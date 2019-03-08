<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
	   <!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">		<!-- Favicon -->
		<?php listingpro_favicon(); 
			global $listingpro_options;
			$listing_detail_slider_style = $listingpro_options['lp_detail_slider_styles'];
			$lp_default_map_location_lat = 0;
			$lp_default_map_location_long = -0;
			if( (isset($listingpro_options['lp_default_map_location_lat'])) && (isset($listingpro_options['lp_default_map_location_long'])) ){
				if( (!empty($listingpro_options['lp_default_map_location_lat'])) && (!empty($listingpro_options['lp_default_map_location_long'])) ){
					$lp_default_map_location_lat   =  $listingpro_options['lp_default_map_location_lat'];
					$lp_default_map_location_long   =  $listingpro_options['lp_default_map_location_long'];
				}
			}
			
			$lpsearchMode = "titlematch";
			if( isset($listingpro_options['lp_what_field_algo']) ){
				if( !empty($listingpro_options['lp_what_field_algo']) && $listingpro_options['lp_what_field_algo']=="keyword" ){
					$lpsearchMode = "keyword";
				}
			}
		?>	
		<?php wp_head(); ?>
    </head>
	
	<?php
	$lpAtts = '';
	if( is_search() || is_tax() ){
		if(lp_theme_option('enable_search_filter')==1){
			if(lp_theme_option('enable_nearme_search_filter')==1){
				if(lp_theme_option('disable_location_in_nearme_search_filter')==1){
					 $lpAtts = "data-locdisablefilter='yes'".' ';
				}
			}
		}
	}
	?>

    <body <?php body_class() ?> data-submitlink="<?php echo listingpro_url('submit-listing'); ?>" data-sliderstyle="<?php echo esc_attr($listing_detail_slider_style); ?>" data-defaultmaplat="<?php echo esc_attr($lp_default_map_location_lat); ?>" data-defaultmaplot="<?php echo esc_attr($lp_default_map_location_long); ?>" data-lpsearchmode = "<?php echo esc_attr($lpsearchMode); ?>" <?php echo $lpAtts; ?>>
	
	<?php
		$mapbox_token= '';
		$map_style= '';
		$mapOption = $listingpro_options['map_option'];

		$search_view = $listingpro_options['search_views'];
		$search_layout = $listingpro_options['search_layout'];
		$alignment = $listingpro_options['search_alignment'];
		$top_banner_styles = $listingpro_options['top_banner_styles'];

		$alignClass = '';
		if( $top_banner_styles == 'map_view' ) {			
			if ( $alignment == 'align_top' ) {
				$alignClass = 'lp-align-top';
			}elseif ( $alignment == 'align_middle' ) {
				$alignClass = 'lp-align-underBanner';
			}elseif ( $alignment == 'align_bottom' ) {
				$alignClass = 'lp-align-bottom';
			}
		}


		if($mapOption == 'mapbox'){
			$mapbox_token = $listingpro_options['mapbox_token'];
			$map_style = $listingpro_options['map_style'];
		}
		
		
		$primary_logo = $listingpro_options['primary_logo']['url'];
		$listing_style = '';
		$listing_styledata = '';
		$listing_style = $listingpro_options['listing_style'];
		if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
			$listing_styledata = 'data-list-style="'.esc_attr($_GET['list-style']).'"';
			$listing_style = esc_html($_GET['list-style']);
		}
		
		$lpCurrLocOnHome = '';
		if(isset($listingpro_options['lp_auto_current_locations_switch'])){
			$lpCurrLocOnHome  = $listingpro_options['lp_auto_current_locations_switch'];
		}


        $header_views =     $listingpro_options['header_views'];
		$topBannerView = $listingpro_options['top_banner_styles'];
		$ipAPI = $listingpro_options['lp_current_ip_type'];
		$videoBanner = '';
		$imgClass = '';
		if( $topBannerView == 'map_view' ) {
			$imgClass = '';
		}else {
			
			$videoBanner = $listingpro_options['lp_video_banner_on'];
			if($videoBanner=="video_banner"){
				$imgClass = 'lp-vedio-bg';
			}
			else{
				$imgClass = 'lp-header-bg';
			}
			
		}
		
	$app_view_home  =   $listingpro_options['app_view_home'];
	$app_view_home  =   url_to_postid( $app_view_home );	
	?>
	
	<div id="page" class="clearfix" <?php echo esc_attr($listing_styledata); ?> data-mtoken="<?php echo esc_attr($mapbox_token); ?>"  data-mstyle="<?php echo esc_attr($map_style); ?>" data-sitelogo="<?php echo esc_attr($primary_logo); ?>" data-site-url="<?php echo esc_url(home_url('/')); ?>"  data-ipapi="<?php echo $ipAPI ?>" data-lpcurrentloconhome = "<?php echo esc_attr($lpCurrLocOnHome) ?>">
	
	<!--==================================Header Open=================================-->
<div class="pos-relative">
	<?php
		get_template_part( 'templates/popups');
	?>
	<div class="header-container <?php if(is_front_page() || ( !empty( $app_view_home ) && is_page( $app_view_home ) )){ echo esc_attr($imgClass); } ?> ">
		<?php
            get_template_part( 'mobile/templates/headers/header-app-view-template');
			get_template_part( 'mobile/templates/headers/banner/banner-app-view');
		?>
	</div>
	<!--==================================Header Close=================================-->

	<!--================================== Search Close =================================-->
	<?php 
	if( is_front_page() && !is_home() || ( !empty( $app_view_home ) && is_page($app_view_home) ) ){
		$topBannerView = $listingpro_options['top_banner_styles'];
		if( $topBannerView == 'map_view' ) {
			get_template_part( 'templates/search/template_search1' );
		}
	}
	?>
	<div class="lp-top-notification-bar"></div>
	<!--================================== Search Close =================================-->
</div>

<?php 
	if ( is_front_page() ) { ?>
		<div class="home-categories-area <?php echo esc_attr($alignClass); ?>">
			<?php echo listingpro_banner_categories(); ?>
		</div>
		<?php
	}
?>