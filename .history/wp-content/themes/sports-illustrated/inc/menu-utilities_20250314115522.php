<?php
/**
 * Menu Utility Functions
 *
 * Helper functions for menu cards, links, and URLs.
 *
 * @package Sports_Illustrated
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Helper function to get menu card image
 *
 * @param string $card_id The card ID
 * @param string $default Default image URL if no image is found
 * @return string The image URL
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
 *
 * @param string $card_id The card ID
 * @return string The link URL
 */
function si_get_menu_card_link($card_id) {
    $link = get_theme_mod('si_menu_card_' . $card_id . '_link', '#');
    
    if (empty($link)) {
        return '#';
    }
    
    return $link;
}

/**
 * Helper function to get the menu page URL
 *
 * @return string The menu page URL
 */
function si_get_menu_url() {
    $menu_page = get_page_by_path('menu');
    if ($menu_page) {
        return get_permalink($menu_page);
    }
    return home_url('/');
} 