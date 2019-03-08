	<?php
	global $listingpro_options;
    $app_view_home  =   $listingpro_options['app_view_home'];
    $app_view_home  =   url_to_postid( $app_view_home );
	if ( is_front_page() || ( !empty( $app_view_home ) && is_page( $app_view_home ) ) ) {
		$topBannerView = $listingpro_options['top_banner_styles'];
		$top_title = $listingpro_options['top_title'];
		$top_main_title = $listingpro_options['top_main_title'];
		$main_text = $listingpro_options['main_text'];
		$map_height = $listingpro_options['map_height'];
		$arrow_image = $listingpro_options['arrow_image'];
		$locationType = 'withip';

		$courtesySwitch = $listingpro_options['courtesy_switcher'];
		if($courtesySwitch == 1) {
			$courtesyListing = $listingpro_options['courtesy_listing'];
		}
		$height = '';
		if ( !empty($map_height) ) {
			$height = ' style="height:'.$map_height.'px;"';
		}else {
			$height = ' style="height:500px;"';
		}
		if( $topBannerView == 'map_view' ) {
		?>
			<div class="lp_home" id="homeMap" <?php echo $height; ?>></div>
		<?php } else { ?>
			<?php
			$videosearchlayout = $listingpro_options['video_search_layout'];
			$videoBanner = $listingpro_options['lp_video_banner_on'];
			$video_banner_img = $listingpro_options['video_banner_img']['url'];
			if($videoBanner=="video_banner"){
                $video_src  =   $listingpro_options['vedio_type'];
			 $vedio_url = $listingpro_options['vedio_url'];
                $vedio_url_yt = $listingpro_options['vedio_url_yt'];
			 if(!empty($vedio_url) || !empty($vedio_url_yt)){
		   ?>

			 <div class="video-lp">
                 <?php
                 if( $video_src == 'video_mp4' ):
                 ?>
                 <video id="lp_vedio" muted autoplay="autoplay" loop="loop" width="0" height="0" poster="<?php echo $video_banner_img;?>">
			  <source src="<?php echo esc_url($vedio_url);?>" type="video/webm" />
			  <source src="<?php echo esc_url($vedio_url);?>" type="video/mp4" />
			  <source src="<?php echo esc_url($vedio_url);?>" type="video/ogg" />
			 </video>
                 <?php
                 else:
                     $outputEmbed =  preg_replace(	"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","$2",$vedio_url_yt);
                     echo '
					 <iframe poster="'.$video_banner_img.' id="lp-youtube-banner" frameborder="0" width="100%" height="100%" src="https://www.youtube.com/embed/'.$outputEmbed.'?autoplay=1&loop=1&controls=0&mute=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					 ';
                 endif;
                 ?>
			 </div>
		   <?php
			 }
			}
			
		   
		   ?>
		   <div class="lp-home-banner-contianer lp-home-banner-with-loc">

			<div class="page-header-overlay"></div>
			<?php if($courtesySwitch == 1) { ?>
			 <div class="img-curtasy">
			  <p><?php esc_html_e('Image courtesy of','listingpro'); ?> <span><a href="<?php echo get_the_permalink($courtesyListing); ?>"><?php echo get_the_title($courtesyListing); ?> <i class="fa fa-angle-right"></i></a></span></p>
			 </div>
			<?php } ?>

			
			<div class="lp-home-banner-contianer-inner">
			 <div class="container">
			  <div class="row">
			   <div class="col-md-8 col-xs-12 col-md-offset-2 col-sm-offset-0">
				<?php get_template_part( 'templates/search/home-search'); ?>
				<div class="text-center lp-search-description">
				 <?php if(!empty($main_text)) { ?>
				  <p><?php echo $main_text; ?></p>
				 <?php } ?>
				<?php if($arrow_image == 1) { ?>
				 <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-arrow.png" alt="banner-arrow" class="banner-arrow" />
				<?php }?>
				</div>
			   </div>
			  </div>
			 </div>
			</div>
		

		   </div><!-- ../Home Search Container -->
		   
		<?php } ?>



		<?php
	}elseif( is_page()) {
	  $showPageTitle = $listingpro_options['lp_showhide_pagetitle'];
	  if ( have_posts() ) : while ( have_posts() ) : the_post();
	   if(has_shortcode( get_the_content(), 'vc_row' ) && has_shortcode( get_the_content(), 'listingpro_promotional' )){
		
	   }else{
		if($showPageTitle=="1"){
	   ?> 
		<div class="page-heading listing-page">
		 <div class="page-heading-inner-container text-center">
		  <h1><?php echo get_the_title(); ?></h1>
		  <?php if (function_exists('listingpro_breadcrumbs')) listingpro_breadcrumbs(); ?>
		 </div>
		 <div class="page-header-overlay"></div>
		</div>
	   <?php
		}
	   }
	  endwhile; endif; 
	  
	  
	  
	 }elseif (is_home()) {
	 ?>
	  <div class="page-heading listing-page">
	   <div class="page-heading-inner-container text-center">
		<h1>
		 <?php
		  $queried_object = get_queried_object();
		  echo single_post_title('', FALSE);
		 ?>
		</h1>
		<ul class="breadcrumbs">
		 <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'listingpro') ?></a></li>
		 <li><span><?php _e('Blog', 'listingpro') ?></span></li>
		</ul>
	   </div>
	   <div class="page-header-overlay"></div>
	  </div>
	 <?php }elseif ( is_archive() ) {
	   $showPageTitle = $listingpro_options['lp_showhide_pagetitle'];
	   if($showPageTitle=="1"){
		?>
		 <div class="page-heading listing-page ss">
		  <div class="page-heading-inner-container text-center">
		   <h1><?php echo the_archive_title(); ?></h1>
		   <?php if (function_exists('listingpro_breadcrumbs')) listingpro_breadcrumbs(); ?>
		  </div>
		  <div class="page-header-overlay"></div>
		 </div> 
		<?php 
	   }
	 }elseif ( is_404() ) {
	 ?>
	  <div class="page-heading listing-page">
	   <div class="page-heading-inner-container text-center">
		<h1><?php esc_html_e('404', 'listingpro') ?></h1>
		<?php if (function_exists('listingpro_breadcrumbs')) listingpro_breadcrumbs(); ?>
	   </div>
	   <div class="page-header-overlay"></div>
	  </div>
	 <?php 
	 }else{
	 ?>
	  
	 <?php 
	 } 
	 ?>