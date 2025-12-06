<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

?>
<div class="wrap">
	<h1><?php esc_html_e( 'SimReact Page Builder', 'simreact-site-builder' ); ?></h1>
	<p><?php esc_html_e( 'Generate structured pages using predefined SimReact templates.', 'simreact-site-builder' ); ?></p>

	<form method="post">
		<?php wp_nonce_field( 'srsb_generate_page', 'srsb_generate_page_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th><label for="srsb_template_id"><?php esc_html_e( 'Page Type', 'simreact-site-builder' ); ?></label></th>
				<td>
					<select name="srsb_template_id" id="srsb_template_id" required>
						<option value=""><?php esc_html_e( 'Select a template...', 'simreact-site-builder' ); ?></option>
						<?php
						$templates = SRSB_Templates::get_templates();
						foreach ( $templates as $id => $template ) {
							echo '<option value="' . esc_attr( $id ) . '">' . esc_html( $template['label'] ) . '</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="srsb_page_title"><?php esc_html_e( 'Page Title', 'simreact-site-builder' ); ?></label></th>
				<td><input type="text" name="srsb_page_title" id="srsb_page_title" class="regular-text" required /></td>
			</tr>
			<tr>
				<th><label for="srsb_page_slug"><?php esc_html_e( 'Slug (optional)', 'simreact-site-builder' ); ?></label></th>
				<td><input type="text" name="srsb_page_slug" id="srsb_page_slug" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="srsb_set_as_front_page"><?php esc_html_e( 'Set as homepage', 'simreact-site-builder' ); ?></label></th>
				<td><input type="checkbox" name="srsb_set_as_front_page" id="srsb_set_as_front_page" value="1" /></td>
			</tr>
		</table>

		<?php submit_button( esc_html__( 'Generate Page', 'simreact-site-builder' ) ); ?>
	</form>
</div>
