<?php
/**
 * Copy email — a Button that copies the address, with the address always visible below it (docs/components/copy-email.md).
 * The address is a mailto: link so it can be tapped, but it reads as plain body text, as in Figma.
 * Button colours follow the section's Theme; the Footer (Ink) uses the secondary variant.
 *
 * Usage: snippet('copy-email', ['variant' => 'secondary'])
 *
 * @var string|null $email    address; defaults to Site → Contact email
 * @var string|null $label    button label; defaults to Site → "Copy email" button label
 * @var string      $variant  'primary' | 'secondary' (Button variant)
 * @var string      $class    extra classes
 *
 * @var \Kirby\Cms\Site $site
 */
$email = trim((string)($email ?? $site->contact_email()->or('openartfolke@gmail.com')->value()));
if ($email === '') return;

$label ??= $site->copy_email_label()->or('Copy email address')->value();
?>
<div class="<?= esc(trim('copy-email ' . ($class ?? ''))) ?>">
  <?php snippet('button', [
    'label'    => $label,
    'variant'  => $variant ?? 'primary',
    'copy'     => $email,
    'announce' => 'Email address copied',
  ]) ?>
  <a class="copy-email__address" href="mailto:<?= esc($email, 'attr') ?>"><?= esc($email) ?></a>
</div>
