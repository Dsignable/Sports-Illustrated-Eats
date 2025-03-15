jQuery(document).ready(function($) {
    // Show first menu by default
    $('.menu-image').first().show();
    $('.menu-btn').first().addClass('active');

    // Handle menu button clicks
    $('.menu-btn').on('click', function() {
        const menuType = $(this).data('menu');
        
        // Update active button
        $('.menu-btn').removeClass('active');
        $(this).addClass('active');
        
        // Hide all menu images and show selected one
        $('.menu-image').hide();
        $('.menu-image[data-menu="' + menuType + '"]').fadeIn();
    });
}); 