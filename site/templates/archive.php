<?php snippet('header') ?>

<section class="panel even theme-brand stack-section half">
  <div class="stack gap-xl readable mt-xl">
    <h1><?= $page->headline()->esc() ?></h1>
    <div class="stack gap-l text-muted"><?= $page->intro()->kt() ?></div>
  </div>
</section>

<?php foreach ($page->editions()->toStructure() as $i => $edition): ?>
  <?php $photos = $edition->gallery()->toFiles() ?>
  <section id="edition-<?= $i ?>" class="panel even stack-section flowing <?= $i % 2 ? 'theme-paper' : 'theme-blush' ?>">
    <div class="stack gap-xl">
      <h2><?= $edition->headline()->esc() ?></h2>

      <?php if ($edition->video()->isNotEmpty()): ?>
        <div class="layout-split">
          <?php snippet('video', [
            'files'  => $edition->video()->toFiles(),
            'class'  => 'aspect-video',
            'poster' => $edition->poster()->toFile(),
          ]) ?>
        </div>
      <?php endif ?>

      <div class="stack gap-l readable"><?= $edition->text()->kt() ?></div>

      <?php if ($photos->count() > 2): ?>
        <ul class="carousel archive-carousel" tabindex="0" aria-label="<?= $edition->headline()->esc('attr') ?> photos">
          <?php foreach ($photos as $photo): ?>
            <li>
              <?php snippet('lightbox-image', [
                'file'    => $photo,
                'sizes'   => '(min-width: 768px) 28vw, 66vw',
                'closeTo' => '#edition-' . $i,
              ]) ?>
            </li>
          <?php endforeach ?>
        </ul>
      <?php elseif ($photos->isNotEmpty()): ?>
        <div class="layout-split">
          <?php foreach ($photos as $photo): ?>
            <?php snippet('image', [
              'file'  => $photo,
              'sizes' => '(min-width: 768px) 50vw, 100vw',
            ]) ?>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    </div>
  </section>
<?php endforeach ?>


<?php snippet('site-footer') ?>

