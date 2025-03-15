jQuery(document).ready(function($) {
    console.log('jQuery ready fired');
    
    // Mobile menu functionality
    const $hamburger = $('.hamburger');
    const $mobileMenu = $('.mobile-menu');
    const $body = $('body');
    
    console.log('Hamburger element:', $hamburger.length);
    console.log('Mobile menu element:', $mobileMenu.length);

    if ($hamburger.length && $mobileMenu.length) {
        // Toggle menu on hamburger click
        $hamburger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $(this).toggleClass('active');
            $mobileMenu.toggleClass('active');
            $body.toggleClass('menu-open');
            
            const isExpanded = $(this).hasClass('active');
            $(this).attr('aria-expanded', isExpanded);
            $mobileMenu.attr('aria-hidden', !isExpanded);
        });

        // Close menu when clicking a link
        $mobileMenu.find('a').on('click', function() {
            $hamburger.removeClass('active').attr('aria-expanded', 'false');
            $mobileMenu.removeClass('active').attr('aria-hidden', 'true');
            $body.removeClass('menu-open');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu, .hamburger').length && 
                $mobileMenu.hasClass('active')) {
                $hamburger.removeClass('active').attr('aria-expanded', 'false');
                $mobileMenu.removeClass('active').attr('aria-hidden', 'true');
                $body.removeClass('menu-open');
            }
        });

        // Handle escape key
        $(document).on('keyup', function(e) {
            if (e.key === 'Escape' && $mobileMenu.hasClass('active')) {
                $hamburger.removeClass('active').attr('aria-expanded', 'false');
                $mobileMenu.removeClass('active').attr('aria-hidden', 'true');
                $body.removeClass('menu-open');
            }
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