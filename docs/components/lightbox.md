# Lightbox

**Layer:** Section · **Status:** figma · **Figma:** `421:2018` · **Code:** Parvus + `src/templates/archive.{js,scss}`, `.parvus` overrides (planned)

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
- No caption; alt text is for screen readers.

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

None of its own. It reads the Edition's `gallery` files; the link's `data-srcset`/`data-sizes` carry the WebP srcset.

## HTML & accessibility

- Native `<dialog>` opened with `showModal()`, via **Parvus** (MIT, about 7 KB, `--parvus-*` custom properties mapped to `--bg`/`--fg`). It was chosen over Tobii, bigger-picture and PhotoSwipe because it's the only maintained library on a native `<dialog>`.
- Without JS, each photo link simply opens the full image.
- The buttons have accessible names ("Close", "Previous photo", "Next photo"); the counter is announced politely.

## Open questions

- Show the alt text as a visible caption later?
