<?php
/* ============== ListingPro create pages ============ */
	
	
	
	add_action('admin_init','check_pages_live');
	if (!function_exists('check_pages_live')) {		
		function check_pages_live(){
			
			if (  class_exists( 'Redux' ) ) {
					global $listingpro_options;
					global $opt_name;
					$opt_name = 'listingpro_options';
					$pricing_plan = $listingpro_options['pricing-plan'];
					$submit_listing = $listingpro_options['submit-listing'];
					$listing_author = $listingpro_options['listing-author'];
				if(empty($pricing_plan) && empty($submit_listing) && empty($listing_author) && empty($payment_checkout) && empty($payment_fail)){
					create_page_if_null('Dashboard', '', 'listing-author');
					create_page_if_null('Submit Your Listing', '[vc_row row_type="row_full_center_content" bg_color="#eff3f6" bg_repeat="no-repeat" bg_attatch="scroll"][vc_column][listingpro_submit title="Add your Listing" subtitle="Add details about your listing"][/vc_column][/vc_row]', 'submit-listing');
					create_page_if_null('Edit Your Listing', '[vc_row row_type="row_full_center_content" bg_color="#eff3f6" bg_repeat="no-repeat" bg_attatch="scroll"][vc_column][listingpro_edit title="Edit your Listing" subtitle="Edit details about your listing"][/vc_column][/vc_row]', 'edit-listing');
					create_page_if_null('Select Your Plan', '[vc_row row_type="row_full_center_content" bg_color="#eff3f6"][vc_column][listingpro_pricing title="Add your Listing" subtitle="Add details about your listing" pricing_views="vertical_view"][/vc_column][/vc_row]', 'pricing-plan');
					
					create_page_if_null('Payment Success', '', 'payment-success');
					create_page_if_null('Payment Fail', '', 'payment-fail');
					create_page_if_null('Payment Checkout', '[vc_row row_type="row_full_center_content" bg_color="#eff3f6" bg_repeat="no-repeat" bg_attatch="scroll"][vc_column][listingpro_checkout title="See listings and pay" subtitle="Select your listings and payment method to proceed"][/vc_column][/vc_row]', 'payment-checkout');
					
					
				}
			}
		}
	}
	
	//add_action('admin_init','check_set_options');
	add_action( "redux/options/listingpro_options/settings/change", "check_set_options"); 
	if (!function_exists('check_set_options')) {
		function check_set_options(){
			$counter = 0;
			
				if (  class_exists( 'Redux' ) ) {
					global $listingpro_options;
					global $opt_name;
					$opt_name = 'listingpro_options';
					$pricing_plan = $listingpro_options['pricing-plan'];
					$submit_listing = $listingpro_options['submit-listing'];
					$edit_listing = $listingpro_options['edit-listing'];
					$listing_author = $listingpro_options['listing-author'];
					$payment_checkout = $listingpro_options['payment-checkout'];
						//print_r($listingpro_options);
						if(empty($listing_author)){
							
							if( get_page_by_title('Dashboard') != NULL ) {
								$page = get_page_by_title('Dashboard');
								$permalink = get_permalink($page->ID);
								$status  = get_post_status( $page->ID );
								if($status == 'publish'){
									Redux::setOption( $opt_name, 'listing-author', $permalink);
								}
							}
						}
						
						if(empty($submit_listing)){
							if( get_page_by_title('Submit Your Listing') != NULL ) {
								$page = get_page_by_title('Submit Your Listing');
								$permalink = get_permalink($page->ID);
								$status  = get_post_status( $page->ID );
								if($status == 'publish'){
									Redux::setOption( $opt_name, 'submit-listing', $permalink);
								}
							}
						}
						
						if(empty($edit_listing)){
							if( get_page_by_title('Edit Your Listing') != NULL ) {
								$page = get_page_by_title('Edit Your Listing');
								$permalink = get_permalink($page->ID);
								$status  = get_post_status( $page->ID );
								if($status == 'publish'){
									Redux::setOption( $opt_name, 'edit-listing', $permalink);
								}
							}
						}
						
						if(empty($pricing_plan)){
							if( get_page_by_title('Select Your Plan') != NULL ) {
								$page = get_page_by_title('Select Your Plan');
								$permalink = get_permalink($page->ID);
								$status  = get_post_status( $page->ID );
								if($status == 'publish'){
									Redux::setOption( $opt_name, 'pricing-plan', $permalink);
								}
							}
						}

						if(empty($payment_checkout)){
							if( get_page_by_title('Payment Checkout') != NULL ) {
								$page = get_page_by_title('Payment Checkout');
								$permalink = $page->ID;
								$status  = get_post_status( $page->ID );
								if($status == 'publish'){
									Redux::setOption( $opt_name, 'payment-checkout', $permalink);
								}
							}
						}
					
				
				}

		}
	}
	
	
	
	if (!function_exists('create_page_if_null')) {
		function create_page_if_null($target,$content,$slug) {
			if( get_page_by_title($target) == NULL ) {
				listingpro_create_pages($target,$content,$slug);
			}
		}
	}
	
	
	
	if (!function_exists('listingpro_create_pages')) {
		function listingpro_create_pages($pageName,$content,$slug) {
			$createPage = array(
			  'post_title'    => $pageName,
			  'post_content'  => $content,
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type'     => 'page',
			  'post_name'     => $slug
			);
			if($slug == 'listing-author'){
				$createPage = array(
				  'post_title'    => $pageName,
				  'post_content'  => $content,
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_type'     => 'page',
				  'post_name'     => $slug,
				  'page_template'  => 'template-dashboard.php'
				);
			}

			if($slug == 'payment-success'){
				$createPage = array(
				  'post_title'    => $pageName,
				  'post_content'  => $content,
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_type'     => 'page',
				  'post_name'     => $slug,
				  'page_template'  => 'templates/template-payment-thankyou.php'
				);
			}

			if($slug == 'payment-fail'){
				$createPage = array(
				  'post_title'    => $pageName,
				  'post_content'  => $content,
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_type'     => 'page',
				  'post_name'     => $slug,
				  'page_template'  => 'templates/template-payment-cancel.php'
				);
			}

			// Insert the post into the database
			 wp_insert_post( $createPage );
	
		}
    }