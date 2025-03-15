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
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('reservations'))); ?>" class="nav-button">RESERVATIONS</a>
            <a href="https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw" target="_blank" rel="noopener noreferrer" class="nav-button">ORDER ONLINE</a>
   
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" class="nav-button">NEWS</a>
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
                <a href="https://dsignable.com" target="_blank" rel="noopener noreferrer" class="creator-credit">Created with ❤️ by Dsignable LLC</a>
            </div>
            <div class="footer-links">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>" class="footer-button">GIFT CARDS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>" class="footer-button">GALLERY</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>" class="footer-button">CAREERS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" class="footer-button">TERMS & CONDITIONS</a>
            </div>
        </div>
    </div>
</footer> 