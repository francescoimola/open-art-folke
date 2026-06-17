<?php
$registerUrl = $site->register_url()->isNotEmpty() ? $site->register_url()->value() : null;
$contactEmail = 'openartfolke@gmail.com';
?>
</main>

<footer class="footer theme-ink panel stack gap-xl stack-section">

  <nav class="cluster center" aria-label="Footer">
    <a class="underline" href="<?= $site->url() ?>"<?= e($site->homePage()->isActive(), ' aria-current="page"') ?>>Home</a>
    <a class="underline" href="<?= $site->homePage()->url() ?>#programme">Programme</a>
    <?php foreach ($site->children()->not('home', 'media') as $child): ?>
      <a class="underline" href="<?= $child->url() ?>"<?= e($child->isActive(), ' aria-current="page"') ?>><?= $child->title() ?></a>
    <?php endforeach ?>
    <?php if ($registerUrl): ?>
      <a class="underline" href="<?= esc($registerUrl, 'attr') ?>" rel="noopener noreferrer" target="_blank">Register <span aria-hidden="true">↗</span></a>
    <?php endif ?>
  </nav>

  <hr>

  <div class="layout-split" style="--layout-gap: var(--vs-xxl);">
    <h2 class="fs-xxl">Key information</h2>
    <div class="stack gap-xl">
      <div class="stack gap-m">
        <h3 class="fs-xxl">I’m a visitor</h3>
        <a class="button btt--contrast fit-width" href="<?= $site->homePage()->url() ?>#programme">See upcoming festival programme</a>
      </div>
      <div class="stack gap-m">
        <h3 class="fs-xxl text-muted">I’m a creative</h3>
        <a class="button btt--contrast fit-width" href="<?= esc($registerUrl ?? '#', 'attr') ?>"<?= e($registerUrl, ' rel="noopener noreferrer" target="_blank"') ?>>Register as a creative</a>
      </div>
    </div>
  </div>

  <hr>

  <div class="layout-split" style="--layout-gap: var(--vs-xxl);">
    <h2 class="fs-xxl">Questions</h2>
    <div class="stack gap-xl">
      <div class="stack gap-m">
        <h3 class="fs-xxl text-muted">Contact us</h3>
        <p>Email us at <?= esc($contactEmail) ?></p>
        <button class="btt--contrast fit-width" type="button" data-copy="<?= esc($contactEmail, 'attr') ?>">Copy email address</button>
      </div>
      <div class="stack gap-m">
        <h3 class="fs-xxl text-muted">Elsewhere</h3>
        <div class="stack gap-s">
          <?php if ($site->instagram_url()->isNotEmpty()): ?>
            <a class="button btt--contrast fit-width" href="<?= $site->instagram_url()->esc('attr') ?>" rel="noopener noreferrer" target="_blank">Instagram</a>
          <?php endif ?>
          <?php if ($site->facebook_url()->isNotEmpty()): ?>
            <a class="button btt--contrast fit-width" href="<?= $site->facebook_url()->esc('attr') ?>" rel="noopener noreferrer" target="_blank">Facebook</a>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <div id="credits-terms" class="layout-split" style="--layout-gap: var(--vs-xxl);">
    <h2 class="fs-xxl">Provisions</h2>
    <div class="stack gap-xl">
      <?php if ($site->media_credits()->isNotEmpty()): ?>
      <div class="stack gap-l">
        <h3>Media credits</h3>
        <div class="pretty"><?= $site->media_credits()->kt() ?></div>
      </div>
      <?php endif ?>
    <div class="stack gap-l">
        <h3>Privacy</h3>
        <p class="pretty">When signing up for festival updates you agree for us to collect your email address and receive emails about the festival, artists, sponsors and related news. We may share data with service providers. We keep your data only as long as necessary. You can unsubscribe using the link in our emails, or contact us for access, correction or deletion.</p>
      </div>
      <div class="stack gap-l">
        <h3>Fundraising</h3>
        <p class="pretty">This website may include information about fundraising activity and support opportunities for the festival. Any fundraising pages, donation links, or supporter arrangements may be subject to separate terms or processing information where relevant.</p>
      </div>
      <div class="stack gap-l">
        <h3>Terms</h3>
        <p class="pretty">This website provides general infor about Open Art Folke, and its festival, artists and supporters. We aim for accuracy and update information regularly, but can't guarantee everything will always be complete or current. Festival dates, participants, fees and other arrangements may change.</p>
      </div>
    </div>
  </div>

  <hr>

  <div class="layout-split footer__legal">
    <small>Copyright ©️ Open Art Folke, 2026</small>
    <div class="stack">
    <small>Site design and heartfelt support by <a href="https://francescoimola.com/" rel="noopener noreferrer" target="_blank">Francesco Imola</a></small>
    <small>Powered by the wonderful CMS that is <a href="https://getkirby.com" rel="noopener noreferrer" target="_blank">Kirby</a>, and hosted by <a href="https://www.fortrabbit.com" rel="noopener noreferrer" target="_blank">Fortrabbit</a> in the EU.</small>
  </div>
  </div>

</footer>
</body>
</html>
