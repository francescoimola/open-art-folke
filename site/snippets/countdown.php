<?php
/**
 * Countdown banner — coat.png revealed as vertical slices.
 *
 * The number of filled slices reflects the share of time remaining; the rest
 * read as pale empty blocks. Decorative composite: the grid carries one
 * accessible name and the individual cells are hidden from assistive tech.
 *
 * coat.png is pre-edited — no filter, no blend mode is applied here.
 */
?>
<div class="stack" style="width: 100%;">
  <div class="split no-wrap">
    <small><?= $page->countdownStartDate()->format('M Y') ?></small>
    <small style="margin-right: var(--vs-s)"><?= $page->countdownEndDate()->format('M Y') ?></small>
  </div>
  <div class="countdown">
    <?php snippet('image', [
      'file' => $page->countdownimage()->toFile(),
      'class' => 'countdown__img',
      'hidden' => true,
      'sizes' => '(min-width: 768px) 50vw, 100vw',
    ]) ?>
    <div
      class="countdown__grid" role="img" aria-label="<?= $page->daysRemaining() ?> days remaining until Open Art Folke">
      <?php for ($i = 0; $i < $page->countdownTotalBlocks(); $i++): ?>
        <span class="countdown__cell<?= $i < $page->countdownFilled() ? ' is-filled' : '' ?>" <?= $i < $page->countdownFilled() ? " style=\"--i: $i\"" : '' ?> aria-hidden="true"></span>
      <?php endfor ?>
    </div>
  </div>
</div>
