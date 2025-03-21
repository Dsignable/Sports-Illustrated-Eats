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

    // Social Media Links Section
    $wp_customize->add_setting('si_footer_social_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_footer_social_heading', array(
        'label'       => __('Social Media Links', 'sports-illustrated'),
        'description' => __('Configure up to 5 social media links that appear in the footer.', 'sports-illustrated'),
        'section'     => 'si_footer_section',
        'type'        => 'hidden',
    )));

    // Available social media platforms and their icons
    $social_platforms = array(
        'instagram' => 'Instagram (fab fa-instagram)',
        'facebook' => 'Facebook (fab fa-facebook)',
        'twitter' => 'X/Twitter (fab fa-x-twitter)',
        'tiktok' => 'TikTok (fab fa-tiktok)',
        'youtube' => 'YouTube (fab fa-youtube)',
        'linkedin' => 'LinkedIn (fab fa-linkedin)',
        'pinterest' => 'Pinterest (fab fa-pinterest)',
        'snapchat' => 'Snapchat (fab fa-snapchat)',
        'whatsapp' => 'WhatsApp (fab fa-whatsapp)',
        'yelp' => 'Yelp (fab fa-yelp)',
    );

    // Social Media Items (up to 5)
    for ($i = 1; $i <= 5; $i++) {
        // Platform Selection
        $wp_customize->add_setting('si_footer_social_platform_' . $i, array(
            'default'           => $i == 1 ? 'instagram' : '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_footer_social_platform_' . $i, array(
            'label'    => sprintf(__('Social Media %d Platform', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'select',
            'choices'  => $social_platforms,
            'priority' => 10 + (($i - 1) * 30),
        ));

        // URL
        $wp_customize->add_setting('si_footer_social_url_' . $i, array(
            'default'           => $i == 1 ? 'https://www.instagram.com/si_clubhouse/' : '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_footer_social_url_' . $i, array(
            'label'    => sprintf(__('Social Media %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'url',
            'priority' => 11 + (($i - 1) * 30),
        ));

        // Visibility
        $wp_customize->add_setting('si_footer_social_visible_' . $i, array(
            'default'           => $i == 1,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_footer_social_visible_' . $i, array(
            'label'    => sprintf(__('Show Social Media %d', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'checkbox',
            'priority' => 12 + (($i - 1) * 30),
        ));
    }

    // Footer Links Section
    $wp_customize->add_setting('si_footer_links_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_footer_links_heading', array(
        'label'       => __('Footer Links', 'sports-illustrated'),
        'description' => __('Configure the links that appear in the footer.', 'sports-illustrated'),
        'section'     => 'si_footer_section',
        'type'        => 'hidden',
        'priority'    => 200,
    )));

    // Footer Links (up to 4)
    for ($i = 1; $i <= 4; $i++) {
        // Link Text
        $wp_customize->add_setting('si_footer_link' . $i . '_text', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_footer_link' . $i . '_text', array(
            'label'    => sprintf(__('Footer Link %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'text',
            'priority' => 201 + (($i - 1) * 30),
        ));

        // Link Page
        $wp_customize->add_setting('si_footer_link' . $i . '_page', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_footer_link' . $i . '_page', array(
            'label'    => sprintf(__('Footer Link %d Page Slug', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'text',
            'priority' => 202 + (($i - 1) * 30),
        ));

        // Link Visibility
        $wp_customize->add_setting('si_footer_link' . $i . '_visible', array(
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_footer_link' . $i . '_visible', array(
            'label'    => sprintf(__('Show Footer Link %d', 'sports-illustrated'), $i),
            'section'  => 'si_footer_section',
            'type'     => 'checkbox',
            'priority' => 203 + (($i - 1) * 30),
        ));
    }

    // Footer Address
    $wp_customize->add_setting('si_footer_address', array(
        'default'           => '3340 SHRUM LANE | VANCOUVER, BC',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_footer_address', array(
        'label'    => __('Footer Address', 'sports-illustrated'),
        'section'  => 'si_footer_section',
        'type'     => 'text',
        'priority' => 300,
    ));
}
add_action('customize_register', 'si_footer_customizer_settings'); 