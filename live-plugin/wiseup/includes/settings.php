<?php
/**
 * Settings: one option array (`wiseup_settings`) merged over these defaults, so a fresh install renders exactly like
 * the Astro site. The defaults mirror wiseup-site/src (data/site.ts, Header.astro, Footer.astro); keep them in sync.
 */
defined( 'ABSPATH' ) || exit;

const WISEUP_OPTION = 'wiseup_settings';

/** Social networks in display order. Label is shown in the admin and used as the link's aria-label. */
function wiseup_networks() {
	return array(
		'whatsapp'  => 'WhatsApp',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'behance'   => 'Behance',
		'pinterest' => 'Pinterest',
		'youtube'   => 'YouTube',
		'email'     => 'Email',
	);
}

function wiseup_defaults() {
	return array(
		// General
		'default_theme'       => 'dark',     // dark | light: what a first-time visitor sees
		'header_source'       => 'plugin',   // plugin | theme | none (pages can override)
		'footer_source'       => 'plugin',
		'lead_popup'          => 1,          // the floating "Get a free plan" button + popup form
		'enquiry_email'       => '',         // '' = the site admin email
		// Header
		'theme_toggle'        => 1,
		'logo'                => '',         // '' = the bundled WiseUp mark
		'podcast_logo'        => '',         // '' = the bundled WiseUp Podcast mark
		'cta_label'           => 'Get our plan',
		'cta_url'             => '',         // '' = each page's own target (the contact form)
		'podcast_subscribe'   => 1,          // the podcast page's YouTube subscribe pill instead of the CTA
		'subscribe_url'       => 'https://www.youtube.com/@WiseUpPodcast_?sub_confirmation=1',
		'subscribe_count'     => '91K',
		// Footer
		'footer_tagline'      => 'Your gateway to inspiration and growth. Where ideas ignite and dreams take flight!',
		'footer_h_quick'      => 'Quick Links',
		'footer_h_services'   => 'Services',
		'chrome_pages'        => 'wiseup-tv, wiseup-studio', // theme pages that get the WiseUp header & footer (includes/chrome.php)
		'contact_page'        => '/contact/',   // the header's phone button
		'contact_phone'       => '+91 62824 34503',
		'contact_phone_href'  => 'tel:+916282434503',
		// Street address as given by the owner (2026-11-03).
		'contact_address'     => 'Third Floor, Sahya Building Govt. Cyberpark, Nellikkode, Kozhikode, Kerala 673016',
		'contact_map'         => 'https://www.google.com/maps/search/?api=1&query=Sahya+Building+Govt+Cyberpark+Nellikkode+Kozhikode',
		'footer_h_useful'     => 'Useful Links',
		'footer_h_follow'     => 'Follow Us',
		'follow_text'         => 'Follow WiseUp for brand stories, campaign launches and a look inside the studio.',
		'follow_text_podcast' => 'Fresh conversations every week. Follow along.',
		'channel_card'        => 1,          // the podcast page's YouTube channel card
		'channel_name'        => 'WiseUp Podcast',
		'channel_handle'      => '@WiseUpPodcast_',
		'channel_url'         => 'https://www.youtube.com/@WiseUpPodcast_',
		'social'              => array(
			'whatsapp'  => 'https://wa.me/916282434503',
			'instagram' => 'https://www.instagram.com/branding_with_wiseup/',
			'linkedin'  => 'https://www.linkedin.com/company/wiseup-marketing-agency/',
			'behance'   => 'https://www.behance.net/brandingwithwiseup',
			'pinterest' => 'https://in.pinterest.com/brandingwithwiseup/',
			'youtube'   => 'https://www.youtube.com/@Brandingwithwiseup',
			'email'     => 'brandingwithwiseup@gmail.com',
		),
		'social_podcast'      => array(
			'whatsapp'  => 'https://wa.me/916282434503',
			'instagram' => 'https://www.instagram.com/wiseuppod/',
			'linkedin'  => 'https://www.linkedin.com/company/wiseup-marketing-agency/',
			'behance'   => '',
			'pinterest' => '',
			'youtube'   => 'https://www.youtube.com/@WiseUpPodcast_',
			'email'     => 'brandingwithwiseup@gmail.com',
		),
		'wordmark'            => 1,          // the particle "wiseup" and dotted band at the bottom
		'copyright'           => 'WiseUp',
		'credit_name'         => 'CodeAce',
		'credit_url'          => '',
	);
}

/** Saved settings over the defaults (cached per request; the cache resets when the option is saved). */
function wiseup_settings( $fresh = false ) {
	static $cache = null;
	if ( null === $cache || $fresh ) {
		$saved = get_option( WISEUP_OPTION, array() );
		$cache = array_replace_recursive( wiseup_defaults(), is_array( $saved ) ? $saved : array() );
	}
	return $cache;
}
add_action( 'update_option_' . WISEUP_OPTION, function () { wiseup_settings( true ); } );

function wiseup_opt( $key ) {
	$s = wiseup_settings();
	return isset( $s[ $key ] ) ? $s[ $key ] : null;
}

// Menus: assign one under Appearance → Menus to replace a default link list (each falls back to the built-in links).
add_action( 'after_setup_theme', function () {
	register_nav_menus( array(
		'wiseup-header'        => __( 'WiseUp: header links', 'wiseup' ),
		'wiseup-footer-quick'  => __( 'WiseUp: footer Quick Links', 'wiseup' ),
		'wiseup-footer-useful' => __( 'WiseUp: footer Useful Links', 'wiseup' ),
	) );
}, 20 );

/** Built-in link lists, used until a menu is assigned to the matching location. */
function wiseup_default_links( $location ) {
	$lists = array(
		'wiseup-header'        => array(
			// Owner's menu (2026-11-03). Contact is the phone-icon button beside the menu (parts/header.php).
			array( 'WiseUp Podcast', 'https://wiseup.in/podcast/' ),
			array( 'WiseUp TV', 'https://wiseup.in/wiseup-tv/' ),
			array( 'Studio', 'https://wiseup.in/wiseup-studio/' ),
			array( 'Services', home_url( '/services/' ) ), // https://wiseup.in/services/ on the live site
			array( 'Portfolio', 'https://wiseup.in/studio/portfolio/' ),
			array( 'Resources', '', array(
				array( 'Blogs', home_url( '/blog/' ) ),
				array( 'Case Studies', 'https://wiseup.in/case-studies/' ),
			) ),
			array( 'About Us', home_url( '/about/' ) ),
		),
		'wiseup-footer-quick'  => array(
			array( 'WiseUp TV', 'https://wiseup.in/wiseup-tv/' ),
			array( 'WiseUp Studio', 'https://wiseup.in/wiseup-studio/' ),
			array( 'WiseUp Podcast', 'https://wiseup.in/podcast/' ),
		),
		'wiseup-footer-useful' => array(
			array( 'Be a Guest', home_url( '/podcast/#guest' ) ),
			array( 'Portfolio', 'https://wiseup.in/studio/portfolio/' ),
			array( 'Case Studies', 'https://wiseup.in/case-studies/' ),
			array( 'About Us', home_url( '/about/' ) ),
			array( 'Contact Us', home_url( '/contact/' ) ),
		),
	);
	return isset( $lists[ $location ] ) ? $lists[ $location ] : array();
}

/**
 * Links for a location: the assigned menu's top-level items, or the built-in list.
 * Each link: [ 'label' => …, 'url' => …, 'external' => bool ] (external links open in a new tab, as on the Astro site).
 */
function wiseup_links( $location ) {
	$links = array();
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations[ $location ] ) ) {
		$items = wp_get_nav_menu_items( $locations[ $location ] );
		foreach ( (array) $items as $item ) {
			if ( (int) $item->menu_item_parent !== 0 ) continue;
			$kids = array();
			foreach ( (array) $items as $child ) {
				if ( (int) $child->menu_item_parent === (int) $item->ID ) $kids[] = array( 'label' => $child->title, 'url' => $child->url, 'external' => '_blank' === $child->target || wiseup_is_external( $child->url ) );
			}
			$links[] = array( 'label' => $item->title, 'url' => $item->url, 'external' => '_blank' === $item->target || wiseup_is_external( $item->url ), 'children' => $kids );
		}
		if ( $links ) return $links;
	}
	foreach ( wiseup_default_links( $location ) as $l ) {
		$kids = array();
		if ( ! empty( $l[2] ) ) {
			foreach ( $l[2] as $c ) $kids[] = array( 'label' => $c[0], 'url' => $c[1], 'external' => wiseup_is_external( $c[1] ) );
		}
		$links[] = array( 'label' => $l[0], 'url' => $l[1], 'external' => wiseup_is_external( $l[1] ), 'children' => $kids );
	}
	return $links;
}

function wiseup_is_external( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host && $host !== wp_parse_url( home_url(), PHP_URL_HOST );
}
