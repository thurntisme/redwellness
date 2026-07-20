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

if ($method === 'GET') {
    try {
        $logStmt = $pdo->prepare("
            SELECT nl.id, nl.food_name, nl.calories, nl.protein, nl.carbs, nl.fats, nl.logged_at,
                   mt.name AS meal_type
            FROM nutrition_logs nl
            JOIN meal_types mt ON mt.id = nl.meal_type_id
            WHERE nl.user_id = ? AND date(nl.logged_at) = date('now')
            ORDER BY nl.logged_at DESC
        ");
        $logStmt->execute([$userId]);
        $todayLogs = $logStmt->fetchAll();

        $totals = ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0];
        foreach ($todayLogs as $log) {
            $totals['calories'] += (int) $log['calories'];
            $totals['protein']  += (int) $log['protein'];
            $totals['carbs']    += (int) $log['carbs'];
            $totals['fats']     += (int) $log['fats'];
        }

        $goalsStmt = $pdo->prepare("SELECT calorie_goal, protein_goal, carbs_goal, fats_goal, water_goal_ml FROM user_goals WHERE user_id = ?");
        $goalsStmt->execute([$userId]);
        $goals = $goalsStmt->fetch();

        if (!$goals) {
            $ins = $pdo->prepare("INSERT INTO user_goals (user_id) VALUES (?)");
            $ins->execute([$userId]);
            $goals = ['calorie_goal' => 2500, 'protein_goal' => 150, 'carbs_goal' => 250, 'fats_goal' => 65, 'water_goal_ml' => 2500];
        }

        $mtStmt = $pdo->query("SELECT id, name FROM meal_types ORDER BY id");
        $mealTypes = $mtStmt->fetchAll();

        echo json_encode([
            'success' => true,
            'today_logs' => $todayLogs,
            'totals' => $totals,
            'goals' => $goals,
            'meal_types' => $mealTypes,
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';

    try {
        if ($action === 'log') {
            $mealTypeName = $input['meal_type'] ?? '';
            $foodName = trim($input['food_name'] ?? '');
            $calories = (int) ($input['calories'] ?? 0);
            $protein = (int) ($input['protein'] ?? 0);
            $carbs = (int) ($input['carbs'] ?? 0);
            $fats = (int) ($input['fats'] ?? 0);

            if (!$mealTypeName || !$foodName || !$calories) {
                echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
                exit;
            }

            $mtStmt = $pdo->prepare("SELECT id FROM meal_types WHERE name = ?");
            $mtStmt->execute([$mealTypeName]);
            $mealType = $mtStmt->fetch();

            if (!$mealType) {
                echo json_encode(['success' => false, 'message' => 'Invalid meal type.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO nutrition_logs (user_id, meal_type_id, food_name, calories, protein, carbs, fats) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $mealType['id'], $foodName, $calories, $protein, $carbs, $fats]);
            $newId = $pdo->lastInsertId();

            $fetch = $pdo->prepare("
                SELECT nl.id, nl.food_name, nl.calories, nl.protein, nl.carbs, nl.fats, nl.logged_at, mt.name AS meal_type
                FROM nutrition_logs nl JOIN meal_types mt ON mt.id = nl.meal_type_id WHERE nl.id = ?
            ");
            $fetch->execute([$newId]);

            echo json_encode(['success' => true, 'message' => 'Meal logged.', 'log' => $fetch->fetch()]);
            exit;
        }

        if ($action === 'delete') {
            $logId = (int) ($input['log_id'] ?? 0);
            if (!$logId) {
                echo json_encode(['success' => false, 'message' => 'Missing log ID.']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM nutrition_logs WHERE id = ? AND user_id = ?");
            $stmt->execute([$logId, $userId]);

            if ($stmt->rowCount()) {
                echo json_encode(['success' => true, 'message' => 'Meal deleted.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not found.']);
            }
            exit;
        }

        if ($action === 'update_goals') {
            $calorieGoal = (int) ($input['calorie_goal'] ?? 2500);
            $proteinGoal = (int) ($input['protein_goal'] ?? 150);
            $carbsGoal = (int) ($input['carbs_goal'] ?? 250);
            $fatsGoal = (int) ($input['fats_goal'] ?? 65);
            $waterGoalMl = (int) ($input['water_goal_ml'] ?? 2500);

            $stmt = $pdo->prepare("INSERT INTO user_goals (user_id, calorie_goal, protein_goal, carbs_goal, fats_goal, water_goal_ml) VALUES (?, ?, ?, ?, ?, ?) ON CONFLICT(user_id) DO UPDATE SET calorie_goal = excluded.calorie_goal, protein_goal = excluded.protein_goal, carbs_goal = excluded.carbs_goal, fats_goal = excluded.fats_goal, water_goal_ml = excluded.water_goal_ml");
            $stmt->execute([$userId, $calorieGoal, $proteinGoal, $carbsGoal, $fatsGoal, $waterGoalMl]);

            $_SESSION['calorie_goal'] = $calorieGoal;
            $_SESSION['water_goal_ml'] = $waterGoalMl;

            echo json_encode(['success' => true, 'message' => 'Goals updated.']);
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
