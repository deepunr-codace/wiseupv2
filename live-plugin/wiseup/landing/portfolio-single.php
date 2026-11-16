<?php
/**
 * A portfolio item (`portfolio` post type), moved from themes/kadence/single-portfolio.php (owner, 2026-11-12: "yeah
 * move"): the same "Back to Work" head, grid of stills and videos from the ACF `portfolio_gallery` field and the
 * lightbox, with the WiseUp header and footer in place of the template's own logo bar and full-screen menu. Routed by
 * includes/portfolio.php; shared head output and assets there too.
 */
defined( 'ABSPATH' ) || exit;

// As in the theme template: LiteSpeed's server page cache never keeps this page.
if ( ! headers_sent() ) header( 'X-LiteSpeed-Cache-Control: no-cache' );

the_post();
$wu_terms    = get_the_terms( get_the_ID(), 'portfolio-category' );
$wu_subtitle = ( $wu_terms && ! is_wp_error( $wu_terms ) ) ? $wu_terms[0]->name : '';
$wu_back     = wiseup_portfolio_url();
$wu_gallery  = function_exists( 'get_field' ) ? get_field( 'portfolio_gallery' ) : null;
$wu_gallery  = is_array( $wu_gallery ) ? array_values( $wu_gallery ) : array();

wiseup_portfolio_head();
add_action( 'wp_head', function () {
	?>
<style id="wu-portfolio-single">
#wu-work { --ink: #1f1f1f; --bg: #0c0c0f; --bg-2: #131318; --white: #fff; --line: rgba(255, 255, 255, .13); --mute: rgba(255, 255, 255, .55); --gutter: clamp(20px, 8vw, 139px); --radius: clamp(14px, 1.6vw, 26px); --ease: cubic-bezier(.22, 1, .36, 1); position: relative; background: var(--bg); color: var(--white); }
.wu-portfolio-main { position: relative; min-height: 100vh; padding: clamp(130px, 13vw, 180px) var(--gutter) clamp(60px, 6vw, 100px); }
.wu-album-title { margin-bottom: clamp(36px, 4vw, 64px); }
.wu-album-title .anita-albums-back-wrap { margin-bottom: 18px; }
/* "Back to Work" as a real button (was 17px-high text): easy to tap on a phone */
.wu-album-title .anita-albums-back { display: inline-flex; align-items: center; gap: 8px; min-height: 44px; padding: 0 18px 0 14px; border-radius: 999px; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .2); color: #fff; font: 500 14px/1 Inter, system-ui, sans-serif; opacity: 1; transform: none; transition: background .2s, box-shadow .2s; }
.wu-album-title .anita-albums-back svg { width: 16px; height: 16px; transition: transform .2s; }
.wu-album-title .anita-albums-back:hover { background: rgba(255, 255, 255, .08); box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .35); }
.wu-album-title .anita-albums-back:hover svg { transform: translateX(-3px); }
@media (max-width: 640px) { .wu-portfolio-main { padding-top: 112px; } .wu-album-title h1 { font-size: clamp(30px, 9vw, 40px); } }
.wu-album-title h1 { margin: 0 0 10px 0; }
.wu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(14px, 1.6vw, 28px); }
.wu-grid-item { position: relative; display: block; aspect-ratio: 4 / 3; border-radius: var(--radius); overflow: hidden; background: var(--bg-2); box-shadow: inset 0 0 0 1px var(--line); text-decoration: none; }
.wu-grid-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s var(--ease); }
.wu-grid-item:hover img { transform: scale(1.06); }
.wu-grid-item.is-video { display: flex; align-items: center; justify-content: center; background: linear-gradient(160deg, #17171c, #0c0c0f); }
.wu-grid-item__thumb { position: absolute; inset: 0; z-index: 0; width: 100%; height: 100%; object-fit: cover; }
.wu-grid-item.is-video::before { content: ''; position: absolute; inset: 0; z-index: 1; background: radial-gradient(circle at center, rgba(0, 0, 0, .35), rgba(0, 0, 0, 0) 62%); opacity: 0; transition: opacity .35s var(--ease); }
.wu-grid-item.is-video:hover::before { opacity: 1; }
.wu-grid-item__play { position: relative; z-index: 2; width: clamp(46px, 4vw, 60px); height: clamp(46px, 4vw, 60px); border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(10, 10, 12, .55); box-shadow: 0 0 0 1.5px rgba(255, 255, 255, .55), 0 8px 20px -6px rgba(0, 0, 0, .6); transition: transform .3s var(--ease), background .3s var(--ease), box-shadow .3s var(--ease); }
.wu-grid-item.is-video:hover .wu-grid-item__play { transform: scale(1.1); background: rgba(10, 10, 12, .75); box-shadow: 0 0 0 1.5px #fff, 0 10px 24px -6px rgba(0, 0, 0, .65); }
.wu-grid-item__play svg { width: 20px; height: 20px; margin-left: 3px; fill: #fff; }
@media (max-width: 900px) { .wu-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) { .wu-grid { grid-template-columns: 1fr; } }
/* the WiseUp header and the chat button step aside while a lightbox is open (#wu-work is its own stacking layer, so the
   lightbox can't be lifted above the header) */
.wu-lb-open .wu-chrome .hd, .wu-lb-open .lead-fab { opacity: 0 !important; visibility: hidden !important; transition: opacity .3s, visibility .3s; }
#wu-work .lightbox { position: fixed; inset: 0; z-index: 2147483100; display: flex; align-items: center; justify-content: center; padding: clamp(16px, 4vw, 60px); background: rgba(6, 6, 9, .92); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); opacity: 0; visibility: hidden; pointer-events: none; transition: opacity .4s var(--ease), visibility .4s var(--ease); }
#wu-work .lightbox.is-open { opacity: 1; visibility: visible; pointer-events: auto; }
#wu-work .lightbox .backdrop { position: absolute; inset: 0; cursor: zoom-out; }
#wu-work .lightbox .stage { position: relative; z-index: 2; width: min(1180px, 100%); max-height: 100%; display: flex; flex-direction: column; gap: 18px; transform: scale(.96) translateY(10px); transition: transform .5s var(--ease); }
#wu-work .lightbox.is-open .stage { transform: scale(1) translateY(0); }
#wu-work .lightbox .frame { position: relative; border-radius: var(--radius); overflow: hidden; background: #000; box-shadow: 0 50px 120px -30px rgba(0, 0, 0, .9), 0 0 0 1px rgba(255, 255, 255, .08); }
#wu-work .lightbox video, #wu-work .lightbox .frame img { width: 100%; height: auto; max-height: 76vh; object-fit: contain; display: block; background: #000; }
#wu-work .lightbox .x { position: absolute; top: -6px; right: 0; transform: translateY(-100%); display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; color: #fff; text-decoration: none; background: rgba(255, 255, 255, .1); backdrop-filter: blur(10px) saturate(160%); -webkit-backdrop-filter: blur(10px) saturate(160%); box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .5), 0 8px 24px -8px rgba(0, 0, 0, .55); transition: background .3s var(--ease), box-shadow .3s var(--ease), transform .3s var(--ease); }
#wu-work .lightbox .x:hover { background: #fff; color: var(--ink); box-shadow: inset 0 0 0 1px #fff, 0 8px 24px -8px rgba(0, 0, 0, .55); transform: translateY(-100%) scale(1.08); }
#wu-work .lightbox .x svg { width: 16px; height: 16px; fill: currentColor; }
@media (max-width: 860px) {
	#wu-work .lightbox .x { position: static; transform: none; align-self: flex-end; }
	#wu-work .lightbox .x:hover { transform: scale(1.08); }
}
</style>
	<?php
}, 7 );

wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-portfolio-page wu-portfolio-single' );
?>
<div id="wu-work">
	<main class="wu-portfolio-main" id="main">
		<div class="wu-album-title">
			<div class="anita-albums-back-wrap" data-aos="fade-up">
				<a href="<?php echo esc_url( $wu_back ); ?>" class="anita-albums-back"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>Back to Work</a>
			</div>
			<h1 class="anita-page-title" data-aos="fade-up" data-aos-delay="50"><?php the_title(); ?></h1>
			<div class="anita-post-meta anita-meta" data-aos="fade-up" data-aos-delay="100" data-aos-offset="20">
				<?php if ( $wu_subtitle ) : ?><span><?php echo esc_html( $wu_subtitle ); ?></span><?php endif; ?>
				<span>Selected Stills</span>
			</div>
		</div>

		<div class="wu-grid">
<?php
foreach ( $wu_gallery as $i => $item ) :
	$is_video = ! empty( $item['mime_type'] ) && 0 === strpos( $item['mime_type'], 'video' );
	$lb_id    = 'wu-lb-' . ( $i + 1 );
	$thumb    = ( ! $is_video && ! empty( $item['sizes']['medium_large'] ) ) ? $item['sizes']['medium_large'] : $item['url'];
	?>
			<a href="#<?php echo esc_attr( $lb_id ); ?>" class="wu-grid-item <?php echo $is_video ? 'is-video' : ''; ?>" data-lightbox="<?php echo esc_attr( $lb_id ); ?>" data-aos="fade-up" aria-label="<?php echo esc_attr( sprintf( $is_video ? __( 'Play video %1$d of %2$s', 'wiseup' ) : __( 'Open image %1$d of %2$s', 'wiseup' ), $i + 1, get_the_title() ) ); ?>">
	<?php if ( $is_video ) : ?>
		<?php $poster = wu_video_thumbnail_url( $item['url'] ); ?>
		<?php if ( $poster ) : ?>
				<img class="wu-grid-item__thumb" src="<?php echo esc_url( $poster ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
		<?php endif; ?>
				<span class="wu-grid-item__play"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.5 6.87a1.2 1.2 0 0 1 1.82-1.03l7.36 4.51a1.2 1.2 0 0 1 0 2.05l-7.36 4.51a1.2 1.2 0 0 1-1.82-1.03Z"/></svg></span>
	<?php else : ?>
				<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
	<?php endif; ?>
			</a>
<?php endforeach; ?>
		</div>

<?php
foreach ( $wu_gallery as $i => $item ) :
	$is_video = ! empty( $item['mime_type'] ) && 0 === strpos( $item['mime_type'], 'video' );
	?>
		<div id="wu-lb-<?php echo (int) ( $i + 1 ); ?>" class="lightbox" role="dialog" aria-modal="true" aria-label="<?php the_title_attribute(); ?>">
			<a href="#" class="backdrop js-lightbox-close" aria-label="<?php esc_attr_e( 'Close', 'wiseup' ); ?>"></a>
			<div class="stage">
				<a href="#" class="x js-lightbox-close" aria-label="<?php esc_attr_e( 'Close', 'wiseup' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.3 5.71 12 12.01l6.3 6.3-1.42 1.42-6.29-6.3-6.3 6.3-1.41-1.42 6.3-6.3-6.3-6.3L4.29 4.3l6.3 6.3 6.29-6.3z"/></svg></a>
				<div class="frame">
	<?php if ( $is_video ) : ?>
		<?php $poster = wu_video_thumbnail_url( $item['url'] ); // cached by the grid above ?>
					<video controls playsinline webkit-playsinline="true" preload="none"<?php if ( $poster ) : ?> poster="<?php echo esc_url( $poster ); ?>"<?php endif; ?> src="<?php echo esc_url( wiseup_portfolio_video( $item['url'], 'play' ) ); ?>"></video>
	<?php else : ?>
					<img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
	<?php endif; ?>
				</div>
			</div>
		</div>
<?php endforeach; ?>
	</main>
</div>

<?php wiseup_portfolio_scripts( array( 'lib/jquery.min.js', 'lib/aos.min.js', 'core.js' ) ); ?>
<script>
jQuery(function ($) {
	$('body').removeClass('is-loading').addClass('is-loaded');
	// Lightbox driven by a class, not :target (mobile browsers didn't repaint the hash match reliably and the video's
	// sound started before the box showed); playback waits two frames so picture and sound start together.
	function closeLightbox(lb) {
		if (!lb) return;
		lb.classList.remove('is-open');
		document.body.classList.toggle('wu-lb-open', !!document.querySelector('#wu-work .lightbox.is-open'));
		var v = lb.querySelector('video');
		if (v) v.pause();
	}
	function openLightbox(lb) {
		if (!lb) return;
		document.querySelectorAll('#wu-work .lightbox.is-open').forEach(closeLightbox);
		lb.classList.add('is-open');
		document.body.classList.add('wu-lb-open');
		var v = lb.querySelector('video');
		if (v) requestAnimationFrame(function () { requestAnimationFrame(function () { v.currentTime = 0; v.play().catch(function () {}); }); });
	}
	document.querySelectorAll('.wu-grid-item[data-lightbox]').forEach(function (link) {
		link.addEventListener('click', function (e) { e.preventDefault(); openLightbox(document.getElementById(link.getAttribute('data-lightbox'))); });
	});
	document.querySelectorAll('.js-lightbox-close').forEach(function (btn) {
		btn.addEventListener('click', function (e) { e.preventDefault(); closeLightbox(btn.closest('.lightbox')); });
	});
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') document.querySelectorAll('#wu-work .lightbox.is-open').forEach(closeLightbox);
	});
});
</script>
<?php
$wu_lead_source = 'portfolio';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'portfolio' );
