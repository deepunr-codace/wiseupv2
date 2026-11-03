<?php
/** Blog listing, /blog/. Uses the WiseUp header and footer (includes/landing.php) and assets/css/blog.css. */
defined( 'ABSPATH' ) || exit;

wiseup_landing_open( 'wu-blog-page' );

global $wp_query;
$topic_slug = isset( $_GET['topic'] ) ? sanitize_title( wp_unslash( $_GET['topic'] ) ) : '';
$cats       = get_categories( array( 'hide_empty' => true ) );
$cats       = array_values( array_filter( $cats, function ( $c ) { return 'uncategorized' !== $c->slug; } ) );
$paged      = max( 1, (int) get_query_var( 'paged' ) );
$cta_url    = wiseup_opt( 'cta_url' ) ? wiseup_opt( 'cta_url' ) : home_url( '/#contact' );
?>
<main id="main" class="wu-blog">
	<section class="bl-hero">
		<div class="bl-wrap">
			<span class="bl-pill"><span class="bl-dot" aria-hidden="true"></span><?php esc_html_e( 'WiseUp Blog', 'wiseup' ); ?></span>
			<h1><?php echo $topic_slug ? esc_html( single_cat_title( '', false ) ?: ucwords( str_replace( '-', ' ', $topic_slug ) ) ) : esc_html__( 'Blogs', 'wiseup' ); ?></h1>
			<p><?php esc_html_e( 'Notes on branding, marketing and growth from the WiseUp team.', 'wiseup' ); ?></p>
			<?php if ( $cats ) : ?>
				<nav class="bl-chips" aria-label="<?php esc_attr_e( 'Blog topics', 'wiseup' ); ?>">
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"<?php echo $topic_slug ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All', 'wiseup' ); ?></a>
					<?php foreach ( $cats as $c ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'topic', $c->slug, home_url( '/blog/' ) ) ); ?>"<?php echo $topic_slug === $c->slug ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $c->name ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</div>
	</section>

	<section class="bl-list">
		<div class="bl-wrap">
			<?php if ( have_posts() ) : $i = 0; ?>
				<?php while ( have_posts() ) : the_post(); $i++;
					if ( 1 === $i && 1 === $paged ) { wiseup_blog_card( true ); echo '<div class="bl-grid">'; continue; }
					if ( 1 === $i ) echo '<div class="bl-grid">';
					wiseup_blog_card( false );
				endwhile; ?>
				</div>
				<?php
				$links = paginate_links( array(
					'base'      => trailingslashit( home_url( '/blog/page/' ) ) . '%#%/',
					'format'    => '',
					'current'   => $paged,
					'total'     => (int) $wp_query->max_num_pages,
					'prev_text' => '←',
					'next_text' => '→',
					'type'      => 'list',
					'add_args'  => $topic_slug ? array( 'topic' => $topic_slug ) : false,
				) );
				if ( $links ) echo '<nav class="bl-pager" aria-label="' . esc_attr__( 'Pagination', 'wiseup' ) . '">' . $links . '</nav>'; // phpcs:ignore -- core markup
				?>
			<?php else : ?>
				<p class="bl-empty"><?php esc_html_e( 'No articles here yet. Please check back soon.', 'wiseup' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="bl-cta">
		<div class="bl-wrap bl-cta__box">
			<h2><?php esc_html_e( 'See the plan before you see a price.', 'wiseup' ); ?></h2>
			<a class="bl-btn" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( wiseup_opt( 'cta_label' ) ); ?></a>
		</div>
	</section>
</main>
<?php
wiseup_landing_close();
