<?php
/**
 * Link — the site's text link (docs/components/link.md).
 * External URLs (another host) get the ↗ Icon, open in a new tab and carry "(opens in a new tab)" for screen readers.
 * Downloads get the ↓ Icon and the download attribute. Labels never contain typed arrows.
 *
 * Usage: snippet('link', ['url' => $page->url(), 'label' => 'About OA'])
 *
 * @var string           $url          required; a Page or Field is cast to string
 * @var string           $label        required; plain text, escaped here
 * @var string           $size         'default' (Link/Default) | 'large' (Link/Large)
 * @var bool|null        $external     null = detect from the URL's host
 * @var bool|string      $download     true, or a file name, marks a file download (↓ + download attribute)
 * @var string|bool|null $icon         Icon glyph to force (e.g. 'arrow-down' for a skip link), false for none
 * @var string|null      $describedby  id of a visible hint; replaces the hidden new-tab text (Link + hint)
 * @var bool             $current      true adds aria-current="page" (no visual style)
 * @var string           $class        extra classes
 * @var array            $attrs        extra attributes, merged last
 */
$url = (string)($url ?? '');
if ($url === '') return;

$download = $download ?? false;
$external = $external ?? (function () use ($url): bool {
  $host = parse_url($url, PHP_URL_HOST);
  return in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
    && $host !== parse_url(site()->url(), PHP_URL_HOST);
})();

$glyph = $icon ?? match (true) {
  $download !== false => 'arrow-down',
  $external           => 'external',
  default             => null,
};

$size = ($size ?? 'default') === 'large' ? 'large' : 'default';
$classes = trim('link' . ($size === 'large' ? ' link--large' : '') . ' ' . ($class ?? ''));
$describedby ??= null;

$attributes = array_merge([
  'class'            => $classes,
  'href'             => $url,
  'target'           => $external ? '_blank' : null,
  'rel'              => $external ? 'noopener' : null,
  'download'         => $download === false ? null : $download,
  'aria-current'     => ($current ?? false) ? 'page' : null,
  'aria-describedby' => $describedby,
], $attrs ?? []);
?>
<a<?= attr($attributes, ' ') ?>><?= esc($label ?? '') ?><?php if ($glyph) snippet('icon', ['glyph' => $glyph]) ?><?php if ($external && !$describedby): ?><span class="visually-hidden"> (opens in a new tab)</span><?php endif ?></a>