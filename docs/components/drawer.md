# Drawer

**Layer:** Section · **Status:** figma · **Figma:** `383:875` · **Code:** part of `site/snippets/header.php` (planned), `.drawer`

## Purpose

The mobile presentation of the Site menu, opened from the Header's Menu button.

## Anatomy

- **Panel**: Red, full width, covering the viewport below the Header.
- **Nav list**: Stacked/Large, Register on, Start here off.

## Props & variants

None. Theme Red is pinned on the main.

## Layout (Stacked ↔ Split)

Exists only below the Header's switch point. On desktop the same `<nav>` shows inline in the Header.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Padding block | Space pair/L-XL | 28 → 54 |
| Padding inline | Layout/Margin | 14 → 27 |
| Link gap | Space XS (from Nav list) | 10.5 → 13.5 |
| Height | `calc(100dvh - var(--nav-h))` | covers the viewport |

## States & interactions

| Event | Behaviour |
| --- | --- |
| Menu tapped | Opens with fade + slide down, **200ms ease-out**; the Header goes to State=Open (label "Close") |
| Close / Escape / any link tapped | Closes; focus returns to the Menu button |
| While open | Focus is trapped in the Header + Drawer; the page behind can't scroll |
| Reduced motion | Opens and closes instantly |

Figma prototype: Menu → the "menu open" frame, then Close → back.

## Panel fields / content rules

Same Site menu as the Header and Footer.

## HTML & accessibility

- `id="drawer"` controlled by the Menu button (`aria-controls`, `aria-expanded`).
- Use `inert` on `<main>` and `<footer>` while open, so focus and screen readers stay inside.
- Scroll lock: `overflow: hidden` on `<html>` while open (Lenis: `lenis.stop()` / `lenis.start()`).

## Open questions

-
