(function(){
  // Ensure a global showToast exists as early as possible
  if (typeof window.showToast !== 'function') {
    window.showToast = function(msg, type){
      try {
        const t = document.getElementById('toast');
        if (t){
          t.textContent = msg;
          t.className = 'toast show ' + (type||'');
          t.hidden = false;
          setTimeout(()=>{ t.classList.remove('show'); t.hidden = true; }, 2500);
        } else {
          alert(msg);
        }
      } catch (_) { alert(msg); }
    };
  }

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

  // toast (ensure defined even if earlier shim set it)
  window.showToast = window.showToast || function(msg, type){
    if (!toastEl) return alert(msg);
    toastEl.textContent = msg;
    toastEl.className = 'toast show ' + (type||'');
    toastEl.hidden = false;
    setTimeout(()=>{ toastEl.classList.remove('show'); toastEl.hidden = true; }, 2500);
  };

  // Safely wrap a global AnimationManager.createRipple if present to avoid errors
  function safeWrapRipple(){
    const am = window.AnimationManager;
    if (!am || typeof am.createRipple !== 'function' || am.__rippleWrapped) return;
    const original = am.createRipple;
    am.createRipple = function(){
      try {
        // Support signatures: (event) or (el, event)
        let target = null, ev = null;
        if (arguments[0] && arguments[0].target) { // looks like an Event
          ev = arguments[0];
          target = ev.target && ev.target.closest ? ev.target.closest('button, .btn, [data-ripple]') : null;
        } else {
          target = arguments[0];
          ev = arguments[1] && arguments[1].target ? arguments[1] : null;
          if (target && target.closest && !(target.matches && (target.matches('button, .btn, [data-ripple]')))) {
            target = target.closest('button, .btn, [data-ripple]');
          }
        }
        if (!target || typeof target.getBoundingClientRect !== 'function') {
          return; // nothing to do, avoid throwing
        }
        return original.apply(this, [target, ev]);
      } catch (e) {
        // swallow to avoid breaking clicks
        return;
      }
    };
    am.__rippleWrapped = true;
  }
  // try early and a bit later (in case lib loads after this script)
  safeWrapRipple();
  document.addEventListener('DOMContentLoaded', safeWrapRipple, { once: true });
  setTimeout(safeWrapRipple, 0);
  setTimeout(safeWrapRipple, 500);
})();
