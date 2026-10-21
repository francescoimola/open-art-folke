import Parvus from 'parvus'

/* Lightbox (docs/components/lightbox.md): Parvus on a native <dialog>, one gallery per Edition (the link's data-group).
   Without JS each photo stays a plain link to its full-size file. Styles: src/templates/archive.scss. */
const links = document.querySelectorAll('.edition__link')

if (links.length > 0) {
  /* The library Icons, rendered once by archive.php, so the controls match the Figma glyphs. */
  const icon = (glyph) => document.querySelector(`template[data-lightbox-icon="${glyph}"]`)?.innerHTML.trim() ?? ''

  const lightbox = Parvus({
    selector: '.edition__link',
    zoomIndicator: false,
    closeButtonIcon: icon('close'),
    previousButtonIcon: icon('arrow-left'),
    nextButtonIcon: icon('arrow-right'),
    l10n: {
      lightboxLabel: 'Photo viewer. Press Escape to close it and return to the page.',
      lightboxLoadingIndicatorLabel: 'Photo loading',
      lightboxLoadingError: 'This photo cannot be loaded.',
      previousButtonLabel: 'Previous photo',
      nextButtonLabel: 'Next photo',
      closeButtonLabel: 'Close',
      sliderLabel: 'Photos',
      slideLabel: 'Photo',
    },
  })

  /* Parvus builds the dialog on init. Theme Ink paints it (ADR-0002); Lenis must not scroll the page behind it. */
  const dialog = document.querySelector('dialog.parvus')
  const counter = dialog?.querySelector('.parvus__counter')
  dialog?.classList.add('theme-ink')
  dialog?.setAttribute('data-lenis-prevent', '')
  counter?.setAttribute('aria-live', 'polite')

  /* Figma spaces the counter ("3 / 11"); Parvus writes "3/11" before each of these events. */
  const spaceCounter = () => {
    if (counter) counter.textContent = counter.textContent.replace('/', ' / ')
  }
  lightbox.on('open', spaceCounter)
  lightbox.on('select', spaceCounter)

  /* Focus returns to the link of the photo last shown, so keyboard readers carry on from there.
     Native <dialog> restores focus to the opening link only, and Safari never focuses a clicked link. */
  lightbox.addHook('afterClose', ({ state }) => {
    state.GROUPS[state.activeGroup]?.triggerElements[state.currentIndex]?.focus()
  })
}
