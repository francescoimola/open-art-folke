<?php

/**
 * Responsive Vimeo embed — replaces self-hosted <video>. Vimeo handles codecs,
 * posters, streaming, and mobile playback reliably.
 *
 * Pass URL and optional title. Renders lazy do-not-track iframe in Graffiti's .aspect-video.
 *
 * @var \Kirby\Content\Field|string|null $url    Vimeo link, e.g. https://vimeo.com/123456789
 * @var \Kirby\Content\Field|string|null $title  Accessible iframe title
 * @var string|null $class                        Extra classes on the wrapper
 */

$url = $url ?? '';
/* Kirby Fields with empty YAML arrays can't cast to string. Check if raw value is an array and skip if so. */
if ($url instanceof \Kirby\Content\Field) {
	$url = $url->value;
}
if (is_array($url)) {
	return;
}
$url = trim((string) $url);
if ($url === '') {
	return;
}

/* Pull numeric video ID and unlisted hash from Vimeo URL shapes: vimeo.com/ID, vimeo.com/ID/HASH, player.vimeo.com/video/ID?h=HASH. */
if (!preg_match('~vimeo\.com/(?:video/)?(\d+)(?:/([0-9a-zA-Z]+))?~', $url, $m)) {
	return;
}
$id   = $m[1];
$hash = $m[2] ?? null;
if ($hash === null && preg_match('~[?&]h=([0-9a-zA-Z]+)~', $url, $hm)) {
	$hash = $hm[1];
}

$query = ['dnt' => 1, 'title' => 0, 'byline' => 0, 'portrait' => 0];
if ($hash !== null) {
	$query['h'] = $hash;
}
$src = 'https://player.vimeo.com/video/' . $id . '?' . http_build_query($query);

$title = trim((string) ($title ?? ''));
$class = trim('aspect-video video-embed ' . ($class ?? ''));
?>
<div class="<?= esc($class, 'attr') ?>">
	<iframe
		src="<?= esc($src, 'attr') ?>"
		loading="lazy"
		allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media"
		<?php if ($title !== ''): ?>title="<?= esc($title, 'attr') ?>"<?php endif ?>
	></iframe>
</div>
