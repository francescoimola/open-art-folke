# SCSS Migration Design

**Date:** 2026-06-01  
**Status:** Approved

## Goal

Migrate `src/index.css` to SCSS so breakpoint and container query logic matching Graffiti UI 4.29.0 can be authored as named mixins rather than repeated raw `@media` strings.

## What changes

| File | Action |
|---|---|
| `src/index.css` | Renamed to `src/index.scss` — content unchanged |
| `src/_mixins.scss` | New partial — breakpoint and container query mixins |
| `vite.config.js` | Glob updated to include `.scss` entry files |
| `package.json` | `sass` added as a dev dependency |

## `_mixins.scss` contents

```scss
// Breakpoints — match Graffiti UI 4.29.0
@mixin mobile        { @media (width < 640px)   { @content; } }
@mixin below-tablet  { @media (width < 768px)   { @content; } }
@mixin tablet        { @media (width >= 768px)  { @content; } }
@mixin below-desktop { @media (width < 1024px)  { @content; } }

// Container queries — match Graffiti UI 4.29.0
@mixin cq-compact    { @container (max-width: 30rem) { @content; } }
@mixin cq-narrow     { @container (max-width: 500px) { @content; } }
@mixin cq-medium     { @container (max-width: 600px) { @content; } }
@mixin cq-wide       { @container (max-width: 768px) { @content; } }
```

## Import in `index.scss`

```scss
@use './mixins' as *;
```

Placed at the top of the file, before the cascade layer declarations, so all layers can use the mixins.

## Vite config change

The input glob changes from:

```js
globSync(["src/index.{js,css}", "src/templates/*.{js,css}"])
```

to:

```js
globSync(["src/index.{js,scss}", "src/templates/*.{js,scss,css}"])
```

Vite's built-in SCSS support activates automatically once `sass` is installed — no plugin needed.

## Out of scope

- No changes to template-level CSS files in `src/templates/` (they stay `.css` for now unless templates need mixins)
- No refactoring of existing CSS rules in `index.scss`
- No changes to Graffiti's own CSS
