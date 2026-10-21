<?php
/**
 * Custom section (ADR-0007, GLOSSARY.md): a Homepage section an editor makes in the Panel. One Split group in Flow:
 * heading, text, up to two links (a Link, or a Link + hint when the hint is filled), and an optional photo
 * before or after the text, Column (right column) or Wide (full width). Both are full width on phones.
 * The anchor id comes from the heading (HomePage::sectionId). No heading → renders nothing.
 *
 * @var \Kirby\Cms\Block $block
 */
$heading = trim((string)$block->heading()->value());
if ($heading === '') return;

$home = $block->parent();
$id = $home->sectionId($block);
$photo = $block->photo()->toFile();
$wide = $block->photo_size()->value() === 'wide';

/* At most two links, each with a URL and a label; a hint makes it a Link + hint (Large). */
$links = [];
foreach ($block->links()->toStructure() as $link) {
  $url = (string)$link->link()->toUrl();
  $label = trim((string)$link->label()->value());
  if ($url === '' || $label === '' || count($links) === 2) continue;
  $links[] = ['url' => $url, 'label' => $label, 'hint' => trim((string)$link->hint()->value())];
}
?>
<?php snippet('split-group', [
  'heading'     => $heading,
  'id'          => $id,
  'columnMedia' => $wide ? null : $photo,
  'media'       => $wide ? $photo : null,
  'mediaFirst'  => $block->photo_position()->value() === 'before',
], slots: true) ?>
  <?= $block->text()->kt() ?>
  <?php foreach ($links as $n => $link): ?>
    <?php if ($link['hint'] !== ''): ?>
      <?php snippet('link-hint', $link + ['id' => 'hint-' . $id . '-' . ($n + 1)]) ?>
    <?php else: ?>
      <?php snippet('link', ['url' => $link['url'], 'label' => $link['label']]) ?>
    <?php endif ?>
  <?php endforeach ?>
<?php endsnippet() ?>
