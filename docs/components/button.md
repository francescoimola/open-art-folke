# Button

**Layer:** Primitive · **Status:** code · **Figma:** `333:267` · **Code:** `site/snippets/button.php` + `src/_buttons.scss`, `.button`; copy behaviour on `[data-copy]` in `src/index.js`

## Purpose

An action that stays on the page. Today its only use is copying the email address (see [Copy email](copy-email.md)). Navigation always uses [Link](link.md), never Button.

## Anatomy

- **Container**: filled with Theme/Button/Background, with a corner radius.
- **Label**: text in the UI/Button style, coloured Theme/Button/Text.
- **Focus ring** (Focus state only): 2px Theme/Text, 2px outside the container with a 2px gap.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| State | Default, Hover, Focus, Copied | Copied is specific to the copy action. |

## Layout (Stacked ↔ Split)

None, fluid only.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Padding block × inline | Space XS × Space S | 10.5 × 14 → 13.5 × 18 |
| Icon gap | Space 2XS | 7 → 9 |
| Label | Text style UI/Button | |
| Fill / label | Theme/Button/Background, Theme/Button/Text | follow the section's Theme |

## States & interactions

| State | Change | Trigger | Timing |
| --- | --- | --- | --- |
| Hover | Fill darkens 5%, and a shadow appears | `:hover` | 200ms ease-out |
| Focus | 2px ring with a 2px offset, in Theme/Text | `:focus-visible` | instant |
| Copied | The label becomes "Copied!" | click, once the clipboard write succeeds | returns to Default after **2s** |

- If the clipboard write fails, nothing happens. The address is always shown as text next to the button.
- Figma prototype: hover → Hover, click → Copied, then back to Default after a timeout. It can't really copy.
- With reduced motion, the hover change is instant.

## Panel fields / content rules

- `data-copy` holds the value to copy (the site email, from the Panel).
- Label: a verb plus an object ("Copy email address"), at most about 24 characters.

## HTML & accessibility

- `<button type="button" data-copy="…">`.
- Announce the change with a polite live region next to the button: `<span class="visually-hidden" aria-live="polite"></span>`, filled with "Email address copied". Changing the button label alone isn't reliably read out.

## Open questions

-
