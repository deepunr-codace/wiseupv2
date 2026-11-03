<?php
/**
 * Page templates: the plugin adds four templates to every page's Template dropdown and renders those pages itself
 * (templates/page.php), so nothing is copied into the theme and the pages survive a theme switch.
 */
defined( 'ABSPATH' ) || exit;

/** Template key (stored in the page's _wp_page_template meta) => [ page slug in generated/pages, label ]. */
function wiseup_templates() {
	return array(
		'wiseup-home'    => array( 'home', __( 'WiseUp: Home', 'wiseup' ) ),
		'wiseup-about'   => array( 'about', __( 'WiseUp: About', 'wiseup' ) ),
		'wiseup-contact' => array( 'contact', __( 'WiseUp: Contact', 'wiseup' ) ),
		'wiseup-podcast' => array( 'podcast', __( 'WiseUp: Podcast', 'wiseup' ) ),
	);
}

add_filter( 'theme_page_templates', function ( $templates ) {
	foreach ( wiseup_templates() as $key => $t ) $templates[ $key ] = $t[1];
	return $templates;
} );

/** The current request's WiseUp page slug (home, about, …), or null when it isn't a WiseUp page. */
function wiseup_page_slug() {
	if ( ! is_singular( 'page' ) ) return null;
	$key = get_page_template_slug( get_queried_object_id() );
	$map = wiseup_templates();
	return isset( $map[ $key ] ) ? $map[ $key ][0] : null;
}

add_filter( 'template_include', function ( $template ) {
	return wiseup_page_slug() ? WISEUP_DIR . 'templates/page.php' : $template;
}, 99 );

// ---------- Header / footer source, per page with a global default ----------

const WISEUP_PART_META = array( 'header' => '_wiseup_header', 'footer' => '_wiseup_footer' );

/** 'plugin', 'theme' or 'none' for this page's header or footer. */
function wiseup_part_source( $part, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_queried_object_id();
	$own = get_post_meta( $post_id, WISEUP_PART_META[ $part ], true );
	$value = in_array( $own, array( 'plugin', 'theme', 'none' ), true ) ? $own : wiseup_opt( $part . '_source' );
	return in_array( $value, array( 'plugin', 'theme', 'none' ), true ) ? $value : 'plugin';
}

add_action( 'add_meta_boxes_page', function () {
	add_meta_box( 'wiseup-parts', __( 'WiseUp header & footer', 'wiseup' ), 'wiseup_parts_box', 'page', 'side' );
} );

function wiseup_parts_box( $post ) {
	wp_nonce_field( 'wiseup_parts', 'wiseup_parts_nonce' );
	$choices = array(
		''       => __( 'Default (Wiseup → General)', 'wiseup' ),
		'plugin' => __( 'WiseUp', 'wiseup' ),
		'theme'  => __( "Theme's own", 'wiseup' ),
		'none'   => __( 'None', 'wiseup' ),
	);
	echo '<p class="description">' . esc_html__( 'Used when this page has a WiseUp template.', 'wiseup' ) . '</p>';
	foreach ( WISEUP_PART_META as $part => $meta ) {
		$current = get_post_meta( $post->ID, $meta, true );
		printf( '<p><label for="wiseup-%1$s"><strong>%2$s</strong></label><br><select id="wiseup-%1$s" name="wiseup_%1$s" style="width:100%%">', esc_attr( $part ), 'header' === $part ? esc_html__( 'Header', 'wiseup' ) : esc_html__( 'Footer', 'wiseup' ) );
		foreach ( $choices as $value => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $current, $value, false ), esc_html( $label ) );
		}
		echo '</select></p>';
	}
}

add_action( 'save_post_page', function ( $post_id ) {
	if ( ! isset( $_POST['wiseup_parts_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wiseup_parts_nonce'] ) ), 'wiseup_parts' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_page', $post_id ) ) return;
	foreach ( WISEUP_PART_META as $part => $meta ) {
		$value = isset( $_POST[ 'wiseup_' . $part ] ) ? sanitize_key( wp_unslash( $_POST[ 'wiseup_' . $part ] ) ) : '';
		if ( in_array( $value, array( 'plugin', 'theme', 'none' ), true ) ) update_post_meta( $post_id, $meta, $value );
		else delete_post_meta( $post_id, $meta );
	}
} );

// ---------- Body classes ----------
// With the WiseUp (or no) header the template prints <body> itself and the body carries .wiseup-home, which the
// stylesheet is scoped to. With the theme's header the theme prints <body>, so .wiseup-home goes on a wrapper div
// instead (templates/page.php) and the page's own styles stay inside it.
add_filter( 'body_class', function ( $classes ) {
	$slug = wiseup_page_slug();
	if ( ! $slug ) return $classes;
	$classes[] = 'wiseup-page-' . $slug;
	if ( 'theme' !== wiseup_part_source( 'header' ) ) $classes[] = 'wiseup-home';
	if ( 'none' === wiseup_part_source( 'header' ) ) $classes[] = 'wiseup-no-header';
	return $classes;
} );

// ---------- Style isolation ----------
// When the page uses neither the theme's header nor its footer, nothing of the theme is on it, so none of the
// theme's (or other plugins') CSS should be either: dequeue every stylesheet queued for the request (the admin bar's
// own CSS stays, so logged-in users keep a working toolbar), plus WP's theme.json global styles and the Customizer's
// Additional CSS, which are printed outside the queue. With a theme header or footer those styles are needed, so
// they're left alone and our CSS stays scoped to .wiseup-home.
add_action( 'template_redirect', function () {
	if ( ! wiseup_page_slug() || 'theme' === wiseup_part_source( 'header' ) || 'theme' === wiseup_part_source( 'footer' ) ) return;
	$dequeue = function () {
		global $wp_styles;
		if ( ! $wp_styles instanceof WP_Styles ) return;
		foreach ( $wp_styles->queue as $handle ) {
			if ( ! in_array( $handle, array( 'admin-bar', 'dashicons' ), true ) ) wp_dequeue_style( $handle );
		}
	};
	add_action( 'wp_enqueue_scripts', $dequeue, 100 );
	add_action( 'wp_print_styles', $dequeue, 0 );
	add_action( 'wp_footer', $dequeue, 0 );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
	remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
	remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
} );

// ---------- Title & description ----------
// Without an SEO plugin, WiseUp pages use the site's own crafted titles and descriptions (from the Astro build);
// with one, the SEO plugin is left in charge of both.
function wiseup_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

add_filter( 'pre_get_document_title', function ( $title ) {
	$slug = wiseup_page_slug();
	if ( ! $slug || wiseup_has_seo_plugin() ) return $title;
	$page = wiseup_manifest_page( $slug );
	return $page ? html_entity_decode( $page['title'], ENT_QUOTES, 'UTF-8' ) : $title;
}, 20 );
