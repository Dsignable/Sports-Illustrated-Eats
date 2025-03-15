<?php
/**
 * Customizer Controls
 *
 * @package Sports_Illustrated
 */

/**
 * Enqueue customizer control styles
 */
function si_customize_controls_enqueue_scripts() {
    wp_enqueue_style(
        'sports-illustrated-customizer-controls',
        get_theme_file_uri('/assets/css/customizer.css'),
        array(),
        SI_VERSION
    );
}
add_action('customize_controls_enqueue_scripts', 'si_customize_controls_enqueue_scripts');

/**
 * Add custom styles to the WordPress customizer.
 */
function si_customizer_styles() {
    ?>
    <style type="text/css">
        /* Ensure URL fields are visible */
        #customize-control-si_menu_dropdown_url_full,
        #customize-control-si_menu_dropdown_url_drink,
        #customize-control-si_menu_dropdown_url_brunch,
        #customize-control-si_menu_dropdown_url_happy,
        #customize-control-si_menu_dropdown_url_today {
            display: block !important;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        /* Add spacing between menu items */
        #customize-control-si_menu_dropdown_text_full,
        #customize-control-si_menu_dropdown_text_drink,
        #customize-control-si_menu_dropdown_text_brunch,
        #customize-control-si_menu_dropdown_text_happy,
        #customize-control-si_menu_dropdown_text_today {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        /* Make the heading more visible */
        #customize-control-si_menu_dropdown_heading {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-weight: bold;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'si_customizer_styles'); 