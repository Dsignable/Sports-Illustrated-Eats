<?php
/**
 * Widget Functions
 *
 * This file includes all widget-related functions.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register widget areas
 */
function sports_illustrated_widgets_init() {
    // Register sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', 'sports-illustrated'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'sports-illustrated'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    // Add any other widget areas here
}
add_action('widgets_init', 'sports_illustrated_widgets_init'); 