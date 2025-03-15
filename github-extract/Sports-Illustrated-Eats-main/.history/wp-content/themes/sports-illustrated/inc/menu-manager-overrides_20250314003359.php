<?php
/**
 * Menu Manager Overrides
 *
 * This file overrides the old menu reset functions to remove them from the admin menu.
 *
 * @package Sports_Illustrated
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove old menu reset functions from admin menu
 */
function si_remove_old_menu_reset_functions() {
    // Remove the action hooks for the old menu reset functions
    remove_action('admin_menu', 'si_add_reset_menu_defaults_button');
    remove_action('admin_menu', 'si_add_direct_reset_menu_defaults_link');
    remove_action('admin_menu', 'si_register_direct_reset_page');
}
add_action('admin_menu', 'si_remove_old_menu_reset_functions', 5);

/**
 * Override the old menu reset functions to do nothing
 */
if (!function_exists('si_add_reset_menu_defaults_button')) {
    function si_add_reset_menu_defaults_button() {
        // Do nothing
    }
}

if (!function_exists('si_add_direct_reset_menu_defaults_link')) {
    function si_add_direct_reset_menu_defaults_link() {
        // Do nothing
    }
}

if (!function_exists('si_register_direct_reset_page')) {
    function si_register_direct_reset_page() {
        // Do nothing
    }
} 