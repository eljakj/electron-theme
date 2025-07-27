jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    // quick shop start
    electronQuickShopPopup();

    $(document).on('electronShopInit', function() {
        electronQuickShopPopup();
    });

    $(document.body).on('trigger_quick_shop', function(e,btn) {
        $(btn).trigger('click');
    });

    function electronQuickShopPopup(){

       $( document.body ).on('click', '.electron-quick-shop-btn', function(event) {
            event.preventDefault();

            var $this = $(this),
                id    = $this.data('product_id');


            if (  $this.closest('.electron-popup-cart') ) {
                $('.electron-popup-cart .panel-close').trigger('click');
            }

            $.magnificPopup.open({
                items           : {
                    src : electron_vars.ajax_url + '?product_id=' + id
                },
                mainClass       : 'mfp-electron-quickshop electron-mfp-slide-bottom',
                removalDelay    : 160,
                overflowY       : 'scroll',
                fixedContentPos : false,
                closeBtnInside  : true,
                tClose          : '',
                closeMarkup     : '<div class="mfp-close electron-panel-close-button panel-close"></div>',
                tLoading        : '<span class="loading-wrapper"><span class="ajax-loading"></span></span>',
                type            : 'ajax',
                ajax            : {
                    settings : {
                        type : 'GET',
                        data : {
                            action : 'electron_ajax_quick_shop'
                        }
                    }
                },
                callbacks       : {
                    beforeOpen  : function() {},
                    open        : function() {
                        $('.mfp-preloader').addClass('loading');
                    },
                    ajaxContentAdded: function() {

                        $('.mfp-preloader').removeClass('loading');

                        var variations_form = $('.electron-quickshop-form-wrapper').find('form.cart');
                        var termsWrapper    = $('.electron-quickshop-form-wrapper').find('.electron-selected-variations-terms-wrapper');
                        var $mainPrice      = $('.electron-quickshop-form-wrapper .electron-price>.price');
                        var $mainPriceHml   = $mainPrice.html();
                        var $mainStock      = $('.electron-quickshop-form-wrapper .electron-price>.electron-stock-status');
                        var $mainStockHml   = $mainStock.html();

                        variations_form.wc_variation_form();

                        $('.electron-quickshop-form-wrapper .electron-variations .electron-small-title').sameSize(true);

                        $(variations_form).on('show_variation', function( event, data ){
                            $('.electron-quickshop-form-wrapper').find('.electron-btn-reset-wrapper,.single_variation_wrap').addClass('active');

                            var $price = $(event.target).closest('.electron-quickshop-wrapper').find('.electron-price>.price,.electron-summary-item.electron-price');
                            // product price
                            if ( $price.length ) {
                                if ( data.price_html ) {
                                    $price.html( data.price_html );
                                }
                            }

                            var $stock = $(event.target).closest('.electron-quickshop-wrapper').find('.electron-price>.electron-stock-status');
                            // product stock
                            if ( $stock.length ) {
                                if ( data.availability_html != '' ) {
                                    var stcokhtml = $(data.availability_html).html();
                                    $stock.html( stcokhtml );
                                }
                            }
                        });

                        $(variations_form).on('hide_variation', function(){
                            $('.electron-quickshop-form-wrapper').find('.electron-btn-reset-wrapper,.single_variation_wrap').removeClass('active');
                            $mainPrice.html($mainPriceHml);
                            $mainStock.html($mainStockHml);
                        });

                        $('a.reset_variations').on('click', function(){
                            termsWrapper.slideUp();
                        });

                        if ( $('.grouped_form').length>0 || $(variations_form).length>0 ) {
                            $(document.body).trigger('electron_on_qtybtn');
                        }

                        if ( $('.electron-selected-variations-terms-wrapper').length > 0 ) {
                            $(variations_form).on('change', function() {
                                var $this = $(this);
                                var selectedterms = '';
                                $this.find('.electron-variations-items select').each(function(){
                                    var title = $(this).parents('.electron-variations-items').find('.electron-small-title').text();
                                    var val   = $(this).val();
                                    var name  = $(this).find('option[value="'+val+'"]').html();
                                    if (val) {
                                        selectedterms += '<span class="selected-features"><span class="selected-label">'+title+': </span><span class="selected-value">'+name+'</span></span>';
                                    }
                                });
                                if (selectedterms){
                                    termsWrapper.slideDown().find('.electron-selected-variations-terms').html(selectedterms);
                                }
                            });
                        }

                        $('.electron-variations .electron-small-title').sameSize(true);
                        $('.electron-product-info-top .electron-quickshop-notices').remove();
                        $('.electron-product-info-top .electron-quickshop-buttons-wrapper').remove();
                        $('.electron-quickshop-notices').appendTo('.electron-quickshop-wrapper .electron-product-info-top');
                        $('.electron-quickshop-buttons-wrapper').appendTo('.electron-quickshop-wrapper .electron-product-info-top');
                        $('.single_add_to_cart_button .woobt-count').appendTo('.single_add_to_cart_button .cart-text');

                        $('.electron-quickshop-form-wrapper form.cart').submit(function(e) {

                            if ( $(e.originalEvent.submitter).hasClass('electron-btn-buynow') ) {
                                return;
                            }

                            e.preventDefault();

                            var form = $(this),
                                btn  = form.find('.electron-btn.single_add_to_cart_button'),
                                data = new FormData(form[0]),
                                val  = form.find('[name=add-to-cart]').val();

                            data.append('add-to-cart',val);

                            btn.addClass('loading');

                            $.ajax({
                                url         : electron_vars.wc_ajax_url.toString().replace( '%%endpoint%%', 'electron_ajax_add_to_cart' ),
                                data        : data,
                                type        : 'POST',
                                processData : false,
                                contentType : false,
                                dataType    : 'json',
                                success     : function( response ) {

                                    btn.removeClass('loading');

                                    if ( ! response ) {
                                        return;
                                    }

                                    var fragments = response.fragments;

                                    $('.electron-quickshop-notices').html(fragments.notices).slideDown();

                                    // update other areas
                                    $('.minicart-panel').replaceWith(fragments.minicart);
                                    $('.electron-cart-count').html(fragments.count);
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

                                    if ( response.error && response.product_url ) {
                                        window.location = response.product_url;
                                        return;
                                    }

                                    $('.electron-quickshop-notices .close-error').on('click touch', function(e) {
                                        $('.electron-quickshop-notices').slideUp();
                                    });

                                    $('.electron-quickshop-wrapper .electron-btn-reset,.electron-quickshop-wrapper .plus,.electron-quickshop-wrapper .minus').on('click touch', function(event) {
                                        $('.electron-quickshop-notices').slideUp();
                                    });

                                    $('.electron-quickshop-buttons-wrapper').slideDown().addClass('active');

                                    $('.electron-quickshop-buttons-wrapper .electron-btn').on('click touch', function(e) {
                                        if ( $(this).hasClass('open-cart-panel') ) {
                                            $('html,body').addClass('electron-overlay-open');
                                            $('.electron-side-panel .active').removeClass('active');
                                            $('.electron-side-panel').addClass('active');
                                            $('.cart-area').addClass('active');
                                        }
                                        $.magnificPopup.close();
                                    });
                                }
                            });
                        });

                        $('body').on('click', '.electron-btn-buynow', function() {
                            if ($(this).parents('form.cart').length) {
                                return;
                            }
                            $('form.cart').find('.electron-btn-buynow').trigger('click');
                        });
                    },
                    beforeClose : function() {},
                    close : function() {},
                    afterClose : function() {}
                }
            });
        });
    }
    // quick shop end
});
