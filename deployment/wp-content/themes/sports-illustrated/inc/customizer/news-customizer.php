<?php
/**
 * News Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

/**
 * Add News settings to the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_customize_news_register($wp_customize) {
    // Add News section
    $wp_customize->add_section('si_news_section', array(
        'title'    => __('News Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // News Page Header Image
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
add_action('customize_register', 'si_customize_news_register'); 