(function($) {
    $(document).ready(function() {
        var file_frame;
        $('.frontend-button').on('click', function(event) {
            event.preventDefault();
            jQuery(this).closest('.upload-field').addClass('active-upload');


            if (file_frame) {
                file_frame.open();
                return
            }
            file_frame = wp.media.frames.file_frame = wp.media({
                title: $(this).data('uploader_title'),
                button: {
                    text: $(this).data('uploader_button_text'),
                },
                multiple: !1
            });
            file_frame.on('select', function() {
                attachment = file_frame.state().get('selection').first().toJSON();

                jQuery('.active-upload').find('.frontend-image').attr('src', attachment.url);
                jQuery('.active-upload').find('.frontend-input').val(attachment.url);
                jQuery('.active-upload').removeClass('active-upload');
            });
            file_frame.open();
        })
    })
})(jQuery);