<?php
/**
 * Reset Menu Defaults Script
 * 
 * This script manually resets the menu defaults by deleting the option
 * and calling the function directly.
 */

// Load WordPress
require_once(dirname(dirname(dirname(__FILE__))) . '/wp-load.php');

// Check if user is logged in and has permissions
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

// Delete the option to allow defaults to be set again
delete_option('si_default_menus_set');

// Call the function to set defaults
if (function_exists('si_set_default_menu_values')) {
    si_set_default_menu_values();
    echo '<div style="background-color: #dff0d8; color: #3c763d; padding: 15px; margin: 15px 0; border: 1px solid #d6e9c6; border-radius: 4px;">';
    echo '<h3>Menu Defaults Reset Successfully</h3>';
    echo '<p>All menu defaults have been reset. You can now go back to the <a href="' . admin_url('customize.php?autofocus[section]=si_menu_display_section') . '">Customizer</a> to see the changes.</p>';
    echo '</div>';
} else {
    echo '<div style="background-color: #f2dede; color: #a94442; padding: 15px; margin: 15px 0; border: 1px solid #ebccd1; border-radius: 4px;">';
    echo '<h3>Error</h3>';
    echo '<p>The function to set menu defaults could not be found. Please contact your theme developer.</p>';
    echo '</div>';
}

// Add link back to admin
echo '<p><a href="' . admin_url() . '" class="button">Return to Dashboard</a></p>';
?> 