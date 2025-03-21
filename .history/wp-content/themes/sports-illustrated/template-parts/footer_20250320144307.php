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
            <!-- <div class="nav-links">
                <a href="<?php echo esc_url(si_get_menu_url()); ?>" class="nav-button">MENUS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('reservations'))); ?>" class="nav-button">RESERVATIONS</a>
                <a href="https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw" target="_blank" rel="noopener noreferrer" class="nav-button">ORDER ONLINE</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" class="nav-button">NEWS</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-button">CONTACT</a>
            </div> -->
            <div class="social-links">
                <?php
                // Loop through social media platforms
                for ($i = 1; $i <= 5; $i++) {
                    $platform = get_theme_mod('si_social_platform_' . $i, $i === 1 ? 'instagram' : '');
                    $url = get_theme_mod('si_social_url_' . $i, $i === 1 ? 'https://instagram.com/sportsillustrated' : '');
                    $visible = get_theme_mod('si_social_visible_' . $i, $i === 1);

                    if ($visible && $platform && $url) {
                        $icon_class = '';
                        switch ($platform) {
                            case 'instagram':
                                $icon_class = 'fab fa-instagram';
                                break;
                            case 'facebook':
                                $icon_class = 'fab fa-facebook-f';
                                break;
                            case 'twitter':
                                $icon_class = 'fab fa-x-twitter';
                                break;
                            case 'tiktok':
                                $icon_class = 'fab fa-tiktok';
                                break;
                            case 'youtube':
                                $icon_class = 'fab fa-youtube';
                                break;
                        }
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="nav-button social-icon">
                            <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <span class="sr-only">Follow us on <?php echo esc_html(ucfirst($platform)); ?></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
        </nav>

        <div class="footer-bottom">
            <div class="footer-links">
                <?php
                // Loop through footer links
                for ($i = 1; $i <= 4; $i++) {
                    $link_visible = get_theme_mod('si_footer_link' . $i . '_visible', true);

                    if ($link_visible) {
                        $link_text = get_theme_mod('si_footer_link' . $i . '_text', '');
                        $link_page = get_theme_mod('si_footer_link' . $i . '_page', '');

                        if (!empty($link_text) && !empty($link_page)) {
                            $page = get_page_by_path($link_page);
                            $url = $page ? get_permalink($page) : '#';
                            echo '<a href="' . esc_url($url) . '" class="footer-button">' . esc_html($link_text) . '</a>';
                        }
                    }
                }
                ?>
            </div>
            <div class="footer-info">
                <p class="address"><?php echo esc_html(get_theme_mod('si_footer_address', '3340 SHRUM LANE | VANCOUVER, BC')); ?></p>
                <p class="copyright">SPORTS ILLUSTRATED TM is a trademark of ABG-SI LLC.</p>
                <p class="copyright">© <?php echo date('Y'); ?> ABG-SI LLC.</p>
                <a href="https://dsignable.com" target="_blank" rel="noopener noreferrer" class="creator-credit">Created with love by Team Dsignable</a>
            </div>
        </div>
    </div>
</footer>