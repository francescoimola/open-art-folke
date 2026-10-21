# Design tokens

`variables-utopia-formulas.json` is the Figma variable export behind the Oct 2026 redesign, imported with the Variables Plus plugin (last import 2026-10-20). Use it as the source when porting tokens to CSS.

## What's in it

- **Utopia** (modes Min = 320px, Max = 1500px): type steps, space steps and pairs, line heights, letter spacing, layout (margin, gutter, nav, logo), icon box and stroke.
- **Theme** (modes Flow, Red, Ink): Background, Text, Text secondary, Link and the other theme colours. Red and Ink alias the OAF primitives library.

## Reading it

- `valuesByMode` holds fixed values; `expressionsByMode` holds formulas.
- `{{Utopia::Type%2FBase}}` means the variable `Type/Base` (URL-encoded `/`). Most of the scale derives from Type/Base (14 → 18) and Type/Ratio (1.2 → 1.25).
- `{{VariableID:…}}` in Theme points to a primitive in the OAF library. Its hex value is in `src/_tokens.scss`.

## Porting to CSS

Each Utopia variable becomes one fluid custom property, `clamp(Min, …, Max)` across 320 → 1500px, named as in its Figma code syntax (`--step-n`, `--space-*`, pairs). Theme modes map to `.theme-*` classes ([ADR-0002](../adr/0002-theme-is-a-variable-mode.md)).

Ported in `src/_utopia.scss` (drivers and formulas in Sass, so a changed variable is a changed driver) and `src/_themes.scss` (one map entry per Theme mode).

Keep this file in sync: re-export after changing variables in Figma.
