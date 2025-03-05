jQuery(document).ready(function($) {
    console.log('jQuery ready fired');
    
    // Mobile menu functionality
    const $hamburger = $('.hamburger');
    const $mobileMenu = $('.mobile-menu');
    const $body = $('body');
    
    console.log('Hamburger element:', $hamburger.length);
    console.log('Mobile menu element:', $mobileMenu.length);

    if ($hamburger.length && $mobileMenu.length) {
        $hamburger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $hamburger.toggleClass('active');
            $mobileMenu.toggleClass('active');
            $body.toggleClass('menu-open');
        });

        // Close mobile menu when clicking a link
        $mobileMenu.find('a').on('click', function() {
            $hamburger.removeClass('active');
            $mobileMenu.removeClass('active');
            $body.removeClass('menu-open');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$mobileMenu.is(e.target) && 
                !$hamburger.is(e.target) && 
                $mobileMenu.has(e.target).length === 0 && 
                $hamburger.has(e.target).length === 0) {
                
                $hamburger.removeClass('active');
                $mobileMenu.removeClass('active');
                $body.removeClass('menu-open');
            }
        });

        // Prevent clicks inside mobile menu from closing it
        $mobileMenu.on('click', function(e) {
            e.stopPropagation();
        });
    }

    // Scroll handling for header
    const $header = $('.site-header');
    let lastScroll = 0;
    let scrollTimer;

    $(window).on('scroll', function() {
        if (scrollTimer) {
            clearTimeout(scrollTimer);
        }

        scrollTimer = setTimeout(function() {
            const currentScroll = $(window).scrollTop();

            if (currentScroll > lastScroll && currentScroll > 100) {
                // Scrolling down & past header
                $header.addClass('header-hidden');
            } else {
                // Scrolling up
                $header.removeClass('header-hidden');
            }

            lastScroll = currentScroll;
        }, 50);
    });
}); 