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
    <div class="snap-section">
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
    </div>

    <div class="snap-section">
        <section class="menu-items">
            <article class="menu-card happy-hour">
                <a href="<?php echo esc_url(si_get_menu_card_link('happy_hour')); ?>" class="menu-card-content">
                    <?php 
                    $happy_hour_image = si_get_menu_card_image('happy_hour');
                    if ($happy_hour_image) : ?>
                        <img src="<?php echo esc_url($happy_hour_image); ?>"
                             alt="<?php esc_attr_e('Happy Hour Menu', 'sports-illustrated'); ?>"
                             class="menu-image"
                             loading="lazy"
                        />
                    <?php endif; ?>
                    <h2 class="menu-title">
                        <?php esc_html_e('HAPPY', 'sports-illustrated'); ?>
                        <br />
                        <?php esc_html_e('HOUR', 'sports-illustrated'); ?>
                    </h2>
                </a>
            </article>

            <article class="menu-card fan-favorites">
                <a href="<?php echo esc_url(si_get_menu_card_link('fan_favorites')); ?>" class="menu-card-content">
                    <?php 
                    $fan_favorites_image = si_get_menu_card_image('fan_favorites');
                    if ($fan_favorites_image) : ?>
                        <img src="<?php echo esc_url($fan_favorites_image); ?>"
                             alt="<?php esc_attr_e('Fan Favorites Menu', 'sports-illustrated'); ?>"
                             class="menu-image"
                             loading="lazy"
                        />
                    <?php endif; ?>
                    <h2 class="menu-title">
                        <?php esc_html_e('FAN', 'sports-illustrated'); ?>
                        <br />
                        <?php esc_html_e('FAVORITES', 'sports-illustrated'); ?>
                    </h2>
                </a>
            </article>

            <article class="menu-card drinks-cocktails">
                <a href="<?php echo esc_url(si_get_menu_card_link('drinks_cocktails')); ?>" class="menu-card-content">
                    <?php 
                    $drinks_cocktails_image = si_get_menu_card_image('drinks_cocktails');
                    if ($drinks_cocktails_image) : ?>
                        <img src="<?php echo esc_url($drinks_cocktails_image); ?>"
                             alt="<?php esc_attr_e('Drinks & Cocktails Menu', 'sports-illustrated'); ?>"
                             class="menu-image"
                             loading="lazy"
                        />
                    <?php endif; ?>
                    <h2 class="menu-title">
                        <?php esc_html_e('DRINKS &', 'sports-illustrated'); ?>
                        <br />
                        <?php esc_html_e('COCKTAILS', 'sports-illustrated'); ?>
                    </h2>
                </a>
            </article>
        </section>
    </div>

    <!-- Add Monthly Events Section -->
    <div class="snap-section">
        <?php get_template_part('template-parts/content', 'monthly-events'); ?>
    </div>

    <div class="snap-section">
        <article class="experience-card">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
        </article>
    </div>

    <div class="snap-section">
        <section class="sports-highlights">
            <div class="content-wrapper">
                <div class="main-column">
                    <article class="highlight-content">
                        <div class="content-container">
                            <div class="content-wrapper">
                                <div class="logo-column">
                                    <img
                                        src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>"
                                        alt="Sports Illustrated Logo"
                                        class="logo-image"
                                    />
                                </div>
                                <div class="text-column">
                                    <?php 
                                    // Get the highlights page content
                                    $highlights_page = get_page_by_path('highlights');
                                    if ($highlights_page) {
                                        $content = apply_filters('the_content', $highlights_page->post_content);
                                        echo $content;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="image-column">
                    <img
                        src="<?php echo esc_url(si_get_image_url('si_interior_image')); ?>"
                        alt="Sports Illustrated Clubhouse Interior"
                        class="feature-image"
                    />
                </div>
            </div>
        </section>
    </div>

    <div class="snap-section">
        <section class="locations-section">
            <h1 class="locations-title">OUR LOCATIONS</h1>
            <div class="locations-container">
                <article class="location-card">
                    <figure class="location-image-wrapper">
                        <img
                            src="<?php echo esc_url(si_get_image_url('si_image_location_1', get_theme_file_uri('assets/images/locations/vancouver1.jpg'))); ?>"
                            alt="<?php esc_attr_e('SI Clubhouse Vancouver Location', 'sports-illustrated'); ?>"
                            class="location-image"
                            loading="lazy"
                        />
                    </figure>
                    <div class="location-details">
                        <div class="location-info">
                            <h2 class="location-name">SI CLUBHOUSE VANCOUVER</h2>
                            <p class="location-address">3340 Shrum Lane, Vancouver</p>
                            <p class="location-hours">Open | 11AM - 11PM Daily</p>
                            <p class="location-happy-hour">Daily Happy Hour 3:00 - 5:00 PM</p>
                        </div>
                        <a href="#book" class="reserve-button">RESERVE A TABLE</a>
                    </div>
                </article>
                <article class="location-card card-reverse">
                    <div class="location-details">
                        <div class="location-info">
                            <h2 class="location-name">SI CLUBHOUSE VANCOUVER</h2>
                            <p class="location-address">3340 Shrum Lane, Vancouver</p>
                            <p class="location-hours">Open | 11AM - 11PM Daily</p>
                            <p class="location-happy-hour">Daily Happy Hour 3:00 - 5:00 PM</p>
                        </div>
                        <a href="#book" class="reserve-button">RESERVE A TABLE</a>
                    </div>
                    <figure class="location-image-wrapper">
                        <img
                            src="<?php echo esc_url(si_get_image_url('si_image_location_2', get_theme_file_uri('assets/images/locations/vancouver2.jpg'))); ?>"
                            alt="<?php esc_attr_e('SI Clubhouse Vancouver Location', 'sports-illustrated'); ?>"
                            class="location-image"
                            loading="lazy"
                        />
                    </figure>
                </article>
            </div>
        </section>
    </div>
</main>

