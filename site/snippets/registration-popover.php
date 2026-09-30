<?php
/**
 * Registration popover — global, so nav triggers work on every page.
 * Only rendered when registration isn't open (the "open" state links out directly).
 * Layout classes go on the inner div, never the [popover] itself — a display utility there
 * (e.g. .stack) beats the UA's closed-popover display: none and leaves it on screen, invisible.
 *
 * @var \Kirby\Cms\Site $site
 */
$status = $site->registration_status()->or('closed')->value();
if ($status === 'open') return;
?>
<article popover id="registration-popover" class="registration-popover theme-brand" data-nav-theme="theme-blush" data-body-theme="theme-brand">
  <div class="stack gap-m">
    <?php snippet('registration-notice', ['status' => $status]) ?>
  </div>
</article>
