# Copy email

**Layer:** Composite · **Status:** code · **Figma:** `377:540` · **Code:** `site/snippets/copy-email.php` + `src/_copy-email.scss`, `.copy-email`; behaviour on `[data-copy]` in `src/index.js`

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

Site → Settings → Contact: **Contact email** (fallback `openartfolke@gmail.com`), used both for `data-copy` and for the visible address, and the **"Copy email" button label** (fallback "Copy email address").

Usage: `snippet('copy-email', ['variant' => 'secondary'])`. Options: `email`, `label` (both default to the Site fields), `variant` (`primary` | `secondary`, the Button variant), `class`. The Footer (Ink) uses `secondary`, matching Figma's light button there.

## HTML & accessibility

```html
<div class="copy-email">
  <button class="button button--secondary" type="button" data-copy="openartfolke@gmail.com" data-copied="Copied!" data-announce="Email address copied"><span class="button__label">Copy email address</span></button>
  <span class="visually-hidden" aria-live="polite" data-copy-status></span>
  <a class="copy-email__address" href="mailto:openartfolke@gmail.com">openartfolke@gmail.com</a>
</div>
```

The address is a `mailto:` link in code, so people can tap it too. Visually it stays plain Body text.

## Open questions

- ~~Should the visible address look like a link?~~ Settled: no, it stays plain Body text (spec #6). It keeps the Link focus ring.
