jQuery(document).ready(function($) {
    
    /*-- Strict mode enabled --*/
    'use strict';
    /**
    * Init zoom.
    */
    function initZoom($action,$url) {
        if ( 'function' !== typeof $.fn.zoom && !wc_single_product_params.zoom_enabled ) {
            return false;
        }

        var galleryWidth = $('.electron-product-showcase-main .swiper-slide').width(),
            zoomEnabled  = false,
            zoom_options = {
                touch: false
            };

        if ( 'ontouchstart' in document.documentElement ) {
            zoom_options.on = 'click';
        }

        $('.electron-product-showcase-main .swiper-slide img').each( function( index, target ) {
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
    
    var galleryThumbs  = new NTSwiper( '.electron-product-showcase-thumbnails', {
        spaceBetween        : 10,
        slidesPerView       : 5,
        direction           : "horizontal",
        wrapperClass        : "electron-swiper-wrapper",
        grabCursor          : true,
        watchSlidesProgress : true,
        breakpoints         : {
            992 : {
                slidesPerView :  'auto'
            }
        },
        on                  : {
            resize : function ( swiper ) {
                var heightFirstImage = $('.electron-product-showcase-thumbnails .electron-swiper-slide-first').height();
                $('.electron-slide-video-item-icon').css('height', heightFirstImage);
                swiper.update();
            },
            afterInit: function(swiper){
                var heightFirstImage = $('.electron-product-showcase-thumbnails .electron-swiper-slide-first').height();
                $('.electron-slide-video-item-icon').css('height', heightFirstImage);
            }
        }
    });

    var galleryMain = new NTSwiper( '.electron-product-showcase-main', {
        speed                 : 800,
        spaceBetween          : 0,
        slidesPerView         : '1',
        direction             : "horizontal",
        effect                : "slide",
        wrapperClass          : "electron-swiper-wrapper",
        slideActiveClass      : "active",
        loop                  : true,
        centeredSlides        : true,
        slideToClickedSlide   : true,
        grabCursor            : true,
        autoHeight            : false,
        autoPlay              : false,
        rewind                : false,
        observer              : true,
        observeParents        : true,
        observeSlideChildren  : true,
        watchOverflow         : true,
        watchSlidesVisibility : true,
        watchSlidesProgress   : true,
        breakpoints         : {
            992 : {
                slidesPerView : 3
            }
        },
        navigation            : {
            nextEl : ".electron-product-showcase-main .electron-swiper-next",
            prevEl : ".electron-product-showcase-main .electron-swiper-prev"
        },
        thumbs                : {
            swiper: galleryThumbs
        },
        on                    : {
            transitionEnd : function ( swiper ) {
                var  active = swiper.realIndex;

                $( '.electron-product-showcase-main .swiper-slide:not(.active)' ).each(function () {
                    var iframe = $( this ).find('iframe');
                    if ( iframe.size() ) {
                        iframe[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                    }
                });

                $( '.electron-product-showcase-main .swiper-slide.active' ).each(function () {
                    var iframe2 = $( this ).find('iframe');
                    if ( iframe2.size() ) {
                        iframe2[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                    }
                });
            },
            afterInit: function(swiper){
                var iframesrc = $('.electron-product-showcase-main .iframe-video iframe').data('src');
                $( '.electron-product-showcase-main .iframe-video iframe' ).attr('src', iframesrc);
            }
        }
    });

    var $oMainImg       = $('.electron-product-showcase-main .electron-swiper-slide-first img'),
        $oZoomSrc       = $('.electron-product-showcase-main .electron-swiper-slide-first').data('zoom-img'),
        $oMainSrc       = $oMainImg.data('src'),
        $oMainSrcSet    = $oMainImg.data('srcset'),
        $oMainSrcSizes  = $oMainImg.data('sizes'),
        $oThumbImg      = $('.electron-product-showcase-thumbnails .electron-swiper-slide-first img'),
        $oThumbSrc      = $oThumbImg.data('src'),
        $oThumbSrcSet   = $oThumbImg.data('srcset'),
        $oThumbSrcSizes = $oThumbImg.data('sizes');

    $( document ).on('change','.electron-product-summary .variations_form select', function( e ) {
        var $this      = $(this),
            $form      = $this.parents('.variations_form'),
            variations = $form.data('product_variations'),
            $oZoomImg  = $('.electron-product-showcase-main .electron-swiper-slide-first img.zoomImg'),
            gallery    = $('.electron-product-showcase-main');

        setTimeout( function() {
            var current_id = $form.attr('current-image'),
                image,
                timage,
                full_src,
                src,
                srcset,
                sizes,
                tsrc,
                tsrcset,
                tsizes;

            $.map(variations, function(elementOfArray, indexInArray) {
                if (elementOfArray.image_id == current_id) {
                    image   = elementOfArray.image;
                    src     = image.src;
                    full_src= image.full_src;
                    srcset  = image.srcset;
                    sizes   = image.sizes;
                }
            });
            $.map(variations, function(elementOfArray, indexInArray) {
                if (elementOfArray.image_id == current_id) {
                    timage  = elementOfArray.image;
                    tsrc    = timage.src;
                    tsrcset = timage.srcset;
                    tsizes  = timage.sizes;
                }
            });
            if ( current_id ) {
                $oMainImg.attr('src',src);
                $oMainImg.attr('data-src',src);
                $oZoomImg.attr('src',full_src);
                if ( srcset ) {
                    $oMainImg.attr('srcset',srcset);
                }
                if ( sizes ) {
                    $oMainImg.attr('sizes',sizes);
                }
                $oThumbImg.attr('src',tsrc);
                if ( tsrcset ) {
                    $oThumbImg.attr('srcset',tsrcset);
                }
                if ( tsizes ) {
                    $oThumbImg.attr('sizes',tsizes);
                }

                setTimeout( function() {
                    if ( !$oMainImg.hasClass('swiper-slide.active') ) {
                        galleryMain.slideTo(0);
                        galleryThumbs.slideTo(0);
                    }
                    galleryMain.update();
                    galleryMain.updateAutoHeight(10);
                    galleryThumbs.update();
                    initZoom('reinit',full_src);
                    $('.electron-product-gallery-popups .electron-product-popup').removeClass('active');
                }, 100 );
            }
        }, 50 );
    });

    $( document ).on('click','.electron-product-summary .reset_variations', function( e ) {
        var $form     = $(this).parents('.variations_form'),
            gallery   = $('.electron-product-showcase-main'),
            $oZoomImg = $('.electron-product-showcase-main .electron-swiper-slide-first img.zoomImg');

        $oMainImg.attr('src',$oMainSrc);
        $oMainImg.attr('data-src',$oMainSrc);
        $oZoomImg.attr('src',$oZoomSrc);
        if ( $oMainSrcSet ) {
            $oMainImg.attr('srcset',$oMainSrcSet);
        }
        if ( $oMainSrcSizes ) {
            $oMainImg.attr('sizes',$oMainSrcSizes);
        }

        $oThumbImg.attr('src',$oThumbSrc);
        if ( $oThumbSrcSet ) {
            $oThumbImg.attr('srcset',$oThumbSrcSet);
        }
        if ( $oThumbSrcSizes ) {
            $oThumbImg.attr('sizes',$oThumbSrcSizes);
        }

        setTimeout( function() {
            if ( !$oMainImg.hasClass('swiper-slide-active') ) {
                galleryMain.slideTo(0);
                galleryThumbs.slideTo(0);
            }
            galleryMain.update();
            galleryMain.updateAutoHeight(10);
            galleryThumbs.update();
            initZoom('reinit',$oZoomSrc);
            $('.electron-product-gallery-popups .electron-product-popup').removeClass('active');
            $('.electron-product-gallery-popups .electron-product-popup:first-child').attr('href',$oMainSrc).addClass('active');
        }, 100 );
    });

    initZoom('load');

});