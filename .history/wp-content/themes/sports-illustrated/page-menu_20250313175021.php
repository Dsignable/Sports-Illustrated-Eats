<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('menu');

// Get the menu display type
$display_type = get_theme_mod('si_menu_display_type', 'image');

// Get the menu type from URL parameter
$active_menu = isset($_GET['menu']) ? sanitize_key($_GET['menu']) : 'full';
$valid_menus = array('full', 'drink', 'brunch', 'happy', 'today');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}

// Define which menus can be displayed as written text
$written_menu_types = array('full', 'drink', 'brunch');

// Get today's day for "today's menu"
$today = strtolower(date('l'));

// Get the menu page ID for links
$menu_page_id = get_the_ID();
$use_page_id = false;
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'sportsillustratedeats.com') !== false) {
    $use_page_id = true;
}

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
    
    /* Written Menu Styles */
    .menu-content-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .written-menu-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 40px;
        position: relative;
    }
    
    .menu-pdf-download {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eaeaea;
    }
    
    .download-btn {
        display: inline-flex;
        align-items: center;
        background-color: #e63946;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    
    .download-btn:hover {
        background-color: #c1121f;
        color: white;
    }
    
    .download-btn .dashicons {
        margin-right: 8px;
    }
    
    .written-menu-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #eaeaea;
        padding-bottom: 20px;
    }
    
    .written-menu-title {
        font-size: 36px;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 700;
        color: #333;
    }
    
    .written-menu-description {
        font-size: 18px;
        color: #666;
        font-style: italic;
    }
    
    .menu-section {
        margin-bottom: 40px;
    }
    
    .section-title {
        font-size: 24px;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-weight: 600;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 10px;
        color: #e63946;
    }
    
    .section-description {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
        font-style: italic;
    }
    
    .menu-items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .menu-item {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }
    
    .menu-item:hover {
        background-color: #f8f9fa;
    }
    
    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 8px;
        border-bottom: 1px dashed #ddd;
        padding-bottom: 8px;
    }
    
    .item-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        color: #333;
    }
    
    .item-price {
        font-size: 18px;
        font-weight: 600;
        color: #e63946;
    }
    
    .item-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    .item-notes {
        font-size: 12px;
        color: #999;
        font-style: italic;
        display: inline-block;
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 3px;
        margin-top: 5px;
    }
    
    /* Responsive styles for written menus */
    @media (max-width: 768px) {
        .menu-items {
            grid-template-columns: 1fr;
        }
        
        .written-menu-container {
            padding: 20px;
        }
        
        .written-menu-title {
            font-size: 28px;
        }
        
        .section-title {
            font-size: 20px;
        }
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
            <?php
            // Generate menu button URLs
            $menu_types = array(
                'full' => 'FULL MENU',
                'drink' => 'DRINK MENU',
                'brunch' => 'BRUNCH MENU',
                'happy' => 'HAPPY HOUR',
                'today' => 'TODAY\'S MENU'
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
        
        <?php if ($display_type === 'written') : ?>
            <!-- Written Menu Display -->
            <section class="menu-content-section">
                <?php
                // Display the active menu
                foreach ($menu_types as $menu_type => $menu_label) :
                    $is_active = ($active_menu === $menu_type);
                    $is_written_menu = in_array($menu_type, $written_menu_types);
                    
                    // For written menus (full, drink, brunch)
                    if ($is_written_menu) :
                        // Get PDF URL for download button
                        $menu_pdf = wp_get_attachment_url(get_theme_mod('si_restaurant_menu_' . $menu_type . '_pdf'));
                ?>
                    <div class="written-menu-wrapper <?php echo $is_active ? 'active' : ''; ?>" 
                         data-menu="<?php echo esc_attr($menu_type); ?>" 
                         <?php echo !$is_active ? 'style="display: none;"' : ''; ?>>
                        <?php 
                        // Include the written menu template part with the menu type
                        // Convert 'drink' to 'drinks' for template part
                        $template_menu_type = ($menu_type === 'drink') ? 'drinks' : $menu_type;
                        get_template_part('template-parts/content', 'written-menu', array('menu_type' => $template_menu_type)); 
                        ?>
                        <?php if ($menu_pdf) : ?>
                        <div class="menu-pdf-download">
                            <a href="<?php echo esc_url($menu_pdf); ?>" target="_blank" class="download-btn">
                                <span class="dashicons dashicons-pdf"></span> Download PDF
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php 
                    endif;
                endforeach; 
                
                // For image-based menus (happy hour, today's menu)
                foreach ($menu_types as $menu_type => $menu_label) :
                    $is_active = ($active_menu === $menu_type);
                    $is_image_menu = !in_array($menu_type, $written_menu_types);
                    
                    if ($is_image_menu) :
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
        <?php else : ?>
            <!-- Image-based Menu Display -->
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
        <?php endif; ?>
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