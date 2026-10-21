<?php
/**
 * Edition — one past festival year on the Archive (docs/components/edition.md). Renders its own Flow <section>.
 * Row: text column (h2 + Text) and an optional Video (16:9) on the right; Stacked below tablet, Split from tablet up.
 * Photos below in justified rows: every photo uncropped at its own ratio, the last row left-aligned and not stretched.
 *
 * Each photo is a plain link to its full-size file. Lightbox hook: `a.edition__link[data-group]`, one group per Edition.
 * The link also carries the Lightbox's WebP srcset/sizes and, when the file has a caption, data-caption-id
 * pointing at a hidden escaped copy of it (Parvus reads that element's HTML, so the text is never parsed as markup).
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
          $number = $photos->indexOf($photo) + 1;
          $label = $heading . ', photo ' . $number;
          $caption = trim((string)$photo->caption()->value());
          $captionId = $group . '-caption-' . $number;
          /* Lightbox: the photo fits the viewport, so its slot is at most the full width or its ratio times the height. */
          $link = [
            'class'           => 'edition__link',
            'href'            => $photo->url(),
            'data-group'      => $group,
            'data-srcset'     => $photo->srcset('webp'),
            'data-sizes'      => 'min(100vw, ' . round($ratio * 100, 2) . 'vh)',
            'data-alt'        => $alt === '' ? $label : null,
            'data-caption-id' => $caption !== '' ? $captionId : null,
          ];
        ?>
        <li class="edition__photo" style="--ratio: <?= $ratio ?>">
          <a<?= attr($link, ' ') ?>>
            <?php snippet('image', [
              'file'  => $photo,
              'sizes' => '(width >= 768px) 40vw, (width >= 520px) 50vw, 100vw',
            ]) ?>
            <?php if ($alt === ''): ?>
              <span class="visually-hidden"><?= esc($label) ?></span>
            <?php endif ?>
          </a>
          <?php if ($caption !== ''): ?>
            <p id="<?= esc($captionId, 'attr') ?>" hidden><?= esc($caption) ?></p>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</section>
