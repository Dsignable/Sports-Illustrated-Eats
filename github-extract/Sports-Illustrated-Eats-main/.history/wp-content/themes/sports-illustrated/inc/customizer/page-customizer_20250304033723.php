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
                var control = this;
                var galleryFrame;
                
                $('.upload-button').on('click', function(e) {
                    e.preventDefault();
                    
                    if (galleryFrame) {
                        galleryFrame.open();
                        return;
                    }
                    
                    galleryFrame = wp.media({
                        title: '<?php esc_html_e('Select Gallery Images', 'sports-illustrated'); ?>',
                        button: {
                            text: '<?php esc_html_e('Add to Gallery', 'sports-illustrated'); ?>'
                        },
                        multiple: true
                    });
                    
                    galleryFrame.on('select', function() {
                        var attachments = galleryFrame.state().get('selection').map(function(attachment) {
                            attachment = attachment.toJSON();
                            return attachment.id;
                        });
                        
                        var input = $('.gallery-input');
                        input.val(attachments.join(',')).trigger('change');
                        
                        var count = attachments.length;
                        $('.gallery-count').text(count + ' ' + (count === 1 ? 'image' : 'images') + ' selected');
                    });
                    
                    galleryFrame.open();
                });
                
                // Update initial count
                var initialValue = $('.gallery-input').val();
                if (initialValue) {
                    var count = initialValue.split(',').length;
                    $('.gallery-count').text(count + ' ' + (count === 1 ? 'image' : 'images') + ' selected');
                }
            });
            </script>
            <?php
        }
    }
}

function si_page_customizer_settings($wp_customize) {
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

    // Gift Cards Page Settings
    $wp_customize->add_section('si_gift_cards_settings', array(
        'title'    => __('Gift Cards Page Settings', 'sports-illustrated'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('si_gift_cards_bg', array(
        'default'           => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'si_gift_cards_bg', array(
        'label'     => __('Background Image', 'sports-illustrated'),
        'section'   => 'si_gift_cards_settings',
        'mime_type' => 'image',
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