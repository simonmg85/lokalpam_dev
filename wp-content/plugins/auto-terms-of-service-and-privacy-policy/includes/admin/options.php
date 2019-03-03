<?php

namespace wpautoterms\admin;

class Options {
	const OPTION_SITE_NAME = 'site_name';
	const OPTION_SITE_URL = 'site_url';
	const OPTION_COMPANY_NAME = 'company_name';
	const OPTION_COUNTRY = 'country';
	const OPTION_STATE = 'state';

	public static function all_options() {
		return array(
			static::OPTION_SITE_NAME,
			static::OPTION_SITE_URL,
			static::OPTION_COMPANY_NAME,
			static::OPTION_COUNTRY,
			static::OPTION_STATE
		);
	}

	public static function get_option( $name, $default = null ) {
		return get_option( WPAUTOTERMS_OPTION_PREFIX . $name, $default );
	}

	public static function set_option( $name, $value, $autoload = null ) {
		return update_option( WPAUTOTERMS_OPTION_PREFIX . $name, $value, $autoload );
	}
}
