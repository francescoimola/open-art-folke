<?php

/**
 * Responsive <picture> for a Kirby file — AVIF → WebP → original fallback.
 *
 * Renders every variant from the `thumbs.srcsets` presets in config.php, so
 * one high-res upload serves an appropriately sized, modern-format image to
 * each device. Define the recipe once (config), reuse it here everywhere.
 *
 * Usage:
 *   snippet('image', [
 *     'file'  => $page->heroimage()->toFile(),
 *     'class' => 'hero__bg',
 *     'sizes' => '100vw',
 *     'hidden' => true,            // decorative → alt="" + aria-hidden
 *     'loading' => 'eager',        // hero/LCP; defaults to 'lazy'
 *   ]);
 *
 * @var Kirby\Cms\File|Kirby\Filesystem\Asset|null $file
 * @var string|null $sizes          the `sizes` attribute (default '100vw')
 * @var string|null $class          class for the <img>
 * @var string|null $style          inline style for the <img> (e.g. object-position)
 * @var string|null $alt            alt text; null → read the file's `alt` field
 * @var bool|null   $hidden         decorative? forces alt="" + aria-hidden="true"
 * @var string|null $loading        'lazy' (default) or 'eager'
 * @var string|null $fetchpriority  optional, e.g. 'high' for the hero LCP
 * @var int|null    $fallback       width of the plain <img src> fallback (default 1024)
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

?>
<picture>
  <source type="image/avif" srcset="<?= $file->srcset('avif') ?>" sizes="<?= $sizes ?>">
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
