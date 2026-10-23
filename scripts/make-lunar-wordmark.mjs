// Builds the hero wordmark SVG in the Lunar template's style (reference: hero-lunar-logo-big.svg): one outlined compound
// path, cap height 225 units, fill = horizontal gradient white -> #999999.
// Font: Syne (Google Fonts, OFL) at weight 470, cut from the variable font. The reference "Lunar" logo is Syne: its L, u
// and n overlap Syne 470 at 96% / 87% / 87% per pixel (its a and r are custom-drawn, but WiseUp uses neither), and its
// letters are set ~24 units tighter than Syne's default spacing at this size, i.e. tracking -0.069em.
// Set in lowercase ("wiseup"), so its u is the very letter the reference uses; the letter size and baseline are the
// reference's (cap height 225, so the x-height matches the Lunar logo's lowercase).
// Usage: node scripts/make-lunar-wordmark.mjs   (needs opentype.js: npm i --no-save opentype.js)
import * as ot from 'opentype.js';
import fs from 'node:fs';
const opentype = ot.default ?? ot;

const FONT = new URL('./fonts/Syne-wght470.ttf', import.meta.url);
const TEXT = 'wiseup';
const TRACK = -0.069; // em
const CAP = 225;
const OUT = new URL('../public/brand/hero-wiseup-lunar-logo-big.svg', import.meta.url);

const load = (u) => { const b = fs.readFileSync(u); return opentype.parse(b.buffer.slice(b.byteOffset, b.byteOffset + b.byteLength)); };
const font = load(FONT);
// The w is narrowed (its top legs closer together): drawn from the weight-540 instance and squeezed to W_SCALE, so its
// diagonals end up as thick as the other strokes.
const fontW = load(new URL('./fonts/Syne-wght540.ttf', import.meta.url));
const W_SCALE = 0.82;
const capUnits = -font.charToGlyph('L').getPath(0, 0, font.unitsPerEm).getBoundingBox().y1;
const size = (CAP / capUnits) * font.unitsPerEm;
const k = size / font.unitsPerEm;

// collect commands in absolute coords, then shift to the ink bbox
const cmds = [];
let letter = 0;
const add = (path, fx = (x) => x) => path.commands.forEach((c) => {
  const o = { type: c.type, g: letter };
  for (const [kx, ky] of [['x', 'y'], ['x1', 'y1'], ['x2', 'y2']]) if (kx in c) { o[kx] = fx(c[kx]); o[ky] = c[ky]; }
  cmds.push(o);
});
let x = 0;
const glyphs = font.stringToGlyphs(TEXT);
// The i's square tittle is replaced by a round dot: a circle 1.35x the stem width, centred over the stem, at the same height.
let dotCircle = null;
const roundDot = (path) => {
  const contours = [];
  path.commands.forEach((c) => { if (c.type === 'M') contours.push([]); contours[contours.length - 1].push(c); });
  const box = (cs) => { const xs = cs.filter((c) => 'x' in c).map((c) => c.x), ys = cs.filter((c) => 'y' in c).map((c) => c.y);
    return { x1: Math.min(...xs), x2: Math.max(...xs), y1: Math.min(...ys), y2: Math.max(...ys) }; };
  const boxes = contours.map(box);
  const di = boxes.reduce((b, bb, i) => (bb.y1 < boxes[b].y1 ? i : b), 0);
  const stem = boxes[di === 0 ? 1 : 0], dot = boxes[di];
  const cx = (stem.x1 + stem.x2) / 2, cy = (dot.y1 + dot.y2) / 2, r = ((stem.x2 - stem.x1) * 1.35) / 2, q = r * 0.5523;
  dotCircle = { cx, cy, r };
  contours.splice(di, 1);
  path.commands = contours.flat();
  return path;
};
glyphs.forEach((g, i) => {
  const gp = g.getPath(x, 0, size);
  letter = i;
  if (TEXT[i] === 'w') {
    const wp = fontW.charToGlyph('w').getPath(0, 0, size), wb = wp.getBoundingBox();
    const lsb = gp.getBoundingBox().x1, rsb = x + g.advanceWidth * k - gp.getBoundingBox().x2;
    add(wp, (px) => lsb + (px - wb.x1) * W_SCALE);
    x = lsb + (wb.x2 - wb.x1) * W_SCALE + rsb + TRACK * size + (i < glyphs.length - 1 ? font.getKerningValue(g, glyphs[i + 1]) * k : 0);
    return;
  }
  add(TEXT[i] === 'i' ? roundDot(gp) : gp);
  x += g.advanceWidth * k + TRACK * size + (i < glyphs.length - 1 ? font.getKerningValue(g, glyphs[i + 1]) * k : 0);
});

let x1 = Infinity, y1 = Infinity, x2 = -Infinity, y2 = -Infinity;
[...cmds, { x: dotCircle.cx, y: dotCircle.cy - dotCircle.r }].forEach((c) => { if ('x' in c) { x1 = Math.min(x1, c.x); x2 = Math.max(x2, c.x); y1 = Math.min(y1, c.y); y2 = Math.max(y2, c.y); } });
const f = (n) => Number(n.toFixed(3));
const P = (px, py) => `${f(px - x1)} ${f(py - y1)}`;
const dOf = (list) => list.map((c) => c.type === 'M' ? `M${P(c.x, c.y)}` : c.type === 'L' ? `L${P(c.x, c.y)}` : c.type === 'C' ? `C${P(c.x1, c.y1)} ${P(c.x2, c.y2)} ${P(c.x, c.y)}` : c.type === 'Q' ? `Q${P(c.x1, c.y1)} ${P(c.x, c.y)}` : 'Z').join('');
const w = f(x2 - x1), h = f(y2 - y1);
const capTop = f(-CAP - y1), baseline = f(-y1);
const svg = `<svg class="wm" role="img" aria-label="WiseUp" width="${Math.round(w)}" height="${Math.round(h)}" viewBox="0 0 ${w} ${h}" fill="none" xmlns="http://www.w3.org/2000/svg">
<g class="wm__letters" fill="url(#paint0_linear_wiseup)">
${[...TEXT].map((ch, i) => `<path class="wm__l" data-ch="${ch}" d="${dOf(cmds.filter((c) => c.g === i))}"/>`).join('\n')}
</g>
<circle class="wm__dot" cx="${f(dotCircle.cx - x1)}" cy="${f(dotCircle.cy - y1)}" r="${f(dotCircle.r)}" fill="url(#paint1_radial_wiseup)"/>
<defs>
<linearGradient id="paint0_linear_wiseup" x1="0" y1="${f(h / 2)}" x2="${w}" y2="${f(h / 2)}" gradientUnits="userSpaceOnUse">
<stop class="wm__s0" stop-color="white"/>
<stop class="wm__s1" offset="1" stop-color="#999999"/>
</linearGradient>
<radialGradient id="paint1_radial_wiseup" cx="0.38" cy="0.32" r="0.75">
<stop class="wm__d0" stop-color="#eef7c8"/>
<stop class="wm__d1" offset="1" stop-color="#beda52"/>
</radialGradient>
</defs>
</svg>
`;
fs.writeFileSync(OUT, svg);
// CSS margins that trim the box to the reference's (cap top .. baseline + 9)
console.log({ w, h, capTop, baseline, marginTop: +(capTop / w).toFixed(6), marginBottom: +((h - baseline - 9) / w).toFixed(6) });
