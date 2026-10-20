# Components

The OAF component library, designed in Figma and built as Kirby snippets + SCSS. **This folder is the source of truth**: each Figma component set's description links to its doc here. Terms follow [`GLOSSARY.md`](../../GLOSSARY.md); decisions are in [`docs/adr/`](../adr/).

- **Figma:** file `kGbvfXZ4km0Z5grxMBAHid`, page "Design Update Oct 2026", section **Components** (left of "Homepage Interactive" `331:285`).
- **Reference frames:** desktop `332:124` (Utopia Max, 1500+), mobile `332:261` (Utopia Min, 320), Drawer open `332:409`.

## Index

Status: `planned` → `figma` (component built) → `code` (snippet + SCSS built).

### Primitives

| Component | Doc | Status |
| --- | --- | --- |
| Link | [link.md](link.md) | figma |
| Button | [button.md](button.md) | figma |
| Icon | [icon.md](icon.md) | figma |
| Image | [image.md](image.md) | figma |
| Video | [video.md](video.md) | figma |
| Logo | [logo.md](logo.md) | figma |
| Sponsor logo | [sponsor-logo.md](sponsor-logo.md) | figma |

### Composites

| Component | Doc | Status |
| --- | --- | --- |
| Link + hint | [link-hint.md](link-hint.md) | figma |
| Link list | [link-list.md](link-list.md) | figma |
| Nav list | [nav-list.md](nav-list.md) | figma |
| Sponsor card | [sponsor-card.md](sponsor-card.md) | figma |
| Info item | [info-item.md](info-item.md) | figma |
| Copy email | [copy-email.md](copy-email.md) | figma |
| Person card | [person-card.md](person-card.md) | figma |
| Disclosure | [disclosure.md](disclosure.md) | figma |
| Benefits table | [benefits-table.md](benefits-table.md) | figma |

### Sections

| Component | Doc | Status |
| --- | --- | --- |
| Header | [header.md](header.md) | figma |
| Drawer | [drawer.md](drawer.md) | figma |
| Statement | [statement.md](statement.md) | figma |
| Photo band | [photo-band.md](photo-band.md) | figma |
| Photo pair | [photo-pair.md](photo-pair.md) | figma |
| Split group | [split-group.md](split-group.md) | figma |
| Sponsor grid | [sponsor-grid.md](sponsor-grid.md) | figma |
| Edition | [edition.md](edition.md) | figma |
| Lightbox | [lightbox.md](lightbox.md) | figma |
| Footer | [footer.md](footer.md) | figma |

Docs are written as each component is built, in this order: primitives, then composites, then sections. After that, the homepage frames are rebuilt from instances to check that everything fits together.

## Conventions

### Naming

- **Figma:** sentence case, e.g. "Split group". Layer names carry the HTML tag ("h2 · …", "ul.sponsors · …").
- **Code:** snippet `site/snippets/<kebab-name>.php`, CSS block `.<kebab-name>`, BEM parts `.<kebab-name>__<part>` and modifiers `--<mod>`.
- **Variant properties:** only `Layout`, `State`, `Size`, `Ratio` and `Glyph` (Icon only). A new axis needs agreement first.

### Fluid sizing

- Every size comes from Utopia tokens (`--step-*`, `--space-*`, pairs). Figma shows the Min and Max modes only.
- `Layout = Stacked | Split` exists only where the structure changes ([ADR-0001](../adr/0001-layout-variant-only-for-structure.md)).
- **Tablet:** no variants. It is handled at the very end, in code, once the design has been built.

### Theme

- Flow, Red or Ink is a variable mode set on the instance, and `.theme-*` on the section in code ([ADR-0002](../adr/0002-theme-is-a-variable-mode.md)).
- Defaults: the Header, Drawer and Statement are Red, the Footer is Ink, and everything else is Flow.
- **Pinned modes on mains.** Those defaults are pinned as explicit Theme modes on the main components, and each `Split` / `Stacked` main is pinned to Utopia Max / Min so the gallery shows the right endpoint. Instances inherit both; override on the instance when needed, e.g. a Statement in Flow, or the tablet check.

### States

- Every interactive component has `State` variants: Default, Hover and **Focus** (required), plus any states specific to it.
- Figma wires Smart Animate between states where it is cheap. Whatever Figma can't show is described in the doc.

## Cross-cutting behaviour

These rules apply site-wide; component docs reference them instead of repeating them.

| Behaviour | Rule |
| --- | --- |
| Motion token | State changes use **200ms ease-out**. With `prefers-reduced-motion: reduce`, everything is instant. |
| External links | **↗** (drawn [Icon](icon.md), never a typed character) = external and opens in a new tab. A hint is wired with `aria-describedby`; with no visible hint, the link carries visually hidden "(opens in a new tab)" text. |
| Downloads | **↓** after a link label = a file download. |
| Anchor scroll | Lenis smooth scroll; targets use `scroll-margin-top` equal to the header height. Instant with reduced motion. The Figma anchor frames ("anchor · #…") stand in for this. |
| Scroll effects | None: no sticky stacking, no parallax. Sections size to their content. |
| Images | Lazy-loaded, except the first Photo band (`loading="eager"`, `fetchpriority="high"`). Rendered via the `image` snippet. |
| Page transitions | Cross-document view transitions stay (fade + 8px lift). The Header and Footer stay in place between pages. |
| Retired | The GSAP typewriter, the Countdown band, sticky/viewport-height sections, and the five-theme palette. |

## Doc template

Copy [`_template.md`](_template.md) for each new component.

## Open questions & next steps (as of 2026-10-20)

The component library is complete in Figma (status `figma`). Code is **not** started.

**Waiting on the user**

- ~~Import the variables in Variables Plus~~: done 2026-10-20. The import file now lives at [`docs/tokens/variables-utopia-formulas.json`](../tokens/variables-utopia-formulas.json), the source for porting tokens to CSS.
- **Deferred: rebuilding the homepage frames from instances** (in Figma section `331:285`). The recommended approach is to build new frames alongside the prototype, rewire flows and anchors, strip typed ↗↓ from labels, and delete the old frames only after comparing.

**Open design questions** (each one is detailed in its doc)

- [Footer](footer.md): the HTML order of nav and logo, and whether to keep the mobile 2px top rule.
- [Nav list](nav-list.md): a current-page link state.
- [Logo](logo.md): should the footer logo link home?
- [Copy email](copy-email.md): should the visible address look like a link?
- [Sponsor logo](sponsor-logo.md) / [Sponsor card](sponsor-card.md): a fluid logo slot, which would remove the card's `Layout` axis.
- [Link](link.md): is Link/Compact (sponsor names) a third Link size?
- [Icon](icon.md): vertical alignment against cap height, to settle in code.

**About redesign: done in Figma (2026-10-20).** Final frames: Desktop v2 `399:1839` and Mobile v2 `399:2255`, in section "About · Redesign" `393:1068`. The v1 frames (`393:1069`, `393:1450`, `393:1487`, `394:1536`) are superseded and kept only for comparison.

- Order: Header → Statement (Red, h1 + Aside) → Photo band → `section#how` (three Split groups) → [Photo pair](photo-pair.md) → People ([Person card](person-card.md) grid) → principles → Footer.
- The principles Photo band sits **before** the principles on desktop and **after** them on mobile, so it's the last thing before the footer.
- Copy is the user's own, set on desktop and mirrored on mobile. Hardcoded for now; Panel fields come at build time.
- Statement skip link (added later): "Here's how ↓" in the Links row, jumping past the Photo band to `#how`.
- Still open:
  - Link targets for "Who makes for a good sponsor" (probably /sponsor) and "Message us about volunteering" (email or Instagram?).
  - Real photos: the principles band has none yet, and 14 of 16 people use placeholders.
  - [Person card](person-card.md): a person without a photo.
  - 16 people in 3 columns leave one card alone on the last row.
  - [Disclosure](disclosure.md) is in the library but unused, since FAQs were dropped.

**Archive redesign: done in Figma (2026-10-20).** Section "Archive · Redesign" `423:1675`, to the right of the live capture `411:4662`. Frames: Desktop `423:1676`, Mobile `424:1879`, Lightbox Desktop `424:2381`, Lightbox Mobile `424:2440`.

- Order: Header → Statement (**Red**, h1 + intro in the Aside + year links; Ink was tried first) → one [Edition](edition.md) per year (Flow) → Footer. No Photo band.
- Library changes: Statement gained **Show links / Links**; Image gained **Ratio=Natural**; Icon gained **Close**, **Arrow left**, **Arrow right**; new [Video](video.md), [Edition](edition.md) and [Lightbox](lightbox.md).
- Panel: each edition gets a new required `year` field.
- Lightbox in code: Parvus on a native `<dialog>` (see [lightbox.md](lightbox.md)).
- Still open: a lone photo on the last row (see [edition.md](edition.md)); video posters are grey placeholders.

**Sponsor redesign: done in Figma (2026-10-20).** Section "Sponsor · Redesign" `445:2918`, to the right of the live capture "Support" `438:2534`. Frames: Desktop `445:2919`, Mobile `448:3031`.

- Order: Header → Statement (**Ink**, h1 + intro in the Aside, no links) → `section#why` (**Ink**: [Photo pair](photo-pair.md) + the Why support us Split group) → Our sponsors → What sponsors get → Become a sponsor (**Red**) → Buy us a coffee + Other ways to support us → Photo band → Footer. Everything else is Flow.
- `section#why` is one section: Photo pair then Split group on desktop. On mobile the pair's photos wrap the text (square → Why support us → portrait); see [Photo pair](photo-pair.md).
- Our sponsors: "Current" + [Sponsor grid](sponsor-grid.md), then "Previous" + a [Link list](link-list.md) of the 10 previous sponsors (↗), then the thank-you line.
- What sponsors get: the new [Benefits table](benefits-table.md) (Layout Split / Stacked) plus the small print.
- Become a sponsor: copy + [Copy email](copy-email.md); the bold "openartfolke at gmail dot com" in prose is gone.
- `section#support` (Flow) holds two Split groups:
  - **Buy us a coffee** (`#donate`): the donating paragraph and a [Link + hint](link-hint.md), "Buy the OAF team a coffee ↗" (was a button).
  - **Other ways to support us** (`#help`, non-monetary help): the intro, the Venues / Equipment loans / Volunteer list (bold lead-ins, plain `ul`), the closing line, then a Large [Link](link.md), "Why volunteer with us", to About (internal, no icon).
- Photos: the Photo pair uses `featureimage` (family-drawing, 1:1) and `detailimage` (froude, 2:3), which fit the pair as they are. The closing Photo band uses a new optional `bandimage` field; Figma shows the homepage's closing photo as a stand-in.
- Statement skip link: "Read on ↓" in the Links row. It jumps to the Why support us Split group (give it its own id, e.g. `#why-support`), not to `section#why`, which opens with the photos on desktop.
- Library changes: Icon gained **Check**; new [Benefits table](benefits-table.md).
- Retired: the old intro/photo 2×2 layout (`.sponsor-grid` in `src/_layout.scss`). Its class name clashes with the library's Sponsor grid, so rename or remove it at build time.
- Still open:
  - [Sponsor card](sponsor-card.md) on a dark Theme: its Neutral/100 fill is fixed while the logo and name follow Theme/Text, so on Ink they vanish unless the grid is pinned to Flow. It no longer arises here (Our sponsors went back to Flow), but it's still open for the library.
  - The mobile Sponsor grid leaves one card alone on the last row (9 cards in 2 columns).

**Next:** redesign the remaining page (default) using these components. New components or names go into this index and `GLOSSARY.md`.
