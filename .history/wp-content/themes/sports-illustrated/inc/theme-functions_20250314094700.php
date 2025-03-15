<?php
/**
 * Theme Functions
 *
 * This file includes all modular theme function files.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include theme setup functions
require_once get_template_directory() . '/inc/theme-setup.php';

// Include script and style enqueuing
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// Include widget functions
require_once get_template_directory() . '/inc/widgets.php';

// Include menu defaults
require_once get_template_directory() . '/inc/menu-defaults.php';

// Include menu manager integration
require_once get_template_directory() . '/inc/menu-manager-integration.php';

// Include customizer functions
require_once get_template_directory() . '/inc/customizer/customizer.php';

// Include any other function files here
// require_once get_template_directory() . '/inc/template-functions.php';
// require_once get_template_directory() . '/inc/template-tags.php'; 