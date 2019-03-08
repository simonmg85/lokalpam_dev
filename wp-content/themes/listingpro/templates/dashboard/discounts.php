<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;


$d_args =   array(
    'post_type' => 'listing',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user_id,
    'meta_key' => 'listing_discount_data',
    'meta_compare' => 'EXISTS'
);
$d_listings  =   new WP_Query($d_args);
$count_d_listings    =   $d_listings->found_posts;


$time_now   =   strtotime("now");

?>
<?php
ajax_response_markup();
?>
<!-- Modal -->
<div class="modal fade" id="dashboard-delete-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-delete-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo esc_html__( 'are you sure you want to delete?' ); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                <button type="button" class="btn btn-primary dashboard-confirm-del-btn"><?php echo esc_html__( 'Delete', 'listingpro' ); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade in active lp-coupns-form" id="lp-listings">
    <?php
    if( $count_d_listings == 0 ):
        ?>
        <div class="lp-blank-section">
            <div class="col-md-12 blank-left-side">
                <img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
               <h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
					<p class="margin-bottom-20"><?php echo esc_html__('You must be here for the first time. If you like to add some thing, click the button below.', 'listingpro'); ?></p>
                <button data-form="discount" class="lp-add-new-btn add-new-open-form"><span><i class="fa fa-plus" aria-hidden="true"></i></span><?php echo esc_html__('Add new coupon', 'listingpro'); ?> </button>
            </div>
        </div>
        <?php
    else:
        ?>

        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-12">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab"><?php esc_html_e('all deals','listingpro'); ?></a></li>
                    <li><a href="#tab2default" data-toggle="tab"><?php esc_html_e('active','listingpro'); ?></a></li>
                    <li><a href="#tab3default" data-toggle="tab"><?php esc_html_e('expired','listingpro'); ?></a></li>
                    <button class="lp-add-new-btn add-new-open-form" data-form="discount"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('add new coupon','listingpro'); ?></button>
	                <?php
	                global $listingpro_customizer_options;
	                $active_detail_page =   $listingpro_customizer_options['detail_page']['active'];
	                if( $active_detail_page != 1 || !is_plugin_active( 'listingpro-visualizer/plugin.php' ) ):
		                ?>
                        <div class="form-group clearfix  margin-0">
                            <div class="select2-dash  col-sm-5 pull-right">
				                <?php
				                $current_user = wp_get_current_user();
				                $user_id = $current_user->ID;
				                $discount_displayin =   get_user_meta( $user_id, 'discount_display_area', true );
				                ?>
                                <div class="discount_displayin_wrap clearfix pull-right">
                                    <span class="discount_displayin_wrap_title"><?php echo esc_html__( 'Display In', 'listingpro'); ?></span>
                                    <select class="form-control select2" id="discount_displayin" data-udi="<?php echo $user_id; ?>">
                                        <option value="content" <?php if( $discount_displayin == 'content' ): echo 'selected="selected"'; endif; ?>><?php echo esc_html__( 'Content Area', 'listingpro' ); ?></option>
                                        <option value="sidebar" <?php if( $discount_displayin == 'sidebar' ): echo 'selected="selected"'; endif; ?>><?php echo esc_html__( 'Sidebar Area', 'listingpro'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
	                <?php endif; ?>
                </ul>
            </div>
            <div class="panel-body">
                <div class="lp-main-title clearfix">
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('deal','listingpro'); ?></p></div>
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('Coupon code','listingpro'); ?></p></div>
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('discount','listingpro'); ?></p></div>
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('start date','listingpro'); ?></p></div>
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('end date','listingpro'); ?></p></div>
                    <div class="col-md-2 text-center"><p><?php echo esc_html__('status','listingpro'); ?></p></div>
                </div>
                <div class="tab-content clearfix">
                    <div class="tab-pane fade in active" id="tab1default">
                        <?php
                        if( $d_listings->have_posts() ): while ( $d_listings->have_posts() ): $d_listings->the_post();
                            global $post;
                            $lid    =   get_the_ID();
                            $listing_discount_data  =   get_post_meta( $post->ID, 'listing_discount_data', true );
                            foreach ( $listing_discount_data as $key => $discount_data ):
                                $disID  =   $lid.'-'.$key;
                                $active_class   =   'lp-cuopon-expired-btn';
                                $active_data    =   'no';
                                $active_text    =   esc_html__( 'Inactive', 'listingpro' );
                                if( $discount_data['disSta'] == 'active' )
                                {
                                    $active_data    =   'yes';
                                    $active_class   =   '';
                                    $active_text    =   esc_html__( 'Active', 'listingpro' );
                                }
									$external_coupon    =   false;
								   if( !empty( $discount_data['disBL'] ) )
								   {
									   $external_coupon    =   true;
								   }
                                ?>
                                <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                    <div class="col-md-2 text-center">
                                        <div class="lp-deal-title lp-content-before-after" data-content="<?php esc_html_e('Deal','listingpro'); ?>">
                                            <p><?php echo substr( $discount_data['disHea'], 0, 19 ).'...'; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="lp-coupon-code-section lp-content-before-after" data-content="<?php echo esc_html__('Coupon Code','listingpro'); ?>">
                                            <?php
                                            if( $discount_data['disCod'] == '' ): echo '-'; else: echo '<p>'.$discount_data['disCod'].'</p>'; endif;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Discount','listingpro'); ?>">

                                        <div class="lp-listing-expire-section">
                                            <p>
                                                <?php
                                                if( $discount_data['disOff'] == '' ): echo '-'; else: echo $discount_data['disOff']; endif;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Start Date','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p>
                                                <?php
                                                if( $discount_data['disExpS'] == '' ): echo '-'; else: echo date_i18n( get_option('date_format'), $discount_data['disExpS'] ); endif;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('End Date','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p>
                                                <?php
                                                if( $discount_data['disExpE'] == '' ): echo '-'; else: echo date( 'M d, Y', $discount_data['disExpE'] ); endif;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <div class="lp-dot-extra-buttons">
                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                    <ul class="lp-user-menu list-style-none">
                                                        <li><a href="" class="dis-edit" data-targetid="<?php echo $disID; ?>" data-disID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php esc_html_e('Edit','listingpro'); ?></span></a></li>
                                                        <li><a href="" class="dis-del del-this" data-targetID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-trash-o"></i><span><?php esc_html_e('Delete','listingpro'); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="lp-listing-pay-outer pull-right <?php echo $active_class; ?>">
                                                <?php
                                                $expiry_date    =   $discount_data['disExpE'];
                                               $date_start     =   $discount_data['disExpS'];
                                               if( ( !empty( $expiry_date ) && $time_now < $expiry_date ) && ( !empty( $date_start ) && $time_now > $date_start ) ):
                                                    ?>
                                                    <a class="lp-listing-pay-button"> <?php esc_html_e('active','listingpro'); ?></a>
                                                <?php else: ?>
                                                    <a class="lp-listing-pay-button inactive"> <?php esc_html_e('inactive','listingpro'); ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="display: none;" id="update-wrap-<?php echo $disID; ?>" class="lp-coupns-form-outer margin-top-30">
                                        <div class="lp-voupon-box">
                                            <form class="lp-coupons-form-inner">
                                                <div class="lp-coupon-box-row">
                                                    <div class="row">
                                                        <div class="form-group col-sm-7 ">

                                                            <div class="margin-bottom-20">
                                                                <label for="dis-heading-<?php echo $disID; ?>"><?php echo esc_html__('Title', 'listingpro'); ?></label>
                                                                <input value="<?php echo $discount_data['disHea']; ?>" name="dis-heading-<?php echo $disID; ?>" id="dis-heading-<?php echo $disID; ?>" class="form-control" type="text" placeholder="<?php echo esc_html__('e.g. 46% Off - Two Vouchers Each Valid for One Large Specialty Pizza', 'listingpro'); ?>">
                                                            </div>
                                                            <div class="">
                                                                <label for="dis-description-<?php echo $disID; ?>"><?php echo esc_html__('Description', 'listingpro'); ?></label>
                                                                <textarea class="form-control" rows="10" name="dis-description-<?php echo $disID; ?>" id="dis-description-<?php echo $disID; ?>" placeholder="<?php echo esc_html__('e.g. Choice of: Two vouchers: Each Good for One Large Specialty Pizza $20 Value', 'listingpro'); ?>"><?php echo $discount_data['disDes']; ?></textarea>
                                                            </div>
                                                        </div>
														<div class="col-sm-5">
                                                           <div class="jFiler-input-dragDrop pos-relative">
                                                               <input type="hidden" id="dis-old-img-<?php echo $disID; ?>" value="<?php echo $discount_data['disImg']; ?>">
                                                               <div class="upload-field dashboard-upload-field edit-upload-<?php echo $disID; ?>">
                                                                   <?php echo do_shortcode('[frontend-button]'); ?>
																   <?php
																	  if( !empty( $discount_data['disImg'] ) ):
																	  ?>
																	  <img class="lp-uploaded-img event-old-img-<?php echo $disID; ?>" src="<?php echo $discount_data['disImg']; ?>" alt="">
																	<?php endif; ?>
                                                               </div>                                                               
                                                           </div>
                                                       </div>
                                                    </div>
                                                </div>
                                                <div class="lp-coupon-box-row">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6 ">
                                                            <div class="">
                                                                <label for="dis-expiry-s-<?php echo $disID; ?>"><?php echo esc_html__('Start Date', 'listingpro'); ?></label>
                                                                <input value="<?php echo date( 'M d, Y', $discount_data['disExpS'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-s-<?php echo $disID; ?>" id="dis-expiry-s-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                            </div>

                                                        </div>
                                                        <div class="form-group col-sm-6 ">
                                                            <div class="">
                                                                <label for="dis-expiry-e-<?php echo $disID; ?>"><?php echo esc_html__('End Date', 'listingpro'); ?></label>
                                                                <input value="<?php echo date( 'M d, Y', $discount_data['disExpE'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-e-<?php echo $disID; ?>" id="dis-expiry-e-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="lp-coupon-box-row">
                                                    <div class="row">

			                                            <?php
			                                            if( $external_coupon == false ):
				                                            ?>
                                                            <div class="form-group col-sm-6">
                                                                <div class="">
                                                                    <label for="dis-code-<?php echo $disID; ?>"><?php echo esc_html__('Coupon Code', 'listingpro'); ?></label>
                                                                    <input value="<?php echo $discount_data['disCod']; ?>" name="dis-code-<?php echo $disID; ?>" id="dis-code-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. SUMMER50', 'listingpro'); ?>">
                                                                </div>
                                                            </div>
			                                            <?php endif; ?>
			                                            <?php
			                                            if( $external_coupon == true ):
				                                            ?>
                                                            <div class="form-group col-sm-6">
                                                                <div class="">
                                                                    <label for="dis-btn-link-<?php echo $disID; ?>"><?php echo esc_html__('Custom URL (Button)', 'listingpro'); ?></label>
                                                                    <input value="<?php echo $discount_data['disBL']; ?>" name="dis-btn-link-<?php echo $disID; ?>" id="dis-btn-link-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://www.example.com', 'listingpro'); ?>">
                                                                </div>
                                                            </div>
			                                            <?php endif; ?>
                                                        <div class="form-group col-sm-6">
                                                            <div class="">
                                                                <label for="dis-off-<?php echo $disID; ?>"><?php echo esc_html__('Discount Value', 'listingpro'); ?></label>
                                                                <input value="<?php echo $discount_data['disOff']; ?>" name="dis-off-<?php echo $disID; ?>" id="dis-off-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. 50% || $50', 'listingpro'); ?>">
                                                            </div>
                                                        </div>
                                                        <p class="col-md-12 margin-top-10"><?php echo esc_html__("*Skip this if your deal doesn't include a coupon", 'listingpro'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="lp-coupon-box-row">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <div class="">
                                                                <label for="dis-btn-text-<?php echo $disID; ?>"><?php echo esc_html__('Custom Text (Button)', 'listingpro'); ?></label>
                                                                <input value="<?php echo $discount_data['disBT']; ?>" name="dis-btn-text-<?php echo $disID; ?>" id="dis-btn-text-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. CLICK HERE', 'listingpro'); ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <p class="col-md-12 margin-top-10"><?php echo esc_html__('*If left blank the default text "CLICK HERE" will be used. ', 'listingpro'); ?></p>
                                                        <p class="col-md-12"><?php echo esc_html__('*Only enable Custom URL if you would like to redirect users to an external link. ', 'listingpro'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="lp-coupon-box-row">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6 ">
                                                            <div class="">
                                                                <input type="text" class="form-control" value="<?php echo get_the_title( $lid ); ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-6 text-right">
                                                            <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                            <button data-listid="<?php echo $lid; ?>" data-disid="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-edit-dis lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; endwhile;; wp_reset_postdata(); else: ?>
                            <p><?php echo esc_html__( 'nothing found', 'listingpro' ); ?></p>
                            <?php
                        endif;
                        ?>
                    </div>
                    <div class="tab-pane fade" id="tab2default">
                        <?php
                        if( $d_listings->have_posts() ): while ( $d_listings->have_posts() ): $d_listings->the_post();
                            global $post;
                            $lid    =   get_the_ID();
                            $listing_discount_data  =   get_post_meta( $post->ID, 'listing_discount_data', true );
                            $strNow =   strtotime("NOW");
                            foreach ( $listing_discount_data as $key => $discount_data ):
                                $expiry_date    =   $discount_data['disExpE'];
                                if( !empty( $expiry_date ) && $time_now < $expiry_date ):
                                    if( ( $strNow < $discount_data['disExpE'] || empty( $discount_data['disExpE'] ) ) && ( $strNow > $discount_data['disExpS'] || empty( $discount_data['disExpS'] ) ) ) :
                                        $disID  =   $lid.'-'.$key;
                                        $active_class   =   'lp-cuopon-expired-btn';
                                        $active_data    =   'no';
                                        $active_text    =   esc_html__( 'Inactive', 'listingpro' );
                                        if( $discount_data['disSta'] == 'active' )
                                        {
                                            $active_data    =   'yes';
                                            $active_class   =   '';
                                            $active_text    =   esc_html__( 'Active', 'listingpro' );
                                        }
                                        ?>
                                        <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                            <div class="col-md-2 text-center">
                                                <div class="lp-deal-title lp-content-before-after" data-content="<?php esc_html_e('Deal','listingpro'); ?>">
                                                    <p><?php echo substr( $discount_data['disHea'], 0, 19 ).'...'; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <div class="lp-coupon-code-section lp-content-before-after" data-content="<?php echo esc_html__('Coupon Code','listingpro'); ?>">
                                                    <p><?php echo $discount_data['disCod']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Discount','listingpro'); ?>">

                                                <div class="lp-listing-expire-section">
                                                    <p><?php echo $discount_data['disOff']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Start End','listingpro'); ?>">
                                                <div class="lp-listing-expire-section">
                                                    <p><?php echo date( 'M d, Y', $discount_data['disExpS'] ); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('End Date','listingpro'); ?>">

                                                <div class="lp-listing-expire-section">
                                                    <p>
                                                    <?php
                                                    if( $discount_data['disExpE'] == '' ): echo '-'; else: echo date( 'M d, Y', $discount_data['disExpE'] ); endif;
                                                    ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                                <div class="clearfix">
                                                    <div class="pull-right">
                                                        <div class="lp-dot-extra-buttons">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                            <ul class="lp-user-menu list-style-none">
                                                                <li><a href="" class="dis-edit" data-targetid="<?php echo $disID; ?>" data-disID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__( 'Edit', 'listingpro' ); ?></span></a></li>
                                                                <li><a href="" class="dis-del del-this" data-targetID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-trash-o"></i><span><?php echo esc_html__( 'Delete', 'listingpro' ); ?></span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="lp-listing-pay-outer pull-right <?php echo $active_class; ?>">
                                                        <a href="" data-active="<?php $discount_data['disSta']; ?>" class="lp-listing-pay-button"> <?php echo $active_text; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none;" id="update-wrap-<?php echo $disID; ?>" class="lp-coupns-form-outer">
                                                <div class="lp-voupon-box">
                                                    <form class="lp-coupons-form-inner">
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">

                                                                    <div class="margin-bottom-20">
                                                                        <label for="dis-heading-<?php echo $disID; ?>"><?php echo esc_html__('Title', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disHea']; ?>" name="dis-heading-<?php echo $disID; ?>" id="dis-heading-<?php echo $disID; ?>" class="form-control" type="text" placeholder="<?php echo esc_html__('e.g. 46% Off - Two Vouchers Each Valid for One Large Specialty Pizza', 'listingpro'); ?>">
                                                                    </div>
                                                                    <div class="">
                                                                        <label for="dis-description-<?php echo $disID; ?>"><?php echo esc_html__('Description', 'listingpro'); ?></label>
                                                                        <textarea class="form-control" rows="10" name="dis-description-<?php echo $disID; ?>" id="dis-description-<?php echo $disID; ?>" placeholder="<?php echo esc_html__('e.g. Choice of: Two vouchers: Each Good for One Large Specialty Pizza $20 Value', 'listingpro'); ?>"><?php echo $discount_data['disDes']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-expiry-s-<?php echo $disID; ?>"><?php echo esc_html__('Start Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $discount_data['disExpS'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-s-<?php echo $disID; ?>" id="dis-expiry-s-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>

                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-expiry-e-<?php echo $disID; ?>"><?php echo esc_html__('End Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $discount_data['disExpE'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-e-<?php echo $disID; ?>" id="dis-expiry-e-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-code-<?php echo $disID; ?>"><?php echo esc_html__('Coupon Code', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disCod']; ?>" name="dis-code-<?php echo $disID; ?>" id="dis-code-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. SUMMER50', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-off-<?php echo $disID; ?>"><?php echo esc_html__('Discount Value %', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disOff']; ?>" id="dis-off-<?php echo $disID; ?>" name="dis-off-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. 50% || $50', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <p class="col-md-12 margin-top-10"><?php echo esc_html__("*Skip this if your deal doesn't include a coupon", 'listingpro'); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-btn-text-<?php echo $disID; ?>"><?php echo esc_html__('Custom Text (Button)', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disBT']; ?>" name="dis-btn-text-<?php echo $disID; ?>" id="dis-btn-text-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. CLICK HERE', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-btn-link-<?php echo $disID; ?>"><?php echo esc_html__('Custom URL (Button)', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disBL']; ?>" name="dis-btn-link-<?php echo $disID; ?>" id="dis-btn-link-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://www.example.com', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <p class="col-md-12 margin-top-10"><?php echo esc_html__('*If left blank the default text "CLICK HERE" will be used. ', 'listingpro'); ?></p>
                                                                <p class="col-md-12"><?php echo esc_html__('*Only enable Custom URL if you would like to redirect users to an external link. ', 'listingpro'); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <input type="text" class="form-control" value="<?php echo get_the_title( $lid ); ?>" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 text-right">
                                                                    <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                                    <button data-listid="<?php echo $lid; ?>" data-disid="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-edit-dis lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endif; //time check ends
                                endif;  //status check ends
                            endforeach; endwhile;; wp_reset_postdata(); else:
                            ?>
                            <p><?php echo esc_html__( 'nothing found', 'listingpro' ); ?></p>
                            <?php
                        endif;
                        ?>
                    </div>
                    <div class="tab-pane fade" id="tab3default">
                        <?php
                        $expired_message    =   '';
                        if( $d_listings->have_posts() ): while ( $d_listings->have_posts() ): $d_listings->the_post();
                            global $post;
                            $lid    =   get_the_ID();
                            $listing_discount_data  =   get_post_meta( $post->ID, 'listing_discount_data', true );
                            $strNow =   strtotime("NOW");
                            foreach ( $listing_discount_data as $key => $discount_data ):
                                $expiry_date    =   $discount_data['disExpE'];

                                if( empty( $expiry_date ) || $expiry_date < $time_now ):
                                        $disID  =   $lid.'-'.$key;
                                        $active_class   =   'lp-cuopon-expired-btn';
                                        $active_data    =   'no';
                                        $active_text    =   esc_html__( 'Inactive', 'listingpro' );
                                        if( $discount_data['disSta'] == 'active' )
                                        {
                                            $active_data    =   'yes';
                                            $active_class   =   '';
                                            $active_text    =   esc_html__( 'Active', 'listingpro' );
                                        }
                                        ?>
                                        <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                            <div class="col-md-2 text-center">
                                                <div class="lp-deal-title lp-content-before-after" data-content="<?php esc_html_e('Deal','listingpro'); ?>">
                                                    <p><?php echo substr( $discount_data['disHea'], 0, 19 ).'...'; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <div class="lp-coupon-code-section lp-content-before-after" data-content="<?php echo esc_html__('Coupon Code','listingpro'); ?>">
                                                    <p><?php echo $discount_data['disCod']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Discount','listingpro'); ?>">

                                                <div class="lp-listing-expire-section">
                                                    <p><?php echo $discount_data['disOff']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Start Date','listingpro'); ?>">
                                                <div class="lp-listing-expire-section">
                                                    <p><?php echo date( 'M d, Y', $discount_data['disExpS'] ); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('End Date','listingpro'); ?>">

                                                <div class="lp-listing-expire-section">
                                                    <p>
                                                    <?php
                                                    if( $discount_data['disExpE'] == '' ): echo '-'; else: echo date( 'M d, Y', $discount_data['disExpE'] ); endif;
                                                    ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                                <div class="clearfix">
                                                    <div class="pull-right">
                                                        <div class="lp-dot-extra-buttons">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                            <ul class="lp-user-menu list-style-none">
                                                                <li><a href="" class="dis-edit" data-targetid="<?php echo $disID; ?>" data-disID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__( 'Edit', 'listingpro' ); ?></span></a></li>
                                                                <li><a href="" class="dis-del del-this" data-targetID="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-trash-o"></i><span><?php echo esc_html__( 'Delete', 'listingpro' ); ?></span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="lp-listing-pay-outer pull-right <?php echo $active_class; ?>">
                                                        <a class="lp-listing-pay-button inactive"> <?php esc_html_e('inactive','listingpro'); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none;" id="update-wrap-<?php echo $disID; ?>" class="lp-coupns-form-outer">
                                                <div class="lp-voupon-box">
                                                    <form class="lp-coupons-form-inner">
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">

                                                                    <div class="margin-bottom-20">
                                                                        <label for="dis-heading-<?php echo $disID; ?>"><?php echo esc_html__('Title', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disHea']; ?>" name="dis-heading-<?php echo $disID; ?>" id="dis-heading-<?php echo $disID; ?>" class="form-control" type="text" placeholder="<?php echo esc_html__('e.g. 46% Off - Two Vouchers Each Valid for One Large Specialty Pizza', 'listingpro'); ?>">
                                                                    </div>
                                                                    <div class="">
                                                                        <label for="dis-description-<?php echo $disID; ?>"><?php echo esc_html__('Description', 'listingpro'); ?></label>
                                                                        <textarea class="form-control" rows="10" name="dis-description-<?php echo $disID; ?>" id="dis-description-<?php echo $disID; ?>" placeholder="<?php echo esc_html__('e.g. Choice of: Two vouchers: Each Good for One Large Specialty Pizza $20 Value', 'listingpro'); ?>"><?php echo $discount_data['disDes']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-expiry-s-<?php echo $disID; ?>"><?php echo esc_html__('Start Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $discount_data['disExpS'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-s-<?php echo $disID; ?>" id="dis-expiry-s-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>

                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-expiry-e-<?php echo $disID; ?>"><?php echo esc_html__('End Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $discount_data['disExpE'] ); ?>" min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-e-<?php echo $disID; ?>" id="dis-expiry-e-<?php echo $disID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-code-<?php echo $disID; ?>"><?php echo esc_html__('Coupon Code', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disCod']; ?>" name="dis-code-<?php echo $disID; ?>" id="dis-code-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. SUMMER50', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="dis-off-<?php echo $disID; ?>"><?php echo esc_html__('Discount Value %', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disOff']; ?>" id="dis-off-<?php echo $disID; ?>" name="dis-off-<?php echo $disID; ?>" type="text" class="form-control" placeholder="e.g. 50% || $50">
                                                                    </div>
                                                                </div>
                                                                <p class="col-md-12 margin-top-10"><?php echo esc_html__("*Skip this if your deal doesn't include a coupon", 'listingpro'); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-btn-text-<?php echo $disID; ?>"><?php echo esc_html__('Custom Text (Button)', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disBT']; ?>" name="dis-btn-text-<?php echo $disID; ?>" id="dis-btn-text-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. CLICK HERE', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <div class="">
                                                                        <label for="dis-btn-link-<?php echo $disID; ?>"><?php echo esc_html__('Custom URL (Button)', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $discount_data['disBL']; ?>" name="dis-btn-link-<?php echo $disID; ?>" id="dis-btn-link-<?php echo $disID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://www.listingprowp.com', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                                <p class="col-md-12 margin-top-10"><?php echo esc_html__('*If left blank the default text "CLICK HERE" will be used. ', 'listingpro'); ?></p>
                                                                <p class="col-md-12"><?php echo esc_html__('*Only enable Custom URL if you would like to redirect users to an external link. ', 'listingpro'); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <input type="text" class="form-control" value="<?php echo get_the_title( $lid ); ?>" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 text-right">
                                                                    <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                                    <button data-listid="<?php echo $lid; ?>" data-disid="<?php echo $disID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-edit-dis lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    else:
//                                        $expired_message    =   '<p>'.esc_html__( 'No Expired Events' ).'</p>';
                                        $expired_message    =   '';
                                    endif; //time check ends
                            endforeach; endwhile;; wp_reset_postdata(); else:
                            ?>
                            <p><?php echo $expired_message; ?></p>
                            <?php
                        endif;
                        ?>
                        <?php echo $expired_message; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif;
    ?>
    <div style="display: none" id="discount-form-toggle">
        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-9 lp-left-panel-height padding-top-0">
            <div class="lp-review-sorting clearfix padding-left-0 padding-top-0">
                <h5 class="margin-top-0"><?php echo esc_html__('Create Coupon', 'listingpro'); ?></h5>
            </div>
            <div class="panel-body margin-bottom-general-form">
                <div class="lp-listing-selecter clearfix background-white">
                    <div class="form-group col-sm-6 ">
                        <div class="lp-listing-selecter-content">
                            <h5 class="margin-top-18"><?php esc_html_e('Select a Listing','listingpro'); ?></h5>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <div class="lp-listing-selecter-drop">
							<div class="lp-pp-noa-tip">
							 	<i class="fa fa-exclamation" aria-hidden="true"></i> <?php echo esc_html__('Discount/Deals not allowed with this listing. Please upgrade your plan.', 'listingpro'); ?>
							</div>
                            <select data-metakey="deals" class="form-control select2-ajax" name="dis-listing" id="dis-listing">
								<option value="0"><?php echo esc_html__('Select Listing', 'listingpro'); ?></option>
							</select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-coupns-form-outer">
                <div class="lp-voupon-box">
                    <form class="lp-coupons-form-inner">
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                <div class="form-group col-sm-7 ">

                                    <div class="margin-bottom-20">
                                        <label for="dis-heading"><?php echo esc_html__('Title', 'listingpro'); ?></label>
                                        <input name="dis-heading" id="dis-heading" class="form-control" type="text" placeholder="<?php echo esc_html__('e.g. 46% Off - Two Vouchers Each Valid for One Large Specialty Pizza', 'listingpro'); ?>">
                                    </div>
                                    <div class="">
                                        <label for="dis-description"><?php echo esc_html__('Description', 'listingpro'); ?></label>
                                        <textarea class="form-control" rows="10" name="dis-description" id="dis-description" placeholder="<?php echo esc_html__('e.g. Choice of: Two vouchers: Each Good for One Large Specialty Pizza $20 Value', 'listingpro'); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="upload-field dashboard-upload-field new-file-upload">
                                            <?php echo do_shortcode('[frontend-button]'); ?>											
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row" id="date-switch">
                            <div class="row">
                                <div class="form-group col-sm-6 ">
                                    <div class="">
                                        <label for="dis-expiry-s"><?php echo esc_html__('Start Date', 'listingpro'); ?></label>
                                        <input min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-s" id="dis-expiry-s" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                    </div>

                                </div>
                                <div class="form-group col-sm-6 ">
                                    <div class="">
                                        <label for="dis-expiry-e"><?php echo esc_html__('End Date', 'listingpro'); ?></label>
                                        <input min="<?php echo date( 'Y-m-d' ); ?>" name="dis-expiry-e" id="dis-expiry-e" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                <div class="form-group col-sm-6" id="code-switch">
                                    <div class="">
                                        <label for="dis-code"><?php echo esc_html__('Coupon Code', 'listingpro'); ?></label>
                                        <input name="dis-code" id="dis-code" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. SUMMER50', 'listingpro'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" id="btn-url-switch" style="display: none;">
                                    <div class="">
                                        <label for="dis-btn-link"><?php echo esc_html__('Custom URL (Button)', 'listingpro'); ?></label>
                                        <input name="dis-btn-link" id="dis-btn-link" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://www.example.com', 'listingpro'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 ">
                                    <div class="">
                                        <label for="dis-off"><?php echo esc_html__('Discount Value', 'listingpro'); ?></label>
                                        <input id="dis-off" name="dis-off" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. 50% || $50', 'listingpro'); ?>">
                                    </div>
                                </div>
                                <p class="col-md-12 margin-top-10"><?php echo esc_html__("*Skip this if your deal doesn't include a coupon", 'listingpro'); ?></p>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                <div class="form-group col-sm-6" id="btn-switch">
                                    <div class="">
                                        <label for="dis-btn-text"><?php echo esc_html__('Custom Text (Button)', 'listingpro'); ?></label>
                                        <input name="dis-btn-text" id="dis-btn-text" type="text" class="form-control" placeholder="e.g. CLICK HERE">
                                    </div>
                                </div>
                                <p class="col-md-12 margin-top-10"><?php echo esc_html__('*If left blank the default text "CLICK HERE" will be used. ', 'listingpro'); ?></p>
                                <p class="col-md-12"><?php echo esc_html__('*Only enable Custom URL if you would like to redirect users to an external link. ', 'listingpro'); ?></p>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                
                                <div class="form-group col-sm-12 clearfix">
                                    <button data-cancel="discount" class="lp-coupns-btns cancel-ad-new-btn pull-left"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                    <button id="lp-save-dis" data-uid="<?php echo $user_id; ?>" class="lp-coupns-btns pull-right"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 padding-right-0 lp-right-panel-height">
            <div class="lp-ad-click-outer">
                <div class="lp-general-section-title-outer">
                    <p id="reply-title" class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__( 'Settings', 'listingpro' ); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></p>
                    <div class="lp-ad-click-inner" id="lp-ad-click-inner">
                        <ul class="lp-invoices-all-stats clearfix coupons-fields-switch">
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php echo esc_html__( 'Set Date', 'listingpro' ); ?>
                                    <label class="switch">
                                        <input data-target="date" class="form-control switch-checkbox" type="checkbox" checked>
                                        <div class="slider round"></div>
                                    </label>
                                </h5>
                            </li>
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php echo esc_html__( 'External Coupon', 'listingpro' ); ?>
                                    <label class="switch">
                                        <input data-target="coupon-external" class="form-control switch-checkbox" type="checkbox">
                                        <div class="slider round"></div>
                                    </label>
                                </h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>