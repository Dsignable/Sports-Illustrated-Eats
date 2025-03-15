<?php
/**
 * The template for displaying the homepage
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background type and URL from theme options or ACF
$bg_type = get_theme_mod('si_background_type', 'image');
$bg_video_url = get_theme_mod('si_background_video');
$bg_image_url = get_theme_mod('si_background_image');
?>

<main id="primary" class="site-main home-page">
    <div class="hero-section">
        <?php if ($bg_type === 'video' && $bg_video_url) : ?>
            <div class="hero-background video-background">
                <video autoplay muted loop playsinline id="heroVideo">
                    <source src="<?php echo esc_url($bg_video_url); ?>" type="video/mp4">
                </video>
            </div>
        <?php elseif ($bg_image_url) : ?>
            <div class="hero-background image-background" style="background-image: url('<?php echo esc_url($bg_image_url); ?>');">
            </div>
        <?php endif; ?>

        <div class="hero-overlay"></div>
        
        <div class="hero-content">
        </div>
    </div>

    <section class="menu-items">
        <article class="menu-card happy-hour">
            <div class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/happy-hour-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Happy Hour Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                />
                <h2 class="menu-title happy-hour-title">
                    <?php esc_html_e('HAPPY', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('HOUR', 'sports-illustrated'); ?>
                </h2>
            </div>
        </article>

        <article class="menu-card fan-favorites">
            <div class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/fan-favorites-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Fan Favorites Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                />
                <h2 class="menu-title fan-favorites-title">
                    <?php esc_html_e('FAN', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('FAVORITES', 'sports-illustrated'); ?>
                </h2>
            </div>
        </article>

        <article class="menu-card drinks-cocktails">
            <div class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/drinks-cocktails-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Drinks & Cocktails Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                />
                <h2 class="menu-title drinks-cocktails-title">
                    <?php esc_html_e('DRINKS &', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('COCKTAILS', 'sports-illustrated'); ?>
                </h2>
            </div>
        </article>
    </section>
</main>
<?php
// Removed get_footer() call 