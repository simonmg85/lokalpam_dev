<?php

	global $wpdb, $listingpro_options;
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$currency = '';
	$currency = $listingpro_options['currency_paid_submission'];
	$currency_symbol = listingpro_currency_sign();
	$currency_position = '';
	$currency_position = $listingpro_options['pricingplan_currency_position'];
	$enableTax = false;
	$Taxrate='';
	$Taxtype='';
	$outputCheck = null;
	if($listingpro_options['lp_tax_swtich']=="1"){
		$enableTax = true;
		$Taxrate = $listingpro_options['lp_tax_amount'];
		$Taxtype = $listingpro_options['lp_tax_label'];
	}
	
	$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND status = 'in progress' ORDER BY main_id DESC" );
	if( count($results) >0 ){
		$outputCheck .='<div class="lp-checkout-wrapper lp-checkout-wrapper-new">';
				foreach ( $results as $info ) {
								
								if(isset($info->post_id)){
									$post_id = $info->post_id;
									
								}
										//$postmeta = get_post_meta($post_id, 'lp_listingpro_options', true);
										$plan_id = listing_get_metabox_by_ID('Plan_id',$post_id);
										$plan_price = get_post_meta($plan_id, 'plan_price', true);
										$plan_duration = get_post_meta($plan_id, 'plan_time', true);
										$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
										$terms = wp_get_post_terms( $post_id, 'listing-category', array() );
										$price = '';
										$price = $plan_price;
										$deafaultFeatImg = lp_default_featured_image_listing();
										
										$catname = '';
										if( count($terms)>0 ){
											$catname = $terms[0]->name;
										}
										if(!empty($plan_price)){
											$outputCheck .='<div class="lp-user-listings clearfix" data-plantype="'.$plan_type.'" data-recurringtext="'.esc_html__('Recurring Payment?', 'listingpro-plugin').'"><div class="col-md-12 col-sm-12 col-xs-12 lp-listing-clm lp-checkout-page-outer lp-checkout-page-outer-new">';
											
											$outputCheck .= '<div class="col-md-10 col-sm-6 col-xs-6">';
												/* left side */
													$outputCheck .= '<h3 id="lp-checkout-lisiting-heading">'.get_the_title($post_id).'</h3>';
											
													$outputCheck .= '<div class="col-md-1 col-sm-2 col-xs-6">';

														$outputCheck .='<div class="radio radio-danger lp_price_trigger_checkout">
															<input type="radio" name="listing_id" data-taxenable = "'.$enableTax.'" data-planid="'.$plan_id.'" data-taxrate = "'.$Taxrate.'" data-planprice = "'.$plan_price.'" data-title="'.get_the_title($plan_id).'" data-price="'.$price.'" id="'.$post_id.'" value="'.$post_id.'">
															<label for="'.$post_id.'">
															 
															</label>
														</div>';
													$outputCheck .='</div>';
											
											if ( has_post_thumbnail($post_id) ) { 
												
												$imgurl = get_the_post_thumbnail_url($post_id, 'listingpro-review-gallery-thumb');
														$outputCheck .= '<input type="hidden" name="listing_img" value="'.$imgurl.'">';
														$outputCheck .='<div class="col-md-3">';
														$outputCheck .='<img class="img-responsive" src="'.$imgurl.'" alt="" />';
														$outputCheck .='</div>';
												
											}
											elseif(!empty($deafaultFeatImg)){
														$outputCheck .= '<input type="hidden" name="listing_img" value="'.$deafaultFeatImg.'">';
														$outputCheck .='<div class="col-md-3">';
														$outputCheck .='<img class="img-responsive" src="'.$deafaultFeatImg.'" alt="" />';
														$outputCheck .='</div>';
											}
											else {
														$outputCheck .='<div class="col-md-3">';
														$outputCheck .='<img class="img-responsive" src="'.esc_url('https://placeholdit.imgix.net/~text?txtsize=33&txt=ListingPro&w=80&h=80').'" alt="" />';
														$outputCheck .='</div>';
											}
											
													$outputCheck .= '<div class="col-md-7">';
														$outputCheck .= '<span class="lp-booking-dt"><p>'.esc_html__('Date: ','listingpro-plugin').
														get_the_date('', $post_id).'</p></span>';
											
														$outputCheck .= '<span class="lp-persons"><p>'.esc_html__('Category: ','listingpro-plugin')
														.$catname.'</p></span>';
											
														$outputCheck .= '<span class="lp-duration"><p>'.esc_html__('Duration: ','listingpro-plugin').$plan_duration.esc_html__(' Days','listingpro-plugin').'</p></span>';
											
													$outputCheck .='</div>';

											
												/* left side ends*/
											$outputCheck .= '</div>';
											

											$outputCheck .= '<div class="col-md-2 col-sm-6 col-xs-6 lp-checkout-price-currency-outer">';
												/* right side */
													$outputCheck .= '<div class="lp-checkout-price-currency">';
														switch($currency_position){

															case('left'):
															$outputCheck .= $currency_symbol.$price;
															break;

															case('right'):
															$outputCheck .= $price.$currency_symbol;
															break;

															default:
															$outputCheck .= $currency_symbol.$price;

														}
													$outputCheck .='</div>';
												/* right side ends*/
											$outputCheck .= '</div>';

											$outputCheck .='</div>';

											$outputCheck .='</div>';
										}

										$outputCheck .= '<input type="hidden" name="currency" value="'.$currency.'">';
							}
		$outputCheck .='</div>';

        $outputCheck .= '<input type="hidden" name="listings_tax_price" value="">';
        $outputCheck .= '<input type="hidden" name="method" value="">';
        $outputCheck .= '<input type="hidden" name="func" value="start">';
		$outputCheck .= '<input type="hidden" name="plan_price" value="">';
		$outputCheck .= '<input type="hidden" name="post_title" value="">';
		$outputCheck .= '<input type="hidden" name="listings_id" value="">';
		$outputCheck .= '<input type="hidden" name="plan_id" value="">';
		$outputCheck .= '<input type="hidden" name="post_id" value="">';
												}
												else{
			$outputCheck .='<p class="text-center">'.esc_html__('Sorry! You have no paid listings yet!','listingpro-plugin').'</p>';
											}
											
	echo $outputCheck;

