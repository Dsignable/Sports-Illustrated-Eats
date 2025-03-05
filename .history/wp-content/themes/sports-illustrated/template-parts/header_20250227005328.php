<?php
/**
 * Header template part
 *
 * @package Sports_Illustrated
 */
?>

<header class="site-header">
    <div class="navigation-bar">
        <nav class="desktop-menu">
            <a href="#menu" class="nav-button">MENU</a>
            <a href="#book" class="nav-button">BOOK NOW</a>
            <a href="#order" class="nav-button">ORDER ONLINE</a>
        </nav>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" 
                 alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                 width="60" height="60">
        </a>

        <nav class="desktop-menu">
            <a href="#events" class="nav-button">PRIVATE EVENTS</a>
            <a href="#schedule" class="nav-button">SPORTS SCHEDULE</a>
            <a href="#contact" class="nav-button">CONTACT US</a>
        </nav>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="mobile-menu">
        <a href="#menu" class="nav-button">MENU</a>
        <a href="#book" class="nav-button">BOOK NOW</a>
        <a href="#order" class="nav-button">ORDER ONLINE</a>
        <a href="#events" class="nav-button">PRIVATE EVENTS</a>
        <a href="#schedule" class="nav-button">SPORTS SCHEDULE</a>
        <a href="#contact" class="nav-button">CONTACT US</a>
    </div>
</header> 