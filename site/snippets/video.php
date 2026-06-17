<?php

/**
 * Responsive <video> from a collection of files. WebM first, MP4 fallback —
 * the browser picks the first source it supports natively.
 *
 * @var \Kirby\Cms\File|string|null $poster  File or URL string
 * @var string|null $caption                overrides the MP4 file's caption field
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

if ($poster instanceof \Kirby\Cms\File) {
	$poster = $poster->resize(1920)->url();
}

?>
<video
	style="object-fit: cover"
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
