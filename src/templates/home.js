const countdown = document.querySelector('.countdown');

if (countdown && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  countdown.classList.add('countdown--primed');

  new IntersectionObserver((entries, obs) => {
    if (entries[0].isIntersecting) {
      countdown.classList.add('countdown--revealed');
      obs.disconnect();
    }
  }, { threshold: 1.0 }).observe(countdown);
}

// Footer: copy-to-clipboard buttons (progressive enhancement). On failure we
// stay silent — the address is always shown as text next to the button.
document.querySelectorAll('[data-copy]').forEach((btn) => {
  btn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(btn.dataset.copy);
      const original = btn.textContent;
      btn.textContent = 'Copied!';
      setTimeout(() => { btn.textContent = original; }, 2000);
    } catch {
      /* clipboard unavailable — no-op */
    }
  });
});
