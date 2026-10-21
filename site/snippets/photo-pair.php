<?php
/**
 * Photo pair — a square and a portrait photo at the same height (docs/components/photo-pair.md).
 * Split from tablet up (widths 3 : 2, gap Layout/Gutter); Stacked below (one column, same gap). The caller supplies the <section>.
 *
 * With 'wrap' (Sponsor page), below tablet the two photos join the parent section's flow and wrap its other content:
 * First → the section's other children → Second. The parent must be a flex or grid container (e.g. .page-section).
 *
 * Usage:
 *   <section class="page-section theme-flow"><?php snippet('photo-pair', ['first' => $a, 'second' => $b]) ?></section>
 *   <section class="page-section theme-ink" id="why"><?php snippet('photo-pair', ['first' => $a, 'second' => $b, 'wrap' => true]) ?><?php snippet('split-group', …) ?></section>
 *
 * @var \Kirby\Cms\File|null $first   the 1:1 photo
 * @var \Kirby\Cms\File|null $second  the 2:3 photo
 * @var bool                 $wrap    below tablet, wrap the section's other content (First → content → Second)
 * @var string               $class   extra classes
 */
$first ??= null;
$second ??= null;
if (empty($first) && empty($second)) return;

$classes = trim('photo-pair' . (($wrap ?? false) ? ' photo-pair--wrap' : '') . ' ' . ($class ?? ''));
?>
<div class="<?= esc($classes, 'attr') ?>">
  <?php if ($first): ?>
    <figure class="photo-pair__first"><?php snippet('image', ['file' => $first, 'sizes' => '(width >= 768px) 60vw, 100vw']) ?></figure>
  <?php endif ?>
  <?php if ($second): ?>
    <figure class="photo-pair__second"><?php snippet('image', ['file' => $second, 'sizes' => '(width >= 768px) 40vw, 100vw']) ?></figure>
  <?php endif ?>
</div>
