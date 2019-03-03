<?php
/**
 * Claim List
 *
 */

/* ============== ListingPro Claim Ajax Init ============ */
	
	if(!function_exists('Listingpro_ajax_approve_review_init')){
		function Listingpro_ajax_approve_review_init(){
			
			
			wp_register_script('ajax-approvereview-script', get_template_directory_uri() . '/assets/js/approve-review.js', array('jquery') ); 
			 
			wp_enqueue_script('ajax-approvereview-script');

			wp_localize_script( 'ajax-approvereview-script', 'ajax_approvereview_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));
			
			
			
		}
		if(!is_admin()){
			if(!is_singular('listing')){
				add_action('init', 'Listingpro_ajax_approve_review_init');
			}
		}
	}
	
	
	
	add_action('wp_ajax_listingpro_review_status', 'listingpro_review_status');
	add_action('wp_ajax_nopriv_listingpro_review_status', 'listingpro_review_status');
	if(!function_exists('listingpro_review_status')){
		function listingpro_review_status(){
			
			if( isset( $_POST[ 'formData' ] ) ) {
				$data = json_decode(stripslashes($_POST[ 'formData' ]));
				$id = '';
				$current_status = '';
				$passive_status = '';
				$response;
				
				$id = $data[0];
				$current_status = $data[1];
				$passive_status = $data[2];
				
				if( !empty($id) ){
					listing_set_metabox('review_status', '', $id);
					listing_set_metabox('review_status', $passive_status, $id);
					
					$response = array('statuss' => 'success', 'current_status' => $passive_status, 'passive_status' => $current_status);
					
					echo json_encode( $response );
					
				}
				else{
					$response = array('statuss' => 'fail');
					echo json_encode($response);
				}
				
			}
			
			else{
				$response = array('status' => 'fail');
				echo json_encode($response);
			}
			  
			exit();
			

		}
	}