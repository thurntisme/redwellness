<?php

// Nutrition logs
$pdo->exec("
    CREATE TABLE nutrition_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        meal_type_id INTEGER NOT NULL,
        food_name TEXT NOT NULL,
        calories INTEGER DEFAULT 0,
        protein REAL DEFAULT 0,
        carbs REAL DEFAULT 0,
        fats REAL DEFAULT 0,
        logged_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (meal_type_id) REFERENCES meal_types(id)
    )
");
