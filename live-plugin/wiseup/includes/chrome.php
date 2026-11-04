<?php
/**
 * WiseUp header and footer on ordinary pages (owner, 2026-11-04).
 *
 * Pages built with the theme (e.g. WiseUp TV and WiseUp Studio: Kadence pages whose content is custom HTML, with the
 * theme's own header and footer switched off) can show the plugin's header and footer instead. A page gets them when
 * its slug is in the "chrome_pages" setting (default: wiseup-tv, wiseup-studio) or when "Use the WiseUp header &
 * footer" is ticked in its editor. The header is printed at wp_body_open, the footer just before the theme's own
 * wp_footer output, each inside a .wiseup-home wrapper so the plugin's stylesheet (scoped to .wiseup-home) styles them
 * without touching the page's own design. Same markup and small reset as the landing pages (includes/landing.php).
 */
defined( 'ABSPATH' ) || exit;

/** Whether the current request is a page that should get the plugin's header and footer. */
function wiseup_chrome_on() {
	static $on = null;
	if ( null !== $on ) return $on;
	$on = false;
	if ( is_admin() || ! is_page() ) return $on;
	$id = get_queried_object_id();
	if ( ! $id ) return $on;
	// the plugin's own templates and the landing pages print their own header and footer already
	if ( function_exists( 'wiseup_page_slug' ) && wiseup_page_slug() ) return $on;
	if ( function_exists( 'wiseup_landing_for' ) && wiseup_landing_for( $id ) ) return $on;
	if ( get_post_meta( $id, '_wiseup_chrome', true ) ) return ( $on = true );
	$slugs = array_filter( array_map( 'trim', explode( ',', (string) wiseup_opt( 'chrome_pages' ) ) ) );
	$post  = get_post( $id );
	return ( $on = $post && in_array( $post->post_name, $slugs, true ) );
}

add_action( 'wp_head', function () {
	if ( ! wiseup_chrome_on() ) return;
	echo '<link rel="stylesheet" href="' . esc_url( wiseup_versioned( 'css/wiseup.css' ) ) . "\">\n";
	echo "<style id=\"wiseup-chrome\">.wu-chrome .hd__theme{display:none}.wu-chrome.wiseup-in-theme{--head-h:0px}.wu-chrome .hd{z-index:2147483000}"
		. ".wu-chrome *,.wu-chrome *::before,.wu-chrome *::after{box-sizing:border-box}.wu-chrome :is(ul,ol){list-style:none;margin:0;padding:0}"
		. ".wu-chrome :is(p,h1,h2,h3){margin-top:0}.wu-chrome a{text-decoration:none;color:inherit}.wu-chrome button{font:inherit;color:inherit}"
		. ".wu-chrome .hd__menu,.wu-chrome .hd__menu:hover,.wu-chrome .hd__menu:focus,.wu-chrome .hd__menu:active{background:#0e0e10!important;color:#fff!important;border:0}"
		. ".wu-chrome-foot{position:relative;z-index:1}"
		// the theme styles every <button>/<a>: keep the header's own type and colours
		. ".wu-chrome .hd__link,.wu-chrome .hd__link--parent{font-size:14px;font-weight:500;line-height:1.71;color:#999;background:none;letter-spacing:normal;text-transform:none}"
		. ".wu-chrome .hd__link:hover,.wu-chrome .hd__item:hover>.hd__link--parent,.wu-chrome .hd__item:focus-within>.hd__link--parent{color:#fff}"
		// the page's own header and footer (inside its custom HTML) give way to the WiseUp ones
		. ".wu-has-chrome :is(.wiseup-tv,#wiseup-studio)>header.nav,.wu-has-chrome :is(.wiseup-tv,#wiseup-studio) footer.footer{display:none!important}"
		. "</style>\n";
	$plugin_css = file_get_contents( WISEUP_DIR . 'assets/css/plugin.css' );
	if ( false !== $plugin_css ) echo '<style id="wiseup-plugin-css">' . $plugin_css . "</style>\n"; // phpcs:ignore -- static plugin stylesheet
}, 20 );

add_filter( 'body_class', function ( $c ) {
	if ( wiseup_chrome_on() ) $c[] = 'wu-has-chrome';
	return $c;
} );

add_action( 'wp_body_open', function () {
	if ( ! wiseup_chrome_on() ) return;
	echo '<div class="wiseup-home wiseup-in-theme wu-chrome">';
	wiseup_part( 'header' );
	echo '</div>';
}, 5 );

add_action( 'wp_footer', function () {
	if ( ! wiseup_chrome_on() ) return;
	echo '<div class="wiseup-home wiseup-in-theme wu-chrome wu-chrome-foot">';
	wiseup_part( 'footer' );
	echo '</div>';
	?>
<script>
(function () {
	var btn = document.querySelector('.wu-chrome [data-menu-btn]'), panel = document.querySelector('.wu-chrome [data-menu]');
	if (btn && panel) {
		var set = function (o) { btn.setAttribute('aria-expanded', String(o)); panel.hidden = !o; };
		btn.addEventListener('click', function () { set(btn.getAttribute('aria-expanded') !== 'true'); });
		panel.addEventListener('click', function (e) { if (e.target.closest('[data-menu-link]')) set(false); });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) { set(false); btn.focus(); } });
	}
	// same header behaviour as the homepage: dark pill once scrolled, hides on scroll down, returns on scroll up
	var head = document.querySelector('.wu-chrome .hd');
	if (head) {
		var last = window.scrollY;
		var onS = function () {
			var y = window.scrollY;
			head.classList.add('is-docked'); // always on the dark backing: these pages can be light, and the logo is white
			if (y < 160 || y < last - 2) head.classList.remove('is-hidden');
			else if (y > last + 2 && !head.querySelector(':focus-visible')) head.classList.add('is-hidden');
			last = y;
		};
		onS();
		window.addEventListener('scroll', onS, { passive: true });
		head.addEventListener('focusin', function () { head.classList.remove('is-hidden'); });
	}
})();
</script>
<?php
}, 5 );

// The per-page switch, in the page editor's sidebar.
add_action( 'add_meta_boxes_page', function () {
	add_meta_box( 'wiseup-chrome', __( 'WiseUp header & footer', 'wiseup' ), function ( $post ) {
		wp_nonce_field( 'wiseup_chrome', 'wiseup_chrome_nonce' );
		printf( '<label><input type="checkbox" name="wiseup_chrome" value="1" %s> %s</label><p class="description">%s</p>',
			checked( (bool) get_post_meta( $post->ID, '_wiseup_chrome', true ), true, false ),
			esc_html__( 'Use the WiseUp header & footer on this page', 'wiseup' ),
			esc_html__( 'For pages built with the theme. Switch the theme\'s own header and footer off for this page to avoid two of each.', 'wiseup' ) );
	}, 'page', 'side' );
} );
add_action( 'save_post_page', function ( $id ) {
	if ( ! isset( $_POST['wiseup_chrome_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wiseup_chrome_nonce'] ) ), 'wiseup_chrome' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_page', $id ) ) return;
	if ( ! empty( $_POST['wiseup_chrome'] ) ) update_post_meta( $id, '_wiseup_chrome', 1 );
	else delete_post_meta( $id, '_wiseup_chrome' );
} );
