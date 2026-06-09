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
 *
 * Cropping is done in the browser via `object-fit: cover` on the layout classes.
 * The crop position follows the file's Panel focus point: it's read here and
 * emitted as `object-position`. A caller-supplied `$style` containing
 * `object-position` overrides the focus point.
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

$style = $style ?? '';

// Honour the Panel focus point: translate it into `object-position` so the
// browser's cover-crop keeps the chosen subject in frame. Skip when the caller
// already set `object-position` explicitly, or when no focus point is stored.
if (
  $file instanceof \Kirby\Cms\File &&
  str_contains($style, 'object-position') === false &&
  ($focus = $file->focus()->value()) !== null &&
  $focus !== ''
) {
  $position = 'object-position: ' . \Kirby\Image\Focus::normalize($focus) . ';';
  $style    = $style === '' ? $position : $position . ' ' . $style;
}

?>
<picture>
  <?php /* No AVIF source on purpose: encoding AVIF from our large (2560px)
     source photos exceeds the hosting container's per-request memory
     (libavif allocates outside PHP's memory_limit) and 503s — even at
     1920w under real web load. WebP is light to encode, serves the full
     width ladder reliably, and via srcset gives every device (incl. large
     retina) the right resolution. JPEG/PNG `<img>` below is the fallback. */ ?>
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
