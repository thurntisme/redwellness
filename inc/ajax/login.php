<?php

/**
 * AJAX Login Handler
 * Validates credentials and authenticates user.
 */

require_once __DIR__ . '/../url.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

if (!isPost()) {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Validate
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

if ($password === '') {
    echo json_encode(['success' => false, 'message' => 'Password is required.']);
    exit;
}

try {
    // Look up user
    $stmt = $pdo->prepare("SELECT id, name, email, password, status, login_attempts, locked_until, avatar_url FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        exit;
    }

    // Check if account is locked
    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
        echo json_encode(['success' => false, 'message' => 'Account is temporarily locked. Try again later.']);
        exit;
    }

    // Check if account is active
    if ($user['status'] !== 'active') {
        echo json_encode(['success' => false, 'message' => 'Account is inactive or suspended.']);
        exit;
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        $attempts = $user['login_attempts'] + 1;
        if ($attempts >= 5) {
            $pdo->prepare("UPDATE users SET login_attempts = ?, locked_until = datetime('now', '+15 minutes') WHERE id = ?")
                ->execute([$attempts, $user['id']]);
            echo json_encode(['success' => false, 'message' => 'Too many attempts. Account locked for 15 minutes.']);
        } else {
            $pdo->prepare("UPDATE users SET login_attempts = ? WHERE id = ?")
                ->execute([$attempts, $user['id']]);
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
        exit;
    }

    // Success — reset attempts, update last login
    $pdo->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL, last_login_at = datetime('now') WHERE id = ?")
        ->execute([$user['id']]);

    // Store user in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];

    // Load goals
    $gStmt = $pdo->prepare("SELECT calorie_goal, water_goal_ml FROM user_goals WHERE user_id = ?");
    $gStmt->execute([$user['id']]);
    $goals = $gStmt->fetch();
    if ($goals) {
        $_SESSION['calorie_goal'] = (int) $goals['calorie_goal'];
        $_SESSION['water_goal_ml'] = (int) $goals['water_goal_ml'];
    } else {
        $_SESSION['calorie_goal'] = 2500;
        $_SESSION['water_goal_ml'] = 2500;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Login successful.',
        'redirect' => url('app'),
        'user' => [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar_url' => $user['avatar_url'],
        ],
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
