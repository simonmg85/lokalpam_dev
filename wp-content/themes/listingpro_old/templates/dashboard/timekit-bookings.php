<?php

global $listingpro_options;	
$timekit_bookings_enable = $listingpro_options['timekit_bookings_enable'];	
if($timekit_bookings_enable != 1){		
	wp_redirect(home_url('/'));	
}

if ( isset( $_POST['timekit_nonce_field'] ) && wp_verify_nonce( $_POST['timekit_nonce_field'], 'timekit_nonce' ) ) {

	$lptimekitwidget 		= $_POST['newtimekitwidget'];
	$timekitListing 	= $_POST['timekitListing'];
	
	if(isset($lptimekitwidget) && !empty($lptimekitwidget) && isset($timekitListing) && !empty($timekitListing) ){
		update_post_meta( $timekitListing, 'timekit_bookings', $lptimekitwidget);
	}

}

if ( isset( $_POST['timekit_del_nonce_field'] ) && wp_verify_nonce( $_POST['timekit_del_nonce_field'], 'timekit_del_nonce' ) ) {
	$timekit_remove_id 		= $_POST['timekit_remove_id'];
	if(isset($timekit_remove_id) && !empty($timekit_remove_id)){
		delete_post_meta($timekit_remove_id, 'timekit_bookings');
	}
}
$user_ID = get_current_user_id();	
$argsActive = array(
	'author'   => $user_ID,
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'post_status'      => 'publish',
	'meta_query' =>
	array(
		array(
			'key'     => 'timekit_bookings',
			'compare' => 'EXIST'
		)
	),
);
$Active_array = get_posts( $argsActive ); 

$args = array(
	'author'   => $user_ID,
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'post_status'      => 'publish'
);
$posts_array = get_posts( $args );

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


?>
<div class="user-recent-listings-inner tab-pane fade in active lp-timekit-outer" id="resurva_bookings">
	
	<div class="row lp-list-page-list">
		<div class="col-md-12 col-sm-6 col-xs-12 lp-list-view">
			<div class="resurva-booking">
				<div class="lp-list-view-inner-contianer clearfix">
					<form method="post" id="booking" action="<?php echo esc_attr($actual_link); ?>">
						<a href="#" class="switch-fields"><?php esc_html_e('Add Timekit Bookings','listingpro'); ?></a>
						<div class="hidden-items clearfix">
							<div class="row margin-bottom-20">
								<div class="col-md-6 col-xs-12">
									<label for="timekitName"><?php esc_html_e('Enter your Timekit widget code here:','listingpro'); ?></label>
									<p><?php esc_html_e('Enter your Timekit booking widget','listingpro'); ?></p>
									<textarea class="form-control" rows="5"  name="newtimekitwidget" id="timekitNamewidget" placeholder="<?php esc_html_e('Timekit Widget Goes Here','listingpro'); ?>"></textarea>
								</div>
								<div class="col-md-6 col-xs-12">
									<label for="timekitListing"><?php esc_html_e('Select your list to assign your Timekit booking','listingpro'); ?></label>
									<p><?php esc_html_e('Select Listing to whome you want to assign the widget','listingpro'); ?></p>
									<?php if(!empty($posts_array)){ ?>
									<select class="select2" name="timekitListing" id="timekitListing">
										<?php										
											foreach ($posts_array as $list) {
											?>
												<option value="<?php echo $list->ID; ?>"><?php echo $list->post_title; ?></option>
											<?php } ?>
									</select>
									<div class="margin-bottom-15"></div>
									<input type="submit" value="Submit" class="lp-review-btn btn-second-hover">
									<?php }else{
										echo esc_html__('You have no published listing.','listingpro');
									} ?>
								</div>
							</div>
							
						</div>
						<?php echo wp_nonce_field( 'timekit_nonce', 'timekit_nonce_field' , true, false ); ?>
					</form>					
				</div>		
			</div>
			<?php if(!empty($Active_array)){ ?>
				<div class="resurva-booking">
					<div class="lp-list-view-inner-contianer clearfix">
					<h3 class="margin-top-0 margin-bottom-30"><?php esc_html_e('Timekit Bookings Currently Active On','listingpro'); ?></h3>
						<ul class="padding-left-0">
							<?php						
							foreach ($Active_array as $list) {
							?>
								<li class="clearfix">
									<h3 class="pull-left margin-right-30"><?php echo $list->post_title; ?></h3>
									<form method="post" id="booking" action="<?php echo esc_attr($actual_link); ?>">
										<input type="hidden" name="timekit_remove_id" value="<?php echo $list->ID; ?>" class="lp-review-btn btn-second-hover">
										<span>
											<i class="fa fa-times"></i>
											<input type="submit" value="<?php esc_html_e('Remove','listingpro'); ?>" class="margin-top-10 pull-right">
										</span>
										<?php echo wp_nonce_field( 'timekit_del_nonce', 'timekit_del_nonce_field' , true, false ); ?>
									</form>	
								</li>
							<?php } ?>						
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>