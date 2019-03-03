<?php
	global $listingpro_options;
	$listing_access_only_users = $listingpro_options['lp_allow_vistor_submit'];
	$showAddListing = true;
	if( isset($listing_access_only_users)&& $listing_access_only_users==1 ){
		$showAddListing = false;
		if(is_user_logged_in()){
			$showAddListing = true;
		}
	}
	if( $showAddListing==false ){
		wp_redirect(home_url());
		exit;
	}
	global $wpdb;
	
	$lp_social_show;
	$lp_social_show = $listingpro_options['listin_social_switch'];

	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$outputVert = null;
	$results = null;
	$table_name = $dbprefix.'listing_orders';
	$limitLefts = '';
	$taxOn = $listingpro_options['lp_tax_swtich'];
	$withtaxprice = false;
	if($taxOn=="1"){
		$showtaxwithprice = $listingpro_options['lp_tax_with_plan_swtich'];
		if($showtaxwithprice=="1"){
			$withtaxprice = true;
		}
	}
	$hide_plan_class = 'lp_hide_general_plans';
	$borderclass = '';

	// class added for border in views
	if( $pricing_views == 'vertical_view' && $pricing_vertical_view == 'vertical_view_2' || 
		$pricing_views == 'vertical_view' && $pricing_vertical_view == 'vertical_view_6' ||
		$pricing_views == 'vertical_view' && $pricing_vertical_view == 'vertical_view_7' ||
		$pricing_views == 'vertical_view' && $pricing_vertical_view == 'vertical_view_8' ||
		$pricing_views == 'vertical_view' && $pricing_vertical_view == 'vertical_view_9'){
		
		$borderclass = 'lp-plan-view-border';
	}
	
	/* vertical view code */
	
			$outputVert .='
			<div class="page-inner-container '.$hide_plan_class.' '.$borderclass.'">';
					$args1 = array(
						'post_type' => 'price_plan',
						'posts_per_page' => -1,
						'post_status' => 'publish',
						'meta_query'=>array(
							'relation' => 'OR',
							array(
								'key' => 'plan_usge_for',
								'value' => 'default',
								'compare' => 'LIKE',
							),
							array(
								'key' => 'lp_selected_cats',
								'compare' => 'NOT EXISTS',
							),
							

						),
					);
					$query1 = new WP_Query( $args1 );
					if($query1->have_posts()){
						while ( $query1->have_posts() ) {
							$query1->the_post();
							ob_start();
							include( LISTINGPRO_PLUGIN_PATH . "templates/pricing/loop/".$pricing_vertical_view.'.php');
							$outputVert .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							
						}/* END WHILE */
						wp_reset_postdata();
					}else {
						echo '<p class="text-center">'.esc_html__('There is no Plan available right now.', 'listingpro-plugin').'</p>';
					}
					$outputVert .= '
				
			</div>';
		
		echo $outputVert;
?>