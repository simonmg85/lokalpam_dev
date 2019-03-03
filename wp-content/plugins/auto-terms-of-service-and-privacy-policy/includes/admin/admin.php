<?php

namespace wpautoterms\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use wpautoterms\admin\action\Recheck_License;
use wpautoterms\admin\action\Set_Option;
use wpautoterms\admin\form\Legal_Page;
use wpautoterms\api\License;
use wpautoterms\api\Query;
use wpautoterms\Countries;
use wpautoterms\cpt\Admin_Columns;
use wpautoterms\admin\page\Legacy_Settings;
use wpautoterms\Wpautoterms;

define( 'WPAUTOTERMS_API_KEY_HEADER', 'X-WpAutoTerms-ApiKey' );

// TODO: refactor, extract classes with less responsibilities
abstract class Admin {
	/**
	 * @var  License
	 */
	protected static $_license;
	/**
	 * @var Query
	 */
	protected static $_query;
	/**
	 * @var Set_Option
	 */
	protected static $_warning_action;

	public static function init( License $license, Query $query ) {
		static::$_license = $license;
		static::$_query = $query;
		add_action( 'init', array( __CLASS__, 'action_init' ) );
	}

	public static function upgrade_from_tos_pp() {
		$options = get_option( Menu::AUTO_TOS_OPTIONS, false );
		update_option( WPAUTOTERMS_OPTION_PREFIX . Menu::LEGACY_OPTIONS, $options !== false );
		if ( $options === false ) {
			return;
		}
		$transform = array_keys( Legacy_Settings::all_options() );
		foreach ( $transform as $k ) {
			if ( isset( $options[ $k ] ) ) {
				$v = $options[ $k ];
			} else {
				$v = '';
			}
			update_option( WPAUTOTERMS_OPTION_PREFIX . $k, $v );
		}
	}

	public static function action_init() {
		if ( ! get_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED ) ) {
			flush_rewrite_rules();
			update_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED, true );
			$version = get_option( WPAUTOTERMS_OPTION_PREFIX . Menu::VERSION );
			if ( $version != WPAUTOTERMS_VERSION ) {
				static::upgrade_from_tos_pp();
				update_option( WPAUTOTERMS_OPTION_PREFIX . Menu::VERSION, WPAUTOTERMS_VERSION );
			}
		}
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'row_actions' ), 10, 2 );
		add_filter( 'get_sample_permalink_html', array( __CLASS__, 'remove_permalink' ), 10, 5 );
		add_action( 'edit_form_top', array( __CLASS__, 'edit_form_top' ) );

		$recheck_action = new Recheck_License( 'manage_options', null, '', null, __( 'Access denied', WPAUTOTERMS_SLUG ) );
		$recheck_action->set_license_query( static::$_license );

		// TODO: extract warnings class
		static::$_warning_action = new Set_Option( 'manage_options', null, 'settings_warning_disable' );
		static::$_warning_action->set_option_name( 'settings_warning_disable' );

		Admin_Columns::init();
		Menu::init( static::$_license, static::$_query );
		static::$_license->check();
	}

	public static function add_meta_boxes() {
		global $post;

		if ( empty( $post ) || ( $post->post_type != WPAUTOTERMS_CPT ) ) {
			return;
		}

		remove_meta_box( 'slugdiv', $post->post_type, 'normal' );
	}

	public static function remove_permalink( $permalink, $post_id, $new_title, $new_slug, $post ) {
		if ( $post->post_type != WPAUTOTERMS_CPT ) {
			return $permalink;
		}

		return '';
	}

	public static function edit_form_top( $post ) {
		if ( $post->post_type != WPAUTOTERMS_CPT ) {
			return;
		}

		if ( $post->post_status == 'auto-draft' ) {
			$page_id = isset( $_REQUEST['page_name'] ) ? sanitize_text_field( $_REQUEST['page_name'] ) : '';
			$page = false;
			if ( $page_id !== 'custom' ) {
				if ( ! empty( $page_id ) ) {
					$page = Wpautoterms::get_legal_page( $page_id );
					if ( $page->availability() !== true ) {
						$page = false;
					}
				}
				if ( $page === false ) {
					global $wpdb;
					$cpt = WPAUTOTERMS_CPT;
					$cases = array();
					foreach ( Wpautoterms::get_legal_pages() as $page ) {
						$id = $page->id();
						$cases[] = "SUM(CASE WHEN $wpdb->posts.post_name LIKE '$id%' THEN 1 ELSE 0 END) as '$id'";
					}
					$cases = join( ',', $cases );
					$query = "SELECT $cases FROM $wpdb->posts WHERE ($wpdb->posts.post_type = '$cpt' AND $wpdb->posts.post_status<>'trash')";
					$pages_by_type = $wpdb->get_results( $query, ARRAY_A );
					$pages_by_type = $pages_by_type[0];
					\wpautoterms\print_template( 'auto-draft', compact( 'pages_by_type' ) );
				} else {
					\wpautoterms\print_template( 'auto-draft-page', compact( 'page' ) );
				}
			}
		}
	}

	public static function row_actions( $actions, $post ) {
		if ( ( WPAUTOTERMS_CPT == get_post_type( $post ) ) && ( $post->post_status == 'publish' ) ) {
			$link = get_post_permalink( $post->ID );
			$short_link = preg_replace( '/https?:\/\//i', '', trim( $link, '/' ) );
			$info = '<a href="' . $link . '">' . $short_link . '</a>';
			array_unshift( $actions, '<div class="inline-row-action-summary">' . $info . '</div>' );
		}

		return $actions;
	}

	public static function enqueue_scripts( $page ) {
		global $post;
		if ( ! empty( $post ) && ( $post->post_type == WPAUTOTERMS_CPT ) ) {
			if ( $page == 'edit.php' ) {
				wp_enqueue_script( WPAUTOTERMS_SLUG . '_row_actions', WPAUTOTERMS_PLUGIN_URL . 'js/row-actions.js',
					false, false, true );
			}
			if ( $page == 'post-new.php' && $post->post_status == 'auto-draft' ) {
				wp_enqueue_script( WPAUTOTERMS_SLUG . '_post_new', WPAUTOTERMS_PLUGIN_URL . 'js/post-new.js',
					false, false, true );
				$hidden = array();
				$dependencies = array();
				/**
				 * @var $v Legal_Page
				 */
				foreach ( Wpautoterms::get_legal_pages() as $v ) {
					$hidden[ $v->id() ] = $v->hidden();
					$dependencies[ $v->id() ] = $v->dependencies();
				}
				$page_id = isset( $_REQUEST['page_name'] ) ? sanitize_text_field( $_REQUEST['page_name'] ) : '';
				wp_localize_script( WPAUTOTERMS_SLUG . '_post_new', 'wpautotermsPostNew', array(
					'hidden' => $hidden,
					'dependencies' => $dependencies,
					'settings_warning_disable_nonce' => static::$_warning_action->nonce(),
					'page_id' => $page_id
				) );
				wp_register_style( WPAUTOTERMS_SLUG . '_post_new_css', WPAUTOTERMS_PLUGIN_URL . 'css/post-new.css', false );
				wp_enqueue_style( WPAUTOTERMS_SLUG . '_post_new_css' );
				wp_register_style( WPAUTOTERMS_SLUG . '_admin_css', WPAUTOTERMS_PLUGIN_URL . 'css/admin.css', false );
				wp_enqueue_style( WPAUTOTERMS_SLUG . '_admin_css' );
			}
		}

		$prefix = WPAUTOTERMS_SLUG . '_';
		if ( strncmp( $page, $prefix, strlen( $prefix ) ) != 0 ) {
			return;
		}
		Countries::enqueue_scripts();
		wp_enqueue_script( WPAUTOTERMS_SLUG . '_admin', WPAUTOTERMS_PLUGIN_URL . 'js/admin.js', false, false, true );
		wp_register_style( WPAUTOTERMS_SLUG . '_admin_css', WPAUTOTERMS_PLUGIN_URL . 'css/admin.css', false );
		wp_enqueue_style( WPAUTOTERMS_SLUG . '_admin_css' );
	}
}
