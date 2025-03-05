<?php
/**
 * Template part for displaying monthly events
 *
 * @package Sports_Illustrated
 */

$events_title = get_theme_mod('si_monthly_events_title', 'SI CLUBHOUSE MONTHLY EVENTS');
?>

<section class="monthly-events">
    <div class="monthly-events-container">
        <h2 class="monthly-events-title"><?php echo esc_html($events_title); ?></h2>
        
        <div class="events-grid">
            <?php
            $has_events = false;
            // Loop through up to 6 event images
            for ($i = 1; $i <= 6; $i++) {
                $event_image_id = get_theme_mod("si_event_image_$i");
                $event_link = get_theme_mod("si_event_link_$i");
                
                if ($event_image_id) {
                    $has_events = true;
                    $image_url = wp_get_attachment_image_url($event_image_id, 'full');
                    ?>
                    <div class="event-card">
                        <?php if ($event_link) : ?>
                        <a href="<?php echo esc_url($event_link); ?>">
                        <?php endif; ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="Event <?php echo $i; ?>" class="event-image">
                            <div class="event-overlay"></div>
                        <?php if ($event_link) : ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            }
            
            if (!$has_events) {
                echo '<p class="no-events">No events currently scheduled. Check back soon!</p>';
            }
            ?>
        </div>
    </div>
</section> 