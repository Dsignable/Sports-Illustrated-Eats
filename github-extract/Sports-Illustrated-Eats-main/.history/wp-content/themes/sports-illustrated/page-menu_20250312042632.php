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
$valid_menus = array('full', 'happy', 'drink', 'brunch', 'today');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}

// Get today's day for "today's menu"
$today = strtolower(date('l'));

// Add custom CSS for menu size
?>
<style>
    .image-section {
        overflow-x: auto;
        max-width: 100%;
    }
    
    .image-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
    }
    
    <?php
    // Add individual menu size styles for desktop
    foreach (array('full', 'drink', 'happy', 'brunch', $today) as $menu_type) {
        $size_multiplier = get_theme_mod('si_menu_' . $menu_type . '_size_multiplier', '1');
        echo '.menu-image-container[data-menu="' . esc_attr($menu_type) . '"] {';
        echo '    transform-origin: top center;';
        echo '    transform: scale(' . esc_attr($size_multiplier) . ');';
        echo '    margin-bottom: ' . ((floatval($size_multiplier) - 1) * 100) . 'px;';
        echo '}';
    }
    
    // Special case for "today" menu which uses the day of week
    if ($active_menu === 'today') {
        $today_multiplier = get_theme_mod('si_menu_' . $today . '_size_multiplier', '1');
        echo '.menu-image-container[data-menu="today"] {';
        echo '    transform-origin: top center;';
        echo '    transform: scale(' . esc_attr($today_multiplier) . ');';
        echo '    margin-bottom: ' . ((floatval($today_multiplier) - 1) * 100) . 'px;';
        echo '}';
    }
    
    // Add tablet-specific styles
    echo '@media (max-width: 991px) {';
    foreach (array('full', 'drink', 'happy', 'brunch', $today) as $menu_type) {
        $tablet_multiplier = get_theme_mod('si_menu_' . $menu_type . '_tablet_size_multiplier', '1.5');
        echo '    .menu-image-container[data-menu="' . esc_attr($menu_type) . '"] {';
        echo '        transform: scale(' . esc_attr($tablet_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($tablet_multiplier) - 1) * 100) . 'px;';
        echo '    }';
    }
    
    // Special case for "today" menu on tablet
    if ($active_menu === 'today') {
        $today_tablet_multiplier = get_theme_mod('si_menu_' . $today . '_tablet_size_multiplier', '1.5');
        echo '    .menu-image-container[data-menu="today"] {';
        echo '        transform: scale(' . esc_attr($today_tablet_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($today_tablet_multiplier) - 1) * 100) . 'px;';
        echo '    }';
    }
    echo '}';
    
    // Add mobile-specific styles
    echo '@media (max-width: 480px) {';
    foreach (array('full', 'drink', 'happy', 'brunch', $today) as $menu_type) {
        $mobile_multiplier = get_theme_mod('si_menu_' . $menu_type . '_mobile_size_multiplier', '2');
        echo '    .menu-image-container[data-menu="' . esc_attr($menu_type) . '"] {';
        echo '        transform: scale(' . esc_attr($mobile_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($mobile_multiplier) - 1) * 100) . 'px;';
        echo '    }';
    }
    
    // Special case for "today" menu on mobile
    if ($active_menu === 'today') {
        $today_mobile_multiplier = get_theme_mod('si_menu_' . $today . '_mobile_size_multiplier', '2');
        echo '    .menu-image-container[data-menu="today"] {';
        echo '        transform: scale(' . esc_attr($today_mobile_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($today_mobile_multiplier) - 1) * 100) . 'px;';
        echo '    }';
    }
    echo '}';
    ?>
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