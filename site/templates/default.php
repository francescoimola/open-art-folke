<?php snippet('header') ?>

<main class="container">
  <h1><?= $page->title() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>
</main>

<?php snippet('footer') ?>
