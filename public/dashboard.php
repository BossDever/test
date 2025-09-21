<?php<?php<?php

require_once __DIR__ . '/bootstrap.php';

$u = current_user();require_once __DIR__ . '/bootstrap.php';require_once __DIR__ . '/bootstrap.php';

if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {

    http_response_code(403); echo 'Forbidden'; exit;$u = current_user();$u = current_user();

}

?>if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {

<!doctype html>

<html lang="th" class="theme-light">    http_response_code(403); echo 'Forbidden'; exit;    http_response_code(403); echo 'Forbidden'; exit;

<head>

  <meta charset="utf-8">}}

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>📊 แดชบอร์ดสรุปผล</title>?>?>

  <link rel="stylesheet" href="/assets/css/dashboard.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script><!doctype html><!doctype html>

</head>

<body><html lang="th" class="theme-light"><html lang="th" class="theme-light">

<header class="modern-header">

  <div class="container"><head><head>

    <div class="header-content">

      <div class="brand">  <meta charset="utf-8">  <meta charset="utf-8">

        <span class="brand-icon">📊</span>

        <h1>แดชบอร์ดสรุปผล</h1>  <meta name="viewport" content="width=device-width, initial-scale=1">  <meta name="viewport" content="width=device-width, initial-scale=1">

      </div>

      <nav class="header-nav">  <title>📊 แดชบอร์ดสรุปผล</title>  <title>แดชบอร์ด</title>

        <a class="nav-btn" href="/index.php">

          <span>📝</span> หน้าแบบประเมิน  <link rel="stylesheet" href="/assets/css/styles.css">  <link rel="stylesheet" href="/assets/css/styles.css">

        </a>

        <form method="post" action="/logout.php" class="inline">  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head>

          <?=csrf_token_input()?>

          <button class="nav-btn logout" type="submit">  <link rel="preconnect" href="https://fonts.googleapis.com"><body>

            <span>🚪</span> ออกจากระบบ

          </button>  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><header class="topbar">

        </form>

        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">  <div class="brand">แดชบอร์ดสรุปผล</div>

          <span class="icon" data-icon-sun>☀️</span>

          <span class="icon" data-icon-moon hidden">🌙</span></head>  <nav>

        </button>

      </nav><body>    <a class="btn" href="/index.php">หน้าแบบประเมิน</a>

    </div>

  </div><header class="modern-header">    <form method="post" action="/logout.php" class="inline"><?=csrf_token_input()?><button class="btn" type="submit">ออกจากระบบ</button></form>

</header>

  <div class="container">    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">

<main class="main-content">

  <div class="container">    <div class="header-content">      <span class="icon" data-icon-sun>☀</span>

    <!-- คำอธิบายและตัวกรอง -->

    <section class="intro-section">      <div class="brand">      <span class="icon" data-icon-moon hidden>🌙</span>

      <div class="intro-card">

        <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>        <span class="brand-icon">📊</span>    </button>

        <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>

      </div>        <h1>แดชบอร์ดสรุปผล</h1>  </nav>

      

      <div class="filters-card">      </div></header>

        <h3>🔍 ตัวกรองข้อมูล</h3>

        <div class="filters-grid">      <nav class="header-nav"><main class="container">

          <div class="filter-group">

            <label>📅 ช่วงเวลา เริ่ม</label>        <a class="nav-btn" href="/index.php">  <section class="card">

            <input type="datetime-local" id="from" class="modern-input">

          </div>          <span>📝</span> หน้าแบบประเมิน    <h2 class="card-title">ตัวกรอง</h2>

          <div class="filter-group">

            <label>📅 ถึง</label>        </a>    <div class="filters">

            <input type="datetime-local" id="to" class="modern-input">

          </div>        <form method="post" action="/logout.php" class="inline">      <label>ช่วงเวลา เริ่ม <input type="datetime-local" id="from"></label>

          <div class="filter-group">

            <label>👥 ประเภทผู้ตอบ</label>          <?=csrf_token_input()?>      <label>ถึง <input type="datetime-local" id="to"></label>

            <select id="respondent" class="modern-select">

              <option value="">ทั้งหมด</option>          <button class="nav-btn logout" type="submit">      <label>ประเภทผู้ตอบ

              <option value="expert">ผู้ทรงคุณวุฒิ</option>

              <option value="teacher">อาจารย์</option>            <span>🚪</span> ออกจากระบบ        <select id="respondent">

              <option value="committee">กรรมการ</option>

              <option value="student">นิสิต/นักศึกษา</option>          </button>          <option value="">ทั้งหมด</option>

              <option value="other">อื่นๆ</option>

            </select>        </form>          <option value="expert">ผู้ทรงคุณวุฒิ</option>

          </div>

          <div class="filter-actions">        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">          <option value="teacher">อาจารย์</option>

            <button id="refreshBtn" class="btn btn-primary">

              <span>🔄</span> รีเฟรช          <span class="icon" data-icon-sun>☀️</span>          <option value="committee">กรรมการ</option>

            </button>

            <button id="exportCsv" class="btn btn-secondary">          <span class="icon" data-icon-moon hidden>🌙</span>          <option value="student">นิสิต/นักศึกษา</option>

              <span>📊</span> Export CSV

            </button>        </button>          <option value="other">อื่นๆ</option>

          </div>

        </div>      </nav>        </select>

      </div>

    </section>    </div>      </label>



    <!-- สถิติรวม -->  </div>    </div>

    <section class="stats-section">

      <h3>📈 สถิติสรุป</h3></header>    <div class="actions">

      <div class="stats-grid" id="statsContainer">

        <div class="stat-card" data-stat="avg">      <button id="exportCsv" class="btn">Export CSV</button>

          <div class="stat-icon">📊</div>

          <div class="stat-content"><main class="main-content">    </div>

            <span class="stat-label">คะแนนเฉลี่ย</span>

            <span class="stat-value" id="avg">-</span>  <div class="container">  </section>

            <span class="stat-unit">คะแนน</span>

          </div>    <!-- คำอธิบายและตัวกรอง -->

        </div>

        <div class="stat-card" data-stat="median">    <section class="intro-section">  <section class="card">

          <div class="stat-icon">📏</div>

          <div class="stat-content">      <div class="intro-card">    <h2 class="card-title">สถิติรวม</h2>

            <span class="stat-label">ค่ามัธยฐาน</span>

            <span class="stat-value" id="median">-</span>        <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>    <div class="stats" id="statsContainer">

            <span class="stat-unit">คะแนน</span>

          </div>        <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>      <div><strong>เฉลี่ย:</strong> <span id="avg">-</span></div>

        </div>

        <div class="stat-card" data-stat="std">      </div>      <div><strong>มัธยฐาน:</strong> <span id="median">-</span></div>

          <div class="stat-icon">📐</div>

          <div class="stat-content">            <div><strong>ส่วนเบี่ยงเบน:</strong> <span id="std">-</span></div>

            <span class="stat-label">ส่วนเบี่ยงเบนมาตรฐาน</span>

            <span class="stat-value" id="std">-</span>      <div class="filters-card">      <div><strong>จำนวนแบบ:</strong> <span id="count">-</span></div>

            <span class="stat-unit">คะแนน</span>

          </div>        <h3>🔍 ตัวกรองข้อมูล</h3>    </div>

        </div>

        <div class="stat-card" data-stat="count">        <div class="filters-grid">  </section>

          <div class="stat-icon">📝</div>

          <div class="stat-content">          <div class="filter-group">

            <span class="stat-label">จำนวนผู้ตอบ</span>

            <span class="stat-value" id="count">-</span>            <label>📅 ช่วงเวลา เริ่ม</label>  <section class="card">

            <span class="stat-unit">คน</span>

          </div>            <input type="datetime-local" id="from" class="modern-input">    <h2 class="card-title">กราฟ</h2>

        </div>

      </div>          </div>    <div class="chart-grid">

    </section>

          <div class="filter-group">      <div class="chart-panel chart-panel-wide" id="barChartPanel">

    <!-- กราฟและแผนภูมิ -->

    <section class="charts-section">            <label>📅 ถึง</label>        <h3 class="chart-title">คะแนนเฉลี่ยต่อข้อ</h3>

      <div class="charts-grid">

        <!-- กราฟคะแนนเฉลี่ยต่อข้อ -->            <input type="datetime-local" id="to" class="modern-input">        <div class="chart-scroll">

        <div class="chart-card chart-wide" id="barChartCard">

          <div class="chart-header">          </div>          <canvas id="bar" width="800" height="260"></canvas>

            <h4>📊 คะแนนเฉลี่ยต่อข้อ</h4>

          </div>          <div class="filter-group">        </div>

          <div class="chart-container">

            <canvas id="barChart"></canvas>            <label>👥 ประเภทผู้ตอบ</label>      </div>

          </div>

        </div>            <select id="respondent" class="modern-select">      <div class="chart-panel" id="radarChartPanel">



        <!-- กราฟเรดาร์ -->              <option value="">ทั้งหมด</option>        <h3 class="chart-title">คะแนนเฉลี่ยตามมิติ</h3>

        <div class="chart-card" id="radarChartCard">

          <div class="chart-header">              <option value="expert">ผู้ทรงคุณวุฒิ</option>        <canvas id="radar" width="420" height="260"></canvas>

            <h4>🎯 คะแนนตามมิติ</h4>

          </div>              <option value="teacher">อาจารย์</option>      </div>

          <div class="chart-container">

            <canvas id="radarChart"></canvas>              <option value="committee">กรรมการ</option>      <div class="chart-panel" id="donutChartPanel">

          </div>

        </div>              <option value="student">นิสิต/นักศึกษา</option>        <h3 class="chart-title">สัดส่วนผู้ตอบ</h3>



        <!-- กราฟโดนัท -->              <option value="other">อื่นๆ</option>        <canvas id="donut" width="320" height="220"></canvas>

        <div class="chart-card" id="donutChartCard">

          <div class="chart-header">            </select>      </div>

            <h4>🥧 สัดส่วนผู้ตอบ</h4>

          </div>          </div>    </div>

          <div class="chart-container">

            <canvas id="donutChart"></canvas>          <div class="filter-actions">  </section>

          </div>

        </div>            <button id="refreshBtn" class="btn btn-primary">

      </div>

    </section>              <span>🔄</span> รีเฟรช  <section class="card">



    <!-- ข้อเสนอแนะ -->            </button>    <h2 class="card-title">ข้อเสนอแนะ (ล่าสุด)</h2>

    <section class="suggestions-section">

      <div class="suggestions-card">            <button id="exportCsv" class="btn btn-secondary">    <div id="suggestions" class="list"></div>

        <div class="suggestions-header">

          <h3>💭 ข้อเสนอแนะล่าสุด</h3>              <span>📊</span> Export CSV  </section>

          <span class="suggestions-count" id="suggestionsCount">0 รายการ</span>

        </div>            </button></main>

        <div class="suggestions-container" id="suggestions">

          <div class="loading-suggestions">          </div><div id="toast" class="toast" hidden></div>

            <div class="loading-spinner"></div>

            <span>กำลังโหลดข้อเสนอแนะ...</span>        </div><script src="/assets/js/app.js"></script>

          </div>

        </div>      </div><script>

      </div>

    </section>    </section>const qs = (s)=>document.querySelector(s);

  </div>

</main>const qsa = (s)=>Array.from(document.querySelectorAll(s));



<!-- Toast Notifications -->    <!-- สถิติรวม -->const barCanvas = document.getElementById('bar');

<div id="toast" class="toast hidden"></div>

    <section class="stats-section">const radarCanvas = document.getElementById('radar');

<!-- Loading Overlay -->

<div id="globalLoading" class="global-loading hidden">      <h3>📈 สถิติสรุป</h3>const donutCanvas = document.getElementById('donut');

  <div class="loading-content">

    <div class="loading-spinner large"></div>      <div class="stats-grid" id="statsContainer">const suggestionsBox = document.getElementById('suggestions');

    <span>กำลังโหลดข้อมูล...</span>

  </div>        <div class="stat-card" data-stat="avg">if (suggestionsBox && !suggestionsBox.textContent.trim()) {

</div>

          <div class="stat-icon">📊</div>  suggestionsBox.textContent = 'กำลังโหลด...';

<script>

// ตัวแปรสำหรับเก็บ Chart instances          <div class="stat-content">}

let barChart = null;

let radarChart = null;            <span class="stat-label">คะแนนเฉลี่ย</span>

let donutChart = null;

            <span class="stat-value" id="avg">-</span>const statsTargets = {

// การจัดการ DOM elements

const elements = {            <span class="stat-unit">คะแนน</span>  avg: qs('#avg'),

  stats: {

    avg: document.getElementById('avg'),          </div>  median: qs('#median'),

    median: document.getElementById('median'),

    std: document.getElementById('std'),        </div>  std: qs('#std'),

    count: document.getElementById('count')

  },        <div class="stat-card" data-stat="median">  count: qs('#count')

  filters: {

    from: document.getElementById('from'),          <div class="stat-icon">📏</div>};

    to: document.getElementById('to'),

    respondent: document.getElementById('respondent')          <div class="stat-content">

  },

  suggestions: document.getElementById('suggestions'),            <span class="stat-label">ค่ามัธยฐาน</span>const formatStat = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val.toFixed(2) : '-';

  suggestionsCount: document.getElementById('suggestionsCount'),

  refreshBtn: document.getElementById('refreshBtn'),            <span class="stat-value" id="median">-</span>const formatCount = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val : '-';

  exportBtn: document.getElementById('exportCsv')

};            <span class="stat-unit">คะแนน</span>let statsErrorShown = false;



// ฟังก์ชันช่วยเหลือ          </div>let suggestionsErrorShown = false;

const formatNumber = (num) => {

  if (typeof num !== 'number' || !Number.isFinite(num)) return '-';        </div>

  return num.toLocaleString('th-TH', { maximumFractionDigits: 2 });

};        <div class="stat-card" data-stat="std">const filters = ()=>({



const showToast = (message, type = 'info') => {          <div class="stat-icon">📐</div>  from: qs('#from')?.value || '',

  const toast = document.getElementById('toast');

  toast.textContent = message;          <div class="stat-content">  to: qs('#to')?.value || '',

  toast.className = `toast ${type}`;

  toast.classList.remove('hidden');            <span class="stat-label">ส่วนเบี่ยงเบนมาตรฐาน</span>  respondent: qs('#respondent')?.value || ''

  toast.classList.add('show');

  setTimeout(() => {            <span class="stat-value" id="std">-</span>});

    toast.classList.remove('show');

    setTimeout(() => toast.classList.add('hidden'), 400);            <span class="stat-unit">คะแนน</span>

  }, 4000);

};          </div>function applySummary(summary){



const showGlobalLoading = () => {        </div>  if (statsTargets.avg) statsTargets.avg.textContent = formatStat(summary.avg);

  document.getElementById('globalLoading').classList.remove('hidden');

};        <div class="stat-card" data-stat="count">  if (statsTargets.median) statsTargets.median.textContent = formatStat(summary.median);



const hideGlobalLoading = () => {          <div class="stat-icon">📝</div>  if (statsTargets.std) statsTargets.std.textContent = formatStat(summary.stddev);

  document.getElementById('globalLoading').classList.add('hidden');

};          <div class="stat-content">  if (statsTargets.count) statsTargets.count.textContent = formatCount(summary.count);



// ฟังก์ชันสำหรับอัพเดตสถิติ            <span class="stat-label">จำนวนผู้ตอบ</span>}

const updateStats = (data) => {

  if (!data) return;            <span class="stat-value" id="count">-</span>

  

  elements.stats.avg.textContent = formatNumber(data.avg);            <span class="stat-unit">คน</span>function resetSummary(){

  elements.stats.median.textContent = formatNumber(data.median);

  elements.stats.std.textContent = formatNumber(data.stddev);          </div>  Object.values(statsTargets).forEach(el=>{ if (el) el.textContent = '-'; });

  elements.stats.count.textContent = formatNumber(data.count);

          </div>}

  // เพิ่ม animation

  Object.values(elements.stats).forEach(el => {      </div>

    if (el && el.parentElement) {

      el.parentElement.classList.add('stat-updated');    </section>function chartMessage(ctx, message, width, height){

      setTimeout(() => el.parentElement.classList.remove('stat-updated'), 600);

    }  ctx.clearRect(0,0,width,height);

  });

};    <!-- กราฟและแผนภูมิ -->  ctx.save();



// ฟังก์ชันสำหรับสร้างกราฟแท่ง    <section class="charts-section">  ctx.fillStyle = '#94a3b8';

const createBarChart = (data) => {

  const ctx = document.getElementById('barChart').getContext('2d');      <div class="charts-grid">  ctx.font = '14px system-ui';

  

  if (barChart) {        <!-- กราฟคะแนนเฉลี่ยต่อข้อ -->  ctx.textAlign = 'center';

    barChart.destroy();

  }        <div class="chart-card chart-wide" id="barChartCard">  ctx.textBaseline = 'middle';

  

  if (!data || data.length === 0) {          <div class="chart-header">  ctx.fillText(message, width/2, height/2);

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    ctx.font = '16px Inter';            <h4>📊 คะแนนเฉลี่ยต่อข้อ</h4>  ctx.restore();

    ctx.fillStyle = '#64748b';

    ctx.textAlign = 'center';            <div class="chart-controls">}

    ctx.fillText('📊 ไม่มีข้อมูลสำหรับแสดงผล', ctx.canvas.width/2, ctx.canvas.height/2);

    return;              <button class="chart-btn" onclick="toggleChartView('bar')">📱</button>

  }

              </div>function showLoading(container) {

  barChart = new Chart(ctx, {

    type: 'bar',          </div>  if (!container) return;

    data: {

      labels: data.map(item => item.code),          <div class="chart-container">  const overlay = document.createElement('div');

      datasets: [{

        label: 'คะแนนเฉลี่ย',            <canvas id="barChart"></canvas>  overlay.className = 'loading-overlay';

        data: data.map(item => item.avg),

        backgroundColor: 'rgba(99, 102, 241, 0.8)',          </div>  overlay.innerHTML = '<div class="loading-text"><div class="loading-spinner"></div>กำลังโหลด...</div>';

        borderColor: 'rgba(99, 102, 241, 1)',

        borderWidth: 2,        </div>  container.style.position = 'relative';

        borderRadius: 8,

        borderSkipped: false,  container.appendChild(overlay);

      }]

    },        <!-- กราฟเรดาร์ -->}

    options: {

      responsive: true,        <div class="chart-card" id="radarChartCard">

      maintainAspectRatio: false,

      plugins: {          <div class="chart-header">function hideLoading(container) {

        legend: {

          display: false            <h4>🎯 คะแนนตามมิติ</h4>  if (!container) return;

        },

        tooltip: {          </div>  const overlay = container.querySelector('.loading-overlay');

          backgroundColor: 'rgba(15, 23, 42, 0.9)',

          titleColor: '#f1f5f9',          <div class="chart-container">  if (overlay) {

          bodyColor: '#f1f5f9',

          borderColor: 'rgba(99, 102, 241, 0.5)',            <canvas id="radarChart"></canvas>    overlay.style.opacity = '0';

          borderWidth: 1,

          cornerRadius: 8,          </div>    setTimeout(() => overlay.remove(), 200);

          callbacks: {

            label: function(context) {        </div>  }

              return `คะแนน: ${context.parsed.y.toFixed(2)}`;

            }}

          }

        }        <!-- กราฟโดนัท -->

      },

      scales: {        <div class="chart-card" id="donutChartCard">function showSkeletonStats() {

        y: {

          beginAtZero: true,          <div class="chart-header">  const statsContainer = document.getElementById('statsContainer');

          max: 5,

          grid: {            <h4>🥧 สัดส่วนผู้ตอบ</h4>  if (!statsContainer) return;

            color: 'rgba(148, 163, 184, 0.1)'

          },          </div>  statsContainer.classList.add('skeleton');

          ticks: {

            color: '#64748b',          <div class="chart-container">}

            font: {

              family: 'Inter'            <canvas id="donutChart"></canvas>

            }

          }          </div>function hideSkeletonStats() {

        },

        x: {        </div>  const statsContainer = document.getElementById('statsContainer');

          grid: {

            display: false      </div>  if (!statsContainer) return;

          },

          ticks: {    </section>  statsContainer.classList.remove('skeleton');

            color: '#64748b',

            font: {}

              family: 'Inter'

            },    <!-- ข้อเสนอแนะ -->

            maxRotation: 45

          }    <section class="suggestions-section">async function loadStats(){

        }

      },      <div class="suggestions-card">  try {

      animation: {

        duration: 1000,        <div class="suggestions-header">    showSkeletonStats();

        easing: 'easeOutQuart'

      }          <h3>💭 ข้อเสนอแนะล่าสุด</h3>    showLoading(document.getElementById('barChartPanel'));

    }

  });          <span class="suggestions-count" id="suggestionsCount">0 รายการ</span>    showLoading(document.getElementById('radarChartPanel'));

};

        </div>    showLoading(document.getElementById('donutChartPanel'));

// ฟังก์ชันสำหรับสร้างกราฟเรดาร์

const createRadarChart = (data) => {        <div class="suggestions-container" id="suggestions">    

  const ctx = document.getElementById('radarChart').getContext('2d');

            <div class="loading-suggestions">    const f = filters();

  if (radarChart) {

    radarChart.destroy();            <div class="loading-spinner"></div>    const p = new URLSearchParams(f);

  }

              <span>กำลังโหลดข้อเสนอแนะ...</span>    const res = await fetch('/public/api/dashboard_stats.php?' + p.toString(), { cache: 'no-store' });

  const entries = Object.entries(data || {});

  if (entries.length === 0) {          </div>    const data = await res.json();

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    ctx.font = '14px Inter';        </div>    if (!res.ok || !data.ok) throw new Error(data.error || 'stat error');

    ctx.fillStyle = '#64748b';

    ctx.textAlign = 'center';      </div>    

    ctx.fillText('🎯 ไม่มีข้อมูลมิติ', ctx.canvas.width/2, ctx.canvas.height/2);

    return;    </section>    applySummary(data.summary || {});

  }

    </div>    drawBar(data.items || []);

  radarChart = new Chart(ctx, {

    type: 'radar',</main>    drawRadar(data.dimensions || {});

    data: {

      labels: entries.map(([label]) => label),    drawDonut(data.respondents || {});

      datasets: [{

        label: 'คะแนนเฉลี่ย',<!-- Toast Notifications -->    statsErrorShown = false;

        data: entries.map(([, value]) => value),

        fill: true,<div id="toast" class="toast" hidden></div>    showToast('ข้อมูลได้รับการอัพเดตแล้ว', 'success');

        backgroundColor: 'rgba(139, 92, 246, 0.2)',

        borderColor: 'rgba(139, 92, 246, 1)',  } catch (err) {

        pointBackgroundColor: 'rgba(139, 92, 246, 1)',

        pointBorderColor: '#fff',<!-- Loading Overlay -->    resetSummary();

        pointHoverBackgroundColor: '#fff',

        pointHoverBorderColor: 'rgba(139, 92, 246, 1)',<div id="globalLoading" class="global-loading hidden">    drawBar([]);

        borderWidth: 2,

        pointRadius: 4  <div class="loading-content">    drawRadar({});

      }]

    },    <div class="loading-spinner large"></div>    drawDonut({});

    options: {

      responsive: true,    <span>กำลังโหลดข้อมูล...</span>    if (!statsErrorShown) {

      maintainAspectRatio: false,

      plugins: {  </div>      showToast('โหลดสถิติล้มเหลว: ' + (err.message || 'เกิดข้อผิดพลาด'),'error');

        legend: {

          display: false</div>      statsErrorShown = true;

        }

      },    }

      scales: {

        r: {<script src="/assets/js/app.js"></script>  } finally {

          beginAtZero: true,

          max: 5,<script>    hideSkeletonStats();

          grid: {

            color: 'rgba(148, 163, 184, 0.2)'// ตัวแปรสำหรับเก็บ Chart instances    hideLoading(document.getElementById('barChartPanel'));

          },

          angleLines: {let barChart = null;    hideLoading(document.getElementById('radarChartPanel'));

            color: 'rgba(148, 163, 184, 0.2)'

          },let radarChart = null;    hideLoading(document.getElementById('donutChartPanel'));

          pointLabels: {

            color: '#475569',let donutChart = null;  }

            font: {

              family: 'Inter',}

              size: 12

            }// การจัดการ DOM elements

          },

          ticks: {const elements = {function drawDonut(breakdown){

            display: false

          }  stats: {  const canvas = donutCanvas;

        }

      },    avg: document.getElementById('avg'),  if (!canvas) return;

      animation: {

        duration: 1200,    median: document.getElementById('median'),  const ctx = canvas.getContext('2d');

        easing: 'easeOutQuart'

      }    std: document.getElementById('std'),  const W = canvas.width;

    }

  });    count: document.getElementById('count')  const H = canvas.height;

};

  },  const entries = Object.entries(breakdown || {}).filter(([,v])=>v>0);

// ฟังก์ชันสำหรับสร้างกราฟโดนัท

const createDonutChart = (data) => {  filters: {  if (!entries.length){

  const ctx = document.getElementById('donutChart').getContext('2d');

      from: document.getElementById('from'),    chartMessage(ctx,'👥 ไม่มีข้อมูลผู้ตอบ',W,H);

  if (donutChart) {

    donutChart.destroy();    to: document.getElementById('to'),    return;

  }

      respondent: document.getElementById('respondent')  }

  const entries = Object.entries(data || {}).filter(([, value]) => value > 0);

  if (entries.length === 0) {  },  ctx.clearRect(0,0,W,H);

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    ctx.font = '14px Inter';  suggestions: document.getElementById('suggestions'),  const total = entries.reduce((sum,[,val])=>sum+val,0);

    ctx.fillStyle = '#64748b';

    ctx.textAlign = 'center';  suggestionsCount: document.getElementById('suggestionsCount'),  const colors = ['#8b5cf6','#06b6d4','#10b981','#f59e0b','#ef4444','#a78bfa'];

    ctx.fillText('🥧 ไม่มีข้อมูลผู้ตอบ', ctx.canvas.width/2, ctx.canvas.height/2);

    return;  refreshBtn: document.getElementById('refreshBtn'),  let start = -Math.PI/2;

  }

    exportBtn: document.getElementById('exportCsv')  const radius = Math.min(W,H)/2 - 20;

  const colors = [

    'rgba(239, 68, 68, 0.8)',};  const innerRadius = radius * 0.6;

    'rgba(245, 158, 11, 0.8)',

    'rgba(34, 197, 94, 0.8)',  

    'rgba(59, 130, 246, 0.8)',

    'rgba(139, 92, 246, 0.8)',// ฟังก์ชันช่วยเหลือ  // Draw donut segments

    'rgba(236, 72, 153, 0.8)'

  ];const formatNumber = (num) => {  entries.forEach(([label,val], idx)=>{

  

  donutChart = new Chart(ctx, {  if (typeof num !== 'number' || !Number.isFinite(num)) return '-';    const angle = (val/total) * Math.PI * 2;

    type: 'doughnut',

    data: {  return num.toLocaleString('th-TH', { maximumFractionDigits: 2 });    const color = colors[idx % colors.length];

      labels: entries.map(([label]) => label),

      datasets: [{};    

        data: entries.map(([, value]) => value),

        backgroundColor: colors.slice(0, entries.length),    // Create gradient

        borderColor: colors.slice(0, entries.length).map(color => color.replace('0.8', '1')),

        borderWidth: 2,const showToast = (message, type = 'info') => {    const gradient = ctx.createRadialGradient(W/2, H/2, innerRadius, W/2, H/2, radius);

        hoverOffset: 4

      }]  const toast = document.getElementById('toast');    gradient.addColorStop(0, color);

    },

    options: {  toast.textContent = message;    gradient.addColorStop(1, color + '80');

      responsive: true,

      maintainAspectRatio: false,  toast.className = `toast ${type} show`;    

      plugins: {

        legend: {  setTimeout(() => {    ctx.beginPath();

          position: 'bottom',

          labels: {    toast.classList.remove('show');    ctx.arc(W/2, H/2, radius, start, start + angle);

            color: '#475569',

            font: {  }, 4000);    ctx.arc(W/2, H/2, innerRadius, start + angle, start, true);

              family: 'Inter',

              size: 12};    ctx.closePath();

            },

            padding: 15,    ctx.fillStyle = gradient;

            usePointStyle: true

          }const showGlobalLoading = () => {    ctx.fill();

        },

        tooltip: {  document.getElementById('globalLoading').classList.remove('hidden');    

          backgroundColor: 'rgba(15, 23, 42, 0.9)',

          titleColor: '#f1f5f9',};    // Add subtle border

          bodyColor: '#f1f5f9',

          borderColor: 'rgba(148, 163, 184, 0.5)',    ctx.strokeStyle = 'rgba(255,255,255,0.5)';

          borderWidth: 1,

          cornerRadius: 8const hideGlobalLoading = () => {    ctx.lineWidth = 2;

        }

      },  document.getElementById('globalLoading').classList.add('hidden');    ctx.stroke();

      animation: {

        duration: 1000,};    

        easing: 'easeOutQuart'

      }    start += angle;

    }

  });// ฟังก์ชันสำหรับอัพเดตสถิติ  });

};

const updateStats = (data) => {  

// ฟังก์ชันโหลดข้อมูลสถิติ

const loadStats = async () => {  if (!data) return;  // Center text

  try {

    showGlobalLoading();    ctx.save();

    

    const params = new URLSearchParams({  elements.stats.avg.textContent = formatNumber(data.avg);  ctx.font = 'bold 16px system-ui';

      from: elements.filters.from.value || '',

      to: elements.filters.to.value || '',  elements.stats.median.textContent = formatNumber(data.median);  ctx.fillStyle = '#475569';

      respondent: elements.filters.respondent.value || ''

    });  elements.stats.std.textContent = formatNumber(data.stddev);  ctx.textAlign = 'center';

    

    const response = await fetch(`/public/api/dashboard_stats.php?${params}`, {  elements.stats.count.textContent = formatNumber(data.count);  ctx.textBaseline = 'middle';

      cache: 'no-store'

    });    ctx.fillText('รวม', W/2, H/2 - 8);

    

    const data = await response.json();  // เพิ่ม animation  ctx.font = 'bold 20px system-ui';

    

    if (!response.ok || !data.ok) {  Object.values(elements.stats).forEach(el => {  ctx.fillText(total.toString(), W/2, H/2 + 8);

      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อมูล');

    }    el.parentElement.classList.add('stat-updated');  ctx.restore();

    

    // อัพเดตสถิติ    setTimeout(() => el.parentElement.classList.remove('stat-updated'), 600);  

    updateStats(data.summary);

      });  // Legend

    // สร้างกราฟ

    createBarChart(data.items || []);};  ctx.save();

    createRadarChart(data.dimensions || {});

    createDonutChart(data.respondents || {});  ctx.font = '12px system-ui';

    

    showToast('ข้อมูลได้รับการอัพเดตเรียบร้อยแล้ว', 'success');// ฟังก์ชันสำหรับสร้างกราฟแท่ง  ctx.textBaseline = 'middle';

    

  } catch (error) {const createBarChart = (data) => {  ctx.textAlign = 'left';

    showToast(`เกิดข้อผิดพลาด: ${error.message}`, 'error');

    console.error('Error loading stats:', error);  const ctx = document.getElementById('barChart').getContext('2d');  const legendX = 20;

  } finally {

    hideGlobalLoading();    let y = Math.max(20, H - entries.length * 22 - 12);

  }

};  if (barChart) {  entries.forEach(([label,val], idx)=>{



// ฟังก์ชันโหลดข้อเสนอแนะ    barChart.destroy();    const color = colors[idx % colors.length];

const loadSuggestions = async () => {

  try {  }    // Legend color box with gradient

    const params = new URLSearchParams({

      from: elements.filters.from.value || '',      const gradient = ctx.createLinearGradient(legendX, y-6, legendX+14, y+6);

      to: elements.filters.to.value || '',

      respondent: elements.filters.respondent.value || ''  if (!data || data.length === 0) {    gradient.addColorStop(0, color);

    });

        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);    gradient.addColorStop(1, color + '80');

    const response = await fetch(`/api/suggestions.php?${params}`, {

      cache: 'no-store'    ctx.font = '16px Inter';    ctx.fillStyle = gradient;

    });

        ctx.fillStyle = '#64748b';    ctx.fillRect(legendX, y - 6, 14, 12);

    const data = await response.json();

        ctx.textAlign = 'center';    ctx.strokeStyle = 'rgba(255,255,255,0.3)';

    if (!response.ok || !data.ok) {

      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อเสนอแนะ');    ctx.fillText('📊 ไม่มีข้อมูลสำหรับแสดงผล', ctx.canvas.width/2, ctx.canvas.height/2);    ctx.strokeRect(legendX, y - 6, 14, 12);

    }

        return;    

    const suggestions = data.data || [];

    elements.suggestionsCount.textContent = `${suggestions.length} รายการ`;  }    // Legend text

    

    if (suggestions.length === 0) {      ctx.fillStyle = '#475569';

      elements.suggestions.innerHTML = `

        <div class="no-suggestions">  barChart = new Chart(ctx, {    ctx.fillText(`${label || 'unknown'} (${val})`, legendX + 20, y);

          <div class="no-suggestions-icon">💭</div>

          <p>ยังไม่มีข้อเสนอแนะ</p>    type: 'bar',    y += 22;

        </div>

      `;    data: {  });

      return;

    }      labels: data.map(item => item.code),  ctx.restore();

    

    elements.suggestions.innerHTML = suggestions.slice(0, 20).map(item => `      datasets: [{}

      <div class="suggestion-item">

        <div class="suggestion-meta">        label: 'คะแนนเฉลี่ย',

          <span class="suggestion-type">${item.respondent_type || 'ไม่ระบุ'}</span>

          <span class="suggestion-time">${new Date(item.created_at || Date.now()).toLocaleDateString('th-TH')}</span>        data: data.map(item => item.avg),function drawBar(items){

        </div>

        <div class="suggestion-text">${item.suggestion || ''}</div>        backgroundColor: 'rgba(99, 102, 241, 0.8)',  const canvas = barCanvas;

      </div>

    `).join('');        borderColor: 'rgba(99, 102, 241, 1)',  if (!canvas) return;

    

  } catch (error) {        borderWidth: 2,  const data = Array.isArray(items) ? items.filter(it=>typeof it.avg === 'number') : [];

    elements.suggestions.innerHTML = `

      <div class="error-suggestions">        borderRadius: 8,  const H = 260;

        <div class="error-icon">⚠️</div>

        <p>ไม่สามารถโหลดข้อเสนอแนะได้</p>        borderSkipped: false,  const padL = 56;

      </div>

    `;      }]  const padB = 48;

    console.error('Error loading suggestions:', error);

  }    },  const barWidth = 32;

};

    options: {  const gap = 18;

// Event Listeners

if (elements.refreshBtn) {      responsive: true,  const defaultWidth = 720;

  elements.refreshBtn.addEventListener('click', () => {

    loadStats();      maintainAspectRatio: false,  const W = data.length ? Math.max(defaultWidth, padL + data.length * (barWidth + gap) + 40) : defaultWidth;

    loadSuggestions();

  });      plugins: {  canvas.width = W;

}

        legend: {  canvas.height = H;

if (elements.exportBtn) {

  elements.exportBtn.addEventListener('click', () => {          display: false  const ctx = canvas.getContext('2d');

    const params = new URLSearchParams({

      from: elements.filters.from.value || '',        },  if (!data.length){

      to: elements.filters.to.value || '',

      respondent: elements.filters.respondent.value || ''        tooltip: {    chartMessage(ctx,'📊 ไม่มีข้อมูลสำหรับแสดงผล',W,H);

    });

    window.open(`/api/export_csv.php?${params}`, '_blank');          backgroundColor: 'rgba(15, 23, 42, 0.9)',    return;

  });

}          titleColor: '#f1f5f9',  }



// เมื่อมีการเปลี่ยนแปลงตัวกรอง          bodyColor: '#f1f5f9',  ctx.clearRect(0,0,W,H);

[elements.filters.from, elements.filters.to, elements.filters.respondent].forEach(element => {

  if (element) {          borderColor: 'rgba(99, 102, 241, 0.5)',  const values = data.map(item=>Math.max(0,item.avg));

    element.addEventListener('change', () => {

      loadStats();          borderWidth: 1,  const axisMax = Math.max(5, Math.ceil(Math.max(...values) * 1.1));

      loadSuggestions();

    });          cornerRadius: 8,  const chartHeight = H - padB - 24;

  }

});          callbacks: {  const scale = chartHeight / axisMax;



// Theme toggle            label: function(context) {  

const themeToggle = document.getElementById('themeToggle');

if (themeToggle) {              return `คะแนน: ${context.parsed.y.toFixed(2)}`;  // Grid lines

  themeToggle.addEventListener('click', () => {

    const html = document.documentElement;            }  ctx.strokeStyle = 'rgba(203,213,225,0.4)';

    const isDark = html.classList.contains('theme-dark');

              }  ctx.lineWidth = 1;

    if (isDark) {

      html.classList.remove('theme-dark');        }  const ticks = 5;

      html.classList.add('theme-light');

      document.querySelector('[data-icon-sun]').classList.remove('hidden');      },  for (let i = 1; i <= ticks; i++){

      document.querySelector('[data-icon-moon]').classList.add('hidden');

    } else {      scales: {    const value = (axisMax / ticks) * i;

      html.classList.remove('theme-light');

      html.classList.add('theme-dark');        y: {    const yy = H - padB - value * scale;

      document.querySelector('[data-icon-sun]').classList.add('hidden');

      document.querySelector('[data-icon-moon]').classList.remove('hidden');          beginAtZero: true,    ctx.beginPath();

    }

  });          max: 5,    ctx.moveTo(padL + 2, yy);

}

          grid: {    ctx.lineTo(W - 20, yy);

// โหลดข้อมูลครั้งแรก

document.addEventListener('DOMContentLoaded', () => {            color: 'rgba(148, 163, 184, 0.1)'    ctx.stroke();

  loadStats();

  loadSuggestions();          },  }

  

  // รีเฟรชอัตโนมัติทุก 30 วินาที          ticks: {  

  setInterval(() => {

    loadStats();            color: '#64748b',  // Axes

    loadSuggestions();

  }, 30000);            font: {  ctx.strokeStyle = '#475569';

});

</script>              family: 'Inter'  ctx.lineWidth = 2;

</body>

</html>            }  ctx.beginPath(); 

          }  ctx.moveTo(padL, 20); 

        },  ctx.lineTo(padL, H - padB); 

        x: {  ctx.lineTo(W - 20, H - padB);

          grid: {  ctx.stroke();

            display: false  

          },  // Y-axis labels

          ticks: {  ctx.font = '12px system-ui';

            color: '#64748b',  ctx.fillStyle = '#64748b';

            font: {  ctx.textAlign = 'right';

              family: 'Inter'  for (let i = 1; i <= ticks; i++){

            }    const value = (axisMax / ticks) * i;

          }    const yy = H - padB - value * scale;

        }    const label = value % 1 === 0 ? value.toString() : value.toFixed(1);

      },    ctx.fillText(label, padL - 8, yy + 4);

      animation: {  }

        duration: 1000,  

        easing: 'easeOutQuart'  // Bars with gradient

      }  ctx.textAlign = 'center';

    }  data.forEach((item, idx)=>{

  });    const x = padL + idx * (barWidth + gap);

};    const height = item.avg * scale;

    const y = H - padB - height;

// ฟังก์ชันสำหรับสร้างกราฟเรดาร์    

const createRadarChart = (data) => {    // Create gradient

  const ctx = document.getElementById('radarChart').getContext('2d');    const gradient = ctx.createLinearGradient(0, y, 0, y + height);

      gradient.addColorStop(0, '#8b5cf6');

  if (radarChart) {    gradient.addColorStop(1, '#4f46e5');

    radarChart.destroy();    

  }    ctx.fillStyle = gradient;

      ctx.fillRect(x, y, barWidth, height);

  const entries = Object.entries(data || {});    

  if (entries.length === 0) {    // Highlight effect

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);    ctx.fillStyle = 'rgba(255,255,255,0.3)';

    ctx.font = '14px Inter';    ctx.fillRect(x, y, barWidth, Math.min(8, height));

    ctx.fillStyle = '#64748b';    

    ctx.textAlign = 'center';    // Value on top

    ctx.fillText('🎯 ไม่มีข้อมูลมิติ', ctx.canvas.width/2, ctx.canvas.height/2);    ctx.fillStyle = '#475569';

    return;    ctx.font = '11px system-ui';

  }    ctx.fillText(item.avg.toFixed(1), x + barWidth/2, y - 6);

      

  radarChart = new Chart(ctx, {    // X-axis labels

    type: 'radar',    ctx.save();

    data: {    ctx.translate(x + barWidth / 2, H - padB + 18);

      labels: entries.map(([label]) => label),    ctx.rotate(-Math.PI / 4);

      datasets: [{    ctx.fillStyle = '#475569';

        label: 'คะแนนเฉลี่ย',    ctx.textAlign = 'left';

        data: entries.map(([, value]) => value),    ctx.font = '12px system-ui';

        fill: true,    ctx.fillText(item.code, 0, 0);

        backgroundColor: 'rgba(139, 92, 246, 0.2)',    ctx.restore();

        borderColor: 'rgba(139, 92, 246, 1)',  });

        pointBackgroundColor: 'rgba(139, 92, 246, 1)',}

        pointBorderColor: '#fff',

        pointHoverBackgroundColor: '#fff',function drawRadar(dimensions){

        pointHoverBorderColor: 'rgba(139, 92, 246, 1)',  const canvas = radarCanvas;

        borderWidth: 2,  if (!canvas) return;

        pointRadius: 4  const ctx = canvas.getContext('2d');

      }]  const W = canvas.width;

    },  const H = canvas.height;

    options: {  ctx.clearRect(0,0,W,H);

      responsive: true,  const entries = Object.entries(dimensions || {}).filter(([,val])=>Number.isFinite(val));

      maintainAspectRatio: false,  const count = entries.length;

      plugins: {  if (!count){

        legend: {    chartMessage(ctx,'ไม่มีข้อมูล',W,H);

          display: false    return;

        }  }

      },  const cx = W/2;

      scales: {  const cy = H/2;

        r: {  const radius = Math.min(W,H)/2 - 36;

          beginAtZero: true,  ctx.strokeStyle = '#e5e7eb';

          max: 5,  for (let g = 1; g <= 5; g++){

          grid: {    const rr = (g/5) * radius;

            color: 'rgba(148, 163, 184, 0.2)'    ctx.beginPath();

          },    for (let i = 0; i <= count; i++){

          angleLines: {      const angle = (Math.PI * 2 * i) / count - Math.PI/2;

            color: 'rgba(148, 163, 184, 0.2)'      const x = cx + rr * Math.cos(angle);

          },      const y = cy + rr * Math.sin(angle);

          pointLabels: {      if (i === 0) ctx.moveTo(x,y); else ctx.lineTo(x,y);

            color: '#475569',    }

            font: {    ctx.stroke();

              family: 'Inter',  }

              size: 12  const points = entries.map(([label, val], idx)=>{

            }    const safe = Math.max(0, Math.min(5, val));

          },    const angle = (Math.PI * 2 * idx) / count - Math.PI / 2;

          ticks: {    const rr = (safe / 5) * radius;

            display: false    return { x: cx + rr * Math.cos(angle), y: cy + rr * Math.sin(angle), angle, label };

          }  });

        }  ctx.beginPath();

      },  points.forEach(({x,y}, idx)=>{ if (idx === 0) ctx.moveTo(x,y); else ctx.lineTo(x,y); });

      animation: {  ctx.closePath();

        duration: 1200,  ctx.fillStyle = 'rgba(79,70,229,0.2)';

        easing: 'easeOutQuart'  ctx.strokeStyle = '#4f46e5';

      }  ctx.fill();

    }  ctx.stroke();

  });  ctx.save();

};  ctx.fillStyle = '#475569';

  ctx.font = '12px system-ui';

// ฟังก์ชันสำหรับสร้างกราฟโดนัท  ctx.textAlign = 'center';

const createDonutChart = (data) => {  ctx.textBaseline = 'middle';

  const ctx = document.getElementById('donutChart').getContext('2d');  const labelRadius = radius + 18;

    points.forEach(({angle, label})=>{

  if (donutChart) {    const lx = cx + labelRadius * Math.cos(angle);

    donutChart.destroy();    const ly = cy + labelRadius * Math.sin(angle);

  }    ctx.fillText(label, lx, ly);

    });

  const entries = Object.entries(data || {}).filter(([, value]) => value > 0);  ctx.restore();

  if (entries.length === 0) {}

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    ctx.font = '14px Inter';loadStats();

    ctx.fillStyle = '#64748b';setInterval(loadStats, 15000);

    ctx.textAlign = 'center';

    ctx.fillText('🥧 ไม่มีข้อมูลผู้ตอบ', ctx.canvas.width/2, ctx.canvas.height/2);async function loadSuggestions(){

    return;  if (!suggestionsBox) return;

  }  suggestionsBox.textContent = 'กำลังโหลด...';

    try{

  const colors = [    const f = filters();

    'rgba(239, 68, 68, 0.8)',    const p = new URLSearchParams(f);

    'rgba(245, 158, 11, 0.8)',    const res = await fetch('/api/suggestions.php?' + p.toString(), { cache: 'no-store' });

    'rgba(34, 197, 94, 0.8)',    const data = await res.json();

    'rgba(59, 130, 246, 0.8)',    if (!res.ok || !data.ok) throw new Error(data.error || 'suggestion error');

    'rgba(139, 92, 246, 0.8)',    if (!data.data || data.data.length === 0){

    'rgba(236, 72, 153, 0.8)'      suggestionsBox.textContent = '— ไม่มีข้อเสนอแนะ —';

  ];      suggestionsErrorShown = false;

        return;

  donutChart = new Chart(ctx, {    }

    type: 'doughnut',    suggestionsBox.innerHTML = '';

    data: {    data.data.slice(0,50).forEach(row=>{

      labels: entries.map(([label]) => label),      const div = document.createElement('div');

      datasets: [{      div.className = 'list-item';

        data: entries.map(([, value]) => value),      const who = row.respondent_type ? `[${row.respondent_type}] ` : '';

        backgroundColor: colors.slice(0, entries.length),      div.textContent = who + (row.suggestion || '');

        borderColor: colors.slice(0, entries.length).map(color => color.replace('0.8', '1')),      suggestionsBox.appendChild(div);

        borderWidth: 2,    });

        hoverOffset: 4    suggestionsErrorShown = false;

      }]  } catch (err){

    },    suggestionsBox.textContent = 'โหลดข้อเสนอแนะไม่สำเร็จ';

    options: {    if (!suggestionsErrorShown){

      responsive: true,      showToast('โหลดข้อเสนอแนะไม่สำเร็จ','error');

      maintainAspectRatio: false,      suggestionsErrorShown = true;

      plugins: {    }

        legend: {  }

          position: 'bottom',}

          labels: {loadSuggestions();

            color: '#475569',setInterval(loadSuggestions, 20000);

            font: {

              family: 'Inter',qsa('#from, #to, #respondent').forEach(el=>{

              size: 12  el.addEventListener('change', ()=>{

            },    loadStats();

            padding: 15,    loadSuggestions();

            usePointStyle: true  });

          }});

        },

        tooltip: {const exportBtn = document.getElementById('exportCsv');

          backgroundColor: 'rgba(15, 23, 42, 0.9)',if (exportBtn){

          titleColor: '#f1f5f9',  exportBtn.addEventListener('click', ()=>{

          bodyColor: '#f1f5f9',    const p = new URLSearchParams(filters()).toString();

          borderColor: 'rgba(148, 163, 184, 0.5)',    window.location = '/api/export_csv.php?' + p;

          borderWidth: 1,  });

          cornerRadius: 8}

        }</script>

      },</body>

      animation: {</html>

        duration: 1000,
        easing: 'easeOutQuart'
      }
    }
  });
};

// ฟังก์ชันโหลดข้อมูลสถิติ
const loadStats = async () => {
  try {
    showGlobalLoading();
    
    const params = new URLSearchParams({
      from: elements.filters.from.value || '',
      to: elements.filters.to.value || '',
      respondent: elements.filters.respondent.value || ''
    });
    
    const response = await fetch(`/public/api/dashboard_stats.php?${params}`, {
      cache: 'no-store'
    });
    
    const data = await response.json();
    
    if (!response.ok || !data.ok) {
      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อมูล');
    }
    
    // อัพเดตสถิติ
    updateStats(data.summary);
    
    // สร้างกราฟ
    createBarChart(data.items || []);
    createRadarChart(data.dimensions || {});
    createDonutChart(data.respondents || {});
    
    showToast('ข้อมูลได้รับการอัพเดตเรียบร้อยแล้ว', 'success');
    
  } catch (error) {
    showToast(`เกิดข้อผิดพลาด: ${error.message}`, 'error');
    console.error('Error loading stats:', error);
  } finally {
    hideGlobalLoading();
  }
};

// ฟังก์ชันโหลดข้อเสนอแนะ
const loadSuggestions = async () => {
  try {
    const params = new URLSearchParams({
      from: elements.filters.from.value || '',
      to: elements.filters.to.value || '',
      respondent: elements.filters.respondent.value || ''
    });
    
    const response = await fetch(`/api/suggestions.php?${params}`, {
      cache: 'no-store'
    });
    
    const data = await response.json();
    
    if (!response.ok || !data.ok) {
      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อเสนอแนะ');
    }
    
    const suggestions = data.data || [];
    elements.suggestionsCount.textContent = `${suggestions.length} รายการ`;
    
    if (suggestions.length === 0) {
      elements.suggestions.innerHTML = `
        <div class="no-suggestions">
          <div class="no-suggestions-icon">💭</div>
          <p>ยังไม่มีข้อเสนอแนะ</p>
        </div>
      `;
      return;
    }
    
    elements.suggestions.innerHTML = suggestions.slice(0, 20).map(item => `
      <div class="suggestion-item">
        <div class="suggestion-meta">
          <span class="suggestion-type">${item.respondent_type || 'ไม่ระบุ'}</span>
          <span class="suggestion-time">${new Date(item.created_at || Date.now()).toLocaleDateString('th-TH')}</span>
        </div>
        <div class="suggestion-text">${item.suggestion || ''}</div>
      </div>
    `).join('');
    
  } catch (error) {
    elements.suggestions.innerHTML = `
      <div class="error-suggestions">
        <div class="error-icon">⚠️</div>
        <p>ไม่สามารถโหลดข้อเสนอแนะได้</p>
      </div>
    `;
    console.error('Error loading suggestions:', error);
  }
};

// Event Listeners
elements.refreshBtn.addEventListener('click', () => {
  loadStats();
  loadSuggestions();
});

elements.exportBtn.addEventListener('click', () => {
  const params = new URLSearchParams({
    from: elements.filters.from.value || '',
    to: elements.filters.to.value || '',
    respondent: elements.filters.respondent.value || ''
  });
  window.open(`/api/export_csv.php?${params}`, '_blank');
});

// เมื่อมีการเปลี่ยนแปลงตัวกรอง
[elements.filters.from, elements.filters.to, elements.filters.respondent].forEach(element => {
  element.addEventListener('change', () => {
    loadStats();
    loadSuggestions();
  });
});

// โหลดข้อมูลครั้งแรก
document.addEventListener('DOMContentLoaded', () => {
  loadStats();
  loadSuggestions();
  
  // รีเฟรชอัตโนมัติทุก 30 วินาที
  setInterval(() => {
    loadStats();
    loadSuggestions();
  }, 30000);
});
</script>
</body>
</html>