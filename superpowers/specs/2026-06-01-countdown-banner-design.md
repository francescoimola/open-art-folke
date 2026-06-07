# Countdown banner — design

**Date:** 2026-06-01
**Status:** Approved for planning
**Figma:** node `121:746` (file `kGbvfXZ4km0Z5grxMBAHid`) — the masked "row" layer to build into a timer.

## Goal

A live countdown on the homepage with two parts:

1. **A number** — days remaining between *today* and the end date, reused in the existing
   "There are X days until the next edition…" heading (`home.php:36`, currently `78 days`).
2. **A masked image band** — `coat.png` revealed as vertical slices. The number of revealed
   ("unmasked") slices represents the share of time *remaining*; the rest read as pale empty
   blocks. The block count is an illustrative metaphor — the precise figure is the day number.

Both are driven by editable start/end dates connected to Kirby.

## Decisions (settled with the user)

- **Reveal style:** discrete blocks — **10** equal vertical slices, filled count = remaining
  fraction **rounded to nearest** block.
- **Placement:** inside the existing `theme-blush` section, as a `<div>` at `home.php:39`
  (after the heading/copy, before `</section>`).
- **Dates:** edited on the **Home page panel** — two date fields on the Home blueprint.
- **Liveness:** **page-load only**, computed in **PHP** (no JS). Day-granularity countdown.
- **Code location:** a **Kirby page model** (`site/models/home.php`) holds the maths.
  `home.php` must not be cluttered with timer logic.

## Architecture

### 1. Data — Kirby fields
`site/blueprints/pages/home.yml` gains two date fields:

```yaml
countdownstart:
  type: date
  label: Countdown start
  default: 2026-01-01
countdownend:
  type: date
  label: Countdown end
  default: 2026-10-09
```

`content/home/home.txt` is seeded with `Countdownstart: 2026-01-01` and
`Countdownend: 2026-10-09` so the banner works immediately and the values are panel-editable.

### 2. Logic — page model (`site/models/home.php`)
A `HomePage extends Kirby\Cms\Page` class. All comparisons are done at **day granularity**
(both dates normalised to midnight) so the count is stable through the day and free of
timezone/hour off-by-one. Methods:

- `countdownStartDate(): DateTime` — from `countdownstart`, fallback `2026-01-01`.
- `countdownEndDate(): DateTime` — from `countdownend`, fallback `2026-10-09`.
- `daysRemaining(): int` — `max(0, ceil((end − today) in days))`. Partial day counts as a day.
- `countdownFraction(): float` — `clamp((end − today) / (end − start), 0, 1)`; share remaining.
  Guards divide-by-zero when start == end (returns 0).
- `countdownTotalBlocks(): int` — `10` (single source of truth for the block count).
- `countdownFilled(): int` — `clamp(round(fraction × total), 0, total)`; revealed slices.

### 3. Template — `site/templates/home.php`
- Line 36: replace `78 days` with the day count via the model, pluralised so it never reads
  ungrammatically near the finish:
  `There <?= $page->daysRemaining() === 1 ? 'is' : 'are' ?> <?= $page->daysRemaining() ?> day<?= $page->daysRemaining() === 1 ? '' : 's' ?> until…`
- Line 39: `<?php snippet('countdown', ['page' => $page]) ?>` — markup lives in the snippet.

No timer arithmetic in the template; it only calls model methods and includes the snippet.

### 4. Markup — `site/snippets/countdown.php`
Reads `$page->countdownFilled()` and `$page->countdownTotalBlocks()`:

```php
<div class="countdown">
  <img class="countdown__img" src="/assets/images/coat.png" alt="" aria-hidden="true">
  <div class="countdown__grid" role="img"
       aria-label="<?= $page->daysRemaining() ?> days remaining">
    <?php for ($i = 0; $i < $page->countdownTotalBlocks(); $i++): ?>
      <span class="countdown__cell<?= $i < $page->countdownFilled() ? ' is-filled' : '' ?>"></span>
    <?php endfor ?>
  </div>
</div>
```

- The `<img>` carries **no filter and no blend mode** — `coat.png` is pre-edited.
- The grid is a decorative composite; `role="img"` + `aria-label` give it one accessible name,
  and the empty/filled `<span>`s are hidden from AT (they convey nothing on their own).

### 5. Styles — `src/templates/home.scss` (new; Vite auto-globs `src/templates/*`)
- `.countdown` — `position: relative; aspect-ratio: 1312 / 354` (matches Figma 1312×354 band),
  with a `min-height` floor so it stays legible on narrow screens.
- `.countdown__img` — `position: absolute; inset: 0; width/height: 100%; object-fit: cover`.
  No `filter`, no `mix-blend-mode`.
- `.countdown__grid` — `position: absolute; inset: 0; display: flex; gap: <gutter>`;
  `background: var(--bg)` (the section's pale blush, `--light-Brand-50` = Figma `#fff1f1`).
- `.countdown__cell` — `flex: 1 1 0`. Default `background: var(--bg)` (empty → merges into the
  pale band and gutters). `.is-filled` → `background: transparent` (the coat slice shows through).

Result: revealed image slices separated by pale gutters on the left; the spent portion reads as
a solid pale block on the right. Because empties use `var(--bg)`, dropping the band into a
different `theme-*` later recolours them automatically. Gutter and `min-height` use existing
tokens (`--vs-*` / a small fixed gap); no hardcoded magic colours.

## Files

| File | Change |
|------|--------|
| `site/blueprints/pages/home.yml` | add `countdownstart`, `countdownend` date fields |
| `content/home/home.txt` | seed the two date values |
| `site/models/home.php` | **new** — `HomePage` model with the countdown methods |
| `site/templates/home.php` | swap line 36 number; add snippet include at line 39 |
| `site/snippets/countdown.php` | **new** — band markup |
| `src/templates/home.scss` | **new** — `.countdown` styles |

## Out of scope / non-goals

- No JavaScript; no live sub-day ticking.
- No filters, blend modes, or re-tinting of `coat.png`.
- Block count (10) is fixed and illustrative — not a precise time readout.

## Verification

- `pnpm dev`, open `http://localhost:8888`: band renders in the blush section; today
  (2026-06-01, ~130 days left of a 281-day span ≈ 46%) shows **5 of 10** filled and the heading
  reads the matching day count.
- Change `Countdownend` in `/panel` → number and filled-block count both update on reload.
- Edge cases: end in the past → 0 days, 0 filled; end == start → no divide-by-zero.
