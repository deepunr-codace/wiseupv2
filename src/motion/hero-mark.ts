// Hero heading as real text (Lobster, set letter by letter; markup in index.astro, styles at the end of site.css).
//
//  - Entrance: the six letters drop in with a springy overshoot, staggered left to right.
//  - Idle: each letter floats on its own sine clock (a pixel or two, a fraction of a degree).
//  - Sweep: a glossy white band slides across the letters in turn every few seconds.
//  - Hover: the lime colour travels outward from the touched letter as a wave and fades back the same way; the
//    letter (and, less, its neighbours) springs up. The extruded depth follows the pointer (the light direction).
//  - Click: every letter hops in a staggered ripple. The whole word also tilts in 3D toward the pointer.
// Touch devices keep the entrance, idle and sweep; reduced motion shows the finished static word.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onPage, isTouch, prefersReducedMotion } from '../engine';

export function heroMark() {
  onPage(({ intro }) => {
    const mark = document.querySelector<HTMLElement>('[data-mark]');
    if (!mark) return;
    const L = gsap.utils.toArray<HTMLElement>('.mk__l', mark);
    const inner = L.map((l) => l.querySelector<HTMLElement>('.mk__in')!);
    const hov = L.map((l) => l.querySelector<HTMLElement>('.mk__h')!);
    const shine = L.map((l) => l.querySelector<HTMLElement>('.mk__s')!);
    if (prefersReducedMotion()) return;
    const fine = !isTouch();

    // entrance
    gsap.set(L, { yPercent: -90, rotation: (i) => (i % 2 ? 14 : -14), scale: 0.6, autoAlpha: 0, transformOrigin: '50% 80%' });
    const tl = gsap.timeline({ paused: true });
    tl.to(L, { yPercent: 0, rotation: 0, scale: 1, autoAlpha: 1, duration: 1.25, ease: 'elastic.out(1, 0.55)', stagger: 0.11 }, 0);
    intro.add(() => tl.play(), 0);

    // idle float + sweep (paused while the hero is off screen)
    const loops: gsap.core.Animation[] = [];
    L.forEach((l, i) => {
      loops.push(gsap.to(inner[i], { y: i % 2 ? -4 : 4, rotation: i % 2 ? 0.7 : -0.7, duration: 2.4 + i * 0.33, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: -i * 0.4 }));
    });
    const sweep = gsap.timeline({ repeat: -1, repeatDelay: 4.2, delay: 3.4 });
    sweep.fromTo(shine, { backgroundPositionX: '160%' }, { backgroundPositionX: '-60%', duration: 0.9, ease: 'power2.inOut', stagger: 0.13 }, 0);
    loops.push(sweep);
    const st = ScrollTrigger.create({ trigger: mark, start: 'top bottom', end: 'bottom top', onToggle: (s) => loops.forEach((a) => (s.isActive ? a.play() : a.pause())) });

    // interaction
    const hop = (from: number, power: number) => {
      inner.forEach((el, i) => {
        const near = Math.max(0, 1 - Math.abs(i - from) * 0.5);
        if (near > 0) gsap.fromTo(el, { yPercent: 0 }, { yPercent: -power * near, duration: 0.22, ease: 'power2.out', yoyo: true, repeat: 1, overwrite: false });
      });
    };
    const wave = (from: number, on: boolean) => {
      hov.forEach((h, i) => gsap.to(h, { opacity: on ? 1 : 0, duration: 0.35, delay: Math.abs(i - from) * (on ? 0.1 : 0.07), overwrite: 'auto' }));
    };
    let cleanup = () => {};
    if (fine) {
      gsap.set(mark, { transformPerspective: 1100, transformOrigin: '50% 60%' });
      const tiltX = gsap.quickTo(mark, 'rotationX', { duration: 0.7, ease: 'power3.out' });
      const tiltY = gsap.quickTo(mark, 'rotationY', { duration: 0.7, ease: 'power3.out' });
      const onMove = (e: PointerEvent) => {
        const r = mark.getBoundingClientRect();
        const nx = Math.max(-1.2, Math.min(1.2, ((e.clientX - r.left) / r.width - 0.5) * 2));
        const ny = Math.max(-1.2, Math.min(1.2, ((e.clientY - r.top) / r.height - 0.5) * 2));
        tiltY(nx * 9); tiltX(-ny * 6);
        // the extruded rim points away from the pointer
        mark.style.setProperty('--dx', (0.62 - nx * 0.5).toFixed(3));
        mark.style.setProperty('--dy', (0.78 - ny * 0.35).toFixed(3));
      };
      const onLeaveAll = () => { tiltX(0); tiltY(0); mark.style.setProperty('--dx', '0.62'); mark.style.setProperty('--dy', '0.78'); };
      const hovered = new Set<number>();
      const enter = L.map((l, i) => { const f = () => { hovered.add(i); wave(i, true); hop(i, 14); }; l.addEventListener('pointerenter', f); return f; });
      const leave = L.map((l, i) => { const f = () => { hovered.delete(i); if (!hovered.size) wave(i, false); }; l.addEventListener('pointerleave', f); return f; });
      const click = L.map((l) => { const f = () => L.forEach((_, j) => gsap.delayedCall(j * 0.07, () => hop(j, 26))); l.addEventListener('pointerdown', f); return f; });
      mark.addEventListener('pointermove', onMove);
      mark.addEventListener('pointerleave', onLeaveAll);
      cleanup = () => {
        mark.removeEventListener('pointermove', onMove); mark.removeEventListener('pointerleave', onLeaveAll);
        L.forEach((l, i) => { l.removeEventListener('pointerenter', enter[i]); l.removeEventListener('pointerleave', leave[i]); l.removeEventListener('pointerdown', click[i]); });
      };
    }

    return () => { cleanup(); st.kill(); tl.kill(); loops.forEach((a) => a.kill()); gsap.killTweensOf([...L, ...inner, ...hov, ...shine, mark]); };
  });
}
