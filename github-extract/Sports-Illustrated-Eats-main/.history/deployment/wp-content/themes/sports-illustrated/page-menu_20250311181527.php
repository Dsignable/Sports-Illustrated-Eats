<?php

/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('menu');
?>

<main id="primary" class="site-main menu-page" <?php echo $bg_style; ?>>
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu active" data-menu="full">FULL MENU</button>
            <button class="menu-btn happy-hour" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn drink-menu" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn brunch-menu" data-menu="brunch">BRUNCH MENU</button>
            <button class="menu-btn burger-menu" data-menu="burger">BURGER MENU</button>
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
                // Happy Hour Menu
                $happy_hour_image = si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'));
                ?>
                <img src="<?php echo esc_url($happy_hour_image); ?>"
                    class="menu-image"
                    data-menu="happy"
                    alt="Happy Hour Menu"
                    style="display: none;">

                <?php
                // Drink Menu
                $drink_menu_image = si_get_image_url('si_menu_drink_image', get_theme_file_uri('assets/images/menus/drink-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($drink_menu_image); ?>"
                    class="menu-image"
                    data-menu="drink"
                    alt="Drink Menu"
                    style="display: none;">

                <?php
                // Brunch Menu
                $brunch_menu_image = si_get_image_url('si_menu_brunch_image', get_theme_file_uri('assets/images/menus/brunch-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($brunch_menu_image); ?>"
                    class="menu-image"
                    data-menu="brunch"
                    alt="Brunch Menu"
                    style="display: none;">

                <?php
                // Burger Menu
                $burger_menu_image = si_get_image_url('si_menu_burger_image', get_theme_file_uri('assets/images/menus/burger-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($burger_menu_image); ?>"
                    class="menu-image"
                    data-menu="burger"
                    alt="Burger Menu"
                    style="display: none;">

                <?php
                // Today's Menu - Using switch statement for different days
                $today = strtolower(date('l')); // Gets current day of week
                $today_menu_image = '';

                switch ($today) {
                    case 'monday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Monday-Menu.jpg";
                        break;
                    case 'tuesday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Tuesday-Menu.jpg";
                        break;
                    case 'wednesday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Wednesday-Menu.jpg";
                        break;
                    case 'thursday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Thursday-Menu.jpg";
                        break;
                    case 'friday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Friday-Menu.jpg";
                        break;
                    case 'saturday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Saturday-Menu.jpg";
                        break;
                    case 'sunday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Sunday-Menu.jpg";
                        break;
                }

                if ($today_menu_image) : // Only show if we have an image for today
                ?>
                    <img src="<?php echo esc_url($today_menu_image); ?>"
                        class="menu-image"
                        data-menu="today"
                        alt="<?php echo ucfirst($today); ?>'s Menu"
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