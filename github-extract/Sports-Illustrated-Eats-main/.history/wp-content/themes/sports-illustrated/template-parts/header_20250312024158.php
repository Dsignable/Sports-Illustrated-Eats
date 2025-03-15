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

        <!-- Desktop Navigation - Left Menu -->
        <nav class="desktop-menu left-menu">
            <?php for ($i = 1; $i <= 3; $i++) :
                $menu_text = get_theme_mod('si_left_menu_text_' . $i, $i == 1 ? 'MENU' : ($i == 2 ? 'RESERVATIONS' : ($i == 3 ? 'ORDER ONLINE' : '')));
                $menu_url = get_theme_mod('si_left_menu_url_' . $i, $i == 1 ? home_url('/menu/') : ($i == 2 ? home_url('/reservations/') : ($i == 3 ? 'https://www.order.store/store/sports-illustrated-clubhouse/k003zVjYXe6DFY58dmcpCw' : '')));
                $menu_visible = get_theme_mod('si_left_menu_visible_' . $i, $i <= 3);

                if ($menu_visible && $menu_text) :
                    // Special handling for the Menu button with dropdown
                    if ($i == 1 && $menu_text == 'MENU' && get_theme_mod('si_enable_menu_dropdown', true)) : ?>
                        <div class="menu-dropdown-wrapper">
                            <a href="<?php echo esc_url($menu_url); ?>" class="nav-button has-dropdown">
                                <?php echo esc_html($menu_text); ?>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="menu-dropdown">
                                <a href="<?php echo esc_url(get_theme_mod('si_menu_dropdown_url_full', add_query_arg('menu', 'full', $menu_url))); ?>" class="dropdown-item">FULL MENU</a>
                                <a href="<?php echo esc_url(get_theme_mod('si_menu_dropdown_url_drink', add_query_arg('menu', 'drink', $menu_url))); ?>" class="dropdown-item">DRINK MENU</a>
                                <a href="<?php echo esc_url(get_theme_mod('si_menu_dropdown_url_brunch', add_query_arg('menu', 'brunch', $menu_url))); ?>" class="dropdown-item">BRUNCH MENU</a>
                                <a href="<?php echo esc_url(get_theme_mod('si_menu_dropdown_url_happy', add_query_arg('menu', 'happy', $menu_url))); ?>" class="dropdown-item">HAPPY HOUR</a>
                                <a href="<?php echo esc_url(get_theme_mod('si_menu_dropdown_url_today', add_query_arg('menu', 'today', $menu_url))); ?>" class="dropdown-item">TODAY'S MENU</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url($menu_url); ?>" class="nav-button"><?php echo esc_html($menu_text); ?></a>
            <?php endif;
                endif;
            endfor; ?>
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

        <!-- Desktop Navigation - Right Menu -->
        <nav class="desktop-menu right-menu">
            <?php for ($i = 1; $i <= 3; $i++) :
                $menu_text = get_theme_mod('si_right_menu_text_' . $i, $i == 1 ? 'CATERING & EVENTS' : ($i == 2 ? 'NEWS' : ($i == 3 ? 'CONTACT US' : '')));
                $menu_url = get_theme_mod('si_right_menu_url_' . $i, $i == 1 ? home_url('/careers/') : ($i == 2 ? home_url('/news/') : ($i == 3 ? home_url('/contact/') : '')));
                $menu_visible = get_theme_mod('si_right_menu_visible_' . $i, $i <= 3);

                if ($menu_visible && $menu_text) : ?>
                    <a href="<?php echo esc_url($menu_url); ?>" class="nav-button"><?php echo esc_html($menu_text); ?></a>
            <?php endif;
            endfor; ?>
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