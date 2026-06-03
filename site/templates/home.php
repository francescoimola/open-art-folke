<?php snippet('header') ?>

<section class="hero stack-section flex text-center stack-gap-none">
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
        <a href="#" class="button fit-width">Explore the 2026 programme</a>
        <a href="#" class="button btt--secondary fit-width">Register as an artist</a>
      </div>
    </div>
    <small class="mt-s">* Open Art is 99% free to attend, but some events require a paid reservation</small>
  </div>
  <img src="/assets/images/visitors.jpg" alt="" class="image-cover" aria-hidden="true">
</section>

<section class="theme-blush stack-section half layout-split split-gap-xxl panel even">
  <div
    class="stack readable gap-l">
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

<section class="theme-crimson stack-section layout-split">
  <img src="/assets/images/visitors-reading-map.jpg" alt="" class="image-cover" aria-hidden="true">
  <div class="panel even split fc vertical gap-l">
    <h2>Looking for the Festival Programme?<br><span class="text-muted">You’re early</span>
    </h2>
    <div class="stack fc readable gap-m pretty">
      <p class="fs-s">We'll release the programme in the weeks leading up to the opening. Leave us your email and we'll tell you all about it* as soon as we can.</p>
      <div class="stack mt-l">
        <label for="actions-email">Email</label>
        <form class="input-group gap-s">
          <input type="email" id="actions-email" placeholder="you@example.com"/>
          <button class="btt--secondary" type="submit">Keep me posted</button>
        </form>
      </div>
    </div>
    <small class="mt-s">*Spam? We want nothing to do with him either—and we'll never send you unsolicited communications.</small>
  </div>
</section>

<section class="sponsors theme-blush stack-section half panel even stack gap-xxl">
  <h2>Recent sponsors</h2>
  <?php
  // Build the data once; both layouts below render from it (logos sanitised once each).
  $sponsors = [];
  foreach ($page->sponsors()->toStructure() as $s) {
    $sponsors[] = [
      'name' => $s->name(),
      'url' => $s->url(),
      'logo' => $page->sponsorLogo($s),
    ];
  }

  // Shared name markup (plain text, or a link when a Website is set).
  $sponsorName = fn($s) => $s['url']->isNotEmpty()
    ? '<a href="' . $s['url']->esc('attr') . '">' . esc($s['name']->value()) . '</a>'
    : esc($s['name']->value());
  ?>

  <!-- Mobile: a Graffiti carousel of cards, name + logo shown together. -->
  <ul
    class="sponsors-mobile show-mobile carousel accent">
    <?php foreach ($sponsors as $s): ?>
      <li class="box ghost split vertical center">
        <p class="h1"><?= $sponsorName($s) ?></p>
        <?php if ($s['logo']): ?>
          <figure class="sponsor-logo center-both"><?= $s['logo'] ?></figure>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>

  <!-- Desktop: a stacked list; each row reveals its own logo on hover/focus. -->
  <ul
    class="sponsors-desktop show-desktop stack gap-xl accent">
    <?php foreach ($sponsors as $s): ?>
      <li>
        <div class="dropdown" style="--anchor: --dropdown-options">
          <button class="reset" style="all: unset" popovertarget="dropdown-options">
            <p class="h1"><?= $sponsorName($s) ?></p>
          </button>
        </div>
        <div id="dropdown-options" popover class="dropdown-menu">
          <div class="dropdown-header">High-quality scanning and fine art printers</div>
          <hr>
          <a href="#profile">Visit website <span aria-hidden="true">↗</span></a>
        </div>

        <?php if ($s['logo']): ?>
          <figure class="sponsor-logo center-both"><?= $s['logo'] ?></figure>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>

  <div class="cluster gap-m accent">
    <a href="#" class="button btt--secondary">See all our sponsors</a>
    <a href="#">Who's behind Open Art Folke</a>
  </div>
</section>

<?php snippet('footer') ?>

