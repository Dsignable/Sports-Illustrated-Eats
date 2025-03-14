<?php
/**
 * Template Name: Written Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('menu');

// Get the menu type from URL parameter
$active_menu = isset($_GET['menu']) ? sanitize_key($_GET['menu']) : 'full';
$valid_menus = array('full', 'drinks', 'brunch', 'happy', 'today');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}

// Define which menus can be displayed as written text
$written_menu_types = array('full', 'drinks', 'brunch');

// Get today's day for "today's menu"
$today = strtolower(date('l'));

// Get the menu page ID for links
$menu_page_id = get_the_ID();
$use_page_id = false;
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'sportsillustratedeats.com') !== false) {
    $use_page_id = true;
}

// Add custom CSS for menu size (for image-based menus)
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
    foreach (array('happy', $today) as $menu_type) {
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
    foreach (array('happy', $today) as $menu_type) {
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
    foreach (array('happy', $today) as $menu_type) {
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

<main id="primary" class="site-main written-menu-page" <?php echo $bg_style; ?>>
    <nav class="menu-container">
        <div class="menu-buttons">
            <?php
            // Generate menu button URLs
            $menu_types = array(
                'full'   => __('FULL MENU', 'sports-illustrated'),
                'drinks' => __('DRINK MENU', 'sports-illustrated'),
                'brunch' => __('BRUNCH MENU', 'sports-illustrated'),
                'happy'  => __('HAPPY HOUR', 'sports-illustrated'),
                'today'  => __('TODAY\'S MENU', 'sports-illustrated')
            );
            
            foreach ($menu_types as $menu_type => $menu_label) :
                $button_url = $use_page_id ? 
                    add_query_arg(array('page_id' => $menu_page_id, 'menu' => $menu_type), home_url()) : 
                    add_query_arg('menu', $menu_type, get_permalink());
            ?>
                <button class="menu-btn <?php echo $menu_type; ?>-menu <?php echo $active_menu === $menu_type ? 'active' : ''; ?>" 
                        data-menu="<?php echo esc_attr($menu_type); ?>" 
                        data-url="<?php echo esc_url($button_url); ?>">
                    <?php echo esc_html($menu_label); ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <section class="menu-content-section">
            <?php
            // Display the active menu
            foreach ($menu_types as $menu_type => $menu_label) :
                $is_active = ($active_menu === $menu_type);
                $is_written_menu = in_array($menu_type, $written_menu_types);
                
                // For written menus (full, drinks, brunch)
                if ($is_written_menu) :
            ?>
                <div class="written-menu-wrapper <?php echo $is_active ? 'active' : ''; ?>" 
                     data-menu="<?php echo esc_attr($menu_type); ?>" 
                     <?php echo !$is_active ? 'style="display: none;"' : ''; ?>>
                    <?php 
                    // Include the written menu template part with the menu type
                    // Convert 'drinks' to 'drinks' for template part
                    $template_menu_type = ($menu_type === 'drinks') ? 'drinks' : $menu_type;
                    get_template_part('template-parts/content', 'written-menu', array('menu_type' => $template_menu_type)); 
                    ?>
                </div>
            <?php 
                // For image-based menus (happy hour, today's menu)
                else : 
                    if ($menu_type === 'happy') :
                        $menu_image = si_get_image_url('si_menu_happy_image', get_theme_file_uri('assets/images/menus/happy-hour.jpg'));
                        $menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_happy_pdf'));
                    elseif ($menu_type === 'today') :
                        $menu_image = si_get_image_url('si_menu_' . $today . '_image');
                        $menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_' . $today . '_pdf'));
                    endif;
            ?>
                <div class="image-section <?php echo $is_active ? 'active' : ''; ?>" 
                     data-menu="<?php echo esc_attr($menu_type); ?>" 
                     <?php echo !$is_active ? 'style="display: none;"' : ''; ?>>
                    <div class="image-wrapper">
                        <?php if (($menu_type === 'today' && $menu_image) || $menu_type === 'happy') : ?>
                            <div class="menu-image-container" data-menu="<?php echo esc_attr($menu_type); ?>">
                                <img src="<?php echo esc_url($menu_image); ?>" 
                                     class="menu-image" 
                                     alt="<?php echo esc_attr($menu_label); ?>">
                                <?php if (isset($menu_pdf) && $menu_pdf) : ?>
                                <div class="menu-pdf-download">
                                    <a href="<?php echo esc_url($menu_pdf); ?>" target="_blank" class="download-btn">
                                        <span class="dashicons dashicons-pdf"></span> Download PDF
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($menu_type === 'today' && !$menu_image) : ?>
                            <div class="no-menu-message">
                                <p><?php _e('Today\'s menu is not available yet. Please check back later or view our other menus.', 'sports-illustrated'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
                endif; 
            endforeach; 
            ?>
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