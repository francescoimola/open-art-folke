<?php
/**
 * Homepage Programme section (placeholder block, ADR-0007). The block holds no content: copy, photo and PDF
 * are the Home page's Programme tab fields, with the Figma copy as fallback.
 * One Split group: heading, text, then "See programme ↗" and "Download PDF ↓" as Link + hint, only once a PDF
 * is uploaded. The photo sits in the right column (Column media).
 *
 * @var \Kirby\Cms\Block $block
 */
$home = $block->parent();
$pdf = $home->programmepdf()->toFile();
?>
<?php snippet('split-group', [
  'heading'     => $home->programmeheading()->or('The 2026 festival programme'),
  'id'          => 'programme',
  'columnMedia' => $home->programmeimage()->toFile(),
], slots: true) ?>
  <?= $home->programmetext()->or('Running 9-11 October, Open Art Folke 2026 brings together over 150 artists across 51 locations in and around Folkestone. Flick through the programme to see exactly what\'s going on, and where. Or download the PDF to keep on your device.')->kt() ?>
  <?php if ($pdf): ?>
    <?php snippet('link-hint', [
      'url'      => $pdf->url(),
      'label'    => $home->programme_see_label()->or('See programme')->value(),
      'hint'     => $home->programme_see_hint()->or('Opens in a new tab')->value(),
      'external' => true,
      'id'       => 'hint-programme-see',
    ]) ?>
    <?php /* Decimal units, 1 dp (e.g. "3.6 MB"), as Finder/Explorer show; Kirby's niceSize() is binary, 2 dp. */ ?>
    <?php $size = $pdf->size() >= 1e6 ? round($pdf->size() / 1e6, 1) . ' MB' : max(1, round($pdf->size() / 1e3)) . ' KB' ?>
    <?php snippet('link-hint', [
      'url'      => $pdf->url(),
      'label'    => $home->programme_download_label()->or('Download PDF')->value(),
      'hint'     => $home->programme_download_hint()->or('Save the programme on your device')->value() . ' (' . $size . ')',
      'download' => true,
      'id'       => 'hint-programme-download',
    ]) ?>
  <?php endif ?>
<?php endsnippet() ?>
