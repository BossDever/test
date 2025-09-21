<?php
require_once __DIR__ . '/../config/config.php';

function login(PDO $pdo, string $username, string $password): bool {
    $stmt = $pdo->prepare('SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if (!$user) return false;
    if (!password_verify($password, $user['password_hash'])) return false;

    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'display_name' => $user['display_name'] ?? $user['username'],
        'role' => $user['role_name'] ?? 'expert',
        'role_id' => (int)$user['role_id'],
    ];
    audit_log($pdo, (int)$user['id'], 'login', 'User logged in');
    return true;
}

function logout(PDO $pdo): void {
    $uid = current_user()['id'] ?? null;
    if ($uid) audit_log($pdo, (int)$uid, 'logout', 'User logged out');
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'], $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
