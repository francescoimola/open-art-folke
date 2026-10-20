# Footer

**Layer:** Section · **Status:** figma · **Figma:** `385:1262` · **Code:** `site/snippets/site-footer.php` (exists; to be reworked)

## Purpose

The end of every page: the Site menu again, the OA mark, practical info and the legal text.

## Anatomy

Built entirely from instances:

- **nav · Footer**: [Nav list](nav-list.md) with Start here on and Register off.
- **Logo**: [Logo](logo.md), Size=Footer.
- **Section · Info**: [Split groups](split-group.md), each with Divider on:
  - **All you need to know**: a `dl` of [Info items](info-item.md):
    - visitor: a Link;
    - artist: text;
    - socials: a [Link list](link-list.md);
    - contact: [Copy email](copy-email.md).
  - **Legal rows**: Media credits, Privacy, Fundraising, Terms, Copyright, each heading + body text.

## Props & variants

| Layout | Order | Nav |
| --- | --- | --- |
| Split | Nav, Logo, Info | centred row (Split/Large) |
| Stacked | Logo, Nav, Info | column (Stacked/Large), with a 1px rule above it |

Theme is **Ink**, pinned on the main. Stacked also has a 2px top rule in Button secondary/Background (from the mobile design).

## Layout (Stacked ↔ Split)

- Info items and legal rows go from two columns to stacked.
- The **logo/nav order swaps**: see Open questions.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Padding inline | Layout/Margin | 14 → 27 |
| Padding bottom | Space pair/2XL-3XL | 56 → 108 |
| Nav row padding block (Split) | Space pair/2XL-3XL | 56 → 108 |
| Logo padding top / bottom | Space pair/S-XL / Space pair/2XL-3XL | 14 → 54 / 56 → 108 |
| Between groups | Space 2XL | 56 → 72 |
| Info items | Space pair/M-L | 21 → 36 |
| Row padding block | Space 2XS | 7 → 9 |

## States & interactions

Only the links' own states and Copy email. The footer stays in place between pages (`view-transition-name: site-footer`).

## Panel fields / content rules

- **Site → Footer**: the Info items (label + value) and the legal rows (heading + text).
- The footer copy currently exists **in Figma only**. Copy it into the production Panel when the code ships.

## HTML & accessibility

```html
<footer class="footer theme-ink">
  <nav aria-label="Footer"> … </nav>
  <?php snippet('logo') ?>
  <section class="split-group" aria-labelledby="info-title"> <h2 id="info-title">All you need to know</h2> <dl>…</dl> </section>
  …
</footer>
```

## Open questions

- **Logo and nav are in a different order on mobile.** One HTML order is needed. I suggest **nav then logo** in the HTML (matching desktop and reading order), with CSS `order` putting the logo first on mobile. The order is purely visual and the logo is decorative, so this is safe.
- Keep the mobile 2px top rule, or drop it to match desktop?
