<?php
require_once __DIR__ . '/bootstrap.php';
?><!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ส่งแบบฟอร์มสำเร็จ</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="topbar">
  <div class="brand">ส่งแบบฟอร์มสำเร็จ</div>
  <nav>
    <a class="btn" href="/index.php">กลับไปหน้าแบบประเมิน</a>
    <?php if (current_user()): ?>
    <a class="btn" href="/dashboard.php">แดชบอร์ด</a>
    <?php endif; ?>
    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">
      <span class="icon" data-icon-sun>☀</span>
      <span class="icon" data-icon-moon hidden>🌙</span>
    </button>
  </nav>
</header>
<main class="container">
  <article class="card" style="max-width:680px;margin:0 auto;">
    <h1 class="card-title">ขอบคุณสำหรับการตอบแบบประเมิน</h1>
    <p>เราได้รับคำตอบของคุณเรียบร้อยแล้ว ขอบคุณค่ะ/ครับ</p>
    <div class="actions" style="margin-top:16px;display:flex;gap:8px;flex-wrap:wrap;">
      <a class="btn" href="/index.php">ทำแบบประเมินอีกครั้ง</a>
      <?php if (current_user()): ?>
      <a class="btn" href="/dashboard.php">ดูผลสรุป</a>
      <?php endif; ?>
    </div>
  </article>
</main>
<div id="toast" class="toast" hidden></div>
<script src="/assets/js/app.js"></script>
</body>
</html>
