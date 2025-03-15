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
        __('Restaurant Menus Manager', 'sports-illustrated'),
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
        <h1><?php echo esc_html__('Restaurant Menus Manager', 'sports-illustrated'); ?></h1>
        
        <div class="menu-manager-container">
            <div class="menu-manager-section">
                <h2><?php echo esc_html__('Written Menus', 'sports-illustrated'); ?></h2>
                <p><?php echo esc_html__('Manage your restaurant menus through the WordPress Customizer.', 'sports-illustrated'); ?></p>
                
                <div class="menu-manager-actions">
                    <a href="<?php echo esc_url(admin_url('customize.php?autofocus[panel]=si_menus_panel')); ?>" class="button button-primary">
                        <?php echo esc_html__('Edit Restaurant Menus', 'sports-illustrated'); ?>
                    </a>
                    
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
        'security' => wp_create_nonce('si_menu_manager_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'si_enqueue_menu_manager_scripts'); 