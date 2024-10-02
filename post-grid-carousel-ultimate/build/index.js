/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/blocks/pgcu-ultimate-block.js":
/*!*******************************************!*\
  !*** ./src/blocks/pgcu-ultimate-block.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _attributes_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./attributes.json */ "./src/blocks/attributes.json");








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
        prevEl: '.pgcu-carousel-nav__btn--prev'
      },
      pagination: {
        el: '.pgcu-carousel-pagination',
        type: 'bullets',
        clickable: true
      },
      breakpoints: checkData(JSON.parse(el.dataset.pgcuResponsive), {})
    });
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
    });
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
        });
      });
    });
  }

  /* Masonry Layout */
  function pgcuMasonryInit() {
    let pgcuMasonryContainer = document.querySelectorAll('.pgcu-masonry');
    pgcuMasonryContainer.forEach(elm => {
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
    });
  }
  pgcuMasonryInit();

  /* Filter Buttons AJAX */
  jQuery('.pgcu-post-sortable__btn').each(function (id, elm) {
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
      $.ajax({
        // you can also use $.post here
        url: pgcu_ajax.ajaxurl,
        // AJAX handler
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
  });

  /* Load More Button AJAX */
  jQuery('.pgcu_load_more').each(function (id, element) {
    $(element).on("click", function () {
      var append_class = '.pgcu-grid-' + $(element).attr('data-id');
      var button = $(element),
        data = {
          'action': 'pgcu_loadmore',
          'query': pgcu_ajax.query,
          // that's how we get params from wp_localize_script() function
          'page': pgcu_ajax.current_page,
          'id': $(element).attr('data-id')
        };
      $.ajax({
        // you can also use $.post here
        url: pgcu_ajax.ajaxurl,
        // AJAX handler
        data: data,
        type: 'POST',
        beforeSend: function (xhr) {
          button.text('Loading...'); // change the button text, you can also add a preloader image
        },

        success: function (data) {
          button.text('Load More');
          if (data) {
            $(append_class).append(data); // insert new posts
            pgcu_ajax.current_page++;
            if (pgcu_ajax.current_page == pgcu_ajax.max_page) button.remove(); // if last page, remove the button

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

(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)('pgcup/block', {
  apiVersion: 2,
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Post Grid & Carousel Ultimate', 'post-grid-carousel-ultimate'),
  category: 'widgets',
  keywords: ['post', 'product', 'grid', 'carousel', 'ultimate'],
  icon: 'slides',
  supports: {
    html: false
  },
  transforms: {},
  attributes: _attributes_json__WEBPACK_IMPORTED_MODULE_6__,
  edit(_ref) {
    let {
      attributes,
      setAttributes
    } = _ref;
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
      setTimeout(() => {
        extra_js();
      }, 5000);
    });
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
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.useBlockProps)(), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Layout', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Layout', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: layout,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Carousel', 'post-grid-carousel-ultimate'),
        value: 'carousel'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Grid', 'post-grid-carousel-ultimate'),
        value: 'grid'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Sortable Grid', 'post-grid-carousel-ultimate'),
        value: 'isotope'
      }],
      onChange: newState => setAttributes({
        layout: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Theme', 'directorist'),
      labelPosition: "side",
      value: theme,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Theme 1', 'post-grid-carousel-ultimate'),
        value: 'theme-1'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Theme 2', 'post-grid-carousel-ultimate'),
        value: 'theme-2'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Theme 3', 'post-grid-carousel-ultimate'),
        value: 'theme-3'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Theme 4', 'post-grid-carousel-ultimate'),
        value: 'theme-4'
      }],
      onChange: newState => setAttributes({
        theme: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Header', 'directorist'),
      checked: display_header_title,
      onChange: newState => setAttributes({
        display_header_title: newState
      })
    }), display_header_title ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Header Title', 'directorist'),
      type: "text",
      value: header_title,
      onChange: newState => setAttributes({
        header_title: newState
      })
    }) : setAttributes({
      header_title: ''
    }), display_header_title ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Header position', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: header_position,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Middle', 'post-grid-carousel-ultimate'),
        value: 'middle'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Left', 'post-grid-carousel-ultimate'),
        value: 'left'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Right', 'post-grid-carousel-ultimate'),
        value: 'right'
      }],
      onChange: newState => setAttributes({
        header_position: newState
      })
    }) : setAttributes({
      header_position: 'middle'
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Title', 'directorist'),
      checked: display_title,
      onChange: newState => setAttributes({
        display_title: newState
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Query', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Post From', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: post_from,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Latest Post', 'post-grid-carousel-ultimate'),
        value: 'latest'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Older Post', 'post-grid-carousel-ultimate'),
        value: 'older'
      }],
      onChange: newState => setAttributes({
        post_from: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Total Posts', 'directorist'),
      type: "text",
      value: total_posts,
      onChange: newState => setAttributes({
        total_posts: newState
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Elements', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Content', 'directorist'),
      checked: display_content,
      onChange: newState => setAttributes({
        display_content: newState
      })
    }), display_content ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content Word Limit', 'directorist'),
      type: "text",
      value: content_word_limit,
      onChange: newState => setAttributes({
        content_word_limit: newState
      })
    }) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Read More', 'directorist'),
      checked: display_read_more,
      onChange: newState => setAttributes({
        display_read_more: newState
      })
    }), display_read_more ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Read More Type', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: read_more_type,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Link', 'post-grid-carousel-ultimate'),
        value: 'link'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Button', 'post-grid-carousel-ultimate'),
        value: 'button'
      }],
      onChange: newState => setAttributes({
        read_more_type: newState
      })
    }) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Author Name', 'directorist'),
      checked: display_author,
      onChange: newState => setAttributes({
        display_author: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Date', 'directorist'),
      checked: display_date,
      onChange: newState => setAttributes({
        display_date: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Term', 'directorist'),
      checked: display_term,
      onChange: newState => setAttributes({
        display_term: newState
      })
    }), display_term ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Term From', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: term_from,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Category', 'post-grid-carousel-ultimate'),
        value: 'category'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tag', 'post-grid-carousel-ultimate'),
        value: 'tag'
      }],
      onChange: newState => setAttributes({
        term_from: newState
      })
    }) : ''), layout == 'carousel' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Carousel', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Auto Play', 'directorist'),
      checked: autoplay,
      onChange: newState => setAttributes({
        autoplay: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Repeat Post', 'directorist'),
      checked: repeat_post,
      onChange: newState => setAttributes({
        repeat_post: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Pause on Hover', 'directorist'),
      checked: pause_hover,
      onChange: newState => setAttributes({
        pause_hover: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Post Columns', 'directorist'),
      type: "text",
      value: post_column,
      onChange: newState => setAttributes({
        post_column: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Laptop Columns', 'directorist'),
      type: "text",
      value: post_column_laptop,
      onChange: newState => setAttributes({
        post_column_laptop: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tablet Columns', 'directorist'),
      type: "text",
      value: post_column_tablet,
      onChange: newState => setAttributes({
        post_column_tablet: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Mobile Columns', 'directorist'),
      type: "text",
      value: post_column_mobile,
      onChange: newState => setAttributes({
        post_column_mobile: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Slide Speed', 'directorist'),
      type: "text",
      value: c_autoplay_speed,
      onChange: newState => setAttributes({
        c_autoplay_speed: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Slide Timeout', 'directorist'),
      type: "text",
      value: c_autoplay_time,
      onChange: newState => setAttributes({
        c_autoplay_time: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Navigation', 'directorist'),
      checked: navigation,
      onChange: newState => setAttributes({
        navigation: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Position', 'post-grid-carousel-ultimate'),
      labelPosition: "side",
      value: navigation_position,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Top Left', 'post-grid-carousel-ultimate'),
        value: 'top-left'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Top Right', 'post-grid-carousel-ultimate'),
        value: 'top-right'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Middle', 'post-grid-carousel-ultimate'),
        value: 'middle'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Bottom Left', 'post-grid-carousel-ultimate'),
        value: 'bottom-left'
      }, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Bottom Right', 'post-grid-carousel-ultimate'),
        value: 'bottom-right'
      }],
      onChange: newState => setAttributes({
        navigation_position: newState
      })
    })) : '', layout == 'grid' ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Grid', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Grid Columns', 'directorist'),
      type: "text",
      value: g_column,
      onChange: newState => setAttributes({
        g_column: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Columns for Tablet', 'directorist'),
      type: "text",
      value: g_tablet,
      onChange: newState => setAttributes({
        g_tablet: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Columns for Mobile', 'directorist'),
      type: "text",
      value: g_mobile,
      onChange: newState => setAttributes({
        g_mobile: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Display Pagination', 'directorist'),
      checked: display_pagination,
      onChange: newState => setAttributes({
        display_pagination: newState
      })
    })) : '', (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'post-grid-carousel-ultimate'),
      initialOpen: false
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image Resize & Crop', 'directorist'),
      checked: image_resize_crop,
      onChange: newState => setAttributes({
        image_resize_crop: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Cropping Width', 'directorist'),
      type: "text",
      value: image_width,
      onChange: newState => setAttributes({
        image_width: newState
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Cropping Height', 'directorist'),
      type: "text",
      value: image_hight,
      onChange: newState => setAttributes({
        image_hight: newState
      })
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)((_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default()), {
      block: "pgcup/block",
      attributes: attributes
    })));
  },
  save(_ref2) {
    let {
      attributes
    } = _ref2;
  }
});

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/server-side-render":
/*!******************************************!*\
  !*** external ["wp","serverSideRender"] ***!
  \******************************************/
/***/ (function(module) {

module.exports = window["wp"]["serverSideRender"];

/***/ }),

/***/ "./src/blocks/attributes.json":
/*!************************************!*\
  !*** ./src/blocks/attributes.json ***!
  \************************************/
/***/ (function(module) {

module.exports = JSON.parse('{"layout":{"type":"string","default":"carousel"},"theme":{"type":"string","default":"theme-1"},"display_header_title":{"type":"boolean","default":false},"header_title":{"type":"string","default":""},"header_position":{"type":"string","default":"middle"},"display_title":{"type":"boolean","default":true},"post_from":{"type":"string","default":"latest"},"total_posts":{"type":"string","default":"12"},"display_content":{"type":"boolean","default":true},"content_word_limit":{"type":"string","default":"16"},"display_read_more":{"type":"boolean","default":true},"read_more_type":{"type":"string","default":"link"},"display_author":{"type":"boolean","default":true},"display_date":{"type":"boolean","default":true},"display_term":{"type":"boolean","default":true},"term_from":{"type":"string","default":"category"},"autoplay":{"type":"boolean","default":true},"repeat_post":{"type":"boolean","default":true},"pause_hover":{"type":"boolean","default":false},"post_column":{"type":"string","default":"2"},"post_column_laptop":{"type":"string","default":"2"},"post_column_tablet":{"type":"string","default":"2"},"post_column_mobile":{"type":"string","default":"1"},"c_autoplay_speed":{"type":"string","default":"2000"},"c_autoplay_time":{"type":"string","default":"2000"},"navigation":{"type":"boolean","default":true},"navigation_position":{"type":"string","default":"middle"},"g_column":{"type":"string","default":"3"},"g_tablet":{"type":"string","default":"2"},"g_mobile":{"type":"string","default":"1"},"display_pagination":{"type":"boolean","default":true},"pagination_type":{"type":"string","default":"number"},"image_resize_crop":{"type":"boolean","default":true},"image_width":{"type":"string","default":"300"},"image_hight":{"type":"string","default":"200"}}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blocks_pgcu_ultimate_block_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blocks/pgcu-ultimate-block.js */ "./src/blocks/pgcu-ultimate-block.js");

}();
/******/ })()
;
//# sourceMappingURL=index.js.map