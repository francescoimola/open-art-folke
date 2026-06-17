<?php

/**
 * <head> metadata + JSON-LD (Organization + WebSite on every page; +Event on
 * the home page). Fallback chain per field: page → site → omit.
 *
 * Blueprint `default:` values do NOT pre-fill reads on the frontend — every
 * festival field below uses ->or() with the same default, so the Event
 * renders before anyone saves the Settings tab.
 */

$metaTitle = $page->seotitle()->isNotEmpty()
  ? $page->seotitle()->value()
  : $page->title() . ' – ' . $site->title();

$metaDesc = $page->seodescription()->or($site->seodescription())->value();

$ogFile = $page->ogimage()->toFile() ?? $site->ogimage()->toFile();
$ogUrl  = $ogFile ? $ogFile->crop(1200, 630)->url() : null;

$orgSameAs = array_values(array_filter([
  $site->instagram_url()->value(),
  $site->facebook_url()->value(),
]));

$organization = array_filter([
  '@type'  => 'Organization',
  '@id'    => $site->url() . '#organization',
  'name'   => $site->title()->value(),
  'url'    => $site->url(),
  'logo'   => $ogUrl, // logo is an inline SVG with no URL; the OG image is a valid raster fallback
  'sameAs' => $orgSameAs ?: null,
]);

$website = [
  '@type'     => 'WebSite',
  '@id'       => $site->url() . '#website',
  'name'      => $site->title()->value(),
  'url'       => $site->url(),
  'publisher' => ['@id' => $site->url() . '#organization'],
];

$graph = [$organization, $website];

if ($page->isHomePage()) {
  $festivalName = trim($site->title() . ' ' . $site->festivalyear()->or('2026'));

  $eventAddress = array_filter([
    '@type'           => 'PostalAddress',
    'addressLocality' => $site->festivallocality()->or('Folkestone')->value(),
    'addressRegion'   => $site->festivalregion()->or('Kent')->value(),
    'addressCountry'  => 'GB',
  ]);

  $graph[] = array_filter([
    '@type'               => 'Event',
    'name'                => $festivalName,
    'startDate'           => $site->festivalstart()->or('2026-10-09')->toDate('Y-m-d'),
    'endDate'             => $site->festivalend()->or('2026-10-11')->toDate('Y-m-d'),
    'eventStatus'         => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    'location'            => array_filter([
      '@type'   => 'Place',
      'name'    => $site->festivalvenue()->or('Across Folkestone')->value(),
      'address' => $eventAddress ?: null,
    ]),
    'image'               => $ogUrl,
    'description'         => $metaDesc ?: null,
    'organizer'           => ['@id' => $site->url() . '#organization'],
    'url'                 => $site->url(),
  ]);
}

$jsonLd = [
  '@context' => 'https://schema.org',
  '@graph'   => $graph,
];

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

<!-- Structured data -->
<script type="application/ld+json">
<?= json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PRETTY_PRINT) ?>
</script>
