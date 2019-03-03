<?php

namespace wpautoterms\admin;


use wpautoterms\admin\action\Send_Message;
use wpautoterms\admin\page\Settings_Base;
use wpautoterms\admin\page\Compliancekits;
use wpautoterms\admin\page\Legacy_Settings;
use wpautoterms\admin\page\License_Settings;
use wpautoterms\admin\page\Settings_Page;
use wpautoterms\admin\page;
use wpautoterms\api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Menu {
	const VERSION = 'version';
	const LEGACY_OPTIONS = 'legacy_options';

	const PAGE_CONTACT = 'contact';
	const PAGE_SETTINGS = 'settings';
	const PAGE_COMPLIANCE_KITS = 'compliancekits';
	const PAGE_LICENSE_SETTINGS = 'license_settings';
	const PAGE_LEGACY_SETTINGS = 'legacy_settings';

	const AUTO_TOS_OPTIONS = 'atospp_plugin_options';

	/**
	 * @var Settings_Base[]
	 */
	static protected $_pages;

	public static function font_sizes() {
		return array(
			' ' => __( 'default', WPAUTOTERMS_SLUG ),
			'12px' => __( '12px', WPAUTOTERMS_SLUG ),
			'13px' => __( '13px', WPAUTOTERMS_SLUG ),
			'14px' => __( '14px', WPAUTOTERMS_SLUG ),
			'15px' => __( '15px', WPAUTOTERMS_SLUG ),
			'16px' => __( '16px', WPAUTOTERMS_SLUG ),
		);
	}

	public static function fonts() {
		return array(
			' ' => __( 'default', WPAUTOTERMS_SLUG ),
			'Arial, sans-serif' => __( 'Arial, sans-serif', WPAUTOTERMS_SLUG ),
			'Georgia, serif' => __( 'Georgia, serif', WPAUTOTERMS_SLUG ),
		);
	}

	public static function init( api\License $license, api\Query $query ) {
		$ls = new License_Settings( static::PAGE_LICENSE_SETTINGS, __( 'License Settings', WPAUTOTERMS_SLUG ),
			__( 'License', WPAUTOTERMS_SLUG ) );
		$ls->set_license( $license );
		$contact = new page\Contact( static::PAGE_CONTACT, __( 'Contact', WPAUTOTERMS_SLUG ) );
		$sm = new Send_Message( 'manage_options', null, $contact->id(), null,
			__( 'Access denied', WPAUTOTERMS_SLUG ), true );
		$contact->action = $sm;

		static::$_pages = array(
			new Compliancekits( static::PAGE_COMPLIANCE_KITS, __( 'Compliance Kits', WPAUTOTERMS_SLUG ), $license ),
			new Settings_Page( static::PAGE_SETTINGS, __( 'Settings', WPAUTOTERMS_SLUG ) ),
			$ls,
			new Legacy_Settings( static::PAGE_LEGACY_SETTINGS, __( 'Legacy Auto TOS & PP', WPAUTOTERMS_SLUG ) ),
			$contact,
		);
		if ( ! get_option( WPAUTOTERMS_OPTION_PREFIX . 'options_activated' ) ) {
			/**
			 * @var $page page\Base
			 */
			foreach ( static::$_pages as $page ) {
				if ( $page instanceof Settings_Base ) {
					foreach ( $page->defaults() as $k => $v ) {
						add_option( WPAUTOTERMS_OPTION_PREFIX . $k, $v );
					}
				}
			}
			update_option( WPAUTOTERMS_OPTION_PREFIX . 'options_activated', true );
		}
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	public static function register_settings() {
		foreach ( static::$_pages as $page ) {
			if ( $page instanceof Settings_Base ) {
				$page->define_options();
			}
		}
	}

	public static function admin_menu() {
		foreach ( static::$_pages as $page ) {
			$page->register_menu();
		}
	}

	public static function enqueue_scripts( $page ) {
		$prefix = WPAUTOTERMS_CPT . '_page_';
		if ( 0 != strncmp( $page, $prefix, strlen( $prefix ) ) ) {
			return;
		}
		$page = substr( $page, strlen( $prefix ) );
		foreach ( static::$_pages as $p ) {
			if ( $p->id() == $page ) {
				$p->enqueue_scripts();
			}
		}
	}
}
