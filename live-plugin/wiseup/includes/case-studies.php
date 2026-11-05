<?php
/**
 * Case studies listing (/case-studies/, the archive of the `case-studies` post type) drawn in the homepage design
 * (landing/case-studies.php, assets/css/case-studies.css), with the WiseUp header, footer and lead popup. Owner,
 * 2026-11-05: "build template for case-studies, using our homepage design system" → listing page only; each case
 * study keeps its own page. Turn off with add_filter( 'wiseup_case_studies_listing', '__return_false' ).
 */
defined( 'ABSPATH' ) || exit;

function wiseup_is_cs_list() {
	return ! is_admin() && is_post_type_archive( 'case-studies' ) && apply_filters( 'wiseup_case_studies_listing', true );
}

// every case study on one page, newest first (there are a handful; the filter chips work on the full set)
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! $q->is_post_type_archive( 'case-studies' ) ) return;
	if ( ! apply_filters( 'wiseup_case_studies_listing', true ) ) return;
	$q->set( 'posts_per_page', 60 );
	$q->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
} );

add_filter( 'template_include', function ( $template ) {
	return wiseup_is_cs_list() ? WISEUP_DIR . 'landing/case-studies.php' : $template;
}, 100 );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( wiseup_is_cs_list() ) $parts['title'] = __( 'Case Studies', 'wiseup' );
	return $parts;
} );

add_action( 'wp_head', function () {
	if ( ! wiseup_is_cs_list() ) return;
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/case-studies.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/case-studies.css' ) ) . "\">\n";
	if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) && ! defined( 'AIOSEO_VERSION' ) ) {
		echo '<meta name="description" content="' . esc_attr__( 'Case studies from WiseUp, the branding and marketing agency in Kozhikode, Kerala: restaurants, cafés, expos and space tech, from Kozhikode to the global.', 'wiseup' ) . "\">\n";
	}
}, 7 );

/**
 * Client, location and a one-line summary of a case study, read from its own content (the Kadence pages carry
 * "Client: …", "Location: …" lines and an "Overview" paragraph). Empty strings when a page has none.
 */
function wiseup_cs_meta( $post ) {
	$post = get_post( $post );
	$html = (string) $post->post_content;
	$line = function ( $label ) use ( $html ) {
		if ( preg_match( '/' . $label . '\s*:(?:\s|&nbsp;|\xC2\xA0|<[^>]+>)*([^<]{1,80})/iu', $html, $m ) ) {
			return trim( html_entity_decode( wp_strip_all_tags( $m[1] ), ENT_QUOTES, 'UTF-8' ), " \t\n\r\0\x0B\xC2\xA0" );
		}
		return '';
	};
	$summary = has_excerpt( $post ) ? get_the_excerpt( $post ) : '';
	if ( ! $summary && preg_match( '/Overview\s*(?:<[^>]+>\s*)*<\/(?:p|h\d|span|div)>.*?<(?:p|h\d)[^>]*>(.*?)<\/(?:p|h\d)>/isu', $html, $m ) ) {
		$summary = trim( html_entity_decode( wp_strip_all_tags( $m[1] ), ENT_QUOTES, 'UTF-8' ) );
	}
	return array(
		'client'   => $line( 'Client' ),
		'location' => $line( 'Location' ),
		'summary'  => wp_trim_words( $summary, 16, '…' ),
	);
}

/**
 * Results shown on a card's hover (the same figures as the homepage work rows and the social media page Results
 * section), keyed by the case study's slug: [ big figure, its label, [ [ figure, label ] … ] ].
 */
function wiseup_cs_stats() {
	return array(
		'golden-karak' => array( '2,060,559', 'views on a single Instagram Reel', array( array( '+160%', 'follower growth' ), array( '681', 'new followers gained' ), array( '75,600+', 'total views' ) ) ),
		'sathya-agencies-brand-launch-campaign-kerala' => array( '1M+', 'minimum reach on every video', array( array( '100+', 'videos in total' ), array( '6+', 'store launches' ), array( '5+', 'video formats' ) ) ),
		'indusgo'      => array( '10', 'campaign videos produced every month', array( array( '100K+', 'reach on several videos' ) ) ),
		'bootland'     => array( '21.6M+', 'impressions for a brand-new event', array( array( '2,000+', 'B2B leads' ), array( '2,500+', 'business walk-ins' ), array( '100%', 'stall occupancy' ) ) ),
		'erets'        => array( '9+', 'international media features within weeks of launch', array( array( '6+', 'global partners at launch' ), array( '3', 'continents' ), array( '12', 'weeks, discovery to live' ) ) ),
	);
}
