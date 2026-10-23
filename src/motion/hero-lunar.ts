// Hero entrance in the Lunar template's style: the wordmark fades up from 80% scale, the subtitle rises from 100px below,
// and (in main.ts heroStrip) the tilted strip rises in. cursorDot() adds the template's mint dot that trails the pointer.
import { gsap } from 'gsap';
import { onPage, isTouch, prefersReducedMotion } from '../engine';

export function heroLunar() {
  onPage(({ intro }) => {
    const mark = document.querySelector<HTMLElement>('[data-lunar-mark]');
    const sub = document.querySelector<HTMLElement>('[data-lunar-sub]');
    if (!mark || prefersReducedMotion()) return;
    const letters = Array.from(mark.querySelectorAll<SVGPathElement>('.wm__l'));
    const dot = mark.querySelector<SVGCircleElement>('.wm__dot');
    // entrance: the word scales up (the template's move) while the letters rise out of a blur one after another,
    // then the i-dot drops in and bounces into place
    intro.fromTo(mark, { scale: 0.8, autoAlpha: 0, transformOrigin: '50% 50%' }, { scale: 1, autoAlpha: 1, duration: 1.5, ease: 'expo.out' }, 0.1);
    if (letters.length) intro.from(letters, { yPercent: 38, opacity: 0, filter: 'blur(14px)', duration: 1.1, ease: 'expo.out', stagger: 0.07 }, 0.1);
    if (dot) intro.from(dot, { y: -260, scale: 0.4, opacity: 0, duration: 1.1, ease: 'bounce.out' }, 0.75);

    // pointer: the word tilts a little toward it in 3D, letters near the pointer lift, and the dot leans toward it
    let off = () => {};
    if (!isTouch() && letters.length) {
      gsap.set(mark, { transformPerspective: 1200 });
      const rx = gsap.quickTo(mark, 'rotationX', { duration: 0.9, ease: 'power3.out' });
      const ry = gsap.quickTo(mark, 'rotationY', { duration: 0.9, ease: 'power3.out' });
      const lifts = letters.map((l) => gsap.quickTo(l, 'y', { duration: 0.5, ease: 'power3.out' }));
      const dx = dot ? gsap.quickTo(dot, 'x', { duration: 0.8, ease: 'power3.out' }) : null;
      const dy = dot ? gsap.quickTo(dot, 'y', { duration: 0.8, ease: 'power3.out' }) : null;
      const move = (e: PointerEvent) => {
        const r = mark.getBoundingClientRect();
        const nx = (e.clientX - r.left) / r.width - 0.5, ny = (e.clientY - r.top) / r.height - 0.5;
        const near = Math.abs(ny) < 0.9 && Math.abs(nx) < 0.65;
        ry(near ? nx * 8 : 0); rx(near ? -ny * 6 : 0);
        letters.forEach((l, i) => {
          const b = l.getBoundingClientRect();
          const d = Math.hypot(e.clientX - (b.left + b.width / 2), e.clientY - (b.top + b.height / 2));
          lifts[i](near ? -Math.max(0, 1 - d / 260) * 14 : 0);
        });
        if (dx && dy) { dx(near ? nx * 18 : 0); dy(near ? ny * 12 : 0); }
      };
      addEventListener('pointermove', move, { passive: true });
      off = () => removeEventListener('pointermove', move);
    }
    if (sub) intro.fromTo(sub, { y: 100, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 1.3, ease: 'expo.out' }, 0.35);
    return () => { off(); gsap.killTweensOf([mark, sub]); };
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
