<?php
/**
 * Sports Illustrated Theme Customizer
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include customizer sections
require_once get_template_directory() . '/inc/customizer/home-page.php';

/**
 * Register all customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_customize_register($wp_customize) {
    // Include all customizer sections
    si_home_page_customizer_settings($wp_customize);
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
    
    // Note: Menu dropdown URL settings are already included in the si_header_navigation_customizer function
}
add_action('customize_register', 'si_customize_register'); 