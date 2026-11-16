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
		'wiseup-performance'  => array( 'performance.php', __( 'WiseUp: Performance Marketing', 'wiseup' ), 'performance' ),
		'wiseup-services'     => array( 'services.php', __( 'WiseUp: Services', 'wiseup' ), 'services' ),
		'wiseup-tv'           => array( 'wiseup-tv.php', __( 'WiseUp: TV', 'wiseup' ), 'wiseup-tv' ),
		'wiseup-studio'       => array( 'wiseup-studio.php', __( 'WiseUp: Studio', 'wiseup' ), 'wiseup-studio' ),
		'wiseup-event-branding' => array( 'event-branding.php', __( 'WiseUp: Event Branding', 'wiseup' ), 'event-branding' ),
		'wiseup-digital-marketing' => array( 'digital-marketing.php', __( 'WiseUp: Digital Marketing', 'wiseup' ), 'digital-marketing' ),
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
}

/**
 * The WiseUp header and footer's stylesheet and the few resets they need inside a landing page's own design. Call it
 * before wp_head(). Used by wiseup_landing_open() and by the landing pages that print their own document (SEO,
 * performance marketing).
 */
function wiseup_landing_chrome_styles() {
	add_action( 'wp_head', function () {
		echo '<link rel="stylesheet" href="' . esc_url( wiseup_versioned( 'css/wiseup.css' ) ) . "\">\n";
		echo "<style>.wu-chrome .hd__theme{display:none}.wu-chrome.wiseup-in-theme{--head-h:0px}.wu-chrome .hd{z-index:2147483000}.wu-chrome *,.wu-chrome *::before,.wu-chrome *::after{box-sizing:border-box}.wu-chrome :is(ul,ol){list-style:none;margin:0;padding:0}.wu-chrome :is(p,h1,h2,h3){margin-top:0}.wu-chrome a{text-decoration:none}.wu-chrome button{font:inherit;color:inherit}.wu-chrome .hd__menu{font-size:14px;font-weight:500;line-height:normal}.wu-chrome a{color:inherit}.wu-chrome .hd__menu,.wu-chrome .hd__menu:hover,.wu-chrome .hd__menu:focus,.wu-chrome .hd__menu:active{background:#0e0e10!important;color:#fff!important;border:0}</style>\n";
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
 * Quick-overview box for service pages (answer-first summary, like a search "AI overview"): a question,
 * a short answer, key points and an optional fact line. Text comes from each page's own copy.
 *
 * @param string   $question Heading, written as the question the page answers.
 * @param string   $answer   Two or three sentences.
 * @param string[] $points   Short key points (chips).
 * @param string   $fact     Optional one-line fact, e.g. "Packages start at ₹60,000".
 */
function wiseup_ai_overview( $question, $answer, $points = array(), $fact = '' ) {
	static $css = false;
	if ( ! $css ) {
		$css = true;
		echo '<style>
.wu-aio{max-width:1240px;margin:0 auto;padding:clamp(28px,4vw,56px) clamp(16px,3vw,24px) 0;font-family:Inter,system-ui,sans-serif}
.wu-aio__in{position:relative;display:grid;gap:18px;padding:clamp(22px,3vw,36px);border-radius:28px;color:#fff;background:linear-gradient(160deg,#121214,#0a0a0b);isolation:isolate;overflow:hidden}
.wu-aio__in::before{content:"";position:absolute;inset:0;z-index:-1;border-radius:inherit;padding:1.5px;background:linear-gradient(120deg,#beda52,#4285f4 35%,#9b72f2 60%,#beda52);background-size:200% 200%;animation:wu-aio-b 8s linear infinite;-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude}
.wu-aio__in::after{content:"";position:absolute;z-index:-1;right:-80px;top:-80px;width:320px;height:320px;border-radius:50%;background:radial-gradient(closest-side,rgba(155,114,242,.16),transparent)}
.wu-aio__tag{display:inline-flex;align-items:center;gap:8px;width:max-content;font-size:13px;font-weight:600;letter-spacing:.02em;color:#d8ec8a}
.wu-aio__tag svg{width:18px;height:18px}
.wu-aio__q{margin:0;font-size:clamp(22px,2.4vw,32px);font-weight:500;line-height:1.2;letter-spacing:-.025em;color:#fff}
.wu-aio__a{margin:0;max-width:78ch;font-size:clamp(16px,1.25vw,18px);line-height:1.7;color:#d4d4da}
.wu-aio__pts{display:flex;flex-wrap:wrap;gap:8px;margin:2px 0 0;padding:0;list-style:none}
.wu-aio__pts li{padding:8px 14px;border-radius:99px;font-size:14px;color:#e8e8ec;background:rgba(255,255,255,.06);box-shadow:inset 0 0 0 1px rgba(255,255,255,.1)}
.wu-aio__ft{display:flex;flex-wrap:wrap;align-items:center;gap:14px 20px;margin-top:4px}
.wu-aio__fact{font-size:14px;color:#a4a4ac}
.wu-aio__fact b{color:#fff;font-weight:600}
.wu-aio__cta{display:inline-flex;align-items:center;gap:8px;min-height:44px;padding:0 20px;border:0;border-radius:99px;font:inherit;font-size:14.5px;font-weight:600;color:#11150a;background:#beda52;cursor:pointer;transition:background .25s}
.wu-aio__cta:hover{background:#d8ec8a}
@keyframes wu-aio-b{to{background-position:200% 0}}
@media (prefers-reduced-motion:reduce){.wu-aio__in::before{animation:none}}
</style>' . "\n";
	}
	$spark = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><defs><linearGradient id="wu-aio-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#4285f4"/><stop offset=".55" stop-color="#9b72f2"/><stop offset="1" stop-color="#d96570"/></linearGradient></defs><path d="M12 2c.6 5.4 4.6 9.4 10 10-5.4.6-9.4 4.6-10 10-.6-5.4-4.6-9.4-10-10 5.4-.6 9.4-4.6 10-10Z" fill="url(#wu-aio-g)"/></svg>';
	echo '<section class="wu-aio" aria-label="' . esc_attr( $question ) . '"><div class="wu-aio__in">';
	echo '<span class="wu-aio__tag">' . $spark . 'Quick overview</span>'; // phpcs:ignore
	echo '<h2 class="wu-aio__q">' . esc_html( $question ) . '</h2>';
	echo '<p class="wu-aio__a">' . esc_html( $answer ) . '</p>';
	if ( $points ) {
		echo '<ul class="wu-aio__pts">';
		foreach ( $points as $pt ) echo '<li>' . esc_html( $pt ) . '</li>';
		echo '</ul>';
	}
	echo '<div class="wu-aio__ft">';
	if ( $fact ) echo '<span class="wu-aio__fact">' . wp_kses( $fact, array( 'b' => array() ) ) . '</span>';
	echo '<button type="button" class="wu-aio__cta" data-lead-open>Get our plan <span aria-hidden="true">&rarr;</span></button>';
	echo '</div></div></section>' . "\n";
}
