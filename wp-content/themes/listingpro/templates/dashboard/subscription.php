<div class="tab-pane fade in active" id="updateprofile">
	<?php
	global $listingpro_options;
	global $wpdb;
	$dbprefix = '';
	$post_ids = '';
	$dbprefix = $wpdb->prefix;
	$user_id = '';
	$user_id = get_current_user_id();
	$results = '';
	$resultss = '';
	$userSubscriptions;
	$userSubscriptions = get_user_meta($user_id, 'listingpro_user_sbscr', true);
	require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
	$strip_sk = $listingpro_options['stripe_secrit_key'];
	\Stripe\Stripe::setApiKey($strip_sk);
	$currency = listingpro_currency_sign();
	$currency_position = lp_theme_option('pricingplan_currency_position');
	?>
    <!-- Active Packages -->
    <div class="subscriptions">
        <div class="active-subscirptions-area">
			<?php if(!empty($userSubscriptions) && count($userSubscriptions)>0 ){ ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php esc_html_e('No.','listingpro'); ?></th>
                            <th><?php esc_html_e('Subscription','listingpro'); ?></th>
                            <th><?php esc_html_e('Listing Title','listingpro'); ?></th>
                            <th><?php esc_html_e('Duration','listingpro'); ?></th>
                            <th><?php esc_html_e('Price','listingpro'); ?></th>
                            <th><?php esc_html_e('Upcoming renewal','listingpro'); ?></th>
                            <th><?php esc_html_e('Action','listingpro'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
						<?php
						global $wpdb;
						$n=1;
						foreach($userSubscriptions as $subscription){

							try {
								$plan_id = $subscription['plan_id'];
								$subscr_id = $subscription['subscr_id'];
								$listing_id = $subscription['listing_id'];
								$subscrObj = \Stripe\Subscription::retrieve($subscr_id);

								//echo '<pre>';
								//print_r($subscrObj);
								//echo '</pre>';
								$subscrID = $subscrObj->id;
								$listing_title = get_the_title($listing_id);
								$plan_price = get_post_meta($plan_id, 'plan_price', true);
								$plan_duration = get_post_meta($plan_id, 'plan_time', true);
								$plan_duration = trim($plan_duration);
								$taxStatus = '';
								$planStripe = $subscrObj->plan;
								$stripePrice = $planStripe->amount;
								$plan_price = get_post_meta($plan_id, 'plan_price', true);

								$dbprefix = $wpdb->prefix;
								$myPrice = $wpdb->get_row( "SELECT * FROM ".$dbprefix."listing_orders WHERE plan_id = $plan_id" );
								if(!empty($myPrice)){
									$plan_price = $myPrice->price;
								}

								$stripePrice = (float)$stripePrice/100;
								$stripePrice = round($stripePrice, 2);
								if($stripePrice==$plan_price){
									$taxStatus = esc_html__('exc. tax', 'listingpro');
								}
								else{
									$plan_price = $stripePrice;
									$taxStatus = esc_html__('inc. tax', 'listingpro');
								}

								if($currency_position=='right'){
									$plan_price .=$currency;
								}else{
									$plan_price =$currency.$plan_price;
								}
								$dayVar = esc_html__('Days', 'listingpro');
								if(!empty($plan_duration)){
									if($plan_duration==1){
										$dayVar = esc_html__('Day', 'listingpro');
									}
								}
								?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td><?php echo $subscrID; ?></td>
                                    <td><?php echo $listing_title; ?></td>
                                    <td><?php echo $plan_duration.' '.$dayVar; ?></td>
                                    <td><?php echo $plan_price." ($taxStatus)"; ?></td>
                                    <td><?php echo date("F j, Y", $subscrObj->current_period_end); ?></td>
                                    <td><a class="delete-subsc-btn" href="<?php echo $subscrID; ?>" data-cmsg="<?php echo esc_html__('Are you sure you want to proceed action?', 'listingpro'); ?>"><?php echo esc_html__('Unsubscribe', 'listingpro'); ?></a></td>
                                </tr>

								<?php
							}catch (Exception $e) {
							}
							$n++;
						}
						?>
                        </tbody>
                    </table>
                </div>


			<?php } if(empty($userSubscriptions)){ ?>
                <div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
                    <h1><?php esc_html_e('Ooops!','listingpro'); ?></h1>
                    <p><?php esc_html_e('Sorry ! You have no active subscriptions yet','listingpro'); ?></p>
                </div>
			<?php } ?>
        </div>


    </div>

