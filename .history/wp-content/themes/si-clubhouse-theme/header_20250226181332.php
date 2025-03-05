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
    <?php
    $hero_background = get_theme_mod('hero_background_image', 'https://cdn.builder.io/api/v1/image/assets/e6ab85e93ad9451db00e45c8874777d7/585341e40dc2a1c807b8c5ee03dc38cbe4fb17cfc85497efbc741230f32a8b3f');
    $logo_image = get_theme_mod('site_logo', 'https://cdn.builder.io/api/v1/image/assets/e6ab85e93ad9451db00e45c8874777d7/7a19f2544c8853b389d17c2a91dab0b24834cb048c292488cc227308b7814579');
    ?>
    
    <img
        src="<?php echo esc_url($hero_background); ?>"
        class="hero-background"
        alt="<?php echo esc_attr(get_bloginfo('name')); ?> background"
    />
    
    <nav class="navigation-bar">
        <a href="#menu" class="nav-button">MENU</a>
        <a href="#book" class="nav-button">BOOK NOW</a>
        <a href="#order" class="nav-button">ORDER ONLINE</a>
        
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
            <img
                src="<?php echo esc_url($logo_image); ?>"
                class="nav-logo"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?> logo"
            />
        </a>
        
        <a href="#events" class="nav-button">PRIVATE EVENTS</a>
        <a href="#schedule" class="nav-button">SPORTS SCHEDULE</a>
        <a href="#contact" class="nav-button">CONTACT US</a>
    </nav>
</header> 