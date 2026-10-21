<?php
/**
 * Person card — one member of the team (docs/components/person-card.md): a 1:1 photo, then name, area and role in Caption.
 * Without a photo it shows a Neutral/100 tile instead (spec #6).
 * Put cards in a `ul.people` grid (2 columns, 3 in a wide container).
 *
 * Usage:
 *   <ul class="people" role="list">
 *     <?php foreach ($page->people()->toStructure() as $person): ?>
 *       <?php snippet('person-card', ['name' => $person->name(), 'area' => $person->area(), 'role' => $person->role(), 'photo' => $person->photo()->toFile()]) ?>
 *     <?php endforeach ?>
 *   </ul>
 *
 * @var string|\Kirby\Content\Field      $name   required; nothing renders without it
 * @var string|\Kirby\Content\Field|null $area   optional second line
 * @var string|\Kirby\Content\Field|null $role   optional third line
 * @var \Kirby\Cms\File|null             $photo  square-cropped (focus point); alt is empty because the name follows
 * @var string                           $tag    'li' (default, inside ul.people) or 'div'
 * @var string                           $class  extra classes
 */
$text = fn ($value): string => trim((string)($value ?? ''));

$name = $text($name ?? '');
if ($name === '') return;

$lines = array_filter([$text($area ?? null), $text($role ?? null)], fn ($line) => $line !== '');
$tag = ($tag ?? 'li') === 'div' ? 'div' : 'li';
$photo ??= null;
?>
<<?= $tag ?> class="<?= esc(trim('person-card ' . ($class ?? '')), 'attr') ?>">
  <?php if ($photo): ?>
    <figure class="person-card__photo">
      <?php snippet('image', ['file' => $photo, 'alt' => '', 'sizes' => '(width >= 768px) 25vw, 50vw']) ?>
    </figure>
  <?php else: ?>
    <div class="person-card__photo person-card__photo--empty"></div>
  <?php endif ?>
  <p class="person-card__details"><strong><?= esc($name) ?></strong><?php foreach ($lines as $line): ?> <span><?= esc($line) ?></span><?php endforeach ?></p>
</<?= $tag ?>>
