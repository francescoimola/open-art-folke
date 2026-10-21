<?php
/**
 * Sponsor grid — the Current sponsors as square Sponsor cards (docs/components/sponsor-grid.md).
 * 2 columns, 3 once the grid is at least 480px wide (container query), gap Space S. Cards follow Panel order.
 * Pinned to Flow (the cards' Neutral/100 fill is fixed), so it reads the same inside an Ink or Red section.
 * Used by the Sponsor page ("Our sponsors") and the homepage Sponsors section.
 *
 * Usage:
 *   snippet('sponsor-grid')                                        // Current sponsors from the Sponsor page
 *   snippet('sponsor-grid', ['sponsors' => $page->currentSponsors()])
 *
 * @var array|null $sponsors  rows of ['name' => Field|string, 'url' => Field|string, 'logo' => SVG string],
 *                            as SponsorPage::currentSponsors() returns; null = the Sponsor page's Current sponsors
 * @var string     $label     accessible name of the list
 * @var string     $class     extra classes on the wrapper
 */
$sponsors ??= page('sponsor')?->currentSponsors() ?? [];
if (empty($sponsors)) return;
?>
<div class="<?= esc(trim('sponsor-grid theme-flow ' . ($class ?? '')), 'attr') ?>">
  <ul class="sponsor-grid__list" role="list" aria-label="<?= esc($label ?? 'Current sponsors', 'attr') ?>">
    <?php foreach ($sponsors as $sponsor): ?>
      <?php snippet('sponsor-card', [
        'name' => $sponsor['name'] ?? '',
        'url'  => $sponsor['url'] ?? '',
        'logo' => $sponsor['logo'] ?? '',
      ]) ?>
    <?php endforeach ?>
  </ul>
</div>
