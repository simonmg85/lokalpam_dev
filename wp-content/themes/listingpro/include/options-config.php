<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
	
	$allowed_html_array = array(
		'i' => array(
			'class' => array()
		),
		'span' => array(
			'class' => array()
		),
		'a' => array(
			'href' => array(),
			'title' => array(),
			'target' => array()
		)
	);


    // This is your option name where all the Redux data is stored.
    $opt_name = "listingpro_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';


    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();



    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'listingpro' ),
        'page_title'           => __( 'Theme Options', 'listingpro' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => true,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.


    );




    
    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */




    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */
	// -> START General Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'listingpro' ),
        'id'               => 'general-settings',
        'customizer_width' => '400px',
        'icon'             => 'el el-cogs',
        'fields'     => array(
			 array(
                'id'       => 'theme_color',
                'type'     => 'color',
                'title'    => __('Primary Theme Color', 'listingpro'), 
                'subtitle' => __('(default: #41a6df).', 'listingpro'),
                'default'  => '#41a6df',
                'validate' => 'color',
            ),
            array(
                'id'       => 'sec_theme_color',
                'type'     => 'color',
                'title'    => __('Secondary Theme Color', 'listingpro'), 
                'subtitle' => __('(default: #363F48).', 'listingpro'),
                'default'  => '#363F48',
                'validate' => 'color',
            ),
            array(
                'id'       => 'lp_register_password',
                'type'     => 'switch',
                'title'    => __( 'Password Field For User SignUp Form', 'listingpro' ),
                'desc'     => __( 'On for enable and Off for disable password field', 'listingpro' ),
                'default'  => 0,
            ),
			array(
                'id'       => 'lp_register_username',
                'type'     => 'switch',
                'title'    => __( 'User-Name Field For Instant Registration', 'listingpro' ),
				'subtitle' => __('On instant signup during listing and review submission, show/hide user-name field for user registration', 'listingpro'),
                'desc'     => __( 'ON=Enable, OFF=Disable', 'listingpro' ),
                'default'  => false,
            ),
			
			array(
                'id'       => 'lp_showhide_pagetitle',
                'type'     => 'switch',
                'title'    => __( 'Show/Hide Page Title', 'listingpro' ),
                'desc'     => __( 'Page Title show/hide on pages.', 'listingpro' ),
                'default'  => 1,
            ),
			array(
                'id'       => 'listing_pricerange_symbol',
                'type'     => 'text',
                'title'    => __( 'Currency symbol for price range', 'listingpro' ),
                'subtitle' => __( 'For example "$/¥/£/ etc". Use only one currency symbol', 'listingpro' ),
                'default'  => '$',
            ),
           
			 array(
                'id'       => 'css_editor',
                'type'     => 'ace_editor',
                'title'    => __('Custom CSS', 'listingpro'),
                'subtitle' => __('Paste your CSS code here.', 'listingpro'),
                'mode'     => 'css',
                'theme'    => 'monokai',
                'desc'     => '',
                'default'  => "#header{\nmargin: 0 auto;\n}"
            ),
            array(
                'id'       => 'script_editor',
                'type'     => 'ace_editor',
                'title'    => __('Custom JS', 'listingpro'),
                'subtitle' => __('Paste your JS code here.', 'listingpro'),
                'mode'     => 'css',
                'theme'    => 'monokai',
                'desc'     => '',
                'default'  => "jQuery(document).ready(function(){\n\n});"
            ),
			
			array(
                'id'       => 'lp_auto_current_locations_switch',
                'type'     => 'switch',
                'title'    => __( 'Current Location on banner and search field', 'listingpro' ),
                'desc'     => __( 'Current Locations enable/disable on search form and home banenr.', 'listingpro' ),
                'default'  => 1,
            ),
			
			array(
				'id'       => 'lp_current_ip_type',
				'type'     => 'select',
				'required' => array('lp_auto_current_locations_switch','equals','1'),
				'title'    => __('Select Method for Current location', 'listingpro'), 
				'subtitle' => __('', 'listingpro'),
				'desc'     => __("Above options are used to identify visitors current location. <br /><br /><strong>Geo IP DB/IP API</strong> = These always get location from user's IP address and it will only show what it will get from the IP address. If your IP does not have your exact current location, then you can choose any other option because IP location are related to the ISPs or mobile operators. <br /><br /><strong>GPS</strong> = GPS is based on user's current location which works with google API and it will prompt a location share popup on page load and if user does not share their location, then location system will not work", 'listingpro'),
				'options'  => array(
					'geo_ip_db' => 'Geo IP DB',
					'ip_api' => 'IP API',
					'gpsloc' => 'GPS',
				),
				'default'  => 'ip_api',
			),
        )
    ) );
	
	// -> START User Dashboard Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'User Dashboard', 'listingpro' ),
        'id'               => 'dashboard-settings',
        'customizer_width' => '400px',
        'icon'             => 'el el-user',
        'fields'     => array(
			 array(
                'id'       => 'dashboard_usr',
                'type'     => 'switch', 
                'title'    => __('Dashboard Option On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'resurva_bookings_enable',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Resurva Bookings', 'listingpro' ),
                'desc'     => __( '', 'listingpro' ),
                'default'  => 1,
            ),
			array(
                'id'       => 'timekit_bookings_enable',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Timekit Bookings', 'listingpro' ),
                'desc'     => __( '', 'listingpro' ),
                'default'  => 1,
            ),
           
			array(
                'id'       => 'my_listings',
                'type'     => 'switch', 
                'title'    => __('My Listings Info On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'saved_listing',
                'type'     => 'switch', 
                'title'    => __('Saved On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'invoices_dashboard',
                'type'     => 'switch', 
                'title'    => __('Invoices Options On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'dashboard_packages',
                'type'     => 'switch', 
                'title'    => __('Packages On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'ad_compaigns',
                'type'     => 'switch', 
                'title'    => __('Ad Campaign Options On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'review_dashoard',
                'type'     => 'switch', 
                'title'    => __('Reviews On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'booking_dashoard',
                'type'     => 'switch', 
                'title'    => __('Bookings On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => false,
            ),
			array(
                'id'       => 'menu_dashoard',
                'type'     => 'switch', 
                'title'    => __('Menus On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
	        array(
		        'id'       => 'menu_gallery_dashoard',
		        'type'     => 'switch',
		        'title'    => __('Menus Image Gallery On/Off', 'listingpro'),
		        'subtitle' => __('', 'listingpro'),
		        'default'  => false,
		        'required' => array('menu_dashoard','equals','1'),
	        ),
	        array(
		        'id'       => 'img_menu_dashoard',
		        'type'     => 'switch',
		        'title'    => __('Image Menu On Dashboard On/Off', 'listingpro'),
		        'subtitle' => __('', 'listingpro'),
		        'default'  => false,
		        'required' => array('menu_dashoard','equals','1'),
	        ),
            array(
                'id'       => 'announcements_dashoard',
                'type'     => 'switch',
                'title'    => __('Announcements On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
				'id'       => 'events_dashoard',
				'type'     => 'switch',
				'title'    => __('Events On Dashboard On/Off', 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default'  => true,
			),
            array(
                'id'       => 'discounts_dashoard',
                'type'     => 'switch',
                'title'    => __('Discount/Offers/Deals On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'my_profile',
                'type'     => 'switch', 
                'title'    => __('My Profile On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
			array(
                'id'       => 'log_outt',
                'type'     => 'switch', 
                'title'    => __('Logout On Dashboard On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
            array(
                'id'       => 'pub_pend_notice',
                'type'     => 'switch',
                'title'    => __('Notice to Listing', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
            array(
                'id'       => 'campgn_notice',
                'type'     => 'switch',
                'title'    => __('Notice to Create Campaigns', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
            ),
        )
    ) );

    // START Typo Section
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Typography', 'listingpro' ),
        'id'               => 'typography-settings',
        'customizer_width' => '400px',
        'icon'             => 'el el-file-edit',
        'fields'     => array(
            array(
                'id'       => 'typography-body',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Font', 'listingpro' ),
                'subtitle' => esc_html__( 'Specify the body font properties.', 'listingpro' ),
                'google'   => true,
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'default'     => array(
                    'color'       => '#7f7f7f',
                    'font-size'   => '',
                    'font-family' => 'Quicksand',
                    'font-weight' => '400',
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'nav_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Navigation Style and Anchor', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'line-height'  => false,
                'all_styles'=> true,
                'color' => false,
                'output'      => array('.menu-item a'),
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'font-style'  => '',
                    'font-family' => 'Quicksand',
                    'google'      => true,
                    'font-size'   => '',
                ),
            ),
            array(
                'id'          => 'h1_typo',
                'type'        => 'typography',
                'title'       => esc_html__('Heading h1 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '', 
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'h2_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Heading h2 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '', 
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'h3_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Heading h3 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '', 
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'h4_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Heading h4 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '', 
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'h5_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Heading h5 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '', 
                    'line-height' => ''
                ),
            ),
            array(
                'id'          => 'h6_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Heading h6 Style', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#333', 
                    'font-style'  => '', 
                    'font-family' => 'Quicksand', 
                    'google'      => true,
                    'font-size'   => '16px', 
                    'line-height' => '27px'
                ),
            ),
            array(
                'id'          => 'paragraph_typo',
                'type'        => 'typography', 
                'title'       => esc_html__('Paragraph and small elements', 'listingpro'),
                'google'      => true, 
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'=> true,
                'units'       =>'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'listingpro'),
                'default'     => array(
                    'color'       => '#7f7f7f', 
                    'font-style'  => '', 
                    'font-family' => 'Open Sans', 
                    'google'      => true,
                    'font-size'   => '',
                    'line-height' => ''
                ),
            )
        )
    ) );
	// -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header', 'listingpro' ),
        'id'               => 'Header',
        'customizer_width' => '400px',
        'icon'             => 'el el-home',
		'fields'     => array(
            array(
                'id'       => 'header_views',
                'type'     => 'image_select',
                'title'    => esc_html__('Header layout', 'listingpro'), 
                'subtitle' => esc_html__('', 'listingpro'),
                'options'  => array(
                    'header_with_topbar'      => array(
                        'alt'   => 'Listing detail layout', 
                        'img'   => get_template_directory_uri().'/assets/images/admin/header-with-topbar.jpg'
                    ),
                    'header_menu_bar'      => array(
                        'alt'   => 'Listing detail layout', 
                        'img'   => get_template_directory_uri().'/assets/images/admin/header-menu-dropdown.jpg'
                    ),
                    'header_without_topbar'      => array(
                        'alt'   => 'Listing detail layout', 
                        'img'   => get_template_directory_uri().'/assets/images/admin/header-without-topbar.jpg'
                    ),
                    'header_with_topbar_menu'      => array(
                        'alt'   => 'Listing detail layout',
                        'img'   => get_template_directory_uri().'/assets/images/admin/header-with-topbar-menu.jpg'
                    ),
                    /* 'header_with_bigmenu'      => array(
                        'alt'   => 'Listing detail layout',
                        'img'   => get_template_directory_uri().'/assets/images/admin/header-with-bigmenu.jpg'
                    ), */
					// New header layouts

                   'header_style5'      => array(
                       'alt'   => 'Header Style 5',
                       'img'   => get_template_directory_uri().'/assets/images/admin/header-5.jpg'
                   ),
                   'header_style6'      => array(
                       'alt'   => 'Header Style 6',
                       'img'   => get_template_directory_uri().'/assets/images/admin/header-6.jpg'
                   ),
                   'header_style7'      => array(
                       'alt'   => 'Header Style 7',
                       'img'   => get_template_directory_uri().'/assets/images/admin/header-7.jpg'
                   ),
                   'header_style8'      => array(
                       'alt'   => 'Header Style 8',
                       'img'   => get_template_directory_uri().'/assets/images/admin/header-8.jpg'
                   ),
                   'header_style9'      => array(
                       'alt'   => 'Header Style 9',
                       'img'   => get_template_directory_uri().'/assets/images/admin/header-9.jpg'
                   ),
                ),
                'default' => 'header_without_topbar'
            ),
			
			array(
                'id'       => 'top_bar_enable',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Top bar', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array('header_views','equals','header_with_topbar'),
                'default'  => 1,
            ),
            array(
                'id'       => 'top_bar_bgcolor',
                'type'     => 'color',
                'title'    => __('Top Bar Background Color', 'listingpro'), 
                'subtitle' => __('(default: #363F48).', 'listingpro'),
                'required' => array('top_bar_enable','equals','1'),
                'default'  => '#363F48',
                'validate' => 'color',
            ),
            array(
                'id'       => 'top_bar_enable_new',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Top bar', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array('header_views','equals','header_with_topbar_menu'),
                'default'  => 1,
            ),
            array(
                'id'       => 'top_bar_bg_inner',
                'type'     => 'color',
                'title'    => __('Top bar Background Color Inner Pages', 'listingpro'),
                'subtitle' => __('(default: #42a7df).', 'listingpro'),
                'default'  => '#fff',
                'validate' => 'color',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'       => 'top_bar_color_inner',
                'type'     => 'color',
                'title'    => __('Top bar Color Inner Pages', 'listingpro'),
                'subtitle' => __('(default: #797979).', 'listingpro'),
                'default'  => '#797979',
                'validate' => 'color',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'       => 'top_bar_opacity',
                'type'     => 'select',
                'title'    => __('Set opacity for top bar', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array('top_bar_enable_new','equals','1'),
                // Must provide key => value pairs for select options
                'options'  => array(
                    '0.1' => '0.1',
                    '0.2' => '0.2',
                    '0.3' => '0.3',
                    '0.4' => '0.4',
                    '0.5' => '0.5',
                    '0.6' => '0.6',
                    '0.7' => '0.7',
                    '0.8' => '0.8',
                    '0.9' => '0.9',
                ),
                'default'  => '0.5',
            ),
            array(
                'id'=>'fb_h',
                'type' => 'text',
                'title' => __("Facebook URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'tw_h',
                'type' => 'text',
                'title' => __("Twitter URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'gog_h',
                'type' => 'text',
                'title' => __("Google URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'insta_h',
                'type' => 'text',
                'title' => __("Instagram URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'tumb_h',
                'type' => 'text',
                'title' => __("Tumbler URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'f-yout_h',
                'type' => 'text',
                'title' => __("Youtube URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'f-linked_h',
                'type' => 'text',
                'title' => __("LinkedIn URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'f-pintereset_h',
                'type' => 'text',
                'title' => __("Pinterest URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'=>'f-vk_h',
                'type' => 'text',
                'title' => __("VK URL", 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default' => '#',
                'required' => array('top_bar_enable_new','equals','1'),
            ),
            array(
                'id'       => 'header_bgcolor',
                'type'     => 'color',
                'title'    => __('Header Background Color', 'listingpro'), 
                'subtitle' => __('(default: #42a7df).', 'listingpro'),
                'default'  => 'transparent',
                'validate' => 'color',
            ),
            array(
                'id'       => 'header_bgcolor_inner_pages',
                'type'     => 'color',
                'title'    => __('Header Background Color Inner Pages', 'listingpro'),
                'subtitle' => __('(default: #42a7df).', 'listingpro'),
                'default'  => '#42a7df',
                'validate' => 'color',

            ),
			array(
                'id'       => 'header_textcolor',
                'type'     => 'color',
                'title'    => __('Header Text and Border Color', 'listingpro'), 
                'subtitle' => __('(default: #ffffff).', 'listingpro'),
                'default'  => '#FFFFFF',
                'validate' => 'color',
            ),
            array(
                'id'       => 'header_cats_partypro',
                'type'     => 'switch',
                'title'    => __(' Categories in Header', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'required' => array('header_views','equals','header_with_bigmenu'),
                'default'  => true,
            ),
			array(
                'id'       => 'header_fullwidth',
                'type'     => 'switch',
                'title'    => __(' Header Layout (On = FullWidth | Off = Boxed )', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                 'default'  => true,
            ),
			array(
                'id'       => 'search_switcher',
                'type'     => 'switch', 
                'title'    => __('Header Search On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => false,
            ),
           
			array(
                'id'       => 'primary_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Home Page Logo ', 'listingpro' ),
                'compiler' => 'true',
                //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'     => __( 'Upload your logo here', 'listingpro' ),
                'default'  => array( 'url' => get_template_directory_uri().'/assets/images/logo.png' ),

            ),	
			array(
                'id'       => 'seconday_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Logo for inner pages', 'listingpro' ),
                'compiler' => 'true',
                //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'     => __( 'Upload your logo here', 'listingpro' ),
                'default'  => array( 'url' => get_template_directory_uri().'/assets/images/logo2.png' ),

            ),
			array(
                'id'       => 'theme_favicon',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Your Favicon ', 'listingpro' ),
                'compiler' => 'true',
                //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'     => __( 'Upload your Favicon here', 'listingpro' ),
                'default'  => array( 'url' => get_template_directory_uri().'/assets/images/favicon.png' ),

            ),
			array(
                'id'       => 'page_header',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Page header background image', 'listingpro' ),
                'compiler' => 'true',
                //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'     => __( 'Upload your Image here', 'listingpro' ),
                'default'  => array( 'url' => get_template_directory_uri().'/assets/images/header-banner.jpg' ),

            ),
            
			
        )
    ) );
    // -> START Banner Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner Settings', 'listingpro' ),
        'id'               => 'search_settings',
        'customizer_width' => '400px',
        'icon'             => 'el el-map-marker',
		'fields'     => array(
            array(
                'id'       => 'top_banner_styles',
                'type'     => 'image_select',
                'title'    => __('Select Top Header Style', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                // Must provide key => value pairs for select options
                'options'  => array(
                    'banner_view2' =>  array(
                        'alt' => 'Banner with Search',
                        'img'   => get_template_directory_uri().'/assets/images/admin/banner-style1.jpg'
                    ),
                    'banner_view' =>  array(
                        'alt' => 'Banner with Search Style2',
                        'img'   => get_template_directory_uri().'/assets/images/admin/banner-style2.jpg'
                    ),
                    'map_view' =>  array(
                        'alt' => 'Map View',
                        'img'   => get_template_directory_uri().'/assets/images/admin/banner-style3.jpg'
                    ),
					// start banner different views added
                    'banner_view_search_bottom' =>  array(
                       'alt' => 'Banner with Search Bottom',
                       'img'   => get_template_directory_uri().'/assets/images/admin/banner-style4.jpg'
					),

                   'banner_view_category_upper' =>  array(
                       'alt' => 'Banner with Category inside',
                       'img'   => get_template_directory_uri().'/assets/images/admin/banner-style5.jpg'
					),

                   'banner_view_search_inside' =>  array(
                       'alt' => 'Banner with search inside',
                       'img'   => get_template_directory_uri().'/assets/images/admin/banner-style6.jpg'
					),
                   // End banner different views added
                ),
                'default'  => 'banner_view',
            ),
			// <---------------------start new options--------------------->
            // Different search views for(banner with serach style 2)
            array(
                'id'       => 'search_different_styles',
                'type'     => 'image_select',
                'title'    => __('Select Search Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'search_view' =>  array(
                    'alt' => 'Search View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-default.png'
                ),
                'search_view1' =>  array(
                    'alt' => 'Search View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-1.png'
                ),
                'search_view2' =>  array(
                    'alt' => 'Search View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-2.png'
                ),
                'search_view3' =>  array(
                    'alt' => 'Search View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-3.png'
                ),
                ),
                'default'  => 'search_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view') )
                )
            ),
            // Different search views for (Banner with search bottom)
            array(
                'id'       => 'search_different_styles_banner_search_overlap',
                'type'     => 'image_select',
                'title'    => __('Select Search Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'search_view' =>  array(
                    'alt' => 'Search View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-overlap-view-1.jpg'
                ),
                'search_view1' =>  array(
                    'alt' => 'Search View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-overlap-view-2.jpg'
                ),
                'search_view2' =>  array(
                    'alt' => 'Search View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-overlap-view-3.jpg'
                ),
                'search_view3' =>  array(
                    'alt' => 'Search View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-overlap-view-4.jpg'
                ),
                ),
                'default'  => 'search_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_bottom') )
                )
            ),
            // Different search views for (Banner with search inside)
            array(
                'id'       => 'search_different_styles_banner_search_inside',
                'type'     => 'image_select',
                'title'    => __('Select Search Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'search_view' =>  array(
                    'alt' => 'Search View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-default.png'
                ),
                'search_view1' =>  array(
                    'alt' => 'Search View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-1.png'
                ),
                'search_view2' =>  array(
                    'alt' => 'Search View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-2.png'
                ),
                'search_view3' =>  array(
                    'alt' => 'Search View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-3.png'
                ),
                ),
                'default'  => 'search_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_inside') )
                )
            ),
            // Different search views for (Banner with category inside)
            array(
                'id'       => 'search_different_styles_banner_category_inside',
                'type'     => 'image_select',
                'title'    => __('Select Search Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'search_view' =>  array(
                    'alt' => 'Search View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-default.png'
                ),
                'search_view1' =>  array(
                    'alt' => 'Search View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-1.png'
                ),
                'search_view2' =>  array(
                    'alt' => 'Search View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-2.png'
                ),
                'search_view3' =>  array(
                    'alt' => 'Search View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/search-view-3.png'
                ),
                ),
                'default'  => 'search_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_category_upper') )
                )
            ),
            // Different Category Views
            array(
                'id'       => 'categories_different_styles',
                'type'     => 'image_select',
                'title'    => __('Select Category Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'category_view' =>  array(
                    'alt' => 'Category View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style.png'
                ),
                'category_view1' =>  array(
                    'alt' => 'Category View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style1.png'
                ),
                'category_view2' =>  array(
                    'alt' => 'Category View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style2.png'
                ),
                'category_view3' =>  array(
                    'alt' => 'Category View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style-banner-view.png'
                ),
                ),
                'default'  => 'category_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view',) )
                )
            ),
            // Different Category Views for(search overlap)
            array(
                'id'       => 'categories_different_styles_search_overlap',
                'type'     => 'image_select',
                'title'    => __('Select Category Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'category_view' =>  array(
                    'alt' => 'Category View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style.png'
                ),
                'category_view1' =>  array(
                    'alt' => 'Category View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style1.png'
                ),
                'category_view2' =>  array(
                    'alt' => 'Category View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style2.png'
                ),
                'category_view3' =>  array(
                    'alt' => 'Category View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style-banner-view.png'
                ),
                ),
                'default'  => 'category_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_bottom') )
                )
            ),
            // Different Category Views for(category inside)
            array(
                'id'       => 'categories_different_styles_category_inside',
                'type'     => 'image_select',
                'title'    => __('Select Category Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'category_view' =>  array(
                    'alt' => 'Category View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style.png'
                ),
                'category_view1' =>  array(
                    'alt' => 'Category View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style1.png'
                ),
                'category_view2' =>  array(
                    'alt' => 'Category View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style2.png'
                ),
                'category_view3' =>  array(
                    'alt' => 'Category View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style-banner-view.png'
                ),
                ),
                'default'  => 'category_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_category_upper') )
                )
            ),
            // Different Category Views for(search inside)
            array(
                'id'       => 'categories_different_styles_search_inside',
                'type'     => 'image_select',
                'title'    => __('Select Category Style', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                'category_view' =>  array(
                    'alt' => 'Category View',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style.png'
                ),
                'category_view1' =>  array(
                    'alt' => 'Category View 1',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style1.png'
                ),
                'category_view2' =>  array(
                    'alt' => 'Category View 2',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style2.png'
                ),
                'category_view3' =>  array(
                    'alt' => 'Category View 3',
                    'img'   => get_template_directory_uri().'/assets/images/admin/category-style-banner-view.png'
                ),
                ),
                'default'  => 'category_view',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_inside') )
                )
            ),
            // Category colors options
            array(
                'id'       => 'categories_color',
                'type'     => 'color',
                'title'    => __('Category Background Color', 'listingpro'), 
                'subtitle' => __('(default: #41a6df).', 'listingpro'),
                'default'  => '#363F48',
                'validate' => 'color',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_bottom', 'banner_view','banner_view_category_upper','banner_view_search_inside') )
                )
            ),
            array(
                'id'       => 'categories_hover_color',
                'type'     => 'color',
                'title'    => __('Category Background Hover Color', 'listingpro'), 
                'subtitle' => __('(default: #363F48).', 'listingpro'),
                'default'  => '#363F48',
                'validate' => 'color',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_bottom', 'banner_view','banner_view_category_upper','banner_view_search_inside') )
                )
            ),
            array(
                'id'       => 'categories_text_color',
                'type'     => 'color',
                'title'    => __('Category Text Color', 'listingpro'), 
                'subtitle' => __('(default: #363F48).', 'listingpro'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view_search_bottom', 'banner_view','banner_view_category_upper','banner_view_search_inside') )
                )
            ),
            // new banner height option for some views
            array(
                'id'       => 'banner_height_search_bottom',
                'type'     => 'text',
                'title'    => __( 'Banner height', 'listingpro' ),
                'subtitle' => __( 'Add Banner Height (without unitPixel/Percent)', 'listingpro' ),
                'default'  => 370,
                'required' => array( 
                    array('top_banner_styles','equals',array('banner_view_search_bottom','banner_view_search_inside')),
                ),
            ),
            // <----------------End new options------------->   
			array(
                'id'       => 'banner_height',
                'type'     => 'text',
                'title'    => __( 'Banner height', 'listingpro' ),
                'subtitle' => __( 'Add Banner Height (without unitPixel/Percent)', 'listingpro' ),
                'default'  => 610,
				'required' => array( 
                    array('top_banner_styles','equals',array('banner_view', 'banner_view2', 'banner_view_category_upper')),
                ),
            ),
			array(
                'id'       => 'banner_opacity',
                'type'     => 'select',
                'title'    => __('Set opacity for banner', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                // Must provide key => value pairs for select options
                'options'  => array(
                    '0.0' => '0.0',
                    '0.1' => '0.1',
                    '0.2' => '0.2',
                    '0.3' => '0.3',
                    '0.4' => '0.4',
                    '0.5' => '0.5',
                    '0.6' => '0.6',
                    '0.7' => '0.7',
                    '0.8' => '0.8',
                    '0.9' => '0.9',
                ),
                'default'  => '0.6',
            ),
			
			array(
                    'id'       => 'lp_video_banner_on',
                    'type'     => 'select', 
                    'title'    => esc_html__('Banner background type', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'options'  => array(
                    'static_image' => 'Static Image',
                    'video_banner' => 'Video Banner'
                ),
                'default'  => 'static_image',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view', 'banner_view2', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') )
                )
                ),
			array(
                'id'       => 'home_banner',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Home Banner Image', 'listingpro' ),
                'compiler' => 'true',
               'subtitle' => __('Upload image for homepage banner', 'listingpro'),
			   'required' => array( 
                    array('top_banner_styles','equals',array('banner_view', 'banner_view2', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside')),
                ),
                'default' => array( 'url' => get_template_directory_uri().'/assets/images/home-banner.jpg' ),
            ),
			array(
                'id'       => 'video_banner_img',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Home Video Banner Image', 'listingpro' ),
                'compiler' => 'true',
               'subtitle' => __('Upload video poster for homepage banner', 'listingpro'),
			   'required' => array( 
					array('lp_video_banner_on','=','video_banner'),
					 array('top_banner_styles','equals',array('banner_view', 'banner_view2', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside')),
                ),
                'default' => array( 'url' => get_template_directory_uri().'/assets/images/dashboard-img.jpg' ),
            ),
            array(
                'id'       => 'vedio_type',
                'type'     => 'select',
                'title'    => __('Video Source', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array(
                    array('lp_video_banner_on','=','video_banner'),
                ),

                'options'  => array(
                    'video_youtube' => 'Youtube',
                    'video_mp4' => 'MP4',
                ),
                'default'  => 'video_mp4',
            ),
			array(
                'id'       => 'vedio_url',
                'type'     => 'text',
                'title'    => __( 'MP4 Video Url', 'listingpro' ),
                'desc'    => __( 'Please use proper video URL with extension like .mp4. Avoid using any video page URL like youtube or vimeo', 'listingpro' ),
                'subtitle' => __( 'Upload video here to show in banner', 'listingpro' ),
                'required' => array( 
                    array('lp_video_banner_on','=','video_banner'),
                    array('vedio_type','=','video_mp4'),
                ),
                'default'  => '',
            ),
            array(
                'id'       => 'vedio_url_yt',
                'type'     => 'text',
                'title'    => __( 'Youtube Video Url', 'listingpro' ),
                'desc'    => __( 'Please use proper video URL from youtube', 'listingpro' ),
                'subtitle' => __( 'Upload video here to show in banner', 'listingpro' ),
                'required' => array(
                    array('lp_video_banner_on','=','video_banner'),
                    array('vedio_type','=','video_youtube'),
                ),
                'default'  => '',
            ),

			array(
                'id'       => 'video_search_layout',
                'type'     => 'select',
                'title'    => __('Select Search Mode For Video', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array( 
                    array('lp_video_banner_on','=','video_banner'),
                ),
                'options'  => array(
                    'align_center' => 'Align Center',
                    'align_bottom_video' => 'Align bottom under Video',
                    'align_bottom_on_banner' => 'Align bottom On Banner',

                ),
                'default'  => 'align_center',
            ),
			
			array(
                'id'       => 'courtesy_switcher',
                'type'     => 'switch', 
                'title'    => __('Courtesy Listing On/Off', 'listingpro'),
                'subtitle' => __('Is this banner courtesy with any listing', 'listingpro'),
                'required' => array( 
                    array('top_banner_styles','equals','banner_view', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') 
                ),
                'default'  => false,
            ),
			array(
                'id'       => 'courtesy_listing',
                'type'     => 'text',
                'title'    => __( 'Listing ID', 'listingpro' ),
                'subtitle' => __( 'Add listing ID here', 'listingpro' ),
                'required' => array( 
                    array('courtesy_switcher','equals', 1),
                ),
                'default'  => '',
            ),  
            /* array(
                'id'        =>'courtesy_listing',
                'type'      => 'select',
                'multi'     => false,
                'required' => array( 
                    array('courtesy_switcher','equals', 1),
                ),
                'data'      => 'posts',
                'args'      => array('post_type' => array('listing'), 'posts_per_page' => -1),
                'title'     => esc_html__('Select listing', 'listingpro'),
                'desc'      => esc_html__('', 'listingpro'),
            ), */
            array(
                'id'       => 'home_banner_taxonomy',
                'type'     => 'select',
                'title'    => esc_html__('Banner Taxonomy', 'listingpro'),
                'subtitle' => esc_html__('', 'listingpro'),
                'options'  => array(
                    'tax_cats' => 'Categories',
                    'tax_locs' => 'Locations',
                    'tax_feats' => 'Features'
                ),
                'default'  => 'tax_cats',
                'required'  =>  array(
                    array('top_banner_styles','=',array('banner_view', 'banner_view2', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') )
                )
            ),
			array(
				'id'       => 'home_banner_cats',
				'type' => 'select',
                'data' => 'terms',
				'args' => array('taxonomies'=>'listing-category', 'hide_empty' => false),
                'multi' => true,
                'title' => __('Select listing categories', 'listingpro'),
                'subtitle' => __('These categories will be appeared on the homepage Banner', 'listingpro'),
				'default' => '',
                'required'  =>  array(
                    array('home_banner_taxonomy','=','tax_cats')
                )
			),
			array(
				'id'       => 'default_search_cats',
				'type' => 'select',
                'data' => 'terms',
				'args' => array('taxonomies'=>'listing-category', 'hide_empty' => false),
                'multi' => true,
                'title' => __('Select listing categories for dropdown in search (WHERE field)', 'listingpro'),
                'subtitle' => __('These categories will be appeared on search dropdown', 'listingpro'),
				'default' => '',
			),
			array(
                'id'       => 'home_banner_locs',
				'type' => 'select',
                'data' => 'terms',
                'args' => array('taxonomies'=>'location', 'hide_empty' => false),
                'multi' => true,
                'title' => __('Select listing Locations', 'listingpro'),
                'subtitle' => __('These categories will be appeared on the homepage Banner', 'listingpro'),
				'default' => '',
                'required'  =>  array(
                    array('home_banner_taxonomy','=', 'tax_locs' )
                )
            ),
            array(
                'id'       => 'home_banner_feats',
                'type' => 'select',
                'data' => 'terms',
                'args' => array('taxonomies'=>'features', 'hide_empty' => false),
                'multi' => true,
                'title' => __('Select listing Features', 'listingpro'),
                'subtitle' => __('These categories will be appeared on the homepage Banner', 'listingpro'),
                'default' => '',
                'required'  =>  array(
                    array('home_banner_taxonomy','=', 'tax_feats' )
                )
			),
            array(
                'id'       => 'search_views',
                'type'     => 'select',
                'title'    => __('Select Search View', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array( 
                    array('top_banner_styles','equals','map_view') 
                ),
                // Must provide key => value pairs for select options
                'options'  => array(
                    'light' => 'Light',
                    'dark' => 'Dark',
                    'grey' => 'Grey',
                ),
                'default'  => 'light',
            ),
            array(
                'id'       => 'search_alignment',
                'type'     => 'select',
                'title'    => __('Select Search Alignment', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array( 
                    array('top_banner_styles','equals','map_view') 
                ),
                // Must provide key => value pairs for select options
                'options'  => array(
                    'align_top' => 'Align with Top Navbar',
                    'align_middle' => 'Align bottom under banner',
                    'align_bottom' => 'Align bottom after banner',
                ),
                'default'  => 'align_middle',
            ),
            array(
                'id'       => 'search_layout',
                'type'     => 'select',
                'title'    => __('Select Search Mode', 'listingpro'), 
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'required' => array( 
                    array('top_banner_styles','equals','map_view') 
                ),
                // Must provide key => value pairs for select options
                'options'  => array(
                    'fullwidth' => 'Fullwidth',
                    'boxed' => 'Boxed',
                ),
                'default'  => 'boxed',
            ),
            array(
                'id'       => 'cat_txt',
                'type'     => 'text',
                'title'    => __( 'Categories Text', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array( 
                    array('top_banner_styles','equals','map_view'),
                    array('search_alignment','!=','align_top')
                ),
                'default'  => 'Just looking around? Let us suggest you something hot & happening! ',
            ),
            array(
                'id'       => 'map_height',
                'type'     => 'text',
                'title'    => __( 'Map Height', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array( 
                    array('top_banner_styles','equals','map_view'),
                ),
                'desc'  => 'Only use numbers do not use Px. i.e 500',
                'default'  => '550',
            ),
			
			
			array(
                'id'       => 'search_placeholder',
                'type'     => 'text',
                'title'    => __( 'Banner Search Placeholder', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'default'  => 'Ex: food, service, barber, hotel',
            ),
			array(
                'id'       => 'location_default_text',
                'type'     => 'text',
                'title'    => __( 'Location Default Text', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'default'  => 'Your City...',
            ),
            array(
                'id'       => 'top_title',
                'type'     => 'text',
                'title'    => __( 'Search Top Title', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array( 
                    array('top_banner_styles','equals','banner_view', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') 
                ),
                'default'  => "Let's uncover the best places to eat, drink, and shop nearest to you.",
            ),
            array(
                'id'       => 'top_main_title',
                'type'     => 'text',
                'title'    => __( 'Search Main Title', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array( 
                    array('top_banner_styles','equals','banner_view', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') 
                ),
                'default'  => 'Explore <span class="lp-dyn-city">Your city</span>',
            ), 
            array(
                'id'       => 'main_text',
                'type'     => 'text',
                'title'    => __( 'Search Main Text', 'listingpro' ),
                'subtitle' => __( '', 'listingpro' ),
                'required' => array( 
                    array('top_banner_styles','equals','banner_view', 'banner_view_search_bottom','banner_view_category_upper','banner_view_search_inside') 
                ),
                'default'  => 'Just looking around? Let us suggest you something hot & happening! ',
            ),
			array(
                'id'       => 'arrow_image',
                'type'     => 'switch', 
                'title'    => __('Banner Arrow Image Option On/Off', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'default'  => true,
                'required'  =>  array(
                    array('top_banner_styles','equals',array('banner_view2', 'banner_view'))
                )
            ),
            array(
                'id'       => 'banner_logo_search2',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Banner Logo', 'listingpro' ),
                'compiler' => 'true',
                'subtitle' => __('Upload image for logo on banner search form', 'listingpro'),
                'required' => array(
                    array('top_banner_styles','equals',array('banner_view2')),
                ),
                'default' => array( 'url' => get_template_directory_uri().'/assets/images/lp-logo1.png' ),
            ),

			/* for v2 */
			array(
                'id'       => 'map_listing_by',
                'type'     => 'select',
                'title'    => __('Show Listing Pin By', 'listingpro'),
                'subtitle' => __('', 'listingpro'),
                'desc'     => __('On home page map, show pin based on the selection', 'listingpro'),
                'required' => array(
                    array('top_banner_styles','=','map_view'),
                ),
                'options'  => array(
                    'all' => 'All Listings',
                    'by_category' => 'By Category',
                    'geolocaion' => 'User city (Based on Wordpress Location taxonomy)',

                ),
                'default'  => 'geolocaion',
            ),

			array(
				'id'=>'lp_listing_cat_on_map',
				'type' => 'select',
				'data' => 'terms',
				'args' => array('taxonomies'=>'listing-category', 'args'=>array()),
				'title' => __('Category', 'listingpro'),
				'subtitle' => __('Please choose a category.', 'listingpro'),
				'required' => array(
                    array('top_banner_styles','=','map_view'),
                    array('map_listing_by','=','by_category'),
                ),
				'desc' => __('Select a listing category', 'listingpro'),
            ),
			/* end for v2 */
        )
    ) );

	
	
	// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Map Settings', 'listingpro' ),
			'id'               => 'map_settings',
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			'fields'     => array(
				array(
					'id'       => 'google_map_api',
					'type'     => 'text',
					'title'    => __( 'Google Map API', 'listingpro' ),
					'subtitle' => __( 'Please set your own google map API key for your site( default key is for only demo)', 'listingpro' ),
					'desc' => __( 'Creat your map api key here. https://developers.google.com/maps/documentation/javascript/get-api-key', 'listingpro' ),					
					'default'  => 'AIzaSyDQIbsz2wFeL42Dp9KaL4o4cJKJu4r8Tvg',
				),
				array(
					'id'       => 'map_option',
					'type'     => 'select',
					'title'    => __('Select Search Mode', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('', 'listingpro'),					
					'options'  => array(
						'google' => 'Google Map',
						'mapbox' => 'MapBox API',
					),
					'default'  => 'google',
				),
				array(
					'id'       => 'mapbox_token',
					'type'     => 'text',
					'title'    => __( 'Mapbox Token (Optional)', 'listingpro' ),
					'subtitle' => __( 'Put here MapBox token, If you leave it empty then Google map will work', 'listingpro' ),
					'required' => array( 
						array('map_option','equals','mapbox') 
					),
					'default'  => '',
				),	
				array(
                    'id'       => 'map_style',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Mapbox Map style', 'listingpro'), 
                    'subtitle' => esc_html__('Select any style', 'listingpro'),
					'required' => array( 
						array('map_option','equals','mapbox') 
					),
                    'options'  => array(
                        'mapbox.streets-basic'      => array(
                            'alt'   => 'streets-basic', 
                            'img'   => get_template_directory_uri().'/assets/images/map/streets-basic.png'
                        ),
                        'mapbox.streets'      => array(
                            'alt'   => 'streets', 
                            'img'   => get_template_directory_uri().'/assets/images/map/streets.png'
                        ),
                        'mapbox.outdoors'      => array(
                            'alt'   => 'outdoors', 
                            'img'   => get_template_directory_uri().'/assets/images/map/outdoors.png'
                        ),
						'mapbox.light'      => array(
                            'alt'   => 'light', 
                            'img'   => get_template_directory_uri().'/assets/images/map/light.png'
                        ),
						'mapbox.emerald'      => array(
                            'alt'   => 'emerald', 
                            'img'   => get_template_directory_uri().'/assets/images/map/emerald.png'
                        ),
						'mapbox.satellite'      => array(
                            'alt'   => 'satellite', 
                            'img'   => get_template_directory_uri().'/assets/images/map/satellite.png'
                        ),
						'mapbox.pencil'      => array(
                            'alt'   => 'pencil', 
                            'img'   => get_template_directory_uri().'/assets/images/map/pencil.png'
                        ),
						'mapbox.pirates'      => array(
                            'alt'   => 'pirates', 
                            'img'   => get_template_directory_uri().'/assets/images/map/pirates.png'
                        ),
						
                    ),
                    'default' => '1'
                ),
				
			

				
			)
		) );
		
		
	// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Blog Settings', 'listingpro' ),
			'id'               => 'lp_blog_settings',
			'customizer_width' => '400px',
			'icon'             => 'el el-comment',
			'fields'     => array(
				array(
                'id'       => 'blog_view',
                'type'     => 'select',
                'title'    => __('Blog View', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                    'list_view' => 'List View',
                    'list_view2' => 'List View 2',
                    'grid_view' => 'Grid View',
                ),
                'default'  => 'grid_view',
            ),
			array(
                'id'       => 'blog_grid_view',
                'type'     => 'select',
                'title'    => __('Blog Grid View Style', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                    'grid_view_style1' => 'Grid View Style1',
                    'grid_view_style2' => 'Grid View Style2',
                    'grid_view_style3' => 'Grid View Style3',
                    'grid_view_style4' => 'Grid View Style4',
                ),
                'default'  => 'grid_view_style1',
            ),
            array(
                'id'       => 'blog_template',
                'type'     => 'select',
                'title'    => __('Blog Template', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                    'fullwidth' => 'Full Width',
                    'left_sidebar' => 'Left Sidebar',
                    'right_sidebar' => 'Right Sidebar',
                ),
                'default'  => 'fullwidth',
            ),
            array(
                'id'       => 'blog_single_template',
                'type'     => 'select',
                'title'    => __('Blog Detail Template', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                    'fullwidth' => 'Full Width',
                    'left_sidebar' => 'Left Sidebar',
                    'right_sidebar' => 'Right Sidebar',
                    'fullwidth2' => 'Full Width Style2',
                    'left_sidebar2' => 'Left Sidebar Style2',
                    'right_sidebar2' => 'Right Sidebar Style2',
                ),
                'default'  => 'fullwidth',
            ),
			
			array(
                'id'       => 'blog_sidebar_style',
                'type'     => 'select',
                'title'    => __('Blog Sidebar Style', 'listingpro'),
                'desc'     => __('', 'listingpro'),
                'options'  => array(
                    'sidebar_style1' => 'SideBar Style1',
                    'sidebar_style2' => 'SideBar Style2',
                    
                ),
                'default'  => 'sidebar_style1',
            ),
				
			),
		));	
		
	include_once(ABSPATH.'wp-admin/includes/plugin.php');	
	if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
		
		// -> START Basic Fields
		Redux::setSection( $opt_name, array(
    		'title'            => __( 'LISTING SETTINGS', 'listingpro' ),
    		'id'               => 'general_settings',
    		'customizer_width' => '400px',
    		'icon'             => 'el el-list-alt',			
    		'fields'     => array(
				
				
    		)
    	) );
		
		
		
		
		Redux::setSection( $opt_name, array(
			'title'            => __( 'General', 'listingpro' ),
			'id'               => 'listing_setting_general',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
                    'id'       => 'single_listing_mobile_view',
                    'type'     => 'select',
                    'title'    => __('Mobile View', 'listingpro'),
                    'desc'     => __('Ap View Activate On Home Page/listing detail/listing Archive Pages Only', 'listingpro'),
                    'options'  => array(
                        'responsive_view' => 'Responsive View',
                        'app_view' => 'App View',
                    ),
                    'default'  => 'responsive_view',
                ),
				array(
                   'id'       => 'app_view_home',
                   'type'     => 'text',
                   'title'    => __( 'Home Page for App View', 'listingpro' ),
                   'subtitle' => __( 'Enter url for home page on app view', 'listingpro' ),
                   'default'  => '',
				   'required' => array( 
						array('single_listing_mobile_view','equals',array('app_view')) 
					),
				),
				/* array(
                   'id'       => 'lp_select_view_archive',
                   'type'     => 'select',
                    'title'    => __('Listing Archive App View', 'listingpro'),
                    'desc'     => __('Listing View Activate On App View Archive Page', 'listingpro'),
                    'options'  => array(
                        'list_archive_view' => 'List View',
                        'grig_archive_view' => 'Grid View',
                    ),
                    'default'  => 'list_archive_view',
				), */
				
				array(
                   'id'       => 'lp_default_map_location_lat',
                   'type'     => 'text',
                   'title'    => __( 'Default Map Location Latitude', 'listingpro' ),
                   'subtitle' => __( 'Enter latitude for default map location', 'listingpro' ),
				   'desc'     => __('This option will work on map only and only if there is no listing result found', 'listingpro'),
                   'default'  => '0',
				),
				array(
                   'id'       => 'lp_default_map_location_long',
                   'type'     => 'text',
                   'title'    => __( 'Default Map Location Longitude', 'listingpro' ),
                   'subtitle' => __( 'Enter longitude for default map location', 'listingpro' ),
				   'desc'     => __('This option will work on map only and only if there is no listing result found', 'listingpro'),
                   'default'  => '-0',
				),
				
				array(
					'id'       => 'lp_archivepage_listingorderby',
					'type'     => 'select',
					'title'    => __('Listings Order By', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('Order By Listings on archive/search result page', 'listingpro'),
					'options'  => array(
						'title' => 'Title',
						'date' => 'Date',
						'rand' => 'Random',
					),
					'default'  => 'date',
				),
				array(
					'id'       => 'lp_archivepage_listingorder',
					'type'     => 'select',
					'title'    => __('Listings Order', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('Listings Order on archive/search result page', 'listingpro'),
					'required' => array( 
						array('lp_archivepage_listingorderby','equals',array('title', 'date')) 
					),
					'options'  => array(
						'ASC' => 'ASC',
						'DESC' => 'DESC',
					),
					'default'  => 'ASC',
				),
				array(
                    'id'       => 'lp_allow_vistor_submit',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Add listing only by logged in users', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => false,
                ),
				array(
					'id'       => 'timing_option',
					'type'     => 'select',
					'title'    => __('Select TIming Format', 'listingpro'),			
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'24' => '24H Format',
						'12' => '12H Format',
					),
					'default'  => '12',
				),
                array(
                    'id'       => 'contact_support',
                    'type'     => 'text',
                    'title'    => __( 'Contact Support URL', 'listingpro' ),
                    'subtitle' => __( 'Enter contact support url here for user dashboard.', 'listingpro' ),
                    'default'  => '#',
                ),
				
				array(
                    'id'       => 'lp_listing_change_plan_option',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Change Plan Button', 'listingpro'),
                    'subtitle' => esc_html__('Enable Disable Change plan button for listings on user dashboard', 'listingpro'),
					'options' => array(
						'enable' => 'Enable', 
						'disable' => 'Disable', 
					 ), 
                    'default'  => 'enable',
                ),
						
                array(
                    'id'       => 'listing_per_page',
                    'type'     => 'text',
                    'title'    => __( 'Listings Per Page', 'listingpro' ),
                    'subtitle' => __( 'It will effect on taxonomy and search page.', 'listingpro' ),
                    'desc' => __( 'Enter only digits. e-g 11', 'listingpro' ),
                    'default'  => '10',
                ),
				
				array(
                    'id'       => 'lp_def_featured_image',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload default featured image for listing', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'In case if there is no featured image in listing, this option will impact', 'listingpro' ),
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/default/placeholder.png' ),
				),
				
				array(
                    'id'       => 'lp_def_featured_image_from_gallery',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Featured image from gallery', 'listingpro'),
                    'subtitle' => esc_html__('If Enable => It means that featured image will be selected from gallery images randomly while submitting listing in case when user has not uploaded image separately', 'listingpro'),
					'options' => array(
						'enable' => 'Enable', 
						'disable' => 'Disable', 
					 ), 
                    'default'  => 'disable',
                ),
				
				array(
                    'id'       => 'lp_map_pin',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload your map pin image for contact us page and listing detail page', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload your image', 'listingpro' ),
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/pins/pin.png' ),
				),
				array(
					'id'       => 'lp_detail_slider_styles',
					'type'     => 'select',
					'title'    => __('Select Slider Type', 'listingpro'),			
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'style1' => 'Style 1',
						'style2' => 'Style 2',
					),
					'default'  => 'style1',
				),
				array(
					'id'       => 'slider_height',
					'type'     => 'text',
					'title'    => __( 'Slider height', 'listingpro' ),
					'subtitle' => __( 'Add Slider Height (without unitPixel/Percent)', 'listingpro' ),
					'required' => array( 
						array('lp_detail_slider_styles','equals','style2') 
					),
					'default'  => 354,
				),
				
				array(
                    'id'       => 'edit_listing_pending_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Change Listing Status On Listing Moderation', 'listingpro'),
                    'subtitle' => esc_html__('Status on edit listing need to be pending', 'listingpro'),
                    'desc' => esc_html__('ON=Pending, OFF=Publish', 'listingpro'),
                    'default'  => false,
                ),
			

				/* for v2 */
				array(
                    'id'       => 'lp_icon_for_archive_pages_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Custom Icon for Archive & Search Pages', 'listingpro'),
                    'subtitle' => esc_html__('If Enable => It means that custom icon will work on listing archive and search result pages', 'listingpro'),
					'options' => array(
						'enable' => 'Enable',
						'disable' => 'Disable',
					 ),
                    'default'  => 'disable',
                ),
				array(
                    'id'       => 'lp_icon_for_archive_search_pages',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Uploade custom icon for Archive & Search Pages', 'listingpro' ),
                    'compiler' => 'true',
					'required' => array(
						array('lp_icon_for_archive_pages_switch','equals','enable')
					),
                    'desc'     => esc_html__( 'Please upload a PNG icon', 'listingpro' ),
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/pins/default.png' ),
				),
				/* end for v2 */
				/* plan for expired */
								array(
				                    'id'       => 'lp_assignplanexpirybutton',
				                    'type'     => 'button_set', 
				                    'title'    => esc_html__('Assign plan to expired listing', 'listingpro'),
				                    'subtitle' => esc_html__('If Enable => It means that the listings which are going to expire their plan will automatically assigned to the plan which will be set from dropdown bellow', 'listingpro'),
									'options' => array(
										'enable' => 'Enable', 
										'disable' => 'Disable', 
									 ), 
				                    'default'  => 'disable',
				                ),
								array(
									'id'=>'lp_plan_after_expire',
									'type' => 'select',
									'data' => 'posts',
									'required' => array(
										array('lp_assignplanexpirybutton','equals','enable')
									),
									'args' => array('post_type' => array('price_plan'), 'posts_per_page' => -1),
									'title' => __('Assign plan to expired listing', 'listingpro'),
									'desc' => __('After expiring any listing, selected plan from this option will attach to the listing', 'listingpro'),
								),
								/* end of expired */			

			)
			
		));
		

		
		
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Listing Detail Page Layout Manager', 'listingpro' ),
			'id'               => 'lp-detail-page-manager',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'       => 'lp_detail_page_styles',
					'type'     => 'select',
					'title'    => __('Select listing detail page Style', 'listingpro'),			
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'lp_detail_page_styles1' => 'Listing Detail Page Style 1',
						'lp_detail_page_styles2' => 'Listing Detail Page Style 2',
                        'lp_detail_page_styles3' => 'Listing Detail Page Style 3',
                        'lp_detail_page_styles4' => 'Listing Detail Page Style 4',
                        /* 'lp_detail_page_styles5' => 'Listing Detail Page Style 5', */
					),
					 
					'default'  => 'lp_detail_page_styles1',
				),

                array(
                    'id'       => 'lp-detail-page-layout5-content',
                    'type'     => 'sorter',
                    'title'    => 'Content Layout',
                    'required' => array('lp_detail_page_styles','equals', 'lp_detail_page_styles5'),
                    'desc'     => 'Shuffle elements within Listing Detail Content',
                    'compiler' => 'true',
                    'options'  => array(
                        'general'  => array(
                            'lp_content_section'   => 'Details',
                            'lp_announcements_section'   => 'Announcements',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_faqs_section'   => 'FAQs',
                            'lp_services_section'   => 'Services',
                            'lp_reviews_section'   => 'Reviews',
                            'lp_quote_section'   => 'Quote Form',
                        ),
                        'disabled' => array(
                            ''   => '',
                        ),
                    ),
                ),
                /* for listing layout3 & 4 */
				array(
                    'id'       => 'lp-detail-page-layout4-content',
                    'type'     => 'sorter',
                    'title'    => 'Content Layout',
                    'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles4'),
                    'desc'     => 'Shuffle elements within Listing Detail Content',
                    'compiler' => 'true',
                    'options'  => array(
                        'general'  => array(
                            'lp_content_section'   => 'Details',
                            'lp_announcements_section'   => 'Announcements',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_additional_section'   => 'Additional Details',
                            'lp_features_section'   => 'Listing Features',
                            'lp_faqs_section'   => 'FAQs',
                            'lp_reviews_section'   => 'Reviews',
                            'lp_reviewform_section'   => 'Review Form',
                            'lp_menu_section'   => 'Menu',
                        ),
                        'disabled' => array(
                            ''   => '',
                        ),
                    ),
                ),
                array(
                    'id'       => 'lp-detail-page-layout4-rsidebar',
                    'type'     => 'sorter',
                    'title'    => 'Sidebar Layout',
                    'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles4'),
                    'desc'     => 'Shuffle elements within Listing SideBar',
                    'compiler' => 'true',
                    'options'  => array(
                        'sidebar'  => array(
                            'lp_sidebar_video'   => 'Video',
                            'lp_mapsocial_section'   => 'Map/Contacts',
							'lp_event_section'   => 'Event',
                            'lp_timing_section' => 'Timings',
                            'lp_quicks_section'   => 'Quick Actions',
                            'lp_additional_section'   => 'Additional Details',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_leadform_section'   => 'Leadform',
                            'lp_sidebarelemnts_section'   => 'Detail Page Sidebar Widgets',
                         ),
                        'disabled' => array(
                            ''   => '',
                        ),
                    ),
                ),

                array(
                    'id'       => 'lp-detail-page-layout3-content',
                    'type'     => 'sorter',
                    'title'    => 'Content Layout',
                    'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles3'),
                    'desc'     => 'Shuffle elements within Listing Detail Content',
                    'compiler' => 'true',
                    'options'  => array(
                        'general'  => array(
                            'lp_content_section'   => 'Details',
                            'lp_announcements_section'   => 'Announcements',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_additional_section'   => 'Additional Details',
                            'lp_features_section'   => 'Listing Features',
                            'lp_faqs_section'   => 'FAQs',
                            'lp_reviews_section'   => 'Reviews',
                            'lp_reviewform_section'   => 'Review Form',
                            'lp_menu_section'   => 'Menu',
                        ),
                        'disabled' => array(
                            ''   => '',
                        ),
                    ),
                ),
                array(
                    'id'       => 'lp-detail-page-layout3-rsidebar',
                    'type'     => 'sorter',
                    'title'    => 'Sidebar Layout',
                    'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles3'),
                    'desc'     => 'Shuffle elements within Listing SideBar',
                    'compiler' => 'true',
                    'options'  => array(
                        'sidebar'  => array(
                            'lp_mapsocial_section'   => 'Map/Contacts',
                            'lp_event_section'   => 'Event',
                            'lp_timing_section' => 'Timings',
                            'lp_quicks_section'   => 'Quick Actions',
                            'lp_additional_section'   => 'Additional Details',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_leadform_section'   => 'Leadform',
                            'lp_sidebarelemnts_section'   => 'Detail Page Sidebar Widgets',
                          ),
                        'disabled' => array(
                            ''   => '',
                        ),
                    ),
                ),

                array(
                    'id'       => 'lp_detail_page_styles4_bg',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__('Header Background Image', 'listingpro'),
                    'subtitle' => esc_html__('Top background image for this syle', 'listingpro'),
                    'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles4'),
                    'default'  => array('url' => get_template_directory_uri().'/assets/images/home-banner.jpg'),
                ),
				/* for listing layout1 */
				array(
					'id'       => 'lp-detail-page-layout-content',
					'type'     => 'sorter',
					'title'    => 'Content Layout',
					'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles1'),
					'desc'     => 'Shuffle elements within Listing Detail Content',
					'compiler' => 'true',
					'options'  => array(
						'general'  => array(
							'lp_video_section' => 'Youtube Video',
							'lp_content_section'   => 'Details',                       
							'lp_openFields_section'   => 'Listing Global Form Fields',                       
							'lp_features_section'   => 'Listing Features',
							'lp_additional_section'   => 'Additional Details',							
							'lp_faqs_section'   => 'FAQs',
                            'lp_announcements_section'   => 'Announcements',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_menu_section'   => 'Menu',
							'lp_reviews_section'   => 'Reviews',
							'lp_reviewform_section'   => 'Review Form',
							),
						'disabled' => array(
							''   => '',
							),
						),
				),
				array(
					'id'       => 'lp-detail-page-layout-rsidebar',
					'type'     => 'sorter',
					'title'    => 'Sidebar Layout',
					'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles1'),
					'desc'     => 'Shuffle elements within Listing SideBar',
					'compiler' => 'true',
					'options'  => array(
						'sidebar'  => array(
							'lp_timing_section' => 'Timings',
							'lp_mapsocial_section'   => 'Map/Contacts',
							'lp_event_section'   => 'Event',							
							'lp_leadform_section'   => 'Leadform',                       
							'lp_quicks_section'   => 'Quick Actions',
							'lp_additional_section'   => 'Additional Details',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
							'lp_sidebarelemnts_section'   => 'Detail Page Sidebar Widgets',
							),
						'disabled' => array(
							''   => '',
							),
						),
				),
				/* for listing layout2 */
				array(
					'id'       => 'lp-detail-page-layout2-content',
					'type'     => 'sorter',
					'title'    => 'Content Layout',
					'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles2'),
					'desc'     => 'Shuffle tabs order within Listing Detail Content',
					'compiler' => 'true',
					'options'  => array(
						'general'  => array(
							'lp_content_section'   => 'Details',
							'lp_video_section' => 'Youtube Video',
							'lp_faqs_section'   => 'FAQs',
							'lp_reviews_section'   => 'Reviews',
							'lp_contacts_section'   => 'Contact info',
                            'lp_announcements_section'   => 'Announcements',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
                            'lp_menu_section'   => 'Menu',
							),
						'disabled' => array(
							''   => '',
							),
						),
				),
				array(
					'id'       => 'lp-detail-page-layout2-rsidebar',
					'type'     => 'sorter',
					'title'    => 'Sidebar Layout',
					'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles2'),
					'desc'     => 'Shuffle elements within Listing SideBar',
					'compiler' => 'true',
					'options'  => array(
						'sidebar'  => array(
							'lp_timing_section' => 'Timings',
							'lp_mapsocial_section'   => 'Map/Contacts', 
							'lp_event_section'   => 'Event',
							'lp_quicks_section'   => 'Quick Actions',
							'lp_additional_section'   => 'Additional Details',
                            'lp_offers_section'   => 'Offers/Discounts/Deals',
							'lp_sidebarelemnts_section'   => 'Detail Page Sidebar Widgets',
							),
						'disabled' => array(
							''   => '',
							),
						),
				),
				array(
                    'id'       => 'lp_detail_page_additional_styles',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Additional Details Position', 'listingpro'),
                    'subtitle' => esc_html__('Set additional details position to sidebar or below content area', 'listingpro'),
					//Must provide key => value pairs for options
					'options' => array(
						'left' => 'Left', 
						'right' => 'Right', 
					 ), 
					'required' => array('lp_detail_page_styles','equals',array('lp_detail_page_styles1', 'lp_detail_page_styles3', 'lp_detail_page_styles4')),
                    'default'  => 'right',
                ),
				array(
                    'id'       => 'lp_detail_page_video_display',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Video Display Option', 'listingpro'),
					'required' => array('lp_detail_page_styles','equals','lp_detail_page_styles1'),
                    'subtitle' => esc_html__('On=Show youtube video in popup, off=embed', 'listingpro'),
					 'options' => array(
					  'on' => 'On', 
					  'off' => 'Off', 
					  ), 
					 
					'default'  => 'on',
				),
				array(
                    'id'       => 'lp_detail_page_report_button',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Detail Listing Page Report Button', 'listingpro'),
                    'subtitle' => esc_html__('on/off', 'listingpro'),
					 'options' => array(
					  'on' => 'On', 
					  'off' => 'Off', 
					  ), 
					 
					'default'  => 'on',
				),
				
                array(
                    'id'       => 'discount_deals_offers_design',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Deals/Offer Design (content)', 'listingpro'),
                    'subtitle' => esc_html__('design for content area', 'listingpro'),
                    'options'  => array(
                        '1'      => array(
                            'alt'   => 'Deals Design',
                            'img'   => get_template_directory_uri().'/assets/images/admin/deal-design.png'
                        ),
                        '2'      => array(
                            'alt'   => 'Offers Design',
                            'img'   => get_template_directory_uri().'/assets/images/admin/offer-design.png'
                        ),
                    ),
                    'default' => '1'
                ),
                array(
                    'id'       => 'discount_deals_offers_design_sidebar',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Discount/Deals (sidebar)', 'listingpro'),
                    'subtitle' => esc_html__('design for sidebar area', 'listingpro'),
                    'required' => array('lp_detail_page_styles','equals',array('lp_detail_page_styles4', 'lp_detail_page_styles3', 'lp_detail_page_styles2', 'lp_detail_page_styles1')),
                    'options'  => array(
                        '1'      => array(
                            'alt'   => 'Deals Design',
                            'img'   => get_template_directory_uri().'/assets/images/admin/deal-design.png'
                        ),
                        '3'      => array(
                            'alt'   => 'Discounts Design',
                            'img'   => get_template_directory_uri().'/assets/images/admin/discount-desing.png'
                        ),
                    ),
                    'default' => '3'
                ),
				/* array(
                    'id'       => 'lp_allow_user_customize_detail_page',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Allow customization on front-end?', 'listingpro'),
                    'subtitle' => esc_html__('User will able to customize page from their dashboard', 'listingpro'),
					//Must provide key => value pairs for options
					'options' => array(
						'on' => 'On', 
						'off' => 'Off', 
					 ), 
                    'default'  => 'on',
                ), */
				
			
			)
		));
			
			
			
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Listing Archive View', 'listingpro' ),
			'id'               => 'listing_view',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
                array(
                    'id'       => 'listing_style',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Listing page layout', 'listingpro'), 
                    'subtitle' => esc_html__('', 'listingpro'),
                    'options'  => array(
                        '1'      => array(
                            'alt'   => 'Fullwidth - top search', 
                            'img'   => get_template_directory_uri().'/assets/images/admin/listing-search-top.jpg'
                        ),
//                       '2'      => array(
//                            'alt'   => 'with sidebar search',
//                            'img'   => get_template_directory_uri().'/assets/images/admin/listing-search.jpg'
//                        ),
                        '3'      => array(
                            'alt'   => 'Half map - half listing - top search', 
                            'img'   => get_template_directory_uri().'/assets/images/admin/listing-map.jpg'
                        ),
                        '4'      => array(
                            'alt'   => 'Listing with header filters',
                            'img'   => get_template_directory_uri().'/assets/images/admin/lsiting_layout_4.jpg'
                        ),
                    ),
                    'default' => '1'
                ),
                array(
                    'id'       => 'lp_archive_bg',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Background Image', 'listingpro' ),
                    'compiler' => 'true',
                    'required' => array('listing_style','equals','4'),
                    'desc'     => '',
                    'default'  => '',
                ),
                array(
                    'id'       => 'lp_listing_sub_cats',
                    'type'     => 'select',
                    'title'    => __('Child Categories', 'listingpro'),
                    'subtitle' => __('Choose an option', 'listingpro'),
                    'required' => array('listing_style','equals','4'),
                    'options'  => array(
                        'show' => 'Show',
                        'hide' => 'Hide',
                    ),
                    'default'  => 'show',
                ),
                array(
                    'id'       => 'lp_listing_sub_cats_lcation',
                    'type'     => 'select',
                    'title'    => __('Display Style', 'listingpro'),
                    'subtitle' => __('Choose display style for child categories ', 'listingpro'),
                    'required' => array('lp_listing_sub_cats','equals','show'),
                    'options'  => array(
                        'fullwidth' => 'Fullwidth',
                        'content' => 'Content Area',
                    ),
                    'default'  => 'content',
                ),
				array(
                    'id'       => 'c_ad',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Ad Image', 'listingpro' ),
                    'compiler' => 'true',
                    'required' => array('listing_style','equals','2'),
                    'desc'     => esc_html__( 'Put ad here', 'listingpro' ),
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/boximage2.jpg' ),
				),
                array(
                    'id'       => 'listing_views',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Listing page layout', 'listingpro'), 
                    'subtitle' => esc_html__('', 'listingpro'),
                    'options'  => array(
                        'list_view'      => array(
                            'alt'   => 'Listing detail layout', 
                            'img'   => get_template_directory_uri().'/assets/images/admin/listing-view.png'
                        ),
//                        'list_view3'      => array(
//                            'alt'   => 'Listing detail layout',
//                            'img'   => get_template_directory_uri().'/assets/images/admin/listview3.png'
//                        ),
                        'grid_view'      => array(
                            'alt'   => 'Listing detail layout', 
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid-view.png'
                        ),
						'grid_view2'      => array(
                            'alt'   => 'Listing detail layout', 
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid3.png'
                        ),
                        'grid_view3'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid4.png'
                        ),
                        'grid_view_v2'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/gird_view_v2.jpg'
                        ),
                        'list_view_v2'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/list_view_v2.png'
                        ),
                    ),
                    'default' => 'grid_view'
                ),
				
			)
		) );
		
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Listing Submit & Edit', 'listingpro' ),
			'id'               => 'listing_submit_settings',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
				
                // Harry Code Starts from here
                array(
                    'id'       => 'listing_submit_page_style',
                    'type'     => 'select',
                    'title'    => __('Page Style', 'listingpro'),
                    'subtitle' => __('Choose an option', 'listingpro'),
                    'desc'     => __('Select style for listing submit and edit', 'listingpro'),
                    'options'  => array(
                        'style1' => 'Page Style 1',
                        'style2' => 'Page Style 2',
                    ),
                    'default'  => 'style1',
                ),

				/* array(
                    'id'       => 'lp_listing_listing_by_custom',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Add Listing by custom input', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'yes',
                ),
				 */


				/* ----------------- */
				array(
                    'id'       => 'lp_listing_listing_by_google',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Auto-Pilot Front-End subbmission via google (Fill-O-Bot) ', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
                ),


				array(
                    'id'       => 'lp_listing_images_count_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Gallery Images Counter', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
                ),

				array(
                    'id'       => 'lp_listing_images_counter',
                    'type' => 'text',
                    'title'    => esc_html__( 'Max. allowed images in gallery', 'listingpro' ),
                    'subtitle' => esc_html__( 'Just use integer value. e.g 5', 'listingpro' ),
                    'description' => esc_html__( 'Maximum no. of images allowed in gallery while submitting a listing', 'listingpro' ),
                    'default' => '5',
					'required' => array('lp_listing_images_count_switch','equals','yes'),
                ),

				array(
                    'id'       => 'lp_listing_images_size_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Gallery Images Size', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
                ),

				array(
                    'id'       => 'lp_listing_images_sizes',
                    'type' => 'text',
                    'title'    => esc_html__( 'Total allowed images size in gallery', 'listingpro' ),
                    'subtitle' => esc_html__( 'Size is in Mbs, Just use integer value. e.g 5', 'listingpro' ),
                    'description' => esc_html__( 'Allowed size of all images in gallery', 'listingpro' ),
                    'default' => '5',
					'required' => array('lp_listing_images_size_switch','equals','yes'),
                ),
				/* ------------- */



                array(
                    'id'       => 'submit_ad_img_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('First section Image ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'submit_ad_img',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload Image for Submit Listing', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload Image for Submit Listing', 'listingpro' ),
                    'required' => array('submit_ad_img_switch','equals','1'), 
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/submt.png' ),
                ),
                array(
                    'id'       => 'submit_ad_img1_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Second section Image ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'submit_ad_img1',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload Image for second section', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload Image for second section', 'listingpro' ),
                    'required' => array('submit_ad_img1_switch','equals','1'), 
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/sbmt.png' ),
                ),
                array(
                    'id'       => 'submit_ad_img2_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Third section Image ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'submit_ad_img2',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload Image for third section', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload Image for third section', 'listingpro' ),
                    'required' => array('submit_ad_img2_switch','equals','1'), 
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/sbmt1.png' ),
                ),
                array(
                    'id'       => 'submit_ad_img3_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Fourth section Image ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'submit_ad_img3',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => esc_html__( 'Upload Image for Fourth section', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload Image for Fourth section', 'listingpro' ),
                    'required' => array('submit_ad_img3_switch','equals','1'), 
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/sbmt2.png' ),
                ),
                array(
                    'id'       => 'business_logo_switch',
                    'type'     => 'switch',
                    'title'    => esc_html__('Business Logo ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'business_logo_default',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Upload Default Logo', 'listingpro' ),
                    'compiler' => 'true',
                    'desc'     => esc_html__( 'Upload Image for Fourth section', 'listingpro' ),
                    'required' => array('business_logo_switch','equals','1'),
                    'default'	=> array( 'url'	=> get_template_directory_uri() .'/assets/images/claim1.png' ),
                ),
                array(
                    'id'       => 'quick_tip_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Quick Tips ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'quick_tip_title',
                    'type' => 'text',
                    'title'    => esc_html__( 'Quick Tip Title', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('quick_tip_switch','equals','1'),                    
                    'default' => 'Quick Tip',
                ),
                array(
                    'id'        => 'quick_tip_text',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Quick Text', 'listingpro'),
                    'subtitle'  => esc_html__('', 'listingpro'),
                    'required' => array('quick_tip_switch','equals','1'), 
                    'default'   => 'Add information about your business below. Your business page will not appear in search results until this information has been verified and approved by our moderators. Once it is approved, you will receive an email with instructions on how to claim your business page.'
                ),
                array(
                    'id'       => 'listing_title_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Title Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),                   
                    'default' => 'Listing Title',
                ),
                array(
                    'id'       => 'listing_city_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Location Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'default' => 'City',
                ),
				array(
					'id'       => 'lp_listing_location_mode',
					'type'     => 'select',
					'title'    => __('Select Location Mode', 'listingpro'),
					'subtitle' => __('Choose an option', 'listingpro'),
					'desc'     => __('Available options are single/multi Location', 'listingpro'),
					'options'  => array(
						'single' => 'Single',
						'multi' => 'Multi',
					),
					'default'  => 'single',
				),
				array(
                    'id'       => 'lp_showhide_address',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Address ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_gadd_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Google Address Button Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
					'required' => array('lp_showhide_address','equals','1'),
                    'default' => 'Full Address',
                ),
				array(
                    'id'       => 'listing_custom_cordn',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Custom Address Button Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
					'required' => array('lp_showhide_address','equals','1'),
                    'default' => 'Add Custom Address',
                ),
                array(
                    'id'       => 'phone_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Phone ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
				array(
                    'id'       => 'lp_detail_page_whatsapp_button',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('Whatsapp Field', 'listingpro'),
                    'subtitle' => esc_html__('on/off', 'listingpro'),
					 'options' => array(
					  'on' => 'On', 
					  'off' => 'Off', 
					  ), 
					 
					'default'  => 'off',
				),
				array(
                   'id'       => 'lp_whatsapp_label',
                   'type' => 'text',
                   'title'    => esc_html__( 'Whatsapp Field Label', 'listingpro' ),
                   'subtitle' => esc_html__( 'Label for whatsapp field', 'listingpro' ),
                   'description' => esc_html__( 'It will show on listing submit and edit page', 'listingpro' ),
                   'default' => 'Whatsapp',
                    'required' => array('lp_detail_page_whatsapp_button','equals','on'),
               ),
                array(
                    'id'       => 'listing_ph_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Phone Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('phone_switch','equals','1'),
                    'default' => 'Phone',
                ),
                array(
                    'id'       => 'web_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Website URL ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_web_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Website Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('web_switch','equals','1'),
                    'default' => 'Website',
                ),
                array(
                    'id'       => 'oph_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Hours ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_oph_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Operational Hours Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('oph_switch','equals','1'),
                    'default' => 'Add Business Hours',
                ),
				array(
                    'id'       => 'lp_hours_slot2',
                    'type'     => 'button_set', 
                    'title'    => esc_html__('2nd Time Slot', 'listingpro'),
					'required' => array('oph_switch','equals','1'),
                    'subtitle' => esc_html__('2 Times slots for a day Enable/Disable', 'listingpro'),
					 'options' => array(
					  'enable' => 'Enable', 
					  'disable' => 'Disable', 
					  ), 
					 
					'default'  => 'disable',
				),
                array(
                    'id'       => 'listing_cat_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Category Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),                   
                    'default' => 'Category',
                ),
				array(
					'id'       => 'lp_listing_category_mode',
					'type'     => 'select',
					'title'    => __('Select Category Mode', 'listingpro'),
					'subtitle' => __('Choose an option', 'listingpro'),
					'desc'     => __('Available options are single/multi category', 'listingpro'),
					'options'  => array(
						'single' => 'Single',
						'multi' => 'Multi',
					),
					'default'  => 'single',
				),
                array(
                    'id'       => 'listing_features_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Features area Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'default' => esc_html__( 'Select your listing features', 'listingpro' ),
                ),
                array(
                    'id'       => 'currency_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Price Range ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_curr_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Price Range Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('currency_switch','equals','1'),                    
                    'default' => 'Price Range',
                ),
                array(
                    'id'       => 'digit_price_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Price From ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_digit_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Price From Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('digit_price_switch','equals','1'),
                    'default' => 'Price From',
                ),
                array(
                    'id'       => 'price_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Price To ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_price_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Price To Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('price_switch','equals','1'),
                    'default' => 'Price To',
                ),
                array(
                    'id'       => 'listing_desc_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Description Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),                   
                    'default' => 'Description',
                ),
                array(
                    'id'       => 'faq_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('FAQ ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_faq_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add FAQ Title', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('faq_switch','equals','1'),
                    'default' => 'FAQ',
                ),
                array(
                    'id'       => 'listing_faq_tabs_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add FAQ Tabs Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('faq_switch','equals','1'),
                    'default' => 'FAQ',
                ),
				array(
                    'id'       => 'listin_social_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Social ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('Hide or show all socials', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'tw_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Twitter URL ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'fb_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Facebook URL ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lnk_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('LinkedIn ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'google_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Google Plus ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'yt_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Youtube ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'insta_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Instagram ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
					'required' => array('listin_social_switch','equals','1'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'tags_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Tags field ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_tags_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Tags Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('fb_switch','equals','1'),
                    'default' => 'Tags or keywords (Comma separated)',
                ),
                array(
                    'id'       => 'vdo_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Business video ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'listing_vdo_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Business video Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'required' => array('vdo_switch','equals','1'),
                    'default' => 'Your Business video',
                ),
                array(
                    'id'       => 'file_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Image Uploading ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lp_featured_file_switch',
                    'type'     => 'switch',
                    'title'    => esc_html__('Featured Image ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => false,
                ),
				array(
                    'id'       => 'location_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show Location ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
				array(
                    'id'       => 'listing_username_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add User Name Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'default'   => esc_html__( 'Enter User Name ', 'listingpro' ),
                ),
                array(
                    'id'       => 'listing_email_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Email Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),
                    'default'   => esc_html__( 'Enter Your email', 'listingpro' ),
                ),
                array(
                    'id'       => 'listing_btn_text',
                    'type' => 'text',
                    'title'    => esc_html__( 'Add Submit Listing Button Text', 'listingpro' ),
                    'subtitle' => esc_html__( '', 'listingpro' ),
                    'description' => esc_html__( '', 'listingpro' ),                    
                    'default' => 'Save & Preview',
                ),
				array(
					'id'       => 'listing_edit_btn_text',
					'type' => 'text',
					'title'    => esc_html__( 'Add Edit Listing Button Text', 'listingpro' ),
					'subtitle' => esc_html__( '', 'listingpro' ),
					'description' => esc_html__( '', 'listingpro' ),					
					'default' => 'Update & Preview',
				),
                // Harry Code Ends from here
			)
		) );
		
		/* **********************************************************************
		 * Locations
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Location', 'listingpro' ),
			'id'               => 'listing_submit_edit_locations',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_listing_location',
					'type' => 'info',
					'desc' => __('This section is for locations field in listing submission and edit. you can select either "Auto" or "Manual" locations option', 'listingpro')
				),
				
				array(
					'id'       => 'lp_listing_locations_options',
					'type'     => 'select',
					'title'    => __('Select Location Type', 'listingpro'),
					'subtitle' => __('Select option about locations', 'listingpro'),
					'desc'     => __('locations option for listing submit and edit', 'listingpro'),
					'options'  => array(
						'manual_loc' => 'Add Locations by Admin Only',
						'auto_loc' => 'Auto Locations by Google',
					),
					'default'  => 'manual_loc',
				),
				
				array(
					'id'       => 'lp_listing_locations_range',
					'type' => 'text',
					'title'    => esc_html__( 'Add Location Shortcode', 'listingpro' ),
					'required' => array('lp_listing_locations_options','equals','auto_loc'),
					'subtitle' => esc_html__( 'Shortcode to restrict locations for specific country ', 'listingpro' ),
					'description' => esc_html__('For locations codes, vist', 'listingpro').'<a href="http://www.fao.org/countryprofiles/iso3list/en/" target="_blank">'.' '.esc_html__('here', 'listingpro').'</a>. You can add single code at a time or you can leave the field empty to activate globally (word-wide).',
					'default' => '',
				),
				array(
					'id'       => 'lp_listing_locations_field_options',
					'type'     => 'select',
					'title'    => __('Select Location Pattern', 'listingpro'),
					'required' => array('lp_listing_locations_options','equals','auto_loc'),
					'subtitle' => __('Select option about locations pattern', 'listingpro'),
					'desc'     => __('locations option for pattern on search and listing submit and edit', 'listingpro'),
					'options'  => array(
						'with_region' => 'With Region',
						'no_region' => 'Without Region',
					),
					'default'  => 'no_region',
				),
				
			)
			)
		);
		
		/* **********************************************************************
		 * Reviews
		 * **********************************************************************/
		
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Reviews', 'listingpro' ),
			'id'               => 'listing_review_submit_option',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_post_review',
					'type' => 'info',
					'desc' => __('This section is for submit review option. You can on/off reviews submission. You can also allow user to submit their reviews on listing by either option', 'listingpro')
				),
				
				array(
                    'id'       => 'lp_review_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Review ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                
				array(
					'id'       => 'lp_review_submit_options',
					'type'     => 'select',
					'title'    => __('Post Review', 'listingpro'),
					'required' => array('lp_review_switch','equals','1'),					
					'subtitle' => __('Select option about review submit', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'sign_in' => 'Only by logged in User',
						'instant_sign_in' => 'Instant signup',
					),
					'default'  => 'instant_sign_in',
				),
				
				array(
                    'id'       => 'lp_detail_page_review_report_button',
                    'type'     => 'button_set',
					'required' => array('lp_review_switch','equals','1'),
                    'title'    => esc_html__('Detail Listing Page review Report Button', 'listingpro'),
                    'subtitle' => esc_html__('on/off', 'listingpro'),
					 'options' => array(
					  'on' => 'on', 
					  'off' => 'off', 
					  ), 
     
                    'default'  => 'on',
                ),
                array(
                    'id'       => 'lp_multirating_switch',
                    'type'     => 'switch',
                    'required' => array('lp_review_switch','equals','1'),
                    'title'    => esc_html__('Multi Rating ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => false,
                ),
                array(
                    'id'       => 'lp_multi_ratiing1_switch',
                    'type'     => 'switch',
                    'required' => array('lp_multirating_switch','equals','1'),
                    'title'    => esc_html__('Field 1', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lp_multi_ratiing1_label_switch',
                    'type'     => 'text',
                    'required' => array('lp_multi_ratiing1_switch','equals','1'),
                    'title'    => esc_html__('Label Field 1', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => '',
                ),
               
                array(
                    'id'       => 'lp_multi_ratiing2_switch',
                    'type'     => 'switch',
                    'required' => array('lp_multirating_switch','equals','1'),
                    'title'    => esc_html__('Field 2', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lp_multi_ratiing2_label_switch',
                    'type'     => 'text',
                    'required' => array('lp_multi_ratiing2_switch','equals','1'),
                    'title'    => esc_html__('Label Field 2', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => '',
                ),
                
                array(
                    'id'       => 'lp_multi_ratiing3_switch',
                    'type'     => 'switch',
                    'required' => array('lp_multirating_switch','equals','1'),
                    'title'    => esc_html__('Field 3', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lp_multi_ratiing3_label_switch',
                    'type'     => 'text',
                    'required' => array('lp_multi_ratiing3_switch','equals','1'),
                    'title'    => esc_html__('Label Field 3', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => '',
                ),
               

                array(
                    'id'       => 'lp_multi_ratiing4_switch',
                    'type'     => 'switch',
                    'required' => array('lp_multirating_switch','equals','1'),
                    'title'    => esc_html__('Field 4', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'lp_multi_ratiing4_label_switch',
                    'type'     => 'text',
                    'required' => array('lp_multi_ratiing4_switch','equals','1'),
                    'title'    => esc_html__('Label Field 4', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => '',
                ),
                

				/* ------------- */
				array(
                    'id'       => 'lp_listing_reviews_images_count_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Gallery Images Counter', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
					'required' => array('lp_review_switch','equals','1'),
                ),

				array(
                    'id'       => 'lp_listing_reviews_images_counter',
                    'type' => 'text',
                    'title'    => esc_html__( 'Max. allowed images in gallery', 'listingpro' ),
                    'subtitle' => esc_html__( 'Just use integer value. e.g 5', 'listingpro' ),
                    'description' => esc_html__( 'Maximum no. of images allowed in gallery while submitting a review', 'listingpro' ),
                    'default' => '5',
					'required' => array(
										array('lp_review_switch','equals','1'),
										array('lp_listing_reviews_images_count_switch','equals','yes'),
									),
                ),

				array(
                    'id'       => 'lp_listing_reviews_images_size_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Gallery Images Size', 'listingpro'),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
					'required' => array('lp_review_switch','equals','1'),
                ),

				array(
                    'id'       => 'lp_listing_reviews_images_sizes',
                    'type' => 'text',
                    'title'    => esc_html__( 'Total allowed images size in gallery', 'listingpro' ),
                    'subtitle' => esc_html__( 'Size is in Mbs, Just use integer value. e.g 5', 'listingpro' ),
                    'description' => esc_html__( 'Allowed size of all images in gallery', 'listingpro' ),
                    'default' => '5',
					'required' => array(
										array('lp_review_switch','equals','1'),
										array('lp_listing_reviews_images_size_switch','equals','yes'),
									),
                ),
				/* ------------- */
			)
			)
		);
		
		/* **********************************************************************
		 * Lead form
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Leads Form', 'listingpro' ),
			'id'               => 'listing_lead_form_option',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_lead form',
					'type' => 'info',
					'desc' => __('Show / Hide leads form from listing detail page', 'listingpro')
				),
				
				array(
                    'id'       => 'lp_lead_form_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Form ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
				array(
                    'id'       => 'lp_lead_form_switch_claim',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Show lead form only on claimed listing ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('on=show only on claimed, off= show on all listing', 'listingpro'),
					'required' => array('lp_lead_form_switch','equals','1'),
                    'default'  => false,
                ),
			)
		));
		
		/* **********************************************************************
		 * Claim ON/OFF
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Listing Claim', 'listingpro' ),
			'id'               => 'listing_listing_claim_option',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_listing_claim',
					'type' => 'info',
					'desc' => __('Show / Hide claim option for listing ', 'listingpro')
				),
				
				array(
                    'id'       => 'lp_listing_claim_switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Claim ON/OFF', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'default'  => true,
                ),
				array(
                    'id'		=> 'lp_listing_claim_image',
                    'url'		=> true,
                    'type'		=> 'media',
                    'title'		=> esc_html__( 'Claim Popup Image', 'listingpro' ),
                    'read-only'	=> false,
					'required' => array( 'lp_listing_claim_switch', '=', '1' ),
                    'default'	=> array( 'url'	=> get_template_directory_uri() .'/assets/images/claim1.png' ),
                    'subtitle'	=> esc_html__( 'Upload Claim Popup Image.', 'listingpro' ),
                ),
			)
		));
		
		/* **********************************************************************
		 * Listing nearby
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Listing Nearby', 'listingpro' ),
			'id'               => 'listing_nearby_loc',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_listing_nearby',
					'type' => 'info',
					'desc' => __('Show nearby listings in listing detail page sidebar', 'listingpro')
				),
				
				array(
					'id'       => 'listingpro_nearby_dest',
					'type' => 'text',
					'title'    => esc_html__( 'Add Distance for Nearby Location', 'listingpro' ),
					'subtitle' => esc_html__( 'Enter only numberic values. Do not add distance units here', 'listingpro' ),
					'description' => esc_html__('', 'listingpro').'</a>',
					'default' => '100',
				),
				array(
					'id'       => 'listingpro_nearby_dest_in',
					'type'     => 'select',
					'title'    => __('Destination in ', 'listingpro'), 
					'subtitle' => __('Nearby Destination Calculate in', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'km' => 'Kilometers',
						'mil' => 'Miles',
					),
					'default' => 'km',
				),
				
				array(
					'id'       => 'listingpro_nearby_filter',
					'type'     => 'select',
					'title'    => __('Filter By Listing Category ', 'listingpro'), 
					'subtitle' => __('Show Nearby listing only from current category', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => 'Yes',
						'no' => 'No',
					),
					'default' => 'no',
				),
				
				
				array(
					'id'       => 'listingpro_nearby_noposts',
					'type' => 'text',
					'title'    => esc_html__( 'No. of Nearby Listings', 'listingpro' ),
					'subtitle' => esc_html__( 'Enter only numberic values', 'listingpro' ),
					'description' => esc_html__('', 'listingpro').'</a>',
					'default' => '5',
				),
			)
		));
		
		
		/* **********************************************************************
		 * Listing nearby
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Google AdSense', 'listingpro' ),
			'id'               => 'listing_google_adnense_section',
			'customizer_width' => '400px',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'   => 'info_listing_googleads',
					'type' => 'info',
					'desc' => __('Paste Your Google AdSense code. Ads will show on listings detail page', 'listingpro')
				),
				
				array(
				'id'               => 'lp-gads-editor',
				'type'             => 'editor',
				'title'            => __('Google AdSense', 'listingpro'),
				'subtitle'         => __('Google Ads on listings details page', 'listingpro'),
				'default'          => '',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
				),

				/* for v2 */
				array(
					'id'   => 'info_listing_archive_googleads',
					'type' => 'info',
					'desc' => __('Paste Your Google AdSense code. Ads will show on listings archive page', 'listingpro')
				),

				array(
				'id'               => 'lp-archive-gads-editor',
				'type'             => 'editor',
				'title'            => __('Google AdSense', 'listingpro'),
				'subtitle'         => __('Google Ads on listings archive page', 'listingpro'),
				'default'          => '',
				'args'   => array(
					'teeny'            => true,
					'textarea_rows'    => 10
				)
				),
				/* end for v2 */

			)
		));

        /* **********************************************************************
         * Author archive settings
         * **********************************************************************/
        Redux::setSection( $opt_name, array(
            'title'            => __( 'Author Archive', 'listingpro' ),
            'id'               => 'author_general',
            'customizer_width' => '400px',
            'icon'             => 'el el-list-alt',
            'fields'     => array(
                array(
                    'id'		=> 'author_banner',
                    'url'		=> true,
                    'type'		=> 'media',
                    'title'		=> esc_html__( 'Banner Image', 'listingpro' ),
                    'read-only'	=> false,
                    'default'	=> array( 'url'	=> get_template_directory_uri() .'/assets/images/home-banner.jpg' ),
                ),
            )
        ) );

        Redux::setSection( $opt_name, array(
            'title'            => __( 'My Listings', 'listingpro' ),
            'id'               => 'author_listings',
            'customizer_width' => '400px',
            'subsection'       => true,
            'fields'     => array(
                array(
                    'id'       => 'my_listings_author',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable My Listings', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'my_listing_per_page',
                    'type'     => 'text',
                    'title'    => __( 'Listings Per Page', 'listingpro' ),
                    'required' => array('my_listings_author','equals','1'),
                    'subtitle' => __( 'It will effect on taxonomy and search page.', 'listingpro' ),
                    'desc' => __( 'Enter only digits. e-g 11', 'listingpro' ),
                    'default'  => '10',
                ),
                array(
                    'id'       => 'my_listing_views',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Listing page layout', 'listingpro'),
                    'subtitle' => esc_html__('', 'listingpro'),
                    'required' => array('my_listings_author','equals','1'),
                    'options'  => array(
                        'list_view'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/listing-view.jpg'
                        ),
                        'list_view3'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/listview3.png'
                        ),
                        'grid_view'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid-view.jpg'
                        ),
                        'grid_view2'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid3.png'
                        ),
                        'grid_view3'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/grid4.png'
                        ),
                        'grid_view_v2'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/gird_view_v2.png'
                        ),
                        'list_view_v2'      => array(
                            'alt'   => 'Listing detail layout',
                            'img'   => get_template_directory_uri().'/assets/images/admin/list_view_v2.png'
                        ),
                    ),
                    'default' => 'grid_view'
                ),
            )
        ) );
        
		Redux::setSection( $opt_name, array(
            'title'            => __( 'About Me', 'listingpro' ),
            'id'               => 'author_about',
            'customizer_width' => '400px',
            'subsection' => true,
            'fields'     => array(
                array(
                    'id'       => 'about_me',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable About Me', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Social Icons', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons_fb',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide Facebook', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons_tw',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide Twitter', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons_linkedin',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide LinkedIn', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons_gp',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide Goolge Plus', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),

                array(
                    'id'       => 'about_me_social_icons_inst',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide Instagram', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_me_social_icons_pin',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show / Hide Pinterest', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('about_me_social_icons','equals','1'),
                    'on'       => esc_html__( 'Show', 'listingpro' ),
                    'off'      => esc_html__( 'Hide', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_activities',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Activities', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'about_activities_title',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Heading', 'listingpro' ),
                    'default'  => esc_html__( 'Activities', 'listingpro' ),
                    'required' => array('about_activities','equals','1'),
                ),
            )
        ) );
//        Redux::setSection( $opt_name, array(
//            'title'            => __( 'Reviews', 'listingpro' ),
//            'id'               => 'author_reviews',
//            'customizer_width' => '400px',
//            'subsection' => true,
//            'fields'     => array(
//                array(
//                    'id'       => 'reviews',
//                    'type'     => 'switch',
//                    'title'    => esc_html__( 'Enable / Disable Reviews', 'listingpro' ),
//                    'desc'     => '',
//                    'subtitle' => '',
//                    'default'  => 1,
//                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
//                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
//                ),
//                array(
//                    'id'       => 'my_reviews_style',
//                    'type'     => 'image_select',
//                    'title'    => esc_html__('Listing page layout', 'listingpro'),
//                    'subtitle' => esc_html__('', 'listingpro'),
//                    'required' => array('reviews','equals','1'),
//                    'options'  => array(
//                        'style1'      => array(
//                            'alt'   => 'Reviews Style',
//                            'img'   => get_template_directory_uri().'/assets/images/admin/reviews1.png'
//                        ),
//                        'style2'      => array(
//                            'alt'   => 'Listing detail layout',
//                            'img'   => get_template_directory_uri().'/assets/images/admin/reviews2.png'
//                        ),
//                    ),
//                    'default' => 'style1'
//                ),
//            )
//        ) );
        Redux::setSection( $opt_name, array(
            'title'            => __( 'Photos', 'listingpro' ),
            'id'               => 'author_photos',
            'customizer_width' => '400px',
            'subsection' => true,
            'fields'     => array(
            array(
                'id'       => 'photos',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable / Disable Photos', 'listingpro' ),
                'desc'     => '',
                'subtitle' => '',
                'default'  => 1,
                'on'       => esc_html__( 'Enabled', 'listingpro' ),
                'off'      => esc_html__( 'Disabled', 'listingpro' ),
            ),
            array(
                'id'       => 'my_photos_per_page',
                'type'     => 'text',
                'title'    => __( 'Photos Per Page', 'listingpro' ),
                'required' => array('photos','equals','1'),
                'subtitle' => __( 'It will effect on taxonomy and search page.', 'listingpro' ),
                'desc' => __( 'Enter only digits. e-g 11', 'listingpro' ),
                'default'  => '10',
            ),

        )
        ) );
        Redux::setSection( $opt_name, array(
            'title'            => __( 'Contact', 'listingpro' ),
            'id'               => 'author_contact',
            'customizer_width' => '400px',
            'subsection' => true,
            'fields'     => array(
                array(
                    'id'       => 'contact',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable contact', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
            )
        ) );
        Redux::setSection( $opt_name, array(
            'title'            => __( 'Counters', 'listingpro' ),
            'id'               => 'author_countersss',
            'customizer_width' => '400px',
            'subsection' => true,
            'fields'     => array(
                array(
                    'id'       => 'author_counters',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Counters', 'listingpro' ),
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'counter_listing',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Listing Counter', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('author_counters','equals','1'),
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'counter_photos',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Photos Counter', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('author_counters','equals','1'),
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'counter_reviews',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Reviews Counter', 'listingpro' ),
                    'default'  => 1,
                    'required' => array('author_counters','equals','1'),
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
                array(
                    'id'       => 'report_btn',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable / Disable Report Button', 'listingpro' ),
                    'desc'     => '',
                    'subtitle' => '',
                    'default'  => 1,
                    'on'       => esc_html__( 'Enabled', 'listingpro' ),
                    'off'      => esc_html__( 'Disabled', 'listingpro' ),
                ),
            )
        ) );
		 /* **********************************************************************
		 * Pricing Plan Options
		 * **********************************************************************/


		Redux::setSection( $opt_name, array(
            'title'            => __( 'Pricing Plan Options', 'listingpro' ),
            'id'               => 'lp_pricing_plans',
            'customizer_width' => '400px',
			'icon'   => 'el-icon-delicious',
            'fields'     => array(
                array(
                    'id'       => 'lp_listing_paid_claim_switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Paid Claim ON/OFF', 'listingpro'),
					'required' => array( 'lp_listing_claim_switch', '=', '1' ),
                    'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
                ),

				array(
					'id'       => 'listingpro_plans_cats',
					'type'     => 'button_set',
					'title'    => __('Pre-Category Selection for Plans', 'listingpro'),
					'subtitle' => __('Attach specific plans for specific category', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
				),

				array(
					'id'       => 'listingpro_month_year_plans',
					'type'     => 'button_set',
					'title'    => __('Month & Year based plan', 'listingpro'),
					'subtitle' => __('Select Option in Pricing Plans Based on Monthly and Yearly based', 'listingpro'),
					'desc'     => __('Month = 30 days, Year=365 days', 'listingpro'),					
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',

				),

			)
		));
		
		 /* **********************************************************************
		 * Search filter Options
		 * **********************************************************************/
		Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Search Filter Options', 'listingpro' ),
		'id'     => 'search-filter-options',
		'desc'   => '',
		'icon'   => 'el-icon-filter',
		'fields'		=> array(
		
		array(
			'id'   => 'info_search_filter',
			'type' => 'info',
			'desc' => __('This section is for search filters on archive page. Here you can show/hide your desired search filter option. You can also show/hide the search filter completely.', 'listingpro')
		),
        
        array(
            'id'       => 'enable_search_filter',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable / Disable Search Filter', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
        array(
            'id'       => 'enable_price_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Price', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),

        array(
            'id'       => 'enable_opentime_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Open Time', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),

        array(
            'id'       => 'enable_high_rated_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Highest Rated', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),

        array(
            'id'       => 'enable_most_reviewed_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Most Reviewed', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		
		array(
            'id'       => 'enable_most_viewed_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Most Viewed', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		array(
            'id'       => 'enable_best_changed_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Best Match', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),

        array(
            'id'       => 'enable_cats_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Categories', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
        array(
            'id'       => 'enable_nearme_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Near Me', 'listingpro' ),
            'desc'     => esc_html__( 'This option will be enabled only if your site has SSL enabled', 'listingpro' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		//near me  and location
		array(
            'id'       => 'disable_location_in_nearme_search_filter',
            'type'     => 'switch',
			'required' => array( 
				array('enable_search_filter', '=', '1'), 
				array('enable_nearme_search_filter', '=', '1'), 
			),
            'title'    => esc_html__( 'Disable Location', 'listingpro' ),
            'desc'     => esc_html__( 'IF you enable this option, when near me filter is active, location will be excluded in all filter results', 'listingpro' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		//end near me  and location
		array(
			'id'       => 'lp_nearme_filter_param',
			'type'     => 'select',
			'title'    => __('Destination in ', 'listingpro'), 
			'required' => array( 'enable_nearme_search_filter', '=', '1' ),
			'subtitle' => __('Nearme Destination Calculate in', 'listingpro'),
			'desc'     => __('', 'listingpro'),
			'options'  => array(
				'km' => 'Kilometers',
				'mil' => 'Miles',
			),
			'default' => 'km',
		),
		/* array(
            'id'       => 'enable_readious_search_filter',
            'type'     => 'switch',
			'required' => array( 'enable_search_filter', '=', '1' ),
            'title'    => esc_html__( 'Radius Filter', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),*/
		array(
            'id'       => 'enable_readious_search_filter_default',
            'type'     => 'text',
            'required' => array( 'enable_nearme_search_filter', '=', '1' ),
            'title'    => esc_html__('Default Value', 'listingpro'),
            'subtitle' => '',
            'desc'     => esc_html__('Set default value of near me', 'listingpro'),
            'default'  => '105',
        ),
		array(
            'id'       => 'enable_readious_search_filter_min',
            'type'     => 'text',
            'required' => array( 'enable_nearme_search_filter', '=', '1' ),
            'title'    => esc_html__('Min Range', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '0',
        ),
        array(
            'id'       => 'enable_readious_search_filter_max',
            'type'     => 'text',
            'required' => array( 'enable_nearme_search_filter', '=', '1' ),
            'title'    => esc_html__('Max Range', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '1000',
        ), 
        array(
		'id'=> 'enable_extrafields_filter',
		'type'=> 'switch',
		'required' => array( 'enable_search_filter', '=', '1' ),
		'title'=> esc_html__( 'Additional Filter options', 'listingpro' ),
		'desc' => '',
		'subtitle' => '',
		'default'  => 0,
		'on'=> esc_html__( 'Enabled', 'listingpro' ), 
		'off'=> esc_html__( 'Disabled', 'listingpro' ),
        ),
	)
	
));
		
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Search Settings', 'listingpro' ),
			'id'               => 'lp_search_settings',
			'customizer_width' => '400px',
			'icon'             => 'el el-search',
			'fields'     => array(
				array(
					'id'       => 'lp_what_field_switcher',
					'type'     => 'switch', 
					'title'    => __('Hide/Show What Field', 'listingpro'),
					'subtitle' => __('on=hide  off=show', 'listingpro'),
					'default'  => false,
				),
				array(
					'id'       => 'lp_what_field_algo',
					'type'     => 'select',
					'required' => array( 'lp_what_field_switcher', '!=', '1' ),
					'title'    => __('Search Mode', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					// Must provide key => value pairs for select options
					'options'  => array(
						'titlematch' => 'Exact Match',
						'keyword' => 'Random Match',
					),
					'default'  => 'titlematch',
				),
				
				array(
					'id'       => 'lp_default_search_by',
					'type'     => 'select',
					'required' => array( 'lp_what_field_switcher', '!=', '1' ),
					'title'    => __('Default Search By', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('If someone does not select any suggestion from "What" field in search form, then this option will show its impact in search result.', 'listingpro'),
					// Must provide key => value pairs for select options
					'options'  => array(
						'title' => 'Title',
						'keyword' => 'Keyword/tag',
					),
					'default'  => 'title',
				),
				
				array(
					'id'       => 'lp_location_loc_switcher',
					'type'     => 'switch', 
					'title'    => __('Hide/Show Location Field', 'listingpro'),
					'subtitle' => __('on=hide  off=show', 'listingpro'),
					'default'  => false,
				),
				array(
					'id'       => 'search_loc_option',
					'type'     => 'select',
					'required' => array(
									array('lp_location_loc_switcher', '!=', '1'),
									array('lp_auto_current_locations_switch', "equals", '1'),
					),
					'title'    => __('Pre populated location in homepage search', 'listingpro'), 
					'subtitle' => __('', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					// Must provide key => value pairs for select options
					'options'  => array(
						'yes' => 'Yes',
						'no' => 'No',
					),
					'default'  => 'no',
				),
				array(
					'id'       => 'home_search_loc_switcher',
					'type'     => 'switch',
					'required' => array( 'lp_location_loc_switcher', '!=', '1' ),					
					'title'    => __('Enable typing in homepage location search field', 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default'  => false,
				),
				array(
					'id'       => 'inner_search_loc_switcher',
					'type'     => 'switch',
					'required' => array( 'lp_location_loc_switcher', '!=', '1' ),
					'title'    => __('Enable typing in inner pages location search field', 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default'  => false,
				),
				
				array(
					'id'       => 'lp_listing_search_locations_type',
					'type'     => 'select',
					'title'    => __('Select Location Search Type', 'listingpro'),
					'subtitle' => __('Select option about locations Search', 'listingpro'),
					'required' => array( 'lp_location_loc_switcher', '!=', '1' ),
					'desc'     => __('locations option for listing search in search form', 'listingpro'),
					'options'  => array(
						'manual_loc' => 'Locations by Admin Only',
						'auto_loc' => 'Auto Locations by Google',
					),
					'default'  => 'manual_loc',
				),
				array(
					'id'       => 'lp_listing_search_locations_range',
					'type' => 'text',
					'title'    => esc_html__( 'Add Location Shortcode', 'listingpro' ),
					'required' => array('lp_listing_search_locations_type','equals','auto_loc'),
					'subtitle' => esc_html__( 'Shortcode to restrict locations for specific country ', 'listingpro' ),
					'description' => esc_html__('For locations codes, vist', 'listingpro').'<a href="http://www.fao.org/countryprofiles/iso3list/en/" target="_blank">'.' '.esc_html__('here', 'listingpro').'</a>. You can add single code at a time or you can leave the field empty to activate globally (word-wide).',
					'default' => '',
				),
				
				array(
					'id'       => 'lp_exclude_listingtitle_switcher',
					'type'     => 'switch', 
					'title'    => __('Exclude Listing Title From Suggestions in Search', 'listingpro'),
					'subtitle' => __('on=exclude,  off=include', 'listingpro'),
					'default'  => false,
				),
				
			)
		));
		/* **********************************************************************
		 * Payment setting
		 * **********************************************************************/

 
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Payment Settings', 'listingpro' ),
    'id'     => 'payment-settings',
    'desc'   => '',
    'icon'   => 'el-icon-eur',
    'fields'		=> array(
       
    ),
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'General', 'listingpro' ),
    'id'     => 'payment-general',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
	
	array(
            'id'       => 'listings_admin_approved',
            'type'     => 'select',
            'title'    => esc_html__('Submitted Listings Should be Approved by Admin ?', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'options'  => array(
                'yes'   => esc_html__( 'Yes', 'listingpro' ),
                'no'   => esc_html__( 'No', 'listingpro' )
            ),
            'default'  => 'yes',
        ),
        array(
            'id'       => 'enable_paid_submission',
            'type'     => 'select',
            'title'    => esc_html__('Enable Paid Submission', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'options'  => array(
                'no'   => esc_html__( 'No', 'listingpro' ),
                'yes'   => esc_html__( 'Yes', 'listingpro' ),
            ),
            'default'  => 'no',
        ),
		
		array(
            'id'       => 'lp_enable_recurring_payment',
            'type'     => 'select',
            'title'    => esc_html__('Enable Recurring Payment', 'listingpro'),
            'subtitle' => '',
			'required' => array( 'enable_paid_submission', '=', 'yes' ),
            'desc'     => '',
            'options'  => array(
                'no'   => esc_html__( 'No', 'listingpro' ),
                'yes'   => esc_html__( 'Yes', 'listingpro' ),
            ),
            'default'  => 'no',
        ),
		array(
            'id'       => 'lp_recurring_notification_before',
            'type'     => 'text',
            'required' => array( 'lp_enable_recurring_payment', '=', 'yes' ),
            'title'    => esc_html__('Notify User before', 'listingpro'),
            'subtitle' => 'Enter No. Of days. Please add only digital value. e.g 2/4/5/9 etc',
            'desc'     => '',
            'default'  => '2',
        ),

        array(
            'id'       => 'per_listing_expire',
            'type'     => 'text',
            'required' => array( 'per_listing_expire_unlimited', '=', '1' ),
            'title'    => esc_html__('Number of Expire Days', 'listingpro'),
            'subtitle' => 'No of days until a listings will expire. Starts from the moment the listing is published on the website',
            'desc'     => '',
            'default'  => '30',
        ),
        array(
            'id'       => 'currency_paid_submission',
            'type'     => 'select',
            'title'    => esc_html__('Currency For Paid Submission', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'options'  => array(
                'USD'  => 'USD',
                'EUR'  => 'EUR',
                'BDT'  => 'BDT',
				'EGP'  => 'EGP',
                'AUD'  => 'AUD',
				'AED'  => 'AED',
                'BRL'  => 'BRL',
                'CAD'  => 'CAD',
                'CHF'  => 'CHF',
                'CZK'  => 'CZK',
                'DKK'  => 'DKK',
                'HKD'  => 'HKD',
                'HUF'  => 'HUF',
                'IDR'  => 'IDR',
                'ILS'  => 'ILS',
                'INR'  => 'INR',
                'JPY'  => 'JPY',
                'KOR'  => 'KOR',
                'KSH'  => 'KSH',
                'MYR'  => 'MYR',
                'MXN'  => 'MXN',
                'NGN'  => 'NGN',
                'NOK'  => 'NOK',
                'NZD'  => 'NZD',
                'PHP'  => 'PHP',
                'PLN'  => 'PLN',
                'RUB'  => 'RUB',
                'GBP'  => 'GBP',
                'GHS'  => 'GHS',
                'SGD'  => 'SGD',
                'SEK'  => 'SEK',
                'TWD'  => 'TWD',
                'TTD'  => 'TTD',
                'THB'  => 'THB',
                'TRY'  => 'TRY',
                'VND'  => 'VND',
                'ZAR'  => 'ZAR'
            ),
            'default'  => 'USD',
        ),
		
		array(
            'id'       => 'pricingplan_currency_position',
            'type'     => 'select',
            'title'    => esc_html__('Currency Position for pricing plan', 'listingpro'),
            'subtitle' => esc_html__('Symbol of currency to left or right side of price in pricing plans', 'listingpro'),
            'desc'     => esc_html__('', 'listingpro'),
            'options'  => array(
                'left'	=> 'Left',
                'right' => 'Right',
            ),
            'default'  => 'left',
        ),

        array(
            'id'       => 'payment_terms_condition',
            'type'     => 'select',
            'data'     => 'pages',
            'title'    => esc_html__( 'Terms & Conditions', 'listingpro' ),
            'subtitle' => esc_html__( 'Select terms & conditions page', 'listingpro' ),
            'desc'     => '',
			'default'  => '',
        ),
         array(
            'id'       => 'payment-checkout',
            'type'     => 'select',
            'data'     => 'pages',
            'title'    => esc_html__( 'Checkout Page', 'listingpro' ),
            'subtitle' => esc_html__( 'Select checkout page', 'listingpro' ),
            'desc'     => '',
			'default'  => '',
        ), 
		
		array(
			'id'=>'payment_fail',
			'type' => 'select',
			'data'     => 'pages',
			'title' => __('Failed Payment page - after failed payment', 'listingpro'),
			'subtitle' => __('This must be an URL.', 'listingpro'),
			'desc' => __('', 'listingpro'),
			'default'  => '',
		),
			
		array(
			'id'=>'payment_success',
			'type' => 'select',
			'data'     => 'pages',
			'title' => __('Thank you page - after successful payment', 'listingpro'),
			'subtitle' => __('This must be an URL.', 'listingpro'),
			'desc' => __('', 'listingpro'),
			'default'  => '',
		),
		array(
			'id'       => 'listingpro_coupons_switch',
			'type'     => 'button_set',
			'title'    => __('On/Off Coupons', 'listingpro'),
			'subtitle' => __('Enable disable on checkout page', 'listingpro'),
			'desc'     => __('', 'listingpro'),
			'options'  => array(
				'yes' => __('Yes', 'listingpro'),
				'no' => __('No', 'listingpro'),
			),
			'default' => 'no',
		),
        array(
            'id'       => 'listingpro_invoice_start_switch',
            'type'     => 'button_set',
            'title'    => __('Set Invoice Start', 'listingpro'),
            'subtitle' => __('Enable disable for Custom Inovice Start No.', 'listingpro'),
            'desc'     => __('', 'listingpro'),
            'options'  => array(
                'yes' => __('Yes', 'listingpro'),
                'no' => __('No', 'listingpro'),
            ),
            'default' => 'no',
        ),

        array(
            'id'       => 'listingpro_invoiceno_no_start',
            'type'     => 'text',
            'required' => array( 'listingpro_invoice_start_switch', '=', 'yes' ),
            'title'    => esc_html__('Invoice Start Number', 'listingpro'),
            'subtitle' => __('Set you own start no. of Invoice for payment', 'listingpro'),
            'desc'     => '',
            'default'  => '000000001',
        ),
	
	)
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Paypal Settings', 'listingpro' ),
    'id'     => 'mem-paypal-settings',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_paypal',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Paypal', 'listingpro' ),
            //'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		
		
        array(
            'id'       => 'paypal_api',
            'type'     => 'select',
			'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Paypal And Checkout Api', 'listingpro'),
            'subtitle' => esc_html__('Sandbox = test API. LIVE = real payments API', 'listingpro'),
            'desc'     => esc_html__('Update PayPal Checkout settings according to API type selection', 'listingpro'),
            'options'  => array(
                'sandbox'=> 'Sandbox',
                'live'   => 'Live',
            ),
            'default'  => 'sandbox',
        ),
        
        array(
            'id'       => 'paypal_api_username',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Paypal API Username', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        array(
            'id'       => 'paypal_api_password',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Paypal API Password', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        array(
            'id'       => 'paypal_api_signature',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Paypal API Signature', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        array(
            'id'       => 'paypal_receiving_email',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Paypal Receiving Email', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
    )
));
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Stripe Settings', 'listingpro' ),
    'id'     => 'mem-stripe-settings',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_stripe',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Stripe', 'listingpro' ),
            //'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		
		
		array(
            'id'       => 'stripe_api',
            'type'     => 'select',
			'required' => array( 'enable_stripe', '=', '1' ),
            'title'    => esc_html__('Stripe And Checkout Api', 'listingpro'),
            'subtitle' => esc_html__('Sandbox = test API. LIVE = real payments API', 'listingpro'),
            'desc'     => esc_html__('Update Stripe Checkout settings according to API type selection', 'listingpro'),
            'options'  => array(
                'sandbox'=> 'Sandbox',
                'live'   => 'Live',
            ),
            'default'  => 'sandbox',
        ),
        
        array(
            'id'       => 'stripe_secrit_key',
            'type'     => 'text',
            'required' => array( 'enable_stripe', '=', '1' ),
            'title'    => esc_html__('Secret Key', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        array(
            'id'       => 'stripe_pubishable_key',
            'type'     => 'text',
            'required' => array( 'enable_stripe', '=', '1' ),
            'title'    => esc_html__('Publishable Key', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        
    )
));
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Direct Payment / Wire Payment', 'listingpro' ),
    'id'     => 'mem-wire-payment',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_wireTransfer',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Wire Transfer', 'listingpro' ),
            //'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
         array(
            'id'       => 'direct_payment_instruction',
            'type'     => 'editor',
            'required' => array( 'enable_wireTransfer', '=', '1' ),
            'title'    => esc_html__('Wire instructions for direct payment', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '
					<div>Your full name and mailing address</div>
					<div>Your Santander Bank account number</div>
					<div>SWIFT Code - SVRNUS33 (International only)</div>
					<div>Santander Bank routing number</div>
			',
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10,
				'wpautop' => false
            )
        ),
    )
));

/* 2 - checkout */
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( '2Checkout Settings', 'listingpro' ),
    'id'     => 'mem-2checkout-settings',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_2checkout',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable 2Checkout', 'listingpro' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
        ),
		
		
		array(
            'id'       => '2checkout_api',
            'type'     => 'select',
			'required' => array( 'enable_2checkout', '=', '1' ),
            'title'    => esc_html__('2Checkout Mode', 'listingpro'),
            'subtitle' => esc_html__('Sandbox = test API. LIVE = real payments API', 'listingpro'),
            'desc'     => esc_html__('Update 2Checkout settings according to API type selection', 'listingpro'),
            'options'  => array(
                'sandbox'=> 'Sandbox',
                'live'   => 'Live',
            ),
            'default'  => 'sandbox',
        ),
		array(
            'id'       => '2checkout_acount_number',
            'type'     => 'text',
            'required' => array( 'enable_2checkout', '=', '1' ),
            'title'    => esc_html__('Account ID', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        array(
            'id'       => '2checkout_pubishable_key',
            'type'     => 'text',
            'required' => array( 'enable_2checkout', '=', '1' ),
            'title'    => esc_html__('Publishable Key', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
		array(
            'id'       => '2checkout_private_key',
            'type'     => 'text',
            'required' => array( 'enable_2checkout', '=', '1' ),
            'title'    => esc_html__('Private Key', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '',
        ),
        
    )
));

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Tax Settings', 'listingpro' ),
    'id'     => 'lp_tax_setting',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
		
        array(
            'id'       => 'lp_tax_swtich',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable taxes ON/OFF', 'listingpro' ),
            //'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'desc'     => '',
            'subtitle' => '',
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
			'default'  => 0,
        ),
		array(
            'id'       => 'lp_tax_label',
            'type'     => 'text',
            'required' => array( 'lp_tax_swtich', '=', '1' ),
            'title'    => esc_html__('Tax Title', 'listingpro'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => esc_html__('Value-Added Tax', 'listingpro'),
        ),
		array(
            'id'       => 'lp_tax_amount',
            'type'     => 'text',
            'required' => array( 'lp_tax_swtich', '=', '1' ),
            'title'    => esc_html__('Tax Rate', 'listingpro'),
            'subtitle' => esc_html__('Add rate without % sign', 'listingpro'),
            'desc'     => esc_html__('Tax rate will be added in every purchase of listing or campaign', 'listingpro'),
            'default'  => '5',
        ),
		array(
            'id'       => 'lp_tax_with_plan_swtich',
            'type'     => 'switch',
            'title'    => esc_html__( 'Include Tax with Pricing Plans Price ON/OFF', 'listingpro' ),
            'required' => array( 'lp_tax_swtich', '=', '1' ),
            'desc'     => '',
            'subtitle' => '',
            'on'       => esc_html__( 'Enabled', 'listingpro' ),
            'off'      => esc_html__( 'Disabled', 'listingpro' ),
			'default'  => 0,
        ),
    )
));


	
	$adminMail = get_option('admin_email');
	$blogName = get_option('blogname');
/* **********************************************************************
 * Email Management
 * **********************************************************************/
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Email Management', 'listingpro' ),
    'id'     => 'listingpro-email-management',
    'desc'   => '',
    'icon'   => 'el-icon-envelope el-icon-small',
    'fields'		=> array(
		
		/* ===================================Email General Setting======================================== */
		array(
			'id'     => 'listingpro-general-listing-email-info',
			'type'   => 'info',
			'notice' => false,
			'style'  => 'info',
			'title'  => wp_kses(__( '<span class="font24">General Email Settings</span>', 'listingpro' ), $allowed_html_array),
			'subtitle' => esc_html__('Set email address and email sender name here', 'listingpro'),
			'desc'   => ''
		),
		array(
			'id'       => 'listingpro_general_email_address',
			'type'     => 'text',
			'title'    => esc_html__('Email Address', 'listingpro'),
			'subtitle' => esc_html__('Email address for general email sending', 'listingpro'),
			'desc'     => 'Enter email address here',
			'default'  => $adminMail,
		),
		array(
			'id'       => 'listingpro_general_email_from',
			'type'     => 'text',
			'title'    => esc_html__('Email From', 'listingpro'),
			'subtitle' => esc_html__('Email sender name for general email sending', 'listingpro'),
			'desc'     => 'Enter email sender name here',
			'default'  => $blogName,
		),

		/* General Switch */
		 array(
			'id'       => 'lp_listing_general_switch',
			'type'     => 'button_set',
			'title'    => esc_html__('Enable Emails', 'listingpro'),
			'options'  => array(
				'yes' => __('Yes', 'listingpro'),
				'no' => __('No', 'listingpro'),
			),
			'default' => 'no',
		),

		array(
            'id'     => 'general-emails-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),

            'title'  => wp_kses(__( '<span class="font24">Global Shortcodes</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Shotcodes for every Email Template . %website_name as Website Name, %website_url as Website URL, %user_name as User Name', 'listingpro' )
        ),
		/* ===================================New User Registration======================================== */
		array(
            'id'     => 'email-new-user-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),

            'title'  => wp_kses(__( '<span class="font24">New Registered User</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for user registertaion email. %user_login_register as username, %user_pass_register as user password, %user_email_register as new user email', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_new_user_register',
            'type'     => 'text',
            'title'    => esc_html__('Subject for New User Notification', 'listingpro'),
            'subtitle' => esc_html__('Email subject for new user notification', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('Your username and password on %website_url', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_new_user_register',
            'type'     => 'editor',
            'title'    => esc_html__('Content for New User Notification', 'listingpro'),
            'subtitle' => esc_html__('Email content for new user notification', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('Hi there,
									Welcome to %website_url! You can login now using the below credentials:
									Username:%user_login_register
									Password: %user_pass_register
									If you have any problems, please contact us.
									Thank you!', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false,
				'wpautop' => false
            )
        ),
		

        array(
            'id'       => 'listingpro_subject_admin_new_user_register',
            'type'     => 'text',
            'title'    => esc_html__('Subject for New User Admin Notification', 'listingpro'),
            'subtitle' => esc_html__('Email subject for new user admin notification', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('New User Registration', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_admin_new_user_register',
            'type'     => 'editor',
            'title'    => esc_html__('Content for New User Admin Notification', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content for new user admin notification', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('New user registration on %website_url.
									Username: %user_login_register,
									E-mail: %user_email_register', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),

		/* ==================================New Listing Submit======================================= */
		array(
            'id'     => 'listingpro-new-listing-submit-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'  => wp_kses(__( '<span class="font24">Submit Listing</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for listng submission email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_new_submit_listing',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('Your listing has been submitted', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_new_submit_listing_content',
            'type'     => 'editor',
            'title'    => esc_html__('Content', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Other Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>45 B Road NY. USA</p>
</div>
</div>
</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
		array(
            'id'       => 'listingpro_subject_new_submit_listing_admin',
            'type'     => 'text',
            'title'    => esc_html__('Subject(for admin)', 'listingpro'),
            'subtitle' => esc_html__('Email subject', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('New listing has been submitted', 'listingpro'),
        ),
		array(
            'id'       => 'listingpro_new_submit_listing_content_admin',
            'type'     => 'editor',
            'title'    => esc_html__('Content(for admin)', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Other Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>45 B Road NY. USA</p>
</div>
</div>
</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
		/* new code by zaheer on 15march */
	
	/* =====================================Purchased Activated==================================== */
        
        array(
            'id'     => 'email-purchase-activated-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'  => wp_kses(__( '<span class="font24">Purchase Activated</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for purchased activated email. %listing_title as Listing title, %listing_url as Listing URL, %plan_title as Plan Title, %invoice_no as Invoice Number', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_purchase_activated',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for purchase activated', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('Your purchase has  activated', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_purchase_activated',
            'type'     => 'editor',
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for Purchase Activated', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;"><a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">Your purchase has been successful on  <a href="%website_url">%website_name</a></p>

<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Plan Name:</strong>%plan_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Plan Price:</strong>%plan_price</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Submitted:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>

</div>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Payment Method:</strong>%payment_method</p>

<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Other Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>45 B Road NY. USA</p>

</div>
</div>
</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
		array(
            'id'       => 'listingpro_subject_purchase_activated_admin',
            'type'     => 'text',
            'title'    => esc_html__('Subject(for admin)', 'listingpro'),
            'subtitle' => esc_html__('Email subject for purchase activated', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('A purchased has been made', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_purchase_activated_admin',
            'type'     => 'editor',
            'title'    => esc_html__('Content(for admin)', 'listingpro'),
            'subtitle' => esc_html__('Email content', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;"><a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">Your purchase has been successful on  <a href="%website_url">%website_name</a></p>

<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Plan Name:</strong>%plan_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Plan Price:</strong>%plan_price</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Submitted:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>

</div>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Payment Method:</strong>%payment_method</p>

<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Other Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>45 B Road NY. USA</p>

</div>
</div>
</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
	/* =====================================Listing Review Reply==================================== */

        array(
            'id'     => 'email-reviewreply-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'  => wp_kses(__( '<span class="font24">Review Reply</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for review reply email. %listing_title as Listing title, %listing_url as Listing URL, %sender_name as Sender Name, %reply as Review Reply ', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_listing_rev_reply',
            'type'     => 'text',
            'title'    => esc_html__('Subject for Review Reply', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject for Review Reply', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Review Reply', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_msg_listing_rev_reply',
            'type'     => 'editor',
            'title'    => esc_html__('Content for Review Reply', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content for Review Reply', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
			You have received a reply on your review.<br> Reply : %review_reply_text
			</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
/* =====================================Listing Approved==================================== */

        array(
            'id'     => 'email-approved-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'  => wp_kses(__( '<span class="font24">Approved Listing</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Listing Approve email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_listing_approved',
            'type'     => 'text',
            'title'    => esc_html__('Subject for Approved Listing', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject for approved listing', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your listing approved', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_listing_approved',
            'type'     => 'editor',
            'title'    => esc_html__('Content for Listing Approved', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content for listing approved', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on %website_url </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Order  Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>P-11, Paradise Floor, Sadiq Trade Center</p>
</div>
</div>
</div>', 'listingpro'),
            'args' => array(
                'teeny' => false,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),

	/* =====================================Listing Expired==================================== */
		
        array(
            'id'     => 'email-expired-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( '<span class="font24">Expired Listing</span>', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Listing Expired email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_listing_expired',
            'type'     => 'text',
            'title'    => esc_html__('Subject for Expired Listing', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject for expired listing', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your listing expired', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_listing_expired',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content for Listing Expired', 'listingpro'),
            'subtitle' => esc_html__('Email content for listing expired', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Order  Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>P-11, Paradise Floor, Sadiq Trade Center</p>
</div>
</div>
</div>', 'listingpro'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10,
				'wpautop' => false
            )
        ),
	/* =====================================Ads Expired==================================== */
		
        array(
            'id'     => 'email-expired-info-ads',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( '<span class="font24">Expired Ad Campaign</span>', 'listingpro' ), $allowed_html_array),
             'desc'   => esc_html__( 'Use these shortcodes only for Ad Campaign Expired email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),

        array(
            'id'       => 'listingpro_subject_ads_expired',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject for expired ads campaign', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your ad campaign has expired', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_ad_campaign_expired',
            'type'     => 'editor',
            'title'    => esc_html__('Content for ads campaigns Expired', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content for ads campaigns expired', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Order  Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>P-11, Paradise Floor, Sadiq Trade Center</p>
</div>
</div>
</div>', 'listingpro'),
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10,
				'wpautop' => false
            )
        ),

    
	/* =====================================Invoice Email==================================== */

        array(
            'id'     => 'email-wire-invoice-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Wire Invoice', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Wire Invoice email. %listing_title as Listing title, %listing_url as Listing URL, %invoice_no as invoice number', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_wire_invoice',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject wire inovice', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your new listing on %website_url', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_wire_invoice',
            'type'     => 'editor',
            'title'    => esc_html__('Content for wire invoice', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email content', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Order  Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>P-11, Paradise Floor, Sadiq Trade Center</p>
</div>
</div>
</div>', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
	
        array(
            'id'       => 'listingpro_subject_wire_invoice_admin',
            'type'     => 'text',
            'title'    => esc_html__('Subject(admin)', 'listingpro'),
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'subtitle' => esc_html__('Email subject(admin)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your new listing on %website_url', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_wire_invoice_admin',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content for wire(admin)', 'listingpro'),
            'subtitle' => esc_html__('Email content(admin)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('<div style="width: 100%; background: #f0f1f3; padding: 50px 0px;">
<a style="width: 45%; margin: 0 auto; text-align: center; display: block; padding-bottom: 25px; padding-left: 30px; padding-right: 30px;"><img src="images/logo.png" /></a>
<div style="width: 45%; background: #fff; padding: 50px 30px; margin: 0 auto;">
<p style="margin: 0px;">New  Listing has been submitted on <a href="%website_url" >%website_name</a> </p>

<h2 style="color: #2a6ad4; margin: 0px; font-size: 20px;">%listing_title</h2>
<div style="padding: 30px 0px 15px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Details are Following:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing Name:</strong>%listing_title</p>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Listing URL:</strong>%listing_url</p>
</div>
<div style="padding: 15px 0px 30px 0px;">
<h3 style="margin: 0px 0px 5px; font-size: 16px;">Order  Details:</h3>
<p style="margin: 0px; font-size: 14px;"><strong style="padding-right: 10px;">Full Address:</strong>P-11, Paradise Floor, Sadiq Trade Center</p>
</div>
</div>
</div>', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
/* =====================================Listing Claim Email On Submission==================================== */

        array(
            'id'     => 'email-listing-claim-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'  => wp_kses(__( 'Claim Listing ( submission )', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Claim email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_listing_claimer',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for claimer', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your claim has submitted', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_listing_claimer',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for claimer', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your Claim on listing <a href="%listing_url">%listing_title</a> has been submitted', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
		array(
            'id'       => 'listingpro_subject_listing_author',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for Author', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('A claim has been submitted on your listing', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_listing_author',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for Author', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Hi, A claim has been submitted on your listing <a href="%listing_url">%listing_title</a>. Please contact admin for further details', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
	
        
		array(
            'id'       => 'listingpro_subject_listing_claim_admin',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for Admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('New Claim has been submitted', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_listing_claim_admin',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for Admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('You have received a new claim on a listing <a href="%listing_url">%listing_title</a> Please login on dashboard for more details', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
/* =====================================Listing Claim Email On Approval==================================== */

        array(
            'id'     => 'email-listing-claim-aproval-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Claim Listing ( Approval )', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Claim Approval email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_listing_claim_approve',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject(claimer)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your claim has approved', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_listing_claim_approve',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content(claimer)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your Claim on listing <a href="%listing_url">%listing_title</a> has been approved', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		array(
            'id'       => 'listingpro_subject_listing_claim_approve_old_owner',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject(old owner)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Listing Claim notice', 'listingpro'),
        ),
        array(
            'id'       => 'listingpro_content_listing_claim_approve_old_owner',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content(old owner)', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Claim against your listing has been has been approved.Details are : <a href="%listing_url">%listing_title</a>', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		

		/* =====================================Campaign active email for admin==================================== */

        array(
            'id'     => 'lp-campaign-active-email-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Campaign Activation(To ADMIN)', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Campaign Activation email. %listing_title as Listing title, %listing_url as Listing URL, %campaign_packages as Packages Purchased, %author_name as Author name', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_campaign_activate',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject campaign activation', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Ad Campaign Activated', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_campaign_activate',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for Admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('%author_name just activated an ad campaign for a listing <a href="%listing_url">%listing_title</a> with packages %campaign_packages', 'listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	
		/* =====================================Campaign active email for Author==================================== */

        array(
            'id'     => 'lp-campaign-active-email-info-author',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Campaign Activation(To Author)', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Author Campaign Activation email. %listing_title as Listing title, %listing_url as Listing URL, %campaign_packages as Packages Purchased', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_campaign_activate_author',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject campaign activation', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Ad Campaign Activated', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_campaign_activate_author',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for Admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('You have activated a campaign on a listing <a href="%listing_url">%listing_title</a>  With packages %campaign_packages ','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	
		/* =====================================recurring payment reminder option==================================== */

        array(
            'id'     => 'lp-recurring-payment-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Recurring Payment Reminder Email', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Recurring Payment Notification email. you can use %listing_title as listing title, %plan_title for Plan name,  %plan_price as Plan Price, %plan_duration as Plan Duration and %notifybefore as no. of  day/days before payment deduction. Use shortcodes only in editor', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_recurring_payment',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for recurring reminder', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Recurring Payment Reminder', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_recurring_payment',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for recurring reminder', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('A Payment will be deduct from your card after %notifybefore day/days. Details are: Listing: %listing_title, Plan: %plan_title, Price: %plan_price, Duration: %plan_duration day/days   ','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		/* for admin */
		
		array(
            'id'       => 'listingpro_subject_recurring_payment_admin',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject (Admin)', 'listingpro'),
            'subtitle' => esc_html__('Email subject by admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Recurring Payment is due', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_recurring_payment_admin',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content (Admin)', 'listingpro'),
            'subtitle' => esc_html__('Email content by admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('A Payment is due by a user after %notifybefore day/days. Details are: Listing: %listing_title, Plan: %plan_title, Price: %plan_price, Duration: %plan_duration day/days   ','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	/* =====================================recurring subscription cancel email==================================== */

        array(
            'id'     => 'lp-subscription-cancel-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Subscription Cancel Email', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for cancel recurring submission  email. %listing_title as Listing title, %listing_url as Listing URL', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_cancel_subscription',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for subscription cancel', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Cancel Subscription Notification', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_cancel_subscription',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for cancel subscription', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Your subscription has been canceled successfully','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		/* for admin */
		
		array(
            'id'       => 'listingpro_subject_cancel_subscription_admin',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject (Admin)', 'listingpro'),
            'subtitle' => esc_html__('Email subject by admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Subscription cancel notification', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_cancel_subscription_admin',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content (Admin)', 'listingpro'),
            'subtitle' => esc_html__('Email content by admin', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('A subscription has been cancelled.','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
		
		/* =====================================Lead form email template==================================== */

        array(
            'id'     => 'lp-lead-form-email-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Lead Form Email Template', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Lead form email. %listing_title as listing title, %sender_name for sender name, %sender_email for sender email, %sender_phone for sender phone and %sender_message for sender message', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_lead_form',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject', 'listingpro'),
            'subtitle' => esc_html__('Email subject for lead form', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Somone contacted for a listing', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_lead_form',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Content', 'listingpro'),
            'subtitle' => esc_html__('Email content for lead form', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Someone has contacted you for the listing "%listing_title". Details are following<br>Name: %sender_name<br>Email: %sender_email<br>Phone:%sender_phone<br>Message: %sender_message','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	/* =====================================Reviews email template==================================== */

        array(
            'id'     => 'lp-review-form-email-info',
            'type'   => 'info',
            'notice' => false,
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'style'  => 'info',
            'title'  => wp_kses(__( 'Reviews Email Templates', 'listingpro' ), $allowed_html_array),
            'desc'   => esc_html__( 'Use these shortcodes only for Review email. %listing_title as listing title, %listing_url as listing link, %reviewtext as Review Message, and %reviewer_email for Reviewer Email in content', 'listingpro' )
        ),
        array(
            'id'       => 'listingpro_subject_review_author',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject for Listing Author', 'listingpro'),
            'subtitle' => esc_html__('Enter Subject of Email for Listing Author', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Review Submit Email', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_review_author',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Message for Listing Author', 'listingpro'),
            'subtitle' => esc_html__('Email content for Listing Author', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Someone has reviewed on the listing "%listing_title" which is yours. Details are following<br>Reviewer: %reviewer_email<br>Review: %reviewtext<br>Listing:%listing_title<br>URL: %listing_url','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	
      array(
            'id'       => 'listingpro_subject_reviewer',
            'type'     => 'text',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Subject for Reviewer', 'listingpro'),
            'subtitle' => esc_html__('Enter Subject of Email for Reviewer', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('Review Submit Email', 'listingpro'),
        ),
		
		array(
            'id'       => 'listingpro_content_reviewer',
            'type'     => 'editor',
			'required' => array(
				array('lp_listing_general_switch', '=', 'yes'),
				array('lp_listing_general_switch', '=', 'yes'),
			),
            'title'    => esc_html__('Message for Reviewer', 'listingpro'),
            'subtitle' => esc_html__('Email content for Reviewer', 'listingpro'),
            'desc'     => '',
            'default'  => esc_html__('You have reviewed on the listing "%listing_title". Details are following<br>Listing:%listing_title<br>URL: %listing_url','listingpro'),
            'args'   => array(
                'teeny'         => true,
                'textarea_rows' => 10,
				'wpautop' => false
            )
        ),
	
      
    ),
));
	
	
	  /* **********************************************************************
        * privacy settings
        * **********************************************************************/
        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Privacy Settings', 'listingpro' ),
            'id'     => 'privacy-settings',
            'desc'   => '',
            'icon'   => 'el-icon-eye-open',
            'fields'		=> array(
				
				array(
					'id'       => 'payment_terms_condition',
					'type'     => 'select',
					'data'     => 'pages',
					'title'    => esc_html__( 'Terms & Conditions', 'listingpro' ),
					'subtitle' => esc_html__( 'Select terms & conditions page', 'listingpro' ),
					'desc'     => '',
					'default'  => '',
				),
                array(
					'id'       => 'listingpro_privacy_register',
					'type'     => 'button_set',
					'title'    => __('On Signup', 'listingpro'), 
					'subtitle' => __('Privacy policy option for User Signup', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'yes',
				),
				
                array(
					'id'       => 'listingpro_privacy_listing',
					'type'     => 'button_set',
					'title'    => __('On Listing Submission', 'listingpro'), 
					'subtitle' => __('Privacy policy option for listing submission', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'yes',
				),
				
				array(
					'id'       => 'listingpro_privacy_review',
					'type'     => 'button_set',
					'title'    => __('On Review Submission', 'listingpro'), 
					'subtitle' => __('Privacy policy option for review submission', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
				),
				
				array(
					'id'       => 'listingpro_privacy_leadform',
					'type'     => 'button_set',
					'title'    => __('On Lead Form', 'listingpro'), 
					'subtitle' => __('Privacy policy option for lead form on listing detail page', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
				),
				
				array(
					'id'       => 'listingpro_privacy_claimform',
					'type'     => 'button_set',
					'title'    => __('On Listing Claim Form', 'listingpro'), 
					'subtitle' => __('Privacy policy option for listing claim form', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
				),
				
				array(
					'id'       => 'listingpro_privacy_contactform',
					'type'     => 'button_set',
					'title'    => __('On Contact Form', 'listingpro'), 
					'subtitle' => __('Privacy policy option for contact form', 'listingpro'),
					'desc'     => __('', 'listingpro'),
					'options'  => array(
						'yes' => __('Yes', 'listingpro'),
						'no' => __('No', 'listingpro'),
					),
					'default' => 'no',
				),
				
            ),
        ));

	
        /* **********************************************************************
        * Invoices
        * **********************************************************************/
        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Invoice Options', 'listingpro' ),
            'id'     => 'listing-invoice',
            'desc'   => '',
            'icon'   => 'el-icon-list-alt',
            'fields'		=> array(
				
                array(
                    'id'		=> 'invoice_logo',
                    'url'		=> true,
                    'type'		=> 'media',
                    'title'		=> esc_html__( 'Company Logo', 'listingpro' ),
                    'read-only'	=> false,
                    'default'	=> array( 'url'	=> get_template_directory_uri() .'/assets/images/logo.png' ),
                    'subtitle'	=> esc_html__( 'Upload company logo for invoices.', 'listingpro' ),
                ),
                array(
                    'id'		=> 'invoice_company_name',
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Company Name', 'listingpro' ),
                    'default'	=> 'Company Name',
                    'subtitle'	=> esc_html__( 'Enter company full name', 'listingpro' ),
                ),
                array(
                    'id'		=> 'invoice_address',
                    'type'		=> 'editor',
                    'title'		=> esc_html__( 'Company Address', 'listingpro' ),
                    'default'	=> '1161 Washingtown Avenue 299<br> Miami Beach 33141 FL',
                    'subtitle'	=> esc_html__( 'Enter company full address', 'listingpro' ),
					'args' => array(
						'teeny' => false,
						'textarea_rows' => 10,
						'wpautop' => false,
					)
                ),
                array(
                    'id'		=> 'invoice_phone',
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Company Phone', 'listingpro' ),
                    'default'	=> '(987)654 3210',
                    'subtitle'	=> '',
                ),
                array(
                    'id'		=> 'invoice_additional_info',
                    'type'		=> 'editor',
                    'title'		=> esc_html__( 'Additional Info', 'listingpro' ),
                    'default'	=> '<p>The lorem ipsum text is typically a scrambled section of De finibus bonorum et malorum, a 1st-century BC Latin text by Cicero, with words altered, added, and removed to make it nonsensical, improper Latin.[citation needed]</p>',
                    'subtitle'	=> 'This information is only for Wire invoices.'
                ),
                array(
                    'id'		=> 'invoice_thankyou',
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Thank You text', 'listingpro' ),
                    'default'	=> 'Thank you for your business with us.',
                    'subtitle'	=> 'This information is only for Wire invoices.',
                ),
            ),
        ));
        /* **********************************************************************
         * Ads Options
         * **********************************************************************/
        Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Ads Options', 'listingpro' ),
            'id'     => 'listing-ads',
            'desc'   => '',
            'icon'   => 'el-icon-screen',
            'fields'		=> array(

                array(
                    'id'       => 'listingpro_ads_campaign_style',
                    'type'     => 'button_set',
                    'title'    => __('Campaign type', 'listingpro'),
                    'subtitle' => __('Select type of campaign', 'listingpro'),
                    'desc'     => __('', 'listingpro'),
                    'options'  => array(
                        'adsperduration' => __('Pay Per Day (PPD)', 'listingpro'),
                        'adsperclick' => __('Pay Per Click (PPC)', 'listingpro'),
                    ),
                    'default' => 'adsperduration',
                ),
				
				array(
                    'id'       => 'lp_pro_img_new',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __( 'Create ad popup image', 'listingpro' ),
                    'compiler' => 'true',
                    //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                    'desc'     => __( 'Upload your image here', 'listingpro' ),
                    'default'  => array( 'url' => get_template_directory_uri().'/assets/images/time1.png' ),
                ),

                array(
                    'id'        => 'lp_pro_title_new',
                    'url'       => true,
                    'type'      => 'text',
                    'title'     => esc_html__( 'Create ad popup Title', 'listingpro' ),
                    'read-only' => false,
                    'default'   => 'Create your Ad Campaign in 3 Simple Steps',
                ),
				
				array(
                    'id'        => 'lp_pro_text_list1',
                    'url'       => true,
                    'type'      => 'textArea',
                    'title'     => esc_html__( 'Create ad popup text list 1', 'listingpro' ),
                    'read-only' => false,
                    'default'   => '<h5>Daily Updates</h5><p>It wont be a bigger problem to find one</p>',
                ),
				
				array(
                    'id'        => 'lp_pro_text_list2',
                    'url'       => true,
                    'type'      => 'textArea',
                    'title'     => esc_html__( 'Create ad popup text list 2', 'listingpro' ),
                    'read-only' => false,
                    'default'   => '<h5>Game First Conceptualized</h5><p>During the formulative years, video games we</p>',
                ),
				
				array(
                    'id'        => 'lp_pro_text_list3',
                    'url'       => true,
                    'type'      => 'textArea',
                    'title'     => esc_html__( 'Create ad popup text list 3', 'listingpro' ),
                    'read-only' => false,
                    'default'   => '<h5>Tube Amusement Device</h5><p>It wont be a bigger problem to find one</p>',
                ),
                
                
                array(
                    'id'       => 'lp_random_ads_switch',
                    'type'     => 'switch',
                    'title'    => __( 'Spotlight Ads', 'listingpro' ),
                    'desc'     => __( 'ON=Allow, OFF=Block', 'listingpro' ),
                    'default'  => 1,
                ),
                array(
                    'id'		=> 'lp_random_ads',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Spotlight', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_random_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperduration'),
                    ),
                    'default'	=> '10',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include any currency sign ).', 'listingpro' ),
                ),
                array(
                    'id'		=> 'lp_random_ads_pc',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Spotlight', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_random_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperclick'),
                    ),
                    'default'	=> '10',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include any currency sign ).', 'listingpro' ),
                ),
                array(
                    'id'       => 'lp_detail_page_ads_switch',
                    'type'     => 'switch',
                    'title'    => __( 'Side of Listing Ads', 'listingpro' ),
                    'desc'     => __( 'ON=Allow, OFF=Block', 'listingpro' ),
                    'default'  => 1,
                ),
                array(
                    'id'		=> 'lp_detail_page_ads',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Side of Listing', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_detail_page_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperduration'),
                    ),
                    'default'	=> '20',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include currency sign ).', 'listingpro' ),
                ),
                array(
                    'id'		=> 'lp_detail_page_ads_pc',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Side of Listing', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_detail_page_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperclick'),
                    ),
                    'default'	=> '20',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include currency sign ).', 'listingpro' ),
                ),

                array(
                    'id'       => 'lp_top_in_search_page_ads_switch',
                    'type'     => 'switch',
                    'title'    => __( 'Top of Search Ads', 'listingpro' ),
                    'desc'     => __( 'ON=Allow, OFF=Block', 'listingpro' ),
                    'default'  => 1,
                ),
                array(
                    'id'		=> 'lp_top_in_search_page_ads',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Top of Search', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_top_in_search_page_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperduration'),
                    ),
                    'default'	=> '50',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include currency sign ).', 'listingpro' ),
                ),
				 array(
                    'id'		=> 'lp_top_in_search_page_ads_pc',
                    'url'		=> true,
                    'type'		=> 'text',
                    'title'		=> esc_html__( 'Top of Search', 'listingpro' ),
                    'read-only'	=> false,
                    'required' => array(
                        array('lp_top_in_search_page_ads_switch','equals','1'),
                        array('listingpro_ads_campaign_style','equals','adsperclick'),
                    ),
                    'default'	=> '50',
                    'subtitle'	=> esc_html__( 'Enter the amount you want to charge business owners to promote their listings for this format and placement( Do not include currency sign ).', 'listingpro' ),
                ),
//                needs to removed after update (might be many)
                array(
                    'id'       => 'listings_ads_durations',
                    'type'     => 'select',
                    'title'    => esc_html__('Ads Duration', 'listingpro'),
                    'subtitle' => '',
                    'desc'     => 'This option is only for backward compatibility, It will be removed after 10 of September,',
                    'options'  => array(
                        '1'   => esc_html__( '1 Day', 'listingpro' ),
                        '2'   => esc_html__( '2 Days', 'listingpro' ),
                        '3'   => esc_html__( '3 Days', 'listingpro' ),
                        '4'   => esc_html__( '4 Days', 'listingpro' ),
                        '5'   => esc_html__( '5 Days', 'listingpro' ),
                        '6'   => esc_html__( '6 Days', 'listingpro' ),
                        '7'    => esc_html__( '1 Week', 'listingpro' ),
                        '14'   => esc_html__( '2 Weeks', 'listingpro' ),
                        '21'   => esc_html__( '3 Weeks', 'listingpro' ),
                        '28'   => esc_html__( '4 Weeks', 'listingpro' ),
                        '30'   => esc_html__( '30 Days', 'listingpro' ),
                        '60'   => esc_html__( '60 Days', 'listingpro' ),
                        '90'   => esc_html__( '90 Days', 'listingpro' ),
                        '120'   => esc_html__( '120 Days', 'listingpro' ),
                        '150'   => esc_html__( '150 Days', 'listingpro' ),
                        '180'   => esc_html__( '180 Days', 'listingpro' ),
                        '210'   => esc_html__( '210 Days', 'listingpro' ),
                        '240'   => esc_html__( '240 Days', 'listingpro' ),
                        '270'   => esc_html__( '270 Days', 'listingpro' ),
                        '300'   => esc_html__( '300 Days', 'listingpro' ),
                        '330'   => esc_html__( '330 Days', 'listingpro' ),
                        '360'   => esc_html__( '360 Days', 'listingpro' ),
                    ),
                    'default'  => '7',
                ),
               
                /* array(
                   'id'       => 'listings_ads_durations',
                   'type'     => 'select',
                   'title'    => esc_html__('Ads Duration', 'listingpro'),
                   'subtitle' => '',
                   'desc'     => '',
                   'options'  => array(
                       '1'   => esc_html__( '1 Day', 'listingpro' ),
                       '2'   => esc_html__( '2 Days', 'listingpro' ),
                       '3'   => esc_html__( '3 Days', 'listingpro' ),
                       '4'   => esc_html__( '4 Days', 'listingpro' ),
                       '5'   => esc_html__( '5 Days', 'listingpro' ),
                       '6'   => esc_html__( '6 Days', 'listingpro' ),
                       '7'    => esc_html__( '1 Week', 'listingpro' ),
                       '14'   => esc_html__( '2 Weeks', 'listingpro' ),
                       '21'   => esc_html__( '3 Weeks', 'listingpro' ),
                       '28'   => esc_html__( '4 Weeks', 'listingpro' ),
                       '30'   => esc_html__( '30 Days', 'listingpro' ),
                       '60'   => esc_html__( '60 Days', 'listingpro' ),
                       '90'   => esc_html__( '90 Days', 'listingpro' ),
                       '120'   => esc_html__( '120 Days', 'listingpro' ),
                       '150'   => esc_html__( '150 Days', 'listingpro' ),
                       '180'   => esc_html__( '180 Days', 'listingpro' ),
                       '210'   => esc_html__( '210 Days', 'listingpro' ),
                       '240'   => esc_html__( '240 Days', 'listingpro' ),
                       '270'   => esc_html__( '270 Days', 'listingpro' ),
                       '300'   => esc_html__( '300 Days', 'listingpro' ),
                       '330'   => esc_html__( '330 Days', 'listingpro' ),
                       '360'   => esc_html__( '360 Days', 'listingpro' ),
                   ),
                   'default'  => '7',
                   'required' => array(
                       array('lp_random_ads_switch','equals','1'),
                       array('listingpro_ads_campaign_style','equals','adsperduration'),
                   ),

               ), */





            ),
        ));
		
	/* **********************************************************************
	 * Captcha Settings
	 * **********************************************************************/
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Form Captcha', 'listingpro' ),
		'id'     => 'listing-captcha',
		'desc'   => '',
		'icon'   => 'el-icon-lock',
		'fields'		=> array(
		
			array(
                'id'       => 'lp_recaptcha_switch',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Google Captcha', 'listingpro' ),
                'desc'     => __( 'Captcha for forms', 'listingpro' ),
                'default'  => 0,
            ),
			array(
                'id'       => 'lp_recaptcha_site_key',
                'type'     => 'text',
                'title'    => __( 'Google Recaptcha Site Key', 'listingpro' ),
				'desc'     => __( 'Create Key <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>', 'listingpro' ),
				'required' => array('lp_recaptcha_switch','equals','1'),
                'subtitle' => __( 'Site Key For Google Recaptcha', 'listingpro' ),
                'default'  => '',
            ),
			array(
                'id'       => 'lp_recaptcha_secret_key',
                'type'     => 'text',
                'title'    => __( 'Google Recaptcha Secret Key', 'listingpro' ),
				'desc'     => __( 'Create Key <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>', 'listingpro' ),
				'required' => array('lp_recaptcha_switch','equals','1'),
                'subtitle' => __( 'Secret Key For Google Recaptcha', 'listingpro' ),
                'default'  => '',
            ),
			array(
                'id'       => 'lp_recaptcha_registration',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of user registeration', 'listingpro' ),
                'desc'     => __( 'Captcha for registeration form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_login',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of user login', 'listingpro' ),
                'desc'     => __( 'Captcha for login form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_listing_submission',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of Listing Submission', 'listingpro' ),
                'desc'     => __( 'Captcha for Listing submission form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_listing_edit',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of Listing Edit', 'listingpro' ),
                'desc'     => __( 'Captcha for Listing edit form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_lead',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of Lead Form', 'listingpro' ),
                'desc'     => __( 'Captcha for Lead form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_reviews',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of Review Form', 'listingpro' ),
                'desc'     => __( 'Captcha for Review form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			array(
                'id'       => 'lp_recaptcha_contact',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Recaptcha of Contact Page Form', 'listingpro' ),
                'desc'     => __( 'Captcha for Contact form', 'listingpro' ),
                'default'  => 0,
				'required' => array('lp_recaptcha_switch','equals','1'),
            ),
			
		
		),
	));
	



}
	
	
	
	if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
		
		// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'URL Config', 'listingpro' ),
			'id'               => 'URL settings',
			'customizer_width' => '400px',
			'icon'             => 'el el-link',
			'fields'     => array(
					array(
					'id'    => 'lp_info_warning',
					'type'  => 'info',
					'title' => __('URL Rewrite', 'listingpro'),
					'style' => 'warning',
					'desc'  => __('Please update permalinks ( under Settings menu ) after any changes you make in following slugs ( to avoid a 404 error page )', 'listingpro')
				),
				array(
					'id'       => 'listing_slug',
					'type'     => 'text',
					'title'    => __( 'Rewrite listing slug', 'listingpro' ),
					'subtitle' => __( 'Default is "listing"', 'listingpro' ),
					'default'  => 'listing',
				),
				array(
					'id'       => 'listing_cat_slug',
					'type'     => 'text',
					'title'    => __( 'Rewrite listing category slug', 'listingpro' ),
					'subtitle' => __( 'Default is "listing-category"', 'listingpro' ),
					'default'  => 'listing-category',
				),
				array(
					'id'       => 'listing_loc_slug',
					'type'     => 'text',
					'title'    => __( 'Rewrite location slug', 'listingpro' ),
					'subtitle' => __( 'Default is "location"', 'listingpro' ),
					'default'  => 'location',
				),
				array(
					'id'       => 'listing_features_slug',
					'type'     => 'text',
					'title'    => __( 'Rewrite features slug', 'listingpro' ),
					'subtitle' => __( 'Default is "features"', 'listingpro' ),
					'default'  => 'features',
				),
				array(
					'id'       => 'events_slug',
					'type'     => 'text',
					'title'    => __( 'Rewrite events slug', 'listingpro' ),
					'subtitle' => __( 'Default is "events"', 'listingpro' ),
					'default'  => 'events',
				),
				array(
					'id'=>'listing-author',
					'type' => 'text',
					'title' => __('Author Page URL', 'listingpro'),
					'subtitle' => __('This must be an URL.', 'listingpro'),
					'validate' => 'url',
					'default' => ''
				),
				array(
					'id'=>'submit-listing',
					'type' => 'text',
					'title' => __('Submit Listing', 'listingpro'),
					'subtitle' => __('This must be an URL.', 'listingpro'),
					'desc' => __('This is a page for Submiting new listing', 'listingpro'),
					'validate' => 'url',
					'default' => ''
				),
				array(
					'id'=>'edit-listing',
					'type' => 'text',
					'title' => __('Edit Listing', 'listingpro'),
					'subtitle' => __('This must be an URL.', 'listingpro'),
					'desc' => __('This is a page for Edit your listing', 'listingpro'),
					'validate' => 'url',
					'default' => ''
				),
				array(
					'id'=>'pricing-plan',
					'type' => 'text',
					'title' => __('Price plans', 'listingpro'),
					'subtitle' => __('This must be an URL.', 'listingpro'),
					'desc' => __('This is a page for selecting price plans', 'listingpro'),
					'validate' => 'url',
					'default' => ''
				),
				

				
			)
		) );
    
	}
	
	// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Contact Page', 'listingpro' ),
			'desc'            => __( 'Translate all text strings into your own language', 'listingpro' ),
			'id'               => 'contact_page',
			'customizer_width' => '400px',
			'icon'             => 'el el-phone'

		) );	
		
	// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Contact Information', 'listingpro' ),
			'desc'            => __( 'Add or edit Content Contact information', 'listingpro' ),
			'id'               => 'contact_page_information',
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'=>'cp-show-contact-details',
					'type' => 'switch',
					'title' => __("Show/Hide contact information", 'listingpro'),
					'subtitle' => __('ON=SHOW, OFF= HIDE', 'listingpro'),
					'default' => 1
				),
				
				array(
					'id'=>'Address',
					'type' => 'text',
					'title' => __("Title for contact information", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'Address',
					'required' => array('cp-show-contact-details','equals','1')
				),
				array(
					'id'=>'cp-address',
					'type' => 'text',
					'title' => __("Your Address", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => ' Your Address at Lutaco Tower 007A Nguyen Van Troi',
					'required' => array('cp-show-contact-details','equals','1')
				),
				array(
					'id'=>'cp-number',
					'type' => 'text',
					'title' => __("Your Phone", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => '+008 1234 6789',
					'required' => array('cp-show-contact-details','equals','1')
					
				),
				array(
					'id'=>'cp-email',
					'type' => 'text',
					'title' => __("Your Email", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'xyz@example.com',
					'required' => array('cp-show-contact-details','equals','1'),
				),
				array(
					'id'=>'cp-social-links',
					'type' => 'switch',
					'title' => __("Social Links", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 1,
					'required' => array('cp-show-contact-details','equals','1'),
				),
				array(
                    'id'=>'fb_co',
                    'type' => 'text',
                    'title' => __("Facebook URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'tw_co',
                    'type' => 'text',
                    'title' => __("Twitter URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'gog_co',
                    'type' => 'text',
                    'title' => __("Google URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'insta_co',
                    'type' => 'text',
                    'title' => __("Instagram URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'tumb_co',
                    'type' => 'text',
                    'title' => __("Tumbler URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'f_yout_co',
                    'type' => 'text',
                    'title' => __("Youtube URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'f_linked_co',
                    'type' => 'text',
                    'title' => __("LinkedIn URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'f_pintereset_co',
                    'type' => 'text',
                    'title' => __("Pinterest URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),
                array(
                    'id'=>'f_vk_co',
                    'type' => 'text',
                    'title' => __("VK URL", 'listingpro'),
                    'subtitle' => __('', 'listingpro'),
                    'default' => '',
                    'required' => array('cp-social-links','equals','1'),
                ),

			)
		) );
		
		
		
		
		
		// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Form Settings', 'listingpro' ),
			'desc'            => __( 'Add or edit Form settings', 'listingpro' ),
			'id'               => 'contact_page_form',
			'customizer_width' => '400px',
			'icon'             => 'el el-caret-up',
			'subsection' => true,
			'fields'     => array(
			
				array(
					'id'=>'form-title',
					'type' => 'text',
					'title' => __("Title for From", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'Contact us'
				),
				array(
					'id'=>'form-title',
					'type' => 'text',
					'title' => __("Title for From", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'Contact us'
				),
				array(
					'id'=>'cp-success-message',
					'type' => 'textArea',
					'title' => __("Success message for contact form", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'Your message was sent successfully! I will be in touch as soon as I can.'
				),
				array(
					'id'=>'cp-failed-message',
					'type' => 'textArea',
					'title' => __("failed or error message for contact form", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default' => 'Something went wrong, try refreshing and submitting the form again.'
				),
				

			)
		) );
		
		// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Contact Map Settings', 'listingpro' ),
			'desc'            => __( 'Set Latitude and longitude for contact page map', 'listingpro' ),
			'id'               => 'contact_page_map',
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'contact_page_map_switch',
					'type'     => 'switch', 
					'title'    => __('Contact Page Map Option', 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'default'  => true,
				),
				array(
					'id'=>'cp-lat',
					'type' => 'text',
					'title' => __("Latitude", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'required' => array('contact_page_map_switch','equals','1'),
					'default' => '51.516576'
				),
				array(
					'id'=>'cp-lan',
					'type' => 'text',
					'title' => __("Longitude", 'listingpro'),
					'subtitle' => __('', 'listingpro'),
					'required' => array('contact_page_map_switch','equals','1'),
					'default' => '-0.137508'
				),


			)
		) );
	
		
			
	// -> START Basic Fields
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Footer', 'listingpro' ),
			'desc'            => __( 'Add or edit Footer information', 'listingpro' ),
			'id'               => 'footer_section_information',
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			//'subsection' => true,
			'fields'     => array(
			array(
                'id'       => 'footer_style',
                'type'     => 'image_select',
                'title'    => esc_html__('Footer Layout', 'listingpro'), 
                'subtitle' => esc_html__('Select Footer layout', 'listingpro'),
                'options'  => array(
                    'footer1'      => array(
                        'alt'   => 'footer 1',
                        'img'   => get_template_directory_uri().'/assets/images/new/fot1.png'
                    ),
                    'footer2'      => array(
                        'alt'   => 'footer 2',
                        'img'   => get_template_directory_uri().'/assets/images/new/fot2.png'
                    ),
                    'footer3'      => array(
                        'alt'   => 'footer 3',
                        'img'   => get_template_directory_uri().'/assets/images/admin/fot3.jpg'
                    ),
					// Start new footer layouts view
                    'footer4'      => array(
                        'alt'   => 'footer 4',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-4.jpg'
                    ),
                    'footer5'      => array(
                        'alt'   => 'footer 5',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-5.jpg'
                    ),
                    'footer6'      => array(
                        'alt'   => 'footer 6',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-6.jpg'
                    ),
                    'footer7'      => array(
                        'alt'   => 'footer 7',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-7.jpg'
                    ),
                    
                    'footer8'      => array(
                        'alt'   => 'footer 8',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-9.jpg'
                    ),
                    'footer9'      => array(
                        'alt'   => 'footer 9',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-10.jpg'
                    ),
                    'footer10'      => array(
                        'alt'   => 'footer 10',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-11.jpg'
                    ),
                    'footer11'      => array(
                        'alt'   => 'footer 11',
                        'img'   => get_template_directory_uri().'/assets/images/admin/footer-12.jpg'
                    ),
                    // End new footer layouts view

                    
                ),
                'default' => 'footer1'
            ),
			array(
					'id'       => 'footer_layout',
					'type'     => 'select',
					'title'    => __('Select  footer widget layout', 'constructive'), 
					'subtitle' => __('Select  footer widget layout', 'constructive'),
					'desc'     => __('Select  footer widget layout', 'constructive'),
					
					'options'  => array(
						'12' => '1 columns',
						'6-6' => '2 columns',
						'4-4-4' => '3 columns',
						'3-3-3-3' => '4 columns',
                        '2-2-2-2-2-2' => '6 columns',
					),
					'default'  => '3-3-3-3',
					/* 'required' => array( 'footer_style', '=', 'footer2' ), */
					'required' => array( 'footer_style', '=', array('footer2','footer4', 'footer5','footer7','footer8','footer10','footer11') ),
			),
            array(
                'id'       => 'footer_top_bgcolor',
                'type'     => 'color',
                'title'    => __('Footer top area bgcolor', 'listingpro'),
                'subtitle' => __('(default: #363f48).', 'listingpro'),
                'default'  => '#363f48',
                'validate' => 'color',
                'required' => array( 'footer_style', '=', array('footer1','footer2', 'footer4', 'footer5', 'footer7', 'footer8','footer10', 'footer11') ),
            ),
            array(
                'id'       => 'footer_bgcolor',
                'type'     => 'color',
                'title'    => __('Footer bottom area bgcolor', 'listingpro'),
                'subtitle' => __('(default: #45505b).', 'listingpro'),
                'default'  => '#45505b',
                'validate' => 'color',
                'required' => array( 'footer_style', '=', array('footer1','footer3', 'footer4', 'footer5', 'footer6', 'footer7','footer8','footer9','footer10') ),
            ),
            array(
                'id'       => 'footer_top_color_switch',
                'type'     => 'switch',
                'title'    => esc_html__('Footer Top Text Color ON/OFF', 'listingpro'),
                'subtitle' => esc_html__('', 'listingpro'),
                'default'  => false,
                'required' => array( 'footer_style', '=', array('footer1','footer2', 'footer4', 'footer5', 'footer7','footer8','footer10', 'footer11') ),
            ),
            array(
                'id'       => 'footer_top_text_color',
                'type'     => 'color',
                'title'    => __('Footer top area text color', 'listingpro'),
                'subtitle' => __('(default: #363f48).', 'listingpro'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'required' => array('footer_top_color_switch','equals','1'),
            ),
            array(
                'id'       => 'footer_bottom_color_switch',
                'type'     => 'switch',
                'title'    => esc_html__('Footer Bottom Text Color ON/OFF', 'listingpro'),
                'subtitle' => esc_html__('', 'listingpro'),
                'default'  => false,
                'required' => array( 'footer_style', '=', array('footer1','footer3', 'footer4', 'footer5', 'footer6', 'footer7','footer8','footer9','footer10') ),
            ),
            array(
                'id'       => 'footer_bottom_text_color',
                'type'     => 'color',
                'title'    => __('Footer bottom area text color', 'listingpro'),
                'subtitle' => __('(default: #45505b).', 'listingpro'),
                'default'  => '#45505b',
                'validate' => 'color',
                'required' => array('footer_bottom_color_switch','equals','1'),
            ),
			array(
				'id'=>'fb',
				'type' => 'text',
				'title' => __("Facebook URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'tw',
				'type' => 'text',
				'title' => __("Twitter URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'gog',
				'type' => 'text',
				'title' => __("Google URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'insta',
				'type' => 'text',
				'title' => __("Instagram URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'tumb',
				'type' => 'text',
				'title' => __("Tumbler URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'f-yout',
				'type' => 'text',
				'title' => __("Youtube URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'f-linked',
				'type' => 'text',
				'title' => __("LinkedIn URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'f-pintereset',
				'type' => 'text',
				'title' => __("Pinterest URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'f-vk',
				'type' => 'text',
				'title' => __("VK URL", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '#',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'copy_right',
				'type' => 'text',
				'title' => __("Copy right information", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => 'Copyright © 2017 Listingpro'
			),
			array(
				'id'       => 'footer_logo',
				'type'     => 'media',
				'url'      => true,
				'title'    => __( 'Footer Logo', 'listingpro' ),
				'compiler' => 'true',
				//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'     => __( 'Upload your logo here', 'listingpro' ),
				'default'  => array( 'url' => get_template_directory_uri().'/assets/images/logo2.png' ),
				'required' => array( 'footer_style', 'equals', array('footer3','footer4','footer10','footer6','footer7','footer9','footer8')),

			),
			array(
				'id'=>'footer_address',
				'type' => 'text',
				'title' => __("Address", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '45 B Road NY. USA',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'phone_number',
				'type' => 'text',
				'title' => __("Phone", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => '007-123-456',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
				'id'=>'author_info',
				'type' => 'text',
				'title' => __("Theme Author Information", 'listingpro'),
				'subtitle' => __('', 'listingpro'),
				'default' => 'Proudly Listingpro by <a href="http://www.cridio.com/" target="_blank">Cridio Studio</a>',
				'required' => array( 'footer_style', '!=', 'footer3' ),
			),
			array(
               'id'=>'about_heading',
               'type' => 'text',
               'title' => __("Footer Aboutus Heading", 'listingpro'),
               'subtitle' => __('', 'listingpro'),
               'default' => 'About Us',
               'required' => array( 'footer_style', '=', 'footer10' ),
           ),

           array(
               'id'=>'about_description',
               'type' => 'text',
               'title' => __("Footer Aboutus Description", 'listingpro'),
               'subtitle' => __('', 'listingpro'),
               'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eleifend urna eu sem commodo euismod. Nam nec mauris et magna scelerisque vulputate id a lorem. In neque erat, interdum sed neque in, gravida scelerisque tellus',
               'required' => array( 'footer_style', '=', 'footer10' ),
           ),

           array(
               'id'=>'footer_contact_us',
               'type' => 'text',
               'title' => __("Footer Go To Page Text", 'listingpro'),
               'subtitle' => __('', 'listingpro'),
               'default' => 'Contact Us',
               'required' => array( 'footer_style', '=', 'footer10' ),
           ),

           array(
               'id'=>'footer_contact_us_url',
               'type' => 'text',
               'title' => __("Footer Go To Page Url", 'listingpro'),
               'subtitle' => __('', 'listingpro'),
               'default' => 'Enter Page Url',
               'required' => array( 'footer_style', '=', 'footer10' ),
           ),
				

			)
		) );
		
		/*  */
		


    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'listingpro' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'listingpro' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'listingpro' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

