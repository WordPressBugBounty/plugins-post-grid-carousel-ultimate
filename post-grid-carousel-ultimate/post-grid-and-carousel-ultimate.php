<?php
/*
Plugin Name: Post Grid, Slider & Carousel Ultimate
Plugin URI: https://wordpress.org/product/post-grid-carousel-ultimate-pro
Description: Use Post Grid & Carousel Ultimate Plugin to display your posts in different beautiful Grids and Sliders/Carousels very easily.
Version: 1.6.10
Author: wpWax
Author URI: https://wpwax.com
License: GPLv2 or later
*/

if( ! defined('ABSPATH') ) { die('Direct browsing is not possible');}

Final class post_grid_and_carousel_ultimate
{

    /**
    *
    * @since 1.0.0
    */
    private static $instance;

	/**
     *custom post
     *@since 1.0.0
     */
    public $custom_post;

	/**
     * metabox
     *@since 1.0.0
     */
    public $metabox;

    /**
     * shortcode
     *@since 1.0.0
     */
    public $shortcode;

    /**
     * ajax
     *@since 1.0.0
     */
    public $ajax;

    /**
     * ajax
     *@since 1.0.0
     */
    public $migration;

    /**
     * Main post_grid_and_carousel_ultimate Instance.
     *
     *
     * @since 1.0
     * @static
     * @static_var array $instance
     * @uses instanceof::adl_constants() Setup the constants needed.
     * @uses instanceof::wcpcsu_include() Include the required files.
     * @uses instanceof::wcpcsu_load_textdomain() load the language files.
     * @return object|post_grid_and_carousel_ultimate The one true post_grid_and_carousel_ultimate
     */
    public static function instance() {
        if(!isset(self::$instance) && !(self::$instance instanceof post_grid_and_carousel_ultimate)) {
            self::$instance = new post_grid_and_carousel_ultimate;

            self::$instance->adl_constants();
			self::$instance->include_files();

			self::$instance->custom_post = new PGCU_Custom_Post();
			self::$instance->metabox     = new PGCU_Metabox();
            self::$instance->shortcode   = new PGCU_Shortcode();
            self::$instance->ajax        = new PGCU_Ajax();
            self::$instance->migration   = new PGCU_Migration();

			add_action( 'admin_enqueue_scripts', array( self::$instance, 'load_admin_file') );
            add_action( 'template_redirect', array( self::$instance, 'template_enqueue_file') );
			add_action( 'plugin_loaded', array( self::$instance, 'load_textdomain' ) );
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( self::$instance, 'pro_version_plugin_link') );

            // enqueue for elementor 
            add_action( 'elementor/preview/enqueue_styles', [ self::$instance, 'elementor_enqueue_preview_style' ] );
            add_action( 'elementor/preview/enqueue_scripts', [ self::$instance, 'elementor_preview_enqueue_script' ] );

            add_action( 'enqueue_block_editor_assets', [ self::$instance, 'enqueue_block_editor_assets' ] );

            add_action( 'admin_menu', array( self::$instance, 'upgrade_support_submenu_pages_for_gc') );
            add_action( 'wp_head',  array( self::$instance, 'track_post_views') );

            if( empty( get_option('pgcu_migrate_serialize_to_json') ) ) {
                add_action( 'admin_init', array( self::$instance, 'migrate_serialize_data') );
            }

            // if( empty( get_option('pgcu_dismiss_notice') ) ) {
            //     add_action( 'admin_notices', array( self::$instance, 'admin_notices') );
            // }
            // Initialize appsero tracking
            self::$instance->init_appsero();
        }

        return self::$instance;
    }

    public function migrate_serialize_data() {
            
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $args = array(
            'post_type'      => PGCU_POST_TYPE,
            'post_status'    => 'any',
            'posts_per_page' => -1,
        );

        $query = new WP_Query( $args );
        
        // Check if there are posts in the query
        if ( $query->have_posts() ) {
            // Loop through each post
            while ( $query->have_posts() ) {
                $query->the_post();
                $wcpscu_data = get_post_meta( get_the_ID(), 'gc', true );
                
                if ( ! empty( $wcpscu_data ) && ! is_json_encoded( $wcpscu_data ) ) {
                    $unserialized_data = unserialize( base64_decode( $wcpscu_data ) );
                    
                    $json_decode_data = self::json_encoded( $unserialized_data );
                    update_post_meta( get_the_ID(), 'gc', $json_decode_data );
                }
            }

            // Restore the global post data
            wp_reset_postdata();
        }
        update_option( 'pgcu_migrate_serialize_to_json', true );

    }

    /**
     * Setup plugin constants.
     * @access public
     * @since 1.0
     * @return void
     */
    public function adl_constants() {
        if( ! defined('ABSPATH')) { die( 'direct browsing can not possible'); }
		if( ! defined('PGCU_TEXTDOMAIN')) { define('PGCU_TEXTDOMAIN','post-grid-and-carousel-ultimate'); }
		if( ! defined('PGCU_POST_TYPE')) { define('PGCU_POST_TYPE','adl-shortcode'); }
		// Plugin Folder Path.
        if ( ! defined( 'PGCU_DIR' ) ) { define( 'PGCU_DIR', plugin_dir_path( __FILE__ ) ); }
        // Plugin Folder URL.
        if ( ! defined( 'PGCU_URL' ) ) { define( 'PGCU_URL', plugin_dir_url( __FILE__ ) ); }
        // Plugin Root File.
        if ( ! defined( 'PGCU_FILE' ) ) { define( 'PGCU_FILE', __FILE__ ); }
        if ( ! defined( 'PGCU_BASE' ) ) { define( 'PGCU_BASE', plugin_basename( __FILE__ ) ); }
        // Plugin Includes Path
        if ( ! defined('PGCU_INC_DIR') ) { define('PGCU_INC_DIR', PGCU_DIR.'includes/'); }
        // Plugin Language File Path
        if ( ! defined('PGCU_LANG_DIR') ) { define('PGCU_LANG_DIR', dirname(plugin_basename( __FILE__ ) ) . '/languages'); }
    }

	//method for pro version link
	public function pro_version_plugin_link( $links ) {

		$links[] = '<a href="https://wpwax.com/product/post-grid-carousel-ultimate-pro/" target="_blank">Pro Version</a>';
         return $links;
	}

    public function admin_notices() {
        global $pagenow, $typenow;
        if ( 'index.php' == $pagenow || 'plugins.php' == $pagenow || 'adl-shortcode' == $typenow ) {
            require_once PGCU_INC_DIR . 'notice.php';
        }
    }

    /**
     * plugin text domain
     */
    public function load_textdomain() {
        load_plugin_textdomain( PGCU_TEXTDOMAIN, false, PGCU_LANG_DIR );
    }

    public function set_post_views($postID) {
    /*@todo; add option to verify the user using his/her IP address so that reloading the page multiple times by the same user does not increase his post view of the same post on the same day.*/
        $count_key = '_pgcu_post_views_count';
        $count = get_post_meta( $postID, $count_key, true );
        if('' == $count){
            delete_post_meta( $postID, $count_key );
            add_post_meta( $postID, $count_key, '0' );
        }else{
            $count++;
            update_post_meta( $postID, $count_key, $count );
        }
    
    }

    /**
     * Track the posts view to show popular posts based on number of views
     * @param $postID
     */
    public function track_post_views( $postID ) {
        // vail if user is logged in or if the post is not single.
        if ( ! is_single() || is_user_logged_in() ) return;

        if ( empty ( $postID ) ) {
            global $post;
            $postID = $post->ID;
        }
        $this->set_post_views( $postID );
    }

    public function upgrade_support_submenu_pages_for_gc() {
        add_submenu_page( 'edit.php?post_type=adl-shortcode', esc_html__('Support', PGCU_TEXTDOMAIN), esc_html__('Usage & Support', PGCU_TEXTDOMAIN), 'manage_options', 'support', array( $this, 'support_view' ) );
    }

    public function support_view() {
        require_once PGCU_INC_DIR . 'support.php';
    }

    /**
     * include all require files
     *
     * @access private
     * @since 1.0.0
     * @return void
     */
    public function include_files(){

		require_once PGCU_INC_DIR . 'helper.php';
        require_once PGCU_INC_DIR . 'gutenberg/init.php';
        require_once PGCU_INC_DIR . 'elementor/init.php';
        pgcu_load_dependencies( 'all', PGCU_INC_DIR . 'classes/' );
    }

    public function load_admin_file () {
        global $typenow, $pagenow;

        if( $typenow == PGCU_POST_TYPE ) {
            wp_enqueue_script('admin-js',PLUGINS_URL('admin/admin.js',__FILE__),array('jquery'));
			wp_enqueue_script( 'adl_color_js', PLUGINS_URL( 'admin/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ) );
			wp_enqueue_style('admin-css',PLUGINS_URL('admin/admin.css',__FILE__));
			wp_enqueue_style('wp-color-picker');

            wp_localize_script( 'admin-js', 'pgcu_ajax', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ), // WordPress AJAX
                
            ) );
        }

        if ( 'index.php' == $pagenow || 'plugins.php' == $pagenow || 'adl-shortcode' == $typenow ) {
            wp_enqueue_style('admin-notice',PLUGINS_URL('admin/notice.css',__FILE__));
        }

    }

    /**
     * Initialize appsero tracking.
     *
     * @see https://github.com/Appsero/client
     *
     * @return void
     */
    public function init_appsero() {
        if ( ! class_exists( '\Appsero\Client' ) ) {
            require_once PGCU_INC_DIR . 'appsero/src/Client.php';
        }

        $client = new \Appsero\Client( '21cc659b-3127-480c-96a4-ece7f6a18a57', 'Post Grid & Carousel Ultimate', __FILE__ );

        // Active insights
        $client->insights()->init();
    }

    public function template_enqueue_file () {
        
        wp_enqueue_style( 'pgcu-main', PGCU_URL . 'assets/css/style.css' );
        wp_enqueue_style( 'pgcu-swiper-css', PGCU_URL . 'assets/css/swiper-bundle.min.css' );
        wp_enqueue_script( 'pgcu-ajax', PGCU_URL . 'assets/js/ajax.js', array('jquery'), '', true );
        wp_enqueue_script( 'pgcu-swiper', PGCU_URL . 'assets/js/swiper-bundle.min.js', array('jquery') );
        wp_enqueue_script( 'pgcu-main-js', PGCU_URL . 'assets/js/main.js', array('jquery') );

    }

    public function elementor_enqueue_preview_style() {
        wp_enqueue_style( 'pgcu-main', PGCU_URL . 'assets/css/style.css' );
        wp_enqueue_style( 'pgcu-swiper-css', PGCU_URL . 'assets/css/swiper-bundle.min.css' );
    }

    public function elementor_preview_enqueue_script() {
        wp_enqueue_script( 'pgcu-macy', PGCU_URL . 'assets/js/macy.min.js', array('jquery'), '', true );
        wp_enqueue_script( 'pgcu-swiper', PGCU_URL . 'assets/js/swiper-bundle.min.js', array('jquery') );
        wp_enqueue_script( 'pgcu-main-js', PGCU_URL . 'assets/js/main.js', array('jquery'), '', true );
        wp_enqueue_script( 'pgcu-ajax', PGCU_URL . 'assets/js/ajax.js', array('jquery'), '', true );
    }

    public function enqueue_block_editor_assets() {
        wp_enqueue_style( 'pgcu-block-editor', PGCU_URL . 'admin/block-editor.css' );
    }

    /**
     * Encodes a PHP value into its JSON representation.
     * @param $data
     * @return string
     */
    public static function json_encoded( $data ) {
        return json_encode( $data );
    }

    /**
     * Decodes a JSON-encoded string into a PHP associative array.
     * @param string $data The JSON-encoded string to be decoded.
     * @return array Returns the decoded PHP associative array on success, or an empty array on failure.
     */
    public static function json_decoded( $data ) {
    
        $decoded_data = json_decode( $data, true );

        
        if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded_data ) ) {
            return $decoded_data;
        } else {
            return array();
        }
    }

} //end of class

function PGCU() {
    return post_grid_and_carousel_ultimate::instance();
}

PGCU();

function pgcu_image_cropping( $attachmentId, $width, $height, $crop = true, $quality = 100 )
{
    $resizer = new PGCU_Image_Resizer( $attachmentId );

    return $resizer->resize( $width, $height, $crop, $quality );
}
