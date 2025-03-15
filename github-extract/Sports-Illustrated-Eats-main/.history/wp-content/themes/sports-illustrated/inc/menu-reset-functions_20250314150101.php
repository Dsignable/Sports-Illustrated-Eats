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

// Make sure the drinks menu defaults function is available
if (!function_exists('si_set_drinks_menu_defaults')) {
    require_once get_template_directory() . '/inc/drinks_menu_defaults.php';
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
    // Debug log
    error_log('si_reset_drinks_menu_defaults called');
    
    // Check if user has permission
    if (!current_user_can('edit_theme_options')) {
        error_log('User does not have permission to reset drinks menu');
        return array(
            'success' => false,
            'message' => __('You do not have sufficient permissions to access this page.', 'sports-illustrated')
        );
    }
    
    // Check if si_set_drinks_menu_defaults function exists
    if (!function_exists('si_set_drinks_menu_defaults')) {
        error_log('si_set_drinks_menu_defaults function does not exist, attempting to load it');
        
        // Try to include the file from the inc directory
        $inc_file = get_template_directory() . '/inc/drinks_menu_defaults.php';
        if (file_exists($inc_file)) {
            require_once $inc_file;
            error_log('Loaded drinks_menu_defaults.php from inc directory');
        } else {
            error_log('inc/drinks_menu_defaults.php does not exist');
            
            // Try to include the file from the root directory
            $root_file = get_template_directory() . '/drinks_menu_defaults.php';
            if (file_exists($root_file)) {
                require_once $root_file;
                error_log('Loaded drinks_menu_defaults.php from root directory');
            } else {
                error_log('drinks_menu_defaults.php does not exist in root directory');
                return array(
                    'success' => false,
                    'message' => __('Failed to load drinks menu defaults file.', 'sports-illustrated')
                );
            }
        }
        
        if (!function_exists('si_set_drinks_menu_defaults')) {
            error_log('Failed to load si_set_drinks_menu_defaults function');
            return array(
                'success' => false,
                'message' => __('Failed to load drinks menu defaults function.', 'sports-illustrated')
            );
        }
    }
    
    // Set drinks menu default values
    try {
        // Get the global drinks_defaults array
        global $drinks_defaults;
        
        // Check if the array is available
        if (!isset($drinks_defaults) || !is_array($drinks_defaults)) {
            error_log('$drinks_defaults array is not available');
            
            // Try to call the function anyway
            si_set_drinks_menu_defaults();
        } else {
            error_log('Setting drinks menu defaults using array');
            
            // Set each theme mod directly from the array
            foreach ($drinks_defaults as $key => $value) {
                set_theme_mod($key, $value);
            }
        }
        
        error_log('Drinks menu reset successful');
        return array(
            'success' => true,
            'message' => __('Drinks menu has been reset to default values.', 'sports-illustrated'),
            'redirect' => admin_url('customize.php?autofocus[section]=si_written_menu_drinks_section')
        );
    } catch (Exception $e) {
        error_log('Error resetting drinks menu: ' . $e->getMessage());
        return array(
            'success' => false,
            'message' => __('Error resetting drinks menu: ', 'sports-illustrated') . $e->getMessage()
        );
    }
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
 * AJAX handler for menu reset
 */
function si_ajax_reset_menu() {
    // Debug log
    error_log('si_ajax_reset_menu called');
    
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'si_menu_manager_nonce')) {
        error_log('Security check failed: ' . (isset($_POST['security']) ? $_POST['security'] : 'not set'));
        wp_send_json_error(array('message' => __('Security check failed.', 'sports-illustrated')));
        return;
    }
    
    // Get reset type
    $reset_type = isset($_POST['reset_type']) ? sanitize_text_field($_POST['reset_type']) : '';
    error_log('Reset type: ' . $reset_type);
    
    if (empty($reset_type)) {
        error_log('Empty reset type');
        wp_send_json_error(array('message' => __('Reset type not specified.', 'sports-illustrated')));
        return;
    }
    
    // Reset based on type
    try {
        switch ($reset_type) {
            case 'drinks':
                error_log('Resetting drinks menu');
                $result = si_reset_drinks_menu_defaults();
                break;
            case 'brunch':
                error_log('Resetting brunch menu');
                $result = si_reset_brunch_menu_defaults();
                break;
            case 'full':
                error_log('Resetting full menu');
                $result = si_reset_full_menu_defaults();
                break;
            case 'all':
                error_log('Resetting all menus');
                $result = si_reset_menu_defaults();
                break;
            default:
                error_log('Invalid reset type: ' . $reset_type);
                wp_send_json_error(array('message' => __('Invalid reset type.', 'sports-illustrated')));
                return;
        }
        
        // Send response
        if ($result['success']) {
            error_log('Reset successful: ' . $result['message']);
            wp_send_json_success(array(
                'message' => $result['message'],
                'redirect' => isset($result['redirect']) ? $result['redirect'] : ''
            ));
        } else {
            error_log('Reset failed: ' . $result['message']);
            wp_send_json_error(array('message' => $result['message']));
        }
    } catch (Exception $e) {
        error_log('Exception during reset: ' . $e->getMessage());
        wp_send_json_error(array('message' => __('An error occurred during the reset process.', 'sports-illustrated')));
    }
}
add_action('wp_ajax_si_reset_menu', 'si_ajax_reset_menu');

// The admin menu items have been moved to the Restaurant Menus Manager page
// and are now handled via AJAX to prevent header warnings 