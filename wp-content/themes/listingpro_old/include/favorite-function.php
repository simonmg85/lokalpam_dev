<?php
/**
 * Listingpro Functions.
 *
 */
	/* ============== ListingPro Add to favorite ============ */
	
	add_action('wp_ajax_listingpro_add_favorite',        'listingpro_add_favorite');
	add_action('wp_ajax_nopriv_listingpro_add_favorite', 'listingpro_add_favorite');
	
	if(!function_exists('listingpro_add_favorite')){
		function listingpro_add_favorite(){
			// Load current favourite posts from cookie
			$favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!

			// Add (or remove) favourite post IDs
			$favposts[] = $_POST['post-id'];
			$type = $_POST['type'];
			
			 //$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
			//$host = parse_url(get_option('siteurl'), PHP_URL_HOST);
			// Update cookie with new favourite posts
			$time_to_live = 3600 * 24 * 30; // 30 days
			setcookie('newco', implode(',', array_unique($favposts)), time() + $time_to_live ,"/");
			
			$done = json_encode(array("type"=>$type,"active"=>'yes',"id"=>$favposts));
			die($done);
					
		}
	}
	
	
	/* ============== ListingPro Remove from favorite ============ */
	
	add_action('wp_ajax_listingpro_remove_favorite',        'listingpro_remove_favorite');
	add_action('wp_ajax_nopriv_listingpro_remove_favorite', 'listingpro_remove_favorite');
	
	if(!function_exists('listingpro_remove_favorite')){
		function listingpro_remove_favorite(){
			// Load current favourite posts from cookie
			$favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!

			// Add (or remove) favourite post IDs
			$favpostsd = $_POST['post-id'];		
			foreach($favposts as $index => $value)

			{

				if($value == $favpostsd)

				{

					unset($favposts[$index]);

				}

			}
			
			
			 //$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
			//$host = parse_url(get_option('siteurl'), PHP_URL_HOST);
			// Update cookie with new favourite posts
			$time_to_live = 3600 * 24 * 30; // 30 days
			setcookie('newco', implode(',', array_unique($favposts)), time() + $time_to_live ,"/");
			
			$done = json_encode(array("remove"=>'yes',"id"=>$favposts, 'remove_text' =>esc_html__('Save', 'listingpro')));
			die($done);
					
		}
	}

	
	add_action('init', 'listingpro_fav_ids');

	if(!function_exists('listingpro_fav_ids')){
		function listingpro_fav_ids(){
		 $favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
		 $favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
		 return $favposts;
		}
	}
	
	
	/* ============== is favourite DETAIL ============ */
	
	if (!function_exists('listingpro_is_favourite')) {
		
		function listingpro_is_favourite($postid,$onlyicon=true){
			$favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
			
			if($onlyicon == true){
				if (in_array($postid,$favposts )) {
					return 'fa-bookmark';
				}else{
					return 'fa-bookmark-o';
				}
			}else{
				global $listingpro_options;	
				if (in_array($postid,$favposts )) {
					echo esc_html__('Saved', 'listingpro');
				}else{
					echo esc_html__('Save', 'listingpro');
				}
			}
		
		}
		
	}
	
	
	/* ============== is favourite GRID ============ */
	
	if (!function_exists('listingpro_is_favourite_grids')) {
		
		function listingpro_is_favourite_grids($postid,$onlyicon=true){
			$favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
			
			if($onlyicon == true){
				if (in_array($postid,$favposts )) {
					return 'fa-bookmark';
				}else{
					return 'fa-bookmark-o';
				}
			}else{
				if (in_array($postid,$favposts )) {
					return esc_html__('Saved', 'listingpro');
				}else{
					return esc_html__('Save', 'listingpro');
				}
			}
		
		}
		
	}
	
	/* ============ fav function to get fav ====================== */
	function getSaved(){
	 $favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();
	 $favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
	 return $favposts;
	}