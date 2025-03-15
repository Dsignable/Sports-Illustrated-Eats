<?php
/**
 * The template for displaying archive pages and posts
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$page_title = get_theme_mod('si_news_title', 'LATEST NEWS');
$page_description = get_theme_mod('si_news_description', 'Stay updated with the latest news and updates from Sports Illustrated Clubhouse.');
$posts_per_page = get_theme_mod('si_news_posts_per_page', 9);
?>

<div class="news-page" <?php echo si_get_background_style('news'); ?>>
    <div class="news-header">
        <div class="news-container">
            <h1 class="news-title"><?php echo esc_html($page_title); ?></h1>
            <?php if ($page_description) : ?>
                <div class="news-description"><?php echo wp_kses_post($page_description); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="news-content">
        <div class="news-container">
            <?php if (have_posts()) : ?>
                <div class="news-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="news-card">
                            <div class="news-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('news-card'); ?>
                                <?php else : 
                                    $default_image = get_theme_mod('si_default_news_image');
                                    if ($default_image) :
                                        echo wp_get_attachment_image($default_image, 'news-card');
                                    endif;
                                endif; ?>
                            </div>
                            <div class="news-card-content">
                                <h2 class="news-card-title"><?php the_title(); ?></h2>
                                <div class="news-excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="read-more">READ MORE</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                echo paginate_links(array(
                    'prev_text' => __('Previous', 'sports-illustrated'),
                    'next_text' => __('Next', 'sports-illustrated'),
                    'mid_size'  => 2,
                ));
                ?>

            <?php else : ?>
                <div class="no-posts">
                    <p><?php _e('No posts found.', 'sports-illustrated'); ?></p>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <p><?php _e('Ready to publish your first post?', 'sports-illustrated'); ?></p>
                        <a href="<?php echo esc_url(admin_url('post-new.php')); ?>" class="add-new-post"><?php _e('Get Started Here', 'sports-illustrated'); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?> 