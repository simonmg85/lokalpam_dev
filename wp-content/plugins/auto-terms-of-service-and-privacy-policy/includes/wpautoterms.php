<?php

namespace wpautoterms;

use wpautoterms\admin\form\Legal_Page;
use wpautoterms\cpt\CPT;
use wpautoterms\frontend\Endorsements;
use wpautoterms\frontend\Links;
use wpautoterms\frontend\notice\Cookies_Notice;
use wpautoterms\frontend\notice\Update_Notice;
use wpautoterms\legal_pages;

abstract class Wpautoterms {

	protected static $_legal_pages;
	/**
	 * @var Links
	 */
	protected static $_links;

	public static function init( $license, $query ) {
		static::$_legal_pages = array();
		foreach ( legal_pages\Conf::get_legal_pages() as $page ) {
			if ( $page->is_paid ) {
				$c = '\wpautoterms\admin\form\Licensed_Legal_Page';
			} else {
				$c = '\wpautoterms\admin\form\Legal_Page';
			}
			$p = new $c( $page->id, $page->title, $page->description );
			if ( $page->is_paid ) {
				$p->set_params( $license, $query );
			}
			static::$_legal_pages[ $page->id ] = $p;
		}
		add_action( 'init', array( __CLASS__, 'action_init' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'init_translations' ), 5 );
		CPT::init();
		Shortcodes::init();
		Legacy_Shortcodes::init();
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		add_action( 'wp_head', array( __CLASS__, 'head' ), 100002 );
		add_action( 'wp_footer', array( __CLASS__, 'footer' ), 100002 );
		$a = Update_Notice::create();
		$a->init();
		$a = Cookies_Notice::create( $license );
		$a->init();
		new Endorsements( $license );
		static::$_links = new Links();
	}

	/**
	 * @return Legal_Page[]
	 */
	public static function get_legal_pages() {
		return static::$_legal_pages;
	}

	/**
	 * @param $id string
	 *
	 * @return Legal_Page|false
	 */
	public static function get_legal_page( $id ) {
		if ( ! isset( static::$_legal_pages[ $id ] ) ) {
			return false;
		}

		return static::$_legal_pages[ $id ];
	}

	public static function init_translations() {
		load_plugin_textdomain( WPAUTOTERMS_SLUG,
			false,
			WPAUTOTERMS_PLUGIN_DIR . 'languages/' );
	}

	public static function action_init() {
		CPT::register();
	}

	public static function enqueue_scripts() {
		wp_register_style( WPAUTOTERMS_SLUG . '_css', WPAUTOTERMS_PLUGIN_URL . 'css/wpautoterms.css', false );
		wp_enqueue_style( WPAUTOTERMS_SLUG . '_css' );
	}

	public static function head() {
		ob_start();
	}

	public static function footer() {
		$c = ob_get_contents();
		preg_match( '/(.*<\s*body[^>]*>)(.*)/is', $c, $m );
		ob_end_clean();
		if ( count( $m ) < 3 ) {
// NOTE: HTML is not well formed, we can only detect a closing body
			echo $c;
			static::top_container();
			static::bottom_container();

			return;
		}
		echo $m[1];
		static::top_container();
		echo $m[2];
		static::$_links->links_box();
		static::bottom_container();
	}

	protected static function container( $where, $type ) {
		ob_start();
		do_action( WPAUTOTERMS_SLUG . '_container', $where, $type );
		$c = ob_get_contents();
		ob_end_clean();
		if ( ! empty( $c ) ) {
			echo '<div id="wpautoterms-' . $where . '-' . $type . '-container">' . $c . '</div>';
		}
	}

	protected static function top_container() {
		static::container( 'top', 'static' );
		static::container( 'top', 'fixed' );
	}

	protected static function bottom_container() {
		static::container( 'bottom', 'fixed' );
		static::container( 'bottom', 'static' );
	}
}
