<?php

// Weekly workout plan
$pdo->exec("
    CREATE TABLE workouts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        day_of_week TEXT NOT NULL DEFAULT 'daily',
        exercise_id INTEGER NOT NULL,
        sets INTEGER DEFAULT 3,
        reps INTEGER DEFAULT 10,
        is_morning_routine INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (exercise_id) REFERENCES exercises(id)
    )
");
