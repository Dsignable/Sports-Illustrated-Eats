<?php
/**
 * Template Name: Gallery Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get gallery images from customizer
$gallery_images = get_theme_mod('si_gallery_images', '');
$gallery_images = is_array($gallery_images) ? $gallery_images : array_filter(explode(',', $gallery_images));
?>

<main id="primary" class="site-main gallery-page">
    <div class="gallery-container">
        <?php if (!empty($gallery_images)) : ?>
            <?php foreach ($gallery_images as $image_id) : ?>
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
            <?php
            // Default gallery images from theme-images directory
            $default_image_dirs = array(
                'wp-content/uploads/theme-images/F&B',
                'wp-content/uploads/theme-images/Interior_Exterior',
                'wp-content/uploads/theme-images/Lifestyle'
            );
            
            $default_images = array();
            foreach ($default_image_dirs as $dir) {
                if (is_dir(ABSPATH . $dir)) {
                    $files = glob(ABSPATH . $dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    foreach ($files as $file) {
                        $default_images[] = str_replace(ABSPATH, '', $file);
                    }
                }
            }
            
            // Limit to 20 images to prevent overwhelming the page
            $default_images = array_slice($default_images, 0, 20);
            
            if (!empty($default_images)) :
                foreach ($default_images as $image) :
            ?>
                <div class="gallery-item">
                    <a href="<?php echo esc_url(site_url($image)); ?>" class="gallery-link">
                        <img src="<?php echo esc_url(site_url($image)); ?>" 
                             alt="<?php echo esc_attr(basename($image)); ?>" 
                             class="gallery-image">
                    </a>
                </div>
            <?php 
                endforeach;
            else :
            ?>
                <div class="no-images">
                    <p><?php esc_html_e('No gallery images found. Please add images through the customizer.', 'sports-illustrated'); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 