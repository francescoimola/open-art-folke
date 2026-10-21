# Link + hint

**Layer:** Composite · **Status:** code · **Figma:** `377:525` · **Code:** `site/snippets/link-hint.php`, `.link-hint` (`src/_link-hint.scss`)

## Purpose

A call-to-action link with one line underneath explaining what happens next ("Opens in a new tab", "Save the programme on your device"). Used in the Programme group.

## Anatomy

- **Link**: a [Link](link.md), Size=Large, Show icon on (External ↗ or Arrow down ↓). Exposed, so its props show on the instance.
- **Hint** (`.link-hint__hint`): Body/Default in Theme/Text secondary.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Hint | text | One short line. |
| Link → Glyph | External, Arrow down | Set on the exposed Link → Icon. |

## Layout (Stacked ↔ Split)

None, fluid only. Several Link + hints stack in their column with Space M (one body line) between them.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Link → hint gap | none (0) | the line heights set the rhythm |
| Hint | Body/Default, Theme/Text secondary | 14 → 18 / line height 21 → 27 |

## States & interactions

Only the Link's own states (Hover, Focus). The hint never changes.

## Panel fields / content rules

- Link label, URL (or file) and hint text are Panel fields wherever the composite is used.
- The hint describes the *consequence* of clicking, not the destination, and is at most about 40 characters.

## HTML & accessibility

```html
<p class="link-hint">
  <a href="…" target="_blank" rel="noopener" aria-describedby="hint-programme">See programme<svg class="icon" …/></a>
  <span class="link-hint__hint" id="hint-programme">Opens in a new tab</span>
</p>
```

- `aria-describedby` points at the hint, so screen readers hear it after the label. Ids must be unique per page.
- Because the hint already says "Opens in a new tab", leave out the visually hidden version.

## Open questions

-
