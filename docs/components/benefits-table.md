# Benefits table

**Layer:** Composite · **Status:** figma · **Figma:** `450:3590` · **Code:** `site/snippets/benefits-table.php`, `.benefits-table` (planned; replaces the inline `<table>` in `sponsor.php`)

## Purpose

The Gold / Silver / Bronze comparison on the Sponsor page: what each Tier gets. It sits in the "What sponsors get" [Split group](split-group.md), with the small print underneath.

## Anatomy

- **thead · tr**: `th · Benefit` (hidden on Stacked), then **Tiers**: `th · Gold`, `th · Silver`, `th · Bronze`. Body/Default in Theme/Text secondary, with a 1px Theme/Text rule below.
- **tr** (one per benefit), with a 1px Theme/Text rule at 20% below:
  - `th[scope=row]`: the benefit, Body/Default in Theme/Text.
  - **Tiers**: three `td` cells. Each holds one of:
    - an [Icon](icon.md) Glyph=Check, Size=Large, in Theme/Accent (red on Flow);
    - short text ("Full page");
    - nothing (`td · Not included`).

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | Split is pinned to Utopia Max, Stacked to Min. |

Rows are plain frames inside the component; edit their text on the instance. In code they come from the Panel.

## Layout (Stacked ↔ Split)

- **Split**: one line per benefit. The benefit column takes half the width and the three tiers share the other half (`grid-template-columns: 3fr repeat(3, 1fr)`), gap Layout/Gutter.
- **Stacked**: each benefit takes its own full-width line, with its three tier cells on a line beneath it (Space 2XS apart). The header row shows only Gold · Silver · Bronze, aligned to the cells. This layout was chosen because four columns at 320 left about 40px per Tier ("Bronze" and "Full page" didn't fit).

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Row padding block | Space XS | 10.5 → 13.5 |
| Column gap | Layout/Gutter | 14 → 18 |
| Benefit → tiers (Stacked) | Space 2XS | 7 → 9 |
| Tick | Icon/Large, Icon stroke/Large | 18.14 → 26.37 |
| Rules | 1px Theme/Text (header), Theme/Text at 20% (rows) | |

## States & interactions

None. A static table.

## Panel fields / content rules

Sponsor page `benefits` structure (exists): `benefit`, `gold`, `silver`, `bronze`.

- A blank tier → an empty cell with visually hidden "Not included".
- "Yes" (or y, ✓, true) → the Check icon with visually hidden "Included".
- Anything else is shown as text. Keep it to one or two short words ("Full page"), since the tier column is narrow on mobile.

## HTML & accessibility

```html
<table class="benefits-table" role="table">
  <thead role="rowgroup">
    <tr role="row"><th scope="col" role="columnheader">Benefit</th><th scope="col" role="columnheader">Gold</th>…</tr>
  </thead>
  <tbody role="rowgroup">
    <tr role="row">
      <th scope="row" role="rowheader">Mention in press releases</th>
      <td role="cell"><?php snippet('icon', ['glyph' => 'check']) ?><span class="visually-hidden">Included</span></td>
      …
      <td role="cell"><span class="visually-hidden">Not included</span></td>
    </tr>
  </tbody>
</table>
```

- **Keep the explicit ARIA table roles.** The Stacked layout changes each `tr` to `display: grid`. Some browsers, Safari in particular, then drop the table semantics. A screen reader would read loose ticks without saying which tier or benefit they belong to. The roles restore that, and they're harmless on Split.
- On Stacked, the "Benefit" column header is visually hidden, not removed.
- The tick SVG is `aria-hidden`. The hidden "Included" / "Not included" text carries the meaning.

## Open questions

- In Figma the tick sits at the top of its cell. Check its alignment against the first line of the benefit in code (see the [Icon](icon.md) alignment question).
