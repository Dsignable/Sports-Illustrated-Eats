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

<?php if (get_theme_mod('si_enable_loading_screen', true)) : ?>
    <div id="loading-screen" class="loading-screen" data-duration="<?php echo esc_attr(get_theme_mod('si_loading_screen_duration', 3000)); ?>">
        <div class="loading-content">
            <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" alt="Loading" class="loading-logo">
        </div>
    </div>
<?php endif; ?>

<div id="page" class="site">
    <?php get_template_part('template-parts/header'); ?>
</body>
</html> 