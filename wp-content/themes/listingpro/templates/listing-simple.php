<?php

					$type = 'listing';
					$term_id = '';
					$taxName = '';
					$termID = '';
					$term_ID = '';
					global $paged, $listingpro_options;
					
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
					
					$taxTaxDisplay = true;
					$TxQuery = '';
					$tagQuery = '';
					$catQuery = '';
					$locQuery = '';
					$taxQuery = '';
					$searchQuery = '';
					$parent = '';
					$priceQuery = '';
					$sKeyword = '';
					$tagKeyword = '';
					$postsonpage = '';
					if(isset($listingpro_options['listing_per_page'])){
						$postsonpage = $listingpro_options['listing_per_page'];
					}
					else{
						$postsonpage = 9;
					}
					
					
					
					if( !empty($_GET['s']) && isset($_GET['s']) && $_GET['s']=="home" ){
						if( !empty($_GET['lp_s_tag']) && isset($_GET['lp_s_tag'])){
							$lpsTag = sanitize_text_field($_GET['lp_s_tag']);
							$tagQuery = array(
								'taxonomy' => 'list-tags',
								'field' => 'id',
								'terms' => $lpsTag,
								'operator'=> 'IN' //Or 'AND' or 'NOT IN'
							);
						}
						
						if( !empty($_GET['lp_s_cat']) && isset($_GET['lp_s_cat'])){
							$lpsCat = sanitize_text_field($_GET['lp_s_cat']);
							$termo = get_term_by('id', $lpsCat, 'listing-category');
							$parent = $termo->parent;
							$catQuery = array(
								'taxonomy' => 'listing-category',
								'field' => 'id',
								'terms' => $lpsCat,
								'operator'=> 'IN' //Or 'AND' or 'NOT IN'
							);
						}
						
						if( !empty($_GET['lp_s_loc']) && isset($_GET['lp_s_loc'])){							
							$lpsLoc = sanitize_text_field($_GET['lp_s_loc']);
							if(is_numeric($lpsLoc)){
								$lpsLoc = $lpsLoc;
							}
							else{
								$term = listingpro_term_exist($lpsLoc,'location');
								if(!empty($term)){
									$lpsLoc=$term['term_id'];
								}
								
								else{
									$lpsLoc = '';
								}
							}
							$locQuery = array(
								'taxonomy' => 'location',
								'field' => 'id',
								'terms' => $lpsLoc,
								'operator'=> 'IN' //Or 'AND' or 'NOT IN'
							);
						}
						/* on 3 april by zaheer */
						if( empty($_GET['lp_s_tag']) && empty($_GET['lp_s_cat']) && !empty($_GET['select']) ){
							
							if( $lpDefaultSearchBy=="title" ){
								$sKeyword = sanitize_text_field($_GET['select']);
								$defSquery = $sKeyword;
							}
							else{
							
								$sKeyword = sanitize_text_field($_GET['select']);
								$tagQuery = array(
									'taxonomy' => 'list-tags',
									'field' => 'name',
									'terms' => $sKeyword,
									'operator'=> 'IN' //Or 'AND' or 'NOT IN'
								);
								$sKeyword = '';
								$tagKeyword = sanitize_text_field($_GET['select']);
								$defSquery = $tagKeyword;
							}
							
						}
						/* end on 3 april by zaheer */
						$TxQuery = array(
							'relation' => 'AND',
							$tagQuery,
							$catQuery,
							$locQuery,
						);
					$ad_campaignsIDS = listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', TRUE,$taxQuery,$TxQuery,$priceQuery,$sKeyword, null, null);
					}
					else{
						$queried_object = get_queried_object();
						$term_id = $queried_object->term_id;
						$taxName = $queried_object->taxonomy;
						if(!empty($term_id)){
							$termID = get_term_by('id', $term_id, $taxName);
							$termName = $termID->name;
							$term_ID = $termID->term_id;
							$parent = $termID->parent;
						}
						
						$TxQuery = array(
							array(
								'taxonomy' => $taxName,
								'field' => 'id',
								'terms' => $termID->term_id,
								'operator'=> 'IN' //Or 'AND' or 'NOT IN'
							),
						);
					$ad_campaignsIDS = listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', TRUE, $TxQuery,$searchQuery,$priceQuery,$sKeyword, null, null );
					}


					
					$args=array(
						'post_type' => $type,
						'post_status' => 'publish',
						'posts_per_page' => $postsonpage,
						's'	=> $sKeyword,
						'paged'  => $paged,
						'post__not_in' =>$ad_campaignsIDS,
						'tax_query' => $TxQuery,
						'orderby' => $lporderby,
						'order'   => $lporders,
					);
					
					$my_query = null;
					$my_query = new WP_Query($args);
					$found = $my_query->found_posts;
					if(($found > 1)){
					$foundtext = esc_html__('Results', 'listingpro');
					}else{
						$foundtext = esc_html__('Result', 'listingpro');
					}
					// Harry Code

					$listing_layout = $listingpro_options['listing_views'];
					$addClassListing = '';
                    if($listing_layout == 'list_view' || $listing_layout == 'list_view3') {
						$addClassListing = 'listing_list_view';
					}
?>
		<!--==================================Section Open=================================-->
	<section>
        <?php
		$v2_map_class   =   '';
        if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' ):
            $header_style_v2   =    '';
			$v2_map_class       =   'v2-map-load';
            $layout_class      =    '';
            $listing_style = $listingpro_options['listing_style'];
            if( $listing_style == 4 )
            {
                $header_style_v2    =   'header-style-v2';
            }
            if( $listing_layout == 'list_view_v2' )
            {
                $layout_class   =   'list';
            }
            if( $listing_layout == 'grid_view_v2' )
            {
                $layout_class   =   'grid';
            }
        ?>
        <div data-layout-class="<?php echo $layout_class; ?>" id="list-grid-view-v2" class="swtch-ll <?php echo $header_style_v2; ?> <?php echo $v2_map_class; ?> <?php echo $listing_layout; ?>"></div>
        <?php endif; ?>
		<div class="container page-container listing-simple <?php echo esc_attr($addClassListing); ?>">
			<!-- archive adsense space before filter -->
			<?php do_action('lp_archive_adsense_before_filter'); ?>
			<div class="margin-bottom-20 margin-top-30 post-with-map-container-right">
				<?php get_template_part( 'templates/search/filter'); ?>
			</div>
			
			<div class="mobile-map-space">
			
					<!-- Popup Open -->
	
					<div class="md-modal md-effect-3 mobilemap" id="modal-listing">
						<div class="md-content mapbilemap-content">
							<div class="map-pop">							
								<div id='map' class="listingmap"></div>							
							</div>
						<a class="md-close mapbilemap-close"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<!-- Popup Close -->
					<div class="md-overlay md-overlayi"></div> <!-- Overlay for Popup -->
			</div>
			
			<div class="content-grids-wraps">
				<div class="row lp-list-page-grid" id="content-grids" >
                    <?php
                    if( $listing_layout == 'list_view_v2' )
                    {
                        echo '<div class="lp-listings list-style active-view">
                                    <div class="search-filter-response">
                                        <div class="lp-listings-inner-wrap">';
                    }
                    if( $listing_layout == 'grid_view_v2' )
                    {
                        echo '<div class="lp-listings grid-style active-view">
                                    <div class="search-filter-response">
                                        <div class="lp-listings-inner-wrap">';
                    }
                    ?>
					<div class="promoted-listings">
					
					<?php
						$array['features'] = '';
						if( !empty($_GET['s']) && isset($_GET['s']) && $_GET['s']=="home" ){
							echo listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', false,$taxQuery,$TxQuery,$priceQuery,$sKeyword, null, $ad_campaignsIDS);
						}else{
							echo listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', false, $TxQuery,$searchQuery,$priceQuery,$sKeyword, null, $ad_campaignsIDS);
						}
						?>
						<div class="md-overlay"></div>
					</div>
					<?php
						
						if( $my_query->have_posts() ) {
							while ($my_query->have_posts()) : $my_query->the_post();  
								get_template_part( 'listing-loop' );							
							endwhile;						
						}elseif(empty($ad_campaignsIDS)){
							?>						
								<div class="text-center margin-top-80 margin-bottom-80">
									<h2><?php esc_html_e('No Results','listingpro'); ?></h2>
									<p><?php esc_html_e('Sorry! There are no listings matching your search.','listingpro'); ?></p>
									<p><?php esc_html_e('Try changing your search filters or','listingpro'); ?>
									<?php
									$currentURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									?>
										<a href="<?php echo esc_url($currentURL); ?>"><?php esc_html_e('Reset Filter','listingpro'); ?></a>
									</p>
								</div>									
							<?php
						}	
						
					?>
					<div class="md-overlay"></div>
                    <?php
                    if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                    {
                        echo '    <div class="clearfix"></div></div>
				</div>
                              </div>';
                    }
                    ?></div>
					
			</div>
			<?php 
				echo '<div id="lp-pages-in-cats">';
				echo listingpro_load_more_filter($my_query, '1', $defSquery);
				echo '</div>';
			?>
			<div class="lp-pagination pagination lp-filter-pagination-ajx"></div>
			<input type="hidden" id="lp_current_query" value="<?php echo $defSquery ?>">
		</div>
		
	</section>
	<!--==================================Section Close=================================-->