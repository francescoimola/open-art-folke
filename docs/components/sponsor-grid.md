# Sponsor grid

**Layer:** Section · **Status:** figma · **Figma:** `382:1136` · **Code:** `site/snippets/sponsor-list.php` (exists; to be reworked), `ul.sponsors`

## Purpose

The square Sponsor cards for the Current sponsors: in the Sponsors Homepage section and under "Our sponsors" on the Sponsor page. It replaces the old mobile carousel and the desktop list of names.

## Anatomy

- **Sponsors** (slot): [Sponsor card](sponsor-card.md) instances.

## Props & variants

| Layout | Columns | Card |
| --- | --- | --- |
| Split | 3, in the right column of a Split group | Sponsor card Layout=Split |
| Stacked | 2, full content width | Sponsor card Layout=Stacked |

## Layout (Stacked ↔ Split)

Columns change from 2 to 3. Cards stay square and fill their cells.

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

```html
<ul class="sponsors" role="list"> <li class="sponsor-card">…</li> … </ul>
```

CSS: `display: grid; grid-template-columns: repeat(2, 1fr)`, and `repeat(3, 1fr)` above the switch point, with `gap: var(--space-s)`.

## Open questions

- **Naming clash:** `.sponsor-grid` in `src/_layout.scss` is the old Sponsor page intro/photo layout. Remove it (retired by the redesign) before building this component.
