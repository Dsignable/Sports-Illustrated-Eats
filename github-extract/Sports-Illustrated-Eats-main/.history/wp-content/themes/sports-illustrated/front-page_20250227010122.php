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
            <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
            <p><?php echo esc_html(get_bloginfo('description')); ?></p>
        </div>
    </div>

    <?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/content', 'page');
    endwhile;
    ?>
</main>

<?php
get_footer(); 