<?php snippet('header') ?>

<main class="page page-home">
  <h1><?= $page->title() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>
</main>

<?php snippet('footer') ?>
