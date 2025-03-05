<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get the active menu type from URL parameter, default to 'full'
$active_menu = isset($_GET['menu']) ? sanitize_text_field($_GET['menu']) : 'full';

// Define all available menus
$menu_types = array(
    'full' => __('Full Menu', 'sports-illustrated'),
    'happy' => __('Happy Hour', 'sports-illustrated'),
    'drink' => __('Drinks', 'sports-illustrated'),
    'brunch' => __('Brunch', 'sports-illustrated'),
    'burger' => __('Burgers', 'sports-illustrated')
);
?>

<main id="primary" class="site-main menu-page">
    <div class="menu-container">
        <div class="menu-buttons">
            <?php foreach ($menu_types as $menu_id => $menu_name) : ?>
                <button 
                    class="menu-btn <?php echo $active_menu === $menu_id ? 'active' : ''; ?>"
                    data-menu="<?php echo esc_attr($menu_id); ?>"
                >
                    <?php echo esc_html($menu_name); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="image-section">
            <div class="image-wrapper">
                <?php foreach ($menu_types as $menu_id => $menu_name) : 
                    $menu_image = si_get_menu_page_image($menu_id);
                    if ($menu_image) : ?>
                        <img 
                            src="<?php echo esc_url($menu_image); ?>"
                            alt="<?php echo esc_attr($menu_name); ?>"
                            class="menu-image <?php echo $active_menu === $menu_id ? 'active' : ''; ?>"
                            data-menu="<?php echo esc_attr($menu_id); ?>"
                            loading="lazy"
                        />
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.menu-btn');
    const images = document.querySelectorAll('.menu-image');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const menuType = this.dataset.menu;
            
            // Update buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update images
            images.forEach(img => {
                if (img.dataset.menu === menuType) {
                    img.classList.add('active');
                } else {
                    img.classList.remove('active');
                }
            });

            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('menu', menuType);
            window.history.pushState({}, '', url);
        });
    });
});
</script>

<?php get_footer(); ?> 