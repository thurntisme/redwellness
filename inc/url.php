<?php

/**
 * URL Helper Functions
 */

// Base URL detection
function baseUrl(): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $protocol . '://' . $host . $path;
}

// Generate URL from page name (removes .php)
function url(string $page): string {
    $page = ltrim($page, '/');
    $page = str_replace('.php', '', $page);
    return baseUrl() . '/' . $page;
}

// Get current page name without extension
function currentPage(): string {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page;
}

// Check if current page matches
function isPage(string $page): bool {
    return currentPage() === $page;
}

// Redirect to page
function redirect(string $page): void {
    header('Location: ' . url($page));
    exit;
}

// Get request URI path
function requestPath(): string {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH);
    return rtrim($path, '/');
}

// Check if request is AJAX
function isAjax(): bool {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// Get HTTP method
function method(): string {
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

// Check if request method is GET
function isGet(): bool {
    return method() === 'GET';
}

// Check if request method is POST
function isPost(): bool {
    return method() === 'POST';
}

// Get input from GET or POST
function input(string $key, $default = null) {
    if (isPost()) {
        return $_POST[$key] ?? $default;
    }
    return $_GET[$key] ?? $default;
}

// Sanitize input
function sanitize(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// Flash messages (session-based)
function flash(string $type, string $message): void {
    $_SESSION['flash'][$type] = $message;
}

function getFlash(string $type): ?string {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
