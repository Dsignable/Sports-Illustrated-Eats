<?php
/**
 * Reset Drinks Menu Script
 *
 * This script manually resets the drinks menu defaults.
 * To use, visit /wp-admin/themes.php?page=si-menu-manager&reset_drinks=1
 *
 * @package Sports_Illustrated
 */

// Add a query parameter hook to reset the drinks menu
function si_manual_reset_drinks_menu() {
    if (isset($_GET['reset_drinks']) && $_GET['reset_drinks'] == 1 && current_user_can('edit_theme_options')) {
        // Include necessary files
        require_once get_template_directory() . '/inc/menu-reset-functions.php';
        
        // Reset drinks menu
        $result = si_reset_drinks_menu_defaults();
        
        // Add admin notice
        if ($result['success']) {
            add_action('admin_notices', 'si_drinks_menu_reset_success_notice');
        } else {
            add_action('admin_notices', 'si_drinks_menu_reset_error_notice');
        }
    }
}
add_action('admin_init', 'si_manual_reset_drinks_menu');

// Success notice
function si_drinks_menu_reset_success_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e('Drinks menu has been reset to default values.', 'sports-illustrated'); ?></p>
    </div>
    <?php
}

// Error notice
function si_drinks_menu_reset_error_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e('Failed to reset drinks menu. Please check the error log for details.', 'sports-illustrated'); ?></p>
    </div>
    <?php
} 