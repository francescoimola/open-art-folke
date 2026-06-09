<?php

/**
 * <head> metadata: title, description, canonical, Open Graph & Twitter card.
 *
 * Fallback chain per field:
 *   title       page `seotitle`       → "{Page title} – {Site title}"
 *   description page `seodescription` → site `seodescription` (else tag omitted)
 *   image       page `ogimage`        → site `ogimage` (else image tags omitted)
 *
 * `$page` and `$site` are available globally in snippets. The OG image is
 * cropped to a 1200×630 social card via the shared `thumbs` recipe (config.php),
 * the same pipeline the `image` snippet uses.
 */

$metaTitle = $page->seotitle()->isNotEmpty()
  ? $page->seotitle()->value()
  : $page->title() . ' – ' . $site->title();

$metaDesc = $page->seodescription()->or($site->seodescription())->value();

$ogFile = $page->ogimage()->toFile() ?? $site->ogimage()->toFile();
$ogUrl  = $ogFile ? $ogFile->crop(1200, 630)->url() : null;

?>
<title><?= esc($metaTitle) ?></title>
<?php if ($metaDesc): ?>
<meta name="description" content="<?= esc($metaDesc) ?>">
<?php endif ?>
<link rel="canonical" href="<?= $page->url() ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= esc($site->title()) ?>">
<meta property="og:title" content="<?= esc($metaTitle) ?>">
<meta property="og:url" content="<?= $page->url() ?>">
<?php if ($metaDesc): ?>
<meta property="og:description" content="<?= esc($metaDesc) ?>">
<?php endif ?>
<?php if ($ogUrl): ?>
<meta property="og:image" content="<?= $ogUrl ?>">
<?php endif ?>

<!-- Twitter -->
<meta name="twitter:card" content="<?= $ogUrl ? 'summary_large_image' : 'summary' ?>">
<meta name="twitter:title" content="<?= esc($metaTitle) ?>">
<?php if ($metaDesc): ?>
<meta name="twitter:description" content="<?= esc($metaDesc) ?>">
<?php endif ?>
<?php if ($ogUrl): ?>
<meta name="twitter:image" content="<?= $ogUrl ?>">
<?php endif ?>
