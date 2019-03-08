<?php
/**
 * Search Filters.
 *
 */
/* ============== ListingPro get child term (tags) in search ============ */
?>
<?php
if (!function_exists('listingpro_search_term_method')) {
    function listingpro_search_term_method()
    {
        wp_register_script('search-ajax-script', get_template_directory_uri() . '/assets/js/search-ajax.js', array(
            'jquery'
        ));
        wp_enqueue_script('search-ajax-script');
        wp_localize_script('search-ajax-script', 'ajax_search_term_object', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
    if (!is_admin()) {
        add_action('init', 'listingpro_search_term_method');
    }
}
/* ============== ListingPro Search Term ============ */
add_action('wp_ajax_ajax_search_term', 'ajax_search_term');
add_action('wp_ajax_nopriv_ajax_search_term', 'ajax_search_term');
if (!function_exists('ajax_search_term')) {
	function ajax_search_term()
	{
		$term_id     = sanitize_text_field($_POST['term_id']);
		$count       = 1;
		$tagsHTML    = '';
		$featureName = '';
		$termparent  = '';
		$parent      = '';
		$hasfeature = false;
		$showdivwrap = true;
		$sortedFeatuers = array();
		if (!empty($term_id)) {
			$termparent = get_term_by('id', $term_id, 'listing-category');
			$parent     = $termparent->parent;
		}
		$features = listingpro_get_term_meta($term_id, 'lp_category_tags');
		if (empty($features)) {
			$features = listingpro_get_term_meta($parent, 'lp_category_tags');
		}
		global $listingpro_options;
		$listing_style = $listingpro_options['listing_style'];
		$ULClass = '';
		$FetTitle = '';


		/* for sorting  creating array*/
		if(!empty($features)){
			foreach ($features as $feature) {
				$terms = get_term_by('id', $feature, 'features');
				if (!empty($terms)) {
					$sortedFeatuers[$feature] = $terms->name;
				}

			}
		}

		if (!empty($sortedFeatuers)) {
			sort($sortedFeatuers);

			foreach($sortedFeatuers as $featureName) {
				$terms = get_term_by('name', $featureName, 'features');
				if (!empty($terms)) {
					$featurCount = lp_count_postcount_taxonomy_term_byID('listing','features', $terms->term_id);

					if(!empty($featurCount)){
						$hasfeature = true;
					}
					if($hasfeature==true && $showdivwrap == true){
						if($listing_style == '4'){
							$tagsHTML = '<div class="form-inline tags-area add-border">
														<div class="form-group">
														<div class="input-group margin-right-0">
														<strong class="col-sm-2">'.esc_html__("Features", "listingpro").'</strong>
														<div class="col-sm-10">
														<ul class="lp-features-inner-container">';
						}else{
							$tagsHTML = '<div class="form-inline lp-features-filter tags-area"><div class="form-group"><div class="input-group margin-right-0"><ul>';
						}

						$showdivwrap = false;
					}

					if(!empty($featurCount)){

						$tagsHTML .= '<li>';
						$tagsHTML .= '<div class="pad-bottom-10 checkbox">';
						$tagsHTML .= '<input type="checkbox" name="searchtags[' . $count . ']" id="check_' . $count . '" class="searchtags" value="' . $terms->term_id . '">';
						$tagsHTML .= '<label for="' . $terms->term_id . '">' . $terms->name . '</label>';
						$tagsHTML .= '</div>';
						$tagsHTML .= '</li>';
					}

					$count++;

				}
			}
			if($hasfeature==true){
				$tagsHTML .= '</ul>';
				$tagsHTML .= '</div>';
				$tagsHTML .= '</div>';
				$tagsHTML .= '</div>';
				if($listing_style == '4'){
					$tagsHTML .= '</div>';
				}
			}

		}
		if(lp_theme_option('listing_style')=="4"){
			/* style 4 */
			$htmlFilter = lp_gett_extrafield_in_filterAjax($term_id);

		}else{
			/* style 1 and 2 */
			$htmlFilter = lp_get_extrafield_in_filterAjax($term_id);
		}

		$term_group_result = json_encode(array(
			'html' => $tagsHTML,
			'htmlfilter' => $htmlFilter
		));
		die($term_group_result);
	}
}
/* ============== ListingPro Search Filter========== */
add_action('wp_ajax_ajax_search_tags', 'ajax_search_tags');
add_action('wp_ajax_nopriv_ajax_search_tags', 'ajax_search_tags');
if (!function_exists('ajax_search_tags')) {
    function ajax_search_tags()
    {
        global $listingpro_options;
				$info   = array('');
		$lporderby = 'date';
		$lporders = 'DESC';
		if( isset($listingpro_options['lp_archivepage_listingorder']) ){
			$lporders = $listingpro_options['lp_archivepage_listingorder'];
		}
		if( isset($listingpro_options['lp_archivepage_listingorderby']) ){
			$lporderby = $listingpro_options['lp_archivepage_listingorderby'];
		}
		
		if($lporderby=="rand"){
			$lporders = '';
		}
		
		$defSquery = '';
		$lpDefaultSearchBy = 'title';
		if( isset($listingpro_options['lp_default_search_by']) ){
			$lpDefaultSearchBy = $listingpro_options['lp_default_search_by'];
		}
		
		$pageno           = '';
        if (isset($_POST['pageno'])) {
            $pageno = $_POST['pageno'];
        }
		/* for version 2.0 */
		$formFieldsMetaArray = array();
		$formFieldsMetaArray['relation'] = 'AND';
		$lp_formFIelds = array();
		if (isset($_POST['formfields'])) {
			$lp_formFIelds = $_POST['formfields'];
			$info['formfields'] = $lp_formFIelds;
		}
		if (!empty($lp_formFIelds)) {
			foreach($lp_formFIelds as $lp_singleField) {
				$lp_singleField = trim($lp_singleField);
				if (!empty($lp_singleField)) {
					$formFieldsMetaArray[] = array('key' => 'lp_listingpro_options_fields', 'value' => "$lp_singleField", 'compare' => 'LIKE');
				}
			}
		}
		/* for radious filter */
		$sloc_address       = ( isset( $_POST[ 'sloc_address' ] ) ) ? $_POST[ 'sloc_address' ] : '';
		$my_bounds_ne_lat   = ( isset( $_POST[ 'my_bounds_ne_lat' ] ) ) ? $_POST[ 'my_bounds_ne_lat' ] : '';
		$my_bounds_ne_lng   = ( isset( $_POST[ 'my_bounds_ne_lng' ] ) ) ? $_POST[ 'my_bounds_ne_lng' ] : '';
		$my_bounds_sw_lat   = ( isset( $_POST[ 'my_bounds_sw_lat' ] ) ) ? $_POST[ 'my_bounds_sw_lat' ] : '';
		$my_bounds_sw_lng   = ( isset( $_POST[ 'my_bounds_sw_lng' ] ) ) ? $_POST[ 'my_bounds_sw_lng' ] : '';
		
		$units = $listingpro_options['lp_nearme_filter_param'];
		if(empty($units)){
			$units = 'km';
		}
	
		
		$squery = '';
		
		$latlongfilter = false;
		$latlongArray = array();
		$openNowArray = array();
		$clat = '';
		$clong = '';
		if(isset($_POST['clat'])){
			$clat = sanitize_text_field($_POST['clat']);
		}
		if(isset($_POST['clong'])){
			$clong = sanitize_text_field($_POST['clong']);
		}

        $info['tag_name']         = $_POST['tag_name'];
        $info['cat_id']           = sanitize_text_field($_POST['cat_id']);

	    if(isset($_POST['loc_id'])){

		    if( is_numeric($_POST['loc_id'] ) ){

			    $info['loc_id']    = ( $sloc_address != '' || $my_bounds_ne_lat != '' ) ? '': sanitize_text_field($_POST['loc_id']);

		    }

		    else{

			    $locTerm = get_term_by('name', $_POST['loc_id'], 'location');

			    if(!empty($locTerm)){

				    $loc_ID = $locTerm->term_id;

				    $info['loc_id']           = ( $sloc_address != '' || $my_bounds_ne_lat != '' ) ? '': $loc_ID;

			    }elseif(!empty($_POST['loc_id'])){

				    $info['loc_id'] = 1;

			    }

		    }

	    }
        
        $info['listStyle']        = sanitize_text_field($_POST['list_style']);
        $info['inexpensive']      = sanitize_text_field($_POST['inexpensive']);
        $info['moderate']         = sanitize_text_field($_POST['moderate']);
        $info['pricey']           = sanitize_text_field($_POST['pricey']);
        $info['ultra']            = sanitize_text_field($_POST['ultra']);
        $info['averageRate']      = sanitize_text_field($_POST['averageRate']);
        $info['mostRewvied']      = sanitize_text_field($_POST['mostRewvied']);
        $info['listing_openTime'] = sanitize_text_field($_POST['listing_openTime']);
        $info['mostviewed'] 	  = sanitize_text_field($_POST['mostviewed']);
        $info['lp_s_tag'] 	  	  = sanitize_text_field($_POST['lpstag']);
        $tagQuery                 = '';
        $catQuery                 = '';
        $searchtagQuery                 = '';
        $listing_time             = '';
		$opentimeswitch = false;
		$opentimefilter = false;
        $sFeatures                = '';
        $sFeatures                = $_POST['tag_name'];
        if (!empty($info['listing_openTime'])) {
            $listing_time = $info['listing_openTime'];
			$opentimeswitch = true;
        }
		global $paged;
        if (!empty($pageno)) {
            $paged = $pageno;
        }
        $priceQuery   = array();
        $categoryName = '';
        $LocationName = '';
        $locQuery     = '';
        $currentTax   = '';
        if (!empty($info['tag_name'])) {
            $tagQuery = array(
				'taxonomy' => 'features',
				'field' => 'id',
				'terms' => $info['tag_name'],
				'operator' => 'AND',
            );
        }
        if (!empty($info['cat_id'])) {
            $categoryName = get_term_by('id', $info['cat_id'], 'listing-category');
            $categoryName = $categoryName->name;
            $catQuery     = array(
                'taxonomy' => 'listing-category',
                'field' => 'id',
                'terms' => $info['cat_id']
            );
        }
        if (!empty($info['loc_id'])) {
            $LocationName = get_term_by('id', $info['loc_id'], 'location');
            $LocationName = $LocationName->name;
            $locQuery     = array(
                'taxonomy' => 'location',
                'field' => 'id',
                'terms' => $info['loc_id']
            );
        }
		
		if( !empty($info['lp_s_tag']) && isset($info['lp_s_tag'])){
			$lpsTag = $info['lp_s_tag'];
			$searchtagQuery = array(
				'taxonomy' => 'list-tags',
				'field' => 'id',
				'terms' => $lpsTag,
				'operator'=> 'IN' //Or 'AND' or 'NOT IN'
			);
		}
		
		if(isset($_POST['skeyword'])){
			if( (empty($info['lp_s_tag']) || !isset($info['lp_s_tag'])) && (empty($info['cat_id']) || !isset($info['cat_id'])) ){
				$squery     = sanitize_text_field($_POST['skeyword']);
				if(!empty($squery)){
					if( $lpDefaultSearchBy=="title" ){
						$squery     = sanitize_text_field($_POST['skeyword']);
						$defSquery = $squery;
					}
					else{
						$searchtagQuery = array(
							'taxonomy' => 'list-tags',
							'field' => 'name',
							'terms' => $squery,
							'operator'=> 'IN' //Or 'AND' or 'NOT IN'
						);
						$squery = '';
						$defSquery = $squery;
					}
				}
			}
		}
        /* added by zaheer on 13 march */
        $orderBy        = $lporderby;
		
        $rateArray      = '';
        $reviewedArray  = '';
        $viewedArray    = array();
        $statusArray    = array();
        $optenTimeArray = array();
        $lpcountwhile = 1;
        $relation       = 'OR';
        if (!empty($info['averageRate'])) {
            $orderBy   = 'meta_value_num';
            $rateArray = array(
                'key' => $info['averageRate'],
                'compare' => 'EXIST'
            );
			
			$lporders = '';
			
        }
		if (!empty($info['mostviewed'])) {
            $orderBy       = 'meta_value_num';
            $viewedArray = array(
                'key' => 'post_views_count',
				'value'   => '1',
                'compare' => '>='
            );
			$lporders = '';
        }
        if (!empty($info['mostRewvied'])) {
            $orderBy       = 'meta_value_num';
            $reviewedArray = array(
                'key' => $info['mostRewvied'],
                'compare' => 'EXIST'
            );
			$lporders = '';
        }
        if (!empty($info['inexpensive'])) {
            $inexArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'inexpensive',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['moderate'])) {
            $moderArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'moderate',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['pricey'])) {
            $pricyArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'pricey',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['ultra'])) {
            $ultrArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'ultra_high_end',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['inexpensive']) || !empty($info['moderate']) || !empty($info['pricey']) || !empty($info['ultra'])) {
            $statusArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'price_status',
                'compare' => 'LIKE'
            );
            $relation    = "AND";
        }
        if (!empty($info['inexpensive']) || !empty($info['moderate']) || !empty($info['pricey']) || !empty($info['ultra']) || !empty($info['averageRate']) || !empty($info['mostRewvied']) || !empty($info['mostviewed']) || !empty($info['formfields']) ) {
            $priceQuery = array(
                'relation' => $relation, // Optional, defaults to "AND"
                $statusArray,
                array(
                    'relation' => 'OR',
                    $inexArray,
                    $moderArray,
                    $pricyArray,
                    $ultrArray
                ),
                array(
                    'relation' => 'OR',
                    $rateArray,
                    $reviewedArray,
					$viewedArray
                ),
                $formFieldsMetaArray
            );
        }
		
		$listingperpage = '';
		if(isset($listingpro_options['listing_per_page']) && !empty($listingpro_options['listing_per_page'])){
			$listingperpage = $listingpro_options['listing_per_page'];
		}
		else{
			$listingperpage = 10;
		}
		
		/* if nearme is on */
		$listingperpageMain = '';
		if( (!empty($clat) && !empty($clong)) || $listing_time=="open" ){
			
			$listingperpageMain = -1;
			
		}else{
			$listingperpageMain = $listingperpage;
		}
		/* end if nearme is on */
		
        /* added by zaheer on 13 march */
        $searchQuery = '';
        $TxQuery     = array(
			$searchtagQuery,
            $tagQuery,
            $catQuery,
            $locQuery
        );
        if (empty($TxQuery)) {
            $TxQuery = array();
        }
        $ad_campaignsIDS = listingpro_get_campaigns_listing('lp_top_in_search_page_ads', true, $TxQuery, $searchQuery, $priceQuery, null, null, null);
        $type            = 'listing';
        $args            = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => $listingperpageMain,
            'paged' => $paged,
            's' => $squery,
            'post__not_in' => $ad_campaignsIDS,
            'orderby' => $orderBy,
			'order'   => $lporders,
            /* 'meta_key'  => $metaKey, */
            'meta_query' => $priceQuery,
            'tax_query' => array(
				$searchtagQuery,
                $tagQuery,
                $catQuery,
                $locQuery
            )
        );
		
		$lp_lat = '';
		$lp_lng = '';
		
        $my_query        = null;
        $output          = null;
        $result          = null;
        $found           = null;
        $my_query        = new WP_Query($args);
        $found           = $my_query->found_posts;
        $output .= '<div class="promoted-listings">';
        ob_start();
        $output .= listingpro_get_campaigns_listing('lp_top_in_search_page_ads', false, $TxQuery, $searchQuery, false, $s=null, $noOFListing=null, $ad_campaignsIDS);
        $output .= ob_get_contents();
        ob_end_clean();
		ob_flush();
        $output .= '</div>';
        if ($my_query->have_posts()) {
			/* $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
            if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
            {
				$htmlOutput .=  '<div class="map-view-list-container">';
			   while ($my_query->have_posts()):
				   $my_query->the_post();
				   ob_start();
				   get_template_part('mobile/listing-loop-app-view2');
				   $htmlOutput .= ob_get_contents();
				   ob_end_clean();
			   endwhile;
			   wp_reset_query();
			   $htmlOutput .=  '</div>';
			} */
            while ($my_query->have_posts()):
                $my_query->the_post();
				
				/* ///////radious filter starts//////// */
				$flag   = true;
				if ( (isset( $_POST[ 'sloc_address' ] ) && $_POST[ 'sloc_address' ] != '' ) || (!empty($clat) && !empty($clong))) {
					
					if(!empty($clat) && !empty($clong)){
						$my_bounds_ne_lat = $clat;
						$my_bounds_ne_lng = $clong;
						
						$my_bounds_sw_lat = $clat;
						$my_bounds_sw_lng = $clong;
					}
					
					$lp_lat = listing_get_metabox_by_ID('latitude', get_the_ID());
					$lp_lng = listing_get_metabox_by_ID('longitude', get_the_ID());

				  $lp_my_distance_range   = (int)$_POST[ 'distance_range' ];
				  $ne_distance       = haversineGreatCircleDistance( $lp_lat, $lp_lng, $my_bounds_ne_lat, $my_bounds_ne_lng );
				  $sw_distance       = haversineGreatCircleDistance( $lp_lat, $lp_lng, $my_bounds_sw_lat, $my_bounds_sw_lng );

				  $flag1   = ( $lp_my_distance_range >= $ne_distance || $lp_my_distance_range >= $sw_distance ) ? true : false;
				  if ( ! $flag1 ) {
					$flag   = $flag1;
				  }

					//$latlongfilter = true;
					
				}

				//Zoom Search
				$lp_data_zoom              = ( isset( $_POST[ 'data_zoom' ] ) ) ? $_POST[ 'data_zoom' ] : '';
				if ( ! $flag || $lp_data_zoom == 'yes' ) {
				  $flag2   = listingproc_inBounds($lp_lat, $lp_lng, $my_bounds_ne_lat, $my_bounds_ne_lng, $my_bounds_sw_lat, $my_bounds_sw_lng);
				  if ( ! $flag2 ) {
					continue;
				  }
				}
				/* ///////radious filter end//////// */
				
                if ($listing_time == 'open') {
                    $openStatus = listingpro_check_time(get_the_ID(), true);
                    if ($openStatus == 'open') {
						
						$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
						$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
						if( !empty($clat) && !empty($clong) ){
							if( !empty($this_lat) && !empty($this_long) ){
								$latlongfilter = true;
								$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
								if(!empty($calDistance['distance'])){
									$latlongArray[get_the_ID()] = $calDistance['distance'];
								}
							}
							
						}
						
						if($latlongfilter==false){
							$optenTimeArray[get_the_ID()] = get_the_ID();
							/* ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush(); */
						}
                        
                    }
                } else {
					$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
					$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
					if( !empty($clat) && !empty($clong) ){
						if( !empty($this_lat) && !empty($this_long) ){
							$latlongfilter = true;
							$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
							if(!empty($calDistance['distance'])){
								$latlongArray[get_the_ID()] = $calDistance['distance'];
							}
						}
						
					}
					if($latlongfilter==false){
						ob_start();
						global $listingpro_options;
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{
							get_template_part('mobile/listing-loop-app-view');
						}
						else
						{
							get_template_part('listing-loop');
						}							
						$htmlOutput .= ob_get_contents();
						ob_end_clean();
						ob_flush();
					}
                }
            endwhile;
            wp_reset_query();
			
			
			if($latlongfilter==true){
						$keysArrray = array();
						if(!empty($latlongArray)){
							asort($latlongArray);
							foreach ($latlongArray as $key=>$val){
								$keysArrray [] = $key;
							}
						}
						
						
					$argss            = array(
					'post_type' => $type,
					'posts_per_page' => $listingperpage,
					'paged' => $paged,
					'post__in' => $keysArrray,
					'orderby'        => 'post__in',
					'order'          => 'ASC'
					
					);
					$my_query        = null;
					$my_query        = new WP_Query($argss);
					$found           = $my_query->found_posts;
					 if ($my_query->have_posts()) {
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{ 
							$htmlOutput .=  '<div class="map-view-list-container">';
						   while ($my_query->have_posts()):
							   $my_query->the_post();
							   ob_start();
							   get_template_part('mobile/listing-loop-app-view2');
							   $htmlOutput .= ob_get_contents();
							   ob_end_clean();
						   endwhile;
						   wp_reset_query();
						   $htmlOutput .=  '</div>';
						}
						 
						while ($my_query->have_posts()):
							
							$my_query->the_post();
							$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
							$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
							
							$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
							
							if ( isset( $_POST[ 'sloc_address' ] ) && $_POST[ 'sloc_address' ] != '' ) {
							}else{
								if(!empty($calDistance['distance'])){
									$nearbydata= $calDistance['distance'].' '.$units;
									$htmlOutput .= '<div class="lp-nearby-dist-data" data-lpnearbydist = "'.$nearbydata.'"></div>';
								}
							}
							ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							if(!empty($calDistance['distance'])){
								//$htmlOutput.='</div>';
							}
							
						endwhile;
						wp_reset_query();
					 }
			}
			if( !empty($optenTimeArray) ){
						$keysArrray = array();
						if(!empty($optenTimeArray)){
							asort($optenTimeArray);
							foreach ($optenTimeArray as $key=>$val){
								$keysArrray [] = $key;
							}
						}
						
						
					$argss            = array(
					'post_type' => $type,
					'posts_per_page' => $listingperpage,
					'paged' => $paged,
					'post__in' => $keysArrray,
					'orderby'        => 'post__in',
					'order'          => 'ASC'
					
					);
					$my_query        = null;
					$my_query        = new WP_Query($argss);
					$found           = $my_query->found_posts;
					 if ($my_query->have_posts()) {
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{ 
							$htmlOutput .=  '<div class="map-view-list-container">';
						   while ($my_query->have_posts()):
							   $my_query->the_post();
							   ob_start();
							   get_template_part('mobile/listing-loop-app-view2');
							   $htmlOutput .= ob_get_contents();
							   ob_end_clean();
						   endwhile;
						   wp_reset_query();
						   $htmlOutput .=  '</div>';
						}
						 
						while ($my_query->have_posts()):
							
							$my_query->the_post();
							
							ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							
							
						endwhile;
						wp_reset_query();
					 }
			}
		
            if (empty($htmlOutput)) {
                $output .= '


						<div class="text-center margin-top-80 margin-bottom-80">


							<h2>' . esc_html__('No Results', 'listingpro') . '</h2>


							<p>' . esc_html__('Sorry! There are no listings matching your search.', 'listingpro') . '</p>


							<p>' . esc_html__('Try changing your search filters or ', 'listingpro') . '<a href="' . $currentURL . '">' . esc_html__('Reset Filter', 'listingpro') . '</a></p>


						</div>


						';
            } else {
                $output .= $htmlOutput;
            }
        } elseif (empty($ad_campaignsIDS)) {
            $output .= '


						<div class="text-center margin-top-80 margin-bottom-80">


							<h2>' . esc_html__('No Results', 'listingpro') . '</h2>


							<p>' . esc_html__('Sorry! There are no listings matching your search.', 'listingpro') . '</p>


							<p>' . esc_html__('Try changing your search filters or ', 'listingpro') . '<a href="' . $currentURL . '">' . esc_html__('Reset Filter', 'listingpro') . '</a></p>


						</div>


						';
        }
        if (($found > 0)) {
            $foundtext = 'Results';
        } else {
            $foundtext = 'Result';
        }
		if (!empty($htmlOutput)) {
			$output .= listingpro_load_more_filter($my_query, $pageno, $defSquery);
			/* if ($opentimeswitch==true) {
				if($opentimefilter==true){
					$output .= listingpro_load_more_filter($my_query, $pageno, $defSquery);
				}
			}
			else{
				$output .= listingpro_load_more_filter($my_query, $pageno, $defSquery);
			} */
		}
        $output            = utf8_encode($output);
        $term_group_result = json_encode(array(
            "foundtext" => $foundtext,
            "found" => $found,
            "tags" => $info['tag_name'],
            "cat" => $categoryName,
            "city" => $LocationName,
            "html" => $output,
            "opentime" => $listing_time,
            "dfdfdfdf" => $latlongArray,
			"latlongfilter" => $latlongfilter,
			"opentimefilter" => $opentimefilter,
        ));
        die($term_group_result);
    }
}
/* ddfd */
/* ============== ListingPro Home page========== */
add_action('wp_ajax_listingpro_suggested_search', 'listingpro_suggested_search');
add_action('wp_ajax_nopriv_listingpro_suggested_search', 'listingpro_suggested_search');
if (!function_exists('listingpro_suggested_search')) {
    function listingpro_suggested_search()
    {
        global $listingpro_options;
        $qString      = '';
        $qString      = sanitize_text_field($_POST['tagID']);
        $qString      = strtolower($qString);
        $output       = null;
        $TAGOutput    = null;
        $CATOutput    = null;
        $TagCatOutput = null;
        $TitleOutput  = null;
        $lpsearchMode = "titlematch";
        if( isset($listingpro_options['lp_what_field_algo']) ){
            if( !empty($listingpro_options['lp_what_field_algo']) && $listingpro_options['lp_what_field_algo']=="keyword" ){
                $lpsearchMode = "keyword";
            }
        }



        if (empty($qString)) {
            global $listingpro_options;
            $cats;
            $ucat       = array(
                'post_type' => 'listing',
                'hide_empty' => false,
                'orderby' => 'count',
                'order' => 'ASC',
                'parent' => 0
            );
            $catIcon    = '';
            $categories = get_terms('listing-category', $ucat);
            foreach ($categories as $cat) {
                $catIcon = listingpro_get_term_meta($cat->term_id, 'lp_category_image');
                if (!empty($catIcon)) {
                    $catIcon = '<img src="' . $catIcon . '" />';
                }
                $cats[$cat->term_id] = '<li class="lp-default-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
            }
            $output           = array(
                'tag' => '',
                'cats' => $cats,
                'tagsncats' => '',
                'titles' => '',
                'more' => ''
            );
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);

        }else{


            $excludeTitleFromSearch = 'no';
            if( isset($listingpro_options['lp_exclude_listingtitle_switcher']) ){
                if( !empty($listingpro_options['lp_exclude_listingtitle_switcher']) && $listingpro_options['lp_exclude_listingtitle_switcher']==1 ){
                    $excludeTitleFromSearch = 'yes';
                }
            }

            if($excludeTitleFromSearch=="yes"){

                /* for low servers resources */
                $argsTaxs = array(
                    'orderby'           => 'count',
                    'order'             => 'ASC',
                    'hide_empty'        => true,
                    'name__like'    => $qString
                );
                $tagTerms = get_terms('list-tags', $argsTaxs);
                $catTerms = get_terms('listing-category', $argsTaxs);

                if(!empty($tagTerms)){
                    foreach ($tagTerms as $tag) {

                        $tagTermMatch = false;
                        $tagTernName  = strtolower($tag->name);

                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$tagTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $tagTermMatch = true;
                            }

                        }else{
                            $tagTermMatch = strpos($tagTernName, $qString);
                        }

                        if ( $tagTermMatch !== false ) {
                            $TAGOutput[$tag->term_id]    = '<li class="lp-wrap-tags" data-tagid="' . $tag->term_id . '"><span class="lp-s-tag">' . $tag->name . '</span></li>';
                        }
                    }
                }

                if(!empty($catTerms)){

                    foreach ($catTerms as $cat) {
                        $catIcon = listingpro_get_term_meta($cat->term_id, 'lp_category_image');
                        if (!empty($catIcon)) {
                            $catIcon = '<img class="lp-s-caticon" src="' . $catIcon . '" />';
                        }

                        $catTermMatch = false;

                        $catTernName  = $cat->name;
                        $catTernName  = strtolower($catTernName);
                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$catTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $catTermMatch = true;
                            }

                        }else{
                            $catTermMatch = strpos($catTernName, $qString);
                        }

                        if ( $catTermMatch !== false ) {
                            $CATOutput[$cat->term_id] = '<li class="lp-wrap-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
                        }

                    }

                }



            }else{

                /* for server with good resources */
                $args     = array(
                    'posts_per_page' => 5, // Number of related posts to display.
                    'post_type' => 'listing',
                    'post_status' => 'publish',
                    's'	=>	$qString,
                );
                $my_query = new wp_query($args);
                if ($my_query->have_posts()) {
                    while ($my_query->have_posts()):
                        $my_query->the_post();

                        $locTerms = get_the_terms(get_the_ID(), 'location');
                        $tagTerms = get_the_terms(get_the_ID(), 'list-tags');
                        $catTerms = get_the_terms(get_the_ID(), 'listing-category');

                        $listThumb = '';
                        if (has_post_thumbnail()) {
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                            if (!empty($image[0])) {
                                $listThumb = "<img src='" . $image[0] . "' />
												";
                            } else {
                                $listThumb = '<img src="' . esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=50&h=50', 'listingpro') . '" alt="">';
                            }
                            $catIcon = listingpro_get_term_meta($catName->term_id, 'lp_category_image');
                            if (empty($catIcon)) {
                                $catIcon = listingpro_get_term_meta($parent, 'lp_category_image');
                            }
                        }

                        $machTitles = false;
                        $listTitle  = get_the_title();
                        $listTitle  = strtolower($listTitle);
                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$listTitle", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $machTitles = true;
                            }

                        }else{
                            $machTitles = strpos($listTitle, $qString);
                        }
                        if ($machTitles !== false) {
                            $TitleOutput[] = '<li class="lp-wrap-title" data-url="' . get_the_permalink() . '">' . $listThumb . '<span class="lp-s-title"><a href="' . get_the_permalink() . '">' . $listTitle . ' <span class="lp-loc">' . $locTerms[0]->name . '</span></a></span></li>';
                        }
                    endwhile;
                    wp_reset_postdata();
                }

                /* for category and tags */

                $argsTaxs = array(
                    'orderby'           => 'count',
                    'order'             => 'ASC',
                    'hide_empty'        => true,
                    'name__like'    => $qString
                );
                $tagTerms = get_terms('list-tags', $argsTaxs);
                $catTerms = get_terms('listing-category', $argsTaxs);

                if(!empty($tagTerms)){
                    foreach ($tagTerms as $tag) {

                        $tagTermMatch = false;
                        $tagTernName  = strtolower($tag->name);

                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$tagTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $tagTermMatch = true;
                            }

                        }else{
                            $tagTermMatch = strpos($tagTernName, $qString);
                        }

                        if ( $tagTermMatch !== false ) {
                            $TAGOutput[$tag->term_id]    = '<li class="lp-wrap-tags" data-tagid="' . $tag->term_id . '"><span class="lp-s-tag">' . $tag->name . '</span></li>';
                        }
                    }
                }

                if(!empty($catTerms)){

                    foreach ($catTerms as $cat) {
                        $catIcon = listingpro_get_term_meta($cat->term_id, 'lp_category_image');
                        if (!empty($catIcon)) {
                            $catIcon = '<img class="lp-s-caticon" src="' . $catIcon . '" />';
                        }

                        $catTermMatch = false;

                        $catTernName  = $cat->name;
                        $catTernName  = strtolower($catTernName);
                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$catTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $catTermMatch = true;
                            }

                        }else{
                            $catTermMatch = strpos($catTernName, $qString);
                        }

                        if ( $catTermMatch !== false ) {
                            $CATOutput[$cat->term_id] = '<li class="lp-wrap-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
                        }

                    }

                }

                /* **********for tags in cat********* */
                $TagstermIds = array_map(function (\WP_Term $term) {
                    return $term->term_id;
                }, get_terms([
                    'name__like' => $qString,
                ]));
                if(!empty($TagstermIds)){

                    $args     = array(
                        'posts_per_page' => 5, // Number of related posts to display.
                        'post_type' => 'listing',
                        'post_status' => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'list-tags',
                                'field'    => 'id',
                                'terms'    => $TagstermIds,
                            ),
                        ),
                    );
                    $my_query = null;
                    $my_query = new wp_query($args);
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()):
                            $my_query->the_post();

                            $tagTerms = get_the_terms(get_the_ID(), 'list-tags');
                            $catTerms = get_the_terms(get_the_ID(), 'listing-category');

                            if (!empty($catTerms) && !empty($tagTerms)) {
                                $catName = $catTerms[0];
                                $term_id = $catName->term_id;
                                $parent  = '';
                                if (!empty($term_id)) {
                                    $termparent = get_term_by('id', $term_id, 'listing-category');
                                    $parent     = $termparent->parent;
                                }
                                $catIcon = listingpro_get_term_meta($catName->term_id, 'lp_category_image');
                                if (empty($catIcon)) {
                                    $catIcon = listingpro_get_term_meta($parent, 'lp_category_image');
                                }
                                if (!empty($catIcon)) {
                                    $catIcon = '<img class="lp-s-caticon" src="' . $catIcon . '" />';
                                }
                                foreach ($tagTerms as $tag) {

                                    $tagTermMatch = false;
                                    $tagTernName  = strtolower($tag->name);

                                    if( $lpsearchMode == "keyword" ){
                                        preg_match("/[$qString]/", "$tagTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                                        $lpresCnt = count($lpMatches);
                                        if( $lpresCnt > 0 ){
                                            $tagTermMatch = true;
                                        }

                                    }else{
                                        $tagTermMatch = strpos($tagTernName, $qString);
                                    }

                                    if ( $tagTermMatch !== false ) {
                                        $TAGOutput[$tag->term_id]    = '<li class="lp-wrap-tags" data-tagid="' . $tag->term_id . '"><span class="lp-s-tag">' . $tag->name . '</span></li>';
                                        $TagCatOutput[] = '<li class="lp-wrap-catsntags" data-tagid="' . $tag->term_id . '" data-catid="' . $catName->term_id . '">' . $catIcon . '<span class="lp-s-tag">' . $tag->name . '</span><span> '.esc_html__('in', 'listingpro').' </span><span class="lp-s-cat">' . $catName->name . '</span></li>';
                                    }
                                }

                            }


                        endwhile;
                        wp_reset_postdata();
                    }
                }

                /* **********for tags in cat ends********* */




            }


            $TAGOutput    = array_unique($TAGOutput);
            $CATOutput    = array_unique($CATOutput);
            $TagCatOutput = array_unique($TagCatOutput);
            $TitleOutput  = array_unique($TitleOutput);
            if ((!empty($TAGOutput) && count($TAGOutput) > 0) || (!empty($CATOutput) && count($CATOutput) > 0) || (!empty($TagCatOutput) && count($TagCatOutput) > 0) || (!empty($TitleOutput) && count($TitleOutput) > 0)) {
                $output = array(
                    'tag' => $TAGOutput,
                    'cats' => $CATOutput,
                    'tagsncats' => $TagCatOutput,
                    'titles' => $TitleOutput,
                    'more' => '',
                    'matches' => $machTitles
                );
            } else {
                $moreResult = array();
                $mResults   = '<strong>' . esc_html__('More results for ', 'listingpro') . '</strong>';
                $mResults .= $qString;
                $moreResult[] = '<li class="lp-wrap-more-results" data-moreval="' . $qString . '">' . $mResults . '</li>';
                $output       = array(
                    'tag' => '',
                    'cats' => '',
                    'tagsncats' => '',
                    'titles' => '',
                    'more' => $moreResult
                );
            }
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);
        }
    }
}
/* ======================show cateogries on focus================ */
add_action('wp_ajax_listingpro_suggested_cats', 'listingpro_suggested_cats');
add_action('wp_ajax_nopriv_listingpro_suggested_cats', 'listingpro_suggested_cats');
if (!function_exists('listingpro_suggested_cats')) {
    function listingpro_suggested_cats()
    {
        global $listingpro_options;
        $cats;
        $homeSearchCategory = $listingpro_options['home_banner_search_cats'];
        $ucat               = array(
            'post_type' => 'listing',
            'hide_empty' => false,
            'orderby' => 'count',
            'order' => 'ASC',
            'include' => $homeSearchCategory
        );
        $categories         = get_terms('listing-category', $ucat);
        foreach ($categories as $category) {
            $cats[] = $category->name;
        }
        $query_suggestion = json_encode(array(
            "cats" => $cats
        ));
        die($query_suggestion);
    }
}
/* ======================show cateogries on focus================ */

	/* ============== ListingPro website visits ============ */
	
	add_action('wp_ajax_listingpro_website_visit',        'listingpro_website_visit');
	add_action('wp_ajax_nopriv_listingpro_website_visit', 'listingpro_website_visit');
	
	if (!function_exists('listingpro_website_visit')) {
		function listingpro_website_visit(){
			$lpCountry = '';
			$lpCity = '';
			$lpZip = '';
			$lp_id = '';
			$lp_id = $_POST['lp-id'];
			$lpCountry = $_POST['lp-country'];
			$lpCity = $_POST['lp-city'];
			$lpZip = $_POST['lp-zip'];
			$actor = esc_html__('Someone', 'listingpro');
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$actor = $current_user->user_login;
			}
			
			$visitorInfo = esc_html__('Country : ', 'listingpro');
			$visitorInfo .= $lpCountry;
			$visitorInfo .= esc_html__(' City : ', 'listingpro');
			$visitorInfo .= $lpCity;
			$visitorInfo .= esc_html__(' Zip : ', 'listingpro');
			$visitorInfo .= $lpZip;
			
			$listing_id = $lp_id;
			$listingData = get_post($listing_id);
			$authID = $listingData->post_author;
			//$currentdate = date("Y-m-d h:i:a");
			//$currentdate = date("d-m-Y h:i:a");
			$currentdate =  current_time('mysql');
			
			/* updating lead */
			$leadsCount = '';
			$leadsCount = get_user_meta( $authID, 'leads_count', true );
			if( isset($leadsCount) ){
				$leadsCount = (int)$leadsCount + 1;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			else{
				$leadsCount = 0;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			/*  */

			/* for stats chart */
			lp_set_this_stats_for_chart($authID, $listing_id, 'leads');
			/* stats chart ends */
			$activityData = array();
			$activityData = array( array(
				'type'	=>	'visit',
				'actor'	=>	$actor,
				'reviewer'	=>	$visitorInfo,
				'listing'	=>	$listing_id,
				'rating'	=>	'',
				'time'	=>	$currentdate
			));
			
			$updatedActivitiesData = array();
			$lp_recent_activities = get_option( 'lp_recent_activities' );
				if( $lp_recent_activities!=false ){
					
					$existingActivitiesData = get_option( 'lp_recent_activities' );
					if (array_key_exists($authID, $existingActivitiesData)) {
						$currenctActivityData = $existingActivitiesData[$authID];
						if(!empty($currenctActivityData)){
							if(count($currenctActivityData)>=20){
							$currenctActivityData =	array_slice($currenctActivityData,1,20);
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
							else{
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
						}
						$existingActivitiesData[$authID] = $updatedActivityData;
					}
					else{
						$existingActivitiesData[$authID] = $activityData;
					}
					$updatedActivitiesData = $existingActivitiesData;
				}
				else{
					$updatedActivitiesData[$authID] = $activityData;
				}
				update_option( 'lp_recent_activities', $updatedActivitiesData );
			
			
			
			$lp_response = json_encode(array("success"=>"ok"));
			die($lp_response);
		}
	}
/* ============== ListingPro phone number clicked ============ */
	
	add_action('wp_ajax_listingpro_phone_clicked',        'listingpro_phone_clicked');
	add_action('wp_ajax_nopriv_listingpro_phone_clicked', 'listingpro_phone_clicked');
	
	if (!function_exists('listingpro_phone_clicked')) {
		function listingpro_phone_clicked(){
			$lpCountry = '';
			$lpCity = '';
			$lpZip = '';
			$lp_id = '';
			$lp_id = $_POST['lp-id'];
			$lpCountry = $_POST['lp-country'];
			$lpCity = $_POST['lp-city'];
			$lpZip = $_POST['lp-zip'];
			$actor = esc_html__('Someone', 'listingpro');
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$actor = $current_user->user_login;
			}
			
			$visitorInfo = esc_html__('Country : ', 'listingpro');
			$visitorInfo .= $lpCountry;
			$visitorInfo .= esc_html__(' City : ', 'listingpro');
			$visitorInfo .= $lpCity;
			$visitorInfo .= esc_html__(' Zip : ', 'listingpro');
			$visitorInfo .= $lpZip;
			
			$listing_id = $lp_id;
			$listingData = get_post($listing_id);
			$authID = $listingData->post_author;
			//$currentdate = date("Y-m-d h:i:a");
			//$currentdate = date("d-m-Y h:i:a");
			$currentdate =  current_time('mysql');
			
			
			/* updating lead */
			$leadsCount = '';
			$leadsCount = get_user_meta( $authID, 'leads_count', true );
			if( isset($leadsCount) ){
				$leadsCount = (int)$leadsCount + 1;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			else{
				$leadsCount = 0;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			/*  */

			/* for stats chart */
				lp_set_this_stats_for_chart($authID, $listing_id, 'leads');
			/* stats chart ends */

			$activityData = array();
			$activityData = array( array(
				'type'	=>	'phone',
				'actor'	=>	$actor,
				'reviewer'	=>	$visitorInfo,
				'listing'	=>	$listing_id,
				'rating'	=>	'',
				'time'	=>	$currentdate
			));
			
			$updatedActivitiesData = array();
			$lp_recent_activities = get_option( 'lp_recent_activities' );
				if( $lp_recent_activities!=false ){
					
					$existingActivitiesData = get_option( 'lp_recent_activities' );
					if (array_key_exists($authID, $existingActivitiesData)) {
						$currenctActivityData = $existingActivitiesData[$authID];
						if(!empty($currenctActivityData)){
							if(count($currenctActivityData)>=20){
							$currenctActivityData =	array_slice($currenctActivityData,1,20);
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
							else{
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
						}
						$existingActivitiesData[$authID] = $updatedActivityData;
					}
					else{
						$existingActivitiesData[$authID] = $activityData;
					}
					$updatedActivitiesData = $existingActivitiesData;
				}
				else{
					$updatedActivitiesData[$authID] = $activityData;
				}
				update_option( 'lp_recent_activities', $updatedActivitiesData );
			
			
			
			$lp_response = json_encode(array("success"=>"ok"));
			die($lp_response);
		}
	}
	
	
if(!function_exists('listingproc_inBounds')){	
	function listingproc_inBounds($pointLat, $pointLong, $boundsNElat, $boundsNElong, $boundsSWlat, $boundsSWlong) {
		$eastBound = $pointLong < $boundsNElong;
		$westBound = $pointLong > $boundsSWlong;

		if ($boundsNElong < $boundsSWlong) {
			$inLong = $eastBound || $westBound;
		} else {
			$inLong = $eastBound && $westBound;
		}

		$inLat = $pointLat > $boundsSWlat && $pointLat < $boundsNElat;
		return $inLat && $inLong;
	}
}// listingproc_inBounds

if(!function_exists('haversineGreatCircleDistance')){
	
	function haversineGreatCircleDistance( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371){
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	  cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}
}

/* ============= Listingpro filter extra fields====== */

if(!function_exists('lp_get_extrafield_in_filterAjax')){
	function lp_get_extrafield_in_filterAjax($term_id){
		$output = null;
		ob_start();
		?>

		<div class="lp_all_page_overflow">
			<div class="col-md-12">

				<?php

				echo '<h2>'.esc_html__("More Option", "listingpro").'</h2>';
				/* multicheck on off */
				$getSwithButtonFieldsFilter = lp_get_extrafields_filter('checkbox', $term_id, false);
				if(!empty($getSwithButtonFieldsFilter)){
					?>
					<div class="lp_more_filter_data_section lp_extrafields_select">

						<?php
						echo '<ul class="filter_data_switch_on_off">';
						foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
							echo '
									<li>
										<label class="filter_checkbox_container">'.$fieldVal.'
											<input type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
											<span class="filter_checkbox_checkmark"></span>
										</label>
									</li>
								';
						}
						echo '</ul>';
						?>

					</div>
					<?php
				}
				/* checkbox */
				$getSwithButtonFieldsFilter = lp_get_extrafields_filter('check', $term_id, false);
				if(!empty($getSwithButtonFieldsFilter)){
					?>
					<div class="lp_more_filter_data_section lp_extrafields_select">

						<?php

						foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
							echo '<h3>' . $fieldVal . '</h3>';
							echo '<ul class="lp_filter_checkbox">';
							echo '
									<li>
										
										<label class="filter_checkbox_container">'.$fieldVal.'
											<input type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
											<span class="filter_checkbox_checkmark"></span>
										</label>
									</li>
								';
							echo '</ul>';
						}

						?>

					</div>
					<?php
				}

				?>
				<!-- for multicheck -->
				<?php
				$getExtraFieldsFilter = lp_get_extrafields_filter('checkboxes', $term_id, false);
				if(!empty($getExtraFieldsFilter)){

					?>
					<div class="lp_more_filter_data_section lp_extrafields_select">

						<?php
						foreach ($getExtraFieldsFilter as $fieldPostID => $fieldVal) {
							echo '<h3>' . $fieldVal . '</h3>';
							echo '<ul class="lp_filter_checkbox">';
							$getFieldsValue = listing_get_metabox_by_ID('multicheck-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);
										echo '
														<li>
															<label class="filter_checkbox_container">'.$optionVal.'
																<input type="checkbox" value="'.$optionVal.'" name="lp_extrafields_select[]">
																<span class="filter_checkbox_checkmark"></span>
															</label>
														</li>
													';
									}
								}
							}
							echo '</ul>';
						}
						?>

					</div>
				<?php } ?>

				<!-- for radio -->
				<?php
				$getRadioFieldsFilter = lp_get_extrafields_filter('radio', $term_id, false);
				if(!empty($getRadioFieldsFilter)){

					?>

					<div class="lp_more_filter_data_section lp_extrafields_select">
						<?php
						foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
							echo '<h3>' . $fieldVal . '</h3>';
							echo '<ul class="lp_filter_checkbox">';

							$getFieldsValue = listing_get_metabox_by_ID('radio-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);

										echo '
														<li>
															<label class="filter_radiobox_container">'.$optionVal.'
															  <input type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
															  <span class="filter_radio_select"></span>
															</label>
														</li>
													';
									}
								}
							}

							echo '</ul>';
						}
						?>

					</div>
					<?php
				}
				?>


				<!-- for Dropdown -->
				<?php
				$getRadioFieldsFilter = lp_get_extrafields_filter('select', $term_id, false);
				if(!empty($getRadioFieldsFilter)){

					?>

					<div class="lp_more_filter_data_section lp_extrafields_select">
						<?php
						foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
							echo '<h3>' . $fieldVal . '</h3>';
							echo '<ul class="lp_filter_checkbox">';

							$getFieldsValue = listing_get_metabox_by_ID('select-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);

										echo '
														<li>
															<label class="filter_radiobox_container">'.$optionVal.'
															  <input type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
															  <span class="filter_radio_select"></span>
															</label>
														</li>
													';
									}
								}
							}

							echo '</ul>';
						}
						?>

					</div>
					<?php
				}
				?>


				<div class="outer_filter_show_result_cancel">
					<div class="filter_show_result_cancel">
						<span id="filter_cancel_all"><?php echo esc_html__('Cancel', 'listingpro'); ?></span>

						<input id="filter_result" type="submit" value="<?php echo esc_html__('Show Results', 'listingpro'); ?>">

					</div>
				</div>

			</div>
		</div>

		<?php

		$output .= ob_get_contents();
		ob_end_clean();
		ob_flush();
		return $output;
	}
}


/* ==============Listingpro filter2 extraflds======= */
if(!function_exists('lp_gett_extrafield_in_filterAjax')){
	function lp_gett_extrafield_in_filterAjax($term_ID){
		$output = null;

		ob_start();
		?>

		<strong class="col-sm-2"><?php echo esc_html__( 'Other Filters', 'listingpro' ); ?></strong>
		<?php
		/* multicheck */
		$getExtraFieldsFilter = lp_get_extrafields_filter('checkboxes', $term_ID, false);
		if(!empty($getExtraFieldsFilter)){
			foreach ($getExtraFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>
							<?php
							$getFieldsValue = listing_get_metabox_by_ID('multicheck-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);
										?>
										<li>
											<div class="pad-bottom-10 checkbox ">
												<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $optionVal; ?>">
												<label><?php echo $optionVal; ?></label>
											</div>
										</li>
										<?php
									}
								}
							}
							?>
						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>

		<?php
		/* check */
		$getSwithButtonFieldsFilter = lp_get_extrafields_filter('check', $term_ID, false);
		if(!empty($getSwithButtonFieldsFilter)){
			foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>

							<li>
								<div class="pad-bottom-10 checkbox ">
									<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $fieldVal; ?>">
									<label><?php echo $fieldVal; ?></label>
								</div>
							</li>

						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>


		<?php
		/* checkbox */
		$getSwithButtonFieldsFilter = lp_get_extrafields_filter('checkbox', $term_ID, false);
		if(!empty($getSwithButtonFieldsFilter)){
			foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>

							<li>
								<div class="pad-bottom-10 checkbox ">
									<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $fieldVal; ?>">
									<label><?php echo $fieldVal; ?></label>
								</div>
							</li>

						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>



		<?php
		/* dropdown */
		$getSwithButtonFieldsFilter = lp_get_extrafields_filter('select', $term_ID, false);
		if(!empty($getSwithButtonFieldsFilter)){
			foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>

							<li>
								<div class="pad-bottom-10 checkbox ">
									<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $fieldVal; ?>">
									<label><?php echo $fieldVal; ?></label>
								</div>
							</li>

						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>


		<?php
		/* radio */
		$getRadioFieldsFilter = lp_get_extrafields_filter('radio', $term_ID, false);
		if(!empty($getRadioFieldsFilter)){
			foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>
							<?php
							$getFieldsValue = listing_get_metabox_by_ID('radio-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);
										?>
										<li>
											<div class="pad-bottom-10 checkbox ">
												<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $optionVal; ?>">
												<label><?php echo $optionVal; ?></label>
											</div>
										</li>
										<?php
									}
								}
							}
							?>
						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>



		<?php
		/* dropdown */
		$getRadioFieldsFilter = lp_get_extrafields_filter('select', $term_ID, false);
		if(!empty($getRadioFieldsFilter)){
			foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
				?>
				<div class="col-md-2">
					<div class="input-group margin-right-0">
						<strong><?php echo $fieldVal; ?></strong>
						<ul>
							<?php
							$getFieldsValue = listing_get_metabox_by_ID('select-options', $fieldPostID);
							if (!empty($getFieldsValue)) {
								$getFieldsArray = explode(",", $getFieldsValue);
								if (!empty($getFieldsArray)) {
									foreach ($getFieldsArray as $optionVal) {
										$optionVal = trim($optionVal);
										?>
										<li>
											<div class="pad-bottom-10 checkbox ">
												<input type="checkbox" name="lp_extrafields_select[]" class="searchtags" value="<?php echo $optionVal; ?>">
												<label><?php echo $optionVal; ?></label>
											</div>
										</li>
										<?php
									}
								}
							}
							?>
						</ul>
						<!--<a href="#" data-toggle="modal" data-target="#modal-extrafields"><?php //echo esc_html__( 'More..', 'listingpro' ); ?></a>-->

					</div>
				</div>
				<?php
			}
		}
		?>





		<div class="clearfix"></div>

		<?php
		$output .=ob_get_contents();
		ob_end_clean();
		ob_flush();
		return $output;
	}
}