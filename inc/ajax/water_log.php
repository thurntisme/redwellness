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

// ── GET: fetch today's logs and total ─────────────────────────────
if ($method === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT id, amount, description, logged_at FROM water_logs WHERE user_id = ? AND date(logged_at) = date('now') ORDER BY logged_at DESC");
        $stmt->execute([$userId]);
        $logs = $stmt->fetchAll();

        $totalMl = 0;
        foreach ($logs as &$log) {
            $totalMl += (float) $log['amount'];
            $log['amount'] = (float) $log['amount'];
            $log['id'] = (int) $log['id'];
            $log['time'] = date('h:i A', strtotime($log['logged_at']));
        }

        $goal = $_SESSION['water_goal'] ?? 2.5;

        echo json_encode([
            'success' => true,
            'total_ml' => $totalMl,
            'total_liters' => round($totalMl / 1000, 1),
            'goal_liters' => (float) $goal,
            'logs' => $logs,
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

// ── POST: create a new log ─────────────────────────────────────────
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $amount = (float) ($input['amount'] ?? 0);
    $description = trim($input['description'] ?? '');

    if ($amount <= 0 || $amount > 5000) {
        echo json_encode(['success' => false, 'message' => 'Amount must be between 1 and 5000 ml.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO water_logs (user_id, amount, description, logged_at) VALUES (?, ?, ?, datetime('now'))");
        $stmt->execute([$userId, $amount, $description]);
        $id = $pdo->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => 'Water logged.',
            'log' => [
                'id' => (int) $id,
                'amount' => $amount,
                'description' => $description,
                'time' => date('h:i A'),
            ],
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

// ── DELETE: remove a log ──────────────────────────────────────────
if ($method === 'DELETE') {
    $id = (int) ($_GET['id'] ?? 0);

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Missing log ID.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM water_logs WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);

        if ($stmt->rowCount()) {
            echo json_encode(['success' => true, 'message' => 'Entry deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Entry not found.']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
