# Video

**Layer:** Primitive · **Status:** code · **Figma:** `421:19` · **Code:** `site/snippets/vimeo.php`, `.video-embed` (`src/_layout.scss`)

## Purpose

A Vimeo embed at 16:9. Used in the [Edition](edition.md)'s right column.

## Anatomy

- **Poster · Vimeo embed**: a rectangle filling the frame. Vimeo provides the poster and controls; in Figma, set an image fill for mockups.

## Props & variants

None. It is always 16:9, filling the width of its container.

## Layout (Stacked ↔ Split)

None, fluid only.

## Tokens

None of its own.

## States & interactions

Vimeo's own player. Loads lazily, with do-not-track.

## Panel fields / content rules

A Vimeo share URL (`vimeo.com/123456789` or `…/123456789/abcdef` for unlisted). Empty means no video.

## HTML & accessibility

`snippet('vimeo', ['url' => …, 'title' => …])` renders the iframe inside Graffiti's `.aspect-video`. The title comes from the Edition headline.

## Open questions

-
