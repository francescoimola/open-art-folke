# Person card

**Layer:** Composite · **Status:** code · **Figma:** `392:1063` · **Code:** `site/snippets/person-card.php`, `.person-card` and its grid `.people` (`src/_person-card.scss`)

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

In code, `.people` is a container and `.people__list` the grid: 2 columns by default, 3 once the container is 640px or wider (mixin `cq-large`), so cards are at least about 200px. On the About page that switch happens at about 1340px viewports, so tablets and most laptops get 2 columns. A lone card on the last row stays left-aligned.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Photo → details | Space XS | |
| Type | Caption (step −2) | |
| Grid gap (row and column) | Space S | 14 → 18 |

## States & interactions

None. Photos lazy-load.

## Panel fields / content rules

The About page's `people` structure: `name`, `area`, `role`, `photo`. With no photo, the card shows a solid Neutral/100 tile (spec #6). An empty Area or Role line is left out; a person without a name renders nothing.

## HTML & accessibility

```php
<div class="people">
  <ul class="people__list" role="list">
    <?php snippet('person-card', ['name' => $person->name(), 'area' => $person->area(), 'role' => $person->role(), 'photo' => $person->photo()->toFile()]) ?>
  </ul>
</div>
```

Each card renders:

```html
<li class="person-card">
  <figure class="person-card__photo"><picture>…</picture></figure>
  <p class="person-card__details"><strong>Thurle Wright</strong> <span>Co-Chair</span> <span>Artist</span></p>
</li>
```

Without a photo, the figure becomes `<div class="person-card__photo person-card__photo--empty"></div>`.

The photo's alt is empty (`alt=""`), because the name is right below it.

## Open questions

- ~~A person without a photo: hide the card, or show a neutral tile?~~ Settled: a Neutral/100 tile (spec #6).
