<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_Shortcode {

    public function __construct() {
        add_shortcode('vm_volunteer_form', [$this, 'render_volunteer_form']);
        add_action('init', [$this, 'handle_form_submission']);
    }

    public function render_volunteer_form() {
        ob_start();

        if (isset($_GET['volunteer_submitted']) && $_GET['volunteer_submitted'] == 'true') {
            echo '<p class="vm-success-message">Thank you for registering as a volunteer!</p>';
        }

        ?>
        <form method="post" action="">
            <p>
                <label>Name</label><br>
                <input type="text" name="vm_name" required>
            </p>
            <p>
                <label>Email</label><br>
                <input type="email" name="vm_email" required>
            </p>
            <p>
                <label>Phone</label><br>
                <input type="text" name="vm_phone" required>
            </p>
            <p>
                <label>Skills</label><br>
                <input type="text" name="vm_skills" required>
            </p>
            <p>
                <label>Availability Days/Times</label><br>
                <input type="text" name="vm_availability" required>
            </p>
            <p>
                <label>Location</label><br>
                <input type="text" name="vm_location" required>
            </p>
            <p>
                <label>Tell us why you volunteer</label><br>
                <textarea name="vm_reason" required></textarea>
            </p>

            <?php wp_nonce_field('vm_volunteer_form_action', 'vm_volunteer_form_nonce'); ?>

            <p>
                <input type="submit" name="vm_volunteer_submit" value="Register as Volunteer">
            </p>
        </form>
        <?php

        return ob_get_clean();
    }

    public function handle_form_submission() {
        if (isset($_POST['vm_volunteer_submit'])) {
            if (!isset($_POST['vm_volunteer_form_nonce']) || !wp_verify_nonce($_POST['vm_volunteer_form_nonce'], 'vm_volunteer_form_action')) {
                return;
            }

            $name = sanitize_text_field($_POST['vm_name']);
            $email = sanitize_email($_POST['vm_email']);
            $phone = sanitize_text_field($_POST['vm_phone']);
            $skills = sanitize_text_field($_POST['vm_skills']);
            $availability = sanitize_text_field($_POST['vm_availability']);
            $location = sanitize_text_field($_POST['vm_location']);
            $reason = sanitize_textarea_field($_POST['vm_reason']);

            $volunteer_id = wp_insert_post([
                'post_type' => 'vm_volunteer',
                'post_title' => $name,
                'post_status' => 'publish'
            ]);

            if ($volunteer_id) {
                update_post_meta($volunteer_id, 'vm_email', $email);
                update_post_meta($volunteer_id, 'vm_phone', $phone);
                update_post_meta($volunteer_id, 'vm_skills', $skills);
                update_post_meta($volunteer_id, 'vm_availability', $availability);
                update_post_meta($volunteer_id, 'vm_location', $location);
                update_post_meta($volunteer_id, 'vm_reason', $reason);

                // Redirect with thank you
                wp_redirect(add_query_arg('volunteer_submitted', 'true', $_SERVER['REQUEST_URI']));
                exit;
            }
        }
    }
}
