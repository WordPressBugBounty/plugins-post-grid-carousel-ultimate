<?php 

if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed

function pgcup_register_block() {

    wp_enqueue_script( 
        'pgcup-gutenberg-js', 
        PGCU_URL . 'build/index.js', 
        [
        'wp-block-editor', 
        'wp-blocks', 
        'wp-components', 
        'wp-element', 
        'wp-i18n', 
        'wp-server-side-render'
        ] 
    );

    wp_enqueue_style( 'pgcu-main', PGCU_URL . 'assets/css/style.css' );
    wp_enqueue_style( 'pgcu-swiper-css', PGCU_URL . 'assets/css/swiper-bundle.min.css' );
    
    wp_enqueue_script( 'pgcu-macy', PGCU_URL . 'assets/js/macy.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'pgcu-swiper', PGCU_URL . 'assets/js/swiper-bundle.min.js', array('jquery') );
    wp_enqueue_script( 'pgcu-main-js', PGCU_URL . 'assets/js/main.js', array('jquery'), '', true );


    $attributes = pgcup_get_attributes_from_metadata( trailingslashit( __DIR__ ) );

    register_block_type(
        'pgcup/block',
        [
            'style'           => 'pgcup-main',
            'editor_script'   => 'pgcup-gutenberg-js',
            'api_version'     => 2,
            'attributes'      => $attributes,
            'render_callback' => 'pgcu_render_callback'
        ]
    );
}

function pgcu_render_callback( $attributes ) {
    $attributes['display_header_title']         = ! empty( $attributes['display_header_title'] ) ? 'yes' : 'no';
    $attributes['display_title']                = ! empty( $attributes['display_title'] ) ? 'yes' : 'no';
    $attributes['display_content']              = ! empty( $attributes['display_content'] ) ? 'yes' : 'no';
    $attributes['display_read_more']            = ! empty( $attributes['display_read_more'] ) ? 'yes' : 'no';
    $attributes['display_author']               = ! empty( $attributes['display_author'] ) ? 'yes' : 'no';
    $attributes['display_date']                 = ! empty( $attributes['display_date'] ) ? 'yes' : 'no';
    $attributes['display_term']                 = ! empty( $attributes['display_term'] ) ? 'yes' : 'no';
    $attributes['autoplay']                     = ! empty( $attributes['autoplay'] ) ? 'yes' : 'no';
    $attributes['repeat_post']                  = ! empty( $attributes['repeat_post'] ) ? 'yes' : 'no';
    $attributes['pause_hover']                  = ! empty( $attributes['pause_hover'] ) ? 'yes' : 'no';
    $attributes['marquee']                      = ! empty( $attributes['marquee'] ) ? 'yes' : 'no';
    $attributes['navigation']                   = ! empty( $attributes['navigation'] ) ? 'yes' : 'no';
    $attributes['display_pagination']           = ! empty( $attributes['display_pagination'] ) ? 'yes' : 'no';
    $attributes['image_resize_crop']            = ! empty( $attributes['image_resize_crop'] ) ? 'yes' : 'no';
    $attributes['img_hover_effect']             = ! empty( $attributes['img_hover_effect'] ) ? 'yes' : 'no';

    return pgcup_run_shortcode( 'pgcu', $attributes );
    
}

function pgcup_get_attributes_from_metadata( $file_or_folder ) {
	$filename      = 'attributes.json';
	$metadata_file = ( substr( $file_or_folder, -strlen( $filename ) ) !== $filename ) ?
		trailingslashit( $file_or_folder ) . $filename :
		$file_or_folder;

	if ( ! file_exists( $metadata_file ) ) {
		return [];
	}

	$metadata = json_decode( file_get_contents( $metadata_file ), true );

	if ( empty( $metadata ) || ! is_array( $metadata )  ) {
		return [];
	}

	return $metadata;
}

function pgcup_run_shortcode( $shortcode, $atts = [] ) {
    $html = '';

    foreach ( $atts as $key => $value ) {
        $html .= sprintf( ' %s="%s"', $key, esc_html( $value ) );
    }

    $html = sprintf( '[%s%s]', $shortcode, $html );

    return do_shortcode( $html );
}

add_action( 'init', 'pgcup_register_block' );
?>