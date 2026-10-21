<?php
/*
 * Sponsor page (Figma "Sponsor · Redesign": Desktop 445:2919, Mobile 448:3031; docs/components/README.md).
 * Statement (Ink) → section#why (Ink: Photo pair + Why support us) → Our sponsors → What sponsors get
 * → Become a sponsor (Red) → section#support (#donate, #help) → closing Photo band → Footer. The rest is Flow.
 * Every piece of copy is a Panel field; the Figma copy is the fallback.
 */
$contactEmail = $site->contact_email()->or('openartfolke@gmail.com')->value();

$previousLinks = array_map(fn ($sponsor) => [
  'url'   => $sponsor['url']->value(),
  'label' => trim($sponsor['name']->value()),
], $page->pastSponsorsData());
?>
<?php snippet('header') ?>

<?php snippet('statement', [
  'heading' => $page->introtitle()->or("Sponsor Folkestone's first artist-led festival"),
  'aside'   => $page->text()->or('Open Art Folke is a community of artists, designers and makers who live or work in Folkestone. Every so often, we turn our studios, along with shops and other public spaces across town, into places that inspire, educate and connect people.'),
  'links'   => [['url' => '#why-support', 'label' => $page->readon_label()->or('Read on')->value(), 'icon' => 'arrow-down']],
  'class'   => 'theme-ink',
]) ?>

<section class="page-section theme-ink" id="why">
  <?php snippet('photo-pair', [
    'first'  => $page->featureimage()->toFile(),
    'second' => $page->detailimage()->toFile(),
    'wrap'   => true,
  ]) ?>
  <?php snippet('split-group', [
    'heading' => $page->helptitle()->or('Why support us'),
    'id'      => 'why-support',
    'content' => $page->helptext()->or("If it wasn't for sponsorship and donations, we would not be able to do what we do—simple as. Sponsoring Open Art Folke pays for printed programmes, our marketing costs, and low/subsidised entry fees for artists who couldn't otherwise take part. Your support also helps to keep OAF ticket-free and open to all.\n\nIn return, your business gets exposure across Folkestone during the festival, with your brand featured in programmes carried by thousands of visitors. It will also be visible online and advertised at our opening event. This is an opportunity to play a visible role in something that matters to this town, in front of an engaged, regional audience.")->kt(),
  ]) ?>
</section>

<section class="page-section theme-flow" id="sponsors">
  <?php snippet('split-group', ['heading' => $page->sponsors_title()->or('Our sponsors')], slots: true) ?>
    <?php if ($current = $page->currentSponsors()): ?>
      <div class="sponsor-roster">
        <p class="sponsor-roster__label"><?= $page->current_label()->or('Current')->esc() ?></p>
        <?php snippet('sponsor-grid', ['sponsors' => $current]) ?>
      </div>
    <?php endif ?>
    <?php if ($previousLinks !== []): ?>
      <div class="sponsor-roster">
        <p class="sponsor-roster__label"><?= $page->previous_label()->or('Previous')->esc() ?></p>
        <?php snippet('link-list', ['links' => $previousLinks]) ?>
      </div>
    <?php endif ?>
    <p><?= $page->sponsors_thanks()->or('Are you one of the foundations or brands named here? Thank you. We couldn’t have done it without you.')->esc() ?></p>
  <?php endsnippet() ?>
</section>

<section class="page-section theme-flow" id="benefits">
  <?php snippet('split-group', ['heading' => $page->benefits_title()->or('What sponsors get')], slots: true) ?>
    <?php snippet('benefits-table', ['rows' => $page->benefits()->toStructure()]) ?>
    <p class="sponsor-small-print"><?= $page->benefits_note()->or('Prices and exact allocations will be confirmed to you by the fundraising team. The list above covers standard benefits available across tiers. Sponsorship packages are for a single festival year. Sponsors with first refusal are contacted ahead of each festival cycle.')->esc() ?></p>
  <?php endsnippet() ?>
</section>

<section class="page-section theme-red" id="become">
  <?php snippet('split-group', ['heading' => $page->become_title()->or('Become a sponsor')], slots: true) ?>
    <?= $page->become_text()->or("To discuss sponsoring OAF, please email Jackie. We'll chat through what your support helps us achieve and how your brand will be highlighted, and we'll answer any questions.")->kt() ?>
    <?php snippet('copy-email', ['variant' => 'secondary']) ?>
  <?php endsnippet() ?>
</section>

<section class="page-section theme-flow" id="support">
  <?php snippet('split-group', ['heading' => $page->donate_title()->or('Buy us a coffee'), 'id' => 'donate'], slots: true) ?>
    <?= $page->donate_text()->or('Donating, however you can, helps to keep the lights on, prepare for the upcoming festival cycle, and support local creatives in making and showcasing their work.')->kt() ?>
    <?php if ($site->donation_url()->isNotEmpty()): ?>
      <?php snippet('link-hint', [
        'url'   => $site->donation_url()->value(),
        'label' => $page->donate_label()->or('Buy the OAF team a coffee')->value(),
        'hint'  => $page->donate_hint()->or('Opens in a new tab')->value(),
        'id'    => 'hint-donate',
      ]) ?>
    <?php endif ?>
  <?php endsnippet() ?>

  <?php snippet('split-group', ['heading' => $page->help_title()->or('Other ways to support us'), 'id' => 'help'], slots: true) ?>
    <?= $page->help_text()->or("Sponsorship isn't the only way to help Open Art Folke continue offering its services to the local creative community. We're always looking for:\n\n- **Venues.** Cafés, shops, studios, community halls, restaurants, or unusual spaces willing to host art, events or performances during the festival.\n- **Equipment loans.** Always on the lookout for plinths, screens, lighting, projectors and AV.\n- **Volunteer time and skills.** Our extended committee is responsible for most of the work, but we often need help with invigilation, installation, photography, videography and guiding visitors.\n\nIf you'd be up for offering any of that, it would make Becca and Thurle, and all of us at Open Art incredibly grateful. Please reach out to let us know.")->kt() ?>
    <?php snippet('link-list', ['links' => [
      ['url' => 'mailto:' . $contactEmail, 'label' => $page->help_contact_label()->or('Message us about venues or equipment')->value()],
      ['url' => page('about')?->url() ?? '', 'label' => $page->help_volunteer_label()->or('Why volunteer with us')->value()],
    ]]) ?>
  <?php endsnippet() ?>
</section>

<?php snippet('photo-band', ['image' => $page->bandimage()->toFile()]) ?>

<?php snippet('site-footer') ?>
