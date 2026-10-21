<?php
/**
 * Link + hint — a Large Link with one line underneath saying what happens next (docs/components/link-hint.md).
 * The hint is wired to the link with aria-describedby, so the Link drops its hidden "(opens in a new tab)" text.
 * Stack several inside a Split group's content (Space M apart).
 *
 * Usage:
 *   snippet('link-hint', ['url' => $programmeUrl, 'label' => 'See programme', 'hint' => 'Opens in a new tab'])
 *   snippet('link-hint', [
 *     'url'      => $pdf->url(),
 *     'label'    => 'Download PDF',
 *     'hint'     => 'Save the programme on your device (' . $pdf->niceSize() . ')',
 *     'download' => true,
 *   ])
 *
 * @var string           $url       required (as Link)
 * @var string           $label     required (as Link)
 * @var string           $hint      the consequence of clicking, about 40 characters; empty = a plain Large Link
 * @var string|null      $id        the hint's id; defaults to "hint-<label slug>" (must be unique on the page)
 * @var bool|null        $external  as Link: null = detect from the URL
 * @var bool|string      $download  as Link
 * @var string|bool|null $icon      as Link: force a glyph, or false for none
 * @var string           $class     extra classes
 */
use Kirby\Toolkit\Str;

$label = (string)($label ?? '');
$hint = trim((string)($hint ?? ''));
$hintId = $hint === '' ? null : ($id ?? 'hint-' . Str::slug($label));
?>
<p class="<?= esc(trim('link-hint ' . ($class ?? '')), 'attr') ?>"><?php snippet('link', [
  'url'         => $url ?? '',
  'label'       => $label,
  'size'        => 'large',
  'external'    => $external ?? null,
  'download'    => $download ?? false,
  'icon'        => $icon ?? null,
  'describedby' => $hintId,
]) ?><?php if ($hintId): ?><span class="link-hint__hint" id="<?= esc($hintId, 'attr') ?>"><?= esc($hint) ?></span><?php endif ?></p>
