<?php

namespace wpautoterms\api;

class Response {
	const HTTP_OK = 200;
	const HTTP_LIMIT = 429;

	const HEADER_RETRY_AFTER = 'retry-after: ';

	const MESSAGE_KEY = 'message';

	public $code;
	public $response;
	public $error;
	public $error_info = '';
	public $url;
	public $delay;
	protected $_curl;
	protected $_verbose;
	protected $_vs;
	public $headers = array();
	protected $_json;

	public function __construct( $curl, $verbose = false ) {
		$this->_curl = $curl;
		$this->_verbose = $verbose;
		curl_setopt( $this->_curl, CURLOPT_HEADERFUNCTION, array( $this, '_handle_header' ) );
		if ( $this->_verbose ) {
			curl_setopt( $this->_curl, CURLOPT_VERBOSE, true );
			$this->_vs = fopen( 'php://temp', 'w+' );
			curl_setopt( $this->_curl, CURLOPT_STDERR, $this->_vs );
		}
		$this->url = curl_getinfo( $this->_curl, CURLINFO_EFFECTIVE_URL );
	}

	public function _handle_header( $curl, $header ) {
		$this->headers[] = $header;
		$l = strlen( static::HEADER_RETRY_AFTER );
		if ( 0 == strncasecmp( $header, static::HEADER_RETRY_AFTER, $l ) ) {
			$this->delay = intval( substr( $header, $l ) );
		}

		return strlen( $header );
	}

	public function _done() {
		$this->code = curl_getinfo( $this->_curl, CURLINFO_HTTP_CODE );
		$this->error = curl_errno( $this->_curl );
		if ( $this->has_error() && $this->_vs !== null ) {
			rewind( $this->_vs );
			$this->error_info = stream_get_contents( $this->_vs );
			fclose( $this->_vs );
			$this->_vs = null;
		}
	}

	public function has_error() {
		return empty( $this->response ) || $this->error != CURLE_OK;
	}

	/**
	 * @return array
	 */
	public function json() {
		if ( $this->has_error() ) {
			return array();
		}
		if ( $this->_json === null ) {
			$this->_json = json_decode( $this->response, true );
		}

		return $this->_json;
	}

	public function format_error( $debug ) {
		if ( $this->has_error() ) {
			$error = __( 'Could not connect to server', WPAUTOTERMS_SLUG );
		} else if ( $this->code != Response::HTTP_OK ) {
			$json = $this->json();
			if ( $json !== null && isset( $json[ static::MESSAGE_KEY ] ) ) {
				$error = $json[ static::MESSAGE_KEY ];
			} else {
				if ( $this->code == Response::HTTP_LIMIT ) {
					$error = __( 'Too much requests. Please, wait.', WPAUTOTERMS_SLUG );
				} else {
					$error = sprintf( __( 'Server response code: %s', WPAUTOTERMS_SLUG ), $this->code );
				}
			}
		} else {
			$error = '';
		}
		if ( ! empty( $error ) && $debug ) {
			$info = sprintf( __( 'URL: %s, error: %s, info: %s', WPAUTOTERMS_SLUG ), $this->url, $this->error, $this->error_info );
			$error = sprintf( _x( '%s, %s', 'class Response verbose error info', WPAUTOTERMS_SLUG ), $error, $info );
		}

		return $error;
	}
}
