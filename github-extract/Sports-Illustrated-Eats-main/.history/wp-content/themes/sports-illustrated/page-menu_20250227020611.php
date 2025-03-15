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
                <img src="<?php echo esc_url(get_theme_mod('si_menu_full', get_theme_file_uri('assets/images/menus/default-menu.jpg'))); ?>" 
                     alt="Menu background" 
                     class="menu-image active" 
                     data-menu="full" />
                <img src="<?php echo esc_url(get_theme_mod('si_menu_happy', get_theme_file_uri('assets/images/menus/happy-hour.jpg'))); ?>" 
                     alt="Happy Hour Menu" 
                     class="menu-image" 
                     data-menu="happy" />
                <img src="<?php echo esc_url(get_theme_mod('si_menu_drink', get_theme_file_uri('assets/images/menus/drinks.jpg'))); ?>" 
                     alt="Drink Menu" 
                     class="menu-image" 
                     data-menu="drink" />
                <img src="<?php 
                    $today = strtolower(date('l'));
                    echo esc_url(get_theme_mod('si_menu_' . $today, get_theme_file_uri('assets/images/menus/' . $today . '.jpg'))); 
                    ?>" 
                     alt="Today's Menu" 
                     class="menu-image" 
                     data-menu="today" />
            </div>
        </section>
    </nav>
</main>

<?php
get_footer(); 