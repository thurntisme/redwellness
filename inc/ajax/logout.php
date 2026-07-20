<?php

require_once __DIR__ . '/../url.php';

header('Content-Type: application/json');

$_SESSION = [];
session_destroy();

echo json_encode(['success' => true]);
