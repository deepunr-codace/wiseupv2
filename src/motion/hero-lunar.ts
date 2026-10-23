// Hero entrance in the Lunar template's style: the wordmark fades up from 80% scale, the subtitle rises from 100px below,
// and (in main.ts heroStrip) the tilted strip rises in. cursorDot() adds the template's mint dot that trails the pointer.
import { gsap } from 'gsap';
import { onPage, isTouch, prefersReducedMotion } from '../engine';

export function heroLunar() {
  onPage(({ intro }) => {
    const mark = document.querySelector<HTMLElement>('[data-lunar-mark]');
    const sub = document.querySelector<HTMLElement>('[data-lunar-sub]');
    if (!mark || prefersReducedMotion()) return;
    intro.fromTo(mark, { scale: 0.8, autoAlpha: 0, transformOrigin: '50% 50%' }, { scale: 1, autoAlpha: 1, duration: 1.5, ease: 'expo.out' }, 0.1);
    if (sub) intro.fromTo(sub, { y: 100, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 1.3, ease: 'expo.out' }, 0.35);
    return () => { gsap.killTweensOf([mark, sub]); };
  });
}

export function cursorDot() {
  if (isTouch() || prefersReducedMotion()) return;
  const dot = document.createElement('div');
  dot.className = 'cursor-dot';
  dot.setAttribute('aria-hidden', 'true');
  document.body.appendChild(dot);
  gsap.set(dot, { x: innerWidth / 2, y: innerHeight / 2 });
  const qx = gsap.quickTo(dot, 'x', { duration: 0.6, ease: 'power3.out' });
  const qy = gsap.quickTo(dot, 'y', { duration: 0.6, ease: 'power3.out' });
  addEventListener('pointermove', (e) => { qx(e.clientX); qy(e.clientY); }, { passive: true });
}
