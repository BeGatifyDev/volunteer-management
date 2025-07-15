<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_Meta_Boxes {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);
    }

    public function add_meta_boxes() {
        add_meta_box('volunteer_details', __('Volunteer Details', 'volunteer-management'), [$this, 'render_meta_box'], 'volunteer', 'normal', 'default');
    }

    public function render_meta_box($post) {
        $fields = [
            'email' => 'Email',
            'phone' => 'Phone',
            'skills' => 'Skills',
            'availability' => 'Availability',
            'location' => 'Location',
            'why' => 'Why Volunteer'
        ];

        foreach ($fields as $key => $label) {
            $value = get_post_meta($post->ID, $key, true);
            echo "<p><label>{$label}</label><br/>";
            echo "<input type='text' name='{$key}' value='" . esc_attr($value) . "' style='width:100%;'/></p>";
        }
    }

    public function save_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        $fields = ['email','phone','skills','availability','location','why'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
