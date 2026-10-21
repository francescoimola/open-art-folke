<?php
/*
 * Default template: any page without a bespoke design. No Figma frame; built from the library.
 * A Red Statement with the page title, then the page text in Flow, in the Split group's right column from tablet up.
 */
?>
<?php snippet('header') ?>

<?php snippet('statement', ['heading' => $page->title()]) ?>

<?php if ($page->text()->isNotEmpty()): ?>
  <section class="page-section theme-flow" id="content">
    <?php snippet('split-group', ['content' => $page->text()->kt(), 'tag' => 'div']) ?>
  </section>
<?php endif ?>

<?php snippet('site-footer') ?>
