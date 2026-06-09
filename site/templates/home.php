<?php snippet('header') ?>

<section class="hero stack-section flex text-center stack-gap-none">
  <?php snippet('image', [
    'file' => $page->heroimage()->toFile(),
    'class' => 'hero__bg darken-50',
    'hidden' => true,
    'loading' => 'eager',
    'fetchpriority' => 'high',
    'sizes' => '100vw',
  ]) ?>
  <h1>Open&nbsp;&nbsp;Art&nbsp;&nbsp;Folke</h1>
  <a class="hero__arrow fs-xl" href="#intro" aria-label="Scroll to content">↓</a>
</section>

<section id="intro" class="panel stack-section half layout-split theme-brand">
  <div class="fc readable">
    <p class="statement">Open Art Folke is a community of 200+ artists and makers in Folkestone. Since 2024, we've run
      <a href="#">an open house-style festival</a>
      to keep the creative energy alive, welcome people into our studios, and take over public spaces to share what we've been making.</p>
  </div>
  <p class="intro__date right-aligned row">Open Art '26 runs 9–11 October 2026</p>
</section>

<section class="theme-paper stack-section layout-split">
  <div class="split vertical panel even gap-l">
    <div class="stack readable gap-xl">
      <h2>
        <span class="text-muted">Open Art</span><br>The Festival</h2>
      <div class="stack gap-m">
        <p>A free pass* to connect with talented local creatives, experience their work, and learn about how it’s made.</p>
        <p>Find great art waiting to be discovered in studios, shops, parks, cafes, and upstairs in that pub you didn't even know had an upstairs.</p>
      </div>
      <div class="stack ">
        <a href="#programme" class="button fit-width">Explore the 2026 programme</a>
        <a href="<?= $site->register_url() ?>" rel="noopener noreferrer" target="_blank" class="button btt--secondary fit-width">Register as an artist</a>
      </div>
    </div>
    <small class="mt-s">* Open Art is 99% free to attend, but some events require a paid reservation</small>
  </div>
  <?php snippet('image', [
    'file' => $page->festivalimage()->toFile(),
    'class' => 'image-cover',
    'hidden' => true,
    'sizes' => '(min-width: 768px) 50vw, 100vw',
  ]) ?>
</section>

<section class="theme-blush stack-section half layout-split">
  <div
    class="stack panel even readable gap-l">
    <?php $days = $page->daysRemaining() ?>
    <h2>There
      <?= $days ?>
      <?= $days === 1 ? 'day' : 'days' ?>
    until the next edition of Open Art Folke
    </h2>
      <p class="close-trim"> Some things, as you know, just take time</p>
  </div>
  <?php snippet('countdown') ?>
</section>

<div id="programme" class="anchor-target" aria-hidden="true"></div>
<?php snippet('programme-signup', ['form' => $form]) ?>

<?php $sponsorPage = page('sponsor') ?>
<?php if ($sponsorPage): ?>
<section class="sponsors theme-blush stack-section half panel even stack gap-xl">
  <h2>Recent sponsors</h2>

  <?php snippet('sponsor-list', [
    'sponsors' => $sponsorPage->currentSponsors(),
    'idPrefix' => 'home-sponsor',
  ]) ?>

  <div class="cluster gap-m accent">
    <a href="<?= $sponsorPage->url() ?>" class="button btt--secondary">See all our sponsors</a>
    <a href="/about">Who's behind Open Art Folke</a>
  </div>
</section>
<?php endif ?>

<?php snippet('photo-banner', ['image' => $page->bannerimage()->toFile()]) ?>

<?php snippet('site-footer') ?>
