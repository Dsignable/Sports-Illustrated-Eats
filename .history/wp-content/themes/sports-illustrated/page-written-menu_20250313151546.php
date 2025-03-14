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
$valid_menus = array('full', 'drinks', 'brunch');
if (!in_array($active_menu, $valid_menus)) {
    $active_menu = 'full';
}

// Get the menu page ID for links
$menu_page_id = get_the_ID();
$use_page_id = false;
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'sportsillustratedeats.com') !== false) {
    $use_page_id = true;
}
?>

<main id="primary" class="site-main written-menu-page" <?php echo $bg_style; ?>>
    <nav class="menu-container">
        <div class="menu-buttons">
            <?php
            // Generate menu button URLs
            $menu_types = array(
                'full'   => __('FULL MENU', 'sports-illustrated'),
                'drinks' => __('DRINK MENU', 'sports-illustrated'),
                'brunch' => __('BRUNCH MENU', 'sports-illustrated')
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
        
        <section class="written-menu-section">
            <?php
            // Display the active menu
            foreach ($menu_types as $menu_type => $menu_label) :
                $is_active = ($active_menu === $menu_type);
            ?>
                <div class="written-menu-wrapper <?php echo $is_active ? 'active' : ''; ?>" 
                     data-menu="<?php echo esc_attr($menu_type); ?>" 
                     <?php echo !$is_active ? 'style="display: none;"' : ''; ?>>
                    <?php 
                    // Include the written menu template part with the menu type
                    get_template_part('template-parts/content', 'written-menu', array('menu_type' => $menu_type)); 
                    ?>
                </div>
            <?php endforeach; ?>
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