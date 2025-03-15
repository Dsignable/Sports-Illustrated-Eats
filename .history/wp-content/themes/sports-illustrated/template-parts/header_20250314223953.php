<?php

/**
 * Header template part
 *
 * @package Sports_Illustrated
 */
?>

<header id="masthead" class="site-header">
    <div class="navigation-bar">
        <!-- Mobile Menu Button -->
        <button class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Desktop Navigation - Left Menu -->
        <nav class="desktop-menu left-menu">
            <?php
            // Left Menu Items
            for ($i = 1; $i <= 3; $i++) {
                if (get_theme_mod('si_left_menu_visible_' . $i, true)) {
                    $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
                    $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
                    echo '<a href="' . esc_url($menu_url) . '" class="nav-button">' . esc_html($menu_text) . '</a>';
                }
            }
            ?>
        </nav>

        <!-- Logo -->
        <div class="site-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">';
                echo '<img src="' . esc_url(get_theme_file_uri('assets/images/logo.png')) . '" alt="' . get_bloginfo('name') . '" class="custom-logo">';
                echo '</a>';
            }
            ?>
        </div>

        <!-- Desktop Navigation - Right Menu -->
        <nav class="desktop-menu right-menu">
            <?php
            // Right Menu Items
            for ($i = 1; $i <= 3; $i++) {
                $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);

                if ($menu_visible && $menu_text) {
                    echo '<a href="' . esc_url($menu_url) . '" class="nav-button">' . esc_html($menu_text) . '</a>';
                }
            }
            ?>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <?php
        // Left menu items
        for ($i = 1; $i <= 3; $i++) {
            if (get_theme_mod('si_left_menu_visible_' . $i, true)) {
                $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
                $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
                echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
            }
        }

        // Right menu items
        for ($i = 1; $i <= 3; $i++) {
            $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
            $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
            $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);

            if ($menu_visible && $menu_text) {
                echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
            }
        }

        // Additional mobile menu items
        ?>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>">GIFT CARDS</a>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>">GALLERY</a>
    </div>
</header>
</div>