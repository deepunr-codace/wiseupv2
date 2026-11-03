// Generates template-wiseup-{home,about,contact,podcast}.php from the current production build
// (dist/), following the project's established WordPress conventions: fully self-contained (no
// get_header/get_footer), wp_head()/wp_footer() hooked in for plugin compatibility, every bare-tag
// selector scoped to .wiseup-home AND wrapped in :where() so it can neither leak onto the theme's
// own markup nor outrank one of our own component rules, and every theme/plugin stylesheet actively
// dequeued on these pages so none of the active theme's own CSS can apply to or conflict with ours
// (see the wp_dequeue_style loop in each generated template's <head>). All pages share one scoped
// stylesheet/script (same design system) and one asset folder — only the body markup, title and
// meta description differ per page.
// Superseded by the WiseUp plugin (scripts/build-wp-plugin.mjs); kept for the theme-template install.
// Usage: npm run build && node scripts/gen-wp-template.mjs
import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import path from 'node:path';
import { DIST, PAGES, sharedCss, pageCss as readPageCss, readPage, rewriteAssetPaths, warnLeftovers, scriptFile, copyAssets } from './wp-shared.mjs';

const ROOT = path.resolve('..'); // the project folder one level above wiseup-site/
const OUT_ASSETS = path.join(ROOT, 'wiseup-assets'); // copy this whole folder, as-is, into the theme

const css = sharedCss();
// The compiled module bundle, inlined verbatim. Identical on every page.
const js = readFileSync(path.join(DIST, '_astro', scriptFile()), 'utf8');
const ASSET_BASE = "<?php echo get_template_directory_uri(); ?>/wiseup-assets";

for (const p of PAGES) {
  const page = { ...p, outFile: `template-wiseup-${p.slug}.php`, templateName: `WiseUp ${p.label}` };
  const built = readPage(page);
  if (!built) { console.warn(`Skipping ${page.slug}: not built (run "npm run build" first)`); continue; }
  const body = rewriteAssetPaths(built.body, ASSET_BASE);
  warnLeftovers(page.slug, body);
  const { title, description, headScript } = built;
  const pageCss = readPageCss(page);

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

// Copy the static asset folders the rewritten paths point at (shared by all pages).
copyAssets(OUT_ASSETS);
console.log(`Copied assets to ${OUT_ASSETS}`);
