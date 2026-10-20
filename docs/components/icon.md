# Icon

**Layer:** Primitive · **Status:** figma · **Figma:** `372:825` · **Code:** `site/snippets/icon.php` (planned)

## Purpose

The drawn arrows used after link labels and as the Statement's ↓. They replace the typed ↗ and ↓ characters: Inclusive Sans has no ↗, so the browser drew it in a fallback font that varied by device, and it needed a Firefox underline fix (`src/_utilities.scss`).

## Anatomy

- **Box**: square, sized 0.75em of the text it sits beside.
- **Glyph**: an open stroke drawn in a 7×7 grid, with butt caps and mitred joins.
  - External ↗: shaft `M0 7 L7 0`, head `M2 0 L7 0 L7 5`.
  - Arrow down ↓: shaft `M3.5 0 L3.5 7`, head `M0 3.5 L3.5 7 L7 3.5`.
  - Plus +: `M3.5 0 L3.5 7`, `M0 3.5 L7 3.5`.
  - Minus −: `M0 3.5 L7 3.5`.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Glyph | External, Arrow down, Plus, Minus | External = opens in a new tab. Arrow down = a download, or the Statement arrow. Plus / Minus = a closed / open [Disclosure](disclosure.md). |
| Size | Default, Large | Matches the Link size it sits in. Link picks it automatically. |

Inside [Link](link.md), the Icon is an exposed nested instance: turn on **Show icon**, then pick **Glyph** in the Link's own panel.

The Sponsor card's corner ↗ is a separate, heavier drawing (stroke 1.25 / 1.5 in a 7px box, at the user's request), so it doesn't use this set.

## Layout (Stacked ↔ Split)

None, fluid only.

## Tokens

| Use | Token | Min (320) → Max (1500) | CSS |
| --- | --- | --- | --- |
| Box, Default | Icon/Default (= Space/XS) | 10.5 → 13.5 | `0.75em` |
| Box, Large | Icon/Large (Step 3 × 3/4) | 18.14 → 26.37 | `0.75em` |
| Stroke, Default | Icon stroke/Default (Step 0 / 10) | 1.4 → 1.8 | `stroke-width="0.93"` in the 7-unit viewBox |
| Stroke, Large | Icon stroke/Large (Step 3 / 10) | 2.42 → 3.52 | same |
| Gap from label | Space 3XS (Default), Space 2XS (Large) | 3.5 → 4.5, 7 → 9 | `margin-inline-start: 0.25em` |
| Colour | Theme/Link | | `currentColor` |

In CSS, all of these reduce to `em` units, because the icon inherits its link's font size. That's why one SVG serves both sizes. The Figma variables are formulas in `variables-utopia-formulas.json`, so they follow any change to Type/Base or Type/Ratio.

## States & interactions

None of its own. It inherits colour and state from its Link. The underline never extends under the icon.

## Panel fields / content rules

- Editors never choose icons. Templates add them: ↗ when a URL is external, ↓ when it points to a file.
- Labels must not contain typed arrow characters. Remove them from Panel text during the code migration.

## HTML & accessibility

```php
<?php snippet('icon', ['glyph' => 'external']) ?>
```

renders

```html
<svg class="icon" viewBox="0 0 7 7" width="0.75em" height="0.75em" fill="none" stroke="currentColor"
     stroke-width="0.93" stroke-linecap="butt" stroke-linejoin="miter" aria-hidden="true" focusable="false">
  <path d="M0 7L7 0M2 0H7V5"/>
</svg>
```

- Always `aria-hidden`. The meaning comes from the link's hint or visually hidden text ("opens in a new tab", "PDF download").
- `.icon { display: inline-block; vertical-align: … }` stops the underline from running into the icon, which also replaces the old Firefox fix.

## Open questions

- Vertical alignment: in Figma the icon is centred on the line. In code, align it to the cap height (`vertical-align: -0.05em` or similar) and check it at both endpoints.
