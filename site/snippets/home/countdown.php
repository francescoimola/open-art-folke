<section class="theme-blush stack-section half layout-split">
  <div
    class="stack panel even readable gap-l">
    <?php if ($page->festivalIsOver()): ?>
      <h2><?= $page->overheading()->or('You\'ve just missed this year\'s festival')->esc() ?></h2>
      <p class="close-trim"><?= $page->overtext()->or('It was a blast and we\'re still recovering. Keep an eye here and on your socials to know what\'s coming next. In the meantime, godspeed my friend!')->kti() ?></p>
    <?php else: ?>
      <?php $days = $page->daysRemaining() ?>
      <h2><?= $days === 1 ? 'There is' : 'There are' ?>
        <?= $days ?>
        <?= $days === 1 ? 'day' : 'days' ?>
        <?= $page->countdownheading()->or('until Open Art Folke ' . $page->festivalYear())->esc() ?><?= $days === 0 ? ' 🥳' : '' ?>
      </h2>
      <p class="close-trim"><?= $days === 0
        ? $page->countdownzerotext()->or('Time to leave the house, dear')->esc()
        : $page->countdowntext()->or('Almost there baby, almost there.')->esc() ?></p>
    <?php endif ?>
  </div>
  <?php if (!$page->festivalIsOver()): ?>
    <?php snippet('countdown') ?>
  <?php endif ?>
</section>
