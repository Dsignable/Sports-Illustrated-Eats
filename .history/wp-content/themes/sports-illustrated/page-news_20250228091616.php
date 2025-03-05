<?php
/**
 * Template Name: News Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$header_image = get_theme_mod('si_news_header_image', '');
$page_title = get_theme_mod('si_news_title', __('Latest News', 'sports-illustrated'));
$page_description = get_theme_mod('si_news_description', __('Stay updated with the latest news and updates from Sports Illustrated Clubhouse.', 'sports-illustrated'));

// Get news posts
$news_query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'orderby' => 'date',
    'order' => 'DESC',
));
?>

<main id="primary" class="site-main news-page">
    <!-- News Header Section -->
    <section class="news-header" <?php echo $header_image ? 'style="background-image: url(' . esc_url($header_image) . ');"' : ''; ?>>
        <div class="news-header-content">
            <h1 class="news-title"><?php echo esc_html($page_title); ?></h1>
            <p class="news-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- News Grid Section -->
    <section class="news-grid">
        <div class="news-container">
            <?php if ($news_query->have_posts()) : ?>
                <div class="news-items">
                    <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                        <article class="news-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-image-wrapper">
                                    <?php the_post_thumbnail('large', array('class' => 'news-image')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="news-date"><?php echo get_the_date(); ?></span>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                    ?>
                                        <span class="news-category"><?php echo esc_html($categories[0]->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h2 class="news-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="news-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e('Read More', 'sports-illustrated'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                $total_pages = $news_query->max_num_pages;
                if ($total_pages > 1) :
                ?>
                    <div class="pagination">
                        <?php
                        echo paginate_links(array(
                            'total' => $total_pages,
                            'prev_text' => __('Previous', 'sports-illustrated'),
                            'next_text' => __('Next', 'sports-illustrated'),
                        ));
                        ?>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <p class="no-posts"><?php esc_html_e('No news posts found.', 'sports-illustrated'); ?></p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?> 