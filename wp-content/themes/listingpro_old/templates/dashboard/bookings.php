<?php	global $listingpro_options;	$resurva_bookings_enable = $listingpro_options['resurva_bookings_enable'];	if($resurva_bookings_enable != 1){		wp_redirect(site_url());	}

if ( isset( $_POST['booking_nonce_field'] ) && wp_verify_nonce( $_POST['booking_nonce_field'], 'booking_nonce' ) ) {

	$reservaUrl 		= $_POST['reservaUrl'];
	$reservaListing 	= $_POST['reservaListing'];
	if(isset($reservaUrl) && !empty($reservaUrl) && isset($reservaListing) && !empty($reservaListing)){
		update_post_meta( $reservaListing, 'resurva_url', $reservaUrl);
	}
}
if ( isset( $_POST['booking_del_nonce_field'] ) && wp_verify_nonce( $_POST['booking_del_nonce_field'], 'booking_del_nonce' ) ) {
	$reserva_remove_id 		= $_POST['reserva_remove_id'];
	if(isset($reserva_remove_id) && !empty($reserva_remove_id)){
		delete_post_meta($reserva_remove_id, 'resurva_url');
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
			'key'     => 'resurva_url',
			'compare' => 'EXIST'
		)
	),
);
$Active_array = get_posts( $argsActive ); 

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


?>
<div class="user-recent-listings-inner tab-pane fade in active" id="resurva_bookings">
	
	<div class="row lp-list-page-list">
		<div class="col-md-12 col-sm-6 col-xs-12 lp-list-view">
			<div class="resurva-booking">
				<div class="lp-list-view-inner-contianer clearfix">
					<form method="post" id="booking" action="<?php echo esc_attr($actual_link); ?>">
						<a href="#" class="switch-fields"><?php esc_html_e('Add Resurva Bookings','listingpro'); ?></a>
						<div class="hidden-items clearfix">
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<label for="reservaUrl"><?php esc_html_e('Enter your resurva url','listingpro'); ?></label>
									<input type="url" name="reservaUrl" id="reservaUrl" placeholder="<?php esc_html_e('Enter your resurva url...','listingpro'); ?>" required>
								</div>
								<div class="col-md-6 col-xs-12">
									<label for="reservaListing"><?php esc_html_e('Select your list to assign your resurva booking','listingpro'); ?></label>
									<select class="select2" name="reservaListing" id="reservaListing">
										<option value="0"><?php echo esc_html__('Select Listing', 'listingpro'); ?></option>
									</select>
									
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-md-6 col-xs-12">
									<input type="submit" value="<?php esc_html_e('Submit','listingpro'); ?>" class="lp-review-btn btn-second-hover">
								</div>
								<div class="col-md-6 col-xs-12">
								</div>
							</div>
						</div>
						<?php echo wp_nonce_field( 'booking_nonce', 'booking_nonce_field' , true, false ); ?>
					</form>					
				</div>		
			</div>
			<?php if(!empty($Active_array)){ ?>
				<div class="resurva-booking">
					<div class="lp-list-view-inner-contianer clearfix">
					<h3 class="margin-top-0 margin-bottom-30"><?php esc_html_e('Resurva Bookings Currently Active On','listingpro'); ?></h3>
						<ul class="padding-left-0">
							<?php						
							foreach ($Active_array as $list) {
							?>
								<li class="clearfix">
									<h3 class="pull-left margin-right-30"><?php echo $list->post_title; ?></h3>
									<form method="post" id="booking" action="<?php echo esc_url($actual_link); ?>">
										<input type="hidden" name="reserva_remove_id" value="<?php echo $list->ID; ?>" class="lp-review-btn btn-second-hover">
										<span>
											<i class="fa fa-times"></i>
											<input type="submit" value="<?php esc_html_e('Remove','listingpro'); ?>" class="margin-top-10 pull-right">
										</span>
										<?php echo wp_nonce_field( 'booking_del_nonce', 'booking_del_nonce_field' , true, false ); ?>
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