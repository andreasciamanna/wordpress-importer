<?php
/*
Plugin Name: WordPress Importer
Plugin URI: http://wordpress.org/extend/plugins/wordpress-importer/
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: wordpressdotorg
Author URI: http://wordpress.org/
Version: 1.0-b1
Text Domain: wordpress-importer
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	return;
}

define( 'WP_IMPORT_PLUGIN_PATH', dirname( __FILE__ ) );

/** Display verbose errors */
define( 'IMPORT_DEBUG', false );

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require $class_wp_importer;
	}
}

require_once dirname( __FILE__ ) . 'lib/wp-import-auto-loader.php';
$wp_import_auto_loader_instance = WP_Import_Auto_Loader::get_instance();
$wp_import_auto_loader_instance->register( WP_IMPORT_PLUGIN_PATH . '/' );

function wordpress_importer_init() {
	load_plugin_textdomain( 'wordpress-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	/**
	 * WordPress Importer object for registering the import callback
	 * @global WP_Import $wp_import
	 */
	$GLOBALS['wp_import'] = new WP_Import();
	register_importer( 'wordpress', 'WordPress', __( 'Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'wordpress-importer' ), array( $GLOBALS['wp_import'], 'dispatch' ) );
}

add_action( 'admin_init', 'wordpress_importer_init' );
