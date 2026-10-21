<?php
/**
 * Statement — the opening band of a page (docs/components/statement.md): one h1 on a Theme, Red by default.
 * Stacked below tablet (Heading, Body and Kicker each on their own line, optional ↓ Arrow);
 * Split from tablet up (the h1 runs on as one paragraph; with an Aside or Links, two equal columns).
 *
 * Usage:
 *   snippet('statement', ['heading' => $page->title()])
 *   snippet('statement', [
 *     'heading' => 'About Open Art Folke',
 *     'aside'   => $page->statement_aside()->or('…')->kt(),
 *     'links'   => [['url' => '#how', 'label' => "Here's how", 'icon' => 'arrow-down']],
 *   ])
 *   snippet('statement', ['heading' => …, 'body' => …, 'kicker' => …, 'arrow' => '#content', 'arrowLabel' => 'Skip to the programme'])
 *
 * @var string|\Kirby\Content\Field      $heading     required; the h1's first sentence (plain text, escaped here)
 * @var string|\Kirby\Content\Field|null $body        optional follow-on sentence
 * @var string|\Kirby\Content\Field|null $kicker      optional short closing line
 * @var string|\Kirby\Content\Field|null $aside       optional Aside, as HTML (e.g. ->kt()); a Field is rendered with ->kt()
 * @var array                            $links       optional Links row under the Aside: one array of Link snippet params per link
 *                                                    (year links, or one skip link with 'icon' => 'arrow-down'); "·" goes between them
 * @var string|null                      $arrow       href of the ↓ Arrow link (Stacked only; Split never shows it), e.g. '#content'
 * @var string                           $arrowLabel  visually hidden label naming the Arrow's target section
 * @var string|null                      $id          section id
 * @var string                           $class       extra classes; a theme-* class here replaces the default theme-red
 * @var array                            $attrs       extra attributes on the <section>, merged last
 */
use Kirby\Content\Field;

$text = fn ($value): string => trim((string)($value ?? ''));

$heading = $text($heading ?? '');
if ($heading === '') return;

$body   = $text($body ?? null);
$kicker = $text($kicker ?? null);
$aside  = ($aside ?? null) instanceof Field ? (string)$aside->kt() : trim((string)($aside ?? ''));
$links  = array_values(array_filter($links ?? [], fn ($link) => is_array($link) && (string)($link['url'] ?? '') !== ''));
$arrow  = $text($arrow ?? null);
$class  = trim($class ?? '');

/* Theme is the section's class (ADR-0002): Red unless the caller passes another theme-* class. */
$theme = str_contains($class, 'theme-') ? '' : 'theme-red';
$hasAside = $aside !== '' || $links !== [];

$attributes = array_merge([
  'class' => trim('statement ' . $theme . ($hasAside ? ' statement--aside' : '') . ' ' . $class),
  'id'    => $id ?? null,
], $attrs ?? []);
?>
<section<?= attr($attributes, ' ') ?>>
  <h1 class="statement__heading"><?= esc($heading) ?><?php if ($body !== ''): ?> <span class="statement__line"><?= esc($body) ?></span><?php endif ?><?php if ($kicker !== ''): ?> <span class="statement__line"><?= esc($kicker) ?></span><?php endif ?></h1>
  <?php if ($hasAside): ?>
    <div class="statement__aside">
      <?php if ($aside !== ''): ?>
        <div class="statement__text"><?= $aside ?></div>
      <?php endif ?>
      <?php if ($links !== []): ?>
        <ul class="statement__links" role="list">
          <?php foreach ($links as $link): ?>
            <li><?php snippet('link', $link) ?></li>
          <?php endforeach ?>
        </ul>
      <?php endif ?>
    </div>
  <?php endif ?>
  <?php if ($arrow !== ''): ?>
    <a class="statement__arrow" href="<?= esc($arrow, 'attr') ?>"><?php snippet('icon', ['glyph' => 'arrow-down']) ?><span class="visually-hidden"><?= esc($arrowLabel ?? 'Skip to the content') ?></span></a>
  <?php endif ?>
</section>
