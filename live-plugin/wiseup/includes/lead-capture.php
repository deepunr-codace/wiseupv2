<?php
/**
 * Plugin Name: WiseUp Lead Capture
 * Description: Saves and emails the leads collected by the WiseUp SEO landing page, and gives its website scanner a safe sitemap reader.
 * Version:     1.0.0
 * Author:      WiseUp Branding
 * License:     GPL-2.0-or-later
 * Text Domain: wiseup-lead-capture
 *
 * What it adds
 *  - A "Leads" menu in the dashboard (one entry per visitor, updated as they move through the scanner).
 *  - An email to you when someone asks for the report or sends a quote request.
 *  - Optional webhook (Zapier, Make, n8n, Google Sheets script) that receives each lead as JSON.
 *  - Server-side checks that repeat the page's validation, plus rate limits.
 *  - A sitemap reader so the scanner can show real pages without browser (CORS) problems.
 *
 * @package WiseUp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class WiseUp_Lead_Capture {

	const CPT      = 'wiseup_lead';
	const OPTION   = 'wiseup_lead_settings';
	const STAGES   = array( 'scan-started', 'scan-complete', 'scan-complete-no-phone', 'phone-captured', 'email-captured', 'report-requested', 'exit-details', 'popup-closed', 'contact-form' );
	const NOTIFY   = array( 'report-requested', 'exit-details', 'contact-form' );
	const DISPOSABLE = array( 'mailinator.com', 'guerrillamail.com', 'guerrillamail.net', '10minutemail.com', 'tempmail.com', 'temp-mail.org', 'yopmail.com', 'trashmail.com', 'sharklasers.com', 'getnada.com', 'dispostable.com', 'maildrop.cc', 'throwawaymail.com', 'fakeinbox.com', 'mailnesia.com', 'mohmal.com', 'emailondeck.com', 'burnermail.io', 'spamgourmet.com', 'tempail.com', 'mintemail.com', 'moakt.com', 'tmpmail.org', 'discard.email', 'mailcatch.com' );

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		foreach ( array( 'wiseup_lead', 'wiseup_sitemap' ) as $action ) {
			add_action( 'wp_ajax_nopriv_' . $action, array( __CLASS__, 'ajax_' . substr( $action, 7 ) ) );
			add_action( 'wp_ajax_' . $action, array( __CLASS__, 'ajax_' . substr( $action, 7 ) ) );
		}
		if ( is_admin() ) {
			add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
			add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column_content' ), 10, 2 );
			add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
			add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
			add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
			add_action( 'admin_post_wiseup_export', array( __CLASS__, 'export_csv' ) );
			add_filter( 'views_edit-' . self::CPT, array( __CLASS__, 'export_link' ) );
		}
	}

	/* ------------------------------------------------------------------ data */

	public static function register_post_type() {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'          => 'Leads',
					'singular_name' => 'Lead',
					'menu_name'     => 'WiseUp Leads',
					'all_items'     => 'All leads',
					'search_items'  => 'Search leads',
					'not_found'     => 'No leads yet.',
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_icon'           => 'dashicons-email-alt',
				'menu_position'       => 26,
				'supports'            => array( 'title' ),
				'capability_type'     => 'post',
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'        => true,
				'exclude_from_search' => true,
				'show_in_rest'        => false,
			)
		);
	}

	private static function settings() {
		return wp_parse_args(
			get_option( self::OPTION, array() ),
			array(
				'email'   => get_option( 'admin_email' ),
				'webhook' => '',
				'notify'  => '1',
			)
		);
	}

	/* ------------------------------------------------------------------ helpers */

	private static function ip() {
		return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0.0.0.0';
	}

	private static function same_origin() {
		$origin = isset( $_SERVER['HTTP_ORIGIN'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_ORIGIN'] ) ) : '';
		if ( '' === $origin ) {
			return true; // some browsers omit it on same-origin requests
		}
		$a = wp_parse_url( $origin, PHP_URL_HOST );
		$b = wp_parse_url( home_url(), PHP_URL_HOST );
		return $a && $b && strtolower( preg_replace( '/^www\./', '', $a ) ) === strtolower( preg_replace( '/^www\./', '', $b ) );
	}

	/** Returns true if the caller is still under the limit. */
	private static function allow( $bucket, $max, $window ) {
		$key = 'wu_rl_' . $bucket . '_' . md5( self::ip() );
		$n   = (int) get_transient( $key );
		if ( $n >= $max ) {
			return false;
		}
		set_transient( $key, $n + 1, $window );
		return true;
	}

	private static function done( $code, $msg = '' ) {
		status_header( $code );
		wp_send_json( array( 'success' => $code < 300, 'message' => $msg ) );
	}

	/* ------------------------------------------------------------------ validation (mirrors the page) */

	private static function mash( $t ) {
		$t = strtolower( $t );
		if ( ! preg_match( '/^[a-z]+$/', $t ) ) {
			return false;
		}
		if ( strlen( $t ) >= 5 && ! preg_match( '/[aeiouy]/', $t ) ) {
			return true;
		}
		return (bool) preg_match( '/(asdf|qwer|zxcv|sdfg|dfgh|hjkl|ghjk|wert|erty|rtyu|tyui|yuio|uiop|xcvb|cvbn|vbnm)/', $t );
	}

	private static function clean_phone( $v ) {
		$v = is_string( $v ) ? trim( $v ) : '';
		if ( ! preg_match( '/^\+[1-9]\d{7,14}$/', $v ) ) {
			return '';
		}
		$national = preg_replace( '/^\+(91|1|44|971|61|65|966|974|968|973|965)/', '', $v );
		$d        = preg_match( '/^\+91\d{10}$/', $v ) ? substr( $v, 3 ) : $national;
		if ( 0 === strpos( $v, '+91' ) && ! preg_match( '/^[6-9]\d{9}$/', $d ) ) {
			return '';
		}
		if ( preg_match( '/^(\d)\1+$/', $d ) || preg_match( '/^(\d\d)\1{2,}$/', $d ) || false !== strpos( '01234567890123456789', $d ) || false !== strpos( '98765432109876543210', $d ) ) {
			return '';
		}
		return $v;
	}

	private static function clean_email( $v ) {
		$v = strtolower( trim( (string) $v ) );
		if ( '' === $v || strlen( $v ) > 254 || ! is_email( $v ) || false !== strpos( $v, '..' ) ) {
			return '';
		}
		list( $local, $domain ) = explode( '@', $v, 2 );
		if ( strlen( $local ) < 2 || in_array( $domain, self::DISPOSABLE, true ) || preg_match( '/^(example|test|fake|invalid|localhost|domain|sample|email|mail)\./', $domain ) ) {
			return '';
		}
		if ( preg_match( '/^(test|testing|asdf|asdfgh|qwerty|abc|abcd|xyz|fake|demo|noreply|none|null|na|nil|sample|dummy|email|mail|user|admin|name)\d*$/', $local ) || preg_match( '/^(.)\1+$/', preg_replace( '/[^a-z0-9]/', '', $local ) ) || self::mash( preg_replace( '/[^a-z]/', '', $local ) ) ) {
			return '';
		}
		return $v;
	}

	private static function clean_name( $v ) {
		$v = trim( preg_replace( '/\s+/u', ' ', (string) $v ) );
		if ( '' === $v || mb_strlen( $v ) < 2 || mb_strlen( $v ) > 60 || ! preg_match( "/^[\p{L}][\p{L} .'’-]*$/u", $v ) ) {
			return '';
		}
		$letters = preg_replace( '/[^\p{L}]/u', '', $v );
		if ( mb_strlen( $letters ) < 2 || preg_match( '/(.)\1{3,}/iu', $letters ) || preg_match( '/^(test|testing|tester|asdf|asdfgh|qwerty|qwe|abc|abcd|xyz|fake|demo|name|admin|user|none|null|na|nil|nothing|hello|hi|sample|dummy|company|business|noname)$/i', $v ) ) {
			return '';
		}
		foreach ( explode( ' ', $v ) as $w ) {
			if ( self::mash( $w ) ) {
				return '';
			}
		}
		return sanitize_text_field( $v );
	}

	private static function clean_company( $v ) {
		$v = trim( preg_replace( '/\s+/u', ' ', (string) $v ) );
		if ( '' === $v || mb_strlen( $v ) < 2 || mb_strlen( $v ) > 80 || ! preg_match( '/[\p{L}\d]{2,}/u', $v ) || preg_match( '/(.)\1{4,}/u', $v ) ) {
			return '';
		}
		return sanitize_text_field( $v );
	}

	private static function valid_host( $h ) {
		$h = strtolower( trim( (string) $h ) );
		if ( '' === $h || strlen( $h ) > 253 || preg_match( '/^\d+(\.\d+){3}$/', $h ) ) {
			return '';
		}
		$parts = explode( '.', $h );
		if ( count( $parts ) < 2 ) {
			return '';
		}
		foreach ( $parts as $p ) {
			if ( ! preg_match( '/^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?$/', $p ) ) {
				return '';
			}
		}
		if ( ! preg_match( '/^([a-z]{2,24}|xn--[a-z0-9-]{2,})$/', end( $parts ) ) ) {
			return '';
		}
		if ( preg_match( '/^(localhost|(www\.)?(example|test|domain|yourdomain|yoursite|yourwebsite|website|sample|abc|xyz|asdf)\.(com|org|net|in|co|co\.in))$/', $h ) ) {
			return '';
		}
		return $h;
	}

	/* ------------------------------------------------------------------ AJAX: lead */

	public static function ajax_lead() {
		nocache_headers();
		if ( ! self::same_origin() ) {
			self::done( 403, 'origin' );
		}
		$raw = file_get_contents( 'php://input' );
		if ( ! is_string( $raw ) || strlen( $raw ) > 8192 ) {
			self::done( 413 );
		}
		$d = json_decode( $raw, true );
		if ( ! is_array( $d ) ) {
			self::done( 400 );
		}
		if ( ! self::allow( 'lead', 60, HOUR_IN_SECONDS ) ) {
			self::done( 429 );
		}

		$stage = isset( $d['stage'] ) ? sanitize_key( (string) $d['stage'] ) : '';
		$stage = str_replace( '_', '-', $stage );
		$sid   = isset( $d['sid'] ) ? preg_replace( '/[^a-zA-Z0-9]/', '', (string) $d['sid'] ) : '';
		if ( ! in_array( $stage, self::STAGES, true ) || strlen( $sid ) < 8 || strlen( $sid ) > 64 ) {
			self::done( 400 );
		}

		$f = array(
			'website' => self::valid_host( isset( $d['website'] ) ? $d['website'] : '' ),
			'phone'   => self::clean_phone( isset( $d['phone'] ) ? $d['phone'] : '' ),
			'contact' => self::clean_phone( isset( $d['contact'] ) ? $d['contact'] : '' ),
			'email'   => self::clean_email( isset( $d['email'] ) ? $d['email'] : '' ),
			'name'    => self::clean_name( isset( $d['name'] ) ? $d['name'] : '' ),
			'company' => self::clean_company( isset( $d['company'] ) ? $d['company'] : '' ),
			'service' => isset( $d['service'] ) ? sanitize_text_field( mb_substr( (string) $d['service'], 0, 80 ) ) : '',
			'message' => isset( $d['message'] ) ? sanitize_textarea_field( mb_substr( (string) $d['message'], 0, 1000 ) ) : '',
			'score'   => isset( $d['score'] ) && is_numeric( $d['score'] ) ? max( 0, min( 100, (int) $d['score'] ) ) : '',
			'source'  => isset( $d['source'] ) ? sanitize_key( (string) $d['source'] ) : 'hero-scan',
		);

		// A request for contact needs a way to contact the person.
		if ( in_array( $stage, self::NOTIFY, true ) && '' === $f['phone'] && '' === $f['email'] ) {
			self::done( 422, 'contact' );
		}

		$existing = get_posts(
			array(
				'post_type'      => self::CPT,
				'post_status'    => 'any',
				'meta_key'       => '_wu_sid',
				'meta_value'     => $sid,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$post_id = $existing ? (int) $existing[0] : 0;

		if ( ! $post_id ) {
			if ( ! self::allow( 'newlead', 20, HOUR_IN_SECONDS ) ) {
				self::done( 429 );
			}
			$post_id = wp_insert_post(
				array(
					'post_type'   => self::CPT,
					'post_status' => 'publish',
					'post_title'  => $f['website'] ? $f['website'] : 'Visitor ' . substr( $sid, 0, 6 ),
				)
			);
			if ( ! $post_id || is_wp_error( $post_id ) ) {
				self::done( 500 );
			}
			update_post_meta( $post_id, '_wu_sid', $sid );
			update_post_meta( $post_id, '_wu_ip', wp_hash( self::ip() ) );
			$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( mb_substr( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ), 0, 160 ) ) : '';
			update_post_meta( $post_id, '_wu_ua', $ua );
		}

		foreach ( $f as $k => $v ) {
			if ( '' !== $v ) {
				update_post_meta( $post_id, '_wu_' . $k, $v );
			}
		}
		if ( $f['website'] && 0 === strpos( (string) get_the_title( $post_id ), 'Visitor ' ) ) {
			wp_update_post( array( 'ID' => $post_id, 'post_title' => $f['website'] ) );
		}

		$stages = get_post_meta( $post_id, '_wu_stages', true );
		$stages = is_array( $stages ) ? $stages : array();
		$seen   = false;
		foreach ( $stages as $s ) {
			if ( isset( $s[0] ) && $s[0] === $stage ) {
				$seen = true;
				break;
			}
		}
		$stages[] = array( $stage, time() );
		update_post_meta( $post_id, '_wu_stages', array_slice( $stages, -40 ) );
		update_post_meta( $post_id, '_wu_stage', $stage );

		if ( ! $seen && in_array( $stage, self::NOTIFY, true ) ) {
			self::notify( $post_id, $stage );
			if ( function_exists( 'wiseup_landing_mirror_lead' ) ) wiseup_landing_mirror_lead( self::lead_data( $post_id ), $stage );
		}
		self::done( 200 );
	}

	private static function lead_data( $post_id ) {
		$out = array( 'id' => $post_id, 'stage' => get_post_meta( $post_id, '_wu_stage', true ), 'date' => get_the_date( 'c', $post_id ) );
		foreach ( array( 'website', 'name', 'company', 'phone', 'contact', 'email', 'service', 'message', 'score', 'source' ) as $k ) {
			$out[ $k ] = (string) get_post_meta( $post_id, '_wu_' . $k, true );
		}
		return $out;
	}

	private static function notify( $post_id, $stage ) {
		$s = self::settings();
		$L = self::lead_data( $post_id );
		if ( '1' === (string) $s['notify'] && is_email( $s['email'] ) ) {
			$who   = $L['name'] ? $L['name'] : ( $L['phone'] ? $L['phone'] : $L['email'] );
			$lines = array();
			foreach ( array( 'name' => 'Name', 'company' => 'Company', 'phone' => 'WhatsApp', 'contact' => 'Phone', 'email' => 'Email', 'website' => 'Website', 'score' => 'Scan score', 'service' => 'Service', 'message' => 'Message' ) as $k => $label ) {
				if ( '' !== $L[ $k ] ) {
					$lines[] = $label . ': ' . $L[ $k ];
				}
			}
			$body = "New lead from the SEO landing page.\n\n" . implode( "\n", $lines ) . "\n\nStep: " . $stage . "\nOpen in dashboard: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . "\n";
			wp_mail( $s['email'], 'New SEO lead: ' . wp_strip_all_tags( $who ) . ( $L['website'] ? ' (' . $L['website'] . ')' : '' ), $body );
		}
		if ( ! empty( $s['webhook'] ) && wp_http_validate_url( $s['webhook'] ) ) {
			wp_remote_post(
				$s['webhook'],
				array(
					'timeout'  => 5,
					'blocking' => false,
					'headers'  => array( 'Content-Type' => 'application/json' ),
					'body'     => wp_json_encode( array_merge( $L, array( 'event' => $stage ) ) ),
				)
			);
		}
	}

	/* ------------------------------------------------------------------ AJAX: sitemap reader */

	public static function ajax_sitemap() {
		nocache_headers();
		if ( ! self::same_origin() || ! self::allow( 'sitemap', 40, 10 * MINUTE_IN_SECONDS ) ) {
			status_header( 429 );
			exit;
		}
		$url   = isset( $_GET['url'] ) ? esc_url_raw( wp_unslash( $_GET['url'] ) ) : '';
		$parts = wp_parse_url( $url );
		$host  = ( $parts && ! empty( $parts['host'] ) ) ? self::valid_host( $parts['host'] ) : '';
		$path  = ( $parts && isset( $parts['path'] ) ) ? strtolower( $parts['path'] ) : '';
		$ok    = $host
			&& isset( $parts['scheme'] ) && in_array( $parts['scheme'], array( 'http', 'https' ), true )
			&& empty( $parts['port'] ) && empty( $parts['user'] )
			&& ( '/robots.txt' === $path || preg_match( '#(sitemap[^/]*\.xml|\.xml)$#', $path ) );
		if ( ! $ok ) {
			status_header( 400 );
			exit;
		}
		// Refuse hosts that resolve to private or reserved addresses.
		$ip = gethostbyname( $host );
		if ( $ip === $host || ! filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
			status_header( 403 );
			exit;
		}
		$cache = 'wu_sm_' . md5( $url );
		$body  = get_transient( $cache );
		if ( false === $body ) {
			$res = wp_safe_remote_get(
				$url,
				array(
					'timeout'             => 6,
					'redirection'         => 3,
					'limit_response_size' => 5 * MB_IN_BYTES,
					'user-agent'          => 'WiseUpScanner/1.0 (+' . home_url() . ')',
					'reject_unsafe_urls'  => true,
				)
			);
			if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
				set_transient( $cache, '', 10 * MINUTE_IN_SECONDS );
				status_header( 404 );
				exit;
			}
			$body = (string) wp_remote_retrieve_body( $res );
			set_transient( $cache, $body, HOUR_IN_SECONDS );
		}
		if ( '' === $body ) {
			status_header( 404 );
			exit;
		}
		header( 'Content-Type: text/plain; charset=utf-8' );
		header( 'X-Content-Type-Options: nosniff' );
		echo $body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- plain text, read as data by the scanner.
		exit;
	}

	/* ------------------------------------------------------------------ admin UI */

	public static function columns( $cols ) {
		return array(
			'cb'        => isset( $cols['cb'] ) ? $cols['cb'] : '',
			'title'     => 'Website',
			'wu_name'   => 'Name',
			'wu_phone'  => 'WhatsApp',
			'wu_email'  => 'Email',
			'wu_stage'  => 'Latest step',
			'wu_source' => 'Page',
			'wu_score'  => 'Score',
			'date'      => 'Date',
		);
	}

	public static function column_content( $col, $post_id ) {
		$map = array( 'wu_name' => 'name', 'wu_phone' => 'phone', 'wu_email' => 'email', 'wu_stage' => 'stage', 'wu_source' => 'source', 'wu_score' => 'score' );
		if ( ! isset( $map[ $col ] ) ) {
			return;
		}
		$v = (string) get_post_meta( $post_id, '_wu_' . $map[ $col ], true );
		if ( 'wu_phone' === $col && $v ) {
			echo '<a href="' . esc_url( 'https://wa.me/' . ltrim( $v, '+' ) ) . '" target="_blank" rel="noopener">' . esc_html( $v ) . '</a>';
			return;
		}
		echo esc_html( '' !== $v ? $v : '-' );
	}

	public static function meta_box() {
		add_meta_box( 'wu_lead_details', 'Lead details', array( __CLASS__, 'render_box' ), self::CPT, 'normal', 'high' );
	}

	public static function render_box( $post ) {
		$L = self::lead_data( $post->ID );
		echo '<table class="widefat striped" style="max-width:720px"><tbody>';
		foreach ( array( 'website' => 'Website', 'name' => 'Name', 'company' => 'Company', 'phone' => 'WhatsApp', 'contact' => 'Phone', 'email' => 'Email', 'service' => 'Service', 'message' => 'Message', 'score' => 'Scan score', 'source' => 'Source' ) as $k => $label ) {
			echo '<tr><th style="width:140px">' . esc_html( $label ) . '</th><td>' . ( '' !== $L[ $k ] ? nl2br( esc_html( $L[ $k ] ) ) : '-' ) . '</td></tr>';
		}
		echo '</tbody></table><h4>Steps</h4><ol>';
		$stages = get_post_meta( $post->ID, '_wu_stages', true );
		foreach ( is_array( $stages ) ? $stages : array() as $s ) {
			echo '<li>' . esc_html( $s[0] ) . ' &middot; ' . esc_html( wp_date( 'j M Y, H:i:s', (int) $s[1] ) ) . '</li>';
		}
		echo '</ol>';
	}

	public static function admin_menu() {
		add_submenu_page( 'edit.php?post_type=' . self::CPT, 'Lead settings', 'Settings', 'manage_options', 'wiseup-lead-settings', array( __CLASS__, 'settings_page' ) );
	}

	public static function register_settings() {
		register_setting( 'wiseup_lead', self::OPTION, array( 'sanitize_callback' => array( __CLASS__, 'sanitize_settings' ) ) );
	}

	public static function sanitize_settings( $in ) {
		$in = is_array( $in ) ? $in : array();
		return array(
			'email'   => isset( $in['email'] ) && is_email( $in['email'] ) ? sanitize_email( $in['email'] ) : get_option( 'admin_email' ),
			'webhook' => isset( $in['webhook'] ) && '' !== $in['webhook'] ? esc_url_raw( $in['webhook'] ) : '',
			'notify'  => ! empty( $in['notify'] ) ? '1' : '0',
		);
	}

	public static function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$s = self::settings();
		echo '<div class="wrap"><h1>WiseUp lead settings</h1><form method="post" action="options.php">';
		settings_fields( 'wiseup_lead' );
		echo '<table class="form-table" role="presentation">';
		echo '<tr><th scope="row">Email me new leads</th><td><label><input type="checkbox" name="' . esc_attr( self::OPTION ) . '[notify]" value="1" ' . checked( '1', (string) $s['notify'], false ) . '> Send an email when someone asks for the report or sends a quote request</label></td></tr>';
		echo '<tr><th scope="row"><label for="wu_email">Send to</label></th><td><input id="wu_email" class="regular-text" type="email" name="' . esc_attr( self::OPTION ) . '[email]" value="' . esc_attr( $s['email'] ) . '"></td></tr>';
		echo '<tr><th scope="row"><label for="wu_hook">Webhook URL (optional)</label></th><td><input id="wu_hook" class="large-text" type="url" name="' . esc_attr( self::OPTION ) . '[webhook]" value="' . esc_attr( $s['webhook'] ) . '" placeholder="https://hooks.zapier.com/..."><p class="description">Each lead is sent here as JSON, for Zapier, Make, n8n or a Google Sheets script.</p></td></tr>';
		echo '</table>';
		submit_button();
		echo '</form></div>';
	}

	public static function export_link( $views ) {
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=wiseup_export' ), 'wiseup_export' );
		$views['wu_export'] = '<a href="' . esc_url( $url ) . '">Download CSV</a>';
		return $views;
	}

	public static function export_csv() {
		if ( ! current_user_can( 'edit_posts' ) || ! check_admin_referer( 'wiseup_export' ) ) {
			wp_die( 'Not allowed.' );
		}
		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=wiseup-leads-' . gmdate( 'Y-m-d' ) . '.csv' );
		$out  = fopen( 'php://output', 'w' );
		$cols = array( 'date', 'website', 'name', 'company', 'phone', 'contact', 'email', 'service', 'message', 'score', 'stage', 'source' );
		fputcsv( $out, $cols );
		$ids = get_posts( array( 'post_type' => self::CPT, 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids', 'orderby' => 'date', 'order' => 'DESC' ) );
		foreach ( $ids as $id ) {
			$L   = self::lead_data( $id );
			$row = array();
			foreach ( $cols as $c ) {
				$val = isset( $L[ $c ] ) ? (string) $L[ $c ] : '';
				// stop spreadsheet formula injection
				if ( '' !== $val && in_array( $val[0], array( '=', '+', '-', '@' ), true ) && 'phone' !== $c && 'contact' !== $c ) {
					$val = "'" . $val;
				}
				$row[] = $val;
			}
			fputcsv( $out, $row );
		}
		fclose( $out );
		exit;
	}
}

WiseUp_Lead_Capture::init();
