<?php snippet('header') ?>

<section class="panel even theme-brand stack-section half">
  <div class="stack gap-xl readable mt-xl">
    <h1>Revisit past festivals</h1>
    <div class="stack gap-l text-muted">
      <p>Nostalgia is the enemy of progress, we get it. But, as a nonprofit, we enjoy documenting our successes, and we know you love reminiscing about good times.</p>
      <p>Here’s an archive of what took place at Open Art Folke in recent years. And if you weren’t there, honestly, what are you waiting for!?</p>
    </div>
  </div>
</section>

<section class="panel even theme-blush stack-section flowing">
  <div class="stack gap-xl">
    <h1>2025: The Triennial Edition</h1>
    <?php if ($video = $page->video()->toFile()): ?>
      <div class="layout-split">
        <video
          class="aspect-video"
          controls
          playsinline
          preload="metadata"
          <?= $video->caption()->isNotEmpty() ? 'aria-label="' . $video->caption()->esc('attr') . '"' : '' ?>>
          <source src="<?= $video->url() ?>" type="<?= $video->mime() ?>">
        </video>
      </div>
    <?php endif ?>
    <div class="stack gap-l readable">
      <p>For our Triennial Edition we invited anyone with a spark of imagination and a point of view to open up and share their energy. The festival ran across the entire summer and into the autumn, 25 July - 19 October. It included two action-packed weekends (we called them Blooms) and an end of Summer open party (Fête of Folkestone) held in Payers Park in collaboration with <a href="https://www.instagram.com/underthemoonartmarket/" target="_blank" rel="noopener noreferrer">Under The Moon Art Market</a>.</p>
      <p>225 artists took part, across 115 projects and 74 Venues thanks to the support of 14 sponsors.</p>
      <p>Thanks to a 12-week season of art and events—which at points seemed it might as well become a permanent engagement(!)—we became one of the longest-running grassroots art festivals in Kent. This edition and its overlap with the 2025 Folkestone Triennial taught us a tremendous amount, above all about audience participation, assessing our impact, and caring for our volunteers.</p>
    </div>
  </div>
  <p></p>
</section>

<section class="panel even theme-paper stack-section layout-split">
  <div class="stack gap-xl">
    <div class="tagline stack gap-l">
      <p class="statement">This page is not yet complete 🥲</p>
    </div>
    <div class="stack gap-l readable">
      <p>Big ideas take time.</p>
      <p>We know how it feels to sit on projects that, by their very nature, will never be finished. So here's a thought we'd like to set free.</p>
      <p>Don't be afraid to share along the way. You don't have to wait until your thing is finished to fling it up into the sky and drop it down here. Hell, you might use that as an excuse to never release anything. People like stories, complete or unfinished they may be, so use that to your benefit. Work in progress is great, and it's a lesson we keep forgetting, and relearning, time and again.</p>
      <hr>
      <p>But if you insist... like, for some reason, you really want to know what we've been up to in recent years, the're no better place than
        <a href="<?= $site->instagram_url()->esc('attr') ?>" rel="noopener noreferrer" target="_blank">our vibrant—perhaps too vibrant—Instagram</a>.</p>
    </div>
    <div class="stack"><?php if ($image1 = $page->image1()->toFile()): ?>
        <?php snippet('image', [
          'file' => $image1,
          'class' => 'image-cover',
          'sizes' => '(min-width: 768px) 50vw, 100vw',
        ]) ?>
      <?php endif ?>
      <?php if ($image2 = $page->image2()->toFile()): ?>
        <?php snippet('image', [
          'file' => $image2,
          'class' => 'image-cover',
          'sizes' => '(min-width: 768px) 50vw, 100vw',
        ]) ?>
      <?php endif ?>
    </div>
  </div>
</section>


<?php snippet('site-footer') ?>

