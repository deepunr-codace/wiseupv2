// Generates template-wiseup-{home,about,contact,podcast}.php from the current production build
// (dist/), following the project's established WordPress conventions: fully self-contained (no
// get_header/get_footer), wp_head()/wp_footer() hooked in for plugin compatibility, every bare-tag
// selector scoped to .wiseup-home AND wrapped in :where() so it can neither leak onto the theme's
// own markup nor outrank one of our own component rules, and every theme/plugin stylesheet actively
// dequeued on these pages so none of the active theme's own CSS can apply to or conflict with ours
// (see the wp_dequeue_style loop in each generated template's <head>). All pages share one scoped
// stylesheet/script (same design system) and one asset folder — only the body markup, title and
// meta description differ per page.
// Usage: npm run build && node scripts/gen-wp-template.mjs
import { readFileSync, writeFileSync, mkdirSync, cpSync, readdirSync, existsSync, rmSync } from 'node:fs';
import path from 'node:path';

const ROOT = path.resolve('..'); // the project folder one level above wiseup-site/
const DIST = path.resolve('dist');
const OUT_ASSETS = path.join(ROOT, 'wiseup-assets'); // copy this whole folder, as-is, into the theme

// ---------- 1. CSS: concatenate the readable sources (not the minified bundle) and scope every
// risky bare-tag reset selector in base.css/tokens.css to .wiseup-home, so none of it can leak onto
// the WP theme, admin bar, or any other plugin-injected chrome sharing the page outside our own
// markup — and wrap every one of those in :where() so it also can't outrank one of our own
// single-class component rules by specificity. Shared verbatim across all three generated pages. --
const tokens = readFileSync('src/styles/tokens.css', 'utf8');
let base = readFileSync('src/styles/base.css', 'utf8');
const site = readFileSync('src/styles/site.css', 'utf8');

// Matched by the SELECTOR list only, not the declarations inside { }, so editing base.css's rules
// later can't silently break this scoping the way an exact-string match on the whole rule once did.
const RISKY_SELECTORS = ['*', 'html', 'body', 'img, svg, video', 'img', 'input, button, textarea, select', 'button', 'a', 'ul, ol', 'h1, h2, h3, h4', 'p'];
// The <html> element itself can't carry our class (WordPress only lets a template add body classes),
// so "our html" is the html whose body is ours. Its rules (background, scroll-padding-top for anchor
// links under the fixed header) must land on <html>, the scroll container; on <body> they do nothing.
const OUR_HTML = ':where(html:has(> body.wiseup-home))';
const scopeSelector = (sel) => sel.split(',').map((s) => {
  s = s.trim();
  return s === 'body' ? 'body:where(.wiseup-home)' : s === 'html' ? OUR_HTML : `:where(.wiseup-home) ${s}`;
}).join(', ');
const scopeBase = (css) => {
  // Includes our <body> itself, or it keeps the browser's default 8px margin: a frame of the theme's
  // background around the whole page.
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
base = scopeBase(base);
// tokens.css stays on plain :root: each template prints its own <html>, so :root is always ours.
// Don't also declare the tokens on body.wiseup-home: that re-sets the dark values on <body>, so the
// light-mode override (:root[data-theme='light'] { --bg: #fff ... }) never reached anything inside
// it and the theme toggle only half-worked on the live site.

// lead.css: LeadModal.astro's own stylesheet, imported by the component directly (not re-exported
// through site.css) and included on every page via Base.astro — found missing from every generated
// template (the popup's HTML was there, none of its CSS was, so it rendered completely unstyled)
// while investigating "why the popup form style broken". All class-scoped already (.lead*), no
// bare-tag selectors, so it's safe to concatenate as-is, same as site.css.
const lead = readFileSync('src/styles/lead.css', 'utf8');

const css = `/* ===== tokens ===== */\n${tokens}\n/* ===== base (scoped to .wiseup-home) ===== */\n${base}\n/* ===== components ===== */\n${site}\n/* ===== lead popup (Base.astro, every page) ===== */\n${lead}`;

// ---------- 2. JS: the compiled module bundle, inlined verbatim. Identical on every page. ----------
const jsFile = readdirSync(path.join(DIST, '_astro')).find((f) => f.startsWith('Base.astro_astro_type_script'));
const js = readFileSync(path.join(DIST, '_astro', jsFile), 'utf8');

const ASSET_BASE = "<?php echo get_template_directory_uri(); ?>/wiseup-assets";
// "podcast" added 2026-10-24 for the /podcast page's own real asset folder (public/podcast/,
// banner/host photos/channel art, including its ep/ and gallery/ subfolders — same prefix match
// catches those too). "strip" added same day for the homepage hero strip's own image set
// (public/strip/) — found missing via this script's own unrewritten-path warning, not assumed.
const rewriteAssetPaths = (body) => body
  .replace(/(src|srcset|data-seq-base)="\/(_astro|process|seq|clients|brand|podcast|strip)\//g, (_, attr, dir) => `${attr}="${ASSET_BASE}/${dir}/`)
  .replace(/srcset="([^"]+)"/g, (m, val) => `srcset="${val.replace(/(?<=,\s*)\/(_astro|process|seq|clients|brand|podcast|strip)\//g, (_, dir) => `${ASSET_BASE}/${dir}/`)}"`);

// ---------- 3. One PHP file per page. ----------
const PAGES = [
  {
    slug: 'home', distDir: '.', outFile: 'template-wiseup-home.php', templateName: 'WiseUp Home',
    title: 'Branding &amp; Marketing Agency in Kerala (Kozhikode) | WiseUp',
    description: 'WiseUp is a branding and digital marketing agency in Kozhikode (Calicut), Kerala, serving brands across India and the Middle East.',
    // Figtree (hero text font, see index.astro's head slot) — this generator reads <body> only and
    // builds its own hardcoded <head> below, so anything added to a page's Astro `head` slot has to
    // be mirrored here by hand too, or it silently never reaches the deployed WP template.
    extraHead: `<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">`,
  },
  {
    slug: 'about', distDir: 'about', outFile: 'template-wiseup-about.php', templateName: 'WiseUp About',
    // Page-only stylesheet, imported by about.astro alone. All class-based (no bare-tag rules), so
    // it is inlined as-is after the shared CSS, in the same order Astro loads it.
    extraCss: ['src/styles/about.css'],
    title: 'About Us | WiseUp',
    description: "We are a brand strategy agency and digital marketing agency in Kozhikode, Kerala: AI-integrated and technologically advanced, yet deeply human.",
  },
  {
    slug: 'contact', distDir: 'contact', outFile: 'template-wiseup-contact.php', templateName: 'WiseUp Contact',
    title: 'Contact Us | WiseUp',
    description: "Tell us where you want your brand to go. We'll send the plan before we talk numbers.",
  },
  {
    slug: 'podcast', distDir: 'podcast', outFile: 'template-wiseup-podcast.php', templateName: 'WiseUp Podcast',
    // Page-only stylesheet, same pattern as about.css.
    extraCss: ['src/styles/podcast.css'],
    title: 'WiseUp Podcast | The Malayalam Podcast for Online Business Owners',
    description: 'A Malayalam business podcast with entrepreneurs, creators and changemakers who are building a better tomorrow.',
    // Mirrors podcast.astro's own <Fragment slot="head"> verbatim — see the "extraHead" note on
    // the home page entry above for why this has to be kept in sync by hand.
    extraHead: `<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Malayalam:wght@700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Malayalam:wght@700;800&display=swap" rel="stylesheet"></noscript>`,
  },
];

for (const page of PAGES) {
  const htmlPath = path.join(DIST, page.distDir, 'index.html');
  if (!existsSync(htmlPath)) { console.warn(`Skipping ${page.slug}: ${htmlPath} not found (run "npm run build" first)`); continue; }
  const html = readFileSync(htmlPath, 'utf8');
  const bodyMatch = html.match(/<body>([\s\S]*)<\/body>/);
  if (!bodyMatch) throw new Error(`Could not find <body> in ${htmlPath}`);
  let body = bodyMatch[1];
  // Drop the trailing module-script tag; we inline the JS ourselves below instead.
  body = body.replace(/<script type="module" src="[^"]+"><\/script>\s*$/, '');
  body = rewriteAssetPaths(body);
  const leftover = body.match(/(?:src|srcset|href)="\/(?!\/|#|about|contact|$)[^"]*\.(?:webp|jpe?g|png|svg|avif|js|css|woff2)"/g);
  if (leftover) console.warn(`  ${page.slug}: root-relative asset paths left unrewritten: ${[...new Set(leftover)].slice(0, 5).join(', ')}`);

  // Title and description come from the built page, so they always match the Astro source;
  // the PAGES values are only a fallback.
  const title = html.match(/<title>([^<]*)<\/title>/)?.[1] || page.title;
  const description = html.match(/<meta name="description" content="([^"]*)"/)?.[1] || page.description;
  // Base.astro's inline head script (js/motion classes + restoring the visitor's saved light/dark
  // theme before first paint), taken from the built page rather than hand-copied: a hand copy here
  // once kept only the first two lines, so WP pages always opened dark whatever the visitor chose.
  const headScript = html.match(/<head>([\s\S]*?)<\/head>/)?.[1].match(/<script>[\s\S]*?wu-theme[\s\S]*?<\/script>/)?.[0];
  if (!headScript) throw new Error(`${page.slug}: Base.astro's theme-init <script> not found in the built <head>`);
  const pageCss = (page.extraCss || []).map((f) => `/* ===== ${path.basename(f)} (this page only) ===== */\n${readFileSync(f, 'utf8')}`).join('\n');

  const php = `<?php
/**
 * Template Name: ${page.templateName}
 * Template Post Type: page
 *
 * Fully self-contained ${page.slug} page template, generated from the project's Astro build
 * (wiseup-site/) on ${new Date().toISOString().slice(0, 10)}. Deliberately does NOT call
 * get_header()/get_footer() so none of the active theme's markup, nav or styles leak into this
 * page — only wp_head() / wp_footer() are hooked in, for plugin/script compatibility (analytics,
 * SEO meta, etc). No global/bare-tag CSS at all: every reset in the stylesheet below is scoped to
 * .wiseup-home AND wrapped in :where() (zero specificity), so it can neither apply outside our own
 * markup nor outrank one of our own component rules. On top of that, every stylesheet the active
 * theme/plugins would otherwise enqueue on this page is actively dequeued (and the admin bar
 * hidden, since its CSS came from that same queue) so none of the theme's own CSS loads here at
 * all — this page uses only our styles.
 *
 * Install:
 *  1. Copy this file into your active theme's root folder.
 *  2. Copy the whole "wiseup-assets" folder (found next to this file in the project: images,
 *     fonts, the flame sequence, process backgrounds) into your active theme's root folder too,
 *     so it sits right next to this template file (theme-root/wiseup-assets/...). One shared
 *     folder serves all three WiseUp templates (home/about/contact) — copy it once.
 *  3. In wp-admin, open the ${page.slug === 'home' ? 'homepage' : page.slug + ' page'}, set Page
 *     Attributes -> Template -> "${page.templateName}".
 *  4. Give the page the slug "${page.slug === 'home' ? '' : page.slug}"${page.slug === 'home' ? ' (the site root)' : ''}
 *     — the header nav and the in-page links (/#about, /#contact, /about, /contact) assume the
 *     WiseUp Home template is published at the site root and About/Contact at /about/ and
 *     /contact/. If your site structure differs, update those hrefs in the Astro source and
 *     regenerate.
 *
 * Regenerate: run "npm run build && node scripts/gen-wp-template.mjs" inside wiseup-site/ after
 * any change to the Astro site, then redo step 1 for every page that changed (all three share one
 * stylesheet/script, so a global CSS change touches all three output files) — step 2 only if asset
 * filenames changed (they're content-hashed, so most content edits don't touch them).
 *
 * Note: title/meta description below are hardcoded by design, and we remove WordPress core's own
 * default <title> (the title-tag theme-support hook) just before wp_head() runs, so there is only
 * ever one <title> on the page — ours. If an SEO plugin (Yoast/RankMath/etc) is active, it likely
 * hooks its own <title>/meta description onto wp_head() too; in that case remove the
 * remove_action() line and the two hardcoded tags below, and let the plugin manage them instead.
 */
?>
<?php
// Reported "these files dont use themes styles... there are some conflicts" (2026-10-24): body_class()
// below adds the active theme's OWN body classes alongside ours, and wp_head() lets the theme/Gutenberg
// enqueue their own stylesheets on this same page — so theme CSS could still match our markup or get
// overridden by it unpredictably. Fix: dequeue every stylesheet the theme/plugins queued for this
// request (we need none of them, everything is in our own inlined <style> below) and hide the admin
// bar (its CSS came from the same queue, so without this an admin would see it unstyled). Theme-agnostic
// - works regardless of which theme is active, so it survives a future theme switch too.
add_filter( 'show_admin_bar', '__return_false' );
$wiseup_dequeue_styles = function () {
	global $wp_styles;
	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( $wp_styles->queue as $handle ) {
			wp_dequeue_style( $handle );
		}
	}
};
add_action( 'wp_enqueue_scripts', $wiseup_dequeue_styles, 100 );
add_action( 'wp_print_styles', $wiseup_dequeue_styles, 0 );
add_action( 'wp_footer', $wiseup_dequeue_styles, 0 );
// Printed outside the style queue, so dequeuing doesn't catch them: WP's theme.json global styles
// and the Customizer's "Additional CSS".
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php remove_action( 'wp_head', '_wp_render_title_tag', 1 ); wp_head(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${title}</title>
<meta name="description" content="${description}">
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/wiseup-assets/favicon.svg" type="image/svg+xml">
<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/wiseup-assets/fonts/inter-300_700-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/wiseup-assets/fonts/outfit-200_500-normal.woff2" as="font" type="font/woff2" crossorigin>
${page.extraHead || ''}
${headScript}
<style>
${(pageCss ? `${css}\n${pageCss}` : css).replace(/url\((['"]?)\/fonts\//g, (_, q) => `url(${q}<?php echo get_template_directory_uri(); ?>/wiseup-assets/fonts/`)}
</style>
</head>
<body <?php body_class( 'wiseup-home' ); ?>>
${body}
<script>
<?php // Real contact-form backend (wiseup-contact-mail plugin, see wordpress-plugin/) — absent
      // if that plugin isn't installed/active, in which case contactForm() in the inlined script
      // below falls back to its original WhatsApp-compose behaviour, not a fake "sent" state. ?>
<?php if ( function_exists( 'rest_url' ) ) : ?>
window.WISEUP_CONTACT = { endpoint: '<?php echo esc_js( rest_url( 'wiseup-contact/v1/submit' ) ); ?>', nonce: '<?php echo esc_js( wp_create_nonce( 'wp_rest' ) ); ?>' };
<?php endif; ?>
</script>
<script type="module">
${js}
</script>
<?php wp_footer(); ?>
</body>
</html>
`;

  const outPath = path.join(ROOT, page.outFile);
  mkdirSync(path.dirname(outPath), { recursive: true });
  writeFileSync(outPath, php);
  console.log(`Wrote ${outPath} (${(php.length / 1024).toFixed(0)} KB)`);
}

// ---------- 4. Copy the static asset folders the rewritten paths point at (shared by all pages). --
mkdirSync(OUT_ASSETS, { recursive: true });
// _astro files are content-hashed, so every build leaves the previous ones behind; start clean so the
// folder only holds what the current templates reference.
rmSync(path.join(OUT_ASSETS, '_astro'), { recursive: true, force: true });
cpSync(path.join(DIST, '_astro'), path.join(OUT_ASSETS, '_astro'), { recursive: true });
cpSync(path.join(DIST, 'process'), path.join(OUT_ASSETS, 'process'), { recursive: true });
cpSync(path.join(DIST, 'seq'), path.join(OUT_ASSETS, 'seq'), { recursive: true });
mkdirSync(path.join(OUT_ASSETS, 'fonts'), { recursive: true });
cpSync('public/fonts', path.join(OUT_ASSETS, 'fonts'), { recursive: true });
cpSync('public/favicon.svg', path.join(OUT_ASSETS, 'favicon.svg'));
// Client logos (homepage marquee) and brand marks (inlined SVG wordmark's own folder, kept for
// any other page that references it by URL) — referenced as root-relative /clients/, /brand/.
if (existsSync('public/clients')) cpSync('public/clients', path.join(OUT_ASSETS, 'clients'), { recursive: true });
if (existsSync('public/brand')) cpSync('public/brand', path.join(OUT_ASSETS, 'brand'), { recursive: true });
// Podcast page's own real asset folder (banner/host photos/channel art, ep/ and gallery/ subfolders).
if (existsSync('public/podcast')) cpSync('public/podcast', path.join(OUT_ASSETS, 'podcast'), { recursive: true });
// Homepage hero strip's own image set.
if (existsSync('public/strip')) cpSync('public/strip', path.join(OUT_ASSETS, 'strip'), { recursive: true });
console.log(`Copied assets to ${OUT_ASSETS}`);
