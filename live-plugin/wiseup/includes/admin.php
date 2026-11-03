<?php
/**
 * The Wiseup dashboard (wp-admin → Wiseup): the pages using each template with one-click creation, and the
 * General / Header / Footer settings. All settings live in one option; each tab saves only its own fields.
 */
defined( 'ABSPATH' ) || exit;

/** Fields per settings tab: key => [ type, label, help ]. Types: select:<a|b>, check, text, url, email, textarea, social. */
function wiseup_admin_fields() {
	return array(
		'general' => array(
			'default_theme' => array( 'select:dark|light', __( 'Default mode', 'wiseup' ), __( "What first-time visitors see. Once someone uses the sun/moon toggle, their own choice is remembered.", 'wiseup' ) ),
			'header_source' => array( 'select:plugin|theme|none', __( 'Header', 'wiseup' ), __( "Which header WiseUp pages use: WiseUp's own, the theme's, or none. Each page can override this (\"WiseUp header & footer\" box on the page's edit screen).", 'wiseup' ) ),
			'footer_source' => array( 'select:plugin|theme|none', __( 'Footer', 'wiseup' ), __( 'Same for the footer. While a page uses neither the theme header nor the theme footer, no theme styles are loaded on it at all.', 'wiseup' ) ),
			'lead_popup'    => array( 'check', __( 'Lead popup', 'wiseup' ), __( 'The floating "Get a free plan" button and its enquiry form.', 'wiseup' ) ),
			'enquiry_email' => array( 'email', __( 'Email new leads to', 'wiseup' ), __( 'Every new lead (Get featured, Sponsor and contact forms) is emailed here. Empty = the site admin email.', 'wiseup' ) ),
		),
		'header'  => array(
			'theme_toggle'      => array( 'check', __( 'Dark/light toggle', 'wiseup' ), __( 'Show the sun/moon button in the header.', 'wiseup' ) ),
			'logo'              => array( 'url', __( 'Logo', 'wiseup' ), __( 'Image URL (e.g. from the Media Library). Empty = the bundled WiseUp mark. White artwork reads best: the header inverts it in light mode.', 'wiseup' ) ),
			'podcast_logo'      => array( 'url', __( 'Podcast page logo', 'wiseup' ), __( 'Empty = the bundled WiseUp Podcast mark.', 'wiseup' ) ),
			'cta_label'         => array( 'text', __( 'Button label', 'wiseup' ), __( 'The header button (and the mobile menu button).', 'wiseup' ) ),
			'cta_url'           => array( 'url', __( 'Button link', 'wiseup' ), __( "Empty = each page's own target (the contact form).", 'wiseup' ) ),
			'podcast_subscribe' => array( 'check', __( 'Podcast: Subscribe button', 'wiseup' ), __( 'On the podcast page, show the YouTube Subscribe pill instead of the button above.', 'wiseup' ) ),
			'subscribe_url'     => array( 'url', __( 'Subscribe link', 'wiseup' ), __( 'Also used by the footer channel card.', 'wiseup' ) ),
			'subscribe_count'   => array( 'text', __( 'Subscriber count', 'wiseup' ), __( 'Shown on the pill, e.g. 91K. Empty hides it.', 'wiseup' ) ),
		),
		'footer'  => array(
			'footer_tagline'      => array( 'textarea', __( 'Tagline', 'wiseup' ), '' ),
			'footer_h_quick'      => array( 'text', __( 'First links heading', 'wiseup' ), __( 'Links: assign a menu to "WiseUp: footer Quick Links" under Appearance → Menus (or the built-in links are used).', 'wiseup' ) ),
			'footer_h_useful'     => array( 'text', __( 'Second links heading', 'wiseup' ), __( 'Menu location "WiseUp: footer Useful Links".', 'wiseup' ) ),
			'footer_h_follow'     => array( 'text', __( 'Social heading', 'wiseup' ), '' ),
			'follow_text'         => array( 'textarea', __( 'Social text', 'wiseup' ), __( 'Under the social heading, on every page except the podcast page. Hidden on phones.', 'wiseup' ) ),
			'social'              => array( 'social', __( 'Social links', 'wiseup' ), __( 'Every page except the podcast page. Empty hides the icon.', 'wiseup' ) ),
			'follow_text_podcast' => array( 'textarea', __( 'Podcast: social text', 'wiseup' ), '' ),
			'social_podcast'      => array( 'social', __( 'Podcast: social links', 'wiseup' ), __( "The podcast page's own set.", 'wiseup' ) ),
			'channel_card'        => array( 'check', __( 'Podcast: channel card', 'wiseup' ), __( 'The YouTube channel card with a Subscribe button, under the tagline.', 'wiseup' ) ),
			'channel_name'        => array( 'text', __( 'Channel name', 'wiseup' ), '' ),
			'channel_handle'      => array( 'text', __( 'Channel handle', 'wiseup' ), '' ),
			'wordmark'            => array( 'check', __( 'Particle wordmark', 'wiseup' ), __( 'The interactive "wiseup" particles and the dotted band at the bottom.', 'wiseup' ) ),
			'copyright'           => array( 'text', __( 'Copyright name', 'wiseup' ), __( 'Shown as © year name.', 'wiseup' ) ),
			'credit_name'         => array( 'text', __( 'Credit', 'wiseup' ), __( 'Shown as "Crafted by …". Empty hides it.', 'wiseup' ) ),
			'credit_url'          => array( 'url', __( 'Credit link', 'wiseup' ), __( 'Optional.', 'wiseup' ) ),
		),
	);
}

function wiseup_choice_label( $value ) {
	$labels = array(
		'dark' => __( 'Dark', 'wiseup' ), 'light' => __( 'Light', 'wiseup' ),
		'plugin' => __( 'WiseUp', 'wiseup' ), 'theme' => __( "Theme's own", 'wiseup' ), 'none' => __( 'None', 'wiseup' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : $value;
}

add_action( 'admin_menu', function () {
	$icon = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><g fill="#a7aaad"><circle cx="3" cy="6" r="1.6"/><circle cx="5.5" cy="11" r="1.6"/><circle cx="8" cy="16" r="1.6"/><circle cx="10" cy="10" r="1.6"/><circle cx="12" cy="16" r="1.6"/><circle cx="14.5" cy="11" r="1.6"/><circle cx="17" cy="6" r="1.6"/></g></svg>' );
	add_menu_page( 'Wiseup', 'Wiseup', 'manage_options', 'wiseup', 'wiseup_admin_page', $icon, 59 );
} );

add_action( 'admin_init', function () {
	register_setting( 'wiseup', WISEUP_OPTION, array( 'type' => 'array', 'sanitize_callback' => 'wiseup_sanitize' ) );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( 'toplevel_page_wiseup' === $hook ) wp_enqueue_style( 'wiseup-admin', WISEUP_URL . 'assets/css/admin.css', array(), WISEUP_VERSION );
} );

/** Saves only the posted tab's fields over the current settings (unchecked boxes aren't posted, so they become 0). */
function wiseup_sanitize( $input ) {
	$current = wiseup_settings( true );
	$fields  = wiseup_admin_fields();
	$tab     = isset( $input['_tab'] ) && isset( $fields[ $input['_tab'] ] ) ? $input['_tab'] : null;
	if ( ! $tab ) {
		// WordPress runs this twice when the option is first created; the second pass gets the first pass's
		// already-clean full array (no _tab), which must be kept, not replaced by the not-yet-saved current values.
		return is_array( $input ) && isset( $input['default_theme'] ) ? array_replace_recursive( wiseup_defaults(), $input ) : $current;
	}
	foreach ( $fields[ $tab ] as $key => $f ) {
		$type  = $f[0];
		$value = isset( $input[ $key ] ) ? $input[ $key ] : '';
		if ( 'check' === $type ) {
			$current[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
		} elseif ( 0 === strpos( $type, 'select:' ) ) {
			$allowed = explode( '|', substr( $type, 7 ) );
			$current[ $key ] = in_array( $value, $allowed, true ) ? $value : $allowed[0];
		} elseif ( 'url' === $type ) {
			$current[ $key ] = esc_url_raw( trim( $value ) );
		} elseif ( 'email' === $type ) {
			$current[ $key ] = sanitize_email( $value );
		} elseif ( 'textarea' === $type ) {
			$current[ $key ] = sanitize_textarea_field( $value );
		} elseif ( 'social' === $type ) {
			foreach ( array_keys( wiseup_networks() ) as $network ) {
				$v = isset( $value[ $network ] ) ? trim( $value[ $network ] ) : '';
				$current[ $key ][ $network ] = 'email' === $network ? sanitize_email( preg_replace( '/^mailto:/i', '', $v ) ) : esc_url_raw( $v );
			}
		} else {
			$current[ $key ] = sanitize_text_field( $value );
		}
	}
	return $current;
}

// ---------- Create a page from a template ----------
add_action( 'admin_post_wiseup_create_page', function () {
	if ( ! current_user_can( 'publish_pages' ) ) wp_die( esc_html__( 'Not allowed.', 'wiseup' ) );
	check_admin_referer( 'wiseup_create_page' );
	$key = isset( $_GET['template'] ) ? sanitize_key( wp_unslash( $_GET['template'] ) ) : '';
	$templates = wiseup_templates();
	if ( ! isset( $templates[ $key ] ) ) wp_die( esc_html__( 'Unknown template.', 'wiseup' ) );
	$titles = array( 'home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'podcast' => 'Podcast' );
	$slug = $templates[ $key ][0];
	$id = wp_insert_post( array(
		'post_type'   => 'page',
		'post_status' => 'draft',
		'post_title'  => $titles[ $slug ],
		'post_name'   => $slug,
		'meta_input'  => array( '_wp_page_template' => $key ),
	), true );
	if ( is_wp_error( $id ) ) wp_die( esc_html( $id->get_error_message() ) );
	wp_safe_redirect( admin_url( 'post.php?post=' . $id . '&action=edit' ) );
	exit;
} );

// ---------- The page ----------
function wiseup_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$new_leads = wiseup_lead_count( 'new' );
	$leads_label = $new_leads ? sprintf( '%s (%d)', __( 'Leads', 'wiseup' ), $new_leads ) : __( 'Leads', 'wiseup' );
	$tabs = array( 'dashboard' => __( 'Dashboard', 'wiseup' ), 'leads' => $leads_label, 'general' => __( 'General', 'wiseup' ), 'header' => __( 'Header', 'wiseup' ), 'footer' => __( 'Footer', 'wiseup' ) );
	$tab  = isset( $_GET['tab'] ) && isset( $tabs[ sanitize_key( $_GET['tab'] ) ] ) ? sanitize_key( $_GET['tab'] ) : 'dashboard'; // phpcs:ignore WordPress.Security.NonceVerification -- navigation only
	?>
	<div class="wrap wiseup-admin">
		<h1 class="wiseup-admin__title"><span class="wiseup-admin__mark" aria-hidden="true"></span>Wiseup <span class="wiseup-admin__by"><?php esc_html_e( 'by Axilume', 'wiseup' ); ?> · v<?php echo esc_html( WISEUP_VERSION ); ?></span></h1>
		<nav class="nav-tab-wrapper">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<a class="nav-tab<?php echo $tab === $key ? ' nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=wiseup&tab=' . $key ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>
		<?php settings_errors(); ?>
		<?php
		if ( 'dashboard' === $tab ) {
			wiseup_admin_dashboard();
		} elseif ( 'leads' === $tab ) {
			wiseup_admin_leads();
		} else {
			wiseup_admin_form( $tab );
		}
		?>
	</div>
	<?php
}

// ---------- Leads: every contact-form / lead-popup submission (includes/leads.php stores them) ----------
function wiseup_admin_leads() {
	global $wpdb;
	$table    = wiseup_leads_table();
	$sources  = wiseup_lead_sources();
	$source   = isset( $_GET['source'] ) ? sanitize_key( wp_unslash( $_GET['source'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- filtering only
	if ( ! isset( $sources[ $source ] ) ) $source = '';
	$base     = admin_url( 'admin.php?page=wiseup&tab=leads' );
	$per_page = 50;
	$paged    = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1; // phpcs:ignore WordPress.Security.NonceVerification -- pagination only
	$offset   = ( $paged - 1 ) * $per_page;
	$total    = wiseup_lead_count_for( $source );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is our own; the filter and paging are prepared
	$leads    = $wpdb->get_results( 'SELECT * FROM ' . $table . ' ' . wiseup_leads_where( $source ) . $wpdb->prepare( ' ORDER BY created_at DESC LIMIT %d OFFSET %d', $per_page, $offset ) );
	$export   = wp_nonce_url( admin_url( 'admin-post.php?action=wiseup_leads_export' . ( $source ? '&source=' . $source : '' ) ), 'wiseup_leads_export' );
	?>
	<div class="wiseup-leadcards">
		<div><strong><?php echo (int) wiseup_lead_count_for(); ?></strong><span><?php esc_html_e( 'Total leads', 'wiseup' ); ?></span></div>
		<div><strong><?php echo (int) wiseup_lead_count_for( '', 'new' ); ?></strong><span><?php esc_html_e( 'Unread', 'wiseup' ); ?></span></div>
		<div><strong><?php echo (int) wiseup_lead_count_week(); ?></strong><span><?php esc_html_e( 'Last 7 days', 'wiseup' ); ?></span></div>
	</div>

	<nav class="wiseup-leadtabs" aria-label="<?php esc_attr_e( 'Lead sources', 'wiseup' ); ?>">
		<a class="<?php echo '' === $source ? 'is-active' : ''; ?>" href="<?php echo esc_url( $base ); ?>">
			<?php esc_html_e( 'All', 'wiseup' ); ?> <span><?php echo (int) wiseup_lead_count_for(); ?></span>
		</a>
		<?php foreach ( $sources as $key => $label ) :
			$unread = wiseup_lead_count_for( $key, 'new' );
			?>
			<a class="<?php echo $source === $key ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'source', $key, $base ) ); ?>">
				<?php echo esc_html( $label ); ?> <span><?php echo (int) wiseup_lead_count_for( $key ); ?></span>
				<?php if ( $unread ) : ?><em><?php echo (int) $unread; ?> <?php esc_html_e( 'new', 'wiseup' ); ?></em><?php endif; ?>
			</a>
		<?php endforeach; ?>
	</nav>

	<p class="wiseup-admin__lead">
		<?php
		printf(
			/* translators: %d: number of leads in the current view */
			esc_html( _n( '%d lead in this view. Each one is saved here whether or not the email went out.', '%d leads in this view. Each one is saved here whether or not the email went out.', $total, 'wiseup' ) ),
			(int) $total
		);
		?>
		<a class="button" style="margin-left: 8px;" href="<?php echo esc_url( $export ); ?>"><?php esc_html_e( 'Export CSV', 'wiseup' ); ?></a>
	</p>
	<?php if ( ! $leads ) : ?>
		<p class="wiseup-muted"><?php esc_html_e( 'No leads here yet.', 'wiseup' ); ?></p>
	<?php else : ?>
		<table class="widefat striped wiseup-leads">
			<thead><tr>
				<th><?php esc_html_e( 'Date', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Form', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Name', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Contact', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Service', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Message', 'wiseup' ); ?></th>
				<th><?php esc_html_e( 'Page', 'wiseup' ); ?></th>
				<th></th>
			</tr></thead>
			<tbody>
				<?php foreach ( $leads as $l ) :
					$read_url   = wp_nonce_url( admin_url( 'admin-post.php?action=wiseup_lead_read&id=' . $l->id ), 'wiseup_lead_read' );
					$delete_url = wp_nonce_url( admin_url( 'admin-post.php?action=wiseup_lead_delete&id=' . $l->id ), 'wiseup_lead_delete' );
					?>
					<tr<?php echo 'new' === $l->status ? ' class="wiseup-lead--new"' : ''; ?>>
						<td><?php echo esc_html( mysql2date( 'M j, Y g:ia', $l->created_at ) ); ?></td>
						<td><span class="wiseup-lead__form"><?php echo esc_html( wiseup_lead_source_label( $l->source ) ); ?></span></td>
						<td><strong><?php echo esc_html( $l->name ); ?></strong></td>
						<td>
							<?php if ( $l->email ) : ?><a href="mailto:<?php echo esc_attr( $l->email ); ?>"><?php echo esc_html( $l->email ); ?></a><br><?php endif; ?>
							<?php echo esc_html( $l->phone ); ?>
						</td>
						<td><?php echo esc_html( $l->service ); ?></td>
						<td><details><summary><?php esc_html_e( 'View', 'wiseup' ); ?></summary><p><?php echo nl2br( esc_html( $l->message ) ); ?></p></details></td>
						<td class="wiseup-muted"><?php echo esc_html( $l->page ); ?></td>
						<td class="wiseup-lead__actions">
							<?php if ( 'new' === $l->status ) : ?><a href="<?php echo esc_url( $read_url ); ?>"><?php esc_html_e( 'Mark read', 'wiseup' ); ?></a> · <?php endif; ?>
							<a href="<?php echo esc_url( $delete_url ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Delete this lead?', 'wiseup' ) ); ?>');"><?php esc_html_e( 'Delete', 'wiseup' ); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ( $total > $per_page ) : ?>
			<p class="wiseup-admin__pager">
				<?php
				echo wp_kses_post( paginate_links( array(
					'base'    => add_query_arg( 'paged', '%#%' ),
					'format'  => '',
					'current' => $paged,
					'total'   => (int) ceil( $total / $per_page ),
				) ) );
				?>
			</p>
		<?php endif; ?>
	<?php endif; ?>
	<?php
}

function wiseup_admin_dashboard() {
	$stale = array();
	foreach ( array( 'home', 'about', 'contact', 'podcast' ) as $s ) {
		if ( locate_template( 'template-wiseup-' . $s . '.php' ) ) $stale[] = 'template-wiseup-' . $s . '.php';
	}
	?>
	<?php if ( $stale ) : ?>
		<div class="notice notice-warning inline"><p>
			<?php esc_html_e( 'The theme still contains the older copy-in WiseUp templates. Pages should use the "WiseUp: …" templates from this plugin; once they do, delete these files (and the theme\'s wiseup-assets folder):', 'wiseup' ); ?>
			<code><?php echo esc_html( implode( ', ', $stale ) ); ?></code>
		</p></div>
	<?php endif; ?>
	<p class="wiseup-admin__lead"><?php esc_html_e( 'Each WiseUp page is a normal WordPress page with one of these templates (Page → Template). They render entirely from this plugin, with their own header, footer and styles, independent of the theme.', 'wiseup' ); ?></p>
	<div class="wiseup-cards">
		<?php foreach ( wiseup_templates() as $key => $t ) :
			$pages = get_posts( array( 'post_type' => 'page', 'post_status' => array( 'publish', 'draft', 'private', 'pending' ), 'numberposts' => 20, 'meta_key' => '_wp_page_template', 'meta_value' => $key ) ); // phpcs:ignore WordPress.DB.SlowDBQuery -- admin only, small
			$create = wp_nonce_url( admin_url( 'admin-post.php?action=wiseup_create_page&template=' . $key ), 'wiseup_create_page' );
			?>
			<div class="wiseup-card">
				<h2><?php echo esc_html( $t[1] ); ?></h2>
				<?php if ( $pages ) : ?>
					<ul>
						<?php foreach ( $pages as $p ) : ?>
							<li>
								<strong><?php echo esc_html( get_the_title( $p ) ); ?></strong>
								<span class="wiseup-status wiseup-status--<?php echo esc_attr( $p->post_status ); ?>"><?php echo esc_html( $p->post_status ); ?></span>
								<?php if ( (int) get_option( 'page_on_front' ) === $p->ID ) : ?><span class="wiseup-status"><?php esc_html_e( 'homepage', 'wiseup' ); ?></span><?php endif; ?>
								<br><a href="<?php echo esc_url( get_edit_post_link( $p ) ); ?>"><?php esc_html_e( 'Edit', 'wiseup' ); ?></a> · <a href="<?php echo esc_url( get_permalink( $p ) ); ?>" target="_blank"><?php esc_html_e( 'View', 'wiseup' ); ?></a>
								<span class="wiseup-muted"> · <?php echo esc_html( sprintf( '%s %s / %s %s', __( 'Header:', 'wiseup' ), wiseup_choice_label( wiseup_part_source( 'header', $p->ID ) ), __( 'Footer:', 'wiseup' ), wiseup_choice_label( wiseup_part_source( 'footer', $p->ID ) ) ) ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="wiseup-muted"><?php esc_html_e( 'No page uses this template yet.', 'wiseup' ); ?></p>
				<?php endif; ?>
				<a class="button" href="<?php echo esc_url( $create ); ?>"><?php esc_html_e( 'Create page', 'wiseup' ); ?></a>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="wiseup-muted"><?php esc_html_e( 'Links inside the pages assume the site structure of wiseup.in: Home as the homepage (Settings → Reading), About at /about/, Contact at /contact/, Podcast at /podcast/.', 'wiseup' ); ?></p>
	<?php
}

function wiseup_admin_form( $tab ) {
	$s = wiseup_settings();
	$name = function ( $key, $sub = null ) { return WISEUP_OPTION . '[' . $key . ']' . ( $sub ? '[' . $sub . ']' : '' ); };
	?>
	<form method="post" action="options.php" class="wiseup-form">
		<?php settings_fields( 'wiseup' ); ?>
		<input type="hidden" name="<?php echo esc_attr( $name( '_tab' ) ); ?>" value="<?php echo esc_attr( $tab ); ?>">
		<table class="form-table" role="presentation">
			<?php foreach ( wiseup_admin_fields()[ $tab ] as $key => $f ) :
				list( $type, $label, $help ) = $f;
				$id = 'wiseup-' . $key;
				?>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
					<td>
						<?php if ( 'check' === $type ) : ?>
							<label><input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name( $key ) ); ?>" value="1" <?php checked( ! empty( $s[ $key ] ) ); ?>> <?php esc_html_e( 'On', 'wiseup' ); ?></label>
						<?php elseif ( 0 === strpos( $type, 'select:' ) ) : ?>
							<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name( $key ) ); ?>">
								<?php foreach ( explode( '|', substr( $type, 7 ) ) as $v ) : ?>
									<option value="<?php echo esc_attr( $v ); ?>" <?php selected( $s[ $key ], $v ); ?>><?php echo esc_html( wiseup_choice_label( $v ) ); ?></option>
								<?php endforeach; ?>
							</select>
						<?php elseif ( 'textarea' === $type ) : ?>
							<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name( $key ) ); ?>" rows="2" class="large-text"><?php echo esc_textarea( $s[ $key ] ); ?></textarea>
						<?php elseif ( 'social' === $type ) : ?>
							<div class="wiseup-social">
								<?php foreach ( wiseup_networks() as $network => $nlabel ) : ?>
									<label><span><?php echo esc_html( $nlabel ); ?></span>
										<input type="<?php echo 'email' === $network ? 'email' : 'url'; ?>" class="regular-text" name="<?php echo esc_attr( $name( $key, $network ) ); ?>" value="<?php echo esc_attr( isset( $s[ $key ][ $network ] ) ? $s[ $key ][ $network ] : '' ); ?>" placeholder="<?php echo 'email' === $network ? 'name@example.com' : 'https://'; ?>">
									</label>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<input type="<?php echo 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name( $key ) ); ?>" value="<?php echo esc_attr( $s[ $key ] ); ?>" class="regular-text">
						<?php endif; ?>
						<?php if ( $help ) : ?><p class="description"><?php echo esc_html( $help ); ?></p><?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php submit_button(); ?>
	</form>
	<?php
}
