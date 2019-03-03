<?php

namespace wpautoterms\cpt;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPAUTOTERMS_CPT', WPAUTOTERMS_SLUG . '_page' );
define( 'WPAUTOTERMS_CAP_SINGULAR', WPAUTOTERMS_SLUG . '_page' );
define( 'WPAUTOTERMS_CAP_PLURAL', WPAUTOTERMS_SLUG . '_pages' );

abstract class CPT {

	static function init() {
		add_action( 'init', array( __CLASS__, 'add_caps' ) );
		add_filter( 'map_meta_cap', array( __CLASS__, 'map_meta_cap' ), 10, 4 );
	}

	static function get_default_caps() {
		return array(
			'administrator' => array(
				'edit_' . WPAUTOTERMS_CAP_PLURAL => true,
				'edit_others_' . WPAUTOTERMS_CAP_PLURAL => true,
				'edit_private_' . WPAUTOTERMS_CAP_PLURAL => true,
				'edit_published_' . WPAUTOTERMS_CAP_PLURAL => true,
				'read_' . WPAUTOTERMS_CAP_PLURAL => true,
				'read_private_' . WPAUTOTERMS_CAP_PLURAL => true,
				'delete_' . WPAUTOTERMS_CAP_PLURAL => true,
				'delete_others_' . WPAUTOTERMS_CAP_PLURAL => true,
				'delete_private_' . WPAUTOTERMS_CAP_PLURAL => true,
				'delete_published_' . WPAUTOTERMS_CAP_PLURAL => true,
				'publish_' . WPAUTOTERMS_CAP_PLURAL => true,
			),
			'subscriber' => array(
				'edit_' . WPAUTOTERMS_CAP_PLURAL => false,
				'edit_others_' . WPAUTOTERMS_CAP_PLURAL => false,
				'edit_private_' . WPAUTOTERMS_CAP_PLURAL => false,
				'edit_published_' . WPAUTOTERMS_CAP_PLURAL => false,
				'read_' . WPAUTOTERMS_CAP_PLURAL => true,
				'read_private_' . WPAUTOTERMS_CAP_PLURAL => false,
				'delete_' . WPAUTOTERMS_CAP_PLURAL => false,
				'delete_others_' . WPAUTOTERMS_CAP_PLURAL => false,
				'delete_private_' . WPAUTOTERMS_CAP_PLURAL => false,
				'delete_published_' . WPAUTOTERMS_CAP_PLURAL => false,
				'publish_' . WPAUTOTERMS_CAP_PLURAL => false,
			),
		);
	}

	static function register() {

		$labels = array(
			'name' => __( 'Legal Pages', WPAUTOTERMS_SLUG ),
			'all_items' => __( 'All Legal Pages', WPAUTOTERMS_SLUG ),
			'singular_name' => __( 'Legal Page', WPAUTOTERMS_SLUG ),
			'add_new' => __( 'Add Legal Pages', WPAUTOTERMS_SLUG ),
			'add_new_item' => __( 'Add Legal Page', WPAUTOTERMS_SLUG ),
			'edit' => __( 'Edit', WPAUTOTERMS_SLUG ),
			'edit_item' => __( 'Edit Legal Page', WPAUTOTERMS_SLUG ),
			'new_item' => __( 'New Legal Page', WPAUTOTERMS_SLUG ),
			'view' => __( 'View', WPAUTOTERMS_SLUG ),
			'view_item' => __( 'View Legal Page', WPAUTOTERMS_SLUG ),
			'search_items' => __( 'Search Legal Pages', WPAUTOTERMS_SLUG ),
			'not_found' => __( 'No legal pages exist.', WPAUTOTERMS_SLUG ),
			'not_found_in_trash' => __( 'No legal pages found in Trash', WPAUTOTERMS_SLUG ),
			'parent' => __( 'Parent Legal Pages', WPAUTOTERMS_SLUG ),
			'plugin_listing_table_title_cell_link' => __( 'Wpautoterms', WPAUTOTERMS_SLUG ),
			'menu_name' => __( 'WP AutoTerms', WPAUTOTERMS_SLUG ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'revisions' ),
			'public' => true,
			'show_ui' => true,
			//'show_in_nav_menus'   => false,
			'show_in_menu' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => array( 'slug' => 'wpautoterms' ),
			'map_meta_cap' => true,
			'capability_type' => array( WPAUTOTERMS_CAP_SINGULAR, WPAUTOTERMS_CAP_PLURAL ),
			'menu_icon' => WPAUTOTERMS_PLUGIN_URL . 'images/icon.png',
			'show_admin_column' => true,
		);

		register_post_type( WPAUTOTERMS_CPT, $args );
	}

	static function add_caps() {

		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles;
		}

		$default_caps = static::get_default_caps();
		foreach ( $wp_roles->role_names as $role => $label ) {

			if ( array_key_exists( $role, $default_caps ) ) {
				$caps = $default_caps[ $role ];
			} else {
				$caps = $default_caps['subscriber'];
			}

			foreach ( $caps as $cap => $grant ) {

				if ( ! isset( $wp_roles->roles[ $role ]['capabilities'][ $cap ] ) ) {
					$wp_roles->add_cap( $role, $cap, $grant );
				}

			}
		}
	}

	static function map_meta_cap( $caps, $cap, $userID, $args = null ) {

		$cpt = get_post_type_object( WPAUTOTERMS_CPT );
		if ( ! $cpt ) {
			return $caps;
		}

		/*
		switch ( $cap ) {
		case 'edit_' . static::CAP_SINGULAR:
			if ( false ) { // deny condition
				$caps[] = 'do_not_allow';
			}
			break;
		}
		*/

		return $caps;

	}

}
