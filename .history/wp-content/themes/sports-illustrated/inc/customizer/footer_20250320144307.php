<?php
/**
 * Footer Customizer Settings
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add footer customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_footer_customizer_settings($wp_customize) {
    // Add Footer Section
    $wp_customize->add_section('si_footer_section', array(
        'title'    => __('Footer Settings', 'sports-illustrated'),
        'priority' => 120,
    ));

    // Social Media Section
    $wp_customize->add_setting('si_social_media_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_social_media_heading', array(
        'label'       => __('Social Media Links', 'sports-illustrated'),
        'description' => __('Configure your social media links and icons.', 'sports-illustrated'),
        'section'     => 'si_footer_section',
        'type'        => 'hidden',
    )));

    // Available social media platforms
    $social_platforms = array(
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'twitter' => 'X/Twitter',
        'tiktok' => 'TikTok',
        'youtube' => 'YouTube',
    );

    // Add settings for up to 5 social media links
    for ($i = 1; $i <= 5; $i++) {
        // Platform Selection
        $wp_customize->add_setting('si_social_platform_' . $i, array(
            'default'           => $i === 1 ? 'instagram' : '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_social_platform_' . $i, array(
            'label'    => sprintf(__('Social Media %d Platform', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'select',
            'choices'  => $social_platforms,
            'priority' => 30 + (($i - 1) * 10),
        ));

        // URL
        $wp_customize->add_setting('si_social_url_' . $i, array(
            'default'           => $i === 1 ? 'https://instagram.com/sportsillustrated' : '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_social_url_' . $i, array(
            'label'    => sprintf(__('Social Media %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'url',
            'priority' => 31 + (($i - 1) * 10),
        ));

        // Visibility
        $wp_customize->add_setting('si_social_visible_' . $i, array(
            'default'           => $i === 1,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_social_visible_' . $i, array(
            'label'    => sprintf(__('Show Social Media %d', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'checkbox',
            'priority' => 32 + (($i - 1) * 10),
        ));
    }
}
add_action('customize_register', 'si_footer_customizer_settings'); 