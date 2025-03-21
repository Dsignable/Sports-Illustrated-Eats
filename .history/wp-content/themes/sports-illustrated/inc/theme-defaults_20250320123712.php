<?php
/**
 * Theme Default Content
 */

// Experience Section Defaults
define('SI_DEFAULT_ABOUT_US', 'At Sports Illustrated Clubhouse, we\'re where passionate fans become family. We\'ve created the ultimate gameday destination where every seat feels like the best in the house. Our dishes will have you cheering between bites, while our craft drinks are worthy of any celebration. When our big screens light up, you\'ll find yourself surrounded by fellow fans who understand that the best moments are shared. We\'re not just about watching the game—we\'re about experiencing it together. Grab your crew and join us. The game\'s about to start, and your table is waiting.');

// Sports Highlights Section Defaults
define('SI_DEFAULT_VIP_TEXT', 'We are dedicated to transforming ordinary fans into VIPs with stadium-level excitement and exceptional hospitality. From the moment you step through our doors until your final high-five goodbye, our team delivers championship-worthy service.');

define('SI_DEFAULT_SPECIALS', 'MON - $7-12 Burger Mania | TUE - $15 Bottomless Pasta | WED - $10 Wings | THU - $2.5 TACOS | FRI - $3 HAPPY DAD | WEEKENDS $10 Brunch Happy Hour');

/**
 * Get default content for a specific section
 *
 * @param string $section The section identifier
 * @return string The default content
 */
function si_get_default_content($section) {
    switch ($section) {
        case 'about_us':
            return SI_DEFAULT_ABOUT_US;
        case 'vip_text':
            return SI_DEFAULT_VIP_TEXT;
        case 'specials':
            return SI_DEFAULT_SPECIALS;
        default:
            return '';
    }
}

/**
 * Initialize default content if not already set
 */
function si_initialize_default_content() {
    // About Us Section
    if (!get_theme_mod('si_about_us_text')) {
        set_theme_mod('si_about_us_text', SI_DEFAULT_ABOUT_US);
    }

    // VIP Section
    if (!get_theme_mod('si_vip_text')) {
        set_theme_mod('si_vip_text', SI_DEFAULT_VIP_TEXT);
    }

    // Specials Section
    if (!get_theme_mod('si_specials_text')) {
        set_theme_mod('si_specials_text', SI_DEFAULT_SPECIALS);
    }
}
add_action('after_switch_theme', 'si_initialize_default_content'); 