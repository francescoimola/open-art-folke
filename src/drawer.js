/*
  Drawer (docs/components/drawer.md): the Header's Menu button opens the one <nav> as a full-height panel below tablet.
  Close, Escape or a link tap closes it and returns focus to the button. While open, everything outside
  the Header is inert, Tab wraps inside the Header and the page can't scroll.
*/
const TABLET = window.matchMedia('(width >= 768px)')

/* Keyboard-reachable controls currently rendered in the Header (Menu/Close, logo, Drawer links). */
function focusables(header) {
  return [...header.querySelectorAll('a[href], button:not([disabled])')]
    .filter((el) => el.checkVisibility?.() ?? true)
}

/* Tab / Shift+Tab past either end wraps to the other end. */
function wrapFocus(event, header) {
  const items = focusables(header)
  const [edge, other] = event.shiftKey ? [items[0], items.at(-1)] : [items.at(-1), items[0]]
  if (document.activeElement !== edge) return
  event.preventDefault()
  other.focus()
}

/* Scroll lock, and everything but the Header out of reach of focus and screen readers. */
function lockPage(header, locked) {
  document.documentElement.classList.toggle('has-drawer-open', locked)
  for (const el of document.body.children) el.inert = locked && el !== header
}

/** @param {{ onOpen?: () => void, onClose?: () => void }} hooks — scroll-lock hooks (Lenis stop/start) */
export function initDrawer({ onOpen, onClose } = {}) {
  const header = document.querySelector('[data-header]')
  const toggle = header?.querySelector('[data-drawer-toggle]')
  if (!toggle) return

  const labels = { false: toggle.textContent, true: toggle.dataset.labelOpen ?? toggle.textContent }
  const hooks = { false: onClose, true: onOpen }
  const isOpen = () => toggle.getAttribute('aria-expanded') === 'true'

  const drawer = header.querySelector('.drawer')
  let closingTimer

  /* [data-closing] keeps the fade-out transition on until the Drawer is hidden (CSS animates only while open or closing). */
  function markClosing(closing) {
    clearTimeout(closingTimer)
    header.toggleAttribute('data-closing', closing)
    if (closing) closingTimer = setTimeout(() => header.removeAttribute('data-closing'), 400)
  }

  function setOpen(open) {
    toggle.setAttribute('aria-expanded', String(open))
    toggle.textContent = labels[open]
    markClosing(!open && header.hasAttribute('data-open'))
    header.toggleAttribute('data-open', open)
    lockPage(header, open)
    hooks[open]?.()
  }

  function close(restoreFocus = true) {
    setOpen(false)
    if (restoreFocus) toggle.focus()
  }

  toggle.addEventListener('click', () => (isOpen() ? close() : setOpen(true)))

  header.addEventListener('click', (event) => {
    if (isOpen() && event.target.closest('#drawer a')) close()
  })

  document.addEventListener('keydown', (event) => {
    if (!isOpen()) return
    if (event.key === 'Escape') close()
    if (event.key === 'Tab') wrapFocus(event, header)
  })

  /* Growing past the switch point shows the nav inline, so drop the open state silently. */
  TABLET.addEventListener('change', (event) => {
    if (event.matches && isOpen()) close(false)
    markClosing(false)
  })

  drawer?.addEventListener('transitionend', (event) => {
    if (event.target === drawer && event.propertyName === 'visibility' && !isOpen()) markClosing(false)
  })
}
