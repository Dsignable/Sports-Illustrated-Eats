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
        <button type="button" class="hamburger" aria-label="Menu">
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
                    if ($i === 1) {
                        // Always use clean menu URL
                        $menu_url = home_url('/menu/');

                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        
                        // Get menu types from customizer or use defaults
                        $menu_types = array(
                            'full' => get_theme_mod('si_menu_dropdown_full_text', 'Full Menu'),
                            'drink' => get_theme_mod('si_menu_dropdown_drink_text', 'Drink Menu'),
                            'brunch' => get_theme_mod('si_menu_dropdown_brunch_text', 'Brunch Menu'),
                            'happy' => get_theme_mod('si_menu_dropdown_happy_text', 'Happy Hour'),
                            'today' => get_theme_mod('si_menu_dropdown_today_text', 'Today\'s Menu')
                        );
                        
                        foreach ($menu_types as $key => $label) {
                            // Always use clean URLs with menu parameter
                            $menu_url = add_query_arg('menu', $key, home_url('/menu/'));
                            $menu_visible = get_theme_mod('si_menu_dropdown_' . $key . '_visible', true);
                            
                            if ($menu_visible) {
                                echo '<a href="' . esc_url($menu_url) . '" class="dropdown-item" data-menu-type="' . esc_attr($key) . '">' . esc_html($label) . '</a>';
                            }
                        }
                        echo '</div></div>';
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
            <?php
            // Right Menu Items
            for ($i = 1; $i <= 3; $i++) {
                $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                
                // Special handling for News button to always point to the posts page
                if ($i == 2) { // News button
                    // Try multiple methods to get the news page URL
                    $posts_page_id = get_option('page_for_posts');
                    if ($posts_page_id) {
                        $menu_url = get_permalink($posts_page_id);
                    } else {
                        // Try to find a page with slug 'news'
                        $news_page = get_page_by_path('news');
                        if ($news_page) {
                            $menu_url = get_permalink($news_page->ID);
                        } else {
                            // Final fallback
                            $menu_url = home_url('/news/');
                        }
                    }
                } else {
                    $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                }
                
                $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);
                $has_dropdown = get_theme_mod('si_right_menu_has_dropdown_' . $i, $i == 3);

                if ($menu_visible && $menu_text) {
                    if ($has_dropdown) {
                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        // Dropdown items
                        for ($j = 1; $j <= 5; $j++) {
                            $dropdown_text = get_theme_mod('si_right_menu_dropdown_' . $i . '_text_' . $j, '');
                            $dropdown_url = get_theme_mod('si_right_menu_dropdown_' . $i . '_url_' . $j, '');
                            $dropdown_visible = get_theme_mod('si_right_menu_dropdown_' . $i . '_visible_' . $j, false);
                            
                            if ($dropdown_visible && $dropdown_text) {
                                echo '<a href="' . esc_url($dropdown_url) . '" class="dropdown-item">' . esc_html($dropdown_text) . '</a>';
                            }
                        }
                        echo '</div></div>';
                    } else {
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button">' . esc_html($menu_text) . '</a>';
                    }
                }
            }
            ?>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="mobile-menu">
        <div class="mobile-menu-inner">
            <?php
            // Left menu items with dropdowns
            for ($i = 1; $i <= 3; $i++) {
                if (get_theme_mod('si_left_menu_visible_' . $i, true)) {
                    $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
                    $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
                    
                    // Special handling for Menu dropdown
                    if ($i === 1) {
                        // Always use clean menu URL
                        $menu_url = home_url('/menu/');

                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        
                        // Get menu types from customizer or use defaults
                        $menu_types = array(
                            'full' => get_theme_mod('si_menu_dropdown_full_text', 'Full Menu'),
                            'drink' => get_theme_mod('si_menu_dropdown_drink_text', 'Drink Menu'),
                            'brunch' => get_theme_mod('si_menu_dropdown_brunch_text', 'Brunch Menu'),
                            'happy' => get_theme_mod('si_menu_dropdown_happy_text', 'Happy Hour'),
                            'today' => get_theme_mod('si_menu_dropdown_today_text', 'Today\'s Menu')
                        );
                        
                        foreach ($menu_types as $key => $label) {
                            // Always use clean URLs with menu parameter
                            $menu_url = add_query_arg('menu', $key, home_url('/menu/'));
                            $menu_visible = get_theme_mod('si_menu_dropdown_' . $key . '_visible', true);
                            
                            if ($menu_visible) {
                                echo '<a href="' . esc_url($menu_url) . '" class="dropdown-item" data-menu-type="' . esc_attr($key) . '">' . esc_html($label) . '</a>';
                            }
                        }
                        echo '</div></div>';
                    } else {
                        echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
                    }
                }
            }

            // Right menu items with dropdowns
            for ($i = 1; $i <= 3; $i++) {
                $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                
                // Special handling for News button to always point to the posts page
                if ($i == 2) { // News button
                    // Try multiple methods to get the news page URL
                    $posts_page_id = get_option('page_for_posts');
                    if ($posts_page_id) {
                        $menu_url = get_permalink($posts_page_id);
                    } else {
                        // Try to find a page with slug 'news'
                        $news_page = get_page_by_path('news');
                        if ($news_page) {
                            $menu_url = get_permalink($news_page->ID);
                        } else {
                            // Final fallback
                            $menu_url = home_url('/news/');
                        }
                    }
                } else {
                    $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                }
                
                $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);
                $has_dropdown = get_theme_mod('si_right_menu_has_dropdown_' . $i, $i == 3);

                if ($menu_visible && $menu_text) {
                    if ($has_dropdown) {
                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        // Dropdown items
                        for ($j = 1; $j <= 5; $j++) {
                            $dropdown_text = get_theme_mod('si_right_menu_dropdown_' . $i . '_text_' . $j, '');
                            $dropdown_url = get_theme_mod('si_right_menu_dropdown_' . $i . '_url_' . $j, '');
                            $dropdown_visible = get_theme_mod('si_right_menu_dropdown_' . $i . '_visible_' . $j, false);
                            
                            if ($dropdown_visible && $dropdown_text) {
                                echo '<a href="' . esc_url($dropdown_url) . '" class="dropdown-item">' . esc_html($dropdown_text) . '</a>';
                            }
                        }
                        echo '</div></div>';
                    } else {
                        echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
                    }
                }
            }

            // Additional mobile menu items
            ?>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('gift-cards'))); ?>">GIFT CARDS</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>">GALLERY</a>
        </div>
    </nav>
</header>
</div>