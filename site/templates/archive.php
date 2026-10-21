<?php
use Kirby\Toolkit\Str;

/* Archive (docs/components/README.md, "Archive redesign"): Statement (Red) with one year link per Edition, then one Edition per year (Flow). */
$editions = $page->editions()->toStructure();

/*
 * Each Edition's key (id, heading id, Lightbox group): "edition-<year>", else "edition-<heading slug>".
 * A repeated year or heading gets "-2", "-3"…, so no two Editions share an id or a Lightbox group.
 * Year links: only Editions with a year get one (an empty year renders the Edition without an anchor).
 */
$keys = [];
$yearLinks = [];
foreach ($editions as $edition) {
  $year = trim((string)$edition->year()->value());
  $hasYear = preg_match('/^\d{4}$/', $year) === 1;
  $base = $hasYear ? 'edition-' . $year : 'edition-' . Str::slug($edition->headline()->value());
  $key = $base;
  for ($n = 2; in_array($key, $keys, true); $n++) {
    $key = $base . '-' . $n;
  }
  $keys[$edition->id()] = $key;
  if ($hasYear) $yearLinks[] = ['url' => '#' . $key, 'label' => $year];
}
?>
<?php snippet('header') ?>

<?php snippet('statement', [
  'heading' => $page->headline()->or('Revisit past editions'),
  'aside'   => $page->intro()->or('Nostalgic as it may seem, we enjoy documenting our successes, and we know that you love reminiscing about good times! In honour of the work done since Open Art Folke launched in 2024, here is an archive of what took place and the highlights of each edition.'),
  'links'   => $yearLinks,
]) ?>

<?php foreach ($editions as $edition): ?>
  <?php snippet('edition', [
    'heading' => $edition->headline(),
    'year'    => $edition->year(),
    'key'     => $keys[$edition->id()],
    'text'    => $edition->text(),
    'video'   => $edition->video(),
    'photos'  => $edition->gallery()->toFiles(),
  ]) ?>
<?php endforeach ?>

<?php /* Lightbox control glyphs (src/templates/archive.js reads them), so the dialog uses the library Icons. */ ?>
<?php foreach (['close', 'arrow-left', 'arrow-right'] as $glyph): ?>
  <template data-lightbox-icon="<?= $glyph ?>"><?php snippet('icon', ['glyph' => $glyph]) ?></template>
<?php endforeach ?>

<?php snippet('site-footer') ?>
