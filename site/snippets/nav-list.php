<?php
/**
 * Nav list — the Site menu (docs/components/nav-list.md, ADR-0003): one list for the Header, Drawer and Footer.
 * Items are the designed ones, in order; only the "Start here" and Register labels are Panel fields.
 * Render it inside the caller's own <nav>; only the layout classes change per context.
 *
 * Usage: snippet('nav-list', ['layout' => ['stacked', 'inline'], 'register' => true])
 *
 * @var string|array $layout     one layout, or [below tablet, tablet and up]:
 *                               'stacked' (column, Link/Large) | 'row' (centred row, Link/Large) | 'inline' (comma-separated, Link/Default)
 * @var bool         $startHere  prepend "Start here" (home); the Footer only
 * @var bool         $register   append Register ↗ while registration is open
 * @var string       $class      extra classes
 *
 * @var \Kirby\Cms\Site $site
 */
$layouts = array_values(array_intersect((array)($layout ?? 'stacked'), ['stacked', 'row', 'inline']));
$classes = ['nav-list', 'nav-list--' . ($layouts[0] ?? 'stacked')];
if (isset($layouts[1]) && $layouts[1] !== $layouts[0]) {
  $classes[] = 'nav-list--tablet-' . $layouts[1];
}
$classes[] = $class ?? '';

$home = $site->homePage();
$items = [];

if ($startHere ?? false) {
  $items[] = ['label' => $site->menu_start_label()->or('Start here')->value(), 'page' => $home];
}

$items[] = ['label' => 'Festival programme', 'page' => $home, 'anchor' => 'programme'];
$items[] = ['label' => 'About OA', 'page' => page('about')];
$items[] = ['label' => 'Explore past editions', 'page' => page('archive')];
$items[] = ['label' => 'How to help', 'page' => page('sponsor')];

/* Resolve URLs; drop missing pages and the programme item while Programme is hidden. */
$links = [];
foreach ($items as $item) {
  $target = $item['page'];
  $anchor = $item['anchor'] ?? '';

  if (!$target) continue;
  if ($anchor === 'programme' && !$home->showsProgramme()) continue;

  $links[] = [
    'url'     => $target->url() . ($anchor !== '' ? '#' . $anchor : ''),
    'label'   => $item['label'],
    'current' => $anchor === '' && $target->isActive(),
  ];
}

if (($register ?? false) && $site->registration_status()->value() === 'open' && $site->register_url()->isNotEmpty()) {
  $links[] = [
    'url'      => $site->register_url()->value(),
    'label'    => $site->register_label()->or('Register')->value(),
    'register' => true,
  ];
}
?>
<ul class="<?= esc(trim(implode(' ', $classes))) ?>" role="list">
  <?php foreach ($links as $link): ?>
  <li class="nav-list__item<?= ($link['register'] ?? false) ? ' nav-list__item--register' : '' ?>"><?php snippet('link', [
    'url'     => $link['url'],
    'label'   => $link['label'],
    'current' => $link['current'] ?? false,
  ]) ?></li>
  <?php endforeach ?>
</ul>
