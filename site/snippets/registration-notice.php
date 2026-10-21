<?php
/**
 * Registration notice — where registration stands, from Site → Registration (the Footer's artist Info item value).
 * Open: the optional open message, then Register ↗. Not open yet / Closed: that state's message,
 * its optional link and footnote. Renders nothing when there is nothing to say.
 *
 * @var \Kirby\Cms\Site $site
 */
$status = $site->registration_status()->or('closed')->value();

if ($status === 'open') {
  $message  = $site->open_message();
  $linkUrl  = $site->register_url();
  $linkText = $site->register_label()->or('Register');
  $footnote = null;
} else {
  $prefix = $status === 'soon' ? 'soon' : 'closed';
  /* In-code fallbacks keep the item filled until the Panel field is saved; Closed uses the Figma copy. */
  $message = $site->{$prefix . '_message'}()->or([
    'soon'   => 'Registration for the next edition isn’t open yet — check back soon.',
    'closed' => 'Want to take part in upcoming editions of Open Art Folke? Come to one of our community meetings in early 2027 where we’ll announce what’s happening next. Follow us on social media to learn when these are taking place.',
  ][$prefix]);
  $linkUrl  = $site->{$prefix . '_link_url'}();
  $linkText = $site->{$prefix . '_link_label'}()->or('Apply');
  $footnote = $site->{$prefix . '_footnote'}();
}

if ($message->isEmpty() && $linkUrl->isEmpty()) return;
?>
<?php if ($message->isNotEmpty()): ?>
<?= $message->kt() ?>
<?php endif ?>
<?php if ($linkUrl->isNotEmpty()): ?>
<p><?php snippet('link', ['url' => $linkUrl->value(), 'label' => $linkText->value()]) ?></p>
<?php endif ?>
<?php if ($footnote?->isNotEmpty()): ?>
<p><small><?= $footnote->html() ?></small></p>
<?php endif ?>
