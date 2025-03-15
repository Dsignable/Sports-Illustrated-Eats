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
            <a href="<?php echo esc_url(si_get_menu_url()); ?>" class="nav-button">MENU</a>
            <a href="#book" class="nav-button">BOOK NOW</a>
            <a href="#order" class="nav-button">ORDER ONLINE</a>
        </nav>

        <div class="site-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
                    <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" 
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                         class="custom-logo">
                </a>
                <?php
            }
            ?>
        </div>

        <nav class="desktop-menu">
            <a href="#events" class="nav-button">PRIVATE EVENTS</a>
            <a href="#schedule" class="nav-button">SPORTS SCHEDULE</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-button">CONTACT US</a>
        </nav>

        <button class="hamburger" aria-label="Toggle mobile menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<nav class="mobile-menu">
    <a href="<?php echo esc_url(si_get_menu_url()); ?>">MENU</a>
    <a href="#book">BOOK NOW</a>
    <a href="#order">ORDER ONLINE</a>
    <a href="#events">PRIVATE EVENTS</a>
    <a href="#schedule">SPORTS SCHEDULE</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>">CONTACT US</a>
</nav> 