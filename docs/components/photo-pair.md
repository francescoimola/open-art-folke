# Photo pair

**Layer:** Section · **Status:** code · **Figma:** `399:1838` · **Code:** `site/snippets/photo-pair.php`, `.photo-pair` (`src/_photo-pair.scss`)

## Purpose

Two photos side by side at the same height: a square one and a portrait one, as on the original About page. On About it sits between the "How we make it possible" blocks and People.

## Anatomy

- **Image · First** (`.photo-pair__first`): an [Image](image.md), Ratio 1:1.
- **Image · Second** (`.photo-pair__second`): an [Image](image.md), Ratio 2:3.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | Split is pinned to Utopia Max, Stacked to Min. |

The photos are image overrides on the nested Images.

## Layout (Stacked ↔ Split)

- **Split**: one row. The widths split 3 : 2, so a 1:1 and a 2:3 come out at the same height. Gap Layout/Gutter.
- **Stacked**: one column, each photo at full width, gap Layout/Gutter.
- **Tablet (code):** Split starts at 640px, not 768px, because two stacked full-width photos are very tall on a portrait tablet. The Sponsor wrap applies below 640px.
- **Wrapping a Split group (Sponsor page):** the pair and a Split group share one section. On desktop the pair comes first. On mobile the photos wrap the text (First → Split group → Second). Figma shows the two Images loose around the Split group. In code: one `<section>`, `.photo-pair { display: contents }` below the switch point, and `order` on its two figures.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Gap | Layout/Gutter | 14 → 18 |
| Section padding | Space pair/L-XL block, Layout/Margin inline | |

## States & interactions

None. Both photos lazy-load.

## Panel fields / content rules

About: `image1` (first) and `image2` (second). Set focus points, because both are cropped to a fixed ratio.

## HTML & accessibility

```html
<section class="photo-pair">
  <figure class="photo-pair__first"><?php snippet('image', [...]) ?></figure>
  <figure class="photo-pair__second"><?php snippet('image', [...]) ?></figure>
</section>
```

CSS: `display: grid; grid-template-columns: 3fr 2fr; gap: var(--gutter)`, with one column below the switch point. Alt text comes from each file.

## Open questions

-
