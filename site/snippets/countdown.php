<?php
/**
 * Countdown banner. coat.png is pre-edited — no filter, no blend mode here.
 */
$days = $page->daysRemaining();
$total = $page->countdownTotalBlocks();
$filled = $page->countdownFilled();
?>
<div class="countdown-panel stack panel even">
  <div class="countdown-range split no-wrap">
    <small><?= $page->countdownStartDate()->format('M Y') ?></small>
    <small><?= $page->countdownEndDate()->format('M Y') ?></small>
  </div>
  <div class="countdown">
    <?php snippet('image', [
      'file' => $page->countdownimage()->toFile(),
      'class' => 'countdown__img',
      'hidden' => true,
      'sizes' => '(min-width: 768px) 50vw, 100vw',
    ]) ?>
    <div
      class="countdown__grid" role="img" aria-label="<?= $days ?> <?= $days === 1 ? 'day' : 'days' ?> remaining until Open Art Folke">
      <?php for ($i = 0; $i < $total; $i++): ?>
        <span class="countdown__cell<?= $i < $filled ? ' is-filled' : '' ?>" <?= $i < $filled ? " style=\"--i: $i\"" : '' ?> aria-hidden="true"></span>
      <?php endfor ?>
    </div>
  </div>
</div>
