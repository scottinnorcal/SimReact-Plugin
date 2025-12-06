<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Generator {

	public static function generate_page_from_template( $template_id, $args = [] ) {
		$template = SRSB_Templates::get_template( $template_id );

		if ( ! $template ) {
			return new WP_Error( 'srsb_template_not_found', __( 'Template not found.', 'simreact-site-builder' ) );
		}

		$block_content = '';

		if ( isset( $template['patterns'] ) && is_array( $template['patterns'] ) ) {
			foreach ( $template['patterns'] as $pattern_slug ) {
				$registered_patterns = \WP_Block_Patterns_Registry::get_instance()->get_registered( $pattern_slug );

				if ( $registered_patterns ) {
					$pattern_content = $registered_patterns['content'] ?? '';
					$block_content .= $pattern_content;
				}
			}
		}

		$defaults = [
			'post_title'       => '',
			'post_name'        => '',
			'post_status'      => 'publish',
			'post_type'        => 'page',
			'set_as_front_page' => false,
		];

		$args = wp_parse_args( $args, $defaults );

		if ( empty( $args['post_title'] ) ) {
			return new WP_Error( 'srsb_missing_title', __( 'Post title is required.', 'simreact-site-builder' ) );
		}

		$post_title = sanitize_text_field( $args['post_title'] );
		$post_name  = $args['post_name'];

		if ( empty( $post_name ) ) {
			$post_name = sanitize_title( $post_title );
		}

		$original_slug = $post_name;
		$unique_slug   = $original_slug;
		$counter       = 2;

		while ( get_page_by_path( $unique_slug, OBJECT, $args['post_type'] ) ) {
			$unique_slug = $original_slug . '-' . $counter;
			$counter++;
		}

		$post_data = [
			'post_title'   => $post_title,
			'post_name'    => $unique_slug,
			'post_type'    => $args['post_type'],
			'post_status'  => $args['post_status'],
			'post_content' => $block_content,
		];

		$post_id = wp_insert_post( $post_data );

		if ( is_wp_error( $post_id ) ) {
			return $post_id; // Already WP_Error
		}

		if ( $args['set_as_front_page'] && $args['post_type'] === 'page' ) {
			update_option( 'page_on_front', $post_id );
			update_option( 'show_on_front', 'page' );
		}

		return $post_id;
	}

}
