# Sponsor grid

**Layer:** Section · **Status:** code · **Figma:** `382:1136` · **Code:** `site/snippets/sponsor-grid.php`, `.sponsor-grid` (`src/_sponsor-grid.scss`). It replaces the old `sponsor-list.php` (mobile carousel + desktop hover list), removed in #15.

## Purpose

The square Sponsor cards for the Current sponsors: in the Sponsors Homepage section and under "Our sponsors" on the Sponsor page. It replaces the old mobile carousel and the desktop list of names.

## Anatomy

- **Sponsors** (slot): [Sponsor card](sponsor-card.md) instances.

## Props & variants

| Layout | Columns | Card |
| --- | --- | --- |
| Split | 3 above a 1210px viewport (2 below), in the right column of a Split group | Sponsor card Layout=Split |
| Stacked | 2, full content width | Sponsor card Layout=Stacked |

## Layout (Stacked ↔ Split)

Columns change from 2 to 3. Cards stay square and fill their cells. User decision (#28): 2 columns up to a 1210px viewport, 3 only above it, on the Sponsor page and the homepage alike (mixin `sponsor-grid-wide`, `width > 1210px`). The grid must also be at least 480px wide (`cq-medium`), so a narrow placement keeps 2 columns. At 1210px the grid is about 570px wide on both pages.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Row and column gap | Space S | 14 → 18 |

## States & interactions

Only the cards' own (Red on Hover and Focus). The cards follow source order, with no shuffle or carousel.

## Panel fields / content rules

- Shows the **Current sponsors**: those tagged with the site's current festival year in the Sponsor page's `sponsors` structure, in Panel order. Each needs a logo.
- Homepage: a "See all our sponsors" Link sits under the grid, in the Split group's Content.
- Sponsor page: a "Current" label sits above the grid, and the Previous sponsors follow as a [Link list](link-list.md).
- In an Ink (or Red) section, pin the grid instance to **Flow** (`.theme-flow` on the `ul`), because the cards' fill is fixed light. See [Sponsor card](sponsor-card.md).

## HTML & accessibility

```php
<?php snippet('sponsor-grid') ?>   // Current sponsors from the Sponsor page
<?php snippet('sponsor-grid', ['sponsors' => $page->currentSponsors()]) ?>
```

```html
<div class="sponsor-grid theme-flow">   <!-- query container; pinned to Flow, no background -->
  <ul class="sponsor-grid__list" role="list" aria-label="Current sponsors"> <li class="sponsor-card">…</li> … </ul>
</div>
```

- Params: `sponsors` (rows of `name`, `url`, `logo`, as `SponsorPage::currentSponsors()` returns; default = the Sponsor page's), `label` (the list's accessible name, default "Current sponsors"), `class`. No sponsors: nothing renders.
- The wrapper, not the `ul`, carries the block class, because it is the query container.

## Open questions

- ~~Naming clash with the old intro/photo layout~~: removed in #15.
