<?php
/**
 * 404 page template: Wiso, the WiseUp mascot, looking for the missing page inside a giant 404 (brand-wide, not tied to one service), a warm line, search and the main places to go.
 * See includes/error-404.php. Hoarding photo = the Media Buying one (assets/landing/img/mb-ang-*.webp); the poster is warped onto its face by the script below.
 */
defined( 'ABSPATH' ) || exit;
status_header( 404 );
nocache_headers();
wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-404-page' );
$wu_wa  = 'https://wa.me/916282434503?text=' . rawurlencode( 'Hi WiseUp, I could not find a page on your website.' );
$wu_ar  = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$wu_img = WISEUP_URL . 'assets/landing/img/mb-ang-';
$wu_links = array(
	array( __( 'Digital Marketing', 'wiseup' ), 'https://wiseup.in/services/digital-marketing-agency-in-kerala/' ),
	array( __( 'Social Media Marketing', 'wiseup' ), 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/' ),
	array( __( 'SEO', 'wiseup' ), 'https://wiseup.in/services/seo-company-in-kerala/' ),
	array( __( 'All services', 'wiseup' ), home_url( '/services/' ) ),
	array( __( 'Case studies', 'wiseup' ), home_url( '/case-studies/' ) ),
	array( __( 'Portfolio', 'wiseup' ), home_url( '/portfolio/' ) ),
	array( __( 'Blog', 'wiseup' ), home_url( '/blog/' ) ),
	array( __( 'Contact', 'wiseup' ), home_url( '/contact/' ) ),
);
?>
<div class="wiseup-home wiseup-in-theme wu-404">
<main id="main">
	<section class="e404">
		<div class="e404__in">
			<div class="e404__copy">
				<p class="eyebrow"><span class="eyebrow__dot" aria-hidden="true"></span><?php esc_html_e( 'Error 404', 'wiseup' ); ?></p>
				<h1 class="e404__h"><?php esc_html_e( 'We could not find that page.', 'wiseup' ); ?> <span><?php esc_html_e( 'Wiso is still looking.', 'wiseup' ); ?></span></h1>
				<p class="e404__p"><?php esc_html_e( 'The link may be old or mistyped. Search the site, or head to one of the places below.', 'wiseup' ); ?></p>
				<form class="e404__s" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="e404-q"><?php esc_html_e( 'Search', 'wiseup' ); ?></label>
					<input id="e404-q" type="search" name="s" placeholder="<?php esc_attr_e( 'Search WiseUp', 'wiseup' ); ?>" autocomplete="off">
					<button class="b b--teal" type="submit"><span class="b__label"><?php esc_html_e( 'Search', 'wiseup' ); ?></span></button>
				</form>
				<div class="e404__btns">
					<a class="b b--teal" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="b__label"><?php esc_html_e( 'Back to home', 'wiseup' ); ?></span><span class="b__ico"><?php echo $wu_ar; // phpcs:ignore ?></span></a>
					<a class="b b--night" href="<?php echo esc_url( $wu_wa ); ?>" target="_blank" rel="noopener"><span class="b__label"><?php esc_html_e( 'Chat on WhatsApp', 'wiseup' ); ?></span><span class="b__ico"><?php echo $wu_ar; // phpcs:ignore ?></span></a>
				</div>
			</div>
			<div class="e404__vis" aria-hidden="true">
				<span class="e404__d">4</span>
				<span class="e404__o"><i class="e404__orbit"><b>?</b><b>?</b><b>?</b></i><img class="e404__wiso" src="<?php echo esc_url( WISEUP_URL . 'assets/smm/wiso-icon.webp' ); ?>" width="200" height="200" alt="" decoding="async"></span>
				<span class="e404__d">4</span>
			</div>
		</div>
		<ul class="e404__l e404__in">
			<?php foreach ( $wu_links as $l ) : ?><li><a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?><?php echo $wu_ar; // phpcs:ignore ?></a></li><?php endforeach; ?>
		</ul>
	</section>
</main>
</div>
<?php wiseup_landing_close( '404' ); ?>
