<?php

// Meal types
$pdo->exec("
    CREATE TABLE meal_types (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE
    )
");

// Default meal types
$mealTypes = ['Breakfast', 'Lunch', 'Dinner', 'Snacks'];
$stmt = $pdo->prepare("INSERT INTO meal_types (name) VALUES (?)");
foreach ($mealTypes as $type) {
    $stmt->execute([$type]);
}
