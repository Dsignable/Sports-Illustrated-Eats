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
$inc_brunch_file = get_template_directory() . '/inc/brunch_menu_defaults.php';
$inc_full_file = get_template_directory() . '/inc/full_menu_defaults.php';
$inc_drinks_file = get_template_directory() . '/inc/drinks_menu_defaults.php';

// Debug log
error_log('Loading menu defaults');

// Load brunch menu defaults
if (file_exists($inc_brunch_file)) {
    require_once $inc_brunch_file;
    error_log('Loaded brunch menu defaults from inc directory');
} else {
    error_log('Could not find brunch menu defaults file');
}

// Load full menu defaults
if (file_exists($inc_full_file)) {
    require_once $inc_full_file;
    error_log('Loaded full menu defaults from inc directory');
} else {
    error_log('Could not find full menu defaults file');
}

// Load drinks menu defaults
if (file_exists($inc_drinks_file)) {
    require_once $inc_drinks_file;
    error_log('Loaded drinks menu defaults from inc directory');
} else {
    error_log('Could not find drinks menu defaults file');
}

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
            return isset($brunch_defaults) ? $brunch_defaults : array();
        case 'full':
            return isset($full_defaults) ? $full_defaults : array();
        case 'drinks':
            return isset($drinks_defaults) ? $drinks_defaults : array();
        default:
            return array();
    }
}

/**
 * Set default menu values
 */
function si_set_default_menu_values() {
    global $brunch_defaults, $full_defaults, $drinks_defaults;
    
    // Debug log
    error_log('Setting default menu values');
    
    // Only run this once
    if (get_option('si_default_menus_set')) {
        error_log('Default menus already set, skipping');
        return;
    }
    
    // Set default values for brunch menu
    if (isset($brunch_defaults) && is_array($brunch_defaults)) {
        foreach ($brunch_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
    }
    
    // Set default values for drinks menu
    if (function_exists('si_set_drinks_menu_defaults')) {
        error_log('Calling si_set_drinks_menu_defaults function');
        si_set_drinks_menu_defaults();
    } elseif (isset($drinks_defaults) && is_array($drinks_defaults)) {
        error_log('Setting drinks menu defaults from array');
        foreach ($drinks_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
    }
    
    // Set default values for full menu
    if (isset($full_defaults) && is_array($full_defaults)) {
        foreach ($full_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
    }
    
    // Mark as set so we don't overwrite user changes
    update_option('si_default_menus_set', true);
    error_log('Default menus set successfully');
}
add_action('after_switch_theme', 'si_set_default_menu_values'); 