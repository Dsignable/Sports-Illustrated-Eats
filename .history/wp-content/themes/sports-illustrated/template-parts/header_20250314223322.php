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
        <button type="button" class="hamburger" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
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
                    
                    // Special handling for Menu dropdown
                    if ($i == 1 && $menu_text == 'MENU' && get_theme_mod('si_enable_menu_dropdown', true)) {
                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button has-dropdown">' . esc_html($menu_text) . ' <span class="dropdown-arrow">▼</span></a>';
                        echo '<div class="menu-dropdown">';
                        
                        // Menu types and their labels
                        $menu_types = array(
                            'full' => 'FULL MENU',
                            'drink' => 'DRINK MENU',
                            'brunch' => 'BRUNCH MENU',
                            'happy' => 'HAPPY HOUR',
                            'today' => 'TODAY\'S MENU'
                        );
                        
                        foreach ($menu_types as $type => $label) {
                            $menu_url = get_theme_mod("si_menu_dropdown_url_{$type}", home_url('/menu/?menu=' . $type));
                            echo '<a href="' . esc_url($menu_url) . '" class="dropdown-item">' . esc_html($label) . '</a>';
                        }
                        
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button">' . esc_html($menu_text) . '</a>';
                    }
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
            <?php for ($i = 1; $i <= 3; $i++) :
                $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);

                if ($menu_visible && $menu_text) : ?>
                    <a href="<?php echo esc_url($menu_url); ?>" class="nav-button"><?php echo esc_html($menu_text); ?></a>
            <?php endif;
            endfor; ?>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-inner">
            <?php
            // Left menu items
            for ($i = 1; $i <= 3; $i++) {
                if (get_theme_mod('si_left_menu_visible_' . $i, true)) {
                    $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
                    $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
                    
                    // Special handling for Menu dropdown
                    if ($i == 1 && $menu_text == 'MENU' && get_theme_mod('si_enable_menu_dropdown', true)) {
                        echo '<div class="menu-item-has-children">';
                        echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
                        
                        // Menu types and their labels
                        $menu_types = array(
                            'full' => 'FULL MENU',
                            'drink' => 'DRINK MENU',
                            'brunch' => 'BRUNCH MENU',
                            'happy' => 'HAPPY HOUR',
                            'today' => 'TODAY\'S MENU'
                        );
                        
                        foreach ($menu_types as $type => $label) {
                            $menu_url = get_theme_mod("si_menu_dropdown_url_{$type}", home_url('/menu/?menu=' . $type));
                            echo '<a href="' . esc_url($menu_url) . '" class="mobile-submenu-item">' . esc_html($label) . '</a>';
                        }
                        
                        echo '</div>';
                    } else {
                        echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
                    }
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
    </div>
</header>
</div>