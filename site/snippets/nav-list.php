<?php
/**
 * Nav list — the Site menu (docs/components/nav-list.md, ADR-0003): one Panel list for the Header, Drawer and Footer.
 * Items come from Site → Settings → Site menu, or the designed defaults while that field is empty.
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

/* Panel rows: label + link (page or URL) + optional anchor. Empty field → the designed defaults. */
$rows = $site->menu()->toStructure();
if ($rows->isNotEmpty()) {
  foreach ($rows as $row) {
    $target = $row->link()->toPage();
    $items[] = [
      'label'  => $row->label()->value(),
      'page'   => $target,
      'url'    => $target ? null : $row->link()->toUrl(),
      'anchor' => $row->anchor()->value(),
    ];
  }
} else {
  $items[] = ['label' => 'Festival programme', 'page' => $home, 'anchor' => 'programme'];
  $items[] = ['label' => 'About OA', 'page' => page('about')];
  $items[] = ['label' => 'Explore past editions', 'page' => page('archive')];
  $items[] = ['label' => 'How to help', 'page' => page('sponsor')];
}

/* Resolve URLs; drop broken rows and the homepage programme item while Programme is hidden. */
$links = [];
foreach ($items as $item) {
  $target = $item['page'] ?? null;
  $anchor = ltrim($item['anchor'] ?? '', '#');

  if ($target && $target->isHomePage() && $anchor === 'programme' && !$home->showsProgramme()) continue;

  $url = $target ? $target->url() . ($anchor !== '' ? '#' . $anchor : '') : ($item['url'] ?? null);
  if (empty($url) || empty($item['label'])) continue;

  $links[] = [
    'url'     => $url,
    'label'   => $item['label'],
    'current' => $target && $anchor === '' && $target->isActive(),
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
