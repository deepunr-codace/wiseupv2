<?php
/**
 * Plugin Name:       Wiseup
 * Plugin URI:        https://wiseup.in
 * Description:       WiseUp's own page templates (Home, About, Contact, Podcast) with their own header, footer, settings and enquiry form, independent of the active theme's styles.
 * Version:           1.3.4
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Axilume
 * License:           Proprietary
 * Text Domain:       wiseup
 *
 * Built from the WiseUp Astro site (wiseup-site/): `npm run build && node scripts/build-wp-plugin.mjs` writes this
 * plugin, with its generated page bodies, styles, script and assets, to wiseup-plugin/ and zips it.
 */
defined( 'ABSPATH' ) || exit;

define( 'WISEUP_VERSION', '1.3.4' );
define( 'WISEUP_DIR', plugin_dir_path( __FILE__ ) );
define( 'WISEUP_URL', plugin_dir_url( __FILE__ ) );
define( 'WISEUP_ASSETS', WISEUP_URL . 'assets' );

require WISEUP_DIR . 'includes/settings.php';
require WISEUP_DIR . 'includes/templates.php';
require WISEUP_DIR . 'includes/render.php';
require WISEUP_DIR . 'includes/leads.php';
require WISEUP_DIR . 'includes/enquiry.php';
require WISEUP_DIR . 'includes/landing.php';
require WISEUP_DIR . 'includes/blog.php';
require WISEUP_DIR . 'includes/chrome.php';
require WISEUP_DIR . 'includes/ard.php';
require WISEUP_DIR . 'includes/case-studies.php';
if ( is_admin() ) require WISEUP_DIR . 'includes/admin.php';

register_activation_hook( __FILE__, 'wiseup_leads_install' );

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
	array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=wiseup' ) ) . '">' . esc_html__( 'Dashboard', 'wiseup' ) . '</a>' );
	return $links;
} );
