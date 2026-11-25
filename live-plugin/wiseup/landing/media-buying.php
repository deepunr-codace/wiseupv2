<?php
/**
 * Media Buying Agency in Kerala ("WiseUp: Media Buying" in the page Template dropdown). Copy = the owner's final doc
 * (Downloads/media buying services page (1).docx, 2026-11-20), word for word in its order. The doc's campaign blocks are
 * [Insert ...] placeholders, so the existing case studies stay under its heading until verified details are supplied.
 * Kept though not in the doc: hero stats strip, AI Overview, Chat on WhatsApp button, budget-range options.
 * Design system: the Event Branding + Digital Marketing blocks (event-branding.css, digital-marketing.css) plus this
 * page's own pieces in assets/css/media-buying.css (.mb-*).
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'media-buying';
$wu_title = apply_filters( 'wiseup_landing_title', 'Media Buying Agency in Kerala | OOH, Print & Theatre Advertising' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'Kerala-based media planning and buying agency for OOH, print and theatre advertising. Based in Kozhikode, serving all of Kerala. Get a free media plan.' );
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
	foreach ( array( 'event-branding.css', 'digital-marketing.css', 'media-buying.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/' . $css . '?ver=' . filemtime( WISEUP_DIR . 'assets/css/' . $css ) ) . "\">\n";
	}
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like a media plan for OOH, print or theatre advertising.' );
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
$wu_h = function ( $a, $b ) { return '<span class="sh__a">' . esc_html( $a ) . '</span> <span class="sh__b">' . esc_html( $b ) . '</span>'; };
$wu_wa_svg   = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.27-.2-.57-.35Zm-5.42 7.4h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.89 9.88Zm8.41-18.3A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.69 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.48-8.41Z"/></svg>';
$wu_call_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2Z"/></svg>';
$wu_pin_svg  = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>';

$wu_icons = array(
	'map'    => '<path d="M3 6.5 9 4l6 2.5 6-2.5v13.5L15 20l-6-2.5L3 20z"/><path d="M9 4v13.5M15 6.5V20"/>',
	'chat'   => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'book'   => '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M4 9h16M8 3v4M16 3v4M8 13h3M8 16h6"/>',
	'check'  => '<circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.6 2.6L16 9.5"/>',
	'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/>',
	'users'  => '<circle cx="9" cy="8" r="3.2"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M15.5 13.6c3 .2 5.5 2.6 5.5 5.4"/>',
	'pie'    => '<path d="M12 3a9 9 0 1 0 9 9h-9z"/><path d="M15 3.5A9 9 0 0 1 20.5 9H15z"/>',
	'deal'   => '<path d="m2.5 11 4-4 4 2 3-2 3 1.5L21 5.5"/><path d="M2.5 11 9 17.5a1.8 1.8 0 0 0 2.5 0L18 11"/><path d="m11 13 2 2M13.5 10.5l2 2"/>',
	'play'   => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5z"/>',
	'chart'  => '<path d="M4 20V4M4 20h16"/><path d="m7.5 15 4-4.5 3 3L20 7"/>',
	'tag'    => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
	'one'    => '<circle cx="12" cy="8" r="4"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/>',
	'camera' => '<path d="M4 8h3.5L9 5.5h6L16.5 8H20v11H4z"/><circle cx="12" cy="13" r="3.5"/>',
	'clock'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
	'eye'    => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/><circle cx="12" cy="12" r="3"/>',
	'link'   => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
	'qr'     => '<rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h2v2h-2zM18 14h2M14 18h2M18 18h2v2"/>',
	'percent' => '<path d="M19 5 5 19"/><circle cx="7" cy="7" r="2.5"/><circle cx="17" cy="17" r="2.5"/>',
	'flat'   => '<rect x="4" y="6" width="16" height="12" rx="2"/><path d="M4 10h16M8 14h4"/>',
	'repeat' => '<path d="M4 12a8 8 0 0 1 13.7-5.6L20 9"/><path d="M20 4v5h-5"/><path d="M20 12a8 8 0 0 1-13.7 5.6L4 15"/><path d="M4 20v-5h5"/>',
);

// Line drawings for the six services (service panels).
$wu_art = array(
	'ooh'     => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path class="mb-art__sky" d="M0 128h240"/><circle class="mb-art__acc" cx="206" cy="30" r="10"/><rect class="mb-art__fill" x="34" y="24" width="150" height="72" rx="6"/><path d="M52 46h60M52 60h92M52 74h44"/><rect class="mb-art__acc" x="150" y="40" width="22" height="40" rx="3"/><path d="M78 96v32M140 96v32M66 128h24M128 128h24"/><path d="M30 110l10-8 10 8M196 120h30M206 112v8"/></svg>',
	'print'   => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path class="mb-art__fill" d="M44 22h140l12 12v104H44z"/><path d="M184 22v12h12"/><path d="M58 40h78M58 50h56"/><rect class="mb-art__acc" x="58" y="64" width="62" height="46" rx="3"/><path d="M132 66h48M132 76h48M132 86h40M132 96h48M132 106h32M58 122h122M58 130h90"/></svg>',
	'theatre' => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path d="M18 18h204"/><path class="mb-art__curtain" d="M18 18c6 40 4 84 0 112h24c-6-34-6-74 0-112z"/><path class="mb-art__curtain" d="M222 18c-6 40-4 84 0 112h-24c6-34 6-74 0-112z"/><rect class="mb-art__fill" x="52" y="30" width="136" height="70" rx="4"/><path class="mb-art__acc mb-art__beam" d="M120 52l-14 10 14 10z"/><path d="M60 118c10-6 20-6 30 0M98 118c10-6 20-6 30 0M136 118c10-6 20-6 30 0M78 136c10-6 20-6 30 0M116 136c10-6 20-6 30 0M154 136c10-6 20-6 30 0"/></svg>',
	'digital' => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><rect class="mb-art__fill" x="30" y="20" width="150" height="100" rx="8"/><path d="M30 36h150"/><circle cx="42" cy="28" r="2.5"/><circle cx="52" cy="28" r="2.5"/><rect class="mb-art__acc" x="44" y="48" width="56" height="40" rx="4"/><path d="M112 52h54M112 62h44M112 72h54M44 100h122"/><rect class="mb-art__fill" x="164" y="64" width="50" height="78" rx="8"/><rect class="mb-art__acc" x="172" y="80" width="34" height="26" rx="3"/><path d="M172 116h34M172 124h22"/><path d="M84 140h50M109 120v20"/></svg>',
	'video'   => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><rect class="mb-art__fill" x="28" y="26" width="184" height="104" rx="10"/><circle class="mb-art__acc" cx="120" cy="72" r="24"/><path d="M113 62l18 10-18 10z"/><path d="M44 116h152"/><path class="mb-art__acc" d="M44 116h70"/><circle cx="114" cy="116" r="4"/></svg>',
	'radio'   => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path d="M70 50 160 22"/><rect class="mb-art__fill" x="40" y="50" width="160" height="86" rx="12"/><circle class="mb-art__acc" cx="88" cy="93" r="26"/><circle cx="88" cy="93" r="10"/><path d="M134 72h48M134 84h48"/><rect x="134" y="100" width="48" height="16" rx="3"/><path class="mb-art__acc" d="M150 100v16"/><path d="M206 60c8 8 8 26 0 34M216 52c13 13 13 37 0 50"/></svg>',
);

// Hero service tiles (doc: "OOH Campaigns | Print Campaigns | Theatre Advertising"): [ anchor, label ].
$wu_tiles = array(
	array( 'ooh', 'OOH Campaigns' ),
	array( 'print', 'Print Campaigns' ),
	array( 'theatre', 'Theatre Advertising' ),
);

// Services (doc order and wording): id, tab label, h3, paragraphs before the list, list lead, list, paragraphs after, best suited for.
$wu_ch_alt = array(
	'ooh'     => 'Jewellery advertisement on a roadside hoarding beside a Kerala highway at dusk',
	'print'   => 'Full-page Onam collection newspaper advertisement on a tea-shop table',
	'theatre' => 'SUV advertisement on a cinema screen before the film starts',
	'digital' => 'Café advertisement as a social media post on a phone and a web banner on a laptop',
	'video'   => 'Smartphone launch advertisement on an LED screen at a city junction in Kochi',
	'radio'   => 'Supermarket offer playing on FM radio on a car dashboard screen at night',
);
$wu_pillars = array(
	array(
		'id' => 'ooh', 'tab' => 'OOH', 'h3' => 'OOH Media Buying in Kerala',
		'p' => array( 'A well-placed outdoor advertisement can make a brand part of the everyday landscape. From busy roads to commercial centres, outdoor advertising creates repeated opportunities for people to notice a brand.' ),
		'lead' => 'Our OOH media buying services cover:',
		'list' => array( 'Hoardings and unipoles', 'Roadside gantries', 'Bus shelters and transit advertising', 'Bus and vehicle branding', 'Railway and airport advertising', 'Mall and digital outdoor screens', 'Wall branding' ),
		'kick' => 'The right location makes all the difference.',
		'after' => array( 'We assess site visibility, traffic movement, audience relevance and available inventory before recommending placements. We also coordinate rate negotiations, permissions, installation and proof-of-display photographs.', 'For businesses targeting Kozhikode and Malabar, we consider local audience movement and high-footfall locations when planning outdoor campaigns.' ),
		'best' => 'Retail, real estate, jewellery, healthcare, education and businesses looking to strengthen local brand visibility.',
	),
	array(
		'id' => 'print', 'tab' => 'Print', 'h3' => 'Print Media Buying in Kerala',
		'p' => array( 'Print advertising gives brands access to established newspaper and magazine readership. The right publication, edition and advertisement position can make a significant difference to campaign reach.' ),
		'lead' => 'Our print media buying services include:',
		'list' => array( 'Newspaper display advertisements', 'Newspaper supplements', 'Solus and jacket advertisements', 'Classified advertisements', 'Tenders and public notices', 'Magazine advertisements' ),
		'kick' => 'Every publication serves a different readership.',
		'after' => array( 'We evaluate publication choices based on audience profiles, language preferences, circulation and geographical coverage. From Malayalam and English dailies to edition-specific placements, we coordinate bookings across Malabar, Kochi and Thiruvananthapuram.', 'Our process includes rate negotiation, advertisement positioning, scheduling and collection of newspaper tear sheets as publication proof.' ),
		'best' => 'Retail promotions, educational admissions, recruitment, legal notices, public announcements and consumer brands.',
	),
	array(
		'id' => 'theatre', 'tab' => 'Theatre', 'h3' => 'Theatre Advertising in Kerala',
		'p' => array( 'Cinema advertising puts brands in front of audiences during a focused viewing experience. It creates an opportunity to communicate through engaging screen advertisements and in-cinema branding.' ),
		'lead' => 'Our theatre advertising services include:',
		'list' => array( 'Pre-show advertisements', 'Interval slides', 'Lobby branding', 'Cinema screen advertisements', 'Film-release promotional tie-ins', 'Multiplex and single-screen placements' ),
		'kick' => '',
		'after' => array( 'We assess cinema locations, audience profiles, available formats and show schedules before recommending placements. WiseUp also coordinates bookings, advertisement submissions and playback confirmation.' ),
		'best' => 'Jewellery, textiles, lifestyle brands, product launches, entertainment and premium consumer products.',
	),
	array(
		'id' => 'digital', 'tab' => 'Digital', 'h3' => 'Digital Media Buying',
		'p' => array( 'Digital advertising extends campaign reach across online platforms and helps brands connect with audiences through targeted placements.', 'Our digital media buying approach covers paid advertising opportunities across relevant digital channels, including search, social media and display advertising. We consider audience targeting, platform selection, campaign budgets and performance before recommending placements.', 'Digital campaigns can also support offline advertising by directing interested audiences towards websites, landing pages and enquiry channels.' ),
		'lead' => '', 'list' => array(), 'kick' => '', 'after' => array(),
		'best' => 'Lead generation, online promotions, product awareness, website traffic and integrated advertising campaigns.',
	),
	array(
		'id' => 'video', 'tab' => 'Video', 'h3' => 'Video Advertising Campaigns',
		'p' => array( 'Video brings brand messages to life through visuals, sound and storytelling. It gives businesses an effective format to communicate product features, promotions and brand messages.', 'WiseUp plans video advertising campaigns around suitable placements, audience preferences and campaign objectives. This can include video advertisements across digital platforms and relevant screen-based advertising opportunities.', 'From placement selection to campaign scheduling, we focus on getting video content in front of the intended audience.' ),
		'lead' => '', 'list' => array(), 'kick' => '', 'after' => array(),
		'best' => 'Product launches, brand awareness, retail promotions, hospitality and consumer brands.',
	),
	array(
		'id' => 'radio', 'tab' => 'Radio', 'h3' => 'Radio Advertising Campaigns',
		'p' => array( 'Radio advertising offers an opportunity to reach listeners during their daily routines, including travel, work and leisure.', 'Our radio advertising campaigns focus on selecting suitable stations, audience segments, time slots and campaign durations. We coordinate advertising schedules and placements based on the intended geographical coverage and campaign requirements.' ),
		'lead' => '', 'list' => array(), 'kick' => '', 'after' => array(),
		'best' => 'Retail offers, local promotions, public announcements, product launches and regional campaigns.',
	),
);

// One strategy: the doc's retail launch example as a small diagram (the sentence itself is in the paragraph).
$wu_mix = array(
	array( 'ooh', 'Outdoor hoardings', 'Local visibility' ),
	array( 'print', 'Newspaper advertisements', 'Promotional offers' ),
	array( 'radio', 'Radio spots', 'Wider awareness' ),
	array( 'digital', 'Digital campaigns', 'Online enquiries' ),
);
// Process (doc): [ title, icon, text ].
$wu_process = array(
	array( 'Discover', 'chat', 'We understand the business, advertising objectives, target audience, geographical coverage and campaign budget.' ),
	array( 'Research', 'users', 'We assess the market, audience profiles, available media inventory, locations, publications and advertising opportunities.' ),
	array( 'Plan', 'pie', 'We recommend suitable media formats, placements, schedules and budget allocations based on campaign requirements.' ),
	array( 'Negotiate and Book', 'deal', 'We coordinate with media owners, negotiate available rates, confirm placements and arrange advertising bookings.' ),
	array( 'Execute and Monitor', 'eye', 'We coordinate advertisement submissions, installations, publication schedules and campaign execution across selected channels.' ),
	array( 'Verify and Report', 'chart', 'We collect available execution evidence, including display photographs, newspaper tear sheets and playback confirmations, and share campaign updates.' ),
);
// Why work with a media buying company (doc): [ icon, title, text ].
$wu_why = array(
	array( 'tag', 'Rate negotiation', 'Comparing available inventory and negotiating media rates helps identify suitable advertising opportunities.' ),
	array( 'one', 'Centralised coordination', 'Planning, booking and execution are managed through a single point of contact.' ),
	array( 'search', 'Informed media selection', 'Audience profiles, location visibility and publication readership guide placement decisions.' ),
	array( 'camera', 'Execution proof', 'Display photographs, publication proofs and playback confirmations help verify completed campaigns.' ),
	array( 'clock', 'Time efficiency', 'Coordinating multiple media owners and advertising schedules becomes more manageable.' ),
);
// How does a media buying agency charge (doc): [ icon, model, text ].
$wu_charge = array(
	array( 'percent', 'Commission-based', 'An agreed commission is charged on the media booking value.' ),
	array( 'flat', 'Flat fee', 'A fixed professional fee covers media planning, coordination or campaign management.' ),
	array( 'repeat', 'Retainer', 'A recurring fee covers ongoing media planning and buying requirements.' ),
);
// Choosing the right agency (doc).
$wu_choose = array(
	'Transparency in media rates and agency fees.',
	'Knowledge of local advertising inventory.',
	'Experience across relevant media formats.',
	'Clear campaign reporting and execution proof.',
	'Communication and coordination throughout the campaign.',
);
// Industries: [ name, filled icon path ].
$wu_ind = array(
	array( 'Healthcare', 'M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm6 11h-3v3h-2v-3H8v-2h3v-3h2v3h3v2z' ),
	array( 'Retail', 'M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z' ),
	array( 'Education', 'M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3 1 9l11 6 9-4.91V17h2V9L12 3z' ),
	array( 'Real Estate', 'M1 11v10h5v-6h4v6h5V11L8 6z M10 3v1.97l7 5V11h2v2h-2v2h2v2h-2v4h6V3H10zm9 6h-2V7h2v2z' ),
	array( 'Jewellery', 'M19 3H5L2 9l10 12L22 9l-3-6zM9.62 8l1.5-3h1.76l1.5 3H9.62zM11 10v6.68L5.44 10H11zm2 0h5.56L13 16.68V10zm6.26-2h-2.65l-1.5-3h2.65l1.5 3zM6.24 5h2.65l-1.5 3H4.74l1.5-3z' ),
	array( 'Textiles', 'M16 3l-2.2 1.6h-3.6L8 3 2.5 6.5l2.3 4.4 2.2-1.1V21h10V9.8l2.2 1.1 2.3-4.4z' ),
	array( 'Hospitality', 'M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z' ),
	array( 'FMCG', 'M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z' ),
);
// Campaign snapshots: the doc's campaign blocks are placeholders ([Insert ...]), so the existing case studies stay until verified campaign details are supplied.
$wu_cases = array(
	array( 'Bootland Expo 2026', 'Expo launch campaign', WISEUP_URL . 'assets/landing/img/case-bootland.jpg', '21.6M+', 'Impressions for the launch', 'https://wiseup.in/case-studies/bootland/' ),
	array( 'Sathya Agencies', 'Brand launch campaign', WISEUP_ASSETS . '/work/case-sathya-720.webp', '1M+', 'Minimum reach on every video', 'https://wiseup.in/case-studies/sathya-agencies-brand-launch-campaign-kerala/' ),
	array( 'Golden Karak', 'Café brand campaign', WISEUP_URL . 'assets/landing/img/case-karak.jpg', '2M+', 'Views on one Instagram Reel', 'https://wiseup.in/case-studies/golden-karak/' ),
	array( 'Popees', 'Brand campaigns', WISEUP_ASSETS . '/work/case-popees-720.webp', '', '', 'https://wiseup.in/case-studies/popees-brand-campaigns-creative-marketing/' ),
);

$wu_faq = array(
	array( 'What Does a Media Buying Agency Do?', 'A media buying agency selects and books advertising spaces across channels such as newspapers, television, radio, cinema, and outdoor media. It manages rate negotiations, placement selection, bookings, and campaign execution based on the client\'s advertising objectives.' ),
	array( 'How Is Media Planning Different from Media Buying?', 'Media planning decides which advertising channels, locations and time slots suit a campaign. Media buying handles the purchase and booking of those placements. Both work together to ensure that advertising budgets are used effectively.' ),
	array( 'What Are the Charges for Hiring a Media Buying Agency?', 'Media buying fees depend on the campaign budget, advertising format, duration, and services required. An agency may charge a fixed fee, commission, or monthly retainer. Media placement, production and installation expenses may be billed separately.' ),
	array( 'Can Small Businesses Afford Media Buying Services?', 'Yes. Small businesses can use media buying services to identify advertising opportunities within their available budgets. An agency can compare placement costs, prioritise relevant locations, and recommend suitable channels without committing to unnecessary advertising spaces.' ),
	array( 'How Can I Book Outdoor Advertising in Kozhikode?', 'You can book outdoor advertising in Kozhikode by selecting suitable locations, checking available hoardings and display formats, comparing rates and confirming booking permissions. The process also includes artwork preparation, installation, and verification of the advertisement display.' ),
	array( 'Which Newspapers Are Suitable for Advertising in Kerala?', 'Malayalam newspapers are suitable for reaching regional audiences across Kerala, while English newspapers can target specific urban, professional, and business readerships. The right publication depends on your audience, campaign location, preferred language, and required circulation.' ),
	array( 'What Determines the Cost of Cinema Advertising in Kerala?', 'Cinema advertising rates depend on the theatre location, number of screens, advertisement duration, screening frequency, and campaign period. Rates can also vary between multiplexes and single-screen theatres. Comparing available placements helps determine which option fits the campaign budget.' ),
	array( 'Can a Media Buying Agency Manage Campaigns Across India?', 'Yes. Media buying agencies can coordinate advertising placements across multiple cities and states, depending on media availability and campaign requirements. WiseUp is based in Kozhikode and manages campaigns across Kerala, while pan-India requirements are evaluated based on the locations and media formats involved.' ),
	array( 'How Can I Verify That My Advertisements Have Been Published or Displayed?', 'Advertisers can request execution records based on the media format. These may include photographs of installed outdoor advertisements, newspaper tear sheets, cinema playback confirmations, and radio transmission records. The available proof depends on the media provider and campaign arrangement.' ),
	array( 'Can Digital and Traditional Media Buying Be Combined?', 'Yes. Digital and traditional media can run together as part of one advertising campaign. Outdoor, newspaper, cinema, and radio placements build brand visibility, while digital advertising supports online engagement, website visits, and lead generation. Using both allows brands to reach audiences across different touchpoints.' ),
);

$wu_addr = wiseup_opt( 'contact_address' );
$wu_map  = wiseup_opt( 'contact_map' );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-mb-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-mb">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero mb-hero mb-hero--photo" data-css-intro>
		<div class="mb-hbg"><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-hero-amber-1400.webp' ); ?>" srcset="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-hero-amber-900.webp' ); ?> 900w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-hero-amber-1400.webp' ); ?> 1400w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-hero-amber-1828.webp' ); ?> 1828w" sizes="100vw" width="1828" height="860" alt="" fetchpriority="high" decoding="async"><div class="mb-hpost" data-mb-hpost><div class="mb-hpost__face" data-mb-hpost-face><div class="mb-mv mb-mv--subs" data-mb-mv><video class="mb-mv__vid" data-mb-vid muted loop playsinline preload="none" poster="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-screen-kollam.webp' ); ?>" data-src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-screen-kollam.mp4' ); ?>" aria-hidden="true"></video><img class="mb-mv__logo" src="<?php echo esc_url( WISEUP_URL . 'assets/brand/wiseup-logo.webp' ); ?>" alt="" width="120" height="44"><div class="mb-mv__sub"><p class="mb-mv__l1">Advertising works best when the right audience sees it in the right place.</p><p class="mb-mv__l2">At WiseUp, we make that happen through strategic media planning and buying.</p></div><div class="mb-mv__grain"></div><div class="mb-mv__scratch"></div></div></div></div></div>
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Media Buying Agency in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">Getting the Right Ad Placement</span> <span class="sh__b">Makes All the Difference</span></h2>
				<div class="ev-hero__p mb-hero__ps"><p class="mb-hero__lead">Advertising works best when the right audience sees it in the right place. At WiseUp, we make that happen through strategic media planning and buying.</p></div>
				<div class="mb-hero__more"><p>WiseUp is a media buying agency in Kerala, specialising in outdoor (OOH), print, and theatre advertising. Based in Kozhikode, we plan and buy media placements across Kerala, helping businesses reach relevant audiences through the right advertising channels.</p><p>As a media planning and buying agency, we focus on selecting suitable media, negotiating placements, and managing campaigns from planning to execution.</p></div>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Get a Free Media Plan', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'Chat on WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				</div>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					// owner's figures (2026-11-25); [ number, suffix, label, prefix ]
					array( '50', '+', 'Campaigns Executed' ),
					array( '500', '+', 'Media Placements' ),
					array( '1', 'Cr+', 'Media Budget Managed', '₹' ),
					array( '100', '%', 'Execution Proof' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><?php if ( ! empty( $wu_st[3] ) ) : ?><em class="ev-stat__pre"><?php echo esc_html( $wu_st[3] ); ?></em><?php endif; ?><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
			<nav class="mb-htiles" aria-label="Our media">
				<?php foreach ( $wu_tiles as $t ) : ?>
				<a href="#<?php echo esc_attr( $t[0] ); ?>"><span class="mb-htiles__i" aria-hidden="true"><?php echo $wu_art[ $t[0] ]; // phpcs:ignore ?></span><?php echo esc_html( $t[1] ); ?><span class="mb-htiles__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>
	<script>
	/* hero: the lead line plays on the cinema screen of the hero photo like an interval ad (perspective via a homography); from 1100px only, the real lead
	   stays in the copy, visually hidden there */
	(function () {
		var w = document.querySelector('[data-mb-hpost]'); if (!w) return;
		var hbg = w.parentNode, img = hbg.querySelector('img'), face = w.querySelector('[data-mb-hpost-face]'), ps = [].slice.call(face.children);
		var IW = 1828, IH = 860, FW = 1000, FH = 400, Q = [[988, 230], [1790, 160], [1792, 538], [988, 525]];
		function solve(A, b) { var n = 8, i, j, k; for (i = 0; i < n; i++) A[i].push(b[i]); for (i = 0; i < n; i++) { var mx = i; for (j = i + 1; j < n; j++) if (Math.abs(A[j][i]) > Math.abs(A[mx][i])) mx = j; var t = A[i]; A[i] = A[mx]; A[mx] = t; for (j = i + 1; j < n; j++) { var f = A[j][i] / A[i][i]; for (k = i; k <= n; k++) A[j][k] -= f * A[i][k]; } } var x = []; for (i = n - 1; i >= 0; i--) { var s = A[i][n]; for (j = i + 1; j < n; j++) s -= A[i][j] * x[j]; x[i] = s / A[i][i]; } return x; }
		function place() {
			if (!img.clientWidth) return;
			var W = img.clientWidth, H = img.clientHeight, sc = Math.max(W / IW, H / IH), op = getComputedStyle(img).objectPosition.split(' ');
			var px = parseFloat(op[0]) / 100, py = parseFloat(op[1] || '50%') / 100, ox = (W - IW * sc) * (isNaN(px) ? .5 : px) + img.offsetLeft, oy = (H - IH * sc) * (isNaN(py) ? .5 : py) + img.offsetTop;
			var src = [[0, 0], [FW, 0], [FW, FH], [0, FH]], A = [], b = [];
			for (var i = 0; i < 4; i++) { var x = src[i][0], y = src[i][1], X = ox + Q[i][0] * sc, Y = oy + Q[i][1] * sc; A.push([x, y, 1, 0, 0, 0, -x * X, -y * X]); b.push(X); A.push([0, 0, 0, x, y, 1, -x * Y, -y * Y]); b.push(Y); }
			var h = solve(A, b); face.style.transform = 'matrix3d(' + [h[0], h[3], 0, h[6], h[1], h[4], 0, h[7], 0, 0, 1, 0, h[2], h[5], 0, 1].join(',') + ')';
		}
		place(); requestAnimationFrame(function () { requestAnimationFrame(function () { w.classList.add('is-up'); }); });
		// subtitles: the two sentences take turns like film subtitles (pauses while the pointer is on them, so they can be selected)
		var sb = w.querySelector('.mb-mv__sub'), hold = false;
		if (sb) { sb.addEventListener('pointerenter', function () { hold = true; }); sb.addEventListener('pointerleave', function () { hold = false; });
			setInterval(function () { if (hold || document.hidden) return; sb.setAttribute('data-line', sb.getAttribute('data-line') === '2' ? '1' : '2'); }, 4800); }
		// the Kollam teaser plays on the screen (muted, looped; a 960px web copy, loaded after the page, only while the hero is on screen)
		var vd = w.querySelector('[data-mb-vid]'), con = navigator.connection || {};
		if (vd && matchMedia('(min-width: 1100px)').matches && !matchMedia('(prefers-reduced-motion: reduce)').matches && !con.saveData) {
			var vOn = true, arm = function () { if (!vd.getAttribute('src')) { vd.src = vd.getAttribute('data-src'); } if (vOn) vd.play().catch(function () {}); };
			if (document.readyState === 'complete') setTimeout(arm, 400); else addEventListener('load', function () { setTimeout(arm, 400); });
			if ('IntersectionObserver' in window) new IntersectionObserver(function (e) { vOn = e[0].isIntersecting; if (!vd.getAttribute('src')) return; if (vOn) vd.play().catch(function () {}); else vd.pause(); }).observe(hbg);
		}
 addEventListener('resize', place); addEventListener('load', place); if (img.decode) img.decode().then(place, function () {});

	})();
	</script>


<?php wiseup_ai_overview( array(
	'q' => 'What does a media buying agency in Kerala do?',
	'a' => 'A media buying agency plans, negotiates and books advertising space for businesses. <b>WiseUp</b>, based in Kozhikode, buys <b>outdoor (OOH), print and theatre media</b> across Kerala, supported by digital, video and radio campaigns, and manages each campaign from planning to proof of display.',
	'points' => array(
		array( 'Services', 'Hoardings, unipoles, bus shelters and transit branding (OOH); newspaper display, supplements and classifieds (print); pre-show ads and lobby branding (theatre).' ),
		array( 'Process', 'Discover, research, plan, negotiate and book, execute and monitor, verify and report.' ),
		array( 'Pricing', 'Commission on media value, flat fee, or monthly retainer. Media, production and installation costs are shared upfront.' ),
		array( 'Proof', 'Display photographs, newspaper tear sheets and cinema playback confirmations.' ),
		array( 'Coverage', 'Kozhikode, Malabar, Kochi, Thiruvananthapuram and across Kerala.' ),
	),
	'note' => 'Tell us your budget, audience and city, and we’ll recommend the right media mix.',
	'cta' => 'Get a Free Media Plan',
	'links' => array( array( 'Services', '#mb-services' ), array( 'Process', '#mb-process' ), array( 'Charges', '#mb-charge' ), array( 'FAQ', '#faq' ) ),
) ); ?>

	<!-- 2. Services -->
	<section class="sec ev-sec" id="mb-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Buying Services That', 'Put Every Placement to Work' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>At WiseUp, media buying goes beyond booking advertising space. We bring media selection, planning, negotiation, and campaign execution together to make every placement count. Our media buying services cover traditional and digital advertising channels, with campaigns shaped around business objectives and audience requirements.</p></div>
			</div>
			<div class="mb-run" data-mb-run><div class="mb-stage" data-mb-stage>
			<div class="mb-bb" data-mb-top>
				<div class="mb-bb__site" aria-hidden="true">
					<div class="mb-bb__board">
						<?php foreach ( $wu_pillars as $wu_k => $p ) : $wu_src = WISEUP_URL . 'assets/landing/img/mb-ch-' . $p['id'] . '-1600.webp'; ?>
						<div class="mb-bb__poster<?php echo 0 === $wu_k ? ' is-on' : ''; ?>" data-k="<?php echo esc_attr( $p['id'] ); ?>" style="--img:url('<?php echo esc_url( $wu_src ); ?>')"><i></i><i></i><i></i><i></i></div>
						<?php endforeach; ?>
						<span class="mb-bb__glare"></span>
					</div>
					<img class="mb-bb__rig" src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-ang-1670.webp' ); ?>" srcset="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-ang-900.webp' ); ?> 900w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-ang-1670.webp' ); ?> 1672w" sizes="(min-width: 1240px) 1180px, 100vw" width="1670" height="941" alt="" decoding="async">
				</div>
				<div class="mb-bb__top" aria-hidden="true"></div>
				<nav class="mb-jump" aria-label="Jump to a service" data-mb-jump>
					<?php foreach ( $wu_pillars as $p ) : ?><a href="#<?php echo esc_attr( $p['id'] ); ?>"><?php echo esc_html( $p['tab'] ); ?></a><?php endforeach; ?>
				</nav>
			</div>
			<div class="mb-pillars">
				<?php foreach ( $wu_pillars as $wu_k => $p ) : ?>
				<article class="mb-pillar" id="<?php echo esc_attr( $p['id'] ); ?>" data-mb-pillar>
					<div class="mb-pillar__vis"><span class="mb-pillar__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_k + 1 ) ); ?></span><?php echo $wu_art[ $p['id'] ]; // phpcs:ignore ?></div>
					<div class="mb-pillar__body">
						<div class="mb-pc">
						<h3><?php echo esc_html( $p['h3'] ); ?></h3>
						<?php foreach ( $p['p'] as $wu_p ) : ?><p><?php echo esc_html( $wu_p ); ?></p><?php endforeach; ?>
						</div>
						<?php if ( $p['list'] ) : ?>
						<div class="mb-pillar__list">
							<h4><?php echo esc_html( $p['lead'] ); ?></h4>
							<ul class="mb-chips"><?php foreach ( $p['list'] as $f ) echo '<li>' . esc_html( $f ) . '</li>'; ?></ul>
						</div>
						<?php endif; ?>
						<?php if ( $p['kick'] || $p['after'] ) : ?>
						<div class="mb-pillar__angle">
							<?php if ( $p['kick'] ) : ?><p class="mb-pillar__q"><?php echo esc_html( $p['kick'] ); ?></p><?php endif; ?>
							<?php foreach ( $p['after'] as $wu_p ) : ?><p><?php echo esc_html( $wu_p ); ?></p><?php endforeach; ?>
						</div>
						<?php endif; ?>
						<div class="mb-pillar__foot">
							<p class="mb-best"><span>Best suited for:</span> <?php echo esc_html( $p['best'] ); ?></p>
							<?php echo $wu_btn( 'Get a Free Media Plan', 'teal', $wu_lead ); // phpcs:ignore ?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
			</div></div>
		</div>
	</section>

	<script>
	// scroll walks the tabs: the section pins, each scroll step drops the passed stone off the slab and opens the next service
	(function () {
		var run = document.querySelector('[data-mb-run]'); if (!run) return;
		var stage = run.querySelector('[data-mb-stage]'), bb = run.querySelector('.mb-bb'), jump = run.querySelector('[data-mb-jump]'), pillars = run.querySelector('.mb-pillars'), root = document.querySelector('.wu-mb');
		var links = [].slice.call(jump.querySelectorAll('a')), n = links.length, ids = links.map(function (a) { return a.getAttribute('href').slice(1); });
		var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches, wide = function () { return window.matchMedia('(min-width: 900px)').matches; };
		var faces = [].slice.call(run.querySelectorAll('[data-mb-pillar]')), top = 100, step = 400, on = false, active = -1, internal = false, tick = 0, delta = 0, tw = 0;
		function measure() {
			on = wide() && !reduce; window.__mbScrub = on;
			run.classList.toggle('mb-pin', on);
			if (!on) { run.style.height = ''; stage.style.top = ''; pillars.style.minHeight = ''; links.forEach(function (a) { a.classList.remove('is-gone'); }); bb.style.removeProperty('--e'); document.documentElement.classList.remove('mb-nohd'); faces.forEach(function (f) { f.style.transform = f.style.opacity = f.style.visibility = f.style.pointerEvents = ''; }); return; }
			var cls = root.classList.contains('mb-tabs'); root.classList.remove('mb-tabs');
			var mh = 0; [].forEach.call(run.querySelectorAll('[data-mb-pillar]'), function (q) { mh = Math.max(mh, q.offsetHeight); });
			root.classList.add('mb-tabs');
			pillars.style.minHeight = (innerWidth >= 1100 ? Math.max(mh, innerHeight - 48) : mh) + 'px'; var m2 = 0; faces.forEach(function (f) { m2 = Math.max(m2, f.scrollHeight); }); if (m2 > pillars.offsetHeight) pillars.style.minHeight = m2 + 'px';
			var H = stage.offsetHeight; step = Math.max(240, innerHeight * 0.3);
			top = (H + 150 < innerHeight) ? Math.round((innerHeight - H) / 2) : Math.min(100, innerHeight - H - 14);
			stage.style.top = top + 'px';
			run.style.height = (H + n * step) + 'px';
			upd();
		}
		function upd() {
			tick = 0; if (!on) return;
			var r = run.getBoundingClientRect(), p = Math.max(0, Math.min(0.9999, (top - r.top) / (n * step)));
			var e = Math.max(0, Math.min(1, 1 - (r.top - top) / (innerHeight * 0.75)));
			bb.style.setProperty('--e', e.toFixed(3));
			document.documentElement.classList.toggle('mb-nohd', r.top < top + 60 && r.bottom > innerHeight * 0.55);
			var cur = Math.max(0, Math.min(n - 0.001, p * n + delta)), idx = Math.min(n - 1, Math.floor(cur + 0.5));
			faces.forEach(function (f, i) { var en = i === 0 ? 1 : Math.max(0, Math.min(1, cur - (i - 1))), cv = Math.max(0, Math.min(1, cur - i)); f.style.transform = 'translateY(' + ((1 - en) * 108).toFixed(2) + '%) scale(' + (1 - cv * 0.06).toFixed(4) + ')'; f.style.opacity = '1'; f.style.filter = cv > 0 ? 'brightness(' + (1 - cv * 0.5).toFixed(3) + ')' : ''; f.style.zIndex = String(i + 1); f.style.visibility = ((en <= 0 && i > 0) || cv >= 1 && cur - i >= 1.02) ? 'hidden' : 'visible'; f.style.pointerEvents = i === idx ? 'auto' : 'none'; });
			links.forEach(function (a, i) { a.classList.toggle('is-gone', i < idx); });
			if (idx !== active && window.__mbShow) { active = idx; if (!links[idx].classList.contains('is-on')) window.__mbShow(ids[idx]); }
		}
		function q() { if (!tick) tick = requestAnimationFrame(upd); }
		function goTo(i) {
			var r = run.getBoundingClientRect();
			window.scrollTo(0, scrollY + r.top - top + (i + 0.5) / n * (n * step));
		}
		document.addEventListener('click', function (e) {
			if (internal || !on) return;
			var a = e.target.closest && e.target.closest('a[href^="#"]'); if (!a) return;
			var i = ids.indexOf(a.getAttribute('href').slice(1)); if (i < 0) return;
			e.preventDefault(); e.stopPropagation();
			if (jump.contains(a)) { var r = run.getBoundingClientRect(), p0 = Math.max(0, Math.min(0.9999, (top - r.top) / (n * step))) * n, from = delta, to = i - p0, t0 = performance.now(); cancelAnimationFrame(tw); (function go(now) { var k = Math.min(1, (now - t0) / 650), e2 = 1 - Math.pow(1 - k, 3); delta = from + (to - from) * e2; upd(); if (k < 1) tw = requestAnimationFrame(go); })(t0); }
			else { delta = 0; goTo(i); }
		}, true);
		addEventListener('scroll', q, { passive: true });
		addEventListener('resize', function () { measure(); });
		(document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve()).then(function () { measure(); var h = ids.indexOf(location.hash.slice(1)); if (h > 0 && on) goTo(h); });
		measure(); addEventListener('load', function () { measure(); });
	})();
	</script>

	<script>
	// "More details": the quote and the extra paragraphs sit behind a toggle on wide screens, so the card stays short
	(function () {
		var root = document.getElementById('mb-services'); if (!root) return;
		[].forEach.call(root.querySelectorAll('.mb-pillar'), function (p) {
			var ang = p.querySelector('.mb-pillar__angle'); if (!ang) return;
			var b = document.createElement('button'); b.type = 'button'; b.className = 'mb-more'; b.setAttribute('aria-expanded', 'false'); b.innerHTML = '<span>More details</span><i aria-hidden="true"></i>';
			ang.parentNode.insertBefore(b, ang);
			b.addEventListener('click', function () {
				var open = p.classList.toggle('is-open'); b.setAttribute('aria-expanded', open ? 'true' : 'false'); b.firstChild.textContent = open ? 'Less' : 'More details';
				setTimeout(function () { var rl = document.querySelector('.mb-rail'); if (rl) rl.style.height = Math.max(0, p.offsetHeight - 16) + 'px'; window.dispatchEvent(new Event('resize')); }, 480);
			});
		});
	})();
	</script>

	<script>
	// the poster board and the tab plate are warped onto the photo's real corners (perspective), so the poster sits on the hoarding like a print
	(function () {
		var site = document.querySelector('.mb-bb__site'), board = document.querySelector('.mb-bb__board'), jump = document.querySelector('[data-mb-jump]'); if (!site || !board) return;
		var IW = 1670, FACE = [[304, 320], [1388, 52], [1410, 560], [262, 688]], PLATE = [[471, 763], [1146, 704], [1151, 802], [471, 853]];
		function solve(A, b) { var n = 8, i, j, k; for (i = 0; i < n; i++) A[i].push(b[i]); for (i = 0; i < n; i++) { var m = i; for (j = i + 1; j < n; j++) if (Math.abs(A[j][i]) > Math.abs(A[m][i])) m = j; var t = A[i]; A[i] = A[m]; A[m] = t; for (j = i + 1; j < n; j++) { var f = A[j][i] / A[i][i]; for (k = i; k <= n; k++) A[j][k] -= f * A[i][k]; } } var x = []; for (i = n - 1; i >= 0; i--) { var sum = A[i][n]; for (j = i + 1; j < n; j++) sum -= A[i][j] * x[j]; x[i] = sum / A[i][i]; } return x; }
		function mat(w, h, q, s) { var src = [[0, 0], [w, 0], [w, h], [0, h]], A = [], b = [], i; for (i = 0; i < 4; i++) { var x = src[i][0], y = src[i][1], X = q[i][0] * s, Y = q[i][1] * s; A.push([x, y, 1, 0, 0, 0, -x * X, -y * X]); b.push(X); A.push([0, 0, 0, x, y, 1, -x * Y, -y * Y]); b.push(Y); } var h8 = solve(A, b); return 'matrix3d(' + [h8[0], h8[3], 0, h8[6], h8[1], h8[4], 0, h8[7], 0, 0, 1, 0, h8[2], h8[5], 0, 1].join(',') + ')'; }
		function place() { var s = site.clientWidth / IW; if (!s) return; board.style.transform = mat(1144, 400, FACE, s); if (jump && window.matchMedia('(min-width: 900px)').matches) jump.style.transform = mat(680, 120, PLATE, s); else if (jump) jump.style.transform = ''; }
		place(); addEventListener('resize', place); addEventListener('load', place); if (window.ResizeObserver) new ResizeObserver(place).observe(site);
	})();
	</script>

	<!-- 3. Campaigns -->
	<section class="sec ev-sec" id="mb-work">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Campaigns' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Campaigns That', 'Make an Impact' ); // phpcs:ignore ?></h2>
				</div>
			</div>
			<ul class="mb-cases">
				<?php foreach ( $wu_cases as $c ) : ?>
				<li>
					<a href="<?php echo esc_url( $c[5] ); ?>" class="mb-case">
						<img src="<?php echo esc_url( $c[2] ); ?>" alt="<?php echo esc_attr( $c[0] . ' ' . strtolower( $c[1] ) . ' by WiseUp' ); ?>" loading="lazy" decoding="async" width="720" height="540">
						<span class="mb-case__t"><small><?php echo esc_html( $c[1] ); ?></small><b><?php echo esc_html( $c[0] ); ?></b></span>
						<?php if ( '' !== $c[3] ) : ?><span class="mb-case__fig"><b><?php echo esc_html( $c[3] ); ?></b><?php echo esc_html( $c[4] ); ?></span><?php endif; ?>
						<span class="mb-case__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>


	<!-- 3b. Testimonials (the shared Google reviews, same as the Social Media / DM / SEO pages) -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Testimonials' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'What Our Clients', 'Say About Us' ); // phpcs:ignore ?></h2>
				</div>
			</div>
			<?php include WISEUP_DIR . 'landing/reviews.php'; ?>
		</div>
	</section>

	<!-- 4. One strategy -->
	<section class="sec ev-sec" id="mb-plan">
		<div class="wrap">
			<div class="mb-split">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Integrated planning' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Planning and Buying,', 'Built Around One Strategy' ); // phpcs:ignore ?></h2>
					<p class="mb-lead">Different advertising channels serve different purposes. OOH builds local visibility, print communicates detailed information, theatre creates screen-based engagement, and radio and digital campaigns extend audience reach.</p>
					<p class="mb-lead">At WiseUp, media planning and buying begin with the campaign objective, target audience, geographical coverage and available budget. We then recommend a suitable combination of advertising formats. The media mix and budget allocation depend on the campaign requirements, available inventory and advertising rates. Every placement should contribute to the larger campaign objective.</p>
				</div>
				<figure class="mb-mix">
					<blockquote><p>For example, a retail store launch in Kozhikode could combine outdoor hoardings for local visibility, newspaper advertisements for promotional offers, radio spots for wider awareness and digital campaigns to encourage online enquiries.</p></blockquote>
					<ul class="mb-mix__l" aria-hidden="true">
						<?php foreach ( $wu_mix as $wu_k => $m ) : ?>
						<li style="--k:<?php echo (int) $wu_k; ?>"><span class="mb-mix__i"><?php echo $wu_art[ $m[0] ]; // phpcs:ignore ?></span><b><?php echo esc_html( $m[1] ); ?></b><small><?php echo esc_html( $m[2] ); ?></small></li>
						<?php endforeach; ?>
					</ul>
				</figure>
			</div>
		</div>
	</section>

	<!-- 5. Process -->
	<section class="sec ev-sec" id="mb-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'How Our Media Buying', 'Process Works' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A well-planned campaign needs the right media, suitable placements and reliable execution. At WiseUp, we follow a structured process to manage each stage.</p></div>
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

	<!-- 6. Why a media buying company -->
	<section class="sec ev-sec" id="mb-why">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why an agency' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Why Work With a', 'Media Buying Company?' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Managing advertising placements across different media owners, publications and platforms takes time and coordination. A professional media buying company brings these activities together under one process.</p></div>
			</div>
			<ul class="pm-grid mb-why">
				<?php foreach ( $wu_why as $w ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $w[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 7. Charges + choosing an agency -->
	<section class="sec ev-sec" id="mb-charge">
		<div class="wrap">
			<div class="mb-fees">
				<div class="mb-fees__head">
					<h2 class="mb-sub">How Does a Media Buying Agency Charge?</h2>
					<p class="mb-subp">Media buying agencies generally follow different fee structures depending on the campaign and scope of work.</p>
				</div>
				<ul class="mb-charge mb-fees__list">
					<?php foreach ( $wu_charge as $wu_ci => $c ) : ?>
					<li class="mb-fee mb-fee--<?php echo (int) $wu_ci; ?>">
						<span class="mb-fee__viz" aria-hidden="true"><?php if ( 0 === $wu_ci ) : ?><i class="mb-fee__val"></i><i class="mb-fee__cut"></i><?php elseif ( 1 === $wu_ci ) : ?><i class="mb-fee__one"></i><?php else : ?><i></i><i></i><i></i><i></i><i></i><i></i><?php endif; ?></span>
						<span class="mb-charge__i"><?php echo $wu_svg( $wu_icons[ $c[0] ], 22 ); // phpcs:ignore ?></span>
						<b><?php echo esc_html( $c[1] ); ?></b>
						<p><?php echo esc_html( $c[2] ); ?></p>
					</li>
					<?php endforeach; ?>
				</ul>
				<p class="mb-fees__note">Media costs, agency fees and additional production or installation charges should be clearly communicated before a campaign begins.</p>
			</div>
			<div class="mb-pick">
				<div class="mb-pick__head">
					<h2 class="mb-sub">Choosing the Right Media Buying Agency</h2>
					<p class="mb-subp">When comparing media buying agencies, consider:</p>
					<blockquote class="mb-pick__q"><p>The right agency should explain not only where an advertisement will appear, but also why the placement suits the campaign.</p></blockquote>
				</div>
				<ul class="mb-check mb-pick__list">
					<?php foreach ( $wu_choose as $c ) : ?>
					<li><span class="mb-check__t" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="m6 12.5 4 4L18 8" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span><div><p><?php echo esc_html( $c ); ?></p></div></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<!-- 8. Kozhikode, Kerala-wide -->
	<section class="sec ev-sec" id="mb-local">
		<div class="wrap">
			<div class="mb-local">
				<div class="mb-local__copy">
					<?php echo $wu_eyebrow( 'Kozhikode' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'A Media Buying Agency in Kozhikode', 'With Kerala-Wide Reach' ); // phpcs:ignore ?></h2>
					<p>Based in Kozhikode, WiseUp works with businesses across Kerala to plan and coordinate advertising campaigns in different markets. From Malabar to Kochi and Thiruvananthapuram, we consider regional audiences, local media availability, and campaign objectives when selecting advertising placements.</p>
					<p>Each location has its own audience patterns and media preferences. A campaign aimed at customers in Kozhikode may require a different mix of outdoor sites, newspaper editions, or cinema placements from one targeting audiences in Kochi or southern Kerala. We take these differences into account when recommending suitable media channels and locations.</p>
					<p>Our work covers the coordination of media selection, placement bookings, schedules, and campaign execution. Whether a campaign focuses on one city or multiple districts, the aim is to maintain consistency while making media choices relevant to each market.</p>
				</div>
				<figure class="mb-kmap">
					<div class="ev-map" data-ev-map role="img" aria-label="Map of Kerala with our studio at Govt. Cyberpark, Kozhikode, and the areas we cover: Kozhikode, Malabar and across Kerala">
						<canvas class="ev-map__gl" aria-hidden="true"></canvas>
						<canvas class="ev-map__ov" aria-hidden="true"></canvas>
						<span class="ev-map__k" aria-hidden="true">Kerala</span>
						<span class="ev-map__n" aria-hidden="true">N</span>
					</div>
					<figcaption class="mb-kmap__cap">
						<a class="mb-kmap__row" href="<?php echo esc_url( $wu_map ); ?>" target="_blank" rel="noopener"><span class="mb-kmap__i"><?php echo $wu_pin_svg; // phpcs:ignore ?></span><span><small>Location:</small> Govt. Cyberpark, Kozhikode, Kerala.</span></a>
						<p class="mb-kmap__row"><span class="mb-kmap__i"><?php echo $wu_svg( $wu_icons['map'], 20 ); // phpcs:ignore ?></span><span><small>Service coverage:</small> Kozhikode, Malabar and across Kerala.</span></p>
					</figcaption>
				</figure>
			</div>
		</div>
	</section>

	<!-- 9. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries', 'We Serve' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Different industries need different advertising approaches. WiseUp plans media campaigns around business objectives and audience requirements across sectors such as:</p></div>
			</div>
			<ul class="dm-ind dm-mag mb-ind" data-mag>
				<?php foreach ( $wu_ind as $ind ) : ?>
				<li><span class="dm-ind__i"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="<?php echo esc_attr( $ind[1] ); ?>"/></svg></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
			<script>(function(){var u=document.querySelector('.wu-mb [data-mag]');if(!u)return;var li=[].slice.call(u.children);if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){li.forEach(function(l){l.classList.add('is-on');});return;}u.classList.add('is-js');var io=new IntersectionObserver(function(es){es.forEach(function(e){e.target.classList.toggle('is-on',e.isIntersecting);});},{rootMargin:'-42% 0px -42% 0px'});li.forEach(function(l){io.observe(l);});})();</script>
		</div>
	</section>

	<!-- 10. Kerala and India -->
	<section class="sec ev-sec" id="mb-india">
		<div class="wrap">
			<div class="mb-india">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Kerala & India' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Buying Campaigns', 'Across Kerala and India' ); // phpcs:ignore ?></h2>
				</div>
				<div class="mb-india__p">
					<p>WiseUp coordinates outdoor, print, theatre, radio, and digital advertising campaigns across Kerala. Based in Kozhikode, we also assess media buying requirements beyond the state based on campaign locations, available inventory, and scope.</p>
					<p>For businesses comparing media buying agencies in India, our media planning and coordination approach can support regional and multi-location advertising requirements.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 11. FAQ -->
	<section class="sec ev-sec" id="faq" aria-labelledby="mb-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="mb-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
			</div>
			<div class="faq">
				<?php foreach ( $wu_faq as $wu_fi => $q ) : ?>
				<details class="faq__item" name="faq"<?php echo 0 === $wu_fi ? ' open' : ''; ?>>
					<summary class="faq__q"><h3><?php echo esc_html( $q[0] ); ?></h3><span class="faq__dot" aria-hidden="true"></span></summary>
					<p class="faq__a"><?php echo esc_html( $q[1] ); ?></p>
				</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php wiseup_other_services( 'wiseup-media-buying' ); ?>

	<!-- 12. Final CTA -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Plan the Next', 'Campaign With Us' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">The right advertising placement begins with a well-planned media strategy. WiseUp brings media planning, advertising selection, negotiation, and campaign execution together to make advertising more purposeful.</p>
					<p class="ev-final__p mb-final__k">Let's put the right campaign in the right places.</p>
					<div class="ev-contact">
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
						<a class="ev-ct mb-ct-wide" href="<?php echo esc_url( $wu_map ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><?php echo $wu_pin_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Visit WiseUp</small><?php echo esc_html( $wu_addr ); ?></span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
					</div>
				</div>
				<form class="ev-form mb-form" data-dm-form novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>" data-source="<?php echo esc_attr( $wu_src ); ?>">
					<label><span>Name</span><input name="name" required autocomplete="name"></label>
					<label><span>Phone</span><input name="phone" type="tel" required autocomplete="tel"></label>
					<label class="ev-form__wide"><span>Budget Range</span>
						<select name="budget" required>
							<option value="" selected disabled>Choose one</option>
							<option>Under ₹1 lakh</option>
							<option>₹1 to 5 lakh</option>
							<option>₹5 to 15 lakh</option>
							<option>Above ₹15 lakh</option>
							<option>Not sure yet</option>
						</select>
					</label>
					<fieldset class="ev-form__wide mb-media"><legend>Media Interest</legend>
						<?php foreach ( array( 'OOH', 'Print', 'Theatre', 'Digital', 'Video', 'Radio' ) as $m ) : ?>
						<label><input type="checkbox" name="media" value="<?php echo esc_attr( $m ); ?>"><span><?php echo esc_html( $m ); ?></span></label>
						<?php endforeach; ?>
					</fieldset>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Get a Free Media Plan</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
					<p class="ev-form__note" data-ev-note aria-live="polite"></p>
				</form>
			</div>
		</div>
	</section>
	<div class="mb-sticky" role="region" aria-label="Quick actions">
		<?php echo $wu_btn( 'Get a Free Media Plan', 'teal', $wu_lead ); // phpcs:ignore ?>
		<a class="mb-sticky__wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><?php echo $wu_wa_svg; // phpcs:ignore ?></a>
	</div>
</main>
</div>
<script>
(function () {
	// enquiry form → wiseup/v1/enquiry (saved to Leads); WhatsApp link if sending fails
	var f = document.querySelector('.wu-mb [data-dm-form]');
	if (f) {
		var note = f.querySelector('[data-ev-note]'), btn = f.querySelector('button[type=submit]');
		f.addEventListener('submit', function (e) {
			e.preventDefault();
			var bad = [].slice.call(f.querySelectorAll('input:not([type=checkbox]),select')).filter(function (el) { return el.name !== 'hp_website' && !el.checkValidity(); });
			if (bad.length) { bad[0].focus(); note.textContent = 'Please add your name, phone and budget range.'; return; }
			var d = new FormData(f), v = function (k) { return String(d.get(k) || '').trim(); };
			var media = d.getAll('media').join(', ') || 'Not sure yet';
			var msg = ['Budget range: ' + v('budget'), 'Media interest: ' + media].join('\n');
			var wa = 'https://wa.me/916282434503?text=' + encodeURIComponent('Hi WiseUp, I am ' + v('name') + '. I would like a free media plan.\n' + msg);
			btn.disabled = true; note.textContent = 'Sending…';
			fetch(f.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': f.dataset.nonce },
				body: JSON.stringify({ name: v('name'), phone: v('phone'), email: '', service: 'Media buying: ' + media, message: msg, page: location.href, source: f.dataset.source, hp_website: v('hp_website') }) })
				.then(function (r) { if (!r.ok) throw 0; f.reset(); note.textContent = 'Thanks, we have your details and will send your media plan soon.'; })
				.catch(function () { note.innerHTML = 'Couldn’t send that right now. <a href="' + wa + '" target="_blank" rel="noopener">Send it on WhatsApp instead</a>.'; })
				.then(function () { btn.disabled = false; });
		});
	}
	// pillars as tabs: one pillar shows at a time (all three stay in the HTML); hero tiles and goal pills open theirs
	var jump = document.querySelector('[data-mb-jump]');
	var pills = [].slice.call(document.querySelectorAll('[data-mb-pillar]'));
	if (jump && pills.length) {
		var links = [].slice.call(jump.querySelectorAll('a'));
		var ids = pills.map(function (p) { return p.id; });
		var show = function (id) {
			var top = document.querySelector('[data-mb-top]');
			if (top) [].slice.call(top.querySelectorAll('.mb-bb__poster')).forEach(function (q) { var k = q.getAttribute('data-k'), was = q.classList.contains('is-on'); q.classList.remove('is-was'); if (k === id) { if (!was) { q.classList.remove('is-on'); void q.offsetWidth; q.classList.add('is-on'); } } else if (was) { q.classList.remove('is-on'); q.classList.add('is-was'); } });
			pills.forEach(function (p) { p.classList.toggle('is-active', p.id === id); if (p.id === id) p.classList.add('is-in'); });
			var stg = document.querySelector('[data-mb-stage]');
			if (stg) { var ix = ids.indexOf(id), tints = ['#ffbe64', '#e3cc94', '#ff5a4a', '#5aa0ff', '#a77bff', '#ffa94d']; stg.style.setProperty('--ai', ix); stg.style.setProperty('--tint', tints[ix] || '#ffbe64');
				var pl = stg.querySelector('.mb-pillars'); if (pl && !pl.querySelector('.mb-rail')) { var r = document.createElement('div'); r.className = 'mb-rail'; r.setAttribute('aria-hidden', 'true'); r.innerHTML = ids.map(function () { return '<i></i>'; }).join('') + '<b></b>'; pl.insertBefore(r, pl.firstChild); } }
			requestAnimationFrame(function () { var ap = document.getElementById(id), rl = document.querySelector('.mb-rail'); if (ap && rl) { var h = ap.offsetHeight; rl.style.height = h > 80 ? (h - 16) + 'px' : ''; rl.style.bottom = 'auto'; } });
			var act = document.getElementById(id), prev = pills.filter(function (p) { return p.classList.contains('is-pasted'); })[0];
			if (act && prev && prev !== act && !window.__mbScrub && !(window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches) && window.__mbReady && act.animate) {
				var dir = pills.indexOf(act) > pills.indexOf(prev) ? 1 : -1, pb = prev.querySelector('.mb-pillar__body'), ab = act.querySelector('.mb-pillar__body');
				[].forEach.call(document.querySelectorAll('.mb-ghost'), function (g) { g.remove(); });
				if (pb && ab) {
					var g = prev.cloneNode(true); g.removeAttribute('id'); g.removeAttribute('data-mb-pillar'); g.className = 'mb-pillar is-active mb-ghost'; g.setAttribute('aria-hidden', 'true');
					g.style.cssText = 'position:absolute;left:0;right:0;top:0;pointer-events:none;z-index:4;margin:0;';
					act.parentNode.style.position = 'relative'; act.parentNode.appendChild(g);
					var o = g.animate([{ opacity: 1, transform: 'none' }, { opacity: 0, transform: 'translateY(' + (-34 * dir) + 'px) scale(.97)' }], { duration: 220, easing: 'cubic-bezier(.4,0,.8,.4)', fill: 'forwards' });
					o.onfinish = function () { g.remove(); };
					ab.animate([{ opacity: 0, transform: 'translateY(' + (44 * dir) + 'px) scale(.985)' }, { opacity: 0, transform: 'translateY(' + (44 * dir) + 'px) scale(.985)', offset: .38 }, { opacity: 1, transform: 'none' }], { duration: 620, easing: 'cubic-bezier(.2,.9,.3,1)' });
				}
			}
			if (act) pills.forEach(function (p) { p.classList.toggle('is-pasted', p === act); });
			links.forEach(function (a) { var on = a.getAttribute('href') === '#' + id; a.classList.toggle('is-on', on); a.setAttribute('aria-selected', on ? 'true' : 'false'); });
		};
		window.__mbShow = show; window.dispatchEvent(new Event('scroll'));
		document.querySelector('.wu-mb').classList.add('mb-tabs');
		jump.setAttribute('role', 'tablist');
		// a click on a tab only switches the service: stop it before the smooth-scroll script follows the #link
		jump.addEventListener('click', function (e) {
			var a = e.target.closest && e.target.closest('a[href^="#"]'); if (!a) return;
			var id = a.getAttribute('href').slice(1); if (ids.indexOf(id) < 0) return;
			e.preventDefault(); e.stopPropagation(); show(id);
		});
		links.forEach(function (a) { a.setAttribute('role', 'tab'); });
		show(ids.indexOf(location.hash.slice(1)) > -1 ? location.hash.slice(1) : ids[0]);
		setTimeout(function () { window.__mbReady = 1; }, 600);
		document.addEventListener('click', function (e) {
			var a = e.target.closest && e.target.closest('a[href^="#"]');
			if (!a) return;
			var id = a.getAttribute('href').slice(1);
			if (ids.indexOf(id) < 0) return;
			e.preventDefault(); show(id);
			if (!jump.contains(a)) jump.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	}
	// budget bar grows when it scrolls into view; pillars and steps rise in
	var rm = matchMedia('(prefers-reduced-motion: reduce)').matches;
	var els = [].slice.call(document.querySelectorAll('.wu-mb [data-mb-budget], .wu-mb .mb-pillar, .wu-mb .mb-steps, .wu-mb .mb-cases li, .wu-mb .mb-charge li, .wu-mb .mb-check li'));
	if (rm || !('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('is-in'); }); }
	else {
		document.documentElement.classList.add('mb-js');
		var ro = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); ro.unobserve(e.target); } }); }, { rootMargin: '0px 0px -12% 0px' });
		els.forEach(function (e) { ro.observe(e); });
	}
	// hero tiles lean toward the pointer
	if (!rm && matchMedia('(hover: hover)').matches) document.querySelectorAll('.wu-mb .mb-tile').forEach(function (t) {
		t.addEventListener('pointermove', function (e) { var b = t.getBoundingClientRect(); t.style.setProperty('--rx', ((e.clientX - b.left) / b.width - .5).toFixed(3)); t.style.setProperty('--ry', ((e.clientY - b.top) / b.height - .5).toFixed(3)); });
		t.addEventListener('pointerleave', function () { t.style.setProperty('--rx', 0); t.style.setProperty('--ry', 0); });
	});
	// process timeline (same as the other service pages)
	var fx = function () {
		if (!window.gsap || !window.ScrollTrigger) return;
		document.querySelectorAll('.wu-mb [data-tl]').forEach(function (tl) {
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
	if (!document.documentElement.classList.contains('wu-motion')) document.querySelectorAll('.wu-mb [data-count]').forEach(function (el) {
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
