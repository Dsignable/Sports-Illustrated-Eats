<?php
/**
 * Template for displaying single posts
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('news');
?>

<main id="primary" class="site-main single-post-page" <?php echo $bg_style; ?>>
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
            <!-- Article Header -->
            <header class="post-header">
                <div class="post-container">
                    <div class="post-meta">
                        <span class="post-date"><?php echo get_the_date('F j, Y'); ?></span>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) :
                        ?>
                            <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image">
                    <div class="post-container">
                        <?php the_post_thumbnail('full', array('class' => 'featured-image')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="post-content">
                <div class="post-container">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Article Footer -->
            <footer class="post-footer">
                <div class="post-container">
                    <div class="post-tags">
                        <?php the_tags('<span class="tag-label">Tags:</span> ', ', '); ?>
                    </div>
                    
                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if (!empty($prev_post)) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="nav-link prev-link">
                                <span class="nav-label">Previous Article</span>
                                <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($next_post)) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="nav-link next-link">
                                <span class="nav-label">Next Article</span>
                                <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?> 