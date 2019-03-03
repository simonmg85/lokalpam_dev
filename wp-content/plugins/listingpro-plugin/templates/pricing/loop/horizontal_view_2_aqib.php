<?php
	global $listingpro_options;
	$listing_access_only_users = $listingpro_options['lp_allow_vistor_submit'];
	$showAddListing = true;
	if( isset($listing_access_only_users)&& $listing_access_only_users==1 ){
		$showAddListing = false;
		if(is_user_logged_in()){
			$showAddListing = true;
		}
	}
	if( $showAddListing==false ){
		wp_redirect(home_url());
		exit;
	}
	global $wpdb;
	
	$lp_social_show;
	$lp_social_show = $listingpro_options['listin_social_switch'];
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$outputHorz = null;
	$results = null;
	$table_name = $dbprefix.'listing_orders';
	$limitLefts = '';
	$taxOn = $listingpro_options['lp_tax_swtich'];
	$withtaxprice = false;
	if($taxOn=="1"){
		$showtaxwithprice = $listingpro_options['lp_tax_with_plan_swtich'];
		if($showtaxwithprice=="1"){
			$withtaxprice = true;
		}
	}
	
	
	$showCatsBoxes = false;
	/* $lp_plan_based = $listingpro_options['listingpro_plans_cats_pos'];
	if(!empty($lp_plan_based)){
		$showCatsBoxes = true;
	} */
	
	/* horizontal view */
	
							global $post;
							$plan_package_type = get_post_meta( get_the_ID(), 'plan_package_type', true );
							$post_price = get_post_meta(get_the_ID(), 'plan_price', true);
							$plan_time = '';
							$plan_time = get_post_meta(get_the_ID(), 'plan_time', true);
							$posts_allowed_in_plan = '';
							$posts_allowed_in_plan = get_post_meta(get_the_ID(), 'plan_text', true);							$plan_type = $plan_package_type;
							
							if(!empty($plan_package_type) && $plan_package_type=="Package"){
								if(is_numeric($posts_allowed_in_plan)){
									$posts_allowed_in_plan = $posts_allowed_in_plan;
								}
								else{
									$posts_allowed_in_plan = esc_html__('unlimited', 'listingpro-plugin');
								}
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


							$plan_hot = '';
							$plan_hot = get_post_meta( get_the_ID(), 'plan_hot', true );
							
							
							
							
							$plan_type_name = '';
							if( $plan_package_type=="Pay Per Listing" ){
								$plan_type_name = esc_html__("Per Listing",'listingpro-plugin');
							}
							else{
								$plan_type_name = esc_html__("Per Package",'listingpro-plugin');
							}
							
				
							$plan_text = '';
							$used = '';
							$plan_limit_left = '';
							$limitLefts = null;
							$currentPlanID = get_the_ID();
							
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id ='$currentPlanID' AND status = 'success' AND plan_type='$plan_package_type'"  );
							}
							
							$used = '';
							if(!empty($plan_package_type) && $plan_package_type=="Package"){
									$plan_text = esc_html__('Per Package ', 'listingpro-plugin');
									$plan_limit_left = $posts_allowed_in_plan;
								}
								else if(!empty($plan_package_type) && $plan_package_type=="Pay Per Listing"){
									$plan_text = esc_html__('Per Listing ', 'listingpro-plugin');
								}
							if( !empty($results) && count($results)>0 ){
								if(!empty($plan_package_type) && $plan_package_type=="Package"){
									
									/* package details */
									/* foreach ( $results as $info ) {
										$used = $info->used;
									} */
									
									$used = $results[0]->used;
									
									if(is_numeric($posts_allowed_in_plan)){
										$plan_limit_left = (int)$posts_allowed_in_plan - (int)$used;
									}
									else{
										$plan_limit_left = $posts_allowed_in_plan;
									}
									
									$plan_text = esc_html__('Per Package ', 'listingpro-plugin');
								}
								else if(!empty($plan_package_type) && $plan_package_type=="Pay Per Listing"){
									$plan_text = esc_html__('Per Listing ', 'listingpro-plugin');
								}
								
								
								
							}
							
							$plan_title_color = '';
                            $plan_title_img =   '';
                            $plan_title_bg  =   '';

                            $plan_title_img = listing_get_metabox_by_ID('lp_price_plan_bg', get_the_ID()); 
							
                            $plan_title_color = get_post_meta(get_the_ID(), 'plan_title_color', true);
							$classForBg = 'price-plan-box-upper';
                            if( isset($plan_title_img) && $plan_title_img != '' )
                            {
                                $plan_title_bg  =   "background: url($plan_title_img); background-size:cover;";
								$classForBg .= ' lp-overlay-pricing';
                            }
                            else
                            {
                                $plan_title_bg  =   "background-color: $plan_title_color;";
                            }

                            $hotClass = '';
							if(!empty($plan_hot) && $plan_hot=="true") {
								$hotClass = 'featured-plan';
							}else {
								$hotClass = '';
							}
							
							//class="featured-active-plan" for active plans 
							$outputHorz .='
							<div class="lp_hori_view_plan_left_section '.get_the_ID().' '.$hotClass.'">
							<div class="lp-active-badge-on-plan">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEoAAABdCAYAAAACA/BSAAAACXBIWXMAABYlAAAWJQFJUiTwAAAEcklEQVR4nO3cv0+TQQDG8QestA3oK9GUNoGGEOtkYusKjazGhcHFDXTVGCcGFx1I3DBxcCOwMDDpgP4BNC6SoNGtmCgaCyWKr9RAa20d2oNS2r53fe/XS++bsEBf7vjkerw9GrpGn3yaBDCJDmn/54++zTepm99WHnxmuc4HYBjANRGT0rJyGQBeAIizXNYtZDL6d2UwOfuU5YJOhQKA+4PJ2QnaB3cyFADMDyZnh2ke2OlQFir7lWOdDgVQ7lcGqpLjfmWgDmu5Xxmow1ruVwbqaE33KwN1vIb7lYFq3LH9ykA17th+ZaCad2S/MlCtO9ivDJRz84PJ2XMGyjkLwAufqtEjlg8Zuyh93MD5C/i28qCL9TplK+rhjRAS0aCq4ZlTApWIBhEfCuDOWL+K4dtKCRQBig8FPLOqpEOR1UTyyqqSDlUP45VVJRWqfjWRvLCqpEI1A/HCqpIG1Ww1kXRfVdKgnCB0X1Xc78xjoR70BU4hEQ3gjL8bsQE/wpYP4bPOQz27FcG7r/vY3f+HdLaATbuIjF1EeiuPXL7Ee6pMuYKKhXqQvNSLq9Eg+vzduBjqcT0h8vRMxnqPfD6XL2E9W0DG/ov0VgFLq7brsVhy9dRLZwuIWD7EhwJckFrV5+9GfCiAZKwXaxt7QsdqlOs9amZ5G68/7vKYi2O5fAn3Fr8jnS1IGa82Lpu5DCyVSADH33oisVQjAZxvD0Rg6YAECLiP4omlCxIg6IaTB5ZOSIDAO/OZ5W1X1y+t2togAQKhYi7vq9xezzthUGHrtKvrIy6v5524FTXgbkWIvtNnTdunHq/vwSuBK8rf8uvr2YLjiYDbpy/PhP0BtNmxyubvIuZSO3j1YRcRy4fbY/24fvlMw8fGBnqwkv4jaopMCYFqdABXC0TK2EXMLG9jLrXTEOxqNIg57IiYInNCoCLW4bfN5UuYS+20PD+qBXt4I3RwJhW2lP3F/1hCZhK2fMjlS1hatbH01qY+nczYRdxd/I5ENIg7Y/0tz9hlJwQqvVXAzecbbR/frm3s4e7iHhLRoLI3c9QnBIrXBqziJLNZ5v1RlBkoygwUZQaKMgNFmYGizEBRZqAoM1CUGSjKDBRlBooylVBfFI7NnCqo96j8E5kpReMzpwLqPYDx1PTIr9T0yDw8giUb6gCJfKKK9VjyPJiTCWWjDomUmh55BGBB4lyYkwXVFImUmh6ZhMZYMqAI0junB+qMJRqKGomkK5ZIKGYkko5YoqDaRiLphiUCyjUSSScs3lDckEi6YPGE4o5E0gGLF5QwJJJqLF5QQpFIKrF4QE3JQCKpwnILNVV9USu1KtZLmWO6gVKCVNMkKqcRUmoXSjUSqi+wxyEJqx0o5UgkmVisUNogkWRhsUBph0SSgUULpS0SSTQWDZT2SCSRWE5QnkEiicJqBbXgNSSSCKxmUAvVu1/PxhurEZTnkUg8seqhTgwSiRdWLdSJQyLVYLX9xhACdWKRSFWsCVQOGdkbffJpuFwuo1M+2v15/wPdmpDUltAwdgAAAABJRU5ErkJggg==">
							</div>
								<ul class="horizontal_view_list">';
								if(!empty($plan_hot) && $plan_hot=="true"){
										//echo '<div class="lp-hot">'.esc_html__('Hot','listingpro-plugin').'</div>';

										$outputHorz .='<div class="lp-hot">
													<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEoAAABdCAYAAAACA/BSAAAACXBIWXMAABYlAAAWJQFJUiTwAAAEcklEQVR4nO3cv0+TQQDG8QestA3oK9GUNoGGEOtkYusKjazGhcHFDXTVGCcGFx1I3DBxcCOwMDDpgP4BNC6SoNGtmCgaCyWKr9RAa20d2oNS2r53fe/XS++bsEBf7vjkerw9GrpGn3yaBDCJDmn/54++zTepm99WHnxmuc4HYBjANRGT0rJyGQBeAIizXNYtZDL6d2UwOfuU5YJOhQKA+4PJ2QnaB3cyFADMDyZnh2ke2OlQFir7lWOdDgVQ7lcGqpLjfmWgDmu5Xxmow1ruVwbqaE33KwN1vIb7lYFq3LH9ykA17th+ZaCad2S/MlCtO9ivDJRz84PJ2XMGyjkLwAufqtEjlg8Zuyh93MD5C/i28qCL9TplK+rhjRAS0aCq4ZlTApWIBhEfCuDOWL+K4dtKCRQBig8FPLOqpEOR1UTyyqqSDlUP45VVJRWqfjWRvLCqpEI1A/HCqpIG1Ww1kXRfVdKgnCB0X1Xc78xjoR70BU4hEQ3gjL8bsQE/wpYP4bPOQz27FcG7r/vY3f+HdLaATbuIjF1EeiuPXL7Ee6pMuYKKhXqQvNSLq9Eg+vzduBjqcT0h8vRMxnqPfD6XL2E9W0DG/ov0VgFLq7brsVhy9dRLZwuIWD7EhwJckFrV5+9GfCiAZKwXaxt7QsdqlOs9amZ5G68/7vKYi2O5fAn3Fr8jnS1IGa82Lpu5DCyVSADH33oisVQjAZxvD0Rg6YAECLiP4omlCxIg6IaTB5ZOSIDAO/OZ5W1X1y+t2togAQKhYi7vq9xezzthUGHrtKvrIy6v5524FTXgbkWIvtNnTdunHq/vwSuBK8rf8uvr2YLjiYDbpy/PhP0BtNmxyubvIuZSO3j1YRcRy4fbY/24fvlMw8fGBnqwkv4jaopMCYFqdABXC0TK2EXMLG9jLrXTEOxqNIg57IiYInNCoCLW4bfN5UuYS+20PD+qBXt4I3RwJhW2lP3F/1hCZhK2fMjlS1hatbH01qY+nczYRdxd/I5ENIg7Y/0tz9hlJwQqvVXAzecbbR/frm3s4e7iHhLRoLI3c9QnBIrXBqziJLNZ5v1RlBkoygwUZQaKMgNFmYGizEBRZqAoM1CUGSjKDBRlBooylVBfFI7NnCqo96j8E5kpReMzpwLqPYDx1PTIr9T0yDw8giUb6gCJfKKK9VjyPJiTCWWjDomUmh55BGBB4lyYkwXVFImUmh6ZhMZYMqAI0junB+qMJRqKGomkK5ZIKGYkko5YoqDaRiLphiUCyjUSSScs3lDckEi6YPGE4o5E0gGLF5QwJJJqLF5QQpFIKrF4QE3JQCKpwnILNVV9USu1KtZLmWO6gVKCVNMkKqcRUmoXSjUSqi+wxyEJqx0o5UgkmVisUNogkWRhsUBph0SSgUULpS0SSTQWDZT2SCSRWE5QnkEiicJqBbXgNSSSCKxmUAvVu1/PxhurEZTnkUg8seqhTgwSiRdWLdSJQyLVYLX9xhACdWKRSFWsCVQOGdkbffJpuFwuo1M+2v15/wPdmpDUltAwdgAAAABJRU5ErkJggg==">
													</div>';
									}
								$outputHorz .='<li>
								<label>
								<input type="radio" name="plan_id" value="'.get_the_ID().'" />
								<span>'.get_the_title().'</span>
								</label>
									
									<div class="per_user_per_listing_price">';

										if(!empty($post_price)){
														if($withtaxprice=="1"){
															$taxrate = $listingpro_options['lp_tax_amount'];
															$taxprice = (float)(($taxrate/100)*$post_price);
															$post_price = (float)$post_price + (float)$taxprice;
														}
														$lp_currency_position = $listingpro_options['pricingplan_currency_position'];
														if(isset($lp_currency_position) && $lp_currency_position=="left"){
															$outputHorz .='<span>'.listingpro_currency_sign().$post_price.'</span>';
														}
														else{
															$outputHorz .='<span>'.$post_price.listingpro_currency_sign().'</span>';
														}
													}
													else{
														$outputHorz .='<span>'.esc_html__("Free", "listingpro-plugin").'</span>';
													}

													$outputHorz .='<p>/ '.$plan_text.'</p>';

									$outputHorz.='</div>
									</li>';

$outputHorz .='<div class="lp-list-form-outer-postion"><ul class="lp-listprc">
											<li>
												<span class="icon-text">
													<i class="awesome_plan_icon_check fa fa-check-circle"></i>
												</span>';
												$outputHorz .= '<span>';
												if( !empty($plan_time) ){
													$outputHorz .= esc_html__('Duration', 'listingpro-plugin').' : '.$plan_time.' '.esc_html__('days', 'listingpro-plugin');
												}
												else{
													$outputHorz .= esc_html__('Duration', 'listingpro-plugin');
													$outputHorz .= esc_html__(' : Unlimited days', 'listingpro-plugin');
												}
												$outputHorz .= '</span>';
												$outputHorz .= '<div class="tooltip_price_features">
															<span><i class="fa fa-question"></i></span>
															<p class="lp_tooltip_text">Lorem ipsum dolor sit amet, lorem sit.</p>
															</div>';
												$outputHorz .='</li>';
												
												if(!empty($posts_allowed_in_plan) && $plan_type=="Package"){
													$outputHorz .='<li>';
													$outputHorz .='<span class="icon-text">'.listingpro_fontawesome_icon('checked').'</span>';
													$outputHorz .= '<span>'.esc_html__('Max. Listings : ', 'listingpro-plugin'). $posts_allowed_in_plan.'</span>';
													$outputHorz .='</li>';
												}
											
												if(empty($posts_allowed_in_plan) && $plan_type=="Package"){
													$outputHorz .='<li>';
													$outputHorz .='<span class="icon-text">'.listingpro_fontawesome_icon('checked').'</span>';
													$outputHorz .= '<span>'.esc_html__('Max. Listings : Unlimited', 'listingpro-plugin').'</span>';
													$outputHorz .='</li>';
												}
											
											if($listingpro_options['lp_showhide_address']=="1"){
												$outputHorz .='
												<li>
													<span class="icon icons8-Cancel">'.listingpro_fontawesome_icon($map_checked).'</span>
													<span>'.esc_html__('Map Display', 'listingpro-plugin').'</span>
												</li>';
											}
											if($listingpro_options['phone_switch']=="1"){
												$outputHorz .='
														<li>
															<span class="icon icons8-Cancel">'.listingpro_fontawesome_icon($contact_checked).'</span>
															<span>'.esc_html__('Contact Display', 'listingpro-plugin').'</span>
														</li>
														';
											}
											if($listingpro_options['file_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon icons8-Cancel">'.listingpro_fontawesome_icon($gallery_checked).'</span>
														<span>'.esc_html__('Image Gallery', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['vdo_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon icons8-Cancel">'.listingpro_fontawesome_icon($video_checked).'</span>
														<span>'.esc_html__('Video', 'listingpro-plugin').'</span>
													</li>
													';
											}
											$outputHorz .='
											<li>
												<span class="icon-text">'.listingpro_fontawesome_icon($tagline_checked).'</span>
												<span>'.esc_html__('Business Tagline', 'listingpro-plugin').'</span>
											</li>
											';
											if($listingpro_options['location_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon-text">'.listingpro_fontawesome_icon($location_checked).'</span>
														<span>'.esc_html__('Location', 'listingpro-plugin').'</span>
													</li>';
											}
											if($listingpro_options['web_switch']=="1"){
												$outputHorz .='
												<li>
													<span class="icon-text">'.listingpro_fontawesome_icon($website_checked).'</span>
													<span>'.esc_html__('Website', 'listingpro-plugin').'</span>
												</li>';
												
											}
											
											if($listingpro_options['listin_social_switch']=="1"){
												$outputHorz .='
												<li>
													<span class="icon-text">'.listingpro_fontawesome_icon($social_checked).'</span>
													<span>'.esc_html__('Social Links', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['faq_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon-text">'.listingpro_fontawesome_icon($faq_checked).'</span>
														<span>'.esc_html__('FAQ', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['currency_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon-text">'.listingpro_fontawesome_icon($price_checked).'</span>
														<span>'.esc_html__('Price Range', 'listingpro-plugin').'</span>
													</li>
													';
											}
											
											if($listingpro_options['tags_switch']=="1"){
												$outputHorz .='
													<li>
														<span class="icon-text">'.listingpro_fontawesome_icon($tag_key_checked).'</span>
														<span>'.esc_html__('Tags/Keywords', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['oph_switch']=="1"){
												$outputHorz .='		
												<li>
													<span class="icon-text">'.listingpro_fontawesome_icon($bhours_checked).'</span>
													<span>'.esc_html__('Business Hours', 'listingpro-plugin').'</span>
												</li>
												';
											}
											$lp_plan_more_fields = listing_get_metabox_by_ID('lp_price_plan_addmore',get_the_ID());
											if(!empty($lp_plan_more_fields)){
												foreach($lp_plan_more_fields as $morefield){
													if(!empty($morefield)){
														$outputHorz .='<li>
															<span class="icon-text">'.listingpro_fontawesome_icon('checked').'</span>
															<span>'.$morefield.'</span>
														</li>';
													}
												}
											}
											$outputHorz .='
										</ul>

										<form  enctype="multipart/form-data" method="post" action="'.listingpro_url('submit-listing').'" class="price-plan-button horizontial_view_width">
										<input type="hidden" name="plan_id" value="'.get_the_ID().'"/>';
										
										if( !empty($plan_package_type) && $plan_package_type=="Package" ){
											$plan_price = get_post_meta(get_the_ID(), 'plan_price', true);
											if(!empty($plan_price)){
											
												if(!empty($plan_limit_left)){
													
												
													$outputHorz .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover lp-secondary-choose" type="submit" value="'.esc_html__('CHOOSE PLAN', 'listingpro-plugin').'" name="submit">';
												}
												else{
													$outputHorz .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover lp-secondary-choose" type="submit" value="'.esc_html__('CHOOSE PLAN', 'listingpro-plugin').'" name="submit">';
												}
											}
											else{
												$outputHorz .='<p>A <strong>'.esc_html__("Package",'listingpro-plugin').'</strong>'.esc_html__(" should have a price ",'listingpro-plugin').'</p>';
											}
										}
										
										else{
											$outputHorz .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover lp-secondary-choose" type="submit" value="'.esc_html__('CHOOSE PLAN', 'listingpro-plugin').'" name="submit">';
										}
										
										$outputHorz .= wp_nonce_field( 'price_nonce', 'price_nonce_field'.$post->ID ,true, false );
										$outputHorz .='
									</form>
									<input class="lp-secondary-btn btn-second-hover lp-secondary-choose lp-claim-plan-btn" type="submit" value="'.esc_html__('CHOOSE PLAN', 'listingpro-plugin').'" name="submit" style="display:none;">
									</div>

								</ul>';

								$outputHorz .='';
								
								

							$outputHorz .='</div>';
							
	echo $outputHorz;
?>