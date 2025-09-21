<?php
require_once __DIR__ . '/bootstrap.php';
$u = current_user();
if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {
    http_response_code(403); echo 'Forbidden'; exit;
}
?>
<!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>แดชบอร์ด</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="topbar">
  <div class="brand">แดชบอร์ดสรุปผล</div>
  <nav>
    <a class="btn" href="/index.php">หน้าแบบประเมิน</a>
    <form method="post" action="/logout.php" class="inline"><?=csrf_token_input()?><button class="btn" type="submit">ออกจากระบบ</button></form>
    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">
      <span class="icon" data-icon-sun>☀</span>
      <span class="icon" data-icon-moon hidden>🌙</span>
    </button>
  </nav>
</header>
<main class="container">
  <section class="card">
    <h2 class="card-title">ตัวกรอง</h2>
    <div class="filters">
      <label>ช่วงเวลา เริ่ม <input type="datetime-local" id="from"></label>
      <label>ถึง <input type="datetime-local" id="to"></label>
      <label>ประเภทผู้ตอบ
        <select id="respondent">
          <option value="">ทั้งหมด</option>
          <option value="expert">ผู้ทรงคุณวุฒิ</option>
          <option value="teacher">อาจารย์</option>
          <option value="committee">กรรมการ</option>
          <option value="student">นิสิต/นักศึกษา</option>
          <option value="other">อื่นๆ</option>
        </select>
      </label>
    </div>
    <div class="actions">
      <button id="exportCsv" class="btn">Export CSV</button>
    </div>
  </section>

  <section class="card">
    <h2 class="card-title">สถิติรวม</h2>
    <div class="stats">
      <div><strong>เฉลี่ย:</strong> <span id="avg">-</span></div>
      <div><strong>มัธยฐาน:</strong> <span id="median">-</span></div>
      <div><strong>ส่วนเบี่ยงเบน:</strong> <span id="std">-</span></div>
      <div><strong>จำนวนแบบ:</strong> <span id="count">-</span></div>
    </div>
  </section>

  <section class="card">
    <h2 class="card-title">กราฟ</h2>
    <div class="chart-grid">
      <div class="chart-panel chart-panel-wide">
        <h3 class="chart-title">คะแนนเฉลี่ยต่อข้อ</h3>
        <div class="chart-scroll">
          <canvas id="bar" width="800" height="260"></canvas>
        </div>
      </div>
      <div class="chart-panel">
        <h3 class="chart-title">คะแนนเฉลี่ยตามมิติ</h3>
        <canvas id="radar" width="420" height="260"></canvas>
      </div>
      <div class="chart-panel">
        <h3 class="chart-title">สัดส่วนผู้ตอบ</h3>
        <canvas id="donut" width="320" height="220"></canvas>
      </div>
    </div>
  </section>

  <section class="card">
    <h2 class="card-title">ข้อเสนอแนะ (ล่าสุด)</h2>
    <div id="suggestions" class="list"></div>
  </section>
</main>
<div id="toast" class="toast" hidden></div>
<script src="/assets/js/app.js"></script>
<script>
const qs = (s)=>document.querySelector(s);
const qsa = (s)=>Array.from(document.querySelectorAll(s));
const barCanvas = document.getElementById('bar');
const radarCanvas = document.getElementById('radar');
const donutCanvas = document.getElementById('donut');
const suggestionsBox = document.getElementById('suggestions');
if (suggestionsBox && !suggestionsBox.textContent.trim()) {
  suggestionsBox.textContent = 'กำลังโหลด...';
}

const statsTargets = {
  avg: qs('#avg'),
  median: qs('#median'),
  std: qs('#std'),
  count: qs('#count')
};

const formatStat = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val.toFixed(2) : '-';
const formatCount = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val : '-';
let statsErrorShown = false;
let suggestionsErrorShown = false;

const filters = ()=>({
  from: qs('#from')?.value || '',
  to: qs('#to')?.value || '',
  respondent: qs('#respondent')?.value || ''
});

function applySummary(summary){
  if (statsTargets.avg) statsTargets.avg.textContent = formatStat(summary.avg);
  if (statsTargets.median) statsTargets.median.textContent = formatStat(summary.median);
  if (statsTargets.std) statsTargets.std.textContent = formatStat(summary.stddev);
  if (statsTargets.count) statsTargets.count.textContent = formatCount(summary.count);
}

function resetSummary(){
  Object.values(statsTargets).forEach(el=>{ if (el) el.textContent = '-'; });
}

function chartMessage(ctx, message, width, height){
  ctx.clearRect(0,0,width,height);
  ctx.save();
  ctx.fillStyle = '#94a3b8';
  ctx.font = '14px system-ui';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  ctx.fillText(message, width/2, height/2);
  ctx.restore();
}

async function loadStats(){
  try {
    const f = filters();
    const p = new URLSearchParams(f);
    const res = await fetch('/public/api/dashboard_stats.php?' + p.toString(), { cache: 'no-store' });
    const data = await res.json();
    if (!res.ok || !data.ok) throw new Error(data.error || 'stat error');
    applySummary(data.summary || {});
    drawBar(data.items || []);
    drawRadar(data.dimensions || {});
    drawDonut(data.respondents || {});
    statsErrorShown = false;
  } catch (err) {
    resetSummary();
    drawBar([]);
    drawRadar({});
    drawDonut({});
    if (!statsErrorShown) {
      showToast('โหลดสถิติล้มเหลว','error');
      statsErrorShown = true;
    }
  }
}

function drawDonut(breakdown){
  const canvas = donutCanvas;
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const W = canvas.width;
  const H = canvas.height;
  const entries = Object.entries(breakdown || {}).filter(([,v])=>v>0);
  if (!entries.length){
    chartMessage(ctx,'ไม่มีข้อมูล',W,H);
    return;
  }
  ctx.clearRect(0,0,W,H);
  const total = entries.reduce((sum,[,val])=>sum+val,0);
  const colors = ['#4f46e5','#06b6d4','#10b981','#f59e0b','#ef4444','#a78bfa'];
  let start = -Math.PI/2;
  const radius = Math.min(W,H)/2 - 18;
  entries.forEach(([label,val], idx)=>{
    const angle = (val/total) * Math.PI * 2;
    ctx.beginPath();
    ctx.moveTo(W/2,H/2);
    ctx.fillStyle = colors[idx % colors.length];
    ctx.arc(W/2, H/2, radius, start, start + angle);
    ctx.closePath();
    ctx.fill();
    start += angle;
  });
  ctx.save();
  ctx.font = '12px system-ui';
  ctx.textBaseline = 'middle';
  ctx.textAlign = 'left';
  const legendX = 24;
  let y = Math.max(20, H - entries.length * 18 - 12);
  entries.forEach(([label,val], idx)=>{
    ctx.fillStyle = colors[idx % colors.length];
    ctx.fillRect(legendX, y - 6, 12, 12);
    ctx.fillStyle = '#475569';
    ctx.fillText(`${label || 'unknown'} (${val})`, legendX + 18, y);
    y += 18;
  });
  ctx.restore();
}

function drawBar(items){
  const canvas = barCanvas;
  if (!canvas) return;
  const data = Array.isArray(items) ? items.filter(it=>typeof it.avg === 'number') : [];
  const H = 260;
  const padL = 56;
  const padB = 48;
  const barWidth = 32;
  const gap = 18;
  const defaultWidth = 720;
  const W = data.length ? Math.max(defaultWidth, padL + data.length * (barWidth + gap) + 40) : defaultWidth;
  canvas.width = W;
  canvas.height = H;
  const ctx = canvas.getContext('2d');
  if (!data.length){
    chartMessage(ctx,'ไม่มีข้อมูล',W,H);
    return;
  }
  ctx.clearRect(0,0,W,H);
  const values = data.map(item=>Math.max(0,item.avg));
  const axisMax = Math.max(5, Math.ceil(Math.max(...values) * 1.1));
  const chartHeight = H - padB - 24;
  const scale = chartHeight / axisMax;
  ctx.strokeStyle = '#cbd5e1';
  ctx.beginPath(); ctx.moveTo(padL, 20); ctx.lineTo(padL, H - padB); ctx.stroke();
  ctx.beginPath(); ctx.moveTo(padL, H - padB); ctx.lineTo(W - 20, H - padB); ctx.stroke();
  ctx.font = '12px system-ui';
  ctx.fillStyle = '#64748b';
  ctx.textAlign = 'right';
  const ticks = 5;
  for (let i = 1; i <= ticks; i++){
    const value = (axisMax / ticks) * i;
    const yy = H - padB - value * scale;
    const label = value % 1 === 0 ? value.toString() : value.toFixed(1);
    ctx.fillText(label, padL - 6, yy + 4);
    ctx.strokeStyle = 'rgba(148,163,184,0.25)';
    ctx.beginPath();
    ctx.moveTo(padL + 2, yy);
    ctx.lineTo(W - 20, yy);
    ctx.stroke();
  }
  ctx.textAlign = 'center';
  data.forEach((item, idx)=>{
    const x = padL + idx * (barWidth + gap);
    const height = item.avg * scale;
    const y = H - padB - height;
    ctx.fillStyle = '#4f46e5';
    ctx.fillRect(x, y, barWidth, height);
    ctx.save();
    ctx.translate(x + barWidth / 2, H - padB + 18);
    ctx.rotate(-Math.PI / 4);
    ctx.fillStyle = '#475569';
    ctx.textAlign = 'left';
    ctx.fillText(item.code, 0, 0);
    ctx.restore();
  });
}

function drawRadar(dimensions){
  const canvas = radarCanvas;
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const W = canvas.width;
  const H = canvas.height;
  ctx.clearRect(0,0,W,H);
  const entries = Object.entries(dimensions || {}).filter(([,val])=>Number.isFinite(val));
  const count = entries.length;
  if (!count){
    chartMessage(ctx,'ไม่มีข้อมูล',W,H);
    return;
  }
  const cx = W/2;
  const cy = H/2;
  const radius = Math.min(W,H)/2 - 36;
  ctx.strokeStyle = '#e5e7eb';
  for (let g = 1; g <= 5; g++){
    const rr = (g/5) * radius;
    ctx.beginPath();
    for (let i = 0; i <= count; i++){
      const angle = (Math.PI * 2 * i) / count - Math.PI/2;
      const x = cx + rr * Math.cos(angle);
      const y = cy + rr * Math.sin(angle);
      if (i === 0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
    }
    ctx.stroke();
  }
  const points = entries.map(([label, val], idx)=>{
    const safe = Math.max(0, Math.min(5, val));
    const angle = (Math.PI * 2 * idx) / count - Math.PI / 2;
    const rr = (safe / 5) * radius;
    return { x: cx + rr * Math.cos(angle), y: cy + rr * Math.sin(angle), angle, label };
  });
  ctx.beginPath();
  points.forEach(({x,y}, idx)=>{ if (idx === 0) ctx.moveTo(x,y); else ctx.lineTo(x,y); });
  ctx.closePath();
  ctx.fillStyle = 'rgba(79,70,229,0.2)';
  ctx.strokeStyle = '#4f46e5';
  ctx.fill();
  ctx.stroke();
  ctx.save();
  ctx.fillStyle = '#475569';
  ctx.font = '12px system-ui';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  const labelRadius = radius + 18;
  points.forEach(({angle, label})=>{
    const lx = cx + labelRadius * Math.cos(angle);
    const ly = cy + labelRadius * Math.sin(angle);
    ctx.fillText(label, lx, ly);
  });
  ctx.restore();
}

loadStats();
setInterval(loadStats, 15000);

async function loadSuggestions(){
  if (!suggestionsBox) return;
  suggestionsBox.textContent = 'กำลังโหลด...';
  try{
    const f = filters();
    const p = new URLSearchParams(f);
    const res = await fetch('/api/suggestions.php?' + p.toString(), { cache: 'no-store' });
    const data = await res.json();
    if (!res.ok || !data.ok) throw new Error(data.error || 'suggestion error');
    if (!data.data || data.data.length === 0){
      suggestionsBox.textContent = '— ไม่มีข้อเสนอแนะ —';
      suggestionsErrorShown = false;
      return;
    }
    suggestionsBox.innerHTML = '';
    data.data.slice(0,50).forEach(row=>{
      const div = document.createElement('div');
      div.className = 'list-item';
      const who = row.respondent_type ? `[${row.respondent_type}] ` : '';
      div.textContent = who + (row.suggestion || '');
      suggestionsBox.appendChild(div);
    });
    suggestionsErrorShown = false;
  } catch (err){
    suggestionsBox.textContent = 'โหลดข้อเสนอแนะไม่สำเร็จ';
    if (!suggestionsErrorShown){
      showToast('โหลดข้อเสนอแนะไม่สำเร็จ','error');
      suggestionsErrorShown = true;
    }
  }
}
loadSuggestions();
setInterval(loadSuggestions, 20000);

qsa('#from, #to, #respondent').forEach(el=>{
  el.addEventListener('change', ()=>{
    loadStats();
    loadSuggestions();
  });
});

const exportBtn = document.getElementById('exportCsv');
if (exportBtn){
  exportBtn.addEventListener('click', ()=>{
    const p = new URLSearchParams(filters()).toString();
    window.location = '/api/export_csv.php?' + p;
  });
}
</script>
</body>
</html>
