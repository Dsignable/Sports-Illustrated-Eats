<?php
/**
 * Menu Dropdown Customizer Settings
 *
 * @package Sports_Illustrated
 */

/**
 * Add menu dropdown settings to the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_customize_menu_dropdown($wp_customize) {
    // Menu Dropdown Section
    $wp_customize->add_section('si_menu_dropdown', array(
        'title'    => __('Menu Dropdown Options', 'sports-illustrated'),
        'priority' => 30,
        'panel'    => 'si_header_panel',
    ));

    // Menu Types
    $menu_types = array(
        'full' => 'Full Menu',
        'drink' => 'Drink Menu',
        'brunch' => 'Brunch Menu',
        'happy' => 'Happy Hour',
        'today' => 'Today\'s Menu'
    );

    foreach ($menu_types as $key => $label) {
        // Menu Item Visibility
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_visible', array(
            'default'           => true,
            'sanitize_callback' => 'si_sanitize_checkbox',
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_visible', array(
            'label'    => sprintf(__('Show %s', 'sports-illustrated'), $label),
            'section'  => 'si_menu_dropdown',
            'type'     => 'checkbox',
        ));

        // Menu Item Label
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_label', array(
            'default'           => $label,
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_label', array(
            'label'    => sprintf(__('%s Label', 'sports-illustrated'), $label),
            'section'  => 'si_menu_dropdown',
            'type'     => 'text',
        ));

        // Menu Item URL
        $wp_customize->add_setting('si_menu_dropdown_' . $key . '_url', array(
            'default'           => home_url('/menu/?menu=' . $key),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_menu_dropdown_' . $key . '_url', array(
            'label'    => sprintf(__('%s URL', 'sports-illustrated'), $label),
            'section'  => 'si_menu_dropdown',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'si_customize_menu_dropdown');

/**
 * Sanitize checkbox values
 */
function si_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
} 