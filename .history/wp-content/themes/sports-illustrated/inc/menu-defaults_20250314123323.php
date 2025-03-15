<?php
/**
 * Menu Defaults
 *
 * This file includes all menu default arrays and provides a function to access them.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include menu default files
require_once get_template_directory() . '/brunch_menu_defaults.php';
require_once get_template_directory() . '/full_menu_defaults.php';
require_once get_template_directory() . '/inc/drinks_menu_defaults.php';

/**
 * Get menu defaults for a specific menu type
 *
 * @param string $menu_type The menu type (brunch, full, drinks)
 * @return array The menu defaults array
 */
function si_get_menu_defaults($menu_type) {
    global $brunch_defaults, $full_defaults, $drinks_defaults;
    
    switch ($menu_type) {
        case 'brunch':
            return $brunch_defaults;
        case 'full':
            return $full_defaults;
        case 'drinks':
            return $drinks_defaults;
        default:
            return array();
    }
}

/**
 * Set default menu values
 */
function si_set_default_menu_values() {
    global $brunch_defaults, $full_defaults, $drinks_defaults;
    
    // Only run this once
    if (get_option('si_default_menus_set')) {
        return;
    }
    
    // Set default values for brunch menu
    foreach ($brunch_defaults as $key => $value) {
        set_theme_mod($key, $value);
    }
    
    // Set default values for drinks menu using the new function
    si_set_drinks_menu_defaults();
    
    // Set default values for full menu
    foreach ($full_defaults as $key => $value) {
        set_theme_mod($key, $value);
    }
    
    // Mark as set so we don't overwrite user changes
    update_option('si_default_menus_set', true);
}
add_action('after_switch_theme', 'si_set_default_menu_values'); 