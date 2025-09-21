(function(){
  const html = document.documentElement;
  const toastEl = document.getElementById('toast');

  // theme load
  const saved = localStorage.getItem('theme') || 'light';
  if (saved === 'dark') html.classList.remove('theme-light'), html.classList.add('theme-dark');
  else html.classList.remove('theme-dark'), html.classList.add('theme-light');
  updateThemeIcon();

  const btn = document.getElementById('themeToggle');
  if (btn) btn.addEventListener('click', ()=>{
    html.classList.toggle('theme-dark');
    html.classList.toggle('theme-light');
    const isDark = html.classList.contains('theme-dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcon();
    fixSelectColors();
  });

  function updateThemeIcon(){
    const sun = document.querySelector('[data-icon-sun]');
    const moon = document.querySelector('[data-icon-moon]');
    const dark = html.classList.contains('theme-dark');
    if (sun && moon){ sun.hidden = dark; moon.hidden = !dark; }
  }

  // Dropdown visibility fix in dark
  function fixSelectColors(){
    const dark = html.classList.contains('theme-dark');
    document.querySelectorAll('select').forEach(sel=>{
      if (dark){ sel.style.background = '#111827'; sel.style.color = '#e5e7eb'; sel.style.borderColor = '#374151'; }
      else { sel.style.background = ''; sel.style.color = ''; sel.style.borderColor = ''; }
    });
  }
  fixSelectColors();

  // toast
  window.showToast = function(msg, type){
    if (!toastEl) return alert(msg);
    toastEl.textContent = msg;
    toastEl.className = 'toast show ' + (type||'');
    toastEl.hidden = false;
    setTimeout(()=>{ toastEl.classList.remove('show'); toastEl.hidden = true; }, 2500);
  }
})();
