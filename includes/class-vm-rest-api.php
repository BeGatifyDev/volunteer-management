<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_REST_API {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('volunteer/v1', '/list', [
            'methods' => 'GET',
            'callback' => [$this, 'get_volunteers'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_volunteers() {
        $query = new \WP_Query(['post_type' => 'volunteer', 'posts_per_page' => -1]);
        $volunteers = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $volunteers[] = [
                    'name' => get_the_title(),
                    'email' => get_post_meta(get_the_ID(), 'email', true),
                    'phone' => get_post_meta(get_the_ID(), 'phone', true),
                    'skills' => get_post_meta(get_the_ID(), 'skills', true),
                    'availability' => get_post_meta(get_the_ID(), 'availability', true),
                    'location' => get_post_meta(get_the_ID(), 'location', true),
                    'why' => get_post_meta(get_the_ID(), 'why', true),
                ];
            }
        }
        wp_reset_postdata();
        return $volunteers;
    }
}
