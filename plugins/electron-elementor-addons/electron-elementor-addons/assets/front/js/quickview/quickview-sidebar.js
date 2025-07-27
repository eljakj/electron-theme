jQuery(document).ready( function($) {

    $('<div class="electron-quickview-sidebar electron-scrollbar electron-spinner"></div>').appendTo('body');

    $(document.body).on('click touch', '.electron-quickview-btn', function(event) {
        event.preventDefault();

        var $this   = $(this),
            id      = $this.data('id'),
            quickId = $('.electron-quickview-sidebar').attr('data-id');
            data    = {
                cache      : false,
                action     : 'electron_quickview',
                product_id : id,
                beforeSend : function() {
                    $('html,body').addClass('quick-open has-overlay');
                    if ( $('.electron-quickview-sidebar').hasClass('loaded') ) {
                        $('.electron-quickview-sidebar').attr('data-id',id).removeClass('spinner').addClass('active loading');
                    } else {
                        $('.electron-quickview-sidebar').attr('data-id',id).addClass('active loading');
                    }
                }
            };

        if ( quickId == id ) {

            $('html,body').addClass('quick-open has-overlay');
            $('.electron-quickview-sidebar').addClass('active');
            $('.page-overlay').attr('data-target','.electron-quickview-sidebar');

        } else {

            $.post(electron_vars.ajax_url, data, function(response) {

                $('.electron-quickview-sidebar').html(response).removeClass('loading image-loading').addClass('loaded');

                $('.page-overlay').attr('data-target','.electron-quickview-sidebar');

                var variations_form = $('.electron-quickview-sidebar').find('form.variations_form');
                var termsWrapper    = $('.electron-quickview-sidebar').find('.electron-selected-variations-terms-wrapper');
                var $mainPrice      = $('.electron-quickview-sidebar .electron-summary-item.electron-price>.price');
                var $mainPriceHml   = $mainPrice.html();
                var $mainStock      = $('.electron-quickview-sidebar .electron-summary-item.electron-price>.electron-stock-status');
                var $mainStockHml   = $mainStock.html();
                var $mainSku        = $('.electron-quickview-sidebar .electron-summary-item .electron-sku-wrapper>.sku');
                var $mainSkuHml     = $mainSku.html();

                $(variations_form).wc_variation_form();

                if ( $('.electron-quickview-sidebar .grouped_form').length>0 || $(variations_form).length>0 ) {
                    $(document.body).trigger('electron_on_qtybtn');
                }

                $('a.reset_variations').on('click', function(){
                    termsWrapper.slideUp();
                });

                if ( $('.electron-quickview-sidebar .electron-selected-variations-terms-wrapper').length > 0 ) {
                    $(variations_form).on('change', function() {
                        var $this = $(this);
                        var selectedterms = '';
                        $this.find('.electron-variations-items select').each(function(){
                            var title = $(this).parents('.electron-variations-items').find('.electron-small-title').text();
                            var val   = $(this).val();
                            if (val) {
                                selectedterms += '<span class="selected-features"><span class="selected-label">'+title+': </span><span class="selected-value">'+val+'</span></span>';
                            }
                        });
                        if (selectedterms){
                            termsWrapper.slideDown().find('.electron-selected-variations-terms').html(selectedterms);
                        }
                    });
                }

                $('.electron-variations .electron-small-title').sameSize(true);

                $('.electron-quickview-sidebar form.cart').submit(function(e) {

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

                            var appended  = '<div class="woocommerce-notices-wrapper">'+fragments.notices+'</div>';

                            $(appended).appendTo('.electron-shop-popup-notices').delay(5000).fadeOut(300, function(){
                                $(this).remove();
                            });

                            // update other areas
                            $('.minicart-panel').replaceWith(fragments.minicart);
                            $('.electron-cart-count').html(fragments.count);
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

                            $('.electron-quickview-sidebar .close-error').on('click touch', function(e) {
                                $(this).parent().remove();
                            });

                            $('.electron-quickview-sidebar .electron-btn-reset,.electron-quickview-sidebar .plus,.electron-quickview-sidebar .minus').on('click touch', function(event) {
                                $('.electron-quickview-notices').slideUp();
                            });

                            if ( response.error && response.product_url ) {
                                window.location = response.product_url;
                                return;
                            }
                        }
                    });
                });

                $('body').on('click', '.electron-btn-buynow', function() {
                    if ( $(this).parents('form.cart').length ) {
                        return;
                    }
                    $('form.cart').find('.electron-btn-buynow').trigger('click');
                });

                if ( $('.quick-main img').length > 1) {

                    $('.quick-main .swiper-slide img').each( function(){
                        var src = $(this).attr('src');
                        $('<div class="swiper-slide"><img src="'+src+'"/></div>').appendTo('.quick-thumbs .electron-swiper-wrapper');
                    });

                    var galleryThumbs = new NTSwiper('.quick-thumbs', {
                        loop                  : false,
                        speed                 : 1000,
                        spaceBetween          : 10,
                        slidesPerView         : 5,
                        autoHeight            : false,
                        watchSlidesVisibility : true,
                        wrapperClass          : "electron-swiper-wrapper",
                        grabCursor            : true,
                        navigation            : {
                            nextEl: '.quick-main .electron-swiper-next',
                            prevEl: '.quick-main .electron-swiper-prev'
                        }
                    });

                    var galleryTop = new NTSwiper('.quick-main', {
                        loop         : false,
                        speed        : 1000,
                        slidesPerView: 1,
                        spaceBetween : 0,
                        observer     : true,
                        rewind       : true,
                        wrapperClass : "electron-swiper-wrapper",
                        grabCursor   : true,
                        navigation   : {
                            nextEl: '.quick-main .electron-swiper-next',
                            prevEl: '.quick-main .electron-swiper-prev'
                        },
                        thumbs       : {
                            swiper: galleryThumbs
                        }
                    });
                }
                var $gallery     = $('.quick-main'),
                    $mainImg     = $gallery.find('.electron-swiper-wrapper .swiper-slide:first-child'),
                    $oMainImg    = $mainImg.find('img'),
                    $oMainImgSrc = $oMainImg.attr('src');

                var $tgallery     = $('.quick-thumbs'),
                    $tmainImg     = $tgallery.find('.electron-swiper-wrapper .swiper-slide:first-child'),
                    $toMainImg    = $tmainImg.find('img'),
                    $toMainImgSrc = $toMainImg.attr('src');

                $(variations_form).on('show_variation', function( event, data ){
                    $('.electron-quickview-sidebar').find('.electron-btn-reset-wrapper,.single_variation_wrap').addClass('active');

                    var $price = $(event.target).closest('.electron-quickview-sidebar').find('.electron-summary-item.electron-price>.price');
                    // product price
                    if ( $mainPrice.length ) {
                        if ( data.price_html ) {
                            $($mainPrice).html( data.price_html );
                        }
                    }

                    if ( $mainSku.length ) {
                        if ( data.sku ) {
                            $($mainSku).html( data.sku );
                        }
                    }

                    var $stock = $(event.target).closest('.electron-quickview-sidebar').find('.electron-summary-item.electron-price>.electron-stock-status');
                    // product stock

                    if ( data.availability_html != '' ) {
                        var stcokhtml = data.availability_html;
                        if ( $stock.length>0 ) {
                            setTimeout( function() {
                                $($stock).replaceWith( stcokhtml );
                            }, 100 );
                        } else {
                            setTimeout( function() {
                                $(stcokhtml).appendTo( '.electron-quickview-sidebar .electron-summary-item.electron-price' );
                            }, 100 );
                        }
                    }

                    var src = data.image.src;

                    $oMainImg.attr('src',src);
                    $toMainImg.attr('src',src);

                    setTimeout( function() {
                        galleryTop.slideTo(0);
                        galleryThumbs.slideTo(0);
                    }, 100 );
                });

                $(variations_form).on('hide_variation', function(){
                    $('.electron-quickview-sidebar').find('.electron-btn-reset-wrapper,.single_variation_wrap').removeClass('active');
                    $('.electron-quickview-sidebar .electron-selected-variations-terms').html('');
                    $stock = $('.electron-quickview-sidebar .electron-summary-item.electron-price>.electron-stock-status');
                    $($mainPrice).html($mainPriceHml);
                    $($stock).replaceWith( $mainStock );
                    $($mainSku).html($mainSkuHml);
                    $oMainImg.attr('src',$oMainImgSrc);
                    $toMainImg.attr('src',$toMainImgSrc);
                    setTimeout( function() {
                        galleryTop.slideTo(0);
                        galleryThumbs.slideTo(0);
                    }, 100 );
                });

            });
        }
    });
});
