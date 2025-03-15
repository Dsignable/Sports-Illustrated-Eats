jQuery(document).ready(function($) {
    // Cache DOM elements
    const hamburger = $('.hamburger');
    const mobileMenu = $('#mobile-menu');
    const body = $('body');
    
    console.log('Header.js initialized');
    console.log('Hamburger element exists:', hamburger.length);
    console.log('Mobile menu element exists:', mobileMenu.length);
    
    // Toggle mobile menu
    hamburger.on('click', function(e) {
        console.log('Hamburger clicked');
        e.preventDefault();
        e.stopPropagation();
        
        const isActive = hamburger.hasClass('active');
        console.log('Current menu state:', isActive ? 'active' : 'inactive');
        
        hamburger.toggleClass('active');
        mobileMenu.toggleClass('active');
        body.toggleClass('menu-open');
        
        console.log('Menu state after toggle:', hamburger.hasClass('active') ? 'active' : 'inactive');
        console.log('Mobile menu visibility:', mobileMenu.is(':visible'));
    });

    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu, .hamburger').length && mobileMenu.hasClass('active')) {
            console.log('Clicked outside menu - closing');
            hamburger.removeClass('active');
            mobileMenu.removeClass('active');
            body.removeClass('menu-open');
        }
    });

    // Close menu on escape key
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape' && mobileMenu.hasClass('active')) {
            console.log('Escape key pressed - closing menu');
            hamburger.removeClass('active');
            mobileMenu.removeClass('active');
            body.removeClass('menu-open');
        }
    });

    // Prevent menu from closing when clicking inside
    mobileMenu.on('click', function(e) {
        console.log('Clicked inside mobile menu');
        e.stopPropagation();
    });
}); 