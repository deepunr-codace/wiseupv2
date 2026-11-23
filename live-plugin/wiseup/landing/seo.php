<?php

/**
 * SEO Company in Kerala ("WiseUp: SEO Company" in the page Template dropdown). Rebuilt in the shared service-page design
 * system (Event Branding / Digital Marketing / Performance pages: assets/css/event-branding.css + digital-marketing.css,
 * .wu-ev .wu-dm .wu-pm); same sections, order and copy as before (the owner's seo agency in kerala.docx).
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'seo';
$wu_title = apply_filters( 'wiseup_landing_title', 'SEO Company in Kerala | WiseUp Marketing Agency' );
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
foreach ( $wu_logos as $f => $alt ) $wu_li .= '<li class="is-tile"><img src="' . esc_url( WISEUP_ASSETS . '/clients/client-logos-2026/' . $f . '.webp' ) . '" alt="' . esc_attr( $alt . ' logo, SEO client of WiseUp' ) . '" loading="lazy" decoding="async"></li>';

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
$wu_visibility = array( array( 'Google Search', 'google' ), array( 'AI Overviews', 'google' ), array( 'Bing', 'bing-logo.svg' ), array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Google Maps', 'googlemaps.svg' ), array( 'Gemini', 'gemini-logo.svg' ), array( 'Copilot', 'copilot.png' ), array( 'Perplexity', 'perplexity.svg' ) );

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
	array( 'WordPress', 'l-wordpress-icon.svg', 'Optimise WordPress websites for technical performance, content structure, indexing, on-page SEO and search visibility.', '' ),
	array( 'WooCommerce', 'l-woocommerce-icon.svg', 'WooCommerce SEO covering product and category optimisation, product search visibility, internal linking, technical issues, structured data and transactional search intent.', 'Dedicated e-commerce SEO' ),
	array( 'Shopify', 'l-shopify.svg', 'Shopify SEO covering collection and product pages, site structure, technical SEO, content optimisation and organic visibility for Shopify stores.', 'Dedicated e-commerce SEO' ),
	array( 'React.js', 'l-react.svg', 'Rendering, crawlable routes and metadata for JavaScript-heavy React applications.', '' ),
	array( 'Next.js', 'l-nextjs-icon.svg', 'SSR and static generation, metadata, sitemaps and Core Web Vitals for Next.js sites.', '' ),
	array( 'Django', 'l-django-icon.svg', 'Clean URL patterns, template-level metadata, sitemaps and performance for Django builds.', '' ),
	array( 'Nest.js', 'l-nestjs.svg', 'Headless and API-driven setups made crawlable, with rendering and structured data handled correctly.', '' ),
	array( 'Node.js', 'l-nodejs-icon.svg', 'Rendering strategy, routing, redirects and page speed for custom Node.js websites.', '' ),
);

// Projects: [ name, image, tags, link ].
$wu_projects = array(
	// [ name, image (plugin path, or '' for a name tile), tags, link, logo (shown on a dark tile instead of a photo) ]
	array( 'Leyali', '', array(), '', 'assets/clients/client-logos-2026/leyali.webp', array( '', '', 'Shopify e-commerce store with a streamlined shopping experience.', 'bag', 'Shopify' ) ),
	array( 'Gloveda', 'assets/landing/img/case-gloveda.webp', array(), '', '', array( '900+', 'Orders in the first 3 months', 'Shopify e-commerce and digital marketing.' ) ),
	array( 'Ikayaa Food Products', '', array(), '', 'assets/clients/client-logos-2026/ikayaa.webp', array( '15+', 'International markets', 'Export-focused B2B website supporting expansion.' ) ),
	array( 'KPG Roofings', 'assets/landing/img/case-kpg.webp', array(), '', '', array( '45+', 'Showrooms connected online', 'Corporate website and digital presence.' ) ),
	array( 'Ceramic Roof Tiles', 'assets/landing/img/case-ceramicrooftiles.webp', array(), '', '', array( '', '', 'Keyword rankings across India.', 'chart', 'India' ) ),
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
$wu_ind_icons = array(
	'bag' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 6h-2c0-2.21-1.79-4-4-4S8 3.79 8 6H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-8 4c0 .55-.45 1-1 1s-1-.45-1-1V8h2v2zm2-6c1.1 0 2 .9 2 2h-4c0-1.1.9-2 2-2zm4 6c0 .55-.45 1-1 1s-1-.45-1-1V8h2v2z"/></svg>',
	'code' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.4 16.6 4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0 4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/></svg>',
	'scale' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m5.25 8.069 2.83-2.827 14.134 14.15-2.83 2.827zm4.236-4.242L12.314.998l5.657 5.656-2.828 2.83zM.999 12.315l2.828-2.829 5.657 5.657-2.828 2.828zM1 21h12v2H1z"/></svg>',
	'cap' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3 1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>',
	'health' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm6 11h-3v3h-2v-3H8v-2h3v-3h2v3h3v2z"/></svg>',
	'home' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 11v10h5v-6h4v6h5V11L8 6z"/><path d="M10 3v1.97l7 5V11h2v2h-2v2h2v2h-2v4h6V3H10zm9 6h-2V7h2v2z"/></svg>',
	'bed' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z"/></svg>',
	'chart' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21 8c-1.45 0-2.26 1.44-1.93 2.51l-3.55 3.56c-.3-.09-.74-.09-1.04 0l-2.55-2.55C12.27 10.45 11.46 9 10 9c-1.45 0-2.27 1.44-1.93 2.52l-4.56 4.55C2.44 15.74 1 16.55 1 18c0 1.1.9 2 2 2 1.45 0 2.26-1.44 1.93-2.51l4.55-4.56c.3.09.74.09 1.04 0l2.55 2.55C12.73 16.55 13.54 18 15 18c1.45 0 2.27-1.44 1.93-2.52l3.56-3.55c1.07.33 2.51-.48 2.51-1.93 0-1.1-.9-2-2-2z"/><path d="m15 9 .94-2.07L18 6l-2.06-.93L15 3l-.92 2.07L12 6l2.08.93zM3.5 11 4 9l2-.5L4 8l-.5-2L3 8l-2 .5L3 9z"/></svg>',
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
	array( 'How much does SEO cost in Kerala?', array( 'SEO services at WiseUp start from ₹70,000 per month. The final cost depends on your website, industry competition, target locations and the scope of work required. We prepare a custom proposal after reviewing your website and business goals.' ) ),
	array( 'When can I expect to see measurable SEO progress?', array( 'SEO typically takes 3–6 months to show measurable progress. The timeline depends on your website’s current performance, competition, technical condition and content requirements. Consistent optimisation helps build search visibility over time.' ) ),
	array( 'Can an SEO company guarantee first-page rankings on Google?', array( 'No ethical SEO company can guarantee first-page rankings because Google controls its search algorithms and ranking systems. At WiseUp, we focus on improving your website’s technical health, content, relevance and authority to strengthen its search performance.' ) ),
	array( 'What services does an SEO company provide?', array( 'An SEO company provides services such as keyword research, technical optimisation, on-page SEO, content development, link building, local SEO and performance tracking.', 'WiseUp also works on AI search visibility and Google AI Overview optimisation.' ) ),
	array( 'Does my business need SEO?', array( 'If your potential customers search online for your products or services, SEO can help them find your business. It improves your website’s visibility, attracts relevant visitors and creates more opportunities for enquiries.' ) ),
);
$wu_services_select = array( 'Free SEO Assessment', 'SEO Package Quote', 'AI SEO & Search Visibility', 'Local SEO', 'WooCommerce / Shopify SEO', 'Something else' );


add_action( 'wp_footer', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $f ) $items[] = array( '@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => implode( ' ', $f[1] ) ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 20 );

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-seo-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-seo">
<main id="main">

	<!-- 1. Hero -->
	<section class="ev-hero dm-hero" data-css-intro>
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
				<div class="seo-card__chips"><?php foreach ( array( array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Gemini', 'googlegemini.svg' ), array( 'Perplexity', 'perplexity.svg' ), array( 'AI Overviews', 'google' ), array( 'Bing', 'fav-bing.com.png' ) ) as $wu_k => $e ) echo '<span data-eng="' . (int) $wu_k . '" class="' . ( 0 === $wu_k ? 'is-on' : '' ) . '">' . $wu_mark( $e[1] ) . esc_html( $e[0] ) . '</span>'; // phpcs:ignore ?></div>
				<div class="seo-card__q"><?php echo $wu_svg( $wu_icons['search'], 18 ); // phpcs:ignore ?><span data-type>best seo company in kerala</span><i></i></div>
				<div class="seo-card__a">
					<small><?php echo $wu_svg( $wu_icons['spark'], 14 ); // phpcs:ignore ?><span data-eng-name>ChatGPT</span>&nbsp;answer</small>
					<p><b>WiseUp Marketing Agency</b><span data-eng-rest> is a Kerala-based SEO company known for technical SEO, content strategy and AI search optimisation, helping businesses get found on Google, Bing and AI assistants.</span></p>
					<div class="seo-card__src"><span><i></i>wiseup.in</span><span>Cited source</span></div>
				</div>
				<div class="seo-card__st"><div><small>Google</small>Ranked</div><div><small>Bing</small>Indexed</div><div class="is-hi"><small>AI search</small>Recommended</div></div>
			</div>
			<div class="seo-check-wrap">
			<div class="seo-check">
				<div class="seo-check__in">
					<div class="seo-check__q"><img src="<?php echo esc_url( WISEUP_URL . 'assets/smm/wiso-icon.gif' ); ?>" alt="Wiso, the WiseUp mascot" width="84" height="84" loading="lazy" decoding="async"><p>How visible is your website on Google, Bing and <span>AI search?</span></p></div>
					<form class="seo-check__f" data-seo-check novalidate>
						<?php echo $wu_svg( $wu_icons['globe'], 18 ); // phpcs:ignore ?>
						<input name="seo_url" type="text" inputmode="url" autocomplete="url" maxlength="300" aria-label="Website URL" placeholder="Enter your website URL">
						<button type="submit" class="seo-check__b">Get My Free Proposal <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></button>
					</form>
				</div>
			</div>
		</div>
			<dl class="ev-proof">
					<?php foreach ( array(
						array( '5', 'K+', 'Keywords ranked for our clients' ),
						array( '8', '+', 'Years with CodeAce' ),
						array( '150', '+', 'Skilled professionals on our team' ),
						array( '5.0', '★', 'Google rating from client reviews' ),
					) as $wu_st ) : ?>
					<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
					<?php endforeach; ?>
				</dl>
		</div>
		<script>(function(){var c=document.querySelector('.wu-seo .seo-card');if(!c||matchMedia('(prefers-reduced-motion: reduce)').matches||!('IntersectionObserver' in window))return;var Q=['best seo company in kerala','seo agency in calicut','who can get my brand recommended by chatgpt?','local seo services near me','woocommerce seo experts in kerala'],A=[' is a Kerala-based SEO company known for technical SEO, content strategy and AI search optimisation, helping businesses get found on Google, Bing and AI assistants.',' works with businesses in Calicut and across Kerala, combining keyword research, on-page SEO and link building to grow organic traffic and enquiries.',' specialises in AI SEO, using AEO and GEO to structure content, entities and citations so brands get recommended by ChatGPT, Gemini and Perplexity.',' offers local SEO services including Google Business Profile optimisation, local citations and review strategy to rank businesses in Maps and the local pack.',' provides dedicated WooCommerce SEO, optimising product and category pages, structured data and site speed to win high-intent shopping searches.'];var el=c.querySelector('[data-type]'),nm=c.querySelector('[data-eng-name]'),rs=c.querySelector('[data-eng-rest]'),ch=[].slice.call(c.querySelectorAll('[data-eng]')),qi=0,t;function eng(n){ch.forEach(function(x,k){x.classList.toggle('is-on',k===n);});if(nm&&ch[n])nm.textContent=ch[n].textContent.trim();if(rs){rs.style.opacity=0;setTimeout(function(){rs.textContent=A[n];rs.style.opacity=1;},250);}}function erase(){if(el.textContent.length){el.textContent=el.textContent.slice(0,-1);t=setTimeout(erase,22);}else{qi=(qi+1)%Q.length;eng(qi%ch.length);type(0);}}function type(i){el.textContent=Q[qi].slice(0,i);if(i<Q[qi].length)t=setTimeout(function(){type(i+1);},55+Math.random()*40);else t=setTimeout(erase,2600);}new IntersectionObserver(function(e){clearTimeout(t);if(e[0].isIntersecting)t=setTimeout(erase,1800);}).observe(c);})();</script>
		<dialog class="seo-rp" data-seo-report aria-labelledby="seo-rp-t">
			<button type="button" class="seo-rp__x" data-rp-close aria-label="Close"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
			<div data-rp-step>
				<p class="seo-rp__k"><span aria-hidden="true"></span>Free SEO report</p>
				<h2 class="seo-rp__t" id="seo-rp-t">We will send you a free report</h2>
				<p class="seo-rp__s">Our team checks how <b data-rp-host>your website</b> shows up on Google, Bing and AI search, and sends the report to you. Free, no obligation.</p>
				<form class="seo-rp__f" data-rp-form novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>">
					<label class="seo-rp__l">Website<input name="website" type="text" inputmode="url" autocomplete="url" maxlength="300" required></label>
					<label class="seo-rp__l">Full name<input name="name" type="text" autocomplete="name" placeholder="Your name" required></label>
					<div class="seo-rp__row">
						<label class="seo-rp__l">Email<input name="email" type="email" autocomplete="email" placeholder="you@company.com" required></label>
						<label class="seo-rp__l">Phone<input name="phone" type="tel" autocomplete="tel" inputmode="tel" placeholder="+91 98765 43210" pattern="[0-9+()\s-]{7,}" required></label>
					</div>
					<input class="seo-rp__hp" name="hp_website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true">
					<button type="submit" class="seo-check__b seo-rp__b">Send me the free report <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></button>
					<p class="seo-rp__n" data-rp-note aria-live="polite"></p>
				</form>
			</div>
			<div class="seo-rp__done" data-rp-done hidden>
				<span class="seo-rp__ok" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg></span>
				<h2 class="seo-rp__t">Thank you, your request is in</h2>
				<p class="seo-rp__s">We will send the free report for <b data-rp-host>your website</b> to <b data-rp-mail></b>.</p>
				<button type="button" class="seo-check__b seo-rp__b" data-rp-close>Done</button>
			</div>
		</dialog>
		<script>(function(){
var f=document.querySelector('[data-seo-check]'),d=document.querySelector('[data-seo-report]');if(!f||!d)return;
var rf=d.querySelector('[data-rp-form]'),note=d.querySelector('[data-rp-note]'),step=d.querySelector('[data-rp-step]'),done=d.querySelector('[data-rp-done]'),send=rf.querySelector('button[type=submit]'),web=rf.elements.website;
function host(u){return String(u).trim().replace(/^https?:\/\//i,'').replace(/^www\./i,'').replace(/\/.*$/,'')||'your website';}
function setHost(u){[].forEach.call(d.querySelectorAll('[data-rp-host]'),function(b){b.textContent=host(u);});}
function close(){d.close();}
f.addEventListener('submit',function(e){e.preventDefault();var i=f.querySelector('input'),u=(i.value||'').trim();if(!u){i.focus();i.classList.add('is-err');setTimeout(function(){i.classList.remove('is-err');},900);return;}
web.value=u;setHost(u);step.hidden=false;done.hidden=true;note.textContent='';note.className='seo-rp__n';
d.showModal();setTimeout(function(){(rf.elements.name.value?rf.elements.email:rf.elements.name).focus();},50);});
web.addEventListener('input',function(){setHost(web.value);});
[].forEach.call(d.querySelectorAll('[data-rp-close]'),function(b){b.addEventListener('click',close);});
d.addEventListener('click',function(e){if(e.target===d)close();});
rf.addEventListener('submit',function(e){e.preventDefault();
var bad=[].filter.call(rf.querySelectorAll('input:not(.seo-rp__hp)'),function(el){el.classList.remove('is-bad');return !el.checkValidity();});
if(bad.length){bad.forEach(function(el){el.classList.add('is-bad');});bad[0].focus();note.className='seo-rp__n is-err';note.textContent=bad[0].validity.valueMissing?'Please fill in the highlighted fields.':'Please check the highlighted field.';return;}
if(rf.elements.hp_website.value)return;
var v=function(n){return rf.elements[n].value.trim();},site=v('website');
send.disabled=true;note.className='seo-rp__n';note.textContent='Sending…';
fetch(rf.dataset.endpoint,{method:'POST',headers:{'Content-Type':'application/json','X-WP-Nonce':rf.dataset.nonce},body:JSON.stringify({name:v('name'),email:v('email'),phone:v('phone'),service:'Free SEO report',message:'Free SEO report requested for: '+site,page:location.pathname,source:'seo'})})
.then(function(r){return r.json().catch(function(){return {};}).then(function(j){if(!r.ok||(j&&j.ok===false))throw 0;});})
.then(function(){d.querySelector('[data-rp-mail]').textContent=v('email');step.hidden=true;done.hidden=false;note.textContent='';f.reset();})
.catch(function(){note.className='seo-rp__n is-err';note.textContent='Could not send right now. ';var a=document.createElement('a');a.target='_blank';a.rel='noopener';a.textContent='Send it on WhatsApp instead';a.href=<?php echo wp_json_encode( $wu_wa ); ?>.split('?')[0]+'?text='+encodeURIComponent('Hi WiseUp, please send me a free SEO report for '+site+'.\nName: '+v('name')+'\nEmail: '+v('email')+'\nPhone: '+v('phone'));note.append(a);})
.then(function(){send.disabled=false;});});
})();</script>
	</section>

<?php wiseup_ai_overview( array(
	'q' => 'What does an SEO company in Kerala do?',
	'a' => 'An SEO company in Kerala helps a business get found on Google, Google Maps and AI search tools. The work usually covers a technical website audit, keyword and competitor research, on-page and content optimisation, local SEO (Google Business Profile, citations, reviews) and regular reporting on rankings, traffic and enquiries.',
	'points' => array(
		array( 'Audit first', 'We check crawlability, speed, mobile usability, indexing and on-page issues before changing anything.' ),
		array( 'Content and keywords', 'We map search terms to pages and build content that answers what customers actually ask.' ),
		array( 'Local and AI visibility', 'We optimise your Maps listing, citations and reviews, and structure content so AI tools can quote it accurately.' ),
		array( 'Reporting', 'You get monthly reports covering rankings, organic traffic, leads and next steps.' ),
	),
	'note' => 'Results depend on competition and your starting point. Get a free audit of your site and we’ll show you what to fix first.',
	'cta' => 'Get a free audit',
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
			<script>(function(){var u=document.querySelector('.wu-seo .seo-chans');if(!u||matchMedia('(prefers-reduced-motion: reduce)').matches)return;var w=document.createElement('div');w.className='seo-chans-run';u.parentNode.insertBefore(w,u);w.appendChild(u);var c=u.cloneNode(true);c.setAttribute('aria-hidden','true');w.appendChild(c);w.classList.add('is-on');})();</script>
			<div class="seo-vorb" aria-hidden="true"><span class="seo-vorb__core"><img src="<?php echo esc_url( WISEUP_URL . 'assets/smm/wiso-icon.gif' ); ?>" alt="" width="120" height="120" loading="lazy" decoding="async"></span><span class="seo-vorb__ring"></span><span class="seo-vorb__ring seo-vorb__ring--2"></span></div>
			<script>(function(){var o=document.querySelector('.seo-vorb');var src=[].slice.call(document.querySelectorAll('.wu-seo #visibility .seo-chans:not([aria-hidden]) li'));if(!o||!src.length)return;var n=src.length;src.forEach(function(li,k){var a=k/n*2*Math.PI-Math.PI/2,el=document.createElement('span');el.className='seo-vorb__i';el.style.left=(50+42*Math.cos(a))+'%';el.style.top=(50+42*Math.sin(a))+'%';el.style.setProperty('--d',(k*-.6)+'s');var m=li.querySelector('.dm-mark');var t=(li.querySelector('span:not(.dm-mark)')||{}).textContent||'';el.innerHTML='<span class="seo-vorb__b">'+(m?m.outerHTML:'')+'<em>'+t.replace(/</g,'&lt;')+'</em></span>';o.appendChild(el);});})();</script>
			<ul class="pm-grid pm-grid--two">
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons['target'], 24 ); // phpcs:ignore ?></span><h3>How WiseUp Helps</h3><p>We build SEO strategies around your business, not pre-defined packages of optimisation activities. Our team assesses your business objectives, target audience, competitors, search demand and website performance to identify where the strongest opportunities lie. Every recommendation is connected to a clear objective: improve organic visibility, attract relevant traffic, increase enquiries and support measurable business growth.</p></li>
				<li><span class="pm-ic"><?php echo $wu_svg( $wu_icons['rocket'], 24 ); // phpcs:ignore ?></span><h3>Scale With Search</h3><p>As your business expands, we extend your SEO strategy to match. From new services and product categories to additional locations, markets and search opportunities, we identify the areas where your brand can build a stronger presence. Our approach also adapts to evolving search behaviour, including AI-generated answers and conversational search, keeping your visibility strategy aligned with your business growth.</p><div class="seo-tags"><?php foreach ( array( 'New keywords', 'Locations', 'Services', 'Products', 'Markets', 'AI search' ) as $t ) echo '<span>' . esc_html( $t ) . '</span>'; ?></div></li>
			</ul>
			<script>(function(){var u=document.querySelector('.wu-seo #visibility .pm-grid--two');if(!u)return;u.classList.add('is-tabs');var li=[].slice.call(u.children);var on=function(x){li.forEach(function(l){l.classList.toggle('is-on',l===x);var h=l.querySelector('h3');h.setAttribute('aria-selected',l===x?'true':'false');});};li.forEach(function(l){var h=l.querySelector('h3');h.setAttribute('role','tab');h.setAttribute('tabindex','0');h.addEventListener('click',function(){on(l);});h.addEventListener('keydown',function(e){if(e.key==='Enter'||e.key===' '){e.preventDefault();on(l);}});});u.setAttribute('role','tablist');on(li[0]);})();</script>
			<script>(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var ps=[].slice.call(document.querySelectorAll('.wu-seo #visibility .pm-grid--two p'));var ws=[];ps.forEach(function(p){var t=p.textContent;p.setAttribute('aria-label',t);p.innerHTML=t.split(/(\s+)/).map(function(w){return /^\s+$/.test(w)?w:'<span class="seo-w" aria-hidden="true">'+w.replace(/</g,'&lt;')+'</span>';}).join('');ws=ws.concat([].slice.call(p.querySelectorAll('.seo-w')));});var raf=0,run=function(){raf=0;var h=innerHeight*.72;ws.forEach(function(w){var r=w.getBoundingClientRect();w.classList.toggle('is-lit',r.top<h);});document.querySelectorAll('.wu-seo #visibility .pm-grid--two > li').forEach(function(li){var r=li.getBoundingClientRect();li.classList.toggle('is-hl',r.top<innerHeight*.8);});};addEventListener('scroll',function(){if(!raf)raf=requestAnimationFrame(run);},{passive:true});run();})();</script>
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
	
	

	<!-- 4. Platforms -->
	<section class="sec ev-sec" id="platforms">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Platforms' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Every Platform Needs', 'a Different Approach' ); // phpcs:ignore ?></h2>
					<p class="dm-intro-lead seo-built" data-built>Built to work with <span class="seo-built__w">your website</span>.</p><script>(function(){var e=document.querySelector('[data-built]');if(!e)return;if(!('IntersectionObserver' in window)){e.classList.add('is-in');return;}var o=new IntersectionObserver(function(x){if(x[0].isIntersecting){e.classList.add('is-in');o.disconnect();}},{threshold:.6});o.observe(e);})();</script>
				</div>
				<div class="ev-intro"><p>SEO requirements change depending on how a website is built. WiseUp adapts its SEO approach to your platform, website structure, business model and the way your customers search.</p></div>
			</div>
			<ul class="seo-pc" data-pc>
				<?php foreach ( $wu_platforms as $wu_k => $p ) : ?>
				<li class="seo-pc__c">
					<div class="seo-pc__top"><span class="seo-pc__lg"><?php echo $wu_mark( $p[1] ); // phpcs:ignore ?></span><span class="seo-pc__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_k + 1 ) ); ?></span></div>
					<h3><?php echo esc_html( $p[0] ); ?></h3>
				</li>
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
				<li<?php echo 0 === $wu_i ? ' class="is-lead"' : ''; ?><?php echo ! empty( $pj[5] ) ? ' tabindex="0"' : ''; ?>><<?php echo $tag . $href; // phpcs:ignore ?> class="seo-proj__in"><?php if ( $pj[1] ) : ?><img src="<?php echo esc_url( WISEUP_URL . $pj[1] ); ?>" alt="<?php echo esc_attr( $pj[0] . ' SEO project by WiseUp, Kerala' ); ?>" width="640" height="800" loading="lazy" decoding="async"><?php elseif ( $pj[4] ) : ?><span class="seo-proj__ph is-logo"><img src="<?php echo esc_url( WISEUP_URL . $pj[4] ); ?>" alt="<?php echo esc_attr( $pj[0] . ' logo, SEO project by WiseUp, Kerala' ); ?>" loading="lazy" decoding="async"></span><?php else : ?><span class="seo-proj__ph" aria-hidden="true"><i><?php echo esc_html( mb_substr( $pj[0], 0, 1 ) ); ?></i></span><?php endif; ?><?php if ( ! empty( $pj[5] ) ) : ?><span class="seo-proj__st<?php echo $pj[5][0] ? '' : ' is-line'; ?>"><?php if ( ! $pj[5][0] && ! empty( $pj[5][3] ) ) : ?><i class="seo-proj__ic"><?php echo $wu_svg( $wu_icons[ $pj[5][3] ], 26 ); // phpcs:ignore ?></i><?php endif; ?><?php if ( $pj[5][0] ) : ?><strong><?php echo esc_html( $pj[5][0] ); ?></strong><small><?php echo esc_html( $pj[5][1] ); ?></small><?php endif; ?><span><?php echo ! empty( $pj[5][4] ) ? str_replace( esc_html( $pj[5][4] ), '<b>' . esc_html( $pj[5][4] ) . '</b>', esc_html( $pj[5][2] ) ) : esc_html( $pj[5][2] ); // phpcs:ignore ?></span></span><?php endif; ?><span class="seo-proj__t"><b><?php echo esc_html( $pj[0] ); ?></b><span class="seo-tags"><?php foreach ( $pj[2] as $t ) echo '<span>' . esc_html( $t ) . '</span>'; ?></span></span></<?php echo $tag; ?>></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. Tools (the original SEO page's two-ring stack) -->
	<section class="sec ev-sec seo-stk" id="tools">
		<div class="wrap">
			<div class="sh seo-stk__sh">
				<?php echo $wu_eyebrow( 'Our stack' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Tools', 'We Work With' ); // phpcs:ignore ?></h2>
			</div>
			<?php
			$wu_tile = function ( $tl ) use ( $wu_mark ) { return '<span class="seo-stk__t">' . $wu_mark( $tl[1] ) . '</span><span class="seo-stk__n">' . esc_html( $tl[0] ) . '</span>'; };
			$wu_ring = function ( $list, $cls ) use ( $wu_tile ) {
				$n = count( $list ); $o = '<div class="seo-stk__ring seo-stk__ring--' . $cls . '">';
				foreach ( array_values( $list ) as $k => $tl ) {
					$a = deg2rad( -90 + 360 * $k / $n + ( 'in' === $cls ? 45 : 0 ) );
					$o .= '<div class="seo-stk__at" style="left:' . round( 50 + 50 * cos( $a ), 2 ) . '%;top:' . round( 50 + 50 * sin( $a ), 2 ) . '%"><div class="seo-stk__it">' . $wu_tile( $tl ) . '</div></div>';
				}
				return $o . '</div>';
			};
			?>
			<div class="seo-stk__orb">
				<?php echo $wu_ring( array_slice( $wu_tools, 0, 6 ), 'out' ) . $wu_ring( array_slice( $wu_tools, 6 ), 'in' ); // phpcs:ignore ?>
				<div class="seo-stk__core"><img src="<?php echo esc_url( WISEUP_URL . 'assets/smm/wiso-icon.gif' ); ?>" alt="Wiso, the WiseUp mascot" width="120" height="120" loading="lazy" decoding="async"><span>WiseUp<br>SEO Stack</span></div>
			</div>
			<ul class="seo-stk__grid">
				<?php foreach ( $wu_tools as $tl ) echo '<li>' . $wu_tile( $tl ) . '</li>'; // phpcs:ignore ?>
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
			<div class="seo-grow" data-grow>
				<svg class="seo-grow__g" viewBox="0 0 1200 300" preserveAspectRatio="none" aria-hidden="true">
					<defs><linearGradient id="seo-grow-f" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#beda52" stop-opacity=".28"/><stop offset="1" stop-color="#beda52" stop-opacity="0"/></linearGradient></defs>
					<path class="seo-grow__area" d="M0 290 C 180 285, 300 262, 400 240 S 650 175, 800 140 S 1050 40, 1200 12 L 1200 300 L 0 300 Z"/>
					<path class="seo-grow__line" d="M0 290 C 180 285, 300 262, 400 240 S 650 175, 800 140 S 1050 40, 1200 12" pathLength="1"/>
					<line x1="400" y1="0" x2="400" y2="300"/><line x1="800" y1="0" x2="800" y2="300"/>
					
				</svg>
				<span class="seo-grow__dot" style="left:33.33%;top:calc(var(--gh) * .8)" aria-hidden="true"></span><span class="seo-grow__dot" style="left:66.67%;top:calc(var(--gh) * .4667)" aria-hidden="true"></span><span class="seo-grow__dot is-end" style="left:100%;top:calc(var(--gh) * .04)" aria-hidden="true"></span>
				<ol class="seo-grow__stages">
					<?php foreach ( $wu_process as $wu_i => $s ) : ?>
					<li style="--k:<?php echo (int) $wu_i; ?>">
						<span class="seo-grow__m"><?php echo esc_html( $s[2] ); ?></span>
						<h3><?php echo esc_html( $s[0] ); ?></h3>
						<ul><?php foreach ( $s[3] as $t ) echo '<li>' . esc_html( $t ) . '</li>'; ?></ul>
					</li>
					<?php endforeach; ?>
				</ol>
			</div>
			<script>(function(){var g=document.querySelector('[data-grow]');if(!g)return;if(!('IntersectionObserver' in window)||matchMedia('(prefers-reduced-motion: reduce)').matches){g.classList.add('is-in');return;}g.classList.add('is-js');var io=new IntersectionObserver(function(e){if(e[0].isIntersecting){g.classList.add('is-in');io.disconnect();}},{threshold:.25});io.observe(g);})();</script>
		</div>
	</section>

	<!-- 8. Packages (same pricing + package layout as the Digital Marketing page) -->
	<section class="sec ev-sec" id="packages">
		<div class="wrap">
			<div class="ev-disc">
				<div class="ev-disc__l">
					<div class="sh">
						<?php echo $wu_eyebrow( 'SEO Packages' ); // phpcs:ignore ?>
						<h2 class="sh__h"><?php echo $wu_h( 'SEO Package Is Built', 'Around a 360° Strategy' ); // phpcs:ignore ?></h2>
					</div>
					<div class="ev-price ev-price--col">
						<p>A complete SEO strategy needs more than a few website changes. Our packages bring together essential optimisation, content, technical improvements and performance tracking to strengthen your online presence. The scope and deliverables are tailored to your selected package and business requirements.</p>
					</div>
				</div>
				<div class="ev-disc__card">
					<span class="ev-disc__pill">SEO Packages</span>
					<p class="ev-disc__from"><span>Packages from</span><strong>₹70K onwards</strong></p>
					<?php echo $wu_btn( 'Request a Quote', 'teal', $wu_lead ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="dm-pkg">
				<div class="dm-pkg__table">
					<h3>SEO Packages Include</h3>
					<ul class="dm-pkg__chips">
						<?php $wu_pk_ic = array( 'search', 'tool', 'chart' ); foreach ( $wu_package as $wu_k => $g ) : ?>
						<li><span class="dm-pkg__ic"><?php echo $wu_svg( $wu_icons[ $wu_pk_ic[ $wu_k ] ?? 'spark' ], 22 ); // phpcs:ignore ?></span><span><?php echo esc_html( $g[0] ); ?></span><small class="dm-pkg__d"><?php echo esc_html( implode( ' · ', $g[1] ) ); ?></small><button type="button" class="dm-pkg__sw" role="switch" aria-checked="true" aria-label="<?php echo esc_attr( $g[0] ); ?>"><i></i></button></li>
						<?php endforeach; ?>
					</ul>
					<script>(function(){var u=document.querySelector('.dm-pkg__chips');if(!u||!('IntersectionObserver' in window))return;var io=new IntersectionObserver(function(e){if(e[0].isIntersecting){u.classList.add('is-lit');io.disconnect();}},{threshold:.5});io.observe(u);})();</script>
					<script>document.querySelectorAll('.dm-pkg__sw').forEach(function(b){b.addEventListener('click',function(){var on=b.getAttribute('aria-checked')!=='true';b.setAttribute('aria-checked',on?'true':'false');b.closest('li').classList.toggle('is-off',!on);});});</script>
				</div>
			</div>
			<div class="seo-pkcta">
				<p>Not sure which SEO package fits your business? Choose from our affordable SEO services in Kerala, with scopes tailored to your website, competition and growth priorities. Request a free SEO assessment to identify the right starting point.</p>
				<?php echo $wu_btn( 'Request a Quote', 'night', $wu_lead ); // phpcs:ignore ?>
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
			<ul class="dm-ind seo-ind">
				<?php foreach ( $wu_industries as $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_ind_icons[ $ind[1] ]; // phpcs:ignore ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
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
			<script>(function(){var u=document.querySelector('.wu-seo .pm-grid--why');if(!u)return;u.classList.add('is-rows');var li=[].slice.call(u.children);var on=function(x){li.forEach(function(l){l.classList.toggle('is-on',l===x);});};on(li[0]);li.forEach(function(l){l.addEventListener('mouseenter',function(){on(l);});l.addEventListener('click',function(){on(l);});});if('IntersectionObserver' in window&&!matchMedia('(hover: hover)').matches){var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting)on(e.target);});},{rootMargin:'-45% 0px -45% 0px'});li.forEach(function(l){io.observe(l);});}})();</script>
		</div>
	</section>


	<!-- 11. Client experiences (same reviews as the Digital Marketing page) -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="sh"><h2 class="sh__h"><?php echo $wu_h( 'Beyond Campaigns:', 'Client Experiences' ); // phpcs:ignore ?></h2></div>
			<?php include WISEUP_DIR . 'landing/reviews.php'; ?>
		</div>
	</section>

	<!-- FAQ (owner's five questions, with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="seo-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="seo-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
			</div>
			<div class="faq">
				<?php foreach ( $wu_faq as $f ) : ?>
				<details class="faq__item" name="faq">
					<summary class="faq__q"><h3><?php echo esc_html( $f[0] ); ?></h3><span class="faq__dot" aria-hidden="true"></span></summary>
					<div class="faq__a"><?php foreach ( $f[1] as $para ) echo '<p>' . esc_html( $para ) . '</p>'; ?></div>
				</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php wiseup_other_services( 'wiseup-seo' ); ?>


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


