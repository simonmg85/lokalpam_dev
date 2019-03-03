<?php
add_action('admin_enqueue_scripts', 'listingpro_coupons_script');
function listingpro_coupons_script() {
	if(isset($_GET['page'])){
		if($_GET['page']=="lp-coupons" || $_GET['page']=="lp-bulkemail"){
			wp_enqueue_style('bootstrapsss', THEME_DIR . '/assets/lib/bootstrap/css/bootstrap.min.css');
		}
	}
}

/* get coupons record*/
if(!function_exists('lp_get_existing_coupons')){
	function lp_get_existing_coupons(){
		$option_name = 'lp_coupons';
		if ( get_option( $option_name ) !== false ) {
			$existingCoupons = get_option( $option_name );
			return $existingCoupons;
		}
	}
}


/* update coupons record */
if(!function_exists('lp_update_coupons')){
	function lp_update_coupons($code, $discount, $starts, $ends, $coponlimit){
		$option_name = 'lp_coupons';
		$newCoupon['code'] = $code;
		$newCoupon['discount'] = $discount;
		$newCoupon['starts'] = $starts;
		$newCoupon['ends'] = $ends;
		$newCoupon['coponlimit'] = $coponlimit;
		$newCoupon['used'] = 0;
		$newCoupon['status'] = '';
		if ( get_option( $option_name ) !== false ) {
			$existingCoupons = get_option( $option_name );
			$existingCoupons[] = $newCoupon;
			update_option( $option_name, $existingCoupons );
		}else{
			update_option( $option_name, array($newCoupon));
		}
	}
}



/* submitting coupon */
if( isset($_POST['lp_submit_new_coupon']) && !empty($_POST['lp_submit_new_coupon']) ){
	$couponcode = $_POST['couponcode'];
	$couponpercentage = $_POST['couponpercentage'];
	$couponstarts = $_POST['couponstarts'];
	$couponends = $_POST['couponends'];
	$coponlimit = $_POST['coponlimit'];
	lp_update_coupons($couponcode, $couponpercentage, $couponstarts, $couponends, $coponlimit);
}


/* deleting coupon */
if( isset($_POST['lp_delte_coupon_submit']) && !empty($_POST['lp_delte_coupon_submit']) ){
	$option_name = 'lp_coupons';
	$couponIndex = $_POST['couponinxed'];
	$currentCoupons = lp_get_existing_coupons();
	if(!empty($currentCoupons)){
		if(empty($couponIndex)){
			unset($currentCoupons[0]);
		}else{
			unset($currentCoupons[$couponIndex]);
		}
	}
	$currentCoupons = array_values($currentCoupons);
	update_option( $option_name, $currentCoupons );
}

/* search data in array */
if(!function_exists('lp_search_coupon_in_array')){
	function lp_search_coupon_in_array($value, $array) {
		foreach ($array as $key => $val) {
			if ($val['code'] === $value) {
				return $key;
			}
		}
		return null;
	}
}

/* if user already used this coupon */
if(!function_exists('lp_check_used_coupon')){
	function lp_check_used_coupon($code) {
		$user_id = get_current_user_id();
		$usedCoupons = get_user_meta($user_id,  'used_coupons', true );
		if(!empty($usedCoupons)){
			$returnKey = array_search($code,$usedCoupons);
			return $returnKey;
		}
		return null;
	}
}



/* get status by coupon code */
if(!function_exists('lp_check_coupon_status')){
	function lp_check_coupon_status($code) {
		$existingCoupons = lp_get_existing_coupons();
		if(!empty($existingCoupons)){
			foreach($existingCoupons as $singleCoupon){
				$singleCOde = $singleCoupon['code'];
				if($singleCOde==$code){
					$cstarts = $singleCoupon['starts'];
					$cends = $singleCoupon['ends'];
					$coponlimit = $singleCoupon['coponlimit'];
					$used = $singleCoupon['used'];
					$status = $singleCoupon['status'];
					$date_now = date("Y-m-d");
					if ($date_now < $cstarts) {
						return 'pending';
					}elseif( $date_now > $cends || $used >= $coponlimit || $status=="expired" ){
						return 'expired';
					}else{
						return 'active';
					}
					
				}
			}
		}
		return false;
	}
}




/* get coupon status counter by type*/
if(!function_exists('lp_get_coupon_status_counter')){
	function lp_get_coupon_status_counter($type, $return=null) {
		$existingCoupons = lp_get_existing_coupons();
		$count = 0;
		$excount = 0;
		$dataArrayActive = array();
		$dataArrayExpired = array();
		if(!empty($existingCoupons)){
			if($type=='all'){
				if(!empty($return)){
					return $existingCoupons;
				}else{
					$count = count($existingCoupons);
					return $count;
				}
			}elseif($type=='active' || $type=='expired'){
				foreach($existingCoupons as $singleCoupon){
					$cstarts = $singleCoupon['starts'];
					$cends = $singleCoupon['ends'];
					$coponlimit = $singleCoupon['coponlimit'];
					$used = $singleCoupon['used'];
					$status = $singleCoupon['status'];
					$date_now = date("Y-m-d");
					if( $date_now > $cends || $used >= $coponlimit || $status=="expired" ){
						if(!empty($return)){
							$dataArrayExpired[] = $singleCoupon;
						}else{
							$excount++;
						}
					}else{
						if(!empty($return)){
							$dataArrayActive[] = $singleCoupon;
						}else{
							$count++;
						}
					}
				}
				if($type=='active'){
					if(!empty($return)){
						return $dataArrayActive;
					}else{
						return $count;
					}
				}elseif($type=='expired'){
					if(!empty($return)){
						return $dataArrayExpired;
					}else{
						return $excount;
					}
				}
			}
		}
		
	}
}





if(!function_exists('listingpro_coupons_page')){
	function listingpro_coupons_page(){
		
		$existingCoupons = lp_get_existing_coupons();
		$allCount = lp_get_coupon_status_counter('all', null);
		$activeCount = lp_get_coupon_status_counter('active', null);
		$expiredCount = lp_get_coupon_status_counter('expired', null);
		
		?>

		<div class="wrap listingpro-coupons">

			<h1 class="wp-heading-inline"><?php echo esc_html__('Listingpro Coupons', 'listingpro-plugin'); ?></h1>

			<button id="show_add_coupons" class="page-title-action">Add New</button>
			<div class="toggle_add_coupons" style="display: none;">


				<h4><?php echo esc_html__('Add New', 'listingpro-plugin'); ?></h4>
				<form name="lp_add_coupon_form" method="POST" action="">
					<div class="form-group">
						<label for="coponcodebtn"><?php echo esc_html__('Coupon Code : ', 'listingpro-plugin'); ?></label>
					</div>
					<div class="form-group">
						<button type="button" id="coponcodebtn" onclick="lprandomString(10)" class="btn btn-default"><?php echo esc_html__('Generate', 'listingpro-plugin'); ?></button>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="couponcode" placeholder="Please click on generate button" name="couponcode" required>
					</div>
					<div class="form-group">
						<label for="couponpercentage"><?php echo esc_html__('Discount(without % sign) : ', 'listingpro-plugin'); ?></label>
						<input type="text" class="form-control" id="couponpercentage" placeholder="Please add discount %" name="couponpercentage" required>
					</div>
					<div class="form-group">
						<label for="couponstarts"><?php echo esc_html__('Start Date : ', 'listingpro-plugin'); ?></label>
						<input type="date" class="form-control" id="couponstarts" placeholder="Coupon Starts" name="couponstarts" required>
					</div>
					<div class="form-group">
						<label for="couponends"><?php echo esc_html__('End Date : ', 'listingpro-plugin'); ?></label>
						<input type="date" class="form-control" id="couponends" placeholder="Coupon Ends" name="couponends" required>
					</div>
					<div class="form-group">
						<label for="coponlimit"><?php echo esc_html__('Limit : ', 'listingpro-plugin'); ?></label>
						<input type="text" class="form-control" id="coponlimit" placeholder="5" name="coponlimit" required>
					</div>
					
					<input type="hidden" name="lp_submit_new_coupon" value="submit it">
					<button type="submit" class="btn btn-default"><?php echo esc_html__('Save Coupon', 'listingpro-plugin'); ?></button>
				</form>

			</div>
			
			<div class="clearfix"></div>
			<ul class="subsubsub lpbackendtabs">
				<li class="all tab-link current" data-tab="tab-1"><a>All <span class="count">(<?php echo $allCount; ?>)</span></a> |</li>
				<li class="publish tab-link" data-tab="tab-2"><a >Active <span class="count">(<?php echo $activeCount; ?>)<span></a> |</li>
				<li class="expired tab-link" data-tab="tab-3"><a>Expired <span class="count">(<?php echo $expiredCount; ?>)</span></a></li>
			</ul>


			<div id="posts-filter" method="get">

				
					
					<?php
					if(!empty($existingCoupons)){

						?>
						<div class="listingpro_coupon_table">
							<!--all -->
							<div id="tab-1" class="lp-backendtabs-content current">
								<?php
									include_once 'templates/all.php';
								?>
												
							</div>
											
							<!--active -->
							<div id="tab-2" class="lp-backendtabs-content">
								<?php
									include_once 'templates/active.php';
								?>
							</div>
							
							
							<!--expired -->
							<div id="tab-3" class="lp-backendtabs-content">
								<?php
									include_once 'templates/expired.php';
								?>
							</div>
											
										</div>
									</div>

									<?php
								}else{
									/* blank */
								?>	
								
										<div class="listingpro_coupon_table">
										<!--all -->
											<div id="tab-1" class="lp-backendtabs-content current">
												<?php
													include_once 'templates/blank.php';
												?>
																
											</div>
										</div>
								<?php } ?>



								<script>
									;(function() {
										var lprandomString = function(length) {

											var text = "";

											var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

											for(var i = 0; i < length; i++) {

												text += possible.charAt(Math.floor(Math.random() * possible.length));

											}

											var elem = document.getElementById("couponcode").value = text;
											//return text;
										}

										// random string length
										//var random = lprandomString(10);
										//alert(random);
										document.getElementById("coponcodebtn").addEventListener("click", lprandomString(10));								
										
									})();
									
									function lprandomString(length){
										var text = "";
										
										var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
										
										for(var i = 0; i < length; i++) {

											text += possible.charAt(Math.floor(Math.random() * possible.length));

										}
										
										var elem = document.getElementById("couponcode").value = text;
									}
									
										// insert random string to the field
									//var elem = document.getElementById("couponcode").value = random;
									
								</script>


				</div>

				<?php
			}
		} 

