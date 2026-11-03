<?php
// Deleting the plugin removes its settings and the per-page header/footer choices. Pages keep their content; their
// template reverts to the theme default. The wp_wiseup_leads table (contact-form / lead-popup submissions) is
// deliberately left in place, same as pages — real enquiry data a reinstall should still have, not something to
// lose on an accidental deactivate/delete.
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'wiseup_settings' );
delete_post_meta_by_key( '_wiseup_header' );
delete_post_meta_by_key( '_wiseup_footer' );
