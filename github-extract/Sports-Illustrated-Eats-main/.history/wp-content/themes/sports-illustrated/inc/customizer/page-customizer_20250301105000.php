<?php
/**
 * Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

function si_page_customizer_settings($wp_customize) {
    // Gift Cards Page Settings
    $wp_customize->add_section('si_gift_cards_settings', array(
        'title'    => __('Gift Cards Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('si_gift_cards_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gift_cards_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_gift_cards_settings',
        'mime_type' => 'image',
    )));

    // News Page Settings
    $wp_customize->add_section('si_news_settings', array(
        'title'    => __('News Page Settings', 'sports-illustrated'),
        'priority' => 31,
    ));

    $wp_customize->add_setting('si_news_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_news_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_news_settings',
        'mime_type' => 'image',
    )));

    // Careers Page Settings
    $wp_customize->add_section('si_careers_settings', array(
        'title'    => __('Careers Page Settings', 'sports-illustrated'),
        'priority' => 32,
    ));

    $wp_customize->add_setting('si_careers_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_careers_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_careers_settings',
        'mime_type' => 'image',
    )));

    // Menu Page Settings
    $wp_customize->add_section('si_menu_settings', array(
        'title'    => __('Menu Page Settings', 'sports-illustrated'),
        'priority' => 33,
    ));

    $wp_customize->add_setting('si_menu_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_menu_settings',
        'mime_type' => 'image',
    )));

    // Gallery Page Settings
    $wp_customize->add_section('si_gallery_settings', array(
        'title'    => __('Gallery Page Settings', 'sports-illustrated'),
        'priority' => 34,
    ));

    $wp_customize->add_setting('si_gallery_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gallery_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_gallery_settings',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_page_customizer_settings'); 