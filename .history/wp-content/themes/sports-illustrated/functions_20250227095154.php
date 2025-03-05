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
        SI_VERSION . '.' . time()  // Force cache bust
    );

    // Enqueue button styles
    wp_enqueue_style(
        'sports-illustrated-buttons',
        get_theme_file_uri('assets/css/buttons.css'),
        array('sports-illustrated-main'),
        SI_VERSION . '.' . time()  // Force cache bust
    );

    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Navigation script
    wp_enqueue_script(
        'sports-illustrated-navigation',
        get_theme_file_uri('assets/js/navigation.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    // Add debug information
    wp_localize_script('sports-illustrated-navigation', 'siDebug', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'themeUrl' => get_template_directory_uri(),
        'debug' => WP_DEBUG
    ));

    // Re-enable other scripts
    wp_enqueue_script(
        'sports-illustrated-scroll-animations',
        get_theme_file_uri('assets/js/scroll-animations.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    wp_enqueue_script(
        'sports-illustrated-menu',
        get_theme_file_uri('assets/js/menu.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    // Add inline script for debugging
    wp_add_inline_script('sports-illustrated-navigation', 'console.log("Navigation script loaded", siDebug);', 'before');
}
add_action('wp_enqueue_scripts', 'sports_illustrated_enqueue_assets', 100);

// Add this new function to debug script loading
function si_debug_scripts() {
    global $wp_scripts;
    error_log('=== Enqueued Scripts ===');
    foreach ($wp_scripts->queue as $handle) {
        error_log("Script: $handle - Source: " . $wp_scripts->registered[$handle]->src);
    }
    error_log('=====================');
}
add_action('wp_print_scripts', 'si_debug_scripts', 99);

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
 * Allow PDF uploads
 */
function si_allow_pdf_uploads($mime_types) {
    $mime_types['pdf'] = 'application/pdf';
    return $mime_types;
}
add_filter('upload_mimes', 'si_allow_pdf_uploads');

/**
 * Add menu customizer settings
 */
function si_menu_customizer_settings($wp_customize) {
    // Add Menu PDFs section
    $wp_customize->add_section('si_menu_pdfs', array(
        'title'    => __('Menu PDFs', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Full Menu PDF
    $wp_customize->add_setting('si_menu_full', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_full', array(
        'label'         => __('Full Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Happy Hour Menu PDF
    $wp_customize->add_setting('si_menu_happy', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_happy', array(
        'label'         => __('Happy Hour Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Drink Menu PDF
    $wp_customize->add_setting('si_menu_drink', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_drink', array(
        'label'         => __('Drink Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Daily Menu PDFs
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    foreach ($days as $day) {
        $wp_customize->add_setting('si_menu_' . $day, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh'
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_' . $day, array(
            'label'         => sprintf(__('%s Menu PDF', 'sports-illustrated'), ucfirst($day)),
            'section'       => 'si_menu_pdfs',
            'mime_type'     => 'application/pdf',
            'button_labels' => array(
                'select'       => __('Select PDF'),
                'change'       => __('Change PDF'),
                'remove'       => __('Remove'),
                'default'      => __('Default'),
                'placeholder'  => __('No PDF selected'),
                'frame_title'  => __('Select PDF'),
                'frame_button' => __('Choose PDF'),
            ),
        )));
    }
}
add_action('customize_register', 'si_menu_customizer_settings');

/**
 * Get menu PDF URL from attachment ID
 */
function si_get_menu_pdf_url($setting_name) {
    $attachment_id = get_theme_mod($setting_name);
    if ($attachment_id && is_numeric($attachment_id)) {
        $attachment_url = wp_get_attachment_url($attachment_id);
        if ($attachment_url && pathinfo($attachment_url, PATHINFO_EXTENSION) === 'pdf') {
            return $attachment_url;
        }
    }
    return '';
}

/**
 * Get menu page URL with optional menu type parameter
 */
function si_get_menu_url($menu_type = '') {
    $menu_page = get_page_by_path('menu');
    if ($menu_page) {
        $url = get_permalink($menu_page->ID);
        if ($menu_type) {
            $url = add_query_arg('menu', $menu_type, $url);
        }
        return $url;
    }
    return home_url('/menu/');
} 