<?php
$contactEmail = 'openartfolke@gmail.com';

// Check-badge tick (currentColor; coloured by the wrapping .accent span).
$tick = '<svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/></svg>';

// Render one tier cell: blank → nothing (sr-only "Not included"); an
// affirmative value → a tick; anything else → the literal text.
$cell = function ($field) use ($tick) {
  $value = trim($field->value());

  if ($value === '') {
    return '<span class="visually-hidden">Not included</span>';
  }

  if (in_array(mb_strtolower($value), ['yes', 'y', '✓', '✔', 'true'], true)) {
    return '<span class="accent">' . $tick . '<span class="visually-hidden">Included</span></span>';
  }

  return esc($value);
};
?>
<?php snippet('header') ?>

<section class="panel theme-ink sponsor-feature">
  <div
    class="sponsor-grid">

    <!-- Cell 1,1: intro -->
    <div class="sponsor-grid__intro stack gap-xl">
      <h1>Sponsor Open Art</h1>
      <p>Open Art Folke is Folkestone’s first artist-led festival. We turn studios, shops, pubs, and public spaces across town into galleries, performance venues, and gathering points. We are a community of makers, artists, and all-around creatives living or working in Folkestone.</p>
    </div>

    <!-- Cell 2,1: subgrid that constrains the detail image -->
    <div
      class="sponsor-grid__detail-cell">
      <?php if ($detail = $page->detailimage()->toFile()): ?>
        <figure
          class="sponsor-grid__detail aspect-square"><?php snippet('image', [
            'file' => $detail,
            'sizes' => '(min-width: 768px) 25vw, 100vw',
          ]) ?>
        </figure>
      <?php endif ?>
    </div>

    <!-- Cell 1,2: feature image -->
    <?php if ($feature = $page->featureimage()->toFile()): ?>
      <figure
        class="sponsor-grid__feature aspect-square"><?php snippet('image', [
          'file' => $feature,
          'sizes' => '(min-width: 768px) 50vw, 100vw',
        ]) ?>
      </figure>
    <?php endif ?>

    <!-- Cell 2,2: help copy -->
    <div class="sponsor-grid__help stack gap-xl">
      <h2><?= $page->helptitle()->html() ?></h2>
      <div class="stack gap-l">
        <p>Sponsorship pays for printed programmes, our marketing costs, and low/subsidised entry fees for artists who couldn’t otherwise take part. Your support is what keeps OAF free and open to everyone.</p>
        <p>In return, your business gets exposure across Folkestone during the festival, with your brand featured in programmes carried by thousands of visitors. It will also be visible online and advertised at our opening event. This is an opportunity to play a visible role in something that matters to this town, in front of an engaged, regional audience.</p>
      </div>
    </div>

  </div>
</section>

<section class="panel theme-crimson sponsors sponsors-roster stack gap-xxl">
  <h2 class="h1">Our sponsors</h2>

  <div class="stack gap-l">
    <p>Current</p>
    <?php snippet('sponsor-list', [
      'sponsors' => $page->currentSponsors(),
      'idPrefix' => 'current-sponsor',
    ]) ?>
  </div>

  <hr class="show-desktop">

  <div class="stack gap-xl">
    <p>Previous</p>
    <ul class="sponsors-past accent stack">
      <?php foreach ($page->pastSponsorsData() as $p): ?>
        <li>
          <?php if ($p['url']->isNotEmpty()): ?>
            <a class="h3" href="<?= $p['url']->esc('attr') ?>" target="_blank" rel="noopener noreferrer">
              <?= esc($p['name']->value()) ?> <span aria-hidden="true">↗</span>
            </a>
          <?php else: ?>
            <p class="h3"><?= esc($p['name']->value()) ?></p>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
  </div>

  <p>If you're one of the people or brands named here, thank you for your support.</p>
</section>

<section class="panel theme-paper sponsor-support stack gap-xxl">

  <div class="stack gap-xl">
    <h2 class="h1">What sponsors get</h2>
    <div class="table">
      <table>
        <thead>
          <tr>
            <th scope="col">Benefit</th>
            <th scope="col">Gold</th>
            <th scope="col">Silver</th>
            <th scope="col">Bronze</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($page->benefits()->toStructure() as $row): ?>
            <tr>
              <th scope="row"><?= $row->benefit()->html() ?></th>
              <td><?= $cell($row->gold()) ?></td>
              <td><?= $cell($row->silver()) ?></td>
              <td><?= $cell($row->bronze()) ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <small class="readable">Prices and exact allocations will be confirmed to you by the fundraising team. The list above covers standard benefits available across tiers. Sponsorship packages are for a single festival year. Sponsors with first refusal are contacted ahead of each festival cycle.</small>
  </div>
</section>

<section class="panel theme-paper sponsor-support stack gap-xxl">
  <div class="stack gap-l">
    <h2 class="mb-m">Become a sponsor</h2>
    <p class="readable">To discuss sponsoring OAF, please email Jackie at
      <strong>openartfolke at gmail dot com</strong>. We’ll chat through what your support helps us achieve and how your brand will be highlighted, and we’ll answer any questions.</p>
    <button class="btt--secondary fit-width" type="button" data-copy="<?= esc($contactEmail, 'attr') ?>">Copy email address</button>
  </div>

  <div class="stack gap-l">
    <h2 class="mb-m">Buy us a coffee</h2>
    <p class="readable">Donating, however you can, helps to keep the lights on, prepare for the upcoming festival cycle, and support local creatives in making and showcasing their work.</p>
    <?php if ($site->donation_url()->isNotEmpty()): ?>
      <a class="button btt--secondary fit-width" href="<?= $site->donation_url()->esc('attr') ?>" rel="noopener noreferrer" target="_blank">Buy the OAF team a coffee
        <span aria-hidden="true">↗</span>
      </a>
    <?php endif ?>
  </div>

  <div class="stack gap-m">
    <h2 class="mb-m">Other ways to support us</h2>
    <p class="readable">Sponsorship isn’t the only way to help Open Art Folke continue offering its services to the local creative community.</p>
    <p class="readable">We’re always looking for:</p>
    <ul class="stack dots gap-m readable">
      <li>
        <p>
          <strong>Venues.</strong>
          Cafés, shops, studios, community halls, restaurants, or unusual spaces willing to host art, events or performances during the festival.
        </p>
      </li>
      <li>
        <p>
          <strong>Equipment loans.</strong>
          Always on the lookout for plinths, screens, lighting, and AV.
        </p>
      </li>
      <li>
        <p>
          <strong>Volunteer time and skills.</strong>
          Our extended committee is responsible for most of the work, but we often need help with invigilation, installation, photography, videography and guiding visitors.
        </p>
      </li>
    </ul>
    <p class="readable">If you'd be up for offering any of that, it would make Becca and Thurle, and all of us at Open Art incredibly grateful. Please reach out to let us know.</p>
  </div>

</section>

<?php snippet('photo-banner', [
  'hideText' => true,
  'half' => true,
  'logoBottom' => true,
]) ?>

<?php snippet('site-footer') ?>

