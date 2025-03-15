<?php
/**
 * Template part for displaying posts
 *
 * @package Sports_Illustrated
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
    </header>

    <div class="entry-content">
        <?php
        the_content(
            sprintf(
                wp_kses(
                    /* translators: %s: Post title. */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'sports-illustrated'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        ?>
    </div>
</article> 