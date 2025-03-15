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
                $has_dropdown = get_theme_mod('si_left_menu_has_dropdown_' . $i, $i == 1);
                    
                    // Special handling for Menu dropdown
                    if ($has_dropdown) {
                        // Get the menu page URL properly
                        $menu_page = get_page_by_path('menu');
                        $menu_url = $menu_page ? get_permalink($menu_page) : home_url('/menu/');
                        
                        // Ensure we have a valid menu page ID for the query args
                        $menu_page_id = $menu_page ? $menu_page->ID : null;

                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        // Menu dropdown items
                        $menu_types = array(
                            'full' => 'Full Menu',
                            'drink' => 'Drink Menu',
                            'brunch' => 'Brunch Menu',
                            'happy' => 'Happy Hour',
                            'today' => 'Today\'s Menu'
                        );
                        
                        foreach ($menu_types as $key => $default_label) {
                            // Get customized text from theme mod, fallback to default
                            $label = get_theme_mod('si_menu_dropdown_text_' . $key, $default_label);
                            
                            // Get the custom URL directly from theme mod
                            $menu_url = get_theme_mod('si_menu_dropdown_url_' . $key, '');
                            
                            // If URL is empty, use default URL structure
                            if (empty($menu_url)) {
                                // If we have a menu page ID, use it in the URL
                                if ($menu_page_id) {
                                    $menu_url = add_query_arg(array(
                                        'page_id' => $menu_page_id,
                                        'menu' => $key
                                    ), home_url('/'));
                                } else {
                                    // Fallback to clean URLs
                                    $menu_url = add_query_arg('menu', $key, home_url('/menu/'));
                                }
                            }
                            
                            echo '<a href="' . esc_url($menu_url) . '" class="dropdown-item" data-menu-type="' . esc_attr($key) . '">' . esc_html($label) . '</a>';
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
                    
                    // First, try to find a page with slug 'club-news' (highest priority)
                    $news_page = get_page_by_path('club-news');
                    if ($news_page) {
                        $menu_url = get_permalink($news_page->ID);
                    } else {
                        // Try the posts page setting
                        $posts_page_id = get_option('page_for_posts');
                        if ($posts_page_id) {
                            $menu_url = get_permalink($posts_page_id);
                        } else {
                            // Try original 'news' slug as fallback
                            $news_page = get_page_by_path('news');
                            if ($news_page) {
                                $menu_url = get_permalink($news_page->ID);
                            } else {
                                // Final fallback
                                $menu_url = home_url('/club-news/');
                            }
                        }
                    }
                } else {
                    $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/club-news/') : ($i == 3 ? home_url('/contact/') : '')));
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
                        // Get the menu page URL properly
                        $menu_page = get_page_by_path('menu');
                        $menu_url = $menu_page ? get_permalink($menu_page) : home_url('/menu/');
                        
                        // Ensure we have a valid menu page ID for the query args
                        $menu_page_id = $menu_page ? $menu_page->ID : null;

                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="has-dropdown">' . esc_html($menu_text) . '</a>';
                        echo '<div class="menu-dropdown">';
                        // Menu dropdown items
                        $menu_types = array(
                            'full' => 'Full Menu',
                            'drink' => 'Drink Menu',
                            'brunch' => 'Brunch Menu',
                            'happy' => 'Happy Hour',
                            'today' => 'Today\'s Menu'
                        );
                        
                        foreach ($menu_types as $key => $default_label) {
                            // Get customized text from theme mod, fallback to default
                            $label = get_theme_mod('si_menu_dropdown_text_' . $key, $default_label);
                            
                            // Get the custom URL directly from theme mod
                            $menu_url = get_theme_mod('si_menu_dropdown_url_' . $key, '');
                            
                            // If URL is empty, use default URL structure
                            if (empty($menu_url)) {
                                // If we have a menu page ID, use it in the URL
                                if ($menu_page_id) {
                                    $menu_url = add_query_arg(array(
                                        'page_id' => $menu_page_id,
                                        'menu' => $key
                                    ), home_url('/'));
                                } else {
                                    // Fallback to clean URLs
                                    $menu_url = add_query_arg('menu', $key, home_url('/menu/'));
                                }
                            }
                            
                            echo '<a href="' . esc_url($menu_url) . '" class="dropdown-item" data-menu-type="' . esc_attr($key) . '">' . esc_html($label) . '</a>';
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
                    
                    // First, try to find a page with slug 'club-news' (highest priority)
                    $news_page = get_page_by_path('club-news');
                    if ($news_page) {
                        $menu_url = get_permalink($news_page->ID);
                    } else {
                        // Try the posts page setting
                        $posts_page_id = get_option('page_for_posts');
                        if ($posts_page_id) {
                            $menu_url = get_permalink($posts_page_id);
                        } else {
                            // Try original 'news' slug as fallback
                            $news_page = get_page_by_path('news');
                            if ($news_page) {
                                $menu_url = get_permalink($news_page->ID);
                            } else {
                                // Final fallback
                                $menu_url = home_url('/club-news/');
                            }
                        }
                    }
                } else {
                    $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/club-news/') : ($i == 3 ? home_url('/contact/') : '')));
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