<?php
/**
 * Template Name: Careers Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$header_image = get_theme_mod('si_careers_header_image', '');
$page_title = get_theme_mod('si_careers_title', __('Join Our Team', 'sports-illustrated'));
$page_description = get_theme_mod('si_careers_description', __('Be part of an exciting team that delivers exceptional dining experiences.', 'sports-illustrated'));
?>

<main id="primary" class="site-main careers-page">
    <!-- Careers Header Section -->
    <section class="careers-header" <?php echo $header_image ? 'style="background-image: url(' . esc_url($header_image) . ');"' : ''; ?>>
        <div class="careers-header-content">
            <h1 class="careers-title"><?php echo esc_html($page_title); ?></h1>
            <p class="careers-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- Careers Content Section -->
    <section class="careers-content">
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'page');
        endwhile;
        ?>
    </section>
</main>

<?php
get_footer();
?> 