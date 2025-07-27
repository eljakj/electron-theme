'use strict';

var electron_ids = [],
    electron_products = [];
(function($) {

    jQuery(document).ready(function($) {
        $('.electron-quickview-btn').each(function() {
            var id = $(this).data('id');
            if (-1 === $.inArray(id, electron_ids)) {
                electron_ids.push(id);
                electron_products.push({src: electron_vars.ajax_url + '?product_id=' + id});
            }
        });
    });

    function electron_get_key(array, key, value) {
      for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
          return i;
        }
      }
      return -1;
    }

    jQuery(document).on('electronShopInit',function() {
        $('.electron-quickview-btn').each(function() {
            var id = $(this).data('id');
            if (-1 === $.inArray(id, electron_ids)) {
                electron_ids.push(id);
                electron_products.push({src: electron_vars.ajax_url + '?product_id=' + id});
            }
        });
        init(electron_products);
    });

    jQuery(document).on('electron_quick_init',function() {
        $('.electron-quickview-btn').each(function() {
            var id = $(this).data('id');
            if (-1 === $.inArray(id, electron_ids)) {
                electron_ids.push(id);
                electron_products.push({src: electron_vars.ajax_url + '?product_id=' + id});
            }
        });
        init(electron_products);
    });

    init(electron_products);

    function init(electron_products){

        $(document).on('click touch', '.electron-quickview-btn', function(event) {
            event.preventDefault();

            var $this = $(this),
                id    = $this.data('id');

            var index = electron_get_key(electron_products, 'src', electron_vars.ajax_url + '?product_id=' + id);

            $.magnificPopup.open({
                items           : electron_products,
                type            : 'ajax',
                mainClass       : 'mfp-electron-quickview electron-mfp-slide-bottom',
                removalDelay    : 160,
                overflowY       : 'scroll',
                fixedContentPos : true,
                closeBtnInside  :true,
                tClose          : '',
                closeMarkup     : '<div class="mfp-close panel-close"></div>',
                tLoading        : '<span class="loading-wrapper"><span class="ajax-loading"></span></span>',
                gallery         : {
                    tPrev: '',
                    tNext: '',
                    enabled: true
                },
                ajax: {
                    settings: {
                        type: 'GET',
                        data: {
                            action: 'electron_quickview'
                        }
                    }
                },
                callbacks: {
                    beforeOpen: function() {},
                    open: function() {
                        $('.mfp-preloader').addClass('loading');
                        $('html,body').addClass('popup-open');
                    },
                    ajaxContentAdded: function() {
                        $('.mfp-preloader').removeClass('loading');

                        var variations_form = $('.electron-quickview-wrapper').find('form.variations_form');
                        var termsWrapper    = $('.electron-quickview-wrapper').find('.electron-selected-variations-terms-wrapper');

                        variations_form.wc_variation_form();

                        $(variations_form).on('show_variation', function( event, data ){
                            $('.electron-quickview-wrapper').find('.electron-btn-reset-wrapper,.single_variation_wrap').addClass('active');
                        });

                        $(variations_form).on('hide_variation', function(){
                            $('.electron-quickview-wrapper').find('.electron-btn-reset-wrapper,.single_variation_wrap').removeClass('active');
                        });

                        $('.electron-quickview-wrapper a.reset_variations').on('click', function(){
                            termsWrapper.slideUp();
                        });

                        if ( $('.electron-quickview-wrapper .grouped_form').length>0 || $(variations_form).length>0 ) {
                            $(document.body).trigger('electron_on_qtybtn');
                        }

                        if ( $('.electron-quickview-wrapper .electron-selected-variations-terms-wrapper').length > 0 ) {
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

                        $('.electron-quickview-wrapper form.cart').submit(function(e) {

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
                                    $('.electron-quickview-notices').appendTo('.electron-product-info-top');
                                    var fragments = response.fragments;
                                    var appended  = '<div class="woocommerce-notices-wrapper electron-summary-item">'+fragments.notices+'</div>';

                                    $(appended).appendTo('.electron-quickview-notices').delay(5000).fadeOut(300, function(){
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

                                    $('.electron-quickview-wrapper .close-error').on('click touch', function(e) {
                                        $(this).parent().remove();
                                    });

                                    $('.electron-quickview-wrapper .electron-btn-reset,.electron-quickview-wrapper .plus,.electron-quickview-wrapper .minus').on('click touch', function(event) {
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
                            if ($(this).parents('form.cart').length) {
                                return;
                            }
                            $('form.cart').find('.electron-btn-buynow').trigger('click');
                        });

                        if ( $('.electron-quickview-main img').length > 1) {

                            $('.electron-quickview-main .swiper-slide img').each( function(){
                                var src = $(this).attr('src');
                                $('<div class="swiper-slide"><img src="'+src+'"/></div>').appendTo('.electron-quickview-thumbnails .electron-swiper-wrapper');
                            });

                            var galleryThumbs = new NTSwiper('.electron-quickview-thumbnails', {
                                loop                  : false,
                                speed                 : 1000,
                                spaceBetween          : 10,
                                slidesPerView         : 4,
                                autoHeight            : false,
                                watchSlidesVisibility : true,
                                wrapperClass          : "electron-swiper-wrapper",
                                grabCursor            : true,
                                navigation            : {
                                    nextEl: '.electron-quickview-main .electron-swiper-next',
                                    prevEl: '.electron-quickview-main .electron-swiper-prev'
                                }
                            });
                            var galleryTop = new NTSwiper('.electron-quickview-main', {
                                loop         : false,
                                speed        : 1000,
                                slidesPerView: 1,
                                spaceBetween : 0,
                                observer     : true,
                                rewind       : true,
                                wrapperClass : "electron-swiper-wrapper",
                                grabCursor   : true,
                                navigation   : {
                                    nextEl: '.electron-quickview-main .electron-swiper-next',
                                    prevEl: '.electron-quickview-main .electron-swiper-prev'
                                },
                                thumbs       : {
                                    swiper: galleryThumbs
                                }
                            });
                        }
                    },
                    close: function(){},
                    afterClose: function(){
						$('html,body').removeClass('popup-open');
                    }
                }
            },index);
        });
    }
})(jQuery);
