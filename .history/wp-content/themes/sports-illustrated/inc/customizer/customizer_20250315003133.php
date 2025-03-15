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
    // Include all customizer section files
    require_once get_template_directory() . '/inc/customizer/home-page.php';
    require_once get_template_directory() . '/inc/customizer/written-menu.php';
    // The following files need to be created:
    // require_once get_template_directory() . '/inc/customizer/header-navigation.php';
    // require_once get_template_directory() . '/inc/customizer/footer.php';
    // require_once get_template_directory() . '/inc/customizer/page-backgrounds.php';
    // require_once get_template_directory() . '/inc/customizer/news-page.php';
    // require_once get_template_directory() . '/inc/customizer/gift-cards.php';
    // require_once get_template_directory() . '/inc/customizer/catering.php';
    // require_once get_template_directory() . '/inc/customizer/contact.php';
    // require_once get_template_directory() . '/inc/customizer/menu-page.php';
    // require_once get_template_directory() . '/inc/customizer/loading-screen.php';
    // require_once get_template_directory() . '/inc/customizer/monthly-events.php';
    // require_once get_template_directory() . '/inc/customizer/menu-display-type.php';
    
    // Call each customizer function
    si_home_page_customizer_settings($wp_customize);
    si_written_menu_customizer_settings($wp_customize);
    
    // These functions are defined in functions.php for now
    si_header_navigation_customizer($wp_customize);
    si_footer_customizer_settings($wp_customize);
    si_page_backgrounds_customizer($wp_customize);
    si_news_page_customizer($wp_customize);
    si_gift_cards_customizer($wp_customize);
    si_catering_customizer($wp_customize);
    si_contact_customizer($wp_customize);
    si_menu_display_type_customizer($wp_customize);
    si_loading_screen_customizer($wp_customize);
    si_monthly_events_customizer($wp_customize);

    // Menu Dropdown Options
    $wp_customize->add_section('si_menu_dropdown_section', array(
        'title' => __('Menu Dropdown Options', 'sports-illustrated'),
        'priority' => 31,
        'panel' => 'si_theme_panel'
    ));

    // Menu Types
    $menu_types = array(
        'full' => 'Full Menu',
        'drink' => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy' => 'Happy Hour',
        'today' => 'Today\'s Menu'
    );

    foreach ($menu_types as $key => $default_label) {
        // Menu Item Text
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_text', array(
            'default' => $default_label,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_text', array(
            'label' => sprintf(__('%s Text', 'sports-illustrated'), $default_label),
            'section' => 'si_menu_dropdown_section',
            'type' => 'text'
        ));

        // Menu Item Visibility
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_visible', array(
            'default' => true,
            'sanitize_callback' => 'si_sanitize_checkbox'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_visible', array(
            'label' => sprintf(__('Show %s', 'sports-illustrated'), $default_label),
            'section' => 'si_menu_dropdown_section',
            'type' => 'checkbox'
        ));
    }
}

function si_header_navigation_customizer($wp_customize) {
    // Existing header navigation settings...

    // Add Menu Dropdown Options subsection
    $wp_customize->add_section('si_header_menu_dropdown', array(
        'title' => __('Menu Dropdown Options', 'sports-illustrated'),
        'priority' => 10,
        'panel' => 'si_header_navigation'
    ));

    // Enable Menu Dropdown Toggle
    $wp_customize->add_setting('si_enable_menu_dropdown', array(
        'default' => true,
        'sanitize_callback' => 'si_sanitize_checkbox'
    ));

    $wp_customize->add_control('si_enable_menu_dropdown', array(
        'label' => __('Enable Menu Dropdown', 'sports-illustrated'),
        'section' => 'si_header_menu_dropdown',
        'type' => 'checkbox'
    ));

    // Menu Types
    $menu_types = array(
        'full' => 'Full Menu',
        'drink' => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy' => 'Happy Hour',
        'today' => 'Today\'s Menu'
    );

    foreach ($menu_types as $key => $default_label) {
        // Menu Item Text
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_text', array(
            'default' => $default_label,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_text', array(
            'label' => sprintf(__('%s Text', 'sports-illustrated'), $default_label),
            'section' => 'si_header_menu_dropdown',
            'type' => 'text'
        ));

        // Menu Item Visibility
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_visible', array(
            'default' => true,
            'sanitize_callback' => 'si_sanitize_checkbox'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_visible', array(
            'label' => sprintf(__('Show %s', 'sports-illustrated'), $default_label),
            'section' => 'si_header_menu_dropdown',
            'type' => 'checkbox'
        ));
    }
}

// Add action to register customizer sections
add_action('customize_register', 'si_register_customizer_sections'); 