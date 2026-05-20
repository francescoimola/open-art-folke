<?php snippet('header') ?>

<main class="page page-about">
  <h1><?= $page->title() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>
</main>

<?php snippet('footer') ?>
