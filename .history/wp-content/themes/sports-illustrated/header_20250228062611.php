<?php
/**
 * The header for our theme
 *
 * @package Sports_Illustrated
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <?php get_template_part('template-parts/header'); ?>

    <button class="hamburger" aria-controls="mobile-menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
        <span class="screen-reader-text">Menu</span>
    </button>

    <nav id="mobile-menu" class="mobile-menu" aria-hidden="true">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'mobile',
            'menu_class'     => 'mobile-menu-items',
            'container'      => false,
            'fallback_cb'    => false,
        ));
        ?>
    </nav>
</div>
</body>
</html> 