<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once join( DIRECTORY_SEPARATOR, array( __DIR__, 'includes', 'cpt', 'cpt.php' ) );
wpautoterms\cpt\CPT::unregister_roles();
delete_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED );
flush_rewrite_rules();
