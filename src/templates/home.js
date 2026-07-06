const signupCallout = document.querySelector('.callout.success, .callout.error');
if (signupCallout) {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  signupCallout.scrollIntoView({
    behavior: reduceMotion ? 'auto' : 'smooth',
    block: 'center',
  });
}

const typed = document.querySelector('.hero__typed');
const cursor = document.querySelector('.hero__cursor');

if (typed && cursor) {
  const words = [
    ' defies easy labels',
    ' is happening again in 2026 🎉',
    ', simply put, is your local art festival',
    ' paints the town red—literally',
    ' is art in unexpected places',
    ' puts on a big party for all art-lovers',
    ' is cross-generational and cross-cultural',
    ' is Folkestone',
  ];

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    // Static fallback — GSAP never downloaded.
    typed.textContent = words[0];
    cursor.style.visibility = 'hidden';
  } else {
    const startTypewriter = async () => {
      const [{ gsap }, { TextPlugin }] = await Promise.all([
        import('gsap'),
        import('gsap/TextPlugin'),
      ]);
      gsap.registerPlugin(TextPlugin);

      const blink = gsap.to(cursor, {
        opacity: 0,
        repeat: -1,
        yoyo: true,
        duration: 0.5,
        ease: 'power2.inOut',
      });

      const master = gsap.timeline({ repeat: -1 });
      words.forEach((word) => {
        // repeat: 1 + yoyo reverses the text tween → character-by-character delete
        const tl = gsap.timeline({ repeat: 1, yoyo: true, repeatDelay: 1.2 });
        tl.to(typed, {
          duration: Math.max(0.6, word.length * 0.06), // constant typing speed regardless of phrase length
          text: word,
          ease: 'none',
        });
        master.add(tl, '+=0.3');
      });

      /* The hero is pinned (later sections scroll over it); its box never leaves the viewport. "Past the hero" = scrolled beyond one viewport height. */
      /* Pause all work while covered; restart from the first word when it comes back into view. */
      let heroCovered = false;
      window.addEventListener('scroll', () => {
        const covered = window.scrollY >= window.innerHeight;
        if (covered === heroCovered) return;
        heroCovered = covered;
        if (covered) {
          master.pause();
          blink.pause();
        } else {
          master.restart();
          blink.play();
        }
      }, { passive: true });
    };

    /* Defer GSAP fetch and animation until after load, when browser is idle — keeps it out of the LCP/CLS window. */
    const whenIdle = (fn) =>
      'requestIdleCallback' in window
        ? requestIdleCallback(fn, { timeout: 2000 })
        : setTimeout(fn, 300);
    if (document.readyState === 'complete') {
      whenIdle(startTypewriter);
    } else {
      window.addEventListener('load', () => whenIdle(startTypewriter), { once: true });
    }
  }
}

const countdown = document.querySelector('.countdown');

if (countdown && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  countdown.classList.add('countdown--primed');

  new IntersectionObserver((entries, obs) => {
    if (entries[0].isIntersecting) {
      setTimeout(() => {
        countdown.classList.add('countdown--revealed');
      }, 400);
      obs.disconnect();
    }
  }, { threshold: 1.0 }).observe(countdown);
}
