/*-----------------------------------------------------------------------------------

    Theme Name: electron
    Description: WordPress Theme
    Author: Ninetheme
    Author URI: https://ninetheme.com/
    Version: 1.0

-----------------------------------------------------------------------------------*/

//var wishlist_vars = {};
"use strict";

(function(window, document, $) {

    function set_Cookie(cname, cvalue, exdays) {
        var d = new Date();

        d.setTime(d.getTime() + (
            exdays * 24 * 60 * 60 * 1000
        ));

        var expires = 'expires=' + d.toUTCString();

        document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/';
    }

    function get_Cookie(cname) {
        var name = cname + '=';
        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];

            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return decodeURIComponent(c.substring(name.length, c.length));
            }
        }

        return '';
    }

    function getProducts() {
        var cookie = 'electron_products',
            cookie = compare_vars.user_id != '' ? 'electron_products_' + compare_vars.user_id : '';

        return get_Cookie( cookie ) != '' ? get_Cookie( cookie ) : '';
    }

    function addProduct( id ) {
        var cookie = 'electron_products',
            count,
            limit  = false,
            notice = compare_vars.notice,
            btn    = $('.electron-compare-btn[data-id="' + id + '"]');

        if ( compare_vars.user_id != '' ) {
            cookie = 'electron_products_' + compare_vars.user_id;
        }

        if ( get_Cookie( cookie ) != '' ) {
            var products = get_Cookie( cookie ).split(',');

            if ( products.length < compare_vars.limit ) {
                products = $.grep( products, function( value ) {
                    return value != id;
                });
                products.unshift( id );

                var products = products.join();

                set_Cookie( cookie, products, 7 );
            } else {
                limit = true;
                notice = notice.replace( '{max_limit}', compare_vars.limit );
            }

            count = products.length;

        } else {
            set_Cookie( cookie, id, 7 );
            count = 1;
        }

        if ( limit ) {
            alert( notice );
        } else {
            btn.addClass('added');
        }
    }

    function removeProduct( id ) {
        var cookie = 'electron_products',
            count  = 0,
            btn    = $('.electron-compare-btn[data-id="' + id + '"]'),
            cookie = compare_vars.user_id != '' ? 'electron_products_' + compare_vars.user_id : '';

        if ( cookie != '' ) {
            var products = get_Cookie( cookie ).split(',');

            products = $.grep( products, function( value ) {
                return value != id;
            });

            var products_str = products.join();

            set_Cookie( cookie, products_str, 7 );
            count = products.length;
        }

        btn.removeClass('added');
    }

    function get_count() {
        var products = getProducts(),
            count = 0;

        if ( products != '' ) {
            var arr = products.split(',');
                count = arr.length;
        }
        return count;
    }

    function change_count() {
        var count = get_count();
        $('[data-compare-count]').attr('data-compare-count', count );
        $('.electron-compare-count').html( count );
        compare_vars.count = count;
    }

    function showMessage(id,message, name) {
        var duration = electron_vars.duration;
        var title    = '<strong>'+name+'</strong>';
        var cookie   = cookie = compare_vars.user_id != '' ? 'electron_products_' + compare_vars.user_id : '';

        if ( message == 'inlist' ) {
            message = compare_vars.inlist.replace( '{name}', title );
            if ( compare_vars.page_url ) {
                window.location = compare_vars.page_url;
                return;
            }
        }

        if ( get_Cookie( cookie ) != '' ) {
            var products = get_Cookie( cookie ).split(',').length;
            if ( (products+1) > compare_vars.limit ) {
                return;
            }
        }

        if ( message == 'added' ) {
            message = compare_vars.added.replace( '{name}', title );
        }

        if ( message == 'removed' ) {
            message = compare_vars.removed.replace( '{name}', title );
        }

        $( '.electron-compare-btn[data-id="' + id + '"]').removeClass('loading');

        var appended = '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message">'+message+'</div></div>';

        $(appended).prependTo('.electron-shop-popup-notices').delay(duration).fadeOut(300, function(){
            $(this).remove();
        });
    }

    // add product to compare list
    $(document).on('click touch', '.electron-compare-btn', function(e) {
        var $this = $( this ),
            id    = $this.attr('data-id'),
            name  = $this.attr('data-name');

        if ( compare_vars.btn_action == 'message' ) {
            if ( $this.hasClass('added') ) {
                showMessage(id,'inlist', name);
                //addCompare( 'add', id );
            } else {
                showMessage(id,'added', name);
                addProduct( id );
                change_count();
            }
        } else {
            if ( $this.hasClass('added') ) {
                addCompare( 'add', id );
            } else {
                $this.addClass('added');
                addProduct( id );
                addCompare( 'add', id );
            }
        }

        if ( get_count() == '0' ) {
            $('.compare-area').removeClass('has-product');
        } else {
            $('.compare-area').addClass('has-product');
        }

        e.preventDefault();
    });

    // remove from compare list
    $(document).on('click touch', '.electron-compare-del-icon', function(e) {

        var id = $(this).attr('data-id');

        $('.electron-compare-item[data-id="' + id + '"]').remove();
        $( '.electron-compare-btn[data-id="' + id + '"]').removeClass('added');
        if ( get_count() < 4 ) {
            var src = $( '.electron-compare-items').data('placeholder');
            $( '.electron-compare-items .image[data-id="' + id + '"]').addClass('img-placeholder');
            $( '.electron-compare-items [data-id="' + id + '"]:not(.image)').addClass('td-placeholder').html('');
            $( '.electron-compare-items th[data-id="' + id + '"]').removeClass('td-placeholder').addClass('th-placeholder');
            $( '.electron-compare-items .td-placeholder,.electron-compare-items .img-placeholder,.electron-compare-items .th-placeholder').each( function(){
                $(this).appendTo($(this).parent());
            });
            $( '.electron-compare-items [data-id="' + id + '"] img').attr('src',src);
        } else {
            $( '.electron-compare-items [data-id="' + id + '"]').remove();
        }

        removeProduct( id );

        change_count();

        $('.electron-compare-items').attr('data-count',get_count());

        if ( get_count() == '0' ) {
            $('.compare-area').removeClass('has-product');
            $('.electron-compare-items').addClass('no-product');
        } else {
            $('.compare-area').addClass('has-product');
        }

        e.preventDefault();
    });

    $(document.body).on('click touch','.electron-compare-popup-list .panel-close', function(){
        $('.electron-compare-popup-list').removeClass('loaded');
        $('body').removeClass('electron-overlay-open');
    });

    $(document.body).on('click touch','.open-compare-popup', function(){
        if ( $('.electron-compare-popup-list').length>0 ) {
            $('.electron-compare-popup-list').addClass('loaded');
            $('body').addClass('electron-overlay-open');
            $('.electron-header-mobile').removeClass('active');
        } else {
            $('body').append('<div class="electron-compare-popup-list loading"><span class="panel-close" data-target=".electron-compare-popup-list"></span><svg class="svgloading electron-big-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><path d="m26 9a1 1 0 0 0 0-2h-4a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-1.66a9 9 0 0 1 -7 14.66c-.3 0-.6 0-.9 0a1 1 0 1 0 -.2 2c.36 0 .73.05 1.1.05a11 11 0 0 0 8.48-18.05z"></path><path d="m10 19a1 1 0 0 0 -1 1v1.66a9 9 0 0 1 8.8-14.48 1 1 0 0 0 .4-2 10.8 10.8 0 0 0 -2.2-.18 11 11 0 0 0 -8.48 18h-1.52a1 1 0 0 0 0 2h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1z"></path></svg><div class="electron-compare-popup-list-inner nt-electron-content"></div></div>');
            var data = {
                action   : 'electron_load_compare_table',
                products : getProducts(),
                nonce    : compare_vars.nonce
            };

            $.post( compare_vars.ajaxurl, data, function( response ) {
                $('body').addClass('electron-overlay-open');
                $('.electron-compare-popup-list-inner').html( response );
                $('.electron-compare-popup-list').removeClass('loading').addClass('loaded');
                $('.electron-header-mobile').removeClass('active');
            });
        }
    });

    function addCompare( $action, id ) {
        if ( compare_vars.btn_action == 'message' ) {
            return;
        }
        if ( compare_vars.btn_action == 'popup' ) {
            if ( $('electron-compare-popup-list').length>0 ) {
                $('.electron-compare-popup-list').addClass('loading');
            } else {
                $('body').append('<div class="electron-compare-popup-list loading"><span class="panel-close" data-target=".electron-compare-popup-list"></span><svg class="svgloading electron-big-svg-icon" width="512" height="512" fill="currentColor" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><path d="m26 9a1 1 0 0 0 0-2h-4a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-1.66a9 9 0 0 1 -7 14.66c-.3 0-.6 0-.9 0a1 1 0 1 0 -.2 2c.36 0 .73.05 1.1.05a11 11 0 0 0 8.48-18.05z"></path><path d="m10 19a1 1 0 0 0 -1 1v1.66a9 9 0 0 1 8.8-14.48 1 1 0 0 0 .4-2 10.8 10.8 0 0 0 -2.2-.18 11 11 0 0 0 -8.48 18h-1.52a1 1 0 0 0 0 2h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1z"></path></svg><div class="electron-compare-popup-list-inner nt-electron-content"></div></div>');
            }
            var data = {
                action   : 'electron_load_compare_table',
                products : getProducts(),
                nonce    : compare_vars.nonce
            };

            $.post( compare_vars.ajaxurl, data, function( response ) {
                $('body').addClass('electron-overlay-open');
                $('.electron-compare-popup-list-inner').html( response );
                $('.electron-compare-popup-list').removeClass('loading').addClass('loaded');
                $( '.electron-compare-btn[data-id="'+id+'"]').removeClass('loading');
                change_count();
            });

        } else {
            var data = {
                action   : 'electron_add_compare',
                products : getProducts(),
                nonce    : compare_vars.nonce
            };

            $.post( compare_vars.ajaxurl, data, function( response ) {
                $( '.electron-compare-btn[data-id="'+id+'"]').removeClass('loading');
                change_count();
            });
        }
    }

    $( document ).ready( function( $ ) {
        $('.electron-compare-count').html( compare_vars.count );
    });

    if ( ( typeof compare_vars != 'undefined' ) && compare_vars.products ) {
        var ids = compare_vars.products;
        for (let i = 0; i < ids.length; i++) {
          $('.electron-compare-btn[data-id="'+ids[i]+'"]').addClass('added');
        }
    }

})(window, document, jQuery);
