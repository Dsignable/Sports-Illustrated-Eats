<?php
/**
 * Content Sections Customizer Settings
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add content sections customizer settings
 */
function si_content_sections_customizer_settings($wp_customize) {
    // About Us Section
    $wp_customize->add_setting('si_about_us_text', array(
        'default'           => 'At Sports Illustrated Clubhouse, we\'re where passionate fans become family. We\'ve created the ultimate gameday destination where every seat feels like the best in the house. Our dishes will have you cheering between bites, while our craft drinks are worthy of any celebration. When our big screens light up, you\'ll find yourself surrounded by fellow fans who understand that the best moments are shared. We\'re not just about watching the game—we\'re about experiencing it together. Grab your crew and join us. The game\'s about to start, and your table is waiting.',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_about_us_text', array(
        'label'       => __('About Us Text', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // VIP Section
    $wp_customize->add_setting('si_vip_text', array(
        'default'           => 'We are dedicated to transforming ordinary fans into VIPs with stadium-level excitement and exceptional hospitality. From the moment you step through our doors until your final high-five goodbye, our team delivers championship-worthy service.',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_vip_text', array(
        'label'       => __('VIP Section Text', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Daily Specials Section
    $wp_customize->add_setting('si_daily_specials_text', array(
        'default'           => 'MON - $7-12 Burger Mania | TUE - $15 Bottomless Pasta | WED - $10 Wings | THU - $2.5 TACOS | FRI - $3 HAPPY DAD | WEEKENDS $10 Brunch Happy Hour',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_daily_specials_text', array(
        'label'       => __('Daily Specials Text', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'si_content_sections_customizer_settings'); 