<?php
/* Homepage #programme section, "programme coming soon" state: photo + email sign-up. */
/* Swapped with programme-choice.php by the Home page's "Programme section" toggle (see home.php). */
/* Copy comes from the Home page's Programme tab; the fallbacks are the original wording. */
?>
<section class="theme-crimson stack-section layout-split">
  <?php snippet('image', [
    'file' => $page->programmeimage()->toFile(),
    'class' => 'image-cover',
    'hidden' => true,
    'sizes' => '(min-width: 768px) 50vw, 100vw',
  ]) ?>
  <div class="panel even split fc vertical gap-l">
    <h2><?= $page->signupheading()->or('Looking for the Festival Programme?')->esc() ?><br><span class="text-muted"><?= $page->signupsubheading()->or('You’re early')->esc() ?></span>
    </h2>
    <div class="stack fc readable gap-m pretty">
      <p class="fs-s"><?= $page->signuptext()->or('We\'re still setting the stage for the 3rd edition of Open Art Folke: <i>Art This Way</i>, and we\'ll release the programme in the weeks leading up to the opening. Leave us your email and we\'ll tell you all about it* as soon as we can.')->kti() ?></p>

      <?php if ($form->success()): ?>
        <div class="callout success hard" role="status">
          <p><?= $page->signupsuccess()->or('Wooho! We\'ll send you an email as soon as the programme drops 😉')->esc() ?>
          </p>
        </div>
      <?php else: ?>

        <?php $emailError = $form->error('email')[0] ?? null ?>
        <?php if ($emailError): ?>
          <div class="callout error hard" role="alert">
            <p><?= esc($emailError) ?></p>
          </div>
        <?php endif ?>

        <div class="stack mt-l">
          <label for="actions-email">Email</label>
          <form class="input-group gap-s" method="POST" action="<?= $page->url() ?>">
            <input
              type="email"
              name="email"
              id="actions-email"
              placeholder="you@example.com"
              value="<?= esc($form->old('email'), 'attr') ?>"
              <?= $emailError ? 'aria-invalid="true"' : '' ?>
            />
            <button class="btt--secondary" type="submit">Keep me posted</button>
            <?= honeypot_field() ?>
            <?= csrf_field() ?>
          </form>
        </div>

      <?php endif ?>
    </div>
    <small class="mt-s"><?= $page->signupfootnote()->or('*Spam? We want nothing to do with him either—and we\'ll never send you unsolicited communications.')->esc() ?></small>
  </div>
</section>
