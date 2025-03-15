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

// Get and validate the menu type from URL parameter
$active_menu = isset($_GET['menu']) ? sanitize_key($_GET['menu']) : 'full';

// Define valid menu types and their corresponding image fields
$menu_config = array(
    'full' => array(
        'title' => 'Full Menu',
        'image_field' => 'si_menu_full_image',
        'pdf_field' => 'si_menu_full_pdf',
        'written_content' => 'si_menu_full_content'
    ),
    'drink' => array(
        'title' => 'Drink Menu',
        'image_field' => 'si_menu_drink_image',
        'pdf_field' => 'si_menu_drink_pdf',
        'written_content' => 'si_menu_drink_content'
    ),
    'brunch' => array(
        'title' => 'Brunch Menu',
        'image_field' => 'si_menu_brunch_image',
        'pdf_field' => 'si_menu_brunch_pdf',
        'written_content' => 'si_menu_brunch_content'
    ),
    'happy' => array(
        'title' => 'Happy Hour Menu',
        'image_field' => 'si_menu_happy_image',
        'pdf_field' => 'si_menu_happy_pdf',
        'written_content' => 'si_menu_happy_content'
    ),
    'today' => array(
        'title' => 'Today\'s Menu',
        'image_field' => 'si_menu_today_image',
        'pdf_field' => 'si_menu_today_pdf',
        'written_content' => 'si_menu_today_content'
    )
);

// Validate menu type and set default if invalid
if (!array_key_exists($active_menu, $menu_config)) {
    $active_menu = 'full';
}

// Get the current menu configuration
$current_menu = $menu_config[$active_menu];

// Handle special case for "today's menu"
if ($active_menu === 'today') {
    $today = strtolower(date('l'));
    $current_menu['image_field'] = 'si_menu_' . $today . '_image';
    $current_menu['pdf_field'] = 'si_menu_' . $today . '_pdf';
    $current_menu['written_content'] = 'si_menu_' . $today . '_content';
}

// Get menu content based on display type
$menu_image = get_theme_mod($current_menu['image_field']);
$menu_pdf = get_theme_mod($current_menu['pdf_field']);
$menu_content = get_theme_mod($current_menu['written_content']);

// Add menu navigation
?>
<div class="menu-navigation">
    <?php foreach ($menu_config as $type => $config): ?>
        <a href="<?php echo esc_url(add_query_arg('menu', $type)); ?>" 
           class="menu-nav-item <?php echo $active_menu === $type ? 'active' : ''; ?>">
            <?php echo esc_html($config['title']); ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="menu-content-wrapper" data-menu-type="<?php echo esc_attr($active_menu); ?>">
    <?php if ($display_type === 'image' && $menu_image): ?>
        <div class="image-section">
            <div class="image-wrapper">
                <div class="menu-image-container" data-menu="<?php echo esc_attr($active_menu); ?>">
                    <img src="<?php echo esc_url($menu_image); ?>" alt="<?php echo esc_attr($current_menu['title']); ?>" class="menu-image">
                </div>
            </div>
        </div>
        <?php if ($menu_pdf): ?>
            <div class="menu-pdf-download">
                <a href="<?php echo esc_url($menu_pdf); ?>" class="download-btn" target="_blank">
                    <span class="dashicons dashicons-pdf"></span>
                    Download PDF Menu
                </a>
            </div>
        <?php endif; ?>
    <?php elseif ($display_type === 'written' && $menu_content): ?>
        <div class="menu-content-section">
            <div class="written-menu-container">
                <div class="written-menu-header">
                    <h1 class="written-menu-title"><?php echo esc_html($current_menu['title']); ?></h1>
                </div>
                <div class="written-menu-content">
                    <?php echo wp_kses_post($menu_content); ?>
                </div>
                <?php if ($menu_pdf): ?>
                    <div class="menu-pdf-download">
                        <a href="<?php echo esc_url($menu_pdf); ?>" class="download-btn" target="_blank">
                            <span class="dashicons dashicons-pdf"></span>
                            Download PDF Menu
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="menu-error">
            <p>Menu content is not available at this time. Please check back later.</p>
        </div>
    <?php endif; ?>
</div>

<?php
// Add menu styles
?>
<style>
    /* Menu Navigation Styles */
    .menu-navigation {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 20px 0;
        flex-wrap: wrap;
        padding: 0 20px;
    }

    .menu-nav-item {
        padding: 10px 20px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .menu-nav-item:hover,
    .menu-nav-item.active {
        background: #e63946;
        transform: translateY(-2px);
    }

    /* Image Section Styles */
    .image-section {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
    }
    
    .image-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
    }

    .menu-image-container {
        transform-origin: top center;
        transition: transform 0.3s ease;
    }

    .menu-image {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* Written Menu Styles */
    .menu-content-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .written-menu-container {
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 40px;
    }

    /* PDF Download Button */
    .menu-pdf-download {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .download-btn {
        display: inline-flex;
        align-items: center;
        background-color: #e63946;
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .download-btn:hover {
        background-color: #c1121f;
        transform: translateY(-2px);
    }

    .dashicons {
        margin-right: 8px;
    }

    /* Error Message */
    .menu-error {
        text-align: center;
        padding: 40px 20px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        border-radius: 8px;
        margin: 20px auto;
        max-width: 600px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .menu-navigation {
            gap: 10px;
            padding: 0 10px;
        }

        .menu-nav-item {
            padding: 8px 16px;
            font-size: 14px;
        }

        .written-menu-container {
            padding: 20px;
        }
    }

    <?php
    // Add menu size styles
    foreach ($menu_config as $type => $config) {
        // Desktop styles
        $size_multiplier = get_theme_mod('si_menu_' . $type . '_size_multiplier', '1');
        echo '.menu-image-container[data-menu="' . esc_attr($type) . '"] {';
        echo '    transform: scale(' . esc_attr($size_multiplier) . ');';
        echo '    margin-bottom: ' . ((floatval($size_multiplier) - 1) * 100) . 'px;';
        echo '}';

        // Tablet styles
        echo '@media (max-width: 991px) {';
        $tablet_multiplier = get_theme_mod('si_menu_' . $type . '_tablet_size_multiplier', '1.5');
        echo '    .menu-image-container[data-menu="' . esc_attr($type) . '"] {';
        echo '        transform: scale(' . esc_attr($tablet_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($tablet_multiplier) - 1) * 100) . 'px;';
        echo '    }';
        echo '}';

        // Mobile styles
        echo '@media (max-width: 480px) {';
        $mobile_multiplier = get_theme_mod('si_menu_' . $type . '_mobile_size_multiplier', '2');
        echo '    .menu-image-container[data-menu="' . esc_attr($type) . '"] {';
        echo '        transform: scale(' . esc_attr($mobile_multiplier) . ');';
        echo '        margin-bottom: ' . ((floatval($mobile_multiplier) - 1) * 100) . 'px;';
        echo '    }';
        echo '}';
    }
    ?>
</style>

<?php
get_footer();
?> 