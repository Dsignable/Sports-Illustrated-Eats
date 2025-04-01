<?php
/**
 * Sports Illustrated theme functions and definitions
 *
 * @package Sports_Illustrated
 */

// Include the navigation bar settings
require_once get_template_directory() . '/inc/navigation-bar-settings.php';

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

// Include modular theme functions
require_once get_template_directory() . '/inc/theme-functions.php';

// Include customizer settings
require_once get_template_directory() . '/inc/customizer/customizer.php';

// Include widgets
require_once get_template_directory() . '/inc/widgets.php';

// Include reset drinks menu script if it exists
$reset_drinks_menu = get_template_directory() . '/reset-drinks-menu.php';
if (file_exists($reset_drinks_menu)) {
    require_once $reset_drinks_menu;
}

// Include menu diagnostics script if it exists
$menu_diagnostics = get_template_directory() . '/menu-diagnostics.php';
if (file_exists($menu_diagnostics)) {
    require_once $menu_diagnostics;
}

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
 * Add featured image column to posts admin screen
 */
function si_add_thumbnail_column($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns[$key] = $value;
            $new_columns['thumbnail'] = __('Featured Image', 'sports-illustrated');
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_posts_columns', 'si_add_thumbnail_column');
add_filter('manage_pages_columns', 'si_add_thumbnail_column');

/**
 * Display featured image in the posts admin column
 */
function si_display_thumbnail_column($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            $thumbnail_id = get_post_thumbnail_id($post_id);
            $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
            echo '<img src="' . esc_url($thumbnail[0]) . '" alt="' . esc_attr(get_the_title($post_id)) . '" />';
        } else {
            echo '<div class="no-thumbnail"></div>';
        }
    }
}
add_action('manage_posts_custom_column', 'si_display_thumbnail_column', 10, 2);
add_action('manage_pages_custom_column', 'si_display_thumbnail_column', 10, 2);

/**
 * Add admin notice for posts without featured images
 */
function si_check_featured_image_admin_notice() {
    global $pagenow, $post;
    
    // Only show on post edit screen for posts
    if ($pagenow === 'post.php' && get_post_type($post) === 'post' && !has_post_thumbnail($post->ID)) {
        ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php _e('Featured Image Missing:', 'sports-illustrated'); ?></strong> 
                <?php _e('This post does not have a featured image set. Featured images are displayed on the News page and improve the visual appeal of your content.', 'sports-illustrated'); ?>
                <a href="#postimagediv"><?php _e('Set Featured Image', 'sports-illustrated'); ?></a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'si_check_featured_image_admin_notice');

/**
 * Make featured image metabox more prominent
 */
function si_featured_image_style() {
    global $post_type;
    
    if ($post_type === 'post') {
        ?>
        <style type="text/css">
            #postimagediv {
                background-color: #f8f8f8;
                border-left: 4px solid #0073aa;
                padding: 10px;
                margin-bottom: 20px;
            }
            #postimagediv .hndle {
                font-size: 16px;
                color: #0073aa;
            }
            #postimagediv .inside {
                padding: 10px;
            }
            #postimagediv #set-post-thumbnail {
                display: inline-block;
                padding: 8px 12px;
                background: #0073aa;
                color: #fff;
                text-decoration: none;
                border-radius: 3px;
                margin: 10px 0;
            }
            #postimagediv #set-post-thumbnail:hover {
                background: #005d87;
            }
        </style>
        <?php
    }
}
add_action('admin_head-post.php', 'si_featured_image_style');
add_action('admin_head-post-new.php', 'si_featured_image_style');

/**
 * Register widget area
 * Note: This function has been moved to inc/widgets.php
 */
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
 * Include customizer settings
 */
// require get_template_directory() . '/inc/customizer/page-customizer.php';

/**
 * Home Page Customizer Settings
 * Note: This function has been moved to inc/customizer/home-page.php
 */

// Remove the old menu cards customizer function since we're moving it to the Home Page section

/**
 * Add Home Page customizer settings
 */
add_action('customize_register', 'si_home_page_customizer_settings');

function si_scripts() {
    wp_enqueue_style('si-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('si-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);

    // Enqueue menu page styles
    if (is_page('menu')) {
        wp_enqueue_style('si-menu-page', get_template_directory_uri() . '/assets/css/menu-page.css', array(), '1.0.0');
        
        // Get gallery images
        $gallery_images = get_theme_mod('si_menu_gallery_images', '');
        $gallery_speed = get_theme_mod('si_menu_gallery_speed', 5000);
        
        if (!empty($gallery_images)) {
            $image_ids = explode(',', $gallery_images);
            $images = array();
            
            foreach ($image_ids as $id) {
                $image_url = wp_get_attachment_image_url($id, 'full');
                if ($image_url) {
                    $images[] = $image_url;
                }
            }
            
            wp_localize_script('si-scripts', 'siMenuGallery', array(
                'images' => $images,
                'speed' => $gallery_speed
            ));
            
            // Add gallery initialization script
            wp_add_inline_script('si-scripts', '
                document.addEventListener("DOMContentLoaded", function() {
                    if (typeof siMenuGallery !== "undefined" && siMenuGallery.images.length > 0) {
                        let currentSlide = 0;
                        const galleryContainer = document.querySelector(".menu-gallery");
                        
                        // Create slides
                        siMenuGallery.images.forEach((image, index) => {
                            const slide = document.createElement("div");
                            slide.className = "menu-gallery-slide" + (index === 0 ? " active" : "");
                            slide.style.backgroundImage = `url(${image})`;
                            galleryContainer.appendChild(slide);
                        });
                        
                        const slides = galleryContainer.querySelectorAll(".menu-gallery-slide");
                        
                        // Rotate slides
                        setInterval(() => {
                            slides[currentSlide].classList.remove("active");
                            currentSlide = (currentSlide + 1) % slides.length;
                            slides[currentSlide].classList.add("active");
                        }, siMenuGallery.speed);
                    }
                });
            ');
        }
    }

    // Loading screen script
    wp_enqueue_script(
        'sports-illustrated-loading-screen',
        get_theme_file_uri('/assets/js/loading-screen.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Header script
    wp_enqueue_script(
        'sports-illustrated-header',
        get_theme_file_uri('/assets/js/header.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Animations script
    wp_enqueue_script(
        'sports-illustrated-animations',
        get_theme_file_uri('/assets/js/animations.js'),
        array('jquery'),
        SI_VERSION,
        true
    );

    // Menu pages script
    wp_enqueue_script(
        'sports-illustrated-menu-pages',
        get_theme_file_uri('/assets/js/menu-pages.js'),
        array('jquery'),
        SI_VERSION,
        true
    );
    
    // Customizer script - only load in customizer preview
    if (is_customize_preview()) {
        wp_enqueue_script(
            'sports-illustrated-customizer',
            get_theme_file_uri('/assets/js/customizer.js'),
            array('jquery', 'customize-preview'),
            SI_VERSION,
            true
        );
    }

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Main stylesheet
    wp_enqueue_style(
        'sports-illustrated-style',
        get_theme_file_uri('/assets/css/main.css'),
        array(),
        SI_VERSION
    );

    // Responsive fixes
    wp_enqueue_style(
        'sports-illustrated-responsive',
        get_theme_file_uri('/assets/css/responsive.css'),
        array(),
        SI_VERSION
    );

    // Menu styles
    wp_enqueue_style(
        'sports-illustrated-menu',
        get_theme_file_uri('/assets/css/menu.css'),
        array(),
        SI_VERSION
    );
    
    // Enqueue mobile menu styles
    wp_enqueue_style('si-mobile-menu', get_template_directory_uri() . '/assets/css/mobile-menu.css', array(), '1.0.0');
}

/**
 * Add Gallery Page Customizer Settings
 */
function si_gallery_page_customizer($wp_customize) {
    // Add Gallery Page Section
    $wp_customize->add_section('si_gallery_page_section', array(
        'title'    => __('Gallery Page Settings', 'sports-illustrated'),
        'description' => __('Configure content for the gallery page.', 'sports-illustrated'),
        'priority' => 35,
    ));

    // Gallery Images
    $wp_customize->add_setting('si_gallery_images', array(
        'default'           => '',
        'sanitize_callback' => 'si_sanitize_gallery_images',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control(new SI_Gallery_Control($wp_customize, 'si_gallery_images', array(
        'label'    => __('Gallery Images', 'sports-illustrated'),
        'section'  => 'si_gallery_page_section',
        'settings' => 'si_gallery_images',
    )));

    // Gallery Background Image
    $wp_customize->add_setting('si_gallery_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gallery_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_gallery_page_section',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_gallery_page_customizer');

/**
 * Sanitize gallery images
 */
function si_sanitize_gallery_images($value) {
    if (empty($value)) {
        return '';
    }
    $image_ids = explode(',', $value);
    $sanitized = array_map('absint', $image_ids);
    return implode(',', $sanitized);
}

/**
 * Add Gallery Control Class
 */
if (class_exists('WP_Customize_Control')) {
    class SI_Gallery_Control extends WP_Customize_Control {
        public $type = 'gallery';

        public function render_content() {
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                
                <div class="gallery-status">
                    <span class="gallery-count"><?php esc_html_e('No images selected', 'sports-illustrated'); ?></span>
                </div>
                
                <div class="gallery-preview"></div>
                
                <input 
                    type="hidden" 
                    <?php $this->link(); ?> 
                    value="<?php echo esc_attr($this->value()); ?>" 
                    class="gallery-input" 
                />
                
                <button type="button" class="button upload-button">
                    <?php esc_html_e('Add/Edit Gallery', 'sports-illustrated'); ?>
                </button>
            </label>
            
            <script>
            jQuery(document).ready(function($) {
                var container = $('#customize-control-<?php echo esc_attr($this->id); ?>');
                var $input = container.find('.gallery-input');
                var $count = container.find('.gallery-count');
                var $preview = container.find('.gallery-preview');
                var galleryFrame;
                
                // Function to update preview
                function updatePreview(ids) {
                    if (!ids || ids.length === 0) {
                        $preview.empty();
                        return;
                    }
                    
                    wp.media.query({ post__in: ids.split(','), posts_per_page: -1 })
                        .more()
                        .then(function() {
                            var html = '';
                            ids.split(',').forEach(function(id) {
                                var attachment = wp.media.attachment(id);
                                if (attachment.get('url')) {
                                    html += '<img src="' + attachment.get('sizes').thumbnail.url + '" alt="" style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">';
                                }
                            });
                            $preview.html(html);
                        });
                }
                
                container.find('.upload-button').on('click', function(e) {
                    e.preventDefault();
                    
                    // If frame exists, open it
                    if (galleryFrame) {
                        galleryFrame.open();
                        return;
                    }
                    
                    // Create media frame
                    galleryFrame = wp.media({
                        frame: 'select',
                        title: '<?php esc_html_e('Select Gallery Images', 'sports-illustrated'); ?>',
                        button: {
                            text: '<?php esc_html_e('Add to Gallery', 'sports-illustrated'); ?>'
                        },
                        library: {
                            type: 'image'
                        },
                        multiple: 'add'
                    });
                    
                    // Set existing selection
                    galleryFrame.on('open', function() {
                        var selection = galleryFrame.state().get('selection');
                        var ids = $input.val();
                        
                        if (ids) {
                            ids.split(',').forEach(function(id) {
                                var attachment = wp.media.attachment(id);
                                attachment.fetch();
                                selection.add(attachment);
                            });
                        }
                    });
                    
                    // When images are selected
                    galleryFrame.on('select', function() {
                        var selection = galleryFrame.state().get('selection');
                        var imageIds = selection.map(function(attachment) {
                            attachment = attachment.toJSON();
                            return attachment.id;
                        });
                        
                        // Update input and trigger change
                        $input.val(imageIds.join(',')).trigger('change');
                        
                        // Update count display
                        var count = imageIds.length;
                        $count.text(count + ' ' + (count === 1 ? 'image' : 'images') + ' selected');
                        
                        // Update preview
                        updatePreview(imageIds.join(','));
                    });
                    
                    galleryFrame.open();
                });
                
                // Update initial count and preview
                var initialValue = $input.val();
                if (initialValue) {
                    var count = initialValue.split(',').length;
                    $count.text(count + ' ' + (count === 1 ? 'image' : 'images') + ' selected');
                    updatePreview(initialValue);
                }
            });
            </script>
            <style>
            #customize-control-<?php echo esc_attr($this->id); ?> .gallery-preview {
                margin: 10px 0;
                min-height: 50px;
                background: #f7f7f7;
                border: 1px solid #ddd;
                padding: 5px;
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            </style>
            <?php
        }
    }
}

/**
 * Add Menu Gallery customizer settings
 */
function si_menu_gallery_customizer($wp_customize) {
    // Add Menu Gallery Section
    $wp_customize->add_section('si_menu_gallery_section', array(
        'title'    => __('Menus Gallery Settings', 'sports-illustrated'),
        'description' => __('Configure the auto-rotating gallery above the menus.', 'sports-illustrated'),
        'priority' => 29,
    ));

    // Gallery Images Setting
    $wp_customize->add_setting('si_menu_gallery_images', array(
        'default'           => '',
        'sanitize_callback' => 'si_sanitize_gallery_images',
        'transport'         => 'refresh'
    ));

    // Gallery Control
    $wp_customize->add_control(new SI_Gallery_Control($wp_customize, 'si_menu_gallery_images', array(
        'label'    => __('Gallery Images', 'sports-illustrated'),
        'description' => __('Select images for the auto-rotating gallery.', 'sports-illustrated'),
        'section'  => 'si_menu_gallery_section',
        'settings' => 'si_menu_gallery_images',
    )));

    // Rotation Speed
    $wp_customize->add_setting('si_menu_gallery_speed', array(
        'default'           => 5000,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('si_menu_gallery_speed', array(
        'label'       => __('Rotation Speed (ms)', 'sports-illustrated'),
        'description' => __('Time in milliseconds between image transitions.', 'sports-illustrated'),
        'section'     => 'si_menu_gallery_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2000,
            'max'  => 10000,
            'step' => 500,
        ),
    ));
}
add_action('customize_register', 'si_menu_gallery_customizer');