import './bootstrap';
import 'sweetalert2/dist/sweetalert2.min.css';
import './utils/action-handler';
import './components/management-common';
import './components/maintenance-management';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// Enhance UX globally
document.addEventListener('DOMContentLoaded', () => {
  // Keyboard: '/' focuses first search input
  window.addEventListener('keydown', (e) => {
    if (e.key === '/' && !['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) {
      const search = document.querySelector('input[name="search"], input[type="search"]');
      if (search) {
        e.preventDefault();
        search.focus();
      }
    }
    // 'n' to create if there's a data-new-url button/link
    if (e.key.toLowerCase() === 'n' && !['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) {
      const newBtn = document.querySelector('[data-new-url]');
      if (newBtn) {
        e.preventDefault();
        window.location.href = newBtn.getAttribute('data-new-url');
      }
    }
  });

  // Row click / double-click helpers
  document.querySelectorAll('tr[data-view-url]').forEach((row) => {
    row.addEventListener('click', (e) => {
      // Ignore clicks on interactive elements
      const t = e.target;
      if (t.closest('a,button,input,select,label,svg')) return;
      const url = row.getAttribute('data-view-url');
      if (url) window.location.href = url;
    });
    row.addEventListener('dblclick', () => {
      const edit = row.getAttribute('data-edit-url');
      if (edit) window.location.href = edit;
    });
    row.classList.add('cursor-pointer');
  });

  // Persist filters (forms with data-persist="true")
  document.querySelectorAll('form[data-persist="true"]').forEach((form) => {
    const key = 'filters:' + (form.getAttribute('action') || window.location.pathname);
    // Restore
    try {
      const saved = JSON.parse(localStorage.getItem(key) || '{}');
      Object.entries(saved).forEach(([name, value]) => {
        const el = form.querySelector(`[name="${name}"]`);
        if (el && !new URLSearchParams(window.location.search).has(name)) {
          el.value = value;
        }
      });
    } catch {}
    // Save on submit
    form.addEventListener('submit', () => {
      const data = {};
      Array.from(new FormData(form).entries()).forEach(([k, v]) => { data[k] = v; });
      localStorage.setItem(key, JSON.stringify(data));
    });
  });
});
