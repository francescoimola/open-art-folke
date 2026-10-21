<?php
/**
 * Button — an action that stays on the page (docs/components/button.md). Navigation always uses the Link snippet.
 * Colours follow the section's Theme (--theme-button*). With `copy`, a click copies the value (src/index.js),
 * shows the Copied label for 2s and announces it through a polite live region next to the button.
 *
 * Usage: snippet('button', ['label' => 'Copy email address', 'copy' => $email, 'announce' => 'Email address copied'])
 *
 * @var string      $label     required; plain text, escaped here
 * @var string      $variant   'primary' (Theme/Button) | 'secondary' (Theme/Button secondary)
 * @var string      $type      button | submit | reset
 * @var string|null $icon      Icon glyph after the label (gap Space 2XS)
 * @var string|null $copy      value to copy to the clipboard
 * @var string      $copied    label shown for 2s after a successful copy
 * @var string      $announce  text read out by the live region after a copy
 * @var string      $class     extra classes
 * @var array       $attrs     extra attributes, merged last
 */
$copy ??= null;
$variant = ($variant ?? 'primary') === 'secondary' ? 'secondary' : 'primary';

$attributes = array_merge([
  'class'          => trim('button' . ($variant === 'secondary' ? ' button--secondary' : '') . ' ' . ($class ?? '')),
  'type'           => in_array($type ?? null, ['submit', 'reset'], true) ? $type : 'button',
  'data-copy'      => $copy,
  'data-copied'    => $copy !== null ? ($copied ?? 'Copied!') : null,
  'data-announce'  => $copy !== null ? ($announce ?? 'Copied') : null,
], $attrs ?? []);
?>
<button<?= attr($attributes, ' ') ?>><span class="button__label"><?= esc($label ?? '') ?></span><?php if (!empty($icon)) snippet('icon', ['glyph' => $icon]) ?></button>
<?php if ($copy !== null): ?>
<span class="visually-hidden" aria-live="polite" data-copy-status></span>
<?php endif ?>
