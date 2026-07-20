<?php

$pdo->exec("
    CREATE TABLE user_goals (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL UNIQUE,
        calorie_goal INTEGER DEFAULT 2500,
        protein_goal INTEGER DEFAULT 150,
        carbs_goal INTEGER DEFAULT 250,
        fats_goal INTEGER DEFAULT 65,
        water_goal_ml INTEGER DEFAULT 2500,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");

// Migrate existing data from user_nutrition_goals
$pdo->exec("
    INSERT OR IGNORE INTO user_goals (user_id, calorie_goal, protein_goal, carbs_goal, fats_goal, water_goal_ml)
    SELECT ung.user_id, ung.calorie_goal, ung.protein_goal, ung.carbs_goal, ung.fats_goal,
           COALESCE((SELECT CAST(water_goal * 1000 AS INTEGER) FROM users WHERE id = ung.user_id), 2500)
    FROM user_nutrition_goals ung
");

// Seed goals for users without them
$pdo->exec("
    INSERT OR IGNORE INTO user_goals (user_id, water_goal_ml)
    SELECT id, CAST(water_goal * 1000 AS INTEGER) FROM users WHERE id NOT IN (SELECT user_id FROM user_goals)
");
