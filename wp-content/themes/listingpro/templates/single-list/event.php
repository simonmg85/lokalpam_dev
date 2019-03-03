<?php
$event_id   =   get_post_meta( $post->ID, 'event_id', true );

if(  get_post_status( $event_id ) === false ) return false;
if( isset( $event_id ) && !empty( $event_id ) ):
	$timeNow    =   strtotime("-1 day");
	$event_date =   get_post_meta( $event_id, 'event-date', true );
	if( $timeNow > $event_date ) return false;
	$event_time =   get_post_meta( $event_id, 'event-time', true );
	$event_loc =   get_post_meta( $event_id, 'event-loc', true );
	$event_ticket_url =   get_post_meta( $event_id, 'ticket-url', true );
	$event_img =   get_post_meta( $event_id, 'event-img', true );
	$event_utilities =   get_post_meta( $event_id, 'event-utilities', true );

    $event_lat =   get_post_meta( $event_id, 'event-lat', true );
    $event_lon =   get_post_meta( $event_id, 'event-lon', true );

	$event_object = get_post( $event_id );
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$attending_users    =   get_post_meta( $event_id, 'attending-users', true );
	$attendies_count    =   0;
	if( !empty( $attending_users ) && is_array( $attending_users ) )
	{
		$attendies_count    =   count( $attending_users );
	}

	if( empty( $event_img ) )
	{
		if( has_post_thumbnail( $event_id ) )
		{
			$event_img  =   get_the_post_thumbnail_url( $event_id, 'large' );
		}
	}
	
	$lp_default_map_pin = $listingpro_options['lp_map_pin']['url'];

	if(empty($lp_default_map_pin)){

	   $lp_default_map_pin = get_template_directory_uri() . '/assets/images/pins/pin.png';
	
	}
	
	?>
    <div class="sidebar-post event-sidebar-wrapper">
        <div class="widget-box lp-event-outer">
			<?php
			if( !empty( $event_img ) ):
				?>
                <div class="lp-event-image-container">
                    <a href="<?php echo get_permalink( $event_id ); ?>"><img src="<?php echo $event_img; ?>" alt="<?php echo get_the_title( $event_id ); ?>"></a>
                </div>
			<?php endif; ?>
            <div class="lp-event-outer-container">
                <div class="lp-event-outer-content margin-bottom-10">
					<?php
					if( !empty( $event_date ) ):
						?>
                        <div class="lp-evnt-date-container">
                            <div class="lp-evnt-date-container-inner">
                                <span><?php echo date_i18n( 'd', $event_date ); ?></span>
                                <span><?php echo date_i18n( 'M', $event_date ); ?></span>
                            </div>
                        </div>
					<?php endif; ?>
                    <div class="lp-evnt-content-container">
                        <a href="<?php echo get_permalink($event_id); ?>"><?php echo wp_trim_words(get_the_title( $event_id ), 3, '...'); ?></a>
                        <h4><?php echo esc_html__('Hosted by','listingpro');?> <?php echo wp_trim_words(get_the_title( $post->ID ), 2, '...'); ?></h4>
						<?php
						$read_more_des  =   '';
						if(!empty($event_object)){
							$des    =   $event_object->post_content;
							if( strlen( $des ) > 100 )
							{
								$read_more_des  =   '<span data-more="'. esc_html__( 'Show More', 'listingpro' ) .'" data-less="'. esc_html__( 'Show Less', 'listingpro' ) .'" class="show-more-event-content">'. esc_html__( 'Show More', 'listingpro' ) .'</span>';
							}
							?>
                            <p><?php echo $des; ?></p>
							<?php echo $read_more_des; ?>
						<?php } ?>
                    </div>
                </div>
                <div class="lp-events-btns-outer">
		            <?php
		            if( !isset( $event_utilities['guests'] ) || $event_utilities['guests'] == 'yes' )
		            {
			            if( is_user_logged_in() ):
				            if( is_array( $attending_users ) && in_array( $user_id, $attending_users ) ):
					            ?>
                                <button type="button"><?php echo esc_html__( 'already going', 'listingpro' ); ?></button>
				            <?php else: ?>
                                <button type="button" id="attend-event" data-event="<?php echo $event_id; ?>" data-uid="<?php echo $user_id; ?>"><?php echo esc_html__( 'Yes! i am going', 'listingpro' ); ?></button>
				            <?php endif; ?>
			            <?php else: ?>
                            <button type="button" class="md-trigger" data-modal="modal-3"><?php echo esc_html__( 'Yes! i am going', 'listingpro' ); ?></button>
			            <?php endif; ?>
			            <?php
			            if( !isset( $event_utilities['counter'] ) || $event_utilities['counter'] == 'yes' ):
				            ?>
                            <button type="button" class="total-going"><?php echo $attendies_count; ?> <?php echo esc_html__( 'going', 'listingpro' ); ?></button>
			            <?php endif; ?>
			            <?php
		            }
		            ?>
                </div>
                <div class="lp-event-list-area">
					<?php
					$border_bottom_class    =   '';
					if( empty( $event_ticket_url ) )
					{
						$border_bottom_class    =   'border-bottom-zero';
					}
					?>
                    <ul class="clearfix <?php echo $border_bottom_class; ?>">
						<?php
						if( !empty( $event_time ) ):
							?>
                            <li><h5><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $event_time; ?> <?php echo esc_html__( '-', 'listingpro' ); ?> <?php echo date_i18n( 'l', $event_date); ?></h5>
								<?php if(!empty( $event_date)): ?>
                                    <span><?php echo date_i18n( get_option('date_format'), $event_date); ?></span>
								<?php endif; ?>
                            </li>
						<?php endif; ?>

                        <li>
							<?php
							if( !empty( $event_loc ) ):
								?>
                                <h5><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $event_loc;?></h5>
                                <h6 id="lp-map-hide-show" class="md-trigger" data-modal="modal-event-map"><?php echo esc_html__( 'Show Map', 'listingpro' ); ?></h6>
							<?php endif; ?>
                        </li>
                    </ul>
					<?php
					if( !empty( $event_ticket_url ) ): ?>
                        <a target="_blank" href="<?php echo $event_ticket_url; ?>" class="lp-event-ticket"><i class="fa fa-tag" aria-hidden="true"></i><?php echo esc_html__( 'Get Tickets', 'listingpro' ); ?></a>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-3" id="modal-event-map">
        <div class="md-content">
            <div style="width: 100%; height: 400px;" class="eventmap-popup" id="eventmap-popup" data-lan="<?php echo $event_lon; ?>" data-lat="<?php echo $event_lat; ?>" data-pinicon="<?php echo $lp_default_map_pin; ?>"></div>
            <a class="md-close widget-map-click"><i class="fa fa-close"></i></a>
        </div>
    </div>
<?php endif; ?>