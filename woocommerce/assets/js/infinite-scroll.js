jQuery(document).ready(function ($) {

    $(document).on('electronShopInit', function () {
        infinitescroll();
    });

    function infinitescroll() {
        $(window).data('ajaxready', true).scroll(function(e) {
            if ($(window).data('ajaxready') == false) return;
            var products_row = $('div.electron-products').offset().top + $('div.electron-products').outerHeight();
            var products_rowh = $('div.electron-products').outerHeight();
            if( $(window).scrollTop() >= ( products_row - window.innerHeight ) - products_rowh ) {

                $(window).data('ajaxready', false);

                electron_infinite_pagination();

            }
        });
    }

    infinitescroll();

    function electron_infinite_pagination() {
        var obj = $('.shop-data-filters').data('shop-filters');
        var data = {
            cache      : false,
            action     : 'electron_shop_load_more',
            beforeSend : function() {
                if ( obj.current_page == obj.max_page ) {
                    $('.electron-load-more').addClass('no-more').text(obj.no_more);
                    setTimeout(function(){
                        $('.row-infinite').slideUp('slow');
                    }, 3000);
                } else {
                    $('.electron-load-more').addClass('loading');
                }
            },
            'ajaxurl'      : obj.ajaxurl,
            'current_page' : obj.current_page,
            'per_page'     : obj.per_page,
            'max_page'     : obj.max_page,
            'cat_id'       : obj.cat_id,
            'brand_id'     : obj.brand_id,
            'filter_cat'   : obj.filter_cat,
            'layered_nav'  : obj.layered_nav,
            'on_sale'      : obj.on_sale,
            'orderby'      : obj.orderby,
            'min_price'    : obj.min_price,
            'max_price'    : obj.max_price,
            'pstyle'       : obj.pstyle,
            'column'       : obj.column,
            'no_more'      : obj.no_more,
            'is_search'    : obj.is_search,
            'is_shop'      : obj.is_shop,
            'is_brand'     : obj.is_brand,
            'is_cat'       : obj.is_cat,
            'is_tag'       : obj.is_tag,
            's'            : obj.s
        };

        if ( obj.current_page == obj.max_page ) {
            $('.electron-load-more').addClass('no-more').text(obj.no_more);
            setTimeout(function(){
                $('.row-infinite').slideUp('slow');
            }, 3000);
            return;
        }

        $.post(obj.ajaxurl, data, function(response) {
            $('div.electron-products').append(response);

            $(document.body).trigger('electron_after_ajax');
            $(document.body).trigger('electron_quick_shop');
            $('body').trigger('electron_quick_init');
            $(document.body).trigger('electron_variations_init');

            if ( obj.current_page == obj.max_page ) {
                $('.electron-load-more').addClass('no-more').text(obj.no_more);
                setTimeout(function(){
                    $('.row-infinite').slideUp('slow');
                }, 3000);
                return false;
            }

            $(document.body).trigger('electron_masonry_init');

            var count = $('div.electron-products').find('.electron-loop-product').length;
            $('.woocommerce-result-count .count').html(parseFloat(count));

            obj.current_page++;

            if ( obj.current_page == obj.max_page ) {
                $('.electron-load-more').addClass('no-more').text(obj.no_more);
                setTimeout(function(){
                    $('.row-infinite').slideUp('slow');
                }, 3000);
                return false;
            }

            $(window).data('ajaxready', true);
        });

        return false;
    }
});
