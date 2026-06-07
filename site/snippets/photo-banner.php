<?php
$image ??= null;
$hideText ??= false;
$half ??= false;
$logoBottom ??= false;

$classes = 'theme-ink photo-banner stack-section';
if ($half) $classes .= ' half';
?>
<section class="<?= $classes ?>"<?= $logoBottom && $hideText ? ' style="align-items: end"' : '' ?>>
  <?php if ($image): ?>
    <?php snippet('image', [
      'file' => $image,
      'class' => 'photo-banner__bg darken-300',
      'hidden' => true,
      'sizes' => '100vw',
    ]) ?>
  <?php endif ?>
  <?php if ($hideText): ?>
    <div class="center-both full"><?php snippet('logo') ?></div>
  <?php else: ?>
    <div class="photo-banner__grid">
      <p>Open Art Folke 2026</p>
      <div><?php snippet('logo') ?></div>
      <p>9–11 October</p>
    </div>
  <?php endif ?>
</section>
