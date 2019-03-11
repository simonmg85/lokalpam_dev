<?php
/* listingpro aditional functions */

if(!function_exists('lp_generate_invoice_mail')){
	function lp_generate_invoice_mail($post) {
		if( $post->post_type=="listing" ) {
			$ID = $post->ID;
			global $listingpro_options;
			$author = $post->post_author;
			$name = get_the_author_meta( 'display_name', $author );
			$useremail = get_the_author_meta( 'user_email', $author );
			$user_name = $name;

				$website_url = site_url();
				$website_name = get_option('blogname');
				$listing_title = $post->post_title;
				$listing_url = get_permalink( $ID );
				$plan_id = listing_get_metabox_by_ID('Plan_id',$ID);
				$plan_title = 'N/A';
				$plan_price = 'N/A';
				$invoice_no = 'N/A';
				$payment_method = 'N/A';
				if(!empty($plan_id)){
					$oplan_price = get_post_meta($plan_id, 'plan_price', true);
					if(!empty($oplan_price)){
						$plan_title = get_the_title($plan_id);
						
						global $wpdb;
						$dbprefix = $wpdb->prefix;
						$table = "listing_orders";
						$table =$dbprefix.$table;
						
						$results = array();
						if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
							$query = "";
							$query = "SELECT * from $table WHERE post_id='$ID' ORDER BY main_id DESC";
							$results = $wpdb->get_results( $query);
							$results = array_reverse($results);
						}

						foreach($results as $Index=>$Value){
							$invoice_no = $Value->order_id;
							$plan_price = $Value->price;
							$payment_method = $Value->payment_method;
						}
					}
				}
				$headers[] = 'Content-Type: text/html; charset=UTF-8';

				$u_mail_subject_a = '';
				$u_mail_body_a = '';
				$u_mail_subject = $listingpro_options['listingpro_subject_listing_approved'];
				$u_mail_body = $listingpro_options['listingpro_listing_approved'];
				
				$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name",
					'user_name' => "$user_name",
					'plan_title' => "$plan_title",
					'plan_price ' => "$plan_price ",
					'invoice_no ' => "$invoice_no ",
					'payment_method ' => "$payment_method ",
				));
				
				$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name",
					'user_name' => "$user_name",
					'plan_title' => "$plan_title",
					'plan_price ' => "$plan_price ",
					'invoice_no ' => "$invoice_no ",
					'payment_method ' => "$payment_method ",
				));
				
				wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);
		}
			
	}
		
}
add_action( 'pending_to_publish', 'lp_generate_invoice_mail', 10, 1);
//add_action('new_to_publish', 'lp_generate_invoice_mail', 10, 1);
add_action('draft_to_publish', 'lp_generate_invoice_mail', 10, 1);

/* ================================= force trash delete ads============================ */


if(!function_exists('listingpro_trash_ads_delete')){
	function listingpro_trash_ads_delete($post_id) {
		if (get_post_type($post_id) == 'lp-ads') {
			// Force delete
			wp_delete_post( $post_id, true );
		}
	}
}	
add_action('wp_trash_post', 'listingpro_trash_ads_delete');

/* ======================= on deleting review ============ */
add_action( 'wp_trash_post', 'lp-deltereviewmeta' );
if(!function_exists('deltereviewmeta')){
	function deltereviewmeta( $postid ){

		global $post_type;   
		if ( $post_type != 'lp-reviews' ) return;
		$listingid = listing_get_metabox_by_ID('listing_id', $postid);
		if(!empty($listingid)){
			$total_reviewed = get_post_meta( $listingid, 'listing_reviewed', true );
			if ( ! empty( $total_reviewed ) ) {
				$total_reviewed--;
				update_post_meta( $listingid, 'listing_reviewed', $total_reviewed );
			}
		}
		
	}
}