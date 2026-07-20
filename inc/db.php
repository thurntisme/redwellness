<?php

// Database Configuration (SQLite)
define('DB_PATH', __DIR__ . '/../data/redwellness.db');

// Ensure data directory exists
$dataDir = dirname(DB_PATH);
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Database Connection via PDO
try {
    $dsn = "sqlite:" . DB_PATH;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, null, null, $options);

    // Enable WAL mode for better performance
    $pdo->exec('PRAGMA journal_mode=WAL');
    $pdo->exec('PRAGMA foreign_keys=ON');
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
