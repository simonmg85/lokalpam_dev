<?php
/**
 * Listingpro Functions.
 *
 */
	define('THEME_PATH', get_template_directory());
	define('THEME_DIR', get_template_directory_uri());
	define('STYLESHEET_PATH', get_stylesheet_directory());
	define('STYLESHEET_DIR', get_stylesheet_directory_uri());


	/* ============== Theme Setup ============ */

	add_action( 'after_setup_theme', 'listingpro_theme_setup' );
	function listingpro_theme_setup() {
		
		/* Text Domain */
		load_theme_textdomain( 'listingpro', get_template_directory() . '/languages' );
		
		/* Theme supports */
		
		add_editor_style();
		add_theme_support( 'post-thumbnails' );
		add_theme_support( "custom-header" );
		add_theme_support( "custom-background" ) ;
		add_theme_support('automatic-feed-links');
		
		remove_post_type_support( 'page', 'thumbnail' );
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
			'search-form',
			'comment-form',
			'comment-list'
			)
		);
		
		// We are using three menu locations.
		register_nav_menus( array(
			'primary'         => esc_html__( 'Homepage Menu', 'listingpro' ),
			'primary_inner'   => esc_html__( 'Inner Pages Menu', 'listingpro' ),
			'top_menu'        => esc_html__( 'Top Bar Menu', 'listingpro' ),
			'footer_menu' 	  => esc_html__( 'Footer Menu', 'listingpro' ),
			'mobile_menu' 	  => esc_html__( 'Mobile Menu', 'listingpro' ),
            'category_menu' 	  => esc_html__( 'Category Menu', 'listingpro' ),
		) );
		
        global $listingpro_options;
        $header_style   =   $listingpro_options['header_views'];
        if( isset( $listingpro_options['header_cats_partypro'] ) && $header_style == 'header_with_bigmenu' )
        {
            register_nav_menu( 'pp_cat_menu', __( 'Partypro Category Menu', 'listingpro' ) );
        }

		/* Image sizes */
		add_image_size( 'listingpro-blog-grid', 372, 240, true ); // (cropped)		
		add_image_size( 'listingpro-blog-grid2', 372, 400, true ); // (cropped)		
		add_image_size( 'listingpro-blog-grid3', 672, 430, true ); // (cropped)		
		add_image_size( 'listingpro-listing-grid', 272, 231, true ); // (cropped)		
		add_image_size( 'listingpro-listing-gallery', 580, 408, true ); // (cropped)		
		add_image_size( 'listingpro-list-thumb',287, 190, true ); // (cropped)		
		add_image_size( 'listingpro-author-thumb',63, 63, true ); // (cropped)		
		add_image_size( 'listingpro-gallery-thumb1',458, 425, true ); // (cropped)		
		add_image_size( 'listingpro-gallery-thumb2',360, 198, true ); // (cropped)		
		add_image_size( 'listingpro-gallery-thumb3',263, 198, true ); // (cropped)		
		add_image_size( 'listingpro-gallery-thumb4',653, 199, true ); // (cropped)
		
		add_image_size( 'listingpro-detail_gallery',383, 454, true ); // (cropped)
		
		add_image_size( 'listingpro-checkout-listing-thumb',220, 80, true ); // (cropped)	
		add_image_size( 'listingpro-review-gallery-thumb',184, 135, true ); // (cropped)
		add_image_size( 'listingpro-thumb4',272, 300, true ); // (cropped)
		
		//for location
		add_image_size( 'listingpro_location270_400',270, 400, true ); // (cropped)
		add_image_size( 'listingpro_location570_455',570, 455, true ); // (cropped)
		add_image_size( 'listingpro_location570_228',570, 228, true ); // (cropped)
		add_image_size( 'listingpro_location270_197',270, 197, true ); // (cropped)
		
		add_image_size( 'listingpro_cats270_213',270, 213, true ); // (cropped) 
		
        add_image_size( 'listingpro_cats270_150',270, 150, true ); // (cropped)
        add_image_size( 'listingpro_liststyle181_172',190, 146, true ); // (cropped)
        // v2
        add_image_size( 'lp-sidebar-thumb-v2', 84, 84, true );



		
	}
	
	if ( ! isset( $content_width ) ) $content_width = 900;
	/* ============== Dynamic options and Styling ============ */
	require_once THEME_PATH . '/include/dynamic-options.php';
	
	/* ============== Breadcrumb ============ */
	require_once THEME_PATH . '/templates/breadcrumb.php';
	
	/* ============== Blog Comments ============ */
	require_once THEME_PATH . '/templates/blog-comments.php';	

	/* ============== Required Plugins ============ */
	require_once THEME_PATH . "/include/plugins/install-plugin.php";
	
	/* ============== icons ============ */
	require_once THEME_PATH . "/include/icons.php";
	
	/* ============== List confirmation ============ */
	require_once THEME_PATH . "/include/list-confirmation.php";
	
	/* ============== Login/Register ============ */
	require_once THEME_PATH . "/include/login-register.php";
	
	/* ============== Search Filter ============ */
	require_once THEME_PATH . "/include/search-filter.php";
	
	/* ============== Claim List ============ */
	require_once THEME_PATH . "/include/single-ajax.php";
	
	/* ============== Social Share ============ */
	require_once THEME_PATH . "/include/social-share.php";
	
	/* ============== Ratings ============ */
	require_once THEME_PATH . "/include/reviews/ratings.php";
	
	/* ============== Last Review ============ */
	require_once THEME_PATH . "/include/reviews/last-review.php";
	
	/* ============== Check Time status ============ */
	require_once THEME_PATH . "/include/time-status.php";
	
	/* ============== Banner Catss ============ */
	require_once THEME_PATH . "/include/banner-cats.php";
	
	/* ============== Fav Function ============ */
	require_once THEME_PATH . "/include/favorite-function.php";
	
	/* ============== Live Chat ============ */
	
	/* ============== listing Widgets ============ */
	require_once THEME_PATH . "/include/widgets/widget_most_viewed.php";
	require_once THEME_PATH . "/include/widgets/widget_ads_listing.php";
	require_once THEME_PATH . "/include/widgets/widget_nearby_listing.php";
	require_once THEME_PATH . "/include/widgets/contact_widget.php";
	require_once THEME_PATH . "/include/widgets/category_widget.php";
	require_once THEME_PATH . "/include/widgets/recent_posts_widget.php";
    require_once THEME_PATH . "/include/widgets/social_widget.php";

	/* ============== Reviews Form ============ */
	require_once THEME_PATH . "/include/reviews/reviews-form.php";
	
	/* ============== all reviews ============ */
	require_once THEME_PATH . "/include/reviews/all-reviews.php";
	
	/* ============== review-submit ============ */
	require_once THEME_PATH . "/include/reviews/review-submit.php";
	
	/* ============== all reviews ============ */
	require_once THEME_PATH . "/include/all-extra-fields.php";
	
	
		/* ============== listing campaign save  ============ */
	require_once THEME_PATH . "/include/paypal/campaign-save.php";
	
	/* ============== invoice function ============ */
	require_once THEME_PATH . "/include/invoices/invoice-functions.php";
	
	require_once THEME_PATH . "/include/invoices/invoice-modal.php";
	
	
	/* ============== Approve review ============ */
	require_once THEME_PATH . "/include/reviews/approve-review.php";
	
	/* ============== setup wizard =============== */
	require_once THEME_PATH . "/include/setup/envato_setup.php";
	//importer
	require_once THEME_PATH . "/include/setup/importer/init.php";
	
	/* ============== listing data db save ============ */
	require_once THEME_PATH . "/include/listingdata_db_save.php";
	
	/* ============== listing home map  ============ */
	require_once THEME_PATH . "/include/home_map.php";
	
	/* ============== listing stripe ajax  ============ */

	require_once THEME_PATH . "/include/stripe/stripe-ajax.php";

	/* ============== 2checkout ajax payment  ============ */

	require_once THEME_PATH . "/include/2checkout/payment.php";
	require_once THEME_PATH . "/include/2checkout/payment-campaigns.php";
	
	
	/* ============== ListingPro Style Load ============ */
	add_action('wp_enqueue_scripts', 'listingpro_style');
	function listingpro_style() {

		wp_enqueue_style('bootstrap', THEME_DIR . '/assets/lib/bootstrap/css/bootstrap.min.css');
		wp_enqueue_style('Magnific-Popup', THEME_DIR . '/assets/lib/Magnific-Popup-master/magnific-popup.css');
		wp_enqueue_style('popup-component', THEME_DIR . '/assets/lib/popup/css/component.css');
		wp_enqueue_style('Font-awesome', THEME_DIR . '/assets/lib/font-awesome/css/font-awesome.min.css');
		wp_enqueue_style('Mmenu', THEME_DIR . '/assets/lib/jquerym.menu/css/jquery.mmenu.all.css');
		wp_enqueue_style('MapBox', THEME_DIR . '/assets/css/mapbox.css');
		wp_enqueue_style('Chosen', THEME_DIR . '/assets/lib/chosen/chosen.css');
        wp_enqueue_style('bootstrap-datetimepicker-css', THEME_DIR .'/assets/css/bootstrap-datetimepicker.min.css');
		
		global $listingpro_options;
		$app_view_home  =   $listingpro_options['app_view_home'];
		$app_view_home  =   url_to_postid( $app_view_home );
		if(is_page( $app_view_home ) || is_singular('listing') || (is_front_page()) ||  is_tax( 'listing-category' ) || is_tax( 'features' ) || is_tax( 'location' ) || ( is_search()  && isset( $_GET['post_type'] )  && $_GET['post_type'] == 'listing' ) || is_author() ){
			   wp_enqueue_style('Slick-css', THEME_DIR . '/assets/lib/slick/slick.css');
			   wp_enqueue_style('Slick-theme', THEME_DIR . '/assets/lib/slick/slick-theme.css');
			   wp_enqueue_style('css-prettyphoto', THEME_DIR . '/assets/css/prettyphoto.css');
		}
		
		if(!is_front_page()){
			wp_enqueue_style('jquery-ui', THEME_DIR . '/assets/css/jquery-ui.css');
		}
		wp_enqueue_style('icon8', THEME_DIR . '/assets/lib/icon8/styles.min.css');
		wp_enqueue_style('Color', THEME_DIR . '/assets/css/colors.css');
		wp_enqueue_style('custom-font', THEME_DIR . '/assets/css/font.css');		
		wp_enqueue_style('Main', THEME_DIR . '/assets/css/main.css');
		wp_enqueue_style('Responsive', THEME_DIR . '/assets/css/responsive.css');
		/* by haroon */
		wp_enqueue_style('select2', THEME_DIR . '/assets/css/select2.css');
		/* end by haroon */
		/* for location */
		wp_enqueue_style('dynamiclocation', THEME_DIR . '/assets/css/city-autocomplete.css');
		wp_enqueue_style('lp-body-overlay', THEME_DIR . '/assets/css/common.loading.css');
		/* end for location */
		
		//if(is_archive()){
			wp_enqueue_style('bootstrapslider', THEME_DIR . '/assets/lib/bootstrap/css/bootstrap-slider.css');
		//}
		
		wp_enqueue_style('mourisjs', THEME_DIR . '/assets/css/morris.css');

		wp_enqueue_style('listingpro', STYLESHEET_DIR . '/style.css');
		
	}
	

	/* ============== ListingPro Script Load ============ */

	add_action('wp_enqueue_scripts', 'listingpro_scripts');

	function listingpro_scripts() {
		
		
		global $listingpro_options;
		
		wp_enqueue_script('Mapbox', THEME_DIR . '/assets/js/mapbox.js', 'jquery', '', true);
		wp_enqueue_script('Mapbox-leaflet', THEME_DIR . '/assets/js/leaflet.markercluster.js', 'jquery', '', true);

		//wp_enqueue_script('Build', THEME_DIR . '/assets/js/build.min.js', 'jquery', '', true);
		
		wp_enqueue_script('Chosen',THEME_DIR. '/assets/lib/chosen/chosen.jquery.js', 'jquery', '', true);	
		
		wp_enqueue_script('bootstrap', THEME_DIR . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
		
		wp_enqueue_script('Mmenu', THEME_DIR . '/assets/lib/jquerym.menu/js/jquery.mmenu.min.all.js', 'jquery', '', true);
		
		wp_enqueue_script('magnific-popup', THEME_DIR . '/assets/lib/Magnific-Popup-master/jquery.magnific-popup.min.js', 'jquery', '', true);
		
		wp_enqueue_script('select2', THEME_DIR . '/assets/js/select2.full.min.js', 'jquery', '', true);	
		
		wp_enqueue_script('popup-classie', THEME_DIR . '/assets/lib/popup/js/classie.js', 'jquery', '', true);
		
		wp_enqueue_script('modalEffects', THEME_DIR. '/assets/lib/popup/js/modalEffects.js', 'jquery', '', true);		
		wp_enqueue_script('2checkout', THEME_DIR. '/assets/js/2co.min.js', 'jquery', '', true);
        wp_enqueue_script( 'bootstrap-moment', THEME_DIR. '/assets/js/moment.js', 'jquery','', true );
		wp_enqueue_script( 'bootstrap-datetimepicker', THEME_DIR. '/assets/js/bootstrap-datetimepicker.min.js', 'jquery', '', true );

        if(class_exists('Redux')){
			$mapAPI = '';
			$mapAPI = $listingpro_options['google_map_api'];
			if(empty($mapAPI)){
				$mapAPI = 'AIzaSyDQIbsz2wFeL42Dp9KaL4o4cJKJu4r8Tvg';
			}
			wp_enqueue_script('mapsjs', 'https://maps.googleapis.com/maps/api/js?key='.$mapAPI.'&libraries=places', 'jquery', '', false);	
		}
		if(!is_front_page()){
			wp_enqueue_script('pagination', THEME_DIR . '/assets/js/pagination.js', 'jquery', '', true);
		}
		/* IF ie9 */
			wp_enqueue_script('html5shim', 'https://html5shim.googlecode.com/svn/trunk/html5.js', array(), '1.0.0', true);
			wp_script_add_data( 'html5shim', 'conditional', 'lt IE 9' );
			
			wp_enqueue_script('nicescroll', THEME_DIR. '/assets/js/jquery.nicescroll.min.js', 'jquery', '', true);
			wp_enqueue_script('chosen-jquery', THEME_DIR . '/assets/js/chosen.jquery.min.js', 'jquery', '', true);
			wp_enqueue_script('jquery-ui',THEME_DIR . '/assets/js/jquery-ui.js', 'jquery', '', true);
		if(is_page_template( 'template-dashboard.php' )){
			wp_enqueue_script('bootstrap-rating', THEME_DIR . '/assets/js/bootstrap-rating.js', 'jquery', '', true);
		}
		wp_enqueue_script('droppin', THEME_DIR. '/assets/js/drop-pin.js', 'jquery', '', true);
		if(is_singular('listing') || is_singular('events') ) {
			wp_enqueue_script( 'singlemap', THEME_DIR . '/assets/js/singlepostmap.js', 'jquery', '', true );
		}
		if(is_singular('listing')){
			wp_enqueue_script('socialshare', THEME_DIR . '/assets/js/social-share.js', 'jquery', '', true);
			wp_enqueue_script('jquery-prettyPhoto', THEME_DIR. '/assets/js/jquery.prettyPhoto.js', 'jquery', '', true);
			wp_enqueue_script('bootstrap-rating', THEME_DIR . '/assets/js/bootstrap-rating.js', 'jquery', '', true);
			wp_enqueue_script('Slick', THEME_DIR . '/assets/lib/slick/slick.min.js', 'jquery', '', true);
		}
		if( is_author() )
		{
            wp_enqueue_script('jquery-prettyPhoto', THEME_DIR. '/assets/js/jquery.prettyPhoto.js', 'jquery', '', true);
        }
		/* ==============start add by sajid ============ */
		global $listingpro_options;
		$app_view_home  =   $listingpro_options['app_view_home'];
		$app_view_home  =   url_to_postid( $app_view_home );
		if(is_page( $app_view_home ) || is_author() || is_tax( 'location' ) || (is_front_page()) || is_tax( 'listing-category' ) || is_tax( 'features' ) || (
				is_search()
				&& isset( $_GET['post_type'] )
				&& $_GET['post_type'] == 'listing'
		) ){
		wp_enqueue_script('Slick', THEME_DIR . '/assets/lib/slick/slick.min.js', 'jquery', '', true);
		}
		/* ==============end add by sajid ============ */
		wp_enqueue_script('dyn-location-js', THEME_DIR . '/assets/js/jquery.city-autocomplete.js', 'jquery', '', true);
		//if(is_archive()){
			wp_enqueue_script('bootstrapsliderjs', THEME_DIR . '/assets/lib/bootstrap/js/bootstrap-slider.js', 'jquery', '', true);
		//}
		
		
		wp_register_script( 'lp-icons-colors', THEME_DIR. '/assets/js/lp-iconcolor.js' , 'jquery', '', true );
		wp_enqueue_script( 'lp-icons-colors' );
		
		wp_register_script( 'lp-current-loc', THEME_DIR. '/assets/js/lp-gps.js' , 'jquery', '', true );
		wp_enqueue_script( 'lp-current-loc' );
		
		wp_enqueue_script('Pricing', THEME_DIR. '/assets/js/pricing.js', 'jquery', '', true);
		
		wp_register_script( 'raphelmin', THEME_DIR .'/assets/js/raphael-min.js','jquery', '', false );
		wp_enqueue_script( 'raphelmin' );

		wp_register_script( 'morisjs', THEME_DIR .'/assets/js/morris.js','jquery', '', false );
		wp_enqueue_script( 'morisjs' );

		wp_enqueue_script('Main', THEME_DIR. '/assets/js/main.js', 'jquery', '', true);
		
		if ( is_singular('post') && comments_open() ) wp_enqueue_script( 'comment-reply' );

	}
	
	add_action( 'lp_pdf_enqueue_scripts', 'lp_pdffiles_include_action' );
	if(!function_exists('lp_pdffiles_include_action')){
		function lp_pdffiles_include_action() {
			wp_register_script( 'lp-pdflib', THEME_DIR. '/assets/js/jspdf.min.js' , 'jquery', '', true );
			wp_register_script( 'lp-pdffunc', THEME_DIR. '/assets/js/pdf-function.js' , 'jquery', '', true );
			wp_enqueue_script( 'lp-pdflib' );
			wp_enqueue_script( 'lp-pdffunc' );
		}
	}
	
	/* ============== ListingPro Stripe JS ============ */
	add_filter( 'wp_enqueue_scripts', 'listingpro_stripeJsfile', 0 );
	if(!function_exists('listingpro_stripeJsfile')){
		function listingpro_stripeJsfile(){

				wp_enqueue_script('stripejs', THEME_DIR . '/assets/js/checkout.js', 'jquery', '', false);
			
		}
	}
	
	


	/* ============== ListingPro Options ============ */

	if ( !isset( $listingpro_options ) && file_exists( dirname( __FILE__ ) . '/include/options-config.php' ) ) {
		require_once( dirname( __FILE__ ) . '/include/options-config.php' );
	}
	
	
	
	/* ============== ListingPro Load media ============ */
	if ( ! function_exists( 'listingpro_load_media' ) ) {
		function listingpro_load_media() {
		  wp_enqueue_media();
		}
		
	}	
	add_action( 'admin_enqueue_scripts', 'listingpro_load_media' );
	
		if ( ! function_exists( 'listingpro_admin_css' ) ) {
			function listingpro_admin_css() {
			  wp_enqueue_style('adminpages-css', THEME_DIR . '/assets/css/admin-style.css');
			}
			
		}	
		add_action( 'admin_enqueue_scripts', 'listingpro_admin_css' );
	
	
	/* ============== ListingPro Author Contact meta ============ */
	if ( ! function_exists( 'listingpro_author_meta' ) ) {
		function listingpro_author_meta( $contactmethods ) {

			// Add telefone
			$contactmethods['phone'] = 'Phone';
			// add address
			$contactmethods['address'] = 'Address';
			// add Social
			$contactmethods['facebook'] = 'Facebook';
			$contactmethods['google'] = 'Google';
			$contactmethods['linkedin'] = 'Linkedin';
			$contactmethods['instagram'] = 'Instagram';
			$contactmethods['twitter'] = 'Twitter';
			$contactmethods['pinterest'] = 'Pinterest';
		 
			return $contactmethods;
			
		}
		add_filter('user_contactmethods','listingpro_author_meta',10,1);
	}	
	
	
	

	
	/* ============== ListingPro User avatar URL ============ */
	
	if ( ! function_exists( 'listingpro_get_avatar_url' ) ) {
		function listingpro_get_avatar_url($author_id, $size){
			$get_avatar = get_avatar( $author_id, $size );
			preg_match("/src='(.*?)'/i", $get_avatar, $matches);
			if(!empty($matches)){
				if (array_key_exists("1", $matches)) {
					return ( $matches[1] );
				}
			}
		}
	}
	
	/* ============== ListingPro Author image ============ */
	
	if (!function_exists('listingpro_author_image')) {

		function listingpro_author_image() {
							 
			if(is_user_logged_in()){
				
				$current_user = wp_get_current_user();
	
				$author_avatar_url = get_user_meta($current_user->ID, "listingpro_author_img_url", true); 

				if(!empty($author_avatar_url)) {

					$avatar =  $author_avatar_url;

				} else { 			

					$avatar_url = listingpro_get_avatar_url ( $current_user->ID, $size = '94' );
					$avatar =  $avatar_url;

				}
			}

				 
			return $avatar;
			
		}

	}
	
	
	/* ============== ListingPro Single Author image ============ */
	
	if (!function_exists('listingpro_single_author_image')) {

		function listingpro_single_author_image() {
							 
			if(is_single()){
				
				$author_avatar_url = get_user_meta(get_the_author_meta('ID'), "listingpro_author_img_url", true); 

				if(!empty($author_avatar_url)) {

					$avatar =  $author_avatar_url;

				} else { 			

					$avatar_url = listingpro_get_avatar_url ( get_the_author_meta('ID'), $size = '94' );
					$avatar =  $avatar_url;

				}
			}

				 
			return $avatar;
			
		}

	}
	
	
	
	
	/* ============== ListingPro Subscriber can upload media ============ */
	
	if ( ! function_exists( 'listingpro_subscriber_capabilities' ) ) {
		
		if ( current_user_can('subscriber')) {
			add_action('init', 'listingpro_subscriber_capabilities');
		}
		
		function listingpro_subscriber_capabilities() {
			//if (!is_admin()) {
			$contributor = get_role('subscriber');
			$contributor->add_cap('upload_files');
			$contributor->add_cap('edit_posts');
			$contributor->add_cap('assign_location');
			$contributor->add_cap('assign_list-tags');
			$contributor->add_cap('assign_listing-category');
			$contributor->add_cap('assign_features');
			
			  show_admin_bar(false);
		
			//}
		}
		
	}
	if ( ! function_exists( 'listingpro_admin_capabilities' ) ) {
		
		add_action('init', 'listingpro_admin_capabilities');
		
		function listingpro_admin_capabilities() {
			$contributor = get_role('administrator');
			$contributor->add_cap('assign_location');
			$contributor->add_cap('assign_list-tags');
			$contributor->add_cap('assign_listing-category');
			$contributor->add_cap('assign_features');
		}
		
	}
	
	
	if( !function_exists('listingpro_vcSetAsTheme') ) {
		add_action('vc_before_init', 'listingpro_vcSetAsTheme');
		function listingpro_vcSetAsTheme()
		{
			vc_set_as_theme($disable_updater = false);
		}
	}  
	
	/* ============== ListingPro Block admin acccess ============ */
	if ( !function_exists( 'listingpro_block_admin_access' ) ) {

		add_action( 'init', 'listingpro_block_admin_access' );

		function listingpro_block_admin_access() {
			if( is_user_logged_in() ) {
				
				
					
				if(is_multisite() ) {
					
					if (is_admin() && !current_user_can('administrator')  && isset( $_GET['action'] ) != 'delete' && !(defined('DOING_AJAX') && DOING_AJAX)) {
						wp_die(esc_html__("You don't have permission to access this page.", "listingpro"));
						exit;
					}
				
				}else{
					
					if (is_admin() && current_user_can('subscriber')  && isset( $_GET['action'] ) != 'delete' && !(defined('DOING_AJAX') && DOING_AJAX)) {
						wp_die(esc_html__("You don't have permission to access this page.", "listingpro"));
						exit;
					}
				}			
			}
		}
	}
	
	
	
	/* ============== ListingPro Media Uploader ============ */
	
	if ( ! function_exists( 'listingpro_add_media_upload_scripts' ) ) {

		function listingpro_add_media_upload_scripts() {
			if ( is_admin() ) {
				 return;
			   }
			wp_enqueue_media();
		}
		//add_action('wp_enqueue_scripts', 'listingpro_add_media_upload_scripts');
		
	}


	/* ============== ListingPro Search Form ============ */
	
	if ( ! function_exists( 'listingpro_search_form' ) ) {

		function listingpro_search_form() {

			$form = '<form role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '" >
			<div class="input">
				<i class="icon-search"></i><input class="" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Type and hit enter', 'listingpro') . '">
			</div>
			</form>';

			return $form;
		}
	}

	add_filter('get_search_form', 'listingpro_search_form');
	
	
	/* ============== ListingPro Favicon ============ */
	
	if ( ! function_exists( 'listingpro_favicon' ) ) {

		function listingpro_favicon() {
			global $listingpro_options;
		   if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

			   if($listingpro_options['theme_favicon'] != ''){
					
					echo '<link rel="shortcut icon" href="' . wp_kses_post($listingpro_options['theme_favicon']['url']) . '"/>';
				} else {
					echo '<link rel="shortcut icon" href="' . THEME_DIR . '/assets/img/favicon.ico"/>';
				}
			}
			
		}
	}

	
	
	/* ============== ListingPro Top bar menu ============ */
	
	if (!function_exists('listingpro_top_bar_menu')) {

		function listingpro_top_bar_menu() {
			$defaults = array(
				'theme_location'  => 'top_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'lp-topbar-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'top_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}
	
	/* ============== ListingPro Primary menu ============ */
	
	if (!function_exists('listingpro_primary_menu')) {

		function listingpro_primary_menu() {
			$defaults = array(
				'theme_location'  => 'primary',
				'menu'            => '',
				'container'       => 'div',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => false,				
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'primary' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}
	
	
	/* ============== ListingPro Inner pages menu ============ */
	
	if (!function_exists('listingpro_inner_menu')) {

		function listingpro_inner_menu() {
			$defaults = array(
				'theme_location'  => 'primary_inner',
				'menu'            => '',
				'container'       => 'div',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => false,				
				'items_wrap'      => '<ul id="%1$s" class="inner_menu %2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'primary_inner' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}
	
	/* ============== ListingPro Footer menu ============ */
	
	if (!function_exists('listingpro_footer_menu')) {

		function listingpro_footer_menu() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'footer-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}
	

    /* ============== ListingPro partypro category menu ============ */

    if (!function_exists('listingpro_pp_cat_menu')) {

        function listingpro_pp_cat_menu() {
            $defaults = array(
                'theme_location'  => 'pp_cat_menu',
                'menu'            => '',
                'container'       => 'false',
                'menu_class'      => '',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker' => new Nav_Bigmenu_Walker()
            );

            if ( has_nav_menu( 'pp_cat_menu' ) ) {
                return wp_nav_menu( $defaults );
            }
        }

    }



class Nav_Bigmenu_Walker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        if( $depth == 0 )
        {
            $classes[] = 'col-md-4';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $cat_icon   =   '';
        if( $item->type == 'taxonomy' && $item->object == 'listing-category' )
        {
            $cat_icon = listing_get_tax_meta($item->object_id,'category','image');
        }
        // Check our custom has_children property.
        if ( $args->has_children ) {
            $attributes .= ' class="menu parent"';
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        if( $cat_icon != '' && $depth == 0 )
        {
            $item_output .=   '<img src="'. $cat_icon .'">';
        }
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

}


	/* ==============start add by sajid ============ */
	if (!function_exists('listingpro_footer_menu_app')) {

		function listingpro_footer_menu_app() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}
	}
	
	/* ==============end add by sajid ============ */
	
	/* ============== ListingPro Mobile menu ============ */
	
	if (!function_exists('listingpro_mobile_menu')) {

		function listingpro_mobile_menu() {
			$defaults = array(
				'theme_location'  => 'mobile_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'mobile-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'mobile_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}
	
	/* ============== ListingPro Default sidebar ============ */

	if (!function_exists('listingpro_sidebar')) {

		function listingpro_sidebar() {
			global $listingpro_options;
			$footer_style = '';
			if(isset($listingpro_options['footer_style'])){
				$footer_style = $listingpro_options['footer_style'];
			}
			
			register_sidebar(array(
				'name' => 'Default sidebar',
				'id' => 'default-sidebar',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<div class="imo-widget-title-container"><h2 class="widget-title">',
				'after_title' => '</h2></div>',
			));
			register_sidebar(array(
				'name' => 'Listing Detail sidebar',
				'id' => 'listing_detail_sidebar',
				'before_widget' => '<div class="widget-box viewed-listing %2$s" id="%1$s">',
				'after_widget' => '</div>',
				'before_title' => '<h2>',
				'after_title' => '</h2>',
			));
            register_sidebar(array(
                'name' => 'Listing Archive sidebar',
                'id' => 'listing_archive_sidebar',
                'before_widget' => '<div class="widget-box viewed-listing %2$s" id="%1$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2>',
                'after_title' => '</h2>',
            ));
			/* ============== shaoib start ============ */
			
			//if($footer_style == 'footer2'){
                global $listingpro_options;
				if(isset($listingpro_options) && !empty($listingpro_options)){
                $grid = $listingpro_options['footer_layout'] !="" ? $listingpro_options['footer_layout'] : '2-2-2-2-2-2';
				
					$i = 1;
					foreach (explode('-', $grid) as $g) {
						register_sidebar(array(
							'name' => esc_html__("Footer sidebar ", "listingpro") . $i,
							'id' => "footer-sidebar-$i",
							'description' => esc_html__('The footer sidebar widget area', 'listingpro'),
							'before_widget' => '<aside class="widget widgets %2$s" id="%1$s">',
							'after_widget' => '</aside>',
							'before_title' => '<div class="widget-title"><h2>',
							'after_title' => '</h2></div>',
							
						));
						$i++;
					}
				}
			/* ============== shoaib end ============ */	
				
		}

	}
	add_action('widgets_init', 'listingpro_sidebar');
	
	/* ============== ListingPro Primary Logo ============ */
	
	if (!function_exists('listingpro_primary_logo')) {

		function listingpro_primary_logo() {
			
			global $listingpro_options;
			$lp_logo = $listingpro_options['primary_logo']['url'];
			if(!empty($lp_logo)){
				echo '<img src="'.$lp_logo.'" alt="" />';
			}
			
		}

	}
	
	
	/* ============== ListingPro Seconday Logo ============ */
	
	if (!function_exists('listingpro_secondary_logo')) {

		function listingpro_secondary_logo() {
			
			global $listingpro_options;
			$lp_logo2 = $listingpro_options['seconday_logo']['url'];
			if(!empty($lp_logo2)){
				echo '<img src="'.$lp_logo2.'" alt="" />';
			}
			
		}

	}
	
	

	/* ============== ListingPro URL Settings ============ */
	
	if (!function_exists('listingpro_url')) {

		function listingpro_url($link) {
			global $listingpro_options;
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
				if($link == 'add_listing_url_mode'){
					//$url = $listingpro_options[$link];
					$paidmode = $listingpro_options['enable_paid_submission'];
					if( $paidmode=="per_listing" || $paidmode=="membership" ){
						$url = $listingpro_options['pricing-plan'];
					}else{
						$url = $listingpro_options['submit-listing'];
					}
				}else{
					$url = $listingpro_options[$link];
				}
				
				/* for wpml compatibility */
				if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
				  $url = $url.'?lang='.ICL_LANGUAGE_CODE;
				}

				return $url;
			}else{
				return false;
			}
		}

	}
	
	
	
	/* ============== ListingPro translation ============ */
	
	if (!function_exists('listingpro_translation')) {

		function listingpro_translation($word) {
			
			
				return $word;
					
		}
	}


	
	/* ============== ListingPro filter page pagination ============ */
	
	if (!function_exists('listingpro_load_more_filter')) {

		function listingpro_load_more_filter($my_query, $pageno=null, $sKeyword='') {
			
			$output = '';
			$pages = '';
			$pages = $my_query->max_num_pages;
			$totalpages = $pages;
			$ajax_pagin_classes =   'pagination lp-filter-pagination-ajx';
			if( is_author() )
			{
                $ajax_pagin_classes =   '';
            }
			if(!empty($pages) && $pages>1){
				$output .='<div class="lp-pagination '. $ajax_pagin_classes .'">';
				$output .='<ul class="page-numbers">';
				$n=1;
				$flagAt = 7;
				$flagAt2 = 7;
				$flagOn = 0;
				while($pages > 0){
					
					if(isset($pageno) && !empty($pageno)){
						
						if(!empty($totalpages) && $totalpages<7){
							if($pageno==$n){
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink current">'.$n.'</span></li>';
							}
							else{
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
							}
						}
						elseif(!empty($totalpages) && $totalpages>6){
							$flagOn = $pageno - 5;
							$flagOn2 = $pageno + 7;
							if($pageno==$n){
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink current">'.$n.'</span></li>';
							}
							else{
								if($n<=4){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
								}
								
								elseif($n > 4 && $flagAt2==7){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
									$output .='<li><span data-skeyword="'.$sKeyword.'"  class="page-numbers">...</span></li>';
									$flagAt2=1;
									
								}
								elseif($n > 4  && $n >=$flagOn && $n<$flagOn2){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
									
								}
								elseif($n == $totalpages){
									$output .='<li><span data-skeyword="'.$sKeyword.'" class="page-numbers">...</span></li>';
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
									
								}
								
							}
							
						}
						
						
					}
					else{
						
						if($n==1){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers  haspaglink current">'.$n.'</span></li>';
						}
						else if( $n<7 ){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
						}
						
						else if( $n>7 && $pages>7 && $flagAt==7 ){
							$output .='<li><span  class="page-numbers">...</span></li>';
							$flagAt = 1;
						}
						
						else if( $n>7 && $pages<7 && $flagAt==1 ){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
						}
						
					}
					
					$pages--;
					$n++;
					$output .='</li>';
				}
				$output .='</ul>';
				$output .='</div>';
			}
			
			
			return $output;
		}
		
	}
	
	
	/* ============== ListingPro Infinite load ============ */
	
	if (!function_exists('listingpro_load_more')) {

		function listingpro_load_more($wp_query) {		
			$pages = $wp_query->max_num_pages;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			if (empty($pages)) {
				$pages = 1;
			}

			if (1 != $pages) {

				$big = 9999; // need an unlikely integer
				echo "
				<div class='lp-pagination pagination lp-filter-pagination'>";

					$pagination = paginate_links(
					array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'end_size' => 3,
						'mid_size' => 6,
						'format' => '?paged=%#%',
						'current' => max(1, get_query_var('paged')),
						'total' => $wp_query->max_num_pages,
						'type' => 'list',
						'prev_text' => __('&laquo;', 'listingpro'),
						'next_text' => __('&raquo;', 'listingpro'),
					));
					print $pagination;
				echo "</div>";
			}
		}
		
	}
	
	
	/* ============== ListingPro Icon8 base64 Icons ============ */
	
	if (!function_exists('listingpro_icons')) {

		function listingpro_icons($icons) {
			$colors = new listingproIcons();
			$icon = '';
			if($icons != ''){
				$iconsrc = $colors->listingpro_icon($icons);	
				$icon = '<img class="icon icons8-'.$icons.'" src="'.$iconsrc.'" alt="'.$icons.'">';
				return $icon;
			}else{
				return $icon;
			}
		}
	}
	
	/* ============== ListingPro Icon8 base64 Icons url ============ */
	
	if (!function_exists('listingpro_icons_url')) {
		function listingpro_icons_url($icons) {
			$colors = new listingproIcons();
			$icon = '';
			if($icons != ''){
				$iconsrc = $colors->listingpro_icon($icons);	
				return $iconsrc;
			}else{
				return $iconsrc;
			}
		}
	}
	
	
	/* ============== ListingPro Search Filter ============ */
	
	if (!function_exists('listingpro_searchFilter')) {
		
		
		function listingpro_searchFilter() {
			global $wp_post_types;
			$wp_post_types['page']->exclude_from_search = true;
		}
		add_action('init', 'listingpro_searchFilter');
		
	}
	

	/* ============== ListingPro Price Dynesty Text============ */
	
	if (!function_exists('listingpro_price_dynesty_text')) {
		function listingpro_price_dynesty_text($postid) {
			$output = null;
			if(!empty($postid)){
				$priceRange = listing_get_metabox_by_ID('price_status', $postid);
				//$listingptext = listing_get_metabox('list_price_text');
				$listingprice = listing_get_metabox_by_ID('list_price', $postid);
				if(!empty($priceRange ) && !empty($listingprice )){
					$output .='
					<span class="element-price-range list-style-none">'; 
						$dollars = '';
						$tip = '';
						if( $priceRange == 'notsay' ){
							$dollars = '';
							$tip = '';

						}elseif( $priceRange == 'inexpensive' ){
							$dollars = '1';
							$tip = esc_html__('Inexpensive', 'listingpro');

						}elseif( $priceRange == 'moderate' ){
							$dollars = '2';
							$tip = esc_html__('Moderate', 'listingpro');

						}elseif( $priceRange == 'pricey' ){
							$dollars = '3';
							$tip = esc_html__('Pricey', 'listingpro');

						}elseif( $priceRange == 'ultra_high_end' ){
							$dollars = '4';
							$tip = esc_html__('Ultra High End', 'listingpro');
						}
						global $listingpro_options;
						$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
						if( $priceRange != 'notsay' ){
							$output .= '<span class="grayscale simptip-position-top simptip-movable" data-tooltip="'.$tip.'">';
							for ($i=0; $i < $dollars ; $i++) { 
								$output .= $lp_priceSymbol;
							}
							$output .= '</span>';
							
						}
						$output .= '
					</span>';
				}
			}
			return $output;
		}		
	}
	
	/* ============== ListingPro Price Dynesty ============ */
	
	if (!function_exists('listingpro_price_dynesty')) {
		function listingpro_price_dynesty($postid) {
			if(!empty($postid)){
				$priceRange = listing_get_metabox_by_ID('price_status', $postid);
				$listingpTo = listing_get_metabox('list_price_to');
				$listingprice = listing_get_metabox_by_ID('list_price', $postid);
				if( ($priceRange != 'notsay' && !empty($priceRange)) || !empty($listingpTo) || !empty($listingprice) ){
					?>
					<div class="post-row price-range">
						<ul class="list-style-none post-price-row line-height-16">
					<?php if( $priceRange != 'notsay' && !empty($priceRange) ){ ?>
							<li class="grayscale-dollar">
								<?php 
									$dollars = '';
									$tip = '';
									if( $priceRange == 'notsay' ){
										$dollars = '';
										$tip = '';

									}elseif( $priceRange == 'inexpensive' ){
										$dollars = '1';
										$tip = esc_html__('Inexpensive', 'listingpro');

									}elseif( $priceRange == 'moderate' ){
										$dollars = '2';
										$tip = esc_html__('Moderate', 'listingpro');

									}elseif( $priceRange == 'pricey' ){
										$dollars = '3';
										$tip = esc_html__('Pricey', 'listingpro');

									}elseif( $priceRange == 'ultra_high_end' ){
										$dollars = '4';
										$tip = esc_html__('Ultra High End', 'listingpro');
									}
									
									global $listingpro_options;
									$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
									
										echo '<span class="simptip-position-top simptip-movable" data-tooltip="'.$tip.'">';
											echo '<span class="active">';
											for ($i=0; $i < $dollars ; $i++) { 
												echo wp_kses_post( $lp_priceSymbol );
											}
											echo '</span>';

											echo '<span class="grayscale">';
											$greyDollar = 4 - $dollars;
											for($i=1;$i<=$greyDollar;$i++){
												echo wp_kses_post($lp_priceSymbol);
											}
											echo '</span>';
										echo '</span>';
									
								?>
							</li>
							<?php 
							}
							if(!empty($listingpTo ) || !empty($listingprice )){
							?>
							<li>
								<span class="post-rice">
									<span class="text">
										<?php echo esc_html__('Price Range', 'listingpro'); ?>
									</span>
									<?php
									
										if(!empty($listingprice)){
											echo esc_html($listingprice);
										}
										if(!empty($listingpTo)){
											echo ' - ';
											echo esc_html($listingpTo);
										}
										
										
									?>
								</span>
							</li>
							<?php 
								}
							?>
						</ul>
					</div>
					<?php
				}
			}
		}		
	}
	
	/* ============== ListingPro email and mailer filter ============ */
	add_filter('wp_mail_from', 'listingpro_mail_from');
	add_filter('wp_mail_from_name', 'listingpro_mail_from_name');
	if( !function_exists('listingpro_mail_from') ){ 
		function listingpro_mail_from($old) {
			
			$mailFrom = null;
			if( class_exists( 'Redux' ) ) {
				global $listingpro_options;
				$mailFrom = $listingpro_options['listingpro_general_email_address'];
			}
			else{
				$mailFrom = get_option( 'admin_email' );
			}
			return $mailFrom;
		}
	}
	if( !function_exists('listingpro_mail_from_name') ){
		function listingpro_mail_from_name($old) {
			
			$mailFromName = null;
			if( class_exists( 'Redux' ) ) {
				global $listingpro_options;
				$mailFromName = $listingpro_options['listingpro_general_email_from'];
			}
			else{
				$mailFromName = get_option( 'blogname' );
			}
			return $mailFromName;
		}
	}
	
	/* ============== email html support ============ */
	if( !function_exists('listingpro_set_content_type') ){
		add_filter( 'wp_mail_content_type', 'listingpro_set_content_type' );
		function listingpro_set_content_type( $content_type ) {
			return 'text/html';
		}
	}
	
	/* ==================textarea to editor============= */
	
	if( !function_exists('get_textarea_as_editor') ){
		function get_textarea_as_editor($editor_id, $editor_name, $pcontent){
			$content = $pcontent;
			$settings = array(

			'wpautop' => true,
						'textarea_name' => $editor_name,
			'textarea_rows' => 8,


			'media_buttons' => false,

						'tinymce' => array(
							'theme_advanced_buttons1' => '',
							'theme_advanced_buttons2' => false,
							'theme_advanced_buttons3' => false,
							'theme_advanced_buttons4' => false,
						),

			'quicktags' => false,

			);

			ob_start();
			wp_editor( $content, $editor_id, $settings );
			$output = ob_get_contents();
			ob_end_clean();
			ob_flush();
			return $output;

		}
	}
	
	/* ================= button in editor=========== */
	
	add_filter( 'tiny_mce_before_init', 'lp_format_TinyMCE' );
	if( !function_exists('lp_format_TinyMCE') ){
        function lp_format_TinyMCE( $in ) {
            if(!is_admin()){
                $in['toolbar'] = 'formatselect,|,bold,italic,underline,|,' .
                    'bullist,numlist,blockquote,|,alignjustify' .
                    ',|,link,unlink,|' .
                    ',spellchecker,';
                $in['toolbar1'] = '';
                $in['toolbar2'] = '';
                return $in;
            }else{
                return $in;
            }

        }
    }
	
	/* ============== Listingpro term Exist ============ */	
	
		if(!function_exists('listingpro_term_exist')){
			function listingpro_term_exist($name,$taxonomy){
				$term = term_exists($name, $taxonomy);
				if (!empty($term)) {
				 return $term;
				}else{
					return 0;
				}
			}
		}
	
	
	
	/* ============== Listingpro add new term ============ */	
	
	if(!function_exists('listingpro_insert_term')){
		function listingpro_insert_term($name,$taxonomy){
			if ( ! taxonomy_exists($taxonomy) ){
				return 0;
			}
			else{
				$term = term_exists($name, $taxonomy);
				if (!empty($term)) {
				 return 0;
				}else{
					$loc = wp_insert_term($name, $taxonomy);
					if (is_wp_error($loc )){
						return 0;
					}else{
						return $loc;
					}
				}
			}
		}
	}
	
	/* ============== Listingpro compaigns ============ */	
	if(!function_exists('listingpro_get_campaigns_listing')){
		function listingpro_get_campaigns_listing( $campaign_type, $IDSonly, $taxQuery=array(), $searchQuery=array(),$priceQuery=array(),$s=null, $noOfListings = null, $posts_in = null ){
			
			$Clistingid =   '';
            if( is_singular( 'listing' ) )
            {
               global $post;
               $Clistingid = $post->ID;
			}
			global $listingpro_options;
			$listing_mobile_view = $listingpro_options['single_listing_mobile_view'];
			
			$adsType = array(
			'lp_random_ads',
			'lp_detail_page_ads',
			'lp_top_in_search_page_ads'
			);
			
			global $listingpro_options;	
			$listing_style = '';
			$listing_style = $listingpro_options['listing_style'];
			$postNumber = '';
			if($listing_style == '3' && !is_front_page()){
				if(empty($noOfListings)){
					$postNumber = 2;
				}
				else{
					$postNumber = $noOfListings;
				}
				
			}elseif($listing_style == '4' && !is_front_page()){
				if(empty($noOfListings)){
					$postNumber = 2;
				}
				else{
					$postNumber = $noOfListings;
				}
				
			}else{
				if(empty($noOfListings)){
					$postNumber = 3;
				}
				else{
					$postNumber = $noOfListings;
				}
			}
			
			
			if( !empty($campaign_type) ){
				if( in_array($campaign_type, $adsType, true) ){
					
					$TxQuery = array();
					if( !empty( $taxQuery ) && is_array($taxQuery)){
						$TxQuery = $taxQuery;
					}elseif(!empty($searchQuery) && is_array($searchQuery)){
						$TxQuery = $searchQuery;
					}
					$args = array(
						'orderby' => 'rand',
						'post_type' => 'listing',
						'post_status' => 'publish',
						'posts_per_page' => $postNumber,
						'post__not_in'	=> array($Clistingid),
						'tax_query' => $TxQuery,
						'meta_query' => array(
							'relation'=>'AND',
							array(
								'key'     => 'campaign_status',
								'value'   => array( 'active' ),
								'compare' => 'IN',
							),
							array(
								'key'     => $campaign_type,
								'value'   => array( 'active' ),
								'compare' => 'IN',
							),
							$priceQuery,
						),
					);
					if(!empty($s)){
						$args = array(
							'orderby' => 'rand',
							'post_type' => 'listing',
							'post_status' => 'publish',
							's' => $s,
							'posts_per_page' => $postNumber,
							'tax_query' => $TxQuery,
							'meta_query' => array(
								'relation'=>'AND',
								array(
									'key'     => 'campaign_status',
									'value'   => array( 'active' ),
									'compare' => 'IN',
								),
								array(
									'key'     => $campaign_type,
									'value'   => array( 'active' ),
									'compare' => 'IN',
								),
								$priceQuery,
							),
						);
					}
					
					if(!empty($posts_in)){
						$args['post__in'] = $posts_in;
					}
					
					$idsArray = array();
					$the_query = new WP_Query( $args );
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							if( $IDSonly==TRUE ){
								$idsArray[] =  get_the_ID();
								
							}
							else{
								if(is_singular('listing') ){
									if( $listing_mobile_view == 'app_view' && wp_is_mobile() ) {
										echo  '<div class="row app-view-ads lp-row-app">';
										get_template_part('mobile/listing-loop-app-view');
										echo '</div>';
									}else{
										get_template_part( 'templates/details-page-ads' );
									}
								}
							elseif( ( is_page()  || is_home() || is_singular('post') ) &&  (is_active_sidebar( 'default-sidebar' ) || is_active_sidebar('listing_archive_sidebar') )  ){
									get_template_part( 'templates/details-page-ads' );
								}
								elseif(is_singular( 'post' )){
									get_template_part( 'templates/details-page-ads' );
								}
								else{
									$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
                                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
                                        get_template_part( 'mobile/listing-loop-app-view' );
                                    }else
                                    {
                                        if( isset($GLOBALS['sidebar_add_loop']) && $GLOBALS['sidebar_add_loop'] == 'yes' )
                                       {
                                           get_template_part( 'templates/details-page-ads' );
                                       }
                                       else
                                       {
                                           get_template_part( 'listing-loop' );
                                       }
                                    }
								}
								
							}
							
							wp_reset_postdata();
						}
						if( $IDSonly==TRUE ){
							if(!empty($idsArray)){
								return $idsArray;
							}
						}
				
					}
			
			
			
				}
			}
			
			
		}
	}
	/* ============== Listingpro Sharing ============ */	
	if(!function_exists('listingpro_sharing')){
		function listingpro_sharing() {
			?>
			<a class="reviews-quantity">
				<span class="reviews-stars">
					<i class="fa fa-share-alt"></i>
				</span>
				<?php echo esc_html__('Share', 'listingpro');?>
			</a>
			<div class="md-overlay hide"></div>
			<ul class="social-icons post-socials smenu">
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('facebook'); ?>" target="_blank"><!-- Facebook icon by Icons8 -->
						<i class="fa fa-facebook"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('gplus'); ?>" target="_blank"><!-- Google Plus icon by Icons8 -->
						<i class="fa fa-google-plus"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('twitter'); ?>" target="_blank"><!-- twitter icon by Icons8 -->
						<i class="fa fa-twitter"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('linkedin'); ?>" target="_blank"><!-- linkedin icon by Icons8 -->
						<i class="fa fa-linkedin"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('pinterest'); ?>" target="_blank"><!-- pinterest icon by Icons8 -->
						<i class="fa fa-pinterest"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('reddit'); ?>" target="_blank"><!-- reddit icon by Icons8 -->
						<i class="fa fa-reddit"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('stumbleupon'); ?>" target="_blank"><!-- stumbleupon icon by Icons8 -->
						<i class="fa fa-stumbleupon"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('del'); ?>" target="_blank"><!-- delicious icon by Icons8 -->
						<i class="fa fa-delicious"></i>
					</a>
				</li>
			</ul>
			<?php
		}
	}
	
	
	/* Post Views */

if(!function_exists('getPostViews')){
	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count=='' || $count=='0'){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return esc_html__('0 View', 'listingpro');
	    }else{
			if(!empty($count)){
				if($count=="1"){
					return $count.esc_html__(' View', 'listingpro');
				}
				else{
					return $count.esc_html__(' Views', 'listingpro');
				}
			}
			else{
				return $count.esc_html__('0 View', 'listingpro');
			}
		}
	    
	}
}
 
// function to count views.
if(!function_exists('setPostViews')){
	function setPostViews($postID) {
		$currID = get_current_user_id();
		$authorID = get_post_field('post_author',$postID);
		if($authorID!=$currID){
			$count_key = 'post_views_count';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
				$count = 0;
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
			}else{
				$count++;
				update_post_meta($postID, $count_key, $count);
			}
		}
	}
}

// function to get all post meta value by keys
if(!function_exists('getMetaValuesByKey')){
	function getMetaValuesByKey($key){
		global $wpdb;
		$metaVal = $wpdb->get_col("SELECT meta_value
		FROM $wpdb->postmeta WHERE meta_key = '$key'" );
		return $metaVal;
	}
}

// function to get total views
if(!function_exists('getTotalPostsViews')){
	function getTotalPostsViews(){
		$totalCount = 0;
		$totalArray = getMetaValuesByKey('post_views_count');
		if(!empty($totalArray)){
			foreach( $totalArray as $count ){
				$totalCount = $totalCount + $count;
			}
		}
		return $totalCount;
	}
}

// function to get author listing total views
if(!function_exists('getAuthorPostsViews')){
	function getAuthorPostsViews(){
		$count = 0;
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		
		$args = array(
			'post_type' => 'listing',
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$n = get_post_meta(get_the_ID(), 'post_views_count', true);
				$count = $count + (int)$n;
			}
			wp_reset_postdata();
		}
		return $count;
	}
}

// function to get author listing total reviews
if(!function_exists('getAuthorTotalViews')){
	function getAuthorTotalViews(){
		$count = 0;
		$review_ids = '';
		$result = array();
		$review_new = array();
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$review_ids = array();
		
		$args = array(
			'post_type' => 'listing',
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$key = 'reviews_ids';
				$review_idss = listing_get_metabox_by_ID($key ,get_the_ID());
				
				if( !empty($review_idss) ){
					if (strpos($review_idss, ",") !== false) {
						$review_ids = explode( ',', $review_idss );		
						$result = array_merge($result, $review_ids);
					}
					else{
						$result[] = $review_idss;
					}
					
				}
			}
			wp_reset_postdata();
			$count = $count + count($result);
		}
		return $count;
	}
}

//function to get all reviews in array on author's posts
if(!function_exists('getAllReviewsArray')){
	function getAllReviewsArray($submitted=false){
		$review_ids = '';
		$result = array();
		$review_new = array();
		$review_idss = '';
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		if(!empty($submitted)){
			/* submitted */
			$post_type = "lp-reviews";
		}else{
			/* received */
			$post_type = "lp-reviews";
			$result = array('0'=>0);
			$user_id = '';
		}
		
		$postid = array();
		
		$args = array(
			'post_type' => $post_type,
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$lp_the_query = null;
		$lp_the_query = new WP_Query( $args );
		if ( $lp_the_query->have_posts() ) {
			while ( $lp_the_query->have_posts() ) {
				$lp_the_query->the_post();
				
				if(!empty($submitted)){
					/* submitted */
					$result[get_the_ID()] = get_the_ID();
				}else{
					/* received */
					
					$listing_id = listing_get_metabox_by_ID('listing_id', get_the_ID());
					if(!empty($listing_id)){
						$l_author_id = get_post_field( 'post_author', $listing_id );
						if($l_author_id==get_current_user_id()){
							$result[get_the_ID()] = get_the_ID();
						}
					}
				
					$key = 'reviews_ids';
					
					$review_idss = listing_get_metabox_by_ID($key ,get_the_ID());
					
					if( !empty($review_idss) ){
						if (strpos($review_idss, ",") !== false) {
							$review_ids = explode( ',', $review_idss );		
							$result = array_merge($result, $review_ids);
						}
						else{
							$result[] = $review_idss;
						}
						
					}
				}
				
			}
			wp_reset_postdata();
		}
		return $result;
	}
}


/*========================================get ads invoices list============================================*/
//function to retreive invoices
if(!function_exists('get_ads_invoices_list')){
	function get_ads_invoices_list($userid, $method, $status){
		global $wpdb;
		$prefix = '';
		$prefix = $wpdb->prefix;
		$table_name = $prefix.'listing_campaigns';
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			
			if( empty($userid)  && !empty($method) && !empty($status) && is_admin() ){
				//return on admin side only
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_campaigns WHERE payment_method=%s AND status=%s ORDER BY main_id DESC", $method, $status) 
							 );
				return $results;
			}
			else if( !empty($userid) && isset($userid) && !empty($status)){
				//return for all users by id
				
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_campaigns WHERE user_id=%d AND status=%s ORDER BY main_id DESC", $userid, $status) 
							 );
				return $results;
				
			}
			
		}
	}
}

/*==============================get listing invoices==================================*/
//function to get invoices list
if(!function_exists('get_invoices_list')){
	function get_invoices_list($userid, $method, $status){
		global $wpdb;
		$prefix = '';
		$prefix = $wpdb->prefix;
		$table_name = $prefix.'listing_orders';
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			
			if( empty($userid)  && !empty($method) && !empty($status) && is_admin() ){
				//return on admin side
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_orders WHERE payment_method=%s AND status=%s ORDER BY main_id DESC", $method, $status) 
							 );
				return $results;
			}
			else if( !empty($userid) && isset($userid) && !empty($status) && !is_admin() ){
				//return on front side
				
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_orders WHERE user_id=%d AND status=%s ORDER BY main_id DESC", $userid, $status) 
							 );
				return $results;
				
			}
			
		}
	}
}

/*==============================delete post action==================================*/
// function to delete post action
if(!function_exists('lp_delete_any_post')){
add_action( 'before_delete_post', 'lp_delete_any_post' );
	function lp_delete_any_post( $postid ){
		global $post_type;
		
		if($post_type == 'listing'){
			$listing_id = $postid;
			$campaignID = listing_get_metabox_by_ID('campaign_id', $listing_id);
			$get_reviews = listing_get_metabox_by_ID('reviews_ids', $listing_id);
			
			wp_delete_post($campaignID);
			if(!empty($get_reviews)){
				$reviewsArray = array();
				if (strpos($get_reviews, ',') !== false) {
					$reviewsArray = explode(",",$get_reviews);
				}
				else{
					$reviewsArray[] = $get_reviews;
				}
				$args = array(
					'posts_per_page'      => -1,
					'post__in'            => $reviewsArray,
					'post_type' => 'lp-reviews',
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						wp_delete_post(get_the_ID());
					}
				}
			}
			
			
		}
		else if($post_type == 'lp-reviews'){
			
			$review_id = $postid;
			$action = 'delete';
			$listing_id = listing_get_metabox_by_ID('listing_id', $postid);
			
			listingpro_set_listing_ratings($review_id, $listing_id, '', $action);

		}
		else if($post_type == 'lp-ads'){
			$listing_id = listing_get_metabox_by_ID('ads_listing', $postid);
			$ad_type = listing_get_metabox_by_ID('ad_type', $postid);
			if(!empty($ad_type)&& count($ad_type)>0){
				foreach($ad_type as $type){
					delete_post_meta( $listing_id, $type );
				}
			}
			
			listing_delete_metabox('campaign_id', $listing_id);
			delete_post_meta( $listing_id, 'campaign_status' );
			
		}
		
		
	}
}

//=======================================================
//						Pagination
//=======================================================
if(!function_exists('listingpro_pagination')){

	function listingpro_pagination($wp_query=array()) {
		if(empty($wp_query)){
			global $wp_query;
		}

		$pages = $wp_query->max_num_pages;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if (empty($pages)) {
			$pages = 1;
		}

		if (1 != $pages) {

			$big = 9999; // need an unlikely integer
			echo "
			<div class='lp-pagination pagination'>";
				$pagination = paginate_links(
				array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'end_size' => 3,
					'mid_size' => 6,
					'format' => '?paged=%#%',
					'current' => max(1, get_query_var('paged')),
					'total' => $wp_query->max_num_pages,
					'type' => 'list',
					'prev_text' => __('&laquo;', 'listingpro'),
					'next_text' => __('&raquo;', 'listingpro'),
				));
				print $pagination;
			echo "</div>";
		}
	}
}

//=======================================================
//						Login Screen
//=======================================================
	if(!function_exists('listingpro_login_screen')){
		function listingpro_login_screen() {
			wp_enqueue_style( 'listable-custom-login', get_template_directory_uri() . '/assets/css/login-page.css' );
			wp_enqueue_style('Font-awesome', THEME_DIR . '/assets/lib/font-awesome/css/font-awesome.min.css');
		}

		add_action( 'login_enqueue_scripts', 'listingpro_login_screen' );
	}
/*====================================================================================*/

/*====================================================================================*/
/* calculate average rate for listing */
	if(!function_exists('lp_cal_listing_rate')){
		function lp_cal_listing_rate($listing_id,$post_type = 'listing', $is_reviewcall = false){
			
			global $listingpro_options;
			$reviewEnabled = $listingpro_options['lp_review_switch'];
			
			if($post_type == 'lp_review'){
				$rating = listing_get_metabox_by_ID('rating' ,$listing_id);
			}else{
				$rating = get_post_meta( $listing_id, 'listing_rate', true );
			}
			$ratingRes = '';
			if(!empty($rating) && $rating > 0){
				
				if($rating < 1){
					$ratingRes = '<span class="rate lp-rate-worst">'.$rating.'<sup>/ 5</sup></span>';
				}
				
				else if($rating >=1 && $rating < 2){
					$ratingRes = '<span class="rate lp-rate-bad">'.$rating.'<sup>/ 5</sup></span>';
				}
				
				else if($rating >=2 && $rating < 3.5){
					$ratingRes = '<span class="rate lp-rate-satisfactory">'.$rating.'<sup>/ 5</sup></span>';
				}
				
				else if($rating >=3.5 && $rating <= 5){
					$ratingRes = '<span class="rate lp-rate-good">'.$rating.'<sup>/ 5</sup></span>';
				}
				
			}
			else{
				if (class_exists('ListingReviews')) {
					if ( is_singular('listing') ){
						
						if($is_reviewcall==true){
							$ratingRes = '';
						}
						else{
							if(get_post_status( $listing_id )!='publish'){
								$ratingRes = '<span class="no-review">'.esc_html__("Rating only enabled on published listing", "listingpro").'</span>';
							}
							else{
								if($reviewEnabled=="1"){
									$ratingRes = '<span class="no-review">'.esc_html__("Be the first one to rate!", "listingpro").'</span>';
								}
							}
						}
					}else{
						//$ratingRes = '<span class="no-review">'.esc_html__("0 Review", "listingpro").'</span>';
					}
				}
				
			}
			
			return $ratingRes;
			
		}
	}


/* =============================================== cron-job for renew listing==================================== */
	add_action( 'wp', 'lp_renew_listing_subcription' );
	function lp_renew_listing_subcription() {
		if (! wp_next_scheduled ( 'lp_daily_renew_listing_subcription' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_renew_listing_subcription');
		}
	}
	add_action('lp_daily_renew_listing_subcription', 'lp_renew_this_listing');

	if(!function_exists('lp_renew_this_listing')){
		function lp_renew_this_listing(){
			global $wpdb, $listingpro_options;
			require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
			$strip_sk = $listingpro_options['stripe_secrit_key'];
			\Stripe\Stripe::setApiKey($strip_sk);
			$users = get_users( array( 'fields' => array( 'ID' ) ) );
			foreach($users as $user_id){
				$user_id = $user_id->ID;
				$user_obj = get_user_by('id', $user_id);
				$user_login = $user_obj->user_login;
				$userSubscriptions = '';
				$userSubscriptions = get_user_meta($user_id, 'listingpro_user_sbscr', true);
				if(!empty($userSubscriptions) && count($userSubscriptions)>0 ) {
					$subscription_exist = true;
					$n=1;
					foreach($userSubscriptions as $subscription){
						try {
							$plan_id = $subscription['plan_id'];
							$subscr_id = $subscription['subscr_id'];
							$listing_id = $subscription['listing_id'];
							
							$subscrObj = \Stripe\Subscription::retrieve($subscr_id);
							
							$LpgetStatusListing = get_post_status ( $listing_id );
							if (empty($LpgetStatusListing)) {
								// expire subscription if listing is deleted
								$subscrObj->cancel();
							}

							$subscrID = $subscrObj->id;
							
							$plan_time = get_post_meta($plan_id, 'plan_time', true);
							$plan_time = (int)$plan_time;

							$isActive = true;
							$isCharged = true;
							$isValid = true;
							$Curdifernce = null;

							if(!empty($subscrObj)){
								/* echo '<pre>';
								print_r($subscrObj);
								echo '</pre>'; */
								$subStatus = $subscrObj->plan->active;
								$subEnds = $subscrObj->current_period_end;
								
								if(!empty($subStatus)){
									echo 'active';
									if (date('Y-m-d') == date('Y-m-d', $subEnds)) {
										echo 'today is expiry';
										// is active and today is renewal day
										$lpCurrentTime = current_time('mysql');
										$my_listing = array('ID' => $listing_id, 'post_date' => $lpCurrentTime, 'post_date_gmt' => get_gmt_from_date($lpCurrentTime), 'post_status' => 'publish');
										wp_update_post( $my_listing );

											$table = 'listing_orders';

											$wherecond = 'post_id="'.$listing_id.'" AND status = "success" AND summary="recurring"';
											$recurringData = lp_get_data_from_db('listing_orders', '*', $wherecond);
											if(!empty($recurringData)){
												$main_id = '';
												foreach($recurringData as $data){
													$main_id = $data->main_id;
													$date = date('d-m-Y');
													$data = array('date'=>$date);
													$where = array('main_id'=>$main_id);
													lp_update_data_in_db($table, $data, $where);
												}
											}
									}
								}else{
									// not active
									$my_listing = array('ID' => $listing_id, 'post_status' => 'expired');
									wp_update_post( $my_listing );
								}
								
								

							}

						}
						catch (Exception $e) {

						}

					}
				}
			}

		}
	}

	
	/* =============================================== cron-job for listing==================================== */
	add_action( 'wp', 'lp_expire_listings' );
	function lp_expire_listings() {
		if (! wp_next_scheduled ( 'lp_daily_cron_listing' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_cron_listing');
		}
	}
	add_action('lp_daily_cron_listing', 'lp_expire_this_listing');

	if(!function_exists('lp_expire_this_listing')){
		function lp_expire_this_listing(){
			global $wpdb, $listingpro_options;
			$dbprefix = $wpdb->prefix;
			$uid = get_current_user_id();
			$args=array(
				'post_type' => 'listing',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);
			$wp_query = null;
			$wp_query = new WP_Query($args);
			if( $wp_query->have_posts() ) {
				while ($wp_query->have_posts()) : $wp_query->the_post();
					$listing_id = get_the_ID();
					$checkIfRecurriong = lp_listing_has_subscriptn($listing_id, $uid);
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$plan_price = listing_get_metabox_by_ID('plan_price', $listing_id);
				
					/* attach plan to expiry listing if on from theme option */
					$planAttach = lp_theme_option('lp_assignplanexpirybutton');
					$nplanid = '';
					if($planAttach=="enable"){
						$nplanid = lp_theme_option('lp_plan_after_expire');
					}
					
					if(!empty($plan_id)){
						$plan_duration = get_post_meta($plan_id, 'plan_time', true);
						if(!empty($plan_duration) && empty($checkIfRecurriong)){
							$sql =
								"UPDATE {$wpdb->posts}
								SET post_status = 'expired'
								WHERE (ID = '$listing_id' AND post_type = 'listing' AND post_status = 'publish')
								AND DATEDIFF(NOW(), post_date) >= %d";
							
							$res = $wpdb->query($wpdb->prepare( $sql, $plan_duration ));
							if($res!=false){
								
								if(!empty($nplanid)){
									//assign plan
									listing_set_metabox('Plan_id', $nplanid, $listing_id);
									$plan_price = get_post_meta($nplanid, 'plan_price', true);
									$this_listing = array(
										  'ID'           => $listing_id,
										  'post_status'   => 'publish',
									  );
									wp_update_post($this_listing);
								}
							
								if(!empty($plan_price) && is_numeric($plan_price)){
									/* update in db table */
									$update_data = array('status' => 'in progress');
									$where = array('post_id' => $listing_id);
									$update_format = array('%s');
									$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
									/* update in db table */
								}
							
								$campaign_status = get_post_meta($listing_id, 'campaign_status', true);
								if(!empty($campaign_status)){
									delete_post_meta( $listing_id, 'campaign_status');
								}
								$adID = listing_get_metabox_by_ID('campaign_id', $listing_id);
								if(!empty($adID)){
									wp_delete_post( $adID, true );
								}
							
								$post_author_id = get_post_field( 'post_author', $listing_id );
								$user = get_user_by( 'id', $post_author_id );
								$useremail = $user->user_email;
								$user_name = $user->user_login;

								$website_url = site_url();
								$website_name = get_option('blogname');
								$listing_title = get_the_title($listing_id);
								$listing_url = get_the_permalink($listing_id);
								/* email to user */
								$headers[] = 'Content-Type: text/html; charset=UTF-8';
					
								$u_mail_subject_a = '';
								$u_mail_body_a = '';
								$u_mail_subject = $listingpro_options['listingpro_subject_listing_expired'];
								$u_mail_body = $listingpro_options['listingpro_listing_expired'];
							
								$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
									'website_url' => "$website_url",
									'listing_title' => "$listing_title",
									'listing_url' => "$listing_url",
									'website_name' => "$website_name",
									'user_name' => "$user_name",
								));
							
								$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
									'website_url' => "$website_url",
									'listing_title' => "$listing_title",
									'listing_url' => "$listing_url",
									'user_name' => "$user_name",
									'website_name' => "$website_name"
								));
							
								wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);
							
							}
						}
					}
				endwhile;
			}
		}
	}
		
		
	/* =============================================== if lisitng has subscription========================= */
	
	if(!function_exists('lp_listing_has_subscriptn')){
		function lp_listing_has_subscriptn($listingid, $user_id){
			$userSubscriptions = get_user_meta($user_id, 'listingpro_user_sbscr', true);
			$resultCHeck = false;
			if(!empty($userSubscriptions)){
				foreach($userSubscriptions as $subscription){

					$listing_id = $subscription['listing_id'];
					if($listingid==$listing_id){
						$resultCHeck = true;
					}
				}
			}
			
			return $resultCHeck;
		}
	}
	/* =============================================== cron-job for ads ==================================== */
	
	add_action( 'wp', 'lp_expire_listings_ads' );
	function lp_expire_listings_ads() {
		if (! wp_next_scheduled ( 'lp_daily_cron_listing_ads' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_cron_listing_ads');
		}
	}
	add_action('lp_daily_cron_listing_ads', 'lp_expire_this_ad');
if(!function_exists('lp_expire_this_ad')){

		function lp_expire_this_ad(){

			global $wpdb, $listingpro_options;

			$ads_durations = $listingpro_options['listings_ads_durations'];

			$args=array(

				'post_type' => 'lp-ads',

				'post_status' => 'publish',

				'posts_per_page' => -1,

			);

			$wp_query = null;

			$wp_query = new WP_Query($args);

			if( $wp_query->have_posts() ) {

				while ($wp_query->have_posts()) : $wp_query->the_post();

					$adID = get_the_ID();

					$ad_Mode = listing_get_metabox_by_ID('ads_mode', $adID);

					$ads_listing = listing_get_metabox_by_ID('ads_listing', $adID);

					if(empty($ad_Mode)){

						$ad_expiryDate = listing_get_metabox_by_ID('ad_expiryDate', $adID);

						$ads_listing = listing_get_metabox_by_ID('ads_listing', $adID);

						$currentdate = date("d-m-Y");

						

						/* to put dates in database */

						$ad_date = listing_get_metabox_by_ID('ad_date', $adID);

						$ads_mode = listing_get_metabox_by_ID('ads_mode', $adID);

						lp_ammend_campaigns_table();

						$table = 'listing_campaigns';

						$data = array('ad_date' => $ad_date,'ad_expiryDate' => $ad_expiryDate);

						$where = array('post_id' => $adID);

						lp_update_data_in_db($table, $data, $where);

						/* where for wire */

						$where = array('post_id' => $ads_listing);

						lp_update_data_in_db($table, $data, $where);

						/* to put dates in database ends */

						

						if( (strtotime($currentdate) > strtotime($ad_expiryDate)) && empty($ads_mode) ){

							

							$campaign_status = get_post_meta($ads_listing, 'campaign_status', true);

							if(!empty($campaign_status)){

								delete_post_meta( $ads_listing, 'campaign_status');

							}

							wp_delete_post( $adID, true );

							

							$listing_id = $ads_listing;

							$post_author_id = get_post_field( 'post_author', $listing_id );

							$user = get_user_by( 'id', $post_author_id );

							$useremail = $user->user_email;

							$user_name = $user->user_login;

							$website_url = site_url();

							$website_name = get_option('blogname');

							$listing_title = get_the_title($listing_id);

							$listing_url = get_the_permalink($listing_id);

							/* email to user */

							$headers[] = 'Content-Type: text/html; charset=UTF-8';

					

							$u_mail_subject_a = '';

							$u_mail_body_a = '';

							$u_mail_subject = $listingpro_options['listingpro_subject_ads_expired'];

							$u_mail_body = $listingpro_options['listingpro_ad_campaign_expired'];

							

							$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(

								'website_url' => "$website_url",

								'listing_title' => "$listing_title",

								'listing_url' => "$listing_url",

								'user_name' => "$user_name",

								'website_name' => "$website_name"

							));

							

							$u_mail_body_a = lp_sprintf2("$u_mail_body", array(

								'website_url' => "$website_url",

								'listing_title' => "$listing_title",

								'listing_url' => "$listing_url",

								'user_name' => "$user_name",

								'website_name' => "$website_name"

							));

							

							wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);

							

						}

					}

						

				endwhile;

			}

		}

	}
	
	/* =============================================== cron-job for recurring email ==================================== */
	
	add_action( 'wp', 'lp_payment_cron_alert_email' );
	function lp_payment_cron_alert_email() {
		if (! wp_next_scheduled ( 'lp_payments_cron_alets' )) {
		wp_schedule_event(time(), 'daily', 'lp_payments_cron_alets');
		}
	}
	add_action('lp_payments_cron_alets', 'lp_notify_payment_recurring');
	if(!function_exists('lp_notify_payment_recurring')){
		function lp_notify_payment_recurring(){
			global $wpdb, $listingpro_options;
			$lp_nofify;
			if(isset($listingpro_options['lp_recurring_notification_before'])){
				$lp_nofify = $listingpro_options['lp_recurring_notification_before'];
				$lp_nofify = trim($lp_nofify);
				$lp_nofify = (int)$lp_nofify;
			}
			else{
				$lp_nofify = 2;
			}
			$wherecond = 'status = "success" AND summary="recurring"';
			$recurringData = lp_get_data_from_db('listing_orders', '*', $wherecond);
			if(!empty($recurringData)){
				foreach($recurringData as $data){
					$plan_id = $data->plan_id;
					$plan_id = trim($plan_id);
					$listing_id = $data->post_id;
					$listing_id = trim($listing_id);
					$user_id = $data->user_id;
					$user_id = trim($user_id);
					
					$plan_title = get_the_title($plan_id);
					$listing_title = get_the_title($listing_id);
					
					$plan_price = get_post_meta($plan_id, 'plan_price', true);
					$plan_time = get_post_meta($plan_id, 'plan_time', true);
					
					if(is_numeric($plan_time)){
						$currentTime = date("Y-m-d");
						$publishedTime = get_the_time('Y-m-d', $listing_id);
						$currentTime = date_create($currentTime);
						$publishedTime = date_create($publishedTime);
						$interval = date_diff($currentTime, $publishedTime);
						/*2 days before plan end*/
						$plan_duration = $plan_time;
						$plan_time = (int)$plan_time - $lp_nofify;
						$daysDiff = $interval->days;
						if($daysDiff == $plan_time){
							
							$author_obj = get_user_by('id', $user_id);
							$author_email = $author_obj->user_email;

							$website_url = site_url();
							$website_name = get_option('blogname');
							$user_name = $author_obj->user_login;

							$headers[] = 'Content-Type: text/html; charset=UTF-8';
							
							/* user email */
							$subject = $listingpro_options['listingpro_subject_recurring_payment'];
							$mail_content = $listingpro_options['listingpro_content_recurring_payment'];
							
							$formated_mail_content = lp_sprintf2("$mail_content", array(
								'website_url' => "$website_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
								'listing_title' => "$listing_title",
								'plan_title' => "$plan_title",
								'plan_price' => "$plan_price",
								'plan_duration' => "$plan_duration",
								'notifybefore' => "$lp_nofify"
							));
							
							wp_mail( $author_email, $subject, $formated_mail_content, $headers );
							
							/* admin email */
							$admin_email = get_option('admin_email');
							
							$subjectadmin = $listingpro_options['listingpro_subject_recurring_payment_admin'];
							$mail_content_admin = $listingpro_options['listingpro_content_recurring_payment_admin'];
							
							$formated_mail_content_admin = lp_sprintf2("$mail_content_admin", array(
								'website_url' => "$website_url",
								'website_name' => "$website_name",
								'user_name' => "$user_name",
								'listing_title' => "$listing_title",
								'plan_title' => "$plan_title",
								'plan_price' => "$plan_price",
								'plan_duration' => "$plan_duration",
								'notifybefore' => "$lp_nofify"
							));
							
							wp_mail( $admin_email, $subjectadmin, $formated_mail_content_admin, $headers );
							
						}
					}
					
				}
			}
			
		}
	}
	

	/* =============================================== getClosestTimezone ==================================== */
	
	
	function getClosestTimezone($lat, $lng)
	  {
	   if (is_float($lat) && is_float($lng)){
            $diffs = array();
            foreach(DateTimeZone::listIdentifiers() as $timezoneID) {
              $timezone = new DateTimeZone($timezoneID);
              $location = $timezone->getLocation();
              $tLat = $location['latitude'];
              $tLng = $location['longitude'];
              $diffLat = abs($lat - $tLat);
              $diffLng = abs($lng - $tLng);
              $diff = $diffLat + $diffLng;
              $diffs[$timezoneID] = $diff;
            }

            $timezone = array_keys($diffs, min($diffs));
            $timestamp = time();
            date_default_timezone_set($timezone[0]);
            $zones_GMT = date('P', $timestamp);
            return $zones_GMT;

	    }
	  }
	/* ===========================listingpro remove version from css and js======================== */
	if(!function_exists('listingpro_remove_scripts_styles_version')){
		function listingpro_remove_scripts_styles_version( $src ) {
			if ( strpos( $src, 'ver=' ) )
				$src = remove_query_arg( 'ver', $src );
			return $src;
		}
	}
	add_filter( 'style_loader_src', 'listingpro_remove_scripts_styles_version', 9999 );
	add_filter( 'script_loader_src', 'listingpro_remove_scripts_styles_version', 9999 );
	
	/* js for invoice print */
	if(!function_exists('lp_call_invoice_print_preview')){
		function lp_call_invoice_print_preview(){
		wp_enqueue_script('lp-print-invoice', THEME_DIR. '/assets/js/jQuery.print.js', 'jquery', '', true);		

		}
	}
	add_action( 'lp_enqueue_print_script', 'lp_call_invoice_print_preview' );
	
	/* check for receptcha */
	if(!function_exists('lp_check_receptcha')){
		function lp_check_receptcha($type){
				
				global $listingpro_options;
				if(isset($listingpro_options['lp_recaptcha_switch'])){
					if($listingpro_options['lp_recaptcha_switch']==1){
						
						if(isset($listingpro_options["$type"])){
							if($listingpro_options["$type"]==1){
								return true;
							}
						}
						else{
							return false;
						}
						
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
		}
	}
	
	/* check if package has purchased and has credit */
	if(!function_exists('lp_check_package_has_credit')){
		function lp_check_package_has_credit($plan_id){
			global $listingpro_options, $wpdb;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = '';
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			$planPrice = get_post_meta($plan_id, 'plan_price', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$plan_id' AND status = 'success' AND plan_type='$plan_type'" );
				if( !empty($results) && count($results)>0 && !empty($planPrice) ){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	
	/* get used listing in package*/
	if(!function_exists('lp_get_used_listing_in_package')){
		function lp_get_used_listing_in_package($plan_id){
			global $listingpro_options, $wpdb;
			$used = 0;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND status = 'success'" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$used = $info->used;
						}
					}
			}
			return $used;
		}
	}
	
		/* check if listing is purchased and pending*/
	if(!function_exists('lp_if_listing_in_purchased_package')){
		function lp_if_listing_in_purchased_package($plan_id, $listing_id){
			global $wpdb;
			$postsIds = '';
			$postsIdsArray = array();
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND (status = 'success' OR status = 'expired')" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$postsIds .= $info->post_id;
						}
					}
			}
			if(!empty($postsIds)){
				$postsIdsArray = explode(",",$postsIds);
				if (in_array($listing_id, $postsIdsArray)){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			
		}
	}

	
	/* package update credit */
	if(!function_exists('lp_update_credit_package')){
		function lp_update_credit_package($listing_id, $plan_id=false){
			global $listingpro_options, $wpdb;
			$listing_ids = '';
			$used = 0;
			$returnVal = false;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			if(empty($plan_id)){
				$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
			}
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			$posts_allowed_in_plan = get_post_meta($plan_id, 'plan_text', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$packageHasCredit = lp_check_package_has_credit($plan_id);
				if(!empty($packageHasCredit) && $packageHasCredit=="1"){
					
					$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND status = 'success'" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$used = $info->used;
								$listing_ids = $info->post_id;
						}
						if(!empty($listing_ids)){
							$listing_ids = $listing_ids.','.$listing_id;
						}
						else{
							$listing_ids = $listing_id;
						}
						
						if( $used < $posts_allowed_in_plan ){
							$used++;
							$update_data = array('post_id' => $listing_ids, 'used' => $used);
							$where = array('user_id' => $user_ID, 'plan_id'=> $plan_id, 'plan_type' => $plan_type, 'status' => 'success');
							$update_format = array('%s', '%s');
							$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
							$returnVal = true;
							
						}
						
						if( $used == $posts_allowed_in_plan ){
							$update_data = array();
							$update_data = array('status' => 'expired');
							$where = array('user_id' => $user_ID, 'plan_id'=> $plan_id, 'plan_type' => $plan_type, 'status' => 'success');
							$update_format = array('%s');
							$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
						}
						
						
					}
					
				}
			}
			
			return $returnVal;
		}
	}
	
	/* change plan button */
	if(!function_exists('listingpro_change_plan_button')){
		function listingpro_change_plan_button($post, $listing_id=''){
			global $listingpro_options;
			$buttonEnabled = $listingpro_options['lp_listing_change_plan_option'];
			if($buttonEnabled=="enable"){
				$currency = listingpro_currency_sign();
				$buttonCode = '';
				$havePlan = "no";
				$planPrice = '';
				$listing_status = '';
				if(empty($listing_id)){
					$listing_id = $post->ID;
					$listing_status =  get_post_status( $listing_id );
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$planTitle = '';
					if(!empty($plan_id)){
						$planTitle = get_the_title($plan_id);
						$planPrice = get_post_meta($plan_id, 'plan_price', true);
						if(!empty($planPrice)){
							$planPrice = $currency.$planPrice;
						}
						else{
							$planPrice = esc_html__('Free', 'listingpro');
						}
						$planPrice .='/<small>'. get_post_meta($plan_id, 'plan_package_type', true).'</small>';
						$havePlan = "yes";
						
					}
					else{
						$planTitle = esc_html__('No Plan Assigned Yet', 'listingpro');
					}
					$buttonCode = '<a href="#" class="lp-review-btn btn-second-hover text-center lp-change-plan-btn" data-toggle="modal" data-target="#modal-packages" data-listingstatus="'.$listing_status.'" data-planprice="'.$planPrice.'"  data-haveplan="'.$havePlan.'" data-plantitle = "'.$planTitle.'" data-listingid="'.$listing_id.'" title="change"><i class="fa fa-paper-plane" aria-hidden="true"></i>'.esc_html__('Change Plan', 'listingpro').'</a>';
				}
				else{
					$listing_id = $post->ID;
					$listing_status =  get_post_status( $listing_id );
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$planTitle = '';
					if(!empty($plan_id)){
						$planPrice = get_post_meta($plan_id, 'plan_price', true);
						if(!empty($planPrice)){
							$planPrice = $currency.$planPrice;
						}
						else{
							$planPrice = esc_html__('Free', 'listingpro');
						}
						$planTitle = get_the_title($plan_id);
						$planpkgtype = '';
						$plantype = get_post_meta($plan_id, 'plan_package_type', true);
						if($plantype=="Package"){
							$planpkgtype = esc_html__('Package', 'listingpro');
						}
						else{
							$planpkgtype = esc_html__('Pay Per Listing', 'listingpro');
						}
						$planPrice .='/<small>'. $planpkgtype.'</small>';
						$havePlan = "yes";
						
					}
					else{
						$planTitle = esc_html__('No Plan Assigned Yet', 'listingpro');
					}
					$buttonCode = '<a href="#" class="lp-review-btn btn-second-hover text-center lp-change-plan-btn" data-toggle="modal" data-target="#modal-packages" data-listingstatus="'.$listing_status.'"  data-planprice="'.$planPrice.'"  data-haveplan="'.$havePlan.'" data-plantitle = "'.$planTitle.'" data-listingid="'.$listing_id.'" title="change"><i class="fa fa-paper-plane" aria-hidden="true"></i>'.esc_html__('Change Plan', 'listingpro').'</a>';
				}
				
				
				global $listingpro_options;
				$paidmode = $listingpro_options['enable_paid_submission'];
				if( !empty($paidmode) && $paidmode=="yes" ){
				return $buttonCode;
				}else{
					return;
				}
			}
		}
	}
	
	/* listingpro get payments status of listing */
	if(!function_exists('lp_get_payment_status_column')){
		function lp_get_payment_status_column($listing_id){
			global $wpdb;
			$returnStatus = '';
			$table_name = $wpdb->prefix . 'listing_orders';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
				$field_name = 'status';
				$prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  post_id = %d", $listing_id );
				$values = $wpdb->get_col( $prepared_statement );
				if(!empty($values)){
					if($values[0]=="success"){
						$returnStatus = esc_html__('Success', 'listingpro');
					}
					else{
						$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
						if(!empty($plan_id)){
							$plan_price = get_post_meta($plan_id, 'plan_price', true);
							if(!empty($plan_price)){
								$returnStatus = esc_html__('Pending', 'listingpro');
							}
							else{
								$returnStatus = esc_html__('Free', 'listingpro');
							}
							
						}
						else{
							$returnStatus = esc_html__('Free', 'listingpro');
						}
						
					}
				}
				else{
					$returnStatus = esc_html__('Free', 'listingpro');
				}
			}
			return $returnStatus;
		}
	}
	
	/* listingpro get payments status of listing by id */
	if(!function_exists('lp_get_payment_status_by_ID')){
		function lp_get_payment_status_by_ID($listing_id){
			global $wpdb;
			$returnStatus = '';
			$table_name = $wpdb->prefix . 'listing_orders';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
				$field_name = 'status';
				$prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  post_id = %d", $listing_id );
				$values = $wpdb->get_col( $prepared_statement );
				if(!empty($values)){
					if($values[0]=="success"){
						$returnStatus = 'success';
					}
					else{
						$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
						if(!empty($plan_id)){
							$plan_price = get_post_meta($plan_id, 'plan_price', true);
							if(!empty($plan_price)){
								$returnStatus = 'pending';
							}
							else{
								$returnStatus = 'free';
							}
							
						}
						else{
							$returnStatus = 'free';
						}
						
					}
				}
				else{
					$returnStatus = 'free';
				}
			}
			return $returnStatus;
		}
	}
	
	
	/* lp count user campaign by id */
	if(!function_exists('lp_count_user_campaigns')){
		function lp_count_user_campaigns($userid){
			$count = 0;
			$args = array(
				'post_type' => 'lp-ads',
				'posts_per_page' => -1,
				'post_status' => 'publish'
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$listingID = listing_get_metabox_by_ID('ads_listing', get_the_ID());
					$listing_author = get_post_field( 'post_author', $listingID );
					if($userid==$listing_author){
						$count++;
					}
				}
				wp_reset_postdata();
			}
			return ($count) ? $count : 0;
		}
	}
 
	/* count no.of post by user id */
	if(!function_exists('count_user_posts_by_status')){
		function count_user_posts_by_status($post_type = 'listing',$post_status = 'publish',$user_id = 0, $userListing=false){
			global $wpdb;
			$count = 0;
			$where = "WHERE post_type = '$post_type' AND post_status = '$post_status'";
			$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
			return apply_filters( 'get_usernumposts', $count, $user_id );
        }
    }

	/* check user reviews by user id and listing id */
	if(!function_exists('lp_check_user_reviews_for_listing')){
		function lp_check_user_reviews_for_listing($uid, $listing_id){
			$returnVal = false;
			if(!empty($uid) && !empty($listing_id)){
				
				$args = array(
					'post_type'  => 'lp-reviews',
					'post_status'	=> 'publish',
					'author' => $uid,
					'posts_per_page' => -1,
					
			 	);
			 	$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$listingid = listing_get_metabox_by_ID('listing_id', get_the_ID());
						if($listingid==$listing_id){
							$returnVal = true;
						}
					}
					wp_reset_postdata();
				}
				
			}
			else{
				$returnVal = false;
			}
			return $returnVal;
		}
	}
	
	/* adding new user meta for new subscription */
	if(!function_exists('lp_add_new_susbcription_meta')){
		function lp_add_new_susbcription_meta($new_susbcription){
			if(!empty($new_susbcription)){
				$uid = get_current_user_id();
				$existing_subsc = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($existing_subsc)){
					array_push($existing_subsc, $new_susbcription);
					update_user_meta($uid, 'listingpro_user_sbscr', $existing_subsc);
				}
				else{
					$new_subsc[] = $new_susbcription;
					update_user_meta($uid, 'listingpro_user_sbscr', $new_subsc);
				}
			}
		}
	}
	
	/* cancel subscription from stripe */
	if(!function_exists('lp_cancel_stripe_subscription')){
		function lp_cancel_stripe_subscription($listing_id, $plan_id){
			if(!empty($plan_id) && !empty($listing_id)){
				global $listingpro_options;
				require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
				$secritKey = $listingpro_options['stripe_secrit_key'];
				\Stripe\Stripe::setApiKey("$secritKey");
				
				$uid = get_current_user_id();
				$userSubscriptions = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($userSubscriptions)){
					foreach($userSubscriptions as $key=>$subscriptions){
						$subc_listing_id = $subscriptions['listing_id'];
						$subc_plan_id = $subscriptions['plan_id'];
						$subc_id = $subscriptions['subscr_id'];
						if( ($subc_listing_id== $listing_id) && ($subc_plan_id == $plan_id) ){
							$subscription = \Stripe\Subscription::retrieve($subc_id);
							$subscription->cancel();
							unset($userSubscriptions[$key]);
							break;
						}
					}
				}
				
				/* update metabox */
				if(!empty($userSubscriptions)){
					update_user_meta($uid, 'listingpro_user_sbscr', $userSubscriptions);
				}
				else{
					delete_user_meta($uid, 'listingpro_user_sbscr');
				}
				
			}
		}
	}
	
	/* remove trash ads permanently */
	if(!function_exists('listingpro_trash_ads_delete')){
		function listingpro_trash_ads_delete($post_id) {
			if (get_post_type($post_id) == 'lp-ads') {
				// Force delete
				wp_delete_post( $post_id, true );
			}
		}
	}	
	add_action('wp_trash_post', 'listingpro_trash_ads_delete');
	
	
	
	/* get distance between co-ordinates */
	if(!function_exists('GetDrivingDistance')){
		
		function GetDrivingDistance($latitudeFrom,$latitudeTo, $longitudeFrom,$longitudeTo, $unit){
			$unit = strtoupper($unit);
			$theta = $longitudeFrom - $longitudeTo;
			$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			if ($unit == "KM") {
				  $distance = ($miles * 1.609344);
				  $dist = round($distance, 1);
				  return array('distance' => $dist);
			  }else {
				  $dist = round($miles, 1);
				  return array('distance' => $dist);
			  }
			

			
		}
		
	}

    /* get lat and long from address and set for listing */
    if(!function_exists('lp_get_lat_long_from_address')){
        function lp_get_lat_long_from_address($address, $listing_id){
            $exLat = listing_get_metabox_by_ID('latitude', $listing_id);
            $exLong = listing_get_metabox_by_ID('longitude', $listing_id);
            $mapkey = lp_theme_option('google_map_api');
            if(empty($exLat) && empty($exLong)){
                if( !empty($address) && !empty($listing_id) ){
                    $address = str_replace(" ", "+", $address);
                    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=$mapkey";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

                    $data = curl_exec($ch);
                    curl_close($ch);

                    $json = json_decode($data);
                    if(!empty($json)){
                        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                        if(!empty($lat) && !empty($long)){
                            //set lat and long for listing
                            listing_set_metabox('latitude', $lat, $listing_id);
                            listing_set_metabox('longitude', $long, $listing_id);
                        }
                    }

                }
            }
        }
    }
	
	/* hide activatio notice vc */
	add_action('admin_head', 'lp_hide_vc_notification_css');
	if(!function_exists('lp_hide_vc_notification_css')){
		function lp_hide_vc_notification_css() {
			echo '<style>#vc_license-activation-notice { display: none !important; }</style>';
		}
	}
	
	/* ==============start add by sajid ============ */
	add_filter('body_class', 'listing_view_class');
	if(!function_exists('listing_view_class')){
		function listing_view_class( $classes ){
			global $listingpro_options;
			$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
			if( $listing_mobile_view == 'app_view' && wp_is_mobile()){
			$classes[]  =   'listing-app-view';
			}
			$app_view_home  =   $listingpro_options['app_view_home'];
			 $app_view_home  =   url_to_postid( $app_view_home );
			if( is_page( $app_view_home ) && $listing_mobile_view == 'app_view' && wp_is_mobile() )
			{
			   $classes[]  =   'app-view-home';
			}
			return $classes;
		}
	}
	
	/* ========listingpro_footer_menu_app======== */
	
	if (!function_exists('listingpro_footer_menu_app')) {
		function listingpro_footer_menu_app() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}
	}
	
	/* ==============end add by sajid ============ */
	
	
/* ===========================listingpro check plugin version======================== */
if(!function_exists('lp_notice_plugin_version')){
	function lp_notice_plugin_version() {
		
		$lp_theme = wp_get_theme();
		if($lp_theme=="Listingpro"){
			$themeVersion = $lp_theme->Version; 
			$lpallPlugins = get_plugins();
			if(class_exists('ListingproPlugin')){
				$listpro_plugin = $lpallPlugins['listingpro-plugin/plugin.php'];
				if(array_key_exists("Version",$listpro_plugin)){
					$pluginVersion = $listpro_plugin['Version'];
					if($themeVersion != $pluginVersion){
						$class = 'notice notice-warning';

						$message = '<h3>'.__('Important Update Notice!', 'listingpro-plugin').'</h3>';		
						
						$message .= __('Thanks for updating your theme, now we highly recommend you to also update the following plugin called  ', 'listingpro-plugin');	
						$message .= '<strong>';			
						$message .= __('ListingPro Plugin', 'listingpro-plugin');
						$message .= '</strong>';						
						$message .= __( '  Go to Plugins, deactivate and delete  *ListingPro Plugin*. After deleting, the following notice will appear,  ', 'listingpro-plugin' );
						$message .= '<strong>';			
						$message .= __('This theme requires the following plugin - Listingpro Plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  Click  ', 'listingpro-plugin' );						
						
						$message .= '<strong>';			
						$message .= __('begin installing plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  link. After installation is complete, activate the plugin. Listingpro plugin will be up to date', 'listingpro-plugin' );
						$message .= '<br/>';
						$message .= __( '  Additional Note for CHILD THEME Users: If you are using child theme then please switch to parent theme and follow the above steps and then switch back to child theme', 'listingpro-plugin' );						
												

						

						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
					}
				}
			}
		}
		 
	}
}
add_action( 'admin_notices', 'lp_notice_plugin_version' );

	/* ==============lp get free fields ============ */
	if (!function_exists('listingpro_get_term_openfields')) {
		function listingpro_get_term_openfields($onbackend=false) {
			
		
			$lpAllCatIds = array();
			$lp_catterms = get_terms( array(
				'taxonomy' => 'listing-category',
				'hide_empty' => false,
			) );
			
			if(!empty($lp_catterms)){
				foreach($lp_catterms as $term){
					array_push($lpAllCatIds,$term->term_id);
				}
			}
			
			
			$output = null;
			$fieldIDs = array();
			
			$texQuery = array(
                'key' => 'lp_listingpro_options',
                'value' => $lpAllCatIds,
                'compare' => 'NOT IN'
            );
			
			
			
			$argss = array(
					'post_type'  => 'form-fields',
					'posts_per_page'  => -1,
					'meta_query' => array(
						$texQuery
					)
			);
			$the_queryy = null;
			$the_queryy = new WP_Query( $argss );
			if ( $the_queryy->have_posts() ) {
				while ( $the_queryy->have_posts() ) {
					$the_queryy->the_post();
					$fID = get_the_ID();
					$yesString = esc_html__('Yes', 'listingpro');
					$exclusiveCheck = listing_get_metabox_by_ID('exclusive_field', $fID);
					if( !empty($exclusiveCheck) && $exclusiveCheck==$yesString ){
						array_push($fieldIDs,get_the_ID());
					}
					wp_reset_postdata();
				}
			}
			if($onbackend==false){
				$output = listingpro_field_type($fieldIDs);
			}else{
				$output = $fieldIDs;
			}
			
			
			return $output;
			
		}
	}
	/* ============== /// ============ */
	
	/* ==============  get post count of taxonomy term============ */
	if(!function_exists('lp_count_postcount_taxonomy_term_byID')){
		function lp_count_postcount_taxonomy_term_byID($post_type,$taxonomy, $termid){
			$postcounts = 0;
			
			$termObj= get_term_by('id', $termid, "$taxonomy");
			if (!is_wp_error( $termObj )){
				$postcounts = $termObj->count;
			}
			$term_children = get_terms("$taxonomy", array('child_of' => $termid));
			if(!empty($term_children) && !is_wp_error($term_children)){
				foreach($term_children as $singleTermObj){
					$postcounts = $postcounts + $singleTermObj->count;
				}
			}
			return $postcounts;
		}
	}
	
	/* ============== is favourite or not only ============ */
	if ( !function_exists('listingpro_is_favourite_new' ) )
	{
		function listingpro_is_favourite_new( $postid )
		{
			$favposts = ( isset( $_COOKIE['newco'] ) ) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
			$return =   'no';
			if ( in_array( $postid,$favposts  ) )
			{
				$return =   'yes';
			}
			return $return;
		}
	}
	
	/* ============== for mail sprintfto function============= */
	if ( !function_exists('lp_sprintf2' ) ){
		function lp_sprintf2($str='', $vars=array(), $char='%'){
			if (!$str) return '';
			if (count($vars) > 0)
			{
				foreach ($vars as $k => $v)
				{
					$str = str_replace($char . $k, $v, $str);
				}
			}

			return $str;
		}
	}
	
	/* ============== default featured image for listing ============= */
	if ( !function_exists('lp_default_featured_image_listing' ) ){
		function lp_default_featured_image_listing(){
			global $listingpro_options;
			$deafaultFeatImg = '';
			//if( isset($listingpro_options['lp_def_featured_image']) && !empty($listingpro_options['lp_def_featured_image']) ){
				
				//$deafaultFeatImgID = $listingpro_options['lp_def_featured_image']['id'];
				$deafaultFeatImgID = lp_theme_option_id('lp_def_featured_image');
				if( !empty($deafaultFeatImgID) ){
					$deafaultFeatImg = wp_get_attachment_image_src($deafaultFeatImgID, 'full', true );
					$deafaultFeatImg = $deafaultFeatImg[0];
				}else{
					$deafaultFeatImg = lp_theme_option_url('lp_def_featured_image');
				}
			//}
			return $deafaultFeatImg;
		}
	}
	
	/* ============== custom actions listingpro ============= */
	
	add_action( 'template_redirect', 'listingpro_redirect_to_homepage' );
	if(!function_exists('listingpro_redirect_to_homepage')){
		function listingpro_redirect_to_homepage() {
			global $post;
			if ( is_singular('listing') ) {
				$cpostID = $post->ID;
				if(!empty($cpostID)){
					$listingStatus = get_post_status( $cpostID );
					$cid = get_current_user_id();
					$listindUserID = get_post_field( 'post_author', $post->ID );
					if( $listingStatus=="expired" && $listindUserID != $cid ){
						wp_redirect( home_url() ); 
						exit;
					}
				}
			}
		}
	}
	
	/* ============ get image alt of featured image from post id ======= */
	if(!function_exists('lp_get_the_post_thumbnail_alt')){
		function lp_get_the_post_thumbnail_alt($post_id) {
			return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
		}
	}



add_image_size( 'listingpro_cats270_150',270, 150, true ); // (cropped)
/* ============== Version2 Functions ============ */
require_once THEME_PATH . "/include/functions-new.php";

/* ======================================= */
/* by dev for 2.0 */

	if(!function_exists('lp_theme_option')){
		function lp_theme_option($optionID){
			global $listingpro_options;
			if(isset($listingpro_options["$optionID"])){
				$optionValue = $listingpro_options["$optionID"];
				return $optionValue;
			}else{
				return false;
			}
		}
	}

	if(!function_exists('lp_paid_mode_status')){
		function lp_paid_mode_status(){
			global $listingpro_options;
			$enable_paid_submission = lp_theme_option('enable_paid_submission');
			if($enable_paid_submission=='yes'){
				return true;
			}else{
				return false;
			}
		}
	}

	if(!function_exists('lp_get_parent_cats_array')){
		function lp_get_parent_cats_array($onlyhavPlans=true){

			$parentCatsArray = array();
			$parentCatTerms = get_terms( 'listing-category', array( 'parent' => 0, 'hide_empty' => false ) );
			if(!empty($parentCatTerms)){
				foreach($parentCatTerms as $catTerm){
					$cat_id = $catTerm->term_id;
					if($onlyhavPlans==true){
						$lp_attached_plans = get_term_meta($cat_id, 'lp_attached_plans', true);
						if(!empty($lp_attached_plans)){
							$parentCatsArray[$cat_id] = $catTerm->name;
						}
					}else{
						$parentCatsArray[$cat_id] = $catTerm->name;
					}
				}
			}
			return $parentCatsArray;
		}
	}


	if(!function_exists('lp_get_child_cats_of_parent')){
		function lp_get_child_cats_of_parent($term_id, $taxonomy){
			$childTermArray = array();
			$argsTermChild = array(
				'order' => 'ASC',
				'hide_empty' => false,
				'hierarchical' => false,
				'parent' => $term_id,

			);
			$childTerms = get_terms($taxonomy, $argsTermChild);
			if(!empty($childTerms) && !is_wp_error($childTerms)){
				foreach($childTerms as $singleChldTerm){
					$childTermArray[$singleChldTerm->term_id] = $singleChldTerm->name;
				}

			}
			return $childTermArray;
		}
	}

	if(!function_exists('lp_get_term_field_by')){
		function lp_get_term_field_by($term_param,$compare_by,$taxonomy,$returnField){
			$returnFieldValue = '';
			$termData = get_term_by( $compare_by, $term_param, $taxonomy );
			if(!empty($termData) && !is_wp_error($termData)){
				if(!empty($returnField)){
					$returnFieldValue = $termData->$returnField;
				}
			}
			return $returnFieldValue;
		}
	}

	/* ajax for plans */
	add_action('wp_ajax_listingpro_select_plan_by_cat', 'listingpro_select_plan_by_cat');
	add_action('wp_ajax_nopriv_listingpro_select_plan_by_cat', 'listingpro_select_plan_by_cat');
if(!function_exists('listingpro_select_plan_by_cat')){
	function listingpro_select_plan_by_cat(){
		$catTermid = $_POST['term_id'];
		$pricing_style_views = $_POST['currentStyle'];
		$durationType = $_POST['duration_type'];

		$durationArray = array();
		if(!empty($durationtype)){
			$durationArray = array(
				'key' => 'plan_duration_type',
				'value' => $durationType,
				'compare' => 'LIKE',
			);
		}

		$isMontlyFilter = false;
		if(!empty($catTermid)){
			/* code goes here */
			$output = null;
			$args = null;
			$args = array(
				'post_type' => 'price_plan',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'meta_query'=>array(
					'relation' => 'AND',
					array(
						'key' => 'lp_selected_cats',
						'value' => $catTermid,
						'compare' => 'LIKE',
					),
					$durationArray,
					array(
						'key' => 'plan_usge_for',
						'value' => 'default',
						'compare' => 'NOT LIKE',
					),
				),
			);


			$cat_Plan_Query = null;
			$gridNumber = 0;
			$cat_Plan_Query = new WP_Query($args);
			$count = $cat_Plan_Query->found_posts;
			$GLOBALS['plans_count'] = $count;
			if($cat_Plan_Query->have_posts()){
				while ( $cat_Plan_Query->have_posts() ) {
					$cat_Plan_Query->the_post();
					$durationtype = get_post_meta(get_the_ID(), 'plan_duration_type', true);
					if( $durationtype=='monthly' || $durationtype=='yearly' ){
						$isMontlyFilter = true;
					}
					$gridNumber++;

					ob_start();

					include( LISTINGPRO_PLUGIN_PATH . "templates/pricing/loop/".$pricing_style_views.'.php');
					$output .= ob_get_contents();
					ob_end_clean();
					ob_flush();
					if($gridNumber%3 == 0) {
						$output.='<div class="clearfix"></div>';
					}
				}//END WHILE
				wp_reset_postdata();
				$returnData = array('response'=>'success', 'plans'=>$output, 'switcher'=>$isMontlyFilter);
			}else{
				$returnData = array('response'=>'success', 'plans'=> esc_html__('Sorry! There is no plan associated with the category', 'listingpro'), 'switcher'=>$isMontlyFilter);
			}
		}

		die(json_encode($returnData));
	}
}


	/* ajax for general plans */
	add_action('wp_ajax_listingpro_select_general_plans', 'listingpro_select_general_plans');
	add_action('wp_ajax_nopriv_listingpro_select_general_plans', 'listingpro_select_general_plans');
	if(!function_exists('listingpro_select_general_plans')){
		function listingpro_select_general_plans(){
				/* code goes here */
				$metaQueryArray['relation'] = 'OR';
				$durationType = $_POST['duration_type'];
				$pricing_style_views = $_POST['currentStyle'];
				$lp_plans_cats = lp_theme_option('listingpro_plans_cats');
				if($lp_plans_cats=='yes'){
					$metaQueryArray['relation'] = 'AND';
				}
				
				$durArrray = array();
				if(!empty($durationType)){
					$metaQueryArray[] = array(
						'key' => 'plan_duration_type',
						'value' => $durationType,
						'compare' => 'LIKE',
					);
				}
				
				$metaQueryArray[] = array(
							'key' => 'plan_usge_for',
							'value' => 'default',
							'compare' => 'LIKE',
						);
				
				
				$outputt = null;
				$args = null;
				$args = array(
					'post_type' => 'price_plan',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'meta_query'=>array(
						$metaQueryArray,

					),
				);


				$cat_Plan_Query = null;
				$gridNumber = 0;
				$cat_Plan_Query = new WP_Query($args);
				$count = $cat_Plan_Query->found_posts;
                $GLOBALS['plans_count'] = $count;
				if($cat_Plan_Query->have_posts()){
					while ( $cat_Plan_Query->have_posts() ) {
							$cat_Plan_Query->the_post();
							//if($pricing_plan_style=="vertical_view"){
								//$gridNumber++;
							//}
							ob_start();
							//get_template_part( "templates/pricing/loop/".$pricing_plan_style);
							//get_template_part( "templates/pricing/loop/vertical_view");

							include( LISTINGPRO_PLUGIN_PATH . "templates/pricing/loop/".$pricing_style_views.'.php');
							$outputt .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							/* if($gridNumber%3 == 0) {
								$output.='<div class="clearfix"></div>';
							} */
					}//END WHILE
					wp_reset_postdata();
					$returnData = array('response'=>'success', 'plans'=>$outputt);
				}else{
					$returnData = array('response'=>'success', 'plans'=> esc_html__('Sorry! There is no general plan', 'listingpro'));
				}

			die(json_encode($returnData));
		}
	}



	/* ============= function for paid claim form================ */
    if(!function_exists('lp_paid_claim_email_form')){
        function lp_paid_claim_email_form(){
            global $wp_rewrite;
            $returnData = array();
            $htmlData = '';
            $checkoutURl = lp_theme_option('payment-checkout');
            $checkoutURl = get_permalink( $checkoutURl );
            $listing_id = sanitize_text_field($_POST['listing_id']);
            $author_id = get_post_field ('post_author', $listing_id);
            $author_obj = get_user_by('id', $author_id);
            $author_email = $author_obj->user_email;
            $claim_type = sanitize_text_field($_POST['claim_type']);
            $claim_plan = sanitize_text_field($_POST['claim_plan']);
            $claimer = sanitize_text_field($_POST['claimer']);

            $claimer_obj = get_user_by('id', $claimer);
            $claimer_email = $claimer_obj->user_email;

            $claim_post_ID = sanitize_text_field($_POST['claim_post_ID']);
            if ($wp_rewrite->permalink_structure == ''){
                $checkoutURl .="&listing_id=$listing_id&claim_plan=$claim_plan&user_id=$claimer&claim_post=$claim_post_ID";
            }else{
                $checkoutURl .="?listing_id=$listing_id&claim_plan=$claim_plan&user_id=$claimer&claim_post=$claim_post_ID";
            }

            /* encodeing url */
            if(!empty($checkoutURl)){
                //$checkoutURl = urlencode($checkoutURl);
                //$checkoutURl = urldecode($checkoutURl);//need to be remove this line after test
            }

            $paidClaimData = esc_html__('To get Claim for listing, click of following link', 'listingpro').'<br />';
            //$paidClaimData .= "<a href='$checkoutURl' target='_blank'>".esc_html__('Click Here', 'listingpro')."</a>";
            $paidClaimData .= $checkoutURl;

            if(!empty($claim_type) && $claim_type=="paidclaims"){
                $htmlData = '<tr id="lp_claim_email"><th><label>' . __('Load Claim Email', 'listingpro') . '</label></th><td>';
                $htmlData .= '<input type="email" id="to_claimer_email" name="to_claimer_email" placeholder="' . __('john@gmail.com', 'listingpro') . '" value="'.$claimer_email.'">';								$htmlData .= '<input type="hidden" id="claimer_id" name="claimer_id" value="'.$claimer.'">';
                $htmlData .= '<br />';
                $htmlData .= '<input type="text" id="email_subject" name="email_subject" placeholder="' . __('Claim For Listing', 'listingpro') . '">';
                $htmlData .= '<br />';
                $htmlData .= '<textarea class="lp_claim_email" name="lp_claim_email">'.$paidClaimData.'</textarea>';
                $htmlData .= '<br />';
                $htmlData .= '<button type="submit" class="lp_trigger_paidclaim_email">' . __('Send Link to email', 'listingpro') . '</button>';
                $htmlData .= '<i style="display:none" class="lp-listing-spingg fa-li fa fa-spinner fa-spin"></i>';
                $htmlData .= '</td></tr>';
            }
            exit(json_encode($returnData=array('status'=>'success','htmlData'=>$htmlData)));
        }
    }

	add_action('wp_ajax_lp_paid_claim_email_form', 'lp_paid_claim_email_form');
	add_action('wp_ajax_nopriv_lp_paid_claim_email_form', 'lp_paid_claim_email_form');

	/* ======================send email for paid claim================== */
	if (!function_exists('lp_paid_claim_email_send'))
	{
	function lp_paid_claim_email_send()
		{
		$returnData = array();
		$claimer_id = $_POST['claimer_id'];
		$to = '';

		if (isset($_POST['to_claimer_email']))
			{
			$to = $_POST['to_claimer_email'];
			}
		  else
			{
			$author_obj = get_user_by('id', $claimer_id);
			$to = $author_obj->user_email;
			}
			/* save in user meta */
		update_user_meta($claimer_id, 'email_for_claim', $to);
		$subject = $_POST['email_subject'];
		$body = $_POST['lp_claim_email'];
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$emailStatus = wp_mail($to, $subject, $body, $headers);
		if (!empty($emailStatus))
			{
			$statusMsg = esc_html__('Email has sent', 'listingpro');
			$returnData = array(
				'status' => 'success',
				'msg' => $statusMsg
			);
			}
		  else
			{
			$statusMsg = esc_html__('Problem in email sending', 'listingpro');
			$returnData = array(
				'status' => 'error',
				'msg' => $statusMsg
			);
			}

		exit(json_encode($returnData));
		}
	}
	add_action('wp_ajax_lp_paid_claim_email_send', 'lp_paid_claim_email_send');
	add_action('wp_ajax_nopriv_lp_paid_claim_email_send', 'lp_paid_claim_email_send');

	/* ======================get filter addtional function ================== */
    if(!function_exists('lp_get_extrafields_filter')){
		function lp_get_extrafields_filter($fieltType=false, $catid=null, $countreturn = false){
			$returnArray = array();
			$singleField = array();
			if(!empty($fieltType)){
				$singleField = array($fieltType);
			}else{
				$singleField = array('check', 'checkbox', 'checkboxes', 'radio', 'select');
			}
				foreach($singleField as $fieltType){
					$args = array(
						'post_type' => 'form-fields',
						'posts_per_page' => -1,
						'post_status' => 'publish',
						'meta_query'=>array(
							'relation'=> 'AND',
							array(
								'key' => 'lp_field_filter_type',
								'value' => "$fieltType",
								'compare' => '='
							),
							array(
								'key' => 'lp_listingpro_options',
								'value' => 'displaytofilt',
								'compare' => 'LIKE'
							),

						),
					);

					$addition_fields_Query = new WP_Query($args);
					if($addition_fields_Query->have_posts()){
						while ( $addition_fields_Query->have_posts() ) {
							$addition_fields_Query->the_post();
								$isExclusive = listing_get_metabox_by_ID('exclusive_field',  get_the_ID());
								
								if( $isExclusive=="Yes" && empty($catid) ){
									$returnArray[get_the_ID()] = get_the_title();
								}else{
									$catsids = listing_get_metabox_by_ID('field-cat',  get_the_ID());
									if(!empty($catsids)){
										if(!empty($catid)){
											if (in_array($catid, $catsids)){
												$returnArray[get_the_ID()] = get_the_title();
											}
										}else{
											$returnArray[get_the_ID()] = get_the_title();
										}
									}
								}

						}
						wp_reset_postdata();
					}
				}
			if(!empty($countreturn)){
				return count($returnArray);
			}else{
				return $returnArray;
			}

		}
	}

	/* ======================ajax post type search autocompelte ================== */
	if(!function_exists('lp_ja_ajax_search_posttype')){
		function lp_ja_ajax_search_posttype() {
            $query_args =   array(
                'post_type'     => stripslashes( $_POST['posttype']),
                'post_status'   => 'publish',
                'posts_per_page'=> 10,
                's'             => stripslashes( $_POST['search'] ),
            );
            if( isset( $_REQUEST ) && $_POST['uniqueForEvents'] == 'yes' )
            {
                $query_args['meta_query']   =   array(
                    array(
                        'key' => 'event_id',
                        'compare' => 'NOT EXISTS'
                    ));
            }
            $results = new WP_Query( $query_args );
			$items = null;
			$items .='<ul id="listing-list">';
			if ( !empty( $results->posts ) ) {
				foreach ( $results->posts as $result ) {
					$items .='<li onClick="selectListing('.$result->ID.')">'.$result->post_title.'</li>';
				}
			}else{
			}
			$items .='</ul>';
			wp_send_json_success( $items );
		}
	}
	add_action( 'wp_ajax_search_posttype','lp_ja_ajax_search_posttype' );
	add_action( 'wp_ajax_nopriv_search_posttype', 'lp_ja_ajax_search_posttype' );

	/* ======================ajax pricing plan by month year ================== */
	if(!function_exists('lp_filter_pricing_plans')){
		function lp_filter_pricing_plans() {

			$catId = '';
			$planUsage = '';
			$catTaxArray = array();
			$catTax2Array = array();
			
			if(isset($_POST['planUsage'])){
				$planUsage = stripslashes( $_POST['planUsage']);
			}
			
			if(isset($_POST['cat_id'])){
				$catId = stripslashes( $_POST['cat_id']);
				if(!empty($catId)){
					$catTaxArray = array(
							'key' => 'lp_selected_cats',
							'value' => $catId,
							'compare' => 'LIKE',
						);

					if(!empty($planUsage)){

						$catTax2Array = array(
								'key' => 'plan_usge_for',
								'value' => $planUsage,
								'compare' => 'LIKE',
						);

					}
						
					
				}
			}
			
			//if($planUsage=="default"){
				if(empty($_POST['cat_id'])  && $planUsage=="default"){
					$catTax2Array = array(
								'key' => 'plan_usge_for',
								'value' => 'by category',
								'compare' => 'NOT LIKE',
							);
				}

				$lp_plans_cats = lp_theme_option('listingpro_plans_cats');
				if($lp_plans_cats=='yes' && !empty($_POST['cat_id'])){
					$catTax2Array = array(
								'key' => 'plan_usge_for',
								'value' => 'by category',
								'compare' => 'LIKE',
							);
				}


			//}

			//exit(json_encode(array('a'=>$catTax2Array, 'b'=>$catTaxArray, 'c'=>$catTaxArray)));
			
			$relationParm = 'AND';
			if( empty($catTaxArray) && !empty($catTax2Array) ){
				$relationParm = 'OR';
			}
			
			$durationType = stripslashes( $_POST['duration_type']);
			$pricing_style_views = $_POST['currentStyle'];
			$returnData = null;
				/* code goes here */
				$output = null;
				$args = null;
				$args = array(
					'post_type' => 'price_plan',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'meta_query'=>array(
					'relation' => $relationParm,
						$catTaxArray,
						array(
							'key' => 'plan_duration_type',
							'value' => $durationType,
							'compare' => 'LIKE',
						),
						$catTax2Array,
						
					),
				);

				$cat_Plan_Query = null;
				$output = null;
				$gridNumber = 0;
				$cat_Plan_Query = new WP_Query($args);
				$count = $cat_Plan_Query->found_posts;
                $GLOBALS['plans_count'] = $count;
				if($cat_Plan_Query->have_posts()){
					while ( $cat_Plan_Query->have_posts() ) {
							$cat_Plan_Query->the_post();
							
							ob_start();
							include( LISTINGPRO_PLUGIN_PATH . "templates/pricing/loop/".$pricing_style_views.'.php');
							$output .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							
					}//END WHILE
					wp_reset_postdata();
					if(!empty($output)){
						$returnData = array('response'=>'success', 'plans'=>$output);
					}else{
						$returnData = array('response'=>'success', 'plans'=> esc_html__('Sorry! There is no plan associated with the category', 'listingpro'));
					}
				}else{
					$returnData = array('response'=>'success', 'plans'=> esc_html__('Sorry! There is no plan associated with the category', 'listingpro'));
				}

			exit(json_encode($returnData ));
			//wp_send_json_success( $returnData );
		}
	}
	add_action( 'wp_ajax_filter_pricingplan','lp_filter_pricing_plans' );
	add_action( 'wp_ajax_nopriv_filter_pricingplan', 'lp_filter_pricing_plans' );



	/*---------------------------Fontawesome Icons For Pricing -----------------------*/

	if (!function_exists('listingpro_fontawesome_icon')) {

		function listingpro_fontawesome_icon($icon) {
			$output = '';
			  if($icon == 'checked'){
				$output = '<i class="awesome_plan_icon_check fa fa-check-circle"></i>';
			  }
			 elseif($icon == 'unchecked'){
				$output = '<i class="awesome_plan_icon_cross fa fa-times-circle"></i>';
			  }
			  return $output;

		}
	}

	/* ******************For coupon code*********************** */

	if(!function_exists('lp_generate_coupon_code')){
		function lp_generate_coupon_code(){
			$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$res = "";
			for ($i = 0; $i < 10; $i++) {
				$res .= $chars[mt_rand(0, strlen($chars)-1)];
			}
			return $res;
		}
	}
	/* ******************For business hours translated*********************** */

	if(!function_exists('lp_get_translated_day')){
		function lp_get_translated_day($dayName){
			return $dayName;

		}
	}

	if(!function_exists('lp_get_days_of_week')){
		function lp_get_days_of_week($currentDate){
			$weekArray = array();
			$currentDayStr = strtotime($currentDate);
			$currentDay = date("l", strtotime($currentDate));
			$StartDate = '';
			//$currentDay = 'Monday';
			switch($currentDay){

				case('Monday'):
				$StartDate = strtotime($currentDate);
				break;

				case('Tuesday'):
				$StartDate = strtotime($currentDate. "-1 day");
				break;

				case('Wednesday'):
				$StartDate = strtotime($currentDate. "-2 day");
				break;

				case('Thursday'):
				$StartDate = strtotime($currentDate. "-3 day");
				break;

				case('Friday'):
				$StartDate = strtotime($currentDate. "-4 day");
				break;

				case('Saturday'):
				$StartDate = strtotime($currentDate. "-5 day");
				break;

				case('Sunday'):
				$StartDate = strtotime($currentDate. "-6 day");
				break;

				case('Sunday'):
				$StartDate = strtotime($currentDate. "-7 day");
				break;

			}

			$start_date = date('Y-m-d', $StartDate);
			$weekArray = array(
				$StartDate,
				strtotime($start_date. "+1 day"),
				strtotime($start_date. "+2 day"),
				strtotime($start_date. "+3 day"),
				strtotime($start_date. "+4 day"),
				strtotime($start_date. "+5 day"),
				strtotime($start_date. "+6 day")
			);
			return $weekArray;
		}
	}

	/* ================================days of month ===================== */

	if(!function_exists('lp_get_days_of_month')){
		function lp_get_days_of_month($month, $year) {
			$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dates_month = array();

			for ($i = 1; $i <= $num; $i++) {
				$mktime = mktime(0, 0, 0, $month, $i, $year);
				$date = date("Y-m-d", $mktime);
				$date = strtotime($date);
				$dates_month[$i] = $date;
			}

			return $dates_month;
		}
	}

	/* ========================= months of year =============================== */
	if(!function_exists('lp_get_all_months')){
		function lp_get_all_months(){
			$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
			return $months;
		}
	}


	/* ========================= lp set stats for chart =============================== */
	if(!function_exists('lp_set_this_stats_for_chart')){
			function lp_set_this_stats_for_chart($authorID, $listing_id, $type){
				if($type=="view"){
					$table = "listing_stats_views";
				}elseif($type=="reviews"){
					$table = "listing_stats_reviews";
				}elseif($type=="leads"){
					$table = "listing_stats_leads";
				}
				$lpTodayTime = date('Y-m-d');
				$lpTodayTime = strtotime($lpTodayTime);
				/* main function */
				lp_create_stats_table_views();
				lp_create_stats_table_reviews();
				lp_create_stats_table_leads();
				$listing_title = get_the_title($listing_id);
				$allCounts = '';
				/* check if already have */
				$ndatDta = array();
				$condition = "listing_id='$listing_id' AND action_type='$type'";
				$ifDataExist = lp_get_data_from_db($table, '*', $condition);
				if(!empty($ifDataExist)){
					/* already exists */
					$hasData = false;
					foreach($ifDataExist as $indx=>$val){
						$datDta  = $val->month;
						$datDta = unserialize($datDta);
						$ndatDta = $datDta;
						if(!empty($datDta)){
							foreach($datDta as $ind=>$singleData){
								$savedDate = $singleData['date'];
								$savedcount = $singleData['count'];
								if($savedDate=="$lpTodayTime"){
									$hasData = true;
									$ndatDta[$ind]['count'] = $savedcount+1;
									$allCounts = $val->count;
								}
							}
						
							if(empty($hasData)){
								$ndatDta = array(
									array(
										'date'=>$lpTodayTime,
										'count'=>1,
										)
								);
							}
						
						}
					
					}
				
					if(!empty($ndatDta)){
						$allCounts = $allCounts + 1;
						$ndatDta = serialize($ndatDta);
					
						$where = array(
							'listing_id'=>$listing_id
						);
					
						$dataArray = array(
							'month'=>$ndatDta,
							'count'=>$allCounts,
						);
						lp_update_data_in_db($table, $dataArray, $where);
					}
				
				
				}
				else{
				
					/* new record */
					$logRecord = array(
							array(
								'date'=>$lpTodayTime,
								'count'=>1,
						)
					);
					$logRecord = serialize($logRecord);
				
					$dataArray = array(
						'user_id'=>$authorID,
						'listing_id'=>$listing_id,
						'listing_title'=>$listing_title,
						'action_type'=>$type,
						'month'=>$logRecord,
						'count'=>1,
					);
					lp_insert_data_in_db($table, $dataArray);
				
				}
				
				
				
				
				
			
				/* $condition = "user_id='$authorID' AND listing_id='$listing_id' AND action_type='$type' AND date='$lpTodayTime'";
				$getRow = lp_get_data_from_db($table, '*', $condition);
				if(!empty($getRow)){
					$counts = $getRow[0]->counts;
					$counts++;
					$data = array(
						'counts'=> $counts,
					);
					$where = array(
						'user_id'=> $authorID,
						'listing_id'=> $listing_id,
						'action_type'=> $type,
						'date'=> $lpTodayTime,
					);
					lp_update_data_in_db($table, $data, $where);
				}else{
					lp_insert_data_in_db($table, $dataArray);
				} */
			}
		}

	/* ================= lp get data attributes ====================== */
    if(!function_exists('lp_header_data_atts')){
        function lp_header_data_atts($datatype){
            global $listingpro_options;
            $lpAtts = ' ';
            if($datatype=="body"){
				if( is_search() || is_tax() ){
					if(lp_theme_option('enable_search_filter')==1){
						if(lp_theme_option('enable_nearme_search_filter')==1){
							if(lp_theme_option('disable_location_in_nearme_search_filter')==1){
								 $lpAtts .= "data-locdisablefilter='yes'".' ';
							}
						}
					}
				}
                $deflat = lp_theme_option("lp_default_map_location_lat");
                $deflong = lp_theme_option("lp_default_map_location_long");
                $maplistingby = lp_theme_option("map_listing_by");
                $defIconOp = lp_theme_option('lp_icon_for_archive_pages_switch');
                if($defIconOp=="enable"){
                    $category_image = lp_theme_option_url('lp_icon_for_archive_search_pages');
                    $lpAtts .= "data-deficon=".$category_image." ";
                }
                if(empty($deflat) && empty($deflong)){
                    $deflat = 0;
                    $deflong = -0;
                }
                $lpAtts .= "data-submitlink=".listingpro_url("submit-listing")." ";
                $lpAtts .= "data-sliderstyle=".lp_theme_option("lp_detail_slider_styles")." ";
                $lpAtts .= "data-defaultmaplat=".$deflat." ";
                $lpAtts .= "data-defaultmaplot=".$deflong." ";
                $lpAtts .= "data-lpsearchmode=".lp_theme_option("lp_what_field_algo")." ";
                $lpAtts .= "data-maplistingby=".$maplistingby." ";

            }elseif($datatype=="page"){
                $mtoken = lp_theme_option("mapbox_token");
                $mapBox = lp_theme_option("map_option");
                if(empty($mtoken) || $mapBox!="mapbox"){
                    $mtoken = 0;
                }
                $lpAtts .= "data-detail-page-style=".lp_theme_option("lp_detail_page_styles")." ";
                $lpAtts .= "data-lpattern=".lp_theme_option("lp_listing_locations_field_options")." ";
                $lpAtts .= "data-mstyle=".lp_theme_option("map_style")." ";
                $lpAtts .= "data-sitelogo=".$listingpro_options["primary_logo"]["url"]." ";
                $lpAtts .= "data-site-url=".esc_url(home_url("/"))." ";
                $lpAtts .= "data-ipapi=".lp_theme_option("lp_current_ip_type")." ";
                $lpAtts .= "data-lpcurrentloconhome=".lp_theme_option("lp_auto_current_locations_switch")." ";
                $lpAtts .= "data-mtoken=".$mtoken." ";
            }

            echo $lpAtts;
        }
    }


	/* ============== ListingPro get url of any theme option ============ */

	if(!function_exists('lp_theme_option_url')){
		function lp_theme_option_url($optionID){
			global $listingpro_options;
			if(isset($listingpro_options["$optionID"])){
				$optionValue = $listingpro_options["$optionID"]['url'];
				return $optionValue;
			}else{
				return false;
			}
		}
	}
	
	
	/* ============== ListingPro get id of any theme option ============ */

	if(!function_exists('lp_theme_option_id')){
		function lp_theme_option_id($optionID){
			global $listingpro_options;
			if(isset($listingpro_options["$optionID"])){
				if(isset($listingpro_options["$optionID"]['id'])){
					$optionValue = $listingpro_options["$optionID"]['id'];
					return $optionValue;
				}
			}else{
				return false;
			}
		}
	}

	/* ============== ListingPro get theme option based on 2 index ============ */

	if(!function_exists('lp_theme_option_by_index')){
		function lp_theme_option_by_index($optionID, $index){
			global $listingpro_options;
			if(isset($listingpro_options["$optionID"])){
				if(isset($listingpro_options["$optionID"]["$index"])){
					$optionValue = $listingpro_options["$optionID"]["$index"];
					return $optionValue;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	

	/* archive adsense before filter */
	if(!function_exists('lp_archive_adsense_before_filter')){
		function lp_archive_adsense_before_filter(){
			$lp_archive_ads = lp_theme_option('lp-archive-gads-editor');
			if(!empty($lp_archive_ads)){
				echo $lp_archive_ads;
			}
		}
		add_action('lp_archive_adsense_before_filter', 'lp_archive_adsense_before_filter', 1);
	}

	/* archive adsense after filter */
	if(!function_exists('lp_archive_adsense_after_filter')){
		function lp_archive_adsense_after_filter(){
			$lp_archive_ads = lp_theme_option('lp-archive-gads-editor');
			if(!empty($lp_archive_ads)){
				echo $lp_archive_ads;
			}
		}
		add_action('lp_archive_adsense_after_filter', 'lp_archive_adsense_after_filter', 1);
	}


	/* archive adsense after filter */
	if(!function_exists('lp_show_notification')){
		function lp_show_notification($source, $type){
			if(!empty($source) && !empty($type)){
				switch($source){
					/* listings */
					case 'listing':
						switch($type){
							case 'success':
								ob_start();
								get_template_part('templates/notifications/listing_success');
								$data = ob_get_contents();
								ob_end_clean();
								ob_flush();
								return json_encode($data);
							break;

							case 'error':
								ob_start();
								get_template_part('templates/notifications/listing_error');
								$data = ob_get_contents();
								ob_end_clean();
								ob_flush();
								return json_encode($data);
							break;

							case 'info':
								ob_start();
								get_template_part('templates/notifications/listing_info');
								$data = ob_get_contents();
								ob_end_clean();
								ob_flush();
								return json_encode($data);
							break;
						}
					break;
				}

			}
		}
	}

	/* notification div at footer via hook */
	if(!function_exists('lp_notification_div')){
		function lp_notification_div(){
			?>
				<div class="lp_notification_wrapper">
				</div>
			<?php
		}
		add_action('lp_add_at_startof_footer', 'lp_notification_div', 1);
	}

	/* notification for pending single listing */

    if(!function_exists('lp_listing_pending_notice')){
        function lp_listing_pending_notice() {
            global $post;
            $listingId = $post->ID;
            $listingStatus = get_post_status($listingId);
            $authorID = $post->post_author;
            if (is_user_logged_in()){
                if(is_singular( 'listing' )){
                    $uid = get_current_user_id();
                    if( $uid==$authorID ){
                        if($listingStatus=="pending"){
                            $data = lp_show_notification('listing', 'info');
                            ?>
                            <script>
                                jQuery(window).load(function(){
                                    var $dataText = JSON.parse(JSON.stringify(<?php echo $data; ?>));
                                    jQuery('<div class="lp_cancel_notic"><i class="fa fa-times"></i></div>').appendTo('.lp_notification_wrapper');
                                    jQuery($dataText).appendTo('.lp_notification_wrapper');
                                });
                            </script>
                            <?php
                        }
                    }
                }
            }
            /* view will be only count for vistors not for author */
            if(is_singular( 'listing' )){
                if($listingStatus=="publish"){
                    $table = 'listing_stats_views';
                    $data = array('user_id'=>$authorID);
                    $where = array('listing_id'=>$listingId);
                    lp_update_data_in_db($table, $data, $where);

                    if (is_user_logged_in()){
                        $uid = get_current_user_id();
                        if( $uid!=$authorID ){
                            lp_set_this_stats_for_chart($authorID, $listingId, 'view');
                        }
                    }else{
                        lp_set_this_stats_for_chart($authorID, $listingId, 'view');
                    }
                }
            }
        }
        add_action( 'listing_single_page_content', 'lp_listing_pending_notice', 1);
    }
	
	/* ======================ajax post type search autocompelte ================== */
	if(!function_exists('lp_save_bulkemail_template')){
		function lp_save_bulkemail_template() {
			$emailSubject = $_POST['email_subject'];
			$emailBody = $_POST['email_body'];
			$arrayData = array(
				'subject'=> $emailSubject,
				'body'=> $emailBody
			);
			update_option( 'bulkemail_template_admin', $arrayData );
			$statusMsg = esc_html__('Template saved successully', 'listingpro');
			$returnData = array(
				'status' => 'success',
				'msg' => $statusMsg
			);
			exit(json_encode($returnData));
		}
	}
	add_action( 'wp_ajax_lp_save_bulkemail_template','lp_save_bulkemail_template' );
	add_action( 'wp_ajax_nopriv_lp_save_bulkemail_template', 'lp_save_bulkemail_template' );
	
	
	/* ===================== check if plan has month/year type========= */
	if(!function_exists('lp_plan_has_monthyear_duration')){
		function lp_plan_has_monthyear_duration($durationType, $planUsage, $categories){
			$args = null;
			$args = array(
				'post_type' => 'price_plan',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'meta_query'=>array(
				'relation' => 'AND',
					array(
						'key' => 'plan_duration_type',
						'value' => $durationType,
						'compare' => 'LIKE',
					),
					array(
						'key' => 'plan_usge_for',
						'value' => array($planUsage),
						'compare' => 'IN',
					),
					array(
						'key' => 'lp_selected_cats',
						'compare' => "$categories",
					),
					
				),
			);

			$cat_Plan_Query = null;
			$cat_Plan_Query = new WP_Query($args);
			$count = $cat_Plan_Query->found_posts;
			if(!empty($count)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	/* lp reply to lead message */
	add_action( 'wp_ajax_lp_reply_to_lead_msg','lp_reply_to_lead_msg' );
	add_action( 'wp_ajax_nopriv_lp_reply_to_lead_msg', 'lp_reply_to_lead_msg' );
if(!function_exists('lp_reply_to_lead_msg')){
    function lp_reply_to_lead_msg(){

        $statusReply = array();
        $udemail = $_POST['lpleadmail'];
        $lp_listing_id = $_POST['lp_listing_id'];
        $message = $_POST['lp_replylead'];
        $newTimeArray = array();
        $lpdatetoday = date(get_option( 'date_format' ));
        $newTimeArray = array();
        $newMessagesArray = array();
        $userID = get_current_user_id();
        $lpAllPrevMessages = get_user_meta($userID, 'lead_messages', true);
        if(!empty($lpAllPrevMessages)){
            $PrevMessges = $lpAllPrevMessages[$lp_listing_id];
            if (array_key_exists("$udemail",$PrevMessges)){
                $PrevMessges = $lpAllPrevMessages[$lp_listing_id][$udemail];
                if (array_key_exists("replies",$PrevMessges)){
                    if(!empty($PrevMessges['replies'])){
                        $newMessagesArray = $PrevMessges['replies']['message'];
                        $newTimeArray = $PrevMessges['replies']['time'];
                    }
                    array_push($newMessagesArray,$message);
                    array_push($newTimeArray,$lpdatetoday);
                    $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['message'] = $newMessagesArray;
                    $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['time'] = $newTimeArray;
                }else{
                    $newMessagesArray = array($message);
                    array_push($newTimeArray,$lpdatetoday);
                    $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['message'] = $newMessagesArray;
                    $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['time'] = $newTimeArray;
                }
            }else{
                $newMessagesArray = array($message);
                array_push($newTimeArray,$lpdatetoday);
                $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['message'] = $newMessagesArray;
                $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['time'] = $newTimeArray;
            }
        }else{
            $newMessagesArray = array($message);
            array_push($newTimeArray,$lpdatetoday);
            $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['message'] = $newMessagesArray;
            $lpAllPrevMessages[$lp_listing_id][$udemail]['replies']['time'] = $newTimeArray;
        }
        $lpAllPrevMessages[$lp_listing_id][$udemail]['status'] = 'read';
        update_user_meta($userID, 'lead_messages', $lpAllPrevMessages);

        $latestLead = array(
            $lp_listing_id => $udemail,
        );
        update_user_meta($userID, 'latest_lead', $latestLead);

        /* for registered user leads sent */
        if ( email_exists( $udemail ) ) {
            $rUser = get_user_by( 'email', $udemail );
            $rUserID = $rUser->ID;
            update_user_meta($rUserID, 'leads_sent', $lpAllPrevMessages);
        }

        $headers = "Content-Type: text/html; charset=UTF-8";
        $subject = esc_html__('Lead message reply', 'listingpro');
        wp_mail( $udemail, $subject, $message,$headers);
        $statusReply = array('status'=>'success');
        exit(json_encode($statusReply));

    }
}
	
	/* function to dispaly messge thread on inbox page*/
	add_action( 'wp_ajax_lp_preview_this_message_thread','lp_preview_this_message_thread' );
	add_action( 'wp_ajax_nopriv_lp_preview_this_message_thread', 'lp_preview_this_message_thread' );

if(!function_exists('lp_preview_this_message_thread')){
    function lp_preview_this_message_thread(){
        $statusReponse = array();
        $listindid = $_POST['listindid'];
        $useremail = $_POST['useremail'];
        $outputcenter = null;
        $outputright = null;

        $latestLeadArray = array();
        $latestRepliesArray = array();
        $post_id = $listindid;
        $lead_mail = $useremail;
        $name = '';
        $phone = '';
        $times = array();
        $replytimes = array();
        $messages = array();
        $replymessages = array();

        $currentUserID = get_current_user_id();
        $leadAvatar = '';
        $leadUID = '';
        if ( email_exists( $lead_mail ) ){
            $leadUser = get_user_by( 'email', $lead_mail );
            $leadUID = $leadUser->ID;
            $leadAvatar = listingpro_get_avatar_url($leadUID, $size = '94');
        }else{
            $leadAvatar = listingpro_icons_url('lp_def_author');
        }

        $lpAllMessges = get_user_meta($currentUserID, 'lead_messages', true);
        //$adminAvatar = listingpro_get_avatar_url($currentUserID, $size = '94');
		$adminAvatar = listingpro_author_image();

        global $current_user;

        $lpAllMessges = get_user_meta($currentUserID, 'lead_messages', true);
        if(!empty($lpAllMessges)){
            $latestLeadArray = $lpAllMessges[$post_id][$lead_mail]['leads'];
            if (array_key_exists("replies",$lpAllMessges[$post_id][$lead_mail])){
                $latestRepliesArray = $lpAllMessges[$post_id][$lead_mail]['replies'];
            }
            $name = $latestLeadArray['name'];
            $phone = $latestLeadArray['phone'];
            $times = $latestLeadArray['time'];
            $messages = $latestLeadArray['message'];
            $extras = $latestLeadArray['extras'];
            if(!empty($latestRepliesArray)){
                $replytimes = $latestRepliesArray['time'];
                $replymessages = $latestRepliesArray['message'];
            }

            $outputcenter ='
					<div class="row">
						<div class="lp-message-title">
						';

            if(!empty($messages)){
                $outputcenter .='<h3>'.substr($messages[0], 0, 30)."...".'</h3>';
            }else{
                $outputcenter .='<h3><?php esc_html_e("No Recent recent message thread found","listingpro"); ?></h3>';
            }

            $outputcenter .='
						</div>
					</div>
					';

            $outputcenter .='
<div class="lp_all_messages_box clearfix">';

            if(!empty($messages)){
                $messages = array_reverse($messages);
                $outputcenter .= '<div  class="lpsinglemsgbox clearfix">';
                $outputcenter .= '<div class="lpsinglemsgbox-inner">';
                /* leads */
				$msgCount = 1;
				$outputtMSG = null;
				$outputcenterr = '';
                foreach($messages as $key=>$singlemessage){
                    /* replies */
                    if(!empty($replymessages)){
                        $replymessages = array_reverse($replymessages);
                        if(isset($replymessages[$key])){
                            $outputcenter .= '<div class="lpQest-outer lpreplyQest-outer">';
                            $outputcenter .= '<div class="lpQest"><div></div><p>'.$replymessages[$key].'</p></div>';
                            $outputcenter .= '<div class="lpQest-img-outer">';
                            $outputcenter .= '<div class="lpQest-image"><img src="'.$adminAvatar.'"></div>';
                            $outputcenter .= '<p>'.$current_user->user_login.'</p>';
                            $outputcenter .= '</div>';
                            $outputcenter .= '<div class="lpQestdate"><p>'.$replytimes[$key].'</p></div>';
                            $outputcenter .= '</div>';
                            $outputcenter .= PHP_EOL;
                        }
                    }
                    /* messages */
                    $outputcenterr .= '<div class="lpQest-outer">';
                    $outputcenterr .= '<div class="lpQest-img-outer">';
                    $outputcenterr .= '<div class="lpQest-image"><img src="'.$leadAvatar.'"></div>';
                    $outputcenterr .= '<p>'.$name.'</p>';
                    $outputcenterr .= '</div>';
                    $outputcenterr .= '<div class="lpQest"><div></div><p>'.$singlemessage.'</p></div>';
                    $outputcenterr .= '<div class="lpQestdate"><p>'.$times[$key].'</p></div>';
                    $outputcenterr .= '</div>';
                    $outputcenterr .= PHP_EOL;
					
					$msgCount++;

                }
				
				/* if replies are greater than messages*/
				if(!empty($replymessages)){
					$msgCount = $msgCount-1;
					
					$replySize = count($replymessages);
					if($replySize > $msgCount){
						
						for($i=$msgCount; $i<$replySize; $i++){
							$outputcenter .=  '<div class="lpQest-outer lpreplyQest-outer">';

                            $outputcenter .= '<div class="lpQest"><div></div><p>'.$replymessages[$i].'</p></div>';

                            $outputcenter .= '<div class="lpQest-img-outer">';
                            $outputcenter .= '<div class="lpQest-image"><img src="'.$adminAvatar.'"></div>';
                            $outputcenter .= '<p>'.$current_user->user_login.'</p>';
                            $outputcenter .= '</div>';
                            $outputcenter .= '<div class="lpQestdate"><p>'.$replytimes[$i].'</p></div>';
                            $outputcenter .= '</div>';
						}
					}
				}
				$outputcenter .= $outputcenterr;
                /* replies */
                /* if(!empty($replymessages)){
                    foreach($replymessages as $key=>$singleReply){

                        $outputcenter .= '<div class="lpQest-outer lpreplyQest-outer">';

                            $outputcenter .= '<div class="lpQest"><div></div><p>'.$singleReply.'</p></div>';

                            $outputcenter .= '<div class="lpQest-img-outer">';
                                    $outputcenter .= '<div class="lpQest-image"></div>';
                                    $outputcenter .= '<p>admin</p>';
                            $outputcenter .= '</div>';
                            $outputcenter .= '<div class="lpQestdate"><p>'.$replytimes[$key].'</p></div>';
                        $outputcenter .= '</div>';
                        $outputcenter .= PHP_EOL;
                    }
                } */
                $outputcenter .= '</div>';


                $outputcenter .= '</div>';

                $outputcenter .='
						<form id="lp_leadReply" name="lp_leadReply" class="lp_leadReply clearfix" method="POST">
							<textarea class="lp_replylead" name="lp_replylead" placeholder="' . __('Reply to this', 'listingpro') . '" required></textarea>
							<i class="lpthisloading fa fa-spinner fa-spin"></i>
							<button type="submit" class="lppRocesesp">'.esc_html__('Send message', 'listingpro').'</button>
							<input type="hidden" name="lpleadmail" value="'. $lead_mail.'">
							<input type="hidden" name="lp_listing_id" value="'. $post_id.'">
						</form>
						';
                $outputcenter .='</div>';

                $outputright .='
						<div class="lp-sender-info text-center background-white">
									<div class="lp-sender-image">
										<img src="'.$leadAvatar.'">
									</div>
									<h6>'.$name.'</h6>';
                if ( email_exists( $lead_mail ) ) {
                    $outputright .= esc_html__('Registered User', 'listingpro');
                }else{
                    $outputright .= esc_html__('Unregistered User', 'listingpro');
                }

                $outputright .='</div>
								<div class="lp-ad-click-outer">
									<div class="lp-general-section-title-outer">	
										<p class="clarfix lp-general-section-title comment-reply-title active"> '.esc_html__('Details', 'listingpro').'<i class="fa fa-angle-right" aria-hidden="true"></i></p>
										<div class="lp-ad-click-inner" id="lp-ad-click-inner">
											
											<ul class="lp-invoices-all-stats clearfix">
													<li>
														<h5>'. esc_html__('Email', 'listingpro').'  <span>'.$lead_mail.'</span></h5>
													</li>
													<li>
														<h5>'.esc_html__('Phone', 'listingpro').'  <span>'.$phone.'</span></h5>
													</li>';

                if(!empty($extras)){
                    foreach($extras as $key=>$singleEtr){
                        if(!empty($key) && !empty( $singleEtr )){
                            $outputright .='
																	<li>
																		<h5>'.$key.' <span>'. $singleEtr.'</span></h5>
																	</li>';
                        }
                    }
                }

                $outputright .='	
													
											</ul>
										</div>	
									</div>
								</div>';
            }

        }
        $statusReponse['outputcenter'] = $outputcenter;
        $statusReponse['outputright'] = $outputright;
        exit(json_encode($statusReponse));
    }
}

if(!function_exists('lp_get_total_ads_clicks')){
    function lp_get_total_ads_clicks(){
        $returnCounts = null;
        $clicksQuery = null;
        $args = array(
            'post_type' => 'lp-ads',
            'post_status' => 'publish',
            'posts_per_page'=> -1
        );
        $clicksQuery = new WP_Query( $args );

        if ( $clicksQuery->have_posts() ) {
            while ( $clicksQuery->have_posts() ) {
                $clicksQuery->the_post();
                $adID = get_the_ID();
                $clickesTHis = listing_get_metabox_by_ID('click_performed',$adID);
				if (is_numeric($returnCounts) && is_numeric($clickesTHis))
				{
                $returnCounts = $returnCounts+$clickesTHis;
				}
            }
            wp_reset_postdata();
        } else {
            $returnCounts = 0;
        }
        return $returnCounts;
    }
}
	/* end by dev for 2.0 */






/* string ends with function */
if(!function_exists('lpStringendsWith')){
    function lpStringendsWith($currentString, $target){
        $length = strlen($target);
        if ($length == 0) {
            return true;
        }
        return (substr($currentString, -$length) === $target);
    }
}





/* =============================================== cron-job for new ads ==================================== */

add_action( 'wp', 'lp_expire_listings_ads_new' );
function lp_expire_listings_ads_new() {
    if (! wp_next_scheduled ( 'lp_daily_cron_listing_ads_new' )) {
        wp_schedule_event(time(), 'daily', 'lp_daily_cron_listing_ads_new');
    }
}
add_action('lp_daily_cron_listing_ads_new', 'lp_expire_this_ad_new');
if(!function_exists('lp_expire_this_ad_new')){
    function lp_expire_this_ad_new(){
        global $wpdb, $listingpro_options;
        $ads_durations = $listingpro_options['listings_ads_durations'];
        $args=array(
            'post_type' => 'lp-ads',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $wp_query = null;
        $wp_query = new WP_Query($args);
        if( $wp_query->have_posts() ) {
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $adID = get_the_ID();
                $ad_Mode = listing_get_metabox_by_ID('ads_mode', $adID);
                $ads_listing = listing_get_metabox_by_ID('ads_listing', $adID);
                if(!empty($ad_Mode)){
                    if($ad_Mode=="byduration"){
                        /* by duration */
                        $duration = listing_get_metabox_by_ID('duration', $adID);
                        if(!empty($duration)){
                            $duration--;
                            listing_set_metabox('duration', $duration, $adID);

                        }else{
                            /* empty the delete */
                            $campaign_status = get_post_meta($ads_listing, 'campaign_status', true);
                            if(!empty($campaign_status)){
                                delete_post_meta( $ads_listing, 'campaign_status');
                            }
                            wp_delete_post( $adID, true );

                            $listing_id = $ads_listing;
                            $post_author_id = get_post_field( 'post_author', $listing_id );
                            $user = get_user_by( 'id', $post_author_id );
                            $useremail = $user->user_email;
                            $user_name = $user->user_login;
                            $website_url = site_url();
                            $website_name = get_option('blogname');
                            $listing_title = get_the_title($listing_id);
                            $listing_url = get_the_permalink($listing_id);
                            /* email to user */
                            $headers[] = 'Content-Type: text/html; charset=UTF-8';

                            $u_mail_subject_a = '';
                            $u_mail_body_a = '';
                            $u_mail_subject = $listingpro_options['listingpro_subject_ads_expired'];
                            $u_mail_body = $listingpro_options['listingpro_ad_campaign_expired'];

                            $u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
                                'website_url' => "$website_url",
                                'listing_title' => "$listing_title",
                                'listing_url' => "$listing_url",
                                'user_name' => "$user_name",
                                'website_name' => "$website_name"
                            ));

                            $u_mail_body_a = lp_sprintf2("$u_mail_body", array(
                                'website_url' => "$website_url",
                                'listing_title' => "$listing_title",
                                'listing_url' => "$listing_url",
                                'user_name' => "$user_name",
                                'website_name' => "$website_name"
                            ));

                            wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);
                            /* empty the delete ends */
                        }
                    }


                    if($ad_Mode=="perclick"){
                        /* per click */
                        $creditFinshed = false;
                        $listing_id = $ads_listing;
                        $allCharges = get_post_meta($listing_id, 'typescharges', true);
                        if(!empty($allCharges)){
                            foreach($allCharges as $key=>$val){
                                $remingCredits = get_post_meta($listing_id, 'credit_remaining', true);
                                if(!empty($remingCredits)){
                                    if($val > $remingCredits){
                                        delate_post_meta( $listing_id, $val);
                                    }
                                }else{
                                    delate_post_meta( $listing_id, $val);
                                    $creditFinshed = true;
                                }

                            }
                        }

                        if(!empty($creditFinshed)){
                            delate_post_meta( $listing_id, 'campaign_status');
                            wp_delete_post( $adID, true );

                            $listing_id = $ads_listing;
                            $post_author_id = get_post_field( 'post_author', $listing_id );
                            $user = get_user_by( 'id', $post_author_id );
                            $useremail = $user->user_email;
                            $user_name = $user->user_login;
                            $website_url = site_url();
                            $website_name = get_option('blogname');
                            $listing_title = get_the_title($listing_id);
                            $listing_url = get_the_permalink($listing_id);
                            /* email to user */
                            $headers[] = 'Content-Type: text/html; charset=UTF-8';

                            $u_mail_subject_a = '';
                            $u_mail_body_a = '';
                            $u_mail_subject = $listingpro_options['listingpro_subject_ads_expired'];
                            $u_mail_body = $listingpro_options['listingpro_ad_campaign_expired'];

                            $u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
                                'website_url' => "$website_url",
                                'listing_title' => "$listing_title",
                                'listing_url' => "$listing_url",
                                'user_name' => "$user_name",
                                'website_name' => "$website_name"
                            ));

                            $u_mail_body_a = lp_sprintf2("$u_mail_body", array(
                                'website_url' => "$website_url",
                                'listing_title' => "$listing_title",
                                'listing_url' => "$listing_url",
                                'user_name' => "$user_name",
                                'website_name' => "$website_name"
                            ));

                            wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);
                            /* empty the delete ends */

                        }

                    }


                }

            endwhile;
        }
    }
}

/* ===========================cron job runs at 1st of each month======================== */
add_action( 'wp', 'lp_stats_table_cron' );
function lp_stats_table_cron() {
    if (! wp_next_scheduled ( 'lp_daily_cron_for_stats' )) {
        wp_schedule_event(time(), 'daily', 'lp_daily_cron_for_stats');
    }
}
add_action('lp_daily_cron_for_stats', 'lp_update_stats_table');
if(!function_exists('lp_update_stats_table')){
    function lp_update_stats_table(){
		
		$date = date('d');
		if ('01' == $date) {
		/* peforms update */
		//$yearsStats = get_option('lp_years_stats');
		//need to set as true if cron run even for one time
		
		
		
		}
		
	}
	
}

/* ===========================listingpro check ads plugin version======================== */
if(!function_exists('lp_notice_ads_plugin_version')){
	function lp_notice_ads_plugin_version() {
		
		$lp_theme = wp_get_theme();
		if($lp_theme=="Listingpro"){
			$lpallPlugins = get_plugins();
			if(class_exists('ListingAds')){
				$listpro_plugin = $lpallPlugins['listingpro-ads/plugin.php'];
				if(array_key_exists("Version",$listpro_plugin)){
					$pluginVersion = $listpro_plugin['Version'];
					if($pluginVersion!="1.0.4"){
						$class = 'notice notice-warning';

						$message = '<h3>'.__('Important Update Notice! for LISTINGPRO ADS Plugin', 'listingpro-plugin').'</h3>';		
						
						$message .= __('Thanks for updating your theme, now we highly recommend you to also update the following plugin called  ', 'listingpro-plugin');	
						$message .= '<strong>';			
						$message .= __('ListingPro Ads Plugin', 'listingpro-plugin');
						$message .= '</strong>';						
						$message .= __( '  Go to Plugins, deactivate and delete  *ListingPro Ads Plugin*. After deleting, the following notice will appear,  ', 'listingpro-plugin' );
						$message .= '<strong>';			
						$message .= __('This theme requires the following plugin - Listingpro Ads Plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  Click  ', 'listingpro-plugin' );						
						
						$message .= '<strong>';			
						$message .= __('begin installing plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  link. After installation is complete, activate the plugin. Listingpro ads plugin will be up to date', 'listingpro-plugin' );
						$message .= '<br/>';
						$message .= __( '  Additional Note for CHILD THEME Users: If you are using child theme then please switch to parent theme and follow the above steps and then switch back to child theme', 'listingpro-plugin' );						
												

						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
					}
				}
			}
		}
		 
	}
}
add_action( 'admin_notices', 'lp_notice_ads_plugin_version' );

/* ======================claim plans array========================= */
	if(!function_exists('lp_get_claim_plans_function_array')){
		function lp_get_claim_plans_function_array(){
			$returnArray = array();
			$returnArray[0] = esc_html__('Select Plan', 'listingpro');
			$args = null;
			$args = array(
				'post_type' => 'price_plan',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'meta_query'=>array(
					'relation'=> 'OR',
					array(
							'key' => 'lp_listingpro_options',
							'value' => 'claimonly',
							'compare' => 'LIKE'
						),
					array(
							'key' => 'lp_listingpro_options',
							'value' => 'listingandclaim',
							'compare' => 'LIKE'
						),
				),
			);

			$claim_Plan_Query = new WP_Query($args);
			if($claim_Plan_Query->have_posts()){
				while ( $claim_Plan_Query->have_posts() ) {
						$claim_Plan_Query->the_post();

						$returnArray[get_the_ID()] = get_the_title();

				}
				wp_reset_postdata();
			}

			return $returnArray;
		}
	}
	
/* ==========================updated metas on success paid claim===================== */
if(!function_exists('lp_update_paid_claim_metas')){
	function lp_update_paid_claim_metas($claimed_post, $post_id, $method){

		listing_set_metabox('claimed_section', 'claimed', $post_id);
		$new_author = listing_get_metabox_by_ID('claimer', $claimed_post);
		$claim_plan = listing_get_metabox_by_ID('claim_plan', $claimed_post);
		listing_set_metabox('Plan_id',$claim_plan, $post_id);
		listing_set_metabox('claim_status','approved', $claimed_post);
		listing_set_metabox('claimed_listing', $claimed_post, $post_id);

		global $listingpro_options;
		$c_mail_subject = $listingpro_options['listingpro_subject_listing_claim_approve'];
		$c_mail_body    = $listingpro_options['listingpro_content_listing_claim_approve'];

		$a_mail_subject = $listingpro_options['listingpro_subject_listing_claim_approve_old_owner'];
		$a_mail_body    = $listingpro_options['listingpro_content_listing_claim_approve_old_owner'];

		$admin_email   = '';
		$admin_email   = get_option('admin_email');
		$website_url   = site_url();
		$website_name  = get_option('blogname');
		$listing_title =  get_the_title($post_id);
		$listing_url   = get_the_permalink($post_id);
		$headers[]     = 'Content-Type: text/html; charset=UTF-8';

		global $wpdb;
		$prefix = $wpdb->prefix;

		$update_data   = array(
			'post_author' => $new_author
		);
		$where         = array(
			'ID' => $post_id
		);
		$update_format = array(
			'%s'
		);
		//$wpdb->update($prefix . 'posts', $update_data, $where, $update_format);

		$argddd = array(
			'ID' => $post_id,
			'post_author' => $new_author,
		);
		wp_update_post($argddd);

		/* updte data is listing order db */
		$orderTable = 'listing_orders';
		lp_change_listinguser_in_db($new_author, $post_id, $orderTable);

		/* creating invoice */
		$start = 11111111;
		$end = 999999999;
		$ord_num = random_int($start, $end);
		if(lp_theme_option('listingpro_invoice_start_switch')=="yes"){
			$ord_num = lp_theme_option('listingpro_invoiceno_no_start');
			$ord_num++;
			if (  class_exists( 'Redux' ) ) {
				$opt_name = 'listingpro_options';
				Redux::setOption( $opt_name, 'listingpro_invoiceno_no_start', "$ord_num");
			}
		}


		$user_obj = get_user_by('id', $new_author);
		$fname = $user_obj->user_login;
		$lname = $user_obj->user_login;
		$usermail = $user_obj->user_email;

		$currency_code = lp_theme_option('currency_paid_submission');
		$plan_id = listing_get_metabox_by_ID('claim_plan', $claimed_post);
		$plan_price = get_post_meta($plan_id, 'plan_price', true);
		$plan_duration = get_post_meta($plan_id, 'plan_time', true);
		$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
		$plan_title = get_the_title($plan_id);

		$post_info_array = array(
			'user_id'	=> $new_author ,
			'post_id'	=> $post_id,
			'plan_id'	=> $plan_id ,
			'plan_name' => $plan_title,
			'plan_type' => $plan_type,
			'payment_method' => $method,
			'token' => '',
			'price' => $plan_price,
			'currency'	=> $currency_code ,
			'days'	=> $plan_duration ,
			'date'	=> '',
			'status'	=> 'success',
			'used'	=> '' ,
			'transaction_id'	=>'',
			'firstname'	=> $fname,
			'lastname'	=> $lname,
			'email'	=> $usermail ,
			'description'	=> 'purchased by paid claim' ,
			'summary'	=> '' ,
			'order_id'	=> $ord_num ,

		);
		$wpdb->insert($prefix."listing_orders", $post_info_array);


	}
}

/* =============================for making listing selected checkut session id================== */
add_action( 'wp_ajax_lp_save_thisid_in_session','lp_save_thisid_in_session' );
add_action( 'wp_ajax_nopriv_lp_save_thisid_in_session', 'lp_save_thisid_in_session' );
if(!function_exists('lp_save_thisid_in_session')){
	function lp_save_thisid_in_session(){
		$listingID = $_POST['listing_id'];
		$_SESSION['listing_id_checkout'] = $listingID;
		exit();
	}
}

/* =============================for addding new column in campagins table======================== */
if(!function_exists('lp_ammend_campaigns_table')){
	function lp_ammend_campaigns_table(){
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$table = $table_prefix.'listing_campaigns';
		if(empty(lp_check_column_exist_in_table($table, 'mode'))){
			$wpdb->query( sprintf( "ALTER TABLE %s ADD mode VARCHAR(255) NOT NULL", $table) );
		}
		if(empty(lp_check_column_exist_in_table($table, 'duration'))){
			$wpdb->query( sprintf( "ALTER TABLE %s ADD duration VARCHAR(255) NOT NULL", $table) );
		}
		if(empty(lp_check_column_exist_in_table($table, 'budget'))){
			$wpdb->query( sprintf( "ALTER TABLE %s ADD budget VARCHAR(255) NOT NULL", $table) );
		}
		if(empty(lp_check_column_exist_in_table($table, 'ad_date'))){
			$wpdb->query( sprintf( "ALTER TABLE %s ADD ad_date VARCHAR(255) NOT NULL", $table) );
		}
		if(empty(lp_check_column_exist_in_table($table, 'ad_expiryDate'))){
			$wpdb->query( sprintf( "ALTER TABLE %s ADD ad_expiryDate VARCHAR(255) NOT NULL", $table) );
		}
		
		
	}
}

/* ============================ for check if column exists=========================== */
if(!function_exists('lp_check_column_exist_in_table')){
	function lp_check_column_exist_in_table($table_name, $column_name){
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			return false;
		}else{
			$column = $wpdb->get_results( $wpdb->prepare(
				"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
				DB_NAME, $table_name, $column_name
			) );
			if ( ! empty( $column ) ) {
				return true;
			}
			return false;
		}
	}
}

/* ============== Theme Setup init tag ============ */

add_action('init', 'listingpro_titleTag');
if( !function_exists('listingpro_titleTag') ){
	function listingpro_titleTag(){
		if(!is_author()){
			add_theme_support( "title-tag" );
		}
	}
}

/* =================ammend column for tax in order table=================== */

if(!function_exists('lp_ammend_orders_table')){
	function lp_ammend_orders_table(){
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$table = $table_prefix.'listing_orders';
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
			if(empty(lp_check_column_exist_in_table($table, 'tax'))){
				$wpdb->query( sprintf( "ALTER TABLE %s ADD tax VARCHAR(255) NOT NULL", $table) );
			}
		}
	}
}
add_action('init', 'lp_ammend_orders_table');

/* =================ammend column for tax in campagins table=================== */

if(!function_exists('lp_ammend_tax_campains_table')){
	function lp_ammend_tax_campains_table(){
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$table = $table_prefix.'listing_campaigns';
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
			if(empty(lp_check_column_exist_in_table($table, 'tax'))){
				$wpdb->query( sprintf( "ALTER TABLE %s ADD tax VARCHAR(255) NOT NULL", $table) );
			}
		}
	}
}
add_action('init', 'lp_ammend_tax_campains_table');