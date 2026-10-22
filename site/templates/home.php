<?php
/*
 * Homepage (Figma Desktop 332:124, Mobile 332:261): Statement (Red) → opening Photo band → Homepage sections → closing Photo band → Footer.
 * Homepage sections are the `sectionblocks` Blocks field (ADR-0007), one snippet per block type in site/snippets/blocks/.
 * Each block renders first, so an empty one leaves no gap and is never an arrow target.
 */

/* The Statement's ↓ arrow labels; Custom sections get "Skip to <heading>". */
$arrowLabels = array_map(fn (array $p) => $p['skip'], HomePage::PLACEHOLDERS);

/* Rendered sections keyed by block type; a type renders at most once, except Custom sections (max two, keyed by block id). */
$sections = [];
$anchors = [];
foreach ($page->homeSections() as $block) {
  $html = trim($block->toHtml());
  if ($html === '') continue;
  $key = $block->type() === 'custom' ? $block->id() : $block->type();
  $sections[$key] = $html;
  $anchors[$key] = $page->sectionId($block);
  if ($block->type() === 'custom') $arrowLabels[$key] = 'Skip to ' . $block->heading()->value();
}

/* The arrow goes to the chosen section, or the first one (#content) if it is hidden or empty. */
$arrowTarget = $page->arrow_target()->value();
$arrowHref = isset($sections[$arrowTarget]) ? '#' . $anchors[$arrowTarget] : '#content';
if (!isset($sections[$arrowTarget])) $arrowTarget = array_key_first($sections);
?>
<?php snippet('header') ?>

<?php snippet('statement', [
  'heading'    => $page->statement_heading()->or('Open Art Folke is a community of 200+ Folkestone artists.'),
  'body'       => $page->statement_body()->or('Every so often, we throw a mighty open-house style festival where we take you off the beaten track to see exactly where the art happens.'),
  'kicker'     => $page->statement_kicker(),
  'arrow'      => $sections === [] ? null : $arrowHref,
  'arrowLabel' => $arrowLabels[$arrowTarget] ?? 'Skip to the content',
]) ?>

<?php snippet('photo-band', ['image' => $page->heroimage()->toFile(), 'first' => true]) ?>

<?php if ($sections !== []): ?>
  <div class="page-section page-section--home theme-flow" id="content">
    <?= implode("\n", $sections) ?>
  </div>
<?php endif ?>

<?php snippet('photo-band', ['image' => $page->bannerimage()->toFile()]) ?>

<?php snippet('site-footer') ?>
