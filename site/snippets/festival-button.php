<?php
/**
 * One "The Festival" CTA (home.php). A registration button opens the closed-registration popover,
 * or links out once registration is open; any other button links to its own URL.
 *
 * @var Kirby\Cms\StructureObject $button
 * @var bool $secondary  second CTA gets the secondary style
 */
$class = 'button fit-width' . (($secondary ?? false) ? ' btt--secondary' : '');
$label = $button->label()->esc();
?>
<?php if ($button->registration()->toBool()): ?>
  <?php if ($site->registration_status()->or('closed')->value() !== 'open'): ?>
    <button popovertarget="registration-popover" data-popover-origin="body" class="<?= $class ?>"><?= $label ?></button>
  <?php elseif ($site->register_url()->isNotEmpty()): ?>
    <a href="<?= $site->register_url()->esc('attr') ?>" rel="noopener noreferrer" target="_blank" class="<?= $class ?>"><?= $label ?></a>
  <?php endif ?>
<?php elseif ($href = $button->link()->toUrl()): ?>
  <?php $external = str_starts_with($button->link()->value(), 'http') ?>
  <a href="<?= esc($href, 'attr') ?>"<?= $external ? ' rel="noopener noreferrer" target="_blank"' : '' ?> class="<?= $class ?>"><?= $label ?></a>
<?php endif ?>
