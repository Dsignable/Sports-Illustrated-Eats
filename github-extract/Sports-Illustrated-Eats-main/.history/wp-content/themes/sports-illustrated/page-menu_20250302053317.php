<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background image
$bg_image = si_get_menu_background();
$bg_style = $bg_image ? 'style="background-image: url(' . esc_url($bg_image) . ');"' : '';

// Define menu types
$menu_types = array(
    'full'    => 'Full Menu',
    'happy'   => 'Happy Hour',
    'drink'   => 'Drinks',
    'today'   => 'Today\'s Specials',
    'brunch'  => 'Brunch',
    'burger'  => 'Burgers'
);
?>

<main id="primary" class="site-main menu-page" <?php echo $bg_style; ?>>
    <div class="menu-container">
        <div class="menu-buttons">
            <?php foreach ($menu_types as $key => $label) : 
                $menu_image = si_get_menu_image_url($key);
                if ($menu_image) : ?>
                    <button class="menu-btn" data-menu="<?php echo esc_attr($key); ?>">
                        <?php echo esc_html($label); ?>
                    </button>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="image-section">
            <div class="image-wrapper">
                <?php foreach ($menu_types as $key => $label) : 
                    $menu_image = si_get_menu_image_url($key);
                    if ($menu_image) : ?>
                        <img src="<?php echo esc_url($menu_image); ?>"
                             alt="<?php echo esc_attr($label); ?>"
                             class="menu-image"
                             data-menu="<?php echo esc_attr($key); ?>"
                             <?php echo $key === 'full' ? 'style="display: block;"' : ''; ?>
                        />
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
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