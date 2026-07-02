<?php
/**
 * Registration popover — global, so nav triggers work on every page.
 * Only rendered when registration isn't open (the "open" state links out directly).
 *
 * @var \Kirby\Cms\Site $site
 */
$status = $site->registration_status()->or('closed')->value();
if ($status === 'open') return;
?>
<article popover id="registration-popover" class="stack gap-m registration-popover theme-brand" data-nav-theme="theme-blush" data-body-theme="theme-brand">
  <?php snippet('registration-notice', ['status' => $status]) ?>
</article>
