<?php
namespace VM\Common;

defined('ABSPATH') || exit;

class VM_Dashboard {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_dashboard_page']);
    }

    public function add_dashboard_page() {
        add_menu_page(
            __('Volunteer Dashboard', 'volunteer-management'),
            __('Volunteers', 'volunteer-management'),
            'manage_options',
            'volunteer-dashboard',
            [$this, 'render_dashboard'],
            'dashicons-groups',
            6
        );
    }

    public function render_dashboard() {
        ?>
        <div class="wrap">
            <h1><?php _e('Volunteer Manager Dashboard', 'volunteer-management'); ?></h1>
            <p><?php _e('Welcome to your volunteer manager dashboard. Here you will see all registered volunteers.', 'volunteer-management'); ?></p>

            <?php
            $query = new \WP_Query([
                'post_type' => 'volunteer',
                'posts_per_page' => -1
            ]);

            if ($query->have_posts()) {
                echo "<table class='wp-list-table widefat fixed striped'>";
                echo "<thead><tr><th>Name</th><th>Email</th><th>Skills</th><th>Availability</th></tr></thead><tbody>";

                while ($query->have_posts()) {
                    $query->the_post();
                    $id = get_the_ID();
                    echo "<tr>";
                    echo "<td>" . get_the_title() . "</td>";
                    echo "<td>" . get_post_meta($id, 'email', true) . "</td>";
                    echo "<td>" . get_post_meta($id, 'skills', true) . "</td>";
                    echo "<td>" . get_post_meta($id, 'availability', true) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
                wp_reset_postdata();
            } else {
                echo "<p>No volunteers found.</p>";
            }
            ?>
        </div>
        <?php
    }
}
