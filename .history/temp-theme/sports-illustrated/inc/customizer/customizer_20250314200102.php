<?php
/**
 * Customizer Functions
 *
 * This file includes all customizer-related functions.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register all customizer sections
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_register_customizer_sections($wp_customize) {
    // Include available customizer section files
    $template_dir = get_template_directory();
    
    // Core customizer settings
    if (file_exists($template_dir . '/inc/customizer/home-page.php')) {
        require_once $template_dir . '/inc/customizer/home-page.php';
        si_home_page_customizer_settings($wp_customize);
    }
    
    if (file_exists($template_dir . '/inc/customizer/written-menu.php')) {
        require_once $template_dir . '/inc/customizer/written-menu.php';
        si_written_menu_customizer_settings($wp_customize);
    }

    // Basic theme customizer settings
    $wp_customize->add_section('si_theme_options', array(
        'title'    => __('Theme Options', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Add logo setting
    $wp_customize->add_setting('si_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_logo', array(
        'label'    => __('Logo', 'sports-illustrated'),
        'section'  => 'si_theme_options',
        'settings' => 'si_logo',
    )));

    // Add background color
    $wp_customize->add_setting('si_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'si_background_color', array(
        'label'    => __('Background Color', 'sports-illustrated'),
        'section'  => 'si_theme_options',
        'settings' => 'si_background_color',
    )));
}

// Add action to register customizer sections
add_action('customize_register', 'si_register_customizer_sections'); 