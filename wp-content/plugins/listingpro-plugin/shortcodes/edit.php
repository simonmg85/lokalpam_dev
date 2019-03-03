<?php
ob_start();
/*------------------------------------------------------*/
/* Edit Listing
/*------------------------------------------------------*/
vc_map( array(
    "name"                      => __("Edit Listing", "js_composer"),
    "base"                      => 'listingpro_edit',
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
            'type'        => 'textfield',
            'heading'     => __( 'Subtitle', 'js_composer' ),
            'param_name'  => 'subtitle',
            'value'       => ''
        ),
    ),
) );
function listingpro_shortcode_edit($atts, $content = null) {

    extract(shortcode_atts(array(
        'title'   => '',
        'subtitle'   => ''
    ), $atts));

    do_action('lp_call_maps_scripts');
    global $listingpro_options;


    /* EDIT LIST */
    $lp_post ='';
    $form_field ='';
    $faqs ='';
    $faq ='';
    $faqans ='';
    $gAddress ='';
    $latitude ='';
    $longitude ='';
    $phone ='';
    $email ='';
    $website ='';
    $twitter ='';
    $facebook ='';
    $linkedin ='';
    $listingprice ='';
    $listingptext ='';
    $gPlus ='';
    $youtube ='';
    $instagram ='';
    $video ='';
    $gSiteKey = '';
    $gSiteKey = $listingpro_options['lp_recaptcha_site_key'];

    $singleLocMode = true;
    if( isset($listingpro_options['lp_listing_location_mode']) ){
        if($listingpro_options['lp_listing_location_mode']=="multi"){
            $singleLocMode = false;
        }
    }

    $singleCatMode = true;
    if( isset($listingpro_options['lp_listing_category_mode']) ){
        if($listingpro_options['lp_listing_category_mode']=="multi"){
            $singleCatMode = false;
        }
    }


    $lp_images_count = '555';
    $lp_images_size = '999999999999999999999999999999999999999999999999999';
    $lp_imagecount_notice = '';
    $lp_imagesize_notice = '';
    if(lp_theme_option('lp_listing_images_count_switch')=='yes'){
        $lp_images_count = lp_theme_option('lp_listing_images_counter');
        $lp_imagecount_notice= esc_html__("Max. allowed images are ", 'listingpro-plugin');
        $lp_imagecount_notice .= $lp_images_count;
    }
    if(lp_theme_option('lp_listing_images_size_switch')=='yes'){
        $lp_images_size = lp_theme_option('lp_listing_images_sizes');
        $lp_imagesize_notice= esc_html__('Max. allowed images size is ', 'listingpro-plugin');
        $lp_imagesize_notice .= $lp_images_size. esc_html__(' Mb', 'listingpro-plugin');
        $lp_images_size = $lp_images_size * 1000000;
    }


    $enableCaptcha = lp_check_receptcha('lp_recaptcha_listing_edit');
    if(isset($_GET['lp_post']) && !empty($_GET['lp_post'])){
        $lp_post = $_GET['lp_post'];
        //$form_field = listing_get_metabox_by_ID('form_field', $lp_post);
        $tagline_text = listing_get_metabox_by_ID('tagline_text',$lp_post);
        $faqs = listing_get_metabox_by_ID('faqs',$lp_post);
        if(!empty($faqs)){
            $faq =$faqs['faq'];
            $faqans =$faqs['faqans'];
        }
        $gAddress = listing_get_metabox_by_ID('gAddress',$lp_post);
        $latitude = listing_get_metabox_by_ID('latitude', $lp_post);
        $longitude = listing_get_metabox_by_ID('longitude',$lp_post);
        $plan_id = listing_get_metabox_by_ID('Plan_id',$lp_post);
        $phone = listing_get_metabox_by_ID('phone', $lp_post);
        $email = listing_get_metabox_by_ID('email', $lp_post);
        $website = listing_get_metabox_by_ID('website', $lp_post);
        $twitter = listing_get_metabox_by_ID('twitter', $lp_post);
        $facebook = listing_get_metabox_by_ID('facebook',$lp_post);
        $linkedin = listing_get_metabox_by_ID('linkedin', $lp_post);
        $gPlus = listing_get_metabox_by_ID('google_plus', $lp_post);
        $youtube = listing_get_metabox_by_ID('youtube', $lp_post);
        $instagram = listing_get_metabox_by_ID('instagram', $lp_post);
        $video = listing_get_metabox_by_ID('video', $lp_post);
        $listingprice = listing_get_metabox_by_ID('list_price', $lp_post);
        $price_status = listing_get_metabox_by_ID('price_status', $lp_post);
        /* by zaheer on 17 march */
        $listingptext = listing_get_metabox_by_ID('list_price_to', $lp_post);
        /* end by zaheer on 17 march */
        $metaFields = get_post_meta( $lp_post, 'lp_'.strtolower(THEMENAME).'_options_fields', true);
        $galleryImagesIDS = get_post_meta( $lp_post, 'gallery_image_ids', true);

        $lp_featured_img_url = get_the_post_thumbnail_url($lp_post,array(30, 30));

        if(!empty($plan_id)){
            $plan_id = $plan_id;
        }else{
            $plan_id = 'none';
        }

        $contact_show = get_post_meta( $plan_id, 'contact_show', true );
        $map_show = get_post_meta( $plan_id, 'map_show', true );
        $video_show = get_post_meta( $plan_id, 'video_show', true );
        $gallery_show = get_post_meta( $plan_id, 'gallery_show', true );
        $tagline_show = get_post_meta( $plan_id, 'listingproc_tagline', true );
        $location_show = get_post_meta( $plan_id, 'listingproc_location', true );
        $website_show = get_post_meta( $plan_id, 'listingproc_website', true );
        $social_show = get_post_meta( $plan_id, 'listingproc_social', true );
        $faqs_show = get_post_meta( $plan_id, 'listingproc_faq', true );
        $price_show = get_post_meta( $plan_id, 'listingproc_price', true );
        $tags_show = get_post_meta( $plan_id, 'listingproc_tag_key', true );
        $hours_show = get_post_meta( $plan_id, 'listingproc_bhours', true );
        if($plan_id=="none"){
            $contact_show = 'true';
            $map_show = 'true';
            $video_show = 'true';
            $gallery_show = 'true';
            $tagline_show = 'true';
            $location_show = 'true';
            $website_show = 'true';
            $social_show = 'true';
            $faqs_show = 'true';
            $price_show = 'true';
            $tags_show = 'true';
            $hours_show = 'true';
        }

    }else{
        wp_redirect( home_url() ); exit;

    }

    if(is_user_logged_in()){

        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $post_author_id = get_post_field( 'post_author', $lp_post );

        if($userID != $post_author_id) {
            wp_redirect( home_url() ); exit;
        }
    }else{
        wp_redirect( home_url() ); exit;
    }


    $current_cat= array();
    $formFields='';
    $term_id=array();
    $n=1;
    $current_cat_array = get_the_terms($lp_post, 'listing-category');
    if(!empty($current_cat_array)){
        foreach($current_cat_array as $current_catt) {
            $current_cat[$n] = $current_catt->term_id;
            $term_id[$n] = $current_catt->term_id;
            $n++;
        }
    }


    $n=1;
    $fieldIDs;
    $fieldIDss = array();
    $allIdsArray = array();
    if(!empty($term_id)){
        foreach($term_id as $tid) {
            $fieldIDss= listingpro_get_term_meta($tid,'fileds_ids');
            if(!empty($fieldIDss)){
                foreach($fieldIDss as $singlefId){
                    if(array_search($singlefId, $allIdsArray)){}else{
                        $lppoststatus = get_post_status( $singlefId );
                        if($lppoststatus=="publish"){
                            array_push($allIdsArray,$singlefId);
                        }
                    }
                }

            }
            $n++;
        }
    }
    $n=1;
    $allIdsArray = array_unique($allIdsArray);
    $fieldIDs[$n]= $allIdsArray;

    $formFieldsArray = array();
    if(!empty($fieldIDs)){
        foreach($fieldIDs as $fid) {
            $formFieldsArray[$n]= listingpro_field_type($fid);
            $n++;
        }
    }

    if(!empty($formFieldsArray)){
        foreach($formFieldsArray as $ffields){
            $formFields .= $ffields;
        }
    }


    $locations_type = $listingpro_options['lp_listing_locations_options'];
    $locArea = '';
    if(!empty($locations_type) && $locations_type=="auto_loc"){
        $locArea = $listingpro_options['lp_listing_locations_range'];
    }

    /* EDIT FORM OUTPUT */
    $page_style =   'style1';
    if( isset( $listingpro_options['listing_submit_page_style'] ) && !empty($listingpro_options['listing_submit_page_style']) )
    {
        $page_style =   $listingpro_options['listing_submit_page_style'];
    }
    $form_page_heading_style    =   '';
    $author_section_style2      =   '';
    $style2_content_class       =   'col-md-6';
    $upload_icon 				=	'';
    $style_wrap					=	'';
    $sidebar_sticky				=	'';
    $lp_submit_sidebar_top      =    '';

    if( $page_style == 'style2' )
    {
        $style2_content_class       =   'col-md-12';
        $form_page_heading_style    =   'form-page-heading_style2';
        $author_section_style2 =   'author-section-style2';
        $upload_icon				=	'<i class="fa fa-upload" aria-hidden="true"></i>';
        $style_wrap					=	'lp-style-wrap-border';
        $sidebar_sticky				=	'lp-submit-sidebar-sticky';
    }
    if(is_user_logged_in() && $page_style == 'style2' ){
        $lp_submit_sidebar_top  =    '33px';
    }

    $quicktip_title = get_template_directory_uri() .'/assets/images/quick-tip/title.png';
    $quicktip_adress = get_template_directory_uri() .'/assets/images/quick-tip/contact.png';
    $quicktip_cat = get_template_directory_uri() .'/assets/images/quick-tip/cat-sub.png';
    $quicktip_price = get_template_directory_uri() .'/assets/images/quick-tip/price.png';
    $quicktip_faq = get_template_directory_uri() .'/assets/images/quick-tip/faq.png';
    $quicktip_video = get_template_directory_uri() .'/assets/images/quick-tip/video.png';
    $quicktip_gallery = get_template_directory_uri() .'/assets/images/quick-tip/gallery.png';
    $quicktip_desc = get_template_directory_uri() .'/assets/images/quick-tip/desc.png';
    $quicktip_biz = get_template_directory_uri() .'/assets/images/quick-tip/biz.png';

    $output = null;

    $output .= '
	<div class="page-container-four clearfix submit_new_style submit_new_style-outer">
		<div class="col-md-12 col-sm-12">
			<div class="form-page-heading test '. $form_page_heading_style .'">
				<h3>'.$title.'</h3>
				<p>'.$subtitle.'</p>
			</div>
			<div class="post-submit">
				<div class="author-section border-bottom lp-form-row clearfix lp-border-bottom padding-bottom-40">
					<div class="lp-form-row-left text-left pull-left not-logged-in-msg">
						<img class="avatar-circle" src="'.plugins_url( '/images/author.jpg', dirname(__FILE__) ).'" />
						<p>'.esc_html__('You are currently signed in as', 'listingpro-plugin').' <strong>'.listingpro_author_name().',</strong> <a href="'.wp_logout_url(esc_url(home_url('/'))).'" class="">'.esc_html__('Sign out', 'listingpro-plugin').'</a> ' .esc_html__('or continue below and start submission.', 'listingpro-plugin').'</p>
					</div>
				</div>';
    $pcontent= '';	$page_data = get_page($lp_post); 	$pcontent = $page_data->post_content;	//$pcontent = get_the_content($lp_post);

    $quickTipTitle = $listingpro_options['quick_tip_title'];
    $quickTipText = $listingpro_options['quick_tip_text'];
    $submitImg = $listingpro_options['submit_ad_img']['url'];
    $submitImg1 = $listingpro_options['submit_ad_img1']['url'];
    $submitImg2 = $listingpro_options['submit_ad_img2']['url'];
    $submitImg3 = $listingpro_options['submit_ad_img3']['url'];

    /* Submit Fields ON/OFF */
    $listing_title_text = $listingpro_options['listing_title_text'];
    $listingCityText = $listingpro_options['listing_city_text'];
    $listingGaddText = $listingpro_options['listing_gadd_text'];
    $listingGaddcustomText = $listingpro_options['listing_custom_cordn'];
    $addressSwitch = $listingpro_options['lp_showhide_address'];
    $phoneSwitch = $listingpro_options['phone_switch'];
    $listingPhText = $listingpro_options['listing_ph_text'];
    $webSwitch = $listingpro_options['web_switch'];
    $listingWebText = $listingpro_options['listing_web_text'];
    $ophSwitch = $listingpro_options['oph_switch'];
    $listing_cat_text = $listingpro_options['listing_cat_text'];
    $listing_features_text = $listingpro_options['listing_features_text'];
    $currencySwitch = $listingpro_options['currency_switch'];
    $listingCurrText = $listingpro_options['listing_curr_text'];
    $digitPriceSwitch = $listingpro_options['digit_price_switch'];
    $listingDigitText = $listingpro_options['listing_digit_text'];
    $priceSwitch = $listingpro_options['price_switch'];
    $listingPriceText = $listingpro_options['listing_price_text'];
    $listing_desc_text = $listingpro_options['listing_desc_text'];
    $faq_switch = $listingpro_options['faq_switch'];
    $listing_faq_text = $listingpro_options['listing_faq_text'];
    $listing_faq_tabs_text = $listingpro_options['listing_faq_tabs_text'];
    $twSwitch = $listingpro_options['tw_switch'];
    $fbSwitch = $listingpro_options['fb_switch'];
    $lnkSwitch = $listingpro_options['lnk_switch'];
    $googleSwitch = $listingpro_options['google_switch'];
    $ytSwitch = $listingpro_options['yt_switch'];
    $instaSwitch = $listingpro_options['insta_switch'];
    $tags_switch = $listingpro_options['tags_switch'];
    $listingTagsText = $listingpro_options['listing_tags_text'];
    $vdoSwitch = $listingpro_options['vdo_switch'];
    $listingVdoText = $listingpro_options['listing_vdo_text'];
    $fileSwitch = $listingpro_options['file_switch'];
    $listingEmailText = $listingpro_options['listing_email_text'];

    $submit_ad_img_switch = $listingpro_options['submit_ad_img_switch'];
    $submit_ad_img1_switch = $listingpro_options['submit_ad_img1_switch'];
    $submit_ad_img2_switch = $listingpro_options['submit_ad_img2_switch'];
    $submit_ad_img3_switch = $listingpro_options['submit_ad_img3_switch'];
    $quick_tip_switch = $listingpro_options['quick_tip_switch'];

    $listing_btn_text = $listingpro_options['listing_edit_btn_text'];
    $showLocation = $listingpro_options['location_switch'];

    $btnText = '';
    if(!empty($listing_btn_text)) {
        $btnText = $listing_btn_text;
    }else {
        $btnText = esc_html__('Update & Preview', 'listingpro-plugin');
    }


    $output .='<div class="clearfix"></div>
				<form method="post" enctype=multipart/form-data id="lp-submit-form" name="lp-submit-form" data-imgcount="'.$lp_images_count.'" data-imgsize="'.$lp_images_size.'" data-countnotice="'.$lp_imagecount_notice.'" data-sizenotice="'.$lp_imagesize_notice.'">';

    if( $page_style == 'style2' )
    {
        $output .=  '<div class="row">';
        $output .=  '<div class="col-md-8 page-style2-content-wrap">';
    }
    if( $page_style == 'style2' )
    {
        $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
        $output .=  '<h4 class="white-section-heading">'. esc_html__( 'primary liting details', 'listingpro' ) .'</h4>';
        $output .=  '   <div class="row">';
        $output .='
								<div class="form-group col-md-12">
									<label for="usr">'.$listing_title_text.' <small>*</small></label>
									<div class="help-text">
										<a href="#" class="help"><i class="fa fa-question"></i></a>
										<div class="help-tooltip">
											<p>'.esc_html__('Put your listing title here and tell the name of your business to the world.', 'listingpro-plugin').'</p>
										</div>
									</div>
									<input data-quick-tip="<h2>Title</h2><p>Enter your complete business name for when people who know your business by name and are looking you up.</p><img src='.$quicktip_title.'>" type="text" value="'.get_the_title($lp_post).'" name="postTitle" class="form-control" id="lptitle">
								</div>';
        if($tagline_show == "true"){
            $output .='
                                    <div class="form-group col-md-12">
                                        <input data-quick-tip="<h2>Tagline</h2><p>For businesses, taglines are of importance as they help business convey what they want to do and their goals to the customers.</p><img src='.$quicktip_title.'>" type="text" name="tagline_text" value="'.$tagline_text.'" class="form-control" id="lptagline" placeholder="' .esc_html__('Tagline Example: Best Express Mexican Grill', 'listingpro-plugin').'">									
                                    </div>';
        }
        if($addressSwitch==1)
        {
            $output .='
                                <div class="form-group '.$style2_content_class.' col-xs-12 col-md-12">
                                    <div class="lp-coordinates">
                                        <a data-type="gaddress" class="btn-link googleAddressbtn active">'.esc_html__('Search By Google', 'listingpro-plugin').'</a>
                                        <a data-type="gaddresscustom" class="btn-link googleAddressbtn">'.esc_html__('Manual Coordinates', 'listingpro-plugin').'</a>';
            if((is_ssl()) || (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))){
                $output .='
                                            <a data-type="gaddresscustom" class="btn-link googledroppin" data-toggle="modal" data-target="#modal-doppin"><i class="fa fa-map-pin"></i> '.esc_html__('Drop Pin', 'listingpro-plugin').'</a>';
            }
            $output .='
                                    </div>
                                    
                                    <label for="inputAddress" class="googlefulladdress">'.$listingGaddText.'</label>
                                    
                                    <div class="help-text googlefulladdress">
                                        <a href="#" class="help"><i class="fa fa-question"></i></a>
                                        <div class="help-tooltip">
                                            <p>'.esc_html__('Start typing and select your google location from google suggestions. This is for the map and also for locating your business.', 'listingpro-plugin').'</p>
                                        </div>
                                    </div>
                                    
                                    <input data-quick-tip="<h2>Full Address</h2><p>Provide your full address for your business to show up on the map and your customer can get direction.</p><img src='.$quicktip_adress.'>" value="'.$gAddress.'" type="text" class="form-control" name="gAddress" id="inputAddress" placeholder="'.esc_html__('Your address for google map', 'listingpro-plugin').'">
                                    <div class="lp-custom-lat clearfix">
                                    <label for="inputAddress">'.$listingGaddcustomText.'</label>
                                        <input value="'.$gAddress.'" type="text" class="form-control" name="gAddresscustom" id="inputAddresss" placeholder="'.esc_html__('Add address here', 'listingpro-plugin').'">
                                        <div class="row hiddenlatlong">
                                            <div class="col-md-6 col-xs-6">
                                                <label for="latitude">'.esc_html__('Latitude', 'listingpro-plugin').'</label>
                                                <input class="form-control" value="'.$latitude.'" type="hidden" id="latitude" name="latitude">
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <label for="longitude">'.esc_html__('Longitude', 'listingpro-plugin').'</label>
                                                <input class="form-control" value="'.$longitude.'" type="hidden" id="longitude" name="longitude">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                ';
        }
        if($showLocation=="1" && $location_show == "true"){
            if( !empty($locations_type)&& $locations_type=="auto_loc" ){
                if($singleLocMode==true){
                    $output .='
										<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
											<label for="inputTags">'.$listingCityText.'</label>
											<div class="help-text">
												<a href="#" class="help"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
												</div>
											</div>';

                    $current_loc ='';
                    $current_loc_array = get_the_terms($lp_post, 'location');
                    if(!empty($current_loc_array)){
                        foreach($current_loc_array as $current_locc) {
                            $current_loc = $current_locc->name;
                        }
                    }

                    $output .='
														<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'" value="'.$current_loc.'">	
														<input type="hidden" name="location" value="'.$current_loc.'">
												';

                    $output .='
										</div>';
                }else{

                    /* for google multiloation */
                    $output .='<div class="form-group lp-selected-locs clearfix col-md-12">';
                    $current_loc = array();
                    $current_loc_array = get_the_terms($lp_post, 'location');
                    if(!empty($current_loc_array)){
                        foreach($current_loc_array as $current_locc) {
                            $current_loc[] = $current_locc->term_id;
                        }
                    }
                    $args = array(
                        'post_type' => 'listing',
                        'order' => 'ASC',
                        'parent' => 0,
                        'hide_empty' => false,
                    );
                    $locations = get_terms( 'location',$args);
                    foreach($locations as $location) {

                        if(!empty($current_loc)){
                            foreach($current_loc as $cloc){
                                if($location->term_id == $cloc){
                                    $output .=	'<div class="lpsinglelocselected '.$location->name.'">'.$location->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$location->name.'"></div>';
                                }
                            }
                        }

                        $argsChild = array(
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'hierarchical' => false,
                            'parent' => $location->term_id,
                        );
                        $childLocs = get_terms('location', $argsChild);
                        if(!empty($childLocs)){
                            foreach($childLocs as $childLoc) {

                                if(!empty($current_loc)){
                                    foreach($current_loc as $cloc){
                                        if($childLoc->term_id == $cloc){
                                            $output .=	'<div class="lpsinglelocselected '.$childLoc->name.'">'.$childLoc->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLoc->name.'"></div>';
                                        }
                                    }
                                }



                                $argsChildof = array(
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'hierarchical' => false,
                                    'parent' => $childLoc->term_id,
                                );
                                $childLocsof = get_terms('location', $argsChildof);
                                if(!empty($childLocsof)){
                                    foreach($childLocsof as $childLocof) {

                                        if(!empty($current_loc)){
                                            foreach($current_loc as $cloc){
                                                if($childLocof->term_id == $cloc){
                                                    $output .=	'<div class="lpsinglelocselected '.$childLocof->name.'">'.$childLocof->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLocof->name.'"></div>';
                                                }
                                            }
                                        }



                                    }

                                }


                            }
                        }



                    }

                    $output .='</div>';
                    $output .='
													<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
													<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'"></div>	
											';
                    /* end for google multiloation */

                }
            }
            elseif( !empty($locations_type)&& $locations_type=="manual_loc" ){

                $output .='
									<div class="form-group '.$style2_content_class.' col-xs-12 lp-new-cat-wrape">
										<label for="inputTags">'.$listingCityText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
											</div>
										</div>';

                if($singleLocMode==true){
                    $output .='<select data-quick-tip="<h2>City</h2><p>Provide your city name for your business to show up on the map and your customer can get direction.</p><img src='.$quicktip_adress.'>" autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5">';
                }else{
                    $output .='<select data-quick-tip="<h2>City</h2><p>Provide your city name for your business to show up on the map and your customer can get direction.</p><img src='.$quicktip_adress.'>" autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5"  multiple="multiple">';
                }
                $output .=	'<option value="">'.esc_html__('Select Location', 'listingpro-plugin').'</option>';
                $current_loc = array();
                $current_loc_array = get_the_terms($lp_post, 'location');
                if(!empty($current_loc_array)){
                    foreach($current_loc_array as $current_locc) {
                        $current_loc[] = $current_locc->term_id;
                    }
                }
                $args = array(
                    'post_type' => 'listing',
                    'order' => 'ASC',
                    'parent' => 0,
                    'hide_empty' => false,
                );
                $locations = get_terms( 'location',$args);
                foreach($locations as $location) {
                    $selected = '';
                    if(!empty($current_loc)){
                        foreach($current_loc as $cloc){
                            if($location->term_id == $cloc){
                                $selected = 'selected';
                            }
                        }
                    }

                    $output .=	'<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';

                    $argsChild = array(
                        'order' => 'ASC',
                        'hide_empty' => false,
                        'hierarchical' => false,
                        'parent' => $location->term_id,
                    );
                    $childLocs = get_terms('location', $argsChild);
                    if(!empty($childLocs)){
                        foreach($childLocs as $childLoc) {
                            $selected = '';
                            if(!empty($current_loc)){
                                foreach($current_loc as $cloc){
                                    if($childLoc->term_id == $cloc){
                                        $selected = 'selected';
                                    }
                                }
                            }

                            $output .=	'<option '. $selected.' value="'.$childLoc->term_id.'">-&nbsp;'.$childLoc->name.'</option>';

                            $argsChildof = array(
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'hierarchical' => false,
                                'parent' => $childLoc->term_id,
                            );
                            $childLocsof = get_terms('location', $argsChildof);
                            if(!empty($childLocsof)){
                                foreach($childLocsof as $childLocof) {

                                    $selected = '';
                                    if(!empty($current_loc)){
                                        foreach($current_loc as $cloc){
                                            if($childLocof->term_id == $cloc){
                                                $selected = 'selected';
                                            }
                                        }
                                    }

                                    $output .=	'<option '. $selected.' value="'.$childLocof->term_id.'">--&nbsp;'.$childLocof->name.'</option>';

                                }

                            }


                        }
                    }



                }
                $output .='
											</select>';
                $output .='
									</div>';

            }
        }
        if($phoneSwitch == 1) {
            if($contact_show=="true"){
                $output .='
									<div class="form-group '.$style2_content_class.' col-xs-12">
										<label for="inputPhone">'.esc_html__('Phone', 'listingpro-plugin').'</label>
										<input data-quick-tip="<h2>Phone</h2><p>Local phone numbers drive 3x more calls than toll-free numbers. Always use a business phone number and avoid personal phone numbers if possible.</p><img src='.$quicktip_adress.'>" value="'.$phone.'" type="text" class="form-control" name="phone" id="inputPhone" placeholder="'.esc_html__('Your contact number', 'listingpro-plugin').'">
									</div>';
            }
        }
        if($webSwitch == 1 && $website_show=="true") {
            $output .='
								<div class="form-group '.$style2_content_class.' col-xs-12">
									<label for="inputWebsite">'.esc_html__('Website', 'listingpro-plugin').'</label>
									<input data-quick-tip="<h2>Website</h2><p>Its recommended to provide official website url and avoid landing pages designed for a specific campaign</p><img src='.$quicktip_adress.'>" value="'.$website.'" type="text" class="form-control" name="website" id="inputWebsite" placeholder="'.esc_html__('Your web URL', 'listingpro-plugin').'">
								</div>';
        }
        $output .=  '   </div>';
        $output .=  '</div>';

        $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
        $output .=  '<h4 class="white-section-heading">'. esc_html__( 'category & services', 'listingpro' ) .'</h4>';
        $output .=  '   <div class="row">';
        $output .='
								<div class="form-group clearfix margin-bottom-0 lp-new-cat-wrape">
									<label for="inputCategory">'.$listing_cat_text.' <small>*</small></label>';
        if($singleCatMode==true){

            $output .='
										<select data-quick-tip="<h2>Categories</h2><p>The more specific you get with your categories, the better. You do still want to stay relevant to your business, though. If you ever choose to run ads campaign, your ad will be shown on those categories you select.</p><img src='.$quicktip_cat.'>" autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5">';

        }else{
            $output .='
										<select data-quick-tip="<h2>Categories</h2><p>The more specific you get with your categories, the better. You do still want to stay relevant to your business, though. If you ever choose to run ads campaign, your ad will be shown on those categories you select.</p><img src='.$quicktip_cat.'>" autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5" multiple="multiple">';
        }
        $output .='<option value="">'.esc_html__('Select Category', 'listingpro-plugin').'</option>';
        $args = array(
            'post_type' => 'listing',
            'order' => 'ASC',
            'hide_empty' => false,
            'parent' => 0,
        );
        $categories = get_terms( 'listing-category',$args);
        if(!empty($categories)){
            foreach($categories as $category) {
                $doAjax = false;
                $doAjax = lp_category_has_features($category->term_id);
                $selected = '';
                foreach($current_cat as $cid){
                    if($category->term_id == $cid){
                        $selected = 'selected';
                    }
                }

                $output .=	'<option data-doajax="'.$doAjax.'" '.$selected.' value="'.$category->term_id.'">'.$category->name.'</option>';

                $argscatChild = array(
                    'order' => 'ASC',
                    'hide_empty' => false,
                    'hierarchical' => false,
                    'parent' => $category->term_id,

                );

                $childCats = get_terms('listing-category', $argscatChild);
                if(!empty($childCats)){

                    foreach ( $childCats as $subID ) {
                        $doAjax = false;
                        $doAjax = lp_category_has_features($subID->term_id);
                        $selected = '';
                        foreach($current_cat as $cid){
                            if($subID->term_id == $cid){
                                $selected = 'selected';
                            }
                        }
                        $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subID->term_id.'">-&nbsp;&nbsp;'.$subID->name.'</option>';

                        $childCatsof = array(
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'hierarchical' => false,
                            'parent' => $subID->term_id,
                        );
                        $childofCats = get_terms('listing-category', $childCatsof);
                        if(!empty($childofCats)){
                            foreach ( $childofCats as $subIDD ) {
                                $doAjax = false;
                                $doAjax = lp_category_has_features($subIDD->term_id);
                                $selected = '';
                                foreach($current_cat as $cid){
                                    if($subIDD->term_id == $cid){
                                        $selected = 'selected';
                                    }
                                }
                                $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDD->term_id.'">--&nbsp;&nbsp;'.$subIDD->name.'</option>';

                                $childCatsoff = array(
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'hierarchical' => false,
                                    'parent' => $subIDD->term_id,
                                );
                                $childofCatss = get_terms('listing-category', $childCatsoff);

                                if(!empty($childofCatss)){
                                    foreach ( $childofCatss as $subIDDD ) {
                                        $doAjax = false;
                                        $doAjax = lp_category_has_features($subIDDD->term_id);
                                        $selected = '';
                                        foreach($current_cat as $cid){
                                            if($subIDDD->term_id == $cid){
                                                $selected = 'selected';
                                            }
                                        }
                                        $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDDD->term_id.'">---&nbsp;&nbsp;'.$subIDDD->name.'</option>';


                                    }
                                }
                            }


                        }


                    }
                }
            }
        }
        $output .='
									</select>
								</div>';
        $output .=  '   </div>';
        $output .=  '</div>';

        $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
        $output .=  '   <div class="row col-md-12">';
        $output .=  listingpro_get_term_openfields(false);
        $output .='<div class="form-group clearfix lpfeatures_fields">';
        $features;
        $featuresArr;
        $nofeatures = true;
        $fcount = 1;
        if(!empty($current_cat_array)){
            $totalTms = count($current_cat);
        }
        $uniqueTermIds = array();
        foreach($current_cat as $cid){
            $features= listingpro_get_term_meta($cid,'lp_category_tags');
            if(!empty($features)){

                $output .='
											<label for="inputTags" class="featuresBycat">'.$listing_features_text.'</label><br>
											<div class="pre-load"></div>
											<div class="featuresDataContainer row clearfix lp-nested" id="tags-by-cat">';

                $nofeatures = false;
                $cheched = '';
                foreach($features as $feature){
                    $terms = get_term_by('id', $feature, 'features');
                    if(!empty($terms)){
                        if (array_key_exists("$terms->term_id",$uniqueTermIds)){}else{
                            $uniqueTermIds[$terms->term_id] = $terms->term_id;
                            if(!empty($metaFields['lp_feature'])){
                                if (in_array($feature, $metaFields['lp_feature'])) {
                                    $cheched =  "checked";
                                }else{
                                    $cheched = '';
                                }
                            }

                            $output .='<div class="col-md-2 col-sm-4 col-xs-6"><div class="checkbox pad-bottom-10"><input '.$cheched.'  id="check_'.$terms->term_id.'" type="checkbox" name="lp_form_fields_inn[lp_feature][]" value="'.$terms->term_id.'" ><label for="check_'.$terms->term_id.'">'.$terms->name.'</label></div></div>
													';
                        }
                    }
                }


            }
        }

        $output .='</div>';
        if($nofeatures==true){
            $output .='
								<div class="form-group clearfix">
									<div class="pre-load"></div>
									<div class="featuresDataContainer lp-nested row" id="tags-by-cat"></div>	
									<div class="featuresDataContainer lp-nested row" id="features-by-cat"></div>
								</div>';
        }

        if(!empty($formFields)){
            $output .='
								<div class="featuresDataContainer row clearfix lp-nested" id="features-by-cat">';
            $output .= '<label for="inputTags" class="featuresBycat">'.esc_html__('Additional Business Info', 'listingpro-plugin').'</label>';
            $output .= $formFields;
            $output	.='
								</div>';
        }
        $output .=  '   </div>';
        $output .=  '</div>';

        $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
        $output .=  '<h4 class="white-section-heading">'. esc_html__( 'price details', 'listingpro' ) .'</h4>';
        $output .=  '   <div class="row">';
        if($currencySwitch == 1) {
            $lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
            $lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
            $lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
            $lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
            $priceyArray = array(
                'notsay' => esc_html__('Not to say', 'listingpro-plugin'),
                'inexpensive' => esc_html__('Inexpensive', 'listingpro-plugin'),
                'moderate' => esc_html__('Moderate', 'listingpro-plugin'),
                'pricey' => esc_html__('Pricey', 'listingpro-plugin'),
                'ultra_high_end'  => esc_html__('Ultra High', 'listingpro-plugin'),
            );


            $output .='
									<div class="col-md-4 clearfix">
										<label for="listingptext">'.$listingCurrText.'</label>
										<select data-quick-tip="<h2>Price Range</h2><p>Setting a price range can help attract the right targeted audience and will avoid any awkward situations for both customers and the owner.</p><img src='.$quicktip_price.'>" id="price_status" name="price_status" class="chosen-select chosen-select7  postsubmitSelect" tabindex="5">
											';
            foreach($priceyArray as $key => $value){
                if($price_status == $key){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                if($key == 'notsay'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$value.'</option>';
                }elseif($key == 'inexpensive'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol.' - '.$value.'</option>';
                }elseif($key == 'moderate'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol2.' - '.$value.'</option>';
                }elseif($key == 'pricey'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol3.' - '.$value.'</option>';
                }elseif($key == 'ultra_high_end'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol4.' - '.$value.'</option>';
                }
            }
            $output .='
										</select>
									</div>';
        }
        if($price_show == "true"){
            if($digitPriceSwitch == 1) {
                $output .='
										<div class="col-md-4">
											<label for="listingprice">'.$listingDigitText.'</label>
											<input data-quick-tip="<h2>Price From</h2><p>Being honest with your customers can build a strong relationship. Dont hesitate to include.</p><img src='.$quicktip_price.'>" value="'.$listingprice.'" type="text" name="listingprice" class="form-control" id="listingprice" placeholder="'.esc_html__('Only Digits', 'listingpro-plugin').'">
										</div>';
            }
            if($priceSwitch == 1) {
                $output .='
										<div class="col-md-4">
											<label for="listingptext">'.$listingPriceText.'</label>
											<input data-quick-tip="<h2>Price To</h2><p>Being honest with your customers can build a strong relationship. Dont hesitate to include.</p><img src='.$quicktip_price.'>" value="'.$listingptext.'" type="text" name="listingptext" class="form-control" id="listingptext" placeholder="'.esc_html__('Price To', 'listingpro-plugin').'">
										</div>';
            }
        }
        $output .=  '   </div>';
        $output .=  '</div>';


        if ($ophSwitch == 1 && $hours_show == "true")
        {
            $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
            $output .=  '<h4 class="white-section-heading bussin-top" data-quick-tip="<h2>Business Hours</h2><p>You dont want your customers to stop by when you are closed so always try to keep your hour up to date. Keeping your store closed when your business indicate its open on the directory could lead to a negative review.</p><img src='.$quicktip_biz.'>">'. esc_html__( 'business hours', 'listingpro' ) .'</h4>';
            $output .=  '   <div class="row">';
            $output .= '        <div class="form-group clearfix margin-bottom-0 col-md-12">';
            $output .=              LP_operational_hours_form($lp_post, true);
            $output .= '        </div>';
            $output .=  '   </div>';
            $output .=  '</div>';

        }
        if ($social_show == "true")
        {
            if ($twSwitch == 1) {$output .=  '<input value="'. $twitter .'" type="hidden" class="form-control" name="twitter" id="inputTwitter">';}
            if ($fbSwitch == 1) {$output .=  '<input value="'. $facebook .'" type="hidden" class="form-control" name="facebook" id="inputFacebook">';}
            if ($lnkSwitch == 1) {$output .=  '<input value="'. $linkedin .'" type="hidden" class="form-control" name="linkedin" id="inputLinkedIn">';}
            if ($googleSwitch == 1) {$output .=  '<input value="'. $gPlus .'" type="hidden" class="form-control" name="google_plus" id="inputGooglePlus">';}
            if ($ytSwitch == 1) {$output .=  '<input value="'. $youtube .'" type="hidden" class="form-control" name="youtube" id="inputYoutube">';}
            if ($instaSwitch == 1) {$output .=  '<input value="'. $instagram .'" type="hidden" class="form-control" name="instagram" id="inputInstagram">';}

            $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
            $output .=  '<h4 class="white-section-heading">'. esc_html__( 'social media', 'listingpro' ) .'</h4>';
            $output .=  '   <div class="row">';
            $output .=  '       <div class="style2-social-list-section">';

            if ($twSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-Twitter"><label>Twitter</label><span>'. $twitter .'</span><a class="remove-social-type" data-social="Twitter"><i class="fa fa-times"></i></a></div>';
            }
            if ($fbSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-Facebook"><label>Facebook</label><span>'. $facebook .'</span><a class="remove-social-type" data-social="Facebook"><i class="fa fa-times"></i></a></div>';
            }
            if ($lnkSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-LinkedIn"><label>LinkedIn</label><span>'. $linkedin .'</span><a class="remove-social-type" data-social="LinkedIn"><i class="fa fa-times"></i></a></div>';
            }
            if ($googleSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-Google-Plus"><label>Google Plus</label><span>'. $gPlus .'</span><a class="remove-social-type" data-social="Google Plus"><i class="fa fa-times"></i></a></div>';
            }
            if ($ytSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-Youtube"><label>Youtube</label><span>'. $youtube .'</span><a class="remove-social-type" data-social="Youtube"><i class="fa fa-times"></i></a></div>';
            }
            if ($instaSwitch == 1)
            {
                $output .=  '<div class="social-row social-row-Instagram"><label>Instagram</label><span>'. $instagram .'</span><a class="remove-social-type" data-social="Instagram"><i class="fa fa-times"></i></a></div>';
            }

            $output .=  '</div>';


            $output .=  '<div class="style2-add-new-social-sec">';
            $output .=  '    <div class="col-md-2">'.esc_html__( 'Select', 'listingpro' ).'</div>';
            $output .=  '    <div class="col-md-3">';
            $output .=  '       <select data-quick-tip="<h2>Social Media</h2><p>Being honest with your customers can build a strong relationship. Dont hesitate to include.</p><img src='.$quicktip_price.'>" class="select2" id="get_media"><option>'. esc_html__( 'Please Select', 'listingpro' ) .'</option>';
            if ($instaSwitch == 1) {$output .=  '<option>' . esc_html__('Instagram', 'listingpro-plugin') . '</option>';}
            if ($ytSwitch == 1) {$output .=  '<option>' . esc_html__('Youtube', 'listingpro-plugin') . '</option>';}
            if ($googleSwitch == 1) {$output .=  '<option>' . esc_html__('Google Plus', 'listingpro-plugin') . '</option>';}
            if ($lnkSwitch == 1) {$output .=  '<option>' . esc_html__('LinkedIn', 'listingpro-plugin') . '</option>';}
            if ($fbSwitch == 1) {$output .=  '<option>' . esc_html__('Facebook', 'listingpro-plugin') . '</option>';}
            if ($twSwitch == 1) {$output .=  '<option>' . esc_html__('Twitter', 'listingpro-plugin') . '</option>';}
            $output .=  '       </select>';
            $output .=  '    </div>';
            $output .=  '    <div class="col-md-6">';
            $output .=  '       <input type="text" class="form-control" value="" id="get_media_url">';
            $output .=  '    </div>';
            $output .=  '    <div class="col-md-1"><a id="add-new-social-url"><i class="fa fa-plus-square"></i></a></div>';
            $output .=  '</div>';


            $output .=  '    </div>';
            $output .=  '</div>';
        }
        if($faq_switch == 1 && $faqs_show == "true")
        {
            $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
            $output .=  '<h4 class="white-section-heading">'. esc_html__( 'frequently asked questions', 'listingpro' ) .'</h4>';
            $output .=  '   <div class="row">';

            $output .='        <div class="form-group clearfix margin-bottom-0">
										        <div id="tabs" class="lsiting-submit-faq-tabs clearfix" data-faqtitle="'.$listing_faq_text.'">';
            $FaqHasData = false;
            if(!empty($faq) && !empty($faqans)){
                foreach($faq as $faqData){
                    if($faqData==""){}else{
                        $FaqHasData = true;
                    }
                }
            }
            if($FaqHasData==true){

                $n=count($faq);
                if($n>1){
                    $j=1;

                    while($j <= $n){
                        $faqQ =$faq[$j];
                        if(!empty($faqQ)){
                            $output .='
                                                                                    <div id="tabs-'.$j.'">
                                                                                        <div class="col-md-2">
                                                                                            <label for="inpuFaqsLp">'.$listing_faq_text.'</label>
                                                                                        </div>
                                                                                        <div class="col-md-10">
                                                                                            <div class="form-group">
                                                                                                <input data-quick-tip="<h2>FAQ</h2><p>Share some of the most asked question and answers so they know you are serious about your business and truly care for your customers.</p><img src='.$quicktip_faq.'>" type="text" class="form-control" placeholder="'.esc_html__('Questions', 'listingpro-plugin').'" name="faq['.$j.']" id="inpuFaqsLp'.$j.'" value="'.$faq[$j].'">
                                                                                                <br>
                                                                                                <textarea data-quick-tip="<h2>FAQ Answers</h2><p>Share some of the most asked question and answers so they know you are serious about your business and truly care for your customers.</p><img src='.$quicktip_faq.'>" class="form-control" placeholder="'.esc_html__('Answer', 'listingpro-plugin').'" name="faqans['.$j.']" rows="8" id="inputDescriptionFaq'.$j.'">'.$faqans[$j].'</textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';
                        }
                        $j++;
                    }
                }else {
                    $output .='
                                                                            <div id="tabs-1">
                                                                                <div class="col-md-2">
                                                                                    <label for="inpuFaqsLp">'.$listing_faq_text.'</label>
                                                                                    <input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>';
                }
                $output.='
                                                                        <div class="btn-container faq-btns clearfix">	
                                                                            <ul>';
                if( is_array($faq) && count($faq)>1 ){
                    $word = preg_replace('/\d/', '', $listing_faq_tabs_text );
                    $i=1;
                    foreach ($faq as $q){
                        if(!empty($q)){
                            $output .='<li><a  data-faq-text="'.$listing_faq_tabs_text.'" href="#tabs-'.$i.'">'.$word.' '.$i.'</a></li>';
                            $i++;
                        }
                    }
                }
                else{
                    $output .='<li><a href="#tabs-1"  data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>';
                }
                $output .='
                                                                            </ul>
                                                                            
                                                                        </div>';
            }else{

                $output.='
                                                                        <div class="btn-container faq-btns clearfix">	
                                                                            <ul>
                                                                                <li><a href="#tabs-1" data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>
                                                                            </ul>
                                                                            <a id="tabsbtn" class="lp-secondary-btn btn-first-hover style2-tabsbtn"><i class="fa fa-plus-square"></i> add new</a>
                                                                        </div>
                                                                        ';

                $output .='
                                                        
                                                                        
                                                                            <div id="tabs-1">
                                                                                <div class="form-group">
                                                                                    <label for="inpuFaqsLp">'.$listing_faq_text.'</label>
                                                                                    <input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
                                                                                </div>
                                                                        </div>';
            }
            $output .=  '            </div>';
            $output .=  '      </div>';
            $output .=  '    </div>';
            $output .=  '</div>';
        }



        $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
        $output .=  '<h4 class="white-section-heading description-tip" data-quick-tip="<h2>Description</h2><p>Tell briefly what your customers what to hear about your business has to offer that is unique and you do better then everyone else.</p><img src='.$quicktip_desc.'>">'. esc_html__( 'more info', 'listingpro' ) .'</h4>';
        $output .=  '   <div class="row">';
        $output .='
								<div class="form-group clearfix col-md-12">
									<label for="inputDescription">'.$listing_desc_text.' <small>*</small></label>'. get_textarea_as_editor('inputDescription', 'postContent', $pcontent) .'
								</div>';
        if($tags_switch == 1 && $tags_show=="true" ) {
            $output .='
								<div class="form-group col-md-12 col-xs-12 lp-social-area">
									<div class="form-group col-md-12 col-xs-12" style="padding:0px;">
										<label for="inputTags">'.$listingTagsText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('These keywords or tags will help your listing to find in search. Add a comma separated list of keywords related to your business.', 'listingpro-plugin').'</p>
											</div>
										</div>
										<textarea class="form-control" name="tags" id="inputTags" placeholder="'.esc_html__('Enter tags or keywords comma separated...', 'listingpro-plugin').'">';
            $tags = get_the_terms($lp_post, 'list-tags');
            if ( $tags and ! is_wp_error($tags) ){
                $names = wp_list_pluck($tags ,'name');
                $output .= implode(',', $names);
            }
            $output .=	'
										</textarea>
									</div>
								</div>';
        }
        $output .=  '    </div>';
        $output .=  '</div>';


        $featuredimageshow = true;
        if($video_show=="true" || $gallery_show=="true" || $featuredimageshow==true)
        {
            $output .= '<div class="white-section border-bottom ' . $style_wrap . '">';
            $output .=  '<h4 class="white-section-heading">'. esc_html__( 'media', 'listingpro' ) .'</h4>';
            $output .=  '   <div class="row">';
            if($vdoSwitch == 1) {
                if($video_show=="true"){
                    $output .='
										<div class="form-group clearfix col-md-12">
											<label for="postVideo">'.esc_html__('Video ', 'listingpro-plugin').'<span>'.esc_html__('(Optional)', 'listingpro-plugin').'</span></label>
											<input data-quick-tip="<h2>Video</h2><p>Take it to next level and provide more details about what you have to offer. Select all that applies to you.</p><img src='.$quicktip_video.'>" type="text" value="'.$video.'" class="form-control" name="postVideo" id="postVideo" placeholder="'.esc_html__('ex: https://youtu.be/lY2yjAdbvdQ', 'listingpro-plugin').'">
										</div>';
                }
            }
            if($fileSwitch == 1) {
                if($gallery_show=="true"){
                    $output .='
										<div class="form-group clearfix margin-bottom-0 lp-img-gall-upload-section col-md-12" data-quick-tip="<h2>Gallery</h2><img src='.$quicktip_gallery.'>">
											<div class="col-sm-12 padding-left-0 padding-right-0">
												<label for="postVideo">'.esc_html__('Images ', 'listingpro-plugin').'</label>	
												<div class="jFiler-input-dragDrop pos-relative">
													<div class="jFiler-input-inner">
														<div class="jFiler-input-icon">
															<i class="icon-jfi-cloud-up-o"></i>
														</div>
															<div class="jFiler-input-text">
															<h3 style="margin:20px 0px;">'.$upload_icon.''.esc_html__('Drop files here or click to upload', 'listingpro-plugin').'</h3>
															
														</div>
														<a class="jFiler-input-choose-btn blue">'.esc_html__('Browse Files', 'listingpro-plugin').'</a>
														<div class="filediv">
															<input type="file" name="listingfiles[]" id="lpFIleGalleryy" multiple>
														</div>';
                    $galleryImagesIDS = explode( ',', $galleryImagesIDS );
                    if(!empty($galleryImagesIDS)){
                        $output.= '<div id="filedivd">';
                        foreach($galleryImagesIDS as $galID){
                            $imgFull = wp_get_attachment_image_src( $galID, 'thumbnail');
                            if(!empty($imgFull[0])){
                                $output.= '									
																		<ul class="jFiler-items-list jFiler-items-grid grid1">
																			<li class="jFiler-item">	
																				<div class="jFiler-item-container">
																					<div class="jFiler-item-inner">		
																						<div class="jFiler-item-thumb">
																							<img src="'. $imgFull[0] .'" alt="post1" />
																						</div>		
																					</div>		
																				</div>
																				<a class="icon-jfi-trash jFiler-item-trash-action"><i class="fa fa-trash"></i></a>	
																				<input name="" calss="lpFIleGalleryyg" multiple="multiple" value="'.$galID.'" type="hidden">
																			</li>
																		</ul>';
                            }
                        }

                        $output .= '</div>';
                    }
                    $output .=	'
													</div>
												</div>
											</div>
										</div>';
                }
            }


            /* to show preview of featured image */

            if( isset($lp_featured_img_url) && !empty($lp_featured_img_url) ){

            }
            $output .='
									<div class="form-group col-md-12 clearfix margin-bottom-0 margin-top-30 lp-listing-featuredimage lp-featur-st">';

            if( isset($lp_featured_img_url) && !empty($lp_featured_img_url) ){
                $output .='	
									<label class="margin-top-10">'.esc_html__('Change Featured Image', 'listingpro-plugin').'</label>';
            }else{
                $output .='	
									<label class="margin-top-10">'.esc_html__('Upload Featured Image', 'listingpro-plugin').'</label>';
            }

            $output .='
								
									<div class="custom-file margin-top-15">
										<input style="display:none;" type="file" name="lp-featuredimage[]" id="lp-featuredimage" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" />
										<label data-quick-tip="<h2>Featured Image</h2><img src='.$quicktip_gallery.'>" class="featured-img-label" for="lp-featuredimage"><p>'.esc_html__('Browse', 'listingpro-plugin').'</p><span>'.esc_html__('Choose a file', 'listingpro-plugin').'&hellip;</span></label>
									</div>
								
								';
            $output .=  '        </div>';

            $b_logo =   $listingpro_options['business_logo_switch'];
            if( $b_logo == 1 ) {
                $output .= '<div class="form-group col-md-12 clearfix margin-bottom-0 margin-top-30 lp-listing-featuredimage lp-featur-st">
									<label class="margin-top-10">' . esc_html__('Upload Business Logo', 'listingpro-plugin') . '</label>
									
									<div class="custom-file">
										<input style="display:none;" type="file" name="business_logo[]" id="business_logo" class="inputfile inputfile-4" />
										<label class="b-logo-img-label" for="business_logo"><p>' . esc_html__('Browser', 'listingpro-plugin') . '</p><span>' . esc_html__('Choose a file', 'listingpro-plugin') . '&hellip;</span></label>
									</div>
								</div>';
            }

            $output .=  '    </div>';
            $output .=  '</div>';
        }
    }
    else
    {
        $output .=	'<div class="white-section border-bottom '.$style_wrap.'">
						<div class="row">
							<div class="form-group '. $style2_content_class .' col-xs-12">';
        if($quick_tip_switch == 1 && $page_style != 'style2' ) {
            $output .='
									<div class="quick_tip">
										<h2>'. $quickTipTitle .'</h2>
										<p>'. $quickTipText .'</p>
									</div>';
        }
        $output .='
								<div class="form-group">
									<label for="usr">'.$listing_title_text.' <small>*</small></label>
									<div class="help-text">
										<a href="#" class="help"><i class="fa fa-question"></i></a>
										<div class="help-tooltip">
											<p>'.esc_html__('Put your listing title here and tell the name of your business to the world.', 'listingpro-plugin').'</p>
										</div>
									</div>
									<input data-quick-tip="<p>this is test data for quick tip for title field</p>'.$quicktip_image.'" type="text" value="'.get_the_title($lp_post).'" name="postTitle" class="form-control" id="lptitle">
								</div>';
        if($tagline_show == "true"){
            $output .='
									<div class="form-group">
										<input data-quick-tip="<p>this is test data for quick tip for tagline field</p>'.$quicktip_image.'" type="text" name="tagline_text" value="'.$tagline_text.'" class="form-control" id="lptagline" placeholder="' .esc_html__('Tagline Example: Best Express Mexican Grill', 'listingpro-plugin').'">									
									</div>';
        }
        $output .='
							</div>';
        if( $page_style != 'style2' )
        {
            $output .=  '<div class="form-group col-md-6 col-xs-12">';
            if($submit_ad_img_switch == 1) {
                $output .='
									<div class="submit-img">
										<img src="'. $submitImg .'" alt="">
									</div>';
            }
            $output .='
							</div>';
        }


        $output .=  '</div>
						<div class="row">';
        if($showLocation=="1" && $location_show == "true"){
            if( !empty($locations_type)&& $locations_type=="auto_loc" ){
                if($singleLocMode==true){
                    $output .='
										<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
											<label for="inputTags">'.$listingCityText.'</label>
											<div class="help-text">
												<a href="#" class="help"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
												</div>
											</div>';

                    $current_loc ='';
                    $current_loc_array = get_the_terms($lp_post, 'location');
                    if(!empty($current_loc_array)){
                        foreach($current_loc_array as $current_locc) {
                            $current_loc = $current_locc->name;
                        }
                    }

                    $output .='
														<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'" value="'.$current_loc.'">	
														<input type="hidden" name="location" value="'.$current_loc.'">
												';

                    $output .='
										</div>';
                }else{

                    /* for google multiloation */
                    $output .='<div class="form-group lp-selected-locs clearfix col-md-12">';
                    $current_loc = array();
                    $current_loc_array = get_the_terms($lp_post, 'location');
                    if(!empty($current_loc_array)){
                        foreach($current_loc_array as $current_locc) {
                            $current_loc[] = $current_locc->term_id;
                        }
                    }
                    $args = array(
                        'post_type' => 'listing',
                        'order' => 'ASC',
                        'parent' => 0,
                        'hide_empty' => false,
                    );
                    $locations = get_terms( 'location',$args);
                    foreach($locations as $location) {

                        if(!empty($current_loc)){
                            foreach($current_loc as $cloc){
                                if($location->term_id == $cloc){
                                    $output .=	'<div class="lpsinglelocselected '.$location->name.'">'.$location->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$location->name.'"></div>';
                                }
                            }
                        }

                        $argsChild = array(
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'hierarchical' => false,
                            'parent' => $location->term_id,
                        );
                        $childLocs = get_terms('location', $argsChild);
                        if(!empty($childLocs)){
                            foreach($childLocs as $childLoc) {

                                if(!empty($current_loc)){
                                    foreach($current_loc as $cloc){
                                        if($childLoc->term_id == $cloc){
                                            $output .=	'<div class="lpsinglelocselected '.$childLoc->name.'">'.$childLoc->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLoc->name.'"></div>';
                                        }
                                    }
                                }



                                $argsChildof = array(
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'hierarchical' => false,
                                    'parent' => $childLoc->term_id,
                                );
                                $childLocsof = get_terms('location', $argsChildof);
                                if(!empty($childLocsof)){
                                    foreach($childLocsof as $childLocof) {

                                        if(!empty($current_loc)){
                                            foreach($current_loc as $cloc){
                                                if($childLocof->term_id == $cloc){
                                                    $output .=	'<div class="lpsinglelocselected '.$childLocof->name.'">'.$childLocof->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLocof->name.'"></div>';
                                                }
                                            }
                                        }



                                    }

                                }


                            }
                        }



                    }

                    $output .='</div>';
                    $output .='
													<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
													<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'"></div>	
											';
                    /* end for google multiloation */

                }
            }
            elseif( !empty($locations_type)&& $locations_type=="manual_loc" ){

                $output .='
									<div class="form-group '.$style2_content_class.' col-xs-12 lp-new-cat-wrape">
										<label for="inputTags">'.$listingCityText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
											</div>
										</div>';

                if($singleLocMode==true){
                    $output .='<select data-quick-tip="<p>this is test data for quick tip for location field</p>'.$quicktip_image.'" autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5">';
                }else{
                    $output .='<select data-quick-tip="<p>this is test data for quick tip for location field</p>'.$quicktip_image.'" autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5"  multiple="multiple">';
                }
                $output .=	'<option value="">'.esc_html__('Select Location', 'listingpro-plugin').'</option>';
                $current_loc = array();
                $current_loc_array = get_the_terms($lp_post, 'location');
                if(!empty($current_loc_array)){
                    foreach($current_loc_array as $current_locc) {
                        $current_loc[] = $current_locc->term_id;
                    }
                }
                $args = array(
                    'post_type' => 'listing',
                    'order' => 'ASC',
                    'parent' => 0,
                    'hide_empty' => false,
                );
                $locations = get_terms( 'location',$args);
                foreach($locations as $location) {
                    $selected = '';
                    if(!empty($current_loc)){
                        foreach($current_loc as $cloc){
                            if($location->term_id == $cloc){
                                $selected = 'selected';
                            }
                        }
                    }

                    $output .=	'<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';

                    $argsChild = array(
                        'order' => 'ASC',
                        'hide_empty' => false,
                        'hierarchical' => false,
                        'parent' => $location->term_id,
                    );
                    $childLocs = get_terms('location', $argsChild);
                    if(!empty($childLocs)){
                        foreach($childLocs as $childLoc) {
                            $selected = '';
                            if(!empty($current_loc)){
                                foreach($current_loc as $cloc){
                                    if($childLoc->term_id == $cloc){
                                        $selected = 'selected';
                                    }
                                }
                            }

                            $output .=	'<option '. $selected.' value="'.$childLoc->term_id.'">-&nbsp;'.$childLoc->name.'</option>';

                            $argsChildof = array(
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'hierarchical' => false,
                                'parent' => $childLoc->term_id,
                            );
                            $childLocsof = get_terms('location', $argsChildof);
                            if(!empty($childLocsof)){
                                foreach($childLocsof as $childLocof) {

                                    $selected = '';
                                    if(!empty($current_loc)){
                                        foreach($current_loc as $cloc){
                                            if($childLocof->term_id == $cloc){
                                                $selected = 'selected';
                                            }
                                        }
                                    }

                                    $output .=	'<option '. $selected.' value="'.$childLocof->term_id.'">--&nbsp;'.$childLocof->name.'</option>';

                                }

                            }


                        }
                    }



                }
                $output .='
											</select>';
                $output .='
									</div>';

            }
        }
        if($addressSwitch==1)
        {
            $output .='
                                <div class="form-group '.$style2_content_class.' col-xs-12">
                                    <div class="lp-coordinates">
                                        <a data-type="gaddress" class="btn-link googleAddressbtn active">'.esc_html__('Search By Google', 'listingpro-plugin').'</a>
                                        <a data-type="gaddresscustom" class="btn-link googleAddressbtn">'.esc_html__('Manual Coordinates', 'listingpro-plugin').'</a>';
            if((is_ssl()) || (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))){
                $output .='
                                            <a data-type="gaddresscustom" class="btn-link googledroppin" data-toggle="modal" data-target="#modal-doppin"><i class="fa fa-map-pin"></i> '.esc_html__('Drop Pin', 'listingpro-plugin').'</a>';
            }
            $output .='
                                    </div>

                                    <label for="inputAddress" class="googlefulladdress">'.$listingGaddText.'</label>

                                    <div class="help-text googlefulladdress">
                                        <a href="#" class="help"><i class="fa fa-question"></i></a>
                                        <div class="help-tooltip">
                                            <p>'.esc_html__('Start typing and select your google location from google suggestions. This is for the map and also for locating your business.', 'listingpro-plugin').'</p>
                                        </div>
                                    </div>

                                    <input data-quick-tip="<p>this is test data for quick tip for address field</p>'.$quicktip_image.'" value="'.$gAddress.'" type="text" class="form-control" name="gAddress" id="inputAddress" placeholder="'.esc_html__('Your address for google map', 'listingpro-plugin').'">
                                    <div class="lp-custom-lat clearfix">
                                    <label for="inputAddress">'.$listingGaddcustomText.'</label>
                                        <input value="'.$gAddress.'" type="text" class="form-control" name="gAddresscustom" id="inputAddresss" placeholder="'.esc_html__('Add address here', 'listingpro-plugin').'">
                                        <div class="row hiddenlatlong">
                                            <div class="col-md-6 col-xs-6">
                                                <label for="latitude">'.esc_html__('Latitude', 'listingpro-plugin').'</label>
                                                <input class="form-control" value="'.$latitude.'" type="hidden" id="latitude" name="latitude">
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <label for="longitude">'.esc_html__('Longitude', 'listingpro-plugin').'</label>
                                                <input class="form-control" value="'.$longitude.'" type="hidden" id="longitude" name="longitude">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                    <div class="row">';
        }

        if($phoneSwitch == 1) {
            if($contact_show=="true"){
                $output .='
									<div class="form-group '.$style2_content_class.' col-xs-12">
										<label for="inputPhone">'.esc_html__('Phone', 'listingpro-plugin').'</label>
										<input data-quick-tip="<p>this is test data for quick tip for phone field</p>'.$quicktip_image.'" value="'.$phone.'" type="text" class="form-control" name="phone" id="inputPhone" placeholder="'.esc_html__('Your contact number', 'listingpro-plugin').'">
									</div>';
            }
        }
        if($webSwitch == 1 && $website_show=="true") {
            $output .='
								<div class="form-group '.$style2_content_class.' col-xs-12">
									<label for="inputWebsite">'.esc_html__('Website', 'listingpro-plugin').'</label>
									<input data-quick-tip="<p>this is test data for quick tip for website field</p>'.$quicktip_image.'" value="'.$website.'" type="text" class="form-control" name="website" id="inputWebsite" placeholder="'.esc_html__('Your web URL', 'listingpro-plugin').'">
								</div>';
        }
        $output .='
						</div>
					</div>
					<div class="white-section border-bottom '.$style_wrap.'">
						<div class="row">
							<div class="form-group '. $style2_content_class .' col-xs-12">';
        if($ophSwitch == 1 && $hours_show=="true") {
            $output .='
									<div class="form-group clearfix margin-bottom-0">';
            $output	.= LP_operational_hours_form($lp_post,true);
            $output	.='
									</div>';
        }
        $output .='
								<div class="form-group clearfix margin-bottom-0 lp-new-cat-wrape">
									<label for="inputCategory">'.$listing_cat_text.' <small>*</small></label>';
        if($singleCatMode==true){

            $output .='
										<select autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5">';

        }else{
            $output .='
										<select autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5" multiple="multiple">';
        }
        $output .='<option value="">'.esc_html__('Select Category', 'listingpro-plugin').'</option>';
        $args = array(
            'post_type' => 'listing',
            'order' => 'ASC',
            'hide_empty' => false,
            'parent' => 0,
        );
        $categories = get_terms( 'listing-category',$args);
        if(!empty($categories)){
            foreach($categories as $category) {
                $doAjax = false;
                $doAjax = lp_category_has_features($category->term_id);
                $selected = '';
                foreach($current_cat as $cid){
                    if($category->term_id == $cid){
                        $selected = 'selected';
                    }
                }

                $output .=	'<option data-doajax="'.$doAjax.'" '.$selected.' value="'.$category->term_id.'">'.$category->name.'</option>';

                $argscatChild = array(
                    'order' => 'ASC',
                    'hide_empty' => false,
                    'hierarchical' => false,
                    'parent' => $category->term_id,

                );

                $childCats = get_terms('listing-category', $argscatChild);
                if(!empty($childCats)){

                    foreach ( $childCats as $subID ) {
                        $doAjax = false;
                        $doAjax = lp_category_has_features($subID->term_id);
                        $selected = '';
                        foreach($current_cat as $cid){
                            if($subID->term_id == $cid){
                                $selected = 'selected';
                            }
                        }
                        $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subID->term_id.'">-&nbsp;&nbsp;'.$subID->name.'</option>';

                        $childCatsof = array(
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'hierarchical' => false,
                            'parent' => $subID->term_id,
                        );
                        $childofCats = get_terms('listing-category', $childCatsof);
                        if(!empty($childofCats)){
                            foreach ( $childofCats as $subIDD ) {
                                $doAjax = false;
                                $doAjax = lp_category_has_features($subIDD->term_id);
                                $selected = '';
                                foreach($current_cat as $cid){
                                    if($subIDD->term_id == $cid){
                                        $selected = 'selected';
                                    }
                                }
                                $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDD->term_id.'">--&nbsp;&nbsp;'.$subIDD->name.'</option>';

                                $childCatsoff = array(
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'hierarchical' => false,
                                    'parent' => $subIDD->term_id,
                                );
                                $childofCatss = get_terms('listing-category', $childCatsoff);

                                if(!empty($childofCatss)){
                                    foreach ( $childofCatss as $subIDDD ) {
                                        $doAjax = false;
                                        $doAjax = lp_category_has_features($subIDDD->term_id);
                                        $selected = '';
                                        foreach($current_cat as $cid){
                                            if($subIDDD->term_id == $cid){
                                                $selected = 'selected';
                                            }
                                        }
                                        $output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDDD->term_id.'">---&nbsp;&nbsp;'.$subIDDD->name.'</option>';


                                    }
                                }
                            }


                        }


                    }
                }
            }
        }
        $output .='
									</select>
								</div>';
        $output .='
							</div>';
        if( $page_style != 'style2' )
        {
            $output .=  '<div class="form-group col-md-6 col-xs-12">';
            if($submit_ad_img1_switch == 1) {
                $output .='
									<div class="submit-img">
										<img src="'. $submitImg1 .'" alt="">
									</div>';
            }
            $output .='
							</div>';
        }

        $output .= listingpro_get_term_openfields(false);
        $output .='
						</div>';
        $output .='
							<div class="form-group clearfix lpfeatures_fields">';
        $features;
        $featuresArr;
        $nofeatures = true;
        $fcount = 1;
        if(!empty($current_cat_array)){
            $totalTms = count($current_cat);
        }
        $uniqueTermIds = array();
        foreach($current_cat as $cid){
            $features= listingpro_get_term_meta($cid,'lp_category_tags');
            if(!empty($features)){

                $output .='
											<label for="inputTags" class="featuresBycat">'.$listing_features_text.'</label><br>
											<div class="pre-load"></div>
											<div class="featuresDataContainer row clearfix lp-nested" id="tags-by-cat">';

                $nofeatures = false;
                $cheched = '';
                foreach($features as $feature){
                    $terms = get_term_by('id', $feature, 'features');
                    if(!empty($terms)){
                        if (array_key_exists("$terms->term_id",$uniqueTermIds)){}else{
                            $uniqueTermIds[$terms->term_id] = $terms->term_id;
                            if(!empty($metaFields['lp_feature'])){
                                if (in_array($feature, $metaFields['lp_feature'])) {
                                    $cheched =  "checked";
                                }else{
                                    $cheched = '';
                                }
                            }

                            $output .='<div class="col-md-2 col-sm-4 col-xs-6"><div class="checkbox pad-bottom-10"><input '.$cheched.'  id="check_'.$terms->term_id.'" type="checkbox" name="lp_form_fields_inn[lp_feature][]" value="'.$terms->term_id.'" ><label for="check_'.$terms->term_id.'">'.$terms->name.'</label></div></div>
													';
                        }
                    }
                }


            }
        }

        $output .='
							</div>';

        if($nofeatures==true){
            $output .='
								<div class="form-group clearfix">
									<div class="pre-load"></div>
									<div class="featuresDataContainer lp-nested row" id="tags-by-cat"></div>	
									<div class="featuresDataContainer lp-nested row" id="features-by-cat"></div>
								</div>';
        }

        if(!empty($formFields)){
            $output .='
								<div class="featuresDataContainer row clearfix lp-nested" id="features-by-cat">';
            $output .= '<label for="inputTags" class="featuresBycat">'.esc_html__('Additional Business Info', 'listingpro-plugin').'</label>';
            $output .= $formFields;
            $output	.='
								</div>';
        }
        $output .='
							</div>';

        $output .='
						<div class="form-group clearfix">
							<div class="row">';
        if($currencySwitch == 1) {
            $lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
            $lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
            $lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
            $lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
            $priceyArray = array(
                'notsay' => esc_html__('Not to say', 'listingpro-plugin'),
                'inexpensive' => esc_html__('Inexpensive', 'listingpro-plugin'),
                'moderate' => esc_html__('Moderate', 'listingpro-plugin'),
                'pricey' => esc_html__('Pricey', 'listingpro-plugin'),
                'ultra_high_end'  => esc_html__('Ultra High', 'listingpro-plugin'),
            );


            $output .='
									<div class="col-md-4 clearfix">
										<label for="listingptext">'.$listingCurrText.'</label>
										<select id="price_status" name="price_status" class="chosen-select chosen-select7  postsubmitSelect" tabindex="5">
											';
            foreach($priceyArray as $key => $value){
                if($price_status == $key){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                if($key == 'notsay'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$value.'</option>';
                }elseif($key == 'inexpensive'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol.' - '.$value.'</option>';
                }elseif($key == 'moderate'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol2.' - '.$value.'</option>';
                }elseif($key == 'pricey'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol3.' - '.$value.'</option>';
                }elseif($key == 'ultra_high_end'){
                    $output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol4.' - '.$value.'</option>';
                }
            }
            $output .='
										</select>
									</div>';
        }
        if($price_show == "true"){
            if($digitPriceSwitch == 1) {
                $output .='
										<div class="col-md-4">
											<label for="listingprice">'.$listingDigitText.'</label>
											<input value="'.$listingprice.'" type="text" name="listingprice" class="form-control" id="listingprice" placeholder="'.esc_html__('Only Digits', 'listingpro-plugin').'">
										</div>';
            }
            if($priceSwitch == 1) {
                $output .='
										<div class="col-md-4">
											<label for="listingptext">'.$listingPriceText.'</label>
											<input value="'.$listingptext.'" type="text" name="listingptext" class="form-control" id="listingptext" placeholder="'.esc_html__('Price To', 'listingpro-plugin').'">
										</div>';
            }
        }
        $output .='
							</div>
						</div>
					</div>
					<div class="white-section border-bottom '.$style_wrap.'">
						<div class="row">
							<div class="form-group '. $style2_content_class .' col-xs-12">';
        $output .='
								<div class="form-group clearfix">
									<label for="inputDescription">'.$listing_desc_text.' <small>*</small></label>'. get_textarea_as_editor('inputDescription', 'postContent', $pcontent) .'
								</div>';
        if($faq_switch == 1 && $faqs_show=="true") {
            $output .='
									<div class="form-group clearfix margin-bottom-0">
										<div id="tabs" class="clearfix" data-faqtitle="'.$listing_faq_text.'">
										
										';

            $FaqHasData = false;

            if(!empty($faq) && !empty($faqans)){
                foreach($faq as $faqData){
                    if($faqData==""){}else{
                        $FaqHasData = true;
                    }
                }
            }


            if($FaqHasData==true){

                $n=count($faq);
                if($n>1){
                    $j=1;

                    while($j <= $n){
                        $faqQ =$faq[$j];
                        if(!empty($faqQ)){
                            $output .='
															<div id="tabs-'.$j.'">
																<div class="form-group">
																	<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
																	<input data-quick-tip="<p>this is test data for quick tip for faq field</p>'.$quicktip_image.'" type="text" class="form-control" placeholder="'.esc_html__('Questions', 'listingpro-plugin').'" name="faq['.$j.']" id="inpuFaqsLp'.$j.'" value="'.$faq[$j].'">
																</div>
																<div class="form-group">
																	<textarea class="form-control" placeholder="'.esc_html__('Answer', 'listingpro-plugin').'" name="faqans['.$j.']" rows="8" id="inputDescriptionFaq'.$j.'">'.$faqans[$j].'</textarea>
																</div>
															</div>';
                        }
                        $j++;
                    }
                }else {
                    $output .='
													<div id="tabs-1">
														<div class="form-group">
															<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
															<input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
														</div>
														<div class="form-group">
															<textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
														</div>
												  	</div>';
                }
                $output.='
												<div class="btn-container faq-btns clearfix">	
												  	<ul>';
                if( is_array($faq) && count($faq)>1 ){
                    $word = preg_replace('/\d/', '', $listing_faq_tabs_text );
                    $i=1;
                    foreach ($faq as $q){
                        if(!empty($q)){
                            $output .='<li><a  data-faq-text="'.$listing_faq_tabs_text.'" href="#tabs-'.$i.'">'.$word.' '.$i.'</a></li>';
                            $i++;
                        }
                    }
                }
                else{
                    $output .='<li><a href="#tabs-1"  data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>';
                }
                $output .='
													</ul>
												  	
											 	</div>';
            }else{

                $output.='
												<div class="btn-container faq-btns clearfix">	
													<ul>
														<li><a href="#tabs-1" data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>
													</ul>
												  	<a id="tabsbtn" class="lp-secondary-btn btn-first-hover">+</a>
												</div>
												';

                $output .='
								
												
													<div id="tabs-1">
														<div class="form-group">
															<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
															<input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
														</div>
														<div class="form-group">
															<textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
														</div>
											 	</div>';
            }
            $output .='
									  	</div>
									</div>';
        }
        $output .='
							</div>';
        if( $page_style !=  'style2' )
        {
            $output .=  '<div class="form-group col-md-6 col-xs-12">';
            if($submit_ad_img2_switch == 1) {
                $output .='
									<div class="submit-img">
										<img src="'. $submitImg2 .'" alt="">
									</div>';
            }
            $output .='
							</div>';
        }

        $output    .=  '</div>
						<div class="row">
							<div class="form-group col-md-12 col-xs-12 lp-social-area">';
        if($social_show=="true"){
            if($twSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputTwitter">'.esc_html__('Twitter', 'listingpro-plugin').'</label>
										<input value="'.$twitter.'" type="text" class="form-control" name="twitter" id="inputTwitter" placeholder="'.esc_html__('Your Twitter URL', 'listingpro-plugin').'">
									</div>';
            }
            if($fbSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputFacebook">'.esc_html__('Facebook', 'listingpro-plugin').'</label>
										<input value="'.$facebook.'" type="text" class="form-control" name="facebook" id="inputFacebook" placeholder="'.esc_html__('Your Facebook URL', 'listingpro-plugin').'">
									</div>';
            }
            if($lnkSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputLinkedIn">'.esc_html__('LinkedIn', 'listingpro-plugin').'</label>
										<input value="'.$linkedin.'" type="text" class="form-control" name="linkedin" id="inputLinkedIn" placeholder="'.esc_html__('Your LinkedIn URL', 'listingpro-plugin').'">
									</div>';
            }
            if($googleSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputGooglePlus">'.esc_html__('Google Plus', 'listingpro-plugin').'</label>
										<input value="'.$gPlus.'" type="text" class="form-control" name="google_plus" id="inputGooglePlus" placeholder="'.esc_html__('Your Google Plus URL', 'listingpro-plugin').'">
									</div>';
            }
            if($ytSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputYoutube">'.esc_html__('Youtube', 'listingpro-plugin').'</label>
										<input value="'.$youtube.'" type="text" class="form-control" name="youtube" id="inputYoutube" placeholder="'.esc_html__('Your Youtube URL', 'listingpro-plugin').'">
									</div>';
            }
            if($instaSwitch == 1) {
                $output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputInstagram">'.esc_html__('Instagram', 'listingpro-plugin').'</label>
										<input value="'.$instagram.'" type="text" class="form-control" name="instagram" id="inputInstagram" placeholder="'.esc_html__('Your Instagram URL', 'listingpro-plugin').'">
									</div>';
            }
        }
        $output .='
							</div>';
        if($tags_switch == 1 && $tags_show=="true" ) {
            $output .='
								<div class="form-group col-md-12 col-xs-12 lp-social-area">
									<div class="form-group col-md-12 col-xs-12" style="padding:0px;">
										<label for="inputTags">'.$listingTagsText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('These keywords or tags will help your listing to find in search. Add a comma separated list of keywords related to your business.', 'listingpro-plugin').'</p>
											</div>
										</div>
										<textarea class="form-control" name="tags" id="inputTags" placeholder="'.esc_html__('Enter tags or keywords comma separated...', 'listingpro-plugin').'">';
            $tags = get_the_terms($lp_post, 'list-tags');
            if ( $tags and ! is_wp_error($tags) ){
                $names = wp_list_pluck($tags ,'name');
                $output .= implode(',', $names);
            }
            $output .=	'
										</textarea>
									</div>
								</div>';
        }
        $output .='
						</div>
					</div>';
        $featuredimageshow = true;
        if($video_show=="true" || $gallery_show=="true" || $featuredimageshow==true){
            $output .='
					<div class="white-section border-bottom '.$style_wrap.'">
						<div class="row">
							<div class="form-group '. $style2_content_class .' col-xs-12">';
            if($vdoSwitch == 1) {
                if($video_show=="true"){
                    $output .='
										<div class="form-group clearfix">
											<label for="postVideo">'.esc_html__('Video ', 'listingpro-plugin').'<span>'.esc_html__('(Optional)', 'listingpro-plugin').'</span></label>
											<input data-quick-tip="<p>this is test data for quick tip for video field</p>'.$quicktip_image.'" type="text" value="'.$video.'" class="form-control" name="postVideo" id="postVideo" placeholder="'.esc_html__('ex: https://youtu.be/lY2yjAdbvdQ', 'listingpro-plugin').'">
										</div>';
                }
            }
            if($fileSwitch == 1) {
                if($gallery_show=="true"){
                    $output .='
										<div class="form-group clearfix margin-bottom-0 lp-img-gall-upload-section">
											<div class="col-sm-12 padding-left-0 padding-right-0">
												<label for="postVideo">'.esc_html__('Images ', 'listingpro-plugin').'</label>	
												<div class="jFiler-input-dragDrop pos-relative">
													<div class="jFiler-input-inner">
														<div class="jFiler-input-icon">
															<i class="icon-jfi-cloud-up-o"></i>
														</div>
															<div class="jFiler-input-text">
															<h3 style="margin:20px 0px;">'.$upload_icon.''.esc_html__('Drop files here or click to upload', 'listingpro-plugin').'</h3>
															
														</div>
														<a class="jFiler-input-choose-btn blue">'.esc_html__('Browse Files', 'listingpro-plugin').'</a>
														<div class="filediv">
															<input type="file" name="listingfiles[]" id="lpFIleGalleryy" multiple>
														</div>';
                    $galleryImagesIDS = explode( ',', $galleryImagesIDS );
                    if(!empty($galleryImagesIDS)){
                        $output.= '<div id="filedivd">';
                        foreach($galleryImagesIDS as $galID){
                            $imgFull = wp_get_attachment_image_src( $galID, 'thumbnail');
                            if(!empty($imgFull[0])){
                                $output.= '									
																		<ul class="jFiler-items-list jFiler-items-grid grid1">
																			<li class="jFiler-item">	
																				<div class="jFiler-item-container">
																					<div class="jFiler-item-inner">		
																						<div class="jFiler-item-thumb">
																							<img src="'. $imgFull[0] .'" alt="post1" />
																						</div>		
																					</div>		
																				</div>
																				<a class="icon-jfi-trash jFiler-item-trash-action"><i class="fa fa-trash"></i></a>	
																				<input name="" calss="lpFIleGalleryyg" multiple="multiple" value="'.$galID.'" type="hidden">
																			</li>
																		</ul>';
                            }
                        }

                        $output .= '</div>';
                    }
                    $output .=	'
													</div>
												</div>
											</div>
										</div>';
                }
            }


            /* to show preview of featured image */

            if( isset($lp_featured_img_url) && !empty($lp_featured_img_url) ){

            }

            $output .='
									<div class="form-group clearfix margin-bottom-0 margin-top-30 lp-listing-featuredimage lp-featur-st">';

            if( isset($lp_featured_img_url) && !empty($lp_featured_img_url) ){
                $output .='	
									<label class="margin-top-20">'.esc_html__('Change Featured Image', 'listingpro-plugin').'</label>';
            }else{
                $output .='	
									<label class="margin-top-20">'.esc_html__('Upload Featured Image', 'listingpro-plugin').'</label>';
            }

            $output .='
								
									<div class="custom-file margin-top-15">
										<input style="display:none;" type="file" name="lp-featuredimage[]" id="lp-featuredimage" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple />
										<label class="featured-img-label" for="lp-featuredimage"><p>'.esc_html__('Browse', 'listingpro-plugin').'</p><span>'.esc_html__('Choose a file', 'listingpro-plugin').'&hellip;</span></label>
									</div>
								
								';
            $b_logo =   $listingpro_options['business_logo_switch'];
            if( $b_logo == 1 ):
                $output .=  '<div class="form-group clearfix margin-bottom-0 margin-top-10 lp-listing-featuredimage lp-featur-st">
									<label class="margin-top-10">'.esc_html__('Upload Business Logo', 'listingpro-plugin').'</label>
									
									<div class="custom-file">
										<input style="display:none;" type="file" name="business_logo[]" id="business_logo" class="inputfile inputfile-4" />
										<label class="b-logo-img-label" for="business_logo"><p>'.esc_html__('Browser', 'listingpro-plugin').'</p><span>'.esc_html__('Choose a file', 'listingpro-plugin').'&hellip;</span></label>
									</div>
								</div>';
            endif;
            $output .='
								</div>
							</div>';
            if( $page_style != 'style2' )
            {
                $output .=  '<div class="form-group col-md-6 col-xs-12">';
                if($submit_ad_img3_switch == 1) {
                    $output .='
									<div class="submit-img">
										<img src="'. $submitImg3 .'" alt="">
									</div>';
                }
                $output .='
					</div>';
            }

            $output .=  '</div>
					</div>';
        }
    }
    if( $page_style != 'style2' )
    {
        $output .='
					<div class="blue-section">
						<div class="row">
							<div class="form-group col-md-6 margin-bottom-0">';
        if(!is_user_logged_in()){
            $output .='
									<label for="inputEmail">'.$listingEmailText.'</label>
									<input type="email" class="form-control" name="email" id="inputEmail" placeholder="'.esc_html__('your contact email', 'listingpro-plugin').'">';
        }
        else{
            $output .='<div id="inputEmail"></div>';
        }
        $output .='
							</div>
							<div class="form-group col-md-6 margin-bottom-0">
							  	<div class="checkbox form-group col-md-4">
							  	</div>
								<div class="form-group clearfix margin-bottom-0 preview-section pos-relative col-md-8 pull-right">';

        if($enableCaptcha==true){
            if ( class_exists( 'cridio_Recaptcha' ) ){
                if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
                    $output .='<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-securet" class="g-recaptcha form-group clearfix" data-sitekey="'.$gSiteKey.'"></div>';
                }
            }
        }

        $output .='<label for="previewListing">'.esc_html__('Click below to review your listing.', 'listingpro-plugin').'</label>
									<div class="error_box"></div>
									<input type="hidden" name="lp_post" value="'.$lp_post.'" /> 
									<input type="hidden" name="plan_id" value="'.$plan_id.'" /> 
									<input type="hidden" name="claimed_section" value="'.listing_get_metabox_by_ID("claimed_section", $lp_post).'" /> 
									<input type="submit" name="listingedit" value="'.$btnText.'" class="lp-secondary-btn btn-first-hover" /> 
									<i class="fa fa-angle-right lpsubmitloading"></i>
									<input type="hidden" name="errorrmsg" value="'.esc_html__('Something is missing! Please fill out all fields highlighted in red.', 'listingpro-plugin').'" />
								</div>';
        $output .= wp_nonce_field( 'edit_nonce', 'edit_nonce_field' ,true, false );
        $output .='
							</div>
						</div>
					</div>';
    }
    else
    {
        if(!is_user_logged_in())
        {
            $output .='
                            <div class="white-section border-bottom '.$style_wrap.'">
                                <div class="row">
                                    <div class="form-group col-md-12 margin-bottom-0">';
            $output .='
                                            <label for="inputEmail">'.$listingEmailText.'</label>
                                            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="'.esc_html__('your contact email', 'listingpro-plugin').'">';
            $output .=  '</div>
					</div>
                            </div>';
        }
        if( $enableCaptcha == true )
        {
            $output .='
                            <div class="white-section">
                                <div class="row">
                                    <div class="form-group col-md-12 margin-bottom-0">';
            if ( class_exists( 'cridio_Recaptcha' ) ){
                if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
                    $output .='<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-securet" class="g-recaptcha form-group clearfix" data-sitekey="'.$gSiteKey.'"></div>';
                }
            }
            $output .=  '</div>
                                </div>
                            </div>';
        }
        $output .='<div class="submitbutton-wraper submitbutton-wraper-style2">
									<div class="error_box"></div>
									<input type="hidden" name="lp_post" value="'.$lp_post.'" /> 
									<input type="hidden" name="plan_id" value="'.$plan_id.'" /> 
									<input type="hidden" name="claimed_section" value="'.listing_get_metabox_by_ID("claimed_section", $lp_post).'" /> 
									<input type="submit" name="listingedit" value="'.$btnText.'" class="lp-secondary-btn btn-first-hover" /> 
								
									<input type="hidden" name="errorrmsg" value="'.esc_html__('Something is missing! Please fill out all fields highlighted in red.', 'listingpro-plugin').'" />
								</div>';
        $output .= wp_nonce_field( 'edit_nonce', 'edit_nonce_field' ,true, false );
    }

    if( $page_style == 'style2' )
    {
        $output .=  '</div><div class="col-md-4 page-style2-sidebar-wrap '.$sidebar_sticky.'" style="top: '. $lp_submit_sidebar_top .';">
<div class="page-style2-sidebar">';
        if( $quick_tip_switch == 1 ) {
            $output .='
									<div class="quick_tip quick_tip_style2 '.$style_wrap.'">
										
										<div class="quick-tip-inner">
										<h2>'. $quickTipTitle .'</h2>
										    <p>'. $quickTipText .'</p>';
            if($submit_ad_img_switch == 1) {
                $output .='
                                                <div class="submit-img">
                                                    <img src="'. $submitImg .'" alt="">
                                                </div>';
            }
            $output .=  '</div>';
            $output .=  '</div>';
        }

        $output .=  '</div>
</div>
<div class="clearfix"></div> </div>';
    }
    $output .=  '</form>
			</div>
		</div>
	</div>';
    ob_end_clean();
    ob_flush();
    return $output;
}
add_shortcode('listingpro_edit', 'listingpro_shortcode_edit');