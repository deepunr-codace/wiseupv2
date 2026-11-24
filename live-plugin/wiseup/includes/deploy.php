<?php
/**
 * Remote deploy for this plugin (owner, 2026-11-24: update the live site without uploading the zip in wp-admin).
 *
 * Off unless wp-config.php defines WISEUP_DEPLOY_KEY (a long random string, at least 32 characters). The deploy script
 * (wiseup-site/scripts/deploy-plugin.mjs) sends the same key in the X-Wiseup-Deploy-Key header.
 *
 * Routes (REST, all need the key):
 *   GET  wiseup/v1/deploy/status    plugin version + a sha1 of every plugin file (the script sends only what differs)
 *   POST wiseup/v1/deploy           { version, files: { "rel/path": base64 }, delete: [ "rel/path" ], clear_priority }
 *   POST wiseup/v1/deploy/rollback  puts back the files of the last deploy
 *   POST wiseup/v1/deploy/cache     clears WP Rocket (page cache + minified files; { priority: true } also priority elements)
 *
 * Safety, in order: only paths inside this plugin with known file types; every file's sha1 must match what was sent;
 * every PHP file is syntax-checked (token_get_all TOKEN_PARSE) before anything is written; the current files are
 * copied to uploads/wiseup-deploy/backups/<id>/; files are written through a temp file + rename, wiseup.php last;
 * then the homepage and every page using a WiseUp template are loaded once (cache bypassed): a 5xx or a WordPress
 * "critical error" puts every file back at once. WP Rocket's cache is cleared after a good deploy.
 */
defined( 'ABSPATH' ) || exit;

function wiseup_deploy_ok_key( WP_REST_Request $r ) {
	if ( ! defined( 'WISEUP_DEPLOY_KEY' ) || strlen( (string) WISEUP_DEPLOY_KEY ) < 32 ) return new WP_Error( 'wiseup_deploy_off', 'Deploy is not set up.', array( 'status' => 403 ) );
	$k = (string) $r->get_header( 'x-wiseup-deploy-key' );
	if ( '' === $k || ! hash_equals( (string) WISEUP_DEPLOY_KEY, $k ) ) return new WP_Error( 'wiseup_deploy_key', 'Wrong key.', array( 'status' => 403 ) );
	return true;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wiseup/v1', '/deploy/status', array( 'methods' => 'GET', 'callback' => 'wiseup_deploy_status', 'permission_callback' => 'wiseup_deploy_ok_key' ) );
	register_rest_route( 'wiseup/v1', '/deploy', array( 'methods' => 'POST', 'callback' => 'wiseup_deploy_run', 'permission_callback' => 'wiseup_deploy_ok_key' ) );
	register_rest_route( 'wiseup/v1', '/deploy/cache', array( 'methods' => 'POST', 'callback' => 'wiseup_deploy_cache_route', 'permission_callback' => 'wiseup_deploy_ok_key' ) );
	register_rest_route( 'wiseup/v1', '/deploy/rollback', array( 'methods' => 'POST', 'callback' => 'wiseup_deploy_rollback_route', 'permission_callback' => 'wiseup_deploy_ok_key' ) );
} );

function wiseup_deploy_root() { return wp_normalize_path( untrailingslashit( WISEUP_DIR ) ); }
function wiseup_deploy_store() {
	$d = wp_normalize_path( wp_upload_dir()['basedir'] ) . '/wiseup-deploy';
	if ( ! is_dir( $d ) ) {
		wp_mkdir_p( $d );
		@file_put_contents( $d . '/index.php', "<?php // Silence.\n" );
		@file_put_contents( $d . '/.htaccess', "Require all denied\nDeny from all\n" );
	}
	return $d;
}

/** A relative path inside the plugin with an allowed file type, or false. */
function wiseup_deploy_rel( $rel ) {
	$rel = str_replace( '\\', '/', (string) $rel );
	if ( '' === $rel || '/' === $rel[0] || false !== strpos( $rel, '..' ) || ! preg_match( '#^[A-Za-z0-9._\-/]+$#', $rel ) ) return false;
	if ( ! preg_match( '#\.(php|js|css|json|txt|md|svg|webp|png|jpe?g|gif|avif|ico|woff2?|ttf|mp4|webm|mp3|pdf|html)$#i', $rel ) ) return false;
	return $rel;
}

function wiseup_deploy_files() {
	$root = wiseup_deploy_root(); $out = array();
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $it as $f ) {
		if ( ! $f->isFile() ) continue;
		$rel = ltrim( substr( wp_normalize_path( $f->getPathname() ), strlen( $root ) ), '/' );
		$out[ $rel ] = sha1_file( $f->getPathname() );
	}
	ksort( $out );
	return $out;
}

function wiseup_deploy_status() {
	return array( 'version' => WISEUP_VERSION, 'php' => PHP_VERSION, 'writable' => is_writable( wiseup_deploy_root() ), 'files' => wiseup_deploy_files(), 'log' => array_slice( (array) get_option( 'wiseup_deploy_log', array() ), 0, 5 ), 'plugins' => array_values( (array) get_option( 'active_plugins', array() ) ), 'server' => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '', 'cache_path' => defined( 'RT_WP_NGINX_HELPER_CACHE_PATH' ) ? RT_WP_NGINX_HELPER_CACHE_PATH : '' );
}

function wiseup_deploy_php_ok( $code, &$err ) {
	if ( ! defined( 'TOKEN_PARSE' ) ) return true;
	try { token_get_all( $code, TOKEN_PARSE ); return true; }
	catch ( \Throwable $e ) { $err = $e->getMessage() . ' (line ' . $e->getLine() . ')'; return false; }
}

function wiseup_deploy_put( $path, $data ) {
	wp_mkdir_p( dirname( $path ) );
	$tmp = $path . '.wudeploy-' . wp_generate_password( 6, false );
	if ( false === file_put_contents( $tmp, $data ) ) return false;
	if ( ! @rename( $tmp, $path ) ) { @unlink( $tmp ); return false; }
	if ( function_exists( 'opcache_invalidate' ) && '.php' === substr( $path, -4 ) ) @opcache_invalidate( $path, true );
	return true;
}

/** Load the homepage and every page on a WiseUp template; returns array( broken[], unreachable[], checked ). */
function wiseup_deploy_health() {
	$urls = array( home_url( '/' ) );
	$q = get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'numberposts' => 20, 'fields' => 'ids',
		'meta_query' => array( array( 'key' => '_wp_page_template', 'value' => 'wiseup-', 'compare' => 'LIKE' ) ) ) );
	foreach ( $q as $id ) $urls[] = get_permalink( $id );
	$urls = array_values( array_unique( array_filter( $urls ) ) );
	$broken = array(); $unreach = array();
	$bad = function ( $u, $code, $body ) use ( &$broken ) {
		if ( $code >= 500 || false !== stripos( $body, 'critical error' ) || preg_match( '/<b>(Fatal|Parse) error<\/b>/i', $body ) ) $broken[] = $u . ' (' . $code . ')';
	};
	$cls = class_exists( '\WpOrg\Requests\Requests' ) ? '\WpOrg\Requests\Requests' : ( class_exists( 'Requests' ) ? 'Requests' : '' );
	if ( $cls ) {
		// all pages at once (they were loaded one after another)
		$reqs = array();
		foreach ( $urls as $i => $u ) $reqs[ $i ] = array( 'url' => add_query_arg( 'wu_deploy_check', wp_generate_password( 8, false ), $u ), 'headers' => array( 'Cache-Control' => 'no-cache' ) );
		$res = call_user_func( array( $cls, 'request_multiple' ), $reqs, array( 'timeout' => 30, 'connect_timeout' => 10, 'verify' => false, 'redirects' => 3 ) );
		foreach ( $urls as $i => $u ) {
			$r = isset( $res[ $i ] ) ? $res[ $i ] : null;
			if ( ! is_object( $r ) || ! isset( $r->status_code ) ) { $unreach[] = $u; continue; }
			$bad( $u, (int) $r->status_code, (string) $r->body );
		}
		return array( $broken, $unreach, count( $urls ) );
	}
	foreach ( $urls as $u ) {
		$res = wp_remote_get( add_query_arg( 'wu_deploy_check', wp_generate_password( 8, false ), $u ), array( 'timeout' => 25, 'sslverify' => false, 'redirection' => 3, 'headers' => array( 'Cache-Control' => 'no-cache' ) ) );
		if ( is_wp_error( $res ) ) { $unreach[] = $u; continue; }
		$bad( $u, (int) wp_remote_retrieve_response_code( $res ), (string) wp_remote_retrieve_body( $res ) );
	}
	return array( $broken, $unreach, count( $urls ) );
}

function wiseup_deploy_restore( $id ) {
	$root = wiseup_deploy_root(); $dir = wiseup_deploy_store() . '/backups/' . $id;
	$man = json_decode( (string) @file_get_contents( $dir . '/manifest.json' ), true );
	if ( ! is_array( $man ) ) return false;
	foreach ( (array) $man['existed'] as $rel ) {
		if ( ! wiseup_deploy_rel( $rel ) ) continue;
		wiseup_deploy_put( $root . '/' . $rel, (string) file_get_contents( $dir . '/files/' . $rel ) );
	}
	foreach ( (array) $man['added'] as $rel ) { if ( wiseup_deploy_rel( $rel ) ) @unlink( $root . '/' . $rel ); }
	return true;
}

function wiseup_deploy_log( $row ) {
	$log = (array) get_option( 'wiseup_deploy_log', array() );
	array_unshift( $log, $row + array( 'at' => current_time( 'mysql' ) ) );
	update_option( 'wiseup_deploy_log', array_slice( $log, 0, 20 ), false );
}

function wiseup_deploy_clear_cache( $priority ) {
	if ( function_exists( 'rocket_clean_domain' ) ) rocket_clean_domain();
	// server-level page caches (live answers X-FastCGI-Cache: HIT; WP Rocket alone left the old pages there)
	wiseup_deploy_purge_nginx();
	do_action( 'rt_nginx_helper_purge_all' );
	do_action( 'litespeed_purge_all' );
	do_action( 'breeze_clear_all_cache' );
	if ( class_exists( 'RunCloud_Hub' ) && method_exists( 'RunCloud_Hub', 'purge_cache_all' ) ) RunCloud_Hub::purge_cache_all();
	if ( function_exists( 'rocket_clean_minify' ) ) rocket_clean_minify();
	// rocket_clean_domain() did not empty the page cache when called from REST on live: empty WP Rocket's cache folders directly (cache files only)
	$rc = wp_normalize_path( WP_CONTENT_DIR ) . '/cache/';
	foreach ( array( 'wp-rocket', 'min', 'busting' ) as $sub ) {
		$d = $rc . $sub;
		if ( ! is_dir( $d ) ) continue;
		$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $d, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST );
		foreach ( $it as $f ) { if ( $f->isDir() ) @rmdir( $f->getPathname() ); else @unlink( $f->getPathname() ); }
	}
	if ( $priority ) {
		global $wpdb;
		foreach ( array( 'wpr_above_the_fold', 'wpr_lazy_render_content' ) as $t ) {
			$t = $wpdb->prefix . $t;
			if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $t ) ) === $t ) $wpdb->query( "TRUNCATE TABLE `$t`" ); // phpcs:ignore
		}
	}
	wp_cache_flush();
}

function wiseup_deploy_run( WP_REST_Request $r ) {
	@set_time_limit( 300 );
	if ( get_transient( 'wiseup_deploy_lock' ) ) return new WP_Error( 'wiseup_deploy_busy', 'Another deploy is running.', array( 'status' => 409 ) );
	$p = $r->get_json_params();
	$files = isset( $p['files'] ) && is_array( $p['files'] ) ? $p['files'] : array();
	$sha = isset( $p['sha1'] ) && is_array( $p['sha1'] ) ? $p['sha1'] : array();
	$del = isset( $p['delete'] ) && is_array( $p['delete'] ) ? $p['delete'] : array();
	if ( ! $files && ! $del ) return new WP_Error( 'wiseup_deploy_empty', 'Nothing to deploy.', array( 'status' => 400 ) );
	$root = wiseup_deploy_root();
	if ( ! is_writable( $root ) ) return new WP_Error( 'wiseup_deploy_fs', 'Plugin folder is not writable.', array( 'status' => 500 ) );

	// 1. check everything before touching anything
	$data = array();
	foreach ( $files as $rel => $b64 ) {
		$ok = wiseup_deploy_rel( $rel );
		if ( ! $ok ) return new WP_Error( 'wiseup_deploy_path', 'Path not allowed: ' . $rel, array( 'status' => 400 ) );
		$bin = base64_decode( (string) $b64, true );
		if ( false === $bin ) return new WP_Error( 'wiseup_deploy_data', 'Bad data: ' . $rel, array( 'status' => 400 ) );
		if ( empty( $sha[ $rel ] ) || ! hash_equals( (string) $sha[ $rel ], sha1( $bin ) ) ) return new WP_Error( 'wiseup_deploy_hash', 'Checksum mismatch: ' . $rel, array( 'status' => 400 ) );
		if ( '.php' === strtolower( substr( $ok, -4 ) ) ) {
			$err = '';
			if ( ! wiseup_deploy_php_ok( $bin, $err ) ) return new WP_Error( 'wiseup_deploy_php', 'PHP syntax error in ' . $rel . ': ' . $err, array( 'status' => 400 ) );
		}
		$data[ $ok ] = $bin;
	}
	foreach ( $del as $i => $rel ) {
		if ( ! wiseup_deploy_rel( $rel ) || 'wiseup.php' === $rel || 'includes/deploy.php' === $rel ) return new WP_Error( 'wiseup_deploy_path', 'Delete not allowed: ' . $rel, array( 'status' => 400 ) );
	}
	set_transient( 'wiseup_deploy_lock', 1, 300 );

	// 2. back up what will change
	$id = gmdate( 'Ymd-His' ) . '-' . wp_generate_password( 4, false );
	$bdir = wiseup_deploy_store() . '/backups/' . $id;
	$existed = array(); $added = array();
	foreach ( array_merge( array_keys( $data ), $del ) as $rel ) {
		if ( is_file( $root . '/' . $rel ) ) {
			wp_mkdir_p( dirname( $bdir . '/files/' . $rel ) );
			if ( ! copy( $root . '/' . $rel, $bdir . '/files/' . $rel ) ) { delete_transient( 'wiseup_deploy_lock' ); return new WP_Error( 'wiseup_deploy_backup', 'Backup failed: ' . $rel, array( 'status' => 500 ) ); }
			$existed[] = $rel;
		} elseif ( isset( $data[ $rel ] ) ) $added[] = $rel;
	}
	wp_mkdir_p( $bdir );
	file_put_contents( $bdir . '/manifest.json', wp_json_encode( array( 'from' => WISEUP_VERSION, 'to' => isset( $p['version'] ) ? (string) $p['version'] : '', 'existed' => $existed, 'added' => $added ) ) );
	update_option( 'wiseup_deploy_last', $id, false );

	// 3. write (wiseup.php last), then deletions
	$order = array_keys( $data ); usort( $order, function ( $a, $b ) { return ( 'wiseup.php' === $a ) - ( 'wiseup.php' === $b ); } );
	foreach ( $order as $rel ) {
		if ( ! wiseup_deploy_put( $root . '/' . $rel, $data[ $rel ] ) ) {
			wiseup_deploy_restore( $id ); delete_transient( 'wiseup_deploy_lock' );
			return new WP_Error( 'wiseup_deploy_write', 'Write failed (rolled back): ' . $rel, array( 'status' => 500 ) );
		}
	}
	foreach ( $del as $rel ) @unlink( $root . '/' . $rel );

	// 4. load the pages; any critical error puts everything back
	list( $broken, $unreach, $n ) = wiseup_deploy_health();
	if ( $broken ) {
		wiseup_deploy_restore( $id );
		delete_transient( 'wiseup_deploy_lock' );
		wiseup_deploy_log( array( 'id' => $id, 'to' => isset( $p['version'] ) ? $p['version'] : '', 'result' => 'rolled back', 'broken' => $broken ) );
		wiseup_deploy_clear_cache( false );
		return new WP_REST_Response( array( 'ok' => false, 'rolled_back' => true, 'broken' => $broken ), 500 );
	}
	wiseup_deploy_clear_cache( ! empty( $p['clear_priority'] ) );
	delete_transient( 'wiseup_deploy_lock' );
	wiseup_deploy_log( array( 'id' => $id, 'to' => isset( $p['version'] ) ? $p['version'] : '', 'result' => 'ok', 'files' => count( $data ), 'deleted' => count( $del ) ) );

	// keep the 5 newest backups
	$all = glob( wiseup_deploy_store() . '/backups/*', GLOB_ONLYDIR ); rsort( $all );
	foreach ( array_slice( $all, 5 ) as $old ) wiseup_deploy_rmdir( $old );

	return array( 'ok' => true, 'id' => $id, 'written' => count( $data ), 'deleted' => count( $del ), 'checked' => $n, 'unreachable' => $unreach );
}

function wiseup_deploy_rmdir( $d ) {
	if ( 0 !== strpos( wp_normalize_path( $d ), wiseup_deploy_store() . '/backups/' ) ) return;
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $d, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST );
	foreach ( $it as $f ) { if ( $f->isDir() ) @rmdir( $f->getPathname() ); else @unlink( $f->getPathname() ); }
	@rmdir( $d );
}

function wiseup_deploy_rollback_route() {
	$id = (string) get_option( 'wiseup_deploy_last', '' );
	if ( '' === $id || ! wiseup_deploy_restore( $id ) ) return new WP_Error( 'wiseup_deploy_none', 'No backup to restore.', array( 'status' => 404 ) );
	wiseup_deploy_clear_cache( false );
	delete_option( 'wiseup_deploy_last' );
	wiseup_deploy_log( array( 'id' => $id, 'result' => 'manual rollback' ) );
	return array( 'ok' => true, 'restored' => $id );
}

function wiseup_deploy_cache_route( WP_REST_Request $r ) {
	$p = (array) $r->get_json_params();
	wiseup_deploy_clear_cache( ! empty( $p['priority'] ) );
	wiseup_deploy_log( array( 'result' => 'cache cleared' . ( ! empty( $p['priority'] ) ? ' (+ priority elements)' : '' ) ) );
	return array( 'ok' => true, 'rocket' => function_exists( 'rocket_clean_domain' ), 'nginx' => wiseup_deploy_purge_nginx() );
}

/**
 * Empty the Nginx FastCGI cache zone (live answers X-FastCGI-Cache: HIT; the "Nginx Cache" plugin there has auto-purge
 * off, so WP Rocket's clear left old pages in it). Path from NGINX_CACHE_PATH or that plugin's setting; only emptied when
 * it looks like a cache zone (sub-folders named with 1-2 hex characters, as the plugin itself checks).
 */
function wiseup_deploy_purge_nginx() {
	$path = defined( 'NGINX_CACHE_PATH' ) ? NGINX_CACHE_PATH : get_option( 'nginx_cache_path' );
	$path = untrailingslashit( wp_normalize_path( (string) $path ) );
	if ( strlen( $path ) < 5 || '/' !== $path[0] || ! is_dir( $path ) || ! is_writable( $path ) ) return 'skipped';
	$kids = array_diff( (array) @scandir( $path ), array( '.', '..' ) );
	foreach ( $kids as $k ) if ( ! is_dir( $path . '/' . $k ) || ! preg_match( '/^[0-9a-f]{1,2}$/', $k ) ) return 'not a cache zone';
	foreach ( $kids as $k ) {
		$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path . '/' . $k, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST );
		foreach ( $it as $f ) { if ( $f->isDir() ) @rmdir( $f->getPathname() ); else @unlink( $f->getPathname() ); }
		@rmdir( $path . '/' . $k );
	}
	return 'purged ' . count( $kids );
}
