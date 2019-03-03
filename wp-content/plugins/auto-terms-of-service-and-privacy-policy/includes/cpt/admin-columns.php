<?php

namespace wpautoterms\cpt;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Admin_Columns {
	const COL_CB = 'cb';
	const COL_TITLE = 'title';
	const COL_STATUS = 'status';
	const COL_LAST_DATE = 'last_date';
	const COL_DATE = 'date';

	static function init() {
		add_filter( 'manage_edit-' . WPAUTOTERMS_CPT . '_columns', array( __CLASS__, 'edit_columns' ) );
		add_filter( 'manage_edit-' . WPAUTOTERMS_CPT . '_sortable_columns', array(
			__CLASS__,
			'sortable_columns'
		) );
		add_filter( 'display_post_states', array( __CLASS__, 'display_post_states' ), 10, 2 );
		add_action( 'manage_' . WPAUTOTERMS_CPT . '_posts_custom_column',
			array( __CLASS__, 'manage_columns' ),
			10,
			2 );
	}

	static function edit_columns( $columns ) {
		return array(
			static::COL_CB => '<input type="checkbox" />',
			static::COL_TITLE => __( 'Title', WPAUTOTERMS_SLUG ),
			static::COL_STATUS => __( 'Status', WPAUTOTERMS_SLUG ),
			static::COL_LAST_DATE => __( 'Last Effective Date', WPAUTOTERMS_SLUG ),
			static::COL_DATE => __( 'Date', WPAUTOTERMS_SLUG )
		);
	}

	static function sortable_columns( $columns ) {
		$columns[ static::COL_STATUS ] = static::COL_STATUS;
		$columns[ static::COL_LAST_DATE ] = static::COL_LAST_DATE;

		return $columns;
	}

	static function manage_columns( $column, $post_id ) {
		$post = get_post( $post_id );
		if ( empty( $post ) ) {
			return;
		}
		switch ( $column ) {
			case static::COL_LAST_DATE:
				if ( $post->post_status == 'publish' ) {
					echo esc_html(get_post_modified_time( get_option( 'date_format' ), false, $post, true ));
				}
				break;
		}
	}

	static function display_post_states( $post_states, $post ) {
		if ( $post->post_type == WPAUTOTERMS_CPT ) {
			return array();
		}

		return $post_states;
	}
}
