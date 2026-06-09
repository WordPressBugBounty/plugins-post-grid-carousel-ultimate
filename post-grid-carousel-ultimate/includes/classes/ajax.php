<?php 
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PGCU_Ajax
{
	public function __construct () {

		add_action('wp_ajax_pgcu_post_type', array( $this, 'post_type_ajax_handler') ); // wp_ajax_{action}

        add_action('wp_ajax_pgcu_sortable', array( $this, 'sortable_ajax_handler') ); // wp_ajax_{action}
        add_action('wp_ajax_nopriv_pgcu_sortable', array( $this, 'sortable_ajax_handler') );

    }

    function post_type_ajax_handler(){
        if ( ! current_user_can('edit_posts') ) {
            wp_send_json_error( ['message' => 'Unauthorized access.'] );
            exit;
        }
        ob_start();

        $post_type = ! empty( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : 'post'; ?>

        <?php 
        $terms = get_object_taxonomies( (object) array( 'post_type' => $post_type, 'hide_empty' => false ) );
        if( $terms ) {
            foreach( $terms as $term ) {
        ?>
        <option value="<?php echo esc_attr( $term ); ?>" ><?php echo esc_html( $term ); ?></option>
        <?php } } 
        $value = ob_get_clean();

        wp_send_json( $value ); 

        die; // here we exit the script and even no wp_reset_query() required!
    }

    function sortable_ajax_handler() {
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => 'Unauthorized access.']);
            exit;
        }

        $term_id = !empty($_POST['term_id']) ? sanitize_text_field($_POST['term_id']) : 'all';
        $post_id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $query   = !empty($_POST['query']) ? json_decode(stripslashes($_POST['query']), true) : [];
        
        $data 	 = get_post_meta( $post_id, 'gc', true );
        $data = post_grid_and_carousel_ultimate::json_decoded( $data );
        $value = is_array( $data ) ? $data : array();
        extract( $value );

        $layout             = ! empty( $layout ) ? sanitize_text_field( $layout ) : 'carousel';
        $allowed_themes     = ['theme-1', 'theme-2', 'theme-3', 'theme-3'];                            // Define allowed themes
        $theme              = isset( $theme ) && in_array( $theme, $allowed_themes, true ) ? sanitize_text_field( $theme ) : 'theme-1';
        $post_type          = ! empty( $post_type ) ? sanitize_text_field( $post_type ) : 'post';
        $term_from          = ! empty( $term_from ) ? sanitize_text_field( $term_from ) : 'category';
        $display_term       = ! empty( $display_term ) ? sanitize_text_field( $display_term ) : 'yes';
        $display_title      = ! empty( $display_title ) ? sanitize_text_field( $display_title ) : 'yes';
        $display_content    = ! empty( $display_content ) ? sanitize_text_field( $display_content ) : 'yes';
        $content_word_limit = ! empty( $content_word_limit ) ? sanitize_text_field( $content_word_limit ) : '16';
        $display_read_more  = ! empty( $display_read_more ) ? sanitize_text_field( $display_read_more ) : 'yes';
        $read_more_text     = ! empty( $read_more_text ) ? sanitize_text_field( $read_more_text ) : 'Read More';
        $read_more_type     = ! empty( $read_more_type ) ? sanitize_text_field( $read_more_type ) : 'link';
        $display_author     = ! empty( $display_author ) ? sanitize_text_field( $display_author ) : 'yes';
        $display_date       = ! empty( $display_date   ) ? sanitize_text_field( $display_date )   : 'yes';

        $image_resize_crop = ! empty( $image_resize_crop ) ? sanitize_text_field( $image_resize_crop ) : "yes";
        $image_width	   = ! empty( $image_width ) ? sanitize_text_field( $image_width ) : 300;
        $image_height	   = ! empty( $image_height ) ? sanitize_text_field( $image_height ) : 290;

        $g_sort            = ! empty( $g_sort    ) ? sanitize_text_field( $g_sort )    : 'category';

        if( 'all' != $term_id ) {
            $query['tax_query'] = array( 
                array(
                'taxonomy' => $g_sort,
                'field' => 'term_id',
                'terms' => $term_id,
                )
            );
        }

        // it is always better to use WP_Query but not here
        query_posts( $query );

        
        if( have_posts() ) :
     
            // run the loop
            while( have_posts() ): the_post();

            $thumb = get_post_thumbnail_id();
            // crop the image if the cropping is enabled.
            if( 'yes' === $image_resize_crop ){
                $pgcu_img = pgcu_image_cropping( $thumb, $image_width, $image_height, true, 100 )['url'];
            }else{
                $aazz_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'large' );
                $pgcu_img = $aazz_thumb['0'];
            }

            $get_terms  = get_the_terms( get_the_ID(), $term_from );
            $post_views = get_post_meta( get_the_id(), '_pgcu_post_views_count', true );

            $template_path = PGCU_INC_DIR . 'templates/' . sanitize_file_name( $theme ) . '.php';
            if (file_exists($template_path)) {
                include $template_path;
            } else {
                wp_send_json_error(['message' => 'Invalid template specified.']);
                exit;
            }
     
     
            endwhile;
     
        endif;

        die; // here we exit the script and even no wp_reset_query() required!
    }

	

}//end class