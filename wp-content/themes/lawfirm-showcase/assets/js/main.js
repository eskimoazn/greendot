/* main.js — Core site interactions */
(function () {
  'use strict';

  /* --- Sticky header ---------------------------------------------------- */
  const header = document.getElementById('masthead');
  if (header) {
    const onScroll = () => {
      header.classList.toggle('is-sticky', window.scrollY > 80);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* --- Mobile nav toggle ------------------------------------------------ */
  const toggle = document.querySelector('.nav-toggle');
  const nav    = document.getElementById('site-navigation');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('is-open', !expanded);
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  /* --- Smooth scroll ---------------------------------------------------- */
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const id = link.getAttribute('href').slice(1);
      if (!id) return;
      const target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      const offset = (header?.offsetHeight ?? 80) + 16;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
      if (nav?.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        toggle?.setAttribute('aria-expanded', 'false');
      }
    });
  });

  /* --- Active nav link on scroll --------------------------------------- */
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu a[href^="#"]');
  if (sections.length && navLinks.length) {
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          navLinks.forEach(link => {
            link.classList.toggle('is-current', link.getAttribute('href') === `#${entry.target.id}`);
          });
        });
      },
      { rootMargin: `-${(header?.offsetHeight ?? 80) + 20}px 0px -60% 0px` }
    );
    sections.forEach(s => sectionObserver.observe(s));
  }

  /* --- Contact form (AJAX) --------------------------------------------- */
  const form = document.getElementById('lf-contact-form');
  if (form) {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const submitBtn  = form.querySelector('.form-submit');
      const textEl     = submitBtn?.querySelector('.form-submit__text');
      const loadingEl  = submitBtn?.querySelector('.form-submit__loading');
      const responseEl = form.querySelector('.form-response');

      if (loadingEl) loadingEl.hidden = false;
      if (textEl)    textEl.hidden    = true;
      if (submitBtn) submitBtn.disabled = true;

      try {
        const data = new FormData(form);
        const res  = await fetch(form.action, { method: 'POST', body: data });
        const url  = new URL(res.url);
        const status = url.searchParams.get('contact');

        if (responseEl) {
          responseEl.hidden = false;
          if (status === 'success') {
            responseEl.className = 'form-response is-success';
            responseEl.textContent = window.lfData?.i18n?.sent ?? 'Message sent! We\'ll be in touch soon.';
            form.reset();
          } else {
            responseEl.className = 'form-response is-error';
            responseEl.textContent = window.lfData?.i18n?.error ?? 'Something went wrong. Please try again.';
          }
        }
      } catch {
        if (responseEl) {
          responseEl.hidden = false;
          responseEl.className = 'form-response is-error';
          responseEl.textContent = window.lfData?.i18n?.error ?? 'Something went wrong. Please try again.';
        }
      } finally {
        if (loadingEl) loadingEl.hidden = true;
        if (textEl)    textEl.hidden    = false;
        if (submitBtn) submitBtn.disabled = false;
      }
    });
  }

  /* --- URL param success/error notice ---------------------------------- */
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('contact')) {
    const notice = document.querySelector('.form-response');
    if (notice) {
      const status = urlParams.get('contact');
      notice.hidden = false;
      notice.className = status === 'success' ? 'form-response is-success' : 'form-response is-error';
      notice.textContent = status === 'success'
        ? (window.lfData?.i18n?.sent  ?? 'Message sent!')
        : (window.lfData?.i18n?.error ?? 'Something went wrong.');
      notice.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }
})();
