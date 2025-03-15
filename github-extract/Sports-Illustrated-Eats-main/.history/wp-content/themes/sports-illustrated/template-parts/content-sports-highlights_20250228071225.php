<?php
/**
 * Template part for displaying the sports highlights section
 *
 * @package Sports_Illustrated
 */
?>

<section class="sports-highlights">
    <div class="content-wrapper">
        <div class="main-column">
            <article class="highlight-content">
                <div class="content-container">
                    <div class="content-wrapper">
                        <div class="logo-column">
                            <?php
                            $logo_id = get_theme_mod('si_sports_logo');
                            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : get_theme_file_uri('assets/images/si-logo.png');
                            ?>
                            <img
                                src="<?php echo esc_url($logo_url); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo"
                                class="logo-image"
                            />
                        </div>
                        <div class="text-column">
                            <div class="text-content">
                                <h1 class="main-heading">
                                    NEVER MISS A MOMENT<br />
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
                    A DINING EXPERIENCE<br />
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
            <?php
            $feature_image_id = get_theme_mod('si_interior_image');
            $feature_image_url = $feature_image_id ? wp_get_attachment_image_url($feature_image_id, 'full') : get_theme_file_uri('assets/images/interior.jpg');
            ?>
            <img
                src="<?php echo esc_url($feature_image_url); ?>"
                alt="Sports Illustrated Clubhouse Interior"
                class="feature-image"
            />
        </div>
    </div>
</section> 