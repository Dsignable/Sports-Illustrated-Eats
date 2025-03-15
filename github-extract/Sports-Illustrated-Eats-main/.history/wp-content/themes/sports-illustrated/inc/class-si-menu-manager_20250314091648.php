<?php
/**
 * Sports Illustrated Menu Manager
 *
 * Provides an intuitive interface for managing menu defaults and settings
 *
 * @package Sports_Illustrated
 */

declare(strict_types=1);

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SI_Menu_Manager Class
 * 
 * Handles menu management functionality including resetting menu defaults
 */
class SI_Menu_Manager {
    
    /**
     * Instance of this class
     *
     * @var SI_Menu_Manager
     */
    private static $instance = null;
    
    /**
     * Menu types available for management
     *
     * @var array
     */
    private $menu_types = array(
        'full'   => 'Full Menu',
        'drinks' => 'Drinks Menu',
        'brunch' => 'Brunch Menu',
    );
    
    /**
     * Constructor
     */
    private function __construct() {
        // Add hooks
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_si_reset_menu', array($this, 'ajax_reset_menu'));
    }
    
    /**
     * Get instance of this class
     *
     * @return SI_Menu_Manager
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Add menu management page to WordPress admin
     */
    public function add_menu_page() {
        add_submenu_page(
            'themes.php',
            __('Menu Manager', 'sports-illustrated'),
            __('Menu Manager', 'sports-illustrated'),
            'manage_options',
            'si-menu-manager',
            array($this, 'render_menu_page')
        );
    }
    
    /**
     * Enqueue assets for the menu manager page
     *
     * @param string $hook Current admin page
     */
    public function enqueue_assets($hook) {
        if ('appearance_page_si-menu-manager' !== $hook) {
            return;
        }
        
        // Enqueue styles
        wp_enqueue_style(
            'si-menu-manager',
            get_template_directory_uri() . '/assets/css/admin/menu-manager.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/admin/menu-manager.css')
        );
        
        // Enqueue scripts
        wp_enqueue_script(
            'si-menu-manager',
            get_template_directory_uri() . '/assets/js/admin/menu-manager.js',
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/admin/menu-manager.js'),
            true
        );
        
        // Localize script
        wp_localize_script('si-menu-manager', 'siMenuManager', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('si-menu-manager-nonce'),
            'confirmReset' => __('Are you sure you want to reset this menu to default values? This action cannot be undone.', 'sports-illustrated'),
            'confirmResetAll' => __('Are you sure you want to reset ALL menus to default values? This action cannot be undone.', 'sports-illustrated'),
        ));
    }
    
    /**
     * Render the menu management page
     */
    public function render_menu_page() {
        ?>
        <div class="wrap si-menu-manager">
            <h1><?php esc_html_e('Sports Illustrated Menu Manager', 'sports-illustrated'); ?></h1>
            
            <div class="si-menu-manager-intro">
                <p><?php esc_html_e('This page allows you to manage your restaurant menus. You can reset individual menus to their default values or reset all menus at once.', 'sports-illustrated'); ?></p>
                <p><?php esc_html_e('After resetting a menu, you can customize it in the WordPress Customizer.', 'sports-illustrated'); ?></p>
            </div>
            
            <div class="si-menu-manager-actions">
                <h2><?php esc_html_e('Reset Menu Defaults', 'sports-illustrated'); ?></h2>
                
                <div class="si-menu-cards">
                    <?php foreach ($this->menu_types as $menu_key => $menu_label) : ?>
                        <div class="si-menu-card">
                            <div class="si-menu-card-header">
                                <h3><?php echo esc_html($menu_label); ?></h3>
                            </div>
                            <div class="si-menu-card-body">
                                <p><?php printf(esc_html__('Reset the %s to default values.', 'sports-illustrated'), esc_html($menu_label)); ?></p>
                            </div>
                            <div class="si-menu-card-footer">
                                <button class="button button-primary si-reset-menu" data-menu="<?php echo esc_attr($menu_key); ?>">
                                    <?php printf(esc_html__('Reset %s', 'sports-illustrated'), esc_html($menu_label)); ?>
                                </button>
                                <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=si_menu_display_section')); ?>" class="button">
                                    <?php esc_html_e('Customize', 'sports-illustrated'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="si-menu-card si-menu-card-all">
                        <div class="si-menu-card-header">
                            <h3><?php esc_html_e('All Menus', 'sports-illustrated'); ?></h3>
                        </div>
                        <div class="si-menu-card-body">
                            <p><?php esc_html_e('Reset all menus to their default values.', 'sports-illustrated'); ?></p>
                        </div>
                        <div class="si-menu-card-footer">
                            <button class="button button-primary si-reset-all-menus">
                                <?php esc_html_e('Reset All Menus', 'sports-illustrated'); ?>
                            </button>
                            <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=si_menu_display_section')); ?>" class="button">
                                <?php esc_html_e('Customize', 'sports-illustrated'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="si-menu-reset-response" class="si-menu-reset-response" style="display: none;"></div>
        </div>
        <?php
    }
    
    /**
     * Handle AJAX request to reset menu
     */
    public function ajax_reset_menu() {
        // Check nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'si-menu-manager-nonce')) {
            error_log("SI Menu Manager: Security check failed");
            wp_send_json_error(array(
                'message' => __('Security check failed.', 'sports-illustrated'),
            ));
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            error_log("SI Menu Manager: Permission check failed");
            wp_send_json_error(array(
                'message' => __('You do not have permission to perform this action.', 'sports-illustrated'),
            ));
        }
        
        // Get menu type
        $menu_type = isset($_POST['menu']) ? sanitize_text_field($_POST['menu']) : 'all';
        error_log("SI Menu Manager: Received request to reset menu type: {$menu_type}");
        
        // Reset menu(s)
        if ('all' === $menu_type) {
            $result = $this->reset_all_menus();
            $message = __('All menus have been reset to their default values.', 'sports-illustrated');
        } else {
            // Handle legacy 'drink' type (without 's')
            if ($menu_type === 'drink') {
                $menu_type = 'drinks';
                error_log("SI Menu Manager: Normalized 'drink' to 'drinks'");
            }
            
            $result = $this->reset_menu($menu_type);
            if (!$result) {
                error_log("SI Menu Manager: Failed to reset menu type: {$menu_type}");
                wp_send_json_error(array(
                    'message' => __('Invalid menu type or error resetting menu.', 'sports-illustrated'),
                ));
                return;
            }
            $menu_label = isset($this->menu_types[$menu_type]) ? $this->menu_types[$menu_type] : $menu_type;
            $message = sprintf(__('%s has been reset to default values.', 'sports-illustrated'), $menu_label);
        }
        
        error_log("SI Menu Manager: Successfully reset menu type: {$menu_type}");
        
        // Send success response
        wp_send_json_success(array(
            'message' => $message,
        ));
    }
    
    /**
     * Reset a specific menu to default values
     *
     * @param string $menu_type Menu type to reset
     */
    private function reset_menu($menu_type) {
        // Validate menu type
        if (!isset($this->menu_types[$menu_type])) {
            error_log("SI Menu Manager: Invalid menu type: {$menu_type}");
            return false;
        }
        
        error_log("SI Menu Manager: Resetting menu type: {$menu_type}");
        
        // Get all theme mods
        $theme_mods = get_theme_mods();
        
        // Backup all menu settings except the one we're resetting
        $backup = array();
        foreach ($theme_mods as $key => $value) {
            if (strpos($key, 'si_written_menu_') === 0 && 
                strpos($key, "si_written_menu_{$menu_type}_") !== 0) {
                $backup[$key] = $value;
            }
        }
        
        error_log("SI Menu Manager: Backed up " . count($backup) . " theme mods");
        
        // Find and remove all theme mods for this menu type
        $removed = 0;
        foreach ($theme_mods as $key => $value) {
            if (strpos($key, "si_written_menu_{$menu_type}_") === 0) {
                remove_theme_mod($key);
                $removed++;
            }
        }
        
        error_log("SI Menu Manager: Removed {$removed} theme mods for menu type: {$menu_type}");
        
        // Delete the option to allow defaults to be set again
        delete_option('si_default_menus_set');
        
        // Call the function to set defaults
        if (function_exists('si_set_default_menu_values')) {
            error_log("SI Menu Manager: Setting default menu values");
            si_set_default_menu_values();
            
            // Restore the backed up menu settings
            foreach ($backup as $key => $value) {
                set_theme_mod($key, $value);
            }
            
            error_log("SI Menu Manager: Restored " . count($backup) . " theme mods");
            return true;
        }
        
        error_log("SI Menu Manager: si_set_default_menu_values function not found");
        return false;
    }
    
    /**
     * Reset all menus to default values
     */
    private function reset_all_menus() {
        error_log("SI Menu Manager: Resetting all menus");
        
        // Delete the option to allow defaults to be set again
        delete_option('si_default_menus_set');
        
        // Call the function to set defaults
        if (function_exists('si_set_default_menu_values')) {
            error_log("SI Menu Manager: Setting default values for all menus");
            si_set_default_menu_values();
            error_log("SI Menu Manager: Successfully reset all menus");
            return true;
        }
        
        error_log("SI Menu Manager: si_set_default_menu_values function not found");
        return false;
    }
    
    /**
     * Set defaults for a specific menu type
     *
     * @param string $menu_type Menu type to set defaults for
     */
    private function set_menu_defaults($menu_type) {
        // This method is no longer used as we're using a different approach
        // for individual menu resets
    }
}

// Initialize the menu manager
SI_Menu_Manager::get_instance(); 