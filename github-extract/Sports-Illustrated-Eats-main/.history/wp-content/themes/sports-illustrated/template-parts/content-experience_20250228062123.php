<?php
/**
 * Template part for displaying the experience section
 *
 * @package Sports_Illustrated
 */
?>

<article class="experience-card">
    <div class="content-wrapper">
        <h2 class="experience-title">EXPERIENCE THE GAME</h2>
        <p class="experience-description">Step into the ultimate sports viewing destination at Sports Illustrated Clubhouse. Our state-of-the-art facility combines premium sports entertainment with exceptional dining, creating an unmatched atmosphere for fans and food lovers alike.</p>
        
        <div class="experience-images">
            <?php if ($image_url = si_get_image_url('si_image_experience_bg')): ?>
                <div class="experience-image">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Sports Illustrated Experience', 'sports-illustrated'); ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>" class="gallery-button">
            <?php esc_html_e('VIEW GALLERY', 'sports-illustrated'); ?>
        </a>
    </div>
</article> 