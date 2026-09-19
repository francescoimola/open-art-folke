<?php
/**
 * Homepage #programme section, "programme is out" state: intro half + See / Download PDF buttons.
 * Swapped with programme-signup.php by the Home page's "Programme section" toggle (see home.php).
 *
 * @var \Kirby\Cms\File $pdf  Home page's programme PDF (home.php only renders this snippet when it exists).
 */
?>
<section class="stack-section layout-split split-gap-none programme-choice">
  <div class="panel even theme-crimson stack gap-l programme-choice__intro">
    <?php snippet('image', [
      'file' => $page->programmeheroimage()->toFile(),
      'class' => 'programme-choice__bg',
      'hidden' => true,
      'sizes' => '(min-width: 768px) 50vw, 100vw',
      // This section is art-directed (bottom-anchored, faded from the top) — an editor's focus point
      // would silently override that crop, so force the same position the CSS uses either way.
      'style' => 'object-position: var(--image-position);',
    ]) ?>
    <h2><?= $page->programmeheading()->or('See our 2026 programme')->esc() ?></h2>
    <p class="readable pretty">
      <?= $page->programmetext()->or('It’s time to explore Open Art Folke. Flick through the programme, or download the PDF to keep on your device.')->kti() ?>
    </p>
  </div>

  <div class="panel even theme-paper stack gap-m programme-choice__actions">
    <a class="button fs-xl" href="<?= $pdf->url() ?>" target="_blank" rel="noopener noreferrer">
      <span>See programme<span aria-hidden="true">↗</span></span>
      <small>Opens in a new tab</small>
    </a>
    <a class="button btt--secondary fs-xl" href="<?= $pdf->url() ?>" download>
      <span>Download PDF programme<span aria-hidden="true">↓</span></span>
      <?php /* Decimal units, 1 dp (e.g. "3.6 MB") — matches what Finder/Explorer show; Kirby's niceSize() is binary, 2 dp. */ ?>
      <small><?= $pdf->size() >= 1e6 ? round($pdf->size() / 1e6, 1) . ' MB' : max(1, round($pdf->size() / 1e3)) . ' KB' ?></small>
    </a>
  </div>
</section>
