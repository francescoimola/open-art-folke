# Homepage sections are Panel blocks, with placeholders for the fixed sections

Supersedes [ADR-0004](0004-homepage-sections-order-and-visibility-only.md).

Editors need to add, hide, remove and reorder Homepage sections, including up to two Custom sections, which make up for the retired Countdown. The section list is a Kirby Blocks field with two kinds of block:

- **Placeholders** for Programme, About and Sponsors. They carry no content, only position and visibility; each section's content stays in its existing fields, so live content never moves.
- **Custom section**: a Split group with its own heading, text, up to two links and an optional photo (before or after the text; Column or Wide), always in Flow.

Hiding uses the Blocks field's own hide toggle. An empty field (live, right after the switch-over) falls back to Programme → About → Sponsors. A hidden or removed Programme also hides the nav's programme link. The Statement arrow targets `#content` or a chosen section, as before.

## Considered Options

- **Keep the multiselect and add a separate list of extra sections**, merging the two into one set of order options. Rejected: more custom code to maintain for a junior maintainer, where Blocks gives add/hide/reorder natively.
- **Blocks holding all section content**: rejected; it would move live Programme/About/Sponsors content into new fields at the switch-over.

## Consequences

- One snippet per block type; the template loops over the blocks.
- The cap of two Custom sections and one of each placeholder is enforced in rendering, and explained in the field's help text.
