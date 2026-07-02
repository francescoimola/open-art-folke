<?php
/**
 * Registration notice — shared body for the "not open yet" and "closed" states.
 * Rendered inside the registration popover and the footer "I'm a creative" block.
 *
 * @var \Kirby\Cms\Site $site
 * @var string $status  'soon' or 'closed'
 */
$prefix = $status === 'closed' ? 'closed' : 'soon';

$message   = $site->{$prefix . '_message'}();
$linkUrl   = $site->{$prefix . '_link_url'}();
$linkLabel = $site->{$prefix . '_link_label'}();
$footnote  = $site->{$prefix . '_footnote'}();

// Fallbacks mirror the blueprint defaults, so the notice is never blank
// between a deploy and the first Panel save (defaults aren't read on the front end).
$fallback = [
  'soon'   => ['message' => 'Registration for the next edition isn’t open yet — check back soon.'],
  'closed' => [
    'message' => 'Registration for the 2026 edition has now closed. However, you can still apply to exhibit at our sister event, held in partnership with Docker Brewery.',
  ],
][$prefix];
?>
<p class="readable"><?= $message->or($fallback['message'])->html() ?></p>
<?php if ($linkUrl->isNotEmpty()): ?>
  <hr>
  <a href="<?= $linkUrl->esc('attr') ?>" rel="noopener noreferrer" target="_blank"><?= $linkLabel->or('Apply')->html() ?> <span aria-hidden="true">↗</span></a>
<?php endif ?>
<?php if ($footnote->isNotEmpty()): ?>
  <small><?= $footnote->html() ?></small>
<?php endif ?>
