<?php
/**
 * Footer template part
 *
 * @package Sports_Illustrated
 */
?>

<footer class="site-footer">
    <div class="footer-container">
        <nav class="primary-nav">
            <a href="<?php echo esc_url(si_get_menu_url()); ?>" class="nav-button">MENUS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('locations'))); ?>" class="nav-button">LOCATIONS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('reservations'))); ?>" class="nav-button">RESERVATIONS</a>
            
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" 
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                     class="footer-logo">
            <?php endif; ?>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="nav-button">ABOUT SI</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-button">CONTACT</a>
            <a href="https://www.instagram.com/si_clubhouse/" target="_blank" rel="noopener noreferrer" class="nav-button social-icon">
                <i class="fab fa-instagram"></i>
                <span class="sr-only">Follow us on Instagram</span>
            </a>
        </nav>

        <div class="footer-bottom">
            <div class="footer-info">
                <p class="address">3340 SHRUM LANE | VANCOUVER, BC</p>
                <p class="copyright">COPYRIGHT <?php echo date('Y'); ?></p>
            </div>
            <div class="footer-links">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>" class="footer-button">GIFT CARDS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>" class="footer-button">CAREERS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" class="footer-button">TERMS & CONDITIONS</a>
            </div>
        </div>
    </div>
</footer> 