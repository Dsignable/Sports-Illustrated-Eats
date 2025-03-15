<?php
/**
 * Template Name: Careers Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$bg_style = si_get_background_style('careers');
$page_title = get_theme_mod('si_careers_title', __('Join Our Team', 'sports-illustrated'));
$page_description = get_theme_mod('si_careers_description', __('Be part of an exciting team that delivers exceptional dining experiences.', 'sports-illustrated'));

// Query for job listings
$jobs_query = new WP_Query(array(
    'post_type' => 'job_listing',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<main id="primary" class="site-main careers-page" <?php echo $bg_style; ?>>
    <!-- Careers Header Section -->
    <section class="careers-header">
        <div class="careers-header-content">
            <h1 class="careers-title"><?php echo esc_html($page_title); ?></h1>
            <p class="careers-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- Careers Content Section -->
    <section class="careers-content">
        <div class="careers-container">
            <?php
            // Display the page content first
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>

            <!-- Job Listings Section -->
            <div class="jobs-grid">
                <?php if ($jobs_query->have_posts()) : ?>
                    <?php while ($jobs_query->have_posts()) : $jobs_query->the_post(); ?>
                        <article class="job-card">
                            <h2 class="job-title"><?php the_title(); ?></h2>
                            <?php
                            $job_categories = get_the_terms(get_the_ID(), 'job_category');
                            if ($job_categories && !is_wp_error($job_categories)) :
                            ?>
                                <div class="job-categories">
                                    <?php foreach ($job_categories as $category) : ?>
                                        <span class="job-category"><?php echo esc_html($category->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="job-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="job-link">Learn More</a>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-jobs-message">
                        <p><?php esc_html_e('No job openings available at this time. Please check back later.', 'sports-illustrated'); ?></p>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?> 