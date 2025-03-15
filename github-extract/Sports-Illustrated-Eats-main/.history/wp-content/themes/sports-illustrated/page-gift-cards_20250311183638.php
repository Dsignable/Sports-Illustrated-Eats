<?php
/**
 * Template Name: Gift Cards Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$bg_image = get_theme_mod('si_gift_cards_bg_image', '');
$bg_opacity = get_theme_mod('si_gift_cards_bg_opacity', 0.5);
$bg_style = '';

if ($bg_image) {
    $bg_style = 'style="background-image: url(' . esc_url($bg_image) . '); position: relative;"';
}

$page_title = get_theme_mod('si_gift_cards_title', __('GIVE THE GIFT OF FLAVOR!', 'sports-illustrated'));
$page_description = get_theme_mod('si_gift_cards_description', __('Looking for the perfect gift for food lovers? Our gift cards make every occasion special. Treat your friends and family to a dining experience filled with delicious dishes, cozy ambiance, and unforgettable memories.', 'sports-illustrated'));
$cta_url = get_theme_mod('si_gift_cards_cta_url', '#');
$cta_text = get_theme_mod('si_gift_cards_cta_text', __('BUY GIFT CARDS', 'sports-illustrated'));
?>

<main id="primary" class="site-main gift-cards-page" <?php echo $bg_style; ?>>
    <?php if ($bg_image && $bg_opacity > 0): ?>
    <div class="background-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, <?php echo esc_attr($bg_opacity); ?>); z-index: 1;"></div>
    <?php endif; ?>
    
    <!-- Gift Cards Header Section -->
    <section class="gift-cards-header" style="position: relative; z-index: 2;">
        <div class="gift-cards-header-content">
            <h1 class="gift-cards-title"><?php echo esc_html($page_title); ?></h1>
            <p class="gift-cards-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- Gift Cards Content Section -->
    <section class="gift-cards-content" style="position: relative; z-index: 2;">
        <div class="gift-cards-container">
            <?php
            // Display the page content first
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
            <?php if ($cta_url && $cta_text): ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="gift-cta"><?php echo esc_html($cta_text); ?></a>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
?> 