<?php
/**
 * Current-sponsor list — mobile carousel + desktop hover-reveal list.
 *
 * Shared by the homepage teaser and the Sponsor page roster so both render the
 * same markup and interaction (native popover, no JS). Pass the data from
 * SponsorPage::sponsorsData().
 *
 * @var array  $sponsors  rows of ['name', 'url', 'description', 'logo']
 * @var string $idPrefix  unique prefix for popover IDs on this page
 */
$idPrefix ??= 'sponsor';

// Shared name markup (plain text, or a link when a Website is set).
$sponsorName = fn($s) => $s['url']->isNotEmpty()
  ? '<a href="' . $s['url']->esc('attr') . '">' . esc($s['name']->value()) . '</a>'
  : esc($s['name']->value());
?>

<!-- Mobile: a Graffiti carousel of cards, name + logo shown together. -->
<ul class="sponsors-mobile show-mobile carousel">
  <?php foreach ($sponsors as $s): ?>
    <li class="theme-crimson box ghost split vertical center gap-xl">
      <?php if ($s['logo']): ?>
        <figure class="sponsor-logo center-both"><?= $s['logo'] ?></figure>
      <?php endif ?>
      <p class="h1"><?= $sponsorName($s) ?></p>
    </li>
  <?php endforeach ?>
</ul>

<!-- Desktop: a stacked list; each row reveals its own logo on hover/focus. -->
<ul class="sponsors-desktop show-desktop stack accent mt-m">
  <?php foreach ($sponsors as $i => $s): ?>
    <?php $menuId = $idPrefix . '-' . $i ?>
    <li style="--anchor: --sponsor-<?= $i ?>">
      <div class="dropdown">
        <button class="reset" style="all: unset" popovertarget="<?= $menuId ?>">
          <p class="h1"><?= esc($s['name']->value()) ?></p>
        </button>
      </div>
      <div id="<?= $menuId ?>" popover class="dropdown-menu">
        <?php if ($s['description']->isNotEmpty()): ?>
          <div class="dropdown-header"><?= $s['description']->esc() ?></div>
          <hr>
        <?php endif ?>
        <?php if ($s['url']->isNotEmpty()): ?>
          <a href="<?= $s['url']->esc('attr') ?>" target="_blank" rel="noopener noreferrer">Visit website <span aria-hidden="true">↗</span></a>
        <?php endif ?>
      </div>

      <?php if ($s['logo']): ?>
        <figure class="sponsor-logo center-both"><?= $s['logo'] ?></figure>
      <?php endif ?>
    </li>
  <?php endforeach ?>
</ul>
