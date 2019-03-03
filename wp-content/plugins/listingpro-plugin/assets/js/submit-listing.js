var widgetsubmit;

function recaptchaCallbackk() {
    if (jQuery('#recaptcha-securet').length) {
        var sitekey = jQuery('#recaptcha-securet').data('sitekey');
        widgetsubmit = grecaptcha.render(document.getElementById('recaptcha-securet'), {
            'sitekey': sitekey
        })
    }
}
window.onload = recaptchaCallbackk;
jQuery('#lp-submit-form').submit(function(e) {
    jQuery('.error_box').hide('');
    jQuery('.error_box').html('');
    jQuery('.error_box').text('');
    jQuery('.username-invalid-error').html('');
    jQuery('.username-invalid-error').text('');
    var $this = jQuery(this);
    jQuery('span.email-exist-error').remove();
    jQuery('input').removeClass('error-msg');
    jQuery('textarea').removeClass('error-msg');
    $this.find('.preview-section .fa-angle-right').removeClass('fa-angle-right');
    $this.find('.preview-section .fa').addClass('fa-spinner fa-spin');
    jQuery('.bottomofbutton.lpsubmitloading').addClass('fa-spinner fa-spin');
    var fd = new FormData(this);
    fd.delete('listingfiles[]');
    fd.delete('lp-featuredimage[]');
    fd.delete('business_logo[]');
    if (jQuery("input[name='listingfiles[]']").length){
        jQuery.each(jQuery("input[name='listingfiles[]']")[0].files, function(i, file) {
            fd.append('listingfiles['+i+']', file);
        });
    }

    if (jQuery("input[name='business_logo[]']").length){
        fd.append('business_logo[]', jQuery("input[name='business_logo[]']")[0].files[0]);
    }

    if (jQuery("input[name='lp-featuredimage[]']").length){
        fd.append('lp-featuredimage[]', jQuery("input[name='lp-featuredimage[]']")[0].files[0]);
    }
    jQuery("#listingsubmitBTN").prop('disabled', !0);
    fd.append('action', 'listingpro_submit_listing_ajax');
    if (jQuery('#already-account').is(':checked')) {
        fd.append('processLogin', 'yes')
    } else {
        fd.append('processLogin', 'no')
    }
    var postContent = tinymce.editors.inputDescription.getContent();
    if (postContent != '' || postContent != null || postContent != !1) {
        fd.append('postContent', postContent)
    } else {
        fd.append('postContent', '')
    }
    jQuery.ajax({
        type: 'POST',
        url: ajax_listingpro_submit_object.ajaxurl,
        data: fd,
        contentType: !1,
        processData: !1,
        success: function(res) {
            if (jQuery('#recaptcha-securet').length) {
                lp_reset_grecaptcha()
            }
            var resp = jQuery.parseJSON(res);
            if (resp.response === "fail") {
                jQuery("#listingsubmitBTN").prop('disabled', !1);
                jQuery.each(resp.status, function(k, v) {
                    if (k === "postTitle") {
                        jQuery("input:text[name='postTitle']").addClass('error-msg')
                    } else if (k === "gAddress") {
                        jQuery("input:text[name='gAddress']").addClass('error-msg')
                    } else if (k === "category") {
                        jQuery("#inputCategory_chosen").find('a.chosen-single').addClass('error-msg');
                        jQuery("#inputCategory").next('.select2-container').find('.selection').find('.select2-selection--single').addClass('error-msg');
                        jQuery("#inputCategory").next('.select2-container').find('.selection').find('.select2-selection--multiple').addClass('error-msg')
                    } else if (k === "location") {
                        jQuery("#inputCity_chosen").find('a.chosen-single').addClass('error-msg');
                        jQuery("#inputCity").next('.select2-container').find('.selection').find('.select2-selection--single').addClass('error-msg');
                        jQuery("#inputCity").next('.select2-container').find('.selection').find('.select2-selection--multiple').addClass('error-msg')
                    } else if (k === "postContent") {
                        jQuery("textarea[name='postContent']").addClass('error-msg');
                        jQuery("#lp-submit-form .wp-editor-container").addClass('error-msg')
                    } else if (k === "email") {
                        jQuery("input#inputEmail").addClass('error-msg')
                    } else if (k === "inputUsername") {
                        jQuery("input#inputUsername").addClass('error-msg')
                    } else if (k === "inputUserpass") {
                        jQuery("input#inputUserpass").addClass('error-msg')
                    }
                });
                var errorrmsg = jQuery("input[name='errorrmsg']").val();
                $this.find('.preview-section .fa-spinner').removeClass('fa-spinner fa-spin');
                $this.find('.preview-section .fa').addClass('fa-times');
                $this.find('.preview-section').find('.error_box').text(errorrmsg).show();
                jQuery('.bottomofbutton.lpsubmitloading').removeClass('fa-spinner fa-spin');
                jQuery('.bottomofbutton.lpsubmitloading').addClass('fa-times');
            } else if (resp.response === "failure") {
                if (jQuery('#already-account').is(':checked')) {
                    jQuery('.lp-submit-have-account').append(resp.status)
                } else {
                    jQuery("input#inputEmail").after(resp.status);
                    jQuery("div#inputEmail").after(resp.status)
                }
                $this.find('.preview-section .fa-spinner').removeClass('fa-spinner fa-spin');
                $this.find('.preview-section .fa').addClass('fa-angle-right');
                jQuery("#listingsubmitBTN").prop('disabled', !1);
                jQuery('.bottomofbutton.lpsubmitloading').removeClass('fa-spinner fa-spin');
                jQuery('.bottomofbutton.lpsubmitloading').addClass('fa-times');
            } else if (resp.response === "success") {
                $this.find('.preview-section .fa-spinner').removeClass('fa-times');
                $this.find('.preview-section .fa-spinner').removeClass('fa-spinner fa-spin');
                $this.find('.preview-section .fa').addClass('fa-check');
                jQuery('.bottomofbutton.lpsubmitloading').removeClass('fa-times');
               jQuery('.bottomofbutton.lpsubmitloading').addClass('fa-check');
                var redURL = resp.status;

                function redirectPageNow() {
                    window.location.href = redURL
                }
                setTimeout(redirectPageNow, 1000)
            }
        },
        error: function(request, error) {
            if (!jQuery('#recaptcha-securet').length === 0) {
                lp_reset_grecaptcha()
            }
            $this.find('.preview-section .fa-spinner').removeClass('fa-times');
            $this.find('.preview-section .fa-spinner').removeClass('fa-spinner fa-spin');
            $this.find('.preview-section .fa').addClass('fa-times');
            alert(error)
        }
    });
    e.preventDefault()
})