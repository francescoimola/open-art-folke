import Lenis from 'lenis'

const lenis = new Lenis({
  autoRaf: true,
  lerp: 0.1,
  anchors: true,
  allowNestedScroll: true,
  smoothWheel: true,   
  syncTouch: false,    // smooth touch devices (can be unstable on iOS<16)
})
