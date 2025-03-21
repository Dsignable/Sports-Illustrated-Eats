/**
 * Menu Manager JavaScript
 */
jQuery(document).ready(function($) {
    
    /**
     * Menu Type Navigation
     */
    $('.si-menu-types-nav a').on('click', function(e) {
        e.preventDefault();
        
        var menuType = $(this).data('menu-type');
        
        // Update active class
        $('.si-menu-types-nav a').removeClass('active');
        $(this).addClass('active');
        
        // Show corresponding menu type
        $('.si-menu-type-content').hide();
        $('#si-menu-type-' + menuType).show();
        
        // Update hidden field
        $('#si_current_menu_type').val(menuType);
    });
    
    /**
     * Reset Menu Confirmation
     */
    $('.si-button-reset').on('click', function(e) {
        if (!confirm('Are you sure you want to reset this menu to default settings? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
    
    /**
     * Menu Item Actions
     */
    // Edit menu item
    $(document).on('click', '.si-edit-menu-item', function(e) {
        e.preventDefault();
        
        var itemId = $(this).data('item-id');
        var $item = $('#si-menu-item-' + itemId);
        
        // Toggle edit form
        $item.find('.si-menu-item-edit-form').toggle();
    });
    
    // Save menu item
    $(document).on('submit', '.si-menu-item-edit-form', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $item = $form.closest('.si-menu-item');
        var itemId = $form.data('item-id');
        
        // Show loading indicator
        $form.find('.si-loader').show();
        
        // Collect form data
        var formData = {
            action: 'si_update_menu_item',
            security: siMenuManager.security,
            item_id: itemId,
            menu_type: $('#si_current_menu_type').val(),
            name: $form.find('.si-item-name').val(),
            description: $form.find('.si-item-description').val(),
            price: $form.find('.si-item-price').val()
        };
        
        // Send Ajax request
        $.post(siMenuManager.ajaxUrl, formData, function(response) {
            $form.find('.si-loader').hide();
            
            if (response.success) {
                // Update item display
                $item.find('.si-menu-item-name').text(formData.name);
                $item.find('.si-menu-item-description').text(formData.description);
                $item.find('.si-menu-item-price').text('$' + formData.price);
                
                // Hide form
                $form.hide();
                
                // Show success message
                $item.append('<div class="si-notice si-notice-success">' + response.data.message + '</div>');
                setTimeout(function() {
                    $item.find('.si-notice').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            } else {
                // Show error message
                $form.after('<div class="si-notice si-notice-error">' + response.data.message + '</div>');
                setTimeout(function() {
                    $form.next('.si-notice').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }).fail(function() {
            $form.find('.si-loader').hide();
            $form.after('<div class="si-notice si-notice-error">An error occurred. Please try again.</div>');
            setTimeout(function() {
                $form.next('.si-notice').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        });
    });
    
    /**
     * Add New Menu Item
     */
    $('.si-add-menu-item-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var menuType = $('#si_current_menu_type').val();
        var sectionId = $form.data('section-id');
        
        // Show loading indicator
        $form.find('.si-loader').show();
        
        // Collect form data
        var formData = {
            action: 'si_add_menu_item',
            security: siMenuManager.security,
            menu_type: menuType,
            section_id: sectionId,
            name: $form.find('.si-new-item-name').val(),
            description: $form.find('.si-new-item-description').val(),
            price: $form.find('.si-new-item-price').val()
        };
        
        // Send Ajax request
        $.post(siMenuManager.ajaxUrl, formData, function(response) {
            $form.find('.si-loader').hide();
            
            if (response.success) {
                // Reset form
                $form[0].reset();
                
                // Add new item to the list
                $('#si-menu-items-' + sectionId).append(response.data.html);
                
                // Show success message
                $form.prepend('<div class="si-notice si-notice-success">' + response.data.message + '</div>');
                setTimeout(function() {
                    $form.find('.si-notice').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            } else {
                // Show error message
                $form.prepend('<div class="si-notice si-notice-error">' + response.data.message + '</div>');
                setTimeout(function() {
                    $form.find('.si-notice').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }).fail(function() {
            $form.find('.si-loader').hide();
            $form.prepend('<div class="si-notice si-notice-error">An error occurred. Please try again.</div>');
            setTimeout(function() {
                $form.find('.si-notice').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        });
    });
    
    /**
     * Toggle Add New Item Form
     */
    $('.si-toggle-add-form').on('click', function(e) {
        e.preventDefault();
        
        var sectionId = $(this).data('section-id');
        $('#si-add-form-' + sectionId).toggle();
    });
}); 