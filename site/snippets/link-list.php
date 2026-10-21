<?php
/**
 * Link list — a short vertical list of Default Links, Space XS apart (docs/components/link-list.md).
 * External items get ↗ automatically (Link). Keep it to 2–4 links; longer lists become a Nav list or their own section.
 *
 * Usage:
 *   snippet('link-list', ['links' => [
 *     ['url' => page('archive')->url(), 'label' => 'Scroll through our archives'],
 *     ['url' => 'https://instagram.com/…', 'label' => 'Instagram'],
 *   ]])
 *
 * @var array  $links  one array of Link snippet params per item (url + label required); empty renders nothing
 * @var string $class  extra classes
 */
$links = array_values(array_filter($links ?? [], fn ($link) => is_array($link) && (string)($link['url'] ?? '') !== ''));
if ($links === []) return;
?>
<ul class="<?= esc(trim('link-list ' . ($class ?? '')), 'attr') ?>" role="list">
  <?php foreach ($links as $link): ?>
    <li><?php snippet('link', $link) ?></li>
  <?php endforeach ?>
</ul>
