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
        'priority' => 90,
    ));

    // Social Media Settings
    $wp_customize->add_setting('si_footer_social_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_footer_social_heading', array(
        'label'       => __('Social Media Links', 'sports-illustrated'),
        'description' => __('Configure your social media links and icons.', 'sports-illustrated'),
        'section'     => 'si_footer_section',
        'type'        => 'hidden',
    )));

    // Available social media platforms
    $social_platforms = array(
        'instagram' => array(
            'label' => 'Instagram',
            'icon' => 'fab fa-instagram'
        ),
        'facebook' => array(
            'label' => 'Facebook',
            'icon' => 'fab fa-facebook-f'
        ),
        'twitter' => array(
            'label' => 'X (Twitter)',
            'icon' => 'fab fa-x-twitter'
        ),
        'tiktok' => array(
            'label' => 'TikTok',
            'icon' => 'fab fa-tiktok'
        ),
        'youtube' => array(
            'label' => 'YouTube',
            'icon' => 'fab fa-youtube'
        )
    );

    // Create settings for each social platform
    foreach ($social_platforms as $platform => $details) {
        // Platform URL
        $wp_customize->add_setting('si_social_' . $platform . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_social_' . $platform . '_url', array(
            'label'       => sprintf(__('%s URL', 'sports-illustrated'), $details['label']),
            'section'     => 'si_footer_section',
            'type'        => 'url',
        ));

        // Platform Visibility
        $wp_customize->add_setting('si_social_' . $platform . '_visible', array(
            'default'           => $platform === 'instagram' ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_social_' . $platform . '_visible', array(
            'label'       => sprintf(__('Show %s', 'sports-illustrated'), $details['label']),
            'section'     => 'si_footer_section',
            'type'        => 'checkbox',
        ));
    }
}
add_action('customize_register', 'si_footer_customizer_settings'); 