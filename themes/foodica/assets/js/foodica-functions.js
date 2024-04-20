/**
 * Theme functions file
 */
(function ($) {
    'use strict';

    var $window = $(window);


    /**
    * Document ready (jQuery)
    */
    $(function () {

        var wpzoomLazyLoadImagesInitEvent = function () {

            var event = document.createEvent('Event');
            var bodyEl = document.querySelector('body');

            event.initEvent('jetpack-lazy-images-load', true, true);
            bodyEl.dispatchEvent(event);

        };

        /**
         * Activate superfish menu.
         */
        $('.sf-menu').superfish({
            'speed': 'fast',
            'delay' : 0,
            'animation': {
                'height': 'show'
            }
        });

       /**
        * SlickNav
        */

       $('#menu-main-slide').slicknav({
           prependTo:'.navbar-header-main',
           allowParentLinks: true,
           closedSymbol: "",
           openedSymbol: ""
           }
       );

       /* Tag Cloud fix */
       $('.tag-cloud-link:has(.post_count)').addClass('has_sub');


        /**
         * FitVids - Responsive Videos in posts
         */
        $(".entry-content, .cover").fitVids();


        /**
         * Search form in header.
         */
        $(".sb-search").sbSearch();


        /**
         * Recipe Index infinite loading support.
         */
        var $folioitems = $('.foodica-index');
        if (typeof wpz_currPage != 'undefined' && wpz_currPage < wpz_maxPages) {
            $('.navigation').empty().append('<a class="btn btn-primary" id="load-more" href="#">' + zoomOptions.index_infinite_load_txt + '</a>');

            $('#load-more').on('click', function (e) {
                e.preventDefault();
                if (wpz_currPage < wpz_maxPages) {
                    $(this).text(zoomOptions.index_infinite_loading_txt);
                    wpz_currPage++;

                    $.get(wpz_pagingURL + wpz_currPage + '/', function (data) {
                        var $newItems = $('.foodica-index article', data);

                        $newItems.addClass('hidden').hide();
                        $folioitems.append($newItems);
                        $folioitems.find('article.hidden').fadeIn().removeClass('hidden');

                        if ((wpz_currPage + 1) <= wpz_maxPages) {
                            $('#load-more').text(zoomOptions.index_infinite_load_txt);
                        } else {
                            $('#load-more').animate({height: 'hide', opacity: 'hide'}, 'slow', function () {
                                $(this).remove();
                            });
                        }

                        //trigger jetpack lazy images event
                        $( 'body' ).trigger( 'jetpack-lazy-images-load');
                        wpzoomLazyLoadImagesInitEvent();
                    });
                }
            });
        }



    });

    $window.on('load', function() {

        /**
         * Activate main slider.
         */
        $('#slider').sllider();


    });


    $.fn.sllider = function() {
        return this.each(function () {
            var $this = $(this);

            var $slides = $this.find('.slide');

            if ($slides.length <= 1) {
                $slides.addClass('is-selected');

                return;
            }

            var flky = new Flickity('.slides', {
                cellAlign: 'center',
                contain: true,
                percentPosition: false,
                //prevNextButtons: false,
                pageDots: true,
                wrapAround: true,
                accessibility: false
            });
        });
    };


    $.fn.sbSearch = function() {
       return this.each(function() {
           new UISearch( this );
       });
    };

})(jQuery);