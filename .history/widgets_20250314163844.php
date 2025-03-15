<?php
/**
 * Widget Functions
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

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