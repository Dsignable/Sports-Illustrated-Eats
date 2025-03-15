jQuery(document).ready(function($) {
    const $form = $('#contact-form');
    const $response = $('#form-response');

    $form.on('submit', function(e) {
        e.preventDefault();

        // Clear previous response
        $response.removeClass('success error').hide();

        // Get form data
        const formData = new FormData(this);
        formData.append('action', 'si_contact_form');

        // Submit form via AJAX
        $.ajax({
            url: siContact.ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $response
                        .addClass('success')
                        .html(response.data)
                        .show();
                    $form[0].reset();
                } else {
                    $response
                        .addClass('error')
                        .html(response.data)
                        .show();
                }
            },
            error: function() {
                $response
                    .addClass('error')
                    .html('An error occurred. Please try again later.')
                    .show();
            }
        });
    });
}); 