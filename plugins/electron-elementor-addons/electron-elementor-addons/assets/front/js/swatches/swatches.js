'use strict';

window.electron = {};

(
function(electron, $) {
    electron = electron || {};

    $.extend(electron, {
        Swatches: {
            init: function() {
                var $term = $('.electron-term'),
                $active_term = $('.electron-term:not(.electron-disabled)');

                // load default value
                $term.each(function() {
                    var $this   = $(this),
                        term    = $this.attr('data-term'),
                        attr    = $this.closest('.electron-terms').attr('data-attribute'),
                        select1 = $this.closest('.electron-terms').parent().find('select[name="' + attr +'"]'),
                        select2 = $this.closest('.electron-terms').parent().find('select#' + attr),
                        $select = $this.is('.a-term') ? select1 : select2,
                        val     = $select.val();

                    if ( val != '' && term == val ) {
                        $(this).addClass('electron-selected');
                    }
                });

                $active_term.unbind('click touch').on('click touch', function(e) {
                    if ( $(this).hasClass('electron-disabled') ) {
                        return false;
                    }
                    var $this   = $(this),
                        term    = $this.attr('data-term'),
                        title   = $this.attr('data-title'),
                        attr    = $this.closest('.electron-terms').attr('data-attribute'),
                        select1 = $this.closest('.electron-terms').parent().find('select[name="' + attr +'"]'),
                        select2 = $this.closest('.electron-terms').parent().find('select#' + attr),
                        $select = $this.is('.a-term') ? select1 : select2;

                    if ( !$this.hasClass('electron-selected') ) {
                        $select.val(term).trigger('change');

                        $this.closest('.electron-terms').find('.electron-selected').removeClass('electron-selected');

                        $this.addClass('electron-selected');

                        $(document).trigger('electron_selected', [attr, term, title,$select]);
                    }
                    e.preventDefault();
                });

                $(document).on('woocommerce_update_variation_values', function(e) {
                    $(e.target).find('select').each(function() {
                        var $this  = $(this);
                        var $terms = $this.parent().parent().find('.electron-terms');

                        $terms.find('.electron-term').removeClass('electron-enabled').addClass('electron-disabled');

                        $this.find('option.enabled').each(function() {
                            var val = $(this).val();
                            $terms.find('.electron-term[data-term="' + val + '"]').removeClass('electron-disabled').addClass('electron-enabled');
                        });
                    });
                });
            }
        }
    });

}).apply(this, [window.electron, jQuery]);

(
function(electron, $) {

    $(document).on('wc_variation_form', function() {
        if ( typeof electron.Swatches !== 'undefined' ) {
            electron.Swatches.init();
        }
    });

    $(document).ready(function($) {
        $('.electron-products .variations_form:not(.loop-cart), .electron-tab-wrapper .variations_form:not(.loop-cart)').each(function () {
            $(this).wc_variation_form();
        });
    });

    $(document.body).on('electron_variations_init', function() {
        if ( typeof electron.Swatches !== 'undefined' ) {
            electron.Swatches.init();
        }
        $('.electron-products .variations_form:not(.loop-cart)').each(function () {
            $(this).wc_variation_form();
        });
    });

    $(document).on('found_variation', function(e, t) {
        if ( $(e.target).closest('.electron-loop-swatches').length ) {
            var $product  = $(e.target).closest('.electron-loop-product'),
                $atc      = $product.find('.electron-quick-shop-btn'),
                $atc2     = $product.find('.electron_swatches_add_to_cart'),
                $image    = $product.find('.product-thumb img'),
                $price    = $product.find('.price');

            if ( $atc.length || $atc2.length ) {
                $product.find('.electron-add-to-cart .electron-hint').text(electron_vars.addto);
                $product.find('.electron-add-to-cart-btn.btn-type-icon .electron-hint').text(electron_vars.addto);
                $product.find('.electron-add-to-cart-btn.btn-type-icon .electron_swatches_add_to_cart').attr('title',electron_vars.addto);
                $product.find('.electron-quick-shop-btn').attr('title',electron_vars.addto);
                $atc.find('.cart-text').text(electron_vars.addto);

                if ( $atc.hasClass('electron-quick-shop-btn') ) {
                    $atc.addClass('electron_swatches_add_to_cart').removeClass('electron-quick-shop-btn');
                }

                $atc.attr('data-variation_id', t.variation_id).attr('data-product_sku', t.sku);
                $atc2.attr('data-variation_id', t.variation_id).attr('data-product_sku', t.sku);

                if ( !t.is_purchasable || !t.is_in_stock ) {
                    $atc.addClass('disabled wc-variation-is-unavailable');
                } else {
                    $atc.removeClass('disabled wc-variation-is-unavailable');
                }

                $atc.removeClass('added error loading');
            }

            // product image
            if ( $image.length ) {

                if ( $image.attr('data-src') == undefined ) {
                    $image.attr('data-src', $image.attr('src'));
                }

                if ( t.image.thumb_src != undefined && t.image.thumb_src != '' ) {
                    $image.attr('src', t.image.thumb_src);
                } else {
                    if ( t.image.src != undefined && t.image.src != '' ) {
                        $image.attr('src', t.image.src);
                    }
                }
            }

            // product price
            if ( $price.length ) {
                if ( $price.attr('data-price') == undefined ) {
                    $price.attr('data-price', $price.html());
                }

                if ( t.price_html ) {
                    $price.html( t.price_html );
                }
            }

            $(document).trigger('electron_archive_found_variation', [t]);
        }

        $(e.target).closest('.has-qty.ptype-variable').addClass('found-variation');
        $(e.target).closest('.has-qty.ptype-variable').find('.electron-btn-reset.reset_variations').addClass('active');

        if ( $(e.target).closest('.product-slider__card').length ) {

            var $product3  = $(e.target).closest('.product-slider__card'),
                $atc3      = $product3.find('a.type-variable'),
                $price3    = $product3.find('.price');

            if ( $atc3.length  ) {

                if ( $atc3.hasClass('electron-quick-shop-btn')  ) {
                    $atc3.addClass('electron_swatches_add_to_cart').removeClass('electron-quick-shop-btn');
                }

                $atc3.find('.cart-text').text(electron_vars.addto);

                $atc3.attr('data-variation_id', t.variation_id).attr('data-product_sku', t.sku);

                if ( !t.is_purchasable || !t.is_in_stock ) {
                    $atc3.addClass('disabled wc-variation-is-unavailable');
                } else {
                    $atc3.removeClass('disabled wc-variation-is-unavailable');
                }

                $atc3.removeClass('added error loading');
            }

            // product price
            if ( $price3.length ) {
                if ( $price3.attr('data-price') == undefined ) {
                    $price3.attr('data-price', $price.html());
                }

                if ( t.price_html ) {
                    $price3.html( t.price_html );
                }
            }

            $(document).trigger('electron_archive_found_variation', [t]);
        }
    });

    $(document).on('reset_data', function(e) {
        var $target = $(e.target);

        $target.find('.electron-selected').removeClass('electron-selected');

        $(e.target).closest('.has-qty.ptype-variable').removeClass('found-variation');
        $(e.target).closest('.has-qty.ptype-variable').find('.electron-btn-reset.reset_variations').removeClass('active');

        $target.find('select').each(function() {
          var attr  = $(this).attr('id');
          var title = $(this).find('option:selected').text();
          var term  = $(this).val();

          if (term != '') {
            $(this).parent().parent().find('.electron-term[data-term="' + term + '"]').addClass('electron-selected');
            $(document).trigger('electron_select', [attr, term, title]);
          }
        });

        if ( $target.closest('.electron-loop-swatches').length ) {
            var $product  = $target.closest('.electron-loop-product'),
                $atc      = $product.find('.electron-product-cart'),
                $atci     = $product.find('.electron-add-to-cart-btn.btn-type-icon'),
                $image    = $product.find('img'),
                $price    = $product.find('.price');

            if ( $atc.length || $atci.length ) {
                $atc.removeClass('electron_swatches_add_to_cart').addClass('electron-quick-shop-btn').attr('data-variation_id', '0').attr('data-product_sku', '');

                $atci.find('.btn-type-icon').removeClass('electron_swatches_add_to_cart').addClass('electron-quick-shop-btn').attr('data-variation_id', '0').attr('data-product_sku', '');
                $product.removeClass('added error loading');
            }

            // add to cart button text
            if ( $atc.length || $atci.length ) {
                var title = $atc.attr('data-title');
                var title2 = $atci.attr('data-label');
                $atc.find('.cart-text').text(title).attr('title',title);
                $atci.find('.electron-hint').text(title2);
                $atci.find('.btn-type-icon').attr('title',title);
                $atc.find('svg').replaceWith('<svg class="svgaddtocart electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><use href="#shopBag"></use></svg>');
                $atci.find('svg').replaceWith('<svg class="svgaddtocart electron-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 32 32"><use href="#shopBag"></use></svg>');
            }

            // product image
            if ( $image.length ) {
                $image.attr('src', $image.attr('data-src'));
                $image.attr('srcset', $image.attr('data-srcset'));
                $image.attr('sizes', $image.attr('data-sizes'));
            }

            // product price
            if ( $price.length ) {
                $price.html($price.attr('data-price'));
            }

            $target.closest('.electron-loop-swatches').addClass('resettting');

            $(document).trigger('electron_archive_reset_data',[e]);
        }
    });

    $(document).on('click touch', '.electron_swatches_add_to_cart', function(e) {
        e.preventDefault();
        var btn        = $(this);
        var $product   = btn.closest('.electron-loop-product');
        var $product2  = btn.closest('.product-slider__card');
        var pid        = btn.attr('data-product_id');
        var attributes = {};

        btn.removeClass('added').addClass('electron-spinner loading');

        if ( electron_vars.popup_upsells == 'yes' ) {
            var hasUpsell = btn.parents('.product-inner').hasClass('has-upsell') ? true : false;
            if ( hasUpsell ) {
                $(document.body).trigger('product_upsells_init',[btn.attr('data-product_id'),hasUpsell]);
            } else {
                $('.electron-popup-cart .cart-upsell').fadeOut(1000);
            }
        }

        if ( $product.length ) {

            $product.find('[name^="attribute"]').each(function() {
                attributes[$(this).attr('data-attribute_name')] = $(this).val();
            });

            var data = {
                action       : 'electron_shop_swatches_add_to_cart',
                product_id   : btn.attr('data-product_id'),
                variation_id : btn.attr('data-variation_id'),
                quantity     : btn.attr('data-quantity'),
                attributes   : JSON.stringify(attributes),
            };

            $.post(electron_vars.ajax_url, data, function(response) {

                btn.removeClass('electron-spinner loading').addClass('added');

                if (response) {

                    btn.attr('href',electron_vars.cart_url).removeClass('electron_swatches_add_to_cart').attr('title',electron_vars.view).find('.cart-text').html(electron_vars.view);
                    btn.parent().find('.electron-hint').html(electron_vars.view);
                    btn.removeClass('electron_ajax_add_to_cart');
                    btn.removeClass('electron-quick-shop-btn');
                    btn.find('svg').replaceWith('<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>');

                    var fragments = response.fragments;

                    if ( fragments.hasOwnProperty('add') ) {

                        var pname = fragments.add.title;
                        var pqty  = fragments.add.qty;
                        var pattr = fragments.add.variation;
                        var attr  = '';

                        for (var attributeName in pattr) {
                            if (pattr.hasOwnProperty(attributeName)) {
                                var attributeValue = attributes[attributeName];
                                attr += ' '+attributeValue+', ';
                            }
                        }
                        var msg = pqty+' x <strong>'+pname+'</strong> '+attr+' '+electron_vars.added;

                        var appended  = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+msg+'</div></div>';

                        $(appended).prependTo('.electron-shop-popup-notices').delay(4000).fadeOut(300, function(){
                            $(this).remove();
                        });
                    }

                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-count').html(fragments.count);
                    $('.electron-side-panel').attr('data-cart-count',fragments.count);
                    $('.electron-cart-total:not(.page-cart)').html(fragments.total);

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

        if ( $product2.length ) {

            $product2.find('[name^="attribute"]').each(function() {
                attributes[$(this).attr('data-attribute_name')] = $(this).val();
            });

            var data2 = {
                action       : 'electron_shop_swatches_add_to_cart',
                product_id   : btn.attr('data-product_id'),
                variation_id : btn.attr('data-variation_id'),
                quantity     : btn.attr('data-quantity'),
                attributes   : JSON.stringify(attributes),
            };

            $.post(electron_vars.ajax_url, data2, function(response) {

                btn.removeClass('electron-spinner loading').addClass('added');

                if (response) {

                    btn.attr('href',electron_vars.cart_url).removeClass('electron_swatches_add_to_cart').attr('title',electron_vars.view).find('.cart-text').html(electron_vars.view);
                    btn.removeClass('electron_ajax_add_to_cart');
                    btn.removeClass('electron-quick-shop-btn');
                    btn.find('svg').replaceWith('<svg class="svgRight" width="512" height="512" fill="currentColor" viewBox="0 0 512 512"><use href="#arrowRight"></use></svg>');

                    var fragments = response.fragments;

                    // update other areas
                    $('.minicart-panel').replaceWith(fragments.minicart);
                    $('.electron-cart-count').html(fragments.count);
                    $('.electron-side-panel').attr('data-cart-count',fragments.count);
                    $('.electron-cart-total').html(fragments.total);

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

    $(document).on('electron_selected',function(e,attr, term, title,select_box) {
        $(select_box).parents('.attr-'+attr).addClass('activate');
        var count       = $(select_box).parents('.electron-variations').data('count');
        var count2      = $(select_box).parents('.electron-variations').find('.activate').length;
        var progressBar = $(select_box).parents('.electron-loop-product').find(".js-progress-bar");
        var loading     = $(select_box).parents('.electron-loop-product').find(".electron-swatches-loading");

        $(select_box).parents('.electron-loop-swatches').removeClass('resettting').find('a.reset_variations').slideDown();
    });

}).apply(this, [window.electron, jQuery]);
