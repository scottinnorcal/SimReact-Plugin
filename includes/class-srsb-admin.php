<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_ajax_srsb_test_ai', array( $this, 'ajax_test_ai' ) );
		add_action( 'wp_ajax_srsb_generate_ai_copy', array( $this, 'ajax_generate_ai_copy' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Register admin menus.
	 */
	public function register_menus() {
		add_menu_page(
			__( 'SimReact Builder', 'simreact-site-builder' ),
			__( 'SimReact Builder', 'simreact-site-builder' ),
			'manage_options',
			'simreact-builder',
			array( $this, 'render_builder_page' ),
			'dashicons-layout',
			58
		);

		add_submenu_page(
			'simreact-builder',
			__( 'SimReact Settings', 'simreact-site-builder' ),
			__( 'Settings', 'simreact-site-builder' ),
			'manage_options',
			'simreact-builder-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Render builder page.
	 */
	public function render_builder_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle page generation form submission.
		if (
			isset( $_POST['srsb_generate_page_nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['srsb_generate_page_nonce'] ) ), 'srsb_generate_page' )
		) {
			$template_id       = isset( $_POST['srsb_template_id'] ) ? sanitize_text_field( wp_unslash( $_POST['srsb_template_id'] ) ) : '';
			$page_title        = isset( $_POST['srsb_page_title'] ) ? sanitize_text_field( wp_unslash( $_POST['srsb_page_title'] ) ) : '';
			$page_slug_input   = isset( $_POST['srsb_page_slug'] ) ? sanitize_text_field( wp_unslash( $_POST['srsb_page_slug'] ) ) : '';
			$set_as_front_page = ! empty( $_POST['srsb_set_as_front_page'] );

			if ( empty( $template_id ) || empty( $page_title ) ) {
				add_settings_error(
					'srsb_builder',
					'srsb_builder_missing_fields',
					__( 'Please select a template and enter a page title.', 'simreact-site-builder' ),
					'error'
				);
			} else {
				$args = array(
					'post_title'        => $page_title,
					'post_name'         => $page_slug_input ? sanitize_title( $page_slug_input ) : '',
					'post_status'       => 'publish',
					'post_type'         => 'page',
					'set_as_front_page' => $set_as_front_page,
				);

				$result = SRSB_Generator::generate_page_from_template( $template_id, $args );

				if ( is_wp_error( $result ) ) {
					add_settings_error(
						'srsb_builder',
						'srsb_builder_error',
						$result->get_error_message(),
						'error'
					);
				} else {
					$edit_link = get_edit_post_link( $result );
					$view_link = get_permalink( $result );

					$message = sprintf(
						/* translators: 1: edit link, 2: view link */
						__( 'Page created successfully. <a href="%1$s">Edit Page</a> | <a href="%2$s" target="_blank">View Page</a>', 'simreact-site-builder' ),
						esc_url( $edit_link ),
						esc_url( $view_link )
					);

					add_settings_error(
						'srsb_builder',
						'srsb_builder_success',
						$message,
						'updated'
					);
				}
			}
		}

		settings_errors( 'srsb_builder' );

		include SRSB_PLUGIN_DIR . 'admin/views/page-builder-dashboard.php';
	}

	/**
	 * Render settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'SimReact Settings', 'simreact-site-builder' ); ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'simreact_site_builder_options' );
					do_settings_sections( 'simreact_site_builder_settings' );
					submit_button();
				?>
			</form>
			<hr>
			<h2><?php esc_html_e( 'AI Connection Test', 'simreact-site-builder' ); ?></h2>
			<p><?php esc_html_e( 'Click the button below to verify your OpenRouter API key is working.', 'simreact-site-builder' ); ?></p>
			<button id="srsb-test-ai" class="button button-secondary"><?php esc_html_e( 'Test AI Connection', 'simreact-site-builder' ); ?></button>
			<div id="srsb-test-ai-output" style="margin-top:10px;"></div>
		</div>
		<?php
	}

	/**
	 * Register plugin settings.
	 */
	public function register_settings() {
		register_setting(
			'simreact_site_builder_options',
			'simreact_ai_api_key',
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);

		register_setting(
			'simreact_site_builder_options',
			'simreact_brand_primary_color',
			array( 'sanitize_callback' => 'sanitize_hex_color' )
		);

		register_setting(
			'simreact_site_builder_options',
			'simreact_brand_secondary_color',
			array( 'sanitize_callback' => 'sanitize_hex_color' )
		);

		register_setting(
			'simreact_site_builder_options',
			'simreact_brand_accent_color',
			array( 'sanitize_callback' => 'sanitize_hex_color' )
		);

		register_setting(
			'simreact_site_builder_options',
			'simreact_brand_default_cta',
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);

		add_settings_section(
			'simreact_site_builder_general',
			__( 'Brand Defaults', 'simreact-site-builder' ),
			'__return_false',
			'simreact_site_builder_settings'
		);

		add_settings_field(
			'simreact_ai_api_key',
			__( 'OpenRouter API Key', 'simreact-site-builder' ),
			array( $this, 'field_ai_api_key' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_primary_color',
			__( 'Primary Color', 'simreact-site-builder' ),
			array( $this, 'field_primary_color' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_secondary_color',
			__( 'Secondary Color', 'simreact-site-builder' ),
			array( $this, 'field_secondary_color' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_accent_color',
			__( 'Accent Color', 'simreact-site-builder' ),
			array( $this, 'field_accent_color' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_default_cta',
			__( 'Default CTA Text', 'simreact-site-builder' ),
			array( $this, 'field_default_cta' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);
	}

	public function field_ai_api_key() {
		$value = get_option( 'simreact_ai_api_key', '' );
		?>
		<input type="text" name="simreact_ai_api_key" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<p class="description"><?php esc_html_e( 'Your OpenRouter API key for AI features.', 'simreact-site-builder' ); ?></p>
		<?php
	}

	public function field_primary_color() {
		$value = get_option( 'simreact_brand_primary_color', '#000000' );
		?>
		<input type="text" name="simreact_brand_primary_color" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<p class="description"><?php esc_html_e( 'Primary brand HEX color, e.g. #1A202C.', 'simreact-site-builder' ); ?></p>
		<?php
	}

	public function field_secondary_color() {
		$value = get_option( 'simreact_brand_secondary_color', '#666666' );
		?>
		<input type="text" name="simreact_brand_secondary_color" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<?php
	}

	public function field_accent_color() {
		$value = get_option( 'simreact_brand_accent_color', '#E53E3E' );
		?>
		<input type="text" name="simreact_brand_accent_color" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<?php
	}

	public function field_default_cta() {
		$value = get_option( 'simreact_brand_default_cta', __( 'Request a Specimen Scan', 'simreact-site-builder' ) );
		?>
		<input type="text" name="simreact_brand_default_cta" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<?php
	}

	/**
	 * AJAX: Test AI connection.
	 */
	public function ajax_test_ai() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Unauthorized.', 'simreact-site-builder' ) );
		}

		$result = SRSB_AI::chat( 'Respond with: AI Test Successful' );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		}

		wp_send_json_success( $result );
	}

	/**
	 * AJAX: Generate AI copy for a section.
	 */
	public function ajax_generate_ai_copy() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Unauthorized.', 'simreact-site-builder' ) );
		}

		$prompt  = isset( $_POST['prompt'] ) ? sanitize_text_field( wp_unslash( $_POST['prompt'] ) ) : '';
		$section = isset( $_POST['section'] ) ? sanitize_text_field( wp_unslash( $_POST['section'] ) ) : '';

		if ( empty( $prompt ) || empty( $section ) ) {
			wp_send_json_error( __( 'Missing section or prompt.', 'simreact-site-builder' ) );
		}

		$full_prompt = sprintf(
			'Write marketing copy for the SimReact website section "%1$s". Purpose: %2$s. Respond with plain text only, no markdown or HTML.',
			$section,
			$prompt
		);

		$result = SRSB_AI::chat( $full_prompt );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		}

		wp_send_json_success( $result );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( false === strpos( $hook, 'simreact-builder' ) ) {
			return;
		}

		wp_enqueue_script(
			'srsb-admin-js',
			SRSB_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			SRSB_VERSION,
			true
		);
	}

}
