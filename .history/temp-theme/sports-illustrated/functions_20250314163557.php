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
    return false;
}

// Include required core files
$required_files = array(
    '/inc/theme-setup.php',
    '/inc/enqueue-scripts.php',
    '/inc/theme-functions.php',
    '/inc/menu-utilities.php',
    '/inc/class-si-menu-manager.php',
    '/inc/menu-manager-integration.php',
    '/inc/customizer/customizer.php'
);

foreach ($required_files as $file) {
    si_safe_require_once(SI_THEME_DIR . $file);
}

// Optional development files - only include if they exist
$dev_files = array(
    '/reset-drinks-menu.php',
    '/menu-diagnostics.php'
);

if (defined('WP_DEBUG') && WP_DEBUG === true) {
    foreach ($dev_files as $file) {
        si_safe_require_once(SI_THEME_DIR . $file);
    }
}

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