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
		'wiseup-performance-marketing' => array( 'performance-marketing.php', __( 'WiseUp: Performance Marketing (new)', 'wiseup' ), 'performance-marketing' ),
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
 * "AI Overview" box in the style of a search AI overview: a tinted card with the answer, bulleted key points,
 * "Show more" (a <details>, works without JavaScript) and jump links. The first two key points are always visible.
 * The page's own question is the heading and the answer sits directly under it (answer-first), the box is marked up
 * with speakable structured data, and the text is written from each page's own copy.
 *
 * $o: q (question), a (answer, <b> allowed), points (array of [label, text]), links (array of [label, #anchor]),
 *     fact (optional line, <b> allowed).
 */
function wiseup_ai_overview( $o ) {
	static $css = false;
	$allowed = array( 'b' => array(), 'strong' => array() );
	if ( ! $css ) {
		$css = true;
		echo '<style>
@property --wu-a{syntax:"<angle>";initial-value:0deg;inherits:false}
.wu-aio{max-width:1240px;margin:0 auto;padding:clamp(20px,2.6vw,36px) clamp(16px,3vw,24px) 0;font-family:"Google Sans",Inter,system-ui,sans-serif;font-size:15px;line-height:1.5;text-align:left}
.wu-aio *{box-sizing:border-box}
.wu-aio__in{position:relative;width:min(100%,800px);padding:18px 22px 16px;border-radius:24px;color:#e3e3e8;background:radial-gradient(120% 140% at 0% 0%,rgba(66,133,244,.20),transparent 55%),radial-gradient(110% 130% at 100% 100%,rgba(217,101,112,.14),transparent 60%),#171a22;box-shadow:inset 0 0 0 1px rgba(255,255,255,.08);isolation:isolate;overflow:hidden}
.wu-aio__in::before{content:"";position:absolute;inset:0;z-index:1;border-radius:inherit;padding:2px;pointer-events:none;background:conic-gradient(from var(--wu-a),#4285f4,#9b72f2,#d96570,#f6c65b,#4285f4);animation:wu-aio-spin 2.2s linear 2,wu-aio-fade 4.4s ease forwards;-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude}
.wu-aio__hd{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
.wu-aio__tag{display:inline-flex;align-items:center;gap:9px;font-size:15px;font-weight:500}
.wu-aio__tag svg{width:20px;height:20px;flex:none}
.wu-aio__tag b{font-weight:500;background:linear-gradient(90deg,#8ab4f8,#c58af9 45%,#f28b82 80%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
.wu-aio__info{display:inline-grid;place-items:center;width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:600;color:#9aa0a6;box-shadow:inset 0 0 0 1px rgba(154,160,166,.5)}
.wu-aio__q{margin:0 0 6px;font-size:clamp(16.5px,1.5vw,19px);font-weight:500;line-height:1.3;color:#fff}
.wu-aio__a{margin:0;font-size:15px;line-height:1.7;color:#e3e3e8}
.wu-aio__a b,.wu-aio__fact b,.wu-aio__pts b{color:#fff;font-weight:600}
.wu-aio.is-js .wu-aio__a .w{opacity:0}
.wu-aio.is-run .wu-aio__a .w{animation:wu-aio-w .4s ease both;animation-delay:calc(var(--i)*20ms)}
.wu-aio__pts{margin:10px 0 0;padding:0 0 0 20px;list-style:disc;font-size:14.5px;line-height:1.65;color:#d4d4da}
.wu-aio__pts li{margin:0 0 4px;padding-left:2px}
.wu-aio__pts li::marker{color:#8ab4f8}
.wu-aio__more{margin-top:8px}
.wu-aio__more>summary{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;min-height:42px;margin-top:6px;border-radius:99px;font-size:14px;font-weight:500;color:#8ab4f8;background:rgba(255,255,255,.04);box-shadow:inset 0 0 0 1px rgba(255,255,255,.14);cursor:pointer;list-style:none;transition:background .25s}
.wu-aio__more>summary::-webkit-details-marker{display:none}
.wu-aio__more>summary:hover{background:rgba(138,180,248,.12)}
.wu-aio__more>summary svg{width:14px;height:14px;transition:transform .3s}
.wu-aio__more[open]>summary svg{transform:rotate(180deg)}
.wu-aio__more>summary .s-less{display:none}
.wu-aio__more[open]>summary .s-more{display:none}
.wu-aio__more[open]>summary .s-less{display:inline}
.wu-aio__more .wu-aio__pts{margin-top:12px}
.wu-aio__srcs{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:14px}
.wu-aio__srcs span{font-size:12.5px;color:#9aa0a6}
.wu-aio__srcs a{padding:7px 13px;border-radius:12px;font-size:13px;color:#d6d6dc;text-decoration:none;background:rgba(255,255,255,.06);box-shadow:inset 0 0 0 1px rgba(255,255,255,.08);transition:background .25s,color .25s}
.wu-aio__srcs a:hover{background:rgba(138,180,248,.18);color:#fff}
.wu-aio__ft{display:flex;flex-wrap:wrap;align-items:center;gap:8px 14px;margin-top:14px}
.wu-aio__fact{font-size:13.5px;color:#a4a4ac}
.wu-aio__cta{display:inline-flex;align-items:center;gap:6px;min-height:36px;padding:0 16px;border:0;border-radius:99px;font:inherit;font-size:13.5px;font-weight:600;color:#11150a;background:#beda52;cursor:pointer;transition:background .25s}
.wu-aio__cta:hover{background:#d8ec8a}
@keyframes wu-aio-spin{to{--wu-a:360deg}}
@keyframes wu-aio-fade{0%,60%{opacity:1}100%{opacity:.22}}
@keyframes wu-aio-w{from{opacity:0;filter:blur(3px)}to{opacity:1;filter:none}}
@media (prefers-reduced-motion:reduce){.wu-aio__in::before{animation:none;opacity:.3}.wu-aio.is-js .wu-aio__a .w{opacity:1}}
</style>' . "\n";
		echo '<script>(function(){var q=function(){var bs=document.querySelectorAll(".wu-aio");if(!bs.length)return;var rm=matchMedia("(prefers-reduced-motion: reduce)").matches;bs.forEach(function(b){if(rm||b.dataset.done)return;b.dataset.done=1;var a=b.querySelector(".wu-aio__a"),n=0;(function walk(el){[].slice.call(el.childNodes).forEach(function(c){if(c.nodeType===3){var f=document.createDocumentFragment();c.textContent.split(/(\s+)/).forEach(function(t){if(!t)return;if(/^\s+$/.test(t)){f.appendChild(document.createTextNode(t));}else{var s=document.createElement("span");s.className="w";s.style.setProperty("--i",n++);s.textContent=t;f.appendChild(s);}});c.parentNode.replaceChild(f,c);}else if(c.nodeType===1){walk(c);}});})(a);b.classList.add("is-js");var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){b.classList.add("is-run");io.disconnect();}});},{threshold:.35});io.observe(b);});};if(document.readyState!=="loading")q();else document.addEventListener("DOMContentLoaded",q);})();</script>' . "\n";
	}
	$spark = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><defs><linearGradient id="wu-aio-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#4285f4"/><stop offset=".55" stop-color="#9b72f2"/><stop offset="1" stop-color="#d96570"/></linearGradient></defs><path d="M12 2c.6 5.4 4.6 9.4 10 10-5.4.6-9.4 4.6-10 10-.6-5.4-4.6-9.4-10-10 5.4-.6 9.4-4.6 10-10Z" fill="url(#wu-aio-g)"/></svg>';
	$chev  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
	$points = isset( $o['points'] ) ? $o['points'] : array();
	$links  = isset( $o['links'] ) ? $o['links'] : array();
	$li     = function ( $pt ) { return '<li><b>' . esc_html( $pt[0] ) . '.</b> ' . esc_html( $pt[1] ) . '</li>'; };
	echo '<section class="wu-aio" aria-label="AI Overview"><div class="wu-aio__in">';
	echo '<div class="wu-aio__hd"><span class="wu-aio__tag">' . $spark . '<b>AI Overview</b></span><span class="wu-aio__info" aria-hidden="true">i</span></div>'; // phpcs:ignore
	echo '<h2 class="wu-aio__q">' . esc_html( $o['q'] ) . '</h2>';
	echo '<p class="wu-aio__a">' . wp_kses( $o['a'], $allowed ) . '</p>';
	if ( $points ) {
		echo '<ul class="wu-aio__pts">' . implode( '', array_map( $li, array_slice( $points, 0, 2 ) ) ) . '</ul>'; // phpcs:ignore
	}
	echo '<details class="wu-aio__more"><summary><span class="s-more">Show more</span><span class="s-less">Show less</span>' . $chev . '</summary>'; // phpcs:ignore
	if ( count( $points ) > 2 ) {
		echo '<ul class="wu-aio__pts">' . implode( '', array_map( $li, array_slice( $points, 2 ) ) ) . '</ul>'; // phpcs:ignore
	}
	if ( $links ) {
		echo '<div class="wu-aio__srcs"><span>On this page</span>';
		foreach ( $links as $ln ) echo '<a href="' . esc_attr( $ln[1] ) . '">' . esc_html( $ln[0] ) . '</a>';
		echo '</div>';
	}
	echo '<div class="wu-aio__ft">';
	if ( ! empty( $o['fact'] ) ) echo '<span class="wu-aio__fact">' . wp_kses( $o['fact'], $allowed ) . '</span>';
	echo '<button type="button" class="wu-aio__cta" data-lead-open>Get our plan <span aria-hidden="true">&rarr;</span></button>';
	echo '</div></details></div></section>' . "\n";
	// Structured data: the question as the section name, the answer as its description, both marked as speakable.
	echo '<script type="application/ld+json">' . wp_json_encode( array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebPage',
		'name'        => wp_strip_all_tags( $o['q'] ),
		'description' => wp_strip_all_tags( $o['a'] ),
		'speakable'   => array( '@type' => 'SpeakableSpecification', 'cssSelector' => array( '.wu-aio__q', '.wu-aio__a' ) ),
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
