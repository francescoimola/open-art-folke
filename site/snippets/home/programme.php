<div id="programme" class="anchor-target" aria-hidden="true"></div>
<?php /* Programme section: toggled in the Panel (Home → Programme). Falls back to sign-up until a PDF is uploaded. */ ?>
<?php $programmePdf = $page->programmepdf()->toFile() ?>
<?php if ($page->programmemode()->value() === 'programme' && $programmePdf): ?>
  <?php snippet('programme-choice', ['pdf' => $programmePdf]) ?>
<?php else: ?>
  <?php snippet('programme-signup', ['form' => $form]) ?>
<?php endif ?>
