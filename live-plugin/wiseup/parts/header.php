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
$wu_cta     = apply_filters( 'wiseup_header_cta', $wu_cta, $wu_slug );
// /podcast's button reads "Get featured" (Header.astro's ctaLabel), other pages use the setting.
$wu_cta_lbl = $wu_podcast ? __( 'Get featured', 'wiseup' ) : wiseup_opt( 'cta_label' );
$wu_sub     = $wu_podcast && wiseup_opt( 'podcast_subscribe' );
$wu_target  = function ( $link ) { return $link['external'] ? ' target="_blank" rel="noopener"' : ''; };
?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'wiseup' ); ?></a>
<header class="hd" data-head>
	<?php if ( $wu_podcast ) : ?>
		<a class="hd__logo hd__logo--podcast" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'WiseUp home', 'wiseup' ); ?>"><img src="<?php echo esc_url( wiseup_logo_url( true ) ); ?>" alt="<?php esc_attr_e( 'WiseUp Podcast', 'wiseup' ); ?>" width="404" height="174" decoding="async"></a>
	<?php else : ?>
		<a class="hd__logo<?php echo 'about' === $wu_slug ? ' hd__logo--dark' : ''; ?>" href="<?php echo $wu_home ? '#top' : esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo $wu_home ? esc_attr__( 'WiseUp, back to top', 'wiseup' ) : esc_attr__( 'WiseUp home', 'wiseup' ); ?>"><img src="<?php echo esc_url( wiseup_logo_url( false ) ); ?>" alt="WiseUp" width="315" height="114" decoding="async"></a>
	<?php endif; ?>

	<nav class="hd__nav" aria-label="<?php esc_attr_e( 'WiseUp sites', 'wiseup' ); ?>">
		<?php foreach ( $wu_links as $l ) : ?>
			<?php if ( 'Services' === $l['label'] ) : // Services mega menu (owner, 2026-11-03) ?>
				<div class="hd__item hd__item--mega"><a class="hd__link hd__link--parent" href="<?php echo esc_url( home_url( '/services/' ) ); ?>" aria-haspopup="true"><span class="hd__dot" aria-hidden="true"></span>Services<svg class="hd__chev" width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2 3.5 3 3 3-3"/></svg></a><div class="hd__mega"><div class="mega"><div class="mega__grid"><a class="mega__tile" href="https://wiseup.in/services/#svc-1" style="--d:0"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17c2-6 3.5-11 5-11 1.5 0 .5 7-1 10s-1 2 1 0 3-5 4-5 0 4 1 4 2-3 3-3 1 2 2 2 2-1 2-1"/></svg></span><span class="mega__txt"><b>Brand Strategy &amp; Identity</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-2" style="--d:1"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3.5 7.5 12 3l8.5 4.5v9L12 21l-8.5-4.5z"/><path d="M3.5 7.5 12 12l8.5-4.5M12 12v9"/></svg></span><span class="mega__txt"><b>Packaging Design &amp; Events</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-3" style="--d:2"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M13.5 5l-3 14"/></svg></span><span class="mega__txt"><b>Web Development</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-4" style="--d:3"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/></svg></span><span class="mega__txt"><b>SEO Services</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-5" style="--d:4"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r=".6"/></svg></span><span class="mega__txt"><b>Performance Marketing</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-6" style="--d:5"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18a14 14 0 0 1 0-18Z"/></svg></span><span class="mega__txt"><b>Digital Marketing</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/social-media-marketing-agency-in-kerala/" style="--d:6"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7a2.5 2.5 0 0 1-2.5 2.5H10l-4.5 4v-4h0A1.5 1.5 0 0 1 4 14.5z"/></svg></span><span class="mega__txt"><b>Social Media Marketing</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-8" style="--d:7"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="6" width="13" height="12" rx="2.5"/><path d="m16 10.5 5-3v9l-5-3"/></svg></span><span class="mega__txt"><b>Video &amp; Photography</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="mega__tile" href="https://wiseup.in/services/#svc-9" style="--d:8"><span class="mega__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 10v4a1 1 0 0 0 1 1h2l7 4V5L7 9H5a1 1 0 0 0-1 1Z"/><path d="M17.5 9.5a3.5 3.5 0 0 1 0 5"/></svg></span><span class="mega__txt"><b>Campaigns &amp; Media Buying</b></span><span class="mega__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16"><path d="M6.5 17.5 16 8M9 7h8.5v8.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a></div><aside class="mega__feat"><span class="mega__kick">Our services</span><p class="mega__h"><span class="mega__360">360°</span> Marketing Services</p><p class="mega__p">See the plan before you see a price.</p><button class="mega__plan" type="button" data-lead-open data-lead-source="header-mega">Get our plan</button></aside></div></div></div>
			<?php elseif ( ! empty( $l['children'] ) ) : ?>
				<div class="hd__item">
					<button class="hd__link hd__link--parent" type="button" aria-haspopup="true"><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?><svg class="hd__chev" width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2 3.5 3 3 3-3"/></svg></button>
					<div class="hd__drop">
						<?php foreach ( $l['children'] as $c ) : ?>
							<a href="<?php echo esc_url( $c['url'] ); ?>"<?php echo $wu_target( $c ); // phpcs:ignore -- static attributes ?>><?php echo esc_html( $c['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php else : ?>
				<a class="hd__link" href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $wu_target( $l ); // phpcs:ignore -- static attributes ?>><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
	</nav>

	<div class="hd__actions">
		<a class="hd__call" href="<?php echo esc_url( home_url( wiseup_opt( 'contact_page' ) ) ); ?>" aria-label="<?php esc_attr_e( 'Contact us', 'wiseup' ); ?>"><?php echo wiseup_icon( 'call' ); // phpcs:ignore -- static SVG ?></a>
		<?php if ( wiseup_opt( 'theme_toggle' ) ) : ?>
			<button class="hd__theme" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Switch to light mode', 'wiseup' ); ?>" aria-pressed="false"><span class="hd__theme-ico"><?php echo wiseup_icon( 'moon' ) . wiseup_icon( 'sun' ); // phpcs:ignore -- static SVG ?></span></button>
		<?php endif; ?>

		<?php if ( $wu_sub ) : ?>
			<a class="hd__sub" href="<?php echo esc_url( wiseup_opt( 'subscribe_url' ) ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Subscribe to WiseUp Podcast on YouTube', 'wiseup' ); ?>">
				<?php echo str_replace( '<svg ', '<svg class="hd__sub-yt" ', wiseup_icon( 'yt-logo' ) ); // phpcs:ignore -- static SVG ?>
				<span class="hd__sub-label"><?php esc_html_e( 'Subscribe', 'wiseup' ); ?></span>
			</a>
		<?php endif; ?>

			<?php if ( ! $wu_podcast ) : ?><a class="hd__cta" href="<?php echo esc_url( $wu_cta ); ?>"><span class="hd__cta-glow" aria-hidden="true"></span><span class="hd__cta-border" aria-hidden="true"></span><span class="hd__cta-shine" aria-hidden="true"></span><span class="hd__cta-inner"><span class="hd__cta-label"><?php echo esc_html( $wu_cta_lbl ); ?></span></span></a><?php endif; ?>

		<button class="hd__menu" type="button" aria-expanded="false" aria-controls="menu" data-menu-btn><svg class="ico hd__burger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M4 8h16"/><path d="M4 16h16"/></svg><span><?php esc_html_e( 'Menu', 'wiseup' ); ?></span></button>
	</div>
	<div class="menu" id="menu" hidden data-menu>
		<?php foreach ( $wu_links as $l ) : ?>
			<?php if ( ! empty( $l['children'] ) ) : ?>
				<details class="menu__group">
					<summary><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?><svg class="hd__chev" width="12" height="12" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2 3.5 3 3 3-3"/></svg></summary>
					<?php foreach ( $l['children'] as $c ) : ?>
						<a class="menu__sub" href="<?php echo esc_url( $c['url'] ); ?>"<?php echo $wu_target( $c ); // phpcs:ignore -- static attributes ?> data-menu-link><?php echo esc_html( $c['label'] ); ?></a>
					<?php endforeach; ?>
				</details>
			<?php else : ?>
				<a href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $wu_target( $l ); // phpcs:ignore -- static attributes ?> data-menu-link><span class="hd__dot" aria-hidden="true"></span><?php echo esc_html( $l['label'] ); ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
		<a class="menu__call" href="<?php echo esc_url( home_url( wiseup_opt( 'contact_page' ) ) ); ?>" data-menu-link><?php echo wiseup_icon( 'call' ); // phpcs:ignore -- static SVG ?><?php esc_html_e( 'Contact Us', 'wiseup' ); ?></a>
		<?php if ( ! $wu_podcast ) : ?><a class="b b--teal b--block" href="<?php echo esc_url( $wu_cta ); ?>" data-menu-link="true"><span class="b__label"><?php echo esc_html( $wu_cta_lbl ); ?></span><span class="b__ico"><?php echo wiseup_icon( 'arrow' ) . wiseup_icon( 'arrow' ); // phpcs:ignore -- static SVG ?></span></a><?php endif; ?>
	</div>
</header>
<script>(function(){var m=document.getElementById('menu');if(!m||!window.MutationObserver)return;var r=document.documentElement,f=function(){r.classList.toggle('wu-menu-open',!m.hidden)};new MutationObserver(f).observe(m,{attributes:true,attributeFilter:['hidden']});})();</script>
<script src="<?php echo esc_url( WISEUP_ASSETS . '/js/mega-rope.js?v=2' ); ?>" defer></script>
