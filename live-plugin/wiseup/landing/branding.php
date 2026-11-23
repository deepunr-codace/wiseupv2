<?php
/**
 * Branding Agency in Kerala ("WiseUp: Branding" in the page Template dropdown). Copy = the owner's doc
 * (Downloads/Branding Company in Kerala.docx, 2026-11-23), word for word in its order. The doc's two placeholders
 * ("Showcase actual WiseUp projects here…", "Add verified client testimonials…") are not shown: the projects section uses
 * the existing case studies and the testimonials section the shared Google reviews, until verified details are supplied.
 * Kept though not in the doc: hero stats strip, AI Overview, Chat on WhatsApp button, contact tiles, the Other services carousel.
 * Design system: the Event Branding + Digital Marketing blocks (event-branding.css, digital-marketing.css) plus this
 * page's own pieces in assets/css/branding.css (.br-*).
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'branding';
$wu_title = apply_filters( 'wiseup_landing_title', 'Branding Agency in Kerala | Logo, Brand Identity & Packaging Design' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is a branding agency in Kerala, based in Calicut. Brand strategy, logo design, corporate identity, product packaging, signage and print production. Start a branding project.' );
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
add_action( 'wp_head', function () {
	echo "<script>(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var d=document.documentElement;d.classList.add('wu-motion');setTimeout(function(){if(!window.__wuEvMotion)d.classList.remove('wu-motion');},3000);})();</script>\n";
}, 1 );
add_action( 'wp_head', function () {
	foreach ( array( 'event-branding.css', 'digital-marketing.css', 'branding.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/' . $css . '?ver=' . filemtime( WISEUP_DIR . 'assets/css/' . $css ) ) . "\">\n";
	}
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to start a branding project.' );
$wu_arrow = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
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
$wu_h = function ( $a, $b ) { return '<span class="sh__a">' . esc_html( $a ) . '</span> <span class="sh__b">' . esc_html( $b ) . '</span>'; };
$wu_wa_svg   = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 2C6.5 2 2 6.5 2 12.04c0 1.77.46 3.5 1.34 5.02L2 22l5.07-1.33a10 10 0 0 0 4.97 1.27C17.58 21.94 22 17.5 22 12.04 22 6.5 17.58 2 12.04 2z"/></svg>';
$wu_call_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.61 21 3 13.39 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>';
$wu_pin_svg  = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>';

$wu_icons = array(
	'target'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.3"/>',
	'nib'     => '<path d="M4 20c4-1 6-3 7-6"/><path d="M14 4l6 6-8 8-6-6z"/><path d="m16 8-6 6"/>',
	'id'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2.2"/><path d="M5.8 16c.6-1.6 1.8-2.4 3.2-2.4s2.6.8 3.2 2.4M15 10h3.5M15 13.5h3.5"/>',
	'chat'    => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'box'     => '<path d="M12 3 4 7v10l8 4 8-4V7z"/><path d="M4 7l8 4 8-4M12 11v10"/>',
	'sign'    => '<rect x="3" y="4" width="18" height="10" rx="1.5"/><path d="M8 14v6M16 14v6M6 20h4M14 20h4"/><path d="M8 9h8"/>',
	'print'   => '<path d="M7 9V3h10v6"/><rect x="4" y="9" width="16" height="8" rx="1.5"/><path d="M7 14h10v7H7z"/>',
	'clip'    => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h4"/>',
	'search'  => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/>',
	'check'   => '<circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.6 2.6L16 9.5"/>',
	'deliver' => '<path d="M3 7h11v9H3zM14 10h4l3 3v3h-7z"/><circle cx="7" cy="17.5" r="1.7"/><circle cx="17" cy="17.5" r="1.7"/>',
	'users'   => '<circle cx="9" cy="8" r="3.2"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M15.5 13.6c3 .2 5.5 2.6 5.5 5.4"/>',
	'play'    => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5z"/>',
	'globe'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>',
	'tag'     => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
	'layers'  => '<path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/>',
);

// Services (doc): Strategy & Branding with its three parts, Product Packaging, Signage, Print Production with Print Management.
$wu_services = array(
	array(
		'title' => 'Strategy & Branding', 'icon' => 'target',
		'p'     => array(
			'Before a brand takes visual shape, it needs a clear direction. We look at the business, its audience, market position, and competitors to establish what the brand should communicate and how it should be perceived.',
			'This forms the foundation of its branding identity, guiding the creative decisions that follow. From positioning and visual direction to identity development, every branding service is shaped around the business and the people it wants to reach.',
		),
		'subs'  => array(
			array( 'Logo Design', 'nib', array(
				'A business\'s logo is usually the first visual feature that comes to mind when people think of its brand. Our branding design process focuses on creating a logo that reflects the brand\'s personality and works across different applications.',
				'From initial concepts to final logo variations, we develop designs that maintain their clarity and recognition across digital platforms, printed materials, packaging and signage.',
			) ),
			array( 'Corporate Identity', 'id', array(
				'Corporate branding gives a business a consistent and professional visual presence. We develop corporate identity elements that bring together the logo, colours, typography and other visual components used across business communication.',
				'This can include business cards, letterheads, company profiles, presentations and other branded materials. For B2B businesses, a consistent corporate identity also supports professional communication across client interactions, proposals and business partnerships.',
			) ),
			array( 'Consultancy', 'chat', array(
				'Good branding decisions begin with a clear understanding of the business. Our branding consultancy focuses on identifying requirements, reviewing existing brand elements and establishing a suitable direction for development.',
				'Whether the requirement involves a new identity or a brand refresh, we provide creative direction and recommendations that support consistency and long-term brand development.',
			) ),
		),
	),
	array(
		'title' => 'Product Packaging', 'icon' => 'box',
		'p'     => array(
			'Packaging is an important part of how a product is presented and recognised. It communicates product information while carrying the visual identity of the brand.',
			'We develop packaging concepts and designs that bring together brand elements, product presentation and visual communication. From the overall design direction to the application of colours, typography and graphics, each element is considered in relation to the product and its brand identity.',
		),
	),
	array(
		'title' => 'Signage', 'icon' => 'sign',
		'p'     => array(
			'Signage brings brand identity into physical spaces. It helps businesses maintain a recognisable presence across storefronts, offices, commercial spaces and other locations.',
			'WiseUp develops indoor and outdoor signage designs, business displays and corporate signage that follow the established visual identity. The aim is to maintain consistency between the brand\'s digital presence and its physical environment.',
		),
	),
	array(
		'title' => 'Print Production', 'icon' => 'print',
		'p'     => array(
			'Printed materials remain an important part of business communication, from corporate stationery to brochures and promotional materials. We translate approved brand designs into print-ready materials that maintain the intended visual presentation.',
		),
		'list_lead' => 'Our print production requirements can include:',
		'list'  => array( 'Brochures and flyers', 'Business cards and letterheads', 'Company profiles', 'Corporate stationery', 'Promotional and marketing materials' ),
		'subs'  => array(
			array( 'Print Management', 'clip', array(
				'Print management coordinates the production requirements behind branded materials. This includes selecting suitable materials, defining printing specifications, coordinating vendors and reviewing production quality. The process helps maintain consistency between the approved design and the final printed output.',
			) ),
		),
	),
);

// Industries (doc): [ name, icon paths ].
$wu_ind = array(
	array( 'Real Estate & Construction', '<path d="M4 21V9l8-5 8 5v12"/><path d="M9 21v-6h6v6M8 12h.01M16 12h.01"/>' ),
	array( 'Healthcare & Wellness', '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/><path d="M7 11h3l1.5-2 2 4 1.5-2h2"/>' ),
	array( 'Food & Beverage', '<path d="M7 3v8a2 2 0 0 0 2 2v8M5 3v5M9 3v5M17 3c-2 2-2.5 5-2.5 8h2.5v10"/>' ),
	array( 'Education & EdTech', '<path d="m2 9 10-5 10 5-10 5z"/><path d="M6 11v5c3 2.5 9 2.5 12 0v-5"/>' ),
	array( 'Retail & E-commerce', '<path d="M5 8h14l-1 12H6z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>' ),
	array( 'Events & Entertainment', '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z"/><path d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8z"/>' ),
	array( 'Fashion & Lifestyle', '<path d="M12 7a2 2 0 1 0-2-2"/><path d="M12 7v2L3 16a1 1 0 0 0 .6 1.8h16.8A1 1 0 0 0 21 16l-9-7"/>' ),
	array( 'Manufacturing & Industrial', '<path d="M3 21V10l6 4V10l6 4V6h6v15z"/><path d="M7 17h2M13 17h2M18 17h1"/>' ),
);

// Brand guidelines (doc).
$wu_guides = array(
	'Logo usage, variations and placement',
	'Brand colours and typography',
	'Visual elements and design rules',
	'Brand messaging and tone of voice',
	'Applications across digital and print platforms',
	'Instructions for internal teams and creative partners',
);

// Brand-book pages drawn for each guideline (SVG, 400 x 440; no text except the "Aa" specimen).
$wu_mark = '<circle cx="0" cy="0" r="30" fill="none" stroke="#beda52" stroke-width="5"/><path d="M-12 12 0-14 12 12" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="0" cy="22" r="4" fill="#beda52"/>';
$wu_gpages = array(
	// 1 logo usage, variations and placement: clear space, minimum size, variations
	'<g transform="translate(200 150)"><rect x="-86" y="-86" width="172" height="172" rx="6" fill="none" stroke="#fff" stroke-opacity=".35" stroke-dasharray="5 6"/><rect x="-52" y="-52" width="104" height="104" rx="4" fill="none" stroke="#beda52" stroke-opacity=".5"/><g transform="scale(1.35)">' . $wu_mark . '</g><path d="M-86-100v-10M86-100v-10M-86-105H86" stroke="#fff" stroke-opacity=".4"/></g><g transform="translate(96 352)"><rect x="-52" y="-34" width="104" height="68" rx="12" fill="#fff" fill-opacity=".06" stroke="#fff" stroke-opacity=".18"/><g transform="scale(.7)">' . $wu_mark . '</g></g><g transform="translate(200 352)"><rect x="-52" y="-34" width="104" height="68" rx="12" fill="#beda52"/><g transform="scale(.7)"><circle r="30" fill="none" stroke="#11150a" stroke-width="5"/><path d="M-12 12 0-14 12 12" fill="none" stroke="#11150a" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/></g></g><g transform="translate(304 352)"><rect x="-52" y="-34" width="104" height="68" rx="12" fill="#f4f4f6"/><g transform="scale(.7)"><circle r="30" fill="none" stroke="#11150a" stroke-width="5"/><path d="M-12 12 0-14 12 12" fill="none" stroke="#11150a" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/></g></g>',
	// 2 brand colours and typography
	'<g><circle cx="92" cy="104" r="50" fill="#beda52"/><circle cx="200" cy="104" r="50" fill="#f4f4f6"/><circle cx="308" cy="104" r="50" fill="#3a3a40"/><circle cx="146" cy="170" r="30" fill="#8fa838"/><circle cx="254" cy="170" r="30" fill="#18181b" stroke="#fff" stroke-opacity=".25"/></g><text x="60" y="324" font-family="Inter,Arial,sans-serif" font-size="128" font-weight="500" letter-spacing="-6" fill="#fff">Aa</text><g stroke="#fff" stroke-opacity=".3" stroke-width="3" stroke-linecap="round"><path d="M250 262h90M250 290h70M250 318h90"/></g><path d="M60 372H340" stroke="#fff" stroke-opacity=".18"/><path d="M60 396H250" stroke="#beda52" stroke-width="4" stroke-linecap="round"/>',
	// 3 visual elements and design rules: grid, shapes, spacing
	'<g stroke="#fff" stroke-opacity=".12"><path d="M60 80H340M60 160H340M60 240H340M60 320H340M60 400H340M60 80V400M140 80V400M220 80V400M300 80V400"/></g><circle cx="100" cy="120" r="34" fill="#beda52"/><rect x="180" y="86" width="68" height="68" rx="6" fill="none" stroke="#fff" stroke-width="3"/><path d="M262 154 300 86 338 154z" fill="#fff" fill-opacity=".9"/><rect x="62" y="202" width="116" height="36" rx="18" fill="#beda52" fill-opacity=".25" stroke="#beda52"/><circle cx="238" cy="222" r="24" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="3"/><circle cx="238" cy="222" r="9" fill="#beda52"/><path d="M282 206h56v32h-56z" fill="#fff" fill-opacity=".12"/><path d="M80 290h240M80 322h160M80 354h200" stroke="#fff" stroke-opacity=".28" stroke-width="5" stroke-linecap="round"/>',
	// 4 brand messaging and tone of voice: a voice, quote marks and lines of copy
	'<path d="M64 120a20 20 0 0 1 20-20h232a20 20 0 0 1 20 20v108a20 20 0 0 1-20 20H168l-40 40v-40H84a20 20 0 0 1-20-20z" fill="none" stroke="#fff" stroke-opacity=".4" stroke-width="3"/><text x="86" y="196" font-family="Georgia,serif" font-size="110" fill="#beda52">&#8220;</text><path d="M150 140h150M150 172h110" stroke="#fff" stroke-width="7" stroke-linecap="round"/><path d="M150 204h70" stroke="#beda52" stroke-width="7" stroke-linecap="round"/><path d="M64 340h272M64 372h200M64 404h236" stroke="#fff" stroke-opacity=".28" stroke-width="6" stroke-linecap="round"/>',
	// 5 applications across digital and print: card, phone, box, sign
	'<g transform="translate(106 118)"><rect x="-70" y="-44" width="140" height="88" rx="10" fill="#fff" fill-opacity=".07" stroke="#fff" stroke-opacity=".3"/><g transform="translate(-34 -2) scale(.55)">' . $wu_mark . '</g><path d="M-4-10h60M-4 8h44" stroke="#fff" stroke-opacity=".4" stroke-width="4" stroke-linecap="round"/></g><g transform="translate(290 118)"><rect x="-34" y="-66" width="68" height="132" rx="14" fill="#0b0b0d" stroke="#fff" stroke-opacity=".4" stroke-width="2"/><rect x="-26" y="-50" width="52" height="34" rx="6" fill="#beda52"/><path d="M-24-4h48M-24 10h32M-24 24h40" stroke="#fff" stroke-opacity=".35" stroke-width="4" stroke-linecap="round"/></g><g transform="translate(108 304)"><path d="M-48-26 0-46 48-26V28L0 48-48 28z" fill="#fff" fill-opacity=".07" stroke="#fff" stroke-opacity=".35"/><path d="M-48-26 0-6 48-26M0-6V48" fill="none" stroke="#fff" stroke-opacity=".35"/><g transform="translate(18 14) scale(.38)">' . $wu_mark . '</g></g><g transform="translate(290 300)"><rect x="-66" y="-40" width="132" height="56" rx="6" fill="#beda52"/><path d="M-30 16v44M30 16v44" stroke="#fff" stroke-opacity=".5" stroke-width="4"/><path d="M-44-12h88M-44 2h56" stroke="#11150a" stroke-opacity=".65" stroke-width="5" stroke-linecap="round"/></g>',
	// 6 instructions for internal teams and creative partners: a checklist + two people
	'<g stroke-linecap="round" stroke-linejoin="round"><g transform="translate(72 120)"><circle r="18" fill="#beda52"/><path d="M-8 1 -2 7 9-6" fill="none" stroke="#11150a" stroke-width="4"/><path d="M40-8h210M40 10h150" stroke="#fff" stroke-opacity=".55" stroke-width="6"/></g><g transform="translate(72 190)"><circle r="18" fill="#beda52"/><path d="M-8 1 -2 7 9-6" fill="none" stroke="#11150a" stroke-width="4"/><path d="M40-8h190M40 10h120" stroke="#fff" stroke-opacity=".55" stroke-width="6"/></g><g transform="translate(72 260)"><circle r="18" fill="none" stroke="#beda52" stroke-width="3"/><path d="M40-8h200M40 10h100" stroke="#fff" stroke-opacity=".3" stroke-width="6"/></g></g><g transform="translate(120 366)"><circle cy="-14" r="14" fill="#fff" fill-opacity=".85"/><path d="M-26 34a26 26 0 0 1 52 0z" fill="#fff" fill-opacity=".85"/></g><g transform="translate(200 366)"><circle cy="-14" r="14" fill="#beda52"/><path d="M-26 34a26 26 0 0 1 52 0z" fill="#beda52"/></g><g transform="translate(280 366)"><circle cy="-14" r="14" fill="#fff" fill-opacity=".4"/><path d="M-26 34a26 26 0 0 1 52 0z" fill="#fff" fill-opacity=".4"/></g>',
);

// Projects: the doc's placeholder block is not shown; the existing branding case studies stay under its heading.
$wu_cases = array(
	array( 'Smoke House', WISEUP_URL . 'assets/landing/img/case-smokehouse.jpg', home_url( '/case-studies/smokehouse/' ) ),
	array( 'Erets Space', WISEUP_URL . 'assets/landing/img/case-erets.jpg', home_url( '/case-studies/erets/' ) ),
	array( 'FORMAA Living', WISEUP_ASSETS . '/work/case-formaa-720.webp', home_url( '/case-studies/case-studies-formaa-living-branding/' ) ),
	array( 'Golden Karak', WISEUP_URL . 'assets/landing/img/case-karak.jpg', home_url( '/case-studies/golden-karak/' ) ),
	array( 'Onesto & Mercado', WISEUP_ASSETS . '/work/case-onesto-720.webp', home_url( '/case-studies/onesto/' ) ),
	array( 'Bootland Expo 2026', WISEUP_URL . 'assets/landing/img/case-bootland.jpg', home_url( '/case-studies/bootland/' ) ),
);

// Process (doc): [ title, icon, text ].
$wu_process = array(
	array( 'Understanding Your Business', 'chat', 'We begin with discussions about the business, its objectives, target audience and branding requirements. This gives us the context needed to plan the work and establish its direction.' ),
	array( 'Research and Creative Direction', 'search', 'We review the relevant market, competitors and audience expectations to shape the brand\'s positioning and creative direction. This establishes the foundation for the identity development stage.' ),
	array( 'Brand Design and Development', 'nib', 'With the direction in place, we develop the agreed brand elements, including logo concepts, visual identity components and other required branding materials.' ),
	array( 'Refinement and Finalisation', 'check', 'We review the proposed designs, gather feedback and make the required refinements. The approved elements are then finalised for their intended applications.' ),
	array( 'Production and Delivery', 'deliver', 'The final assets are prepared for the agreed digital and print applications. Where required, we also coordinate production requirements and organise the handover of approved brand materials.' ),
);

// Branding that connects with marketing (doc): [ label, text, icon ].
$wu_connect = array(
	array( 'Digital campaigns', 'Applying consistent brand visuals and messaging across advertising creatives.', 'play' ),
	array( 'Social media', 'Maintaining a recognisable identity through social media content and communication.', 'users' ),
	array( 'Website design', 'Aligning website layouts, colours, typography and messaging with the brand identity.', 'globe' ),
	array( 'Marketing materials', 'Keeping brochures, presentations and promotional assets consistent with the overall brand.', 'layers' ),
);

$wu_faq = array(
	array( 'What Is Included in Brand Identity Design?', 'Brand identity design includes the visual elements that represent a business, such as its logo, colour palette, typography and supporting graphic elements. Depending on the project, it can also include business stationery, brand guidelines, packaging and other branded materials.' ),
	array( 'How Is Branding Different From Logo Design?', 'Branding covers the overall identity and positioning of a business, while logo design focuses on creating its primary visual symbol. A logo is one part of branding, which also includes colours, typography, messaging and consistent applications across different platforms.' ),
	array( 'Why Does a Business Need Corporate Branding?', 'Corporate branding gives a business a consistent and professional identity across its communication and customer touchpoints. It helps maintain a recognisable presentation across company profiles, presentations, stationery, websites and other business materials.' ),
	array( 'How Much Do Branding Services Cost in Kerala?', 'Branding service costs in Kerala depend on the project scope, business requirements and deliverables. A logo design project will have different requirements from a complete corporate identity or packaging project. The final cost is determined by the services, design requirements and production needs involved.' ),
	array( 'What Is Included in Product Packaging Design?', 'Product packaging design includes the visual concept, layout, colours, typography, graphics and application of brand elements to packaging. The design also considers product information, packaging format and how the product should be presented to its intended market.' ),
	array( 'What Are Online Brand Guidelines?', 'Online brand guidelines are digital documents or resources that explain how a brand\'s identity should be applied. They typically cover logo usage, colours, typography, visual elements and communication standards, providing teams and creative partners with a consistent reference.' ),
	array( 'How Long Does It Take to Develop a Brand Identity?', 'The timeline depends on the scope and complexity of the project. A logo design may require less time than a complete brand identity involving corporate materials, packaging and guidelines. Research, design reviews, feedback and final approvals also influence the delivery timeline.' ),
	array( 'How Can B2B Businesses Benefit From Professional Branding?', 'Professional branding helps B2B businesses maintain a consistent and credible identity across proposals, company profiles, presentations, websites and client communication. A clear corporate identity supports professional positioning and creates a consistent impression across business relationships.' ),
);
add_action( 'wp_head', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 3 );

$wu_addr = wiseup_opt( 'contact_address' );
$wu_map  = wiseup_opt( 'contact_map' );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-br-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-br">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero br-hero" data-css-intro>
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="br-art" aria-hidden="true">
			<?php foreach ( array( array( 'formaa', 'one' ), array( 'onesto', 'two' ), array( 'popees', 'three' ) ) as $wu_a ) : $wu_ai = WISEUP_ASSETS . '/work/case-' . $wu_a[0] . '-'; ?>
			<img class="br-art__c br-art__c--<?php echo esc_attr( $wu_a[1] ); ?>" src="<?php echo esc_url( $wu_ai . '540.webp' ); ?>" srcset="<?php echo esc_url( $wu_ai . '360.webp' ); ?> 360w, <?php echo esc_url( $wu_ai . '540.webp' ); ?> 540w, <?php echo esc_url( $wu_ai . '720.webp' ); ?> 720w" sizes="(min-width: 1100px) 22vw, 60vw" width="540" height="540" alt="" loading="eager" decoding="async">
			<?php endforeach; ?>
		</div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Branding Agency in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">We turn your vision into</span> <span class="sh__b">a brand people connect with.</span></h2>
				<div class="ev-hero__p br-hero__ps"><p>WiseUp is a branding agency in Kerala, based in Calicut, working with businesses across different industries. We create brand identities through strategy, creative direction, and design, giving businesses a clear and recognisable identity.</p>
				<p>Branding is more than just a logo. It includes the colours, fonts, designs, messages, and emotions that represent a business across its website, packaging, advertisements, and printed materials. As a branding company, WiseUp brings these elements together to create a consistent brand image that reflects the business and what it stands for.</p></div>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Start a Branding Project', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'Chat on WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				</div>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					array( '8', '+', 'Years with CodeAce' ),
					array( '120', '+', 'Projects delivered' ),
					array( '14', '', 'Districts of Kerala covered' ),
					array( '5.0', '★', 'Google rating from client reviews' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
	</section>

<?php wiseup_ai_overview( array(
	'q'      => 'What does a branding agency in Kerala do?',
	'a'      => '<b>WiseUp</b> is a branding agency in Kerala, based in Calicut, working with businesses across different industries. We create brand identities through <b>strategy, creative direction, and design</b>, giving businesses a clear and recognisable identity.',
	'points' => array(
		array( 'Services', 'Strategy & branding (logo design, corporate identity, consultancy), product packaging, signage, print production and print management.' ),
		array( 'How we work', 'Understanding your business, research and creative direction, brand design and development, refinement and finalisation, then production and delivery.' ),
		array( 'Brand guidelines', 'Logo usage, colours and typography, visual elements, messaging and tone of voice, and applications across digital and print.' ),
		array( 'Industries', 'Real estate, healthcare, food and beverage, education, retail, events, fashion and manufacturing.' ),
		array( 'Where', 'Based in Kozhikode (Calicut), working with businesses across Kerala.' ),
	),
	'links'  => array( array( 'Services', '#br-services' ), array( 'Process', '#br-process' ), array( 'Industries', '#industries' ), array( 'FAQ', '#faq' ) ),
) ); ?>

	<!-- 2. Build a brand that represents your business -->
	<section class="sec ev-sec" id="br-build">
		<div class="wrap">
			<div class="br-split">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Your brand' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Build a Brand That', 'Represents Your Business' ); // phpcs:ignore ?></h2>
				</div>
				<div class="br-split__tx">
					<p class="br-lead">Every business reaches a point where its brand identity needs attention. A new business needs an identity that establishes its presence. An established company may need a more professional corporate image, while a new product requires packaging and visual elements that connect with its market.</p>
					<p>Sometimes, the requirement is to refresh an outdated identity or bring consistency to branding across different platforms and materials.</p>
					<p>WiseUp develops branding solutions around these requirements. We consider the business, its audience, and its market before shaping a creative direction that gives the brand a clear and consistent identity.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="br-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Branding Services That', 'Shape Your Brand Identity' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A strong brand takes more than individual design elements. It requires a clear direction and consistency across every application. WiseUp's branding agency services cover strategy, identity development and creative execution, with each service contributing to how a business presents itself.</p></div>
			</div>
			<div class="br-svcs" data-br-svcs>
				<nav class="br-rail" aria-label="Branding services">
					<span class="br-rail__line" aria-hidden="true"><i></i></span>
					<ol>
						<?php foreach ( $wu_services as $wu_k => $sv ) : ?>
						<li><a href="#br-s<?php echo (int) $wu_k; ?>"<?php echo 0 === $wu_k ? ' class="is-on"' : ''; ?>><span class="br-rail__i" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $sv['icon'] ], 20, 1.6 ); // phpcs:ignore ?></span><span><?php echo esc_html( $sv['title'] ); ?></span></a></li>
						<?php endforeach; ?>
					</ol>
				</nav>
				<div class="br-chaps">
					<?php foreach ( $wu_services as $wu_k => $sv ) : ?>
					<section class="br-ch" id="br-s<?php echo (int) $wu_k; ?>" data-ch>
						<header class="br-ch__h"><span class="br-ch__i" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $sv['icon'] ], 34, 1.4 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $sv['title'] ); ?></h3></header>
						<div class="br-ch__b">
							<?php foreach ( $sv['p'] as $wu_i => $wu_p ) : ?><p class="<?php echo 0 === $wu_i ? 'br-ch__lead' : 'br-ch__p'; ?>"><?php echo esc_html( $wu_p ); ?></p><?php endforeach; ?>
							<?php if ( ! empty( $sv['list'] ) ) : ?>
							<div class="br-svc__list">
								<h4><?php echo esc_html( $sv['list_lead'] ); ?></h4>
								<ul><?php foreach ( $sv['list'] as $f ) echo '<li>' . esc_html( $f ) . '</li>'; ?></ul>
							</div>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $sv['subs'] ) ) : ?>
						<div class="br-subs br-subs--<?php echo count( $sv['subs'] ); ?>">
							<?php foreach ( $sv['subs'] as $sub ) : ?>
							<section class="br-sub">
								<span class="br-sub__i" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $sub[1] ], 22, 1.6 ); // phpcs:ignore ?></span>
								<h4><?php echo esc_html( $sub[0] ); ?></h4>
								<?php foreach ( $sub[2] as $wu_p ) : ?><p><?php echo esc_html( $wu_p ); ?></p><?php endforeach; ?>
							</section>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</section>
					<?php endforeach; ?>
				</div>
			</div>
			<script>(function(){var w=document.querySelector('[data-br-svcs]');if(!w)return;var chs=[].slice.call(w.querySelectorAll('[data-ch]')),links=[].slice.call(w.querySelectorAll('.br-rail a')),bar=w.querySelector('.br-rail__line i');
var tick=function(){var mid=innerHeight*.42,cur=0;chs.forEach(function(c,i){if(c.getBoundingClientRect().top<mid)cur=i;});links.forEach(function(a,i){a.classList.toggle('is-on',i===cur);a.classList.toggle('is-past',i<cur);});
var r=w.getBoundingClientRect(),t=Math.min(1,Math.max(0,(innerHeight*.42-r.top)/Math.max(1,r.height-innerHeight*.2)));if(bar)bar.style.transform='scaleY('+t.toFixed(3)+')';};
tick();addEventListener('scroll',tick,{passive:true});addEventListener('resize',tick);})();</script>
		</div>
	</section>

	<!-- 4. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries We', 'Create Brands For' ); // phpcs:ignore ?></h2>
				</div>
			</div>
			<ul class="dm-ind dm-mag br-ind" data-mag>
				<?php foreach ( $wu_ind as $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_svg( $ind[1], 24, 1.6 ); // phpcs:ignore ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
			<script>(function(){var u=document.querySelector('.wu-br [data-mag]');if(!u)return;var li=[].slice.call(u.children);if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){li.forEach(function(l){l.classList.add('is-in')});return;}li.forEach(function(l,i){l.style.setProperty('--i',i)});var io=new IntersectionObserver(function(es){if(es.some(function(e){return e.isIntersecting})){io.disconnect();li.forEach(function(l){l.classList.add('is-in')});}},{rootMargin:'0px 0px -10% 0px'});io.observe(u);})();</script>
		</div>
	</section>

	<!-- 5. Brand guidelines -->
	<section class="sec ev-sec" id="br-guidelines">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Guidelines' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Brand Guidelines', 'That Keep Your Identity Consistent' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A brand identity needs clear standards to remain consistent across different platforms and applications. Brand guidelines document how the visual and communication elements should be used, giving internal teams and external creative partners a common reference.</p></div>
			</div>
			<div class="br-book" data-br-book>
				<div class="br-book__stage" aria-hidden="true">
					<span class="br-book__spine"></span>
					<?php foreach ( $wu_gpages as $wu_k => $wu_pg ) : ?>
					<svg class="br-book__page<?php echo 0 === $wu_k ? ' is-on' : ''; ?>" viewBox="0 0 400 440" role="presentation" focusable="false"><?php echo $wu_pg; // phpcs:ignore ?></svg>
					<?php endforeach; ?>
				</div>
				<div class="br-book__toc">
					<h3 class="br-label">These guidelines can cover:</h3>
					<ul class="br-toc" role="tablist" aria-label="Brand guideline topics">
						<?php foreach ( $wu_guides as $wu_k => $g ) : ?>
						<li><button type="button" role="tab" class="br-toc__b<?php echo 0 === $wu_k ? ' is-on' : ''; ?>" aria-selected="<?php echo 0 === $wu_k ? 'true' : 'false'; ?>" data-g="<?php echo (int) $wu_k; ?>"><span class="br-toc__dot" aria-hidden="true"></span><span class="br-toc__t"><?php echo esc_html( $g ); ?></span></button></li>
						<?php endforeach; ?>
					</ul>
					<p class="br-after">Online brand guidelines make these standards accessible to teams working across different locations and platforms. They provide a shared reference for applying the brand identity correctly, whether creating digital content, preparing presentations or producing printed materials.</p>
				</div>
			</div>
			<script>(function(){var w=document.querySelector('[data-br-book]');if(!w)return;var bs=[].slice.call(w.querySelectorAll('.br-toc__b')),pg=[].slice.call(w.querySelectorAll('.br-book__page')),cur=0,tm=null,touched=false,vis=false;
var set=function(i){cur=i;bs.forEach(function(b,k){var on=k===i;b.classList.toggle('is-on',on);b.setAttribute('aria-selected',on?'true':'false');});pg.forEach(function(p,k){p.classList.toggle('is-on',k===i);});};
var auto=function(){clearTimeout(tm);if(touched||!vis||matchMedia('(prefers-reduced-motion: reduce)').matches)return;tm=setTimeout(function(){set((cur+1)%bs.length);auto();},3800);};
bs.forEach(function(b,i){b.addEventListener('click',function(){touched=true;set(i);});b.addEventListener('mouseenter',function(){if(matchMedia('(hover: hover)').matches){touched=true;set(i);}});b.addEventListener('focus',function(){touched=true;set(i);});});
if('IntersectionObserver' in window){new IntersectionObserver(function(es){vis=es[0].isIntersecting;auto();},{threshold:.35}).observe(w);}})();</script>
		</div>
	</section>

	<!-- 6. Projects -->
	<section class="sec ev-sec" id="br-work">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Projects' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Branding Projects That', 'Bring Ideas to Life' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A brand identity becomes meaningful when its elements work together across real applications. Our branding projects showcase how creative direction translates into logos, packaging, corporate materials and other brand assets.</p></div>
			</div>
			<div class="br-car" data-br-car>
				<div class="br-car__nav"><button type="button" class="br-car__btn" data-prev aria-label="Previous projects"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg></button><button type="button" class="br-car__btn" data-next aria-label="Next projects"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button></div>
				<ul class="br-car__track" data-track role="region" aria-roledescription="carousel" aria-label="Branding projects">
					<?php foreach ( $wu_cases as $c ) : ?>
					<li class="br-car__card"><a href="<?php echo esc_url( $c[2] ); ?>"><span class="br-car__img"><img src="<?php echo esc_url( $c[1] ); ?>" alt="<?php echo esc_attr( $c[0] . ' branding project by WiseUp' ); ?>" loading="lazy" decoding="async" width="720" height="540"></span><span class="br-car__t"><b><?php echo esc_html( $c[0] ); ?></b><i aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></i></span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<script>(function(){var w=document.querySelector('[data-br-car]');if(!w)return;var t=w.querySelector('[data-track]'),pv=w.querySelector('[data-prev]'),nx=w.querySelector('[data-next]');
var step=function(){var c=t.querySelector('.br-car__card');return c?c.getBoundingClientRect().width+parseFloat(getComputedStyle(t).columnGap||18):320};
var upd=function(){var m=t.scrollWidth-t.clientWidth;pv.disabled=t.scrollLeft<4;nx.disabled=t.scrollLeft>m-4;w.querySelector('.br-car__nav').style.visibility=m<8?'hidden':'';};
pv.addEventListener('click',function(){t.scrollBy({left:-step(),behavior:'smooth'})});nx.addEventListener('click',function(){t.scrollBy({left:step(),behavior:'smooth'})});
t.addEventListener('scroll',upd,{passive:true});addEventListener('resize',upd);upd();
var d=0,x0=0,s0=0,mv=0;t.addEventListener('pointerdown',function(e){if(e.pointerType!=='mouse'||e.button)return;d=1;x0=e.clientX;s0=t.scrollLeft;mv=0});
addEventListener('pointermove',function(e){if(!d)return;var dx=e.clientX-x0;if(Math.abs(dx)>5){mv=1;t.classList.add('is-drag')}if(mv)t.scrollLeft=s0-dx});
addEventListener('pointerup',function(){if(!d)return;d=0;if(mv){var c=step(),n=Math.round(t.scrollLeft/c);t.classList.remove('is-drag');t.scrollTo({left:n*c,behavior:'smooth'})}});})();</script>
		</div>
	</section>

	<!-- 7. Client experiences -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Testimonials' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Hear It From the', 'Businesses We Work With' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Every branding project involves collaboration, creative decisions and a shared understanding of the business. Here's what our clients say about their experience working with WiseUp.</p></div>
			</div>
			<?php include WISEUP_DIR . 'landing/reviews.php'; ?>
		</div>
	</section>

	<!-- 8. Process -->
	<section class="sec ev-sec" id="br-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'How We Approach', 'a Branding Project' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Every branding project follows a process that takes the work from initial discussions to final delivery. The exact requirements may vary, but our approach keeps business objectives and creative direction at the centre.</p></div>
			</div>
			<div class="dm-tl" data-tl>
				<span class="dm-tl__line" aria-hidden="true"><i></i></span>
				<ol class="dm-tl__list">
					<?php foreach ( $wu_process as $wu_i => $s ) : ?>
					<li class="dm-tl__step"><span class="dm-tl__node" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $s[1] ], 24 ); // phpcs:ignore ?></span><div class="dm-tl__card"><h3><span class="dm-tl__n"><?php echo esc_html( sprintf( '%02d.', $wu_i + 1 ) ); ?></span> <?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 9. Branding that connects with your marketing -->
	<section class="sec ev-sec" id="br-marketing">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Marketing' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Branding That Connects', 'With Your Marketing' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Branding and marketing work best when they communicate a consistent identity. A well-developed visual direction and clear brand messaging give marketing activities a recognisable foundation across different channels.</p></div>
			</div>
			<p class="br-lead br-lead--w">As a branding and marketing agency, WiseUp connects brand identity with its wider creative and digital capabilities. This can include:</p>
			<ul class="br-connect">
				<?php foreach ( $wu_connect as $c ) : ?>
				<li class="ev-card"><span class="br-connect__i" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $c[2] ], 26, 1.5 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $c[0] ); ?></h3><p><?php echo esc_html( $c[1] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
			<p class="br-after br-after--w">This connection helps maintain a consistent brand experience, from the first interaction to ongoing communication.</p>
		</div>
	</section>

	<!-- 10. Calicut, working across Kerala -->
	<section class="sec ev-sec" id="br-local">
		<div class="wrap">
			<div class="br-local">
				<div class="br-local__copy">
					<?php echo $wu_eyebrow( 'Kozhikode' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'A Branding Agency in Calicut,', 'Working Across Kerala' ); // phpcs:ignore ?></h2>
					<p>Based in Kozhikode, WiseUp works with businesses across Kerala on branding and creative requirements. Our understanding of different business types and industries informs the way we approach brand identity, visual communication and creative execution.</p>
					<p>Whether a business is establishing a new identity, updating its corporate image or developing branding for a product, we shape the work around its requirements.</p>
					<p>For businesses looking for a branding company in Kerala, WiseUp brings strategy, design and creative thinking together to develop brand identities that work across different applications.</p>
				</div>
				<div class="ev-map" data-ev-map role="img" aria-label="Map of Kerala with our studio in Kozhikode (Calicut)">
					<canvas class="ev-map__gl" aria-hidden="true"></canvas>
					<canvas class="ev-map__ov" aria-hidden="true"></canvas>
					<span class="ev-map__k" aria-hidden="true">Kerala</span>
					<span class="ev-map__n" aria-hidden="true">N</span>
				</div>
			</div>
		</div>
	</section>

	<!-- 11. FAQ -->
	<section class="sec ev-sec" id="faq" aria-labelledby="br-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="br-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
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

	<?php wiseup_other_services( 'wiseup-branding' ); ?>

	<!-- 12. Final CTA -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final br-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Give Your Business an Identity', 'Worth Remembering.' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Let's shape a brand identity that reflects the business, communicates its value and stays consistent across every touchpoint.</p>
					<div class="br-final__btn"><?php echo $wu_btn( 'Start a Branding Project With WiseUp', 'teal', $wu_lead ); // phpcs:ignore ?></div>
				</div>
				<div class="ev-contact br-contact">
					<a class="ev-ct ev-ct--wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener">
						<span class="ev-ct__i"><?php echo $wu_wa_svg; // phpcs:ignore ?></span>
						<span class="ev-ct__t"><small>WhatsApp</small>+91 62824 34503</span>
						<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
					</a>
					<a class="ev-ct" href="tel:+916282434503">
						<span class="ev-ct__i"><?php echo $wu_call_svg; // phpcs:ignore ?></span>
						<span class="ev-ct__t"><small>Call</small>+91 62824 34503</span>
						<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
					</a>
					<a class="ev-ct br-ct-wide" href="<?php echo esc_url( $wu_map ); ?>" target="_blank" rel="noopener">
						<span class="ev-ct__i"><?php echo $wu_pin_svg; // phpcs:ignore ?></span>
						<span class="ev-ct__t"><small>Visit WiseUp</small><?php echo esc_html( $wu_addr ); ?></span>
						<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>
</main>
</div>
<script>
(function () {
	var rm = matchMedia('(prefers-reduced-motion: reduce)').matches;
	// process timeline (same as the other service pages)
	var fx = function () {
		if (!window.gsap || !window.ScrollTrigger) return;
		document.querySelectorAll('.wu-br [data-tl]').forEach(function (tl) {
			var wide = matchMedia('(min-width: 900px)').matches;
			tl.classList.add('is-live');
			gsap.fromTo(tl.querySelector('.dm-tl__line i'), { scaleY: 0 }, { scaleY: 1, ease: 'none', scrollTrigger: { trigger: tl, start: 'top 60%', end: 'bottom 60%', scrub: true } });
			[].slice.call(tl.querySelectorAll('.dm-tl__step')).forEach(function (s, i) {
				ScrollTrigger.create({ trigger: s.querySelector('.dm-tl__node'), start: 'center 60%', onEnter: function () { s.classList.add('is-on'); }, onLeaveBack: function () { s.classList.remove('is-on'); } });
				gsap.from(s.querySelector('.dm-tl__card'), { x: wide ? (i % 2 ? 70 : -70) : 40, opacity: 0, duration: 1.1, ease: 'expo.out', clearProps: 'transform,opacity', scrollTrigger: { trigger: s, start: 'top 82%', once: true } });
			});
		});
	};
	if (rm) return;
	if (document.documentElement.classList.contains('wu-motion')) addEventListener('DOMContentLoaded', function () { if (window.__wuEvMotion) fx(); });
	else addEventListener('load', fx);
	if (!document.documentElement.classList.contains('wu-motion')) document.querySelectorAll('.wu-br [data-count]').forEach(function (el) {
		var raw = el.getAttribute('data-count'), to = +raw, dp = (raw.split('.')[1] || '').length, t0 = performance.now();
		(function stp(t) { var k = Math.min(1, (t - t0) / 1400); el.textContent = (to * (1 - Math.pow(1 - k, 3))).toFixed(dp); if (k < 1) requestAnimationFrame(stp); })(t0);
	});
})();
</script>
<?php
$wu_lead_source = $wu_src;
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js', 'ev-map.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
