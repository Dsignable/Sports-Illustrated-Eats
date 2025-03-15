<?php
/**
 * Home Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add home page customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_home_page_customizer_settings($wp_customize) {
    // Add Home Page Section
    $wp_customize->add_section('si_home_page', array(
        'title'    => __('Home Page', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Hero Section
    $wp_customize->add_setting('si_home_hero_title', array(
        'default'           => __('WELCOME TO SPORTS ILLUSTRATED CLUBHOUSE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_hero_title', array(
        'label'    => __('Hero Title', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_hero_subtitle', array(
        'default'           => __('FOOD. DRINKS. SPORTS.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_hero_description', array(
        'default'           => __('Experience the ultimate sports bar and restaurant. Great food, drinks, and the best place to watch the game.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_home_hero_description', array(
        'label'    => __('Hero Description', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('si_home_hero_button_text', array(
        'default'           => __('RESERVE A TABLE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_hero_button_text', array(
        'label'    => __('Hero Button Text', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_hero_button_url', array(
        'default'           => home_url('/reservations/'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_home_hero_button_url', array(
        'label'    => __('Hero Button URL', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('si_home_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_home_hero_image', array(
        'label'    => __('Hero Background Image', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'settings' => 'si_home_hero_image',
    )));

    // About Section
    $wp_customize->add_setting('si_home_about_title', array(
        'default'           => __('ABOUT US', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_about_title', array(
        'label'    => __('About Section Title', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_about_content', array(
        'default'           => __('Sports Illustrated Clubhouse is the ultimate destination for sports fans and food enthusiasts alike. Our restaurant combines the excitement of sports with exceptional dining experiences.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_home_about_content', array(
        'label'    => __('About Section Content', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('si_home_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_home_about_image', array(
        'label'    => __('About Section Image', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'settings' => 'si_home_about_image',
    )));

    // Featured Menu Items Section
    $wp_customize->add_setting('si_home_menu_title', array(
        'default'           => __('FEATURED MENU ITEMS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_menu_title', array(
        'label'    => __('Menu Section Title', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_menu_description', array(
        'default'           => __('Explore our signature dishes and drinks, crafted with quality ingredients and passion.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_home_menu_description', array(
        'label'    => __('Menu Section Description', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'textarea',
    ));

    // For up to 3 featured menu items
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting('si_home_menu_item_' . $i . '_title', array(
            'default'           => __('Menu Item ' . $i, 'sports-illustrated'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_home_menu_item_' . $i . '_title', array(
            'label'    => sprintf(__('Menu Item %d Title', 'sports-illustrated'), $i),
            'section'  => 'si_home_page',
            'type'     => 'text',
        ));

        $wp_customize->add_setting('si_home_menu_item_' . $i . '_description', array(
            'default'           => __('Description for menu item ' . $i, 'sports-illustrated'),
            'sanitize_callback' => 'wp_kses_post',
        ));

        $wp_customize->add_control('si_home_menu_item_' . $i . '_description', array(
            'label'    => sprintf(__('Menu Item %d Description', 'sports-illustrated'), $i),
            'section'  => 'si_home_page',
            'type'     => 'textarea',
        ));

        $wp_customize->add_setting('si_home_menu_item_' . $i . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_home_menu_item_' . $i . '_image', array(
            'label'    => sprintf(__('Menu Item %d Image', 'sports-illustrated'), $i),
            'section'  => 'si_home_page',
            'settings' => 'si_home_menu_item_' . $i . '_image',
        )));
    }

    // Call to Action Section
    $wp_customize->add_setting('si_home_cta_title', array(
        'default'           => __('READY TO EXPERIENCE SPORTS ILLUSTRATED CLUBHOUSE?', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_cta_title', array(
        'label'    => __('CTA Section Title', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_cta_description', array(
        'default'           => __('Join us for great food, drinks, and the best place to watch the game.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_home_cta_description', array(
        'label'    => __('CTA Section Description', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('si_home_cta_button_text', array(
        'default'           => __('RESERVE A TABLE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_home_cta_button_text', array(
        'label'    => __('CTA Button Text', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('si_home_cta_button_url', array(
        'default'           => home_url('/reservations/'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_home_cta_button_url', array(
        'label'    => __('CTA Button URL', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('si_home_cta_background', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_home_cta_background', array(
        'label'    => __('CTA Background Image', 'sports-illustrated'),
        'section'  => 'si_home_page',
        'settings' => 'si_home_cta_background',
    )));
} 