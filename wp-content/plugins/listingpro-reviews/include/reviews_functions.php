<?php

	/* ============== ListingPro Custom post type columns ============ */
	
	if (!function_exists('lp_review_columns')) {
		function lp_review_columns($columns) {
			return array(
				'cb' => '<input type="checkbox" />',			
				'title' => esc_html__('Review Title'),			
				'list_title' => esc_html__('Listing Title'),			
				'review_rating' => esc_html__('Rating'),			
				'author' => esc_html__('Author'),
				'date' => esc_html__('Date')
			);
		}
		add_filter('manage_lp-reviews_posts_columns' , 'lp_review_columns');
	}
	
	/* ============== content for custom column ======================*/
	
	if (!function_exists('listingpro_reviews_columns_content')) {
		function listingpro_reviews_columns_content($column_name, $post_ID) {
			
			if ($column_name == 'list_title') {
				$metabox = get_post_meta($post_ID, 'lp_' . strtolower(THEMENAME) . '_options', true);
				if(isset($metabox['listing_id']) && !empty($metabox['listing_id'])){
					echo get_the_title($metabox['listing_id']);
				}
			}
			
			if ($column_name == 'review_rating') {
				$metabox = get_post_meta($post_ID, 'lp_' . strtolower(THEMENAME) . '_options', true);
				if(isset($metabox['rating']) && !empty($metabox['rating'])){
					$noRatings = 5;
					while($metabox['rating']>0){
						echo '<i class="fa fa-star"></i>';
						$metabox['rating']--;
						$noRatings--;
					}
					while($noRatings>0){
						echo '<i class="fa fa-star-o"></i>';
						$noRatings--;
					}
					
				}
			}
		
			
		}
		add_action('manage_lp-reviews_posts_custom_column', 'listingpro_reviews_columns_content', 10, 2);
	}
	
	/* ============== redirect on single review post view to home page ======================*/
	add_action( 'template_redirect', 'redirect_reviews_singular_posts' );
    function redirect_reviews_singular_posts() {
		if ( is_singular('lp-reviews') ) {
			wp_redirect( home_url(), 302 );
			exit;
		}
    }
	
	
/* ================================================================================== */
/* added on 7 april by zaheer */

	function save_lp_review_meta( $post_id, $post, $update ) {
		
		
		if (isset($post->post_status) && 'auto-draft' == $post->post_status) return;
		if ( wp_is_post_revision( $post_id ) )return;
		$post_type = get_post_type($post_id);
		if ( "lp-reviews" != $post_type ) return;
		
		$review_id = $_POST['post_ID'];
		$listing_id = $_POST['listing_id'];
		$status = $_POST['review_status'];
		$rating = $_POST['rating'];
		
		if($_POST['original_post_status']=="publish"){
				$action = 'update';
				listingpro_set_listing_ratings($review_id, $listing_id , $rating , $action);
				listingpro_total_reviews_add($listing_id);
		}
		else{
				$action = 'add';
				listingpro_set_listing_ratings($review_id, $listing_id , $rating , $action);
		}
		

	}
add_action( 'save_post', 'save_lp_review_meta', 10, 3 );

if(!function_exists('listingpro_trash_review_delete')){
	function listingpro_trash_review_delete($post_id) {
		if (get_post_type($post_id) == 'lp-reviews') {
			// Force delete
			wp_delete_post( $post_id, true );
		}
	}
}	
add_action('wp_trash_post', 'listingpro_trash_review_delete');
/* end on 7 april by zaheer */
/* ================================================================================== */	
?>