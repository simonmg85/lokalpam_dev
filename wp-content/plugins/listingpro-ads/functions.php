<?php 
add_action( 'init', 'create_post_type_ads' );

function create_post_type_ads() {
	$labels = array(
		'name'               => _x( 'Ads', 'post type general name', 'listingpro' ),
		'singular_name'      => _x( 'Ad', 'post type singular name', 'listingpro' ),
		'menu_name'          => _x( 'Ads', 'admin menu', 'listingpro' ),
		'name_admin_bar'     => _x( 'Ad', 'add new on admin bar', 'listingpro' ),
		'add_new'            => _x( 'Add New', 'ad', 'listingpro' ),
		'add_new_item'       => __( 'Add New Ad', 'listingpro' ),
		'new_item'           => __( 'New Ad', 'listingpro' ),
		'edit_item'          => __( 'Edit Ad', 'listingpro' ),
		'view_item'          => __( 'View Ad', 'listingpro' ),
		'all_items'          => __( 'All Ads', 'listingpro' ),
		'search_items'       => __( 'Search Ads', 'listingpro' ),
		'parent_item_colon'  => __( 'Parent Ads:', 'listingpro' ),
		'not_found'          => __( 'No ads found.', 'listingpro' ),
		'not_found_in_trash' => __( 'No ads found in Trash.', 'listingpro' )
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-media-spreadsheet',
        'description'        => __( 'Description.', 'listingpro' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'lp-ads' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 29,
		'supports'           => array( 'title')
	);

	register_post_type( 'lp-ads', $args );
}