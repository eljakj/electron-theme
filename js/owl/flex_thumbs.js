jQuery(document).ready(function($) {
	"use strict";

    $(".flex-control-thumbs").addClass("swiper-container");
    var countThumb = $(".flex-control-thumbs li").length;
    $(".flex-control-thumbs li").addClass("swiper-slide").wrapAll('<div class="swiper-wrapper"></div>');
    $(".flex-control-thumbs").attr("id","product-thumbnails");
    var items = $('.woocommerce-product-gallery.woocommerce-product-gallery--with-images').attr('data-columns');
    
    if ( countThumb < 5 ){
        $( '.electron-product-strech-type div.images .flex-control-thumbs' ).css('max-width', countThumb*100 );
    }
    
    var galleryThumbs  = new NTSwiper( '.flex-control-thumbs', {
        spaceBetween          : 10,
        slidesPerView         : 4,
        direction             : "horizontal",
        centeredSlides        : true,
        centeredSlidesBounds  : true,
        slideToClickedSlide   : true,
        breakpoints           : {
            320 : {
                slidesPerView : 5
            },
            1200 : {
                slidesPerView : 3
            },
            1400 : {
                slidesPerView : 5
            }
        }
    });

    $( 'body' ).on('change','.electron-variations select', function( e ) {
        galleryThumbs.slideTo(0);
        galleryThumbs.update();
    });

});
