<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main menu-page">
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu active" data-menu="full">FULL MENU</button>
            <button class="menu-btn happy-hour" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn drink-menu" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn todays-menu" data-menu="today">TODAY'S MENU</button>
        </div>
        <section class="image-section">
            <div class="image-wrapper">
                <img src="<?php echo esc_url(si_get_image_url('si_menu_full_image', get_theme_file_uri('assets/images/menus/full-menu.jpg'))); ?>" 
                     class="menu-image active" 
                     data-menu="full"
                     alt="Full Menu">
                <img src="<?php echo esc_url(si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'))); ?>" 
                     class="menu-image" 
                     data-menu="happy"
                     alt="Happy Hour Menu">
                <img src="<?php echo esc_url(si_get_image_url('si_menu_drink_image', get_theme_file_uri('assets/images/menus/drink-menu.jpg'))); ?>" 
                     class="menu-image" 
                     data-menu="drink"
                     alt="Drink Menu">
                <img src="<?php 
                    $today = strtolower(date('l'));
                    echo esc_url(si_get_image_url('si_menu_' . $today . '_image')); 
                    ?>" 
                     class="menu-image" 
                     data-menu="today"
                     alt="Today's Menu">
            </div>
        </section>
    </nav>
</main>

<?php get_footer(); ?> 