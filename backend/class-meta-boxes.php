<?php
/**
 * @package Backend
 *
 * Main backend code.
 */
if ( ! defined( 'KEVINW_OWLC_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'Kevinw_OwlC_Backend_Meta_Boxes' ) ) {

	class Kevinw_OwlC_Backend_Meta_Boxes {

		function __construct() {
			/**
			 * Add additonal fields to the page where you create your posts and pages
			 * (Based on http://wp.tutsplus.com/tutorials/plugins/how-to-create-custom-wordpress-writemeta-boxes/)
			 */
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action( 'save_post', array( $this, 'save' ) );
		}

		function add_meta_box() {

			$screens = array( 'post', 'page' );

			foreach ( $screens as $screen ) {
				add_meta_box(
					'meta-box-kevinw-owlc',
					'Carousel Settings',
					array( $this, 'meta_box' ),
					$screen,
					'side',	// position
					'high'	// priority
				);
			}

		}

		function meta_box( $post ) {
			$values = get_post_custom( $post->ID );
			$check = isset( $values['kevinw_check_owlc'] ) ? esc_attr( $values['kevinw_check_owlc'][0] ) : '';
			
			wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

			?>
			<p>
				<input type="checkbox" name="kevinw_check_owlc" id="kevinw_check_owlc" <?php checked( $check, 'on' ); ?> />
				<label for="kevinw_check_owlc">Enable OwlCarousel Script?</label>
			</p>

		<?php }

		function save( $post_id ) {

			// Bail if we're doing an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			
			// If our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
			
			// Now we can actually save the data
			$allowed = array( 
				'a' => array( // on allow a tags
					'href' => array() // and those anchords can only have href attribute
				)
			);
			
			// Probably a good idea to make sure your data is set
			// CHECKBOX
			$chk = ( isset( $_POST['kevinw_check_owlc'] ) && $_POST['kevinw_check_owlc'] ) ? 'on' : 'off';
			update_post_meta( $post_id, 'kevinw_check_owlc', $chk );
		}

	}
 
} /* End of class-exists wrapper */
?>