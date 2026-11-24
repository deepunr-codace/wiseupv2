<?php
/**
 * 404 page: a dark stage with a giant outlined 404 that lights up under a lime flashlight following the pointer, Wiso floating in the zero.
 * Only the essentials: a short line, Go back, Back to home. See includes/error-404.php.
 */
defined( 'ABSPATH' ) || exit;
status_header( 404 );
nocache_headers();
wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-404-page' );
$wu_ar = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$wu_bk = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>';
$wu_wiso = esc_url( WISEUP_URL . 'assets/smm/wiso-icon.webp' );
?>
<div class="wiseup-home wiseup-in-theme wu-404">
<main id="main">
	<section class="e404" data-e404>
		<h1 class="screen-reader-text"><?php esc_html_e( 'Page not found', 'wiseup' ); ?></h1>
		<div class="e404__vis" data-e404-vis aria-hidden="true">
			<div class="e404__row e404__row--dim">
				<span class="e404__d">4</span>
				<span class="e404__o"><span class="e404__wm" data-e404-wm><img class="e404__wiso" src="<?php echo $wu_wiso; // phpcs:ignore ?>" width="200" height="200" alt="" decoding="async"></span></span>
				<span class="e404__d">4</span>
			</div>
			<div class="e404__row e404__row--lit">
				<span class="e404__d">4</span>
				<span class="e404__o"></span>
				<span class="e404__d">4</span>
			</div>
		</div>
		<div class="e404__copy">
			<p class="e404__p"><?php esc_html_e( 'This page got lost. Follow the light, or head back.', 'wiseup' ); ?></p>
			<div class="e404__btns">
				<button class="b b--night" type="button" data-e404-back><span class="b__ico"><?php echo $wu_bk; // phpcs:ignore ?></span><span class="b__label"><?php esc_html_e( 'Go back', 'wiseup' ); ?></span></button>
				<a class="b b--teal" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="b__label"><?php esc_html_e( 'Back to home', 'wiseup' ); ?></span><span class="b__ico"><?php echo $wu_ar; // phpcs:ignore ?></span></a>
			</div>
		</div>
	</section>
</main>
</div>
<script>
(function () {
	var s = document.querySelector('[data-e404]'); if (!s) return;
	var v = s.querySelector('[data-e404-vis]'), wm = s.querySelector('[data-e404-wm]');
	var back = s.querySelector('[data-e404-back]');
	back.addEventListener('click', function () {
		if (history.length > 1 && document.referrer) history.back(); else location.href = '<?php echo esc_js( home_url( '/' ) ); ?>';
	});
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var used = false, tx = 0, ty = 0, cx = 0, cy = 0, ready = false;
	function set(x, y) {
		var r = v.getBoundingClientRect();
		var px = x - r.left, py = y - r.top;
		cx = px; cy = py; ready = true;
		v.style.setProperty('--mx', px + 'px');
		v.style.setProperty('--my', py + 'px');
		var nx = Math.max(-1, Math.min(1, (x - (r.left + r.width / 2)) / (window.innerWidth / 2)));
		var ny = Math.max(-1, Math.min(1, (y - (r.top + r.height / 2)) / (window.innerHeight / 2)));
		if (wm) wm.style.transform = 'translate(' + (nx * 10).toFixed(1) + 'px,' + (ny * 8).toFixed(1) + 'px)';
	}
	window.addEventListener('pointermove', function (e) { used = true; set(e.clientX, e.clientY); }, { passive: true });
	var r0 = v.getBoundingClientRect();
	set(r0.left + r0.width * .5, r0.top + r0.height * .5);
	if (reduce) return;
	var t0 = performance.now(), on = true;
	if ('IntersectionObserver' in window) new IntersectionObserver(function (e) { on = e[0].isIntersecting; }).observe(v);
	function tick(t) {
		if (on && !used) {
			var r = v.getBoundingClientRect(), k = (t - t0) / 1000;
			set(r.left + r.width * (.5 + .38 * Math.sin(k * .8)), r.top + r.height * (.5 + .3 * Math.sin(k * 1.3 + 1)));
		}
		requestAnimationFrame(tick);
	}
	requestAnimationFrame(tick);
})();
</script>
<?php wiseup_landing_close( '404' ); ?>
