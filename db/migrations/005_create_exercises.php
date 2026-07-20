<?php

// Exercises
$pdo->exec("
    CREATE TABLE exercises (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        category TEXT,
        image_url TEXT
    )
");

// Default exercises
$exercises = [
    ['Push-ups', 'Bodyweight'],
    ['Squats', 'Bodyweight'],
    ['Lunges', 'Bodyweight'],
    ['Plank', 'Core'],
    ['Burpees', 'Cardio'],
    ['Mountain Climbers', 'Cardio'],
    ['Bench Press', 'Weight'],
    ['Deadlift', 'Weight'],
    ['Pull-ups', 'Bodyweight'],
    ['Bicep Curls', 'Weight'],
];

$stmt = $pdo->prepare("INSERT INTO exercises (name, category, image_url) VALUES (?, ?, NULL)");
foreach ($exercises as [$name, $category]) {
    $stmt->execute([$name, $category]);
}
