# Edition

**Layer:** Section · **Status:** code · **Figma:** `421:51` · **Code:** `site/snippets/edition.php`, `.edition` (`src/_edition.scss`)

## Purpose

One past festival year on the Archive page: its title, text, an optional video and every photo, uncropped. The Archive [Statement](statement.md)'s year links jump to each Edition.

## Anatomy

- **Row**:
  - **Text column**: **h2 · Heading** (Heading/H2), then the **Text** slot (body paragraphs, Space M apart).
  - **Video** (slot): one [Video](video.md) at 16:9. Leave it empty when the edition has no video; the right column stays empty and the text keeps its half.
- **ul · Photos** (slot, prop "Photos"): justified rows of [Images](image.md) at Ratio **Natural**, each photo opening the [Lightbox](lightbox.md).

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | Split is pinned to Utopia Max, Stacked to Min. |
| Heading | text | e.g. "2025: The Triennial Edition". |
| Text / Video / Photos | slot | |

## Layout (Stacked ↔ Split)

- **Split**: text column left, video right (`1fr 1fr`, gap Layout/Gutter); photos full width below.
- **Stacked**: heading → text → video → photos.
- **Photos, justified rows**: every photo in a row shares one height and keeps its own ratio, so nothing is cropped and rows fill the width.
  - Aim for about 3 photos per row on desktop and about 2 on larger mobiles. On small mobile, the rows fold to one photo per row at full width.
  - **The last row is not stretched**: its photos keep the target row height and sit left-aligned.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Row → photos | Space pair/XL-M | 42 → 27 |
| Column gap (Split), photo gaps | Layout/Gutter | 14 → 18 |
| Heading → text | Space pair/S-M | 14 → 27 |
| Between paragraphs | Space M | 21 → 27 |
| Section padding | Space pair/L-XL block, Layout/Margin inline | |

Theme: **Flow** for every Edition, separated by section padding only.

## States & interactions

- Photos lazy-load. Each photo is a link to its full-size file; with JS, it opens the [Lightbox](lightbox.md), grouped per Edition.
- Year links scroll to `#edition-<year>` with Lenis (instant with reduced motion).

## Panel fields / content rules

Archive `editions` structure, one row per Edition, most recent first:

- `year` (**new**, required): drives the Statement's year links and the `id`.
- `headline`, `text` (writer), `video` (Vimeo URL, optional), `gallery` (up to 12 photos).

## HTML & accessibility

```php
<section class="edition" id="edition-<?= $year ?>" aria-labelledby="edition-<?= $year ?>-title">
  <div class="edition__row">
    <div class="edition__text"><h2 id="edition-<?= $year ?>-title">…</h2>…</div>
    <div class="edition__video"><?php snippet('vimeo', […]) ?></div>
  </div>
  <ul class="edition__photos" aria-label="… photos">
    <li style="--ratio: <?= $w / $h ?>"><a href="<full>" data-group="edition-<?= $year ?>"><?php snippet('image', […]) ?></a></li>
  </ul>
</section>
```

CSS for the rows: `display: flex; flex-wrap: wrap; gap: var(--gutter)`, each `li { flex: var(--ratio) 1 calc(var(--ratio) * var(--row-h)) }`. A trailing `::after { content: ''; flex-grow: 999 }` stops the last row stretching. Below the small-mobile switch point: one column. Alt text comes from each file.

## Open questions

- Decided (spec #6): a lone photo on the last row stays left-aligned at the target height; no smarter partition.
- Decided (spec #6): the video's poster is Vimeo's own thumbnail; no Kirby field.

## In code

- `snippet('edition', ['heading', 'year', 'text', 'video', 'photos', 'group', 'class'])` renders the whole `<section class="edition page-section theme-flow">`. No valid 4-digit `year` → no `id` (and the Archive template gives it no year link).
- Rows: `--row-h` is `30cqi` from a 480px list (about 2 per row) and `20cqi` from tablet (about 3); below 480px, one photo per row. Each `li` takes `aspect-ratio: var(--ratio)` and the image is `object-fit: contain`, so nothing is ever cropped.
- Lightbox hook: each photo is `a.edition__link[href=<original file>][data-group=<edition id>]`.
