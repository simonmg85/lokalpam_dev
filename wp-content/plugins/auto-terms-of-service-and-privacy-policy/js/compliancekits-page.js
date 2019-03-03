jQuery(document).ready(function () {
    jQuery(".wpautoterms-box-enable-button a.button[data-type='enable']").click(function () {
        var b = jQuery(this);
        b.attr("disabled", "disabled");
        var id = b.attr("id");
        var s = jQuery("#status_" + id);
        jQuery.post(ajaxurl, {
            action: id,
            nonce: wpautotermsComplianceKits.boxData[id].nonce
        }).done(function (response) {
            if (typeof response !== "object") {
                alert(response);
            } else {
                b.text(wpautotermsComplianceKits.buttonText[response.enabled]);
                s.text(wpautotermsComplianceKits.statusText[response.enabled]).toggleClass('enabled', response.enabled)
                    .toggleClass('disabled', !response.enabled);
                wpautoterms.setNotice(wpautotermsComplianceKits.boxData[id].noticeText[response.enabled],
                    "updated notice");
            }
        }).fail(function (error) {
            console.log(error);
            alert(error.statusText);
        }).always(function () {
            b.removeAttr("disabled");
        });
    });
});
