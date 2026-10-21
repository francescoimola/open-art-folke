<?php
/**
 * Icon — a drawn glyph in a 7×7 grid (docs/components/icon.md, ADR-0005).
 * Sized 0.75em of the surrounding text and coloured by currentColor, so one SVG serves every Link size.
 * Always aria-hidden: the meaning comes from the link's hint or visually hidden text.
 *
 * Usage: snippet('icon', ['glyph' => 'external'])
 *
 * @var string $glyph  external | arrow-down | plus | minus | close | arrow-left | arrow-right | check
 * @var string $class  optional extra classes
 */
$paths = [
  'external'    => 'M0 7L7 0M2 0H7V5',
  'arrow-down'  => 'M3.5 0V7M0 3.5L3.5 7L7 3.5',
  'plus'        => 'M3.5 0V7M0 3.5H7',
  'minus'       => 'M0 3.5H7',
  'close'       => 'M1 1L6 6M6 1L1 6',
  'arrow-left'  => 'M7 3.5H0M3.5 0L0 3.5L3.5 7',
  'arrow-right' => 'M0 3.5H7M3.5 0L7 3.5L3.5 7',
  'check'       => 'M0.3 3.8L2.6 6L6.7 1.1',
];

/* An unknown glyph renders nothing rather than breaking the page. */
$path = $paths[$glyph ?? ''] ?? null;
if ($path === null) return;

$classes = trim('icon icon--' . $glyph . ' ' . ($class ?? ''));
?>
<svg class="<?= esc($classes) ?>" viewBox="0 0 7 7" width="0.75em" height="0.75em" fill="none" stroke="currentColor" stroke-width="0.93" stroke-linecap="butt" stroke-linejoin="miter" aria-hidden="true" focusable="false"><path d="<?= $path ?>"/></svg>