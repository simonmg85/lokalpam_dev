<?php

namespace wpautoterms;

abstract class Util {
	/**
	 * @param $template string - format string with named arguments, e.g. '{arg1} some text {arg2}, again {arg1}, {{preserve braces}}'
	 * @param $args - associative array of arguments
	 *
	 * @return string
	 */
	public static function format( $template, $args ) {
		$ret = explode( '{{', $template );
		foreach ( $args as $k => $v ) {
			$ret = array_map( function ( $x ) use ( $k, $v ) {
				return str_replace( '{' . $k . '}', $v, $x );
			}, $ret );
		}

		return str_replace( '}}', '}', implode( '{', $ret ) );
	}

	public static function first_existing( $files ) {
		foreach ( $files as $file ) {
			if ( file_exists( $file ) ) {
				return $file;
			}
		}

		return false;
	}
}