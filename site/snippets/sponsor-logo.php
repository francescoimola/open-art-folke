<?php
/**
 * Sponsor logo — a sponsor's SVG in a fluid slot, top-left aligned (docs/components/sponsor-logo.md).
 * The slot runs from Figma's S (72×40) to M (108×60); the artwork keeps its ratio inside it. Colour = currentColor.
 * Decorative (aria-hidden): the Sponsor card's text names the sponsor.
 *
 * Usage: snippet('sponsor-logo', ['svg' => $row['logo']])
 *
 * @var string $svg    sanitised inline SVG, as returned by SponsorPage::sponsorLogo() (rows from currentSponsors() carry it as 'logo'); empty renders nothing
 * @var string $class  extra classes
 */
$svg = trim((string)($svg ?? ''));
if ($svg === '') return;
?>
<span class="<?= esc(trim('sponsor-logo ' . ($class ?? '')), 'attr') ?>"><?= $svg ?></span>
