<?php
require_once __DIR__ . '/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  verify_csrf_or_fail();
  logout($pdo);
}
header('Location: /index.php');
