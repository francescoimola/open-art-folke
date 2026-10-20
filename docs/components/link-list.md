# Link list

**Layer:** Composite · **Status:** figma · **Figma:** `377:532` · **Code:** `.link-list` (planned)

## Purpose

A short vertical list of plain links: the About links ("Scroll through our archives", "See who is behind Open Art Folke") and the social links in the footer.

## Anatomy

- **Links** (slot): any number of [Link](link.md) instances, Size=Default.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Links | slot | Drop, reorder or remove Link instances. |

## Layout (Stacked ↔ Split)

None, fluid only. The gap is Space XS everywhere (user decision, 2026-10-20): the About links and footer Socials both change to match it.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Gap between links | Space XS | 10.5 → 13.5 |

## States & interactions

Only the Links' own states.

## Panel fields / content rules

- Each item is label + URL. External items get the ↗ icon automatically.
- Keep it to 2–4 links. Longer lists become a [Nav list](nav-list.md) or their own section.

## HTML & accessibility

```html
<ul class="link-list" role="list">
  <li><a href="/archive">Scroll through our archives</a></li>
  …
</ul>
```

`role="list"` keeps list semantics in Safari once `list-style: none` is applied.

## Open questions

-
