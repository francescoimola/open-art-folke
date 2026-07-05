<?php
$status = $site->registration_status()->or('closed')->value();
$registerUrl = $site->register_url()->isNotEmpty() ? $site->register_url()->value() : null;
?>
<header class="site-nav theme-brand" aria-label="<?= $site->title()->html() ?>">
  <nav class="site-nav__group" aria-label="Primary">
    <a href="<?= $site->url() ?>" class="site-nav__logo site-nav__logo--topbar" aria-label="<?= $site->title()->html() ?> — home">
      <?php snippet('logo') ?>
    </a>
    <ul class="site-nav__links" role="list">
      <li class="fs-s">
        <a class="underline" href="<?= $site->homePage()->url() ?>#programme">Programme</a>
      </li>
      <?php foreach($site->children()->not('home', 'media') as $child): ?>
        <li class="fs-s">
          <a class="underline" href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
        </li>
      <?php endforeach ?>
    </ul>
  </nav>
  <div class="site-nav__group">
    <button class="site-nav__menu-toggle minimal underline-on-hover" popovertarget="mobile-drawer">Menu</button>
    <?php if ($status === 'open'): ?>
      <?php if ($registerUrl): ?>
        <a href="<?= esc($registerUrl, 'attr') ?>" class="site-nav__register fs-s" rel="noopener noreferrer" target="_blank">
          Register <span aria-hidden="true">↗</span>
        </a>
      <?php endif ?>
    <?php else: ?>
      <button type="button" popovertarget="registration-popover" data-popover-origin="nav" class="minimal underline site-nav__register fs-s">
        Register <span aria-hidden="true">↗</span>
      </button>
    <?php endif ?>
  </div>
</header>

<aside id="mobile-drawer" popover="auto" class="drawer mobile-drawer theme-brand">
  <div class="split mobile-drawer__header">
    <a href="<?= $site->url() ?>" class="site-nav__logo" aria-label="<?= $site->title()->html() ?> — home">
      <?php snippet('logo') ?>
    </a>
    <button class="minimal close" popovertarget="mobile-drawer" popovertargetaction="hide" aria-label="Close menu">&times;</button>
  </div>
  <nav class="stack mobile-drawer__nav" aria-label="Mobile navigation">
    <a href="<?= $site->url() ?>"<?= e($site->homePage()->isActive(), ' aria-current="page"') ?>>Home</a>
    <a href="<?= $site->homePage()->url() ?>#programme">Programme</a>
    <?php foreach($site->children()->not('home', 'media') as $child): ?>
      <a href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
    <?php endforeach ?>
    <?php if ($status === 'open'): ?>
      <?php if ($registerUrl): ?>
        <a href="<?= esc($registerUrl, 'attr') ?>" rel="noopener noreferrer" target="_blank">
          Register <span aria-hidden="true">↗</span>
        </a>
      <?php endif ?>
    <?php else: ?>
      <button type="button" popovertarget="registration-popover" data-popover-origin="nav" class="minimal underline-on-hover">
        Register <span aria-hidden="true">↗</span>
      </button>
    <?php endif ?>
  </nav>
</aside>
