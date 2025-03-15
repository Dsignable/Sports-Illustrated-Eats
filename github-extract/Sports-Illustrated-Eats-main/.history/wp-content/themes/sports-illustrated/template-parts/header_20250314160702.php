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
                        
                        // Get menu page ID
                        $menu_page = get_page_by_path('menu');
                        $menu_page_id = $menu_page ? $menu_page->ID : 0;
                        
                        // Menu types and their labels
                        $menu_types = array(
                            'full' => 'FULL MENU',
                            'drink' => 'DRINK MENU',
                            'brunch' => 'BRUNCH MENU',
                            'happy' => 'HAPPY HOUR',
                            'today' => 'TODAY\'S MENU'
                        );
                        
                        foreach ($menu_types as $type => $label) {
                            // Get the custom URL from theme mod if set
                            $custom_url = get_theme_mod("si_menu_dropdown_url_{$type}", '');
                            
                            if ($custom_url) {
                                $menu_url = $custom_url;
                            } else {
                                // Fallback to standard URL structure
                                $menu_url = add_query_arg('menu', $type, get_permalink($menu_page_id));
                            }
                            
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
            <?php
            // Right Menu Items
            for ($i = 1; $i <= 3; $i++) {
                if (get_theme_mod('si_right_menu_visible_' . $i, true)) {
                    $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                    $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/catering/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                    
                    // Check if this menu item has a dropdown
                    $has_dropdown = get_theme_mod('si_right_menu_has_dropdown_' . $i, $i == 3); // Default true for Contact Us
                    
                    if ($has_dropdown) {
                        echo '<div class="menu-dropdown-wrapper">';
                        echo '<a href="' . esc_url($menu_url) . '" class="nav-button has-dropdown">' . esc_html($menu_text) . ' <span class="dropdown-arrow">▼</span></a>';
                        echo '<div class="menu-dropdown">';
                        
                        // Display dropdown items
                        for ($j = 1; $j <= 5; $j++) {
                            if (get_theme_mod('si_right_menu_dropdown_' . $i . '_visible_' . $j, $i == 3 && ($j == 1 || $j == 2))) {
                                $dropdown_text = get_theme_mod('si_right_menu_dropdown_' . $i . '_text_' . $j, 
                                    $i == 3 && $j == 1 ? 'Contact The Restaurant' : 
                                    ($i == 3 && $j == 2 ? 'Franchise Opportunities' : ''));
                                $dropdown_url = get_theme_mod('si_right_menu_dropdown_' . $i . '_url_' . $j,
                                    $i == 3 && $j == 1 ? home_url('/contact/') :
                                    ($i == 3 && $j == 2 ? home_url('/franchise/') : ''));
                                
                                // Only output if we have both text and URL
                                if ($dropdown_text && $dropdown_url) {
                                    echo '<a href="' . esc_url($dropdown_url) . '" class="dropdown-item">' . esc_html($dropdown_text) . '</a>';
                                }
                            }
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
    </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="mobile-menu" aria-hidden="true">
    <?php
    // Left menu items
    for ($i = 1; $i <= 3; $i++) {
        $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
        $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
        $menu_visible = get_theme_mod('si_left_menu_visible_' . $i, $i <= 3);

        if ($menu_visible && $menu_text) {
            echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_text) . '</a>';
            
            // Add menu dropdown items for mobile
            if ($i == 1 && $menu_text == 'MENU' && get_theme_mod('si_enable_menu_dropdown', true)) {
                // Get the menu page ID if not already set
                if (!isset($menu_page_id)) {
                    $menu_page = get_page_by_path('menu');
                    $menu_page_id = $menu_page ? $menu_page->ID : 0;
                }
                
                // Determine if we should use page_id or pretty permalinks
                $use_page_id = false;
                if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'sportsillustratedeats.com') !== false) {
                    $use_page_id = true;
                }
                
                if ($use_page_id && $menu_page_id) {
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_full', add_query_arg(array('page_id' => $menu_page_id, 'menu' => 'full'), home_url()))) . '" class="mobile-submenu-item">— FULL MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_drink', add_query_arg(array('page_id' => $menu_page_id, 'menu' => 'drink'), home_url()))) . '" class="mobile-submenu-item">— DRINK MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_brunch', add_query_arg(array('page_id' => $menu_page_id, 'menu' => 'brunch'), home_url()))) . '" class="mobile-submenu-item">— BRUNCH MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_happy', add_query_arg(array('page_id' => $menu_page_id, 'menu' => 'happy'), home_url()))) . '" class="mobile-submenu-item">— HAPPY HOUR</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_today', add_query_arg(array('page_id' => $menu_page_id, 'menu' => 'today'), home_url()))) . '" class="mobile-submenu-item">— TODAY\'S MENU</a>';
                } else {
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_full', home_url('/menu/?menu=full'))) . '" class="mobile-submenu-item">— FULL MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_drink', home_url('/menu/?menu=drink'))) . '" class="mobile-submenu-item">— DRINK MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_brunch', home_url('/menu/?menu=brunch'))) . '" class="mobile-submenu-item">— BRUNCH MENU</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_happy', home_url('/menu/?menu=happy'))) . '" class="mobile-submenu-item">— HAPPY HOUR</a>';
                    echo '<a href="' . esc_url(get_theme_mod('si_menu_dropdown_url_today', home_url('/menu/?menu=today'))) . '" class="mobile-submenu-item">— TODAY\'S MENU</a>';
                }
            }
        }
    }

    // Right menu items
    for ($i = 1; $i <= 3; $i++) {
        $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
        $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/careers/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
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