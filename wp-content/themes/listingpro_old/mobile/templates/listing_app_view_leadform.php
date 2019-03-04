
<?php
	global $listingpro_customizer_options, $post;
	$lead_form_customizer   =   'no';
	if( $listingpro_customizer_options && !empty( $listingpro_customizer_options ) )
	{
	    if( isset( $listingpro_customizer_options['form_builder']['active'] ) && $listingpro_customizer_options['form_builder']['active'] == 1 )
	    {
	        $lead_form_customizer   =   'yes';
	    }
	} 
	if( $lead_form_customizer == 'yes' )
	{
	    $lp_lead_form               =    get_post_meta( $post->ID, 'lp_lead_form', true );
	    $lead_form_user_dashboard   =    get_option('lead_form_user_dashboard');

	    if( !empty( $lp_lead_form ) && $lead_form_user_dashboard == 1 )
	    {
	        echo do_shortcode( $lp_lead_form );
	    }
	    else
	    {
	        $form_shortcode =   $listingpro_customizer_options['form_builder']['lead_form_code'];
	        if( empty( $form_shortcode ) )
	        {
	            echo do_shortcode( "[lead-form][lp-customizer-field type='text' name='name7' placeholder='Name:' class='myclass' label='Name'][lp-customizer-field type='email' name='email7' placeholder='Email:' class='myclass' label='Email'][lp-customizer-field type='text' name='phone7' placeholder='Phone:' class='myclass' label='Phone'][lp-customizer-field type='textarea' name='message7' placeholder='Message:' class='myclass' label='Message'][/lead-form]" );
	        }
	        else
	        {
	            echo do_shortcode( $form_shortcode );
	        }
	    }

	}else{ ?>
    <div class="contact-form quickform">
        <div class="user_text">
            <?php
            $author_avatar_url = get_user_meta(get_the_author_meta( 'ID' ), "listingpro_author_img_url", true);
            $avatar ='';
            if(!empty($author_avatar_url)) {
                $avatar =  $author_avatar_url;
            } else {
                $avatar_url = listingpro_get_avatar_url (get_the_author_meta( 'ID' ), $size = '94' );
                $avatar =  $avatar_url;
            }
            ?>
            <div class="author-img">
                <img src="<?php echo esc_url($avatar); ?>" alt="">
            </div>
            <div class="author-social">
                <div class="status">
                    <?php
                    $u_display_name = get_the_author_meta('display_name');
                    if(empty($u_display_name)){
                        $u_display_name = get_the_author_meta('nickname');
                    }
                    ?>
                    <span class="online"><a><?php echo $u_display_name; ?></a></span>
                </div>
                <ul class="social-icons post-socials">
                    <?php if(!empty($user_facebook)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_facebook); ?>">
                                <?php echo listingpro_icons('fbGrey'); ?>
                            </a>
                        </li>
                    <?php } if(!empty($user_google)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_google); ?>">
                                <?php echo listingpro_icons('googleGrey'); ?>
                            </a>
                        </li>
                    <?php } if(!empty($user_instagram)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_instagram); ?>">
                                <?php echo listingpro_icons('instaGrey'); ?>
                            </a>
                        </li>
                    <?php } if(!empty($user_twitter)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_twitter); ?>">
                                <?php echo listingpro_icons('tmblrGrey'); ?>
                            </a>
                        </li>
                    <?php } if(!empty($user_linkedin)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_linkedin); ?>">
                                <?php echo listingpro_icons('clinkedin'); ?>
                            </a>
                        </li>
                    <?php } if(!empty($user_pinterest)) { ?>
                        <li>
                            <a href="<?php echo esc_url($user_pinterest); ?>">
                                <?php echo listingpro_icons('cinterest'); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <form class="form-horizontal"  method="post" id="contactOwner">
            <?php
            $author_id = '';
            $author_email = '';
            $author_email = get_the_author_meta( 'user_email' );
            $author_id = get_the_author_meta( 'ID' );
            $gSiteKey = '';
            $gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
            $enableCaptcha = lp_check_receptcha('lp_recaptcha_lead');
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="name7" id="name7" placeholder="<?php esc_html_e('Name:','listingpro'); ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email7" id="email7" placeholder="<?php esc_html_e('Email:','listingpro'); ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php esc_html_e('Phone','listingpro'); ?>">
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" name="message7" id="message7" placeholder="<?php esc_html_e('Message:','listingpro'); ?>"></textarea>
            </div>
            <div class="form-group">
                <?php
                if($enableCaptcha==true){
                    if ( class_exists( 'cridio_Recaptcha' ) ){
                        if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
                            echo  '<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
                        }
                    }
                }
                ?>
            </div>
            <div class="form-group margin-bottom-0 pos-relative">
                <input type="submit" value="<?php esc_html_e('Send','listingpro'); ?>" class="lp-review-btn btn-second-hover">
                <input type="hidden" value="<?php the_ID(); ?>" name="post_id">
                <input type="hidden" value="<?php echo esc_attr($author_email); ?>" name="author_email">
                <input type="hidden" value="<?php echo esc_attr($author_id); ?>" name="author_id">
                <i class="lp-search-icon fa fa-send"></i>
            </div>
        </form>
    </div>
<?php } ?>
