 jQuery(document).ready(function($){
	 jQuery('#claimform').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				if (jQuery("form#claimform .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });
	 
	  jQuery('#claimformmobile').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				if (jQuery("form#claimformmobile .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });



     jQuery('#contactOwner').on('submit', function(e){

         $this = jQuery(this);

         e.preventDefault();

         var lEmail     =   jQuery('#email7').val(),
             lName      =   jQuery('#name7').val(),
             lMsg       =   jQuery('#message7').val(),
             proceedIt  =   true;

         if( lEmail == '' || lName == '' || lMsg == '' )
         {

             if( lEmail == '' )
             {
                 jQuery('#email7').addClass('error-msg');
             }
             else
             {
                 jQuery('#email7').removeClass('error-msg');
             }
             if( lName == '' )
             {
                 jQuery('#name7').addClass('error-msg');
             }
             else
             {
                 jQuery('#name7').removeClass('error-msg');
             }
             if( lMsg == '' )
             {
                 jQuery('#message7').addClass('error-msg');
             }
             else
             {
                 jQuery('#message7').removeClass('error-msg');
             }

             proceedIt  =   false;
         }
         if( jQuery('input:checkbox.lp-required-field').length > 0 )
         {
             if (jQuery('input:checkbox.lp-required-field', this).is(':checked'))
             {
                 jQuery('input:checkbox.lp-required-field').closest('label' ).removeClass('error-msg');
             }
             else
             {
                 jQuery('input:checkbox.lp-required-field').closest('label' ).addClass('error-msg');
                 proceedIt  =   false;
             }
         }
         if( jQuery('input:radio.lp-required-field').length > 0 )
         {
             if(jQuery('input:radio.lp-required-field', this).is(':checked') )
             {
                 jQuery('input:radio.lp-required-field').closest('label' ).removeClass('error-msg');
             }
             else
             {
                 jQuery('input:radio.lp-required-field').closest('label' ).addClass('error-msg');
                 proceedIt  =   false;

             }
         }

         if( jQuery('#contactOwner .lp-required-field').length > 0 )
         {
             jQuery('#contactOwner .lp-required-field').each(function (index) {
                 var $this      =   jQuery(this),
                     $thisVal   =   $this.val(),
                     $thisType  =   $this.attr('type');

                 if( $this.prop('tagName') == 'SELECT' )
                 {
                     if( $thisVal == 0 )
                     {
                         proceedIt  =   false;
                         $this.addClass('error-msg');
                     }
                     else
                     {
                         $this.removeClass('error-msg');
                     }
                 }
                 else
                 {

                     if( $thisVal == '' )
                     {
                         proceedIt  =   false;
                         $this.addClass('error-msg');
                         alert('5');
                     }
                     else
                     {
                         $this.removeClass('error-msg');
                     }
                 }

             });
         }
         if( proceedIt === false )
         {
             return proceedIt;
         }



         var formData = $(this).serialize();
         $this.find('.lp-search-icon').removeClass('fa-send');
         $this.find('.lp-search-icon').addClass('fa-spinner fa-spin');

         jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'listingpro_contactowner',
                 'formData': formData,
             },
             success: function(res){
                 if (jQuery("form#contactOwner .g-recaptcha-response").length){
                     lp_reset_grecaptcha();
                 }
                 if(res.result==="fail"){
                     jQuery.each(res.errors, function (k, v) {
                         if(k==="email"){
                             jQuery("input[name='email7']").addClass('error-msg');
                         }
                         if(k==="message"){
                             jQuery("textarea[name='message7']").addClass('error-msg');
                         }
                         if(k==="name7"){
                             jQuery("input[name='name7']").addClass('error-msg');
                         }
                         $this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');
                         $this.find('.lp-search-icon').addClass('fa-cross');
                         //$this.append(res.state);
                     });
                 }
                 else{
                     $this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');
                     $this.find('.lp-search-icon').addClass('fa-check');
                     // success msg.
                     jQuery('.lp-lead-success-msg-outer').fadeIn('700');
                     //$this.append(res.state);
                     $this[0].reset();
                 }
             }
         });
         //return false;
         //alert(formData);

     });
	 
	 
/* jquery ajax code for expired listing plan change */
	jQuery('.lp-change-proceed-link').on('click', function(e){
		jQuery('div.lp-existing-plane-container').slideToggle(700);
		jQuery('div.lp-new-plane-container').slideToggle(700);
		e.preventDefault();
	})
	
	jQuery('.lp-role-back-to-current-plan').on('click', function(e){
		jQuery('div.lp-existing-plane-container').slideToggle(700);
		jQuery('div.lp-new-plane-container').slideToggle(700);
		e.preventDefault();
	})
	
	
	jQuery('.lp-change-plan-btn').on('click', function(e){
		var listing_id = '';
		var listing_status = '';
		var plan_title = '';
		var plan_price = '';
		var haveplan = '';
		listing_id = jQuery(this).data('listingid');
		plan_title = jQuery(this).data('plantitle');
		plan_price = jQuery(this).data('planprice');
		haveplan = jQuery(this).data('haveplan');
		listing_status = jQuery(this).data('listingstatus');
		jQuery('.lp-selected-plan-price h3' ).html('');
		jQuery('.lp-selected-plan-price h3' ).text(plan_title);
		jQuery('.lp-selected-plan-price h4' ).html('');
		jQuery('.lp-selected-plan-price h4' ).html(plan_price);
		jQuery('#select-plan-form input#listing_id' ).val(listing_id);
		jQuery('#select-plan-form input#listing_statuss' ).val(listing_status);
		//jQuery('.pay-again-button').removeClass('lp-new-button-added');
		//jQuery(this).closest('li').next('.pay-again-button').addClass('lp-new-button-added');
		e.preventDefault();
	});
	jQuery('#select-plan-form').submit(function(event){
		var plan_id = '';
		$this = jQuery(this);
		listing_idd = '';
		listing_status = '';
		listing_idd = jQuery("input[name='plans-posts']:checked").val();
		listing_id = jQuery("input[name='listing-id']").val();
		listing_status = jQuery("input[name='listing_status']").val();
		jQuery('.lp-change-plane-status .lp-action-div').html('');
		if( typeof(listing_idd)  !== "undefined" ){
			jQuery("div.lp-expire-update-status").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_change_plan', 
					'ch_plan_id': listing_idd, 
					'ch_listing_id': listing_id, 
					'ch_listing_status': listing_status, 
				},   
				success: function(data){
					//jQuery('#select-plan-form')[0].reset();
					if( data.subscribed ){
						if(data.subscribed=="yes"){
							alert(data.alertmsg);
						}
					}
					jQuery("div.lp-expire-update-status").html('');
					jQuery('.lp-change-plane-status .lp-action-div').html('');
					jQuery('.lp-change-plane-status .lp-action-div').html(data.action);
					
				}
			});
			
		}
		event.preventDefault();
	})
	 
 });
 
 
 /* change plan proceedings */
 jQuery(document).on('click', '.lp_change_plan_action', function(e){
	 var planid = jQuery('.lp-action-div input[name="planid"]').val();
	 var listingid = jQuery('.lp-action-div input[name="listingid"]').val();
	 jQuery('.lp-action-div').html('');
	 jQuery("div.lp-expire-update-status").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>');
	 jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_change_plan_proceeding', 
					'plan_iddd': planid, 
					'listing_iddd': listingid, 
				},   
				success: function(data){
					//jQuery('#select-plan-form')[0].reset();
					jQuery("div.lp-expire-update-status").html('');
					jQuery("div.lp-expire-update-status").html(data.message);
				}
			});
	 
	 e.preventDefault();
 })
 /* end change plan proceedings */ 
 
 /* delete subscription proceedings */
jQuery(document).on('click', 'a.delete-subsc-btn', function(e){

     e.preventDefault();
	 var $this = jQuery(this),
         cMsg   =   $this.data('cmsg');


     var r = confirm(cMsg);
     if( r == true )
     {
         jQuery('body').addClass('listingpro-loading');
         var subscript_id = jQuery(this).attr('href');
         jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'listingpro_cancel_subscription_proceeding',
                 'subscript_id': subscript_id,
             },
             success: function(data){
                 jQuery('body').removeClass('listingpro-loading');
                 alert(data.msg);
                 if(data.status=="success"){
                     $this.closest('tr').slideToggle();
                 }

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 jQuery('body').removeClass('listingpro-loading');
                 console.log(textStatus, errorThrown);
             }
         });
     }


 });
 
 /* Report listing or Report Review */
 jQuery(document).on('click', '#lp-report-listing a#lp-report-this-listing, #lp-report-review a#lp-report-this-review, .lp-review-right-bottom a#lp-report-this-review', function(e){
	 var $this = jQuery(this);
	 var $posttype = $this.data('posttype');
	 var $postid = $this.data('postid');
	 var $reportedby = $this.data('reportedby');
	 jQuery('body').addClass('listingpro-loading');
	 jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_report_this_post', 
					'posttype': $posttype, 
					'postid': $postid, 
					'reportedby': $reportedby 
				},   
				success: function(data){
					jQuery('body').removeClass('listingpro-loading');
					jQuery('div.lp-top-notification-bar').html('');
					var alertmsgs = '';
					if(data.status==="success"){
						alertmsgs = '<div class="lp-reporting-success">'+data.msg+'</div>';
						jQuery('div.lp-top-notification-bar').html(alertmsgs);
					}
					else{
						alertmsgs = '<div class="lp-reporting-error">'+data.msg+'</div>';
						jQuery('div.lp-top-notification-bar').html(alertmsgs);
					}
					jQuery('div.lp-top-notification-bar').slideDown('slow').delay(2000).slideUp('slow');
					//alert(data.msg);
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					jQuery('body').removeClass('listingpro-loading');
					console.log(textStatus, errorThrown);
				}
			});
	 
	 e.preventDefault();
 })


 /* lp bar graph print options */

 jQuery(document).on('click', 'div.lp_user_stats_btn, ul li .lp_stats_duratonBtn', function(e){
     $this = jQuery(this);
     if($this.hasClass('active') && ($this.hasClass('lp_user_stats_btn'))){}else{
         jQuery('div.lp_user_stats_btn').removeClass('active');
         jQuery( "#lpgraph" ).empty();
         $duration = jQuery('ul li .lp_stats_duratonBtn.active').data('chartduration');
         $type = $this.data('type');
         jQuery('ul.lp_stats_duration_filter li button').data('type', $type);
         jQuery('body').addClass('listingpro-loading');
         jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'listingpro_show_bar_chart',
                 'type': $type,
                 'duration': $duration,
             },
             success: function(data){
                 jQuery('body').removeClass('listingpro-loading');
                 jQuery('ul.lp_stats_duration_filter').show();
                 showthischart(data.data, $type);
                 jQuery('.lp_user_stats_btn.active p.lpstatsnumber').text('');
                 jQuery('.lp_user_stats_btn.active p.lpstatsnumber').text(data.counts);
                 jQuery('.lp_user_stats_btn.active').find('.lp_status_duration_counter').text('');
                 jQuery('.lp_user_stats_btn.active').find('.lp_status_duration_counter').text(data.resp);
                 //alert(data.msg);

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 jQuery('body').removeClass('listingpro-loading');
                 console.log(textStatus, errorThrown);
             }
         });
     }
 });

function showthischart($datarray, $type){
	// Use Morris.Bar
	Morris.Bar({
	  element: 'lpgraph',
	  data : $datarray,
	  xkey: 'x',
	  ykeys: ['y'],
	  labels: [$type]
	});
	if($type=="view"){
		jQuery('div.lpviewchart').addClass('active');
	}else if($type=="leads"){
		jQuery('div.lpviewleads').addClass('active');
	}else if($type=="reviews"){
		jQuery('div.lpviewreviews').addClass('active');
	}
}

/* start for coupon button on checkout page */
jQuery(document).on('click', 'button.coupon-apply-bt', function(){
     var couponcode = jQuery('input[name=coupon-text-field]').val();
     var $price = jQuery('input[name=listing_id]:checked').data('planprice');
     var $listingID = jQuery('input[name=listing_id]:checked').val();
     var $post_title = jQuery('input[name=listing_id]:checked').data('title');
     var $planID = jQuery('input[name=listing_id]:checked').data('planid');
     var $tax =jQuery('input[name=listing_id]:checked').data('taxenable');
     var $taxRate = jQuery('input[name=listing_id]:checked').data('taxrate');

     if(couponcode === ''){}else{
         jQuery('body').addClass('listingpro-loading');
         jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'listingpro_apply_coupon_code',
                 'coupon': couponcode,
                 'listingid': $listingID,
                 'taxrate': $taxRate,
                 'price': $price,
             },
             success: function(data){
                 jQuery('body').removeClass('listingpro-loading');
                 if(data.status=="success"){
                     $discount = data.discount;
                     $newprice = $discount/100;
                     $newprice = $newprice*$price;
                     $newprice = $price-$newprice;
                     $newprice = parseFloat($newprice).toFixed(2);
                     lp_add_checkout_data_fields_in_form($listingID, $post_title, $planID, $newprice, $tax, $taxRate);
					  if(jQuery('li').hasClass('checkout_discount_val')){}else{
					 jQuery('span.lp-subtotal-p-price').parent().after('<li class="checkout_discount_val"><span class="item-price-total-left lp-subtotal-plan">Discounted</span><span class="item-price-total-right lp-subtotal-p-prasaice">'+$discount+'%</span></li>');
					  }
                 }

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 jQuery('body').removeClass('listingpro-loading');
                 console.log(textStatus, errorThrown);
             }
         });
     }

 });
 
 /* reset tax in database while switching offto discound */
jQuery(document).on('click', 'input[name="lp_checkbox_coupon"]', function(){
	if(jQuery(this).hasClass('active')){}else{
		
		 var couponcode = '';
		 var $price = jQuery('input[name=listing_id]:checked').data('planprice');
		 var $listingID = jQuery('input[name=listing_id]:checked').val();
		 var $post_title = jQuery('input[name=listing_id]:checked').data('title');
		 var $planID = jQuery('input[name=listing_id]:checked').data('planid');
		 var $tax =jQuery('input[name=listing_id]:checked').data('taxenable');
		 var $taxRate = jQuery('input[name=listing_id]:checked').data('taxrate');
		 
		 jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'listingpro_apply_coupon_code',
                 'coupon': couponcode,
                 'listingid': $listingID,
                 'taxrate': $taxRate,
                 'price': $price,
             },
             success: function(data){
                 jQuery('body').removeClass('listingpro-loading');
                 if(data.status=="success"){
                     $discount = data.discount;
                     $newprice = $discount/100;
                     $newprice = $newprice*$price;
                     $newprice = $price-$newprice;
                     $newprice = parseFloat($newprice).toFixed(2);
                     lp_add_checkout_data_fields_in_form($listingID, $post_title, $planID, $newprice, $tax, $taxRate);
					  if(jQuery('li').hasClass('checkout_discount_val')){}else{
					 jQuery('span.lp-subtotal-p-price').parent().after('<li class="checkout_discount_val"><span class="item-price-total-left lp-subtotal-plan">Discounted</span><span class="item-price-total-right lp-subtotal-p-prasaice">'+$discount+'%</span></li>');
					  }
                 }

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 jQuery('body').removeClass('listingpro-loading');
                 console.log(textStatus, errorThrown);
             }
         });
		 
		
	}
     
 });
 
 
/* ajax call to reply to leads message */
jQuery(document).on('submit', 'form[name=lp_leadReply]', function(e){
	
	$this = jQuery(this);
	$this.find('.lpthisloading').show();
	var fd = new FormData(this);
	fd.append('action', 'lp_reply_to_lead_msg');
	jQuery.ajax({
            type: 'POST',
            url: single_ajax_object.ajaxurl,
            data:fd,  
			contentType: false,
			processData: false,
            success: function(res){
				$this.find('.lpthisloading').removeClass('fa-spinner fa-spin');
				$this.find('.lpthisloading').addClass('fa-check');
				window.location.href=window.location.href
				$this[0].reset();
            },
			error: function(request, error){
				//alert(error);
				$this.find('.lpthisloading').removeClass('fa-spinner fa-spin');
				$this.find('.lpthisloading').addClass('fa-check');
				window.location.href=window.location.href
			}
        });
	e.preventDefault();
	return false;	
});

/* ajax call read message thread on click */
 /* ajax call read message thread on click */
 jQuery(document).on('click', '.lp-read-messages .lp-read-message-inner', function(e){
     $this = jQuery(this);
     $loaderImg = $this.data('loader');
     $listingid = $this.data('listingid');
     $useremail = $this.data('email');
     if($listingid){
         jQuery('.lpinboxmiddlepart').html('');
         jQuery('.lpinboxrightpart').html('');
         jQuery('.lpinboxmiddlepart').html('<div class="text-center loadercenterclass"><img src="'+$loaderImg+'" width=35 height=35></div>');
         jQuery('.lpinboxrightpart').html('<div class="text-center loadercenterclass"><img src="'+$loaderImg+'" width=35 height=35></div>');
         jQuery.ajax({
             type: 'POST',
             dataType: 'json',
             url: single_ajax_object.ajaxurl,
             data: {
                 'action': 'lp_preview_this_message_thread',
                 'listindid': $listingid,
                 'useremail': $useremail,
             },
             success: function(data){
                 jQuery('.lpinboxmiddlepart').html('');
                 jQuery('.lpinboxrightpart').html('');
                 jQuery('.lpinboxmiddlepart').html(data.outputcenter);
                 jQuery('.lpinboxrightpart').html(data.outputright);

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 jQuery('.lpinboxmiddlepart').html('');
                 jQuery('.lpinboxrightpart').html('');
                 jQuery('.lpinboxmiddlepart').html(data.outputcenter);
                 jQuery('.lpinboxrightpart').html(data.outputright);
             }
         });
     }



 });

 /* function for Campaigns per click counter */

 jQuery(document).on('click', 'body.home .listingcampaings .lp-grid-box-contianer .lp-grid-box .lp-h4 a, body.home .listingcampaings .lp-grid-box .lp-grid-box-thumb-container .lp-grid-box-thumb a, body.search .promoted-listings .lp-grid-box .lp-grid-box-thumb-container .lp-grid-box-thumb a, body.search .promoted-listings .lp-grid-box-contianer .lp-grid-box .lp-h4 a, body.archive .promoted-listings .lp-grid-box .lp-grid-box-thumb-container .lp-grid-box-thumb a, body.archive .promoted-listings .lp-grid-box-contianer .lp-grid-box .lp-h4 a, .promoted-listings .lp-grid-app-view .lp-grid-box .lp-grid-box-thumb .show-img a, .promoted-listings .lp-grid-app-view .lp-grid-box .lp-h4 a, .listingcampaings .lp-grid-app-view .lp-grid-box .lp-grid-box-thumb .show-img a, .single-listing .widget_listingpro_ads_widget .listing-post article figure a, .single-listing .widget_listingpro_ads_widget .listing-post article figure figcaption a.overlay-link, .single-listing .widget_listingpro_ads_widget .listing-post article figure figcaption h4 a,.single .widget_listingpro_ads_widget .listing-post article figure figcaption a.overlay-link,.single .widget_listingpro_ads_widget .listing-post article figure figcaption h4 a, body.home .listingcampaings .lp-listing .lp-listing-bottom h4 a,  body.home .listingcampaings .lp-listing .lp-listing-top-thumb a', function(){

     $listingURL = jQuery(this).attr('href');
     //search
     $type = '';

     if(jQuery('body').hasClass('search') || jQuery('body').hasClass('archive')){
         $type = 'lp_top_in_search_page_ads_pc';
     }
     //home

     if(jQuery('body').hasClass('home')){
         $type = 'lp_random_ads_pc';
     }
     //detail
     if(jQuery('body').hasClass('single-listing')){
         $type = 'lp_detail_page_ads_pc';
     }

     jQuery.ajax({
         type: 'POST',

         dataType: 'json',

         async:false,

         url: single_ajax_object.ajaxurl,

         data: {
             'action': 'lp_count_clicks_for_campaigns',

             'listingURL': $listingURL,

             'type': $type,
         },

         success: function(data){

             console.log(data);
             window.location.href = $listingURL;

         },

         error: function(jqXHR, textStatus, errorThrown) {

             console.log(errorThrown);

         }

     });

 });
/* ==================for saving id in session for checkout============= */
 
 jQuery(document).on('click', 'a.lp-pay-publish-btn, a.lp-listing-pay-button, input.lp-listing-pay-button', function(){
	 $listingID = jQuery(this).data('lpthisid');
	 jQuery.ajax({
         type: 'POST',
         dataType: 'json',
         url: single_ajax_object.ajaxurl,
         data: {
             'action': 'lp_save_thisid_in_session',
             'listing_id': $listingID,
         },
         success: function(data){
             console.log(data);
         },
         error: function(jqXHR, textStatus, errorThrown) {
             console.log(errorThrown);
         }
     });
 });
	
