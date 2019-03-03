<?php

namespace wpautoterms;

function uninstall() {
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		die;
	}

	require_once dirname( __FILE__ ) . '/wpautoterms.php';

	delete_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED );
	flush_rewrite_rules();
}
