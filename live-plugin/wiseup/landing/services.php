<?php
/**
 * Services listing page ("WiseUp: Services" in the page Template dropdown). Uses the WiseUp header and footer
 * (includes/landing.php), assets/css/services.css and the lead popup. The services, icons and tags are the homepage's
 * (site.ts `services`); a service links to its own landing page when a published page uses that template.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', function () {
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/services.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/services.css' ) ) . "\">\n";
}, 7 );

// Marks the page for motion before first paint (so hidden-before-reveal content never flashes). If the scripts fail to
// run within 3s the flag is removed again and everything shows.
add_action( 'wp_head', function () {
	echo "<script>(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var d=document.documentElement;d.classList.add('wu-motion');setTimeout(function(){if(!window.__wuSvcMotion)d.classList.remove('wu-motion');},3000);})();</script>
";
}, 1 );


$wu_svc_icons = array(
	'signature' => '<path d="M3 17c2-6 3.5-11 5-11 1.5 0 .5 7-1 10s-1 2 1 0 3-5 4-5 0 4 1 4 2-3 3-3 1 2 2 2 2-1 2-1"/>',
	'box'       => '<path d="M3.5 7.5 12 3l8.5 4.5v9L12 21l-8.5-4.5z"/><path d="M3.5 7.5 12 12l8.5-4.5M12 12v9"/>',
	'code'      => '<path d="m8 8-4 4 4 4M16 8l4 4-4 4M13.5 5l-3 14"/>',
	'search'    => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/>',
	'target'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r=".6"/>',
	'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18a14 14 0 0 1 0-18Z"/>',
	'chat'      => '<path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7a2.5 2.5 0 0 1-2.5 2.5H10l-4.5 4v-4h0A1.5 1.5 0 0 1 4 14.5z"/>',
	'video'     => '<rect x="3" y="6" width="13" height="12" rx="2.5"/><path d="m16 10.5 5-3v9l-5-3"/>',
	'megaphone' => '<path d="M4 10v4a1 1 0 0 0 1 1h2l7 4V5L7 9H5a1 1 0 0 0-1 1Z"/><path d="M17.5 9.5a3.5 3.5 0 0 1 0 5"/>',
);

// The service structure (same as the Services menu in the header): title, visual/icon, chips, page it links to (if one is
// published), the lead popup's service option, anchor id.
$wu_dm_url   = wiseup_svc_page_url( 'wiseup-digital-marketing' );
$wu_seo_url  = wiseup_svc_page_url( 'wiseup-seo' );
$wu_ppc_url  = wiseup_svc_page_url( 'wiseup-performance-marketing' ) ?: wiseup_svc_page_url( 'wiseup-performance' );
$wu_ev_url   = wiseup_svc_page_url( 'wiseup-event-branding' );
$wu_studio   = wiseup_svc_page_url( 'wiseup-studio' );
$wu_services = array(
	array( 'Digital Marketing', 'globe', array( 'Content Marketing', 'Digital Branding', 'Website Development', 'Digital PR', 'AI Automation & CRM' ), 'https://wiseup.in/services/digital-marketing-agency-in-kerala/', 'Digital Marketing & Social Media', 'digital-marketing' ),
	array( 'Social Media Marketing', 'chat', array( 'Influencer Marketing', 'PR (Public Relations)', 'Engagement', 'Crisis Management', 'Sponsorship' ), 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/', 'Digital Marketing & Social Media', 'social-media' ),
	array( 'SEO (Search Engine Optimization)', 'search', array( 'SEO Strategy & Keyword Research', 'On-Page SEO', 'Technical SEO', 'Local SEO', 'AI SEO' ), 'https://wiseup.in/services/seo-company-in-kerala/', 'SEO Services', 'seo' ),
	array( 'Performance Marketing (PPC)', 'target', array( 'Google Ads', 'Meta Ads' ), '', 'Performance Marketing', 'ppc' ),
	array( 'Video Production & Photography', 'video', array( 'Corporate Films', 'Presentation (PPT)', 'Concept Videos', 'CGI Videos', 'AI Videos' ), '', 'Video & Photography', 'video' ),
	array( 'Brand Solutions', 'signature', array( 'Logo Design', 'Corporate Identity', 'Consultancy', 'Product Packaging', 'Signage', 'Print Production' ), '', 'Brand Strategy & Identity', 'brand-solutions' ),
	array( 'Strategic Campaigns', 'megaphone', array( 'OOH Campaigns', 'Print Campaigns', 'Digital Campaigns', 'Video Campaigns', 'Radio Campaigns' ), '', 'Campaigns & Media Buying', 'campaigns' ),
	array( 'Strategic Planning', 'target', array( 'Market Research', 'Promotional Plans' ), '', 'Brand Strategy & Identity', 'strategic-planning' ),
	array( 'Media & Release', 'megaphone', array( 'Media Buying', 'Media Planning', 'Media Monitoring', 'Print Media Release' ), '', 'Campaigns & Media Buying', 'media' ),
	array( 'Event Branding', 'box', array( 'Corporate Events', 'Virtual & Hybrid Events', 'Stage, Backdrops & Entrances', 'Badges & Printed Material' ), '', 'Packaging Design & Events', 'event-branding' ),
	array( 'Web Solutions', 'code', array( 'ERP Solutions', 'Business Websites', 'Online Stores' ), '', 'Web Development', 'web' ),
);

$wu_svc_vis = require WISEUP_DIR . 'landing/services-visuals.php';
$wu_svc_wide = array( 0, 6, 10 ); // bento: these cards span wider, picture beside the text

$wu_arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>';

wiseup_landing_open( 'wu-landing wu-svc-page' );
?>
<main id="main" class="wu-svc">
	<section class="sv-hero">
		<div class="sv-glow" aria-hidden="true"></div>
		<div class="sv-wrap">
			<span class="sv-pill" data-reveal="fade" data-intro><span class="sv-dot" aria-hidden="true"></span><?php esc_html_e( 'Our services', 'wiseup' ); ?></span>
			<h1 data-split="lines" data-intro><span><?php esc_html_e( 'Every channel.', 'wiseup' ); ?></span> <span class="sv-dim"><?php esc_html_e( 'One strategy.', 'wiseup' ); ?></span></h1>
			<p data-reveal="up" data-intro data-delay="0.3"><?php esc_html_e( 'Branding, design, web and digital marketing for businesses in Kozhikode, Kerala and across India, all from one team.', 'wiseup' ); ?></p>
		</div>
	</section>

<?php wiseup_ai_overview( array(
	'q' => 'What services does WiseUp offer?',
	'a' => '<b>WiseUp</b> offers <b>digital marketing, social media marketing, SEO, performance marketing, video production and photography, brand solutions, strategic campaigns, strategic planning, media and release, event branding and web solutions</b> under one roof. Pick one service or combine several into one plan.',
	'points' => array(
		array( 'Marketing', 'Digital marketing, social media marketing, SEO and performance marketing (PPC).' ),
		array( 'Brand and production', 'Brand solutions, video production and photography, event branding.' ),
		array( 'Planning and reach', 'Strategic campaigns, strategic planning, media and release, and web solutions.' ),
	),
	'links' => array( array( 'All services', '#wu-svc-list' ), array( 'Get our plan', '#wu-svc-cta' ) ),
) ); ?>	<section class="sv-list" id="wu-svc-list" aria-label="<?php esc_attr_e( 'All services', 'wiseup' ); ?>">
		<div class="sv-wrap">
			<ol class="sv-grid">
				<?php foreach ( $wu_services as $i => $s ) :
					$n    = sprintf( '%02d', $i + 1 );
					?>
					<li class="sv-card sv-card--<?php echo esc_attr( $s[1] ); ?><?php echo in_array( $i, $wu_svc_wide, true ) ? ' sv-card--wide' : ''; ?>" data-card id="svc-<?php echo esc_attr( $s[5] ); ?>">
						<div class="sv-vis" aria-hidden="true"><?php echo $wu_svc_vis[ $s[1] ]; // phpcs:ignore -- fixed markup ?></div>
						<div class="sv-card__body">
							<div class="sv-card__top">
								<span class="sv-card__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $wu_svc_icons[ $s[1] ]; // phpcs:ignore -- fixed markup above ?></svg></span>
								<span class="sv-card__n" aria-hidden="true" data-count="<?php echo (int) $i + 1; ?>"><?php echo esc_html( $n ); ?></span>
							</div>
							<h2 class="sv-card__t"><?php echo esc_html( $s[0] ); ?></h2>
							<ul class="sv-chips">
								<?php foreach ( $s[2] as $tag ) : ?><li><?php echo esc_html( $tag ); ?></li><?php endforeach; ?>
							</ul>
							<div class="sv-card__foot">
								<?php if ( ! empty( $s[3] ) ) : ?>
									<a class="sv-link" href="<?php echo esc_url( $s[3] ); ?>"><?php esc_html_e( 'Explore service', 'wiseup' ); ?> <?php echo $wu_arrow; // phpcs:ignore ?></a>
								<?php endif; ?>
								<button class="sv-link sv-link--ghost" type="button" data-lead-open data-lead-source="services" data-svc-pick="<?php echo esc_attr( $s[4] ); ?>"><?php esc_html_e( 'Get our plan', 'wiseup' ); ?> <?php echo $wu_arrow; // phpcs:ignore ?></button>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="sv-cta" id="wu-svc-cta">
		<div class="sv-wrap sv-cta__box" data-reveal="scale">
			<h2 data-split="lines"><?php esc_html_e( 'See the plan before you see a price.', 'wiseup' ); ?></h2>
			<div class="sv-cta__btns" data-reveal="up" data-delay="0.2">
				<button class="sv-btn" type="button" data-lead-open data-lead-source="services"><?php echo esc_html( wiseup_opt( 'cta_label' ) ? wiseup_opt( 'cta_label' ) : __( 'Get our plan', 'wiseup' ) ); ?></button>
				<a class="sv-btn sv-btn--ghost" href="https://wa.me/916282434503" target="_blank" rel="noopener"><?php esc_html_e( 'Chat on WhatsApp', 'wiseup' ); ?></a>
			</div>
		</div>
	</section>
</main>
<script>
// "Get our plan" on a card opens the lead popup with that service already chosen.
document.addEventListener('click', function (e) {
	var t = e.target.closest && e.target.closest('[data-svc-pick]');
	if (!t) return;
	var v = t.getAttribute('data-svc-pick');
	setTimeout(function () {
		var sel = document.querySelector('[data-lead-form] select');
		if (!sel) return;
		for (var i = 0; i < sel.options.length; i++) if (sel.options[i].value === v) { sel.value = v; sel.dispatchEvent(new Event('change', { bubbles: true })); break; }
	}, 0);
}, true); // capture, registered before the popup's own capture listener (which stops the event)
</script>
<?php
$wu_lead_source = 'services';
include WISEUP_DIR . 'landing/lead-popup.php';
foreach ( array( 'vendor/gsap.min.js', 'vendor/ScrollTrigger.min.js', 'vendor/SplitText.min.js', 'vendor/lenis.min.js', 'services.js' ) as $wu_js ) {
	echo '<script src="' . esc_url( WISEUP_URL . 'assets/js/' . $wu_js . '?ver=' . filemtime( WISEUP_DIR . 'assets/js/' . $wu_js ) ) . '"></script>' . "
";
}
wiseup_landing_close( 'services' );
