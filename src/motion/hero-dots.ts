// Hero heading, "Glowing Dot Typography": the wordmark rendered as a halftone grid of dots,
// each one a soft neon point in the brand lime (#BEDA52), gently pulsing out of phase with its
// neighbours so the whole word reads as a living neon sign rather than a static dot-matrix print.
//
// How it's built: an offscreen canvas renders the plain word in a bold sans at the element's own
// size, then a grid is sampled across it — every grid cell that lands on filled (opaque) pixels
// becomes one dot. The visible canvas never touches the real letterforms at draw time, only this
// pre-sampled dot list, so the per-frame cost is just drawing N small radial-gradient glows.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onPage, prefersReducedMotion } from '../engine';

const WORD = 'WiseUp';
const COLOR = '190, 218, 82'; // #BEDA52 as r,g,b for rgba() strings
const GAP = 10; // grid spacing, css px — wider than the dot/glow radius so neighbours stay
                 // visually distinct points instead of merging into one soft wash
const DOT_R = 2.3;

type Dot = { x: number; y: number; r: number; seed: number; speed: number };

export function heroDots() {
  onPage(() => {
    const canvas = document.querySelector<HTMLCanvasElement>('[data-hero-dots]');
    const ctx = canvas?.getContext('2d');
    const wrap = canvas?.parentElement;
    if (!canvas || !ctx || !wrap) return;
    const reduced = prefersReducedMotion();
    const DPR = Math.min(devicePixelRatio || 1, 2);

    let dots: Dot[] = [];
    let cw = 0, ch = 0;

    const build = () => {
      const rect = wrap.getBoundingClientRect();
      cw = Math.max(1, Math.round(rect.width));
      ch = Math.max(1, Math.round(rect.height));
      canvas.width = cw * DPR;
      canvas.height = ch * DPR;
      canvas.style.width = `${cw}px`;
      canvas.style.height = `${ch}px`;

      const off = document.createElement('canvas');
      off.width = cw; off.height = ch;
      const octx = off.getContext('2d')!;
      // Fit to both dimensions, not just height: on a narrow/short box (mobile, where .hero__art's
      // fixed aspect-ratio gives a shorter box than the word's own width needs) a height-only size
      // overflowed past the canvas edge and the word got clipped. Capped well under the full box
      // on both axes — at 0.92/0.6 the word read as oversized, crowding the header on wide screens.
      let fontSize = Math.min(ch * 0.5, 210);
      octx.font = `800 ${fontSize}px "Outfit", system-ui, sans-serif`;
      const textW = octx.measureText(WORD).width;
      const maxW = cw * 0.74;
      if (textW > maxW) fontSize *= maxW / textW;
      octx.font = `800 ${fontSize}px "Outfit", system-ui, sans-serif`;
      octx.fillStyle = '#fff';
      octx.textAlign = 'center';
      octx.textBaseline = 'middle';
      octx.fillText(WORD, cw / 2, ch * 0.52);
      const img = octx.getImageData(0, 0, cw, ch).data;

      dots = [];
      for (let y = GAP / 2; y < ch; y += GAP) {
        for (let x = GAP / 2; x < cw; x += GAP) {
          const i = (Math.floor(y) * cw + Math.floor(x)) * 4;
          if (img[i + 3] > 128) {
            dots.push({
              x, y,
              r: DOT_R * (0.75 + Math.random() * 0.5),
              seed: Math.random() * Math.PI * 2,
              speed: 0.8 + Math.random() * 0.8,
            });
          }
        }
      }
    };

    const draw = (t: number) => {
      ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
      ctx.clearRect(0, 0, cw, ch);
      // Glow pass first, 'lighter' so overlapping halos brighten instead of just averaging into a
      // flat haze, and capped to ~2x the dot radius (was 5.5x) so each glow stays local to its own
      // dot rather than bleeding across the GAP into neighbours — that bleed was what read as
      // "blurred" rather than individually glowing points.
      ctx.globalCompositeOperation = 'lighter';
      for (const d of dots) {
        const pulse = reduced ? 1 : 0.55 + 0.45 * Math.sin(t * d.speed + d.seed);
        const r = d.r * (0.82 + 0.3 * pulse);
        const glowR = r * 3.2;
        const g = ctx.createRadialGradient(d.x, d.y, 0, d.x, d.y, glowR);
        g.addColorStop(0, `rgba(${COLOR}, ${0.55 * pulse})`);
        g.addColorStop(1, `rgba(${COLOR}, 0)`);
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(d.x, d.y, glowR, 0, Math.PI * 2);
        ctx.fill();
      }
      // Solid core pass, normal compositing so each dot stays a crisp, fully-opaque point on top
      // of its own glow rather than additively blowing out to white.
      ctx.globalCompositeOperation = 'source-over';
      for (const d of dots) {
        const pulse = reduced ? 1 : 0.55 + 0.45 * Math.sin(t * d.speed + d.seed);
        const r = d.r * (0.82 + 0.3 * pulse);
        ctx.fillStyle = `rgba(${COLOR}, ${Math.min(1, 0.75 + 0.25 * pulse)})`;
        ctx.beginPath();
        ctx.arc(d.x, d.y, r, 0, Math.PI * 2);
        ctx.fill();
      }
    };

    build();
    draw(0);
    const onResize = () => { build(); draw(0); };
    addEventListener('resize', onResize);
    if (reduced) return () => removeEventListener('resize', onResize);

    let t = 0;
    const tick = () => { t += gsap.ticker.deltaRatio(60) / 60; draw(t); };
    const st = ScrollTrigger.create({
      trigger: wrap, start: 'top bottom', end: 'bottom top',
      onToggle: (s) => (s.isActive ? gsap.ticker.add(tick) : gsap.ticker.remove(tick)),
    });
    return () => { st.kill(); gsap.ticker.remove(tick); removeEventListener('resize', onResize); };
  });
}
