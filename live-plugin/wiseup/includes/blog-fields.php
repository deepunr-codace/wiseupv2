<?php
/**
 * Blog detail custom fields (owner, 2026-11-05: "i need custom fields", for the simplified blog detail page).
 * A "WiseUp: article details" box under the post editor. Every field is optional: an empty field falls back to the
 * WordPress value or hides its block (landing/blog-single.php), so an ordinary post still looks right.
 * Stored as post meta `_wu_<key>`.
 */
defined( 'ABSPATH' ) || exit;

/** Field definitions in display order: key => [ type, label, help, group heading (first field of a group only) ]. */
function wiseup_blog_fields() {
	return array(
		'subtitle'     => array( 'textarea', __( 'Subtitle', 'wiseup' ), __( 'Line under the title. Empty = no subtitle.', 'wiseup' ), __( 'Top of the page', 'wiseup' ) ),
		'author_name'  => array( 'text', __( 'Author name', 'wiseup' ), __( 'Empty = the WordPress author (e.g. "admin").', 'wiseup' ) ),
		'author_photo' => array( 'image', __( 'Author photo', 'wiseup' ), __( 'Empty = the WordPress profile picture.', 'wiseup' ) ),
		'author_role'  => array( 'text', __( 'Author role', 'wiseup' ), __( 'Shown after the name, e.g. "Brand strategist".', 'wiseup' ) ),
		'read_time'    => array( 'number', __( 'Reading time (minutes)', 'wiseup' ), __( 'Shown beside the date. Empty = worked out from the text.', 'wiseup' ) ),
		'cover_cap'    => array( 'text', __( 'Featured image caption', 'wiseup' ), __( 'Shown under the featured image. Empty = the image\'s own caption, if any.', 'wiseup' ) ),
		'takeaways'    => array( 'textarea', __( 'Key takeaways', 'wiseup' ), __( 'One per line. A numbered card before the article.', 'wiseup' ), __( 'Around the article', 'wiseup' ) ),
		'stats'        => array( 'textarea', __( 'Highlight figures', 'wiseup' ), __( 'One per line: figure | label, e.g. "160% | follower growth in 60 days". Up to 4, shown before the article.', 'wiseup' ) ),
		'faq'          => array( 'textarea', __( 'FAQ', 'wiseup' ), __( 'One per line: question | answer. Shown after the article, also given to Google as FAQ data.', 'wiseup' ) ),
		'sources'      => array( 'textarea', __( 'Sources', 'wiseup' ), __( 'One per line: title | URL.', 'wiseup' ) ),
		'cta_heading'  => array( 'text', __( 'Heading', 'wiseup' ), __( 'Fill to show a call-to-action box after the article.', 'wiseup' ), __( 'Call to action', 'wiseup' ) ),
		'cta_text'     => array( 'textarea', __( 'Text', 'wiseup' ), __( 'Optional line under the heading.', 'wiseup' ) ),
		'cta_label'    => array( 'text', __( 'Button label', 'wiseup' ), __( 'Empty = "Get our plan".', 'wiseup' ) ),
		'cta_url'      => array( 'url', __( 'Button link', 'wiseup' ), __( 'Empty = opens the lead form.', 'wiseup' ) ),
		'related'      => array( 'posts', __( 'Posts to show', 'wiseup' ), __( 'Pick up to 3 (Ctrl / Cmd + click). None picked = same category, else the newest.', 'wiseup' ), __( 'Continue reading', 'wiseup' ) ),
		'hide_cover'   => array( 'check', __( 'Hide the featured image', 'wiseup' ), '', __( 'Show / hide', 'wiseup' ) ),
		'hide_share'   => array( 'check', __( 'Hide share icons', 'wiseup' ), '' ),
		'hide_related' => array( 'check', __( 'Hide "Continue reading"', 'wiseup' ), '' ),
	);
}

/** One field's value for a post ('' when empty). */
function wiseup_post_field( $key, $post = null ) {
	$post = get_post( $post );
	return $post ? (string) get_post_meta( $post->ID, '_wu_' . $key, true ) : '';
}

/** A "a | b" per-line field as a list of [ a, b ] pairs (b may be ''). */
function wiseup_post_field_pairs( $key, $post = null ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', wiseup_post_field( $key, $post ) ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) continue;
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$out[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' );
	}
	return $out;
}

/** A one-item-per-line field as a list of strings. */
function wiseup_post_field_lines( $key, $post = null ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', wiseup_post_field( $key, $post ) ) ), 'strlen' ) );
}

/** The chosen "Continue reading" post IDs (published only). */
function wiseup_post_field_ids( $key, $post = null ) {
	$ids = array_filter( array_map( 'absint', explode( ',', wiseup_post_field( $key, $post ) ) ) );
	return array_values( array_filter( $ids, function ( $id ) { return 'publish' === get_post_status( $id ); } ) );
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && 'post' === get_current_screen()->post_type ) wp_enqueue_media();
} );

add_action( 'add_meta_boxes_post', function ( $post ) {
	add_meta_box( 'wiseup-article', __( 'WiseUp: article details', 'wiseup' ), function ( $post ) {
		wp_nonce_field( 'wiseup_article', 'wiseup_article_nonce' );
		?>
		<style>
		.wu-af{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 22px;padding-top:4px}
		.wu-af__f{display:grid;gap:5px;align-content:start}.wu-af__f--wide{grid-column:1/-1}.wu-af__f label{font-weight:600}
		.wu-af__f textarea{min-height:72px}.wu-af__f .description{margin:0}.wu-af__f select[multiple]{min-height:150px}
		.wu-af__h{grid-column:1/-1;margin:10px 0 0;padding-top:12px;border-top:1px solid #dcdcde;font-size:12px;text-transform:uppercase;letter-spacing:.07em;color:#50575e}
		.wu-af__h:first-child{margin-top:0;padding-top:0;border:0}
		.wu-af__checks{grid-column:1/-1;display:flex;flex-wrap:wrap;gap:8px 24px}
		.wu-af__img{display:flex;align-items:center;gap:10px}.wu-af__img img{width:48px;height:48px;border-radius:50%;object-fit:cover;background:#f0f0f1}
		.wu-af__img img:not([src]),.wu-af__img img[src=""]{display:none}
		@media(max-width:782px){.wu-af{grid-template-columns:1fr}}
		</style>
		<div class="wu-af">
		<?php
		$checks = false;
		foreach ( wiseup_blog_fields() as $key => $f ) {
			if ( ! empty( $f[3] ) ) {
				if ( $checks ) { echo '</div>'; $checks = false; }
				echo '<h4 class="wu-af__h">' . esc_html( $f[3] ) . '</h4>';
				if ( 'check' === $f[0] ) { echo '<div class="wu-af__checks">'; $checks = true; }
			}
			$name = 'wu_af[' . $key . ']';
			$id   = 'wu-af-' . $key;
			$val  = (string) get_post_meta( $post->ID, '_wu_' . $key, true );
			if ( 'check' === $f[0] ) {
				printf( '<label><input type="checkbox" name="%s" value="1" %s> %s</label>', esc_attr( $name ), checked( '' !== $val, true, false ), esc_html( $f[1] ) );
				continue;
			}
			$wide = in_array( $f[0], array( 'textarea', 'posts' ), true ) ? ' wu-af__f--wide' : '';
			echo '<div class="wu-af__f' . esc_attr( $wide ) . '"><label for="' . esc_attr( $id ) . '">' . esc_html( $f[1] ) . '</label>';
			switch ( $f[0] ) {
				case 'textarea':
					echo '<textarea class="widefat" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="3">' . esc_textarea( $val ) . '</textarea>';
					break;
				case 'image':
					$src = $val ? wp_get_attachment_image_url( (int) $val, 'thumbnail' ) : '';
					echo '<div class="wu-af__img" data-wu-img><img src="' . esc_url( $src ) . '" alt=""><input type="hidden" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">'
						. '<button type="button" class="button" data-wu-pick>' . esc_html__( 'Choose image', 'wiseup' ) . '</button>'
						. '<button type="button" class="button-link" data-wu-clear' . ( $val ? '' : ' hidden' ) . '>' . esc_html__( 'Remove', 'wiseup' ) . '</button></div>';
					break;
				case 'posts':
					$chosen = array_filter( array_map( 'absint', explode( ',', $val ) ) );
					$posts  = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 200, 'exclude' => array( $post->ID ), 'fields' => 'ids' ) );
					echo '<select class="widefat" multiple id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '[]">';
					foreach ( $posts as $pid ) {
						printf( '<option value="%d" %s>%s</option>', (int) $pid, selected( in_array( (int) $pid, $chosen, true ), true, false ), esc_html( get_the_title( $pid ) . ' (' . get_the_date( '', $pid ) . ')' ) );
					}
					echo '</select>';
					break;
				default:
					$type = 'number' === $f[0] ? 'number" min="1" max="120' : ( 'url' === $f[0] ? 'url' : 'text' );
					echo '<input class="widefat" type="' . $type . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">'; // phpcs:ignore -- $type is a fixed string
			}
			if ( $f[2] ) echo '<p class="description">' . esc_html( $f[2] ) . '</p>';
			echo '</div>';
		}
		if ( $checks ) echo '</div>';
		?>
		</div>
		<script>
		document.querySelectorAll('#wiseup-article [data-wu-img]').forEach(function (box) {
			var input = box.querySelector('input'), img = box.querySelector('img'), clear = box.querySelector('[data-wu-clear]'), frame;
			box.querySelector('[data-wu-pick]').addEventListener('click', function () {
				if (!window.wp || !wp.media) return;
				frame = frame || wp.media({ title: <?php echo wp_json_encode( __( 'Author photo', 'wiseup' ) ); ?>, library: { type: 'image' }, multiple: false });
				frame.off('select').on('select', function () {
					var a = frame.state().get('selection').first().toJSON();
					input.value = a.id; img.src = (a.sizes && a.sizes.thumbnail ? a.sizes.thumbnail.url : a.url); clear.hidden = false;
				});
				frame.open();
			});
			clear.addEventListener('click', function () { input.value = ''; img.removeAttribute('src'); clear.hidden = true; });
		});
		</script>
		<?php
	}, 'post', 'normal', 'high' );
} );

add_action( 'save_post_post', function ( $id ) {
	if ( ! isset( $_POST['wiseup_article_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wiseup_article_nonce'] ) ), 'wiseup_article' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	$in = isset( $_POST['wu_af'] ) && is_array( $_POST['wu_af'] ) ? wp_unslash( $_POST['wu_af'] ) : array(); // phpcs:ignore -- sanitized per field below
	foreach ( wiseup_blog_fields() as $key => $f ) {
		$raw = isset( $in[ $key ] ) ? $in[ $key ] : '';
		switch ( $f[0] ) {
			case 'check':    $v = $raw ? '1' : ''; break;
			case 'number':
			case 'image':    $v = absint( $raw ) ? (string) absint( $raw ) : ''; break;
			case 'posts':    $v = implode( ',', array_slice( array_filter( array_map( 'absint', (array) $raw ) ), 0, 3 ) ); break;
			case 'url':      $v = esc_url_raw( trim( (string) $raw ) ); break;
			case 'textarea': $v = sanitize_textarea_field( (string) $raw ); break;
			default:         $v = sanitize_text_field( (string) $raw );
		}
		if ( '' === $v ) delete_post_meta( $id, '_wu_' . $key );
		else update_post_meta( $id, '_wu_' . $key, $v );
	}
} );

// FAQ data for search engines, from the FAQ field.
add_action( 'wp_head', function () {
	if ( ! is_singular( 'post' ) ) return;
	$faq = array();
	foreach ( wiseup_post_field_pairs( 'faq', get_queried_object_id() ) as $p ) {
		if ( '' === $p[1] ) continue;
		$faq[] = array( '@type' => 'Question', 'name' => $p[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $p[1] ) );
	}
	if ( $faq ) echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faq ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 7 );

// The BlogPosting data and the page's author line use the "Author name" field when it is filled.
add_filter( 'the_author', function ( $name ) {
	if ( is_admin() || ! is_singular( 'post' ) ) return $name;
	$set = wiseup_post_field( 'author_name' );
	return $set ? $set : $name;
} );
