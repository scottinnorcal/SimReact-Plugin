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
</div>
