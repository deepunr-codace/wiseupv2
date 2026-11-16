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
.wu-aio3__tab i{width:6px;height:6px;border-radius:50%;background:#beda52;box-shadow:0 0 0 0 rgba(190,218,82,.6);animation:wu-aio3-d 2.4s ease-out infinite}
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
@keyframes wu-aio3-p{0%,100%{transform:scale(1) rotate(0)}50%{transform:scale(1.2) rotate(14deg)}}
@keyframes wu-aio3-d{0%{box-shadow:0 0 0 0 rgba(190,218,82,.6)}100%{box-shadow:0 0 0 9px rgba(190,218,82,0)}}
@media (max-width:640px){.wu-aio3__panel{width:min(310px,calc(100vw - 52px))}.wu-aio3__in{width:100%}}
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
	echo '<button type="button" class="wu-aio3__cta" data-lead-open>Get our plan <span aria-hidden="true">&rarr;</span></button></div></div>';
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
