<?php
/**
 * Menu Template Functions
 *
 * Functions related to menu templates and display.
 *
 * @package Sports_Illustrated
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Get the menu template file name
 *
 * @return string The template file name
 */
function si_get_menu_template() {
    // We're now using a single template (page-menu.php) for both display types
    // The template itself handles the conditional display based on the menu_display_type setting
    return 'page-menu.php';
}

/**
 * Filter the template for the menu page
 *
 * @param string $template The current template path
 * @return string The filtered template path
 */
function si_filter_menu_template($template) {
    // Only apply to the menu page template
    if (is_page_template('page-menu.php')) {
        // We're now using a single template (page-menu.php) for both display types
        // The template itself handles the conditional display based on the menu_display_type setting
        return $template;
    }
    
    return $template;
}
add_filter('template_include', 'si_filter_menu_template', 99); 