<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sports_Illustrated
 */

?>
<!DOCTYPE html>
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
        <div class="loading-screen">
            <div class="loading-content">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'full') : false;
                ?>
                <img src="<?php echo $logo ? esc_url($logo[0]) : esc_url(get_theme_file_uri('assets/images/logo.png')); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                    class="loading-logo">
            </div>
        </div>
    <?php endif; ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'sports-illustrated'); ?></a>

        <header id="masthead" class="site-header">
            <?php 
            // Use the new navigation bar template
            get_template_part('template-parts/header', 'nav'); 
            ?>
        </header>

        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                <?php