<?php snippet('header') ?>

<section class="page-hero panel even theme-brand stack-section">
  <h1>Archive<br><span class="text-muted">Or what we've done so far</span>
  </h1>
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
    <div class="stack">
      <?php if ($image1 = $page->image1()->toFile()): ?>
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

