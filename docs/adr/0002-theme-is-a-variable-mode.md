# Theme is a variable mode, not a component variant

Sections take their colour (Flow, Red, Ink) from the Figma "Theme" variable collection's mode, set on the instance, mirroring a `.theme-*` class on the `<section>` in code. No component has a `Theme` property, so one component works in every theme without being copied. The exception is a State that deliberately switches theme (e.g. Sponsor card Hover/Focus going Red), which pins that mode inside its own variant.

## Consequences

- The site moves from five themes (brand, paper, blush, crimson, ink) to three. The old names are retired.
- Homepage sections lose their per-section colour pickers in the Panel; they all sit in Flow.
