<?php
/**
 * Plugin Name: SimReact Site Builder
 * Description: Internal plugin to speed up building and maintaining the SimReact marketing site.
 * Version: 1.0.0
 * Author: SimReact Team
 * Text Domain: simreact-site-builder
 * License: GPL v2 or later
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SRSB_VERSION', '1.0.0' );
define( 'SRSB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SRSB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once SRSB_PLUGIN_DIR . 'includes/class-srsb-loader.php';

SRSB_Plugin::get_instance();
