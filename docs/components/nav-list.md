# Nav list

**Layer:** Composite · **Status:** figma · **Figma:** `377:600` · **Code:** `site/snippets/menu.php` (exists; to be reworked), `.nav-list`

## Purpose

The **Site menu**: one Panel-managed list of links, shown in the Header (desktop), the Drawer (mobile) and the Footer ([ADR-0003](../adr/0003-one-nav-list-for-header-and-drawer.md)).

## Anatomy

- **Items**: [Link](link.md) instances, in this order: Start here (footer only) · Festival programme · About OA · Explore past editions · How to help · Register ↗ (Drawer only).
- **Separator** (Split/Default only): a "," after every item except the last.

## Props & variants

| Layout | Size | Used in | Arrangement |
| --- | --- | --- | --- |
| Split | Default | Header, desktop | Inline row, comma-separated, gap Space 2XS |
| Split | Large | Footer, desktop | Centred row, gap Space L |
| Stacked | Large | Drawer; Footer, mobile | Column, gap Space XS |

| Property | Values | Notes |
| --- | --- | --- |
| Start here | on / off | On in the Footer only. |
| Register | on / off | On in the Drawer only. The desktop Header shows Register separately, pushed to the right. |

## Layout (Stacked ↔ Split)

In the Header, Split becomes the Drawer's Stacked below the switch point. In the Footer, the centred row becomes a column. The HTML is the same list every time; only CSS changes.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Inline gap (after comma) | Space 2XS | 7 → 9 |
| Footer row gap | Space L | 28 → 36 |
| Stacked gap | Space XS (user decision, 2026-10-20) | 10.5 → 13.5 |
| Text | Link/Default (header), Link/Large (drawer, footer) | |

## States & interactions

- Each item has the Link states.
- **The current page** gets `aria-current="page"`, shown with no underline, like Hover. It isn't designed in Figma yet.
- **Hidden sections.** If Programme is hidden on the homepage, the "Festival programme" item disappears too ([ADR-0004](../adr/0004-homepage-sections-order-and-visibility-only.md)).

## Panel fields / content rules

- Site → **Menu**: a structure of label + page/URL, edited once and used everywhere. Labels are the same in every context.
- Footer adds "Start here" (home) at the front. Register comes from the site's registration URL and shows only while registration is open.

## HTML & accessibility

```html
<nav aria-label="Main">
  <ul class="nav-list" role="list">
    <li><a href="/#programme">Festival programme</a></li>
    …
  </ul>
</nav>
```

- Commas are CSS (`li:not(:last-child)::after { content: ","; }`) so screen readers don't announce them.
- The Footer list uses `aria-label="Footer"` so it can be told apart from the main nav.

## Open questions

- **Current-page style.** A no-underline "current" style hasn't been designed yet. Add it as a Link state?
