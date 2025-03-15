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
    // Include menu defaults
    require_once get_template_directory() . '/inc/menu-defaults.php';
    
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
    
    // Add settings and controls for each menu type
    foreach ($menu_types as $type => $label) {
        // Get the defaults for this menu type
        $defaults = si_get_menu_defaults($type);
        
        // Add section for this menu type
        $wp_customize->add_section("si_written_menu_{$type}_section", array(
            'title'    => $label,
            'priority' => 10,
            'panel'    => 'si_menus_panel',
            'description' => __('Edit the content for this menu. Each section can have up to 20 items.', 'sports-illustrated'),
        ));
        
        // Add title setting
        $default_title = isset($defaults["si_written_menu_{$type}_title"]) ? $defaults["si_written_menu_{$type}_title"] : ucfirst($type) . ' Menu';
        $wp_customize->add_setting("si_written_menu_{$type}_title", array(
            'default'           => $default_title,
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("si_written_menu_{$type}_title", array(
            'label'       => __('Menu Title', 'sports-illustrated'),
            'description' => sprintf(__('Default: %s', 'sports-illustrated'), $default_title),
            'section'     => "si_written_menu_{$type}_section",
            'type'        => 'text',
            'priority'    => 10,
        ));
        
        // Add description setting
        $default_description = isset($defaults["si_written_menu_{$type}_description"]) ? $defaults["si_written_menu_{$type}_description"] : '';
        $wp_customize->add_setting("si_written_menu_{$type}_description", array(
            'default'           => $default_description,
            'sanitize_callback' => 'wp_kses_post',
        ));
        
        $wp_customize->add_control("si_written_menu_{$type}_description", array(
            'label'       => __('Menu Description', 'sports-illustrated'),
            'description' => !empty($default_description) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_description) : __('No default description', 'sports-illustrated'),
            'section'     => "si_written_menu_{$type}_section",
            'type'        => 'textarea',
            'priority'    => 20,
        ));
        
        // Add sections for this menu type (up to 10 sections)
        for ($i = 1; $i <= 10; $i++) {
            // Create a section container
            $section_id = "si_written_menu_{$type}_section_{$i}";
            
            // Section title
            $default_section_title = isset($defaults["{$section_id}_title"]) ? $defaults["{$section_id}_title"] : '';
            
            // Skip empty sections after section 3 to reduce clutter
            if ($i > 3 && empty($default_section_title)) {
                continue;
            }
            
            // Add a separator for better organization
            $wp_customize->add_setting("{$section_id}_separator", array(
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_control(new WP_Customize_Separator_Control($wp_customize, "{$section_id}_separator", array(
                'label'       => sprintf(__('SECTION %d', 'sports-illustrated'), $i),
                'section'     => "si_written_menu_{$type}_section",
                'priority'    => 30 + ($i * 100),
            )));
            
            // Section title
            $wp_customize->add_setting("{$section_id}_title", array(
                'default'           => $default_section_title,
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_control("{$section_id}_title", array(
                'label'       => sprintf(__('Section %d Title', 'sports-illustrated'), $i),
                'description' => !empty($default_section_title) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_section_title) : '',
                'section'     => "si_written_menu_{$type}_section",
                'type'        => 'text',
                'priority'    => 30 + ($i * 100) + 1,
            ));
            
            // Section description
            $default_section_description = isset($defaults["{$section_id}_description"]) ? $defaults["{$section_id}_description"] : '';
            $wp_customize->add_setting("{$section_id}_description", array(
                'default'           => $default_section_description,
                'sanitize_callback' => 'wp_kses_post',
            ));
            
            $wp_customize->add_control("{$section_id}_description", array(
                'label'       => sprintf(__('Section %d Description', 'sports-illustrated'), $i),
                'description' => !empty($default_section_description) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_section_description) : '',
                'section'     => "si_written_menu_{$type}_section",
                'type'        => 'textarea',
                'priority'    => 30 + ($i * 100) + 2,
            ));
            
            // Add items for this section (up to 20 items per section)
            for ($j = 1; $j <= 20; $j++) {
                $item_id = "{$section_id}_item_{$j}";
                
                // Item name
                $default_item_name = isset($defaults["{$item_id}_name"]) ? $defaults["{$item_id}_name"] : '';
                
                // Skip empty items after item 5 to reduce clutter
                if ($j > 5 && empty($default_item_name)) {
                    continue;
                }
                
                // Add a separator for each item
                $wp_customize->add_setting("{$item_id}_separator", array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control(new WP_Customize_Item_Separator_Control($wp_customize, "{$item_id}_separator", array(
                    'label'       => sprintf(__('Item %d', 'sports-illustrated'), $j),
                    'section'     => "si_written_menu_{$type}_section",
                    'priority'    => 30 + ($i * 100) + 3 + ($j * 5),
                )));
                
                // Item name
                $wp_customize->add_setting("{$item_id}_name", array(
                    'default'           => $default_item_name,
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control("{$item_id}_name", array(
                    'label'       => sprintf(__('Section %d - Item %d Name', 'sports-illustrated'), $i, $j),
                    'description' => !empty($default_item_name) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_item_name) : '',
                    'section'     => "si_written_menu_{$type}_section",
                    'type'        => 'text',
                    'priority'    => 30 + ($i * 100) + 4 + ($j * 5),
                ));
                
                // Item description
                $default_item_description = isset($defaults["{$item_id}_description"]) ? $defaults["{$item_id}_description"] : '';
                $wp_customize->add_setting("{$item_id}_description", array(
                    'default'           => $default_item_description,
                    'sanitize_callback' => 'wp_kses_post',
                ));
                
                $wp_customize->add_control("{$item_id}_description", array(
                    'label'       => sprintf(__('Section %d - Item %d Description', 'sports-illustrated'), $i, $j),
                    'description' => !empty($default_item_description) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_item_description) : '',
                    'section'     => "si_written_menu_{$type}_section",
                    'type'        => 'textarea',
                    'priority'    => 30 + ($i * 100) + 5 + ($j * 5),
                ));
                
                // Item price
                $default_item_price = isset($defaults["{$item_id}_price"]) ? $defaults["{$item_id}_price"] : '';
                $wp_customize->add_setting("{$item_id}_price", array(
                    'default'           => $default_item_price,
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $wp_customize->add_control("{$item_id}_price", array(
                    'label'       => sprintf(__('Section %d - Item %d Price', 'sports-illustrated'), $i, $j),
                    'description' => !empty($default_item_price) ? sprintf(__('Default: %s', 'sports-illustrated'), $default_item_price) : '',
                    'section'     => "si_written_menu_{$type}_section",
                    'type'        => 'text',
                    'priority'    => 30 + ($i * 100) + 6 + ($j * 5),
                ));
                
                // Item notes
                $default_item_notes = isset($defaults["{$item_id}_notes"]) ? $defaults["{$item_id}_notes"] : '';
                $wp_customize->add_setting("{$item_id}_notes", array(
                    'default'           => $default_item_notes,
                    'sanitize_callback' => 'sanitize_text_field',
                ));
                
                $notes_description = __('Use "subsection" to mark this item as a subsection header', 'sports-illustrated');
                if (!empty($default_item_notes)) {
                    $notes_description .= sprintf(__(' | Default: %s', 'sports-illustrated'), $default_item_notes);
                }
                
                $wp_customize->add_control("{$item_id}_notes", array(
                    'label'       => sprintf(__('Section %d - Item %d Notes', 'sports-illustrated'), $i, $j),
                    'description' => $notes_description,
                    'section'     => "si_written_menu_{$type}_section",
                    'type'        => 'text',
                    'priority'    => 30 + ($i * 100) + 7 + ($j * 5),
                ));
            }
        }
    }
    
    // Add reset buttons to each menu section
    foreach ($menu_types as $type => $label) {
        $wp_customize->add_setting("si_reset_{$type}_menu", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control(new WP_Customize_Button_Control($wp_customize, "si_reset_{$type}_menu", array(
            'label'       => sprintf(__('Reset %s', 'sports-illustrated'), $label),
            'description' => sprintf(__('Reset the %s to default values. This cannot be undone.', 'sports-illustrated'), strtolower($label)),
            'section'     => "si_written_menu_{$type}_section",
            'button_text' => sprintf(__('Reset %s', 'sports-illustrated'), $label),
            'button_url'  => admin_url('themes.php?page=si-menu-manager'),
            'priority'    => 1000,
        )));
    }
}

/**
 * Custom separator control for the customizer
 */
if (!class_exists('WP_Customize_Separator_Control')) {
    class WP_Customize_Separator_Control extends WP_Customize_Control {
        public $type = 'separator';
        
        public function render_content() {
            ?>
            <div style="margin: 20px 0; border-top: 2px solid #ddd; padding-top: 15px;">
                <h3 style="text-transform: uppercase; color: #0073aa; margin: 0;"><?php echo esc_html($this->label); ?></h3>
            </div>
            <?php
        }
    }
}

/**
 * Custom item separator control for the customizer
 */
if (!class_exists('WP_Customize_Item_Separator_Control')) {
    class WP_Customize_Item_Separator_Control extends WP_Customize_Control {
        public $type = 'item_separator';
        
        public function render_content() {
            ?>
            <div style="margin: 10px 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                <h4 style="color: #555; margin: 0;"><?php echo esc_html($this->label); ?></h4>
            </div>
            <?php
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