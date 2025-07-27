jQuery(document).ready(function($) {
    "use strict";

    $(document).on('click', '.electron-load-more', function(event){

        event.preventDefault();
        var loading = $('.electron-load-more').data('title');
        var nomore  = $('.electron-load-more').data('nomore');
        var more    = $('.electron-load-more').text();
        var obj     = $('.shop-data-filters').data('shop-filters');

        var data = {
            cache      : false,
            action     : 'electron_shop_load_more',
            beforeSend : function() {
                if ( obj.current_page == obj.max_page ) {
                    $('.electron-load-more').html(nomore).removeClass('loading');
                    setTimeout(function(){
                        $('.electron-more').slideUp('slow');
                    }, 3000);
                } else {
                    $('.electron-load-more').html(loading).addClass('loading');
                }
            },
            'ajaxurl'      : obj.ajaxurl,
            'current_page' : obj.current_page,
            'max_page'     : obj.max_page,
            'per_page'     : obj.per_page,
            'layered_nav'  : obj.layered_nav,
            'cat_id'       : obj.cat_id,
            'brand_id'     : obj.brand_id,
            'filter_cat'   : obj.filter_cat,
            'filter_brand' : obj.filter_brand,
            'on_sale'      : obj.on_sale,
            'orderby'      : obj.orderby,
            'min_price'    : obj.min_price,
            'max_price'    : obj.max_price,
            'product_style': obj.product_style,
            'column'       : obj.column,
            'pstyle'       : obj.pstyle,
            'no_more'      : obj.no_more,
            'is_search'    : obj.is_search,
            'is_shop'      : obj.is_shop,
            'is_brand'     : obj.is_brand,
            'is_cat'       : obj.is_cat,
            'is_tag'       : obj.is_tag,
            's'            : obj.s
        };

        if ( obj.current_page == obj.max_page ) {
            $('.electron-load-more').html(nomore).removeClass('loading');
            setTimeout(function(){
                $('.electron-more').slideUp('slow');
            }, 3000);
            return;
        }
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(obj.ajaxurl, data, function(response) {

            $('div.electron-products').append(response);

            $(document.body).trigger('electron_after_ajax');
            $(document.body).trigger('electron_quick_shop');
            $('body').trigger('electron_quick_init');
            $(document.body).trigger('electron_variations_init');

            var count = $('div.electron-products').find('.electron-loop-product').length;
            $('.woocommerce-result-count .count').html(parseFloat(count));

            obj.current_page++;

            $('.electron-load-more').html(more).removeClass('loading');

            if ( obj.current_page == obj.max_page ) {
                $('.electron-load-more').html(nomore).removeClass('loading');
                setTimeout(function(){
                    $('.electron-more').slideUp('slow');
                }, 3000);
                return;
            }

        });
    });
});
