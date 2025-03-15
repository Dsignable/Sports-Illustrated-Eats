<?php
/**
 * Template Name: Contact Page
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main contact-page">
    <div class="contact-container">
        <section class="contact-form-section">
            <h1 class="contact-title">CONTACT US</h1>
            
            <div class="contact-form-wrapper">
                <form id="si-contact-form" class="contact-form" method="post">
                    <?php wp_nonce_field('si_contact_form_nonce', 'si_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Reservation">Make a Reservation</option>
                            <option value="Private Event">Private Event</option>
                            <option value="Feedback">Feedback</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="submit-button">SEND MESSAGE</button>
                </form>

                <div class="form-response success">Message sent successfully!</div>
                <div class="form-response error">Error sending message. Please try again.</div>
            </div>
        </section>

        <section class="contact-image-section">
            <img 
                src="<?php echo esc_url(get_theme_mod('si_contact_image', get_theme_file_uri('assets/images/contact-image.jpg'))); ?>" 
                alt="Contact Us" 
                class="contact-image"
            >
        </section>
    </div>
</main>

