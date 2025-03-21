/**
 * Sports Illustrated Menu Manager
 * JavaScript functionality for the admin menu manager
 */
(function($) {
    'use strict';

    // Main Menu Manager object
    var SIMenuManager = {
        init: function() {
            this.bindEvents();
            this.initMenuTypesTabs();
        },
        
        bindEvents: function() {
            // Menu edit buttons
            $('.si-edit-menu-button').on('click', this.handleEditMenuClick);
            
            // Reset buttons
            $('.si-reset-button').on('click', this.handleResetClick);
            
            // Save menu button
            $(document).on('click', '.si-save-menu', this.handleSaveMenu);
            
            // Cancel edit button
            $(document).on('click', '.si-cancel-edit', this.handleCancelEdit);
            
            // Add section button
            $(document).on('click', '.si-add-section', this.handleAddSection);
            
            // Add item button
            $(document).on('click', '.si-add-item', this.handleAddItem);
            
            // Toggle section visibility
            $(document).on('click', '.si-toggle-section', this.handleToggleSection);
            
            // Toggle subsection checkbox
            $(document).on('change', '.si-subsection-toggle', this.handleSubsectionToggle);
        },
        
        handleEditMenuClick: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var menuType = $button.data('menu-type');
            var $container = $('#si-menu-editor-container');
            var $loading = $container.find('.si-menu-editor-loading');
            
            // Show loading state
            $container.show();
            $loading.show();
            
            // Send AJAX request to load menu editor
            $.ajax({
                url: siMenuManager.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'si_load_menu_editor',
                    menu_type: menuType,
                    security: siMenuManager.security
                },
                success: function(response) {
                    if (response.success) {
                        // Hide loading and show editor
                        $loading.hide();
                        $container.html(response.data.html);
                        
                        // Initialize sortable for new content
                        SIMenuManager.initSortable();
                        
                        // Scroll to editor
                        $('html, body').animate({
                            scrollTop: $container.offset().top - 50
                        }, 500);
                    } else {
                        // Show error message
                        SIMenuManager.showNotice('error', response.data.message || siMenuManager.loadError);
                        $container.hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message
                    console.error('AJAX Error:', status, error);
                    SIMenuManager.showNotice('error', siMenuManager.loadError);
                    $container.hide();
                }
            });
        },
        
        handleSaveMenu: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var menuType = $button.data('menu-type');
            var $form = $button.closest('.si-menu-editor-form');
            var $spinner = $button.find('.spinner');
            
            // Show spinner and disable button
            $spinner.addClass('is-active');
            $button.prop('disabled', true);
            
            // Collect form data
            var formData = $form.find(':input').serialize();
            
            // Send save request
            $.ajax({
                url: siMenuManager.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'si_save_menu',
                    menu_type: menuType,
                    form_data: formData,
                    security: siMenuManager.security
                },
                success: function(response) {
                    if (response.success) {
                        SIMenuManager.showNotice('success', response.data.message || siMenuManager.saveSuccess);
                        
                        // Reload page after short delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        SIMenuManager.showNotice('error', response.data.message || siMenuManager.saveError);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    SIMenuManager.showNotice('error', siMenuManager.saveError);
                },
                complete: function() {
                    // Hide spinner and re-enable button
                    $spinner.removeClass('is-active');
                    $button.prop('disabled', false);
                }
            });
        },
        
        handleCancelEdit: function(e) {
            e.preventDefault();
            
            if (confirm(siMenuManager.confirmCancel)) {
                $('#si-menu-editor-container').hide().empty();
                
                // Scroll back to top
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        },
        
        handleResetClick: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var resetType = $button.data('reset-type');
            var $spinner = $button.find('.spinner');
            
            if (!confirm(siMenuManager.confirmReset)) {
                return;
            }
            
            // Show spinner
            $spinner.addClass('is-active');
            $button.prop('disabled', true);
            
            // Send reset request
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
                        SIMenuManager.showNotice('success', siMenuManager.resetSuccess);
                        // Reload page after short delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        SIMenuManager.showNotice('error', response.data.message || siMenuManager.resetError);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    SIMenuManager.showNotice('error', siMenuManager.resetError);
                },
                complete: function() {
                    // Hide spinner and re-enable button
                    $spinner.removeClass('is-active');
                    $button.prop('disabled', false);
                }
            });
        },
        
        handleToggleSection: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $section = $button.closest('.si-menu-editor-section');
            var $content = $section.find('.si-menu-editor-section-content');
            
            $content.slideToggle();
            $button.find('.dashicons').toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        },
        
        handleSubsectionToggle: function() {
            var $checkbox = $(this);
            var $row = $checkbox.closest('tr');
            
            if ($checkbox.is(':checked')) {
                $row.addClass('si-subsection-row');
                $row.find('input[name*="_notes"]').val('subsection');
            } else {
                $row.removeClass('si-subsection-row');
                $row.find('input[name*="_notes"]').val('');
            }
        },
        
        showNotice: function(type, message) {
            var $notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
            
            // Remove any existing notices
            $('.notice').remove();
            
            // Add new notice at the top of the page
            $('.wrap h1').after($notice);
            
            // Make the notice dismissible
            $notice.on('click', '.notice-dismiss', function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            });
            
            // Auto dismiss after 5 seconds
            setTimeout(function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    };
    
    // Initialize when document is ready
    $(document).ready(function() {
        SIMenuManager.init();
    });
    
})(jQuery); 