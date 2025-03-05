<?php
/**
 * Template for displaying single job listings
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main single-job-page">
    <div class="single-job-container">
        <?php while (have_posts()) : the_post(); ?>
            <article class="single-job-content">
                <header class="job-header">
                    <h1 class="job-title"><?php the_title(); ?></h1>
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'job_category');
                    if ($categories && !is_wp_error($categories)) :
                    ?>
                        <div class="job-categories">
                            <?php foreach ($categories as $category) : ?>
                                <span class="job-category"><?php echo esc_html($category->name); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="job-meta">
                        <span class="job-date"><?php echo get_the_date(); ?></span>
                    </div>
                </header>

                <div class="job-description">
                    <?php the_content(); ?>
                </div>

                <footer class="job-footer">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('careers'))); ?>" class="back-to-jobs">
                        <?php _e('Back to All Jobs', 'sports-illustrated'); ?>
                    </a>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
?> 