<?php

if( !defined('ABSPATH')) { die('Direct access not allow');}


	class PGCU_Shortcode
	{

		public function __construct() {
			//add shortcode hoke
			add_shortcode( "pgcu", array( $this,"shortcode_for_post_grid_carousel") );
			add_shortcode( "PGCU", array( $this,"shortcode_for_post_grid_carousel") );
			add_shortcode( "post_grid_carousel", array( $this,"shortcode_for_post_grid_carousel") );

		}

		//method for shortcode
		public function shortcode_for_post_grid_carousel($atts, $content) {

			ob_start();
			$atts = shortcode_atts(
				array(
					'id'						=>'',
					'layout'            		=> '',
            		'theme'                     => '',
					'display_header_title'      => '',
					'header_title'              => '',
					'header_position'			=> '',
					'display_title'             => '',
					'post_type'             	=> '',
					'post_from'             	=> '',
					'total_posts'             	=> '',
					'display_content'           => '',
					'content_word_limit'        => '',
					'display_read_more'         => '',
					'read_more_type'            => '',
					'display_author'            => '',
					'display_date'             	=> '',
					'display_term'             	=> '',
					'term_from'             	=> '',
					'g_column'             		=> '',
					'g_tablet'             		=> '',
					'g_mobile'             		=> '',
					'display_pagination'        => '',
					'pagination_type'           => '',
					'autoplay'             		=> '',
					'repeat_post'             	=> '',
					'pause_hover'             	=> '',
					'marquee'           		=> '',
					'post_column'        		=> '',
					'post_column_laptop'        => '',
					'post_column_tablet'        => '',
					'post_column_mobile'        => '',
					'c_autoplay_speed'          => '',
					'c_autoplay_time'           => '',
					'scrool_direction'          => '',
					'navigation'             	=> '',
					'navigation_position'       => '',
					'g_sort'					=> '',
					'image_resize_crop'         => '',
					'image_width'       		=> '',
					'image_hight'				=> '',
				), $atts );

			$post_id =  ! empty( $atts['id'] ) ? $atts['id'] : '';
			$data 	 = get_post_meta( $post_id, 'gc', true );
			$data    = ! is_array( $data ) ? post_grid_and_carousel_ultimate::json_decoded( $data ) : $data;
			$value   = is_array( $data ) ? $data : array();
			extract( $value );

			$rand = rand();

            $layout            = ! empty( $layout ) ? $layout : 'carousel';
			$theme             = ! empty( $theme ) ? $theme : 'theme-1';

			$post_type            = ! empty( $post_type ) ? $post_type : 'post';
			$term_from            = ! empty( $term_from ) ? $term_from : 'category';
			$display_term         = ! empty( $display_term ) ? $display_term : 'yes';
			$display_title        = ! empty( $display_title ) ? $display_title : 'yes';
			$display_header_title = ! empty( $display_header_title ) ? $display_header_title : 'no';
			$header_title         = ! empty( $header_title ) ? $header_title : '';
			$display_content      = ! empty( $display_content ) ? $display_content : 'yes';
			$content_word_limit   = ! empty( $content_word_limit ) ? $content_word_limit : '16';
			$display_read_more    = ! empty( $display_read_more ) ? $display_read_more : 'yes';
			$read_more_text       = ! empty( $read_more_text ) ? $read_more_text : 'Read More';
			$read_more_type       = ! empty( $read_more_type ) ? $read_more_type : 'link';
			$display_author       = ! empty( $display_author ) ? $display_author : 'yes';
			$display_date         = ! empty( $display_date   ) ? $display_date   : 'yes';
			$post_from            = ! empty( $post_from   ) ? $post_from   : '';
			$total_posts          = ! empty( $total_posts   ) ? $total_posts   : 12;

			$image_resize_crop = ! empty( $image_resize_crop ) ? $image_resize_crop : "yes";
			$image_width	   = ! empty( $image_width ) ? $image_width : 300;
			$image_hight	   = ! empty( $image_hight ) ? $image_hight : 290;
			
			$navigation              		=   ! empty( $navigation  ) ? $navigation  : 'yes';
			$navigation_position     		=   ! empty( $navigation_position  ) ? $navigation_position  : 'middle';
			$navigation_arrow_color	 		=	! empty( $navigation_arrow_color ) ? $navigation_arrow_color : '#030517';
			$navigation_arrow_hover_color	=	! empty( $navigation_arrow_hover_color ) ? $navigation_arrow_hover_color : '#fff';
			$navigation_back_color			=	! empty( $navigation_back_color ) ? $navigation_back_color : '#f5f5f5';
			$navigation_back_hover_color	=	! empty( $navigation_back_hover_color ) ? $navigation_back_hover_color : '#F31C1C';
			$navigation_border_color		=	! empty( $navigation_border_color ) ? $navigation_border_color : '#f5f5f5';
			$navigation_border_hover_color	=	! empty( $navigation_border_hover_color ) ? $navigation_border_hover_color : '#F31C1C';

			$autoplay                =   ! empty( $autoplay ) ? $autoplay : 'yes';
			$pause_hover             =   ! empty( $pause_hover ) ? $pause_hover : 'no';
			$repeat_post             =   ! empty( $repeat_post ) ? $repeat_post : 'yes';
			$c_autoplay_speed 		 =	 ! empty( $c_autoplay_speed ) ? $c_autoplay_speed : '2000';
			$c_autoplay_time 		 =	 ! empty( $c_autoplay_time ) ? $c_autoplay_time : '2000';
			
			$post_column             =   ! empty( $post_column ) ? $post_column : '3';
			$post_column_laptop      =   ! empty( $post_column_laptop ) ? $post_column_laptop : '3';
			$post_column_tablet      =   ! empty( $post_column_tablet ) ? $post_column_tablet : '2';
			$post_column_mobile      =   ! empty( $post_column_mobile ) ? $post_column_mobile : '1';

			$g_column                   = ! empty( $g_column   ) ? $g_column   : '3';
			$g_tablet                   = ! empty( $g_tablet   ) ? $g_tablet   : '2';
			$g_mobile                   = ! empty( $g_mobile   ) ? $g_mobile   : '1';

			//grid pagination settings
			$display_pagination         = ! empty( $display_pagination   ) ? $display_pagination   : 'yes';
			$pagi_color                 = ! empty( $pagi_color ) ? $pagi_color : '#333';
			$pagi_border_color          = ! empty( $pagi_border_color ) ? $pagi_border_color : '#e4e4e4';
			$pagi_back_color            = ! empty( $pagi_back_color ) ? $pagi_back_color : '#fff';
	
			$pagi_hover_color           = ! empty( $pagi_hover_color ) ? $pagi_hover_color : '#fff';
			$pagi_hover_border_color    = ! empty( $pagi_hover_border_color ) ? $pagi_hover_border_color : '#ff5500';
			$pagi_hover_back_color      = ! empty( $pagi_hover_back_color ) ? $pagi_hover_back_color : '#ff5500';
			$pagi_active_color          = ! empty( $pagi_active_color ) ? $pagi_active_color : '#fff';
			$pagi_active_border_color   = ! empty( $pagi_active_border_color ) ? $pagi_active_border_color : '#ff5500';
			$pagi_active_back_color     = ! empty( $pagi_active_back_color ) ? $pagi_active_back_color : '#ff5500';

			$sortable_menu_text_color		    = ! empty( $sortable_menu_text_color ) ? $sortable_menu_text_color : '#4F515A';
			$sortable_menu_active_back_color	= ! empty( $sortable_menu_active_back_color ) ? $sortable_menu_active_back_color : '#030213';
			$sortable_menu_active__text_color 	= ! empty( $sortable_menu_active__text_color ) ? $sortable_menu_active__text_color : '#ffffff';
			
			$header_title_color 		= ! empty( $header_title_color ) ? $header_title_color : '#030213';
			$post_title_color 				       = ! empty( $post_title_color ) ? $post_title_color : '#030213';
			$post_title_hover_color 		       = ! empty( $post_title_hover_color ) ? $post_title_hover_color : '#F31C1C';
			$post_content_color 	    	  	   = ! empty( $post_content_color ) ? $post_content_color : '#63666D';
			$read_more_color 	    		  	   = ! empty( $read_more_color ) ? $read_more_color : '#030213';
			$read_more_hover_color 	    	  	   = ! empty( $read_more_hover_color ) ? $read_more_hover_color : '#F31C1C';
			$read_more_button_color     	  	   = ! empty( $read_more_button_color ) ? $read_more_button_color : '#030213';
			$read_more_button_hover_color     	   = ! empty( $read_more_button_hover_color ) ? $read_more_button_hover_color : '#ffffff';
			$read_more_button_background_color     = ! empty( $read_more_button_background_color ) ? $read_more_button_background_color : '#EFEFEF';
			$read_more_button_background_hover_color     = ! empty( $read_more_button_background_hover_color ) ? $read_more_button_background_hover_color : '#030213';

			// shortcode $atts 
			$layout             			  = ! empty( $atts['layout'] ) ? $atts['layout'] : $layout;
			$theme              			  = ! empty( $atts['theme'] ) ? $atts['theme'] : $theme;
			$display_header_title             = ! empty( $atts['display_header_title'] ) ? $atts['display_header_title'] : $display_header_title;
			$header_position 	   			  = ! empty( $atts['header_position'] ) ? $atts['header_position'] : 'middle';
			$header_title             		  = ! empty( $atts['header_title'] ) ? $atts['header_title'] : $header_title;
			$display_title             		  = ! empty( $atts['display_title'] ) ? $atts['display_title'] : $display_title;
			$post_type             		  	  = ! empty( $atts['post_type'] ) ? $atts['post_type'] : $post_type;
			$post_from             		  	  = ! empty( $atts['post_from'] ) ? $atts['post_from'] : $post_from;
			$total_posts             		  = ! empty( $atts['total_posts'] ) ? $atts['total_posts'] : $total_posts;
			$display_content             	  = ! empty( $atts['display_content'] ) ? $atts['display_content'] : $display_content;
			$content_word_limit               = ! empty( $atts['content_word_limit'] ) ? $atts['content_word_limit'] : $content_word_limit;
			$display_read_more             	  = ! empty( $atts['display_read_more'] ) ? $atts['display_read_more'] : $display_read_more;
			$read_more_type             	  = ! empty( $atts['read_more_type'] ) ? $atts['read_more_type'] : $read_more_type;
			$display_author             	  = ! empty( $atts['display_author'] ) ? $atts['display_author'] : $display_author;
			$display_date             		  = ! empty( $atts['display_date'] ) ? $atts['display_date'] : $display_date;
			$display_term             		  = ! empty( $atts['display_term'] ) ? $atts['display_term'] : $display_term;
			$term_from             		  	  = ! empty( $atts['term_from'] ) ? $atts['term_from'] : $term_from;
			$g_column             		  	  = ! empty( $atts['g_column'] ) ? $atts['g_column'] : $g_column;
			$g_tablet             		  	  = ! empty( $atts['g_tablet'] ) ? $atts['g_tablet'] : $g_tablet;
			$g_mobile             		  	  = ! empty( $atts['g_mobile'] ) ? $atts['g_mobile'] : $g_mobile;
			$display_pagination            	  = ! empty( $atts['display_pagination'] ) ? $atts['display_pagination'] : $display_pagination;
			$autoplay             		  	  = ! empty( $atts['autoplay'] ) ? $atts['autoplay'] : $autoplay;
			$repeat_post             		  = ! empty( $atts['repeat_post'] ) ? $atts['repeat_post'] : $repeat_post;
			$pause_hover             		  = ! empty( $atts['pause_hover'] ) ? $atts['pause_hover'] : $pause_hover;
			$post_column               		  = ! empty( $atts['post_column'] ) ? $atts['post_column'] : $post_column;
			$post_column_laptop            	  = ! empty( $atts['post_column_laptop'] ) ? $atts['post_column_laptop'] : $post_column_laptop;
			$post_column_tablet            	  = ! empty( $atts['post_column_tablet'] ) ? $atts['post_column_tablet'] : $post_column_tablet;
			$post_column_mobile               = ! empty( $atts['post_column_mobile'] ) ? $atts['post_column_mobile'] : $post_column_mobile;
			$c_autoplay_speed             	  = ! empty( $atts['c_autoplay_speed'] ) ? $atts['c_autoplay_speed'] : $c_autoplay_speed;
			$c_autoplay_time             	  = ! empty( $atts['c_autoplay_time'] ) ? $atts['c_autoplay_time'] : $c_autoplay_time;
			$navigation             		  = ! empty( $atts['navigation'] ) ? $atts['navigation'] : $navigation;
			$navigation_position              = ! empty( $atts['navigation_position'] ) ? $atts['navigation_position'] : $navigation_position;
			$image_resize_crop                = ! empty( $atts['image_resize_crop'] ) ? $atts['image_resize_crop'] : $image_resize_crop;
			$image_width              		  = ! empty( $atts['image_width'] ) ? $atts['image_width'] : $image_width;
			$image_hight              		  = ! empty( $atts['image_hight'] ) ? $atts['image_hight'] : $image_hight;

			$post_from 		  = ! empty( $post_from ) ? $post_from : 'latest';
			$paged 			  = pgcu_get_paged_num();
				
			$g_sort           = ! empty( $g_sort    ) ? $g_sort    : 'category';
			$terms			   = get_terms( array(
				'taxonomy' => $g_sort,
				'hide_empty' => false,
			) );


			$args = array();
		    $common_args = [
		        'post_type'      => $post_type,
		        'posts_per_page' => ( ! empty( $total_posts ) ? $total_posts : -1 ),
		        'status' 		 => 'published',
		        'paged'			 => $paged

		    ];
		    if ( 'latest' == $post_from ) { $args = $common_args; }
		    elseif ('older' == $post_from) {
		        $older_args = [
		            'orderby'   => 'date',
		            'order'     => 'ASC',
		        ];
		        $args = array_merge($common_args, $older_args);
		    }else {
		        $args = $common_args;
		    }

		    $posts = new WP_Query( $args );

			wp_localize_script( 'pgcu-ajax', 'pgcu_ajax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ), // WordPress AJAX
				'query'   => json_encode( $posts->query_vars ), // everything about your loop is here
			) );

			$header_class = '';

			if( 'middle' == $header_position ) {
				$header_class = 'pgcu-posts__header--middle';
			} elseif( 'right' == $header_position ) {
				$header_class = 'pgcu-posts__header--right';
			}

			if( $posts->have_posts() ) { ?>
				<?php if( 'yes' == $display_header_title ) { ?>
				<div class="pgcu-posts__header <?php echo $header_class; ?>" style="
					--pgcu-headerFontSize: 24px;
    				--pgcu-headerFontColor: <?php echo esc_attr( $header_title_color ); ?>;
				">
					<h2><?php echo esc_html( $header_title ); ?></h2>
				</div>
				<?php } ?>
				<div class="pgcu-posts pgcu-<?php echo esc_attr( $theme ); ?> <?php echo ( 'carousel' == $layout ) ? 'pgcu-carousel' : ''; ?>"
				<?php if( 'carousel' == $layout ) { ?>
					data-pgcu-items="4"
					data-pgcu-margin="30"
					data-pgcu-loop="<?php echo ( 'yes' == $repeat_post ) ? 'true' : 'false'; ?>"
					data-pgcu-perslide="2"
					data-pgcu-speed="<?php echo esc_attr( $c_autoplay_speed ); ?>"
					data-pgcu-autoplay='
					<?php if( 'yes' == $autoplay ) { ?>
					{
						"delay": "<?php echo esc_attr( $c_autoplay_time ); ?>",
						"pauseOnMouseEnter": <?php echo ( 'yes' == $pause_hover ) ? "true" : "false"; ?>,
						"disableOnInteraction": false,
						"stopOnLastSlide": true,
						"reverseDirection": false
					}
					<?php } else { ?>
						false
					<?php } ?>
				' data-pgcu-responsive='{
						"0": {"slidesPerView": "<?php echo esc_attr( $post_column_mobile ); ?>", "spaceBetween": "20", "slidesPerGroup":"1"},
						"768": {"slidesPerView": "<?php echo esc_attr( $post_column_tablet ); ?>", "spaceBetween": "30", "slidesPerGroup":"1"},
						"992": {"slidesPerView": "<?php echo esc_attr( $post_column_laptop ); ?>", "spaceBetween": "30", "slidesPerGroup":"1"},
						"1200": {"slidesPerView": "<?php echo esc_attr( $post_column ); ?>", "spaceBetween": "30", "slidesPerGroup":"1"}
					}'
				<?php } ?>
				>

					<?php 
					if( 'isotope' == $layout ) {
						include PGCU_INC_DIR . 'templates/sortable/sortable.php';
					} elseif( 'yes' == $navigation && 'carousel' == $layout && ( 'top-left' == $navigation_position || 'top-right' == $navigation_position ) ) {
						include PGCU_INC_DIR . 'templates/navigation/navigation.php';
					}
						
						?>


    				<div class="<?php echo ( 'carousel' == $layout) ? 'swiper-wrapper' : 'pgcu-row pgcu-column-' . esc_attr( $g_column ) . ' pgcu-column-md-' . esc_attr( $g_tablet ) . ' pgcu-column-sm-' . esc_attr( $g_mobile ) . ''; ?>" style="
					--pgcu-titleColor: <?php echo esc_attr( $post_title_color ); ?>;
    				--pgcu-titleColorHover: <?php echo esc_attr( $post_title_hover_color ); ?>;
					--pgcu-excerptColor: <?php echo esc_attr( $post_content_color ); ?>;
					--pgcu-readMoreColor: <?php echo esc_attr( $read_more_color ); ?>;
    				--pgcu-readMoreColorHover: <?php echo esc_attr( $read_more_hover_color ); ?>;
					--pgcu-buttonFontSize: 14px;
					--pgcu-buttonColor: <?php echo esc_attr( $read_more_button_color ); ?>;
					--pgcu-buttonColorHover: <?php echo esc_attr( $read_more_button_hover_color ); ?>;
					--pgcu-buttonBg: <?php echo esc_attr( $read_more_button_background_color ); ?>;
					--pgcu-buttonBgHover: <?php echo esc_attr( $read_more_button_background_hover_color ); ?>;
				">

						<?php 
						while( $posts->have_posts() ) : $posts->the_post();

						$thumb = get_post_thumbnail_id();
						// crop the image if the cropping is enabled.
						if( 'yes' === $image_resize_crop ){
							$pgcu_img = pgcu_image_cropping( $thumb, $image_width, $image_hight, true, 100 )['url'];
						}else{
							$aazz_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'large' );
							$pgcu_img = $aazz_thumb['0'];
						}

						$get_terms  = get_the_terms( get_the_ID(), $term_from );
						$post_views = get_post_meta( get_the_id(), '_pgcu_post_views_count', true );

						include PGCU_INC_DIR . 'templates/' . $theme . '.php';
						
						endwhile;
						?>
						
					</div>

						<?php
						if( 'yes' == $navigation && 'carousel' == $layout && ( 'middle' == $navigation_position || 'bottom-left' == $navigation_position || 'bottom-right' == $navigation_position ) ) {
							include PGCU_INC_DIR . 'templates/navigation/navigation.php';
						}elseif( 'grid' == $layout && 'yes' == $display_pagination ) {
							include PGCU_INC_DIR . 'templates/pagination/pagination.php';
						}
						?>

				</div>


			<?php

			}

			$true = ob_get_clean();
			return $true;
		}



	}//end class

