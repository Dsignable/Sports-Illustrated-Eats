<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Sports_Illustrated
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (!is_front_page()) : ?>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'sports-illustrated'),
            'after'  => '</div>',
        ));
        ?>
    </div>
</article> 