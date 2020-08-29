<?php
/**
 * @package Frontend
 *
 * Main frontend code.
 */
if ( ! defined( 'KEVINW_OWLC_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'Kevinw_OwlC_Frontend_Setup' ) ) {

	class Kevinw_OwlC_Frontend_Setup {

		function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		}

		/**
		 * Add JS and CSS
		 */
		function register_scripts() {
			$id = get_the_ID();
			// Only continue if carousel was enabled manually
			if ( get_post_meta( $id, 'kevinw_check_owlc', true ) != 'on' ) return;

			wp_enqueue_script( 'jquery', false, array(), false, true );
			wp_enqueue_script( 'jquery-kevinw-owlc', plugins_url( 'assets/owl.carousel.min.js', KEVINW_OWLC_FILE ), array( 'jquery' ), false, true );
			wp_add_inline_script(
				'jquery-kevinw-owlc',
				$this->owlcarousel_inline_script(),
				'after'
			);

			$this->register_scripts_css();
		}

		function register_scripts_css() {
			wp_register_style( 'css-kevinw-owlc-basic', plugins_url( 'assets/owl.carousel.css', KEVINW_OWLC_FILE ) );
			wp_enqueue_style( 'css-kevinw-owlc-basic' );
			wp_register_style( 'css-kevinw-owlc-theme', plugins_url( 'assets/owl.theme.css', KEVINW_OWLC_FILE ) );
			wp_enqueue_style( 'css-kevinw-owlc-theme' );
		}

		function owlcarousel_inline_script() {
			return <<<EOD
	(function ( $ ) {
		$(function() {
			$("#owl-stripe").owlCarousel({
				items : 4,
				lazyLoad : true
			});
			$("#owl-quote").owlCarousel({
				slideSpeed : 300,
				paginationSpeed : 400,
				singleItem: true
			});
		});
	}(jQuery));
EOD;
		}

	}

	new Kevinw_OwlC_Frontend_Setup();

} /* End of class-exists wrapper */

?>
