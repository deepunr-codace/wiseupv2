<?php
/**
 * Renders every WiseUp page. The body comes from the build (generated/pages/{slug}.php); the header and footer are
 * the plugin's own parts, the theme's, or none, per page (see wiseup_part_source()).
 *
 * With the WiseUp (or no) header, <body> carries .wiseup-home, which the stylesheet is scoped to. With the theme's
 * header the page sits in a .wiseup-home div instead, so the theme's header keeps its own styling. Classic themes
 * print their header/footer through get_header()/get_footer(); block themes have no header.php, so this template
 * prints the document itself and renders the theme's "header"/"footer" template parts.
 */
defined( 'ABSPATH' ) || exit;

$wu_slug   = wiseup_page_slug();
$wu_header = wiseup_part_source( 'header' );
$wu_footer = wiseup_part_source( 'footer' );
$wu_block  = function_exists( 'wp_is_block_theme' ) && wp_is_block_theme();

// A block theme's header/footer are rendered before wp_head(), as WordPress itself does: blocks in them (e.g. the
// navigation) register script modules and styles while rendering, and the head has to know about those.
$wu_parts = array( 'header' => '', 'footer' => '' );
if ( $wu_block ) {
	foreach ( $wu_parts as $part => $html ) {
		if ( 'theme' === ( 'header' === $part ? $wu_header : $wu_footer ) ) {
			$wu_parts[ $part ] = do_blocks( '<!-- wp:template-part {"slug":"' . $part . '","tagName":"' . $part . '"} /-->' );
		}
	}
}

if ( 'theme' === $wu_header && ! $wu_block ) {
	get_header();
} else {
	?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	wp_body_open();
	if ( 'plugin' === $wu_header ) wiseup_part( 'header' );
	elseif ( 'theme' === $wu_header ) echo $wu_parts['header']; // phpcs:ignore -- rendered block markup
}
if ( 'theme' === $wu_header ) echo '<div class="wiseup-home wiseup-in-theme wiseup-page-' . esc_attr( $wu_slug ) . '">';

ob_start();
require WISEUP_DIR . 'generated/pages/' . $wu_slug . '.php';
echo wiseup_page_html( $wu_slug, ob_get_clean() ); // phpcs:ignore -- the generated page body, adjusted in render.php

if ( 'plugin' === $wu_footer ) wiseup_part( 'footer' );
if ( 'theme' === $wu_header ) echo '</div>';

if ( 'theme' === $wu_footer && ! $wu_block ) {
	get_footer();
} else {
	if ( 'theme' === $wu_footer ) echo $wu_parts['footer']; // phpcs:ignore -- rendered block markup
	wp_footer();
	echo "\n</body>\n</html>\n";
}
