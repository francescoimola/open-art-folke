# Disclosure

**Layer:** Composite · **Status:** figma · **Figma:** `392:1095` · **Code:** `site/snippets/disclosure.php`, `.disclosure` (planned)

## Purpose

A question that opens to reveal its answer. Used for the About page FAQs, and likely on Archive and Sponsor too.

## Anatomy

- **summary** (`.disclosure__summary`): a row with
  - **h3 · Question**: Heading/H4, fills the row.
  - **Icon**: [Icon](icon.md), Glyph Plus (closed) or Minus (open), Size Default.
- **p · Answer** (`.disclosure__answer`): Body/Default, visible only when open.
- **Top rule**: 1px Theme/Text. The list wrapper adds the same rule at the bottom.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| State | Default, Hover, Focus, Open | |
| Question, Answer | text | |

## Layout (Stacked ↔ Split)

None, fluid only. It fills the Split group's Content column.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Padding block | Space S | 14 → 18 |
| Question → answer | Space XS | |
| Question → icon | Space S | 14 → 18 |
| Rule | 1px, Theme/Text | |

## States & interactions

- **Hover**: the question, icon and rule turn Theme/Link (red in Flow). 200ms ease-out.
- **Focus**: the focus ring on the summary (2px Theme/Text, 2px offset).
- **Open**: the icon swaps Plus → Minus and the answer shows. It opens instantly, with no height animation; the icon swap follows the motion token.
- Each Disclosure opens independently (no `name` grouping), and all start closed.

## Panel fields / content rules

The FAQs are hardcoded during the prototype. Planned: a `faqs` structure with `question` (text) and `answer` (writer, which allows links).

## HTML & accessibility

```html
<details class="disclosure">
  <summary class="disclosure__summary"><h3>Who are we here for?</h3><?php snippet('icon', ['glyph' => 'plus']) ?></summary>
  <div class="disclosure__answer"><p>…</p></div>
</details>
```

The native `<details>` handles the keyboard (Enter/Space) and announces expanded/collapsed. The icon is `aria-hidden`.

## Open questions

-
