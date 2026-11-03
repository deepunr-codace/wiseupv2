<?php
/**
 * Blog: a listing page at /blog/ and a detail page for every post, both drawn with the WiseUp header, footer and design
 * (landing/blog-list.php, landing/blog-single.php), from ordinary WordPress posts. The theme's own blog templates are
 * not used. Posts keep their normal permalinks; only /blog/ is added.
 */
defined( 'ABSPATH' ) || exit;

define( 'WISEUP_BLOG_PER_PAGE', 10 ); // page 1 shows the first as a large featured card

add_action( 'init', function () {
	add_rewrite_rule( '^blog/?$', 'index.php?wiseup_blog=1', 'top' );
	add_rewrite_rule( '^blog/page/([0-9]+)/?$', 'index.php?wiseup_blog=1&paged=$matches[1]', 'top' );
	// flush once so /blog/ works the moment the plugin has this code, without a visit to Settings → Permalinks
	if ( get_option( 'wiseup_blog_rewrite' ) !== '1' ) {
		flush_rewrite_rules( false );
		update_option( 'wiseup_blog_rewrite', '1', false );
	}
} );

add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'wiseup_blog';
	return $vars;
} );

/** True on the /blog/ listing. */
function wiseup_is_blog_list() {
	return (bool) get_query_var( 'wiseup_blog' );
}

add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! $q->get( 'wiseup_blog' ) ) return;
	$q->set( 'post_type', 'post' );
	$q->set( 'post_status', 'publish' );
	$q->set( 'posts_per_page', WISEUP_BLOG_PER_PAGE );
	$q->set( 'ignore_sticky_posts', true );
	// ?topic=category-slug filters the list
	if ( ! empty( $_GET['topic'] ) ) $q->set( 'category_name', sanitize_title( wp_unslash( $_GET['topic'] ) ) );
} );

add_filter( 'template_include', function ( $template ) {
	if ( wiseup_is_blog_list() ) return WISEUP_DIR . 'landing/blog-list.php';
	if ( is_singular( 'post' ) ) return WISEUP_DIR . 'landing/blog-single.php';
	return $template;
}, 100 );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( wiseup_is_blog_list() ) $parts['title'] = __( 'Blogs', 'wiseup' );
	return $parts;
} );

add_action( 'wp_head', function () {
	if ( ! wiseup_is_blog_list() && ! is_singular( 'post' ) ) return;
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/blog.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/blog.css' ) ) . "\">\n";
	// description, only when no SEO plugin is doing it
	if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) && ! defined( 'AIOSEO_VERSION' ) ) {
		$desc = is_singular( 'post' ) ? wp_strip_all_tags( get_the_excerpt() ) : __( 'Notes on branding, marketing and growth from the WiseUp team in Kozhikode, Kerala.', 'wiseup' );
		if ( $desc ) echo '<meta name="description" content="' . esc_attr( wp_trim_words( $desc, 30, '' ) ) . "\">\n";
	}
	if ( is_singular( 'post' ) ) {
		$img = get_the_post_thumbnail_url( null, 'large' );
		$ld  = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => array( '@type' => 'Person', 'name' => get_the_author() ),
			'publisher'        => array( '@type' => 'Organization', 'name' => 'WiseUp', 'url' => home_url( '/' ) ),
			'mainEntityOfPage' => get_permalink(),
		);
		if ( $img ) $ld['image'] = $img;
		echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}, 7 );

/** Whole minutes to read a post, at least 1. */
function wiseup_read_minutes( $post = null ) {
	$post = get_post( $post );
	$n    = str_word_count( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
	return max( 1, (int) ceil( $n / 220 ) );
}

/** The post's first category (never "Uncategorized" unless it is the only one) as [ name, url ] or null. */
function wiseup_post_topic( $post = null ) {
	$cats = get_the_category( $post ? $post : get_the_ID() );
	if ( ! $cats ) return null;
	foreach ( $cats as $c ) if ( 'uncategorized' !== $c->slug ) return array( $c->name, add_query_arg( 'topic', $c->slug, home_url( '/blog/' ) ) );
	return null;
}

/** One post card (used by the grid, the featured slot and related posts). $big makes the featured layout. */
function wiseup_blog_card( $big = false ) {
	$topic = wiseup_post_topic();
	?>
	<article class="bl-card<?php echo $big ? ' bl-card--big' : ''; ?>">
		<a class="bl-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php if ( has_post_thumbnail() ) : the_post_thumbnail( $big ? 'large' : 'medium_large', array( 'loading' => 'lazy', 'alt' => '' ) ); else : ?>
				<span class="bl-card__ph" aria-hidden="true"><?php echo esc_html( mb_strtoupper( mb_substr( wp_strip_all_tags( get_the_title() ), 0, 1 ) ) ); ?></span>
			<?php endif; ?>
		</a>
		<div class="bl-card__body">
			<div class="bl-card__meta">
				<?php if ( $topic ) : ?><span class="bl-tag"><?php echo esc_html( $topic[0] ); ?></span><?php endif; ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span><?php echo esc_html( sprintf( _n( '%d min read', '%d min read', wiseup_read_minutes(), 'wiseup' ), wiseup_read_minutes() ) ); ?></span>
			</div>
			<h2 class="bl-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="bl-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), $big ? 38 : 22 ) ); ?></p>
			<a class="bl-card__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'wiseup' ); ?><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"/><path d="M8.5 7H17v8.5"/></svg></a>
		</div>
	</article>
	<?php
}
