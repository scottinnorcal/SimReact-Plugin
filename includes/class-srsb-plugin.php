<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_Plugin {

	public function __construct() {
		$this->patterns = new SRSB_Patterns();
	}

}
