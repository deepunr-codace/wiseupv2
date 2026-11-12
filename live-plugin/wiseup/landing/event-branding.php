<?php
/**
 * Event Branding service page ("WiseUp: Event Branding" in the page Template dropdown), built point by point from the
 * owner's brief (Downloads/Event Branding Page.docx, 2026-11-06; owner: "do exactly what the doc says, don't skip
 * anything"). Title tag, meta description, H1, section headings and lists are the doc's own wording. Figures given by
 * the owner on 2026-11-06: 10+ events branded, 100+ cities served, brief 14 days ahead, from ₹25,000, wedding and
 * reception branding offered. Case study figures from wiseup_cs_stats(); the testimonial is the real Google review.
 * Homepage design system: the WiseUp header/footer, .sh / .eyebrow / .b / .faq / .logos from wiseup.css, plus
 * assets/css/event-branding.css.
 */
defined( 'ABSPATH' ) || exit;

$wu_title = apply_filters( 'wiseup_landing_title', 'Event Branding Agency in Kerala | Corporate & Creative Event Branding Services' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'Event branding company in Kerala for corporate events, conferences, exhibitions and hybrid events. Concept, design, production and on-ground branding, handled by one team.' );
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
// Homepage motion (assets/js/event-branding.js): mark the page before first paint so hidden-before-reveal content never
// flashes. If the scripts have not started within 3s the flag is removed and everything shows.
add_action( 'wp_head', function () {
	echo "<script>(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var d=document.documentElement;d.classList.add('wu-motion');setTimeout(function(){if(!window.__wuEvMotion)d.classList.remove('wu-motion');},3000);})();</script>\n";
}, 1 );
add_action( 'wp_head', function () {
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/event-branding.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/event-branding.css' ) ) . "\">\n";
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to talk about branding for an event.' );
$wu_arrow = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg>';
$wu_ne    = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>';
$wu_tick  = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12.5 4.5 4.5L19 7"/></svg>';
$wu_btn   = function ( $label, $look = 'teal', $attrs = '' ) use ( $wu_arrow ) {
	$tag = false !== strpos( $attrs, 'href=' ) ? 'a' : 'button';
	return '<' . $tag . ( 'button' === $tag ? ' type="button"' : '' ) . ' class="b b--' . $look . '" ' . $attrs . '><span class="b__label">' . esc_html( $label ) . '</span><span class="b__ico">' . $wu_arrow . $wu_arrow . '</span></' . $tag . '>';
};
$wu_eyebrow = function ( $t ) { return '<p class="eyebrow"><span class="eyebrow__dot" aria-hidden="true"></span>' . esc_html( $t ) . '</p>'; };
$wu_check   = function ( $items ) use ( $wu_tick ) {
	$o = '<ul class="ev-check">';
	foreach ( $items as $t ) $o .= '<li><span class="ev-check__t">' . $wu_tick . '</span>' . esc_html( $t ) . '</li>';
	return $o . '</ul>';
};
$wu_chips = function ( $items, $soft = false ) {
	$o = '<ul class="ev-chips' . ( $soft ? ' ev-chips--soft' : '' ) . '">';
	foreach ( $items as $t ) $o .= '<li>' . esc_html( $t ) . '</li>';
	return $o . '</ul>';
};

// Client logos: the homepage strip's logo set (same files and alt text).
$wu_logos = array( 'amarapushpa' => 'Amarapushpa', 'bm-prime' => 'BM Prime', 'bucho' => 'Bucho', 'cadd' => 'CADD', 'cellar-de-mahe' => 'Cellar de mahe', 'clair-veda' => 'Clair veda', 'eduwizz' => 'Eduwizz', 'ellisto' => 'Ellisto', 'erets' => 'Erets', 'flora-fauna' => 'Flora fauna', 'formaa' => 'Formaa', 'gloveda' => 'Gloveda', 'goldekarak' => 'Golden Karak', 'hayath' => 'Hayath', 'intervel' => 'Intervel', 'lullaby' => 'Lullaby', 'lunar' => 'Lunar', 'mgf' => 'MGF', 'mooss' => 'mooss', 'onesto-marcado' => 'Onesto Marcado', 'philips' => 'Philips', 'popees' => 'Popees', 'sathya' => 'Sathya', 'superhuman' => 'Superhuman', 'tiny-mafia' => 'Tiny Mafia', 'wellah' => 'Wellah' );
$wu_logo_strip = function ( $label ) use ( $wu_logos ) {
	$li = '';
	foreach ( $wu_logos as $f => $alt ) $li .= '<li class="is-tile"><img src="' . esc_url( WISEUP_ASSETS . '/clients/client-logos-2026/' . $f . '.webp' ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async"></li>';
	return '<div class="logos ev-logos" role="region" aria-label="' . esc_attr( $label ) . '"><div class="logos__marquee"><div class="logos__row"><div class="logos__track"><ul>' . $li . '</ul><ul aria-hidden="true">' . str_replace( '" alt="', '" alt="" data-alt="', $li ) . '</ul></div></div></div></div>';
};

$wu_icons = array(
	'mic'    => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0M12 17.5V21M8.5 21h7"/>',
	'stall'  => '<path d="M3 9h18l-1.5-5h-15z"/><path d="M4.5 9v11h15V9M9 20v-6h6v6"/>',
	'stage'  => '<rect x="3" y="4" width="18" height="11" rx="1.5"/><path d="M2 20h20M7 15v5M17 15v5"/>',
	'sign'   => '<path d="M12 3v18M5 6h11l3 2.5L16 11H5zM19 13H8l-3 2.5L8 18h11z"/>',
	'banner' => '<path d="M7 3h10v14l-5-3-5 3z"/><path d="M9 21h6"/>',
	'badge'  => '<rect x="5" y="3" width="14" height="18" rx="2.5"/><circle cx="12" cy="10" r="2.5"/><path d="M8.5 16.5c.8-1.6 2-2.4 3.5-2.4s2.7.8 3.5 2.4M10 3v2h4V3"/>',
	'spark'  => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M18.4 5.6l-2.8 2.8M8.4 15.6l-2.8 2.8"/>',
	'brush'  => '<path d="M14.5 4.5 19.5 9.5 11 18l-5-5z"/><path d="M6 13c-2 0-3 1.5-3 3.5S2 20 2 20s4 .5 5.5-1 1.5-3.5.5-5"/>',
	'screen' => '<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4M10 8.5l4 1.5-4 1.5z"/>',
	'chat'   => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'bulb'   => '<path d="M9 18h6M10 21h4"/><path d="M12 3a6 6 0 0 0-3.5 10.9c.6.5 1 1.2 1 2.1h5c0-.9.4-1.6 1-2.1A6 6 0 0 0 12 3z"/>',
	'layers' => '<path d="M12 3 3 8l9 5 9-5z"/><path d="M3 13l9 5 9-5"/>',
	'print'  => '<path d="M7 8V3h10v5"/><rect x="3" y="8" width="18" height="9" rx="2"/><path d="M7 14h10v7H7z"/>',
	'tool'   => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/>',
	'box'    => '<path d="M3 7.5 12 3l9 4.5v9L12 21l-9-4.5z"/><path d="M3 7.5 12 12l9-4.5M12 12v9"/>',
	'pin'    => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
	'team'   => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3 20c.5-3.2 3-5 6-5s5.5 1.8 6 5M15 15.5c2.6 0 4.6 1.4 5 4.5"/>',
	'tag'    => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
);

// Services: the doc's nine cards. 'link' = the card's sub-page; fill it in when the sub-page exists.
$wu_services = array(
	array( 'title' => 'Corporate Event Branding', 'icon' => 'mic', 'text' => 'Conferences, launches, and summits branded with clarity and purpose. We design for the room, the audience, and the message you need to land.', 'link' => '' ),
	array( 'title' => 'Exhibition and Stall Branding', 'icon' => 'stall', 'text' => 'Stalls that stand out on a crowded floor and still communicate in seconds. Layout, graphics and messaging are planned together, not added later.', 'link' => '' ),
	array( 'title' => 'Stage, Backdrop and LED Branding', 'icon' => 'stage', 'text' => 'The visuals your audience looks at longest and your photographs capture most. We design for the stage, the screens and the camera.', 'link' => '' ),
	array( 'title' => 'Venue Branding, Signage and Wayfinding', 'icon' => 'sign', 'text' => 'Good signage helps people before they ask for help. We brand the venue so guests find their way easily and feel the theme at every turn.', 'link' => '' ),
	array( 'title' => 'Standees, Banners and Displays', 'icon' => 'banner', 'text' => 'Portable branding that works across entrances, lobbies and sessions. Sized, printed and placed with the venue layout in mind.', 'link' => '' ),
	array( 'title' => 'Event Collateral', 'icon' => 'badge', 'text' => 'Invitations, badges, kits and brochures that carry the theme into guests’ hands. These are the pieces people keep after the event ends.', 'link' => '' ),
	array( 'title' => 'Brand Activation and Experiential', 'icon' => 'spark', 'text' => 'Interactive zones and branded experiences that give guests something to do, not just something to see. Designed to invite participation and conversation.', 'link' => '' ),
	array( 'title' => 'Creative Event Branding', 'icon' => 'brush', 'text' => 'Themes, concepts and custom environments for events that need a bold idea. From festival-style set designs to fully imagined spaces.', 'link' => '' ),
	array( 'title' => 'Virtual and Hybrid Event Branding', 'icon' => 'screen', 'text' => 'Branding that works on a screen as well as in a room. Read more in the virtual and hybrid section below.', 'link' => '#virtual' ),
);

// Portfolio: the two projects the owner sent (2026-11-11), text as given.
$wu_cases = array(
	array(
		'name'    => 'Eallisto',
		'sub'     => 'Corporate Stall Branding & Partnership Signing Ceremonies',
		'tags'    => '',
		'type'    => 'Corporate / Renewable Energy & Energy Solutions',
		'img'     => WISEUP_ASSETS . '/clients/client-logos-2026/ellisto.webp',
		'logo'    => true,
		'url'     => '',
		'problem' => array( 'Eallisto regularly participates in industry events, exhibitions and corporate partnership initiatives. They needed a consistent brand presence at exhibitions and professionally organised partnership signing ceremonies that reflected their corporate identity and strengthened their brand image.' ),
		'did_h'   => 'What we worked on',
		'did'     => array( 'Exhibition stall branding and visual design.', 'Corporate event branding and collateral.', 'End-to-end planning and coordination of corporate partnership signing ceremonies.', 'Professional photography and videography.', 'Anchor sourcing and event hosting.', 'On-ground event management and coordination.', 'Documentation and coverage of key moments, including partnership signings and guest interactions.' ),
		'result'  => 'A consistent and professional brand presence across exhibitions and corporate events, with end-to-end execution of partnership signing ceremonies and high-quality photo and video assets for Eallisto’s marketing, communication and future brand promotions.',
		'stats'   => array(),
		'after'   => '',
	),
	array(
		'name'    => 'Bootland Expo 2026',
		'sub'     => 'Building a Distinctive Brand Identity for a Large-Scale Footwear Expo',
		'tags'    => 'Event branding · Brand strategy · Visual identity · Campaign design · Digital marketing · Event promotion',
		'type'    => 'B2B Exhibition & Trade Event – Footwear and Retail Industry',
		'img'     => WISEUP_URL . 'assets/landing/img/case-bootland.jpg',
		'logo'    => false,
		'url'     => home_url( '/case-studies/bootland/' ),
		'problem' => array( 'Bootland aimed to establish itself as a major footwear exhibition, bringing together footwear brands, manufacturers, retailers, distributors and industry professionals.', 'The challenge was to create more than a conventional trade fair identity. The event needed a distinctive visual personality that could attract attention, build industry recognition and maintain a consistent presence across digital campaigns, promotional materials and the physical exhibition.' ),
		'did_h'   => 'What we branded',
		'did'     => array(
			array( 'Brand Strategy & Identity', 'Developed the Bootland brand identity, including logo design, colour palette and visual language.' ),
			array( 'Visual Communication', 'Established a bold yellow-and-blue colour system with strong typography to create visibility and recognition.' ),
			array( 'Mascot Development', 'Created ‘Go Go’, a distinctive brand character designed to give the expo a recognisable personality and strengthen audience engagement.' ),
			array( 'Campaign Creatives', 'Developed promotional creatives and digital communication for event awareness and audience acquisition.' ),
			array( 'Exhibition Branding', 'Extended the visual identity across physical event spaces, exhibition stalls and promotional touchpoints.' ),
			array( 'Digital & Event Marketing', 'Supported the event through digital promotions, social media campaigns and influencer-led communication.' ),
		),
		'result'  => 'Bootland Expo 2026 established a distinctive event identity supported by integrated digital and on-ground branding. The campaign and event execution delivered measurable reach and industry participation:',
		'stats'   => array( array( '21.6M', 'impressions' ), array( '13.4M', 'reach' ), array( '2,000+', 'registrations and industry professionals' ), array( '45+', 'exhibitors' ), array( '~50', 'participating brands' ) ),
		'after'   => 'The result was a cohesive exhibition brand experience, connecting brand identity, event promotion and physical execution under one consistent visual direction.',
	),
);

$wu_faq = array(
	array( 'What Is Event Branding, and What Does It Include?', 'Event branding gives an event its own identity through a consistent use of name, logo, colours, fonts, themes and signage. In practice, it can include stage backdrops, entrance arches, signage, banners, badges, invitations, presentation templates and social media kits. We agree the exact list with you at the start.' ),
	array( 'How Much Does Event Branding Cost in Kerala?', 'The cost depends on the scale of your event, the number of branded touchpoints, the materials used, the installation involved and your timeline. A small seminar and a multi-day exhibition cannot be priced alike. Share a few details with us and we will send a clear quote showing what is included.' ),
	array( 'How Early Should We Brief an Event Branding Agency?', 'The earlier, the better. For larger events, we recommend sharing the brief a month ahead, which leaves room for concept approval, design, production and installation. Smaller events can often move faster.' ),
	array( 'Do You Handle Printing and Installation, or Only Design?', 'Both. We design, prepare print-ready files, coordinate production and install the branding at the venue. One team stays responsible from concept to installation.' ),
	array( 'Can You Brand Virtual and Hybrid Events?', 'Yes. We design virtual stages, lobbies, webinar templates, motion graphics, lower-thirds and branded joining pages. For hybrid events, we keep the physical and digital identities aligned, so remote and in-person attendees experience the same event.' ),
	array( 'Do You Work Outside Kochi or Kozhikode?', 'Yes. We work across Kerala, including Thiruvananthapuram, Thrissur, Kannur and Malappuram. For events outside our usual cities, we plan site visits and logistics early.' ),
	array( 'What Is the Difference Between Corporate Event Branding and Event Management?', 'Event branding focuses on how the event looks and feels, including its identity, visuals and branded surfaces. Event management handles the wider logistics, such as scheduling, vendors, hospitality and guest handling. They work well together, and we are happy to coordinate with your event manager.' ),
);

add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 20 );

wiseup_landing_open( 'wu-landing wu-ev-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev">
<main id="main">

	<!-- 1. Hero: value proposition, two CTAs (WhatsApp, Get a Quote), proof strip (events branded, cities served, client logos) -->
	<section class="ev-hero">
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
			<?php echo $wu_eyebrow( __( 'Event branding', 'wiseup' ) ); // phpcs:ignore ?>
			<h1 class="ev-hero__h"><span class="sh__a">Event Branding Agency in Kerala</span> <span class="sh__b">for Events People Remember</span></h1>
			<p class="ev-hero__p">People form an opinion about your event long before the first speaker takes the stage. The invitation, the entrance, the backdrop, and even the badge are already speaking for you. WiseUp is an event branding company in Kerala that designs, produces, and installs every one of them, so your event looks like one idea from start to finish.</p>
			<div class="ev-btns">
				<?php echo $wu_btn( 'Chat on WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				<?php echo $wu_btn( 'Get a Quote', 'teal', 'data-lead-open data-lead-source="event-branding"' ); // phpcs:ignore ?>
			</div>
			</div>
			<div class="ev-stage ev-sc" aria-hidden="true" data-stage>
				<svg class="ev-sc__defs" width="0" height="0" aria-hidden="true"><symbol id="ev-wm" viewBox="0 0 960.532 317.019"><path d="M135.035 74.685L173.697 219.947L165.169 219.6L204.116 74.685L235.955 74.685L184.216 247.682L156.924 247.682L113.429 101.38L121.958 101.38L77.894 247.682L50.602 247.682L0 74.685L31.555 74.685L69.365 219.6L61.121 219.947L100.921 74.685L135.035 74.685"/><path d="M243.236 247.682L243.236 74.685L274.784 74.685L274.784 247.682L243.236 247.682"/><path d="M289.692 191.519L289.692 191.519L318.814 191.519Q320.2 205.733 330.948 214.747Q341.695 223.761 361.109 223.761L361.109 223.761Q372.897 223.761 379.831 220.814Q386.764 217.867 389.884 212.667Q393.005 207.466 393.005 200.879L393.005 200.879Q393.005 192.905 388.844 188.398Q384.684 183.892 377.404 180.945Q370.123 177.998 360.069 175.571L360.069 175.571Q348.975 171.758 337.881 167.771Q326.787 163.784 317.253 157.717Q307.72 151.65 301.999 142.809Q296.279 133.969 296.279 121.488L296.279 121.488Q296.279 110.394 300.959 101.207Q305.639 92.019 314.133 85.259Q322.627 78.499 334.068 74.685Q345.508 70.872 359.029 70.872L359.029 70.872Q378.444 70.872 391.445 77.979Q404.445 85.086 411.206 97.913Q417.966 110.741 418.313 127.382L418.313 127.382L390.924 127.382Q388.498 112.474 380.871 105.714Q373.243 98.953 358.683 98.953L358.683 98.953Q343.775 98.953 335.975 105.02Q328.174 111.087 328.174 121.141L328.174 121.141Q328.174 128.422 333.721 133.275Q339.268 138.129 348.455 141.769Q357.643 145.409 369.083 149.223L369.083 149.223Q379.831 153.036 389.711 157.197Q399.592 161.357 407.392 166.731Q415.193 172.104 419.873 180.425Q424.553 188.745 424.553 201.226L424.553 201.226Q424.553 216.133 417.273 227.574Q409.992 239.015 395.951 245.082Q381.911 251.149 361.803 251.149L361.803 251.149Q343.775 251.149 330.948 246.815Q318.12 242.482 309.626 235.375Q301.133 228.268 296.626 220.12Q292.119 211.973 290.559 204.346Q288.998 196.719 289.692 191.519"/><path d="M565.655 191.519L565.655 191.519L595.47 191.519Q592.696 208.853 582.643 222.201Q572.589 235.548 556.121 243.348Q539.653 251.149 517.465 251.149L517.465 251.149Q491.464 251.149 470.663 239.882Q449.861 228.614 438.074 208.333Q426.287 188.052 426.287 161.357L426.287 161.357Q426.287 135.009 437.727 114.554Q449.168 94.1 469.622 82.486Q490.077 70.872 515.732 70.872L515.732 70.872Q543.12 70.872 561.668 82.139Q580.216 93.406 589.23 115.074Q598.243 136.742 596.51 168.637L596.51 168.637L457.835 168.637Q459.569 184.932 467.196 197.239Q474.823 209.546 487.65 216.48Q500.478 223.414 517.465 223.414L517.465 223.414Q535.84 223.414 548.494 214.573Q561.148 205.733 565.655 191.519M516.079 98.953L516.079 98.953Q493.891 98.953 479.156 111.087Q464.422 123.221 459.569 143.329L459.569 143.329L564.615 143.329Q563.228 121.835 549.534 110.394Q535.84 98.953 516.079 98.953"/><path d="M766.04 74.685L766.04 247.682L734.838 247.682L734.838 74.685L766.04 74.685M736.572 166.557L736.572 166.557L736.918 176.611Q736.572 180.771 734.665 189.612Q732.758 198.452 728.771 209.026Q724.784 219.6 717.504 229.308Q710.223 239.015 699.129 245.082Q688.035 251.149 671.741 251.149L671.741 251.149Q660.994 251.149 649.727 248.202Q638.459 245.255 628.925 238.148Q619.391 231.041 613.671 218.56Q607.951 206.08 607.951 187.358L607.951 187.358L607.951 74.685L639.499 74.685L639.499 180.425Q639.499 196.026 644.526 205.039Q649.553 214.053 658.567 217.867Q667.581 221.68 679.022 221.68L679.022 221.68Q697.049 221.68 709.183 212.84Q721.317 203.999 728.078 191.172Q734.838 178.345 736.572 166.557"/><path d="M881.487 251.149L881.487 251.149Q861.726 251.149 848.725 242.482Q835.724 233.815 828.27 219.947Q820.817 206.08 817.523 190.652Q814.23 175.224 814.23 161.357L814.23 161.357Q814.23 142.636 817.35 126.341Q820.47 110.047 827.75 97.566Q835.031 85.086 848.205 77.979Q861.379 70.872 881.487 70.872L881.487 70.872Q903.328 70.872 921.183 82.659Q939.037 94.446 949.784 114.901Q960.532 135.355 960.532 161.357L960.532 161.357Q960.532 187.705 949.611 207.986Q938.69 228.268 920.663 239.708Q902.635 251.149 881.487 251.149M872.82 223.067L872.82 223.067Q889.461 223.067 902.115 215.267Q914.769 207.466 921.703 193.425Q928.636 179.385 928.636 161.357L928.636 161.357Q928.636 134.315 914.076 116.808Q899.515 99.3 872.82 99.3L872.82 99.3Q856.872 99.3 844.391 107.1Q831.911 114.901 824.977 128.768Q818.043 142.636 818.043 161.357L818.043 161.357Q818.043 178.691 824.11 192.559Q830.177 206.426 842.485 214.747Q854.792 223.067 872.82 223.067M786.495 317.019L786.495 74.685L816.656 74.685L818.043 112.821L818.043 317.019L786.495 317.019"/><circle cx="259.01" cy="21.295" r="21.295" fill="#c2f760"/></symbol></svg>
				<figure class="ev-sc__photo">
					<img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/ev-stage-gala.webp' ); ?>" alt="" width="1671" height="941" decoding="async" fetchpriority="high">
					<figcaption class="ev-sc__lower"><svg class="ev-sc__wm" viewBox="0 0 960.532 317.019"><use href="#ev-wm"/></svg><span>Main stage</span></figcaption>
				</figure>
				<div class="ev-sc__rollup">
					<div class="ev-sc__banner">
						<svg class="ev-sc__wm" viewBox="0 0 960.532 317.019"><use href="#ev-wm"/></svg>
						<p class="ev-sc__rh">Events people remember</p>
						<span class="ev-sc__rl">Kozhikode, Kerala</span>
					</div>
					<span class="ev-sc__foot"></span>
				</div>
				<div class="ev-sc__pass">
					<span class="ev-sc__strap"></span>
					<span class="ev-sc__clip"></span>
					<div class="ev-sc__card">
						<div class="ev-sc__chead"><svg class="ev-sc__wm" viewBox="0 0 960.532 317.019"><use href="#ev-wm"/></svg></div>
						<div class="ev-sc__cbody">
							<span class="ev-sc__role">Guest</span>
							<strong class="ev-sc__name">Your name</strong>
							<span class="ev-sc__ev">Your event, 2026</span>
							<svg class="ev-sc__qr" viewBox="-1 -1 23 23" shape-rendering="crispEdges"><path d="M0 0h1v1h-1zM1 0h1v1h-1zM2 0h1v1h-1zM3 0h1v1h-1zM4 0h1v1h-1zM5 0h1v1h-1zM6 0h1v1h-1zM8 0h1v1h-1zM11 0h1v1h-1zM14 0h1v1h-1zM15 0h1v1h-1zM16 0h1v1h-1zM17 0h1v1h-1zM18 0h1v1h-1zM19 0h1v1h-1zM20 0h1v1h-1zM0 1h1v1h-1zM6 1h1v1h-1zM9 1h1v1h-1zM14 1h1v1h-1zM20 1h1v1h-1zM0 2h1v1h-1zM2 2h1v1h-1zM3 2h1v1h-1zM4 2h1v1h-1zM6 2h1v1h-1zM8 2h1v1h-1zM9 2h1v1h-1zM10 2h1v1h-1zM14 2h1v1h-1zM16 2h1v1h-1zM17 2h1v1h-1zM18 2h1v1h-1zM20 2h1v1h-1zM0 3h1v1h-1zM2 3h1v1h-1zM3 3h1v1h-1zM4 3h1v1h-1zM6 3h1v1h-1zM8 3h1v1h-1zM14 3h1v1h-1zM16 3h1v1h-1zM17 3h1v1h-1zM18 3h1v1h-1zM20 3h1v1h-1zM0 4h1v1h-1zM2 4h1v1h-1zM3 4h1v1h-1zM4 4h1v1h-1zM6 4h1v1h-1zM8 4h1v1h-1zM9 4h1v1h-1zM11 4h1v1h-1zM12 4h1v1h-1zM14 4h1v1h-1zM16 4h1v1h-1zM17 4h1v1h-1zM18 4h1v1h-1zM20 4h1v1h-1zM0 5h1v1h-1zM6 5h1v1h-1zM8 5h1v1h-1zM9 5h1v1h-1zM10 5h1v1h-1zM11 5h1v1h-1zM14 5h1v1h-1zM20 5h1v1h-1zM0 6h1v1h-1zM1 6h1v1h-1zM2 6h1v1h-1zM3 6h1v1h-1zM4 6h1v1h-1zM5 6h1v1h-1zM6 6h1v1h-1zM8 6h1v1h-1zM10 6h1v1h-1zM12 6h1v1h-1zM14 6h1v1h-1zM15 6h1v1h-1zM16 6h1v1h-1zM17 6h1v1h-1zM18 6h1v1h-1zM19 6h1v1h-1zM20 6h1v1h-1zM12 7h1v1h-1zM0 8h1v1h-1zM5 8h1v1h-1zM6 8h1v1h-1zM7 8h1v1h-1zM8 8h1v1h-1zM9 8h1v1h-1zM11 8h1v1h-1zM13 8h1v1h-1zM16 8h1v1h-1zM17 8h1v1h-1zM19 8h1v1h-1zM0 9h1v1h-1zM1 9h1v1h-1zM4 9h1v1h-1zM5 9h1v1h-1zM7 9h1v1h-1zM10 9h1v1h-1zM11 9h1v1h-1zM12 9h1v1h-1zM13 9h1v1h-1zM15 9h1v1h-1zM17 9h1v1h-1zM18 9h1v1h-1zM20 9h1v1h-1zM1 10h1v1h-1zM2 10h1v1h-1zM3 10h1v1h-1zM4 10h1v1h-1zM6 10h1v1h-1zM8 10h1v1h-1zM10 10h1v1h-1zM11 10h1v1h-1zM14 10h1v1h-1zM16 10h1v1h-1zM17 10h1v1h-1zM19 10h1v1h-1zM20 10h1v1h-1zM0 11h1v1h-1zM1 11h1v1h-1zM3 11h1v1h-1zM5 11h1v1h-1zM7 11h1v1h-1zM12 11h1v1h-1zM13 11h1v1h-1zM16 11h1v1h-1zM17 11h1v1h-1zM20 11h1v1h-1zM3 12h1v1h-1zM4 12h1v1h-1zM5 12h1v1h-1zM6 12h1v1h-1zM8 12h1v1h-1zM10 12h1v1h-1zM13 12h1v1h-1zM14 12h1v1h-1zM16 12h1v1h-1zM17 12h1v1h-1zM8 13h1v1h-1zM10 13h1v1h-1zM11 13h1v1h-1zM12 13h1v1h-1zM13 13h1v1h-1zM14 13h1v1h-1zM15 13h1v1h-1zM16 13h1v1h-1zM18 13h1v1h-1zM19 13h1v1h-1zM0 14h1v1h-1zM1 14h1v1h-1zM2 14h1v1h-1zM3 14h1v1h-1zM4 14h1v1h-1zM5 14h1v1h-1zM6 14h1v1h-1zM12 14h1v1h-1zM13 14h1v1h-1zM14 14h1v1h-1zM18 14h1v1h-1zM0 15h1v1h-1zM6 15h1v1h-1zM9 15h1v1h-1zM11 15h1v1h-1zM19 15h1v1h-1zM0 16h1v1h-1zM2 16h1v1h-1zM3 16h1v1h-1zM4 16h1v1h-1zM6 16h1v1h-1zM10 16h1v1h-1zM15 16h1v1h-1zM18 16h1v1h-1zM0 17h1v1h-1zM2 17h1v1h-1zM3 17h1v1h-1zM4 17h1v1h-1zM6 17h1v1h-1zM10 17h1v1h-1zM13 17h1v1h-1zM15 17h1v1h-1zM17 17h1v1h-1zM20 17h1v1h-1zM0 18h1v1h-1zM2 18h1v1h-1zM3 18h1v1h-1zM4 18h1v1h-1zM6 18h1v1h-1zM12 18h1v1h-1zM13 18h1v1h-1zM14 18h1v1h-1zM16 18h1v1h-1zM17 18h1v1h-1zM20 18h1v1h-1zM0 19h1v1h-1zM6 19h1v1h-1zM9 19h1v1h-1zM11 19h1v1h-1zM12 19h1v1h-1zM16 19h1v1h-1zM18 19h1v1h-1zM19 19h1v1h-1zM0 20h1v1h-1zM1 20h1v1h-1zM2 20h1v1h-1zM3 20h1v1h-1zM4 20h1v1h-1zM5 20h1v1h-1zM6 20h1v1h-1zM12 20h1v1h-1zM13 20h1v1h-1zM14 20h1v1h-1zM15 20h1v1h-1zM16 20h1v1h-1zM17 20h1v1h-1zM20 20h1v1h-1z"/></svg>
						</div>
					</div>
				</div>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					array( '10', '+', 'Events branded' ),
					array( '120', '+', 'Projects delivered' ),
					array( '13.4', 'M+', 'Campaign reach' ),
					array( '50', '+', 'Brands at Bootland Expo' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
		<?php echo $wu_logo_strip( 'Client logos' ); // phpcs:ignore ?>
	</section>

	<div class="ev-ticker" aria-hidden="true"><div class="ev-ticker__track">
		<?php $wu_tk = ''; foreach ( array( 'Conferences', 'Product launches', 'Award nights', 'Exhibitions', 'Leadership summits', 'Dealer meets', 'Inaugurations', 'College fests', 'Trade shows', 'Cultural festivals' ) as $t ) $wu_tk .= '<span>' . esc_html( $t ) . '</span><i></i>'; echo '<div>' . $wu_tk . '</div><div>' . $wu_tk . '</div>'; // phpcs:ignore ?>
	</div></div>

	<!-- 2. One event, one identity -->
	<section class="sec ev-sec" id="what">
		<div class="wrap ev-split">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Event branding' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">One Event, One Identity:</span> <span class="sh__b">What Event Branding Really Means</span></h2>
			</div>
			<div class="ev-prose">
				<p class="ev-lead">Event branding is the practice of giving an event its own visual identity and tone, so that every part of it feels like it belongs together. The name, logo, colours, fonts, theme and signage all work as one identity, from the invitation people receive to the backdrop they photograph. At WiseUp, we see this as strategic work, not decoration. Done well, guests do not notice the branding as separate pieces. They simply feel that the event was thought through.</p>
				<h3>Same Family, Its Own Personality</h3>
				<p>A company already has a brand identity, so why does an event need another one? Because an event is a moment with its own purpose, audience, and mood. A leadership summit and a customer celebration may belong to the same company, yet they should not look or sound identical.</p>
				<p>Branding for an event should echo the parent brand enough to be recognised, and still stand on its own. At WiseUp, we borrow the right cues from your brand, then build a distinct theme around the occasion. That balance is what makes an event feel connected to your company without being a repeat of your brochure.</p>
			</div>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="services">
		<div class="wrap">
			<div class="ev-head ev-head--center">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Event Branding Services</span> <span class="sh__b">for Every Part of Your Event</span></h2>
			</div>
			<div class="ev-intro"><p>Think back to the last event you attended. You probably cannot recall every slide or speaker, but you remember how it felt to walk in: the arch, the signage, the stage lit in one colour story. That feeling was never an accident. Guests meet your event as a series of small encounters, from the invitation to the registration desk to the kit they carry home, and each one either strengthens the story or weakens it. Our event branding services cover all of them, so nothing feels like an afterthought.</p></div>
			</div>
			<ul class="ev-cards">
				<?php foreach ( $wu_services as $s ) : ?>
				<li class="ev-card">
					<span class="ev-ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons[ $s['icon'] ]; // phpcs:ignore -- fixed markup ?></svg></span>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p><?php echo esc_html( $s['text'] ); ?></p>
					<?php if ( $s['link'] ) : ?><a class="ev-more" href="<?php echo esc_attr( $s['link'] ); ?>">Learn more <?php echo $wu_ne; // phpcs:ignore ?></a><?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 4. Corporate events -->
	<section class="sec ev-sec" id="corporate">
		<div class="wrap">
			<div class="ev-head">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Corporate' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Corporate Events Deserve</span> <span class="sh__b">More Than a Logo on a Backdrop</span></h2>
			</div>
			<div class="ev-intro">
				<p>A corporate event carries real expectations. Leaders want the message to land, partners want to feel valued and attendees want an experience worth their time. Corporate event branding is how that intent becomes visible.</p>
				<p>Our corporate event branding services begin with what the event is meant to achieve. A product launch needs momentum and focus. An AGM needs clarity and credibility. An award night needs a sense of occasion. We shape the visual identity around that purpose, then carry it through every branded surface.</p>
			</div>
			</div>
			<div class="ev-corp">
				<div class="ev-panel">
					<h3>Events We Brand</h3>
					<p>We work on conferences, leadership summits, product launches, award nights, dealer and partner meets, AGMs and trade shows. Each has its own audience and pace, so no two get the same treatment.</p>
					<h3>Sectors We Understand</h3>
					<p>Different industries ask for different tones, and we adjust accordingly.</p>
					<ul class="ev-sectors">
						<?php foreach ( array(
							array( 'Healthcare', '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.4 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/><path d="M7.5 12.5h2.6l1.4-2.4 2 4.2 1.4-1.8h1.6"/>' ),
							array( 'Education', '<path d="M2.5 9 12 4.5 21.5 9 12 13.5z"/><path d="M6.5 11v5c1.6 1.6 3.4 2.3 5.5 2.3s3.9-.7 5.5-2.3v-5M21.5 9v5"/>' ),
							array( 'Government', '<path d="M3 9.5 12 4l9 5.5z"/><path d="M5 9.5v8M9.7 9.5v8M14.3 9.5v8M19 9.5v8M3 20h18M4 17.5h16"/>' ),
							array( 'Startups', '<path d="M14.5 4.5c3-1 5-1 5-1s0 2-1 5l-5.5 5.5-4-4z"/><path d="M9 10 6 9.5 3.5 12l4 1M14 15l.5 3-2.5 2.5-1-4M8 16c-1.5.3-2.8 1.6-3.5 4 2.4-.7 3.7-2 4-3.5"/><circle cx="15.5" cy="8.5" r="1.3"/>' ),
							array( 'Retail', '<path d="M5 8h14l-1.2 12H6.2z"/><path d="M9 10V7a3 3 0 0 1 6 0v3"/>' ),
							array( 'Tourism and hospitality', '<path d="M12 21v-9.5"/><path d="M12 11.5C10 8 6.5 7.5 4 9c2.2-3.3 6-3.6 8 2.5zM12 11.5c2-3.5 5.5-4 8-2.5-2.2-3.3-6-3.6-8 2.5zM12 11.5c-.5-3.4-2.8-5.6-5.5-6 3-1.4 5.6.4 5.5 6zM12 11.5c.5-3.4 2.8-5.6 5.5-6-3-1.4-5.6.4-5.5 6z"/><path d="M5 21c2.3-1.3 4.6-1.3 7 0s4.7 1.3 7 0"/>' ),
						) as $sec ) : ?>
						<li><span class="ev-sectors__i"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $sec[1]; // phpcs:ignore -- fixed markup ?></svg></span><strong><?php echo esc_html( $sec[0] ); ?></strong></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="ev-panel ev-panel--list">
					<h3>What One Corporate Event Might Include</h3>
					<p>Here is a sample deliverables list for a single event:</p>
					<?php echo $wu_check( array( 'Main stage backdrop', 'Entrance arch', 'Registration desk branding', 'Signage set', 'Delegate badges', 'Presentation template', 'Social media kit' ) ); // phpcs:ignore ?>
					<p class="ev-note">Your event may need more or fewer pieces. We agree the list with you at the start, so you know exactly what is covered.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 5. Virtual and hybrid (doc order: before the process) -->
	<section class="sec ev-sec" id="virtual">
		<div class="wrap">
			<div class="ev-head">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Virtual and hybrid' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">In the Room and on the Screen:</span> <span class="sh__b">Virtual and Hybrid Event Branding</span></h2>
			</div>
			<div class="ev-intro"><p>A virtual event has no venue to walk through and no entrance arch to set the mood. Everything your audience knows about your brand arrives through a screen, where attention is far easier to lose. At WiseUp, we design virtual and hybrid events as experiences in their own right, not as scaled-down versions of an on-site plan.</p></div>
			</div>
			<div class="ev-three">
				<div class="ev-panel">
					<h3>Virtual Event Branding: Making a Platform Feel Like Your Event</h3>
					<p>On-site branding fills a physical space. Virtual branding has to build one. We map every point where an attendee meets your brand, from the invitation email to the closing screen, and give each a consistent look. That usually includes:</p>
					<?php echo $wu_check( array( 'The platform lobby and the first screen attendees see', 'Branded joining pages and reminder emails', 'Virtual backgrounds for speakers', 'Presentation slides and motion graphics', 'Lower-thirds and speaker identification' ) ); // phpcs:ignore ?>
					<p class="ev-note">Each of these appears for only a few seconds. Together, they decide whether the event feels organised or improvised.</p>
				</div>
				<div class="ev-panel">
					<h3>Hybrid Event Branding: One Identity, Two Audiences</h3>
					<p>The risk in a hybrid event is that remote attendees feel like an afterthought. We keep the physical and digital identities aligned, so a delegate in the hall and a delegate at a laptop experience the same event. We also brand the entry experience for remote attendees, so their first impression matches what guests get at the registration desk. Where it suits the event, we design kits that reach them in advance, which helps people at home feel part of the room before it begins.</p>
				</div>
				<div class="ev-panel ev-panel--list">
					<h3>What a Virtual or Hybrid Package Includes</h3>
					<?php echo $wu_check( array( 'Virtual stage and lobby design', 'Branded webinar template', 'Social media and email kit', 'LED and livestream overlay' ) ); // phpcs:ignore ?>
					<p class="ev-note">Tell us the platform and the format, and we will recommend what your event actually needs.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 6. Process -->
	<section class="sec ev-sec" id="process">
		<div class="wrap">
			<div class="ev-head">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">From Creative Thinking</span> <span class="sh__b">to On-Site Branding</span></h2>
			</div>
			<div class="ev-intro"><p>Good event branding needs a clear plan from the first idea to the final setup. Here’s how we bring it all together.</p><div class="ev-intro__btn"><?php echo $wu_btn( 'Get a Quote', 'teal', 'data-lead-open data-lead-source="event-branding"' ); // phpcs:ignore ?></div></div>
			</div>
			<ol class="ev-tsteps">
				<?php foreach ( array(
					array( 'Brief and Discovery', 'We discuss your event goals, audience, venue, timeline and branding requirements.' ),
					array( 'Creative Direction', 'We develop the event concept, visual style and creative direction for your approval.' ),
					array( 'Design and Templates', 'We create the designs and templates needed to maintain a consistent look across all event materials.' ),
					array( 'Production and Coordination', 'We prepare print-ready artwork and coordinate with printers and fabricators to get everything production-ready.' ),
					array( 'On-Site Installation', 'We oversee the branding setup at the venue to ensure every element is placed and presented as planned.' ),
					array( 'Post-Event Handover', 'We share the final design files and reusable digital assets for your future promotions and events.' ),
				) as $i => $s ) : ?>
				<?php $wu_si = array( 'chat', 'bulb', 'layers', 'print', 'tool', 'box' ); ?>
				<li class="ev-step ev-tstep"><span class="ev-tstep__i"><svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons[ $wu_si[ $i ] ]; // phpcs:ignore -- fixed markup ?></svg></span><span class="ev-tstep__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
			<div class="ev-timeline">
				<div class="ev-timeline__num"><strong>1</strong><span>month</span></div>
				<div class="ev-timeline__txt">
					<p class="ev-timeline__k">Typical timeline</p>
					<p>Send us the brief at least a month before the event. That leaves time for the concept, your approvals, printing and installation.</p>
				</div>
				<ol class="ev-timeline__track" aria-hidden="true">
					<li><span>Brief</span></li><li><span>Concept</span></li><li><span>Approvals</span></li><li><span>Printing</span></li><li><span>Installation</span></li><li class="is-day"><span>Event day</span></li>
				</ol>
			</div>
		</div>
	</section>

	<!-- 7. One team -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="ev-head ev-head--center">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">One Team Behind</span> <span class="sh__b">Every Event Detail</span></h2>
			</div>
			<div class="ev-intro"><p>Event branding involves more than creating designs. Every element needs to look right in print and work in the venue. At WiseUp, one team manages the process from the first concept to the final installation, keeping every detail connected.</p></div>
			</div>
			<ul class="ev-exp" data-ev-exp>
				<li class="ev-exp__card is-on" tabindex="0"><span class="ev-exp__i"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons['pin']; // phpcs:ignore ?></svg></span><span class="ev-exp__n">01</span><h3>Local Knowledge, On‑Site Support</h3><p>Based in Kerala, we can visit venues, assess spaces and take measurements before the design work begins. This helps us plan branding that fits the actual event environment.</p></li>
				<li class="ev-exp__card" tabindex="0"><span class="ev-exp__i"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons['print']; // phpcs:ignore ?></svg></span><span class="ev-exp__n">02</span><h3>Designs Ready for Production</h3><p>We prepare artwork with the correct dimensions, bleed and colour specifications, reducing avoidable printing errors and last-minute changes.</p></li>
				<li class="ev-exp__card" tabindex="0"><span class="ev-exp__i"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons['team']; // phpcs:ignore ?></svg></span><span class="ev-exp__n">03</span><h3>One Team from Design to Installation</h3><p>The same team that develops your event branding oversees its execution. This keeps the original creative direction consistent through production and installation.</p></li>
				<li class="ev-exp__card" tabindex="0"><span class="ev-exp__i"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons['tag']; // phpcs:ignore ?></svg></span><span class="ev-exp__n">04</span><h3>Clear and Practical Pricing</h3><p>We explain the factors that shape your event branding costs, so you know what is included and can plan your budget with confidence.</p></li>
				<li class="ev-exp__card" tabindex="0"><span class="ev-exp__i"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_icons['spark']; // phpcs:ignore ?></svg></span><span class="ev-exp__n">05</span><h3>Experience Across Local Event Formats</h3><p>From inaugurations and college fests to trade fairs and cultural festivals, we consider the purpose, audience and setting of each event when planning its branding.</p></li>
			</ul>
		</div>
	</section>

	<!-- 8. Across Kerala -->
	<section class="sec ev-sec" id="kerala">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Kerala' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Every City Has Its Own Stage:</span> <span class="sh__b">Event Branding Across Kerala</span></h2>
			</div>
			<div class="ev-kl">
				<div class="ev-route">
					<div class="ev-route__head"><h3>Cities We Work In</h3><span class="ev-route__dir" aria-hidden="true">North &rarr; South</span></div>
					<p class="ev-route__lead">We plan and promote events across the state, including:</p>
					<ol class="ev-route__list">
						<?php foreach ( array( array( 'Kannur', false ), array( 'Kozhikode', true ), array( 'Malappuram', false ), array( 'Thrissur', false ), array( 'Kochi', false ), array( 'Alappuzha', false ), array( 'Kollam', false ), array( 'Thiruvananthapuram', false ) ) as $wu_ci => $c ) : ?>
						<li class="ev-stop<?php echo $c[1] ? ' is-home' : ''; ?>" data-ev-city="<?php echo (int) $wu_ci; ?>">
							<span class="ev-stop__dot" aria-hidden="true"></span>
							<div><strong><?php echo esc_html( $c[0] ); ?></strong><?php if ( $c[1] ) : ?> <span class="ev-stop__pill">Our studio</span><?php endif; ?></div>
						</li>
						<?php endforeach; ?>
						<li class="ev-stop ev-stop--more"><span class="ev-stop__dot" aria-hidden="true"></span><div><p>We also take on events in other districts when the date and the brief call for it.</p></div></li>
					</ol>
				</div>
				<div class="ev-map" data-ev-map role="img" aria-label="Map of Kerala showing Kannur, Kozhikode (our studio), Malappuram, Thrissur, Kochi, Alappuzha, Kollam and Thiruvananthapuram">
					<canvas class="ev-map__gl" aria-hidden="true"></canvas>
					<canvas class="ev-map__ov" aria-hidden="true"></canvas>
					<span class="ev-map__k" aria-hidden="true">Kerala</span>
					<span class="ev-map__n" aria-hidden="true">N</span>
				</div>
				<div class="ev-kl__side">
					<div class="ev-panel ev-kl__lead">
						<p class="ev-lead">Events in Kerala are as varied as the state itself. A trade fair in Kochi, a college fest in Kozhikode and a cultural festival in Thrissur all call for different thinking. As an event branding agency in Kerala, we bring local understanding to each.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 9. Portfolio -->
	<section class="sec ev-sec" id="work">
		<div class="wrap">
			<div class="ev-head">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Portfolio' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Making Every Event</span> <span class="sh__b">a Brand Experience</span></h2>
			</div>
			<div class="ev-intro"><p>A portfolio shows more than a list of services ever could. Each project below follows the same structure, so you can see how we think and what the result was.</p></div>
			</div>
			<div class="ev-cases ev-cases--two">
				<?php foreach ( $wu_cases as $c ) : ?>
				<article class="ev-case">
					<?php if ( $c['url'] ) : ?><a class="ev-case__img" href="<?php echo esc_url( $c['url'] ); ?>" tabindex="-1" aria-hidden="true"><?php else : ?><div class="ev-case__img<?php echo $c['logo'] ? ' ev-case__img--logo' : ''; ?>" aria-hidden="true"><?php endif; ?><img src="<?php echo esc_url( $c['img'] ); ?>" alt="" loading="lazy" decoding="async"><?php echo $c['url'] ? '</a>' : '</div>'; ?>
					<div class="ev-case__body">
						<?php if ( $c['tags'] ) : ?><p class="ev-case__type"><?php echo esc_html( $c['tags'] ); ?></p><?php endif; ?>
						<h3><?php if ( $c['url'] ) : ?><a href="<?php echo esc_url( $c['url'] ); ?>"><?php echo esc_html( $c['name'] ); ?></a><?php else : echo esc_html( $c['name'] ); endif; ?></h3>
						<p class="ev-case__sub"><?php echo esc_html( $c['sub'] ); ?></p>
						<p class="ev-case__client"><span>Client type</span><?php echo esc_html( $c['type'] ); ?></p>
						<?php $wu_tid = 'evc-' . sanitize_title( $c['name'] ); ?>
						<div class="ev-tabs" data-tabs>
							<div class="ev-tabs__bar" role="tablist" aria-label="<?php echo esc_attr( $c['name'] ); ?>">
								<?php foreach ( array( 'challenge' => 'The challenge', 'did' => $c['did_h'], 'result' => 'The result' ) as $k => $t ) : ?>
								<button type="button" role="tab" id="<?php echo esc_attr( $wu_tid . '-t-' . $k ); ?>" aria-controls="<?php echo esc_attr( $wu_tid . '-' . $k ); ?>" aria-selected="<?php echo 'challenge' === $k ? 'true' : 'false'; ?>" tabindex="<?php echo 'challenge' === $k ? '0' : '-1'; ?>"><?php echo esc_html( $t ); ?></button>
								<?php endforeach; ?>
							</div>
							<div class="ev-tabs__panes">
								<div class="ev-tabs__pane is-on" role="tabpanel" id="<?php echo esc_attr( $wu_tid . '-challenge' ); ?>" aria-labelledby="<?php echo esc_attr( $wu_tid . '-t-challenge' ); ?>"><?php foreach ( $c['problem'] as $pp ) echo '<p>' . esc_html( $pp ) . '</p>'; ?></div>
								<div class="ev-tabs__pane" role="tabpanel" id="<?php echo esc_attr( $wu_tid . '-did' ); ?>" aria-labelledby="<?php echo esc_attr( $wu_tid . '-t-did' ); ?>"><ul class="ev-case__did"><?php foreach ( $c['did'] as $d ) echo '<li>' . ( is_array( $d ) ? '<strong>' . esc_html( $d[0] ) . ':</strong> ' . esc_html( $d[1] ) : esc_html( $d ) ) . '</li>'; ?></ul></div>
								<div class="ev-tabs__pane" role="tabpanel" id="<?php echo esc_attr( $wu_tid . '-result' ); ?>" aria-labelledby="<?php echo esc_attr( $wu_tid . '-t-result' ); ?>"><p><?php echo esc_html( $c['result'] ); ?></p><?php if ( $c['stats'] ) : ?><ul class="ev-case__stats"><?php foreach ( $c['stats'] as $st ) : ?><li><strong><?php echo esc_html( $st[0] ); ?></strong><span><?php echo esc_html( $st[1] ); ?></span></li><?php endforeach; ?></ul><?php endif; ?><?php if ( $c['after'] ) : ?><p><?php echo esc_html( $c['after'] ); ?></p><?php endif; ?></div>
							</div>
						</div>
						<?php if ( $c['url'] ) : ?><a class="ev-more" href="<?php echo esc_url( $c['url'] ); ?>">View case study <?php echo $wu_ne; // phpcs:ignore ?></a><?php endif; ?>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
			<div class="ev-quotes" data-quotes>
				<div class="ev-quotes__head">
					<h3 class="ev-quotes__h">What clients say</h3>
					<div class="ev-quotes__nav">
						<button type="button" class="ev-qnav" data-q-prev aria-label="Previous review"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M10.5 6.5 5 12l5.5 5.5"/></svg></button>
						<button type="button" class="ev-qnav" data-q-next aria-label="Next review"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg></button>
					</div>
				</div>
				<div class="ev-quotes__track" data-q-track tabindex="0" aria-label="Client reviews">
					<figure class="ev-quote" data-quote>
						<div class="ev-quote__head"><span class="ev-quote__mark" aria-hidden="true">&ldquo;</span><div class="ev-quote__stars" role="img" aria-label="5 out of 5 stars">★★★★★</div></div>
						<blockquote class="ev-quote__text"><p>We had a wonderful experience working with WiseUp for Sathya Agencies. Their team handled our video production projects professionally with creative concepts and trending video ideas that perfectly matched our brand. The quality of the videos, editing, and overall presentation was excellent and helped us attract more customer attention online.</p><p>Apart from video production, WiseUp also provided strong support for our digital presence. Their digital marketing strategies, creative content, and consistent support helped improve our online visibility and engagement. The team was responsive, creative, and always ready to bring fresh ideas to the table.</p><p>We truly appreciate their dedication, professionalism, and innovative approach. Highly recommended for anyone looking for quality video production, branding, and digital marketing services.</p></blockquote>
						<button class="ev-quote__more" type="button" hidden aria-expanded="false">Read more</button>
						<figcaption><span class="ev-quote__av" aria-hidden="true">A</span><span><strong>Arjun</strong><span>Branding Manager, Sathya Agencies · Google review</span></span></figcaption>
					</figure>
					<figure class="ev-quote" data-quote>
						<div class="ev-quote__head"><span class="ev-quote__mark" aria-hidden="true">&ldquo;</span><div class="ev-quote__stars" role="img" aria-label="5 out of 5 stars">★★★★★</div></div>
						<blockquote class="ev-quote__text"><p>We are very satisfied with the social media marketing services provided by WiseUp Branding. Since they started managing our social media pages, we have seen a noticeable increase in engagement and sales.</p><p>Their team is creative, professional, and always supportive whenever we need assistance or updates. They truly understand branding and marketing strategies that work.</p><p>Thank you, WiseUp Branding, for your continuous support and dedication. Highly recommended for businesses looking to grow online!</p></blockquote>
						<button class="ev-quote__more" type="button" hidden aria-expanded="false">Read more</button>
						<figcaption><span class="ev-quote__av" aria-hidden="true">M</span><span><strong>Mohamed Afsal K</strong><span>Director (Sales and Marketing), Onesto and Mercado Pvt Ltd · Google review</span></span></figcaption>
					</figure>
					<figure class="ev-quote" data-quote>
						<div class="ev-quote__head"><span class="ev-quote__mark" aria-hidden="true">&ldquo;</span><div class="ev-quote__stars" role="img" aria-label="5 out of 5 stars">★★★★★</div></div>
						<blockquote class="ev-quote__text"><p>I recently got my logo designed and I’m extremely happy with the result. The designer perfectly understood my vision and created a logo that looks professional, unique, and elegant. The communication was smooth, delivery was on time, and the overall experience was excellent. Highly recommend for anyone looking for quality branding and logo design work.</p></blockquote>
						<button class="ev-quote__more" type="button" hidden aria-expanded="false">Read more</button>
						<figcaption><span class="ev-quote__av" aria-hidden="true">S</span><span><strong>Sharlet N Shaji</strong><span>Google review</span></span></figcaption>
					</figure>
				</div>
				<div class="ev-quotes__dots" aria-hidden="true"><i></i><i></i><i></i></div>
			</div>
		</div>
	</section>

		<!-- 10. Pricing -->
	<section class="sec ev-sec" id="pricing">
		<div class="wrap ev-disc">
			<div class="ev-disc__l">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Pricing' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Pricing That Fits</span> <span class="sh__b">Your Event Goals</span></h2>
				</div>
				<div class="ev-price ev-price--col">
				<p>A full house does not happen by itself. Someone has to know about your event, want to come, and then actually walk in. That is the work we do at WiseUp, and our event branding and promotion packages start from ₹1 lakh.</p>
				<p>Our focus is on bringing people to your event and to your stall. We plan how your event reaches the right audience, build the buzz before the doors open, and drive walk-ins while it is running. For exhibitors, that includes bringing visitors to your stall, so your investment in the space turns into real conversations.</p>
				<p>Printing, fabrication, and set construction are handled by specialist vendors, and we coordinate with them so your branding stays consistent. What you pay us for is the thinking and the reach: getting your event in front of as many of the right people as possible.</p>
				<p>Every event is different, so your final quote depends on what you want to achieve. Share your event date and goals, and we will send a clear quote showing what is included.</p>
				</div>
			</div>
			<div class="ev-disc__card">
				<span class="ev-disc__pill">Event branding and promotion</span>
				<p class="ev-disc__from"><span>Starting from</span><strong>₹1 lakh</strong></p>
				<p class="ev-disc__note">One plan before the price</p>
				<?php echo $wu_btn( 'Get a Quote', 'teal', 'data-lead-open data-lead-source="event-branding"' ); // phpcs:ignore ?>
			</div>
		</div>
	</section>

	<!-- 11. How to tell the difference -->
	<section class="sec ev-sec" id="choose">
		<div class="wrap">
			<div class="ev-head">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Choosing an agency' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Not All Event Branding Agencies Work Alike:</span> <span class="sh__b">How to Tell the Difference</span></h2>
			</div>
			<div class="ev-intro"><p>Most agencies can show you an attractive mood board. Fewer can tell you who will be at the venue at 6 am on setup day. The checks that separate the two are practical, and they are far easier to make before you sign than after something goes wrong. Here is what we would look at in your position.</p></div>
			</div>
			<ol class="ev-choose">
				<?php foreach ( array(
					array( 'Portfolio relevance', 'Ask for work from events of a similar size and type. Look for photographs of real installations, not only digital mock-ups, because a design that looks good on screen can fall flat in a hall.' ),
					array( 'Production capability', 'Find out who prints, fabricates and installs. If the agency only designs, ask who is accountable when a banner arrives in the wrong size.' ),
					array( 'Turnaround', 'Ask for a schedule that works backwards from your event date, with approval points along the way. A trustworthy agency will tell you what cannot be done in the time you have.' ),
					array( 'Support on event day', 'Confirm that someone from the team will be at the venue during installation and while the event runs.' ),
					array( 'Clarity on what is included', 'A good quote lists every item with its size, material, quantity and number of revision rounds. Vague quotes tend to grow.' ),
				) as $i => $c ) : ?>
				<li class="ev-chk">
					<div class="ev-chk__top">
						<span class="ev-chk__box" aria-hidden="true"><?php echo $wu_tick; // phpcs:ignore ?></span>
						<span class="ev-chk__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					</div>
					<h3><?php echo esc_html( $c[0] ); ?></h3>
					<p><?php echo esc_html( $c[1] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ol>
			<div class="ev-panel ev-ask">
				<h3>Questions to Ask Any Agency, Including Us</h3>
				<ol class="ev-ask__list">
					<?php foreach ( array(
						'Can I see photographs of installations from events similar to mine?',
						'Who handles production, printing and installation, and who is accountable for each?',
						'What file standards do you follow before anything goes to print?',
						'How many revision rounds are included, and what happens after that?',
						'Will someone from your team be at the venue during setup and on event day?',
						'What is your timeline for an event on my date, and what do you need from me to keep to it?',
						'What does the quote include, and what could cost extra?',
					) as $q ) echo '<li>' . esc_html( $q ) . '</li>'; ?>
				</ol>
				<p class="ev-note">At WiseUp, we are glad to be asked every one of these. Clear answers early in the conversation are usually a good sign of how the project will run.</p>
			</div>
		</div>
	</section>

	<!-- 12. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="ev-faq-h">
		<div class="wrap ev-faqsplit">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="ev-faq-h" class="sh__h"><span class="sh__a">Frequently Asked</span> <span class="sh__b">Questions</span></h2>
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

	<!-- 13. Final CTA: short enquiry form (name, company, event type, date, city), WhatsApp button and phone number -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Enquire' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Got an Event Date?</span> <span class="sh__b">Let’s Give It a Look.</span></h2>
					<p class="ev-final__p">Tell us what you are planning, and we will tell you how we would brand it. A short conversation is often enough to know where to begin.</p>
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
				<form class="ev-form" data-ev-form novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>">
					<label><span>Name</span><input name="name" required autocomplete="name"></label>
					<label><span>Company</span><input name="company" autocomplete="organization"></label>
					<label><span>Event type</span>
						<select name="event_type" required>
							<option value="" selected disabled>Choose one</option>
							<?php foreach ( array( 'Conference', 'Leadership summit', 'Product launch', 'Award night', 'Dealer and partner meet', 'AGM', 'Trade show', 'Exhibition', 'Inauguration', 'College fest', 'Cultural or festival event', 'Wedding or reception', 'Virtual or hybrid event', 'Other' ) as $o ) echo '<option>' . esc_html( $o ) . '</option>'; ?>
						</select>
					</label>
					<label><span>Event date</span><input name="date" type="date"></label>
					<label class="ev-form__wide"><span>City</span><input name="city" autocomplete="address-level2"></label>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Get a Quote</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
					<p class="ev-form__note" data-ev-note aria-live="polite"></p>
				</form>
			</div>
		</div>
	</section>
</main>
</div>
<script>
(function () {
	var f = document.querySelector('[data-ev-form]');
	if (!f) return;
	var note = f.querySelector('[data-ev-note]'), btn = f.querySelector('button[type=submit]');
	f.addEventListener('submit', function (e) {
		e.preventDefault();
		var bad = [].slice.call(f.querySelectorAll('input,select')).filter(function (el) { return el.name !== 'hp_website' && !el.checkValidity(); });
		if (bad.length) { bad[0].focus(); note.textContent = 'Please add your name and the event type.'; return; }
		var d = new FormData(f), v = function (k) { return String(d.get(k) || '').trim(); };
		var msg = ['Event type: ' + v('event_type'), 'Company: ' + (v('company') || '-'), 'Date: ' + (v('date') || '-'), 'City: ' + (v('city') || '-')].join('\n');
		var wa = 'https://wa.me/916282434503?text=' + encodeURIComponent('Hi WiseUp, I am ' + v('name') + '.\n' + msg);
		btn.disabled = true; note.textContent = 'Sending…';
		fetch(f.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': f.dataset.nonce },
			body: JSON.stringify({ name: v('name'), service: 'Event branding', message: msg, page: location.href, source: 'event-branding', hp_website: v('hp_website') }) })
			.then(function (r) { if (!r.ok) throw 0; f.reset(); note.textContent = 'Thanks, we have your enquiry.'; })
			.catch(function () { note.innerHTML = 'Couldn’t send that right now. <a href="' + wa + '" target="_blank" rel="noopener">Send it on WhatsApp instead</a>.'; })
			.then(function () { btn.disabled = false; });
	});
	// portfolio cards: tabs (click, arrow keys); without JS every part shows
		document.querySelectorAll('.wu-ev [data-tabs]').forEach(function (box) {
			box.classList.add('is-js');
			var tabs = [].slice.call(box.querySelectorAll('[role=tab]')), panes = [].slice.call(box.querySelectorAll('[role=tabpanel]'));
			var go = function (i, focus) { tabs.forEach(function (t, k) { var on = k === i; t.setAttribute('aria-selected', on); t.tabIndex = on ? 0 : -1; panes[k].classList.toggle('is-on', on); }); if (focus) tabs[i].focus(); };
			tabs.forEach(function (t, i) {
				t.addEventListener('click', function () { go(i); });
				t.addEventListener('keydown', function (e) { var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0; if (d) { e.preventDefault(); go((i + d + tabs.length) % tabs.length, true); } });
			});
		});
	// reviews carousel
	var qs = document.querySelector('[data-quotes]');
	if (qs) {
		var tr = qs.querySelector('[data-q-track]'), cardsQ = [].slice.call(tr.children), dots = qs.querySelectorAll('.ev-quotes__dots i');
		var step = function (d) { var w = cardsQ[0].getBoundingClientRect().width + parseFloat(getComputedStyle(tr).columnGap || 0); tr.scrollBy({ left: d * w, behavior: 'smooth' }); };
		qs.querySelector('[data-q-prev]').addEventListener('click', function () { step(-1); });
		qs.querySelector('[data-q-next]').addEventListener('click', function () { step(1); });
		var mark = function () { var max = tr.scrollWidth - tr.clientWidth, k = max > 0 ? Math.round(tr.scrollLeft / max * (cardsQ.length - 1)) : 0; dots.forEach(function (d, i) { d.classList.toggle('is-on', i === k); }); qs.querySelector('[data-q-prev]').disabled = tr.scrollLeft < 4; qs.querySelector('[data-q-next]').disabled = tr.scrollLeft > max - 4; };
		tr.addEventListener('scroll', function () { requestAnimationFrame(mark); }, { passive: true }); mark();
		var fitQ = function () { cardsQ.forEach(function (c) { var t = c.querySelector('.ev-quote__text'), b = c.querySelector('.ev-quote__more'); if (c.classList.contains('is-open')) return; b.hidden = !(t.scrollHeight > t.clientHeight + 2); }); };
		cardsQ.forEach(function (c) { c.querySelector('.ev-quote__more').addEventListener('click', function () { var o = c.classList.toggle('is-open'); this.textContent = o ? 'Show less' : 'Read more'; this.setAttribute('aria-expanded', o); }); });
		fitQ(); addEventListener('resize', fitQ);
	}
	if (matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
	var gs = document.documentElement.classList.contains('wu-motion'); // the GSAP engine handles reveals and counters
	document.documentElement.classList.add('ev-anim');
	// proof numbers count up when the hero loads
	if (!gs) document.querySelectorAll('.wu-ev [data-count]').forEach(function (el) {
		var raw = el.getAttribute('data-count'), to = +raw, dp = (raw.split('.')[1] || '').length, t0 = performance.now();
		(function step(t) { var k = Math.min(1, (t - t0) / 1400); el.textContent = (to * (1 - Math.pow(1 - k, 3))).toFixed(dp); if (k < 1) requestAnimationFrame(step); })(t0);
	});
	// process line fills with scroll
	var steps = document.querySelector('.wu-ev .ev-steps'), raf = 0;
	function fill() { raf = 0; if (!steps) return; var r = steps.getBoundingClientRect(); steps.style.setProperty('--p', Math.max(0, Math.min(1, (innerHeight * .75 - r.top) / Math.max(1, r.height + innerHeight * .2))).toFixed(3)); }
	addEventListener('scroll', function () { if (!raf) raf = requestAnimationFrame(fill); }, { passive: true }); fill();
	// "one team" cards: the hovered / focused card opens, the rest fold
	document.querySelectorAll('.wu-ev [data-ev-exp]').forEach(function (g) {
		var cs = [].slice.call(g.children);
		cs.forEach(function (c) {
			var on = function () { cs.forEach(function (x) { x.classList.toggle('is-on', x === c); }); };
			// a short hover intent, so sweeping the mouse across the row does not flick every card open
			var t;
			c.addEventListener('pointerenter', function () { clearTimeout(t); t = setTimeout(on, 40); });
			c.addEventListener('pointerleave', function () { clearTimeout(t); });
			c.addEventListener('focus', on); c.addEventListener('click', on);
		});
	});
	// cursor spotlight on cards; stage leans toward the pointer
	if (matchMedia('(hover: hover)').matches) {
		document.querySelectorAll('.wu-ev :is(.ev-card, .ev-why li)').forEach(function (c) {
			c.addEventListener('pointermove', function (e) { var b = c.getBoundingClientRect(); c.style.setProperty('--mx', (e.clientX - b.left) + 'px'); c.style.setProperty('--my', (e.clientY - b.top) + 'px'); });
		});
		var st = document.querySelector('[data-stage]');
		if (st) st.parentNode.addEventListener('pointermove', function (e) { var b = st.getBoundingClientRect(); st.style.setProperty('--rx', ((e.clientX - b.left) / b.width - .5).toFixed(3)); st.style.setProperty('--ry', ((e.clientY - b.top) / b.height - .5).toFixed(3)); });
	}
	if (gs) return;
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { rootMargin: '0px 0px -8% 0px' });
	document.querySelectorAll('.wu-ev :is(.ev-card, .ev-step, .ev-why li, .ev-case, .ev-panel, .ev-chk, .ev-quotes, .ev-ask)').forEach(function (el, i) {
		if (el.getBoundingClientRect().top > innerHeight) { el.classList.add('ev-rise'); el.style.setProperty('--d', (i % 3) * 70 + 'ms'); io.observe(el); }
	});
})();
</script>
<?php
$wu_lead_source = 'event-branding';
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js', 'ev-map.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( 'event-branding' );
