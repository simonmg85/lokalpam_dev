<?php

namespace wpautoterms\shortcode;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Post_Base extends Sub_Shortcode {

	function handle( $values, $content ) {
		global $wpautoterms_post;
		if ( ! empty( $wpautoterms_post ) ) {
			return $this->handle_post( $wpautoterms_post, $values, $content );
		}
		global $post;
		if ( empty( $post ) ) {
			return '';
		}

		return $this->handle_post( $post, $values, $content );
	}

	abstract protected function handle_post( $post, $values, $content );
}
