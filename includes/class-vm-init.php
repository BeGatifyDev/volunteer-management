<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_Init {

    public function __construct() {
        add_action('plugins_loaded', [$this, 'load_textdomain']);
        $this->includes();
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
    }

    public function load_textdomain() {
        load_plugin_textdomain('volunteer-management', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function admin_assets() {
        wp_enqueue_style('vm-admin-css', VM_URL . 'assets/css/admin.css');
        wp_enqueue_script('vm-admin-js', VM_URL . 'assets/js/admin.js', ['jquery'], null, true);
    }

    public function frontend_assets() {
        wp_enqueue_style('vm-frontend-css', VM_URL . 'assets/css/frontend.css');
        wp_enqueue_script('vm-frontend-js', VM_URL . 'assets/js/frontend.js', ['jquery'], null, true);
    }

    private function includes() {
        require_once VM_PATH . 'includes/class-vm-post-type.php';
        require_once VM_PATH . 'includes/class-vm-meta-boxes.php';
        require_once VM_PATH . 'includes/class-vm-shortcode.php';
        require_once VM_PATH . 'includes/class-vm-dashboard.php';
        require_once VM_PATH . 'includes/class-vm-rest-api.php';

        new VM_Post_Type();
        new VM_Meta_Boxes();
        new VM_Shortcode();
        new VM_Dashboard();
        new VM_REST_API();
    }
}
