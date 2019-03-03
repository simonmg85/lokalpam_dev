<?php

namespace wpautoterms\box;

use wpautoterms\admin\action\Toggle_Action;
use wpautoterms\admin\page;
use wpautoterms\option\Text_Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Box {
	protected $_id;
	protected $_title;
	protected $_infotip;
	protected $_action;

	public function __construct( $id, $title, $infotip ) {
		$this->_id = $id;
		$this->_action = new Toggle_Action( 'manage_options', null, $this->enable_action_id() );
		$this->_action->set_option_name( $this->_enabled_option() );
		$this->_title = $title;
		$this->_infotip = $infotip;
	}

	public function action() {
		return $this->_action;
	}

	public function enable_action_id() {
		return WPAUTOTERMS_SLUG . '_enable_' . $this->id() . '_toggle';
	}

	public function id() {
		return $this->_id;
	}

	public function title() {
		return $this->_title;
	}

	public function infotip() {
		return $this->_infotip;
	}

	protected function _toggle_button_text( $value ) {
		return $value ? __( 'Disable', WPAUTOTERMS_SLUG ) : __( 'Enable', WPAUTOTERMS_SLUG );
	}

	protected function _box_args() {
		$v = get_option( $this->_enabled_option(), false );

		return array(
			'box' => $this,
			'enabled' => $v,
			'enable_button_text' => $this->_toggle_button_text( $v ),
			'status_text' => $v ? __( 'Enabled', WPAUTOTERMS_SLUG ) : __( 'Disabled', WPAUTOTERMS_SLUG ),
		);
	}

	public function render() {
		\wpautoterms\print_template( 'options/box', $this->_box_args() );
	}

	protected function _page_args( page\Base $page ) {
		return array(
			'title' => $this->title(),
			'page_id' => $page->id(),
			'box_id' => $this->id(),
		);
	}

	public function render_page( page\Base $page ) {
		\wpautoterms\print_template( 'options/box-page', $this->_page_args( $page ) );
	}

	protected function _enabled_option() {
		return WPAUTOTERMS_OPTION_PREFIX . $this->id();
	}

	abstract public function defaults();

	abstract public function define_options( $page_id, $section_id );

	protected function _custom_css_options( $page_id, $section_id ) {
		new Text_Option( $this->id() . '_custom_css', __( 'Additional CSS', WPAUTOTERMS_SLUG ), '',
			$page_id, $section_id, Text_Option::TYPE_TEXTAREA, array(), array( 'wpautoterms-resize-both' ) );
	}
}
