<?php
/**
 * Enquiry endpoint for the contact form and the lead popup: validates a submission and emails it with wp_mail().
 * The page's script posts here when window.WISEUP_CONTACT is set (includes/render.php); if the request fails it falls
 * back to composing a WhatsApp message, never a fake "sent". Replaces the separate WiseUp Contact Mail plugin, under
 * its own route so the two can't clash while both are active.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', function () {
	register_rest_route( 'wiseup/v1', '/enquiry', array(
		'methods'             => 'POST',
		'callback'            => 'wiseup_enquiry_submit',
		// Anonymous visitors submit the form; the nonce check in the callback gates it.
		'permission_callback' => '__return_true',
	) );
} );

function wiseup_enquiry_submit( WP_REST_Request $request ) {
	$nonce = $request->get_header( 'x-wp-nonce' );
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
		return new WP_Error( 'forbidden', 'Missing or invalid nonce.', array( 'status' => 403 ) );
	}

	// At most one submission per IP every 20 seconds: caps double-submits and naive flooding (the honeypot below
	// handles the common bot).
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'wiseup_enquiry_' . md5( $ip );
	if ( get_transient( $key ) ) {
		return new WP_Error( 'rate_limited', 'Please wait a moment before sending another message.', array( 'status' => 429 ) );
	}
	set_transient( $key, 1, 20 );

	$body = $request->get_json_params();
	if ( ! is_array( $body ) ) {
		return new WP_Error( 'bad_request', 'Expected a JSON body.', array( 'status' => 400 ) );
	}
	// Honeypot: hidden from people, filled by bots. Report success without sending so the bot gets no signal.
	if ( ! empty( $body['hp_website'] ) ) return array( 'ok' => true );

	$field = function ( $name, $textarea = false ) use ( $body ) {
		if ( ! isset( $body[ $name ] ) || ! is_string( $body[ $name ] ) ) return '';
		$value = wp_unslash( $body[ $name ] );
		return $textarea ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
	};
	$name    = $field( 'name' );
	$email   = sanitize_email( $field( 'email' ) );
	$phone   = $field( 'phone' );
	$service = $field( 'service' );
	$message = $field( 'message', true );
	$page    = $field( 'page' );
	$source  = sanitize_key( $field( 'source' ) );

	if ( '' === $name || '' === $message ) {
		return new WP_Error( 'bad_request', 'Name and message are required.', array( 'status' => 400 ) );
	}
	if ( '' !== $field( 'email' ) && ! is_email( $email ) ) {
		return new WP_Error( 'bad_request', 'Email address is not valid.', array( 'status' => 400 ) );
	}

	// Saved to the Leads table before the email send below, so a dropped/misconfigured email never loses the
	// submission — it's always visible in wp-admin → Wiseup → Leads either way.
	wiseup_save_lead( array(
		'name'    => $name,
		'email'   => $email,
		'phone'   => $phone,
		'service' => $service,
		'message' => $message,
		'page'    => $page,
		'source'  => $source,
		'ip'      => $ip,
	) );

	$to = wiseup_opt( 'enquiry_email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );
	$lines = array_filter( array(
		"Form: " . wiseup_lead_source_label( $source ),
		"Name: {$name}",
		$email ? "Email: {$email}" : null,
		$phone ? "Phone: {$phone}" : null,
		$service ? "Service: {$service}" : null,
		$page ? "Page: {$page}" . ( $source ? " ({$source})" : '' ) : null,
		'',
		'Message:',
		$message,
	), function ( $l ) { return null !== $l; } );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) $headers[] = "Reply-To: {$name} <{$email}>";

	/* translators: %s: the visitor's name */
	$subject = sprintf( __( 'New %1$s lead from %2$s (WiseUp site)', 'wiseup' ), wiseup_lead_source_label( $source ), $name );
	if ( ! wp_mail( $to, $subject, implode( "\n", $lines ), $headers ) ) {
		return new WP_Error( 'mail_failed', 'The message could not be sent.', array( 'status' => 500 ) );
	}
	return array( 'ok' => true );
}
