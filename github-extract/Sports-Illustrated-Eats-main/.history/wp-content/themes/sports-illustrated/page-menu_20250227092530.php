<?php
/**
 * Template Name: Menu Page
 *
 * @package Sports_Illustrated
 */

get_header();
?>

<main id="primary" class="site-main menu-page">
    <nav class="menu-container">
        <div class="menu-buttons">
            <button class="menu-btn full-menu active" data-menu="full">FULL MENU</button>
            <button class="menu-btn happy-hour" data-menu="happy">HAPPY HOUR</button>
            <button class="menu-btn drink-menu" data-menu="drink">DRINK MENU</button>
            <button class="menu-btn todays-menu" data-menu="today">TODAY'S MENU</button>
        </div>
        <section class="image-section">
            <div class="pdf-wrapper">
                <iframe src="<?php echo esc_url(si_get_menu_pdf_url('si_menu_full')); ?>" 
                        class="menu-pdf active" 
                        data-menu="full"
                        title="Full Menu"></iframe>
                <iframe src="<?php echo esc_url(si_get_menu_pdf_url('si_menu_happy')); ?>" 
                        class="menu-pdf" 
                        data-menu="happy"
                        title="Happy Hour Menu"></iframe>
                <iframe src="<?php echo esc_url(si_get_menu_pdf_url('si_menu_drink')); ?>" 
                        class="menu-pdf" 
                        data-menu="drink"
                        title="Drink Menu"></iframe>
                <iframe src="<?php 
                    $today = strtolower(date('l'));
                    echo esc_url(si_get_menu_pdf_url('si_menu_' . $today)); 
                    ?>" 
                        class="menu-pdf" 
                        data-menu="today"
                        title="Today's Menu"></iframe>
            </div>
        </section>
    </nav>
</main>

<?php
get_footer(); 