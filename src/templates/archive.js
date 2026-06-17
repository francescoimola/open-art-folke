// Archive carousel arrows — progressive enhancement.
//
// The .archive-carousel scrolls natively (swipe / trackpad / arrow keys). This
// adds clickable prev/next buttons that work in every browser, replacing the
// Chrome-only CSS ::scroll-button() pseudo-element. No JS → no buttons, but the
// carousel still scrolls. Styles live in src/_components.scss (.carousel-arrow).

const makeButton = (dir, label, glyph) => {
  const button = document.createElement('button');
  button.type = 'button';
  // `minimal` opts the button out of Graffiti's primary-button rule
  // (button:not(.minimal) { color: … }) so .carousel-arrow's colours win.
  button.className = `carousel-arrow minimal carousel-arrow--${dir}`;
  button.setAttribute('aria-label', label);
  const icon = document.createElement('span');
  icon.setAttribute('aria-hidden', 'true');
  icon.textContent = glyph;
  button.append(icon);
  return button;
};

document.querySelectorAll('.archive-carousel').forEach((scroller) => {
  // Wrap the scroller so the absolutely-positioned arrows anchor to it.
  const wrap = document.createElement('div');
  wrap.className = 'carousel-wrap';
  scroller.before(wrap);
  wrap.append(scroller);

  const prev = makeButton('prev', 'Scroll left', '←');
  const next = makeButton('next', 'Scroll right', '→');
  wrap.append(prev, next);

  const step = () => Math.round(scroller.clientWidth * 0.8);
  prev.addEventListener('click', () => scroller.scrollBy({ left: -step(), behavior: 'smooth' }));
  next.addEventListener('click', () => scroller.scrollBy({ left: step(), behavior: 'smooth' }));

  // Dim each arrow once you can't scroll further that way.
  const update = () => {
    const max = scroller.scrollWidth - scroller.clientWidth - 1;
    prev.disabled = scroller.scrollLeft <= 0;
    next.disabled = scroller.scrollLeft >= max;
  };

  scroller.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
  update();
});
