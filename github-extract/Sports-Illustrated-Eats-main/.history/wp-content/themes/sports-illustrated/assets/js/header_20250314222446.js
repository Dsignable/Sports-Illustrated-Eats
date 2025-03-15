jQuery(document).ready(function($) {
    // Variables
    const hamburger = $('.hamburger');
    const mobileMenu = $('.mobile-menu');
    const body = $('body');
    let lastScrollTop = 0;
    let isMenuOpen = false;

    // Toggle mobile menu
    hamburger.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        $(this).toggleClass('active');
        mobileMenu.toggleClass('active');
        body.toggleClass('menu-open');
        isMenuOpen = !isMenuOpen;
    });

    // Handle menu items with dropdowns
    $('.mobile-menu a').each(function() {
        if ($(this).next('.mobile-submenu-item').length) {
            $(this).parent().addClass('menu-item-has-children');
        }
    });

    // Toggle dropdown items
    $('.menu-item-has-children > a').on('click', function(e) {
        if (window.innerWidth <= 991) {
            e.preventDefault();
            e.stopPropagation();
            $(this).parent().toggleClass('active');
        }
    });

    // Close mobile menu on window resize
    $(window).on('resize', function() {
        if (window.innerWidth > 991 && isMenuOpen) {
            closeMenu();
        }
    });

    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (isMenuOpen && !$(e.target).closest('.mobile-menu, .hamburger').length) {
            closeMenu();
        }
    });

    // Close menu with escape key
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
        }
    });

    // Function to close menu
    function closeMenu() {
        hamburger.removeClass('active');
        mobileMenu.removeClass('active');
        body.removeClass('menu-open');
        isMenuOpen = false;
    }

    // Hide header on scroll down, show on scroll up
    $(window).on('scroll', function() {
        if (!isMenuOpen) {
            const currentScroll = $(this).scrollTop();
            if (currentScroll > lastScrollTop && currentScroll > 100) {
                // Scrolling down
                $('.site-header').addClass('header-hidden');
            } else {
                // Scrolling up
                $('.site-header').removeClass('header-hidden');
            }
            lastScrollTop = currentScroll;
        }
    });
}); 