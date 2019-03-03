<?php

namespace wpautoterms\admin\page;

use wpautoterms\admin\Options;
use wpautoterms\Countries;
use wpautoterms\option\Choices_Option;
use wpautoterms\option\Text_Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings_Page extends Settings_Base {
	const SHORTCODE_OPTION_TEMPLATE = 'shortcode-entry-option';
	const SHORTCODE_SELECT_TEMPLATE = 'shortcode-select-option';

	public function define_options() {
		parent::define_options();
		new Text_Option( Options::OPTION_SITE_NAME,
			__( 'Website name', WPAUTOTERMS_SLUG ),
			'',
			$this->id(), static::SECTION_ID,
			static::SHORTCODE_OPTION_TEMPLATE );
		new Text_Option( Options::OPTION_SITE_URL,
			__( 'Website URL', WPAUTOTERMS_SLUG ),
			'',
			$this->id(), static::SECTION_ID,
			static::SHORTCODE_OPTION_TEMPLATE );
		new Text_Option( Options::OPTION_COMPANY_NAME,
			__( 'Company name', WPAUTOTERMS_SLUG ),
			'',
			$this->id(), static::SECTION_ID,
			static::SHORTCODE_OPTION_TEMPLATE );
		$country = new Choices_Option( Options::OPTION_COUNTRY,
			__( 'Country', WPAUTOTERMS_SLUG ),
			'',
			$this->id(), static::SECTION_ID,
			static::SHORTCODE_SELECT_TEMPLATE, array(
				'data-type' => 'country-selector',
			),
			array( 'wpautoterms-hidden' ) );
		$countries = Countries::get();
		$country->set_values( array_combine( $countries, $countries ) );

		$state = new Choices_Option( Options::OPTION_STATE,
			__( 'State', WPAUTOTERMS_SLUG ),
			'',
			$this->id(), static::SECTION_ID,
			static::SHORTCODE_SELECT_TEMPLATE, array(
				'data-type' => 'state-selector',
			),
			array( 'wpautoterms-hidden' ) );
		$states = array_keys( Countries::translations() );
		$states = array_diff( $states, $countries );
		$state->set_values( array_combine( $states, $states ) );
	}

	public function defaults() {
		return array(
			Options::OPTION_SITE_NAME => get_option( 'blogname' ),
			Options::OPTION_SITE_URL => get_option( 'siteurl' ),
			Options::OPTION_COMPANY_NAME => get_option( 'blogname' ),
			Options::OPTION_COUNTRY => '',
			Options::OPTION_STATE => '',
		);
	}

	public function enqueue_scripts() {
		parent::enqueue_scripts();
		Countries::enqueue_scripts();
	}
}
