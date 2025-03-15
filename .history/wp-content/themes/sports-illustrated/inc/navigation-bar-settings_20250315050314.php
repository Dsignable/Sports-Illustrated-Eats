<?php
/**
 * Navigation Bar Settings Customizer
 *
 * @package Sports_Illustrated
 */

/**
 * Add Navigation Bar Settings to the customizer
 */
function si_navigation_bar_settings_customizer($wp_customize) {
    // Add Navigation Bar Settings Section
    $wp_customize->add_section('si_navigation_bar_settings', array(
        'title'    => __('Navigation Bar Settings', 'sports-illustrated'),
        'priority' => 29, // Just before Header Navigation
        'description' => __('Configure the navigation bar menu items and dropdowns.', 'sports-illustrated'),
    ));

    // Left Menu Section
    $wp_customize->add_setting('si_nav_left_menu_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_nav_left_menu_heading', array(
        'label'       => __('Left Menu Items', 'sports-illustrated'),
        'description' => __('Configure the left side menu items.', 'sports-illustrated'),
        'section'     => 'si_navigation_bar_settings',
        'type'        => 'hidden',
    )));

    // Left Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_nav_left_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_nav_left_menu_text_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'text',
            'priority' => 10 + (($i - 1) * 10),
        ));

        // Item URL
        $wp_customize->add_setting('si_nav_left_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_nav_left_menu_url_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'url',
            'priority' => 11 + (($i - 1) * 10),
        ));

        // Item Visibility
        $wp_customize->add_setting('si_nav_left_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_nav_left_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Left Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'checkbox',
            'priority' => 12 + (($i - 1) * 10),
        ));
        
        // Has Dropdown
        $wp_customize->add_setting('si_nav_left_menu_has_dropdown_' . $i, array(
            'default'           => $i == 1, // Default true for Menu (1st item)
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_nav_left_menu_has_dropdown_' . $i, array(
            'label'    => sprintf(__('Enable Dropdown for Left Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'checkbox',
            'priority' => 13 + (($i - 1) * 10),
        ));
    }
    
    // Menu Dropdown Items Section
    $wp_customize->add_setting('si_nav_menu_dropdown_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_nav_menu_dropdown_heading', array(
        'label'       => __('Menu Dropdown Items', 'sports-illustrated'),
        'description' => __('Configure the dropdown items for the Menu button.', 'sports-illustrated'),
        'section'     => 'si_navigation_bar_settings',
        'type'        => 'hidden',
        'priority'    => 40,
    )));
    
    // Menu dropdown items
    $menu_items = array(
        'full'   => __('Full Menu', 'sports-illustrated'),
        'drink'  => __('Drink Menu', 'sports-illustrated'),
        'brunch' => __('Brunch Menu', 'sports-illustrated'),
        'happy'  => __('Happy Hour', 'sports-illustrated'),
        'today'  => __('Today\'s Menu', 'sports-illustrated')
    );
    
    $item_count = 0;
    foreach ($menu_items as $key => $label) {
        $item_count++;
        
        // Menu dropdown item text
        $wp_customize->add_setting('si_nav_menu_dropdown_text_' . $key, array(
            'default'           => $label,
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));
        
        $wp_customize->add_control('si_nav_menu_dropdown_text_' . $key, array(
            'label'       => sprintf(__('%s Text', 'sports-illustrated'), $label),
            'section'     => 'si_navigation_bar_settings',
            'type'        => 'text',
            'priority'    => 41 + (($item_count - 1) * 3),
        ));
        
        // Menu dropdown item URL
        $wp_customize->add_setting('si_nav_menu_dropdown_url_' . $key, array(
            'default'           => home_url('/menu/?menu=' . $key),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ));
        
        $wp_customize->add_control('si_nav_menu_dropdown_url_' . $key, array(
            'label'       => sprintf(__('%s URL', 'sports-illustrated'), $label),
            'section'     => 'si_navigation_bar_settings',
            'type'        => 'url',
            'priority'    => 42 + (($item_count - 1) * 3),
        ));
        
        // Menu dropdown item visibility
        $wp_customize->add_setting('si_nav_menu_dropdown_visible_' . $key, array(
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));
        
        $wp_customize->add_control('si_nav_menu_dropdown_visible_' . $key, array(
            'label'       => sprintf(__('Show %s', 'sports-illustrated'), $label),
            'section'     => 'si_navigation_bar_settings',
            'type'        => 'checkbox',
            'priority'    => 43 + (($item_count - 1) * 3),
        ));
    }
    
    // Right Menu Section
    $wp_customize->add_setting('si_nav_right_menu_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_nav_right_menu_heading', array(
        'label'       => __('Right Menu Items', 'sports-illustrated'),
        'description' => __('Configure the right side menu items.', 'sports-illustrated'),
        'section'     => 'si_navigation_bar_settings',
        'type'        => 'hidden',
        'priority'    => 60,
    )));

    // Right Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_nav_right_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_nav_right_menu_text_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'text',
            'priority' => 61 + (($i - 1) * 10),
        ));

        // Item URL
        $wp_customize->add_setting('si_nav_right_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_nav_right_menu_url_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'url',
            'priority' => 62 + (($i - 1) * 10),
        ));

        // Item Visibility
        $wp_customize->add_setting('si_nav_right_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_nav_right_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Right Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'checkbox',
            'priority' => 63 + (($i - 1) * 10),
        ));
        
        // Has Dropdown
        $wp_customize->add_setting('si_nav_right_menu_has_dropdown_' . $i, array(
            'default'           => $i == 3, // Default true for Contact Us (3rd item)
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_nav_right_menu_has_dropdown_' . $i, array(
            'label'    => sprintf(__('Enable Dropdown for Right Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_navigation_bar_settings',
            'type'     => 'checkbox',
            'priority' => 64 + (($i - 1) * 10),
        ));
        
        // Dropdown Items (up to 5)
        for ($j = 1; $j <= 5; $j++) {
            // Dropdown Item Text
            $wp_customize->add_setting('si_nav_right_menu_dropdown_' . $i . '_text_' . $j, array(
                'default'           => $i == 3 && $j == 1 ? 'CONTACT THE RESTAURANT' : ($i == 3 && $j == 2 ? 'FRANCHISE OPPORTUNITIES' : ''),
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('si_nav_right_menu_dropdown_' . $i . '_text_' . $j, array(
                'label'    => sprintf(__('Right Menu Item %d Dropdown Item %d Text', 'sports-illustrated'), $i, $j),
                'section'  => 'si_navigation_bar_settings',
                'type'     => 'text',
                'priority' => 65 + (($i - 1) * 50) + (($j - 1) * 3),
            ));

            // Dropdown Item URL
            $wp_customize->add_setting('si_nav_right_menu_dropdown_' . $i . '_url_' . $j, array(
                'default'           => $i == 3 && $j == 1 ? home_url('/contact/') : ($i == 3 && $j == 2 ? home_url('/franchise/') : ''),
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control('si_nav_right_menu_dropdown_' . $i . '_url_' . $j, array(
                'label'    => sprintf(__('Right Menu Item %d Dropdown Item %d URL', 'sports-illustrated'), $i, $j),
                'section'  => 'si_navigation_bar_settings',
                'type'     => 'url',
                'priority' => 66 + (($i - 1) * 50) + (($j - 1) * 3),
            ));

            // Dropdown Item Visibility
            $wp_customize->add_setting('si_nav_right_menu_dropdown_' . $i . '_visible_' . $j, array(
                'default'           => $i == 3 && ($j == 1 || $j == 2),
                'sanitize_callback' => 'rest_sanitize_boolean',
            ));

            $wp_customize->add_control('si_nav_right_menu_dropdown_' . $i . '_visible_' . $j, array(
                'label'    => sprintf(__('Show Right Menu Item %d Dropdown Item %d', 'sports-illustrated'), $i, $j),
                'section'  => 'si_navigation_bar_settings',
                'type'     => 'checkbox',
                'priority' => 67 + (($i - 1) * 50) + (($j - 1) * 3),
            ));
        }
    }
}
add_action('customize_register', 'si_navigation_bar_settings_customizer');

/**
 * Enqueue scripts for the customizer preview
 */
function si_nav_customizer_preview_scripts() {
    if (is_customize_preview()) {
        wp_enqueue_script(
            'si-nav-customizer',
            get_template_directory_uri() . '/assets/js/nav-customizer.js',
            array('jquery', 'customize-preview'),
            SI_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'si_nav_customizer_preview_scripts');

/**
 * Sanitize boolean values
 */
function si_nav_sanitize_boolean($value) {
    return (bool) $value;
} 