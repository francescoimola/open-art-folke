const signupCallout = document.querySelector('.callout.success, .callout.error');
if (signupCallout) {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  signupCallout.scrollIntoView({
    behavior: reduceMotion ? 'auto' : 'smooth',
    block: 'center',
  });
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
