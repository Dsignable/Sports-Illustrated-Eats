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

// Include modular theme functions
require_once get_template_directory() . '/inc/theme-functions.php';

// Include reset drinks menu script if it exists
$reset_drinks_menu = get_template_directory() . '/reset-drinks-menu.php';
if (file_exists($reset_drinks_menu)) {
    require_once $reset_drinks_menu;
}

// Include menu diagnostics script if it exists
$menu_diagnostics = get_template_directory() . '/menu-diagnostics.php';
if (file_exists($menu_diagnostics)) {
    require_once $menu_diagnostics;
}

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
 * Add featured image column to posts admin screen
 */
function si_add_thumbnail_column($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns[$key] = $value;
            $new_columns['thumbnail'] = __('Featured Image', 'sports-illustrated');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_posts_columns', 'si_add_thumbnail_column');
add_filter('manage_pages_columns', 'si_add_thumbnail_column');

/**
 * Display featured image in the posts admin column
 */
function si_display_thumbnail_column($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            $thumbnail_id = get_post_thumbnail_id($post_id);
            $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
            echo '<img src="' . esc_url($thumbnail[0]) . '" alt="' . esc_attr(get_the_title($post_id)) . '" />';
        } else {
            echo '<div class="no-thumbnail"></div>';
        }
    }
}
add_action('manage_posts_custom_column', 'si_display_thumbnail_column', 10, 2);
add_action('manage_pages_custom_column', 'si_display_thumbnail_column', 10, 2);

/**
 * Add admin notice for posts without featured images
 */
function si_check_featured_image_admin_notice() {
    global $pagenow, $post;
    
    // Only show on post edit screen for posts
    if ($pagenow === 'post.php' && get_post_type($post) === 'post' && !has_post_thumbnail($post->ID)) {
        ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php _e('Featured Image Missing:', 'sports-illustrated'); ?></strong> 
                <?php _e('This post does not have a featured image set. Featured images are displayed on the News page and improve the visual appeal of your content.', 'sports-illustrated'); ?>
                <a href="#postimagediv"><?php _e('Set Featured Image', 'sports-illustrated'); ?></a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'si_check_featured_image_admin_notice');

/**
 * Make featured image metabox more prominent
 */
function si_featured_image_style() {
    global $post_type;
    
    if ($post_type === 'post') {
        ?>
        <style type="text/css">
            #postimagediv {
                background-color: #f8f8f8;
                border-left: 4px solid #0073aa;
                padding: 10px;
                margin-bottom: 20px;
            }
            #postimagediv .hndle {
                font-size: 16px;
                color: #0073aa;
            }
            #postimagediv .inside {
                padding: 10px;
            }
            #postimagediv #set-post-thumbnail {
                display: inline-block;
                padding: 8px 12px;
                background: #0073aa;
                color: #fff;
                text-decoration: none;
                border-radius: 3px;
                margin: 10px 0;
            }
            #postimagediv #set-post-thumbnail:hover {
                background: #005d87;
            }
        </style>
        <?php
    }
}
add_action('admin_head-post.php', 'si_featured_image_style');
add_action('admin_head-post-new.php', 'si_featured_image_style');

/**
 * Register widget area
 * Note: This function has been moved to inc/widgets.php
 */
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
// require get_template_directory() . '/inc/customizer/page-customizer.php';

/**
 * Home Page Customizer Settings
 * Note: This function has been moved to inc/customizer/home-page.php
 */

// Remove the old menu cards customizer function since we're moving it to the Home Page section

/**
 * Add Home Page customizer settings
 */
add_action('customize_register', 'si_home_page_customizer_settings');

function si_scripts() {
    // Loading screen script
    wp_enqueue_script(
        'sports-illustrated-loading-screen',
        get_theme_file_uri('/assets/js/loading-screen.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Header script
    wp_enqueue_script(
        'sports-illustrated-header',
        get_theme_file_uri('/assets/js/header.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Animations script
    wp_enqueue_script(
        'sports-illustrated-animations',
        get_theme_file_uri('/assets/js/animations.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Menu pages script
    wp_enqueue_script(
        'sports-illustrated-menu-pages',
        get_theme_file_uri('/assets/js/menu-pages.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Main stylesheet
    wp_enqueue_style(
        'sports-illustrated-style',
        get_theme_file_uri('/assets/css/main.css'),
        array(),
        SI_VERSION
    );

    // Responsive fixes
    wp_enqueue_style(
        'sports-illustrated-responsive',
        get_theme_file_uri('/assets/css/responsive.css'),
        array(),
        SI_VERSION
    );

    // Menu styles
    wp_enqueue_style(
        'sports-illustrated-menu',
        get_theme_file_uri('/assets/css/menu.css'),
        array(),
        SI_VERSION
    );
    
    // Enqueue mobile menu styles
    wp_enqueue_style('si-mobile-menu', get_template_directory_uri() . '/assets/css/mobile-menu.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'si_scripts');

/**
 * Add customizer settings for header navigation
 */
function si_header_navigation_customizer($wp_customize) {
    // Create the panel if it doesn't exist
    if (!$wp_customize->get_panel('si_header_navigation')) {
        $wp_customize->add_panel('si_header_navigation', array(
            'title' => __('Header Navigation', 'sports-illustrated'),
            'priority' => 30
        ));
    }

    // Add Menu Dropdown Options subsection
    $wp_customize->add_section('si_header_menu_dropdown', array(
        'title' => __('Menu Dropdown Options', 'sports-illustrated'),
        'priority' => 10,
        'panel' => 'si_header_navigation'
    ));

    // Enable Menu Dropdown Toggle
    $wp_customize->add_setting('si_enable_menu_dropdown', array(
        'default' => true,
        'sanitize_callback' => 'si_sanitize_checkbox'
    ));

    $wp_customize->add_control('si_enable_menu_dropdown', array(
        'label' => __('Enable Menu Dropdown', 'sports-illustrated'),
        'section' => 'si_header_menu_dropdown',
        'type' => 'checkbox'
    ));

    // Menu Types
    $menu_types = array(
        'full' => 'Full Menu',
        'drink' => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy' => 'Happy Hour',
        'today' => 'Today\'s Menu'
    );

    foreach ($menu_types as $key => $default_label) {
        // Menu Item Text
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_text', array(
            'default' => $default_label,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_text', array(
            'label' => sprintf(__('%s Text', 'sports-illustrated'), $default_label),
            'section' => 'si_header_menu_dropdown',
            'type' => 'text'
        ));

        // Menu Item Visibility
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_visible', array(
            'default' => true,
            'sanitize_callback' => 'si_sanitize_checkbox'
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_visible', array(
            'label' => sprintf(__('Show %s', 'sports-illustrated'), $default_label),
            'section' => 'si_header_menu_dropdown',
            'type' => 'checkbox'
        ));
    }

    // Existing header navigation settings...
    $wp_customize->add_section('si_header_navigation_section', array(
        'title' => __('Navigation Links', 'sports-illustrated'),
        'priority' => 20,
        'panel' => 'si_header_navigation'
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

        // Has Dropdown
        $wp_customize->add_setting('si_right_menu_has_dropdown_' . $i, array(
            'default'           => $i == 3, // Default true for Contact Us (3rd item)
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_right_menu_has_dropdown_' . $i, array(
            'label'    => sprintf(__('Enable Dropdown for Right Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'checkbox',
        ));

        // Dropdown Items (up to 5)
        for ($j = 1; $j <= 5; $j++) {
            // Dropdown Item Text
            $wp_customize->add_setting('si_right_menu_dropdown_' . $i . '_text_' . $j, array(
                'default'           => $i == 3 && $j == 1 ? 'CONTACT THE RESTAURANT' : ($i == 3 && $j == 2 ? 'FRANCHISE OPPORTUNITIES' : ''),
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('si_right_menu_dropdown_' . $i . '_text_' . $j, array(
                'label'    => sprintf(__('Right Menu Item %d Dropdown Item %d Text', 'sports-illustrated'), $i, $j),
                'section'  => 'si_header_navigation',
                'type'     => 'text',
                'active_callback' => function() use ($wp_customize, $i) {
                    return get_theme_mod('si_right_menu_has_dropdown_' . $i, false);
                },
            ));

            // Dropdown Item URL
            $wp_customize->add_setting('si_right_menu_dropdown_' . $i . '_url_' . $j, array(
                'default'           => $i == 3 && $j == 1 ? home_url('/contact/') : ($i == 3 && $j == 2 ? home_url('/franchise/') : ''),
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control('si_right_menu_dropdown_' . $i . '_url_' . $j, array(
                'label'    => sprintf(__('Right Menu Item %d Dropdown Item %d URL', 'sports-illustrated'), $i, $j),
                'section'  => 'si_header_navigation',
                'type'     => 'url',
                'active_callback' => function() use ($wp_customize, $i) {
                    return get_theme_mod('si_right_menu_has_dropdown_' . $i, false);
                },
            ));

            // Dropdown Item Visibility
            $wp_customize->add_setting('si_right_menu_dropdown_' . $i . '_visible_' . $j, array(
                'default'           => $i == 3 && ($j == 1 || $j == 2),
                'sanitize_callback' => 'rest_sanitize_boolean',
            ));

            $wp_customize->add_control('si_right_menu_dropdown_' . $i . '_visible_' . $j, array(
                'label'    => sprintf(__('Show Right Menu Item %d Dropdown Item %d', 'sports-illustrated'), $i, $j),
                'section'  => 'si_header_navigation',
                'type'     => 'checkbox',
                'active_callback' => function() use ($wp_customize, $i) {
                    return get_theme_mod('si_right_menu_has_dropdown_' . $i, false);
                },
            ));
        }
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
    
    // Menu Dropdown URLs
    $wp_customize->add_setting('si_menu_dropdown_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_menu_dropdown_heading', array(
        'label'       => __('Menu Dropdown URLs', 'sports-illustrated'),
        'description' => __('Configure the URLs for each menu dropdown item.', 'sports-illustrated'),
        'section'     => 'si_header_navigation',
        'type'        => 'hidden',
    )));
    
    // Menu dropdown items
    $menu_items = array(
        'full'   => __('Full Menu', 'sports-illustrated'),
        'drink'  => __('Drink Menu', 'sports-illustrated'),
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'happy'  => __('Happy Hour', 'sports-illustrated'),
        'today'  => __('Today\'s Menu', 'sports-illustrated')
    );
    
    foreach ($menu_items as $key => $label) {
        $wp_customize->add_setting('si_menu_dropdown_url_' . $key, array(
            'default'           => home_url('/menu/?menu=' . $key),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ));
        
        $wp_customize->add_control('si_menu_dropdown_url_' . $key, array(
            'label'       => sprintf(__('%s URL', 'sports-illustrated'), $label),
            'description' => __('Enter the full URL including https://', 'sports-illustrated'),
            'section'     => 'si_header_navigation',
            'type'        => 'url',
        ));
    }
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
 * Menu Card Functions
 * Note: These functions have been moved to inc/menu-utilities.php
 */

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
        'catering'     => 'Catering Page',
        'franchise'    => 'Franchise Page',
        'gift_cards'   => 'Gift Cards Page'
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
 * Add news page customizer settings
 */
function si_news_page_customizer($wp_customize) {
    // Add News Page Section
    $wp_customize->add_section('si_news_section', array(
        'title'    => __('News Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the news page.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // News Page Title
    $wp_customize->add_setting('si_news_title', array(
        'default'           => __('LATEST NEWS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_news_title', array(
        'label'    => __('News Page Title', 'sports-illustrated'),
        'description' => __('Enter the title for the news page.', 'sports-illustrated'),
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
        'description' => __('Enter the description for the news page.', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'type'     => 'textarea',
    ));

    // Default Featured Image
    $wp_customize->add_setting('si_default_news_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_default_news_image', array(
        'label'    => __('Default Featured Image', 'sports-illustrated'),
        'description' => __('Select a default image to use for news posts that don\'t have a featured image set.', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'mime_type' => 'image',
    )));

    // Posts Per Page
    $wp_customize->add_setting('si_news_posts_per_page', array(
        'default'           => 9,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('si_news_posts_per_page', array(
        'label'    => __('Posts Per Page', 'sports-illustrated'),
        'description' => __('Set how many posts to display per page.', 'sports-illustrated'),
        'section'  => 'si_news_section',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 3,
            'max' => 24,
            'step' => 3,
        ),
    ));
}
add_action('customize_register', 'si_news_page_customizer');

/**
 * Add gift cards page customizer settings
 */
function si_gift_cards_customizer($wp_customize) {
    // Add Gift Cards Page Section
    $wp_customize->add_section('si_gift_cards_section', array(
        'title'    => __('Gift Cards Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the gift cards page.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Gift Cards Title
    $wp_customize->add_setting('si_gift_cards_title', array(
        'default'           => __('GIVE THE GIFT OF FLAVOR!', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'text',
    ));

    // Gift Cards Description
    $wp_customize->add_setting('si_gift_cards_description', array(
        'default'           => __('Looking for the perfect gift for food lovers? Our gift cards make every occasion special. Treat your friends and family to a dining experience filled with delicious dishes, cozy ambiance, and unforgettable memories.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_gift_cards_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'textarea',
    ));

    // CTA Button URL
    $wp_customize->add_setting('si_gift_cards_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_gift_cards_cta_url', array(
        'label'    => __('CTA Button URL', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'url',
    ));

    // CTA Button Text
    $wp_customize->add_setting('si_gift_cards_cta_text', array(
        'default'           => __('BUY GIFT CARDS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_cta_text', array(
        'label'    => __('CTA Button Text', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'si_gift_cards_customizer');

/**
 * Add catering page customizer settings
 */
function si_catering_customizer($wp_customize) {
    // Add Catering Page Section
    $wp_customize->add_section('si_catering_section', array(
        'title'    => __('Catering Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the catering page.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Catering Title
    $wp_customize->add_setting('si_catering_title', array(
        'default'           => __('CATERING & EVENTS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_catering_section',
        'type'     => 'text',
    ));

    // Catering Description
    $wp_customize->add_setting('si_catering_description', array(
        'default'           => __('Let us cater your next event with our delicious menu options. Fill out the form below to get started.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_catering_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'section'  => 'si_catering_section',
        'type'     => 'textarea',
    ));

    // Catering Image
    $wp_customize->add_setting('si_catering_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_catering_image', array(
        'label'    => __('Catering Image', 'sports-illustrated'),
        'description' => __('Select an image to display on the catering page.', 'sports-illustrated'),
        'section'  => 'si_catering_section',
        'mime_type' => 'image',
    )));

    // Contact Form 7 ID
    $wp_customize->add_setting('si_catering_form_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_form_id', array(
        'label'    => __('Contact Form 7 ID', 'sports-illustrated'),
        'description' => __('Enter the ID of the Contact Form 7 form to use on the catering page.', 'sports-illustrated'),
        'section'  => 'si_catering_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'si_catering_customizer');

/**
 * Add franchise page customizer settings
 */
function si_franchise_customizer($wp_customize) {
    // Add Franchise Page Section
    $wp_customize->add_section('si_franchise_section', array(
        'title'    => __('Franchise Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the franchise page.', 'sports-illustrated'),
        'priority' => 31,
    ));

    // Franchise Title
    $wp_customize->add_setting('si_franchise_title', array(
        'default'           => __('FRANCHISE OPPORTUNITIES', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_franchise_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_franchise_section',
        'type'     => 'text',
    ));

    // Franchise Description
    $wp_customize->add_setting('si_franchise_description', array(
        'default'           => __('Join the Sports Illustrated family by becoming a franchise owner. Fill out the form below to get started with your franchise application.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_franchise_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'section'  => 'si_franchise_section',
        'type'     => 'textarea',
    ));

    // Franchise Image
    $wp_customize->add_setting('si_franchise_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_franchise_image', array(
        'label'    => __('Franchise Image', 'sports-illustrated'),
        'description' => __('Select an image to display on the franchise page.', 'sports-illustrated'),
        'section'  => 'si_franchise_section',
        'mime_type' => 'image',
    )));

    // Contact Form 7 ID
    $wp_customize->add_setting('si_franchise_form_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_franchise_form_id', array(
        'label'    => __('Contact Form 7 ID', 'sports-illustrated'),
        'description' => __('Enter the ID of the Contact Form 7 form to use on the franchise page.', 'sports-illustrated'),
        'section'  => 'si_franchise_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'si_franchise_customizer');

/**
 * Add contact page customizer settings
 */
function si_contact_customizer($wp_customize) {
    // Add Contact Page Section
    $wp_customize->add_section('si_contact_section', array(
        'title'    => __('Contact Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the contact page.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Contact Display Type
    $wp_customize->add_setting('si_contact_display_type', array(
        'default'           => 'static',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_contact_display_type', array(
        'label'    => __('Contact Display Type', 'sports-illustrated'),
        'description' => __('Choose how to display contact information.', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'type'     => 'select',
        'choices'  => array(
            'static' => __('Static Information', 'sports-illustrated'),
            'form'   => __('Contact Form', 'sports-illustrated'),
        ),
    ));

    // Contact Title
    $wp_customize->add_setting('si_contact_title', array(
        'default'           => __('CONTACT US', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_contact_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'type'     => 'text',
    ));

    // Contact Email
    $wp_customize->add_setting('si_contact_email', array(
        'default'           => 'admin@sportsillustratedeats.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('si_contact_email', array(
        'label'    => __('Contact Email', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'type'     => 'email',
    ));

    // Contact Phone
    $wp_customize->add_setting('si_contact_phone', array(
        'default'           => '(236) 471-7643',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_contact_phone', array(
        'label'    => __('Contact Phone', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'type'     => 'text',
    ));

    // Contact Message
    $wp_customize->add_setting('si_contact_message', array(
        'default'           => __('Thank you for your interest in Sports Illustrated Clubhouse. For reservations, event inquiries, or general questions, please contact us using the information below. We look forward to hearing from you!', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_contact_message', array(
        'label'    => __('Contact Message', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'type'     => 'textarea',
    ));

    // Contact Image
    $wp_customize->add_setting('si_contact_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_contact_image', array(
        'label'    => __('Contact Image', 'sports-illustrated'),
        'description' => __('Select an image to display on the contact page.', 'sports-illustrated'),
        'section'  => 'si_contact_section',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_contact_customizer');

/**
 * Menu Page Customizer Settings
 */
function si_menu_page_customizer($wp_customize) {
    // This function is now consolidated into si_menu_display_type_customizer
}
// Remove the action hook for this function
remove_action('customize_register', 'si_menu_page_customizer');

/**
 * Add loading screen customizer settings
 */
function si_loading_screen_customizer($wp_customize) {
    // Add Loading Screen Section
    $wp_customize->add_section('si_loading_screen_section', array(
        'title'    => __('Loading Screen', 'sports-illustrated'),
        'description' => __('Configure the loading screen settings.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Enable Loading Screen
    $wp_customize->add_setting('si_enable_loading_screen', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));

    $wp_customize->add_control('si_enable_loading_screen', array(
        'label'    => __('Enable Loading Screen', 'sports-illustrated'),
        'description' => __('Show a loading screen when the site first loads.', 'sports-illustrated'),
        'section'  => 'si_loading_screen_section',
        'type'     => 'checkbox',
    ));
}
add_action('customize_register', 'si_loading_screen_customizer');

/**
 * Helper function to get image URL from theme mod or fallback
 */
function si_get_image_url($theme_mod_key, $default = '') {
    $image_id = get_theme_mod($theme_mod_key);
    
    if ($image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    
    return $default;
}

/**
 * Helper function to get menu URL
function si_get_default_news_image() {
    $default_image_id = get_theme_mod('si_default_news_image');
    
    if ($default_image_id) {
        $image_url = wp_get_attachment_image_url($default_image_id, 'news-thumbnail');
        if ($image_url) {
            return $image_url;
        }
    }
    
    return get_theme_file_uri('assets/images/placeholder-news.jpg');
}

/**
 * Modify the featured image metabox text
 */
function si_featured_image_metabox_text($content) {
    global $post_type;
    
    if ($post_type === 'post') {
        $content = str_replace(
            __('Set featured image'),
            __('Set Featured Image (Required for News Page)', 'sports-illustrated'),
            $content
        );
        
        $content = str_replace(
            __('Remove featured image'),
            __('Remove Featured Image (Not Recommended)', 'sports-illustrated'),
            $content
        );
        
        // Add additional instructions
        $instructions = '<p class="description">' . __('Featured images are displayed on the News page and improve the visual appeal of your content. Recommended size: 800×450 pixels.', 'sports-illustrated') . '</p>';
/**
 * Menu URL Function
 * Note: This function has been moved to inc/menu-utilities.php
 */
        $content = preg_replace('/(id="set-post-thumbnail".*?<\/a>)/s', '$1' . $instructions, $content);
    }
    
    return $content;
}
add_filter('admin_post_thumbnail_html', 'si_featured_image_metabox_text');

/**
 * Add custom image sizes for news thumbnails
 */
function si_add_image_sizes() {
    // Add specific image size for news thumbnails with cropping
    add_image_size('news-card', 800, 450, true);
    
    // Add image size for news thumbnails in admin
    add_image_size('news-admin-thumb', 300, 169, true);
    
    // Add image size for menu images
    add_image_size('menu-image', 1200, 1800, false);
}
add_action('after_setup_theme', 'si_add_image_sizes');

/**
 * Add custom image sizes to media library dropdown
 */
function si_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'news-card' => __('News Card (800×450)', 'sports-illustrated'),
        'menu-image' => __('Menu Image (1200×1800)', 'sports-illustrated'),
    ));
}
add_filter('image_size_names_choose', 'si_custom_image_sizes');

/**
 * Add featured image to Quick Edit
 */
function si_quick_edit_featured_image() {
    // Only run on the post list page
    $screen = get_current_screen();
    if ($screen->base !== 'edit' || $screen->post_type !== 'post') {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Add featured image field to Quick Edit
        $('#wpbody').on('click', '.editinline', function() {
            // Get the post ID
            var post_id = $(this).closest('tr').attr('id').replace('post-', '');
            
            // Add the featured image field
            if ($('#quick-edit-featured-image').length === 0) {
                $('.inline-edit-col-right .inline-edit-col').append(
                    '<div class="inline-edit-group wp-clearfix" id="quick-edit-featured-image">' +
                    '<label class="alignleft"><span class="title">Featured Image</span></label>' +
                    '<div class="alignleft">' +
                    '<button type="button" class="button-secondary quick-set-featured-image" data-post-id="' + post_id + '">Set Featured Image</button>' +
                    '</div>' +
                    '</div>'
                );
            } else {
                $('.quick-set-featured-image').attr('data-post-id', post_id);
            }
            
            // Handle click on Set Featured Image button
            $('.quick-set-featured-image').off('click').on('click', function(e) {
                e.preventDefault();
                var post_id = $(this).data('post-id');
                
                // Close the Quick Edit panel
                $('.button-cancel').click();
                
                // Open the featured image modal
                wp.media.featuredImage.frame().open();
                
                // Set the post ID
                wp.media.featuredImage.set(post_id);
                
                // Refresh the page after selection
                wp.media.featuredImage.frame().on('select', function() {
                    location.reload();
                });
            });
        });
    });
    </script>
    <style type="text/css">
    #quick-edit-featured-image {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
    }
    .quick-set-featured-image {
        background: #0073aa !important;
        color: white !important;
        border-color: #0073aa !important;
        padding: 4px 12px !important;
    }
    </style>
    <?php
}
add_action('admin_footer', 'si_quick_edit_featured_image');

/**
 * Add bulk action to set featured images
 */
function si_add_bulk_actions_featured_image() {
    $screen = get_current_screen();
    if ($screen->base !== 'edit' || $screen->post_type !== 'post') {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Add bulk action
        $('select[name="action"]').append(
            $('<option>').val('set_featured_image').text('Set Featured Image')
        );
        $('select[name="action2"]').append(
            $('<option>').val('set_featured_image').text('Set Featured Image')
        );
        
        // Handle bulk action
        $('#doaction, #doaction2').click(function(e) {
            var action = $(this).prev('select').val();
            if (action === 'set_featured_image') {
                e.preventDefault();
                
                // Get selected post IDs
                var post_ids = [];
                $('input[name="post[]"]:checked').each(function() {
                    post_ids.push($(this).val());
                });
                
                if (post_ids.length === 0) {
                    alert('Please select at least one post.');
                    return;
                }
                
                // Store post IDs in localStorage
                localStorage.setItem('si_bulk_featured_image_posts', JSON.stringify(post_ids));
                
                // Open media library
                var frame = wp.media({
                    title: 'Select Featured Image for ' + post_ids.length + ' Posts',
                    button: {
                        text: 'Set Featured Image'
                    },
                    multiple: false
                });
                
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    var image_id = attachment.id;
                    var post_ids = JSON.parse(localStorage.getItem('si_bulk_featured_image_posts'));
                    
                    // Show loading message
                    $('body').append('<div id="si-bulk-loading" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.7); z-index:99999; display:flex; align-items:center; justify-content:center;"><div style="background:white; padding:20px; border-radius:5px;"><p>Setting featured images for ' + post_ids.length + ' posts...</p><div style="height:10px; background:#f0f0f0; margin-top:10px;"><div id="si-bulk-progress" style="height:10px; background:#0073aa; width:0%;"></div></div></div></div>');
                    
                    // Process posts one by one
                    var processed = 0;
                    function processNext() {
                        if (processed >= post_ids.length) {
                            // All done, reload page
                            localStorage.removeItem('si_bulk_featured_image_posts');
                            location.reload();
                            return;
                        }
                        
                        var post_id = post_ids[processed];
                        
                        // Update progress
                        var progress = Math.round((processed / post_ids.length) * 100);
                        $('#si-bulk-progress').css('width', progress + '%');
                        
                        // Set featured image via AJAX
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'si_set_featured_image',
                                post_id: post_id,
                                image_id: image_id,
                                nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                            },
                            success: function() {
                                processed++;
                                processNext();
                            },
                            error: function() {
                                processed++;
                                processNext();
                            }
                        });
                    }
                    
                    // Start processing
                    processNext();
                });
                
                frame.open();
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'si_add_bulk_actions_featured_image');

/**
 * AJAX handler for setting featured image
 */
function si_ajax_set_featured_image() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'si_set_featured_image')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Check permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied');
    }
    
    // Get post ID and image ID
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $image_id = isset($_POST['image_id']) ? intval($_POST['image_id']) : 0;
    
    if ($post_id && $image_id) {
        // Set featured image
        set_post_thumbnail($post_id, $image_id);
        wp_send_json_success();
    } else {
        wp_send_json_error('Invalid post ID or image ID');
    }
}
add_action('wp_ajax_si_set_featured_image', 'si_ajax_set_featured_image');

/**
 * Add a featured image management page
 */
function si_add_featured_image_management_page() {
    add_submenu_page(
        'edit.php',
        __('Manage Featured Images', 'sports-illustrated'),
        __('Featured Images', 'sports-illustrated'),
        'edit_posts',
        'manage-featured-images',
        'si_featured_image_management_page_callback'
    );
}
add_action('admin_menu', 'si_add_featured_image_management_page');

/**
 * Featured image management page callback
 */
function si_featured_image_management_page_callback() {
    // Process form submission for default image
    if (isset($_POST['si_set_default_featured_image']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'si_set_default_featured_image')) {
        $image_id = isset($_POST['default_featured_image_id']) ? intval($_POST['default_featured_image_id']) : 0;
        update_option('si_default_featured_image', $image_id);
        echo '<div class="notice notice-success"><p>' . __('Default featured image updated successfully.', 'sports-illustrated') . '</p></div>';
    }
    
    // Process auto-set featured images
    if (isset($_POST['si_auto_set_featured_images']) && isset($_POST['si_auto_set_featured_images_nonce']) && wp_verify_nonce($_POST['si_auto_set_featured_images_nonce'], 'si_auto_set_featured_images')) {
        $count = si_bulk_auto_set_featured_images();
        echo '<div class="notice notice-success"><p>' . sprintf(__('Featured images have been automatically set for %d posts.', 'sports-illustrated'), $count) . '</p></div>';
    }
    
    // Get posts without featured images
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    $posts_without_featured_image = get_posts($args);
    
    // Get default featured image
    $default_featured_image_id = get_option('si_default_featured_image', 0);
    $default_featured_image_url = $default_featured_image_id ? wp_get_attachment_image_url($default_featured_image_id, 'medium') : '';
    
    ?>
    <div class="wrap">
        <h1><?php _e('Manage Featured Images', 'sports-illustrated'); ?></h1>
        
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Default Featured Image', 'sports-illustrated'); ?></h2>
            <p><?php _e('Set a default featured image to use for posts that don\'t have one.', 'sports-illustrated'); ?></p>
            
            <form method="post" action="">
                <?php wp_nonce_field('si_set_default_featured_image'); ?>
                <div style="margin-bottom: 20px;">
                    <div id="default-featured-image-preview" style="margin-bottom: 10px; max-width: 300px;">
                        <?php if ($default_featured_image_url) : ?>
                            <img src="<?php echo esc_url($default_featured_image_url); ?>" style="max-width: 100%; height: auto;" />
                        <?php else : ?>
                            <div style="width: 300px; height: 169px; background: #f0f0f0; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center;">
                                <span><?php _e('No default image set', 'sports-illustrated'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="default_featured_image_id" id="default-featured-image-id" value="<?php echo esc_attr($default_featured_image_id); ?>" />
                    <button type="button" class="button-secondary" id="select-default-featured-image"><?php _e('Select Image', 'sports-illustrated'); ?></button>
                    <?php if ($default_featured_image_id) : ?>
                        <button type="button" class="button-secondary" id="remove-default-featured-image"><?php _e('Remove Image', 'sports-illustrated'); ?></button>
                    <?php endif; ?>
                </div>
                <input type="submit" name="si_set_default_featured_image" class="button-primary" value="<?php _e('Save Default Image', 'sports-illustrated'); ?>" />
            </form>
        </div>
        
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Auto-Set Featured Images', 'sports-illustrated'); ?></h2>
            <p><?php _e('Automatically set featured images for all posts that don\'t have one. The system will try to use the first image from each post\'s content, or fall back to the default image.', 'sports-illustrated'); ?></p>
            
            <form method="post" action="">
                <?php wp_nonce_field('si_auto_set_featured_images', 'si_auto_set_featured_images_nonce'); ?>
                <p>
                    <input type="submit" name="si_auto_set_featured_images" class="button-primary" value="<?php _e('Auto-Set Featured Images', 'sports-illustrated'); ?>">
                </p>
            </form>
        </div>
        
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Posts Without Featured Images', 'sports-illustrated'); ?></h2>
            <p><?php _e('These posts don\'t have a featured image set. Click on a post to edit it and set a featured image.', 'sports-illustrated'); ?></p>
            
            <?php if (empty($posts_without_featured_image)) : ?>
                <p><strong><?php _e('All posts have featured images set. Great job!', 'sports-illustrated'); ?></strong></p>
            <?php else : ?>
                <p><button type="button" class="button-primary" id="set-all-featured-images"><?php _e('Set Featured Image for All Posts', 'sports-illustrated'); ?></button></p>
                
                <table class="widefat striped">
                    <thead>
                        <tr>
                            <th><?php _e('Post Title', 'sports-illustrated'); ?></th>
                            <th><?php _e('Date', 'sports-illustrated'); ?></th>
                            <th><?php _e('Actions', 'sports-illustrated'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts_without_featured_image as $post) : ?>
                            <tr>
                                <td><a href="<?php echo get_edit_post_link($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a></td>
                                <td><?php echo get_the_date('', $post->ID); ?></td>
                                <td>
                                    <a href="<?php echo get_edit_post_link($post->ID); ?>#postimagediv" class="button-secondary"><?php _e('Edit Post', 'sports-illustrated'); ?></a>
                                    <button type="button" class="button-secondary set-single-featured-image" data-post-id="<?php echo esc_attr($post->ID); ?>"><?php _e('Set Image', 'sports-illustrated'); ?></button>
                                    <button type="button" class="button-secondary auto-set-single-featured-image" data-post-id="<?php echo esc_attr($post->ID); ?>"><?php _e('Auto-Set', 'sports-illustrated'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Media uploader for default featured image
        $('#select-default-featured-image').click(function(e) {
            e.preventDefault();
            
            // Create and open media frame
            var frame = wp.media({
                title: '<?php _e('Select Default Featured Image', 'sports-illustrated'); ?>',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: '<?php _e('Set as default', 'sports-illustrated'); ?>'
                }
            });
            
            // When an image is selected in the media frame
            frame.on('select', function() {
                // Get media attachment details
                var attachment = frame.state().get('selection').first().toJSON();
                
                // Set the featured image ID
                $('#default-featured-image-id').val(attachment.id);
                
                // Update the preview
                $('#default-featured-image-preview').html('<img src="' + attachment.url + '" style="max-width: 100%; height: auto;" />');
                
                // Show the remove button
                $('#remove-default-featured-image').show();
            });
            
            // Open the media library frame
            frame.open();
        });
        
        // Remove default featured image
        $('#remove-default-featured-image').click(function(e) {
            e.preventDefault();
            
            // Clear the featured image ID
            $('#default-featured-image-id').val('');
            
            // Update the preview
            $('#default-featured-image-preview').html('<div style="width: 300px; height: 169px; background: #f0f0f0; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center;"><span><?php _e('No default image set', 'sports-illustrated'); ?></span></div>');
            
            // Hide the remove button
            $(this).hide();
        });
        
        // Set featured image for a single post
        $('.set-single-featured-image').click(function(e) {
            e.preventDefault();
            
            var postId = $(this).data('post-id');
            var button = $(this);
            
            // Create and open media frame
            var frame = wp.media({
                title: '<?php _e('Select Featured Image', 'sports-illustrated'); ?>',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: '<?php _e('Set as featured image', 'sports-illustrated'); ?>'
                }
            });
            
            // When an image is selected in the media frame
            frame.on('select', function() {
                // Get media attachment details
                var attachment = frame.state().get('selection').first().toJSON();
                
                // Show loading state
                button.text('<?php _e('Saving...', 'sports-illustrated'); ?>').prop('disabled', true);
                
                // Save the featured image via AJAX
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'si_set_featured_image',
                        post_id: postId,
                        image_id: attachment.id,
                        nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                    },
                    success: function(response) {
                        // Remove the row
                        button.closest('tr').fadeOut(function() {
                            $(this).remove();
                            
                            // Check if there are any rows left
                            if ($('table tbody tr').length === 0) {
                                $('table').replaceWith('<p><strong><?php _e('All posts have featured images set. Great job!', 'sports-illustrated'); ?></strong></p>');
                                $('#set-all-featured-images').hide();
                            }
                        });
                    },
                    error: function() {
                        button.text('<?php _e('Error', 'sports-illustrated'); ?>').prop('disabled', false);
                    }
                });
            });
            
            // Open the media library frame
            frame.open();
        });
        
        // Auto-set featured image for a single post
        $('.auto-set-single-featured-image').click(function(e) {
            e.preventDefault();
            
            var postId = $(this).data('post-id');
            var button = $(this);
            
            // Show loading state
            button.text('<?php _e('Processing...', 'sports-illustrated'); ?>').prop('disabled', true);
            
            // Auto-set the featured image via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'si_auto_set_featured_image_ajax',
                    post_id: postId,
                    nonce: '<?php echo wp_create_nonce('si_auto_set_featured_image_ajax'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the row
                        button.closest('tr').fadeOut(function() {
                            $(this).remove();
                            
                            // Check if there are any rows left
                            if ($('table tbody tr').length === 0) {
                                $('table').replaceWith('<p><strong><?php _e('All posts have featured images set. Great job!', 'sports-illustrated'); ?></strong></p>');
                                $('#set-all-featured-images').hide();
                            }
                        });
                    } else {
                        button.text('<?php _e('Failed', 'sports-illustrated'); ?>').prop('disabled', false);
                    }
                },
                error: function() {
                    button.text('<?php _e('Error', 'sports-illustrated'); ?>').prop('disabled', false);
                }
            });
        });
        
        // Set featured image for all posts
        $('#set-all-featured-images').click(function(e) {
            e.preventDefault();
            
            // Create and open media frame
            var frame = wp.media({
                title: '<?php _e('Select Featured Image for All Posts', 'sports-illustrated'); ?>',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: '<?php _e('Set as featured image', 'sports-illustrated'); ?>'
                }
            });
            
            // When an image is selected in the media frame
            frame.on('select', function() {
                // Get media attachment details
                var attachment = frame.state().get('selection').first().toJSON();
                
                // Get all post IDs
                var postIds = [];
                $('.set-single-featured-image').each(function() {
                    postIds.push($(this).data('post-id'));
                });
                
                // Show loading message
                $('body').append('<div id="si-bulk-loading" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.7); z-index:99999; display:flex; align-items:center; justify-content:center;"><div style="background:white; padding:20px; border-radius:5px;"><p>Setting featured images for ' + postIds.length + ' posts...</p><div style="height:10px; background:#f0f0f0; margin-top:10px;"><div id="si-bulk-progress" style="height:10px; background:#0073aa; width:0%;"></div></div></div></div>');
                
                // Process posts one by one
                var processed = 0;
                function processNext() {
                    if (processed >= postIds.length) {
                        // All done, reload page
                        location.reload();
                        return;
                    }
                    
                    var postId = postIds[processed];
                    
                    // Update progress
                    var progress = Math.round((processed / postIds.length) * 100);
                    $('#si-bulk-progress').css('width', progress + '%');
                    
                    // Set featured image via AJAX
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'si_set_featured_image',
                            post_id: postId,
                            image_id: attachment.id,
                            nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                        },
                        success: function() {
                            processed++;
                            processNext();
                        },
                        error: function() {
                            processed++;
                            processNext();
                        }
                    });
                }
                
                // Start processing
                processNext();
            });
            
            // Open the media library frame
            frame.open();
        });
    });
    </script>
    <?php
}

/**
 * AJAX handler for auto-setting featured image
 */
function si_auto_set_featured_image_ajax_callback() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'si_auto_set_featured_image_ajax')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Check permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied');
    }
    
    // Get post ID
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if ($post_id) {
        // Auto-set featured image
        $result = si_auto_set_featured_image($post_id);
        
        if ($result) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Could not set featured image');
        }
    } else {
        wp_send_json_error('Invalid post ID');
    }
}
add_action('wp_ajax_si_auto_set_featured_image_ajax', 'si_auto_set_featured_image_ajax_callback');

/**
 * Add a notice to the post editor about featured images
 */
function si_featured_image_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on post add/edit screens
    if ($screen->base !== 'post' || $screen->post_type !== 'post') {
        return;
    }
    
    // Check if the post has a featured image
    $post_id = get_the_ID();
    if ($post_id && has_post_thumbnail($post_id)) {
        return;
    }
    
    // Show notice
    ?>
    <div class="notice notice-warning">
        <p>
            <strong><?php _e('Featured Image Required', 'sports-illustrated'); ?></strong>
            <br>
            <?php _e('Please set a featured image for this post. Featured images are displayed on the News page and improve the visual appeal of your content.', 'sports-illustrated'); ?>
            <br>
            <?php _e('Recommended size: 800×450 pixels (16:9 ratio)', 'sports-illustrated'); ?>
        </p>
        <p>
            <a href="#postimagediv" class="button button-primary"><?php _e('Set Featured Image Now', 'sports-illustrated'); ?></a>
        </p>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Highlight the featured image metabox
        $('#postimagediv').css('border', '2px solid #dc3232').css('box-shadow', '0 0 5px rgba(220, 50, 50, 0.3)');
        
        // Scroll to featured image metabox when clicking the button
        $('a[href="#postimagediv"]').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('#postimagediv').offset().top - 50
            }, 500);
            
            // Flash the metabox to draw attention
            $('#postimagediv').css('background-color', '#f7fcfe');
            setTimeout(function() {
                $('#postimagediv').css('background-color', '');
            }, 750);
        });
        
        // Remove highlight when featured image is set
        // This works for the media modal "Set featured image" button
        $(document).on('click', '.set-post-thumbnail', function() {
            $('#postimagediv').css('border', '').css('box-shadow', '');
        });
        
        // Also check when the featured image is updated via AJAX
        $(document).ajaxComplete(function(event, xhr, settings) {
            if (settings.data && settings.data.indexOf('action=set-post-thumbnail') !== -1) {
                $('#postimagediv').css('border', '').css('box-shadow', '');
                $('.notice.notice-warning').fadeOut();
            }
        });
    });
    </script>
    <?php
}
add_action('admin_notices', 'si_featured_image_admin_notice');

/**
 * Enhance the featured image metabox with clearer instructions
 */
function si_enhance_featured_image_metabox() {
    global $post;
    
    // Only run on post edit screens
    $screen = get_current_screen();
    if ($screen->base !== 'post' || $screen->post_type !== 'post') {
        return;
    }
    
    // Add custom styling and script to make the featured image more prominent
    ?>
    <style>
    #postimagediv h2.hndle {
        background-color: #f0f6fc;
        border-left: 4px solid #2271b1;
        padding-left: 12px !important;
    }
    
    #postimagediv.no-featured-image h2.hndle {
        background-color: #fcf0f0;
        border-left: 4px solid #d63638;
    }
    
    #postimagediv .inside {
        padding: 15px !important;
    }
    
    .si-featured-image-instructions {
        margin-bottom: 15px;
        padding: 10px;
        background: #f8f8f8;
        border-left: 4px solid #646970;
    }
    
    .si-featured-image-instructions p {
        margin: 0 0 8px;
    }
    
    .si-featured-image-instructions p:last-child {
        margin-bottom: 0;
    }
    
    .si-featured-image-instructions strong {
        color: #d63638;
    }
    
    #set-post-thumbnail-desc {
        display: none;
    }
    
    .si-set-featured-image-btn {
        display: inline-block;
        background: #2271b1;
        border: none;
        color: white;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .si-set-featured-image-btn:hover {
        background: #135e96;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Check if there's a featured image
        var hasFeaturedImage = $('#_thumbnail_id').val() > 0;
        
        // Add class to metabox based on featured image status
        if (!hasFeaturedImage) {
            $('#postimagediv').addClass('no-featured-image');
        }
        
        // Add custom instructions
        var instructions = $('<div class="si-featured-image-instructions"></div>');
        instructions.html(
            '<p><strong>Required for News Page:</strong> Featured images are displayed on the News page and improve the visual appeal of your content.</p>' +
            '<p><strong>Recommended size:</strong> 800×450 pixels (16:9 ratio)</p>'
        );
        
        // Add custom button with direct media library access
        var customButton = $('<button type="button" class="si-set-featured-image-btn">Set Featured Image</button>');
        
        // Insert elements
        $('#postimagediv .inside').prepend(instructions);
        
        // If no featured image, add the custom button
        if (!hasFeaturedImage) {
            $('#postimagediv .inside').append(customButton);
        }
        
        // Handle custom button click
        customButton.on('click', function(e) {
            e.preventDefault();
            
            // Create and open media frame
            var mediaFrame = wp.media({
                title: 'Select Featured Image',
                button: {
                    text: 'Set as featured image'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });
            
            // When image selected
            mediaFrame.on('select', function() {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                
                // Set the thumbnail ID
                $('#_thumbnail_id').val(attachment.id);
                
                // Update the preview
                $('.inside', '#postimagediv').html(
                    '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail">' +
                    'Remove featured image</a></p>' +
                    '<img src="' + attachment.url + '" style="max-width:100%;height:auto;" />'
                );
                
                // Remove the no-featured-image class
                $('#postimagediv').removeClass('no-featured-image');
                
                // Remove the warning notice
                $('.notice.notice-warning').fadeOut();
                
                // Save the post to update the featured image
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'si_set_featured_image',
                        post_id: $('#post_ID').val(),
                        image_id: attachment.id,
                        nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                    },
                    success: function(response) {
                        // Reload the featured image metabox
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'si_refresh_featured_image_metabox',
                                post_id: $('#post_ID').val(),
                                nonce: '<?php echo wp_create_nonce('si_refresh_featured_image_metabox'); ?>'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#postimagediv .inside').html(response.data);
                                    // Re-add our instructions
                                    $('#postimagediv .inside').prepend(instructions);
                                }
                            }
                        });
                    }
                });
            });
            
            // Open the media library
            mediaFrame.open();
        });
        
        // Override the default "Set featured image" link
        $(document).on('click', '.set-post-thumbnail', function(e) {
            e.preventDefault();
            customButton.click();
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'si_enhance_featured_image_metabox');

/**
 * AJAX handler to refresh the featured image metabox
 */
function si_refresh_featured_image_metabox_callback() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'si_refresh_featured_image_metabox')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Check permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied');
    }
    
    // Get post ID
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if ($post_id) {
        // Get the post
        $post = get_post($post_id);
        
        // Buffer the output
        ob_start();
        
        // Output the featured image HTML
        if (has_post_thumbnail($post_id)) {
            $thumbnail_id = get_post_thumbnail_id($post_id);
            $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'medium');
            ?>
            <p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail"><?php _e('Remove featured image', 'sports-illustrated'); ?></a></p>
            <img src="<?php echo esc_url($thumbnail[0]); ?>" style="max-width:100%;height:auto;" />
            <?php
        } else {
            ?>
            <p class="hide-if-no-js">
                <a href="#" id="set-post-thumbnail" class="thickbox"><?php _e('Set featured image', 'sports-illustrated'); ?></a>
            </p>
            <button type="button" class="si-set-featured-image-btn"><?php _e('Set Featured Image', 'sports-illustrated'); ?></button>
            <?php
        }
        
        $html = ob_get_clean();
        wp_send_json_success($html);
    } else {
        wp_send_json_error('Invalid post ID');
    }
}
add_action('wp_ajax_si_refresh_featured_image_metabox', 'si_refresh_featured_image_metabox_callback');

/**
 * Enhance the thumbnail column in the posts list
 */
function si_enhance_thumbnail_column() {
    // Only run on the post list page
    $screen = get_current_screen();
    if ($screen->base !== 'edit' || $screen->post_type !== 'post') {
        return;
    }
    ?>
    <style>
    .column-thumbnail {
        width: 120px !important;
        text-align: center !important;
    }
    
    .column-thumbnail img {
        max-width: 100px;
        height: auto;
        border: 1px solid #ddd;
        padding: 2px;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .column-thumbnail .no-thumbnail {
        display: block;
        width: 100px;
        height: 56px;
        margin: 0 auto;
        background: #f0f0f0;
        border: 1px dashed #ccc;
        position: relative;
    }
    
    .column-thumbnail .no-thumbnail::before {
        content: "No Image";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        color: #888;
    }
    
    .column-thumbnail .set-thumbnail-btn {
        display: inline-block;
        background: #2271b1;
        color: white;
        border: none;
        padding: 4px 8px;
        font-size: 12px;
        margin-top: 5px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .column-thumbnail .set-thumbnail-btn:hover {
        background: #135e96;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Add Set Image buttons to posts without thumbnails
        $('.column-thumbnail').each(function() {
            var cell = $(this);
            if (cell.find('img').length === 0) {
                var postId = cell.closest('tr').attr('id').replace('post-', '');
                
                // Add button
                cell.append('<button type="button" class="set-thumbnail-btn" data-post-id="' + postId + '">Set Image</button>');
            }
        });
        
        // Handle Set Image button click
        $(document).on('click', '.set-thumbnail-btn', function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var button = $(this);
            var cell = button.closest('td');
            
            // Create and open media frame
            var mediaFrame = wp.media({
                title: 'Select Featured Image',
                button: {
                    text: 'Set as featured image'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });
            
            // When image selected
            mediaFrame.on('select', function() {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                
                // Show loading state
                button.text('Saving...').prop('disabled', true);
                
                // Save the featured image
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'si_set_featured_image',
                        post_id: postId,
                        image_id: attachment.id,
                        nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                    },
                    success: function(response) {
                        // Update the cell with the new image
                        var img = $('<img>').attr('src', attachment.url).attr('alt', 'Featured Image');
                        cell.html(img);
                    },
                    error: function() {
                        button.text('Error').prop('disabled', false);
                    }
                });
            });
            
            // Open the media library
            mediaFrame.open();
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'si_enhance_thumbnail_column');

/**
 * Modify the display of the thumbnail column
 */

/**
 * Auto-set featured image from post content or default
 * 
 * This function checks if a post has a featured image. If not, it:
 * 1. Tries to use the first image from the post content
 * 2. Falls back to the default image from the customizer
 */
function si_auto_set_featured_image($post_id) {
    // Only proceed if the post doesn't already have a featured image
    if (!has_post_thumbnail($post_id)) {
        $post = get_post($post_id);
        
        // Try to find the first image in the post content
        $first_img = '';
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        
        if ($output && isset($matches[1][0])) {
            $first_img = $matches[1][0];
            
            // Get image ID from URL
            $image_id = si_get_attachment_id_from_url($first_img);
            
            if ($image_id) {
                // Set as featured image
                set_post_thumbnail($post_id, $image_id);
                return true;
            } else {
                // If we can't get the image ID, try to sideload the image
                $image_id = si_sideload_image_as_featured($first_img, $post_id);
                if ($image_id) {
                    return true;
                }
            }
        }
        
        // If no image in content or couldn't set it, use default image
        $default_image_id = get_option('si_default_featured_image', 0);
        if ($default_image_id) {
            set_post_thumbnail($post_id, $default_image_id);
            return true;
        }
    }
    
    return false;
}

/**
 * Get attachment ID from image URL
 */
function si_get_attachment_id_from_url($image_url) {
    global $wpdb;
    
    // Remove any image size from URL (e.g., -300x200.jpg)
    $image_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url);
    
    // Try to find the attachment ID
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
    
    // If not found by guid, try by comparing to attachment URLs
    if (empty($attachment)) {
        $uploads = wp_upload_dir();
        $uploads_baseurl = $uploads['baseurl'];
        
        // If the image is in the uploads directory
        if (strpos($image_url, $uploads_baseurl) !== false) {
            $path = str_replace($uploads_baseurl, '', $image_url);
            $attachment = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_wp_attached_file' AND meta_value='%s';", ltrim($path, '/')));
        }
    }
    
    return !empty($attachment[0]) ? $attachment[0] : 0;
}

/**
 * Sideload an external image and set as featured image
 */
function si_sideload_image_as_featured($image_url, $post_id) {
    if (empty($image_url)) {
        return 0;
    }
    
    // Require these files for media handling
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    
    // Download the image
    $tmp = download_url($image_url);
    
    if (is_wp_error($tmp)) {
        return 0;
    }
    
    // Get the filename and extension
    $filename = basename($image_url);
    $info = pathinfo($filename);
    $ext = isset($info['extension']) ? $info['extension'] : '';
    
    // Build the file array
    $file_array = array(
        'name' => $filename,
        'tmp_name' => $tmp
    );
    
    // Check file type
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array(strtolower($ext), $allowed_types)) {
        @unlink($tmp);
        return 0;
    }
    
    // Upload the image
    $attachment_id = media_handle_sideload($file_array, $post_id);
    
    // If error, clean up and return
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        return 0;
    }
    
    // Set as featured image
    set_post_thumbnail($post_id, $attachment_id);
    
    return $attachment_id;
}

/**
 * Auto-set featured images when saving posts
 */
function si_auto_set_featured_image_on_save($post_id, $post, $update) {
    // Skip auto-draft, revision, and autosave
    if ($post->post_status == 'auto-draft' || wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }
    
    // Only run on posts
    if ($post->post_type != 'post') {
        return;
    }
    
    // Auto-set featured image
    si_auto_set_featured_image($post_id);
}
add_action('save_post', 'si_auto_set_featured_image_on_save', 10, 3);

/**
 * Auto-set featured images for existing posts without featured images
 * 
 * @return int Number of posts that had featured images set
 */
function si_bulk_auto_set_featured_images() {
    // Get posts without featured images
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    
    $posts_without_featured_image = get_posts($args);
    $count = 0;
    
    foreach ($posts_without_featured_image as $post) {
        $result = si_auto_set_featured_image($post->ID);
        if ($result) {
            $count++;
        }
    }
    
    return $count;
}

/**
 * Add a button to bulk auto-set featured images
 */
function si_add_auto_set_featured_images_button() {
    $screen = get_current_screen();
    if ($screen->id !== 'posts_page_manage-featured-images') {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Auto-Set Featured Images', 'sports-illustrated'); ?></h1>
        <p><?php _e('Click the button below to automatically set featured images for all posts that don\'t have one. The system will try to use the first image from each post\'s content, or fall back to the default image.', 'sports-illustrated'); ?></p>
        <form method="post" action="">
            <?php wp_nonce_field('si_auto_set_featured_images', 'si_auto_set_featured_images_nonce'); ?>
            <p>
                <input type="submit" name="si_auto_set_featured_images" class="button button-primary" value="<?php _e('Auto-Set Featured Images', 'sports-illustrated'); ?>">
            </p>
        </form>
    </div>
    <?php
}
add_action('admin_footer', 'si_add_auto_set_featured_images_button');

/**
 * Process the auto-set featured images request
 */
function si_process_auto_set_featured_images() {
    if (isset($_POST['si_auto_set_featured_images']) && isset($_POST['si_auto_set_featured_images_nonce']) && wp_verify_nonce($_POST['si_auto_set_featured_images_nonce'], 'si_auto_set_featured_images')) {
        si_bulk_auto_set_featured_images();
        
        // Redirect back to the page with a success message
        wp_redirect(add_query_arg('auto-set', 'success', admin_url('edit.php?page=manage-featured-images')));
        exit;
    }
}
add_action('admin_init', 'si_process_auto_set_featured_images');

/**
 * Display success message after auto-setting featured images
 */
function si_auto_set_featured_images_success_message() {
    if (isset($_GET['auto-set']) && $_GET['auto-set'] === 'success') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Featured images have been automatically set for all posts without featured images.', 'sports-illustrated'); ?></p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'si_auto_set_featured_images_success_message');

/**
 * Fix the featured image metabox to ensure it works properly
 */
function si_fix_featured_image_metabox() {
    global $post;
    
    // Only run on post edit screens
    $screen = get_current_screen();
    if ($screen->base !== 'post' || $screen->post_type !== 'post') {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Fix the Set Featured Image functionality
        $(document).on('click', '#set-post-thumbnail, .si-set-featured-image-btn, .set-thumbnail-btn', function(e) {
            e.preventDefault();
            
            var postId = $('#post_ID').val();
            
            // Create and open media frame
            var frame = wp.media({
                title: '<?php _e('Select Featured Image', 'sports-illustrated'); ?>',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: '<?php _e('Set as featured image', 'sports-illustrated'); ?>'
                }
            });
            
            // When an image is selected in the media frame
            frame.on('select', function() {
                // Get media attachment details
                var attachment = frame.state().get('selection').first().toJSON();
                
                // Set the featured image ID
                $('#_thumbnail_id').val(attachment.id);
                
                // Update the featured image display
                $('.inside', '#postimagediv').html(
                    '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail">' +
                    '<?php _e('Remove featured image', 'sports-illustrated'); ?></a></p>' +
                    '<img src="' + attachment.url + '" style="max-width:100%;height:auto;" />'
                );
                
                // Remove warning notice and highlighting
                $('.notice.notice-warning').fadeOut();
                $('#postimagediv').removeClass('no-featured-image').css('border', '').css('box-shadow', '');
                
                // Save the featured image via AJAX
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'si_set_featured_image',
                        post_id: postId,
                        image_id: attachment.id,
                        nonce: '<?php echo wp_create_nonce('si_set_featured_image'); ?>'
                    }
                });
            });
            
            // Open the media library frame
            frame.open();
            
            return false;
        });
        
        // Handle remove featured image
        $(document).on('click', '#remove-post-thumbnail', function(e) {
            e.preventDefault();
            
            var postId = $('#post_ID').val();
            
            // Update the featured image display
            $('.inside', '#postimagediv').html(
                '<p class="hide-if-no-js"><a href="#" id="set-post-thumbnail">' +
                '<?php _e('Set featured image', 'sports-illustrated'); ?></a></p>'
            );
            
            // Clear the featured image ID
            $('#_thumbnail_id').val('-1');
            
            // Add warning notice and highlighting
            $('#postimagediv').addClass('no-featured-image');
            
            // Remove the featured image via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'si_remove_featured_image',
                    post_id: postId,
                    nonce: '<?php echo wp_create_nonce('si_remove_featured_image'); ?>'
                }
            });
            
            return false;
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'si_fix_featured_image_metabox');

/**
 * AJAX handler to remove featured image
 */
function si_remove_featured_image_callback() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'si_remove_featured_image')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Check permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied');
    }
    
    // Get post ID
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if ($post_id) {
        // Remove featured image
        delete_post_thumbnail($post_id);
        wp_send_json_success();
    } else {
        wp_send_json_error('Invalid post ID');
    }
}
add_action('wp_ajax_si_remove_featured_image', 'si_remove_featured_image_callback');

/**
 * Add custom rewrite rules for menu URLs
 */
function si_add_menu_rewrite_rules() {
    // Add a rewrite rule for the menu page with query parameters
    add_rewrite_rule(
        '^menu/?$',
        'index.php?pagename=menu',
        'top'
    );
    
    // Ensure menu query parameter is passed through
    global $wp;
    $wp->add_query_var('menu');
}
add_action('init', 'si_add_menu_rewrite_rules');

/**
 * Fix menu URLs to prevent redirection
 */
function si_fix_menu_urls($redirect_url, $requested_url) {
    // If the URL contains /menu/ and a menu parameter, don't redirect
    if (strpos($requested_url, '/menu/') !== false && strpos($requested_url, 'menu=') !== false) {
        return false; // Prevent redirection
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'si_fix_menu_urls', 10, 2);

/**
 * Add monthly events customizer settings
 */
function si_monthly_events_customizer($wp_customize) {
    // Add Monthly Events Section
    $wp_customize->add_section('si_monthly_events_section', array(
        'title'    => __('Monthly Events Settings', 'sports-illustrated'),
        'description' => __('Configure content for the monthly events section on the homepage.', 'sports-illustrated'),
        'priority' => 35,
    ));

    // Monthly Events Title
    $wp_customize->add_setting('si_monthly_events_title', array(
        'default'           => __('SI CLUBHOUSE MONTHLY EVENTS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_monthly_events_title', array(
        'label'    => __('Section Title', 'sports-illustrated'),
        'section'  => 'si_monthly_events_section',
        'type'     => 'text',
    ));

    // Add settings for up to 8 events
    for ($i = 1; $i <= 8; $i++) {
        // Event Image
        $wp_customize->add_setting("si_event_image_$i", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "si_event_image_$i", array(
            'label'       => sprintf(__('Event %d Image', 'sports-illustrated'), $i),
            'description' => sprintf(__('Upload an image for event %d.', 'sports-illustrated'), $i),
            'section'     => 'si_monthly_events_section',
            'mime_type'   => 'image',
        )));

        // Event Title
        $wp_customize->add_setting("si_event_title_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("si_event_title_$i", array(
            'label'    => sprintf(__('Event %d Title', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'text',
        ));

        // Event Date
        $wp_customize->add_setting("si_event_date_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("si_event_date_$i", array(
            'label'    => sprintf(__('Event %d Date', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'text',
        ));

        // Event Link
        $wp_customize->add_setting("si_event_link_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("si_event_link_$i", array(
            'label'    => sprintf(__('Event %d Link', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'si_monthly_events_customizer');

/**
 * Add option to toggle between image-based menus and written menus
 */
function si_menu_display_type_customizer($wp_customize) {
    // Add Menu Display Type Section
    $wp_customize->add_section('si_menu_display_section', array(
        'title'    => __('Menu Display Settings', 'sports-illustrated'),
        'description' => __('Configure how menus are displayed on the website.', 'sports-illustrated'),
        'priority' => 30,
    ));
    
    // Menu Display Type
    $wp_customize->add_setting('si_menu_display_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('si_menu_display_type', array(
        'label'    => __('Menu Display Type', 'sports-illustrated'),
        'description' => __('Choose whether to display menus as images or as written text. Written menus are available for Full Menu, Brunch Menu, and Drinks Menu. Other menus will always display as images.', 'sports-illustrated'),
        'section'  => 'si_menu_display_section',
        'type'     => 'radio',
        'choices'  => array(
            'image'  => __('Image-based Menus', 'sports-illustrated'),
            'written' => __('Written Menus', 'sports-illustrated'),
        ),
    ));
    
    // Menu Types for Image-based Menus
    $image_menu_types = array(
        'full'   => 'Full Menu',
        'drink'  => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy'  => 'Happy Hour Menu',
        'monday' => 'Monday Menu',
        'tuesday' => 'Tuesday Menu',
        'wednesday' => 'Wednesday Menu',
        'thursday' => 'Thursday Menu',
        'friday' => 'Friday Menu',
        'saturday' => 'Saturday Menu',
        'sunday' => 'Sunday Menu'
    );

    // Size multiplier options
    $size_options = array(
        '1'   => __('1x (Default Size)', 'sports-illustrated'),
        '1.25' => __('1.25x', 'sports-illustrated'),
        '1.5' => __('1.5x', 'sports-illustrated'),
        '1.75' => __('1.75x', 'sports-illustrated'),
        '2'   => __('2x', 'sports-illustrated'),
        '2.5' => __('2.5x', 'sports-illustrated'),
        '3'   => __('3x', 'sports-illustrated'),
    );

    // Add Image-based Menu Settings
    foreach ($image_menu_types as $menu_id => $menu_name) {
        // Menu Image
        $wp_customize->add_setting('si_menu_' . $menu_id . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_' . $menu_id . '_image', array(
            'label'    => $menu_name . ' Image',
            'description' => sprintf(__('Select an image for the %s.', 'sports-illustrated'), $menu_name),
            'section'  => 'si_menu_display_section',
            'mime_type' => 'image',
            'active_callback' => function() use ($menu_id) {
                // Always show Happy Hour and daily menus regardless of display type
                if (in_array($menu_id, array('happy', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'))) {
                    return true;
                }
                // For other menus, show when image display type is selected
                return get_theme_mod('si_menu_display_type', 'image') === 'image';
            },
        )));

        // Menu PDF
        $wp_customize->add_setting('si_restaurant_menu_' . $menu_id . '_pdf', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_restaurant_menu_' . $menu_id . '_pdf', array(
            'label'    => $menu_name . ' PDF',
            'description' => sprintf(__('Select a PDF file for the %s.', 'sports-illustrated'), $menu_name),
            'section'  => 'si_menu_display_section',
            'mime_type' => 'application/pdf',
            'active_callback' => function() use ($menu_id) {
                // Always show Happy Hour and daily menus regardless of display type
                if (in_array($menu_id, array('happy', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'))) {
                    return true;
                }
                // For other menus, only show when image display type is selected
                return get_theme_mod('si_menu_display_type', 'image') === 'image';
            },
        )));

        // Only add size multipliers for Happy Hour and daily menus
        if (in_array($menu_id, array('happy', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'))) {
            // Desktop Size Multiplier
            $wp_customize->add_setting('si_menu_' . $menu_id . '_size_multiplier', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('si_menu_' . $menu_id . '_size_multiplier', array(
                'label'    => $menu_name . ' Size (Desktop)',
                'description' => sprintf(__('Adjust the size of the %s on desktop devices.', 'sports-illustrated'), $menu_name),
                'section'  => 'si_menu_display_section',
                'type'     => 'select',
                'choices'  => $size_options,
            ));

            // Tablet Size Multiplier
            $wp_customize->add_setting('si_menu_' . $menu_id . '_tablet_size_multiplier', array(
                'default'           => '1.5',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('si_menu_' . $menu_id . '_tablet_size_multiplier', array(
                'label'    => $menu_name . ' Size (Tablet)',
                'description' => sprintf(__('Adjust the size of the %s on tablet devices.', 'sports-illustrated'), $menu_name),
                'section'  => 'si_menu_display_section',
                'type'     => 'select',
                'choices'  => $size_options,
            ));

            // Mobile Size Multiplier
            $wp_customize->add_setting('si_menu_' . $menu_id . '_mobile_size_multiplier', array(
                'default'           => '2',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('si_menu_' . $menu_id . '_mobile_size_multiplier', array(
                'label'    => $menu_name . ' Size (Mobile)',
                'description' => sprintf(__('Adjust the size of the %s on mobile devices.', 'sports-illustrated'), $menu_name),
                'section'  => 'si_menu_display_section',
                'type'     => 'select',
                'choices'  => $size_options,
            ));
        }
    }
    
    // Written Menu Settings
    $written_menu_types = array(
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'drinks' => __('Drinks Menu', 'sports-illustrated'),
        'full'   => __('Full Menu', 'sports-illustrated')
    );

    // Add settings for each written menu type
    foreach ($written_menu_types as $menu_key => $menu_label) {
        // Menu Title
        $wp_customize->add_setting("si_written_menu_{$menu_key}_title", array(
            'default'           => $menu_label,
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("si_written_menu_{$menu_key}_title", array(
            'label'    => sprintf(__('%s Title', 'sports-illustrated'), $menu_label),
            'section'  => 'si_menu_display_section',
            'type'     => 'text',
            'active_callback' => function() {
                return get_theme_mod('si_menu_display_type', 'image') === 'written';
            },
        ));

        // Menu Description
        $wp_customize->add_setting("si_written_menu_{$menu_key}_description", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ));

        $wp_customize->add_control("si_written_menu_{$menu_key}_description", array(
            'label'    => sprintf(__('%s Description', 'sports-illustrated'), $menu_label),
            'section'  => 'si_menu_display_section',
            'type'     => 'textarea',
            'active_callback' => function() {
                return get_theme_mod('si_menu_display_type', 'image') === 'written';
            },
        ));

        // Menu Sections (up to 10 sections per menu)
        for ($i = 1; $i <= 10; $i++) {
            // Section Title
            $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_title", array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_title", array(
                'label'    => sprintf(__('%s Section %d Title', 'sports-illustrated'), $menu_label, $i),
                'section'  => 'si_menu_display_section',
                'type'     => 'text',
                'active_callback' => function() {
                    return get_theme_mod('si_menu_display_type', 'image') === 'written';
                },
            ));

            // Section Description
            $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_description", array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            ));

            $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_description", array(
                'label'    => sprintf(__('%s Section %d Description', 'sports-illustrated'), $menu_label, $i),
                'section'  => 'si_menu_display_section',
                'type'     => 'textarea',
                'active_callback' => function() {
                    return get_theme_mod('si_menu_display_type', 'image') === 'written';
                },
            ));

            // Menu Items (up to 15 items per section)
            for ($j = 1; $j <= 15; $j++) {
                // Item Name
                $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_name", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_name", array(
                    'label'    => sprintf(__('%s Section %d Item %d Name', 'sports-illustrated'), $menu_label, $i, $j),
                    'section'  => 'si_menu_display_section',
                    'type'     => 'text',
                    'active_callback' => function() {
                        return get_theme_mod('si_menu_display_type', 'image') === 'written';
                    },
                ));

                // Item Description
                $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_description", array(
                    'default'           => '',
                    'sanitize_callback' => 'wp_kses_post',
                ));

                $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_description", array(
                    'label'    => sprintf(__('%s Section %d Item %d Description', 'sports-illustrated'), $menu_label, $i, $j),
                    'section'  => 'si_menu_display_section',
                    'type'     => 'textarea',
                    'active_callback' => function() {
                        return get_theme_mod('si_menu_display_type', 'image') === 'written';
                    },
                ));

                // Item Price
                $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_price", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_price", array(
                    'label'    => sprintf(__('%s Section %d Item %d Price', 'sports-illustrated'), $menu_label, $i, $j),
                    'section'  => 'si_menu_display_section',
                    'type'     => 'text',
                    'active_callback' => function() {
                        return get_theme_mod('si_menu_display_type', 'image') === 'written';
                    },
                ));

                // Item Notes (V, GF, etc.)
                $wp_customize->add_setting("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_notes", array(
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control("si_written_menu_{$menu_key}_section_{$i}_item_{$j}_notes", array(
                    'label'    => sprintf(__('%s Section %d Item %d Notes (V, GF, etc.)', 'sports-illustrated'), $menu_label, $i, $j),
                    'section'  => 'si_menu_display_section',
                    'type'     => 'text',
                    'active_callback' => function() {
                        return get_theme_mod('si_menu_display_type', 'image') === 'written';
                    },
                ));
            }
        }
    }

    // Menu Image Size Controls
    $menu_types = array(
        'full' => 'Full Menu',
        'drink' => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy' => 'Happy Hour Menu',
        'today' => 'Today\'s Menu'
    );

    foreach ($menu_types as $type => $label) {
        // Image Size Control
        $wp_customize->add_setting("si_menu_{$type}_image_size", array(
            'default'           => 1.0,
            'sanitize_callback' => 'floatval',
        ));

        $wp_customize->add_control("si_menu_{$type}_image_size", array(
            'label'       => sprintf(__('%s Image Size Multiplier', 'sports-illustrated'), $label),
            'description' => __('Adjust the size of the menu image (1.0 = 100%)', 'sports-illustrated'),
            'section'     => 'si_menus',
            'type'        => 'number',
            'input_attrs' => array(
                'min'   => 0.1,
                'max'   => 2.0,
                'step'  => 0.1,
            ),
        ));

        // Image Upload Control
        $wp_customize->add_setting("si_menu_{$type}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "si_menu_{$type}_image", array(
            'label'    => sprintf(__('%s Image', 'sports-illustrated'), $label),
            'section'  => 'si_menus',
            'settings' => "si_menu_{$type}_image",
        )));

        // Custom URL for each menu type
        $wp_customize->add_setting("si_menu_dropdown_url_{$type}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("si_menu_dropdown_url_{$type}", array(
            'label'       => sprintf(__('Custom URL for %s', 'sports-illustrated'), $label),
            'description' => __('Leave blank to use default URL structure', 'sports-illustrated'),
            'section'     => 'si_menus',
            'type'        => 'url',
        ));
    }
}
add_action('customize_register', 'si_menu_display_type_customizer');

/**
 * Get the menu page template based on the display type setting
/**
 * Menu Template Functions
 * Note: These functions have been moved to inc/menu-templates.php
 */

/**
 * Set default values for the written menus
 * Note: This function has been moved to inc/menu-defaults.php
 */

/**
 * Menu Reset Functions
 * Note: These functions have been moved to inc/menu-reset-functions.php
 */

/**
 * Include the Menu Manager class
 */

/**
 * Fix pagination for custom queries
 */
function si_fix_custom_pagination($query) {
    if (!is_admin() && $query->is_main_query()) {
        // If this is the news page
        if (is_page_template('page-posts.php')) {
            // Set posts per page from customizer setting
            $posts_per_page = get_theme_mod('si_news_posts_per_page', 9);
            $query->set('posts_per_page', $posts_per_page);
            $query->set('post_type', 'post');
            $query->set('post_status', 'publish');
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'si_fix_custom_pagination');

/**
 * Add rewrite rules for pagination
 */
function si_add_pagination_rewrite_rules() {
    add_rewrite_rule(
        'news/page/([0-9]+)/?$',
        'index.php?pagename=news&paged=$matches[1]',
        'top'
    );
}
add_action('init', 'si_add_pagination_rewrite_rules');

/**
 * Fix pagination for news page
 */
function si_fix_news_page_query($query) {
    // Only modify the main query on the frontend
    if (!is_admin() && $query->is_main_query()) {
        // Check if we're on the news page template
        if (is_page_template('page-posts.php')) {
            // Set query parameters for news page
            $posts_per_page = get_theme_mod('si_news_posts_per_page', 9);
            $query->set('post_type', 'post');
            $query->set('posts_per_page', $posts_per_page);
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
            $query->set('ignore_sticky_posts', 1);
            
            // Important: Set proper query flags
            $query->is_page = false;
            $query->is_archive = true;
            $query->is_post_type_archive = true;
        }
    }
    return $query;
}
add_action('pre_get_posts', 'si_fix_news_page_query');

/**
 * Fix pagination base for news page
 */
function si_fix_news_pagination_base($link) {
    if (is_page_template('page-posts.php')) {
        $news_page_id = get_page_by_path('news')->ID;
        $news_page_link = get_permalink($news_page_id);
        $link = str_replace(home_url('/'), $news_page_link, $link);
    }
    return $link;
}
add_filter('paginate_links', 'si_fix_news_pagination_base');

/**
 * Add rewrite rules for news page pagination
 */
function si_add_news_rewrite_rules() {
    $news_page = get_page_by_path('news');
    if ($news_page) {
        add_rewrite_rule(
            'news/page/([0-9]+)/?$',
            'index.php?page_id=' . $news_page->ID . '&paged=$matches[1]',
            'top'
        );
    }
}
add_action('init', 'si_add_news_rewrite_rules');

/**
 * Flush rewrite rules when the news page is saved
 */
function si_flush_rules_on_news_save($post_id) {
    if (get_page_template_slug($post_id) === 'page-news.php') {
        flush_rewrite_rules();
    }
}
add_action('save_post_page', 'si_flush_rules_on_news_save');

/**
 * Basic theme setup
 */
function si_setup() {
    load_theme_textdomain('sports-illustrated', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo');
    
    // Flush rewrite rules on theme activation
    flush_rewrite_rules();
}
add_action('after_setup_theme', 'si_setup');

// Also flush rewrite rules when saving the customizer settings
function si_customize_save_after() {
    flush_rewrite_rules();
}
add_action('customize_save_after', 'si_customize_save_after');

/**
 * Enqueue scripts and styles
 */