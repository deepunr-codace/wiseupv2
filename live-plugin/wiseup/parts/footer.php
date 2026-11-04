<?php
/**
 * WiseUp footer. Mirrors wiseup-site/src/components/Footer.astro (same markup and classes); keep the two in sync.
 * Variables: $wu_slug. The podcast page gets its own layout: logo and description, the podcast's social icons, then
 * Company, Resources and Elsewhere columns. Its links are fixed here, as in Footer.astro.
 */
defined( 'ABSPATH' ) || exit;

$wu_podcast = 'podcast' === $wu_slug;
$wu_social  = wiseup_opt( $wu_podcast ? 'social_podcast' : 'social' );
if ( ! $wu_podcast && empty( $wu_social['youtube'] ) ) $wu_social['youtube'] = 'https://www.youtube.com/@Brandingwithwiseup'; // owner, 2026-11-03
$wu_follow  = wiseup_opt( $wu_podcast ? 'follow_text_podcast' : 'follow_text' );
// Agency footer: every service from the homepage list, each pointing at that section (same list as Footer.astro).
// Owner, 2026-11-03: '#' for now, except Social Media Marketing, which has its own page.
$wu_services = array( 'Brand Strategy & Identity' => '#', 'Packaging Design & Events' => '#', 'Web Development' => '#', 'SEO Services' => '#', 'Performance Marketing' => '#', 'Digital Marketing' => '#', 'Social Media Marketing' => 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/', 'Video & Photography' => '#', 'Campaigns & Media Buying' => '#' );
// Quick Links and Useful Links are one column (owner, 2026-11-03): both link lists under the Quick Links heading.
$wu_lists   = array(
	'quick'  => array( 'id' => 'ft-quick', 'title' => wiseup_opt( 'footer_h_quick' ), 'links' => array_merge( wiseup_links( 'wiseup-footer-quick' ), wiseup_links( 'wiseup-footer-useful' ) ) ),
);
// Podcast columns, the same links as the podcastCompany / podcastResources / podcastElsewhere arrays in Footer.astro.
$wu_podcast_cols = array(
	array( 'id' => 'ft-company', 'title' => 'Company', 'links' => array(
		array( 'About WiseUp', home_url( '/about/' ), false ),
		array( 'Contact', home_url( '/contact/' ), false ),
		array( 'Sponsor the show', '#sponsor-enquiry', false ),
		array( 'Get featured', home_url( '/podcast/#get-featured' ), false ),
		array( "Brands we've worked with", '#brands', false ),
	) ),
	array( 'id' => 'ft-resources', 'title' => 'Resources', 'links' => array(
		array( 'Latest episodes', '#episodes', false ),
		array( 'Topics', '#topics', false ),
		array( 'Hosts', '#hosts', false ),
		array( 'FAQ', '#faq', false ),
	) ),
	array( 'id' => 'ft-elsewhere', 'title' => 'Elsewhere', 'links' => array(
		array( 'WiseUp TV', 'https://wiseup.in/wiseup-tv/', true ),
		array( 'WiseUp Studio', 'https://wiseup.in/wiseup-studio/', true ),
		array( 'WiseUp Branding', 'https://wiseup.in', true ),
		array( 'CodeAce IT Solutions', 'https://codeace.com/', true ),
	) ),
);
$wu_credit  = wiseup_opt( 'credit_name' );
$wu_tagline = $wu_podcast
	? 'A weekly Malayalam business podcast, watched by founders and business owners who are building their brands online.'
	: wiseup_opt( 'footer_tagline' );
?>
<footer class="ft">
	<div class="wrap ft__top">
		<div class="ft__intro">
			<?php if ( ! $wu_podcast ) : ?>
				<a class="ft__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'WiseUp home', 'wiseup' ); ?>"><img src="<?php echo esc_url( WISEUP_ASSETS . '/brand/wiseup-branding.webp' ); ?>" alt="WiseUp Branding" width="200" height="104" loading="lazy" decoding="async"></a>
			<?php endif; ?>
			<?php if ( $wu_podcast ) : ?>
				<img class="ft__logo" src="<?php echo esc_url( wiseup_logo_url( true ) ); ?>" alt="WiseUp Podcast" width="404" height="174" loading="lazy" decoding="async">
			<?php endif; ?>
			<?php if ( $wu_tagline ) : ?><p class="<?php echo $wu_podcast ? 'ft__tag ft__tag--sm' : 'ft__tag'; ?>"><?php echo esc_html( $wu_tagline ); ?></p><?php endif; ?>
			<?php if ( ! $wu_podcast ) : ?>
				<p class="ft__pillars">Branding<span aria-hidden="true">|</span>Ads<span aria-hidden="true">|</span>Digital Strategy</p>
			<?php endif; ?>
			<?php if ( $wu_podcast ) : ?>
				<ul class="ft__social">
					<?php foreach ( wiseup_networks() as $network => $label ) : ?>
						<?php if ( 'email' === $network || empty( $wu_social[ $network ] ) ) continue; // no Gmail icon (owner, 2026-11-03) ?>
						<li><a class="ft__soc ft__soc--<?php echo esc_attr( wiseup_social_mod( $network ) ); ?>" href="<?php echo esc_url( wiseup_social_href( $network, $wu_social[ $network ] ) ); ?>"<?php echo 'email' === $network ? '' : ' target="_blank"'; ?> rel="me noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo wiseup_icon( $network ); // phpcs:ignore -- static SVG ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php if ( $wu_podcast ) : ?>
			<?php foreach ( $wu_podcast_cols as $col ) : ?>
				<nav class="ft__col" aria-labelledby="<?php echo esc_attr( $col['id'] ); ?>">
					<h2 class="ft__h" id="<?php echo esc_attr( $col['id'] ); ?>"><?php echo esc_html( $col['title'] ); ?></h2>
					<ul>
						<?php foreach ( $col['links'] as $l ) : ?>
							<li><a class="ft__link" href="<?php echo esc_url( $l[1] ); ?>"<?php echo $l[2] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $l[0] ); ?><?php if ( $l[2] ) : ?><span class="ft__ext" aria-hidden="true">↗</span><?php endif; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
		<?php else : ?>
			<nav class="ft__col ft__services" aria-labelledby="ft-services">
				<h2 class="ft__h" id="ft-services"><?php echo esc_html( wiseup_opt( 'footer_h_services' ) ); ?></h2>
				<ul>
					<?php foreach ( $wu_services as $svc => $svc_url ) : ?>
						<li><a class="ft__link" href="<?php echo '#' === $svc_url ? '#' : esc_url( $svc_url ); ?>"><?php echo esc_html( $svc ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<?php foreach ( $wu_lists as $list ) : ?>
				<nav class="ft__col" aria-labelledby="<?php echo esc_attr( $list['id'] ); ?>">
					<h2 class="ft__h" id="<?php echo esc_attr( $list['id'] ); ?>"><?php echo esc_html( $list['title'] ); ?></h2>
					<ul>
						<?php foreach ( $list['links'] as $l ) : ?>
							<li><a class="ft__link" href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $l['external'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $l['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
			<div class="ft__col ft__follow">
				<h2 class="ft__h"><?php esc_html_e( 'Branding With Wiseup', 'wiseup' ); ?></h2>
				<p class="ft__lead">We turn <em class="ft__lead-a">bold ideas</em> into <span class="ft__lead-b">brand realities</span></p>
				<ul class="ft__contact">
					<?php $wu_mail = ! empty( $wu_social['email'] ) ? $wu_social['email'] : 'brandingwithwiseup@gmail.com'; ?>
					<li><a href="<?php echo esc_url( 'mailto:' . $wu_mail ); ?>"><?php echo wiseup_icon( 'mail-chip' ); // phpcs:ignore -- static SVG ?><span><?php echo esc_html( $wu_mail ); ?></span></a></li>
					<?php if ( wiseup_opt( 'contact_phone' ) ) : ?><li><a href="<?php echo esc_url( wiseup_opt( 'contact_phone_href' ), array( 'tel' ) ); ?>"><?php echo wiseup_icon( 'call-chip' ); // phpcs:ignore -- static SVG ?><span><?php echo esc_html( wiseup_opt( 'contact_phone' ) ); ?></span></a></li><?php endif; ?>
					<li><a href="<?php echo esc_url( wiseup_opt( 'contact_map' ) ); ?>" target="_blank" rel="noopener"><?php echo wiseup_icon( 'pin-chip' ); // phpcs:ignore -- static SVG ?><address><?php esc_html_e( '3rd Floor, Sahya Building, Govt. Cyberpark, Nellikode, Kozhikode', 'wiseup' ); ?></address></a></li>
				</ul>
				<ul class="ft__social">
					<?php foreach ( wiseup_networks() as $network => $label ) : ?>
						<?php if ( 'email' === $network || empty( $wu_social[ $network ] ) ) continue; // no Gmail icon (owner, 2026-11-03) ?>
						<li><a class="ft__soc ft__soc--<?php echo esc_attr( wiseup_social_mod( $network ) ); ?>" href="<?php echo esc_url( wiseup_social_href( $network, $wu_social[ $network ] ) ); ?>"<?php echo 'email' === $network ? '' : ' target="_blank"'; ?> rel="me noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo wiseup_icon( $network ); // phpcs:ignore -- static SVG ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( wiseup_opt( 'wordmark' ) ) : ?>
		<div class="ft__word" aria-hidden="true" data-ft-word2><span class="ft__word-text">wiseup</span><canvas class="ft__canvas"></canvas></div>
		<?php // The dot wordmark builds itself from the text on start (a few hundred ms on a phone), so its script is fetched only once the footer is a couple of screens away. ?>
		<script>(function(){var w=document.querySelector('[data-ft-word2]');if(!w)return;var load=function(){var s=document.createElement('script');s.src=<?php echo wp_json_encode( WISEUP_ASSETS . '/js/footer-word.js?v=13' ); ?>;document.body.appendChild(s);};if(!('IntersectionObserver' in window))return load();var io=new IntersectionObserver(function(es){if(es[0].isIntersecting){io.disconnect();load();}},{rootMargin:'0px 0px 200% 0px'});io.observe(w);})();</script>
	<?php endif; ?>
		<div class="wrap ft__base">
			<p>© <?php echo esc_html( gmdate( 'Y' ) . ' ' . wiseup_opt( 'copyright' ) ); ?></p>
			<a class="ft__ca" href="https://codeace.com/" target="_blank" rel="noopener" aria-label="From the CodeAce family (opens codeace.com)"><img class="ft__ca-mark" src="<?php echo esc_url( WISEUP_ASSETS . '/brand/codeace-mark.webp' ); ?>" alt="CodeAce logo" width="96" height="96" loading="lazy" decoding="async" /><span class="ft__ca-txt">From the <b>CodeAce</b> family</span><svg class="ft__ca-go" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
			<?php if ( $wu_credit ) : ?>
				<p><?php esc_html_e( 'Crafted by', 'wiseup' ); ?> <?php if ( wiseup_opt( 'credit_url' ) ) : ?><a class="ft__credit" href="<?php echo esc_url( wiseup_opt( 'credit_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $wu_credit ); ?></a><?php else : ?><b class="ft__credit"><?php echo esc_html( $wu_credit ); ?></b><?php endif; ?></p>
			<?php endif; ?>
		</div>
</footer>
