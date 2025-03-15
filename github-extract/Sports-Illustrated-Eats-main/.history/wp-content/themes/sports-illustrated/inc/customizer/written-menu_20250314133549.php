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
    
    // Add Written Menus Section
    $wp_customize->add_section('si_written_menus_section', array(
        'title'    => __('Written Menus', 'sports-illustrated'),
        'priority' => 10,
        'panel'    => 'si_menus_panel',
    ));
    
    // Add Written Menu Types
    $menu_types = array(
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'full'   => __('Full Menu', 'sports-illustrated'),
        'drinks' => __('Drinks Menu', 'sports-illustrated'),
    );
    
    // Add settings and controls for each menu type
    foreach ($menu_types as $type => $label) {
        // Add section for this menu type
        $wp_customize->add_section("si_written_menu_{$type}_section", array(
            'title'    => $label,
            'priority' => 10,
            'panel'    => 'si_menus_panel',
        ));
        
        // Add title setting
        $wp_customize->add_setting("si_written_menu_{$type}_title", array(
            'default'           => ucfirst($type) . ' Menu',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("si_written_menu_{$type}_title", array(
            'label'    => __('Menu Title', 'sports-illustrated'),
            'section'  => "si_written_menu_{$type}_section",
            'type'     => 'text',
            'priority' => 10,
        ));
        
        // Add description setting
        $wp_customize->add_setting("si_written_menu_{$type}_description", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ));
        
        $wp_customize->add_control("si_written_menu_{$type}_description", array(
            'label'    => __('Menu Description', 'sports-illustrated'),
            'section'  => "si_written_menu_{$type}_section",
            'type'     => 'textarea',
            'priority' => 20,
        ));
        
        // Add sections for this menu type (up to 10 sections)
        for ($i = 1; $i <= 10; $i++) {
            // Section title
            $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_title", array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_title", array(
                'label'    => sprintf(__('Section %d Title', 'sports-illustrated'), $i),
                'section'  => "si_written_menu_{$type}_section",
                'type'     => 'text',
                'priority' => 30 + ($i * 10),
            ));
            
            // Section description
            $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_description", array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            ));
            
            $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_description", array(
                'label'    => sprintf(__('Section %d Description', 'sports-illustrated'), $i),
                'section'  => "si_written_menu_{$type}_section",
                'type'     => 'textarea',
                'priority' => 30 + ($i * 10) + 1,
            ));
            
            // Add items for this section (up to 20 items per section)
            for ($j = 1; $j <= 20; $j++) {
                // Item name
                $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_item_{$j}_name", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_item_{$j}_name", array(
                    'label'    => sprintf(__('Section %d - Item %d Name', 'sports-illustrated'), $i, $j),
                    'section'  => "si_written_menu_{$type}_section",
                    'type'     => 'text',
                    'priority' => 30 + ($i * 10) + 2 + ($j * 4),
                ));
                
                // Item description
                $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_item_{$j}_description", array(
                    'default'           => '',
                    'sanitize_callback' => 'wp_kses_post',
                ));
                
                $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_item_{$j}_description", array(
                    'label'    => sprintf(__('Section %d - Item %d Description', 'sports-illustrated'), $i, $j),
                    'section'  => "si_written_menu_{$type}_section",
                    'type'     => 'textarea',
                    'priority' => 30 + ($i * 10) + 3 + ($j * 4),
                ));
                
                // Item price
                $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_item_{$j}_price", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_item_{$j}_price", array(
                    'label'    => sprintf(__('Section %d - Item %d Price', 'sports-illustrated'), $i, $j),
                    'section'  => "si_written_menu_{$type}_section",
                    'type'     => 'text',
                    'priority' => 30 + ($i * 10) + 4 + ($j * 4),
                ));
                
                // Item notes
                $wp_customize->add_setting("si_written_menu_{$type}_section_{$i}_item_{$j}_notes", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control("si_written_menu_{$type}_section_{$i}_item_{$j}_notes", array(
                    'label'       => sprintf(__('Section %d - Item %d Notes', 'sports-illustrated'), $i, $j),
                    'description' => __('Use "subsection" to mark this item as a subsection header', 'sports-illustrated'),
                    'section'     => "si_written_menu_{$type}_section",
                    'type'        => 'text',
                    'priority'    => 30 + ($i * 10) + 5 + ($j * 4),
                ));
            }
        }
    }
}

/**
 * Custom button control for the customizer
 */
if (!class_exists('WP_Customize_Button_Control')) {
    class WP_Customize_Button_Control extends WP_Customize_Control {
        public $type = 'button';
        public $button_text = '';
        public $button_url = '';
        
        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <a href="<?php echo esc_url($this->button_url); ?>" class="button button-primary" style="margin-top: 10px;"><?php echo esc_html($this->button_text); ?></a>
            <?php
        }
    }
} 