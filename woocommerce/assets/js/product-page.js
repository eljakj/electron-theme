jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    if ( $(".electron-product-stock-progressbar").length ) {
        var percent = $(".electron-product-stock-progressbar").data('stock-percent');
        $(".electron-product-stock-progressbar").css('width',percent);
    }

    // product tabs
    $(document.body).on('click', '.electron-product-tab-title-item', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.electron-product-tabs-wrapper div[data-id="'+id+'"]').addClass('active');
        $('.electron-product-tabs-wrapper div:not([data-id="'+id+'"])').removeClass('active');
    });

    // product summary accordion tabs
    $('.cr-qna-link').on('click', function() {
        var name  = 'accordion';
        var offset  = 32;
        if ($('.zank-product-tabs-wrapper').length) {
            name  = 'tabs';
            offset = 0;
        }
        var target = $('.zank-product-'+name+'-wrapper').position();

        $('html,body').stop().animate({
            scrollTop: target.top + offset
        }, 1500);
        if ( $('[data-id="accordion-cr_qna"]').parent().hasClass('active') ) {
            return;
        } else {
            setTimeout(function(){
                $('[data-id="accordion-cr_qna"]').trigger('click');
            }, 700);
        }
        if ( $('[data-id="tab-cr_qna"]').hasClass('active') ) {
            return;
        } else {
            setTimeout(function(){
                $('[data-id="tab-cr_qna"]').trigger('click');
            }, 700);
        }
    });

    $(document.body).on('click','.electron-product-summary .electron-review-link', function(e) {
        e.preventDefault();
        var target = $('.nt-woo-single #reviews').position();
        if ($('.electron-product-tabs-wrapper').length) {
            target = $('.nt-woo-single .electron-product-tabs-wrapper').position();
        }
        $('html,body').stop().animate({
            scrollTop: target.top
        }, 1500);

        if ( $('[data-id="tab-reviews"]').hasClass('active') ) {
            return;
        } else {
            setTimeout(function(){
                $('[data-id="tab-reviews"]').trigger('click');
            }, 700);
        }
    });

    // product summary accordion tabs
    $(document.body).on('click', '.electron-accordion-header', function(e) {
        e.preventDefault();
        var accordionItem   = $(this),
            accordionParent = accordionItem.parent(),
            accordionHeight = accordionItem.outerHeight(),
            headerHeight    = $('body').hasClass('admin-bar') ? 32 : 0,
            totalHeight     = accordionHeight + headerHeight;

        accordionParent.toggleClass('active');
        accordionItem.next('.electron-accordion-body').slideToggle();
        accordionParent.siblings().removeClass('active').find('.electron-accordion-body').slideUp();
    });

    // product selected-variations-terms
    if ( $('.electron-selected-variations-terms-wrapper').length > 0 ) {
        $('.electron-summary-item.variations_form').on('change', function() {
            var $this = $(this);
            var selectedterms = '';
            $this.find('.electron-variations-items select').each(function(){
                var title = $(this).parents('.electron-variations-items').find('.electron-small-title').text();
                var val = $(this).val();
                var name  = $(this).find('option[value="'+val+'"]').html();
                if (val) {
                    selectedterms += '<span class="selected-features"><span class="selected-title">'+title+': </span><span class="selected-value">'+name+'</span></span>';
                }
            });
            if (selectedterms){
                $('.electron-selected-variations-terms-wrapper').slideDown().find('.electron-selected-variations-terms').html(selectedterms);
            }
        });
        $('.electron-btn-reset.reset_variations').on('click', function() {
            $('.electron-selected-variations-terms-wrapper').slideUp();
        });
    }

    if ( electron_vars.product_ajax == 'yes' ) {
        // single page ajax add to cart
        $('body').on('submit', '.nt-woo-single form.cart', function(e) {

            if ( $(this).parents('.product').hasClass('product-type-external') || $(e.originalEvent.submitter).hasClass('electron-btn-buynow') ) {
                return;
            }

            e.preventDefault();

            var form = $(this),
                btn  = form.find('.electron-btn.single_add_to_cart_button'),
                val  = form.find('[name=add-to-cart]').val(),
                data = new FormData(form[0]);

            btn.addClass('loading');

            data.append('add-to-cart', val );

            // Ajax action.
            $.ajax({
                url         : electron_vars.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_ajax_add_to_cart' ),
                data        : data,
                type        : 'POST',
                processData : false,
                contentType : false,
                dataType    : 'json',
                success     : function( response ) {

                    btn.removeClass('loading');

                    var fragments = response.fragments;
                    var appended  = '<div class="woocommerce-notices-wrapper">'+fragments.notices+'</div>';

                    if ( fragments.notices.indexOf('woocommerce-error') > -1 ) {

                        btn.addClass('disabled');
                        $(appended).prependTo('.electron-shop-popup-notices');

                    } else {

                        if ( $('.electron-shop-popup-notices .woocommerce-notices-wrapper').length>0 ) {
                            $('.electron-shop-popup-notices .woocommerce-notices-wrapper').remove();
                            $(appended).prependTo('.electron-shop-popup-notices').delay(4000).fadeOut(300, function(){
                                $(this).remove();
                            });
                        } else {
                            $(appended).prependTo('.electron-shop-popup-notices').delay(4000).fadeOut(300, function(){
                                $(this).remove();
                            });
                        }
                    }

                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.nt-sidebar-inner .electron-minicart').replaceWith(fragments.minicart);
                    $('.electron-cart-count').html(fragments.count);
                    $('.electron-cart-total').html(fragments.total);
                    $('.electron-cart-goal-text').html(fragments.shipping.message);
                    $('.electron-progress-bar').css('width',fragments.shipping.value+'%');

                    // Redirect to cart option
                    if ( electron_vars.cart_redirect === 'yes' ) {
                        window.location = electron_vars.cart_url;
                        return;
                    }
                },
                error: function() {
                    btn.removeClass('loading');
                    console.log('cart-error');
                    $( document.body ).trigger( 'wc_fragments_ajax_error' );
                }
            });
        });
    }

    /***** buynow start *****/

    $('body').on('click', '.nt-woo-single .electron-btn-buynow', function() {
        if ($(this).parents('form.cart').length) {
            return;
        }
    });

    /***** buynow end *****/

    // Product Fake View

    var viewingItem = $('.electron-product-view'),
        data        = viewingItem.data('product-view'),
        countView   = viewingItem.find('.electron-view-count'),
        current     = 0,
        change_counter;

    singleProductFakeView();
    function singleProductFakeView() {

        if ( viewingItem.length ) {
            var min    = data.min,
                max    = data.max,
                delay  = data.delay,
                change = data.change,
                id     = data.id;

            if ( !viewingItem.hasClass( 'inited' ) ) {
                if ( typeof change !== 'undefined' && change ) {
                    clearInterval( change );
                }

                current = $.cookie( 'electron_cpv_' + id );

                if ( typeof current === 'undefined' || !current ) {
                    current = Math.floor(Math.random() * max) + min;
                }

                viewingItem.addClass('inited');

                $.cookie('electron_cpv_' + id, current, { expires: 1 / 24, path: '/'} );

                countView.html( current );

            }

            change_counter = setInterval( function() {
                current    = parseInt( countView.text() );

                if ( !current ) {
                    current = min;
                }

                var pm = Math.floor( Math.random() * 2 );
                var others = Math.floor( Math.random() * change + 1 );
                current = ( pm < 1 && current > others ) ? current - others : current + others;
                $.cookie('electron_cpv_' + id, current, { expires: 1 / 24, path: '/'} );

                countView.html( current );

            }, delay);
        }
    }

    electronProductGalleryInit();

    function electronProductGalleryInit() {
        if ( $('.electron-product-gallery-main-slider').length ) {
            var thumbsDirection = 'horizontal';
            if ( $('.electron-swiper-slider-wrapper').hasClass('thumbs-right') || $('.electron-swiper-slider-wrapper').hasClass('thumbs-left') ) {
                var thumbsDirection = 'vertical';
            }

            $('.electron-product-gallery-main-slider .swiper-slide').each(function(i,e){
                var thumbUrl = $(this).data('thumb') ? $(this).data('thumb') : $(this).data('src');
                var active   = i == 0 ? ' swiper-slide-thumb-active' : '';
                var videoH   = $(this).hasClass('iframe-video') ? ' style="height:'+Math.round($('.electron-product-thumbnails .swiper-slide:first-child img').height())+'px"' : '';
                var tumbImg = $(this).hasClass('iframe-video') ? '<div class="electron-slide-video-item-icon"'+videoH+'><i class="nt-icon-button-play-2"></i></div>' : '<img src="'+thumbUrl+'">';
                $('<div class="swiper-slide thmub-video-icon'+active+'">'+tumbImg+'</div>').appendTo($('.electron-product-thumbnails .electron-swiper-wrapper'));
            });

            var navs    = $('.electron-product-thumbnails-navs').length;
            var perview = $('.electron-product-thumbnails').data('perview');
                perview = navs > 0 ? parseFloat(perview) : 'auto';
            var galleryThumbs  = new NTSwiper( '.electron-product-thumbnails', {
                spaceBetween         : 10,
                slidesPerView        : 5,
                direction            : "horizontal",
                wrapperClass         : "electron-swiper-wrapper",
                watchOverflow        : true,
                watchSlidesProgress  : true,
                watchSlidesVisibility: true,
                rewind               : true,
                observer             : true,
                observeParents       : true,
                resizeObserver       : true,
                grabCursor           : true,
                navigation            : {
                    nextEl : ".electron-product-thumbnails-wrapper .electron-swiper-next",
                    prevEl : ".electron-product-thumbnails-wrapper .electron-swiper-prev"
                },
                breakpoints          : {
                    320 : {
                        slidesPerView : 5,
                        direction     : "horizontal"
                    },
                    576 : {
                        slidesPerView : 8,
                        direction     : "horizontal",
                    },
                    768 : {
                        slidesPerView : thumbsDirection == 'vertical' ? perview : 8,
                        direction     : thumbsDirection,
                    }
                },
                on                   : {
                    resize : function ( swiper ) {
                        swiper.update();
                        var videoicon = $('.electron-product-thumbnails .swiper-slide:not(.swiper-slide-active)').height();
                        $('.electron-slide-video-item-icon').css('height', videoicon );
                    },
                    init : function ( swiper ) {
                        $('.electron-product-thumbnails-wrapper').addClass('initialized');
                        setTimeout(function(){
                            var videoicon = $('.electron-product-thumbnails .swiper-slide:first-child').height();

                            $('.electron-slide-video-item-icon').css('height', videoicon - 6 );
                        }, 500);
                    }
                }
            });

            var galleryMain = new NTSwiper( '.electron-product-gallery-main-slider', {
                speed                 : 800,
                spaceBetween          : 0,
                slidesPerView         : 1,
                direction             : "horizontal",
                wrapperClass          : "electron-swiper-wrapper",
                watchSlidesVisibility : true,
                watchSlidesProgress   : true,
                autoHeight            : true,
                rewind                : true,
                observer              : true,
                observeParents        : true,
                resizeObserver        : true,
                grabCursor            : true,
                navigation            : {
                    nextEl : ".electron-product-gallery-main-slider .electron-swiper-next",
                    prevEl : ".electron-product-gallery-main-slider .electron-swiper-prev"
                },
                thumbs                : {
                    swiper: galleryThumbs
                },
                on                    : {
                    init : function ( swiper ) {
                        var heightVertical = $('.electron-product-gallery-main-slider').height();
                        var slideItems = $('.electron-product-thumbnails .swiper-slide').length;
                        var heightVertical = slideItems > 5 ? heightVertical - 50 : heightVertical;
                        if ( $('.electron-product-thumbnails-wrapper').length ) {
                            $('.electron-product-thumbnails').css('max-height', heightVertical );
                        }
                    },
                    resize : function ( swiper ) {
                        var heightVertical = $('.electron-product-gallery-main-slider').height();
                        var slideItems = $('.electron-product-thumbnails .swiper-slide').length;
                        var heightVertical = slideItems > 5 ? heightVertical - 50 : heightVertical;
                        if ( $('.electron-product-thumbnails-wrapper').length ) {
                            $('.electron-product-thumbnails').css('max-height', heightVertical );
                        }
                    },
                    transitionEnd : function ( swiper ) {
                        var  active = swiper.realIndex;

                        $( '.electron-product-gallery-main-slider .swiper-slide:not(.swiper-slide-active)' ).each(function () {
                            var iframe = $( this ).find('iframe');
                            if ( iframe.length ) {
                                iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                            }
                        });

                        $( '.electron-product-gallery-main-slider .swiper-slide.swiper-slide-active' ).each(function () {
                            var iframe2 = $( this ).find('iframe');
                            if ( iframe2.length ) {
                                iframe2[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                            }
                        });
                    },
                    afterInit: function(swiper){
                        var iframesrc = $('.electron-product-gallery-main-slider .iframe-video iframe').data('src');
                        $( '.electron-product-gallery-main-slider .iframe-video iframe' ).attr('src', iframesrc);
                    }
                }
            });

            var $gallery     = $('.electron-product-gallery-main-slider'),
                $mainImg     = $gallery.find('.electron-swiper-slide-first'),
                $oMainImg    = $mainImg.find('img'),
                $oZoomImg    = $mainImg.find('img.zoomImg'),
                $oZoomSrc    = $oMainImg.attr('src'),
                $popupSrc    = $mainImg.attr('data-src'),
                $oThumbImg   = $('.electron-product-thumbnails .swiper-slide:first-child img'),
                $hasThumbs   = $mainImg.attr('data-thumb') ? true : false,
                $oThumbSrc   = $hasThumbs ? $mainImg.attr('data-thumb') : $popupSrc,
                resetBtn     = $('.electron-btn-reset.reset_variations'),
                $mainSkuHtml = $('.electron-sku-wrapper .sku'),
                $mainSku     = $mainSkuHtml.html(),
                $mainPrice   = $('.electron-summary-item.electron-price .price'),
                $mainPriceHml= $mainPrice.html(),
                $mainStock   = $('.electron-summary-item .electron-price>.electron-stock-status'),
                $mainStockHml= $mainStock.html();

            $('.electron-product-summary form.variations_form').on('show_variation', function( event, data ){
                $('.electron-product-summary .electron-product-info').addClass('found');
                if ( data.sku ) {
                    $mainSkuHtml.html(data.sku);
                }

                var $price = $(event.target).closest('.electron-product-summary').find('.electron-price>.price');
                // product price
                if ( $price.length ) {
                    if ( data.price_html ) {
                        $price.html( data.price_html );
                    }
                }

                var $stock = $(event.target).closest('.electron-product-summary').find('.electron-price>.electron-stock-status');
                // product stock
                if ( $stock.length ) {
                    if ( data.availability_html != '' ) {
                        var stcokhtml = $(data.availability_html).html();
                        $stock.html( stcokhtml );
                    }
                }

                resetBtn.addClass( 'active' );
                var fullsrc = data.image.full_src;
                var src     = data.image.src;
                var tsrc    = data.image.gallery_thumbnail_src;
                $mainImg.attr('data-src',fullsrc);
                $oMainImg.attr('src',src);
                $oZoomImg.attr('src',fullsrc);
                if ( $hasThumbs ) {
                    $oThumbImg.attr('src',tsrc);
                } else {
                    $oThumbImg.attr('src',fullsrc);
                }
                setTimeout( function() {
                    if ( !$oMainImg.hasClass('active') ) {
                        galleryMain.slideTo(0);
                        galleryThumbs.slideTo(0);
                    }
                    //initZoom('reinit',fullsrc);
                }, 100 );
            });

            $('.electron-product-summary form.variations_form').on('hide_variation', function(){
                $('.electron-product-summary .electron-product-info').removeClass('found');
                $mainSkuHtml.html($mainSku);
                $mainPrice.html($mainPriceHml);
                $mainStock.html($mainStockHml);
                resetBtn.removeClass( 'active' );
                $mainImg.attr('data-src',$popupSrc);
                $oMainImg.attr('src',$oZoomSrc);
                $oZoomImg.attr('src',$oZoomSrc);
                $oThumbImg.attr('src',$oThumbSrc);

                setTimeout( function() {
                    if ( !$oMainImg.hasClass('active') ) {
                        galleryMain.slideTo(0);
                        galleryThumbs.slideTo(0);
                    }
                    initZoom('reinit',$oZoomSrc);
                }, 100 );
            });

            /*
            var paneContainer = document.querySelector('.zoom');

            $(".electron-product-gallery-main-slider:not(.electron-variation-slider) .swiper-slide").each(function(){

                new Drift($(this).find("img")[0], {
                    //paneContainer: document.body,
                    //inlineContainer: document.body,
                    //inlinePane: false,
                    containInline: true,
                });
            });
            */

            initZoom('load');

            /**
            * Init zoom.
            */
            function initZoom($action,$url) {
                if ( 'function' !== typeof $.fn.zoom && !wc_single_product_params.zoom_enabled ) {
                    return false;
                }

                var galleryWidth = $('.electron-product-gallery-main-slider:not(.electron-variation-slider) .swiper-slide').width(),
                    zoomEnabled  = false,
                    zoom_options = {
                        touch: false,
                        onZoomIn: function(){
                            $(this).parent().find('img:not(.zoomImg)').css('opacity',0);
                        },
                        onZoomOut: function(){
                            $(this).parent().find('img:not(.zoomImg)').css('opacity',1);
                        }
                    };

                if ( 'ontouchstart' in document.documentElement ) {
                    zoom_options.on = 'click';
                }

                $('.electron-product-gallery-main-slider:not(.electron-variation-slider) .swiper-slide img').each( function( index, target ) {
                    var image = $( target );
                    var imageIndex = image.parents('.swiper-slide');

                    if ( image.attr( 'width' ) > galleryWidth ) {
                        if ( $action == 'load' ) {
                            zoom_options.url = image.parent().data('zoom-img');
                            image.wrap('<span class="electron-zoom-wrapper" style="display:block"></span>')
                              .css('display', 'block')
                              .parent()
                              .zoom(zoom_options);
                        } else {
                            image.trigger('zoom.destroy').unwrap();
                            zoom_options.url = imageIndex.hasClass('electron-swiper-slide-first') ? $url : image.parent().data('zoom-img');
                            image.wrap('<span class="electron-zoom-wrapper" style="display:block"></span>')
                              .css('display', 'block')
                              .parent()
                              .zoom(zoom_options);
                        }
                    }
                });
            }
        }
    }


    /**
    * singleGalleryGridVariations
    */

    if ( $('.electron-product-main-gallery-grid').length > 0 ) {

        var $gallery     = $('.electron-product-main-gallery-grid'),
            $mainImg     = $gallery.find('.electron-gallery-grid-item-first'),
            $oMainImg    = $mainImg.find('img'),
            $oMainSrc    = $oMainImg.attr('src'),
            $popupSrc    = $mainImg.attr('data-src'),
            resetBtn     = $('.electron-btn-reset.reset_variations'),
            $mainSkuHtml = $('.electron-sku-wrapper .sku'),
            $mainSku     = $mainSkuHtml.html();

        $('.electron-product-summary form.variations_form').on('show_variation', function( event, data ){
            var fullsrc = data.image.full_src,
                src     = data.image.src;
            if ( data.sku ) {
                $mainSkuHtml.html(data.sku);
            }
            resetBtn.addClass( 'active' );
            $mainImg.attr('data-src',fullsrc);
            $oMainImg.attr('src',src);
        });

        $('.electron-product-summary form.variations_form').on('hide_variation', function(){
            resetBtn.removeClass( 'active' );
            $oMainImg.attr('src',$oMainSrc);
            $oMainImg.attr('data-src',$popupSrc);
        });
    }

   /* product variations swatches multiple gallery */
    $('.electron-product-summary form.variations_form').on('hide_variation', function(){
        $('.electron-swiper-slider-wrapper:not(.electron-variation-slider)').removeClass('electron-hidden');
        $('.electron-swiper-slider-wrapper.electron-variation-slider').addClass('electron-hidden');
    });

    $('.electron-product-summary form.variations_form').on('found_variation', function(event, variation) {

        var variation_id = variation.variation_id;

        if ( variation_id && $('.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"]').length>0 ) {
            $('.electron-swiper-slider-wrapper:not([data-slider-id="'+variation_id+'"])').addClass('electron-hidden');
            $('.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"]').removeClass('electron-hidden');
        } else {
            if ( variation_id && variation.electron_variation_gallery ) {
                var images = variation.electron_variation_gallery;
                $.ajax({
                    url      : electron_vars.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_variation_gallery' ),
                    type     : 'POST',
                    dataType : 'html',
                    data     : {
                        action       : 'electron_variation_gallery',
                        variation_id : variation_id,
                        images       : images
                    },
                    beforeSend : function () {
                        $('.electron-swiper-slider-wrapper').addClass('loading');
                    },
                    success: function(response) {

                        if (response){

                            $('.electron-product-gallery-col').append(response);
                            $('.electron-swiper-slider-wrapper').removeClass('loading');

                            $('.electron-swiper-slider-wrapper:not([data-slider-id="'+variation_id+'"])').addClass('electron-hidden');
                            $('.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"]').removeClass('electron-hidden');

                            $('.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"] .swiper-slide').each(function(i,e){
                                $(this).attr('data-fancybox','gallery'+variation_id);
                            });

                            var thumbsDirection = 'horizontal';
                            var wrapperEl = $('.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"]');
                            var wrapper   = '.electron-swiper-slider-wrapper[data-slider-id="'+variation_id+'"] ';
                            if ( wrapperEl.hasClass('thumbs-right') || wrapperEl.hasClass('thumbs-left') ) {
                                var thumbsDirection = 'vertical';
                            }
                            $(wrapper+'.swiper-slide').each(function(i,e){
                                var thumbUrl = $(this).data('thumb') ? $(this).data('thumb') : $(this).data('src');
                                var active   = i == 0 ? ' swiper-slide-thumb-active' : '';
                                var videoH   = $(this).hasClass('iframe-video') ? ' style="height:'+Math.round($('.electron-product-thumbnails .swiper-slide:first-child img').height())+'px"' : '';
                                var tumbImg = $(this).hasClass('iframe-video') ? '<div class="electron-slide-video-item-icon"'+videoH+'><i class="nt-icon-button-play-2"></i></div>' : '<img src="'+thumbUrl+'">';
                                $('<div class="swiper-slide thmub-video-icon'+active+'">'+tumbImg+'</div>').appendTo($(wrapper+'.electron-product-thumbnails .electron-swiper-wrapper'));
                            });

                            var galleryThumbs  = new NTSwiper( wrapper+'.electron-product-thumbnails', {
                                spaceBetween         : 10,
                                slidesPerView        : 5,
                                direction            : "horizontal",
                                wrapperClass         : "electron-swiper-wrapper",
                                watchOverflow        : true,
                                watchSlidesProgress  : true,
                                watchSlidesVisibility: true,
                                rewind               : true,
                                observer             : true,
                                observeParents       : true,
                                resizeObserver       : true,
                                grabCursor           : true,
                                breakpoints          : {
                                    320 : {
                                        slidesPerView : 5,
                                        direction     : "horizontal"
                                    },
                                    576 : {
                                        slidesPerView : 8,
                                        direction     : "horizontal",
                                    },
                                    768 : {
                                        slidesPerView : thumbsDirection == 'vertical' ? 'auto' : 8,
                                        direction     : thumbsDirection,
                                    }
                                },
                                on                   : {
                                    resize : function ( swiper ) {
                                        swiper.update();
                                        var videoicon = $(wrapper+'.electron-product-thumbnails .swiper-slide:not(.swiper-slide-active)').height();
                                        $(wrapper+'.electron-slide-video-item-icon').css('height', videoicon );
                                    },
                                    init : function ( swiper ) {

                                        setTimeout(function(){
                                            var videoicon = $(wrapper+'.electron-product-thumbnails .swiper-slide:first-child').height();
                                            $(wrapper+'.electron-slide-video-item-icon').css('height', videoicon - 6 );
                                        }, 500);
                                    }
                                }
                            });

                            var galleryMain = new NTSwiper( wrapper+' .electron-product-gallery-main-slider', {
                                speed                 : 800,
                                spaceBetween          : 0,
                                slidesPerView         : 1,
                                direction             : "horizontal",
                                wrapperClass          : "electron-swiper-wrapper",
                                watchSlidesVisibility : true,
                                watchSlidesProgress   : true,
                                autoHeight            : true,
                                rewind                : true,
                                observer              : true,
                                observeParents        : true,
                                resizeObserver        : true,
                                grabCursor            : true,
                                navigation            : {
                                    nextEl : wrapper+'.electron-swiper-next',
                                    prevEl : wrapper+'.electron-swiper-prev'
                                },
                                thumbs                : {
                                    swiper: galleryThumbs
                                },
                                on                    : {
                                    init : function ( swiper ) {
                                        var heightVertical = $(wrapper+'.electron-product-gallery-main-slider').height();
                                        $(wrapper+'.electron-product-thumbnails').css('max-height', heightVertical );
                                    },
                                    resize : function ( swiper ) {
                                        var heightVertical = $(wrapper+'.electron-product-gallery-main-slider').height();
                                        $(wrapper+'.electron-product-thumbnails').css('max-height', heightVertical );
                                        //swiper.update();
                                    },
                                    transitionEnd : function ( swiper ) {
                                        var  active = swiper.realIndex;

                                        $( wrapper+'.electron-product-gallery-main-slider .swiper-slide:not(.swiper-slide-active)' ).each(function () {
                                            var iframe = $( this ).find('iframe');
                                            if ( iframe.length ) {
                                                iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                                            }
                                        });

                                        $( wrapper+'.electron-product-gallery-main-slider .swiper-slide.swiper-slide-active' ).each(function () {
                                            var iframe2 = $( this ).find('iframe');
                                            if ( iframe2.length ) {
                                                iframe2[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                                            }
                                        });
                                    },
                                    afterInit: function(swiper){
                                        var iframesrc = $(wrapper+'.electron-product-gallery-main-slider .iframe-video iframe').data('src');
                                        $( wrapper+'.electron-product-gallery-main-slider .iframe-video iframe' ).attr('src', iframesrc);
                                    }
                                }
                            });


                            /**
                            * Init zoom.
                            */
                            var initZoom2 = function ($action,$url) {
                                if ( 'function' !== typeof $.fn.zoom && !wc_single_product_params.zoom_enabled ) {
                                    return false;
                                }

                                var galleryWidth = $(wrapper+'.electron-product-gallery-main-slider .swiper-slide').width(),
                                    zoomEnabled  = false,
                                    zoom_options = {
                                        touch: false,
                                        onZoomIn: function(){
                                            $(this).parent().find('img:not(.zoomImg)').css('opacity',0);
                                        },
                                        onZoomOut: function(){
                                            $(this).parent().find('img:not(.zoomImg)').css('opacity',1);
                                        }
                                    };

                                if ( 'ontouchstart' in document.documentElement ) {
                                    zoom_options.on = 'click';
                                }

                                $(wrapper+'.electron-product-gallery-main-slider .swiper-slide img').each( function( index, target ) {
                                    var image = $( target );
                                    var imageIndex = image.parents('.swiper-slide');

                                    if ( image.attr( 'width' ) > galleryWidth ) {
                                        if ( $action == 'load' ) {
                                            zoom_options.url = image.parent().data('zoom-img');
                                            image.wrap('<span class="electron-zoom-wrapper" style="display:block"></span>')
                                              .css('display', 'block')
                                              .parent()
                                              .zoom(zoom_options);
                                        } else {
                                            image.trigger('zoom.destroy').unwrap();
                                            zoom_options.url = imageIndex.hasClass('electron-swiper-slide-first') ? $url : image.parent().data('zoom-img');
                                            image.wrap('<span class="electron-zoom-wrapper" style="display:block"></span>')
                                              .css('display', 'block')
                                              .parent()
                                              .zoom(zoom_options);
                                        }
                                    }
                                });
                            }
                            initZoom2('load');
                        }
                    }
                });
            } else {
                $('.electron-swiper-slider-wrapper:not(.electron-variation-slider)').removeClass('electron-hidden');
                $('.electron-swiper-slider-wrapper.electron-variation-slider').addClass('electron-hidden');
            }
        }
    });

    $(window).on("scroll", function () {
        var singlePopupCart  = $(".electron-product-bottom-popup-cart");
        var singleCart       = $('.electron-product-summary .single_add_to_cart_button');
        var singlePopupCartH = singlePopupCart.outerHeight();
        var singleCartPos    = singleCart.offset();
        var singleCartTop    = singleCart.length && singlePopupCart.length ? singleCartPos.top : 0;
        var singleDocHeight  = $(document).height() - singlePopupCartH;

        if ( singlePopupCart.length && singleCart.length ) {
            $("body").css('padding-bottom',singlePopupCartH);
        }
        if ( singlePopupCart.length && singleCart.length ) {
            if ( $(window).scrollTop() > singleCartTop ) {
                singlePopupCart.addClass('active');
                $("body").addClass('bottom-popup-cart-active');
            } else {
                singlePopupCart.removeClass('active');
                $("body").removeClass('bottom-popup-cart-active');

            }
        }
    });

    $('.iv-comment-image').each(function(i,e){
        var src = $(this).find('img').attr('src');
        $(this).attr('data-fancybox','comment_image');
        $(this).attr('data-src',src);
    });


});
