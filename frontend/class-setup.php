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
			add_action( 'wp_footer', array( $this, 'owlcarousel_init') );
		}

		/**
		 * Add JS and CSS
		 */
		function register_scripts() {
			$id = get_the_ID();
			// Only continue if current page is home or the carousel is enabled manually
			if ( !is_home() && ( get_post_meta( $id, 'kevinw_check_owlc', true ) != 'on' ) ) return;

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-kevinw-owlc', plugins_url( 'assets/owl.carousel.min.js', KEVINW_OWLC_FILE ), array( 'jquery' ), true );

			$this->register_scripts_css();
		}

		function register_scripts_css() {
			wp_register_style( 'css-kevinw-owlc-basic', plugins_url( 'assets/owl.carousel.css', KEVINW_OWLC_FILE ) );
			wp_enqueue_style( 'css-kevinw-owlc-basic' );
			wp_register_style( 'css-kevinw-owlc-theme', plugins_url( 'assets/owl.theme.css', KEVINW_OWLC_FILE ) );
			wp_enqueue_style( 'css-kevinw-owlc-theme' );
		}

		/**
		 * @TODO: Add backend options page so that these setting can be set without the need of hard-coding
		 */
		function owlcarousel_init() {
			$id = get_the_ID();
			if ( !is_home() && ( get_post_meta( $id, 'kevinw_check_owlc', true ) != 'on' ) ) return;

			?>
			<script>
			(function ( $ ) {
				$(document).ready(function() {
				  $("#owl-home").owlCarousel({
				    items : 3,
				    lazyLoad : true,
				  });
				});
				$(document).ready(function() {
				  $("#owl-quote").owlCarousel({
				      slideSpeed : 300,
				      paginationSpeed : 400,
				      singleItem: true,
				  });
				});
			})(jQuery);
			</script>
		<?php }

	}
 
} /* End of class-exists wrapper */
?>