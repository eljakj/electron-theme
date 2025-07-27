jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    $(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function(){
        $(".electron-product-bottom-popup-cart").removeClass('active');
    });

    if ( $(window).width() < 992 && $(".electron-bottom-mobile-nav").length ) {
        $("body").addClass('has-bottom-fixed-menu');
    }

    var singleCartPos = $('.electron-product-summary .single_add_to_cart_button').offset();
    var singleCartTop = $('.electron-product-summary .single_add_to_cart_button').length && $(".electron-product-bottom-popup-cart").length ? singleCartPos.top : 0;
    var singleDocHeight = $(document).height() - 25;

    $(window).on("scroll", function () {

        if ( $(".electron-product-bottom-popup-cart").length && $(".electron-product-summary .single_add_to_cart_button").length ) {

            if ( $(window).scrollTop() > singleCartTop ) {
                $(".electron-product-bottom-popup-cart").addClass('active');
                $("body").addClass('bottom-popup-cart-active');
            } else {
                $(".electron-product-bottom-popup-cart").removeClass('active');
                $("body").removeClass('bottom-popup-cart-active');
            }
            
            if($(window).scrollTop() + $(window).height() > singleDocHeight ) {
                $(".electron-product-bottom-popup-cart").addClass('relative');
            } else {
                $(".electron-product-bottom-popup-cart").removeClass('relative');
            }
        }
    });

});

