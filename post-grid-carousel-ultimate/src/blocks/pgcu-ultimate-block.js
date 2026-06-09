import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { Fragment, useState, useEffect } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';
import { 
    useBlockProps, 
    InspectorControls, 
    BlockControls 
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	ToggleControl,
	TextControl,
	Toolbar,
	ToolbarButton,
	ColorPicker,
	ColorPalette
} from '@wordpress/components';
import blockAttributes from './attributes.json';

function extra_js() {
	 /* Check PGCU Carousel Data */
	 let checkData = function (data, value) {
		return typeof data === 'undefined' ? value : data;
	};
	/* PGCU Carousel */
	let pgcuCarousel = document.querySelectorAll('.pgcu-carousel');
	pgcuCarousel.forEach(function (el) {
		let swiper = new Swiper(el, {
			slidesPerView: checkData(parseInt(el.dataset.pgcuItems), 4),
			spaceBetween: checkData(parseInt(el.dataset.pgcuMargin), 30),
			loop: checkData(JSON.parse(el.dataset.pgcuLoop.toLowerCase()), false),
			slidesPerGroup: checkData(parseInt(el.dataset.pgcuPerslide), 4),
			speed: checkData(parseInt(el.dataset.pgcuSpeed), 3000),
			autoplay: checkData(JSON.parse(el.dataset.pgcuAutoplay), {}),
			navigation: {
				nextEl: '.pgcu-carousel-nav__btn--next',
				prevEl: '.pgcu-carousel-nav__btn--prev',
			},
			pagination: {
				el: '.pgcu-carousel-pagination',
				type: 'bullets',
				clickable: true
			},
			breakpoints: checkData(JSON.parse(el.dataset.pgcuResponsive), {})
		})
	});

	/* Marquee wrapper value */
	var pgcuStyles = document.createElement('style');
	document.head.append(pgcuStyles);
	pgcuStyles.innerHTML = `
		.pgcu-carousel--marquee .swiper-wrapper{
			animation: pgcuMarquee var(--pgcu-marqueeSpeed) linear infinite running;
		}
		@keyframes pgcuMarquee {
			0% {
				transform: translate(0, 0);
			}
			100% {
				transform: translate(var(--pgcu-marqueeItemsWidth), 0);
			}
		}
	`;
	var pgcuMarqueeCarousel = document.querySelectorAll('.pgcu-carousel--marquee');
	pgcuMarqueeCarousel.forEach(elm => {
		var pgcuMarqueeCarouselItem = elm.querySelectorAll('.pgcu-post:not(.swiper-slide-duplicate)');
		pgcuMarqueeCarouselItem.forEach(elmnt => {
			var pgcuMarqueeWrapperWidth = pgcuMarqueeCarouselItem.length * (elmnt.offsetWidth + checkData(parseInt(elm.dataset.pgcuMargin)));
			elm.style.setProperty('--pgcu-marqueeItemsWidth', `-${pgcuMarqueeWrapperWidth}px`);
			elm.style.setProperty('--pgcu-marqueeSpeed', `${checkData(parseInt(elm.dataset.pgcuSpeed))}ms`);
		})
	});

	/* Sortable Grid */
	let sortableGrids = document.querySelectorAll('.pgcu-post-sortable');
	if (sortableGrids.length) {
		sortableGrids.forEach(elm => {
			let pgcuSortable = window.Shuffle;
			let pgcuSortableGrid = elm.querySelector('.pgcu-post-sortable__grid');
			let sortLink = elm.querySelectorAll('.pgcu-post-sortable__btn');
			let shuffleInstance = new pgcuSortable(pgcuSortableGrid, {
				itemSelector: '.pgcu-post'
			});
			sortLink.forEach(link => {
				link.addEventListener('click', e => {
					e.preventDefault();
					let _this = e.target;
					let siblings = link.parentElement.children;
					for (let sib of siblings) {
						sib.classList.remove('pgcu-post-sortable__btn--active');
					}
					_this.classList.add('pgcu-post-sortable__btn--active');
					let keyword = _this.getAttribute('data-sortable-nav');
					shuffleInstance.filter(keyword);
				})
			})
		})
	}

	/* Masonry Layout */
	function pgcuMasonryInit() {
		let pgcuMasonryContainer = document.querySelectorAll('.pgcu-masonry');
		pgcuMasonryContainer.forEach(elm=>{
			let macy = new Macy({
				container: elm,
				trueOrder: window.innerWidth > 575 ? true : false,
				waitForImages: true,
				margin: checkData(parseInt(elm.dataset.pgcuMasonryGutter), 30),
				columns: checkData(parseInt(elm.dataset.pgcuMasonryColumns), 3),
				breakAt: checkData(JSON.parse(elm.dataset.pgcuMasonryResponsive), {})
			});
			macy.runOnImageLoad(function () {
				macy.recalculate(true);
			}, true);
		})
	}
	pgcuMasonryInit();

	/* Filter Buttons AJAX */
	jQuery('.pgcu-post-sortable__btn').each(function(id, elm){
		$(elm).on("click", function (e) {
			e.preventDefault();
			var button = $(this),
				data = {
					'action': 'pgcu_sortable',
					'id': $(this).attr('data-id'),
					'term_id': $(this).attr('data-sortable-nav'),
					'query': pgcu_ajax.query
				};
			$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').addClass('pgcu-post-loading');
			$.ajax({ // you can also use $.post here
				url: pgcu_ajax.ajaxurl, // AJAX handler
				data: data,
				type: 'POST',
				success: function (data) {
					$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').empty().append(data);
					$(elm).siblings().removeClass('pgcu-post-sortable__btn--active');
					$(elm).addClass('pgcu-post-sortable__btn--active');
					$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').removeClass('pgcu-post-loading');
				}
			});
		});
	})

	/* Load More Button AJAX */
	jQuery('.pgcu_load_more').each(function(id, element){
		$(element).on("click", function(){
			var append_class = '.pgcu-grid-'+$(element).attr('data-id');
			var button = $(element),
				data = {
				'action': 'pgcu_loadmore',
				'query': pgcu_ajax.query, // that's how we get params from wp_localize_script() function
				'page' : pgcu_ajax.current_page,
				'id'   : $(element).attr('data-id')
			};

			$.ajax({ // you can also use $.post here
				url : pgcu_ajax.ajaxurl, // AJAX handler
				data : data,
				type : 'POST',
				beforeSend : function ( xhr ) {
					button.text('Loading...'); // change the button text, you can also add a preloader image
				},
				success : function( data ){
					button.text('Load More');
					if( data ) {
						$(append_class).append(data); // insert new posts
						pgcu_ajax.current_page++;

						if ( pgcu_ajax.current_page == pgcu_ajax.max_page )
							button.remove(); // if last page, remove the button

						// you can also fire the "post-load" event here if you use a plugin that requires it
						//$( document.body ).trigger( 'post-load' );
						pgcuMasonryInit();
					} else {
						button.remove(); // if no data, remove the button as well
					}
				}
			});
		});
	});
}

registerBlockType( 'pgcup/block', {
    apiVersion: 2,

	title: __( 'Post Grid & Carousel Ultimate', 'post-grid-carousel-ultimate' ),

	category: 'widgets',

    keywords: [ 'post', 'product', 'grid', 'carousel', 'ultimate' ],

    icon: 'slides',

    supports: {
		html: false
	},

    transforms: {

    },

    attributes: blockAttributes,

    edit({ attributes, setAttributes }){
		
			useEffect( () => {
				setTimeout(() => {
					extra_js();
				}, 5000 );
			} );

        let {
			layout,
			theme,
			display_header_title,
			header_title,
			header_position,
			display_title,
			post_from,
			total_posts,
			display_content,
			content_word_limit,
			display_read_more,
			read_more_type,
			display_author,
			display_date,
			display_term,
			term_from,
			autoplay,
			repeat_post,
			pause_hover,
			post_column,
			post_column_laptop,
			post_column_tablet,
			post_column_mobile,
			c_autoplay_time,
			c_autoplay_speed,
			navigation,
			navigation_position,
			g_column,
			g_tablet,
			g_mobile,
			display_pagination,
			image_resize_crop,
			image_width,
			image_hight
		} = attributes;
		return(
            <Fragment>
                <div { ...useBlockProps() }>
                    <InspectorControls>

                        <PanelBody title={ __( 'Layout', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<SelectControl
								label={ __( 'Layout', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ layout }
								options={ [
									{ label: __( 'Carousel', 'post-grid-carousel-ultimate' ), value: 'carousel' },
									{ label: __( 'Grid', 'post-grid-carousel-ultimate' ), value: 'grid' },
									{ label: __( 'Sortable Grid', 'post-grid-carousel-ultimate' ), value: 'isotope' },
								] }
								onChange={ newState => setAttributes( { layout: newState } ) }
							/>

							<SelectControl
								label={ __( 'Theme', 'directorist' ) }
								labelPosition='side'
								value={ theme }
								options={ [
									{ label: __( 'Theme 1', 'post-grid-carousel-ultimate' ), value: 'theme-1' },
									{ label: __( 'Theme 2', 'post-grid-carousel-ultimate' ), value: 'theme-2' },
									{ label: __( 'Theme 3', 'post-grid-carousel-ultimate' ), value: 'theme-3' },
									{ label: __( 'Theme 4', 'post-grid-carousel-ultimate' ), value: 'theme-4' },
								] }
								onChange={ newState => setAttributes( { theme: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Display Header', 'directorist' ) }
								checked={ display_header_title }
								onChange={ newState => setAttributes( { display_header_title: newState } ) }
							/>

							{ display_header_title ? <TextControl
								label={ __( 'Header Title', 'directorist' ) }
								type='text'
								value={ header_title }
								onChange={ newState => setAttributes( { header_title: newState } ) }
							/> : setAttributes( { header_title: '' } ) }

							{ display_header_title ? <SelectControl
								label={ __( 'Header position', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ header_position }
								options={ [
									{ label: __( 'Middle', 'post-grid-carousel-ultimate' ), value: 'middle' },
									{ label: __( 'Left', 'post-grid-carousel-ultimate' ), value: 'left' },
									{ label: __( 'Right', 'post-grid-carousel-ultimate' ), value: 'right' },
								] }
								onChange={ newState => setAttributes( { header_position: newState } ) }
							/> : setAttributes( { header_position: 'middle' } ) }

							<ToggleControl
								label={ __( 'Display Title', 'directorist' ) }
								checked={ display_title }
								onChange={ newState => setAttributes( { display_title: newState } ) }
							/>
							
                        </PanelBody>

						<PanelBody title={ __( 'Query', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<SelectControl
								label={ __( 'Display Post From', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ post_from }
								options={ [
									{ label: __( 'Latest Post', 'post-grid-carousel-ultimate' ), value: 'latest' },
									{ label: __( 'Older Post', 'post-grid-carousel-ultimate' ), value: 'older' },
								] }
								onChange={ newState => setAttributes( { post_from: newState } ) }
							/>

							<TextControl
								label={ __( 'Total Posts', 'directorist' ) }
								type='text'
								value={ total_posts }
								onChange={ newState => setAttributes( { total_posts: newState } ) }
							/>

						</PanelBody>

						<PanelBody title={ __( 'Elements', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<ToggleControl
								label={ __( 'Display Content', 'directorist' ) }
								checked={ display_content }
								onChange={ newState => setAttributes( { display_content: newState } ) }
							/>

							{ display_content ? <TextControl
								label={ __( 'Content Word Limit', 'directorist' ) }
								type='text'
								value={ content_word_limit }
								onChange={ newState => setAttributes( { content_word_limit: newState } ) }
							/> : '' }

							<ToggleControl
								label={ __( 'Display Read More', 'directorist' ) }
								checked={ display_read_more }
								onChange={ newState => setAttributes( { display_read_more: newState } ) }
							/>

							{ display_read_more ? <SelectControl
								label={ __( 'Read More Type', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ read_more_type }
								options={ [
									{ label: __( 'Link', 'post-grid-carousel-ultimate' ), value: 'link' },
									{ label: __( 'Button', 'post-grid-carousel-ultimate' ), value: 'button' },
								] }
								onChange={ newState => setAttributes( { read_more_type: newState } ) }
							/> : '' }

							<ToggleControl
								label={ __( 'Display Author Name', 'directorist' ) }
								checked={ display_author }
								onChange={ newState => setAttributes( { display_author: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Display Date', 'directorist' ) }
								checked={ display_date }
								onChange={ newState => setAttributes( { display_date: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Display Term', 'directorist' ) }
								checked={ display_term }
								onChange={ newState => setAttributes( { display_term: newState } ) }
							/>

							{ display_term ? <SelectControl
								label={ __( 'Term From', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ term_from }
								options={ [
									{ label: __( 'Category', 'post-grid-carousel-ultimate' ), value: 'category' },
									{ label: __( 'Tag', 'post-grid-carousel-ultimate' ), value: 'tag' },
								] }
								onChange={ newState => setAttributes( { term_from: newState } ) }
							/> : '' }

						</PanelBody>

						{ layout == 'carousel' ? <PanelBody title={ __( 'Carousel', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<ToggleControl
								label={ __( 'Auto Play', 'directorist' ) }
								checked={ autoplay }
								onChange={ newState => setAttributes( { autoplay: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Repeat Post', 'directorist' ) }
								checked={ repeat_post }
								onChange={ newState => setAttributes( { repeat_post: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Pause on Hover', 'directorist' ) }
								checked={ pause_hover }
								onChange={ newState => setAttributes( { pause_hover: newState } ) }
							/>

							<TextControl
								label={ __( 'Post Columns', 'directorist' ) }
								type='text'
								value={ post_column }
								onChange={ newState => setAttributes( { post_column: newState } ) }
							/>

							<TextControl
								label={ __( 'Laptop Columns', 'directorist' ) }
								type='text'
								value={ post_column_laptop }
								onChange={ newState => setAttributes( { post_column_laptop: newState } ) }
							/>

							<TextControl
								label={ __( 'Tablet Columns', 'directorist' ) }
								type='text'
								value={ post_column_tablet }
								onChange={ newState => setAttributes( { post_column_tablet: newState } ) }
							/>

							<TextControl
								label={ __( 'Mobile Columns', 'directorist' ) }
								type='text'
								value={ post_column_mobile }
								onChange={ newState => setAttributes( { post_column_mobile: newState } ) }
							/>

							<TextControl
								label={ __( 'Slide Speed', 'directorist' ) }
								type='text'
								value={ c_autoplay_speed }
								onChange={ newState => setAttributes( { c_autoplay_speed: newState } ) }
							/>

							<TextControl
								label={ __( 'Slide Timeout', 'directorist' ) }
								type='text'
								value={ c_autoplay_time }
								onChange={ newState => setAttributes( { c_autoplay_time: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Navigation', 'directorist' ) }
								checked={ navigation }
								onChange={ newState => setAttributes( { navigation: newState } ) }
							/>

							<SelectControl
								label={ __( 'Position', 'post-grid-carousel-ultimate' ) }
								labelPosition='side'
								value={ navigation_position }
								options={ [
									{ label: __( 'Top Left', 'post-grid-carousel-ultimate' ), value: 'top-left' },
									{ label: __( 'Top Right', 'post-grid-carousel-ultimate' ), value: 'top-right' },
									{ label: __( 'Middle', 'post-grid-carousel-ultimate' ), value: 'middle' },
									{ label: __( 'Bottom Left', 'post-grid-carousel-ultimate' ), value: 'bottom-left' },
									{ label: __( 'Bottom Right', 'post-grid-carousel-ultimate' ), value: 'bottom-right' }

								] }
								onChange={ newState => setAttributes( { navigation_position: newState } ) }
							/>
							
						</PanelBody> : '' }

						{ layout == 'grid' ? <PanelBody title={ __( 'Grid', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<TextControl
								label={ __( 'Grid Columns', 'directorist' ) }
								type='text'
								value={ g_column }
								onChange={ newState => setAttributes( { g_column: newState } ) }
							/>

							<TextControl
								label={ __( 'Select Columns for Tablet', 'directorist' ) }
								type='text'
								value={ g_tablet }
								onChange={ newState => setAttributes( { g_tablet: newState } ) }
							/>

							<TextControl
								label={ __( 'Select Columns for Mobile', 'directorist' ) }
								type='text'
								value={ g_mobile }
								onChange={ newState => setAttributes( { g_mobile: newState } ) }
							/>

							<ToggleControl
								label={ __( 'Display Pagination', 'directorist' ) }
								checked={ display_pagination }
								onChange={ newState => setAttributes( { display_pagination: newState } ) }
							/>

						</PanelBody> : '' }

						<PanelBody title={ __( 'Image', 'post-grid-carousel-ultimate' ) } initialOpen={ false }>

							<ToggleControl
								label={ __( 'Image Resize & Crop', 'directorist' ) }
								checked={ image_resize_crop }
								onChange={ newState => setAttributes( { image_resize_crop: newState } ) }
							/>

							<TextControl
								label={ __( 'Cropping Width', 'directorist' ) }
								type='text'
								value={ image_width }
								onChange={ newState => setAttributes( { image_width: newState } ) }
							/>

							<TextControl
								label={ __( 'Cropping Height', 'directorist' ) }
								type='text'
								value={ image_hight }
								onChange={ newState => setAttributes( { image_hight: newState } ) }
							/>

						</PanelBody>

                    </InspectorControls>
                
			    	<ServerSideRender block="pgcup/block" attributes={ attributes } />
                 </div>
            </Fragment>
		)
	},

    save( { attributes } ){

    }
} );

