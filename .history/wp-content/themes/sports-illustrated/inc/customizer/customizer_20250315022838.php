<?php
/**
 * Sports Illustrated Theme Customizer
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register all customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_customize_register($wp_customize) {
    // Include all customizer sections
    si_header_navigation_customizer($wp_customize);
    si_footer_customizer_settings($wp_customize);
    si_page_backgrounds_customizer($wp_customize);
    si_news_page_customizer($wp_customize);
    si_gift_cards_customizer($wp_customize);
    si_catering_customizer($wp_customize);
    si_franchise_customizer($wp_customize);
    si_contact_customizer($wp_customize);
    si_menu_page_customizer($wp_customize);
    si_loading_screen_customizer($wp_customize);
    si_menu_display_type_customizer($wp_customize);
    si_monthly_events_customizer($wp_customize);
    
    // Add menu dropdown URL settings
    si_menu_dropdown_urls_customizer($wp_customize);
}
add_action('customize_register', 'si_customize_register');

/**
 * Add menu dropdown URL settings to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_menu_dropdown_urls_customizer($wp_customize) {
    // Menu Dropdown URLs
    $wp_customize->add_setting('si_menu_dropdown_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_menu_dropdown_heading', array(
        'label'       => __('Menu Dropdown URLs', 'sports-illustrated'),
        'description' => __('Configure the URLs for each menu dropdown item.', 'sports-illustrated'),
        'section'     => 'si_header_navigation',
        'type'        => 'hidden',
    )));
    
    // Menu dropdown items
    $menu_items = array(
        'full'   => __('Full Menu', 'sports-illustrated'),
        'drink'  => __('Drink Menu', 'sports-illustrated'),
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'happy'  => __('Happy Hour', 'sports-illustrated'),
        'today'  => __('Today\'s Menu', 'sports-illustrated')
    );
    
    foreach ($menu_items as $key => $label) {
        // Menu dropdown item text
        $wp_customize->add_setting('si_menu_dropdown_text_' . $key, array(
            'default'           => $label,
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));
        
        $wp_customize->add_control('si_menu_dropdown_text_' . $key, array(
            'label'       => sprintf(__('%s Text', 'sports-illustrated'), $label),
            'description' => __('Customize the text for this menu item', 'sports-illustrated'),
            'section'     => 'si_header_navigation',
            'type'        => 'text',
        ));
        
        // Menu dropdown item URL
        $wp_customize->add_setting('si_menu_dropdown_url_' . $key, array(
            'default'           => home_url('/menu/?menu=' . $key),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ));
        
        $wp_customize->add_control('si_menu_dropdown_url_' . $key, array(
            'label'       => sprintf(__('%s URL', 'sports-illustrated'), $label),
            'description' => __('Enter the full URL including https://', 'sports-illustrated'),
            'section'     => 'si_header_navigation',
            'type'        => 'url',
        ));
    }
} 