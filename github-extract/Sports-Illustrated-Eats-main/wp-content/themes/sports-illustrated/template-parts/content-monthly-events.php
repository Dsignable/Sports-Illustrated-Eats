<?php
/**
 * Template part for displaying monthly events
 *
 * @package Sports_Illustrated
 */
?>

<section class="monthly-events">
    <div class="monthly-events-container">
        <h2 class="monthly-events-title"><?php echo esc_html(get_theme_mod('si_monthly_events_title', 'SI CLUBHOUSE MONTHLY EVENTS')); ?></h2>
        
        <div class="events-grid">
            <?php
            // Loop through up to 8 events
            for ($i = 1; $i <= 8; $i++) {
                $event_image_id = get_theme_mod("si_event_image_$i");
                $event_title = get_theme_mod("si_event_title_$i");
                $event_link = get_theme_mod("si_event_link_$i");
                $event_date = get_theme_mod("si_event_date_$i");

                // Only display if there's an image
                if ($event_image_id) {
                    $image_url = wp_get_attachment_image_url($event_image_id, 'large');
                    if ($image_url) {
                        ?>
                        <article class="event-card">
                            <?php if ($event_link) : ?>
                            <a href="<?php echo esc_url($event_link); ?>" class="event-link">
                            <?php endif; ?>
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($event_title); ?>" 
                                     class="event-image"
                                     loading="lazy">
                                <div class="event-overlay">
                                    <?php if ($event_title || $event_date) : ?>
                                    <div class="event-info">
                                        <?php if ($event_title) : ?>
                                            <h3 class="event-title"><?php echo esc_html($event_title); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($event_date) : ?>
                                            <p class="event-date"><?php echo esc_html($event_date); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php if ($event_link) : ?>
                            </a>
                            <?php endif; ?>
                        </article>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section> 