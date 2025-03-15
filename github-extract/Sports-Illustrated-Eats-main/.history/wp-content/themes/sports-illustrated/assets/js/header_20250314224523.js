jQuery(document).ready(function($) {
    const hamburger = $('.hamburger');
    const mobileMenu = $('.mobile-menu');
    const body = $('body');

    // Toggle mobile menu
    hamburger.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('active');
        mobileMenu.toggleClass('active');
        body.toggleClass('menu-open');
    });

    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu, .hamburger').length && mobileMenu.hasClass('active')) {
            hamburger.removeClass('active');
            mobileMenu.removeClass('active');
            body.removeClass('menu-open');
        }
    });

    // Close menu on escape key
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape' && mobileMenu.hasClass('active')) {
            hamburger.removeClass('active');
            mobileMenu.removeClass('active');
            body.removeClass('menu-open');
        }
    });

    // Prevent menu clicks from closing the menu
    mobileMenu.on('click', function(e) {
        e.stopPropagation();
    });
}); 