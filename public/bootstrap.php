<?php
// Locate and load the app config regardless of docroot layout
$paths = [
    __DIR__ . '/../app', // typical: project_root/public with app as sibling
    __DIR__ . '/app',    // fallback: app inside docroot/public
];
$base = null;
foreach ($paths as $p) { if (is_dir($p)) { $base = $p; break; } }
if (!$base) {
    http_response_code(500);
    echo 'App folder not found. Ensure "app/" exists.';
    exit;
}

// Load config and auth
$config = $base . '/config/config.php';
if (!is_file($config)) { http_response_code(500); echo 'Config not found.'; exit; }
require_once $config;

$auth = $base . '/lib/auth.php';
if (is_file($auth)) { require_once $auth; }
