<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="hero-section">
    <img
        src="<?php echo esc_url(get_theme_file_uri('images/hero-background.jpg')); ?>"
        class="hero-background"
        alt="<?php echo esc_attr__('Background image', 'si-clubhouse'); ?>"
    />
    <nav class="navigation-bar">
        <?php
        $nav_items = array(
            'menu' => __('MENU', 'si-clubhouse'),
            'book-now' => __('BOOK NOW', 'si-clubhouse'),
            'order-online' => __('ORDER ONLINE', 'si-clubhouse'),
            'private-events' => __('PRIVATE EVENTS', 'si-clubhouse'),
            'sports-schedule' => __('SPORTS SCHEDULE', 'si-clubhouse'),
            'contact-us' => __('CONTACT US', 'si-clubhouse')
        );

        // First three buttons
        $count = 1;
        foreach (array_slice($nav_items, 0, 3) as $key => $label) {
            printf(
                '<button class="nav-button" data-nav="%s">%s</button>',
                esc_attr($key),
                esc_html($label)
            );
            $count++;
        }

        // Logo
        ?>
        <img
            src="<?php echo esc_url(get_theme_file_uri('images/logo.png')); ?>"
            class="nav-logo"
            alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
        />
        <?php
        // Last three buttons
        foreach (array_slice($nav_items, 3) as $key => $label) {
            printf(
                '<button class="nav-button" data-nav="%s">%s</button>',
                esc_attr($key),
                esc_html($label)
            );
        }
        ?>
    </nav>
</header> 