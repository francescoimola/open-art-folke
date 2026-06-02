<?php snippet('header') ?>

<section class="hero stack-section flex text-center gap-none">
  <img class="hero__bg" src="/assets/images/specsavers.jpg" alt="" aria-hidden="true">
  <h1>Open&nbsp;&nbsp;Art&nbsp;&nbsp;Folke</h1>
  <a class="hero__arrow fs-xl" href="#intro" aria-label="Scroll to content">↓</a>
</section>

<section id="intro" class="panel stack-section half layout-split theme-brand">
  <div class="fc readable">
    <p class="statement">Open Art Folke is
      <a href="#">a community of 200+ artists and makers</a>
      in Folkestone. Since 2024, we've run
      <a href="#">an open house-style festival</a>
      to keep the creative energy alive, welcome people into our studios, and take over public spaces to share what we've been making.</p>
  </div>
  <p class="intro__date right-aligned row">Open Art '26 runs 9–11 October 2026</p>
</section>

<section class="theme-paper stack-section layout-split no-gap">
  <div class="split vertical panel even gap-l">
    <div class="stack fc readable gap-xl">
      <h2>
        <span style="color: var(--fg-6)">Open Art</span><br>The Festival</h2>
      <div class="stack gap-m">
        <p class="fs-s">A free pass* to connect with talented local creatives, experience their work, and learn about how it’s made.</p>
        <p class="fs-s close-trim">Find great art waiting to be discovered in studios, shops, parks, cafes, and upstairs in that pub you didn't even know had an upstairs.</p>
      </div>
      <div class="stack ">
        <a href="#" class="button button-cta fit-width">Explore the 2026 programme</a>
        <a href="#" class="button button-secondary button-cta fit-width">Register as an artist</a>
      </div>
    </div>
    <small class="mt-s">* Open Art is 99% free to attend, but some events require a paid reservation</small>
  </div>
  <img src="/assets/images/visitors.jpg" alt="" class="image-cover" aria-hidden="true">
</section>

<section class="theme-blush stack-section half split panel even vertical gap-xxl">
  <div
    class="stack fc readable gap-l">
    <?php $days = $page->daysRemaining() ?>
    <h2>There
      <?= $days === 1 ? 'is' : 'are' ?>
      <?= $days ?>
      day<?= $days === 1 ? '' : 's' ?>
    until the next edition of Open Art Folke
    </h2>
      <p class="close-trim"> Some things, as you know, just take time</p>
  </div>
  <?php snippet('countdown') ?>
</section>

<section class="theme-crimson stack-section layout-split">
  <img src="/assets/images/visitors-reading-map.jpg" alt="" class="image-cover" aria-hidden="true">
  <div class="panel even split fc vertical gap-l">
    <h2>Looking for the Festival Programme?<br><span style="color: var(--fg-6)">You’re early</span>
    </h2>
    <div class="box panel even stack fc readable gap-m pretty">
      <p class="fs-s">We'll release the programme in the weeks leading up to the opening. Leave us your email and we'll tell you all about it as soon as we can.</p>
      <div class="stack mt-l">
        <label for="actions-email">Email</label>
        <form class="input-group gap-s">
          <input type="email" id="actions-email" placeholder="you@example.com" style="border-radius: 0"/>
          <button class="button-cta" type="submit" style="border-radius: 0">Keep me posted</button>
        </form>
      </div>
    </div>
  </div>

</section>

<?php snippet('footer') ?>

