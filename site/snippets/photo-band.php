<?php
/**
 * Photo band — a full-bleed photo between sections (docs/components/photo-band.md). No padding, no caption, no Theme.
 * The first band (under the Statement) is 1:1 below tablet and loads eagerly at high priority; later bands are 3:2 and lazy.
 * Both are 2:1 from tablet up. Crops follow the file's focus point.
 *
 * Usage: snippet('photo-band', ['image' => $page->heroimage()->toFile(), 'first' => true])
 *
 * @var \Kirby\Cms\File|null $image   the photo; nothing renders without one
 * @var bool                 $first   the band under the Statement: 1:1 on mobile, eager + fetchpriority high
 * @var bool                 $hidden  purely decorative: alt="" (otherwise alt comes from the file)
 * @var string               $class   extra classes
 */
if (empty($image)) return;

$first ??= false;
?>
<figure class="<?= esc(trim('photo-band' . ($first ? ' photo-band--first' : '') . ' ' . ($class ?? '')), 'attr') ?>">
  <?php snippet('image', [
    'file'          => $image,
    'sizes'         => '100vw',
    'hidden'        => $hidden ?? false,
    'loading'       => $first ? 'eager' : 'lazy',
    'fetchpriority' => $first ? 'high' : null,
  ]) ?>
</figure>
