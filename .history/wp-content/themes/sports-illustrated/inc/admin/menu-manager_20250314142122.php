<?php
/**
 * Restaurant Menus Manager Admin Page
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add Restaurant Menus Manager admin page
 */
function si_add_menu_manager_page() {
    add_theme_page(
        __('Restaurant Menus', 'sports-illustrated'),
        __('Restaurant Menus', 'sports-illustrated'),
        'edit_theme_options',
        'si-menu-manager',
        'si_render_menu_manager_page'
    );
}
add_action('admin_menu', 'si_add_menu_manager_page');

/**
 * Render the Restaurant Menus Manager admin page
 */
function si_render_menu_manager_page() {
    // Check user permissions
    if (!current_user_can('edit_theme_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'sports-illustrated'));
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Restaurant Menus', 'sports-illustrated'); ?></h1>
        
        <div class="menu-manager-container">
            <div class="menu-manager-section">
                <h2><?php echo esc_html__('Manage Your Restaurant Menus', 'sports-illustrated'); ?></h2>
                <p><?php echo esc_html__('Edit your restaurant menus using our intuitive menu editor. Select a menu type below to get started.', 'sports-illustrated'); ?></p>
                
                <div class="menu-manager-cards">
                    <div class="menu-manager-card">
                        <div class="menu-manager-card-header">
                            <h3><?php echo esc_html__('Drinks Menu', 'sports-illustrated'); ?></h3>
                        </div>
                        <div class="menu-manager-card-body">
                            <p><?php echo esc_html__('Manage beverages, including alcoholic and non-alcoholic options.', 'sports-illustrated'); ?></p>
                        </div>
                        <div class="menu-manager-card-footer">
                            <button class="button button-primary si-edit-menu-button" data-menu-type="drinks">
                                <?php echo esc_html__('Edit Drinks Menu', 'sports-illustrated'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <div class="menu-manager-card">
                        <div class="menu-manager-card-header">
                            <h3><?php echo esc_html__('Brunch Menu', 'sports-illustrated'); ?></h3>
                        </div>
                        <div class="menu-manager-card-body">
                            <p><?php echo esc_html__('Manage breakfast and brunch items.', 'sports-illustrated'); ?></p>
                        </div>
                        <div class="menu-manager-card-footer">
                            <button class="button button-primary si-edit-menu-button" data-menu-type="brunch">
                                <?php echo esc_html__('Edit Brunch Menu', 'sports-illustrated'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <div class="menu-manager-card">
                        <div class="menu-manager-card-header">
                            <h3><?php echo esc_html__('Full Menu', 'sports-illustrated'); ?></h3>
                        </div>
                        <div class="menu-manager-card-body">
                            <p><?php echo esc_html__('Manage lunch and dinner items.', 'sports-illustrated'); ?></p>
                        </div>
                        <div class="menu-manager-card-footer">
                            <button class="button button-primary si-edit-menu-button" data-menu-type="full">
                                <?php echo esc_html__('Edit Full Menu', 'sports-illustrated'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div id="si-menu-editor-container" class="si-menu-editor-container" style="display: none;">
                    <!-- Menu editor will be loaded here via AJAX -->
                    <div class="si-menu-editor-loading">
                        <span class="spinner is-active"></span>
                        <p><?php echo esc_html__('Loading menu editor...', 'sports-illustrated'); ?></p>
                    </div>
                </div>
                
                <div class="menu-manager-section-divider"></div>
                
                <h3><?php echo esc_html__('Reset Menu Options', 'sports-illustrated'); ?></h3>
                <p><?php echo esc_html__('Use these buttons to reset menus to their default values. This cannot be undone.', 'sports-illustrated'); ?></p>
                
                <div class="menu-manager-actions menu-manager-reset-actions">
                    <button class="button si-reset-button" data-reset-type="drinks">
                        <?php echo esc_html__('Reset Drinks Menu', 'sports-illustrated'); ?>
                        <span class="spinner"></span>
                    </button>
                    
                    <button class="button si-reset-button" data-reset-type="brunch">
                        <?php echo esc_html__('Reset Brunch Menu', 'sports-illustrated'); ?>
                        <span class="spinner"></span>
                    </button>
                    
                    <button class="button si-reset-button" data-reset-type="full">
                        <?php echo esc_html__('Reset Full Menu', 'sports-illustrated'); ?>
                        <span class="spinner"></span>
                    </button>
                    
                    <button class="button si-reset-button" data-reset-type="all">
                        <?php echo esc_html__('Reset All Menus', 'sports-illustrated'); ?>
                        <span class="spinner"></span>
                    </button>
                </div>
                
                <div class="menu-manager-instructions">
                    <h3><?php echo esc_html__('Menu Instructions', 'sports-illustrated'); ?></h3>
                    <p><?php echo esc_html__('The Sports Illustrated theme includes support for three types of menus:', 'sports-illustrated'); ?></p>
                    <ul>
                        <li><?php echo esc_html__('Brunch Menu - For breakfast and brunch items', 'sports-illustrated'); ?></li>
                        <li><?php echo esc_html__('Full Menu - For lunch and dinner items', 'sports-illustrated'); ?></li>
                        <li><?php echo esc_html__('Drinks Menu - For beverages, including alcoholic and non-alcoholic options', 'sports-illustrated'); ?></li>
                    </ul>
                    <p><?php echo esc_html__('Each menu can have up to 10 sections, and each section can have up to 20 items.', 'sports-illustrated'); ?></p>
                    
                    <h3><?php echo esc_html__('Using Subsections', 'sports-illustrated'); ?></h3>
                    <p><?php echo esc_html__('You can create subsections within each menu section by adding an item and setting its "Notes" field to "subsection". This will display the item as a subsection header.', 'sports-illustrated'); ?></p>
                    <p><?php echo esc_html__('For example, in the Drinks Menu, you might have a "Wine" section with subsections for "Red", "White", and "Sparkling".', 'sports-illustrated'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Enqueue scripts and styles for the Restaurant Menus Manager
 */
function si_enqueue_menu_manager_scripts($hook) {
    // Only load on our menu manager page
    if ('appearance_page_si-menu-manager' !== $hook) {
        return;
    }
    
    // Enqueue dashicons
    wp_enqueue_style('dashicons');
    
    // Enqueue styles
    wp_enqueue_style(
        'si-menu-manager-styles',
        get_template_directory_uri() . '/assets/css/admin/menu-manager.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/admin/menu-manager.css')
    );
    
    // Enqueue scripts
    wp_enqueue_script(
        'si-menu-manager-scripts',
        get_template_directory_uri() . '/assets/js/admin/menu-manager.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/admin/menu-manager.js'),
        true
    );
    
    // Localize script
    wp_localize_script('si-menu-manager-scripts', 'siMenuManager', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('si_menu_manager_nonce'),
        'loadingText' => __('Loading...', 'sports-illustrated'),
        'savingText' => __('Saving...', 'sports-illustrated'),
        'confirmReset' => __('Are you sure you want to reset this menu? This cannot be undone.', 'sports-illustrated'),
        'confirmCancel' => __('Are you sure you want to cancel? Any unsaved changes will be lost.', 'sports-illustrated')
    ));
}
add_action('admin_enqueue_scripts', 'si_enqueue_menu_manager_scripts');

/**
 * Include the menu editor functionality
 */
require_once get_template_directory() . '/inc/admin/menu-editor.php'; 