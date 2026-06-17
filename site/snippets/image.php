<?php

/**
 * Responsive <picture> for a Kirby file. WebP + original-format fallback
 * (no AVIF — see the comment inside the <picture> below for why). Renders
 * the focus point as `object-position` unless the caller already set it.
 *
 * @var mixed $file Kirby File or Asset; null renders nothing
 * @var string|null $sizes defaults to '100vw'
 * @var string|null $class
 * @var string|null $style inline style (e.g. object-position)
 * @var string|null $alt  null → read the file's `alt` field
 * @var bool|null   $hidden  decorative? forces alt="" + aria-hidden="true"
 * @var string|null $loading 'lazy' (default) or 'eager'
 * @var string|null $fetchpriority
 * @var int|null    $fallback width of the plain <img src> fallback (default 1024)
 */

// Fail soft: an unset panel slot renders nothing rather than erroring.
if (empty($file)) {
  return;
}

$sizes    = $sizes ?? '100vw';
$loading  = $loading ?? 'lazy';
$fallback = $fallback ?? 1024;
$hidden   = $hidden ?? false;

if ($hidden === true) {
  $alt = '';
} elseif (($alt ?? null) === null) {
  // Cms\File exposes alt() as a magic content field (so method_exists is false);
  // Asset has no content fields. Read the panel `alt` field for real files only.
  $alt = $file instanceof \Kirby\Cms\File ? $file->alt()->or('')->value() : '';
}

$style = $style ?? '';

// Honour the Panel focus point: translate it into `object-position` so the
// browser's cover-crop keeps the chosen subject in frame. Skip when the caller
// already set `object-position` explicitly, or when no focus point is stored.
$objectPosition = null;
if (
  $file instanceof \Kirby\Cms\File &&
  str_contains($style, 'object-position') === false &&
  ($focus = $file->focus()->value()) !== null &&
  $focus !== ''
) {
  $objectPosition = \Kirby\Image\Focus::normalize($focus);
  $position = 'object-position: ' . $objectPosition . ';';
  $style    = $style === '' ? $position : $position . ' ' . $style;
}

?>
<picture>
  <?php /* WebP only; see "Responsive images" in AGENTS.md for why no AVIF. */ ?>
  <source type="image/webp" srcset="<?= $file->srcset('webp') ?>" sizes="<?= $sizes ?>">
  <img
    src="<?= $file->resize($fallback)->url() ?>"
    srcset="<?= $file->srcset('default') ?>"
    sizes="<?= $sizes ?>"
    width="<?= $file->width() ?>"
    height="<?= $file->height() ?>"
    alt="<?= esc($alt) ?>"
    loading="<?= $loading ?>"
    decoding="async"
    <?php if (!empty($fetchpriority)): ?>fetchpriority="<?= esc($fetchpriority) ?>"<?php endif ?>
    <?php if ($hidden === true): ?>aria-hidden="true"<?php endif ?>
    <?php if (!empty($class)): ?>class="<?= esc($class) ?>"<?php endif ?>
    <?php if (!empty($style)): ?>style="<?= esc($style) ?>"<?php endif ?>
  >
</picture>
