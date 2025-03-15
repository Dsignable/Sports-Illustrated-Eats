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

<!-- wp:cover {"dimRatio":0,"overlayColor":"background","minHeight":100,"minHeightUnit":"vh","isDark":false,"className":"site-background","style":{"position":{"all":"fixed"}}} -->
<div class="wp-block-cover is-light site-background" style="min-height:100vh">
    <img 
        class="wp-block-cover__image-background hero-background" 
        alt="Background image" 
        src="<?php echo esc_url(get_theme_file_uri('assets/images/hero-background.jpg')); ?>" 
        data-object-fit="cover"
    />
    <div class="wp-block-cover__inner-container"></div>
</div>
<!-- /wp:cover -->

<!-- wp:group {"tagName":"header","className":"hero-section","layout":{"type":"default"}} -->
<header class="wp-block-group hero-section">
    <!-- wp:group {"className":"navigation-bar","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
    <div class="wp-block-group navigation-bar">
        <!-- wp:site-logo {"className":"nav-logo","shouldSyncIcon":true} /-->

        <!-- wp:group {"className":"desktop-menu","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
        <div class="wp-block-group desktop-menu">
            <!-- wp:button {"className":"nav-button"} -->
            <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#menu">MENU</a></div>
            <!-- /wp:button -->

            <!-- wp:button {"className":"nav-button"} -->
            <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#book">BOOK NOW</a></div>
            <!-- /wp:button -->

            <!-- wp:button {"className":"nav-button"} -->
            <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#order">ORDER ONLINE</a></div>
            <!-- /wp:button -->

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

        <!-- wp:html -->
        <button class="hamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <!-- /wp:html -->
    </div>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->

<!-- wp:html -->
<nav class="mobile-menu" aria-label="Mobile menu">
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#menu">MENU</a></div>
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#book">BOOK NOW</a></div>
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#order">ORDER ONLINE</a></div>
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#events">PRIVATE EVENTS</a></div>
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#schedule">SPORTS SCHEDULE</a></div>
    <div class="wp-block-button nav-button"><a class="wp-block-button__link wp-element-button" href="#contact">CONTACT US</a></div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
});
</script>
<!-- /wp:html -->
