jQuery(document).ready(function($) {
    console.log('jQuery ready fired');
    
    // Mobile menu functionality
    const $hamburger = $('.hamburger');
    const $mobileMenu = $('.mobile-menu');
    
    console.log('Hamburger element:', $hamburger.length);
    console.log('Mobile menu element:', $mobileMenu.length);

    if ($hamburger.length && $mobileMenu.length) {
        $hamburger.on('click', function(e) {
            e.preventDefault();
            console.log('Hamburger clicked');
            
            $hamburger.toggleClass('active');
            $mobileMenu.toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        // Close mobile menu when clicking a link
        $('.mobile-menu a').on('click', function() {
            console.log('Mobile menu link clicked');
            $hamburger.removeClass('active');
            $mobileMenu.removeClass('active');
            $('body').removeClass('menu-open');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if ($mobileMenu.hasClass('active')) {
                if (!$mobileMenu.is(e.target) && 
                    !$hamburger.is(e.target) && 
                    $mobileMenu.has(e.target).length === 0 && 
                    $hamburger.has(e.target).length === 0) {
                    
                    $hamburger.removeClass('active');
                    $mobileMenu.removeClass('active');
                    $('body').removeClass('menu-open');
                }
            }
        });
    }

    // Scroll handling for header
    const $header = $('.site-header');
    let lastScroll = 0;

    $(window).on('scroll', function() {
        const currentScroll = $(window).scrollTop();

        if (currentScroll > lastScroll && currentScroll > 100) {
            // Scrolling down & past header
            $header.addClass('header-hidden');
        } else {
            // Scrolling up
            $header.removeClass('header-hidden');
        }

        lastScroll = currentScroll;
    });
}); 