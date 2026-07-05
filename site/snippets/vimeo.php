<?php

/**
 * Responsive Vimeo embed — the project's standard way to show video. We no
 * longer self-host MP4/WebM: Vimeo handles codecs, posters, adaptive streaming,
 * and mobile playback, which the old <video> snippet could not do reliably
 * (AV1/WebM stalled on phones, heavy PNG posters never loaded).
 *
 * Pass a Vimeo URL (a string or a Kirby Field — both stringify to the value)
 * and an optional accessible title. Renders a lazy, do-not-track iframe inside
 * Graffiti's 16/9 `.aspect-video` box (filled via `.video-embed`).
 *
 * @var \Kirby\Content\Field|string|null $url    Vimeo link, e.g. https://vimeo.com/123456789
 * @var \Kirby\Content\Field|string|null $title  Accessible iframe title
 * @var string|null $class                        Extra classes on the wrapper
 */

$url = $url ?? '';
// Kirby Fields with empty YAML arrays can't cast to string. Check if the
// Field's raw value is an array (empty or otherwise) and skip if so.
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

// Pull the numeric video ID and any unlisted hash out of the common Vimeo URL
// shapes: vimeo.com/ID, vimeo.com/ID/HASH, player.vimeo.com/video/ID?h=HASH.
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
