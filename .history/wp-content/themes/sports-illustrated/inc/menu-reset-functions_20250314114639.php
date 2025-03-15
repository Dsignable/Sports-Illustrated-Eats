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
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Delete the option to allow the defaults to be set again
    delete_option('si_default_menus_set');
    
    // Call the function to set defaults
    si_set_default_menu_values();
    
    // Redirect back to the customizer
    wp_redirect(admin_url('customize.php?autofocus[section]=si_menu_display_section'));
    exit;
}

/**
 * Add admin menu item to reset menu defaults
 */
function si_add_reset_menu_defaults_button() {
    add_submenu_page(
        'themes.php',
        __('Reset Menu Defaults', 'sports-illustrated'),
        __('Reset Menu Defaults', 'sports-illustrated'),
        'manage_options',
        'si-reset-menu-defaults',
        'si_reset_menu_defaults'
    );
}
add_action('admin_menu', 'si_add_reset_menu_defaults_button');

/**
 * Add a direct link to reset menu defaults without redirection
 */
function si_add_direct_reset_menu_defaults_link() {
    add_submenu_page(
        'themes.php',
        __('Reset Menu Defaults (Direct)', 'sports-illustrated'),
        __('Reset Menu Defaults (Direct)', 'sports-illustrated'),
        'manage_options',
        'admin.php?page=si-direct-reset-menu-defaults',
        ''
    );
}
add_action('admin_menu', 'si_add_direct_reset_menu_defaults_link');

/**
 * Register the direct reset page
 */
function si_register_direct_reset_page() {
    add_submenu_page(
        null, // No parent
        __('Reset Menu Defaults', 'sports-illustrated'),
        __('Reset Menu Defaults', 'sports-illustrated'),
        'manage_options',
        'si-direct-reset-menu-defaults',
        'si_direct_reset_menu_defaults_callback'
    );
}
add_action('admin_menu', 'si_register_direct_reset_page');

/**
 * Callback for the direct reset page
 */
function si_direct_reset_menu_defaults_callback() {
    // Redirect to the new menu manager page
    wp_redirect(admin_url('themes.php?page=si-menu-manager'));
    exit;
} 