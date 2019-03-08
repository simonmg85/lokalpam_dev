<?php
if(!function_exists('listingpro_get_reviews_form')){
	function listingpro_get_reviews_form($postid){
		if (class_exists('ListingReviews')) {

			global $listingpro_options;
			$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
			$lp_Reviews_OPT = $listingpro_options['lp_review_submit_options'];
			$gSiteKey = '';
			$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
			$enableCaptcha = lp_check_receptcha('lp_recaptcha_reviews');
            $privacy_policy = $listingpro_options['payment_terms_condition'];
            $privacy_review = $listingpro_options['listingpro_privacy_review'];

			$lp_images_count = '555';
			$lp_images_size = '999999999999999999999999999999999999999999999999999';
			$lp_imagecount_notice = '';
			$lp_imagesize_notice = '';
			if(lp_theme_option('lp_listing_reviews_images_count_switch')=='yes')
			{
				$lp_images_count = lp_theme_option('lp_listing_reviews_images_counter');
				$lp_imagecount_notice= esc_html__("Max. allowed images are ", 'listingpro');
				$lp_imagecount_notice .= $lp_images_count;
			}
			if(lp_theme_option('lp_listing_reviews_images_size_switch')=='yes'){
				$lp_images_size = lp_theme_option('lp_listing_reviews_images_sizes');
				$lp_imagesize_notice= esc_html__('Max. allowed images size is ', 'listingpro');
				$lp_imagesize_notice .= $lp_images_size. esc_html__(' Mb', 'listingpro');
				$lp_images_size = $lp_images_size * 1000000;
			}
			$enableUsernameField = lp_theme_option('lp_register_username');

            $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];
            if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )
            {
                $lp_multi_rating_fields_active	=	array();
                for ($x = 1; $x <= 5; $x++) {
                    $field_active   =   '';
                   if( isset($listingpro_options['lp_multi_ratiing'.$x.'_switch']) )
                   {
                       $field_active    =    $listingpro_options['lp_multi_ratiing'.$x.'_switch'];
                   }
                    if( $field_active == 1 )
                    {
                        
                        $field_active_label			=	$listingpro_options['lp_multi_ratiing'.$x.'_label_switch'];

                        $lp_multi_rating_fields_active['field'.$x]['label']			=	$field_active_label;
                        
				    }
			    }

            }
            $lp_detail_page_styles  =   $listingpro_options['lp_detail_page_styles'];
            $multi_col_class    =   'col-md-6';
            if( $lp_detail_page_styles == 'lp_detail_page_styles5' )
            {
                $multi_col_class    =   'col-md-3';
            }
			if( is_user_logged_in() )
			{

				?>
					<div class="review-form" id="review-section">
						<h3 id="reply-title" class="comment-reply-title"><i class="fa fa-star-o"></i> <?php esc_html_e('Rate us and Write a Review','listingpro'); ?> <i class="fa fa-caret-down"></i></h3>
						<form data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_form" name = "rewies_form" action = "" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">
							<?php
							if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )
							{
								echo '<div class="col-md-12 padding-left-0 lp-multi-rating-ui-wrap">';
								$lp_rating_field_counter	=	1;
								foreach( $lp_multi_rating_fields_active as $k => $lp_multi_rating_field )
								{
									?>
									<div class="<?php echo $multi_col_class; ?> padding-left-0">
										<div class="sfdfdf list-style-none form-review-stars">
											<p><?php echo $lp_multi_rating_field['label']; ?></p>
											<input type="hidden" data-mrf="<?php echo $k; ?>" id="review-rating-<?php echo $k; ?>" name="rating-<?php echo $k; ?>" class="rating-tooltip lp-multi-rating-val" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
											<span class="label-start"><?php echo $lp_multi_rating_field['label_start']; ?></span><span class="label-end"><?php echo $lp_multi_rating_field['label_end']; ?></span>
										</div>
									</div>

									<?php
									$lp_rating_field_counter++;
								}
								echo '<div class="clearfix"></div>';
							?>
								<div class = "col-md-6 padding-left-0">
									<div class="form-group submit-images">
										<label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
										<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
										<input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<?php
							}
							?>


							<?php
							if( $lp_multi_rating_state == 0 )
							{
							?>
							<div class = "col-md-6 padding-left-0">
								<div class="form-group margin-bottom-40">
									<p class="padding-bottom-15"><?php esc_html_e('Your Rating for this listing','listingpro'); ?></p>
									<div class="sfdfdf list-style-none form-review-stars">
										<input type="hidden" id="review-rating" name="rating" class="rating-tooltip" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
										<div class="review-emoticons">
											<div class="review angry"><?php echo listingpro_icons('angry'); ?></div>
											<div class="review cry"><?php echo listingpro_icons('crying'); ?></div>
											<div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>
											<div class="review smily"><?php echo listingpro_icons('smily'); ?></div>
											<div class="review cool"><?php echo listingpro_icons('cool'); ?></div>
										</div>
									</div>
								</div>
							</div>

							<div class = "col-md-6 pull-right padding-right-0">
								<div class="form-group submit-images">
									<label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
									<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
									<input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
								</div>
							</div>
							<div class="clearfix"></div>
							<?php
							}
							?>

							<div class="form-group">
								<label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>
								<input placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" type = "text" id = "post_title" class="form-control" name = "post_title" />
							</div>
							<div class="form-group">
								<label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>
								<textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too!','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>
								<p><?php esc_html_e('Your review is recommended to be at least 140 characters long :)','listingpro'); ?></p>
							</div>
							<div class="form-group">
								<?php
									if($enableCaptcha==true){
										if ( class_exists( 'cridio_Recaptcha' ) ){
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
											echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}
									}
								?>
							</div>
							<?php
								if(!empty($privacy_policy) && $privacy_review=="yes"){
							?>
									<div class="form-group lp_privacy_policy_Wrap">
										<input class="lpprivacycheckboxopt" id="reviewpolicycheck" type="checkbox" name="reviewpolicycheck" value="true">
												<label for="reviewpolicycheck"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
											<div class="help-text">
												<a class="help" target="_blank"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this review?', 'listingpro'); ?></p>
												</div>
											</div>
									</div>
									<p class="form-submit post-reletive">
										<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php esc_html_e('Submit Review','listingpro'); ?>" disabled>
										<input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
										<input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
										<span class="review_status"></span>
										<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
									</p>
							<?php
								}else{
							?>
								<p class="form-submit post-reletive">
									<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php esc_html_e('Submit Review','listingpro'); ?>">
									<input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
									<input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
									<span class="review_status"></span>
									<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
								</p>
							<?php
								}
							?>


						</form>
					</div>
				<?php
			}
			else
            {
            ?>
				<div class="review-form">
					<h3 id="reply-title" class="comment-reply-title"><i class="fa fa-star-o"></i><?php esc_html_e(' Rate us and Write a Review ','listingpro'); ?><i class="fa fa-caret-down"></i></h3>
					<?php
						if($lp_Reviews_OPT=="instant_sign_in"){
					?>
						<form data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_form" name = "rewies_form" action = "" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">
					<?php
						}
						else{
					?>
						<form class="reviewformwithnotice" data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_formm" name = "rewies_form" action = "#" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">
					<?php } ?>

						<?php
							if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )
							{
								echo '<div class="col-md-12 padding-left-0 lp-multi-rating-ui-wrap">';
								$lp_rating_field_counter	=	1;
								foreach( $lp_multi_rating_fields_active as $k => $lp_multi_rating_field )
								{
									?>
									<div class="<?php echo $multi_col_class; ?> padding-left-0">
										<div class="sfdfdf list-style-none form-review-stars">
											<p><?php echo $lp_multi_rating_field['label']; ?></p>
											<input type="hidden" data-mrf="<?php echo $k; ?>" id="review-rating-<?php echo $k; ?>" name="rating-<?php echo $k; ?>" class="rating-tooltip lp-multi-rating-val" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
											<span class="label-start"><?php echo $lp_multi_rating_field['label_start']; ?></span><span class="label-end"><?php echo $lp_multi_rating_field['label_end']; ?></span>
										</div>
									</div>

									<?php
									$lp_rating_field_counter++;
								}
								echo '<div class="clearfix"></div>';
							?>
								<div class = "col-md-6 padding-left-0">
									<div class="form-group submit-images">
										<label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
										<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
										<input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<?php
							}
							?>


							<?php
							if( $lp_multi_rating_state == 0 )
							{
							?>
						    <div class = "col-md-6 padding-left-0">
                                <div class="form-group margin-bottom-40">
                                    <p class="padding-bottom-15"><?php esc_html_e('Your Rating for this listing','listingpro'); ?></p>
                                    <input type="hidden" id="review-rating" name="rating" class="rating-tooltip" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
                                    <div class="review-emoticons">
                                        <div class="review angry"><?php echo listingpro_icons('angry'); ?></div>
                                        <div class="review cry"><?php echo listingpro_icons('crying'); ?></div>
                                        <div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>
                                        <div class="review smily"><?php echo listingpro_icons('smily'); ?></div>
                                        <div class="review cool"><?php echo listingpro_icons('cool'); ?></div>
                                    </div>
								</div>
							</div>
                            <div class = "col-md-6 pull-right padding-right-0">
                                <div class="form-group submit-images">
                                    <label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
                                    <a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
                                    <input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
                                </div>
                            </div>
						    <div class="clearfix"></div>
                            <?php
                            }
                            ?>
						<?php if($enableUsernameField==true){ ?>
							<div class="form-group">
								<label for = "u_mail"><?php esc_html_e('User Name','listingpro'); ?></label>
								<input type = "text" placeholder="<?php esc_html_e('john','listingpro'); ?>" id = "lp_custom_username" class="form-control" name = "lp_custom_username" />
							</div>

						<?php } ?>

						<?php
							if($lp_Reviews_OPT=="instant_sign_in"){
						?>
							<div class="form-group">
								<label for = "u_mail"><?php esc_html_e('Email','listingpro'); ?></label>
								<input type = "email" placeholder="<?php esc_html_e('you@website.com','listingpro'); ?>" id = "u_mail" class="form-control" name = "u_mail" />
							</div>
							<?php } ?>

						<div class="form-group">
							<label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>
							<input type = "text" placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" id = "post_title" class="form-control" name = "post_title" />
						</div>
						<div class="form-group">
							<label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>
							<textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too!','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>
							<p><?php esc_html_e('Your review is recommended to be at least 140 characters long','listingpro'); ?></p>
						</div>
						<div class="form-group">
								<?php
									if($lp_Reviews_OPT=="instant_sign_in"){
										if($enableCaptcha==true){
											if ( class_exists( 'cridio_Recaptcha' ) ){
												if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
												echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
												}
											}
										}
									}
								?>
						</div>
						<?php

							if(!empty($privacy_policy) && $privacy_review=="yes"){
						?>
								<div class="form-group lp_privacy_policy_Wrap">
									<input class="lpprivacycheckboxopt" id="reviewpolicycheck" type="checkbox" name="reviewpolicycheck" value="true">
												<label for="reviewpolicycheck"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
												<div class="help-text">
													<a class="help" target="_blank"><i class="fa fa-question"></i></a>
													<div class="help-tooltip">
														<p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this review?', 'listingpro'); ?></p>
													</div>
												</div>
								</div>


								<p class="form-submit">
									<?php
										if($lp_Reviews_OPT=="sign_in"){
											
											$reviewDataAtts = '';
											$extraDataatts = 'data-modal="modal-3"';
									?>
									<?php if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
											$reviewDataAtts = 'data-toggle="modal" data-target="#app-view-login-popup"';
											$extraDataatts = '';
									}
									?>
                                            
									<input name="submit_review" <?php echo $reviewDataAtts; ?> type="submit" id="submit" class="lp-review-btn btn-second-hover md-trigger" <?php echo $extraDataatts; ?> value="<?php echo esc_html__('Submit Review ', 'listingpro');?>" disabled>
									<?php
										}elseif($lp_Reviews_OPT=="instant_sign_in"){
									?>
										<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php echo esc_html__('Signup & Submit Review ', 'listingpro');?>" disabled>
									<?php } ?>
									<span class="review_status"></span>
									<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
								</p>
						<?php
							}else{
						?>
								<p class="form-submit">
									<?php
										if($lp_Reviews_OPT=="sign_in"){
											
											$reviewDataAtts = '';
											$extraDataatts = 'data-modal="modal-3"';
									?>
									<?php if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
											$reviewDataAtts = 'data-toggle="modal" data-target="#app-view-login-popup"';
											$extraDataatts = '';
									}
									?>
                                            
									<input name="submit_review" <?php echo $reviewDataAtts; ?> type="submit" id="submit" class="lp-review-btn btn-second-hover md-trigger" <?php echo $extraDataatts; ?> value="<?php echo esc_html__('Submit Review ', 'listingpro');?>">
									<?php
										}elseif($lp_Reviews_OPT=="instant_sign_in"){
									?>
										<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php echo esc_html__('Signup & Submit Review ', 'listingpro');?>">
									<?php } ?>

									<span class="review_status"></span>
									<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
								</p>
					<?php
							}
					?>
					<input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">

						<input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">


					</form>
				</div>
				<?php

			}
		}
	}
}

if( !function_exists('listingpro_get_reviews_form_v2' ) )
{

    function listingpro_get_reviews_form_v2( $postid )

    {
        if ( class_exists('ListingReviews' ) )
        {

            global $listingpro_options;

            $lp_Reviews_OPT = $listingpro_options['lp_review_submit_options'];

            $gSiteKey = '';

            $gSiteKey = $listingpro_options['lp_recaptcha_site_key'];

            $enableCaptcha = lp_check_receptcha('lp_recaptcha_reviews');

            $lp_images_count = '555';
            $lp_images_size = '999999999999999999999999999999999999999999999999999';
            $lp_imagecount_notice = '';
            $lp_imagesize_notice = '';
            if(lp_theme_option('lp_listing_reviews_images_count_switch')=='yes')
            {
                $lp_images_count = lp_theme_option('lp_listing_reviews_images_counter');
                $lp_imagecount_notice= esc_html__("Max. allowed images are ", 'listingpro');
                $lp_imagecount_notice .= $lp_images_count;
            }
            if(lp_theme_option('lp_listing_reviews_images_size_switch')=='yes'){
                $lp_images_size = lp_theme_option('lp_listing_reviews_images_sizes');
                $lp_imagesize_notice= esc_html__('Max. allowed images size is ', 'listingpro');
                $lp_imagesize_notice .= $lp_images_size. esc_html__(' Mb', 'listingpro');
                $lp_images_size = $lp_images_size * 1000000;
            }
            $enableUsernameField = lp_theme_option('lp_register_username');

            $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];
            if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )

            {

                $lp_multi_rating_fields_active	=	array();

                for ($x = 1; $x <= 4; $x++) {

                    $field_active   =   '';
                   if( isset($listingpro_options['lp_multi_ratiing'.$x.'_switch']) )
                   {
                       $field_active    =    $listingpro_options['lp_multi_ratiing'.$x.'_switch'];
                   }

                    if( $field_active == 1 )

                    {

                        

                        $field_active_label			=	$listingpro_options['lp_multi_ratiing'.$x.'_label_switch'];



                        $lp_multi_rating_fields_active['field'.$x]['label']			=	$field_active_label;

                        

                    }

                }



            }

            $multi_left_col =   '';

            $multi_right_col =   '';



            if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )

            {

                $multi_left_col =   'lp-review-form-top-multi';

                $multi_right_col =   'lp-review-images-multi';

            }



            if( is_user_logged_in() )

            {

                ?>

                <div class="lp-listing-review-form" id="review-section">

                    

                    <h2><?php echo esc_html__('Write a review', 'listingpro'); ?> <i class="fa fa-chevron-down"></i></h2>

                    <form data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_form" name="rewies_form" action = "" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">

                        <div class="lp-review-form-top <?php echo $multi_left_col; ?>">

                            <?php

                            if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )

                            {

                                ?>

                                <div class="lp-review-stars">

                                    <span class="stars-label"><?php esc_html_e('Your Rating','listingpro'); ?></span>

                                    <i class="fa fa-star-o"></i>

                                    <i class="fa fa-star-o"></i>

                                    <i class="fa fa-star-o"></i>

                                    <i class="fa fa-star-o"></i>

                                    <i class="fa fa-star-o"></i>

                                </div>

                                <?php

                            }

                            else

                            {

                                ?>

                                <div class="lp-review-stars">

                                    <span class="stars-label"><?php esc_html_e('Your Rating','listingpro'); ?></span>

                                    <div class="lp-listing-stars">

                                        <input type="hidden" id="review-rating" name="rating" class="rating-tooltip" data-filled="fa fa-star" data-empty="fa fa-star-o" />

                                        <div class="review-emoticons">

                                            <div class="review angry"><?php echo listingpro_icons('angry'); ?></div>

                                            <div class="review cry"><?php echo listingpro_icons('crying'); ?></div>

                                            <div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>

                                            <div class="review smily"><?php echo listingpro_icons('smily'); ?></div>

                                            <div class="review cool"><?php echo listingpro_icons('cool'); ?></div>

                                        </div>

                                    </div>

                                </div>

                                <?php

                            }

                            ?>

                            <div class="form-group submit-images lp-review-images <?php echo $multi_right_col; ?>">

                                <label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>

                                <a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>

                                <input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>

                            </div>



                            <div class="clearfix"></div>

                        </div>

                        <div class="lp-review-form-bottom">



                            <?php

                            if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )

                            {

                                echo '<div class="form-group">';

                                echo '<div class="col-md-12 padding-left-0 lp-multi-rating-ui-wrap">';

                                $lp_rating_field_counter	=	1;

                                foreach( $lp_multi_rating_fields_active as $k => $lp_multi_rating_field )

                                {

                                    ?>

                                    <div class="col-md-6 padding-left-0">

                                        <div class="sfdfdf list-style-none form-review-stars">

                                            <p><?php echo $lp_multi_rating_field['label']; ?></p>

                                            <input type="hidden" data-mrf="<?php echo $k; ?>" id="review-rating-<?php echo $k; ?>" name="rating-<?php echo $k; ?>" class="rating-tooltip lp-multi-rating-val" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />

                                            <span class="label-start"><?php echo $lp_multi_rating_field['label_start']; ?></span><span class="label-end"><?php echo $lp_multi_rating_field['label_end']; ?></span>

                                        </div>

                                    </div>

                                    <?php

                                    $lp_rating_field_counter++;

                                }

                                echo '<div class="clearfix"></div>';

                                echo '</div>';

                                echo '</div>';

                            }

                            ?>



                            <div class="form-group">

                                <label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>

                                <input placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" type = "text" id = "post_title" class="form-control" name = "post_title" />

                            </div>

                            <div class="form-group">

                                <label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>

                                <textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too! And remember.','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>

                                <p><?php esc_html_e('Your review is recommended to be at least 140 characters long :)','listingpro'); ?></p>

                            </div>

                            <div class="form-group">

                                <?php

                                if($enableCaptcha==true){

                                    if ( class_exists( 'cridio_Recaptcha' ) ){

                                        if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {

                                            echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';

                                        }

                                    }

                                }

                                ?>

                            </div>
							
                            <?php
							$privacy_policy = $listingpro_options['payment_terms_condition'];
							$privacy_review = $listingpro_options['listingpro_privacy_review'];
                            if( !empty( $privacy_policy ) && $privacy_review == 'yes' )
                            {
                                ?>
                                <div class="form-group lp_privacy_policy_Wrap">
                                    <input class="lpprivacycheckboxopt" id="reviewpolicycheck" type="checkbox" name="reviewpolicycheck" value="true">
                                    <label for="reviewpolicycheck"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
                                    <div class="help-text">
                                        <a class="help" target="_blank"><i class="fa fa-question"></i></a>
                                        <div class="help-tooltip">
                                            <p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this review?', 'listingpro'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="form-submit post-reletive">
                                    <input name="submit_review" type="submit" id="submit" class="review-submit-btn" value="<?php esc_html_e('Submit Review','listingpro'); ?>" disabled>
                                    <input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
                                    <input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
                                    <span class="review_status"></span>
                                    <img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
                                </p>
                                <?php
                            }else{
                                ?>
                                <?php
                                ?>
                                <p class="form-submit post-reletive">
                                    <input name="submit_review" type="submit" id="submit" class="review-submit-btn" value="<?php esc_html_e('Submit Review','listingpro'); ?>">
                                    <input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
                                    <input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
                                    <span class="review_status"></span>
                                    <img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
                                </p>
                            <?php
                            }
                            ?>

                        </div>



                    </form>

                </div>

                <?php

            } else  { ?>

                <div class="lp-listing-review-form">

                    
                    <h2><?php echo esc_html__('Write a review', 'listingpro'); ?> <i class="fa fa-chevron-down"></i></h2>

                    <?php

                    if($lp_Reviews_OPT=="instant_sign_in"){

                    ?>

                    <form data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_form" name = "rewies_form" action = "" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">

                        <?php

                        }

                        else{

                        ?>

                        <form data-multi-rating="<?php echo $lp_multi_rating_state; ?>" id = "rewies_formm" name = "rewies_form" action = "#" method = "post" enctype="multipart/form-data" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>">



                            <?php } ?>

                            <div class="lp-review-form-top">

                                <div class="lp-review-stars">

                                    <span class="stars-label"><?php esc_html_e('Your Rating','listingpro'); ?></span>

                                    <?php

                                    if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) ) {

                                        ?>

                                        <i class="fa fa-star-o"></i>

                                        <i class="fa fa-star-o"></i>

                                        <i class="fa fa-star-o"></i>

                                        <i class="fa fa-star-o"></i>

                                        <i class="fa fa-star-o"></i>

                                        <?php

                                    }else

                                    {

                                        ?>

                                        <div class="lp-listing-stars">

                                            <input type="hidden" id="review-rating" name="rating" class="rating-tooltip"

                                                   data-filled="fa fa-star" data-empty="fa fa-star-o"/>

                                            <div class="review-emoticons">

                                                <div class="review angry"><?php echo listingpro_icons('angry'); ?></div>

                                                <div class="review cry"><?php echo listingpro_icons('crying'); ?></div>

                                                <div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>

                                                <div class="review smily"><?php echo listingpro_icons('smily'); ?></div>

                                                <div class="review cool"><?php echo listingpro_icons('cool'); ?></div>

                                            </div>

                                        </div>

                                        <?php

                                    }

                                    ?>

                                </div>

                                <div class="form-group submit-images lp-review-images">

                                    <label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>

                                    <a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>

                                    <input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>

                                </div>



                                <div class="clearfix"></div>

                            </div>

                            <div class="clearfix"></div>

                            <div class="lp-review-form-bottom">

                                <div class="form-group">

                                    <?php

                                    if( $lp_multi_rating_state == 1 && is_array( $lp_multi_rating_fields_active ) && !empty( $lp_multi_rating_fields_active ) )

                                    {

                                        echo '<div class="col-md-12 padding-left-0 lp-multi-rating-ui-wrap">';

                                        $lp_rating_field_counter	=	1;

                                        foreach( $lp_multi_rating_fields_active as $k => $lp_multi_rating_field )

                                        {

                                            ?>

                                            <div class="col-md-6 padding-left-0">

                                                <div class="sfdfdf list-style-none form-review-stars">

                                                    <p><?php echo $lp_multi_rating_field['label']; ?></p>

                                                    <input type="hidden" data-mrf="<?php echo $k; ?>" id="review-rating-<?php echo $k; ?>" name="rating-<?php echo $k; ?>" class="rating-tooltip lp-multi-rating-val" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />

                                                    <span class="label-start"><?php echo $lp_multi_rating_field['label_start']; ?></span><span class="label-end"><?php echo $lp_multi_rating_field['label_end']; ?></span>

                                                </div>

                                            </div>

                                            <?php

                                            $lp_rating_field_counter++;

                                        }

                                        echo '<div class="clearfix"></div>';

                                        echo '</div>';

                                    }

                                    ?>

                                </div>

                                
								<?php if($enableUsernameField==true){ ?>
                                   <div class="form-group">
                                       <label for = "u_mail"><?php esc_html_e('User Name','listingpro'); ?></label>
                                       <input type = "text" placeholder="<?php esc_html_e('john','listingpro'); ?>" id = "lp_custom_username" class="form-control" name = "lp_custom_username" />
                                   </div>

                               <?php } ?>
							   <?php
                                if($lp_Reviews_OPT=="instant_sign_in"){

                                    ?>

                                    <div class="form-group">

                                        <label for = "u_mail"><?php esc_html_e('Email','listingpro'); ?></label>

                                        <input type = "email" placeholder="<?php esc_html_e('you@website.com','listingpro'); ?>" id = "u_mail" class="form-control" name = "u_mail" />

                                    </div>

                                <?php } ?>



                                <div class="form-group">

                                    <label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>

                                    <input placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" type = "text" id = "post_title" class="form-control" name = "post_title" />

                                </div>

                                <div class="form-group">

                                    <label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>

                                    <textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too! And remember.','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>

                                    <p><?php esc_html_e('Your review recommended to be at least 140 characters long :)','listingpro'); ?></p>

                                </div>

                                <div class="form-group">

                                    <div class="form-group">

                                        <?php

                                        if($lp_Reviews_OPT=="instant_sign_in"){

                                            if($enableCaptcha==true){

                                                if ( class_exists( 'cridio_Recaptcha' ) ){

                                                    if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {

                                                        echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';

                                                    }

                                                }

                                            }

                                        }

                                        ?>

                                    </div>

                                </div>

								<?php
                                if(!empty($privacy_policy) && $privacy_review=="yes")
                                {
                                ?>
                                    <div class="form-group lp_privacy_policy_Wrap">
                                        <input class="lpprivacycheckboxopt" id="reviewpolicycheck" type="checkbox" name="reviewpolicycheck" value="true">
                                        <label for="reviewpolicycheck"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
                                        <div class="help-text">
                                            <a class="help" target="_blank"><i class="fa fa-question"></i></a>
                                            <div class="help-tooltip">
                                                <p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this review?', 'listingpro'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <p class="form-submit">
                                    <?php
                                    if($lp_Reviews_OPT=="sign_in"){
                                    ?>
                                        <input name="submit_review" type="submit" id="submit" class="review-submit-btn md-trigger" data-modal="modal-3" value="<?php echo esc_html__('Submit Review ', 'listingpro');?>" disabled>
                                    <?php
                                    }elseif($lp_Reviews_OPT=="instant_sign_in"){
                                        ?>
                                        <input name="submit_review" type="submit" id="submit" class="review-submit-btn" value="<?php echo esc_html__('Signup & Submit Review ', 'listingpro');?>" disabled>
                                    <?php } ?>
                                    <input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
                                    <span class="review_status"></span>
                                    <img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
                                </p>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <p class="form-submit">
                                        <?php
                                        if($lp_Reviews_OPT=="sign_in"){
                                            ?>
                                            <input name="submit_review" type="submit" id="submit" class="review-submit-btn md-trigger" data-modal="modal-3" value="<?php echo esc_html__('Submit Review ', 'listingpro');?>">
                                            <?php
                                        }elseif($lp_Reviews_OPT=="instant_sign_in"){
                                            ?>
                                            <input name="submit_review" type="submit" id="submit" class="review-submit-btn" value="<?php echo esc_html__('Signup & Submit Review ', 'listingpro');?>">
                                        <?php } ?>
                                        <input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
                                        <span class="review_status"></span>
                                        <img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
                                    </p>
                                    <?php

                                }
                                ?>
                                <input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
                            </div>

                        </form>

                </div>

                <?php

            }

        }

    }

}
?>