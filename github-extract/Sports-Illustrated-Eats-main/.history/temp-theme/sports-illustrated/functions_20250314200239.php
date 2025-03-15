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

// Define theme constants
define('SI_THEME_DIR', get_template_directory());
define('SI_THEME_URI', get_template_directory_uri());

// Safe file include function
function si_safe_require_once($file) {
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    error_log('Failed to load file: ' . $file);
    return false;
}

// Core files that must exist for the theme to function
$core_files = array(
    '/inc/theme-setup.php',
    '/inc/enqueue-scripts.php',
    '/inc/theme-functions.php',
    '/inc/widgets.php',
    '/inc/menu-utilities.php',
    '/inc/menu-templates.php',
    '/inc/class-si-menu-manager.php',
    '/inc/menu-manager-integration.php',
    '/inc/customizer/customizer.php',
    '/inc/customizer/home-page.php',
    '/inc/customizer/written-menu.php',
    '/inc/drinks_menu_defaults.php',
    '/inc/menu-defaults.php',
    '/inc/menu-reset-functions.php',
    '/inc/admin/menu-manager.php'
);

// Try to include core files
foreach ($core_files as $file) {
    if (!si_safe_require_once(SI_THEME_DIR . $file)) {
        // Log error for missing core file
        error_log('Sports Illustrated Theme Error: Missing core file ' . $file);
    }
}

/**
 * Register widget area
 */
function sports_illustrated_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'sports-illustrated'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'sports-illustrated'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'sports_illustrated_widgets_init');

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
 * Allow PDF uploads
 */
function si_allow_pdf_uploads($mime_types) {
    $mime_types['pdf'] = 'application/pdf';
    return $mime_types;
}
add_filter('upload_mimes', 'si_allow_pdf_uploads');

/**
 * Fix pagination for custom queries
 */
function si_fix_custom_pagination($query) {
    if (!is_admin() && $query->is_main_query()) {
        // If this is the news page
        if (is_page_template('page-news.php')) {
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
}
add_action('after_setup_theme', 'si_setup');

/**
 * Enqueue scripts and styles
 */
function si_scripts() {
    wp_enqueue_style('sports-illustrated-style', get_stylesheet_uri(), array(), SI_VERSION);
    wp_enqueue_style('sports-illustrated-main', get_template_directory_uri() . '/assets/css/main.css', array(), SI_VERSION);
    wp_enqueue_style('sports-illustrated-responsive', get_template_directory_uri() . '/assets/css/responsive-fixes.css', array(), SI_VERSION);
    wp_enqueue_style('sports-illustrated-buttons', get_template_directory_uri() . '/assets/css/buttons.css', array(), SI_VERSION);

    wp_enqueue_script('sports-illustrated-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), SI_VERSION, true);
    wp_enqueue_script('sports-illustrated-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), SI_VERSION, true);
    wp_enqueue_script('sports-illustrated-animations', get_template_directory_uri() . '/assets/js/animations.js', array('jquery'), SI_VERSION, true);
}
add_action('wp_enqueue_scripts', 'si_scripts');