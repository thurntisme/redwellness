<?php

require_once __DIR__ . '/../url.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$userId = $_SESSION['user_id'] ?? 0;

if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
    exit;
}

$dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// ── GET ──────────────────────────────────────────────────────────
if ($method === 'GET') {
    try {
        $todayDow = (int) date('w');

        $exStmt = $pdo->prepare("SELECT id, name, category FROM exercises ORDER BY category, name");
        $exStmt->execute();
        $exercises = $exStmt->fetchAll();

        $planStmt = $pdo->prepare("
            SELECT w.id, w.day_of_week, w.exercise_id, w.sets, w.reps, w.is_morning_routine,
                   e.name, e.category
            FROM workouts w
            JOIN exercises e ON e.id = w.exercise_id
            WHERE w.user_id = ? AND w.is_morning_routine = 0
            ORDER BY w.id
        ");
        $planStmt->execute([$userId]);
        $plan = $planStmt->fetchAll();

        $logStmt = $pdo->prepare("
            SELECT wl.id, wl.workout_id, wl.exercise_id, wl.sets_completed, wl.reps_completed,
                   wl.duration_minutes, wl.logged_at
            FROM workout_logs wl
            WHERE wl.user_id = ? AND date(wl.logged_at) = date('now')
        ");
        $logStmt->execute([$userId]);
        $todayLogs = $logStmt->fetchAll();

        $loggedExerciseIds = array_map(fn($l) => (int) $l['exercise_id'], $todayLogs);

        $morningStmt = $pdo->prepare("
            SELECT w.id, w.exercise_id, e.name, e.category
            FROM workouts w JOIN exercises e ON e.id = w.exercise_id
            WHERE w.user_id = ? AND w.is_morning_routine = 1
        ");
        $morningStmt->execute([$userId]);
        $morningRoutine = $morningStmt->fetchAll();

        echo json_encode([
            'success' => true,
            'exercises' => $exercises,
            'plan' => $plan,
            'today_logs' => $todayLogs,
            'logged_exercise_ids' => $loggedExerciseIds,
            'today_dow' => $todayDow,
            'today_day' => $dayNames[$todayDow],
            'morning_routine' => $morningRoutine,
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

// ── POST ─────────────────────────────────────────────────────────
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';

    try {
        if ($action === 'add_to_plan') {
            $day = $input['day_of_week'] ?? '';
            $exerciseId = (int) ($input['exercise_id'] ?? 0);

            if (!in_array($day, $dayNames) || !$exerciseId) {
                echo json_encode(['success' => false, 'message' => 'Invalid day or exercise.']);
                exit;
            }

            $sets = (int) ($input['sets'] ?? 3);
            $reps = (int) ($input['reps'] ?? 10);

            $check = $pdo->prepare("SELECT id FROM workouts WHERE user_id = ? AND day_of_week = ? AND exercise_id = ? AND is_morning_routine = 0");
            $check->execute([$userId, $day, $exerciseId]);
            if ($check->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Exercise already added to this day.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO workouts (user_id, day_of_week, exercise_id, sets, reps) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $day, $exerciseId, $sets, $reps]);
            $newId = $pdo->lastInsertId();

            $fetch = $pdo->prepare("
                SELECT w.id, w.day_of_week, w.exercise_id, w.sets, w.reps, e.name, e.category
                FROM workouts w JOIN exercises e ON e.id = w.exercise_id
                WHERE w.id = ?
            ");
            $fetch->execute([$newId]);

            echo json_encode(['success' => true, 'message' => 'Exercise added.', 'plan' => $fetch->fetch()]);
            exit;
        }

        if ($action === 'log') {
            $exerciseId = (int) ($input['exercise_id'] ?? 0);
            $workoutId = !empty($input['workout_id']) ? (int) $input['workout_id'] : null;
            $setsCompleted = (int) ($input['sets_completed'] ?? 0);
            $repsCompleted = (int) ($input['reps_completed'] ?? 0);
            $duration = (int) ($input['duration_minutes'] ?? 0);

            if (!$exerciseId) {
                echo json_encode(['success' => false, 'message' => 'Missing exercise.']);
                exit;
            }

            $check = $pdo->prepare("SELECT id FROM workout_logs WHERE user_id = ? AND exercise_id = ? AND date(logged_at) = date('now')");
            $check->execute([$userId, $exerciseId]);
            $existing = $check->fetch();

            if ($existing) {
                echo json_encode(['success' => false, 'message' => 'Already logged today.', 'log_id' => $existing['id']]);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO workout_logs (user_id, workout_id, exercise_id, sets_completed, reps_completed, duration_minutes, logged_at) VALUES (?, ?, ?, ?, ?, ?, datetime('now'))");
            $stmt->execute([$userId, $workoutId, $exerciseId, $setsCompleted, $repsCompleted, $duration]);

            echo json_encode(['success' => true, 'message' => 'Workout logged.', 'log_id' => $pdo->lastInsertId()]);
            exit;
        }

        if ($action === 'remove_from_plan') {
            $planId = (int) ($input['plan_id'] ?? 0);
            if (!$planId) {
                echo json_encode(['success' => false, 'message' => 'Missing plan ID.']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM workouts WHERE id = ? AND user_id = ?");
            $stmt->execute([$planId, $userId]);

            if ($stmt->rowCount()) {
                echo json_encode(['success' => true, 'message' => 'Removed from plan.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not found.']);
            }
            exit;
        }

        if ($action === 'add_morning') {
            $exerciseId = (int) ($input['exercise_id'] ?? 0);
            if (!$exerciseId) {
                echo json_encode(['success' => false, 'message' => 'Missing exercise.']);
                exit;
            }

            $check = $pdo->prepare("SELECT id FROM workouts WHERE user_id = ? AND exercise_id = ? AND is_morning_routine = 1");
            $check->execute([$userId, $exerciseId]);
            if ($check->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Already in morning routine.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO workouts (user_id, day_of_week, exercise_id, is_morning_routine) VALUES (?, 'daily', ?, 1)");
            $stmt->execute([$userId, $exerciseId]);
            $newId = $pdo->lastInsertId();

            $fetch = $pdo->prepare("SELECT w.id, w.exercise_id, e.name, e.category FROM workouts w JOIN exercises e ON e.id = w.exercise_id WHERE w.id = ?");
            $fetch->execute([$newId]);

            echo json_encode(['success' => true, 'message' => 'Added to morning routine.', 'item' => $fetch->fetch()]);
            exit;
        }

        if ($action === 'remove_morning') {
            $itemId = (int) ($input['item_id'] ?? 0);
            if (!$itemId) {
                echo json_encode(['success' => false, 'message' => 'Missing item ID.']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM workouts WHERE id = ? AND user_id = ? AND is_morning_routine = 1");
            $stmt->execute([$itemId, $userId]);

            if ($stmt->rowCount()) {
                echo json_encode(['success' => true, 'message' => 'Removed from morning routine.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not found.']);
            }
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
