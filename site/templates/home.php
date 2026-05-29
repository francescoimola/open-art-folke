<?php snippet('header') ?>

<section class="hero stack-section flex text-center" style="--gap: 0;">
  <img class="hero__bg" src="/assets/images/specsavers.jpg" alt="" aria-hidden="true">
  <h1><?= $site->title()->html() ?></h1>
  <a class="hero__arrow fs-xl" href="#intro" aria-label="Scroll to content">↓</a>
</section>

<section id="intro" class="intro stack-section split " style="--gap: var(--vs-l);">
  <div class="fc readable">
    <p>Open Art Folke is <a href="#">a community of 200+ artists and makers</a> in Folkestone. Since 2024, we've run <a href="#">an open house-style festival</a> to keep the creative energy alive, welcome people into our studios, and take over public spaces to share what we've been making.</p>
  </div>
  <p class="intro__date">Open Art '26 runs 9–11 October 2026</p>
</section>

<?php snippet('footer') ?>
