(function($) {

    var $doc  = $(document),
        $win  = $(window),
        $body = $('body'),
        links = '.electron-shop-fast-filters.is-shop.is-ajax .electron-fast-filters-list li a,.woocommerce .widget_rating_filter ul li a, .widget_product_categories a, .woocommerce-widget-layered-nav a, body.post-type-archive-product:not(.woocommerce-account) .electron-woocommerce-pagination.ajax-pagination a, body.tax-product_cat:not(.woocommerce-account) .electron-woocommerce-pagination a, .woocommerce-widget-layered-nav-list a, .top-action a, .electron-choosen-filters a, .widget_product_tag_cloud a, .electron-shop-filter-area li:not(.active) a, .electron-woo-breadcrumb .breadcrumb li a, .shop-slider-categories .slick-slide a, .electron-remove-filter a, .electron-product-status a, .electron-widget-product-categories a,.electron-shop-hero .electron-wc-category-list.type-filter li a, .electron-shop-hero .electron-category-slide-item.type-filter a, .shop-cat-banner-template-wrapper .electron-banner-link,.electron-products-column .electron-cat-item a,.shop-area .coupons>li>a:not(.applied),.discount_filter a:not(.checked),a.form-clear';

    function scrollToTop($target) {
        if ( $($target).length ) {
            var adminBarHeight = $body.hasClass('admin-bar') ? 46 + 140 : 140;
            setTimeout(function(){
                $('html, body').stop().animate({
                    scrollTop: $($target).offset().top - adminBarHeight
                }, 800);
            }, 800 );

        }
    }

    function sortOrder() {
        var $order = $('.woocommerce-ordering');

        $order.on('change', 'select.orderby', function() {
            var $form = $(this).closest('form');
            $form.find('[name="_pjax"]').remove();

            $.pjax({
                container: '.nt-shop-page',
                timeout  : 5000,
                url      : '?' + $form.serialize(),
                scrollTo : false,
                renderCallback: function(context, html, afterRender) {
                    electronBeforeRender(html);
                    $(context).replaceWith(html);
                    electronAfterRender();
                    $doc.trigger('electronShopInit');
                }
            });
        });

        $order.on('submit', function(e) {
            return false;
        });
    }

    function discountSelectFilter() {
        $('.ninetheme-discount-filter').on('change', 'select', function() {
            var $form = $(this).closest('form');
            if ($form.serialize() == 'discount_filter=') {
                const url = new URL(window.location.href);
                url.searchParams.delete('discount_filter');
                $.pjax({
                    container: '.nt-shop-page',
                    timeout  : 5000,
                    url      : url,
                    scrollTo : false,
                    renderCallback: function(context, html, afterRender) {
                        electronBeforeRender(html);
                        $(context).replaceWith(html);
                        electronAfterRender();
                        $doc.trigger('electronShopInit');
                    }
                });
            } else {
                $.pjax({
                    container: '.nt-shop-page',
                    timeout  : 5000,
                    url      : '?' + $form.serialize(),
                    scrollTo : false,
                    renderCallback: function(context, html, afterRender) {
                        electronBeforeRender(html);
                        $(context).replaceWith(html);
                        electronAfterRender();
                        $doc.trigger('electronShopInit');
                    }
                });
            }
        });
    }

    function sortOrder2() {
        var $order2 = $('form.woocommerce-widget-layered-nav-dropdown');

        $order2.on('change', 'select.woocommerce-widget-layered-nav-dropdown', function() {
            var $form = $(this).closest('form');
            $form.find('[name="_pjax"]').remove();

            $.pjax({
                container: '.nt-shop-page',
                timeout  : 5000,
                url      : '?' + $form.serialize(),
                scrollTo : false,
                renderCallback: function(context, html, afterRender) {
                    $(context).replaceWith(html);
                    electronAfterRender();
                    $doc.trigger('electronShopInit');
                }
            });
        });

        $order2.on('submit', function(e) {
            return false;
        });
    }

    function sortOrder3() {
        var $order3 = $('form.woocommerce-widget-layered-nav-dropdown');

        $order3.on('change', 'select.woocommerce-widget-layered-nav-dropdown', function() {
            var $form = $(this).closest('form');
            $form.find('[name="_pjax"]').remove();

            $.pjax({
                container: '.nt-shop-page',
                timeout  : 5000,
                url      : '?' + $form.serialize(),
                scrollTo : false,
                renderCallback: function(context, html, afterRender) {
                    electronBeforeRender(html);
                    $(context).replaceWith(html);
                    electronAfterRender();
                    $doc.trigger('electronShopInit');
                }
            });
        });

        $order3.on('submit', function(e) {
            return false;
        });
    }

    function layeredNav() {
        $('form.electron-multiselect .electron-select2').each(function () {
            var self = $(this);
            var placeholder = self.data('placeholder');
            var search = self.data('search') === "true" ? null : Infinity;
            var searchPlaceholder = self.data('searchplaceholder');
            self.select2({
              placeholder: placeholder,
              allowClear: true,
              minimumResultsForSearch: search,
              searchInputPlaceholder: searchPlaceholder
            });
        });

        $('form.electron-multiselect select').on('select2:select', function (e) {
            $('form.electron-multiselect .filter-submit').attr('data-disabled',"false");
        });

        $('form.electron-multiselect select').each(function() {
            if ( $(this).val() !== '') {
                $('form.electron-multiselect .filter-submit').attr('data-disabled',"false");
                return false;
            }
        });

        var allEmpty = true;
        $('form.electron-multiselect select').each(function() {
            if ($(this).val() !== '') {
                allEmpty = false;
                return false;
            }
        });

        $doc.on('change','form.electron-multiselect select', function(e) {

            var $form          = $(this).parents('form.electron-multiselect');
            var $formData      = $form.serializeArray();
            var combinedValues = {};
            var url            = window.location.href;
            var urlParts       = url.split("/");
            var currentParams  = new URLSearchParams(window.location.search);
            var paged          = false;

            $form.parent().addClass('ajax-loading');

            for (var i = 0; i < urlParts.length; i++) {
                if (urlParts[i] === "page") {
                    paged = true;
                    break;
                }
            }

            $formData.forEach(function (item) {
                var name  = item.name;
                var value = item.value;

                if ( value.trim() !== '' ) {
                    if (combinedValues.hasOwnProperty(name)) {
                        combinedValues[name].push(value);
                    } else {
                        combinedValues[name] = [value];
                    }
                }
            });

            for (var key in combinedValues) {
                combinedValues[key] = combinedValues[key];
            }

            var queryString = Object.keys(combinedValues).map(function (key) {
                return key + '=' + combinedValues[key];
            }).join('&');

            if ( queryString ) {

                if (currentParams.has('layout')) {
                    var layoutValue = currentParams.get('layout');
                    queryString += '&layout='+layoutValue;
                }

                if (currentParams.has('discount_filter')) {
                    var discountValue = currentParams.get('discount_filter');
                    if (discountValue) {
                        queryString += '&discount_filter='+discountValue;
                    }
                }

                if (currentParams.has('featured')) {
                    var featuredValue = currentParams.get('featured');
                    queryString += '&featured='+featuredValue;
                }


                if (currentParams.has('best_seller')) {
                    var bestSellerValue = currentParams.get('best_seller');
                    queryString += '&best_seller='+bestSellerValue;
                }

                if (currentParams.has('rating_filter')) {
                    var ratingFilterValue = currentParams.get('rating_filter');
                    queryString += '&rating_filter='+ratingFilterValue;
                }

                if (currentParams.has('on_sale')) {
                    var onSaleValue = currentParams.get('on_sale');
                    queryString += '&on_sale='+onSaleValue;
                }

                if (currentParams.has('stock_status')) {
                    var stockStatusValue = currentParams.get('stock_status');
                    queryString += '&stock_status='+stockStatusValue;
                }

                if (currentParams.has('min_price')) {
                    var minPriceValue = currentParams.get('min_price');
                    queryString += '&min_price='+minPriceValue;
                }

                if (currentParams.has('max_price')) {
                    var maxPriceValue = currentParams.get('max_price');
                    queryString += '&max_price='+maxPriceValue;
                }

                if (currentParams.has('product_style')) {
                    var productStyleValue = currentParams.get('product_style');
                    queryString += '&product_style='+productStyleValue;
                }

                if (currentParams.has('pagination')) {
                    var paginationValue = currentParams.get('pagination');
                    queryString += '&pagination='+paginationValue;
                }

                if (currentParams.has('perpage')) {
                    var perpageValue = currentParams.get('perpage');
                    queryString += '&perpage='+perpageValue;
                }

                if (currentParams.has('orderby')) {
                    var orderbyValue = currentParams.get('orderby');
                    queryString += '&orderby='+orderbyValue;
                }

                if (currentParams.has('column')) {
                    var shopviewValue = currentParams.get('column');
                    queryString += '&column='+shopviewValue;
                }

                if (currentParams.has('paged')) {
                    var pagedValue = currentParams.get('paged');
                    queryString += '&paged='+pagedValue;
                }

                if (currentParams.has('filter_cat')) {
                    var filtercatValue = currentParams.get('filter_cat');
                    queryString += '&filter_cat='+filtercatValue;
                }

                if (currentParams.has('s')) {
                    var filtercatValue = currentParams.get('s');
                    queryString += '&s='+filtercatValue;
                }

                if (currentParams.has('post_type')) {
                    var filtercatValue = currentParams.get('post_type');
                    queryString += '&post_type='+filtercatValue;
                }


                if ( paged ) {
                    var shopUrl = $('.form-clear').attr('href');
                    var newURL  = shopUrl + '?' + queryString;
                } else {
                    var newURL = url.split('?')[0] + '?' + queryString;
                }

                if ( url == newURL ) {
                    scrollToTop('.electron-products-wrapper');
                    return;
                }

                $.pjax({
                    container: '.nt-shop-page',
                    timeout  : 10000,
                    url      : newURL,
                    scrollTo : false,
                    renderCallback: function(context, html, afterRender) {
                        electronBeforeRender(html);
                        $(context).replaceWith(html);
                        electronAfterRender();
                        $doc.trigger('electronShopInit');
                    }
                });
            } else {
                $form.find('.filter-submit').attr('data-disabled',"true");
                $('.electron-widget a.btn.form-clear').removeClass('active');
            }

            return false;
        });
    }

    function priceSlider() {

        if ( $('body').hasClass('shop-layout-no-sidebar') || !$( '.price_slider' ).length > 0 ) {
            return;
        }

        $( document.body ).on( 'price_slider_create price_slider_slide', function( event, min, max ) {

            $( '.price_slider_amount span.from' ).html( accounting.formatMoney( min, {
                symbol:    woocommerce_price_slider_params.currency_format_symbol,
                decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
                thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
                precision: woocommerce_price_slider_params.currency_format_num_decimals,
                format:    woocommerce_price_slider_params.currency_format
            } ) );

            $( '.price_slider_amount span.to' ).html( accounting.formatMoney( max, {
                symbol:    woocommerce_price_slider_params.currency_format_symbol,
                decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
                thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
                precision: woocommerce_price_slider_params.currency_format_num_decimals,
                format:    woocommerce_price_slider_params.currency_format
            } ) );

            $( document.body ).trigger( 'price_slider_updated', [ min, max ] );

        });

        function initPriceFilter() {
            if ( $('body').hasClass('shop-layout-no-sidebar') || !$( '.price_slider' ).length > 0 ) {
                return;
            }
            $( 'input#min_price, input#max_price' ).hide();
            $( '.price_slider, .price_label' ).show();

            var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
                max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
                step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
                current_min_price = $( '.price_slider_amount #min_price' ).val(),
                current_max_price = $( '.price_slider_amount #max_price' ).val();

            $( '.price_slider:not(.ui-slider)' ).slider({
                range  : true,
                animate: true,
                min    : min_price,
                max    : max_price,
                step   : step,
                values : [ current_min_price, current_max_price ],
                create : function() {

                    $( '.price_slider_amount #min_price' ).val( current_min_price );
                    $( '.price_slider_amount #max_price' ).val( current_max_price );

                    $( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
                },
                slide: function( event, ui ) {

                    $( 'input#min_price' ).val( ui.values[0] );
                    $( 'input#max_price' ).val( ui.values[1] );

                    $( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
                },
                change: function( event, ui ) {

                    $( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
                }
            });
        }

        //initPriceFilter();

        //$( document.body ).on( 'init_price_filter', initPriceFilter );

        var hasSelectiveRefresh = (
            'undefined' !== typeof wp &&
            wp.customize &&
            wp.customize.selectiveRefresh &&
            wp.customize.widgetsPreview &&
            wp.customize.widgetsPreview.WidgetPartial
        );
        if ( hasSelectiveRefresh ) {
            wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
                //initPriceFilter();
            } );
        }

        var $min_price = $('.price_slider_amount #min_price');
        var $max_price = $('.price_slider_amount #max_price');
        var $products  = $('.shop-data-filters').data('shop-filters');

        if (typeof woocommerce_price_slider_params === 'undefined' || $min_price.length < 1 || !$.fn.slider) {
            return false;
        }

        var $slider = $('.price_slider');

        if ($slider.slider('instance') !== undefined) {
            return;
        }

        $('input#min_price, input#max_price').hide();
        $('.price_slider, .price_label').show();

        var min_price         = $min_price.data('min'),
            max_price         = $max_price.data('max'),
            current_min_price = parseInt(min_price, 10),
            current_max_price = parseInt(max_price, 10);

        if ( $products.min_price ) {
            current_min_price = parseInt($products.min_price, 10);
        }

        if ( $products.max_price ) {
            current_max_price = parseInt($products.max_price, 10);
        }

        $slider.slider({
            range  : true,
            animate: true,
            min    : min_price,
            max    : max_price,
            values : [
                current_min_price,
                current_max_price
            ],
            create : function() {
                $min_price.val(current_min_price);
                $max_price.val(current_max_price);

                $body.trigger('price_slider_create', [
                    current_min_price,
                    current_max_price
                ]);
            },
            slide  : function(event, ui) {
                $('input#min_price').val(ui.values[0]);
                $('input#max_price').val(ui.values[1]);

                $body.trigger('price_slider_slide', [
                    ui.values[0],
                    ui.values[1]
                ]);
            },
            change : function(event, ui) {
                $body.trigger('price_slider_change', [
                    ui.values[0],
                    ui.values[1]
                ]);
            }
        });

        setTimeout(function() {
            $body.trigger('price_slider_create', [
                current_min_price,
                current_max_price
            ]);

            if ($slider.find('.ui-slider-range').length > 1) {
                $slider.find('.ui-slider-range').first().remove();
            }
        }, 10);
    }

    function ajaxHandler() {

        $doc.pjax(links, '.nt-shop-page', {
            timeout       : 5000,
            scrollTo      : false,
            renderCallback: function(context, html, afterRender) {
                //console.log(context);
                electronBeforeRender(html);
                $(context).replaceWith(html);
                var fixedSidebar = $('.site-content .electron-shop-fixed-sidebar.site-main-sidebar');
                var sidebarPjax  = $('.electron-shop-fixed-sidebar.is_pjax').html();
                $('.electron-shop-fixed-sidebar.is_pjax').remove();
                $(fixedSidebar).html(sidebarPjax);

                var totalproduct = html.find('.electron-products .electron-loop-product').length;
                html.find('.electron-products').addClass('total-'+totalproduct);
                html.find('.electron-products>.product-category').each(function(){
                    $(this).appendTo('.electron-products-category-wrapper');
                    $(this).removeClass('electron-hidden');
                });
                afterRender();
                electronAfterRender();
                $doc.trigger('electronShopInit');
            }
        });

        $doc.on('submit', '.widget_price_filter form', function(event) {
            var $form = $(this);
            $form.find('[name="_pjax"]').remove();
            $.pjax({
                container: '.nt-shop-page',
                timeout  : 5000,
                url      : '?' + $form.serialize(),
                scrollTo : false,
                renderCallback: function(context, html, afterRender) {
                    electronBeforeRender(html);
                    $(context).replaceWith(html);
                    electronAfterRender();
                    $doc.trigger('electronShopInit');
                }
            });

            return false;
        });

        $doc.on('pjax:error', function(event, xhr, textStatus, error, options) {
            if (xhr.status === 404) {
                event.preventDefault();
                var currentUrl = window.location.href;
                var params = currentUrl.split("?")[1];
                var shopUrl = electron_vars.shop_url; // buraya shop url yi çek

                if (currentUrl.includes("?")) {
                    shopUrl += "?" + params;
                }
                window.location.href = shopUrl;
            }
            $('.nt-shop-page').removeClass('loading');
        });

        $doc.on('pjax:start', function() {
            $('.nt-shop-page').addClass('loading');
            scrollToTop('.shop-area');
        });

        $doc.on('pjax:complete', function() {
            $doc.trigger('electronShopInit');
        });

        $doc.on('pjax:end', function() {
            $('.nt-shop-page').removeClass('loading');
        });
    }

    function electronBeforeRender(html) {
        var totalproduct = html.find('.electron-products .electron-loop-product').length;
        html.find('.electron-products').addClass('total-'+totalproduct);

        html.find('.electron-products .product').each(function(index) {
            var delay = index * 0.1;
            var anim = $(this).data('product-animation');
            $(this).addClass('animated ' + anim).css('animation-delay', delay.toFixed(1) + 's');
        });

        var text = html.find('.nt-sidebar .discount_filter a.checked .name').text();
        if ('' != text) {
            $(html).find('.electron-remove-filter .discount_filter').html('<span class="remove-filter"></span>'+text);
        }

        var selectVal = html.find('.nt-sidebar select[name="discount_filter"] option[selected="selected"]').text();
        if ('' != selectVal) {
            $(html).find('.electron-remove-filter .discount_filter').html('<span class="remove-filter"></span>'+selectVal);
        }
    }

    function electronAfterRender() {
        sortOrder();
        sortOrder2();
        priceSlider();
        sortOrder3();
        layeredNav();
        discountSelectFilter();

        $('html,body').removeClass('has-overlay');

        $('.row-infinite').hide();

        $('form.woocommerce-widget-layered-nav-dropdown > select' ).each(function(){

            // Update value on change.
            $(this).on( 'change', function() {
                var slug = jQuery( this ).val();

                // get class name
                var classNames = jQuery( this ).attr("class").split(" ");
                var lastPart;

                $.each(classNames, function(index, name) {
                    if (name.startsWith("dropdown_layered_nav_")) {
                        lastPart = name.substring("dropdown_layered_nav_".length);
                        return false;
                    }
                });

                jQuery(':input[name="filter_'+lastPart+'"]').val( slug );

                // Submit form on change if standard dropdown.
                if ( ! jQuery( this ).attr( 'multiple' ) ) {
                    jQuery( this ).closest( 'form' ).trigger( 'submit' );
                }
            });
            // Use Select2 enhancement if possible
            if ( jQuery().selectWoo ) {
                var anyLabel = $(this).find('option').html();
                $(this).selectWoo( {
                    placeholder: ''+anyLabel+'',
                    minimumResultsForSearch: 5,
                    width: '100%',
                    allowClear: true
                });
            }
        });

        if ( $('.woocommerce-ordering select').length ) {
            $('.woocommerce-ordering select').niceSelect();
        }

        if ( $('.electron-swiper-slider') ) {
            $('.nt-shop-page .electron-swiper-slider').each(function () {
                const options = $(this).data('swiper-options');
                const mySlider = new NTSwiper(this, options);
            });
        }

        if ( $('.electron-slick-slider') ) {
            $('.nt-shop-page .electron-slick-slider').each(function () {
                $(this).not('.slick-initialized').slick();
            });
        }

        $('[data-label-color]').each( function() {
            var $this = $(this);
            var $color = $this.data('label-color');
            $this.css( {'background-color': $color,'border-color': $color } );
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
        $(document.body).trigger('electron_variations_init');

        $('.site-scroll li.cat-parent.checked').each(function () {
            //$(this).find('.subDropdown').trigger('click');
        });

        $('.site-scroll .cat-item.checked').each(function () {
            $(this).parents('.cat-parent').addClass('checked');
            $(this).parents('.cat-parent').find('>a.product_cat').addClass('checked');
            $(this).parents('.cat-parent').find('>.subDropdown').removeClass('plus').addClass('active minus');
            $(this).parent('.children').slideDown('slow');
        });

        $('.nt-sidebar-widget-body li.checked, .nt-sidebar-widget-body .chosen').each(function () {
            $(this).parents('.nt-sidebar-widget-body').prev('.nt-sidebar-inner-widget-title').addClass('active');
        });

        $('.nt-sidebar-widget-body a').on('click', function (e) {
            $(this).parents('.nt-sidebar-widget-body').prev().toggleClass('active');
        });

        $('.nt-sidebar-inner .woocommerce-widget-layered-nav-list__item.chosen a').each(function() {
            $(this).prepend('<span class="remove-filter"></span>');
        });

        $('[data-countdown]').each(function () {
            var $this     = $(this),
                data      = $this.data('countdown'),
                finalDate = data.date,
                hr        = data.hr,
                min       = data.min,
                sec       = data.sec;
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('<div class="time-count day"><span>%D</span>Day</div><div class="time-count hour"><span>%H</span>'+hr+'</div><div class="time-count min"><span>%M</span>'+min+'</div><div class="time-count sec"><span>%S</span>'+sec+'</div>'));
            });
        });
    }

    $doc.ready(function() {
        sortOrder();
        sortOrder2();
        ajaxHandler();
        sortOrder3();
        layeredNav();
        discountSelectFilter();

        var text = $('.nt-sidebar .discount_filter a.checked .name').text();
        if ('' != text) {
            $('.electron-remove-filter .discount_filter').html('<span class="remove-filter"></span>'+text);
        }
        var selectVal = $('.nt-sidebar select[name="discount_filter"] option[selected="selected"]').text();
        if ('' != selectVal) {
            $('.electron-remove-filter .discount_filter').html('<span class="remove-filter"></span>'+selectVal);
        }
    });

})(jQuery);
