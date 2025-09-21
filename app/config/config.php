<?php
// Polyfill for PHP < 8.0
if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) {
    if (!is_string($haystack) || !is_string($needle)) return false;
    return $needle === '' || strpos($haystack, $needle) !== false;
  }
}

// Database config and PDO setup
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'questionn1_survey_system';
$DB_USER = getenv('DB_USER') ?: 'questionn1_survey_system';
$DB_PASS = getenv('DB_PASS') ?: 'Boss.1212';
$DB_CHARSET = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (Throwable $e) {
    http_response_code(500);
    $accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
    if ($accept && strpos($accept, 'application/json') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'error'=>'Database connection failed','detail'=>$e->getMessage()]);
    } else {
        echo 'Database connection failed.';
    }
    exit;
}

// App settings
session_name('survey_app');
session_start();

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_token_input(): string {
    $t = htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $t . '">';
}

function same_origin_ok(): bool {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    if ($origin) {
        $oh = parse_url($origin, PHP_URL_HOST);
        return $oh && strcasecmp($oh, $host) === 0;
    }
    if ($referer) {
        $rh = parse_url($referer, PHP_URL_HOST);
        return $rh && strcasecmp($rh, $host) === 0;
    }
    return false;
}

function verify_csrf_or_fail(): void {
    $sent = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    $current = $_SESSION['csrf_token'] ?? '';
    if ($sent && $current && hash_equals($current, $sent)) return; // strict match OK

    // Soft fallback: allow same-origin POST when token is missing (helps some shared-host setups)
    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && same_origin_ok()) return;

    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Invalid CSRF']);
    exit;
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function current_user() { return $_SESSION['user'] ?? null; }
function require_role(array $roles) {
    $u = current_user();
    if (!$u || !in_array($u['role'], $roles, true)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}

function audit_log(PDO $pdo, ?int $userId, string $action, string $details = ''): void {
    $stmt = $pdo->prepare('INSERT INTO audit_logs (user_id, action, details) VALUES (?,?,?)');
    $stmt->execute([$userId, $action, $details]);
}
