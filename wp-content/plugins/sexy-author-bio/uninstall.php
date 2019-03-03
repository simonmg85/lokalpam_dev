<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   WP_Author_Bio
 * @author    Andy Forsberg <andy@penguinwp.com>
 * @license   GPL-2.0+
 * @copyright 2017 Penguin Initiatives
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'sexyauthorbio_settings' );
