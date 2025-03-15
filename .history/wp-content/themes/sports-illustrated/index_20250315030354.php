<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            
            get_template_part('template-parts/content', get_post_type());
            
        endwhile;
        
        the_posts_navigation();
        
    else :
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main><!-- #primary -->

<?php
get_footer(); 