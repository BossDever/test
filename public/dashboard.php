<?php<?php

require_once __DIR__ . '/bootstrap.php';require_once __DIR__ . '/bootstrap.php';

$u = current_user();$u = current_user();

if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) {

    http_response_code(403); echo 'Forbidden'; exit;    http_response_code(403); echo 'Forbidden'; exit;

}}

?>?>

<!doctype html><!doctype html>

<html lang="th" class="theme-light"><html lang="th" class="theme-light">

<head><head>

  <meta charset="utf-8">  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>📊 แดชบอร์ดสรุปผล</title>

  <link rel="stylesheet" href="/assets/css/dashboard.css">  <title>📊 แดชบอร์ดสรุปผล</title>?>?>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>  <link rel="stylesheet" href="/assets/css/dashboard.css">

<body>

<header class="modern-header">  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script><!doctype html><!doctype html>

  <div class="container">

    <div class="header-content"></head>

      <div class="brand">

        <span class="brand-icon">📊</span><body><html lang="th" class="theme-light"><html lang="th" class="theme-light">

        <h1>แดชบอร์ดสรุปผล</h1>

      </div><header class="modern-header">

      <nav class="header-nav">

        <a class="nav-btn" href="/index.php">  <div class="container"><head><head>

          <span>📝</span> หน้าแบบประเมิน

        </a>    <div class="header-content">

        <form method="post" action="/logout.php" class="inline">

          <?=csrf_token_input()?>      <div class="brand">  <meta charset="utf-8">  <meta charset="utf-8">

          <button class="nav-btn logout" type="submit">

            <span>🚪</span> ออกจากระบบ        <span class="brand-icon">📊</span>

          </button>

        </form>        <h1>แดชบอร์ดสรุปผล</h1>  <meta name="viewport" content="width=device-width, initial-scale=1">  <meta name="viewport" content="width=device-width, initial-scale=1">

        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">

          <span class="icon" data-icon-sun>☀️</span>      </div>

          <span class="icon" data-icon-moon hidden">🌙</span>

        </button>      <nav class="header-nav">  <title>📊 แดชบอร์ดสรุปผล</title>  <title>แดชบอร์ด</title>

      </nav>

    </div>        <a class="nav-btn" href="/index.php">

  </div>

</header>          <span>📝</span> หน้าแบบประเมิน  <link rel="stylesheet" href="/assets/css/styles.css">  <link rel="stylesheet" href="/assets/css/styles.css">



<main class="main-content">        </a>

  <div class="container">

    <!-- คำอธิบายและตัวกรอง -->        <form method="post" action="/logout.php" class="inline">  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head>

    <section class="intro-section">

      <div class="intro-card">          <?=csrf_token_input()?>

        <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>

        <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>          <button class="nav-btn logout" type="submit">  <link rel="preconnect" href="https://fonts.googleapis.com"><body>

      </div>

                  <span>🚪</span> ออกจากระบบ

      <div class="filters-card">

        <h3>🔍 ตัวกรองข้อมูล</h3>          </button>  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><header class="topbar">

        <div class="filters-grid">

          <div class="filter-group">        </form>

            <label>📅 ช่วงเวลา เริ่ม</label>

            <input type="datetime-local" id="from" class="modern-input">        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">  <div class="brand">แดชบอร์ดสรุปผล</div>

          </div>

          <div class="filter-group">          <span class="icon" data-icon-sun>☀️</span>

            <label>📅 ถึง</label>

            <input type="datetime-local" id="to" class="modern-input">          <span class="icon" data-icon-moon hidden">🌙</span></head>  <nav>

          </div>

          <div class="filter-group">        </button>

            <label>👥 ประเภทผู้ตอบ</label>

            <select id="respondent" class="modern-select">      </nav><body>    <a class="btn" href="/index.php">หน้าแบบประเมิน</a>

              <option value="">ทั้งหมด</option>

              <option value="expert">ผู้ทรงคุณวุฒิ</option>    </div>

              <option value="teacher">อาจารย์</option>

              <option value="committee">กรรมการ</option>  </div><header class="modern-header">    <form method="post" action="/logout.php" class="inline"><?=csrf_token_input()?><button class="btn" type="submit">ออกจากระบบ</button></form>

              <option value="student">นิสิต/นักศึกษา</option>

              <option value="other">อื่นๆ</option></header>

            </select>

          </div>  <div class="container">    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">

          <div class="filter-actions">

            <button id="refreshBtn" class="btn btn-primary"><main class="main-content">

              <span>🔄</span> รีเฟรช

            </button>  <div class="container">    <div class="header-content">      <span class="icon" data-icon-sun>☀</span>

            <button id="exportCsv" class="btn btn-secondary">

              <span>📊</span> Export CSV    <!-- คำอธิบายและตัวกรอง -->

            </button>

          </div>    <section class="intro-section">      <div class="brand">      <span class="icon" data-icon-moon hidden>🌙</span>

        </div>

      </div>      <div class="intro-card">

    </section>

        <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>        <span class="brand-icon">📊</span>    </button>

    <!-- สถิติรวม -->

    <section class="stats-section">        <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>

      <h3>📈 สถิติสรุป</h3>

      <div class="stats-grid" id="statsContainer">      </div>        <h1>แดชบอร์ดสรุปผล</h1>  </nav>

        <div class="stat-card" data-stat="avg">

          <div class="stat-icon">📊</div>      

          <div class="stat-content">

            <span class="stat-label">คะแนนเฉลี่ย</span>      <div class="filters-card">      </div></header>

            <span class="stat-value" id="avg">-</span>

            <span class="stat-unit">คะแนน</span>        <h3>🔍 ตัวกรองข้อมูล</h3>

          </div>

        </div>        <div class="filters-grid">      <nav class="header-nav"><main class="container">

        <div class="stat-card" data-stat="median">

          <div class="stat-icon">📏</div>          <div class="filter-group">

          <div class="stat-content">

            <span class="stat-label">ค่ามัธยฐาน</span>            <label>📅 ช่วงเวลา เริ่ม</label>        <a class="nav-btn" href="/index.php">  <section class="card">

            <span class="stat-value" id="median">-</span>

            <span class="stat-unit">คะแนน</span>            <input type="datetime-local" id="from" class="modern-input">

          </div>

        </div>          </div>          <span>📝</span> หน้าแบบประเมิน    <h2 class="card-title">ตัวกรอง</h2>

        <div class="stat-card" data-stat="std">

          <div class="stat-icon">📐</div>          <div class="filter-group">

          <div class="stat-content">

            <span class="stat-label">ส่วนเบี่ยงเบนมาตรฐาน</span>            <label>📅 ถึง</label>        </a>    <div class="filters">

            <span class="stat-value" id="std">-</span>

            <span class="stat-unit">คะแนน</span>            <input type="datetime-local" id="to" class="modern-input">

          </div>

        </div>          </div>        <form method="post" action="/logout.php" class="inline">      <label>ช่วงเวลา เริ่ม <input type="datetime-local" id="from"></label>

        <div class="stat-card" data-stat="count">

          <div class="stat-icon">📝</div>          <div class="filter-group">

          <div class="stat-content">

            <span class="stat-label">จำนวนผู้ตอบ</span>            <label>👥 ประเภทผู้ตอบ</label>          <?=csrf_token_input()?>      <label>ถึง <input type="datetime-local" id="to"></label>

            <span class="stat-value" id="count">-</span>

            <span class="stat-unit">คน</span>            <select id="respondent" class="modern-select">

          </div>

        </div>              <option value="">ทั้งหมด</option>          <button class="nav-btn logout" type="submit">      <label>ประเภทผู้ตอบ

      </div>

    </section>              <option value="expert">ผู้ทรงคุณวุฒิ</option>



    <!-- กราฟและแผนภูมิ -->              <option value="teacher">อาจารย์</option>            <span>🚪</span> ออกจากระบบ        <select id="respondent">

    <section class="charts-section">

      <div class="charts-grid">              <option value="committee">กรรมการ</option>

        <!-- กราฟคะแนนเฉลี่ยต่อข้อ -->

        <div class="chart-card chart-wide" id="barChartCard">              <option value="student">นิสิต/นักศึกษา</option>          </button>          <option value="">ทั้งหมด</option>

          <div class="chart-header">

            <h4>📊 คะแนนเฉลี่ยต่อข้อ</h4>              <option value="other">อื่นๆ</option>

          </div>

          <div class="chart-container">            </select>        </form>          <option value="expert">ผู้ทรงคุณวุฒิ</option>

            <canvas id="barChart"></canvas>

          </div>          </div>

        </div>

          <div class="filter-actions">        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">          <option value="teacher">อาจารย์</option>

        <!-- กราฟเรดาร์ -->

        <div class="chart-card" id="radarChartCard">            <button id="refreshBtn" class="btn btn-primary">

          <div class="chart-header">

            <h4>🎯 คะแนนตามมิติ</h4>              <span>🔄</span> รีเฟรช          <span class="icon" data-icon-sun>☀️</span>          <option value="committee">กรรมการ</option>

          </div>

          <div class="chart-container">            </button>

            <canvas id="radarChart"></canvas>

          </div>            <button id="exportCsv" class="btn btn-secondary">          <span class="icon" data-icon-moon hidden>🌙</span>          <option value="student">นิสิต/นักศึกษา</option>

        </div>

              <span>📊</span> Export CSV

        <!-- กราฟโดนัท -->

        <div class="chart-card" id="donutChartCard">            </button>        </button>          <option value="other">อื่นๆ</option>

          <div class="chart-header">

            <h4>🥧 สัดส่วนผู้ตอบ</h4>          </div>

          </div>

          <div class="chart-container">        </div>      </nav>        </select>

            <canvas id="donutChart"></canvas>

          </div>      </div>

        </div>

      </div>    </section>    </div>      </label>

    </section>



    <!-- ข้อเสนอแนะ -->

    <section class="suggestions-section">    <!-- สถิติรวม -->  </div>    </div>

      <div class="suggestions-card">

        <div class="suggestions-header">    <section class="stats-section">

          <h3>💭 ข้อเสนอแนะล่าสุด</h3>

          <span class="suggestions-count" id="suggestionsCount">0 รายการ</span>      <h3>📈 สถิติสรุป</h3></header>    <div class="actions">

        </div>

        <div class="suggestions-container" id="suggestions">      <div class="stats-grid" id="statsContainer">

          <div class="loading-suggestions">

            <div class="loading-spinner"></div>        <div class="stat-card" data-stat="avg">      <button id="exportCsv" class="btn">Export CSV</button>

            <span>กำลังโหลดข้อเสนอแนะ...</span>

          </div>          <div class="stat-icon">📊</div>

        </div>

      </div>          <div class="stat-content"><main class="main-content">    </div>

    </section>

  </div>            <span class="stat-label">คะแนนเฉลี่ย</span>

</main>

            <span class="stat-value" id="avg">-</span>  <div class="container">  </section>

<!-- Toast Notifications -->

<div id="toast" class="toast hidden"></div>            <span class="stat-unit">คะแนน</span>



<!-- Loading Overlay -->          </div>    <!-- คำอธิบายและตัวกรอง -->

<div id="globalLoading" class="global-loading hidden">

  <div class="loading-content">        </div>

    <div class="loading-spinner large"></div>

    <span>กำลังโหลดข้อมูล...</span>        <div class="stat-card" data-stat="median">    <section class="intro-section">  <section class="card">

  </div>

</div>          <div class="stat-icon">📏</div>



<script>          <div class="stat-content">      <div class="intro-card">    <h2 class="card-title">สถิติรวม</h2>

// ตัวแปรสำหรับเก็บ Chart instances

let barChart = null;            <span class="stat-label">ค่ามัธยฐาน</span>

let radarChart = null;

let donutChart = null;            <span class="stat-value" id="median">-</span>        <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>    <div class="stats" id="statsContainer">



// การจัดการ DOM elements            <span class="stat-unit">คะแนน</span>

const elements = {

  stats: {          </div>        <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>      <div><strong>เฉลี่ย:</strong> <span id="avg">-</span></div>

    avg: document.getElementById('avg'),

    median: document.getElementById('median'),        </div>

    std: document.getElementById('std'),

    count: document.getElementById('count')        <div class="stat-card" data-stat="std">      </div>      <div><strong>มัธยฐาน:</strong> <span id="median">-</span></div>

  },

  filters: {          <div class="stat-icon">📐</div>

    from: document.getElementById('from'),

    to: document.getElementById('to'),          <div class="stat-content">            <div><strong>ส่วนเบี่ยงเบน:</strong> <span id="std">-</span></div>

    respondent: document.getElementById('respondent')

  },            <span class="stat-label">ส่วนเบี่ยงเบนมาตรฐาน</span>

  suggestions: document.getElementById('suggestions'),

  suggestionsCount: document.getElementById('suggestionsCount'),            <span class="stat-value" id="std">-</span>      <div class="filters-card">      <div><strong>จำนวนแบบ:</strong> <span id="count">-</span></div>

  refreshBtn: document.getElementById('refreshBtn'),

  exportBtn: document.getElementById('exportCsv')            <span class="stat-unit">คะแนน</span>

};

          </div>        <h3>🔍 ตัวกรองข้อมูล</h3>    </div>

// ฟังก์ชันช่วยเหลือ

const formatNumber = (num) => {        </div>

  if (typeof num !== 'number' || !Number.isFinite(num)) return '-';

  return num.toLocaleString('th-TH', { maximumFractionDigits: 2 });        <div class="stat-card" data-stat="count">        <div class="filters-grid">  </section>

};

          <div class="stat-icon">📝</div>

const showToast = (message, type = 'info') => {

  const toast = document.getElementById('toast');          <div class="stat-content">          <div class="filter-group">

  toast.textContent = message;

  toast.className = `toast ${type}`;            <span class="stat-label">จำนวนผู้ตอบ</span>

  toast.classList.remove('hidden');

  toast.classList.add('show');            <span class="stat-value" id="count">-</span>            <label>📅 ช่วงเวลา เริ่ม</label>  <section class="card">

  setTimeout(() => {

    toast.classList.remove('show');            <span class="stat-unit">คน</span>

    setTimeout(() => toast.classList.add('hidden'), 400);

  }, 4000);          </div>            <input type="datetime-local" id="from" class="modern-input">    <h2 class="card-title">กราฟ</h2>

};

        </div>

const showGlobalLoading = () => {

  document.getElementById('globalLoading').classList.remove('hidden');      </div>          </div>    <div class="chart-grid">

};

    </section>

const hideGlobalLoading = () => {

  document.getElementById('globalLoading').classList.add('hidden');          <div class="filter-group">      <div class="chart-panel chart-panel-wide" id="barChartPanel">

};

    <!-- กราฟและแผนภูมิ -->

// ฟังก์ชันสำหรับอัพเดตสถิติ

const updateStats = (data) => {    <section class="charts-section">            <label>📅 ถึง</label>        <h3 class="chart-title">คะแนนเฉลี่ยต่อข้อ</h3>

  if (!data) return;

        <div class="charts-grid">

  elements.stats.avg.textContent = formatNumber(data.avg);

  elements.stats.median.textContent = formatNumber(data.median);        <!-- กราฟคะแนนเฉลี่ยต่อข้อ -->            <input type="datetime-local" id="to" class="modern-input">        <div class="chart-scroll">

  elements.stats.std.textContent = formatNumber(data.stddev);

  elements.stats.count.textContent = formatNumber(data.count);        <div class="chart-card chart-wide" id="barChartCard">

  

  // เพิ่ม animation          <div class="chart-header">          </div>          <canvas id="bar" width="800" height="260"></canvas>

  Object.values(elements.stats).forEach(el => {

    if (el && el.parentElement) {            <h4>📊 คะแนนเฉลี่ยต่อข้อ</h4>

      el.parentElement.classList.add('stat-updated');

      setTimeout(() => el.parentElement.classList.remove('stat-updated'), 600);          </div>          <div class="filter-group">        </div>

    }

  });          <div class="chart-container">

};

            <canvas id="barChart"></canvas>            <label>👥 ประเภทผู้ตอบ</label>      </div>

// ฟังก์ชันสำหรับสร้างกราฟแท่ง

const createBarChart = (data) => {          </div>

  const ctx = document.getElementById('barChart').getContext('2d');

          </div>            <select id="respondent" class="modern-select">      <div class="chart-panel" id="radarChartPanel">

  if (barChart) {

    barChart.destroy();

  }

          <!-- กราฟเรดาร์ -->              <option value="">ทั้งหมด</option>        <h3 class="chart-title">คะแนนเฉลี่ยตามมิติ</h3>

  if (!data || data.length === 0) {

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);        <div class="chart-card" id="radarChartCard">

    ctx.font = '16px Inter';

    ctx.fillStyle = '#64748b';          <div class="chart-header">              <option value="expert">ผู้ทรงคุณวุฒิ</option>        <canvas id="radar" width="420" height="260"></canvas>

    ctx.textAlign = 'center';

    ctx.fillText('📊 ไม่มีข้อมูลสำหรับแสดงผล', ctx.canvas.width/2, ctx.canvas.height/2);            <h4>🎯 คะแนนตามมิติ</h4>

    return;

  }          </div>              <option value="teacher">อาจารย์</option>      </div>

  

  barChart = new Chart(ctx, {          <div class="chart-container">

    type: 'bar',

    data: {            <canvas id="radarChart"></canvas>              <option value="committee">กรรมการ</option>      <div class="chart-panel" id="donutChartPanel">

      labels: data.map(item => item.code),

      datasets: [{          </div>

        label: 'คะแนนเฉลี่ย',

        data: data.map(item => item.avg),        </div>              <option value="student">นิสิต/นักศึกษา</option>        <h3 class="chart-title">สัดส่วนผู้ตอบ</h3>

        backgroundColor: 'rgba(99, 102, 241, 0.8)',

        borderColor: 'rgba(99, 102, 241, 1)',

        borderWidth: 2,

        borderRadius: 8,        <!-- กราฟโดนัท -->              <option value="other">อื่นๆ</option>        <canvas id="donut" width="320" height="220"></canvas>

        borderSkipped: false,

      }]        <div class="chart-card" id="donutChartCard">

    },

    options: {          <div class="chart-header">            </select>      </div>

      responsive: true,

      maintainAspectRatio: false,            <h4>🥧 สัดส่วนผู้ตอบ</h4>

      plugins: {

        legend: {          </div>          </div>    </div>

          display: false

        },          <div class="chart-container">

        tooltip: {

          backgroundColor: 'rgba(15, 23, 42, 0.9)',            <canvas id="donutChart"></canvas>          <div class="filter-actions">  </section>

          titleColor: '#f1f5f9',

          bodyColor: '#f1f5f9',          </div>

          borderColor: 'rgba(99, 102, 241, 0.5)',

          borderWidth: 1,        </div>            <button id="refreshBtn" class="btn btn-primary">

          cornerRadius: 8,

          callbacks: {      </div>

            label: function(context) {

              return `คะแนน: ${context.parsed.y.toFixed(2)}`;    </section>              <span>🔄</span> รีเฟรช  <section class="card">

            }

          }

        }

      },    <!-- ข้อเสนอแนะ -->            </button>    <h2 class="card-title">ข้อเสนอแนะ (ล่าสุด)</h2>

      scales: {

        y: {    <section class="suggestions-section">

          beginAtZero: true,

          max: 5,      <div class="suggestions-card">            <button id="exportCsv" class="btn btn-secondary">    <div id="suggestions" class="list"></div>

          grid: {

            color: 'rgba(148, 163, 184, 0.1)'        <div class="suggestions-header">

          },

          ticks: {          <h3>💭 ข้อเสนอแนะล่าสุด</h3>              <span>📊</span> Export CSV  </section>

            color: '#64748b',

            font: {          <span class="suggestions-count" id="suggestionsCount">0 รายการ</span>

              family: 'Inter'

            }        </div>            </button></main>

          }

        },        <div class="suggestions-container" id="suggestions">

        x: {

          grid: {          <div class="loading-suggestions">          </div><div id="toast" class="toast" hidden></div>

            display: false

          },            <div class="loading-spinner"></div>

          ticks: {

            color: '#64748b',            <span>กำลังโหลดข้อเสนอแนะ...</span>        </div><script src="/assets/js/app.js"></script>

            font: {

              family: 'Inter'          </div>

            },

            maxRotation: 45        </div>      </div><script>

          }

        }      </div>

      },

      animation: {    </section>    </section>const qs = (s)=>document.querySelector(s);

        duration: 1000,

        easing: 'easeOutQuart'  </div>

      }

    }</main>const qsa = (s)=>Array.from(document.querySelectorAll(s));

  });

};



// ฟังก์ชันสำหรับสร้างกราฟเรดาร์<!-- Toast Notifications -->    <!-- สถิติรวม -->const barCanvas = document.getElementById('bar');

const createRadarChart = (data) => {

  const ctx = document.getElementById('radarChart').getContext('2d');<div id="toast" class="toast hidden"></div>

  

  if (radarChart) {    <section class="stats-section">const radarCanvas = document.getElementById('radar');

    radarChart.destroy();

  }<!-- Loading Overlay -->

  

  const entries = Object.entries(data || {});<div id="globalLoading" class="global-loading hidden">      <h3>📈 สถิติสรุป</h3>const donutCanvas = document.getElementById('donut');

  if (entries.length === 0) {

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);  <div class="loading-content">

    ctx.font = '14px Inter';

    ctx.fillStyle = '#64748b';    <div class="loading-spinner large"></div>      <div class="stats-grid" id="statsContainer">const suggestionsBox = document.getElementById('suggestions');

    ctx.textAlign = 'center';

    ctx.fillText('🎯 ไม่มีข้อมูลมิติ', ctx.canvas.width/2, ctx.canvas.height/2);    <span>กำลังโหลดข้อมูล...</span>

    return;

  }  </div>        <div class="stat-card" data-stat="avg">if (suggestionsBox && !suggestionsBox.textContent.trim()) {

  

  radarChart = new Chart(ctx, {</div>

    type: 'radar',

    data: {          <div class="stat-icon">📊</div>  suggestionsBox.textContent = 'กำลังโหลด...';

      labels: entries.map(([label]) => label),

      datasets: [{<script>

        label: 'คะแนนเฉลี่ย',

        data: entries.map(([, value]) => value),// ตัวแปรสำหรับเก็บ Chart instances          <div class="stat-content">}

        fill: true,

        backgroundColor: 'rgba(139, 92, 246, 0.2)',let barChart = null;

        borderColor: 'rgba(139, 92, 246, 1)',

        pointBackgroundColor: 'rgba(139, 92, 246, 1)',let radarChart = null;            <span class="stat-label">คะแนนเฉลี่ย</span>

        pointBorderColor: '#fff',

        pointHoverBackgroundColor: '#fff',let donutChart = null;

        pointHoverBorderColor: 'rgba(139, 92, 246, 1)',

        borderWidth: 2,            <span class="stat-value" id="avg">-</span>const statsTargets = {

        pointRadius: 4

      }]// การจัดการ DOM elements

    },

    options: {const elements = {            <span class="stat-unit">คะแนน</span>  avg: qs('#avg'),

      responsive: true,

      maintainAspectRatio: false,  stats: {

      plugins: {

        legend: {    avg: document.getElementById('avg'),          </div>  median: qs('#median'),

          display: false

        }    median: document.getElementById('median'),

      },

      scales: {    std: document.getElementById('std'),        </div>  std: qs('#std'),

        r: {

          beginAtZero: true,    count: document.getElementById('count')

          max: 5,

          grid: {  },        <div class="stat-card" data-stat="median">  count: qs('#count')

            color: 'rgba(148, 163, 184, 0.2)'

          },  filters: {

          angleLines: {

            color: 'rgba(148, 163, 184, 0.2)'    from: document.getElementById('from'),          <div class="stat-icon">📏</div>};

          },

          pointLabels: {    to: document.getElementById('to'),

            color: '#475569',

            font: {    respondent: document.getElementById('respondent')          <div class="stat-content">

              family: 'Inter',

              size: 12  },

            }

          },  suggestions: document.getElementById('suggestions'),            <span class="stat-label">ค่ามัธยฐาน</span>const formatStat = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val.toFixed(2) : '-';

          ticks: {

            display: false  suggestionsCount: document.getElementById('suggestionsCount'),

          }

        }  refreshBtn: document.getElementById('refreshBtn'),            <span class="stat-value" id="median">-</span>const formatCount = (val)=> (typeof val === 'number' && Number.isFinite(val)) ? val : '-';

      },

      animation: {  exportBtn: document.getElementById('exportCsv')

        duration: 1200,

        easing: 'easeOutQuart'};            <span class="stat-unit">คะแนน</span>let statsErrorShown = false;

      }

    }

  });

};// ฟังก์ชันช่วยเหลือ          </div>let suggestionsErrorShown = false;



// ฟังก์ชันสำหรับสร้างกราฟโดนัทconst formatNumber = (num) => {

const createDonutChart = (data) => {

  const ctx = document.getElementById('donutChart').getContext('2d');  if (typeof num !== 'number' || !Number.isFinite(num)) return '-';        </div>

  

  if (donutChart) {  return num.toLocaleString('th-TH', { maximumFractionDigits: 2 });

    donutChart.destroy();

  }};        <div class="stat-card" data-stat="std">const filters = ()=>({

  

  const entries = Object.entries(data || {}).filter(([, value]) => value > 0);

  if (entries.length === 0) {

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);const showToast = (message, type = 'info') => {          <div class="stat-icon">📐</div>  from: qs('#from')?.value || '',

    ctx.font = '14px Inter';

    ctx.fillStyle = '#64748b';  const toast = document.getElementById('toast');

    ctx.textAlign = 'center';

    ctx.fillText('🥧 ไม่มีข้อมูลผู้ตอบ', ctx.canvas.width/2, ctx.canvas.height/2);  toast.textContent = message;          <div class="stat-content">  to: qs('#to')?.value || '',

    return;

  }  toast.className = `toast ${type}`;

  

  const colors = [  toast.classList.remove('hidden');            <span class="stat-label">ส่วนเบี่ยงเบนมาตรฐาน</span>  respondent: qs('#respondent')?.value || ''

    'rgba(239, 68, 68, 0.8)',

    'rgba(245, 158, 11, 0.8)',  toast.classList.add('show');

    'rgba(34, 197, 94, 0.8)',

    'rgba(59, 130, 246, 0.8)',  setTimeout(() => {            <span class="stat-value" id="std">-</span>});

    'rgba(139, 92, 246, 0.8)',

    'rgba(236, 72, 153, 0.8)'    toast.classList.remove('show');

  ];

      setTimeout(() => toast.classList.add('hidden'), 400);            <span class="stat-unit">คะแนน</span>

  donutChart = new Chart(ctx, {

    type: 'doughnut',  }, 4000);

    data: {

      labels: entries.map(([label]) => label),};          </div>function applySummary(summary){

      datasets: [{

        data: entries.map(([, value]) => value),

        backgroundColor: colors.slice(0, entries.length),

        borderColor: colors.slice(0, entries.length).map(color => color.replace('0.8', '1')),const showGlobalLoading = () => {        </div>  if (statsTargets.avg) statsTargets.avg.textContent = formatStat(summary.avg);

        borderWidth: 2,

        hoverOffset: 4  document.getElementById('globalLoading').classList.remove('hidden');

      }]

    },};        <div class="stat-card" data-stat="count">  if (statsTargets.median) statsTargets.median.textContent = formatStat(summary.median);

    options: {

      responsive: true,

      maintainAspectRatio: false,

      plugins: {const hideGlobalLoading = () => {          <div class="stat-icon">📝</div>  if (statsTargets.std) statsTargets.std.textContent = formatStat(summary.stddev);

        legend: {

          position: 'bottom',  document.getElementById('globalLoading').classList.add('hidden');

          labels: {

            color: '#475569',};          <div class="stat-content">  if (statsTargets.count) statsTargets.count.textContent = formatCount(summary.count);

            font: {

              family: 'Inter',

              size: 12

            },// ฟังก์ชันสำหรับอัพเดตสถิติ            <span class="stat-label">จำนวนผู้ตอบ</span>}

            padding: 15,

            usePointStyle: trueconst updateStats = (data) => {

          }

        },  if (!data) return;            <span class="stat-value" id="count">-</span>

        tooltip: {

          backgroundColor: 'rgba(15, 23, 42, 0.9)',  

          titleColor: '#f1f5f9',

          bodyColor: '#f1f5f9',  elements.stats.avg.textContent = formatNumber(data.avg);            <span class="stat-unit">คน</span>function resetSummary(){

          borderColor: 'rgba(148, 163, 184, 0.5)',

          borderWidth: 1,  elements.stats.median.textContent = formatNumber(data.median);

          cornerRadius: 8

        }  elements.stats.std.textContent = formatNumber(data.stddev);          </div>  Object.values(statsTargets).forEach(el=>{ if (el) el.textContent = '-'; });

      },

      animation: {  elements.stats.count.textContent = formatNumber(data.count);

        duration: 1000,

        easing: 'easeOutQuart'          </div>}

      }

    }  // เพิ่ม animation

  });

};  Object.values(elements.stats).forEach(el => {      </div>



// ฟังก์ชันโหลดข้อมูลสถิติ    if (el && el.parentElement) {

const loadStats = async () => {

  try {      el.parentElement.classList.add('stat-updated');    </section>function chartMessage(ctx, message, width, height){

    showGlobalLoading();

          setTimeout(() => el.parentElement.classList.remove('stat-updated'), 600);

    const params = new URLSearchParams({

      from: elements.filters.from.value || '',    }  ctx.clearRect(0,0,width,height);

      to: elements.filters.to.value || '',

      respondent: elements.filters.respondent.value || ''  });

    });

    };    <!-- กราฟและแผนภูมิ -->  ctx.save();

    const response = await fetch(`/public/api/dashboard_stats.php?${params}`, {

      cache: 'no-store'

    });

    // ฟังก์ชันสำหรับสร้างกราฟแท่ง    <section class="charts-section">  ctx.fillStyle = '#94a3b8';

    const data = await response.json();

    const createBarChart = (data) => {

    if (!response.ok || !data.ok) {

      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อมูล');  const ctx = document.getElementById('barChart').getContext('2d');      <div class="charts-grid">  ctx.font = '14px system-ui';

    }

      

    // อัพเดตสถิติ

    updateStats(data.summary);  if (barChart) {        <!-- กราฟคะแนนเฉลี่ยต่อข้อ -->  ctx.textAlign = 'center';

    

    // สร้างกราฟ    barChart.destroy();

    createBarChart(data.items || []);

    createRadarChart(data.dimensions || {});  }        <div class="chart-card chart-wide" id="barChartCard">  ctx.textBaseline = 'middle';

    createDonutChart(data.respondents || {});

      

    showToast('ข้อมูลได้รับการอัพเดตเรียบร้อยแล้ว', 'success');

      if (!data || data.length === 0) {          <div class="chart-header">  ctx.fillText(message, width/2, height/2);

  } catch (error) {

    showToast(`เกิดข้อผิดพลาด: ${error.message}`, 'error');    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    console.error('Error loading stats:', error);

  } finally {    ctx.font = '16px Inter';            <h4>📊 คะแนนเฉลี่ยต่อข้อ</h4>  ctx.restore();

    hideGlobalLoading();

  }    ctx.fillStyle = '#64748b';

};

    ctx.textAlign = 'center';            <div class="chart-controls">}

// ฟังก์ชันโหลดข้อเสนอแนะ

const loadSuggestions = async () => {    ctx.fillText('📊 ไม่มีข้อมูลสำหรับแสดงผล', ctx.canvas.width/2, ctx.canvas.height/2);

  try {

    const params = new URLSearchParams({    return;              <button class="chart-btn" onclick="toggleChartView('bar')">📱</button>

      from: elements.filters.from.value || '',

      to: elements.filters.to.value || '',  }

      respondent: elements.filters.respondent.value || ''

    });              </div>function showLoading(container) {

    

    const response = await fetch(`/api/suggestions.php?${params}`, {  barChart = new Chart(ctx, {

      cache: 'no-store'

    });    type: 'bar',          </div>  if (!container) return;

    

    const data = await response.json();    data: {

    

    if (!response.ok || !data.ok) {      labels: data.map(item => item.code),          <div class="chart-container">  const overlay = document.createElement('div');

      throw new Error(data.error || 'เกิดข้อผิดพลาดในการโหลดข้อเสนอแนะ');

    }      datasets: [{

    

    const suggestions = data.data || [];        label: 'คะแนนเฉลี่ย',            <canvas id="barChart"></canvas>  overlay.className = 'loading-overlay';

    elements.suggestionsCount.textContent = `${suggestions.length} รายการ`;

            data: data.map(item => item.avg),

    if (suggestions.length === 0) {

      elements.suggestions.innerHTML = `        backgroundColor: 'rgba(99, 102, 241, 0.8)',          </div>  overlay.innerHTML = '<div class="loading-text"><div class="loading-spinner"></div>กำลังโหลด...</div>';

        <div class="no-suggestions">

          <div class="no-suggestions-icon">💭</div>        borderColor: 'rgba(99, 102, 241, 1)',

          <p>ยังไม่มีข้อเสนอแนะ</p>

        </div>        borderWidth: 2,        </div>  container.style.position = 'relative';

      `;

      return;        borderRadius: 8,

    }

            borderSkipped: false,  container.appendChild(overlay);

    elements.suggestions.innerHTML = suggestions.slice(0, 20).map(item => `

      <div class="suggestion-item">      }]

        <div class="suggestion-meta">

          <span class="suggestion-type">${item.respondent_type || 'ไม่ระบุ'}</span>    },        <!-- กราฟเรดาร์ -->}

          <span class="suggestion-time">${new Date(item.created_at || Date.now()).toLocaleDateString('th-TH')}</span>

        </div>    options: {

        <div class="suggestion-text">${item.suggestion || ''}</div>

      </div>      responsive: true,        <div class="chart-card" id="radarChartCard">

    `).join('');

          maintainAspectRatio: false,

  } catch (error) {

    elements.suggestions.innerHTML = `      plugins: {          <div class="chart-header">function hideLoading(container) {

      <div class="error-suggestions">

        <div class="error-icon">⚠️</div>        legend: {

        <p>ไม่สามารถโหลดข้อเสนอแนะได้</p>

      </div>          display: false            <h4>🎯 คะแนนตามมิติ</h4>  if (!container) return;

    `;

    console.error('Error loading suggestions:', error);        },

  }

};        tooltip: {          </div>  const overlay = container.querySelector('.loading-overlay');



// Event Listeners          backgroundColor: 'rgba(15, 23, 42, 0.9)',

if (elements.refreshBtn) {

  elements.refreshBtn.addEventListener('click', () => {          titleColor: '#f1f5f9',          <div class="chart-container">  if (overlay) {

    loadStats();

    loadSuggestions();          bodyColor: '#f1f5f9',

  });

}          borderColor: 'rgba(99, 102, 241, 0.5)',            <canvas id="radarChart"></canvas>    overlay.style.opacity = '0';



if (elements.exportBtn) {          borderWidth: 1,

  elements.exportBtn.addEventListener('click', () => {

    const params = new URLSearchParams({          cornerRadius: 8,          </div>    setTimeout(() => overlay.remove(), 200);

      from: elements.filters.from.value || '',

      to: elements.filters.to.value || '',          callbacks: {

      respondent: elements.filters.respondent.value || ''

    });            label: function(context) {        </div>  }

    window.open(`/api/export_csv.php?${params}`, '_blank');

  });              return `คะแนน: ${context.parsed.y.toFixed(2)}`;

}

            }}

// เมื่อมีการเปลี่ยนแปลงตัวกรอง

[elements.filters.from, elements.filters.to, elements.filters.respondent].forEach(element => {          }

  if (element) {

    element.addEventListener('change', () => {        }        <!-- กราฟโดนัท -->

      loadStats();

      loadSuggestions();      },

    });

  }      scales: {        <div class="chart-card" id="donutChartCard">function showSkeletonStats() {

});

        y: {

// Theme toggle

const themeToggle = document.getElementById('themeToggle');          beginAtZero: true,          <div class="chart-header">  const statsContainer = document.getElementById('statsContainer');

if (themeToggle) {

  themeToggle.addEventListener('click', () => {          max: 5,

    const html = document.documentElement;

    const isDark = html.classList.contains('theme-dark');          grid: {            <h4>🥧 สัดส่วนผู้ตอบ</h4>  if (!statsContainer) return;

    

    if (isDark) {            color: 'rgba(148, 163, 184, 0.1)'

      html.classList.remove('theme-dark');

      html.classList.add('theme-light');          },          </div>  statsContainer.classList.add('skeleton');

      document.querySelector('[data-icon-sun]').classList.remove('hidden');

      document.querySelector('[data-icon-moon]').classList.add('hidden');          ticks: {

    } else {

      html.classList.remove('theme-light');            color: '#64748b',          <div class="chart-container">}

      html.classList.add('theme-dark');

      document.querySelector('[data-icon-sun]').classList.add('hidden');            font: {

      document.querySelector('[data-icon-moon]').classList.remove('hidden');

    }              family: 'Inter'            <canvas id="donutChart"></canvas>

  });

}            }



// โหลดข้อมูลครั้งแรก          }          </div>function hideSkeletonStats() {

document.addEventListener('DOMContentLoaded', () => {

  loadStats();        },

  loadSuggestions();

          x: {        </div>  const statsContainer = document.getElementById('statsContainer');

  // รีเฟรชอัตโนมัติทุก 30 วินาที

  setInterval(() => {          grid: {

    loadStats();

    loadSuggestions();            display: false      </div>  if (!statsContainer) return;

  }, 30000);

});          },

</script>

</body>          ticks: {    </section>  statsContainer.classList.remove('skeleton');

</html>
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