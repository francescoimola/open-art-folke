# Sponsor logo

**Layer:** Primitive · **Status:** code · **Figma:** source logos `325:378`, slots S `357:381` and M `359:509` · **Code:** `site/snippets/sponsor-logo.php`, `.sponsor-logo` (`src/_sponsor-logo.scss`); SVGs from `content/sponsor/*.svg`, sanitised by `SponsorPage::sponsorLogo()`

## Purpose

A sponsor's logo, sized to sit in a [Sponsor card](sponsor-card.md).

## Anatomy

- **Source logos** (`Sponsor logo/<Name>`): nine components imported from `content/sponsor/*.svg`, coloured Theme/Text.
- **Slots**: `Sponsor logo · S/<Name>` (72×40) and `Sponsor logo · M/<Name>` (108×60, 1.5× S). Each one rescales its source logo to fit, aligned top-left.

## Props & variants

None. Each sponsor is its own component, picked through the Sponsor card's **Logo** instance swap. The S and M slot sets exist because nested instances can't be resized, and a swap keeps the slot size of the variant.

## Layout (Stacked ↔ Split)

- S slot: Sponsor card Layout=Stacked (mobile).
- M slot: Layout=Split (desktop).

In CSS this is one fluid box (`max-width` / `max-height` on the `<svg>`), with no separate sizes.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Slot | `--sponsor-logo-w` × `--sponsor-logo-h` | 72×40 → 108×60 |
| Colour | Theme/Text, Theme Background on card hover | |

## States & interactions

None of its own. It turns off-white when its Sponsor card is hovered or focused.

## Panel fields / content rules

- Upload one SVG per sponsor page. Keep it single-colour, using `currentColor` or with fills removed, so the theme can colour it.
- Use a tight viewBox, with no padding baked into the artwork.
- Adding a sponsor in Figma means three components (source, S, M).

## HTML & accessibility

- An inline `<svg aria-hidden="true" focusable="false" preserveAspectRatio="xMinYMin meet">` in `<span class="sponsor-logo">`, inside the card's link. The link's text gives the sponsor name.
- The model turns every non-`none` fill into `currentColor`, and gives the root `fill="currentColor"` when it has none, so unfilled paths follow the Theme too.
- The slot shrinks with a narrow card (`max-inline-size: 100%`).

## Open questions

- ~~Should the slot become a fluid token?~~ Done: `--sponsor-logo-w` / `--sponsor-logo-h` in `src/_utopia.scss`. Figma keeps its S/M slots (nested instances can't be resized).
