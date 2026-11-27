<?php
/**
 * Website Development Company in Kerala ("WiseUp: Web Development" in the page Template dropdown).
 * Copy = the owner's final content (Downloads/website development company in kerala (1).docx, 2026-11-27), word for word.
 * Earlier structure = the owner's brief (Downloads/website development company in kerala.docx, 2026-11-26): its headings, order,
 * hook line and CTA labels are used as given; the doc gives writer instructions, not copy, so the body copy is written from them.
 * First pass: the structure in the shared service-page design system (event-branding.css, digital-marketing.css, branding.css,
 * service-system.css) plus this page's own pieces in assets/css/web-development.css (.wd-*). Creative pass to follow.
 * Kept though not in the doc: hero stats strip, AI Overview, Chat on WhatsApp tile, the Other services carousel.
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'web-development';
$wu_title = apply_filters( 'wiseup_landing_title', 'Website Development Company in Kerala | WordPress, Shopify & Custom Websites' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is a website development company in Kerala, based in Kozhikode. Custom, WordPress, e-commerce and business websites, landing pages and redesigns. Discuss your website with us.' );
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
	foreach ( array( 'event-branding.css', 'digital-marketing.css', 'branding.css', 'service-system.css', 'web-development.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/' . $css . '?ver=' . filemtime( WISEUP_DIR . 'assets/css/' . $css ) ) . "\">\n";
	}
}, 8 );

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to discuss a website project.' );
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
	'code'    => '<path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 5l-4 14"/>',
	'wp'      => '<circle cx="12" cy="12" r="9"/><path d="M5.5 8.5 9.5 19l2.5-7M8 8.5h4M14.5 8.5h3.5M15.5 8.5 18 15.5l-2.5 3.5"/>',
	'cart'    => '<path d="M3 4h2l2.4 11h10.2L20 7H6.2"/><circle cx="9" cy="19.5" r="1.4"/><circle cx="17" cy="19.5" r="1.4"/>',
	'office'  => '<path d="M4 21V5l8-2v18M12 8h8v13M4 21h16M7.5 8h1M7.5 12h1M7.5 16h1M15.5 12h1M15.5 16h1"/>',
	'target'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.3"/>',
	'refresh' => '<path d="M20 11a8 8 0 0 0-14.6-4.5L4 8M4 4v4h4M4 13a8 8 0 0 0 14.6 4.5L20 16M20 20v-4h-4"/>',
	'layout'  => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11"/>',
	'nav'     => '<path d="M4 6h16M4 12h10M4 18h6"/><path d="m17 15 3 3-3 3"/>',
	'devices' => '<rect x="2" y="5" width="14" height="10" rx="1.5"/><path d="M6 19h6M9 15v4"/><rect x="17" y="9" width="5" height="10" rx="1"/>',
	'type'    => '<path d="M4 7V5h16v2M12 5v14M9 19h6"/>',
	'hand'    => '<path d="M9 11V5.5a1.5 1.5 0 0 1 3 0V10M12 10V4.5a1.5 1.5 0 0 1 3 0V10M15 10V6.5a1.5 1.5 0 0 1 3 0V14a7 7 0 0 1-7 7h-.5a6 6 0 0 1-5-2.7L3 15a1.5 1.5 0 0 1 2.5-1.7L9 16"/>',
	'brand'   => '<path d="M12 3a9 9 0 1 0 0 18c1.5 0 2-1 1.5-2-.6-1.3.3-2.5 1.7-2.5H17a4 4 0 0 0 4-4C21 6.6 17 3 12 3z"/><circle cx="7.5" cy="11" r="1.1"/><circle cx="10" cy="7" r="1.1"/><circle cx="14.5" cy="7" r="1.1"/>',
	'speed'   => '<path d="M4 18a8 8 0 1 1 16 0"/><path d="m12 18 4-6"/><path d="M4 18h16"/>',
	'search'  => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/>',
	'shield'  => '<path d="M12 3 4 6v6c0 5 3.4 8 8 9 4.6-1 8-4 8-9V6z"/><path d="m8.5 12 2.5 2.5L16 9.5"/>',
	'chat'    => '<path d="M4 5h16v10H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
	'map'     => '<path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2z"/><path d="M9 4v14M15 6v14"/>',
	'pen'     => '<path d="M4 20c4-1 6-3 7-6"/><path d="M14 4l6 6-8 8-6-6z"/>',
	'check'   => '<circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.6 2.6L16 9.5"/>',
	'rocket'  => '<path d="M5 15c-1.5 1.5-2 5-2 5s3.5-.5 5-2M9 15l-3-3c1-4 4.5-8 12-9-1 7.5-5 11-9 12z"/><circle cx="14.5" cy="9.5" r="1.6"/>',
	'stack'   => '<path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/>',
	'users'   => '<circle cx="9" cy="8" r="3.2"/><path d="M3 19c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M15.5 13.6c3 .2 5.5 2.6 5.5 5.4"/>',
);

// Services (doc H3s, 40-60 words each): [ title, icon, text, platform tags ].
$wu_services = array(
	array( 'Custom Website Development', 'code', 'Some projects need more than a standard template. Custom website development makes it possible to create layouts, features, and functionality around specific business requirements. From the initial structure to the final build, each element is planned to support the website\'s purpose and provide a consistent experience for visitors.', array() ),
	array( 'WordPress Website Development', 'wp', 'WordPress provides a flexible platform for business websites, service pages and content-driven websites. WiseUp develops WordPress websites with customised layouts, suitable themes and relevant plugins. The content management system also makes it easier for authorised users to update website pages, images and other content without changing the underlying website structure.', array() ),
	array( 'E-commerce Website Development', 'cart', 'An online store needs more than an attractive product display. It needs a smooth shopping experience from product browsing to checkout. WiseUp works on e-commerce website design and development, including product catalogues, product pages, shopping carts, and payment gateway integration. Platforms such as Shopify and WooCommerce can support different online store requirements.', array() ),
	array( 'Business and Corporate Website Development', 'office', 'A business website should make company information easy to find and understand. WiseUp develops websites for businesses and professional organisations, with dedicated sections for services, company information, projects and contact details. Clear page structures and enquiry options help visitors find relevant information and take the next step.', array() ),
	array( 'Landing Page Development', 'target', 'A landing page gives a specific campaign, service or promotion a focused online destination. Its content and layout are organised around a clear message and action. WiseUp develops landing pages with relevant information, engaging visuals, enquiry forms and calls to action to support advertising campaigns and lead generation.', array() ),
	array( 'Website Redesign and Development', 'refresh', 'An outdated website can make information difficult to access and affect the overall browsing experience. A redesign can improve page layouts, navigation, mobile responsiveness and functionality while retaining relevant content. Where required, the process can also include content migration and careful handling of existing URLs.', array() ),
);

// Design that makes navigation feel natural (doc points): [ title, icon, text ].
$wu_design = array(
	array( 'UI/UX design and page layouts', 'layout', 'Layouts planned around what visitors need to see first, and what they look for next.' ),
	array( 'Clear navigation and hierarchy', 'nav', 'Menus and headings that make it obvious where each piece of information lives.' ),
	array( 'Responsive across devices', 'devices', 'Pages that work as well on a phone or tablet as on a desktop screen.' ),
	array( 'Readable type and consistent visuals', 'type', 'Typography, imagery and spacing that stay consistent from page to page.' ),
	array( 'Accessible, intuitive interactions', 'hand', 'Buttons, forms and links that behave the way people expect them to.' ),
	array( 'Consistent with your brand', 'brand', 'Colours, type and visual style that match the identity your customers already know.' ),
);

// Platforms and technologies (doc lists): [ name, logo file in assets/landing/img/icons/ ].
$wu_platforms = array( array( 'WordPress', 'l-wordpress-icon.svg' ), array( 'Shopify', 'l-shopify.svg' ), array( 'WooCommerce', 'l-woocommerce-icon.svg' ), array( 'Strapi', 'l-strapi-icon.svg' ) );
$wu_tech      = array( array( 'HTML', 'l-html-5.svg' ), array( 'CSS', 'l-css-3.svg' ), array( 'JavaScript', 'l-javascript.svg' ), array( 'PHP', 'l-php.svg' ), array( 'Laravel', 'l-laravel.svg' ), array( 'React', 'l-react.svg' ), array( 'Next.js', 'l-nextjs-icon.svg' ) );

// What goes into a well-developed website (doc H3s): [ title, icon, text ].
$wu_quality = array(
	array( 'Responsive Website Structure', 'devices', 'A well-designed website adjusts to different screen sizes while keeping its content clear and easy to navigate. Responsive development supports a consistent experience across desktops, tablets, and mobile phones.' ),
	array( 'Website Speed and Performance', 'speed', 'Slow-loading pages can interrupt the browsing experience. Image optimisation, efficient code and suitable development practices help improve loading performance and make website interactions smoother.' ),
	array( 'SEO-Friendly Website Structure', 'search', 'Search-friendly development starts with a clear page hierarchy, descriptive URLs, suitable metadata, and crawlable content. Elements such as heading structures and XML sitemaps also support search engine discovery. These elements support SEO but don\'t guarantee rankings.' ),
	array( 'Security and Functionality', 'shield', 'Website security and reliable functionality are important throughout development. SSL configuration, secure forms, and relevant updates help protect website interactions. Testing also checks links, navigation, forms, and integrations before launch.' ),
);

// Process (doc): [ title, icon, text ].
$wu_process = array(
	array( 'Requirement Gathering', 'chat', 'The process begins with business objectives, audience expectations, website requirements, and the functionality needed for the project.' ),
	array( 'Planning and Structure', 'map', 'The sitemap, page hierarchy, content requirements, and user journey are mapped out to establish a clear website structure.' ),
	array( 'Design and Prototyping', 'pen', 'Page layouts and design concepts are prepared for review. This stage helps establish the visual direction and structure before development begins.' ),
	array( 'Website Development', 'code', 'The approved designs are developed using the selected platform and technologies. Required features, integrations, and content management functions are configured as part of the build.' ),
	array( 'Testing and Review', 'check', 'The website is checked across different screen sizes and browsers. Forms, links, navigation, functionality, and performance are reviewed before launch.' ),
	array( 'Launch and Handover', 'rocket', 'Once approved, the website is made ready for publication. Access details and guidance for managing website content can be provided as part of the agreed handover.' ),
);

// Industries (doc): [ name, text, icon paths ].
$wu_ind = array(
	array( 'E-commerce and Retail', 'Product catalogues, shopping carts, payment options and online purchasing experiences.', '<path d="M5 8h14l-1 12H6z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>' ),
	array( 'Education and Training', 'Course information, programme pages, admission enquiries and registration features.', '<path d="m2 9 10-5 10 5-10 5z"/><path d="M6 11v5c3 2.5 9 2.5 12 0v-5"/>' ),
	array( 'Healthcare and Wellness', 'Service information, practitioner profiles, appointment enquiries and accessible navigation.', '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/><path d="M7 11h3l1.5-2 2 4 1.5-2h2"/>' ),
	array( 'Real Estate', 'Property listings, project information, image galleries and enquiry forms.', '<path d="M4 21V9l8-5 8 5v12"/><path d="M9 21v-6h6v6"/>' ),
	array( 'Hospitality and Travel', 'Accommodation or service details, location information and booking enquiries.', '<path d="M3 18h18M5 18v-5a7 7 0 0 1 14 0v5M12 6V4M10 4h4"/>' ),
	array( 'B2B and Professional Services', 'Company profiles, service pages, project information and business enquiry forms.', '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5h6v2M3 13h18"/>' ),
);

// Projects (website work already shown on the SEO page; figures from the CodeAce Website & SEO brochure):
// [ name, industry, website type, platform, what we delivered, figure, figure label, image (plugin path), logo (plugin path) ].
$wu_projects = array(
	array( 'KPG Roofings', '', '', '', '', '', '', 'assets/landing/img/case-kpg.webp', '' ),
	array( 'Ceramic Roof Tiles', '', '', '', '', '', '', 'assets/landing/img/case-ceramicrooftiles.webp', '' ),
	array( 'Inchub', '', '', '', '', '', '', '', '' ),
	array( 'Gloveda', '', '', '', '', '', '', 'assets/landing/img/case-gloveda.webp', '' ),
	array( 'Leyali', '', '', '', '', '', '', '', 'assets/clients/client-logos-2026/leyali.webp', 'dark' ),
	array( 'Ikayaa Food Products', '', '', '', '', '', '', '', 'assets/clients/client-logos-2026/ikayaa.webp' ),
);

// Why WiseUp (doc H3s): [ title, icon, text ].
$wu_why = array(
	array( 'Built Around Business Requirements', 'target', 'Website structure and functionality are planned around the purpose of each project, rather than relying on a standard layout for every business.' ),
	array( 'Design and Development Together', 'stack', 'Visual design, user experience, and technical development are considered as connected parts of the website creation process.' ),
	array( 'The Right Platform for the Website', 'wp', 'Platform and technology choices are based on project requirements, content management needs, and the functionality involved.' ),
	array( 'User-Friendly Website Design', 'users', 'Responsive layouts, clear navigation and organised content make it easier for visitors to move through the website.' ),
	array( 'SEO-Friendly Development', 'search', 'Technical foundations such as page structure, metadata and mobile responsiveness are considered during development to support search engine discovery.' ),
	array( 'Clear Communication and Support', 'chat', 'Project requirements, feedback, and development updates are communicated throughout the process. Handover and post-launch support are discussed according to the agreed project scope.' ),
);

$wu_faq = array(
	array( 'How much does website development cost in Kerala?', 'Website development in Kerala typically costs ₹10,000 to ₹1,00,000 for small and mid-sized business websites. E-commerce websites can cost ₹25,000 to ₹2,00,000 or more, while complex web applications and portals may range from ₹2,00,000 to ₹10,00,000+. The final cost depends on the website type, design, features, integrations, and development requirements. Domain renewal, hosting, maintenance, and premium plugins may involve additional costs.' ),
	array( 'What is the typical timeline for building a business website?', 'A basic business website may take a few weeks to complete, while larger websites with custom designs, multiple pages or advanced functionality can take longer. The timeline depends on the project scope, content readiness and feedback during development.' ),
	array( 'What is the difference between WordPress and Shopify?', 'WordPress is a flexible content management platform suited to business websites, blogs, and customised websites. Shopify is an e-commerce platform designed to manage online stores, products, payments and orders.' ),
	array( 'Can a website be developed based on specific business requirements?', 'Yes. Custom website development allows the design, structure, features, and functionality to be planned around specific business needs, rather than relying entirely on a standard template.' ),
	array( 'Can an e-commerce website include payment gateway integration?', 'Yes. E-commerce websites can include payment gateway integration to accept online payments. Other features may include product catalogues, inventory management, order tracking and shipping integrations, depending on the project requirements.' ),
	array( 'Will the website work on mobile phones and tablets?', 'A responsive website adjusts its layout and content to different screen sizes. This allows visitors to browse and interact with the website across desktops, tablets and mobile phones.' ),
	array( 'Can website content be updated without technical knowledge?', 'Yes. Websites built with a content management system (CMS), such as WordPress, allow authorised users to update text, images, pages and other content through an administrative dashboard.' ),
	array( 'Can an existing website be redesigned or migrated?', 'Yes. An existing website can be redesigned to improve its appearance, navigation, usability and functionality. Website migration can also move content and relevant data to a new platform or hosting environment, depending on the existing setup.' ),
	array( 'Is website maintenance required after launch?', 'Yes. Regular maintenance helps keep a website updated, secure, and functional. It may include software updates, backups, security checks, bug fixes, and performance monitoring.' ),
	array( 'Does website development include SEO?', 'SEO-friendly development can include a clear website structure, mobile responsiveness, fast-loading pages, search-friendly URLs, and technical elements that support crawling and indexing. Ongoing SEO activities, such as content optimisation and link building, are generally handled separately.' ),
);
add_action( 'wp_head', function () use ( $wu_faq ) {
	$items = array();
	foreach ( $wu_faq as $q ) $items[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items ) ) . "</script>\n";
}, 3 );

$wu_addr = wiseup_opt( 'contact_address' );
$wu_map  = wiseup_opt( 'contact_map' );
$wu_logo = function ( $l ) { return '<li class="wd-logo"><span class="wd-logo__i"><img src="' . esc_url( WISEUP_URL . 'assets/landing/img/icons/' . $l[1] ) . '" alt="' . esc_attr( $l[0] . ' logo' ) . '" width="40" height="40" loading="lazy" decoding="async"></span><b>' . esc_html( $l[0] ) . '</b></li>'; };

$wu_shot = function ( $pj, $lazy ) {
	if ( $pj[7] ) return '<img src="' . esc_url( WISEUP_URL . $pj[7] ) . '" alt="' . esc_attr( $pj[0] . ' website project by WiseUp' ) . '" width="720" height="540" ' . ( $lazy ? 'loading="lazy" ' : '' ) . 'decoding="async">';
	if ( ! $pj[8] ) return '<span class="wd-logo-shot is-name"><b>' . esc_html( $pj[0] ) . '</b></span>'; // no image on file yet
	return '<span class="wd-logo-shot' . ( ! empty( $pj[9] ) ? ' is-dark' : '' ) . '"><img src="' . esc_url( WISEUP_URL . $pj[8] ) . '" alt="' . esc_attr( $pj[0] . ' logo, website project by WiseUp' ) . '" ' . ( $lazy ? 'loading="lazy" ' : '' ) . 'decoding="async"></span>';
};

wiseup_landing_open( 'wu-landing wu-ev-page wu-dm-page wu-pm-page wu-br-page wu-wd-page' );
?>
<div class="wiseup-home wiseup-in-theme wu-ev wu-dm wu-pm wu-br wu-wd">
<main id="main">

	<!-- 1. Hero: portfolio wall. A tilted 3D wall of website screens drifts in columns behind the copy; the pointer tilts it. -->
	<?php
	// wall tiles: GPT website designs assets/landing/img/wd-wall-{1..12}.webp when present, else existing work images
	$wu_wall = array();
	for ( $wu_i = 1; $wu_i <= 12; $wu_i++ ) { if ( file_exists( WISEUP_DIR . 'assets/landing/img/wd-wall-' . $wu_i . '.webp' ) ) $wu_wall[] = WISEUP_URL . 'assets/landing/img/wd-wall-' . $wu_i . '.webp'; }
	// owner's real website screenshots first, mixed with the existing work images (real ones on every other tile)
	$wu_work = array(
		WISEUP_URL . 'assets/landing/img/wd-xr-site-1000.webp', WISEUP_URL . 'assets/landing/img/case-gloveda.webp', WISEUP_URL . 'assets/landing/img/case-kpg.webp',
		WISEUP_URL . 'assets/landing/img/case-smokehouse.jpg', WISEUP_URL . 'assets/landing/img/case-erets.jpg', WISEUP_URL . 'assets/landing/img/case-karak.jpg',
		WISEUP_URL . 'assets/landing/img/case-indusgo.jpg', WISEUP_URL . 'assets/landing/img/case-bootland.jpg', WISEUP_ASSETS . '/work/case-onesto-720.webp',
		WISEUP_ASSETS . '/work/case-formaa-720.webp', WISEUP_ASSETS . '/work/case-sathya-720.webp', WISEUP_ASSETS . '/work/case-popees-720.webp',
	);
	$wu_mix = array();
	for ( $wu_i = 0; $wu_i < max( count( $wu_wall ), count( $wu_work ) ); $wu_i++ ) {
		if ( isset( $wu_wall[ $wu_i ] ) ) $wu_mix[] = $wu_wall[ $wu_i ];
		if ( isset( $wu_work[ $wu_i ] ) ) $wu_mix[] = $wu_work[ $wu_i ];
	}
	$wu_wall = $wu_mix;
	$wu_cols = 6; $wu_per = 4; $wu_n = count( $wu_wall );
	?>
	<section class="ev-hero dm-hero wd-hero wd-hero--wall" data-css-intro>
		<div class="wd-wall" data-wd-wall aria-hidden="true">
			<div class="wd-wall__plane">
				<?php for ( $c = 0; $c < $wu_cols; $c++ ) : ?>
				<div class="wd-wall__col" style="--d:<?php echo (int) ( 46 + ( $c % 3 ) * 9 ); ?>s"><div class="wd-wall__run<?php echo $c % 2 ? ' is-down' : ''; ?>">
					<?php for ( $k = 0; $k < 2; $k++ ) : for ( $r = 0; $r < $wu_per; $r++ ) : $src = $wu_wall[ ( $c * 2 + $r * 5 ) % $wu_n ]; ?>
					<span class="wd-wall__tile"><i class="wd-wall__bar"><b></b><b></b><b></b></i><img src="<?php echo esc_url( $src ); ?>" alt="" loading="<?php echo $c > 1 && $c < 5 && 0 === $k ? 'eager' : 'lazy'; ?>" decoding="async"></span>
					<?php endfor; endfor; ?>
				</div></div>
				<?php endfor; ?>
			</div>
		</div>
		<div class="wd-wall__spot" aria-hidden="true"></div>
		<div class="wd-wall__shade" aria-hidden="true"></div>
		<div class="wrap wd-wall__wrap">
			<div class="ev-hero__copy wd-wall__copy">
				<h1 class="eyebrow dm-hero__pill"><span class="eyebrow__dot" aria-hidden="true"></span>Website Development Company in Kerala</h1>
				<h2 class="ev-hero__h"><span class="sh__a">Websites Built for <br class="wd-br">Better Experiences</span> <span class="sh__b">and Business Performance.</span></h2>
				<p class="ev-hero__p">WiseUp is a website development company in Kerala, based in Kozhikode, with web design and development backed by CodeAce's eight years of web engineering experience. We bring design, technology, and strategy together to build websites that communicate business offerings clearly, make navigation simple, and encourage enquiries or sales. From the first page to the final functionality, every element is planned around the website's purpose and business requirements.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Discuss a Website Project', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'View Our Work', 'night', 'href="#wd-work"' ); // phpcs:ignore ?>
				</div>
			</div>

		</div>
	</section>
	<div class="wrap wd-wall__stats">
			<dl class="ev-proof">
				<?php foreach ( array(
					array( '8', '+', 'Years of web engineering with CodeAce' ),
					array( '120', '+', 'Projects delivered' ),
					array( '900', '+', 'Orders in 3 months for Gloveda\'s store' ),
					array( '5.0', '★', 'Google rating from client reviews' ),
				) as $wu_st ) : ?>
				<div class="ev-stat"><dt><?php echo esc_html( $wu_st[2] ); ?></dt><dd><span data-count="<?php echo esc_attr( $wu_st[0] ); ?>"><?php echo esc_html( $wu_st[0] ); ?></span><em><?php echo esc_html( $wu_st[1] ); ?></em></dd></div>
				<?php endforeach; ?>
			</dl>
	</div>

<?php wiseup_ai_overview( array(
	'q'      => 'What does a website development company in Kerala do?',
	'a'      => '<b>WiseUp</b> is a website development company in Kerala, based in Kozhikode. We plan, design and build <b>business websites, online stores and landing pages</b>, backed by CodeAce\'s eight years of web engineering.',
	'points' => array(
		array( 'Services', 'Custom websites, WordPress, e-commerce on Shopify and WooCommerce, business and corporate websites, landing pages, and redesigns with migration.' ),
		array( 'Technologies', 'WordPress, Shopify, WooCommerce and Strapi; HTML, CSS, JavaScript, PHP, Laravel, React and Next.js.' ),
		array( 'Process', 'Requirements, planning and structure, design and prototyping, development, testing, then launch and handover.' ),
		array( 'Built in', 'Responsive layouts, speed, SEO-friendly structure, security and tested forms and integrations.' ),
		array( 'Where', 'Based in Kozhikode (Calicut), working with businesses across Kerala.' ),
	),
	'links'  => array( array( 'Services', '#wd-services' ), array( 'Technologies', '#wd-tech' ), array( 'Process', '#wd-process' ), array( 'FAQ', '#faq' ) ),
	'cta'    => 'Discuss a Website Project',
) ); ?>

	<!-- 2. Services -->
	<section class="sec ev-sec" id="wd-services">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Website Development Services', 'for Different Business Needs' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>No two businesses have the same website requirements. Some need a clear online presence, while others need advanced functionality or a complete e-commerce experience. WiseUp provides website development services shaped around business objectives, audience expectations, and the features each project requires.</p></div>
			</div>
			<?php
			// Fly-through: the section pins and scrolling moves the camera forward through website screens floating in depth;
			// each service's screen arrives in front as its text comes in. Screens = the owner's real website screenshots.
			$wu_zx_img  = array( 7, 1, 6, 5, 2, 3 ); // wd-zx-N.webp per service
			$wu_zx_fill = array( 'case-gloveda.webp', 'case-kpg.webp', 'wd-xr-site-1000.webp', 'case-ceramicrooftiles.webp', 'case-smokehouse.jpg', 'case-erets.jpg' );
			$wu_zx_pos  = array( array( 4, -2 ), array( -6, 3 ), array( 6, 1 ), array( -3, -3 ), array( 5, 3 ), array( -5, -1 ) ); // x / y offsets (vw / vh)
			$wu_zx_fp   = array( array( -8, -24 ), array( 32, 20 ), array( 28, -22 ), array( -6, 24 ), array( 34, 16 ), array( 26, -20 ) );
			?>
			<div class="wd-zx" data-zx>
				<div class="wd-zx__pin">
					<div class="wd-zx__space" aria-hidden="true">
						<?php foreach ( $wu_zx_fill as $wu_i => $f ) : ?>
						<figure class="wd-zx__s wd-zx__s--fill" data-z="<?php echo esc_attr( $wu_i + .5 ); ?>" style="--x:<?php echo (int) $wu_zx_fp[ $wu_i ][0]; ?>;--y:<?php echo (int) $wu_zx_fp[ $wu_i ][1]; ?>"><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/' . $f ); ?>" alt="" loading="lazy" decoding="async"></figure>
						<?php endforeach; ?>
						<?php foreach ( $wu_services as $wu_i => $sv ) : ?>
						<figure class="wd-zx__s" data-z="<?php echo (int) $wu_i; ?>" style="--x:<?php echo (int) $wu_zx_pos[ $wu_i ][0]; ?>;--y:<?php echo (int) $wu_zx_pos[ $wu_i ][1]; ?>"><div class="wd-zx__bar"><i></i><i></i><i></i><span><?php echo esc_html( $sv[0] ); ?></span></div><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/wd-zx-' . $wu_zx_img[ $wu_i ] . '.webp' ); ?>" alt="" width="1400" height="670" loading="lazy" decoding="async"></figure>
						<?php endforeach; ?>
					</div>
					<ol class="wd-zx__list">
						<?php foreach ( $wu_services as $wu_i => $sv ) : ?>
						<li class="wd-zx__it<?php echo 0 === $wu_i ? ' is-on' : ''; ?>">
							<figure class="wd-zx__mini" aria-hidden="true"><div class="wd-zx__bar"><i></i><i></i><i></i><span><?php echo esc_html( $sv[0] ); ?></span></div><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/wd-zx-' . $wu_zx_img[ $wu_i ] . '.webp' ); ?>" alt="" width="1400" height="670" loading="lazy" decoding="async"></figure>
							<span class="wd-zx__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?> <i>/ <?php echo esc_html( sprintf( '%02d', count( $wu_services ) ) ); ?></i></span>
							<h3><?php echo esc_html( $sv[0] ); ?></h3>
							<p><?php echo esc_html( $sv[2] ); ?></p>
						</li>
						<?php endforeach; ?>
					</ol>
					<div class="wd-zx__nav" aria-label="Services"><?php foreach ( $wu_services as $wu_i => $sv ) : ?><button type="button" class="wd-zx__tb<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" data-k="<?php echo (int) $wu_i; ?>" aria-label="<?php echo esc_attr( $sv[0] ); ?>"><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/wd-zx-' . $wu_zx_img[ $wu_i ] . '.webp' ); ?>" alt="" loading="lazy" decoding="async"><i><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></i></button><?php endforeach; ?></div>
				</div>
			</div>
			<script>(function(){
var w=document.querySelector('[data-zx]');if(!w)return;
var ss=[].slice.call(w.querySelectorAll('.wd-zx__s')),its=[].slice.call(w.querySelectorAll('.wd-zx__it')),tbs=[].slice.call(w.querySelectorAll('.wd-zx__tb')),N=its.length,D=800,p=0,tp=0,raf=0,on=false,cur=0;
var ok=function(){return innerWidth>=1024&&!matchMedia('(prefers-reduced-motion: reduce)').matches;};
var target=function(){var r=w.getBoundingClientRect(),len=w.offsetHeight-innerHeight;return Math.max(0,Math.min(1,-r.top/len))*(N-1+.75);};
var draw=function(){raf=0;p+=(tp-p)*.12;if(Math.abs(tp-p)<.0005)p=tp;
ss.forEach(function(s){var d=p-(+s.getAttribute('data-z')),z=d*D,o=d<0?Math.max(0,1+d*.3):d<.2?1:Math.max(0,1-(d-.2)/.3),b=d>.2?(d-.2)*22:d<-1.2?(-d-1.2)*1.4:0;
s.style.transform='translate3d('+s.dataset.x+'vw,'+s.dataset.y+'vh,'+z.toFixed(1)+'px)';s.style.opacity=o.toFixed(3);s.style.filter=b>.05?'blur('+b.toFixed(1)+'px)':'';s.style.visibility=o<.01?'hidden':'';});
var i=Math.max(0,Math.min(N-1,Math.round(p)));if(i!==cur){cur=i;its.forEach(function(e,k){e.classList.toggle('is-on',k===i)});tbs.forEach(function(e,k){e.classList.toggle('is-on',k===i)});}

if(p!==tp)raf=requestAnimationFrame(draw);};
var kick=function(){if(!on)return;tp=target();if(!raf)raf=requestAnimationFrame(draw);};
var mode=function(){var m=ok();if(m===on)return;on=m;w.classList.toggle('is-3d',m);if(!m){ss.forEach(function(s){s.style.transform=s.style.opacity=s.style.filter=s.style.visibility=''});its.forEach(function(e){e.classList.add('is-on')});}else{its.forEach(function(e,k){e.classList.toggle('is-on',k===cur)});p=tp=target();draw();}};
ss.forEach(function(s){s.dataset.x=s.style.getPropertyValue('--x').trim();s.dataset.y=s.style.getPropertyValue('--y').trim();});
tbs.forEach(function(b,k){b.addEventListener('click',function(){var top=w.getBoundingClientRect().top+scrollY,len=w.offsetHeight-innerHeight;scrollTo({top:top+len*k/(N-1+.75)+2,behavior:'smooth'});});});mode();addEventListener('scroll',kick,{passive:true});addEventListener('resize',function(){mode();kick();});
})();</script>
		</div>
	</section>

	<!-- 3. Design that makes navigation feel natural -->
	<section class="sec ev-sec" id="wd-design">
		<div class="wrap">
			<div class="br-split">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Design' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Website Design That Makes', 'Navigation Feel Natural' ); // phpcs:ignore ?></h2>
				</div>
				<div class="br-split__tx">
					<p class="br-lead">Good website design is not only about appearance. It is also about how easily visitors can move through a website and find the information they need. WiseUp brings web design and development together to create experiences that feel clear and consistent.</p>
					<p>Page layouts, navigation and information hierarchy are planned to make content easy to follow. Responsive design helps maintain usability across desktops, tablets and mobile devices. Typography, imagery, colours and visual elements are selected to create a consistent look, while intuitive interactions make important information and actions easier to access.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 4. Platforms and technologies -->
	<section class="sec ev-sec" id="wd-tech">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Technologies' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Platforms and Technologies', 'Behind Our Web Solutions' ); // phpcs:ignore ?></h2>
				</div>
			</div>
			<?php
			$wu_fl_t = array(); foreach ( $wu_tech as $wu_i => $l ) $wu_fl_t[] = 40 + $wu_i * 80;
			$wu_fl_p = array( 100, 220, 340, 460 );
			?>
			<div class="wd-flow" data-flow>
				<svg class="wd-flow__ln" viewBox="0 0 1200 560" aria-hidden="true">
					<?php foreach ( $wu_fl_t as $wu_i => $y ) : $d = 'M178 ' . $y . ' C390 ' . $y . ' 420 280 560 280'; ?>
					<path d="<?php echo esc_attr( $d ); ?>" class="b" data-t="<?php echo (int) $wu_i; ?>"/><path d="<?php echo esc_attr( $d ); ?>" class="p" style="--d:<?php echo esc_attr( $wu_i * .37 ); ?>s"/>
					<?php endforeach; foreach ( $wu_fl_p as $wu_i => $y ) : $d = 'M640 280 C780 280 810 ' . $y . ' 1022 ' . $y; ?>
					<path d="<?php echo esc_attr( $d ); ?>" class="b" data-p="<?php echo (int) $wu_i; ?>"/><path d="<?php echo esc_attr( $d ); ?>" class="p" style="--d:<?php echo esc_attr( 1.2 + $wu_i * .45 ); ?>s"/>
					<?php endforeach; ?>
				</svg>
				<div class="wd-flow__g wd-flow__g--t">
					<h3>Development Technologies</h3>
					<ul><?php foreach ( $wu_tech as $wu_i => $l ) : ?><li style="--y:<?php echo esc_attr( $wu_fl_t[ $wu_i ] / 5.6 ); ?>%" data-t="<?php echo (int) $wu_i; ?>"><b><?php echo esc_html( $l[0] ); ?></b><span><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/icons/' . $l[1] ); ?>" alt="<?php echo esc_attr( $l[0] . ' logo' ); ?>" width="34" height="34" loading="lazy" decoding="async"></span></li><?php endforeach; ?></ul>
				</div>
				<div class="wd-flow__core" aria-hidden="true"><svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 8.5h18"/><path d="m9.5 12-2 2 2 2M14.5 12l2 2-2 2"/></svg></div>
				<div class="wd-flow__g wd-flow__g--p">
					<h3>Website Platforms</h3>
					<ul><?php foreach ( $wu_platforms as $wu_i => $l ) : ?><li style="--y:<?php echo esc_attr( $wu_fl_p[ $wu_i ] / 5.6 ); ?>%" data-p="<?php echo (int) $wu_i; ?>"><span><img src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/icons/' . $l[1] ); ?>" alt="<?php echo esc_attr( $l[0] . ' logo' ); ?>" width="40" height="40" loading="lazy" decoding="async"></span><b><?php echo esc_html( $l[0] ); ?></b></li><?php endforeach; ?></ul>
				</div>
			</div>
			<script>(function(){var w=document.querySelector('[data-flow]');if(!w)return;
w.querySelectorAll('li[data-t],li[data-p]').forEach(function(li){var k=li.hasAttribute('data-t')?'data-t':'data-p',v=li.getAttribute(k),ln=w.querySelector('path.b['+k+'="'+v+'"]');
li.addEventListener('mouseenter',function(){w.classList.add('is-hl');li.classList.add('is-on');ln&&ln.classList.add('is-on')});
li.addEventListener('mouseleave',function(){w.classList.remove('is-hl');li.classList.remove('is-on');ln&&ln.classList.remove('is-on')});});
if('IntersectionObserver' in window)new IntersectionObserver(function(es){w.classList.toggle('is-in',es[0].isIntersecting)},{threshold:.25}).observe(w);else w.classList.add('is-in');})();</script>
		</div>
	</section>

	<!-- 5. What goes into a well-developed website -->
	<section class="sec ev-sec" id="wd-quality">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Quality' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'What Goes Into a', 'Well-Developed Website?' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A website's value goes beyond its appearance. Its underlying structure, loading speed and features all play a part in creating a smooth and reliable user experience. WiseUp considers these elements during the web development process.</p></div>
			</div>
			<div class="wd-ly" data-ly>
				<div class="wd-ly__scene" aria-hidden="true">
					<div class="wd-ly__stack wd-ly__stack--img">
						<img class="wd-ly__pl wd-ly__pl--top" src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/wd-ly-1.webp' ); ?>" alt="" width="900" height="725" loading="lazy" decoding="async" style="--k:0">
						<?php foreach ( array( 2, 3, 4, 5 ) as $wu_k => $wu_n ) : ?><img class="wd-ly__pl" data-l="<?php echo (int) $wu_k; ?>" src="<?php echo esc_url( WISEUP_URL . 'assets/landing/img/wd-ly-' . $wu_n . '.webp' ); ?>" alt="" width="900" height="700" loading="lazy" decoding="async" style="--k:<?php echo (int) ( $wu_k + 1 ); ?>"><?php endforeach; ?>
					</div>
				</div>
				<ol class="wd-ly__list">
					<?php foreach ( $wu_quality as $wu_i => $q ) : ?>
					<li class="wd-ly__it<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" data-i="<?php echo (int) $wu_i; ?>" tabindex="0"><span class="wd-ly__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><div><h3><?php echo esc_html( $q[0] ); ?></h3><p><?php echo esc_html( $q[2] ); ?></p></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
			<script>(function(){var w=document.querySelector('[data-ly]');if(!w)return;var its=[].slice.call(w.querySelectorAll('.wd-ly__it')),pl=[].slice.call(w.querySelectorAll('.wd-ly__pl[data-l]')),hold=false;
var set=function(i){its.forEach(function(e,k){e.classList.toggle('is-on',k===i)});pl.forEach(function(e){e.classList.toggle('is-on',+e.getAttribute('data-l')===i)});w.classList.add('has-on');};set(0);
its.forEach(function(e,k){e.addEventListener('mouseenter',function(){hold=true;set(k)});e.addEventListener('mouseleave',function(){hold=false});e.addEventListener('focus',function(){set(k)});});
if('IntersectionObserver' in window){var io=new IntersectionObserver(function(es){if(hold)return;es.forEach(function(e){if(e.isIntersecting)set(+e.target.getAttribute('data-i'))})},{rootMargin:'-45% 0px -45% 0px'});its.forEach(function(e){io.observe(e)});}})();</script>
		</div>
	</section>

	<!-- 6. Process -->
	<section class="sec ev-sec" id="wd-process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'From First Discussion', 'to Website Launch' ); // phpcs:ignore ?></h2>
				</div>
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

	<!-- 7. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Website Solutions', 'Across Industries' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Website requirements change according to the nature of a business, the audience it serves and the actions visitors need to take. Different industries may require different layouts, features and content structures.</p></div>
			</div>
			<div class="wd-dl" data-dl>
				<div class="wd-dl__stick"><div class="wd-dl__ring" style="--n:<?php echo count( $wu_ind ); ?>">
					<i class="wd-dl__ticks" aria-hidden="true"></i>
					<i class="wd-dl__mark" aria-hidden="true"></i>
					<div class="wd-dl__rot" role="tablist" aria-label="Industries">
						<?php foreach ( $wu_ind as $wu_i => $ind ) : ?>
						<button type="button" class="wd-dl__b<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" role="tab" id="wd-dl-t<?php echo (int) $wu_i; ?>" aria-controls="wd-dl-p<?php echo (int) $wu_i; ?>" aria-selected="<?php echo 0 === $wu_i ? 'true' : 'false'; ?>" style="--i:<?php echo (int) $wu_i; ?>"><span class="wd-dl__ic"><?php echo $wu_svg( $ind[2], 26, 1.5 ); // phpcs:ignore ?></span><span class="wd-dl__lb"><?php echo esc_html( $ind[0] ); ?></span></button>
						<?php endforeach; ?>
					</div>
					<div class="wd-dl__core">
						<?php foreach ( $wu_ind as $wu_i => $ind ) : ?>
						<div class="wd-dl__p<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" role="tabpanel" id="wd-dl-p<?php echo (int) $wu_i; ?>" aria-labelledby="wd-dl-t<?php echo (int) $wu_i; ?>">
							<span class="wd-dl__big" aria-hidden="true"><?php echo $wu_svg( $ind[2], 44, 1.3 ); // phpcs:ignore ?></span>
							<h3><?php echo esc_html( $ind[0] ); ?></h3>
							<p><?php echo esc_html( $ind[1] ); ?></p>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			</div>
			<script>(function(){var w=document.querySelector('[data-dl]');if(!w)return;var ring=w.querySelector('.wd-dl__ring'),bs=[].slice.call(w.querySelectorAll('.wd-dl__b')),ps=[].slice.call(w.querySelectorAll('.wd-dl__p')),n=bs.length,cur=-1,on=false,raf=0,p=0,tp=0;
var show=function(i){if(i===cur)return;cur=i;bs.forEach(function(b,k){b.classList.toggle('is-on',k===i);b.setAttribute('aria-selected',k===i?'true':'false')});ps.forEach(function(e,k){e.classList.toggle('is-on',k===i)});};
var rot=function(v){ring.style.setProperty('--r',(-v*360/n).toFixed(2)+'deg');show(Math.max(0,Math.min(n-1,Math.round(v))));};
var len=function(){return w.offsetHeight-innerHeight;};
var target=function(){var r=w.getBoundingClientRect();return Math.max(0,Math.min(1,-r.top/len()))*(n-1);};
var draw=function(){raf=0;p+=(tp-p)*.14;if(Math.abs(tp-p)<.001)p=tp;rot(p);if(p!==tp)raf=requestAnimationFrame(draw);};
var kick=function(){if(!on)return;tp=target();if(!raf)raf=requestAnimationFrame(draw);};
var mode=function(){var m=!matchMedia('(prefers-reduced-motion: reduce)').matches;on=m;w.classList.toggle('is-pin',m);if(m){p=tp=target();rot(p);}else{rot(cur<0?0:cur);}};
bs.forEach(function(b,k){b.addEventListener('click',function(){if(!on){rot(k);return;}var top=w.getBoundingClientRect().top+scrollY;scrollTo({top:top+len()*k/(n-1)+2,behavior:'smooth'});});});
mode();addEventListener('scroll',kick,{passive:true});addEventListener('resize',function(){mode();kick();});})();</script>
		</div>
	</section>

	<!-- 8. Projects -->
	<section class="sec ev-sec" id="wd-work">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Projects' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Projects', 'We\'ve Worked On' ); // phpcs:ignore ?></h2>
				</div>
			</div>
			<div class="wd-folio" data-folio>
				<ol class="wd-folio__list">
					<?php foreach ( $wu_projects as $wu_i => $pj ) : ?>
					<li class="wd-folio__it<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" data-i="<?php echo (int) $wu_i; ?>" tabindex="0">
						<span class="wd-folio__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span>
						<div class="wd-folio__t">
							<h3><?php echo esc_html( $pj[0] ); ?></h3>
							<?php if ( $pj[1] ) : ?><p class="wd-folio__k"><?php echo esc_html( $pj[1] ); ?> <i aria-hidden="true">/</i> <?php echo esc_html( $pj[2] ); ?><?php if ( $pj[3] ) echo ' <i aria-hidden="true">/</i> ' . esc_html( $pj[3] ); ?></p><?php endif; ?>
							<?php if ( $pj[4] ) : ?><p class="wd-folio__d"><?php echo esc_html( $pj[4] ); ?></p><?php endif; ?>
						</div>
						<span class="wd-folio__go" aria-hidden="true"><?php echo $wu_ne; // phpcs:ignore ?></span>
						<figure class="wd-folio__m"><?php echo $wu_shot( $pj, true ); // phpcs:ignore ?></figure>
					</li>
					<?php endforeach; ?>
				</ol>
				<div class="wd-folio__stage" aria-hidden="true">
					<div class="wd-folio__win">
						<div class="wd-folio__bar"><i></i><i></i><i></i><span data-url><?php echo esc_html( $wu_projects[0][0] ); ?></span></div>
						<div class="wd-folio__view">
							<?php foreach ( $wu_projects as $wu_i => $pj ) : ?>
							<figure class="wd-folio__shot<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" data-i="<?php echo (int) $wu_i; ?>" data-name="<?php echo esc_attr( $pj[0] ); ?>"><?php echo $wu_shot( $pj, $wu_i > 0 ); // phpcs:ignore ?></figure>
							<?php endforeach; ?>
						</div>
					</div>
					<p class="wd-folio__cap"><b data-cnt>01</b> <span>/ <?php echo esc_html( sprintf( '%02d', count( $wu_projects ) ) ); ?></span></p>
				</div>
			</div>
			<script>(function(){var w=document.querySelector('[data-folio]');if(!w)return;var its=[].slice.call(w.querySelectorAll('.wd-folio__it')),sh=[].slice.call(w.querySelectorAll('.wd-folio__shot')),u=w.querySelector('[data-url]'),c=w.querySelector('[data-cnt]');
var set=function(i){its.forEach(function(e,k){e.classList.toggle('is-on',k===i)});sh.forEach(function(e,k){e.classList.toggle('is-on',k===i)});u.textContent=sh[i].getAttribute('data-name');c.textContent=(i<9?'0':'')+(i+1);};
its.forEach(function(e,k){e.addEventListener('mouseenter',function(){set(k)});e.addEventListener('focus',function(){set(k)});});
var st=w.querySelector('.wd-folio__stage');w.addEventListener('pointermove',function(e){if(e.pointerType!=='mouse')return;var r=w.getBoundingClientRect();st.style.setProperty('--mx',((e.clientX-r.left)/r.width-.5).toFixed(3));st.style.setProperty('--my',((e.clientY-r.top)/r.height-.5).toFixed(3));});
w.addEventListener('pointerleave',function(){st.style.setProperty('--mx',0);st.style.setProperty('--my',0);});})();</script>
		</div>
	</section>

	<!-- 9. Why WiseUp -->
	<section class="sec ev-sec" id="wd-why">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Why Businesses', 'Choose WiseUp' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Choosing a website development company involves more than comparing designs or platforms. The development approach, technical decisions, and project communication also matter.</p></div>
			</div>
			<ul class="wd-wy">
				<?php foreach ( $wu_why as $wu_i => $d ) : ?>
				<li><span class="wd-wy__top"><span class="wd-wy__i" aria-hidden="true"><?php echo $wu_svg( $wu_icons[ $d[1] ], 24, 1.6 ); // phpcs:ignore ?></span><span class="wd-wy__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span></span><h3><?php echo esc_html( $d[0] ); ?></h3><p><?php echo esc_html( $d[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 10. FAQ -->
	<section class="sec ev-sec" id="faq" aria-labelledby="wd-faq-h">
		<div class="wrap dm-faq">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="wd-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
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

	<?php wiseup_other_services( 'wiseup-web-development' ); ?>

	<!-- 11. Final CTA -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final br-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Need a Website That Fits', 'the Way the Business Works?' ); // phpcs:ignore ?></h2>
					<div class="br-final__btn"><?php echo $wu_btn( 'Talk to Our Development Team', 'teal', $wu_lead ); // phpcs:ignore ?></div>
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
	var fx = function () {
		if (!window.gsap || !window.ScrollTrigger) return;
		document.querySelectorAll('.wu-wd [data-tl]').forEach(function (tl) {
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
	if (!document.documentElement.classList.contains('wu-motion')) document.querySelectorAll('.wu-wd [data-count]').forEach(function (el) {
		var raw = el.getAttribute('data-count'), to = +raw, dp = (raw.split('.')[1] || '').length, t0 = performance.now();
		(function stp(t) { var k = Math.min(1, (t - t0) / 1400); el.textContent = (to * (1 - Math.pow(1 - k, 3))).toFixed(dp); if (k < 1) requestAnimationFrame(stp); })(t0);
	});
})();
</script>
<script>
(function () {
	// hero wall: the pointer is a spotlight: tiles near it light up and grow a little; the wall tilts slightly with it
	var w = document.querySelector('[data-wd-wall]'); if (!w) return;
	var sec = w.parentNode, calm = matchMedia('(prefers-reduced-motion: reduce)').matches;
	if ('IntersectionObserver' in window) new IntersectionObserver(function (es) { sec.classList.toggle('is-off', !es[0].isIntersecting); }).observe(sec);
	if (calm || !matchMedia('(hover: hover)').matches) return;
	var tiles = [].slice.call(w.querySelectorAll('.wd-wall__tile')), tx = 0, ty = 0, x = 0, y = 0, px = -999, py = -999, raf = 0, live = 0;
	var step = function () {
		raf = 0; x += (tx - x) * .06; y += (ty - y) * .06;
		w.style.setProperty('--mx', x.toFixed(4)); w.style.setProperty('--my', y.toFixed(4));
		var r0 = sec.getBoundingClientRect(), R = 260;
		tiles.forEach(function (el) {
			var r = el.getBoundingClientRect(); if (r.bottom < r0.top || r.top > r0.bottom || r.right < 0 || r.left > innerWidth) return;
			var d = Math.hypot(r.left + r.width / 2 - (r0.left + px), r.top + r.height / 2 - (r0.top + py)), k = Math.max(0, 1 - d / R);
			k = k * k * (3 - 2 * k); var o = +(el.style.getPropertyValue('--k') || 0), n = o + (k - o) * .18;
			if (Math.abs(n - o) > .002 || n > .002) el.style.setProperty('--k', n.toFixed(3));
		});
		if (live-- > 0 || Math.abs(tx - x) + Math.abs(ty - y) > .001) raf = requestAnimationFrame(step);
	};
	var kick = function () { live = 60; if (!raf) raf = requestAnimationFrame(step); };
	sec.addEventListener('pointermove', function (e) { var r = sec.getBoundingClientRect(); px = e.clientX - r.left; py = e.clientY - r.top; tx = px / r.width - .5; ty = py / r.height - .5; sec.style.setProperty('--px', px + 'px'); sec.style.setProperty('--py', py + 'px'); sec.classList.add('is-lit'); kick(); });
	sec.addEventListener('pointerleave', function () { tx = 0; ty = 0; px = py = -999; sec.classList.remove('is-lit'); kick(); });
})();
</script>
<?php
$wu_lead_source = $wu_src;
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
