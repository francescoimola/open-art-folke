# Person card

**Layer:** Composite · **Status:** figma · **Figma:** `392:1063` · **Code:** `site/snippets/person-card.php`, `.person-card` (planned)

## Purpose

One member of the team on the About page: a square photo with their name, area and role stacked tightly beneath it. Cards sit in a grid in the People [Split group](split-group.md)'s right column: 3 columns on large desktop, 2 below that.

## Anatomy

- **Photo** (`.person-card__photo`): an [Image](image.md), Ratio 1:1, full card width.
- **Details** (`.person-card__details`), with no gap between lines:
  - **strong · Name**: Caption, SemiBold, Theme/Text.
  - **span · Area**: Caption, Theme/Text secondary.
  - **span · Role**: Caption, Theme/Text secondary.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Name, Area, Role | text | |

No variants. The photo is an image override on the nested Image.

## Layout (Stacked ↔ Split)

None on the card itself; the grid around it changes its column count:

- **Large desktop** (Utopia Max): **3 columns** in the right column, Space S apart, which makes 261px cards. That matches the Sponsor grid.
- **Large tablet and below:** **2 columns**, down to 139px cards at 320.

In code, use a container query on the Content column rather than a viewport breakpoint. Grids are 2 columns by default and 3 once the column fits three cards of about 240px or more. The exact switch width gets settled in the tablet pass, at the end.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Photo → details | Space XS | |
| Type | Caption (step −2) | |
| Grid gap (row and column) | Space S | 14 → 18 |

## States & interactions

None. Photos lazy-load.

## Panel fields / content rules

The About page's `people` structure: `name`, `area`, `role`, `photo`. With no photo, the card shows the Image placeholder (decide: hide the card, or show a neutral tile?).

## HTML & accessibility

```html
<ul class="people" role="list">
  <li class="person-card">
    <figure class="person-card__photo"><?php snippet('image', [...]) ?></figure>
    <p class="person-card__details"><strong>Thurle Wright</strong> <span>Co-Chair</span> <span>Artist</span></p>
  </li>
</ul>
```

The photo's alt is empty (`alt=""`), because the name is right below it.

## Open questions

- A person without a photo: hide the card, or show a neutral tile?
