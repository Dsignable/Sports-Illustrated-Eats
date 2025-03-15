<?php
/**
 * Written Menu Customizer Settings
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add written menu customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_written_menu_customizer_settings($wp_customize) {
    // Add Menus Panel
    $wp_customize->add_panel('si_menus_panel', array(
        'title'    => __('Restaurant Menus', 'sports-illustrated'),
        'priority' => 130,
    ));
    
    // Add Written Menu Types
    $menu_types = array(
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'full'   => __('Full Menu', 'sports-illustrated'),
        'drinks' => __('Drinks Menu', 'sports-illustrated'),
    );
    
    // Add sections for each menu type that redirect to the Restaurant Menus page
    foreach ($menu_types as $type => $label) {
        // Add section for this menu type
        $wp_customize->add_section("si_written_menu_{$type}_section", array(
            'title'    => $label,
            'priority' => 10,
            'panel'    => 'si_menus_panel',
        ));
        
        // Add redirect control
        $wp_customize->add_setting("si_written_menu_{$type}_redirect", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control(new WP_Customize_Redirect_Control($wp_customize, "si_written_menu_{$type}_redirect", array(
            'section'     => "si_written_menu_{$type}_section",
            'label'       => __('Edit Restaurant Menus', 'sports-illustrated'),
            'description' => __('Restaurant menus are now managed in the Restaurant Menus page for a better editing experience.', 'sports-illustrated'),
            'button_text' => __('Go to Restaurant Menus', 'sports-illustrated'),
            'button_url'  => admin_url('themes.php?page=si-menu-manager'),
            'priority'    => 10,
        )));
    }
}

/**
 * Custom redirect control for the customizer
 */
if (!class_exists('WP_Customize_Redirect_Control')) {
    class WP_Customize_Redirect_Control extends WP_Customize_Control {
        public $type = 'redirect';
        public $button_text = '';
        public $button_url = '';
        
        public function render_content() {
            ?>
            <div class="customize-control-redirect">
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <a href="<?php echo esc_url($this->button_url); ?>" class="button button-primary" style="margin-top: 10px;"><?php echo esc_html($this->button_text); ?></a>
            </div>
            <?php
        }
    }
} 