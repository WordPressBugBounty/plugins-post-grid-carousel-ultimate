<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
class Elementor_Post_Ultimate_Widget extends \Elementor\Widget_Base {

	public function register_controls() {
		$fields = $this->pgcu_fields();
		foreach ( $fields as $field ) {
			if ( isset( $field['mode'] ) && $field['mode'] == 'section_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_section( $id, $field );
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'section_end' ) {
				$this->end_controls_section();
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'tabs_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_tabs( $id );
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'tabs_end' ) {
				$this->end_controls_tabs();
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'tab_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_tab( $id, $field );
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'tab_end' ) {
				$this->end_controls_tab();
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'group' ) {
				$type = $field['type'];
				$field['name'] = $field['id'];
				unset( $field['mode'] );
				unset( $field['type'] );
				unset( $field['id'] );
				$this->add_group_control( $type, $field );
			}
			elseif ( isset( $field['mode'] ) && $field['mode'] == 'responsive' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->add_responsive_control( $id, $field );
			}
			else {
				$id = $field['id'];
				unset( $field['id'] );
				$this->add_control( $id, $field );
			}
		}
	}

	public function custom_post_type() {
		$custom_posts = get_post_types( array(
			'public'	=>	true,
			) );
		$exclude    = array( 'adl-shortcode','attachment', 'revision', 'nav_menu_item' );

		foreach ( $exclude as $ex ) {
			unset( $custom_posts[ $ex ] );
		}
		$html = "";
		if( ! empty( $custom_posts ) ) {
			ob_start();
			foreach( $custom_posts as $value ){
				
				?>
				<option value="<?php echo esc_attr( $value );?>"><?php echo esc_html( $value );?></option>
				<?php
				
			}
			$html = ob_get_clean();
		}
		return $html;
	}

	public function custom_term_type() {
		//$settings 	= $this->get_settings();
		$post_type 	= ! empty( $settings['post_type'] ) ? $settings['post_type'] : 'post';
		$terms 		= get_taxonomies();

		$html = "";
		if( $terms ) {
			ob_start();
			foreach( $terms as $term ) {
			?>
			<option value="<?php echo esc_attr( $term ); ?>"><?php echo esc_html( $term ); ?></option>
			<?php
			}
			$html = ob_get_clean();
		}

		return $html;
	}

	public function pgcu_fields() {
		$fields = array(
			//layout section
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'Layout', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'layout',
				'label'   => __( 'Layout', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'carousel' => __( 'Carousel', 'post-grid-carousel-ultimate' ),
					'grid' 		=> __( 'Grid', 'post-grid-carousel-ultimate' ),
					'isotope' 	=> __( 'Sortable Grid', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'carousel',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'theme',
				'label'   => __( 'Theme', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'theme-1' => __( 'Theme 1', 'post-grid-carousel-ultimate' ),
					'theme-2' => __( 'Theme 2', 'post-grid-carousel-ultimate' ),
					'theme-3' => __( 'Theme 3', 'post-grid-carousel-ultimate' ),
					'theme-4' => __( 'Theme 4', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'theme-1',
				'separator' => 'after'
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_header_title',
				'label'     => __( 'Display Header', 'post-grid-carousel-ultimate' ),
				'default'   => 'no',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'header_title',
				'label'     => __( 'Title', 'post-grid-carousel-ultimate' ),
				'default'   => '',
				'condition'    => [
					'display_header_title'          => 'yes',
				],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'header_position',
				'label'   => __( 'Header Position', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'left' 		=> __( 'Left', 'post-grid-carousel-ultimate' ),
					'right' 	=> __( 'Right', 'post-grid-carousel-ultimate' ),
					'middle' 	=> __( 'Middle', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'middle',
				'condition'    => [
					'display_header_title'          => 'yes',
				],
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_title',
				'label'     => __( 'Display Product Title', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_query',
				'label'   => __( 'Query', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'post_type',
				'label'   => __( 'Post Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					$this->custom_post_type()
				),
				'default' => 'post',
				'condition'    => [
					'layout!'          => 'isotope',
				],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'post_from',
				'label'   => __( 'Display Post From', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'latest' 		=> __( 'Latest Post', 'post-grid-carousel-ultimate' ),
					'older' 		=> __( 'Older Post', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'latest',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'total_posts',
				'label'     => __( 'Total Posts', 'post-grid-carousel-ultimate' ),
				'default'   => 12,
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_elements',
				'label'   => __( 'Elements', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_content',
				'label'     => __( 'Display Content', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'content_word_limit',
				'label'     => __( 'Content Word Limit', 'post-grid-carousel-ultimate' ),
				'min' 		=> 1,
				'max' 		=> 50,
				'step' 		=> 1,
				'default'   => 16,
				'condition'    => [
					'display_content'    => 'yes',
				],
				'separator' => 'after'
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_read_more',
				'label'     => __( 'Display Read More', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'read_more_type',
				'label'   => __( 'Read More Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'link' 		=> __( 'Link', 'post-grid-carousel-ultimate' ),
					'button' 	=> __( 'Button', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'link',
				'condition'    => [
					'display_read_more'          => 'yes',
				],
				'separator' => 'after'
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_author',
				'label'     => __( 'Display Author Name', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_date',
				'label'     => __( 'Display Date', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_term',
				'label'     => __( 'Display Term', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'term_from',
				'label'   => __( 'Term From', 'post-grid-carousel-ultimate' ),
				'options' => array(
					$this->custom_term_type(),
				),
				'default' => 'category',
				'condition'    => [
					'display_term'          => 'yes',
				],
				'separator' => 'after'
			),
			
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_carousel',
				'label'   => __( 'Carousel', 'post-grid-carousel-ultimate' ),
				'condition'    => [
					'layout'          => 'carousel',
				],
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'autoplay',
				'label'     => __( 'Auto Play', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'repeat_post',
				'label'     => __( 'Repeat Post', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'pause_hover',
				'label'     => __( 'Pause on Hover', 'post-grid-carousel-ultimate' ),
				'default'   => 'no',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'post_column',
				'label'     => __( 'Post Columns', 'post-grid-carousel-ultimate' ),
				'default'   => 2,
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'post_column_laptop',
				'label'     => __( 'Laptop Columns', 'post-grid-carousel-ultimate' ),
				'default'   => 2,
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'post_column_tablet',
				'label'     => __( 'Tablet Columns', 'post-grid-carousel-ultimate' ),
				'default'   => 2,
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'post_column_mobile',
				'label'     => __( 'Mobile Columns', 'post-grid-carousel-ultimate' ),
				'default'   => 1,
				'separator' => 'after'
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'c_autoplay_speed',
				'label'     => __( 'Slide Speed', 'post-grid-carousel-ultimate' ),
				'default'   => 2000,
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'c_autoplay_time',
				'label'     => __( 'Slide Timeout', 'post-grid-carousel-ultimate' ),
				'default'   => 2000,
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'navigation',
				'label'     => __( 'Navigation', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'navigation_position',
				'label'   => __( 'Position', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'top-left' 		=> __( 'Top Left', 'post-grid-carousel-ultimate' ),
					'top-right' 	=> __( 'Top Right', 'post-grid-carousel-ultimate' ),
					'middle' 		=> __( 'Middle', 'post-grid-carousel-ultimate' ),
					'bottom-left' 	=> __( 'Bottom Left', 'post-grid-carousel-ultimate' ),
					'bottom-right' 	=> __( 'Bottom Right', 'post-grid-carousel-ultimate' ),
				),
				'default' => 'middle',
				'condition'    => [
					'navigation'          => 'yes',
				],
				'separator' => 'after'
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_grid',
				'label'   => __( 'Grid', 'post-grid-carousel-ultimate' ),
				'condition'    => [
					'layout'          => [ 'grid', 'masonry' ],
				],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'g_column',
				'label'   => __( 'Grid Columns', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'1' 	=> __( 'Column-1', 'post-grid-carousel-ultimate' ),
					'2' 	=> __( 'Column-2', 'post-grid-carousel-ultimate' ),
					'3' 	=> __( 'Column-3', 'post-grid-carousel-ultimate' ),
					'4' 	=> __( 'Column-4', 'post-grid-carousel-ultimate' ),
				),
				'default' => '3',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'g_tablet',
				'label'   => __( 'Select Columns for Tablet', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'1' 	=> __( 'Column-1', 'post-grid-carousel-ultimate' ),
					'2' 	=> __( 'Column-2', 'post-grid-carousel-ultimate' ),
					'3' 	=> __( 'Column-3', 'post-grid-carousel-ultimate' ),
					'4' 	=> __( 'Column-4', 'post-grid-carousel-ultimate' ),
				),
				'default' => '2',
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'g_mobile',
				'label'   => __( 'Select Columns for Mobile', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'1' 	=> __( 'Column-1', 'post-grid-carousel-ultimate' ),
					'2' 	=> __( 'Column-2', 'post-grid-carousel-ultimate' ),
					'3' 	=> __( 'Column-3', 'post-grid-carousel-ultimate' ),
					'4' 	=> __( 'Column-4', 'post-grid-carousel-ultimate' ),
				),
				'default' => '1',
				'separator' => 'after'
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'display_pagination',
				'label'     => __( 'Display Pagination', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_image',
				'label'   => __( 'Image', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'image_resize_crop',
				'label'     => __( 'Image Resize & Crop', 'post-grid-carousel-ultimate' ),
				'default'   => 'yes',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'image_width',
				'label'     => __( 'Cropping Width', 'post-grid-carousel-ultimate' ),
				'default'   => 300,
				'condition'    => [
					'image_resize_crop'          => 'yes',
				],
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'image_hight',
				'label'     => __( 'Cropping Height', 'post-grid-carousel-ultimate' ),
				'default'   => 200,
				'condition'    => [
					'image_resize_crop'          => 'yes',
				],
				'separator' => 'after'
			),
			array(
				'mode' => 'section_end',
			),
			// header title style
			array(
				'mode'    => 'section_start',
				'tab'       => Controls_Manager::TAB_STYLE,
				'id'      => 'header_title_tab',
				'label'   => __( 'Header Title', 'post-grid-carousel-ultimate' ),
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'header_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'header_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header h2' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-posts__header' => 'background-color: {{VALUE}}'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'header_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'header_title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-posts__header h2',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'header_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'header_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-posts__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'header_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-posts__header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'header_hover_tab',
				'label'   => __( 'HOVER', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'default'   => '#303030',
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header h2:hover' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-posts__header:hover' => 'background-color: {{VALUE}}'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'header_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header:hover' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'header_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header:hover' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'id'     	=> 'header_hover_title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-posts__header h2:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'header_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-posts__header:hover' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'header_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-posts__header:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'header_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-posts__header:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'tab'       => Controls_Manager::TAB_STYLE,
				'id'      => 'post_title_tab',
				'label'   => __( 'Post Title', 'post-grid-carousel-ultimate' ),
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'title_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'title_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title a' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post__title' => 'background-color: {{VALUE}}'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'title_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post__title a',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'title_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'title_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'title_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'title_hover_tab',
				'label'   => __( 'HOVER', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title a:hover' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post__title:hover' => 'background-color: {{VALUE}} !important'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title:hover' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'title_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title:hover' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'id'     	=> 'title_hover_title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post__title:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'title_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__title:hover' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'title_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__title:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'title_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__title:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),

			array(
				'mode'    => 'section_start',
				'tab'       => Controls_Manager::TAB_STYLE,
				'id'      => 'post_meta_tab',
				'label'   => __( 'Post Meta', 'post-grid-carousel-ultimate' ),
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'meta_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'meta_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta li a' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta li span' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta li svg' => 'fill: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert svg' => 'fill: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert span' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author a' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat' => 'color: {{VALUE}} !important',
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat' => 'background-color: {{VALUE}} !important',
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat' => 'border-color: {{VALUE}} !important',
					],
			),
			array(
				'type'      => Controls_Manager::SLIDER,
				'id'        => 'meta_font_size',
				'label'     => __( 'Font Size', 'post-grid-carousel-ultimate' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta li a' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta li span' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta li svg' => 'width: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert svg' => 'width: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert span' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author a' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-cat' => 'font-size: {{SIZE}}{{UNIT}} !important',
					],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'meta_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta' => 'border-style: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert' => 'border-style: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat' => 'border-style: {{VALUE}} !important',
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'meta_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-post__meta__ert' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-post__meta__author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'meta_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-post__meta__ert' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-post__meta__author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pgcu-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'meta_hover_tab',
				'label'   => __( 'Hover', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta li a:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta li span:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta li svg:hover' => 'fill: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert svg:hover' => 'fill: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert span:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author a:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat a:hover' => 'color: {{VALUE}} !important',
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta:hover' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert:hover' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author:hover' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat:hover' => 'background-color: {{VALUE}} !important',
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'meta_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta:hover' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert:hover' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author:hover' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat:hover' => 'border-color: {{VALUE}} !important',
					],
			),
			array(
				'type'      => Controls_Manager::SLIDER,
				'id'        => 'meta_hover_font_size',
				'label'     => __( 'Font Size', 'post-grid-carousel-ultimate' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta li a:hover' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta li span:hover' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta li svg:hover' => 'width: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert svg:hover' => 'width: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert span:hover' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-post__meta__author a:hover' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .pgcu-cat a:hover' => 'font-size: {{SIZE}}{{UNIT}} !important',
					],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'meta_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__meta:hover' => 'border-style: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post__meta__ert:hover' => 'border-style: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-cat:hover' => 'border-style: {{VALUE}} !important',
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'meta_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__meta:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-post__meta__ert:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-post__meta__author:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-cat:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'meta_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__meta:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-post__meta__ert:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-post__meta__author:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-cat:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'tab'       => Controls_Manager::TAB_STYLE,
				'id'      => 'content_tab',
				'label'   => __( 'Content', 'post-grid-carousel-ultimate' ),
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'content_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'content_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'background-color: {{VALUE}}'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'content_title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'content_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'content_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'content_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'content_hover_tab',
				'label'   => __( 'Hover', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'background-color: {{VALUE}}'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'border-color: {{VALUE}}'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'content_hover_title_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'content_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'border-style: {{VALUE}}'
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'content_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'content_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post__details .pgcu-post__excerpt:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			
			array(
				'mode'    => 'section_start',
				'tab'       => Controls_Manager::TAB_STYLE,
				'id'      => 'read_more_tab',
				'label'   => __( 'Read More', 'post-grid-carousel-ultimate' ),
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'read_more_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'read_more_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-read-more svg' => 'fill: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-read-more' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'read_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'read_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-read-more',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'read_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-read-more',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'read_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'read_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'read_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'read_more_hover_normal_tab',
				'label'   => __( 'HOVER', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-read-more svg:hover' => 'fill: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-read-more:hover' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'read_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'read_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'read_hover_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-read-more:hover',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'read_hover_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-read-more:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'read_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_hover_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'read_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_hover_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'read_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'read_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-read-more:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			
			
			array(
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'id'      => 'quick_view_tab',
				'label'   => __( 'Quick View Button', 'post-grid-carousel-ultimate' ),
				'condition' => [
					'theme' => [ 'theme_8', 'theme_9' ]
				],
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'quick_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'quick_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .wpcu-quick-view-btn' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'quick_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'quick_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .wpcu-quick-view-btn',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'quick_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .wpcu-quick-view-btn',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'quick_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'quick_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'quick_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'quick_hover_normal_tab',
				'label'   => __( 'Hover', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'color: {{VALUE}} !important'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'quick_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'quick_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'quick_hover_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .wpcu-quick-view-btn:hover',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'quick_hover_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .wpcu-quick-view-btn:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'quick_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_hover_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'quick_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_hover_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'quick_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'quick_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .wpcu-quick-view-btn:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'id'      => 'carousel_navigation',
				'label'   => __( 'Navigation', 'post-grid-carousel-ultimate' ),
				'condition' => array( 
					'layout'   => 'carousel',
					'navigation' => 'yes'
				)
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'nav_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'nav_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn svg' => 'fill: {{VALUE}} !important;',
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'nav_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'nav_pagi_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn',
			),
			array(
				'type'      => Controls_Manager::SLIDER,
				'id'        => 'nav_font_size',
				'label'     => __( 'Arrow Font Size', 'post-grid-carousel-ultimate' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn svg' => 'width: {{SIZE}}{{UNIT}} !important'
					],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'nav_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'nav_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'nav_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'nav_hover_tab',
				'label'   => __( 'HOVER', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn svg:hover' => 'fill: {{VALUE}} !important;',
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'nav_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'nav_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'nav_hover_pagi_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover',
			),
			array(
				'type'      => Controls_Manager::SLIDER,
				'id'        => 'nav_hover_font_size',
				'label'     => __( 'Arrow Font Size', 'post-grid-carousel-ultimate' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn svg:hover' => 'width: {{SIZE}}{{UNIT}} !important'
					],
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'nav_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'border-style: {{VALUE}} !important;',
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_hover_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'nav_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_hover_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav .pgcu-carousel-nav__btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'nav_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'nav_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-carousel-nav:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			
			array(
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'id'      => 'grid_pagination_tab',
				'label'   => __( 'Grid Pagination', 'post-grid-carousel-ultimate' ),
				'condition'    => [
					'layout'				=> 'grid',
					'display_pagination'    => 'yes',
				],
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'grid_pagi_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'grid_pagi_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-pagination .page-numbers svg' => 'fill: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_pagi_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_pagi_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'grid_page_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'grid_pagi_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-pagination .page-numbers',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'grid_pagi_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-pagination .page-numbers',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'grid_pagi_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'grid_pagi_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'grid_pagi_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'grid_pagi_hover_tab',
				'label'   => __( 'Hover', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-pagination .page-numbers svg:hover' => 'fill: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_pagi_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'background-color: {{VALUE}} !important;',
				'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'grid_pagi_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'grid_page_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'transition-duration: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'grid_pagi_hover_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selectors' 	=> [ 
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current',
				]
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'grid_pagi_hover_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current',
				],
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'grid_pagi_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'border-style: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'border-style: {{VALUE}} !important;',
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_hover_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'grid_pagi_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_hover_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .pgcu-pagination .nav-links .current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'grid_pagi_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'grid_pagi_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-pagination:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
			
			array(
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'id'      => 'filter_tab',
				'label'   => __( 'Filters', 'post-grid-carousel-ultimate' ),
				'condition'    => [
					'layout'				=> 'isotope',
				],
			),
			array(
				'mode'    => 'tabs_start',
				'id'      => 'filter_style_tab',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'filter_normal_tab',
				'label'   => __( 'NORMAL', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'color: {{VALUE}} !important;',
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'filter_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'filter_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'filter_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'filter_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'filter_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'filter_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode'    => 'tab_start',
				'id'      => 'filter_hover_tab',
				'label'   => __( 'Hover', 'post-grid-carousel-ultimate' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_hover_font_color',
				'label'     => __( 'Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn--active' => 'color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_hover_back_color',
				'label'     => __( 'Background Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
				'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'background-color: {{VALUE}} !important;',
				'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn--active' => 'background-color: {{VALUE}} !important;'
				],
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'filter_hover_border_color',
				'label'     => __( 'Border Color', 'post-grid-carousel-ultimate' ),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn--active' => 'border-color: {{VALUE}} !important;'
					],
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'filter_hover_transition_duration',
				'label'     => __( 'Transition Duration', 'post-grid-carousel-ultimate' ),
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'transition-duration: {{VALUE}} !important',
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn--active' => 'transition-duration: {{VALUE}} !important'
					],
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Box Shadow', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'filter_hover_shadow',
				'type'		=> \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover',
			),
			array(
				'mode'		=> 'group',
				'label'     => __( 'Typography', 'post-grid-carousel-ultimate' ),
				'id'     	=> 'filter_hover_typography',
				'type'		=> Group_Control_Typography::get_type(),
				'selector' 	=> '{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover',
				'scheme' => Typography::TYPOGRAPHY_3,
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'filter_hover_border_type',
				'label'   => __( 'Border Type', 'post-grid-carousel-ultimate' ),
				'options' => array(
					'none' 		=> __( 'None', 'post-grid-carousel-ultimate' ),
					'solid' 	=> __( 'Solid', 'post-grid-carousel-ultimate' ),
					'double' 	=> __( 'Double', 'post-grid-carousel-ultimate' ),
					'dotted' 	=> __( 'Dotted', 'post-grid-carousel-ultimate' ),
					'dashed' 	=> __( 'Dashed', 'post-grid-carousel-ultimate' ),
					'groove' 	=> __( 'Groove', 'post-grid-carousel-ultimate' ),
				),
				'selectors' 	=> [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'border-style: {{VALUE}} !important;',
					
					],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_hover_border_width',
				'label'     	=> __( 'Border Width', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'filter_hover_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_hover_border_radius',
				'label'     	=> __( 'Border Radius', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav .pgcu-post-sortable__btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'filter_border_type!' => 'none',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_hover_padding',
				'label'     	=> __( 'Padding', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode'			=> 'responsive',
				'type'      	=> Controls_Manager::DIMENSIONS,
				'id'        	=> 'filter_hover_margin',
				'label'     	=> __( 'Margin', 'post-grid-carousel-ultimate' ),
				'selectors' => [
					'{{WRAPPER}} .pgcu-post-sortable__nav:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			),
			array(
				'mode' => 'tab_end',
			),
			array(
				'mode' => 'tabs_end',
			),
			array(
				'mode' => 'section_end',
			),
		);
		return $fields;
	}

	public function get_name() {
		return 'post_grid_ultimate';
	}

	public function get_title() {
		return esc_html__( 'Post Grid & Carousel Ultimate', 'post-grid-carousel-ultimate' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'post', 'product', 'grid', 'carousel', 'ultimate' ];
	}

	protected function render() {
		$settings = $this->get_settings();
	
		$atts = array(
			'layout'                		=> sanitize_text_field($settings['layout'] ? $settings['layout'] : 'carousel'),
			'theme'                 		=> sanitize_text_field($settings['theme'] ? $settings['theme'] : 'theme-1'),
			'display_header_title'          => sanitize_text_field($settings['display_header_title'] ? $settings['display_header_title'] : 'no'),
			'header_title'                 	=> sanitize_text_field($settings['header_title'] ? $settings['header_title'] : ''),
			'header_position'				=> sanitize_text_field($settings['header_position'] ? $settings['header_position'] : 'middle'),
			'display_title'                 => sanitize_text_field($settings['display_title'] ? $settings['display_title'] : 'no'),
			'post_type'                 	=> sanitize_key($settings['post_type'] ? $settings['post_type'] : 'post'),
			'post_from'                 	=> sanitize_text_field($settings['post_from'] ? $settings['post_from'] : 'latest'),
			'total_posts'                 	=> absint($settings['total_posts'] ? $settings['total_posts'] : '12'),
			'display_content'               => sanitize_text_field($settings['display_content'] ? $settings['display_content'] : 'no'),
			'content_word_limit'            => absint($settings['content_word_limit'] ? $settings['content_word_limit'] : 16),
			'display_read_more'             => sanitize_text_field($settings['display_read_more'] ? $settings['display_read_more'] : 'no'),
			'read_more_type'                => sanitize_text_field($settings['read_more_type'] ? $settings['read_more_type'] : 'link'),
			'display_author'                => sanitize_text_field($settings['display_author'] ? $settings['display_author'] : 'no'),
			'display_date'                 	=> sanitize_text_field($settings['display_date'] ? $settings['display_date'] : 'no'),
			'display_term'                 	=> sanitize_text_field($settings['display_term'] ? $settings['display_term'] : 'no'),
			'term_from'                 	=> sanitize_text_field($settings['term_from'] ? $settings['term_from'] : 'category'),
			'g_column'                 		=> absint($settings['g_column'] ? $settings['g_column'] : '3'),
			'g_tablet'                 		=> absint($settings['g_tablet'] ? $settings['g_tablet'] : '2'),
			'g_mobile'                 		=> absint($settings['g_mobile'] ? $settings['g_mobile'] : '1'),
			'display_pagination'            => sanitize_text_field($settings['display_pagination'] ? $settings['display_pagination'] : 'no'),
			'autoplay'                		=> sanitize_text_field($settings['autoplay'] ? $settings['autoplay'] : 'no'),
			'repeat_post'                 	=> sanitize_text_field($settings['repeat_post'] ? $settings['repeat_post'] : 'no'),
			'pause_hover'                 	=> sanitize_text_field($settings['pause_hover'] ? $settings['pause_hover'] : 'no'),
			'post_column'                 	=> absint($settings['post_column'] ? $settings['post_column'] : '2'),
			'post_column_laptop'            => absint($settings['post_column_laptop'] ? $settings['post_column_laptop'] : '2'),
			'post_column_tablet'            => absint($settings['post_column_tablet'] ? $settings['post_column_tablet'] : '2'),
			'post_column_mobile'            => absint($settings['post_column_mobile'] ? $settings['post_column_mobile'] : '1'),
			'c_autoplay_speed'            	=> absint($settings['c_autoplay_speed'] ? $settings['c_autoplay_speed'] : '2000'),
			'c_autoplay_time'            	=> absint($settings['c_autoplay_time'] ? $settings['c_autoplay_time'] : '2000'),
			'navigation'            		=> sanitize_text_field($settings['navigation'] ? $settings['navigation'] : 'no'),
			'navigation_position'           => sanitize_text_field($settings['navigation_position'] ? $settings['navigation_position'] : 'middle'),
			'image_resize_crop'           	=> sanitize_text_field($settings['image_resize_crop'] ? $settings['image_resize_crop'] : 'no'),
			'image_width'           		=> absint($settings['image_width'] ? $settings['image_width'] : '300'),
			'image_hight'           		=> absint($settings['image_hight'] ? $settings['image_hight'] : '200'),
		);
	
		$this->run_shortcode( 'pgcu', $atts );
	}

	public function display_image( $atts ) {
		$layout  = ! empty( $atts['layout'] ) ? $atts['layout'] : 'carousel';
		$theme   = ! empty( $atts['theme'] ) ? $atts['theme'] . '.png' : 'theme_1.png';
		$img_src = WCPCSU_URL . 'includes/elementor/assets/img/' . $layout . '/' . $theme;
		ob_start();
		?>
		<div>
			<img src="<?php echo esc_attr( $img_src ); ?>" alt="">
		</div>
		<?php
		echo ob_get_clean();
	}

	public function run_shortcode( $shortcode, $atts = [] ) {
		$html = '';

		foreach ( $atts as $key => $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_html( $value ) );
		}

		$html = sprintf( '[%s%s]', $shortcode, $html );

		echo do_shortcode( $html );
	}
}