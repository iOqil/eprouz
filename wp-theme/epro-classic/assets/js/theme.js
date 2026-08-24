/*
 * EPRO — Classic: interactivity.
 * Dark-mode toggle, mobile menu, dropdowns, pricing billing switch.
 * Vanilla JS, no dependencies.
 */
(function () {
  'use strict';

  /* ---- Dark mode ------------------------------------------------------- */
  document.querySelectorAll('[data-epro-theme-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var root = document.documentElement;
      var isDark = root.classList.toggle('dark');
      try {
        localStorage.setItem('epro-theme', isDark ? 'dark' : 'light');
      } catch (e) {}
    });
  });

  /* ---- Mobile menu ----------------------------------------------------- */
  var mobileToggle = document.querySelector('[data-epro-mobile-toggle]');
  var mobileMenu = document.querySelector('[data-epro-mobile-menu]');
  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', function () {
      mobileMenu.classList.toggle('hidden');
    });
    mobileMenu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
      });
    });
  }

  /* ---- Dropdowns (language switcher) ----------------------------------- */
  document.querySelectorAll('[data-epro-dropdown]').forEach(function (wrap) {
    var toggle = wrap.querySelector('[data-epro-dropdown-toggle]');
    var menu = wrap.querySelector('[data-epro-dropdown-menu]');
    if (!toggle || !menu) return;
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = menu.classList.toggle('hidden');
      toggle.setAttribute('aria-expanded', String(!open));
    });
  });
  document.addEventListener('click', function () {
    document.querySelectorAll('[data-epro-dropdown-menu]').forEach(function (m) {
      m.classList.add('hidden');
    });
  });

  /* ---- Pricing billing toggle ------------------------------------------ */
  function initBilling(scope) {
    var root = scope || document;
    var billing = root.querySelector('[data-epro-billing]');
    if (!billing || billing.dataset.eproBound === '1') return;
    billing.dataset.eproBound = '1';

    var buttons = billing.querySelectorAll('[data-billing]');
    var setMode = function (mode) {
      buttons.forEach(function (b) {
        var active = b.getAttribute('data-billing') === mode;
        b.setAttribute('aria-pressed', String(active));
        b.classList.toggle('bg-white', active);
        b.classList.toggle('dark:bg-neutral-800', active);
        b.classList.toggle('shadow', active);
        b.classList.toggle('text-neutral-900', active);
        b.classList.toggle('dark:text-white', active);
        b.classList.toggle('text-neutral-600', !active);
        b.classList.toggle('dark:text-neutral-400', !active);
      });
      document.querySelectorAll('[data-price]').forEach(function (el) {
        el.textContent = el.getAttribute('data-' + mode);
      });
      document.querySelectorAll('[data-yearly-hint]').forEach(function (el) {
        el.classList.toggle('hidden', mode !== 'yearly');
      });
    };

    buttons.forEach(function (b) {
      b.addEventListener('click', function () {
        setMode(b.getAttribute('data-billing'));
      });
    });
    setMode('monthly');
  }
  initBilling();

  // Re-bind after a Customizer selective refresh so the preview stays live.
  if (window.wp && wp.customize && wp.customize.selectiveRefresh) {
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
      initBilling(placement && placement.container ? placement.container[0] : document);
    });
  }
})();
