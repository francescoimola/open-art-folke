# Split group

**Layer:** Section · **Status:** code · **Figma:** `381:589` · **Code:** `site/snippets/split-group.php`, `.split-group` (`src/_split-group.scss`)

## Purpose

The workhorse content block: a heading in the left column and content in the right. It's used for every Homepage section (Programme, About, Sponsors) and every footer row. On mobile it stacks.

## Anatomy

- **Row**:
  - **h2 · Heading**: Heading/H2.
  - **Content** (slot): body text, [Link + hint](link-hint.md), [Link list](link-list.md), [Sponsor grid](sponsor-grid.md), a `dl` of [Info items](info-item.md)… Items inside are Space M apart.
- **Column media row** (optional): a slot in the right column, with an empty left column. Takes a 3:2 [Image](image.md).
- **Media** (optional): a full-width slot. Takes a 2:1 Image on desktop, 3:2 on mobile.
- **Divider** (optional): a 1px Theme/Text rule across the top. Used for footer rows.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | Split's main is pinned to Utopia Max and Stacked's to Min, so the gallery shows the right endpoint. |
| Heading | text | |
| Content | slot | |
| Show column media / Column media | on / off + slot | |
| Show media / Media | on / off + slot | |
| Divider | on / off | Footer rows. Their instances also set padding block to Space 2XS. |

## Layout (Stacked ↔ Split)

- **Split**: Row = two equal columns (`1fr 1fr`), gap Space L (2 × Layout/Gutter; doubled from the Figma gutter in the user's review, #30).
- **Stacked**: heading above content, gap Space pair/S-M.

Both stack Row → Column media → Media with gap Space pair/XL-M (a gap that *shrinks* from 42 on mobile to 27 on desktop).

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Column gap (Split) | Space L (2 × Layout/Gutter, #30) | 28 → 36 |
| Heading → content (Stacked) | Space pair/S-M | 14 → 27 |
| Inside Content | Space M | 21 → 27 |
| Row → media | Space pair/XL-M | 42 → 27 |
| Divider | 1px, Theme/Text | |

## States & interactions

None of its own. Photos lazy-load.

## Panel fields / content rules

- **Homepage sections** are Split groups. Editors control their order and visibility ([ADR-0004](../adr/0004-homepage-sections-order-and-visibility-only.md)).
- Each section's photo is part of it (`<section>image`) and moves with it.
- Each section gets a stable `id` (`#programme`, `#about`, `#sponsors`) for anchors and the Statement arrow.
- **Custom sections** (up to two, `site/snippets/blocks/custom.php`) are Split groups too: heading (required), text, up to two links (Link, or Link + hint when a hint is given), optional photo. Photo size Column = Column media, Wide = Media; position Before the text = media above the Row. Their `id` is the heading's slug, suffixed `-2`, `-3`… if it clashes with another id on the page (`HomePage::sectionId()`).
- A heading-only group renders no content box, so no gap hangs under the heading.
- The first section's wrapper carries `#content`.

## HTML & accessibility

```html
<section class="split-group" id="programme" aria-labelledby="programme-title">
  <h2 id="programme-title">The 2026 festival programme</h2>
  <div class="split-group__content"> … </div>
  <figure class="split-group__media split-group__media--column"> … </figure>
</section>
```

CSS: `display: grid; grid-template-columns: 1fr 1fr; column-gap: var(--space-l)`, with the heading in column 1, content in column 2, `--column` media in column 2 and wide media spanning `1 / -1`. One column below the switch point.

## Open questions

-
