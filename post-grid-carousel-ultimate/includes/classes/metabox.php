<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PGCU_Metabox
{

    public function __construct () {
        //add metabox
        add_action( 'add_meta_boxes', array( $this,'gc_adl_add_meta_box' ) );

        //save post
        add_action( 'save_post', array( $this,'gc_adl_save_meta_box' ) );

    }

    //method for add meta box
    public function gc_adl_add_meta_box() {
        add_meta_box(
            'short_metabox',
            __( 'Settings & Shortcode Generator', PGCU_TEXTDOMAIN ),
            array( $this,'outpost_shortcode_metabox_markup' ),
            PGCU_POST_TYPE,
            'normal'
            );
    }

    //Function that will check if value is a valid HEX color.
    public function check_color( $value ) {

        if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #
            return true;
        }

        return false;
    }

    //output of shortcode metabox
    public function outpost_shortcode_metabox_markup( $post ){

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'aps_meta_save', 'gc_meta_save_nonce' );

        $get_value = get_post_meta( $post->ID,'gc',true );
        $get_value = ! is_array( $get_value ) ? post_grid_and_carousel_ultimate::json_decoded( $get_value ) : $get_value;

        $gc_value = is_array( $get_value ) ? $get_value : array();

        extract( $gc_value );

        $layout = ! empty( $layout ) ? $layout : 'carousel';
        ?>
        <div id="tabs-container">
            <div class="lcsp-tabs-menu-wrapper">
                <ul class="lcsp-tabs-menu">
                    <li class="current"><a href="#tab-1"> <?php esc_html_e( 'Shortcodes', PGCU_TEXTDOMAIN ); ?> </a></li>

                    <li><a href="#tab-2"> <?php esc_html_e( 'General Settings', PGCU_TEXTDOMAIN ); ?> </a></li>

                    <li style="display: <?php if( $layout == "grid" || $layout == "isotope" ) { echo "none"; }else{ echo "block"; }?>;" id="tab1"><a href="#tab-3"> <?php esc_html_e( 'Carousel Settings', PGCU_TEXTDOMAIN ); ?> </a></li>

                    <li style="display: <?php if( $layout == "grid" ){ echo "block"; }else{ echo "none"; }?>;" id="tab2"><a href="#tab-4"> <?php esc_html_e( 'Grid Settings', PGCU_TEXTDOMAIN ); ?> </a></li>

                    <li style="display: <?php if( $layout == "isotope" ){ echo "block"; }else{ echo "none"; }?>;" id="tab3"><a href="#tab-5"> <?php esc_html_e( 'Sortable Grid Settings', PGCU_TEXTDOMAIN ); ?> </a></li>

                    <li><a href="#tab-6"> <?php esc_html_e( 'Style Settings', PGCU_TEXTDOMAIN ); ?> </a></li>
                </ul>
                <a href="https://wpwax.com/contact/" class="lcsp-support"><span class="fas fa-question-circle"></span>Support</a>
            </div>
            <?php
            require_once PGCU_INC_DIR . 'settings/get-shortcodes.php';
            require_once PGCU_INC_DIR . 'settings/general.php';
            require_once PGCU_INC_DIR . 'settings/grid.php';
            require_once PGCU_INC_DIR . 'settings/carousel.php';
            require_once PGCU_INC_DIR . 'settings/sortable.php';
            require_once PGCU_INC_DIR . 'settings/style.php';

    }

    //save  all posts
    public function gc_adl_save_meta_box( $post_id )
    {
        // vail if the security check fails
        if ( ! $this->wcpscu_security_check( 'gc_meta_save_nonce', 'aps_meta_save', $post_id ) )
            return;


        // save the meta data if it is our post type lcg_mainpost post type
        if ( ! empty( $_POST['post_type'] ) && ( PGCU_POST_TYPE == $_POST['post_type'] ) ) {

            $gc = ! empty( $_POST['gc'] ) ? post_grid_and_carousel_ultimate::json_encoded( pgcu_sanitize_array( $_POST['gc'] ) ) : post_grid_and_carousel_ultimate::json_encoded( array() );

            //save the meta value
            update_post_meta( $post_id, "gc", $gc );

        }
    }

    //security check
    private function wcpscu_security_check( $nonce_name, $action, $post_id ) {
        // checks are divided into 3 parts for readability.
        if ( ! empty( $_POST[ $nonce_name ] ) && wp_verify_nonce( $_POST[ $nonce_name ], $action ) ) {
            return true;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything. returns false
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return false;
        }
        // Check the user's permissions.
        if ( current_user_can( 'edit_post', $post_id ) ) {
            return true;
        }

        return false;
    }



} // end class
