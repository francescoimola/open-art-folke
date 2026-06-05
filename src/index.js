import Lenis from 'lenis'

const lenis = new Lenis({
  autoRaf: true,
  duration: 1.2,
  anchors: true,
  allowNestedScroll: true,
  smoothWheel: true,   
  syncTouch: false,    // smooth touch devices (can be unstable on iOS<16)
})
