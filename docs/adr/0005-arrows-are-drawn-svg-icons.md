# Link arrows are drawn SVG icons, not typed characters

The ↗ and ↓ after link labels were typed characters. Inclusive Sans has no ↗, so the browser drew it in a fallback font: its shape varied by device, and Firefox drew its underline lower, which needed a patch. We replaced them with a small drawn [Icon](../components/icon.md) set (inline SVG, `currentColor`, sized in `em`), so the arrows look the same everywhere and match the drawn ↗ on the Sponsor card.

## Considered Options

- **Keep the typed characters**: no markup change, but they look different on every device.
- **A font subset with just the arrows**: consistent, but an extra font file for two characters.

## Consequences

- Every link with an arrow renders `snippet('icon', …)`. Panel text must not contain typed arrows.
- The Firefox underline fix for `span[aria-hidden]` in `src/_utilities.scss` can be removed once the migration is done.
