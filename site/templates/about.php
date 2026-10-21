<?php
/**
 * About page (docs/components/README.md "About redesign"; Figma Desktop v2 399:1839, Mobile v2 399:2255).
 * Statement (Red) → Photo band → #how (Red) → Photo pair → #get-involved → #people → principles (Red) + Photo band → Footer.
 * Every string is a Panel field with the Figma copy as the fallback, so empty fields render the design.
 *
 * @var \Kirby\Cms\Page $page
 * @var \Kirby\Cms\Site $site
 */
$sponsorUrl = page('sponsor')?->url() ?? url('sponsor');
$email = $site->contact_email()->or('openartfolke@gmail.com')->value();
?>
<?php snippet('header') ?>

<?php snippet('statement', [
  'heading' => $page->statement_heading()->or('How do we make Open Art Folke possible'),
  'aside'   => $page->statement_aside()->or("We're a friendly bunch of creative types, from arts and non-arts backgrounds, who've joined forces to give our peers a reason to make and show their work—which they'd otherwise hide behind the couch indefinitely.\n\nOpen Art Folke is the perfect reason for folks to tidy their studios, open their doors, and collaborate. And for anyone visiting, it’s a reason to join in and experience some of the best ideas that Folkestone has to offer."),
  'links'   => [[
    'url'   => '#how',
    'label' => $page->statement_link()->or("Here's how")->value(),
    'icon'  => 'arrow-down',
  ]],
]) ?>

<?php snippet('photo-band', ['image' => $page->heroimage()->toFile(), 'first' => true]) ?>

<div class="page-section theme-red" id="how">
  <?php snippet('split-group', [
    'heading' => $page->behind_title()->or('What goes on behind the scenes'),
    'id'      => 'behind-the-scenes',
    'content' => $page->behind_text()->or("As a community led by artists for artists, we make sure to check in with the community between festivals, ask questions and run labs on topics such as finding a venue, collaborating and marketing your work. Of course, there's also a lot that we do behind the scenes to prepare for the upcoming festival season, such as coming up with improbable marketing ideas, divvying up tasks, and fundraising, fundraising, fundraising.")->kt(),
  ]) ?>

  <?php snippet('split-group', [
    'heading' => $page->invest_title()->or('Where we invest'),
    'id'      => 'where-we-invest',
  ], slots: true) ?>
    <?= $page->invest_text()->or('Participating creatives pay a small fee to take part in the festival, the rest of our money comes from sponsors and local arts funding. We run a bit like a charity—even though we’re officially a “non-profit, unincorporated association”, bit of a mouthful—and everything we receive goes back into the festival, the marketing, and the community events we run in between.')->kt() ?>
    <?php snippet('link', ['url' => $sponsorUrl, 'label' => $page->invest_link()->or('Who makes for a good sponsor')->value()]) ?>
  <?php endsnippet() ?>
</div>

<div class="page-section theme-flow">
  <?php snippet('photo-pair', ['first' => $page->image1()->toFile(), 'second' => $page->image2()->toFile()]) ?>
</div>

<div class="page-section page-section--flush-start theme-flow">
  <?php snippet('split-group', [
    'heading' => $page->involved_title()->or('Get involved'),
    'id'      => 'get-involved',
  ], slots: true) ?>
    <?= $page->involved_text()->or('We don’t guarantee running a festival each year, but when we do run, our incredible team is what makes it possible. We’re a dozen volunteers at the moment, but there’s always room for more. Know your onions? Alright with spreadsheets, words, design software, ladders, herding cats, or talking to people? Send us a message and don’t make it wait.')->kt() ?>
    <?php snippet('link', ['url' => 'mailto:' . $email, 'label' => $page->involved_link()->or('Message us about volunteering')->value()]) ?>
  <?php endsnippet() ?>
</div>

<div class="page-section theme-flow">
  <?php snippet('split-group', [
    'heading' => $page->people_title()->or('The folks behind Open Art Folke'),
    'id'      => 'people',
  ], slots: true) ?>
    <div class="people">
      <ul class="people__list" role="list">
        <?php foreach ($page->people()->toStructure() as $person): ?>
          <?php snippet('person-card', [
            'name'  => $person->name(),
            'area'  => $person->area(),
            'role'  => $person->role(),
            'photo' => $person->photo()->toFile(),
          ]) ?>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endsnippet() ?>
</div>

<?php
/* Principles: a Panel structure, else the eight designed lines. */
$principles = [];
foreach ($page->principles()->toStructure() as $item) {
  $line = trim($item->principle()->value() ?? '');
  if ($line !== '') $principles[] = $line;
}
if ($principles === []) {
  $principles = [
    'We are open to all',
    'We are a community',
    'We are collaborative',
    'We are reliant on artist participation',
    'We are honest and straightforward',
    'We are not sales or professional agents',
    'We are not curated or themed',
    'We are not always a festival',
  ];
}
?>
<?php /* The Photo band comes first in the HTML (desktop order); below tablet, about.scss moves it after the principles. */ ?>
<div class="about-principles">
  <?php snippet('photo-band', ['image' => $page->principlesimage()->toFile()]) ?>
  <div class="page-section theme-red">
    <?php snippet('split-group', [
      'heading' => $page->principles_title()->or('Our (very solemn but very important) guiding principles'),
      'id'      => 'principles',
    ], slots: true) ?>
      <ul class="principles-list" role="list">
        <?php foreach ($principles as $principle): ?>
          <li class="principles-list__item"><?= esc($principle) ?></li>
        <?php endforeach ?>
      </ul>
    <?php endsnippet() ?>
  </div>
</div>

<?php snippet('site-footer') ?>
