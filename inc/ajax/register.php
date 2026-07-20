<?php

/**
 * AJAX Registration Handler
 * Validates input and creates a new user account.
 */

require_once __DIR__ . '/../url.php';
require_once __DIR__ . '/../db.php';

// Ensure JSON response
header('Content-Type: application/json');

// Only accept POST requests
if (!isPost()) {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate fields
$errors = [];

$name = trim($input['name'] ?? '');
if ($name === '') {
    $errors[] = 'Name is required.';
}

$email = trim($input['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email address.';
}

$password = $input['password'] ?? '';
if (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters.';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'An account with this email already exists.']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification token
    $verificationToken = bin2hex(random_bytes(32));

    // Insert user
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, verification_token, created_at, updated_at)
        VALUES (?, ?, ?, ?, datetime('now'), datetime('now'))
    ");
    $stmt->execute([$name, $email, $hashedPassword, $verificationToken]);

    $userId = $pdo->lastInsertId();

    $_SESSION['user_id'] = (int) $userId;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    echo json_encode([
        'success' => true,
        'message' => 'Account created successfully.',
        'redirect' => url('app'),
        'user' => [
            'id' => (int) $userId,
            'name' => $name,
            'email' => $email,
            'avatar_url' => null,
        ],
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
