<?php
/**
 * Portfolio (owner, 2026-11-12: "move the template to our plugin", then "yeah move" for the item pages). Both
 * portfolio templates came from the Kadence theme and now live in the plugin, with the WiseUp header and footer:
 * - the listing, "WiseUp: Portfolio" (landing/portfolio.php; was themes/kadence/template-studio-portfolio.php), routed
 *   by includes/landing.php;
 * - each portfolio item (`portfolio` post type), landing/portfolio-single.php (was themes/kadence/single-portfolio.php),
 *   routed below; off with the `wiseup_portfolio_single` filter.
 * Their CSS/JS are the plugin's copies in assets/portfolio/ (from the theme's portfolio-assets2/).
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wu_video_thumbnail_url' ) ) {
	/**
	 * A cached still frame grabbed from a portfolio video (ffmpeg in uploads/ffmpeg-bin/, once), as in the theme
	 * templates: these are raw uploads whose metadata often sits at the end of the file, so the browser can't cheaply
	 * decode a poster frame. Same function name as the theme's, so whichever loads first is used.
	 */
	function wu_video_thumbnail_url( $video_url ) {
		$upload_dir = wp_upload_dir();
		if ( strpos( $video_url, $upload_dir['baseurl'] ) !== 0 ) return false;
		$video_path = $upload_dir['basedir'] . substr( $video_url, strlen( $upload_dir['baseurl'] ) );
		if ( ! file_exists( $video_path ) ) return false;
		$cache_dir  = $upload_dir['basedir'] . '/video-thumbs';
		$cache_key  = md5( $video_path . filemtime( $video_path ) );
		$cache_file = $cache_dir . '/' . $cache_key . '.jpg';
		$cache_url  = $upload_dir['baseurl'] . '/video-thumbs/' . $cache_key . '.jpg';
		if ( file_exists( $cache_file ) ) return $cache_url;
		if ( ! function_exists( 'shell_exec' ) ) return false;
		$ffmpeg = wiseup_portfolio_ffmpeg();
		if ( ! $ffmpeg ) return false;
		if ( ! is_dir( $cache_dir ) ) wp_mkdir_p( $cache_dir );
		$cmd = escapeshellarg( $ffmpeg ) . ' -ss 1 -i ' . escapeshellarg( $video_path ) . ' -frames:v 1 -q:v 4 -vf '
			. escapeshellarg( 'scale=640:-2' ) . ' -y ' . escapeshellarg( $cache_file ) . ' 2>&1';
		@shell_exec( $cmd ); // phpcs:ignore -- same as the theme templates
		return file_exists( $cache_file ) ? $cache_url : false;
	}
}

/** The ffmpeg build the portfolio uses (uploads/ffmpeg-bin/), or null. */
function wiseup_portfolio_ffmpeg() {
	$dir = wp_upload_dir()['basedir'] . '/ffmpeg-bin/';
	foreach ( array( 'ffmpeg', 'ffmpeg.exe' ) as $f ) {
		if ( file_exists( $dir . $f ) && ( 'ffmpeg.exe' === $f ) === ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) ) ) return $dir . $f;
	}
	return null;
}

/** Whether an MP4's index (moov) comes before its data (mdat), so a browser can start playing while it downloads. */
function wiseup_portfolio_faststart( $path ) {
	$fh = @fopen( $path, 'rb' );
	if ( ! $fh ) return false;
	$pos = 0;
	$size_all = filesize( $path );
	for ( $i = 0; $i < 16 && $pos + 8 <= $size_all; $i++ ) {
		fseek( $fh, $pos );
		$h = fread( $fh, 8 );
		if ( strlen( $h ) < 8 ) break;
		$size = unpack( 'N', substr( $h, 0, 4 ) )[1];
		$type = substr( $h, 4, 4 );
		if ( 'moov' === $type ) { fclose( $fh ); return true; }
		if ( 'mdat' === $type ) { fclose( $fh ); return false; }
		if ( 1 === $size ) { $big = unpack( 'J', fread( $fh, 8 ) )[1]; $size = (int) $big; }
		if ( $size < 8 ) break;
		$pos += $size;
	}
	fclose( $fh );
	return false;
}

/**
 * A web-ready copy of a portfolio video (owner, 2026-11-12: "fix video loading"). The uploads are raw: most keep their
 * index at the end of the file (the browser must download all of it, 20-50 MB, before showing a frame). Profiles:
 * - 'loop' (the carousel's muted, looping slide video): the first 30 seconds, longer side at most 1280px, no sound, H.264,
 *   index first; a few MB.
 * - 'play' (the lightbox on an item page, with sound and controls): the same file with its index moved to the front
 *   (no re-encode, same quality), so playback starts at once; files that already have it are served as they are.
 * Copies are made in the background with the ffmpeg in uploads/ffmpeg-bin/ (one at a time across the site) into
 * uploads/video-web/; until a copy is ready the original is served, so a page view never waits for ffmpeg.
 */
function wiseup_portfolio_video( $video_url, $profile = 'loop' ) {
	if ( ! apply_filters( 'wiseup_portfolio_web_video', true ) ) return $video_url;
	$up = wp_upload_dir();
	if ( 0 !== strpos( $video_url, $up['baseurl'] ) ) return $video_url;
	$src = $up['basedir'] . substr( $video_url, strlen( $up['baseurl'] ) );
	if ( ! file_exists( $src ) ) return $video_url;
	if ( 'play' === $profile && wiseup_portfolio_faststart( $src ) ) return $video_url;
	$key = md5( $src . '|' . filemtime( $src ) . '|' . $profile . '|2' ); // bump the last part when the encode settings change
	$dir = $up['basedir'] . '/video-web';
	if ( file_exists( "$dir/$key.mp4" ) ) return $up['baseurl'] . "/video-web/$key.mp4";
	wiseup_portfolio_video_job( $src, $dir, $key, $profile );
	return file_exists( "$dir/$key.mp4" ) ? $up['baseurl'] . "/video-web/$key.mp4" : $video_url;
}

/** Publishes a finished copy, or starts making one when no other copy is being made. */
function wiseup_portfolio_video_job( $src, $dir, $key, $profile ) {
	static $started = false;
	$tmp  = "$dir/$key.part.mp4";
	$prog = "$dir/$key.progress";
	$fail = "$dir/$key.failed";
	if ( file_exists( $prog ) ) {
		$p = (string) @file_get_contents( $prog );
		if ( false !== strpos( $p, 'progress=end' ) && file_exists( $tmp ) && filesize( $tmp ) > 1024 ) {
			@rename( $tmp, "$dir/$key.mp4" ); // phpcs:ignore -- plain file move in uploads
			@unlink( $prog );
			return;
		}
		if ( time() - filemtime( $prog ) < 120 ) return; // still being made (ffmpeg rewrites the progress file every half second)
		@unlink( $prog );
		@unlink( $tmp );
		@touch( $fail ); // stopped without finishing
		return;
	}
	if ( $started || ( file_exists( $fail ) && time() - filemtime( $fail ) < DAY_IN_SECONDS ) ) return;
	if ( ! function_exists( 'shell_exec' ) || ! function_exists( 'popen' ) ) return;
	$ffmpeg = wiseup_portfolio_ffmpeg();
	if ( ! $ffmpeg ) return;
	if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) return;
	foreach ( (array) glob( "$dir/*.progress" ) as $other ) { // one copy at a time across the site
		if ( $other && time() - filemtime( $other ) < 120 && false === strpos( (string) @file_get_contents( $other ), 'progress=end' ) ) return;
	}
	if ( 'loop' === $profile ) {
		$args = '-t 30 -an -vf ' . escapeshellarg( 'scale=min(1280\,iw):min(1280\,ih):force_original_aspect_ratio=decrease,scale=trunc(iw/2)*2:trunc(ih/2)*2' ) . ' -c:v libx264 -preset veryfast -crf 27 -pix_fmt yuv420p -movflags +faststart';
	} else {
		$args = '-c copy -movflags +faststart';
	}
	$cmd = escapeshellarg( $ffmpeg ) . ' -hide_banner -nostdin -loglevel error -i ' . escapeshellarg( $src ) . ' ' . $args
		. ' -progress ' . escapeshellarg( $prog ) . ' -y ' . escapeshellarg( $tmp );
	@file_put_contents( $prog, '' );
	$started = true;
	if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
		@pclose( @popen( 'start "" /B ' . $cmd . ' > NUL 2>&1', 'r' ) ); // phpcs:ignore -- background encode
	} else {
		@shell_exec( 'nohup nice -n 10 ' . $cmd . ' > /dev/null 2>&1 &' ); // phpcs:ignore -- background encode
	}
}

/** URL of a file in assets/portfolio/, versioned by its modification time. */
function wiseup_portfolio_asset( $rel ) {
	$path = WISEUP_DIR . 'assets/portfolio/' . $rel;
	return WISEUP_URL . 'assets/portfolio/' . $rel . '?v=' . ( file_exists( $path ) ? filemtime( $path ) : WISEUP_VERSION );
}

/** The portfolio listing page (the page on the WiseUp: Portfolio template), for "Back to Work". */
function wiseup_portfolio_url() {
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_query'     => array( array( 'key' => '_wp_page_template', 'value' => array( 'wiseup-portfolio', 'template-studio-portfolio.php' ), 'compare' => 'IN' ) ), // phpcs:ignore -- one small lookup
	) );
	if ( $pages ) return get_permalink( $pages[0] );
	$archive = get_post_type_archive_link( 'portfolio' );
	return $archive ? $archive : home_url( '/studio/portfolio/' );
}

/**
 * Head output shared by both portfolio templates: the theme fonts, the portfolio stylesheets and the fixes the WiseUp
 * header and footer need next to them. The stylesheets style bare tags (button, a, li, h1-h6, *); imported into a
 * cascade layer they lose to every unlayered rule, so the header and footer keep their own look and the portfolio
 * markup keeps the theme's. Call before wiseup_landing_open().
 */
function wiseup_portfolio_head() {
	add_action( 'wp_head', function () {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,300;0,400;0,500;0,600;1,500;1,600&amp;family=Open+Sans:wght@600;800&amp;family=Rajdhani:wght@700&amp;display=swap">' . "\n";
		$imports = '';
		foreach ( array( 'config', 'libs', 'style', 'responsive' ) as $f ) {
			$href = wiseup_portfolio_asset( 'css/' . $f . '.css' );
			echo '<link rel="preload" as="style" href="' . esc_url( $href ) . "\">\n";
			$imports .= '@import url("' . esc_url( $href ) . '") layer(anita);';
		}
		echo '<style id="wu-portfolio-theme">' . $imports . "</style>\n"; // phpcs:ignore -- escaped above
		?>
<style id="wu-portfolio-chrome">
html, body { margin: 0; padding: 0; background: #0c0c0f; color: #fff; font-family: "Epilogue", "Open Sans", sans-serif; overflow-x: hidden; overflow-y: auto; height: auto; }
/* what the WiseUp stylesheet's own resets don't cover (zero specificity, so its class rules still win) */
:where(.wu-chrome) li { padding: 0; }
:where(.wu-chrome) button { font-weight: inherit; line-height: inherit; text-align: inherit; }
.wu-chrome .hd__link--parent { font-size: 14px; font-weight: 500; line-height: 1.71; }
.wu-chrome .b--teal { color: var(--on-teal); } /* the shared ".wu-chrome a { color: inherit }" made the menu's lime button text white */
:where(.wu-chrome) :focus-visible { outline: revert; }
.wu-chrome footer { position: relative; z-index: 5; }
</style>
		<?php
	}, 7 );
}

/** Script tags for files in assets/portfolio/js/. */
function wiseup_portfolio_scripts( $files ) {
	foreach ( $files as $f ) echo '<script src="' . esc_url( wiseup_portfolio_asset( 'js/' . $f ) ) . '"></script>' . "\n";
}

// Portfolio items: the plugin's template instead of the theme's single-portfolio.php.
add_filter( 'template_include', function ( $template ) {
	if ( ! is_singular( 'portfolio' ) || ! apply_filters( 'wiseup_portfolio_single', true ) ) return $template;
	return WISEUP_DIR . 'landing/portfolio-single.php';
}, 100 );
