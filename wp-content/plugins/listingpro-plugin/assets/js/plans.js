jQuery(function() {
    jQuery('#plan_package_type').change(function() {
        var selected = jQuery('#plan_package_type option:selected').text();
        var alertmsg = jQuery('#plan_package_type select').data('alertmsg');
        if (selected === "Pay Per Listing") {
            jQuery('#plan_text_box').slideUp();
            /* jQuery('#plan_duration_type').slideUp(); */
            jQuery("input#plan_time").prop("disabled", !1);
            jQuery("input#plan_time").prop("readonly", !1)
        } else {
			alert(alertmsg);
            jQuery('#plan_text_box').slideDown();
            /* jQuery('#plan_duration_type').slideDown(); */
            jQuery("input#plan_time").prop("disabled", !1);
            jQuery("input#plan_time").prop("readonly", !1)
        }
    })
});
jQuery(document).ready(function($) {
    
	jQuery('select#plan_usge_for').on('change', function(){
		$cval = jQuery(this).val();
		if($cval=="default"){
			jQuery('#plan_cats').slideUp();
		}else{
			jQuery('#plan_cats').slideDown();
		}
	});
	$cval = jQuery('select#plan_usge_for').val();
	if($cval=="default"){
		jQuery('#plan_cats').slideUp();
	}else{
		jQuery('#plan_cats').slideDown();
	}
});

jQuery(window).load(function(){
        var selected = jQuery('#plan_package_type option:selected').text();
        if (selected === "Pay Per Listing") {
            jQuery('#plan_text_box').slideUp();
            /* jQuery('#plan_duration_type').slideUp(); */
            jQuery("input#plan_time").prop("disabled", !1);
            jQuery("input#plan_time").prop("readonly", !1)
        } else {
            jQuery('#plan_text_box').slideDown();
            /* jQuery('#plan_duration_type').slideDown(); */
            jQuery("input#plan_time").prop("disabled", !1);
            jQuery("input#plan_time").prop("readonly", !1)
        }
});