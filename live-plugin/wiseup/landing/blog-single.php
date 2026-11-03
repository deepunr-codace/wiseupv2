<?php
/** Blog detail page, one per post. Uses the WiseUp header and footer (includes/landing.php) and assets/css/blog.css. */
defined( 'ABSPATH' ) || exit;

wiseup_landing_open( 'wu-blog-page' );

the_post();
$topic   = wiseup_post_topic();
$cta_url = wiseup_opt( 'cta_url' ) ? wiseup_opt( 'cta_url' ) : home_url( '/#contact' );
$url     = get_permalink();
$title   = get_the_title();
$prev    = get_previous_post();
$next    = get_next_post();
$tags    = get_the_tags();

$related = new WP_Query( array(
	'post_type'           => 'post',
	'post__not_in'        => array( get_the_ID() ),
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'category__in'        => wp_get_post_categories( get_the_ID() ),
) );
?>
<main id="main" class="wu-blog">
	<article class="bs">
		<header class="bs-head">
			<div class="bl-wrap bl-wrap--narrow">
				<nav class="bs-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'wiseup' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'wiseup' ); ?></a><span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blogs', 'wiseup' ); ?></a>
				</nav>
				<?php if ( $topic ) : ?><a class="bl-tag bl-tag--link" href="<?php echo esc_url( $topic[1] ); ?>"><?php echo esc_html( $topic[0] ); ?></a><?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<div class="bs-meta">
					<span class="bs-by"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', '', array( 'class' => 'bs-avatar' ) ); ?><?php echo esc_html( get_the_author() ); ?></span>
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span><?php echo esc_html( sprintf( __( '%d min read', 'wiseup' ), wiseup_read_minutes() ) ); ?></span>
				</div>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="bl-wrap"><figure class="bs-cover"><?php the_post_thumbnail( 'full', array( 'alt' => '' ) ); ?></figure></div>
			<?php endif; ?>
		</header>

		<div class="bl-wrap bl-wrap--narrow">
			<div class="bs-content"><?php the_content(); ?></div>

			<?php if ( $tags ) : ?>
				<p class="bs-tags"><?php foreach ( $tags as $t ) echo '<span>#' . esc_html( $t->name ) . '</span>'; ?></p>
			<?php endif; ?>

			<div class="bs-share">
				<span><?php esc_html_e( 'Share this article', 'wiseup' ); ?></span>
				<a href="<?php echo esc_url( 'https://wa.me/?text=' . rawurlencode( $title . ' ' . $url ) ); ?>" target="_blank" rel="noopener">WhatsApp</a>
				<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ) ); ?>" target="_blank" rel="noopener">LinkedIn</a>
				<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $title ) ); ?>" target="_blank" rel="noopener">X</a>
				<button type="button" data-copy="<?php echo esc_attr( $url ); ?>"><?php esc_html_e( 'Copy link', 'wiseup' ); ?></button>
			</div>

			<?php if ( $prev || $next ) : ?>
				<nav class="bs-nav" aria-label="<?php esc_attr_e( 'More articles', 'wiseup' ); ?>">
					<?php if ( $prev ) : ?><a class="bs-nav__prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><small>← <?php esc_html_e( 'Previous', 'wiseup' ); ?></small><?php echo esc_html( get_the_title( $prev ) ); ?></a><?php else : ?><span></span><?php endif; ?>
					<?php if ( $next ) : ?><a class="bs-nav__next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><small><?php esc_html_e( 'Next', 'wiseup' ); ?> →</small><?php echo esc_html( get_the_title( $next ) ); ?></a><?php endif; ?>
				</nav>
			<?php endif; ?>
		</div>
	</article>

	<?php if ( $related->have_posts() ) : ?>
		<section class="bl-list bs-related">
			<div class="bl-wrap">
				<h2 class="bs-related__h"><?php esc_html_e( 'Keep reading', 'wiseup' ); ?></h2>
				<div class="bl-grid">
					<?php while ( $related->have_posts() ) : $related->the_post(); wiseup_blog_card( false ); endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="bl-cta">
		<div class="bl-wrap bl-cta__box">
			<h2><?php esc_html_e( 'See the plan before you see a price.', 'wiseup' ); ?></h2>
			<a class="bl-btn" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( wiseup_opt( 'cta_label' ) ); ?></a>
		</div>
	</section>
</main>
<script>
document.querySelectorAll('[data-copy]').forEach(function (b) {
	b.addEventListener('click', function () {
		var t = b.getAttribute('data-copy'), done = function () { var o = b.textContent; b.textContent = 'Copied'; setTimeout(function () { b.textContent = o; }, 1600); };
		if (navigator.clipboard) navigator.clipboard.writeText(t).then(done); else { var i = document.createElement('input'); i.value = t; document.body.appendChild(i); i.select(); document.execCommand('copy'); i.remove(); done(); }
	});
});
</script>
<?php
wiseup_landing_close();
