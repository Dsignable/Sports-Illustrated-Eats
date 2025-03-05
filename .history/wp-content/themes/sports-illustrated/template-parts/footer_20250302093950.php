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
            <a href="https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website" class="nav-button" target="_blank" rel="noopener noreferrer">RESERVATIONS</a>
            
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" 
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                     class="footer-logo">
            <?php endif; ?>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>" class="nav-button">GIFT CARDS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="nav-button">ABOUT SI</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-button">CONTACT</a>
        </nav>

        <div class="footer-bottom">
            <div class="footer-info">
                <p class="address">3340 SHRUM LANE | VANCOUVER, BC</p>
                <p class="copyright">COPYRIGHT <?php echo date('Y'); ?></p>
            </div>
            <div class="footer-links">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>" class="footer-button">CAREERS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" class="footer-button">PRIVACY POLICY</a>
            </div>
        </div>
    </div>
</footer> 