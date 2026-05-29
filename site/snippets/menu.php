<nav class="site-nav" aria-label="<?= $site->title()->html() ?>">
  <div class="split site-nav__bar">
    <div class="flex site-nav__group">
      <a href="<?= $site->url() ?>" class="site-nav__logo" aria-label="<?= $site->title()->html() ?> — home">
        <?php snippet('logo') ?>
      </a>
      <ul class="site-nav__links flex no-list" role="list">
        <?php foreach($site->children()->not('home', 'contact') as $child): ?>
          <li class="fs-s">
            <a href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="flex site-nav__group">
      <button class="site-nav__menu-toggle minimal" popovertarget="site-drawer">Menu</button>
      <?php if ($registerUrl = $site->register_url()->isNotEmpty() ? $site->register_url()->value() : null): ?>
        <a href="<?= $registerUrl ?>" class="site-nav__register fs-s" rel="noopener noreferrer" target="_blank">
          Register <span aria-hidden="true">↗</span>
        </a>
      <?php endif ?>
    </div>
  </div>
</nav>

<aside id="site-drawer" popover="auto" class="drawer site-drawer">
  <div class="split site-drawer__header">
    <a href="<?= $site->url() ?>" class="site-nav__logo" aria-label="<?= $site->title()->html() ?> — home">
      <?php snippet('logo') ?>
    </a>
    <button class="minimal close" popovertarget="site-drawer" popovertargetaction="hide" aria-label="Close menu">&times;</button>
  </div>
  <nav class="stack site-drawer__nav" aria-label="Mobile navigation">
    <a href="<?= $site->url() ?>"<?= e($site->homePage()->isActive(), ' aria-current="page"') ?>>Home</a>
    <?php foreach($site->children()->not('home', 'contact') as $child): ?>
      <a href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
    <?php endforeach ?>
    <?php if ($registerUrl = $site->register_url()->isNotEmpty() ? $site->register_url()->value() : null): ?>
      <a href="<?= $registerUrl ?>" rel="noopener noreferrer" target="_blank">
        Register <span aria-hidden="true">↗</span>
      </a>
    <?php endif ?>
  </nav>
</aside>
