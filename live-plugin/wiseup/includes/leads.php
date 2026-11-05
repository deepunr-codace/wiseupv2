<?php
/**
 * Stored leads: every contact-form / lead-popup submission (includes/enquiry.php) is saved to its own table
 * ({$wpdb->prefix}wiseup_leads), not just emailed — so a dropped email (spam filter, misconfigured SMTP, the
 * Playground/local-dev "no mail server" case) never loses the enquiry. Managed from wp-admin → Wiseup → Leads.
 */
defined( 'ABSPATH' ) || exit;

function wiseup_leads_table() {
	global $wpdb;
	return $wpdb->prefix . 'wiseup_leads';
}

function wiseup_leads_install() {
	global $wpdb;
	$table           = wiseup_leads_table();
	$charset_collate = $wpdb->get_charset_collate();
	$sql             = "CREATE TABLE {$table} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		created_at DATETIME NOT NULL,
		name VARCHAR(190) NOT NULL DEFAULT '',
		email VARCHAR(190) NOT NULL DEFAULT '',
		phone VARCHAR(60) NOT NULL DEFAULT '',
		service VARCHAR(190) NOT NULL DEFAULT '',
		message TEXT NOT NULL,
		page VARCHAR(190) NOT NULL DEFAULT '',
		source VARCHAR(60) NOT NULL DEFAULT '',
		ip VARCHAR(100) NOT NULL DEFAULT '',
		status VARCHAR(20) NOT NULL DEFAULT 'new',
		PRIMARY KEY  (id),
		KEY created_at (created_at),
		KEY status (status)
	) {$charset_collate};";
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}

// Normal path: WordPress's own activation hook (registered in wiseup.php). Safety net: if the plugin was ever
// activated before this table existed, or installed in a way that skipped the hook, create it lazily the first
// time an admin opens wp-admin, instead of the Leads tab just silently showing nothing.
add_action( 'admin_init', function () {
	global $wpdb;
	$table = wiseup_leads_table();
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) !== $table ) { // phpcs:ignore WordPress.DB.DirectDatabaseQuery -- one-off existence check, not a query to cache
		wiseup_leads_install();
	}
} );

/**
 * Saves one submission. Returns the new row's id, or false on failure. Deliberately never throws: a storage
 * failure here must not block the email send in enquiry.php (the visitor should still get through either way).
 */
function wiseup_save_lead( $data ) {
	global $wpdb;
	$row = array(
		'created_at' => current_time( 'mysql' ),
		'name'       => isset( $data['name'] ) ? $data['name'] : '',
		'email'      => isset( $data['email'] ) ? $data['email'] : '',
		'phone'      => isset( $data['phone'] ) ? $data['phone'] : '',
		'service'    => isset( $data['service'] ) ? $data['service'] : '',
		'message'    => isset( $data['message'] ) ? $data['message'] : '',
		'page'       => isset( $data['page'] ) ? $data['page'] : '',
		'source'     => isset( $data['source'] ) ? $data['source'] : '',
		'ip'         => isset( $data['ip'] ) ? $data['ip'] : '',
		'status'     => 'new',
	);
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- the plugin's own table; $wpdb->insert() already parametrizes
	$ok = $wpdb->insert( wiseup_leads_table(), $row );
	return $ok ? $wpdb->insert_id : false;
}

function wiseup_lead_count( $status = null ) {
	global $wpdb;
	$table = wiseup_leads_table();
	if ( $status ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is our own constant, not user input
		return (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE status = %s", $status ) );
	}
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
}

/**
 * Lead sources: the key each form sends as `source` (data-source on the form), and its label in the dashboard and the
 * notification email. Older leads with no source count as Contact.
 */
function wiseup_lead_sources() {
	return array(
		'get-featured' => __( 'Get featured', 'wiseup' ),
		'sponsor'      => __( 'Sponsor', 'wiseup' ),
		'contact'      => __( 'Contact', 'wiseup' ),
		'seo'          => __( 'SEO page', 'wiseup' ),
		'performance'  => __( 'Performance page', 'wiseup' ),
		'social-media' => __( 'Social media page', 'wiseup' ),
		'services'     => __( 'Services page', 'wiseup' ),
		'wiseup-tv'    => __( 'WiseUp TV page', 'wiseup' ),
		'wiseup-studio' => __( 'WiseUp Studio page', 'wiseup' ),
	);
}

function wiseup_lead_source_label( $source ) {
	$all = wiseup_lead_sources();
	if ( isset( $all[ $source ] ) ) return $all[ $source ];
	return $source ? ucwords( str_replace( '-', ' ', $source ) ) : $all['contact'];
}

/** WHERE clause for the leads table, filtered by source and/or status ('' for none). */
function wiseup_leads_where( $source = '', $status = '' ) {
	global $wpdb;
	$clauses = array();
	if ( $source ) {
		if ( 'contact' === $source ) {
			$clauses[] = $wpdb->prepare( "(source = %s OR source = '')", 'contact' );
		} else {
			$clauses[] = $wpdb->prepare( 'source = %s', $source );
		}
	}
	if ( $status ) $clauses[] = $wpdb->prepare( 'status = %s', $status );
	return $clauses ? 'WHERE ' . implode( ' AND ', $clauses ) : '';
}

/** Number of leads for a source (and optionally a status), for the dashboard's counts. */
function wiseup_lead_count_for( $source = '', $status = '' ) {
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is our own; the filters are prepared
	return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . wiseup_leads_table() . ' ' . wiseup_leads_where( $source, $status ) );
}

/** Leads received in the last seven days (site time), for the dashboard summary. */
function wiseup_lead_count_week() {
	global $wpdb;
	$since = gmdate( 'Y-m-d H:i:s', current_time( 'timestamp' ) - 7 * DAY_IN_SECONDS );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is our own; the date is prepared
	return (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . wiseup_leads_table() . ' WHERE created_at >= %s', $since ) );
}

// ---------- Admin actions: mark read, delete, export ----------
add_action( 'admin_post_wiseup_lead_read', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'Not allowed.', 'wiseup' ) );
	check_admin_referer( 'wiseup_lead_read' );
	global $wpdb;
	$id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- the plugin's own table
	if ( $id ) $wpdb->update( wiseup_leads_table(), array( 'status' => 'read' ), array( 'id' => $id ) );
	$ref = wp_get_referer();
	wp_safe_redirect( $ref ? $ref : admin_url( 'admin.php?page=wiseup&tab=leads' ) );
	exit;
} );

add_action( 'admin_post_wiseup_lead_delete', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'Not allowed.', 'wiseup' ) );
	check_admin_referer( 'wiseup_lead_delete' );
	global $wpdb;
	$id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- the plugin's own table
	if ( $id ) $wpdb->delete( wiseup_leads_table(), array( 'id' => $id ) );
	wp_safe_redirect( admin_url( 'admin.php?page=wiseup&tab=leads' ) );
	exit;
} );

add_action( 'admin_post_wiseup_leads_export', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'Not allowed.', 'wiseup' ) );
	check_admin_referer( 'wiseup_leads_export' );
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- the plugin's own table, admin-only export
	$export_source = isset( $_GET['source'] ) ? sanitize_key( wp_unslash( $_GET['source'] ) ) : '';
	$rows = $wpdb->get_results( 'SELECT created_at, name, email, phone, service, page, source, message FROM ' . wiseup_leads_table() . ' ' . wiseup_leads_where( $export_source ) . ' ORDER BY created_at DESC', ARRAY_A );
	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=wiseup-leads-' . gmdate( 'Y-m-d' ) . '.csv' );
	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array( 'Date', 'Name', 'Email', 'Phone', 'Service', 'Page', 'Source', 'Message' ) );
	foreach ( (array) $rows as $r ) fputcsv( $out, $r );
	fclose( $out );
	exit;
} );
