<?php

/*
 * Submit Listing ajax
 *
*/
	
	if (!function_exists('Listingpro_listing_submit_init')) {
		function Listingpro_listing_submit_init(){
			wp_register_script('listingpro-submit-listing', plugins_url( '/assets/js/submit-listing.js', plugin_dir_path( __FILE__ ) ), '', '' ,true ); 
			wp_enqueue_script('listingpro-submit-listing');

			wp_localize_script( 'listingpro-submit-listing', 'ajax_listingpro_submit_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));
		}
		
	}
	add_action('init', 'Listingpro_listing_submit_init');
	
	/* ================================================================================= */
	add_action('wp_ajax_listingpro_submit_listing_ajax', 'listingpro_submit_listing_ajax');
	add_action('wp_ajax_nopriv_listingpro_submit_listing_ajax', 'listingpro_submit_listing_ajax');
	if(!function_exists('listingpro_submit_listing_ajax')){
		function listingpro_submit_listing_ajax(){
			
			global $listingpro_options;
			$enableCaptcha = false;
			$gCaptcha;
			$count = 0;	
			$keyResponse = '';
			$processSubmission = true;
			$listingptext ='';
			$listingprice ='';
			$price_status ='';
			
			$featImgFromGal = false;
			if( isset($listingpro_options['lp_def_featured_image_from_gallery']) && !empty($listingpro_options['lp_def_featured_image_from_gallery']) ){
				if($listingpro_options['lp_def_featured_image_from_gallery']=="enable"){
					$featImgFromGal = true;
				}
			}
			
			if(isset($_POST['g-recaptcha-response'])){
				if(!empty($_POST['g-recaptcha-response'])){
					$enableCaptcha = true;
				}
				else{
					$processSubmission = false;
				}
			}
			else{
				$enableCaptcha = false;
				$processSubmission = true;
			}
			
			if($enableCaptcha == true){
				if ( class_exists( 'cridio_Recaptcha' ) ){ 
									$keyResponse = cridio_Recaptcha_Logic::is_recaptcha_valid($_POST['g-recaptcha-response']);
									if($keyResponse == false){
										$processSubmission = false;
									}
									else{
										$processSubmission = true;
									}
				}
			}
			
			if($processSubmission==true){
				if ( isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ) {
					
					$response = '';
					$errors = array();
					if(empty($_POST['postTitle'])){
						$errors['postTitle'] = 'postTitle';
					}
					/* if(empty($_POST['gAddress'])){
						$errors['gAddress'] = 'gAddress';
					} */
					if(empty($_POST['category']) || !array_filter($_POST['category'])){
						$errors['category'] = 'category';
					}
					
					if(empty($_POST['postContent'])){
						$errors['postContent'] = 'postContent';
					}
					if( isset($_POST['processLogin']) ){
						if($_POST['processLogin'] == 'yes'){
							if(empty($_POST['inputUsername'])){
								$errors['inputUsername'] = 'inputUsername';
							}
							if(empty($_POST['inputUserpass'])){
								$errors['inputUserpass'] = 'inputUserpass';
							}
						}
					}
					/* PLAN ID */
					$lp_paid_mode = $listingpro_options['enable_paid_submission'];
					$plan_id = 'none';
					if(isset($_POST['plan_id'])){
						$plan_id = $_POST['plan_id'];
					}else{
						$plan_id = 'none';
					}
					if( !empty($errors) && count($errors)>0 ){
						
						die(json_encode(array('response'=>'fail', 'status'=>$errors)));	
					}
					else{
						
						$gaddpress = '';
						if(isset($_POST['gAddress']) && !empty($_POST['gAddress'])){
							$gaddpress = sanitize_text_field($_POST['gAddress']);
						}
						if(isset($_POST['gAddresscustom']) && !empty($_POST['gAddresscustom'])){
							$gaddpress = sanitize_text_field($_POST['gAddresscustom']);
						}
						$postID = '';
						$featuresID = '';
						if(isset($_POST['lp_form_fields_inn'])){
							if(isset($_POST['lp_form_fields_inn']['lp_feature']) && !empty($_POST['lp_form_fields_inn']['lp_feature'])){
								$featuresID = $_POST['lp_form_fields_inn']['lp_feature'];
							}
						}
						
						$tags = '';
						if(isset($_POST['tags']) && !empty($_POST['tags'])){						
							$tags = $_POST['tags'];
							$tags = explode( ',', $tags );
						}
						
						/* locations */
						
						$listLocation;
						$lpsLoc;
						$locations_type = $listingpro_options['lp_listing_locations_options'];
						if($locations_type=="auto_loc"){
							if(isset($_POST['location'])){
								if(!empty($_POST['location'])){
									if(is_array($_POST['location'])){
										$listLocation = sanitize_text_field($_POST['location']);
										
										$locCount = 0;
										foreach($_POST['location'] as $locnames){
											$insertLoc = listingpro_insert_term($locnames,'location');
											if(!empty($insertLoc)){
												$lpsLoc[$locCount] = $insertLoc['term_id'] ;
											}
											else{
												$lpLocObj = get_term_by('name', $locnames, 'location');
												if(!empty($lpLocObj)){
													$lpsLoc[$locCount] = $lpLocObj->term_id;
												}
												else{
													$lpsLoc[$locCount] = '';
												}
											}
											
											$locCount++;
										}
										
									}else{
										$listLocation = sanitize_text_field($_POST['location']);
										$insertLoc = listingpro_insert_term($listLocation,'location');
										if(!empty($insertLoc)){
											$lpsLoc = $insertLoc['term_id'] ;
										}
										else{
											$lpLocObj = get_term_by('name', $listLocation, 'location');
											if(!empty($lpLocObj)){
												$lpsLoc = $lpLocObj->term_id;
											}
											else{
												$lpsLoc = '';
											}
										}
									}
								}
							}
						}else{
							$lpsLoc = $_POST['location'];
							
						}
						/* ends locations */
						$lp_listing_locations;
						$lp_listing_cats;
						if( !empty($lpsLoc) && is_array($lpsLoc) ){
							$lp_listing_locations = $lpsLoc;
						}
						else{
							$lp_listing_locations = array($lpsLoc);
						}
						
						if(isset($_POST['category'])){
							$lpcatss = $_POST['category'];
							if(!empty($lpcatss) && is_array($lpcatss)){
								$lp_listing_cats = $lpcatss;
							}
							else{
								$lp_listing_cats = array($lpcatss);
							}
						}
							
						if ( is_user_logged_in() ) {
							$post_information = array(
								'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
								'post_content' => $_POST['postContent'],
								'post_type' => 'listing',
								'tax_input' => array(
									'location' => $lp_listing_locations,
									'listing-category' => $lp_listing_cats,
									'features' => $featuresID,
									'list-tags' => $tags,
								),			
							   'post_status' => 'pending'
							);						
							$postID = wp_insert_post( $post_information );
                            /* plan data save in meta */
                            lp_listing_save_additional_metas($plan_id, $postID);

							$current_user = wp_get_current_user();
							$useremail = $current_user->user_email;
							$user_name = $current_user->user_login;
							$admin_email = '';
							$admin_email = get_option( 'admin_email' );
							$website_url = site_url();
							$website_name = get_option('blogname');
							$listing_title = get_the_title($postID);
							$listing_url = get_the_permalink($postID);
							
							$headers[] = 'Content-Type: text/html; charset=UTF-8';
							
							
							$business_hours = $_POST['business_hours'];
							
							$faqs;
							if( isset($_POST['faq']) && isset($_POST['faqans']) ){
								$faqQuestion = $_POST['faq'];
								$faqAns = $_POST['faqans'];
								$faqs = array('faq'=>$faqQuestion,'faqans'=>$faqAns);
							}
							if(isset($_POST['lp_form_fields_inn'])){
								$metaFields = 'lp_'.strtolower(THEMENAME).'_options_fields';
								$fields = $_POST['lp_form_fields_inn'];		 	
								update_post_meta($postID, $metaFields, $fields);

							}
							
							$priceStatus = sanitize_text_field($_POST['price_status']);
							$listTagline = sanitize_text_field($_POST['tagline_text']);
							$listLatitude = sanitize_text_field($_POST['latitude']);
							$listLongitude = sanitize_text_field($_POST['longitude']);
							$listPhone = sanitize_text_field($_POST['phone']);
							$listWebsite = sanitize_text_field($_POST['website']);
							$listTwitter = sanitize_text_field($_POST['twitter']);
							$listFacebook = sanitize_text_field($_POST['facebook']);
							$listLinkedin= sanitize_text_field($_POST['linkedin']);
							$listGplus= sanitize_text_field($_POST['google_plus']);
							$listYoutube= sanitize_text_field($_POST['youtube']);
							$listInstagram= sanitize_text_field($_POST['instagram']);
							$listPrice= sanitize_text_field($_POST['listingprice']);
							$listPText= sanitize_text_field($_POST['listingptext']);
							$listPostVideo= sanitize_text_field($_POST['postVideo']);
							
							listing_set_metabox('business_hours', $business_hours, $postID);
							listing_set_metabox('price_status', $priceStatus, $postID);
							listing_set_metabox('faqs', $faqs, $postID);
							listing_set_metabox('tagline_text', $listTagline, $postID);
							listing_set_metabox('gAddress', $gaddpress, $postID);
							listing_set_metabox('latitude', $listLatitude, $postID);
							listing_set_metabox('longitude', $listLongitude, $postID);
							listing_set_metabox('phone', $listPhone, $postID);
							listing_set_metabox('email', $useremail, $postID);
							listing_set_metabox('website', $listWebsite, $postID);
							listing_set_metabox('twitter', $listTwitter, $postID);
							listing_set_metabox('facebook', $listFacebook, $postID);
							listing_set_metabox('linkedin', $listLinkedin, $postID);
							listing_set_metabox('google_plus', $listGplus, $postID);
							listing_set_metabox('youtube', $listYoutube, $postID);
							listing_set_metabox('instagram', $listInstagram, $postID);
							listing_set_metabox('Plan_id', $plan_id, $postID);
							listing_set_metabox('list_price', $listPrice, $postID);
							listing_set_metabox('list_price_to', $listPText, $postID);
							listing_set_metabox('video', $listPostVideo, $postID);
							listing_set_metabox('claimed_section', 'not_claimed', $postID);
							
                            if ( isset($_FILES["business_logo"]) )  {
                                if($_FILES['business_logo']['size'] != 0) {
                                    $files2 = $_FILES["listingfiles"];
                                    $files3 = $_FILES["lp-featuredimage"];
                                    $files = $_FILES["business_logo"];
                                    foreach ($files['name'] as $key => $value) {
                                        if ($files['name'][$key]) {
                                            $file = array( 'name' => $files['name'][$key],
                                                'type' => $files['type'][$key],
                                                'tmp_name' => $files['tmp_name'][$key],
                                                'error' => $files['error'][$key],
                                                'size' => $files['size'][$key] );
                                            $_FILES = array ("business_logo" => $file);
                                            $count = 0;
                                            foreach ($_FILES as $file => $array) {
                                                //$newupload = listingpro_handle_attachment_featured($file,$postID);
                                                $newupload = listingpro_handle_attachment($file,$postID,$set_thu=false);
                                                $b_logo_url = wp_get_attachment_url( $newupload );

                                                listing_set_metabox('business_logo', $b_logo_url, $postID);
                                            }
                                        }
                                        $_FILES["listingfiles"] = '';
                                        $_FILES["listingfiles"] = $files2;
                                        $_FILES["lp-featuredimage"] = $files3;
                                    }
                                }
                            }
							if ( isset($_FILES["lp-featuredimage"]) )  {
								if($_FILES['lp-featuredimage']['size'] != 0) {
									$files2 = $_FILES["listingfiles"];  
									$files = $_FILES["lp-featuredimage"];  			
									$b_logo = $_FILES["business_logo"];
									foreach ($files['name'] as $key => $value) {
										if ($files['name'][$key]) { 					
											$file = array( 'name' => $files['name'][$key],	 					
											'type' => $files['type'][$key], 						
											'tmp_name' => $files['tmp_name'][$key], 						
											'error' => $files['error'][$key], 						
											'size' => $files['size'][$key] ); 					
											$_FILES = array ("lp-featuredimage" => $file); 					
											$count = 0;					
											foreach ($_FILES as $file => $array) {	
												$newupload = listingpro_handle_attachment_featured($file,$postID); 
											}
										}
										$_FILES["listingfiles"] = '';
                                        $_FILES["business_logo"] = '';

										$_FILES["listingfiles"] = $files2;
										$_FILES["business_logo"] = $b_logo;
									}
								}									
							}
							
							
							if ( isset($_FILES["listingfiles"]) ) {
								if($_FILES['listingfiles']['size'] != 0) {
									$files = $_FILES["listingfiles"];  			
                                    $b_logo = $_FILES["business_logo"];
									//$files2 = $_FILES["lp-featuredimage"];
									foreach ($files['name'] as $key => $value) { 							
										if ($files['name'][$key]) {
											$file = array( 'name' => $files['name'][$key],	 					
											'type' => $files['type'][$key], 						
											'tmp_name' => $files['tmp_name'][$key], 						
											'error' => $files['error'][$key], 						
											'size' => $files['size'][$key] ); 					
											$_FILES = array ("listingfiles" => $file); 					
											$count = 0;					
											foreach ($_FILES as $file => $array) {	
											
												if( $featImgFromGal==true && !isset($_FILES["lp-featuredimage"]) ){
													$newupload = listingpro_handle_attachment($file,$postID,$set_thu=true); 
												}else{
													$newupload = listingpro_handle_attachment($file,$postID,$set_thu=false); 
												}
												
												
												$ids[] =$newupload;
												$count++;
											}
										}
                                        $_FILES["business_logo"] = '';
										$_FILES["business_logo"] = $b_logo;
									}
									if(!empty($ids) && is_array($ids)){
										$img_ids = implode(",", $ids);				
										update_post_meta($postID, 'gallery_image_ids', $img_ids);
										//$_FILES['lp-featuredimage'] = $files2;
										
									}
								}									
							}
							
							/* mail for user */
							$u_mail_subject_a = '';
							$u_mail_body_a = '';
							$u_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing'];
							$u_mail_body = $listingpro_options['listingpro_new_submit_listing_content'];
							
							$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
								'website_url' => "$website_url",
								'listing_title' => "$listing_title",
								'listing_url' => "$listing_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
							));
							
							$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
								'website_url' => "$website_url",
								'listing_title' => "$listing_title",
								'listing_url' => "$listing_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
							));
							
							wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);
							
							/* mail for admin */
							$a_mail_subject_a = '';
							$a_mail_body_a = '';
							$a_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing_admin'];
							$a_mail_body = $listingpro_options['listingpro_new_submit_listing_content_admin'];
							
							$a_mail_subject_a = lp_sprintf2("$a_mail_subject", array(
								'website_url' => "$website_url",
								'listing_title' => "$listing_title",
								'listing_url' => "$listing_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
							));
							
							$a_mail_body_a = lp_sprintf2("$a_mail_body", array(
								'website_url' => "$website_url",
								'listing_title' => "$listing_title",
								'listing_url' => "$listing_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
							));
							
							wp_mail( $admin_email, $a_mail_subject_a, $a_mail_body_a, $headers);
							

							if( $lp_paid_mode == "yes" ){
								listing_draft_save( $postID, null );
							}
							
							$response = get_the_permalink($postID);
							die(json_encode(array('response'=>'success', 'status'=>$response)));
						}
						else{
							
							if( $_POST['processLogin'] == 'no' || !isset($_POST['processLogin']) )
                            {
								$enableUsernameField = false;
								if( isset($listingpro_options['lp_register_username']) ){
									if($listingpro_options['lp_register_username']==true){
										$enableUsernameField = true;
									}
								}
                                $user_email = '';
                                $user_name = '';
                                $email = $_POST['email'];
                                if(empty($email)){
                                    $errors['email'] = $email;
                                }

                                if( !empty($errors) && count($errors)>0 ){

                                    die(json_encode(array('response'=>'fail', 'status'=>$errors)));
                                }
                                $user_name = $_POST['email'];
                                list($user_name) = explode('@', $email);
                                $user_name .=rand(1,100);
								if(!empty($enableUsernameField)){
									$user_name = sanitize_text_field($_POST['customUname']);
								}
								
								$existinUserId = username_exists( $user_name );
								if(!empty($existinUserId)){
									$response = '<span class="email-exist-error">'.esc_html__("UserName already exists", "listingpro-plugin").'</span>';
                                    die(json_encode(array('response'=>'failure', 'status'=>$response)));
								}
								
								
                                if( email_exists($email)==true || username_exists($user_name)==true ){
                                    $response = '<span class="email-exist-error">'.esc_html__("Email already exists", "listingpro-plugin").'</span>';
                                    die(json_encode(array('response'=>'failure', 'status'=>$response)));
                                }
                                else{

                                    $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
                                    $user_id = wp_create_user( $user_name, $random_password, $email );
                                    $creds['user_login'] = $user_name;
                                    $creds['user_password'] = $random_password;
                                    $creds['remember'] = true;
                                    $user = wp_signon( $creds, true );

                                    /* for user */
                                    $subject = $listingpro_options['listingpro_subject_new_user_register'];
                                    $website_url = site_url();
                                    
									$formated_subject = lp_sprintf2("$subject", array(
										'website_url' => "$website_url"
									));

                                    $mail_content = $listingpro_options['listingpro_new_user_register'];
									$formated_mail_content = lp_sprintf2("$mail_content", array(
										'website_url' => "$website_url",
										'user_login_register' => "$user_name",
										'user_pass_register' => "$random_password",
										'user_name' => "$user_name",
									));

                                    /* for admin */

                                    $subject2 = $listingpro_options['listingpro_subject_admin_new_user_register'];
                                    $mail_content2 = $listingpro_options['listingpro_admin_new_user_register'];
									$formated_mail_content2 = lp_sprintf2("$mail_content2", array(
										'website_url' => "$website_url",
										'user_login_register' => "$user_name",
										'user_email_register' => "$email",
										'user_name' => "$user_name",
									));

                                    $from = get_option('admin_email');
                                    $headers[] = 'Content-Type: text/html; charset=UTF-8';

                                    $headers2[] = 'Content-Type: text/html; charset=UTF-8';

                                    wp_mail( $email, $formated_subject, $formated_mail_content, $headers );
                                    wp_mail( $from, $subject2, $formated_mail_content2, $headers2 );

                                    /* locations */
                                    $listLocation;
                                    $lpsLoc;
                                    $insertLoc;
                                    $locations_type = $listingpro_options['lp_listing_locations_options'];
                                    if($locations_type=="auto_loc"){
                                        if(isset($_POST['location'])){
                                            if(!empty($_POST['location'])){
                                                //$listLocation = sanitize_text_field($_POST['location']);
												$listLocation = array_map( 'sanitize_text_field', wp_unslash( $_POST['location'] ) );
												if(is_array($listLocation)){
													foreach($listLocation as $singlelistLoc){
														$insertLoc[$singlelistLoc] = listingpro_insert_term($singlelistLoc,'location');
													}
												}else{
                                                $insertLoc = listingpro_insert_term($listLocation,'location');
												}
                                                if(!empty($insertLoc)){
													if(is_array($insertLoc)){
														foreach($insertLoc as $singleinsertLoc){
															$slidd = $singleinsertLoc['term_id'];
															$lpsLoc[$slidd] = $slidd ;
														}
														
													}else{
                                                    $lpsLoc = $insertLoc['term_id'] ;
                                                }
                                                }
                                                else{
													if(is_array($listLocation)){
														
														foreach($listLocation as $singlelistLoc){
															$lpLocObj = get_term_by('name', $singlelistLoc, 'location');
															if(!empty($lpLocObj)){
																$obtID = $lpLocObj->term_id;
																$lpsLoc[$obtID] = $obtID;
															}
														}
														
													}else{
                                                    $lpLocObj = get_term_by('name', $listLocation, 'location');
                                                    if(!empty($lpLocObj)){
                                                        $lpsLoc = $lpLocObj->term_id;
                                                    }
                                                    else{
                                                        $lpsLoc = '';
														}
                                                    }
                                                }
                                            }
                                        }
                                    }else{
                                        $lpsLoc = $_POST['location'];

                                    }
                                    /* ends locations */


                                    $post_information = array(
                                        'post_author'=> $user_id,
                                        'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
                                        'post_content' => $_POST['postContent'],
                                        'post_type' => 'listing',
                                        'post_status' => 'pending'
                                    );
                                    $postID = wp_insert_post( $post_information );
                                    /* plan data save in meta */
                                    lp_listing_save_additional_metas($plan_id, $postID);

                                    wp_set_post_terms($postID, $_POST['category'], 'listing-category');
                                    wp_set_post_terms($postID, $lpsLoc, 'location');
                                    wp_set_post_terms($postID, $featuresID, 'features');
                                    wp_set_post_terms($postID, $tags, 'list-tags');



                                    $current_user = wp_get_current_user();
                                    $useremail = $current_user->user_email;
									$user_name = $current_user->user_login;
                                    $admin_email = '';
                                    $admin_email = get_option( 'admin_email' );
                                    $website_url = site_url();
                                    $website_name = get_option('blogname');
                                    $listing_title = get_the_title($postID);
                                    $listing_url = get_the_permalink($postID);

                                    $headers[] = 'Content-Type: text/html; charset=UTF-8';
                                    

                                    $business_hours = $_POST['business_hours'];

                                    $faqs='';
                                    if( isset($_POST['faq']) && isset($_POST['faqans']) ){
                                        $faqQuestion = $_POST['faq'];
                                        $faqAns = $_POST['faqans'];
                                        $faqs = array('faq'=>$faqQuestion,'faqans'=>$faqAns);
                                    }
                                    if(isset($_POST['lp_form_fields_inn'])){
                                        $metaFields = 'lp_'.strtolower(THEMENAME).'_options_fields';
                                        $fields = $_POST['lp_form_fields_inn'];
                                        update_post_meta($postID, $metaFields, $fields);

                                    }

                                    $priceStatus = sanitize_text_field($_POST['price_status']);
                                    $listTagline = sanitize_text_field($_POST['tagline_text']);
                                    $listLatitude = sanitize_text_field($_POST['latitude']);
                                    $listLongitude = sanitize_text_field($_POST['longitude']);
                                    $listPhone = sanitize_text_field($_POST['phone']);
                                    $listWebsite = sanitize_text_field($_POST['website']);
                                    $listTwitter = sanitize_text_field($_POST['twitter']);
                                    $listFacebook = sanitize_text_field($_POST['facebook']);
                                    $listLinkedin= sanitize_text_field($_POST['linkedin']);
                                    $listGplus= sanitize_text_field($_POST['google_plus']);
                                    $listYoutube= sanitize_text_field($_POST['youtube']);
                                    $listInstagram= sanitize_text_field($_POST['instagram']);
                                    $listPrice= sanitize_text_field($_POST['listingprice']);
                                    $listPText= sanitize_text_field($_POST['listingptext']);
                                    $listPostVideo= sanitize_text_field($_POST['postVideo']);

                                    listing_set_metabox('business_hours', $business_hours, $postID);
                                    listing_set_metabox('price_status', $priceStatus, $postID);
                                    listing_set_metabox('faqs', $faqs, $postID);
                                    listing_set_metabox('tagline_text', $listTagline, $postID);
                                    listing_set_metabox('gAddress', $gaddpress, $postID);
                                    listing_set_metabox('latitude', $listLatitude, $postID);
                                    listing_set_metabox('longitude', $listLongitude, $postID);
                                    listing_set_metabox('phone', $listPhone, $postID);
                                    listing_set_metabox('email', $email, $postID);
                                    listing_set_metabox('website', $listWebsite, $postID);
                                    listing_set_metabox('twitter', $listTwitter, $postID);
                                    listing_set_metabox('facebook', $listFacebook, $postID);
                                    listing_set_metabox('linkedin', $listLinkedin, $postID);
                                    listing_set_metabox('google_plus', $listGplus, $postID);
                                    listing_set_metabox('youtube', $listYoutube, $postID);
                                    listing_set_metabox('instagram', $listInstagram, $postID);
                                    listing_set_metabox('Plan_id', $plan_id, $postID);
                                    listing_set_metabox('list_price', $listPrice, $postID);
                                    listing_set_metabox('list_price_to', $listPText, $postID);
                                    listing_set_metabox('video', $listPostVideo, $postID);
                                    listing_set_metabox('claimed_section', 'not_claimed', $postID);
									
									if ( isset($_FILES["lp-featuredimage"]) )  {
										if($_FILES['lp-featuredimage']['size'] != 0) {
											$files2 = $_FILES["listingfiles"];  
											$files = $_FILES["lp-featuredimage"];  			
											foreach ($files['name'] as $key => $value) { 							
												if ($files['name'][$key]) { 					
													$file = array( 'name' => $files['name'][$key],	 					
													'type' => $files['type'][$key], 						
													'tmp_name' => $files['tmp_name'][$key], 						
													'error' => $files['error'][$key], 						
													'size' => $files['size'][$key] ); 					
													$_FILES = array ("lp-featuredimage" => $file); 					
													$count = 0;					
													foreach ($_FILES as $file => $array) {	
														$newupload = listingpro_handle_attachment_featured($file,$postID); 
													}
												}
												$_FILES["listingfiles"] = '';
												$_FILES["listingfiles"] = $files2;
											}
										}									
									}
									
									
									if ( isset($_FILES["listingfiles"]) ) {
										if($_FILES['listingfiles']['size'] != 0) {
											$files = $_FILES["listingfiles"];  			
											//$files2 = $_FILES["lp-featuredimage"];  			
											foreach ($files['name'] as $key => $value) { 							
												if ($files['name'][$key]) {
													$file = array( 'name' => $files['name'][$key],	 					
													'type' => $files['type'][$key], 						
													'tmp_name' => $files['tmp_name'][$key], 						
													'error' => $files['error'][$key], 						
													'size' => $files['size'][$key] ); 					
													$_FILES = array ("listingfiles" => $file); 					
													$count = 0;					
													foreach ($_FILES as $file => $array) {	
														
														if( $featImgFromGal==true && !isset($_FILES["lp-featuredimage"]) ){
															$newupload = listingpro_handle_attachment($file,$postID,$set_thu=true);
														}else{
															$newupload = listingpro_handle_attachment($file,$postID,$set_thu=false);
														}														
														$ids[] =$newupload;
														$count++;
													}
												}
											}
											if(!empty($ids) && is_array($ids)){
												$img_ids = implode(",", $ids);				
												update_post_meta($postID, 'gallery_image_ids', $img_ids);
												//$_FILES['lp-featuredimage'] = $files2;
												
											}
										}									
									}

                                    /* mail for user */
                                    $u_mail_subject_a = '';
                                    $u_mail_body_a = '';
                                    $u_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing'];
                                    $u_mail_body = $listingpro_options['listingpro_new_submit_listing_content'];

									$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
										'website_url' => "$website_url",
										'listing_title' => "$listing_title",
										'listing_url' => "$listing_url",
										'website_name' => "$website_name",
										'user_name' => "$user_name",
									));

									$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
										'website_url' => "$website_url",
										'listing_title' => "$listing_title",
										'listing_url' => "$listing_url",
										'website_name' => "$website_name",
										'user_name' => "$user_name",
									));
									
                                    wp_mail( $email, $u_mail_subject_a, $u_mail_body_a, $headers);

                                    /* mail for admin */
                                    $a_mail_subject_a = '';
                                    $a_mail_body_a = '';
                                    $a_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing_admin'];
                                    $a_mail_body = $listingpro_options['listingpro_new_submit_listing_content_admin'];
									
									$a_mail_subject_a = lp_sprintf2("$a_mail_subject", array(
										'website_url' => "$website_url",
										'listing_title' => "$listing_title",
										'listing_url' => "$listing_url",
										'website_name' => "$website_name",
										'user_name' => "$user_name",
									));
									
									$a_mail_body_a = lp_sprintf2("$a_mail_body", array(
										'website_url' => "$website_url",
										'listing_title' => "$listing_title",
										'listing_url' => "$listing_url",
										'website_name' => "$website_name",
										'user_name' => "$user_name",
									));
									
                                    wp_mail( $admin_email, $a_mail_subject_a, $a_mail_body_a, $headers);
									

                                    if( $lp_paid_mode == "yes" ){
                                        listing_draft_save( $postID, $user_id );
                                    }

                                    $response = get_the_permalink($postID);
                                    die(json_encode(array('response'=>'success', 'status'=>$response, 'newuser'=>$user_id )));

                                }
                            }
                            else if( $_POST['processLogin'] == 'yes' && isset($_POST['processLogin']) )
                            {
                                $user_pass = $_POST['inputUserpass'];
                                $user_name = $_POST['inputUsername'];
                                
                                    $creds = array();
                                    $creds['user_login'] = $user_name;
                                    $creds['user_password'] = $user_pass;
                                    $creds['remember'] = true;
									
                                    $user = wp_signon( $creds, true );
                                    if( is_wp_error( $user ) )
                                    {
                                        $response = '<span class="invalid-cred-error">'.esc_html__("Invalid username or password", "listingpro-plugin").'</span>';
                                        die(json_encode(array('response'=>'failure', 'status'=>$response)));
                                    }
                                    else{
										
										//Get current user ID
										$user_id = $user->ID;

                                        /* locations */
                                        $listLocation = '';
                                        $lpsLoc = '';
                                        $locations_type = $listingpro_options['lp_listing_locations_options'];
                                        if($locations_type=="auto_loc"){
                                            if(isset($_POST['location'])){
                                                if(!empty($_POST['location'])){
                                                    $listLocation = sanitize_text_field($_POST['location']);
                                                    $insertLoc = listingpro_insert_term($listLocation,'location');
                                                    if(!empty($insertLoc)){
                                                        $lpsLoc = $insertLoc['term_id'] ;
                                                    }
                                                    else{
                                                        $lpLocObj = get_term_by('name', $listLocation, 'location');
                                                        if(!empty($lpLocObj)){
                                                            $lpsLoc = $lpLocObj->term_id;
                                                        }
                                                        else{
                                                            $lpsLoc = '';
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                            $lpsLoc = $_POST['location'];

                                        }
                                        /* ends locations */


                                        $post_information = array(
                                            'post_author'=> $user_id,
                                            'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
                                            'post_content' => $_POST['postContent'],
                                            'post_type' => 'listing',
                                            'post_status' => 'pending'
                                        );
                                        $postID = wp_insert_post( $post_information );
                                        /* plan data save in meta */
                                        lp_listing_save_additional_metas($plan_id, $postID);

                                        wp_set_post_terms($postID, $_POST['category'], 'listing-category');
                                        wp_set_post_terms($postID, $lpsLoc, 'location');
                                        wp_set_post_terms($postID, $featuresID, 'features');
                                        wp_set_post_terms($postID, $tags, 'list-tags');



                                        $current_user = wp_get_current_user();
                                        $useremail = $current_user->user_email;
                                        $admin_email = '';
                                        $admin_email = get_option( 'admin_email' );
                                        $website_url = site_url();
                                        $website_name = get_option('blogname');
                                        $listing_title = get_the_title($postID);
                                        $listing_url = get_the_permalink($postID);

                                        $headers[] = 'Content-Type: text/html; charset=UTF-8';

                                        $business_hours = $_POST['business_hours'];

                                        $faqs='';
                                        if( isset($_POST['faq']) && isset($_POST['faqans']) ){
                                            $faqQuestion = $_POST['faq'];
                                            $faqAns = $_POST['faqans'];
                                            $faqs = array('faq'=>$faqQuestion,'faqans'=>$faqAns);
                                        }
                                        if(isset($_POST['lp_form_fields_inn'])){
                                            $metaFields = 'lp_'.strtolower(THEMENAME).'_options_fields';
                                            $fields = $_POST['lp_form_fields_inn'];
                                            update_post_meta($postID, $metaFields, $fields);

                                        }

                                        $priceStatus = sanitize_text_field($_POST['price_status']);
                                        $listTagline = sanitize_text_field($_POST['tagline_text']);
                                        $listLatitude = sanitize_text_field($_POST['latitude']);
                                        $listLongitude = sanitize_text_field($_POST['longitude']);
                                        $listPhone = sanitize_text_field($_POST['phone']);
                                        $listWebsite = sanitize_text_field($_POST['website']);
                                        $listTwitter = sanitize_text_field($_POST['twitter']);
                                        $listFacebook = sanitize_text_field($_POST['facebook']);
                                        $listLinkedin= sanitize_text_field($_POST['linkedin']);
                                        $listGplus= sanitize_text_field($_POST['google_plus']);
                                        $listYoutube= sanitize_text_field($_POST['youtube']);
                                        $listInstagram= sanitize_text_field($_POST['instagram']);
                                        $listPrice= sanitize_text_field($_POST['listingprice']);
                                        $listPText= sanitize_text_field($_POST['listingptext']);
                                        $listPostVideo= sanitize_text_field($_POST['postVideo']);

                                        listing_set_metabox('business_hours', $business_hours, $postID);
                                        listing_set_metabox('price_status', $priceStatus, $postID);
                                        listing_set_metabox('faqs', $faqs, $postID);
                                        listing_set_metabox('tagline_text', $listTagline, $postID);
                                        listing_set_metabox('gAddress', $gaddpress, $postID);
                                        listing_set_metabox('latitude', $listLatitude, $postID);
                                        listing_set_metabox('longitude', $listLongitude, $postID);
                                        listing_set_metabox('phone', $listPhone, $postID);
                                        listing_set_metabox('email', $email, $postID);
                                        listing_set_metabox('website', $listWebsite, $postID);
                                        listing_set_metabox('twitter', $listTwitter, $postID);
                                        listing_set_metabox('facebook', $listFacebook, $postID);
                                        listing_set_metabox('linkedin', $listLinkedin, $postID);
                                        listing_set_metabox('google_plus', $listGplus, $postID);
                                        listing_set_metabox('youtube', $listYoutube, $postID);
                                        listing_set_metabox('instagram', $listInstagram, $postID);
                                        listing_set_metabox('Plan_id', $plan_id, $postID);
                                        listing_set_metabox('list_price', $listPrice, $postID);
                                        listing_set_metabox('list_price_to', $listPText, $postID);
                                        listing_set_metabox('video', $listPostVideo, $postID);
                                        listing_set_metabox('claimed_section', 'not_claimed', $postID);

                                        if ( isset($_FILES["lp-featuredimage"]) )  {
											if($_FILES['lp-featuredimage']['size'] != 0) {
												$files2 = $_FILES["listingfiles"];  
												$files = $_FILES["lp-featuredimage"];  			
												foreach ($files['name'] as $key => $value) { 							
													if ($files['name'][$key]) { 					
														$file = array( 'name' => $files['name'][$key],	 					
														'type' => $files['type'][$key], 						
														'tmp_name' => $files['tmp_name'][$key], 						
														'error' => $files['error'][$key], 						
														'size' => $files['size'][$key] ); 					
														$_FILES = array ("lp-featuredimage" => $file); 					
														$count = 0;					
														foreach ($_FILES as $file => $array) {	
															$newupload = listingpro_handle_attachment_featured($file,$postID); 
														}
													}
													$_FILES["listingfiles"] = '';
													$_FILES["listingfiles"] = $files2;
												}
											}									
										}
									
									
									if ( isset($_FILES["listingfiles"]) ) {
										if($_FILES['listingfiles']['size'] != 0) {
											$files = $_FILES["listingfiles"];  			
											//$files2 = $_FILES["lp-featuredimage"];  			
											foreach ($files['name'] as $key => $value) { 							
												if ($files['name'][$key]) {
													$file = array( 'name' => $files['name'][$key],	 					
													'type' => $files['type'][$key], 						
													'tmp_name' => $files['tmp_name'][$key], 						
													'error' => $files['error'][$key], 						
													'size' => $files['size'][$key] ); 					
													$_FILES = array ("listingfiles" => $file); 					
													$count = 0;					
													foreach ($_FILES as $file => $array) {	
														
														if( $featImgFromGal==true && !isset($_FILES["lp-featuredimage"]) ){
															$newupload = listingpro_handle_attachment($file,$postID,$set_thu=true);
														}else{
															$newupload = listingpro_handle_attachment($file,$postID,$set_thu=false);
														}														
														$ids[] =$newupload;
														$count++;
													}
												}
											}
											if(!empty($ids) && is_array($ids)){
												$img_ids = implode(",", $ids);				
												update_post_meta($postID, 'gallery_image_ids', $img_ids);
												//$_FILES['lp-featuredimage'] = $files2;
												
											}
										}									
									}
									
									
                                        /* mail for user */
                                        $u_mail_subject_a = '';
                                        $u_mail_body_a = '';
                                        $u_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing'];
                                        $u_mail_body = $listingpro_options['listingpro_new_submit_listing_content'];
										
										$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
											'website_url' => "$website_url",
											'listing_title' => "$listing_title",
											'listing_url' => "$listing_url",
											'website_name' => "$website_name",
											'user_name' => "$user_name",
										));
										
										$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
											'website_url' => "$website_url",
											'listing_title' => "$listing_title",
											'listing_url' => "$listing_url",
											'website_name' => "$website_name",
											'user_name' => "$user_name",
										));

										
                                        wp_mail( $email, $u_mail_subject_a, $u_mail_body_a, $headers);

                                        /* mail for admin */
                                        $a_mail_subject_a = '';
                                        $a_mail_body_a = '';
                                        $a_mail_subject = $listingpro_options['listingpro_subject_new_submit_listing_admin'];
                                        $a_mail_body = $listingpro_options['listingpro_new_submit_listing_content_admin'];
										
										$a_mail_subject_a = lp_sprintf2("$a_mail_subject", array(
											'website_url' => "$website_url",
											'listing_title' => "$listing_title",
											'listing_url' => "$listing_url",
											'website_name' => "$website_name",
											'user_name' => "$user_name",
										));

										$a_mail_body_a = lp_sprintf2("$a_mail_body", array(
											'website_url' => "$website_url",
											'listing_title' => "$listing_title",
											'listing_url' => "$listing_url",
											'website_name' => "$website_name",
											'user_name' => "$user_name",
										));
                                        wp_mail( $admin_email, $a_mail_subject_a, $a_mail_body_a, $headers);
									
									
									

                                        if( $lp_paid_mode == "yes" ){
                                            listing_draft_save( $postID, $user_id );
                                        }

                                        $response = get_the_permalink($postID);
                                        die(json_encode(array('response'=>'success', 'status'=>$response, 'newuser'=>$user_id )));

                                    }
                                //}
                            }
							
						}
						/* not loggedin ends */
						
						
					}
				}
				
				
				/* edit post */
				if ( isset( $_POST['edit_nonce_field'] ) && wp_verify_nonce( $_POST['edit_nonce_field'], 'edit_nonce' ) ) {
					
					global $listingpro_options;

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
					$video ='';	
					$lp_post = sanitize_text_field($_POST['lp_post']);
					$prevAddress = listing_get_metabox_by_ID('gAddress', $lp_post);
					
					/* for validations */
					$errors = array();
					if(empty($_POST['postTitle'])){
						$errors['postTitle'] = 'postTitle';
					}
					/* if(empty($_POST['gAddress'])){
						$errors['gAddress'] = 'gAddress';
					} */
					if(empty($_POST['category']) || !array_filter($_POST['category'])){
						$errors['category'] = 'category';
					}
					
					if(empty($_POST['postContent'])){
						$errors['postContent'] = 'postContent';
					}
					
					if( !empty($errors) && count($errors)>0 ){
						
						die(json_encode(array('response'=>'fail', 'status'=>$errors)));	
					}
					else{
					
						$gaddpress = '';
						$gaddpress = $prevAddress;
						if(isset($_POST['gAddress']) && !empty($_POST['gAddress'])){
							$gaddpressA = sanitize_text_field($_POST['gAddress']);
							if($prevAddress!=$gaddpressA){
								$gaddpress = $gaddpressA;
							}
						}
						if(isset($_POST['gAddresscustom']) && !empty($_POST['gAddresscustom'])){
							$gaddpressC = sanitize_text_field($_POST['gAddresscustom']);
							if($prevAddress!=$gaddpressC){
								$gaddpress = $gaddpressC;
							}
						}
						
						$featuresID='';
						if(isset($_POST['lp_form_fields_inn'])){
							if(isset($_POST['lp_form_fields_inn']['lp_feature']) && !empty($_POST['lp_form_fields_inn']['lp_feature'])){
								$featuresID = $_POST['lp_form_fields_inn']['lp_feature'];
							}
						}
						$tags = '';
						if(isset($_POST['tags']) && !empty($_POST['tags'])){						
							$tags = $_POST['tags'];
							$tags = explode( ',', $tags );
						}
						/* locations */
							
							$listLocation;
							$lpsLoc;
							$locations_type = $listingpro_options['lp_listing_locations_options'];
							if($locations_type=="auto_loc"){
								if(isset($_POST['location'])){
									if(!empty($_POST['location'])){
										if(is_array($_POST['location'])){
											$listLocation = sanitize_text_field($_POST['location']);
											$locCount = 0;
											foreach($_POST['location'] as $locnames){
												$insertLoc = listingpro_insert_term($locnames,'location');
												if(!empty($insertLoc)){
													$lpsLoc[$locCount] = $insertLoc['term_id'] ;
												}
												else{
													$lpLocObj = get_term_by('name', $locnames, 'location');
													if(!empty($lpLocObj)){
														$lpsLoc[$locCount] = $lpLocObj->term_id;
													}
													else{
														$lpsLoc[$locCount] = '';
													}
												}
												
												$locCount++;
											}
											
										}else{
											$listLocation = sanitize_text_field($_POST['location']);
											$insertLoc = listingpro_insert_term($listLocation,'location');
											if(!empty($insertLoc)){
												$lpsLoc = $insertLoc['term_id'] ;
											}
											else{
												$lpLocObj = get_term_by('name', $listLocation, 'location');
												if(!empty($lpLocObj)){
													$lpsLoc = $lpLocObj->term_id;
												}
												else{
													$lpsLoc = '';
												}
											}
										}
									}
								}
							}else{
								$lpsLoc = $_POST['location'];
								
							}
							
							$lp_listing_locations;
							$lp_listing_cats;
							if( !empty($lpsLoc) && is_array($lpsLoc) ){
								$lp_listing_locations = $lpsLoc;
							}
							else{
								$lp_listing_locations = array($lpsLoc);
							}
							/* ends locations */
							
							$lp_listing_cats;
							
							if(isset($_POST['category'])){
								$lpcatss = $_POST['category'];
								if(!empty($lpcatss) && is_array($lpcatss)){
									$lp_listing_cats = $lpcatss;
								}
								else{
									$lp_listing_cats = array($lpcatss);
								}
							}
						
						
						$listingEditStatus = 'publish';
						if ( get_post_status ( $lp_post ) == 'publish' ) {
							$listingEditStatus = 'publish';
							if(isset($listingpro_options['edit_listing_pending_switch'])){
								if( $listingpro_options['edit_listing_pending_switch']==true ){
									$listingEditStatus = 'pending';
								}
							}
						}
						
						elseif ( get_post_status ( $lp_post ) == 'pending' ||  get_post_status ( $lp_post ) == 'draft' ) {
							$listingEditStatus = 'pending';
						}
						elseif( get_post_status ( $lp_post ) == 'expired' ){
							$listingEditStatus = 'expired';
						}
						
						$post_information = array(
							'ID'           => $lp_post,
							'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
							'post_name' => '',
							'post_content' => $_POST['postContent'],
							'post_type' => 'listing',
							'tax_input' => array(
								'location' => $lp_listing_locations,
								'listing-category' => $lp_listing_cats,
								'features' =>$featuresID,
								'list-tags' =>$tags,
							),       
							'post_status' => $listingEditStatus
						);
						
						wp_update_post( $post_information );
						
						$postID = $lp_post;
						
						
						$business_hours = $_POST['business_hours'];
						$faqs;
						if( isset($_POST['faq']) && isset($_POST['faqans']) ){
							$faqs = array('faq'=>$_POST['faq'],'faqans'=>$_POST['faqans']);
						}

						if(isset($_POST['lp_form_fields_inn'])){
							$metaFields = 'lp_'.strtolower(THEMENAME).'_options_fields';
							$fields = $_POST['lp_form_fields_inn'];		 	
							update_post_meta($postID, $metaFields, $fields);

						}
						
						$priceStatus = sanitize_text_field($_POST['price_status']);
						$listTagline = sanitize_text_field($_POST['tagline_text']);
						$listLatitude = sanitize_text_field($_POST['latitude']);
						$listLongitude = sanitize_text_field($_POST['longitude']);
						$listPhone = sanitize_text_field($_POST['phone']);
						$listEmail = '';
						if(isset($_POST['email'])){
							$listEmail = sanitize_email($_POST['email']);
						}
						$listWebsite = sanitize_text_field($_POST['website']);
						$listTwitter = sanitize_text_field($_POST['twitter']);
						$listFacebook = sanitize_text_field($_POST['facebook']);
						$listLinkedin= sanitize_text_field($_POST['linkedin']);
						$listGplus= sanitize_text_field($_POST['google_plus']);
						$listYoutube= sanitize_text_field($_POST['youtube']);
						$listInstagram= sanitize_text_field($_POST['instagram']);
						$listPlanid= sanitize_text_field($_POST['plan_id']);
                        lp_listing_save_additional_metas($listPlanid, $postID);
						$listPrice= sanitize_text_field($_POST['listingprice']);
						$listPText= sanitize_text_field($_POST['listingptext']);
						$listPostVideo= sanitize_text_field($_POST['postVideo']);
						$listClaimedsec= sanitize_text_field($_POST['claimed_section']);
						
						listing_set_metabox('business_hours', $business_hours, $postID);
						listing_set_metabox('price_status', $priceStatus, $postID);
						listing_set_metabox('faqs', $faqs, $postID);
						listing_set_metabox('tagline_text', $listTagline, $postID);
						listing_set_metabox('gAddress', $gaddpress, $postID);
						listing_set_metabox('latitude', $listLatitude, $postID);
						listing_set_metabox('longitude', $listLongitude, $postID);
						listing_set_metabox('phone', $listPhone, $postID);
						listing_set_metabox('email', $listEmail, $postID);
						listing_set_metabox('website', $listWebsite, $postID);
						listing_set_metabox('twitter', $listTwitter, $postID);
						listing_set_metabox('facebook', $listFacebook, $postID);
						listing_set_metabox('linkedin', $listLinkedin, $postID);
						listing_set_metabox('google_plus', $listGplus, $postID);
						listing_set_metabox('youtube', $listYoutube, $postID);
						listing_set_metabox('instagram', $listInstagram, $postID);
						listing_set_metabox('Plan_id', $listPlanid, $postID);
						listing_set_metabox('list_price', $listPrice, $postID);
						listing_set_metabox('list_price_to', $listPText, $postID);
						listing_set_metabox('video', $listPostVideo, $postID);
						listing_set_metabox('claimed_section', $listClaimedsec, $postID);
						//update_post_meta($postID, 'gallery_image_ids', '');
						
						$ids = array();
						
						/* print_r($_FILES["listingfiles"]);
						exit; */
						
							if ( isset($_FILES["lp-featuredimage"]) ) {
								if($_FILES['lp-featuredimage']['size'] != 0) {
									$files = $_FILES["lp-featuredimage"];
									$files2 = $_FILES["listingfiles"];								
									foreach ($files['name'] as $key => $value) { 							
										if ($files['name'][$key]) { 					
											$file = array( 'name' => $files['name'][$key],	 					
											'type' => $files['type'][$key], 						
											'tmp_name' => $files['tmp_name'][$key], 						
											'error' => $files['error'][$key], 						
											'size' => $files['size'][$key] ); 					
											$_FILES = array ("lp-featuredimage" => $file); 					
											$count = 0;					
											foreach ($_FILES as $file => $array) {	
												$newupload = listingpro_handle_attachment_featured($file,$postID); 
											}
										}
										$_FILES["listingfiles"] = '';
										$_FILES["listingfiles"] = $files2;
									}
								}									
							}
							
							
							$result;
							$galleryImagesIDS;
							if ( isset($_FILES["listingfiles"]) ) {
								if($_FILES['listingfiles']['size'] != 0) {
									$files = $_FILES["listingfiles"]; 
									foreach ($files['name'] as $key => $value) { 			
										if ($files['name'][$key]) { 
											$file = array( 
												'name' => $files['name'][$key],
												'type' => $files['type'][$key], 
												'tmp_name' => $files['tmp_name'][$key], 
												'error' => $files['error'][$key],
												'size' => $files['size'][$key]
											); 
											$_FILES = array ("listingfiles" => $file); 
											$count = 0;
											if(!empty($_FILES)) {
												foreach ($_FILES as $file => $array) {

													if( $featImgFromGal==true && !isset($_FILES["lp-featuredimage"]) ){
														$newupload = listingpro_handle_attachment($file,$postID,$set_thu=true);
													}else{
														$newupload = listingpro_handle_attachment($file,$postID,$set_thu=false);
													}												
													array_push($ids,$newupload);
													$count++;
												}
											}
											
										} 
									}					
									if(!empty($ids)){
										$galleryImagesIDS = get_post_meta( $postID, 'gallery_image_ids', true);
										if(!empty($galleryImagesIDS)){
											$galleryImagesIDS = explode( ',', $galleryImagesIDS );
											$result = array_merge($galleryImagesIDS, $ids);
											$img_ids = implode(",", $result);
										}else{
											$img_ids = implode(",", $ids);
											$result = $ids;
										}
										update_post_meta($postID, 'gallery_image_ids', $img_ids);
									}					
								}
							}
							
							/* print_r($result);
							exit; */
							
							
						
						if (isset($_POST['listImg_remove']) && !empty($_POST['listImg_remove'])) {
							$removeIDS = $_POST['listImg_remove'];
							$galleryImagesIDS = get_post_meta( $postID, 'gallery_image_ids', true);
							$galleryImagesIDS = explode( ',', $galleryImagesIDS );
							foreach ( $removeIDS as $key){
								$index = array_search($key,$galleryImagesIDS);
								if($index !== false){
									unset($galleryImagesIDS[$index]);
								}
							}
							$fIDS = implode(",", $galleryImagesIDS);
							update_post_meta($postID, 'gallery_image_ids', $fIDS);
						}
						$response = get_the_permalink($postID);
						die(json_encode(array('llllc'=>$lp_listing_locations, 'response'=>'success', 'status'=>$response, 'responsed'=>$count, 'responsedds'=>$galleryImagesIDS )));

							
					}
				}
			}
			else{
					$response = '<span class="email-exist-error error-msg">'.esc_html__("Please check captcha", "listingpro-plugin").'</span>';
					die(json_encode(array('response'=>'failure', 'status'=>$response, 'dff'=>$processSubmission)));
			}
				
			
		}	
	}