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
  <span class="hero__arrow fs-xl" aria-hidden="true">↓</span>
</section>

<?php /* Middle sections: order and visibility set in the Panel (Home → Content → Homepage sections). */ ?>
<?php foreach ($page->homeSections() as $section): ?>
  <?php snippet('home/' . $section, ['form' => $form]) ?>
<?php endforeach ?>

<?php snippet('photo-banner', ['image' => $page->bannerimage()->toFile()]) ?>

<?php snippet('site-footer') ?>
