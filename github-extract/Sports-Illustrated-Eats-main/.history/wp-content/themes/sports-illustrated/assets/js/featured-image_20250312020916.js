/**
 * Featured Image Management Script
 * 
 * This script handles all featured image functionality in the WordPress admin.
 */
(function($) {
    'use strict';

    // Store the wp.media frame instances
    var mediaFrames = {};

    // Initialize on document ready
    $(document).ready(function() {
        initFeaturedImageButtons();
        enhanceFeaturedImageMetabox();
        enhanceThumbnailColumn();
    });

    /**
     * Initialize all featured image buttons
     */
    function initFeaturedImageButtons() {
        // Handle all Set Featured Image buttons with a common class
        $(document).on('click', '.si-set-featured-image', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var postId = button.data('post-id') || $('#post_ID').val();
            
            if (!postId) {
                alert('Error: Could not determine post ID.');
                return;
            }
            
            openMediaLibrary(postId, button);
        });
        
        // Add the class to all WordPress default featured image buttons
        $('.set-post-thumbnail').addClass('si-set-featured-image');
    }

    /**
     * Open the media library for selecting a featured image
     */
    function openMediaLibrary(postId, button) {
        // Create a unique key for this frame
        var frameKey = 'post_' + postId;
        
        // If we already have a frame for this post, open it
        if (mediaFrames[frameKey]) {
            mediaFrames[frameKey].open();
            return;
        }
        
        // Create a new media frame
        var frame = wp.media({
            title: 'Select Featured Image',
            library: { type: 'image' },
            multiple: false,
            button: { text: 'Set as featured image' }
        });
        
        // Store the frame for future use
        mediaFrames[frameKey] = frame;
        
        // When an image is selected
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            
            // Show loading state if button exists
            if (button) {
                var originalText = button.text();
                button.text('Saving...').prop('disabled', true);
            }
            
            // Save the featured image via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'si_set_featured_image',
                    post_id: postId,
                    image_id: attachment.id,
                    nonce: siSettings.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Handle different contexts
                        if (button.closest('.column-thumbnail').length) {
                            // Posts list context
                            updateThumbnailColumn(button, attachment);
                        } else if (button.closest('#postimagediv').length) {
                            // Post edit context
                            updateFeaturedImageMetabox(attachment);
                        } else if (button.closest('.manage-featured-images').length) {
                            // Featured image management page
                            button.closest('tr').fadeOut(function() {
                                $(this).remove();
                                
                                // Check if there are any rows left
                                if ($('.manage-featured-images table tbody tr').length === 0) {
                                    $('.manage-featured-images table').replaceWith('<p><strong>All posts have featured images set. Great job!</strong></p>');
                                    $('#set-all-featured-images').hide();
                                }
                            });
                        }
                        
                        // Remove any warning notices
                        $('.notice.notice-warning').fadeOut();
                    } else {
                        // Reset button if it exists
                        if (button) {
                            button.text(originalText).prop('disabled', false);
                        }
                        alert('Error setting featured image. Please try again.');
                    }
                },
                error: function() {
                    // Reset button if it exists
                    if (button) {
                        button.text(originalText).prop('disabled', false);
                    }
                    alert('Error setting featured image. Please try again.');
                }
            });
        });
        
        // Open the frame
        frame.open();
    }

    /**
     * Update the thumbnail column in the posts list
     */
    function updateThumbnailColumn(button, attachment) {
        var cell = button.closest('td');
        var img = $('<img>').attr('src', attachment.url).attr('alt', 'Featured Image');
        cell.html(img);
    }

    /**
     * Update the featured image metabox in the post edit screen
     */
    function updateFeaturedImageMetabox(attachment) {
        var metabox = $('#postimagediv');
        
        // Update the hidden input
        $('#_thumbnail_id').val(attachment.id);
        
        // Update the preview
        var html = '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail" class="si-remove-featured-image">Remove featured image</a></p>' +
                  '<img src="' + attachment.url + '" style="max-width:100%;height:auto;" />';
        
        $('.inside', metabox).html(html);
        
        // Re-add our instructions
        var instructions = $('<div class="si-featured-image-instructions"></div>').html(
            '<p><strong>Required for News Page:</strong> Featured images are displayed on the News page and improve the visual appeal of your content.</p>' +
            '<p><strong>Recommended size:</strong> 800×450 pixels (16:9 ratio)</p>'
        );
        $('.inside', metabox).prepend(instructions);
        
        // Remove the no-featured-image class
        metabox.removeClass('no-featured-image');
    }

    /**
     * Enhance the featured image metabox in the post edit screen
     */
    function enhanceFeaturedImageMetabox() {
        var metabox = $('#postimagediv');
        if (!metabox.length) return;
        
        // Check if there's a featured image
        var hasFeaturedImage = $('#_thumbnail_id').val() > 0;
        
        // Add class to metabox based on featured image status
        if (!hasFeaturedImage) {
            metabox.addClass('no-featured-image');
        }
        
        // Add custom instructions
        var instructions = $('<div class="si-featured-image-instructions"></div>').html(
            '<p><strong>Required for News Page:</strong> Featured images are displayed on the News page and improve the visual appeal of your content.</p>' +
            '<p><strong>Recommended size:</strong> 800×450 pixels (16:9 ratio)</p>'
        );
        
        // Add custom button with direct media library access
        var customButton = $('<button type="button" class="si-set-featured-image-btn si-set-featured-image">Set Featured Image</button>');
        
        // Insert elements
        $('.inside', metabox).prepend(instructions);
        
        // If no featured image, add the custom button
        if (!hasFeaturedImage) {
            $('.inside', metabox).append(customButton);
        }
        
        // Override the default "Set featured image" link
        $('.set-post-thumbnail').addClass('si-set-featured-image');
        
        // Handle remove featured image
        $(document).on('click', '.si-remove-featured-image', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'si_remove_featured_image',
                    post_id: $('#post_ID').val(),
                    nonce: siSettings.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Reset the metabox
                        $('#_thumbnail_id').val('');
                        metabox.addClass('no-featured-image');
                        
                        // Update the preview
                        var html = '<p class="hide-if-no-js"><a href="#" class="si-set-featured-image">Set featured image</a></p>' +
                                  '<button type="button" class="si-set-featured-image-btn si-set-featured-image">Set Featured Image</button>';
                        
                        $('.inside', metabox).html(html);
                        $('.inside', metabox).prepend(instructions);
                    }
                }
            });
        });
    }

    /**
     * Enhance the thumbnail column in the posts list
     */
    function enhanceThumbnailColumn() {
        // Only run on the post list page
        if (!$('.wp-list-table').length) return;
        
        // Add Set Image buttons to posts without thumbnails
        $('.column-thumbnail').each(function() {
            var cell = $(this);
            if (cell.find('img').length === 0) {
                var postId = cell.closest('tr').attr('id').replace('post-', '');
                
                // Add button
                cell.append('<button type="button" class="set-thumbnail-btn si-set-featured-image" data-post-id="' + postId + '">Set Image</button>');
            }
        });
    }

})(jQuery); 