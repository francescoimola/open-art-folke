# Figma Rebuild & Fluid Token System — Working Reference

**Date:** 2026-10-12 · **Last updated:** 2026-10-14
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
- **Baseline approach (decided on V3.5): rhythm + resets, not a strict page-long baseline.**
  - The rules:
    - every line height is a whole unit, or half a unit for headings;
    - every gap, padding and paragraph spacing is a token, and so a whole or half unit.
  - Image heights come from width × ratio, and odd-line headings leave half a unit over, so drift after them is
    accepted. CSS can't snap content-driven heights to a grid, and on the web the drift is invisible.
  - Each section is checked on its own: hidden 9px row guides on each section frame, offset by
    that section's top padding variable.
  - Common slips to avoid:
    - off-scale paragraph or list spacing (it was 16 and 4; now Space S and 0);
    - a 3XS gap in one stack but not its twin;
    - strokes that count in layout (+1–2px);
    - fixed-size assets that aren't whole units (the footer logo is now 189px).

### 3.4 Layout
- **Sections are content-driven** — no fixed, full-height or half-height sections
  (designer explicitly dropped viewport-height heroes for flexibility).
- Section padding-block = pair **L→XL** (28 → 54); padding-inline = margin.
- Half-page panels carry the margin on their **outer** edge only, so inner content
  starts on a column line; the 16→18px gutter between panels is visible.
- **Nav** = 2 × Space XS + one body line = **42 → 54px** (always 6 units, token
  `Layout/Nav height`); body top offset uses the same token. *(Was 49 → 63 before V3.5.)*
- **Photo bands** (hero, house photo): title/caption row above, photo below spanning
  the 4 columns **inside the margins** at its native ratio (both photos are 4:3).
- **Programme illustration removed.**

### 3.4.1 Image ratios (added later the same day)
- Images use **only four ratios**: **3:2**, **2:3**, **1:1**, and **2:1** (wide, for full-width photo bands).
  Video stays **16:9** (set by Vimeo).
- The image's width fills its container and its height follows the ratio. The crop position plays
  the role of the Panel focus point (`image.php` already sets `object-position`).
- In CSS: `aspect-ratio` on the wrapper + `object-fit: cover` on the image, e.g. Graffiti's
  `.aspect-square` / `.aspect-custom` with `--aspect: 3 / 2`.
- The homepage **countdown band** (`1312 / 325`) is being **removed** in this version of the site,
  so it is not an exception to the ratio set.
- Audit at decision time:
  - The code set only 1:1 (people, sponsor), 16:9 (video) and the countdown.
  - Every other image was either shown at its own shape or cropped to a viewport-height box.
  - The media library is mostly 4:3 (20 files), 1:1 (20) and 3:2 (15).

### 3.4.2 Colour: three themes instead of five (added later the same day)
- **Flow** (default, "sectionless"): red text `#B51E2C` on `#FFFBFA`. Sections in the flow have no
  background of their own, so content reads as one continuous column.
- **Red**: white text (`light/Neutral/50` #FFF1F1) on `#B51E2C`. Used for the nav and the intro/hero.
- **Ink**: light text (`dark/Neutral/950` #E1D4D3) on `#110908`. Used for sponsors, the house-photo band and the footer.
- Replaces `.theme-brand / paper / blush / crimson / ink`. The likely mapping in code is three classes:
  flow = default `:root`, `.theme-red`, `.theme-ink`. Blush and crimson go.
- Figma: "Theme" collection (`VariableCollectionId:268:10`), modes Flow / Red / Ink.
  - Variables: Background, Text, Accent, Button/Background, Button/Text,
    Button secondary/Background, Button secondary/Text.
  - Each is an alias of the OAF "primitives" library, except Flow Background, which is the raw
    `#FFFBFA` (`--color-background`).
  - Code syntax: `--bg`, `--fg`, `--primary`, `--button-color`. `--button-text` is a proposed name
    that doesn't exist in code yet.
- Muted text stays as paint opacity (0.9 / 0.75) on the Text colour.
- **Update (V3.5, `269:3229`): text black, links red.**
  - Text roles in Flow:
    - **Text** = near-black `light/Neutral/900` #1C1313, used for headings and body.
    - **Link** = red `dark/Brand/600`, a new variable with code syntax `var(--link)`.
    - **Text secondary** = `dark/Neutral/600` #716665 (about 5.5:1 on #FFFBFA), a new variable for
      captions under links, with code syntax `var(--fg-muted)`. It replaces paint opacity.
  - In Red and Ink, Link = Text. Text secondary is light/Neutral/100 in Red and dark/Neutral/800 in Ink.
  - The sponsor names stay black on purpose: a list, not calls to action.
  - Footer row dividers use **Text** (in CSS, `currentColor`).
  - Link text styles:
    - **Link/Default** = body size, Medium, underlined;
    - **Link/Large** = H3 size, Medium, underlined (programme links, sponsors, footer nav).
  - **Heading/H4** (first created as Body/Strong) = body size, SemiBold, used for the footer labels.

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

**Type system (V3.5, 2026-10-13): five sizes, all formula-driven.**
Only **Type/Base** (14 Min | 18 Max) and **Type/Ratio** (1.2 | 1.25) are typed in.
Everything else is a Variables Plus formula (import file: `docs/tokens/variables-utopia-formulas.json`).

| Size | Formula | Min → Max | Styles |
|---|---|---|---|
| Step pair 4-6 | Min: Base × Ratio⁴, Max: Base × Ratio⁶ | 29.03 → 68.66 | Heading/H1 (Medium) |
| Step 4 | Base × Ratio⁴ | 29.03 → 43.95 | Heading/H2 (Medium) |
| Step 3 | Base × Ratio³ | 24.19 → 35.16 | Heading/H3 (Medium, Text secondary colour), Link/Large |
| Step 0 | Base | 14 → 18 | Body/Default, Heading/H4 (SemiBold), Link/Default (Medium, underlined), UI/Button (Medium) |
| Step −2 | Base ÷ Ratio² | 9.72 → 11.52 | Caption |

- **Spaces:**
  - Each space = Step 0 × 0.25 / 0.5 / 0.75 / 1 / 1.5 / 2 / 3 / 4 / 6.
  - Each pair = Min of the first space, Max of the second.
- **Line heights:**
  - H1 and H2 = `CEILING(step × 1.1, 2XS / 2)`, i.e. half units.
  - H3 = `CEILING(Step 3 × 1.1, 2XS)`, i.e. whole units (28 → 45), so large-link stacks stay on the grid.
  - Body = `CEILING(Step 0 × 1.5, 2XS)` and Caption = `CEILING(Step −2 × 1.4, 2XS)`, i.e. whole units.
- **Letter spacing:** H1 −0.05em at Min → −0.08em at Max (it matches H2 at 320), H2 −0.05em, H3 −0.035em, Body −0.05em, Caption +0.01em.
  - Written as `step * -8 / 100`, because Variables Plus misreads decimals like `0.05` (it computed ten times the value).
- Footer section titles (All you need to know, Media credits, Privacy, Fundraising, Terms, Copyright) are **H2**, so the heading levels in the HTML don't skip one.
- **Layout/Nav height** = 2 × Space XS + Line height/Body (42 → 54).
  - The nav logo is bound to it too: height = `Line height/Body` and width = `Layout/Logo width` (body line × 38.04⁄27). The header is then exactly Nav height at both ends.
  - Nav links and Register are body size now, and the nav logo is one body line tall.
- **Retired styles** (text moved to the new styles first):
  - old H1 (step 5) → H1;
  - Statement → H2;
  - UI/Button large → UI/Button;
  - UI/Button caption → Body;
  - UI/Nav link and UI/Nav button → Link/Default when underlined, otherwise Body.
- **Deleted:** Step 1/2/3/5 and their line-height and letter-spacing variables.
- **CSS:** compute the same formulas with `pow()` and `round(up, …)` from `--type-base-min/max` and `--type-ratio-min/max`.

**Pairs, for type as well as space (2026-10-14).** Each element has one formula at every width.
- The rule: **the 320 value comes from the mobile frame, the 1500 value from the desktop frame.**
- When no existing token fits, a custom pair joins the two.
- A pair is a variable whose Min mode aliases one token and Max mode another. In CSS it is a single `clamp()`.

| Pair | Min → Max | Used for | CSS |
|---|---|---|---|
| `Step pair/4-6` | Step 4 → Step 6 (29.03 → 68.66) | Heading/H1 | `clamp(1.8144rem, 1.1426rem + 3.3588vi, 4.2915rem)` |
| `Space pair/XL-M` | XL → M (42 → 27), **decreasing** | Main section row gap | clamp with a negative slope, bounds 27px and 42px |
| `Space pair/S-XL` | S → XL (14 → 54) | Space above the footer logo | `--space-s-xl` |

- The decreasing pair is on purpose: on one column, groups need more air; on two columns, the columns do the separating.
- **Where mobile and desktop tokens already agree at 320, desktop's token wins.** So the footer group gap is Space 2XL, and the contact button → email gap is 2XS.

---

### 4.1 Semantics are separate from style (2026-10-14)
- **Text styles set size only.** The HTML tag is written in the layer name, e.g. `h2 · Privacy`, `p.h1 · Come and have a nosey`, `span[aria-hidden] · ↓ hero arrow`.
- **An element never changes style between frames.** If it needs a different size on mobile, its style becomes a pair (see H1).
- **Homepage outline, the same on both frames:**
  - `h1` the statement;
  - `h2` The 2026 festival programme / About the festival / Recent sponsors;
  - footer `h2`s: I'm a visitor, I'm an artist/creative, Find us on socials, Contact us, Media credits, Privacy, Fundraising, Terms, Copyright.
- "Come and have a nosey." is a `<p>` with the H1 style, sitting one H1 line below the h1 (gap = `Line height/H1`).
- The ↓ under the hero is decorative: `aria-hidden`, as in the live `hero__arrow`.
- **Mobile ↔ desktop structure:**
  - Programme and About are **groups**.
  - On desktop each group spans both columns and is itself a 2-column grid (heading | content). On mobile it's a vertical stack.
  - In CSS that's one element: `grid-template-columns: subgrid`, `column-gap: gutter`, `row-gap: var(--space-s-m)`.
  - Footer groups work the same way: H2 label | content.
  - Layer order = HTML source order on both frames.

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
- No mobile (Min-mode) frame has been built yet. *(Mobile draft started 2026-10-14; see §6.)*
- **255:1817 "Open Art Folke V3"** — later working frame (copy of V2).
  - The 9px baseline rows are hidden. In their place, 27px alternating row bands (bound to Space M,
    starting at Nav height) make dragging and snapping easier.
  - Its three photos are instances of the **Image** component:
    - hero and house photo at 2:1 (`264:17`, `264:19`);
    - festival photo at 3:2 (`264:21`).
- **269:3229 "Open Art Folke V3.5"** — the designer's reworked frame: tighter spacing, grid sections,
  black text and red links. All colours are bound to Theme, every text node has a style, and every
  non-zero gap or padding is bound to a token.
  - Body copy is tighter, by design: `Letter spacing/Body/Default` = −0.05em of step 0 (−0.7 → −0.9px).
    Before, it borrowed the button-caption token, which is derived from a different step.
  - Left alone: the hidden red "Section" `269:3233` inside the intro, and the floating `Container` `269:3340`.
  - **Approved by the designer on 2026-10-14** as the desktop (Max) reference for the mobile and tablet drafts.
  - Structure, which maps directly to CSS:
    - the frame sits in Figma section **"Homepage"** (`306:69`);
    - the header `269:3313` (54 tall) is a sibling of Body, positioned over it;
    - Main Content `269:3231` stacks the intro `269:3232`, a full-bleed 2:1 photo, the content section and a second full-bleed photo;
    - the content section `269:3237` and the footer section `269:3281` use Figma's **grid auto-layout**:
      2 columns `1fr 1fr`, column gap bound to the gutter (18), in CSS `display: grid`.
  - In `269:3237`, the grid cells are placed explicitly, but the layer order isn't the reading order
    (the first layer is the photo in row 2). In HTML, the layer order becomes the source order, and on a
    one-column mobile layout that order is what people see.
  - Sponsor names use **Link/Large** in the Text colour.
  - Footer section titles are **H2**.
  - **Footer copy, Figma only.** It needs copying into the production Panel if the page is live.
    - Privacy, Fundraising and Terms were condensed slightly.
    - Terms now opens with "Open Art Folke is a volunteer-run, unincorporated charitable association."
- **`309:4` "Open Art Folke V3.5 Mobile (320)"**: the mobile draft (2026-10-14), a duplicate of V3.5 placed to its right.
  - **Set-up** (the designer's choices):
    - Width **320**, with Utopia pinned to **Min**, so every value is exactly what the CSS renders at 320.
    - **Navigation:** the header shows the logo and "Menu". A second frame, **`312:8`** "… menu open",
      shows the drawer: Red theme, the nav links and Register in **Link/Large**, a 2XS gap, margin inline,
      and L→XL padding.
    - **Full-width photos switch from 2:1 to 3:2**; in CSS, one `aspect-ratio` change.
    - **Stack order is row by row, left then right.** The desktop layers of `269:3237` were reordered to
      match, with no visual change, so layer order = HTML source order.
  - **How it collapses** (each step maps to CSS):
    - The grids `269:3237` and `269:3281` go to **one column** with auto-flow (`grid-template-columns: 1fr`).
      The spans are reset to 1.
    - Footer rows (title | text) become vertical: title above text.
    - The footer label/value grid also goes to one column, so the label → value gap equals the
      pair → pair gap (21). A `dl` with margin above each `dt` would separate pairs better.
    - The footer nav becomes a vertical list with a 2XS gap, aligned left.
  - Hidden in the draft: the floating `Container` (a browser-extension button captured with the page).
  - **Open questions for review:**
    - ~~the H1 runs to 15 lines at 41.8px~~ → resolved by `Step pair/4-6`: H1 is 29.03 at 320;
    - the nav label "See pogramme" has a typo, inherited from desktop;
    - the footer nav keeps its fixed 56px padding.
- **2026-10-14 sync:**
  - The designer's mobile edits are now on desktop too: the arrow, the "nosey" line, groups, and a footer with the logo first, then the nav, then H2 groups. "All you need to know" is removed.
  - The desktop About body had lost its text style; Body/Default is reapplied.
  - Both frames are bound to the pairs above.
- **Sponsor carousel (mobile only;** desktop keeps the names list, as on the live site):
  - **"Sponsor logos"** (`325:378`): nine `Sponsor logo/<Name>` components imported from `content/sponsor/*.svg`, coloured with Theme/Text.
  - **"Sponsor card"** (`325:388`):
    - 234 × 351, i.e. 2:3; in CSS the width is `min(80%, 24rem)`;
    - no fill, a 1px **Theme/Link** border (inside), padding Space L;
    - the logo is centred, and the name is Link/Large in Text colour;
    - properties: Name and Logo (instance swap).
  - In the mobile frame, the carousel replaces the names list, which is hidden but kept, since it's still the desktop list in the HTML. Cards run to the screen edge; the first card lines up with the margin.
  - **Code later:** the cards change from `theme-crimson box` to bordered cards.
- **Image component set `264:12`** (to the right of V3).
  - Variant property **Ratio** = 3:2 / 2:3 / 1:1 / 2:1. Each variant has its proportions locked;
    the photo sits on the inner layer "Photo".
  - Tested:
    - with width set to Fill, the height follows the ratio;
    - the photo is kept when you switch ratio.

---

## 6. Open items / known issues (as of this session)

- ~~Photos are 4:3 and too tall~~ → resolved by the ratio set (§3.4.1); full-width bands are 2:1 (1656 × 828).
- **House-photo caption row** is dominated by the 192px OA logo.
- **Programme buttons** became compact (XS×S) — correct per grammar, visibly different.
- **Hero typewriter** layers are missing from both frames.
- **Responsive drafts, in order:** mobile first (Utopia Min), then tablet, once the mobile set-up is agreed.
  Both start as duplicates of V3.5 so all variables and styles carry over.
- **Variables Plus re-import: done 2026-10-20.** The file now lives at `docs/tokens/variables-utopia-formulas.json`
  (see `docs/tokens/README.md`). Spot-check: H1 letter spacing ≈ −5.49 at Max, Step 3 = 24.19 → 35.16.
- Colour themes are now Figma variables (§3.4.2), but only in V3. The other frames still use raw
  primitives. Light/dark mode is not modelled.
- In the flow, adjacent sections each keep their own L→XL padding, so the gap between them is
  doubled (≈108px at Max). This may want a single XL→2XL gap instead.
- Code mixins mix `max-width`/`min-width` breakpoints (`src/_mixins.scss`) — flagged by
  the design-system guidance; not addressed.

---

## 7. Suggested next step (not started)

CSS migration **after** the mobile and tablet drafts are agreed, on a feature branch:
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
