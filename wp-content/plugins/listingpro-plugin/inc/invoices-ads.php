<?php 

require_once(ABSPATH . 'wp-admin/includes/screen.php');
/* =========================form action for wire process============================= */

if( !empty($_POST['payment_submit']) && isset($_POST['payment_submit']) ){
	if (!isset($_SESSION)) { session_start(); }
	global $wpdb,$listingpro_options;
	$ads_durations = $listingpro_options['listings_ads_durations'];
	
	$currentdate = date("d-m-Y");
	$exprityDate = date('Y-m-d', strtotime($currentdate. ' + '.$ads_durations.' days'));
	$exprityDate = date('d-m-Y', strtotime( $exprityDate ));
	
	$table = 'listing_campaigns';
	$order_id = '';
	$order_id = $_POST['order_id'];
	$mode = $_POST['mode'];
	$duration = $_POST['duration'];
	$budget = $_POST['budget'];
	
	$postid= $_POST['post_id'];
	$price_packages = listing_get_metabox_by_ID('listings_ads_purchase_packages', $postid);
	
	
	$my_post = array( 'post_title'    => $postid, 'post_status'   => 'publish', 'post_type' => 'lp-ads' );
	$adID = wp_insert_post( $my_post );
	
	$data = array('post_id' => $postid,'status' => 'success');
	$where = array('transaction_id' => $order_id);
	lp_update_data_in_db($table, $data, $where);
	listing_set_metabox('ads_listing', $postid, $adID);
	listing_set_metabox('ad_status', 'Active', $adID);
	listing_set_metabox('ad_date', $currentdate, $adID);
	listing_set_metabox('ad_expiryDate', $exprityDate, $adID);
	listing_set_metabox('campaign_id',$postid, $adID);
	if($mode=="byduration"){}else{
		//cpc
		listing_set_metabox('remaining_balance', $budget, $adID);
	}
	listing_set_metabox('ads_mode', $mode, $adID);
	listing_set_metabox('duration', $duration, $adID);
	listing_set_metabox('budget', $budget, $adID);
	
	$packagesDetails = '';
	$priceKeyArray;
	if( !empty($price_packages) ){
		foreach( $price_packages as $type ){
			if($type=="lp_random_ads"){
								$packagesDetails .= esc_html__(' Random Ads ', 'listingpro-plugin');
							}
							if($type=="lp_detail_page_ads"){
								$packagesDetails .= esc_html__(' Detail Page Ads ', 'listingpro-plugin');
							}
							if($type=="lp_top_in_search_page_ads"){
								$packagesDetails .= esc_html__(' Top in Search Page Ads ', 'listingpro-plugin');
							}
			$priceKeyArray[] = $type;
			update_post_meta( $postid, $type, 'active' );
		}
	}
	update_post_meta( $postid, 'campaign_status', 'active' );
	update_post_meta( $postid, 'campaign_id', $adID );
	
	if( !empty($priceKeyArray) ){
		listing_set_metabox('ad_type', $priceKeyArray, $adID);
	}
	
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		$admin_email = get_option('admin_email');
		$listing_title = get_the_title($postid);
		$listing_url = get_the_permalink($postid);
		$campaign_packages = $packagesDetails;
		
		$author_id = get_post_field( 'post_author', $postid );
		$user_email = get_the_author_meta( 'user_email', $author_id );
		$author_name = get_the_author_meta( 'user_login', $author_id );
		$user_name = $author_name;
		$website_url = site_url();
		$website_name = get_option('blogname');
        /* for admin */
		$subject = $listingpro_options['listingpro_subject_campaign_activate'];
		$mail_content = $listingpro_options['listingpro_content_campaign_activate'];
		
		
		$formated_mail_content = lp_sprintf2("$mail_content", array(
			'campaign_packages' => "$campaign_packages",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'author_name' => "$author_name",
			'website_url' => "$website_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
		
		
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		wp_mail( $admin_email, $subject, $formated_mail_content, $headers);
		
		 /* for author */
		 
		$subject = $listingpro_options['listingpro_subject_campaign_activate_author'];
		$mail_content = $listingpro_options['listingpro_content_campaign_activate_author'];
		
		$formated_mail_content = lp_sprintf2("$mail_content", array(
			'campaign_packages' => "$campaign_packages",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_url' => "$website_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
		
		
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		wp_mail( $user_email, $subject, $formated_mail_content, $headers);
	
	
}

/* --------------------delete invoice data------------------- */
if( isset($_POST['delete_invoice']) && !empty($_POST['delete_invoice']) ){
	
	$main_id = $_POST['main_id'];
	if( !empty($main_id) ){
		$table = 'listing_campaigns';
		$where = array('main_id'=>$main_id);
		lp_delete_data_in_db($table, $where);
		
	}
	
}

/* =========================inovices for ads========================================= */
add_action('admin_menu', 'lp_register_ads_invoice_page');
 
function lp_register_ads_invoice_page() {
    add_submenu_page(
        'lp-listings-invoices',
        'Ads Invoices',
        'Ads Invoices',
        'manage_options',
        'ads-invoices-page',
        'ads_invoices_submenu_page_callback' );
}
 
function ads_invoices_submenu_page_callback() {
	wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.min.css');
	wp_enqueue_script('bootstrapadmin', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
?>

<?php
	global $wpdb;
	$dbprefix = $wpdb->prefix;
	$table = 'listing_campaigns';
	$table_name =$dbprefix.$table;
?>
	<div class="wrap">
		<h2><?php esc_html_e('Ads Invoices', 'listingpro-plugin');  ?></h2>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#paypal"><?php echo esc_html__('Paypal', 'listingpro-plugin'); ?></a></li>
			<li><a data-toggle="tab" href="#stripe"><?php echo esc_html__('Stripe', 'listingpro-plugin'); ?></a></li>
			<li><a data-toggle="tab" href="#wire"><?php echo esc_html__('Wire', 'listingpro-plugin'); ?></a></li>
		</ul>
		<div class="tab-content">
			<!--paypal-->
			<div id="paypal" class="tab-pane fade in active">
			
				<ul class="nav nav-tabs">
				
					<li class="active">
						<a data-toggle="tab" href="#p-success"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#p-pending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#p-failed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
					</li>
					
				</ul>
				
				<div class="tab-content">
					
					<div id="p-success" class="tab-pane fade in active">
						
						<?php
							
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="paypal" AND status="success"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$paypal_success = lp_get_data_from_db($table, $data, $condition);
							}
							
							if(!empty($paypal_success) && count($paypal_success)>0){ ?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $paypal_success as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listId = $data->post_id;
												$listTitle = get_the_title($listId); 
												$main_id = $data->main_id; 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
												<td>
													<form class="wp-core-ui" method="post">
														<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
														<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
													</form>
												</td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
							}
							else{
								echo esc_html__('Sorry! You have no successful invoice', 'listingpro-plugin');
							}
						?>
					
					</div>
					
					<div id="p-pending" class="tab-pane fade in">
						
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="paypal" AND status="pending"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$paypal_pending = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($paypal_pending) && count($paypal_pending)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $paypal_pending as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no pending invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
					<div id="p-failed" class="tab-pane fade in">
						
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="paypal" AND status="failed"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$paypal_failed = lp_get_data_from_db($table, $data, $condition);
							}
							
							if(!empty($paypal_failed) && count($paypal_failed)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $paypal_failed as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no failed invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
				</div>
			
			</div>
			
			<!--stripe-->
			<div id="stripe" class="tab-pane fade in">
			
				<ul class="nav nav-tabs">
				
					<li class="active">
						<a data-toggle="tab" href="#s-success"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#s-pending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#s-failed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
					</li>
					
				</ul>
				
				<div class="tab-content">
				
					<div id="s-success" class="tab-pane fade in active">
					
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="stripe" AND status="success"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$stripe_success = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($stripe_success) && count($stripe_success)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $stripe_success as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
												$main_id = $data->main_id;
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
												<td>
													<form class="wp-core-ui" method="post">
														<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
														<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
													</form>
												</td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no successful invoice', 'listingpro-plugin');
							}
						?>
					
					</div>
					
					<div id="s-pending" class="tab-pane fade in">
					
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="stripe" AND status="pending"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$stripe_pending = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($stripe_pending) && count($stripe_pending)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $stripe_pending as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no pending invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
					<div id="s-failed" class="tab-pane fade in">
						
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="stripe" AND status="failed"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$stripe_failed = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($stripe_failed) && count($stripe_failed)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $stripe_failed as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no failed invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
				</div>
			
			</div>
			
			<!--wire-->
			<div id="wire" class="tab-pane fade in">
			
				<ul class="nav nav-tabs">
				
					<li class="active">
						<a data-toggle="tab" href="#w-success"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#w-pending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
					</li>
					
					<li>
						<a data-toggle="tab" href="#w-failed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
					</li>
					
				</ul>
				
				<div class="tab-content">
				
					<div id="w-success" class="tab-pane fade in active">
						
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="wire" AND status="success"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$wire_success = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($wire_success) && count($wire_success)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $wire_success as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id);
												$main_id = $data->main_id;												
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
												<td>
													<form class="wp-core-ui" method="post">
														<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
														<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
													</form>
												</td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no successful invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
					<div id="w-pending" class="tab-pane fade in">
						
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="wire" AND status="pending"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$wire_pending = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($wire_pending) && count($wire_pending)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $wire_pending as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->status; ?></td>
												<td>
													<form class="wp-core-ui" id="confirm_payment" name="confirm_payment" method="post">
														<input type="submit" name="payment_submit" class="button action" value="Confirm" onclick="return window.confirm('Are you sure you want to proceed action?');" />
														<input type="hidden" name="order_id" value="<?php echo $data->transaction_id ?>" />
														<input type="hidden" name="post_id" value="<?php echo $data->post_id; ?>" />
														<?php
															if(isset($data->mode)){
																?>
																<input type="hidden" name="mode" value="<?php echo $data->mode; ?>" />
																<?php
															}
															?>
														<?php
															if(isset($data->duration)){
																?>
																<input type="hidden" name="duration" value="<?php echo $data->duration; ?>" />
																<?php
															}
															?>
														<?php
															if(isset($data->budget)){
																?>
																<input type="hidden" name="budget" value="<?php echo $data->budget; ?>" />
																<?php
															}
														?>
													
													</form>
												</td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no pending invoice', 'listingpro-plugin');
							}
						?>
						
					</div>
					
					<div id="w-failed" class="tab-pane fade in">
					
						<?php 
							$table = 'listing_campaigns';
							$data = '*';
							$condition = 'payment_method="wire" AND status="failed"';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$wire_failed = lp_get_data_from_db($table, $data, $condition);
							}
							
							
							if(!empty($wire_failed) && count($wire_failed)>0){?>
							
								<?php $n=1; ?>
								<table class="wp-list-table widefat fixed striped posts">
									<thead>
										<tr>
											<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Post', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
											<th><?php echo esc_html__('Transaction ID', 'listingpro-plugin'); ?></th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $wire_failed as $data ){ 
												$author_obj = get_userdata($data->user_id);
												$user_login = $author_obj->user_login;
												$listTitle = get_the_title($data->post_id); 
										?>
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $listTitle; ?></td>
												<td><?php echo $data->price.$data->currency; ?></td>
												<td><?php echo $data->transaction_id; ?></td>
											</tr>
										<?php $n++; ?>
										<?php } ?>
										
									</tbody>
								</table>	
							
							<?php
								
							}
							else{
								echo esc_html__('Sorry! You have no failed invoice', 'listingpro-plugin');
							}
						?>
					
					</div>
					
				</div>
			
			</div>
			
		</div>
	</div>
			
			
<?php
}
?>