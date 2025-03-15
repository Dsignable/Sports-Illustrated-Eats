<?php
/**
 * Menu Manager Integration
 *
 * Integrates the Menu Manager class with WordPress and removes old menu reset functions.
 *
 * @package Sports_Illustrated
 */

declare(strict_types=1);

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the Menu Manager class
require_once get_template_directory() . '/inc/class-si-menu-manager.php';

// Remove old menu reset functions from admin menu
add_action('admin_menu', function() {
    // Remove the old menu items
    remove_submenu_page('themes.php', 'si-reset-menu-defaults');
    remove_submenu_page('themes.php', 'admin.php?page=si-direct-reset-menu-defaults');
}, 100);

// Redirect old reset pages to the new menu manager
add_action('admin_init', function() {
    global $pagenow;
    
    // Check if we're on the old reset pages
    if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'si-direct-reset-menu-defaults') {
        wp_redirect(admin_url('themes.php?page=si-menu-manager'));
        exit;
    }
    
    if ($pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'si-reset-menu-defaults') {
        wp_redirect(admin_url('themes.php?page=si-menu-manager'));
        exit;
    }
}); 