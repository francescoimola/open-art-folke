<section class="theme-paper stack-section layout-split">
  <div class="split vertical panel even gap-l">
    <div class="stack readable gap-xl">
      <h2>
        <span class="text-muted">Open Art Folke</span><br>The Festival</h2>
      <div class="stack gap-m">
        <p>A free pass* to connect with talented local creatives, experience their work, and learn about how it’s made.</p>
        <p>Find great art waiting to be discovered in studios, gardens, pubs, cafes, galleries, and upstairs in that shop you didn't even know had an upstairs.</p>
      </div>
      <?php $festivalButtons = $page->festivalButtons() ?>
      <?php if ($festivalButtons->isNotEmpty()): ?>
        <div class="stack">
          <?php foreach ($festivalButtons->values() as $i => $button): ?>
            <?php snippet('festival-button', ['button' => $button, 'secondary' => $i > 0]) ?>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    </div>
    <small class="mt-s">* Open Art is 99% free to attend, but some events require a paid reservation</small>
  </div>
  <?php snippet('image', [
    'file' => $page->festivalimage()->toFile(),
    'class' => 'image-cover',
    'hidden' => true,
    'sizes' => '(min-width: 768px) 50vw, 100vw',
  ]) ?>
</section>
