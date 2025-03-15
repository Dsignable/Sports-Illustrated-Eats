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
 * 
 * @return array Response data
 */
function si_reset_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        return array(
            'success' => false,
            'message' => __('You do not have sufficient permissions to access this page.', 'sports-illustrated')
        );
    }
    
    // Delete the option to allow the defaults to be set again
    delete_option('si_default_menus_set');
    
    // Call the function to set defaults
    si_set_default_menu_values();
    
    return array(
        'success' => true,
        'message' => __('All menus have been reset to default values.', 'sports-illustrated'),
        'redirect' => admin_url('customize.php')
    );
}

/**
 * Reset drinks menu defaults only
 *
 * @return array Response data
 */
function si_reset_drinks_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        return array(
            'success' => false,
            'message' => __('You do not have sufficient permissions to access this page.', 'sports-illustrated')
        );
    }
    
    // Set drinks menu default values
    si_set_drinks_menu_defaults();
    
    return array(
        'success' => true,
        'message' => __('Drinks menu has been reset to default values.', 'sports-illustrated'),
        'redirect' => admin_url('customize.php?autofocus[section]=si_written_menu_drinks_section')
    );
}

/**
 * Reset brunch menu defaults only
 *
 * @return array Response data
 */
function si_reset_brunch_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        return array(
            'success' => false,
            'message' => __('You do not have sufficient permissions to access this page.', 'sports-illustrated')
        );
    }
    
    // Set brunch menu default values
    si_set_brunch_menu_defaults();
    
    return array(
        'success' => true,
        'message' => __('Brunch menu has been reset to default values.', 'sports-illustrated'),
        'redirect' => admin_url('customize.php?autofocus[section]=si_written_menu_brunch_section')
    );
}

/**
 * Reset full menu defaults only
 *
 * @return array Response data
 */
function si_reset_full_menu_defaults() {
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        return array(
            'success' => false,
            'message' => __('You do not have sufficient permissions to access this page.', 'sports-illustrated')
        );
    }
    
    // Set full menu default values
    si_set_full_menu_defaults();
    
    return array(
        'success' => true,
        'message' => __('Full menu has been reset to default values.', 'sports-illustrated'),
        'redirect' => admin_url('customize.php?autofocus[section]=si_written_menu_full_section')
    );
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

/**
 * Set drinks menu defaults
 */
function si_set_drinks_menu_defaults() {
    global $drinks_defaults;
    
    // Include the drinks menu defaults file if not already included
    if (!isset($drinks_defaults)) {
        require_once get_template_directory() . '/drinks_menu_defaults.php';
    }
    
    // Set default values for drinks menu
    foreach ($drinks_defaults as $key => $value) {
        set_theme_mod($key, $value);
    }
}

/**
 * AJAX handler for menu reset
 */
function si_ajax_reset_menu() {
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'si_menu_manager_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'sports-illustrated')));
    }
    
    // Get reset type
    $reset_type = isset($_POST['reset_type']) ? sanitize_text_field($_POST['reset_type']) : '';
    
    // Reset based on type
    switch ($reset_type) {
        case 'drinks':
            $result = si_reset_drinks_menu_defaults();
            break;
        case 'brunch':
            $result = si_reset_brunch_menu_defaults();
            break;
        case 'full':
            $result = si_reset_full_menu_defaults();
            break;
        case 'all':
            $result = si_reset_menu_defaults();
            break;
        default:
            $result = array(
                'success' => false,
                'message' => __('Invalid reset type.', 'sports-illustrated')
            );
            break;
    }
    
    // Send response
    if ($result['success']) {
        wp_send_json_success(array(
            'message' => $result['message'],
            'redirect' => isset($result['redirect']) ? $result['redirect'] : ''
        ));
    } else {
        wp_send_json_error(array('message' => $result['message']));
    }
}
add_action('wp_ajax_si_reset_menu', 'si_ajax_reset_menu');

// The admin menu items have been moved to the Restaurant Menus Manager page
// and are now handled via AJAX to prevent header warnings 