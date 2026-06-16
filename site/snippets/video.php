<?php

/**
 * Responsive <video> with WebM → MP4 fallback from a collection of Kirby files.
 *
 * Renders <source> elements in priority order (WebM first, MP4 fallback) so
 * browsers pick the first format they support natively. Zero JavaScript —
 * this is standard HTML source selection.
 *
 * Usage:
 *   snippet('video', [
 *     'files'  => $page->video()->toFiles(),
 *     'class'  => 'aspect-video',
 *   ]);
 *
 * @var \Kirby\Cms\Files|\Kirby\Cms\File[]|null $files   collection of video files
 * @var string|null $class                                CSS class for the <video>
 * @var string|null $caption                              overrides the MP4 file's caption field
 * @var bool       $controls                              show native playback controls (default true)
 * @var bool       $playsinline                           allow inline playback on iOS (default true)
 * @var string     $preload                               'metadata' (default), 'auto', or 'none'
 * @var bool       $muted                                 mute by default
 * @var bool       $autoplay                              autoplay (requires muted in most browsers)
 * @var bool       $loop                                  loop playback
 * @var string|null $poster                               poster image URL
 */

if (empty($files) || $files->count() === 0) {
	return;
}

$mp4  = $files->filterBy('extension', 'mp4')->first();
$webm = $files->filterBy('extension', 'webm')->first();

if (!$mp4 && !$webm) {
	return;
}

$controls    = $controls ?? true;
$playsinline = $playsinline ?? true;
$preload     = $preload ?? 'metadata';
$muted       = $muted ?? false;
$autoplay    = $autoplay ?? false;
$loop        = $loop ?? false;

if (($caption ?? null) === null) {
	$caption = $mp4 ? $mp4->caption()->or('')->value() : '';
}

?>
<video
	<?php if (!empty($class)): ?>class="<?= esc($class) ?>"<?php endif ?>

	<?php if ($controls): ?>controls<?php endif ?>

	<?php if ($playsinline): ?>playsinline<?php endif ?>

	preload="<?= esc($preload) ?>"
	<?php if ($muted): ?>muted<?php endif ?>

	<?php if ($autoplay): ?>autoplay<?php endif ?>

	<?php if ($loop): ?>loop<?php endif ?>

	<?php if (!empty($poster)): ?>poster="<?= esc($poster, 'attr') ?>"<?php endif ?>

	<?php if (!empty($caption)): ?>aria-label="<?= esc($caption, 'attr') ?>"<?php endif ?>

>
	<?php if ($webm): ?>
	<source src="<?= $webm->url() ?>" type="video/webm">
	<?php endif ?>
	<?php if ($mp4): ?>
	<source src="<?= $mp4->url() ?>" type="video/mp4">
	<?php endif ?>
</video>
