<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function si_clubhouse_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 80,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Register nav menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'si-clubhouse'),
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'si_clubhouse_setup');

/**
 * Enqueue scripts and styles.
 */
function si_clubhouse_scripts() {
    wp_enqueue_style(
        'si-clubhouse-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'si_clubhouse_scripts');

/**
 * Add custom image sizes if needed
 */
function si_clubhouse_custom_image_sizes() {
    add_image_size('hero-background', 1920, 832, true);
}
add_action('after_setup_theme', 'si_clubhouse_custom_image_sizes');

/**
 * Customize theme settings
 */
function si_clubhouse_customize_register($wp_customize) {
    // Add section for hero settings
    $wp_customize->add_section('si_clubhouse_hero_section', array(
        'title'    => __('Hero Section', 'si-clubhouse'),
        'priority' => 30,
    ));

    // Add setting for hero background image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Add control for hero background image
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => __('Hero Background Image', 'si-clubhouse'),
        'section'  => 'si_clubhouse_hero_section',
        'settings' => 'hero_background_image',
    )));
}
add_action('customize_register', 'si_clubhouse_customize_register'); 