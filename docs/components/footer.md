# Footer

**Layer:** Section · **Status:** code · **Figma:** `385:1262` · **Code:** `site/snippets/site-footer.php` + `src/_footer.scss`, `.footer`

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

- **Site → Settings → Footer**: the Info heading, the four Info item labels, the visitor link label, and each legal row's heading and text (KirbyText). Media credits text stays in **Credits**; Instagram and Facebook in **Links**; the address and button label in **Contact**.
- Every field falls back to the Figma copy in code (`->or()`), so nothing needs copying into the Panel at ship time. The Copyright heading falls back to "Copyright © Open Art Folke, " and the current year.
- **Visitor item**: "See festival programme" links to the homepage's `#programme`. It is hidden, with its item, while `HomePage::showsProgramme()` is false (the same check as the Nav list).
- **Artist item** follows **Registration status** (`site/snippets/registration-notice.php`): Open shows the optional open message and Register ↗; Not open yet and Closed show that state's message, link and footnote. Closed falls back to the Figma copy.
- **Socials**: Instagram and Facebook, each shown only when its URL is set; the item hides when both are empty.

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

- ~~Logo and nav order on mobile~~: settled. Nav then logo in the HTML; CSS `order` puts the logo first below tablet.
- ~~The mobile 2px top rule~~: kept (Theme/Button secondary).
- **Tablet (768–1100px):** the nav row wraps, centred; the Info items stay stacked in the right column until it is 480px wide (about 1000px viewport), then go Split.
- The groups are Split-group rows built inside `.footer` (`.footer__group`), and Socials is a plain list of Links (`.footer__links`). Swap in the Split group and Link list snippets once they exist, if they fit.
