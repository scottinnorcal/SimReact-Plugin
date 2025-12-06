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
					'simreact/hero-main',
					'simreact/feature-grid-core',
					'simreact/workflow-timeline',
					'simreact/output-gallery',
					'simreact/testimonial-strip',
					'simreact/cta-primary',
				],
			],
			'product' => [
				'label'    => __( 'Product Page – SimReact Explainer', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/hero-product',
					'simreact/feature-grid-core',
					'simreact/workflow-timeline',
					'simreact/faq-basic',
					'simreact/cta-primary',
				],
			],
			'pricing' => [
				'label'    => __( 'Pricing Page – Basic', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/hero-product',
					'simreact/feature-grid-core',
					'simreact/cta-primary',
				],
			],
			'about' => [
				'label'    => __( 'About Page – Story', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/hero-main',
					'simreact/workflow-timeline',
					'simreact/testimonial-strip',
					'simreact/cta-primary',
				],
			],
			'contact' => [
				'label'    => __( 'Contact Page – Simple', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/hero-main',
					'simreact/cta-primary',
				],
			],
			'case_study' => [
				'label'    => __( 'Case Study Page – Simple', 'simreact-site-builder' ),
				'patterns' => [
					'simreact/hero-main',
					'simreact/workflow-timeline',
					'simreact/output-gallery',
					'simreact/cta-primary',
				],
			],
		];
	}

	public static function get_template( $id ) {
		$templates = self::get_templates();
		return isset( $templates[ $id ] ) ? $templates[ $id ] : null;
	}

}
