<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Patterns {

	public function __construct() {
		add_action( 'init', array( $this, 'register_pattern_categories' ), 10 );
		add_action( 'init', array( $this, 'register_test_patterns' ), 11 );
	}

	public function register_pattern_categories() {
		register_block_pattern_category( 'simreact-heroes', array(
			'label' => __( 'SimReact – Heroes', 'simreact-site-builder' ),
		) );

		register_block_pattern_category( 'simreact-features', array(
			'label' => __( 'SimReact – Features', 'simreact-site-builder' ),
		) );

		register_block_pattern_category( 'simreact-ctas', array(
			'label' => __( 'SimReact – CTAs', 'simreact-site-builder' ),
		) );

		register_block_pattern_category( 'simreact-testimonials', array(
			'label' => __( 'SimReact – Testimonials', 'simreact-site-builder' ),
		) );

		register_block_pattern_category( 'simreact-structure', array(
			'label' => __( 'SimReact – Structure', 'simreact-site-builder' ),
		) );
	}

	public function register_test_patterns() {
		register_block_pattern(
			'simreact/hero-main',
			array(
				'title'      => __( 'Hero – Main Product', 'simreact-site-builder' ),
				'description' => __( 'Primary hero section for SimReact product introduction', 'simreact-site-builder' ),
				'categories' => array( 'simreact-heroes' ),
				'content'    => '<!-- wp:group {"className":"srsb-hero-main"} -->
<!-- wp:heading {"level":1} --
SimReact — Structural Intelligence for YouTube Creators
-- /wp:heading -->
<!-- wp:paragraph --
Ai-powered structural analysis software that identifies and optimize your video strategies. Systematically analyze content structure, audience engagement, and optimization opportunities.
-- /wp:paragraph -->
<!-- wp:buttons --
<!-- wp:button {"className":"srsb-hero-primary-cta"} --><a class="wp-block-button__link">Request a Specimen Scan</a><!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline srsb-hero-secondary-cta"} --><a class="wp-block-button__link">View Sample Reports</a><!-- /wp:button -->
<!-- /wp:buttons -->
<!-- /wp:group -->',
			)
		);

		register_block_pattern(
			'simreact/feature-grid-core',
			array(
				'title'      => __( 'Feature Grid – Core Benefits', 'simreact-site-builder' ),
				'description' => __( 'Grid layout highlighting key SimReact features', 'simreact-site-builder' ),
				'categories' => array( 'simreact-features' ),
				'content'    => '<!-- wp:heading {"level":2} --
Why SimReact
-- /wp:heading -->
<!-- wp:columns --
<!-- wp:column --
<!-- wp:heading {"level":3} --
Structural Diagnostics
-- /wp:heading -->
<!-- wp:paragraph --
Comprehensive analysis of video structure identifies weak points, engagement patterns, and optimization opportunities.
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:heading {"level":3} --
Persona Lens Analysis
-- /wp:heading -->
<!-- wp:paragraph --
Demographic and psychographic profiling of your audience to create more targeted and compelling content.
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:heading {"level":3} --
Timestamped Friction Map
-- /wp:heading -->
<!-- wp:paragraph --
Pinpoint exact moments where viewers lose interest, with actionable recommendations for pacing and flow.
-- /wp:paragraph -->
-- /wp:column -->
<!-- /wp:columns -->',
			)
		);

		register_block_pattern(
			'simreact/workflow-timeline',
			array(
				'title'      => __( 'Workflow Timeline', 'simreact-site-builder' ),
				'description' => __( 'Step-by-step process explanation', 'simreact-site-builder' ),
				'categories' => array( 'simreact-structure' ),
				'content'    => '<!-- wp:heading {"level":2} --
How SimReact Works
-- /wp:heading -->
<!-- wp:list --
<li><strong>Step 1:</strong> Input your video URL or upload content for analysis</li>
<li><strong>Step 2:</strong> AI-powered structural risk assessment is performed</li>
<li><strong>Step 3:</strong> Receive detailed diagnostics and optimization recommendations</li>
<li><strong>Step 4:</strong> Apply insights to improve future content strategy</li>
<li><strong>Step 5:</strong> Track performance improvements with before/after metrics</li>
<!-- /wp:list -->',
			)
		);

		register_block_pattern(
			'simreact/output-gallery',
			array(
				'title'      => __( 'Output Gallery / Deliverables', 'simreact-site-builder' ),
				'description' => __( 'Display of SimReact analysis outputs', 'simreact-site-builder' ),
				'categories' => array( 'simreact-structure' ),
				'content'    => '<!-- wp:heading {"level":2} --
What You Get
-- /wp:heading -->
<!-- wp:columns --
<!-- wp:column --
<!-- wp:heading {"level":3} --
Structural Risk Assessment
-- /wp:heading -->
<!-- wp:paragraph --
Detailed breakdown of content structure weaknesses with risk scores and improvement recommendations.
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:heading {"level":3} --
Specimen Scan Report
-- /wp:heading -->
<!-- wp:paragraph --
Video-by-video analysis with engagement metrics, content flow evaluation, and optimization suggestions.
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:heading {"level":3} --
Outreach Packet
-- /wp:heading -->
<!-- wp:paragraph --
Professional summary designed for pitching to brands and collaborations with actionable takeaways.
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:heading {"level":3} --
Timestamp Map
-- /wp:heading -->
<!-- wp:paragraph --
Precise timeline of audience engagement with drop-off points highlighted for editor cut and pacing fixes.
-- /wp:paragraph -->
-- /wp:column -->
<!-- /wp:columns -->',
			)
		);

		register_block_pattern(
			'simreact/testimonial-strip',
			array(
				'title'      => __( 'Testimonial Strip', 'simreact-site-builder' ),
				'description' => __( 'Creator testimonials and feedback', 'simreact-site-builder' ),
				'categories' => array( 'simreact-testimonials' ),
				'content'    => '<!-- wp:heading {"level":2} --
Creator Feedback
-- /wp:heading -->
<!-- wp:columns --
<!-- wp:column --
<!-- wp:paragraph --
"SimReact completely transformed how I approach my videos. I went from over-analyzing to data-driven optimization."
-- /wp:paragraph -->
<!-- wp:paragraph --
<strong>- Creator Name, 50K subscribers</strong>
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:paragraph --
"The structural diagnostics are spot on. I've increased my retention by 30% since applying these insights."
-- /wp:paragraph -->
<!-- wp:paragraph --
<strong>- Creator Name, 100K+ subscribers</strong>
-- /wp:paragraph -->
-- /wp:column -->
<!-- wp:column --
<!-- wp:paragraph --
"Best investment I've made for my channel. The timestamp mapping alone saved me hours of guessing."
-- /wp:paragraph -->
<!-- wp:paragraph --
<strong>- Creator Name, Gaming Reviewer</strong>
-- /wp:paragraph -->
-- /wp:column -->
<!-- /wp:columns -->',
			)
		);

		register_block_pattern(
			'simreact/cta-primary',
			array(
				'title'      => __( 'Primary CTA Footer', 'simreact-site-builder' ),
				'description' => __( 'Call-to-action section for conversions', 'simreact-site-builder' ),
				'categories' => array( 'simreact-ctas' ),
				'content'    => '<!-- wp:group {"className":"srsb-cta-primary"} -->
<!-- wp:heading {"level":2} --
Ready to Optimize Your Content Strategy?
-- /wp:heading -->
<!-- wp:paragraph --
Join hundreds of creators who are already using SimReact to systematically improve their video performance.
-- /wp:paragraph -->
<!-- wp:buttons --
<!-- wp:button {"className":"srsb-cta-button"} --><a class="wp-block-button__link">Request Analysis</a><!-- /wp:button -->
<!-- /wp:buttons -->
<!-- /wp:group -->',
			)
		);

		register_block_pattern(
			'simreact/hero-product',
			array(
				'title'      => __( 'Hero – Product Focused', 'simreact-site-builder' ),
				'description' => __( 'Product-specific hero for detailed pages', 'simreact-site-builder' ),
				'categories' => array( 'simreact-heroes' ),
				'content'    => '<!-- wp:group {"className":"srsb-hero-product"} -->
<!-- wp:heading {"level":1} --
SimReact vΩ⁴ — Structural Risk Assessment Engine
-- /wp:heading -->
<!-- wp:paragraph --
The only AI-powered platform designed specifically for YouTube content structure optimization. Analyze, diagnose, and transform your video creation process.
-- /wp:paragraph -->
<!-- wp:buttons --
<!-- wp:button {"className":"srsb-hero-primary-cta"} --><a class="wp-block-button__link">Start Your Analysis</a><!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline srsb-hero-secondary-cta"} --><a class="wp-block-button__link">Learn More</a><!-- /wp:button -->
<!-- /wp:buttons -->
<!-- /wp:group -->',
			)
		);

		register_block_pattern(
			'simreact/faq-basic',
			array(
				'title'      => __( 'FAQ Section', 'simreact-site-builder' ),
				'description' => __( 'Frequently asked questions and answers', 'simreact-site-builder' ),
				'categories' => array( 'simreact-structure' ),
				'content'    => '<!-- wp:heading {"level":2} --
Frequently Asked Questions
-- /wp:heading -->
<!-- wp:heading {"level":3} --
How does structural risk assessment work?
-- /wp:heading -->
<!-- wp:paragraph --
Our AI analyzes thousands of data points from your video content to identify structural weaknesses, engagement patterns, and optimization opportunities.
-- /wp:paragraph -->
<!-- wp:heading {"level":3} --
Can I use SimReact for any video type?
-- /wp:heading -->
<!-- wp:paragraph --
Yes! SimReact works for all video formats - vlogs, tutorials, reviews, live streams, and more. Our algorithms adapt to different content types.
-- /wp:paragraph -->
<!-- wp:heading {"level":3} --
How long does analysis take?
-- /wp:heading -->
<!-- wp:paragraph --
Most videos are analyzed within minutes, with comprehensive reports delivered in under 15 minutes depending on video length.
-- /wp:paragraph -->
<!-- wp:heading {"level":3} --
Is my content secure with SimReact?
-- /wp:heading -->
<!-- wp:paragraph --
Absolutely. We prioritize privacy and security - content is processed securely and not stored after analysis is complete.
-- /wp:paragraph -->
<!-- wp:heading {"level":3} --
What metrics do you track?
-- /wp:heading -->
<!-- wp:paragraph --
We analyze view retention, engagement peaks/drops, content pacing, topic transitions, and audience interaction patterns.
-- /wp:paragraph -->',
			)
		);
	}

}
