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
					));
					
					$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
						'website_url' => "$website_url",
						'listing_title' => "$listing_title",
						'listing_url' => "$listing_url",
						'website_name' => "$website_name",
						'user_name' => "$user_name",
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