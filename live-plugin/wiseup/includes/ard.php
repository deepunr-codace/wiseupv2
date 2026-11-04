<?php
/**
 * Agentic Resource Discovery (ARD) manifest (owner, 2026-11-04: Lighthouse "ARD manifest is invalid").
 *
 * The ARD spec (agenticresourcediscovery.org, v0.91) wants a JSON document with an `entries` array; each entry has an
 * `identifier` (urn:air:<domain>:[<namespace>:]<name>), a `displayName`, a `type` (a media type) and exactly one of
 * `url` or `data`. Lighthouse looks for it via robots.txt, then a <link rel="ard">, then /.well-known/ard.json.
 *
 * On wiseup.in the server answers /.well-known/ard.json with a Cloudflare 520, which Lighthouse counts as a manifest
 * that failed to load. So the manifest is served by WordPress's REST API (/wp-json/wiseup/v1/ard, which works there)
 * and linked from every front-end page with rel="ard"; /.well-known/ard.json is also answered when the request reaches
 * WordPress. Content: the site's own content feed (WordPress REST API) and an organisation profile built from the
 * plugin's settings (the same contact details, address and socials the header and footer print).
 */
defined( 'ABSPATH' ) || exit;

function wiseup_ard_manifest() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	$host = $host ? $host : 'wiseup.in';
	$home = home_url( '/' );

	$social = (array) wiseup_opt( 'social' );
	$email  = isset( $social['email'] ) ? $social['email'] : '';
	unset( $social['email'] );
	$same_as = array_values( array_filter( $social ) );

	$org = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'ProfessionalService',
		'name'        => 'WiseUp',
		'description' => 'Branding and digital marketing agency in Kozhikode, Kerala, the creative wing of CodeAce. Visitors see the plan before they see a price.',
		'url'         => $home,
		'telephone'   => (string) wiseup_opt( 'contact_phone' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => (string) wiseup_opt( 'contact_address' ),
			'addressLocality' => 'Kozhikode',
			'addressRegion'   => 'Kerala',
			'addressCountry'  => 'IN',
		),
		'parentOrganization' => array( '@type' => 'Organization', 'name' => 'CodeAce', 'url' => 'https://codeace.com/' ),
		'knowsAbout'  => array( 'Brand Strategy & Identity', 'Packaging Design & Events', 'Web Development', 'SEO Services', 'Performance Marketing', 'Digital Marketing', 'Social Media Marketing', 'Video & Photography', 'Campaigns & Media Buying' ),
		'sameAs'      => $same_as,
	);
	if ( $email ) $org['email'] = $email;

	return array(
		'entries' => array(
			array(
				'identifier'            => 'urn:air:' . $host . ':profile:agency',
				'displayName'           => 'WiseUp agency profile',
				'type'                  => 'application/ld+json',
				'description'           => 'Who WiseUp is, the services it offers and how to reach the team (phone, WhatsApp, email, office address).',
				'representativeQueries' => array(
					'branding and digital marketing agency in Kozhikode',
					'how do I contact WiseUp',
					'which services does WiseUp offer',
				),
				'tags'                  => array( 'branding', 'digital marketing', 'Kerala' ),
				'data'                  => $org,
			),
			array(
				'identifier'            => 'urn:air:' . $host . ':content:pages',
				'displayName'           => 'WiseUp website pages',
				'type'                  => 'application/json',
				'description'           => 'The published pages of the WiseUp website (services, case studies, podcast) as JSON from the WordPress REST API.',
				'representativeQueries' => array(
					'list the pages on the WiseUp website',
					'read WiseUp case studies',
				),
				'url'                   => rest_url( 'wp/v2/pages' ),
			),
		),
	);
}

function wiseup_ard_send() {
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Access-Control-Allow-Origin: *' );
	echo wp_json_encode( wiseup_ard_manifest(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	exit;
}

// /wp-json/wiseup/v1/ard
add_action( 'rest_api_init', function () {
	register_rest_route( 'wiseup/v1', '/ard', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			$r = new WP_REST_Response( wiseup_ard_manifest() );
			$r->header( 'Access-Control-Allow-Origin', '*' );
			return $r;
		},
	) );
} );

// /.well-known/ard.json, when the web server hands the request to WordPress
add_action( 'parse_request', function () {
	$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ); // phpcs:ignore
	if ( $path && '/.well-known/ard.json' === untrailingslashit( $path ) ) wiseup_ard_send();
}, 0 );

// <link rel="ard"> on every front-end page
add_action( 'wp_head', function () {
	// The REST address, not /.well-known/: on wiseup.in everything under /.well-known/ is answered by Cloudflare with a
	// 520 before WordPress runs (2026-11-04), and an advertised location that fails is a Lighthouse error. Lighthouse
	// gives a linked manifest 2 seconds; the live REST route answers in ~0.5-0.7s.
	echo '<link rel="ard" type="application/json" href="' . esc_url( apply_filters( 'wiseup_ard_href', rest_url( 'wiseup/v1/ard' ) ) ) . "\">\n";
}, 2 );
