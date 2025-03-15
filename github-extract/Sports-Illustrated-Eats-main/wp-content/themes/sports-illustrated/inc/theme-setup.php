<?php
/**
 * Theme Setup Functions
 *
 * This file includes all theme setup functions.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sports_illustrated_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'sports-illustrated'),
        'footer'  => __('Footer Menu', 'sports-illustrated'),
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo.
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Add support for responsive embeds.
    add_theme_support('responsive-embeds');

    // Add support for full and wide align images.
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'sports_illustrated_setup'); 