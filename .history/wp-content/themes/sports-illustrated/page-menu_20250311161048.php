<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('menu');

// Get the menu type from URL parameter
$active_menu = isset($_GET['menu']) ? sanitize_key($_GET['menu']) : 'full';
$valid_menus = array('full', 'happy', 'drink', 'brunch', 'burger', 'today');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}
?>

<main id="primary" class="site-main menu-page" <?php echo $bg_style; ?>>
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu <?php echo $active_menu === 'full' ? 'active' : ''; ?>" data-menu="full">FULL MENU</button>
            <button class="menu-btn happy-hour <?php echo $active_menu === 'happy' ? 'active' : ''; ?>" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn drink-menu <?php echo $active_menu === 'drink' ? 'active' : ''; ?>" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn brunch-menu <?php echo $active_menu === 'brunch' ? 'active' : ''; ?>" data-menu="brunch">BRUNCH MENU</button>
            <button class="menu-btn burger-menu <?php echo $active_menu === 'burger' ? 'active' : ''; ?>" data-menu="burger">BURGER MENU</button>
            <button class="menu-btn todays-menu <?php echo $active_menu === 'today' ? 'active' : ''; ?>" data-menu="today">TODAY'S MENU</button>
        </div>
        <section class="image-section">
            <div class="image-wrapper">
                <?php
                // Full Menu
                $full_menu_image = si_get_image_url('si_menu_full_image', get_theme_file_uri('assets/images/menus/full-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($full_menu_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'full' ? 'active' : ''; ?>" 
                     data-menu="full"
                     alt="Full Menu"
                     <?php echo $active_menu !== 'full' ? 'style="display: none;"' : ''; ?>>

                <?php
                // Happy Hour Menu
                $happy_hour_image = si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'));
                ?>
                <img src="<?php echo esc_url($happy_hour_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'happy' ? 'active' : ''; ?>" 
                     data-menu="happy"
                     alt="Happy Hour Menu"
                     <?php echo $active_menu !== 'happy' ? 'style="display: none;"' : ''; ?>>

                <?php
                // Drink Menu
                $drink_menu_image = si_get_image_url('si_menu_drink_image', get_theme_file_uri('assets/images/menus/drink-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($drink_menu_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'drink' ? 'active' : ''; ?>" 
                     data-menu="drink"
                     alt="Drink Menu"
                     <?php echo $active_menu !== 'drink' ? 'style="display: none;"' : ''; ?>>

                <?php
                // Brunch Menu
                $brunch_menu_image = si_get_image_url('si_menu_brunch_image', get_theme_file_uri('assets/images/menus/brunch-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($brunch_menu_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'brunch' ? 'active' : ''; ?>" 
                     data-menu="brunch"
                     alt="Brunch Menu"
                     <?php echo $active_menu !== 'brunch' ? 'style="display: none;"' : ''; ?>>

                <?php
                // Burger Menu
                $burger_menu_image = si_get_image_url('si_menu_burger_image', get_theme_file_uri('assets/images/menus/burger-menu.jpg'));
                ?>
                <img src="<?php echo esc_url($burger_menu_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'burger' ? 'active' : ''; ?>" 
                     data-menu="burger"
                     alt="Burger Menu"
                     <?php echo $active_menu !== 'burger' ? 'style="display: none;"' : ''; ?>>

                <?php
                // Today's Menu
                $today = strtolower(date('l'));
                $today_menu_image = si_get_image_url('si_menu_' . $today . '_image');
                if ($today_menu_image) :
                ?>
                <img src="<?php echo esc_url($today_menu_image); ?>" 
                     class="menu-image <?php echo $active_menu === 'today' ? 'active' : ''; ?>" 
                     data-menu="today"
                     alt="Today's Menu"
                     <?php echo $active_menu !== 'today' ? 'style="display: none;"' : ''; ?>>
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