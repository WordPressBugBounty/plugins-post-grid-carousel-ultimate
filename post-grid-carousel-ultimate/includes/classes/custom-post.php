<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PGCU_Custom_Post
{
	public function __construct() {
		//hook for custom post
		add_action( 'init', array( $this,'gc_adl_custom_post_type') );

		// shortcode column list
		add_filter( 'manage_'.PGCU_POST_TYPE.'_posts_columns', array( $this, 'gc_adl_new_post_shortcord_columns' ) );
		add_action( 'manage_'.PGCU_POST_TYPE.'_posts_custom_column', array( $this, 'gc_adl_manage_shortcode_columns' ), 10, 2 );
	}

	//method for custom post type
	public function gc_adl_custom_post_type() {

		$shortcode_label = array(
			'name'               => _x( 'Shortcodes', 'post type general name', PGCU_TEXTDOMAIN ),
			'singular_name'      => _x( 'Shortcode', 'post type singular name', PGCU_TEXTDOMAIN ),
			'menu_name'          => _x( 'Post Grid & Carousel', 'admin menu', PGCU_TEXTDOMAIN ),
			'name_admin_bar'     => _x( 'Shortcode', 'add new on admin bar', PGCU_TEXTDOMAIN ),
			'add_new'            => _x( 'New Grid/Carousel', 'Shortcode', PGCU_TEXTDOMAIN ),
			'add_new_item'       => __( 'New Grid/Carousel', PGCU_TEXTDOMAIN ),
			'new_item'           => __( 'New Grid/Carousel', PGCU_TEXTDOMAIN ),
			'edit_item'          => __( 'Edit Post Grid/Carousel', PGCU_TEXTDOMAIN ),
			'view_item'          => __( 'View Post Grid/Carousel', PGCU_TEXTDOMAIN ),
			'all_items'          => __( 'All Grid/Carousel', PGCU_TEXTDOMAIN ),
			'search_items'       => __( 'Search Shortcodes', PGCU_TEXTDOMAIN ),
			'parent_item_colon'  => __( 'Parent Shortcodes:', PGCU_TEXTDOMAIN ),
			'not_found'          => __( 'No Shortcodes found.', PGCU_TEXTDOMAIN ),
			'not_found_in_trash' => __( 'No Shortcodes found in Trash.', PGCU_TEXTDOMAIN )
		);

		$short_args = array(
			'labels'             => $shortcode_label,
			'description'        => __( 'Description.', PGCU_TEXTDOMAIN ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => PGCU_POST_TYPE ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array('title'),
			'menu_icon'		     => 'dashicons-schedule'
		);

		register_post_type( PGCU_POST_TYPE, $short_args );

	}

	//method for shortcode columns
	public function gc_adl_new_post_shortcord_columns( $columns ) {
		$columns = array();
		$columns['cb']   = '<input type="checkbox" />';
		$columns['title']   = esc_html__('Post Name', PGCU_TEXTDOMAIN);
		$columns['post_grid_carousel_sc_1']   = esc_html__('Post Shortcode', PGCU_TEXTDOMAIN);
		$columns['date']   = esc_html__('Created at', PGCU_TEXTDOMAIN);
		return $columns;
	}

	/// method for shortcode column list
	public function gc_adl_manage_shortcode_columns( $column_name, $post_id ) {
		switch( $column_name ){
			case 'post_grid_carousel_sc_1': ?>
				<textarea  style="background:#0074A8; color:#fff;" rows="1" onClick="this.select();" >[pgcu id="<?php echo esc_attr( $post_id );?>"]</textarea>
				<?php
				break;

			default:
				break;

		}
	}
}
