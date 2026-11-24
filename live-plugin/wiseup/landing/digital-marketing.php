<?php
/**
 * Digital Marketing Agency in Kerala ("WiseUp: Digital Marketing" in the page Template dropdown). Copy is the owner's
 * doc word for word (Downloads/digital marketing company (1).docx, 2026-11-12: "this is the actual content. dont miss
 * any word"), in the doc's order; the Australia version was dropped on request. The doc's keyword list feeds the
 * title and meta description only. Case-study figures come from wiseup_cs_stats(); reviews are the real Google reviews.
 * Design system: the Event Branding page's (assets/css/event-branding.css + assets/js/event-branding.js, scoped to
 * .wu-ev) plus this page's own blocks in assets/css/digital-marketing.css. Brand marks: landing/digital-marketing-icons.php.
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'digital-marketing';
$wu_title = apply_filters( 'wiseup_landing_title', 'Digital Marketing Agency in Kerala | Digital Marketing Company in Calicut | WiseUp' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is a digital marketing agency in Kerala, based in Calicut: SEO, PPC advertising, social media marketing, content, branding, websites and AI automation. Packages start at ₹60,000.' );
$wu_seo   = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
if ( ! $wu_seo ) {
	add_filter( 'pre_get_document_title', function () use ( $wu_title ) { return $wu_title; } );
	add_action( 'wp_head', function () use ( $wu_title, $wu_desc ) {
		$url = get_permalink();
		echo '<meta name="description" content="' . esc_attr( $wu_desc ) . '">' . "\n";
		echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $wu_title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $wu_desc ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	}, 2 );
}
wiseup_landing_isolate();
// Motion engine flag before first paint (same as the Event Branding page; removed after 3s if the scripts never start).
add_action( 'wp_head', function () {
	echo "<script>(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var d=document.documentElement;d.classList.add('wu-motion');setTimeout(function(){if(!window.__wuEvMotion)d.classList.remove('wu-motion');},3000);})();</script>\n";
}, 1 );
add_action( 'wp_head', function () {
	foreach ( array( 'event-branding.css', 'digital-marketing.css', 'service-system.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/' . $css . '?ver=' . filemtime( WISEUP_DIR . 'assets/css/' . $css ) ) . "\">\n";
	}
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to talk about digital marketing for my business.' );
$wu_arrow = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg>';
$wu_ne    = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>';
$wu_btn   = function ( $label, $look = 'teal', $attrs = '' ) use ( $wu_arrow ) {
	$tag = false !== strpos( $attrs, 'href=' ) ? 'a' : 'button';
	return '<' . $tag . ( 'button' === $tag ? ' type="button"' : '' ) . ' class="b b--' . $look . '" ' . $attrs . '><span class="b__label">' . esc_html( $label ) . '</span><span class="b__ico">' . $wu_arrow . $wu_arrow . '</span></' . $tag . '>';
};
$wu_lead    = 'data-lead-open data-lead-source="' . esc_attr( $wu_src ) . '"';
$wu_eyebrow = function ( $t ) { return '<p class="eyebrow"><span class="eyebrow__dot" aria-hidden="true"></span>' . esc_html( $t ) . '</p>'; };
$wu_svg     = function ( $paths, $size = 22, $sw = 1.6 ) {
	return '<svg width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . esc_attr( $sw ) . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths . '</svg>';
};
// Brand mark tile: a Simple Icons slug (inline SVG in its brand colour) or an image file in assets/landing/img/icons/.
$wu_brands = include WISEUP_DIR . 'landing/digital-marketing-icons.php';
$wu_mark   = function ( $key ) use ( $wu_brands ) {
	// Google products: the official full-colour logos (Simple Icons only has flat one-colour versions)
	$wu_google = array( 'google' => 'i-google-icon.svg', 'googleads' => 'i-google-ads.svg', 'googlesearchconsole' => 'google-search-console.png', 'googleanalytics' => 'i-google-analytics.svg', 'googletagmanager' => 'i-google-tag-manager.svg' );
	if ( isset( $wu_google[ $key ] ) ) $key = $wu_google[ $key ];
	if ( isset( $wu_brands[ $key ] ) ) {
		$fill = $wu_brands[ $key ][0];
		$defs = '';
		if ( 'instagram' === $key ) { // the real Instagram gradient, defined inside its own svg
			static $ig_n = 0;
			$ig_n++;
			$fill = 'url(#dm-ig' . $ig_n . ')';
			$defs = '<defs><radialGradient id="dm-ig' . $ig_n . '" cx="30%" cy="107%" r="150%"><stop offset="0" stop-color="#fdf497"/><stop offset=".05" stop-color="#fdf497"/><stop offset=".45" stop-color="#fd5949"/><stop offset=".6" stop-color="#d6249f"/><stop offset=".9" stop-color="#285AEB"/></radialGradient></defs>';
		}
		return '<span class="dm-mark" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20" fill="' . esc_attr( $fill ) . '">' . $defs . '<path d="' . esc_attr( $wu_brands[ $key ][1] ) . '"/></svg></span>';
	}
	return '<span class="dm-mark" aria-hidden="true"><img src="' . esc_url( WISEUP_URL . 'assets/landing/img/icons/' . $key ) . '" alt="" width="20" height="20" loading="lazy" decoding="async"></span>';
};
// Stacking cards: one wide card per item; on scroll each card slides up over the one before (sticky), the covered
// card shrinks back and dims (assets/css/digital-marketing.css .dm-stack, script at the end of this file).
// Item: [ title, text, visual html, extra html after the text, number label ].
// Card title in two tones, like the section headings: white lead words, grey rest from the first " (" or " & ".
$wu_stack_title = function ( $s ) {
	foreach ( array( ' (', ' & ' ) as $cut ) {
		$p = strpos( $s, $cut );
		if ( false !== $p ) return esc_html( substr( $s, 0, $p ) ) . ' <span>' . esc_html( substr( $s, $p + 1 ) ) . '</span>';
	}
	return esc_html( $s );
};
$wu_stack = function ( $items, $mod ) use ( $wu_stack_title ) {
	$n = count( $items );
	$o = '<ol class="dm-stack dm-stack--' . esc_attr( $mod ) . '" data-stack>';
	foreach ( array_values( $items ) as $k => $it ) {
		$o .= '<li class="dm-stack__card" style="--i:' . (int) $k . '"><div class="dm-stack__in">'
			. '<div class="dm-stack__l"><span class="dm-stack__vis">' . $it[2] . '</span>'
			. '<h3>' . $wu_stack_title( $it[0] ) . '</h3></div>'
			. '<div class="dm-stack__r">'
			. '<p>' . esc_html( $it[1] ) . '</p>' . $it[3] . '</div>'
			. '</div></li>';
	}
	return $o . '</ol>';
};
// Two-tone heading: first part white, second part grey, split where the sentence breaks.
$wu_h = function ( $a, $b ) { return '<span class="sh__a">' . esc_html( $a ) . '</span> <span class="sh__b">' . esc_html( $b ) . '</span>'; };

// Client logos: the homepage strip's logo set (same files and alt text as the Event Branding page).
$wu_logos = array( 'amarapushpa' => 'Amarapushpa', 'bm-prime' => 'BM Prime', 'bucho' => 'Bucho', 'cadd' => 'CADD Centre', 'cellar-de-mahe' => 'Cellar de Mahe', 'clair-veda' => 'Clair Veda', 'eduwizz' => 'Eduwizz', 'ellisto' => 'Eallisto', 'erets' => 'Erets', 'flora-fauna' => 'Flora Fauna', 'formaa' => 'Formaa', 'gloveda' => 'Gloveda', 'goldekarak' => 'Golden Karak', 'hayath' => 'Hayath Medicare', 'intervel' => 'Intervel', 'lullaby' => 'Lullaby', 'lunar' => 'Lunar', 'mgf' => 'MGF Events', 'mooss' => 'Mooss', 'onesto-marcado' => 'Onesto & Mercado', 'philips' => 'Philips', 'popees' => 'Popees', 'sathya' => 'Sathya', 'superhuman' => 'Superhuman', 'tiny-mafia' => 'Tiny Mafia', 'wellah' => 'Wellah' );
$wu_li    = '';
foreach ( $wu_logos as $f => $alt ) $wu_li .= '<li class="is-tile"><img src="' . esc_url( WISEUP_ASSETS . '/clients/client-logos-2026/' . $f . '.webp' ) . '" alt="' . esc_attr( $alt . ' logo, digital marketing client of WiseUp' ) . '" loading="lazy" decoding="async"></li>';

$wu_icons = array(
	'search'  => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2M8.5 11h5M11 8.5v5"/>',
	'target'  => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/>',
	'chat'    => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'pen'     => '<path d="M4 20h4L19 9l-4-4L4 16z"/><path d="m13.5 6.5 4 4M14 20h6"/>',
	'brush'   => '<path d="M14.5 4.5 19.5 9.5 11 18l-5-5z"/><path d="M6 13c-2 0-3 1.5-3 3.5S2 20 2 20s4 .5 5.5-1 1.5-3.5.5-5"/>',
	'code'    => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 8h18M9.5 12 7.5 14l2 2M14.5 12l2 2-2 2"/>',
	'mega'    => '<path d="M4 10v4h3l7 4V6l-7 4z"/><path d="M17.5 9.5a3.5 3.5 0 0 1 0 5M7 14l1.5 5h2.5l-1-4.5"/>',
	'bot'     => '<rect x="4.5" y="8" width="15" height="11" rx="3"/><path d="M12 4.5V8M9.5 13h.01M14.5 13h.01M9.5 16h5M2.5 12.5v2M21.5 12.5v2"/><circle cx="12" cy="4" r="1"/>',
	'ear'     => '<path d="M7 9.5a5 5 0 0 1 10 0c0 3-2.5 3.5-3 6s-1.5 4-3.5 4-3-1.5-3-3"/><path d="M10 9.5a2 2 0 0 1 4 0"/>',
	'scope'   => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2M8 12.5l2-2 1.5 1.5L14 9"/>',
	'mix'     => '<path d="M4 7h10M18 7h2M4 17h4M12 17h8"/><circle cx="16" cy="7" r="2"/><circle cx="10" cy="17" r="2"/><path d="M4 12h6M14 12h6"/><circle cx="12" cy="12" r="2"/>',
	'spark'   => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M18.4 5.6l-2.8 2.8M8.4 15.6l-2.8 2.8"/>',
	'chart'   => '<path d="M4 20V4M4 20h16"/><path d="m7.5 15 4-4.5 3 3L20 7"/>',
	'health'  => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.4 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/><path d="M9.5 12h5M12 9.5v5"/>',
	'home'    => '<path d="M3.5 11 12 4l8.5 7"/><path d="M5.5 9.5V20h13V9.5M10 20v-5.5h4V20"/>',
	'cap'     => '<path d="m2.5 9.5 9.5-5 9.5 5-9.5 5z"/><path d="M6.5 11.6V16c1.5 1.6 3.4 2.4 5.5 2.4s4-.8 5.5-2.4v-4.4M21.5 9.5v5"/>',
	'scale'   => '<path d="M12 4v16M8 20h8M5 7h14"/><path d="m5 7-2.5 6a3 3 0 0 0 5 0zM19 7l-2.5 6a3 3 0 0 0 5 0z"/>',
	'bed'     => '<path d="M3 18V7M3 14h18v4M21 14v-2.5A2.5 2.5 0 0 0 18.5 9H11v5"/><circle cx="7" cy="11" r="1.8"/>',
	'bag'     => '<path d="M5 8h14l-1 12H6z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/>',
	'factory' => '<path d="M3 20V10l5 3V10l5 3V6h4l1 14z"/><path d="M3 20h18M7 17h2M12 17h2"/>',
	'rocket'  => '<path d="M12 3c3 2 4.5 5 4.5 9L12 16.5 7.5 12C7.5 8 9 5 12 3z"/><circle cx="12" cy="9.5" r="1.6"/><path d="M7.5 12 5 14.5l2.5 1M16.5 12l2.5 2.5-2.5 1M10.5 17.5 12 21l1.5-3.5"/>',
	'tool'    => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/>',
	'pin'     => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
	'globe'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3z"/>',
	'map'     => '<path d="M3 6.5 9 4l6 2.5 6-2.5v13.5L15 20l-6-2.5L3 20z"/><path d="M9 4v13.5M15 6.5V20"/>',
	'play'    => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5z"/>',
	'link'    => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
	'eye'     => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/><circle cx="12" cy="12" r="3"/>',
);

$wu_smm = ( function () {
	$ids = get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'meta_key' => '_wp_page_template', 'meta_value' => 'wiseup-social-media', 'posts_per_page' => 1, 'fields' => 'ids' ) ); // phpcs:ignore
	return $ids ? get_permalink( $ids[0] ) : 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/';
} )();

$wu_services = array(
	array( 'Search Engine Optimisation (SEO)', 'search', 'Help your business get found when potential customers search for what you offer. We strengthen your search presence through technical SEO, keyword research, content optimisation, and local search strategies, bringing more relevant visitors to your website and creating opportunities for organic growth.', '' ),
	array( 'Performance Marketing & PPC Advertising', 'target', 'Reach the right audience with campaigns built to generate meaningful action. We create and manage Google Ads, Meta campaigns and remarketing strategies, using audience targeting and performance tracking to improve clicks, enquiries and conversions.', '' ),
	array( 'Social Media Marketing', 'chat', 'Give your audience more reasons to connect with your brand. We create platform-specific social media strategies and content that build brand awareness, encourage engagement and generate business enquiries.', $wu_smm ),
	array( 'Content Marketing & Creative Production', 'pen', 'Give your brand a clear and consistent voice across digital platforms. We create website content, SEO articles, social media posts, campaign copy and video assets that communicate your message and connect with your audience.', '' ),
	array( 'Branding & Digital Brand Experiences', 'brush', 'Build a brand people can recognise and remember. From brand strategy and positioning to visual identity, messaging and creative communication, we bring the different elements of your brand together.', '' ),
	array( 'Website & Digital Experience Development', 'code', 'Turn your website into a more effective business touchpoint. We design and develop responsive websites and landing pages with clear navigation and user-friendly experiences that make it easier for visitors to take action.', '' ),
	array( 'Public Relations & Digital Brand Communication', 'mega', 'Make your brand story reach a wider audience. Through digital PR, media communication, and brand storytelling, we strengthen brand visibility and create more opportunities for meaningful audience connections.', '' ),
	array( 'AI Business Automation & CRM', 'bot', 'Make everyday business operations more organised and efficient with AI-powered automation and CRM solutions. We streamline repetitive tasks, automate customer interactions, and organise lead management through connected systems that help your team save time and manage customer relationships more effectively.', '' ),
);

$wu_approach = array(
	array( 'ear', 'Understand the Business and Its Audience', 'We look at your business objectives, customer profiles, audience behaviour and existing digital presence. This gives us a clearer picture of where your marketing stands and what needs attention.' ),
	array( 'scope', 'Research the Market and Competition', 'We assess competitor activity, search demand, audience expectations, and opportunities to differentiate your brand. The aim is to identify where your business can make a stronger impression.' ),
	array( 'mix', 'Choose the Right Marketing Mix', 'Not every business needs every channel. We select services, platforms and campaign formats based on your objectives, audience and available resources.' ),
	array( 'spark', 'Connect Creativity With Strategy', 'A good strategy needs equally thoughtful execution. We bring messaging, design, content, and advertising together so that your brand communicates with consistency and purpose.' ),
	array( 'chart', 'Refine Through Performance Insights', 'Marketing is not a set-and-forget activity. We review campaign performance, audience response, and website data to identify what is working and where improvements are needed.' ),
);

$wu_channels = array(
	array( 'Google & Search Platforms', array( 'google', 'googleads', 'googlesearchconsole' ), 'SEO, Google Ads and local search help your business reach people looking for relevant products or services. These channels are useful for building search visibility and attracting audiences with a clear interest.' ),
	array( 'Instagram & Facebook', array( 'instagram', 'facebook', 'meta' ), 'Visual content, community engagement, and Meta Ads can help brands build awareness, communicate their personality, and generate enquiries from relevant audiences.' ),
	array( 'LinkedIn', array( 'linkedin' ), 'For businesses targeting professionals and other organisations, LinkedIn supports B2B communication, thought leadership, professional visibility and business enquiries.' ),
	array( 'YouTube & Video Platforms', array( 'youtube' ), 'Video gives brands more room to demonstrate products, communicate ideas and tell stories. YouTube can support discovery through both organic video content and paid advertising.' ),
	array( 'Other Relevant Digital Channels', array( 'pinterest' ), 'Depending on your audience and objectives, platforms such as Pinterest may also be worth considering. We assess their relevance before adding them to your marketing mix.' ),
);

$wu_stages = array(
	array( 'Startups Building Their First Digital Presence', 'Build a clear brand position, establish your website, and create the initial visibility needed to reach your target audience.' ),
	array( 'Small Businesses Looking for More Customers', 'You do not need to be everywhere to make an impact. Our digital marketing services for small businesses can focus on practical priorities such as local SEO, targeted advertising, and social media, depending on your budget and goals.' ),
	array( 'Established Businesses Expanding Their Reach', 'Reach new audiences through integrated campaigns, stronger brand positioning and a coordinated presence across relevant digital channels.' ),
	array( 'Growing Brands Strengthening Market Position', 'Maintain consistency as your business grows through creative campaigns, relevant content, performance optimisation and stronger brand communication.' ),
);

$wu_industries = array(
	array( 'Healthcare & Medical Practices', 'health' ), array( 'Real Estate & Property', 'home' ), array( 'Education & Training', 'cap' ),
	array( 'Legal & Professional Services', 'scale' ), array( 'Hotels, Hospitality & Dining', 'bed' ), array( 'E-commerce & Retail', 'bag' ),
	array( 'Manufacturing & Printing', 'factory' ), array( 'Startups & SaaS Businesses', 'rocket' ), array( 'Local & Home Services', 'tool' ),
);

$wu_ind_icons = array(
	'health' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm6 11h-3v3h-2v-3H8v-2h3v-3h2v3h3v2z"/></svg>',
	'home' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 11v10h5v-6h4v6h5V11L8 6z"/><path d="M10 3v1.97l7 5V11h2v2h-2v2h2v2h-2v4h6V3H10zm9 6h-2V7h2v2z"/></svg>',
	'cap' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3 1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>',
	'scale' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m5.25 8.069 2.83-2.827 14.134 14.15-2.83 2.827zm4.236-4.242L12.314.998l5.657 5.656-2.828 2.83zM.999 12.315l2.828-2.829 5.657 5.657-2.828 2.828zM1 21h12v2H1z"/></svg>',
	'bed' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>',
	'bag' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 6h-2c0-2.21-1.79-4-4-4S8 3.79 8 6H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-8 4c0 .55-.45 1-1 1s-1-.45-1-1V8h2v2zm2-6c1.1 0 2 .9 2 2h-4c0-1.1.9-2 2-2zm4 6c0 .55-.45 1-1 1s-1-.45-1-1V8h2v2z"/></svg>',
	'factory' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m19.93 8.21-3.6 1.68L14 7.7V6.3l2.33-2.19 3.6 1.68c.38.18.82.01 1-.36.18-.38.01-.82-.36-1L16.65 2.6a.993.993 0 0 0-1.13.2l-1.74 1.6A.975.975 0 0 0 13 4c-.55 0-1 .45-1 1v1H8.82C8.34 4.65 6.98 3.73 5.4 4.07c-1.16.25-2.15 1.25-2.36 2.43-.22 1.32.46 2.47 1.48 3.08L7.08 18H4v3h13v-3h-3.62L8.41 8.77c.17-.24.31-.49.41-.77H12v1c0 .55.45 1 1 1 .32 0 .6-.16.78-.4l1.74 1.6c.3.3.75.38 1.13.2l3.92-1.83c.38-.18.54-.62.36-1a.753.753 0 0 0-1-.36zM6 8c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/></svg>',
	'rocket' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.19 6.35c-2.04 2.29-3.44 5.58-3.57 5.89L2 10.69l4.05-4.05c.47-.47 1.15-.68 1.81-.55l1.33.26zM11.17 17s3.74-1.55 5.89-3.7c5.4-5.4 4.5-9.62 4.21-10.57-.95-.3-5.17-1.19-10.57 4.21C8.55 9.09 7 12.83 7 12.83L11.17 17zm6.48-2.19c-2.29 2.04-5.58 3.44-5.89 3.57L13.31 22l4.05-4.05c.47-.47.68-1.15.55-1.81l-.26-1.33zM9 18c0 .83-.34 1.58-.88 2.12C6.94 21.3 2 22 2 22s.7-4.94 1.88-6.12A2.996 2.996 0 0 1 9 18zm4-9c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z"/></svg>',
	'tool' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m21.67 18.17-5.3-5.3h-.99l-2.54 2.54v.99l5.3 5.3c.39.39 1.02.39 1.41 0l2.12-2.12a.996.996 0 0 0 0-1.41z"/><path d="m17.34 10.19 1.41-1.41 2.12 2.12a3 3 0 0 0 0-4.24l-3.54-3.54-1.41 1.41V1.71l-.7-.71-3.54 3.54.71.71h2.83l-1.41 1.41 1.06 1.06-2.89 2.89-4.13-4.13V5.06L4.83 2.04 2 4.87 5.03 7.9h1.41l4.13 4.13-.85.85H7.6l-5.3 5.3a.996.996 0 0 0 0 1.41l2.12 2.12c.39.39 1.02.39 1.41 0l5.3-5.3v-2.12l5.15-5.15 1.06 1.05z"/></svg>',
);

// What each process step hands over (shown opposite the step on wide screens).
$wu_outcome = array( 'Audit and opportunities', 'Marketing roadmap', 'Content, designs and campaigns', 'Live campaigns and channels', 'Refined strategy' );
$wu_process = array(
	array( 'Discover', 'search', 'We begin with your business, audience, objectives and competitors. We also assess your existing website, brand communication and digital presence to identify opportunities.' ),
	array( 'Strategise', 'map', 'Based on our findings, we develop a marketing roadmap. This sets the direction for channel priorities, campaign objectives, content and creative requirements.' ),
	array( 'Create', 'pen', 'Our team develops the content, designs, campaigns, websites and digital assets needed to bring the strategy to life. Each element is created with its intended audience and platform in mind.' ),
	array( 'Launch & Execute', 'play', 'We put the plan into action by launching campaigns, publishing content and activating the selected channels. We keep execution aligned with the agreed direction and priorities.' ),
	array( 'Measure & Optimise', 'chart', 'We review performance data, audience response and campaign outcomes to identify opportunities for improvement. The strategy can then be refined based on what the results tell us.' ),
);

$wu_tl_icons = array(
	'search' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.3 16.9c.4-.7.7-1.5.7-2.4 0-2.5-2-4.5-4.5-4.5S11 12 11 14.5s2 4.5 4.5 4.5c.9 0 1.7-.3 2.4-.7l3.2 3.2 1.4-1.4-3.2-3.2zm-3.8.1c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5zM12 20v2C6.48 22 2 17.52 2 12S6.48 2 12 2c4.84 0 8.87 3.44 9.8 8h-2.07A8 8 0 0 0 15 4.59V5c0 1.1-.9 2-2 2h-2v2c0 .55-.45 1-1 1H8v2h2v3H9l-4.79-4.79C4.08 10.79 4 11.38 4 12c0 4.41 3.59 8 8 8z"/></svg>',
	'map' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m20.5 3-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>',
	'pen' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>',
	'play' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.19 6.35c-2.04 2.29-3.44 5.58-3.57 5.89L2 10.69l4.05-4.05c.47-.47 1.15-.68 1.81-.55l1.33.26zM11.17 17s3.74-1.55 5.89-3.7c5.4-5.4 4.5-9.62 4.21-10.57-.95-.3-5.17-1.19-10.57 4.21C8.55 9.09 7 12.83 7 12.83L11.17 17zm6.48-2.19c-2.29 2.04-5.58 3.44-5.89 3.57L13.31 22l4.05-4.05c.47-.47.68-1.15.55-1.81l-.26-1.33zM9 18c0 .83-.34 1.58-.88 2.12C6.94 21.3 2 22 2 22s.7-4.94 1.88-6.12A2.996 2.996 0 0 1 9 18zm4-9c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z"/></svg>',
	'chart' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 9h4v11H4zm12 4h4v7h-4zm-6-9h4v16h-4z"/></svg>',
);

// Tools: [ group, [ [ name, brand mark ], ... ] ], names as in the doc.
$wu_tools = array(
	array( 'SEO & Keyword Research', array( array( 'Google Search Console', 'googlesearchconsole' ), array( 'Google Analytics 4', 'googleanalytics' ), array( 'Ahrefs', 'fav-ahrefs.com.png' ), array( 'Semrush', 'semrush' ), array( 'Screaming Frog SEO Spider', 'fav-screamingfrog.co.uk.png' ), array( 'Google Keyword Planner', 'googleads' ) ) ),
	array( 'Paid Advertising', array( array( 'Google Ads', 'googleads' ), array( 'Meta Ads Manager', 'meta' ), array( 'LinkedIn Campaign Manager', 'linkedin' ), array( 'TikTok Ads Manager', 'tiktok' ) ) ),
	array( 'Social Media Management', array( array( 'Meta Business Suite', 'meta' ), array( 'Hootsuite', 'hootsuite' ), array( 'Buffer', 'buffer' ), array( 'Sprout Social', 'fav-sproutsocial.com.png' ), array( 'Later', 'fav-later.com.png' ) ) ),
	array( 'Analytics & Reporting', array( array( 'Looker Studio', 'looker.svg' ), array( 'Microsoft Clarity', 'fav-clarity.microsoft.com.png' ), array( 'Hotjar', 'hotjar' ), array( 'Google Tag Manager', 'googletagmanager' ) ) ),
	array( 'Design & Creative Production', array( array( 'Adobe Photoshop', 'adobephotoshop' ), array( 'Illustrator', 'adobeillustrator' ), array( 'Premiere Pro', 'adobepremierepro' ), array( 'After Effects', 'adobeaftereffects' ), array( 'Canva', 'canva' ), array( 'Figma', 'figma' ) ) ),
	array( 'Content & Research', array( array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Grammarly', 'grammarly' ), array( 'Google Trends', 'fav-trends.google.com.png' ), array( 'AnswerThePublic', 'fav-answerthepublic.com.png' ) ) ),
	array( 'Email marketing and automation', array( array( 'Mailchimp', 'mailchimp' ), array( 'HubSpot', 'hubspot' ), array( 'Brevo', 'brevo' ), array( 'Zoho Campaigns', 'zoho' ) ) ),
);

$wu_why = array(
	array( 'spark', 'Strategy and Creativity Working Together', 'We bring planning and creative execution into the same process. This helps ensure that the ideas behind your marketing are reflected in the content, design, and campaigns your audience sees.' ),
	array( 'link', 'A Connected Creative and Technology Approach', 'WiseUp’s creative and strategic capabilities work alongside CodeAce’s technology expertise where a project requires it. This gives businesses access to connected thinking across brand communication and digital experiences.' ),
	array( 'target', 'Marketing Around Your Business Goals', 'We do not begin with a fixed list of services. We look at your priorities and recommend the channels and activities that make sense for your objectives and resources.' ),
	array( 'eye', 'Creative That Builds Brand Recognition', 'From visual identity to campaign content, we focus on communication that reflects your brand and makes it easier for audiences to recognise and remember.' ),
	array( 'chart', 'Performance That Can Be Evaluated', 'We consider measurable indicators such as website traffic, enquiries, conversions, and advertising performance. These insights help assess progress and guide the next decisions.' ),
);

// Results: owner's four brands, image or logo and name only, no details (owner 2026-11-12). [ name, kind, image, link ]
// kind: photo = cover image, logo = colour logo on a white tile, none = no artwork yet (KPG Roofings: no logo on file).
$wu_results = array(
	array( 'Onesto & Mercado', 'logo', WISEUP_ASSETS . '/clients/client-logos-2026/onesto-marcado.png', home_url( '/case-studies/onesto/' ) ),
	array( 'IndusGo', 'photo', WISEUP_URL . 'assets/landing/img/case-indusgo.jpg', home_url( '/case-studies/indusgo/' ), array( '10', 'Campaign videos produced every month', '', array( array( '100K+', 'reach on several videos' ) ) ) ),
	array( 'Sathya', 'photo', WISEUP_URL . 'assets/work/case-sathya-720.webp', home_url( '/case-studies/sathya-agencies-brand-launch-campaign-kerala/' ), array( '1M+', 'Minimum reach on every video', '', array( array( '100+', 'videos in total' ), array( '6+', 'store launches' ), array( '5+', 'video formats' ) ) ) ),
	array( 'KPG Roofings', 'photo', WISEUP_URL . 'assets/landing/img/case-kpg.webp', '', array( '45+', 'Showrooms connected online', 'Corporate website and digital presence.' ) ),
);

$wu_package = array(
	array( 'Strategy & Planning', 'Business and audience research, competitor analysis, marketing strategy and monthly planning' ),
	array( 'Content & Creative', 'Content calendars, graphics, carousels, reels, video creatives and campaign copy' ),
	array( 'SEO', 'Keyword research, on-page SEO and website performance recommendations' ),
	array( 'Paid Campaigns', 'Google and Meta Ads setup, audience targeting, ad creatives, monitoring and optimisation' ),
	array( 'Social Media Management', 'Platform-specific content, publishing and account management' ),
	array( 'Reporting & Analysis', 'Performance reports, campaign insights and recommendations' ),
);

$wu_faq = array(
	array( 'How will you understand our business, target customers, and competitors before recommending a marketing plan?', 'We begin with a detailed assessment of your business, industry, existing marketing activities and growth objectives. This includes analysing your target audience, customer behaviour, market trends and key competitors. We also review your current digital presence to identify strengths, gaps and opportunities. These insights help us develop a marketing plan that reflects your business needs and reaches the right audience.' ),
	array( 'What information do you need from us before preparing a proposal or marketing roadmap?', 'We need a clear understanding of your business goals, products or services, target audience, industry, budget and expected outcomes. Information about your existing marketing activities, previous campaign performance, brand guidelines and current challenges is also valuable. This gives us the context to recommend suitable channels, define priorities and prepare a marketing roadmap aligned with your objectives.' ),
	array( 'How do you balance brand building with generating immediate leads and sales?', 'We combine long-term brand-building activities with performance-focused campaigns to support both immediate and sustained growth. Brand strategy, content marketing, SEO and social media help strengthen brand recognition and customer trust, while paid advertising, targeted campaigns and conversion optimisation focus on generating enquiries and sales. The balance depends on your business goals, budget and growth stage.' ),
	array( 'How often will we receive performance reports, and what will those reports include?', 'We provide regular performance reports, typically on a monthly basis, with additional updates for ongoing campaigns when required. Reports cover key metrics such as reach, engagement, website traffic, keyword performance, leads, conversions, cost per lead and return on ad spend, depending on the services being managed. We also highlight campaign progress, key insights and recommended improvements so you can clearly understand how your marketing activities are performing.' ),
	array( 'What steps do you take when a campaign does not deliver the expected results?', 'When a campaign falls short of its targets, we analyse the performance data to identify where improvements are needed. This may involve reviewing audience targeting, ad creatives, messaging, keyword selection, landing pages, budget allocation and conversion paths. Based on these findings, we make data-driven adjustments, test different approaches and monitor the results. Our focus is on identifying the underlying issues and continuously improving campaign performance rather than continuing with an approach that is not delivering results.' ),
);

add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 20 );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero" data-css-intro>
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Digital Marketing Agency in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">Your Growth Starts</span> <span class="sh__b">With the Right Strategy</span></h2>
				<p class="ev-hero__p">Your marketing should do more than keep your business visible. It should bring the right people closer to your brand. As a digital marketing agency in Kerala, WiseUp combines strategy, creativity and technology to build campaigns around your business goals. From SEO and paid advertising to social media, content and branding, we bring the right elements together to turn audience interest into meaningful business opportunities.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Let’s Talk About Your Growth', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'View Our Work', 'night', 'href="#results"' ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-stage dm-shot" data-stage>
				<img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-glossy-1200.webp' ); ?>" srcset="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-glossy-560.webp' ); ?> 560w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-glossy-760.webp' ); ?> 760w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-glossy-1200.webp' ); ?> 1200w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-glossy-1600.webp' ); ?> 1600w" sizes="(max-width: 1023px) 92vw, 54vw" width="1852" height="849" fetchpriority="high" decoding="async" alt="WiseUp digital marketing agency in Kerala: SEO, social media, paid ads, analytics and growth marketing services">
			
				<script>(function(){var st=document.querySelector('.dm-shot');if(!st||matchMedia('(prefers-reduced-motion: reduce)').matches)return;var img=st.querySelector('img'),t=0;var run=function(){t=0;var r=st.getBoundingClientRect(),h=innerHeight,p=Math.max(0,Math.min(1,(h*.5-r.top-r.height/2)/(h*.9)*-1+0));p=Math.max(0,Math.min(1,-r.top/(h*.8)));img.style.setProperty('--sy',(p*-70).toFixed(1)+'px');img.style.setProperty('--sr',(p*4).toFixed(2)+'deg');img.style.setProperty('--ss',(1+p*.08).toFixed(3));img.style.opacity=(1-p*.55).toFixed(3);};addEventListener('scroll',function(){if(!t)t=requestAnimationFrame(run);},{passive:true});run();})();</script>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					array( '120', '+', 'Projects delivered' ),
					array( '3', 'M+', 'Audience reached' ),
					array( '21.6', 'M+', 'Impressions for one launch' ),
					array( '8', '', 'Years of CodeAce engineering' ),
					array( '5.0', '★', 'Google rating from client reviews' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
		<div class="logos ev-logos" role="region" aria-label="Client logos"><div class="logos__marquee"><div class="logos__row"><div class="logos__track"><ul><?php echo $wu_li; // phpcs:ignore ?></ul><ul aria-hidden="true"><?php echo str_replace( '" alt="', '" alt="" data-alt="', $wu_li ); // phpcs:ignore ?></ul></div></div></div></div>
	</section>


<?php wiseup_ai_overview( array(
	'q' => 'What does a digital marketing agency in Kerala do?',
	'a' => 'A digital marketing agency in Kerala helps businesses attract customers online through search, social media, paid advertising, content and branding. The work usually covers market and competitor research, SEO, Google and Meta Ads, social media management, content and creative production, website optimisation and monthly reporting on traffic, leads and return on ad spend.',
	'points' => array(
		array( 'Services', 'SEO, Google Ads and Meta Ads, social media marketing, content and video production, branding, website development, digital PR and AI automation with CRM.' ),
		array( 'How it works', 'We start by understanding your business, audience and competitors, then build a plan covering the right channels, creative and tracking, and refine it every month using performance data.' ),
		array( 'Who it’s for', 'Startups, small businesses and established brands in healthcare, real estate, education, retail, hospitality and more.' ),
		array( 'Where', 'WiseUp is based in Calicut (Kozhikode) and works with businesses across Kerala, India and the Gulf.' ),
	),
	'links' => array( array( 'Services', '#dm-services' ), array( 'Channels', '#channels' ), array( 'Kerala', '#kerala' ), array( 'Process', '#dm-process' ), array( 'Pricing', '#pricing' ), array( 'FAQ', '#faq' ) ),
	'note' => 'Packages start at <b>₹60,000</b> per month, depending on scope. Get a free marketing plan before you see a price.',
) ); ?>	<!-- 2. Good marketing moves business forward -->
	<section class="sec ev-sec" id="approach">
		<div class="wrap dm-split">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Why it matters' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Good Marketing Doesn’t Just Get Attention.', 'It Moves Business Forward.' ); // phpcs:ignore ?></h2>
			</div>
			<div class="dm-prose">
				<p class="ev-lead">Getting noticed is a start. Getting the right people to take action is what makes marketing valuable.</p>
				<p>Your audience needs to find your brand, understand what makes it relevant, and have a reason to choose you. That journey does not happen through a single advertisement or social media post. It takes consistent communication across the right channels, supported by a clear strategy.</p>
				<p>At WiseUp, we connect brand awareness, audience engagement, relevant website traffic, and lead generation into a more focused marketing approach. Every campaign, creative, and digital touchpoint should have a purpose, whether that is building recognition, generating enquiries, improving conversions or strengthening customer relationships.</p>
			</div>
			<div class="dm-rise" data-rise>
				<svg class="dm-rise__svg" viewBox="0 0 1000 300" preserveAspectRatio="none" aria-hidden="true"><defs><linearGradient id="dm-rise-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#c2f760" stop-opacity=".22"/><stop offset=".7" stop-color="#c2f760" stop-opacity=".04"/><stop offset="1" stop-color="#c2f760" stop-opacity="0"/></linearGradient><linearGradient id="dm-rise-stroke" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#c2f760" stop-opacity=".25"/><stop offset=".55" stop-color="#c2f760" stop-opacity=".8"/><stop offset="1" stop-color="#d8ff8a"/></linearGradient><linearGradient id="dm-rise-fade" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#fff"/><stop offset=".86" stop-color="#fff"/><stop offset="1" stop-color="#000"/></linearGradient><mask id="dm-rise-mask" maskUnits="userSpaceOnUse" x="0" y="-20" width="1000" height="340"><rect x="0" y="-20" width="1000" height="340" fill="url(#dm-rise-fade)"/></mask></defs><g mask="url(#dm-rise-mask)"><path class="dm-rise__area" d="M0.0,279.0 C15.0,276.0 28.3,271.0 90.0,261.0 C151.7,251.0 280.0,239.0 370.0,219.0 C460.0,199.0 545.0,171.0 630.0,141.0 C715.0,111.0 818.3,62.0 880.0,39.0 C941.7,16.0 980.0,9.0 1000.0,3.0 L1000,300 L0,300 Z" fill="url(#dm-rise-fill)"/><line class="dm-rise__drop" x1="90" y1="261" x2="90" y2="300"/><line class="dm-rise__drop" x1="370" y1="219" x2="370" y2="300"/><line class="dm-rise__drop" x1="630" y1="141" x2="630" y2="300"/><line class="dm-rise__drop" x1="880" y1="39" x2="880" y2="300"/><path class="dm-rise__glow" d="M0.0,279.0 C15.0,276.0 28.3,271.0 90.0,261.0 C151.7,251.0 280.0,239.0 370.0,219.0 C460.0,199.0 545.0,171.0 630.0,141.0 C715.0,111.0 818.3,62.0 880.0,39.0 C941.7,16.0 980.0,9.0 1000.0,3.0"/><path class="dm-rise__line" d="M0.0,279.0 C15.0,276.0 28.3,271.0 90.0,261.0 C151.7,251.0 280.0,239.0 370.0,219.0 C460.0,199.0 545.0,171.0 630.0,141.0 C715.0,111.0 818.3,62.0 880.0,39.0 C941.7,16.0 980.0,9.0 1000.0,3.0"/></g></svg>
				<ol class="dm-rise__pts">
					<?php foreach ( array( array( 'Visibility', 9, 87 ), array( 'Engagement', 37, 73 ), array( 'Conversion', 63, 47 ), array( 'Growth', 88, 13 ) ) as $wu_i => $fl ) : ?>
					<li class="dm-rise__pt" style="--x:<?php echo (int) $fl[1]; ?>%;--y:<?php echo (int) $fl[2]; ?>%;--k:<?php echo (int) $wu_i; ?>"><strong><?php echo esc_html( $fl[0] ); ?></strong></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="dm-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing Services That Create', 'Stronger Brand Connections' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Every business needs the right mix of marketing, not just more marketing. From search visibility and targeted campaigns to content and branding, we bring the right services together around your business needs, whether you want to strengthen one area or manage multiple channels.</p></div>
			</div>
			<?php
			$wu_svc_brands = array(
				array( 'google', 'googlesearchconsole', 'semrush' ),
				array( 'googleads', 'meta' ),
				array( 'instagram', 'facebook', 'linkedin', 'youtube' ),
				array( 'canva', 'adobepremierepro', 'adobeaftereffects' ),
				array( 'adobeillustrator', 'figma', 'adobephotoshop' ),
				array( 'wordpress.svg', 'shopify.svg', 'react.svg' ),
				array( 'linkedin', 'youtube', 'google' ),
				array( 'hubspot', 'zoho', 'claude.svg' ),
			);
			$wu_list = array();
			foreach ( $wu_services as $wu_i => $s ) {
				$wu_list[] = array( $s[0], $s[2], '<span class="dm-stack__brands">' . implode( '', array_map( $wu_mark, $wu_svc_brands[ $wu_i ] ) ) . '</span>', $s[3] ? '<a class="ev-more dm-stack__more" href="' . esc_url( $s[3] ) . '">View Our Social Media Marketing Services ' . $wu_ne . '</a>' : '', sprintf( '%02d', $wu_i + 1 ) );
			}
			echo $wu_stack( $wu_list, 'services' ); // phpcs:ignore -- escaped in the helper
			?>
<script>
(function () {
	var NS = 'http://www.w3.org/2000/svg';
	document.querySelectorAll('.wu-dm ol.dm-stack[data-stack]').forEach(function (ol) {
		var rm = matchMedia('(prefers-reduced-motion: reduce)').matches;
		var cards = [].slice.call(ol.children).filter(function (c) { return c.classList.contains('dm-stack__card'); });
		if (!rm) ol.classList.add('is-js');
		var mk = function (n, c) { var e = document.createElementNS(NS, n); if (c) e.setAttribute('class', c); return e; };
		var svg = mk('svg', 'dm-stack__path'); svg.setAttribute('aria-hidden', 'true');
		var groove = mk('path', 'dm-groove'), edge = mk('path', 'dm-groove-edge'), fill = mk('path', 'dm-groove-fill'), orb = mk('circle', 'dm-groove-orb');
		orb.setAttribute('r', '9');
		[groove, edge, fill, orb].forEach(function (e) { svg.appendChild(e); });
		ol.insertBefore(svg, ol.firstChild);
		var len = 0, pts = [], lit = -1;
		var layout = function () {
			var vis = [].slice.call(ol.querySelectorAll('.dm-stack__vis')), o = ol.getBoundingClientRect();
			if (vis.length < 2 || innerWidth <= 860) { svg.style.display = 'none'; cards.forEach(function (c) { c.classList.add('is-lit'); }); return; }
			svg.style.display = '';
			pts = vis.map(function (v) { var r = v.getBoundingClientRect(); return [r.left - o.left + r.width / 2, r.top - o.top + r.height / 2]; });
			var d = 'M' + pts[0][0] + ' ' + (pts[0][1] - 70) + ' L' + pts[0].join(' ');
			for (var i = 1; i < pts.length; i++) { var a = pts[i - 1], b = pts[i], m = (a[1] + b[1]) / 2; d += ' C' + a[0] + ' ' + m + ' ' + b[0] + ' ' + m + ' ' + b.join(' '); }
			[groove, edge, fill].forEach(function (p) { p.setAttribute('d', d); });
			len = fill.getTotalLength(); fill.style.strokeDasharray = len; move();
		};
		var move = function () {
			if (!len) return;
			var o = ol.getBoundingClientRect(), p = (innerHeight * 0.62 - o.top) / (o.height || 1);
			p = Math.max(0, Math.min(1, p)); if (rm) p = 1;
			fill.style.strokeDashoffset = len * (1 - p);
			var pt = fill.getPointAtLength(p * len); orb.setAttribute('cx', pt.x); orb.setAttribute('cy', pt.y);
			orb.style.opacity = p > 0.005 && p < 0.995 ? 1 : 0;
			var y = p * o.height;
			cards.forEach(function (c, i) { if (pts[i] && pts[i][1] - 30 <= y) c.classList.add('is-lit'); else if (pts[i]) c.classList.remove('is-lit'); });
		};
		if ('IntersectionObserver' in window && !rm) {
			var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { threshold: 0, rootMargin: '0px 0px 15% 0px' });
			cards.forEach(function (c) { io.observe(c); });
		} else cards.forEach(function (c) { c.classList.add('is-in'); });
		layout(); addEventListener('resize', layout); addEventListener('load', layout); addEventListener('scroll', move, { passive: true });
		if (window.ResizeObserver) new ResizeObserver(layout).observe(ol);
		setTimeout(layout, 1200);
	});
})();
</script>
		</div>
	</section>

	<!-- 4. Marketing built around your business -->
	<section class="sec ev-sec" id="tailored">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Our approach' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Marketing Built Around Your Business,', 'Not a Ready-Made Template' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p class="dm-soft">Two businesses in the same industry can have completely different customers, competition, budgets and growth ambitions. So why should they follow the same marketing plan?</p><p>We start by understanding what your business needs before recommending services or platforms. The strategy is shaped around your position in the market, the people you want to reach, and the results you want to work towards.</p></div>
			</div>
			<div class="dm-spy" data-spy>
				<div class="dm-spy__stage" aria-hidden="true">
					<div class="dm-plan">
						<div class="dm-plan__hd"><span class="dm-plan__t">Your marketing plan</span><span class="dm-plan__st"><b class="dm-plan__tpl">Template</b><b class="dm-plan__own">Built for you</b></span></div>
						<?php
						$wu_plan = array(
							array( 'Audience', '<span class="dm-pv dm-pv--aud2">' . implode( '', array_map( function ( $f ) { return '<i><img src="' . esc_url( WISEUP_ASSETS . '/landing/img/aud-' . $f . '.webp' ) . '" alt="" width="28" height="28" loading="lazy" decoding="async"></i>'; }, array( 1, 2, 3, 4 ) ) ) . '<em>+</em></span>' ),
							array( 'Market', '<span class="dm-pv dm-pv--map">' . $wu_mark( 'googlemaps.svg' ) . $wu_mark( 'fav-trends.google.com.png' ) . $wu_mark( 'googleanalytics' ) . '</span>' ),
							array( 'Marketing mix', '<span class="dm-pv dm-pv--mix">' . $wu_mark( 'google' ) . $wu_mark( 'meta' ) . $wu_mark( 'instagram' ) . $wu_mark( 'linkedin' ) . $wu_mark( 'youtube' ) . '</span>' ),
							array( 'Creative', '<span class="dm-pv dm-pv--mix">' . $wu_mark( 'adobephotoshop' ) . $wu_mark( 'adobeillustrator' ) . $wu_mark( 'figma' ) . $wu_mark( 'canva' ) . '</span>' ),
							array( 'Insights', '<span class="dm-pv dm-pv--ins2">' . $wu_mark( 'googleanalytics' ) . $wu_mark( 'looker.svg' ) . $wu_mark( 'fav-clarity.microsoft.com.png' ) . '</span>' ),
						);
						foreach ( $wu_plan as $pl ) :
							?>
						<div class="dm-plan__row"><span class="dm-plan__chk"><?php echo $wu_svg( '<path d="M5 12l5 5L20 7"/>', 14, 2.6 ); // phpcs:ignore ?></span><span class="dm-plan__l"><?php echo esc_html( $pl[0] ); ?></span><span class="dm-plan__v"><?php echo $pl[1]; // phpcs:ignore ?><span class="dm-plan__blank"><i></i><i></i></span></span></div>
						<?php endforeach; ?>
					</div>
				</div>
				<ol class="dm-spy__list">
					<?php foreach ( $wu_approach as $wu_i => $s ) : ?>
					<li class="dm-spy__row"><span class="dm-spy__mi" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $s[0] ], 22 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $s[1] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 5. Channels -->
	<section class="sec ev-sec" id="channels">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Channels' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'The Right Strategy Starts', 'With the Right Channels' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p class="dm-intro-lead">Your audience is everywhere. Your marketing doesn’t need to be.</p><p>Each platform serves a different purpose. Some help people find your business when they are actively searching. Others introduce your brand, build relationships or create demand. We choose channels based on where your audience spends time and what you want them to do.</p></div>
			</div>
			<?php
			$wu_orb_pos   = array( array( 50.0, 12.0 ), array( 76.6, 41.3 ), array( 72.3, 80.7 ), array( 33.5, 72.7 ), array( 13.9, 38.3 ) );
			$wu_orb_short = array( 'Google', 'Meta', 'LinkedIn', 'YouTube', 'Pinterest & more' );
			?>
			<div class="dm-orb" data-orb>
				<div class="dm-orb__map">
					<span class="dm-orb__ring dm-orb__ring--a" aria-hidden="true"></span>
					<span class="dm-orb__ring dm-orb__ring--b" aria-hidden="true"></span>
					<svg class="dm-orb__lines" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true"><line x1="50" y1="50" x2="50.0" y2="12.0"/><line x1="50" y1="50" x2="76.6" y2="41.3"/><line x1="50" y1="50" x2="72.3" y2="80.7"/><line x1="50" y1="50" x2="33.5" y2="72.7"/><line x1="50" y1="50" x2="13.9" y2="38.3"/></svg>
					<span class="dm-orb__core" aria-hidden="true"><i></i>Your<br>audience</span>
					<?php foreach ( $wu_channels as $wu_i => $s ) : ?>
					<button type="button" class="dm-orb__node<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" style="--x:<?php echo esc_attr( $wu_orb_pos[ $wu_i ][0] ); ?>%;--y:<?php echo esc_attr( $wu_orb_pos[ $wu_i ][1] ); ?>%" aria-controls="dm-ch-<?php echo (int) $wu_i; ?>" aria-pressed="<?php echo 0 === $wu_i ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( $s[0] ); ?>"><?php echo $wu_mark( 1 === $wu_i ? 'meta' : $s[1][0] ); // phpcs:ignore ?><span aria-hidden="true"><?php echo esc_html( $wu_orb_short[ $wu_i ] ); ?></span></button>
					<?php endforeach; ?>
				</div>
				<div class="dm-orb__panels">
					<?php foreach ( $wu_channels as $wu_i => $s ) : ?>
					<div class="dm-orb__panel<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" id="dm-ch-<?php echo (int) $wu_i; ?>"><span class="dm-orb__marks"><?php foreach ( $s[1] as $m ) echo $wu_mark( $m ); // phpcs:ignore ?></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></div>
					<?php endforeach; ?>
					<span class="dm-orb__bar" aria-hidden="true"><i></i></span>
				</div>
			</div>
		</div>
	</section>

	<!-- 6. Every stage of growth -->
	<section class="sec ev-sec" id="stages">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Stage of growth' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing for Businesses', 'at Every Stage of Growth' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A startup building its first audience does not have the same priorities as an established business entering a new market. Your marketing should reflect where your business stands today and where it wants to go next.</p></div>
			</div>
			<ol class="dm-climb" data-climb>
				<?php foreach ( $wu_stages as $wu_i => $s ) : ?>
				<li class="dm-climb__step" style="--s:<?php echo (int) $wu_i + 1; ?>"><div class="dm-climb__card"><span class="dm-climb__top" aria-hidden="true"><span class="dm-climb__k">Stage <?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><span class="dm-climb__meter"><?php echo str_repeat( '<i></i>', 4 ); // phpcs:ignore ?></span></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></div></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 7. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries', 'We Work With' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>We work with businesses across different sectors, adapting our marketing approach to their audiences, markets and business objectives.</p></div>
			</div>
			<ul class="dm-ind dm-mag" data-mag>
				<?php foreach ( $wu_industries as $wu_i => $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_ind_icons[ $ind[1] ]; // phpcs:ignore ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
			<script>(function(){var u=document.querySelector('[data-mag]');if(!u)return;var li=[].slice.call(u.children);if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){li.forEach(function(l){l.classList.add('is-on');});return;}u.classList.add('is-js');var io=new IntersectionObserver(function(es){es.forEach(function(e){e.target.classList.toggle('is-on',e.isIntersecting);});},{rootMargin:'-42% 0px -42% 0px'});li.forEach(function(l){io.observe(l);});})();</script>
		</div>
	</section>

	<!-- 8. Kerala's business landscape -->
	<section class="sec ev-sec" id="kerala">
		<div class="wrap">
			<div class="ev-head dm-klh">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Kerala' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing That Understands', 'Kerala’s Business Landscape' ); // phpcs:ignore ?></h2>
				</div>
				<div class="dm-klh__lead">
					<p class="ev-lead">Marketing works best when it reflects the people it is trying to reach. Kerala has diverse audiences, regional preferences and local buying behaviours that influence how businesses communicate. Language, location and customer expectations all matter.</p>
						<p>WiseUp considers these factors when planning campaigns for businesses targeting audiences in Kerala, as well as those looking to reach customers beyond the state. Whether your communication needs Malayalam, English or a combination of both, the approach should suit the audience and the brand.</p>
				</div>
			</div>
			<div class="dm-kl dm-kl--v2">
				<div class="ev-map" data-ev-map role="img" aria-label="Map of Kerala with our studio in Kozhikode (Calicut)">
					<canvas class="ev-map__gl" aria-hidden="true"></canvas>
					<canvas class="ev-map__ov" aria-hidden="true"></canvas>
					<span class="ev-map__k" aria-hidden="true">Kerala</span>
					<span class="ev-map__n" aria-hidden="true">N</span>
				</div>
				<div class="dm-kl__right">
				<p class="dm-kl__roll" aria-hidden="true"><span class="dm-kl__pre">Reaching</span><span class="dm-kl__win"><span class="dm-kl__col"><b>Calicut</b><b>Kerala</b><b>India</b><b>the Gulf</b><b>Calicut</b></span></span></p>
				<div class="dm-kl__two">
					<div class="ev-panel dm-kl__it"><span class="dm-kl__r dm-kl__r--1" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg></span><h3>Digital Marketing Company in Calicut, Kerala</h3><p>Based in Calicut, WiseUp works with businesses that want to strengthen their local presence and build a wider digital reach. We consider local search behaviour, audience interests and market competition when shaping campaigns for businesses in and around the city.</p></div>
						<div class="ev-panel dm-kl__it"><span class="dm-kl__r dm-kl__r--3" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg></span><h3>Supporting Businesses Across Kerala and Beyond</h3><p>A business does not have to limit its reach to its immediate location. We work towards marketing objectives that may involve audiences across Kerala and, where relevant, wider national and international markets.</p></div>
				</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 9. Process -->
	<section class="sec ev-sec" id="dm-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'From Strategy to Execution:', 'How WiseUp Brings Marketing Ideas to Life' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A strong campaign needs more than a good idea. It needs a clear plan, thoughtful execution, and regular evaluation. Our process connects each stage so that the work stays aligned with your business objectives.</p></div>
			</div>
			<div class="dm-tl" data-tl>
				<span class="dm-tl__line" aria-hidden="true"><i></i></span>
				<ol class="dm-tl__list">
					<?php foreach ( $wu_process as $wu_i => $s ) : ?>
					<li class="dm-tl__step"><span class="dm-tl__node" aria-hidden="true"><?php echo $wu_tl_icons[ $s[1] ]; // phpcs:ignore ?></span><span class="dm-tl__out" aria-hidden="true"><small>Outcome</small><?php echo esc_html( $wu_outcome[ $wu_i ] ); ?></span><div class="dm-tl__card"><h3><span class="dm-tl__n"><?php echo esc_html( sprintf( '%02d.', $wu_i + 1 ) ); ?></span> <?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 10. Tools -->
	<section class="sec ev-sec" id="tools">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Tools' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'The Tools and Technology', 'Behind Smarter Campaigns' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="dm-tools dm-tools--sr">
				<?php
				$wu_seen = array();
				foreach ( $wu_tools as $g ) foreach ( $g[1] as $tl ) {
					if ( isset( $wu_seen[ $tl[0] ] ) ) continue; // the same tool listed under two groups shows once
					$wu_seen[ $tl[0] ] = true;
					echo '<li>' . $wu_mark( $tl[1] ) . '<span>' . esc_html( $tl[0] ) . '</span></li>'; // phpcs:ignore
				}
				?>
			</ul>
			<?php
			// The tools in the order a campaign uses them: research, create, run, measure (groups are the doc's own).
			$wu_stage_map = array(
				array( 'Research', array( 'SEO & Keyword Research', 'Content & Research' ) ),
				array( 'Create', array( 'Design & Creative Production' ) ),
				array( 'Run', array( 'Paid Advertising', 'Social Media Management', 'Email marketing and automation' ) ),
				array( 'Measure', array( 'Analytics & Reporting' ) ),
			);
			$wu_by_group = array();
			foreach ( $wu_tools as $g ) $wu_by_group[ $g[0] ] = $g[1];
			$wu_seen2 = array();
			?>
			<div class="dm-orbit" data-orbit aria-hidden="true"><span class="dm-orbit__core"><img src="<?php echo esc_url( WISEUP_URL . 'assets/smm/wiso-icon.webp' ); ?>" alt="" width="120" height="120" loading="lazy" decoding="async"></span></div>
			<script>(function(){var o=document.querySelector('[data-orbit]');if(!o)return;var it=[].slice.call(document.querySelectorAll('.dm-tools--sr li')).map(function(li){return{m:li.querySelector('.dm-mark'),n:(li.querySelector('span:not(.dm-mark)')||{}).textContent||''};}).filter(function(x){return x.m;});var seen={};it=it.filter(function(x){var k=x.m.innerHTML;if(seen[k])return false;seen[k]=1;return true;});var dark=/tiktok|buffer|later|mailchimp|chatgpt/i,rings=[7,11,15],i=0;rings.forEach(function(c,r){var ring=document.createElement('div');ring.className='dm-orbit__ring dm-orbit__ring--'+(r+1);var n=Math.min(c,it.length-i);for(var k=0;k<n;k++,i++){var a=k/n*360+(r*17),el=document.createElement('span');el.className='dm-orbit__i'+(dark.test(it[i].n)?' is-dark':'');var rad=a*Math.PI/180;el.style.left=(50+50*Math.cos(rad))+'%';el.style.top=(50+50*Math.sin(rad))+'%';el.innerHTML='<span class="dm-orbit__b">'+it[i].m.outerHTML+'<em>'+it[i].n.replace(/</g,'&lt;')+'</em></span>';ring.appendChild(el);}o.appendChild(ring);});})();</script>
			<ol class="dm-flow2" data-flow aria-hidden="true">
				<?php foreach ( $wu_stage_map as $wu_k => $st ) : ?>
				<li class="dm-flow2__st" style="--k:<?php echo (int) $wu_k; ?>">
					<div class="dm-flow2__hd"><span class="dm-flow2__n"><?php echo esc_html( sprintf( '%02d', $wu_k + 1 ) ); ?></span><span class="dm-flow2__dot"></span></div>
					<h3 class="dm-flow2__t"><?php echo esc_html( $st[0] ); ?></h3>
					<p class="dm-flow2__g"><?php echo esc_html( implode( ' · ', $st[1] ) ); ?></p>
					<ul class="dm-flow2__tools">
						<?php
						foreach ( $st[1] as $gn ) {
							if ( empty( $wu_by_group[ $gn ] ) ) continue;
							foreach ( $wu_by_group[ $gn ] as $tl ) {
								if ( isset( $wu_seen2[ $tl[0] ] ) ) continue;
								$wu_seen2[ $tl[0] ] = true;
								echo '<li' . ( preg_match( '/tiktok|buffer|later|mailchimp|chatgpt/i', $tl[0] ) ? ' class="is-dark"' : '' ) . '>' . $wu_mark( $tl[1] ) . '<span>' . esc_html( $tl[0] ) . '</span></li>'; // phpcs:ignore
							}
						}
						?>
					</ul>
				</li>
				<?php endforeach; ?>
			</ol>
			<script>(function(){var f=document.querySelector('[data-flow]');if(!f)return;if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){f.classList.add('is-in');return;}f.classList.add('is-js');var io=new IntersectionObserver(function(e){if(e[0].isIntersecting){f.classList.add('is-in');io.disconnect();}},{threshold:.15});io.observe(f);})();</script>
		</div>
	</section>

	<!-- 11. Why WiseUp -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Why Businesses', 'Choose WiseUp' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="ev-exp" data-ev-exp>
				<?php foreach ( $wu_why as $wu_i => $w ) : ?>
				<li class="ev-exp__card<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" tabindex="0"><span class="ev-exp__i"><?php echo $wu_svg( $wu_icons[ $w[0] ], 26 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 12. Results -->
	<section class="sec ev-sec" id="results">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Results' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Real Campaigns.', 'Tangible Business Results.' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro dm-intro-btn"><?php echo $wu_btn( 'View Our Case Studies', 'teal', 'href="' . esc_url( home_url( '/case-studies/' ) ) . '"' ); // phpcs:ignore ?></div>
			</div>
			<ul class="dm-brands">
				<?php foreach ( $wu_results as $r ) :
					$tag  = $r[3] ? 'a' : 'div';
					$href = $r[3] ? ' href="' . esc_url( $r[3] ) . '"' : ''; ?>
				<li class="dm-brand dm-brand--<?php echo esc_attr( $r[1] ); ?>"<?php echo ( ! empty( $r[4] ) && ! $r[3] ) ? ' tabindex="0"' : ''; ?>>
					<<?php echo $tag . $href; // phpcs:ignore ?> class="dm-brand__in">
						<span class="dm-brand__art"><?php if ( ! empty( $r[4] ) ) : ?><span class="dm-brand__st"><?php if ( $r[4][0] ) : ?><strong><?php echo esc_html( $r[4][0] ); ?></strong><small><?php echo esc_html( $r[4][1] ); ?></small><?php endif; ?><?php if ( $r[4][2] ) : ?><span><?php echo esc_html( $r[4][2] ); ?></span><?php endif; ?><?php if ( ! empty( $r[4][3] ) ) : ?><em class="dm-brand__mini"><?php foreach ( $r[4][3] as $mi ) echo '<i><b>' . esc_html( $mi[0] ) . '</b>' . esc_html( $mi[1] ) . '</i>'; ?></em><?php endif; ?></span><?php endif; ?>
							<?php if ( 'none' === $r[1] ) : ?>
							<span class="dm-brand__ph" aria-hidden="true"><?php echo $wu_svg( '<path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 9.5V20h13V9.5"/><path d="M9.5 20v-5h5v5"/>', 44, 1.4 ); // phpcs:ignore ?></span>
							<?php else : ?>
							<img src="<?php echo esc_url( $r[2] ); ?>" alt="<?php echo esc_attr( 'logo' === $r[1] ? $r[0] . ' logo' : $r[0] . ' digital marketing campaign by WiseUp, Kerala' ); ?>" loading="lazy" decoding="async">
							<?php endif; ?>
						</span>
						<strong class="dm-brand__name"><?php echo esc_html( $r[0] ); ?></strong>
					</<?php echo $tag; // phpcs:ignore ?>>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 13. Client experiences -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="sh"><h2 class="sh__h"><?php echo $wu_h( 'Beyond Campaigns:', 'Client Experiences' ); // phpcs:ignore ?></h2></div>
			<?php include WISEUP_DIR . 'landing/reviews.php'; ?>
		</div>
	</section>

	<!-- 14. Pricing -->
	<section class="sec ev-sec" id="pricing">
		<div class="wrap">
			<div class="ev-disc">
				<div class="ev-disc__l">
					<div class="sh">
						<?php echo $wu_eyebrow( 'Pricing' ); // phpcs:ignore ?>
						<h2 class="sh__h"><?php echo $wu_h( 'Clear Pricing,', 'Defined Deliverables' ); // phpcs:ignore ?></h2>
					</div>
					<div class="ev-price ev-price--col">
						<p>Every business has different marketing requirements, so the scope of work should reflect what it actually needs. WiseUp’s packages start at ₹60,000, with the final proposal based on your goals, selected services, campaign requirements and expected deliverables.</p>
					</div>
				</div>
				<div class="ev-disc__card">
					<span class="ev-disc__pill">Digital marketing packages</span>
					<p class="ev-disc__from"><span>Packages start at</span><strong>₹60,000</strong></p>
					<?php echo $wu_btn( 'Get Your Custom Proposal', 'teal', $wu_lead ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="dm-pkg">
				<div class="dm-pkg__table">
					<h3>What Your Package Can Cover</h3>
					<ul class="dm-pkg__chips">
						<?php $wu_pk_ic = array( 'mix', 'pen', 'search', 'target', 'chat', 'chart' ); foreach ( $wu_package as $wu_k => $row ) : ?>
						<li><span class="dm-pkg__ic"><?php echo $wu_svg( $wu_icons[ $wu_pk_ic[ $wu_k ] ?? 'spark' ], 22 ); // phpcs:ignore ?></span><span><?php echo esc_html( $row[0] ); ?></span><small class="dm-pkg__d"><?php echo esc_html( $row[1] ); ?></small><button type="button" class="dm-pkg__sw" role="switch" aria-checked="true" aria-label="<?php echo esc_attr( $row[0] ); ?>"><i></i></button></li>
						<?php endforeach; ?>
					</ul>
					<script>(function(){var u=document.querySelector('.dm-pkg__chips');if(!u||!('IntersectionObserver' in window))return;var io=new IntersectionObserver(function(e){if(e[0].isIntersecting){u.classList.add('is-lit');io.disconnect();}},{threshold:.5});io.observe(u);})();</script>
					<script>document.querySelectorAll('.dm-pkg__sw').forEach(function(b){b.addEventListener('click',function(){var on=b.getAttribute('aria-checked')!=='true';b.setAttribute('aria-checked',on?'true':'false');b.closest('li').classList.toggle('is-off',!on);});});</script>
					<table class="dm-pkg__sr">
						<thead><tr><th scope="col">Area</th><th scope="col">Potential Deliverables</th></tr></thead>
						<tbody>
							<?php foreach ( $wu_package as $row ) : ?>
							<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td><?php echo esc_html( $row[1] ); ?></td></tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<p class="ev-note">The deliverables included in a package depend on the agreed scope. Not every service or activity is included in the starting package.</p>
				</div>
				<div class="dm-pkg__side">
					<div class="ev-panel">
						<h3>What Influences the Final Investment?</h3>
						<p>The final investment depends on the number of services and platforms involved, content volume, creative production requirements, advertising objectives, campaign complexity and any website or technical work needed.</p>
					</div>
					<div class="ev-panel dm-pkg__cta">
						<h3>Not Sure Where Your Marketing Budget Should Go?</h3>
						<p>You do not have to invest in every channel at once. Tell us what your business wants to achieve, and we can recommend a practical scope based on your priorities and budget.</p>
						<?php echo $wu_btn( 'Get Your Custom Proposal', 'teal', $wu_lead ); // phpcs:ignore ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 15. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="dm-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="dm-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
			</div>
			<div class="faq">
				<?php foreach ( $wu_faq as $q ) : ?>
				<details class="faq__item" name="faq">
					<summary class="faq__q"><h3><?php echo esc_html( $q[0] ); ?></h3><span class="faq__dot" aria-hidden="true"></span></summary>
					<p class="faq__a"><?php echo esc_html( $q[1] ); ?></p>
				</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php wiseup_other_services( 'wiseup-digital-marketing' ); ?>


	<!-- 16. Final CTA: lead form (Name | Business Name | Email | Phone | Services Required | Tell Us About Your Project) -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Ready to Give Your Brand', 'a Stronger Direction?' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Let’s discuss where your brand stands, what you want to achieve, and how WiseUp can help move things forward.</p>
					<div class="ev-contact">
						<a class="ev-ct ev-ct--wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.27-.2-.57-.35Zm-5.42 7.4h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.89 9.88Zm8.41-18.3A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.69 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.48-8.41Z"/></svg></span>
							<span class="ev-ct__t"><small>Chat on WhatsApp</small>+91 62824 34503</span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
						<a class="ev-ct" href="tel:+916282434503">
							<span class="ev-ct__i"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2Z"/></svg></span>
							<span class="ev-ct__t"><small>Call us</small>+91 62824 34503</span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
					</div>
				</div>
				<form class="ev-form" data-dm-form novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>" data-source="<?php echo esc_attr( $wu_src ); ?>">
					<label><span>Name</span><input name="name" required autocomplete="name"></label>
					<label><span>Business Name</span><input name="company" autocomplete="organization"></label>
					<label><span>Email</span><input name="email" type="email" autocomplete="email"></label>
					<label><span>Phone</span><input name="phone" type="tel" required autocomplete="tel"></label>
					<label class="ev-form__wide"><span>Services Required</span>
						<select name="service" required>
							<option value="" selected disabled>Choose one</option>
							<?php foreach ( $wu_services as $s ) echo '<option>' . esc_html( $s[0] ) . '</option>'; ?>
						</select>
					</label>
					<label class="ev-form__wide"><span>Tell Us About Your Project</span><textarea name="project" rows="4"></textarea></label>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Let’s Talk About Your Growth</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
					<p class="ev-form__note" data-ev-note aria-live="polite"></p>
				</form>
			</div>
		</div>
	</section>
</main>
</div>
<script>
(function () {
	// enquiry form → wiseup/v1/enquiry (saved to Leads); WhatsApp link if sending fails
	var f = document.querySelector('[data-dm-form]');
	if (f) {
		var note = f.querySelector('[data-ev-note]'), btn = f.querySelector('button[type=submit]');
		f.addEventListener('submit', function (e) {
			e.preventDefault();
			var bad = [].slice.call(f.querySelectorAll('input,select,textarea')).filter(function (el) { return el.name !== 'hp_website' && !el.checkValidity(); });
			if (bad.length) { bad[0].focus(); note.textContent = bad[0].name === 'email' ? 'Please check the email address.' : 'Please add your name, phone and the service you need.'; return; }
			var d = new FormData(f), v = function (k) { return String(d.get(k) || '').trim(); };
			var msg = ['Services required: ' + v('service'), 'Business name: ' + (v('company') || '-'), 'Project: ' + (v('project') || '-')].join('\n');
			var wa = 'https://wa.me/916282434503?text=' + encodeURIComponent('Hi WiseUp, I am ' + v('name') + '.\n' + msg);
			btn.disabled = true; note.textContent = 'Sending…';
			fetch(f.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': f.dataset.nonce },
				body: JSON.stringify({ name: v('name'), phone: v('phone'), email: v('email'), service: v('service'), message: msg, page: location.href, source: f.dataset.source, hp_website: v('hp_website') }) })
				.then(function (r) { if (!r.ok) throw 0; f.reset(); note.textContent = 'Thanks, we have your details and will be in touch soon.'; })
				.catch(function () { note.innerHTML = 'Couldn’t send that right now. <a href="' + wa + '" target="_blank" rel="noopener">Send it on WhatsApp instead</a>.'; })
				.then(function () { btn.disabled = false; });
		});
	}
	// reviews carousel
	var qs = document.querySelector('[data-quotes]');
	if (qs) {
		var tr = qs.querySelector('[data-q-track]'), cardsQ = [].slice.call(tr.children), dots = qs.querySelectorAll('.ev-quotes__dots i');
		var step = function (dd) { var w = cardsQ[0].getBoundingClientRect().width + parseFloat(getComputedStyle(tr).columnGap || 0); tr.scrollBy({ left: dd * w, behavior: 'smooth' }); };
		qs.querySelector('[data-q-prev]').addEventListener('click', function () { step(-1); });
		qs.querySelector('[data-q-next]').addEventListener('click', function () { step(1); });
		var mark = function () { var max = tr.scrollWidth - tr.clientWidth, k = max > 0 ? Math.round(tr.scrollLeft / max * (cardsQ.length - 1)) : 0; dots.forEach(function (x, i) { x.classList.toggle('is-on', i === k); }); qs.querySelector('[data-q-prev]').disabled = tr.scrollLeft < 4; qs.querySelector('[data-q-next]').disabled = tr.scrollLeft > max - 4; };
		tr.addEventListener('scroll', function () { requestAnimationFrame(mark); }, { passive: true }); mark();
		var fitQ = function () { cardsQ.forEach(function (c) { var t = c.querySelector('.ev-quote__text'), b = c.querySelector('.ev-quote__more'); if (c.classList.contains('is-open')) return; b.hidden = !(t.scrollHeight > t.clientHeight + 2); }); };
		cardsQ.forEach(function (c) { c.querySelector('.ev-quote__more').addEventListener('click', function () { var o = c.classList.toggle('is-open'); this.textContent = o ? 'Show less' : 'Read more'; this.setAttribute('aria-expanded', o); }); });
		fitQ(); addEventListener('resize', fitQ);
	}
	// "why" cards: the hovered / focused card opens
	document.querySelectorAll('.wu-dm [data-ev-exp]').forEach(function (g) {
		var cs = [].slice.call(g.children);
		cs.forEach(function (c) { var on = function () { cs.forEach(function (x) { x.classList.toggle('is-on', x === c); }); }; c.addEventListener('pointerenter', on); c.addEventListener('focus', on); c.addEventListener('click', on); });
	});
	// approach: the row crossing the middle of the screen is lit, the sticky figure follows it
	if ('IntersectionObserver' in window) document.querySelectorAll('.wu-dm [data-spy]').forEach(function (sp) {
		var rows = [].slice.call(sp.querySelectorAll('.dm-spy__row')), prs = [].slice.call(sp.querySelectorAll('.dm-plan__row')), plan = sp.querySelector('.dm-plan');
		var on = function (k) {
			rows.forEach(function (r, i) { r.classList.toggle('is-on', i === k); });
			prs.forEach(function (r, i) { r.classList.toggle('is-done', i <= k); r.classList.toggle('is-on', i === k); });
			if (plan) plan.classList.toggle('is-built', k === rows.length - 1);
		};
		sp.classList.add('is-spy'); on(0);
		var so = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) on(rows.indexOf(e.target)); }); }, { rootMargin: '-48% 0px -48% 0px' });
		rows.forEach(function (r) { so.observe(r); });
	});
	// channels orbit: a node (or the auto cycle while on screen) chooses the channel shown beside it
	document.querySelectorAll('.wu-dm [data-orb]').forEach(function (orb) {
		var nodes = [].slice.call(orb.querySelectorAll('.dm-orb__node')), panels = [].slice.call(orb.querySelectorAll('.dm-orb__panel')), lines = [].slice.call(orb.querySelectorAll('.dm-orb__lines line'));
		var cur = 0, timer = null, user = false, seen = false;
		var show = function (k) {
			cur = k;
			nodes.forEach(function (n, i) { n.classList.toggle('is-on', i === k); n.setAttribute('aria-pressed', i === k ? 'true' : 'false'); });
			panels.forEach(function (pn, i) { pn.classList.toggle('is-on', i === k); pn.setAttribute('aria-hidden', i === k ? 'false' : 'true'); });
			lines.forEach(function (l, i) { l.classList.toggle('is-on', i === k); });
			var bi = orb.querySelector('.dm-orb__bar i'); if (bi) { bi.style.animation = 'none'; void bi.offsetWidth; bi.style.animation = ''; }
		};
		orb.classList.add('is-live'); show(0);
		nodes.forEach(function (n, i) { n.addEventListener('click', function () { user = true; orb.classList.add('is-user'); clearInterval(timer); show(i); }); });
		if (matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) { orb.classList.add('is-user'); return; }
		new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				clearInterval(timer);
				orb.classList.toggle('is-run', e.isIntersecting && !user);
				if (e.isIntersecting && !user) timer = setInterval(function () { show((cur + 1) % nodes.length); }, 5000);
			});
		}, { threshold: 0.45 }).observe(orb);
	});
	if (matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
	var gs = document.documentElement.classList.contains('wu-motion');
	document.documentElement.classList.add('ev-anim');
	if (!gs) document.querySelectorAll('.wu-dm [data-count]').forEach(function (el) {
		var raw = el.getAttribute('data-count'), to = +raw, dp = (raw.split('.')[1] || '').length, t0 = performance.now();
		(function stp(t) { var k = Math.min(1, (t - t0) / 1400); el.textContent = (to * (1 - Math.pow(1 - k, 3))).toFixed(dp); if (k < 1) requestAnimationFrame(stp); })(t0);
	});
	if (matchMedia('(hover: hover)').matches) {
		document.querySelectorAll('.wu-dm .ev-card').forEach(function (c) {
			c.addEventListener('pointermove', function (e) { var b = c.getBoundingClientRect(); c.style.setProperty('--mx', (e.clientX - b.left) + 'px'); c.style.setProperty('--my', (e.clientY - b.top) + 'px'); });
		});
		var st = document.querySelector('.wu-dm [data-stage]');
		if (st) st.parentNode.addEventListener('pointermove', function (e) { var b = st.getBoundingClientRect(); st.style.setProperty('--rx', ((e.clientX - b.left) / b.width - .5).toFixed(3)); st.style.setProperty('--ry', ((e.clientY - b.top) / b.height - .5).toFixed(3)); });
	}
	var fx = function () {
		if (!window.gsap || !window.ScrollTrigger) return;
		// services: stacking cards; the covered card shrinks back and dims as the next one slides over it
		document.querySelectorAll('.wu-dm [data-stack]').forEach(function (list) {
			var cs = [].slice.call(list.children);
			cs.forEach(function (c, i) {
				var next = cs[i + 1];
				if (!next) return;
				gsap.fromTo(c, { scale: 1, '--dim': 0 }, { scale: 0.94, '--dim': 0.6, ease: 'none', scrollTrigger: { trigger: next, start: 'top bottom', end: function () { return 'top ' + (parseFloat(getComputedStyle(next).top) || 0) + 'px'; }, scrub: true, invalidateOnRefresh: true } });
			});
		});
		// tools: each folder's icons pop in one after another
		gsap.utils.toArray('.wu-dm .dm-tools').forEach(function (g) {
			gsap.from(g.querySelectorAll('.dm-mark'), { scale: 0.5, opacity: 0, duration: 0.7, stagger: 0.05, ease: 'back.out(2)', clearProps: 'transform,opacity', scrollTrigger: { trigger: g, start: 'top 88%', once: true } });
		});
		// stages: the cards climb into a staircase, each drawing its top line
		document.querySelectorAll('.wu-dm [data-climb]').forEach(function (cl) {
			var steps = [].slice.call(cl.children);
			if (matchMedia('(min-width: 1100px)').matches) {
				cl.classList.add('is-live');
				var ct = gsap.timeline({ scrollTrigger: { trigger: cl, start: 'top 90%', end: 'bottom 72%', scrub: 0.7 } });
				steps.forEach(function (s, i) {
					var c = s.querySelector('.dm-climb__card');
					ct.fromTo(c, { y: 150, opacity: 0.1 }, { y: 0, opacity: 1, ease: 'power2.out', duration: 1 }, i * 0.45)
						.fromTo(c, { '--ln': 0 }, { '--ln': 1, ease: 'none', duration: 0.6 }, i * 0.45 + 0.55);
				});
			} else steps.forEach(function (s) { gsap.from(s, { y: 40, opacity: 0, duration: 1, ease: 'expo.out', clearProps: 'transform,opacity', scrollTrigger: { trigger: s, start: 'top 88%', once: true } }); });
		});
		// process: the line fills with the scroll, each step's dot lights as the line reaches it, its card slides in
		document.querySelectorAll('.wu-dm [data-tl]').forEach(function (tl) {
			var wide = matchMedia('(min-width: 900px)').matches;
			tl.classList.add('is-live');
			gsap.fromTo(tl.querySelector('.dm-tl__line i'), { scaleY: 0 }, { scaleY: 1, ease: 'none', scrollTrigger: { trigger: tl, start: 'top 60%', end: 'bottom 60%', scrub: true } });
			[].slice.call(tl.querySelectorAll('.dm-tl__step')).forEach(function (s, i) {
				ScrollTrigger.create({ trigger: s.querySelector('.dm-tl__node'), start: 'center 60%', onEnter: function () { s.classList.add('is-on'); }, onLeaveBack: function () { s.classList.remove('is-on'); } });
				gsap.from(s.querySelector('.dm-tl__card'), { x: wide ? (i % 2 ? 70 : -70) : 40, opacity: 0, duration: 1.1, ease: 'expo.out', clearProps: 'transform,opacity', scrollTrigger: { trigger: s, start: 'top 82%', once: true } });
			});
		});
	};
	if (gs) addEventListener('DOMContentLoaded', function () { if (window.__wuEvMotion) fx(); });
	else addEventListener('load', fx);
	// this page's own blocks: staggered rise (GSAP when the engine runs, otherwise a class toggle)
	var mineSel = '.dm-ind li, .dm-kl .ev-panel, .dm-apps__f, .dm-brand, .dm-pkg__table, .dm-pkg .ev-panel, .ev-quotes';
	var mine = [].slice.call(document.querySelectorAll('.wu-dm :is(' + mineSel + ')'));
	if (gs) {
		// the GSAP scripts load after this one: run once they have
		addEventListener('DOMContentLoaded', function () {
			if (!window.__wuEvMotion || !window.gsap || !window.ScrollTrigger) return;
			gsap.set(mine, { opacity: 0, y: 56 });
			// one IntersectionObserver from the engine instead of a ScrollTrigger per block (fewer forced layouts on refresh)
			if (window.__wuOnceIn) mine.forEach(function (el) { window.__wuOnceIn(el, function (k) { gsap.to(el, { opacity: 1, y: 0, duration: 1.1, delay: k * 0.08, ease: 'expo.out', clearProps: 'transform' }); }); });
			else ScrollTrigger.batch(mine, { start: 'top 90%', once: true, onEnter: function (b) { gsap.to(b, { opacity: 1, y: 0, duration: 1.1, stagger: 0.08, ease: 'expo.out', clearProps: 'transform' }); } });
		});
		return;
	}
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { rootMargin: '0px 0px -8% 0px' });
	document.querySelectorAll('.wu-dm :is(.ev-card, .ev-step, .ev-exp__card, ' + mineSel + ')').forEach(function (el, i) {
		if (el.getBoundingClientRect().top > innerHeight) { el.classList.add('ev-rise'); el.style.setProperty('--d', (i % 3) * 70 + 'ms'); io.observe(el); }
	});
})();
</script>
<script>(function(){if(!matchMedia('(hover: hover)').matches||matchMedia('(prefers-reduced-motion: reduce)').matches)return;document.querySelectorAll('.dm-stack__in').forEach(function(c){c.addEventListener('pointermove',function(e){var b=c.getBoundingClientRect();c.style.setProperty('--sx',(e.clientX-b.left)+'px');c.style.setProperty('--sy',(e.clientY-b.top)+'px');});});})();</script>
<?php
$wu_lead_source = $wu_src;
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js', 'ev-map.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
