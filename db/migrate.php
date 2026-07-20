<?php

/**
 * Database Migration Runner
 * 
 * Usage:
 *   php db/migrate.php              - Run all pending migrations
 *   php db/migrate.php --status     - Show migration status
 *   php db/migrate.php --fresh      - Drop all tables and re-run migrations
 */

require __DIR__ . '/../inc/db.php';

$migrationsDir = __DIR__ . '/migrations';

// Create migrations table if not exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        filename TEXT NOT NULL UNIQUE,
        applied_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");

// Get list of applied migrations
$stmt = $pdo->query("SELECT filename FROM migrations ORDER BY id");
$applied = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Get list of migration files
$migrationFiles = [];
if (is_dir($migrationsDir)) {
    $files = glob($migrationsDir . '/*.php');
    foreach ($files as $file) {
        $migrationFiles[] = basename($file);
    }
    sort($migrationFiles);
}

// Handle --status flag
if (isset($argv[1]) && $argv[1] === '--status') {
    echo "Migration Status:\n";
    echo "================\n";
    foreach ($migrationFiles as $file) {
        $status = in_array($file, $applied) ? '[APPLIED]' : '[PENDING]';
        echo "$status $file\n";
    }
    exit(0);
}

// Handle --fresh flag
if (isset($argv[1]) && $argv[1] === '--fresh') {
    echo "Dropping all tables...\n";
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS $table");
        echo "  Dropped: $table\n";
    }
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            filename TEXT NOT NULL UNIQUE,
            applied_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "All tables dropped.\n\n";
}

// Run pending migrations
$pending = array_diff($migrationFiles, $applied);
if (empty($pending)) {
    echo "No pending migrations.\n";
    exit(0);
}

echo "Running migrations...\n";
foreach ($pending as $file) {
    echo "  Applying: $file ... ";
    
    try {
        require $migrationsDir . '/' . $file;
        $stmt = $pdo->prepare("INSERT INTO migrations (filename) VALUES (?)");
        $stmt->execute([$file]);
        echo "OK\n";
    } catch (Exception $e) {
        echo "FAILED\n";
        echo "  Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All migrations applied successfully.\n";
