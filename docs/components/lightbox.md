# Lightbox

**Layer:** Section · **Status:** code · **Figma:** `421:2018` · **Code:** Parvus + `src/templates/archive.{js,scss}`, `.parvus` overrides

## Purpose

A single photo opened large over the page, from an [Edition](edition.md)'s photos. Closing it returns the reader to where they were.

## Anatomy

- **Backdrop**: Ink Background at **90% opacity**: the page is only a faint hint behind. 50% was tried first and the page stayed too readable.
- **Top bar**:
  - **p · Counter** ("3 / 11"), top left.
  - **button · Close** ([Icon](icon.md) Close, Large), top right.
- **Stage**:
  - **button · Previous** and **button · Next** (Icon Arrow left / Arrow right, Large), vertically centred at the edges.
  - **Photo** (slot): one [Image](image.md) at Ratio Natural, uncropped, as large as fits inside the margins.
- The counter and every control sit on a **solid Ink pill**, so they keep full contrast whatever shows through the backdrop.
- **Caption** (optional): the file's `caption` field, under the photo in Caption text, Theme/Text, at most 60ch wide. Shown only when set; alt text stays for screen readers.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | Split pinned to Utopia Max, Stacked to Min. Both pinned to Theme Ink. |
| Show arrows | on / off | On in Split. Stacked hides the arrows: swipe instead. |
| Photo | slot | Drop in an Image sized to the photo's own ratio (nested instances can't be resized). |

## Layout (Stacked ↔ Split)

- **Split**: arrows at the left and right edges of the stage.
- **Stacked**: no arrows; swipe left or right. Close and counter stay at the top.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Outer padding | Layout/Margin | 14 → 27 |
| Gaps (top bar → stage, arrows → photo) | Layout/Gutter | 14 → 18 |
| Pill padding | Space XS (counter: XS × S) | |
| Backdrop | Theme Ink Background, 90% | |
| Pills | Theme Ink Background, solid | |

## States & interactions

- Opens on a photo click; Esc, the close button or a backdrop click closes it, and focus returns to the photo link.
- ← / → keys and swipe move within the same Edition. The counter updates.
- Controls use the library Focus ring.
- Reduced motion: no fade or slide.

## Panel fields / content rules

None of its own. It reads the Edition's `gallery` files; the link's `data-srcset`/`data-sizes` carry the WebP srcset (sizes `min(100vw, <ratio × 100>vh)`, the most the photo can fill). Each image file has an optional `caption` field (Panel: Caption, under Alt text).

## HTML & accessibility

- Native `<dialog>` opened with `showModal()`, via **Parvus** (MIT, about 7 KB, `--parvus-*` custom properties mapped to `--bg`/`--fg`). It was chosen over Tobii, bigger-picture and PhotoSwipe because it's the only maintained library on a native `<dialog>`.
- Without JS, each photo link simply opens the full image.
- The buttons have accessible names ("Close", "Previous photo", "Next photo"); the counter is announced politely.

## In code

- `src/templates/archive.js` (loaded only on the Archive, via the per-template entry) runs Parvus on `.edition__link`; each link's `data-group` keeps previous/next inside its Edition. It adds `theme-ink` to Parvus's `<dialog>`, `data-lenis-prevent` (so Lenis doesn't scroll the page behind), `aria-live="polite"` on the counter, and rewrites the counter as "3 / 11".
- Close / Previous / Next use the library [Icons](icon.md): `archive.php` renders them once into `<template data-lightbox-icon="…">`, and the script hands their markup to Parvus.
- On close, focus goes to the link of the photo last shown (that is also where Parvus's zoom-back animation lands), so a keyboard reader carries on from there.
- Captions: `edition.php` writes the caption, escaped, into a hidden `<p>` beside the link and points `data-caption-id` at it. Parvus copies that element's HTML, so caption text is never parsed as markup.
- `src/templates/archive.scss` loads Parvus's SCSS into `@layer graffiti` (the package exports no CSS file) and overrides it in `@layer custom`: the `--parvus-*` colours map to the Theme, and Graffiti's rounded, shadowed `dialog` card is reset. Split (arrows) from `tablet` (768px), Stacked below.
- Reduced motion: Parvus only animates under `no-preference`, and the global reduced-motion rules stop its view transitions.

## Open questions

- Show the alt text as a visible caption later?
