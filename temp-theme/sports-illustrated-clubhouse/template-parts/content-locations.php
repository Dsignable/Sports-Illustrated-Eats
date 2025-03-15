<?php
/**
 * Template part for displaying locations
 *
 * @package Sports_Illustrated
 */
?>

<section class="locations-section">
    <h2 class="locations-title"><?php echo esc_html(get_theme_mod('si_locations_title', 'OUR LOCATIONS')); ?></h2>
    
    <div class="locations-container">
        <?php
        // Loop through locations (assuming up to 3 locations)
        for ($i = 1; $i <= 3; $i++) {
            $location_name = get_theme_mod("si_location_{$i}_name");
            $location_address = get_theme_mod("si_location_{$i}_address");
            $location_hours = get_theme_mod("si_location_{$i}_hours");
            $location_happy_hour = get_theme_mod("si_location_{$i}_happy_hour");
            $location_image = get_theme_mod("si_location_{$i}_image");

            if ($location_name) :
            ?>
            <div class="location-card">
                <?php if ($location_image) : ?>
                <div class="location-image-wrapper">
                    <?php echo wp_get_attachment_image($location_image, 'full', false, array('class' => 'location-image')); ?>
                </div>
                <?php endif; ?>

                <div class="location-details">
                    <div class="location-info">
                        <h3 class="location-name"><?php echo esc_html($location_name); ?></h3>
                        <?php if ($location_address) : ?>
                            <p class="location-address"><?php echo esc_html($location_address); ?></p>
                        <?php endif; ?>
                        <?php if ($location_hours) : ?>
                            <p class="location-hours"><?php echo esc_html($location_hours); ?></p>
                        <?php endif; ?>
                        <?php if ($location_happy_hour) : ?>
                            <p class="location-happy-hour"><?php echo esc_html($location_happy_hour); ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="https://www.opentable.ca/r/sports-illustrated-clubhouse-reservations-vancouver?restref=1307443&lang=en-CA&ot_source=Restaurant%20website" 
                       class="reserve-button" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        RESERVE A TABLE
                    </a>
                </div>
            </div>
            <?php
            endif;
        }
        ?>
    </div>
</section> 