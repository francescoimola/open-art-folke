<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php snippet('seo') ?>

  <!-- Shared CSS / JS -->
  <?= vite()->css('index.scss') ?>
  <?= vite()->js('index.js', ['defer' => true]) ?>

  <!-- Per-page CSS / JS (loaded only when present) -->
  <?php $pageCss = vite()->css("templates/{$page->template()}.css", try: true)
              ?? vite()->css("templates/{$page->template()}.scss", try: true) ?>
  <?php $pageJs = vite()->js("templates/{$page->template()}.js", ['defer' => true], try: true) ?>
  <?= $pageCss ?>
  <?= $pageJs ?>
</head>

<body>
  <a class="skip-link" href="#main">Skip to content</a>
  <?php
  /*
   * Header (docs/components/header.md) + Drawer (docs/components/drawer.md), always Red.
   * One <nav> (ADR-0003): inline in the Header from tablet up, the Drawer below it, opened by the Menu button (src/drawer.js).
   */
  ?>
  <header class="header theme-red" data-header>
    <a class="header__home" href="<?= $site->url() ?>" aria-label="<?= $site->title()->esc() ?> — home"><?php snippet('logo', ['size' => 'header']) ?></a>
    <button class="header__menu link" type="button" aria-expanded="false" aria-controls="drawer" data-drawer-toggle data-label-open="Close">Menu</button>
    <nav id="drawer" class="header__nav drawer" aria-label="Main">
      <?php snippet('nav-list', ['layout' => ['stacked', 'inline'], 'register' => true]) ?>
    </nav>
  </header>
  <main id="main" tabindex="-1">
