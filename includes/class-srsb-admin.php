<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_ajax_srsb_test_ai', array( $this, 'ajax_test_ai' ) );
		add_action( 'wp_ajax_srsb_generate_ai_copy', array( $this, 'ajax_generate_ai_copy' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	public function register_menus() {
		add_menu_page(
			__( 'SimReact Page Builder', 'simreact-site-builder' ),
			__( 'SimReact Builder', 'simreact-site-builder' ),
			'manage_options',
			'simreact-builder',
			array( $this, 'render_builder_page' ),
			'dashicons-welcome-add-page',
			20
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

	public function render_builder_page() {
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['srsb_generate_page_nonce'] ) ) {
			$this->handle_form_submission();
		}

		include_once SRSB_PLUGIN_DIR . 'admin/views/page-builder-dashboard.php';
	}

	private function handle_form_submission() {
		if ( ! wp_verify_nonce( $_POST['srsb_generate_page_nonce'], 'srsb_generate_page' ) ) {
			wp_die( __( 'Security check failed.', 'simreact-site-builder' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have permission to perform this action.', 'simreact-site-builder' ) );
		}

		$template_id = sanitize_text_field( $_POST['srsb_template_id'] ?? '' );
		$page_title  = sanitize_text_field( $_POST['srsb_page_title'] ?? '' );
		$page_slug   = sanitize_title( $_POST['srsb_page_slug'] ?? '' );
		$set_as_front_page = ! empty( $_POST['srsb_set_as_front_page'] );

		if ( empty( $template_id ) || empty( $page_title ) ) {
			echo '<div class="notice notice-error is-dismissible"><p>' . __( 'Template and page title are required.', 'simreact-site-builder' ) . '</p></div>';
			return;
		}

		$args = array(
			'post_title'       => $page_title,
			'post_name'        => $page_slug ?: null,
			'post_status'      => 'publish',
			'post_type'        => 'page',
			'set_as_front_page' => $set_as_front_page,
		);

		$result = SRSB_Generator::generate_page_from_template( $template_id, $args );

		if ( is_wp_error( $result ) ) {
			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
		} else {
			$edit_link = get_edit_post_link( $result );
			$view_link = get_permalink( $result );
			$message = sprintf(
				__( 'Page created successfully. <a href="%1$s">Edit Page</a> | <a href="%2$s" target="_blank">View Page</a>', 'simreact-site-builder' ),
				esc_url( $edit_link ),
				esc_url( $view_link )
			);
			echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
		}
	}

	public function render_settings_page() {
		include_once SRSB_PLUGIN_DIR . 'admin/views/page-settings.php';
	}

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
			__( 'SimReact Brand Settings', 'simreact-site-builder' ),
			null,
			'simreact_site_builder_settings'
		);

		add_settings_field(
			'simreact_ai_api_key',
			__( 'OpenRouter API Key', 'simreact-site-builder' ),
			array( $this, 'render_api_key_field' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_primary_color',
			__( 'Primary Color', 'simreact-site-builder' ),
			array( $this, 'render_primary_color_field' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_secondary_color',
			__( 'Secondary Color', 'simreact-site-builder' ),
			array( $this, 'render_secondary_color_field' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_accent_color',
			__( 'Accent Color', 'simreact-site-builder' ),
			array( $this, 'render_accent_color_field' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);

		add_settings_field(
			'simreact_brand_default_cta',
			__( 'Default CTA Text', 'simreact-site-builder' ),
			array( $this, 'render_default_cta_field' ),
			'simreact_site_builder_settings',
			'simreact_site_builder_general'
		);
	}

	public function render_api_key_field() {
		$value = get_option( 'simreact_ai_api_key', '' );
		echo '<input type="text" name="simreact_ai_api_key" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'Enter your OpenRouter API key for AI features.', 'simreact-site-builder' ) . '</p>';
	}

	public function render_primary_color_field() {
		$value = get_option( 'simreact_brand_primary_color', '#000000' );
		echo '<input type="text" name="simreact_brand_primary_color" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'Enter a HEX color like #1A202C', 'simreact-site-builder' ) . '</p>';
	}

	public function render_secondary_color_field() {
		$value = get_option( 'simreact_brand_secondary_color', '#ffffff' );
		echo '<input type="text" name="simreact_brand_secondary_color" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'Enter a HEX color like #6B7280', 'simreact-site-builder' ) . '</p>';
	}

	public function render_accent_color_field() {
		$value = get_option( 'simreact_brand_accent_color', '#007bff' );
		echo '<input type="text" name="simreact_brand_accent_color" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'Enter a HEX color like #0056B3', 'simreact-site-builder' ) . '</p>';
	}

	public function render_default_cta_field() {
		$value = get_option( 'simreact_brand_default_cta', 'Request a Diagnostic' );
		echo '<input type="text" name="simreact_brand_default_cta" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'Default call-to-action text for patterns.', 'simreact-site-builder' ) . '</p>';
	}

	public function ajax_test_ai() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Unauthorized.', 'simreact-site-builder' ) );
		}

		$result = SRSB_AI::chat( __( 'Respond with: AI Test Successful', 'simreact-site-builder' ) );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		} else {
			wp_send_json_success( $result );
		}
	}

	public function ajax_generate_ai_copy() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Unauthorized.', 'simreact-site-builder' ) );
		}

		$prompt  = sanitize_text_field( $_POST['prompt'] ?? '' );
		$section = sanitize_text_field( $_POST['section'] ?? '' );

		if ( empty( $prompt ) || empty( $section ) ) {
			wp_send_json_error( __( 'Missing section or prompt.', 'simreact-site-builder' ) );
		}

		$full_prompt = "Write copy for the SimReact website section: {$section}. The purpose of this section: {$prompt}. Respond with only text, no markdown.";

		$result = SRSB_AI::chat( $full_prompt );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		} else {
			wp_send_json_success( $result );
		}
	}

	public function enqueue_admin_assets() {
		wp_enqueue_script(
			'srsb-admin-js',
			SRSB_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			SRSB_VERSION,
			true
		);
	}

}
