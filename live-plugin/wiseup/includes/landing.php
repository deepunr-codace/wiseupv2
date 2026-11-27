<?php
/**
 * Landing pages: Social Media Marketing, SEO Company and Performance Marketing. Each is a complete page template of
 * its own (landing/*.php, with its own design and assets), offered in the page Template dropdown next to the WiseUp
 * pages. They are kept out of wiseup_templates() on purpose, so the plugin's own head output, header, footer and
 * style isolation don't touch them.
 */
defined( 'ABSPATH' ) || exit;

/** Template key => [ file in landing/, dropdown label, lead source ]. */
function wiseup_landing_templates() {
	return array(
		'wiseup-social-media' => array( 'social-media.php', __( 'WiseUp: Social Media Marketing', 'wiseup' ), 'social-media' ),
		'wiseup-seo'          => array( 'seo.php', __( 'WiseUp: SEO Company', 'wiseup' ), 'seo' ),
		'wiseup-performance'  => array( 'performance-marketing.php', __( 'WiseUp: Performance Marketing', 'wiseup' ), 'performance-marketing' ), // owner 2026-11-18: same page as the doc-based template (the old performance.php content did not match the doc)
		'wiseup-services'     => array( 'services.php', __( 'WiseUp: Services', 'wiseup' ), 'services' ),
		'wiseup-tv'           => array( 'wiseup-tv.php', __( 'WiseUp: TV', 'wiseup' ), 'wiseup-tv' ),
		'wiseup-studio'       => array( 'wiseup-studio.php', __( 'WiseUp: Studio', 'wiseup' ), 'wiseup-studio' ),
		'wiseup-event-branding' => array( 'event-branding.php', __( 'WiseUp: Event Branding', 'wiseup' ), 'event-branding' ),
		'wiseup-digital-marketing' => array( 'digital-marketing.php', __( 'WiseUp: Digital Marketing', 'wiseup' ), 'digital-marketing' ),
		'wiseup-performance-marketing' => array( 'performance-marketing.php', __( 'WiseUp: Performance Marketing (new)', 'wiseup' ), 'performance-marketing' ),
		'wiseup-media-buying' => array( 'media-buying.php', __( 'WiseUp: Media Buying', 'wiseup' ), 'media-buying' ),
		'wiseup-branding'    => array( 'branding.php', __( 'WiseUp: Branding', 'wiseup' ), 'branding' ),
		'wiseup-web-development' => array( 'web-development.php', __( 'WiseUp: Web Development', 'wiseup' ), 'web-development' ),
		'wiseup-portfolio'    => array( 'portfolio.php', __( 'WiseUp: Portfolio', 'wiseup' ), 'portfolio' ),
	);
}

add_filter( 'theme_page_templates', function ( $templates ) {
	foreach ( wiseup_landing_templates() as $key => $t ) $templates[ $key ] = $t[1];
	return $templates;
} );

/** The landing template entry for a page, or null when the page doesn't use one. */
function wiseup_landing_for( $post_id ) {
	$map = wiseup_landing_templates();
	$key = $post_id ? get_page_template_slug( $post_id ) : '';
	// The portfolio template moved from the theme into the plugin (2026-11-12): a page still set to the theme's
	// "Studio Portfolio" template gets the plugin's copy, so nothing breaks before its Template is switched.
	if ( 'template-studio-portfolio.php' === $key ) $key = 'wiseup-portfolio';
	return isset( $map[ $key ] ) ? $map[ $key ] : null;
}

add_filter( 'template_include', function ( $template ) {
	if ( ! is_singular( 'page' ) ) return $template;
	$t = wiseup_landing_for( get_queried_object_id() );
	return $t ? WISEUP_DIR . 'landing/' . $t[0] : $template;
}, 100 );

// The SEO and performance templates find their assets through this function and only define their own copy when it
// is missing, so defining it here serves landing.css/js and performance.css/js from the plugin, not the theme.
function wiseup_landing_assets() {
	return array( WISEUP_URL . 'assets/landing/', WISEUP_DIR . 'assets/landing/' );
}

// Their scanner and forms post to admin-ajax (wiseup_lead, wiseup_sitemap), handled by the bundled WiseUp Lead
// Capture code. Skipped when the standalone plugin is active, so the class is never declared twice.
add_action( 'plugins_loaded', function () {
	if ( ! class_exists( 'WiseUp_Lead_Capture' ) ) require WISEUP_DIR . 'includes/lead-capture.php';
} );

/**
 * Copies a finished landing-page lead (report request, contact form, exit details) into the WiseUp Leads table,
 * tagged with the page it came from, so it shows in Wiseup → Leads next to the site's other forms.
 */
function wiseup_landing_mirror_lead( $lead, $stage ) {
	if ( ! function_exists( 'wiseup_save_lead' ) ) return;
	$referer = (string) wp_get_referer();
	$t       = wiseup_landing_for( url_to_postid( $referer ) );
	$extra   = array();
	foreach ( array( 'company' => 'Company', 'website' => 'Website', 'contact' => 'Phone', 'score' => 'Scan score' ) as $k => $label ) {
		if ( isset( $lead[ $k ] ) && '' !== (string) $lead[ $k ] ) $extra[] = $label . ': ' . $lead[ $k ];
	}
	$extra[] = 'Stage: ' . $stage;
	wiseup_save_lead( array(
		'name'    => $lead['name'] ? $lead['name'] : ( $lead['company'] ? $lead['company'] : $lead['website'] ),
		'email'   => $lead['email'],
		'phone'   => $lead['phone'] ? $lead['phone'] : $lead['contact'],
		'service' => $lead['service'],
		'message' => trim( $lead['message'] . "\n\n" . implode( "\n", $extra ) ),
		'page'    => $referer,
		'source'  => $t ? $t[2] : 'seo',
		'ip'      => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
	) );
}

// ---------- WiseUp header and footer on the landing pages ----------

/**
 * Opens a landing page's document and prints the plugin's own header (the same part the WiseUp pages use, with the
 * links and button set in Wiseup → Header). Replaces get_header(), which printed the theme's old header. The site
 * stylesheet is scoped to .wiseup-home, so only the header and footer wrappers take it; the page's own design is
 * untouched. The main site script is not loaded here (its reveal engine would fight the page's own); a few lines of
 * script in the wp_footer hook below cover the menu button and the header's button.
 */
function wiseup_landing_open( $body_class = 'wu-landing' ) {
	wiseup_landing_chrome_styles();
	?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( $body_class ); ?>>
<?php
	wp_body_open();
	wiseup_landing_chrome_header();
	// service pages: links to other pages inside the page body open in a new tab (owner, 2026-11-23); the header and footer are left alone
	if ( preg_match( '/\bwu-(ev|smm)-page\b/', $body_class ) ) {
		ob_start( 'wiseup_new_tab_links' );
		$GLOBALS['wiseup_newtab_ob'] = ob_get_level();
	}
}

/**
 * The WiseUp header and footer's stylesheet and the few resets they need inside a landing page's own design. Call it
 * before wp_head(). Used by wiseup_landing_open() and by the landing pages that print their own document (SEO,
 * performance marketing).
 */
function wiseup_landing_chrome_styles() {
	add_action( 'wp_head', function () {
		echo '<link rel="stylesheet" href="' . esc_url( wiseup_versioned( 'css/wiseup.css' ) ) . "\">\n";
		echo "<style>body:not(:has(.wu-ev,#wu-smm)) .wu-chrome .hd__theme{display:none}.wu-chrome.wiseup-in-theme{--head-h:0px}.wu-chrome .hd{z-index:2147483000}.wu-chrome *,.wu-chrome *::before,.wu-chrome *::after{box-sizing:border-box}.wu-chrome :is(ul,ol){list-style:none;margin:0;padding:0}.wu-chrome :is(p,h1,h2,h3){margin-top:0}.wu-chrome a{text-decoration:none}.wu-chrome button{font:inherit;color:inherit}.wu-chrome .hd__menu{font-size:14px;font-weight:500;line-height:normal}.wu-chrome a{color:inherit}.wu-chrome .hd__menu,.wu-chrome .hd__menu:hover,.wu-chrome .hd__menu:focus,.wu-chrome .hd__menu:active{background:#0e0e10!important;color:#fff!important;border:0}</style>\n";
		$wu_real_light = ( 'wiseup-media-buying' === get_page_template_slug( get_queried_object_id() ) );
		echo '<script>window.__wuRealLight=' . ( $wu_real_light ? 'true' : 'false' ) . ';try{if(localStorage.getItem("wu-svc-theme")==="light"){document.documentElement.setAttribute("data-svc-theme","light");if(window.__wuRealLight)document.documentElement.setAttribute("data-theme","light")}}catch(e){}</script>' . "
";
		echo '<script>document.addEventListener("DOMContentLoaded",function(){var h=document.documentElement;[].forEach.call(document.querySelectorAll("[data-theme-toggle]"),function(b){var sync=function(){var l=h.getAttribute("data-svc-theme")==="light";b.setAttribute("aria-pressed",l?"true":"false");b.setAttribute("aria-label",l?"Switch to dark mode":"Switch to light mode")};sync();b.addEventListener("click",function(){var l=h.getAttribute("data-svc-theme")==="light";if(l)h.removeAttribute("data-svc-theme");else h.setAttribute("data-svc-theme","light");if(window.__wuRealLight){if(l)h.removeAttribute("data-theme");else h.setAttribute("data-theme","light")}try{localStorage.setItem("wu-svc-theme",l?"dark":"light")}catch(e){}sync()})})})</script>' . "
";
		echo '<style>html[data-svc-theme="light"]:has(.wu-ev,#wu-smm):not(:has(.wu-mb)){filter:invert(1) hue-rotate(180deg);background:#fff}html[data-svc-theme="light"]:has(.wu-ev,#wu-smm):not(:has(.wu-mb)) :is(img:not(.hd__logo img):not(.ft__logo img),video,picture,iframe,.mb-bb__site,.ev-hero__glow){filter:invert(1) hue-rotate(180deg)}html[data-svc-theme="light"]:has(.wu-ev,#wu-smm):not(:has(.wu-mb)) .ft__logo img{filter:brightness(0) invert(1)}html[data-svc-theme="light"]:has(.wu-ev,#wu-smm) .hd__theme-ico .ico--moon{translate:0 -140%;rotate:90deg;opacity:0}html[data-svc-theme="light"]:has(.wu-ev,#wu-smm) .hd__theme-ico .ico--sun{translate:0 0;rotate:0deg;opacity:1}</style>' . "
";
		echo '<script>document.addEventListener("DOMContentLoaded",function(){var f=document.querySelector(".wu-ev .faq");if(f&&!f.querySelector("details[open]")){var d=f.querySelector("details");if(d)d.setAttribute("open","")}})</script>' . "
";
		$plugin_css = file_get_contents( WISEUP_DIR . 'assets/css/plugin.css' );
		if ( false !== $plugin_css ) echo '<style id="wiseup-plugin-css">' . $plugin_css . "</style>\n";
	}, 6 );
}

/** The WiseUp header, in its own wrapper so the site stylesheet (scoped to .wiseup-home) styles only it. */
function wiseup_landing_chrome_header() {
	echo '<div class="wiseup-home wiseup-in-theme wu-chrome">';
	wiseup_part( 'header' );
	echo '</div>';
}

/** Prints the plugin's footer, the scripts for the header, and closes the document. */
function wiseup_landing_close( $lead_source = '' ) {
	if ( ! empty( $GLOBALS['wiseup_newtab_ob'] ) && ob_get_level() >= $GLOBALS['wiseup_newtab_ob'] ) { ob_end_flush(); $GLOBALS['wiseup_newtab_ob'] = 0; }
	wiseup_landing_chrome_footer( $lead_source, true );
	?>
</body>
</html>
<?php
}

/**
 * The WiseUp footer and the scripts for the header (menu button, docking, the header button opening the lead popup).
 * With $wp_footer the theme's wp_footer() runs between the two, as on a full WiseUp landing page.
 */
function wiseup_landing_chrome_footer( $lead_source = '', $wp_footer = false ) {
	echo '<div class="wiseup-home wiseup-in-theme wu-chrome">';
	wiseup_part( 'footer' );
	echo '</div>';
	if ( $wp_footer ) wp_footer();
	echo '<script src="' . esc_url( wiseup_versioned( 'js/footer-wordmark.js' ) ) . '"></script>' . "\n";
	?>
<style>.wu-off, .wu-off *, .wu-off *::before, .wu-off *::after { animation-play-state: paused !important; }</style>
<script>
// CSS animations in sections that are off screen are paused (they ran every frame, SVG ones on the main thread: a style
// and layout pass per frame on every service page even when idle; PageSpeed, 2026-11-24). They carry on when the section comes near.
(function () {
	if (!('IntersectionObserver' in window)) return;
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { e.target.classList.toggle('wu-off', !e.isIntersecting); }); }, { rootMargin: '25% 0px 25% 0px' });
	[].forEach.call(document.querySelectorAll('main section, #wu-smm section, .wu-chrome footer'), function (s) { io.observe(s); });
})();
</script>
<script>
(function () {
	var btn = document.querySelector('[data-menu-btn]'), panel = document.querySelector('[data-menu]');
	if (btn && panel) {
		var set = function (o) { btn.setAttribute('aria-expanded', String(o)); panel.hidden = !o; };
		btn.addEventListener('click', function () { set(btn.getAttribute('aria-expanded') !== 'true'); });
		panel.addEventListener('click', function (e) { if (e.target.closest('[data-menu-link]')) set(false); });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) { set(false); btn.focus(); } });
	}
	// same header behaviour as the homepage: dark pill behind it once scrolled, hides on scroll down, returns on scroll up
	var head = document.querySelector('.hd');
	var dockAlways = <?php echo apply_filters( 'wiseup_header_always_docked', false ) ? 'true' : 'false'; ?>; // a light page keeps the dark pill behind the white logo
	if (head) {
		var last = window.scrollY;
		var onS = function () {
			var y = window.scrollY;
			head.classList.toggle('is-docked', dockAlways || y > 40);
			if (y < 160 || y < last - 2) head.classList.remove('is-hidden');
			else if (y > last + 2 && !head.querySelector(':focus-visible')) head.classList.add('is-hidden');
			last = y;
		};
		onS();
		window.addEventListener('scroll', onS, { passive: true });
		head.addEventListener('focusin', function () { head.classList.remove('is-hidden'); });
	}
	var src = <?php echo wp_json_encode( $lead_source ); ?>;
	if (src && document.querySelector('[data-lead-modal]')) document.querySelectorAll('.hd__cta, [data-menu] .b').forEach(function (a) { a.setAttribute('data-lead-open', ''); a.setAttribute('data-lead-source', src); });
})();
</script>
<?php
}

// On the landing pages the header button goes to the page's own closing section (and opens the lead popup).
add_filter( 'wiseup_header_cta', function ( $cta ) {
	$t = wiseup_landing_for( get_queried_object_id() );
	if ( ! $t || 'portfolio.php' === $t[0] ) return $cta;
	if ( 'services.php' === $t[0] ) return '#wu-svc-cta';
	if ( in_array( $t[0], array( 'seo.php', 'performance.php' ), true ) ) return '#contact';
	return '#wu-smm-cta';
} );

/**
 * For landing pages whose design is fully self-contained (WiseUp TV, WiseUp Studio): drop every stylesheet the theme
 * and other plugins queue (the admin bar's stay), WP's global styles and the Customizer CSS, and the theme's and
 * Kadence's scripts, as the WiseUp templates do (includes/templates.php). Call before wiseup_landing_open().
 */
function wiseup_landing_isolate() {
	$css = function () {
		global $wp_styles;
		if ( ! $wp_styles instanceof WP_Styles ) return;
		foreach ( $wp_styles->queue as $h ) if ( ! in_array( $h, array( 'admin-bar', 'dashicons' ), true ) ) wp_dequeue_style( $h );
	};
	$js = function () {
		global $wp_scripts;
		if ( ! $wp_scripts instanceof WP_Scripts ) return;
		foreach ( $wp_scripts->queue as $h ) {
			$src = isset( $wp_scripts->registered[ $h ] ) ? (string) $wp_scripts->registered[ $h ]->src : '';
			if ( false !== strpos( $src, '/wp-content/themes/' ) || preg_match( '#/wp-content/plugins/kadence[^/]*/#', $src ) ) wp_dequeue_script( $h );
		}
	};
	foreach ( array( array( 'wp_enqueue_scripts', 100 ), array( 'wp_print_styles', 0 ), array( 'wp_footer', 0 ) ) as $hk ) add_action( $hk[0], $css, $hk[1] );
	foreach ( array( array( 'wp_enqueue_scripts', 100 ), array( 'wp_print_scripts', 0 ), array( 'wp_print_footer_scripts', 0 ), array( 'wp_footer', 0 ) ) as $hk ) add_action( $hk[0], $js, $hk[1] );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
	remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
	remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
}

/**
 * "AI Overview": a slim side tab docked to the right edge of the screen (outside the page layout). It appears after a little
 * scrolling; on hover, focus or tap it slides out a small panel with the page's question, a direct answer, key points and a
 * plan button. The text is always in the HTML. Written from each page's own copy; marked up with speakable data.
 *
 * $o: q (question), a (answer, <b> allowed), points (array of [label, text]), links (unused here), fact (optional line).
 */
function wiseup_ai_overview( $o ) {
	static $css = false;
	$allowed = array( 'b' => array(), 'strong' => array() );
	if ( ! $css ) {
		$css = true;
		echo '<style>
.wu-aio3{position:fixed;right:0;top:50%;z-index:80;display:flex;align-items:center;transform:translate(100%,-50%);opacity:0;transition:transform .6s cubic-bezier(.2,.8,.2,1),opacity .4s;font-family:Inter,system-ui,sans-serif;color:#fff;text-align:left}
.wu-aio3.is-in{transform:translate(0,-50%);opacity:1}
.wu-aio3:not(.is-js){transform:translate(0,-50%);opacity:1}
.wu-aio3 *{box-sizing:border-box}
.wu-aio3__tab{display:flex;flex-direction:column;align-items:center;gap:10px;width:38px;padding:14px 0;border:0;border-radius:16px 0 0 16px;background:#111113;color:#fff;font:inherit;cursor:pointer;box-shadow:-6px 8px 24px -10px rgba(0,0,0,.8);transition:background .25s}
.wu-aio3__tab:hover,.wu-aio3.is-open .wu-aio3__tab{background:#1a1a1e}
.wu-aio3__tab:focus-visible{outline:2px solid #beda52;outline-offset:-2px}
.wu-aio3__tab svg{width:15px;height:15px;animation:wu-aio3-p 3s ease-in-out infinite}
.wu-aio3__tab span{writing-mode:vertical-rl;transform:rotate(180deg);font-size:12px;font-weight:600;letter-spacing:.14em;text-transform:uppercase}
.wu-aio3__tab i{width:6px;height:6px;border-radius:50%;background:#beda52;position:relative}.wu-aio3__tab i::after{content:"";position:absolute;inset:0;border-radius:50%;background:rgba(190,218,82,.6);animation:wu-aio3-d 2.4s ease-out infinite}
.wu-aio3__panel{position:absolute;right:100%;top:50%;width:340px;max-height:min(78vh,560px);overflow:auto;background:#111113;border-radius:20px 0 0 20px;box-shadow:-10px 12px 40px -14px rgba(0,0,0,.9);clip-path:inset(0 0 0 100% round 20px 0 0 20px);opacity:0;pointer-events:none;transform:translateY(-50%) translateX(14px);transition:clip-path .65s cubic-bezier(.2,.9,.2,1),opacity .3s,transform .65s cubic-bezier(.2,.9,.2,1)}
.wu-aio3.is-open .wu-aio3__panel{clip-path:inset(0 0 0 0 round 20px 0 0 20px);opacity:1;pointer-events:auto;transform:translateY(-50%)}
@media (hover:hover){.wu-aio3:hover .wu-aio3__panel{clip-path:inset(0 0 0 0 round 20px 0 0 20px);opacity:1;pointer-events:auto;transform:translateY(-50%)}.wu-aio3:hover .wu-aio3__tab svg{animation:wu-aio3-s .8s cubic-bezier(.3,1.4,.5,1) forwards}}
.wu-aio3__in{width:340px;padding:18px 18px 16px}
.wu-aio3__q{margin:0 0 8px;font-size:17px;font-weight:500;line-height:1.25;letter-spacing:-.02em;color:#fff}
.wu-aio3__a{margin:0 0 12px;font-size:13.5px;line-height:1.65;color:#bdbdc5}
.wu-aio3__a b,.wu-aio3__pts b{color:#fff;font-weight:600}
.wu-aio3__pts{margin:0 0 14px;padding:0;list-style:none;display:grid;gap:8px}
.wu-aio3__pts li{position:relative;padding-left:16px;font-size:12.5px;line-height:1.5;color:#a4a4ac}
.wu-aio3__pts li::before{content:"";position:absolute;left:0;top:.5em;width:6px;height:6px;border-radius:50%;background:#beda52}
.wu-aio3__cta{display:inline-flex;align-items:center;gap:6px;min-height:36px;padding:0 16px;border:0;border-radius:99px;font:inherit;font-size:13px;font-weight:600;color:#11150a;background:#beda52;cursor:pointer}
.wu-aio3__cta:hover{background:#d8ec8a}
.wu-aio3__in>*{opacity:0;transform:translateX(18px);transition:opacity .4s,transform .5s cubic-bezier(.2,.9,.2,1)}
.wu-aio3.is-open .wu-aio3__in>*{opacity:1;transform:none;transition-delay:calc(.12s + var(--k,0) * .07s)}
@media (hover:hover){.wu-aio3:hover .wu-aio3__in>*{opacity:1;transform:none;transition-delay:calc(.12s + var(--k,0) * .07s)}}
.wu-aio3__in>:nth-child(2){--k:1}.wu-aio3__in>:nth-child(3){--k:2}.wu-aio3__in>:nth-child(4){--k:3}
.wu-aio3.is-open .wu-aio3__tab svg{animation:wu-aio3-s .8s cubic-bezier(.3,1.4,.5,1) forwards}
.wu-aio3__tab{transition:background .25s,padding .35s cubic-bezier(.2,.9,.2,1),width .35s cubic-bezier(.2,.9,.2,1)}
.wu-aio3:hover .wu-aio3__tab,.wu-aio3.is-open .wu-aio3__tab{width:42px;background:#1b1b20}
@keyframes wu-aio3-s{from{transform:rotate(0) scale(1)}60%{transform:rotate(200deg) scale(1.45)}to{transform:rotate(180deg) scale(1.15)}}
.wu-aio3 .wu-aio3__panel{width:min(360px,calc(100vw - 56px));border-radius:24px 0 0 24px;background:rgba(14,14,16,.86);-webkit-backdrop-filter:blur(18px) saturate(1.3);backdrop-filter:blur(18px) saturate(1.3);box-shadow:-18px 20px 50px -20px rgba(0,0,0,.95)}
.wu-aio3 .wu-aio3__panel::before{content:"";position:absolute;left:0;right:0;top:0;height:2px;background:linear-gradient(90deg,transparent,#beda52 30%,#d8ec8a 60%,transparent)}
.wu-aio3 .wu-aio3__in{width:auto;padding:22px 22px 20px}
.wu-aio3 .wu-aio3__in::before{content:"AI Overview";display:inline-flex;align-items:center;gap:6px;margin-bottom:12px;padding:4px 10px;border-radius:99px;font-size:10.5px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#beda52;background:rgba(190,218,82,.1)}
.wu-aio3 .wu-aio3__q{font-size:18px;line-height:1.3;margin-bottom:10px}
.wu-aio3 .wu-aio3__a{font-size:14px;line-height:1.65;color:#c3c3ca;margin-bottom:16px}
.wu-aio3 .wu-aio3__a b{color:#fff;font-weight:600}
.wu-aio3 .wu-aio3__pts{gap:0;margin-bottom:18px;border-top:1px solid rgba(255,255,255,.07)}
.wu-aio3 .wu-aio3__pts li{padding:11px 0 11px 18px;border-bottom:1px solid rgba(255,255,255,.07);font-size:13px;line-height:1.55;color:#a7a7af}
.wu-aio3 .wu-aio3__pts li::before{top:1.15em;width:6px;height:6px}
.wu-aio3 .wu-aio3__pts b{display:block;margin-bottom:2px;color:#fff;font-size:13.5px}
.wu-aio3 .wu-aio3__cta{width:100%;justify-content:center;min-height:44px;font-size:14px}
@media (max-width:640px){.wu-aio3 .wu-aio3__panel{max-height:70vh}}
.wu-aio3 .wu-aio3__panel,.wu-aio3.is-open .wu-aio3__panel{max-height:none!important;overflow:visible!important}
@media (hover:hover){.wu-aio3:hover .wu-aio3__panel{overflow:visible!important}}
.wu-aio3 .wu-aio3__panel::before{display:none}
.wu-aio3 .wu-aio3__in{padding:18px 20px 18px}
.wu-aio3 .wu-aio3__in::before{margin-bottom:10px}
.wu-aio3 .wu-aio3__q{font-size:17px;margin-bottom:8px}
.wu-aio3 .wu-aio3__a{font-size:13.5px;line-height:1.6;margin-bottom:12px}
.wu-aio3 .wu-aio3__pts{border-top:0;gap:8px;margin-bottom:14px}
.wu-aio3 .wu-aio3__pts li{padding:0 0 0 16px;border-bottom:0;font-size:12.5px;line-height:1.5}
.wu-aio3 .wu-aio3__pts li::before{top:.45em}
.wu-aio3 .wu-aio3__pts b{display:inline;font-size:12.5px;margin:0}
.wu-aio3 .wu-aio3__cta{min-height:40px}
.wu-aio3 .wu-aio3__panel,.wu-aio3 .wu-aio3__tab{background:#121214!important;-webkit-backdrop-filter:none;backdrop-filter:none}
.wu-aio3 .wu-aio3__panel{right:calc(100% - 1px);border-radius:26px 0 26px 26px;box-shadow:-24px 28px 60px -26px rgba(0,0,0,.95)!important;clip-path:circle(0 at 100% 50%)!important;opacity:1!important;transform:translateY(-50%)!important;transition:clip-path .85s cubic-bezier(.22,1,.36,1)!important}
.wu-aio3.is-open .wu-aio3__panel{clip-path:circle(160% at 100% 50%)!important}
@media (hover:hover){.wu-aio3:hover .wu-aio3__panel{clip-path:circle(160% at 100% 50%)!important}}
.wu-aio3 .wu-aio3__tab{transition:border-radius .5s ease,width .5s cubic-bezier(.22,1,.36,1),box-shadow .5s!important}
.wu-aio3.is-open .wu-aio3__tab{border-radius:0 0 0 0}
@media (hover:hover){.wu-aio3:hover .wu-aio3__tab{border-radius:0}}
.wu-aio3 .wu-aio3__cta{position:relative;overflow:hidden;width:100%;justify-content:space-between;min-height:52px!important;padding:0 8px 0 22px!important;border-radius:16px!important;font-size:15px!important}
.wu-aio3 .wu-aio3__cta span{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#11150a;color:#beda52;transition:transform .5s cubic-bezier(.34,1.56,.64,1)}
.wu-aio3 .wu-aio3__cta:hover span{transform:translateX(3px) rotate(-12deg)}
.wu-aio3 .wu-aio3__cta::after{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 30%,rgba(255,255,255,.45) 50%,transparent 70%);translate:-120% 0;transition:translate 1.1s ease}
.wu-aio3.is-open .wu-aio3__cta::after{translate:120% 0;transition-delay:.6s}
@media (hover:hover){.wu-aio3:hover .wu-aio3__cta::after{translate:120% 0;transition-delay:.6s}}
.wu-aio3 .wu-aio3__in>*{transition:opacity .5s ease,transform .7s cubic-bezier(.22,1,.36,1)!important}
.wu-aio3.is-open .wu-aio3__in>*{transition-delay:calc(.25s + var(--k,0)*.08s)!important}
@media (hover:hover){.wu-aio3:hover .wu-aio3__in>*{transition-delay:calc(.25s + var(--k,0)*.08s)!important}}
@media (prefers-reduced-motion:reduce){.wu-aio3 .wu-aio3__panel{transition:none!important}}
.wu-aio3 .wu-aio3__note{margin:0 0 14px;font-size:12.5px;color:#a7a7af}
@media (max-height:740px){.wu-aio3 .wu-aio3__panel,.wu-aio3.is-open .wu-aio3__panel{max-height:calc(100vh - 24px)!important;overflow-y:auto!important;overscroll-behavior:contain}}
@keyframes wu-aio3-p{0%,100%{transform:scale(1) rotate(0)}50%{transform:scale(1.2) rotate(14deg)}}
@keyframes wu-aio3-d{0%{transform:scale(1);opacity:1}100%{transform:scale(4);opacity:0}}
@media (max-width:640px){.wu-aio3__panel{width:min(310px,calc(100vw - 52px))}.wu-aio3__in{width:100%}}
@media (max-width:640px){
.wu-aio3{right:auto!important;left:12px;top:auto!important;bottom:14px;transform:translate(0,140%)!important;align-items:flex-end}
.wu-aio3.is-in,.wu-aio3:not(.is-js){transform:none!important}
.wu-aio3__tab,.wu-aio3 .wu-aio3__tab,.wu-aio3:hover .wu-aio3__tab,.wu-aio3.is-open .wu-aio3__tab{flex-direction:row;width:auto!important;height:46px;padding:0 16px 0 14px;gap:9px;border-radius:99px!important;box-shadow:0 10px 24px -10px rgba(0,0,0,.9),inset 0 0 0 1px rgba(255,255,255,.1)}
.wu-aio3__tab span{writing-mode:horizontal-tb;transform:none;font-size:12px;letter-spacing:.1em}
.wu-aio3 .wu-aio3__panel{position:fixed;left:12px;right:12px;bottom:70px;top:auto;width:auto;max-height:min(72vh,520px);border-radius:20px!important;clip-path:inset(100% 0 0 0 round 20px);transform:translateY(14px);transform-origin:50% 100%}
.wu-aio3.is-open .wu-aio3__panel{clip-path:inset(0 0 0 0 round 20px);transform:none}
.wu-aio3__in{width:100%}
}
@media (prefers-reduced-motion:reduce){.wu-aio3,.wu-aio3__panel{transition:none}.wu-aio3__tab svg,.wu-aio3__tab i{animation:none}}
</style>' . "\n";
		echo '<script>(function(){var q=function(){document.querySelectorAll(".wu-aio3").forEach(function(b){if(b.dataset.done)return;b.dataset.done=1;b.classList.add("is-js");var show=function(){b.classList.add("is-in");};var t=setTimeout(show,2500);addEventListener("scroll",function(){if(scrollY>240){clearTimeout(t);show();}},{passive:true,once:true});var tab=b.querySelector(".wu-aio3__tab");tab.addEventListener("click",function(){var o=b.classList.toggle("is-open");tab.setAttribute("aria-expanded",o?"true":"false");});document.addEventListener("click",function(e){if(!b.contains(e.target)){b.classList.remove("is-open");tab.setAttribute("aria-expanded","false");}});document.addEventListener("keydown",function(e){if(e.key==="Escape"){b.classList.remove("is-open");tab.setAttribute("aria-expanded","false");}});b.querySelectorAll(".wu-aio3__cta").forEach(function(c){c.addEventListener("click",function(){b.classList.remove("is-open");});});});};if(document.readyState!=="loading")q();else document.addEventListener("DOMContentLoaded",q);})();</script>' . "\n";
	}
	$spark  = '<svg viewBox="0 0 24 24" fill="#beda52" aria-hidden="true"><path d="M12 2c.6 5.4 4.6 9.4 10 10-5.4.6-9.4 4.6-10 10-.6-5.4-4.6-9.4-10-10 5.4-.6 9.4-4.6 10-10Z"/></svg>';
	$points = isset( $o['points'] ) ? $o['points'] : array();
	echo '<aside class="wu-aio3" aria-label="AI Overview">';
	echo '<div class="wu-aio3__panel" id="wu-aio3-panel"><div class="wu-aio3__in"><h2 class="wu-aio3__q">' . esc_html( $o['q'] ) . '</h2>';
	echo '<p class="wu-aio3__a">' . wp_kses( $o['a'], $allowed ) . '</p>';
	if ( $points ) {
		echo '<ul class="wu-aio3__pts">';
		foreach ( $points as $pt ) echo '<li><b>' . esc_html( $pt[0] ) . '.</b> ' . esc_html( $pt[1] ) . '</li>';
		echo '</ul>';
	}
	if ( ! empty( $o['note'] ) ) echo '<p class="wu-aio3__a wu-aio3__note">' . wp_kses( $o['note'], $allowed ) . '</p>';
	echo '<button type="button" class="wu-aio3__cta" data-lead-open>' . esc_html( isset( $o['cta'] ) ? $o['cta'] : 'Get our plan' ) . ' <span aria-hidden="true">&rarr;</span></button></div></div>';
	echo '<button type="button" class="wu-aio3__tab" aria-expanded="false" aria-controls="wu-aio3-panel">' . $spark . '<span>AI Overview</span><i aria-hidden="true"></i></button>'; // phpcs:ignore
	echo '</aside>' . "\n";
	echo '<script type="application/ld+json">' . wp_json_encode( array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebPage',
		'name'        => wp_strip_all_tags( $o['q'] ),
		'description' => wp_strip_all_tags( $o['a'] ),
		'speakable'   => array( '@type' => 'SpeakableSpecification', 'cssSelector' => array( '.wu-aio3__q', '.wu-aio3__a' ) ),
	) ) . "</script>\n";
}

/** Overview boxes for the generated pages (home, about, contact, podcast), inserted by wiseup_page_html(). */
function wiseup_page_overview( $slug ) {
	$o = array(
		'home'    => array(
			'q'      => 'What is WiseUp?',
			'a'      => '<b>WiseUp</b> is the branding and digital marketing agency of <b>CodeAce</b>, based in <b>Kozhikode (Calicut), Kerala</b>. We help founders, marketing heads and established businesses with brand strategy, web, SEO, performance and social media marketing, video and campaigns, and you see the plan before you see a price.',
			'points' => array(
				array( 'What we do', 'Brand strategy and identity, packaging design and events, web development, SEO, performance marketing, digital marketing, social media marketing, video and photography, and campaigns and media buying.' ),
				array( 'Who it is for', 'Founders, marketing heads and established businesses in Kerala, across India and the Gulf.' ),
				array( 'Track record', 'Eight years of engineering behind it (CodeAce), 120+ projects delivered and an audience of 3M+ reached.' ),
				array( 'How to start', 'Ask for a plan: you see the plan before you see a price.' ),
			),
			'links'  => array( array( 'Services', '#services' ), array( 'Our work', '#work' ), array( 'Process', '#process' ), array( 'FAQ', '#faq' ), array( 'Contact', '#contact' ) ),
		),
		'about'   => array(
			'q'      => 'Who is WiseUp?',
			'a'      => '<b>WiseUp</b> is a dedicated team focused on delivering innovative solutions that help businesses thrive in the digital world. We build lasting relationships with our clients, combining <b>creative expertise and technology</b> to create impactful services. WiseUp is the creative wing of <b>CodeAce</b>, a web engineering company with over eight years of experience.',
			'points' => array(
				array( 'Who we are', 'A team of creative and technical professionals in Kozhikode, Kerala.' ),
				array( 'Our expertise', 'Branding, digital marketing and web engineering working as one team.' ),
				array( 'Our values', 'Quality, creativity and long-term client relationships.' ),
			),
			'links'  => array( array( 'Who we are', '#who' ), array( 'Our expertise', '#expertise' ), array( 'Our values', '#values' ), array( 'Our team', '#team' ) ),
		),
		'contact' => array(
			'q'      => 'How can I contact WiseUp?',
			'a'      => 'The quickest way is <b>WhatsApp or a call on +91 62824 34503</b>. You can also email <b>brandingwithwiseup@gmail.com</b> or use the form on this page, which opens a WhatsApp message with your details. Our studio is at the Government Cyberpark, Nellikode, Kozhikode.',
			'points' => array(
				array( 'WhatsApp / call', '+91 62824 34503' ),
				array( 'Email', 'brandingwithwiseup@gmail.com' ),
				array( 'Visit', 'Sahya Building, Govt. Cyberpark, Nellikode, Kozhikode, Kerala 673016' ),
			),
			'links'  => array( array( 'Contact form', '#form' ) ),
		),
		'podcast' => array(
			'q'      => 'What is the WiseUp Podcast?',
			'a'      => 'The <b>WiseUp Podcast</b> is a Malayalam business and entrepreneur interview show on YouTube, hosted by <b>Jijin Mohan, Chethana and Sreerag</b>. It has <b>91K+ YouTube subscribers</b> and <b>100+ episodes</b> of real stories from founders and brands.',
			'points' => array(
				array( 'Watch', 'Featured and latest episodes, grouped by topic.' ),
				array( 'Get featured', 'Founders and brands can apply to be a guest on the show.' ),
				array( 'Sponsor the show', 'Sponsored episodes, Shorts and Reels, Instagram carousels and brand story episodes.' ),
			),
			'links'  => array( array( 'Featured', '#featured' ), array( 'Episodes', '#episodes' ), array( 'Hosts', '#hosts' ), array( 'Sponsor', '#sponsor' ), array( 'FAQ', '#faq' ) ),
		),
	);
	if ( ! isset( $o[ $slug ] ) ) return '';
	ob_start();
	wiseup_ai_overview( $o[ $slug ] );
	return ob_get_clean();
}

/** URL of the first published page using a given template, or '' (cached per request). */
if ( ! function_exists( 'wiseup_svc_page_url' ) ) {
	function wiseup_svc_page_url( $template ) {
		static $cache = array();
		if ( ! isset( $cache[ $template ] ) ) {
			$ids = get_posts( array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'meta_key'       => '_wp_page_template', // phpcs:ignore -- small, one-off lookup
				'meta_value'     => $template,           // phpcs:ignore
				'posts_per_page' => 1,
				'fields'         => 'ids',
			) );
			$cache[ $template ] = $ids ? get_permalink( $ids[0] ) : '';
		}
		return $cache[ $template ];
	}
}

/** Menu link for a service: its page if one is published, else '#'. */
function wiseup_svc_link( $templates, $fallback = '#' ) {
	foreach ( (array) $templates as $t ) {
		$u = wiseup_svc_page_url( $t );
		if ( $u ) return $u;
	}
	return $fallback;
}


/**
 * "Other services we provide": a carousel of the service pages that are live, on every service page
 * (owner, 2026-11-23: "other services we provide ennu oru section; ippo currently live ayittulla page mathram mathi, carousal pole").
 * A service shows when a published page uses its template (or it is known to be live on wiseup.in); the current page is left out,
 * so a new service page appears here by itself once it is published. Texts are short lines taken from each page's own copy.
 *
 * @param string $current Template key of the page being shown (e.g. 'wiseup-seo').
 */
function wiseup_other_services( $current = '' ) {
	$s = wiseup_settings();
	if ( empty( $s['os_enabled'] ) ) return;
	$icons = wiseup_os_icons();
	$cards = array();
	// a list saved in wp-admin replaces the defaults; fill its empty template / live-URL fields from the built-in item with the
	// same id, so a service that is live on wiseup.in still shows (live had Performance and Event Branding missing, 2026-11-24)
	$defs = array();
	foreach ( wiseup_os_default_items() as $d ) $defs[ $d['id'] ] = $d;
	foreach ( (array) $s['os_items'] as $it ) {
		$id = isset( $it['id'] ) ? $it['id'] : '';
		if ( $id && isset( $defs[ $id ] ) ) foreach ( array( 'tpl', 'live' ) as $f ) { if ( empty( $it[ $f ] ) && ! empty( $defs[ $id ][ $f ] ) ) $it[ $f ] = $defs[ $id ][ $f ]; }
		$mode = isset( $it['mode'] ) ? $it['mode'] : 'auto';
		if ( 'hide' === $mode || empty( $it['title'] ) ) continue;
		$tpls = array_filter( array_map( 'trim', explode( ',', isset( $it['tpl'] ) ? $it['tpl'] : '' ) ) );
		if ( $current && in_array( $current, $tpls, true ) ) continue; // a page leaves itself out
		$url = isset( $it['url'] ) ? trim( $it['url'] ) : '';
		if ( ! $url ) {
			foreach ( $tpls as $tp ) {
				if ( function_exists( 'wiseup_svc_page_url' ) ) $url = wiseup_svc_page_url( $tp );
				if ( $url ) break;
			}
		}
		if ( ! $url && ! empty( $it['live'] ) ) $url = $it['live'];
		if ( ! $url && 'show' === $mode ) $url = home_url( '/services/' );
		if ( ! $url ) continue; // auto: not live yet
		$cards[] = array( 'icon' => isset( $it['icon'], $icons[ $it['icon'] ] ) ? $icons[ $it['icon'] ] : $icons['star'], 'title' => $it['title'], 'text' => isset( $it['text'] ) ? $it['text'] : '', 'url' => $url );
	}
	$cards = apply_filters( 'wiseup_other_services', $cards, $current );
	if ( ! $cards ) return;
	static $css = false;
	if ( ! $css ) {
		$css = true;
		echo '<style>
.wu-os{padding-block:clamp(56px,6vw,96px);overflow-x:clip;color:#fff;font-family:Inter,system-ui,sans-serif}
.wu-os *{box-sizing:border-box}
.wu-os__in{width:min(100% - 2 * clamp(20px,3.4vw,56px),1480px);margin-inline:auto}
.wu-os__head{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:clamp(28px,3.2vw,48px)}
.wu-os__eb{display:inline-flex;align-items:center;gap:8px;margin:0 0 18px;padding:8px 16px 8px 12px;border-radius:99px;background:#0e0e10;box-shadow:inset 0 0 0 1px rgba(255,255,255,.1);font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#fff}
.wu-os__eb i{width:7px;height:7px;border-radius:50%;background:#beda52}
.wu-os__h{margin:0;font-size:clamp(30px,3.6vw,52px);font-weight:500;line-height:1.05;letter-spacing:-.04em;color:#fff;text-wrap:balance}
.wu-os__h span{display:block;color:#9a9aa2}
.wu-os__nav{display:flex;gap:10px;flex:none}
.wu-os__btn{display:grid;place-items:center;width:52px;height:52px;border:0;border-radius:50%;background:linear-gradient(145deg,#161618,#08080a);color:#fff;cursor:pointer;box-shadow:-5px -5px 14px rgba(255,255,255,.025),8px 10px 20px -8px rgba(0,0,0,.95),inset 0 0 0 1px rgba(255,255,255,.08);transition:color .3s,box-shadow .3s,opacity .3s}
.wu-os__btn:hover:not(:disabled){color:#beda52;box-shadow:-5px -5px 14px rgba(255,255,255,.03),8px 10px 20px -8px rgba(0,0,0,.95),inset 0 0 0 1px rgba(190,218,82,.55)}
.wu-os__btn:disabled{opacity:.3;cursor:default}
.wu-os__btn svg{width:20px;height:20px}
.wu-os__track{display:flex;gap:clamp(14px,1.6vw,22px);margin:0 calc(50% - 50vw);padding:6px max(clamp(20px,3.4vw,56px),calc((100vw - 1480px)/2 + clamp(20px,3.4vw,56px))) 30px;list-style:none;overflow-x:auto;scroll-snap-type:x mandatory;scroll-padding-inline:max(clamp(20px,3.4vw,56px),calc((100vw - 1480px)/2 + clamp(20px,3.4vw,56px)));scrollbar-width:none;cursor:grab;overscroll-behavior-x:contain}
.wu-os__track::-webkit-scrollbar{display:none}
.wu-os__track.is-drag{cursor:grabbing;scroll-snap-type:none}
.wu-os__track.is-drag a{pointer-events:none}
.wu-os__card{flex:0 0 min(400px,82vw);scroll-snap-align:start}
.wu-os__card a{position:relative;display:flex;flex-direction:column;gap:18px;height:100%;min-height:310px;padding:clamp(24px,2.2vw,32px);border-radius:28px;overflow:hidden;color:inherit;text-decoration:none;background:linear-gradient(150deg,#151517,#08080a);box-shadow:-8px -8px 20px rgba(255,255,255,.025),14px 18px 34px -12px rgba(0,0,0,.95),inset 0 0 0 1px rgba(255,255,255,.06);transition:translate .55s cubic-bezier(.2,.9,.2,1),box-shadow .5s}
.wu-os__card a::before{content:"";position:absolute;top:-45%;right:-35%;width:80%;aspect-ratio:1;border-radius:50%;background:radial-gradient(closest-side,rgba(190,218,82,.14),transparent);opacity:0;transition:opacity .6s}
.wu-os__card a:hover,.wu-os__card a:focus-visible{translate:0 -6px;box-shadow:-8px -8px 20px rgba(255,255,255,.03),20px 28px 44px -14px rgba(0,0,0,.98),inset 0 0 0 1px rgba(190,218,82,.5);outline:none}
.wu-os__card a:hover::before,.wu-os__card a:focus-visible::before{opacity:1}
.wu-os__ic{position:relative;display:grid;place-items:center;width:60px;height:60px;border-radius:19px;color:#beda52;background:linear-gradient(145deg,#1b1b1e,#09090b);box-shadow:-4px -4px 10px rgba(255,255,255,.03),6px 8px 16px -6px rgba(0,0,0,.95),inset 0 0 0 1px rgba(190,218,82,.22)}
.wu-os__ic svg{width:28px;height:28px;fill:none;stroke:currentColor;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
.wu-os__t{position:relative;margin:auto 0 0;font-size:clamp(24px,2.1vw,30px);font-weight:500;line-height:1.1;letter-spacing:-.03em;color:#fff}
.wu-os__p{position:relative;margin:0;font-size:15.5px;line-height:1.6;color:#a9a9b0}
.wu-os__go{position:relative;display:inline-flex;align-items:center;gap:12px;margin-top:6px;font-size:14px;font-weight:600;color:#e6e6ea}
.wu-os__go i{display:grid;place-items:center;width:40px;height:40px;border-radius:50%;color:#11150a;background:#beda52;transition:rotate .5s cubic-bezier(.2,.9,.2,1)}
.wu-os__go svg{width:16px;height:16px}
.wu-os__card a:hover .wu-os__go i{rotate:45deg}
@media (max-width:767px){.wu-os__head{flex-direction:column;align-items:flex-start}.wu-os__nav{display:none}.wu-os__h{font-size:clamp(27px,7.6vw,32px)}.wu-os__card{flex-basis:min(320px,80vw)}.wu-os__card a{min-height:280px}.wu-os__track{padding-bottom:20px}}
@media (prefers-reduced-motion:reduce){.wu-os__card a,.wu-os__go i{transition:none}}
/* 3 cards per row inside the page width (owner 2026-11-24); beats the page-layer overrides (service-system.css, media-buying.css) */
html body section.wu-os .wu-os__track{--os-g:22px;gap:var(--os-g)!important;margin:0!important;padding:6px 0 30px!important;scroll-padding-inline:0!important}
html body section.wu-os .wu-os__card{flex:0 0 calc((100% - 2 * var(--os-g)) / 3)!important}
@media (max-width:1023px){html body section.wu-os .wu-os__card{flex-basis:calc((100% - var(--os-g)) / 2)!important}}
@media (max-width:767px){html body section.wu-os .wu-os__track{--os-g:14px}html body section.wu-os .wu-os__card{flex-basis:86%!important}}
</style>';
	}
	$arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
	echo '<section class="wu-os" id="other-services" aria-labelledby="wu-os-h" data-wu-os><div class="wu-os__in" role="region" aria-roledescription="carousel" aria-label="' . esc_attr( $s['os_heading'] . ' ' . $s['os_heading2'] ) . '">';
	echo '<div class="wu-os__head"><div><p class="wu-os__eb"><i aria-hidden="true"></i>' . esc_html( $s['os_eyebrow'] ) . '</p><h2 class="wu-os__h" id="wu-os-h">' . esc_html( $s['os_heading'] ) . ( $s['os_heading2'] ? ' <span>' . esc_html( $s['os_heading2'] ) . '</span>' : '' ) . '</h2></div>';
	echo '<div class="wu-os__nav"><button type="button" class="wu-os__btn" data-os-prev aria-label="Previous services"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg></button><button type="button" class="wu-os__btn" data-os-next aria-label="Next services">' . $arrow . '</button></div></div>'; // phpcs:ignore
	echo '<ul class="wu-os__track" data-os-track>';
	foreach ( $cards as $c ) {
		echo '<li class="wu-os__card"><a href="' . esc_url( $c['url'] ) . '"><span class="wu-os__ic" aria-hidden="true"><svg viewBox="0 0 24 24">' . $c['icon'] . '</svg></span><h3 class="wu-os__t">' . esc_html( $c['title'] ) . '</h3><p class="wu-os__p">' . esc_html( $c['text'] ) . '</p><span class="wu-os__go">Explore service <i aria-hidden="true">' . $arrow . '</i></span></a></li>'; // phpcs:ignore
	}
	echo '</ul></div></section>';
	echo '<script>(function(){var w=document.querySelector("[data-wu-os]");if(!w)return;var t=w.querySelector("[data-os-track]"),pv=w.querySelector("[data-os-prev]"),nx=w.querySelector("[data-os-next]"),nav=w.querySelector(".wu-os__nav");
var step=function(){var c=t.querySelector(".wu-os__card");return c?c.getBoundingClientRect().width+parseFloat(getComputedStyle(t).columnGap||16):300};
var upd=function(){var m=t.scrollWidth-t.clientWidth;pv.disabled=t.scrollLeft<4;nx.disabled=t.scrollLeft>m-4;if(nav)nav.style.visibility=m<8?"hidden":"";};
pv.addEventListener("click",function(){t.scrollBy({left:-step(),behavior:"smooth"})});nx.addEventListener("click",function(){t.scrollBy({left:step(),behavior:"smooth"})});
t.addEventListener("scroll",upd,{passive:true});addEventListener("resize",upd);upd();
var d=0,x0=0,s0=0,moved=0;t.addEventListener("pointerdown",function(e){if(e.pointerType!=="mouse"||e.button)return;d=1;x0=e.clientX;s0=t.scrollLeft;moved=0});
addEventListener("pointermove",function(e){if(!d)return;var dx=e.clientX-x0;if(Math.abs(dx)>5){moved=1;t.classList.add("is-drag")}if(moved)t.scrollLeft=s0-dx});
addEventListener("pointerup",function(){if(!d)return;d=0;if(moved){var c=step(),n=Math.round(t.scrollLeft/c);t.classList.remove("is-drag");t.scrollTo({left:n*c,behavior:"smooth"})}});})();</script>'; // phpcs:ignore
}

/**
 * Output filter for service pages: adds target="_blank" rel="noopener" to links in the page body that go to another page.
 * Left alone: #anchors and links to a section of the same page, mailto/tel/sms/javascript links, links that already have a
 * target, popup buttons (data-lead-open), and anything inside <script> / <style>. Add data-same-tab to keep one in the tab.
 */
function wiseup_new_tab_links( $html ) {
	$cur  = rtrim( (string) get_permalink( get_queried_object_id() ), '/' );
	$bits = preg_split( '#(<script\b.*?</script>|<style\b.*?</style>)#is', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
	foreach ( $bits as $i => $bit ) {
		if ( 1 === $i % 2 ) continue; // a script or style block
		$bits[ $i ] = preg_replace_callback( '/<a\s[^>]*>/i', function ( $m ) use ( $cur ) {
			$tag = $m[0];
			if ( preg_match( '/\sdata-(lead-open|same-tab)\b/i', $tag ) ) return $tag;
			if ( ! preg_match( '/\shref\s*=\s*(["\'])(.*?)\1/is', $tag, $h ) ) return $tag;
			$href = trim( html_entity_decode( $h[2] ) );
			if ( '' === $href || preg_match( '/^(#|javascript:|mailto:|tel:|sms:|data:)/i', $href ) ) return $tag;
			$base = false !== strpos( $href, '#' ) ? substr( $href, 0, strpos( $href, '#' ) ) : $href;
			if ( $cur && rtrim( $base, '/' ) === $cur ) return $tag; // the same page
			if ( preg_match( '/\starget\s*=/i', $tag ) ) {
				if ( preg_match( '/\starget\s*=\s*(["\'])_blank\1/i', $tag ) && ! preg_match( '/\srel\s*=\s*(["\'])[^"\']*noopener/i', $tag ) ) {
					$tag = preg_match( '/\srel\s*=\s*(["\'])/i', $tag ) ? preg_replace( '/(\srel\s*=\s*(["\']))/i', '$1noopener ', $tag, 1 ) : substr( $tag, 0, -1 ) . ' rel="noopener">';
				}
				return $tag;
			}
			$add = ' target="_blank"';
			if ( preg_match( '/\srel\s*=\s*(["\'])/i', $tag ) ) {
				$tag = preg_replace( '/(\srel\s*=\s*(["\']))/i', '$1noopener ', $tag, 1 );
			} else {
				$add .= ' rel="noopener"';
			}
			return substr( $tag, 0, -1 ) . $add . '>';
		}, $bit );
	}
	return implode( '', $bits );
}
