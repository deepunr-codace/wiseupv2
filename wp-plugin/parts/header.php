<?php
/**
 * WiseUp header. Mirrors wiseup-site/src/components/Header.astro (same markup and classes, so the site's CSS and JS
 * apply unchanged); keep the two in sync. Variables: $wu_slug (home, about, contact, podcast).
 */
defined( 'ABSPATH' ) || exit;

$wu_page    = wiseup_manifest_page( $wu_slug );
$wu_podcast = 'podcast' === $wu_slug;
$wu_home    = 'home' === $wu_slug;
$wu_links   = wiseup_links( 'wiseup-header' );
// The button: the setting, else this page's own target from the build (a site path or an on-page #anchor).
$wu_cta     = $wu_page && $wu_page['cta'] ? $wu_page['cta'] : '/#contact';
$wu_cta     = 0 === strpos( $wu_cta, '/' ) ? home_url( $wu_cta ) : $wu_cta;
$wu_cta     = wiseup_opt( 'cta_url' ) ? wiseup_opt( 'cta_url' ) : $wu_cta;
// /podcast's button reads "Get featured" (Header.astro's ctaLabel), other pages use the setting.
$wu_cta_lbl = $wu_podcast ? __( 'Get featured', 'wiseup' ) : wiseup_opt( 'cta_label' );
$wu_sub     = $wu_podcast && wiseup_opt( 'podcast_subscribe' );
$wu_target  = function ( $link ) { return $link['external'] ? ' target="_blank" rel="noopener"' : ''; };
?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'wiseup' ); ?></a>
<header class="hd" data-head>
	<?php if ( $wu_podcast ) : ?>
		<a class="hd__logo hd__logo--podcast" href="#top" aria-label="<?php esc_attr_e( 'WiseUp Podcast, back to top', 'wiseup' ); ?>"><img src="<?php echo esc_url( wiseup_logo_url( true ) ); ?>" alt="<?php esc_attr_e( 'WiseUp Podcast', 'wiseup' ); ?>" width="404" height="174" decoding="async"></a>
	<?php else : ?>
		<a class="hd__logo<?php echo 'about' === $wu_slug ? ' hd__logo--dark' : ''; ?>" href="<?php echo $wu_home ? '#top' : esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo $wu_home ? esc_attr__( 'WiseUp, back to top', 'wiseup' ) : esc_attr__( 'WiseUp home', 'wiseup' ); ?>"><img src="<?php echo esc_url( wiseup_logo_url( false ) ); ?>" alt="WiseUp" width="315" height="114" decoding="async"></a>
	<?php endif; ?>

	<nav class="hd__nav" aria-label="<?php esc_attr_e( 'WiseUp sites', 'wiseup' ); ?>">
		<?php foreach ( $wu_links as $l ) : ?>
			<a class="hd__link" href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $wu_target( $l ); // phpcs:ignore -- static attributes ?>><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?></a>
		<?php endforeach; ?>
	</nav>

	<div class="hd__actions">
		<?php if ( wiseup_opt( 'theme_toggle' ) ) : ?>
			<button class="hd__theme" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Switch to light mode', 'wiseup' ); ?>" aria-pressed="false"><span class="hd__theme-ico"><?php echo wiseup_icon( 'moon' ) . wiseup_icon( 'sun' ); // phpcs:ignore -- static SVG ?></span></button>
		<?php endif; ?>

		<?php if ( $wu_sub ) : ?>
			<a class="hd__sub" href="<?php echo esc_url( wiseup_opt( 'subscribe_url' ) ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Subscribe to WiseUp Podcast on YouTube', 'wiseup' ); ?>">
				<?php echo str_replace( '<svg ', '<svg class="hd__sub-yt" ', wiseup_icon( 'yt-logo' ) ); // phpcs:ignore -- static SVG ?>
				<span class="hd__sub-label"><?php esc_html_e( 'Subscribe', 'wiseup' ); ?></span>
				<?php if ( wiseup_opt( 'subscribe_count' ) ) : ?><span class="hd__sub-count" aria-hidden="true"><?php echo esc_html( wiseup_opt( 'subscribe_count' ) ); ?></span><?php endif; ?>
			</a>
		<?php endif; ?>

			<a class="hd__cta" href="<?php echo esc_url( $wu_cta ); ?>"><span class="hd__cta-glow" aria-hidden="true"></span><span class="hd__cta-border" aria-hidden="true"></span><span class="hd__cta-shine" aria-hidden="true"></span><span class="hd__cta-inner"><span class="hd__cta-label"><?php echo esc_html( $wu_cta_lbl ); ?></span></span></a>

		<button class="hd__menu" type="button" aria-expanded="false" aria-controls="menu" data-menu-btn><?php echo wiseup_icon( 'menu' ); // phpcs:ignore -- static SVG ?><span><?php esc_html_e( 'Menu', 'wiseup' ); ?></span></button>
	</div>
	<div class="menu" id="menu" hidden data-menu>
		<?php foreach ( $wu_links as $l ) : ?>
			<a href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $wu_target( $l ); // phpcs:ignore -- static attributes ?> data-menu-link><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?></a>
		<?php endforeach; ?>
		<a class="b b--teal b--block" href="<?php echo esc_url( $wu_cta ); ?>" data-menu-link="true"><span class="b__label"><?php echo esc_html( $wu_cta_lbl ); ?></span><span class="b__ico"><?php echo wiseup_icon( 'arrow' ) . wiseup_icon( 'arrow' ); // phpcs:ignore -- static SVG ?></span></a>
	</div>
</header>
