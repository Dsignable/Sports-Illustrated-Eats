<?php
/**
 * Page Customizer Settings
 *
 * @package Sports_Illustrated
 */

// Add Gallery Control Class
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

function si_page_customizer_settings($wp_customize) {
    // Add Homepage Background Section if it doesn't exist
    if (!$wp_customize->get_section('si_background_settings')) {
        $wp_customize->add_section('si_background_settings', array(
            'title'    => __('Homepage Background', 'sports-illustrated'),
            'priority' => 30,
        ));
    }

    // Background Type
    $wp_customize->add_setting('si_background_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('si_background_type', array(
        'label'    => __('Background Type', 'sports-illustrated'),
        'section'  => 'si_background_settings',
        'type'     => 'select',
        'choices'  => array(
            'image' => __('Image', 'sports-illustrated'),
            'video' => __('Video', 'sports-illustrated'),
        ),
    ));

    // Background Image
    $wp_customize->add_setting('si_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_background_image', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_background_settings',
        'mime_type' => 'image',
    )));

    // Background Video URL
    $wp_customize->add_setting('si_background_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('si_background_video', array(
        'label'       => __('Background Video URL', 'sports-illustrated'),
        'description' => __('Enter a video URL or upload a video file below', 'sports-illustrated'),
        'section'     => 'si_background_settings',
        'type'        => 'url',
    ));

    // Background Video File Upload
    $wp_customize->add_setting('si_background_video_file', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_background_video_file', array(
        'label'       => __('Upload Background Video', 'sports-illustrated'),
        'description' => __('Upload an MP4 video file', 'sports-illustrated'),
        'section'     => 'si_background_settings',
        'mime_type'   => 'video',
    )));

    // Loading Screen Settings
    $wp_customize->add_section('si_loading_screen_settings', array(
        'title'    => __('Loading Screen Settings', 'sports-illustrated'),
        'priority' => 20,
    ));

    // Enable Loading Screen
    $wp_customize->add_setting('si_enable_loading_screen', array(
        'default'           => true,
        'sanitize_callback' => 'si_sanitize_checkbox'
    ));

    $wp_customize->add_control('si_enable_loading_screen', array(
        'label'    => __('Enable Loading Screen', 'sports-illustrated'),
        'section'  => 'si_loading_screen_settings',
        'type'     => 'checkbox',
    ));

    // Loading Screen Duration
    $wp_customize->add_setting('si_loading_screen_duration', array(
        'default'           => 3000,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('si_loading_screen_duration', array(
        'label'    => __('Loading Screen Duration (milliseconds)', 'sports-illustrated'),
        'section'  => 'si_loading_screen_settings',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 10000,
            'step' => 500,
        ),
    ));

    // Gallery Settings
    $wp_customize->add_section('si_gallery_settings', array(
        'title'    => __('Gallery Settings', 'sports-illustrated'),
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
        'section'  => 'si_gallery_settings',
        'settings' => 'si_gallery_images',
    )));

    // News Page Settings
    $wp_customize->add_section('si_news_settings', array(
        'title'    => __('News Page Settings', 'sports-illustrated'),
        'priority' => 31,
    ));

    $wp_customize->add_setting('si_news_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_news_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_news_settings',
        'mime_type' => 'image',
    )));

    // Careers Page Settings
    $wp_customize->add_section('si_careers_settings', array(
        'title'    => __('Careers Page Settings', 'sports-illustrated'),
        'priority' => 32,
    ));

    $wp_customize->add_setting('si_careers_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_careers_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_careers_settings',
        'mime_type' => 'image',
    )));

    // Menu Page Settings
    $wp_customize->add_section('si_menu_settings', array(
        'title'    => __('Menu Page Settings', 'sports-illustrated'),
        'priority' => 33,
    ));

    $wp_customize->add_setting('si_menu_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_menu_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_menu_settings',
        'mime_type' => 'image',
    )));

    // Gallery Page Settings
    $wp_customize->add_section('si_gallery_settings', array(
        'title'    => __('Gallery Page Settings', 'sports-illustrated'),
        'priority' => 34,
    ));

    $wp_customize->add_setting('si_gallery_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gallery_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_gallery_settings',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'si_page_customizer_settings');

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

// Add sanitize callback for checkbox
function si_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
} 