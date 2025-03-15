<?php
/**
 * Home Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add home page customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function si_home_page_customizer_settings($wp_customize) {
    // Add Home Page Section
    $wp_customize->add_section('si_home_page_section', array(
        'title'    => __('Home Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Menu Cards Section
    $wp_customize->add_setting('si_menu_cards_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_menu_cards_heading', array(
        'label'       => __('Menu Cards', 'sports-illustrated'),
        'description' => __('Configure the menu cards that appear on the front page.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Menu card settings for each type
    $menu_cards = array(
        'happy_hour' => 'Happy Hour',
        'fan_favorites' => 'Fan Favorites',
        'drinks_cocktails' => 'Drinks & Cocktails'
    );

    foreach ($menu_cards as $card_id => $card_name) {
        // Title setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_title', array(
            'default'           => $card_name,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        // Title control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_title', array(
            'label'       => $card_name . ' Card Title',
            'description' => sprintf(__('Enter the title for the %s menu card.', 'sports-illustrated'), $card_name),
            'section'     => 'si_home_page_section',
            'type'        => 'text',
        ));

        // Image setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'absint'
        ));

        // Image control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
            'si_menu_card_' . $card_id . '_image', 
            array(
                'label'       => $card_name . ' Card Image',
                'description' => sprintf(__('Select an image for the %s menu card.', 'sports-illustrated'), $card_name),
                'section'     => 'si_home_page_section',
                'mime_type'   => 'image',
            )
        ));

        // Link setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_link', array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Link control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_link', array(
            'label'       => $card_name . ' Card Link',
            'description' => sprintf(__('Enter the URL where the %s menu card should link to.', 'sports-illustrated'), $card_name),
            'section'     => 'si_home_page_section',
            'type'        => 'url',
        ));
    }

    // Move Homepage Background settings to Home Page Settings
    // Background Type
    $wp_customize->add_setting('si_background_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_background_type', array(
        'label'    => __('Background Type', 'sports-illustrated'),
        'description' => __('Choose between image or video background for the homepage.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'select',
        'choices'  => array(
            'image' => __('Image', 'sports-illustrated'),
            'video' => __('Video', 'sports-illustrated'),
        ),
    ));

    // Background Image
    $wp_customize->add_setting('si_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_background_image', array(
        'label'    => __('Background Image', 'sports-illustrated'),
        'description' => __('Upload an image for the homepage background.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'settings' => 'si_background_image',
    )));

    // Background Video URL
    $wp_customize->add_setting('si_background_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_background_video', array(
        'label'    => __('Background Video URL', 'sports-illustrated'),
        'description' => __('Enter a URL for the background video (YouTube, Vimeo, or direct video URL).', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'url',
    ));

    // Background Video File
    $wp_customize->add_setting('si_background_video_file', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_background_video_file', array(
        'label'    => __('Background Video File', 'sports-illustrated'),
        'description' => __('Upload a video file for the homepage background.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'mime_type' => 'video',
    )));

    // Hero Title
    $wp_customize->add_setting('si_hero_title', array(
        'default'           => __('SPORTS ILLUSTRATED CLUBHOUSE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_hero_title', array(
        'label'    => __('Hero Title', 'sports-illustrated'),
        'description' => __('Enter the main heading for the hero section.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('si_hero_subtitle', array(
        'default'           => __('WHERE FANS COME TO PLAY', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'sports-illustrated'),
        'description' => __('Enter the subtitle for the hero section.', 'sports-illustrated'),
        'section'  => 'si_home_page_section',
        'type'     => 'text',
    ));

    // Experience Section Settings (consolidated from si_experience_section_settings)
    $wp_customize->add_setting('si_experience_section_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_experience_section_heading', array(
        'label'       => __('Experience Section', 'sports-illustrated'),
        'description' => __('Configure the experience section on the homepage.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Experience Header Text
    $wp_customize->add_setting('si_experience_header_text', array(
        'default'           => __('SPORTS ILLUSTRATED CLUBHOUSE', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_experience_header_text', array(
        'label'       => __('Experience Header Text', 'sports-illustrated'),
        'description' => __('Enter the header text for the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Experience Content Title
    $wp_customize->add_setting('si_experience_content_title', array(
        'default'           => __('A DINING EXPERIENCE LIKE NO OTHER', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_experience_content_title', array(
        'label'       => __('Experience Content Title', 'sports-illustrated'),
        'description' => __('Enter the title for the experience content section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Experience Description
    $wp_customize->add_setting('si_experience_description', array(
        'default'           => __('At Sports Illustrated Clubhouse, we bring the excitement of the game to your table with a menu crafted to satisfy every craving. Our signature dishes are inspired by the energy and spirit of sports, blending bold flavors with fresh, locally sourced ingredients. Whether you\'re catching the big game with friends or celebrating a special occasion, our menu features a lineup of winning options that include sizzling burgers, hand-crafted pizzas, zesty wings, and fresh, crisp salads. Every dish is designed to make your taste buds cheer, from classic comfort foods to innovative culinary creations.', 'sports-illustrated'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('si_experience_description', array(
        'label'       => __('Experience Description', 'sports-illustrated'),
        'description' => __('Enter the description text for the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Experience Top Photo
    $wp_customize->add_setting('si_experience_top_photo', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_top_photo', array(
        'label'       => __('Experience Top Photo', 'sports-illustrated'),
        'description' => __('Upload an image for the top of the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Experience Bottom Photo
    $wp_customize->add_setting('si_experience_bottom_photo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_bottom_photo', array(
        'label'       => __('Experience Bottom Photo', 'sports-illustrated'),
        'description' => __('Upload an image for the bottom of the experience section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Featured Content Section (formerly Sports Highlights)
    $wp_customize->add_setting('si_featured_content_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_featured_content_heading', array(
        'label'       => __('Featured Content Section (formerly Sports Highlights)', 'sports-illustrated'),
        'description' => __('Configure the featured content section on the homepage.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'hidden',
    )));

    // Featured Left Image
    $wp_customize->add_setting('si_featured_left_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_featured_left_image', array(
        'label'       => __('Featured Left Image', 'sports-illustrated'),
        'description' => __('Upload an image for the left side of the featured content section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Featured Left Image X Position
    $wp_customize->add_setting('si_featured_left_image_x_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_left_image_x_position', array(
        'label'       => __('Left Image X Position (%)', 'sports-illustrated'),
        'description' => __('Adjust the horizontal position of the left image (positive values move right, negative values move left).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => -100,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Featured Left Image Y Position
    $wp_customize->add_setting('si_featured_left_image_y_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_left_image_y_position', array(
        'label'       => __('Left Image Y Position (%)', 'sports-illustrated'),
        'description' => __('Adjust the vertical position of the left image (positive values move down, negative values move up).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => -100,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Featured Top Title
    $wp_customize->add_setting('si_featured_top_title', array(
        'default'           => __('NEVER MISS A MOMENT AT YOUR HOME AWAY FROM HOME', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_top_title', array(
        'label'       => __('Featured Top Title', 'sports-illustrated'),
        'description' => __('Enter the title for the top section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Featured Top Description
    $wp_customize->add_setting('si_featured_top_description', array(
        'default'           => __('The Sports Illustrated Clubhouse interior is a celebration of sports culture, blending sophistication with a vibrant, game-day atmosphere. From the moment you walk in, you\'re surrounded by iconic memorabilia, larger-than-life murals of legendary athletes, and screens broadcasting the biggest moments in sports history. The design seamlessly merges modern elegance with a love for the game, featuring sleek lines, warm wood accents, and dynamic lighting that creates the perfect ambiance for every occasion.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('si_featured_top_description', array(
        'label'       => __('Featured Top Description', 'sports-illustrated'),
        'description' => __('Enter the description for the top section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Featured Bottom Title
    $wp_customize->add_setting('si_featured_bottom_title', array(
        'default'           => __('A DINING EXPERIENCE LIKE NO OTHER', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_bottom_title', array(
        'label'       => __('Featured Bottom Title', 'sports-illustrated'),
        'description' => __('Enter the title for the bottom section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'text',
    ));

    // Featured Bottom Description
    $wp_customize->add_setting('si_featured_bottom_description', array(
        'default'           => __('Our signature dishes are inspired by the energy and spirit of sports, blending bold flavors with fresh, locally sourced ingredients. Whether you\'re catching the big game with friends or celebrating a special occasion, our menu features a lineup of winning options that include sizzling burgers, hand-crafted pizzas, zesty wings, and fresh, crisp salads.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('si_featured_bottom_description', array(
        'label'       => __('Featured Bottom Description', 'sports-illustrated'),
        'description' => __('Enter the description for the bottom section of the featured content.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'textarea',
    ));

    // Featured Right Image
    $wp_customize->add_setting('si_featured_right_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_featured_right_image', array(
        'label'       => __('Featured Right Image', 'sports-illustrated'),
        'description' => __('Upload an image for the right side of the featured content section.', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'mime_type'   => 'image',
    )));

    // Featured Right Image X Position
    $wp_customize->add_setting('si_featured_right_image_x_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_right_image_x_position', array(
        'label'       => __('Right Image X Position (%)', 'sports-illustrated'),
        'description' => __('Adjust the horizontal position of the right image (positive values move left, negative values move right).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => -100,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Featured Right Image Y Position
    $wp_customize->add_setting('si_featured_right_image_y_position', array(
        'default'           => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_featured_right_image_y_position', array(
        'label'       => __('Right Image Y Position (%)', 'sports-illustrated'),
        'description' => __('Adjust the vertical position of the right image (positive values move down, negative values move up).', 'sports-illustrated'),
        'section'     => 'si_home_page_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => -100,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Add more settings from the original function as needed
} 