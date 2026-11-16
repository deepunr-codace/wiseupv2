<?php
/**
 * Performance Marketing Agency in Kerala ("WiseUp: Performance Marketing (new)" in the page Template dropdown). Copy is
 * the owner's doc (Downloads/performance marketing company in Kerala.docx, 2026-11-16), in the doc's order. The doc's
 * "[Add verified client project and testimonial details here]" is a placeholder and is not shown. Design system: the
 * Event Branding page's (assets/css/event-branding.css + event-branding.js, scoped to .wu-ev) plus the Digital
 * Marketing page's blocks (assets/css/digital-marketing.css, .dm-* and .pm-*). Brand marks: landing/digital-marketing-icons.php.
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'performance-marketing';
$wu_title = apply_filters( 'wiseup_landing_title', 'Performance Marketing Agency in Kerala | PPC & Google Ads Company in Calicut | WiseUp' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is a performance marketing agency in Kerala, based in Calicut: Google Ads, Meta Ads, LinkedIn Ads, remarketing and conversion tracking built around leads, sales and a better use of your advertising budget.' );
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

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to talk about performance marketing for my business.' );
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
	$wu_google = array( 'google' => 'i-google-icon.svg', 'googleads' => 'i-google-ads.svg', 'googlesearchconsole' => 'i-google-search-console.svg', 'googleanalytics' => 'i-google-analytics.svg', 'googletagmanager' => 'i-google-tag-manager.svg' );
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
$wu_logos = array( 'amarapushpa' => 'Amarapushpa', 'bm-prime' => 'BM Prime', 'bucho' => 'Bucho', 'cadd' => 'CADD', 'cellar-de-mahe' => 'Cellar de mahe', 'clair-veda' => 'Clair veda', 'eduwizz' => 'Eduwizz', 'ellisto' => 'Ellisto', 'erets' => 'Erets', 'flora-fauna' => 'Flora fauna', 'formaa' => 'Formaa', 'gloveda' => 'Gloveda', 'goldekarak' => 'Golden Karak', 'hayath' => 'Hayath', 'intervel' => 'Intervel', 'lullaby' => 'Lullaby', 'lunar' => 'Lunar', 'mgf' => 'MGF', 'mooss' => 'mooss', 'onesto-marcado' => 'Onesto Marcado', 'philips' => 'Philips', 'popees' => 'Popees', 'sathya' => 'Sathya', 'superhuman' => 'Superhuman', 'tiny-mafia' => 'Tiny Mafia', 'wellah' => 'Wellah' );
$wu_li    = '';
foreach ( $wu_logos as $f => $alt ) $wu_li .= '<li class="is-tile"><img src="' . esc_url( WISEUP_ASSETS . '/clients/client-logos-2026/' . $f . '.webp' ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async"></li>';

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


// Services: [ title, icon, text, link, brand marks ].
$wu_services = array(
	array( 'Google Search Ads and PPC Management', 'search', 'We plan and manage Google Search campaigns to connect your business with people actively searching for your products or services. As a Google ad management agency, we handle keyword targeting, ad copy, bidding strategies and campaign monitoring. Our approach focuses on reaching relevant audiences, managing advertising costs and generating meaningful enquiries through paid search.', '', array( 'google', 'googleads' ) ),
	array( 'Google Display Ads and YouTube Advertising', 'play', 'Reach potential customers beyond search results with visual and video advertising. We plan Google Display and YouTube campaigns using audience interests, demographics and relevant placements to build awareness and generate interest. Where suitable, we also use remarketing to reconnect with people who have previously interacted with your brand, keeping your business visible as they move towards a decision.', '', array( 'googleads', 'youtube' ) ),
	array( 'Google Shopping and Performance Max Campaigns', 'bag', 'For e-commerce businesses, product visibility can make a difference to purchase decisions. We set up and manage Google Shopping and Performance Max campaigns to showcase products across Google’s advertising channels. From product feed considerations and campaign setup to audience signals and performance monitoring, we focus on reaching shoppers with relevant products and improving campaign efficiency.', '', array( 'google', 'googleads', 'shopify.svg' ) ),
	array( 'Meta Ads for Facebook and Instagram', 'target', 'As a PPC marketing agency, we manage Facebook and Instagram campaigns using audience targeting and creative formats suited to your business goals. Whether you want to generate leads, increase website conversions or drive sales, we plan campaigns around the people you want to reach and the actions you want them to take.', '', array( 'meta', 'facebook', 'instagram' ) ),
	array( 'LinkedIn Ads for B2B Lead Generation', 'scale', 'Reach decision-makers and professional audiences through targeted LinkedIn campaigns. We plan campaigns around relevant industries, job roles, company sizes, and professional interests, helping B2B businesses generate enquiries, qualified leads, and demo requests. Each campaign is structured around the audience and business outcome that matter most.', '', array( 'linkedin' ) ),
	array( 'Remarketing and Retargeting Campaigns', 'eye', 'Not everyone takes action on their first visit. Remarketing allows your business to reconnect with eligible audiences who have previously visited your website, interacted with an advertisement, or engaged with your brand. We create targeted campaigns to bring interested people back, reinforce your message, and encourage them to complete an enquiry or purchase.', '', array( 'googleads', 'meta', 'linkedin' ) ),
	array( 'Landing Page Optimisation and Conversion Rate Optimisation', 'code', 'An effective advertisement needs a landing page that supports the same message. We review page content, calls to action, forms and user experience to identify barriers that may prevent visitors from converting. Through relevant improvements and conversion testing, we aim to make it easier for visitors to take the next step after clicking your ad.', '', array( 'googleanalytics', 'hotjar', 'googletagmanager' ) ),
);

// Process: [ title, icon, text ].
$wu_process = array(
	array( 'Understand Business Goals', 'target', 'We identify your campaign objectives, whether they involve lead generation, sales, website traffic, or brand awareness. We also define the key performance indicators (KPIs) that will measure progress.' ),
	array( 'Research the Target Audience', 'search', 'We study audience demographics, interests, search intent, and buying behaviour to understand who your campaigns need to reach and what influences their decisions.' ),
	array( 'Plan the Campaign Strategy', 'map', 'We select suitable advertising platforms, plan campaign structures, and allocate budgets based on your goals and audience behaviour.' ),
	array( 'Create and Launch Campaigns', 'rocket', 'We prepare ad copy, creative assets, offers and audience targeting. Conversion tracking is configured to measure relevant actions after launch.' ),
	array( 'Monitor Campaign Performance', 'chart', 'We review clicks, click-through rates (CTR), cost per click (CPC), conversions, cost per lead and return on ad spend (ROAS), where applicable.' ),
	array( 'Test and Optimise', 'spark', 'We test creatives, messaging, audiences and landing pages, adjusting bids and budgets based on the results. This helps us identify what works and improve campaign performance over time.' ),
);

// What we bring: [ icon, title, text ].
$wu_bring = array(
	array( 'globe', 'Platform Expertise', 'Campaign management across Google, Meta, LinkedIn, and other relevant advertising platforms.' ),
	array( 'brush', 'Creative Development', 'Ad visuals, headlines and messaging suited to your brand and target audience.' ),
	array( 'chart', 'Tracking and Measurement', 'Tools and tracking systems to give you a clearer view of campaign activity and results.' ),
	array( 'eye', 'Performance Insights', 'Regular updates on campaign progress, advertising costs, and results against agreed KPIs.' ),
	array( 'chat', 'Account Management', 'Ongoing support, communication and campaign reviews to keep your advertising on track.' ),
);

// Platforms and tracking tools: [ title, brand mark, text ].
$wu_platforms = array(
	array( 'Google Ads and Conversion Tracking', 'googleads', 'We use Google Ads to manage search, display, video, shopping and other suitable campaigns. Its reporting helps us monitor impressions, clicks, CTR, CPC and conversions, while conversion tracking measures actions users complete after interacting with your advertisements.' ),
	array( 'Google Analytics 4 (GA4)', 'googleanalytics', 'GA4 helps us assess how visitors arriving through paid campaigns interact with your website. We review traffic sources, engagement, user behaviour and conversion activity to understand what happens after an advertisement brings someone to your site.' ),
	array( 'Google Tag Manager (GTM)', 'googletagmanager', 'Google Tag Manager helps manage website tracking tags and conversion events. It supports the measurement of important interactions, such as form submissions, button clicks and other actions relevant to your campaign objectives.' ),
	array( 'Meta Ads Manager and Meta Pixel', 'meta', 'Meta Ads Manager provides campaign insights across Facebook and Instagram, including reach, impressions, clicks, engagement and conversions. With Meta Pixel configured appropriately, we can measure relevant website activity and assess how different audiences and creatives perform.' ),
	array( 'LinkedIn Campaign Manager', 'linkedin', 'LinkedIn Campaign Manager helps us review the performance of professional audience campaigns. We assess impressions, clicks, engagement, lead generation and conversions to understand how campaigns are reaching relevant business audiences.' ),
	array( 'Looker Studio and Performance Reports', 'looker.svg', 'Where used, Looker Studio brings campaign data into visual dashboards, making it easier to review key metrics and compare performance across channels. We use reports to communicate campaign progress, advertising expenditure and areas that may need attention.' ),
);

// From clicks to business results: [ icon, title, text ].
$wu_results = array(
	array( 'link', 'Track the Journey from Click to Conversion', 'We measure what happens after someone interacts with your advertisement, whether they visit your website, submit an enquiry form, request a consultation or complete a purchase. Conversion tracking helps connect these actions to individual campaigns, giving us a clearer picture of what your advertising achieves.' ),
	array( 'scope', 'Look Beyond the Number of Leads', 'More enquiries do not always mean better results. We look at the relevance of incoming leads, cost per lead, and how closely enquiries match your target customers. Where CRM or sales data is available, we can also assess which leads progress through the sales process and identify campaigns attracting more valuable prospects.' ),
	array( 'chart', 'Measure Business Outcomes', 'We look beyond advertising activity to assess acquisition costs, completed sales, and revenue wherever reliable data is available. For suitable campaigns with revenue tracking in place, return on ad spend (ROAS) helps measure the revenue generated against advertising expenditure.' ),
	array( 'spark', 'Turn Insights into Better Decisions', 'Campaign data helps identify which audiences, advertisements, and channels are delivering value. We use these findings to refine targeting, test new creatives, adjust budgets, and improve underperforming campaigns. Where campaigns show consistent results, we can assess opportunities to scale them.' ),
);

// Industries: [ name, icon ].
$wu_industries = array(
	array( 'E-commerce and Retail', 'bag' ), array( 'Real Estate', 'home' ), array( 'Healthcare and Wellness', 'health' ),
	array( 'Education and Training', 'cap' ), array( 'B2B and Professional Services', 'scale' ), array( 'Travel and Hospitality', 'bed' ),
);

// Why WiseUp: [ icon, title, text ].
$wu_why = array(
	array( 'target', 'No Wasted Ad Spend', 'We focus your advertising budget on relevant audiences, suitable platforms, and better-performing campaigns. Regular monitoring helps identify unnecessary spending and areas where your budget can be used more effectively.' ),
	array( 'map', 'Strategies Built Around Your Goals', 'Your campaign strategy starts with your business objectives, target audience and available budget. We plan advertising activities around what you want to achieve rather than applying the same approach to every business.' ),
	array( 'brush', 'Creative Ads That Get Attention', 'Relevant messaging and strong visuals make a difference to how people respond to advertisements. We develop ad copy and creative assets that reflect your brand, communicate your message and encourage your audience to take action.' ),
	array( 'chart', 'Focus on Leads and Sales', 'Clicks and impressions are useful indicators, but they are not the only measures of success. We monitor enquiries, conversions and sales to understand how your campaigns contribute to business objectives.' ),
	array( 'spark', 'Continuous Campaign Improvement', 'We regularly review campaign performance and test different audiences, creatives and advertising approaches. These insights guide our optimisation decisions and help us improve results over time.' ),
	array( 'eye', 'Clear Reporting and Communication', 'You stay informed about your campaign activity, advertising expenditure and performance. We share clear reports and communicate what is working, what needs attention and where improvements can be made.' ),
	array( 'rocket', 'Growth-Focused Campaigns', 'As your business and campaign requirements change, your advertising strategy should adapt too. We use performance insights to identify opportunities to improve results and scale campaigns where the data supports it.' ),
);

$wu_faq = array(
	array( 'Will we have access to our ad accounts, analytics, and dashboards?', 'Yes. Your business should retain access to its advertising accounts and relevant analytics platforms. We work with the necessary account permissions to manage campaigns and provide visibility into campaign activity, expenditure and performance.' ),
	array( 'How do you improve ROAS without reducing lead quality or sales volume?', 'We review the factors influencing campaign returns, including audience targeting, conversion rates, advertising costs and lead quality. We then test and adjust campaign elements based on performance data. The aim is to improve returns without making changes that compromise the quality of incoming leads or sales.' ),
	array( 'What reporting will we receive from your agency?', 'We provide campaign reports covering relevant metrics such as impressions, clicks, CTR, CPC, conversions, cost per lead and ROAS where applicable. Reports also highlight campaign performance, advertising expenditure and areas that may benefit from further optimisation.' ),
	array( 'Can you take over an existing performance marketing account?', 'Yes. We can review existing campaigns, account structure, targeting, advertising expenditure and conversion tracking before recommending improvements. This helps us identify what is working, where performance is falling short and what needs attention before making changes.' ),
	array( 'Can I run campaigns across multiple performance marketing channels at the same time?', 'Yes. We can plan campaigns across suitable platforms such as Google, Meta and LinkedIn, depending on your audience and business goals. Each channel serves a different purpose, so we coordinate campaign activity to support your overall marketing objectives.' ),
	array( 'Can you generate qualified B2B leads through performance marketing?', 'Yes. Platforms such as LinkedIn and Google can support B2B lead generation through professional audience targeting and search intent. We structure campaigns around relevant decision-makers, business requirements and conversion goals, while using available lead and sales data to assess lead quality.' ),
);

add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 20 );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero">
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Performance Marketing Agency in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">Make Every Ad Spend Count. Focus on Results That Matter.</span></h2>
				<p class="ev-hero__p">Getting clicks is easy. Turning those clicks into enquiries, customers and sales takes a well-planned strategy. WiseUp is a performance marketing agency in Kerala, working with businesses looking for a reliable performance marketing agency in Calicut and across Kerala. We bring audience research, creative campaigns and data-driven optimisation together to make your advertising work harder. Our campaigns focus on reaching relevant audiences, generating quality leads and making better use of your advertising budget.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Get Started', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'Talk to Our Team', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-stage dm-shot" data-stage>
				<img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-growth-1200.webp' ); ?>" srcset="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-growth-760.webp' ); ?> 760w, <?php echo esc_url( WISEUP_URL . 'assets/landing/img/dm-hero-growth-1200.webp' ); ?> 1200w" sizes="(max-width: 1023px) 92vw, 46vw" width="1116" height="920" fetchpriority="high" decoding="async" alt="A laptop showing a rising growth chart, surrounded by glowing marketing icons">
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

<?php wiseup_ai_overview( array(
	'q' => 'What does a performance marketing agency in Kerala do?',
	'a' => '<b>WiseUp</b> is a performance marketing agency in Kerala that brings <b>audience research, creative campaigns and data-driven optimisation</b> together to make your advertising work harder, reaching relevant audiences, generating quality leads and making better use of your advertising budget.',
	'points' => array(
		array( 'Platforms', 'Google Search, Display, YouTube, Shopping and Performance Max, plus Meta (Facebook and Instagram) and LinkedIn advertising.' ),
		array( 'How we work', 'We plan around your goals, audience and budget, launch with conversion tracking, then test and optimise using performance data.' ),
		array( 'What you see', 'Clear reports on impressions, clicks, CTR, CPC, conversions, cost per lead and ROAS where applicable.' ),
	),
	'links' => array( array( 'Services', '#pm-services' ), array( 'Process', '#pm-process' ), array( 'Tracking tools', '#pm-tools' ), array( 'Why WiseUp', '#why' ), array( 'FAQ', '#faq' ) ),
) ); ?>

	<!-- 2. Services -->
	<section class="sec ev-sec" id="pm-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Performance Marketing Services', 'to Reach, Engage and Convert' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Every business has different advertising goals. At WiseUp, we plan campaigns around your objectives, target audience and budget, selecting the right channels to reach potential customers. Our performance marketing services cover campaign planning, execution, tracking and ongoing optimisation.</p></div>
			</div>
			<?php
			$wu_list = array();
			foreach ( $wu_services as $s ) {
				$wu_list[] = array( $s[0], $s[2], '<span class="dm-stack__brands">' . implode( '', array_map( $wu_mark, $s[4] ) ) . '</span>', '' );
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
			var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { threshold: 0.05, rootMargin: '0px 0px -8% 0px' });
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

	<!-- 3. Process -->
	<section class="sec ev-sec" id="pm-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'How We Plan, Launch and', 'Optimise Your Ad Campaigns' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Good campaign performance starts before an advertisement goes live. We follow a structured process to understand your goals, reach the right audience and improve campaigns using performance data.</p></div>
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

	<!-- 4. What we bring -->
	<section class="sec ev-sec" id="pm-bring">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'What we bring' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'What We Bring', 'to Your Campaigns' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>As a PPC service provider, WiseUp brings together the creative, technical and reporting support needed to manage your advertising across relevant platforms. We focus on keeping campaigns organised, tracking results and maintaining clear communication throughout the process.</p></div>
			</div>
			<ul class="ev-exp" data-ev-exp>
				<?php foreach ( $wu_bring as $wu_i => $w ) : ?>
				<li class="ev-exp__card<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" tabindex="0"><span class="ev-exp__i"><?php echo $wu_svg( $wu_icons[ $w[0] ], 26 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 5. Platforms and tracking tools -->
	<section class="sec ev-sec" id="pm-tools">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Tools' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Performance Marketing Platforms', 'and Tracking Tools' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Managing advertisements is only one part of a campaign. We also use advertising and analytics platforms to monitor performance, measure conversions and understand how people interact with your website.</p></div>
			</div>
			<ul class="pm-grid pm-grid--tools">
				<?php foreach ( $wu_platforms as $p ) : ?>
				<li><?php echo $wu_mark( $p[1] ); // phpcs:ignore ?><h3><?php echo esc_html( $p[0] ); ?></h3><p><?php echo esc_html( $p[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. From ad clicks to business results -->
	<section class="sec ev-sec" id="pm-results">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Results' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'From Ad Clicks', 'to Business Results' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Clicks and impressions show how people interact with advertisements, but they do not tell the whole story. Our PPC marketing approach looks at what happens after someone clicks, from website visits and enquiries to completed purchases. By connecting campaign activity with conversion data, we can assess lead quality, acquisition costs, and revenue where reliable data is available. These insights help us understand which campaigns contribute to business goals, where advertising spend needs attention, and which opportunities are worth pursuing.</p></div>
			</div>
			<ul class="pm-grid pm-grid--two">
				<?php foreach ( $wu_results as $r ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $r[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $r[1] ); ?></h3><p><?php echo esc_html( $r[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 7. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries', 'We Serve' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Advertising goals vary across industries. While some businesses focus on immediate purchases, others need qualified enquiries, appointment requests or longer-term customer relationships. We plan campaigns around the buying behaviour and conversion goals relevant to each business.</p></div>
			</div>
			<ul class="dm-ind">
				<?php foreach ( $wu_industries as $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_svg( $wu_icons[ $ind[1] ], 22 ); // phpcs:ignore ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 8. Trusted strategies (the doc's client project and testimonial placeholder is not shown) -->
	<section class="sec ev-sec" id="trusted">
		<div class="wrap">
			<div class="pm-band">
				<h2 class="sh__h"><?php echo $wu_h( 'Trusted Strategies.', 'Transparent Results.' ); // phpcs:ignore ?></h2>
				<?php echo $wu_btn( 'Plan Your Next Campaign', 'teal', $wu_lead ); // phpcs:ignore ?>
			</div>
		</div>
	</section>

	<!-- 9. Why WiseUp -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Why Businesses Opt for', 'WiseUp Marketing Agency?' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Choosing a PPC services company is about finding a team that understands your business goals, respects your advertising budget and takes responsibility for campaign performance. At WiseUp, we combine strategic planning, creative execution, and regular performance reviews to keep your campaigns focused on meaningful business outcomes.</p></div>
			</div>
			<ul class="pm-grid pm-grid--why">
				<?php foreach ( $wu_why as $w ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $w[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 10. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="dm-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="dm-faq-h" class="sh__h"><?php echo $wu_h( 'What Businesses', 'Often Ask' ); // phpcs:ignore ?></h2>
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
					<h2 class="sh__h"><?php echo $wu_h( 'Ready to Make Your', 'Ad Spend Work Harder?' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Let’s build advertising campaigns around your business goals, reach the right audiences and make every marketing decision count.</p>
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
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Request a Campaign Consultation</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
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
				gsap.from(c.querySelectorAll('.dm-stack__l > *, .dm-stack__r > *'), { y: 34, opacity: 0, duration: 0.9, stagger: 0.07, ease: 'expo.out', clearProps: 'transform,opacity', scrollTrigger: { trigger: c, start: 'top 82%', once: true } });
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
			ScrollTrigger.batch(mine, { start: 'top 90%', once: true, onEnter: function (b) { gsap.to(b, { opacity: 1, y: 0, duration: 1.1, stagger: 0.08, ease: 'expo.out', clearProps: 'transform' }); } });
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

