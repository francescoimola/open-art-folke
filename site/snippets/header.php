<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title() ?> – <?= $site->title() ?></title>

  <!-- Shared CSS / JS -->
  <?= vite()->css('index.css') ?>
  <?= vite()->js('index.js', ['defer' => true]) ?>

  <!-- Per-page CSS / JS (loaded only when present) -->
  <?= vite()->css("templates/{$page->template()}.css", try: true) ?>
  <?= vite()->js("templates/{$page->template()}.js", ['defer' => true], try: true) ?>
</head>

<body>
  <?php snippet('menu') ?>
