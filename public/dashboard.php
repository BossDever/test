<?php
require_once __DIR__ . '/bootstrap.php';

$u = current_user();
if (!$u || !in_array($u['role'], ['admin', 'teacher', 'committee'], true)) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}
?>
<!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>📊 แดชบอร์ดสรุปผล</title>
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header class="modern-header">
    <div class="container">
      <div class="header-content">
        <div class="brand">
          <span class="brand-icon">📊</span>
          <h1>แดชบอร์ดสรุปผล</h1>
        </div>
        <nav class="header-nav">
          <a class="nav-btn" href="/index.php">
            <span>📝</span> หน้าแบบประเมิน
          </a>
          <form method="post" action="/logout.php" class="inline">
            <?= csrf_token_input() ?>
            <button class="nav-btn logout" type="submit">
              <span>🚪</span> ออกจากระบบ
            </button>
          </form>
          <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
            <span class="icon" data-icon-sun>☀️</span>
            <span class="icon" data-icon-moon hidden>🌙</span>
          </button>
        </nav>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="container">
      <section class="intro-section">
        <div class="intro-card">
          <h2>ยินดีต้อนรับสู่แดชบอร์ด</h2>
          <p>สรุปข้อมูลและวิเคราะห์ผลการประเมินแบบเรียลไทม์</p>
        </div>
        <div class="filters-card">
          <h3>🔍 ตัวกรองข้อมูล</h3>
          <div class="filters-grid">
            <div class="filter-group">
              <label>📅 ช่วงเวลา เริ่ม</label>
              <input type="datetime-local" id="from" class="modern-input">
            </div>
            <div class="filter-group">
              <label>📅 ถึง</label>
              <input type="datetime-local" id="to" class="modern-input">
            </div>
            <div class="filter-group">
              <label>👥 ประเภทผู้ตอบ</label>
              <select id="respondent" class="modern-select">
                <option value="">ทั้งหมด</option>
                <option value="expert">ผู้ทรงคุณวุฒิ</option>
                <option value="teacher">อาจารย์</option>
                <option value="committee">กรรมการ</option>
                <option value="student">นิสิต/นักศึกษา</option>
                <option value="other">อื่นๆ</option>
              </select>
            </div>
            <div class="filter-actions">
              <button id="refreshBtn" class="btn btn-primary">
                <span>🔄</span> รีเฟรช
              </button>
              <button id="exportCsv" class="btn btn-secondary">
                <span>📊</span> Export CSV
              </button>
            </div>
          </div>
        </div>
      </section>

      <section class="stats-section">
        <h3>📈 สถิติสรุป</h3>
        <div class="stats-grid" id="statsContainer">
          <div class="stat-card" data-stat="avg">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
              <span class="stat-label">คะแนนเฉลี่ย</span>
              <span class="stat-value" id="avg">-</span>
              <span class="stat-unit">คะแนน</span>
            </div>
          </div>
          <div class="stat-card" data-stat="median">
            <div class="stat-icon">📏</div>
            <div class="stat-content">
              <span class="stat-label">มัธยฐาน</span>
              <span class="stat-value" id="median">-</span>
              <span class="stat-unit">คะแนน</span>
            </div>
          </div>
          <div class="stat-card" data-stat="count">
            <div class="stat-icon">🧮</div>
            <div class="stat-content">
              <span class="stat-label">จำนวนแบบประเมิน</span>
              <span class="stat-value" id="count">-</span>
              <span class="stat-unit">ฉบับ</span>
            </div>
          </div>
          <div class="stat-card" data-stat="lastUpdate">
            <div class="stat-icon">⏱️</div>
            <div class="stat-content">
              <span class="stat-label">อัปเดตล่าสุด</span>
              <span class="stat-value" id="lastUpdate">-</span>
            </div>
          </div>
        </div>
      </section>

      <section class="charts-section">
        <div class="chart-card">
          <div class="chart-header">
            <h3>คะแนนเฉลี่ยต่อข้อ</h3>
          </div>
          <div class="chart-body">
            <canvas id="barChart"></canvas>
          </div>
        </div>
        <div class="chart-card">
          <div class="chart-header">
            <h3>เรดาร์คะแนน</h3>
          </div>
          <div class="chart-body">
            <canvas id="radarChart"></canvas>
          </div>
        </div>
        <div class="chart-card">
          <div class="chart-header">
            <h3>สัดส่วนระดับคะแนน</h3>
          </div>
          <div class="chart-body">
            <canvas id="donutChart"></canvas>
          </div>
        </div>
      </section>

      <section class="suggestions-section">
        <h3>💡 ข้อเสนอแนะ</h3>
        <ul class="suggestions-list" id="suggestionsList"></ul>
      </section>
    </div>
  </main>

  <div id="globalLoading" class="loading-overlay" hidden>
    <div class="spinner"></div>
  </div>
  <div id="toast" class="toast" hidden></div>

  <script>
    const qs = (s, el=document) => el.querySelector(s);
    const qsa = (s, el=document) => Array.from(el.querySelectorAll(s));
    const $ = {
      from: qs('#from'),
      to: qs('#to'),
      respondent: qs('#respondent'),
      refresh: qs('#refreshBtn'),
      exportCsv: qs('#exportCsv'),
      stats: {
        avg: qs('#avg'),
        median: qs('#median'),
        count: qs('#count'),
        lastUpdate: qs('#lastUpdate')
      },
      list: qs('#suggestionsList'),
      loading: qs('#globalLoading'),
      toast: qs('#toast'),
      themeToggle: qs('#themeToggle')
    };

    const showLoading = (v=true)=> $.loading.hidden = !v;
    const showToast = (msg, type='info') => {
      $.toast.textContent = msg;
      $.toast.dataset.type = type;
      $.toast.hidden = false;
      setTimeout(()=> $.toast.hidden = true, 2500);
    };

    let charts = { bar:null, radar:null, donut:null };

    function getParams() {
      const p = new URLSearchParams();
      if ($.from.value) p.set('from', $.from.value);
      if ($.to.value) p.set('to', $.to.value);
      if ($.respondent.value) p.set('respondent', $.respondent.value);
      return p.toString();
    }

    async function fetchJSON(url) {
      const r = await fetch(url, { headers: { 'Accept': 'application/json' }});
      if (!r.ok) throw new Error('Network error '+r.status);
      return r.json();
    }

    function updateStats(data) {
      $.stats.avg.textContent = data.avg?.toFixed?.(2) ?? '-';
      $.stats.median.textContent = data.median?.toFixed?.(2) ?? '-';
      $.stats.count.textContent = data.count ?? '-';
      $.stats.lastUpdate.textContent = data.lastUpdate ?? '-';
    }

    function ensureChart(ctxId, type, data, options) {
      if (charts[type]) charts[type].destroy();
      const ctx = document.getElementById(ctxId).getContext('2d');
      charts[type] = new Chart(ctx, { type, data, options });
    }

    function buildBar(labels, values) {
      ensureChart('barChart', 'bar', {
        labels,
        datasets: [{
          label: 'คะแนนเฉลี่ย',
          data: values,
          backgroundColor: 'rgba(99, 102, 241, 0.6)'
        }]
      }, {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { ticks: { autoSkip: false, maxRotation: 45, minRotation: 0 } },
          y: { beginAtZero: true, max: 5 }
        },
        plugins: { legend: { display: false } }
      });
    }

    function buildRadar(labels, values) {
      ensureChart('radarChart', 'radar', {
        labels,
        datasets: [{
          label: 'เรดาร์คะแนน',
          data: values,
          backgroundColor: 'rgba(16, 185, 129, 0.3)',
          borderColor: 'rgba(16, 185, 129, 1)'
        }]
      }, {
        responsive: true,
        maintainAspectRatio: false,
        scales: { r: { beginAtZero: true, max: 5 } }
      });
    }

    function buildDonut(labels, values) {
      ensureChart('donutChart', 'doughnut', {
        labels,
        datasets: [{
          label: 'สัดส่วนคะแนน',
          data: values,
          backgroundColor: [
            '#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa'
          ]
        }]
      }, {
        responsive: true,
        maintainAspectRatio: false,
      });
    }

    async function loadAll() {
      try {
        showLoading(true);
        const params = getParams();
        const stats = await fetchJSON(`/api/dashboard_stats.php${params ? '?' + params : ''}`);
        updateStats(stats);

        if (Array.isArray(stats.avg_per_question_labels) && Array.isArray(stats.avg_per_question_values)) {
          buildBar(stats.avg_per_question_labels, stats.avg_per_question_values);
        }
        if (Array.isArray(stats.radar_labels) && Array.isArray(stats.radar_values)) {
          buildRadar(stats.radar_labels, stats.radar_values);
        }
        if (Array.isArray(stats.donut_labels) && Array.isArray(stats.donut_values)) {
          buildDonut(stats.donut_labels, stats.donut_values);
        }

        const sugg = await fetchJSON(`/api/suggestions.php${params ? '?' + params : ''}`);
        $.list.innerHTML = '';
        if (Array.isArray(sugg) && sugg.length) {
          for (const s of sugg) {
            const li = document.createElement('li');
            li.className = 'suggestion-item';
            li.textContent = s.comment ?? String(s);
            $.list.appendChild(li);
          }
        } else {
          const li = document.createElement('li');
          li.className = 'suggestion-item empty';
          li.textContent = 'ไม่มีข้อเสนอแนะ';
          $.list.appendChild(li);
        }
      } catch (e) {
        console.error(e);
        showToast('โหลดข้อมูลไม่สำเร็จ', 'error');
      } finally {
        showLoading(false);
      }
    }

    $.refresh.addEventListener('click', (e)=> { e.preventDefault(); loadAll(); });
    $.exportCsv.addEventListener('click', (e)=> {
      e.preventDefault();
      const params = getParams();
      window.location.href = `/api/export_csv.php${params ? '?' + params : ''}`;
    });

    $.themeToggle.addEventListener('click', ()=>{
      const html = document.documentElement;
      const isLight = html.classList.contains('theme-light');
      html.classList.toggle('theme-light', !isLight);
      html.classList.toggle('theme-dark', isLight);
    });

    loadAll();
    setInterval(loadAll, 30000);
  </script>
</body>
</html>