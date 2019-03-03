<?php

namespace wpautoterms\shortcode;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Sub_Shortcode {
	protected $_name;

	function __construct( $name ) {
		$this->_name = $name;
	}

	public function name() {
		return $this->_name;
	}

	abstract function handle( $values, $content );
}
