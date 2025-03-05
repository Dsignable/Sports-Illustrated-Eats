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

    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Navigation script
    wp_enqueue_script(
        'sports-illustrated-navigation',
        get_theme_file_uri('assets/js/navigation.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    // Add debug information
    wp_localize_script('sports-illustrated-navigation', 'siDebug', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'themeUrl' => get_template_directory_uri(),
        'debug' => WP_DEBUG
    ));

    // Re-enable other scripts
    wp_enqueue_script(
        'sports-illustrated-scroll-animations',
        get_theme_file_uri('assets/js/scroll-animations.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    wp_enqueue_script(
        'sports-illustrated-menu',
        get_theme_file_uri('assets/js/menu.js'),
        array('jquery'),
        SI_VERSION . '.' . time(),
        true
    );

    // Add inline script for debugging
    wp_add_inline_script('sports-illustrated-navigation', 'console.log("Navigation script loaded", siDebug);', 'before');
}
add_action('wp_enqueue_scripts', 'sports_illustrated_enqueue_assets', 100);

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
    // Add Menu PDFs section
    $wp_customize->add_section('si_menu_pdfs', array(
        'title'    => __('Menu PDFs', 'sports-illustrated'),
        'priority' => 30,
    ));

    // Full Menu PDF
    $wp_customize->add_setting('si_menu_full', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_full', array(
        'label'         => __('Full Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Happy Hour Menu PDF
    $wp_customize->add_setting('si_menu_happy', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_happy', array(
        'label'         => __('Happy Hour Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Drink Menu PDF
    $wp_customize->add_setting('si_menu_drink', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_drink', array(
        'label'         => __('Drink Menu PDF', 'sports-illustrated'),
        'section'       => 'si_menu_pdfs',
        'mime_type'     => 'application/pdf',
        'button_labels' => array(
            'select'       => __('Select PDF'),
            'change'       => __('Change PDF'),
            'remove'       => __('Remove'),
            'default'      => __('Default'),
            'placeholder'  => __('No PDF selected'),
            'frame_title'  => __('Select PDF'),
            'frame_button' => __('Choose PDF'),
        ),
    )));

    // Daily Menu PDFs
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    foreach ($days as $day) {
        $wp_customize->add_setting('si_menu_' . $day, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh'
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_' . $day, array(
            'label'         => sprintf(__('%s Menu PDF', 'sports-illustrated'), ucfirst($day)),
            'section'       => 'si_menu_pdfs',
            'mime_type'     => 'application/pdf',
            'button_labels' => array(
                'select'       => __('Select PDF'),
                'change'       => __('Change PDF'),
                'remove'       => __('Remove'),
                'default'      => __('Default'),
                'placeholder'  => __('No PDF selected'),
                'frame_title'  => __('Select PDF'),
                'frame_button' => __('Choose PDF'),
            ),
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

    // Menu Section Images
    $image_settings = array(
        'happy_hour' => 'Happy Hour Menu',
        'fan_favorites' => 'Fan Favorites Menu',
        'drinks_cocktails' => 'Drinks & Cocktails Menu',
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