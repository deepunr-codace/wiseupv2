// Builds the hero wordmark SVG in the Lunar template's style (reference: hero-lunar-logo-big.svg): one outlined compound
// path, cap height 225 units, fill = horizontal gradient white -> #999999.
// Font: Unbounded at weight 340, cut from the variable font (the reference's stem/cap-height ratio is 0.145; this is 0.144).
// Usage: node scripts/make-lunar-wordmark.mjs   (needs opentype.js: npm i --no-save opentype.js)
import * as ot from 'opentype.js';
import fs from 'node:fs';
const opentype = ot.default ?? ot;

const TEXT = 'WiseUp';
const FONT = new URL('./fonts/Unbounded-wght340.ttf', import.meta.url);
const CAP = 225; // cap height in svg units, as in the reference
const OUT = new URL('../public/brand/hero-wiseup-lunar-logo-big.svg', import.meta.url);

const buf = fs.readFileSync(FONT);
const font = opentype.parse(buf.buffer.slice(buf.byteOffset, buf.byteOffset + buf.byteLength));
const capUnits = -font.charToGlyph('L').getPath(0, 0, font.unitsPerEm).getBoundingBox().y1;
const size = (CAP / capUnits) * font.unitsPerEm;
const path = font.getPath(TEXT, 0, 0, size, { kerning: true, letterSpacing: -0.012 });
const bb = path.getBoundingBox();
const dx = -bb.x1, dy = -bb.y1;
const f = (n) => Number(n.toFixed(3));
const d = path.commands.map((c) => {
  const p = (x, y) => `${f(x + dx)} ${f(y + dy)}`;
  switch (c.type) {
    case 'M': return `M${p(c.x, c.y)}`;
    case 'L': return `L${p(c.x, c.y)}`;
    case 'C': return `C${p(c.x1, c.y1)} ${p(c.x2, c.y2)} ${p(c.x, c.y)}`;
    case 'Q': return `Q${p(c.x1, c.y1)} ${p(c.x, c.y)}`;
    case 'Z': return 'Z';
  }
}).join('');
const w = f(bb.x2 - bb.x1), h = f(bb.y2 - bb.y1);
const svg = `<svg width="${Math.round(w)}" height="${Math.round(h)}" viewBox="0 0 ${w} ${h}" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="nonzero" clip-rule="nonzero" d="${d}" fill="url(#paint0_linear_wiseup)"/>
<defs>
<linearGradient id="paint0_linear_wiseup" x1="0" y1="${f(h / 2)}" x2="${w}" y2="${f(h / 2)}" gradientUnits="userSpaceOnUse">
<stop stop-color="white"/>
<stop offset="1" stop-color="#999999"/>
</linearGradient>
</defs>
</svg>
`;
fs.writeFileSync(OUT, svg);
console.log({ w, h, bytes: svg.length });
