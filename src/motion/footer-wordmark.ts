// Footer particles, two fields sharing one pointer and one ticker:
//  - the "wiseup" wordmark: brand particles that fly in from random spots the first time the footer comes into view,
//  - the dotted ground under it (.ft__ground): a grid of small dark dots, confined to that band.
// Both scatter away from the pointer (or a finger) and drift back into place.
//
// Wordmark: the invisible .ft__word-text sets the size and font; an offscreen canvas renders the word with the same
// computed font, a grid is sampled across it and each filled cell becomes a particle. Particles are bucketed into a
// small palette so each frame is one path + fill per colour per field, and drawing stops once everything has settled
// and the pointer is away. One clock: the gsap ticker, attached only while the footer is on screen.
// Reduced motion: both fields are drawn once, in place, with no interaction.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onPage, prefersReducedMotion } from '../engine';

const WORD = 'wiseup';
const TAU = Math.PI * 2;
const SHADES = 10;

type P = { x: number; y: number; bx: number; by: number; r: number; pull: number };
type Layout = { cw: number; ch: number; points: [number, number][]; radius: number; size: () => number };
type Pointer = { x: number; y: number; on: boolean };

// Wordmark. Dark theme: lime #BEDA52 (hue ~73) through to green (hue ~125). Light theme: black, in a spread of
// near-black shades so it keeps the same textured look.
const wordPalette = (light: boolean) => Array.from({ length: SHADES }, (_, k) => {
  if (light) return `hsl(0 0% ${4 + ((k * 23) % 24)}%)`;
  const f = k / (SHADES - 1);
  return `hsl(${(73 + f * 52).toFixed(0)} ${58 + ((k * 37) % 30)}% ${42 + ((k * 29) % 30)}%)`;
});
// Ground: neutral, quieter than the word. Charcoal on the black page, black-to-grey on white.
const groundPalette = (light: boolean) => Array.from({ length: SHADES }, (_, k) =>
  `hsl(0 0% ${light ? 12 + ((k * 23) % 32) : 13 + ((k * 23) % 14)}%)`);

function field(canvas: HTMLCanvasElement, layout: () => Layout, palette: (light: boolean) => string[], DPR: number) {
  const ctx = canvas.getContext('2d')!;
  let buckets: P[][] = [];
  let all: P[] = [];
  let colors: string[] = [];
  let cw = 0, ch = 0, radius = 100;

  return {
    build(intro: boolean) {
      const L = layout();
      ({ cw, ch, radius } = L);
      canvas.width = cw * DPR;
      canvas.height = ch * DPR;
      buckets = Array.from({ length: SHADES }, () => []);
      all = [];
      for (const [x, y] of L.points) {
        const p: P = { bx: x, by: y, x: intro ? Math.random() * cw : x, y: intro ? Math.random() * ch : y, r: L.size(), pull: 2 + Math.random() * 18 };
        buckets[(Math.random() * SHADES) | 0].push(p);
        all.push(p);
      }
    },
    recolor(light: boolean) { colors = palette(light); },
    draw() {
      ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
      ctx.clearRect(0, 0, cw, ch);
      for (let k = 0; k < SHADES; k++) {
        ctx.fillStyle = colors[k];
        ctx.beginPath();
        for (const p of buckets[k]) { ctx.moveTo(p.x + p.r, p.y); ctx.arc(p.x, p.y, p.r, 0, TAU); }
        ctx.fill();
      }
    },
    // Advances every particle against the pointer (client coords); returns whether anything is still moving.
    step(dt: number, ptr: Pointer) {
      const rect = canvas.getBoundingClientRect();
      const px = ptr.x - rect.left, py = ptr.y - rect.top;
      const near = ptr.on && px > -radius && px < cw + radius && py > -radius && py < ch + radius;
      const ease = 1 - Math.pow(0.9, dt);
      let moving = false;
      for (const p of all) {
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
    },
    clear() { ctx.clearRect(0, 0, canvas.width, canvas.height); },
  };
}

export function footerWordmark() {
  onPage(() => {
    const wrap = document.querySelector<HTMLElement>('[data-ft-word]');
    const wordCanvas = wrap?.querySelector('canvas');
    const text = wrap?.querySelector<HTMLElement>('.ft__word-text');
    const ground = document.querySelector<HTMLElement>('[data-ft-ground]');
    const groundCanvas = ground?.querySelector('canvas');
    if (!wrap || !wordCanvas || !text || !ground || !groundCanvas) return;
    const reduced = prefersReducedMotion();
    const DPR = Math.min(devicePixelRatio || 1, 2);
    const isLight = () => document.documentElement.dataset.theme === 'light';

    // The word sits on the divider line (the top edge of .ft__ground, directly under this box): the box is sized to
    // the letters' height above the baseline, and the canvas runs past its bottom by the descender so only the tail
    // of the "p" drops below the line.
    const word = field(wordCanvas, () => {
      const cs = getComputedStyle(text);
      const size = parseFloat(cs.fontSize);
      const font = `${cs.fontWeight} ${size}px ${cs.fontFamily}`;
      const probe = document.createElement('canvas').getContext('2d')!;
      probe.font = font;
      const m = probe.measureText(WORD);
      const base = Math.ceil(m.actualBoundingBoxAscent + size * 0.04);
      wrap.style.height = `${base}px`;
      const cw = Math.max(1, Math.round(wrap.clientWidth));
      const ch = base + Math.ceil(m.actualBoundingBoxDescent) + 4;
      wordCanvas.style.height = `${ch}px`;
      const mobile = cw < 768;
      const gap = mobile ? 4 : 5;

      const off = document.createElement('canvas');
      off.width = cw; off.height = ch;
      const o = off.getContext('2d', { willReadFrequently: true })!;
      o.font = font;
      if ('letterSpacing' in o) (o as CanvasRenderingContext2D & { letterSpacing: string }).letterSpacing = cs.letterSpacing;
      o.fillStyle = '#fff';
      o.textAlign = 'center';
      o.textBaseline = 'alphabetic';
      o.fillText(WORD, cw / 2, base - 2);
      const px = o.getImageData(0, 0, cw, ch).data;
      const points: [number, number][] = [];
      for (let y = 0; y < ch; y += gap) for (let x = 0; x < cw; x += gap) if (px[(y * cw + x) * 4 + 3] >= 128) points.push([x, y]);
      return { cw, ch, points, radius: mobile ? 50 : 110, size: () => (gap / 5) * (0.8 + Math.random() * 1.2) };
    }, wordPalette, DPR);

    // The ground: a dot grid filling the band, the same 6px pitch as its CSS fallback dots.
    const groundField = field(groundCanvas, () => {
      const cw = Math.max(1, Math.round(ground.clientWidth));
      const ch = Math.max(1, Math.round(ground.clientHeight));
      const gap = 6;
      const points: [number, number][] = [];
      for (let y = gap / 2; y < ch; y += gap) for (let x = gap / 2; x < cw; x += gap) points.push([x, y]);
      return { cw, ch, points, radius: cw < 768 ? 40 : 80, size: () => 0.7 + Math.random() * 0.8 };
    }, groundPalette, DPR);

    const fields = [word, groundField];
    let dirty = true;
    let alive = true;
    const recolor = () => { fields.forEach((f) => f.recolor(isLight())); dirty = true; };
    const drawAll = () => { fields.forEach((f) => f.draw()); dirty = false; };
    recolor();

    const onTheme = new MutationObserver(() => { recolor(); if (reduced) drawAll(); });
    onTheme.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    const onResize = () => { fields.forEach((f) => f.build(false)); dirty = true; if (reduced) drawAll(); };
    addEventListener('resize', onResize);

    const cleanup: (() => void)[] = [() => {
      alive = false; onTheme.disconnect(); removeEventListener('resize', onResize);
      ground.classList.remove('is-live');
      wrap.style.removeProperty('height'); wordCanvas.style.removeProperty('height');
      fields.forEach((f) => f.clear());
    }];

    // Sample only once the self-hosted font is ready, or the word would trace the fallback font.
    const font = getComputedStyle(text);
    const ready = document.fonts?.load(`${font.fontWeight} ${font.fontSize} ${font.fontFamily}`) ?? Promise.resolve();
    ready.catch(() => {}).then(() => {
      if (!alive) return;
      word.build(!reduced);
      groundField.build(false); // starts on its grid, so it takes over from the CSS dots without a visible change
      ground.classList.add('is-live');
      drawAll();
      if (reduced) return;

      const ptr: Pointer = { x: -1e4, y: -1e4, on: false };
      const move = (e: { clientX: number; clientY: number }) => { ptr.x = e.clientX; ptr.y = e.clientY; ptr.on = true; };
      // A touch that starts scrolling cancels its pointer events, so follow the finger through touchmove as well.
      const touch = (e: TouchEvent) => { const t = e.touches[0]; if (t) move(t); };
      const away = () => { ptr.on = false; };
      // Each field redraws only while its own particles move (or after a theme/size change).
      const tick = () => {
        const dt = Math.min(gsap.ticker.deltaRatio(60), 3);
        if (dirty) { fields.forEach((f) => f.step(dt, ptr)); drawAll(); return; }
        for (const f of fields) if (f.step(dt, ptr)) f.draw();
      };
      const st = ScrollTrigger.create({
        trigger: wrap, endTrigger: ground, start: 'top bottom', end: 'bottom top',
        onToggle: (s) => {
          if (s.isActive) { gsap.ticker.add(tick); addEventListener('pointermove', move, { passive: true }); addEventListener('touchmove', touch, { passive: true }); }
          else { gsap.ticker.remove(tick); removeEventListener('pointermove', move); removeEventListener('touchmove', touch); away(); }
        },
      });
      document.addEventListener('pointerleave', away);
      addEventListener('touchend', away);
      cleanup.push(() => {
        st.kill(); gsap.ticker.remove(tick);
        removeEventListener('pointermove', move); removeEventListener('touchmove', touch);
        document.removeEventListener('pointerleave', away); removeEventListener('touchend', away);
      });
    });

    return () => cleanup.forEach((f) => f());
  });
}
