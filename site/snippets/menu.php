<nav class="site-nav" aria-label="<?= $site->title()->html() ?>">
  <div class="split" style="align-items: center; padding-inline: var(--pad-xl); padding-block: var(--vs-base);">
    <div class="flex" style="align-items: center; --gap: var(--vs-m);">
      <a href="<?= $site->url() ?>" class="site-nav__logo" aria-label="<?= $site->title()->html() ?> — home">
        <?php snippet('logo') ?>
      </a>
      <ul class="site-nav__links flex no-list" style="--gap: 0; align-items: center;" role="list">
        <?php foreach($site->children()->not('home', 'contact') as $child): ?>
          <li class="fs-s">
            <a href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="flex" style="align-items: center; --gap: var(--vs-m);">
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
  <div class="split" style="padding: var(--pad-l); margin-bottom: var(--vs-l);">
    <a href="<?= $site->url() ?>" class="site-nav__logo" aria-label="<?= $site->title()->html() ?> — home">
      <?php snippet('logo') ?>
    </a>
    <button class="minimal close" popovertarget="site-drawer" popovertargetaction="hide" aria-label="Close menu">&times;</button>
  </div>
  <nav class="stack" style="padding-inline: var(--pad-l); padding-block-end: var(--pad-l); --gap: var(--vs-x);" aria-label="Mobile navigation">
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
