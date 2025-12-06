<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Templates {

	public static function get_templates() {
		return [
			'home_v1' => [
				'label'    => __( 'Homepage v1 – Product-Led', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
			'product' => [
				'label'    => __( 'Product Page – SimReact Explainer', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
			'pricing' => [
				'label'    => __( 'Pricing Page – Basic', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
			'about' => [
				'label'    => __( 'About Page – Simple', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
			'contact' => [
				'label'    => __( 'Contact Page – Simple', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
			'case_study' => [
				'label'    => __( 'Case Study Page – Simple', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/test-hero',
					'simreact/test-feature',
				],
			],
		];
	}

	public static function get_template( $id ) {
		$templates = self::get_templates();
		return isset( $templates[ $id ] ) ? $templates[ $id ] : null;
	}

}
