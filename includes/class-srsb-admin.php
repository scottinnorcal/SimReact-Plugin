<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
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
		echo '<div class="wrap"><h1>' . esc_html__( 'SimReact Settings', 'simreact-site-builder' ) . '</h1><p>' . esc_html__( 'Settings UI coming in a later phase.', 'simreact-site-builder' ) . '</p></div>';
	}

}
