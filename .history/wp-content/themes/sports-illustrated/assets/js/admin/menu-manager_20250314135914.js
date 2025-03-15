/**
 * Sports Illustrated Menu Manager Scripts
 */
(function($) {
    'use strict';
    
    // Initialize the menu manager
    function initMenuManager() {
        // Handle reset buttons
        $('.si-reset-button').on('click', function(e) {
            e.preventDefault();
            
            const resetType = $(this).data('reset-type');
            const confirmMessage = resetType === 'all' 
                ? 'Are you sure you want to reset ALL menus to default values? This cannot be undone.'
                : `Are you sure you want to reset the ${resetType} menu to default values? This cannot be undone.`;
            
            if (confirm(confirmMessage)) {
                // Show loading spinner on all reset buttons
                $('.si-reset-button').prop('disabled', true);
                
                // Show loading spinner on the clicked button
                $(this).addClass('loading');
                $(this).find('.spinner').addClass('is-active');
                
                // Make AJAX request to reset menu
                $.ajax({
                    url: siMenuManager.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'si_reset_menu',
                        reset_type: resetType,
                        security: siMenuManager.security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            const successMessage = $('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                            $('.menu-manager-section').prepend(successMessage);
                            
                            // Redirect to customizer if needed
                            if (response.data.redirect) {
                                setTimeout(function() {
                                    window.location.href = response.data.redirect;
                                }, 1000);
                            } else {
                                // Remove loading state
                                $('.si-reset-button').removeClass('loading').prop('disabled', false);
                                $('.si-reset-button').find('.spinner').removeClass('is-active');
                            }
                        } else {
                            // Show error message
                            const errorMessage = $('<div class="notice notice-error is-dismissible"><p>Error: ' + response.data.message + '</p></div>');
                            $('.menu-manager-section').prepend(errorMessage);
                            
                            // Remove loading state
                            $('.si-reset-button').removeClass('loading').prop('disabled', false);
                            $('.si-reset-button').find('.spinner').removeClass('is-active');
                        }
                    },
                    error: function() {
                        // Show error message
                        const errorMessage = $('<div class="notice notice-error is-dismissible"><p>An error occurred. Please try again.</p></div>');
                        $('.menu-manager-section').prepend(errorMessage);
                        
                        // Remove loading state
                        $('.si-reset-button').removeClass('loading').prop('disabled', false);
                        $('.si-reset-button').find('.spinner').removeClass('is-active');
                    }
                });
            }
        });
        
        // Make notices dismissible
        $(document).on('click', '.notice-dismiss', function() {
            $(this).closest('.notice').fadeOut(300, function() {
                $(this).remove();
            });
        });
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initMenuManager();
    });
    
})(jQuery); 