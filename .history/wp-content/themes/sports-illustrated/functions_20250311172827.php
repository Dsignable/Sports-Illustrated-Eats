<?php
/**
 * Sports Illustrated theme functions and definitions
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme version
if (!defined('SI_VERSION')) {
    define('SI_VERSION', wp_get_theme()->get('Version'));
}

// Enable debugging
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

/**
 * Enqueue scripts and styles
 */
function sports_illustrated_enqueue_assets() {
    // Enqueue styles
    wp_enqueue_style(
        'sports-illustrated-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(),
        '6.0.0'
    );

    // Enqueue main stylesheet
    wp_enqueue_style(
        'sports-illustrated-main',
        get_theme_file_uri('assets/css/main.css'),
        array(),
        SI_VERSION . '.' . time()  // Force cache bust
    );

    // Enqueue button styles
    wp_enqueue_style(
        'sports-illustrated-buttons',
        get_theme_file_uri('assets/css/buttons.css'),
        array('sports-illustrated-main'),
        SI_VERSION . '.' . time()  // Force cache bust
    );

    // Enqueue jQuery first
    wp_enqueue_script('jquery');

    // Enqueue navigation script with jQuery dependency
    wp_enqueue_script(
        'sports-illustrated-navigation',
        get_theme_file_uri('/assets/js/navigation.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),  // Force cache bust
        true
    );

    // Add debug information
    wp_localize_script('sports-illustrated-navigation', 'siDebug', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'themeUrl' => get_template_directory_uri(),
        'debug' => WP_DEBUG,
        'isHome' => is_home() || is_front_page()
    ));

    // Enqueue scroll animations after navigation
    wp_enqueue_script(
        'sports-illustrated-scroll-animations',
        get_theme_file_uri('assets/js/scroll-animations.js'),
        array('jquery', 'sports-illustrated-navigation'),
        SI_VERSION . '.' . time(),
        true
    );

    // Remove menu.js as it might conflict with navigation.js
    // wp_enqueue_script(
    //     'sports-illustrated-menu',
    //     get_theme_file_uri('assets/js/menu.js'),
    //     array('jquery'),
    //     SI_VERSION . '.' . time(),
    //     true
    // );

    // Add inline script for debugging
    wp_add_inline_script('sports-illustrated-navigation', 'console.log("Navigation script loaded with debug:", siDebug);', 'before');
}
add_action('wp_enqueue_scripts', 'sports_illustrated_enqueue_assets');

// Add this new function to debug script loading
function si_debug_scripts() {
    global $wp_scripts;
    error_log('=== Enqueued Scripts ===');
    foreach ($wp_scripts->queue as $handle) {
        error_log("Script: $handle - Source: " . $wp_scripts->registered[$handle]->src);
    }
    error_log('=====================');
}
add_action('wp_print_scripts', 'si_debug_scripts', 99);

/**
 * Theme setup
 */
function sports_illustrated_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 60,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'sports-illustrated'),
        'mobile'  => esc_html__('Mobile Menu', 'sports-illustrated'),
    ));
}
add_action('after_setup_theme', 'sports_illustrated_setup');

/**
 * Register widget area
 */
function sports_illustrated_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'sports-illustrated'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'sports-illustrated'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'sports_illustrated_widgets_init');

/**
 * Customizer additions
 */
function sports_illustrated_customize_register($wp_customize) {
    // Add section for homepage background
    $wp_customize->add_section('si_homepage_background', array(
        'title'    => __('Homepage Background', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Add background type setting
    $wp_customize->add_setting('si_background_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_background_type', array(
        'label'    => __('Background Type', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
        'type'     => 'select',
        'choices'  => array(
            'image' => __('Image', 'sports-illustrated'),
            'video' => __('Video', 'sports-illustrated'),
        ),
    ));

    // Add background image setting
    $wp_customize->add_setting('si_background_image', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'si_background_image', array(
        'label'    => __('Background Image', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
    )));

    // Add background video setting
    $wp_customize->add_setting('si_background_video', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('si_background_video', array(
        'label'    => __('Background Video URL (MP4)', 'sports-illustrated'),
        'section'  => 'si_homepage_background',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'sports_illustrated_customize_register');

/**
 * Allow PDF uploads
 */
function si_allow_pdf_uploads($mime_types) {
    $mime_types['pdf'] = 'application/pdf';
    return $mime_types;
}
add_filter('upload_mimes', 'si_allow_pdf_uploads');

/**
 * Add menu customizer settings
 */
function si_menu_customizer_settings($wp_customize) {
    // Add Menu Page Background Section
    $wp_customize->add_section('si_menu_page_section', array(
        'title'    => __('Menu Page Settings', 'sports-illustrated'),
        'description' => __('Configure the menu page background, menu images, and downloadable PDF menus.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Background Image
    $wp_customize->add_setting('si_menu_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_bg', array(
        'label'    => __('Menu Page Background', 'sports-illustrated'),
        'description' => __('Select a background image for the entire menu page.', 'sports-illustrated'),
        'section'  => 'si_menu_page_section',
        'mime_type' => 'image',
    )));

    // Restaurant Menu PDF Uploads
    $wp_customize->add_setting('si_restaurant_menu_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_restaurant_menu_heading', array(
        'label'    => __('Restaurant Menu PDFs', 'sports-illustrated'),
        'description' => __('Upload PDF versions of your restaurant menus for visitors to download.', 'sports-illustrated'),
        'section'  => 'si_menu_page_section',
        'type'     => 'hidden',
    )));

    // Restaurant Menu PDFs
    $restaurant_menus = array(
        'full'    => 'Full Menu PDF',
        'drink'   => 'Drink Menu PDF',
        'brunch'  => 'Brunch Menu PDF',
        'happy'   => 'Happy Hour Menu PDF',
        'burger'  => 'Burger Menu PDF'
    );

    foreach ($restaurant_menus as $type => $label) {
        $wp_customize->add_setting('si_restaurant_menu_' . $type . '_pdf', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_restaurant_menu_' . $type . '_pdf', array(
            'label'    => $label,
            'description' => sprintf(__('Upload a PDF version of your %s for visitors to download.', 'sports-illustrated'), strtolower($label)),
            'section'  => 'si_menu_page_section',
            'mime_type' => 'application/pdf',
        )));
    }

    // Menu Images Heading
    $wp_customize->add_setting('si_menu_images_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'si_menu_images_heading', array(
        'label'    => __('Menu Images', 'sports-illustrated'),
        'description' => __('Upload images of your menus to display on the menu page.', 'sports-illustrated'),
        'section'  => 'si_menu_page_section',
        'type'     => 'hidden',
    )));

    // Menu Images
    $menu_types = array(
        'full'    => 'Full Menu',
        'drink'   => 'Drink Menu',
        'brunch'  => 'Brunch Menu',
        'happy'   => 'Happy Hour Menu',
        'burger'  => 'Burger Menu',
        'today'   => 'Today\'s Menu'
    );

    foreach ($menu_types as $type => $label) {
        $wp_customize->add_setting('si_menu_' . $type . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_' . $type . '_image', array(
            'label'    => $label . ' Image',
            'description' => sprintf(__('Upload an image of your %s to display on the menu page.', 'sports-illustrated'), strtolower($label)),
            'section'  => 'si_menu_page_section',
            'mime_type' => 'image',
        )));
    }
}
add_action('customize_register', 'si_menu_customizer_settings');

/**
 * Get menu PDF URL from attachment ID
 */
function si_get_menu_pdf_url($setting_name) {
    $attachment_id = get_theme_mod($setting_name);
    if ($attachment_id && is_numeric($attachment_id)) {
        $attachment_url = wp_get_attachment_url($attachment_id);
        if ($attachment_url && pathinfo($attachment_url, PATHINFO_EXTENSION) === 'pdf') {
            return $attachment_url;
        }
    }
    return '';
}

/**
 * Get menu page URL with optional menu type parameter
 */
function si_get_menu_url($menu_type = '') {
    $menu_page = get_page_by_path('menu');
    if ($menu_page) {
        $url = get_permalink($menu_page->ID);
        if ($menu_type) {
            $url = add_query_arg('menu', $menu_type, $url);
        }
        return $url;
    }
    return home_url('/menu/');
}

/**
 * Handle contact form submissions
 */
function si_handle_contact_form() {
    if (!isset($_POST['si_nonce']) || !wp_verify_nonce($_POST['si_nonce'], 'si_contact_form_nonce')) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    // Save to WordPress database
    $post_data = array(
        'post_title'    => wp_strip_all_tags($subject),
        'post_content'  => $message,
        'post_status'   => 'publish',
        'post_type'     => 'si_contact_form'
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Add contact form meta
        add_post_meta($post_id, '_contact_name', $name);
        add_post_meta($post_id, '_contact_email', $email);
        add_post_meta($post_id, '_contact_phone', $phone);
        
        // Send email notification
        $to = get_option('admin_email');
        $email_subject = 'New Contact Form Submission: ' . $subject;
        $email_message = "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Phone: $phone\n";
        $email_message .= "Subject: $subject\n\n";
        $email_message .= "Message:\n$message";
        
        wp_mail($to, $email_subject, $email_message);
        
        wp_send_json_success('Message sent successfully');
    } else {
        wp_send_json_error('Error saving message');
    }
}
add_action('wp_ajax_si_contact_form', 'si_handle_contact_form');
add_action('wp_ajax_nopriv_si_contact_form', 'si_handle_contact_form');

/**
 * Register Contact Form Custom Post Type
 */
function si_register_contact_form_cpt() {
    $args = array(
        'public'       => false,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-email-alt',
        'labels'       => array(
            'name'          => 'Contact Forms',
            'singular_name' => 'Contact Form',
            'menu_name'     => 'Contact Forms',
            'all_items'     => 'All Submissions',
            'add_new'       => 'Add New',
            'add_new_item' => 'Add New Submission',
            'edit_item'    => 'Edit Submission',
            'view_item'    => 'View Submission',
        ),
        'supports'     => array('title', 'editor'),
        'capabilities' => array(
            'create_posts' => false,
        ),
        'map_meta_cap' => true,
    );
    
    register_post_type('si_contact_form', $args);
}
add_action('init', 'si_register_contact_form_cpt');

/**
 * Add custom columns to contact form admin list
 */
function si_contact_form_columns($columns) {
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => 'Subject',
        'name'      => 'Name',
        'email'     => 'Email',
        'phone'     => 'Phone',
        'date'      => 'Date'
    );
    return $columns;
}
add_filter('manage_si_contact_form_posts_columns', 'si_contact_form_columns');

/**
 * Display custom column data
 */
function si_contact_form_column_data($column, $post_id) {
    switch ($column) {
        case 'name':
            echo esc_html(get_post_meta($post_id, '_contact_name', true));
            break;
        case 'email':
            echo esc_html(get_post_meta($post_id, '_contact_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_contact_phone', true));
            break;
    }
}
add_action('manage_si_contact_form_posts_custom_column', 'si_contact_form_column_data', 10, 2);

/**
 * Enqueue contact form scripts
 */
function si_enqueue_contact_scripts() {
    if (is_page_template('page-contact.php')) {
        wp_enqueue_script(
            'si-contact-form',
            get_theme_file_uri('/assets/js/contact-form.js'),
            array('jquery'),
            wp_get_theme()->get('Version'),
            true
        );

        wp_localize_script('si-contact-form', 'siContact', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('contact_form_submit')
        ));
    }
}
add_action('wp_enqueue_scripts', 'si_enqueue_contact_scripts');

/**
 * Add customizer settings for landing page images
 */
function si_landing_page_images($wp_customize) {
    // Add section for landing page images
    $wp_customize->add_section('si_landing_images', array(
        'title'    => __('Landing Page Images', 'sports-illustrated'),
        'priority' => 31,
    ));

    // Landing Page Images (excluding menu cards which are handled in si_landing_page_menu_cards)
    $image_settings = array(
        'experience_bg' => 'Experience Section Background',
        'interior_image' => 'Interior Image',
        'location_1' => 'Location Image 1',
        'location_2' => 'Location Image 2'
    );

    foreach ($image_settings as $key => $label) {
        $wp_customize->add_setting('si_image_' . $key, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh'
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_image_' . $key, array(
            'label'         => __($label, 'sports-illustrated'),
            'section'       => 'si_landing_images',
            'mime_type'     => 'image',
            'button_labels' => array(
                'select'       => __('Select Image'),
                'change'       => __('Change Image'),
                'remove'       => __('Remove'),
                'default'      => __('Default'),
                'placeholder'  => __('No image selected'),
                'frame_title'  => __('Select Image'),
                'frame_button' => __('Choose Image'),
            ),
        )));
    }

    // Add Contact Page Image
    $wp_customize->add_setting('si_contact_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_contact_image', array(
        'label'         => __('Contact Page Image', 'sports-illustrated'),
        'section'       => 'si_landing_images',
        'mime_type'     => 'image',
        'button_labels' => array(
            'select'       => __('Select Image'),
            'change'       => __('Change Image'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No image selected'),
            'frame_title'  => __('Select Image'),
            'frame_button' => __('Choose Image'),
        ),
    )));
}
add_action('customize_register', 'si_landing_page_images');

/**
 * Helper function to get image URL from customizer setting
 */
function si_get_image_url($setting_name, $default = '') {
    $attachment_id = get_theme_mod($setting_name);
    if ($attachment_id) {
        $image_url = wp_get_attachment_image_url($attachment_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    return $default;
}

function si_contact_page_settings($wp_customize) {
    // Contact Page Section
    $wp_customize->add_section('si_contact_page_section', array(
        'title'    => __('Contact Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Contact Page Image
    $wp_customize->add_setting('si_contact_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_contact_image', array(
        'label'     => __('Contact Page Image', 'sports-illustrated'),
        'section'   => 'si_contact_page_section',
        'settings'  => 'si_contact_image',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_contact_page_settings');

function si_monthly_events_settings($wp_customize) {
    // Monthly Events Section
    $wp_customize->add_section('si_monthly_events_section', array(
        'title'    => __('Monthly Events Settings', 'sports-illustrated'),
        'priority' => 35,
    ));

    // Monthly Events Title
    $wp_customize->add_setting('si_monthly_events_title', array(
        'default'           => 'SI CLUBHOUSE MONTHLY EVENTS',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_monthly_events_title', array(
        'label'    => __('Events Section Title', 'sports-illustrated'),
        'section'  => 'si_monthly_events_section',
        'type'     => 'text',
    ));

    // Add up to 8 event images
    for ($i = 1; $i <= 8; $i++) {
        // Event Image
        $wp_customize->add_setting("si_event_image_$i", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "si_event_image_$i", array(
            'label'     => sprintf(__('Event Image %d', 'sports-illustrated'), $i),
            'section'   => 'si_monthly_events_section',
            'settings'  => "si_event_image_$i",
            'mime_type' => 'image',
        )));

        // Event Title
        $wp_customize->add_setting("si_event_title_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("si_event_title_$i", array(
            'label'    => sprintf(__('Event Title %d', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'text',
        ));

        // Event Link
        $wp_customize->add_setting("si_event_link_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("si_event_link_$i", array(
            'label'    => sprintf(__('Event Link %d', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'url',
        ));

        // Event Date
        $wp_customize->add_setting("si_event_date_$i", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("si_event_date_$i", array(
            'label'    => sprintf(__('Event Date %d', 'sports-illustrated'), $i),
            'section'  => 'si_monthly_events_section',
            'type'     => 'text',
        ));
    }
}
add_action('customize_register', 'si_monthly_events_settings');

function si_landing_page_menu_cards($wp_customize) {
    // Add section for menu cards
    $wp_customize->add_section('si_menu_cards_section', array(
        'title' => __('Menu Cards Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Array of menu cards
    $menu_cards = array(
        'happy_hour' => 'Happy Hour Menu Card',
        'fan_favorites' => 'Fan Favorites Menu Card',
        'drinks_cocktails' => 'Drinks & Cocktails Menu Card'
    );

    // Add settings and controls for each menu card
    foreach ($menu_cards as $card_id => $card_name) {
        // Image setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_image', array(
            'default' => '',
            'sanitize_callback' => 'absint'
        ));

        // Image control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
            'si_menu_card_' . $card_id . '_image', 
            array(
                'label' => $card_name . ' Image',
                'section' => 'si_menu_cards_section',
                'mime_type' => 'image',
            )
        ));

        // Link setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_link', array(
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Link control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_link', array(
            'label' => $card_name . ' Link',
            'section' => 'si_menu_cards_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'si_landing_page_menu_cards');

// Helper function to get menu card image URL
function si_get_menu_card_image($card_id, $default = '') {
    $attachment_id = get_theme_mod('si_menu_card_' . $card_id . '_image');
    
    if ($attachment_id) {
        $image_url = wp_get_attachment_image_url($attachment_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    
    // Add debugging
    error_log('Menu Card Image Debug - Card ID: ' . $card_id);
    error_log('Menu Card Image Debug - Attachment ID: ' . var_export($attachment_id, true));
    error_log('Menu Card Image Debug - Default Image: ' . var_export($default, true));
    
    return $default;
}

// Helper function to get menu card link
function si_get_menu_card_link($card_id) {
    $link = get_theme_mod('si_menu_card_' . $card_id . '_link', '#');
    
    // Add debugging
    error_log('Menu Card Link Debug - Card ID: ' . $card_id);
    error_log('Menu Card Link Debug - Link: ' . var_export($link, true));
    
    if (empty($link)) {
        return '#';
    }
    
    return $link;
}

// Add Contact Form 7 debugging
add_filter('wpcf7_config_validator_email', function($error, $args) {
    error_log('CF7 Email Config Validation:');
    error_log(print_r($args, true));
    return $error;
}, 10, 2);

add_action('wpcf7_mail_failed', function($contact_form) {
    error_log('CF7 Mail Failed:');
    error_log(print_r($contact_form->prop('mail'), true));
});

// Add better error handling for Contact Form 7
add_filter('wpcf7_ajax_json_echo', function($response, $result) {
    if (!$result['success']) {
        error_log('CF7 Submission Error:');
        error_log(print_r($result, true));
    }
    return $response;
}, 10, 2);

// Temporary fix for CF7 mail errors
add_filter('wpcf7_skip_mail', '__return_true');

// Log form submissions even if mail fails
add_action('wpcf7_before_send_mail', function($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        error_log('Form submission data:');
        error_log(print_r($posted_data, true));
    }
});

function si_experience_section_settings($wp_customize) {
    // Add Experience Section
    $wp_customize->add_section('si_experience_section', array(
        'title'    => __('Experience Section Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Top Right Photo
    $wp_customize->add_setting('si_experience_top_photo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_top_photo', array(
        'label'    => __('Top Right Photo', 'sports-illustrated'),
        'section'  => 'si_experience_section',
        'settings' => 'si_experience_top_photo',
        'mime_type' => 'image',
    )));

    // Bottom Left Photo
    $wp_customize->add_setting('si_experience_bottom_photo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_experience_bottom_photo', array(
        'label'    => __('Bottom Left Photo', 'sports-illustrated'),
        'section'  => 'si_experience_section',
        'settings' => 'si_experience_bottom_photo',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_experience_section_settings');

/**
 * Include customizer settings
 */
require get_template_directory() . '/inc/customizer/page-customizer.php';

// Add Menu Cards Section to Customizer
function si_menu_cards_customizer($wp_customize) {
    $wp_customize->add_section('si_menu_cards_section', array(
        'title'    => __('Front Page Menu Cards', 'sports-illustrated'),
        'description' => __('Configure the menu cards that appear on the front page of the website.', 'sports-illustrated'),
        'priority' => 31,
    ));

    // Menu card settings for each type
    $menu_cards = array(
        'happy_hour' => 'Happy Hour',
        'fan_favorites' => 'Fan Favorites',
        'drinks_cocktails' => 'Drinks & Cocktails'
    );

    foreach ($menu_cards as $card_id => $card_name) {
        // Image setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'absint'
        ));

        // Image control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 
            'si_menu_card_' . $card_id . '_image', 
            array(
                'label'     => $card_name . ' Card Image',
                'description' => sprintf(__('Select an image for the %s menu card on the front page.', 'sports-illustrated'), $card_name),
                'section'   => 'si_menu_cards_section',
                'mime_type' => 'image',
            )
        ));

        // Link setting
        $wp_customize->add_setting('si_menu_card_' . $card_id . '_link', array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Link control
        $wp_customize->add_control('si_menu_card_' . $card_id . '_link', array(
            'label'    => $card_name . ' Card Link',
            'description' => sprintf(__('Enter the URL where the %s menu card should link to.', 'sports-illustrated'), $card_name),
            'section'  => 'si_menu_cards_section',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'si_menu_cards_customizer');

// Remove the old menu customizer function since we've split it into separate functions
remove_action('customize_register', 'si_menu_customizer_settings');

function si_page_backgrounds_customizer($wp_customize) {
    // Add Page Backgrounds Section
    $wp_customize->add_section('si_page_backgrounds', array(
        'title'    => __('Page Backgrounds', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Define pages that need background images
    $pages = array(
        'menu'         => 'Menu Page',
        'careers'      => 'Careers Page',
        'news'         => 'News Page',
        'gift'         => 'Gift Cards Section',
        'privacy'      => 'Privacy Policy Page',
        'reservations' => 'Reservations Page'
    );

    foreach ($pages as $page_id => $page_name) {
        // Background Image Setting
        $wp_customize->add_setting('si_' . $page_id . '_bg', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        // Background Image Control
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_' . $page_id . '_bg', array(
            'label'    => $page_name . ' Background',
            'section'  => 'si_page_backgrounds',
            'mime_type' => 'image',
        )));

        // Background Overlay Opacity
        $wp_customize->add_setting('si_' . $page_id . '_bg_opacity', array(
            'default'           => '0.6',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_' . $page_id . '_bg_opacity', array(
            'label'    => $page_name . ' Overlay Opacity',
            'section'  => 'si_page_backgrounds',
            'type'     => 'select',
            'choices'  => array(
                '0.3' => '30%',
                '0.4' => '40%',
                '0.5' => '50%',
                '0.6' => '60%',
                '0.7' => '70%',
                '0.8' => '80%',
            ),
        ));
    }
}
add_action('customize_register', 'si_page_backgrounds_customizer');

// Helper function to get background style
function si_get_background_style($page_id) {
    $bg_image_id = get_theme_mod('si_' . $page_id . '_bg');
    $bg_opacity = get_theme_mod('si_' . $page_id . '_bg_opacity', '0.6');
    $style = '';
    
    if ($bg_image_id) {
        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');
        if ($bg_image_url) {
            $style = sprintf(
                'style="background-image: url(%s); --overlay-opacity: %s;"',
                esc_url($bg_image_url),
                esc_attr($bg_opacity)
            );
        }
    }
    
    return $style;
}

function si_get_menu_card_style($menu_type) {
    $image_id = get_theme_mod('menu_card_' . $menu_type . '_image');
    if ($image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            return sprintf('background-image: url("%s");', esc_url($image_url));
        }
    }
    return '';
}

function si_menu_card_image($menu_type) {
    $image_id = get_theme_mod('menu_card_' . $menu_type . '_image');
    if ($image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            return sprintf('<img src="%s" alt="%s Menu" class="menu-image">', esc_url($image_url), esc_attr(ucfirst($menu_type)));
        }
    }
    return '';
}

/**
 * Add customizer settings for Reservations page
 */
function si_reservations_customizer_settings($wp_customize) {
    // Add Reservations Page Section
    $wp_customize->add_section('si_reservations_section', array(
        'title'    => __('Reservations Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Background Image
    $wp_customize->add_setting('si_reservations_header_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_reservations_header_image', array(
        'label'    => __('Header Background Image', 'sports-illustrated'),
        'section'  => 'si_reservations_section',
        'mime_type' => 'image',
    )));

    // Title
    $wp_customize->add_setting('si_reservations_title', array(
        'default'           => __('Make a Reservation', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_reservations_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_reservations_section',
        'type'     => 'text',
    ));

    // Description
    $wp_customize->add_setting('si_reservations_description', array(
        'default'           => __('Book your table at Sports Illustrated Clubhouse for an unforgettable dining experience.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_reservations_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'section'  => 'si_reservations_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'si_reservations_customizer_settings');

/**
 * Add customizer settings for Gift Cards page
 */
function si_gift_cards_customizer_settings($wp_customize) {
    // Add Gift Cards Page Section
    $wp_customize->add_section('si_gift_cards_section', array(
        'title'    => __('Gift Cards Page Settings', 'sports-illustrated'),
        'description' => __('Configure the appearance and content of the Gift Cards page.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Background Image
    $wp_customize->add_setting('si_gift_cards_header_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gift_cards_header_image', array(
        'label'    => __('Header Background Image', 'sports-illustrated'),
        'description' => __('Select a background image for the Gift Cards page header.', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'mime_type' => 'image',
    )));

    // Title
    $wp_customize->add_setting('si_gift_cards_title', array(
        'default'           => __('Gift Cards', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'description' => __('Enter the main heading for the Gift Cards page.', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'text',
    ));

    // Description
    $wp_customize->add_setting('si_gift_cards_description', array(
        'default'           => __('Give the gift of an unforgettable dining experience.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_gift_cards_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'description' => __('Enter the descriptive text that appears below the title.', 'sports-illustrated'),
        'section'  => 'si_gift_cards_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'si_gift_cards_customizer_settings');

function si_catering_page_customizer($wp_customize) {
    // Add Catering Page Section
    $wp_customize->add_section('si_catering_page_section', array(
        'title'    => __('Catering Page Settings', 'sports-illustrated'),
        'description' => __('Configure the catering page appearance and content.', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Background Image
    $wp_customize->add_setting('si_catering_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_catering_bg', array(
        'label'    => __('Background Image', 'sports-illustrated'),
        'description' => __('Select an image for the catering page background.', 'sports-illustrated'),
        'section'  => 'si_catering_page_section',
        'mime_type' => 'image',
    )));

    // Background Overlay Opacity
    $wp_customize->add_setting('si_catering_bg_opacity', array(
        'default'           => '0.6',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_bg_opacity', array(
        'label'    => __('Background Overlay Opacity', 'sports-illustrated'),
        'description' => __('Select the opacity level for the background overlay.', 'sports-illustrated'),
        'section'  => 'si_catering_page_section',
        'type'     => 'select',
        'choices'  => array(
            '0.3' => '30%',
            '0.4' => '40%',
            '0.5' => '50%',
            '0.6' => '60%',
            '0.7' => '70%',
            '0.8' => '80%',
        ),
    ));

    // Catering Page Image
    $wp_customize->add_setting('si_catering_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_catering_image', array(
        'label'     => __('Catering Page Image', 'sports-illustrated'),
        'description' => __('Select a featured image to display on the catering page.', 'sports-illustrated'),
        'section'   => 'si_catering_page_section',
        'mime_type' => 'image',
    )));

    // Title
    $wp_customize->add_setting('si_catering_title', array(
        'default'           => __('CATERING & EVENTS', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_title', array(
        'label'    => __('Page Title', 'sports-illustrated'),
        'section'  => 'si_catering_page_section',
        'type'     => 'text',
    ));

    // Description
    $wp_customize->add_setting('si_catering_description', array(
        'default'           => __('Let us cater your next event with our delicious menu options. Fill out the form below to get started.', 'sports-illustrated'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_description', array(
        'label'    => __('Page Description', 'sports-illustrated'),
        'section'  => 'si_catering_page_section',
        'type'     => 'textarea',
    ));

    // Contact Form 7 ID
    $wp_customize->add_setting('si_catering_form_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('si_catering_form_id', array(
        'label'       => __('Contact Form 7 ID', 'sports-illustrated'),
        'description' => __('Enter the ID of the Contact Form 7 form to display on this page.', 'sports-illustrated'),
        'section'     => 'si_catering_page_section',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'si_catering_page_customizer');

function si_scripts() {
    // ... existing enqueues ...

    // Enqueue loading screen script
    wp_enqueue_script(
        'si-loading-screen',
        get_template_directory_uri() . '/assets/js/loading-screen.js',
        array(),
        SI_VERSION,
        true
    );

    // Enqueue animations script
    wp_enqueue_script(
        'si-animations',
        get_template_directory_uri() . '/assets/js/animations.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // ... existing code ...
}
add_action('wp_enqueue_scripts', 'si_scripts');

/**
 * Add customizer settings for header navigation
 */
function si_header_navigation_customizer($wp_customize) {
    // Add Header Navigation Section
    $wp_customize->add_section('si_header_navigation', array(
        'title'    => __('Header Navigation', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Left Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_left_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_left_menu_text_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'text',
        ));

        // Item URL
        $wp_customize->add_setting('si_left_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_left_menu_url_' . $i, array(
            'label'    => sprintf(__('Left Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'url',
        ));

        // Item Visibility
        $wp_customize->add_setting('si_left_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_left_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Left Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'checkbox',
        ));
    }

    // Right Menu Items (up to 3)
    for ($i = 1; $i <= 3; $i++) {
        // Item Text
        $wp_customize->add_setting('si_right_menu_text_' . $i, array(
            'default'           => $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('si_right_menu_text_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d Text', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'text',
        ));

        // Item URL
        $wp_customize->add_setting('si_right_menu_url_' . $i, array(
            'default'           => $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')),
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('si_right_menu_url_' . $i, array(
            'label'    => sprintf(__('Right Menu Item %d URL', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'url',
        ));

        // Item Visibility
        $wp_customize->add_setting('si_right_menu_visible_' . $i, array(
            'default'           => $i <= 3 ? true : false,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('si_right_menu_visible_' . $i, array(
            'label'    => sprintf(__('Show Right Menu Item %d', 'sports-illustrated'), $i),
            'section'  => 'si_header_navigation',
            'type'     => 'checkbox',
        ));
    }

    // Menu Dropdown Settings
    $wp_customize->add_setting('si_enable_menu_dropdown', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));

    $wp_customize->add_control('si_enable_menu_dropdown', array(
        'label'    => __('Enable Menu Dropdown', 'sports-illustrated'),
        'section'  => 'si_header_navigation',
        'type'     => 'checkbox',
    ));
}
add_action('customize_register', 'si_header_navigation_customizer');

// Helper function to sanitize boolean values
if (!function_exists('rest_sanitize_boolean')) {
    function rest_sanitize_boolean($value) {
        return $value === true || $value === 'true' || $value === '1' || $value === 1 ? true : false;
    }
} 