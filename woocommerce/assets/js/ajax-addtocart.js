jQuery(document).ready(function($) {

    'use strict';

    if( $( '.electron-cart-count' ).length ) {

        var data = {
            'action': 'load_woo_cart'
        };

        $.post( electron_vars.ajax_url, data, function( response ) {
            $('.minicart-panel').replaceWith(response.minicart);
            $('.electron-cart-count').html(response.count);
        });
    }

    if ( electron_vars.product_ajax == 'yes' ) {
        // single page ajax add to cart
        $('body').on('submit', 'form.loop-cart', function(e) {
            // Redirect to cart option
            if ( electron_vars.cart_redirect === 'yes' ) {
                window.location = electron_vars.cart_url;
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
                    $('.electron-cart-count').html(fragments.count);
                    $('.electron-cart-total').html(fragments.total);
                    $('.electron-cart-goal-text').html(fragments.shipping.message);
                    $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                },
                error: function() {
                    btn.removeClass('loading');
                    console.log('cart-error');
                    $( document.body ).trigger( 'wc_fragments_ajax_error' );
                }
            });
        });
    }


    // AJax single add to cart
    $(document).on('click', 'a.electron_ajax_add_to_cart', function(e){
        // Redirect to cart option
        if ( electron_vars.cart_redirect === 'yes' ) {
            window.location = electron_vars.cart_url;
            return;
        }

        e.preventDefault();

        var btn  = $(this),
            pid  = btn.attr( 'data-product_id' ),
            qty  = parseFloat( btn.data('quantity') ),
            data = new FormData();

        data.append('add-to-cart', pid);

        if ( qty > 0 ) {
            data.append('quantity', qty);

            btn.addClass('loading');
            btn.closest('.electron-add-to-cart').addClass('loading');

            if ( electron_vars.popup_upsells == 'yes' ) {
                var hasUpsell = btn.parents('.product-inner').hasClass('has-upsell') ? true : false;
                if ( hasUpsell ) {
                    $(document.body).trigger('product_upsells_init',[pid,hasUpsell]);
                } else {
                    $('.electron-popup-cart .cart-upsell').fadeOut(1000);
                }
            }

            if ( btn.closest('.electron-popup-cart') ) {
                $('.electron-popup-cart').addClass('loading');
            }

            $.ajax({
                url        : electron_vars.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_ajax_add_to_cart' ),
                data       : data,
                type       : 'POST',
                processData: false,
                contentType: false,
                dataType   : 'json',
                success    : function( response ) {
                    var arrowSvg = '<svg class="svgRight electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>';
                    btn.removeClass('loading').addClass('added');
                    btn.attr('href',electron_vars.cart_url).attr('title',electron_vars.view).find('.cart-text').html(electron_vars.view);
                    if ( btn.hasClass('electron-btn-text') ) {
                        btn.html(electron_vars.view+arrowSvg);
                    }
                    btn.parent().find('.electron-hint').html(electron_vars.view);
                    btn.removeClass('electron_ajax_add_to_cart');
                    btn.find('svg').replaceWith(arrowSvg);
                    btn.closest('.electron-add-to-cart').removeClass('loading').addClass('added');

                    var fragments = response.fragments;
                    var appended  = '<div class="woocommerce-notices-wrapper">'+fragments.notices+'</div>';
                    var duration  = electron_vars.duration;

                    $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                        $(this).remove();
                    });

                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-count').html(fragments.count);

                    $('.electron-side-panel').attr('data-cart-count',fragments.count);
                    $('.electron-cart-total:not(.page-cart)').html(fragments.total);
                    if ( $('.electron-cart-goal-text').length>0 ) {
                        $('.electron-cart-goal-text').html(fragments.shipping.message);
                        $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                        if ( fragments.shipping.value >= 100 ) {
                            $('.electron-cart-goal-wrapper').addClass('free-shipping-success shakeY');
                        }
                    }

                    // side panel
                    if ( electron_vars.minicart_open === 'yes' && electron_vars.minicart_type === 'panel' && $('.electron-side-panel').length>0 ) {
                        $('.electron-side-panel').addClass('active');
                        $('.page-overlay').attr('data-target','.electron-side-panel');
                        $('html,body').addClass('has-overlay');
                    }

                    // popup cart
                    if ( electron_vars.minicart_open === 'yes' && $('.electron-popup-cart').length && electron_vars.minicart_type == 'popup' ) {
                        var cartItem = $(fragments.minicart).find('.woocommerce-mini-cart-item[data-pid="'+pid+'"] .cart-item-details').clone();
                        var cartFooter = $(fragments.minicart).find('.header-cart-footer').clone();
                        var cartGoal = $(fragments.minicart).find('.electron-cart-goal-wrapper').clone();
                        $('.electron-popup-cart .cart-item').html(cartItem).attr('data-pid',pid);
                        $('.electron-popup-cart .cart-footer').html(cartFooter);
                        $('html,body').addClass('has-popup-overlay');
                        $('.electron-popup-cart').addClass('active');
                        $( '.electron-popup-cart .cart-item-wrapper' ).removeClass('hidden');
                        $( '.electron-popup-cart .popup-cart-inner' ).removeClass('cart-empty');
                        $( '.electron-popup-cart .cart-item' ).removeClass('loading');

                        if ( !hasUpsell ) {
                            $( '.electron-popup-cart' ).removeClass('loading');
                        }
                    }

                    // Redirect to cart option
                    if ( electron_vars.cart_redirect === 'yes' ) {
                        window.location = electron_vars.cart_url;
                        return;
                    }
                },
                error: function() {
                    $( document.body ).trigger( 'wc_fragments_ajax_error' );
                }
            });
        }
    });

    $(document).on('click', '.electron_remove_from_cart_button', function(e){
        e.preventDefault();

        var $this = $(this),
            pid   = $this.data('product_id'),
            note  = electron_vars.removed,
            cart  = $this.closest('.electron-minicart'),
            mcart = $this.closest('.mini-panel .electron-spinner'),
            row   = $this.closest('.electron-cart-item'),
            key   = $this.data( 'cart_item_key' ),
            name  = $this.data('name'),
            qty   = $this.data('qty'),
			btn   = $('.elc-btn[data-product_id="'+pid+'"]'),
            msg   = qty ? qty+' &times '+name+' '+note : name+' '+note,
            dur   = electron_vars.duration;

            msg   = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+msg+'</div></div>';

        $(msg).appendTo('.electron-shop-popup-notices').delay(dur).fadeOut(300, function(){
            $(this).remove();
        });

        cart.addClass('loading');
        mcart.addClass('loading');

        row.remove();

        var cartItems = cart.find('.mini-cart-item').length;

        if ( cartItems == 0 ) {
            cart.addClass('no-products');
        }

        $.ajax({
            url      : electron_vars.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_remove_from_cart' ),
            type     : 'POST',
            dataType : 'json',
            data     : {
                cart_item_key : key
            },
            success  : function( response ){
                var fragments = response.fragments;
				var bagSvg = '<svg class="svgaddtocart electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><use href="#shopBag"></use></svg>';


				$('.elc-btn[data-product_id="'+pid+'"]:not(.electron-btn-text)').each(function() {
					var btn   = $(this);
					var href  = btn.attr('data-ohref');
					var title = btn.attr('data-title');
					var cls   = btn.attr('data-oclass');

					btn.removeClass('added').attr('href',href).attr('class',cls).attr('title',title).find('.cart-text').html(title);
                	btn.parents('.btn-type-icon').find('.electron-hint').html(title);
                	btn.find('svg').replaceWith(bagSvg);
                    if ( btn.hasClass('type-variable') ) {
                        var btn_reset = btn.parents('.product-inner').find('.reset_variations');
                        $(btn_reset).trigger('click');
                    }

				});

				$('.elc-btn[data-product_id="'+pid+'"].electron-btn-text').each(function() {
					var btn   = $(this);
					var href  = btn.attr('data-ohref');
					var title = btn.attr('data-title');
					var cls   = btn.attr('data-oclass');
					btn.removeClass('added').attr('href',href).attr('class',cls).attr('title',title).html(title);
                    if ( btn.hasClass('type-variable') ) {
                        var btn_reset = btn.parents('.product-inner').find('.reset_variations');
                        $(btn_reset).trigger('click');
                    }
				});

                if ( $('.electron-popup-cart').length && electron_vars.minicart_type == 'popup' ) {
                    $( '.electron-popup-cart .cart-item-wrapper' ).addClass('hidden');
                    $( '.electron-popup-cart .cart-item-details' ).remove();
                    var cartFooter = $(fragments.minicart).find('.header-cart-footer').clone();
                    $('.electron-popup-cart .cart-footer').html(cartFooter);
                }

                $('.minicart-panel').replaceWith(fragments.minicart);
                $('.electron-cart-count').html(fragments.count);
                $('.electron-side-panel').attr('data-cart-count',fragments.count);
                $('.electron-cart-total:not(.page-cart)').html(fragments.total);
                if ( $('.electron-cart-goal-text').length>0 ) {
                    $('.electron-cart-goal-text').html(fragments.shipping.message);
                    $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                    if ( fragments.shipping.value >= 100 ) {
                        $('.electron-cart-goal-wrapper').addClass('free-shipping-success shakeY');
                    } else {
                        $('.electron-cart-goal-wrapper').removeClass('free-shipping-success shakeY');
                    }
                }
                cart.removeClass('loading no-products');
                mcart.removeClass('loading');

                $( document.body ).trigger( 'removed_from_cart', [ fragments, response.cart_hash, btn ] );
                $('.electron-product-inner[data-product_id="'+pid+'"] .reset_variations').trigger('click');

                if ( electron_vars.is_cart == 'yes' || electron_vars.is_checkout == 'yes'  ) {
                    location.reload(); // page reload
                }
            },
            error: function() {
                $( document.body ).trigger( 'wc_fragments_ajax_error' );
            }
        });
    });

    $(document).on('click', '.product-remove .remove', function(e){
        var $this = $(this),
            pid   = $this.data('product_id');

        $( '.electron-minicart .electron_remove_from_cart_button[data-product_id="'+pid+'"]' ).trigger( 'click' );
    });

    $(document).on('updated_wc_div', function() {
        if ( electron_vars.is_cart == 'yes' ) {
            $.ajax({
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_ajax_add_to_cart' ),
                type: 'POST',
                data: {
                    action: 'electron_ajax_add_to_cart'
                },
                success: function(response) {
                    var fragments = response.fragments;

                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-count').html(fragments.count);
                    $('.electron-side-panel').attr('data-cart-count',fragments.count);
                    $('.electron-cart-total:not(.page-cart)').html(fragments.total);

                    if ( $('.electron-cart-goal-text').length>0 ) {
                        $('.electron-cart-goal-text').html(fragments.shipping.message);
                        $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                        if ( fragments.shipping.value >= 100 ) {
                            $('.electron-cart-goal-wrapper').addClass('free-shipping-success shakeY');
                        } else {
                            $('.electron-cart-goal-wrapper').removeClass('free-shipping-success shakeY');
                        }
                    }
                }
            });
        }
    });

    $(document).on('click', '.electron_clear_cart_button', function(e){
        var confirmMsg = electron_vars.clear;
        if ( confirm( confirmMsg ) ){
            $.ajax({
                type     : 'POST',
                dataType : 'json',
                url      : wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_clear_cart' ),
                data     : {
                    action : 'electron_clear_cart'
                },
                success  : function ( response ) {

                    var fragments = response.fragments;
                    var message   = fragments.clear.msg;
                    var duration  = electron_vars.duration;

                    if ( fragments.clear.status != 'success' ) {
                        alert(message);
                    } else {

                        var appended = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+message+'</div></div>';
                        $(appended).appendTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                            $(this).remove();
                        });

                        // update other areas
                        $('.minicart-panel').replaceWith(fragments.minicart);
                        $('.electron-cart-count').html(fragments.count);
                        $('.electron-side-panel').attr('data-cart-count',fragments.count);
                        $('.electron-cart-total:not(.page-cart)').html(fragments.total);

                        if ( $('.electron-cart-goal-text').length>0 ) {
                            $('.electron-cart-goal-text').html(fragments.shipping.message);
                            $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                            $('.electron-cart-goal-wrapper').removeClass('free-shipping-success shakeY');
                        }

                        location.reload(); // page reload

                        $(document.body).trigger('electron_reset_all_cart_btn');
                    }
                }
            });
        }
    });

    // AJax cart cuantity
    var timeout;

    $(document).on('change input', '.cart-quantity-wrapper .quantity .qty', function() {

        var input = $(this),
            qty   = input.val(),
            key   = input.parents('.cart-quantity-wrapper').data('key'),
            id    = input.parents('.cart-quantity-wrapper').data('product_id'),
            name  = input.parents('.woocommerce-mini-cart-item').find('.cart-name').html(),
            btn   = $('.elc-btn[data-product_id="'+id+'"]'),
            href  = btn.attr('data-ohref'),
            title = btn.attr('data-title'),
            cls   = btn.attr('data-oclass');

        if ( input.parents('.electron-loop-product').length ) {
            name = input.parents('.electron-loop-product').find('.electron-loop-product-name').html();
        }

        if ( qty == 0 ) {
            input.parents('.cart-quantity-wrapper .quantity').addClass('loading');
            btn.removeClass('added').attr('href',href).attr('class',cls).attr('title',title).find('.cart-text').html(title);
            btn.parents('.btn-type-icon').find('.electron-hint').html(title);
            btn.find('svg').replaceWith('<svg class="svgaddtocart electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><use href="#shopBag"></use></svg>');
        }

        clearTimeout(timeout);

        timeout = setTimeout(function() {
            $.ajax({
                url     : electron_vars.ajax_url,
                dataType: 'json',
                method  : 'GET',
                data    : {
                    action  : 'electron_quantity_button',
                    id      : key,
                    qty     : qty,
                    is_cart : electron_vars.is_cart
                },
                beforeSend  : function(){
                    if ( input.parents('.woocommerce-mini-cart-item').length ) {
                        input.parents('.woocommerce-mini-cart-item').addClass('loading').append('<span class="loading-wrapper"><span class="ajax-loading"></span></span>');
                    } else {
                        input.parents('.cart-quantity-wrapper').addClass('loading');
                    }
                },
                success : function(data) {

                    input.parents('.cart-quantity-wrapper').removeClass('loading');
                    input.parents('.woocommerce-mini-cart-item').removeClass('loading');

                    if (data && data.fragments) {

                        var fragments = data.fragments;
                        var minicart  = fragments.minicart;
                        var duration  = electron_vars.duration;
                        var appended  = '';

                        if ( fragments.count != 0 ) {
                            if ( qty == 0 ) {
                                appended  = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message update-message"><span class="update">'+electron_vars.updated+'</span> <strong>"'+name+'"</strong> '+electron_vars.removed+'</div></div>';
                                $('.electron-popup-cart .cart-item-wrapper').addClass('hidden');
                            } else {
                                appended  = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message update-message"><span class="update">'+electron_vars.updated+'</span>'+qty+'&times <strong>"'+name+'"</strong> '+electron_vars.added+'</div></div>';
                            }
                        }

                        if ( fragments.count == 0 ) {
                            appended  = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message update-message">'+fragments.update.msg+'</div></div>';
                        }

                        $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                            $(this).remove();
                        });

                        // update other areas
                        $('.minicart-panel').replaceWith(minicart);
                        $('.electron-cart-count').html(fragments.count);
                        $('.electron-side-panel').data('cart-count',fragments.count);
                        $('.electron-cart-total:not(.page-cart)').html(fragments.total);

                        if ( $('.electron-cart-goal-wrapper').length>0 ) {
                            $('.electron-cart-goal-text').html(fragments.shipping.message);
                            $('.electron-progress-bar').css('width',fragments.shipping.value+'%');
                            if ( fragments.shipping.value >= 100 ) {
                                $('.electron-cart-goal-wrapper').addClass('free-shipping-success shakeY');
                            } else {
                                $('.electron-cart-goal-wrapper').removeClass('free-shipping-success shakeY');
                            }
                        }

                        if ( input.parents('.electron-popup-cart').length>0 ) {
                            var cartItem = $(minicart).find('.woocommerce-mini-cart-item[data-pid="'+id+'"] .cart-item-details').clone();
                            var cartFooter = $(minicart).find('.header-cart-footer').clone();
                            $('.electron-popup-cart .cart-item').html(cartItem);
                            $('.electron-popup-cart .cart-footer').html(cartFooter);
                        }

                        if ( fragments.count == 0 ) {
                            $( '.electron-popup-cart .popup-cart-inner' ).addClass('cart-empty');
                            var cartFooter2 = $(minicart).find('.cart-empty-content').clone();
                            $('.electron-popup-cart .cart-footer').html(cartFooter2);
                            $('.electron-popup-cart .upsells').remove();
                        }

                        $(document.body).trigger('electron_update_minicart');

                        if ( $('.cross-sells .electron-swiper-slider').length>0 ) {
                            $('.electron-swiper-slider').each(function () {
                                const options  = $(this).data('swiper-options');
                                const mySlider = new NTSwiper(this, options );
                            });
                        }

                        if ( electron_vars.is_cart == 'yes' || electron_vars.is_checkout == 'yes'  ) {
                            location.reload(); // page reload
                        }

                        $(document.body).trigger('wc_fragment_refresh')
                    }
                },
                error: function() {
                    $( document.body ).trigger( 'wc_fragments_ajax_error' );
                }
            });
        }, 500);
    });

    $(document).on('click', '.cart-bottom-actions .action', function(e){
        e.preventDefault();
        var target = $(this).data('target');
        var height = $(target).outerHeight();

        $(target).addClass('active');

    });

    $(document.body).on('click', '.minicart-panel .panel-close', function(e){
        e.preventDefault();
        $(this).parents('.minicart-panel').find('.minicart-panel-inner').removeAttr('style');
    });

    $('.minicart-panel .electron-remove-coupon').each(function(e){
        var $this = $(this);
        var code  = $this.attr('data-coupon');
        $('.minicart-panel .coupons>li>a[data-coupon="'+code+'"]').addClass('applied');
        $('.electron-summary-item .coupon>a[data-coupon="'+code+'"]').parent().addClass('applied');
    });

    $(document).on('click', '.coupons>li>div:not(.applied),.coupon:not(.applied) div.add-coupon,.cart-total-item a.electron-remove-coupon', function(e){
        e.preventDefault();

        var $this       = $(this);
        var coupon      = $this.attr('data-coupon');
        var checkout    = electron_vars.is_checkout == 'yes' ? 'yes' : 'no';
        var action_type = $this.is('.electron-remove-coupon') ? 'remove' : 'add';

        $this.parents('.coupons').addClass('loading');

        $.ajax({
            url: electron_vars.ajax_url, // WordPress AJAX URL
            type: 'POST',
            data: {
                action      : 'electron_apply_coupon',
                coupon_code : coupon,
                action_type : action_type
            },
            success: function(response) {

                $this.parents('.coupons').removeClass('loading active');

                if ( $this.is('.add-coupon') ) {
                    $this.parent().addClass('applied');
                }

                var fragments = response.fragments;
                var duration  = electron_vars.duration;
                var msg = '';

                if ( action_type == 'remove' ) {
                    msg = electron_vars.coupon_remove;
                } else {
                    msg = fragments.notices;
                }
                var appended  = '<div class="woocommerce-notices-wrapper">'+msg+'</div>';

                $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
                    $(this).remove();
                });

                if ( action_type == 'remove' ) {
                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-total:not(.page-cart)').html(fragments.total);
                    $('.minicart-panel .coupons>li>a[data-coupon="'+coupon+'"]').removeClass('applied');
                }

                if ( fragments.coupon.applied == true ) {

                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-total:not(.page-cart)').html(fragments.total);
                    $('.minicart-panel .coupons>li>a[data-coupon="'+coupon+'"]').addClass('applied');
                    $( document.body ).trigger( 'applied_coupon', [ coupon ] );
                }
            }
        });
    });

    if ( electron_vars.minicart_type == 'popup' ) {
        $(document.body).on('product_upsells_init',function(ev,pid,hasUpsell) {
            if ( pid ) {
                $.ajax({
                    type : 'POST',
                    url  : electron_vars.ajax_url,
                    data : {
                        action : 'cart_upsells_init',
                        pid    : pid
                    },
                    beforeSend: function() {
                        if ( hasUpsell == 'no' ) {
                            $('.electron-popup-cart .cart-upsell .up-sells').remove();
                            $('.electron-popup-cart .cart-upsell').hide();
                        }
                    },
                    success: function(response) {
                        $('.electron-popup-cart .cart-upsell').html(response);
                        const options  = $('.electron-popup-cart .electron-swiper-slider').data('swiper-options');
                        const mySlider = new NTSwiper('.electron-popup-cart .electron-swiper-slider', options );
                        $('.electron-popup-cart').removeClass('loading').addClass('loaded');
                        $('.electron-popup-cart .cart-upsell').fadeIn('slow');
                    },
                    error: function(error) {
                        console.error(error.responseText);
                    }
                });
            }
        });
    }

});
