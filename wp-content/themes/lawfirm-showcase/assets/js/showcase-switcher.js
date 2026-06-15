/* showcase-switcher.js — Live template switcher for client demos */
(function () {
  'use strict';

  const TEMPLATE_MAP = {
    obsidian: 't01-obsidian.css',
    azure:    't02-azure.css',
    crimson:  't03-crimson.css',
    slate:    't04-slate.css',
    verdant:  't05-verdant.css',
    amber:    't06-amber.css',
    midnight: 't07-midnight.css',
    chalk:    't08-chalk.css',
    titanium: 't09-titanium.css',
    rosewood: 't10-rosewood.css',
    cobalt:   't11-cobalt.css',
    onyx:     't12-onyx.css',
  };

  const themeUri = window.lfData?.themeUri ?? '';
  const panel    = document.getElementById('showcase-switcher');
  const trigger  = document.getElementById('switcher-trigger');

  if (!panel || !trigger) return;

  /* Backdrop */
  const backdrop = document.createElement('div');
  backdrop.className = 'switcher-backdrop';
  document.body.appendChild(backdrop);

  function openPanel() {
    panel.classList.add('is-open');
    panel.setAttribute('aria-hidden', 'false');
    backdrop.classList.add('is-visible');
    document.body.style.overflow = 'hidden';
    const firstCard = panel.querySelector('.switcher-card');
    if (firstCard) firstCard.focus();
  }

  function closePanel() {
    panel.classList.remove('is-open');
    panel.setAttribute('aria-hidden', 'true');
    backdrop.classList.remove('is-visible');
    document.body.style.overflow = '';
    trigger.focus();
  }

  trigger.addEventListener('click', openPanel);
  backdrop.addEventListener('click', closePanel);

  const closeBtn = panel.querySelector('.showcase-switcher__close');
  if (closeBtn) closeBtn.addEventListener('click', closePanel);

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && panel.classList.contains('is-open')) closePanel();
  });

  /* Trap focus inside panel */
  panel.addEventListener('keydown', e => {
    if (e.key !== 'Tab') return;
    const focusable = [...panel.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])')];
    const first = focusable[0];
    const last  = focusable[focusable.length - 1];
    if (e.shiftKey ? document.activeElement === first : document.activeElement === last) {
      e.preventDefault();
      (e.shiftKey ? last : first).focus();
    }
  });

  /* Swap template */
  function applyTemplate(slug) {
    if (!TEMPLATE_MAP[slug]) return;

    /* Update body data attribute */
    document.body.dataset.template = slug;

    /* Swap CSS link */
    let link = document.getElementById('lf-template-css');
    const href = `${themeUri}/assets/css/templates/${TEMPLATE_MAP[slug]}`;
    if (link) {
      link.href = href;
    } else {
      link = document.createElement('link');
      link.rel = 'stylesheet';
      link.id  = 'lf-template-css';
      link.href = href;
      document.head.appendChild(link);
    }

    /* Update active card */
    panel.querySelectorAll('.switcher-card').forEach(card => {
      card.classList.toggle('is-active', card.dataset.template === slug);
    });

    /* Push URL state */
    const url = new URL(window.location.href);
    url.searchParams.set('lf_template', slug);
    window.history.pushState({ lf_template: slug }, '', url.toString());
  }

  /* Card click */
  panel.querySelectorAll('.switcher-card[data-template]').forEach(card => {
    card.addEventListener('click', () => {
      applyTemplate(card.dataset.template);
      closePanel();
    });
  });

  /* Handle browser back/forward */
  window.addEventListener('popstate', e => {
    const slug = e.state?.lf_template ?? new URLSearchParams(window.location.search).get('lf_template');
    if (slug && TEMPLATE_MAP[slug]) applyTemplate(slug);
  });
})();
