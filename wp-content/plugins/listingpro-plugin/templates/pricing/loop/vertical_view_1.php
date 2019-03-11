<?php
	global $wpdb,$listingpro_options;
	$plan_package_type = get_post_meta( get_the_ID(), 'plan_package_type', true );
	$post_price = get_post_meta(get_the_ID(), 'plan_price', true);
	
	$plan_type = '';
	$plan_type_name = '';
	$plan_type = get_post_meta(get_the_ID(), 'plan_package_type', true);
	if( $plan_type=="Pay Per Listing" ){
		$plan_type_name = esc_html__("Per Listing",'listingpro-plugin');
	}
	else{
		$plan_type_name = esc_html__("Per Package",'listingpro-plugin');
	}

	$plan_time = '';
	$plan_time = get_post_meta(get_the_ID(), 'plan_time', true);
	$posts_allowed_in_plan = '';
	$PostAllowedInPlan = get_post_meta(get_the_ID(), 'plan_text', true);
	if(!empty($PostAllowedInPlan)){
		$posts_allowed_in_plan = get_post_meta(get_the_ID(), 'plan_text', true);
		$posts_allowed_in_plan = trim($posts_allowed_in_plan);
	}
	else{
		$posts_allowed_in_plan = 'unlimited';
	}
	
	$contact_show = get_post_meta( get_the_ID(), 'contact_show', true );
	if($contact_show == 'true'){
		$contact_checked = 'checked';
	}else{
		$contact_checked = 'unchecked';
	}
	
	$map_show = get_post_meta( get_the_ID(), 'map_show', true );
	if($map_show == 'true'){
		$map_checked = 'checked';
	}else{
		$map_checked = 'unchecked';
	}
	
	$video_show = get_post_meta( get_the_ID(), 'video_show', true );
	if($video_show == 'true'){
		$video_checked = 'checked';
	}else{
		$video_checked = 'unchecked';
	}
	
	$gallery_show = get_post_meta( get_the_ID(), 'gallery_show', true );
	if($gallery_show == 'true'){
		$gallery_checked = 'checked';
	}else{
		$gallery_checked = 'unchecked';
	}
	
	$listingproc_tagline = get_post_meta( get_the_ID(), 'listingproc_tagline', true );
	if($listingproc_tagline == 'true'){
		$tagline_checked = 'checked';
	}else{
		$tagline_checked = 'unchecked';
	}
	
	$listingproc_location = get_post_meta( get_the_ID(), 'listingproc_location', true );
	if($listingproc_location == 'true'){
		$location_checked = 'checked';
	}else{
		$location_checked = 'unchecked';
	}
	
	$listingproc_website = get_post_meta( get_the_ID(), 'listingproc_website', true );
	if($listingproc_website == 'true'){
		$website_checked = 'checked';
	}else{
		$website_checked = 'unchecked';
	}
	
	$listingproc_social = get_post_meta( get_the_ID(), 'listingproc_social', true );
	if($listingproc_social == 'true'){
		$social_checked = 'checked';
	}else{
		$social_checked = 'unchecked';
	}
	
	$listingproc_faq = get_post_meta( get_the_ID(), 'listingproc_faq', true );
	if($listingproc_faq == 'true'){
		$faq_checked = 'checked';
	}else{
		$faq_checked = 'unchecked';
	}
	
	$listingproc_price = get_post_meta( get_the_ID(), 'listingproc_price', true );
	if($listingproc_price == 'true'){
		$price_checked = 'checked';
	}else{
		$price_checked = 'unchecked';
	}
	
	$listingproc_tag_key = get_post_meta( get_the_ID(), 'listingproc_tag_key', true );
	if($listingproc_tag_key == 'true'){
		$tag_key_checked = 'checked';
	}else{
		$tag_key_checked = 'unchecked';
	}
	
	$listingproc_bhours = get_post_meta( get_the_ID(), 'listingproc_bhours', true );
	if($listingproc_bhours == 'true'){
		$bhours_checked = 'checked';
	}else{
		$bhours_checked = 'unchecked';
	}
	
	/* new options  */
	$resurva_show = get_post_meta( get_the_ID(), 'listingproc_plan_reservera', true );
	if($resurva_show == "true"){
		$resurva_show = 'checked';
	}else{
		$resurva_show = 'unchecked';
	}
	
	$timekit_show = get_post_meta( get_the_ID(), 'listingproc_plan_timekit', true );
	if($timekit_show == "true"){
		$timekit_show = 'checked';
	}else{
		$timekit_show = 'unchecked';
	}
	
	$menu_show = get_post_meta( get_the_ID(), 'listingproc_plan_menu', true );
	if($menu_show == "true"){
		$menu_show = 'checked';
	}else{
		$menu_show = 'unchecked';
	}
	
	$announcment_show = get_post_meta( get_the_ID(), 'listingproc_plan_announcment', true );
	if($announcment_show == "true"){
		$announcment_show = 'checked';
	}else{
		$announcment_show = 'unchecked';
	}
	
	$deals_show = get_post_meta( get_the_ID(), 'listingproc_plan_deals', true );
	if($deals_show == "true"){
		$deals_show = 'checked';
	}else{
		$deals_show = 'unchecked';
	}
	
	$competitor_show = get_post_meta( get_the_ID(), 'listingproc_plan_campaigns', true );
	if($competitor_show == "true"){
		$competitor_show = 'checked';
	}else{
		$competitor_show = 'unchecked';
	}
	
	
	$featured_show = get_post_meta( get_the_ID(), 'lp_featured_imageplan', true );
	if($featured_show == "true"){
		$featured_show = 'checked';
	}else{
		$featured_show = 'unchecked';
	}
	
	
	$event_show = get_post_meta( get_the_ID(), 'lp_eventsplan', true );
	if($event_show == "true"){
		$event_show = 'checked';
	}else{
		$event_show = 'unchecked';
	}
	/* new options ends  */
	
	$plan_hot = '';
	$plan_hot = get_post_meta( get_the_ID(), 'plan_hot', true );
	
	$hotClass = '';
	if(!empty($plan_hot) && $plan_hot=="true") {
		$hotClass = 'featured-plan';
	}else {
		$hotClass = '';
	}
	
	/* here you go for dbs*/
	$results = null;
	$currentPlanID = get_the_ID();
	$plan_text = '';
	$used = '';
	$plan_limit_left = '';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
		$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$currentPlanID' AND status = 'success' AND plan_type='$plan_type'" );
	}
	
	if( !empty($results) && count($results)>0 ){
		$used = '';
		$used = $results[0]->used;
		
		if(is_numeric($posts_allowed_in_plan)){
			$plan_limit_left = (int)$posts_allowed_in_plan - (int)$used;
		}
		else{
			$plan_limit_left = 'unlimited';
		}
		
	}
	else{
		$plan_limit_left = $PostAllowedInPlan;
	}

	if( !empty ( $plan_package_type ) ){
		if( $plan_package_type=="Pay Per Listing" ){
			$plan_text = '';
		}
		else if( $plan_package_type=="Package" ){
			$plan_text = get_post_meta(get_the_ID(), 'plan_text', true);
			if( !empty($plan_text) && isset($plan_text) ){
				$plan_text = esc_html__('Max. listings allowed : ', 'listingpro-plugin').$plan_text;
			}
		}
	}
	// start centerlized plan
        $classoffset = '';
        if(isset($GLOBALS['plans_count'])){
            if($GLOBALS['plans_count'] == '1'){
                $classoffset = 'col-md-offset-4';
            }
            if($GLOBALS['plans_count'] == '2'){
                $classoffset = 'col-md-offset-2';
            }
        }

    //End centerlized plan								
	
	
?>
	<div class="col-md-4 price-view-default <?php echo get_the_ID(). ' '.$hotClass.' '.$classoffset ?>">
				<div class="lp-price-main lp-border-radius-8 lp-border text-center">
					<?php 
						/* ================ */
						$user_ID = get_current_user_id();
						if( !empty($plan_type) && $plan_type=="Package" ){
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$currentPlanID' AND status = 'success' AND plan_type='$plan_type'" );
							}
							
							if(is_numeric($plan_limit_left)){
								if( !empty($results) && count($results)>0 ){
									if(!empty($post_price) && $plan_limit_left>0){
										echo '<div class="lp-sales-option">
														<div class="sales-offer">
															'.esc_html__("Active",'listingpro-plugin').'
														</div>
													</div>';
									}
								}
							}
							else if(!empty($post_price) && $plan_limit_left=="unlimited"){
								if( !empty($plan_type) && $plan_type=="Package" ){
									if( !empty($results) && count($results)>0 ){
										echo '<div class="lp-sales-option">
														<div class="sales-offer">
															'.esc_html__("Active",'listingpro-plugin').'
														</div>
													</div>';
									}
								}
							}
						}
						$plan_title_color = '';
						$plan_title_img =   '';
						$plan_title_bg  =   '';

						$plan_title_img = listing_get_metabox_by_ID('lp_price_plan_bg', get_the_ID()); 

						$plan_title_color = get_post_meta(get_the_ID(), 'plan_title_color', true);
						$classForBg = 'lp-title';
						if( isset($plan_title_img) && $plan_title_img != '' )
						{
							$plan_title_bg  =   "background: url($plan_title_img); background-size:cover;";
							$classForBg .= ' lp-overlay-pricing';
						}
						else
						{
							$plan_title_bg  =   "background-color: $plan_title_color;";
						}
						/* ================ */
					?>
					
					<div class="<?php echo $classForBg; ?>" style="<?php echo $plan_title_bg; ?>">
										<div class="lp-plane-top-wrape">
											<a><?php echo get_the_title(); ?></a>
											<?php
											if(!empty($post_price)){
												if($withtaxprice=="1"){
													$taxrate = $listingpro_options['lp_tax_amount'];
													$taxprice = (float)(($taxrate/100)*$post_price);
													$post_price = (float)$post_price + (float)$taxprice;
												}
												$post_price = round($post_price,2);
												$lp_currency_position = $listingpro_options['pricingplan_currency_position'];
												if(isset($lp_currency_position) && $lp_currency_position=="left"){
												?>
													<p><?php echo listingpro_currency_sign().$post_price; ?></p>
												<?php
												}
												else{ ?>
													<p><?php echo $post_price.listingpro_currency_sign(); ?></p>
												<?php
												}
											}
											else{ ?>
												<p><?php echo esc_html__("Free", 'listingpro-plugin'); ?></p>
											<?php
											}
											if(!empty($plan_type_name)){ ?>
												<span class="package-type"><?php echo $plan_type_name; ?></span><br><br>
											<?php
											}
											
											if(is_numeric($plan_limit_left)){
												if( !empty($results) && count($results)>0 ){
													if(!empty($post_price) && $plan_limit_left>0){ ?>
														<span style="font-size:12px;color:#fff" class="allowedListing"><?php echo esc_html__('Remaining Listings : ', 'listingpro-plugin') . $plan_limit_left; ?></span>
													
													<?php
													}
												}
											}
											?>
										</div>
					</div>
					
					<!--Bottom plan section -->
					
					<div class="lp-price-list" style="display:block;">
							<?php
								/* =============== */
									if(!empty($plan_hot) && $plan_hot=="true"){ ?>
										<div class="lp-hot"><?php echo esc_html__('Hot','listingpro-plugin'); ?></div>
									<?php
									}
								/* =============== */
							?>
							
									
									<ul class="lp-listprc">
											<li>
												<span class="icon-text">
													<img class="icon icons8-Cancel" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAFaElEQVRoQ+1aTVbbVhT+rpSDO6s5EePACgqTVh7F7ABWgFkBZlKbUckInAnJCmJWULICxMhuJjgrCIxxDnQGja3bcyU9+0lI1pNsSk9OPAL8/r77893v3QfhO/nQd4IDP4CkefLtp9vXzH6dmesErgK0Ph3HAwbdye9E5BFZH3//dXmwqIiY2yNHvZs6Ee0Q0Ch6KAauAHjMfHpQW/GKztfHlwbS+Wu4xYw9AupqQQZ/BsTa8IjsK93ibz/dro/Ho6plUZUZdWJsgfBqOjcA9KYsoMJAjnq3q0TjDxMAjGuAuz5edA9qy2Jh44+A4/Foi4maBPwsExnwKhV7e39jOQhD008hIOIFMD4AqDLwN4EOW+7Ld6abZY07ubyt/nM/aipAEnKWZW8nc0jGZQE0BnLc/7pH4ODQDHysVOxGUavlAZaDPjyMPAL9ImN9xu5BzenKz0e9YcMinJBlb6aRhBGQ4/5QQilKZtpfhBdmgTruD98RsEeWvSGHFkKxiM6T4Aole6f/tQnwiYQSM5rKQnnWnfd7yUXJuSCP/LGAqIL5Tau2cpi29kyPRDnx5yxLzHvgWfOD3HkYnQf1iHHaqjmZFJ8JRCxi0fgysASePpzSAHX6N5cCQmi9UnlRn5WTmUCO+8NzoVhJ7LbrbD2l5dPWnuQl43rpJ3tdQEiuZNWZVCAqpCQvKhV7ddHslGcUPS8ty67rCe8zb6aBSQWivPEcIRXRrNQqgLDd+s05kx87vZtDEP0hBbPtOptJYzwCMqE6xnWr5qzmWW+R3+sMpdcQ2SOsMeMrUQBpXnkEpNMbdkHYmUV1izy8WitGLhkMpbySxmCPgfSHHNKtvVZUO5UFGKdZvmjVViZCVF8zAvsFwN1SxV7TczcGZJrk/Lntrmh3ibJHNJvX6Q+lVm2Z0Oxx/2YgEiYZXnEg04R633adptkx5hulaDZUDvZ6XhQo+ZIM/SQQD0SvdbaY75izZyuGEhCKZvP20+bE6lscSFRJlVjLW3Se702EYNr6U1aN51ICSJjoLdcxVsXMuCgqJE2FYBqQkBjGt5LwLddZVmNKA9ELV5Lz84Tgw8P4koDVPCGYtU4nYlbd4KWByCY6GAY12+7L93nhpgvBssy4cCCPwaDbdp3dLDBpQjAPeNr3uUAURxdN9rhn0sFoWsmYodJARPl1KTVH9+jC6Dfqb52JFmLEwcTzKV29mnpmctnjWaw1Z0EUa/n+2IvABG2db9+wyn5wQYs1E0wPnhxnVBCn3M6DlruyUWYzHQzAA4BEQVfLMlTyDIosZkoUmaQSaR7RGIIZdVVbZ1G3TCUaRQm0Xaeqg3wyGa96VLJZ3n3b1POFZLwKL+n2tV1nzXSTrCp8f49qnhA03aPTH0pFrxpdrILw6t2E4vGZuifptSPsryHBVqkSRf1R62c9usCYWm+R4yJ9JReqVG/IXpnicOoVnLVcZ3uRByu61vTild2amtmgIxoPwnb/8zToQhbVW7bZF6//dcs0qzWU5tHce4eyiOh/n7Ff9O5RNIzU+BgIg4jIBRKyWNQiCt5GzOR6WQAyT3+LMVUERkD0WI0OeLZUsXcX3UqN2Em6jFGv2Tw3jYEEYMIH0G703nfHoEOTy5SJdyIvyNtH+KxHaKh2qcn8QkBkwUDvYNQNC2bwDHdFRF3ft06LVvBgLcvfYeZGcPWNnvWY7WbRtQoDiRVNn5sKUPh3UbvwGORZln2dfOuLlPErAksnsR77hwLmCx84/M+ep5NuDrQZqBH0iwt+ghBinPngblkAMyVKwfNMhoeggn8gqDOhqmS8GiDXU2LI+7nnA968h9fPWTq0yoJ9qnk/gDyVZcuu+y8Ax3BgT7fNbAAAAABJRU5ErkJggg==" alt="icon-cross">
												</span>
												
												<span>
													<?php if($plan_time){ ?>
														<?php echo esc_html__('Duration', 'listingpro-plugin').' : '.$plan_time.' '.esc_html__('days', 'listingpro-plugin'); ?>
													<?php } else { ?>
														<?php echo esc_html__('Duration', 'listingpro-plugin'); ?>
														<?php echo esc_html__(' : Unlimited days', 'listingpro-plugin'); ?>
													<?php }?>
												</span>
											</li>
											
											<?php
												if(!empty($posts_allowed_in_plan) && $plan_type=="Package"){ ?>
												<li>
													<span class="icon-text"><?php echo listingpro_icon8('checked'); ?></span>
													<span><?php echo esc_html__('Max. Listings : ', 'listingpro-plugin'). $posts_allowed_in_plan; ?>
													</span>
												</li>
											<?php
												}
											?>
											
											<?php
												
												if($listingpro_options['lp_showhide_address']=="1"){
													if(get_post_meta(get_the_ID(), 'map_show_hide', true)==''){
														echo '
														<li>
															<span class="icon icons8-Cancel">'.listingpro_icon8($map_checked).'</span>
															<span>'.esc_html__('Map Display', 'listingpro-plugin').'</span>
														</li>';
													}
												}
												if($listingpro_options['phone_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'contact_show_hide', true)==''){
														echo '
																<li>
																	<span class="icon icons8-Cancel">'.listingpro_icon8($contact_checked).'</span>
																	<span>'.esc_html__('Contact Display', 'listingpro-plugin').'</span>
																</li>
																';
													}
												}
												if($listingpro_options['file_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'gall_show_hide', true)==''){
														echo '
															<li>
																<span class="icon icons8-Cancel">'.listingpro_icon8($gallery_checked).'</span>
																<span>'.esc_html__('Image Gallery', 'listingpro-plugin').'</span>
															</li>
															';
													}
												}
												if($listingpro_options['vdo_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'video_show_hide', true)==''){
														echo '
															<li>
																<span class="icon icons8-Cancel">'.listingpro_icon8($video_checked).'</span>
																<span>'.esc_html__('Video', 'listingpro-plugin').'</span>
															</li>
															';
													}
												}
												if(get_post_meta(get_the_ID(), 'tagline_show_hide', true)==''){
													echo '
													<li>
														<span class="icon-text">'.listingpro_icon8($tagline_checked).'</span>
														<span>'.esc_html__('Business Tagline', 'listingpro-plugin').'</span>
													</li>
													';
												}
												if($listingpro_options['location_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'location_show_hide', true)==''){
														echo '
															<li>
																<span class="icon-text">'.listingpro_icon8($location_checked).'</span>
																<span>'.esc_html__('Location', 'listingpro-plugin').'</span>
															</li>';
													}
												}
												if($listingpro_options['web_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'website_show_hide', true)==''){
														echo '
														<li>
															<span class="icon-text">'.listingpro_icon8($website_checked).'</span>
															<span>'.esc_html__('Website', 'listingpro-plugin').'</span>
														</li>';
													}
													
												}
												
												if($listingpro_options['listin_social_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'social_show_hide', true)==''){
														echo '
														<li>
															<span class="icon-text">'.listingpro_icon8($social_checked).'</span>
															<span>'.esc_html__('Social Links', 'listingpro-plugin').'</span>
														</li>
														';
													}
												}
												if($listingpro_options['faq_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'faqs_show_hide', true)==''){
														echo '
															<li>
																<span class="icon-text">'.listingpro_icon8($faq_checked).'</span>
																<span>'.esc_html__('FAQ', 'listingpro-plugin').'</span>
															</li>
															';
													}
												}
												if($listingpro_options['currency_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'price_show_hide', true)==''){
														echo '
															<li>
																<span class="icon-text">'.listingpro_icon8($price_checked).'</span>
																<span>'.esc_html__('Price Range', 'listingpro-plugin').'</span>
															</li>
															';
													}
												}
												
												if($listingpro_options['tags_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'tags_show_hide', true)==''){
														echo '
															<li>
																<span class="icon-text">'.listingpro_icon8($tag_key_checked).'</span>
																<span>'.esc_html__('Tags/Keywords', 'listingpro-plugin').'</span>
															</li>
															';
													}
												}
												if($listingpro_options['oph_switch']=="1"){
													if(get_post_meta(get_the_ID(), 'bhours_show_hide', true)==''){
														echo '		
														<li>
															<span class="icon-text">'.listingpro_icon8($bhours_checked).'</span>
															<span>'.esc_html__('Business Hours', 'listingpro-plugin').'</span>
														</li>
														';
													}
												}
												
												
												/* new option */
											if(lp_theme_option('lp_featured_file_switch')){
												if(get_post_meta(get_the_ID(), 'reserva_show_hide', true)==''){
													echo '
														<li>
															<span class="icon-text">'.listingpro_icon8($resurva_show).'</span>
															<span>'.esc_html__('Resurva', 'listingpro-plugin').'</span>
														</li>
														';
												}
											}
											if(get_post_meta(get_the_ID(), 'timekit_show_hide', true)==''){
												echo '
													<li>
														<span class="icon-text">'.listingpro_icon8($timekit_show).'</span>
														<span>'.esc_html__('Timekit', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if(get_post_meta(get_the_ID(), 'menu_show_hide', true)==''){
												
												echo '
												<li>
													<span class="icon-text">'.listingpro_icon8($menu_show).'</span>
													<span>'.esc_html__('Menu', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if(get_post_meta(get_the_ID(), 'announcment_show_hide', true)==''){
												echo '
												<li>
													<span class="icon-text">'.listingpro_icon8($announcment_show).'</span>
													<span>'.esc_html__('Announcment', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if(get_post_meta(get_the_ID(), 'deals_show_hide', true)==''){
												echo '
												<li>
													<span class="icon-text">'.listingpro_icon8($deals_show).'</span>
													<span>'.esc_html__('Deals-Offers-Discounts', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if(get_post_meta(get_the_ID(), 'metacampaign_show_hide', true)==''){
												echo '
												<li>
													<span class="icon-text">'.listingpro_icon8($competitor_show).'</span>
													<span>'.esc_html__('Hide competitors Ads', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if(get_post_meta(get_the_ID(), 'events_show_hide', true)==''){
												
												echo '
												<li>
													<span class="icon-text">'.listingpro_icon8($event_show).'</span>
													<span>'.esc_html__('Events', 'listingpro-plugin').'</span>
												</li>
												';
											}
											/* new option emd */
												
												
												
												$lp_plan_more_fields = listing_get_metabox_by_ID('lp_price_plan_addmore',get_the_ID());
												if(!empty($lp_plan_more_fields)){
													foreach($lp_plan_more_fields as $morefield){
														if(!empty($morefield)){
															echo '<li>
																<span class="icon-text">'.listingpro_icon8('checked').'</span>
																<span>'.$morefield.'</span>
															</li>';
														}
													}
												}
											?>
											
									</ul>
									
									<form method="post" name="<?php echo get_the_ID(); ?>" action="<?php echo listingpro_url('submit-listing'); ?>" class="price-plan-button">
									<!-- for button -->
									<?php
										echo '<input type="hidden" name="plan_id" value="'.get_the_ID().'" />';
											
											if(empty($post_price) && $plan_type=="Package"){
												echo '<p>A <strong>'.esc_html__("Package",'listingpro-plugin').'</strong>'.esc_html__(" should have a price ",'listingpro-plugin').'</p>';

											}
											else if( !empty($plan_type) && $plan_type=="Package" ){
												if(!empty($plan_limit_left)){
											
													echo '<input id="submit'.get_the_ID().'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												}
												else{
													echo '<input id="submit'.get_the_ID().'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												}
											}
											else{
											
													echo '<input id="submit'.get_the_ID().'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												
												
											}
											echo  wp_nonce_field( 'price_nonce', 'price_nonce_field'.get_the_ID() ,true, false );
											
											if(isset($_POST['lp_cat_plan_submit'])){
												$lp_s_cat= $_POST['lp-slected-plan-cat'];
												echo '<input type="hidden" value="'.$lp_s_cat.'" name="lp_pre_selected_cats" />';
											}
											
											
									?>
									<!-- for button -->
									</form>	
										
									
					</div>
									
					
				</div>
	</div>