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

/**
 * Reset brunch menu defaults only
 *
 * This function checks user permissions, calls the function to set brunch menu default values.
 */
function si_reset_brunch_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'sports-illustrated'));
    }
    
    // Set brunch menu default values
    si_set_brunch_menu_defaults();
}

/**
 * Reset full menu defaults only
 *
 * This function checks user permissions, calls the function to set full menu default values.
 */
function si_reset_full_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'sports-illustrated'));
    }
    
    // Set full menu default values
    si_set_full_menu_defaults();
}

/**
 * Set brunch menu defaults
 */
function si_set_brunch_menu_defaults() {
    global $brunch_defaults;
    
    // Include the brunch menu defaults file if not already included
    if (!isset($brunch_defaults)) {
        require_once get_template_directory() . '/brunch_menu_defaults.php';
    }
    
    // Set default values for brunch menu
    foreach ($brunch_defaults as $key => $value) {
        set_theme_mod($key, $value);
    }
}

/**
 * Set full menu defaults
 */
function si_set_full_menu_defaults() {
    global $full_defaults;
    
    // Include the full menu defaults file if not already included
    if (!isset($full_defaults)) {
        require_once get_template_directory() . '/full_menu_defaults.php';
    }
    
    // Set default values for full menu
    foreach ($full_defaults as $key => $value) {
        set_theme_mod($key, $value);
    }
}

// The admin menu items have been removed to prevent header warnings
// The functions are still available for programmatic use 