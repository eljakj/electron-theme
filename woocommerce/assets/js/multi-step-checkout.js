jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    //multiStepCheckout();
    function multiStepCheckout() {
        var $body               = $('body'),
            login               = $('.electron-woocommerce-checkout-login'),
            billing             = $('.electron-customer-billing-details'),
            shipping            = $('.electron-customer-shipping-details'),
            order               = $('.electron-order-review'),
            payment             = $('.electron-payment'),
            form_actions        = $('.electron-form-actions'),
            coupon              = $('.electron-checkout-coupon'),
            timeline            = $(),
            steps               = new Array(login, billing, shipping, order, payment),
            is_user_logged_in   = $body.hasClass('logged-in');

        $body.on( 'updated_checkout electron_multistep_myaccount_order_pay', function(e) {
            steps[4] = $('#payment');
            if(e.type == 'updated_checkout' ) {
                steps[4] = $('#payment');
            }
            $('#payment').find( 'input[name=payment_method]' ).on( 'click', function() {
                if ($('.payment_methods input.input-radio').length > 1) {
                    var target_payment_box = $('div.payment_box.' + $(this).attr('ID'));
                    if ($(this).is(':checked') && !target_payment_box.is(':visible')) {
                        $('div.payment_box').filter(':visible').slideUp(250);

                        if ($(this).is(':checked')) {
                            $('div.payment_box.' + $(this).attr('ID')).slideDown(250);
                        }
                    }
                } else {
                    $('div.payment_box').show();
                }

                if ($(this).data('order_button_text')) {
                    $('#place_order').val($(this).data('order_button_text'));
                } else {
                    $('#place_order').val($('#place_order').data('value'));
                }
            });
        });

        if ($body.hasClass('woocommerce-order-pay')) {
            $body.trigger('electron_multistep_myaccount_order_pay');
        }

        $body.on('electron_multistep_select2', function (event) {
            if ($().select2) {
                var wc_country_select_select2 = function () {
                    $('select.country_select, select.state_select').each(function () {
                        var select2_args = {
                            placeholder      : $(this).attr('placeholder'),
                            placeholderOption: 'first',
                            width            : '100%'
                        };

                        $(this).select2(select2_args);
                    });
                };

                wc_country_select_select2();

                $body.bind('country_to_state_changed', function () {
                    wc_country_select_select2();
                });
            }
        });

        $body.trigger('electron_multistep_select2');

        if ( $('.electron-checkout-content').length ) {

            var checkoutMultiSteps = new NTSwiper('.electron-checkout-content', {
                loop          : false,
                speed         : 500,
                spaceBetween  : 10,
                autoHeight    : true,
                nested        : true,
                simulateTouch : false,
                navigation    : {
                    nextEl: '.electron-checkout-content .electron-checkout-button-next',
                    prevEl: '.electron-checkout-content .electron-checkout-button-prev'
                },
                on: {
                    resize: function () {
                        var swiper = this;
                        swiper.update();
                    },
                    slideChange: function () {
                        var swiper = this;
                        var realIndex = swiper.realIndex;
                        $( '.electron-step-item:not(:eq('+realIndex+'))' ).addClass('active');
                        $( '.electron-step-item:eq('+realIndex+')' ).next().removeClass('active');
                        $( '.electron-step-item:eq('+realIndex+')' ).next().next().removeClass('active');
                    }
                },
                effect: 'slide',
                creativeEffect: {
                    prev: { translate: [0, 0, -400] },
                    next: { translate: ['100%', 0, 0] }
                },
                pagination: {
                    el: ".electron-page-multistep-checkout .electron-swiper-pagination",
                    type: 'bullets',
                    bulletClass: 'electron-bullets',
                    bulletActiveClass: 'active',
                    clickable: true,
                    renderBullet: function (index, className) {
                        var labels = $('.electron-page-multistep-checkout .electron-swiper-pagination').data('steps-labels');
                        return '<div class="electron-step-item electron-step-item-' + (index + 1) + ' ' + className + '"><span class="electron-step">' + (index + 1) + '</span><span class="electron-step-label electron-login">' + labels.labels[(index)] + '</span></div>';
                    }
                }
            });

            var checkoutLoginSteps = new NTSwiper('.electron-checkout-form-login', {
                loop          : false,
                speed         : 500,
                spaceBetween  : 5,
                autoHeight    : true,
                simulateTouch : false,
                navigation    : {
                    nextEl: '.electron-checkout-form-login .electron-checkout-form-button-register',
                    prevEl: '.electron-checkout-form-login .electron-checkout-form-button-login'
                },
                on: {
                    resize: function () {
                        var swiper = this;
                        swiper.update();
                    }
                },
                effect: 'slide',
                creativeEffect: {
                    prev: { translate: [0, 0, -400] },
                    next: { translate: ['100%', 0, 0] }
                }
            });

            $('body').on('input validate change', '.input-text, select, input:checkbox', function(e){
                var $this       = $( this ),
                    $parent     = $this.closest( '.form-row' ),
                    event_type  = e.type;

                if ( 'validate' === event_type && $parent.hasClass( 'woocommerce-invalid-required-field' ) ) {

                    $( '.woocommerce-billing-fields .woocommerce-invalid-required-field' ).parents('.swiper-slide').addClass( 'has-error' );

                    setTimeout(function(){
                        var getInvalidSection = $( '.swiper-slide.has-error' ).index();
                        checkoutMultiSteps.slideTo(getInvalidSection);
                        checkoutMultiSteps.updateAutoHeight(10);
                    }, 300 );

                    if ( $('.woocommerce-NoticeGroup').length ) {
                        var $targetFirst = $('.woocommerce-NoticeGroup .woocommerce-error li:first-child').data('id'),
                            $targetFirstEl = $('#'+$targetFirst+'_field');
                    }
                }
            });
        }
    }
});
