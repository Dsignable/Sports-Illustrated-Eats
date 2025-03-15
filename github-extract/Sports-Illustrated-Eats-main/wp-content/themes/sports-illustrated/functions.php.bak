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
    // Enqueue styles
    wp_enqueue_style(
        'sports-illustrated-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(),
        '6.0.0'
    );

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

    // Enqueue jQuery first
    wp_enqueue_script('jquery');

    // Enqueue navigation script with jQuery dependency
    wp_enqueue_script(
        'sports-illustrated-navigation',
        get_theme_file_uri('/assets/js/navigation.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),  // Force cache bust
        true
    );

    // Add debug information
    wp_localize_script('sports-illustrated-navigation', 'siDebug', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'themeUrl' => get_template_directory_uri(),
        'debug' => WP_DEBUG,
        'isHome' => is_home() || is_front_page()
    ));

    // Enqueue scroll animations after navigation
    wp_enqueue_script(
        'sports-illustrated-scroll-animations',
        get_theme_file_uri('assets/js/scroll-animations.js'),
        array('jquery', 'sports-illustrated-navigation'),
        SI_VERSION . '.' . time(),
        true
    );

    // Remove menu.js as it might conflict with navigation.js
    // wp_enqueue_script(
    //     'sports-illustrated-menu',
    //     get_theme_file_uri('assets/js/menu.js'),
    //     array('jquery'),
    //     SI_VERSION . '.' . time(),
    //     true
    // );

    // Add inline script for debugging
    wp_add_inline_script('sports-illustrated-navigation', 'console.log("Navigation script loaded with debug:", siDebug);', 'before');
}
add_action('wp_enqueue_scripts', 'sports_illustrated_enqueue_assets');

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
 * Include customizer settings
 */
require get_template_directory() . '/inc/customizer/page-customizer.php';

// Remove the old menu cards customizer function since we're moving it to the Home Page section
remove_action('customize_register', 'si_menu_cards_customizer');

/**
 * Add Home Page customizer settings
 */
function si_home_page_customizer_settings($wp_customize) {
    // Add Home Page Section
    $wp_customize->add_section('si_home_page_section', array(
        'title'    => __('Home Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Menu Cards Section
    $wp_customize->add_setting('si_menu_cards_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_menu_cards_heading', array(
        'label'       => __('Menu Cards', 'sports-illustrated'),
        'description' => __('Configure the menu cards that appear on the front page.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Menu card settings for each type
    $menu_cards = array(
        'happy_hour' => 'Happy Hour',
        'fan_favorites' => 'Fan Favorites',
        'drinks_cocktails' => 'Drinks & Cocktails'
    );

    foreach ($menu_cards as $card_id => $card_name) {
        // Title setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_title', array(
            'default'           => $card_name,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        // Title control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_title', array(
            'label'       => $card_name . ' Card Title',
            'description' => sprintf(__('Enter the title for the %s menu card.', 'sports-illustrated'), $card_name),
            'section'     => 'si_home_page_section',
            'type'        => 'text',
        ));

        // Image setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'absint'
        ));

        // Image control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
            'si_menu_card_' . $card_id . '_image', 
            array(
                'label'       => $card_name . ' Card Image',
                'description' => sprintf(__('Select an image for the %s menu card.', 'sports-illustrated'), $card_name),
                'section'     => 'si_home_page_section',
                'mime_type'   => 'image',
            )
        ));

        // Link setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_link', array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Link control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_link', array(
            'label'       => $card_name . ' Card Link',
            'description' => sprintf(__('Enter the URL where the %s menu card should link to.', 'sports-illustrated'), $card_name),
            'section'     => 'si_home_page_section',
            'type'        => 'url',
        ));
    }

    // Move Homepage Background settings to Home Page Settings
    // Background Type
    $wp_customize->add_setting('si_background_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_background_type', array(
        'label'    => __('Background Type', 'sports-illustrated'),
        'description' => __('Choose between image or video background for the homepage.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'select',
        'choices'  => array(
            'image' => __('Image', 'sports-illustrated'),
            'video' => __('Video', 'sports-illustrated'),
        ),
    ));

    // Background Image
    $wp_customize->add_setting('si_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_background_image', array(
        'label'    => __('Background Image', 'sports-illustrated'),
        'description' => __('Upload an image for the homepage background.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'settings' => 'si_background_image',
    )));

    // Background Video URL
    $wp_customize->add_setting('si_background_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_background_video', array(
        'label'    => __('Background Video URL', 'sports-illustrated'),
        'description' => __('Enter a URL for the background video (YouTube, Vimeo, or direct video URL).', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'url',
    ));

    // Background Video File
    $wp_customize->add_setting('si_background_video_file', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_background_video_file', array(
        'label'    => __('Background Video File', 'sports-illustrated'),
        'description' => __('Upload a video file for the homepage background.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'mime_type' => 'video',
    )));

    // Hero Title
    $wp_customize->add_setting('si_hero_title', array(
        'default'           => __('SPORTS ILLUSTRATED CLUBHOUSE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_hero_title', array(
        'label'    => __('Hero Title', 'sports-illustrated'),
        'description' => __('Enter the main heading for the hero section.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('si_hero_subtitle', array(
        'default'           => __('WHERE FANS COME TO PLAY', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'sports-illustrated'),
        'description' => __('Enter the subtitle for the hero section.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Experience Section Settings (consolidated from si_experience_section_settings)
    $wp_customize->add_setting('si_experience_section_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_experience_section_heading', array(
        'label'       => __('Experience Section', 'sports-illustrated'),
        'description' => __('Configure the experience section on the homepage.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Experience Top Photo
    $wp_customize->add_setting('si_experience_top_photo', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_top_photo', array(
        'label'       => __('Experience Top Photo', 'sports-illustrated'),
        'description' => __('Upload an image for the top of the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Experience Bottom Photo
    $wp_customize->add_setting('si_experience_bottom_photo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_bottom_photo', array(
        'label'       => __('Experience Bottom Photo', 'sports-illustrated'),
        'description' => __('Upload an image for the bottom of the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Featured Content Section (formerly Sports Highlights)
    $wp_customize->add_setting('si_featured_content_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_featured_content_heading', array(
        'label'       => __('Featured Content Section (formerly Sports Highlights)', 'sports-illustrated'),
        'description' => __('Configure the featured content section on the homepage.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Left Image
    $wp_customize->add_setting('si_featured_left_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_featured_left_image', array(
        'label'       => __('Left Image', 'sports-illustrated'),
        'description' => __('Upload an image for the left side of the featured content section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Left Image Position Adjustments
    $wp_customize->add_setting('si_featured_left_image_x_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_left_image_x_position', array(
        'label'       => __('Left Image X Position', 'sports-illustrated'),
        'description' => __('Adjust the horizontal position of the left image (negative values move left, positive values move right).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'select',
        'choices'     => array(
            '-20' => __('-20%', 'sports-illustrated'),
            '-15' => __('-15%', 'sports-illustrated'),
            '-10' => __('-10%', 'sports-illustrated'),
            '-5'  => __('-5%', 'sports-illustrated'),
            '0'   => __('0% (Default)', 'sports-illustrated'),
            '5'   => __('5%', 'sports-illustrated'),
            '10'  => __('10%', 'sports-illustrated'),
            '15'  => __('15%', 'sports-illustrated'),
            '20'  => __('20%', 'sports-illustrated'),
        ),
    ));

    $wp_customize->add_setting('si_featured_left_image_y_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_left_image_y_position', array(
        'label'       => __('Left Image Y Position', 'sports-illustrated'),
        'description' => __('Adjust the vertical position of the left image (negative values move up, positive values move down).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'select',
        'choices'     => array(
            '-20' => __('-20%', 'sports-illustrated'),
            '-15' => __('-15%', 'sports-illustrated'),
            '-10' => __('-10%', 'sports-illustrated'),
            '-5'  => __('-5%', 'sports-illustrated'),
            '0'   => __('0% (Default)', 'sports-illustrated'),
            '5'   => __('5%', 'sports-illustrated'),
            '10'  => __('10%', 'sports-illustrated'),
            '15'  => __('15%', 'sports-illustrated'),
            '20'  => __('20%', 'sports-illustrated'),
        ),
    ));

    // Top Section Title
    $wp_customize->add_setting('si_featured_top_title', array(
        'default'           => __('NEVER MISS A MOMENT AT YOUR HOME AWAY FROM HOME', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_top_title', array(
        'label'       => __('Top Section Title', 'sports-illustrated'),
        'description' => __('Enter the title for the top section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Top Section Description
    $wp_customize->add_setting('si_featured_top_description', array(
        'default'           => __('The Sports Illustrated Clubhouse interior is a celebration of sports culture, blending sophistication with a vibrant, game-day atmosphere. From the moment you walk in, you\'re surrounded by iconic memorabilia, larger-than-life murals of legendary athletes, and screens broadcasting the biggest moments in sports history. The design seamlessly merges modern elegance with a love for the game, featuring sleek lines, warm wood accents, and dynamic lighting that creates the perfect ambiance for every occasion.', 'sports-illustrated'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

    $wp_customize->add_control('si_featured_top_description', array(
        'label'       => __('Top Section Description', 'sports-illustrated'),
        'description' => __('Enter the description for the top section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Right Image
    $wp_customize->add_setting('si_featured_right_image', array(
            'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_featured_right_image', array(
        'label'       => __('Right Image', 'sports-illustrated'),
        'description' => __('Upload an image for the right side of the featured content section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Right Image Position Adjustments
    $wp_customize->add_setting('si_featured_right_image_x_position', array(
        'default'           => '0',
            'sanitize_callback' => 'sanitize_text_field',
        ));

    $wp_customize->add_control('si_featured_right_image_x_position', array(
        'label'       => __('Right Image X Position', 'sports-illustrated'),
        'description' => __('Adjust the horizontal position of the right image (negative values move left, positive values move right).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'select',
        'choices'     => array(
            '-20' => __('-20%', 'sports-illustrated'),
            '-15' => __('-15%', 'sports-illustrated'),
            '-10' => __('-10%', 'sports-illustrated'),
            '-5'  => __('-5%', 'sports-illustrated'),
            '0'   => __('0% (Default)', 'sports-illustrated'),
            '5'   => __('5%', 'sports-illustrated'),
            '10'  => __('10%', 'sports-illustrated'),
            '15'  => __('15%', 'sports-illustrated'),
            '20'  => __('20%', 'sports-illustrated'),
        ),
    ));

    $wp_customize->add_setting('si_featured_right_image_y_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_right_image_y_position', array(
        'label'       => __('Right Image Y Position', 'sports-illustrated'),
        'description' => __('Adjust the vertical position of the right image (negative values move up, positive values move down).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'select',
        'choices'     => array(
            '-20' => __('-20%', 'sports-illustrated'),
            '-15' => __('-15%', 'sports-illustrated'),
            '-10' => __('-10%', 'sports-illustrated'),
            '-5'  => __('-5%', 'sports-illustrated'),
            '0'   => __('0% (Default)', 'sports-illustrated'),
            '5'   => __('5%', 'sports-illustrated'),
            '10'  => __('10%', 'sports-illustrated'),
            '15'  => __('15%', 'sports-illustrated'),
            '20'  => __('20%', 'sports-illustrated'),
        ),
    ));

    // Bottom Section Title
    $wp_customize->add_setting('si_featured_bottom_title', array(
        'default'           => __('A DINING EXPERIENCE LIKE NO OTHER', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_bottom_title', array(
        'label'       => __('Bottom Section Title', 'sports-illustrated'),
        'description' => __('Enter the title for the bottom section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Bottom Section Description
    $wp_customize->add_setting('si_featured_bottom_description', array(
        'default'           => __('Our signature dishes are inspired by the energy and spirit of sports, blending bold flavors with fresh, locally sourced ingredients. Whether you\'re catching the big game with friends or celebrating a special occasion, our menu features a lineup of winning options that include sizzling burgers, hand-crafted pizzas, zesty wings, and fresh, crisp salads.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_bottom_description', array(
        'label'       => __('Bottom Section Description', 'sports-illustrated'),
        'description' => __('Enter the description for the bottom section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Locations Section
    $wp_customize->add_setting('si_locations_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_locations_heading', array(
        'label'    => __('Locations Section', 'sports-illustrated'),
        'description' => __('Configure the locations section on the homepage.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'hidden',
    )));

    // Locations Title
    $wp_customize->add_setting('si_locations_title', array(
        'default'           => __('OUR LOCATIONS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_locations_title', array(
        'label'       => __('Locations Section Title', 'sports-illustrated'),
        'description' => __('The title displayed above the locations section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Enable Second Location
    $wp_customize->add_setting('si_enable_second_location', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));

    $wp_customize->add_control('si_enable_second_location', array(
        'label'       => __('Show Second Location', 'sports-illustrated'),
        'description' => __('Enable or disable the display of the second location.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'checkbox',
    ));

    // Location 1 Settings
    $wp_customize->add_setting('si_location_1_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_location_1_heading', array(
        'label'    => __('Location 1', 'sports-illustrated'),
        'description' => __('Configure the first location card.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'hidden',
    )));

    // Location 1 Image
    $wp_customize->add_setting('si_image_location_1', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_image_location_1', array(
        'label'    => __('Location 1 Image', 'sports-illustrated'),
        'description' => __('Select an image for the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'mime_type' => 'image',
    )));

    // Location 1 Name
    $wp_customize->add_setting('si_location_1_name', array(
        'default'           => __('SI CLUBHOUSE VANCOUVER', 'sports-illustrated'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

    $wp_customize->add_control('si_location_1_name', array(
        'label'    => __('Location 1 Name', 'sports-illustrated'),
        'description' => __('Enter the name of the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 1 Address
    $wp_customize->add_setting('si_location_1_address', array(
        'default'           => __('3340 Shrum Lane, Vancouver', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_1_address', array(
        'label'    => __('Location 1 Address', 'sports-illustrated'),
        'description' => __('Enter the address of the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 1 Hours
    $wp_customize->add_setting('si_location_1_hours', array(
        'default'           => __('Open | 11AM - 11PM Daily', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_1_hours', array(
        'label'    => __('Location 1 Hours', 'sports-illustrated'),
        'description' => __('Enter the hours of operation for the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 1 Happy Hour
    $wp_customize->add_setting('si_location_1_happy_hour', array(
        'default'           => __('Daily Happy Hour 3:00 - 5:00 PM', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_1_happy_hour', array(
        'label'    => __('Location 1 Happy Hour', 'sports-illustrated'),
        'description' => __('Enter the happy hour details for the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 1 Reservation URL
    $wp_customize->add_setting('si_location_1_reservation_url', array(
        'default'           => __('https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website', 'sports-illustrated'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_location_1_reservation_url', array(
        'label'    => __('Location 1 Reservation URL', 'sports-illustrated'),
        'description' => __('Enter the reservation URL for the first location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'url',
    ));

    // Location 2 Settings
    $wp_customize->add_setting('si_location_2_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_location_2_heading', array(
        'label'    => __('Location 2', 'sports-illustrated'),
        'description' => __('Configure the second location card.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'hidden',
    )));

    // Location 2 Image
    $wp_customize->add_setting('si_image_location_2', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_image_location_2', array(
        'label'    => __('Location 2 Image', 'sports-illustrated'),
        'description' => __('Select an image for the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
            'mime_type' => 'image',
        )));

    // Location 2 Name
    $wp_customize->add_setting('si_location_2_name', array(
        'default'           => __('SI CLUBHOUSE VANCOUVER', 'sports-illustrated'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

    $wp_customize->add_control('si_location_2_name', array(
        'label'    => __('Location 2 Name', 'sports-illustrated'),
        'description' => __('Enter the name of the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 2 Address
    $wp_customize->add_setting('si_location_2_address', array(
        'default'           => __('3340 Shrum Lane, Vancouver', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_2_address', array(
        'label'    => __('Location 2 Address', 'sports-illustrated'),
        'description' => __('Enter the address of the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 2 Hours
    $wp_customize->add_setting('si_location_2_hours', array(
        'default'           => __('Open | 11AM - 11PM Daily', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_2_hours', array(
        'label'    => __('Location 2 Hours', 'sports-illustrated'),
        'description' => __('Enter the hours of operation for the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 2 Happy Hour
    $wp_customize->add_setting('si_location_2_happy_hour', array(
        'default'           => __('Daily Happy Hour 3:00 - 5:00 PM', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_location_2_happy_hour', array(
        'label'    => __('Location 2 Happy Hour', 'sports-illustrated'),
        'description' => __('Enter the happy hour details for the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Location 2 Reservation URL
    $wp_customize->add_setting('si_location_2_reservation_url', array(
        'default'           => __('https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website', 'sports-illustrated'),
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_location_2_reservation_url', array(
        'label'    => __('Location 2 Reservation URL', 'sports-illustrated'),
        'description' => __('Enter the reservation URL for the second location.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'url',
    ));

    // Add Gift Cards Page Section
    $wp_customize->add_section('si_gift_cards_section', array(
        'title'       => __('Gift Cards Page', 'sports-illustrated'),
        'description' => __('Configure the Gift Cards page settings including background image, title, description, and call-to-action button.', 'sports-illustrated'),
        'priority'    => 30,
    ));

    // Background Image
    $wp_customize->add_setting('si_gift_cards_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_gift_cards_bg_image', array(
        'label'       => __('Background Image', 'sports-illustrated'),
        'description' => __('Select a background image for the Gift Cards page.', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_bg_image',
    )));

    // Background Opacity
    $wp_customize->add_setting('si_gift_cards_bg_opacity', array(
        'default'           => 0.5,
        'sanitize_callback' => 'si_sanitize_opacity',
    ));

    $wp_customize->add_control('si_gift_cards_bg_opacity', array(
        'label'       => __('Background Overlay Opacity', 'sports-illustrated'),
        'description' => __('Adjust the opacity of the dark overlay on the background image (0.0 = fully transparent, 1.0 = fully opaque).', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_bg_opacity',
        'type'        => 'select',
        'choices'     => array(
            '0.3' => __('30%', 'sports-illustrated'),
            '0.4' => __('40%', 'sports-illustrated'),
            '0.5' => __('50%', 'sports-illustrated'),
            '0.6' => __('60%', 'sports-illustrated'),
            '0.7' => __('70%', 'sports-illustrated'),
            '0.8' => __('80%', 'sports-illustrated'),
        ),
    ));

    // Title
    $wp_customize->add_setting('si_gift_cards_title', array(
        'default'           => __('GIVE THE GIFT OF FLAVOR!', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_title', array(
        'label'       => __('Page Title', 'sports-illustrated'),
        'description' => __('Enter the title for the Gift Cards page.', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_title',
        'type'        => 'text',
    ));

    // Description
    $wp_customize->add_setting('si_gift_cards_description', array(
        'default'           => __('Looking for the perfect gift for food lovers? Our gift cards make every occasion special. Treat your friends and family to a dining experience filled with delicious dishes, cozy ambiance, and unforgettable memories.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_gift_cards_description', array(
        'label'       => __('Page Description', 'sports-illustrated'),
        'description' => __('Enter the description text for the Gift Cards page.', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_description',
        'type'        => 'textarea',
    ));

    // CTA URL
    $wp_customize->add_setting('si_gift_cards_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_gift_cards_cta_url', array(
        'label'       => __('CTA Button URL', 'sports-illustrated'),
        'description' => __('Enter the URL for the "Buy Gift Cards" button.', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_cta_url',
        'type'        => 'url',
    ));

    // CTA Text
    $wp_customize->add_setting('si_gift_cards_cta_text', array(
        'default'           => __('BUY GIFT CARDS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_cta_text', array(
        'label'       => __('CTA Button Text', 'sports-illustrated'),
        'description' => __('Enter the text for the call-to-action button.', 'sports-illustrated'),
        'section'     => 'si_gift_cards_section',
        'settings'    => 'si_gift_cards_cta_text',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'si_home_page_customizer_settings');

function si_scripts() {
    // ... existing enqueues ...

    // Enqueue loading screen script
    wp_enqueue_script(
        'si-loading-screen',
        get_template_directory_uri() . '/assets/js/loading-screen.js',
        array(),
        SI_VERSION,
        true
    );

    // Enqueue animations script
    wp_enqueue_script(
        'si-animations',
        get_template_directory_uri() . '/assets/js/animations.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // ... existing code ...
}
add_action('wp_enqueue_scripts', 'si_scripts'); 

/**
 * Add customizer settings for header navigation
 */
function si_header_navigation_customizer($wp_customize) {
    // Add Header Navigation Section
    $wp_customize->add_section('si_header_navigation', array(
        'title'    => __('Header Navigation', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Left Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_left_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_left_menu_text_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'text',
        ));

        // Item URL
        $wp_customize->add_setting('si_left_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_left_menu_url_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'url',
        ));

        // Item Visibility
        $wp_customize->add_setting('si_left_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_left_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Left Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'checkbox',
        ));
    }

    // Right Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_right_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_right_menu_text_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'text',
        ));

        // Item URL
        $wp_customize->add_setting('si_right_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_right_menu_url_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'url',
        ));

        // Item Visibility
        $wp_customize->add_setting('si_right_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_right_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Right Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'checkbox',
        ));
    }

    // Menu Dropdown Settings
    $wp_customize->add_setting('si_enable_menu_dropdown', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));

    $wp_customize->add_control('si_enable_menu_dropdown', array(
        'label'    => __('Enable Menu Dropdown', 'sports-illustrated'),
        'section'  => 'si_header_navigation',
        'type'     => 'checkbox',
    ));
}
add_action('customize_register', 'si_header_navigation_customizer');

// Helper function to sanitize boolean values
if (!function_exists('rest_sanitize_boolean')) {
    function rest_sanitize_boolean($value) {
        return $value === true || $value === 'true' || $value === '1' || $value === 1 ? true : false;
    }
}

/**
 * Add customizer settings for footer pages
 */
function si_footer_customizer_settings($wp_customize) {
    // Add Footer Section
    $wp_customize->add_section('si_footer_section', array(
        'title'    => __('Footer Settings', 'sports-illustrated'),
        'description' => __('Configure the footer links and content.', 'sports-illustrated'),
        'priority' => 90,
    ));

    // Footer Links
    $footer_links = array(
        'link1' => array(
            'default_text' => 'GIFT CARDS',
            'default_page' => 'gift-cards'
        ),
        'link2' => array(
            'default_text' => 'GALLERY',
            'default_page' => 'gallery'
        ),
        'link3' => array(
            'default_text' => 'CAREERS',
            'default_page' => 'careers'
        ),
        'link4' => array(
            'default_text' => 'TERMS & CONDITIONS',
            'default_page' => 'terms'
        )
    );

    foreach ($footer_links as $link_id => $link_defaults) {
        // Link Text
        $wp_customize->add_setting('si_footer_' . $link_id . '_text', array(
            'default'           => $link_defaults['default_text'],
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_footer_' . $link_id . '_text', array(
            'label'    => sprintf(__('Footer Link %s Text', 'sports-illustrated'), substr($link_id, -1)),
            'description' => __('Enter the text for this footer link.', 'sports-illustrated'),
            'section'  => 'si_footer_section',
            'type'     => 'text',
        ));

        // Link Page
        $wp_customize->add_setting('si_footer_' . $link_id . '_page', array(
            'default'           => $link_defaults['default_page'],
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_footer_' . $link_id . '_page', array(
            'label'    => sprintf(__('Footer Link %s Page', 'sports-illustrated'), substr($link_id, -1)),
            'description' => __('Enter the page slug for this footer link.', 'sports-illustrated'),
            'section'  => 'si_footer_section',
            'type'     => 'text',
        ));

        // Link Visibility
        $wp_customize->add_setting('si_footer_' . $link_id . '_visible', array(
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_footer_' . $link_id . '_visible', array(
            'label'    => sprintf(__('Show Footer Link %s', 'sports-illustrated'), substr($link_id, -1)),
            'section'  => 'si_footer_section',
            'type'     => 'checkbox',
        ));
    }

    // Footer Address
    $wp_customize->add_setting('si_footer_address', array(
        'default'           => '3340 SHRUM LANE | VANCOUVER, BC',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_footer_address', array(
        'label'    => __('Footer Address', 'sports-illustrated'),
        'description' => __('Enter the address to display in the footer.', 'sports-illustrated'),
        'section'  => 'si_footer_section',
        'type'     => 'text',
    ));

    // Social Media Links
    $wp_customize->add_setting('si_footer_instagram', array(
        'default'           => 'https://www.instagram.com/si_clubhouse/',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_footer_instagram', array(
        'label'    => __('Instagram URL', 'sports-illustrated'),
        'description' => __('Enter the URL for your Instagram profile.', 'sports-illustrated'),
        'section'  => 'si_footer_section',
        'type'     => 'url',
    ));

    // Additional social media platforms can be added here
}
add_action('customize_register', 'si_footer_customizer_settings'); 

/**
 * Helper function to get background style
 */
function si_get_background_style($page_id) {
    $bg_image_id = get_theme_mod('si_' . $page_id . '_bg');
    $bg_opacity = get_theme_mod('si_' . $page_id . '_bg_opacity', '0.6');
    $style = '';
    
    if ($bg_image_id) {
        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');
        if ($bg_image_url) {
            $style = sprintf(
                'style="background-image: url(%s); --overlay-opacity: %s;"',
                esc_url($bg_image_url),
                esc_attr($bg_opacity)
            );
        }
    }
    
    return $style;
}

/**
 * Helper function to get menu card image URL
 */
function si_get_menu_card_image($card_id, $default = '') {
    $attachment_id = get_theme_mod('si_menu_card_' . $card_id . '_image');
    
    if ($attachment_id) {
        $image_url = wp_get_attachment_image_url($attachment_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    
    return $default;
}

/**
 * Helper function to get menu card link
 */
function si_get_menu_card_link($card_id) {
    $link = get_theme_mod('si_menu_card_' . $card_id . '_link', '#');
    
    if (empty($link)) {
        return '#';
    }
    
    return $link;
}

/**
 * Add page backgrounds customizer settings
 */
function si_page_backgrounds_customizer($wp_customize) {
    // Add Page Backgrounds Section
    $wp_customize->add_section('si_page_backgrounds', array(
        'title'    => __('Page Background Images', 'sports-illustrated'),
        'description' => __('Configure background images and overlay opacity for various pages throughout the site.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Define pages that need background images
    $pages = array(
        'menu'         => 'Menu Page',
        'careers'      => 'Careers Page',
        'news'         => 'News Page',
        'privacy'      => 'Privacy Policy Page',
        'reservations' => 'Reservations Page',
        'catering'     => 'Catering Page'
    );

    foreach ($pages as $page_id => $page_name) {
        // Background Image Setting
        $wp_customize->add_setting('si_' . $page_id . '_bg', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        // Background Image Control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_' . $page_id . '_bg', array(
            'label'    => $page_name . ' Background',
            'description' => sprintf(__('Select a background image for the %s.', 'sports-illustrated'), $page_name),
            'section'  => 'si_page_backgrounds',
            'mime_type' => 'image',
        )));

        // Background Overlay Opacity
        $wp_customize->add_setting('si_' . $page_id . '_bg_opacity', array(
            'default'           => '0.6',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_' . $page_id . '_bg_opacity', array(
            'label'    => $page_name . ' Overlay Opacity',
            'description' => sprintf(__('Set the darkness level of the overlay on the %s background (higher values = darker overlay).', 'sports-illustrated'), $page_name),
            'section'  => 'si_page_backgrounds',
            'type'     => 'select',
            'choices'  => array(
                '0.3' => '30%',
                '0.4' => '40%',
                '0.5' => '50%',
                '0.6' => '60%',
                '0.7' => '70%',
                '0.8' => '80%',
            ),
        ));
    }
}
add_action('customize_register', 'si_page_backgrounds_customizer');

/**
 * Helper function to get background style
 */
function si_get_background_style($page_id) {
    $bg_image_id = get_theme_mod('si_' . $page_id . '_bg');
    $bg_opacity = get_theme_mod('si_' . $page_id . '_bg_opacity', '0.6');
    $style = '';
    
    if ($bg_image_id) {
        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');
        if ($bg_image_url) {
            $style = sprintf(
                'style="background-image: url(%s); --overlay-opacity: %s;"',
                esc_url($bg_image_url),
                esc_attr($bg_opacity)
            );
        }
    }
    
    return $style;
} 