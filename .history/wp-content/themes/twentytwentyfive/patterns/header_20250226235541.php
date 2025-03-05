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

<style>
/* Direct button overrides */
.wp-block-button__link,
.wp-element-button,
a.wp-element-button {
    background: transparent !important;
    background-color: transparent !important;
    color: #FFFFFF !important;
    border: none !important;
    padding: 9px 30px !important;
    min-width: 150px !important;
    font-family: 'Solano Gothic MVB', -apple-system, Roboto, Helvetica, sans-serif !important;
    font-size: 20px !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    letter-spacing: 2px !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
    border-radius: 100px !important;
}

.wp-block-button__link:hover,
.wp-element-button:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
}

/* Navigation specific styles */
.navigation-bar {
    background: rgba(0, 0, 0, 0.3) !important;
}

.desktop-menu {
    display: flex;
    justify-content: center;
    gap: 33px;
    flex: 1;
}

.nav-logo {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: auto;
}
</style>

<div class="site-background">
    <div class="hero-background"></div>
</div>

<div class="hero-section">
    <div class="navigation-bar">
        <nav class="desktop-menu">
            <a href="#menu" class="wp-element-button" style="background: transparent; color: #FFFFFF;">MENU</a>
            <a href="#book" class="wp-element-button" style="background: transparent; color: #FFFFFF;">BOOK NOW</a>
            <a href="#order" class="wp-element-button" style="background: transparent; color: #FFFFFF;">ORDER ONLINE</a>
            <a href="#events" class="wp-element-button" style="background: transparent; color: #FFFFFF;">PRIVATE EVENTS</a>
            <a href="#schedule" class="wp-element-button" style="background: transparent; color: #FFFFFF;">SPORTS SCHEDULE</a>
            <a href="#contact" class="wp-element-button" style="background: transparent; color: #FFFFFF;">CONTACT US</a>
        </nav>

        <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" alt="Sports Illustrated Logo" class="nav-logo">
        
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<div class="mobile-menu">
    <a href="#menu" class="wp-element-button" style="background: transparent; color: #FFFFFF;">MENU</a>
    <a href="#book" class="wp-element-button" style="background: transparent; color: #FFFFFF;">BOOK NOWS</a>
    <a href="#order" class="wp-element-button" style="background: transparent; color: #FFFFFF;">ORDER ONLINE</a>
    <a href="#events" class="wp-element-button" style="background: transparent; color: #FFFFFF;">PRIVATE EVENTS</a>
    <a href="#schedule" class="wp-element-button" style="background: transparent; color: #FFFFFF;">SPORTS SCHEDULE</a>
    <a href="#contact" class="wp-element-button" style="background: transparent; color: #FFFFFF;">CONTACT US</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-menu .wp-element-button');

    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
    });

    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
        });
    });
});
</script>
