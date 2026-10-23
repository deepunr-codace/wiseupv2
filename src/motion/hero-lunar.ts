// Hero entrance in the Lunar template's style: the wordmark fades up from 80% scale, the subtitle rises from
// 100px below, and (in main.ts heroStrip) the tilted strip slides in. The wordmark itself is plain gradient text
// (styles: .lunar* at the end of site.css), so it stays crisp at any size and follows the theme.
import { gsap } from 'gsap';
import { onPage, prefersReducedMotion } from '../engine';

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
