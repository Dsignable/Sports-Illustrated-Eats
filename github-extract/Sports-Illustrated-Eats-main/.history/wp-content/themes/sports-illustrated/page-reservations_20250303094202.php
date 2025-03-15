<?php
/**
 * Template Name: Reservations Page
 *
 * @package Sports_Illustrated
 */

get_header();

// Get customizer settings
$header_image = get_theme_mod('si_reservations_header_image', '');
$page_title = get_theme_mod('si_reservations_title', __('Make a Reservation', 'sports-illustrated'));
$page_description = get_theme_mod('si_reservations_description', __('Book your table at Sports Illustrated Clubhouse for an unforgettable dining experience.', 'sports-illustrated'));
?>

<main id="primary" class="site-main reservations-page">
    <!-- Reservations Header Section -->
    <section class="reservations-header" <?php echo $header_image ? 'style="background-image: url(' . esc_url($header_image) . ');"' : ''; ?>>
        <div class="reservations-header-content">
            <h1 class="reservations-title"><?php echo esc_html($page_title); ?></h1>
            <p class="reservations-description"><?php echo wp_kses_post($page_description); ?></p>
        </div>
    </section>

    <!-- Reservations Content Section -->
    <section class="reservations-content">
        <div class="reservations-container">
            <?php
            // Display the page content first
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>

            <!-- OpenTable Widget Section -->
            <div class="opentable-widget">
                <script type='text/javascript' src='//www.opentable.ca/widget/reservation/loader?rid=1307443&type=standard&theme=wide&color=1&dark=false&iframe=true&domain=ca&lang=en-CA&newtab=true&ot_source=Restaurant%20website&cfe=true'></script>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?> 