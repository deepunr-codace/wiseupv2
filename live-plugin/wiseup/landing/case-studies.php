<?php
/**
 * Case studies listing (/case-studies/), in the homepage design: the work section's heading, eyebrow pill, square
 * photo tiles with the results overlay on hover, the homepage buttons, category filter chips, and a closing call to
 * action that opens the lead popup. Content comes from the `case-studies` posts (title, featured image, categories,
 * and the Client / Location / Overview lines of each post's own content). See includes/case-studies.php.
 */
defined( 'ABSPATH' ) || exit;

wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-cs-page' );

$wu_arrow = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg>';
$wu_stats = wiseup_cs_stats();
$wu_terms = get_terms( array( 'taxonomy' => 'case-study-category', 'hide_empty' => true ) );
$wu_terms = is_wp_error( $wu_terms ) ? array() : $wu_terms;
?>
<div class="wiseup-home wiseup-in-theme wu-cs">
<main id="main">
	<section class="cs-hero" aria-labelledby="cs-title">
		<div class="wrap">
			<div class="sh">
				<p class="eyebrow"><span class="eyebrow__dot" aria-hidden="true"></span><?php esc_html_e( 'Case studies', 'wiseup' ); ?></p>
				<h1 id="cs-title" class="sh__h">
					<span class="sh__a"><?php esc_html_e( 'Proof, not bluff.', 'wiseup' ); ?></span>
					<span class="sh__b"><?php esc_html_e( 'Restaurants, cafés, expos and space tech, from Kozhikode to the global.', 'wiseup' ); ?></span>
				</h1>
			</div>
			<?php if ( count( $wu_terms ) > 1 ) : ?>
			<div class="cs-filter" role="group" aria-label="<?php esc_attr_e( 'Filter case studies', 'wiseup' ); ?>">
				<button type="button" class="cs-chip is-on" data-cs-filter="" aria-pressed="true"><?php esc_html_e( 'All', 'wiseup' ); ?></button>
				<?php foreach ( $wu_terms as $t ) : ?>
					<button type="button" class="cs-chip" data-cs-filter="<?php echo esc_attr( $t->slug ); ?>" aria-pressed="false"><?php echo esc_html( $t->name ); ?></button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="cs-list" aria-label="<?php esc_attr_e( 'All case studies', 'wiseup' ); ?>">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
			<ul class="cs-grid">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					$slug  = get_post_field( 'post_name' );
					$meta  = wiseup_cs_meta( get_the_ID() );
					$cats  = get_the_terms( get_the_ID(), 'case-study-category' );
					$cats  = ( $cats && ! is_wp_error( $cats ) ) ? $cats : array();
					$label = $cats ? $cats[0]->name : '';
					$sub   = implode( ' · ', array_filter( array( $meta['client'] && 0 !== strcasecmp( $meta['client'], get_the_title() ) ? $meta['client'] : '', $meta['location'] ) ) );
					?>
					<li class="cs-card" data-cats="<?php echo esc_attr( implode( ' ', wp_list_pluck( $cats, 'slug' ) ) ); ?>" style="--d:<?php echo (int) ( $i++ * 80 ); ?>ms">
						<a class="cs-card__link" href="<?php the_permalink(); ?>">
							<span class="cs-card__media">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'large', array(
										'class'   => 'cs-card__img',
										'sizes'   => '(max-width: 767px) 92vw, (max-width: 1099px) 46vw, 410px',
										'alt'     => sprintf( /* translators: %s: case study title */ __( '%s case study by WiseUp', 'wiseup' ), get_the_title() ),
										'loading' => $i <= 3 ? 'eager' : 'lazy',
									) );
								}
								if ( isset( $wu_stats[ $slug ] ) ) :
									$s = $wu_stats[ $slug ];
									?>
									<span class="rows__stats" aria-hidden="true"><span class="rows__big"><b><?php echo esc_html( $s[0] ); ?></b><span><?php echo esc_html( $s[1] ); ?></span></span><span class="rows__mini"><?php foreach ( $s[2] as $m ) : ?><span><b><?php echo esc_html( $m[0] ); ?></b><?php echo esc_html( $m[1] ); ?></span><?php endforeach; ?></span></span>
								<?php endif; ?>
							</span>
							<span class="cs-card__body">
								<?php if ( $label ) : ?><span class="cs-card__cat"><?php echo esc_html( $label ); ?></span><?php endif; ?>
								<h2 class="cs-card__title"><?php the_title(); ?></h2>
								<?php if ( $sub ) : ?><span class="cs-card__sub"><?php echo esc_html( $sub ); ?></span><?php endif; ?>
								<?php if ( $meta['summary'] ) : ?><span class="cs-card__sum"><?php echo esc_html( $meta['summary'] ); ?></span><?php endif; ?>
								<span class="cs-card__go"><?php esc_html_e( 'View case study', 'wiseup' ); ?> <?php echo $wu_arrow; // phpcs:ignore -- static SVG ?></span>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
			<p class="cs-empty" hidden><?php esc_html_e( 'No case studies in this category yet.', 'wiseup' ); ?></p>
			<?php else : ?>
			<p class="cs-empty"><?php esc_html_e( 'Case studies are on their way.', 'wiseup' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="cs-cta" aria-labelledby="cs-cta-title">
		<div class="wrap">
			<div class="cs-cta__box">
				<h2 id="cs-cta-title" class="sh__h"><span class="sh__a"><?php esc_html_e( 'See the plan', 'wiseup' ); ?></span> <span class="sh__b"><?php esc_html_e( 'before you see a price.', 'wiseup' ); ?></span></h2>
				<div class="cs-cta__btns">
					<a class="b b--teal" href="#" data-lead-open data-lead-source="case-studies"><span class="b__label"><?php esc_html_e( 'Get our plan', 'wiseup' ); ?></span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></a>
					<a class="b b--night" href="https://wiseup.in/studio/portfolio/"><span class="b__label"><?php esc_html_e( 'Full portfolio', 'wiseup' ); ?></span><span class="b__ico"><?php echo $wu_arrow . $wu_arrow; // phpcs:ignore ?></span></a>
				</div>
			</div>
		</div>
	</section>
</main>
</div>
<script>
/* category chips + staggered entrance (no site script on this page) */
(function () {
	var grid = document.querySelector('.cs-grid'); if (!grid) return;
	var cards = Array.prototype.slice.call(grid.children), empty = document.querySelector('.cs-empty');
	document.querySelectorAll('[data-cs-filter]').forEach(function (b) {
		b.addEventListener('click', function () {
			var f = b.getAttribute('data-cs-filter'), n = 0;
			document.querySelectorAll('[data-cs-filter]').forEach(function (x) { var on = x === b; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', String(on)); });
			cards.forEach(function (c) { var show = !f || (' ' + c.getAttribute('data-cats') + ' ').indexOf(' ' + f + ' ') > -1; c.hidden = !show; if (show) n++; });
			if (empty) empty.hidden = n > 0;
		});
	});
	if (matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
	grid.classList.add('cs-anim');
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } }); }, { threshold: 0.12 });
	cards.forEach(function (c) { io.observe(c); });
})();
</script>
<?php
$wu_lead_source = 'case-studies';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'case-studies' );
