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
$contact_title = get_theme_mod('si_contact_title', __('CONTACT US', 'sports-illustrated'));
$contact_email = get_theme_mod('si_contact_email', 'admin@sportsillustratedeats.com');
$contact_phone = get_theme_mod('si_contact_phone', '(236) 471-7643');
$contact_message = get_theme_mod('si_contact_message', __('Thank you for your interest in Sports Illustrated Clubhouse. For reservations, event inquiries, or general questions, please contact us using the information below. We look forward to hearing from you!', 'sports-illustrated'));
?>

<main id="primary" class="site-main contact-page">
    <div class="contact-container">
        <section class="contact-form-section">
            <h1 class="contact-title"><?php echo esc_html($contact_title); ?></h1>
            
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
                // Check if Contact Form 7 is active
                if (function_exists('wpcf7_contact_form')) {
                    // Get the contact form ID from theme mod
                    $contact_form_id = get_theme_mod('si_contact_form_id');
                    
                    if ($contact_form_id) {
                        echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form_id) . '"]');
                    } else {
                        // Default contact form shortcode or message
                        echo '<div class="contact-form-placeholder">';
                        echo '<p>' . __('Please configure a contact form in the theme customizer.', 'sports-illustrated') . '</p>';
                        
                        // Display contact info as fallback
                        echo '<div class="contact-details fallback">';
                        echo '<div class="contact-email"><strong>' . __('Email:', 'sports-illustrated') . '</strong> <a href="mailto:' . esc_attr($contact_email) . '">' . esc_html($contact_email) . '</a></div>';
                        echo '<div class="contact-phone"><strong>' . __('Phone:', 'sports-illustrated') . '</strong> <a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $contact_phone)) . '">' . esc_html($contact_phone) . '</a></div>';
                        echo '</div>';
                        
                        echo '</div>';
                    }
                } else {
                    echo '<div class="contact-form-placeholder">';
                    echo '<p>' . __('Contact Form 7 plugin is not active. Please install and activate it to use contact forms.', 'sports-illustrated') . '</p>';
                    
                    // Display contact info as fallback
                    echo '<div class="contact-details fallback">';
                    echo '<div class="contact-email"><strong>' . __('Email:', 'sports-illustrated') . '</strong> <a href="mailto:' . esc_attr($contact_email) . '">' . esc_html($contact_email) . '</a></div>';
                    echo '<div class="contact-phone"><strong>' . __('Phone:', 'sports-illustrated') . '</strong> <a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $contact_phone)) . '">' . esc_html($contact_phone) . '</a></div>';
                    echo '</div>';
                    
                    echo '</div>';
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


