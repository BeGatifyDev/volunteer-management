<?php
/**
 * Plugin Name: Volunteer Management
 * Description: Manage volunteers with registration, admin dashboard, CSV export, and REST API.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: volunteer-management
 */

defined('ABSPATH') || exit;

define('VM_PATH', plugin_dir_path(__FILE__));
define('VM_URL', plugin_dir_url(__FILE__));

// Includes
require_once VM_PATH . 'includes/class-vm-init.php';

use VM\Common\VM_Init;

new VM_Init();
