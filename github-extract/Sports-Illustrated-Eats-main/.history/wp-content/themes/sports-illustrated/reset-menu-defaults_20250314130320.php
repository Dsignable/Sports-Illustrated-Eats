<?php
/**
 * Reset Menu Defaults Script
 * 
 * This script redirects to the new Menu Manager page.
 */

// Load WordPress
require_once(dirname(dirname(dirname(__FILE__))) . '/wp-load.php');

// Check if user is logged in and has permissions
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

// Redirect to the new menu manager page
wp_redirect(admin_url('themes.php?page=menu-manager'));
exit;
?> 