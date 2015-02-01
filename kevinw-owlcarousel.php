<?php
/*
 * Plugin Name: Custom OwlCarousel
 * Plugin URI: http://kevinw.de/
 * Description: Custom OwlCarousel solution for WordPress with kevinw.de in mind (http://owlgraphic.com/owlcarousel/).
 * Author: Kevin Weber
 * Version: 0.1
 * Author URI: http://kevinw.de/
 * License: GPL v3
 * Text Domain: kevinw-owlcarousel
*/
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'KEVINW_OWLC_VERSION', '0.1' );

if ( ! defined( 'KEVINW_OWLC_FILE' ) ) {
	define( 'KEVINW_OWLC_FILE', __FILE__ );
}

if ( ! defined( 'KEVINW_OWLC_PATH' ) ) {
	define( 'KEVINW_OWLC_PATH', plugin_dir_path( KEVINW_OWLC_FILE ) );
}

if ( ! defined( 'KEVINW_OWLC_BASENAME' ) ) {
	define( 'KEVINW_OWLC_BASENAME', plugin_basename( KEVINW_OWLC_FILE ) );
}


/* ***************************** CLASS AUTOLOADING *************************** */

function kevinw_owlc_auto_load_frontend($class) {
	kevinw_owlc_auto_load($class, 'frontend');
	$Kevinw_OwlC_Frontend_Setup = new Kevinw_OwlC_Frontend_Setup();
}
function kevinw_owlc_auto_load_backend($class) {
	kevinw_owlc_auto_load($class, 'backend');
	$Kevinw_OwlC_Frontend_Setup = new Kevinw_OwlC_Backend_Meta_Boxes();
}

/*
 * Require classes á la "Kevinw_OwlC_Frontend_Setup()". "Kevinw_OwlC_Frontend_" gets removed to load files á la "frontend/class-setup.php"
 */
function kevinw_owlc_auto_load($class, $folderName) {
	$className = strtolower( $class );
	$className = str_replace("kevinw_owlc_".$folderName."_", "", $className);
	$className = str_replace("_", "-", $className);

    $filename = KEVINW_OWLC_PATH . $folderName . "/class-" . $className . ".php";
    if (is_readable($filename)) {
        require_once $filename;
    }
}
if ( function_exists( 'spl_autoload_register' ) ) {
	spl_autoload_register( 'kevinw_owlc_auto_load_frontend' );
	spl_autoload_register( 'kevinw_owlc_auto_load_backend' );
}
?>