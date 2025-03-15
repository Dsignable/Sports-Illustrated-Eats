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
 * Add admin menu item to reset menu defaults
 */
function si_add_reset_menu_defaults_button() {
    add_submenu_page(
        'themes.php',
        __('Reset Menu Defaults', 'sports-illustrated'),
        __('Reset Menu Defaults', 'sports-illustrated'),
        'edit_theme_options',
        'reset-menu-defaults',
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
        __('Reset Menu Manager', 'sports-illustrated'),
        __('Reset Menu Manager', 'sports-illustrated'),
        'edit_theme_options',
        'direct-reset-menu-defaults',
        'si_register_direct_reset_page'
    );
    
    // Add submenu for resetting drinks menu only
    add_submenu_page(
        'themes.php',
        __('Reset Drinks Menu', 'sports-illustrated'),
        __('Reset Drinks Menu', 'sports-illustrated'),
        'edit_theme_options',
        'reset-drinks-menu',
        'si_reset_drinks_menu_defaults'
    );
}
add_action('admin_menu', 'si_add_direct_reset_menu_defaults_link');

/**
 * Register the direct reset page
 */
function si_register_direct_reset_page() {
    // Redirect to menu manager page
    wp_redirect(admin_url('themes.php?page=menu-manager'));
    exit;
} 