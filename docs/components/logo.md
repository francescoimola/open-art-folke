# Logo

**Layer:** Primitive · **Status:** figma · **Figma:** `375:537` · **Code:** `site/snippets/logo.php` (exists, inline SVG)

## Purpose

The OA mark. It appears small in the [Header](header.md), where it's the home link, and large in the [Footer](footer.md).

## Anatomy

- **Mark**: three vector shapes in a 1.41 : 1 box (`viewBox="0 0 87.34 61.98"`), filled with Theme/Text.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Size | Header, Footer | Same mark, two token-bound sizes. |

## Layout (Stacked ↔ Split)

None. Both sizes are fluid.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Header width | Layout/Logo width | 29.59 → 38.04 |
| Header height | Line height/Body (one nav line) | 21 → 27 |
| Footer width | Layout/Footer logo width | 108 → 266.33 |
| Footer height | Layout/Footer logo height | 76.64 → 189 (7 body lines at Max) |
| Colour | Theme/Text | adapts to Red (header) and Ink (footer) |

The footer sizes are values the designer chose, not derived from the type scale, so they're stored as fixed values in [`docs/tokens/variables-utopia-formulas.json`](../tokens/variables-utopia-formulas.json). In CSS: `width: clamp(6.75rem, …, 16.65rem)` using the Utopia viewport range, with `height: auto`.

## States & interactions

- Header: it's the home link, so it gets the Link Focus ring (2px Theme/Text, 2px offset). There is no hover change.
- Footer: decorative, not interactive.

## Panel fields / content rules

None.

## HTML & accessibility

- Header: `<a href="/" aria-label="Open Art Folke — home"><?php snippet('logo') ?></a>`. The SVG is already `aria-hidden` and `focusable="false"`.
- Footer: `<?php snippet('logo') ?>` with no link, and hidden from assistive technology.
- `fill="currentColor"` on the SVG, so the section's Theme colours it.

## Open questions

- Should the footer logo be a home link too?
