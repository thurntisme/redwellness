<?php

$pdo->exec("
    CREATE TABLE user_nutrition_goals (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL UNIQUE,
        calorie_goal INTEGER DEFAULT 2500,
        protein_goal INTEGER DEFAULT 150,
        carbs_goal INTEGER DEFAULT 250,
        fats_goal INTEGER DEFAULT 65,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");
