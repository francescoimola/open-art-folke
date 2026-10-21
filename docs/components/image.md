# Image

**Layer:** Primitive · **Status:** code · **Figma:** `264:12` · **Code:** `site/snippets/image.php` (Ratio Natural: `.edition__photo`)

## Purpose

Every photo on the site. It has a fixed aspect ratio, fills the width of its container, and crops to fit.

## Anatomy

- **Wrapper**: sets the aspect ratio.
- **Photo** (inner layer): the image itself, set to fill and crop.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Ratio | 3:2, 2:3, 1:1, 2:1, Natural | 2:1 is for wide bands only. **Natural** keeps the photo's own ratio and never crops: Archive [Edition](edition.md) photos and the [Lightbox](lightbox.md). In Figma, resize each Natural instance to its photo's ratio. Video is always 16:9 (see [Video](video.md)). |

## Layout (Stacked ↔ Split)

The ratio is a property of each instance, not a Layout variant ([ADR-0001](../adr/0001-layout-variant-only-for-structure.md)). Where the ratio changes between mobile and desktop, the component using the image sets it:

| Use | Mobile | Desktop |
| --- | --- | --- |
| First Photo band (hero) | 1:1 | 2:1 |
| Later Photo bands | 3:2 | 2:1 |
| Split group media, right column | 3:2 | 3:2 |
| Split group media, full width | 3:2 | 2:1 |

## Tokens

None of its own. Width comes from the container, height from the ratio.

## States & interactions

None. Images lazy-load, except the first Photo band (`loading="eager"`, `fetchpriority="high"`). No parallax, no scroll effects.

## Panel fields / content rules

- One Kirby `File` per image. The focus point sets the crop position.
- Upload sources sized to how they're shown: JPEG, with heroes around 2000px. Never multi-MB PNGs (see `AGENTS.md`, "Responsive images").

## HTML & accessibility

- `snippet('image', ['file' => …, 'sizes' => …])` renders a `<picture>` with a WebP `<source>` and a JPG/PNG `<img>` fallback.
- CSS: `aspect-ratio` on the wrapper (3 / 2, 2 / 3, 1 / 1 or 2 / 1) plus `object-fit: cover`, with `object-position` taken from the focus point.
- Alt text comes from the file's Panel field. Decorative bands use `alt=""`.

## Open questions

-
