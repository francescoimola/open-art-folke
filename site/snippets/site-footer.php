<?php
/**
 * Footer — the end of every page, always Ink (docs/components/footer.md). Closes the <main> opened in header.php.
 * Nav list first in the HTML (CSS puts the Logo first below tablet), then the Info items and the legal rows.
 * Every string is a Site → Footer field, with the Figma copy as the fallback.
 *
 * @var \Kirby\Cms\Site $site
 */
$home = $site->homePage();

/* Legal rows: heading field, text field, Figma fallbacks. The text fields are KirbyText. */
$legal = [
  'media-credits' => [
    $site->media_credits_title()->or('Media credits'),
    $site->media_credits()->or('This site proudly features videos and photos by Niamh Pomace, Peter Blach, Dylan Komaromi, Katie Hutchings, Andrei Damian, and Sangmin Cha.'),
  ],
  'privacy' => [
    $site->privacy_title()->or('Privacy'),
    $site->privacy_text()->or('By signing up for festival updates, you agree to us collecting your email address and sending you news about the festival, artists and sponsors. We may share data with service providers and keep it only as long as necessary. Unsubscribe using the link in any email, or contact us to access, correct or delete your data.'),
  ],
  'fundraising' => [
    $site->fundraising_title()->or('Fundraising'),
    $site->fundraising_text()->or('This website may include information about fundraising and ways to support the festival. Donation pages, links or supporter/sponsorship arrangements may have their own terms.'),
  ],
  'terms' => [
    $site->terms_title()->or('Terms'),
    $site->terms_text()->or('Open Art Folke is a volunteer-run, unincorporated charitable association. This website shares info about our festival, artists and supporters. We aim to keep it accurate and up to date, but can’t guarantee it is always complete or current. Festival dates, volunteer team, fees and other arrangements may change.'),
  ],
  'copyright' => [
    $site->copyright_title()->or('Copyright © Open Art Folke, ' . date('Y')),
    $site->copyright_text()->or("Site design, copywriting, and heartfelt support by Francesco Imola.\n\nPowered by the wonderful CMS that is Kirby, and hosted by Fortrabbit in the EU."),
  ],
];

$socials = array_filter([
  'Instagram' => $site->instagram_url()->value(),
  'Facebook'  => $site->facebook_url()->value(),
]);
?>
</main>

<footer class="footer theme-ink">

  <nav class="footer__nav" aria-label="Footer">
    <?php snippet('nav-list', ['layout' => ['stacked', 'row'], 'startHere' => true, 'register' => true]) ?>
  </nav>

  <div class="footer__logo">
    <?php snippet('logo', ['size' => 'footer']) ?>
  </div>

  <div class="footer__info">

    <section class="footer__group" aria-labelledby="footer-info">
      <h2 class="footer__title" id="footer-info"><?= $site->footer_info_title()->or('All you need to know')->html() ?></h2>
      <div class="footer__content">
        <dl class="footer__list">

          <?php /* The programme link follows the homepage: hidden with Programme, and the item with it. */ ?>
          <?php if ($home->showsProgramme()): ?>
          <?php snippet('info-item', ['label' => $site->footer_visitor_label()->or('I’m a visitor')->value()], slots: true) ?>
            <?php snippet('link', [
              'url'   => $home->url() . '#programme',
              'label' => $site->footer_visitor_link()->or('See festival programme')->value(),
            ]) ?>
          <?php endsnippet() ?>
          <?php endif ?>

          <?php snippet('info-item', ['label' => $site->footer_artist_label()->or('I’m an artist/creative')->value()], slots: true) ?>
            <?php snippet('registration-notice') ?>
          <?php endsnippet() ?>

          <?php snippet('info-item', ['label' => $site->footer_socials_label()->or('Find us on socials')->value()], slots: true) ?>
            <?php if ($socials): ?>
            <ul class="footer__links" role="list">
              <?php foreach ($socials as $label => $url): ?>
              <li><?php snippet('link', ['url' => $url, 'label' => $label]) ?></li>
              <?php endforeach ?>
            </ul>
            <?php endif ?>
          <?php endsnippet() ?>

          <?php snippet('info-item', ['label' => $site->footer_contact_label()->or('Contact us')->value()], slots: true) ?>
            <?php snippet('copy-email', ['variant' => 'secondary']) ?>
          <?php endsnippet() ?>

        </dl>
      </div>
    </section>

    <?php foreach ($legal as $id => [$title, $text]): ?>
    <section class="footer__group" aria-labelledby="footer-<?= $id ?>">
      <h2 class="footer__title" id="footer-<?= $id ?>"><?= $title->html() ?></h2>
      <div class="footer__content footer__text"><?= $text->kt() ?></div>
    </section>
    <?php endforeach ?>

  </div>

</footer>

</body>

</html>
