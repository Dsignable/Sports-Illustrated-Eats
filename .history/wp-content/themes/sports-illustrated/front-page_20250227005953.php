<?php
/**
 * The template for displaying the homepage
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main home-page">
    <div class="hero-section">
        <div class="hero-content">
            <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
            <p><?php echo esc_html(get_bloginfo('description')); ?></p>
        </div>
    </div>

    <?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/content', 'page');
    endwhile;
    ?>
</main>

<?php
get_footer(); 