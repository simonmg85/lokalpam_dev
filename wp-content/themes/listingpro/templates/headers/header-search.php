<?php
global $listingpro_options;
$type = 'listing';
$term_id = '';
$taxName = '';
$termID = '';
$term_ID = '';
$termName = '';
$sterm = '';
$sloc = '';
$termName = '';
$locName = '';
$catterm = '';
$parent = '';
$loc_ID = '';
$lpstag =   '';
$locationID = '';
global $paged;
$taxTaxDisplay = true;



$listCats=array();
$catIcon = '';
$defaultCats = null;
global $listingpro_options;
$search_placeholder = $listingpro_options['search_placeholder'];
$location_default_text = $listingpro_options['location_default_text'];
$home_srch_loc_switchr = $listingpro_options['home_search_loc_switcher'];
$search_loc_option = $listingpro_options['search_loc_option'];
$lp_what_field_switcher = $listingpro_options['lp_what_field_switcher'];
$search_loc_field_hide = $listingpro_options['lp_location_loc_switcher'];
$hideWhereClass = '';
$searchHide = '';
if(isset($search_loc_field_hide) && $search_loc_field_hide==1){
    $hideWhereClass = "hide-where";
    $searchHide = "search-hide";
} else {
    $searchHide = "";
}
$hideWhatClass = '';
$whatHide = '';
if(isset($lp_what_field_switcher) && $lp_what_field_switcher==1){
    $hideWhatClass = "hide-what";
    $whatHide = "what-hide";
} else {
    $whatHide = "";
}


$srchBr = '';
$slct = '';
if ( $home_srch_loc_switchr == true ) {
    $srchBr = 'ui-widget';
    $slct = 'select2';
}else {
    $srchBr = 'ui-widget border-dropdown';
    $slct = 'chosen-select5';
}

$locOption = '';
if ($search_loc_option == 'yes') {
    $locOption = 'yes';
}elseif ($search_loc_option == 'no') {
    $locOption = 'no';
}

$locations_search_type = $listingpro_options['lp_listing_search_locations_type'];
$locArea = '';
if(!empty($locations_search_type) && $locations_search_type=="auto_loc"){
    $locArea = $listingpro_options['lp_listing_search_locations_range'];
}

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
            $lpstag = $termID->term_id;
        }


    }
}
elseif(isset($_GET['lp_s_cat']) || isset($_GET['lp_s_tag']) || isset($_GET['lp_s_loc']))
{
    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat'])){
        $sterm = $_GET['lp_s_cat'];
        $term_ID = $_GET['lp_s_cat'];
        $termo = get_term_by('id', $sterm, 'listing-category');
        $parent = $termo->parent;
    }
    if(isset($_GET['lp_s_cat']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
    }

    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
    }

    if(isset($_GET['lp_s_loc']) && !empty($_GET['lp_s_loc'])){
        $loc_ID = $_GET['lp_s_loc'];
    }
}




?>
<div class="col-md-12">
    <div class="lp-search-bar lp-header-search-form text-center">
        <form autocomplete="off" class="form-inline" action="<?php echo home_url(); ?>" method="get" accept-charset="UTF-8">
			  <?php
            if( is_archive() || is_search() ):
            ?>
            <div class="select-filter" id="searchform">
                <i class="fa fa-list" aria-hidden="true"></i>
                <select class="chosen-select2" id="searchcategory">
                    <option value=""><?php echo esc_html__( 'All Categories', 'listingpro' );?></option>

                    <?php
                    $args = array(
                        'post_type' => 'listing',
                        'order' => 'ASC',
                        'hide_empty' => false,
                        'parent' => 0,
                    );
                    $locations = get_terms( 'listing-category',$args);
                    foreach($locations as $location) {
                        if($term_ID == $location->term_id){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                        echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
                        $sub = get_term_children( $location->term_id, 'listing-category' );
                        foreach ( $sub as $subID ) {
                            if($term_ID == $subID){
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            }
                            $term = get_term_by( 'id', $subID, 'listing-category' );
                            echo '<option '.$selected.' class="sub_cat" value="'.$term->term_id.'">-&nbsp;&nbsp;'.$term->name.'</option>';
                        }
                    }
                    ?>
                </select>
				
				<input type="hidden" name="clat">
				<input type="hidden" name="clong">
				
				
            </div>
            <?php endif; ?>
            <?php
            if( isset($lp_what_field_switcher) && $lp_what_field_switcher==0 ){
                ?>
                <div class="<?php if( is_archive() || is_search() ): ?>right-margin-20<?php endif; ?> form-group lp-suggested-search <?php echo esc_attr($hideWhereClass); ?> <?php echo esc_attr($hideWhatClass); ?>">
<?php
                    if( (isset($lp_what_field_switcher) && $lp_what_field_switcher==0) ||(isset($search_loc_field_hide) && $search_loc_field_hide==0) ){
                    if( ( is_archive() || is_search() ) && !wp_is_mobile() ){
                    ?>
                        <div class="form-group <?php echo esc_attr($searchHide); ?>">
                            <div class="lp-search-bar-right">
                                <a href="#" class="keyword-ajax">Go</a>
                                <!--
                                <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/images/searchloader.gif" class="searchloading">
                            -->
                            </div>
                        </div>
                    <?php } } ?>

                    <?php
                    if( ( is_archive() || is_search() ) && !wp_is_mobile() ) {
                        ?>
                        <div class="input-group-addon lp-border input-group-addon-keyword"><?php esc_html_e('Keyword', 'listingpro'); ?></div>
                        <div class="pos-relative">
                            <div class="what-placeholder pos-relative lp-search-form-what" data-holder="">
                                <input autocomplete="off" type="text"
                                       class="lp-suggested-search js-typeahead-input lp-search-input form-control ui-autocomplete-input dropdown_fields"
                                       name="select" id="skeyword-filter" placeholder="<?php echo $search_placeholder; ?>"
                                       data-prev-value='0'
                                       data-noresult="<?php echo esc_html__('More results for', 'listingpro'); ?>">
                                <i class="cross-search-q fa fa-times-circle" aria-hidden="true"></i>

                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="input-group-addon lp-border"><?php esc_html_e('What', 'listingpro'); ?></div>
                        <div class="pos-relative">
                            <div class="what-placeholder pos-relative lp-search-form-what" data-holder="">
                                <input autocomplete="off" type="text"
                                       class="lp-suggested-search js-typeahead-input lp-search-input form-control ui-autocomplete-input dropdown_fields"
                                       name="select" id="select" placeholder="<?php echo $search_placeholder; ?>"
                                       data-prev-value='0'
                                       data-noresult="<?php echo esc_html__('More results for', 'listingpro'); ?>">
                                <i class="cross-search-q fa fa-times-circle" aria-hidden="true"></i>
                                <img class='loadinerSearch' width="100px"
                                     src="<?php echo get_template_directory_uri() . '/assets/images/search-load.gif' ?>"/>

                            </div>
                            <div id="input-dropdown">
                                <ul>
                                    <?php

                                    $args = array(
                                        'post_type' => 'listing',
                                        'order' => 'ASC',
                                        'hide_empty' => false,
                                        'parent' => 0,
                                    );
                                    $default_search_cats = '';
                                    if (isset($listingpro_options['default_search_cats'])) {
                                        $default_search_cats = $listingpro_options['default_search_cats'];
                                    }
                                    if (empty($default_search_cats)) {
                                        $listCatTerms = get_terms('listing-category', $args);
                                        if (!empty($listCatTerms) && !is_wp_error($listCatTerms)) {
                                            foreach ($listCatTerms as $term) {
                                                $catIcon = listingpro_get_term_meta($term->term_id, 'lp_category_image');
                                                if (!empty($catIcon)) {
                                                    $catIcon = '<img class="d-icon" src="' . $catIcon . '" />';
                                                }
                                                echo '<li class="lp-wrap-cats" data-catid="' . $term->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $term->name . '</span></li>';

                                                $defaultCats .= '<li class="lp-wrap-cats" data-catid="' . $term->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $term->name . '</span></li>';


                                            }
                                        }
                                    } else {
                                        foreach ($default_search_cats as $catTermID) {
                                            $term = get_term_by('id', $catTermID, 'listing-category');
                                            $catIcon = listingpro_get_term_meta($term->term_id, 'lp_category_image');
                                            if (!empty($catIcon)) {
                                                $catIcon = '<img class="d-icon" src="' . $catIcon . '" />';
                                            }
                                            echo '<li class="lp-wrap-cats" data-catid="' . $term->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $term->name . '</span></li>';

                                            $defaultCats .= '<li class="lp-wrap-cats" data-catid="' . $term->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $term->name . '</span></li>';


                                        }
                                    }
                                    ?>

                                </ul>
                                <div style="display:none" id="def-cats"><?php echo $defaultCats; ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            <?php } ?>
          
            <?php
			if( isset($search_loc_field_hide) && $search_loc_field_hide==0 ){
                if( !empty($locations_search_type) && $locations_search_type=="auto_loc" )
                {
                    ?>
                    <div class="form-group lp-location-auto-fix lp-location-search <?php echo esc_attr($hideWhatClass); ?>">
                        <?php
                        if( ( is_archive() || is_search() ) && !wp_is_mobile() ){
                            ?>
                            <div class="input-group-addon lp-border lp-where"><?php esc_html_e('Location','listingpro'); ?></div>
                        <?php }else{ ?>
                            <div class="input-group-addon lp-border lp-where"><?php esc_html_e('Where','listingpro'); ?></div>
                        <?php } ?>
                        <div data-option="<?php echo esc_attr($locOption); ?>" class="<?php echo esc_attr($srchBr); ?>">
                            <i class="fa fa-crosshairs"></i>
                            <input autocomplete="off" id="cities" class="form-control" data-country="<?php echo $locArea; ?>" placeholder="<?php echo $location_default_text; ?>">
                            <input type="hidden" autocomplete="off" id="lp_search_loc" name="lp_s_loc">
                        </div>
                    </div>
                    <?php
                }
                elseif( !empty($locations_search_type) && $locations_search_type=="manual_loc" )
                {
                    ?>
                    <div class="form-group lp-location-search <?php echo esc_attr($hideWhatClass); ?>">
                        <?php
                        if( ( is_archive() || is_search() ) && !wp_is_mobile() ){
                            ?>
                            <div class="input-group-addon lp-border lp-where"><?php esc_html_e('Location','listingpro'); ?></div>
                        <?php }else{ ?>
                            <div class="input-group-addon lp-border lp-where"><?php esc_html_e('Where','listingpro'); ?></div>
                        <?php } ?>
                        <div data-option="<?php echo esc_attr($locOption); ?>" class="<?php echo esc_attr($srchBr); ?>">
                            <i class="fa fa-crosshairs"></i>
                            <?php
                            if( is_front_page() )
                            {
                            ?>
                            <select class="<?php echo esc_attr($slct); ?>" name="lp_s_loc" id="searchlocation">
                                <?php
                                }
                                else
                                {
                                ?>
                                <select class="<?php echo esc_attr($slct); ?>" name="lp_s_loc" id="searchlocation">
                                    <?php
                                    }
                                    ?>
                                    <option id="def_location" value=""><?php echo $location_default_text; ?></option>
                                    <?php
                                    $args = array(
                                        'post_type' => 'listing',
                                        'order' => 'ASC',
                                        'hide_empty' => false,
                                        'parent' => 0,
                                    );
                                    $locations = get_terms( 'location',$args);
                                    if ( ! empty( $locations ) && ! is_wp_error( $locations ) ){
                                        foreach($locations as $location) {
                                            if($loc_ID == $location->term_id){
                                                $selected = 'selected';
                                            }else{
                                                $selected = '';
                                            }
                                            echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
                                            $sub = get_term_children( $location->term_id, 'location' );
                                            foreach ( $sub as $subID ) {
                                                $locationTerm = get_term_by( 'id', $subID, 'location' );
                                                echo  '<option '.$selected.' class="sub_cat" value="'.$locationTerm->term_id.'">-&nbsp;&nbsp;'.$locationTerm->name.'</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                        </div>
                    </div>
                    <?php
                }
            }

            if( (isset($lp_what_field_switcher) && $lp_what_field_switcher==0) ||(isset($search_loc_field_hide) && $search_loc_field_hide==0) ){
                if( is_home() || is_front_page() || wp_is_mobile() ){

                ?>
                <div class="form-group <?php echo esc_attr($searchHide); ?>">
                    <div class="lp-search-bar-right">
                        <input value="" class="lp-search-btn lp-search-form-submit" type="submit">
                        <i class="icons8-search lp-search-icon"></i>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ellipsis.gif" class="searchloading">
                        <!--
										<img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/images/searchloader.gif" class="searchloading">
									-->
                    </div>
                </div>
            <?php } } ?>
            <input type="hidden" name="lp_s_tag" id="lp_s_tag" value="<?php echo $lpstag; ?>">
            <input type="hidden" name="lp_s_cat" id="lp_s_cat" value="<?php echo $term_ID; ?>">
            <input type="hidden" name="s" value="home">
            <input type="hidden" name="post_type" value="listing">

        </form>

    </div>
    <div class="clearfix"></div>
</div>
