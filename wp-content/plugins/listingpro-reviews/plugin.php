<?php
/*
Plugin Name: ListingPro Reviews
Plugin URI: 
Description: This plugin Only competible With listingpro Theme By CridioStudio.
Version: 1.0.0
Author: CridioStudio (Dev Team)
Author URI: http://www.cridio.io
Author Email: support@cridio.com

  Copyright 2016 CridioStudio
*/



	/* ============== Visual composer added ============ */
	
	class ListingReviews{
	}

	
	add_action( 'init', 'listing_reviews_admin_init' );
    function listing_reviews_admin_init() {
		
	}
	include_once(WP_PLUGIN_DIR.'/listingpro-reviews/functions.php');
	include_once(WP_PLUGIN_DIR.'/listingpro-reviews/include/reviews_functions.php');
	include_once(WP_PLUGIN_DIR.'/listingpro-reviews/include/review_ajax.php');
	
	if(!function_exists('Listingpro_ajax_review_init')){
		function Listingpro_ajax_review_init(){
			
			
			wp_register_script('ajax-review-script', plugins_url( 'assets/js/change-status.js', __FILE__ )); 
			wp_enqueue_script('ajax-review-script');

			
		}
	}
	
	add_action('admin_enqueue_scripts', 'Listingpro_ajax_review_init');
	
	