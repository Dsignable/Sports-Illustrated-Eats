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

<main id="primary" class="site-main home-page snap-scroll">
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
                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/happy-hour-menu.jpg'));?>"
                         alt="<?php esc_attr_e('Happy Hour Menu', 'sports-illustrated'); ?>"
                         class="menu-image"
                         loading="lazy"
                    />
                    <h2 class="menu-title">
                        <?php esc_html_e('HAPPY', 'sports-illustrated'); ?>
                        <br />
                        <?php esc_html_e('HOUR', 'sports-illustrated'); ?>
                    </h2>
                </a>
            </article>

            <!-- Fan Favorites Menu Card -->
            <article class="menu-card fan-favorites">
                <a href="<?php echo esc_url(si_get_menu_card_link('fan_favorites')); ?>" class="menu-card-content">

                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/fan-favorites-menu.jpg')); ?>"
                         alt="<?php esc_attr_e('Fan Favorites Menu', 'sports-illustrated'); ?>"
                         class="menu-image"
                         loading="lazy"
                    />

                    <h2 class="menu-title">
                        <?php esc_html_e('FAN', 'sports-illustrated'); ?>
                        <br />
                        <?php esc_html_e('FAVORITES', 'sports-illustrated'); ?>
                    </h2>
                </a>
            </article>

            <!-- Drinks & Cocktails Menu Card -->
            <article class="menu-card drinks-cocktails">
                <a href="<?php echo esc_url(si_get_menu_card_link('drinks_cocktails')); ?>" class="menu-card-content">
                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/drinks-cocktails.jpg')); ?>"
                         alt="<?php esc_attr_e('Drinks & Cocktails Menu', 'sports-illustrated'); ?>"
                         class="menu-image"
                         loading="lazy"
                    />
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

    <!-- Experience Section -->
    <div class="snap-section">
        <section class="experience-card">
            <?php 
            // Get the experience photos
            $top_photo_id = get_theme_mod('si_experience_top_photo');
            $bottom_photo_id = get_theme_mod('si_experience_bottom_photo');
            
            if ($top_photo_id) {
                $top_photo_url = wp_get_attachment_image_url($top_photo_id, 'large');
                echo '<img src="' . esc_url($top_photo_url) . '" alt="Experience Top" class="experience-photo-top">';
            }
            
            if ($bottom_photo_id) {
                $bottom_photo_url = wp_get_attachment_image_url($bottom_photo_id, 'large');
                echo '<img src="' . esc_url($bottom_photo_url) . '" alt="Experience Bottom" class="experience-photo-bottom">';
            }
            ?>

            <h1 class="brand-header">
                Sports
                <span class="brand-highlight">Illustrated</span>
                <br />
                Clubhouse
            </h1>

            <article class="content-container">
                <h2 class="content-title">A DINING EXPERIENCE LIKE NO OTHER</h2>

                <div class="content-body">
                    <p class="description">
                        At Sports Illustrated Clubhouse, we bring the excitement of the game to
                        your table with a menu crafted to satisfy every craving. Our signature
                        dishes are inspired by the energy and spirit of sports, blending bold
                        flavors with fresh, locally sourced ingredients. Whether you're catching
                        the big game with friends or celebrating a special occasion, our menu
                        features a lineup of winning options that include sizzling burgers,
                        hand-crafted pizzas, zesty wings, and fresh, crisp salads. Every dish is
                        designed to make your taste buds cheer, from classic comfort foods to
                        innovative culinary creations.
                    </p>

                    <p class="description-secondary">
                        Pair your meal with our selection of specialty cocktails, craft beers,
                        and refreshing mocktails, all served in an inviting atmosphere that
                        celebrates the history and culture of sports.
                    </p>

                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>" class="gallery-button">SEE GALLERY</a>
                </div>
            </article>
        </section>
    </div>
    
    <!-- Sports Highlights Section -->
    <div class="snap-section">
        <section class="sports-highlights">
            <div class="content-wrapper">

                <div class="highlight-content">
                    <div class="top-section">
                        <img
                            src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/plates-left.png')); ?>"
                            alt="Plate Left"
                            class="left-image"
                        />
                        <div class="text-content">
                            <h1 class="main-heading">
                                NEVER MISS A MOMENT<br/>
                                AT YOUR HOME AWAY FROM HOME
                            </h1>
                            <p class="description">
                                The Sports Illustrated Clubhouse interior is a celebration of
                                sports culture, blending sophistication with a vibrant,
                                game-day atmosphere. From the moment you walk in, you're
                                surrounded by iconic memorabilia, larger-than-life murals of
                                legendary athletes, and screens broadcasting the biggest
                                moments in sports history. The design seamlessly merges modern
                                elegance with a love for the game, featuring sleek lines, warm
                                wood accents, and dynamic lighting that creates the perfect
                                ambiance for every occasion.
                            </p>
                        </div>
                    </div>

                    <div class="bottom-section">
                        <div class="text-content">
                            <h2 class="secondary-heading">
                                A DINING EXPERIENCE<br />
                                LIKE NO OTHER
                            </h2>
                            <p class="secondary-description">
                                At the Sports Illustrated Clubhouse, we bring the excitement of the game
                                to your table with a menu crafted to satisfy every craving. Our
                                signature dishes are inspired by the energy and spirit of sports,
                                blending bold flavors with fresh, locally sourced ingredients. Whether
                                you're catching the big game with friends or celebrating a special
                                occasion, our menu features a lineup of winning options that include
                                sizzling burgers, hand-crafted pizzas, zesty wings, and fresh, crisp
                                salads.
                            </p>
                        </div>
                        <img
                            src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/plate-right.png')); ?>"
                            alt="Plate Right"
                            class="right-image"
                        />
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Locations Section -->
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
                        <a href="https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website" class="reserve-button">RESERVE A TABLE</a>
                    </div>
                </article>
                <article class="location-card card-reverse">
                <figure class="location-image-wrapper">
                        <img
                            src="<?php echo esc_url(si_get_image_url('si_image_location_2', get_theme_file_uri('assets/images/locations/vancouver2.jpg'))); ?>"
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
                        <a href="https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website" class="reserve-button">RESERVE A TABLE</a>
                    </div>
                  
                </article>
            </div>
        </section>
    </div>

    <?php get_footer(); ?>

<?php wp_footer(); ?>


</main>


