<?php
$status = $site->registration_status()->or('closed')->value();
$registerUrl = $site->register_url()->isNotEmpty() ? $site->register_url()->value() : null;
?>
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
  <div class="hero__title">
    <h1>Open&nbsp;&nbsp;Art&nbsp;&nbsp;Folke<span aria-hidden="true"><span class="hero__typed"></span><span class="hero__cursor">|</span></span></h1>
    <span class="hero__sizer h1" aria-hidden="true">Open&nbsp;&nbsp;Art&nbsp;&nbsp;Folke is cross-generational and cross-cultural</span>
  </div>
  <a class="hero__arrow fs-xl" href="#programme" aria-label="Scroll to content">↓</a>
</section>

<div id="programme" class="anchor-target" aria-hidden="true"></div>
<?php /* Programme section: toggled in the Panel (Home → Programme). Falls back to sign-up until a PDF is uploaded. */ ?>
<?php $programmePdf = $page->programmepdf()->toFile() ?>
<?php if ($page->programmemode()->value() === 'programme' && $programmePdf): ?>
  <?php snippet('programme-choice', ['pdf' => $programmePdf]) ?>
<?php else: ?>
  <?php snippet('programme-signup', ['form' => $form]) ?>
<?php endif ?>

<section class="theme-blush stack-section half layout-split">
  <div
    class="stack panel even readable gap-l">
    <?php $days = $page->daysRemaining() ?>
    <h2><?= $days === 1 ? 'There is' : 'There are' ?>
      <?= $days ?>
      <?= $days === 1 ? 'day' : 'days' ?>
      until Open Art Folke 2026
    </h2>
    <p class="close-trim">Almost there baby, almost there.</p>
  </div>
  <?php snippet('countdown') ?>
</section>

<section id="intro" class="panel stack-section half layout-split theme-brand">
  <div class="fc readable">
    <p class="statement">Open Art Folke is a community of 200+ artists and makers in Folkestone. Since 2024, we've run
      <a href="/about">an open house-style festival</a>
      to keep the creative energy alive, welcome people into our studios, and take over public spaces to share what we've been making.</p>
  </div>
  <p class="intro__date right-aligned row">Open Art '26 runs 9–11 October 2026</p>
</section>

<section class="theme-paper stack-section layout-split">
  <div class="split vertical panel even gap-l">
    <div class="stack readable gap-xl">
      <h2>
        <span class="text-muted">Open Art Folke</span><br>The Festival</h2>
      <div class="stack gap-m">
        <p>A free pass* to connect with talented local creatives, experience their work, and learn about how it’s made.</p>
        <p>Find great art waiting to be discovered in studios, gardens, pubs, cafes, galleries, and upstairs in that shop you didn't even know had an upstairs.</p>
      </div>
      <?php
      /* Until an editor first saves the field, fall back to the blueprint defaults so buttons don't vanish on deploy. */
      $festivalButtons = $page->content()->has('festivalbuttons')
        ? $page->festivalbuttons()->toStructure()
        : Kirby\Cms\Structure::factory($page->blueprint()->field('festivalbuttons')['default'] ?? [], ['parent' => $page]);
      ?>
      <?php if ($festivalButtons->isNotEmpty()): ?>
        <div class="stack">
          <?php foreach ($festivalButtons->limit(2)->values() as $i => $button): ?>
            <?php $class = $i === 0 ? 'button fit-width' : 'button btt--secondary fit-width' ?>
            <?php if ($button->registration()->toBool()): ?>
              <?php if ($status !== 'open'): ?>
                <button popovertarget="registration-popover" data-popover-origin="body" class="<?= $class ?>"><?= $button->label()->esc() ?></button>
              <?php elseif ($registerUrl): ?>
                <a href="<?= esc($registerUrl, 'attr') ?>" rel="noopener noreferrer" target="_blank" class="<?= $class ?>"><?= $button->label()->esc() ?></a>
              <?php endif ?>
            <?php elseif ($href = $button->link()->toUrl()): ?>
              <?php $external = str_starts_with($button->link()->value(), 'http') ?>
              <a href="<?= esc($href, 'attr') ?>"<?= $external ? ' rel="noopener noreferrer" target="_blank"' : '' ?> class="<?= $class ?>"><?= $button->label()->esc() ?></a>
            <?php endif ?>
          <?php endforeach ?>
        </div>
      <?php endif ?>
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

<?php $sponsorPage = page('sponsor') ?>
<?php if ($sponsorPage): ?>
<section class="sponsors theme-blush stack-section flowing half panel even stack gap-xl">
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
