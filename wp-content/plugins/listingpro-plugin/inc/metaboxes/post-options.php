<?php 
/* * *********************** */
/* Listing options */
/* * *********************** */
global $listingpro_options, $reviews_options, $listingpro_settings, $listingpro_formFields,$claim_options, $page_options, $post_options, $price_plans_options;

$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
$lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
$lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
$lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
/* zaheer 10 march */
global $currentdate, $exprityDate;
$currentdate = date("d-m-Y");
$ads_durations = '';
if(class_exists('Redux') && isset($listingpro_options) && !empty($listingpro_options)){
$ads_durations = lp_theme_option('listings_ads_durations' );
}
$exprityDate = date('Y-m-d', strtotime($currentdate. ' + '.$ads_durations.' days'));
$exprityDate = date('d-m-Y', strtotime( $exprityDate ));
/* zaheer 10 march */
global $priceplans;
$priceplans[]= 'Select Plan';
$the_query = new WP_Query( array('post_type'	=> 'price_plan','post_status'=> 'publish', 'posts_per_page'	=> -1) );

if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$priceplans[get_the_ID()] = get_the_title();
	}
	wp_reset_postdata();
} else {
}


/* ads plan array by zaheer */
$level1_price = '';
$level2_price = '';
$level3_price = '';
$level4_price = '';
global $adsArray;
if(class_exists('Redux') && isset($listingpro_options) && !empty($listingpro_options)){
$currencyprice = $listingpro_options['currency_paid_submission'];
$lp_random_ads = $listingpro_options['lp_random_ads'];
$lp_detail_page_ads = $listingpro_options['lp_detail_page_ads'];
$lp_top_in_search_page_ads = $listingpro_options['lp_top_in_search_page_ads'];
$currencyprice = $listingpro_options['currency_paid_submission'];


$adsArray['lp_random_ads'] = $lp_random_ads.$currencyprice.' (Spotlight)'; 
$adsArray['lp_detail_page_ads'] = $lp_detail_page_ads.$currencyprice.' (Sidebar)'; 
$adsArray['lp_top_in_search_page_ads'] = $lp_top_in_search_page_ads.$currencyprice.' (Top of Search)'; 
}

$claimers = array();

$users = get_users(  );
foreach($users as $user_id){
        $claimers[$user_id->ID] = $user_id->user_nicename;
    }

$claimStatus = array();
$claimStatus = array(
	'pending'	=> 'Pending',
	'approved'	=> 'Approved',
	'decline'	=> 'Decline',
);


$post_options = Array(
    Array(
        'name' => esc_html__('Add Banner', 'listingpro-plugin'),
        'id' => 'lp_post_banner',
        'type' => 'file',
        'desc' => 'Upload banner for this page'),
);
	
$page_options = Array(
    Array(
        'name' => esc_html__('Add Banner', 'listingpro-plugin'),
        'id' => 'lp_page_banner',
        'type' => 'file',
        'desc' => 'Upload banner for this page'),
);


/* plan new options */

$planFor = array(
	'name' => '',
	'id' => 'plan_for',
	'type' => 'hidden',
	'desc' => ''
);

$claimTypeArray = array(
	'name' => '',
	'id' => 'claim_type',
	'type' => 'hidden',
	'desc' => ''
);

$claimPlansArray = array(
	'name' => '',
	'id' => 'claim_plans',
	'type' => 'hidden',
	'desc' => ''
);

$claimCustomButton = array(
	'name' => '',
	'id' => 'claim_actionBtn',
	'type' => 'hidden',
	'desc' => ''
);

$lp_paid_claim = lp_theme_option('lp_listing_paid_claim_switch');
if($lp_paid_claim=="yes"){
	$planFor = Array(
		'name' => esc_html__('Plan For', 'listingpro-plugin'),
		'id' => 'plan_for',
		'type' => 'select',
		'options' => array(
				'listingonly' => esc_html__('Listing Only', 'listingpro-plugin'),
				'claimonly' => esc_html__('Claim Only', 'listingpro-plugin'),
				'listingandclaim' => esc_html__('Both', 'listingpro-plugin'),
			),
		'desc' => 'listingonly');



	$claimTypeArray = Array(
		'name' => esc_html__('Claim Type', 'listingpro-plugin'),
		'id' => 'claim_type',
		'type' => 'select',
		'options' => array(
				'freeclaims' => esc_html__('Free', 'listingpro-plugin'),
				'paidclaims' => esc_html__('Paid', 'listingpro-plugin'),
			),
		'desc' => '');


	$claimPlansArray = Array(
		'name' => esc_html__('Select Plan', 'listingpro-plugin'),
		'id' => 'claim_plan',
		'type' => 'select',
		'options' => lp_get_claim_plans_function_array(),
		'desc' => '');

	$claimCustomButton = array(
	'name' => esc_html__('Send Email', 'listingpro-plugin'),
	'id' => 'claim_actionBtn',
	'type' => 'custombutton',
	'desc' => ''
);


}


$price_plans_options = Array(

	$planFor,
    Array(
        'name' => esc_html__('Background Image', 'listingpro-plugin'),
        'id' => 'lp_price_plan_bg',
        'type' => 'file',
        'desc' => 'Upload background image for plan'
    ),
	Array(
        'name' => esc_html__('Add More', 'listingpro-plugin'),
        'id' => 'lp_price_plan_addmore',
        'type' => 'increment',
        'desc' => 'Add Custom Fields here'
    ),
	

);
	
$claim_options = Array(
	Array(
		'name' => esc_html__('Select Listing for Claim', 'listingpro-plugin'),
        'id' => 'claimed_listing',
        'type' => 'listing',
        'options' => '',
		'desc' => ''),
		
	Array(
		'name' => esc_html__('Claimed by', 'listingpro-plugin'),
        'id' => 'claimer',
        'type' => 'select',
        'options' => $claimers,
		'desc' => ''),
		
	Array(
		'name' => esc_html__('Author', 'listingpro-plugin'),
        'id' => 'owner',
        'type' => 'static',
		'desc' => ''),
	Array(
		'name' => esc_html__('Status', 'listingpro-plugin'),
        'id' => 'claim_status',
        'type' => 'select',
        'options' => $claimStatus,
		'desc' => ''),
	
	Array(
		'name' => esc_html__('Claimer Details', 'listingpro-plugin'),
        'id' => 'details',
        'type' => 'textarea',
        'child_of' => '',
        'match' => '',
		'desc' => ''),
	Array(
		'name' => esc_html__('Claimer Phone', 'listingpro-plugin'),
        'id' => 'claimer_phone',
        'type' => 'text',
        'child_of' => '',
        'match' => '',
		'desc' => ''),
	$claimTypeArray,
	$claimPlansArray,
	$claimCustomButton,

);

/* end ads by zaheer */

/* Ads options by zaheer */
global $ads_options;

$ads_options = Array(
	Array(
		'name' => esc_html__('Select Listing', 'listingpro-plugin'),
        'id' => 'ads_listing',
        'type' => 'listing',
		'options' => array(
			''=>	'Select Listing'
		),
		'desc'	  => '',
		),
	Array(
		'name' => esc_html__('Ad type', 'listingpro-plugin'),
        'id' => 'ad_type',
        'type' => 'checkboxes',
		'value'=> '',
		'options' => $adsArray,
		'desc'	  => '',
		),
	Array(
		'name' => esc_html__('Launched Date', 'listingpro-plugin'),
        'id' => 'ad_date',
        'type' => 'hidden',
		'std' => $currentdate,
		 'desc' => '',
		),
	Array(
		'name' => esc_html__('Ad Expiry Date', 'listingpro-plugin'),
        'id' => 'ad_expiryDate',
        'type' => 'hidden',
	 	'std' => $exprityDate,
		'desc' => '',
		),
    /* for v2 */
    Array(
        'name' => esc_html__('Mode', 'listingpro-plugin'),
        'id' => 'ads_mode',
        'type' => 'select',
        'options' => array(
            ''=>	'Select Mode',
            'perclick'=>    'Pay Per Click (PPC)',
           'byduration'=>    'Pay Per Day (PPD)',
        ),
        'desc'	  => '',
    ),
    Array(
        'name' => esc_html__('Total Duration', 'listingpro-plugin'),
        'id' => 'duration',
        'type' => 'text',
        'desc' => 'Duration for ads in Days. e-g : 20'),
    Array(
        'name' => esc_html__('Total Budget', 'listingpro-plugin'),
        'id' => 'budget',
        'type' => 'text',
        'desc' => 'Budget for ads'),
    Array(
        'name' => esc_html__('Allowed Click', 'listingpro-plugin'),
        'id' => 'remaining_balance',
        'type' => 'text',
        'std' => '',
        'desc' => 'Remaing balance for clicks',
    ),
    Array(
        'name' => esc_html__('Click Used', 'listingpro-plugin'),
        'id' => 'click_performed',
        'type' => 'text',
        'std' => '',
        'desc' => 'Used Click by this ad',
    ),
		
);
/* end Ads options by zaheer */


$reviews_options = Array(

	Array(
		'name' => esc_html__('Gallery', 'listingpro-plugin'),
        'id' => 'gallery',
        'type' => 'gallery',
		'desc' => ''),
		/* by zaheer on 25 feb */
	Array(
		'name' => esc_html__('Rating', 'listingpro-plugin'),
        'id' => 'rating',
        'type' => 'select',
        'options' => array(
		''	=>	'Select rating',
		'1'	=>	'1',
		'2'	=>	'2',
		'3'	=>	'3',
		'4'	=>	'4',
		'5'	=>	'5',
		),
		'desc' => ''),
	Array(
		'name' => esc_html__('Assigned to Listing', 'listingpro-plugin'),
        'id' => 'listing_id',
        'type' => 'listing',
        'options' => array(
			''=>	'Select Listing'
		),
		'desc' => ''),
	Array(
		'name' => esc_html__('Reply', 'listingpro-plugin'),
        'id' => 'review_reply',
        'type' => 'text',
        'default' => '',
		'desc' => ''),
	/* end by zaheer on 25 feb */
		/* by zaher on 16 march */
	Array(
		'name' => esc_html__('Interesting', 'listingpro-plugin'),
        'id' => 'review_Interesting',
        'type' => 'hidden',
        'default' => '',
		'desc' => ''),
	Array(
		'name' => esc_html__('LOL', 'listingpro-plugin'),
        'id' => 'review_Lol',
        'type' => 'hidden',
        'default' => '',
		'desc' => ''),
	Array(
		'name' => esc_html__('Love', 'listingpro-plugin'),
        'id' => 'review_Love',
        'type' => 'hidden',
        'default' => '',
		'desc' => ''),
	Array(
		'name' => esc_html__('Reported By', 'listingpro-plugin'),
        'id' => 'review_reported_by',
        'type' => 'hidden',
        'default' => '0',
		'desc' => ''),
	Array(
		'name' => esc_html__('Reported Count', 'listingpro-plugin'),
        'id' => 'review_reported',
        'type' => 'hidden',
        'default' => '0',
		'desc' => ''),
	/*end by zaher on 16 march */
	
);

$listingpro_settings = Array(
	Array(
        'name' => esc_html__('Business Tagline Text', 'listingpro-plugin'),
        'id' => 'tagline_text',
        'type' => 'text',
		'desc' => 'Your Business One liner'),

    Array(
        'name' => esc_html__('Google Address', 'listingpro-plugin'),
        'id' => 'gAddress',
        'type' => 'text',
		'desc' => 'Google address for map'),		
	Array(
        'name' => esc_html__('Latitude', 'listingpro-plugin'),
        'id' => 'latitude',
        'type' => 'text',
		'desc' => ''),
	Array(
        'name' => esc_html__('Longitude', 'listingpro-plugin'),
        'id' => 'longitude',
        'type' => 'text',
		'desc' => ''),
		
	Array(
        'name' => esc_html__('Map Pin', 'listingpro-plugin'),
        'id' => 'mappin',
        'type' => 'mappinbuton',
		'desc' => ''),	
   
   Array(
        'name' => esc_html__('Phone', 'listingpro-plugin'),
        'id' => 'phone',
        'type' => 'text',
		'desc' => ''),
	Array(
        'name' => esc_html__('Whatsapp', 'listingpro-plugin'),
        'id' => 'whatsapp',
        'type' => 'text',
		'desc' => ''),
    Array(
        'name' => esc_html__('Email', 'listingpro-plugin'),
        'id' => 'email',
        'type' => 'text',
		'desc' => 'This Email is not for public'),
    Array(
        'name' => esc_html__('Website', 'listingpro-plugin'),
        'id' => 'website',
        'type' => 'text',
		'desc' => 'Your website URL'),
    Array(
        'name' => esc_html__('Twitter', 'listingpro-plugin'),
        'id' => 'twitter',
        'type' => 'text',
		'desc' => 'Your twitter URL'),
    Array(
        'name' => esc_html__('Facebook', 'listingpro-plugin'),
        'id' => 'facebook',
        'type' => 'text',
		'desc' => 'Your facebook URL'),
    Array(
        'name' => esc_html__('LinkedIn', 'listingpro-plugin'),
        'id' => 'linkedin',
        'type' => 'text',
		'desc' => 'Your Linkedin URL'),
	Array(
        'name' => esc_html__('Google Plus', 'listingpro-plugin'),
        'id' => 'google_plus',
        'type' => 'text',
		'desc' => 'Your Google Plus URL'),
    Array(
        'name' => esc_html__('Youtube Channel Link', 'listingpro-plugin'),
        'id' => 'youtube',
        'type' => 'text',
		'desc' => esc_html__('Your Youtube Channel URL as social link', 'listingpro-plugin'),
		),
	Array(
        'name' => esc_html__('Instagram Profile Link', 'listingpro-plugin'),
        'id' => 'instagram',
        'type' => 'text',
		'desc' => esc_html__('Your Instagram Profile URL as social link', 'listingpro-plugin'),
		),
	Array(
        'name' => esc_html__('Youtube Video URL', 'listingpro-plugin'),
        'id' => 'video',
        'type' => 'text',
		'desc' => esc_html__('Any specific Youtube Video? You want to share on business page', 'listingpro-plugin'),
		),
	
    Array(
        'name' => esc_html__('Image Gallery', 'listingpro-plugin'),
        'id' => 'gallery',
        'type' => 'gallery',
		'desc' => esc_html__('Select images to present your buisness online.', 'listingpro-plugin'),
		),
	Array(
        'name' => esc_html__('Show Price Status', 'listingpro-plugin'),
        'id' => 'price_status',
        'type' => 'select',
        'std' => 'Price Range',
        'options' => array(
        	'notsay' => 'Prefer not to say',
        	'inexpensive' => ''.$lp_priceSymbol.' Inexpensive',
        	'moderate' => ''.$lp_priceSymbol2.' Moderate',
        	'pricey' => ''.$lp_priceSymbol3.' Pricey',
        	'ultra_high_end' => ''.$lp_priceSymbol4.' Ultra High-End',
        ),
		'desc' => esc_html__('It will show your business price range', 'listingpro-plugin')
		),
			/*by zaher on 17 march */
	Array(
        'name' => esc_html__('Price From', 'listingpro-plugin'),
        'id' => 'list_price',
        'type' => 'Text',
		'desc' => esc_html__('Ignore this if your buisness does not have any specific price to show', 'listingpro-plugin')
		),
	Array(
        'name' => esc_html__('Price To', 'listingpro-plugin'),
        'id' => 'list_price_to',
        'type' => 'Text',
		'desc' => esc_html__('Ignore this if your buisness does not have any specific price to show', 'listingpro-plugin')
		),	
		/*end by zaher on 17 march */
	Array(
        'name' => esc_html__('Plans', 'listingpro-plugin'),
        'id' => 'Plan_id',
        'type' => 'select',
        'options' => $priceplans,
		'desc' => esc_html__('Ignore this if this post will not be a paid one', 'listingpro-plugin')
		),
	Array(
        'name' => esc_html__('Reviews', 'listingpro-plugin'),
        'id' => 'reviews_ids',
        'type' => 'array',
		'desc' => ''),
	Array(
        'name' => esc_html__('Verify Listing', 'listingpro-plugin'),
        'id' => 'claimed_section',
        'type' => 'select',
        'std' => 'Verify Listing',
        'options' => array(
			'not_claimed' => 'Not Claimed',
        	'claimed' => 'Claimed'      	
        ),
		'default'=> 'not_claimed',
		'desc' => esc_html__('Approve claim at claim section this will override complete claim system', 'listingpro-plugin')
		),
    
	/* changes on 25 feb by zaheer */
	Array(
        'name' => esc_html__('Ad Purchased on', 'listingpro-plugin'),
        'id' => 'listings_ads_purchase_date',
        'type' => 'hidden',
		'default'	=>'',
		'desc' => ''),
	/* end changes on 25 feb by zaheer */
	Array(
        'name' => esc_html__('Ad Purchased Packages', 'listingpro-plugin'),
        'id' => 'listings_ads_purchase_packages',
        'type' => 'hidden',
		'default'	=>'',
		'desc' => ''),
	Array(
        'name' => esc_html__('Faq', 'listingpro-plugin'),
        'id' => 'faqs',
        'type' => 'faqs',
		'desc' => ''),
	Array(
        'name' => esc_html__('Timings', 'listingpro-plugin'),
        'id' => 'business_hours',
        'type' => 'timings',
		'desc' => esc_html__('Set Your business time details', 'listingpro-plugin')
		),
	Array(
		'name' => esc_html__('Copmain ID', 'listingpro-plugin'),
        'id' => 'campaign_id',
        'type' => 'hidden',
		'desc' => '',
		),
	Array(
		'name' => esc_html__('Changed Plan ID', 'listingpro-plugin'),
        'id' => 'changed_planid',
        'type' => 'hidden',
		'desc' => '',
		),
		
	Array(
		'name' => esc_html__('Reported By', 'listingpro-plugin'),
        'id' => 'listing_reported_by',
        'type' => 'hidden',
        'default' => '0',
		'desc' => ''),
		
	Array(
		'name' => esc_html__('Reported Count', 'listingpro-plugin'),
        'id' => 'listing_reported',
        'type' => 'hidden',
        'default' => '0',
		'desc' => ''),
		

);
$b_logo =   lp_theme_option('business_logo_switch');
if( $b_logo == 1 )
{
    $listingpro_settings[]  =   Array(
        'name' => esc_html__('Business Logo', 'listingpro-plugin'),
        'id' => 'business_logo',
        'type' => 'file',
        'desc' => esc_html__('Select business logo for your listing.', 'listingpro-plugin'),
    );
}


$showInFilter = Array(
'name'          => __( '', 'listingpro-plugin' ),
'id'            => 'lp-showin-filter',
'type'          => 'hidden',
'desc' => ''
);
$showFieldsInFilter = lp_theme_option('enable_extrafields_filter');
if(!empty($showFieldsInFilter)){
	$showInFilter = Array(
	'name'          => __( 'Show in Filter', 'listingpro-plugin' ),
	'id'            => 'lp-showin-filter',
	'type'          => 'select',
	'child_of'=> '',
	'options'=>array(
		'notshowinfilter'=> __('No', 'listingpro-plugin'),
		'displaytofilt'=> __('Yes', 'listingpro-plugin'),
	),
	'desc' => ''
	);
}

$listingpro_formFields = Array(
	
	
	Array(
		'name'          => __( 'Field Type', 'listingpro-plugin' ),
		'id'            => 'field-type',
		'type'          => 'select',
		'child_of'=> '',
		'options'       => array(
			'text'                              => __( 'Text', 'listingpro-plugin' ),                
			//'textarea'                          => __( 'Textarea', 'listingpro-plugin' ),                
			//'wysiwyg'                           => __( 'TinyMCE wysiwyg editor', 'listingpro-plugin' ),
/* 			'text_time'                         => __( 'Time picker', 'listingpro-plugin' ),
			'select_timezone'                   => __( 'Timezone', 'listingpro-plugin' ),
			'text_date_timestamp'               => __( 'Date', 'listingpro-plugin' ),
			'text_datetime_timestamp'           => __( 'Date and time', 'listingpro-plugin' ),
			'text_datetime_timestamp_timezone'  => __( 'Date, time and timezone', 'listingpro-plugin' ), */
			//'color'                       => __( 'Colorpicker', 'listingpro-plugin' ),
			'check'                          => __( 'Checkbox', 'listingpro-plugin' ),
			'checkbox'                          => __( 'Checkbox (Switch On/Off)', 'listingpro-plugin' ),
			'checkboxes'                        => __( 'Multicheck', 'listingpro-plugin' ),
			'radio'                             => __( 'Radio', 'listingpro-plugin' ),
			'select'                            => __( 'Drop-Down', 'listingpro-plugin' ),   		
			),
		'desc' => ''
		),
	Array(
		'name'          => __( 'Radio Options', 'listingpro-plugin' ),
		'id'            => 'radio-options',
		'type'          => 'textarea',
		'child_of'=> 'field-type',
		'match'=>'radio',
		'desc' => 'Comma separated options if type support choices'
		),
	Array(
		'name'          => __( 'Select Options', 'listingpro-plugin' ),
		'id'            => 'select-options',
		'type'          => 'textarea',
		'child_of'=> 'field-type',
		'match'=>'select',
		'desc' => 'Comma separated options if type support choices'
		),	
	Array(
		'name'          => __( 'Multicheck Options', 'listingpro-plugin' ),
		'id'            => 'multicheck-options',
		'type'          => 'textarea',
		'child_of'=> 'field-type',
		'match'=>'checkboxes',
		'desc' => 'Comma separated options if type support choices'
		),
	Array(
		'name'          => __( 'Exclusive from Categories', 'listingpro-plugin' ),
		'id'            => 'exclusive_field',
		'type'          => 'check',
		'child_of'=> '',
		'desc' => ''
		),	
	Array(
		'name'          => __( 'Select category for this field', 'listingpro-plugin' ),
		'id'            => 'field-cat',
		'type'          => 'checkboxes',
		'child_of'=> '',
		'options'=>listing_get_cat_array(),
		'desc' => ''
		),
	$showInFilter

	
	
   
);

	
	
	
		
		
		
	

add_action('admin_init', 'listingpro_settings_box');
if (!function_exists('listingpro_settings_box')) {
    function listingpro_settings_box() {
        global $listingpro_settings, $reviews_options;
        add_meta_box('listing_meta_settings',esc_html__( 'listing settings', 'listingpro-plugin' ),'listingpro_metabox_render','listing','normal','high',$listingpro_settings);
        add_meta_box('Reviews_meta_settings',esc_html__( 'Additional Setting', 'listingpro-plugin' ),'reviews_metabox_render','lp-reviews','normal','high',$reviews_options);
		global $claim_options;
		add_meta_box('claims_meta_settings',esc_html__( 'Details About Claim', 'listingpro-plugin' ),'claims_metabox_render','lp-claims','normal','high',$claim_options);
		/* ads metabox by zaheer */
		global $ads_options;
		add_meta_box('ads_meta_settings',esc_html__( 'Ad Options', 'listingpro-plugin' ),'ads_metabox_render','lp-ads','normal','high',$ads_options);
		global $listingpro_options;
		if(isset($listingpro_options['lp_showhide_pagetitle'])){
			if($listingpro_options['lp_showhide_pagetitle']=="1"){
				global $page_options;
				add_meta_box('lp_meta_settings',esc_html__( 'Page Options', 'listingpro-plugin' ),'lp_pages_metabox_render','page','normal','high',$page_options);
			}
		}
		else{
			global $page_options;
			add_meta_box('lp_meta_settings',esc_html__( 'Page Options', 'listingpro-plugin' ),'lp_pages_metabox_render','page','normal','high',$page_options);
		}

		global $post_options;
        add_meta_box('lp_meta_settings',esc_html__( 'Post Options', 'listingpro-plugin' ),'lp_post_metabox_render','post','normal','high', $post_options);
		/* end ads metabox by zaheer */
		global $price_plans_options;
        add_meta_box('lp_meta_settings',esc_html__( 'General Options', 'listingpro-plugin' ),'lp_price_plans_metabox_render','price_plan','normal','high', $price_plans_options);
    }
}

add_action('admin_init', 'listingpro_settings_formfields');
if (!function_exists('listingpro_settings_formfields')) {
    function listingpro_settings_formfields() {
        global $listingpro_formFields;
        add_meta_box('listing_meta_settings',esc_html__( 'Custom Form Fields', 'listingpro-plugin' ),'listingpro_metabox_render','form-fields','normal','high',$listingpro_formFields);
    }
}

 ?>