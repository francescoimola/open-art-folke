import Lenis from 'lenis'

const lenis = new Lenis({
  autoRaf: true,
  duration: 1.2,
  anchors: true,
  allowNestedScroll: true,
  smoothWheel: true,
  syncTouch: false,    // Lenis smooth-scroll on iOS<16 can jitter during inertial scroll, so we leave native touch alone.
})

// Registration popover — swap its theme class to whichever theme the
// popover itself declares for the origin of whichever trigger opened it
// (data-nav-theme / data-body-theme).
document.querySelectorAll('[popovertarget="registration-popover"]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const popover = document.getElementById('registration-popover')
    const theme = popover.dataset[`${btn.dataset.popoverOrigin}Theme`]
    if (theme) popover.className = popover.className.replace(/\btheme-\S+\b/, theme)
  })
})

// Copy-to-clipboard buttons (progressive enhancement). Global so it works on
// every page — the footer's copy button and the Sponsor page both rely on it.
// On failure we stay silent — the address is always shown as text nearby.
document.querySelectorAll('[data-copy]').forEach((btn) => {
  btn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(btn.dataset.copy)
      const original = btn.textContent
      btn.textContent = 'Copied!'
      setTimeout(() => { btn.textContent = original }, 2000)
    } catch {
      /* clipboard unavailable — no-op */
    }
  })
})
