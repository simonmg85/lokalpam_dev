<?php

namespace wpautoterms\api;

class Query {
	protected $_base_url;
	protected $_verbose;

	public function __construct( $base_url, $verbose = false ) {
		$this->_base_url = $base_url;
		$this->_verbose = $verbose;
	}

	/**
	 * @param string $ep remote endpoint
	 * @param array $params
	 * @param false|array $headers
	 *
	 * @return Response
	 */
	public function get( $ep, $params = array(), $headers = false ) {
		$params = array_map( function ( $x ) use ( $params ) {
			return urlencode( $x ) . '=' . urlencode( $params[ $x ] );
		}, array_keys( $params ) );
		$suffix = empty( $params ) ? '' : '?' . join( '&', $params );
		$url = $this->_base_url . $ep . $suffix;
		$all_headers = array(
			'Referer: ' . get_site_url(),
			'X-WP-Locale: ' . get_locale()
		);
		if ( $headers ) {
			$all_headers = array_merge( $headers, $all_headers );
		}
		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $all_headers );

		return $this->_exec( $curl );
	}

	/**
	 * @param string $ep remote endpoint
	 * @param mixed $params
	 * @param false|array $headers
	 *
	 * @return Response
	 */
	public function post_json( $ep, $params, $headers = false ) {
		$data = json_encode( $params );
		$url = $this->_base_url . $ep;
		$curl = curl_init( $url );
		$all_headers = array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen( $data ),
			'Referer: ' . get_site_url(),
			'X-WP-Locale: ' . get_locale()
		);
		if ( $headers ) {
			$all_headers = array_merge( $headers, $all_headers );
		}
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $all_headers );

		return $this->_exec( $curl );
	}

	/**
	 * @param $curl
	 *
	 * @return Response
	 */
	protected function _exec( $curl ) {
		$vs = null;
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HEADER, false );
		$resp = new Response( $curl, $this->_verbose );
		$resp->response = curl_exec( $curl );
		$resp->_done();
		curl_close( $curl );

		return $resp;
	}
}
