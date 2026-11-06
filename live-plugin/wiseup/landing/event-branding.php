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
);

// Section 3: the doc's nine cards, two lines each. 'link' = the card's sub-page (doc: "a link to a sub-page later");
// fill it in when the sub-page exists and the card links there.
$wu_services = array(
	array( 'title' => 'Corporate event branding', 'icon' => 'mic', 'text' => 'Corporate event branding services for conferences, summits, launches and award nights, carried in your company identity from the invite to the stage.', 'link' => '' ),
	array( 'title' => 'Exhibition and stall branding', 'icon' => 'stall', 'text' => 'Stall graphics, fascia, back walls and counters designed to stand out across the exhibition hall.', 'link' => '' ),
	array( 'title' => 'Stage, backdrop and LED branding', 'icon' => 'stage', 'text' => 'Main stage backdrops, stage wraps and LED screen content, sized to the real stage.', 'link' => '' ),
	array( 'title' => 'Venue branding, signage, and wayfinding', 'icon' => 'sign', 'text' => 'Entrance, hall and directional signage that guides guests and carries the event identity through the venue.', 'link' => '' ),
	array( 'title' => 'Standees, banners, and displays', 'icon' => 'banner', 'text' => 'Roll-up standees, banners and display units designed as one set and delivered print-ready.', 'link' => '' ),
	array( 'title' => 'Event collateral: invitations, badges, kits, brochures', 'icon' => 'badge', 'text' => 'Invitations, badges, delegate kits and brochures that carry the same identity into every guest’s hands.', 'link' => '' ),
	array( 'title' => 'Brand activation and experiential', 'icon' => 'spark', 'text' => 'Activations and experiential spaces that let guests interact with the brand, not just see it.', 'link' => '' ),
	array( 'title' => 'Creative event branding', 'icon' => 'brush', 'text' => 'Creative event branding with themes, concepts and custom environments built for one event.', 'link' => '' ),
	array( 'title' => 'Virtual and hybrid event branding', 'icon' => 'screen', 'text' => 'Branding for the online audience too: virtual stages, lobbies, overlays and templates.', 'link' => '#virtual' ),
);

$wu_cases = array(
	array(
		'name'    => 'Bootland Expo',
		'type'    => 'Trade exhibition',
		'img'     => WISEUP_URL . 'assets/landing/img/case-bootland.jpg',
		'url'     => home_url( '/case-studies/bootland/' ),
		'problem' => 'Make Kerala’s largest footwear exhibition feel unforgettable in a market full of generic trade events.',
		'did'     => 'Brand strategy, visual identity, mascot design, marketing assets and on-ground event branding.',
		'stats'   => array( array( '21.6M+', 'impressions' ), array( '2,000+', 'B2B leads' ), array( '100%', 'stall occupancy' ) ),
	),
	array(
		'name'    => 'Sathya Agencies',
		'type'    => 'Retail brand launch',
		'img'     => WISEUP_URL . 'assets/work/case-sathya-720.webp',
		'url'     => 'https://wiseup.in/case-studies/sathya-agencies-brand-launch-campaign-kerala/',
		'problem' => 'Launch a retail brand across Kerala with one consistent look at every store launch.',
		'did'     => 'The brand launch campaign: store launch branding and the video content around it.',
		'stats'   => array( array( '6+', 'store launches' ), array( '100+', 'videos' ), array( '1M+', 'minimum reach per video' ) ),
	),
	array(
		'name'    => 'Smoke House (Bucho Meat)',
		'type'    => 'Restaurant brand activation, Calicut Beach',
		'img'     => WISEUP_URL . 'assets/landing/img/case-smokehouse.jpg',
		'url'     => home_url( '/case-studies/smokehouse/' ),
		'problem' => 'A smokehouse restaurant near Calicut Beach with a strong product but low walk-in traffic and weak brand positioning.',
		'did'     => 'A complete brand activation: menu redesign, outdoor branding for beach traffic, atmosphere curation, NFC brand cards, review prompts and influencer activation.',
		'stats'   => array( array( '30 days', 'to a visible impact' ), array( 'Footfall', 'significant increase' ), array( 'Reviews', 'improved online ratings' ) ),
	),
);

$wu_faq = array(
	array( 'What is event branding, and what does it include?', 'Event branding is the identity of an event: its name, logo, colours, fonts and theme, and the signage, stage and collateral that carry them as one. It includes stage and backdrop branding, venue signage and wayfinding, standees and banners, invitations, badges and kits, and the branding for virtual and hybrid audiences.' ),
	array( 'How much does event branding cost in Kerala?', 'Event branding with WiseUp starts from ₹25,000. The final cost depends on the event scale, the number of branded touchpoints, materials and fabrication, installation and the timeline.' ),
	array( 'How early should we brief an event branding agency?', 'Brief us at least 14 days before the event.' ),
	array( 'Do you handle printing and installation, or only design?', 'Both. One team takes the event from concept and design to production and on-site installation.' ),
	array( 'Can you brand virtual and hybrid events?', 'Yes. We design virtual stages and lobbies, branded webinar templates, social and email kits, and LED and livestream overlays, kept in line with the branding at the venue.' ),
	array( 'Do you work outside Kochi or Kozhikode?', 'Yes. Our team is based in Kozhikode, visits venues across Kerala, and has served clients in 100+ cities.' ),
	array( 'What’s the difference between corporate event branding and event management?', 'Event management runs the event: venue, logistics, schedule and guests. Corporate event branding is how the event looks and is remembered: its identity, stage, signage and collateral.' ),
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
			<h1 class="ev-hero__h"><span class="sh__a">Event Branding Agency in Kerala:</span> <span class="sh__b">Corporate &amp; Creative Event Branding Services</span></h1>
			<p class="ev-hero__p">An event branding company in Kerala that delivers end to end, from concept to on-ground. One team plans the identity, designs every touchpoint, coordinates production and installs it at the venue, for corporate events, conferences, exhibitions and hybrid events.</p>
			<div class="ev-btns">
				<?php echo $wu_btn( 'WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				<?php echo $wu_btn( 'Get a Quote', 'teal', 'data-lead-open data-lead-source="event-branding"' ); // phpcs:ignore ?>
			</div>
			</div>
			<div class="ev-stage" aria-hidden="true" data-stage>
				<span class="ev-beam ev-beam--l"></span><span class="ev-beam ev-beam--r"></span>
				<div class="ev-stage__screen">
					<img class="ev-led__img" src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/case-bootland.jpg' ); ?>" alt="" decoding="async" fetchpriority="high">
					<span class="ev-led__grid"></span>
					<span class="ev-led__sweep"></span>
					<span class="ev-led__mark">W</span>
					<span class="ev-led__k">Main stage</span>
				</div>
				<div class="ev-standee ev-standee--l"><i></i><b></b><b></b><b></b></div>
				<div class="ev-standee ev-standee--r"><i></i><b></b><b></b><b></b></div>
				<div class="ev-lectern"><span>W</span></div>
				<div class="ev-stage__deck"></div>
				<div class="ev-stage__floor"></div>
				<div class="ev-pass">
					<span class="ev-pass__cord"></span>
					<div class="ev-pass__card">
						<span class="ev-pass__clip"></span>
						<span class="ev-pass__top">EVENT PASS</span>
						<span class="ev-pass__mark">W</span>
						<span class="ev-pass__name">Your event</span>
						<span class="ev-pass__role">Branded by WiseUp</span>
						<span class="ev-pass__bar"></span>
					</div>
				</div>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					array( 10, '+', 'Events branded' ),
					array( 100, '+', 'Cities served' ),
					array( 120, '+', 'Projects delivered' ),
					array( 3, 'M+', 'Audience reached' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo (int) $wu_st[0]; ?>"><?php echo (int) $wu_st[0]; ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
		<?php echo $wu_logo_strip( 'Client logos' ); // phpcs:ignore ?>
	</section>

	<div class="ev-ticker" aria-hidden="true"><div class="ev-ticker__track">
		<?php $wu_tk = ''; foreach ( array( 'Conferences', 'Product launches', 'Award nights', 'Exhibitions', 'Leadership summits', 'Dealer meets', 'Inaugurations', 'College fests', 'Trade shows', 'Weddings' ) as $t ) $wu_tk .= '<span>' . esc_html( $t ) . '</span><i></i>'; echo '<div>' . $wu_tk . '</div><div>' . $wu_tk . '</div>'; // phpcs:ignore ?>
	</div></div>

	<!-- 2. What is event branding? -->
	<section class="sec ev-sec" id="what">
		<div class="wrap ev-split">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Event branding' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">What is</span> <span class="sh__b">event branding?</span></h2>
			</div>
			<div class="ev-prose">
				<p class="ev-lead">Event branding is the identity of an event: its name, logo, colours, fonts and theme, and the signage that carries them. Event branding works when all of these act as one identity, so every touchpoint feels like the same event.</p>
				<h3>Branding for an event: how it differs from a company’s own brand identity</h3>
				<p>A company’s brand identity is built to last for years; branding for an event is built for one occasion. The event brand should echo the parent brand, in its colours, tone and logo, but still stand alone, with its own name and look.</p>
			</div>
		</div>
	</section>

	<!-- 3. Services: 9 cards, 2 lines each, link to a sub-page later -->
	<section class="sec ev-sec" id="services">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Our event branding</span> <span class="sh__b">services in Kerala</span></h2>
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

	<!-- 4. Corporate event branding services: event types, sector strip, sample deliverables checklist -->
	<section class="sec ev-sec" id="corporate">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Corporate' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Corporate event</span> <span class="sh__b">branding services</span></h2>
			</div>
			<div class="ev-corp">
				<div class="ev-panel">
					<h3>Event types</h3>
					<?php echo $wu_chips( array( 'Conferences', 'Leadership summits', 'Product launches', 'Award nights', 'Dealer and partner meets', 'AGMs', 'Trade shows' ) ); // phpcs:ignore ?>
					<h3>Sectors</h3>
					<?php echo $wu_chips( array( 'Healthcare', 'Education', 'Government', 'Startups', 'Retail', 'Tourism', 'Hospitality' ), true ); // phpcs:ignore ?>
					<p class="ev-note">Tourism and hospitality is a Kerala-specific strength.</p>
				</div>
				<div class="ev-panel ev-panel--list">
					<h3>Sample deliverables checklist for one event</h3>
					<?php echo $wu_check( array( 'Main backdrop', 'Entrance arch', 'Registration desk', 'Signage set', 'Badges', 'Presentation template', 'Social kit' ) ); // phpcs:ignore ?>
				</div>
			</div>
		</div>
	</section>

	<!-- 5. Our process: 6 steps in a visual timeline + typical timeline note -->
	<section class="sec ev-sec" id="process">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Our process</span></h2>
			</div>
			<ol class="ev-steps">
				<?php foreach ( array(
					array( 'Brief and discovery', 'We learn the event, the audience, the venue, the date and the goals, and visit the venue to measure.' ),
					array( 'Concept and creative direction', 'One clear idea for the event: a name, a theme and a visual direction, shown to you before any artwork.' ),
					array( 'Design system and templates', 'Logo, colours, fonts and master layouts that every banner, badge, slide and post follows.' ),
					array( 'Production-ready artwork and vendor coordination', 'Every file prepared with bleed, colour profile and exact dimensions, and the printers and fabricators coordinated.' ),
					array( 'On-site installation', 'Our team at the venue for set-up, checking that every piece goes up where it should.' ),
					array( 'Post-event assets', 'Photos, videos and social posts that keep the event working after the day.' ),
				) as $i => $s ) : ?>
				<li class="ev-step"><span class="ev-step__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
			<div class="ev-timeline">
				<div class="ev-timeline__num"><strong>14</strong><span>days</span></div>
				<div class="ev-timeline__txt">
					<p class="ev-timeline__k">Typical timeline</p>
					<p>Send us the brief at least 14 days before the event. That leaves time for the concept, your approvals, printing and installation.</p>
				</div>
				<ol class="ev-timeline__track" aria-hidden="true">
					<li><span>Brief</span></li><li><span>Concept</span></li><li><span>Approvals</span></li><li><span>Printing</span></li><li><span>Installation</span></li><li class="is-day"><span>Event day</span></li>
				</ol>
			</div>
		</div>
	</section>

	<!-- 6. Virtual and hybrid event branding -->
	<section class="sec ev-sec" id="virtual">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Virtual and hybrid' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Virtual and hybrid</span> <span class="sh__b">event branding</span></h2>
			</div>
			<div class="ev-three">
				<div class="ev-panel">
					<h3>How virtual branding differs from on-site</h3>
					<p>On-site, the branding lives on the stage, the walls and the signage. In virtual and hybrid event branding it lives on screen:</p>
					<?php echo $wu_chips( array( 'Platform lobby', 'Virtual backgrounds', 'Slides', 'Motion graphics', 'Lower-thirds', 'Branded joining pages' ), true ); // phpcs:ignore ?>
				</div>
				<div class="ev-panel">
					<h3>Hybrid branding</h3>
					<?php echo $wu_check( array( 'Physical and digital identities kept aligned', 'A branded entry experience for remote attendees', 'Kits sent to remote attendees' ) ); // phpcs:ignore ?>
				</div>
				<div class="ev-panel ev-panel--list">
					<h3>Deliverables</h3>
					<?php echo $wu_check( array( 'Virtual stage and lobby design', 'Branded webinar template', 'Social and email kit', 'LED and livestream overlay' ) ); // phpcs:ignore ?>
				</div>
			</div>
		</div>
	</section>

	<!-- 7. Why choose us: differentiators, each with evidence -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Why choose us</span></h2>
			</div>
			<ol class="ev-why">
				<li><span class="ev-why__n">01</span><h3>A Kerala-based team that can visit venues</h3><p>Our studio is at Govt. Cyberpark, Kozhikode, and our team visits venues across Kerala.</p></li>
				<li><span class="ev-why__n">02</span><h3>A print-ready file standard</h3><p>Every file is checked for bleed, colour profile and dimensions before it goes to print.</p></li>
				<li><span class="ev-why__n">03</span><h3>One team from concept to installation</h3><p>For Bootland Expo, one team did the brand strategy, visual identity, mascot, marketing assets and on-ground branding.</p></li>
				<li><span class="ev-why__n">04</span><h3>Pricing transparency</h3><p>Event branding starts from ₹25,000, and we list what affects the cost. <a class="ev-inline" href="#pricing">See pricing</a></p></li>
				<li><span class="ev-why__n">05</span><h3>Experience with local event types</h3><p>10+ events branded and clients in 100+ cities. <a class="ev-inline" href="#kerala">See events we brand across Kerala</a></p></li>
			</ol>
		</div>
	</section>

	<!-- 8. Events we brand across Kerala: cities and districts, Kerala-specific event types, venue familiarity -->
	<section class="sec ev-sec" id="kerala">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Kerala' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Events we brand</span> <span class="sh__b">across Kerala</span></h2>
			</div>
			<div class="ev-kl">
				<div class="ev-route">
					<div class="ev-route__head"><h3>Cities and districts</h3><span class="ev-route__dir" aria-hidden="true">North &rarr; South</span></div>
					<ol class="ev-route__list">
						<?php foreach ( array(
							array( 'Kannur', 'Inaugurations, dealer meets and community events in north Kerala.', false ),
							array( 'Kozhikode', 'Our studio is here, at Govt. Cyberpark, minutes from the city’s venues.', true ),
							array( 'Malappuram', 'Store launches, education events and Gulf-linked business meets.', false ),
							array( 'Thrissur', 'Festival, cultural and retail events in the cultural capital.', false ),
							array( 'Kochi', 'Conferences, product launches and trade expos in Kerala’s business hub.', false ),
							array( 'Thiruvananthapuram', 'Government events, summits and institutional programmes in the capital.', false ),
						) as $c ) : ?>
						<li class="ev-stop<?php echo $c[2] ? ' is-home' : ''; ?>">
							<span class="ev-stop__dot" aria-hidden="true"></span>
							<div><strong><?php echo esc_html( $c[0] ); ?></strong><?php if ( $c[2] ) : ?> <span class="ev-stop__pill">Our studio</span><?php endif; ?><p><?php echo esc_html( $c[1] ); ?></p></div>
						</li>
						<?php endforeach; ?>
						<li class="ev-stop ev-stop--more"><span class="ev-stop__dot" aria-hidden="true"></span><div><strong>And others</strong><p>Our team travels to venues across every district of Kerala.</p></div></li>
					</ol>
				</div>
				<div class="ev-kl__side">
					<div class="ev-panel">
						<h3>Kerala-specific event types</h3>
						<p>Kerala events have their own rhythm: inaugurations timed to auspicious dates, college fests with student crowds, trade fairs and Gulf-linked business expos that bring visitors from abroad, festival events and weddings.</p>
						<ul class="ev-types">
							<?php foreach ( array(
								array( 'Inaugurations', '<path d="M4 20h16M6 20V9l6-5 6 5v11"/><path d="M3 9h18" stroke-dasharray="2 2"/>' ),
								array( 'College fests', '<path d="M3 9.5 12 5l9 4.5-9 4.5z"/><path d="M7 11.5V16c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5v-4.5M21 9.5v5"/>' ),
								array( 'Trade fairs', '<path d="M3 9h18l-1.5-5h-15z"/><path d="M4.5 9v11h15V9M9 20v-6h6v6"/>' ),
								array( 'Gulf-linked business expos', '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18a14 14 0 0 1 0-18Z"/>' ),
								array( 'Cultural and festival events', '<path d="M12 3c2 3 5 4 5 8a5 5 0 0 1-10 0c0-4 3-5 5-8Z"/><path d="M12 21v-5"/>' ),
								array( 'Wedding and reception branding', '<path d="M12 20s-7-4.3-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.7-7 10-7 10Z"/>' ),
							) as $t ) : ?>
							<li><span class="ev-types__i"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $t[1]; // phpcs:ignore -- fixed markup ?></svg></span><?php echo esc_html( $t[0] ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="ev-panel ev-venue">
						<h3>Venue and vendor familiarity</h3>
						<ul class="ev-venue__list" aria-label="Venue types">
							<?php foreach ( array( 'Convention centres', 'Exhibition grounds', 'Hotel ballrooms', 'College auditoriums', 'Open-air grounds' ) as $v ) echo '<li>' . esc_html( $v ) . '</li>'; ?>
						</ul>
						<p>Each venue has its own sizes, rules and set-up windows. We measure the venue, work to its timings, and coordinate with the printers and fabricators who deliver to it.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 9. Pricing and what affects cost -->
	<section class="sec ev-sec" id="pricing">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Pricing' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Pricing and what</span> <span class="sh__b">affects cost</span></h2>
			</div>
			<div class="ev-ticket">
				<div class="ev-ticket__main"><span class="ev-ticket__k">Event branding</span><p class="ev-from"><span>Starting from</span> <strong>₹25,000</strong></p></div>
				<div class="ev-ticket__stub"><span>Admit</span><strong>One plan</strong><span>before the price</span></div>
			</div>
			<p class="ev-from__note">Every event is different, so we send a plan with the cost broken down before you commit. These are the things that move the price:</p>
			<ul class="ev-costs">
				<?php foreach ( array(
					array( 'Event scale', 'The number of guests, halls and days the branding has to cover.', 'One hall, one day', 'many halls, many days', 30, '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3.5 19c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5M14.5 14.2c2.6-.4 5 1.2 5.6 4.8"/>' ),
					array( 'Number of branded touchpoints', 'A backdrop and a few standees, or a fully branded venue.', 'A few pieces', 'a full venue', 45, '<rect x="3" y="4" width="7" height="7" rx="1.5"/><rect x="14" y="4" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>' ),
					array( 'Materials and fabrication', 'Flex and vinyl cost less than fabricated arches, built stalls or LED content.', 'Flex and vinyl', 'fabrication and LED', 60, '<path d="M12 3 3 8l9 5 9-5z"/><path d="m3 13 9 5 9-5"/>' ),
					array( 'Installation', 'Set-up crew, transport, venue timings and removal after the event.', 'Simple set-up', 'crew, transport and removal', 50, '<path d="M14.5 6.5a4 4 0 0 0-5.3 5.3L4 17l3 3 5.2-5.2a4 4 0 0 0 5.3-5.3l-2.6 2.6-2.6-.6-.6-2.6z"/>' ),
					array( 'Timeline', 'A comfortable lead time costs less than a rush job with overnight printing.', 'Comfortable lead time', 'a rush job', 70, '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l2.5 2.5M9.5 2.5h5"/>' ),
				) as $i => $c ) : ?>
				<li class="ev-cost" style="--lvl: <?php echo (int) $c[4]; ?>%">
					<div class="ev-cost__top">
						<span class="ev-ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $c[5]; // phpcs:ignore -- fixed markup ?></svg></span>
						<span class="ev-cost__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					</div>
					<h3><?php echo esc_html( $c[0] ); ?></h3>
					<p><?php echo esc_html( $c[1] ); ?></p>
					<div class="ev-meter">
						<div class="ev-meter__row" aria-hidden="true"><span>₹</span><div class="ev-meter__bar"><span></span></div><span>₹₹₹</span></div>
						<p class="ev-meter__up">Costs more with: <strong><?php echo esc_html( $c[3] ); ?></strong></p>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 10. Portfolio and case studies: client type, challenge, what we branded, result; photos; testimonials and client logos -->
	<section class="sec ev-sec" id="work">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Portfolio' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Portfolio and</span> <span class="sh__b">case studies</span></h2>
			</div>
			<div class="ev-cases">
				<?php foreach ( $wu_cases as $c ) : ?>
				<article class="ev-case">
					<a class="ev-case__img" href="<?php echo esc_url( $c['url'] ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo esc_url( $c['img'] ); ?>" alt="" loading="lazy" decoding="async"></a>
					<div class="ev-case__body">
						<h3><a href="<?php echo esc_url( $c['url'] ); ?>"><?php echo esc_html( $c['name'] ); ?></a></h3>
						<dl class="ev-case__dl">
							<div><dt>Client type</dt><dd><?php echo esc_html( $c['type'] ); ?></dd></div>
							<div><dt>Challenge</dt><dd><?php echo esc_html( $c['problem'] ); ?></dd></div>
							<div><dt>What we branded</dt><dd><?php echo esc_html( $c['did'] ); ?></dd></div>
							<div><dt>Result</dt><dd><ul class="ev-case__stats"><?php foreach ( $c['stats'] as $st ) : ?><li><strong><?php echo esc_html( $st[0] ); ?></strong><span><?php echo esc_html( $st[1] ); ?></span></li><?php endforeach; ?></ul></dd></div>
						</dl>
						<a class="ev-more" href="<?php echo esc_url( $c['url'] ); ?>">View case study <?php echo $wu_ne; // phpcs:ignore ?></a>
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

	<!-- 11. How to choose an event branding agency: checklist + questions to ask any agency, including us -->
	<section class="sec ev-sec" id="choose">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Choosing an agency' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">How to choose an</span> <span class="sh__b">event branding agency</span></h2>
			</div>
			<p class="ev-choose__intro">Use this checklist with any agency you talk to, including us. Each point comes with the question to ask.</p>
			<ol class="ev-choose">
				<?php foreach ( array(
					array( 'Portfolio relevance', 'Ask for events like yours, at a similar scale, with photos of the real installations.', 'Can we see events you have branded that are like ours?' ),
					array( 'Production capability', 'Check whether they print, fabricate and install, or only send design files.', 'Do you handle printing and installation yourselves?' ),
					array( 'Turnaround', 'Ask how many days before the event they need the brief.', 'How many days before the event do you need the brief?' ),
					array( 'Support on event day', 'Ask who from their team will be at the venue during set-up and on the day.', 'Will your team be at the venue on event day?' ),
					array( 'Clarity on what is included', 'Make sure the quote lists design, print, transport, installation and removal.', 'What exactly is included in the price?' ),
				) as $i => $c ) : ?>
				<li class="ev-chk">
					<div class="ev-chk__top">
						<span class="ev-chk__box" aria-hidden="true"><?php echo $wu_tick; // phpcs:ignore ?></span>
						<span class="ev-chk__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					</div>
					<h3><?php echo esc_html( $c[0] ); ?></h3>
					<p><?php echo esc_html( $c[1] ); ?></p>
					<p class="ev-chk__ask"><span>Ask</span><?php echo esc_html( $c[2] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 12. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="ev-faq-h">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="ev-faq-h" class="sh__h"><span class="sh__a">FAQ</span></h2>
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
					<h2 class="sh__h"><span class="sh__a">Tell us about</span> <span class="sh__b">your event</span></h2>
					<div class="ev-contact">
						<a class="ev-ct ev-ct--wa" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener">
							<span class="ev-ct__i"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.27-.2-.57-.35Zm-5.42 7.4h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.89 9.88Zm8.41-18.3A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.69 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.48-8.41Z"/></svg></span>
							<span class="ev-ct__t"><small>WhatsApp</small>+91 62824 34503</span>
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
					<label><span>Date</span><input name="date" type="date"></label>
					<label class="ev-form__wide"><span>City</span><input name="city" autocomplete="address-level2"></label>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Send enquiry</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
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
		var to = +el.getAttribute('data-count'), t0 = performance.now();
		(function step(t) { var k = Math.min(1, (t - t0) / 1400); el.textContent = Math.round(to * (1 - Math.pow(1 - k, 3))); if (k < 1) requestAnimationFrame(step); })(t0);
	});
	// process line fills with scroll
	var steps = document.querySelector('.wu-ev .ev-steps'), raf = 0;
	function fill() { raf = 0; if (!steps) return; var r = steps.getBoundingClientRect(); steps.style.setProperty('--p', Math.max(0, Math.min(1, (innerHeight * .75 - r.top) / Math.max(1, r.height + innerHeight * .2))).toFixed(3)); }
	addEventListener('scroll', function () { if (!raf) raf = requestAnimationFrame(fill); }, { passive: true }); fill();
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
	document.querySelectorAll('.wu-ev :is(.ev-card, .ev-step, .ev-why li, .ev-case, .ev-panel, .ev-chk, .ev-quotes, .ev-cost)').forEach(function (el, i) {
		if (el.getBoundingClientRect().top > innerHeight) { el.classList.add('ev-rise'); el.style.setProperty('--d', (i % 3) * 70 + 'ms'); io.observe(el); }
	});
})();
</script>
<?php
$wu_lead_source = 'event-branding';
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( 'event-branding' );
