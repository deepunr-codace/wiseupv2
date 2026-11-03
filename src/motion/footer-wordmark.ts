// Footer wordmark: the "wiseup" word as interactive particles on a canvas. The dots fly in from random spots the first
// time the footer comes into view, scatter away from the pointer (or a finger) and drift back into place.
//
// The invisible .ft__word-text sets the size and font; an offscreen canvas renders the word with the same computed font,
// a grid is sampled across it and each filled cell becomes a particle. Particles are bucketed into a small palette so each
// frame is one path + fill per colour, and drawing stops once everything has settled and the pointer is away. One clock:
// the gsap ticker, attached only while the footer is on screen. Reduced motion: the word is drawn once, in place.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onPage, prefersReducedMotion } from '../engine';

const WORD = 'wiseup';
const TAU = Math.PI * 2;
const SHADES = 10;

type P = { x: number; y: number; bx: number; by: number; r: number; pull: number };
type Pointer = { x: number; y: number; on: boolean };

// Dark theme: lime #BEDA52 (hue ~73) through to green (hue ~125). Light theme: near-black shades.
const wordPalette = (light: boolean) => Array.from({ length: SHADES }, (_, k) => {
  if (light) return `hsl(0 0% ${4 + ((k * 23) % 24)}%)`;
  const f = k / (SHADES - 1);
  return `hsl(${(73 + f * 52).toFixed(0)} ${58 + ((k * 37) % 30)}% ${42 + ((k * 29) % 30)}%)`;
});

export function footerWordmark() {
  onPage(() => {
    const wrap = document.querySelector<HTMLElement>('[data-ft-word]');
    const canvas = wrap?.querySelector('canvas');
    const text = wrap?.querySelector<HTMLElement>('.ft__word-text');
    if (!wrap || !canvas || !text) return;
    const ctx = canvas.getContext('2d')!;
    const reduced = prefersReducedMotion();
    const DPR = Math.min(devicePixelRatio || 1, 2);
    const isLight = () => document.documentElement.dataset.theme === 'light';

    let particles: P[] = [];
    let buckets: P[][] = [];
    let colors: string[] = [];
    let cw = 0, ch = 0, radius = 100;
    let dirty = true;
    let alive = true;

    // The word sits on the box's baseline; the canvas runs past the box by the descender so the "p" tail is not clipped.
    const build = (intro: boolean) => {
      const cs = getComputedStyle(text);
      const size = parseFloat(cs.fontSize);
      const font = `${cs.fontWeight} ${size}px ${cs.fontFamily}`;
      const probe = document.createElement('canvas').getContext('2d')!;
      probe.font = font;
      const m = probe.measureText(WORD);
      const base = Math.ceil(m.actualBoundingBoxAscent + size * 0.04);
      wrap.style.height = `${base}px`;
      cw = Math.max(1, Math.round(wrap.clientWidth));
      ch = base + Math.ceil(m.actualBoundingBoxDescent) + 4;
      canvas.style.height = `${ch}px`;
      canvas.width = cw * DPR;
      canvas.height = ch * DPR;

      const mobile = cw < 768;
      const gap = mobile ? 4 : 5;
      radius = mobile ? 50 : 110;
      const off = document.createElement('canvas');
      off.width = cw;
      off.height = ch;
      const o = off.getContext('2d', { willReadFrequently: true })!;
      o.font = font;
      if ('letterSpacing' in o) (o as CanvasRenderingContext2D & { letterSpacing: string }).letterSpacing = cs.letterSpacing;
      o.fillStyle = '#fff';
      o.textAlign = 'center';
      o.textBaseline = 'alphabetic';
      o.fillText(WORD, cw / 2, base - 2);
      const px = o.getImageData(0, 0, cw, ch).data;

      buckets = Array.from({ length: SHADES }, () => []);
      particles = [];
      for (let y = 0; y < ch; y += gap) {
        for (let x = 0; x < cw; x += gap) {
          if (px[(y * cw + x) * 4 + 3] < 128) continue;
          const p: P = {
            bx: x, by: y,
            x: intro ? Math.random() * cw : x,
            y: intro ? Math.random() * ch : y,
            r: (gap / 5) * (0.8 + Math.random() * 1.2),
            pull: 2 + Math.random() * 18,
          };
          buckets[(Math.random() * SHADES) | 0].push(p);
          particles.push(p);
        }
      }
      colors = wordPalette(isLight());
      dirty = true;
    };

    const draw = () => {
      ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
      ctx.clearRect(0, 0, cw, ch);
      for (let k = 0; k < SHADES; k++) {
        ctx.fillStyle = colors[k];
        ctx.beginPath();
        for (const p of buckets[k]) { ctx.moveTo(p.x + p.r, p.y); ctx.arc(p.x, p.y, p.r, 0, TAU); }
        ctx.fill();
      }
      dirty = false;
    };

    // Advances every particle against the pointer (client coords); returns whether anything is still moving.
    const step = (dt: number, ptr: Pointer) => {
      const rect = canvas.getBoundingClientRect();
      const px = ptr.x - rect.left, py = ptr.y - rect.top;
      const near = ptr.on && px > -radius && px < cw + radius && py > -radius && py < ch + radius;
      const ease = 1 - Math.pow(0.9, dt);
      let moving = false;
      for (const p of particles) {
        const dx = px - p.x, dy = py - p.y;
        const d = near ? Math.hypot(dx, dy) : Infinity;
        if (d < radius && d > 0.01) {
          const f = ((radius - d) / radius) * p.pull * dt;
          p.x -= (dx / d) * f;
          p.y -= (dy / d) * f;
          moving = true;
        } else {
          const ex = p.bx - p.x, ey = p.by - p.y;
          if (Math.abs(ex) > 0.05 || Math.abs(ey) > 0.05) { p.x += ex * ease; p.y += ey * ease; moving = true; }
          else { p.x = p.bx; p.y = p.by; }
        }
      }
      return moving;
    };

    build(false);
    draw();

    const onTheme = new MutationObserver(() => {
      colors = wordPalette(isLight());
      dirty = true;
      if (reduced) draw();
    });
    onTheme.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    const onResize = () => { build(false); if (reduced) draw(); };
    addEventListener('resize', onResize);

    const cleanups: (() => void)[] = [() => {
      alive = false;
      onTheme.disconnect();
      removeEventListener('resize', onResize);
      wrap.style.removeProperty('height');
      canvas.style.removeProperty('height');
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }];

    // Sample only once the self-hosted font is ready, or the word would trace the fallback font.
    const font = getComputedStyle(text);
    const ready = document.fonts?.load(`${font.fontWeight} ${font.fontSize} ${font.fontFamily}`) ?? Promise.resolve();
    ready.catch(() => {}).then(() => {
      if (!alive) return;
      build(!reduced);
      draw();
      if (reduced) return;

      const ptr: Pointer = { x: -1e4, y: -1e4, on: false };
      const move = (e: { clientX: number; clientY: number }) => { ptr.x = e.clientX; ptr.y = e.clientY; ptr.on = true; };
      // A touch that starts scrolling cancels its pointer events, so follow the finger through touchmove as well.
      const touch = (e: TouchEvent) => { const t = e.touches[0]; if (t) move(t); };
      const away = () => { ptr.on = false; };
      const tick = () => {
        const dt = Math.min(gsap.ticker.deltaRatio(60), 3);
        if (dirty) { step(dt, ptr); draw(); return; }
        if (step(dt, ptr)) draw();
      };
      const st = ScrollTrigger.create({
        trigger: wrap, start: 'top bottom', end: 'bottom top',
        onToggle: (s) => {
          if (s.isActive) { gsap.ticker.add(tick); addEventListener('pointermove', move, { passive: true }); addEventListener('touchmove', touch, { passive: true }); }
          else { gsap.ticker.remove(tick); removeEventListener('pointermove', move); removeEventListener('touchmove', touch); away(); }
        },
      });
      document.addEventListener('pointerleave', away);
      addEventListener('touchend', away);
      cleanups.push(() => {
        st.kill();
        gsap.ticker.remove(tick);
        removeEventListener('pointermove', move);
        removeEventListener('touchmove', touch);
        document.removeEventListener('pointerleave', away);
        removeEventListener('touchend', away);
      });
    });

    return () => cleanups.forEach((f) => f());
  });
}
