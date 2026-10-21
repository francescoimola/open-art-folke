<?php
/**
 * Info item — one label → value pair in a <dl> (docs/components/info-item.md), e.g. the Footer's "All you need to know".
 * The value is the snippet's slot: body text, a Link, a list of Links or Copy email.
 * Label above value in a narrow container; two equal columns once the container is wide enough (Split).
 *
 * Usage:
 *   <?php snippet('info-item', ['label' => 'Contact us'], slots: true) ?>
 *     <?php snippet('copy-email', ['email' => $email]) ?>
 *   <?php endsnippet() ?>
 *
 * @var string $label  required; plain text, escaped here
 * @var string $class  extra classes
 * @var \Kirby\Template\Slot|null $slot  the value
 */
$value = trim((string)($slot ?? ''));
if ($value === '' || empty($label)) return;
?>
<div class="<?= esc(trim('info-item ' . ($class ?? ''))) ?>">
  <dt class="info-item__label"><?= esc($label) ?></dt>
  <dd class="info-item__value"><?= $value ?></dd>
</div>
