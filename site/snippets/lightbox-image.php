<?php

/**
 * Carousel photo cell + pure-CSS (`:target`) lightbox. No JS: the thumbnail is
 * an anchor to a full-screen overlay revealed via `:target`; the overlay's
 * close button + backdrop are anchors back to `$closeTo`. Accessible no-JS
 * option (real focusable, labelled links). Caveats: no Escape key / focus trap.
 *
 * @var mixed       $file    Kirby File; null renders nothing
 * @var string|null $sizes   thumbnail `sizes` (passed to the image snippet)
 * @var string|null $closeTo fragment the close/backdrop links point back to
 *                           (e.g. '#edition-0') so closing never jumps to top
 */

if (empty($file)) {
  return;
}

$sizes   = $sizes ?? '100vw';
$closeTo = $closeTo ?? '#';

// Stable, fragment-safe id (File::id() contains slashes — not a valid id).
$lightboxId = 'photo-' . substr(md5($file->id()), 0, 10);

$alt   = $file instanceof \Kirby\Cms\File ? $file->alt()->or('')->value() : '';
$label = $alt !== '' ? $alt : 'photo';
?>
<a href="#<?= $lightboxId ?>" class="lightbox-trigger" aria-label="Enlarge <?= esc($label) ?>">
  <?php snippet('image', ['file' => $file, 'sizes' => $sizes]) ?>
</a>

<div id="<?= $lightboxId ?>" class="lightbox" role="dialog" aria-label="<?= esc($label) ?>" data-lenis-prevent>
  <a href="<?= esc($closeTo) ?>" class="lightbox__backdrop" tabindex="-1" aria-hidden="true"></a>
  <a href="<?= esc($closeTo) ?>" class="lightbox__close" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </a>
  <figure class="lightbox__figure">
    <?php snippet('image', ['file' => $file, 'sizes' => '90vw']) ?>
  </figure>
</div>
