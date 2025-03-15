<?php
/**
 * Template Name: Posts Page
 * 
 * This template displays all posts in a grid layout with pagination.
 * Styled to match the original news page design.
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$page_title = get_theme_mod('si_news_title', 'LATEST NEWS');
$page_description = get_theme_mod('si_news_description', 'Stay updated with the latest news and updates from Sports Illustrated Clubhouse.');
$posts_per_page = get_theme_mod('si_news_posts_per_page', 9);

// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Custom query for posts
$args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish'
);

$news_query = new WP_Query($args);
?>

<div class="news-page" <?php echo si_get_background_style('news'); ?>>
    <div class="news-header">
        <div class="container">
            <h1 class="news-title"><?php echo esc_html($page_title); ?></h1>
            <?php if ($page_description) : ?>
                <div class="news-description"><?php echo wp_kses_post($page_description); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="news-content">
        <div class="container">
            <?php if ($news_query->have_posts()) : ?>
                <div class="news-grid">
                    <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                        <article class="news-card">
                            <a href="<?php the_permalink(); ?>" class="news-card-link">
                                <div class="news-card-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('news-card', array('class' => 'news-thumbnail')); ?>
                                    <?php else : 
                                        $default_image = get_theme_mod('si_default_news_image');
                                        if ($default_image) :
                                            echo wp_get_attachment_image($default_image, 'news-card', false, array('class' => 'news-thumbnail'));
                                        endif;
                                    endif; ?>
                                    <div class="news-card-overlay"></div>
                                </div>
                                <div class="news-card-content">
                                    <h2 class="news-card-title"><?php the_title(); ?></h2>
                                    <div class="news-meta">
                                        <span class="news-date"><?php echo get_the_date(); ?></span>
                                    </div>
                                    <div class="news-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                    <span class="read-more">READ MORE</span>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Pagination
                $big = 999999999;
                echo '<div class="news-pagination">';
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $paged),
                    'total' => $news_query->max_num_pages,
                    'prev_text' => __('Previous', 'sports-illustrated'),
                    'next_text' => __('Next', 'sports-illustrated'),
                    'mid_size' => 2,
                    'type' => 'list'
                ));
                echo '</div>';
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
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>

<style>
/* News Page Styles */
.news-page {
    position: relative;
    min-height: 100vh;
    background-color: #000;
    color: #fff;
    padding: 120px 0 60px;
}

.news-header {
    text-align: center;
    margin-bottom: 60px;
}

.news-title {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.news-description {
    font-size: 18px;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 40px;
}

.news-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.news-card:hover {
    transform: translateY(-5px);
}

.news-card-link {
    text-decoration: none;
    color: #fff;
    display: block;
}

.news-card-image {
    position: relative;
    padding-top: 56.25%; /* 16:9 aspect ratio */
    overflow: hidden;
}

.news-thumbnail {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card:hover .news-thumbnail {
    transform: scale(1.05);
}

.news-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
}

.news-card-content {
    padding: 20px;
}

.news-card-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
    line-height: 1.3;
}

.news-meta {
    font-size: 14px;
    color: #ccc;
    margin-bottom: 10px;
}

.news-excerpt {
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 15px;
    color: #ccc;
}

.read-more {
    display: inline-block;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
    transition: color 0.3s ease;
    position: relative;
    padding-right: 25px;
}

.read-more::after {

    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
}

.news-card:hover .read-more {
    color: #e63422;
}

.news-card:hover .read-more::after {
    transform: translate(5px, -50%);
}

.news-pagination {
    text-align: center;
    margin-top: 40px;
}

.news-pagination .page-numbers {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 10px;
}

.news-pagination .page-numbers li {
    display: inline-block;
}

.news-pagination .page-numbers a,
.news-pagination .page-numbers span {
    display: inline-block;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.news-pagination .page-numbers a:hover {
    background: rgba(255, 255, 255, 0.2);
}

.news-pagination .page-numbers .current {
    background: #e63422;
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .news-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .news-page {
        padding: 100px 0 40px;
    }

    .news-title {
        font-size: 36px;
    }

    .news-description {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .news-grid {
        grid-template-columns: 1fr;
    }

    .news-card-title {
        font-size: 20px;
    }

    .news-excerpt {
        font-size: 14px;
    }
}
</style>

<?php get_footer(); ?> 