<?php
/**
 * Template Name: Menu Page
 */

get_header();
?>

<div class="menu-gallery-container">
    <?php
    $gallery_images = get_theme_mod('si_menu_gallery', '');
    if (!empty($gallery_images)) {
        $images = explode(',', $gallery_images);
        ?>
        <div class="menu-gallery-slider">
            <?php foreach ($images as $image_id) : ?>
                <div class="gallery-slide">
                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } ?>
</div>

<div class="menu-container">
    <div class="menu-buttons">
        <?php
        // ... existing menu buttons code ...
        ?>
    </div>

    <div class="menu-content">
        <?php
        // ... existing menu content code ...
        ?>
    </div>
</div>

<?php get_footer(); ?> 