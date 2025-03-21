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
            // Menu type navigation
            $('.si-menu-types-nav a').on('click', this.handleMenuTypeChange);
            
            // Add section button
            $('.si-add-section-button').on('click', this.handleAddSection);
            
            // Add item button
            $('.si-add-item-button').on('click', this.handleAddItem);
            
            // Edit item button
            $(document).on('click', '.si-edit-item-button', this.handleEditItem);
            
            // Delete item button
            $(document).on('click', '.si-delete-item-button', this.handleDeleteItem);
            
            // Edit section button
            $(document).on('click', '.si-edit-section-button', this.handleEditSection);
            
            // Delete section button
            $(document).on('click', '.si-delete-section-button', this.handleDeleteSection);
            
            // Save menu form
            $(document).on('submit', '.si-menu-form', this.handleSaveMenu);
            
            // Sort sections
            this.initSortable();
        },
        
        initMenuTypesTabs: function() {
            // Show the active menu type
            var activeType = $('.si-menu-types-nav a.active').data('type');
            $('.si-menu-type-container').hide();
            $('#si-menu-type-' + activeType).show();
        },
        
        handleMenuTypeChange: function(e) {
            e.preventDefault();
            
            var $link = $(this);
            var menuType = $link.data('type');
            
            // Update active tab
            $('.si-menu-types-nav a').removeClass('active');
            $link.addClass('active');
            
            // Show corresponding menu container
            $('.si-menu-type-container').hide();
            $('#si-menu-type-' + menuType).show();
        },
        
        handleAddSection: function(e) {
            e.preventDefault();
            
            var menuType = $(this).data('menu-type');
            
            // Show the add section form
            $('#si-add-section-form-' + menuType).toggle();
        },
        
        handleAddItem: function(e) {
            e.preventDefault();
            
            var sectionId = $(this).data('section-id');
            
            // Show the add item form
            $('#si-add-item-form-' + sectionId).toggle();
        },
        
        handleEditItem: function(e) {
            e.preventDefault();
            
            var itemId = $(this).data('item-id');
            
            // Toggle edit form
            $('#si-edit-item-form-' + itemId).toggle();
        },
        
        handleDeleteItem: function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this item?')) {
                var itemId = $(this).data('item-id');
                var nonce = $(this).data('nonce');
                
                // Send delete request
                SIMenuManager.sendAjaxRequest({
                    action: 'si_delete_menu_item',
                    item_id: itemId,
                    nonce: nonce
                }, function(response) {
                    if (response.success) {
                        // Remove item from DOM
                        $('#si-menu-item-' + itemId).remove();
                        
                        // Show success message
                        SIMenuManager.showNotice('success', response.data.message);
                    } else {
                        // Show error
                        SIMenuManager.showNotice('error', response.data.message);
                    }
                });
            }
        },
        
        handleEditSection: function(e) {
            e.preventDefault();
            
            var sectionId = $(this).data('section-id');
            
            // Toggle edit form
            $('#si-edit-section-form-' + sectionId).toggle();
        },
        
        handleDeleteSection: function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this section and all its items?')) {
                var sectionId = $(this).data('section-id');
                var nonce = $(this).data('nonce');
                
                // Send delete request
                SIMenuManager.sendAjaxRequest({
                    action: 'si_delete_menu_section',
                    section_id: sectionId,
                    nonce: nonce
                }, function(response) {
                    if (response.success) {
                        // Remove section from DOM
                        $('#si-menu-section-' + sectionId).remove();
                        
                        // Show success message
                        SIMenuManager.showNotice('success', response.data.message);
                    } else {
                        // Show error
                        SIMenuManager.showNotice('error', response.data.message);
                    }
                });
            }
        },
        
        handleSaveMenu: function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $submitButton = $form.find(':submit');
            var $loader = $form.find('.si-loader');
            
            // Disable submit button and show loader
            $submitButton.prop('disabled', true);
            $loader.show();
            
            // Collect form data
            var formData = $form.serialize();
            
            // Send save request
            SIMenuManager.sendAjaxRequest({
                action: $form.data('action'),
                form_data: formData,
                nonce: $form.data('nonce')
            }, function(response) {
                // Re-enable submit button and hide loader
                $submitButton.prop('disabled', false);
                $loader.hide();
                
                if (response.success) {
                    // Hide form if it's an add form
                    if ($form.hasClass('si-add-form')) {
                        $form.hide();
                    }
                    
                    // Show success message
                    SIMenuManager.showNotice('success', response.data.message);
                    
                    // Refresh the page if needed
                    if (response.data.refresh) {
                        window.location.reload();
                    } else if (response.data.html) {
                        // Update HTML if provided
                        $(response.data.target).html(response.data.html);
                    }
                } else {
                    // Show error
                    SIMenuManager.showNotice('error', response.data.message);
                }
            });
        },
        
        initSortable: function() {
            // Make sections sortable
            $('.si-menu-sections').sortable({
                handle: '.si-menu-section-header',
                update: function(event, ui) {
                    var menuType = $(this).data('menu-type');
                    var order = $(this).sortable('toArray', { attribute: 'data-section-id' });
                    
                    // Update section order
                    SIMenuManager.updateSectionOrder(menuType, order);
                }
            });
            
            // Make items sortable within each section
            $('.si-menu-items').sortable({
                handle: '.si-menu-item-handle',
                update: function(event, ui) {
                    var sectionId = $(this).data('section-id');
                    var order = $(this).sortable('toArray', { attribute: 'data-item-id' });
                    
                    // Update item order
                    SIMenuManager.updateItemOrder(sectionId, order);
                }
            });
        },
        
        updateSectionOrder: function(menuType, order) {
            SIMenuManager.sendAjaxRequest({
                action: 'si_update_section_order',
                menu_type: menuType,
                order: order,
                nonce: si_menu_manager_params.nonce
            }, function(response) {
                if (response.success) {
                    SIMenuManager.showNotice('success', response.data.message);
                } else {
                    SIMenuManager.showNotice('error', response.data.message);
                }
            });
        },
        
        updateItemOrder: function(sectionId, order) {
            SIMenuManager.sendAjaxRequest({
                action: 'si_update_item_order',
                section_id: sectionId,
                order: order,
                nonce: si_menu_manager_params.nonce
            }, function(response) {
                if (response.success) {
                    SIMenuManager.showNotice('success', response.data.message);
                } else {
                    SIMenuManager.showNotice('error', response.data.message);
                }
            });
        },
        
        sendAjaxRequest: function(data, callback) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (callback) {
                        callback(response);
                    }
                },
                error: function() {
                    SIMenuManager.showNotice('error', 'An error occurred. Please try again.');
                }
            });
        },
        
        showNotice: function(type, message) {
            var $notice = $('<div class="si-notice si-notice-' + type + '"></div>').text(message);
            
            // Show notice at the top of the page
            $('.si-menu-manager-notices').html($notice);
            
            // Auto hide after 5 seconds
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