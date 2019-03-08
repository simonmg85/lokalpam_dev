
<?php
$currencyCode = listingpro_currency_sign();
$showSpotlightAds = true;
$showSearchtopAds = true;
$showDetailpageAds = true;
$currencyPos = lp_theme_option('pricingplan_currency_position');
$taxPerfent = 0;
$taxRate = 0;
$taxPrice = 0;
$isTax = lp_theme_option('lp_tax_swtich');
if(!empty($isTax)){
    $taxPerfent = lp_theme_option('lp_tax_amount');
	$taxRate = $taxPerfent;
}
$spotOrgprice = '';
$detailOrgprice = '';
$searchOrgprice = '';
$selctedPackages = '';
$selctedduration = '';
$selctedAmount = '';
$selctedMethod = '';
$selectedClicks = '';
$selectedPaidAmount = '';
$selectedCredit = '';
$adsTypeval = '';
$typeofcampaign = lp_theme_option('listingpro_ads_campaign_style');
if($typeofcampaign=="adsperclick"){
    $adsTypeval = 'perclick';
    $prefixCPC = esc_html__('CPC', 'listingpro');

    $spotlightPrice = lp_theme_option('lp_random_ads_pc');
    $spotOrgprice = $spotlightPrice;
	
	if(!empty($isTax)){
		$spotpricePerPercent = $spotOrgprice/100;
		$spottaxPrice = $spotpricePerPercent*$taxRate;
		$spotOrgprice =  $spotOrgprice+$spottaxPrice;
	}
	$spotOrgprice = round($spotOrgprice,2);
	
    if($currencyPos=="right"){
        $spotlightPrice = $spotlightPrice.$currencyCode;
    }else{
        $spotlightPrice = $currencyCode.$spotlightPrice;
    }

    $spotlightPrice = $prefixCPC.' '.$spotlightPrice;

    $detailpageprice = lp_theme_option('lp_detail_page_ads_pc');
    $detailOrgprice = $detailpageprice;
	
	if(!empty($isTax)){
		$detailpricePerPercent = $detailOrgprice/100;
		$detailtaxPrice = $detailpricePerPercent*$taxRate;
		$detailOrgprice =  $detailOrgprice+$detailtaxPrice;
	}
	$detailOrgprice = round($detailOrgprice,2);
	
    if($currencyPos=="right"){
        $detailpageprice = $detailpageprice.$currencyCode;
    }else{
        $detailpageprice = $currencyCode.$detailpageprice;
    }
    $detailpageprice = $prefixCPC.' '.$detailpageprice;

    $searchpageprice = lp_theme_option('lp_top_in_search_page_ads_pc');
    $searchOrgprice = $searchpageprice;
	
	if(!empty($isTax)){
		$searchpricePerPercent = $searchOrgprice/100;
		$searchtaxPrice = $searchpricePerPercent*$taxRate;
		$searchOrgprice =  $searchOrgprice+$searchtaxPrice;
	}
	$searchOrgprice = round($searchOrgprice,2);
	
    if($currencyPos=="right"){
        $searchpageprice = $searchpageprice.$currencyCode;
    }else{
        $searchpageprice = $currencyCode.$searchpageprice;
    }
    $searchpageprice = $prefixCPC.' '.$searchpageprice;

}elseif($typeofcampaign=="adsperduration"){
    $adsTypeval = 'byduration';
	$prefixPD = esc_html__('/ day', 'listingpro');
    $spotlightPrice = lp_theme_option('lp_random_ads');
    $spotOrgprice = $spotlightPrice;
	if(!empty($isTax)){
		$spotpricePerPercent = $spotOrgprice/100;
		$spottaxPrice = $spotpricePerPercent*$taxRate;
		$spotOrgprice =  $spotOrgprice+$spottaxPrice;
	}
	//$spotOrgprice = round($spotOrgprice,2);
    if($currencyPos=="right"){
        $spotlightPrice = $spotlightPrice.$currencyCode;
    }else{
        $spotlightPrice = $currencyCode.$spotlightPrice;
    }
	$spotlightPrice = $spotlightPrice.' '.$prefixPD; 
    $detailpageprice = lp_theme_option('lp_detail_page_ads');
    $detailOrgprice = $detailpageprice;
	if(!empty($isTax)){
		$detailpricePerPercent = $detailOrgprice/100;
		$detailtaxPrice = $detailpricePerPercent*$taxRate;
		$detailOrgprice =  $detailOrgprice+$detailtaxPrice;
	}
	//$detailOrgprice = round($detailOrgprice,2);
    if($currencyPos=="right"){
        $detailpageprice = $detailpageprice.$currencyCode;
    }else{
        $detailpageprice = $currencyCode.$detailpageprice;
    }
	$detailpageprice = $detailpageprice.' '.$prefixPD;
    $searchpageprice = lp_theme_option('lp_top_in_search_page_ads');
    $searchOrgprice = $searchpageprice;
	
	if(!empty($isTax)){
		$searchpricePerPercent = $searchOrgprice/100;
		$searchtaxPrice = $searchpricePerPercent*$taxRate;
		$searchOrgprice =  $searchOrgprice+$searchtaxPrice;
	}
	//$searchOrgprice = round($searchOrgprice,2);
	
    if($currencyPos=="right"){
        $searchpageprice = $searchpageprice.$currencyCode;
    }else{
        $searchpageprice = $currencyCode.$searchpageprice;
    }
	$searchpageprice = $searchpageprice.' '.$prefixPD;
}

if(empty(lp_theme_option('lp_random_ads_switch'))){
    $showSpotlightAds = false;
}
if(empty(lp_theme_option('lp_detail_page_ads_switch'))){
    $showDetailpageAds = false;
}
if(empty(lp_theme_option('lp_top_in_search_page_ads_switch'))){
    $showSearchtopAds = false;
}

$showcampaingprocess = true;
if( empty($showSpotlightAds) && empty($showDetailpageAds) && empty($showSearchtopAds) ){
    $showcampaingprocess = false;
}
global $user_id;


$firstClickCOunt = '';
$firstAmount = '';
$firstCredit = '';


$showPaypal = lp_theme_option('enable_paypal');
$showStripe = lp_theme_option('enable_stripe');
$showWire = lp_theme_option('enable_wireTransfer');


global $wpdb;
        $dbprefix = $wpdb->prefix;
        $table = 'listing_campaigns';
        $table_name =$dbprefix.$table;
        $all_success = array();
        $data = '*';
        $condition = "status='success' AND user_id='$user_id'";
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            $all_success = lp_get_data_from_db($table, $data, $condition);
        }
		if(!empty($all_success)){
			$showAC = 0;
			foreach($all_success as $key=>$val){
				 $caID = $val->post_id;
				  if ( get_post_status ( $caID ) ) {
					  $showAC++;
				  }
			}
			if($showAC == 0){
				$all_success = '';
			}
		}
?>
<div class="tab-pane fade in active lp-new-ad-compaign" id="lp-listings">
<?php $ads_promo_url =get_template_directory_uri().'/include/paypal/form-handler2.php'; ?>
        <form id="lp-new-ad-compaignForm" method="POST" name="lp-new-ad-compaignForm" data-type="<?php echo $typeofcampaign; ?>" action="<?php echo esc_url($ads_promo_url); ?>">
<?php
	$classcols = '9';
	if($typeofcampaign!="adsperclick" && !empty($all_success)){
		$classcols = '9';
	}
?>
    <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-<?php echo $classcols;?> lp-left-panel-height">

       
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <?php
                if(!empty($all_success)){
                    ?>
                    <li class="active"><a href="#tab1default" data-toggle="tab"><?php esc_html_e('All Campaigns','listingpro'); ?></a></li>
                    <?php
                }
                ?>

                <?php
                if(!empty($showcampaingprocess) && !empty($all_success)){
                    ?>
                    <button type="button" class="lp-add-new-btn" data-toggle="modal" data-target="#modal-lp-submit-ad"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php echo esc_html__('Add new ad','listingpro'); ?></button>
                    <?php
                }
                ?>

            </ul>
        </div>
        <?php
        if(!empty($all_success)){
            ?>
            <div class="panel-body lp-new-packages" id="lp-new-invoices">
                <div class="lp-main-title clearfix">
                    <div class="col-md-3"><p><?php esc_html_e('Title','listingpro'); ?></p></div>
                    <div class="col-md-3"><p><?php esc_html_e('trans id','listingpro'); ?></p></div>
                    <div class="col-md-3"><p><?php esc_html_e('trans date','listingpro'); ?></p></div>
                    <div class="col-md-3 text-right"><p><?php esc_html_e('status','listingpro'); ?></p></div>
                </div>
                <div class="tab-content clearfix">
                    <!--1-->
                    <div class="tab-pane fade in active" id="tab1default">

                        <?php
                        $ncount = 1;
                        foreach($all_success as $key=>$val){

                            

                            $caID = $val->post_id;

                            $adID = $caID;

                            $pmethod = $val->payment_method;

                            if($pmethod=="wire"){

                                $irddf = get_post_meta($caID, 'campaign_id', true);

                                if(!empty($irddf)){

                                    $adID = get_post_meta($caID, 'campaign_id', true);

                                }

                            }

                            $listingTID = listing_get_metabox_by_ID('campaign_id', $adID);

                            if(!empty($listingTID)){

                                $listingTtitle = get_the_title($listingTID);

                            }else{

                                $listingTID = listing_get_metabox_by_ID('ads_listing', $adID);

                                $listingTtitle = get_the_title($listingTID);

                            }

                            

                            $dbcurrency = $val->currency;

                            $dbmethod = esc_html__('Payment Method : ', 'listingpro');

                            $dbmethod .= '<span>'.$val->payment_method.'</span>';

                            

                            $listing_id = listing_get_metabox_by_ID('ads_listing', $adID);

                            $clicks = listing_get_metabox_by_ID('click_performed', $adID);

                            $budget = listing_get_metabox_by_ID('budget', $adID);

                            $remaining_balance = listing_get_metabox_by_ID('remaining_balance', $adID);

                            $active_packages = listing_get_metabox_by_ID('ad_type', $adID);

                            $duration = listing_get_metabox_by_ID('duration', $adID);

                            

                            

                            if(empty($clicks)){

                                $clicks = esc_html__('No', 'click');

                            }

                            

                            

                            if(!empty($caID)){

                                if ( get_post_status ( $caID ) ) {

                                    // do stuff

                                    $thisInvAtts = '';

                                    

                                    if(!empty($clicks)){

                                    $thisInvAtts .= "data-clicks=\"$clicks\"";

                                    }

                                    if(!empty($typeofcampaign)){

                                        $thisInvAtts .= " data-mode= \"$typeofcampaign\"";

                                    }

                                    if(!empty($budget)){

                                        if($typeofcampaign=="adsperclick"){

                                            $thisInvAtts .= " data-budget= \"$budget\"";

                                        }else{

                                            $budget = esc_html__('Amount Paid : ', 'listingpro').'<span>'.$budget.$dbcurrency .'</span>';

                                            $thisInvAtts .= " data-budget= \"$budget\"";

                                        }

                                    }

                                    if(!empty($remaining_balance)){

                                        $thisInvAtts .= " data-credit= \"$remaining_balance\"";

                                    }

                                    $durationHTML = '';

                                    if(!empty($duration)){

                                        $durationHTML = esc_html__('Ad Duration : ', 'listingpro').'<span>'.$duration.' '.esc_html__('Days', 'listingpro').'</span>';

                                        $thisInvAtts .= " data-duration= \"$durationHTML\"";

                                    }

                                    

                                    $thisInvAtts .= " data-currency= \"$dbcurrency\"";

                                    $thisInvAtts .= " data-method= \"$dbmethod\"";

                                    if(!empty($active_packages)){

                                        $typetitle = '';

                                        $hasPackage = false;

                                        foreach($active_packages as $key=>$singlePackage){

                                            if($singlePackage=="lp_random_ads"){

                                                $typetitle = "<i class='fa fa-check-circle'></i>";

                                                $typetitle .= '<span>'.esc_html__("Spotlight", "listingpro").'</span>';

                                            }elseif($singlePackage=="lp_detail_page_ads"){

                                                $typetitle = "<i class='fa fa-check-circle'></i>";

                                                $typetitle .= '<span>'.esc_html__("Sidebar", "listingpro").'</span>';

                                            }elseif($singlePackage=="lp_top_in_search_page_ads"){

                                                $typetitle = "<i class='fa fa-check-circle'></i>";

                                                $typetitle .= '<span>'.esc_html__("Top of Search", "listingpro").'</span>';

                                            }

                                            $thisInvAtts .= "data-packeg$key=\"$typetitle\"";

                                            if($ncount==1){

                                                $selctedPackages .= '<li>'.$typetitle.'</li>';

                                            }

                                        }

                                        

                                    }

                                    $checkedButton = '';

                                    if($ncount==1){

                                        $selctedduration = '';

                                        if(!empty($durationHTML)){

                                            $selctedduration = '<h5>'.$durationHTML.'</h5>';

                                        }

                                        if(!empty($budget)){

                                            $selctedAmount = '<h5>'.$budget.'</h5>';

                                        }

                                        if(!empty($dbmethod)){

                                            $selctedMethod = '<h5>'.$dbmethod.'</h5>';

                                        }

                                        $checkedButton = 'checked';

                                        

                                        $selectedClicks = $clicks;

                                        $selectedPaidAmount = $budget;

                                        $selectedCredit = $remaining_balance;

                                    }



                                    ?>

                                    <div <?php echo $thisInvAtts;?> class="lp-listing-outer-container clearfix <?php echo $listingTID; ?>">

                                        <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Type','listingpro'); ?>">

                                            <div class="lp-invoice-number lp-listing-form">

                                                

                                                <label>

                                                    <p>

                                                        <a target="_blank" href="<?php echo get_the_permalink($listingTID); ?>" title = "<?php echo $listingTtitle; ?>"><?php echo substr($listingTtitle,0, 20); ?></a>

                                                    </p>

                                                    

                                                    <?php

                                                        //if($typeofcampaign=="adsperclick"){

                                                            ?>

                                                            <div class="radio radio-danger">

                                                                <input class="radio_checked" type="radio" name="ads_invc" id="<?php echo $adID; ?>" value="<?php echo $adID; ?>" <?php echo $checkedButton; ?>>

                                                                <label for="">



                                                                </label>

                                                            </div>

                                                            <?php

                                                        //}

                                                        ?>

                                                    

                                                </label>



                                            </div>

                                        </div>

                                        <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Trans ID','listingpro'); ?>">

                                            <div class="lp-invoice-date">

                                                <p><?php $transID = $val->transaction_id;

                                                    $transID = substr($transID,0, 15);
													if(empty($transID)){
														$transID = esc_html__('N/A', 'listingpro');
													}

                                                    echo $transID;

                                                    ?></p>

                                            </div>

                                        </div>

                                        <div class="col-md-3 lp-content-before-after" data-content="<?php esc_html_e('Trans Date','listingpro'); ?>">

                                            <div class="lp-invoice-date">

                                                <p><?php echo get_the_time(get_option('date_format'), $adID); ?></p>

                                            </div>

                                        </div>



                                        <div class="col-md-3 text-right lp-content-before-after" data-content="<?php esc_html_e('Status','listingpro'); ?>">

                                            <div class="lp-invoice-price clerarfix lp-active-plan-btn lp-plane-btn">



                                                <a> <?php esc_html_e('Active','listingpro'); ?></a>

                                            </div>

                                        </div>

                                    </div>

                                    <?php

                                }

                            }

                            

                            $ncount++;



                        }

                        ?>

                    </div>
                   
                </div>
            </div>
            <?php
        }else{
        ?>
		
		 <div class="lp-blank-section" style="min-height:inherit">
            <div class="col-md-12 blank-left-side">
                <img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
					<h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
					<p class="margin-bottom-20"><?php echo esc_html__('You must be here for the first time. If you like to add some thing, click the button below.', 'listingpro'); ?></p>
				
				<button type="button" class="lp-add-new-btn lp-add-new-btn add-new-open-form" data-toggle="modal" data-target="#modal-lp-submit-ad"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php echo esc_html__('Add new ad','listingpro'); ?></button>
            </div>
        </div>
		
		<?php } ?>

        <!-- campaigns step code-->
        
            <div class="lp-ad-step-two margin-top-20">
                <div class="lp-add-menu-outer clearfix">
                    <h5><?php esc_html_e('Create Ad Campaign','listingpro'); ?></h5>

                </div>
                <div class="panel-body margin-bottom-30">
                    <div class="lp-listing-selecter clearfix background-white">

                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-content margin-top-18">
                                <h5><?php esc_html_e('Select a Listing','listingpro'); ?></h5>
                                <p><?php esc_html_e('','listingpro'); ?></p>
                            </div>

                        </div>
                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-drop">
                                <select class="form-control select2-ajaxx lp-search-listing-camp" name="lp_ads_for_listing" id="">
                                    <option value="0"><?php echo esc_html__('Select Listing', 'listingpro'); ?></option>
                                </select>
                            </div>

                        </div>



                    </div>
                    <div class="lp-listing-selecter clearfix background-white">

                        <div class="form-group col-sm-12 lp-ad-step-two-inner">
                            <div class="lp-listing-selecter-content margin-bottom-20">
                                <h5><?php esc_html_e('Select all Placement','listingpro'); ?></h5>
                                <p><?php esc_html_e(' ','listingpro'); ?></p>
                            </div>
                            <div class="row">
                                <?php
                                if( !empty($showSpotlightAds)){
                                    $previewURL = get_template_directory_uri().'/assets/images/preview1.jpg';
                                    $campaigns_name = esc_html__('Spotlight', 'listingpro');
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="lp-select-ad">
                                            <div class="lp-select-top input-group margin-right-0 clearfix">
                                                <div class="pad-bottom-10 checkbox ">
                                                    <input data-title="<?php echo $campaigns_name; ?>" data-price="<?php echo $spotOrgprice; ?>" data-preview="<?php echo $previewURL; ?>" type="checkbox" name="lpadsoftype[]" class="searchtags" value="lp_random_ads">
                                                    <label for="<?php echo $spotOrgprice; ?>"></label>
                                                </div>
                                            </div>
                                            <div class="lp-ad-location-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/spotlight.png" />
                                            </div>
                                            <div class="lp-ad-price-content text-center">
                                                <h5><?php echo esc_html__('Spotlight', 'listingpro'); ?></h5>
                                                <p>   </p>
                                                <button type="button" type="button"><?php echo $spotlightPrice; ?></button>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                }
                                if( !empty($showSearchtopAds)){
                                    $previewURL = get_template_directory_uri().'/assets/images/preview1.jpg';
                                    $campaigns_name = esc_html__('Top Of Search', 'listingpro');
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="lp-select-ad">
                                            <div class="lp-select-top input-group margin-right-0 clearfix">
                                                <div class="pad-bottom-10 checkbox ">
                                                    <input data-title="<?php echo $campaigns_name; ?>" data-price="<?php echo $searchOrgprice; ?>" data-preview="<?php echo $previewURL; ?>" type="checkbox" name="lpadsoftype[]" class="searchtags" value="lp_top_in_search_page_ads">
                                                    <label for="<?php echo $searchOrgprice; ?>"></label>
                                                </div>
                                            </div>
                                            <div class="lp-ad-location-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/topofsearch.png" />
                                            </div>
                                            <div class="lp-ad-price-content text-center">
                                                <h5><?php echo esc_html__('Top of Search', 'listingpro'); ?></h5>
                                                <p>   </p>
                                                <button  type="button"><?php echo $searchpageprice; ?></button>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                }
                                if( !empty($showDetailpageAds) ){
                                    $previewURL = get_template_directory_uri().'/assets/images/preview1.jpg';
                                    $campaigns_name = esc_html__('Sidebar', 'listingpro');
                                    ?>

                                    <div class="col-sm-4">
                                        <div class="lp-select-ad">
                                            <div class="lp-select-top input-group margin-right-0 clearfix">
                                                <div class="pad-bottom-10 checkbox ">
                                                    <input data-title="<?php echo $campaigns_name; ?>" data-price="<?php echo $detailOrgprice; ?>" data-preview="<?php echo $previewURL; ?>" type="checkbox" name="lpadsoftype[]" class="searchtags" value="lp_detail_page_ads">
                                                    <label for="<?php echo $detailOrgprice; ?>"></label>
                                                </div>
                                            </div>
                                            <div class="lp-ad-location-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/listingsidebar.png" />
                                            </div>
                                            <div class="lp-ad-price-content text-center">
                                                <h5><?php echo esc_html__('Sidebar', 'listingpro'); ?></h5>
                                                <p>   </p>
                                                <button type="button"><?php echo $detailpageprice; ?></button>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                }
                                ?>


                            </div>
                        </div>


                    </div>
                    <div class="lp-listing-selecter clearfix background-white">
                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-content margin-top-18">
                                <?php
                                if($typeofcampaign=="adsperduration"){
                                    ?>
                                    <h5><?php esc_html_e('Set ad Duration in Days','listingpro'); ?></h5>
                                    <?php
                                }elseif($typeofcampaign=="adsperclick"){ ?>
                                    <h5><?php esc_html_e('Set your budget','listingpro'); ?></h5>
                                <?php }?>

                                <p><?php esc_html_e('','listingpro'); ?></p>
                            </div>

                        </div>
                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-drop">
                                <?php
                                if($typeofcampaign=="adsperduration"){
                                    ?>
                                    <input name="adsduration_pd" autocomplete="off" type="text" class="lp-search-listing" name="select" id="" placeholder="20">
                                    <?php
                                }elseif($typeofcampaign=="adsperclick"){ ?>
                                    <input name="adsprice_pc" autocomplete="off" type="text" class="lp-search-listing" name="select" id="" placeholder="100">
                                <?php }?>
                            </div>

                        </div>
                    </div>
                </div>

				<?php
					if ( !wp_is_mobile() ) {
						?>
					<div class="lp-menu-save-btns clearfix">
						<button class="lp-cancle-btn"><?php echo esc_html__('Cancel', 'listingpro'); ?></button>
						<button type="button" class="lp-save-btn lp_campaign_paynow startpayforcampaignsss" disabled><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo esc_html__('Pay Now', 'listingpro'); ?></button>
					</div>
					<?php
					}
				?>
            </div>
            <?php
            $currency = lp_theme_option('currency_paid_submission');
            if($typeofcampaign=="adsperduration"){
                ?>
                <input type="hidden" name="ads_days" value="0">
                <?php
            }
            $taxRate = '';
            if(!empty(lp_theme_option('lp_tax_swtich'))){
                $taxRate = lp_theme_option('lp_tax_amount');
            }
            ?>
            <input type="hidden" name="ads_price" value="0">
            <input type="hidden" name="adsTypeval" value="<?php echo $adsTypeval; ?>">
            <input type="hidden" name="currency" value="<?php echo $currency; ?>">
            <input type="hidden" name="lp_ads_title" value="<?php echo esc_html__('Campaign Payment', 'listingpro'); ?>">
            <input type="hidden" name="taxprice" value="<?php echo $taxRate; ?>">
            <input type="hidden" name="func" value="start ads">
            <input type="hidden" name="method">
       
    </div>
    <div class="col-md-3 lp-right-panel-height">
	
       <?php

        if(!empty($all_success)){

        ?>

                <div class=" padding-right-0">

                    <div class="lp-ad-click-outer lp_selected_active_ad">

                        <div class="lp-general-section-title-outer">

                            

                            <?php

                                if($typeofcampaign=="adsperclick"){

                                    ?>

                                <div class="lp-ad-click-inner" id="lp-ad-click-inner">

                                    <div class="lp-ad-details-outer">

                                        <div class="lp-total-clicks">

                                            <div class="lp-total-clicks-inner">

                                                <?php

                                                if(empty($selectedClicks)){

                                                    $selectedClicks = esc_html__('No', 'listingpro');

                                                }

                                                ?>

                                                <h4><?php echo $selectedClicks; ?></h4>

                                                <h5><?php echo esc_html__('clicks', 'listingpro'); ?></h5>

                                            </div>



                                        </div>

                                        <p><?php echo esc_html__('Total Ads Clicks', 'listingpro'); ?></p>



                                    </div>



                                </div>

                                <?php

                                }

                                ?>

                            

                        </div>



                        <div class="lp-general-section-title-outer">

                            <p id="" class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__('Purchase Details', 'listingpro');?> <i class="fa fa-angle-right" aria-hidden="true"></i></p>

                            <div class="lp-ad-click-inner" id="lp-ad-click-innerr">

                                <?php

                                    if($typeofcampaign=="adsperclick"){

                                        ?>

                                        <ul class="lp-ad-all-stats clearfix lp-ad-packages-stats">



                                            <li>

                                                <p><?php echo esc_html__('Amount paid', 'listingpro'); ?></p>

                                                <h4 class="facmount"><?php echo $selectedPaidAmount.$currency; ?></h4>

                                            </li>

                                            <li>

                                                <p><?php echo esc_html__('Credit', 'listingpro'); ?></p>

                                                <?php

                                                    if(empty($selectedCredit)){

                                                        $selectedCredit = $selectedPaidAmount;

                                                    }

                                                ?>

                                                <h4 class="faccredit"><?php echo $selectedCredit.$currency; ?></small></h4>

                                            </li>

                                        </ul>

                                        <?php

                                    }

                                    ?>

                                    

                                    <div class="lp-invoices-all-stats">

                                        <h5><?php echo esc_html__('Ad Placements', 'listingpro'); ?></h5>

                                        <ul class="lp-ad-all-attached-packages clearfix padding-bottom-10 border-bottom margin-bottom-30">

                                            <?php echo $selctedPackages; ?>

                                        </ul>

                                        <ul>

                                            <li class="margin-bottom-20"></li>

                                            <li class="lp-ad-payment-method"><?php echo $selctedMethod; ?></li>

                                            <?php

                                            if($typeofcampaign!="adsperclick"){

                                                ?>

                                                <li class="lp-ad-payment-duration"><?php echo $selctedduration; ?></li>

                                                <li class="lp-ad-payment-price"><?php echo $selctedAmount; ?></li>

                                                <?php

                                            }

                                            ?>

                                        </ul>

                                    </div>



                            </div>

                        </div>



                    </div>

                </div>

        <?php } ?>
 
        <div class="padding-right-0">
            <div class="lp-ad-click-outer lp_campaign_invoice_pmethod">
                <div class="lp-general-section-title-outer lp_ads_payment_summary">
                    <p class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__('New ad summery', 'listingpro');?> <i class="fa fa-angle-right" aria-hidden="true"></i></p>
                    <div class="lp-ad-click-inner  lp-ad-statcs margin-bottom-30">

                        <ul class="lp-invoices-all-stats clearfix">

		                    <?php  if( !empty($showSpotlightAds)){ ?>

                                <li class="spotlight">

                                    <h5><?php echo esc_html__('SPOTLIGHT', 'listingpro'); ?>  <span><i class="fa fa-check-circle lp-gray-this-ccircle"></i></span></h5>

                                </li>

		                    <?php } ?>

		                    <?php  if( !empty($showSearchtopAds)){ ?>

                                <li class="searchpage">

                                    <h5><?php echo esc_html__('TOP OF SEARCH', 'listingpro'); ?>  <span><i class="fa fa-check-circle lp-gray-this-ccircle"></i></span></h5>

                                </li>

		                    <?php } ?>

		                    <?php  if( !empty($showDetailpageAds)){ ?>

                                <li class="detailpage">

                                    <h5><?php echo esc_html__('SIDEBAR', 'listingpro'); ?>  <span><i class="fa fa-check-circle lp-gray-this-ccircle"></i></span></h5>

                                </li>

		                    <?php } ?>

		                    <?php

		                    if(!empty($isTax)){

			                    ?>

                                <li class="taxpricein">

                                    <h5><?php echo esc_html__('Tax(inc)', 'listingpro'); ?>  <span><?php echo $taxPerfent; ?>%</span></h5>

                                </li>



			                    <?php

		                    }

		                    ?>



		                    <?php

		                    if($typeofcampaign=="adsperduration"){

			                    ?>

                                <li class="budget">

                                    <h5><?php echo esc_html__('Duration', 'listingpro'); ?>  <span></span></h5>

                                </li>

			                    <?php

		                    }else{

			                    ?>

                                <li class="budget">

                                    <h5><?php echo esc_html__('BUDGET', 'listingpro'); ?>  <span></span></h5>

                                </li>

			                    <?php
		                    }

		                    ?>

                        </ul>
                        <ul class="lp-invoices-all-stats clearfix lp-ad-total-amount">
                            <li class="subamount">
                                <h5><?php echo esc_html__('SUB AMOUNT', 'listingpro'); ?>  <span></span></h5>
                            </li>
                            
                            <li class="lp-total-amount-count">
                                <h5><?php echo esc_html__('TOTAL AMOUNT', 'listingpro'); ?>  <span></span></h5>
                            </li>

                        </ul>
                    </div>
                </div>


                <div class="lp-select-payement-outer lp_payment_methods_ads" style="display:none">
                    <p class="clarfix lp-general-section-title comment-reply-title active"><?php echo esc_html__('SELECT PAYMENT METHOD', 'listingpro');?> <i class="fa fa-angle-right" aria-hidden="true"></i></p>
					
					<?php
						if(!empty($showPaypal) || !empty($showStripe) || !empty($showWire)){
					?>
					
							<ul>
								<?php
								if(!empty($showPaypal)){
									?>
										<li class="clearfix">
											<div class="lp-invoice-number lp-listing-form pull-left">

												<label>

													<div class="radio radio-danger">
														<input class="radio_checked" type="radio" name="method" id="" value="paypal">
														<label for="">

														</label>
													</div>
												</label>

											</div>
											<div class="lp-payement-images pull-left">
											<img src="<?php echo get_template_directory_uri().'/assets/images/paypal.png'; ?>" />
											</div>
										</li>
										<?php
								}
								if(!empty($showStripe)){
									?>
										<li class="clearfix">
											<div class="lp-invoice-number lp-listing-form pull-left">

												<label>

													<div class="radio radio-danger">
														<input class="radio_checked" type="radio" name="method" id="" value="stripe">
														<label for="">

														</label>
													</div>
												</label>

											</div>
											<div class="lp-payement-images pull-left">
												<img src="<?php echo get_template_directory_uri().'/assets/images/stripe.png'; ?>" />
											</div>
										</li>
										<?php
								}
								if(!empty($showWire)){
									?>
										<li class="clearfix">
											<div class="lp-invoice-number lp-listing-form pull-left">

												<label>

													<div class="radio radio-danger">
														<input class="radio_checked" type="radio" name="method" id="" value="wire">
														<label for="">

														</label>
													</div>
												</label>

											</div>
											<div class="lp-payement-images pull-left">
											<img src="<?php echo get_template_directory_uri().'/assets/images/wire.png'; ?>" />
											</div>
										</li>
										<?php
								}
								?>
								
							</ul>
					<?php
						}
					?>
					
					
				<?php
					if ( wp_is_mobile() && !empty($showcampaingprocess) ) {
						?>
					<div class="col-sm-12 lp-menu-save-btns clearfix">
						<button class="lp-cancle-btn"><?php echo esc_html__('Cancel', 'listingpro'); ?></button>
						<button type="button" class="lp-save-btn lp_campaign_paynow startpayforcampaignsss" disabled><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo esc_html__('Pay Now', 'listingpro'); ?></button>
					</div>
					<?php
					}
				?>	
					
                </div>
				

            </div>
        </div>
    </div>
		
	
	 </form>
</div>

<?php
$pubilshableKey = '';
$secritKey = '';

$pubilshableKey = lp_theme_option('stripe_pubishable_key');
$secritKey = lp_theme_option('stripe_secrit_key');

$ajaxURL = '';
$ajaxURL = admin_url( 'admin-ajax.php' );

?>
<script>
    var listing_id;
    var packages = [];
    var taxprice = '';
	document.getElementById("lp-new-ad-compaignForm").reset(); 
    jQuery('input[name="lpadsoftype[]"]').click(function(){
        if(jQuery(this).attr('checked')){
            packages.push(jQuery(this).val());
        }
        else{
            var i = packages.indexOf(jQuery(this).val());
            if(i != -1) {
                packages.splice(i, 1);
            }
        }

    });

    jQuery('#lp-new-ad-compaignForm').on('submit', function(e){

        $this = jQuery(this);
        taxprice = $this.find('input[name="taxRate"]').val();

    });

    var handler = StripeCheckout.configure({
        key: "<?php echo $pubilshableKey; ?>",
        image: "https://stripe.com/img/documentation/checkout/marketplace.png",
        locale: "auto",
        token: function(token) {
            token_id = token.id;
            token_email = token.email;
            jQuery('body').addClass('listingpro-loading');
            lpTotalPrice = '';
			if(jQuery('input[name=adsprice_pc]').val()){
				lpTotalPrice = jQuery('input[name="adsprice_pc"]').val();
			}else if(jQuery('input[name="ads_price"]').val()){
				lpTotalPrice = jQuery('input[name="ads_price"]').val();
			}
			
			if(jQuery('#lp-new-ad-compaignForm').data('type')=="adsperclick"){
				totalPrice = jQuery('input[name="adsprice_pc"]').val();
			}else{
				totalPrice = jQuery('input[name="ads_price"]').val();
			}
			
			

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo $ajaxURL; ?>",
                data: {
                    "action": "listingpro_save_package_stripe",
                    "token": token_id,
                    "email": token_email,
                    "listing": jQuery('select[name=lp_ads_for_listing]').val(),
                    "packages": packages,
                    "lpTOtalprice":lpTotalPrice,
                    "adsTypeval":jQuery('input[name=adsTypeval]').val(),
                    "ads_days":jQuery('input[name=ads_days]').val(),
                    "taxprice":jQuery('input[name=taxprice]').val(),
                    "ads_price":totalPrice,
                },
                success: function(res){
                    jQuery('body').removeClass('listingpro-loading');
                    if(res.status=="success"){
                        redURL = res.redirect;
                        window.location.href = redURL;
                    }
                    else{
                        alert(res.status);
                        jQuery('body').removeClass('listingpro-loading');
                    }

                },
                error: function(errorThrown){
                    jQuery('body').removeClass('listingpro-loading');
                    alert(errorThrown);
                }
            });


        }
    });

    window.addEventListener("popstate", function() {
        handler.close();
    });
</script>