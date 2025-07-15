<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_Post_Type {

    public function __construct() {
        add_action('init', [$this, 'register_volunteer_cpt']);
    }

    public function register_volunteer_cpt() {
        $labels = [
            'name' => __('Volunteers', 'volunteer-management'),
            'singular_name' => __('Volunteer', 'volunteer-management'),
            'add_new' => __('Add New Volunteer', 'volunteer-management'),
        ];

        $args = [
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'supports' => ['title'],
            'menu_icon' => 'dashicons-groups',
        ];

        register_post_type('volunteer', $args);
    }
}
