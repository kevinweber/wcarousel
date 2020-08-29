<?php
/*
 * Plugin Name: wCarousel
 * Plugin URI: http://kevinw.de/
 * Description: wCarousel brings OwlCarousel to WordPress. Work in progress.
 * Author: Kevin Weber
 * Version: 0.1
 * Author URI: http://kevinw.de/
 * License: GPL v3
 * Text Domain: wcarousel
*/
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'KEVINW_OWLC_VERSION', '0.2' );

if ( ! defined( 'KEVINW_OWLC_FILE' ) ) {
	define( 'KEVINW_OWLC_FILE', __FILE__ );
}

if ( ! defined( 'KEVINW_OWLC_PATH' ) ) {
	define( 'KEVINW_OWLC_PATH', plugin_dir_path( KEVINW_OWLC_FILE ) );
}

function kevinw_owlc_plugins_loaded() {
	require_once( KEVINW_OWLC_PATH . 'frontend/class-setup.php' );
	require_once( KEVINW_OWLC_PATH . 'backend/class-meta-boxes.php' );
}

add_action( 'plugins_loaded', 'kevinw_owlc_plugins_loaded', 16 );
?>