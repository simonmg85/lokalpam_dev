<?php
	global $listingpro_options;
	$plan_id = listing_get_metabox_by_ID('Plan_id',$post->ID);
	if(!empty($plan_id)){
		$plan_id = $plan_id;
	}else{
		$plan_id = 'none';
	}
	$map_show = get_post_meta( $plan_id, 'map_show', true );
	$social_show = get_post_meta( $plan_id, 'listingproc_social', true );
	$location_show = get_post_meta( $plan_id, 'listingproc_location', true );
	$contact_show = get_post_meta( $plan_id, 'contact_show', true );
	$website_show = get_post_meta( $plan_id, 'listingproc_website', true );
	
	if($plan_id=="none"){
		$map_show = 'true';
		$social_show = 'true';
		$location_show = 'true';
		$contact_show = 'true';
		$website_show = 'true';
	}
	
	$facebook = listing_get_metabox('facebook');
	$twitter = listing_get_metabox('twitter');
	$linkedin = listing_get_metabox('linkedin');
	$google_plus = listing_get_metabox('google_plus');
	$youtube = listing_get_metabox('youtube');
	$instagram = listing_get_metabox('instagram');
	$phone = listing_get_metabox('phone');
	$website = listing_get_metabox('website');
	$gAddress = listing_get_metabox('gAddress');
	$latitude = listing_get_metabox('latitude');
	$longitude = listing_get_metabox('longitude');
	$whatsapp = listing_get_metabox('whatsapp');
?>

<?php
								
	if( !empty($latitude) || !empty($longitude) || !empty($gAddress) || !empty($phone) || !empty($website) ||  !empty($facebook) || !empty($twitter) || !empty($linkedin) || !empty($google_plus) || !empty($youtube) || !empty($instagram) ){
?>
		<div class="sidebar-post">
			<div class="widget-box map-area">
				<?php 
				if(!empty($latitude) && !empty($longitude)){
					if($map_show=="true"){
				?>
							<div class="widget-bg-color post-author-box lp-border-radius-5">
								<div class="widget-header margin-bottom-25 hideonmobile">
									<ul class="post-stat">
										<li>
											<a class="md-trigger parimary-link singlebigmaptrigger" data-lat="<?php echo esc_attr($latitude); ?>" data-lan="<?php echo esc_attr($longitude); ?>" data-modal="modal-4" >
												<!-- <span class="phone-icon">
													Marker icon by Icons8
													<?php echo listingpro_icons('mapMarker'); ?>
												</span>
												<span class="phone-number ">
													<?php echo esc_html__('View Large Map', 'listingpro'); ?>
												</span> -->
											</a>
										</li>
									</ul>
								</div>
								<?php
								$lp_map_pin = $listingpro_options['lp_map_pin']['url'];
								?>
								<div class="widget-content ">
									<div class="widget-map pos-relative">
										<div id="singlepostmap" class="singlemap" data-pinicon="<?php echo esc_attr($lp_map_pin); ?>"></div>
										<div class="get-directions">
											<a href="https://www.google.com/maps?daddr=<?php echo esc_attr($latitude); ?>,<?php echo esc_attr($longitude); ?>" target="_blank" >
												<span class="phone-icon">
													<i class="fa fa-map-o"></i>
												</span>
												<span class="phone-number ">
													<?php echo esc_html__('Get Directions', 'listingpro'); ?>
												</span>
											</a>
										</div>
									</div>
								</div>
							</div><!-- ../widget-box  -->
					<?php } ?>
				<?php } ?>
				<div class="listing-detail-infos margin-top-20 clearfix">
					<ul class="list-style-none list-st-img clearfix">
						<?php 
						
						$phone = listing_get_metabox('phone');
						$website = listing_get_metabox('website');
						//if(empty($facebook) && empty($twitter) && empty($linkedin)){}else{
							?>
							<?php if(!empty($gAddress)) { 
								if($location_show=="true"){?>
									<li>
										<a>
											<span class="cat-icon">
												<?php echo listingpro_icons('mapMarkerGrey'); ?>
												<!-- <i class="fa fa-map-marker"></i> -->
											</span>
											<span>
												<?php echo $gAddress ?>
											</span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>
							<?php if(!empty($phone) || !empty($whatsapp)) { ?>
								<?php if($contact_show=="true"){ ?>
									<li class="lp-listing-phone">
										<a data-lpID="<?php echo $post->ID; ?>" href="tel:<?php echo esc_attr($phone); ?>">
											<span class="cat-icon">
												<?php echo listingpro_icons('phone'); ?>
												<!-- <i class="fa fa-mobile"></i> -->
											</span>
											<span>
												<?php echo esc_html($phone); ?>
											</span>
										</a>
									</li>
									<?php
										$whatsappStatus = $listingpro_options['lp_detail_page_whatsapp_button'];
										$whatsappMsg = esc_html__('Hi, Contacting for you listing', 'listingpro');
										if($whatsappStatus=="on" && !empty($whatsapp)){
											
											$whatsappobj = "https://api.whatsapp.com/send?";
											$whatsappobj .= "phone=$whatsapp";
											$whatsappobj .= "&";
											$whatsappobj .= "text=$whatsappMsg";
									?>
											<li class="lp-listing-phone-whatsapp">
												<a href="<?php echo $whatsappobj; ?>" target="_blank">
													<span class="cat-icon">
														<i class="fa fa-whatsapp" aria-hidden="true"></i>
													</span>
													<span>
														<?php echo esc_html__('Call on Whatsapp', 'listingpro'); ?>
													</span>
												</a>
											</li>
									<?php
										}
									?>
									
								<?php } ?>
							<?php } ?>
							<?php if(!empty($website)) { 
									if($website_show=="true"){?>
										<li class="lp-user-web">
											<a data-lpID="<?php echo $post->ID; ?>" href="<?php echo esc_url($website); ?>" target="_blank" rel="nofollow">
												<span class="cat-icon">
													<?php echo listingpro_icons('globe'); ?>
													<!-- <i class="fa fa-globe"></i> -->
												</span>
												<span><?php echo esc_url($website); ?></span>
											</a>
										</li>
									<?php } ?>
							<?php } ?>
						<?php //} ?>
					</ul>
					<?php 
					$facebook = listing_get_metabox('facebook');
					$twitter = listing_get_metabox('twitter');
					$linkedin = listing_get_metabox('linkedin');
					$google_plus = listing_get_metabox('google_plus');
					$youtube = listing_get_metabox('youtube');
					$instagram = listing_get_metabox('instagram');
					if($social_show=="true"){
						if(empty($facebook) && empty($twitter) && empty($linkedin) && empty($google_plus) && empty($youtube) && empty($instagram)){}else{
							?>
							<div class="widget-box widget-social">
								<div class="widget-content clearfix">
									<ul class="list-style-none list-st-img">
										<?php if(!empty($facebook)){ ?>
											<li class="lp-fb">
												<a href="<?php echo esc_url($facebook); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-facebook"></i> -->
													<?php echo listingpro_icons('fb'); ?>
												</a>
											</li>
										<?php } ?>
										<?php if(!empty($twitter)){ ?>
											<li class="lp-tw">
												<a href="<?php echo esc_url($twitter); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-twitter"></i> -->
													<?php echo listingpro_icons('tw'); ?>
												</a>
											</li>
										<?php } ?>
										<?php if(!empty($linkedin)){ ?>
											<li  class="lp-li">
												<a href="<?php echo esc_url($linkedin); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-linkedin"></i> -->
													<?php echo listingpro_icons('lnk'); ?>
												</a>
											</li>
										<?php } ?>
										<?php if(!empty($google_plus)){ ?>
											<li  class="lp-li">
												<a href="<?php echo esc_url($google_plus); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-linkedin"></i> -->
													<?php echo listingpro_icons('gp'); ?>
												</a>
											</li>
										<?php } ?>
										<?php if(!empty($youtube)){ ?>
											<li  class="lp-li">
												<a href="<?php echo esc_url($youtube); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-linkedin"></i> -->
													<?php echo listingpro_icons('yt'); ?>
												</a>
											</li>
										<?php } ?>
										<?php if(!empty($instagram)){ ?>
											<li  class="lp-li">
												<a href="<?php echo esc_url($instagram); ?>" class="padding-left-0" target="_blank">
													<!-- <i class="fa fa-linkedin"></i> -->
													<?php echo listingpro_icons('insta'); ?>
												</a>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div><!-- ../widget-box  -->
						<?php } ?>
				<?php } ?>
				</div>
			</div>
		</div>
<?php } ?>
