<?php
defined('ABSPATH') || die('Direct access is not allow');

class PGCU_Migration
{
    public function __construct ()
    {
       // add_action( 'admin_init', array( $this, 'migrate_custom_post' ) );
    }

    public function migrate_custom_post() {
        
        $old_posts = get_posts( array( 'post_type'        => 'adl-shortcode' ) );
        $migration = get_option( 'pgcu_migration' );

        if( empty( $migration ) && ! empty( $old_posts ) ) {

            foreach( $old_posts as $old_post ) {

                $get_meta = get_post_meta( $old_post->ID, 'gc', true );
                $new_meta      = $get_meta;
                if( ! empty( $get_meta['g_theme'] ) ) {

                    $grid_theme_number = trim( $get_meta['g_theme'], 'theme_' );
                    $carousel_theme_number = trim( $get_meta['c_theme'], 'theme_' );

                    if( 'grid' == $get_meta['layout'] ) {
                        $new_meta['theme'] = 'theme-' . $grid_theme_number;
                    }elseif( 'carousel' == $get_meta['layout'] ) {
                        $new_meta['theme'] = 'theme-' . $carousel_theme_number;
                    }
                    
                }

                $new_meta['display_title']                       = empty( $get_meta['post_title'] ) ? 'yes' : 'no';
                $new_meta['display_content']                     = empty( $get_meta['post_content'] ) ? 'yes' : 'no';
                $new_meta['display_author']                      = empty( $get_meta['post_author_name'] ) ? 'yes' : 'no';
                $new_meta['display_date']                        = empty( $get_meta['post_date'] ) ? 'yes' : 'no';
                $new_meta['display_term']                        = empty( $get_meta['post_category'] ) ? 'yes' : 'no';
                $new_meta['display_read_more']                   = empty( $get_meta['read_more'] ) ? 'yes' : 'no';
                $new_meta['sortable_menu_text_color']            = ! empty( $get_meta['grid_menu_text'] ) ? $get_meta['grid_menu_text'] : '';
                $new_meta['sortable_menu_active_back_color']     = ! empty( $get_meta['grid_active_back'] ) ? $get_meta['grid_active_back'] : '';
                $new_meta['sortable_menu_active__text_color']    = ! empty( $get_meta['grid_active_text'] ) ? $get_meta['grid_active_text'] : '';
                $new_meta['display_pagination']                 = empty( $get_meta['pagi_hide'] ) ? 'yes' : 'no';
                $new_meta['pagi_color']                          = ! empty( $get_meta['pagi_text_color'] ) ? $get_meta['pagi_text_color'] : '';
                $new_meta['pagi_hover_color']                    = ! empty( $get_meta['pagi_text_hover_color'] ) ? $get_meta['pagi_text_hover_color'] : '';
                $new_meta['pagi_active_color']                   = ! empty( $get_meta['pagi_text_active_color'] ) ? $get_meta['pagi_text_active_color'] : '';
                $new_meta['pagi_active_back_color']              = ! empty( $get_meta['pagi_active_back_color'] ) ? $get_meta['pagi_active_back_color'] : '';

                update_post_meta( $old_post->ID, 'gc', post_grid_and_carousel_ultimate::json_encoded( $new_meta ) );
                
                
            }
           
            
        }

        update_option( 'pgcu_migration', true );

    }

   
}