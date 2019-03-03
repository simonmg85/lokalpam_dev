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
$feature_ID = '';
$lpstag = '';
$locationID = '';
$catsOPT = '';
$searchfilter = '';
global $paged;
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
            $lpstag = $termID->term_id;
        }


    }
}elseif(isset($_GET['lp_s_cat']) || isset($_GET['lp_s_tag']) || isset($_GET['lp_s_loc'])){

    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat'])){
        $sterm = $_GET['lp_s_cat'];
        $term_ID = $_GET['lp_s_cat'];
        $termo = get_term_by('id', $sterm, 'listing-category');
        $termName = esc_html__('Results For','listingpro').' <strong class="term-name">'.$termo->name.'</strong>';
        $parent = $termo->parent;
    }
    if(isset($_GET['lp_s_cat']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
        $lpstag = $sterm;
        $termo = get_term_by('id', $sterm, 'list-tags');
        $termName = esc_html__('Results For','listingpro').' <strong>'.$termo->name.'</strong>';
    }

    if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
        $sterm = $_GET['lp_s_tag'];
        $lpstag = $sterm;

        $termo = get_term_by('id', $sterm, 'list-tags');
        $termName = esc_html__('Results For','listingpro').' <strong>'.$termo->name.'</strong>';
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
                    $locName = esc_html__('In ', 'listingpro').'<strong class="termloc-name">'.$locTerm->name.'<strong>';
                }

            }
            else{
                $locName = esc_html__('In ', 'listingpro').'<strong class="termloc-name">'.$sloc.'</strong>';
            }
        }

    }
}

$emptySearchTitle = '';
if( empty($_GET['lp_s_tag']) && isset($_GET['lp_s_tag']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_cat']) && empty($_GET['lp_s_loc']) && isset($_GET['lp_s_loc']) ){
    $emptySearchTitle = esc_html__('Most recent ', 'listingpro');
}
$lp_archive_bg  =   '';
$lparchiveBGCLass = '';
$emptyFIlter = '';
if( isset( $listingpro_options['lp_archive_bg']['url']) && !empty( $listingpro_options['lp_archive_bg']['url'] ) )
{
   $lp_archive_bg  =   $listingpro_options['lp_archive_bg']['url'];
   $lparchiveBGCLass = 'colorWhite';
}

		$searchfilter = $listingpro_options['enable_search_filter'];
		if( $searchfilter != '1' ){
			$emptyFIlter = 'empty-filter';
		}
	
?>
<div class="lp-archive-banner <?php echo $emptyFIlter; ?>" style="background-image: url(<?php echo $lp_archive_bg; ?>); ">
	<?php if(!empty($lp_archive_bg)){ ?>
    <div class="lp-header-overlay"></div>
	<?php } ?>
    <div class="lp-header-search archive-search">
        <div class="text-center lp-filter-top-text">
            <?php if(is_search()){ ?>
                <h4 class="lp-title <?php echo $lparchiveBGCLass; ?>"><?php echo $termName; ?> <?php echo $emptySearchTitle; ?><?php echo esc_html__( ' Listings', 'listingpro' );?> <?php echo $locName; ?></h4>

            <?php }else{ ?>
                <h4 class="lp-title <?php echo $lparchiveBGCLass; ?>"><?php echo esc_html__( 'Results For ', 'listingpro' );?> <em><?php echo $termName; ?></em><?php echo esc_html__( ' Listings', 'listingpro' );?> </h4>
            <?php } ?>
        </div>
		<?php 
		if( !empty( $searchfilter ) && $searchfilter == '1' ){
	?>
        <div class="container">
            <div class="row">
                <?php
                get_template_part( 'templates/headers/header-search' );
                ?>
            </div>
        </div>
        <?php
        get_template_part('templates/headers/filters-in-header');
        ?>
		<?php } ?>
    </div>
</div>
