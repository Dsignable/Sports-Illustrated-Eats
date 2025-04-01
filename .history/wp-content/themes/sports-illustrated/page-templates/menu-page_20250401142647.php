<?php
/**
 * Template Name: Menu Page
 */

get_header();
?>

<div class="menu-gallery-section">
    <div class="menu-gallery-slider">
        <?php
        $gallery_images = get_theme_mod('si_menu_gallery_images', array());
        if (!empty($gallery_images)) {
            foreach ($gallery_images as $image) {
                echo '<div class="gallery-slide">';
                echo wp_get_attachment_image($image, 'full');
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<div class="menu-page-container" style="background-color: #000;">
    <div class="menu-buttons-container">
        <?php
        // ... existing menu buttons code ...
        ?>
    </div>

    <div class="menu-content-container" style="background-color: #000;">
        <?php
        // ... existing menu content code ...
        ?>
    </div>
</div>

<style>
.menu-gallery-section {
    width: 100vw;
    height: 400px;
    margin-bottom: 40px;
    overflow: hidden;
}

.menu-gallery-slider {
    width: 100%;
    height: 100%;
}

.gallery-slide {
    width: 100%;
    height: 100%;
}

.gallery-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.menu-page-container {
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    padding: 40px 0;
}

.menu-content-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Add Slick Slider styles */
.slick-slider {
    width: 100%;
    height: 100%;
}

.slick-slide {
    width: 100%;
    height: 100%;
}
</style>

<script>
jQuery(document).ready(function($) {
    $('.menu-gallery-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false
    });
});
</script>

<?php
get_footer(); 