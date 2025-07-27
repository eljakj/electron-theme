jQuery(document).ready(function($) {

    /*-- Strict mode enabled --*/
    'use strict';

    var scrollOffset = $('.electron-header-default').height();

    if ( $('body').hasClass('admin-bar') ) {
        scrollOffset = scrollOffset + 32;
    }

    /**  scrollToTop */

    function scrollToTop(target,delay,timeout) {
        setTimeout(function(){
            $('html, body').stop().animate({
                scrollTop: target.offset().top - scrollOffset
            }, delay);
        }, timeout );
    }

    $('.woocommerce-message').hide();


    /***** shop sidebar *****/

    var scrollToTopSidebar = function() {
        var shopP = 30;

        if ( $('body').hasClass('admin-bar') ) {
            shopP = 32;
        }

        $('html, body').stop().animate({
            scrollTop: $('.shop-area').offset().top - shopP
        }, 400);
    };

    $(document.body).on('click','.electron-toggle-hidden-sidebar', function (e) {
        $('.electron-toggle-hidden-sidebar').toggleClass('active');
        $('.nt-sidebar').toggleClass('active').slideToggle();

        setTimeout(function(){
            scrollToTopSidebar();
        }, 100 );
    });

    $(document.body).on('click','.electron-fast-filters-list .electron-has-submenu>a', function (e) {
        var parent = $(this).parent();
        if ( parent.hasClass('active') ) {
            parent.removeClass('active').addClass("inactive");
        } else {
            parent.addClass("active").removeClass("inactive");
        }
    });

    electronWcProductCats();

    $(document).on('electronShopInit', function() {
        electronWcProductCats();
    });

    function electronWcProductCats() {
        $('.widget_electron_product_categories ul.children input[checked]').closest('li.cat-parent').addClass("current-cat");
    }

    $('.nt-sidebar ul.product-categories li.cat-parent> ul.children').each( function (e) {
        $(this).before('<span class="subDropdown"></span>');
        //$(this).slideUp();
    });

    $(document.body).on('click','.nt-sidebar ul li.cat-parent > .subDropdown', function (e) {
        e.preventDefault();
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active minus').addClass("plus");
            $(this).next('.children').slideUp('slow');
        } else {
            $(this).removeClass('plus').addClass("active minus");
            $(this).next('.children').slideDown('slow');
        }
    });

    $('.site-scroll .cat-item.checked').each(function () {
        $(this).parents('.cat-parent').addClass('checked');
        $(this).parents('.cat-parent').find('>a.product_cat').addClass('checked');
        $(this).parents('.cat-parent').find('>.subDropdown').removeClass('plus').addClass('active minus');
        $(this).parent('.children').slideDown('slow');
    });

    if ( typeof electron_vars !== 'undefined' && electron_vars ) {
        var colors = electron_vars.swatches;

        $('.woocommerce-widget-layered-nav-list li a').each(function () {
            var $this = $(this);
            var title = $this.html();
            for (var i in colors) {
                if ( title == i ) {
                    var is_white = color == '#fff' || color == '#FFF' || color == '#ffffff' || color == '#FFFFFF' ? 'is_white' : '';
                    var color = '<span class="electron-swatches-widget-color-item'+is_white+'" style="background-color: '+colors[i]+';"></span>';
                    $this.prepend(color);
                }
            }
        });
    }

    if ( $(window).width() < 992 ) {
        var columnSize = $('.electron-shop-hidden-top-sidebar').data('column');
        $('.electron-shop-hidden-top-sidebar').removeClass('d-none active').removeAttr('style');
        $('.electron-toggle-hidden-sidebar').removeClass('active');
        $('.electron-shop-hidden-top-sidebar:not(.d-none) .nt-sidebar-inner').removeClass(columnSize);
    }

    $(window).on('resize', function(){
        var columnSize = $('.electron-shop-hidden-top-sidebar').data('column');
        if ( $(window).width() >= 992 ) {
            if ( $('html,body').hasClass('has-overlay') ) {
                $('.electron-shop-hidden-top-sidebar').removeClass('active');
            }
            $('.electron-shop-hidden-top-sidebar').addClass('d-none');
            $('.electron-shop-hidden-top-sidebar .nt-sidebar-inner').addClass(columnSize);
        }
        if ( $(window).width() < 992 ) {
            $('.electron-shop-hidden-top-sidebar').removeClass('d-none active').removeAttr('style');
            $('.electron-toggle-hidden-sidebar').removeClass('active');
            $('.electron-shop-hidden-top-sidebar:not(.d-none) .nt-sidebar-inner').removeClass(columnSize);
        }
    });


    /***** go-back-btn browser history *****/

    $(document.body).on('click', '.electron-go-back-btn', function(e) {
        e.preventDefault();
        history.go(-1);
    });


    /***** cart shipping form show-hide start *****/

    $(document.body).on('click','.details-trigger', function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        if ( parent.hasClass('active') ) {
            parent.removeClass('active');
        } else {
            parent.addClass("active");
        }
    });


    /***** cart shipping calculator-button *****/

    $(document.body).on('click','a.electron-shipping-calculator-button', function (e) {
        e.preventDefault();
        var cartTotals = $('.electron-cart-totals'),
            form       = $('.shipping-calculator-form');

        if ( cartTotals.hasClass('active')) {
            cartTotals.removeClass('active');
            form.slideUp('slow');
        } else {
            cartTotals.addClass('active');
            form.slideDown('slow');
            setTimeout(function(){
                $('html, body').stop().animate({
                    scrollTop: cartTotals.offset().top - scrollOffset
                }, 400);
            }, 300 );
        }
    });


    /***** panel Cart Content Height start *****/

    panelCartContentHeight();
    function panelCartContentHeight() {
        if ( $('.electron-side-panel .cart-area').length ) {
            var cartPos          = $('.electron-side-panel .panel-content').position();
            var cartFooterHeight = $('.electron-side-panel .header-cart-footer').height();
            var cartMaxHeight    = cartPos.top + cartFooterHeight + 40;

            $('.electron-side-panel .cart-area .electron-scrollbar').css('max-height',cartMaxHeight);
        }
    }

    $(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function(){
        setTimeout( function(){
            panelCartContentHeight();
        },500)
    });


    /***** shop-popup-notices close trigger *****/

    $(document.body).on('click', '.electron-shop-popup-notices .close-error', function() {
        $(this).parent().remove();
    });


    /***** label-color *****/

    $('[data-label-color]').each( function() {
        var $this = $(this);
        var $color = $this.data('label-color');
        $this.css( {'background-color': $color,'border-color': $color } );
    });

    $(document.body).on('electron_after_ajax', function(){
        $('span[data-label-color]').each( function() {
            var $this  = $(this);
            var $color = $this.data('label-color');
            $this.css( {'background-color': $color,'border-color': $color } );
        });
    });


    /***** woocommerce-ordering *****/

    if ( $('.woocommerce-ordering select').length ) {
        $('.woocommerce-ordering select').niceSelect();
    }


    /***** sameSize for swtaches label *****/

    $('.electron-variations .electron-small-title').sameSize(true);


    /***** update swatches color filters *****/

    if ( typeof electron_vars !== 'undefined' && electron_vars ) {
        var colors = electron_vars.swatches;

        $('.woocommerce-widget-layered-nav-list li a').each(function () {
            var $this = $(this);
            var title = $this.html();
            for (var i in colors) {
                if ( title == i ) {
                    var is_white = color == '#fff' || color == '#FFF' || color == '#ffffff' || color == '#FFFFFF' ? 'is_white' : '';
                    var color = '<span class="electron-swatches-widget-color-item'+is_white+'" style="background-color: '+colors[i]+';"></span>';
                    $this.prepend(color);
                }
            }
        });

        $('.electron-fast-filters-submenu span[data-color]').each(function () {
            var $this    = $(this);
            var color    = $this.data('color');
            var is_white = color == '#fff' || color == '#FFF' || color == '#ffffff' || color == '#FFFFFF' ? 'is_white' : '';
            $this.css('background-color',color);
            if (is_white) {
                $this.addClass(is_white);
            }
        });
    }

    /***** my account page multisteps slider *****/

    if ( $('.electron-myaccount-steps-register').length>0 ) {
        var myAccountFormSteps = new NTSwiper('.electron-myaccount-steps-register', {
            loop          : false,
            speed         : 500,
            spaceBetween  : 0,
            autoHeight    : false,
            simulateTouch : false,
            observer      : true,
            observerChildren      : true,
            navigation    : {
                nextEl: '.electron-myaccount-steps-register .electron-myaccount-form-button-register',
                prevEl: '.electron-myaccount-steps-register .electron-myaccount-form-button-login'
            },
            on: {
                resize: function () {
                    var swiper = this;
                    swiper.update();
                }
            },
            effect: 'slide'
        });
    }


    /***** compare button fix *****/

    if ( $('#woosc-area').length> 0) {
        var woosc = $('#woosc-area').data('count');
        $('.electron-compare-count').html(woosc);
        $('.woosc-bar-item').each(function () {
            var $id = $(this).attr('data-id');
            $('.woosc-btn-icon-only[data-id="'+$id+'"]').addClass('woosc-added added');
        });
    }

    $(document.body).on('click', '.open-compare-panel', function(e){
        //e.preventDefault();
        $('#woosc-area').addClass('woosc-area-open-bar woosc-area-open-table');
        $('#woosc-area .woosc-table').addClass('woosc-table-open');
        $('#woosc-area .woosc-bar').addClass('woosc-bar-open');
    });

    $(document.body).on('woosc_change_count', function(){
        var woosc_count = $('#woosc-area').attr('data-count');
        $('.electron-compare-count').html(woosc_count);
    });


    /***** change sku *****/

    var $mainSkuHtml = $('.electron-sku-wrapper .sku'),
        $mainSku     = $mainSkuHtml.html();

    $('.electron-product-summary form.variations_form').on('show_variation', function( event, data ){
        $mainSkuHtml.html(data.sku);
        $('.electron-btn-reset-wrapper,.electron-product-info').addClass('active');
    });

    $('.electron-product-summary form.variations_form').on('hide_variation', function(){
        $mainSkuHtml.html($mainSku);
        $('.electron-btn-reset-wrapper,.electron-product-info').removeClass('active');
    });


    /***** shop mode both on taxonomy pages *****/

    $('.electron-products>.product-category').each(function(){
        $(this).appendTo('.electron-products-category-wrapper');
        $(this).removeClass('electron-hidden');
    });

    var totalproduct = $('.electron-products .electron-loop-product').length;
    $('.electron-products').addClass('total-'+totalproduct);

    /***** add margin bottom to product type 1 *****/

    $(document).on('electronShopInit', function () {
        productHover();
        productThumbs();
        sidebarFilterStar();
    });

    $(document.body).on('productHover', function () {
        productHover();
    });

    $(document).on('found_variation', function (e) {
        var $target = $(e.target).parents('.type-2');
        setTimeout(function(){
            var mar = $target.find('.product-footer').outerHeight();
            $target.find('.content-hidden').css({marginBottom: -mar});
        },150);
    });

    $(document).on('reset_data', function (e) {
        var $target = $(e.target).parents('.type-2');
        setTimeout(function(){
            var mar = $target.find('.product-footer').outerHeight();
            $target.find('.content-hidden').css({marginBottom: -mar});
        },200);
    });

    $(document.body).on('productThumbs', function () {
        productThumbs();
    });

    productHover();
    function productHover() {
        $('.type-2 .product-footer').each(function (e,i) {
            var mar = $(this).outerHeight();
            $(this).parents('.type-2').find('.content-hidden').css({marginBottom: -mar});
        });
    }

    $('.product-cart-wrapper').each(function (e,i) {
        var pad = $(this).outerHeight()+15;
        if ( jQuery(window).width() < 1100 ) {
            $(this).parents('.product-inner.vr-absolute').css({paddingBottom: pad,height: '100%'});
        } else {
            $(this).parents('.product-inner.vr-relative').css({paddingBottom: pad,height: '100%'});
        }

    });

    jQuery(window).resize(function(){
        $('.product-cart-wrapper').each(function (e,i) {
            var pad = $(this).outerHeight()+15;
            if ( jQuery(window).width() <= 1100 ) {
                $(this).parents('.product-inner.vr-absolute').css({paddingBottom: pad,height: '100%'});
            } else {
                $(this).parents('.product-inner.vr-relative').css({paddingBottom: pad,height: '100%'});
            }
        });
    });

    productThumbs();
    function productThumbs() {

        $('.has-thumbs .thumbs .dot:not(active)').each(function () {
            var $this    = $(this);
            var imgs     = $this.parents('.has-thumbs').find('.thumb-wrapper');
            var imgsLink = imgs.find('a.product-thumb img:first-child');
            var src      = $this.data('url');
            var count    = $this.data('img');
            
            imgsLink.after('<img data-img="'+count+'" data-imgsrc="'+src+'" class="hidden">');
        });

        $('.has-thumbs .thumbs .dot:not(active)').hover(
            function() {
                var $this    = $(this);
                var imgs     = $this.parents('.has-thumbs').find('.thumb-wrapper');
                var imgsLink = imgs.find('a.product-thumb img:first-child');
                var img      = imgs.find('img');
                var src      = $this.data('url');
                var count    = $this.data('img');
                var append   = $(imgs).find('img[data-img="'+count+'"]');
                $this.siblings().removeClass('active');
                $this.addClass('active');
                if (src) {
                    $(imgs).find('img').addClass('hidden').removeClass('active');

                    if (count == '1') {
                        imgsLink.addClass('active').removeClass('hidden');
                    } else {
                        if ( append.is('.added')) {
                            append.addClass('active').removeClass('hidden');
                        } else {
                            append.attr('src', append.data('imgsrc')).addClass('added active').removeClass('hidden');
                        }
                    }
                }
            }
        );
    }

    sidebarFilterStar();
    function sidebarFilterStar() {
        $('.widget_rating_filter .wc-layered-nav-rating a').each(function (e,i) {
            $(this).attr('rel','nofollow');
        });
    }

    $('.woocommerce-product-rating').addClass('electron-summary-item');

    if ($('body').hasClass('woocommerce-checkout') || $('body').hasClass('woocommerce-cart')) {
        $(document.body).on('click touch', '.electron-woocommerce-cart-form .product-remove', function(event) {
            $(this).addClass('loading');
        });
    }

    $('.electron-shop-filter-top-area .electron-block-right>div:last-child').addClass('last-child');

    $('.has-height-container.swiper-initialized').each(function(){
        var height = $(this).height();
        $(this).css('height',height);
    });

    jQuery(window).resize(function(){
        jQuery('.has-height-container.swiper-initialized').each(function(){
            jQuery(this).css('height','auto');
            var height2 = jQuery(this).height();
            jQuery(this).css({height:height2});
        });
    });

    if ( jQuery(window).width() < 992 && electron_vars.mobile_filter == 'yes' ) {
        var filterArea = jQuery('.electron-before-loop.electron-shop-filter-top-area').clone();
        filterArea.prependTo('.electron-header-mobile');
    }

    jQuery(window).on("scroll", function () {
        var bodyScroll = jQuery(window).scrollTop();
        var filterArea = jQuery('.electron-products-column .electron-before-loop.electron-shop-filter-top-area')
        var mobHeader  = jQuery('.electron-header-mobile');
        var mobFilter  = jQuery('.electron-header-mobile .electron-shop-filter-top-area');

        if ( mobFilter.length && jQuery(window).width() < 992 ) {
            var filterAreaPos = filterArea.offset(),
            topoffset = filterAreaPos.top-80;
            if ( bodyScroll > topoffset ) {
                mobHeader.addClass('mobile-filter-active');
            } else {
                mobHeader.removeClass('mobile-filter-active');
            }
        }
    });

    /* load more button pagination */
    if ($.support.pjax && $('.shop-loop-wrapper.pagination-loadmore').length>0) {

        var links_loadmore = '.shop-loop-wrapper.pagination-loadmore .shop-loadmore-wrapper a:not(.nomore)';
        var loadmoreClass  = 'electron-btn electron-btn-primary electron-solid electron-radius electron-btn-medium electron-load-more';
        var pageLink       = $('.electron-woocommerce-pagination.loadmore .page-numbers.current').parent().next().find('a');
        var pageLinkCloned = pageLink.clone();
        var pageLinkWapper = pageLink.closest('.shop-loop-wrapper').data('id');
        var maxPage        = $('.electron-woocommerce-pagination.loadmore .page-numbers.current');

        pageLinkCloned.text(electron_vars.load_title).addClass(loadmoreClass).attr('rel','nofollow noreferrer').appendTo('.shop-loop-wrapper[data-id="'+pageLinkWapper+'"] .shop-loadmore-wrapper');

        $(document).on('click',links_loadmore, function(event) {

            var $this   = $(this);
            var wrapper = $this.closest('.shop-loop-wrapper');
            var el      = wrapper.find('.electron-products');
            var elPag   = wrapper.find('.electron-woocommerce-pagination');
            var maxPag  = wrapper.find('.electron-woocommerce-pagination').data('max');
            var curPag  = wrapper.find('.electron-woocommerce-pagination').data('current');
            var elBtn   = wrapper.find('.shop-loadmore-wrapper a');
            var id      = wrapper.data('id');
            var pushurl = wrapper.data('pushurl');
            var title   = electron_vars.load_title;
            var loading = electron_vars.loading_title;
            var nomore  = electron_vars.nomore;

            if( maxPag == curPag ) {
                elBtn.addClass('nomore').attr('href','javascript:void(0)').text(nomore);
                return;
            }

            $this.addClass('loading').text(loading);

            if ( wrapper.hasClass('replace') ) {
                wrapper.addClass('loading');
            }

            $.pjax.click(event, {
                container      : '.shop-loop-wrapper[data-id="'+id+'"]',
                timeout        : 5000,
                push           : pushurl,
                renderCallback : function(context, html, afterRender) {

                    wrapper.removeClass('loading');

                    $(html).find('.product-category').remove();
                    var maxPag  = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-woocommerce-pagination').data('max');
                    var curPag  = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-woocommerce-pagination').data('current');
                    var product = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-loop-product');
                    var data    = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-products').html();
                    var data2   = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] >.woocommerce');
                    var pagin   = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-woocommerce-pagination');
                    var btnHref = $(html).find('.shop-loop-wrapper[data-id="'+id+'"] .electron-woocommerce-pagination .page-numbers.current').parent().next().find('a').attr('href');

                    if (product.length>0) {

                        elBtn.attr('href',btnHref).text(title).removeClass('loading');

                        if ( wrapper.hasClass('replace') ) {
                            wrapper.find('>.woocommerce').replaceWith(data2);
                        } else {
                            el.append(data);
                            elPag.replaceWith(pagin);
                        }

                        if ( parseFloat(maxPag) == parseFloat(curPag) ) {
                            elBtn.addClass('nomore').attr('href','javascript:void(0)').text(nomore);
                        }
                    }

                    $(document.body).trigger('electron_quick_shop');
                    $('body').trigger('electron_quick_init');
                    $(document.body).trigger('electron_variations_init');
                    $(document.body).trigger('productHover');
                    $(document.body).trigger('productThumbs');
                }
            });
        });
    }

    /* load more with pagination */
    if ($.support.pjax && $('.shop-loop-wrapper .electron-woocommerce-pagination.default').length>0) {

        var links_pagination = '.shop-loop-wrapper .electron-woocommerce-pagination.default a';
        $(document).on('click', links_pagination, function(event) {

            var $this   = $(this);
            var wapper  = $this.closest('.shop-loop-wrapper');
            var id      = wapper.data('id');

            wapper.addClass('loading');

            $.pjax.click(event, {
                container      : '.shop-loop-wrapper[data-id="'+id+'"]',
                push           : false,
                timeout        : 50000,
                maxCacheLength : false,
                renderCallback : function(context, html, afterRender) {

                    $(html).find('.product-category').remove();
                    var data = $(html).find('.shop-loop-wrapper[data-id="'+id+'"]');

                    wapper.replaceWith(data).removeClass('loading');

                    $(document.body).trigger('electron_quick_shop');
                    $('body').trigger('electron_quick_init');
                    $(document.body).trigger('electron_variations_init');
                    $(document.body).trigger('productHover');
                    $(document.body).trigger('productThumbs');
                }
            });
        });
    }

    /* load more with tab-menu and pagination */
    if ($.support.pjax && $('.electron-tab-wrapper').length>0) {

        var links_tabs_two = '.electron-tab-wrapper .electron-tab-menu:not(.custom-links) a,.electron-tab-wrapper .electron-woocommerce-pagination a';
        $(document).on('click', links_tabs_two, function(event) {

            var $this   = $(this);
            var wapper  = $this.closest('.electron-tab-wrapper');
            var id      = wapper.data('id');
            var el      = wapper.find('.electron-tab-products');
            var name    = $this.parents('.electron-woocommerce-pagination').length ? $this.parents('.electron-woocommerce-pagination').data('name') : $this.data('name');
            var pagCur  = $this.parents('.electron-woocommerce-pagination').length ? parseFloat($this.parents('.electron-woocommerce-pagination').find('.current').html()) : '';
            var swiperHeight = el.find('.electron-swiper-container').data('height');
            var num     = $this.html();
            var taxLink = $this.html();
            var options = wapper.data('swiper-options');

            el.addClass('loading');
            wapper.find('.electron-tab-header .active').removeClass('active');
            $this.addClass('active');

            if ( $this.hasClass('next') || $this.hasClass('prev') ) {
                num = $this.hasClass('next') ? pagCur + 1 : pagCur - 1;
            } else if ( $this.hasClass('tax-link') || $this.hasClass('fast-link') ) {
                num = $this.data('filter');
            }

            if ( $this.hasClass('page-numbers') ) {
                wapper.find('.filter-shop-all').addClass('active');
            }

            if ( $this.hasClass('page-numbers') && wapper.find('.electron-tab-products.theme-query[data-filter="pagination-'+num+'"]').length>0 ) {
                event.preventDefault();
                wapper.find('.electron-tab-products').removeClass('active loading');
                wapper.find('.electron-tab-products.theme-query[data-filter="pagination-'+num+'"]').addClass('active');
                wapper.find('.filter-shop-all').addClass('active');
                return;
            }

            if ( ( $this.hasClass('tax-link') || $this.hasClass('fast-link') ) && wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"]').length>0 ) {
                event.preventDefault();
                wapper.find('.electron-tab-products').removeClass('active loading');
                wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"]').addClass('active');
                return;
            }

            if ( $this.hasClass('filter-shop-all') && wapper.find('.electron-tab-products.theme-query[data-filter="pagination-1"]').length>0 ) {
                event.preventDefault();
                wapper.find('.electron-tab-products').removeClass('active loading');
                wapper.find('.electron-tab-products.theme-query[data-filter="pagination-1"]').addClass('active');
                return;
            }

            $.pjax.click(event, {
                container      : '.electron-tab-wrapper[data-id="'+id+'"]',
                push           : false,
                timeout        : 10000,
                renderCallback : function(context, html, afterRender) {
                    var data,product,pagin;

                    $(html).find('.product-category').remove();

                    if ( $(html).find('.electron-tab-wrapper[data-id="'+id+'"]').length>0 ) {

                        data    = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-products');
                        product = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-loop-product');
                        pagin   = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-woocommerce-pagination');

                    } else {

                        data    = $(html).find('.electron-products');
                        product = $(html).find('.electron-loop-product');
                        pagin   = $(html).find('.electron-woocommerce-pagination');
                    }

                    if ( $this.hasClass('page-numbers') ) {

                        if ( $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-tab-products.theme-query').length>0 ) {

                            data = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-tab-products.theme-query');
                            wapper.find('.electron-tab-products').removeClass('active loading');
                            wapper.find('.electron-tab-content').append(data);
                            data.attr('data-filter','pagination-'+num).addClass('active');

                            if ( wapper.hasClass('layout-slider') ) {

                                var mySliderC = wapper.find('.electron-tab-products[data-filter="pagination-'+num+'"] .electron-swiper-container.theme-query');
                                const mySlider = new NTSwiper(mySliderC[0],options);

                                mySliderC.css('height','auto');
                                var heightC = mySliderC.height();
                                mySliderC.css('height',heightC);
                            }

                        } else {
                            data = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-tab-products>.woocommerce>.electron-products').html();
                            pagin = $(html).find('.electron-tab-wrapper[data-id="'+id+'"] .electron-tab-products .electron-woocommerce-pagination').html();

                            if ( wapper.hasClass('layout-slider') ) {

                                var swiperWr  = '<div class="electron-tab-products theme-query active" data-filter="pagination-'+num+'">';
                                    swiperWr += '<div class="electron-swiper-container">';
                                    swiperWr += '<div class="electron-swiper-wrapper">'+data+'</div>';
                                    swiperWr += '<div class="electron-swiper-prev slide-prev-'+id+'"></div>';
                                    swiperWr += '<div class="electron-swiper-next slide-next-'+id+'"></div>';
                                    swiperWr += '</div>';
                                    swiperWr += '<nav class="electron-woocommerce-pagination">'+pagin+'</div>';
                                    swiperWr += '</div>';


                                wapper.find('.electron-tab-content').append(swiperWr);
                                wapper.find('.electron-tab-products').removeClass('active loading');
                                wapper.find('.electron-tab-products.theme-query[data-filter="pagination-'+num+'"]').addClass('active');

                                wapper.find('.electron-tab-products.theme-query[data-filter="pagination-'+num+'"] .electron-loop-product').each(function(){
                                    $(this).wrap('<div class="swiper-slide"></div>');
                                });

                                var mySliderC2 = wapper.find('.electron-tab-products.theme-query[data-filter="pagination-'+num+'"] .electron-swiper-container');
                                const mySlider = new NTSwiper(mySliderC2[0],options);

                                mySliderC2.css('height','auto');
                                var heightC2 = mySliderC2.height();
                                mySliderC2.css('height',heightC2);

                            }
                        }

                        $(document.body).trigger('electron_quick_shop');
                        $('body').trigger('electron_quick_init');
                        $(document.body).trigger('electron_variations_init');
                        $(document.body).trigger('productHover');
                        $(document.body).trigger('productThumbs');

                        if ( typeof electron !== 'undefined' && typeof electron.Swatches !== 'undefined' ) {
                            electron.Swatches.init();
                            wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"] .variations_form').each(function () {
                                $(this).wc_variation_form();
                            });
                        }

                        setTimeout(function(){
                            $('.electron-terms.electron-type-image .electron-term img').each(function(){
                                var imgSrc = $(this).data('src');
                                if (imgSrc) {
                                    $(this).attr('src',imgSrc);
                                }
                            });
                        },1000);

                    } else if ( $this.hasClass('tax-link') || $this.hasClass('fast-link') || $this.hasClass('filter-shop-all') ) {

                        data = $(html).find('.electron-products').html();

                        if ( $this.hasClass('filter-shop-all') ) {
                            num = 'pagination-1'
                        }

                        if ( wapper.hasClass('layout-slider') ) {
                            var swiperWr  = '<div class="electron-tab-products theme-query" data-filter="'+num+'">';
                                swiperWr += '<div class="electron-swiper-container">';
                                swiperWr += '<div class="electron-swiper-wrapper">'+data+'</div>';
                                swiperWr += '<div class="electron-swiper-prev slide-prev-'+id+'"></div>';
                                swiperWr += '<div class="electron-swiper-next slide-next-'+id+'"></div>';
                                swiperWr += '</div>';
                                swiperWr += '</div>';

                            wapper.find('.electron-tab-content').append(swiperWr);

                            $('.electron-tab-products.theme-query[data-filter="'+num+'"] .electron-loop-product').each(function(){
                                $(this).wrap('<div class="swiper-slide"></div>');
                            });

                            var mySliderC3 = wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"] .electron-swiper-container');
                            const mySlider = new NTSwiper(mySliderC3[0],options);

                            mySliderC3.css('height','auto');
                            var heightC3 = mySliderC3.height();
                            mySliderC3.css('height',heightC3);

                        } else {

                            var datan  = '<div class="electron-tab-products theme-query" data-filter="'+num+'">';
                                datan += '<div class="electron-products">'+data+'</div>';
                                datan += '</div>';
                            wapper.find('.electron-tab-content').append(datan);
                        }

                        wapper.find('.electron-tab-products').removeClass('active loading');
                        wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"]').addClass('active');

                        $(document.body).trigger('electron_quick_shop');
                        $('body').trigger('electron_quick_init');
                        $(document.body).trigger('electron_variations_init');
                        $(document.body).trigger('productHover');
                        $(document.body).trigger('productThumbs');

                        if ( typeof electron !== 'undefined' && typeof electron.Swatches !== 'undefined' ) {
                            electron.Swatches.init();
                            wapper.find('.electron-tab-products.theme-query[data-filter="'+num+'"] .variations_form').each(function () {
                                $(this).wc_variation_form();
                            });
                        }

                        setTimeout(function(){
                            $('.electron-terms.electron-type-image .electron-term img').each(function(){
                                var imgSrc = $(this).data('src');
                                if (imgSrc) {
                                    $(this).attr('src',imgSrc);
                                }
                            });
                        },1000);

                    } else {

                        if (product.length>0) {

                            if ( wapper.hasClass('layout-slider') ) {

                                var swiperWrapper = '<div class="electron-swiper-wrapper"></div>';
                                var sliderNav     = '<div class="electron-swiper-prev slide-prev-'+id+'"></div><div class="electron-swiper-next slide-next-'+id+'"></div>';
                                $(data).addClass('electron-swiper-container').find('.electron-loop-product').addClass('swiper-slide').wrapAll(swiperWrapper);

                                el.html(data).removeClass('loading');
                                if (wapper.hasClass('has-pagination')) {
                                    el.append(pagin);
                                }

                                $(sliderNav).appendTo('.electron-tab-wrapper[data-id="'+id+'"] .electron-swiper-container');
                                const mySlider     = new NTSwiper('.electron-tab-wrapper[data-id="'+id+'"] .electron-swiper-container',options);
                                var swiperHeight   = wapper.find('.electron-swiper-wrapper').height();
                                wapper.find('.electron-swiper-'+id).attr('data-height',swiperHeight);

                            } else {

                                el.html(data).removeClass('loading');
                                wapper.find('.electron-woocommerce-pagination').remove();
                                if (wapper.hasClass('has-pagination')) {
                                    el.append(pagin);
                                }
                            }
                            wapper.find('.electron-tab-header a[data-name="'+name+'"]').addClass('active').siblings().removeClass('active');

                            $(document.body).trigger('electron_quick_shop');
                            $('body').trigger('electron_quick_init');
                            $(document.body).trigger('electron_variations_init');
                            $(document.body).trigger('productHover');
                            $(document.body).trigger('productThumbs');

                            if ( typeof electron !== 'undefined' && typeof electron.Swatches !== 'undefined' ) {
                                electron.Swatches.init();
                                wapper.find('.electron-tab-products .variations_form').each(function () {
                                    $(this).wc_variation_form();
                                });
                            }

                            setTimeout(function(){
                                $('.electron-terms.electron-type-image .electron-term img').each(function(){
                                    var imgSrc = $(this).data('src');
                                    if (imgSrc) {
                                        $(this).attr('src',imgSrc);
                                    }
                                });
                            },1000);

                        } else {
                            el.removeClass('loading');
                        }
                    }
                }
            });
        });
    }

    /* load more with tab-menu and pagination */

    if ($.support.pjax && $('.electron-tab-taxonomy').length>0) {

        var links_tax = '.electron-tab-taxonomy .electron-woocommerce-pagination a,.electron-tab-taxonomy .electron-taxonomy-list a';
        $(document.body).on('click', links_tax, function(event) {

            var $this     = $(this);
            var wapper    = $this.closest('.electron-tab-taxonomy');
            var id        = wapper.data('id');
            var el        = wapper.find('.products-col-wrapper');
            var height    = el.find('.electron-swiper-container').data('height');
            var taxId     = $this.data('tax');
            var pageHref  = $this.attr('href');
            var current   = parseFloat($this.parents('.electron-woocommerce-pagination').data('current'));
            var pageRegex = /\/page\/(\d+)/;
            var match     = pageHref.match(pageRegex);

            $('html, body').stop().animate({
                scrollTop: $(el).offset().top - 100
            }, 800);

            if ( match && parseInt(match[1]) == 1 ) {
                event.preventDefault();
                el.find('.electron-swiper-container,.electron-woocommerce-pagination').removeClass('active');
                $this.parents('.slider-wrapper').find('.electron-swiper-container:first-child').addClass('active');
                $this.parents('.slider-wrapper').find('.electron-swiper-container.active').next('.electron-woocommerce-pagination').addClass('active');
                return false;
            } else {
                if ( $this.is('a.page-numbers') && el.find('.electron-swiper-container[data-href="'+pageHref+'"]').length>0 ) {
                    event.preventDefault();
                    el.find('.electron-swiper-container,.electron-woocommerce-pagination').removeClass('active');
                    el.find('.electron-swiper-container[data-href="'+pageHref+'"]').addClass('active');
                    el.find('.electron-swiper-container[data-href="'+pageHref+'"]').next('.electron-woocommerce-pagination').addClass('active');
                    return false;
                }
            }

            if ( $this.is('.taxonomy-link') && el.find('.electron-swiper-container[data-href="'+pageHref+'"]').length>0 ) {
                event.preventDefault();
                $this.parent().siblings().removeClass('active');
                $this.parent().addClass('active');
                el.find('.active').removeClass('active');
                el.find('.electron-swiper-container[data-href="'+pageHref+'"]').addClass('active');
                el.find('.electron-swiper-container[data-href="'+pageHref+'"]').next('.electron-woocommerce-pagination').addClass('active');
                return false;
            }

            el.addClass('loading');
            wapper.find('.electron-taxonomy-list .active').removeClass('active');
            $this.parent().addClass('active');

            $.pjax.click(event, {
                container      : '.electron-tab-taxonomy[data-id="'+id+'"]',
                push           : false,
                renderCallback : function(context, html, afterRender) {

                    var data,products,pagin;

                    $(html).find('.product-category').remove();

                    products = $(html).find('.electron-products');
                    pagin    = $(html).find('.electron-woocommerce-pagination');

                    if ( $this.is('a.page-numbers') ) {

                        $(products).find('.electron-loop-product').addClass('swiper-slide').wrapAll('<div class="electron-swiper-wrapper"></div>');
                        $(products).removeClass('electron-products products').addClass('electron-swiper-container nav-vertical-centered loaded active new-added');
                        $(products).attr('data-href',pageHref).attr('data-tax',taxId).wrap('<div class="slider-wrapper" data-tax="'+taxId+'"></div>');
                        products.addClass('loaded active new-added').appendTo($this.parents('.slider-wrapper'));

                        pagin.addClass('loaded active new-added').appendTo($this.parents('.slider-wrapper'));

                        el.removeClass('loading');

                        var options    = wapper.data('swiper-options');
                        const mySlider = new NTSwiper('.electron-tab-taxonomy[data-id="'+id+'"] .electron-swiper-container.new-added',options);

                        el.find('.electron-swiper-container:not(.new-added),.electron-woocommerce-pagination:not(.new-added)').removeClass('active');
                        el.find('.new-added').removeClass('new-added');

                        $(document.body).trigger('electron_quick_shop');
                        $('body').trigger('electron_quick_init');
                        $(document.body).trigger('electron_variations_init');
                        $(document.body).trigger('productHover');
                        $(document.body).trigger('productThumbs');

                    } else {

                        $('<div class="slider-wrapper" data-tax="'+taxId+'"></div>').appendTo(el);
                        $(products).find('.electron-loop-product').addClass('swiper-slide').wrapAll('<div class="electron-swiper-wrapper"></div>');
                        $(products).removeClass('electron-products products').addClass('electron-swiper-container nav-vertical-centered loaded active new-added');
                        $(products).attr('data-href',$this.attr('href')).appendTo('.slider-wrapper[data-tax="'+taxId+'"]');
                        products.addClass('loaded active new-added');

                        pagin.addClass('loaded active new-added').appendTo('.slider-wrapper[data-tax="'+taxId+'"]');

                        el.removeClass('loading');

                        var options    = wapper.data('swiper-options');
                        const mySlider = new NTSwiper('.electron-tab-taxonomy[data-id="'+id+'"] .electron-swiper-container.new-added',options);

                        el.find('.electron-swiper-container:not(.new-added),.electron-woocommerce-pagination:not(.new-added)').removeClass('active');
                        el.find('.new-added').removeClass('new-added');

                        $(document.body).trigger('electron_quick_shop');
                        $('body').trigger('electron_quick_init');
                        $(document.body).trigger('electron_variations_init');
                        $(document.body).trigger('productHover');
                        $(document.body).trigger('productThumbs');
                    }
                }
            });
        });
    }

    /* mobile tab menu filter trigger */
    $(document).on('click', '.fast-filters-trigger', function(event) {
        event.preventDefault();
        var $this  = $(this);

        if ($this.hasClass('active')) {
            $this.removeClass('active');
            $this.next().removeClass('active');
        } else {
            $this.addClass('active');
            $this.next().addClass('active');
        }
    });

    $('.top-action-btn.has-panel.account-action').hover(
        function() {
            $(this).addClass('active');
        },
        function() {
            $(this).removeClass('active');
        }
    );

    if ( electron_vars.is_account == 'no' ) {

        $('.electron-popup-account.multi-forms .form-heading').each(function(){
            $(this).appendTo('.multi-forms .account-steps');
        });

        $(document).on('click', '.electron-popup-account.multi-forms .form-heading', function(event) {
            var $this = $(this);
            var parent= $this.parents('.account-area').find('>.row');
            var step  = $this.data('step');
            var width = parent.find('div[data-step="'+step+'"]').width()+30;

            $this.siblings().removeClass('active');
            $this.addClass('active');
            parent.find('div:not([data-step="'+step+'"])').removeClass('active');
            parent.find('div[data-step="'+step+'"]').addClass('active');
            if (step == 'register' ) {
                parent.css('transform', 'translateX(-' + width + 'px)');
            } else {
                parent.css('transform', 'translateX(0px)');
            }
        });

        // Show password visibility hover icon on woocommerce forms
        $( '.electron-popup-account form .woocommerce-Input[type="password"]' ).wrap( '<span class="password-input-wrapper"></span>' );
        $( '.electron-popup-account .password-input-wrapper' ).append( '<span class="show-password-input"><i class="fa fa-regular fa-eye"></i><i class="fa fa-regular fa-eye-slash"></i></span>' );
    }

});
jQuery(window).on('load', function() {
    jQuery( '.woocommerce-form-login .password-input .show-password-input' ).append( '<i class="fa fa-regular fa-eye"></i><i class="fa fa-regular fa-eye-slash"></i>' );
});
