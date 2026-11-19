<?php
/**
 * Media Buying Agency in Kerala ("WiseUp: Media Buying" in the page Template dropdown). Built from the owner's brief
 * (Downloads/media buying services page.docx, 2026-11-18): the doc is a page structure + keyword brief, so the copy is
 * written from it, in its section order. Owner answers: no prices anywhere; campaign snapshots = existing case studies
 * with their own figures (not claimed as OOH / print / theatre buys); trust strip = figures already on the site.
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

// Line drawings for the three pillars (hero cards and the pillar panels).
$wu_art = array(
	'ooh'     => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path class="mb-art__sky" d="M0 128h240"/><circle class="mb-art__acc" cx="206" cy="30" r="10"/><rect class="mb-art__fill" x="34" y="24" width="150" height="72" rx="6"/><path d="M52 46h60M52 60h92M52 74h44"/><rect class="mb-art__acc" x="150" y="40" width="22" height="40" rx="3"/><path d="M78 96v32M140 96v32M66 128h24M128 128h24"/><path d="M30 110l10-8 10 8M196 120h30M206 112v8"/></svg>',
	'print'   => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path class="mb-art__fill" d="M44 22h140l12 12v104H44z"/><path d="M184 22v12h12"/><path d="M58 40h78M58 50h56"/><rect class="mb-art__acc" x="58" y="64" width="62" height="46" rx="3"/><path d="M132 66h48M132 76h48M132 86h40M132 96h48M132 106h32M58 122h122M58 130h90"/></svg>',
	'theatre' => '<svg class="mb-art" viewBox="0 0 240 160" aria-hidden="true"><path d="M18 18h204"/><path class="mb-art__curtain" d="M18 18c6 40 4 84 0 112h24c-6-34-6-74 0-112z"/><path class="mb-art__curtain" d="M222 18c-6 40-4 84 0 112h-24c6-34 6-74 0-112z"/><rect class="mb-art__fill" x="52" y="30" width="136" height="70" rx="4"/><path class="mb-art__acc mb-art__beam" d="M120 52l-14 10 14 10z"/><path d="M60 118c10-6 20-6 30 0M98 118c10-6 20-6 30 0M136 118c10-6 20-6 30 0M78 136c10-6 20-6 30 0M116 136c10-6 20-6 30 0M154 136c10-6 20-6 30 0"/></svg>',
);

// Hero tiles: [ anchor, title, promise ].
$wu_tiles = array(
	array( 'ooh', 'OOH', 'Be seen where your customers travel every day.' ),
	array( 'print', 'Print', 'Reach readers who trust their morning paper.' ),
	array( 'theatre', 'Theatre', 'Speak to an audience that is already watching.' ),
);

// Pillars: id, title, intro, formats, how we buy, angle, best for.
$wu_pillars = array(
	array(
		'id' => 'ooh', 'eyebrow' => 'Pillar 01 · OOH', 'h3' => 'OOH Media Buying in Kerala',
		'what' => 'Out-of-home (OOH) advertising puts your brand on the roads, junctions, transit routes and public spaces your customers pass every day. It builds steady visibility in a city or locality, and it works well when you want people to remember your name before they need you.',
		'formats' => array( 'Hoardings and unipoles', 'Gantries', 'Bus shelters', 'Transit and bus branding', 'Railway and airport sites', 'Mall and digital screens', 'Wall branding' ),
		'how' => array( 'Site audit', 'Visibility check', 'Permissions and licensing', 'Installation', 'Proof-of-display photos' ),
		'angle' => 'Being based in Kozhikode, we plan OOH around the high-footfall stretches of Kozhikode and Malabar, and we check every site on the ground before it goes into your plan. Availability changes often, so we confirm the inventory for your campaign dates instead of promising fixed locations upfront.',
		'best' => array( 'Retail', 'Real estate', 'Jewellery', 'Hospitals' ),
		'cta' => 'Plan an OOH campaign',
	),
	array(
		'id' => 'print', 'eyebrow' => 'Pillar 02 · Print', 'h3' => 'Print Media Buying in Kerala',
		'what' => 'Newspapers are still where many Kerala households look for offers, admissions, jobs and announcements. Print gives your message the credibility of the paper it appears in, and it lets you reach a specific edition, district or readership on a specific day.',
		'formats' => array( 'Newspaper display ads', 'Supplements', 'Solus and jacket ads', 'Classifieds', 'Tenders and public notices', 'Magazines' ),
		'how' => array( 'Rate negotiation', 'Edition and position selection', 'Scheduling', 'Tear-sheet proof' ),
		'angle' => 'We help you choose between Malayalam and English dailies based on who you need to reach, then buy edition by edition, so a campaign can run across Malabar, Kochi and Thiruvananthapuram without paying for readers outside your market.',
		'best' => array( 'Offers', 'Admissions', 'Recruitment', 'Legal notices', 'Trust-led categories' ),
		'cta' => 'Plan a print campaign',
	),
	array(
		'id' => 'theatre', 'eyebrow' => 'Pillar 03 · Theatre', 'h3' => 'Theatre Advertising in Kerala',
		'what' => 'Cinema advertising reaches people who are seated, relaxed and looking at a big screen with nothing to skip. It is one of the few places where your ad gets full attention, which makes it a strong choice for launches and brands that rely on visual impact.',
		'formats' => array( 'Pre-show ads', 'Interval slides', 'Lobby branding', 'Film-release tie-ins', 'Multiplex networks', 'Single-screen theatres' ),
		'how' => array( 'Screen and city selection', 'Show-time planning', 'Playback confirmation' ),
		'angle' => 'We select screens and cities by the audience you want, plan show times and film releases around your launch, and confirm that your ad was played as booked.',
		'best' => array( 'Launches', 'Lifestyle and premium brands', 'Jewellery', 'Textiles' ),
		'cta' => 'Plan a theatre campaign',
	),
);

// Media planning vs media buying: [ aspect, planning, buying ].
$wu_vs = array(
	array( 'Purpose', 'Decides where, when and how often your ad should appear.', 'Secures those placements at the right rates and gets them live.' ),
	array( 'Key question', 'Which media will reach my audience best?', 'How do we get those spots at the best price and terms?' ),
	array( 'Work involved', 'Audience research, media mix, budget split and schedule.', 'Negotiation, booking, execution and proof of display.' ),
	array( 'Output', 'A media plan.', 'Live campaigns and a report showing they ran.' ),
);
// How media buying works: [ icon, step, text ].
$wu_how = array(
	array( 'map', 'Plan', 'Match the media to your audience, goal and budget.' ),
	array( 'deal', 'Negotiate', 'Get rates, positions and terms that suit the plan.' ),
	array( 'book', 'Book', 'Confirm sites, editions and screens for your dates.' ),
	array( 'check', 'Verify', 'Collect proof that every ad ran as booked.' ),
);
// Which medium for which goal (doc table).
$wu_goals = array(
	array( 'Local dominance in a city or locality', 'OOH', 'ooh' ),
	array( 'Credibility, offers, notices', 'Print', 'print' ),
	array( 'Launch buzz, captive audience', 'Theatre', 'theatre' ),
);
// Sample budget split for the integrated section (an example, labelled as such on the page).
$wu_split = array(
	array( 'OOH', 45, 'Steady presence in your key city' ),
	array( 'Print', 30, 'Offer and launch announcements' ),
	array( 'Theatre', 15, 'Launch-week attention' ),
	array( 'Digital support', 10, 'Retargeting and response tracking' ),
);
// Digital support points: [ icon, title, text ].
$wu_digital = array(
	array( 'repeat', 'Retarget people you reached offline', 'Follow up with online ads for the audiences and areas your OOH, print or theatre campaign covered, so the message is seen more than once.' ),
	array( 'qr', 'Measure response online', 'QR codes, campaign links, landing pages and dedicated numbers show how many people responded to each offline placement.' ),
	array( 'link', 'One plan across channels', 'Digital spends are planned in the same media plan, so offline and online ads support each other instead of competing for budget.' ),
);
// Process: [ title, icon, text ].
$wu_process = array(
	array( 'Discovery', 'chat', 'We learn about your business, campaign goal, timeline, target locations and budget.' ),
	array( 'Audience and market research', 'users', 'We study who you need to reach, where they live and travel, what they read and watch, and what competitors are doing.' ),
	array( 'Media mix and budget', 'pie', 'We choose the right mix of OOH, print, theatre and digital support, and split the budget across them in a clear media plan.' ),
	array( 'Negotiation and booking', 'deal', 'We negotiate rates, positions and schedules with media owners, then confirm every booking for your dates.' ),
	array( 'Execution and monitoring', 'eye', 'We manage creatives, installation and release, and check that every placement goes live as planned.' ),
	array( 'Reporting', 'chart', 'You receive proof of display, tear sheets and playback confirmation, with a summary of what ran and what responded.' ),
);
// Why work with a media buying company: [ icon, title, text ].
$wu_why = array(
	array( 'tag', 'Negotiated rates', 'Media owners price differently for direct buyers and agencies that book regularly. We negotiate rates, positions and add-ons, so your budget covers more.' ),
	array( 'one', 'One point of accountability', 'One team handles planning, booking, creatives and execution across every medium, instead of you coordinating with several vendors.' ),
	array( 'camera', 'Proof of execution', 'You receive proof-of-display photos, tear sheets and playback confirmation for what you paid for.' ),
	array( 'clock', 'Time saved', 'Site checks, permissions, rate comparisons and follow-ups are handled for you, so your team can focus on the business.' ),
);
// How we charge: [ icon, model, text ].
$wu_charge = array(
	array( 'percent', 'Commission', 'A percentage of the media spend. Common for larger bookings, where the agency is paid from the value of the media it buys.' ),
	array( 'flat', 'Flat fee', 'A fixed fee for planning and managing a specific campaign, agreed before work starts. Useful for one-off launches and short bursts.' ),
	array( 'repeat', 'Retainer', 'A monthly fee for ongoing planning, buying and reporting. Suits brands that advertise across media throughout the year.' ),
);
// How to choose: checklist.
$wu_choose = array(
	array( 'Transparency', 'You see the media costs and our fee separately, with no hidden mark-ups.' ),
	array( 'Reporting', 'You receive clear reports and proof for every placement, not just an invoice.' ),
	array( 'Local rate knowledge', 'The agency knows current rates, sites, editions and screens in your market.' ),
	array( 'Proof of work', 'They can show past campaigns and the results behind them.' ),
);
// Industries: [ name, filled icon path ].
$wu_ind = array(
	array( 'Healthcare', 'M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm6 11h-3v3h-2v-3H8v-2h3v-3h2v3h3v2z' ),
	array( 'Retail', 'M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z' ),
	array( 'Education', 'M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3 1 9l11 6 9-4.91V17h2V9L12 3z' ),
	array( 'Real estate', 'M1 11v10h5v-6h4v6h5V11L8 6z M10 3v1.97l7 5V11h2v2h-2v2h2v2h-2v4h6V3H10zm9 6h-2V7h2v2z' ),
	array( 'Jewellery', 'M19 3H5L2 9l10 12L22 9l-3-6zM9.62 8l1.5-3h1.76l1.5 3H9.62zM11 10v6.68L5.44 10H11zm2 0h5.56L13 16.68V10zm6.26-2h-2.65l-1.5-3h2.65l1.5 3zM6.24 5h2.65l-1.5 3H4.74l1.5-3z' ),
	array( 'Textiles', 'M16 3l-2.2 1.6h-3.6L8 3 2.5 6.5l2.3 4.4 2.2-1.1V21h10V9.8l2.2 1.1 2.3-4.4z' ),
	array( 'Hospitality', 'M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z' ),
	array( 'FMCG', 'M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z' ),
);
// Campaign snapshots (owner: use existing case studies with their own figures): [ name, kind, image, figure, label, url ].
$wu_cases = array(
	array( 'Bootland Expo 2026', 'Expo launch campaign', WISEUP_URL . 'assets/landing/img/case-bootland.jpg', '21.6M+', 'Impressions for the launch', 'https://wiseup.in/case-studies/bootland/' ),
	array( 'Sathya Agencies', 'Brand launch campaign', WISEUP_ASSETS . '/work/case-sathya-720.webp', '1M+', 'Minimum reach on every video', 'https://wiseup.in/case-studies/sathya-agencies-brand-launch-campaign-kerala/' ),
	array( 'Golden Karak', 'Café brand campaign', WISEUP_URL . 'assets/landing/img/case-karak.jpg', '2M+', 'Views on one Instagram Reel', 'https://wiseup.in/case-studies/golden-karak/' ),
);

$wu_faq = array(
	array( 'What is media buying?', 'Media buying is the process of purchasing advertising space and time, such as hoardings, newspaper space or cinema screen time, at the right price and on the right dates. A media buying agency negotiates with media owners, books the placements, manages execution and proves that your ads ran.' ),
	array( 'What is the difference between media planning and media buying?', 'Media planning decides where, when and how often your ads should appear, based on your audience, goal and budget. Media buying secures those placements, negotiates the rates and terms, and gets the campaign live. Planning produces the plan; buying puts it into action.' ),
	array( 'How much does a media buying agency charge?', 'Agencies usually charge a commission on the media spend, a flat fee for a specific campaign, or a monthly retainer for ongoing work. The right model depends on how often you advertise and how many media you use. We explain our fee separately from the media costs in every proposal.' ),
	array( 'Do I need a media buying agency for a small budget?', 'A small budget gains the most from careful planning, because there is less room for waste. An agency can help you choose one or two media that suit your goal, negotiate better rates and avoid placements that look busy but reach the wrong people.' ),
	array( 'How do I book OOH advertising in Kozhikode?', 'Share your campaign goal, target areas, dates and budget with us. We shortlist available hoardings and other OOH sites, check their visibility on the ground, handle permissions and printing, install the creatives and send you proof-of-display photos.' ),
	array( 'Which newspapers work best for advertising in Kerala?', 'It depends on who you want to reach. Malayalam dailies have the widest reach across Kerala households, while English dailies suit professional, urban and some B2B audiences. Edition-wise buying lets you reach only the districts that matter, such as Malabar, Kochi or Thiruvananthapuram.' ),
	array( 'How much does cinema advertising cost in Kerala?', 'Cinema advertising costs depend on the number of screens, the cities, multiplex or single-screen theatres, the ad format and how long the campaign runs. We share a plan with options for your budget before you commit to any booking.' ),
	array( 'Can you buy media across Kerala and India?', 'Yes. We are based in Kozhikode and plan campaigns across all of Kerala. For brands that need reach beyond the state, we can plan and buy media in other parts of India as well.' ),
	array( 'How do you prove my ads ran?', 'For OOH we share proof-of-display photos of every site, for print we share tear sheets of the published ads, and for theatre we confirm playback with the screens. You receive these with a summary report at the end of the campaign.' ),
	array( 'How do digital and offline media buying work together?', 'Offline media such as OOH, print and theatre build awareness at scale. Digital ads can then retarget the people and areas you reached, and QR codes, campaign links and landing pages help measure how many people responded to each offline placement.' ),
);
add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 20 );

$wu_addr = wiseup_opt( 'contact_address' );
$wu_map  = wiseup_opt( 'contact_map' );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-mb-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-mb">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero mb-hero">
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<p class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Media planning &amp; buying</p>
				<h1 class="ev-hero__h"><span class="sh__a">Media Buying Agency in Kerala</span> <span class="sh__b">for OOH, Print and Theatre Advertising</span></h1>
				<p class="ev-hero__p">WiseUp is a media buying agency in Kerala that plans, negotiates and books your advertising across hoardings, newspapers and cinema screens. As a media planning and buying agency based in Kozhikode, we cover all of Kerala, and we prove every placement ran as booked.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Get a Free Media Plan', 'teal', $wu_lead ); // phpcs:ignore ?>
					<a class="mb-icbtn mb-icbtn--wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><?php echo $wu_wa_svg; // phpcs:ignore ?></a>
					<a class="mb-icbtn" href="tel:+916282434503" aria-label="Call +91 62824 34503"><?php echo $wu_call_svg; // phpcs:ignore ?></a>
				</div>
			</div>
			<?php $wu_ca = esc_url( WISEUP_ASSETS . '/brand/wiseup-logo.webp' ); ?>
			<!-- Hero scene (owner's script, walker removed on request): a road by the paddy fields with a WiseUp hoarding;
			     a newspaper boy cycles past, throws a paper, and it opens on the same WiseUp ad. SVG + CSS, 16s loop. -->
			<figure class="mb-scene" aria-label="Animation: a WiseUp hoarding beside a road through paddy fields, then a newspaper delivered by bicycle opens on the same WiseUp ad">
				<svg viewBox="0 0 800 560" role="presentation" aria-hidden="true">
					<defs>
						<clipPath id="sc-clip"><rect width="800" height="560" rx="28"/></clipPath>
						<g id="sc-ad">
							<rect width="250" height="116" rx="6" fill="#0c0c0e"/>
							<image href="<?php echo $wu_ca; // phpcs:ignore ?>" x="25" y="12" width="200" height="72"/>
							<rect x="65" y="94" width="120" height="7" rx="3.5" fill="#beda52"/>
						</g>
					</defs>
					<g clip-path="url(#sc-clip)">
						<image href="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/mb-scene-bg.webp' ); ?>" width="800" height="560" preserveAspectRatio="xMidYMid slice"/>
						<!-- hoarding -->
						<g class="sc-hoard">
							<path d="M548 360V232M690 360V232" stroke="#3a3a3f" stroke-width="7"/>
							<path d="M534 360h28M676 360h28" stroke="#3a3a3f" stroke-width="5"/>
							<rect x="482" y="92" width="270" height="140" rx="8" fill="#16161a" stroke="#e6e6ea" stroke-width="3"/>
							<use href="#sc-ad" x="492" y="104"/>
							<rect class="sc-hoard__glow" x="476" y="86" width="282" height="152" rx="12" fill="none" stroke="#beda52" stroke-width="4"/>
							<path class="sc-hoard__lamp" d="M512 84l10-14M722 84l-10-14" stroke="#e6e6ea" stroke-width="3" stroke-linecap="round"/>
						</g>
						<!-- cyclist -->
						<g class="sc-cyc"><g transform="translate(0 412) scale(1.4)">
							<g transform="translate(-26 -18)"><g class="sc-wheel"><circle r="18" fill="none" stroke="#e6e6ea" stroke-width="3"/><path d="M-18 0h36M0-18v36" stroke="#8a8a92" stroke-width="2"/></g></g>
							<g transform="translate(30 -18)"><g class="sc-wheel"><circle r="18" fill="none" stroke="#e6e6ea" stroke-width="3"/><path d="M-18 0h36M0-18v36" stroke="#8a8a92" stroke-width="2"/></g></g>
							<path d="M-26-18l18-26h30l8 26M-8-44l12 26 26-26M22-44l-4-12" fill="none" stroke="#beda52" stroke-width="4" stroke-linejoin="round" stroke-linecap="round"/>
							<rect x="26" y="-56" width="22" height="14" rx="2" fill="#f1ece0" stroke="#8a8a92" stroke-width="2"/>
							<path d="M-6-48l10-30M4-78l18 16" stroke="#3b82b6" stroke-width="9" stroke-linecap="round"/>
							<path d="M-8-46l14 22" stroke="#26262b" stroke-width="7" stroke-linecap="round"/>
							<circle cx="6" cy="-90" r="10" fill="#9c6b43"/>
						</g></g>
						<!-- thrown paper -->
						<g class="sc-toss"><rect x="-12" y="-8" width="24" height="16" rx="2" fill="#f1ece0" stroke="#8a8a92" stroke-width="1.5"/></g>
												<!-- newspaper close-up: the same ad -->
						<g class="sc-paper"><g transform="translate(400 286)">
							<g class="sc-paper__in">
								<rect x="-190" y="-150" width="380" height="290" rx="6" fill="#f1ece0"/>
								<rect x="-190" y="-150" width="380" height="290" rx="6" fill="none" stroke="#d6cfbd" stroke-width="2"/>
								<rect x="-160" y="-128" width="320" height="16" rx="3" fill="#1d1d20"/>
								<path d="M-160-100h320M-160-96h320" stroke="#1d1d20" stroke-width="1.5"/>
								<path d="M-160-78h130M-160-66h120M-160-54h130M-160-42h100M-160 120h320M-160 108h320" stroke="#b5ad99" stroke-width="5" stroke-linecap="round"/>
								<path d="M-12-78h172M-12-66h150" stroke="#55524a" stroke-width="7" stroke-linecap="round"/>
								<use href="#sc-ad" x="-125" y="-24"/>
								<rect x="-131" y="-30" width="262" height="128" rx="9" fill="none" stroke="#beda52" stroke-width="4"/>
							</g>
						</g></g>
					</g>
				</svg>
			</figure>
			<nav class="mb-tiles" aria-label="Our media">
				<?php foreach ( $wu_tiles as $wu_k => $t ) : ?>
				<a class="mb-tile mb-tile--<?php echo esc_attr( $t[0] ); ?>" href="#<?php echo esc_attr( $t[0] ); ?>" style="--k:<?php echo (int) $wu_k; ?>">
					<span class="mb-tile__art"><?php echo $wu_art[ $t[0] ]; // phpcs:ignore ?></span>
					<span class="mb-tile__t"><b><?php echo esc_html( $t[1] ); ?></b><small><?php echo esc_html( $t[2] ); ?></small></span>
					<span class="mb-tile__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
				</a>
				<?php endforeach; ?>
			</nav>
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
	'q' => 'What does a media buying agency in Kerala do?',
	'a' => '<b>WiseUp</b> is a media planning and buying agency in Kozhikode that <b>plans, negotiates, books and verifies</b> OOH, print and theatre advertising across Kerala, with digital ads to support offline campaigns.',
	'points' => array(
		array( 'Media', 'Hoardings and other OOH sites, newspaper and magazine ads, and cinema advertising in multiplex and single-screen theatres.' ),
		array( 'How it works', 'Discovery and research, a media mix and budget, negotiation and booking, execution, then reporting with proof.' ),
		array( 'Proof', 'Proof-of-display photos for OOH, tear sheets for print and playback confirmation for theatre.' ),
		array( 'Where', 'Based in Kozhikode, covering Malabar and the rest of Kerala, and able to buy media beyond the state.' ),
	),
	'note' => 'Every campaign starts with a free media plan, before any booking.',
	'links' => array( array( 'Services', '#mb-services' ), array( 'Process', '#mb-process' ), array( 'Pricing models', '#mb-why' ), array( 'FAQ', '#faq' ) ),
) ); ?>

	<!-- 2. What is media buying -->
	<section class="sec ev-sec" id="mb-what">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'The basics' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'What Is', 'Media Buying?' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p class="mb-def">Media buying is the process of purchasing advertising space and time, such as hoardings, newspaper space and cinema screen time, at the right price and on the right dates. A media buying agency negotiates with media owners, books the placements, manages execution and proves that your ads ran.</p></div>
			</div>

			<div class="mb-two">
				<div class="mb-vs">
					<h3>Media Planning vs Media Buying</h3>
					<table class="mb-table">
						<thead><tr><th scope="col"><span class="sr-only">Aspect</span></th><th scope="col">Media planning</th><th scope="col">Media buying</th></tr></thead>
						<tbody>
						<?php foreach ( $wu_vs as $v ) : ?>
							<tr><th scope="row"><?php echo esc_html( $v[0] ); ?></th><td><?php echo esc_html( $v[1] ); ?></td><td><?php echo esc_html( $v[2] ); ?></td></tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="mb-how">
					<h3>How Media Buying Works</h3>
					<ol class="mb-steps">
						<?php foreach ( $wu_how as $wu_k => $s ) : ?>
						<li style="--k:<?php echo (int) $wu_k; ?>"><span class="mb-steps__i"><?php echo $wu_svg( $wu_icons[ $s[0] ], 22 ); // phpcs:ignore ?></span><div><b><?php echo esc_html( $s[1] ); ?></b><span><?php echo esc_html( $s[2] ); ?></span></div></li>
						<?php endforeach; ?>
					</ol>
				</div>
			</div>

			<div class="mb-goals">
				<h3>Which Medium for Which Goal?</h3>
				<table class="mb-goal">
					<thead><tr><th scope="col">Your goal</th><th scope="col">Best-fit pillar</th></tr></thead>
					<tbody>
					<?php foreach ( $wu_goals as $g ) : ?>
						<tr><td><?php echo esc_html( $g[0] ); ?></td><td><a class="mb-pill mb-pill--<?php echo esc_attr( $g[2] ); ?>" href="#<?php echo esc_attr( $g[2] ); ?>"><?php echo esc_html( $g[1] ); ?></a></td></tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<!-- 3. Services: three pillars with a sticky jump nav -->
	<section class="sec ev-sec" id="mb-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Planning and Buying', 'Services We Offer' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>We plan and buy three kinds of offline media, each with the same care: the right placements, negotiated rates and proof that they ran. Pick a pillar below, or let us combine them in one plan.</p></div>
			</div>
			<nav class="mb-jump" aria-label="Jump to a service" data-mb-jump>
				<?php foreach ( $wu_pillars as $p ) : ?><a href="#<?php echo esc_attr( $p['id'] ); ?>"><?php echo esc_html( strtok( $p['h3'], ' ' ) ); ?></a><?php endforeach; ?>
			</nav>
			<div class="mb-pillars">
				<?php foreach ( $wu_pillars as $wu_k => $p ) : ?>
				<article class="mb-pillar" id="<?php echo esc_attr( $p['id'] ); ?>" data-mb-pillar>
					<div class="mb-pillar__vis"><span class="mb-pillar__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_k + 1 ) ); ?></span><?php echo $wu_art[ $p['id'] ]; // phpcs:ignore ?></div>
					<div class="mb-pillar__body">
						<p class="mb-pillar__kick"><?php echo esc_html( $p['eyebrow'] ); ?></p>
						<h3><?php echo esc_html( $p['h3'] ); ?></h3>
						<p><?php echo esc_html( $p['what'] ); ?></p>
						<div class="mb-pillar__grid">
							<div>
								<h4>Formats we buy</h4>
								<ul class="mb-chips"><?php foreach ( $p['formats'] as $f ) echo '<li>' . esc_html( $f ) . '</li>'; ?></ul>
							</div>
							<div>
								<h4>How we buy</h4>
								<ol class="mb-flow"><?php foreach ( $p['how'] as $f ) echo '<li>' . esc_html( $f ) . '</li>'; ?></ol>
							</div>
						</div>
						<p class="mb-pillar__angle"><?php echo esc_html( $p['angle'] ); ?></p>
						<div class="mb-pillar__foot">
							<p class="mb-best"><span>Best for</span><?php echo esc_html( implode( ' · ', $p['best'] ) ); ?></p>
							<?php echo $wu_btn( $p['cta'], 'teal', $wu_lead ); // phpcs:ignore ?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 4. Integrated media planning -->
	<section class="sec ev-sec" id="mb-plan">
		<div class="wrap">
			<div class="mb-split">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Integrated planning' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Planning and Buying,', 'Built Around One Strategy' ); // phpcs:ignore ?></h2>
					<p class="mb-lead">OOH, print and theatre work best when they share one message, one schedule and one budget. As a media planning and buying agency, we decide what each pillar should do: OOH keeps your name visible in the places your customers pass, print carries the offer and the details, and theatre gives a launch its moment of full attention. Digital support then follows up with the people you reached. Unlike media planning and buying agencies that only book space, we plan the mix first, so every rupee has a job.</p>
				</div>
				<figure class="mb-budget" data-mb-budget>
					<figcaption><b>A sample budget split</b><span>Example only. Your plan depends on your goal, cities and dates.</span></figcaption>
					<div class="mb-bar" role="img" aria-label="Example split: OOH 45%, Print 30%, Theatre 15%, Digital support 10%">
						<?php foreach ( $wu_split as $wu_k => $s ) : ?><i class="mb-bar__s mb-bar__s--<?php echo (int) $wu_k; ?>" style="--w:<?php echo (int) $s[1]; ?>"></i><?php endforeach; ?>
					</div>
					<ul class="mb-legend">
						<?php foreach ( $wu_split as $wu_k => $s ) : ?>
						<li class="mb-legend--<?php echo (int) $wu_k; ?>"><b><?php echo (int) $s[1]; ?>%</b><span><?php echo esc_html( $s[0] ); ?></span><small><?php echo esc_html( $s[2] ); ?></small></li>
						<?php endforeach; ?>
					</ul>
				</figure>
			</div>
		</div>
	</section>

	<!-- 5. Digital media buying (supporting) -->
	<section class="sec ev-sec" id="mb-digital">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Digital support' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Media Buying to Support', 'Your Offline Campaigns' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Digital media buying is not a separate pillar here; it is how we make offline campaigns go further. Media buying in digital marketing lets us reach the same audience again and measure who responded. For full-scale online advertising, see our <a href="https://wiseup.in/services/digital-marketing-agency-in-kerala/">digital marketing</a> services.</p></div>
			</div>
			<ul class="pm-grid mb-dig">
				<?php foreach ( $wu_digital as $d ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $d[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $d[1] ); ?></h3><p><?php echo esc_html( $d[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. Process -->
	<section class="sec ev-sec" id="mb-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'How Our Media Buying', 'Process Works' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Every campaign follows the same six steps, from the first conversation to the final proof. You know what is booked, what it costs and when it goes live.</p></div>
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

	<!-- 7. Why work with a media buying company -->
	<section class="sec ev-sec" id="mb-why">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why an agency' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Why Work With a', 'Media Buying Company' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>You can book a hoarding or a newspaper ad yourself. A media buying company makes sure it is the right one, at the right rate, and that it actually runs.</p></div>
			</div>
			<ul class="pm-grid mb-why">
				<?php foreach ( $wu_why as $w ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $w[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>

			<div class="mb-two mb-two--charge">
				<div>
					<h3 class="mb-sub">How We Charge</h3>
					<p class="mb-subp">Media buying agencies are usually paid in one of three ways. We recommend the one that fits how you advertise, and we always show our fee separately from the media cost.</p>
					<ul class="mb-charge">
						<?php foreach ( $wu_charge as $c ) : ?>
						<li><span class="mb-charge__i"><?php echo $wu_svg( $wu_icons[ $c[0] ], 22 ); // phpcs:ignore ?></span><div><b><?php echo esc_html( $c[1] ); ?></b><p><?php echo esc_html( $c[2] ); ?></p></div></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<h3 class="mb-sub">How to Choose a Media Buying Agency</h3>
					<p class="mb-subp">Before you sign with any media buying agency, check for these four things.</p>
					<ul class="mb-check">
						<?php foreach ( $wu_choose as $c ) : ?>
						<li><span class="mb-check__t" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="m6 12.5 4 4L18 8" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span><div><b><?php echo esc_html( $c[0] ); ?></b><p><?php echo esc_html( $c[1] ); ?></p></div></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. Kozhikode -->
	<section class="sec ev-sec" id="mb-local">
		<div class="wrap">
			<div class="mb-local">
				<div class="mb-local__copy">
					<?php echo $wu_eyebrow( 'Kozhikode' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Media Buying Agency', 'in Kozhikode' ); // phpcs:ignore ?></h2>
					<p>Searching for a media buying agency near me in Kozhikode? Our studio is at Govt. Cyberpark, so we know the city’s roads, junctions, editions and screens first-hand. Businesses looking for the best media buying agencies in Kozhikode want someone who can visit a site, talk to a local publisher and fix a problem the same day, and that is how we work.</p>
					<p>From Kozhikode we cover Malabar and the rest of Kerala, from Kasaragod to Thiruvananthapuram. Among media buying agencies in Kerala, we combine local presence with one plan that can run across the state.</p>
					<div class="ev-contact">
						<a class="ev-ct" href="<?php echo esc_url( $wu_map ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><?php echo $wu_pin_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Visit us</small><?php echo esc_html( $wu_addr ); ?></span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
						<a class="ev-ct" href="tel:+916282434503">
							<span class="ev-ct__i"><?php echo $wu_call_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Call us</small>+91 62824 34503</span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
					</div>
				</div>
				<div class="mb-local__map">
					<iframe title="WiseUp office on Google Maps" src="https://maps.google.com/maps?q=Sahya%20Building%2C%20Govt.%20Cyberpark%2C%20Nellikkode%2C%20Kozhikode&amp;z=15&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>
	</section>

	<!-- 9. Industries and proof -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries & work' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries We Serve and', 'Campaigns We’ve Run' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>We plan media for businesses that need to be seen locally and trusted widely. We are a Kerala-based team, and among media buying agencies in India we can also run campaigns beyond the state when your market grows.</p></div>
			</div>
			<ul class="dm-ind dm-mag mb-ind" data-mag>
				<?php foreach ( $wu_ind as $ind ) : ?>
				<li><span class="dm-ind__i"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="<?php echo esc_attr( $ind[1] ); ?>"/></svg></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
			<h3 class="mb-sub mb-sub--cases">Recent campaigns</h3>
			<ul class="mb-cases">
				<?php foreach ( $wu_cases as $c ) : ?>
				<li>
					<a href="<?php echo esc_url( $c[5] ); ?>" class="mb-case">
						<img src="<?php echo esc_url( $c[2] ); ?>" alt="<?php echo esc_attr( $c[0] . ' ' . strtolower( $c[1] ) . ' by WiseUp' ); ?>" loading="lazy" decoding="async" width="720" height="540">
						<span class="mb-case__t"><small><?php echo esc_html( $c[1] ); ?></small><b><?php echo esc_html( $c[0] ); ?></b></span>
						<span class="mb-case__fig"><b><?php echo esc_html( $c[3] ); ?></b><?php echo esc_html( $c[4] ); ?></span>
						<span class="mb-case__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<script>(function(){var u=document.querySelector('.wu-mb [data-mag]');if(!u)return;var li=[].slice.call(u.children);if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){li.forEach(function(l){l.classList.add('is-on');});return;}u.classList.add('is-js');var io=new IntersectionObserver(function(es){es.forEach(function(e){e.target.classList.toggle('is-on',e.isIntersecting);});},{rootMargin:'-42% 0px -42% 0px'});li.forEach(function(l){io.observe(l);});})();</script>
		</div>
	</section>

	<!-- 10. FAQ -->
	<section class="sec ev-sec" id="faq" aria-labelledby="mb-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="mb-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
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

	<!-- 11. Final CTA -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Plan Your Next', 'Campaign With Us' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Tell us your budget and the media you are considering. We will come back with a free media plan before you book anything.</p>
					<div class="ev-contact">
						<a class="ev-ct ev-ct--wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><?php echo $wu_wa_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Chat on WhatsApp</small>+91 62824 34503</span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
						<a class="ev-ct" href="tel:+916282434503">
							<span class="ev-ct__i"><?php echo $wu_call_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Call us</small>+91 62824 34503</span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
						<a class="ev-ct mb-ct-wide" href="<?php echo esc_url( $wu_map ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><?php echo $wu_pin_svg; // phpcs:ignore ?></span>
							<span class="ev-ct__t"><small>Visit us</small><?php echo esc_html( $wu_addr ); ?></span>
							<span class="ev-ct__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						</a>
					</div>
				</div>
				<form class="ev-form mb-form" data-dm-form novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>" data-source="<?php echo esc_attr( $wu_src ); ?>">
					<label><span>Name</span><input name="name" required autocomplete="name"></label>
					<label><span>Phone</span><input name="phone" type="tel" required autocomplete="tel"></label>
					<label class="ev-form__wide"><span>Budget range</span>
						<select name="budget" required>
							<option value="" selected disabled>Choose one</option>
							<option>Under ₹1 lakh</option>
							<option>₹1 to 5 lakh</option>
							<option>₹5 to 15 lakh</option>
							<option>Above ₹15 lakh</option>
							<option>Not sure yet</option>
						</select>
					</label>
					<fieldset class="ev-form__wide mb-media"><legend>Media interest</legend>
						<?php foreach ( array( 'OOH', 'Print', 'Theatre', 'Digital support' ) as $m ) : ?>
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
			pills.forEach(function (p) { p.classList.toggle('is-active', p.id === id); if (p.id === id) p.classList.add('is-in'); });
			links.forEach(function (a) { var on = a.getAttribute('href') === '#' + id; a.classList.toggle('is-on', on); a.setAttribute('aria-selected', on ? 'true' : 'false'); });
		};
		document.querySelector('.wu-mb').classList.add('mb-tabs');
		jump.setAttribute('role', 'tablist');
		links.forEach(function (a) { a.setAttribute('role', 'tab'); });
		show(ids.indexOf(location.hash.slice(1)) > -1 ? location.hash.slice(1) : ids[0]);
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
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
