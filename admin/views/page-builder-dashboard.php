<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}

$templates = class_exists( 'SRSB_Templates' ) ? SRSB_Templates::get_templates() : array();
?>
<div class="wrap">
    <h1><?php esc_html_e( 'SimReact Page Builder', 'simreact-site-builder' ); ?></h1>
    <p><?php esc_html_e( 'Generate structured pages using predefined SimReact templates.', 'simreact-site-builder' ); ?></p>

    <hr>

    <h2><?php esc_html_e( 'AI Copy Generator (Optional)', 'simreact-site-builder' ); ?></h2>
    <p><?php esc_html_e( 'Use AI to generate custom copy for specific sections before building the page. You can copy/paste the generated text into your pages or patterns.', 'simreact-site-builder' ); ?></p>

    <table class="form-table">
        <tr>
            <th><label for="srsb_ai_section"><?php esc_html_e( 'Section', 'simreact-site-builder' ); ?></label></th>
            <td>
                <select name="srsb_ai_section" id="srsb_ai_section">
                    <option value=""><?php esc_html_e( 'Do not use AI', 'simreact-site-builder' ); ?></option>
                    <option value="hero-main"><?php esc_html_e( 'Hero – Main', 'simreact-site-builder' ); ?></option>
                    <option value="hero-product"><?php esc_html_e( 'Hero – Product', 'simreact-site-builder' ); ?></option>
                    <option value="feature-grid-core"><?php esc_html_e( 'Feature Grid – Core', 'simreact-site-builder' ); ?></option>
                    <option value="workflow-timeline"><?php esc_html_e( 'Workflow Timeline', 'simreact-site-builder' ); ?></option>
                    <option value="output-gallery"><?php esc_html_e( 'Output Gallery', 'simreact-site-builder' ); ?></option>
                    <option value="testimonial-strip"><?php esc_html_e( 'Testimonials', 'simreact-site-builder' ); ?></option>
                    <option value="faq-basic"><?php esc_html_e( 'FAQ Section', 'simreact-site-builder' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="srsb_ai_prompt"><?php esc_html_e( 'AI Prompt', 'simreact-site-builder' ); ?></label></th>
            <td>
                <textarea name="srsb_ai_prompt" id="srsb_ai_prompt" rows="4" class="large-text" placeholder="<?php esc_attr_e( 'Describe what you want the AI to write. Example: Rewrite the hero to highlight SimReact as a structural intelligence engine for creators.', 'simreact-site-builder' ); ?>"></textarea>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <button type="button" class="button" id="srsb-ai-generate-button"><?php esc_html_e( 'Generate Copy', 'simreact-site-builder' ); ?></button>
                <div id="srsb-ai-generation-output" style="margin-top:10px;"></div>
            </td>
        </tr>
    </table>

    <hr>

    <h2><?php esc_html_e( 'Generate Page from Template', 'simreact-site-builder' ); ?></h2>

    <form method="post">
        <?php wp_nonce_field( 'srsb_generate_page', 'srsb_generate_page_nonce' ); ?>

        <table class="form-table">
            <tr>
                <th><label for="srsb_template_id"><?php esc_html_e( 'Page Type', 'simreact-site-builder' ); ?></label></th>
                <td>
                    <select name="srsb_template_id" id="srsb_template_id" required>
                        <option value=""><?php esc_html_e( 'Select a template', 'simreact-site-builder' ); ?></option>
                        <?php foreach ( $templates as $template_id => $template ) : ?>
                            <option value="<?php echo esc_attr( $template_id ); ?>">
                                <?php echo esc_html( $template['label'] ?? $template_id ); ?>
                            </option>
                        <?php endforeach; ?>
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
