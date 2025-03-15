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

/**
 * Menu Defaults Manager Class
 */
class SI_Menu_Defaults {
    /**
     * Instance of this class.
     *
     * @var SI_Menu_Defaults
     */
    private static $instance = null;

    /**
     * Menu defaults arrays
     */
    private $brunch_defaults = array();
    private $full_defaults = array();
    private $drinks_defaults = array();

    /**
     * Get an instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->load_menu_defaults();
        
        // Add hooks
        add_action('after_switch_theme', array($this, 'set_default_menu_values'));
        add_action('switch_theme', array($this, 'cleanup_theme_mods'));
    }

    /**
     * Load all menu defaults
     */
    private function load_menu_defaults() {
        $theme_dir = trailingslashit(get_template_directory());
        $inc_dir = $theme_dir . 'inc/';
        
        // Debug log
        error_log('Loading menu defaults from: ' . $inc_dir);
        
        // Load brunch menu defaults
        $brunch_file = $inc_dir . 'brunch_menu_defaults.php';
        if (file_exists($brunch_file)) {
            require_once $brunch_file;
            if (isset($brunch_defaults)) {
                $this->brunch_defaults = $brunch_defaults;
                error_log('Loaded brunch menu defaults');
            }
        }
        
        // Load full menu defaults
        $full_file = $inc_dir . 'full_menu_defaults.php';
        if (file_exists($full_file)) {
            require_once $full_file;
            if (isset($full_defaults)) {
                $this->full_defaults = $full_defaults;
                error_log('Loaded full menu defaults');
            }
        }
        
        // Load drinks menu defaults
        $drinks_file = $inc_dir . 'drinks_menu_defaults.php';
        if (file_exists($drinks_file)) {
            require_once $drinks_file;
            if (isset($drinks_defaults)) {
                $this->drinks_defaults = $drinks_defaults;
                error_log('Loaded drinks menu defaults');
            }
        }
    }

    /**
     * Get menu defaults for a specific menu type
     *
     * @param string $menu_type The menu type (brunch, full, drinks)
     * @return array The menu defaults array
     */
    public function get_menu_defaults($menu_type) {
        switch ($menu_type) {
            case 'brunch':
                return $this->brunch_defaults;
            case 'full':
                return $this->full_defaults;
            case 'drinks':
                return $this->drinks_defaults;
            default:
                return array();
        }
    }

    /**
     * Set default menu values
     */
    public function set_default_menu_values() {
        // Debug log
        error_log('Setting default menu values');
        
        // Only run this once
        if (get_option('si_default_menus_set')) {
            error_log('Default menus already set, skipping');
            return;
        }
        
        // Set brunch menu defaults
        foreach ($this->brunch_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        // Set full menu defaults
        foreach ($this->full_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        // Set drinks menu defaults
        foreach ($this->drinks_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        // Mark as set
        update_option('si_default_menus_set', true);
        error_log('Default menus set successfully');
    }

    /**
     * Clean up theme mods when switching themes
     */
    public function cleanup_theme_mods() {
        // Remove all menu-related theme mods
        $all_theme_mods = get_theme_mods();
        if ($all_theme_mods) {
            foreach ($all_theme_mods as $key => $value) {
                if (strpos($key, 'si_written_menu_') === 0) {
                    remove_theme_mod($key);
                }
            }
        }
        
        // Remove the default menus set option
        delete_option('si_default_menus_set');
        
        error_log('Cleaned up menu theme mods');
    }
}

// Initialize the menu defaults manager
SI_Menu_Defaults::get_instance();

/**
 * Helper function to get menu defaults
 *
 * @param string $menu_type The menu type (brunch, full, drinks)
 * @return array The menu defaults array
 */
function si_get_menu_defaults($menu_type) {
    return SI_Menu_Defaults::get_instance()->get_menu_defaults($menu_type);
} 