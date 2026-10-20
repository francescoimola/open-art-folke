# Sponsor card

**Layer:** Composite · **Status:** figma · **Figma:** `357:498` · **Code:** `site/snippets/sponsor-card.php`, `.sponsor-card` (planned)

## Purpose

One sponsor in the [Sponsor grid](sponsor-grid.md): a square card linking out to the sponsor's site.

## Anatomy

- **Card**: a square with a Neutral/100 fill and Space S padding. Its content is spread apart: logo top-left, name bottom-left.
- **Logo**: an instance of [Sponsor logo](sponsor-logo.md) (S size on mobile, M on desktop).
- **Name**: text in the Link/Compact style (no underline), coloured Theme/Text.
- **Corner → Icon · External**: a square in Theme/Text, flush top-right, with a ↗ arrow in Theme/Background. It sits in an absolutely positioned, full-width "Corner" row aligned right, so it stays flush as Space S changes size.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Stacked, Split | Stacked = 139px card with S logo (mobile). Split = 261px card with M logo (desktop). Renamed from `Size = Mobile / Desktop`. |
| State | Default, Hover, Focus | |
| Name | text | |
| Logo | instance swap | swaps between the Sponsor logo components |

## Layout (Stacked ↔ Split)

The card is square and fills its grid cell. Only the logo slot changes, from 72×40 to 108×60. In CSS, the card size comes from the grid, and the logo slot can be one fluid token. If that works in code, `Layout` can be removed here ([ADR-0001](../adr/0001-layout-variant-only-for-structure.md)).

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Padding | Space S | 14 → 18 |
| Name | Link/Compact, line height `Line height/Body tight` | 17.5 → 22.5 |
| Corner square | Space S | 14 → 18 |
| Arrow | Space 2XS box, stroke 1.25 / 1.5 | 7 → 9 |

## States & interactions

| State | Change | Trigger | Timing |
| --- | --- | --- | --- |
| Hover | The card switches to the **Red** theme (red fill; text, logo and square off-white; red arrow), and the arrow nudges 2px up and to the right | `:hover` | 200ms ease-out (Smart Animate) |
| Focus | Same as Hover, plus a 2px outside ring in Neutral/900 | `:has(:focus-visible)` | instant |

CSS: reuse the Red theme values (today `.theme-brand`) under `:hover` and `:has(:focus-visible)`. With reduced motion, there is no nudge and the colour change is instant.

## Panel fields / content rules

From each sponsor page: name, logo (SVG, coloured to Theme/Text via `currentColor`) and website URL.

## HTML & accessibility

- `<li>` inside `ul.sponsors`. The whole card is one `<a href target="_blank" rel="noopener">` whose accessible name is the sponsor's name, plus "(opens in a new tab)" as visually hidden text.
- The logo SVG and the ↗ arrow are `aria-hidden="true"`.

## Open questions

- **Dark Themes:** the Neutral/100 fill is fixed, but the logo, name and corner follow Theme/Text, so on Ink they turn light on light. The Sponsor page pins the grid to Flow inside its Ink band. Should the card instead get theme-aware colours?
