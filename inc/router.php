<?php

/**
 * Front Controller — Global Router
 *
 * All requests pass through this file.
 * Bootstraps the app and dispatches to the correct page.
 *
 * Usage: php -S localhost:8000 inc/router.php
 */

// ── Bootstrap ──────────────────────────────────────────────────────────
require __DIR__ . '/url.php';
require __DIR__ . '/db.php';
require __DIR__ . '/auth.php';

// ── Routing ────────────────────────────────────────────────────────────
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = $uri;

// Serve existing static files directly
$staticFile = __DIR__ . '/..' . $path;
if ($path !== '/' && file_exists($staticFile) && is_file($staticFile)) {
    return false;
}

// Route to .php file
$page = ltrim($path, '/');
$phpFile = __DIR__ . '/../' . $page . '.php';

// Route AJAX requests to inc/ajax/
if (str_starts_with($page, 'ajax/')) {
    $phpFile = __DIR__ . '/' . $page . '.php';
}

if ($page === '') {
    require __DIR__ . '/../index.php';
} elseif (file_exists($phpFile)) {
    require $phpFile;
} else {
    // 404
    http_response_code(404);
    require __DIR__ . '/../partials/header-landing.php';
    echo '<div class="text-center py-20 px-container-margin">
        <span class="material-symbols-outlined text-[64px] text-primary">error_outline</span>
        <h1 class="font-headline-lg text-headline-lg-mobile mt-sm mb-xs">Page Not Found</h1>
        <p class="text-secondary mb-lg">The page you\'re looking for doesn\'t exist.</p>
        <a href="' . url('/') . '" class="inline-block px-6 py-3 rounded-full bg-primary text-white font-headline-md">Go Home</a>
    </div>';
    require __DIR__ . '/../partials/footer-landing.php';
}
