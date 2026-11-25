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

/** Icons for the "Other services" cards: key => inner SVG (24px, stroked). */
function wiseup_os_icons() {
	return array(
		'dm'    => '<path d="M3 20h18"/><path d="M6 20V11M12 20V5M18 20v-6"/><path d="m5 8 5-4 4 3 5-4"/>',
		'smm'   => '<path d="M5 5h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7l-5 4v-4H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"/><path d="M9 10.5c0-1 1-1.6 1.7-1.2.5.3.8.8 1.3 1.4.5-.6.8-1.1 1.3-1.4.7-.4 1.7.2 1.7 1.2 0 1.4-1.8 2.4-3 3.3-1.2-.9-3-1.9-3-3.3z"/>',
		'seo'   => '<circle cx="10.5" cy="10.5" r="6.5"/><path d="m20 20-4.9-4.9"/><path d="M8 11.5 10 9.5l1.5 1.5L14 8.5"/>',
		'perf'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.2"/><path d="m12 12 7-7M16 4h4v4"/>',
		'mb'    => '<rect x="3" y="4" width="18" height="10" rx="1.5"/><path d="M8 14v6M16 14v6M6 20h4M14 20h4"/><path d="m6 9 3-2 3 3 3-2 3 1"/>',
		'ev'    => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z"/><path d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8z"/>',
		'video' => '<rect x="3" y="6" width="13" height="12" rx="2"/><path d="m16 10 5-3v10l-5-3"/>',
		'web'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><circle cx="6" cy="6.5" r=".6"/><circle cx="8.5" cy="6.5" r=".6"/>',
		'brand' => '<path d="M4 20c4-1 6-3 7-6"/><path d="M14 4l6 6-8 8-6-6z"/><path d="m16 8-6 6"/>',
		'plan'  => '<path d="M6 3h9l4 4v14H6z"/><path d="M14 3v5h5M9 13h7M9 17h5"/>',
		'star'  => '<path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/>',
	);
}

/** Admin labels for those icons. */
function wiseup_os_icon_labels() {
	return array(
		'dm' => 'Growth chart', 'smm' => 'Chat and heart', 'seo' => 'Search', 'perf' => 'Target', 'mb' => 'Billboard', 'ev' => 'Sparkles',
		'video' => 'Video', 'web' => 'Website', 'brand' => 'Brand', 'plan' => 'Plan', 'star' => 'Star',
	);
}

/**
 * The service list behind the "Other services we provide" carousel (Wiseup → Other services).
 * mode: auto = shown only when the service is live (a published page uses its template, or `live` is set);
 *       show = always shown; hide = never. `url` empty = the page's own address. `tpl` = template keys (comma separated),
 *       used to find the page and to leave the current page out of its own list.
 */
function wiseup_os_default_items() {
	return array(
		array( 'id' => 'digital-marketing', 'mode' => 'auto', 'title' => 'Digital Marketing', 'text' => 'Integrated campaigns that connect visibility, engagement, conversion and growth.', 'url' => '', 'icon' => 'dm', 'tpl' => 'wiseup-digital-marketing', 'live' => 'https://wiseup.in/services/digital-marketing-agency-in-kerala/' ),
		array( 'id' => 'social-media', 'mode' => 'auto', 'title' => 'Social Media Marketing', 'text' => 'Strategy, content and campaigns for the platforms your customers use every day.', 'url' => '', 'icon' => 'smm', 'tpl' => 'wiseup-social-media,template-social-media-marketing.php', 'live' => 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/' ),
		array( 'id' => 'seo', 'mode' => 'auto', 'title' => 'SEO Company', 'text' => 'Be found on Google, Bing and AI search with a plan built around your business.', 'url' => '', 'icon' => 'seo', 'tpl' => 'wiseup-seo', 'live' => 'https://wiseup.in/services/seo-company-in-kerala/' ),
		array( 'id' => 'performance-marketing', 'mode' => 'auto', 'title' => 'Performance Marketing', 'text' => 'Paid advertising measured by enquiries, leads and sales, not just clicks.', 'url' => '', 'icon' => 'perf', 'tpl' => 'wiseup-performance-marketing,wiseup-performance', 'live' => 'https://wiseup.in/services/performance-marketing-agency-in-kerala/' ),
		array( 'id' => 'branding', 'mode' => 'auto', 'title' => 'Branding', 'text' => 'Brand identity, logo, packaging and print, shaped by strategy and design.', 'url' => '', 'icon' => 'brand', 'tpl' => 'wiseup-branding', 'live' => '' ),
		array( 'id' => 'media-buying', 'mode' => 'auto', 'title' => 'Media Buying', 'text' => 'Outdoor, print and theatre placements planned and bought across Kerala.', 'url' => '', 'icon' => 'mb', 'tpl' => 'wiseup-media-buying', 'live' => 'https://wiseup.in/services/media-buying-agency/' ),
		array( 'id' => 'event-branding', 'mode' => 'auto', 'title' => 'Event Branding', 'text' => 'One identity for your event, from the invitation to the stage backdrop.', 'url' => '', 'icon' => 'ev', 'tpl' => 'wiseup-event-branding', 'live' => 'https://wiseup.in/services/event-branding-agency-in-kerala/' ),
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
		// Other services carousel (Wiseup → Other services)
		'os_enabled'          => 1,
		'os_eyebrow'          => 'More services',
		'os_heading'          => 'Other services',
		'os_heading2'         => 'we provide',
		'os_items'            => wiseup_os_default_items(),
	);
}

/** Saved settings over the defaults (cached per request; the cache resets when the option is saved). */
function wiseup_settings( $fresh = false ) {
	static $cache = null;
	if ( null === $cache || $fresh ) {
		$saved = get_option( WISEUP_OPTION, array() );
		$cache = array_replace_recursive( wiseup_defaults(), is_array( $saved ) ? $saved : array() );
		// a saved service list replaces the built-in one as a whole (a recursive merge would put deleted services back)
		if ( is_array( $saved ) && isset( $saved['os_items'] ) && is_array( $saved['os_items'] ) ) $cache['os_items'] = array_values( $saved['os_items'] );
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
			array( 'WiseUp Studio', 'https://wiseup.in/wiseup-studio/' ),
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
