<?php

if ( ! defined( 'WPINC' ) ) {
	die;
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

	<div id="srsb-test-ai-output" style="margin-top: 10px;"></div>
</div>
