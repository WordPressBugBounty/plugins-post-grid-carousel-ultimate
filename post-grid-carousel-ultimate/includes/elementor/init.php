<?php
if ( ! function_exists('register_post_ultimate_widget') ) {
	function register_post_ultimate_widget( $widgets_manager ) {

		require_once PGCU_INC_DIR . 'elementor/widget.php';

		$widgets_manager->register( new Elementor_Post_Ultimate_Widget() );

	}
}
add_action( 'elementor/widgets/register', 'register_post_ultimate_widget' );