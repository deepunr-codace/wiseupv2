<?php
/**
 * 404 page: a WiseUp-designed "page not found" with the header and footer, search and the main places to go.
 * Front-end 404s only (never admin, REST, feeds or AJAX). Filter `wiseup_404_page` turns it off.
 */
defined( 'ABSPATH' ) || exit;

function wiseup_is_404_page() {
	return ! is_admin() && is_404() && apply_filters( 'wiseup_404_page', true );
}
add_filter( 'template_include', function ( $template ) {
	return wiseup_is_404_page() ? WISEUP_DIR . 'landing/error-404.php' : $template;
}, 100 );
add_filter( 'document_title_parts', function ( $parts ) {
	if ( wiseup_is_404_page() ) $parts['title'] = __( 'Page not found', 'wiseup' );
	return $parts;
} );
add_action( 'wp_head', function () {
	if ( ! wiseup_is_404_page() ) return;
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/error-404.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/error-404.css' ) ) . "\">\n";
	echo '<meta name="robots" content="noindex, follow">' . "\n";
}, 7 );
