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
  <div class="split">
        <small><?= $page->countdownStartDate()->format('M Y') ?></small>
        <small style="margin-right: var(--vs-s)"><?= $page->countdownEndDate()->format('M Y') ?></small>
  </div>
  <div class="countdown">
    <img class="countdown__img" src="/assets/images/coat.png" alt="" aria-hidden="true">
    <div class="countdown__grid" role="img" aria-label="<?= $page->daysRemaining() ?> days remaining until Open Art Folke">
      <?php for ($i = 0; $i < $page->countdownTotalBlocks(); $i++): ?>
        <span class="countdown__cell<?= $i < $page->countdownFilled() ? ' is-filled' : '' ?>" aria-hidden="true"></span>
      <?php endfor ?>
    </div>
  </div>
</div>