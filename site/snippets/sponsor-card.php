<?php
/**
 * Sponsor card — one square card in the Sponsor grid (docs/components/sponsor-card.md).
 * Logo top-left, name bottom-left (Link/Compact), ↗ corner top-right. The whole card links out in a new tab.
 * Hover and keyboard Focus switch it to the Red Theme's colours. Without a URL it renders as a plain card (no link, no corner).
 * Renders the <li>: use it inside the Sponsor grid's list.
 *
 * Usage: snippet('sponsor-card', ['name' => $row['name'], 'url' => $row['url'], 'logo' => $row['logo']])
 *
 * @var string|\Kirby\Content\Field      $name   required; plain text, escaped here
 * @var string|\Kirby\Content\Field|null $url    the sponsor's website
 * @var string                           $logo   sanitised inline SVG (Sponsor logo); empty = name only
 * @var string                           $class  extra classes on the <li>
 */
$name = trim((string)($name ?? ''));
if ($name === '') return;

$url = trim((string)($url ?? ''));
$tag = $url === '' ? 'div' : 'a';

$attributes = $url === '' ? [] : [
  'href'   => $url,
  'target' => '_blank',
  'rel'    => 'noopener',
];
?>
<li class="<?= esc(trim('sponsor-card ' . ($class ?? '')), 'attr') ?>">
  <<?= $tag ?> class="sponsor-card__box"<?= attr($attributes, ' ') ?>>
    <?php snippet('sponsor-logo', ['svg' => $logo ?? '', 'class' => 'sponsor-card__logo']) ?>
    <span class="sponsor-card__name"><?= esc($name) ?></span>
    <?php if ($url !== ''): ?>
      <span class="visually-hidden"> (opens in a new tab)</span>
      <span class="sponsor-card__corner"><?php snippet('icon', ['glyph' => 'external']) ?></span>
    <?php endif ?>
  </<?= $tag ?>>
</li>
