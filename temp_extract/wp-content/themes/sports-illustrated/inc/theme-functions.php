<?php
/**
 * Theme functions for Sports Illustrated
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Helper function to get theme options with defaults
 *
 * @param string $option_name The option name
 * @param mixed $default The default value if option doesn't exist
 * @return mixed The option value or default
 */
function si_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Helper function to check if a file exists in the theme
 *
 * @param string $file_path Relative path to the file in the theme
 * @return bool Whether the file exists
 */
function si_file_exists($file_path) {
    return file_exists(get_template_directory() . '/' . $file_path);
}

/**
 * Helper function to get the URL of a file in the theme
 *
 * @param string $file_path Relative path to the file in the theme
 * @return string The URL of the file
 */
function si_get_file_url($file_path) {
    return get_template_directory_uri() . '/' . $file_path;
}

/**
 * Helper function to include a template part
 *
 * @param string $template_name The name of the template
 * @param array $args Arguments to pass to the template
 */
function si_get_template_part($template_name, $args = array()) {
    if (!empty($args) && is_array($args)) {
        extract($args);
    }
    
    $template_path = get_template_directory() . '/template-parts/' . $template_name . '.php';
    
    if (file_exists($template_path)) {
        include $template_path;
    }
}

// Note: si_get_background_style function has been removed to avoid duplication
// This function is already defined in functions.php 