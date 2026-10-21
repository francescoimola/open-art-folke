<?php
/**
 * Homepage About section (placeholder block, ADR-0007). The block holds no content: copy, link labels and photo
 * are the Home page's About tab fields, with the Figma copy as fallback.
 * One Split group: heading, text, Links to the Archive and About pages, then the photo full width (Media).
 *
 * @var \Kirby\Cms\Block $block
 */
$home = $block->parent();

$fallback = <<<'KT'
Each year since 2024 we’ve put together a festival: a chance to come face to face with great art and ideas in studios, gardens, pubs, galleries, or more off-the-beaten-track corners of Folkestone.

When you visit Open Art Folke, you get:

- To celebrate Folkestone’s creative community.
- To get out of your bubble.
- A chance to connect with talented local people.
- A reason to make life more bearable.
- Endless opportunities to see, touch, and experience new ideas up close, learn about how things are made, and who knows, maybe see your life reflected in someone else’s work.

The third and latest edition of OA ran 9–11 October 2026. It was a blast, and truth be told we're still recovering. Keep an eye here and on your socials to know what's coming next.
KT;

/* Each link renders only while its page exists. */
$links = array_filter([
  ['page' => page('archive'), 'label' => $home->about_archive_label()->or('Scroll through our archives')],
  ['page' => page('about'), 'label' => $home->about_people_label()->or('See who is behind Open Art Folke')],
], fn ($link) => $link['page'] !== null);
?>
<?php snippet('split-group', [
  'heading' => $home->aboutheading()->or('About the festival'),
  'id'      => 'about',
  'media'   => $home->festivalimage()->toFile(),
  'class'   => 'home-about',
], slots: true) ?>
  <?= $home->abouttext()->or($fallback)->kt() ?>
  <?php foreach ($links as $link): ?>
    <?php snippet('link', ['url' => $link['page']->url(), 'label' => $link['label']->value()]) ?>
  <?php endforeach ?>
<?php endsnippet() ?>
