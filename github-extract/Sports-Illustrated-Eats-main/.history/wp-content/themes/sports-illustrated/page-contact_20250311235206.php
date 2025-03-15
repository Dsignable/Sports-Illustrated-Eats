<?php
/**
 * Template Name: Contact Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get the contact image URL
$contact_image_url = si_get_image_url('si_contact_image', get_theme_file_uri('assets/images/contact-default.jpg'));

// Get contact display type
$display_type = get_theme_mod('si_contact_display_type', 'static');

// Get contact information
$contact_email = get_theme_mod('si_contact_email', 'admin@sportsillustratedeats.com');
$contact_phone = get_theme_mod('si_contact_phone', '(236) 471-7643');
$contact_message = get_theme_mod('si_contact_message', __('Thank you for your interest in Sports Illustrated Clubhouse. For reservations, event inquiries, or general questions, please contact us using the information below. We look forward to hearing from you!', 'sports-illustrated'));
?>

<main id="primary" class="site-main contact-page">
    <div class="contact-container">
        <section class="contact-form-section">
            <h1 class="contact-title">CONTACT US</h1>
            
            <?php if ($display_type === 'static'): ?>
            <!-- Static Contact Information -->
            <div class="contact-info-wrapper">
                <div class="contact-message">
                    <?php echo wp_kses_post($contact_message); ?>
                </div>
                
                <div class="contact-details">
                    <?php if ($contact_email): ?>
                    <div class="contact-email">
                        <strong><?php _e('Email:', 'sports-illustrated'); ?></strong>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($contact_phone): ?>
                    <div class="contact-phone">
                        <strong><?php _e('Phone:', 'sports-illustrated'); ?></strong>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <?php 
                if (shortcode_exists('contact-form-7')) {
                    // Get all CF7 forms
                    $forms = get_posts(array(
                        'post_type' => 'wpcf7_contact_form',
                        'posts_per_page' => 1
                    ));
                    
                    if (!empty($forms)) {
                        // Use the first available form
                        $form_id = $forms[0]->ID;
                        echo do_shortcode('[contact-form-7 id="' . esc_attr($form_id) . '" title="Contact Form"]');
                    } else {
                        echo '<p>' . __('Please create a form in Contact Form 7.', 'sports-illustrated') . '</p>';
                    }
                } else {
                    echo '<p>' . __('Please install and activate Contact Form 7 plugin.', 'sports-illustrated') . '</p>';
                }
                ?>
            </div>
            <?php endif; ?>
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


