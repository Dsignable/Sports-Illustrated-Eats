<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('menu');

// Get the menu size multiplier from customizer
$menu_size_multiplier = get_theme_mod('si_menu_size_multiplier', '1');

// Get the menu type from URL parameter
$active_menu = isset($_GET['menu']) ? sanitize_key($_GET['menu']) : 'full';
$valid_menus = array('full', 'happy', 'drink', 'brunch', 'today');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}

// Add custom CSS for menu size
?>
<style>
    .menu-image-container {
        transform-origin: top center;
        transform: scale(<?php echo esc_attr($menu_size_multiplier); ?>);
        margin-bottom: <?php echo (floatval($menu_size_multiplier) - 1) * 100; ?>px;
    }
    
    .image-section {
        overflow-x: auto;
        max-width: 100%;
    }
    
    .image-wrapper {
        min-height: <?php echo max(100, 100 * floatval($menu_size_multiplier)); ?>vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
    }
</style>

<main id="primary" class="site-main menu-page" <?php echo $bg_style; ?>>
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu <?php echo $active_menu === 'full' ? 'active' : ''; ?>" data-menu="full">FULL MENU</button>
            <button class="menu-btn drink-menu <?php echo $active_menu === 'drink' ? 'active' : ''; ?>" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn brunch-menu <?php echo $active_menu === 'brunch' ? 'active' : ''; ?>" data-menu="brunch">BRUNCH MENU</button>
            <button class="menu-btn happy-hour <?php echo $active_menu === 'happy' ? 'active' : ''; ?>" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn todays-menu <?php echo $active_menu === 'today' ? 'active' : ''; ?>" data-menu="today">TODAY'S MENU</button>
        </div>
        <section class="image-section">
            <div class="image-wrapper">
                <?php
                // Full Menu
                $full_menu_image = si_get_image_url('si_menu_full_image', get_theme_file_uri('assets/images/menus/full-menu.jpg'));
                $full_menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_full_pdf'));
                ?>
                <div class="menu-image-container <?php echo $active_menu === 'full' ? 'active' : ''; ?>" data-menu="full" <?php echo $active_menu !== 'full' ? 'style="display: none;"' : ''; ?>>
                    <img src="<?php echo esc_url($full_menu_image); ?>" 
                         class="menu-image" 
                         alt="Full Menu">
                    <?php if ($full_menu_pdf) : ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($full_menu_pdf); ?>" target="_blank" class="download-btn">
                            <span class="dashicons dashicons-pdf"></span> Download PDF
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                // Drink Menu
                $drink_menu_image = si_get_image_url('si_menu_drink_image', get_theme_file_uri('assets/images/menus/drink-menu.jpg'));
                $drink_menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_drink_pdf'));
                ?>
                <div class="menu-image-container <?php echo $active_menu === 'drink' ? 'active' : ''; ?>" data-menu="drink" <?php echo $active_menu !== 'drink' ? 'style="display: none;"' : ''; ?>>
                    <img src="<?php echo esc_url($drink_menu_image); ?>" 
                         class="menu-image" 
                         alt="Drink Menu">
                    <?php if ($drink_menu_pdf) : ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($drink_menu_pdf); ?>" target="_blank" class="download-btn">
                            <span class="dashicons dashicons-pdf"></span> Download PDF
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                // Happy Hour Menu
                $happy_hour_image = si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'));
                $happy_hour_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_happy_pdf'));
                ?>
                <div class="menu-image-container <?php echo $active_menu === 'happy' ? 'active' : ''; ?>" data-menu="happy" <?php echo $active_menu !== 'happy' ? 'style="display: none;"' : ''; ?>>
                    <img src="<?php echo esc_url($happy_hour_image); ?>" 
                         class="menu-image" 
                         alt="Happy Hour Menu">
                    <?php if ($happy_hour_pdf) : ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($happy_hour_pdf); ?>" target="_blank" class="download-btn">
                            <span class="dashicons dashicons-pdf"></span> Download PDF
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                // Brunch Menu
                $brunch_menu_image = si_get_image_url('si_menu_brunch_image', get_theme_file_uri('assets/images/menus/brunch-menu.jpg'));
                $brunch_menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_brunch_pdf'));
                ?>
                <div class="menu-image-container <?php echo $active_menu === 'brunch' ? 'active' : ''; ?>" data-menu="brunch" <?php echo $active_menu !== 'brunch' ? 'style="display: none;"' : ''; ?>>
                    <img src="<?php echo esc_url($brunch_menu_image); ?>" 
                         class="menu-image" 
                         alt="Brunch Menu">
                    <?php if ($brunch_menu_pdf) : ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($brunch_menu_pdf); ?>" target="_blank" class="download-btn">
                            <span class="dashicons dashicons-pdf"></span> Download PDF
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                // Today's Menu
                $today = strtolower(date('l'));
                $today_menu_image = si_get_image_url('si_menu_' . $today . '_image');
                $today_menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_' . $today . '_pdf'));
                
                if ($today_menu_image) :
                ?>
                <div class="menu-image-container <?php echo $active_menu === 'today' ? 'active' : ''; ?>" data-menu="today" <?php echo $active_menu !== 'today' ? 'style="display: none;"' : ''; ?>>
                    <img src="<?php echo esc_url($today_menu_image); ?>" 
                         class="menu-image" 
                         alt="Today's Menu">
                    <?php if ($today_menu_pdf) : ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($today_menu_pdf); ?>" target="_blank" class="download-btn">
                            <span class="dashicons dashicons-pdf"></span> Download PDF
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else : ?>
                <div class="menu-image-container <?php echo $active_menu === 'today' ? 'active' : ''; ?>" data-menu="today" <?php echo $active_menu !== 'today' ? 'style="display: none;"' : ''; ?>>
                    <div class="no-menu-message">
                        <p><?php _e('Today\'s menu is not available yet. Please check back later or view our other menus.', 'sports-illustrated'); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </nav>
</main>

<?php
// Enqueue dashicons for PDF icon
wp_enqueue_style('dashicons');

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