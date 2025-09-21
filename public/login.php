<?php
require_once __DIR__ . '/bootstrap.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_fail();
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    if ($u && $p && login($pdo, $u, $p)) {
        header('Location: /index.php');
        exit;
    } else {
        $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    }
}
?><!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เข้าสู่ระบบ</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
  <main class="container" style="max-width:480px;">
    <article class="card">
      <h1 class="card-title">เข้าสู่ระบบ</h1>
      <?php if ($error): ?><div class="alert error"><?=h($error)?></div><?php endif; ?>
      <form method="post">
        <?=csrf_token_input()?>
        <div class="field"><label>ชื่อผู้ใช้</label><input type="text" name="username" required></div>
        <div class="field"><label>รหัสผ่าน</label><input type="password" name="password" required></div>
        <button class="btn" type="submit">เข้าสู่ระบบ</button>
      </form>
    </article>
  </main>
  <script src="/assets/js/app.js"></script>
</body>
</html>
