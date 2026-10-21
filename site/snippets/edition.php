<?php
/**
 * Edition — one past festival year on the Archive (docs/components/edition.md). Renders its own Flow <section>.
 * Row: text column (h2 + Text) and an optional Video (16:9) on the right; Stacked below tablet, Split from tablet up.
 * Photos below in justified rows: every photo uncropped at its own ratio, the last row left-aligned and not stretched.
 *
 * Each photo is a plain link to its full-size file. Lightbox hook: `a.edition__link[data-group]`, one group per Edition.
 *
 * Usage:
 *   snippet('edition', [
 *     'heading' => $edition->headline(),
 *     'year'    => $edition->year(),
 *     'text'    => $edition->text(),
 *     'video'   => $edition->video(),
 *     'photos'  => $edition->gallery()->toFiles(),
 *   ])
 *
 * @var string|\Kirby\Content\Field      $heading  required; the h2 (plain text, escaped here)
 * @var string|int|\Kirby\Content\Field  $year     drives id="edition-<year>"; empty or not a year = no id (the page still renders)
 * @var string|\Kirby\Content\Field|null $text     KirbyText field (rendered with ->kt()) or HTML string
 * @var string|\Kirby\Content\Field|null $video    Vimeo URL; empty = no Video, the text keeps its half
 * @var \Kirby\Cms\Files|null            $photos   images in order; empty = no photo list
 * @var string|null                      $group    Lightbox group key; defaults to the id, else "edition-<heading slug>"
 * @var string                           $class    extra classes on the <section>
 */
use Kirby\Content\Field;
use Kirby\Toolkit\Str;

$heading = trim((string)($heading ?? ''));
if ($heading === '') return;

/* A year is digits only (the anchor and the Statement's year link use it); anything else is treated as unset. */
$year = trim((string)($year ?? ''));
$id = preg_match('/^\d{4}$/', $year) ? 'edition-' . $year : null;
$headingId = ($id ?? 'edition-' . Str::slug($heading)) . '-title';
$group = $group ?? ($id ?? 'edition-' . Str::slug($heading));

$text = ($text ?? null) instanceof Field ? (string)$text->kt() : trim((string)($text ?? ''));
$video = snippet('vimeo', ['url' => $video ?? null, 'title' => $heading], return: true);
$photos ??= null;

$attributes = [
  'class'           => trim('edition page-section theme-flow ' . ($class ?? '')),
  'id'              => $id,
  'aria-labelledby' => $headingId,
];
?>
<section<?= attr($attributes, ' ') ?>>
  <div class="edition__row">
    <div class="edition__text">
      <h2 class="edition__heading" id="<?= esc($headingId, 'attr') ?>"><?= esc($heading) ?></h2>
      <?php if ($text !== ''): ?>
        <div class="edition__body"><?= $text ?></div>
      <?php endif ?>
    </div>
    <?php if (trim($video) !== ''): ?>
      <div class="edition__video"><?= $video ?></div>
    <?php endif ?>
  </div>
  <?php if ($photos !== null && $photos->isNotEmpty()): ?>
    <ul class="edition__photos" role="list" aria-label="<?= esc($heading . ' photos', 'attr') ?>">
      <?php foreach ($photos as $photo): ?>
        <?php
          /* The photo's own ratio sizes its slot, so the cover-fit image is never cropped. */
          $ratio = $photo->height() > 0 ? round($photo->width() / $photo->height(), 4) : 1.5;
          $alt = $photo->alt()->or('')->value();
        ?>
        <li class="edition__photo" style="--ratio: <?= $ratio ?>">
          <a class="edition__link" href="<?= esc($photo->url(), 'attr') ?>" data-group="<?= esc($group, 'attr') ?>">
            <?php snippet('image', [
              'file'  => $photo,
              'sizes' => '(width >= 768px) 40vw, (width >= 520px) 50vw, 100vw',
            ]) ?>
            <?php if ($alt === ''): ?>
              <span class="visually-hidden"><?= esc($heading) ?>, photo <?= $photos->indexOf($photo) + 1 ?></span>
            <?php endif ?>
          </a>
        </li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</section>
