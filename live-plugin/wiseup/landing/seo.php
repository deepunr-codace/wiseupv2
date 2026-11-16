<?php

/**
 * SEO Company in Kerala ("WiseUp: SEO Company" in the page Template dropdown). Rebuilt in the shared service-page design
 * system (Event Branding / Digital Marketing / Performance pages: assets/css/event-branding.css + digital-marketing.css,
 * .wu-ev .wu-dm .wu-pm); same sections, order and copy as before (the owner's seo agency in kerala.docx).
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'seo';
$wu_title = apply_filters( 'wiseup_landing_title', 'SEO Company in Kerala | WiseUp Branding' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is an SEO company in Kerala building visibility across Google, Bing and AI-powered search with technical SEO, content, AI SEO and data-led strategy.' );
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

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like a free SEO assessment for my website.' );
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

// ---------- content ----------
$wu_visibility = array( array( 'Google Search', 'google' ), array( 'AI Overviews', 'googlegemini.svg' ), array( 'Bing', 'fav-bing.com.png' ), array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Google Maps', 'googlemaps.svg' ), array( 'Gemini', 'googlegemini.svg' ), array( 'Copilot', '' ), array( 'Perplexity', 'perplexity.svg' ) );

// Services: [ title, icon, text, tags, brand marks ].
$wu_services = array(
	array( 'SEO Strategy & Keyword Research', 'search', 'Our SEO strategy begins with understanding your market, competitors and customer search behaviour. We identify relevant keywords across informational, commercial and transactional intent, assessing their search demand, competition and business relevance. From keyword mapping and content gaps to search opportunity analysis, we develop a practical roadmap that gives every page a clear purpose and direction.', array(), array( 'semrush', 'fav-ahrefs.com.png', 'fav-trends.google.com.png' ) ),
	array( 'On-Page SEO', 'pen', 'We optimise the elements that influence page relevance, search visibility and user experience. Our on-page SEO includes title tags, meta descriptions, heading structures, URLs, keyword placement, content optimisation, image attributes, internal linking and structured data. We also review page organisation and content quality to ensure your website communicates its relevance clearly to both visitors and search engines.', array(), array( 'google', 'googlesearchconsole' ) ),
	array( 'AI SEO & Search Visibility', 'spark', 'WiseUp incorporates Answer Engine Optimisation (AEO), Generative Engine Optimisation (GEO) and LLM-focused strategies into its broader SEO approach. We work on answer-focused content, entity clarity, topical authority, structured data, source accessibility and consistent brand information to improve how your business can be discovered across AI-powered search experiences. Our approach covers platforms such as ChatGPT, Gemini, Claude and Perplexity, alongside conventional search engines.', array( 'AEO', 'GEO', 'LLM visibility', 'AI Overviews', 'Entity optimisation' ), array( 'fav-chatgpt.com.png', 'googlegemini.svg', 'claude.svg', 'perplexity.svg' ) ),
	array( 'AI Overview Optimisation (AIO)', 'bot', 'Google AI Overviews are changing how information appears in search results. Our AIO services focus on improving your website’s eligibility to appear as a cited source in AI-generated summaries. We work on content relevance, clear information structures, topical coverage, entity consistency and supporting page signals. This helps search engines identify useful information on your website and consider it for relevant AI-generated responses.', array(), array( 'google', 'googlegemini.svg' ) ),
	array( 'Technical SEO', 'tool', 'Our technical SEO services address website issues that affect crawling, indexing, rendering, and performance. We conduct technical audits and work on site architecture, XML sitemaps, robots.txt, canonical tags, redirects, broken links, Core Web Vitals, mobile usability, structured data, and page speed. From identifying crawl errors to resolving indexing barriers, we strengthen the technical elements required for sustainable organic search performance.', array(), array( 'fav-screamingfrog.co.uk.png', 'googlesearchconsole', 'googletagmanager' ) ),
	array( 'Content SEO', 'brush', 'Our content SEO strategy connects keyword opportunities with your audience’s needs and your business offerings. We develop and optimise service pages, landing pages, product content, blogs and supporting resources to improve topical relevance and organic visibility. Content gap analysis, search intent mapping, topic clusters, internal linking and content updates ensure your website has a clear, connected content strategy.', array(), array( 'semrush', 'grammarly', 'fav-answerthepublic.com.png' ) ),
	array( 'Off-Page SEO & Link Building', 'link', 'We strengthen your website’s external authority through strategic link acquisition, backlink analysis, competitor link research, digital PR opportunities and relevant brand mentions. Our off-page SEO services prioritise credible sources, industry relevance and natural link profiles. We also monitor existing backlinks to identify potentially harmful patterns and opportunities to improve your website’s authority.', array(), array( 'fav-ahrefs.com.png', 'semrush', 'ddg-moz.com.ico' ) ),
	array( 'Local SEO', 'pin', 'We improve your local search presence through Google Business Profile management and targeted keywords that connect your business with nearby customers. Our local SEO services cover business profile management, local citations, business information consistency, location landing pages, review visibility, and locally relevant content. Whether you’re targeting Calicut, other cities across Kerala, or multiple service locations, we align your local search presence with your business reach.', array(), array( 'googlemaps.svg', 'google' ) ),
	array( 'International SEO', 'globe', 'We build international SEO strategies for businesses targeting customers across countries and languages. Our work covers international keyword research, website localisation, country-specific content, URL structures, hreflang implementation and regional targeting. We also review technical configurations to ensure search engines can identify the right content for audiences in different markets.', array(), array( 'google', 'fav-bing.com.png' ) ),
	array( 'Mobile SEO', 'eye', 'We optimise mobile website performance across responsive layouts, navigation, page speed, content presentation, usability and Core Web Vitals. Our mobile SEO work also addresses technical accessibility and rendering issues that affect how search engines access mobile pages. The result is a website experience designed to support both mobile visitors and organic search performance.', array(), array( 'google', 'fav-clarity.microsoft.com.png' ) ),
	array( 'SaaS SEO', 'code', 'Our SaaS SEO services focus on reaching users at every stage of the software buying journey. We optimise product pages, feature pages, integration pages, use-case landing pages and comparison content around high-intent search opportunities. Our strategy also covers competitor positioning, technical SEO, topical content clusters and conversion-focused optimisation to strengthen organic acquisition and attract users who are actively evaluating software solutions.', array(), array( 'hubspot', 'react.svg', 'nextdotjs.svg' ) ),
);

// Platforms: [ name, mark, text, tag ].
$wu_platforms = array(
	array( 'WordPress', 'wordpress.svg', 'Optimise WordPress websites for technical performance, content structure, indexing, on-page SEO and search visibility.', '' ),
	array( 'WooCommerce', 'woocommerce.svg', 'WooCommerce SEO covering product and category optimisation, product search visibility, internal linking, technical issues, structured data and transactional search intent.', 'Dedicated e-commerce SEO' ),
	array( 'Shopify', 'shopify.svg', 'Shopify SEO covering collection and product pages, site structure, technical SEO, content optimisation and organic visibility for Shopify stores.', 'Dedicated e-commerce SEO' ),
	array( 'React.js', 'react.svg', 'Rendering, crawlable routes and metadata for JavaScript-heavy React applications.', '' ),
	array( 'Next.js', 'nextdotjs.svg', 'SSR and static generation, metadata, sitemaps and Core Web Vitals for Next.js sites.', '' ),
	array( 'Django', 'django.svg', 'Clean URL patterns, template-level metadata, sitemaps and performance for Django builds.', '' ),
	array( 'Nest.js', 'nestjs.svg', 'Headless and API-driven setups made crawlable, with rendering and structured data handled correctly.', '' ),
	array( 'Node.js', 'nodedotjs.svg', 'Rendering strategy, routing, redirects and page speed for custom Node.js websites.', '' ),
);

// Projects: [ name, image, tags, link ].
$wu_projects = array(
	array( 'Smoke House', 'assets/landing/img/case-smokehouse.jpg', array( 'Local SEO', 'Content SEO' ), '' ),
	array( 'Bootland', 'assets/landing/img/case-bootland.jpg', array( 'Technical SEO', 'On-Page SEO' ), '' ),
	array( 'Indus Go', 'assets/landing/img/case-indusgo.jpg', array( 'SEO Strategy', 'AI Search Visibility' ), home_url( '/case-studies/indusgo/' ) ),
	array( 'Erets Space', 'assets/landing/img/case-erets.jpg', array( 'Content SEO', 'Link Building' ), '' ),
	array( 'Golden Karak', 'assets/landing/img/case-karak.jpg', array( 'Local SEO', 'Mobile SEO' ), home_url( '/case-studies/golden-karak/' ) ),
);

// Tools: [ name, mark ].
$wu_tools = array( array( 'Semrush', 'semrush' ), array( 'Ahrefs', 'fav-ahrefs.com.png' ), array( 'Screaming Frog', 'fav-screamingfrog.co.uk.png' ), array( 'Moz', 'ddg-moz.com.ico' ), array( 'Google Trends', 'fav-trends.google.com.png' ), array( 'Heap', 'fav-heap.io.png' ), array( 'Google Search Console', 'googlesearchconsole' ), array( 'Google Analytics 4', 'googleanalytics' ), array( 'Google Tag Manager', 'googletagmanager' ), array( 'Microsoft Clarity', 'fav-clarity.microsoft.com.png' ) );

// Process: [ stage title, icon, months, steps ].
$wu_process = array(
	array( 'Discover & Strategise', 'search', 'Months 1–2', array( 'Discovery', 'SEO & AI Audit', 'Keyword Research', 'Competitor Analysis', 'SEO Roadmap' ) ),
	array( 'Optimise & Strengthen', 'tool', 'Months 3–4', array( 'Technical SEO', 'On-Page SEO', 'Content Optimisation', 'AI Search Optimisation', 'Authority Building' ) ),
	array( 'Measure & Grow', 'chart', 'Months 5–6', array( 'Performance Tracking', 'SEO Recommendations', 'Content Expansion', 'Continuous Optimisation', 'Scale' ) ),
);

// Package groups: [ title, items ].
$wu_package = array(
	array( 'Research & Content', array( 'Thorough Keyword Research', 'Content Creation', 'Competitor Benchmarking', 'Duplicate Content Analysis' ) ),
	array( 'Website & Technical Optimisation', array( 'Speed Tests', 'Website Downtime Monitoring', 'HTML and Content Structure Optimisation', 'Meta Information Optimisation', 'Rich Snippet Implementation', 'UI/UX Designs' ) ),
	array( 'Authority & Performance', array( 'Inbound Backlinking', 'Google Search Console Setup', 'Google Analytics 4 Enhancement', 'Comprehensive Monthly Reports', '24/7 support' ) ),
);

$wu_industries = array(
	array( 'E-commerce & Retail', 'bag' ), array( 'SaaS & Technology', 'code' ), array( 'Professional Services', 'scale' ), array( 'Education & Training', 'cap' ),
	array( 'Healthcare & Wellness', 'health' ), array( 'Real Estate & Construction', 'home' ), array( 'Hospitality & Travel', 'bed' ), array( 'Finance & Business Services', 'chart' ),
);

// Why WiseUp: [ icon, title, text ].
$wu_why = array(
	array( 'target', 'Strategies That Fit Your Business', 'We take time to understand your business, audience, competitors and goals before planning a campaign. Every strategy is built around what your business needs, not a one-size-fits-all approach.' ),
	array( 'globe', 'Experienced Team With the Right Expertise', 'Our team brings together skills in keyword research, content, technical optimisation and digital marketing. You get the right expertise working together to improve your website’s performance.' ),
	array( 'scale', 'Ethical Practices, Always', 'We follow search engine guidelines and focus on sustainable methods. No shortcuts or risky tactics that could harm your website or brand reputation.' ),
	array( 'chart', 'Focus on Real Business Growth', 'Rankings and traffic matter, but what happens after visitors reach your website matters too. We focus on attracting relevant visitors who are more likely to become enquiries and customers.' ),
	array( 'eye', 'Clear Reports and Regular Updates', 'You stay informed about campaign activities and progress. We share reports on traffic, rankings, visibility and important improvements, so you know where things stand.' ),
	array( 'code', 'Solutions for Different Website Platforms', 'Whether your website runs on WordPress, Shopify, WooCommerce or a custom framework, we adapt our approach to its platform and technical requirements.' ),
);

$wu_faq = array(
	array( 'How long do SEO efforts typically take to show significant, measurable results for an established website?', 'Most established websites see measurable gains: better rankings, impressions and organic traffic, within three to six months. Highly competitive keywords or new markets can take six to twelve. Technical fixes often show impact sooner, and results compound the longer a consistent strategy runs.' ),
	array( 'What deliverables and reports will we receive every month?', 'A monthly SEO report covering keyword rankings, organic traffic, conversions, Search Console and GA4 insights, AI search visibility, the work completed and the plan for next month, plus access to a live dashboard whenever you need it.' ),
	array( 'Should SEO be part of a broader digital marketing strategy?', 'Yes. SEO builds long-term organic visibility, while paid ads, social media and content marketing drive faster reach. Planned together, each channel strengthens the others, and your overall cost per lead comes down.' ),
	array( 'What Is WooCommerce SEO and How Does It Benefit E-commerce Businesses?', 'WooCommerce SEO optimises WordPress-based online stores: product and category pages, site structure, structured data, internal linking and technical performance, so your products appear for high-intent, ready-to-buy searches. The result is more organic shoppers and sales without relying entirely on paid ads.' ),
);
$wu_services_select = array( 'Free SEO Assessment', 'SEO Package Quote', 'AI SEO & Search Visibility', 'Local SEO', 'WooCommerce / Shopify SEO', 'Something else' );

add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
}, 20 );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-seo-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-seo">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero">
		<div class="ev-hero__glow" aria-hidden="true"></div>
		<div class="wrap ev-hero__grid">
			<div class="ev-hero__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>SEO Company in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">Search is changing. Make sure your brand is still being found.</span></h2>
				<p class="ev-hero__p">A website that doesn’t appear when customers search for your services is missing valuable opportunities. WiseUp is an SEO company in Kerala that brings technical optimisation, strategic content, keyword intelligence and competitor analysis together to strengthen your online presence. We build search strategies that position your brand across traditional search engines and AI-powered platforms, helping potential customers find and consider your business.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Get My Free Proposal', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'Chat on WhatsApp', 'night', 'href="' . esc_url( $wu_wa ) . '" target="_blank" rel="noopener"' ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-stage seo-card" data-stage aria-hidden="true">
				<div class="seo-card__chips"><?php foreach ( array( array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Gemini', 'googlegemini.svg' ), array( 'Perplexity', 'perplexity.svg' ), array( 'AI Overviews', 'google' ), array( 'Bing', 'fav-bing.com.png' ) ) as $wu_k => $e ) echo '<span class="' . ( 0 === $wu_k ? 'is-on' : '' ) . '">' . $wu_mark( $e[1] ) . esc_html( $e[0] ) . '</span>'; // phpcs:ignore ?></div>
				<div class="seo-card__q"><?php echo $wu_svg( $wu_icons['search'], 18 ); // phpcs:ignore ?><span>best seo company in kerala</span><i></i></div>
				<div class="seo-card__a">
					<small><?php echo $wu_svg( $wu_icons['spark'], 14 ); // phpcs:ignore ?>ChatGPT answer</small>
					<p><b>WiseUp Branding</b> is a Kerala-based SEO company known for technical SEO, content strategy and AI search optimisation, helping businesses get found on Google, Bing and AI assistants.</p>
					<div class="seo-card__src"><span><i></i>wiseup.in</span><span>Cited source</span></div>
				</div>
				<div class="seo-card__st"><div><small>Google</small>Ranked</div><div><small>Bing</small>Indexed</div><div class="is-hi"><small>AI search</small>Recommended</div></div>
			</div>
		</div>
		<div class="logos ev-logos" role="region" aria-label="Client logos"><div class="logos__marquee"><div class="logos__row"><div class="logos__track"><ul><?php echo $wu_li; // phpcs:ignore ?></ul><ul aria-hidden="true"><?php echo str_replace( '" alt="', '" alt="" data-alt="', $wu_li ); // phpcs:ignore ?></ul></div></div></div></div>
	</section>

<?php wiseup_ai_overview( array(
	'q' => 'What does an SEO company in Kerala do?',
	'a' => '<b>WiseUp</b> is an SEO company in Kerala that brings <b>technical optimisation, strategic content, keyword intelligence and competitor analysis</b> together to strengthen your online presence. We build search strategies that position your brand across traditional search engines and AI-powered platforms, helping potential customers find and consider your business.',
	'points' => array(
		array( 'Be found', 'A website that does not appear when customers search for your services misses valuable opportunities.' ),
		array( 'Search is changing', 'We optimise for both traditional search engines and AI-powered platforms.' ),
		array( 'Packages', 'Research and content, website and technical optimisation, authority and performance.' ),
	),
	'links' => array( array( 'Be found', '#visibility' ), array( 'Services', '#services' ), array( 'Platforms', '#platforms' ), array( 'Process', '#process' ), array( 'Packages', '#packages' ), array( 'FAQ', '#faq' ) ),
	'fact' => 'Packages from <b>₹70K</b> onwards',
) ); ?>

	<!-- 2. Be found -->
	<section class="sec ev-sec" id="visibility">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Search visibility' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Be Found Where Your', 'Customers Are Searching' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Search visibility now extends beyond traditional search results. Customers use Google, Bing and AI platforms such as ChatGPT, Gemini and Claude to research businesses, compare services and find solutions. WiseUp combines established SEO practices with emerging AI search optimisation to strengthen your brand’s presence across these discovery channels.</p></div>
			</div>
			<ul class="seo-chans">
				<?php foreach ( $wu_visibility as $v ) echo '<li>' . ( $v[1] ? $wu_mark( $v[1] ) : '<span class="dm-mark">' . $wu_svg( $wu_icons['spark'], 20 ) . '</span>' ) . '<span>' . esc_html( $v[0] ) . '</span></li>'; // phpcs:ignore ?>
			</ul>
			<ul class="pm-grid pm-grid--two">
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons['target'], 24 ); // phpcs:ignore ?></span><h3>How WiseUp Helps</h3><p>We build SEO strategies around your business, not pre-defined packages of optimisation activities. Our team assesses your business objectives, target audience, competitors, search demand and website performance to identify where the strongest opportunities lie. Every recommendation is connected to a clear objective: improve organic visibility, attract relevant traffic, increase enquiries and support measurable business growth.</p></li>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons['rocket'], 24 ); // phpcs:ignore ?></span><h3>Scale With Search</h3><p>As your business expands, we extend your SEO strategy to match. From new services and product categories to additional locations, markets and search opportunities, we identify the areas where your brand can build a stronger presence. Our approach also adapts to evolving search behaviour, including AI-generated answers and conversational search, keeping your visibility strategy aligned with your business growth.</p><div class="seo-tags"><?php foreach ( array( 'New keywords', 'Locations', 'Services', 'Products', 'Markets', 'AI search' ) as $t ) echo '<span>' . esc_html( $t ) . '</span>'; ?></div></li>
			</ul>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'SEO Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Build Search Visibility With', 'the Right SEO Services' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>WiseUp brings technical SEO, content, keyword strategy, website optimisation and authority building together through a connected approach. Our search engine optimisation services are structured around your website’s requirements and the opportunities within your industry, with each activity contributing to stronger organic performance.</p></div>
			</div>
			<?php
			$wu_list = array();
			foreach ( $wu_services as $s ) {
				$extra = $s[3] ? '<div class="seo-tags">' . implode( '', array_map( function ( $t ) { return '<span>' . esc_html( $t ) . '</span>'; }, $s[3] ) ) . '</div>' : '';
				$wu_list[] = array( $s[0], $s[2], '<span class="dm-stack__brands">' . implode( '', array_map( $wu_mark, $s[4] ) ) . '</span>', $extra );
			}
			echo $wu_stack( $wu_list, 'services' ); // phpcs:ignore -- escaped in the helper
			?>
		</div>
	</section>

	<!-- 4. Platforms -->
	<section class="sec ev-sec" id="platforms">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Platforms' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Every Platform Needs', 'a Different Approach' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p class="dm-intro-lead">Built to work with your website.</p><p>SEO requirements change depending on how a website is built. WiseUp adapts its SEO approach to your platform, website structure, business model and the way your customers search.</p></div>
			</div>
			<ul class="pm-grid pm-grid--tools">
				<?php foreach ( $wu_platforms as $p ) : ?>
				<li><?php echo $wu_mark( $p[1] ); // phpcs:ignore ?><h3><?php echo esc_html( $p[0] ); ?></h3><p><?php echo esc_html( $p[2] ); ?></p><?php if ( $p[3] ) echo '<div class="seo-tags"><span>' . esc_html( $p[3] ) . '</span></div>'; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 5. Projects -->
	<section class="sec ev-sec" id="work">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'SEO Projects' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'From Strategy', 'to Real Results.' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="seo-proj">
				<?php foreach ( $wu_projects as $wu_i => $pj ) : $tag = $pj[3] ? 'a' : 'div'; $href = $pj[3] ? ' href="' . esc_url( $pj[3] ) . '"' : ''; ?>
				<li<?php echo 0 === $wu_i ? ' class="is-lead"' : ''; ?>><<?php echo $tag . $href; // phpcs:ignore ?> class="seo-proj__in"><img src="<?php echo esc_url( WISEUP_URL . $pj[1] ); ?>" alt="<?php echo esc_attr( $pj[0] . ' project' ); ?>" width="640" height="480" loading="lazy" decoding="async"><span class="seo-proj__t"><?php if ( 0 === $wu_i ) echo '<em>Featured project</em>'; ?><b><?php echo esc_html( $pj[0] ); ?></b><span class="seo-tags"><?php foreach ( $pj[2] as $t ) echo '<span>' . esc_html( $t ) . '</span>'; ?></span></span></<?php echo $tag; ?>></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. Tools -->
	<section class="sec ev-sec" id="tools">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Our stack' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Tools', 'We Work With' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="dm-tools">
				<?php foreach ( $wu_tools as $tl ) echo '<li>' . $wu_mark( $tl[1] ) . '<span>' . esc_html( $tl[0] ) . '</span></li>'; // phpcs:ignore ?>
			</ul>
		</div>
	</section>

	<!-- 7. Process -->
	<section class="sec ev-sec" id="process">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'How we work' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'How We Work to Build', 'Better SEO Results' ); // phpcs:ignore ?></h2>
			</div>
			<div class="dm-tl" data-tl>
				<span class="dm-tl__line" aria-hidden="true"><i></i></span>
				<ol class="dm-tl__list">
					<?php foreach ( $wu_process as $wu_i => $s ) : ?>
					<li class="dm-tl__step"><span class="dm-tl__node" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $s[1] ], 24 ); // phpcs:ignore ?></span><span class="dm-tl__out" aria-hidden="true"><small>Timeline</small><?php echo esc_html( $s[2] ); ?></span><div class="dm-tl__card"><h3><span class="dm-tl__n"><?php echo esc_html( sprintf( '%02d.', $wu_i + 1 ) ); ?></span> <?php echo esc_html( $s[0] ); ?></h3><div class="seo-tags"><?php foreach ( $s[3] as $t ) echo '<span>' . esc_html( $t ) . '</span>'; ?></div></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 8. Packages -->
	<section class="sec ev-sec" id="packages">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'SEO Packages' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'SEO Package Is Built', 'Around a 360° Strategy' ); // phpcs:ignore ?></h2>
					<p class="seo-from">Packages from <strong>₹70K onwards</strong></p>
				</div>
				<div class="ev-intro"><p>A complete SEO strategy needs more than a few website changes. Our packages bring together essential optimisation, content, technical improvements and performance tracking to strengthen your online presence. The scope and deliverables are tailored to your selected package and business requirements.</p></div>
			</div>
			<h3 class="pm-sub">SEO Strategy Includes</h3>
			<ul class="pm-grid pm-grid--tools">
				<?php foreach ( $wu_package as $g ) : ?>
				<li><h3><?php echo esc_html( $g[0] ); ?></h3><ul class="pm-list"><?php foreach ( $g[1] as $it ) echo '<li>' . esc_html( $it ) . '</li>'; ?></ul></li>
				<?php endforeach; ?>
			</ul>
			<div class="pm-band">
				<p class="pm-band__p">Not sure which SEO package fits your business? Choose from our affordable SEO services in Kerala, with scopes tailored to your website, competition and growth priorities. Request a free SEO assessment to identify the right starting point.</p>
				<?php echo $wu_btn( 'Request a Quote', 'teal', $wu_lead ); // phpcs:ignore ?>
			</div>
		</div>
	</section>

	<!-- 9. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'SEO for Businesses', 'Across Industries' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>We develop search strategies for businesses across:</p></div>
			</div>
			<ul class="dm-ind">
				<?php foreach ( $wu_industries as $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_svg( $wu_icons[ $ind[1] ], 22 ); // phpcs:ignore ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 10. Why WiseUp -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Why Choose', 'WiseUp?' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>At WiseUp, we focus on getting your business noticed by the right audience. We bring together strategy, creativity and technical expertise to improve your online visibility and support your business growth. Here’s what makes us a reliable partner.</p></div>
			</div>
			<ul class="pm-grid pm-grid--why">
				<?php foreach ( $wu_why as $w ) : ?>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons[ $w[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 11. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="dm-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="dm-faq-h" class="sh__h"><?php echo $wu_h( 'What Businesses Ask', 'Our SEO Experts' ); // phpcs:ignore ?></h2>
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

	<!-- 12. Final CTA: free SEO assessment -->
			<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Get Your Free', 'SEO Assessment' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Share your website and goals. Our SEO experts will review where you stand on Google, Bing and AI search, and send back a clear plan with a quote.</p>
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
					<label><span>Website</span><input name="company" type="url" autocomplete="url" placeholder="https://"></label>
					<label><span>Email</span><input name="email" type="email" autocomplete="email"></label>
					<label><span>Phone</span><input name="phone" type="tel" required autocomplete="tel"></label>
					<label class="ev-form__wide"><span>What do you need?</span>
						<select name="service" required>
							<option value="" selected disabled>Choose one</option>
							<?php foreach ( $wu_services_select as $s ) echo '<option>' . esc_html( $s ) . '</option>'; ?>
						</select>
					</label>
					<label class="ev-form__wide"><span>Message</span><textarea name="project" rows="4"></textarea></label>
					<input class="ev-hp" name="hp_website" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Request a Quote</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
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
			var msg = ['Services required: ' + v('service'), 'Website: ' + (v('company') || '-'), 'Project: ' + (v('project') || '-')].join('\n');
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


