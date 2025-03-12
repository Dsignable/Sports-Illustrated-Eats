<?php
/**
 * Template Name: Catering Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get background style
$bg_style = si_get_background_style('catering');
?>

<main id="primary" class="site-main catering-page" <?php echo $bg_style; ?>>
    <div class="catering-container">
        <section class="catering-form-section">
            <div class="catering-title">
                <h1><?php echo esc_html(get_theme_mod('si_catering_title', 'CATERING & EVENTS')); ?></h1>
                <p><?php echo esc_html(get_theme_mod('si_catering_description', 'Let us cater your next event with our delicious menu options. Fill out the form below to get started.')); ?></p>
            </div>
            <div class="catering-form-wrapper">
                <?php 
                // Display Contact Form 7 if available
                $catering_form_id = get_theme_mod('si_catering_form_id');
                if ($catering_form_id && function_exists('wpcf7_contact_form')) {
                    echo do_shortcode('[contact-form-7 id="' . esc_attr($catering_form_id) . '"]');
                } else {
                    // Fallback message if Contact Form 7 is not available
                    echo '<p>Please contact us at <a href="mailto:info@sportsillustratedeats.com">info@sportsillustratedeats.com</a> for catering inquiries.</p>';
                }
                ?>
            </div>
        </section>
        <section class="catering-image-section">
            <?php 
            $catering_image = get_theme_mod('si_catering_image');
            if ($catering_image) {
                echo wp_get_attachment_image($catering_image, 'full', false, array('class' => 'catering-image'));
            } else {
                // Fallback image
                ?>
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/catering.jpg')); ?>" alt="Catering" class="catering-image">
                <?php
            }
            ?>
        </section>
    </div>
</main>

<?php
// Enqueue contact form script
wp_enqueue_script(
    'si-catering-form',
    get_theme_file_uri('/assets/js/contact-form.js'),
    array('jquery'),
    SI_VERSION,
    true
);

get_footer();
?> 