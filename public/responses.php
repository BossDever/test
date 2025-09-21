<?php
require_once __DIR__ . '/bootstrap.php';
$u = current_user();
if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) { http_response_code(403); echo 'Forbidden'; exit; }
?><!doctype html>
<html lang="th" class="theme-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Responses Explorer</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="topbar">
  <div class="brand">Responses Explorer</div>
  <nav>
    <a class="btn" href="/dashboard.php">แดชบอร์ด</a>
    <a class="btn" href="/index.php">หน้าแบบประเมิน</a>
    <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">
      <span class="icon" data-icon-sun>☀</span>
      <span class="icon" data-icon-moon hidden>🌙</span>
    </button>
  </nav>
 </header>

<main class="container">
  <section class="card">
    <div class="filters">
      <label>เริ่ม <input type="datetime-local" id="from"></label>
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
      <button id="reload" class="btn">โหลด</button>
    </div>
  </section>

  <section class="card">
    <h2 class="card-title">ผลลัพธ์</h2>
    <div id="list"></div>
    <div id="pager" class="actions" style="margin-top:12px;"></div>
  </section>
  <section class="card" id="detailCard" style="display:none;"></section>
</main>
<div id="toast" class="toast" hidden></div>
<script src="/assets/js/app.js"></script>
<script>
const qs = s=>document.querySelector(s);
const filters = ()=>({ from: qs('#from').value, to: qs('#to').value, respondent: qs('#respondent').value });
let page=1, size=20;

async function load(){
  const p = new URLSearchParams({...filters(), page, size});
  const res = await fetch('/api/responses.php?'+p.toString());
  const data = await res.json();
  if(!data.ok){ showToast('โหลดข้อมูลล้มเหลว','error'); return; }
  const list = qs('#list'); list.innerHTML='';
  if(!data.data.length){ list.textContent='— ไม่มีข้อมูล —'; qs('#pager').innerHTML=''; return; }
  const table = document.createElement('table'); table.className='table';
  table.innerHTML = '<thead><tr><th>ID</th><th>เวลา</th><th>ประเภท</th><th></th></tr></thead><tbody></tbody>';
  data.data.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.submitted_at}</td><td>${r.respondent_type||'-'}</td><td><button class="btn" data-id="${r.id}">ดูรายละเอียด</button></td>`;
    table.querySelector('tbody').appendChild(tr);
  });
  table.addEventListener('click', async (e)=>{
    const b = e.target.closest('button[data-id]');
    if(!b) return; const id = b.getAttribute('data-id');
    const res = await fetch('/api/response_detail.php?id='+id);
    const d = await res.json();
    if(!d.ok){ showToast('โหลดรายละเอียดล้มเหลว','error'); return; }
    const card = qs('#detailCard'); card.style.display='block';
    const ans = d.answers.map(a=>{
      let v = a.value_likert ?? a.value_text ?? (a.value_bool==null? '' : (a.value_bool? 'Yes' : 'No'));
      return `<div class="list-item"><strong>${a.item_code}</strong> ${a.q_text}<div>คำตอบ: ${v}</div></div>`;
    }).join('');
    const sug = d.suggestion && d.suggestion.suggestion ? `<div class="list-item"><strong>ข้อเสนอแนะ:</strong> ${d.suggestion.suggestion}</div>` : '';
    card.innerHTML = `<h2 class="card-title">Response #${d.response.id} — ${d.response.respondent_type||'-'} — ${d.response.submitted_at}</h2>${ans}${sug}`;
    card.scrollIntoView({behavior:'smooth'});
  });
  list.appendChild(table);
  // pager
  const pages = Math.ceil(data.total/size);
  const pager = qs('#pager');
  pager.innerHTML = '';
  if (pages>1){
    for(let i=1;i<=pages;i++){
      const a = document.createElement('button');
      a.className = 'btn' + (i===page? ' active': '');
      a.textContent = i;
      a.addEventListener('click', ()=>{ page=i; load(); });
      pager.appendChild(a);
    }
  }
}
qs('#reload').addEventListener('click', ()=>{ page=1; load(); });
load();
</script>
</body>
</html>
