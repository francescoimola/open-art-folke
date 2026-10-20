# Open Art Folke — Design System

The shared language for the OAF website's components, as designed in Figma and built in Kirby. Names here are used identically in Figma, snippets, CSS and docs.

## Component layers

**Primitive**:
The smallest reusable piece of UI, with no other components inside it (Link, Button, Icon, Image, Logo, Sponsor logo).
_Avoid_: Atom, element

**Composite**:
A small group of primitives that always travel together (Link + hint, Link list, Nav list, Sponsor card, Info item, Copy email).
_Avoid_: Molecule, widget

**Section**:
A full-width band of a page, built from composites and primitives (Header, Drawer, Statement, Photo band, Split group, Sponsor grid, Footer).
_Avoid_: Block, organism, module

## Variation

**Layout**:
The structural arrangement of a component: `Stacked` (one column, mobile) or `Split` (side by side, desktop). Only components whose structure changes have one.
_Avoid_: Breakpoint, Viewport, Mobile/Desktop variant

**Theme**:
The colour context a section sits in: **Flow** (default, light), **Red** (white on brand red) or **Ink** (light on near-black). Set on the section, never part of the component itself.
_Avoid_: Colour variant, skin, brand/paper/blush/crimson (retired theme names)

**State**:
How an interactive component looks in response to the user: Default, Hover, Focus, plus component-specific states such as Copied.
_Avoid_: Mode (reserved for Figma variable modes)

## Sections

**Statement**:
The opening band of a page: an h1, optional follow-on lines, and an optional arrow, on a Theme. The homepage intro is one Statement; inner pages use it as their title band.
_Avoid_: Hero, intro, title band

**Arrow target**:
The place the Statement's ↓ arrow links to: the first Homepage section by default, or one chosen in the Panel.

**Photo band**:
A full-bleed Image between sections.
_Avoid_: Banner, hero image, photo banner

**Photo pair**:
Two Images side by side at the same height, one square and one portrait; stacked on mobile.
_Avoid_: Gallery, image grid, diptych

**Split group**:
A heading in the left column with content in the right column, plus an optional media slot below; on mobile it stacks. Used for page content and footer rows alike.
_Avoid_: Row, two-column section, text group

**Homepage section**:
A Split group on the homepage whose order and visibility editors control in the Panel (Programme, About, Sponsors…). A section's photo belongs to it and moves with it.

**Edition**:
One past festival year on the Archive page: its title, text, optional video and uncropped photos. The Archive Statement links to each Edition by its year.
_Avoid_: Year block, archive entry, past-edition section

**Drawer**:
The mobile presentation of the site navigation, opened from the header's Menu button.
_Avoid_: Mobile menu, overlay, off-canvas

## Composites

**Link + hint**:
A link with a short line of supporting text beneath it ("Opens in a new tab").
_Avoid_: Link caption, helper text

**Hint**:
The supporting text in a Link + hint.

**Info item**:
One label → value pair in the footer's "All you need to know" list.
_Avoid_: Footer row, definition

**Person card**:
One member of the team: a square photo with their name, area and role stacked tightly beneath it.
_Avoid_: Team card, profile, bio

**Disclosure**:
A question that opens to reveal its answer, with a + / − Icon; used for FAQs.
_Avoid_: Accordion, toggle, details

**Lightbox**:
A single photo opened large over the page, from an Edition's photos; closing it returns the reader to where they were.
_Avoid_: Modal, popup, zoom view

**Site menu**:
The one Panel-managed list of navigation links shown in the header, the Drawer and the Footer.
_Avoid_: Primary nav, footer nav (as separate things)
