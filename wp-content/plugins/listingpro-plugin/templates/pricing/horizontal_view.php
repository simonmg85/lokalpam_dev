<?php
	global $listingpro_options;
	global $wpdb;
	
	$lp_social_show;
	$lp_social_show = $listingpro_options['listin_social_switch'];
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$output1 = null;
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
	$horposiclass = '';
	if($pricing_views == 'horizontal_view' && $pricing_horizontal_view == 'horizontal_view_2'){

		$horposiclass = 'lp-horizontial-specific';
	}
	
	/* horizontal view */
	
	$output1 .= '
				<div class="page-inner-container '.$hide_plan_class.' '.$horposiclass.'">';
					$args = array(
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
					$query = new WP_Query( $args );
					if($query->have_posts()){
						while ( $query->have_posts() ) {
							$query->the_post();
							global $post;
							ob_start();
							include( LISTINGPRO_PLUGIN_PATH . "templates/pricing/loop/".$pricing_horizontal_view.'.php');
							$output1 .= ob_get_contents();
							ob_end_clean();
							ob_flush();
						}/* END WHILE */
						wp_reset_postdata();
					}else {
						echo '<p class="text-center">'.esc_html__('There is no Plan available right now.', 'listingpro-plugin').'</p>';
					}
					$output1 .= '
			</div>';
	
	echo $output1;
?>