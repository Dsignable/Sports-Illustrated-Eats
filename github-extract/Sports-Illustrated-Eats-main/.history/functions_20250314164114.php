<?php
// Enable WordPress debug mode safely
@ini_set('display_errors', 0);
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}

/**
 * Sports Illustrated functions and definitions
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('SI_THEME_DIR', get_template_directory());
define('SI_THEME_URI', get_template_directory_uri());

// Include required files
require_once SI_THEME_DIR . '/inc/theme-setup.php';
require_once SI_THEME_DIR . '/inc/enqueue-scripts.php';
require_once SI_THEME_DIR . '/inc/theme-functions.php';
require_once SI_THEME_DIR . '/inc/menu-utilities.php';
require_once SI_THEME_DIR . '/inc/class-si-menu-manager.php';
require_once SI_THEME_DIR . '/inc/menu-manager-integration.php'; 