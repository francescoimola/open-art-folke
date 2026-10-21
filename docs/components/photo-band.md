# Photo band

**Layer:** Section · **Status:** code · **Figma:** `382:1137` · **Code:** `site/snippets/photo-band.php`, `.photo-band` (`src/_photo-band.scss`)

## Purpose

A full-bleed photo between sections: under the Statement, and before the Footer.

## Anatomy

- **Image**: an exposed [Image](image.md) instance at full width, with no padding or caption.

## Props & variants

None. Set **Ratio** on the exposed Image.

## Layout (Stacked ↔ Split)

| Band | Mobile | Desktop |
| --- | --- | --- |
| First (under the Statement) | 1:1 | 2:1 |
| Later | 3:2 | 2:1 |

Tablet (code): from 640px the first band is 3:2 too, so it doesn't fill a portrait tablet's screen; every band is 2:1 from 768px.

## Tokens

None. It spans the viewport (`100vw`); the height comes from the ratio.

## States & interactions

None. The first band loads eagerly (`loading="eager"`, `fetchpriority="high"`); later bands lazy-load. No parallax.

## Panel fields / content rules

- Homepage: `heroimage` (first band) and `bannerimage` (last band). Inner pages: an optional `bandimage`.
- JPEG around 2000px wide. Set a focus point, because the crop changes from 2:1 to 1:1.

## HTML & accessibility

```php
<figure class="photo-band"><?php snippet('image', ['file' => $img, 'sizes' => '100vw', …]) ?></figure>
```

Alt text comes from the file; purely decorative bands use `alt=""`.

## Open questions

-
