<?php
require_once __DIR__ . '/bootstrap.php';

// get active survey
$stmt = $pdo->query('SELECT * FROM surveys WHERE is_active = 1 ORDER BY id DESC LIMIT 1');
$survey = $stmt->fetch();
if (!$survey) {
    echo '<!doctype html><meta charset="utf-8"><title>Survey</title><p>No active survey.</p>';
    exit;
}

// fetch sections & questions
$sectionsStmt = $pdo->prepare('SELECT * FROM sections WHERE survey_id = ? ORDER BY sort_order, id');
$sectionsStmt->execute([$survey['id']]);
$sections = $sectionsStmt->fetchAll();

$qStmt = $pdo->prepare('SELECT * FROM questions WHERE survey_id = ? ORDER BY sort_order, id');
$qStmt->execute([$survey['id']]);
$questionsBySection = [];
foreach ($qStmt as $q) {
    $questionsBySection[$q['section_id']][] = $q;
}

$user = current_user();
?>
<!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=h($survey['title'])?></title>
  <link rel="stylesheet" href="/assets/css/styles.css">
  <script>
    // Early toast shim to avoid race conditions
    window.showToast = window.showToast || function(msg, type){
      try {
        var t = document.getElementById('toast');
        if (t){
          t.textContent = msg;
          t.className = 'toast show ' + (type||'');
          t.hidden = false;
          setTimeout(function(){ t.classList.remove('show'); t.hidden = true; }, 2500);
        } else {
          alert(msg);
        }
      } catch (_) { alert(msg); }
    };

    // Intercept global AnimationManager to wrap createRipple safely regardless of load order
    (function(){
      var _amStore = (typeof window.AnimationManager !== 'undefined') ? window.AnimationManager : undefined;
      function patch(obj){
        if (!obj || typeof obj.createRipple !== 'function' || obj.__ripplePatched) return obj;
        var orig = obj.createRipple;
        obj.createRipple = function(){
          try {
            var target = null, ev = null, a0 = arguments[0], a1 = arguments[1];
            if (a0 && a0.target) {
              ev = a0;
              target = ev.target && ev.target.closest ? ev.target.closest('button, .btn, [data-ripple]') : null;
            } else {
              target = a0;
              ev = (a1 && a1.target) ? a1 : null;
              if (target && target.closest && !(target.matches && (target.matches('button, .btn, [data-ripple]')))) {
                target = target.closest('button, .btn, [data-ripple]');
              }
            }
            if (!target || typeof target.getBoundingClientRect !== 'function') return;
            return orig.apply(this, [target, ev]);
          } catch (e) { return; }
        };
        obj.__ripplePatched = true;
        return obj;
      }
      try {
        Object.defineProperty(window, 'AnimationManager', {
          configurable: true,
          enumerable: true,
          get: function(){ return _amStore; },
          set: function(v){ _amStore = patch(v); }
        });
        // If already present before defineProperty, ensure patched
        if (_amStore) { _amStore = patch(_amStore); }
      } catch (e) {
        // Fallback: try to patch later
        window.addEventListener('DOMContentLoaded', function(){ if (window.AnimationManager) patch(window.AnimationManager); }, { once: true });
        setTimeout(function(){ if (window.AnimationManager) patch(window.AnimationManager); }, 0);
      }
    })();
  </script>
</head>
<body>
<header class="topbar">
  <div class="brand text-wiggle">แบบประเมินความพึงพอใจ</div>
  <nav>
    <?php if ($user): ?>
      <span class="user"><?=h($user['display_name'])?> (<?=h($user['role'])?>)</span>
  <a href="/dashboard.php" class="btn">แดชบอร์ด</a>
  <form method="post" action="/logout.php" class="inline"><?=csrf_token_input()?><button class="btn" type="submit">ออกจากระบบ</button></form>
    <?php else: ?>
  <a class="btn" href="/login.php">เข้าสู่ระบบ</a>
    <?php endif; ?>
    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">
      <span class="icon" data-icon-sun>☀</span>
      <span class="icon" data-icon-moon hidden>🌙</span>
    </button>
  </nav>
</header>

<main class="container">
  <article class="card">
    <h1 class="card-title"><?=h($survey['title'])?></h1>
    <?php if (!empty($survey['description'])): ?><p><?=nl2br(h($survey['description']))?></p><?php endif; ?>

    <form id="surveyForm" class="survey-form">
      <div id="submitAlert" class="alert success" style="display:none">ส่งแบบประเมินสำเร็จ ขอบคุณค่ะ/ครับ</div>
      <?=csrf_token_input()?>
      <input type="hidden" name="survey_id" value="<?= (int)$survey['id'] ?>">

      <div class="field">
        <label>ประเภทผู้ตอบ</label>
        <select name="respondent_type" required>
          <option value="expert">ผู้ทรงคุณวุฒิ</option>
          <option value="teacher">อาจารย์</option>
          <option value="committee">กรรมการ</option>
          <option value="student">นิสิต/นักศึกษา</option>
          <option value="other">อื่นๆ</option>
        </select>
        <input type="text" name="respondent_other" placeholder="ระบุ (ถ้าเลือกอื่นๆ)" />
      </div>

      <?php foreach ($sections as $sec): ?>
        <section class="section">
          <h2 class="section-title text-wiggle"><?=h($sec['code'] . ' ' . $sec['title'])?></h2>
          <div class="section-body">
          <?php foreach ($questionsBySection[$sec['id']] ?? [] as $q): ?>
            <div class="question">
              <label><?=h($q['item_code'] . ' ' . $q['q_text'])?></label>
              <?php if ($q['q_type'] === 'likert'): ?>
                <div class="likert">
                  <?php for ($i=1; $i<=5; $i++): ?>
                    <label><input type="radio" name="q_<?= (int)$q['id'] ?>" value="<?= $i ?>" <?= $q['is_required'] ? 'required' : '' ?>> <span><?= $i ?></span></label>
                  <?php endfor; ?>
                </div>
              <?php elseif ($q['q_type'] === 'text'): ?>
                <textarea name="q_<?= (int)$q['id'] ?>" rows="2" <?= $q['is_required'] ? 'required' : '' ?>></textarea>
              <?php else: ?>
                <label class="switch"><input type="checkbox" name="q_<?= (int)$q['id'] ?>" value="1"><span class="slider"></span></label>
              <?php endif; ?>
              <?php if ($q['has_detail']): ?>
                <input type="text" name="q_<?= (int)$q['id'] ?>_detail" placeholder="รายละเอียดเพิ่มเติม">
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>

      <div class="field">
        <label>ข้อเสนอแนะเพิ่มเติม</label>
        <textarea name="suggestion" rows="3" placeholder="เสนอแนะเพิ่มเติม"></textarea>
      </div>

      <button class="btn pulse" type="submit">ส่งแบบประเมิน</button>
    </form>
  </article>
</main>

<div id="toast" class="toast" hidden></div>

<script src="/assets/js/app.js"></script>
<script>
const form = document.getElementById('surveyForm');
const submitAlert = document.getElementById('submitAlert');
const submitBtn = form.querySelector('button[type="submit"]');
form.addEventListener('submit', async (e)=>{
  e.preventDefault();
  submitBtn.disabled = true;
  const oldText = submitBtn.textContent;
  submitBtn.textContent = 'กำลังส่ง...';
  try {
    const fd = new FormData(form);
    // timeout helper
    const controller = new AbortController();
    const t = setTimeout(()=>controller.abort(), 10000);
    const res = await fetch('/api/submit_response.php', {
      method: 'POST',
      headers: { 'X-CSRF-Token': fd.get('csrf_token') },
      body: fd,
      signal: controller.signal
    }).finally(()=>clearTimeout(t));

    let data = null;
    const ct = res.headers.get('content-type') || '';
    if (ct.includes('application/json')) {
      data = await res.json().catch(()=>null);
    }

    if (res.ok && (!data || data.ok)) {
      // redirect to success page
      window.location.href = '/submitted.php';
      return;
    } else {
      const msg = (data && data.error) ? data.error : ('HTTP ' + res.status);
      showToast('ผิดพลาด: ' + msg, 'error');
    }
  } catch (err) {
    const msg = (err && err.name === 'AbortError') ? 'ขาดการเชื่อมต่อ (timeout)' : 'ผิดพลาดระหว่างส่งข้อมูล';
    showToast(msg, 'error');
  } finally {
    submitBtn.textContent = oldText;
    submitBtn.disabled = false;
  }
});
</script>
</body>
</html>
