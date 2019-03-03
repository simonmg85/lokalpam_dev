<?php
/*------------------------------------------------------*/
/* Submit Listing
/*------------------------------------------------------*/
vc_map( array(
    "name"                      => __("Listing Checkout", "js_composer"),
    "base"                      => 'listingpro_checkout',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> __("Title","js_composer"),
            "param_name"	=> "title",
            "value"			=> ""
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Bank Transfer Image","js_composer"),
            "param_name"  => "bank_transfer_img",
            "value"       => "",
            "description" => "Bank Transfer image"
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Stripe Image","js_composer"),
            "param_name"  => "stripe_img",
            "value"       => "",
            "description" => "Stripe image"
        ),

        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Paypal Image","js_composer"),
            "param_name"  => "paypal_img",
            "value"       => "",
            "description" => "Paypal image"
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("2 Checkout Image","js_composer"),
            "param_name"  => "twocheckout_img",
            "value"       => "",
            "description" => "2checkout image"
        ),


    ),
) );
function listingpro_shortcode_checkout($atts, $content = null) {

    extract(shortcode_atts(array(
        'title'   => '',
        'stripe_img'   => '',
        'bank_transfer_img'   => '',
        'paypal_img'   => '',
        'twocheckout_img'   => '',
    ), $atts));




    $output = null;

    global $listingpro_options;

    $pubilshableKey = '';
    $pubilshableKey = $listingpro_options['stripe_pubishable_key'];
    $currency = $listingpro_options['currency_paid_submission'];
    $ajaxURL = '';
    $ajaxURL = admin_url( 'admin-ajax.php' );

    $paypalStatus = false;
    $stripeStatus = false;
    $wireStatus = false;
    $checkout2Status = false;
    if($listingpro_options['enable_paypal']=="1"){
        $paypalStatus = true;
    }
    if($listingpro_options['enable_stripe']=="1"){
        $stripeStatus = true;
    }
    if($listingpro_options['enable_wireTransfer']=="1"){
        $wireStatus = true;
    }
    if($listingpro_options['enable_2checkout']=="1"){
        $checkout2Status = true;
    }

    $currency = $listingpro_options['currency_paid_submission'];
    $currency_symbol = listingpro_currency_sign();
    $currency_position = '';
    $currency_position = $listingpro_options['pricingplan_currency_position'];

    $deafaultFeatImg = lp_default_featured_image_listing();

    /* ================================for claim paid payment============================== */
    if( isset($_GET['listing_id']) && isset($_GET['claim_plan']) && isset($_GET['user_id']) && isset($_GET['claim_post']) ) {
        $output = null;
        $output .='<div class="col-md-10 col-md-offset-1">';
        $output .='<form autocomplete="off" id="claim_payment_checkout" class="claim_payment_checkout lp-listing-form" name ="claim_payment_checkout" action="" method="post">';

        $output .='<div class="row">';

        $claimListing_id =  $_GET['listing_id'];




        $claimStatus = listing_get_metabox_by_ID('claimed_section', $claimListing_id);
        if($claimStatus=="claimed"){
            /* already claimed by someone */
            $output .= '<p>Sorry! This listing has already been claimed by someone</p>';
        }else{
            $claim_plan =  $_GET['claim_plan'];
            $user_id =  $_GET['user_id'];
            $claim_post =  $_GET['claim_post'];
            $plan_price = get_post_meta($claim_plan, 'plan_price', true);


            $plan_id = $claim_plan;
            $plan_price = get_post_meta($plan_id, 'plan_price', true);
            $plan_duration = get_post_meta($plan_id, 'plan_time', true);
            $plan_type = get_post_meta($plan_id, 'plan_package_type', true);
            $terms = wp_get_post_terms( $claimListing_id, 'listing-category', array() );
            $price = '';
            $price = $plan_price;

            $catname = '';
            if( count($terms)>0 ){
                $catname = $terms[0]->name;
            }


            $output .='<div class="col-md-8">';
            //$output .= 'Price Plan : '.$plan_price.listingpro_currency_sign();
            $output .='<h2 class="lp_select_listing_heading">To claim listing select this plan </h2>';

            $output .= '<input type="hidden" name="claimerID" value="'.$user_id.'"/>';
            $output .= '<input type="hidden" name="claimPost" value="'.$claim_post.'"/>';
            $output .= '<input type="hidden" name="claimListing_id" value="'.$claimListing_id.'"/>';
            $output .= '<input type="hidden" name="claimPrice" value="'.$plan_price.'"/>';
            $output .= '<input type="hidden" name="currency" value="'.$currency.'"/>';

            /* dfdf */
            $output .='<div class="lp-checkout-wrapper">';
            $output .='<div class="lp-user-listings clearfix" data-plantype="" data-recurringtext="'.esc_html__('Recurring Payment?', 'listingpro-plugin').'"><div class="col-md-12 col-sm-12 col-xs-12 lp-listing-clm lp-checkout-page-outer">';

            $output .= '<div class="col-md-1 col-sm-2 col-xs-6">';

            $output .='<div class="radio radio-danger lp_price_trigger_checkout">
								<input type="radio" name="listing_id" data-taxenable = "" data-taxrate = "" data-planprice = "" data-title="" data-price="'.$plan_price.'" id="'.$claimListing_id.'" value="'.$claimListing_id.'">
								<label for="'.$claimListing_id.'">
								 
								</label>
							</div>';
            $output .='</div>';

            if ( has_post_thumbnail($claimListing_id) ) {

                $imgurl = get_the_post_thumbnail_url($claimListing_id, 'listingpro-checkout-listing-thumb');
                $output .= '<input type="hidden" name="listing_img" value="'.$imgurl.'">';
                $output .='<div class="col-md-3">';
                $output .='<img class="img-responsive" src="'.$imgurl.'" alt="" />';
                $output .='</div>';

            }
            elseif(!empty($deafaultFeatImg)){
                $output .= '<input type="hidden" name="listing_img" value="'.$deafaultFeatImg.'">';
                $output .='<div class="col-md-3">';
                $output .='<img class="img-responsive" src="'.$deafaultFeatImg.'" alt="" />';
                $output .='</div>';
            }
            else {
                $output .='<div class="col-md-3">';
                $output .='<img class="img-responsive" src="'.esc_url('https://placeholdit.imgix.net/~text?txtsize=33&txt=ListingPro&w=372&h=240').'" alt="" />';
                $output .='</div>';
            }



            $output .= '<h5>';
            $output .= get_the_title($claimListing_id);
            $output .='</h5>';
            $output .= '<div class="col-md-2 col-sm-2 col-xs-6">';

            $output .= '<span class="lp-booking-dt">'.esc_html__('Date:','listingpro-plugin').'</span>
											<p>'.get_the_date('', $claimListing_id).'</p>';

            $output .='</div>';
            $output .= '<div class="col-md-2 col-sm-2 col-xs-6">';

            $output .= '<span class="lp-persons">'.esc_html__('Category:','listingpro-plugin').'</span>
											<p>'.$catname.'</p>';

            $output .='</div>';
            $output .= '<div class="col-md-2 col-sm-2 col-xs-6">';

            $output .= '<span class="lp-duration">'.esc_html__('Duration:','listingpro-plugin').'</span>
											<p>'.$plan_duration.esc_html__(' Days','listingpro-plugin').'</p>';

            $output .='</div>';
            $output .= '<div class="col-md-2 col-sm-2 col-xs-6">';

            if(!empty($currency_position)){
                if($currency_position=="left"){
                    $output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$currency_symbol.$plan_price.'</p>';
                }
                else{
                    $output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$plan_price.$currency_symbol.'</p>';
                }
            }
            else{
                $output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$currency_symbol.$plan_price.'</p>';
            }

            /* dfdf  dfd*/


            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            $output .= '<button type="submit" class="claimproceed" name="claimproceed">Proceed</button>';
            $output .='</div>';

            $output .='<div class="col-md-4">';
            ob_start();
            include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/payment-methods.php');
            $output .= ob_get_contents();
            ob_end_clean();
            ob_flush();
            $output .='</div>';
            $output .='</div>';
            $output .='</form>';
            $output .='</div>';

            $output .= '
			<script>
			var claimerID = "";
			var claimPost = "";
			var claimListingid = "1";
			var claimPrice = "";
			jQuery("button.claimproceed").on("click", function(){
				claimerID = jQuery("input[name=claimerID].val()");
				claimPost = jQuery("input[name=claimPost].val()");
				claimListingid = jQuery("input[name=claimListing_id].val()");
				claimPrice = jQuery("input[name=claimPrice].val()");
			});

			var token_email, token_id;
				var handler = StripeCheckout.configure({
				  key: "<?php echo $pubilshableKey; ?>",
				  image: "https://stripe.com/img/documentation/checkout/marketplace.png",
				  locale: "auto",
				  token: function(token) {
					console.log(token);
					token_id = token.id;
					token_email = token.email;
					jQuery("body").addClass("listingpro-loading");
					jQuery.ajax({
						type: "POST",
						dataType: "json",
						url: "<?php echo $ajaxURL; ?>",
						data: {
							"action": "listingpro_claim_payment_via_stripe",
							"token": token_id,
							"email": token_email,
							"claimerID": claimerID,
							"claimPost": claimPost,
							"listing_id": <?php echo $_GET["listing_id"]; ?>,
							"claimPrice" : claimPrice,
						},
						success: function(res){
							if(res.status=="success"){
								redURL = res.redirect;
								if(res.status=="success"){
									window.location.href = redURL;
									jQuery("body").removeClass("listingpro-loading");
								}
							}
							if(res.status=="fail"){
								alert(res.redirect);
								jQuery("body").removeClass("listingpro-loading");
							}

						},
						error: function(errorThrown){
							alert(errorThrown);
							jQuery("body").removeClass("listingpro-loading");
						}
					})


				  }
				});

				//document.getElementById("stripe-submit").addEventListener("click", function(e) {

				  //e.preventDefault();
				//});

				// Close Checkout on page navigation:
				window.addEventListener("popstate", function() {
				  handler.close();
				});
			</script>';

        }
    }

    /* ================================for campaign wire============================== */
    else if(isset($_GET['checkout']) && !empty($_GET['checkout']) && $_GET['checkout']=="wire"){

        if (!isset($_SESSION)) { session_start(); }

        $postID = $_SESSION['post_id'];
        if(!empty($postID)){
            $output ='<div class="page-container-four clearfix">';
            $output .='<div class="col-md-10 col-md-offset-1">';
            $output .= get_campaign_wire_invoice( $postID );
            $output .='</div>';
            $output .='</div>';
            unset($_SESSION['post_id']);
        }
        else{
            $redirect = site_url();
            wp_redirect($redirect);
            exit();
        }
    }
    /* ================================for listings wire============================== */
    else if( isset($_GET['method']) && !empty($_GET['method']) && $_GET['method']=="wire" ){

        if (!isset($_SESSION)) { session_start(); }

        $postID = $_SESSION['post_id'];
        if(!empty($postID)){
            $output ='<div class="page-container-four clearfix">';
            $output .='<div class="col-md-10 col-md-offset-1">';
            $output .= generate_wire_invoice( $postID );
            $output .='</div>';
            $output .='</div>';
            unset($_SESSION['post_id']);
        }
        else{
            $redirect = site_url();
            wp_redirect($redirect);
            exit();
        }
    }

    /* ================================for checkout success/failed ============================== */
    else if( isset($_GET['lpcheckstatus']) && !empty($_GET['lpcheckstatus'])){

        /* for steps */
        $output .='<div class="page-container-four clearfix lpcheckoutcomplete">';
        ob_start();
        include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/payment-steps-complete.php');
        $output .= ob_get_contents();
        ob_end_clean();
        ob_flush();
        $output .='</div>';

        ob_start();
        include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/'.$_GET["lpcheckstatus"].'.php');
        $output .= ob_get_contents();
        ob_end_clean();
        ob_flush();


        /* ================================for checkout default page ============================== */
    }else{
        $post_id = '';
        $order_id = '';
        $redirect = '';
        $redirect = get_template_directory_uri().'/include/paypal/form-handler.php?func=addrow';
        $recurringPayment = lp_theme_option('lp_enable_recurring_payment');


        $output ='<div class="page-container-four clearfix">';
        $output .='<div class="col-md-10 col-md-offset-1">';

        $paid_mode = lp_theme_option('enable_paid_submission');
        $taxButton = lp_theme_option('lp_tax_swtich');

        if( !empty($paid_mode) && $paid_mode=="no" ){
            $output .='<p class="text-center">'.esc_html__('Sorry! Currently Free mode is activated','listingpro-plugin').'</p>';
        }
        else{
            /* for steps */
            ob_start();
            include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/payment-steps.php');
            $output .= ob_get_contents();
            ob_end_clean();
            ob_flush();


            $output .='<form autocomplete="off" id="listings_checkout_form" class="lp-listing-form" name ="listings_checkout_form" action="'.$redirect.'" method="post" data-recurring="'.$recurringPayment.'" data-currencypos="'.$currency_position.'" data-currencysymbol="'.$currency_symbol.'">';
            $output .='<div class="row">';
            $output .='<div class="col-md-8">';
            if(isset($_POST['planid']) && isset($_POST['listingid'])){
                ob_start();
                include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/quick-checkout.php');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            }
            else{
                ob_start();
                include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/default-checkout.php');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            }

            // section selected listing details and coupons.

            $output .='<div class="lp-checkout-coupon-outer">';
            $couponsSwitch = lp_theme_option('listingpro_coupons_switch');
            if($couponsSwitch=="yes"){
                $output .='
									<div class="col-md-12 checkout-padding-top-bottom">
										<div class="col-md-6">
											<div class="lp-checkout-coupon-code">
												<div class="lp-onoff-switch-checkbox">
													<label class="switch-checkbox-label">
														<input type="checkbox" name="lp_checkbox_coupon">
														<span class="switch-checkbox-styling">
														</span>
													</label>
												</div>
												<span class="lp-text-switch-checkbox">Coupon Code</span>
											</div>
										</div>
										<div class="col-md-6 apply-coupon-text-field">
											<input type="text" class="coupon-text-field" name="coupon-text-field" placeholder="Type Here" disabled>
											<button type="button" class="coupon-apply-bt" disabled>APPLY CODE</button>
										</div>
									</div>';
            }

            $output .='
								<ul class="checkout-item-price-total">
									<li>
										<span class="item-price-total-left"><b>ITEM</b></span>
										<span class="item-price-total-right"><b>PRICE</b></span>

									</li>
									<li>
										<span class="item-price-total-left lp-subtotal-plan">Pro</span>
										<span class="item-price-total-right lp-subtotal-p-price">$11.00</span>

									</li>';
            if(!empty($taxButton)){
                $output .='
										<li>
											<span class="item-price-total-left">Tax(Value Added Tax)</span>
											<span class="item-price-total-right lp-subtotal-taxamount">$0.40</span>

										</li>';
            }
            $output .='
									<li>
										<span class="item-price-total-left">Subtotal</span>
										<span class="item-price-total-right lp-subtotal-price">$11.00</span>

									</li>
									<li>
										<span class="item-price-total-left"><b>Total</b></span>
										<span class="item-price-total-right lp-subtotal-total-price"><b>$11.40</b></span>

									</li>

								</ul>

						</div>';

            $output .='</div>';

            $output .='<div class="col-md-4 lp-col-outer">';
            ob_start();
            include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/payment-methods.php');
            $output .= ob_get_contents();
            ob_end_clean();
            ob_flush();

            // checkbox term and conditions
            $termsCondition = lp_theme_option('payment_terms_condition');
            if(!empty($termsCondition)){
                $output.='<label class="filter_checkbox_container terms-checkbox-container">Terms And Conditions
										<input type="checkbox">
										<span class="filter_checkbox_checkmark"></span>
									</label>';
            }

            $output .='
						<button type="button" class="lp_payment_step_next firstStep" disabled>'.esc_html__('PROCEED TO NEXT', 'listingpro-plugin').'</button>
					';
            $output .='</div>';

            $output .='</div>';


            $output .='</form>';


            $output .='
							<button id="stripe-submit">'.esc_html__('Purchase','listingpro-plugin').'</button>

								<script>
								var post_title = "";
								listings_id = "";
								listings_img = "";
								plan_price = "";
								currency = "";
								plan_id = "";
								listing_img = "";
								taxrate = "";
								jQuery("#listings_checkout_form input[name=listing_id]").click(function(){
									listings_id = "";
									listings_id = jQuery("#listings_checkout_form input[name=listing_id]:checked").val();
									plan_id = "";
									plan_id = jQuery("#listings_checkout_form input[name=listing_id]:checked").data("planid");
									taxrate = jQuery("#listings_checkout_form input[name=listing_id]:checked").data("taxrate");
								});
								var recurringtext ="";
								jQuery("#listings_checkout_form").submit(function(){
									recurringtext = jQuery("input[name=lp-recurring-option]:checked").val();
								});
								
								var token_email, token_id;
								var handler = StripeCheckout.configure({
								  key: "'.$pubilshableKey.'",
								  image: "https://stripe.com/img/documentation/checkout/marketplace.png",
								  locale: "auto",
								  token: function(token) {
									console.log(token);
									token_id = token.id;
									token_email = token.email;
									jQuery("body").addClass("listingpro-loading");
									jQuery.ajax({
										type: "POST",
										dataType: "json",
										url: "'.$ajaxURL.'",
										data: { 
											"action": "listingpro_save_stripe", 
											"token": token_id, 
											"email": token_email, 
											"listing": listings_id, 
											"plan": plan_id,
											"taxrate" : taxrate,						
											"recurring" : recurringtext,						
										},   
										success: function(res){
											if(res.status=="success"){
												redURL = res.redirect;
												if(res.status=="success"){
													window.location.href = redURL;
													jQuery("body").removeClass("listingpro-loading");
												}
											}
											if(res.status=="fail"){
												alert(res.redirect);
												jQuery("body").removeClass("listingpro-loading");
											}
											
										},
										error: function(errorThrown){
											alert(errorThrown);
											jQuery("body").removeClass("listingpro-loading");
										} 
									});
									

								  }
								});

								// Close Checkout on page navigation:
								window.addEventListener("popstate", function() {
								  handler.close();
								});
								</script>
								
								';


        }

    }
    return $output;
}
add_shortcode('listingpro_checkout', 'listingpro_shortcode_checkout');