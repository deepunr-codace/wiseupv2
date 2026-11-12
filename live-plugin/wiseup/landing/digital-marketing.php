<?php
/**
 * Digital Marketing Agency in Kerala ("WiseUp: Digital Marketing" in the page Template dropdown). Copy is the owner's
 * doc word for word (Downloads/digital marketing company (1).docx, 2026-11-12: "this is the actual content. dont miss
 * any word"), in the doc's order; the Australia version was dropped on request. The doc's keyword list feeds the
 * title and meta description only. Case-study figures come from wiseup_cs_stats(); reviews are the real Google reviews.
 * Design system: the Event Branding page's (assets/css/event-branding.css + assets/js/event-branding.js, scoped to
 * .wu-ev) plus this page's own blocks in assets/css/digital-marketing.css. Brand marks: landing/digital-marketing-icons.php.
 */
defined( 'ABSPATH' ) || exit;

$wu_src   = 'digital-marketing';
$wu_title = apply_filters( 'wiseup_landing_title', 'Digital Marketing Agency in Kerala | Digital Marketing Company in Calicut | WiseUp' );
$wu_desc  = apply_filters( 'wiseup_landing_description', 'WiseUp is a digital marketing agency in Kerala, based in Calicut: SEO, PPC advertising, social media marketing, content, branding, websites and AI automation. Packages start at ₹60,000.' );
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

$wu_wa    = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I would like to talk about digital marketing for my business.' );
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
	if ( isset( $wu_brands[ $key ] ) ) {
		return '<span class="dm-mark" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20" fill="' . esc_attr( $wu_brands[ $key ][0] ) . '"><path d="' . esc_attr( $wu_brands[ $key ][1] ) . '"/></svg></span>';
	}
	return '<span class="dm-mark" aria-hidden="true"><img src="' . esc_url( WISEUP_URL . 'assets/landing/img/icons/' . $key ) . '" alt="" width="20" height="20" loading="lazy" decoding="async"></span>';
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

$wu_smm = ( function () {
	$ids = get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'meta_key' => '_wp_page_template', 'meta_value' => 'wiseup-social-media', 'posts_per_page' => 1, 'fields' => 'ids' ) ); // phpcs:ignore
	return $ids ? get_permalink( $ids[0] ) : 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/';
} )();

$wu_services = array(
	array( 'Search Engine Optimisation (SEO)', 'search', 'Help your business get found when potential customers search for what you offer. We strengthen your search presence through technical SEO, keyword research, content optimisation, and local search strategies, bringing more relevant visitors to your website and creating opportunities for organic growth.', '' ),
	array( 'Performance Marketing & PPC Advertising', 'target', 'Reach the right audience with campaigns built to generate meaningful action. We create and manage Google Ads, Meta campaigns and remarketing strategies, using audience targeting and performance tracking to improve clicks, enquiries and conversions.', '' ),
	array( 'Social Media Marketing', 'chat', 'Give your audience more reasons to connect with your brand. We create platform-specific social media strategies and content that build brand awareness, encourage engagement and generate business enquiries.', $wu_smm ),
	array( 'Content Marketing & Creative Production', 'pen', 'Give your brand a clear and consistent voice across digital platforms. We create website content, SEO articles, social media posts, campaign copy and video assets that communicate your message and connect with your audience.', '' ),
	array( 'Branding & Digital Brand Experiences', 'brush', 'Build a brand people can recognise and remember. From brand strategy and positioning to visual identity, messaging and creative communication, we bring the different elements of your brand together.', '' ),
	array( 'Website & Digital Experience Development', 'code', 'Turn your website into a more effective business touchpoint. We design and develop responsive websites and landing pages with clear navigation and user-friendly experiences that make it easier for visitors to take action.', '' ),
	array( 'Public Relations & Digital Brand Communication', 'mega', 'Make your brand story reach a wider audience. Through digital PR, media communication, and brand storytelling, we strengthen brand visibility and create more opportunities for meaningful audience connections.', '' ),
	array( 'AI Business Automation & CRM', 'bot', 'Make everyday business operations more organised and efficient with AI-powered automation and CRM solutions. We streamline repetitive tasks, automate customer interactions, and organise lead management through connected systems that help your team save time and manage customer relationships more effectively.', '' ),
);

$wu_approach = array(
	array( 'ear', 'Understand the Business and Its Audience', 'We look at your business objectives, customer profiles, audience behaviour and existing digital presence. This gives us a clearer picture of where your marketing stands and what needs attention.' ),
	array( 'scope', 'Research the Market and Competition', 'We assess competitor activity, search demand, audience expectations, and opportunities to differentiate your brand. The aim is to identify where your business can make a stronger impression.' ),
	array( 'mix', 'Choose the Right Marketing Mix', 'Not every business needs every channel. We select services, platforms and campaign formats based on your objectives, audience and available resources.' ),
	array( 'spark', 'Connect Creativity With Strategy', 'A good strategy needs equally thoughtful execution. We bring messaging, design, content, and advertising together so that your brand communicates with consistency and purpose.' ),
	array( 'chart', 'Refine Through Performance Insights', 'Marketing is not a set-and-forget activity. We review campaign performance, audience response, and website data to identify what is working and where improvements are needed.' ),
);

$wu_channels = array(
	array( 'Google & Search Platforms', array( 'google', 'googleads', 'googlesearchconsole' ), 'SEO, Google Ads and local search help your business reach people looking for relevant products or services. These channels are useful for building search visibility and attracting audiences with a clear interest.' ),
	array( 'Instagram & Facebook', array( 'instagram', 'facebook', 'meta' ), 'Visual content, community engagement, and Meta Ads can help brands build awareness, communicate their personality, and generate enquiries from relevant audiences.' ),
	array( 'LinkedIn', array( 'linkedin' ), 'For businesses targeting professionals and other organisations, LinkedIn supports B2B communication, thought leadership, professional visibility and business enquiries.' ),
	array( 'YouTube & Video Platforms', array( 'youtube' ), 'Video gives brands more room to demonstrate products, communicate ideas and tell stories. YouTube can support discovery through both organic video content and paid advertising.' ),
	array( 'Other Relevant Digital Channels', array( 'pinterest' ), 'Depending on your audience and objectives, platforms such as Pinterest may also be worth considering. We assess their relevance before adding them to your marketing mix.' ),
);

$wu_stages = array(
	array( 'Startups Building Their First Digital Presence', 'Build a clear brand position, establish your website, and create the initial visibility needed to reach your target audience.' ),
	array( 'Small Businesses Looking for More Customers', 'You do not need to be everywhere to make an impact. Our digital marketing services for small businesses can focus on practical priorities such as local SEO, targeted advertising, and social media, depending on your budget and goals.' ),
	array( 'Established Businesses Expanding Their Reach', 'Reach new audiences through integrated campaigns, stronger brand positioning and a coordinated presence across relevant digital channels.' ),
	array( 'Growing Brands Strengthening Market Position', 'Maintain consistency as your business grows through creative campaigns, relevant content, performance optimisation and stronger brand communication.' ),
);

$wu_industries = array(
	array( 'Healthcare & Medical Practices', 'health' ), array( 'Real Estate & Property', 'home' ), array( 'Education & Training', 'cap' ),
	array( 'Legal & Professional Services', 'scale' ), array( 'Hotels, Hospitality & Dining', 'bed' ), array( 'E-commerce & Retail', 'bag' ),
	array( 'Manufacturing & Printing', 'factory' ), array( 'Startups & SaaS Businesses', 'rocket' ), array( 'Local & Home Services', 'tool' ),
);

$wu_process = array(
	array( 'Discover', 'search', 'We begin with your business, audience, objectives and competitors. We also assess your existing website, brand communication and digital presence to identify opportunities.' ),
	array( 'Strategise', 'map', 'Based on our findings, we develop a marketing roadmap. This sets the direction for channel priorities, campaign objectives, content and creative requirements.' ),
	array( 'Create', 'pen', 'Our team develops the content, designs, campaigns, websites and digital assets needed to bring the strategy to life. Each element is created with its intended audience and platform in mind.' ),
	array( 'Launch & Execute', 'play', 'We put the plan into action by launching campaigns, publishing content and activating the selected channels. We keep execution aligned with the agreed direction and priorities.' ),
	array( 'Measure & Optimise', 'chart', 'We review performance data, audience response and campaign outcomes to identify opportunities for improvement. The strategy can then be refined based on what the results tell us.' ),
);

// Tools: [ group, [ [ name, brand mark ], ... ] ], names as in the doc.
$wu_tools = array(
	array( 'SEO & Keyword Research', array( array( 'Google Search Console', 'googlesearchconsole' ), array( 'Google Analytics 4', 'googleanalytics' ), array( 'Ahrefs', 'fav-ahrefs.com.png' ), array( 'Semrush', 'semrush' ), array( 'Screaming Frog SEO Spider', 'fav-screamingfrog.co.uk.png' ), array( 'Google Keyword Planner', 'googleads' ) ) ),
	array( 'Paid Advertising', array( array( 'Google Ads', 'googleads' ), array( 'Meta Ads Manager', 'meta' ), array( 'LinkedIn Campaign Manager', 'linkedin' ), array( 'TikTok Ads Manager', 'tiktok' ) ) ),
	array( 'Social Media Management', array( array( 'Meta Business Suite', 'meta' ), array( 'Hootsuite', 'hootsuite' ), array( 'Buffer', 'buffer' ), array( 'Sprout Social', 'fav-sproutsocial.com.png' ), array( 'Later', 'fav-later.com.png' ) ) ),
	array( 'Analytics & Reporting', array( array( 'Looker Studio', 'looker.svg' ), array( 'Microsoft Clarity', 'fav-clarity.microsoft.com.png' ), array( 'Hotjar', 'hotjar' ), array( 'Google Tag Manager', 'googletagmanager' ) ) ),
	array( 'Design & Creative Production', array( array( 'Adobe Photoshop', 'adobephotoshop' ), array( 'Illustrator', 'adobeillustrator' ), array( 'Premiere Pro', 'adobepremierepro' ), array( 'After Effects', 'adobeaftereffects' ), array( 'Canva', 'canva' ), array( 'Figma', 'figma' ) ) ),
	array( 'Content & Research', array( array( 'ChatGPT', 'fav-chatgpt.com.png' ), array( 'Grammarly', 'grammarly' ), array( 'Google Trends', 'fav-trends.google.com.png' ), array( 'AnswerThePublic', 'fav-answerthepublic.com.png' ) ) ),
	array( 'Email marketing and automation', array( array( 'Mailchimp', 'mailchimp' ), array( 'HubSpot', 'hubspot' ), array( 'Brevo', 'brevo' ), array( 'Zoho Campaigns', 'zoho' ) ) ),
);

$wu_why = array(
	array( 'spark', 'Strategy and Creativity Working Together', 'We bring planning and creative execution into the same process. This helps ensure that the ideas behind your marketing are reflected in the content, design, and campaigns your audience sees.' ),
	array( 'link', 'A Connected Creative and Technology Approach', 'WiseUp’s creative and strategic capabilities work alongside CodeAce’s technology expertise where a project requires it. This gives businesses access to connected thinking across brand communication and digital experiences.' ),
	array( 'target', 'Marketing Around Your Business Goals', 'We do not begin with a fixed list of services. We look at your priorities and recommend the channels and activities that make sense for your objectives and resources.' ),
	array( 'eye', 'Creative That Builds Brand Recognition', 'From visual identity to campaign content, we focus on communication that reflects your brand and makes it easier for audiences to recognise and remember.' ),
	array( 'chart', 'Performance That Can Be Evaluated', 'We consider measurable indicators such as website traffic, enquiries, conversions, and advertising performance. These insights help assess progress and guide the next decisions.' ),
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

$wu_package = array(
	array( 'Strategy & Planning', 'Business and audience research, competitor analysis, marketing strategy and monthly planning' ),
	array( 'Content & Creative', 'Content calendars, graphics, carousels, reels, video creatives and campaign copy' ),
	array( 'SEO', 'Keyword research, on-page SEO and website performance recommendations' ),
	array( 'Paid Campaigns', 'Google and Meta Ads setup, audience targeting, ad creatives, monitoring and optimisation' ),
	array( 'Social Media Management', 'Platform-specific content, publishing and account management' ),
	array( 'Reporting & Analysis', 'Performance reports, campaign insights and recommendations' ),
);

$wu_faq = array(
	array( 'What does a digital marketing agency in Kerala do for a business?', 'A digital marketing agency helps businesses build their online presence and reach relevant audiences through services such as SEO, paid advertising, social media marketing, content creation, branding and website development. The right combination depends on the business’s audience, goals and budget.' ),
	array( 'How Soon Can My Business Expect Marketing Results?', 'The time required depends on the channels, competition, budget and campaign objectives. Paid advertising can generate traffic and enquiries soon after a campaign goes live, while SEO and organic content generally require consistent work over a longer period. Results should be assessed against clear performance indicators rather than a fixed timeline.' ),
	array( 'Which social media platforms should my business be on?', 'Your platform selection should align with your audience and marketing goals. Instagram and Facebook can support visual communication and audience engagement, while LinkedIn is often relevant for B2B businesses. YouTube can help brands communicate through video. It is better to focus on platforms that suit your audience than to maintain accounts everywhere.' ),
	array( 'Does WiseUp offer content creation services in both Malayalam and English?', 'Yes. Content can be developed in Malayalam, English or both, depending on the target audience and communication requirements. Language selection is considered as part of the content strategy so that the message feels relevant to the people it is intended to reach.' ),
	array( 'Does WiseUp work with businesses outside Calicut?', 'Yes. WiseUp is based in Calicut and can work with businesses targeting audiences in other parts of Kerala and beyond. The location of a business does not have to limit the markets its digital campaigns target.' ),
	array( 'Can small businesses afford digital marketing?', 'Yes. Small businesses can begin with a focused approach based on their goals and available budget. Instead of investing in every service, they can prioritise activities such as local SEO, targeted advertising or social media marketing. WiseUp’s packages start at ₹60,000, with the final scope depending on the services and deliverables required.' ),
	array( 'How will I know if my marketing is working?', 'Marketing performance can be assessed through indicators linked to your objectives. These may include website traffic, search visibility, enquiries, leads, conversions, engagement, and advertising performance. Regular reporting helps show what is contributing to progress and where the strategy may need adjustment.' ),
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
				<?php echo $wu_eyebrow( 'Digital marketing' ); // phpcs:ignore ?>
				<h1 class="ev-hero__h"><span class="sh__a">Digital Marketing Agency in Kerala</span></h1>
				<p class="dm-hero__sub">Your Next Stage of Growth Starts With the Right Digital Strategy</p>
				<p class="ev-hero__p">Your business deserves more than scattered campaigns and occasional social media posts. As a digital marketing agency in Kerala, WiseUp brings strategy, creativity and technology together to build stronger digital brand experiences. We look at your business, audience, competitors, and customer journey before deciding where and how to market your brand. From SEO and performance marketing to social media, content, branding and digital experiences, we connect the right activities to your business goals. Not just another agency managing channels, but a strategic partner invested in moving your brand forward.</p>
				<div class="ev-btns">
					<?php echo $wu_btn( 'Let’s Talk About Your Growth', 'teal', $wu_lead ); // phpcs:ignore ?>
					<?php echo $wu_btn( 'View Our Work', 'night', 'href="#results"' ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="ev-stage dm-plan" aria-hidden="true" data-stage>
				<div class="dm-plan__card">
					<div class="dm-plan__top"><span class="dm-plan__dot"></span><span>Growth plan</span><em>Draft 01</em></div>
					<p class="dm-plan__for">Prepared for <strong>your business</strong></p>
					<ul class="dm-plan__rows">
						<?php foreach ( array(
							array( 'search', 'Search', 'SEO + local search', '.84' ),
							array( 'target', 'Paid ads', 'Google + Meta', '.66' ),
							array( 'chat', 'Social', 'Content + reels', '.92' ),
							array( 'code', 'Website', 'Landing pages', '.54' ),
						) as $wu_i => $r ) : ?>
						<li style="--w:<?php echo esc_attr( $r[3] ); ?>;--i:<?php echo (int) $wu_i; ?>"><span class="dm-plan__ic"><?php echo $wu_svg( $wu_icons[ $r[0] ], 18, 1.7 ); // phpcs:ignore ?></span><span class="dm-plan__lab"><?php echo esc_html( $r[1] ); ?><small><?php echo esc_html( $r[2] ); ?></small></span><span class="dm-plan__bar"><i></i></span></li>
						<?php endforeach; ?>
					</ul>
					<div class="dm-plan__chart">
						<span class="dm-plan__k">Enquiries</span>
						<svg viewBox="0 0 320 96" preserveAspectRatio="none"><defs><linearGradient id="dm-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#c2f760" stop-opacity=".32"/><stop offset="1" stop-color="#c2f760" stop-opacity="0"/></linearGradient></defs><path class="dm-plan__area" d="M0 84 C40 82 60 76 90 70 S140 66 170 52 S230 40 260 26 S300 12 320 8 V96 H0z"/><path class="dm-plan__line" pathLength="1" d="M0 84 C40 82 60 76 90 70 S140 66 170 52 S230 40 260 26 S300 12 320 8"/></svg>
					</div>
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
		<?php $wu_tk = ''; foreach ( array( 'SEO', 'Google Ads', 'Meta Ads', 'Social Media', 'Content', 'Branding', 'Websites', 'Digital PR', 'AI Automation', 'CRM' ) as $t ) $wu_tk .= '<span>' . esc_html( $t ) . '</span><i></i>'; echo '<div>' . $wu_tk . '</div><div>' . $wu_tk . '</div>'; // phpcs:ignore ?>
	</div></div>

	<!-- 2. Good marketing moves business forward -->
	<section class="sec ev-sec" id="approach">
		<div class="wrap dm-split">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Why it matters' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Good Marketing Doesn’t Just Get Attention.', 'It Moves Business Forward.' ); // phpcs:ignore ?></h2>
			</div>
			<div class="dm-prose">
				<p class="ev-lead">Getting noticed is a start. Getting the right people to take action is what makes marketing valuable.</p>
				<p>Your audience needs to find your brand, understand what makes it relevant, and have a reason to choose you. That journey does not happen through a single advertisement or social media post. It takes consistent communication across the right channels, supported by a clear strategy.</p>
				<p>At WiseUp, we connect brand awareness, audience engagement, relevant website traffic, and lead generation into a more focused marketing approach. Every campaign, creative, and digital touchpoint should have a purpose, whether that is building recognition, generating enquiries, improving conversions or strengthening customer relationships.</p>
			</div>
			<ol class="dm-flow">
				<?php foreach ( array( array( 'Visibility', 'eye' ), array( 'Engagement', 'chat' ), array( 'Conversion', 'target' ), array( 'Growth', 'chart' ) ) as $wu_i => $fl ) : ?>
				<li><span class="dm-flow__i"><?php echo $wu_svg( $wu_icons[ $fl[1] ], 24 ); // phpcs:ignore ?></span><span class="dm-flow__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><strong><?php echo esc_html( $fl[0] ); ?></strong><?php if ( $wu_i < 3 ) : ?><span class="dm-flow__arr" aria-hidden="true">→</span><?php endif; ?></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 3. Services -->
	<section class="sec ev-sec" id="services">
		<div class="wrap">
			<div class="ev-head ev-head--center">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Services' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing Services That Bring', 'Every Part of Your Brand Together' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Your brand does not operate through separate channels, and your marketing should not either. We bring together the services your business needs, whether that means strengthening one area or building a connected strategy across multiple platforms.</p></div>
			</div>
			<ul class="ev-cards dm-svc">
				<?php foreach ( $wu_services as $wu_i => $s ) : ?>
				<li class="ev-card">
					<span class="ev-ico"><?php echo $wu_svg( $wu_icons[ $s[1] ] ); // phpcs:ignore -- fixed markup ?></span>
					<span class="dm-svc__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<p><?php echo esc_html( $s[2] ); ?></p>
					<?php if ( $s[3] ) : ?><a class="ev-more" href="<?php echo esc_url( $s[3] ); ?>">View Our Social Media Marketing Services <?php echo $wu_ne; // phpcs:ignore ?></a><?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 4. Marketing built around your business -->
	<section class="sec ev-sec" id="tailored">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Our approach' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Marketing Built Around Your Business,', 'Not a Ready-Made Template' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>Two businesses in the same industry can have completely different customers, competition, budgets and growth ambitions. So why should they follow the same marketing plan?</p><p>We start by understanding what your business needs before recommending services or platforms. The strategy is shaped around your position in the market, the people you want to reach, and the results you want to work towards.</p></div>
			</div>
			<ol class="dm-rows">
				<?php foreach ( $wu_approach as $wu_i => $a ) : ?>
				<li><span class="dm-rows__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><span class="dm-rows__i"><?php echo $wu_svg( $wu_icons[ $a[0] ], 24 ); // phpcs:ignore ?></span><h3><?php echo esc_html( $a[1] ); ?></h3><p><?php echo esc_html( $a[2] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 5. Channels -->
	<section class="sec ev-sec" id="channels">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Channels' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'The Right Strategy Starts', 'With the Right Channels' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p class="dm-intro-lead">Your audience is everywhere. Your marketing doesn’t need to be.</p><p>Each platform serves a different purpose. Some help people find your business when they are actively searching. Others introduce your brand, build relationships or create demand. We choose channels based on where your audience spends time and what you want them to do.</p></div>
			</div>
			<ul class="dm-ch">
				<?php foreach ( $wu_channels as $c ) : ?>
				<li>
					<span class="dm-ch__marks"><?php foreach ( $c[1] as $mk ) echo $wu_mark( $mk ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $c[0] ); ?></h3>
					<p><?php echo esc_html( $c[2] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 6. Every stage of growth -->
	<section class="sec ev-sec" id="stages">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Stage of growth' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing for Businesses', 'at Every Stage of Growth' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A startup building its first audience does not have the same priorities as an established business entering a new market. Your marketing should reflect where your business stands today and where it wants to go next.</p></div>
			</div>
			<ol class="dm-stages">
				<?php foreach ( $wu_stages as $wu_i => $s ) : ?>
				<li style="--s:<?php echo (int) $wu_i + 1; ?>">
					<span class="dm-stages__meter" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
					<span class="dm-stages__k" aria-hidden="true">Stage <?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<p><?php echo esc_html( $s[1] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 7. Industries -->
	<section class="sec ev-sec" id="industries">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Industries' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Industries', 'We Work With' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>We work with businesses across different sectors, adapting our marketing approach to their audiences, markets and business objectives.</p></div>
			</div>
			<ul class="dm-ind">
				<?php foreach ( $wu_industries as $wu_i => $ind ) : ?>
				<li><span class="dm-ind__i"><?php echo $wu_svg( $wu_icons[ $ind[1] ], 22 ); // phpcs:ignore ?></span><span class="dm-ind__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><strong><?php echo esc_html( $ind[0] ); ?></strong></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 8. Kerala's business landscape -->
	<section class="sec ev-sec" id="kerala">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Kerala' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Digital Marketing That Understands', 'Kerala’s Business Landscape' ); // phpcs:ignore ?></h2>
			</div>
			<div class="dm-kl">
				<div class="dm-kl__copy">
					<div class="ev-panel dm-kl__lead">
						<p class="ev-lead">Marketing works best when it reflects the people it is trying to reach. Kerala has diverse audiences, regional preferences and local buying behaviours that influence how businesses communicate. Language, location and customer expectations all matter.</p>
						<p>WiseUp considers these factors when planning campaigns for businesses targeting audiences in Kerala, as well as those looking to reach customers beyond the state. Whether your communication needs Malayalam, English or a combination of both, the approach should suit the audience and the brand.</p>
					</div>
					<div class="dm-kl__two">
						<div class="ev-panel"><span class="dm-kl__i"><?php echo $wu_svg( $wu_icons['pin'], 24 ); // phpcs:ignore ?></span><h3>Digital Marketing Company in Calicut, Kerala</h3><p>Based in Calicut, WiseUp works with businesses that want to strengthen their local presence and build a wider digital reach. We consider local search behaviour, audience interests and market competition when shaping campaigns for businesses in and around the city.</p></div>
						<div class="ev-panel"><span class="dm-kl__i"><?php echo $wu_svg( $wu_icons['globe'], 24 ); // phpcs:ignore ?></span><h3>Supporting Businesses Across Kerala and Beyond</h3><p>A business does not have to limit its reach to its immediate location. We work towards marketing objectives that may involve audiences across Kerala and, where relevant, wider national and international markets.</p></div>
					</div>
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

	<!-- 9. Process -->
	<section class="sec ev-sec" id="process">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Process' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'From Strategy to Execution:', 'How WiseUp Brings Marketing Ideas to Life' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro"><p>A strong campaign needs more than a good idea. It needs a clear plan, thoughtful execution, and regular evaluation. Our process connects each stage so that the work stays aligned with your business objectives.</p></div>
			</div>
			<ol class="ev-tsteps dm-steps">
				<?php foreach ( $wu_process as $wu_i => $s ) : ?>
				<li class="ev-step ev-tstep"><span class="ev-tstep__i"><?php echo $wu_svg( $wu_icons[ $s[1] ], 34, 1.5 ); // phpcs:ignore ?></span><h3><span class="ev-tstep__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?>.</span> <?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- 10. Tools -->
	<section class="sec ev-sec" id="tools">
		<div class="wrap">
			<div class="sh">
				<?php echo $wu_eyebrow( 'Tools' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'The Tools and Technology', 'Behind Smarter Campaigns' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="dm-tools">
				<?php foreach ( $wu_tools as $g ) : ?>
				<li>
					<h3><?php echo esc_html( $g[0] ); ?></h3>
					<ul class="dm-tools__list">
						<?php foreach ( $g[1] as $tl ) echo '<li>' . $wu_mark( $tl[1] ) . '<span>' . esc_html( $tl[0] ) . '</span></li>'; // phpcs:ignore ?>
					</ul>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 11. Why WiseUp -->
	<section class="sec ev-sec" id="why">
		<div class="wrap">
			<div class="sh dm-center">
				<?php echo $wu_eyebrow( 'Why WiseUp' ); // phpcs:ignore ?>
				<h2 class="sh__h"><?php echo $wu_h( 'Why Businesses', 'Choose WiseUp' ); // phpcs:ignore ?></h2>
			</div>
			<ul class="ev-exp" data-ev-exp>
				<?php foreach ( $wu_why as $wu_i => $w ) : ?>
				<li class="ev-exp__card<?php echo 0 === $wu_i ? ' is-on' : ''; ?>" tabindex="0"><span class="ev-exp__i"><?php echo $wu_svg( $wu_icons[ $w[0] ], 26 ); // phpcs:ignore ?></span><span class="ev-exp__n"><?php echo esc_html( sprintf( '%02d', $wu_i + 1 ) ); ?></span><h3><?php echo esc_html( $w[1] ); ?></h3><p><?php echo esc_html( $w[2] ); ?></p></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 12. Results -->
	<section class="sec ev-sec" id="results">
		<div class="wrap">
			<div class="ev-head">
				<div class="sh">
					<?php echo $wu_eyebrow( 'Results' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Real Campaigns.', 'Tangible Business Results.' ); // phpcs:ignore ?></h2>
				</div>
				<div class="ev-intro dm-intro-btn"><?php echo $wu_btn( 'View Our Case Studies', 'teal', 'href="' . esc_url( home_url( '/case-studies/' ) ) . '"' ); // phpcs:ignore ?></div>
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

	<!-- 13. Client experiences -->
	<section class="sec ev-sec" id="reviews">
		<div class="wrap">
			<div class="ev-quotes" data-quotes>
				<div class="ev-quotes__head">
					<h2 class="ev-quotes__h sh__h"><?php echo $wu_h( 'Beyond Campaigns:', 'Client Experiences' ); // phpcs:ignore ?></h2>
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

	<!-- 14. Pricing -->
	<section class="sec ev-sec" id="pricing">
		<div class="wrap">
			<div class="ev-disc">
				<div class="ev-disc__l">
					<div class="sh">
						<?php echo $wu_eyebrow( 'Pricing' ); // phpcs:ignore ?>
						<h2 class="sh__h"><?php echo $wu_h( 'Clear Pricing,', 'Defined Deliverables' ); // phpcs:ignore ?></h2>
					</div>
					<div class="ev-price ev-price--col">
						<p>Every business has different marketing requirements, so the scope of work should reflect what it actually needs. WiseUp’s packages start at ₹60,000, with the final proposal based on your goals, selected services, campaign requirements and expected deliverables.</p>
					</div>
				</div>
				<div class="ev-disc__card">
					<span class="ev-disc__pill">Digital marketing packages</span>
					<p class="ev-disc__from"><span>Packages start at</span><strong>₹60,000</strong></p>
					<?php echo $wu_btn( 'Get Your Custom Proposal', 'teal', $wu_lead ); // phpcs:ignore ?>
				</div>
			</div>
			<div class="dm-pkg">
				<div class="dm-pkg__table">
					<h3>What Your Package Can Cover</h3>
					<table>
						<thead><tr><th scope="col">Area</th><th scope="col">Potential Deliverables</th></tr></thead>
						<tbody>
							<?php foreach ( $wu_package as $row ) : ?>
							<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td><?php echo esc_html( $row[1] ); ?></td></tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<p class="ev-note">The deliverables included in a package depend on the agreed scope. Not every service or activity is included in the starting package.</p>
				</div>
				<div class="dm-pkg__side">
					<div class="ev-panel">
						<h3>What Influences the Final Investment?</h3>
						<p>The final investment depends on the number of services and platforms involved, content volume, creative production requirements, advertising objectives, campaign complexity and any website or technical work needed.</p>
					</div>
					<div class="ev-panel dm-pkg__cta">
						<h3>Not Sure Where Your Marketing Budget Should Go?</h3>
						<p>You do not have to invest in every channel at once. Tell us what your business wants to achieve, and we can recommend a practical scope based on your priorities and budget.</p>
						<?php echo $wu_btn( 'Get Your Custom Proposal', 'teal', $wu_lead ); // phpcs:ignore ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 15. FAQ (with FAQPage schema) -->
	<section class="sec ev-sec" id="faq" aria-labelledby="dm-faq-h">
		<div class="wrap ev-faqsplit">
			<div class="sh">
				<?php echo $wu_eyebrow( 'FAQ' ); // phpcs:ignore ?>
				<h2 id="dm-faq-h" class="sh__h"><?php echo $wu_h( 'Frequently Asked', 'Questions' ); // phpcs:ignore ?></h2>
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

	<!-- 16. Final CTA: lead form (Name | Business Name | Email | Phone | Services Required | Tell Us About Your Project) -->
	<section class="sec ev-sec" id="enquire">
		<div class="wrap">
			<div class="ev-final">
				<div class="ev-final__copy">
					<?php echo $wu_eyebrow( 'Get started' ); // phpcs:ignore ?>
					<h2 class="sh__h"><?php echo $wu_h( 'Ready to Give Your Brand', 'a Stronger Direction?' ); // phpcs:ignore ?></h2>
					<p class="ev-final__p">Let’s discuss where your brand stands, what you want to achieve, and how WiseUp can help move things forward.</p>
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
					<button class="b b--teal ev-form__send" type="submit"><span class="b__label">Let’s Talk About Your Growth</span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></button>
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
	var mineSel = '.dm-flow li, .dm-rows li, .dm-ch li, .dm-stages li, .dm-ind li, .dm-kl .ev-panel, .dm-tools > li, .dm-res__card, .dm-pkg__table, .dm-pkg .ev-panel, .ev-quotes';
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
<?php
$wu_lead_source = $wu_src;
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'event-branding.js', 'ev-map.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "\n";
}
wiseup_landing_close( $wu_src );
