# Figma Rebuild & Fluid Token System — Working Reference

**Date:** 2026-10-12
**Status:** Work in progress — reference only, not a binding plan
**Figma file:** [OAF-Website](https://www.figma.com/design/kGbvfXZ4km0Z5grxMBAHid/OAF-Website) (`kGbvfXZ4km0Z5grxMBAHid`), page **Design Update Oct 2026**
**Stack context:** Kirby 5 · Graffiti UI 4.29.0 · SCSS · Vite (see `AGENTS.md`)

> **Read this first.** This document records what was explored and decided in one
> working session so that later sessions (or a compacted conversation) know where
> things started. **None of it is final.** Future agents and the designer are free
> to change, reverse or replace any decision here. Treat it as history and context,
> not as a spec to enforce. Where the Figma file and this document disagree, the
> Figma file is the more recent truth.

---

## 1. Goal

Turn the live homepage into an editable Figma design with real variables and styles,
then use it to rework the layout on a **Vignelli-canon grid**, in a way that can be
brought back into **CSS** (fluid, scalable), not just a static graphic layout.

---

## 2. Timeline — how we got here

| # | Step | Outcome |
|---|---|---|
| 1 | Asked whether a live site can be pulled into Figma | User captured the homepage with Figma's Chrome plugin → frame **244:703** ("Open Art Folke", 1710 × 7518). Values came in hard-coded. |
| 2 | First pass: text styles | Created 12 semantic text styles + a "Typography" collection (Desktop/Mobile modes) derived from Graffiti's `--fl` fluid scale. *(Later replaced — see step 8.)* |
| 3 | Duplicated frame for editing | Working frame **244:1073** ("Open Art Folke V2"). The hero typewriter layers ("is cross-g", cursor, sizer) were already missing from both frames. |
| 4 | Vignelli grid guides | Read *The Vignelli Canon* (book pp. 40–53 = PDF pp. 21–27). Applied 4 columns + 400px rows. 31px margin was an arithmetic leftover of the 1710px capture width, not a design choice. |
| 5 | Snap sections to grid | Nav 64px; sections forced to multiples of 416px; footer split into bands; dividers turned into top borders. *(Later undone — see step 9.)* |
| 6 | Harmony audit | Found no shared unit: gaps 16/19.8/24/32/64, paddings 4/8/16/24/31/64, eleven unrelated line-heights. |
| 7 | Review with Design Masters + Vignelli design-system skills | Identified Figma↔CSS incongruities (fixed heights vs fluid CSS, 31px margin, inventing a spacing scale, fluid type vs strict baseline, arbitrary frame width). |
| 8 | Utopia investigation → token rebuild | Graffiti's type scale already *is* a Utopia scale; the gain is fluid **space** + **space pairs**. Built one "Utopia" collection (Min/Max). Deleted the old unused Inter/Utopia starter kit and the step-2 Typography collection. |
| 9 | Content-driven layout | Undid fixed heights; every section hugs its content with token padding; spacing grammar applied; photo bands reworked; Programme illustration removed. |

---

## 3. Decisions in force at end of session

All decisions were made with the designer via multiple-choice questions. Each must
be reproducible in CSS.

### 3.1 Token system
- **Utopia for type and space** (incl. space pairs); **Graffiti kept** for components.
  In code, Graffiti's `--fl` scale and `--vs-*` / `--pad-*` would be re-pointed at
  Utopia values so existing components inherit them.
- **Poles:** body **14px @ 320w → 18px @ 1500w**; type ratio **1.2 → 1.25**.
- **Baseline unit** = `--space-2xs` = **7 → 9px**. Because every Utopia space token is
  a fixed multiple of the body size, all spacing stays an exact multiple of the unit
  at *every* width (not just the poles).
- **Accessibility guards:** form inputs `max(16px, var(--step-0))` (prevents iOS zoom);
  small/caption text floored at **12px** (`max(0.75rem, var(--step--1))`).

### 3.2 Grid
- **4 columns**, gutter = **Space S** (14 → 18) — "one line of body type" (user chose
  body *size*, not leading).
- **Outer margin** = space pair **S→M** (14 → 27). Columns are fluid (`1fr`), as in CSS.
- Rows are **not** modules anymore; vertical structure = the baseline unit.

### 3.3 Vertical rhythm
- **Strict baseline with fallback:** line-heights use
  `round(up, <ratio>em, var(--space-2xs))` inside
  `@supports (line-height: round(up, 1px, 1px))`; plain unitless line-height otherwise.
  (Must be `@supports` — `round()` inside a custom property won't fall back on its own.)
- **Headings** (Display, H1–H3, Statement, Button large) round up to **half** a unit;
  body/UI text to whole units.

### 3.4 Layout
- **Sections are content-driven** — no fixed, full-height or half-height sections
  (designer explicitly dropped viewport-height heroes for flexibility).
- Section padding-block = pair **L→XL** (28 → 54); padding-inline = margin.
- Half-page panels carry the margin on their **outer** edge only, so inner content
  starts on a column line; the 16→18px gutter between panels is visible.
- **Nav** = XS padding + one nav-link line = **49 → 63px** (always 7 units); body top
  offset uses the same token.
- **Photo bands** (hero, house photo): title/caption row above, photo below spanning
  the 4 columns **inside the margins** at its native ratio (both photos are 4:3).
- **Programme illustration removed.**

### 3.5 Spacing grammar ("1 line / 2 lines")
| Relationship | Token | Value (Min → Max) |
|---|---|---|
| Related: heading→text, paragraph→paragraph, list items (e.g. sponsors) | Space M = one body line | 21 → 27 |
| Groups: text→buttons, list→buttons, footer group→group | Space XL = two body lines | 42 → 54 |
| Button padding | XS (block) × S (inline) | 10.5→13.5 × 14→18 |
| Section padding-block | Pair L→XL | 28 → 54 |

---

## 4. Token reference (Figma "Utopia" collection, modes Min = 320w, Max = 1500w+)

Every variable carries WEB code syntax (e.g. `var(--step-4)`, `var(--space-s-m)`).

**Type steps** — `--step-n`

| Step | −1* | 0 | 1 | 2 | 3 | 4 | 5 | 6 |
|---|---|---|---|---|---|---|---|---|
| Min | 12 | 14 | 16.8 | 20.16 | 24.19 | 29.03 | 34.84 | 41.80 |
| Max | 14.4 | 18 | 22.5 | 28.13 | 35.16 | 43.95 | 54.93 | 68.66 |

\* floored at 12px.

**Space** — `--space-*` (multipliers of step 0: 0.25, 0.5, 0.75, 1, 1.5, 2, 3, 4, 6)

| | 3XS | 2XS | XS | S | M | L | XL | 2XL | 3XL |
|---|---|---|---|---|---|---|---|---|---|
| Min | 3.5 | 7 | 10.5 | 14 | 21 | 28 | 42 | 56 | 84 |
| Max | 4.5 | 9 | 13.5 | 18 | 27 | 36 | 54 | 72 | 108 |

**Pairs** (min of first → max of second): 3XS-2XS, 2XS-XS, XS-S, **S-M** (margin),
M-L, **L-XL** (section padding), XL-2XL, 2XL-3XL.

**Layout aliases:** `Layout/Unit` → 2XS · `Layout/Gutter` → S · `Layout/Margin` → pair S-M ·
`Layout/Nav height` = 49 → 63.

**Text styles** (bound to the collection; font Inclusive Sans, Medium for headings/buttons, Regular for text)

| Style | Size | Line-height (Min → Max) | Tracking |
|---|---|---|---|
| Display | step 6 | 49 → 76.5 | −0.08em |
| Heading/H1 | step 5 | 35 → 58.5 | −0.065em |
| Heading/H2 | step 4 | 35 → 49.5 | −0.05em |
| Heading/H3 | step 3 | 31.5 → 45 | −0.035em |
| Statement | step 2 → step 4 (custom) | 28 → 58.5 | −0.05em |
| Body/Default | step 0 | 21 → 27 | +0.01em |
| Body/Small | step −1 (floored) | 21 → 27 | +0.01em |
| UI/Button | step 0 | 21 → 27 | +0.01em |
| UI/Button large | step 4 | 35 → 54 | −0.05em |
| UI/Button caption | 50% of step 4 | 21 → 27 | −0.05em |
| UI/Nav link | step 1 | 28 → 36 | −0.02em |
| UI/Nav button | step 1 | 21 → 27 | −0.02em |

---

## 5. State of the Figma file

- **244:703** — original capture. Uses the new text styles (pinned to Max) but keeps the
  original layout. Useful as the "before".
- **244:1073 "Open Art Folke V2"** — working frame, pinned to **Max**. Content-driven,
  token-bound paddings/gaps, ~1710 × 7966.
  - Layout guides: 4 columns bound to margin/gutter tokens; a 9px baseline row guide
    from y = 63 (Max values only — Figma can't bind "unit − 1", so a Min frame would
    need a 7px guide).
  - New wrapper frames named **"Text group"** (Festival, Sponsors) separate related
    items (M) from groups (XL).
  - Footer dividers: original 1px rule layers are **hidden**, replaced by 1px top
    strokes on each band (not counted in layout).
  - Hidden, not deleted: hero background wrapper (244:1077) and scroll arrow (244:1080).
  - Captured CSS `min-height`s were cleared from sections so they can hug.
- No mobile (Min-mode) frame has been built yet.

---

## 6. Open items / known issues (as of this session)

- **Photos are 4:3** → each ~1656 × 1242 at desktop, taller than a screen. Options
  floated: fixed crop ratio (e.g. 3:2) or spanning fewer columns.
- **House-photo caption row** is dominated by the 192px OA logo.
- **Programme buttons** became compact (XS×S) — correct per grammar, visibly different.
- **Hero typewriter** layers are missing from both frames.
- **Mobile frame** (Min mode) not yet created; mobile grid columns undecided.
- **Colour** (themes `brand`, `paper`, `blush`, `crimson`, `ink`, light/dark) not yet
  turned into Figma variables.
- Code mixins mix `max-width`/`min-width` breakpoints (`src/_mixins.scss`) — flagged by
  the design-system guidance; not addressed.

---

## 7. Suggested next step (not started)

CSS migration **after** the designer reviews V2, on a feature branch:
1. Add Utopia `--step-*` and `--space-*` (incl. pairs) as the source tokens.
2. Re-point Graffiti's `--font-size-min/max`, ratios, `--vs-*`, `--pad-*` at them.
3. `round()` line-heights in `@supports`; input 16px guard; small-text 12px floor.
4. Replace viewport/fixed-height sections with the padding + grammar above.
5. Run `pnpm preview` and `pnpm fallow:audit` before merging (see `AGENTS.md`).

---

## 8. Sources consulted

- *The Vignelli Canon* (local PDF), "Grids, Margins, Columns and Modules" and "Grids for Books".
- Skills: `design-masters` (Vignelli, Müller-Brockmann), Vignelli design-system skill
  (density & responsive), `utopia-fluid-scales`, Figma `figma-use` / `figma-generate-library`.
- [Utopia: Figma plugin and kickstarter V2](https://utopia.fyi/blog/figma-plugin-v2)
- [Utopia: Fluid Type + Space Calculator supports Figma variables](https://utopia.fyi/blog/figma-variables)
- [Utopia: Designing a utopian layout grid](https://utopia.fyi/blog/designing-a-utopian-layout-grid/)
- [Responsive UI design with Figma's variables and modes](https://uxdesign.cc/responsive-ui-design-with-figmas-variables-and-modes-2f97a36be6f7?gi=2590b5e943e5)
- Figma variables have no native fluid/`clamp()` support (as of this session) — modes are
  discrete endpoints only.
