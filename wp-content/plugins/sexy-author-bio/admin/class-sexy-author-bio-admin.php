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
 * Sexy_Author_Bio_Admin class.
 *
 * @package   WP_Author_Bio_Admin
 * @author    Andy Forsberg <andy@penguinwp.com>
 */
class Sexy_Author_Bio_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		$this->plugin_slug = Sexy_Author_Bio::get_plugin_slug();

		// Custom contact methods.
		add_filter( 'user_contactmethods', array( $this, 'contact_methods' ), 10, 1 );

		// Load admin JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Init plugin options form.
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );

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
	 * Sets default settings.
	 *
	 * @since  1.0.0
	 *
	 * @return array Plugin default settings.
	 */
	protected function default_settings() {

		$settings = array(
			'settings' => array(
				'title' => __( 'Functionality', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'display' => array(
				'title' => __( 'Display in', $this->plugin_slug ),
				'default' => 'posts',
				'type' => 'select',
				'description' => sprintf( __( 'You can display the box directly into your theme using: %s', $this->plugin_slug ), '<br /><code>&lt;?php if ( function_exists( \'get_Sexy_Author_Bio\' ) ) echo get_Sexy_Author_Bio(); ?&gt;</code><br />You can also use this shortcode:<br /><code>[sexy_author_bio]</code>' ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'posts' => __( 'Only in Posts', $this->plugin_slug ),
					'home_posts' => __( 'Homepage and Posts', $this->plugin_slug ),
					'none' => __( 'None', $this->plugin_slug ),
				)
			),
			'author_links' => array(
				'title' => __( 'Author Links', $this->plugin_slug ),
				'default' => 'users_set',
				'type' => 'select',
				'description' => sprintf( __( 'Control whether or not users can set avatar and name links', $this->plugin_slug ) ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'users_set' => __( 'Users set the links', $this->plugin_slug ),
					'link_to_author_page' => __( 'Author avatar and name link to author page', $this->plugin_slug ),
					'not_linked' => __( 'Remove links from author avatar and name', $this->plugin_slug ),
				)
			),
			'nofollow_author_links' => array(
				'title' => __( 'Nofollow Links', $this->plugin_slug ),
				'default' => 'follow',
				'type' => 'select',
				'description' => sprintf( __( 'Toggle WP Author Bio links between follow and nofollow', $this->plugin_slug ) ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'follow' => __( 'FOLLOW Links', $this->plugin_slug ),
					'nofollow' => __( 'NOFOLLOW Links', $this->plugin_slug ),
				)
			),
			'link_target' => array(
				'title' => __( 'Link Target', $this->plugin_slug ),
				'default' => '_blank',
				'type' => 'select',
				'description' => sprintf( __( 'Set WP Author Bio links to open in current window or in a new window', $this->plugin_slug ) ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'_top' => __( 'Load in the full body of the window', $this->plugin_slug ),
					'_blank' => __( 'Load in a new window', $this->plugin_slug ),
				)
			),
			'design' => array(
				'title' => __( 'Design', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'gravatar' => array(
				'title' => __( 'Gravatar size', $this->plugin_slug ),
				'default' => 100,
				'type' => 'text',
				'description' => sprintf( __( 'Set the Gravatar size (only integers). To configure the profile picture of the author you need to register in %s', $this->plugin_slug ), '<a href="gravatar.com">gravatar.com</a>' ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_font_size' => array(
				'title' => __( 'Author Name Font Size', $this->plugin_slug ),
				'default' => 32,
				'type' => 'text',
				'description' => sprintf( __( 'Set the author name font size in pixels', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_line_height' => array(
				'title' => __( 'Author Name Line Height', $this->plugin_slug ),
				'default' => 32,
				'type' => 'text',
				'description' => sprintf( __( 'Set the author name line height in pixels (the same line height as the font size is a good starting point)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_font' => array(
				'title' => __( 'Author Name Font', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author name font', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_font_weight' => array(
				'title' => __( 'Author Name Font Weight', $this->plugin_slug ),
				'default' => '400',
				'type' => 'select',
				'description' => sprintf( __( 'Set the author name font weight (different fonts allow for different weight options)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'100' => __( 'Extra Light or Ultra Light', $this->plugin_slug ),
					'200' => __( 'Light or Thin', $this->plugin_slug ),
					'300' => __( 'Book or Demi', $this->plugin_slug ),
					'400' => __( 'Normal or Regular', $this->plugin_slug ),
					'500' => __( 'Medium', $this->plugin_slug ),
					'600' => __( 'Semibold, Demibold', $this->plugin_slug ),
					'700' => __( 'Bold', $this->plugin_slug ),
					'800' => __( 'Black, Extra Bold or Heavy', $this->plugin_slug ),
					'900' => __( 'Extra Black, Fat, Poster or Ultra Black', $this->plugin_slug )
				)
			),
			'author_name_capitalization' => array(
				'title' => __( 'Author Name Capitalization', $this->plugin_slug ),
				'default' => 'none',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'uppercase' => __( 'UPPERCASE', $this->plugin_slug ),
					'capitalize' => __( 'Capitalize', $this->plugin_slug ),
					'lowercase' => __( 'lowercase', $this->plugin_slug ),
					'none' => __( 'As is', $this->plugin_slug )
				)
			),
			'author_name_decoration' => array(
				'title' => __( 'Author Name Decoration', $this->plugin_slug ),
				'default' => 'none',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'none' => __( 'None', $this->plugin_slug ),
					'underline' => __( 'Underline', $this->plugin_slug )
				)
			),
			'author_byline_font_size' => array(
				'title' => __( 'Author Byline Font Size', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author byline (Job Title &amp; Company) font size in pixels', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_byline_line_height' => array(
				'title' => __( 'Author Byline Line Height', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author byline line height in pixels (the same line height as the font size is a good starting point)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_byline_font' => array(
				'title' => __( 'Author Byline Font', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author byline (Job Title &amp; Company) font', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_byline_font_weight' => array(
				'title' => __( 'Author Byline Font Weight', $this->plugin_slug ),
				'default' => '400',
				'type' => 'select',
				'description' => sprintf( __( 'Set the author byline font weight (different fonts allow for different weight options)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'100' => __( 'Extra Light or Ultra Light', $this->plugin_slug ),
					'200' => __( 'Light or Thin', $this->plugin_slug ),
					'300' => __( 'Book or Demi', $this->plugin_slug ),
					'400' => __( 'Normal or Regular', $this->plugin_slug ),
					'500' => __( 'Medium', $this->plugin_slug ),
					'600' => __( 'Semibold, Demibold', $this->plugin_slug ),
					'700' => __( 'Bold', $this->plugin_slug ),
					'800' => __( 'Black, Extra Bold or Heavy', $this->plugin_slug ),
					'900' => __( 'Extra Black, Fat, Poster or Ultra Black', $this->plugin_slug )
				)
			),
			'author_byline_capitalization' => array(
				'title' => __( 'Author Byline Capitalization', $this->plugin_slug ),
				'default' => 'uppercase',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'uppercase' => __( 'UPPERCASE', $this->plugin_slug ),
					'capitalize' => __( 'Capitalize', $this->plugin_slug ),
					'lowercase' => __( 'lowercase', $this->plugin_slug ),
					'none' => __( 'As is', $this->plugin_slug )
				)
			),
			'author_byline_decoration' => array(
				'title' => __( 'Author Byline Decoration', $this->plugin_slug ),
				'default' => 'none',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'none' => __( 'None', $this->plugin_slug ),
					'underline' => __( 'Underline', $this->plugin_slug )
				)
			),
			'author_biography_font_size' => array(
				'title' => __( 'Author Biography Font Size', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author biography font size in pixels', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_biography_line_height' => array(
				'title' => __( 'Author Biography Line Height', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author biography line height in pixels (the same line height as the font size is a good starting point)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_biography_font' => array(
				'title' => __( 'Author Biography Font', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author biography font', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_biography_font_weight' => array(
				'title' => __( 'Author Biography Font Weight', $this->plugin_slug ),
				'default' => '400',
				'type' => 'select',
				'description' => sprintf( __( 'Set the author biography font weight (different fonts allow for different weight options)', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'100' => __( 'Extra Light or Ultra Light', $this->plugin_slug ),
					'200' => __( 'Light or Thin', $this->plugin_slug ),
					'300' => __( 'Book or Demi', $this->plugin_slug ),
					'400' => __( 'Normal or Regular', $this->plugin_slug ),
					'500' => __( 'Medium', $this->plugin_slug ),
					'600' => __( 'Semibold, Demibold', $this->plugin_slug ),
					'700' => __( 'Bold', $this->plugin_slug ),
					'800' => __( 'Black, Extra Bold or Heavy', $this->plugin_slug ),
					'900' => __( 'Extra Black, Fat, Poster or Ultra Black', $this->plugin_slug )
				)
			),
			'separator' => array(
				'title' => __( 'Job Title Company Separator', $this->plugin_slug ),
				'default' => 'at',
				'type' => 'text',
				'description' => sprintf( __( 'Set the text to separate job title and company', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'background_color' => array(
				'title' => __( 'Background color', $this->plugin_slug ),
				'default' => '#333333',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'highlight_color' => array(
				'title' => __( 'Highlight color', $this->plugin_slug ),
				'default' => '#0088cc',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'text_color' => array(
				'title' => __( 'Text color', $this->plugin_slug ),
				'default' => '#ffffff',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'byline_color' => array(
				'title' => __( 'Byline color', $this->plugin_slug ),
				'default' => '#777777',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'border_top_size' => array(
				'title' => __( 'Top Border size', $this->plugin_slug ),
				'default' => 0,
				'type' => 'text',
				'section' => 'design',
				'description' => __( 'Thickness of the top border of the box (only integers)', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'border_right_size' => array(
				'title' => __( 'Right Border size', $this->plugin_slug ),
				'default' => 0,
				'type' => 'text',
				'section' => 'design',
				'description' => __( 'Thickness of the right border of the box (only integers)', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'border_bottom_size' => array(
				'title' => __( 'Bottom Border size', $this->plugin_slug ),
				'default' => 0,
				'type' => 'text',
				'section' => 'design',
				'description' => __( 'Thickness of the bottom border of the box (only integers)', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'border_left_size' => array(
				'title' => __( 'Left Border size', $this->plugin_slug ),
				'default' => 0,
				'type' => 'text',
				'section' => 'design',
				'description' => __( 'Thickness of the left border of the box (only integers)', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'border_style' => array(
				'title' => __( 'Border style', $this->plugin_slug ),
				'default' => 'solid',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'none' => __( 'None', $this->plugin_slug ),
					'solid' => __( 'Solid', $this->plugin_slug ),
					'dotted' => __( 'Dotted', $this->plugin_slug ),
					'dashed' => __( 'Dashed', $this->plugin_slug )
				)
			),
			'border_color' => array(
				'title' => __( 'Border color', $this->plugin_slug ),
				'default' => '#444444',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'mobile' => array(
				'title' => __( 'Mobile', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'mobile_avatar_display' => array(
				'title' => __( 'Display Avatar on Smartphones', $this->plugin_slug ),
				'default' => 'hide',
				'type' => 'select',
				'section' => 'mobile',
				'description' => __( 'Toggle display of WP Author Bio Avatars on smartphones (0 - 767px in width)', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'display' => __( 'Display', $this->plugin_slug ),
					'hide' => __( 'Hide', $this->plugin_slug )
				)
			),
			'user_roles' => array(
				'title' => __( 'User Roles', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'user_roles_access' => array(
				'title' => __( 'Allow Access For', $this->plugin_slug ),
				'default' => 'contributors',
				'type' => 'select',
				'section' => 'user_roles',
				'description' => __( 'Control which user roles have access to WP Author Bio user fields', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'admins' => __( 'Admins', $this->plugin_slug ),
					'editors' => __( 'Admins and Editors', $this->plugin_slug ),
					'authors' => __( 'Admins, Editors and Authors', $this->plugin_slug ),
					'contributors' => __( 'Admins, Editors, Authors and Contributors', $this->plugin_slug )
				)
			),
			'icon_set' => array(
				'title' => __( 'Icon Set', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'icon_size' => array(
				'title' => __( 'Icon size (in pixels)', $this->plugin_slug ),
				'default' => 64,
				'type' => 'text',
				'section' => 'icon_set',
				'description' => __( 'The height & width of the social icons.<br /><strong>DO NOT SET ABOVE 64!</strong>', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'icon_spacing' => array(
				'title' => __( 'Icon spacing (in pixels)', $this->plugin_slug ),
				'default' => 2,
				'type' => 'text',
				'section' => 'icon_set',
				'description' => __( 'The width between social icons', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'icon_hover_effect' => array(
				'title' => __( 'Icon Hover Effect', $this->plugin_slug ),
				'default' => 'fade',
				'type' => 'select',
				'section' => 'icon_set',
				'description' => __( 'The effect when users hover over social icons with their cursor', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'fade' => __( 'Fade', $this->plugin_slug ),
					'none' => __( 'None', $this->plugin_slug )
				)
			),
			'icon_position' => array(
				'title' => __( 'Icon Position', $this->plugin_slug ),
				'default' => 'fade',
				'type' => 'select',
				'section' => 'icon_set',
				'description' => __( 'The position of the icons relative to the bio', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'top' => __( 'Top', $this->plugin_slug ),
					'bottom' => __( 'Bottom', $this->plugin_slug )
				)
			),
			'pick_icon_set' => array(
				'title' => __( 'Pick Icon Set', $this->plugin_slug ),
				'default' => 'flat-square',
				'type' => 'select',
				'section' => 'icon_set',
				'description' => __( '<div style="background-color:#ffffff;padding:20px;border:solid 1px #eee;width:100%;max-width:1100px;"><img id="sab-icon-set" src="'.plugins_url().'/sexy-author-bio/public/assets/images/social-icon-sets.png" style="width: 100%;max-width:1100px;></div>', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'flat-square' => __( 'Flat Squares', $this->plugin_slug ),
					'flat-square-rounded' => __( 'Flat Squares Rounded', $this->plugin_slug ),
					'shadow-square' => __( 'Shadow Squares', $this->plugin_slug ),
					'flat-circle' => __( 'Flat Circles', $this->plugin_slug ),
					'shadow-circle' => __( 'Shadow Circles', $this->plugin_slug )
				)
			),
			'custom_css' => array(
				'title' => __( 'Custom CSS', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_default' => array(
				'title' => __( 'YOUR Custom CSS', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'custom_css',
				'description' => __( 'Paste your custom CSS here', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'responsive_css' => array(
				'title' => __( 'Responsive CSS', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_desktop' => array(
				'title' => __( 'DESKTOP<br />1,200px +', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for DESKTOP 1,200px + here', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_ipad_landscape' => array(
				'title' => __( 'IPAD LANDSCAPE<br />1019 - 1199px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for IPAD LANDSCAPE 1019 - 1199px here', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_ipad_portrait' => array(
				'title' => __( 'IPAD PORTRAIT<br />768 - 1018px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for IPAD PORTRAIT 768 - 1018px here', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_smartphones' => array(
				'title' => __( 'SMARTPHONES<br />0 - 767px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for SMARTPHONES 0 - 767px here', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
		);

		return $settings;

	}

	/**
	 * Custom contact methods.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $methods Old contact methods.
	 *
	 * @return array          New contact methods.
	 */
	public function contact_methods( $methods ) {
		// Add new methods.
		$methods['sabbehance']   = __( 'Author Bio - Behance URL', $this->plugin_slug );
		$methods['sabblogger']   = __( 'Author Bio - Blogger URL', $this->plugin_slug );
		$methods['sabdelicious']   = __( 'Author Bio - Delicious URL', $this->plugin_slug );
		$methods['sabdeviantart']   = __( 'Author Bio - DeviantArt URL', $this->plugin_slug );
		$methods['sabdribbble']   = __( 'Author Bio - Dribbble URL', $this->plugin_slug );
		$methods['sabemail']   = __( 'Author Bio - Email Address', $this->plugin_slug );
		$methods['sabfacebook']   = __( 'Author Bio - Facebook URL', $this->plugin_slug );
		$methods['sabflickr']   = __( 'Author Bio - Flickr URL', $this->plugin_slug );
		$methods['sabgithub']   = __( 'Author Bio - GitHub URL', $this->plugin_slug );
		$methods['sabgoogle']   = __( 'Author Bio - Google+ URL', $this->plugin_slug );
		$methods['sabinstagram']   = __( 'Author Bio - Instagram URL', $this->plugin_slug );
		$methods['sablinkedin']   = __( 'Author Bio - LinkedIn URL', $this->plugin_slug );
		$methods['sabmyspace']   = __( 'Author Bio - MySpace URL', $this->plugin_slug );
		$methods['sabpinterest']   = __( 'Author Bio - Pinterest URL', $this->plugin_slug );
		$methods['sabrss']   = __( 'Author Bio - RSS Feed URL', $this->plugin_slug );
		$methods['sabstumbleupon']   = __( 'Author Bio - StumbleUpon URL', $this->plugin_slug );
		$methods['sabtumblr']   = __( 'Author Bio - Tumblr URL', $this->plugin_slug );
		$methods['sabtwitter']   = __( 'Author Bio - Twitter URL', $this->plugin_slug );
		$methods['sabvimeo']   = __( 'Author Bio - Vimeo URL', $this->plugin_slug );
		$methods['sabwordpress']   = __( 'Author Bio - WordPress URL', $this->plugin_slug );
		$methods['sabyahoo']   = __( 'Author Bio - Yahoo! URL', $this->plugin_slug );
		$methods['sabyoutube']   = __( 'Author Bio - YouTube URL', $this->plugin_slug );

		// Remove old methods.
		unset( $methods['aim'] );
		unset( $methods['yim'] );
		unset( $methods['jabber'] );

		return $methods;
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since  1.0.0
	 *
	 * @return null Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				$this->plugin_slug . '-admin',
				plugins_url( 'assets/js/admin.min.js', __FILE__ ),
				array( 'jquery', 'wp-color-picker' ),
				null,
				true
			);
		}
	}

	/**
	 * Register the administration menu for this plugin into the
	 * WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	/*public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WP Author Bio', $this->plugin_slug ),
			__( 'WP Author Bio', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
	}*/

	/**
	* Create Admin Menu for WP Author Bio
	*
	*/
	public function add_plugin_admin_menu(){
		
		// WP Author Bio Admin Menu
		add_menu_page( 
				'Settings',
				'WP Author Bio',
				'manage_options',
				'sexy-author-bio', 
				array( $this,'display_plugin_admin_page' ),
				'dashicons-id', 
				40
		);
		
		add_submenu_page(
			'sexy-author-bio',
			'WP Author Bio Settings',
			'Settings', 
			'manage_options', 
			'sexy-author-bio',
			array( $this, 'display_plugin_admin_page' )
		);

		// Add-Ons Coming Soon!
		/*add_submenu_page(
			'sexy-author-bio',
			'WP Author Bio Addons',
			'Add-ons', 
			'manage_options', 
			'sexy-author-bio-addons',
			array( $this, 'display_plugin_addon_page' )
		);*/

		add_submenu_page(
			'sexy-author-bio',
			'About WP Author Bio',
			'About',
			'manage_options', 
			'sexy-author-bio-about',
			array( $this, 'display_plugin_about_page' )
		);

	}

	/**
	 * Plugin settings form fields.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function plugin_settings() {
		$settings = 'sexyauthorbio_settings';

		foreach ( $this->default_settings() as $key => $value ) {

			switch ( $value['type'] ) {
				case 'section':
					add_settings_section(
						$key,
						$value['title'],
						'__return_false',
						$value['menu']
					);
					break;
				case 'text':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'text_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'small-text',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'textarea':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'textarea_element_callback'),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'large-text',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'checkbox':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'checkbox_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'checkbox',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'select':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'select_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'description' => isset( $value['description'] ) ? $value['description'] : '',
							'options' => $value['options']
						)
					);
					break;
				case 'color':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'color_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;

				default:
					break;
			}

		}

		// Register settings.
		register_setting( $settings, $settings, array( $this, 'validate_options' ) );
	}

	/**
	 * Text element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function text_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'small-text';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<input style="width:200px;" type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Text Area element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function textarea_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'large-text';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<textarea style="width:550px;height: 175px;" type="text" id="%1$s" name="%2$s[%1$s]" class="%4$s" />%3$s</textarea>', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Text element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function checkbox_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'checkbox';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Select field fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Select field.
	 */
	public function select_element_callback( $args ) {
		$menu = $args['menu'];
		$id   = $args['id'];

		$options = get_option( $menu );

		// Sets current option.
		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $menu );
		foreach( $args['options'] as $key => $label ) {
			$key = sanitize_title( $key );

			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
		}
		$html .= '</select>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Color field.
	 */
	public function color_element_callback( $args ) {
		$menu = $args['menu'];
		$id   = $args['id'];

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '#333333';
		}

		$html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="sexy-author-bio-color-field" />', $id, $menu, $current );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Valid options.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $input options to valid.
	 *
	 * @return array        validated options.
	 */
	public function validate_options( $input ) {
		// Create our array for storing the validated options.
		$output = array();

		// Loop through each of the incoming options.
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings.
				$output[ $key ] = sanitize_text_field( $input[ $key ] );
			}
		}

		return $output;
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once 'views/admin.php';
	}

	/**
	 * Render the addons page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_addon_page() {
		include_once 'views/addons.php';
	}

	/**
	 * Render the about page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_about_page() {
		include_once 'views/about.php';
	}

}
