# Copy email

**Layer:** Composite · **Status:** figma · **Figma:** `377:540` · **Code:** footer markup in `site/snippets/site-footer.php`; behaviour on `[data-copy]` in `src/index.js` (both exist)

## Purpose

Lets visitors copy the festival email address in one click, with the address always visible in case copying fails or they'd rather type it.

## Anatomy

- **Button**: a [Button](button.md) ("Copy email address"). Exposed, so its State shows on the instance.
- **Address**: Body/Default, Theme/Text.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Address | text | From the Panel. |
| Button → State | Default, Hover, Focus, Copied | |

## Layout (Stacked ↔ Split)

None, fluid only.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Button → address gap | Space 2XS | 7 → 9 |

## States & interactions

Click → the Button shows Copied for 2s and a polite live region announces "Email address copied" (see [Button](button.md)). If the clipboard write fails, nothing happens and the visible address remains.

## Panel fields / content rules

Site → contact email, used both for `data-copy` and for the visible address.

## HTML & accessibility

```html
<div class="copy-email">
  <button type="button" class="btt" data-copy="openartfolke@gmail.com">Copy email address</button>
  <span class="visually-hidden" aria-live="polite"></span>
  <a href="mailto:openartfolke@gmail.com">openartfolke@gmail.com</a>
</div>
```

The address is a `mailto:` link in code, so people can tap it too. Visually it stays plain Body text.

## Open questions

- Should the visible address look like a link (underlined), since it is one in code?
