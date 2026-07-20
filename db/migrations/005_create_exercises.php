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

// Seed from exercises.json
$jsonPath = __DIR__ . '/../../assets/json/exercises.json';
if (file_exists($jsonPath)) {
    $exercises = json_decode(file_get_contents($jsonPath), true);
    if (is_array($exercises)) {
        $stmt = $pdo->prepare("INSERT INTO exercises (name, category, image_url) VALUES (?, ?, NULL)");
        foreach ($exercises as $ex) {
            $stmt->execute([$ex['name'], $ex['category']]);
        }
    }
}
