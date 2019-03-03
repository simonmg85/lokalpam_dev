<?php

namespace wpautoterms\frontend;

use wpautoterms\gen_css\Attr;
use wpautoterms\gen_css\Document;
use wpautoterms\gen_css\Record;

class Links {
	const MODULE_ID = 'links';

	public function __construct() {
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );
	}

	public function links_box() {
		if ( ! get_option( WPAUTOTERMS_OPTION_PREFIX . static::MODULE_ID ) ) {
			return;
		}
		\wpautoterms\print_template( static::MODULE_ID );
	}

	public function print_styles() {
		$option_prefix = WPAUTOTERMS_OPTION_PREFIX . static::MODULE_ID;

		if ( ! get_option( $option_prefix ) ) {
			return;
		}

		$d = new Document( array(
			new Record( '.wpautoterms-footer', array(
				new Attr( $option_prefix, Attr::TYPE_BG_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_TEXT_ALIGN ),
			) ),
			new Record( '.wpautoterms-footer a', array(
				new Attr( $option_prefix, Attr::TYPE_LINKS_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_FONT ),
				new Attr( $option_prefix, Attr::TYPE_FONT_SIZE ),
			) ),
			new Record( '.wpautoterms-footer .separator', array(
				new Attr( $option_prefix, Attr::TYPE_TEXT_COLOR ),
				new Attr( $option_prefix, Attr::TYPE_FONT ),
				new Attr( $option_prefix, Attr::TYPE_FONT_SIZE ),
			) ),
		) );
		$text = $d->text();
		$custom = get_option( $option_prefix . '_custom_css' );
		if ( ! empty( $custom ) ) {
			$text .= "\n" . strip_tags($custom);
		}
		echo Document::style( $text ) . "\n";
	}

}