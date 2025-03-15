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
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu active" data-menu="full">FULL MENU</button>
            <button class="menu-btn happy-hour" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn drink-menu" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn todays-menu" data-menu="today">TODAY'S MENU</button>
        </div>
        <section class="image-section">
            <div class="image-wrapper">
                <?php
                // Full Menu (visible by default)
                $full_menu_image = si_get_image_url('si_menu_full_image', get_theme_file_uri('assets/images/menus/full-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($full_menu_image); ?>" 
                     class="menu-image active" 
                     data-menu="full"
                     alt="Full Menu">

                <?php
                // Happy Hour Menu (hidden by default)
                $happy_hour_image = si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'));
                ?>
                <img src="<?php echo esc_url($happy_hour_image); ?>" 
                     class="menu-image" 
                     data-menu="happy"
                     alt="Happy Hour Menu"
                     style="display: none;">

                <?php
                // Drink Menu (hidden by default)
                $drink_menu_image = si_get_image_url('si_menu_drink_image', get_theme_file_uri('assets/images/menus/drink-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($drink_menu_image); ?>" 
                     class="menu-image" 
                     data-menu="drink"
                     alt="Drink Menu"
                     style="display: none;">

                <?php
                // Today's Menu (hidden by default)
                $today = strtolower(date('l'));
                $today_menu_image = si_get_image_url('si_menu_' . $today . '_image');
                if ($today_menu_image) :
                ?>
                <img src="<?php echo esc_url($today_menu_image); ?>" 
                     class="menu-image" 
                     data-menu="today"
                     alt="Today's Menu"
                     style="display: none;">
                <?php endif; ?>
            </div>
        </section>
    </nav>
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