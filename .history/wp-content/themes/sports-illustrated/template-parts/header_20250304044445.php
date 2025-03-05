<?php
/**
 * Header template part
 *
 * @package Sports_Illustrated
 */
?>

<header class="site-header">
    <div class="navigation-bar">
        <!-- Mobile Menu Button -->
        <button type="button" class="hamburger" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <!-- Desktop Navigation -->
        <nav class="desktop-menu left-menu">
            <a href="<?php echo esc_url(si_get_menu_url()); ?>" class="nav-button">MENU</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('reservations'))); ?>" class="nav-button">RESERVATIONS</a>
            <a href="https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw" class="nav-button">ORDER ONLINE</a>
        </nav>
        
        <!-- Logo -->
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

        <!-- Desktop Navigation -->
        <nav class="desktop-menu right-menu">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" class="nav-button">NEWS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>" class="nav-button">CAREERS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-button">CONTACT US</a>
        </nav>
    </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="mobile-menu" aria-hidden="true">
    <a href="<?php echo esc_url(si_get_menu_url()); ?>">MENU</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('reservations'))); ?>">RESERVATIONS</a>
    <a href="https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw">ORDER ONLINE</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>">NEWS</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>">CAREERS</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>">CONTACT US</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>">GIFT CARDS</a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>">GALLERY</a>
</div> 