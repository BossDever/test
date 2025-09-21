<?php
require_once __DIR__ . '/bootstrap.php';

// Allow first-time seed if no users exist; otherwise require admin
$hasUsers = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0;
if ($hasUsers) {
  $u = current_user();
  if (!$u || $u['role'] !== 'admin') { http_response_code(403); echo 'Forbidden'; exit; }
}

require_once __DIR__ . '/../app/seed/seed.php';
echo '<br><a href="/">กลับไปหน้าแรก</a> | <a href="/dashboard.php">แดชบอร์ด</a>';
