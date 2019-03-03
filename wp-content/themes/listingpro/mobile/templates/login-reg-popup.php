<?php
if( !is_user_logged_in() && wp_is_mobile() ){ 
	global $listingpro_options;
				
				$gSiteKey = '';
				$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
				$enableCaptcha = lp_check_receptcha('lp_recaptcha_registration');		
				$enableCaptchaLogin = lp_check_receptcha('lp_recaptcha_login');	
				$privacy_policy = $listingpro_options['payment_terms_condition'];
				$enablepassword = false;
				if(isset($listingpro_options['lp_register_password'])){
					if($listingpro_options['lp_register_password']==1){
						$enablepassword = true;
					}
				}				


?>



		<div class="modal-dialog">
			
			  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<div class="login-form-pop-tabs clearfix">
						<ul>
							<li><a href="#" class="signInClick active"><?php esc_html_e('Sign In','listingpro'); ?></a></li>
							<li><a href="#" class="signUpClick"><?php esc_html_e('Sign Up','listingpro'); ?></a></li>
						   
						</ul>
						 <a class="md-close" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></a>
						 
					</div>
					
				</div>
				<div class="modal-body">
					
					<div class="lp-border-radius-8 login-form-popup-outer">
						
						
						<div class="siginincontainer2">
							<?php if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) { ?>
							<ul class="social-login list-style-none">
								
									<li>
									<a id="logingoogle" class="google flaticon-googleplus" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;">
                                        <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('google_login'); ?>"></span>
                                        <span><?php esc_html_e('sign in With Google','listingpro'); ?></span>
									</a>
								</li>
							
								<li>
									<a id="loginfacebook" class="facebook flaticon-facebook" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
                                        <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('facebook_login'); ?>"></span>
                                        <span><?php esc_html_e('sign in With Facebook','listingpro'); ?></span>
									</a>
								</li>
							
								<li>
									<a id="logintwitter" class="twitter flaticon-twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter&redirect='+window.location.href; return false;">
                                        <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('twitter_login'); ?>"></span>
                                        <span><?php esc_html_e('sign in With Twitter','listingpro'); ?></span>
									</a>
								</li>
								
								
							</ul>
							<?php } ?>
							<div class="alterna text-center">
								<p><?php esc_html_e('Or','listingpro'); ?></p>
							</div>
							<form id="login" class="form-horizontal margin-top-30"  method="post">
								<p class="status"></p>
								<div class="form-group">
									<input type="text" class="form-control" id="lpusername" name="lpusername" placeholder="<?php esc_html_e('UserName/Email','listingpro'); ?>"/>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="lppassword" name="lppassword" placeholder="<?php esc_html_e('Password','listingpro'); ?>"/>
								</div>
							   
									<?php
									if($enableCaptchaLogin==true){ ?>
										 <div class="form-group">
										<?php if ( class_exists( 'cridio_Recaptcha' ) ){
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
												echo  '<div id="recaptcha-'.get_the_ID().'" class="g-recaptcha" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}?>
										</div>
								   <?php  }

									?>
								
								<div class="form-group">
									<div class="checkbox clearfix">
										<input id="check1" type="checkbox" name="remember" value="yes">
									   
										<a class="forgetPasswordClick pull-right" ><?php esc_html_e('Forgot Password','listingpro'); ?></a>
									</div>
								</div>

								<div class="form-group">
									<input type="submit" value="<?php esc_html_e('Sign in','listingpro'); ?>" class="lp-secondary-btn width-full btn-first-hover" />
								</div>
								<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
							</form>

						</div>
						<div class="siginupcontainer2">
							<?php if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) { ?>
							<ul class="social-login list-style-none">
								
								<li>
									<a id="logingoogle" class="google flaticon-googleplus" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;">
                                        <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('google_login'); ?>"></span>
                                        <span><?php esc_html_e('sign in With Google','listingpro'); ?></span>
									</a>
								</li>
							
							<li>
								<a id="loginfacebook" class="facebook flaticon-facebook" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
                                    <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('facebook_login'); ?>"></span>
                                    <span><?php esc_html_e('sign in With Facebook','listingpro'); ?></span>
								</a>
							</li>
							
								<li>
									<a id="logintwitter" class="twitter flaticon-twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginSocial=twitter&redirect='+window.location.href; return false;">
                                        <span class="lp-pop-icon-img"><img src="<?php echo listingpro_icons_url('twitter_login'); ?>"></span>
                                        <span><?php esc_html_e('sign in With Twitter','listingpro'); ?></span>
									</a>
								</li>
								
							   
							</ul>
							<?php } ?>
							<div class="alterna text-center">
								<p><?php esc_html_e('Or','listingpro'); ?></p>
							</div>
							<form id="register" class="form-horizontal margin-top-30"  method="post">
								<p class="status"></p>
								<div class="form-group">
								   
									<input type="text" class="form-control" id="username2" name="username"  placeholder="<?php esc_html_e('User name *','listingpro'); ?>"/>
								</div>
								<div class="form-group">
									
									<input type="email" class="form-control" id="email" name="email" placeholder="<?php esc_html_e('Email *','listingpro'); ?>"/>
								</div>
								<?php if($enablepassword==true){ ?>
									<div class="form-group">
										<input type="password" class="form-control" id="upassword" name="upassword" placeholder="<?php esc_html_e('Password *','listingpro'); ?>"/>
									</div>
								<?php } ?>
								<?php if($enablepassword==false){ ?>
									<div class="form-group">
										<p class="margin-bottom-0"><?php esc_html_e('Password will be e-mailed to you.','listingpro'); ?></p>
									</div>
								<?php } ?>
								
								<?php
									if(!empty($privacy_policy)){
											
										echo '
										<div class="checkbox form-group check_policy termpolicy pull-left termpolicy-wraper lp-appview-ppolicy">
											<input id="check_policy" type="checkbox" name="policycheck" value="true">
											<label for="check_policy"><a target="_blank" href="'.get_the_permalink($privacy_policy).'" class="help" target="_blank">'.esc_html__('I Agree', 'listingpro').'</a></label>
											<div class="help-text">
												<a class="help" target="_blank"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p>'.esc_html__('You agree you accept our Terms & Conditions for posting this ad.', 'listingpro').'</p>
												</div>
											</div>
										</div>';
									}
								?>
								
									<?php
									if($enableCaptcha==true){?>
										<div class="form-group">
									   <?php if ( class_exists( 'cridio_Recaptcha' ) ){
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
												echo  '<div id="recaptcha-'.get_the_ID().'" class="g-recaptcha" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}?>
										 </div>
								   <?php }

									?>
							   
								<div class="form-group">
									<input id="lp_usr_reg_btn" type="submit" value="<?php esc_html_e('Register','listingpro'); ?>" class="lp-secondary-btn width-full btn-first-hover" />
								</div>
								<?php wp_nonce_field( 'ajax-register-nonce', 'security2' ); ?>
							</form>

						</div>
						<div class="forgetpasswordcontainer2">
							<form class="form-horizontal margin-top-30" id="lp_forget_pass_form" action="#"  method="post">
								<p class="status"></p>
								<div class="form-group">
									<input type="email" name="user_login" class="form-control" id="email3" placeholder="<?php esc_html_e('Email','listingpro'); ?>"/>
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
						</div>
					</div>
				</div>
			</div>
		</div>

<?php } ?>