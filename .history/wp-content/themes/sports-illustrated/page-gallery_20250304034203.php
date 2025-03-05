<?php
/**
 * Template Name: Gallery Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get gallery images from customizer
$gallery_images = get_theme_mod('si_gallery_images', '');
$gallery_images_array = is_array($gallery_images) ? $gallery_images : array_filter(explode(',', $gallery_images));
?>

<main id="primary" class="site-main gallery-page">
    <div class="gallery-container">
        <?php if (!empty($gallery_images_array)) : ?>
            <?php foreach ($gallery_images_array as $image_id) : ?>
                <?php 
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                if ($image_url) :
                ?>
                    <div class="gallery-item">
                        <a href="<?php echo esc_url($image_url); ?>" class="gallery-link">
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr($image_alt); ?>" 
                                 class="gallery-image">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-images">
                <p><?php esc_html_e('No gallery images found. Please add images through the customizer.', 'sports-illustrated'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 