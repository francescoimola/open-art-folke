# Info item

**Layer:** Composite · **Status:** figma · **Figma:** `377:882` · **Code:** `.info-item` inside `.footer__info` (planned)

## Purpose

One label → value pair in the footer's "All you need to know" list: I'm a visitor, I'm an artist/creative, Find us on socials, Contact us.

## Anatomy

- **dt · Label**: Heading/H4 (body size, SemiBold), Theme/Text.
- **Value** (slot): any content: Body text, a [Link](link.md), a [Link list](link-list.md) or [Copy email](copy-email.md).

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | |
| Label | text | |
| Value | slot | Body text by default. |

## Layout (Stacked ↔ Split)

- **Split** (desktop): label and value in two equal columns (`1fr 1fr`), gap Layout/Gutter.
- **Stacked** (mobile): label above value, gap Space 2XS.

The same markup is used at both sizes (Q17): the mobile frame's h2 groups become this `dt`/`dd` structure.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Column gap (Split) | Layout/Gutter (Space S) | 14 → 18 |
| Label → value (Stacked) | Space 2XS | 7 → 9 |
| Between items | Space pair/M-L (set on the `dl`, in the Footer) | 21 → 36 |

## States & interactions

None of its own.

## Panel fields / content rules

Site → Footer: each item is a label plus a value. The value is either text or one of the link types. "Contact us" always uses Copy email.

## HTML & accessibility

```html
<dl class="footer__info">
  <div class="info-item">
    <dt class="h4">I’m an artist/creative</dt>
    <dd>Registration for the 2026 edition has now closed…</dd>
  </div>
</dl>
```

Wrapping each pair in a `<div>` is valid in a `dl` and gives the grid a row to lay out.

## Open questions

-
