<?php snippet('header') ?>

<div class="layout-readable section stack">
  <h1><?= $page->title() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>
</div>

<?php snippet('site-footer') ?>
