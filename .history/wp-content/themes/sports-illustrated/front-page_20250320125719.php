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
$bg_video_file = get_theme_mod('si_background_video_file');
$bg_image_url = get_theme_mod('si_background_image');

// Get video URL (either direct URL or uploaded file)
$video_url = '';
if ($bg_type === 'video') {
    if ($bg_video_file) {
        $video_url = wp_get_attachment_url($bg_video_file);
    } elseif ($bg_video_url) {
        $video_url = $bg_video_url;
    }
}
?>

<main id="primary" class="site-main home-page">
    <div class="snap-scroll" id="snap-container">
        <!-- Hero Section -->
        <div class="snap-section">
            <div class="hero-section">
                <?php if ($bg_type === 'video' && $video_url) : ?>
                    <div class="hero-background video-background">
                        <video autoplay muted loop playsinline id="heroVideo">
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        </video>
                    </div>
                <?php elseif ($bg_image_url) : ?>
                    <div class="hero-background image-background" style="background-image: url('<?php echo esc_url($bg_image_url); ?>');">
                    </div>
                <?php endif; ?>

                <div class="hero-content">
                </div>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="snap-section">
            <section class="menu-items">
                <!-- Happy Hour Menu Card -->
                <article class="menu-card happy-hour">
                    <a href="<?php echo esc_url(si_get_menu_card_link('happy_hour')); ?>" class="menu-card-content">
                        <?php 
                        $happy_hour_image = si_get_menu_card_image('happy_hour', get_theme_file_uri('assets/images/modified/happy-hour-menu.jpg'));
                        $happy_hour_title = get_theme_mod('si_menu_card_happy_hour_title', 'HAPPY HOUR');
                        $title_parts = explode(' ', $happy_hour_title, 2);
                        ?>
                        <img src="<?php echo esc_url($happy_hour_image); ?>"
                            alt="<?php echo esc_attr($happy_hour_title); ?>"
                            class="menu-image"
                            loading="lazy" />
                        <h2 class="menu-title">
                            <?php echo esc_html($title_parts[0] ?? ''); ?>
                            <?php if (isset($title_parts[1])): ?>
                            <br />
                            <?php echo esc_html($title_parts[1]); ?>
                            <?php endif; ?>
                        </h2>
                    </a>
                </article>

                <!-- Fan Favorites Menu Card -->
                <article class="menu-card fan-favorites">
                    <a href="<?php echo esc_url(si_get_menu_card_link('fan_favorites')); ?>" class="menu-card-content">
                        <?php 
                        $fan_favorites_image = si_get_menu_card_image('fan_favorites', get_theme_file_uri('assets/images/modified/fan-favorites-menu.jpg'));
                        $fan_favorites_title = get_theme_mod('si_menu_card_fan_favorites_title', 'FAN FAVORITES');
                        $title_parts = explode(' ', $fan_favorites_title, 2);
                        ?>
                        <img src="<?php echo esc_url($fan_favorites_image); ?>"
                            alt="<?php echo esc_attr($fan_favorites_title); ?>"
                            class="menu-image"
                            loading="lazy" />
                        <h2 class="menu-title">
                            <?php echo esc_html($title_parts[0] ?? ''); ?>
                            <?php if (isset($title_parts[1])): ?>
                            <br />
                            <?php echo esc_html($title_parts[1]); ?>
                            <?php endif; ?>
                        </h2>
                    </a>
                </article>

                <!-- Drinks & Cocktails Menu Card -->
                <article class="menu-card drinks-cocktails">
                    <a href="<?php echo esc_url(si_get_menu_card_link('drinks_cocktails')); ?>" class="menu-card-content">
                        <?php 
                        $drinks_cocktails_image = si_get_menu_card_image('drinks_cocktails', get_theme_file_uri('assets/images/modified/drinks-cocktails.jpg'));
                        $drinks_cocktails_title = get_theme_mod('si_menu_card_drinks_cocktails_title', 'DRINKS & COCKTAILS');
                        $title_parts = explode(' ', $drinks_cocktails_title, 2);
                        ?>
                        <img src="<?php echo esc_url($drinks_cocktails_image); ?>"
                            alt="<?php echo esc_attr($drinks_cocktails_title); ?>"
                            class="menu-image"
                            loading="lazy" />
                        <h2 class="menu-title">
                            <?php echo esc_html($title_parts[0] ?? ''); ?>
                            <?php if (isset($title_parts[1])): ?>
                            <br />
                            <?php echo esc_html($title_parts[1]); ?>
                            <?php endif; ?>
                        </h2>
                    </a>
                </article>

            </section>
        </div>

        <!-- Add Monthly Events Section -->
        <div class="snap-section">
            <?php get_template_part('template-parts/content', 'monthly-events'); ?>
        </div>

        <!-- Experience Section -->
        <div class="snap-section">
            <section class="experience-card">
                <?php if (get_theme_mod('si_show_about_section', true)) : ?>
                <article class="content-container">
                    <h2 class="content-title"><?php echo esc_html(get_theme_mod('si_about_section_title', 'About Us')); ?></h2>
                    <div class="content-body">
                        <p class="description">
                            <?php echo wp_kses_post(get_theme_mod('si_about_us_text', si_get_default_content('about_us'))); ?>
                        </p>
                    </div>
                </article>
                <?php endif; ?>
            </section>
        </div>

        <!-- Sports Highlights Section -->
        <div class="snap-section">
            <section class="sports-highlights">
                <div class="content-wrapper">
                    <div class="highlight-content">
                        <?php if (get_theme_mod('si_show_vip_section', true)) : ?>
                        <div class="top-section">
                            <div class="text-content">
                                <h2 class="main-heading">
                                    <?php echo esc_html(get_theme_mod('si_vip_section_title', 'Where Every Fan\'s a VIP')); ?>
                                </h2>
                                <p class="description">
                                    <?php echo wp_kses_post(get_theme_mod('si_vip_text', si_get_default_content('vip_text'))); ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (get_theme_mod('si_show_specials_section', true)) : ?>
                        <div class="bottom-section">
                            <div class="text-content">
                                <h2 class="main-heading">
                                    <?php echo esc_html(get_theme_mod('si_specials_section_title', 'Game-Changing Specials, Every Day of the Week')); ?>
                                </h2>
                                <p class="description">
                                    <?php echo wp_kses_post(get_theme_mod('si_specials_text', si_get_default_content('specials'))); ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

        <!-- Locations Section -->
        <div class="snap-section">
            <section class="locations-section">
                <h1 class="locations-title"><?php echo esc_html(get_theme_mod('si_locations_title', 'OUR LOCATIONS')); ?></h1>
                <div class="locations-container">
                    <article class="location-card">
                        <figure class="location-image-wrapper">
                            <img
                                src="<?php echo esc_url(wp_get_attachment_url(get_theme_mod('si_image_location_1', ''))); ?>"
                                alt="<?php esc_attr_e('Location 1', 'sports-illustrated'); ?>"
                                class="location-image"
                                loading="lazy" />
                        </figure>
                        <div class="location-details">
                            <div class="location-info">
                                <h2 class="location-name"><?php echo esc_html(get_theme_mod('si_location_1_name', 'SI CLUBHOUSE VANCOUVER')); ?></h2>
                                <p class="location-address"><?php echo esc_html(get_theme_mod('si_location_1_address', '3340 Shrum Lane, Vancouver')); ?></p>
                                <p class="location-hours"><?php echo esc_html(get_theme_mod('si_location_1_hours', 'Open | 11AM - 11PM Daily')); ?></p>
                                <p class="location-happy-hour"><?php echo esc_html(get_theme_mod('si_location_1_happy_hour', 'Daily Happy Hour 3:00 - 5:00 PM')); ?></p>
                            </div>
                            <a href="<?php echo esc_url(get_theme_mod('si_location_1_reservation_url', 'https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website')); ?>" class="reserve-button">RESERVE A TABLE</a>
                        </div>
                    </article>
                    
                    <?php if (get_theme_mod('si_enable_second_location', true)): ?>
                    <article class="location-card card-reverse">
                        <figure class="location-image-wrapper">
                            <img
                                src="<?php echo esc_url(wp_get_attachment_url(get_theme_mod('si_image_location_2', ''))); ?>"
                                alt="<?php esc_attr_e('Location 2', 'sports-illustrated'); ?>"
                                class="location-image"
                                loading="lazy" />
                        </figure>
                        <div class="location-details">
                            <div class="location-info">
                                <h2 class="location-name"><?php echo esc_html(get_theme_mod('si_location_2_name', 'SI CLUBHOUSE VANCOUVER')); ?></h2>
                                <p class="location-address"><?php echo esc_html(get_theme_mod('si_location_2_address', '3340 Shrum Lane, Vancouver')); ?></p>
                                <p class="location-hours"><?php echo esc_html(get_theme_mod('si_location_2_hours', 'Open | 11AM - 11PM Daily')); ?></p>
                                <p class="location-happy-hour"><?php echo esc_html(get_theme_mod('si_location_2_happy_hour', 'Daily Happy Hour 3:00 - 5:00 PM')); ?></p>
                            </div>
                            <a href="<?php echo esc_url(get_theme_mod('si_location_2_reservation_url', 'https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website')); ?>" class="reserve-button">RESERVE A TABLE</a>
                        </div>
                    </article>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="site-footer snap-section">
            <?php get_template_part('template-parts/footer'); ?>
        </footer>
    </div>
</main>

<?php wp_footer(); ?>