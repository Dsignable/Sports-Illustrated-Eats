<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<div class="menu-page-container">
    <?php
    // Get gallery images
    $gallery_images = get_theme_mod('si_menu_gallery_images', '');
    if (!empty($gallery_images)) :
    ?>
        <div class="menu-gallery-container">
            <div class="menu-gallery">
                <!-- Gallery slides will be inserted here via JavaScript -->
            </div>
        </div>
    <?php endif; ?>

    <div class="menu-content">
        <div class="menu-buttons">
            <?php
            $menu_types = array(
                'full'   => 'Full Menu',
                'drink'  => 'Drink Menu',
                'brunch' => 'Brunch Menu',
                'happy'  => 'Happy Hour Menu',
            );

            foreach ($menu_types as $type => $label) :
                $menu_image = get_theme_mod("si_menu_{$type}_image", '');
                if (!empty($menu_image)) :
            ?>
                    <button class="menu-button" data-menu="<?php echo esc_attr($type); ?>">
                        <?php echo esc_html($label); ?>
                    </button>
            <?php
                endif;
            endforeach;
            ?>
        </div>

        <?php
        foreach ($menu_types as $type => $label) :
            $menu_image = get_theme_mod("si_menu_{$type}_image", '');
            if (!empty($menu_image)) :
                $image_url = wp_get_attachment_image_url($menu_image, 'full');
        ?>
                <div class="menu-image-container" id="menu-<?php echo esc_attr($type); ?>" style="display: none;">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($label); ?>" class="menu-image">
                </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>
</div>

<?php
get_footer();
?> 