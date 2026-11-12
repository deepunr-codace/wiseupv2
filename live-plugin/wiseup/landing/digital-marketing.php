<?php
/**
 * Digital marketing company page, one file for two markets (owner brief: Downloads/digital marketing company.docx,
 * 2026-11-12: keywords "digital marketing company in kerala" and "... in australia" with competitor outlines, no copy).
 *  - "WiseUp: Digital Marketing (Kerala)"    = template key wiseup-digital-marketing
 *  - "WiseUp: Digital Marketing (Australia)" = template key wiseup-digital-marketing-au
 * Copy is written for WiseUp; every figure is one the site already publishes (wiseup_cs_stats(), 120+ projects,
 * 3M+ audience, CodeAce's eight years). No price is published: the offer is the plan before the price.
 * Design system: the Event Branding page's (assets/css/event-branding.css + assets/js/event-branding.js, scoped to
 * .wu-ev) plus this page's own blocks in assets/css/digital-marketing.css.
 */
defined( 'ABSPATH' ) || exit;

$wu_au  = 'wiseup-digital-marketing-au' === get_page_template_slug( get_queried_object_id() );
$wu_src = $wu_au ? 'digital-marketing-au' : 'digital-marketing';

$wu_m = $wu_au ? array(
	'title'   => 'Digital Marketing Agency in Australia | SEO, Ads, Social & Web | WiseUp',
	'desc'    => 'Digital marketing agency for Australian businesses: SEO and AEO, Google and Meta ads, social media, content and websites from one team. See the plan before you see a price.',
	'eyebrow' => 'Digital marketing · Australia',
	'h1a'     => 'Digital Marketing Agency in Australia',
	'h1b'     => 'That Shows You the Plan First',
	'lede'    => 'Search, ads, social, content and your website should pull in one direction. WiseUp plans and runs all of them as one team for businesses in Sydney, Melbourne, Brisbane, Perth and beyond, and you see the strategy before you see a number.',
	'wa'      => 'Hi WiseUp, I run a business in Australia and would like a digital marketing plan.',
	'city'    => 'City or state',
) : array(
	'title'   => 'Digital Marketing Company in Kerala | SEO, Ads, Social & Web | WiseUp',
	'desc'    => 'WiseUp is a digital marketing company in Kerala for SEO and AEO, Google and Meta ads, social media, content and websites. One team, one plan, and you see the plan before the price.',
	'eyebrow' => 'Digital marketing · Kerala',
	'h1a'     => 'Digital Marketing Company in Kerala',
	'h1b'     => 'That Shows You the Plan First',
	'lede'    => 'Search, ads, social, content and your website should pull in one direction. WiseUp plans and runs all of them as one team from our studio in Kozhikode, and you see the strategy before you see a number.',
	'wa'      => 'Hi WiseUp, I would like a digital marketing plan for my business.',
	'city'    => 'City',
);

$wu_title = apply_filters( 'wiseup_landing_title', $wu_m['title'] );
$wu_desc  = apply_filters( 'wiseup_landing_description', $wu_m['desc'] );
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
	foreach ( array( 'event-branding.css', 'digital-marketing.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/' . $css . '?ver=' . filemtime( WISEUP_DIR . 'assets/css/' . $css ) ) . "\">\n";
	}
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( $wu_m['wa'] );
$wu_arrow = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg>';
$wu_ne    = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>';
$wu_tick  = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12.5 4.5 4.5L19 7"/></svg>';
$wu_btn   = function ( $label, $look = 'teal', $attrs = '' ) use ( $wu_arrow ) {
	$tag = false !== strpos( $attrs, 'href=' ) ? 'a' : 'button';
	return '<' . $tag . ( 'button' === $tag ? ' type="button"' : '' ) . ' class="b b--' . $look . '" ' . $attrs . '><span class="b__label">' . esc_html( $label ) . '</span><span class="b__ico">' . $wu_arrow . $wu_arrow . '</span></' . $tag . '>';
};
$wu_lead    = 'data-lead-open data-lead-source="' . esc_attr( $wu_src ) . '"';
$wu_eyebrow = function ( $t ) { return '<p class="eyebrow"><span class="eyebrow__dot" aria-hidden="true"></span>' . esc_html( $t ) . '</p>'; };
$wu_check   = function ( $items ) use ( $wu_tick ) {
	$o = '<ul class="ev-check">';
	foreach ( $items as $t ) $o .= '<li><span class="ev-check__t">' . $wu_tick . '</span>' . esc_html( $t ) . '</li>';
	return $o . '</ul>';
};
$wu_svg = function ( $paths, $size = 22, $sw = 1.6 ) {
	return '<svg width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . esc_attr( $sw ) . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths . '</svg>';
};

// Client logos: the homepage strip's logo set (same files and alt text as the Event Branding page).
$wu_logos = array( 'amarapushpa' => 'Amarapushpa', 'bm-prime' => 'BM Prime', 'bucho' => 'Bucho', 'cadd' => 'CADD', 'cellar-de-mahe' => 'Cellar de mahe', 'clair-veda' => 'Clair veda', 'eduwizz' => 'Eduwizz', 'ellisto' => 'Ellisto', 'erets' => 'Erets', 'flora-fauna' => 'Flora fauna', 'formaa' => 'Formaa', 'gloveda' => 'Gloveda', 'goldekarak' => 'Golden Karak', 'hayath' => 'Hayath', 'intervel' => 'Intervel', 'lullaby' => 'Lullaby', 'lunar' => 'Lunar', 'mgf' => 'MGF', 'mooss' => 'mooss', 'onesto-marcado' => 'Onesto Marcado', 'philips' => 'Philips', 'popees' => 'Popees', 'sathya' => 'Sathya', 'superhuman' => 'Superhuman', 'tiny-mafia' => 'Tiny Mafia', 'wellah' => 'Wellah' );
$wu_li    = '';
foreach ( $wu_logos as $f => $alt ) $wu_li .= '<li class="is-tile"><img src="' . esc_url( WISEUP_ASSETS . '/clients/client-logos-2026/' . $f . '.webp' ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async"></li>';

$wu_icons = array(
	'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2M8.5 11h5M11 8.5v5"/>',
	'target' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/>',
	'chat'   => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'brush'  => '<path d="M14.5 4.5 19.5 9.5 11 18l-5-5z"/><path d="M6 13c-2 0-3 1.5-3 3.5S2 20 2 20s4 .5 5.5-1 1.5-3.5.5-5"/>',
	'video'  => '<rect x="3" y="6" width="13" height="12" rx="2"/><path d="m16 10.5 5-3v9l-5-3"/>',
	'code'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 8h18M9.5 12 7.5 14l2 2M14.5 12l2 2-2 2"/>',
	'cup'    => '<path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5z"/><path d="M17 10.5h1.5a2.5 2.5 0 0 1 0 5H17M8 3.5c0 1.5 1.5 1.5 1.5 3M12 3.5c0 1.5 1.5 1.5 1.5 3"/>',
	'bag'    => '<path d="M5 8h14l-1 12H6z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/>',
	'stall'  => '<path d="M3 9h18l-1.5-5h-15z"/><path d="M4.5 9v11h15V9M9 20v-6h6v6"/>',
	'car'    => '<path d="M5 16V11.5L7 6.5h10l2 5V16"/><path d="M3.5 16h17M5 11.5h14"/><circle cx="8" cy="16.5" r="1.8"/><circle cx="16" cy="16.5" r="1.8"/>',
	'rocket' => '<path d="M12 3c3 2 4.5 5 4.5 9L12 16.5 7.5 12C7.5 8 9 5 12 3z"/><circle cx="12" cy="9.5" r="1.6"/><path d="M7.5 12 5 14.5l2.5 1M16.5 12l2.5 2.5-2.5 1M10.5 17.5 12 21l1.5-3.5"/>',
	'health' => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.4 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/><path d="M9.5 12h5M12 9.5v5"/>',
	'cap'    => '<path d="m2.5 9.5 9.5-5 9.5 5-9.5 5z"/><path d="M6.5 11.6V16c1.5 1.6 3.4 2.4 5.5 2.4s4-.8 5.5-2.4v-4.4M21.5 9.5v5"/>',
	'bolt'   => '<path d="M13 3 5 13.5h6L10 21l8-10.5h-6z"/>',
	'ear'    => '<path d="M7 9.5a5 5 0 0 1 10 0c0 3-2.5 3.5-3 6s-1.5 4-3.5 4-3-1.5-3-3"/><path d="M10 9.5a2 2 0 0 1 4 0"/>',
	'map'    => '<path d="M3 6.5 9 4l6 2.5 6-2.5v13.5L15 20l-6-2.5L3 20z"/><path d="M9 4v13.5M15 6.5V20"/>',
	'play'   => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5z"/>',
	'chart'  => '<path d="M4 20V4M4 20h16"/><path d="m7.5 15 4-4.5 3 3L20 7"/>',
	'team'   => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3 20c.5-3.2 3-5 6-5s5.5 1.8 6 5M15 15.5c2.6 0 4.6 1.4 5 4.5"/>',
	'tag'    => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
);

// Sub-page of a service, when a published page uses that template (same lookup as the Services page).
$wu_page_for = function ( $template ) {
	$ids = get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'meta_key' => '_wp_page_template', 'meta_value' => $template, 'posts_per_page' => 1, 'fields' => 'ids' ) ); // phpcs:ignore
	return $ids ? get_permalink( $ids[0] ) : '';
};
$wu_smm = $wu_page_for( 'wiseup-social-media' );

$wu_services = array(
	array( 'SEO, AEO and Local Search', 'search', 'Rank on Google and show up in the answers people now get from ChatGPT, Gemini, Perplexity and Google’s AI Overviews. Technical fixes, content that answers real questions, and local search for the areas you serve.', array( 'Technical SEO', 'Content', 'AI answers', 'Local search' ), $wu_au ? '' : $wu_page_for( 'wiseup-seo' ) ),
	array( 'Performance Marketing', 'target', 'Google and Meta campaigns built around one number you care about: enquiries, sales or bookings. Budgets move toward what works, and the reporting shows where every rupee or dollar went.', array( 'Google Ads', 'Meta Ads', 'Retargeting', 'Landing pages' ), $wu_au ? '' : $wu_page_for( 'wiseup-performance' ) ),
	array( 'Social Media Marketing', 'chat', 'Content calendars, reels, carousels and community management for Instagram, Facebook, LinkedIn and YouTube. Planned around what your audience stops for, not around posting every day for the sake of it.', array( 'Reels', 'Content calendar', 'Influencers', 'Community' ), $wu_au ? '' : ( $wu_smm ? $wu_smm : 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/' ) ),
	array( 'Branding and Creative', 'brush', 'Brand identity, campaign ideas and the design system that keeps every ad, post and page recognisably yours. Creative is made in-house, so it is planned with the media, not handed over at the end.', array( 'Identity', 'Campaign ideas', 'Ad creative', 'Packaging' ), '' ),
	array( 'Video and Content Production', 'video', 'Reels, ad films, product shoots and long-form video from our own studio team. We run a YouTube podcast with 91K+ subscribers, so we make video for attention, not just for the brief.', array( 'Reels', 'Ad films', 'Photography', 'Podcasts' ), '' ),
	array( 'Websites and Ecommerce', 'code', 'Fast websites, landing pages and online stores built with CodeAce, our parent company and its eight years of web engineering. Built to rank, load quickly and turn visits into enquiries.', array( 'Websites', 'Ecommerce', 'Landing pages', 'Analytics setup' ), '' ),
);

$wu_industries = array(
	array( 'Restaurants and cafés', 'cup', 'Smoke House, Golden Karak' ),
	array( 'Retail and consumer brands', 'bag', 'Sathya Agencies, Popees, Amarapushpa' ),
	array( 'Events and exhibitions', 'stall', 'Bootland Expo, MGF' ),
	array( 'Travel and mobility', 'car', 'IndusGo self-drive rentals' ),
	array( 'Technology', 'rocket', 'Erets Space' ),
	array( 'Healthcare', 'health', 'Hayath' ),
	array( 'Education and training', 'cap', 'CADD, Eduwizz' ),
	array( 'Energy', 'bolt', 'Eallisto' ),
);

// Results: the homepage's hover figures (wiseup_cs_stats()), each linked to its case study.
$wu_stats   = function_exists( 'wiseup_cs_stats' ) ? wiseup_cs_stats() : array();
$wu_results = array(
	array( 'golden-karak', 'Golden Karak', 'Café brand · social media', WISEUP_URL . 'assets/landing/img/case-karak.jpg' ),
	array( 'bootland', 'Bootland Expo 2026', 'Footwear expo · event marketing', WISEUP_URL . 'assets/landing/img/case-bootland.jpg' ),
	array( 'sathya-agencies-brand-launch-campaign-kerala', 'Sathya Agencies', 'Brand launch campaign', WISEUP_URL . 'assets/work/case-sathya-720.webp' ),
	array( 'erets', 'Erets Space', 'Space technology · launch', WISEUP_URL . 'assets/landing/img/case-erets.jpg' ),
	array( 'indusgo', 'IndusGo', 'Self-drive rentals · video', WISEUP_URL . 'assets/landing/img/case-indusgo.jpg' ),
);

$wu_faq = array(
	array( 'What does a digital marketing company do?', 'A digital marketing company plans and runs the ways customers find and choose you online: search (SEO and AEO), paid ads on Google and Meta, social media, content and video, and the website those channels send people to. At WiseUp, all of these sit with one team, so every channel follows the same plan.' ),
	$wu_au
		? array( 'How much does digital marketing cost for an Australian business?', 'It depends on the channels you need, how much content we produce each month, your ad budget and how fast you want to move. We do not publish one package price for that reason. You see the plan first, then a quote that shows what each part covers. Your ad budget goes to Google and Meta; our fee covers planning, creative and management, and a good quote shows the two separately.' )
		: array( 'How much does digital marketing cost in Kerala?', 'It depends on the channels you need, how much content we produce each month, your ad budget and how fast you want to move. We do not publish one package price for that reason. You see the plan first, then a quote that shows what each part covers. Your ad budget goes to Google and Meta; our fee covers planning, creative and management, and a good quote shows the two separately.' ),
	array( 'How long does it take to see results?', 'Paid campaigns can bring enquiries within weeks of going live. SEO builds more slowly and usually takes a few months to show steady growth. We agree what to measure at the start, so you can follow progress in your own analytics and ad accounts.' ),
	$wu_au
		? array( 'Can a team in India work well for an Australian business?', 'Yes. Our working morning in Kozhikode is your afternoon on the east coast and around midday in Perth, so calls and approvals happen within the same working day. Before we plan, we research your city’s search demand and competitors, because results in Sydney and Perth are not the same market.' )
		: array( 'Do you work with businesses outside Kozhikode?', 'Yes. Our studio is in Kozhikode, and we work with businesses across Kerala, including Kochi, Thrissur, Kannur, Malappuram, Alappuzha, Kollam and Thiruvananthapuram. Our work runs from local cafés to Erets, a space technology launch with partners on three continents.' ),
	array( 'What is AEO, and do you offer it?', 'AEO, or answer engine optimisation, helps your business appear in the answers people get from ChatGPT, Gemini, Perplexity and Google’s AI Overviews. It is part of our SEO work: clear pages that answer real questions, structured data, and a consistent presence across the sources those tools read.' ),
	array( 'Do you also build websites?', 'Yes. Websites, landing pages and online stores are built with CodeAce, our parent company, which has eight years of web engineering behind it. Because the same group runs your marketing, the site is built for search and conversions from day one.' ),
	array( 'What do you need from us to get started?', 'A short conversation is enough: what you sell, who buys it, what you have tried so far and what you want to grow. From there we prepare a plan for you to review before any price is discussed.' ),
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
	<section class="ev-hero dm-hero">
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<?php echo $wu_eyebrow( $wu_m['eyebrow'] ); // phpcs:ignore ?>
				<h1 class="ev-hero__h"><span class="sh__a"><?php echo esc_html( $wu_m['h1a'] ); ?></span> <span class="sh__b"><?php echo esc_html( $wu_m['h1b'] ); ?></span></h1>
				<p class="ev-hero__p"><?php echo esc_html( $wu_m['lede'] ); ?></p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Get our plan', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'Chat on WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-stage dm-plan" aria-hidden="true" data-stage>
				<div class="dm-plan__card">
					<div class="dm-plan__top"><span class="dm-plan__dot"></span><span>Growth plan</span><em>Draft 01</em></div>
					<p class="dm-plan__for">Prepared for <strong>your business</strong></p>
					<ul class="dm-plan__rows">
						<?php foreach ( array(
							array( 'search', 'Search', 'SEO + AI answers', '.84' ),
							array( 'target', 'Paid ads', 'Google + Meta', '.66' ),
							array( 'chat', 'Social', 'Reels + content', '.92' ),
							array( 'code', 'Website', 'Landing pages', '.54' ),
						) as $wu_i => $r ) : ?>
						<li style="--w:<?php echo esc_attr( $r[3] ); ?>;--i:<?php echo (int) $wu_i; ?>"><span class="dm-plan__ic"><?php echo $wu_svg( $wu_icons[ $r[0] ], 18, 1.7 ); // phpcs:ignore ?></span><span class="dm-plan__lab"><?php echo esc_html( $r[1] ); ?><small><?php echo esc_html( $r[2] ); ?></small></span><span class="dm-plan__bar"><i></i></span></li>
						<?php endforeach; ?>
					</ul>
					<div class="dm-plan__chart">
						<span class="dm-plan__k">Enquiries</span>
						<svg viewBox="0 0 320 96" preserveAspectRatio="none"><defs><linearGradient id="dm-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#c2f760" stop-opacity=".32"/><stop offset="1" stop-color="#c2f760" stop-opacity="0"/></linearGradient></defs><path class="dm-plan__area" d="M0 84 C40 82 60 76 90 70 S140 66 170 52 S230 40 260 26 S300 12 320 8 V96 H0z"/><path class="dm-plan__line" pathLength="1" d="M0 84 C40 82 60 76 90 70 S140 66 170 52 S230 40 260 26 S300 12 320 8"/></svg>
					</div>
					<div class="dm-plan__foot"><span>Plan first</span><span class="dm-plan__arr"><?php echo $wu_arrow; // phpcs:ignore ?></span><span>Price after</span></div>
				</div>
			</div>
			<dl class="ev-proof">
				<?php foreach ( array(
					array( '120', '+', 'Projects delivered' ),
					array( '3', 'M+', 'Audience reached' ),
					array( '21.6', 'M+', 'Impressions for one launch' ),
					array( '8', '', 'Years of CodeAce engineering' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
		<div class="logos ev-logos" role="region" aria-label="Client logos"><div class="logos__marquee"><div class="logos__row"><div class="logos__track"><ul><?php echo $wu_li; // phpcs:ignore ?></ul><ul aria-hidden="true"><?php echo str_replace( '" alt="', '" alt="" data-alt="', $wu_li ); // phpcs:ignore ?></ul></div></div></div></div>
	</section>

	<div class="ev-ticker" aria-hidden="true"><div class="ev-ticker__track">
		<?php $wu_tk = ''; foreach ( array( 'SEO', 'AI answers', 'Google Ads', 'Meta Ads', 'Instagram', 'YouTube', 'LinkedIn', 'Reels', 'Content', 'Websites', 'Ecommerce', 'Branding' ) as $t ) $wu_tk .= '<span>' . esc_html( $t ) . '</span><i></i>'; echo '<div>' . $wu_tk . '</div><div>' . $wu_tk . '</div>'; // phpcs:ignore ?>
	</div></div>

	<!-- 2. One connected partner -->
	<section class="sec ev-sec" id="partner">
		<div class="wrap dm-split">
			<div class="sh">
				<?php echo $wu_eyebrow( 'One partner' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Marketing, Creative and Technology</span> <span class="sh__b">Under One Roof</span></h2>
			</div>
			<div class="dm-prose">
				<p class="ev-lead">WiseUp is the branding and digital marketing wing of CodeAce, a web engineering company with eight years behind it. The people who plan your campaigns work beside the people who make your creative and the engineers who build your website.</p>
				<h3>Why that matters</h3>
				<p>When search, ads, social and the website sit with different vendors, each one looks after its own number. One team can see the whole path a customer takes: the search that found you, the ad that brought them back, the page where they finally got in touch. That is where most of the wasted budget hides, and where most of the gains are.</p>
			</div>
			<ul class="dm-trio">
				<li><span class="dm-trio__n">01</span><strong>Marketing</strong><span>SEO, AEO, paid ads and social, planned as one campaign.</span></li>
				<li><span class="dm-trio__n">02</span><strong>Creative</strong><span>Brand, design, video and content from our own studio.</span></li>
				<li><span class="dm-trio__n">03</span><strong>Technology</strong><span>Websites, stores and tracking built with CodeAce.</span></li>
			</ul>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="services">
		<div class="wrap">
			<div class="ev-head ev-head--center">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Digital Marketing Services</span> <span class="sh__b">That Work as One Plan</span></h2>
				</div>
				<div class="ev-intro"><p>Most businesses do not need every channel at once. They need the right two or three, run well and connected to each other. These are the services we plan from, and the plan decides which ones you actually need.</p></div>
			</div>
			<ul class="ev-cards">
				<?php foreach ( $wu_services as $s ) : ?>
				<li class="ev-card">
					<span class="ev-ico"><?php echo $wu_svg( $wu_icons[ $s[1] ] ); // phpcs:ignore -- fixed markup ?></span>
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<p><?php echo esc_html( $s[2] ); ?></p>
					<ul class="dm-tags"><?php foreach ( $s[3] as $t ) echo '<li>' . esc_html( $t ) . '</li>'; ?></ul>
					<?php if ( $s[4] ) : ?><a class="ev-more" href="<?php echo esc_url( $s[4] ); ?>">Learn more <?php echo $wu_ne; // phpcs:ignore ?></a><?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 4. Local search: Kerala cities on the dot map / Australian cities with live local time -->
	<section class="sec ev-sec" id="local">
		<div class="wrap">
		<?php if ( $wu_au ) : ?>
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Local search' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Digital Marketing Across</span> <span class="sh__b">Sydney, Melbourne, Brisbane &amp; Perth</span></h2>
				</div>
				<div class="ev-intro"><p>Search results change from city to city, and so does the competition. We plan local SEO and location-targeted Google and Meta campaigns city by city, and we research each market’s search demand and competitors before we recommend a budget.</p></div>
			</div>
			<ul class="dm-cities" data-tz>
				<li class="dm-city is-home" data-zone="Asia/Kolkata"><span class="dm-city__k">Our studio</span><strong>Kozhikode</strong><span class="dm-city__s">Kerala, India</span><span class="dm-city__t" data-time>&nbsp;</span><span class="dm-city__o">IST</span></li>
				<?php foreach ( array( array( 'Sydney', 'New South Wales', 'Australia/Sydney' ), array( 'Melbourne', 'Victoria', 'Australia/Melbourne' ), array( 'Brisbane', 'Queensland', 'Australia/Brisbane' ), array( 'Perth', 'Western Australia', 'Australia/Perth' ) ) as $c ) : ?>
				<li class="dm-city" data-zone="<?php echo esc_attr( $c[2] ); ?>"><span class="dm-city__k">Local time</span><strong><?php echo esc_html( $c[0] ); ?></strong><span class="dm-city__s"><?php echo esc_html( $c[1] ); ?></span><span class="dm-city__t" data-time>&nbsp;</span><span class="dm-city__o" data-off>&nbsp;</span></li>
				<?php endforeach; ?>
			</ul>
			<div class="ev-panel dm-overlap">
				<span class="dm-overlap__i"><?php echo $wu_svg( '<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>', 26 ); // phpcs:ignore ?></span>
				<div>
					<h3>Our morning is your afternoon</h3>
					<p>We work remotely from Kozhikode, India. Our working morning lands in your afternoon on the east coast and around midday in Perth, so calls, approvals and campaign changes happen within the same working day. We also take on businesses in Adelaide, Canberra, Hobart and regional Australia.</p>
				</div>
			</div>
		<?php else : ?>
			<div class="sh">
				<?php echo $wu_eyebrow( 'Local search' ); // phpcs:ignore ?>
				<h2 class="sh__h"><span class="sh__a">Digital Marketing Across Kerala,</span> <span class="sh__b">From Our Studio in Kozhikode</span></h2>
			</div>
			<div class="ev-kl">
				<div class="ev-route">
					<div class="ev-route__head"><h3>Cities We Work In</h3><span class="ev-route__dir" aria-hidden="true">North &rarr; South</span></div>
					<p class="ev-route__lead">We run campaigns for businesses across the state, including:</p>
					<ol class="ev-route__list">
						<?php foreach ( array( array( 'Kannur', false ), array( 'Kozhikode', true ), array( 'Malappuram', false ), array( 'Thrissur', false ), array( 'Kochi', false ), array( 'Alappuzha', false ), array( 'Kollam', false ), array( 'Thiruvananthapuram', false ) ) as $wu_ci => $c ) : ?>
						<li class="ev-stop<?php echo $c[1] ? ' is-home' : ''; ?>" data-ev-city="<?php echo (int) $wu_ci; ?>">
							<span class="ev-stop__dot" aria-hidden="true"></span>
							<div><strong><?php echo esc_html( $c[0] ); ?></strong><?php if ( $c[1] ) : ?> <span class="ev-stop__pill">Our studio</span><?php endif; ?></div>
						</li>
						<?php endforeach; ?>
						<li class="ev-stop ev-stop--more"><span class="ev-stop__dot" aria-hidden="true"></span><div><p>And businesses in every other district, since most of the work happens online.</p></div></li>
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
						<p class="ev-lead">Someone in Kochi searching for a service sees different businesses from someone in Kannur. We plan local SEO, Google Business Profiles and location-targeted ads city by city, in English and Malayalam where your customers search in it.</p>
					</div>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</section>

	<!-- 5. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Marketing Shaped</span> <span class="sh__b">for Your Industry</span></h2>
				</div>
				<div class="ev-intro"><p>A café fills tables on a Friday night; a B2B expo needs registrations three months out. The channels can look the same, but the plan behind them is not. These are sectors we have already worked in, with a few of the brands.</p></div>
			</div>
			<ul class="dm-ind">
				<?php foreach ( $wu_industries as $wu_i => $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_svg( $wu_icons[ $ind[1] ], 22 ); // phpcs:ignore ?></span><span class="dm-ind__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong><span class="dm-ind__c"><?php echo esc_html( $ind[2] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. Results -->
	<section class="sec ev-sec" id="results">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Results' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Real Campaigns,</span> <span class="sh__b">Real Numbers</span></h2>
				</div>
				<div class="ev-intro"><p>Figures from campaigns we have run, as published in each case study. Open any project for the full story: the problem, what we did and what changed.</p></div>
			</div>
			<ul class="dm-res">
				<?php foreach ( $wu_results as $wu_i => $r ) :
					if ( empty( $wu_stats[ $r[0] ] ) ) continue;
					$st  = $wu_stats[ $r[0] ];
					$url = home_url( '/case-studies/' . $r[0] . '/' ); ?>
				<li class="dm-res__card<?php echo 0 === $wu_i ? ' is-big' : ''; ?>">
					<a class="dm-res__link" href="<?php echo esc_url( $url ); ?>">
						<span class="dm-res__img"><img src="<?php echo esc_url( $r[3] ); ?>" alt="<?php echo esc_attr( $r[1] . ' case study by WiseUp' ); ?>" loading="lazy" decoding="async"></span>
						<span class="dm-res__body">
							<span class="dm-res__type"><?php echo esc_html( $r[2] ); ?></span>
							<strong class="dm-res__name"><?php echo esc_html( $r[1] ); ?></strong>
							<span class="dm-res__fig"><b><?php echo esc_html( $st[0] ); ?></b><span><?php echo esc_html( $st[1] ); ?></span></span>
							<?php if ( ! empty( $st[2] ) ) : ?><span class="dm-res__mini"><?php foreach ( $st[2] as $mi ) echo '<span><b>' . esc_html( $mi[0] ) . '</b>' . esc_html( $mi[1] ) . '</span>'; ?></span><?php endif; ?>
							<span class="dm-res__go">View case study <?php echo $wu_ne; // phpcs:ignore ?></span>
						</span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 7. Process -->
	<section class="sec ev-sec" id="process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">From Your Market</span> <span class="sh__b">to Measurable Growth</span></h2>
				</div>
				<div class="ev-intro"><p>Four steps, in the same order every time. The second one is why clients trust the rest: you see the full strategy before we talk about a fee.</p><div class="ev-intro__btn"><?php echo $wu_btn( 'Get our plan', 'teal', $wu_lead ); // phpcs:ignore ?></div></div>
			</div>
			<ol class="ev-tsteps dm-steps">
				<?php foreach ( array(
					array( 'ear', 'Listen first', 'We learn your business, your customers and what you have tried, before we suggest a single channel.' ),
					array( 'map', 'Plan before we price', 'You see the strategy: which channels, what each one is for and what we will measure. Then the quote.' ),
					array( 'play', 'Execute with intent', 'Every ad, post and page has a job. If it does not serve a purpose, we do not make it.' ),
					array( 'chart', 'Measure and improve', 'We watch what works, move budget and effort toward it, and report in plain language.' ),
				) as $wu_i => $s ) : ?>
				<li class="ev-step ev-tstep"><span class="ev-tstep__i"><?php echo $wu_svg( $wu_icons[ $s[0] ], 34, 1.5 ); // phpcs:ignore ?></span><span class="ev-tstep__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><h3><?php echo esc_html( $s[1] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 8. Why WiseUp -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="ev-head ev-head--center">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">Why Businesses Choose</span> <span class="sh__b">WiseUp for Digital Marketing</span></h2>
				</div>
				<div class="ev-intro"><p>There are many agencies that can run ads. These are the reasons clients give for staying with us.</p></div>
			</div>
			<ul class="ev-exp" data-ev-exp>
				<?php foreach ( array(
					array( 'team', 'One team for every channel', 'Search, ads, social, content, video and the website are planned together, so no channel works against another.' ),
					array( 'map', 'The plan before the price', 'You see the strategy first and decide with it in hand. No package picked from a menu.' ),
					array( 'video', 'Creative made in-house', 'Our own studio makes the reels, shoots and ad films, and our YouTube podcast has grown to 91K+ subscribers.' ),
					array( 'code', 'Engineering from CodeAce', 'Websites, stores and tracking are built by our parent company, with eight years of web engineering.' ),
					array( 'chart', 'Numbers you can check', 'We agree what to measure at the start and track it in your own analytics and ad accounts.' ),
				) as $wu_i => $w ) : ?>
				<li class="ev-exp__card<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" tabindex="0"><span class="ev-exp__i"><?php echo $wu_svg( $wu_icons[ $w[0] ], 26 ); // phpcs:ignore ?></span><span class="ev-exp__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 9. Pricing: the plan before the price -->
	<section class="sec ev-sec" id="pricing">
		<div class="wrap ev-disc">
			<div class="ev-disc__l">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Pricing' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">See the Plan</span> <span class="sh__b">Before You See a Price</span></h2>
				</div>
				<div class="ev-price ev-price--col">
					<p>A package price picked from a menu tells you what an agency sells, not what your business needs. Two companies in the same city can need completely different channels, content volumes and budgets.</p>
					<p>So we work the other way round. First you get the strategy: which channels we would use, what each is for, what we would produce and how we will measure it. When you have read it, we send a quote that matches it line by line.</p>
					<?php echo $wu_check( array( 'Channels and the job of each one', 'Content and creative we would produce', 'What we will measure, and how often you will hear from us', 'Our fee, shown separately from your ad budget' ) ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-disc__card">
				<span class="ev-disc__pill">Digital marketing plan</span>
				<p class="ev-disc__from"><span>Step one</span><strong>The plan</strong></p>
				<p class="ev-disc__note">The price comes after you have seen it.</p>
				<?php echo $wu_btn( 'Get our plan', 'teal', $wu_lead ); // phpcs:ignore ?>
			</div>
		</div>
	</section>

	<!-- 10. Reviews -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="ev-quotes" data-quotes>
				<div class="ev-quotes__head">
					<h2 class="ev-quotes__h sh__h">What clients say</h2>
					<div class="ev-quotes__nav">
						<button type="button" class="ev-qnav" data-q-prev aria-label="Previous review"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M10.5 6.5 5 12l5.5 5.5"/></svg></button>
						<button type="button" class="ev-qnav" data-q-next aria-label="Next review"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg></button>
					</div>
				</div>
				<div class="ev-quotes__track" data-q-track tabindex="0" aria-label="Client reviews">
					<?php foreach ( array(
						array( 'Mohamed Afsal K', 'Director (Sales and Marketing), Onesto and Mercado Pvt Ltd · Google review', array( 'We are very satisfied with the social media marketing services provided by WiseUp Branding. Since they started managing our social media pages, we have seen a noticeable increase in engagement and sales.', 'Their team is creative, professional, and always supportive whenever we need assistance or updates. They truly understand branding and marketing strategies that work.', 'Thank you, WiseUp Branding, for your continuous support and dedication. Highly recommended for businesses looking to grow online!' ) ),
						array( 'Arjun', 'Branding Manager, Sathya Agencies · Google review', array( 'We had a wonderful experience working with WiseUp for Sathya Agencies. Their team handled our video production projects professionally with creative concepts and trending video ideas that perfectly matched our brand. The quality of the videos, editing, and overall presentation was excellent and helped us attract more customer attention online.', 'Apart from video production, WiseUp also provided strong support for our digital presence. Their digital marketing strategies, creative content, and consistent support helped improve our online visibility and engagement. The team was responsive, creative, and always ready to bring fresh ideas to the table.', 'We truly appreciate their dedication, professionalism, and innovative approach. Highly recommended for anyone looking for quality video production, branding, and digital marketing services.' ) ),
						array( 'Sharlet N Shaji', 'Google review', array( 'I recently got my logo designed and I’m extremely happy with the result. The designer perfectly understood my vision and created a logo that looks professional, unique, and elegant. The communication was smooth, delivery was on time, and the overall experience was excellent. Highly recommend for anyone looking for quality branding and logo design work.' ) ),
					) as $q ) : ?>
					<figure class="ev-quote" data-quote>
						<div class="ev-quote__head"><span class="ev-quote__mark" aria-hidden="true">&ldquo;</span><div class="ev-quote__stars" role="img" aria-label="5 out of 5 stars">★★★★★</div></div>
						<blockquote class="ev-quote__text"><?php foreach ( $q[2] as $p ) echo '<p>' . esc_html( $p ) . '</p>'; ?></blockquote>
						<button class="ev-quote__more" type="button" hidden aria-expanded="false">Read more</button>
						<figcaption><span class="ev-quote__av" aria-hidden="true"><?php echo esc_html( mb_substr( $q[0], 0, 1 ) ); ?></span><span><strong><?php echo esc_html( $q[0] ); ?></strong><span><?php echo esc_html( $q[1] ); ?></span></span></figcaption>
					</figure>
					<?php endforeach; ?>
				</div>
				<div class="ev-quotes__dots" aria-hidden="true"><i></i><i></i><i></i></div>
			</div>
		</div>
	</section>

	<!-- 11. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="dm-faq-h">
		<div class="wrap ev-faqsplit">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="dm-faq-h" class="sh__h"><span class="sh__a">Common Questions</span> <span class="sh__b">About Working With Us</span></h2>
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

	<!-- 12. Final CTA: enquiry form + WhatsApp / call -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><span class="sh__a">What Do You Want</span> <span class="sh__b">to Grow Next?</span></h2>
					<p class="ev-final__p">Tell us a little about your business and what you want more of. We will come back with a plan you can read before any price is discussed.</p>
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
					<label><span>Phone or WhatsApp</span><input name="phone" type="tel" required autocomplete="tel"></label>
					<label><span>Email</span><input name="email" type="email" autocomplete="email"></label>
					<label><span>Company</span><input name="company" autocomplete="organization"></label>
					<label><span>What do you want to grow?</span>
						<select name="service" required>
							<option value="" selected disabled>Choose one</option>
							<?php foreach ( array( 'Not sure yet: plan it for me', 'SEO and AI search', 'Google and Meta ads', 'Social media', 'Branding and creative', 'Video and content', 'Website or online store' ) as $o ) echo '<option>' . esc_html( $o ) . '</option>'; ?>
						</select>
					</label>
					<label><span><?php echo esc_html( $wu_m['city'] ); ?></span><input name="city" autocomplete="address-level2"></label>
					<label class="ev-form__wide"><span>Website (optional)</span><input name="website" inputmode="url" autocomplete="url" placeholder="yourbusiness.com"></label>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Get our plan</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
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
			var bad = [].slice.call(f.querySelectorAll('input,select')).filter(function (el) { return el.name !== 'hp_website' && !el.checkValidity(); });
			if (bad.length) { bad[0].focus(); note.textContent = bad[0].name === 'email' ? 'Please check that address.' : 'Please add your name, a phone number and what you want to grow.'; return; }
			var d = new FormData(f), v = function (k) { return String(d.get(k) || '').trim(); };
			var msg = ['Wants to grow: ' + v('service'), 'Company: ' + (v('company') || '-'), 'City: ' + (v('city') || '-'), 'Website: ' + (v('website') || '-')].join('\n');
			var wa = 'https://wa.me/916282434503?text=' + encodeURIComponent('Hi WiseUp, I am ' + v('name') + '.\n' + msg);
			btn.disabled = true; note.textContent = 'Sending…';
			fetch(f.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': f.dataset.nonce },
				body: JSON.stringify({ name: v('name'), phone: v('phone'), email: v('email'), service: v('service'), message: msg, page: location.href, source: f.dataset.source, hp_website: v('hp_website') }) })
				.then(function (r) { if (!r.ok) throw 0; f.reset(); note.textContent = 'Thanks, we have your details and will be in touch soon.'; })
				.catch(function () { note.innerHTML = 'Couldn’t send that right now. <a href="' + wa + '" target="_blank" rel="noopener">Send it on WhatsApp instead</a>.'; })
				.then(function () { btn.disabled = false; });
		});
	}
	// live local times (Australian version)
	var tz = document.querySelector('[data-tz]');
	if (tz && window.Intl) {
		var cells = [].slice.call(tz.querySelectorAll('[data-zone]'));
		var mins = function (zone, now) { var p = new Intl.DateTimeFormat('en-GB', { timeZone: zone, hour: 'numeric', minute: 'numeric', hourCycle: 'h23' }).formatToParts(now), g = function (t) { return +p.filter(function (x) { return x.type === t; })[0].value; }; return g('hour') * 60 + g('minute'); };
		var tick = function () {
			var now = new Date(), home = mins('Asia/Kolkata', now);
			cells.forEach(function (c) {
				var z = c.getAttribute('data-zone');
				c.querySelector('[data-time]').textContent = new Intl.DateTimeFormat('en-AU', { timeZone: z, hour: 'numeric', minute: '2-digit' }).format(now);
				var o = c.querySelector('[data-off]');
				if (o) { var diff = mins(z, now) - home; if (diff < -720) diff += 1440; if (diff > 720) diff -= 1440; var h = diff / 60; o.textContent = (h >= 0 ? '+' : '−') + String(Math.abs(h)).replace('.5', '½') + ' h from Kozhikode'; }
			});
		};
		tick(); setInterval(tick, 30000);
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
	// this page's own blocks: staggered rise (GSAP when the engine runs, otherwise a class toggle)
	var mine = [].slice.call(document.querySelectorAll('.wu-dm :is(.dm-trio li, .dm-ind li, .dm-res__card, .dm-city, .dm-overlap, .ev-quotes)'));
	if (gs) {
		// the GSAP scripts load after this one: run once they have
		addEventListener('DOMContentLoaded', function () {
			if (!window.__wuEvMotion || !window.gsap || !window.ScrollTrigger) return;
			gsap.set(mine, { opacity: 0, y: 56 });
			ScrollTrigger.batch(mine, { start: 'top 90%', once: true, onEnter: function (b) { gsap.to(b, { opacity: 1, y: 0, duration: 1.1, stagger: 0.08, ease: 'expo.out', clearProps: 'transform' }); } });
		});
		return;
	}
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { rootMargin: '0px 0px -8% 0px' });
	document.querySelectorAll('.wu-dm :is(.ev-card, .ev-step, .ev-panel, .ev-exp__card, .dm-trio li, .dm-ind li, .dm-res__card, .dm-city, .ev-quotes)').forEach(function (el, i) {
		if (el.getBoundingClientRect().top > innerHeight) { el.classList.add('ev-rise'); el.style.setProperty('--d', (i % 3) * 70 + 'ms'); io.observe(el); }
	});
})();
</script>
<?php
$wu_lead_source = $wu_src;
include WISEUP_DIR . 'landing/lead-popup.php';
$wu_scripts = array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js' );
if ( ! $wu_au ) $wu_scripts[] = 'ev-map.js';
foreach ( $wu_scripts as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
