<?php
/**
 * Split group — h2 in the left column, content in the right (docs/components/split-group.md).
 * Stacked below tablet, Split from tablet up (CSS only, ADR-0001). Optional media below (or above) the Row:
 * Column media (right column, 3:2) and Media (full width, 3:2 → 2:1 from tablet up). Theme comes from the parent section.
 *
 * Content is the default slot (or the `content` string); media are Files, or the named slots `columnMedia` / `media` for any other markup:
 *   <?php snippet('split-group', ['heading' => 'About the festival', 'id' => 'about', 'columnMedia' => $page->festivalimage()->toFile()], slots: true) ?>
 *     <?= $page->about_text()->kt() ?>
 *     <?php snippet('link-list', ['links' => […]]) ?>
 *   <?php endsnippet() ?>
 *   snippet('split-group', ['heading' => 'Media credits', 'content' => $site->credits()->kt(), 'divider' => true, 'tag' => 'div'])
 *
 * @var string|\Kirby\Content\Field|null $heading     h2 text (escaped here); empty = no h2, content still sits in the right column
 * @var string|null                      $content     content HTML when not using the default slot
 * @var \Kirby\Cms\File|null             $columnMedia 3:2 photo in the right column (Custom section "Column")
 * @var \Kirby\Cms\File|null             $media       full-width photo, 3:2 → 2:1 (Custom section "Wide")
 * @var bool                             $mediaFirst  put the media before the Row (Custom section photo "Before the text")
 * @var bool                             $divider     1px Theme/Text rule across the top, with Space 2XS padding block (Footer rows)
 * @var string|null                      $id          id on the group (anchors, the Statement arrow); the h2 gets "<id>-title"
 * @var string                           $tag         'section' (default, labelled by its h2) or 'div' (inside a section that has its own heading)
 * @var string                           $class       extra classes
 * @var array                            $attrs       extra attributes, merged last
 *
 * @var \Kirby\Template\Slot|null  $slot
 * @var \Kirby\Template\Slots      $slots
 */
use Kirby\Toolkit\Str;

$heading = trim((string)($heading ?? ''));
$tag = ($tag ?? 'section') === 'div' ? 'div' : 'section';
$id ??= null;
$headingId = $heading === '' ? null : ($id ? $id . '-title' : 'split-' . Str::slug($heading) . '-title');

$content = $slot !== null ? (string)$slot : (string)($content ?? '');

/* Each media slot: the named slot's markup, else the File through the image snippet at its ratio. */
$mediaRow = function (string $name, $file, string $sizes) use ($slots): string {
  $markup = $slots->$name();
  if ($markup !== null) return (string)$markup;
  if (empty($file)) return '';
  return snippet('image', ['file' => $file, 'sizes' => $sizes], return: true);
};
$columnMedia = $mediaRow('columnMedia', $columnMedia ?? null, '(width >= 768px) 50vw, 100vw');
$media = $mediaRow('media', $media ?? null, '100vw');

$figures = '';
if ($columnMedia !== '') $figures .= '<figure class="split-group__media split-group__media--column">' . $columnMedia . '</figure>';
if ($media !== '') $figures .= '<figure class="split-group__media split-group__media--wide">' . $media . '</figure>';
$mediaFirst ??= false;

$attributes = array_merge([
  'class'           => trim('split-group' . (($divider ?? false) ? ' split-group--divider' : '') . ' ' . ($class ?? '')),
  'id'              => $id,
  'aria-labelledby' => $tag === 'section' ? $headingId : null,
], $attrs ?? []);
?>
<<?= $tag ?><?= attr($attributes, ' ') ?>>
  <?php if ($mediaFirst) echo $figures ?>
  <div class="split-group__row">
    <?php if ($heading !== ''): ?>
      <h2 class="split-group__heading" id="<?= esc($headingId, 'attr') ?>"><?= esc($heading) ?></h2>
    <?php endif ?>
    <?php /* No content (a heading-only Custom section) → no empty box adding a gap under the heading. */ ?>
    <?php if (trim($content) !== ''): ?>
    <div class="split-group__content">
      <?= $content ?>
    </div>
    <?php endif ?>
  </div>
  <?php if (!$mediaFirst) echo $figures ?>
</<?= $tag ?>>
