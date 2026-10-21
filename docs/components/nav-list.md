# Nav list

**Layer:** Composite · **Status:** code · **Figma:** `377:600` · **Code:** `site/snippets/nav-list.php` + `src/_nav-list.scss`, `.nav-list`

## Purpose

The **Site menu**: one fixed list of links, shown in the Header (desktop), the Drawer (mobile) and the Footer ([ADR-0003](../adr/0003-one-nav-list-for-header-and-drawer.md)).

## Anatomy

- **Items**: [Link](link.md) instances, in this order: Start here (footer only) · Festival programme · About OA · Explore past editions · How to help · Register ↗ (Drawer and Footer, while registration is open).
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
| Register | on / off | On in the Drawer and Footer. The desktop Header shows Register separately, pushed to the right. |

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
- **The current page** gets `aria-current="page"`, with no visual style (spec #6).
- **Hidden sections.** If Programme is hidden on the homepage, the "Festival programme" item disappears too, via `HomePage::showsProgramme()`.

## Panel fields / content rules

- The items and their labels are fixed in `nav-list.php`, the same in every context (user decision, #35: the Panel-editable menu field was removed). An item whose page doesn't exist is dropped.
- Footer adds "Start here" (home; label field Site → Settings → Site menu → "Start here" label) at the front. Register uses the registration URL and label, and shows only while registration is open.

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

## Code

```php
<nav aria-label="Footer">
  <?php snippet('nav-list', ['layout' => ['stacked', 'row'], 'startHere' => true, 'register' => true]) ?>
</nav>
```

`layout` is `stacked`, `row` or `inline`, or a pair `[below tablet, tablet and up]`. The Header uses `['stacked', 'inline']`. The Footer passes `stacked` and switches to the row itself above 820px (see [Footer](footer.md)). There the row wraps into balanced lines, never one item alone (#29): the Footer sets the list to a centred `text-wrap: balance` block of inline-block items. That override lives in `_footer.scss`; the `row` layout itself (and the Header) still wraps as a flex row.

## Open questions

-
