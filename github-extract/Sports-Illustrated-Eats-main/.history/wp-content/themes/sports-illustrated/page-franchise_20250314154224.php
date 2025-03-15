<?php

/**
 * Template Name: Franchise Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('franchise');
?>

<main id="primary" class="site-main franchise-page" <?php echo $bg_style; ?>>
    <div class="franchise-container">
        <section class="franchise-form-section">
            <div class="franchise-title">
                <h1><?php echo esc_html(get_theme_mod('si_franchise_title', 'FRANCHISE OPPORTUNITIES')); ?></h1>
                <p><?php echo esc_html(get_theme_mod('si_franchise_description', 'Join the Sports Illustrated family by becoming a franchise owner. Fill out the form below to get started with your franchise application.')); ?></p>
            </div>
            <div class="franchise-form-wrapper">
                <?php
                // Display Contact Form 7 if available
                $franchise_form_id = get_theme_mod('si_franchise_form_id');
                if ($franchise_form_id && function_exists('wpcf7_contact_form')) {
                    echo do_shortcode('[contact-form-7 id="' . esc_attr($franchise_form_id) . '"]');
                } else {
                    // Fallback message if Contact Form 7 is not available
                    echo '<p>Please contact us at <a href="mailto:admin@sportsillustratedeats.com">admin@sportsillustratedeats.com</a> for franchise inquiries.</p>';
                }
                ?>
            </div>
        </section>
        <section class="franchise-image-section">
            <?php
            $franchise_image = get_theme_mod('si_franchise_image');
            if ($franchise_image) {
                echo wp_get_attachment_image($franchise_image, 'full', false, array('class' => 'franchise-image'));
            } else {
                // Fallback image
            ?>
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/franchise.jpg')); ?>" alt="Franchise" class="franchise-image">
            <?php
            }
            ?>
        </section>
    </div>
</main>

<?php
// Enqueue contact form script
wp_enqueue_script(
    'si-franchise-form',
    get_theme_file_uri('/assets/js/contact-form.js'),
    array('jquery'),
    SI_VERSION,
    true
);

get_footer();
?> 