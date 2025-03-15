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
                // Show loading spinner
                $(this).addClass('loading').prop('disabled', true);
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
                            alert(response.data.message);
                            
                            // Redirect to customizer if needed
                            if (response.data.redirect) {
                                window.location.href = response.data.redirect;
                            } else {
                                // Remove loading state
                                $('.si-reset-button').removeClass('loading').prop('disabled', false);
                                $('.si-reset-button').find('.spinner').removeClass('is-active');
                            }
                        } else {
                            alert('Error: ' + response.data.message);
                            // Remove loading state
                            $('.si-reset-button').removeClass('loading').prop('disabled', false);
                            $('.si-reset-button').find('.spinner').removeClass('is-active');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                        // Remove loading state
                        $('.si-reset-button').removeClass('loading').prop('disabled', false);
                        $('.si-reset-button').find('.spinner').removeClass('is-active');
                    }
                });
            }
        });
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initMenuManager();
    });
    
})(jQuery); 