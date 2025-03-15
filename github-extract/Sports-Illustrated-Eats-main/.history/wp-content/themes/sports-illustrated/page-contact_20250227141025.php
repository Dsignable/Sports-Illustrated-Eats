<?php
/**
 * Template Name: Contact Page
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main contact-page snap-section">
    <div class="contact-container">
        <div class="contact-form-section">
            <h1 class="contact-title">CONTACT US</h1>
            <div class="contact-form-wrapper">
                <form id="contact-form" class="contact-form" method="post">
                    <?php wp_nonce_field('contact_form_submit', 'contact_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="reservation">Make a Reservation</option>
                            <option value="private-event">Private Event Inquiry</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="submit-button">SEND MESSAGE</button>
                </form>
                <div id="form-response" class="form-response"></div>
            </div>
        </div>
        <div class="contact-image-section">
            <img src="<?php echo esc_url(get_theme_file_uri('assets/images/contact-image.jpg')); ?>" 
                 alt="Sports Illustrated Clubhouse Interior" 
                 class="contact-image"
                 loading="lazy">
        </div>
    </div>
</main>

<?php get_footer(); ?> 