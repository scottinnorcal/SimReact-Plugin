<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Loader {

	public function __construct() {
		$this->load_classes();
	}

	private function load_classes() {
		$classes = array(
			'class-srsb-plugin.php',
			'class-srsb-patterns.php',
			'class-srsb-templates.php',
			'class-srsb-admin.php',
			'class-srsb-settings.php',
			'class-srsb-generator.php',
		);
		foreach ( $classes as $class ) {
			require_once SRSB_PLUGIN_DIR . 'includes/' . $class;
		}
		require_once SRSB_PLUGIN_DIR . 'includes/helpers.php';
	}

}
