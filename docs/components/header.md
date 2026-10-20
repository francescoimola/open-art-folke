# Header

**Layer:** Section · **Status:** code · **Figma:** `383:874` · **Code:** `site/snippets/header.php` (with the Drawer) + `src/_header.scss`, `.header`

## Purpose

The site bar at the top of every page: home link, Site menu and Register on desktop; home link and Menu button on mobile.

## Anatomy

- **nav · Primary**: [Logo](logo.md) (Size=Header, the home link), then (Split only) the [Nav list](nav-list.md) Split/Default. Gap Space M.
- **Right**: Register ↗ ([Link](link.md) with icon) on desktop, Menu / Close button on mobile.

## Props & variants

| Layout | State | Shows |
| --- | --- | --- |
| Split | Default | Logo + Nav list + Register ↗ |
| Stacked | Default | Logo + "Menu" |
| Stacked | Open | Logo + "Close" (while the [Drawer](drawer.md) is open) |

Theme is **Red** by default, pinned on the main ([ADR-0002](../adr/0002-theme-is-a-variable-mode.md)).

## Layout (Stacked ↔ Split)

Split shows the links inline. Stacked moves them into the Drawer. One `<nav>` list in the HTML ([ADR-0003](../adr/0003-one-nav-list-for-header-and-drawer.md)).

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Height | Layout/Nav height (Space XS × 2 + one body line) | 42 → 54 |
| Padding block | Space XS | 10.5 → 13.5 |
| Padding inline | Layout/Margin (Space pair S-M) | 14 → 27 |
| Logo → nav gap | Space M | 21 → 27 |

## States & interactions

- **Fixed, always visible, always Red**, including over Flow and Ink sections. Anchor targets use `scroll-margin-top: var(--nav-h)`.
- Logo, links and Register: Link states (Hover drops the underline, Focus ring).
- Menu → opens the Drawer (State=Open). Close, Escape or a link tap → closes it.
- The Header stays in place between pages (`view-transition-name: site-nav`).

## Panel fields / content rules

- Site menu: see [Nav list](nav-list.md).
- Register: the site registration URL. Shown only while registration is open.

## HTML & accessibility

```html
<header class="header theme-red">
  <a href="/" class="header__home" aria-label="Open Art Folke — home"><?php snippet('logo') ?></a>
  <button class="header__menu" aria-expanded="false" aria-controls="drawer">Menu</button>
  <nav id="drawer" class="drawer" aria-label="Main"> … Nav list … </nav>
</header>
```

- The Menu button toggles `aria-expanded` and its label (Menu ↔ Close).
- On desktop the button is hidden and the nav shows inline.

## Open questions

-
