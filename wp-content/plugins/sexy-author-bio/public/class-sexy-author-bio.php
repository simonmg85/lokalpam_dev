<?php
/**
 * WP Author Bio
 *
 * @package   WP_Author_Bio
 * @author    Andy Forsberg <andy@penguinwp.com>
 * @license   GPL-2.0+
 * @copyright 2017 Penguin Initiatives
 */

/**
 * Sexy_Author_Bio class.
 *
 * @package Sexy_Author_Bio
 * @author  Andy Forsberg <andy@penguinwp.com>
 */
class Sexy_Author_Bio {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	protected static $plugin_slug = 'sexy-author-bio';

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Display the box.
		add_filter( 'the_content', array( $this, 'display' ), 9999 );

		add_action('wp_head', array( $this, 'hook_css' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since  1.0.0
	 *
	 * @return Plugin slug variable.
	 */
	public static function get_plugin_slug() {
		return self::$plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since  1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since  1.0.0
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses
	 *                               "Network Activate" action, false if
	 *                               WPMU is disabled or plugin is
	 *                               activated on an individual blog.
	 *
	 * @return void
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since  1.0.0
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses
	 *                               "Network Deactivate" action, false if
	 *                               WPMU is disabled or plugin is
	 *                               deactivated on an individual blog.
	 *
	 * @return void
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since  1.0.0
	 *
	 * @param  int  $blog_id ID of the new blog.
	 *
	 * @return void
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since  1.0.0
	 *
	 * @return array|false The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private static function single_activate() {
		$options = array(
			'display' => 'posts',
			'author_links' => 'users_set',
			'nofollow_author_links' => 'follow',
			'link_target' => '_top',
			'gravatar' => 100,
			'author_name_font_size' => 48,
			'author_name_line_height' => 48,
			'author_name_font' => '\'Open Sans\', sans-serif',
			'author_name_font_weight' => '600',
			'author_name_capitalization' => 'uppercase',
			'author_name_decoration' => 'none',
			'author_byline_font_size' => '15',
			'author_byline_line_height' => '21',
			'author_byline_font' => '\'Open Sans\', sans-serif',
			'author_byline_font_weight' => '700',
			'author_byline_capitalization' => 'uppercase',
			'author_byline_decoration' => 'underline',
			'author_biography_font_size' => '12',
			'author_biography_line_height' => '17',
			'author_biography_font' => '\'Open Sans\', sans-serif',
			'author_biography_font_weight' => '400',
			'separator' => 'at',
			'background_color' => '#333333',
			'highlight_color' => '#0088cc',
			'text_color' => '#ffffff',
			'byline_color' => '#777777',
			'border_top_size' => 20,
			'border_right_size' => 0,
			'border_bottom_size' => 20,
			'border_left_size' => 0,
			'border_style' => 'solid',
			'border_color' => '#444444',
			'mobile_avatar_display' => 'hide',
			'user_roles_access' => 'contributors',
			'icon_size' => 48,
			'icon_spacing' => 2,
			'icon_hover_effect' => 'fade',
			'icon_position' => 'top',
			'pick_icon_set' => 'flat-circle'
		);

		add_option( 'sexyauthorbio_settings', $options );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private static function single_deactivate() {
		//delete_option( 'sexyauthorbio_settings' );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$domain = self::get_plugin_slug();
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_register_style( self::get_plugin_slug() . '-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION, 'all' );
		/*wp_register_style( 'GoogleFonts', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700'); 
    	wp_enqueue_style( 'GoogleFonts' ); */
	}

	/**
	 * Checks if can display the box.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $settings WP Author Bio settings.
	 *
	 * @return bool
	 */
	protected function is_display( $settings ) {
		switch( $settings['display'] ) {
			case 'posts':
				return is_single() && 'post' == get_post_type();
				break;
			case 'home_posts':
				return is_single() && 'post' == get_post_type() || is_home();
				break;

			default:
				return false;
				break;
		}
	}

	/**
	 * HTML of the box.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $settings WP Author Bio settings.
	 *
	 * @return string          WP Author Bio HTML.
	 */
	public static function view( $settings ) {

		// Load the styles.
		wp_enqueue_style( self::get_plugin_slug() . '-styles' );

		// Set the gravatar size.
		$gravatar = ! empty( $settings['gravatar'] ) ? $settings['gravatar'] : 70;

		if ( function_exists( 'get_coauthors' ) && count( get_coauthors( get_the_id() ) ) > 1 ){

			ob_start();

			//foreach ( get_coauthors( $post->ID ) as $sab_coauthor ){

			$co_authors = get_coauthors();
				foreach ( $co_authors as $key => $sab_coauthor ) {
					$co_author_classes = array(
						'co-author-wrap',
						'co-author-number-' . ( $key + 1 ),
					);
				
				$zeeauthor = $sab_coauthor->data->ID;

				$output = array('author' => $zeeauthor, 'content' => '');

				// Load the styles.
				wp_enqueue_style( self::get_plugin_slug() . '-styles' );

				// Set the gravatar size.
				$gravatar = ! empty( $settings['gravatar'] ) ? $settings['gravatar'] : 70;

				$sabemail = get_the_author_meta( 'sabemail', $zeeauthor );

				if($sabemail && strpos($sabemail, 'mailto') !== false){
					$mailto = "";
				}else if($sabemail && strpos($sabemail, 'mailto') !== true){
					$mailto = "mailto:";
				}else{
					$mailto = "";
				}

				// Set the social icons
				$social = array(
					'sabbehance'    => get_the_author_meta( 'sabbehance', $zeeauthor ),
					'sabblogger'    => get_the_author_meta( 'sabblogger', $zeeauthor ),
					'sabdelicious'    => get_the_author_meta( 'sabdelicious', $zeeauthor ),
					'sabdeviantart'    => get_the_author_meta( 'sabdeviantart', $zeeauthor ),
					'sabdribbble'    => get_the_author_meta( 'sabdribbble', $zeeauthor ),
					'sabemail'    => get_the_author_meta( 'sabemail', $zeeauthor ),
					'sabfacebook'    => get_the_author_meta( 'sabfacebook', $zeeauthor ),
					'sabflickr'    => get_the_author_meta( 'sabflickr', $zeeauthor ),
					'sabgithub'    => get_the_author_meta( 'sabgithub', $zeeauthor ),
					'sabgoogle'    => get_the_author_meta( 'sabgoogle', $zeeauthor ),
					'sabinstagram'    => get_the_author_meta( 'sabinstagram', $zeeauthor ),
					'sablinkedin'    => get_the_author_meta( 'sablinkedin', $zeeauthor ),
					'sabmyspace'    => get_the_author_meta( 'sabmyspace', $zeeauthor ),
					'sabpinterest'    => get_the_author_meta( 'sabpinterest', $zeeauthor ),
					'sabrss'    => get_the_author_meta( 'sabrss', $zeeauthor ),
					'sabstumbleupon'    => get_the_author_meta( 'sabstumbleupon', $zeeauthor ),
					'sabtumblr'    => get_the_author_meta( 'sabtumblr', $zeeauthor ),
					'sabtwitter'    => get_the_author_meta( 'sabtwitter', $zeeauthor ),
					'sabvimeo'    => get_the_author_meta( 'sabvimeo', $zeeauthor ),
					'sabwordpress'    => get_the_author_meta( 'sabwordpress', $zeeauthor ),
					'sabyahoo'    => get_the_author_meta( 'sabyahoo', $zeeauthor ),
					'sabyoutube'    => get_the_author_meta( 'sabyoutube', $zeeauthor )
				);

				if ( $settings['author_links'] == "link_to_author_page" ){ 
					$author_name_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $zeeauthor ) ) );
					$author_avatar_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $zeeauthor ) ) );
				}else{
					if ( get_the_author_meta('name-link', $zeeauthor) ){
						$author_name_link = esc_url( get_the_author_meta( 'name-link', $zeeauthor ) );
					}else{
						$author_name_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $zeeauthor ) ) );
					}
					if ( get_the_author_meta('avatar-link', $zeeauthor) ){
						$author_avatar_link = esc_url( get_the_author_meta( 'avatar-link', $zeeauthor ) );
					}else{
						$author_avatar_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $zeeauthor ) ) );
					}
				}

				if ( get_the_author_meta('hide-signature', $zeeauthor) || !$sab_coauthor->description ) { $hidden = "display:none!important;"; }else{ $hidden = ""; }

				$output['content'] = '<div id="sexy-author-bio" style="margin:10px 0;'.$hidden.'" class="';
				$output['content'] .= preg_replace("/[\s_]/", "-", strtolower($sab_coauthor->display_name));
				$output['content'] .= '">';

				if ($settings['icon_hover_effect'] == "fade"){
					$fade = 'class="bio-icon" ';
				}else{
					$fade = '';
				}

				if ( $settings['nofollow_author_links'] == "nofollow" ){
					$nofollow = 'rel="nofollow" ';
					$nofollowshort = "nofollow ";
				}else {
					$nofollow = '';
					$nofollowshort = "";
				}

					// BEGIN AUTHOR SCHEMA

					$output['content'] .= '<script type="application/ld+json">
							{
							  "@context" : "http://schema.org",
							  "@type" : "Person",
							  "name" : "' . $sab_coauthor->display_name . '",
					 		  "url" : "' . $author_name_link . '",
							  "sameAs" : [';

					$l = 0;

					foreach ( ($social) as $network => $url ) {
						
						if( strpos($url,'sabfacebook') !== false || strpos($url,'sabtwitter') !== false || strpos($url,'sabgoogle') !== false || strpos($url,'sabinstagram') !== false || strpos($url,'sabyoutube') !== false || strpos($url,'sablinkedin') !== false || strpos($url,'sabmyspace') !== false || strpos($url,'sabpinterest') !== false || strpos($url,'sabsoundcloud') !== false || strpos($url,'sabtumblr') !== false ){

							$l++;

						}

					}

					$len = $l;

					$i = 0;

					foreach ( ($social) as $network => $url ) {

						if ( $url ){

							$i++;

							if( strpos($url,'sabfacebook') !== false || strpos($url,'sabtwitter') !== false || strpos($url,'sabgoogle') !== false || strpos($url,'sabinstagram') !== false || strpos($url,'sabyoutube') !== false || strpos($url,'sablinkedin') !== false || strpos($url,'sabmyspace') !== false || strpos($url,'sabpinterest') !== false || strpos($url,'sabsoundcloud') !== false || strpos($url,'sabtumblr') !== false ){
								
								$output['content'] .= '"' . $url . '"';
							    
							    if ($i == $len ) {
							        // last
							    } else {
							    	$output['content'] .= ',';
							    }

							}
							    
						}
					}

					$output['content'] .= '
							  ]
							}
							</script>';

					// END AUTHOR SCHEMA

				if($settings['icon_position'] == "top"){

					$iconset = $settings['pick_icon_set'];

					$output['content'] .= '<div id="sab-social-wrapper">';

					include 'icons-coauthor.php';

					$output['content'] .= '</div>';

				}

				if ( $settings['author_links'] == "not_linked" ){ 

					$output['content'] .= '<div id="sab-author"><span style="color:' . $settings['highlight_color'] . ';">' . $sab_coauthor->display_name . '</span></div><div id="sab-gravatar"><span>';
					if( !get_the_author_meta('avatar-url', $zeeauthor) ){
						$output['content'] .= get_avatar( get_the_author_meta('ID', $zeeauthor), $gravatar, '', $sab_coauthor->display_name );
					}else{
						$output['content'] .= '<img alt="' . $sab_coauthor->display_name . '" src="'.get_the_author_meta('avatar-url', $zeeauthor).'" />';
					}
					$output['content'] .= '</span></div>';

				}else{

					$output['content'] .= '<div id="sab-author"><a rel="'.$nofollowshort.'author" href="' . $author_name_link . '" title="' . get_the_author_meta( 'display_name', $zeeauthor) .'" target="' . $settings['link_target'] . '">' . $sab_coauthor->display_name . '</a></div><div id="sab-gravatar"><a '.$nofollow.'href="' . $author_avatar_link . '" target="' . $settings['link_target'] . '">';
					if( !get_the_author_meta('avatar-url', $zeeauthor) ){
						$output['content'] .= get_avatar( get_the_author_meta('ID', $zeeauthor), $gravatar, '', $sab_coauthor->display_name );
					}else{
						$output['content'] .= '<img alt="' . $sab_coauthor->display_name . '" src="'.get_the_author_meta('avatar-url', $zeeauthor).'" />';
					}
					$output['content'] .= '</a></div>';

				}

					if ( !get_the_author_meta('hide-job-title', $zeeauthor) && get_the_author_meta('job-title', $zeeauthor) ){ $showjobtitle = '<span id="sab-jobtitle">' . get_the_author_meta('job-title', $zeeauthor) . '</span>'; }

					if ( !get_the_author_meta('hide-company', $zeeauthor) && get_the_author_meta('company', $zeeauthor) ){ $showcompany = '<span id="sab-company"><a '.$nofollow.'href="' . esc_url(get_the_author_meta('company-website-url', $zeeauthor)) . '" target="' . $settings['link_target'] . '" style="color:' . $settings['highlight_color'] . ';">' . get_the_author_meta('company', $zeeauthor) . '</a></span>'; }

					if ( $showjobtitle && $showcompany ){ $showseparator = '<span id="sab-separator"> ' . $settings['separator'] . ' </span>'; }

					if( $showseparator && $showjobtitle && $showcompany ){ $output['content'] .= '<div id="sab-byline">'.$showjobtitle.$showseparator.$showcompany.'</div>'; }
					else if ( $showseparator && $showjobtitle || $showcompany ){
						$output['content'] .= '<div id="sab-byline">'.$showjobtitle.$showcompany.'</div>';
					}


				$output['content'] .= '<div id="sab-description">' . do_shortcode( nl2br( $sab_coauthor->description ) ) . '</div>';

				if($settings['icon_position'] == "bottom"){

					$iconset = $settings['pick_icon_set'];

					$output['content'] .= '<div id="sab-social-wrapper">';

					include 'icons-coauthor.php';

					$output['content'] .= '</div>';

				}

				$output['content'] .= '</div>';

				echo $output['content'];
				$bios = ob_get_contents();

				//}

			}

			
			ob_end_clean();
			return $bios;
				

		}else{

		$sabemail = get_the_author_meta( 'sabemail' );

		if($sabemail && strpos($sabemail, 'mailto') !== false){
			$mailto = "";
		}else if($sabemail && strpos($sabemail, 'mailto') !== true){
			$mailto = "mailto:";
		}else{
			$mailto = "";
		}

		// Set the social icons
		$social = array(
			'sabbehance'    => get_the_author_meta( 'sabbehance' ),
			'sabblogger'    => get_the_author_meta( 'sabblogger' ),
			'sabdelicious'    => get_the_author_meta( 'sabdelicious' ),
			'sabdeviantart'    => get_the_author_meta( 'sabdeviantart' ),
			'sabdribbble'    => get_the_author_meta( 'sabdribbble' ),
			'sabemail'    => get_the_author_meta( 'sabemail' ),
			'sabfacebook'    => get_the_author_meta( 'sabfacebook' ),
			'sabflickr'    => get_the_author_meta( 'sabflickr' ),
			'sabgithub'    => get_the_author_meta( 'sabgithub' ),
			'sabgoogle'    => get_the_author_meta( 'sabgoogle' ),
			'sabinstagram'    => get_the_author_meta( 'sabinstagram' ),
			'sablinkedin'    => get_the_author_meta( 'sablinkedin' ),
			'sabmyspace'    => get_the_author_meta( 'sabmyspace' ),
			'sabpinterest'    => get_the_author_meta( 'sabpinterest' ),
			'sabrss'    => get_the_author_meta( 'sabrss' ),
			'sabstumbleupon'    => get_the_author_meta( 'sabstumbleupon' ),
			'sabtumblr'    => get_the_author_meta( 'sabtumblr' ),
			'sabtwitter'    => get_the_author_meta( 'sabtwitter' ),
			'sabvimeo'    => get_the_author_meta( 'sabvimeo' ),
			'sabwordpress'    => get_the_author_meta( 'sabwordpress' ),
			'sabyahoo'    => get_the_author_meta( 'sabyahoo' ),
			'sabyoutube'    => get_the_author_meta( 'sabyoutube' )
		);

		$author = get_query_var('author');

		if ( $settings['author_links'] == "link_to_author_page" ){ 
			$author_name_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			$author_avatar_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
		}else{
			if ( get_the_author_meta('name-link') ){
				$author_name_link = esc_url( get_the_author_meta('name-link') );
			}else{
				$author_name_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			}
			if ( get_the_author_meta('avatar-link') ){
				$author_avatar_link = esc_url( get_the_author_meta('avatar-link') );
			}else{
				$author_avatar_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			}
		}

		if ( get_the_author_meta('hide-signature') ) { $hidden = "display:none!important;"; }else{ $hidden = ""; }

		$html = '<div id="sexy-author-bio" style="'.$hidden.'" class="';

		$html .= preg_replace("/[\s_]/", "-", strtolower(get_the_author()));
		$html .= '">';

		if ( $settings['nofollow_author_links'] == "nofollow" ){
			$nofollow = 'rel="nofollow" ';
			$nofollowshort = "nofollow ";
		}else {
			$nofollow = '';
			$nofollowshort = "";
		}

		if ($settings['icon_hover_effect'] == "fade"){
			$fade = 'class="bio-icon" ';
		}else{
			$fade = '';
		}

		$iconset = $settings['pick_icon_set'];

		if ( !get_the_author_meta('hide-job-title') && get_the_author_meta('job-title') ){ $showjobtitle = '<span id="sab-jobtitle">' . get_the_author_meta('job-title') . '</span>'; }

		if ( !get_the_author_meta('hide-company') && get_the_author_meta('company') ){ $showcompany = '<span id="sab-company"><a '.$nofollow.'href="' . esc_url(get_the_author_meta('company-website-url')) . '" target="' . $settings['link_target'] . '" style="color:' . $settings['highlight_color'] . ';">' . get_the_author_meta('company') . '</a></span>'; }

		if ( $settings['separator'] && $showjobtitle && $showcompany !== '' ){ $showseparator = '<span id="sab-separator"> ' . $settings['separator'] . ' </span>'; }

		if( $showseparator && $showjobtitle && $showcompany ){ 
			$titleline = '<div id="sab-byline">'.$showjobtitle.$showseparator.$showcompany.'</div>'; 
		}
		else if( $showseparator && $showjobtitle || $showcompany ){ 
			$titleline = '<div id="sab-byline">'.$showjobtitle.$showcompany.'</div>'; 
		}

			// BEGIN AUTHOR SCHEMA

			$html .= '<script type="application/ld+json">
					{
					  "@context" : "http://schema.org",
					  "@type" : "Person",
					  "name" : "' . get_the_author() . '",
					  "url" : "' . get_the_author_meta('name-link') . '",
					  "sameAs" : [';

			$l = 0;

			foreach ( ($social) as $network => $url ) {
				
				if( strpos($url,'sabfacebook') !== false || strpos($url,'sabtwitter') !== false || strpos($url,'sabgoogle') !== false || strpos($url,'sabinstagram') !== false || strpos($url,'sabyoutube') !== false || strpos($url,'sablinkedin') !== false || strpos($url,'sabmyspace') !== false || strpos($url,'sabpinterest') !== false || strpos($url,'sabsoundcloud') !== false || strpos($url,'sabtumblr') !== false ){

						$l++;

				}

			}

			$len = $l;

			$i = 0;

			foreach ( ($social) as $network => $url ) {

				if ( $url ){

					$i++;

					if( strpos($url,'sabfacebook') !== false || strpos($url,'sabtwitter') !== false || strpos($url,'sabgoogle') !== false || strpos($url,'sabinstagram') !== false || strpos($url,'sabyoutube') !== false || strpos($url,'sablinkedin') !== false || strpos($url,'sabmyspace') !== false || strpos($url,'sabpinterest') !== false || strpos($url,'sabsoundcloud') !== false || strpos($url,'sabtumblr') !== false ){
						
						$html .= '"' . $url . '"';
					    
					    if ($i == $len ) {
					        // last
					    } else {
					    $html .= ',';
					    }

					}
					    
				}
			}

			$html .= '
					  ]
					}
					</script>';

			// END AUTHOR SCHEMA

		if($settings['icon_position'] == "top"){

				$html .= '<div id="sab-social-wrapper">';

				include 'icons-standard.php';

				$html .= '</div>';

			}

		if ( $settings['author_links'] == "not_linked" ){ 
			$html .= '<div id="sab-author"><span style="color:' . $settings['highlight_color'] . ';">' . get_the_author() . '</span></div><div id="sab-gravatar"><span style="color:' . $settings['highlight_color'] . ';">';
			if( !get_the_author_meta('avatar-url') ){
				$html .= get_avatar( get_the_author_meta('ID'), $gravatar, '', get_the_author() );
			}else{
				$html .= '<img alt="'.get_the_author().'" src="'.get_the_author_meta('avatar-url').'" />';
			}
			$html .= '</span></div>'.$titleline.'<div id="sab-description">' . do_shortcode( nl2br( apply_filters( 'sexyauthorbio_author_description', get_the_author_meta( 'description' ) ) ) ) . '</div>';
			$html .= '</div>';
		}else{
			$html .= '<div id="sab-author"><a rel="'.$nofollowshort.'author" href="' . $author_name_link . '" title="' . esc_attr( __( '', self::get_plugin_slug() ) . '' . get_the_author() ) .'" target="' . $settings['link_target'] . '">' . get_the_author() . '</a></div><div id="sab-gravatar"><a '.$nofollow.'href="' . $author_avatar_link . '" target="' . $settings['link_target'] . '">';
			if( !get_the_author_meta('avatar-url') ){
				$html .= get_avatar( get_the_author_meta('ID'), $gravatar, '', get_the_author() );
			}else{
				$html .= '<img alt="'.get_the_author().'" src="'.get_the_author_meta('avatar-url').'" />';
			}
			$html .= '</a></div>'.$titleline.'<div id="sab-description">' . do_shortcode( nl2br( apply_filters( 'sexyauthorbio_author_description', get_the_author_meta( 'description' ) ) ) ) . '</div>';
			
			if($settings['icon_position'] == "bottom"){
		
				$html .= '<div id="sab-social-wrapper">';

				include 'icons-standard.php';

				$html .= '</div>';

			}

			$html .= '</div>';
		}


		return $html;

		}

	}

	/**
	 * Insert the box in the content.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $content WP the content.
	 *
	 * @return string          WP the content with WP Author Bio.
	 */
	public function display( $content ) {
		// Get the settings.
		$settings = get_option( 'sexyauthorbio_settings' );

		if ( $this->is_display( $settings ) ) {
			return $content . self::view( $settings );
		}

		return $content;
	}

	public function hook_css() {
		// Get the settings.
		$settings = get_option( 'sexyauthorbio_settings' );

			// Set the styes.
			$styles = sprintf(
				'background: %1$s; border-style: %2$s; border-color: %3$s; color: %4$s; border-top-width: %5$spx; border-right-width: %6$spx; border-bottom-width: %7$spx; border-left-width: %8$spx;',
				$settings['background_color'],
				$settings['border_style'],
				$settings['border_color'],
				$settings['text_color'],
				$settings['border_top_size'],
				$settings['border_right_size'],
				$settings['border_bottom_size'],
				$settings['border_left_size']
			);

			$customcss = $settings['custom_css_default'];
			$customcssdesktop = $settings['custom_css_desktop'];
			$customcssipadlandscape = $settings['custom_css_ipad_landscape'];
			$customcssipadportrait = $settings['custom_css_ipad_portrait'];
			$customcsssmartphones = $settings['custom_css_smartphones'];
			$mobileavatardisplay = $settings['mobile_avatar_display'];
			if($mobileavatardisplay == "hide"){ 
				$mobileavatardisplay = "#sab-gravatar{display:none!important;}"; 
			}else{
				$mobileavatardisplay = "";
			}

			$output = '<style id="sexy-author-bio-css" type="text/css" media="screen">
					  #sexy-author-bio { ' . $styles . ' }
					  #sab-author { '
						.($settings['author_name_font'] ? 'font-family: '.$settings['author_name_font'].';' : '')
						.($settings['author_name_font_weight'] ? 'font-weight: '.$settings['author_name_font_weight'].';' : '')
						.($settings['author_name_font_size'] ? 'font-size: '.$settings['author_name_font_size'].'px;' : '')
						.($settings['author_name_line_height'] ? 'line-height: '.$settings['author_name_line_height'].'px;' : '')
					  .'}
					  #sab-gravatar { '
						.($settings['gravatar'] ? 'width: '.$settings['gravatar'].'px;' : '')
					  .'}';

		if ( $settings['author_links'] == "not_linked" ){ 

			$output .= '#sab-gravatar span { '
						.($settings['highlight_color'] ? 'color: '.$settings['highlight_color'].';' : '')
					  .'}
					  #sab-author span { 
					    margin-right:10px;'
						.($settings['author_name_decoration'] ? 'text-decoration: '.$settings['author_name_decoration'].';' : '')
						.($settings['author_name_capitalization'] ? 'text-transform: '.$settings['author_name_capitalization'].';' : '')
						.($settings['highlight_color'] ? 'color: '.$settings['highlight_color'].';' : '')
					  .'}';

		}else{

			$output .= '#sab-gravatar a { '
						.($settings['highlight_color'] ? 'color: '.$settings['highlight_color'].';' : '')
					  .'}
					  #sab-author a { 
					    margin-right:10px;'
						.($settings['author_name_decoration'] ? 'text-decoration: '.$settings['author_name_decoration'].';' : '')
						.($settings['author_name_capitalization'] ? 'text-transform: '.$settings['author_name_capitalization'].';' : '')
						.($settings['highlight_color'] ? 'color: '.$settings['highlight_color'].';' : '')
					  .'}';

		}

			$output .= '#sab-byline { '
						.($settings['byline_color'] ? 'color: '.$settings['byline_color'].';' : '')
						.($settings['author_byline_font'] ? 'font-family: '.$settings['author_byline_font'].';' : '')
						.($settings['author_byline_font_weight'] ? 'font-weight: '.$settings['author_byline_font_weight'].';' : '')
						.($settings['author_byline_font_size'] ? 'font-size: '.$settings['author_byline_font_size'].'px;' : '')
						.($settings['author_byline_line_height'] ? 'line-height: '.$settings['author_byline_line_height'].'px;' : '')
						.($settings['author_byline_decoration'] ? 'text-decoration: '.$settings['author_byline_decoration'].';' : '')
						.($settings['author_byline_capitalization'] ? 'text-transform: '.$settings['author_byline_capitalization'].';' : '')
					  .'}
					  #sab-description { '
						.($settings['author_biography_font'] ? 'font-family: '.$settings['author_biography_font'].';' : '')
						.($settings['author_biography_font_weight'] ? 'font-weight: '.$settings['author_biography_font_weight'].';' : '')
						.($settings['author_biography_font_size'] ? 'font-size: '.$settings['author_biography_font_size'].'px;' : '')
						.($settings['author_biography_line_height'] ? 'line-height: '.$settings['author_biography_line_height'].'px;' : '')
					  .'}
					  [id^=sig-] { '
						.($settings['icon_size'] ? 'height: '.$settings['icon_size'].'px;' : '')
						.($settings['icon_size'] ? 'width: '.$settings['icon_size'].'px;' : '')
						.($settings['icon_spacing'] ? 'margin-top: '.$settings['icon_spacing'].'px;margin-right: '.$settings['icon_spacing'].'px;margin-bottom: '.$settings['icon_spacing'].'px;' : '')
						.($settings[''] ? 'SELECTOR: '.$settings[''].';' : '')
						.($settings[''] ? 'SELECTOR: '.$settings[''].';' : '')
						.($settings[''] ? 'SELECTOR: '.$settings[''].';' : '')
						.($settings[''] ? 'SELECTOR: '.$settings[''].';' : '')
					  .'}
					  '.$customcss.'
					  @media (min-width: 1200px) {
					  '.$customcssdesktop.'
					  }
					  @media (min-width: 1019px) and (max-width: 1199px) {
					  '.$customcssipadlandscape.'
					  }
					  @media (min-width: 768px) and (max-width: 1018px) {
					  '.$customcssipadportrait.'
					  }
					  @media (max-width: 767px) {
					  [id^=sig-] { margin-left: 0;'
						.($settings['icon_spacing'] ? 'margin-right: '.$settings['icon_spacing'].'px;' : '')
					  .'}
					  '.$customcsssmartphones.$mobileavatardisplay.'
					  }
					  </style>';

	echo $output;

	}

}
