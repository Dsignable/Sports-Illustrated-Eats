/**
 * Sports Illustrated Menu Manager Scripts
 */
(function($) {
    'use strict';
    
    // Initialize the menu manager
    function initMenuManager() {
        // Handle reset menu button click
        $('.si-reset-menu').on('click', function(e) {
            e.preventDefault();
            
            const menuType = $(this).data('menu');
            const menuName = $(this).text().replace('Reset ', '');
            
            // Confirm reset
            if (confirm(siMenuManager.confirmReset)) {
                resetMenu(menuType, menuName);
            }
        });
        
        // Handle reset all menus button click
        $('.si-reset-all-menus').on('click', function(e) {
            e.preventDefault();
            
            // Confirm reset all
            if (confirm(siMenuManager.confirmResetAll)) {
                resetMenu('all', 'All Menus');
            }
        });
    }
    
    // Reset menu function
    function resetMenu(menuType, menuName) {
        // Show loading state
        const $responseContainer = $('#si-menu-reset-response');
        $responseContainer.html('<p><span class="spinner is-active" style="float:none;margin:0 10px 0 0"></span> Resetting ' + menuName + '...</p>');
        $responseContainer.show();
        
        // Send AJAX request
        $.ajax({
            url: siMenuManager.ajaxUrl,
            type: 'POST',
            data: {
                action: 'si_reset_menu',
                menu: menuType,
                nonce: siMenuManager.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $responseContainer.html('<p><span class="dashicons dashicons-yes" style="color:#46b450"></span> ' + response.data.message + '</p>');
                    $responseContainer.removeClass('error');
                    
                    // Scroll to response
                    $('html, body').animate({
                        scrollTop: $responseContainer.offset().top - 100
                    }, 500);
                    
                    // Add customize link
                    $responseContainer.append('<p><a href="' + siMenuManager.ajaxUrl.replace('admin-ajax.php', '') + 'customize.php?autofocus[section]=si_menu_display_section" class="button button-primary">Customize Menu</a></p>');
                } else {
                    // Show error message
                    $responseContainer.html('<p><span class="dashicons dashicons-no" style="color:#dc3232"></span> ' + response.data.message + '</p>');
                    $responseContainer.addClass('error');
                }
            },
            error: function() {
                // Show error message
                $responseContainer.html('<p><span class="dashicons dashicons-no" style="color:#dc3232"></span> An error occurred while resetting the menu. Please try again.</p>');
                $responseContainer.addClass('error');
            }
        });
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initMenuManager();
    });
    
})(jQuery); 