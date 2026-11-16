<?php
/**
 * Portfolio page ("WiseUp: Portfolio" in the page Template dropdown; owner, 2026-11-12: "use our plugins header and
 * footer", then "move the template to our plugin"). Moved from the theme's "Studio Portfolio" template
 * (themes/kadence/template-studio-portfolio.php, the WebGL work carousel at /studio/portfolio/): the same carousel
 * markup and portfolio posts, its CSS/JS copied from the theme's portfolio-assets2/ into assets/portfolio/ (only the
 * files this page loads, plus img/ground2.jpg, which anita-gl-carousel.js finds next to its own js/ folder), with the
 * WiseUp header and footer in place of the template's own logo bar and full-screen menu. Pages still on the theme
 * template are served from here too (includes/landing.php). The carousel fills the first screen; the wheel steps
 * through the work as before and, once the last piece is showing, scrolls on to the footer.
 */
defined( 'ABSPATH' ) || exit;

wiseup_portfolio_head(); // fonts, the portfolio stylesheets (layered) and the header/footer fixes (includes/portfolio.php)

add_action( 'wp_head', function () {
	?>
<style id="wu-portfolio">
#wu-work { --ink: #1f1f1f; --bg: #0c0c0f; --white: #fff; --mute: rgba(255, 255, 255, .55); --radius: clamp(20px, 2.4vw, 40px); --ease: cubic-bezier(.22, 1, .36, 1); position: relative; width: 100%; background: var(--bg); color: var(--white); }
/* The carousel is the hero: its 3D scene fills the first screen and the transparent WiseUp header sits on it (no band,
   no header background). The work itself is composed below the header: --pf-top (the header's bottom edge + 32px,
   measured by the script below) is passed to the carousel as its inset, and the captions, arrows and drag area sit
   in the part of the screen below it, so the header never covers a piece. The footer follows the hero. */
#wu-work { --pf-top: 120px; }
.anita-main { position: relative; width: 100%; height: 100vh; height: 100dvh; min-height: 520px !important; /* core.js sets an inline min-height of the whole window */ background: #000; overflow: hidden; }
.anita-gl-carousel-canvas { position: absolute !important; left: 0 !important; top: 0 !important; width: 100% !important; height: 100% !important; z-index: 0 !important; opacity: 1 !important; pointer-events: none; }
.anita-gl-carousel-gallery-wrap { position: absolute !important; left: 0 !important; top: var(--gl-frame-top, var(--pf-top)) !important; width: 100% !important; height: var(--gl-frame-h, calc(100% - var(--pf-top))) !important; z-index: 4 !important; }
.anita-gl-container-wrap::after, .anita-preloader-wrap { display: none !important; }
.anita-gl-container-wrap, .anita-gl-container { opacity: 1 !important; visibility: visible !important; }
/* "View work": a clear button under the active piece's title (was a faint "Explore" word) */
.anita-gl-gallery-item__content { text-align: center; }
/* captions sit right under the card: 12px below its bottom edge (--gl-card-bottom from the carousel, which also
   moves the caption strip with the card as the camera leans and follows the mouse), not a fixed 120px above the bottom; titles medium (owner, 2026-11-13: "text medium") */
.anita-gl-gallery-item { align-items: flex-start !important; padding-bottom: 0 !important; padding-top: calc(var(--gl-card-bottom, 70%) + 12px); font-size: clamp(24px, 1rem + 1.1vw, 34px); }
.anita-gl-gallery__caption { font-size: clamp(24px, 1rem + 1.1vw, 34px); line-height: 1.05; }
.anita-gl-gallery__caption sup { font-size: .42em; }
.anita-gl-gallery__meta:empty { display: none; }
.anita-gl-gallery__explore { float: none !important; display: inline-flex; align-items: center; gap: 8px; margin-top: 14px; padding: 10px 18px 10px 20px; border-radius: 999px; background: #beda52; color: #11150a !important; font: 600 14px/1 Inter, system-ui, sans-serif; letter-spacing: 0; text-shadow: none; opacity: 0; transition: opacity .5s, background .25s; }
.anita-gl-gallery__explore svg { width: 16px; height: 16px; transition: transform .25s; }
.is-active .anita-gl-gallery__explore { opacity: 1; }
.anita-gl-gallery-item__content:hover .anita-gl-gallery__explore { background: #d2e874; }
.anita-gl-gallery-item__content:hover .anita-gl-gallery__explore svg { transform: translateX(3px); }
/* phones: smaller arrows at the screen edges, titles that fit the width */
@media (max-width: 640px) {
	.anita-gallery-nav { width: 44px; height: 44px; margin-top: -22px; transform: none; } /* the theme also scaled them to .7 on phones: under a comfortable tap size */
	.anita-gallery-nav::before { font-size: 20px; }
	.anita-gallery-nav__prev { left: 10px; }
	.anita-gallery-nav__next { right: 10px; }
	.anita-gl-gallery-item { font-size: clamp(22px, 6.4vw, 28px); }
	.anita-gl-gallery__caption { font-size: clamp(22px, 6.4vw, 28px); white-space: normal; text-wrap: balance; padding: 0 20px; box-sizing: border-box; }
	.anita-gl-gallery__explore { margin-top: 12px; padding: 10px 18px; }
}
</style>
	<?php
}, 7 );

wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-portfolio-page' );
?>
<div id="wu-work">
	<main class="anita-main" aria-label="<?php esc_attr_e( 'Portfolio', 'wiseup' ); ?>">
		<h1 class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap"><?php echo esc_html( get_the_title() ?: __( 'Portfolio', 'wiseup' ) ); ?></h1>
		<div class="anita-gl-container-wrap anita-albums-listing anita-gl-carousel-gallery-wrap anita-scrollEW">
			<div class="anita-gl-container anita-gl-carousel-gallery" data-prev-label="Previous Work" data-next-label="Next Work">
<?php
$portfolio_query = new WP_Query( array(
	'post_type'      => 'portfolio',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
) );
if ( $portfolio_query->have_posts() ) :
	$i = 0;
	while ( $portfolio_query->have_posts() ) :
		$portfolio_query->the_post();
		$i++;
		$number     = str_pad( $i, 2, '0', STR_PAD_LEFT );
		$thumb_id   = get_post_thumbnail_id();
		$image_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';
		$image_meta = $thumb_id ? wp_get_attachment_metadata( $thumb_id ) : false;
		$natural    = ( ! empty( $image_meta['width'] ) && ! empty( $image_meta['height'] ) ) ? $image_meta['width'] . 'x' . $image_meta['height'] : '512x512';
		$video_url  = '';
		if ( function_exists( 'get_field' ) ) {
			$featured_video = get_field( 'featured_video' );
			if ( is_array( $featured_video ) && ! empty( $featured_video['url'] ) ) {
				$video_url = $featured_video['url'];
				if ( ! empty( $featured_video['width'] ) && ! empty( $featured_video['height'] ) ) $natural = $featured_video['width'] . 'x' . $featured_video['height'];
			} elseif ( is_string( $featured_video ) && '' !== $featured_video ) {
				$video_url = $featured_video;
			}
		}
		$is_video   = '' !== $video_url;
		$poster_url = $image_url;
		if ( $is_video ) {
			$video_thumb = wu_video_thumbnail_url( $video_url );
			if ( $video_thumb ) $poster_url = $video_thumb;
		}
		$subtitle = '';
		$terms    = get_the_terms( get_the_ID(), 'portfolio-category' );
		if ( $terms && ! is_wp_error( $terms ) ) $subtitle = $terms[0]->name;
		?>
				<div class="anita-gl-gallery-item <?php echo $is_video ? 'is-video' : 'is-image'; ?>" data-src="<?php echo esc_url( $is_video ? wiseup_portfolio_video( $video_url, 'loop' ) : $image_url ); ?>" data-size="<?php echo esc_attr( $natural ); ?>" data-natural="<?php echo esc_attr( $natural ); ?>"<?php if ( $is_video ) : ?> data-poster="<?php echo esc_url( $poster_url ); ?>"<?php endif; ?>>
					<div class="anita-gl-gallery-item__content" data-aos="fade-up">
						<span class="anita-meta anita-gl-gallery__meta"><?php echo esc_html( $subtitle ); ?></span>
						<h2 class="anita-gl-gallery__caption"><sup><?php echo esc_html( $number ); ?>.</sup> <?php the_title(); ?></h2>
						<span class="anita-gl-gallery__explore" aria-hidden="true">View work <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
						<a href="<?php the_permalink(); ?>" class="anita-album-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
					</div>
				</div>
		<?php
	endwhile;
	wp_reset_postdata();
endif;
?>
			</div>
		</div>
	</main>
</div>

<?php wiseup_portfolio_scripts( array( 'lib/jquery.min.js', 'lib/aos.min.js', 'lib/three.min.js', 'lib/shaders/reflector.js', 'anita-gl-carousel.js', 'core.js' ) ); ?>
<script>
jQuery(function ($) {
	$('body').removeClass('is-loading').addClass('is-loaded');
	$('.anita-gl-container-wrap, .anita-gl-container').addClass('is-loaded');
	if (typeof Anita_GL_Carousel !== 'function' || !$('.anita-gl-carousel-gallery').length) return;
	var work = document.getElementById('wu-work'), main = document.querySelector('.anita-main');
	// The work is composed below the WiseUp header: --pf-top = the header's bottom edge plus 32px of air, measured at the
	// top of the page (the header can be hidden or docked once scrolled). This resize handler runs before the carousel's.
	var pfTop = 120;
	var fitTop = function () {
		var hd = document.querySelector('.wu-chrome .hd');
		if (hd && window.scrollY < 40 && !hd.classList.contains('is-hidden')) pfTop = Math.round(hd.getBoundingClientRect().bottom + 32);
		work.style.setProperty('--pf-top', pfTop + 'px');
	};
	fitTop();
	window.addEventListener('resize', fitTop);
	// inset: keep the cards below the header; overhang: the cards reach up to .08 of the frame above it (mouse parallax
	// included), measured; camera_angle 0: no camera yaw, so the cards face the viewer with level edges (owner: "make
	// cards horizontal"; the theme's .1 tilted them per slide).
	// insetBottom: a little air between the work and the bottom of the screen
	var c = new Anita_GL_Carousel($('.anita-gl-carousel-gallery'), { container: $('.anita-main'), nav: true, inset: function () { return pfTop; }, insetBottom: 24, overhang: .1, camera_angle: 0, portrait_fit: .86, portrait_distance: 6, caption_space: 100 }); // phones: each card fits 86% of the width, front card centred, camera closer (bigger cards)
	window.wuPortfolioCarousel = c; // handy in the browser console
	// Clickable cards: a click (not a drag) on a side card brings it to the front; on the front card it opens the piece.
	var wrap = document.querySelector('.anita-gl-carousel-gallery-wrap'), ray = new THREE.Raycaster(), ndc = new THREE.Vector2();
	var cardAt = function (x, y) {
		var r = main.getBoundingClientRect();
		ndc.set((x - r.left) / r.width * 2 - 1, -((y - r.top) / r.height) * 2 + 1);
		ray.setFromCamera(ndc, c.camera);
		var hit = ray.intersectObjects(c.gallery.children, false)[0];
		return hit ? c.gallery.children.indexOf(hit.object) : -1;
	};
	var skip = function (t) { return t.closest('a, button'); };
	var press = null;
	main.addEventListener('pointerdown', function (e) { press = e.button === 0 && !skip(e.target) ? [e.clientX, e.clientY] : null; });
	main.addEventListener('pointerup', function (e) {
		if (!press) return;
		var moved = Math.abs(e.clientX - press[0]) + Math.abs(e.clientY - press[1]);
		press = null;
		if (moved > 6) return;
		var i = cardAt(e.clientX, e.clientY);
		if (i < 0) return;
		if (i === c.active) { var link = document.querySelectorAll('.anita-gl-gallery-item .anita-album-link')[i]; if (link) window.location.href = link.href; }
		else { c.active = i; c.changeSlide(); }
	});
	// pointer cursor over the cards (mouse only, once per frame)
	var hover = 0, hx = 0, hy = 0;
	main.addEventListener('pointermove', function (e) {
		if (e.pointerType !== 'mouse') return;
		hx = e.clientX; hy = e.clientY;
		if (hover) return;
		hover = requestAnimationFrame(function () {
			hover = 0;
			var t = document.elementFromPoint(hx, hy);
			wrap.style.cursor = t && !skip(t) && cardAt(hx, hy) >= 0 ? 'pointer' : '';
		});
	});
	// The wheel steps through the work over the carousel (the page doesn't move); once the last piece is showing,
	// or once the page has scrolled away from the top, it scrolls the page to the footer and back. Listening on the
	// carousel only (not the window) leaves every other scroll on the page to the browser, without waiting for script.
	// One piece per scroll gesture (owner, 2026-11-13: "reduce scroll speed. make it smooth"): the theme moved a slide on
	// every wheel event 50ms apart, so one trackpad flick or a quick spin raced through several pieces. Now a gesture
	// (wheel events less than GAP ms apart, a trackpad's coasting included) must add up to STEP px to move one piece;
	// the rest of that gesture is ignored, and the next move waits until the slide has had SETTLE ms to glide over.
	// Leaving for the footer from the last piece also takes a fresh gesture.
	var GAP = 180, STEP = 50, SETTLE = 700, acc = 0, lastEv = 0, lastGo = 0, used = false, toPage = false;
	main.addEventListener('wheel', function (e) {
		var now = performance.now(), gap = now - lastEv, unit = e.deltaMode === 1 ? 33 : e.deltaMode === 2 ? window.innerHeight : 1,
			delta = (Math.abs(e.deltaY) >= Math.abs(e.deltaX) ? e.deltaY : e.deltaX) * unit;
		lastEv = now;
		if (gap > GAP) { acc = 0; used = false; toPage = false; }
		var fresh = !used && now - lastGo > SETTLE;
		if (toPage || window.scrollY > 2 || (delta > 0 && c.active >= c.max && fresh)) { toPage = used = true; e.stopPropagation(); return; } // the page scrolls, for the rest of this gesture too (and it won't also change slides when it reaches the top)
		e.preventDefault();
		e.stopPropagation(); // the carousel's own wheel handler (a slide per event) stays out of it
		if (!fresh) return;
		acc += delta;
		if (Math.abs(acc) < STEP) return;
		acc > 0 ? c.nextSlide() : c.prevSlide();
		acc = 0; used = true; lastGo = now;
	}, { capture: true, passive: false });
	// No 3D rendering or video playback while the carousel is off screen (scrolled to the footer, or tab hidden).
	if ('IntersectionObserver' in window && c.setPaused) {
		new IntersectionObserver(function (es) { c.setPaused(!es[0].isIntersecting); }, { rootMargin: '40px' }).observe(main);
	}
});
</script>
<?php
$wu_lead_source = 'portfolio';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'portfolio' );
