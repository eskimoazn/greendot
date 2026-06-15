<?php
defined( 'ABSPATH' ) || exit;

class LF_Google_Sheets {

	private string $option_prefix = 'lf_sheets_';
	private string $api_base      = 'https://sheets.googleapis.com/v4/spreadsheets/';

	public function __construct() {
		add_action( 'admin_menu',            [ $this, 'register_settings_page' ] );
		add_action( 'admin_init',            [ $this, 'register_settings' ] );
		add_action( 'admin_post_lf_import_sheets', [ $this, 'handle_manual_import' ] );
		add_action( 'lf_sheets_sync',        [ $this, 'run_sync' ] );
		add_action( 'admin_notices',         [ $this, 'show_notices' ] );

		if ( get_option( $this->option_prefix . 'enable_cron' ) === '1' ) {
			if ( ! wp_next_scheduled( 'lf_sheets_sync' ) ) {
				wp_schedule_event( time(), 'daily', 'lf_sheets_sync' );
			}
		}
	}

	public function register_settings_page(): void {
		add_options_page(
			__( 'Law Firm Data', 'lawfirm-showcase' ),
			__( 'Law Firm Data', 'lawfirm-showcase' ),
			'manage_options',
			'lf-law-firm-data',
			[ $this, 'render_settings_page' ]
		);
	}

	public function register_settings(): void {
		register_setting( 'lf_sheets_settings', $this->option_prefix . 'api_key',         [ 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'lf_sheets_settings', $this->option_prefix . 'spreadsheet_id',  [ 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'lf_sheets_settings', $this->option_prefix . 'range',           [ 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'lf_sheets_settings', $this->option_prefix . 'enable_cron',     [ 'sanitize_callback' => 'sanitize_text_field' ] );
		register_setting( 'lf_sheets_settings', $this->option_prefix . 'post_type',       [ 'sanitize_callback' => 'sanitize_key' ] );
	}

	public function render_settings_page(): void {
		$last_import = get_option( $this->option_prefix . 'last_import' );
		$last_result = get_transient( $this->option_prefix . 'last_result' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Law Firm Data — Google Sheets Import', 'lawfirm-showcase' ); ?></h1>

			<div class="notice notice-info">
				<p><?php esc_html_e( 'Expected spreadsheet columns:', 'lawfirm-showcase' ); ?>
				<code>firm_name, tagline, description, phone, email, address, city, state, zip, website, practice_areas, attorney_1_name, attorney_1_title, attorney_2_name, attorney_2_title, facebook, instagram, linkedin, template_preference</code></p>
			</div>

			<form method="post" action="options.php">
				<?php settings_fields( 'lf_sheets_settings' ); ?>
				<table class="form-table">
					<tr>
						<th><?php esc_html_e( 'Google Sheets API Key', 'lawfirm-showcase' ); ?></th>
						<td><input type="password" name="<?php echo esc_attr( $this->option_prefix . 'api_key' ); ?>" value="<?php echo esc_attr( get_option( $this->option_prefix . 'api_key' ) ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Spreadsheet ID', 'lawfirm-showcase' ); ?></th>
						<td><input type="text" name="<?php echo esc_attr( $this->option_prefix . 'spreadsheet_id' ); ?>" value="<?php echo esc_attr( get_option( $this->option_prefix . 'spreadsheet_id' ) ); ?>" class="regular-text" placeholder="1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgVE2upms"></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Sheet Range', 'lawfirm-showcase' ); ?></th>
						<td><input type="text" name="<?php echo esc_attr( $this->option_prefix . 'range' ); ?>" value="<?php echo esc_attr( get_option( $this->option_prefix . 'range', 'Sheet1!A1:Z1000' ) ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Daily Auto-Sync', 'lawfirm-showcase' ); ?></th>
						<td><label><input type="checkbox" name="<?php echo esc_attr( $this->option_prefix . 'enable_cron' ); ?>" value="1" <?php checked( get_option( $this->option_prefix . 'enable_cron' ), '1' ); ?>> <?php esc_html_e( 'Enable daily automatic import', 'lawfirm-showcase' ); ?></label></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Import as Post Type', 'lawfirm-showcase' ); ?></th>
						<td>
							<select name="<?php echo esc_attr( $this->option_prefix . 'post_type' ); ?>">
								<option value="page" <?php selected( get_option( $this->option_prefix . 'post_type', 'page' ), 'page' ); ?>>Page</option>
								<option value="post" <?php selected( get_option( $this->option_prefix . 'post_type', 'page' ), 'post' ); ?>>Post</option>
							</select>
						</td>
					</tr>
				</table>
				<?php submit_button( __( 'Save Settings', 'lawfirm-showcase' ) ); ?>
			</form>

			<hr>
			<h2><?php esc_html_e( 'Manual Import', 'lawfirm-showcase' ); ?></h2>
			<?php if ( $last_import ) : ?>
				<p><?php printf( esc_html__( 'Last import: %s', 'lawfirm-showcase' ), esc_html( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $last_import ) ) ); ?></p>
			<?php endif; ?>
			<?php if ( $last_result ) : ?>
				<p><?php printf( esc_html__( 'Result: %d imported, %d updated, %d errors', 'lawfirm-showcase' ), $last_result['imported'] ?? 0, $last_result['updated'] ?? 0, count( $last_result['errors'] ?? [] ) ); ?></p>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'lf_import_nonce', 'lf_import_nonce_field' ); ?>
				<input type="hidden" name="action" value="lf_import_sheets">
				<?php submit_button( __( 'Import Now from Google Sheets', 'lawfirm-showcase' ), 'secondary' ); ?>
			</form>
		</div>
		<?php
	}

	public function fetch_data(): array|WP_Error {
		$api_key = get_option( $this->option_prefix . 'api_key' );
		$sheet_id = get_option( $this->option_prefix . 'spreadsheet_id' );
		$range   = get_option( $this->option_prefix . 'range', 'Sheet1!A1:Z1000' );

		if ( ! $api_key || ! $sheet_id ) {
			return new WP_Error( 'lf_sheets_missing_config', __( 'API key or Spreadsheet ID not configured.', 'lawfirm-showcase' ) );
		}

		$url = add_query_arg(
			[ 'key' => $api_key ],
			$this->api_base . rawurlencode( $sheet_id ) . '/values/' . rawurlencode( $range )
		);

		$response = wp_remote_get( $url, [ 'timeout' => 15 ] );
		if ( is_wp_error( $response ) ) return $response;

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code !== 200 ) {
			return new WP_Error( 'lf_sheets_api_error', sprintf( __( 'Google Sheets API returned HTTP %d', 'lawfirm-showcase' ), $code ) );
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );
		return $body['values'] ?? [];
	}

	public function parse_rows( array $raw ): array {
		if ( empty( $raw ) ) return [];
		$headers = array_map( 'strtolower', array_map( 'trim', $raw[0] ) );
		$clients = [];
		for ( $i = 1, $total = count( $raw ); $i < $total; $i++ ) {
			$row    = $raw[ $i ];
			$client = [];
			foreach ( $headers as $col => $header ) {
				$client[ $header ] = $row[ $col ] ?? '';
			}
			if ( ! empty( $client['firm_name'] ) ) {
				$clients[] = $client;
			}
		}
		return $clients;
	}

	public function import_to_posts( array $clients ): array {
		$result    = [ 'imported' => 0, 'updated' => 0, 'errors' => [] ];
		$post_type = get_option( $this->option_prefix . 'post_type', 'page' );

		$valid_templates = array_keys( lf_get_template_map() );

		foreach ( $clients as $client ) {
			$firm_name = sanitize_text_field( $client['firm_name'] ?? '' );
			if ( ! $firm_name ) continue;

			$existing = get_posts( [
				'post_type'      => $post_type,
				'meta_key'       => 'lf_firm_name',
				'meta_value'     => $firm_name,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			] );

			$post_data = [
				'post_type'    => $post_type,
				'post_status'  => 'publish',
				'post_title'   => $firm_name,
				'post_content' => sanitize_textarea_field( $client['description'] ?? '' ),
			];

			if ( $existing ) {
				$post_data['ID'] = $existing[0];
				$post_id         = wp_update_post( $post_data, true );
				if ( ! is_wp_error( $post_id ) ) $result['updated']++;
			} else {
				$post_id = wp_insert_post( $post_data, true );
				if ( ! is_wp_error( $post_id ) ) $result['imported']++;
			}

			if ( is_wp_error( $post_id ) ) {
				$result['errors'][] = $post_id->get_error_message();
				continue;
			}

			$meta_fields = [
				'firm_name', 'tagline', 'description', 'phone', 'email', 'address',
				'city', 'state', 'zip', 'website', 'practice_areas',
				'attorney_1_name', 'attorney_1_title', 'attorney_2_name', 'attorney_2_title',
				'facebook', 'instagram', 'linkedin',
			];
			foreach ( $meta_fields as $field ) {
				if ( isset( $client[ $field ] ) ) {
					update_post_meta( $post_id, 'lf_' . $field, sanitize_text_field( $client[ $field ] ) );
				}
			}

			$tpl = sanitize_key( $client['template_preference'] ?? '' );
			if ( $tpl && in_array( $tpl, $valid_templates, true ) ) {
				update_post_meta( $post_id, '_wp_page_template', "page-templates/template-{$tpl}.php" );
				update_post_meta( $post_id, 'lf_template_preference', $tpl );
			}
		}

		return $result;
	}

	public function handle_manual_import(): void {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'Unauthorized', 'lawfirm-showcase' ) );
		if ( ! isset( $_POST['lf_import_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lf_import_nonce_field'] ) ), 'lf_import_nonce' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'lawfirm-showcase' ) );
		}

		$raw     = $this->fetch_data();
		$redirect = admin_url( 'options-general.php?page=lf-law-firm-data' );

		if ( is_wp_error( $raw ) ) {
			set_transient( $this->option_prefix . 'admin_error', $raw->get_error_message(), 60 );
			wp_safe_redirect( add_query_arg( 'import_error', '1', $redirect ) );
			exit;
		}

		$clients = $this->parse_rows( $raw );
		$result  = $this->import_to_posts( $clients );
		set_transient( $this->option_prefix . 'last_result', $result, HOUR_IN_SECONDS );
		update_option( $this->option_prefix . 'last_import', time() );

		wp_safe_redirect( add_query_arg( 'imported', '1', $redirect ) );
		exit;
	}

	public function run_sync(): void {
		$raw = $this->fetch_data();
		if ( is_wp_error( $raw ) ) return;
		$clients = $this->parse_rows( $raw );
		$result  = $this->import_to_posts( $clients );
		set_transient( $this->option_prefix . 'last_result', $result, HOUR_IN_SECONDS );
		update_option( $this->option_prefix . 'last_import', time() );
	}

	public function show_notices(): void {
		$screen = get_current_screen();
		if ( ! $screen || $screen->id !== 'settings_page_lf-law-firm-data' ) return;

		if ( isset( $_GET['imported'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Import complete!', 'lawfirm-showcase' ) . '</p></div>';
		}
		if ( isset( $_GET['import_error'] ) ) {
			$msg = get_transient( $this->option_prefix . 'admin_error' ) ?: __( 'Import failed.', 'lawfirm-showcase' );
			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $msg ) . '</p></div>';
		}
	}
}

new LF_Google_Sheets();
