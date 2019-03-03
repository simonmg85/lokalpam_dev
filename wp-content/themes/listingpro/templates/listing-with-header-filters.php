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
if($listing_layout == 'list_view') {
    $addClassListing = 'listing_list_view';
}
// Harry Code

$listing_layout = $listingpro_options['listing_views'];
$addClassListing = '';
if($listing_layout == 'list_view') {
    $addClassListing = 'listing_list_view';
}

$listing_style = $listingpro_options['listing_style'];

$listing_style_class    =   '';
if( $listing_style == 1 )
{
    $listing_style_class    =   'listing-simple';
}
if( $listing_style == 2 )
{
    $listing_style_class    =   'listing-with-sidebar';
}
if( $listing_style == 3 )
{
    $listing_style_class    =   'listing-with-map';
}
?>
<?php
$taxTaxDisplay = true;
if( !isset($_GET['s'])){
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $taxName = $queried_object->taxonomy;
    if(!empty($term_id)){
        $termID = get_term_by('id', $term_id, $taxName);
        $termName = $termID->name;
        $parent = $termID->parent;
        $term_ID = $termID->term_id;
        if(is_tax('location')){
            $loc_ID = $termID->term_id;
        }
        elseif(is_tax('features')){
            $feature_ID = $termID->term_id;
        }

        elseif(is_tax('list-tags')){
            $lpstag = $termID->name;
        }





    }
}elseif(isset($_GET['lp_s_cat']) || isset($_GET['lp_s_tag']) || isset($_GET['lp_s_loc'])){

    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat'])){
        $sterm = $_GET['lp_s_cat'];
        $term_ID = $_GET['lp_s_cat'];
        $termo = get_term_by('id', $sterm, 'listing-category');
        $termName = esc_html__('Results For','listingpro').' '.$termo->name;
        $parent = $termo->parent;
    }
    if(isset($_GET['lp_s_cat']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
        $lpstag = $sterm;
        $termo = get_term_by('id', $sterm, 'list-tags');
        $termName = esc_html__('Results For','listingpro').' '.$termo->name;
    }

    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
        $lpstag = $sterm;

        $termo = get_term_by('id', $sterm, 'list-tags');
        $termName = esc_html__('Results For','listingpro').' '.$termo->name;
    }

    if(isset($_GET['lp_s_loc']) && !empty($_GET['lp_s_loc'])){
        $sloc = $_GET['lp_s_loc'];
        $loc_ID = $_GET['lp_s_loc'];
        if(is_numeric($sloc)){
            $sloc = $sloc;
            $termo = get_term_by('id', $sloc, 'location');
            if(!empty($termo)){
                $locName = esc_html__('In ','listingpro').$termo->name;
            }
        }
        else{
            $checkTerm = listingpro_term_exist($sloc,'location');
            if(!empty($checkTerm)){
                $locTerm = get_term_by('name', $sloc, 'location');
                if( !empty($locTerm) ){
                    $loc_ID = $locTerm->term_id;
                    $locName = esc_html__('In ', 'listingpro').' '.$locTerm->name;
                }

            }
            else{
                $locName = esc_html__('In ', 'listingpro').' '.$sloc;
            }
        }

    }
}

$emptySearchTitle = '';
if( empty($_GET['lp_s_tag']) && isset($_GET['lp_s_tag']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_cat']) && empty($_GET['lp_s_loc']) && isset($_GET['lp_s_loc']) ){
    $emptySearchTitle = esc_html__('Most recent ', 'listingpro');
}
?>
<!--==================================Section Open=================================-->
<section class="lp-section listing-style4">
    <?php
    $v2_toggle  =   '';
    $listing_style = $listingpro_options['listing_style'];
    $listing_layoutt = $listingpro_options['listing_views'];
    if( $listing_layoutt == 'list_view_v2' || $listing_layoutt == 'grid_view_v2' || $listing_style == 4 ):
        $layout_class      =    '';
        if( $listing_layoutt == 'list_view_v2' || $listing_layoutt == 'grid_view_v2' )
        {
            $v2_toggle  =   'v2-toggle';
            if( $listing_layoutt == 'list_view_v2' )
            {
                $layout_class   =   'list';
            }
            if( $listing_layoutt == 'grid_view_v2' )
            {
                $layout_class   =   'grid';
            }
        }
        $sub_cats_loc   =   $listingpro_options['lp_listing_sub_cats_lcation'];
        ?>
        <div data-layout-class="<?php echo $layout_class; ?>" id="list-grid-view-v2" class="header-style-v2 <?php echo $listing_layoutt; ?>"></div>
    <?php endif; ?>
    <div class="container">

        <div class="row">
            <?php if($sub_cats_loc == 'fullwidth'): ?>
                <?php get_template_part( 'templates/child-cats' );  ?>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="lp-header-title">

                    <div class="row">
						
                        <div class="col-md-9">
						<?php $searchfilter = $listingpro_options['enable_search_filter'];
						if( !empty( $searchfilter ) && $searchfilter == '1' ){
						?>
                            <ul style="float:left" id="select-lp-more-filter" class="lp-sorting-filter-outer margin-top-10 filter-in-header">
                                <span><?php esc_html_e('Sort By:','listingpro'); ?></span>
								<?php
								$enable_high_rated_search_filter = $listingpro_options['enable_high_rated_search_filter'];
								if( !empty($enable_high_rated_search_filter ) && $enable_high_rated_search_filter == '1' ){
								?>
                                <li id="listingRate"><a data-value="listing_rate" class="rated-filter header-filter-wrap"><i class="fa fa-star-o" aria-hidden="true"></i> <?php esc_html_e('Highest Rated','listingpro'); ?></a></li>
								<?php
								}
								$enable_most_reviewed_search_filter = $listingpro_options['enable_most_reviewed_search_filter'];
								if( !empty($enable_most_reviewed_search_filter ) && $enable_most_reviewed_search_filter == '1' ){
								?>
                                <li id="listingReviewed"><a data-value="listing_reviewed" class="reviewed-filter header-filter-wrap"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php esc_html_e('Most Reviewed','listingpro'); ?></a></li>
								<?php
								}
								$enable_most_viewed_search_filter = $listingpro_options['enable_most_viewed_search_filter'];
								if( !empty($enable_most_viewed_search_filter ) && $enable_most_viewed_search_filter == '1' ){
								?>
                                <li id="mostviewed"><a data-value="mostviewed" class="viewed-filter header-filter-wrap"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('Most Viewed','listingpro'); ?></a></li>
								<?php
								}								
								?>
                            </ul>
							<?php
								
								if( !empty(lp_theme_option('enable_nearme_search_filter')) ){
									if( is_ssl() || in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))){
							
									$units = $listingpro_options['lp_nearme_filter_param'];
									if(empty($units)){
										$units = 'km';
									}
							?>
									<div id="lp-find-near-me" class="lp-tooltip-outer" style="line-height:" data-nearmeunit="<?php echo esc_attr($units); ?>">
										<a href="#" class="near-me-btn" style="line-height: 40px;"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo esc_html__('Near Me', 'listingpro'); ?></a>
										
										
										<div class="lp-tooltip-div-hidden">
											<div class="lp-tooltip-arrow"></div>
											<div class="lp-tool-tip-content clearfix lp-tooltip-outer-responsive">
												<?php
											
												$minRange = $listingpro_options['enable_readious_search_filter_min'];
												$maxRange = $listingpro_options['enable_readious_search_filter_max'];
												$defVal = 100;
												if(isset($listingpro_options['enable_readious_search_filter_default'])){
													$defVal = $listingpro_options['enable_readious_search_filter_default'];
												}
											 ?>
											<div class="location-filters location-filters-wrapper">
												
												<div id="pac-container" class="clearfix">
													<div class="clearfix row">
														<div class="lp-price-range-btnn col-md-1 text-right padding-0">
															<?php echo $minRange; ?>
														</div>
														 <div class="col-md-9" id="distance_range_div">
															<input id="distance_range" name="distance_range" type="text" data-slider-min="<?php echo $minRange; ?>" data-slider-max="<?php echo $maxRange; ?>" data-slider-step="1" data-slider-value="<?php echo $defVal ?>"/>
														 </div>
														 <div class="col-md-2 padding-0 text-left lp-price-range-btnn">
															<?php echo $maxRange; ?>
														</div>
														 <div style="display:none" class="col-md-4" id="distance_range_div_btn">
															<a href=""><?php echo esc_html__('New Location', 'listingpro'); ?></a>
														 </div>
													</div>
													<div class="col-md-12 padding-top-10" style="display:none" >
													  <input id="pac-input" name="pac-input" type="text" placeholder="<?php echo esc_html__('Enter a location', 'listingpro'); ?>" data-lat="" data-lng="" data-center-lat="" data-center-lng="" data-ne-lat="" data-ne-lng="" data-sw-lat="" data-sw-lng="" data-zoom="">
													</div>
												</div>
													
											</div>
											
											</div>

										</div>
										
										
									</div>
									<?php
									}
								}
								?>
							<?php } ?>
                        </div>
						
                        <div class="col-md-3">
                            <?php
                            $listing_view = $listingpro_options['listing_views'];
                            $active_list    =   '';
                            $active_grid    =   '';
                            if( $listing_view == 'list_view' || $listing_view == 'list_view3' || $listing_view == 'list_view_v2' )
                            {
                                $active_list    =   'active';
                            }
                            if( $listing_view != 'list_view' && $listing_view != 'list_view3' && $listing_view != 'list_view_v2' )
                            {
                                $active_grid    =   'active';
                            }
                            ?>
                            <div class="lp-header-togglesa text-right">

                                <div class="listing-view-layout listing-view-layout-v2">
                                    <ul>
                                        <li><a class="grid <?php echo $active_grid; ?>" href="#"><i class="fa fa-th-large"></i></a></li>
                                        <li><a class="list <?php echo $active_list; ?>" href="#"><i class="fa fa-list-ul"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
				<?php do_action('lp_archive_adsense_before_filter'); ?>
                </div>
                <div class="row">
                    <?php if($sub_cats_loc == 'content'): ?>
                        <?php get_template_part( 'templates/child-cats' );  ?>
                    <?php endif; ?>
                    <div class="listing-simple">

                        <div id="content-grids" class="listing-with-header-filters-wrap <?php echo $v2_toggle; ?>">
                            <?php
                            $campaign_layout    =   'grid';
                            if( $listing_layout == 'list_view_v2' )
                            {
                                $campaign_layout    =   'list';
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
                                    echo listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', false,$taxQuery,$TxQuery,$priceQuery,$sKeyword, 2, $ad_campaignsIDS);
                                }else{
                                    echo listingpro_get_campaigns_listing( 'lp_top_in_search_page_ads', false, $TxQuery,$searchQuery,$priceQuery,$sKeyword, null, $ad_campaignsIDS);
                                }
                           

                            ?>
							</div>
                            <?php
                            if( $my_query->have_posts() ):
                                global $listing_counter;
                                $listing_counter    =   1;
                                while ( $my_query->have_posts() ): $my_query->the_post();
                                    ?>
                                    <?php get_template_part( 'listing-loop' ); ?>
                                    <?php $listing_counter++; endwhile; wp_reset_postdata(); else: ?>
                                <div class="text-center margin-top-80 margin-bottom-80">
                                    <h2><?php esc_html_e('No Results','listingpro'); ?></h2>
                                    <p><?php esc_html_e('Sorry! You have not selected any list as favorite.','listingpro'); ?></p>
                                    <p><?php esc_html_e('Go and select lists as favorite','listingpro'); ?>
                                        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Visit Here','listingpro'); ?></a>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <?php
                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                            {
                                echo '    <div class="clearfix"></div></div>
                                </div>
                              </div>';
                            }
                            ?>


                        </div>
                    </div>
                    <?php
                    echo '<div id="lp-pages-in-cats">';
                    echo listingpro_load_more_filter($my_query, '1', $defSquery);
                    echo '</div>';
                    ?>
                    <input type="hidden" id="lp_current_query" value="<?php echo $defSquery ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="lp-sidebar">
                    <div class="widget lp-widget map-widget map-no-btns">
                        <?php
                        $v2_map_load_old    =   '';
                        if( $listing_view != 'list_view_v2' && $listing_view != 'grid_view_v2' )
                        {
                            $v2_map_load_old    =   'v2_map_load_old';
                        }
                        ?>
                        <div class="v2-map-load <?php echo $v2_map_load_old; ?>"></div>
                        <div class="map-pop">
                            <div id="map" class="mapSidebar"></div>
                        </div>
                    </div>
                    <?php
                    if( is_active_sidebar( 'listing_archive_sidebar' ) )
                    {
                        dynamic_sidebar( 'listing_archive_sidebar' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>