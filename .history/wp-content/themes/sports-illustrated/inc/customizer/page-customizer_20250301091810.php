<?php
/**
 * Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

function si_customize_page_settings($wp_customize) {
    // Careers Page Settings
    $wp_customize->add_section('si_careers_section', array(
        'title'    => __('Careers Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Careers Header Image
    $wp_customize->add_setting('si_careers_header_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_careers_header_image', array(
        'label'    => __('Careers Page Header Image', 'sports-illustrated'),
        'section'  => 'si_careers_section',
        'settings' => 'si_careers_header_image',
    )));

    // Careers Page Title
    $wp_customize->add_setting('si_careers_title', array(
        'default'           => __('Join Our Team', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_careers_title', array(
        'label'    => __('Careers Page Title', 'sports-illustrated'),
        'section'  => 'si_careers_section',
        'type'     => 'text',
    ));

    // Careers Page Description
    $wp_customize->add_setting('si_careers_description', array(
        'default'           => __('Be part of an exciting team that delivers exceptional dining experiences.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_careers_description', array(
        'label'    => __('Careers Page Description', 'sports-illustrated'),
        'section'  => 'si_careers_section',
        'type'     => 'textarea',
    ));

    // News Page Settings
    $wp_customize->add_section('si_news_section', array(
        'title'    => __('News Page Settings', 'sports-illustrated'),
        'priority' => 31,
    ));

    // News Header Image
    $wp_customize->add_setting('si_news_header_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_news_header_image', array(
        'label'    => __('News Page Header Image', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'settings' => 'si_news_header_image',
    )));

    // News Page Title
    $wp_customize->add_setting('si_news_title', array(
        'default'           => __('Latest News', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_news_title', array(
        'label'    => __('News Page Title', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'type'     => 'text',
    ));

    // News Page Description
    $wp_customize->add_setting('si_news_description', array(
        'default'           => __('Stay updated with the latest news and updates from Sports Illustrated Clubhouse.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_news_description', array(
        'label'    => __('News Page Description', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'si_customize_page_settings'); 