<?php

// Workout log (completed workouts)
$pdo->exec("
    CREATE TABLE workout_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        workout_id INTEGER,
        exercise_id INTEGER NOT NULL,
        sets_completed INTEGER DEFAULT 0,
        reps_completed INTEGER DEFAULT 0,
        duration_minutes INTEGER,
        logged_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (workout_id) REFERENCES workouts(id) ON DELETE SET NULL,
        FOREIGN KEY (exercise_id) REFERENCES exercises(id)
    )
");
