# Utopia tokens are the source of truth; Graffiti reads from them

The redesign's sizes come from the Figma Utopia collection (`docs/tokens/variables-utopia-formulas.json`): fluid type steps, space steps and pairs across 320 → 1500px. In code, each becomes a `clamp()` custom property named as in Figma (`--step-*`, `--space-*`, pairs), and Graffiti's own type, spacing and colour tokens are re-pointed at them. Graffiti's classes and components keep working, but render the Figma scale exactly. Custom Utopia pairs (e.g. multi-step jumps such as `--space-s-xl`) are kept as custom properties of their own rather than rounded to a Graffiti step.

## Considered Options

- **Keep Graffiti's scale and round Figma to the nearest token (within ~15%)**: the previous rule. Rejected because the Figma Min/Max modes would no longer match the build.
- **Drop Graffiti**: rejected; a large rewrite for no visual gain.

## Consequences

- The `oaf-graffiti` skill's "nearest Graffiti token" and "no `clamp()` for type" rules give way to "use the Utopia token". The skill is updated as part of the token work.
