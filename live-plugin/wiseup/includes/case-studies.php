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
 * Homepage work row: case studies published in wp-admin that the hand-made tiles in generated/pages/home.php don't
 * cover yet, newest first (owner, 2026-11-19: "automatically add next adding case study"). Printed at the start of
 * each of the row's 3 loop sets; $copy > 0 = a hidden duplicate set (aria-hidden, not focusable). Needs a featured
 * image. Off with add_filter( 'wiseup_home_auto_cases', '__return_false' ).
 */
function wiseup_home_cs_tiles( $copy = 0 ) {
	static $posts = null;
	if ( ! apply_filters( 'wiseup_home_auto_cases', true ) || ! post_type_exists( 'case-studies' ) ) return;
	if ( null === $posts ) {
		$known = apply_filters( 'wiseup_home_known_cases', array( 'bootland', 'smokehouse', 'erets', 'indusgo', 'golden-karak',
			'sathya-agencies-brand-launch-campaign-kerala', 'eallisto-corporate-event-branding',
			'popees-brand-campaigns-creative-marketing', 'case-studies-formaa-living-branding', 'onesto' ) );
		$posts = array();
		foreach ( get_posts( array( 'post_type' => 'case-studies', 'post_status' => 'publish', 'numberposts' => 30, 'orderby' => 'date', 'order' => 'DESC' ) ) as $p ) {
			if ( ! in_array( $p->post_name, $known, true ) && has_post_thumbnail( $p ) ) $posts[] = $p;
		}
	}
	$stats = wiseup_cs_stats();
	foreach ( $posts as $p ) {
		$title = get_the_title( $p );
		$terms = get_the_terms( $p, 'case-study-category' );
		$cat   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
		$label = $title . ( $cat ? ', ' . $cat : '' ) . ': view case study';
		$img   = get_the_post_thumbnail( $p, 'large', array(
			'alt'      => trim( $title . ' ' . strtolower( $cat ) ) . ' by WiseUp',
			'sizes'    => '(max-width: 640px) 72vw, 35vw',
			'loading'  => 'lazy',
			'decoding' => 'async',
			'class'    => '',
		) );
		echo '<li class="rows__tile"' . ( $copy ? ' aria-hidden="true"' : '' ) . '><a class="rows__link" href="' . esc_url( get_permalink( $p ) ) . '"'
			. ( $copy ? ' tabindex="-1"' : '' ) . ' aria-label="' . esc_attr( $label ) . '">' . $img;
		if ( isset( $stats[ $p->post_name ] ) ) {
			$s = $stats[ $p->post_name ];
			echo '<span class="rows__stats" aria-hidden="true"><span class="rows__big"><b>' . esc_html( $s[0] ) . '</b><span>' . esc_html( $s[1] ) . '</span></span><span class="rows__mini">';
			foreach ( $s[2] as $m ) echo '<span><b>' . esc_html( $m[0] ) . '</b>' . esc_html( $m[1] ) . '</span>';
			echo '</span></span>';
		}
		echo "</a></li>\n";
	}
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

/**
 * A case study published, updated, unpublished or deleted changes the homepage work row (wiseup_home_cs_tiles()),
 * so the cached homepage and case studies listing are cleared then (owner, 2026-11-20: a new MyWear case study did
 * not show because WP Rocket kept serving the old homepage).
 */
function wiseup_cs_purge_cache( $post_id ) {
	if ( 'case-studies' !== get_post_type( $post_id ) || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) return;
	if ( function_exists( 'rocket_clean_home' ) ) rocket_clean_home();
	if ( function_exists( 'rocket_clean_post' ) ) {
		$front = (int) get_option( 'page_on_front' );
		if ( $front ) rocket_clean_post( $front );
	}
	if ( function_exists( 'rocket_clean_files' ) ) {
		$list = get_post_type_archive_link( 'case-studies' );
		if ( $list ) rocket_clean_files( array( $list ) );
	}
	do_action( 'wiseup_cs_cache_purged', $post_id );
}
add_action( 'transition_post_status', function ( $new, $old, $post ) {
	if ( 'publish' === $new || 'publish' === $old ) wiseup_cs_purge_cache( $post->ID );
}, 10, 3 );
add_action( 'before_delete_post', 'wiseup_cs_purge_cache' );

// Case studies: the content screenshots are 0.4-2 MB PNGs/JPGs in the Media library (the Onesto 1024px PNGs took 5 s each). Serve the plugin's WebP copies instead (about 40-80 KB at 1024px), matched by the images' own attachment ids (assets/case-studies/img/manifest.json: id => widths + alt), so no other page is touched (2026-11-24).
$wiseup_cs_webp = function ( $html ) {
	if ( false === strpos( $html, 'wp-image-' ) ) return $html;
	static $man = null;
	if ( null === $man ) {
		$raw = @file_get_contents( WISEUP_DIR . 'assets/case-studies/img/manifest.json' );
		$man = $raw ? json_decode( $raw, true ) : array();
		if ( ! is_array( $man ) ) $man = array();
	}
	if ( ! $man ) return $html;
	return preg_replace_callback( '/<img\b[^>]*>/i', function ( $m ) use ( $man ) {
		$tag = $m[0];
		if ( ! preg_match( '/\bwp-image-(\d+)\b/', $tag, $id ) || ! isset( $man[ $id[1] ] ) ) return $tag;
		$e    = $man[ $id[1] ];
		$base = WISEUP_URL . 'assets/case-studies/img/' . $id[1] . '-';
		$ws   = array_map( 'intval', $e['w'] );
		$src  = $ws[0];
		foreach ( $ws as $w ) if ( $w <= 1024 ) $src = $w;
		$set  = array();
		foreach ( $ws as $w ) $set[] = $base . $w . '.webp ' . $w . 'w';
		$tag  = preg_replace( '/\s(src|srcset|data-lazy-src|data-lazy-srcset)\s*=\s*"[^"]*"/i', '', $tag );
		if ( ! empty( $e['alt'] ) ) $tag = preg_replace( '/\salt\s*=\s*""/i', ' alt="' . esc_attr( $e['alt'] ) . '"', $tag );
		return preg_replace( '/^<img\b/i', '<img src="' . esc_url( $base . $src . '.webp' ) . '" srcset="' . esc_attr( implode( ', ', $set ) ) . '"', $tag );
	}, $html );
};
add_filter( 'the_content', $wiseup_cs_webp, 97 );
add_filter( 'render_block', $wiseup_cs_webp, 97 ); // Kadence image blocks

// Old Kadence "openform" modal on every single case study (a Kadence Pro modal element hooked into the footer: Wiso mascot + a Full name / Email / Phone / Services / Description form posting through Kadence, not into Wiseup > Leads). Nothing on the site links to #openform (checked live 2026-11-24), so it was never shown; it only added ~25 KB of hidden HTML and the modal + advanced-form scripts. Remove it; the site's own lead popup is the enquiry path (owner: "if it is the old form, remove it").
add_filter( 'kadence_blocks_pro_modal_footer_output', function ( $html ) {
	return ( false !== strpos( (string) $html, 'id="openform"' ) || false !== strpos( (string) $html, 'kb-adv-form-791-cpt-id' ) ) ? '' : $html;
}, 99 );
add_action( 'wp_print_footer_scripts', function () {
	if ( ! is_singular( 'case-studies' ) ) return;
	global $wp_scripts;
	if ( ! $wp_scripts instanceof WP_Scripts ) return;
	foreach ( $wp_scripts->queue as $handle ) {
		$src = isset( $wp_scripts->registered[ $handle ] ) ? (string) $wp_scripts->registered[ $handle ]->src : '';
		if ( false !== strpos( $src, 'kt-modal-init' ) || false !== strpos( $src, 'kb-advanced-form-block' ) ) wp_dequeue_script( $handle );
	}
}, 1 );
