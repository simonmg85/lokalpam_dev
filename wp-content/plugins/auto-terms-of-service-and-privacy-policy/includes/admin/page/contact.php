<?php

namespace wpautoterms\admin\page;


use wpautoterms\admin\action\Send_Message;

class Contact extends Base {
	const EP_MESSAGE = 'contact/v2/message_prepare';
	/**
	 * @var Send_Message
	 */
	public $action;

	public function api_endpoint() {
		return WPAUTOTERMS_API_URL . static::EP_MESSAGE;
	}

	public function enqueue_scripts() {
		parent::enqueue_scripts();
		wp_enqueue_script( WPAUTOTERMS_SLUG . '_contact_form', WPAUTOTERMS_PLUGIN_URL . 'js/contact-form.js',
			array( 'underscore', 'wp-util' ), false, true );
		wp_localize_script( WPAUTOTERMS_SLUG . '_contact_form', 'wpautotermsContact', array(
			'nonce' => $this->action->nonce(),
			'id' => $this->action->name(),
			'siteInfo' => $this->action->site_info()
		) );
	}
}
