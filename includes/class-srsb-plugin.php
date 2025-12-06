<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Main SimReact Site Builder plugin class.
 */
class SRSB_Plugin {

    /**
     * Singleton instance.
     *
     * @var SRSB_Plugin|null
     */
    protected static $instance = null;

    /**
     * Patterns manager.
     *
     * @var SRSB_Patterns
     */
    protected $patterns;

    /**
     * Admin manager.
     *
     * @var SRSB_Admin|null
     */
    protected $admin;

    /**
     * Get singleton instance.
     *
     * @return SRSB_Plugin
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * SRSB_Plugin constructor.
     */
    private function __construct() {
        $this->patterns = new SRSB_Patterns();

        if ( is_admin() ) {
            $this->admin = new SRSB_Admin();
        }
    }
}
