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
    require_once get_template_directory() . '/inc/customizer/header-navigation.php';
    require_once get_template_directory() . '/inc/customizer/footer.php';
    require_once get_template_directory() . '/inc/customizer/page-backgrounds.php';
    require_once get_template_directory() . '/inc/customizer/news-page.php';
    require_once get_template_directory() . '/inc/customizer/gift-cards.php';
    require_once get_template_directory() . '/inc/customizer/catering.php';
    require_once get_template_directory() . '/inc/customizer/contact.php';
    require_once get_template_directory() . '/inc/customizer/menu-page.php';
    require_once get_template_directory() . '/inc/customizer/loading-screen.php';
    require_once get_template_directory() . '/inc/customizer/monthly-events.php';
    require_once get_template_directory() . '/inc/customizer/menu-display-type.php';
    
    // Call each customizer function
    si_home_page_customizer_settings($wp_customize);
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
}

// Add action to register customizer sections
add_action('customize_register', 'si_register_customizer_sections'); 