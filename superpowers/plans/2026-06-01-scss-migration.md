# SCSS Migration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Migrate `src/index.css` to SCSS and introduce a `_mixins.scss` partial with named breakpoint and container query mixins matching Graffiti UI 4.29.0.

**Architecture:** Install `sass`, rename the entry file, add a mixins partial imported via `@use`, and update the Vite glob so the new extension is picked up. No CSS rules change — this is purely a tooling and authoring upgrade.

**Tech Stack:** Vite 7, sass (Dart Sass), pnpm, Graffiti UI 4.29.0

---

## Files

| Action | Path | Responsibility |
|---|---|---|
| Create | `src/_mixins.scss` | Named breakpoint and container query mixins |
| Rename | `src/index.css` → `src/index.scss` | Global stylesheet entry point |
| Modify | `src/index.scss` | Add `@use './mixins' as *;` at top |
| Modify | `vite.config.js` | Update glob to include `.scss` |

---

### Task 1: Install sass

**Files:**
- Modify: `package.json` (pnpm adds it automatically)

- [ ] **Step 1: Install the sass package**

```bash
pnpm add -D sass
```

Expected output: something like `+ sass 1.x.x` with no errors.

- [ ] **Step 2: Verify it's in devDependencies**

```bash
grep '"sass"' package.json
```

Expected: `"sass": "^1.x.x"` under `devDependencies`.

- [ ] **Step 3: Commit**

```bash
git add package.json pnpm-lock.yaml
git commit -m "chore: add sass as dev dependency"
```

---

### Task 2: Create `src/_mixins.scss`

**Files:**
- Create: `src/_mixins.scss`

- [ ] **Step 1: Create the mixins partial**

Write `src/_mixins.scss` with the following content exactly:

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

- [ ] **Step 2: Commit**

```bash
git add src/_mixins.scss
git commit -m "feat: add SCSS breakpoint and container query mixins"
```

---

### Task 3: Rename `index.css` to `index.scss` and add the `@use` import

**Files:**
- Rename: `src/index.css` → `src/index.scss`
- Modify: `src/index.scss` (add `@use` at top)

- [ ] **Step 1: Rename the file**

```bash
mv src/index.css src/index.scss
```

- [ ] **Step 2: Add the `@use` import at the very top of `src/index.scss`**

The file currently starts with:

```css
@layer reset, fonts, graffiti, colors, custom;
```

Prepend the `@use` line so it becomes:

```scss
@use './mixins' as *;

@layer reset, fonts, graffiti, colors, custom;
```

Note: `@use` must come before any other rules (including `@layer` declarations) — this is a Sass requirement.

- [ ] **Step 3: Commit**

```bash
git add src/index.scss
git commit -m "feat: rename index.css to index.scss and import mixins partial"
```

---

### Task 4: Update Vite config to pick up `.scss` files

**Files:**
- Modify: `vite.config.js`

The current glob is:

```js
const input= globSync(["src/index.{js,css}", "src/templates/*.{js,css}"]).map(
```

- [ ] **Step 1: Update the glob patterns**

Change it to:

```js
const input= globSync(["src/index.{js,scss}", "src/templates/*.{js,scss,css}"]).map(
```

`src/templates/` keeps `.css` in the glob so any existing template CSS files still work.

- [ ] **Step 2: Commit**

```bash
git add vite.config.js
git commit -m "chore: update Vite glob to include .scss entry files"
```

---

### Task 5: Verify the build works

**Files:** none (verification only)

- [ ] **Step 1: Run the dev server**

```bash
pnpm dev
```

Open http://localhost:8888 and confirm the site loads with styles intact. Watch the terminal for any Sass compilation errors.

- [ ] **Step 2: Run a production build**

Stop the dev server, then:

```bash
pnpm build
```

Expected: build completes with no errors. Check `public/dist/` contains a compiled CSS file.

- [ ] **Step 3: Spot-check the compiled CSS**

```bash
grep -i "inclusive sans" public/dist/assets/*.css | head -3
```

Expected: font-face rules appear, confirming `index.scss` compiled correctly.

- [ ] **Step 4: Commit if anything was fixed, otherwise done**

If no fixes were needed, no commit required. If you had to patch something, commit with:

```bash
git commit -m "fix: resolve SCSS compilation issue"
```
