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

<div class="site-background">
    <div class="hero-background"></div>
</div>

<div class="hero-section">
    <div class="navigation-bar">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Sports Illustrated Logo" class="nav-logo">
        
        <nav class="desktop-menu">
            <a href="#menu" class="wp-element-button">MENU</a>
            <a href="#book" class="wp-element-button">BOOK NOW</a>
            <a href="#order" class="wp-element-button">ORDER ONLINE</a>
            <a href="#events" class="wp-element-button">PRIVATE EVENTS</a>
            <a href="#schedule" class="wp-element-button">SPORTS SCHEDULE</a>
            <a href="#contact" class="wp-element-button">CONTACT US</a>
        </nav>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<div class="mobile-menu">
    <a href="#menu" class="wp-element-button">MENU</a>
    <a href="#book" class="wp-element-button">BOOK NOW</a>
    <a href="#order" class="wp-element-button">ORDER ONLINE</a>
    <a href="#events" class="wp-element-button">PRIVATE EVENTS</a>
    <a href="#schedule" class="wp-element-button">SPORTS SCHEDULE</a>
    <a href="#contact" class="wp-element-button">CONTACT US</a>
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
