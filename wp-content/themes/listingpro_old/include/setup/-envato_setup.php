<?php
/**
 * Envato Theme Setup Wizard Class
 *
 * Takes new users through some basic steps to setup their theme.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Envato_Theme_Setup_Wizard' ) ) {
	
	class Envato_Theme_Setup_Wizard {

		
		protected $version = '1.3.0';

		protected $theme_name = '';

		protected $envato_username = '';

	
		protected $oauth_script = '';

		
		protected $step = '';

		protected $steps = array();

		
		protected $plugin_path = '';

		
		protected $plugin_url = '';

		
		protected $page_slug;

		
		protected $tgmpa_instance;

		
		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		
		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

		
		protected $page_parent;

		
		protected $page_url;

		
		public $site_styles = array();

		
		private static $instance = null;

		
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		
		public function __construct() {
			$this->init_globals();
			$this->init_actions();
		}

		
		
		
		public function init_globals() {
			$current_theme         = wp_get_theme();
			$this->page_slug       = apply_filters( $this->theme_name . '_theme_setup_wizard_page_slug', $this->theme_name . '-setup' );
			$this->parent_slug     = apply_filters( $this->theme_name . '_theme_setup_wizard_parent_slug', '' );

			// create an images/styleX/ folder for each style here.
			$this->site_styles = array(
                'style1' => 'Style 1',
                'style2' => 'Style 2',
                'style3' => 'Style 3',
            );

			//If we have parent slug - set correct url
			if ( $this->parent_slug !== '' ) {
				$this->page_url = 'admin.php?page=' . $this->page_slug;
			} else {
				$this->page_url = 'themes.php?page=' . $this->page_slug;
			}
			$this->page_url = apply_filters( $this->theme_name . '_theme_setup_wizard_page_url', $this->page_url );

			//set relative plugin path url
			$this->plugin_path = trailingslashit( $this->cleanFilePath( dirname( __FILE__ ) ) );
			$relative_url      = str_replace( $this->cleanFilePath( get_template_directory() ), '', $this->plugin_path );
			$this->plugin_url  = trailingslashit( get_template_directory_uri() . $relative_url );
		}

		
		
		
		
		public function init_actions() {
			if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' ) ) {
				add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );

				if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
					add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
					add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
				}

				add_action( 'admin_menu', array( $this, 'admin_menus' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
				add_action( 'admin_init', array( $this, 'init_wizard_steps' ), 30 );
				add_action( 'admin_init', array( $this, 'setup_wizard' ), 30 );
				add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
				add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
				add_action( 'wp_ajax_envato_setup_content', array( $this, 'ajax_content' ) );
				/* by zaheer */
				add_action( 'wp_ajax_setup_content', array( $this, 'setup_content' ) );
				add_action( 'wp_ajax_listingpro_menu', array( $this, 'listingpro_menu' ) );
				add_action( 'wp_ajax_listingpro_homepage', array( $this, 'listingpro_homepage' ) );
				add_action( 'wp_ajax_listingpro_theme_options', array( $this, 'listingpro_theme_options' ) );
				add_action( 'wp_ajax_listingpro_save_logo', array( $this, 'listingpro_save_logo' ) );
			}
			
			add_action( 'upgrader_post_install', array( $this, 'upgrader_post_install' ), 10, 2 );
		}

		/**
		 * After a theme update we clear the setup_complete option. This prompts the user to visit the update page again.
		 */
		public function upgrader_post_install( $return, $theme ) {
			if ( is_wp_error( $return ) ) {
				return $return;
			}
			if ( $theme != get_stylesheet() ) {
				return $return;
			}
			update_option( 'envato_setup_complete', false );

			return $return;
		}

		/**
		 * We determine if the user already has theme content installed. This can happen if swapping from a previous theme or updated the current theme. We change the UI a bit when updating / swapping to a new theme.
		 *
		*/
		public function is_possible_upgrade() {
			return false;
		}

		public function enqueue_scripts() {
		}

		public function tgmpa_load( $status ) {
			return is_admin() || current_user_can( 'install_themes' );
		}

		public function switch_theme() {
			set_transient( '_' . $this->theme_name . '_activation_redirect', 1 );
		}

		public function admin_redirects() {
			if ( ! get_transient( '_' . $this->theme_name . '_activation_redirect' ) || get_option( 'envato_setup_complete', false ) ) {
				return;
			}
			delete_transient( '_' . $this->theme_name . '_activation_redirect' );
			wp_redirect( admin_url( $this->page_url ) );
			exit();
		}

		public function get_default_theme_style() {
			return 'style1';
		}

		/**
		 * Get configured TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		/**
		 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

			$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );

		}

		/**
		 * Add admin menus/screens.
		 */
		public function admin_menus() {

			if ( $this->is_submenu_page() ) {
				//prevent Theme Check warning about "themes should use add_theme_page for adding admin pages"
				$add_subpage_function = 'add_submenu' . '_page';
				$add_subpage_function( $this->parent_slug, esc_html__( 'Setup Wizard', 'listingpro' ), esc_html__( 'Setup Wizard', 'listingpro' ), 'manage_options', $this->page_slug, array(
					$this,
					'setup_wizard',
				) );
			} else {
				add_theme_page( esc_html__( 'Setup Wizard', 'listingpro' ), esc_html__( 'Setup Wizard', 'listingpro' ), 'manage_options', $this->page_slug, array(
					$this,
					'setup_wizard',
				) );
			}

		}


		/**
		 * Setup steps.
		 *
		 * @since 1.1.1
		 * @access public
		 * @return array
		 */
		public function init_wizard_steps() {

			$this->steps = array(
				'introduction' => array(
					'name'    => esc_html__( 'Introduction', 'listingpro' ),
					'view'    => array( $this, 'envato_setup_introduction' ),
					'handler' => array( $this, '' ),
				),
			);
			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				$this->steps['default_plugins'] = array(
					'name'    => esc_html__( 'Plugins', 'listingpro' ),
					'view'    => array( $this, 'envato_setup_default_plugins' ),
					'handler' => '',
				);
			}			

			if( count($this->site_styles) > 1 ) {
				$this->steps['style'] = array(
					'name'    => esc_html__( 'Demos', 'listingpro' ),
					'view'    => array( $this, 'envato_setup_color_style' ),
					'handler' => array( $this, 'envato_setup_color_style_save' ),
				);
			}
			$this->steps['default_content'] = array(
				'name'    => esc_html__( 'Content' , 'listingpro'),
				'view'    => array( $this, 'envato_setup_default_content' ),
				'handler' => '',
			);			
			$this->steps['next_steps']      = array(
				'name'    => esc_html__( 'Ready!', 'listingpro' ),
				'view'    => array( $this, 'envato_setup_ready' ),
				'handler' => '',
			);

			$this->steps = apply_filters( $this->theme_name . '_theme_setup_wizard_steps', $this->steps );

		}

		/**
		 * Show the setup wizard
		 */
		public function setup_wizard() {
			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			wp_register_script( 'jquery-blockui', $this->plugin_url . 'js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
			
			wp_register_script( 'envato-setup', $this->plugin_url . 'js/envato-setup.js', array(
				'jquery',
				'jquery-blockui',
			), $this->version );
			wp_localize_script( 'envato-setup', 'envato_setup_params', array(
				'tgm_plugin_nonce' => array(
					'update'  => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url'     => admin_url( $this->tgmpa_url ),
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'wpnonce'          => wp_create_nonce( 'envato_setup_nonce' ),
				'verify_text'      => esc_html__( '...verifying' , 'listingpro'),
			) );

			//wp_enqueue_style( 'envato_wizard_admin_styles', $this->plugin_url . '/css/admin.css', array(), $this->version );
			wp_enqueue_style( 'envato-setup', $this->plugin_url . 'css/envato-setup.css', array(
				'wp-admin',
				'dashicons',
				'install',
			), $this->version );
			
			//enqueue style for admin notices
			wp_enqueue_style( 'wp-admin' );

			wp_enqueue_media();
			wp_enqueue_script( 'media' );

			ob_start();
			$this->setup_wizard_header();
			$this->setup_wizard_steps();
			$show_content = true;
			echo '<div class="envato-setup-content">';
			if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
				$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
			}
			if ( $show_content ) {
				$this->setup_wizard_content();
			}
			echo '</div>';
			$this->setup_wizard_footer();
			exit;
		}

		public function get_step_link( $step ) {
			return add_query_arg( 'step', $step, admin_url( 'admin.php?page=' . $this->page_slug ) );
		}

		public function get_next_step_link() {
			$keys = array_keys( $this->steps );

			return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
		}

		/**
		 * Setup Wizard Header
		 */
	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<?php
			// avoid theme check issues.
			echo '<t';
			echo 'itle>' . esc_html__( 'Listingpro &rsaquo; Setup Wizard', 'listingpro' ) . '</ti' . 'tle>'; ?>
			<?php wp_print_scripts( 'envato-setup' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_print_scripts' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="envato-setup wp-core-ui">
		<h1 id="wc-logo">
			<a href="http://themeforest.net/user/cridiostudio/portfolio" target="_blank">				
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/cs-logo.png" alt="Cridio Studio" />
			</a>
		</h1>
		<?php
		}

		/**
		 * Setup Wizard Footer
		 */
		public function setup_wizard_footer() {
			?>
			<?php if ( 'next_steps' === $this->step ) : ?>
				<a class="wc-return-to-dashboard"
				   href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'listingpro' ); ?></a>
			<?php endif; ?>
			</body>
			<?php
			@do_action( 'admin_footer' ); // this was spitting out some errors in some admin templates. quick @ fix until I have time to find out what's causing errors.
			do_action( 'admin_print_footer_scripts' );
			?>
			</html>
			<?php
		}

		/**
		 * Output the steps
		 */
		public function setup_wizard_steps() {
			$ouput_steps = $this->steps;
			array_shift( $ouput_steps );
			?>
			<ol class="envato-setup-steps">
				<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
					<li class="<?php
					$show_link = false;
					if ( $step_key === $this->step ) {
						echo 'active';
					} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
						echo 'done';
						$show_link = true;
					}
					?>"><?php
						if ( $show_link ) {
							?>
							<a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a>
							<?php
						} else {
							echo esc_html( $step['name'] );
						}
						?></li>
				<?php endforeach; ?>
			</ol>
			<?php
		}

		/**
		 * Output the content for the current step
		 */
		public function setup_wizard_content() {
			isset( $this->steps[ $this->step ] ) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
		}

		/**
		 * Introduction step
		 */
		public function envato_setup_introduction() {

			if ( $this->is_possible_upgrade() ) {
				?>
				<h1><?php printf( esc_html__( 'Welcome to the Easy Setup Assistant! for %s.', 'listingpro' ), wp_get_theme() ); ?></h1>
				<p><?php esc_html_e( 'It looks like you may have recently upgraded to this theme. Great! This setup wizard will help ensure all the default settings are correct. It will also show some information about your new website and support options.', 'listingpro' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'listingpro' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Not right now', 'listingpro' ); ?></a>
				</p>
				<?php
			} else if ( get_option( 'envato_setup_complete', false ) ) {
				?>
				
				<div class="envato-setup-first-step-container envato-setup-first-step-containerwelcome">
					
					<h1><?php printf( esc_html__( 'Welcome to the Easy Setup Assistant! for %s.', 'listingpro' ), wp_get_theme() ); ?></h1>
					<p><?php printf( esc_html__( 'It looks like you have already run the setup wizard.', 'listingpro' ), wp_get_theme() ); ?></p>
				</div>
				<img style="width:100%;"src="<?php echo get_template_directory_uri().'/assets/images/setup/setup1.jpg' ?>" />
				
				
				
				<p class="envato-setup-actions step">
					
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Cancel', 'listingpro' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					class="button-primary button button-next button-large"><?php esc_html_e( 'Run Setup Wizard Again', 'listingpro' ); ?></a>   
				</p>
				<?php
			} else {
				?>
				
				<div class="envato-setup-first-step-container">
					<h1><?php printf( esc_html__( 'Easy Setup! Click! Click! Click!', 'listingpro' ), wp_get_theme() ); ?></h1>
					<p><?php printf( esc_html__( 'This wizard will help you kickstart with all the necessary tools. ', 'listingpro' ), wp_get_theme() ); ?></p>
				</div>
				<img style="width:100%;"src="<?php echo get_template_directory_uri().'/assets/images/setup/setup1.jpg' ?>"/>
				<h1 class="firs-step-h1"><?php printf( esc_html__( 'Ready to begin the setup?', 'listingpro' ), wp_get_theme() ); ?></h1>
				
				<p class="envato-setup-actions step text-center">
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Not! maybe later', 'listingpro' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button-primary button button-large button-next"><?php esc_html_e( 'yes! i am ready.', 'listingpro' ); ?></a>
					
				</p>
				<?php
			}
		}

		public function filter_options( $options ) {
			return $options;
		}




		private function _get_plugins() {
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}

			return $plugins;
		}

		/**
		 * Page setup
		 */
		public function envato_setup_default_plugins() {

			tgmpa_load_bulk_installer();
			// install plugins with TGM.
			if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
				die( 'Failed to find TGM' );
			}
			$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
			$plugins = $this->_get_plugins();

			// copied from TGM

			$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
			$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
				return true; // Stop the normal page form from displaying, credential request form will be shown.
			}

			// Now we have some credentials, setup WP_Filesystem.
			if ( ! WP_Filesystem( $creds ) ) {
				// Our credentials were no good, ask the user for them again.
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

				return true;
			}

			/* If we arrive here, we have the filesystem */

			?>
			
			<div class="envato-setup-first-step-container envato-setup-first-step-containerwelcome plugins-container-heading">
					
				<h1><?php printf( esc_html__( "Unpack completed!", 'listingpro' ), wp_get_theme() ); ?></h1>
				
			</div>
			<form method="post" class="plugins-container">

				<?php
				$plugins = $this->_get_plugins();
				if ( count( $plugins['all'] ) ) {
					?>
						<img style="width:100%;"src="<?php echo get_template_directory_uri().'/assets/images/setup/setup2.jpg' ?>" />
					
				<div class="plugins-container-inner">
					
						<ul class="envato-wizard-plugins">
							<?php foreach ( $plugins['all'] as $slug => $plugin ) { ?>
								<li data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $plugin['name'] ); ?>
									<span>
										<?php
										$keys = array();
										if ( isset( $plugins['install'][ $slug ] ) ) {
											$keys[] = 'Installation';
										}
										if ( isset( $plugins['update'][ $slug ] ) ) {
											$keys[] = 'Update';
										}
										if ( isset( $plugins['activate'][ $slug ] ) ) {
											$keys[] = 'Activation';
										}
										echo implode( ' and ', $keys ) . ' required';
										?>
									</span>
									<div class="spinner"></div>
								</li>
							<?php } ?>
						</ul>
						<?php
					} else {
						echo '<div class="sss">';
						echo '<img style="width:100%;"src="'.get_template_directory_uri().'/assets/images/setup/setup2.jpg">';	
						echo '<h1 class="firs-step-h1">';
						printf( esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'listingpro' ) ); 
						echo '</h1>';
						echo '</div>';
					} ?>

					
					<h1 class="firs-step-h1"><?php printf( esc_html__( 'Do you want to select a pre-built demo style now?', 'listingpro' ) ); ?></h1>
				
					<p class="envato-setup-actions step">
						
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
						   class="button button-large button-next"><?php esc_html_e( 'No! maybe later', 'listingpro' ); ?></a>
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
						   class="button-primary button button-large button-next"
						   data-callback="install_plugins"><?php esc_html_e( 'Yes! i am ready.','listingpro' ); ?></a>   
						<?php wp_nonce_field( 'envato-setup' ); ?>
					</p>
				</div>
			</form>
			<?php
		}


		public function ajax_plugins() {
			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found', 'listingpro' ) ) );
			}
			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => - 1,
						'message'       => esc_html__( 'Activating Plugin', 'listingpro' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => - 1,
						'message'       => esc_html__( 'Updating Plugin', 'listingpro' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => - 1,
						'message'       => esc_html__( 'Installing Plugin' , 'listingpro'),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'listingpro' ) ) );
			}
			exit;

		}


		public function envato_setup_default_content() {
			?>
				
			
			<div class="envato-setup-first-step-container envato-setup-first-step-containerwelcome lp-step2">
					
				<h1><?php printf( esc_html__( "Let us help you jump start with dummy content.", 'listingpro' ), wp_get_theme() ); ?></h1>
				
			</div>
			<img style="width:100%;"src="<?php echo get_template_directory_uri().'/assets/images/setup/step2.jpg' ?>"/>
			<form method="post">
				<?php if ( $this->is_possible_upgrade() ) { ?>
					
				<?php } else { ?>
					
				<?php } ?>
				
				<?php
				
				 
					
					//set_demo_data( $solitaire_content );
				?>
				<div class="content-importer-response content-importer-response-outer">
					<div id="importer-response" class="clear pos-relative">
						<span class="res-text"></span>
						<img class="loadinerSearch" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
						<img class="checkImg" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/check-img.png' ?>">
					</div>
					<div id="importer-response-menu" class="clear pos-relative">
						<span class="res-text"></span>
						<img class="loadinerSearch" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
						<img class="checkImg" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/check-img.png' ?>">
					</div>
					<div id="importer-response-homepage" class="clear pos-relative">
						<span class="res-text"></span>
						<img class="loadinerSearch" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
						<img class="checkImg" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/check-img.png' ?>">
					</div>
					<div id="importer-response-themeoptions" class="clear pos-relative">
						<span class="res-text"></span>
						<img class="loadinerSearch" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
						<img class="checkImg" width="30px" src="<?php echo get_template_directory_uri().'/assets/images/check-img.png' ?>">
					</div>
					<div class="clear"></div>
				</div>
				<h1 class="firs-step-h1"><?php printf( esc_html__( 'Stay tight while we are preparing your new directory.', 'listingpro' ) ); ?></h1>
				<p class="envato-setup-actions step">
					
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button button-large button-next button-next-skip"><?php esc_html_e( 'Skip this step', 'listingpro' ); ?></a>
					<a href="#" class="listingpro-import-content button button-large"><?php esc_html_e( 'Import Content', 'listingpro' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form>
			<?php
		}
		
		public function setup_content() {

			$themeSelectedStyle = get_theme_mod('dtbwp_site_style',$this->get_default_theme_style());
			$file = get_template_directory().'/include/setup/content/'.$themeSelectedStyle.'/content.xml';
	  if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		require_once ABSPATH . 'wp-admin/includes/import.php';

		$importer_error = false;

		if ( !class_exists( 'WP_Importer' ) ) {

			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
  
			if ( file_exists( $class_wp_importer ) ){

				require_once($class_wp_importer);

			} else {

				$importer_error = true;

			}

		}

		if ( !class_exists( 'WP_Import' ) ) {

			$class_wp_import = get_template_directory().'/include/setup/importer/importer/wordpress-importer.php';

			if ( file_exists( $class_wp_import ) ) 
				require_once($class_wp_import);
			else
				$importer_error = true;

		}

		if($importer_error){
			ob_start();
			$msg = "Error on import";
			$msg = ob_get_contents();
			ob_end_clean();
			
			die($msg);

		} 
		else {
	  
				if(!is_file( $file )){

					ob_start();
					$msg = "Something went wrong";
					$msg = ob_get_contents();
					ob_end_clean();
					die($msg);

				} else {

				   $wp_import = new WP_Import();
				   $wp_import->fetch_attachments = true;
				   ob_start();
					$res=$wp_import->import( $file );
					$res = ob_get_contents();
					ob_end_clean();
					$msg = 'Content imported success';
				   die($msg);
				}

			}

		}
		
		public function listingpro_menu(){
			
				/*
					$themeSelectedStyle = get_theme_mod('dtbwp_site_style',$this->get_default_theme_style());
					$file = get_template_directory().'/include/setup/content/'.$themeSelectedStyle.'/content.xml';
				*/

				$top_bar_menu = get_term_by('name', 'Top', 'nav_menu');
				$primary_menu = get_term_by('name', 'Main', 'nav_menu');
				$footer_menu = get_term_by('name', 'Footer', 'nav_menu');
				$inner_menu = get_term_by('name', 'Inner', 'nav_menu');
				set_theme_mod( 'nav_menu_locations', array(
						'top_menu' => $top_bar_menu->term_id,
						'primary' => $primary_menu->term_id,
						'primary_inner' => $inner_menu->term_id,
						'footer_menu' => $footer_menu->term_id,
					)
				);
				die('Menu setup successfull');
		}
		
		
		public function listingpro_homepage(){

			/*
				$themeSelectedStyle = get_theme_mod('dtbwp_site_style',$this->get_default_theme_style());
				$file = get_template_directory().'/include/setup/content/'.$themeSelectedStyle.'/content.xml';
			*/

			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', 17 );
			update_option( 'page_for_posts', 35 );
			
			$automotiveIcon = 'data:image/png;base64,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';
			$hotelIcon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAB/klEQVRoge2YW5nCMBCFkYAEJNQBkxjYOgAnVAImOrNvrANwAAo4OEAC+9LJ9k4vQAqb//vmpZdwDs2ZpJ3NAoFAIBAIfChWsDECWMFtypVp3NSbYGx9CxxQScWIYVyt4EYpoic/+NFQikifTOWkuvSgaxCNeoMRT/xvI+YbX1lr3hvBXhtDpS0yrnqNFWwMY/nIMQYboRTR2HXFCPCIMcrdtJcRJ4DPF8vYEiMmAdEO87p/iXaYk4CIEVvG1vL54gSNHKPcansZeURunjVGMKJQisgwllawKYS3JcD3Qq3B1nB3ycMgIyp4TGAHhlwNDjdCjFXtD/D5YhgHK0isICEBueqxT6MUUf5eHc8wDoUmkStirDobIQEV2mW+2zR0mmdAO8zrup8RIDPebiR3w4kY8auE34MYsRGcyjorF5YuSF4vtRvZFKw3QjvMcyfXfiR2xwrWLgr56a5vh0bw41FfL7KGU5w97u1QsPCmrCckWOh6pAdIw+1ZW280/CSgv/Awtr6F9SX3wSRxc21KrbYrxIhdtp0RAfkW1hcXC8bhrT4DlSl8FmpcId8Ep//VO9pn1ecZ8T1FhhKMTI27RogRG8bR99zXMoxj3aLdakRXzClW2UyrkdyTSB40A0Zjsz2hYRxLx5uNTDU3rVqDEQ90MlJXvgQ30ar1U4z8AqzZRBgg+pcOAAAAAElFTkSuQmCC';
			$realestateIcon = 'data:image/png;base64,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';
			$restaurantIcon = 'data:image/png;base64,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';
			$servicesIcon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAEgUlEQVRoge1Z3ZXyOAxNCZRACXTwyW5g6WDSwUwHpAPogHnB4i10AB0MFeTSAXTA9xDLURzDwmRIds8ZnZOHxI6ja+vnSsmyX/mVLMuyjBhkGWvLKOIxy8itw5IY0+E1e0CoxMQyFoYBy7haxtU4nLXCxJgah7OMW4eSGDSe1jekUbA6GcbRMq6GsQ/jDqWMh7mMK5WYjKl3R4zDwTKuxKD6hKqL3/mldVjWilcXYky9+V0N4zi23h2xDiuv+Ie//9A73xpjFB7I56hKU4lJ7LACRCtnGQUxiBgkILIsywxjp4GNJpaRe6XhbX+hdn31b++LGRqHs9niH9ri3TqUfr3hwOnopK9nTMUwPm+sgReq3og4qnXViTaYWUZuGJ/xSRCDDGOvFNzH4dYwjoZx9GaZS4CgDWYvByL2bRj7W6FTnPnGVaTeoRITAT5IECCHueyccTiTw7w1LifG1cU6fFCJCZWY1FHM73h0MuQwj8y1eDmQLAu7twtJTSkmjpxyWgnJxuEQP5O8MohZxSIZXAO5l7GJMZVxNT8fzJxuiXH46gukNtXHwvaPC20w0xHpadNi7MKzdmBYD8a9WsmPq8stZzcOZ9riXZydtnhPAffMOYDxAeTt5UBCVmbsfjT8MqbCjPWJvUyCczp8GYc/lrGwDmVsSsSgYGY+UiUS4t46lLTFuzdXpMLzd5RM7WTRnecpevfKn/jWOrmGq069QGSZclTNfVTMD/M8TzIOB+uwChT+QUYr0U6SZk1xQsGVP6ywZeSxk+oP0AYzz6OuxuErnucduvVBBaZQ6/2RtXSiC/mnGyimD0ctsXG/e8toLE5WrXuv8DJlSqFC9MqlCisBE5jvdyl7C0RjOl/k8KYIWyg/VRTZk8NbYxJKOe+YOhHqRoNxOMQ1fK9sHjKoX4A2mMWNAG+zIcPWzh85tqfvyk/OEV/aC2AJozVpDN9aq017vvao6YFnn/74PfkTR8tvvWsZue+OfIoN643xpeyqDbq6aHvX8/WGPg0ky1rs89yHClCJSehRKTv3WTq3rjrdCCYH66qT0Pvvfr9ZrFag/PYaYhqJ0DyYBIdPJJ64PE11A3XPKrXrg4g3CYk8uR57hh/ZMfpStu7J7lt9V64uek5TntY277uBUw0uwVhbIdyf5OKVQDqUI05Ed2uIZvdbjLSmJnH4bifPlwC518rXySweS1V1nTmezvz/gTwwp7ckktC+Y1pNR6RIvJ82LUbRinADAClqH2iybkwNWs7OWChnX6gTpTA/cnbrqpP3s+JlQFoK15Sk08IRwE+EX6kSD6P9qFFKJOsM3XgzjF0qIYaSdKyEmGWKXvQo8OVU+9CcXhLMx1WnXqRRMel7rPkloh1aKjXfXC4NA/d6Sb7wglUNNGWi53uh/cfFtqvDNTnM27SlKZLCOw6rzhwGfAIMXZDBfcWmS92DrX/WHOVe5otTx3OiKx8URBdM3YqR55IbjMNZzU01H1ajgxAhh3nKrjVVUT3cQ+r90UHck1SDbpR2f19J/mkd+1/4r/zH5C8H9jxzeXwHHgAAAABJRU5ErkJggg==';
			
			
			
			update_term_meta( 14, 'lp_category_image', $automotiveIcon );
			update_term_meta( 23, 'lp_category_image', $hotelIcon );
			update_term_meta( 27, 'lp_category_image', $realestateIcon );
			update_term_meta( 29, 'lp_category_image', $restaurantIcon );
			update_term_meta( 31, 'lp_category_image', $servicesIcon );



			
			
			
			die('Home page setup seccessfully');
		}
		
		public function listingpro_theme_options() {
			
			$themeSelectedStyle = get_theme_mod('dtbwp_site_style',$this->get_default_theme_style());
			$file = get_template_directory().'/include/setup/content/'.$themeSelectedStyle.'/themeOptions.json';
			$data = file_get_contents( $file );
			$data = json_decode( $data, true );
            
			$theme_option_name       =  'listingpro_options';
			 
			if ( is_array( $data ) && !empty( $data ) ) {
			  $data = apply_filters( 'solitaire_theme_import_theme_options', $data );
			  update_option($theme_option_name, $data);
			  die('Theme Options imported');
			} else {
				die('Error in theme option');
			}

		}
		
		
		public $logs = array();

		public function log( $message ) {
			$this->logs[] = $message;
		}

		public $errors = array();

		public function error( $message ) {
			$this->logs[] = 'ERROR!!!! ' . $message;
		}


		/* for demo styles */
		public function envato_setup_color_style() {

			?>
			
			<div class="envato-setup-first-step-container envato-setup-first-step-containerwelcome plugins-container-heading">
					
				<h1><?php printf( esc_html__( "Which Pre-Built Demo Style You Like?", 'listingpro' ), wp_get_theme() ); ?></h1>
				
			</div>
			<img style="width:100%;"src="<?php echo get_template_directory_uri().'/assets/images/setup/setup3.jpg' ?>"/>
           
            <form method="post" class="lp-demo-content-import-container">
                <div class="plugins-container-inner">
					
					
					<div class="theme-presets lp-select-demo-outer">
						<ul>
							<?php
							$current_style = get_theme_mod( 'dtbwp_site_style', $this->get_default_theme_style() );
							$stylecls = '';
							foreach ( $this->site_styles as $style_name => $style_data ) {
								?>
								<li class="lp-imp-demo">
									
									<div class="">
										<div class="lp-select-demo">
											<div class="lp-select-demo-image">
												<a href="#" data-style="<?php echo esc_attr( $style_name ); ?>"></a>
												<img style="width:100%;" src="<?php echo get_template_directory_uri().'/include/setup/content/demos/'.$style_name.'/style.jpeg' ?>"/>
												<?php if('style1' == $style_name){ 
													$stylecls = 'opacity:1;visibility:visible';			
												}else{
													$stylecls = '';
												} ?>
												<div class="lp-select-demo-image-overlay" style="<?php echo $stylecls; ?>"></div>
												<div class="lp-select-demo-image-overlay-link"  style="<?php echo $stylecls; ?>">
												
													<a href="" class="lp_current_demo"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAVnSURBVHhe7ZxbiFVVHMZnHPOCSjWZSUYQYgkiBYUEXSQMKShECpIuYkj1EGEPItVDYATRDXyQCAp8qCiKoAbqoSKipIcKghQiiyi6iFgkFmmmM/3+Z38HZppZe6+5rJk54/eDj4XnfN/ee31H5pyz99qnyxhjjDHGGGOMMcYYY4wxxhjTQQwMDHSje/v7+/eiA6gPXaenzWRD+Xt4QYbAY6cYtshiJguKv7N6CYbDc0fRIllNaSh7CfpN/Y8Iz98kuykNZb+h3pPg2SC7KQlFb1TnSfAcR+cpYkpByb3ooHpPgudpRUxJKHrYp6r/g+c7tEARUwpKvkGdJ8ETrFXElIKSF6Ef1XsSPM8rYkpC0c+p8yTxgsULp4gpBSWvRf3qPQmWGxUxpaDk+ehbdZ4Ezx5FTEko+ll1ngTPQdSriCkFJa9BJ9V7EjwbFTGloOS5aL86r+N1RUxJeDF2qvAkeA6jJYqYUlDypeiEek+C5w5FTCnoeTb6otV4DbwYfYqYktD1Q1XltRzhBVmmiCkFRa+k6GNV52nwbFXElIKeZ1H03qryNHjeZ+hWzJSCordVlafB8ye6SBFTiig5ylbvSfA8oIgpBT13U/QHVeVp8HzCMEsxUwqK3lpVngbPMXSxIqYUlLyMvo9UtafBt0MRUxKK7lPnSfB8ztCjiCkFRd9eVZ4Gzz9otSKmFJQcqw4Pq/ckeB5VxJSEol9T50nwfMUwRxFTCorOWXX4L8PliphSUPLZlP1Lq/Ua8DypiCkJReesOvyaYZ4iphQUvR7VLuXh6bjR5mpFTCkoeSFl56w63KWIKQlF71bnSfB8z7BQkc6Cg9+M9qFT6Gf0OJOZlh8RObZrUNOfqmCdIp0FB75d8xgCj8fZ0MWyTQs4plh1eKA6wjR4XlCks+DYz+Lgj1fTGE5MHq2QfcrhWJ7SoSXB8xPDmYp0Fhx8zv0RcUpiyj+pcBy5qw4798ZMjv/6ahr1MMm4frBJsUmHQ5jD/uPURy14XlKkM2ECcdPKH5pPLfiChxWdVNhvzqrDQ+gcRToXJnEXii9QWeB9keEMxYvD/lajnFWHtyrS+TCZ21Dj+qU2eN9jKP7GyT56UM6qwzcVmTkwqatQ4zWFNnj3MVyoeBHYx45qb2nw/M6wVJGZBZNbgRo/57fB+ytDkdPabPsSlLPqcLMiMxPmuJhJNq74a4P3L3Sz4hMCm41Vh/HFtBY87yoys2Gu85hs41W4NnhPoglbdBbb0qaT4Ilf57lAkZkPc44FZ09U088D/y6Gca3oYBu5qw7vU+T0gonfg+ISaBZ430Jj+hkK4vGfID7B1YLnQ4bTd4E0BcTFoKNVHc3g/Yxh1J98yOWsOoz3rOWKnL5QQnxBixN3WeD9Aa1SvBG856PGswZ4tiliVNqX6iaHuDMp67oEvpxVh58yeNXhYCgkLp++02ooA7wn0N2KjwjPb5I9CZ74TrJSETMYiumhoMYfbxkM/rgKOeyNmMfPRTmrDh9RxKSgpO1oNCcmX0FzFW/Bv1/V03XE+azZipg6KPQW9HfVWzN4P0at3xFh3KCHk+CJM72XtXZm8qC0K9GhqsJm8Mal4StQzqrDndqNGQ0UtxzFKsEs8Db+qcOzHw35E2dGAeX10uNHVZ3jg23F+bE12rQZK/E/Gr2sXscM23hGmzTjhT7jnNRjVbWjh2y8x8zX5sxEQbdbKLbxevhg8AfXahNmoqHcdfTceGdsG/y7FTWloORVKGe1eng6c4F0p0HRSyk8bkkeEZ4L1stuJgMKX4De1mswBB73vRxTAd3HickHUXySCr5B9/O4fyLJGGOMMcYYY4wxxhhjzLSkq+s/G8ELdx2zjB4AAAAASUVORK5CYII="></a>
												</div>
												
											</div>
											<div class="lp-ad-price-content text-center">
											<?php if('style1' == $style_name){ ?>
												<h5>Classic</h5>
												<p>Best Suited For Multipurpose Directory</p>
												
												<a href="https://classic.listingprowp.com/" target="_blank"><?php printf( esc_html__( 'preview', 'listingpro' ) ); ?></a>
											<?php } ?>
											<?php if('style2' == $style_name){ ?>
												<h5>PlacesPro</h5>
												<p>Best Suited For Multipurpose places Directory</p>
												
												<a href="http://placespro.listingprowp.com/" target="_blank"><?php printf( esc_html__( 'preview', 'listingpro' ) ); ?></a>
											<?php } ?>	
											<?php if('style3' == $style_name){ ?>
												<h5>Restaurantpro</h5>
												<p>Best Suited For Multipurpose restaurant Directory</p>
												
												<a href="http://restaurantpro.listingprowp.com/" target="_blank"><?php printf( esc_html__( 'preview', 'listingpro' ) ); ?></a>
											<?php } ?>	
												
											</div>
										</div>
									</div>	
								</li>
							<?php } ?>
						</ul>
					</div>
					<div class="clearfix"></div>
					<input type="hidden" name="new_style" id="new_style" value="style1">

					<p class="envato-setup-actions step">
					   
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
						   class="button button-large button-next"><?php esc_html_e( 'No, Maybe Later' ); ?></a>
						<?php wp_nonce_field( 'envato-setup' ); ?>
						 <input type="submit" class="button-primary button button-large button-next"
							   value="<?php esc_attr_e( 'Yes, i am ready. ' ); ?>" name="save_step"/>
					</p>
				</div>
            </form>
			<?php
		}

		public function envato_setup_color_style_save() {
			check_admin_referer( 'envato-setup' );

			$new_style = isset( $_POST['new_style'] ) ? $_POST['new_style'] : false;
			if ( $new_style ) {
				set_theme_mod( 'dtbwp_site_style', $new_style );
			}

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			exit;
		}


		/* end for demo styles */



		public function envato_setup_ready() {

			update_option( 'envato_setup_complete', time() );
			update_option( 'dtbwp_update_notice', strtotime('-4 days') );
			?>
			
			<img src="<?php echo get_template_directory_uri().'/assets/images/setup/setup4.jpg' ?>"/>
			
			<h1 class="firs-step-h1 lp-setip-last-step"><?php printf( esc_html__( 'Now you will be automatically redirected to WordPress dashboard...', 'listingpro' ) ); ?></h1>
			
			

			<?php
			$welcomePargeURL = admin_url().'themes.php?page=listingpro';
			header("refresh:3;url=$welcomePargeURL");
			
		}

		

		private static $_current_manage_token = false;

		
		public function ajax_notice_handler() {
			check_ajax_referer( 'dtnwp-ajax-nonce', 'security' );
			// Store it in the options table
			update_option( 'dtbwp_update_notice', time() );
		}

		
		
		private function _array_merge_recursive_distinct( $array1, $array2 ) {
			$merged = $array1;
			foreach ( $array2 as $key => &$value ) {
				if ( is_array( $value ) && isset( $merged [ $key ] ) && is_array( $merged [ $key ] ) ) {
					$merged [ $key ] = $this->_array_merge_recursive_distinct( $merged [ $key ], $value );
				} else {
					$merged [ $key ] = $value;
				}
			}

			return $merged;
		}


		public static function cleanFilePath( $path ) {
			$path = str_replace( '', '', str_replace( array( '\\', '\\\\', '//' ), '/', $path ) );
			if ( $path[ strlen( $path ) - 1 ] === '/' ) {
				$path = rtrim( $path, '/' );
			}

			return $path;
		}

		public function is_submenu_page() {
			return ( $this->parent_slug == '' ) ? false : true;
		}
	}

}// if !class_exists

/**
 * Loads the main instance of Envato_Theme_Setup_Wizard to have
 * ability extend class functionality
 *
 * @since 1.1.1
 * @return object Envato_Theme_Setup_Wizard
 */
add_action( 'after_setup_theme', 'envato_theme_setup_wizard', 10 );
if ( ! function_exists( 'envato_theme_setup_wizard' ) ) :
	function envato_theme_setup_wizard() {
		Envato_Theme_Setup_Wizard::get_instance();
	}
endif;
