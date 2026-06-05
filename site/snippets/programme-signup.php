<section class="theme-crimson stack-section layout-split">
  <?php snippet('image', [
    'file' => $page->programmeimage()->toFile(),
    'class' => 'image-cover',
    'hidden' => true,
    'sizes' => '(min-width: 768px) 50vw, 100vw',
  ]) ?>
  <div class="panel even split fc vertical gap-l">
    <h2>Looking for the Festival Programme?<br><span class="text-muted">You’re early</span>
    </h2>
    <div class="stack fc readable gap-m pretty">
      <p class="fs-s">We'll release the programme in the weeks leading up to the opening. Leave us your email and we'll tell you all about it* as soon as we can.</p>
      <div class="stack mt-l">
        <label for="actions-email">Email</label>
        <form class="input-group gap-s">
          <input type="email" id="actions-email" placeholder="you@example.com"/>
          <button class="btt--secondary" type="submit">Keep me posted</button>
        </form>
      </div>
    </div>
    <small class="mt-s">*Spam? We want nothing to do with him either—and we'll never send you unsolicited communications.</small>
  </div>
</section>
