import Lenis from 'lenis'
import { initDrawer } from './drawer.js'

/* Smooth scroll, skipped with reduced motion so scrolling and anchor jumps stay native and instant.
   Anchor targets land below the fixed Header via scroll-margin-top (Lenis reads it too). */
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches

const lenis = reduceMotion ? null : new Lenis({
  autoRaf: true,
  duration: 1.2,
  anchors: true,
  allowNestedScroll: true,
  smoothWheel: true,
  syncTouch: false,    // Lenis smooth-scroll on iOS<16 can jitter during inertial scroll, so we leave native touch alone.
})

initDrawer({
  onOpen: () => lenis?.stop(),
  onClose: () => lenis?.start(),
})

/* Copy-to-clipboard buttons (progressive enhancement; the Button snippet's `copy` option). On success the label
   shows data-copied for 2s and the sibling live region announces data-announce. On failure, stay silent
   (the value is shown as text nearby). */
document.querySelectorAll('[data-copy]').forEach((btn) => {
  const label = btn.querySelector('.button__label') ?? btn
  const original = label.textContent
  const status = btn.nextElementSibling?.matches('[data-copy-status]') ? btn.nextElementSibling : null
  const say = (text) => { if (status) status.textContent = text }

  btn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(btn.dataset.copy)
      label.textContent = btn.dataset.copied ?? 'Copied!'
      say(btn.dataset.announce ?? 'Copied')
      setTimeout(() => {
        label.textContent = original
        say('')
      }, 2000)
    } catch {
      /* clipboard unavailable — no-op */
    }
  })
})
