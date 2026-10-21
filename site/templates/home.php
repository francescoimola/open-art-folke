<?php
/*
 * Homepage (Figma Desktop 332:124, Mobile 332:261): Statement (Red) → opening Photo band → Homepage sections → closing Photo band → Footer.
 * Homepage sections are the `sectionblocks` Blocks field (ADR-0007), one snippet per block type in site/snippets/blocks/.
 * Each block renders first, so an empty one leaves no gap and is never an arrow target.
 */

/* Rendered sections keyed by block type; a type renders at most once, except Custom sections (max two, keyed by id). */
$sections = [];
foreach ($page->homeSections() as $block) {
  $html = trim($block->toHtml());
  if ($html !== '') $sections[$block->type() === 'custom' ? $block->id() : $block->type()] = $html;
}

/* The Statement's ↓ arrow: the chosen section, or the first one (#content) if it is hidden or empty. */
$arrowLabels = [
  'programme' => 'Skip to the festival programme',
  'about'     => 'Skip to about the festival',
  'sponsors'  => 'Skip to our sponsors',
];
$arrowTarget = $page->arrow_target()->value();
$arrowHref = isset($sections[$arrowTarget]) ? '#' . $arrowTarget : '#content';
if (!isset($sections[$arrowTarget])) $arrowTarget = array_key_first($sections);
?>
<?php snippet('header') ?>

<?php snippet('statement', [
  'heading'    => $page->statement_heading()->or('Open Art Folke is a community of 200+ Folkestone artists.'),
  'body'       => $page->statement_body()->or('Every so often, we throw a mighty open-house style festival where we take you off the beaten track to see exactly where the art happens.'),
  'kicker'     => $page->statement_kicker()->or('Come and have a nosey.'),
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
