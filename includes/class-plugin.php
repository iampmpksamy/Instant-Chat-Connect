<?php
namespace WWAC;

if ( ! defined( 'ABSPATH' ) ) exit;

class Plugin {

    private static $instance = null;

    public static function instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }

    private function includes() {
        require_once WWAC_PATH . 'includes/class-admin.php';
        require_once WWAC_PATH . 'includes/class-frontend.php';
    }

    private function init_hooks() {
        if ( is_admin() ) {
            new Admin();
        } else {
            new Frontend();
        }
    }
}