# Graffiti-Aligned Development Workflow

**Date:** 2026-05-29
**Status:** Approved
**Stack:** Kirby CMS 5 · native PHP templates · Graffiti UI 4.29.0 (CSS) · Vite 7 · pnpm

## Purpose

Establish a single development loop that keeps all future work strictly aligned
with the Graffiti design system — building new UI *from* Graffiti primitives, and
continuously folding existing custom code *back into* them. Two collaborating
roles produce one process: an **Implementation Specialist** (Figma → Graffiti)
and an **Audit & Optimization Specialist** (custom code → Graffiti).

The non-negotiable rule shared by both: **map before you write.** Exhaust Graffiti
classes, tokens, and components before writing any custom CSS. Custom CSS is
allowed only when no primitive fits, and only as a reusable project-level class —
never a one-off inline override.

---

## Agent 1 — Implementation Specialist: Figma → Graffiti translation

A repeatable 6-step pipeline, run for every Figma frame handed over.

1. **Read structure, not pixels.** Use the Figma MCP (`get_metadata`,
   `get_design_context`, `get_variable_defs`). Immediately apply the
   **÷1.93688 rem correction** — the OAF Figma frame is rooted at ~31px, so every
   exported `rem`/`clamp()` is inflated ~1.94×. Convert with `figma_px ÷ 16`, then
   map to the nearest Graffiti token (within ~15% — prefer the token over a custom
   value). Never copy a raw Figma `rem` or `clamp()`.

2. **Classify intent per region (role menu first).** Walk Graffiti's role menu
   top-down and stop at the first match: `.stat-card` (KPI), `.feature-card`
   (value prop), `.card` / `.card.featured` / `.card.linked` (record-like unit),
   `.callout` + semantic variant (notice), `.tag` (status/category), `.chip`
   (selectable pill), `<details class="bordered">` (FAQ disclosure), native
   `<dialog>` + `.close` (modal), `.row` / `.form-actions` (form rows),
   `.pull-quote` (pull quote). Neutral wrappers — `.box` / `.stack` / `.cluster` /
   `.split` — are **fallbacks**, used only after the menu is exhausted, with a
   written reason.

3. **Map tokens, not values.** Spacing → `--pad-*` / `--vs-*`. Type → set `--fl`
   (fluid level) + `.fs-*` classes; never raw `clamp()` for font size, never
   `--vs-*` as a font-size. Color → the bridged `--primary` / `--fg` / `--bg` plus
   semantic state tokens (`--color-success/warning/error/info`). No hex / rgb /
   oklch inline.

4. **Verify against the *installed* version, not the docs.** This project is on
   Graffiti **4.29.0**. Classes from later releases — `.eyebrow`, `.icon-rail`,
   `.composer`, `.log-card` — **do not exist here.** Confirm every class against
   `node_modules/@drop-in/graffiti/dist/{layouts,utilities,components,core}.css`
   before using it.

5. **Layout via primitives + container queries.** `.layout-readable` / `.section`
   / `.stack` for page shells. Use `@container` (not `@media`) for
   component-internal responsiveness, consistent with the existing
   `section { container-type: inline-size }` rule.

6. **Justify any custom CSS in writing.** If a region has no primitive, write it as a reusable class in
   `@layer custom` and record *why* no primitive fit. The deliverable for each
   component is a class plan + token plan + a one-line note for each custom rule.

---

## Agent 2 — Audit & Optimization Specialist: findings (2026-05-29)

Audited the live codebase including uncommitted WIP.

### P1 — Correctness

- **Duplicate `<main>` landmark.** `header.php` opened `<main class="layout-readable">`
  and `footer.php` closed it, but `default`, `about`, `contact`, `programme`,
  `archive`, and `sponsor-us` templates *each opened a second*
  `<main class="layout-readable section stack">` — nested `<main>` elements
  (invalid HTML, two landmarks).
- **Six byte-identical templates.** `default`, `about`, `contact`, `programme`,
  `archive`, `sponsor-us` were exact copies — pure duplication.
- **Orphan `test.php`.** No matching content page; still loaded the p5.js CDN that
  was removed in commit `e39f8a7`.

### P2 — Reuse / consistency

- **Inline-style soup in `menu.php`** — repeated
  `style="align-items:center; padding-inline:…; --gap:…"`. These map to documented
  tokens and belong in a small reusable nav class set, not per-element inline
  styles. (Also fixed: markup referenced `--vs-x`, which is not a Graffiti token.)
- **Full-bleed breakout duplicated.** `width:100vw; margin-inline:calc(50% - 50vw)`
  was hand-written on both `.hero` and `.intro`. Extracted into one reusable `.full-bleed` class.
- **Header forced `layout-readable` on the shared `<main>`,** which fought
  `home.php`'s full-bleed sections. Resolved by making the header own a plain
  `<main>` and letting each template choose its own layout wrapper.

### P3 — Investigate (flagged, not actioned)

- **Hand-rolled `@layer reset` (~220 lines)** likely overlaps Graffiti's own
  `core.css` reset. Candidate for trimming, but needs careful diffing against the
  installed core before removing anything. Deferred.

### Positive exemplars (standardize on these)

- **Drawer:** `popover` + `.drawer` + `.close` + `.minimal` is textbook-canonical
  Graffiti. Reference pattern.
- **Color-token bridge** in `@layer custom :root` is intentional and correct, not
  slop. Keep.

### Sanctioned custom code (justified exceptions)

- **`.site-nav`** — Graffiti 4.29 ships no navbar primitive, so a custom nav is
  justified. Stays, leans on tokens, documented as a sanctioned exception.

---

## Reconciliation — the integrated loop

The two roles are one loop, not two activities:

- **Shared source-of-truth order:** installed CSS contracts → hosted Graffiti docs
  → `AGENTS.md` → skill recipes.
- **Audit feeds Implementation.** Every custom class the audit sanctions
  (`.site-nav`) becomes a *known primitive* the Implementation
  Specialist reuses — custom code is written once, then reused, never re-invented.
- **Implementation feeds Audit.** Step 6's "justify custom CSS" notes become the
  audit's checklist next round; new raw CSS without a justification note is the
  audit's first target.
- **One governance gate** — the OAF Graffiti skill (`.claude/skills/oaf-graffiti/`)
  carries the compliance checklist every change must pass, Figma-sourced or
  hand-written.

## Compliance checklist (the gate)

- [ ] Role menu walked before any neutral wrapper or custom CSS.
- [ ] Every class verified against installed Graffiti **4.29.0** dist files.
- [ ] All values are tokens (`--pad-*`, `--vs-*`, `--fl`/`.fs-*`, bridged colors) —
      no raw hex/rgb/oklch or `clamp()` for type.
- [ ] Responsiveness uses `@container` for component internals, `@media` only for
      page-level shape.
- [ ] Any custom CSS is a reusable class in `@layer custom` with a written reason —
      no one-off inline overrides beyond approved token overrides.
- [ ] One `<main>` landmark per page; logical heading order; labelled controls.

## Execution log (this session)

- Wrote this spec.
- Created `.claude/skills/oaf-graffiti/SKILL.md`.
- P1: header `<main>` made plain; `default.php` rewrapped; deleted 5 redundant
  templates + `test.php`.
- P3 (reset trim) left as a flagged follow-up.
