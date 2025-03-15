<?php
/**
 * Template for displaying single posts
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('news');

// Get featured image
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$featured_image) {
    // If no featured image is set, use the default background
    $featured_image = get_theme_mod('si_news_bg', '');
}
?>

<main id="primary" class="site-main single-post-page" style="background-image: url('<?php echo esc_url($featured_image); ?>');">
    <div class="post-overlay"></div>
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

            <?php if (has_post_thumbnail() && !is_page()) : ?>
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
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <?php the_tags('<span class="tag-label">Tags:</span> ', ', '); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        
                        if (!empty($prev_post)) :
                            $prev_thumb = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
                        ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="nav-link prev-link">
                                <?php if ($prev_thumb) : ?>
                                    <div class="nav-thumb" style="background-image: url('<?php echo esc_url($prev_thumb); ?>')"></div>
                                <?php endif; ?>
                                <div class="nav-content">
                                    <span class="nav-label">Previous Article</span>
                                    <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($next_post)) :
                            $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
                        ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="nav-link next-link">
                                <?php if ($next_thumb) : ?>
                                    <div class="nav-thumb" style="background-image: url('<?php echo esc_url($next_thumb); ?>')"></div>
                                <?php endif; ?>
                                <div class="nav-content">
                                    <span class="nav-label">Next Article</span>
                                    <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?> 