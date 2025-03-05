<?php
/**
 * Title: Header
 * Slug: twentytwentyfive/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with site title and navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */
?>

<!-- wp:group {"tagName":"header","className":"hero-section","layout":{"type":"default"}} -->
<header class="wp-block-group hero-section">
    <!-- wp:cover {"dimRatio":0,"overlayColor":"background","minHeight":100,"minHeightUnit":"vh","isDark":false,"style":{"position":{"all":"fixed"}}} -->
    <div class="wp-block-cover is-light" style="min-height:100vh">
        <img 
            class="wp-block-cover__image-background hero-background" 
            alt="Background image" 
            src="<?php echo esc_url(get_theme_file_uri('assets/images/hero-background.jpg')); ?>" 
            data-object-fit="cover"
        />
        <div class="wp-block-cover__inner-container">
            <!-- wp:group {"className":"navigation-bar","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
            <div class="wp-block-group navigation-bar">
                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#menu">MENU</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#book">BOOK NOW</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#order">ORDER ONLINE</a></div>
                <!-- /wp:button -->

                <!-- wp:site-logo {"className":"nav-logo","shouldSyncIcon":true} /-->

                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#events">PRIVATE EVENTS</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#schedule">SPORTS SCHEDULE</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"nav-button"} -->
                <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#contact">CONTACT US</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:group -->
        </div>
    </div>
    <!-- /wp:cover -->
</header>
<!-- /wp:group -->
