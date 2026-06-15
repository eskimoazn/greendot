/* animations.js — Scroll-triggered reveal via IntersectionObserver */
(function () {
  'use strict';

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (prefersReduced) {
    document.querySelectorAll('[data-animate]').forEach(el => el.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  const staggerParents = document.querySelectorAll('[data-stagger]');
  staggerParents.forEach(parent => {
    const children = parent.querySelectorAll('[data-animate]');
    children.forEach((child, i) => {
      child.style.setProperty('--stagger-delay', `${i * 80}ms`);
    });
  });

  document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

  /* Counter animation */
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const raw = el.dataset.countTo;
        if (!raw) return;
        const numStr = raw.replace(/[^0-9]/g, '');
        const target = parseInt(numStr, 10);
        if (!target) return;

        const prefix = raw.match(/^[^0-9]*/)?.[0] ?? '';
        const suffix = raw.match(/[^0-9]*$/)?.[0] ?? '';
        const duration = 1600;
        const start = performance.now();

        function tick(now) {
          const elapsed = now - start;
          const progress = Math.min(elapsed / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          const current = Math.round(eased * target);
          el.textContent = prefix + current.toLocaleString() + suffix;
          if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
        counterObserver.unobserve(el);
      });
    },
    { threshold: 0.5 }
  );

  document.querySelectorAll('[data-count-to]').forEach(el => counterObserver.observe(el));
})();
