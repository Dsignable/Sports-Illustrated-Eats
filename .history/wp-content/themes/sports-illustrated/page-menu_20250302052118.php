<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background image if set
$bg_image_id = get_theme_mod('si_menu_bg');
$bg_style = '';
if ($bg_image_id) {
    $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');
    if ($bg_image_url) {
        $bg_style = 'style="background-image: url(' . esc_url($bg_image_url) . ');"';
    }
}
?>

<main id="primary" class="site-main menu-page" <?php echo $bg_style; ?>>
    <div class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn" data-menu="full"><?php esc_html_e('Full Menu', 'sports-illustrated'); ?></button>
            <button class="menu-btn" data-menu="happy"><?php esc_html_e('Happy Hour', 'sports-illustrated'); ?></button>
            <button class="menu-btn" data-menu="drink"><?php esc_html_e('Drinks & Cocktails', 'sports-illustrated'); ?></button>
            <button class="menu-btn" data-menu="brunch"><?php esc_html_e('Brunch Menu', 'sports-illustrated'); ?></button>
            <button class="menu-btn" data-menu="burger"><?php esc_html_e('Burger Menu', 'sports-illustrated'); ?></button>
        </div>

        <div class="image-section">
            <div class="image-wrapper">
                <?php
                // Get menu images from customizer settings
                $menu_types = array('full', 'happy', 'drink', 'brunch', 'burger');
                foreach ($menu_types as $type) {
                    $menu_image = get_theme_mod('si_menu_' . $type . '_image');
                    if ($menu_image) {
                        $image_url = wp_get_attachment_image_url($menu_image, 'full');
                        if ($image_url) {
                            printf(
                                '<img src="%s" alt="%s" class="menu-image" data-menu="%s" %s />',
                                esc_url($image_url),
                                esc_attr(ucfirst($type) . ' Menu'),
                                esc_attr($type),
                                $type === 'full' ? 'style="opacity: 1;"' : ''
                            );
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php
// Enqueue menu script
wp_enqueue_script(
    'si-menu-page',
    get_theme_file_uri('/assets/js/menu.js'),
    array('jquery'),
    SI_VERSION,
    true
);

get_footer();
?> 