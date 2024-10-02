/*
    Plugin: Post Grid & Carousel Ultimate
    Plugin URI: https://wpwax.com/product/post-grid-carousel-ultimate-pro/
    Author: wpWax
    Version: 1.0
*/

(function ($) {
    function alljs() {
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
        if(sortableGrids.length){
            sortableGrids.forEach(elm=>{
                let pgcuSortable = window.Shuffle;
                let pgcuSortableGrid = elm.querySelector('.pgcu-post-sortable__grid');
                let sortLink = elm.querySelectorAll('.pgcu-post-sortable__btn');
                let shuffleInstance = new pgcuSortable(pgcuSortableGrid, {
                    itemSelector: '.pgcu-post'
                });
                sortLink.forEach(link=>{
                    link.addEventListener('click', e=>{
                        e.preventDefault();
                        let _this = e.target;
                        let siblings = link.parentElement.children;
                        for(let sib of siblings){
                            sib.classList.remove('pgcu-post-sortable__btn--active');
                        }
                        _this.classList.add('pgcu-post-sortable__btn--active');
                        let keyword = _this.getAttribute('data-sortable-nav');
                        shuffleInstance.filter(keyword);
                    })
                })
            })
        }
    }

    window.addEventListener('load', () => { 
        alljs();
    })
    

    /* Elementor Edit Mode */
    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.isEditMode()) {
            alljs();
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function() {
                alljs();
            });
        }
    });

})(jQuery);