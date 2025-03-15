<?php
/**
 * Menu Reset Functions
 *
 * This file includes functions for resetting menu defaults.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Reset the written menu defaults for testing purposes
 */
function si_reset_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'sports-illustrated'));
    }
    
    // Delete the option to allow the defaults to be set again
    delete_option('si_default_menus_set');
    
    // Call the function to set defaults
    si_set_default_menu_values();
    
    // Redirect back to the customizer
    wp_redirect(admin_url('customize.php'));
    exit;
}

/**
 * Reset drinks menu defaults only
 *
 * This function checks user permissions, calls the function to set drinks menu default values,
 * and redirects to the customizer.
 */
function si_reset_drinks_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'sports-illustrated'));
    }
    
    // Set drinks menu default values
    si_set_drinks_menu_defaults();
    
    // Redirect back to customizer
    wp_redirect(admin_url('customize.php?autofocus[section]=si_written_menu_drinks_section'));
    exit;
}

// The admin menu items have been removed to prevent header warnings
// The functions are still available for programmatic use 