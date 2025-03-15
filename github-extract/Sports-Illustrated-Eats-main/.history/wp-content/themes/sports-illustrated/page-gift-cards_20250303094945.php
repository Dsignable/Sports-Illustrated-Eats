<?php
/**
 * Template Name: Gift Cards Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$bg_style = si_get_background_style('gift');
$page_title = get_theme_mod('si_gift_cards_title', __('GIVE THE GIFT OF FLAVOR!', 'sports-illustrated'));
$page_description = get_theme_mod('si_gift_cards_description', __('Looking for the perfect gift for food lovers? Our gift cards make every occasion special. Treat your friends and family to a dining experience filled with delicious dishes, cozy ambiance, and unforgettable memories.', 'sports-illustrated'));
?>

<main id="primary" class="site-main gift-cards-page" <?php echo $bg_style; ?>>
    <!-- Gift Cards Header Section -->
    <section class="gift-cards-header">
        <div class="gift-cards-header-content">
            <h1 class="gift-cards-title"><?php echo esc_html($page_title); ?></h1>
            <p class="gift-cards-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- Gift Cards Content Section -->
    <section class="gift-cards-content">
        <div class="gift-cards-container">
            <?php
            // Display the page content first
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
            <a href="#" class="gift-cta">BUY GIFT CARDS</a>
        </div>
    </section>
</main>

<?php
get_footer();
?> 