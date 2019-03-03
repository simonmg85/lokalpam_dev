<?php
$currentUserID = get_current_user_id();
$lpAllMessges = get_user_meta($currentUserID, 'lead_messages', true);

?>



<div class="tab-pane fade in active" id="updateprofile">

	<?php
	do_action('lp_pdf_enqueue_scripts');
	global $listingpro_options;
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	// User Name
	$user_fname = get_the_author_meta('first_name', $user_id);
	$user_lname = get_the_author_meta('last_name', $user_id);
	// User contact meta
	$user_address = get_the_author_meta('address', $user_id);
	$user_phone = get_the_author_meta('phone', $user_id);
	$user_email = get_the_author_meta('user_email', $user_id);
	// User Social links
	$user_facebook = get_the_author_meta('facebook', $user_id);
	$user_google = get_the_author_meta('google', $user_id);
	$user_linkedin = get_the_author_meta('linkedin', $user_id);
	$user_instagram = get_the_author_meta('instagram', $user_id);
	$user_twitter = get_the_author_meta('twitter', $user_id);
	$user_pinterest = get_the_author_meta('pinterest', $user_id);
	// User BIO
	$user_desc = get_the_author_meta('description', $user_id);
	$user_ID = $user_id;
	if ($user_ID) {

		/* delete user */
		if(isset($_POST['lp_assign_data'])){
			if(isset($_POST['lp_delte_user_nonce'])){
				$assignListing = esc_html($_POST['lp_assign_data']);
				$current_user = wp_get_current_user();
				if($assignListing=="yes"){
					//yes
					$super_admins = get_users( 'role=administrator' );
					if(!empty($super_admins)){
						$adminID = $super_admins[0]->ID;
						wp_delete_user( $current_user->ID, $adminID);
					}else{
						wp_delete_user( $current_user->ID);
					}
					wp_redirect( home_url() );
					exit;

				}else{
					//no
					wp_delete_user( $current_user->ID );
					wp_redirect( home_url() );
					exit;
				}
			}
		}
		/* end delete user */

		if(isset($_POST['profileupdate'])) {

			$message = esc_html__('Your profile updated successfully.','listingpro');
			$mType = 'success';

			$first = esc_html($_POST['first_name']);
			$last = esc_html($_POST['last_name']);
			$email = esc_html($_POST['email']);
			$user_phone = esc_html($_POST['phone']);
			$user_address = esc_html($_POST['address']);
			$description = esc_html($_POST['desc']);

			$facebook = esc_html($_POST['facebook']);
			$google = esc_html($_POST['google']);
			$linkedin = esc_html($_POST['linkedin']);
			$instagram = esc_html($_POST['instagram']);
			$twitter = esc_html($_POST['twitter']);
			$pinterest = esc_html($_POST['pinterest']);

			$password = esc_html($_POST['pwd']);
			$confirm_password = esc_html($_POST['confirm']);

			update_user_meta( $user_ID, 'first_name', $first );
			update_user_meta( $user_ID, 'last_name', $last );
			update_user_meta( $user_ID, 'phone', $user_phone );
			update_user_meta( $user_ID, 'address', $user_address );
			update_user_meta( $user_ID, 'description', $description );

			update_user_meta( $user_ID, 'facebook', $facebook );
			update_user_meta( $user_ID, 'google', $google );
			update_user_meta( $user_ID, 'linkedin', $linkedin );
			update_user_meta( $user_ID, 'instagram', $instagram );
			update_user_meta( $user_ID, 'twitter', $twitter );
			update_user_meta( $user_ID, 'pinterest', $pinterest );

			$your_image_url = $_POST['your_author_image_url'];
			$author_avatar_url = get_user_meta($user_ID, "listingpro_author_img_url", true);
			if($your_image_url != ''){
				update_user_meta( $user_ID, 'listingpro_author_img_url', $your_image_url );
			}else{
				update_user_meta( $user_ID, 'listingpro_author_img_url', $author_avatar_url );
			}

			if(isset($email) && is_email($email)) {
				wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;
			}else {
				$message = "Please enter a valid email id.";
				$mType = 'error';
			}

			if($password) {
				if (strlen($password) < 5 || strlen($password) > 15) {
					$message = "Password must be 5 to 15 characters in length";
					$mType = 'error';
				}
				//elseif( $password == $confirm_password ) {
                elseif(isset($password) && $password != $confirm_password) {
					$message = esc_html__('Password Mismatch','listingpro');
					$mType = 'error';
				} elseif ( isset($password) && !empty($password) ) {
					$lpCUser = wp_get_current_user();
					$update = wp_set_password( $password, $user_ID );
					wp_set_auth_cookie($lpCUser->ID);
					wp_set_current_user($lpCUser->ID);
					do_action('wp_login', $lpCUser->user_login, $lpCUser);
					$message = esc_html__('Your profile updated successfully.','listingpro');
					$mType = esc_html__('success','listingpro');
				}
			}
			$updateTab = true;
		}
	}
	?>
    <div class="user-recent-listings-inner tab-pane fade in active lp-update-profile-container" id="inbox">
        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-12 lp-left-panel-height lp-update-profile">
            <div class="tab-header lp-update-password-outer">
                <h3><?php echo esc_html__('Update Profile Details', 'listingpro'); ?></h3>
            </div>
            <div class="updateprofile-tab">
                <div class="updateprofile-tab aligncenter">


					<?php if(isset($message) && !empty($message)){ ?>
                        <div class="notification <?php echo esc_attr($mType); ?> clearfix">
                            <div class="noti-icon">	</div>
                            <p><?php echo esc_html($message); ?></p>
                        </div>
					<?php } ?>

                    <form class="form-horizontal" id="profileupdate" action="" method="POST" enctype="multipart/form-data">
                        <div class="page-innner-container padding-40 lp-border lp-border-radius-8">
                            <div class="user-avatar-upload lp-border-bottom padding-bottom-45">
                                <div class="user-avatar-preview avatar-circle">
                                    <img class="author-avatar" src="<?php echo listingpro_author_image(); ?>" alt="userimg" />
                                </div>
                                <div class="user-avatar-description">
                                    <p class="paragraph-form">
										<?php echo esc_html__('Update your photo manually If the photo is not set the default Gravatar will be the same as your login email account', 'listingpro'); ?><br>
                                    </p>
                                    <div class="upload-photo margin-top-25">
																<span class="file-input file-upload-btn btn-first-hover btn-file">
																	<?php echo esc_html__('Upload Photo', 'listingpro'); ?>&hellip; <input class="upload-author-image" type="file" accept="image/*" />
																</span>
                                        <input class="criteria-image-url" id="your_image_url" type="text" size="36" name="your_author_image_url" style="display: none;" value="<?php if (isset($your_image_url)){ echo esc_attr($your_image_url); } ?>" />
                                        <input class="criteria-image-id" id="your_image_id" type="text" size="36" name="your_author_image_id" style="display: none;" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="Fname"><?php echo esc_html__('First Name', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_fname); ?>" type="text" class="form-control" name="first_name" id="Fname" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="Lname"><?php echo esc_html__('Last Name', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_lname); ?>" type="text" class="form-control" name="last_name" id="Lname" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="uemail"><?php echo esc_html__('Email', 'listingpro'); ?>*</label>
                                    <input value="<?php echo esc_attr($user_email); ?>" type="email" class="form-control" name="email" id="uemail" placeholder="<?php esc_html_e('eg. example@gmal.com','listingpro'); ?>" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="phone"><?php echo esc_html__('Phone', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_phone); ?>" type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo esc_html__('+00-12345-7890', 'listingpro'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="address"><?php echo esc_html__('Address', 'listingpro'); ?></label>
                                    <textarea  class="form-control" name="address" id="address" rows="3" placeholder="<?php esc_html_e('Your Address','listingpro'); ?>"><?php echo esc_html($user_address); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="about"><?php echo esc_html__('About', 'listingpro'); ?></label>
                                    <textarea  class="form-control" name="desc" id="about" rows="8" placeholder="<?php esc_html_e('Write about youself','listingpro'); ?>"><?php echo esc_html($user_desc); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="facebook"><?php echo esc_html__('Facebook', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_facebook); ?>" type="text" class="form-control" name="facebook" id="facebook" placeholder="<?php esc_html_e('enter facebook profile url','listingpro'); ?>" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="twitter"><?php echo esc_html__('Twitter', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_twitter); ?>" type="text" class="form-control" name="twitter" id="twitter" placeholder="<?php esc_html_e('enter twitter profile url','listingpro'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="linkedin"><?php echo esc_html__('Linkedin', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_linkedin); ?>" type="text" class="form-control" name="linkedin" id="linkedin" placeholder="<?php esc_html_e('enter linkedin profile url','listingpro'); ?>" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="google"><?php echo esc_html__('Google', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_google); ?>" type="text" class="form-control" name="google" id="google" placeholder="<?php esc_html_e('enter google profile url','listingpro'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="instagram"><?php echo esc_html__('Instagram', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_instagram); ?>" type="text" class="form-control" name="instagram" id="instagram" placeholder="<?php esc_html_e('enter instagram profile url','listingpro'); ?>" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="pinterest"><?php echo esc_html__('Pinterest', 'listingpro'); ?></label>
                                    <input value="<?php echo esc_attr($user_pinterest); ?>" type="text" class="form-control" name="pinterest" id="pinterest" placeholder="<?php esc_html_e('enter pinterest profile url','listingpro'); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix margin-top-30"></div>
                        <div class="tab-header lp-update-password-outer margin-top-30">
                            <h3><?php echo esc_html__('Update Password', 'listingpro'); ?></h3>
                        </div>
                        <div class="page-innner-container padding-40 lp-border lp-border-radius-8 margin-bottom-30">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="npassword"><?php echo esc_html__('New Password', 'listingpro'); ?></label>
                                    <input type="password" class="form-control" name="pwd" id="npassword" placeholder="<?php esc_html_e('write new password','listingpro'); ?>" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="rnpassword"><?php echo esc_html__('Repeat Password', 'listingpro'); ?></label>
                                    <input type="password" class="form-control" name="confirm" id="rnpassword" placeholder="<?php esc_html_e('write again your new password','listingpro'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p class="paragraph-form"><?php echo esc_html__('Enter same password in both fields Use an uppercase letter and a number for stronger password', 'listingpro'); ?>.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" name="profileupdate" value="<?php echo esc_html__('Update profile', 'listingpro'); ?>" class="lp-secondary-big-btn btn-first-hover" />
                                </div>
                            </div>

                        </div>

                    </form>

                    <!-- listingpro GDPR -->
                    <form class="form-horizontal" id="lp_delete_user_profile" action="" method="POST">
                        <div class="form-group">

                            <div class="col-sm-6 text-left">
                                <button type="button" class="btn btn-success btn-sm" id="lp_profile_pdf"><i class="fa fa-download"></i> <?php echo esc_html__('Download Profile', 'listingpro'); ?></button>
                            </div>

			                <?php
			                if( !current_user_can('administrator')){
				                ?>

                                <div class="col-sm-6 text-right">
                                    <button type="button" id="lpwanttodelete" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#lp_delete_accountpopup" ><i class="fa fa-trash"></i> <?php echo esc_html__('Delete Account', 'listingpro'); ?></button>

					                <?php wp_nonce_field( '', 'lp_delte_user_nonce' ); ?>
                                </div>

                                <!-- Modal -->
                                <div id="lp_delete_accountpopup" class="modal fade" role="dialog" data-backdrop="false">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><?php echo esc_html__('Delete Account', 'listingpro'); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo esc_html__('What should be done with content owned by you?', 'listingpro'); ?></p>

                                                <div class="radio">
                                                    <label><input type="radio" class="lp_assign_data" name="lp_assign_data" value="no"><?php echo esc_html__('Delete all content.', 'listingpro'); ?></label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" class="lp_assign_data" name="lp_assign_data" value="yes"><?php echo esc_html__('Attribute all content to super admin of website', 'listingpro'); ?></label>
                                                </div>

                                                <button type="submit" class="btn btn-danger margin-top-20 lp_delte_user_confirm" disabled><?php echo esc_html__('Confirm Deletion', 'listingpro'); ?></button>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo esc_html__('Close', 'listingpro'); ?></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
				                <?php
			                }
			                ?>

                        </div>
                    </form>

                    <!-- end listingpro GDPR -->
                </div>
            </div>
            <!-- html for pdf -->
            <div id="lp_profile_for_pdf" style="display:none">
                <h2 style="margin-left:500px"><?php echo esc_html__('Profile Data', 'listingpro'); ?></h2>
                <ul class="list-group">
                    <li class="list-group-item"><?php echo esc_html__('First Name', 'listingpro'); ?> : <?php echo $user_fname; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Last Name', 'listingpro'); ?> : <?php echo $user_lname; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Email', 'listingpro'); ?> : <?php echo $user_email; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Phone', 'listingpro'); ?> : <?php echo $user_phone; ?></li>

                    <li class="list-group-item"><?php echo esc_html__('Facebook', 'listingpro'); ?> : <?php echo $user_facebook; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Twitter', 'listingpro'); ?> : <?php echo $user_twitter; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Linkedin', 'listingpro'); ?> : <?php echo $user_linkedin; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Google', 'listingpro'); ?> : <?php echo $user_google; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Instagram', 'listingpro'); ?> : <?php echo $user_instagram; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('Pinterest', 'listingpro'); ?> : <?php echo $user_pinterest; ?></li>

                    <li class="list-group-item"><?php echo esc_html__('Address', 'listingpro'); ?> : <?php echo $user_address; ?></li>
                    <li class="list-group-item"><?php echo esc_html__('About', 'listingpro'); ?> : <?php echo $user_desc; ?></li>

                </ul>
            </div>
            <!-- end html for pdf -->

        </div>


    </div>

</div>
<!--updateprofile-->