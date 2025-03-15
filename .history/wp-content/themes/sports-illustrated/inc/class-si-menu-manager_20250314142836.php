<?php
/**
 * SI Menu Manager Class
 *
 * This class handles the menu management functionality.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * SI_Menu_Manager class
 */
class SI_Menu_Manager {
    /**
     * Constructor
     */
    public function __construct() {
        // Initialize the menu manager
        // Commented out to prevent duplicate menu item
        // add_action('admin_menu', array($this, 'register_menu_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    /**
     * Register the menu manager page
     * 
     * Note: This method is disabled to prevent duplicate menu items.
     * The main Restaurant Menus page is registered in inc/admin/menu-manager.php
     */
    public function register_menu_page() {
        /* Commented out to prevent duplicate menu item
        add_submenu_page(
            'themes.php',
            __('Restaurant Menus Manager', 'sports-illustrated'),
            __('Restaurant Menus Manager', 'sports-illustrated'),
            'edit_theme_options',
            'menu-manager',
            array($this, 'render_menu_page')
        );
        */
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $hook The current admin page.
     */
    public function enqueue_admin_scripts($hook) {
        if ('appearance_page_menu-manager' !== $hook) {
            return;
        }

        wp_enqueue_style('si-menu-manager-style', get_template_directory_uri() . '/assets/css/admin/menu-manager.css', array(), '1.0.0');
        wp_enqueue_script('si-menu-manager-script', get_template_directory_uri() . '/assets/js/admin/menu-manager.js', array('jquery'), '1.0.0', true);
    }

    /**
     * Render the menu manager page
     */
    public function render_menu_page() {
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
                    </div>
                </div>
                
                <div class="menu-manager-section">
                    <h2><?php echo esc_html__('Menu Instructions', 'sports-illustrated'); ?></h2>
                    <p><?php echo esc_html__('The Sports Illustrated theme includes support for three types of menus:', 'sports-illustrated'); ?></p>
                    
                    <ul>
                        <li><?php echo esc_html__('Brunch Menu - For breakfast and brunch items', 'sports-illustrated'); ?></li>
                        <li><?php echo esc_html__('Full Menu - For lunch and dinner items', 'sports-illustrated'); ?></li>
                        <li><?php echo esc_html__('Drinks Menu - For beverages, including alcoholic and non-alcoholic options', 'sports-illustrated'); ?></li>
                    </ul>
                    
                    <p><?php echo esc_html__('Each menu can have up to 10 sections, and each section can have up to 15 items.', 'sports-illustrated'); ?></p>
                    
                    <h3><?php echo esc_html__('Using Subsections', 'sports-illustrated'); ?></h3>
                    <p><?php echo esc_html__('You can create subsections within each menu section by adding an item and setting its "Notes" field to "subsection". This will display the item as a subsection header.', 'sports-illustrated'); ?></p>
                    
                    <p><?php echo esc_html__('For example, in the Drinks Menu, you might have a "Wine" section with subsections for "Red", "White", and "Sparkling".', 'sports-illustrated'); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
}

// Initialize the menu manager
new SI_Menu_Manager(); 