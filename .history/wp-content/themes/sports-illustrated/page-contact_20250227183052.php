<?php
/**
 * Template Name: Contact Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get the contact image URL
$contact_image_url = si_get_image_url('si_contact_image', get_theme_file_uri('assets/images/contact-default.jpg'));
?>

<main id="primary" class="site-main contact-page">
    <div class="contact-container">
        <section class="contact-form-section">
            <h1 class="contact-title">CONTACT US</h1>
            <div class="contact-form-wrapper">
                <?php 
                if (shortcode_exists('contact-form-7')) {
                    echo do_shortcode('[contact-form-7 id="FORM_ID" title="Contact Form"]');
                } else {
                    echo '<p>Please install and activate Contact Form 7 plugin.</p>';
                }
                ?>
            </div>
        </section>
        
        <section class="contact-image-section">
            <?php if ($contact_image_url) : ?>
                <img src="<?php echo esc_url($contact_image_url); ?>" 
                     alt="<?php esc_attr_e('Contact Us', 'sports-illustrated'); ?>" 
                     class="contact-image">
            <?php endif; ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>


