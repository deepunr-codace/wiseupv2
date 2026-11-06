<?php
/**
 * Blog detail page, classic blog layout (owner, 2026-11-05: "need blog like layout not normal page").
 * Homepage design system (black, Inter, lime, eyebrow pill, dark #111113 cards).
 *
 * Main column: category pill, title, author photo + name · date · N min read, featured image, the block editor content.
 * Sidebar (sticky on desktop, below the article on phones): "Recent blogs" (5 newest other posts with thumbnail,
 * title, date) with a "View all" link, and "Categories" with post counts.
 *
 * The content is rendered with WordPress's own block styles (core block library, editor presets, per-block layout CSS)
 * even though wiseup_landing_isolate() removes theme styles; assets/css/blog-single.css restyles the blocks.
 * Earlier versions: scratchpad plugin-archive/blog-single.php.before-*.
 */
defined( 'ABSPATH' ) || exit;

wiseup_landing_isolate();
add_action( 'wp_head', function () {
	echo '<link rel="stylesheet" href="' . esc_url( includes_url( 'css/dist/block-library/style.min.css' ) . '?ver=' . get_bloginfo( 'version' ) ) . "\">\n";
	if ( function_exists( 'wp_get_global_stylesheet' ) ) {
		echo '<style id="wu-block-presets">' . wp_get_global_stylesheet( array( 'variables', 'presets' ) ) . "</style>\n"; // phpcs:ignore -- core-generated CSS
	}
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/blog-single.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/blog-single.css' ) ) . "\">\n";
}, 8 );
add_action( 'wp_footer', function () {
	if ( ! function_exists( 'wp_style_engine_get_stylesheet_from_context' ) ) return;
	$css = wp_style_engine_get_stylesheet_from_context( 'block-supports', array( 'optimize' => true ) );
	if ( $css ) echo '<style id="wu-block-supports">' . $css . "</style>\n"; // phpcs:ignore -- core-generated CSS
}, 2 );
wiseup_landing_open( 'wu-landing wu-post-page' );

the_post();
$wu_id     = get_the_ID();
$wu_topic  = wiseup_post_topic();
$wu_mins   = wiseup_read_minutes();
$wu_recent = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'post__not_in' => array( $wu_id ), 'posts_per_page' => 5, 'ignore_sticky_posts' => true ) );
$wu_cats   = get_categories( array( 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) );
$wu_arrow  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/></svg>';
?>
<div class="wiseup-home wiseup-in-theme wu-post">
<main id="main" class="bp-wrap wrap">
	<article class="bp" itemscope itemtype="https://schema.org/BlogPosting">
		<header class="bp-head">
			<a class="eyebrow bp-eyebrow" href="<?php echo esc_url( $wu_topic ? $wu_topic[1] : home_url( '/blog/' ) ); ?>"><span class="eyebrow__dot" aria-hidden="true"></span><?php echo esc_html( $wu_topic ? $wu_topic[0] : __( 'Blog', 'wiseup' ) ); ?></a>
			<h1 class="bp-title" itemprop="headline"><?php the_title(); ?></h1>
			<div class="bp-by">
				<?php echo get_avatar( (int) get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'bp-by__img' ) ); ?>
				<span class="bp-by__txt">
					<span class="bp-by__name" itemprop="author"><?php echo esc_html( get_the_author() ); ?></span>
					<span class="bp-by__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></time> · <?php echo esc_html( sprintf( _n( '%d min read', '%d mins read', $wu_mins, 'wiseup' ), $wu_mins ) ); ?></span>
				</span>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="bp-cover">
			<?php the_post_thumbnail( 'full', array( 'class' => 'bp-cover__img', 'sizes' => '(max-width: 1023px) 94vw, 860px', 'loading' => 'eager', 'fetchpriority' => 'high', 'itemprop' => 'image' ) ); ?>
		</figure>
		<?php endif; ?>

		<div class="bp-content entry-content" itemprop="articleBody"><?php the_content(); ?></div>
	</article>

	<aside class="bp-side" aria-label="<?php esc_attr_e( 'Blog sidebar', 'wiseup' ); ?>">
		<?php if ( $wu_recent->have_posts() ) : ?>
		<section class="bp-widget" aria-labelledby="bp-recent-h">
			<div class="bp-widget__head">
				<h2 id="bp-recent-h"><?php esc_html_e( 'Recent blogs', 'wiseup' ); ?></h2>
				<a class="bp-widget__all" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'View all', 'wiseup' ); ?> <?php echo $wu_arrow; // phpcs:ignore -- static SVG ?></a>
			</div>
			<ul class="bp-recent">
				<?php while ( $wu_recent->have_posts() ) : $wu_recent->the_post(); ?>
				<li><a class="bp-recent__a" href="<?php the_permalink(); ?>">
					<span class="bp-recent__img"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy', 'alt' => '' ) ); } else { echo '<span aria-hidden="true">' . esc_html( mb_strtoupper( mb_substr( wp_strip_all_tags( get_the_title() ), 0, 1 ) ) ) . '</span>'; } ?></span>
					<span class="bp-recent__txt"><span class="bp-recent__t"><?php the_title(); ?></span><span class="bp-recent__d"><?php echo esc_html( get_the_date() ); ?></span></span>
				</a></li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</section>
		<?php endif; ?>

		<?php if ( $wu_cats ) : ?>
		<section class="bp-widget" aria-labelledby="bp-cats-h">
			<div class="bp-widget__head"><h2 id="bp-cats-h"><?php esc_html_e( 'Categories', 'wiseup' ); ?></h2></div>
			<ul class="bp-cats">
				<?php foreach ( $wu_cats as $c ) : ?>
				<li><a href="<?php echo esc_url( add_query_arg( 'topic', $c->slug, home_url( '/blog/' ) ) ); ?>"<?php echo ( $wu_topic && $wu_topic[0] === $c->name ) ? ' aria-current="true"' : ''; ?>><span><?php echo esc_html( $c->name ); ?></span><span class="bp-cats__n"><?php echo (int) $c->count; ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</section>
		<?php endif; ?>
	</aside>
</main>
</div>
<?php
$wu_lead_source = 'blog';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'blog' );
