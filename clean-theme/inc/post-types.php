<?php
/**
 * Custom Post Types Registration
 *
 * @package Sports_Illustrated
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom post types
 */
function si_register_post_types() {
    // Register Job Listings Post Type
    $labels = array(
        'name'                  => _x('Job Listings', 'Post type general name', 'sports-illustrated'),
        'singular_name'         => _x('Job Listing', 'Post type singular name', 'sports-illustrated'),
        'menu_name'             => _x('Job Listings', 'Admin Menu text', 'sports-illustrated'),
        'name_admin_bar'        => _x('Job Listing', 'Add New on Toolbar', 'sports-illustrated'),
        'add_new'              => __('Add New', 'sports-illustrated'),
        'add_new_item'         => __('Add New Job Listing', 'sports-illustrated'),
        'new_item'             => __('New Job Listing', 'sports-illustrated'),
        'edit_item'            => __('Edit Job Listing', 'sports-illustrated'),
        'view_item'            => __('View Job Listing', 'sports-illustrated'),
        'all_items'            => __('All Job Listings', 'sports-illustrated'),
        'search_items'         => __('Search Job Listings', 'sports-illustrated'),
        'not_found'            => __('No job listings found.', 'sports-illustrated'),
        'not_found_in_trash'   => __('No job listings found in Trash.', 'sports-illustrated'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'jobs'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => array('title', 'editor', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('job_listing', $args);

    // Register Job Categories Taxonomy
    $tax_labels = array(
        'name'              => _x('Job Categories', 'taxonomy general name', 'sports-illustrated'),
        'singular_name'     => _x('Job Category', 'taxonomy singular name', 'sports-illustrated'),
        'search_items'      => __('Search Job Categories', 'sports-illustrated'),
        'all_items'         => __('All Job Categories', 'sports-illustrated'),
        'parent_item'       => __('Parent Job Category', 'sports-illustrated'),
        'parent_item_colon' => __('Parent Job Category:', 'sports-illustrated'),
        'edit_item'         => __('Edit Job Category', 'sports-illustrated'),
        'update_item'       => __('Update Job Category', 'sports-illustrated'),
        'add_new_item'      => __('Add New Job Category', 'sports-illustrated'),
        'new_item_name'     => __('New Job Category Name', 'sports-illustrated'),
        'menu_name'         => __('Categories', 'sports-illustrated'),
    );

    register_taxonomy('job_category', 'job_listing', array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'job-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'si_register_post_types'); 