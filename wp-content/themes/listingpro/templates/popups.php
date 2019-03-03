		<!-- Listing Detail Popup -->
		<?php
				global $listingpro_options;
				$enablepassword = false;
				if(isset($listingpro_options['lp_register_password'])){
					if($listingpro_options['lp_register_password']==1){
						$enablepassword = true;
					}
				}
				$gSiteKey = '';
				$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
				$enableCaptcha = lp_check_receptcha('lp_recaptcha_registration');		
				$enableCaptchaLogin = lp_check_receptcha('lp_recaptcha_login');	
				$privacy_policy = $listingpro_options['payment_terms_condition'];				
					
				?>
		<?php
			if(is_page_template('template-dashboard.php')){
		?>
		<!-- dynamic invoice -->
			<div class="modal fade lp-modal-list" id="modal-invoice">
					<div class="modal-content">
					
						<div class="modal-body">
							<?php echo esc_html__('Content is loading...','listingpro'); ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white" data-dismiss="modal"><?php esc_html_e('Close','listingpro'); ?></button>
							<a href="#" class="lp-print-list btn-first-hover"><?php esc_html_e('Print','listingpro'); ?></a>
						</div>
					</div>
			</div>
		<!-- dynamic invoice -->
		<?php
			}
			?>
		
		
		<!-- Login Popup -->
		<?php
       global $listingpro_options;
       $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
       if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
       {}
       else
       {
		   ?>
		<div class="md-modal md-effect-3" id="modal-3">
			
			<div class="login-form-popup lp-border-radius-8">
				<div class="siginincontainer">
					<h3 class="text-center"><?php esc_html_e('Sign in','listingpro'); ?></h3>
					<form id="login" class="form-horizontal margin-top-30"  method="post">
						<p class="status"></p>
						<div class="form-group">
							<label for="username"><?php esc_html_e('Username or Email Address *','listingpro'); ?></label>
							<input type="text" class="form-control" id="lpusername" name="lpusername" />
						</div>
						<div class="form-group">
							<label for="password"><?php esc_html_e('Password *','listingpro'); ?></label>
							<input type="password" class="form-control" id="lppassword" name="lppassword" />
						</div>
						<div class="form-group">
							<?php
								if($enableCaptchaLogin==true){
									if ( class_exists( 'cridio_Recaptcha' ) ){ 
										if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
										echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
										}
									}
								}

							?>
						</div>
						<div class="form-group">
							<div class="checkbox pad-bottom-10">
								<input id="check1" type="checkbox" name="remember" value="yes">
								<label for="check1"><?php esc_html_e('Keep me signed in','listingpro'); ?></label>
							</div>
						</div>
						
						<div class="form-group">
							<input type="submit" value="<?php esc_html_e('Sign in','listingpro'); ?>" class="lp-secondary-btn width-full btn-first-hover" /> 
						</div>
						<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
					</form>	
					<div class="pop-form-bottom">
						<div class="bottom-links">
							<a  class="signUpClick"><?php esc_html_e('Not a member? Sign up','listingpro'); ?></a>
							<a  class="forgetPasswordClick pull-right" ><?php esc_html_e('Forgot Password','listingpro'); ?></a>
						</div>
						<?php 
							if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) {
								if (count(NextendSocialLogin::$enabledProviders) > 0) {
					?>
						<p class="margin-top-15"><?php esc_html_e('Connect with your Social Network','listingpro'); ?></p>
								
						<ul class="social-login list-style-none">						
							<?php
								
								foreach (NextendSocialLogin::$providers AS $provider){
		
									$state         = $provider->getState();
									$providerLable = $provider->getLabel();
									switch ($state) {
										case 'enabled':
										if($providerLable=="Google"){
											/* google is configured */
											?>
											<li>
												<a id="logingoogle" class="google flaticon-googleplus" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('google_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Google','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
										
										if($providerLable=="Facebook"){
											/* facebook is configured */
											?>
											<li>
												<a id="loginfacebook" class="facebook flaticon-facebook" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('facebook_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Facebook','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
										
										if($providerLable=="Twitter"){
											/* twitter is configured */
											?>
											<li>
												<a id="logintwitter" class="twitter flaticon-twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('twitter_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Twitter','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
									}										
								}
							?>							
						</ul>					
					<?php 
							}
					
						} 
					?>
					</div>
				<a class="md-close"><i class="fa fa-close"></i></a>
				</div>
				
				<div class="siginupcontainer">
					<h3 class="text-center"><?php esc_html_e('Sign Up','listingpro'); ?></h3>
					<form id="register" class="form-horizontal margin-top-30"  method="post">
					<p class="status"></p>
						<div class="form-group">
							<label for="username"><?php esc_html_e('Username *','listingpro'); ?></label>
							<input type="text" class="form-control" id="username2" name="username" />
						</div>
						<div class="form-group">
							<label for="email"><?php esc_html_e('Email Address *','listingpro'); ?></label>
							<input type="email" class="form-control" id="email" name="email" />
						</div>
						<?php if($enablepassword==true){ ?>
							<div class="form-group">
							<label for="upassword"><?php esc_html_e('Password *','listingpro'); ?></label>
							<input type="password" class="form-control" id="upassword" name="upassword" />
							</div>
						<?php } ?>
						<?php if($enablepassword==false){ ?>
							<div class="form-group">
								<p><?php esc_html_e('Password will be e-mailed to you.','listingpro'); ?></p>
							</div>
						<?php } ?>
						
						<?php
							if(!empty($privacy_policy)){
								$privacy_signup = $listingpro_options['listingpro_privacy_register'];
								if($privacy_signup=="yes"){
									echo '
									<div class="checkbox form-group check_policy termpolicy pull-left termpolicy-wraper">
										<input id="check_policy" type="checkbox" name="policycheck" value="true">
										<label for="check_policy"><a target="_blank" href="'.get_the_permalink($privacy_policy).'" class="help" target="_blank">'.esc_html__('I Agree', 'listingpro').'</a></label>
										<div class="help-text">
											<a class="help" target="_blank"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('You agree & accept our Terms & Conditions to signup.', 'listingpro').'</p>
											</div>
										</div>
									</div>';
								}
							}
						?>
						
						<div class="form-group pull-left">
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
						
						<div class="clearfix padding-top-20 padding-bottom-20"></div>
						<div class="form-group">
							<input type="submit" value="<?php esc_html_e('Register','listingpro'); ?>" id="lp_usr_reg_btn" class="lp-secondary-btn width-full btn-first-hover" /> 
						</div>
						<?php wp_nonce_field( 'ajax-register-nonce', 'security2' ); ?>
					</form>	
										<div class="pop-form-bottom">
						<div class="bottom-links">
							<a  class="signInClick"><?php esc_html_e('Already have an account? Sign in','listingpro'); ?></a>
							<a  class="forgetPasswordClick pull-right" ><?php esc_html_e('Forgot Password','listingpro'); ?></a>
						</div>
						<?php 
							if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) {
								if (count(NextendSocialLogin::$enabledProviders) > 0) {
					?>
						<p class="margin-top-15"><?php esc_html_e('Connect with your Social Network','listingpro'); ?></p>
								
						<ul class="social-login list-style-none">						
							<?php
								
								foreach (NextendSocialLogin::$providers AS $provider){
		
									$state         = $provider->getState();
									$providerLable = $provider->getLabel();
									switch ($state) {
										case 'enabled':
										if($providerLable=="Google"){
											/* google is configured */
											?>
											<li>
												<a id="logingoogle" class="google flaticon-googleplus" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('google_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Google','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
										
										if($providerLable=="Facebook"){
											/* facebook is configured */
											?>
											<li>
												<a id="loginfacebook" class="facebook flaticon-facebook" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('facebook_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Facebook','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
										
										if($providerLable=="Twitter"){
											/* twitter is configured */
											?>
											<li>
												<a id="logintwitter" class="twitter flaticon-twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter&redirect='+window.location.href; return false;">
                                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('twitter_login'); ?>"></span>
                                                    <span><?php esc_html_e('sign in With Twitter','listingpro'); ?></span>
												</a>
											</li>
											<?php
										}
									}										
								}
							?>							
						</ul>					
					<?php 
							}
					
						} 
					?>
					</div>
				<a class="md-close"><i class="fa fa-close"></i></a>
				</div>
				<div class="forgetpasswordcontainer">
					<h3 class="text-center"><?php esc_html_e('Forgotten Password','listingpro'); ?></h3>
					<form class="form-horizontal margin-top-30" id="lp_forget_pass_form" action="#"  method="post">
					<p class="status"></p>
						<div class="form-group">
							<label for="password"><?php esc_html_e('Email Address *','listingpro'); ?></label>
							<input type="email" name="user_login" class="form-control" id="email3" />
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="<?php esc_html_e('Get New Password','listingpro'); ?>" class="lp-secondary-btn width-full btn-first-hover" />
							<?php wp_nonce_field( 'ajax-forgetpass-nonce', 'security3' ); ?>
						</div>
					</form>	
					<div class="pop-form-bottom">
						<div class="bottom-links">
							<a class="cancelClick" ><?php esc_html_e('Cancel','listingpro'); ?></a>
						</div>
					</div>
				<a class="md-close"><i class="fa fa-close"></i></a>
				</div>
			</div>
			
			
		</div>
		
	   <?php } ?>
		
		
		
		<!-- ../Login Popup -->
		<?php if(is_singular('listing')){ ?>
		<?php 
		
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post(); 
				
		?>
		<?php
		$post_id='';
		$post_title='';
		$post_url='';
		$post_author_id='';
		$post_author_meta='';
		$author_nicename='';
		$author_url='';
		
		$post_id = $post->ID;
		$post_title = $post->post_title;
		$post_url = get_permalink($post_id);
		
		$post_author_id= $post->post_author;
		$post_author_meta = get_user_by( 'id', $post_author_id );
		//print_r($post_author_meta);
		if(!empty($post_author_meta)){
			$author_nicename = $post_author_meta->user_nicename;
			$author_user_email = $post_author_meta->user_email;
		}
		
		$author_url = get_author_posts_url( $post_author_id);
		
		

		?>
		<?php
			}
		}
		?>
		
		<!-- Popup Open -->
		<div class="md-modal md-effect-3 single-page-popup" id="modal-6">
			<div class="md-content cotnactowner-box">
				<h3><?php esc_html('Contact Owner', 'listingpro'); ?></h3>
				<div class="">
					<form class="form-horizontal"  method="post" id="contactowner">
						<div class="form-group">
							<input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e('Name:','listingpro'); ?>" required>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email6" id="email6" placeholder="<?php esc_html_e('Email:','listingpro'); ?>" required>
						</div>
						<div class="form-group">
							<textarea class="form-control" rows="5" name="message1" id="message1" placeholder="<?php esc_html_e('Message:','listingpro'); ?>"></textarea>
						</div>
						<div class="form-group mr-bottom-0">
							<input type="submit" value="<?php esc_html_e('Submit','listingpro'); ?>" class="lp-review-btn btn-second-hover">
							<input type="hidden"  name="authoremail" value="<?php echo esc_attr($author_user_email); ?>">
							<input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
							<input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
							<i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
							<span class="statuss"></span>
						</div>
					</form>	
					<a class="md-close"><i class="fa fa-close"></i></a>
				</div>
			</div>
		</div>
		<!-- Popup Close -->
		<div class="md-modal md-effect-3" id="modal-4">
			<div class="md-content">
				<div id="map"  class="singlebigpost"></div>
				<a class="md-close widget-map-click"><i class="fa fa-close"></i></a>
			</div>
		</div>
		<div class="md-modal md-effect-3" id="modal-5">
			<div class="md-content">
				<div id="mapp"  class="singlebigpostfgf"></div>
				<a class="md-close widget-mapdfd-click"><i class="fa fa-close"></i></a>
				
			</div>
		</div>
		
		<?php } ?>
		
		<?php
			if(is_page_template('template-dashboard.php')){
		?>
		
				<!-- Modal Packages -->
				  <div class="modal fade" id="modal-packages" role="dialog">
					<div class="modal-dialog  lp-change-plan-popup">
					
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-body">
							<div class="lp-existing-plane-container">
								<div class="modal-header">
									<h2 class="modal-title"><?php echo esc_html__('Current Pricing Plan', 'listingpro'); ?></h2>
									<p><?php echo esc_html__('We recommend you check the details of Pricing Plans before changing.', 'listingpro'); ?>
									<?php
										$pricingURL = $listingpro_options['pricing-plan'];
										if(!empty($pricingURL)){
									?>
										<a href="<?php echo esc_url($pricingURL); ?>" target="_blank"><?php echo esc_html__('Click Here', 'listingpro'); ?></a>
									<?php
										}
									?>
									</p>
								</div>
								<div class="lp-selected-plan-features">
									<div class="lp-selected-plan-price">
										<h3></h3>
									</div>
									<div class="lp-selected-plan-price">
										<h4></h4>
									</div>
									<p class="lp-change-plan-btnn"><?php echo esc_html__('Do you want to change pricing plan? ', 'listingpro'); ?>
									
										<a class="lp-change-proceed-link" href="" target="_blank"><?php echo esc_html__('Proceed Here', 'listingpro'); ?></a>
									
									</p>
								</div>
							</div>
							
							<div class="lp-new-plane-container"  style="display:none;">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><?php echo esc_html__('Change Pricing Plan', 'listingpro'); ?></h4>
									<p><?php echo esc_html__('We recommend you check the details of Pricing Plans before changing.', 'listingpro'); ?>
									<?php
										$pricingURL = $listingpro_options['pricing-plan'];
										if(!empty($pricingURL)){
									?>
										<a href="<?php echo esc_url($pricingURL); ?>" target="_blank"><?php echo esc_html__('Click Here', 'listingpro'); ?></a>
									<?php
										}
									?>
									</p>
								</div>
								<?php
									$n=0;
									$currency_position = '';
									$currency_position = $listingpro_options['pricingplan_currency_position'];
									$currency = listingpro_currency_sign();
									$checkout = $listingpro_options['payment-checkout'];
									$checkout_url = get_permalink( $checkout );
									$taxOn = $listingpro_options['lp_tax_swtich'];
									$withtaxprice = false;
									if($taxOn=="1"){
										$showtaxwithprice = $listingpro_options['lp_tax_with_plan_swtich'];
										if($showtaxwithprice=="1"){
											$withtaxprice = true;
										}
									}
									$args = array(
										'posts_per_page'    => -1,
										'post_type' => array( 'price_plan' ),
									);
									$the_query = new WP_Query( $args );

									if ( $the_query->have_posts() ) {
										echo '<form name="select-plan-form"  id="select-plan-form" method="post" class="select-plan-form">';
											while ( $the_query->have_posts() ) {
												$the_query->the_post();
												$plan_id = get_the_ID();
												$planPrice = get_post_meta($plan_id, 'plan_price', true);
												if(!empty($planPrice)){
													if($withtaxprice=="1"){
														$taxrate = $listingpro_options['lp_tax_amount'];
														$taxprice = (float)(($taxrate/100)*$planPrice);
														$planPrice = (float)$planPrice + (float)$taxprice;
													}
													if(!empty($currency_position)){
														if($currency_position=="left"){
															$planPrice = $currency. $planPrice;
														}
														else{
															$planPrice = $planPrice. $currency;
														}
													}
													else{
														$planPrice = $currency. $planPrice;
													}
													
												}
												else{
													$planPrice = esc_html__('Free', 'listingpro');
												}
												
												$planType = get_post_meta($plan_id, 'plan_package_type', true);
												$planType = trim($planType);
												$planpkgtype = '';
												if( !empty($planType) && $planType=="Package"){
													$planpkgtype = esc_html__('Package', 'listingpro');
												}
												else{
													$planpkgtype = esc_html__('Pay Per Listing', 'listingpro');
												}
												$planDays = '';
												$planDays = get_post_meta($plan_id, 'plan_time', true);
												$planListing = '';
												if( !empty($planType) && $planType=="Package"){
													$planListing = get_post_meta($plan_id, 'plan_text', true);
													if(!empty($planListing)){
														$planListing = $planListing.' '. esc_html__('Listing', 'listingpro');
													}
													else{
														$planListing = esc_html__('Unlimited Listing', 'listingpro');
													}
												}
												
												if(!empty($planDays)){
													if($planDays=="1"){
														$planDays .=' '.esc_html__('Day', 'listingpro');
													}
													else{
														$planDays .=' '.esc_html__('Days', 'listingpro');
													}
												}
												else{
													$planDays .='Unlimited '.esc_html__('Days', 'listingpro');
												}
												echo '
													<div class="lp-selected-plan-features select-plan-form">
														<div class="lp-selected-plan-price">
															
															<label class="plan-options">
																		<div class="radio radio-danger">
																		<input id="'.get_the_ID().'" type="radio" name="plans-posts" value="'.get_the_ID().'">
																		<label for="'.get_the_ID().'"></label>
																		</div>
																		 '.get_the_title().'
															</label>
																
														</div>
														<div class="selected-plane-price-features">
															<ul class="clearfix">
																<li><span></span><p>'.$planPrice.'</p></li>
																<li><span></span><p>'.$planpkgtype.'</p></li>
																<li><span></span><p>'.$planDays.'</p></li>';
																if(!empty($planListing)){
																	echo '<li><span></span><p>'.$planListing.'</p></li>';
																}
															echo '	
															</ul>
														</div>
														
													</div>
												';
												$n++;
												
											}
											if($n>0){
												echo '<div class="clearfix margin-top-30 margin-bottom-20"><div class="pull-left plane_change_btn">';
												echo '<input type="hidden" value="" name="listing-id" id="listing_id">';
												echo '<input type="hidden" value="" name="listing_statuss" id="listing_statuss">';
												echo '<input type="submit" class="btn btn-default" value="'.esc_html__('Change', 'listingpro').'" name="submit-change">';
												echo '</div>';
												echo '</div>';
											}
											else{
												echo '<p>'.esc_html__('Sorry! There is no plan available', 'listingpro').'</p>';
											}
											echo '<div class="clearfix pull-left plane_change_btn">';
											echo '<a href="" class="lp-role-back-to-current-plan">'.esc_html__('Go Back', 'listingpro').'</a>';
											echo '</div>';
										echo '</form>';
										echo '<div class="lp-change-plane-status pull-right"><div class="lp-action-div"></div><div class="lp-expire-update-status"></div></div><div class="clearfix"></div>';

										wp_reset_postdata();
									} else {
									}
								?>
							</div>
							
						</div>
					  </div>
					</div>
				  </div>
				<!--modal 7, for app view filters-->
		<?php
			}
			
			if(is_page() && !is_front_page()){
		?>
        
		
				<!--modal droppin, for custom lat and long via drag-->
				<div id="modal-doppin" class="modal fade" role="dialog" data-lploctitlemap='<?php echo esc_html__("Your Location", "listingpro"); ?>'>
					<div class="modal-dialog">
						<a href="#" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></a>
						<div class="md-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">×</button>
							  <h4 class="modal-title"><?php echo esc_html__('Drop Pin', 'listingpro'); ?></h4>
							</div>
							<div id="lp-custom-latlong" style="height:600px; width:600px;"></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>

		<div class="md-overlay"></div> <!-- Overlay for Popup -->
		
		<!-- top notificaton bar -->
		<div class="lp-top-notification-bar"></div>
		<!-- end top notification-bar -->
		
		
		<!-- popup for quick view --->
		
		<div class="md-modal md-effect-3" id="listing-preview-popup">
			<div class="container">
				<div class="md-content ">
					<div class="row popup-inner-left-padding ">


					</div>
				</div>
			</div>
			<a class="md-close widget-map-click"><i class="fa fa-close"></i></a>
		</div>
		<div class="md-overlay content-loading"></div>


        <div class="md-modal md-effect-map-btn" id="grid-show-popup">
            <div class="container">
                <div class="md-content ">
                    <div class="row grid-show-popup" data-loader="<?php echo get_template_directory_uri(); ?>/assets/images/content-loader.gif"">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/content-loader.gif">
                    </div>
                </div>
            </div>
            <a class="md-close widget-map-click"><i class="fa fa-close"></i></a>
        </div>
<!--        <div class="md-overlay content-loading"></div>-->
		
		<!--hidden google map-->
		<div id="lp-hidden-map" style="width:300px;height:300px;position:absolute;left:-300000px"></div>
		
		<?php
			if(is_page_template('template-dashboard.php')){
				//campaign creation popup
				echo get_template_part('templates/popups/campaign');
			}
		?>