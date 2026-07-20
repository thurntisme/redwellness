<?php

// Users table
$pdo->exec("
    CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        avatar_url TEXT,
        calorie_goal INTEGER DEFAULT 2400,
        water_goal REAL DEFAULT 2.5,
        status TEXT DEFAULT 'active' CHECK(status IN ('active', 'inactive', 'suspended')),
        email_verified_at DATETIME,
        verification_token TEXT,
        reset_password_token TEXT,
        reset_password_expires_at DATETIME,
        remember_token TEXT,
        last_login_at DATETIME,
        login_attempts INTEGER DEFAULT 0,
        locked_until DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");

$pdo->exec("CREATE INDEX idx_users_email ON users(email)");
$pdo->exec("CREATE INDEX idx_users_verification_token ON users(verification_token)");
$pdo->exec("CREATE INDEX idx_users_reset_password_token ON users(reset_password_token)");
$pdo->exec("CREATE INDEX idx_users_remember_token ON users(remember_token)");
