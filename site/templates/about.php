<?php snippet('header') ?>

<section class="page-hero panel even theme-brand stack-section">
  <?php snippet('image', [
    'file' => $page->heroimage()->toFile(),
    'class' => 'page-hero__bg darken-200',
    'hidden' => true,
    'loading' => 'eager',
    'fetchpriority' => 'high',
    'sizes' => '100vw',
  ]) ?>
  <h1>About Open Art</h1>
</section>

<section class="panel even theme-paper stack-section flowing stack gap-xxl">
  <div class="tagline stack gap-l">
    <p class="statement">Under the umbrella of Open Art Folke, creatives come together all year round for labs, events, and conversations.</p>
    <p class="statement">Every so often, we invite the whole town to join us for a mighty festival, where you can meet the makers in their studios, their homes or perhaps in more unlikely corners of Folkestone.</p>
  </div>

  <div class="grid about-grid">
    <figure class="">
      <?php snippet('image', [
        'file' => $page->image1()->toFile(),
        'sizes' => '(min-width: 768px) 50vw, 100vw',
      ]) ?>
    </figure>
    <figure>
      <?php snippet('image', [
        'file' => $page->image2()->toFile(),
        'sizes' => '(min-width: 768px) 50vw, 100vw',
      ]) ?>
    </figure>
  </div>
</section>

<section class="panel even theme-paper stack gap-xl stack-section flowing">
  <div class="stack gap-xl">
    <h2>The people behind Open Art Folke</h2>
    <p class="readable">OAF is a nonprofit, volunteer-run collective led by artists for artists. We don't guarantee running a festival each year, but when we do run, our incredible team is what makes it possible.</p>
  </div>

  <ul class="stack people-list">
    <?php foreach ($page->people()->toStructure() as $person): ?>
      <li>
        <?php if ($photo = $person->photo()->toFile()): ?>
          <div class="people-row__photo aspect-square">
            <?php snippet('image', [
              'file' => $photo,
              'sizes' => '20vw',
              'alt' => $person->name()->value(),
            ]) ?>
          </div>
        <?php endif ?>
        <article class="stack">
          <span class="h5 fluid text-muted"><?= $person->name()->html() ?></span>
          <span><?= $person->area()->html() ?></span>
          <span><?= $person->role()->html() ?></span>
        </article>
      </li>
    <?php endforeach ?>
  </ul>
</section>

<section class="theme-paper panel even stack-section half flowing stack gap-xxl">
  <h2>FAQs</h2>
    <div class="stack gap-m">
      <details class="minimal stack">
      <summary class="fluid fs-xl"><p class="fs-xl">Who are we here for?</p></summary>
      <p class="readable">
        Art and culture have emerged from, and found their way to Folkestone in various forms over the years. Open Art Folke is here to celebrate both, by supporting the active creative community that makes this coastal town so shit hot special.
      </p>
    </details>
    <hr>
    <details class="minimal stack">
      <summary class="fluid fs-xl"><p class="fs-xl">Why not just open studios?</p></summary>
      <p class="readable">
        Since 2024, we've encouraged creatives to think of the Open Art festival as an opportunity to welcome the public into their studios, of course, but have a go at exhibiting work or hosting events in unlikely spaces too—for by doing so we bring art and creativity to the everyday lives of everyday people.
      </p>
    </details>
    <hr>
    <details class="minimal stack">
      <summary class="fluid fs-xl"><p class="fs-xl">Are you a charity?</p></summary>
      <p class="readable">
        Not at the moment. We qualify as a non-profit, unincorporated association. That is, we are a group of individuals who have voluntarily come together for a common purpose, and like many volunteer-led groups, we are reliant on <a href="/sponsors">the generous support of our sponsors and venues</a>.
      </p>
    </details>
    </div>
</section>

<section class="principles stack-section flowing">
  <?php snippet('image', [
    'file' => $page->principlesimage()->toFile(),
    'class' => 'principles__bg',
    'hidden' => true,
    'sizes' => '100vw',
  ]) ?>
  <div class="principles__card panel even theme-brand stack gap-xxl text-center">
    <h2>Our (very solemn but very important) guiding principles</h2>
    <ul class="stack gap-base fs-l">
      <li>We are open to all</li>
      <li>We are a community</li>
      <li>We are collaborative</li>
      <li>We are reliant on artist participation</li>
      <li>We are honest and straightforward</li>
      <li>We are not sales or professional agents</li>
      <li>We are not curated or themed</li>
      <li>We are not always a festival</li>
    </ul>
  </div>
</section>

<?php snippet('photo-banner', [
  'hideText' => true,
  'half' => true,
  'logoBottom' => true,
]) ?>

<?php snippet('site-footer') ?>
