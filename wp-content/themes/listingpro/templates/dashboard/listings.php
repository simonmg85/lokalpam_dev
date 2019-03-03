<div class="tab-pane fade in active" id="lp-listings">

<?php
		global $paged, $wp_query, $listingpro_options;
			$pendingArrayIds = array();
			$publishArrayIds = array();
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
			$checkoutURl = lp_theme_option('payment-checkout');
			$checkoutURl = get_permalink( $checkoutURl );
			$args=array(
				'post_type' => 'listing',
				'post_status' => array( 'publish', 'pending', 'expired'),
				'posts_per_page' => 12,
				'author' => $user_id,
				'paged' => $paged,
			);
			$deafaultFeatImg = lp_default_featured_image_listing();
			$listings_query = null;
			$listings_query = new WP_Query($args);
			
			global $wp_rewrite;
			$edit_post = '';
            $edit_post_page_id = $listingpro_options['edit-listing'];
            //$postID = $post->ID;

			$lpfound_posts = $listings_query->post_count;
			/* to dispaly popups outside of tabs */
			if(!empty($lpfound_posts)){
				if( $listings_query->have_posts() ) {
					while ($listings_query->have_posts()) : $listings_query->the_post();
						$postID = get_the_ID();
						?>
							<div class="md-modal md-effect-3" id="modal-<?php echo esc_attr($postID); ?>">
								<div class="md-content">
									<form class="form-horizontal"  method="post">
										<div class="form-group mr-bottom-0">
											<h3><?php echo esc_html__( 'Are you sure you want to delete this?', 'listingpro' ); ?></h3>
											<a href="#" class="md-close" data-postid="<?php echo esc_attr($postID); ?>">
												<?php echo esc_html__( 'No', 'listingpro' ); ?>
											</a>
											<input type="submit" value="<?php echo esc_html__( 'Yes', 'listingpro' ); ?>" class="lp-review-btn btn-second-hover">
											<input name="removeid" type="hidden" value="<?php echo esc_attr($postID); ?>" />
										</div>
									</form>	
								</div>
							</div>	
						<?php
					endwhile;	
				}
				
			}
			/* ends here */
?>
	
				<div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-9 lp-left-panel-height">
					<?php
						if(!empty($lpfound_posts)){
					?>
							<div class="panel-heading">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab1default" data-toggle="tab"><?php echo esc_html__('all', 'listingpro'); ?></a></li>
										<li><a href="#tab2default" data-toggle="tab"><?php echo esc_html__('published', 'listingpro'); ?></a></li>
										<li><a href="#tab3default" data-toggle="tab"><?php echo esc_html__('pending', 'listingpro'); ?></a></li>
										<li><a href="#tab4default" data-toggle="tab"><?php echo esc_html__('expired', 'listingpro'); ?></a></li>
									   
									</ul>
							</div>
							<div class="panel-body">
								<div class="lp-main-title clearfix">
									<div class="col-md-6 lp-first-title"><p><?php esc_html_e('title','listingpro'); ?></p></div>
									<div class="col-md-2"><p><?php esc_html_e('expiry','listingpro'); ?></p></div>
									<div class="col-md-4"><p><?php esc_html_e('status','listingpro'); ?></p></div>
								</div>
								<div class="tab-content clearfix">
									<div class="tab-pane fade in active" id="tab1default">
										<?php
										if( $listings_query->have_posts() ) {
											while ($listings_query->have_posts()) : $listings_query->the_post();
												$postID = get_the_ID();
												if ($wp_rewrite->permalink_structure == ''){
													//we are using ?page_id
													$edit_post = $edit_post_page_id."&lp_post=".$postID;
												}else{
													//we are using permalinks
													$edit_post = $edit_post_page_id."?lp_post=".$postID;
												}
												$listing_status = get_post_status(get_the_ID());
												$expiry = esc_html__('Unlimited', 'listingpro');
												$plan_id = listing_get_metabox('Plan_id');
												$showpaybutton = false;
												if(!empty($plan_id)){
                                                    $plan_duration = get_post_meta($plan_id, 'plan_time', true);
                                                    if(!empty($plan_duration)){
                                                        
                                                        $startdate = get_the_time('Y-m-d');
														$endDate = date('Y-m-d', strtotime($startdate. ' + '.$plan_duration.' days'));
														$diff = (strtotime($endDate) - time()) / 60 / 60 / 24;

                                                        if ($diff < 1 && $diff > 0) {
                                                            $days = 1;
                                                        } else {
                                                            $days = floor($diff);
                                                        }
                                                        
                                                        $expiry = $days.' '.esc_html__('Days', 'listingpro');
                                                    }
                                                }
												$table = 'listing_orders';
												$data = '*';
												global $wpdb;
												$dbprefix = $wpdb->prefix;
												$ftablename = 'listing_orders';
												$ftablename =$dbprefix.$ftablename;
												$plan_price = get_post_meta($plan_id, 'plan_price', true);
												$checkIfpurchasedandpending = lp_if_listing_in_purchased_package($plan_id, $postID);
												$listing_payment_status = '';
												$condition = 'post_id="'.$postID.'" AND plan_id="'.$plan_id.'" AND status="success"';
															if($wpdb->get_var("SHOW TABLES LIKE '$ftablename'") == $ftablename) {
																$listing_payment_status = lp_get_data_from_db($table, $data, $condition);
															}
												$condition2 = 'post_id="'.$postID.'" AND plan_id="'.$plan_id.'" AND payment_method="wire" AND status="pending"';
															if($wpdb->get_var("SHOW TABLES LIKE '$ftablename'") == $ftablename) {
																$paid_with_wire = lp_get_data_from_db($table, $data, $condition2);
															}
												
												if($listing_status=="pending" && !empty($plan_price) && empty($checkIfpurchasedandpending) && empty($listing_payment_status) && empty($paid_with_wire)){
													$showpaybutton = true;
												}
												
											?>
												<div class="lp-listing-outer-container clearfix ">
													<div class="col-md-6 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
														<div class="lp-listing-image-section">
															
															<div class="lp-image-container">
																<?php
																	if ( has_post_thumbnail()) {
																		$imageAlt = lp_get_the_post_thumbnail_alt(get_the_ID());
																		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'thumbnail' );
																	?>
																		<img src="<?php echo $image[0]; ?>" />
																	<?php }elseif(!empty($deafaultFeatImg)){ ?>
																		<img src="<?php echo $deafaultFeatImg; ?>" />
																	<?php }else{ ?>
																		<img src="<?php echo esc_url('https://placeholdit.imgix.net/~text?txtsize=62&txt=50%C3%97150&w=62&h=50');?>" />
																	<?php } ?>
															</div>
															<div class="lp-left-content-container">
																<a class="lp-cat-name-first" href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
																<?php
																	$category_image = '';
																	$cats = get_the_terms( get_the_ID(), 'listing-category' );
																	if(!empty($cats)){
																		$cat = $cats[0];
																		$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																		if(!empty($category_image)){
																			$category_image = '<img class="icon icons8-Food" src="'.esc_attr($category_image).'">';
																		}
																?>
																	<a href="<?php echo get_term_link($cat); ?>"> <?php echo $category_image; ?> <?php echo $cat->name; ?></a>
																	<?php 
																	}
																?>
															</div>
															
														</div>
													</div>
													<div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Expiry','listingpro'); ?>">
														
														<div class="lp-listing-expire-section">
															<p><?php echo $expiry; ?></p>
														</div>	
													</div>
													<div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
														
														<div class="lp-status-container pull-left">
															<?php
																if($listing_status=="pending"){
																	$pendingArrayIds[get_the_ID()] = get_the_ID();
															?>
																	<span><img src="<?php echo listingpro_icons_url('plan_pending'); ?>"></span>
															<?php
																}elseif($listing_status=="publish"){
																	$publishArrayIds[get_the_ID()] = get_the_ID();
															?>
																	<span><i class="fa fa-check" aria-hidden="true"></i></span>
															<?php
																}
																
																if($listing_status == 'publish'){
																	$listing_status = esc_html__('Published','listingpro');
																}elseif($listing_status == 'pending'){
																	$listing_status = esc_html__('Pending','listingpro');
																}elseif($listing_status == 'expired'){
																	$listing_status = esc_html__('Expired','listingpro');
																}
															?>
															<p><?php echo $listing_status; ?></p>
														</div>
														<div class="pull-right">
															<div class="clearfix">
																<div class="pull-right">
																	<div class="lp-dot-extra-buttons">
																		<img src="<?php echo listingpro_icons_url('lp_menu_drop'); ?>">
																		<ul class="lp-user-menu list-style-none">
																				<li><a target="_blank" href="<?php echo esc_url($edit_post); ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__('Edit', 'listingpro'); ?></span></span></a></li>
																				<li><a href="#" data-modal="modal-<?php echo esc_attr($postID); ?>" class="md-trigger"><i class="fa fa-times"></i><span><?php echo esc_html__('Remove', 'listingpro'); ?></span></a></li>
																				<li>
																					
																					<?php 
																						global $post;
																						echo listingpro_change_plan_button($post, get_the_ID()); 
																					?>
																				</li>
																		</ul>
																	</div>
																</div>
																<?php if(!empty($showpaybutton)){ ?>
																	<div class="lp-listing-pay-outer pull-right">
																		<a href="<?php echo esc_attr($checkoutURl); ?>" class="lp-listing-pay-button" data-lpthisid="<?php echo  $postID; ?>"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span> <?php esc_html_e('Pay','listingpro'); ?></a>
																	</div>
																<?php
																}
																?>
																
															</div>
														</div>
													</div>
												</div>
												
								
											<?php						
											endwhile;
											echo listingpro_pagination($listings_query);
										}
										?>
										
									</div>
									<div class="tab-pane fade" id="tab2default">
										<?php
											$args=array(
												'post_type' => 'listing',
												'post_status' => 'publish',
												'posts_per_page' => 12,
												'author' => $user_id,
												'post__in' => $publishArrayIds,
											);
											$plistings_query = null;
											$plistings_query = new WP_Query($args);
										?>
										<?php
										if( $plistings_query->have_posts() ) {
											while ($plistings_query->have_posts()) : $plistings_query->the_post();
												$listing_status = get_post_status(get_the_ID());
												$expiry = esc_html__('Unlimited', 'listingpro');
												$plan_id = listing_get_metabox('Plan_id');
												if(!empty($plan_id)){
                                                    $plan_duration = get_post_meta($plan_id, 'plan_time', true);
                                                    if(!empty($plan_duration)){
                                                        
                                                        $startdate = get_the_time('Y-m-d');
														$endDate = date('Y-m-d', strtotime($startdate. ' + '.$plan_duration.' days'));
														$diff = (strtotime($endDate) - time()) / 60 / 60 / 24;

                                                        if ($diff < 1 && $diff > 0) {
                                                            $days = 1;
                                                        } else {
                                                            $days = floor($diff);
                                                        }
                                                        
                                                        $expiry = $days.' '.esc_html__('Days', 'listingpro');
                                                    }
                                                }
											?>
												<div class="lp-listing-outer-container clearfix ">
													<div class="col-md-6 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
														<div class="lp-listing-image-section">
															
															<div class="lp-image-container">
																<?php
																	if ( has_post_thumbnail()) {
																		$imageAlt = lp_get_the_post_thumbnail_alt(get_the_ID());
																		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'thumbnail' );
																	?>
																		<img src="<?php echo $image[0]; ?>" />
																	<?php }elseif(!empty($deafaultFeatImg)){ ?>
																		<img src="<?php echo $deafaultFeatImg; ?>" />
																	<?php }else{ ?>
																		<img src="<?php echo esc_url('https://placeholdit.imgix.net/~text?txtsize=62&txt=50%C3%97150&w=62&h=50');?>" />
																	<?php } ?>
															</div>
															<div class="lp-left-content-container">
																<a class="lp-cat-name-first" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
																<?php
																	$category_image = '';
																	$cats = get_the_terms( get_the_ID(), 'listing-category' );
																	if(!empty($cats)){
																		$cat = $cats[0];
																		$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																		if(!empty($category_image)){
																			$category_image = '<img class="icon icons8-Food" src="'.esc_attr($category_image).'">';
																		}
																?>
																	<a href="<?php echo get_term_link($cat); ?>"> <?php echo $category_image; ?> <?php echo $cat->name; ?></a>
																	<?php 
																	}
																?>
															</div>
															
														</div>
													</div>
													<div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Expiry','listingpro'); ?>">
														
														<div class="lp-listing-expire-section">
															<p><?php echo $expiry; ?></p>
														</div>	
													</div>
													<div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
														
														<div class="lp-status-container pull-left">
															<span><i class="fa fa-check" aria-hidden="true"></i></span>
															<p><?php echo $listing_status; ?></p>
														</div>
														<div class="pull-right">
															<div class="clearfix">
																<div class="pull-right">
																	<div class="lp-dot-extra-buttons">
																		<img src="<?php echo listingpro_icons_url('lp_menu_drop'); ?>">
																		<ul class="lp-user-menu list-style-none">
																				<li><a target="_blank" href="<?php echo esc_url($edit_post); ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__('Edit', 'listingpro'); ?></span></span></a></li>
																				<li><a href="#" data-modal="modal-<?php echo esc_attr($postID); ?>" class="md-trigger"><i class="fa fa-times"></i><span><?php echo esc_html__('Remove', 'listingpro'); ?></span></a></li>
																				<li>
																					
																					<?php 
																						global $post;
																						echo listingpro_change_plan_button($post, get_the_ID()); 
																					?>
																				</li>
																		</ul>
																	</div>
																</div>
																
															</div>
														</div>
													</div>
												</div>
												

												
											<?php						
											endwhile;
											echo listingpro_pagination($plistings_query);
										}
										?>
									</div>
									<div class="tab-pane fade" id="tab3default">
										<?php
											$args=array(
												'post_type' => 'listing',
												'post_status' => 'pending',
												'posts_per_page' => 12,
												'author' => $user_id,
												'post__in' => $pendingArrayIds,
											);
											$pnlistings_query = null;
											$pnlistings_query = new WP_Query($args);
										?>
										<?php
										if( $pnlistings_query->have_posts() ) {
											while ($pnlistings_query->have_posts()) : $pnlistings_query->the_post();
												$postID = get_the_ID();
												if ($wp_rewrite->permalink_structure == ''){
													//we are using ?page_id
													$edit_post = $edit_post_page_id."&lp_post=".$postID;
												}else{
													//we are using permalinks
													$edit_post = $edit_post_page_id."?lp_post=".$postID;
												}
												$listing_status = get_post_status(get_the_ID());
												$expiry = esc_html__('Unlimited', 'listingpro');
												$plan_id = listing_get_metabox('Plan_id');
												$showpaybutton = false;
												if(!empty($plan_id)){
                                                    $plan_duration = get_post_meta($plan_id, 'plan_time', true);
                                                    if(!empty($plan_duration)){
                                                        
                                                        $startdate = get_the_time('Y-m-d');
														$endDate = date('Y-m-d', strtotime($startdate. ' + '.$plan_duration.' days'));
														$diff = (strtotime($endDate) - time()) / 60 / 60 / 24;

                                                        if ($diff < 1 && $diff > 0) {
                                                            $days = 1;
                                                        } else {
                                                            $days = floor($diff);
                                                        }
                                                        
                                                        $expiry = $days.' '.esc_html__('Days', 'listingpro');
                                                    }
                                                }
												$table = 'listing_orders';
												$data = '*';
												global $wpdb;
												$dbprefix = $wpdb->prefix;
												$ftablename = 'listing_orders';
												$ftablename =$dbprefix.$ftablename;
												$plan_price = get_post_meta($plan_id, 'plan_price', true);
												$checkIfpurchasedandpending = lp_if_listing_in_purchased_package($plan_id, $postID);
												$listing_payment_status = '';
												$condition = 'post_id="'.$postID.'" AND plan_id="'.$plan_id.'" AND status="success"';
															if($wpdb->get_var("SHOW TABLES LIKE '$ftablename'") == $ftablename) {
																$listing_payment_status = lp_get_data_from_db($table, $data, $condition);
															}
												
												$condition2 = 'post_id="'.$postID.'" AND plan_id="'.$plan_id.'" AND payment_method="wire" AND status="pending"';
															if($wpdb->get_var("SHOW TABLES LIKE '$ftablename'") == $ftablename) {
																$paid_with_wire = lp_get_data_from_db($table, $data, $condition2);
															}
												
												if($listing_status=="pending" && !empty($plan_price) && empty($checkIfpurchasedandpending) && empty($listing_payment_status) && empty($paid_with_wire)){
													$showpaybutton = true;
												}
											?>
												<div class="lp-listing-outer-container clearfix ">
													<div class="col-md-6 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
														<div class="lp-listing-image-section">
															
															<div class="lp-image-container">
																<?php
																	if ( has_post_thumbnail()) {
																		$imageAlt = lp_get_the_post_thumbnail_alt(get_the_ID());
																		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'thumbnail' );
																	?>
																		<img src="<?php echo $image[0]; ?>" />
																	<?php }elseif(!empty($deafaultFeatImg)){ ?>
																		<img src="<?php echo $deafaultFeatImg; ?>" />
																	<?php }else{ ?>
																		<img src="<?php echo esc_url('https://placeholdit.imgix.net/~text?txtsize=62&txt=50%C3%97150&w=62&h=50');?>" />
																	<?php } ?>
															</div>
															<div class="lp-left-content-container">
																<a class="lp-cat-name-first" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
																<?php
																	$category_image = '';
																	$cats = get_the_terms( get_the_ID(), 'listing-category' );
																	if(!empty($cats)){
																		$cat = $cats[0];
																		$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																		if(!empty($category_image)){
																			$category_image = '<img class="icon icons8-Food" src="'.esc_attr($category_image).'">';
																		}
																?>
																	<a href="<?php echo get_term_link($cat); ?>"> <?php echo $category_image; ?> <?php echo $cat->name; ?></a>
																	<?php 
																	}
																?>
															</div>
															
														</div>
													</div>
													<div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Expiry','listingpro'); ?>">
														
														<div class="lp-listing-expire-section">
															<p><?php echo $expiry; ?></p>
														</div>	
													</div>
													<div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
														
														<div class="lp-status-container pull-left">
															<span><img src="<?php echo listingpro_icons_url('plan_pending'); ?>"></span>
															<p><?php echo $listing_status; ?></p>
														</div>
														<div class="pull-right">
															<div class="clearfix">
																<div class="pull-right">
																	<div class="lp-dot-extra-buttons">
																		<img src="<?php echo listingpro_icons_url('lp_menu_drop'); ?>">
																		<ul class="lp-user-menu list-style-none">
																				<li><a target="_blank" href="<?php echo esc_url($edit_post); ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__('Edit', 'listingpro'); ?></span></span></a></li>
																				<li><a href="#" data-modal="modal-<?php echo esc_attr($postID); ?>" class="md-trigger"><i class="fa fa-times"></i><span><?php echo esc_html__('Remove', 'listingpro'); ?></span></a></li>
																				<li>
																					
																					<?php 
																						global $post;
																						echo listingpro_change_plan_button($post, get_the_ID()); 
																					?>
																				</li>
																		</ul>
																	</div>
																</div>
																<?php if(!empty($showpaybutton)){ ?>
																	<div class="lp-listing-pay-outer pull-right">
																		<a href="<?php echo esc_attr($checkoutURl); ?>" class="lp-listing-pay-button" data-lpthisid="<?php echo  $postID; ?>"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span> <?php esc_html_e('Pay','listingpro'); ?></a>
																	</div>
																<?php
																}
																?>
																
															</div>
														</div>
													</div>
												</div>
												

												
											<?php						
											endwhile;
											echo listingpro_pagination($pnlistings_query);
										}
										?>
									
									</div>
									
									
									<div class="tab-pane fade" id="tab4default">
										<?php
											$args=array(
												'post_type' => 'listing',
												'post_status' => 'expired',
												'posts_per_page' => 12,
												'author' => $user_id,
											);
											$pnlistings_query = null;
											$pnlistings_query = new WP_Query($args);
										?>
										<?php
										if( $pnlistings_query->have_posts() ) {
											while ($pnlistings_query->have_posts()) : $pnlistings_query->the_post();
												$listing_status = get_post_status(get_the_ID());
												$expiry = esc_html__('Unlimited', 'listingpro');
												$plan_id = listing_get_metabox('Plan_id');
												$showpaybutton = false;
												if(!empty($plan_id)){
													$plan_duration = get_post_meta($plan_id, 'plan_time', true);
													if(!empty($plan_duration)){
														$expiry = $plan_duration.' '.esc_html__('Days', 'listingpro');
													}
												}
												$table = 'listing_orders';
												$data = '*';
												global $wpdb;
												$dbprefix = $wpdb->prefix;
												$ftablename = 'listing_orders';
												$ftablename =$dbprefix.$ftablename;
												$plan_price = get_post_meta($plan_id, 'plan_price', true);
												$checkIfpurchasedandpending = lp_if_listing_in_purchased_package($plan_id, $postID);
												$listing_payment_status = '';
												$condition = 'post_id="'.$postID.'" AND plan_id="'.$plan_id.'" AND status="success"';
															if($wpdb->get_var("SHOW TABLES LIKE '$ftablename'") == $ftablename) {
																$listing_payment_status = lp_get_data_from_db($table, $data, $condition);
															}
												
												if($listing_status=="pending" && !empty($plan_price) && empty($checkIfpurchasedandpending) && empty($listing_payment_status)){
													$showpaybutton = true;
												}
											?>
												<div class="lp-listing-outer-container clearfix ">
													<div class="col-md-6 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
														<div class="lp-listing-image-section">
															
															<div class="lp-image-container">
																<?php
																	if ( has_post_thumbnail()) {
																		$imageAlt = lp_get_the_post_thumbnail_alt(get_the_ID());
																		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'thumbnail' );
																	?>
																		<img src="<?php echo $image[0]; ?>" />
																	<?php }elseif(!empty($deafaultFeatImg)){ ?>
																		<img src="<?php echo $deafaultFeatImg; ?>" />
																	<?php }else{ ?>
																		<img src="<?php echo esc_url('https://placeholdit.imgix.net/~text?txtsize=62&txt=50%C3%97150&w=62&h=50');?>" />
																	<?php } ?>
															</div>
															<div class="lp-left-content-container">
																<a class="lp-cat-name-first" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
																<?php
																	$category_image = '';
																	$cats = get_the_terms( get_the_ID(), 'listing-category' );
																	if(!empty($cats)){
																		$cat = $cats[0];
																		$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																		if(!empty($category_image)){
																			$category_image = '<img class="icon icons8-Food" src="'.esc_attr($category_image).'">';
																		}
																?>
																	<a href="<?php echo get_term_link($cat); ?>"> <?php echo $category_image; ?> <?php echo $cat->name; ?></a>
																	<?php 
																	}
																?>
															</div>
															
														</div>
													</div>
													<div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Expiry','listingpro'); ?>">
														
														<div class="lp-listing-expire-section">
															
														</div>	
													</div>
													<div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
														
														<div class="lp-status-container pull-left">
															<span><img src="<?php echo listingpro_icons_url('plan_pending'); ?>"></span>
															<p><?php echo $listing_status; ?></p>
														</div>
														<div class="pull-right">
															<div class="clearfix">
																<div class="pull-right">
																	<div class="lp-dot-extra-buttons">
																		<img src="<?php echo listingpro_icons_url('lp_menu_drop'); ?>">
																		<ul class="lp-user-menu list-style-none">
																				<li><a target="_blank" href="<?php echo esc_url($edit_post); ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__('Edit', 'listingpro'); ?></span></span></a></li>
																				<li><a href="#" data-modal="modal-<?php echo esc_attr($postID); ?>" class="md-trigger"><i class="fa fa-times"></i><span><?php echo esc_html__('Remove', 'listingpro'); ?></span></a></li>
																				<li>
																					
																					<?php 
																						global $post;
																						echo listingpro_change_plan_button($post, get_the_ID()); 
																					?>
																				</li>
																		</ul>
																	</div>
																</div>
																<?php if(!empty($showpaybutton)){ ?>
																	<div class="lp-listing-pay-outer pull-right">
																		<a href="<?php echo esc_attr($checkoutURl); ?>" class="lp-listing-pay-button" data-lpthisid="<?php echo  $postID; ?>"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span> <?php esc_html_e('Pay','listingpro'); ?></a>
																	</div>
																<?php
																}
																?>
																
															</div>
														</div>
													</div>
												</div>
												
	
												
											<?php						
											endwhile;
											echo listingpro_pagination($pnlistings_query);
										}
										?>
									
									</div>
									
									
									
								</div>
							</div>
					<?php } else{ ?>
								
								<div class="lp-blank-section">
									<div class="col-md-9 blank-left-side">
										<img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
										<h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
					<p><?php echo esc_html__('You must be here for the first time. If you like to add some thing, click the button below.', 'listingpro'); ?></p>
									</div>
									<div class="col-md-3 blank-right-side">
										<img src="<?php echo listingpro_icons_url('lp_blank_right_quote'); ?>">
										<p><?php echo esc_html__('"Your time is limited, so dont waste it living someone elses life."', 'listingpro'); ?><strong><?php echo esc_html__('-Steve Jobs-', 'listingpro'); ?></strong></p>
									</div>
								</div>
								
					<?php }?>
				</div>
<?php
$lpalertsRatings = getAllReviewsArray(false);
$lptotalClicks = lp_get_total_ads_clicks();
set_query_var( 'lptotalClicks', $lptotalClicks );
if( !empty($lpalertsRatings) || !empty($lptotalClicks) ){
    ?>
    <div class="col-md-3 padding-right-0 lp-right-panel-height">
        <div class="lp-ad-click-outer">
            <?php
            if( !empty($lptotalClicks)){ ?>
                <div class="lp-general-section-title-outer">
                    <?php echo get_template_part('templates/dashboard/ads_state'); ?>
                </div>
                <?php
            }
            if( !empty($lpalertsRatings)){
                ?>

                <div class="lp-general-section-title-outer">
                    <p id="reply-title" class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__('Rating alerts', 'listingpro'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></p>
                    <div class="lp-ad-click-inner" id="lp-ad-click-inner">
                        <?php echo get_template_part('templates/dashboard/rating_alerts'); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}else{
	?>
	
	 <div class="col-md-3 padding-right-0 lp-right-panel-height">
        <div class="lp-ad-click-outer">
            <div class="lp-general-section-title-outer">
                    <p id="reply-title" class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__('Rating alerts', 'listingpro'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></p>
                    <div class="lp-ad-click-inner" id="lp-ad-click-inner">
                        <?php echo get_template_part('templates/dashboard/rating_alerts'); ?>
                    </div>
                </div>
        </div>
    </div>
	
	<?php
}
?>
	
</div>