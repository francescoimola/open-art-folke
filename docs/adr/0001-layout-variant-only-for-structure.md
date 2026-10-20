# Layout variants only where structure changes; size comes from Utopia

Figma can only show Utopia's Min (320) and Max (1500) endpoints, while the CSS is fluid in between. We decided that components do **not** get a Mobile/Desktop variant for size: every size difference comes from switching the Utopia variable mode. A `Layout = Stacked | Split` variant exists only where the structure itself changes (Header, Statement, Split group, Nav list, Sponsor grid, Footer).

## Considered Options

- **A Viewport variant on every component**: rejected. It doubles every set, and the two copies drift from each other and from the single fluid CSS rule.

## Consequences

- Image ratio changes (2:1 desktop → 1:1 / 3:2 mobile) are an instance property, not a Layout variant.
- Sponsor card's old `Size` axis exists only because of fixed logo slots; it is renamed to `Layout`, or removed if the slot can follow a token.
- Tablet gets no variant. It is handled at the very end, in code, once the design has been built.
