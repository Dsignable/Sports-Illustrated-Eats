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
    // Register footer widget area
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'sports-illustrated'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'sports-illustrated'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    // Add any other widget areas here
}
add_action('widgets_init', 'sports_illustrated_widgets_init'); 