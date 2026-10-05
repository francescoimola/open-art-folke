<?php $sponsorPage = page('sponsor') ?>
<?php if ($sponsorPage): ?>
<section class="sponsors <?= $theme ?> stack-section flowing half panel even stack gap-xl">
  <h2>Recent sponsors</h2>

  <?php snippet('sponsor-list', [
    'sponsors' => $sponsorPage->currentSponsors(),
    'idPrefix' => 'home-sponsor',
  ]) ?>

  <div class="cluster gap-m accent">
    <a href="<?= $sponsorPage->url() ?>" class="button btt--secondary">See all our sponsors</a>
    <a href="/about">Who's behind Open Art Folke</a>
  </div>
</section>
<?php endif ?>
