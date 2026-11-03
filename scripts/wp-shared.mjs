// Shared by the two WordPress outputs: the theme page templates (gen-wp-template.mjs) and the WiseUp plugin
// (build-wp-plugin.mjs). Reads the production build (dist/) plus the readable CSS sources.
import { readFileSync, readdirSync, existsSync, cpSync, mkdirSync, rmSync } from 'node:fs';
import path from 'node:path';

export const DIST = path.resolve('dist');

// ---------- CSS: concatenate the readable sources (not the minified bundle) and scope every risky bare-tag reset
// selector in base.css to .wiseup-home, so none of it can leak onto the WP theme, admin bar, or any other
// plugin-injected chrome sharing the page outside our own markup, and wrap every one of those in :where() so it
// also can't outrank one of our own single-class component rules by specificity. ----------

// Matched by the SELECTOR list only, not the declarations inside { }, so editing base.css's rules later can't
// silently break this scoping the way an exact-string match on the whole rule once did.
const RISKY_SELECTORS = ['*', 'html', 'body', 'img, svg, video', 'img', 'input, button, textarea, select', 'button', 'a', 'ul, ol', 'h1, h2, h3, h4', 'p'];
// The <html> element itself can't carry our class (WordPress only lets a template add body classes), so "our
// html" is the html whose body is ours. Its rules (background, scroll-padding-top for anchor links under the
// fixed header) must land on <html>, the scroll container; on <body> they do nothing.
const OUR_HTML = ':where(html:has(> body.wiseup-home))';
const scopeSelector = (sel) => sel.split(',').map((s) => {
  s = s.trim();
  return s === 'body' ? 'body:where(.wiseup-home)' : s === 'html' ? OUR_HTML : `:where(.wiseup-home) ${s}`;
}).join(', ');
const scopeBase = (css) => {
  // Includes our <body> itself, or it keeps the browser's default 8px margin: a frame of the theme's background
  // around the whole page.
  let out = css.replace(/^\* \{ margin: 0; \}$/m, ':where(.wiseup-home), :where(.wiseup-home) * { margin: 0; }');
  for (const sel of RISKY_SELECTORS) {
    if (sel === '*') continue; // handled above (margin reset); *::before/*::after below are separate selectors
    const re = new RegExp(`^${sel.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')} \\{`, 'm');
    out = out.replace(re, `${scopeSelector(sel)} {`);
  }
  // The two remaining universal rules (*, *::before, *::after { ... }).
  out = out.replace(/^\*, \*::before, \*::after \{ box-sizing: border-box; \}$/m,
    ':where(.wiseup-home), :where(.wiseup-home) *, :where(.wiseup-home) *::before, :where(.wiseup-home) *::after { box-sizing: border-box; }');
  out = out.replace(/^\*, \*::before, \*::after \{ border: 0; background: none; box-shadow: none; \}$/m,
    ':where(.wiseup-home), :where(.wiseup-home) *, :where(.wiseup-home) *::before, :where(.wiseup-home) *::after { border: 0; background: none; box-shadow: none; }');
  return out;
};

/** The stylesheet every page shares. url(/fonts/…) and url(/brand/…) are left root-relative for the caller to map. */
export function sharedCss() {
  // tokens.css stays on plain :root. Don't also declare the tokens on body.wiseup-home: that re-sets the dark values
  // on <body>, so the light-mode override (:root[data-theme='light'] { --bg: #fff ... }) never reached anything
  // inside it and the theme toggle only half-worked on the live site.
  const tokens = readFileSync('src/styles/tokens.css', 'utf8');
  const base = scopeBase(readFileSync('src/styles/base.css', 'utf8'));
  const site = readFileSync('src/styles/site.css', 'utf8');
  // lead.css: LeadModal.astro's own stylesheet, imported by the component directly (not through site.css) and on
  // every page via Base.astro. All class-scoped (.lead*), so it goes in as-is.
  const lead = readFileSync('src/styles/lead.css', 'utf8');
  return `/* ===== tokens ===== */\n${tokens}\n/* ===== base (scoped to .wiseup-home) ===== */\n${base}\n/* ===== components ===== */\n${site}\n/* ===== lead popup (Base.astro, every page) ===== */\n${lead}`;
}

/** A page's own stylesheet(s), '' if it has none. */
export const pageCss = (page) => (page.extraCss || []).map((f) => `/* ===== ${path.basename(f)} (this page only) ===== */\n${readFileSync(f, 'utf8')}`).join('\n');

// ---------- Pages ----------
export const PAGES = [
  {
    slug: 'home', distDir: '.', label: 'Home',
    title: 'Branding &amp; Marketing Agency in Kerala (Kozhikode) | WiseUp',
    description: 'WiseUp is a branding and digital marketing agency in Kozhikode (Calicut), Kerala, serving brands across India and the Middle East.',
    // Figtree (hero text font, see index.astro's head slot). These generators read <body> only and build their own
    // <head>, so anything added to a page's Astro `head` slot has to be mirrored here by hand too.
    extraHead: `<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">`,
  },
  {
    slug: 'about', distDir: 'about', label: 'About',
    // Page-only stylesheet, imported by about.astro alone. All class-based (no bare-tag rules), so it goes in as-is
    // after the shared CSS, in the same order Astro loads it.
    extraCss: ['src/styles/about.css'],
    title: 'About Us | WiseUp',
    description: 'We are a brand strategy agency and digital marketing agency in Kozhikode, Kerala: AI-integrated and technologically advanced, yet deeply human.',
  },
  {
    slug: 'contact', distDir: 'contact', label: 'Contact',
    title: 'Contact Us | WiseUp',
    description: "Tell us where you want your brand to go. We'll send the plan before we talk numbers.",
  },
  {
    slug: 'podcast', distDir: 'podcast', label: 'Podcast',
    extraCss: ['src/styles/podcast.css'],
    title: 'WiseUp Podcast | The Malayalam Podcast for Online Business Owners',
    description: 'A Malayalam business podcast with entrepreneurs, creators and changemakers who are building a better tomorrow.',
    // Mirrors podcast.astro's own <Fragment slot="head"> verbatim (see the home entry's note).
    extraHead: `<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Malayalam:wght@700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Malayalam:wght@700;800&display=swap" rel="stylesheet"></noscript>`,
  },
];

// ---------- Output formatting: strip the .astro source's own authoring comments (dev notes, not meant for
// production "view source") and pretty-print the markup with real indentation, since Astro's compressHTML
// collapses the whole page onto one line. Applied once, in readPage(), so both WP outputs (the theme templates
// and the plugin) get clean source automatically. Doesn't touch the .astro source files themselves — those
// comments stay for whoever reads the Astro code next. ----------
const VOID_TAGS = new Set(['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr']);
const RAW_TAGS = ['script', 'style']; // their content may contain '<'/'>'/quotes a tag tokenizer would misread

export function formatHtml(html) {
  // Mask <script>/<style> blocks whole (tag + content) before touching anything, so their insides are never
  // reformatted or mistaken for markup, then strip comments from what's left (now safe: no script/style content
  // left to false-match against).
  const raws = [];
  let masked = html.replace(new RegExp(`<(${RAW_TAGS.join('|')})\\b[^>]*>[\\s\\S]*?<\\/\\1>`, 'gi'), (m) => {
    raws.push(m);
    return `\u0000RAW${raws.length - 1}\u0000`;
  });
  masked = masked.replace(/<!--[\s\S]*?-->/g, '');

  // Tokenize into tags and text runs (safe here: no attribute value in this codebase contains a literal '<'/'>').
  const tokens = masked.match(/<[^>]+>|[^<]+/g) || [];
  let depth = 0;
  const lines = [];
  for (const tok of tokens) {
    if (tok[0] !== '<') {
      const text = tok.trim();
      if (text) lines.push('\t'.repeat(depth) + text);
      continue;
    }
    const isClose = tok[1] === '/';
    const isSelfClose = /\/>\s*$/.test(tok);
    const tagName = (tok.match(/^<\/?([a-zA-Z0-9-]+)/) || [])[1]?.toLowerCase() || '';
    const isVoid = isSelfClose || VOID_TAGS.has(tagName);
    if (isClose) depth = Math.max(0, depth - 1);
    lines.push('\t'.repeat(depth) + tok);
    if (!isClose && !isVoid) depth++;
  }
  return lines.join('\n').replace(/\u0000RAW(\d+)\u0000/g, (_, i) => raws[Number(i)]);
}

/** The built page split into the parts both outputs need. Returns null if the page hasn't been built. */
export function readPage(page) {
  const htmlPath = path.join(DIST, page.distDir, 'index.html');
  if (!existsSync(htmlPath)) return null;
  const html = readFileSync(htmlPath, 'utf8');
  const body = html.match(/<body>([\s\S]*)<\/body>/)?.[1];
  if (!body) throw new Error(`Could not find <body> in ${htmlPath}`);
  // Base.astro's inline head script (js/motion classes + restoring the visitor's saved light/dark theme before first
  // paint), taken from the built page rather than hand-copied: a hand copy once kept only the first two lines, so WP
  // pages always opened dark whatever the visitor chose.
  const headScript = html.match(/<head>([\s\S]*?)<\/head>/)?.[1].match(/<script>[\s\S]*?wu-theme[\s\S]*?<\/script>/)?.[0];
  if (!headScript) throw new Error(`${page.slug}: Base.astro's theme-init <script> not found in the built <head>`);
  return {
    html,
    body: formatHtml(body.replace(/<script type="module" src="[^"]+"><\/script>\s*$/, '')), // we load the JS ourselves
    title: html.match(/<title>([^<]*)<\/title>/)?.[1] || page.title,
    description: html.match(/<meta name="description" content="([^"]*)"/)?.[1] || page.description,
    headScript,
  };
}

// ---------- Assets ----------
// Root-relative folders the built markup points at; each is copied next to the output and rewritten to it.
const ASSET_DIRS = '_astro|process|seq|clients|brand|podcast|strip|press|reach';
export function rewriteAssetPaths(body, base) {
  return body
    .replace(new RegExp(`(src|srcset|data-seq-base)="\\/(${ASSET_DIRS})\\/`, 'g'), (_, attr, dir) => `${attr}="${base}/${dir}/`)
    .replace(/srcset="([^"]+)"/g, (m, val) => `srcset="${val.replace(new RegExp(`(?<=,\\s*)\\/(${ASSET_DIRS})\\/`, 'g'), (_, dir) => `${base}/${dir}/`)}"`);
}
/** Logs any root-relative asset path rewriteAssetPaths() didn't cover (a new public/ folder, usually). */
export function warnLeftovers(slug, body) {
  const leftover = body.match(/(?:src|srcset|href)="\/(?!\/|#|about|contact|podcast\/#|$)[^"]*\.(?:webp|jpe?g|png|svg|avif|js|css|woff2)"/g);
  if (leftover) console.warn(`  ${slug}: root-relative asset paths left unrewritten: ${[...new Set(leftover)].slice(0, 5).join(', ')}`);
}

/** File name of the compiled site script (one self-contained module, no imports) inside dist/_astro. */
export const scriptFile = () => readdirSync(path.join(DIST, '_astro')).find((f) => f.startsWith('Base.astro_astro_type_script'));

/** Copies every folder the rewritten paths point at, plus fonts and the favicon, into `dest`. */
export function copyAssets(dest) {
  mkdirSync(dest, { recursive: true });
  // _astro files are content-hashed, so every build leaves the previous ones behind; start clean so the folder only
  // holds what the current output references.
  rmSync(path.join(dest, '_astro'), { recursive: true, force: true });
  cpSync(path.join(DIST, '_astro'), path.join(dest, '_astro'), { recursive: true });
  cpSync(path.join(DIST, 'process'), path.join(dest, 'process'), { recursive: true });
  cpSync(path.join(DIST, 'seq'), path.join(dest, 'seq'), { recursive: true });
  mkdirSync(path.join(dest, 'fonts'), { recursive: true });
  cpSync('public/fonts', path.join(dest, 'fonts'), { recursive: true });
  cpSync('public/favicon.svg', path.join(dest, 'favicon.svg'));
  for (const dir of ['clients', 'brand', 'podcast', 'strip', 'press', 'reach']) {
    if (existsSync(`public/${dir}`)) cpSync(`public/${dir}`, path.join(dest, dir), { recursive: true });
  }
}
