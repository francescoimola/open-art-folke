# Link

**Layer:** Primitive · **Status:** code · **Figma:** `333:255` · **Code:** `site/snippets/link.php` + `src/_link.scss`, `.link`

## Purpose

The site's text link: inline in body copy, standalone as calls to action ("See programme ↗"), and inside Nav lists, Link lists and the Footer.

## Anatomy

- **Label**: text in the Link/Default or Link/Large style. Contains no typed arrows.
- **Icon** (optional): an exposed [Icon](icon.md) instance after the label: External ↗ or Arrow down ↓. Gap: Space 3XS (Default) or Space 2XS (Large).
- **Focus ring** (Focus state only): an absolutely positioned outline, 2px outside the label with a 2px gap.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Size | Default, Large | Default = body size. Large = H3 size, used in the Drawer and for stand-alone calls to action. |
| State | Default, Hover, Focus | |
| Show icon | on / off | Off by default. When on, pick **Glyph** on the exposed Icon. The Icon's size follows the Link's Size automatically. |

Edit the label text directly on instances. Binding a TEXT property would force every variant to share the same text formatting.

## Layout (Stacked ↔ Split)

None, fluid only.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Default text | Text style Link/Default (step 0, Medium, underlined) | 14 → 18, line height 21 → 27 |
| Large text | Text style Link/Large (step 3, underlined) | line height 28 → 45 |
| Colour | Theme/Link | red in Flow; adapts in Red and Ink |
| Focus ring | Theme/Text, 2px, 2px offset | fixed |

## States & interactions

| State | Change | Trigger |
| --- | --- | --- |
| Default | Underlined | |
| Hover | Underline removed | `:hover`. Figma: While hovering. |
| Focus | Underline kept, plus a 2px ring in Theme/Text with a 2px offset | `:focus-visible` only, never on mouse click |

The underline change is instant; it isn't animated. With reduced motion, nothing changes.

## Panel fields / content rules

- **↗** = external link, which opens in a new tab. **↓** = file download. No arrow = internal page or anchor.
- Keep labels to what the link *does* ("See programme", "Download PDF"), never "click here".

## HTML & accessibility

- `<a href>`. External links: `target="_blank" rel="noopener"`. When there is no visible Hint, add visually hidden text: `<span class="visually-hidden">(opens in a new tab)</span>`.
- The icon is an inline SVG from the `icon` snippet and is always `aria-hidden` (see [Icon](icon.md)). This replaces `<span aria-hidden="true">↗</span>` and its Firefox underline fix.
- CSS: `a:focus-visible { outline: 2px solid currentColor; outline-offset: 2px; }`, using Theme/Text as the colour.

## Open questions

- Sponsor names use Link/Compact (no underline, black). Is that a third Size, or the Sponsor card's own text style? For now it belongs to the Sponsor card.
