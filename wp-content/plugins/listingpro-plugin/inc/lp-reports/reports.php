<?php
/*---------------------------------------------------
				adding reports page
----------------------------------------------------*/
if(!function_exists('listingpro_register_reports_page')){
	function listingpro_register_reports_page() {
		add_menu_page(
			__( 'Flags', 'listingpro-plugin' ),
			'Listing Flags',
			'manage_options',
			'lp-flags',
			'listingpro_flags_page',
			plugins_url( 'listingpro-plugin/images/flag.png' ),
			30
		);
		wp_enqueue_style("panel_style", WP_PLUGIN_URL."/listingpro-plugin/assets/css/custom-admin-pages.css", false, "1.0", "all");
		
	}
}
add_action( 'admin_menu', 'listingpro_register_reports_page' );

/* ----------------------include listings reports---------------- */
include_once(WP_PLUGIN_DIR.'/listingpro-plugin/inc/lp-reports/listings-reports.php');

/* ----------------------include reviews reports---------------- */
include_once(WP_PLUGIN_DIR.'/listingpro-plugin/inc/lp-reports/reviews-reports.php');

?>