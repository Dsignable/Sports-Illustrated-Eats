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

    <section class="menu-items snap-section">
        <article class="menu-card happy-hour">
            <a href="<?php echo esc_url(si_get_menu_url('happy')); ?>" class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/happy-hour-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Happy Hour Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                    loading="lazy"
                />
                <h2 class="menu-title happy-hour-title">
                    <?php esc_html_e('HAPPY', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('HOUR', 'sports-illustrated'); ?>
                </h2>
            </a>
        </article>

        <article class="menu-card fan-favorites">
            <a href="<?php echo esc_url(si_get_menu_url('today')); ?>" class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/fan-favorites-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Fan Favorites Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                    loading="lazy"
                />
                <h2 class="menu-title fan-favorites-title">
                    <?php esc_html_e('FAN', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('FAVORITES', 'sports-illustrated'); ?>
                </h2>
            </a>
        </article>

        <article class="menu-card drinks-cocktails">
            <a href="<?php echo esc_url(si_get_menu_url('drink')); ?>" class="menu-card-content">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/modified/drinks-cocktails-menu.jpg')); ?>"
                    alt="<?php esc_attr_e('Drinks & Cocktails Menu', 'sports-illustrated'); ?>"
                    class="menu-image"
                    loading="lazy"
                />
                <h2 class="menu-title drinks-cocktails-title">
                    <?php esc_html_e('DRINKS &', 'sports-illustrated'); ?>
                    <br />
                    <?php esc_html_e('COCKTAILS', 'sports-illustrated'); ?>
                </h2>
            </a>
        </article>
    </section>

    <article class="experience-card snap-section">
        <header class="brand-header">
            Sports
            <span class="brand-highlight">Illustrated</span>
            <br />
            Clubhouse
        </header>

        <section class="content-wrapper">
            <h1 class="experience-title">A DINING EXPERIENCE LIKE NO OTHER</h1>

            <div class="content-container">
                <p class="experience-description">
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

                <p class="experience-subtitle">
                    Pair your meal with our selection of specialty cocktails, craft beers,
                    and refreshing mocktails, all served in an inviting atmosphere that
                    celebrates the history and culture of sports.
                </p>

                <button class="gallery-button">SEE GALLERY</button>
            </div>
        </section>
    </article>

    <section class="sports-highlights snap-section">
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
                                <div class="text-content">
                                    <h1 class="main-heading">
                                        NEVER MISS A MOMENT
                                        <br />
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
                        </div>
                    </div>
                    <h2 class="secondary-heading">
                        A DINING EXPERIENCE
                        <br />
                        LIKE NO OTHER
                    </h2>
                    <p class="secondary-description">
                        At Sports Illustrated Clubhouse, we bring the excitement of the game
                        to your table with a menu crafted to satisfy every craving. Our
                        signature dishes are inspired by the energy and spirit of sports,
                        blending bold flavors with fresh, locally sourced ingredients. Whether
                        you're catching the big game with friends or celebrating a special
                        occasion, our menu features a lineup of winning options that include
                        sizzling burgers, hand-crafted pizzas, zesty wings, and fresh, crisp
                        salads.
                    </p>
                </article>
            </div>
            <div class="image-column">
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/interior.jpg')); ?>"
                    alt="Sports Illustrated Clubhouse Interior"
                    class="feature-image"
                />
            </div>
        </div>
    </section>
</main>
<?php
get_footer(); 