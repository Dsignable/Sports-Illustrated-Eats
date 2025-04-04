<?php
/**
 * Sports Illustrated theme functions and definitions
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme version
if (!defined('SI_VERSION')) {
    define('SI_VERSION', wp_get_theme()->get('Version'));
}

// Enable debugging
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

/**
 * Enqueue scripts and styles
 */
function sports_illustrated_enqueue_assets() {
    // Enqueue main stylesheet
    wp_enqueue_style(
        'sports-illustrated-main',
        get_theme_file_uri('assets/css/main.css'),
        array(),
        SI_VERSION
    );

    // Enqueue button styles
    wp_enqueue_style(
        'sports-illustrated-buttons',
        get_theme_file_uri('assets/css/buttons.css'),
        array('sports-illustrated-main'),
        SI_VERSION
    );

    // Enqueue navigation script
    wp_enqueue_script(
        'sports-illustrated-navigation',
        get_theme_file_uri('assets/js/navigation.js'),
        array(),
        SI_VERSION,
        true
    );

    // Enqueue scroll animations script
    wp_enqueue_script(
        'sports-illustrated-scroll-animations',
        get_theme_file_uri('assets/js/scroll-animations.js'),
        array(),
        SI_VERSION,
        true
    );

    // Add menu script
    wp_enqueue_script(
        'sports-illustrated-menu',
        get_theme_file_uri('assets/js/menu.js'),
        array(),
        SI_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'sports_illustrated_enqueue_assets');

/**
 * Theme setup
 */
function sports_illustrated_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 60,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'sports-illustrated'),
        'mobile'  => esc_html__('Mobile Menu', 'sports-illustrated'),
    ));
}
add_action('after_setup_theme', 'sports_illustrated_setup');

/**
 * Register widget area
 */
function sports_illustrated_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'sports-illustrated'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'sports-illustrated'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'sports_illustrated_widgets_init');

/**
 * Customizer additions
 */
function sports_illustrated_customize_register($wp_customize) {
    // Add section for homepage background
    $wp_customize->add_section('si_homepage_background', array(
        'title'    => __('Homepage Background', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Add background type setting
    $wp_customize->add_setting('si_background_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_background_type', array(
        'label'    => __('Background Type', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
        'type'     => 'select',
        'choices'  => array(
            'image' => __('Image', 'sports-illustrated'),
            'video' => __('Video', 'sports-illustrated'),
        ),
    ));

    // Add background image setting
    $wp_customize->add_setting('si_background_image', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_background_image', array(
        'label'    => __('Background Image', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
    )));

    // Add background video setting
    $wp_customize->add_setting('si_background_video', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_background_video', array(
        'label'    => __('Background Video URL (MP4)', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'sports_illustrated_customize_register');

/**
 * Add menu customizer settings
 */
function si_menu_customizer_settings($wp_customize) {
    // Add Menu Images section
    $wp_customize->add_section('si_menu_images', array(
        'title'    => __('Menu Images', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Full Menu Image
    $wp_customize->add_setting('si_menu_full', array(
        'default'           => get_theme_file_uri('assets/images/menus/default-menu.jpg'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_menu_full', array(
        'label'    => __('Full Menu Image (Landscape)', 'sports-illustrated'),
        'section'  => 'si_menu_images',
        'settings' => 'si_menu_full',
    )));

    // Happy Hour Menu Image
    $wp_customize->add_setting('si_menu_happy', array(
        'default'           => get_theme_file_uri('assets/images/menus/happy-hour.jpg'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_menu_happy', array(
        'label'    => __('Happy Hour Menu Image (Portrait)', 'sports-illustrated'),
        'section'  => 'si_menu_images',
        'settings' => 'si_menu_happy',
    )));

    // Drink Menu Image
    $wp_customize->add_setting('si_menu_drink', array(
        'default'           => get_theme_file_uri('assets/images/menus/drinks.jpg'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_menu_drink', array(
        'label'    => __('Drink Menu Image (Portrait)', 'sports-illustrated'),
        'section'  => 'si_menu_images',
        'settings' => 'si_menu_drink',
    )));

    // Daily Menu Images
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    foreach ($days as $day) {
        $wp_customize->add_setting('si_menu_' . $day, array(
            'default'           => get_theme_file_uri('assets/images/menus/' . $day . '.jpg'),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_menu_' . $day, array(
            'label'    => sprintf(__('%s Menu Image (Portrait)', 'sports-illustrated'), ucfirst($day)),
            'section'  => 'si_menu_images',
            'settings' => 'si_menu_' . $day,
        )));
    }
}
add_action('customize_register', 'si_menu_customizer_settings'); 