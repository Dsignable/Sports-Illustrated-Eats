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
    <?php if ( has_custom_header() ) : ?>
        <?php the_custom_header_markup(); ?>
    <?php else : ?>
        <img
            src="<?php echo esc_url(get_theme_file_uri('assets/images/hero-background.jpg')); ?>"
            class="hero-background"
            alt="<?php echo esc_attr__('Background image', 'sports-illustrated'); ?>"
        />
    <?php endif; ?>
    
    <nav class="navigation-bar">
        <button class="nav-button"><?php echo esc_html__('MENU', 'sports-illustrated'); ?></button>
        <button class="nav-button"><?php echo esc_html__('BOOK NOW', 'sports-illustrated'); ?></button>
        <button class="nav-button"><?php echo esc_html__('ORDER ONLINE', 'sports-illustrated'); ?></button>
        
        <?php if ( has_custom_logo() ) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <img
                src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>"
                class="nav-logo"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
            />
        <?php endif; ?>
        
        <button class="nav-button"><?php echo esc_html__('PRIVATE EVENTS', 'sports-illustrated'); ?></button>
        <button class="nav-button"><?php echo esc_html__('SPORTS SCHEDULE', 'sports-illustrated'); ?></button>
        <button class="nav-button"><?php echo esc_html__('CONTACT US', 'sports-illustrated'); ?></button>
    </nav>
</header> 