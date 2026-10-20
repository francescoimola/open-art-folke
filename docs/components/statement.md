# Statement

**Layer:** Section · **Status:** figma · **Figma:** `382:1150` · **Code:** `site/snippets/statement.php`, `.statement` (planned; replaces `.hero`)

## Purpose

The opening band of every page: one h1 on a Theme. On the homepage, it's the "Open Art Folke is a community…" intro. Inner pages use it as their title band.

## Anatomy

- **h1**: Heading/H1 style (font size Step pair/4-6), made of up to three parts:
  - **Heading**: the first sentence.
  - **Body**: an optional follow-on sentence.
  - **Kicker**: an optional short closing line ("Come and have a nosey.").
- **Arrow** (Stacked only, optional): an [Icon](icon.md) Arrow down (Size=Large) as a link.

## Props & variants

| Property | Values | Notes |
| --- | --- | --- |
| Layout | Split, Stacked | |
| Statement (Split) | text | Desktop: the whole h1 as one paragraph. |
| Heading, Body, Kicker | text | Mobile: one line group each. |
| Arrow | on / off | Stacked only. Desktop has no arrow (user decision). |
| Show aside / Aside | on / off + text | Off by default. An optional Body paragraph (or two): in the right column on Split, with the h1 in the left; below the h1 on Stacked. Used on About. |
| Show links / Links | on / off + slot | Off by default. A row of [Links](link.md) under the Aside, Space XS apart with "·" between them. Archive uses it for the year links ("2025 · 2024", most recent first), each jumping to its [Edition](edition.md). About and Sponsor use it for one **skip link** with a drawn ↓ [Icon](icon.md) that jumps past the photos to the first text ("Here's how", "Read on"). Never "Learn more". Needs Show aside on. |

Theme is **Red** by default, pinned on the main; switch the Theme mode on the instance for inner pages.

Figma can't flow three text layers as one paragraph, so Split carries the joined text in its own property. In code there is **one** set of Panel fields (Heading, Body, Kicker).

## Layout (Stacked ↔ Split)

- **Split**: Heading, Body and Kicker run on as one paragraph. With the Aside on, the band becomes two equal columns, gap Layout/Gutter, matching the [Split group](split-group.md) grid.
- **Stacked**: each starts on its own line, one H1 line apart. The arrow sits Space XL below.

## Tokens

| Use | Token | Min (320) → Max (1500) |
| --- | --- | --- |
| Type | Step pair/4-6, Line height/H1, Letter spacing/H1 | 29.03 → 68.66 |
| Gap between parts (Stacked) | Line height/H1 | 35 → 76.5 |
| Text → arrow | Space XL | 42 → 54 |
| Padding block | Space pair/S-M | 14 → 27 |
| Padding inline | Layout/Margin | 14 → 27 |

## States & interactions

- **Static**: no typewriter. GSAP is removed from the homepage.
- The **arrow** is a real link (Link states: Focus ring, Hover).
  - Its target comes from the Panel's "Arrow goes to": the default is the first section (`#content`), or a chosen section.
  - It falls back to `#content` if the chosen section is hidden ([ADR-0004](../adr/0004-homepage-sections-order-and-visibility-only.md)).
  - It scrolls smoothly with Lenis (instant with reduced motion).

## Panel fields / content rules

- `statement_heading` (required), `statement_body`, `statement_kicker`, `statement_aside` (optional; a writer field, so it can hold paragraphs). Paragraphs in the Aside are Space M apart.
- `arrow_target` (homepage only): a select with "First section" plus the visible Homepage sections.
- Keep it to about 3 sentences: on mobile at 29px, more than about 15 lines pushes the photo out of the first screen.

## HTML & accessibility

```html
<section class="statement theme-red">
  <h1>Open Art Folke is a community of 200+ Folkestone artists.
    <span class="statement__line">Every so often, we throw…</span>
    <span class="statement__line">Come and have a nosey.</span></h1>
  <a class="statement__arrow" href="#content"><?php snippet('icon', ['glyph' => 'down']) ?><span class="visually-hidden">Skip to the programme</span></a>
</section>
```

- `.statement__line { display: block }` on mobile and `inline` on desktop, so the h1 stays one heading for screen readers.
- The arrow's hidden label names its actual target section.
- A **skip link** in Links is a normal same-page `<a href="#…">` with the ↓ Icon `aria-hidden`; Lenis scrolls to it (instant with reduced motion). Its target must be the first *text* after the photos, not the section that starts with them.

## Open questions

-
