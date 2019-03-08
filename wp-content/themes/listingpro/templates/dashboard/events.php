<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

$d_args =   array(
	'post_type' => 'events',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'author' => $user_id,
);
$a_events  =   new WP_Query($d_args);
$events_count   =   $a_events->found_posts;
$time_now   =   strtotime("-1 day");
?>

<?php
ajax_response_markup();
?>
<div class="modal fade" id="dashboard-delete-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-delete-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
				<?php echo esc_html__( 'Are you sure you want to delete?' ); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                <button type="button" class="btn btn-primary dashboard-confirm-del-btn"><?php echo esc_html__( 'Delete', 'listingpro' ); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade in active lp-coupns-form" id="lp-events">
	<?php
	if( $events_count == 0 ):
		?>
        <div class="lp-blank-section">
            <div class="col-md-12 blank-left-side">
                <img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
                <h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
                <p class="margin-bottom-20"><?php echo esc_html__('You must be here for the first time. If you like to add some thing, click the button below.', 'listingpro'); ?></p>
                <button data-form="events" class="lp-add-new-btn add-new-open-form"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php echo esc_html__('Add new event', 'listingpro'); ?></button>
            </div>
        </div>
	<?php
	else:
		?>
        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-12">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab"><?php esc_html_e('all events','listingpro'); ?></a></li>
                    <li><a href="#tab2default" data-toggle="tab"><?php esc_html_e('active','listingpro'); ?></a></li>
                    <li><a href="#tab3default" data-toggle="tab"><?php esc_html_e('inactive','listingpro'); ?></a></li>
                    <button data-form="events" class="lp-add-new-btn add-new-open-form"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('add new event','listingpro'); ?></button>
                </ul>
            </div>
            <div class="panel-body">
                <div class="lp-main-title clearfix">
                    <div class="col-md-3"><p><?php esc_html_e('event','listingpro'); ?></p></div>
                    <div class="col-md-3"><p><?php esc_html_e('Location','listingpro'); ?></p></div>
                    <div class="col-md-2"><p><?php esc_html_e('start date','listingpro'); ?></p></div>
                    <div class="col-md-2"><p><?php esc_html_e('start time','listingpro'); ?></p></div>
                    <div class="col-md-2"><p><?php esc_html_e('status','listingpro'); ?></p></div>
                </div>
                <div class="tab-content clearfix">
                    <div class="tab-pane fade in active" id="tab1default">
						<?php
						if( $a_events->have_posts() ): while ( $a_events->have_posts() ): $a_events->the_post();
							$eID        =   get_the_ID();
							$eImg       =   get_post_meta( $eID, 'event-img', true );
							$eLID       =   get_post_meta( $eID, 'event-lsiting-id', true );
							$eLoc       =   get_post_meta( $eID, 'event-loc', true );
							$tUrl       =   get_post_meta( $eID, 'ticket-url', true );
							$eTime      =   get_post_meta( $eID, 'event-time', true );
							$eDate      =   get_post_meta( $eID, 'event-date', true );
							$eLat      	=   get_post_meta( $eID, 'event-lat', true );
							$eLon      	=   get_post_meta( $eID, 'event-lon', true );
							$eTitle     =   get_the_title( get_the_ID() );
							?>
                            <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
                                    <div class="lp-deal-title">
                                        <p><?php echo substr( get_the_title( get_the_ID() ), 0, 19 ).'...'; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Location','listingpro'); ?>">
                                    <div class="lp-listing-expire-section">
                                        <p><?php echo $eLoc; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Date','listingpro'); ?>">
                                    <div class="lp-listing-expire-section">
										<?php if(!empty($eDate)){ ?>
                                            <p><?php echo date_i18n( get_option('date_format'), $eDate); ?></p>
										<?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Time','listingpro'); ?>">
                                    <div class="lp-listing-expire-section">
                                        <p><?php echo $eTime; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                    <div class="clearfix">
                                        <div class="lp-listing-pay-outer pull-left">
											<?php
											if( $time_now < $eDate ):
												?>
                                                <a class="lp-listing-pay-button"> <?php esc_html_e('active','listingpro'); ?></a>
											<?php else: ?>
                                                <a class="lp-listing-pay-button inactive"> <?php esc_html_e('inactive','listingpro'); ?></a>
											<?php endif; ?>
                                        </div>
                                        <div class="pull-left lp-pull-left-new">
                                            <div class="lp-dot-extra-buttons">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                <ul class="lp-user-menu list-style-none">
                                                    <li><a href="" class="event-edit" data-targetid="<?php echo $eID; ?>" data-disID="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php esc_html_e('Edit','listingpro'); ?></span></a></li>
                                                    <li><a href="#" class="del-this event-del" data-uid="<?php echo $user_id; ?>" data-lid="<?php echo $eLID; ?>" data-eid="<?php echo $eID; ?>" data-targetid="<?php echo $eID; ?>"><i class="fa fa-trash-o"></i><span><?php esc_html_e('Delete','listingpro'); ?></span></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div style="display: none;" id="update-wrap-<?php echo $eID; ?>">
                                    <div class="panel with-nav-tabs panel-default lp-dashboard-tabs lp-left-panel-height margin-top-40">
                                        <div class="lp-coupns-form-outer">
                                            <div class="lp-voupon-box">
                                                <form class="lp-coupons-form-inner" id="lp-events-form-<?php echo $eID; ?>">
                                                    <div class="lp-coupon-box-row">
                                                        <div class="row">
                                                            <div class="form-group col-sm-7 col-md-7">
                                                                <div class="margin-bottom-20">
                                                                    <label for="event-title-<?php echo $eID; ?>"><?php echo esc_html__('Event Name', 'listingpro'); ?></label>
                                                                    <input name="event-title-<?php echo $eID; ?>" id="event-title-<?php echo $eID; ?>" class="form-control" value="<?php echo $eTitle; ?>" type="text" placeholder="<?php echo esc_html__('e.g. Enter your event name that to be created', 'listingpro'); ?>">
                                                                </div>
                                                                <div class="">
                                                                    <label for="event-description-<?php echo $eID; ?>"><?php echo esc_html__('Event Description', 'listingpro'); ?></label>
                                                                    <textarea id="event-description-<?php echo $eID; ?>" name="event-description-<?php echo $eID; ?>" type="text" class="form-control" rows="10" ><?php echo get_the_content(); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="jFiler-input-dragDrop pos-relative">
                                                                    <input type="hidden" id="event-old-img-<?php echo $eID; ?>" value="<?php echo $eImg; ?>">
                                                                    <div class="removeable-image upload-field dashboard-upload-field edit-upload-<?php echo $eID; ?>">
                                                                        <?php
                                                                        if( !empty( $eImg ) )
                                                                        {
                                                                            ?>
                                                                            <span class="remove-event-img remove-eei" data-targetid="<?php echo $eID; ?>">X</span>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <?php echo do_shortcode('[frontend-button]'); ?>
                                                                        <?php
                                                                        if( !empty( $eImg ) ):
                                                                            ?>

                                                                            <img class="lp-uploaded-img event-old-img-<?php echo $eID; ?>" src="<?php echo $eImg; ?>" alt="">
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
                                                                    <label for="event-date-s-<?php echo $eID; ?>"><?php echo esc_html__('Event Date', 'listingpro'); ?></label>
                                                                    <input value="<?php if(!empty($eDate)){ echo date( 'M d, Y', $eDate );} ?>" name="event-date-s-<?php echo $eID; ?>" id="event-date-s-<?php echo $eID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-sm-6 ">
                                                                <div class="">
                                                                    <label for="event-time-<?php echo $eID; ?>"><?php echo esc_html__('Event Time', 'listingpro'); ?></label>
                                                                    <input value="<?php echo $eTime; ?>" name="event-time-<?php echo $eID; ?>" id="event-time-<?php echo $eID; ?>" type="text" class="form-control datetimepicker1" placeholder="<?php echo esc_html__('1:00 am', 'listingpro'); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="lp-coupon-box-row">
                                                        <div class="row">
                                                            <div class="form-group col-sm-12 ">
                                                                <div class="">
                                                                    <label for="event-location-<?php echo $eID; ?>"><?php echo esc_html__('Address ', 'listingpro'); ?></label>
                                                                    <input value="<?php echo $eLoc; ?>" type="text" class="form-control event-addr" name="event-location-<?php echo $eID; ?>" id="event-location-<?php echo $eID; ?>" placeholder="<?php echo esc_html__('e.g. Country, City, Location', 'listingpro'); ?>">
                                                                    <input type="hidden" class="latitude" name="latitude" value="<?php echo $eLat; ?>">

                                                                   <input type="hidden" class="longitude" name="longitude" value="<?php echo $eLon; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="lp-coupon-box-row">
                                                        <div class="row">
                                                            <div class="form-group col-sm-12 ">
                                                                <div class="">
                                                                    <label for="event-ticket-url-<?php echo $eID; ?>"><?php echo esc_html__('Ticket URL', 'listingpro'); ?></label>
                                                                    <input value="<?php echo $tUrl; ?>" id="event-ticket-url-<?php echo $eID; ?>" name="event-ticket-url-<?php echo $eID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://yoursite.com', 'listingpro'); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="lp-coupon-box-row">
                                                        <div class="row">
                                                            <div class="form-group col-sm-6 ">
                                                                <div class="">
                                                                    <label for="event-listing-<?php echo $eID; ?>"><?php echo esc_html__('Assign Listing', 'listingpro'); ?></label>
                                                                    <input value="<?php echo get_the_title( $eLID ); ?>" type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-sm-6 text-right margin-top-20">
                                                                <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                                <button class="lp-save-events lp-coupns-btns" data-eid="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php
						endwhile; wp_reset_postdata(); endif;
						?>
                    </div>
                    <div class="tab-pane fade" id="tab2default">
						<?php

						if( $a_events->have_posts() ): while ( $a_events->have_posts() ): $a_events->the_post();
							$eID        =   get_the_ID();

							$eDate      =   get_post_meta( $eID, 'event-date', true );

							if( $eDate > $time_now ):

								$eLID       =   get_post_meta( $eID, 'event-lsiting-id', true );
								$eLoc       =   get_post_meta( $eID, 'event-loc', true );
								$tUrl       =   get_post_meta( $eID, 'ticket-url', true );
								$eTime      =   get_post_meta( $eID, 'event-time', true );

								$eTitle     =   get_the_title( get_the_ID() );
								?>
                                <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                    <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
                                        <div class="lp-deal-title">
                                            <p><?php echo substr( get_the_title( get_the_ID() ), 0, 19 ).'...'; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Location','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p><?php echo $eLoc; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Date','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
											<?php if(!empty($eDate)){ ?>
                                                <p><?php echo date( 'M d, Y', $eDate ); ?></p>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Time','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p><?php echo $eTime; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <div class="lp-dot-extra-buttons">
                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                    <ul class="lp-user-menu list-style-none">
                                                        <li><a href="" class="event-edit" data-targetid="<?php echo $eID; ?>" data-disID="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php esc_html_e('Edit','listingpro'); ?></span></a></li>
                                                        <li><a href="#" class="del-this event-del" data-uid="<?php echo $user_id; ?>" data-lid="<?php echo $eLID; ?>" data-eid="<?php echo $eID; ?>" data-targetid="<?php echo $eID; ?>"><i class="fa fa-trash-o"></i><span><?php esc_html_e('Delete','listingpro'); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="lp-listing-pay-outer pull-right">
                                                <a class="lp-listing-pay-button"> <?php esc_html_e('active','listingpro'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="display: none;" id="update-wrap-<?php echo $eID; ?>">
                                        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs lp-left-panel-height margin-top-40">
                                            <div class="lp-coupns-form-outer">
                                                <div class="lp-voupon-box">
                                                    <form class="lp-coupons-form-inner" id="lp-events-form-<?php echo $eID; ?>">
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="margin-bottom-20">
                                                                        <label for="event-title-<?php echo $eID; ?>"><?php echo esc_html__('Event Name', 'listingpro'); ?></label>
                                                                        <input name="event-title-<?php echo $eID; ?>" id="event-title-<?php echo $eID; ?>" class="form-control" value="<?php echo $eTitle; ?>" type="text" placeholder="<?php echo esc_html__('e.g. Enter your event name that to be created', 'listingpro'); ?>">
                                                                    </div>
                                                                    <div class="">
                                                                        <label for="event-description-<?php echo $eID; ?>"><?php echo esc_html__('Event Description', 'listingpro'); ?></label>
                                                                        <textarea id="event-description-<?php echo $eID; ?>" name="event-description-<?php echo $eID; ?>" type="text" class="form-control" rows="10" ><?php echo get_the_content(); ?></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-date-s-<?php echo $eID; ?>"><?php echo esc_html__('Event Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $eDate ); ?>" name="event-date-s-<?php echo $eID; ?>" id="event-date-s-<?php echo $eID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-time-<?php echo $eID; ?>"><?php echo esc_html__('Event Time', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $eTime; ?>" name="event-time-<?php echo $eID; ?>" id="event-time-<?php echo $eID; ?>" type="time" class="form-control" placeholder="<?php echo esc_html__('1:00 am', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="">
                                                                        <label for="event-location-<?php echo $eID; ?>"><?php echo esc_html__('Address ', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $eLoc; ?>" type="text" class="form-control" name="event-location-<?php echo $eID; ?>" id="event-location-<?php echo $eID; ?>" placeholder="<?php echo esc_html__('e.g. Country, City, Location', 'listingpro'); ?>">
                                                                        <input type="hidden" class="latitude" name="latitude">
                                                                        <input type="hidden" class="longitude" name="longitude">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="">
                                                                        <label for="event-ticket-url-<?php echo $eID; ?>"><?php echo esc_html__('Ticket URL', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $tUrl; ?>" id="event-ticket-url-<?php echo $eID; ?>" name="event-ticket-url-<?php echo $eID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. CLICK HERE', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-listing-<?php echo $eID; ?>"><?php echo esc_html__('Assign Listing', 'listingpro'); ?></label>
                                                                        <input value="<?php echo get_the_title( $eLID ); ?>" type="text" class="form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 text-right margin-top-20">
                                                                    <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                                    <button class="lp-save-events lp-coupns-btns" data-eid="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php
							endif;
						endwhile; wp_reset_postdata(); endif;
						?>
                    </div>
                    <div class="tab-pane fade" id="tab3default">
						<?php
						if( $a_events->have_posts() ): while ( $a_events->have_posts() ): $a_events->the_post();

							$eID        =   get_the_ID();
							$eDate      =   get_post_meta( $eID, 'event-date', true );

							if( $time_now > $eDate ):
								$eLID       =   get_post_meta( $eID, 'event-lsiting-id', true );
								$eLoc       =   get_post_meta( $eID, 'event-loc', true );
								$tUrl       =   get_post_meta( $eID, 'ticket-url', true );
								$eTime      =   get_post_meta( $eID, 'event-time', true );

								$eTitle     =   get_the_title( get_the_ID() );
								?>
                                <div class="lp-listing-outer-container clearfix lp-coupon-outer-container">
                                    <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Title','listingpro'); ?>">
                                        <div class="lp-deal-title">
                                            <p><?php echo substr( get_the_title( get_the_ID() ), 0, 19 ).'...'; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Location','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p><?php echo $eLoc; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Date','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p><?php echo date( 'M d, Y', $eDate ); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Event Time','listingpro'); ?>">
                                        <div class="lp-listing-expire-section">
                                            <p><?php echo $eTime; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <div class="lp-dot-extra-buttons">
                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                    <ul class="lp-user-menu list-style-none">
                                                        <li><a href="" class="event-edit" data-targetid="<?php echo $eID; ?>" data-disID="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>"><i class="fa fa-pencil-square-o"></i><span><?php esc_html_e('Edit','listingpro'); ?></span></a></li>
                                                        <li><a href="#" class="del-this event-del" data-uid="<?php echo $user_id; ?>" data-lid="<?php echo $eLID; ?>" data-eid="<?php echo $eID; ?>" data-targetid="<?php echo $eID; ?>"><i class="fa fa-trash-o"></i><span><?php esc_html_e('Delete','listingpro'); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="lp-listing-pay-outer pull-right">
                                                <a class="lp-listing-pay-button inactive"> <?php esc_html_e('Inactive','listingpro'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="display: none;" id="update-wrap-<?php echo $eID; ?>">
                                        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs lp-left-panel-height margin-top-40">
                                            <div class="lp-coupns-form-outer">
                                                <div class="lp-voupon-box">
                                                    <form class="lp-coupons-form-inner" id="lp-events-form-<?php echo $eID; ?>">
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="margin-bottom-20">
                                                                        <label for="event-title-<?php echo $eID; ?>"><?php echo esc_html__('Event Name', 'listingpro'); ?></label>
                                                                        <input name="event-title-<?php echo $eID; ?>" id="event-title-<?php echo $eID; ?>" class="form-control" value="<?php echo $eTitle; ?>" type="text" placeholder="<?php echo esc_html__('e.g. Enter your event name that to be created', 'listingpro'); ?>">
                                                                    </div>
                                                                    <div class="">
                                                                        <label for="event-description-<?php echo $eID; ?>"><?php echo esc_html__('Event Description', 'listingpro'); ?></label>
                                                                        <textarea id="event-description-<?php echo $eID; ?>" name="event-description-<?php echo $eID; ?>" type="text" class="form-control" rows="10" ><?php echo get_the_content(); ?></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-date-s-<?php echo $eID; ?>"><?php echo esc_html__('Event Date', 'listingpro'); ?></label>
                                                                        <input value="<?php echo date( 'M d, Y', $eDate ); ?>" name="event-date-s-<?php echo $eID; ?>" id="event-date-s-<?php echo $eID; ?>" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-time-<?php echo $eID; ?>"><?php echo esc_html__('Event Time', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $eTime; ?>" name="event-time-<?php echo $eID; ?>" id="event-time-<?php echo $eID; ?>" type="time" class="form-control" placeholder="<?php echo esc_html__('1:00 am', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="">
                                                                        <label for="event-location-<?php echo $eID; ?>"><?php echo esc_html__('Address ', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $eLoc; ?>" type="text" class="form-control" name="event-location-<?php echo $eID; ?>" id="event-location-<?php echo $eID; ?>" placeholder="<?php echo esc_html__('e.g. Country, City, Location', 'listingpro'); ?>">
                                                                        <input type="hidden" class="latitude" name="latitude">
                                                                        <input type="hidden" class="longitude" name="longitude">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-12 ">
                                                                    <div class="">
                                                                        <label for="event-ticket-url-<?php echo $eID; ?>"><?php echo esc_html__('Ticket URL', 'listingpro'); ?></label>
                                                                        <input value="<?php echo $tUrl; ?>" id="event-ticket-url-<?php echo $eID; ?>" name="event-ticket-url-<?php echo $eID; ?>" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://yoursite.com', 'listingpro'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lp-coupon-box-row">
                                                            <div class="row">
                                                                <div class="form-group col-sm-6 ">
                                                                    <div class="">
                                                                        <label for="event-listing-<?php echo $eID; ?>"><?php echo esc_html__('Assign Listing', 'listingpro'); ?></label>
                                                                        <input value="<?php echo get_the_title( $eLID ); ?>" type="text" class="form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 text-right margin-top-20">
                                                                    <button class="lp-coupns-btns cancel-update"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                                                    <button class="lp-save-events lp-coupns-btns" data-eid="<?php echo $eID; ?>" data-uid="<?php echo $user_id; ?>" class="lp-coupns-btns"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php
							endif;
						endwhile; wp_reset_postdata(); endif;
						?>

                    </div>

                </div>
            </div>
        </div>
	<?php endif; ?>
    <div id="events-form-toggle" style="display: none">
        <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-9 lp-left-panel-height padding-top-0">
            <div class="lp-review-sorting clearfix padding-left-0 padding-top-0">
                <h5 class="margin-top-0"><?php echo esc_html__('Create New event', 'listingpro'); ?></h5>
            </div>
            <div class="lp-listing-selecter clearfix background-white margin-bottom-general-form">
                <div class="form-group col-sm-6 ">
                    <div class="lp-listing-selecter-content">
                        <h5 class="padding-top-10"><?php esc_html_e('Hosted By (assign listing)','listingpro'); ?></h5>
                    </div>
                </div>
                <div class="form-group col-sm-6 ">
                    <div class="lp-listing-selecter-drop">                        
					   <div class="lp-pp-noa-tip">
					       <i class="fa fa-exclamation" aria-hidden="true"></i> <?php echo esc_html__('Event not allowed with this listing. Please upgrade your plan.', 'listingpro'); ?>
					   </div>
                        <select id="event-listing" name="event-listing" class="form-control select2-ajax-unique" data-metakey="event_id" data-planmetakey="events">
                            <option value="0"><?php echo esc_html__('Select Listing', 'listingpro'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="lp-coupns-form-outer">
                <div class="lp-voupon-box">
                    <form class="lp-coupons-form-inner" id="lp-events-form">
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                <div class="form-group col-sm-7 ">
                                    <div class="margin-bottom-20">
                                        <label for="event-title"><?php echo esc_html__('Event Name', 'listingpro'); ?></label>
                                        <input name="event-title" id="event-title" class="form-control" value="" type="text" placeholder="<?php echo esc_html__('e.g. Enter your event name that to be created', 'listingpro'); ?>">
                                    </div>
                                    <div class="">
                                        <label for="event-description"><?php echo esc_html__('Event Description', 'listingpro'); ?></label>
                                        <textarea placeholder="<?php echo esc_html__('e.g Enter description about your event
		', 'listingpro'); ?>" id="event-description" name="event-description" type="text" class="form-control" rows="10" ></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="removeable-image upload-field dashboard-upload-field new-file-upload">
                                            <?php echo do_shortcode('[frontend-button]'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row empty-row-check">
                            <div class="row">
                                <div class="form-group col-sm-6 ">
                                    <div class="" id="date-switch">
                                        <label for="event-date-s"><?php echo esc_html__('Event Date', 'listingpro'); ?></label>
                                        <input name="event-date-s" id="event-date-s" type="text" class="form-control discount-date" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 ">
                                    <div class="" id="time-switch">
                                        <label for="event-time"><?php echo esc_html__('Event Time', 'listingpro'); ?></label>
                                        <input name="event-time" id="event-time" type="text" class="form-control datetimepicker1" placeholder="<?php echo esc_html__('1:00 am', 'listingpro'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row">
                            <div class="row">
                                <div class="form-group col-sm-12 ">
                                    <div class="">
                                        <label for="event-location"><?php echo esc_html__('Address ', 'listingpro'); ?></label>
                                        <input type="text" class="form-control event-addr" name="event-location" id="event-location" placeholder="<?php echo esc_html__('e.g. Country, City, Location', 'listingpro'); ?>">
                                        <input type="hidden" class="latitude" name="latitude">
                                        <input type="hidden" class="longitude" name="longitude">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row" id="ticket-url-switch">
                            <div class="row">
                                <div class="form-group col-sm-12 ">
                                    <div class="">
                                        <label for="event-ticket-url"><?php echo esc_html__('Ticket URL', 'listingpro'); ?></label>
                                        <input id="event-ticket-url" name="event-ticket-url" type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. http://yoursite.com', 'listingpro'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-coupon-box-row">
                            <div class="row">

                                <div class="form-group col-sm-12 clarfix">
                                    <button data-cancel="events" class="lp-coupns-btns cancel-ad-new-btn pull-left"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                                    <button id="lp-save-events" data-uid="<?php echo $user_id; ?>" class="lp-coupns-btns pull-right"><?php echo esc_html__( 'save', 'listingpro' ); ?></button>
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
                                <h5 class="clearfix"><?php esc_html_e('Set start date','listingpro'); ?>
                                    <label class="switch">
                                        <input data-target="date" class="form-control switch-checkbox" type="checkbox" checked>
                                        <div class="slider round"></div>
                                    </label>

                                </h5>
                            </li>
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php esc_html_e('Set start Time','listingpro'); ?>
                                    <label class="switch">
                                        <input data-target="time" class="form-control switch-checkbox" type="checkbox" checked>
                                        <div class="slider round"></div>
                                    </label>

                                </h5>
                            </li>
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php esc_html_e('Ticket URL','listingpro'); ?>
                                    <label class="switch">
                                        <input data-target="ticket-url" class="form-control switch-checkbox" type="checkbox" checked>
                                        <div class="slider round"></div>
                                    </label>

                                </h5>
                            </li>
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php esc_html_e('Guests','listingpro'); ?>
                                    <label class="switch">
                                        <input data-target="guests" class="form-control switch-checkbox" type="checkbox" checked>
                                        <div class="slider round"></div>
                                    </label>

                                </h5>
                            </li>
                            <li class="lp-invoices-all-stats-on-off">
                                <h5 class="clearfix"><?php esc_html_e('Counter','listingpro'); ?>
                                    <label class="switch">
                                        <input data-target="counter" class="form-control switch-checkbox" type="checkbox" checked>
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