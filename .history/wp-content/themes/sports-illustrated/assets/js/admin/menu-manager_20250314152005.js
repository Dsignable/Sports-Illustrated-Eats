/**
 * Sports Illustrated Menu Manager Scripts
 */
(function($) {
    'use strict';
    
    // Initialize the menu manager
    function initMenuManager() {
        // Handle edit menu buttons
        $('.si-edit-menu-button').on('click', function(e) {
            e.preventDefault();
            
            const menuType = $(this).data('menu-type');
            loadMenuEditor(menuType);
        });
        
        // Handle cancel edit button
        $(document).on('click', '.si-cancel-edit', function(e) {
            e.preventDefault();
            
            if (confirm(siMenuManager.confirmCancel)) {
                hideMenuEditor();
            }
        });
        
        // Handle save menu button
        $(document).on('click', '.si-save-menu', function(e) {
            e.preventDefault();
            
            const menuType = $(this).data('menu-type');
            const $button = $(this);
            const $form = $('.si-menu-editor-form');
            
            // Show loading state
            $button.addClass('loading').prop('disabled', true);
            $button.find('.spinner').addClass('is-active');
            $button.text(siMenuManager.savingText);
            
            // Get form data
            const formData = $form.find('input, textarea, select').serialize();
            
            // Make AJAX request to save menu
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
                    // Remove loading state
                    $button.removeClass('loading').prop('disabled', false);
                    $button.find('.spinner').removeClass('is-active');
                    $button.text('Save Changes');
                    
                    if (response.success) {
                        // Show success message
                        showMessage(response.data.message, 'success');
                        
                        // Hide editor after a delay
                        setTimeout(function() {
                            hideMenuEditor();
                        }, 2000);
                    } else {
                        // Show error message
                        showMessage(response.data.message, 'error');
                    }
                },
                error: function() {
                    // Remove loading state
                    $button.removeClass('loading').prop('disabled', false);
                    $button.find('.spinner').removeClass('is-active');
                    $button.text('Save Changes');
                    
                    // Show error message
                    showMessage('An error occurred while saving the menu. Please try again.', 'error');
                }
            });
        });
        
        // Handle toggle section button
        $(document).on('click', '.si-toggle-section', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $section = $button.closest('.si-menu-editor-section');
            const $content = $section.find('.si-menu-editor-section-content');
            
            $content.slideToggle(200);
            $button.find('.dashicons').toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        });
        
        // Handle subsection toggle
        $(document).on('change', '.si-subsection-toggle', function() {
            const $checkbox = $(this);
            const $row = $checkbox.closest('tr');
            const $notesInput = $row.find('input[name$="_notes"]');
            
            if ($checkbox.is(':checked')) {
                $notesInput.val('subsection');
                $row.addClass('si-subsection-row');
            } else {
                if ($notesInput.val() === 'subsection') {
                    $notesInput.val('');
                }
                $row.removeClass('si-subsection-row');
            }
        });
        
        // Handle add item button
        $(document).on('click', '.si-add-item', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const sectionNum = $button.data('section');
            const $table = $button.closest('table');
            const $tbody = $table.find('tbody');
            const menuType = $('.si-menu-editor-form').data('menu-type');
            
            // Get the last item number
            let lastItemNum = 1;
            const $lastRow = $tbody.find('tr:last');
            
            if ($lastRow.length) {
                lastItemNum = parseInt($lastRow.data('item'), 10) + 1;
            }
            
            // Maximum 20 items per section
            if (lastItemNum > 20) {
                alert('Maximum 20 items per section reached.');
                return;
            }
            
            // Create new row
            const sectionId = `si_written_menu_${menuType}_section_${sectionNum}`;
            const itemId = `${sectionId}_item_${lastItemNum}`;
            
            const $newRow = $(`
                <tr data-item="${lastItemNum}">
                    <td class="si-item-name">
                        <input type="text" name="${itemId}_name" value="" placeholder="Item name">
                    </td>
                    <td class="si-item-description">
                        <textarea name="${itemId}_description" rows="2" placeholder="Item description"></textarea>
                    </td>
                    <td class="si-item-price">
                        <input type="text" name="${itemId}_price" value="" placeholder="Price">
                    </td>
                    <td class="si-item-notes">
                        <input type="text" name="${itemId}_notes" value="" placeholder="Notes">
                        <label>
                            <input type="checkbox" class="si-subsection-toggle">
                            Subsection
                        </label>
                    </td>
                </tr>
            `);
            
            $tbody.append($newRow);
        });
        
        // Handle add section button
        $(document).on('click', '.si-add-section', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $sections = $('.si-menu-editor-sections');
            const menuType = $('.si-menu-editor-form').data('menu-type');
            
            // Get the last section number
            let lastSectionNum = 1;
            const $lastSection = $sections.find('.si-menu-editor-section:last');
            
            if ($lastSection.length) {
                lastSectionNum = parseInt($lastSection.data('section'), 10) + 1;
            }
            
            // Maximum 10 sections
            if (lastSectionNum > 10) {
                alert('Maximum 10 sections reached.');
                return;
            }
            
            // Create new section
            const sectionId = `si_written_menu_${menuType}_section_${lastSectionNum}`;
            
            const $newSection = $(`
                <div class="si-menu-editor-section" data-section="${lastSectionNum}">
                    <div class="si-menu-editor-section-header">
                        <h3>Section ${lastSectionNum}</h3>
                        <div class="si-menu-editor-section-actions">
                            <button type="button" class="button si-toggle-section" data-section="${lastSectionNum}">
                                <span class="dashicons dashicons-arrow-down-alt2"></span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="si-menu-editor-section-content">
                        <div class="si-menu-editor-field">
                            <label for="${sectionId}_title">Section Title</label>
                            <input type="text" id="${sectionId}_title" name="${sectionId}_title" value="" class="regular-text">
                        </div>
                        
                        <div class="si-menu-editor-field">
                            <label for="${sectionId}_description">Section Description</label>
                            <textarea id="${sectionId}_description" name="${sectionId}_description" rows="2" class="large-text"></textarea>
                        </div>
                        
                        <div class="si-menu-editor-items">
                            <h4>Menu Items</h4>
                            
                            <table class="widefat si-menu-items-table">
                                <thead>
                                    <tr>
                                        <th class="si-item-name">Name</th>
                                        <th class="si-item-description">Description</th>
                                        <th class="si-item-price">Price</th>
                                        <th class="si-item-notes">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-item="1">
                                        <td class="si-item-name">
                                            <input type="text" name="${sectionId}_item_1_name" value="" placeholder="Item name">
                                        </td>
                                        <td class="si-item-description">
                                            <textarea name="${sectionId}_item_1_description" rows="2" placeholder="Item description"></textarea>
                                        </td>
                                        <td class="si-item-price">
                                            <input type="text" name="${sectionId}_item_1_price" value="" placeholder="Price">
                                        </td>
                                        <td class="si-item-notes">
                                            <input type="text" name="${sectionId}_item_1_notes" value="" placeholder="Notes">
                                            <label>
                                                <input type="checkbox" class="si-subsection-toggle">
                                                Subsection
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" class="button si-add-item" data-section="${lastSectionNum}">
                                                Add Item
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            `);
            
            $newSection.insertBefore($button.parent());
        });
        
        // Handle reset buttons
        $('.si-reset-button').off('click').on('click', function(e) {
            e.preventDefault();
            
            const resetType = $(this).data('reset-type');
            const $button = $(this);
            
            // Prevent multiple clicks
            if ($button.hasClass('loading')) {
                return;
            }
            
            // Use the localized string for confirmation
            if (confirm(siMenuManager.confirmReset)) {
                // Show loading spinner on the clicked button only
                $button.addClass('loading').prop('disabled', true);
                $button.find('.spinner').addClass('is-active');
                
                console.log('Sending AJAX request to reset menu:', resetType);
                console.log('Security nonce:', siMenuManager.security);
                
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
                        console.log('AJAX response:', response);
                        
                        // Remove loading state
                        $button.removeClass('loading').prop('disabled', false);
                        $button.find('.spinner').removeClass('is-active');
                        
                        if (response && response.success) {
                            // Show success message
                            alert(siMenuManager.resetSuccess);
                            
                            // If there's a redirect URL, navigate to it
                            if (response.data && response.data.redirect) {
                                window.location.href = response.data.redirect;
                                return;
                            }
                            
                            // If the menu editor is open, reload it to show the default values
                            const $form = $('.si-menu-editor-form');
                            if ($form.length) {
                                const menuType = $form.data('menu-type');
                                if (resetType === 'all' || resetType === menuType) {
                                    // Hide the current editor
                                    hideMenuEditor();
                                    
                                    // Reload the editor after a short delay
                                    setTimeout(function() {
                                        loadMenuEditor(menuType);
                                    }, 500);
                                }
                            } else {
                                // Reload the page to show updated values
                                location.reload();
                            }
                        } else {
                            // Show error message
                            let errorMsg = siMenuManager.resetError;
                            if (response && response.data && response.data.message) {
                                errorMsg = response.data.message;
                            }
                            alert('Error: ' + errorMsg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.log('Response:', xhr.responseText);
                        
                        // Show error message
                        alert(siMenuManager.resetError + ' ' + status + ': ' + error);
                        
                        // Remove loading state
                        $button.removeClass('loading').prop('disabled', false);
                        $button.find('.spinner').removeClass('is-active');
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
    
    // Load menu editor
    function loadMenuEditor(menuType) {
        const $container = $('#si-menu-editor-container');
        
        // Show container and loading state
        $container.show();
        $container.find('.si-menu-editor-loading').show();
        
        // Scroll to container
        $('html, body').animate({
            scrollTop: $container.offset().top - 50
        }, 500);
        
        // Make AJAX request to load menu editor
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
                    // Hide loading state
                    $container.find('.si-menu-editor-loading').hide();
                    
                    // Append editor HTML
                    $container.append(response.data.html);
                    
                    // Initialize subsection toggles
                    $('.si-subsection-toggle').each(function() {
                        const $checkbox = $(this);
                        const $row = $checkbox.closest('tr');
                        const $notesInput = $row.find('input[name$="_notes"]');
                        
                        if ($notesInput.val() === 'subsection') {
                            $checkbox.prop('checked', true);
                            $row.addClass('si-subsection-row');
                        }
                    });
                } else {
                    // Hide container
                    $container.hide();
                    
                    // Show error message
                    alert(response.data.message || 'An error occurred while loading the menu editor.');
                }
            },
            error: function() {
                // Hide container
                $container.hide();
                
                // Show error message
                alert('An error occurred while loading the menu editor. Please try again.');
            }
        });
    }
    
    // Hide menu editor
    function hideMenuEditor() {
        const $container = $('#si-menu-editor-container');
        
        // Remove editor form
        $container.find('.si-menu-editor-form').remove();
        
        // Hide container
        $container.hide();
    }
    
    // Show message
    function showMessage(message, type) {
        const $messages = $('.si-menu-editor-messages');
        const $message = $(`<div class="si-menu-editor-message ${type}">${message}</div>`);
        
        // Remove existing messages
        $messages.empty();
        
        // Add new message
        $messages.append($message);
        
        // Auto-remove message after 5 seconds
        setTimeout(function() {
            $message.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initMenuManager();
    });
    
})(jQuery); 