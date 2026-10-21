<?php
/**
 * Homepage Sponsors section (placeholder block, ADR-0007). The block holds no content: heading and link label
 * are the Home page's Sponsors tab fields, with the Figma copy as fallback; the sponsors come from the Sponsor page.
 * One Split group: heading, the Sponsor grid of Current sponsors, then "See all our sponsors" (Link/Large).
 * No Current sponsors → heading and link only. No Sponsor page → no link.
 *
 * @var \Kirby\Cms\Block $block
 */
$home = $block->parent();
$sponsorPage = page('sponsor');
?>
<?php snippet('split-group', [
  'heading' => $home->sponsorsheading()->or('Recent sponsors'),
  'id'      => 'sponsors',
], slots: true) ?>
  <?php snippet('sponsor-grid') ?>
  <?php if ($sponsorPage): ?>
    <?php snippet('link', [
      'url'   => $sponsorPage->url(),
      'label' => $home->sponsors_all_label()->or('See all our sponsors')->value(),
      'size'  => 'large',
    ]) ?>
  <?php endif ?>
<?php endsnippet() ?>
